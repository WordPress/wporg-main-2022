<?php
namespace WordPressdotorg\Theme\Main_2022;

/**
 * Shortcode to display the Market Share number, including the Percent sign.
 */
add_shortcode(
	'market_share',
	function() {
		return number_format_i18n( defined( 'WP_MARKET_SHARE' ) ? WP_MARKET_SHARE : 43 ) . '%';
	}
);

/**
 * Shortcode to display the number of WordPress plugins.
 */
add_shortcode(
	'plugin_count',
	function() {
		return number_format_i18n( defined( 'WP_PLUGIN_COUNT' ) ? WP_PLUGIN_COUNT : 55000 );
	}
);

/**
 * Shortcode to display the latest released version of WordPress.
 */
add_shortcode(
	'latest_version',
	function() {
		global $wp_version;
		return defined( 'WP_CORE_LATEST_RELEASE' ) ? WP_CORE_LATEST_RELEASE : $wp_version;
	}
);
