<?php
/**
 * Test the BlockParser class and related functions.
 */

use WordPress_org\Main_2022\ExportToPatterns\BlockParser;
use function WordPress_org\Main_2022\ExportToPatterns\replace_with_i18n;

require dirname( __DIR__ ) . '/includes/parser.php';

class BlockParser_Test extends WP_UnitTestCase {
	/**
	 * Data provider for valid block content, and the expected strings when parsed.
	 *
	 * @return array
	 */
	public function data_block_content_strings() {
		return [
			[
				// Two plain paragraphs.
				"<!-- wp:paragraph -->\n<p>One.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Two.</p>\n<!-- /wp:paragraph -->",
				[ 'One.', 'Two.' ],
			],
			[
				// A paragraph with nested HTML.
				"<!-- wp:paragraph -->\n<p>A paragraph with <strong>bold</strong> text.</p>\n<!-- /wp:paragraph -->",
				[ 'A paragraph with <strong>bold</strong> text.' ],
			],
			[
				// A paragraph with a nested link.
				"<!-- wp:paragraph -->\n<p>A paragraph with <a href=\"#\">a link</strong>.</p>\n<!-- /wp:paragraph -->",
				[ 'A paragraph with <a href="#">a link</strong>.' ],
			],
			[
				// Empty paragraph.
				"<!-- wp:paragraph -->\n<p></p>\n<!-- /wp:paragraph -->\n",
				[],
			],
			[
				// Buttons.
				"<!-- wp:buttons -->\n<div class=\"wp-block-buttons\"><!-- wp:button -->\n<div class=\"wp-block-button\"><a class=\"wp-block-button__link wp-element-button\" href=\"https://w.org/test/\">Button 1</a></div>\n<!-- /wp:button -->\n\n<!-- wp:button -->\n<div class=\"wp-block-button\"><a class=\"wp-block-button__link wp-element-button\" href=\"#anchor\">Button 2</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons -->",
				[ 'Button 1', 'https://w.org/test/', 'Button 2' ],
			],
			[
				// Column with a list, list-items.
				"<!-- wp:column {\"verticalAlignment\":\"center\",\"width\":\"50%\",\"style\":{\"spacing\":{\"padding\":{\"right\":\"60px\"}}}} -->\n<div class=\"wp-block-column is-vertically-aligned-center\" style=\"padding-right:60px;flex-basis:50%\"><!-- wp:list {\"className\":\"is-style-features\"} -->\n<ul class=\"is-style-features\"><!-- wp:list-item -->\n<li>Simple</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li>Intuitive</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li>Extendable</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li>Free</li>\n<!-- /wp:list-item -->\n\n<!-- wp:list-item -->\n<li>Open</li>\n<!-- /wp:list-item --></ul>\n<!-- /wp:list --></div>\n<!-- /wp:column -->",
				[ 'Simple', 'Intuitive', 'Extendable', 'Free', 'Open' ],
			],
			[
				// Image block with an alt.
				"<!-- wp:image {\"width\":150,\"height\":45,\"linkDestination\":\"custom\"} -->\n<figure class=\"wp-block-image is-resized\"><a href=\"#\"><img src=\"./badge-apple.png\" alt=\"Download on the Apple App Store\" width=\"150\" height=\"45\" /></a></figure>\n<!-- /wp:image -->",
				[ 'Download on the Apple App Store' ],
			],
			[
				// Navigation with custom navigation links.
				"<!-- wp:navigation {\"textColor\":\"blueberry-1\",\"overlayMenu\":\"never\",\"className\":\"is-style-dots\",\"style\":{\"spacing\":{\"blockGap\":\"0px\"}},\"fontSize\":\"small\"} -->\n<!-- wp:navigation-link {\"label\":\"Releases\",\"url\":\"https://wordpress.org/download/releases/\",\"kind\":\"custom\",\"isTopLevelLink\":true} /-->\n\n<!-- wp:navigation-link {\"label\":\"Nightly\",\"url\":\"https://wordpress.org/download/beta-nightly/\",\"kind\":\"custom\",\"isTopLevelLink\":true} /-->\n\n<!-- wp:navigation-link {\"label\":\"Counter\",\"url\":\"https://wordpress.org/download/counter/\",\"kind\":\"custom\",\"isTopLevelLink\":true} /-->\n\n<!-- wp:navigation-link {\"label\":\"Source\",\"url\":\"https://wordpress.org/download/source/\",\"kind\":\"custom\",\"isTopLevelLink\":true} /-->\n<!-- /wp:navigation -->",
				[ 'Releases', 'Nightly', 'Counter', 'Source' ],
			],
			[
				// Cover with background image (with alt), and nested paragraph.
				"<!-- wp:cover {\"url\":\"http://localhost:8878/wp-content/uploads/2022/10/kerstin-wrba-zeInZepl_Hw-unsplash-scaled.jpg\",\"id\":7,\"dimRatio\":50,\"overlayColor\":\"tertiary\",\"isDark\":false} -->\n<div class=\"wp-block-cover is-light\"><span aria-hidden=\"true\" class=\"wp-block-cover__background has-tertiary-background-color has-background-dim\"></span><img class=\"wp-block-cover__image-background wp-image-7\" alt=\"Some alt.\" src=\"http://localhost:8878/wp-content/uploads/2022/10/kerstin-wrba-zeInZepl_Hw-unsplash-scaled.jpg\" data-object-fit=\"cover\"/><div class=\"wp-block-cover__inner-container\"><!-- wp:paragraph {\"align\":\"center\",\"fontSize\":\"large\"} -->\n<p class=\"has-text-align-center has-large-font-size\">Testing a Cover</p>\n<!-- /wp:paragraph --></div></div>\n<!-- /wp:cover -->",
				[ 'Some alt.', 'Testing a Cover' ],
			],
			[
				// Social links.
				"<!-- wp:social-links {\"className\":\"is-style-logos-only\"} -->\n<ul class=\"wp-block-social-links is-style-logos-only\">\n<!-- wp:social-link {\"url\":\"https://www.facebook.com/WordPress/\",\"service\":\"facebook\",\"label\":\"Visit our Facebook page\"} /-->\n<!-- wp:social-link {\"url\":\"https://twitter.com/WordPress\",\"service\":\"twitter\",\"label\":\"Visit our Twitter account\"} /-->\n</ul>\n<!-- /wp:social-links -->",
				[ 'Visit our Facebook page', 'Visit our Twitter account' ],
			],
			[
				// List with links
				"<!-- wp:list -->\n<ul>\n<!-- wp:list-item -->\n<li><a href=\"#\">Fonts API</a></li>\n<!-- /wp:list-item -->\n<!-- wp:list-item -->\n<li>Interactivity <a href=\"#\">Link</a> API</li>\n<!-- /wp:list-item -->\n<!-- wp:list-item -->\n<li><a href=\"\">Block API</a></li>\n<!-- /wp:list-item --></ul>\n<!-- /wp:list -->",
				[ '<a href="#">Fonts API</a>', 'Interactivity <a href="#">Link</a> API', '<a href="">Block API</a>' ],
			],
			[
				// List of lists
				"<!-- wp:list -->\n<ul><!-- wp:list-item -->\n<li>APIs:<!-- wp:list -->\n<ul>\n<!-- wp:list-item -->\n<li>Fonts API</li>\n<!-- /wp:list-item -->\n<!-- wp:list-item -->\n<li>Interactivity API</li>\n<!-- /wp:list-item -->\n<!-- wp:list-item -->\n<li>Block API</li>\n<!-- /wp:list-item --></ul>\n<!-- /wp:list --></li>\n<!-- /wp:list-item -->\n</ul>\n<!-- /wp:list -->",
				[ 'APIs:', 'Fonts API', 'Interactivity API', 'Block API' ],
			],
			[
				"<!-- wp:table -->\n<figure class=\"wp-block-table\"><table><thead><tr><th>Cookie</th><th>Logged-in Users Only?</th></tr></thead><tbody><tr><th>welcome-{blog_id}</th><td>No</td></tr><tr><th>showComments</th><td>No</td></tr></tbody></table></figure>\n<!-- /wp:table -->",
				[ 'Cookie', 'Logged-in Users Only?', 'welcome-{blog_id}', 'No', 'showComments' ],
			],
		];
	}

