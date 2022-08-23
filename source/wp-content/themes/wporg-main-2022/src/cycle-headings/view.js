// Set up the dynamic text in the hero section of the Home page.
const MS_DURATION_PER_ITEM = 4000;
const MS_DELAY_BETWEEN_ITEMS = 500;

function textFragmentIterator() {
	let currentIteration = 0;
	const fragments = Array.from( document.querySelectorAll( '.wp-block-wporg-cycle-heading p > span' ) ).map(
		( elem ) => elem.innerHTML
	);

	return () => {
		const index = ++currentIteration % fragments.length;
		return fragments[ index ];
	};
}

const getNextTextFragment = textFragmentIterator();
const targetNode = document.querySelector( '.wp-block-wporg-cycle-heading-container' );

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
