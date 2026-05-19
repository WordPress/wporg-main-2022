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

/*
 * Rewrite production wordpress.org URLs to the local site URL so links in
 * imported content navigate to the local copy instead of leaving to prod.
 *
 * Only paths that match a published page or post on the local site are
 * rewritten — paths that belong to other sites in the production network
 * (e.g. /news/, /patterns/, /plugins/, /themes/, /support/, /documentation/,
 * /five-for-the-future/) are left pointing at wordpress.org so they still
 * resolve. Subdomains (make./developer./learn./events.) are never matched
 * by the regex.
 */
add_action(
	'template_redirect',
	function () {
		if ( is_admin() || wp_doing_ajax() || wp_is_json_request() ) {
			return;
		}

		$local_paths = array( '/' => true );
		$ids = get_posts(
			array(
				'post_type'   => array( 'page', 'post' ),
				'post_status' => 'publish',
				'numberposts' => -1,
				'fields'      => 'ids',
			)
		);
		foreach ( $ids as $id ) {
			$path = wp_parse_url( get_permalink( $id ), PHP_URL_PATH );
			if ( $path ) {
				$local_paths[ $path ] = true;
			}
		}

		ob_start(
			function ( $buffer ) use ( $local_paths ) {
				$home = home_url();
				return preg_replace_callback(
					'~https?://wordpress\.org(/[^"\s\'<>)#?]*)?~',
					function ( $m ) use ( $local_paths, $home ) {
						$path = $m[1] ?? '';
						$key  = ( '' === $path || '/' === $path ) ? '/' : ( rtrim( $path, '/' ) . '/' );
						if ( isset( $local_paths[ $key ] ) ) {
							return $home . $path;
						}
						return $m[0];
					},
					$buffer
				);
			}
		);
	}
);
