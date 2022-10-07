/**
 * WordPress dependencies
 */

const init = () => {
	const containers = document.querySelectorAll( '.wp-block-wporg-release-tables' );
	if ( containers ) {
		containers.forEach( ( element ) => {
			console.log( element );
		} );
	}
};

window.addEventListener( 'load', init );
