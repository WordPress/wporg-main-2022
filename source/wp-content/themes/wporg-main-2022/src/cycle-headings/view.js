// Code originally forked from https://wordpress.com/p2/
// https://github.com/Automattic/p2/blob/master/themes/marketing/src/js/hero-dynamic-text.js

// Set up the dynamic text in the hero section of the Home page.
const DURATION_PER_ITEM_MS = 5000;
const DELAY_BETWEEN_ITEMS_MS = 500; // Should equal the sum of transition duration in CSS.

function textFragmentIterator() {
	let currentIteration = 0;
	const fragments = Array.from( document.querySelectorAll( '.wp-block-wporg-cycle-headings p' ) ).map(
		( elem ) => elem.innerHTML
	);

	return () => {
		const index = ++currentIteration % fragments.length;
		return fragments[ index ];
	};
}

function init() {
	const getNextTextFragment = textFragmentIterator();
	const targetNode = document.querySelector( '.wp-block-wporg-cycle-headings__container' );

	window.setTimeout( () => {
		targetNode.classList.add( 'is-ready' );
	}, DURATION_PER_ITEM_MS - 1 );

	window.setInterval( () => {
		targetNode.classList.remove( 'fade-in' );

		window.setTimeout( () => {
			targetNode.innerHTML = getNextTextFragment();
			targetNode.classList.add( 'fade-in' );
		}, DELAY_BETWEEN_ITEMS_MS );
	}, DURATION_PER_ITEM_MS );
}

const wantMotionQuery = window.matchMedia( '(prefers-reduced-motion)' );

if ( ! wantMotionQuery.matches ) {
	init();
}
