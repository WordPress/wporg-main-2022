<?php
/**
 * Template selection for pages whose content brings its own title and spacing.
 *
 * @package WordPressdotorg\MainTheme
 */

declare( strict_types = 1 );

namespace WordPressdotorg\Theme\Main_2022;

add_filter( 'page_template_hierarchy', __NAMESPACE__ . '\add_content_only_template' );

/**
 * Prefer the content-only template over page.html for pages laid out like synced patterns.
 *
 * Until a page has its own template, it renders through page.html, which adds a title and padding
 * that such content already has, doubling both in previews and on the live page.
 *
 * @param string[] $templates Template candidates, most specific first.
 * @return string[] Filtered template candidates.
 */
function add_content_only_template( array $templates ): array {
	$index = array_search( 'page.php', $templates, true );
	$post  = get_post();

	if ( false === $index || ! $post || ! has_own_page_layout( $post->post_content ) ) {
		return $templates;
	}

	array_splice( $templates, $index, 0, 'page-content-only.php' );

	return $templates;
}

/**
 * Whether content starts with a full-width group holding the page's H1, like the page-layout pattern.
 *
 * @param string $content Post content.
 * @return bool
 */
function has_own_page_layout( string $content ): bool {
	$blocks = array_values(
		array_filter(
			parse_blocks( $content ),
			static fn ( array $block ): bool => null !== $block['blockName']
		)
	);
	$first  = $blocks[0] ?? null;

	if ( ! $first || 'core/group' !== $first['blockName'] || 'full' !== ( $first['attrs']['align'] ?? '' ) ) {
		return false;
	}

	foreach ( $first['innerBlocks'] as $block ) {
		if ( 'core/heading' === $block['blockName'] && 1 === ( $block['attrs']['level'] ?? 2 ) ) {
			return true;
		}
	}

	return false;
}
