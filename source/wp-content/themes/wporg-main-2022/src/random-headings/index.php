<?php
/**
 * Block Name: Random Headings
 * Description: Display a random heading from a set.
 *
 * @package wporg
 */

namespace WordPressdotorg\Theme\Main_2022\Random_Headings_Block;

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
		dirname( dirname( __DIR__ ) ) . '/build/random-headings',
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
	$headings = array(
		__( 'WordPress: Publish your <em>passion</em>', 'wporg' ),
		__( 'WordPress: Grow your <em>business</em>', 'wporg' ),
		__( 'WordPress: Flex your <em>freedom</em>', 'wporg' ),
	);
	$heading = array_rand( array_flip( $headings ) );

	$wrapper_attributes = get_block_wrapper_attributes();
	return sprintf(
		'<h1 %1$s>%2$s</h1>',
		$wrapper_attributes,
		$heading
	);
}
