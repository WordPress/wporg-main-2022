#!/usr/bin/env node
/* eslint-disable no-console */
/**
 * Adds published wordpress.org pages to the page manifest.
 *
 * The pattern name is the page's ancestor slugs plus its own slug (e.g. `about-privacy-cookies.php`),
 * and the template is `page-{slug}.html`.
 *
 * Usage:
 *   node ./env/add-page.js <slug>  Add one page.
 *   node ./env/add-page.js --new   Add every published page that the new theme renders but the manifest lacks.
 */

/**
 * External dependencies.
 */
const { existsSync, readFileSync, writeFileSync } = require( 'fs' );
const path = require( 'path' );

const MANIFEST_PATH = path.join( __dirname, 'page-manifest.json' );
const THEME_DIR = path.join( __dirname, '../source/wp-content/themes/wporg-main-2022' );
const PATTERNS_DIR = path.join( THEME_DIR, 'patterns' );
const TEMPLATES_DIR = path.join( THEME_DIR, 'templates' );
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
	// Following a redirect would report the theme of the page it lands on.
	const response = await fetch( page.link, { redirect: 'manual' } );
	if ( response.status >= 300 && response.status < 400 ) {
		throw new Error( `it redirects to ${ response.headers.get( 'location' ) }` );
	}
	if ( ! response.ok ) {
		throw new Error( `HTTP ${ response.status }` );
	}
	return /<body[^>]+wp-child-theme-wporg-main-2022/.test( await response.text() );
}

/**
 * Build the manifest entry for a page.
 *
 * @param {Object} page     Page from the REST API.
 * @param {Array}  allPages All published pages, to resolve ancestors.
 * @param {Array}  manifest Manifest entries.
 * @return {Object} Manifest entry.
 */
function getEntry( page, allPages, manifest ) {
	if ( ! page.title.rendered.trim() ) {
		throw new Error(
			"it has no title. Set one in the editor first; patterns without a title don't register."
		);
	}

	// The template hierarchy and pattern slugs go by slug, so a shared one needs a template picked by hand.
	const others = [ ...allPages, ...manifest ];
	if ( others.some( ( other ) => other.slug === page.slug && other.id !== page.id ) ) {
		throw new Error( `another page uses the slug "${ page.slug }". Add it to the manifest by hand.` );
	}

	const slugs = [ page.slug ];
	let parentId = page.parent;
	while ( parentId ) {
		const ancestor = allPages.find( ( { id } ) => id === parentId );
		if ( ! ancestor ) {
			throw new Error( `its parent page ${ parentId } is not published.` );
		}
		slugs.unshift( ancestor.slug );
		parentId = ancestor.parent;
	}

	// An assigned block template already shows another page's pattern; old-theme ones (`page-*.php`) are ignored.
	if ( page.template && existsSync( path.join( TEMPLATES_DIR, `${ page.template }.html` ) ) ) {
		throw new Error( `it's assigned the "${ page.template }" template. Add it to the manifest by hand.` );
	}

	const entry = {
		id: page.id,
		slug: page.slug,
		pattern: `${ slugs.join( '-' ) }.php`,
		template: `page-${ page.slug }.html`,
	};

	if ( ! slugs.every( ( name ) => NAME_PATTERN.test( name ) ) ) {
		throw new Error( 'it has an unexpected slug.' );
	}

	// Pattern names join ancestor slugs, so `about/privacy-cookies` would take `about/privacy/cookies`' pattern.
	const taken = [
		[ PATTERNS_DIR, entry.pattern, 'pattern' ],
		[ TEMPLATES_DIR, entry.template, 'template' ],
	].find(
		( [ dir, file, key ] ) =>
			existsSync( path.join( dir, file ) ) || manifest.some( ( other ) => other[ key ] === file )
	);
	if ( taken ) {
		throw new Error( `${ taken[ 1 ] } already exists. Add it to the manifest by hand.` );
	}

	return entry;
}

/**
 * Find the published pages the new theme renders but the manifest lacks.
 *
 * Problems are reported as workflow warnings, so they don't hold up the content sync.
 *
 * @param {Array} manifest Manifest entries.
 * @return {Promise<Array>} Manifest entries to add.
 */
async function findNewPages( manifest ) {
	let allPages;
	try {
		allPages = await fetchAllPages();
	} catch ( error ) {
		console.log( `::warning::Couldn't look for new pages: ${ error.message }` );
		return [];
	}

	const candidates = allPages.filter(
		( page ) => IN_PROGRESS_TEMPLATE !== page.template && ! manifest.some( ( entry ) => entry.id === page.id )
	);

	const entries = await Promise.all(
		candidates.map( async ( page ) => {
			try {
				return ( await usesNewTheme( page ) ) ? getEntry( page, allPages, manifest ) : null;
			} catch ( error ) {
				console.log( `::warning::Skipped ${ page.link }: ${ error.message }` );
				return null;
			}
		} )
	);

	return entries.filter( Boolean );
}

/**
 * Build the manifest entry for the published page with the given slug.
 *
 * @param {string} slug     Page slug.
 * @param {Array}  manifest Manifest entries.
 * @return {Promise<Array>} Manifest entries to add.
 */
async function findPage( slug, manifest ) {
	const allPages = await fetchAllPages();
	const matches = allPages.filter( ( page ) => page.slug === slug );
	if ( matches.length !== 1 ) {
		throw new Error( `Expected one published page with the slug "${ slug }", found ${ matches.length }.` );
	}
	if ( manifest.some( ( entry ) => entry.id === matches[ 0 ].id ) ) {
		console.log( `"${ slug }" is already in the manifest.` );
		return [];
	}
	try {
		return [ getEntry( matches[ 0 ], allPages, manifest ) ];
	} catch ( error ) {
		throw new Error( `Can't add "${ slug }": ${ error.message }` );
	}
}

( async () => {
	if ( ! arg ) {
		throw new Error( 'Usage: node ./env/add-page.js <slug> | --new' );
	}

	const manifest = JSON.parse( readFileSync( MANIFEST_PATH, 'utf8' ) );
	const entries = '--new' === arg ? await findNewPages( manifest ) : await findPage( arg, manifest );

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
