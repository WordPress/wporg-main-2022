<?php
/**
 * Test adding the page title to exported page content.
 */

declare( strict_types = 1 );

use function WordPress_org\Main_2022\ExportToPatterns\add_page_title;
use function WordPressdotorg\Theme\Main_2022\has_h1;

require_once dirname( __DIR__ ) . '/includes/utils.php';

/**
 * Tests for the page title that pages without their own H1 get in their pattern.
 */
class Page_Title_Test extends WP_UnitTestCase {
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
