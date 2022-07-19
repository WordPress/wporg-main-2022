<?php
// phpcs:disable Generic.Functions.OpeningFunctionBraceKernighanRitchie.ContentAfterBrace
// phpcs:disable Generic.Formatting.DisallowMultipleStatements.SameLine
/**
 * Theme switcher
 *
 * Switch back to old theme unless we're on the "new theme" pages. This allows
 * us to still use the Site Editor in wp-admin, which is not available if the
 * active theme is not a block-based theme.
 */

namespace WordPressdotorg\MU_Plugins\Theme_Switcher;

/**
 * Helper to check the requested page against our new page list.
 */
function should_use_new_theme() {
	if ( is_admin() ) {
		return true;
	}

	$new_theme_pages = array(
		'/',
		'/download/',
	);

	return isset( $_SERVER['REQUEST_URI'] ) && in_array( $_SERVER['REQUEST_URI'], $new_theme_pages );
}

// Always show admin bar.
add_filter( 'show_admin_bar', '__return_true' );

if ( 'production' !== wp_get_environment_type() ) {
	if ( ! should_use_new_theme() ) {
		// Enable the old parent & child themes.
		add_filter( 'template', function() { return 'wporg'; } );
		add_filter( 'stylesheet', function() { return 'wporg-main'; } );
	}
}
