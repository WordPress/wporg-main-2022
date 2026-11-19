<?php
/**
 * Layout for pages that don't have their own template yet.
 *
 * @package WordPressdotorg\Theme\Main_2022
 */

declare( strict_types = 1 );

namespace WordPressdotorg\Theme\Main_2022;

require_once __DIR__ . '/page-title.php';

/**
 * Add the page title and padding to content without its own H1, in the default page template.
 *
 * Until the content sync gives a page its own template, it renders and previews through page.html, which lays content
 * out like the sync does. The sync adds the title the same way, so the page looks the same before and after.
 *
 * @param string|null $content Raw block content.
 * @return string|null Block content.
 */
function add_title_to_content( ?string $content ): ?string {
	global $_wp_current_template_id;

	if (
		null === $content ||
		! is_page() ||
		! in_the_loop() ||
		! is_main_query() ||
		get_the_ID() !== get_queried_object_id() ||
		get_stylesheet() . '//page' !== $_wp_current_template_id ||
		has_h1( $content )
	) {
		return $content;
	}

	return add_page_title( $content, get_the_title() );
}
add_filter( 'the_content', __NAMESPACE__ . '\add_title_to_content', 8 ); // Before do_blocks().
