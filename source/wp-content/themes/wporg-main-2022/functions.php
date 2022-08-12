<?php

namespace WordPressdotorg\Theme\Main_2022;

require_once( __DIR__ . '/inc/page-meta-descriptions.php' );
require_once( __DIR__ . '/inc/hreflang.php' );

/**
 * Actions and filters.
 */
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_assets' );
add_action( 'init', __NAMESPACE__ . '\register_shortcodes' );
add_filter( 'render_block_core/pattern', __NAMESPACE__ . '\prevent_arrow_emoji', 20 );
add_filter( 'wp_omit_loading_attr_threshold', __NAMESPACE__ . '\skip_lazyloading_on_homepage_images' );

/**
 * Enqueue scripts and styles.
 */
function enqueue_assets() {
	// The parent style is registered as `wporg-parent-2021-style`, and will be loaded unless
	// explicitly unregistered. We can load any child-theme overrides by declaring the parent
	// stylesheet as a dependency.
	wp_enqueue_style(
		'wporg-main-2022-style',
		get_stylesheet_uri(),
		array( 'wporg-parent-2021-style', 'wporg-global-fonts' ),
		filemtime( __DIR__ . '/style.css' )
	);

	if ( is_page( 'download' ) ) {
		$path        = __DIR__ . '/build/index.js';
		$deps_path   = __DIR__ . '/build/index.asset.php';
		$script_info = file_exists( $deps_path )
			? require $deps_path
			: array(
				'dependencies' => array(),
				'version'      => filemtime( $path ),
			);

		wp_enqueue_script(
			'wporg-main-2022-script',
			get_stylesheet_directory_uri() . '/build/index.js',
			$script_info['dependencies'],
			$script_info['version'],
			true
		);
	}
}

/**
 * Load the shortcodes available for the theme.
 */
function register_shortcodes() {
	include __DIR__ . '/inc/shortcodes.php';
}

/**
 * Make posts and pages available for export from the staging site, so the import script can
 * fetch them to a local dev environment.
 */
add_filter(
	'wporg_export_context_post_types',
	function( $types ) {
		return array_merge(
			$types,
			[
				'post',
				'page',
			]
		);
	}
);

/**
 * Add the variation-selector unicode character to any arrow. This will force
 * the twemoji script to skip these characters, leaving them as text.
 *
 * Can be removed once the `wp-exclude-emoji` issue is fixed.
 * See https://core.trac.wordpress.org/ticket/52219.
 *
 * @param string $content Content of the current post.
 * @return string The updated content.
 */
function prevent_arrow_emoji( $content ) {
	return preg_replace( '/([←↑→↓↔↕↖↗↘↙])/u', '\1&#65038;', $content );
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
 * Prevent lazy loading the images above the fold as this affects LCP performance.
 */
function skip_lazyloading_on_homepage_images( $omit_threshold ) {
	if ( is_home() ) {
		return 2;
	}

	return $omit_threshold;
}
