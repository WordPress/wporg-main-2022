/* global google, jQuery */

function wporg_search_update_url( term, refinement_obj = false ) {
	let refinement = 'all';
	if ( refinement_obj && refinement_obj.length ) {
		refinement = refinement_obj
			.text()
			.trim()
			.toLowerCase()
			.replace( /[^a-z]/g, '_' );
	}
	if ( 'all' === refinement ) {
		refinement = '';
	}

	const state = {
		search: term,
		refinement: refinement,
	};

	if (
		! window.history.state ||
		window.history.state.search !== state.search ||
		window.history.state.refinement !== state.refinement
	) {
		wporg_record_search( term, refinement );
	}

	window.history.replaceState(
		state,
		document.title,
		'/search/' +
			encodeURIComponent( term ).replace( /%20/g, '+' ) +
			'/' +
			( refinement ? '?in=' + refinement : '' )
	);
}

function wporg_record_search( term, refinement ) {
	jQuery.post( 'https://api.wordpress.org/search/1.0/', {
		term: term,
		in: refinement, // eslint-disable-line id-length
	} );
}

window.__gcse = {
	parsetags: 'explicit',
	callback: function () {
		const executeSearch = function () {
			const container = document.getElementById( 'gsce-search' );
			container.innerHTML = '';
			google.search.cse.element.render( JSON.parse( container.dataset.config ) );
			google.search.cse.element
				.getElement( 'wordpressorg-search' )
				.execute( JSON.parse( container.dataset.terms ) );
		};

		if ( document.readyState === 'complete' ) {
			executeSearch();
		} else {
			google.setOnLoadCallback( function () {
				executeSearch();
			}, true );
		}
	},
	searchCallbacks: {
		web: {
			starting: ( gname, searchTerm ) => {
				wporg_search_update_url( searchTerm, jQuery( '.gsc-refinementBlock .gsc-tabhActive' ) );
			},
			rendered: ( gname, searchTerm ) => {
				jQuery( '.gsc-refinementBlock .gsc-tabHeader' )
					.off( 'click.refinement, keypress.refinement' )
					.on( 'click.refinement, keypress.refinement', function () {
						wporg_search_update_url( searchTerm, jQuery( this ) );
					} );
			},
		},
	},
};

( function () {
	const cx = '012566942813864066925:bnbfebp99hs'; // eslint-disable-line id-length
	const gcseElement = document.createElement( 'script' );
	gcseElement.type = 'text/javascript';
	gcseElement.async = true;
	gcseElement.src = 'https://cse.google.com/cse.js?cx=' + cx;

	const firstScriptTag = document.getElementsByTagName( 'script' )[ 0 ];
	firstScriptTag.parentNode.insertBefore( gcseElement, firstScriptTag );
} )();
