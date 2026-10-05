/**
 * WordPress dependencies
 */
import apiFetch from '@wordpress/api-fetch';
import { decodeEntities } from '@wordpress/html-entities';

// A branch is a version like "6.4". Mirror the server-side validate_branch() in
// index.php so the client trusts the same shape the server does.
const BRANCH = /^[0-9]+\.[0-9]$/;

const init = () => {
	const containers = document.querySelectorAll( '.wp-block-wporg-download-counter' );

	containers.forEach( ( element ) => {
		const { branch } = element.dataset;

		// Ignore anything whose branch is not a plain version number. This skips
		// the heading update and the download-count request alike, so a value the
		// server would reject drives no behaviour here either.
		if ( ! BRANCH.test( branch ) ) {
			return;
		}

		// Update the version string, only when the previous element is a heading 1.
		// Writing it as a text node (not innerHTML) keeps the value as text and
		// can never introduce markup.
		const heading = element.previousElementSibling;
		if ( heading && 'H1' === heading.tagName.toUpperCase() ) {
			const [ version ] = heading.textContent.match( /[0-9]+\.[0-9]/ ) || [];
			if ( version ) {
				const walker = document.createTreeWalker( heading, NodeFilter.SHOW_TEXT );
				let node;
				while ( ( node = walker.nextNode() ) ) {
					const index = node.nodeValue.indexOf( version );
					if ( -1 !== index ) {
						node.nodeValue =
							node.nodeValue.slice( 0, index ) +
							branch +
							node.nodeValue.slice( index + version.length );
						break;
					}
				}
			}
		}

		setInterval( async () => {
			try {
				const count = await apiFetch( { path: `/wporg/v1/core-downloads/${ branch }?_locale=site` } );
				element.textContent = decodeEntities( count );
			} catch {}
		}, 5000 );
	} );
};

window.addEventListener( 'load', init );
