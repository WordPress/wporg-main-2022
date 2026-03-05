#!/usr/bin/env node
/* eslint-disable no-console */
/**
 * External dependencies.
 */
const path = require( 'path' );
const fs = require( 'fs' );
const puppeteer = require( 'puppeteer' );
const { PNG } = require( 'pngjs' );
const pixelmatch = require( 'pixelmatch' );

/**
 * Internal dependencies.
 */
const manifest = require( './page-manifest.json' );

const ARTIFACTS_PATH = path.resolve( process.env.GITHUB_WORKSPACE || '.', 'artifacts' );
const GITHUB_REPOSITORY = process.env.GITHUB_REPOSITORY || 'WordPress/wporg-main-2022';
const SCREENSHOTS_BRANCH = 'content-update-screenshots';

const isBeforeMode = process.argv.includes( '--before' );
const files = process.argv.slice( 2 ).filter( ( f ) => f !== '--before' );

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
 * Pad an image to a target size, filling extra space with white.
 */
function padImageData( img, targetWidth, targetHeight ) {
	if ( img.width === targetWidth && img.height === targetHeight ) {
		return img.data;
	}
	const padded = Buffer.alloc( targetWidth * targetHeight * 4, 255 );
	for ( let y = 0; y < img.height; y++ ) {
		const srcOffset = y * img.width * 4;
		const dstOffset = y * targetWidth * 4;
		img.data.copy( padded, dstOffset, srcOffset, srcOffset + img.width * 4 );
	}
	return padded;
}

function generateDiff( beforePath, afterPath, diffPath ) {
	const beforeImg = PNG.sync.read( fs.readFileSync( beforePath ) );
	const afterImg = PNG.sync.read( fs.readFileSync( afterPath ) );

	const width = Math.max( beforeImg.width, afterImg.width );
	const height = Math.max( beforeImg.height, afterImg.height );

	const beforeData = padImageData( beforeImg, width, height );
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

	if ( isBeforeMode ) {
		const beforeDir = path.join( ARTIFACTS_PATH, 'before' );
		fs.mkdirSync( beforeDir, { recursive: true } );

		for ( let i = 0; i < manifest.length; i++ ) {
			const entry = manifest[ i ];
			const post = await getPageDetails( entry.slug );
			if ( ! post ) {
				continue;
			}
			console.error( `[before] ${ post.title.rendered }` );
			await takeScreenshot( page, post.localLink, path.join( beforeDir, `${ entry.slug }.png` ) );
		}
	} else {
		const afterDir = path.join( ARTIFACTS_PATH, 'after' );
		const diffDir = path.join( ARTIFACTS_PATH, 'diff' );
		fs.mkdirSync( afterDir, { recursive: true } );
		fs.mkdirSync( diffDir, { recursive: true } );

		const results = [];
		const usedSlugs = new Set();

		for ( let i = 0; i < files.length; i++ ) {
			const file = files[ i ];
			const found = manifest.find(
				( entry ) => entry.pattern === path.basename( file ) || `${ entry.slug }.php` === path.basename( file )
			);
			if ( ! found ) {
				continue;
			}

			const post = await getPageDetails( found.slug );
			if ( ! post ) {
				continue;
			}

			// Output changelist line (existing format).
			console.log( `${ post.title.rendered } [${ post.link }]` );

			const afterFile = path.join( afterDir, `${ found.slug }.png` );
			await takeScreenshot( page, post.localLink, afterFile );

			const beforeFile = path.join( ARTIFACTS_PATH, 'before', `${ found.slug }.png` );
			let diffPixels = -1;
			if ( fs.existsSync( beforeFile ) ) {
				diffPixels = generateDiff( beforeFile, afterFile, path.join( diffDir, `${ found.slug }.png` ) );
				usedSlugs.add( found.slug );
			}

			results.push( {
				title: post.title.rendered,
				link: post.link,
				slug: found.slug,
				hasBefore: fs.existsSync( beforeFile ),
				diffPixels,
			} );
		}

		// Clean up unused before screenshots to keep the commit small.
		const beforeDir = path.join( ARTIFACTS_PATH, 'before' );
		if ( fs.existsSync( beforeDir ) ) {
			for ( const file of fs.readdirSync( beforeDir ) ) {
				const slug = path.basename( file, '.png' );
				if ( ! usedSlugs.has( slug ) ) {
					fs.unlinkSync( path.join( beforeDir, file ) );
				}
			}
		}

		// Write screenshot markdown to a file for the PR body.
		const baseUrl = `https://raw.githubusercontent.com/${ GITHUB_REPOSITORY }/${ SCREENSHOTS_BRANCH }`;
		let markdown = '';

		for ( const r of results ) {
			if ( ! r.hasBefore ) {
				markdown += `\n<details>\n<summary>${ r.title }</summary>\n\n`;
				markdown += `![After](${ baseUrl }/after/${ r.slug }.png)\n\n`;
				markdown += `</details>\n`;
				continue;
			}

			if ( r.diffPixels === 0 ) {
				markdown += `\n<details>\n<summary>${ r.title } (no visual changes)</summary>\n\n`;
				markdown += `![After](${ baseUrl }/after/${ r.slug }.png)\n\n`;
				markdown += `</details>\n`;
				continue;
			}

			markdown += `\n<details>\n<summary>${ r.title } (${ r.diffPixels.toLocaleString() } pixels changed)</summary>\n\n`;
			markdown += `#### Diff\n![Diff](${ baseUrl }/diff/${ r.slug }.png)\n\n`;
			markdown += `#### Before\n![Before](${ baseUrl }/before/${ r.slug }.png)\n\n`;
			markdown += `#### After\n![After](${ baseUrl }/after/${ r.slug }.png)\n\n`;
			markdown += `</details>\n`;
		}

		fs.writeFileSync( path.join( ARTIFACTS_PATH, 'screenshots.md' ), markdown );
	}

	await browser.close();
} )();
