<?php
/**
 * Page title for content without its own H1.
 *
 * Shared by the theme and the content sync (env/export-content), so pages look the same before and after the sync.
 * Keep this file free of hooks: the sync loads it outside the theme.
 *
 * @package WordPressdotorg\Theme\Main_2022
 */

declare( strict_types = 1 );

namespace WordPressdotorg\Theme\Main_2022;

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

/**
 * Wrap content in padding, below an H1 with the page title.
 *
 * The inner group keeps wide and full-width blocks to the content width.
 *
 * @param string $content Raw block content.
 * @param string $title   Page title, as plain text.
 * @return string Block content.
 */
function add_page_title( string $content, string $title ): string {
	$title = esc_html( $title );

	return <<<EOF
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","right":"var:preset|spacing|edge-space","left":"var:preset|spacing|edge-space","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--edge-space);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:heading {"level":1,"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|30"}}}} -->
<h1 class="wp-block-heading" style="margin-bottom:var(--wp--preset--spacing--30)">{$title}</h1>
<!-- /wp:heading -->

<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group">{$content}</div>
<!-- /wp:group --></div>
<!-- /wp:group -->
EOF;
}
