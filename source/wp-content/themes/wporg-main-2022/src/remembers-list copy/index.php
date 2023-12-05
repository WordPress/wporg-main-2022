<?php
/**
 * Block Name: Remembers Contributor List
 * Description: Displays a list of memorialized contributors..
 *
 * @package wporg
 */

namespace WordPressdotorg\Theme\Main_2022\Remembers_List_Block;

add_action( 'init', __NAMESPACE__ . '\init' );

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function init() {
	register_block_type(
		dirname( dirname( __DIR__ ) ) . '/build/remembers-list',
		array(
			'render_callback' => __NAMESPACE__ . '\render',
		)
	);
}

/**
 * Render the block content.
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    Block default content.
 * @param WP_Block $block      Block instance.
 *
 * @return string Returns the block markup.
 */
function render( $attributes, $content, $block ) {

	$json = '[{"ID":"652470","user_nicename":"kpdesign","id":"652470","display_name":"Kim Parsell","date_passing":"2015-01-01 00:00:00"},{"ID":"257","user_nicename":"alexkingorg","id":"257","display_name":"Alex King","date_passing":"2015-01-01 00:00:00"},{"ID":"147442","user_nicename":"peterdog","id":"147442","display_name":"Jesse Petersen","date_passing":"2017-01-01 00:00:00"},{"ID":"12052506","user_nicename":"efrainwp","id":"12052506","display_name":"Efrain Rivera","date_passing":"2018-01-01 00:00:00"},{"ID":"14186165","user_nicename":"todrickmoore","id":"14186165","display_name":"Todrick Moore","date_passing":"2018-01-01 00:00:00"},{"ID":"360","user_nicename":"viper007bond","id":"360","display_name":"Alex Mills","date_passing":"2019-01-01 00:00:00"},{"ID":"10359005","user_nicename":"accessiblejoe","id":"10359005","display_name":"Joseph Karr O\u2019Connor","date_passing":"2020-01-01 00:00:00"},{"ID":"14040689","user_nicename":"davdebcom","id":"14040689","display_name":"David de Boer","date_passing":"2020-01-01 00:00:00"},{"ID":"6347704","user_nicename":"puneetsahalot","id":"6347704","display_name":"Puneet Sahalot","date_passing":"2020-01-01 00:00:00"},{"ID":"7334857","user_nicename":"dan-gaia","id":"7334857","display_name":"Dan Beil","date_passing":"2021-01-01 00:00:00"},{"ID":"1306517","user_nicename":"tumpak","id":"1306517","display_name":"Ujwal Thapa","date_passing":"2021-01-01 00:00:00"},{"ID":"1702","user_nicename":"wolly","id":"1702","display_name":"Paolo Valenti","date_passing":"2022-01-01 00:00:00"},{"ID":"15689130","user_nicename":"jose64","id":"15689130","display_name":"Jos\u00e9 Luis Losada","date_passing":"2023-01-01 00:00:00"}]';

	$profiles = json_decode( $json );

	$columns     = $attributes['columns'];
	$group_count = ceil( count( $profiles ) / $columns );

	$groups = array();
	for ( $i = 0; $i < $group_count; $i++ ) {
		$groups[] = array_slice( $profiles, $i * $columns, $columns );
	}

	$block_content = '';
	foreach ( $groups as $group ) {
		// Set isStackedOnMobile to false so that the columns are not stacked on mobile. We override this in CSS to stack them.
		$block_content .= '<!-- wp:columns {"isStackedOnMobile":false} --><div class="wp-block-columns is-not-stacked-on-mobile">';

		foreach ( $group as $profile ) {
			$block_content .= '<!-- wp:column --><div class="wp-block-column">';
			$block_content .= '<!-- wp:heading {"textAlign":"center","style":{"spacing":{"margin":{"top":"var:preset|spacing|40","right":"var:preset|spacing|default","bottom":"var:preset|spacing|40","left":"var:preset|spacing|default"}}},"fontSize":"extra-large"} -->';
			$block_content .= '<h2 class="wp-block-heading has-text-align-center has-extra-large-font-size" style="margin-top:var(--wp--preset--spacing--40);margin-right:var(--wp--preset--spacing--default);margin-bottom:var(--wp--preset--spacing--40);margin-left:var(--wp--preset--spacing--default)">';
			$block_content .= '<em>';
			$block_content .= '<a href="' . esc_url( 'https://profiles.wordpress.org/' . $profile->user_nicename ) . '">' . esc_html( $profile->display_name ) . '</a>';
			$block_content .= '</em>';
			$block_content .= '</h2>';
			$block_content .= '<!-- /wp:heading -->';
			$block_content .= '</div><!-- /wp:column -->';
		}

		$block_content .= '</div><!-- /wp:columns -->';
	}

	$wrapper_attributes = get_block_wrapper_attributes();
	return sprintf(
		'<div %1$s>%2$s</div>',
		$wrapper_attributes,
		do_blocks( $block_content )
	);
}
