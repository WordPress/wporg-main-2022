<?php
/**
 * Block Name: Cycle Headings
 * Description: Animate through a set of headings.
 *
 * @package wporg
 */

namespace WordPressdotorg\Theme\Main_2022\Cycle_Headings_Block;

add_action( 'init', __NAMESPACE__ . '\init' );

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function init() {
	register_block_type(
		dirname( dirname( __DIR__ ) ) . '/build/cycle-headings',
		array(
			'render_callback' => __NAMESPACE__ . '\render',
		)
	);
}

/**
 * Render the block content.
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    Block default content.
 * @param WP_Block $block      Block instance.
 *
 * @return string Returns the block markup.
 */
function render( $attributes, $content, $block ) {
	if ( ! empty( $block->block_type->view_script ) ) {
		wp_enqueue_script( $block->block_type->view_script );
		// Move to footer.
		wp_script_add_data( $block->block_type->view_script, 'group', 1 );
	}

	$headings = array(
		'Publish your <em>passion</em>',
		'Start your <em>podcast</em>',
		'Do your <em>thing</em>',
	);

	$content = '<h1 class="screen-reader-text">WordPress: Publish your passion</h1>';
	$content .= '<div aria-hidden="true">WordPress: <span class="wp-block-wporg-cycle-headings__container">' . $headings[0] . '</span></div>';

	foreach ( $headings as $heading ) {
		$content .= sprintf( '<p class="screen-reader-text">WordPress: <span>%s</span></p>', $heading );
	}

	$wrapper_attributes = get_block_wrapper_attributes();
	return sprintf(
		'<div %1$s>%2$s</div>',
		$wrapper_attributes,
		$content
	);
}