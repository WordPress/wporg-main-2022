#!/usr/bin/env node
/* eslint-disable no-console */
/**
 * External dependencies.
 */
const path = require( 'path' );
const puppeteer = require( 'puppeteer' );

/**
 * Internal dependencies.
 */
const manifest = require( './page-manifest.json' );

const IMAGE_PATH = path.resolve( process.env.GITHUB_WORKSPACE || '.', 'artifacts' );
console.log( 'Saving images to ' + IMAGE_PATH );

// node ./env/screenshot-changes.js [...files]
const [ , , ...files ] = process.argv;

( async () => {
	const browser = await puppeteer.launch( { headless: true } );
	const page = await browser.newPage();

	await page.setViewport( {
		width: 1440,
		height: 800,
		deviceScaleFactor: 1,
	} );

	for ( let i = 0; i < files.length; i++ ) {
		const file = files[ i ];
		const found = manifest.find(
			( entry ) => entry.pattern === path.basename( file ) || `${ entry.slug }.php` === path.basename( file )
		);
		if ( found ) {
			let url = `http://localhost:8888/?pagename=${ found.slug }`;
			if ( 'home' === found.slug ) {
				url = 'http://localhost:8888/';
			}
			console.log( `Capturing ${ url }` );

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
				path: `${ IMAGE_PATH }/${ found.slug }.png`,
				fullPage: true,
			} );
		}
	}

	await browser.close();
} )();
