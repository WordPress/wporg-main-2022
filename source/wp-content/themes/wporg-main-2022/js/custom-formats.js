// This creates a button in the toolbar which inserts a custom, non-editable
// HTML element `<wporg-percentage />`, with the visible content of "43%". That
// could be a constant we pull from somewhere, but the string itself is saved in
// the content as text, and wouldn't live-update. For that, it would need to be
// replaced on the frontend too (a naive string replacement of the HTML element
// would probably be fine).

// The keyboard interaction is not quite right - if you arrow back after adding
// the percentage, it moves through the text rather than jumping over it.
// Using CSS to render the value, instead of a text node, would probably fix that.

// Note: using plain JS for prototyping.

/**
 * WordPress dependencies
 */
const { __ } = wp.i18n;
const { createElement } = wp.element;
const { create, insert, registerFormatType } = wp.richText;
const { BlockControls } = wp.blockEditor;
const { ToolbarButton } = wp.components;

const name = 'wporg/percentage';

const settings = {
	title: __( 'Market Share', 'wporg' ),
	tagName: 'wporg-percentage',
	className: null,
	active: false,

	edit: function ( { isActive, value, onChange, onFocus } ) {
		const onToggle = () => {
			onChange(
				insert(
					value,
					create( { html: '<wporg-percentage contenteditable="false">43%</wporg-percentage>' } )
				)
			);
			onFocus();
		};
		return createElement( BlockControls, {}, [
			createElement( ToolbarButton, {
				key: 'button',
				icon: 'admin-site-alt',
				title: __( 'Market Share', 'wporg' ),
				onClick: onToggle,
				isPressed: isActive,
			} ),
		] );
	},
};

registerFormatType( name, settings );
