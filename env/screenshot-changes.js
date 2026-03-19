#!/usr/bin/env node
/* eslint-disable no-console */
/**
 * External dependencies.
 */
const path = require( 'path' );
const fs = require( 'fs' );
const { execSync } = require( 'child_process' );
const puppeteer = require( 'puppeteer' );
const { PNG } = require( 'pngjs' );
const pixelmatch = require( 'pixelmatch' );

/**
 * Internal dependencies.
 */
const manifest = require( './page-manifest.json' );

const ARTIFACTS_PATH = path.resolve( process.env.GITHUB_WORKSPACE || '.', 'artifacts' );
const GITHUB_REPOSITORY = process.env.GITHUB_REPOSITORY || 'WordPress/wporg-main-2022';
const SCREENSHOTS_COMMIT = process.env.SCREENSHOTS_COMMIT || 'content-update-screenshots';

// node ./env/screenshot-changes.js [...files]
const [ , , ...files ] = process.argv;

async function getPageDetails( slug ) {
	const apiUrl = `https://wordpress.org/wp-json/wp/v2/pages?context=wporg_export&slug=${ slug }`;
	let post = false;
	try {
		const response = await fetch( apiUrl );
		[ post ] = await response.json();
		post.localLink = post.link.replace( 'https://wordpress.org/', 'http://localhost:8888/' );
	} catch ( error ) {
		console.error( error.message );
	}
	return post;
}

async function takeScreenshot( page, url, outputPath ) {
	await page.goto( url, { waitUntil: 'networkidle0' } );
	await page.evaluate( async () => {
		// eslint-disable-next-line no-undef
		const images = document.querySelectorAll( 'img[class*=wp-image]' );

		for ( let img = 0; img < images.length; img++ ) {
			images[ img ].scrollIntoView();
			await new Promise( ( r ) => setTimeout( r, 100 ) );
		}

		// Wait for all remaining lazy loading images to load
		await Promise.all(
			Array.from( images, ( image ) => {
				if ( image.complete ) {
					return;
				}

				return new Promise( ( resolve, reject ) => {
					image.addEventListener( 'load', resolve );
					image.addEventListener( 'error', reject );
				} );
			} )
		);
	} );
	await page.evaluate( async () => {
		// Pause all videos to prevent non-deterministic frames in screenshots.
		// eslint-disable-next-line no-undef
		document.querySelectorAll( 'video' ).forEach( ( v ) => {
			v.pause();
			v.currentTime = 0;
		} );
		// eslint-disable-next-line no-undef
		document.body.scrollIntoView( true );
	} );

	await page.waitForNetworkIdle();

	await page.screenshot( {
		path: outputPath,
		fullPage: true,
	} );
}

/**
 * Find the vertical offset that best aligns the before image within the taller
 * after image. Detects content insertion (e.g., new content added at the top).
 * Returns 0 if no insertion is detected or the images are the same height.
 */
