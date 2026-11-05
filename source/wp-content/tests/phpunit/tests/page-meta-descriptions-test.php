<?php
/**
 * Test the meta description of pages rendered from patterns.
 */

declare( strict_types = 1 );

use function WordPressdotorg\Theme\Main_2022\get_page_pattern_description;

require_once dirname( __DIR__, 3 ) . '/themes/wporg-main-2022/inc/page-meta-descriptions.php';

/**
 * Tests for reading the meta description from the pattern of the current page template.
 */
class Page_Meta_Descriptions_Test extends WP_UnitTestCase {
	/**
	 * Unregister the test patterns and reset the current template.
	 */
	public function tear_down(): void {
		foreach ( array( 'test/nav', 'test/page' ) as $slug ) {
			if ( WP_Block_Patterns_Registry::get_instance()->is_registered( $slug ) ) {
				unregister_block_pattern( $slug );
			}
		}
		unset( $GLOBALS['_wp_current_template_content'] );

		parent::tear_down();
	}

	/**
	 * Test that the description comes from the page's pattern in the main element, not the navigation pattern before it.
	 */
	public function test_description_comes_from_the_page_pattern(): void {
		register_block_pattern(
			'test/nav',
			array(
				'title'       => 'Navigation',
				'description' => 'Navigation description.',
				'content'     => '',
			)
		);
		register_block_pattern(
			'test/page',
			array(
				'title'       => 'Download',
				'description' => 'Download WordPress today.',
				'content'     => '',
			)
		);

		$GLOBALS['_wp_current_template_content'] = '<!-- wp:pattern {"slug":"test/nav"} /-->'
			. '<!-- wp:group {"tagName":"main"} --><main class="wp-block-group"><!-- wp:pattern {"slug":"test/page"} /--></main><!-- /wp:group -->';

		$this->assertSame( 'Download WordPress today.', get_page_pattern_description() );
	}
}
