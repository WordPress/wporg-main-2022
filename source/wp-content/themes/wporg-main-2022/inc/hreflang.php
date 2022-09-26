<?php

namespace WordPressdotorg\Theme\Main_2022;

/**
 * Adds hreflang link attributes to WordPress.org pages.
 *
 * @link https://support.google.com/webmasters/answer/189077?hl=en Use hreflang for language and regional URLs.
 * @link https://sites.google.com/site/webmasterhelpforum/en/faq-internationalisation FAQ: Internationalisation.
 */
function hreflang_link_attributes() {
	// No hreflangs on 404 pages.
	if ( is_404() ) {
		return;
	}

	if ( ! defined( 'GLOTPRESS_LOCALES_PATH' ) && 'local' !== wp_get_environment_type() ) {
		return;
	}

	// Don't add these if within a rest-api request which calls `wp_head`. It's never going to be expected.
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		return;
	}

	wp_cache_add_global_groups( array( 'locale-associations' ) );

	// Google doesn't have support for a whole lot of languages and throws errors about it,
	// so we exclude them, as we're otherwise outputting data that isn't used at all.
	$unsupported_languages = array(
		'arq',
		'art',
		'art-xemoji',
		'art-pirate',
		'pirate',
		'ary',
		'ast',
		'az-ir',
		'azb',
		'bal',
		'bcc',
		'bho',
		'brx',
		'dsb',
		'ff-sn',
		'fon',
		'frp',
		'fuc',
		'fur',
		'gax',
		'haz',
		'hsb',
		'ido',
		'io',
		'kaa',
		'kab',
		'li',
		'li-nl',
		'lij',
		'lmo',
		'mai',
		'me',
		'me-me',
		'mfe',
		'nqo',
		'pcd',
		'pcm',
		'rhg',
		'roa',
		'rup',
		'sah',
		'sc-it',
		'scn',
		'skr',
		'srd',
		'syr',
		'szl',
		'tah',
		'twd',
		'ty-tj',
		'tzm',
		'zgh',
	);

	$sites = wp_cache_get( 'local-sites', 'locale-associations' );

	// WARNING: for any changes below, check other uses of the `locale-assosciations` group as there's shared cache keys in use.
	if ( false === $sites ) {
		global $wpdb;

		if ( 'local' === wp_get_environment_type() ) {
			$sites = array();
		} else {
			// phpcs:ignore WordPress.VIP.DirectDatabaseQuery.DirectQuery
			$sites = $wpdb->get_results( 'SELECT locale, subdomain FROM wporg_locales', OBJECT_K );
			if ( ! $sites ) {
				return;
			}

			require_once GLOTPRESS_LOCALES_PATH;

			foreach ( $sites as $key => $site ) {
				$gp_locale = \GP_Locales::by_field( 'wp_locale', $site->locale );
				if ( ! $gp_locale ) {
					unset( $sites[ $key ] );
					continue;
				}

				// Skip non-existing subdomains, e.g. 'de_CH_informal'.
				if ( false !== strpos( $site->subdomain, '_' ) ) {
					unset( $sites[ $key ] );
					continue;
				}

				// Skip unsupported locales.
				if ( in_array( $gp_locale->slug, $unsupported_languages ) ) {
					unset( $sites[ $key ] );
					continue;
				}

				$hreflang = false;

				// Note that Google only supports ISO 639-1 codes.
				if ( isset( $gp_locale->lang_code_iso_639_1 ) && isset( $gp_locale->country_code ) ) {
					$hreflang = $gp_locale->lang_code_iso_639_1 . '-' . $gp_locale->country_code;
				} elseif ( isset( $gp_locale->lang_code_iso_639_1 ) ) {
					$hreflang = $gp_locale->lang_code_iso_639_1;
				} elseif ( isset( $gp_locale->lang_code_iso_639_2 ) ) {
					$hreflang = $gp_locale->lang_code_iso_639_2;
				} elseif ( isset( $gp_locale->lang_code_iso_639_3 ) ) {
					$hreflang = $gp_locale->lang_code_iso_639_3;
				}

				if ( $hreflang ) {
					$sites[ $key ]->hreflang = strtolower( $hreflang );
				} else {
					unset( $sites[ $key ] );
				}
			}
		}

		// Add en_US to the list of sites.
		$sites['en_US'] = (object) array(
			'locale'    => 'en_US',
			'hreflang'  => 'en',
			'subdomain' => '',
		);

		// Add x-default to the list of sites.
		$sites['x-default'] = (object) array(
			'locale'    => 'x-default',
			'hreflang'  => 'x-default',
			'subdomain' => '',
		);

		uasort(
			$sites,
			function( $a, $b ) {
				return strcasecmp( $a->hreflang, $b->hreflang );
			}
		);

		wp_cache_set( 'local-sites', $sites, 'locale-associations' );
	}

	if ( is_singular() ) {
		$path = parse_url( get_permalink(), PHP_URL_PATH );
	} else {
		// WordPress doesn't have a good way to get the canonical version of non-singular urls.
		$path = $_SERVER['REQUEST_URI']; // phpcs:ignore
	}

	foreach ( $sites as $site ) {
		$url = sprintf(
			'https://%swordpress.org%s',
			$site->subdomain ? "{$site->subdomain}." : '',
			$path
		);

		printf(
			'<link rel="alternate" href="%s" hreflang="%s" />' . "\n",
			esc_url( $url ),
			esc_attr( $site->hreflang )
		);
	}
}
add_action( 'wp_head', __NAMESPACE__ . '\hreflang_link_attributes' );
