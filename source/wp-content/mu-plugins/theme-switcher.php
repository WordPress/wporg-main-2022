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
	// Front-page sites only.
	if ( function_exists( '\get_blog_details' ) && '/' !== \get_blog_details( null, false )->path ) {
		return false;
	}

	// Preview. Can't call is_preview() this early in the process.
	if ( isset( $_GET['preview'] ) && isset( $_GET['preview_id'] ) ) {
		return true;
	}

	$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? explode( '?', esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ?? '/' )[0] : '/';

	// By default, the new theme is enabled, but there are some exceptions.
	$old_theme_pages = array(
		'/40-percent-of-web/',
		'/about/privacy/cookies/',
		'/about/privacy/data-erasure-request/',
		'/about/privacy/data-export-request/',
		'/enterprise/content-marketing/',
		'/enterprise/ecommerce/',
		'/enterprise/education/',
		'/enterprise/integrations/',
		'/enterprise/media/',
		'/hosting/',
	);
	if ( in_array( strtolower( $request_uri ), $old_theme_pages ) ) {
		return false;
	}

	// If the new theme is the active theme, we should use it, otherwise, we should use the old theme.
	return ( 'wporg-main-2022' === get_option( 'stylesheet' ) );
}

// Only on sites running the new theme, decide if we need to downgrade to the old one.
if ( 'wporg-main-2022' === get_option( 'stylesheet' ) ) {
	if ( ! should_use_new_theme() ) {
		if ( 'local' === wp_get_environment_type() ) {
			// Enable the old parent & child themes.
			add_filter( 'template', function() { return 'wporg'; } );
			add_filter( 'stylesheet', function() { return 'wporg-main'; } );
		} else {
			// Slightly different paths for old themes on sandbox/producton
			add_filter( 'template', function() { return 'pub/wporg'; } );
			add_filter( 'stylesheet', function() { return 'pub/wporg-main'; } );
		}
	}
}

/**
 * Action to add text indicator to the admin bar when previewing post content (as opposed to a pattern file)
 */
function admin_bar_preview_indicator( $wp_admin_bar ) {
	$text = 'Previewing post content';

	$wp_admin_bar->add_node(
		[
			'id'    => 'preview-indicator',
			'title' => '<span class="ab-icon dashicons-admin-appearance"></span> ' . $text,
			'href'  => get_permalink( get_queried_object_id() ),
			'meta'  => [
				'class' => 'preview-indicator',
			],
		]
	);
}

/**
 * Filter the page template during preview to show the edited post_content rather than pattern file.
 */
function replace_template_content_for_preview( $template ) {
	global $_wp_current_template_content;

	if ( is_preview() ) {
		$count = 0;
		$_wp_current_template_content = preg_replace(
			'#<!-- wp:pattern {"slug":"wporg-main-2022/[\w-]+"} /-->#',
			'<!-- wp:post-content {"layout":{"inherit":true},"style":{"spacing":{"blockGap":"0px"}}} /-->',
			$_wp_current_template_content,
			1,
			$count
		);

		if ( $count > 0 ) {
			$_wp_current_template_content = str_replace( [ '"layout":{"inherit":true},"className":"entry-content",', ' entry-content' ], '', $_wp_current_template_content );
		}

		if ( false !== strpos( $_wp_current_template_content, '<!-- wp:post-content ' ) ) {
			add_action( 'admin_bar_menu', __NAMESPACE__ . '\admin_bar_preview_indicator', 1000 );
		}
	}

	return $template;
}

// Only if the user is logged in and can edit posts:
// Override the block template, to force loading post_content instead of the hard-coded pattern file.
// This is so that content and design can be edited or created in-place.
add_action(
	'init',
	function() {
		if ( current_user_can( 'edit_posts' ) ) {
			add_filter( 'template_include', __NAMESPACE__ . '\replace_template_content_for_preview' );
		}
	}
);
