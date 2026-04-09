<?php
/**
 * These are stubs for closed source code, or things that only apply to local environments.
 */

defined( 'WPINC' ) || die();

/*
 * In production these are defined by the WordPress.org sandbox config; locally
 * we derive them from the WordPress version that wp-env actually installed,
 * so the values stay in sync instead of drifting against a hard-coded number.
 *
 * $wp_version is set in wp-includes/version.php, which loads before mu-plugins.
 * Examples: "6.9.2" → "6.9", "6.10-RC1" → "6.10", "7.0-alpha-12345" → "7.0".
 */
if ( ! defined( 'WP_CORE_STABLE_BRANCH' ) || ! defined( 'WP_CORE_LATEST_RELEASE' ) ) {
	global $wp_version;
	if ( isset( $wp_version ) && preg_match( '/^(\d+\.\d+)/', $wp_version, $m ) ) {
		if ( ! defined( 'WP_CORE_STABLE_BRANCH' ) ) {
			define( 'WP_CORE_STABLE_BRANCH', $m[1] );
		}
		if ( ! defined( 'WP_CORE_LATEST_RELEASE' ) ) {
			define( 'WP_CORE_LATEST_RELEASE', $m[1] );
		}
	}
}

require_once WPMU_PLUGIN_DIR . '/pub/servehappy-config.php';
require_once WPMU_PLUGIN_DIR . '/wporg-mu-plugins/mu-plugins/loader.php';
