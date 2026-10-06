<?php
/**
 * Test the code of generated pattern files.
 */

declare( strict_types = 1 );

use function WordPress_org\Main_2022\ExportToPatterns\generate_pattern;
use function WordPress_org\Main_2022\ExportToPatterns\get_pattern_header;
use function WordPress_org\Main_2022\ExportToPatterns\replace_with_i18n;
use function WordPress_org\Main_2022\ExportToPatterns\validate_pattern_code;

require_once dirname( __DIR__ ) . '/includes/utils.php';

/**
 * Tests for the PHP in generated pattern files.
 */
class Pattern_Code_Test extends WP_UnitTestCase {
	/**
	 * Data provider for code the export writes.
	 *
	 * @return array
	 */
	public function data_valid_code(): array {
		return array(
			'header'          => array( get_pattern_header( 'About', 'about' ) ),
			'text'            => array( "<p><?php esc_html_e( 'It\\'s here.', 'wporg' ); ?></p>" ),
			'markup in text'  => array( "<p><?php _e( 'A <a href=\"#\">link</a>.', 'wporg' ); ?></p>" ),
			'double quotes'   => array( "<p><?php esc_html_e( \"It's here.\", 'wporg' ); ?></p>" ),
			'attribute'       => array( "<img alt=\"<?php esc_attr_e( 'Logo', 'wporg' ); ?>\" />" ),
			'URL'             => array( "<a href=\"<?php echo esc_url( __( 'https://wordpress.org/', 'wporg' ) ); ?>\">x</a>" ),
			'translator note' => array( "<?php /* translators: x */ esc_html_e( 'x', 'wporg' ); ?>" ),
		);
	}

	/**
	 * Test that the code the export writes passes validation.
	 *
	 * @dataProvider data_valid_code
	 *
	 * @param string $code Pattern code.
	 */
	public function test_valid_code( string $code ): void {
		validate_pattern_code( $code );

		$this->addToAssertionCount( 1 );
	}

	/**
	 * Test that all patterns synced so far pass validation.
	 */
	public function test_synced_patterns_are_valid(): void {
		$theme_dir = dirname( __DIR__, 3 ) . '/wp-content/themes/wporg-main-2022';
		$manifest  = json_decode( (string) file_get_contents( dirname( __DIR__, 2 ) . '/page-manifest.json' ) );

		$validated = 0;
		foreach ( $manifest as $item ) {
			$file = $theme_dir . '/patterns/' . ( $item->pattern ?? $item->slug . '.php' );
			if ( file_exists( $file ) ) {
				validate_pattern_code( (string) file_get_contents( $file ) );
				++$validated;
			}
		}

		$this->assertGreaterThan( count( $manifest ) / 2, $validated, 'Most manifest patterns should be found.' );
	}

	/**
	 * Data provider for text containing PHP string syntax.
	 *
	 * @return array
	 */
	public function data_strings_with_php_syntax(): array {
		return array(
			'dollar with apostrophe'   => array( "It's \$price" ),
			'braces with apostrophe'   => array( "It's {\$x}" ),
			'dollar'                   => array( 'It costs $price' ),
			'trailing backslash'       => array( 'C:\\' ),
			'backslash and apostrophe' => array( "It's C:\\" ),
		);
	}

	/**
	 * Test that text with PHP string syntax becomes valid code that outputs the text unchanged.
	 *
	 * @dataProvider data_strings_with_php_syntax
	 *
	 * @param string $text Paragraph text.
	 */
	public function test_text_with_php_syntax( string $text ): void {
		$code = replace_with_i18n( "<!-- wp:paragraph -->\n<p>{$text}</p>\n<!-- /wp:paragraph -->" );
		validate_pattern_code( $code );

		$file = wp_tempnam( 'pattern' );
		file_put_contents( $file, $code );
		ob_start();
		include $file;
		$output = (string) ob_get_clean();
		unlink( $file );

		$this->assertStringContainsString( '<p>' . esc_html( $text ) . '</p>', $output );
	}