function findInsertionOffset( beforeImg, afterImg ) {
	const heightDiff = afterImg.height - beforeImg.height;
	if ( heightDiff <= 0 ) {
		return 0;
	}

	// Sampling density for alignment scoring (columns × rows per offset check).
	const HORIZONTAL_SAMPLES = 20;
	const VERTICAL_SAMPLES = 50;
	// Number of evenly-spaced offsets to evaluate in the initial coarse scan.
	const COARSE_SCAN_DIVISIONS = 100;
	// The offset must reduce the alignment score by at least this factor to be accepted.
	const ALIGNMENT_IMPROVEMENT_THRESHOLD = 0.5;

	const width = Math.min( beforeImg.width, afterImg.width );
	const xStep = Math.max( 1, Math.floor( width / HORIZONTAL_SAMPLES ) );
	const compareHeight = beforeImg.height;
	const yStep = Math.max( 1, Math.floor( compareHeight / VERTICAL_SAMPLES ) );

	function scoreAtOffset( offset ) {
		let score = 0;
		for ( let y = 0; y < compareHeight; y += yStep ) {
			for ( let x = 0; x < width; x += xStep ) {
				const bIdx = ( y * beforeImg.width + x ) * 4;
				const aIdx = ( ( y + offset ) * afterImg.width + x ) * 4;
				score +=
					Math.abs( beforeImg.data[ bIdx ] - afterImg.data[ aIdx ] ) +
					Math.abs( beforeImg.data[ bIdx + 1 ] - afterImg.data[ aIdx + 1 ] ) +
					Math.abs( beforeImg.data[ bIdx + 2 ] - afterImg.data[ aIdx + 2 ] );
			}
		}
		return score;
	}

	const scoreAt0 = scoreAtOffset( 0 );
	let bestOffset = 0;
	let bestScore = scoreAt0;

	// Scan candidate offsets with adaptive step size, then refine.
	const coarseStep = Math.max( 1, Math.floor( heightDiff / COARSE_SCAN_DIVISIONS ) );
	for ( let offset = coarseStep; offset <= heightDiff; offset += coarseStep ) {
		const score = scoreAtOffset( offset );
		if ( score < bestScore ) {
			bestScore = score;
			bestOffset = offset;
		}
	}

	// Refine around the best offset found.
	if ( coarseStep > 1 && bestOffset > 0 ) {
		const lo = Math.max( 1, bestOffset - coarseStep );
		const hi = Math.min( heightDiff, bestOffset + coarseStep );
		for ( let offset = lo; offset <= hi; offset++ ) {
			const score = scoreAtOffset( offset );
			if ( score < bestScore ) {
				bestScore = score;
				bestOffset = offset;
			}
		}
	}

	// Only accept the offset if it significantly improves alignment.
	if ( bestOffset > 0 && bestScore < scoreAt0 * ALIGNMENT_IMPROVEMENT_THRESHOLD ) {
		return bestOffset;
	}

	return 0;
}

/**
 * Pad an image to a target size, filling extra space with white.
 * An optional topOffset shifts the image content down, adding white rows at the top.
 */
function padImageData( img, targetWidth, targetHeight, topOffset = 0 ) {
	if ( img.width === targetWidth && img.height === targetHeight && topOffset === 0 ) {
		return img.data;
	}
	const padded = Buffer.alloc( targetWidth * targetHeight * 4, 255 );
	for ( let y = 0; y < img.height; y++ ) {
		const destY = y + topOffset;
		if ( destY >= targetHeight ) {
			break;
		}
		const srcOffset = y * img.width * 4;
		const dstOffset = destY * targetWidth * 4;
		img.data.copy( padded, dstOffset, srcOffset, srcOffset + img.width * 4 );
	}
	return padded;
}

function generateDiff( beforePath, afterPath, diffPath ) {
	const beforeImg = PNG.sync.read( fs.readFileSync( beforePath ) );
	const afterImg = PNG.sync.read( fs.readFileSync( afterPath ) );

	const width = Math.max( beforeImg.width, afterImg.width );
	const height = Math.max( beforeImg.height, afterImg.height );

	// Detect content insertion by finding the best vertical alignment.
	const insertionOffset = findInsertionOffset( beforeImg, afterImg );

	// Pad the before image, shifting it down by the insertion offset so that
	// existing content aligns and only the truly new region shows as changed.
	const beforeData = padImageData( beforeImg, width, height, insertionOffset );
	const afterData = padImageData( afterImg, width, height );

	const diff = new PNG( { width, height } );
	const numDiffPixels = pixelmatch( beforeData, afterData, diff.data, width, height, {
		threshold: 0.1,
	} );

	fs.writeFileSync( diffPath, PNG.sync.write( diff ) );
	return numDiffPixels;
}

