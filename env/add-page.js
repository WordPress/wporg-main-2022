#!/usr/bin/env node
/* eslint-disable no-console */
/**
 * Adds published wordpress.org pages to the page manifest.
 *
 * The pattern name is the page's ancestor slugs plus its own slug (e.g. `about-privacy-cookies.php`),
 * and the template is the one assigned to the page, or `page-{slug}.html` when none is.
 *
 * Usage:
 *   node ./env/add-page.js <slug>  Add one page.
 *   node ./env/add-page.js --new   Add every published page that the new theme renders but the manifest lacks.
 */

/**
 * External dependencies.
 */
const { readFileSync, writeFileSync } = require( 'fs' );
const path = require( 'path' );

const MANIFEST_PATH = path.join( __dirname, 'page-manifest.json' );
const API_URL =
	'https://wordpress.org/wp-json/wp/v2/pages?per_page=100&_fields=id,slug,parent,template,title,link';

// Slugs and template names become file names.
const NAME_PATTERN = /^[a-z0-9%_-]+$/i;

// Unfinished pages are published with this template, which hides their content.
const IN_PROGRESS_TEMPLATE = 'page-in-progress';

const [ , , arg ] = process.argv;

/**
 * Fetch all published pages from wordpress.org.
 *
 * @return {Promise<Array>} Pages.
 */
async function fetchAllPages() {
	const pages = [];
	let totalPages = 1;
	for ( let current = 1; current <= totalPages; current++ ) {
		const response = await fetch( `${ API_URL }&page=${ current }` );
		if ( ! response.ok ) {
			throw new Error( `HTTP ${ response.status } fetching pages.` );
		}
		totalPages = Number( response.headers.get( 'X-WP-TotalPages' ) );
		pages.push( ...( await response.json() ) );
	}
	return pages;
}

/**
 * Whether the live page renders through this theme, not the old one the theme switcher keeps some pages on.
 *
 * @param {Object} page Page from the REST API.
 * @return {Promise<boolean>} True if the page uses the new theme.
 */
async function usesNewTheme( page ) {
	const response = await fetch( page.link );
	const html = await response.text();
	return /<body[^>]+wp-child-theme-wporg-main-2022/.test( html );
}

/**
 * Build the manifest entry for a page.
 *
 * @param {Object} page     Page from the REST API.
 * @param {Array}  allPages All published pages, to resolve ancestors.
 * @return {Object} Manifest entry.
 */
function getEntry( page, allPages ) {
	if ( ! page.title.rendered ) {
		throw new Error(
			`"${ page.slug }" has no title. Set one in the editor first; patterns without a title don't register.`
		);
	}

	const slugs = [ page.slug ];
	let parentId = page.parent;
	while ( parentId ) {
		const ancestor = allPages.find( ( { id } ) => id === parentId );
		if ( ! ancestor ) {
			throw new Error( `Parent page ${ parentId } of "${ page.slug }" is not published.` );
		}
		slugs.unshift( ancestor.slug );
		parentId = ancestor.parent;
	}

	const template = page.template || `page-${ page.slug }`;
	if ( ! [ ...slugs, template ].every( ( name ) => NAME_PATTERN.test( name ) ) ) {
		throw new Error( `"${ page.slug }" has an unexpected slug or template name.` );
	}

	return {
		slug: page.slug,
		pattern: `${ slugs.join( '-' ) }.php`,
		template: `${ template }.html`,
	};
}

( async () => {
	if ( ! arg ) {
		throw new Error( 'Usage: node ./env/add-page.js <slug> | --new' );
	}

	const manifest = JSON.parse( readFileSync( MANIFEST_PATH, 'utf8' ) );
	const inManifest = ( page ) => manifest.some( ( entry ) => entry.slug === page.slug );
	const allPages = await fetchAllPages();
	const entries = [];

	if ( '--new' === arg ) {
		for ( const page of allPages.filter( ( candidate ) => ! inManifest( candidate ) ) ) {
			if ( IN_PROGRESS_TEMPLATE === page.template || ! ( await usesNewTheme( page ) ) ) {
				continue;
			}
			try {
				entries.push( getEntry( page, allPages ) );
			} catch ( error ) {
				// Annotates the workflow run without blocking other pages' content updates.
				console.log( `::warning::Skipped ${ page.link }: ${ error.message }` );
			}
		}
	} else {
		const matches = allPages.filter( ( page ) => page.slug === arg );
		if ( matches.length !== 1 ) {
			throw new Error( `Expected one published page with the slug "${ arg }", found ${ matches.length }.` );
		}
		if ( inManifest( matches[ 0 ] ) ) {
			console.log( `"${ arg }" is already in the manifest.` );
			return;
		}
		entries.push( getEntry( matches[ 0 ], allPages ) );
	}

	if ( ! entries.length ) {
		console.log( 'No pages to add.' );
		return;
	}

	manifest.push( ...entries );
	writeFileSync( MANIFEST_PATH, JSON.stringify( manifest, null, '\t' ) + '\n' );

	for ( const entry of entries ) {
		console.log( 'Added to the manifest:', entry );
	}
} )().catch( ( error ) => {
	console.error( error.message );
	process.exitCode = 1;
} );