	/**
	 * Data provider for code the export doesn't write.
	 *
	 * @return array
	 */
	public function data_invalid_code(): array {
		return array(
			'other function'       => array( "<?php printf( 'x' ); ?>" ),
			'variable'             => array( '<?php echo $x; ?>' ),
			'interpolated string'  => array( "<?php esc_html_e( \"{\$x}\", 'wporg' ); ?>" ),
			'short echo tag'       => array( "<?= 'x' ?>" ),
			'short open tag'       => array( "<p><? echo 'x'; ?></p>" ),
			'short tag in HTML'    => array( "<?php esc_html_e( 'x', 'wporg' ); ?><p><?</p>" ),
			'constant'             => array( '<?php echo PHP_VERSION; ?>' ),
		);
	}

	/**
	 * Test that code the export doesn't write fails validation.
	 *
	 * @dataProvider data_invalid_code
	 *
	 * @param string $code Pattern code.
	 */
	public function test_invalid_code( string $code ): void {
		$this->expectException( Exception::class );

		validate_pattern_code( $code );
	}

	/**
	 * Data provider for titles, and how they appear in the header.
	 *
	 * @return array
	 */
	public function data_header_titles(): array {
		return array(
			'plain'          => array( 'About WordPress', 'About WordPress' ),
			'line break'     => array( "First line\nSecond line", 'First line Second line' ),
			'comment end'    => array( 'A */ B', 'A * / B' ),
			'nested'         => array( 'A **// B', 'A ** // B' ),
		);
	}

	/**
	 * Test that the title stays on its own header line inside the docblock.
	 *
	 * @dataProvider data_header_titles
	 *
	 * @param string $title    Page title.
	 * @param string $expected Title in the header.
	 */
	public function test_header_title_is_one_line( string $title, string $expected ): void {
		$header = get_pattern_header( $title, 'test' );

		$this->assertStringContainsString( " * Title: {$expected}\n * Slug:", $header );
		$this->assertSame( 1, substr_count( $header, '*/' ) );
		validate_pattern_code( $header );
	}

	/**
	 * Data provider for content with markup that looks like PHP, and how it is written to the pattern.
	 *
	 * @return array
	 */
	public function data_php_like_markup(): array {
		return array(
			'PHP'         => array( "<div><?php echo 'x'; ?></div>", "<div><!--?php echo 'x'; ?--></div>" ),
			'XML prolog'  => array( '<svg><?xml version="1.0"?><g/></svg>', '<svg><!--?xml version="1.0"?--><g/></svg>' ),
			'unclosed'    => array( '<div><?php echo 1;</div>', '<div>&lt;?php echo 1;</div>' ),
			'no closing >' => array( 'a <? b', 'a &lt;? b' ),
		);
	}

	/**
	 * Test that markup looking like PHP in page content is written as the comment browsers parse it as.
	 *
	 * @dataProvider data_php_like_markup
	 *
	 * @param string $markup   Markup in the page content.
	 * @param string $expected Markup in the pattern.
	 */
	public function test_generate_pattern_writes_php_like_markup_as_comments( string $markup, string $expected ): void {
		$response = static function () use ( $markup ): array {
			$post = array(
				'slug'        => 'test',
				'title'       => array( 'rendered' => 'Test' ),
				'content_raw' => "<!-- wp:html -->\n{$markup}\n<!-- /wp:html -->",
			);

			return array(
				'headers'  => array(),
				'body'     => wp_json_encode( array( $post ) ),
				'response' => array(
					'code'    => 200,
					'message' => 'OK',
				),
				'cookies'  => array(),
			);
		};
		$file     = wp_tempnam( 'pattern' );

		add_filter( 'pre_http_request', $response );
		ob_start();
		generate_pattern( 'https://example.org/', $file );
		ob_end_clean();
		remove_filter( 'pre_http_request', $response );

		$code = (string) file_get_contents( $file );
		unlink( $file );

		$this->assertStringContainsString( $expected, $code );
		validate_pattern_code( $code );
	}
}
