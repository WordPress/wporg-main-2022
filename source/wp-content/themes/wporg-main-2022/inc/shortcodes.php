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
 * Shortcode to display the recommended PHP version.
 */
add_shortcode(
	'recommended_php',
	function() {
		return defined( 'RECOMMENDED_PHP' ) ? RECOMMENDED_PHP : substr( phpversion(), 0, 3 );
	}
);

/**
 * Shortcode to display the recommended MySQL version.
 */
add_shortcode(
	'recommended_mysql',
	function() {
		return '5.7';
	}
);

/**
 * Shortcode to display the recommended MariaDB version.
 */
add_shortcode(
	'recommended_mariadb',
	function() {
		return '10.3';
	}
);

/**
 * Shortcode to display the latest released version of WordPress.
 */
add_shortcode(
	'latest_version',
	function() {
		global $wp_version;
		$latest_release = $wp_version;

		if ( defined( 'WP_CORE_LATEST_RELEASE' ) ) {
			$latest_release = WP_CORE_LATEST_RELEASE;
		}

		if ( defined( 'IS_ROSETTA_NETWORK' ) && IS_ROSETTA_NETWORK && ! empty( $GLOBALS['rosetta'] ) ) {
			$rosetta_release = $GLOBALS['rosetta']->rosetta->get_latest_public_release();
			if ( $rosetta_release ) {
				$latest_release = $rosetta_release['version'];
			}
		}

		return $latest_release;
	}
);

/**
 * Shortcode for a link to the latest version of WordPress.
 */
add_shortcode(
	'download_link',
	function( $attrs = array() ) {
		$ext = ( ! empty( $attrs['type'] ) && 'tar.gz' === $attrs['type'] ) ? 'tar.gz' : 'zip';

		$link = "https://wordpress.org/latest.{$ext}";

		if ( defined( 'IS_ROSETTA_NETWORK' ) && IS_ROSETTA_NETWORK && ! empty( $GLOBALS['rosetta'] ) ) {
			$rosetta_release = $GLOBALS['rosetta']->rosetta->get_latest_public_release();
			if ( $rosetta_release ) {
				$link = home_url( 'latest-' . get_locale() . ".{$ext}" );
			}
		}

		return $link;
	}
);

/**
 * Shortcode for a formatted date & time when the latest version was published.
 */
add_shortcode(
	'latest_version_date',
	function( $attrs = array() ) {
		$format = $attrs['format'] ?? 'Y-m-d\TH:i:s\+00:00';

		$timestamp = defined( 'WPORG_WP_RELEASES_PATH' ) ? filemtime( WPORG_WP_RELEASES_PATH . 'wordpress-' . WP_CORE_LATEST_RELEASE . '.zip' ) : time();

		if ( defined( 'IS_ROSETTA_NETWORK' ) && IS_ROSETTA_NETWORK && ! empty( $GLOBALS['rosetta'] ) ) {
			$rosetta_release = $GLOBALS['rosetta']->rosetta->get_latest_public_release();
			if ( $rosetta_release ) {
				$timestamp = $rosetta_release['builton'];
			}
		}

		return gmdate( $format, $timestamp );
	}
);
