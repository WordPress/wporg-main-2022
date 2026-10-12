<?php
/**
 * Layout for pages that don't have their own template yet.
 *
 * @package WordPressdotorg\Theme\Main_2022
 */

declare( strict_types = 1 );

namespace WordPressdotorg\Theme\Main_2022;

use WP_Post;

add_filter( 'page_template_hierarchy', __NAMESPACE__ . '\add_content_only_template' );

/**
 * Prefer the content-only template over page.html for content that has its own H1.
 *
 * The default page.html adds a title and padding, and keeps content to the content width. Content with its own H1
 * gets neither when the content sync turns it into a pattern, so this keeps previews and the live page the same
 * before and after the sync.
 *
 * @param string[] $templates Template candidates, most specific first.
 * @return string[] Filtered template candidates.
 */
function add_content_only_template( array $templates ): array {
	$index = array_search( 'page.php', $templates, true );
	$post  = get_queried_object();

	if ( false === $index || ! $post instanceof WP_Post || ! has_h1( $post->post_content ) ) {
		return $templates;
	}

	array_splice( $templates, $index, 0, 'page-content-only.php' );

	return $templates;
}

/**
 * Whether content renders its own H1.
 *
 * @param string $content Raw block content.
 * @return bool
 */
function has_h1( string $content ): bool {
	return preg_match( '/<h1[\s>]/i', $content ) || blocks_render_h1( parse_blocks( $content ) );
}

/**
 * Whether any of the blocks renders an H1 dynamically.
 *
 * Synced patterns and pattern references count too: their content isn't in the page, so it may hold one.
 *
 * @param array[] $blocks Parsed blocks.
 * @return bool
 */
function blocks_render_h1( array $blocks ): bool {
	foreach ( $blocks as $block ) {
		$level       = $block['attrs']['level'] ?? ( 'core/post-title' === $block['blockName'] ? 2 : 1 );
		$is_h1_title = in_array( $block['blockName'], array( 'core/post-title', 'core/site-title', 'core/query-title' ), true ) && 1 === $level;

		if (
			$is_h1_title ||
			in_array( $block['blockName'], array( 'wporg/random-heading', 'core/block', 'core/pattern' ), true ) ||
			blocks_render_h1( $block['innerBlocks'] )
		) {
			return true;
		}
	}

	return false;
}
