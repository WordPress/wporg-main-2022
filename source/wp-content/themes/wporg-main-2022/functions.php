<?php

namespace WordPressdotorg\Theme\Main_2022;

/**
 * Actions and filters.
 */
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_assets' );
add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\enqueue_editor_assets' );

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
}

/**
 * Enqueue scripts and styles for the editor.
 */
function enqueue_editor_assets() {
	wp_enqueue_script(
		'wporg-main-2022-formats',
		get_stylesheet_directory_uri() . '/js/custom-formats.js',
		array( 'wp-i18n', 'wp-element', 'wp-rich-text', 'wp-block-editor', 'wp-components' ),
		filemtime( __DIR__ . '/js/custom-formats.js' )
	);
}
