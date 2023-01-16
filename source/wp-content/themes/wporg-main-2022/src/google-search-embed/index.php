<?php
/**
 * Block Name: Google Search Embed
 * Description: Display the Google Search embed for WordPress.org.
 *
 * @package wporg
 */

namespace WordPressdotorg\Theme\Main_2022\Google_Search_Embed;

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
		dirname( dirname( __DIR__ ) ) . '/build/google-search-embed',
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

		// If jQuery is not enqueued, add it.
		if ( ! wp_script_is( 'jquery', 'enqueued' ) ) {
			wp_enqueue_script( 'jquery' );
		}
	}

	$terms = urldecode( wp_unslash( $_GET['s'] ?? '' ) ); // phpcs:ignore
	$terms = htmlspecialchars_decode( $terms );
	$terms = explode( '?', $terms )[0];
	$terms = trim( $terms, "/ \r\n\t" );

	$search_config = array(
		'div'        => 'gsce-search',
		'gname'      => 'wordpressorg-search',
		'attributes' => array(
			'queryParameterName' => 'search',
			'linkTarget'         => '_parent',
			'enableHistory'      => false,
			'enableOrderBy'      => true,
		),
	);

	$refinement = isset( $_REQUEST['in'] ) ? sanitize_title( wp_unslash( $_REQUEST['in'] ) ) : ''; // phpcs:ignore
	if ( in_array( $refinement, [ 'support_forums', 'support_docs', 'developer_documentation' ], true ) ) {
		$search_config['attributes']['defaultToRefinement'] = $refinement;
	}

	$wrapper_attributes = get_block_wrapper_attributes();
	return sprintf(
		'<div %1$s id="gsce-search" data-config="%2$s" data-terms="%3$s"></div>',
		$wrapper_attributes,
		esc_attr( wp_json_encode( $search_config, true ) ),
		esc_attr( wp_json_encode( $terms ) )
	);
}