	/**
	 * Test string parsing from valid block content.
	 *
	 * @dataProvider data_block_content_strings
	 */
	public function test_strings_parser( $block_content, $expected ) {
		$parser = new BlockParser( $block_content );
		$strings = $parser->to_strings();
		$this->assertSame( $expected, $strings );
	}

	/**
	 * Data provider for valid block content and the i18n-ized results.
	 *
	 * @return array
	 */
	public function data_block_content_i18n() {
		return [
			[
				// Two plain paragraphs.
				"<!-- wp:paragraph -->\n<p>One.</p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p>Two.</p>\n<!-- /wp:paragraph -->",
				"<!-- wp:paragraph -->\n<p><?php _e( 'One.', 'wporg' ); ?></p>\n<!-- /wp:paragraph -->\n\n<!-- wp:paragraph -->\n<p><?php _e( 'Two.', 'wporg' ); ?></p>\n<!-- /wp:paragraph -->",
			],
			[
				// Image block with an alt.
				"<!-- wp:image {\"width\":150,\"height\":45,\"linkDestination\":\"custom\"} -->\n<figure class=\"wp-block-image is-resized\"><a href=\"#\"><img src=\"./badge-apple.png\" alt=\"Download on the Apple App Store\" width=\"150\" height=\"45\" /></a></figure>\n<!-- /wp:image -->",
				"<!-- wp:image {\"width\":150,\"height\":45,\"linkDestination\":\"custom\"} -->\n<figure class=\"wp-block-image is-resized\"><a href=\"#\"><img src=\"./badge-apple.png\" alt=\"<?php _e( 'Download on the Apple App Store', 'wporg' ); ?>\" width=\"150\" height=\"45\" /></a></figure>\n<!-- /wp:image -->",
			],
			[
				// Navigation with custom navigation links.
				"<!-- wp:navigation {\"textColor\":\"blueberry-1\",\"overlayMenu\":\"never\",\"className\":\"is-style-dots\",\"style\":{\"spacing\":{\"blockGap\":\"0px\"}},\"fontSize\":\"small\"} -->\n<!-- wp:navigation-link {\"label\":\"Releases\",\"url\":\"#\",\"kind\":\"custom\",\"isTopLevelLink\":true} /-->\n<!-- /wp:navigation -->",
				"<!-- wp:navigation {\"textColor\":\"blueberry-1\",\"overlayMenu\":\"never\",\"className\":\"is-style-dots\",\"style\":{\"spacing\":{\"blockGap\":\"0px\"}},\"fontSize\":\"small\"} -->\n<!-- wp:navigation-link {\"label\":\"<?php _e( 'Releases', 'wporg' ); ?>\",\"url\":\"#\",\"kind\":\"custom\",\"isTopLevelLink\":true} /-->\n<!-- /wp:navigation -->",
			],
			[
				// List with links
				"<!-- wp:list -->\n<ul>\n<!-- wp:list-item -->\n<li><a href=\"#\">Fonts API</a></li>\n<!-- /wp:list-item -->\n<!-- wp:list-item -->\n<li>Interactivity <a href=\"#\">Link</a> API</li>\n<!-- /wp:list-item -->\n<!-- wp:list-item -->\n<li><a href=\"\">Block API</a></li>\n<!-- /wp:list-item --></ul>\n<!-- /wp:list -->",
				"<!-- wp:list -->\n<ul>\n<!-- wp:list-item -->\n<li><?php _e( '<a href=\"#\">Fonts API</a>', 'wporg' ); ?></li>\n<!-- /wp:list-item -->\n<!-- wp:list-item -->\n<li><?php _e( 'Interactivity <a href=\"#\">Link</a> API', 'wporg' ); ?></li>\n<!-- /wp:list-item -->\n<!-- wp:list-item -->\n<li><?php _e( '<a href=\"\">Block API</a>', 'wporg' ); ?></li>\n<!-- /wp:list-item --></ul>\n<!-- /wp:list -->",
			],
			[
				// List of lists
				"<!-- wp:list -->\n<ul><!-- wp:list-item -->\n<li>APIs:<!-- wp:list -->\n<ul>\n<!-- wp:list-item -->\n<li>Fonts API</li>\n<!-- /wp:list-item -->\n<!-- wp:list-item -->\n<li>Interactivity API</li>\n<!-- /wp:list-item -->\n<!-- wp:list-item -->\n<li>Block API</li>\n<!-- /wp:list-item --></ul>\n<!-- /wp:list --></li>\n<!-- /wp:list-item -->\n</ul>\n<!-- /wp:list -->\n",
				"<!-- wp:list -->\n<ul><!-- wp:list-item -->\n<li><?php _e( 'APIs:', 'wporg' ); ?><!-- wp:list -->\n<ul>\n<!-- wp:list-item -->\n<li><?php _e( 'Fonts API', 'wporg' ); ?></li>\n<!-- /wp:list-item -->\n<!-- wp:list-item -->\n<li><?php _e( 'Interactivity API', 'wporg' ); ?></li>\n<!-- /wp:list-item -->\n<!-- wp:list-item -->\n<li><?php _e( 'Block API', 'wporg' ); ?></li>\n<!-- /wp:list-item --></ul>\n<!-- /wp:list --></li>\n<!-- /wp:list-item -->\n</ul>\n<!-- /wp:list -->\n",
			],
			[
				// Buttons.
				"<!-- wp:buttons -->\n<div class=\"wp-block-buttons\"><!-- wp:button -->\n<div class=\"wp-block-button\"><a class=\"wp-block-button__link wp-element-button\" href=\"https://w.org/test/\">Button 1</a></div>\n<!-- /wp:button -->\n\n<!-- wp:button -->\n<div class=\"wp-block-button\"><a class=\"wp-block-button__link wp-element-button\" href=\"#anchor\">Button 2</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons -->",
				"<!-- wp:buttons -->\n<div class=\"wp-block-buttons\"><!-- wp:button -->\n<div class=\"wp-block-button\"><a class=\"wp-block-button__link wp-element-button\" href=\"<?php _e( 'https://w.org/test/', 'wporg' ); ?>\"><?php _e( 'Button 1', 'wporg' ); ?></a></div>\n<!-- /wp:button -->\n\n<!-- wp:button -->\n<div class=\"wp-block-button\"><a class=\"wp-block-button__link wp-element-button\" href=\"#anchor\"><?php _e( 'Button 2', 'wporg' ); ?></a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons -->",
			],
			[
				"<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><!-- wp:paragraph -->\m<p>I'm interested in running the open-source WordPress &lt;https://wordpress.org/&gt; web software and I was wondering if my account supported the following:</p>\n<!-- /wp:paragraph --></blockquote>\n<!-- /wp:quote -->",
				"<!-- wp:quote -->\n<blockquote class=\"wp-block-quote\"><!-- wp:paragraph -->\m<p><?php _e( 'I&#039;m interested in running the open-source WordPress &lt;https://wordpress.org/&gt; web software and I was wondering if my account supported the following:', 'wporg' ); ?></p>\n<!-- /wp:paragraph --></blockquote>\n<!-- /wp:quote -->",
			],
			[
				// Block with repeated strings.
				"<!-- wp:table -->\n<figure class=\"wp-block-table\"><table><thead><tr><th>Cookie</th><th>Logged-in Users Only?</th></tr></thead><tbody><tr><th>welcome-{blog_id}</th><td>No</td></tr><tr><th>showComments</th><td>No</td></tr></tbody></table></figure>\n<!-- /wp:table -->",
				"<!-- wp:table -->\n<figure class=\"wp-block-table\"><table><thead><tr><th><?php _e( 'Cookie', 'wporg' ); ?></th><th><?php _e( 'Logged-in Users Only?', 'wporg' ); ?></th></tr></thead><tbody><tr><th><?php _e( 'welcome-{blog_id}', 'wporg' ); ?></th><td><?php _e( 'No', 'wporg' ); ?></td></tr><tr><th><?php _e( 'showComments', 'wporg' ); ?></th><td><?php _e( 'No', 'wporg' ); ?></td></tr></tbody></table></figure>\n<!-- /wp:table -->",
			],
			[
				// Link Wrapper block with child content.
				'<!-- wp:wporg/link-wrapper {"align":"full"} --><a class="wp-block-wporg-link-wrapper alignfull" href="https://wordpress.org/news/2024/05/wordcamp-europe-2024-mid-year-update-and-qa-with-matt-mullenweg/"><!-- wp:paragraph --><p>Matt Mullenweg at WordCamp Europe—streaming live June 15</p><!-- /wp:paragraph --></a><!-- /wp:wporg/link-wrapper -->',
				'<!-- wp:wporg/link-wrapper {"align":"full"} --><a class="wp-block-wporg-link-wrapper alignfull" href="<?php _e( \'https://wordpress.org/news/2024/05/wordcamp-europe-2024-mid-year-update-and-qa-with-matt-mullenweg/\', \'wporg\' ); ?>"><!-- wp:paragraph --><p><?php _e( \'Matt Mullenweg at WordCamp Europe—streaming live June 15\', \'wporg\' ); ?></p><!-- /wp:paragraph --></a><!-- /wp:wporg/link-wrapper -->',
			],
		];
	}

