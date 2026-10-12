<?php
/**
 * Test the layout of pages that don't have their own template yet.
 */

declare( strict_types = 1 );

use function WordPressdotorg\Theme\Main_2022\add_content_only_template;
use function WordPressdotorg\Theme\Main_2022\has_h1;

require_once dirname( __DIR__, 3 ) . '/themes/wporg-main-2022/inc/page-layout.php';

/**
 * Tests for the template that content with its own H1 gets instead of page.html.
 */
class Page_Layout_Test extends WP_UnitTestCase {
	/**
	 * Template candidates for a page without a custom template.
	 *
	 * @var string[]
	 */
	private const TEMPLATES = array( 'page-example.php', 'page-1.php', 'page.php' );

	/**
	 * Data provider for content, and whether it has its own H1.
	 *
	 * @return array
	 */
	public function data_content_has_h1(): array {
		return array(
			'paragraphs'                => array(
				"<!-- wp:paragraph -->\n<p>One.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Two.</p>\n<!-- /wp:paragraph -->",
				false,
			),
			'only lower-level headings' => array(
				"<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">Section</h2>\n<!-- /wp:heading -->",
				false,
			),
			'full-width banner'         => array(
				"<!-- wp:cover {\"align\":\"full\"} -->\n<div class=\"wp-block-cover alignfull\"></div>\n<!-- /wp:cover -->",
				false,
			),
			'empty'                     => array( '', false ),
			'header element'            => array( '<header class="wp-block-group"></header>', false ),
			'heading block'             => array(
				"<!-- wp:heading {\"level\":1} -->\n<h1 class=\"wp-block-heading\">Title</h1>\n<!-- /wp:heading -->",
				true,
			),
			'nested heading block'      => array(
				"<!-- wp:group -->\n<div class=\"wp-block-group\"><!-- wp:heading {\"level\":1} -->\n<h1 class=\"wp-block-heading\">Title</h1>\n<!-- /wp:heading --></div>\n<!-- /wp:group -->",
				true,
			),
			'HTML block'                => array( "<!-- wp:html -->\n<h1>Title</h1>\n<!-- /wp:html -->", true ),
			'H1 post title'             => array( '<!-- wp:post-title {"level":1} /-->', true ),
			'default post title'        => array( '<!-- wp:post-title /-->', false ),
			'random heading'            => array( '<!-- wp:wporg/random-heading /-->', true ),
			'site title'                => array( '<!-- wp:site-title /-->', true ),
			'H2 site title'             => array( '<!-- wp:site-title {"level":2} /-->', false ),
			'query title'               => array( '<!-- wp:query-title {"type":"archive"} /-->', true ),
			'nested synced pattern'     => array(
				"<!-- wp:group -->\n<div class=\"wp-block-group\"><!-- wp:block {\"ref\":1} /--></div>\n<!-- /wp:group -->",
				true,
			),
			'pattern reference'         => array( '<!-- wp:pattern {"slug":"wporg-main-2022/x"} /-->', true ),
		);
	}

	/**
	 * Test detecting content's own H1.
	 *
	 * @dataProvider data_content_has_h1
	 *
	 * @param string $content  Raw block content.
	 * @param bool   $expected Whether the content has an H1.
	 */
	public function test_has_h1( string $content, bool $expected ): void {
		$this->assertSame( $expected, has_h1( $content ) );
	}

	/**
	 * Test that content with its own H1 gets the content-only template ahead of page.html.
	 */
	public function test_content_with_h1_uses_content_only_template(): void {
		$this->go_to_page( "<!-- wp:heading {\"level\":1} -->\n<h1 class=\"wp-block-heading\">Title</h1>\n<!-- /wp:heading -->" );

		$this->assertSame(
			array( 'page-example.php', 'page-1.php', 'page-content-only.php', 'page.php' ),
			add_content_only_template( self::TEMPLATES )
		);
	}

	/**
	 * Test that content without an H1 keeps page.html, which adds the title.
	 */
	public function test_content_without_h1_keeps_page_template(): void {
		$this->go_to_page( "<!-- wp:paragraph -->\n<p>One.</p>\n<!-- /wp:paragraph -->" );

		$this->assertSame( self::TEMPLATES, add_content_only_template( self::TEMPLATES ) );
	}

	/**
	 * Test that candidates without page.html, like other post types', are left alone.
	 */
	public function test_other_hierarchies_are_unchanged(): void {
		$this->go_to_page( '<!-- wp:post-title {"level":1} /-->' );

		$this->assertSame( array( 'single.php' ), add_content_only_template( array( 'single.php' ) ) );
	}

	/**
	 * Query a published page with the given content.
	 *
	 * @param string $content Raw block content.
	 */
	private function go_to_page( string $content ): void {
		$page_id = self::factory()->post->create(
			array(
				'post_type'    => 'page',
				'post_content' => $content,
			)
		);

		$this->go_to( get_permalink( $page_id ) );
	}
}
