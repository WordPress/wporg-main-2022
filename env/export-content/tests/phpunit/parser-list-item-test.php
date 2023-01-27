<?php

defined( 'WPINC' ) || die();

require_once __DIR__ . '../../parsers/ListItem.php';

class Test_Parser_List_Item extends WP_UnitTestCase {

	/**
	 * @covers WordPress_org\Main_2022\ExportToPatterns\Parsers\ListItem\replace_strings
	 */
	public function test_totp_setup_returns_expected_data() : void {
		$parser       = new ListItem();
		$block        = array(
			'blockName'    => 'core/list-item',
			'innerHTML'    => '<li><a href="https://learn.wordpress.org/">Learn with WordPress ↗</a></li>',
			'innerContent' => array( '<li><a href="https://learn.wordpress.org/">Learn with WordPress ↗</a></li>' ),
		);
		$replacements = array(
			'<a href="https://learn.wordpress.org/">Learn with WordPress ↗</a>' => '<?php _e( "<a href="https://learn.wordpress.org/">Learn with WordPress ↗</a>", "wporg" ); ?>',
		);

		$parsed_block = $parser->replace_strings( $block, $replacements );

		$this->assertSame(
			$parsed_block,
			array(
				'blockName'    => 'core/list-item',
				'innerHTML'    => '<li><?php _e( "<a href="https://learn.wordpress.org/">Learn with WordPress ↗</a>", "wporg" ); ?></li>',
				'innerContent' => array( '<li><?php _e( "<a href="https://learn.wordpress.org/">Learn with WordPress ↗</a>", "wporg" ); ?></li>' ),
			),
		);
	}
}
