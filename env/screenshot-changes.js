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
 * Row-based image alignment using chunk hashing and Longest Common Subsequence.
 *
 * Divides both images into horizontal strips ("chunks"), hashes each strip,
 * and uses LCS to find matching regions. This correctly handles content
 * insertions and removals at any position in the page — not just the top.
 */

// Minimum number of pixel rows per chunk.
const MIN_CHUNK_HEIGHT = 8;
// Maximum chunks per image, keeps the LCS O(m×n) table manageable.
const MAX_CHUNKS_PER_IMAGE = 2000;

/**
 * Compute a hash for each horizontal chunk of an image.
 */
function computeChunkHashes( imgData, width, height, chunkHeight ) {
	const chunks = [];
	for ( let y = 0; y < height; y += chunkHeight ) {
		const endY = Math.min( y + chunkHeight, height );
		let hash = 5381;
		for ( let row = y; row < endY; row++ ) {
			for ( let x = 0; x < width; x++ ) {
				const idx = ( row * width + x ) * 4;
				hash = ( ( hash << 5 ) + hash + imgData[ idx ] ) >>> 0;
				hash = ( ( hash << 5 ) + hash + imgData[ idx + 1 ] ) >>> 0;
				hash = ( ( hash << 5 ) + hash + imgData[ idx + 2 ] ) >>> 0;
			}
		}
		chunks.push( { hash, y, height: endY - y } );
	}
	return chunks;
}

/**
 * Find the Longest Common Subsequence of two chunk-hash sequences.
 *
 * @return {Array<{a: number, b: number}>} Pairs of matching indices.
 */
function findLCS( seqA, seqB ) {
	const m = seqA.length;
	const n = seqB.length;
	// Uint16Array is safe here because MAX_CHUNKS_PER_IMAGE (2000) < 65 535.
	const dp = Array.from( { length: m + 1 }, () => new Uint16Array( n + 1 ) );

	for ( let i = 1; i <= m; i++ ) {
		for ( let j = 1; j <= n; j++ ) {
			if ( seqA[ i - 1 ].hash === seqB[ j - 1 ].hash ) {
				dp[ i ][ j ] = dp[ i - 1 ][ j - 1 ] + 1;
			} else {
				dp[ i ][ j ] = Math.max( dp[ i - 1 ][ j ], dp[ i ][ j - 1 ] );
			}
		}
	}

	const matches = [];
	let i = m;
	let j = n;
	while ( i > 0 && j > 0 ) {
		if ( seqA[ i - 1 ].hash === seqB[ j - 1 ].hash ) {
			matches.unshift( { a: i - 1, b: j - 1 } );
			i--;
			j--;
		} else if ( dp[ i - 1 ][ j ] > dp[ i ][ j - 1 ] ) {
			i--;
		} else {
			j--;
		}
	}
	return matches;
}

/**
 * Copy a chunk of pixel rows from a source image into a destination buffer.
 */
function copyChunkData( srcImg, chunk, destBuffer, destWidth, destY ) {
	for ( let row = 0; row < chunk.height; row++ ) {
		const srcOffset = ( chunk.y + row ) * srcImg.width * 4;
		const dstOffset = ( destY + row ) * destWidth * 4;
		srcImg.data.copy( destBuffer, dstOffset, srcOffset, srcOffset + srcImg.width * 4 );
	}
}

/**
 * Align two images using row-based chunk hashing and LCS.
 *
 * Produces two same-height image buffers where matching content sits at
 * the same vertical position, with white padding for insertions/removals.
 */
function alignImages( beforeImg, afterImg ) {
	const width = Math.max( beforeImg.width, afterImg.width );
	const maxHeight = Math.max( beforeImg.height, afterImg.height );
	const chunkHeight = Math.max( MIN_CHUNK_HEIGHT, Math.ceil( maxHeight / MAX_CHUNKS_PER_IMAGE ) );

	const beforeChunks = computeChunkHashes( beforeImg.data, beforeImg.width, beforeImg.height, chunkHeight );
	const afterChunks = computeChunkHashes( afterImg.data, afterImg.width, afterImg.height, chunkHeight );

	const matches = findLCS( beforeChunks, afterChunks );

	// Build alignment: each slot pairs a before and/or after chunk index.
	// Between LCS matches, pair up unmatched before/after chunks so that
	// in-place modifications show as overlaid pixel diffs rather than
	// separate deletion + insertion regions.
	const alignment = [];
	let bi = 0;
	let ai = 0;

	function pushGap( gapBefore, gapAfter ) {
		const pairCount = Math.min( gapBefore.length, gapAfter.length );
		for ( let p = 0; p < pairCount; p++ ) {
			alignment.push( { before: gapBefore[ p ], after: gapAfter[ p ] } );
		}
		for ( let p = pairCount; p < gapBefore.length; p++ ) {
			alignment.push( { before: gapBefore[ p ], after: null } );
		}
		for ( let p = pairCount; p < gapAfter.length; p++ ) {
			alignment.push( { before: null, after: gapAfter[ p ] } );
		}
	}

	for ( const match of matches ) {
		const gapBefore = [];
		const gapAfter = [];
		while ( bi < match.a ) {
			gapBefore.push( bi++ );
		}
		while ( ai < match.b ) {
			gapAfter.push( ai++ );
		}
		pushGap( gapBefore, gapAfter );

		// Matched pair — unchanged region.
		alignment.push( { before: bi, after: ai } );
		bi++;
		ai++;
	}

	// Remaining unmatched tails.
	{
		const gapBefore = [];
		const gapAfter = [];
		while ( bi < beforeChunks.length ) {
			gapBefore.push( bi++ );
		}
		while ( ai < afterChunks.length ) {
			gapAfter.push( ai++ );
		}
		pushGap( gapBefore, gapAfter );
	}

	// Calculate total aligned height.
	let totalHeight = 0;
	for ( const slot of alignment ) {
		if ( slot.before !== null && slot.after !== null ) {
			totalHeight += Math.max(
				beforeChunks[ slot.before ].height,
				afterChunks[ slot.after ].height
			);
		} else if ( slot.before !== null ) {
			totalHeight += beforeChunks[ slot.before ].height;
		} else {
			totalHeight += afterChunks[ slot.after ].height;
		}
	}

	// Fill aligned buffers (white by default).
	const beforeData = Buffer.alloc( width * totalHeight * 4, 255 );
	const afterData = Buffer.alloc( width * totalHeight * 4, 255 );

	let outY = 0;
	for ( const slot of alignment ) {
		let h;
		if ( slot.before !== null && slot.after !== null ) {
			h = Math.max(
				beforeChunks[ slot.before ].height,
				afterChunks[ slot.after ].height
			);
		} else if ( slot.before !== null ) {
			h = beforeChunks[ slot.before ].height;
		} else {
			h = afterChunks[ slot.after ].height;
		}

		if ( slot.before !== null ) {
			copyChunkData( beforeImg, beforeChunks[ slot.before ], beforeData, width, outY );
		}
		if ( slot.after !== null ) {
			copyChunkData( afterImg, afterChunks[ slot.after ], afterData, width, outY );
		}

		outY += h;
	}

	return { beforeData, afterData, width, height: totalHeight };
}

function generateDiff( beforePath, afterPath, diffPath ) {
	const beforeImg = PNG.sync.read( fs.readFileSync( beforePath ) );
	const afterImg = PNG.sync.read( fs.readFileSync( afterPath ) );

	// Align images using row-based chunk matching so that insertions and
	// removals at any position are handled, not just a single top offset.
	const { beforeData, afterData, width, height } = alignImages( beforeImg, afterImg );

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
