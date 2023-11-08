<?php
/**
 * Block Name: Remembers Contributor List
 * Description: Displays a list of memorialized contributors..
 *
 * @package wporg
 */

namespace WordPressdotorg\Theme\Main_2022\Remembers_List_Block;

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
		dirname( dirname( __DIR__ ) ) . '/build/remembers-list',
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

	// Replace with query
	$profiles = [ 'Kim Parsell', 'Alex King', 'Jesse Petersen', 'Efrain Rivera', 'Todrick Moore', 'Alex Mills', 'Joseph Karr O’Connor', 'David de Boer' ];

	$columns = $attributes['columns'];
	$group_count = ceil( count( $profiles ) / $columns );

	$groups = [];
	for ( $i = 0; $i < $group_count; $i++ ) {
		$groups[] = array_slice( $profiles, $i * $columns, $columns );
	}

	$block_content = '';
	foreach ( $groups as $group ) {
		$block_content .= '<!-- wp:columns --><div class="wp-block-columns">';

		foreach ( $group as $name ) {
			$block_content .= '<!-- wp:column --><div class="wp-block-column">';
			$block_content .= '<!-- wp:heading {"textAlign":"center","style":{"spacing":{"margin":{"top":"var:preset|spacing|30","right":"var:preset|spacing|default","bottom":"var:preset|spacing|30","left":"var:preset|spacing|default"}}},"fontSize":"extra-large"} -->';
			$block_content .= '<h2 class="wp-block-heading has-text-align-center has-extra-large-font-size" style="margin-top:var(--wp--preset--spacing--30);margin-right:var(--wp--preset--spacing--default);margin-bottom:var(--wp--preset--spacing--30);margin-left:var(--wp--preset--spacing--default)">';
			$block_content .= '<em>';
			$block_content .= '<a href="https://google.com">' . esc_html( $name ) . '</a>';
			$block_content .= '</em>';
			$block_content .= '</h2>';
			$block_content .= '<!-- /wp:heading -->';
			$block_content .= '</div><!-- /wp:column -->';
		}

		$block_content .= '</div><!-- /wp:columns -->';
	}

	$wrapper_attributes = get_block_wrapper_attributes();
	return sprintf(
		'<h1 %1$s>%2$s</h1>',
		$wrapper_attributes,
		do_blocks( $block_content )
	);
}
