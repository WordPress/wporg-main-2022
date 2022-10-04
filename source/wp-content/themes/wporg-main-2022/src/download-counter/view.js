/**
 * WordPress dependencies
 */
import apiFetch from '@wordpress/api-fetch';

const init = () => {
	const containers = document.querySelectorAll( '.wp-block-wporg-download-counter' );
	if ( containers ) {
		containers.forEach( ( element ) => {
			const { branch } = element.dataset;

			// Update the version string if the branch is different, only if the previous element is a heading 1.
			const heading = element.previousElementSibling;
			if ( 'H1' === heading.tagName.toUpperCase() ) {
				const [ version ] = heading.innerHTML.match( /[0-9]+\.[0-9]/ ) || [];
				if ( version ) {
					heading.innerHTML = heading.innerHTML.replace( version, branch );
				}
			}

			setInterval( async () => {
				const count = await apiFetch( { path: `/wporg/v1/core-downloads/${ branch }` } );
				element.innerHTML = count;
			}, 5000 );
		} );
	}
};

window.addEventListener( 'load', init );
