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
add_filter( 'wp_theme_json_data_user', __NAMESPACE__ . '\inject_theme_json' );

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

/**
 * Filter the user data for global styles & settings to inject our local settings
 * without overriding the parent theme.json properties.
 *
 * See https://github.com/WordPress/gutenberg/issues/40557
 *
 * @param WP_Theme_JSON_Data $theme_json Class to access and update the underlying data.
 */
function inject_theme_json( $theme_json ) {
	// Get the combined settings from core + the theme, avoids infinite recursion.
	$settings = \WP_Theme_JSON_Resolver::get_merged_data( 'theme' )->get_settings();

	// Pull out the existing font families, and append the new font.
	$font_families   = $settings['typography']['fontFamilies']['theme'];
	$font_families[] = array(
		'fontFamily' => "'Courier Prime', serif",
		'slug'       => 'courier prime',
		'name'       => 'Courier Prime',
	);

	// Settings array must be formatted like valid JSON object.
	$new_settings = array(
		'$schema'  => 'https://schemas.wp.org/trunk/theme.json',
		'version'  => 2,
		'settings' => array(
			'typography' => array(
				'fontFamilies' => $font_families,
			),
		),
	);

	// Merge the settings into the user JSON.
	$theme_json->update_with( $new_settings );

	return $theme_json;
}