( async () => {
	const browser = await puppeteer.launch( { headless: true } );
	const page = await browser.newPage();

	await page.setViewport( {
		width: 1440,
		height: 800,
		deviceScaleFactor: 1,
	} );

	const afterDir = path.join( ARTIFACTS_PATH, 'after' );
	const beforeDir = path.join( ARTIFACTS_PATH, 'before' );
	const diffDir = path.join( ARTIFACTS_PATH, 'diff' );
	fs.mkdirSync( afterDir, { recursive: true } );
	fs.mkdirSync( beforeDir, { recursive: true } );
	fs.mkdirSync( diffDir, { recursive: true } );

	// Match changed files to manifest entries.
	const entries = [];
	for ( const file of files ) {
		const found = manifest.find(
			( entry ) => entry.pattern === path.basename( file ) || `${ entry.slug }.php` === path.basename( file )
		);
		if ( found ) {
			entries.push( { file, ...found } );
		}
	}

	// Step 1: Take "after" screenshots (current state has new patterns).
	for ( const entry of entries ) {
		const post = await getPageDetails( entry.slug );
		if ( ! post ) {
			continue;
		}
		console.log( `${ post.title.rendered } [${ post.link }]` );
		entry.post = post;
		await takeScreenshot( page, post.localLink, path.join( afterDir, `${ entry.slug }.png` ) );
	}

	// Step 2: Revert changed files to take "before" screenshots.
	const filesToRevert = entries.filter( ( e ) => e.post ).map( ( e ) => e.file );
	if ( filesToRevert.length > 0 ) {
		// Save new patterns to temp, revert to old, screenshot, then restore.
		const tmpDir = path.join( ARTIFACTS_PATH, '.tmp' );
		fs.mkdirSync( tmpDir, { recursive: true } );
		for ( const file of filesToRevert ) {
			fs.copyFileSync( file, path.join( tmpDir, path.basename( file ) ) );
		}

		execSync( `git checkout HEAD -- ${ filesToRevert.join( ' ' ) }`, { stdio: 'inherit' } );

		for ( const entry of entries ) {
			if ( ! entry.post ) {
				continue;
			}
			await takeScreenshot( page, entry.post.localLink, path.join( beforeDir, `${ entry.slug }.png` ) );
		}

		// Restore new patterns from temp.
		for ( const file of filesToRevert ) {
			fs.copyFileSync( path.join( tmpDir, path.basename( file ) ), file );
		}
		fs.rmSync( tmpDir, { recursive: true } );
	}

	// Step 4: Generate diffs and write markdown with side-by-side table.
	const baseUrl = `https://raw.githubusercontent.com/${ GITHUB_REPOSITORY }/${ SCREENSHOTS_COMMIT }`;
	let markdown = '';

	for ( const entry of entries ) {
		if ( ! entry.post ) {
			continue;
		}

		const afterFile = path.join( afterDir, `${ entry.slug }.png` );
		const beforeFile = path.join( beforeDir, `${ entry.slug }.png` );

		if ( ! fs.existsSync( beforeFile ) ) {
			markdown += `\n<details>\n<summary>${ entry.post.title.rendered }</summary>\n\n`;
			markdown += `![After](${ baseUrl }/after/${ entry.slug }.png)\n\n`;
			markdown += `</details>\n`;
			continue;
		}

		const diffPixels = generateDiff( beforeFile, afterFile, path.join( diffDir, `${ entry.slug }.png` ) );

		if ( diffPixels === 0 ) {
			markdown += `\n<details>\n<summary>${ entry.post.title.rendered } (no visual changes)</summary>\n\n`;
			markdown += `![After](${ baseUrl }/after/${ entry.slug }.png)\n\n`;
			markdown += `</details>\n`;
			continue;
		}

		markdown += `\n<details>\n<summary>${ entry.post.title.rendered } (${ diffPixels.toLocaleString() } pixels changed)</summary>\n\n`;
		markdown += `| Before | Changes | After |\n`;
		markdown += `| --- | --- | --- |\n`;
		markdown += `| ![Before](${ baseUrl }/before/${ entry.slug }.png) `;
		markdown += `| ![Changes](${ baseUrl }/diff/${ entry.slug }.png) `;
		markdown += `| ![After](${ baseUrl }/after/${ entry.slug }.png) |\n\n`;
		markdown += `</details>\n`;
	}

	fs.writeFileSync( path.join( ARTIFACTS_PATH, 'screenshots.md' ), markdown );

	await browser.close();
} )();
