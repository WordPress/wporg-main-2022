<?php
/**
 * Test the layout of pages that don't have their own template yet.
 */

declare( strict_types = 1 );

use function WordPressdotorg\Theme\Main_2022\add_title_to_content;

require_once dirname( __DIR__, 3 ) . '/themes/wporg-main-2022/inc/page-layout.php';

/**
 * Tests for the page title that page.html adds to content without its own H1.
 */
class Page_Layout_Test extends WP_UnitTestCase {
	/**
	 * Content without an H1.
	 *
	 * @var string
	 */
	private const PLAIN = "<!-- wp:paragraph -->\n<p>One.</p>\n<!-- /wp:paragraph -->";

	/**
	 * Set up pretty permalinks, which resolve pages like production does.
	 */
	public function set_up(): void {
		parent::set_up();

		$this->set_permalink_structure( '/%postname%/' );
	}

	/**
	 * Clean up the current template.
	 */
	public function tear_down(): void {
		unset( $GLOBALS['_wp_current_template_id'] );

		parent::tear_down();
	}

	/**
	 * Test that content without an H1 gets the page title in page.html.
	 */
	public function test_adds_title_to_content_without_h1(): void {
		$this->render_page( self::PLAIN, 'page' );

		$result = add_title_to_content( self::PLAIN );

		$this->assertStringContainsString( '>Q&amp;A</h1>', $result );
		$this->assertStringContainsString( self::PLAIN, $result );
	}

	/**
	 * Test that content with its own H1 is left alone.
	 */
	public function test_keeps_content_with_h1(): void {
		$content = "<!-- wp:heading {\"level\":1} -->\n<h1 class=\"wp-block-heading\">Title</h1>\n<!-- /wp:heading -->";
		$this->render_page( $content, 'page' );

		$this->assertSame( $content, add_title_to_content( $content ) );
	}

	/**
	 * Test that pages with their own template are left alone; their patterns already have the title.
	 */
	public function test_keeps_content_in_other_templates(): void {
		$this->render_page( self::PLAIN, 'page-about' );

		$this->assertSame( self::PLAIN, add_title_to_content( self::PLAIN ) );
	}

	/**
	 * Test that content outside the main loop, like in the document head, is left alone.
	 */
	public function test_keeps_content_outside_the_loop(): void {
		$this->render_page( self::PLAIN, 'page' );
		have_posts(); // Ends the loop.

		$this->assertSame( self::PLAIN, add_title_to_content( self::PLAIN ) );
	}

	/**
	 * Query a published page and enter the main loop, as rendering a block template does.
	 *
	 * @param string $content  Raw block content.
	 * @param string $template Slug of the template rendering the page.
	 */
	private function render_page( string $content, string $template ): void {
		$page_id = self::factory()->post->create(
			array(
				'post_type'    => 'page',
				'post_title'   => 'Q&A',
				'post_content' => $content,
			)
		);

		$this->go_to( get_permalink( $page_id ) );
		$GLOBALS['_wp_current_template_id'] = get_stylesheet() . '//' . $template;
		the_post();
	}
}
