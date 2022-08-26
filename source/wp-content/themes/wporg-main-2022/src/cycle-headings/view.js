// Set up the dynamic text in the hero section of the Home page.
const MS_DURATION_PER_ITEM = 5000;
const MS_DELAY_BETWEEN_ITEMS = 500; // Should equal the sum of transition duration in CSS.

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
	}, MS_DURATION_PER_ITEM - 1 );

	window.setInterval( () => {
		targetNode.classList.remove( 'fade-in' );

		window.setTimeout( () => {
			targetNode.innerHTML = getNextTextFragment();
			targetNode.classList.add( 'fade-in' );
		}, MS_DELAY_BETWEEN_ITEMS );
	}, MS_DURATION_PER_ITEM );
}

const wantMotionQuery = window.matchMedia( '(prefers-reduced-motion)' );

if ( ! wantMotionQuery.matches ) {
	init();
}
