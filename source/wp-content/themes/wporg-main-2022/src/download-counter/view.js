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

		// Update the version string, only when the previous element is a heading 1
		// and the branch is a plain version number. Writing it as a text node (not
		// innerHTML) keeps the value as text and can never introduce markup.
		const heading = element.previousElementSibling;
		if ( heading && 'H1' === heading.tagName.toUpperCase() && BRANCH.test( branch ) ) {
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
