<?php

namespace WordPressdotorg\Theme\Main_2022;

use function WordPressdotorg\MU_Plugins\Global_Header_Footer\is_rosetta_site;

require_once __DIR__ . '/inc/page-meta-descriptions.php';
require_once __DIR__ . '/inc/hreflang.php';
require_once __DIR__ . '/inc/capabilities.php';

// Block files
require_once __DIR__ . '/src/download-counter/index.php';
require_once __DIR__ . '/src/google-search-embed/index.php';
require_once __DIR__ . '/src/random-heading/index.php';
require_once __DIR__ . '/src/release-tables/index.php';

/**
 * Actions and filters.
 */
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_assets' );
add_action( 'init', __NAMESPACE__ . '\register_shortcodes' );
add_filter( 'wp_img_tag_add_loading_attr', __NAMESPACE__ . '\override_lazy_loading', 10, 2 );

// Enable embeds in patterns.
// See https://github.com/WordPress/gutenberg/issues/46556.
global $wp_embed;
add_filter( 'render_block_core/pattern', array( $wp_embed, 'autoembed' ) );

/**
 * Enqueue scripts and styles.
 */
function enqueue_assets() {
	// The parent style is registered as `wporg-parent-2021-style`, and will be loaded unless
	// explicitly unregistered. We can load any child-theme overrides by declaring the parent
	// stylesheet as a dependency.
	wp_enqueue_style(
		'wporg-main-2022-style',
		get_stylesheet_directory_uri() . '/build/style/style-index.css',
		array( 'wporg-parent-2021-style', 'wporg-global-fonts' ),
		filemtime( __DIR__ . '/build/style/style-index.css' )
	);
	wp_style_add_data( 'wporg-main-2022-style', 'rtl', 'replace' );

	if ( is_page( 'download' ) ) {
		$path        = __DIR__ . '/build/download/index.js';
		$deps_path   = __DIR__ . '/build/download/index.asset.php';
		$script_info = file_exists( $deps_path )
			? require $deps_path
			: array(
				'dependencies' => array(),
				'version'      => filemtime( $path ),
			);

		wp_enqueue_script(
			'wporg-main-2022-download-script',
			get_stylesheet_directory_uri() . '/build/download/index.js',
			$script_info['dependencies'],
			$script_info['version'],
			true
		);

		wp_enqueue_style(
			'wporg-main-2022-download-style',
			get_stylesheet_directory_uri() . '/build/download/style-index.css',
			array(),
			$script_info['version']
		);
		wp_style_add_data( 'wporg-main-2022-download-style', 'rtl', 'replace' );
	}

	if ( is_page( 'stats' ) ) {
		// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
		wp_enqueue_script( 'google-charts', 'https://www.gstatic.com/charts/loader.js', [], null, true );
		wp_enqueue_script( 'wporg-page-stats', get_theme_file_uri( '/js/page-stats.js' ), [ 'jquery', 'google-charts' ], filemtime( __DIR__ . '/js/page-stats.js' ), true );
		wp_localize_script(
			'wporg-page-stats',
			'wporgPageStats',
			[
				'trunk'       => number_format( WP_CORE_STABLE_BRANCH + 0.1, 1 ), /* trunk */
				'viewAsChart' => __( 'View as Chart', 'wporg' ),
				'viewAsTable' => __( 'View as Table', 'wporg' ),
			]
		);
	}

	// Preload the heading font(s).
	if ( is_callable( 'global_fonts_preload' ) ) {
		/* translators: Subsets can be any of cyrillic, cyrillic-ext, greek, greek-ext, vietnamese, latin, latin-ext. */
		$subsets = _x( 'latin', 'Heading font subsets, comma separated', 'wporg' );
		// All headings.
		global_fonts_preload( 'EB Garamond', $subsets );

		if ( is_front_page() ) {
			// The heading on the front-page has some italic.
			global_fonts_preload( 'EB Garamond italic', $subsets );
		}
	}
}

/**
 * Load the shortcodes available for the theme.
 */
function register_shortcodes() {
	include __DIR__ . '/inc/shortcodes.php';
}

/**
 * Prevents adding loading="lazy" to the editor section's background.
 *
 * @param string|bool $value   The `loading` attribute value.
 * @param string      $image   The HTML `img` tag to be filtered.
 *
 * @return string The filtered loading value.
 */
function override_lazy_loading( $value, $image ) {
	if ( str_contains( $image, 'Editor.webp' ) ) {
		// False removes the `loading` attribute entirely.
		return false;
	}
	return $value;
}

/**
 * Prevent Jetpack from looking for a non-existent featured image.
 */
add_filter(
	'jetpack_images_pre_get_images',
	function() {
		return new \WP_Error();
	}
);

/**
 * Register the Rosetta header menu.
 */
add_action(
	'after_setup_theme',
	function() {
		register_nav_menus(
			array(
				'rosetta_main' => 'Rosetta',
			)
		);
	}
);
