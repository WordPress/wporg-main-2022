<?php
/**
 * Test adding the page title to exported page content.
 */

declare( strict_types = 1 );

use function WordPress_org\Main_2022\ExportToPatterns\add_page_title;
use function WordPress_org\Main_2022\ExportToPatterns\has_h1;

require_once dirname( __DIR__ ) . '/includes/utils.php';

/**
 * Tests for the page title that pages without their own H1 get in their pattern.
 */
class Page_Title_Test extends WP_UnitTestCase {
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
	 * Test that the title is added as an escaped H1 above the content, nested like page.html.
	 */
	public function test_add_page_title(): void {
		$content = "<!-- wp:paragraph -->\n<p>One.</p>\n<!-- /wp:paragraph -->";
		$result  = add_page_title( $content, 'Q&A <draft>' );
		$blocks  = array_values(
			array_filter(
				parse_blocks( $result ),
				static fn ( array $block ): bool => null !== $block['blockName']
			)
		);

		$this->assertCount( 1, $blocks );
		$this->assertSame( 'core/group', $blocks[0]['blockName'] );
		$this->assertSame( 'full', $blocks[0]['attrs']['align'] );

		$heading = $blocks[0]['innerBlocks'][0];
		$this->assertSame( 'core/heading', $heading['blockName'] );
		$this->assertSame( 1, $heading['attrs']['level'] );
		$this->assertStringContainsString( '>Q&amp;A &lt;draft&gt;</h1>', $heading['innerHTML'] );

		$inner = $blocks[0]['innerBlocks'][1];
		$this->assertSame( 'core/group', $inner['blockName'] );
		$this->assertSame( 'core/paragraph', $inner['innerBlocks'][0]['blockName'] );
		$this->assertSame( $result, serialize_blocks( parse_blocks( $result ) ) );
		$this->assertTrue( has_h1( $result ) );
	}
}
