/**
 * WordPress dependencies
 */

const init = () => {
	const containers = document.querySelectorAll( '.wp-block-wporg-release-tables' );
	if ( containers ) {
		containers.forEach( ( element ) => {
			const tabs = element.querySelectorAll( 'ul[role="tablist"] a' );

			tabs.forEach( ( tab ) => {
				tab.onclick = () => {
					// Unselect selected tabs, hide all tables.
					element
						.querySelectorAll( 'a[role="tab"][aria-selected="true"]' )
						.forEach( ( elem ) => elem.setAttribute( 'aria-selected', false ) );
					element
						.querySelectorAll( '.wp-block-wporg-release-tables__section[aria-hidden="false"]' )
						.forEach( ( elem ) => elem.setAttribute( 'aria-hidden', true ) );

					// Show the selected table.
					const id = tab.getAttribute( 'aria-controls' );
					tab.setAttribute( 'aria-selected', true );
					document.getElementById( id ).setAttribute( 'aria-hidden', false );
				};
			} );
		} );

		// If linked to a table directly, make sure that's selected.
		if ( window.location.hash ) {
			const id = window.location.hash.replace( '#', '' );
			const section = document.getElementById( id );
			const tab = document.querySelector( `a[role="tab"][aria-controls=${ id }]` );
			if ( section && tab ) {
				tab.setAttribute( 'aria-selected', true );
				section.setAttribute( 'aria-hidden', false );
			}
		}
	}
};

window.addEventListener( 'load', init );
