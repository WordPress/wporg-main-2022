#!/usr/bin/env node
/* eslint-disable no-console */
/**
 * Adds a published wordpress.org page to the page manifest.
 *
 * The pattern name is the page's ancestor slugs plus its own slug (e.g. `about-privacy-cookies.php`),
 * and the template is the one assigned to the page, or `page-{slug}.html` when none is.
 *
 * Usage: node ./env/add-page.js <slug>
 */

/**
 * External dependencies.
 */
const { readFileSync, writeFileSync } = require( 'fs' );
const path = require( 'path' );

const MANIFEST_PATH = path.join( __dirname, 'page-manifest.json' );
const API_URL = 'https://wordpress.org/wp-json/wp/v2/pages';

const [ , , slug ] = process.argv;

/**
 * Fetch pages from the wordpress.org REST API.
 *
 * @param {string} query Query string.
 * @return {Promise<Array>} Matching pages.
 */
async function fetchPages( query ) {
	const response = await fetch( `${ API_URL }?${ query }&_fields=id,slug,parent,template,title` );
	if ( ! response.ok ) {
		throw new Error( `HTTP ${ response.status } for ${ API_URL }?${ query }` );
	}
	return response.json();
}

( async () => {
	if ( ! slug ) {
		throw new Error( 'Usage: node ./env/add-page.js <slug>' );
	}

	const manifest = JSON.parse( readFileSync( MANIFEST_PATH, 'utf8' ) );
	if ( manifest.some( ( entry ) => entry.slug === slug ) ) {
		console.log( `"${ slug }" is already in the manifest.` );
		return;
	}

	const pages = await fetchPages( `slug=${ encodeURIComponent( slug ) }` );
	if ( pages.length !== 1 ) {
		throw new Error( `Expected one published page with the slug "${ slug }", found ${ pages.length }.` );
	}

	const [ page ] = pages;
	if ( ! page.title.rendered ) {
		throw new Error(
			`"${ slug }" has no title. Set one in the editor first; patterns without a title don't register.`
		);
	}

	const slugs = [ page.slug ];
	let parent = page.parent;
	while ( parent ) {
		const [ ancestor ] = await fetchPages( `include=${ parent }` );
		if ( ! ancestor ) {
			throw new Error( `Parent page ${ parent } of "${ slug }" is not published.` );
		}
		slugs.unshift( ancestor.slug );
		parent = ancestor.parent;
	}

	const entry = {
		slug: page.slug,
		pattern: `${ slugs.join( '-' ) }.php`,
		template: `${ page.template || `page-${ slug }` }.html`,
	};

	manifest.push( entry );
	writeFileSync( MANIFEST_PATH, JSON.stringify( manifest, null, '\t' ) + '\n' );

	console.log( `Added "${ page.title.rendered }" to the manifest:`, entry );
} )().catch( ( error ) => {
	console.error( error.message );
	process.exitCode = 1;
} );