	/**
	 * Test the i18n replacement.
	 *
	 * @dataProvider data_block_content_i18n
	 */
	public function test_i18n_replacement( $block_content, $expected ) {
		$content_with_i18n = replace_with_i18n( $block_content );
		$this->assertSame( $expected, $content_with_i18n );
	}

	/**
	 * Data provider for valid block content and the i18n-ized results.
	 *
	 * @return array
	 */
	public function data_block_content_i18n_with_shortcode() {
		return [
			[
				"<!-- wp:paragraph -->\n<p>Recommend PHP [recommended_php] or greater and MySQL [recommended_mysql] or MariaDB version [recommended_mariadb] or greater.</p>\n<!-- /wp:paragraph -->",
				"<!-- wp:paragraph -->\n<p><?php\n/* translators: [recommended_php], [recommended_mysql], [recommended_mariadb] are shortcodes and should not be translated. */\n_e( 'Recommend PHP [recommended_php] or greater and MySQL [recommended_mysql] or MariaDB version [recommended_mariadb] or greater.', 'wporg' );\n?></p>\n<!-- /wp:paragraph -->",
			],
			[
				"<!-- wp:list-item -->\n<li>Recommend PHP [recommended_php] or greater.</li>\n<!-- /wp:list-item -->",
				"<!-- wp:list-item -->\n<li><?php\n/* translators: [recommended_php] is a shortcode and should not be translated. */\n_e( 'Recommend PHP [recommended_php] or greater.', 'wporg' );\n?></li>\n<!-- /wp:list-item -->",
			],
			[
				// Buttons.
				"<!-- wp:buttons -->\n<div class=\"wp-block-buttons\"><!-- wp:button -->\n<div class=\"wp-block-button\"><a class=\"wp-block-button__link wp-element-button\" href=\"[download_link]\">Download WordPress [latest_version]</a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons -->",
				"<!-- wp:buttons -->\n<div class=\"wp-block-buttons\"><!-- wp:button -->\n<div class=\"wp-block-button\"><a class=\"wp-block-button__link wp-element-button\" href=\"[download_link]\"><?php\n/* translators: [latest_version] is a shortcode and should not be translated. */\n_e( 'Download WordPress [latest_version]', 'wporg' );\n?></a></div>\n<!-- /wp:button --></div>\n<!-- /wp:buttons -->",
			],
		];
	}

	/**
	 * Test the i18n replacement.
	 *
	 * @dataProvider data_block_content_i18n_with_shortcode
	 */
	public function test_i18n_replacement_with_shortcode( $block_content, $expected ) {
		$content_with_i18n = replace_with_i18n( $block_content );
		$this->assertSame( $expected, $content_with_i18n );
	}
}
