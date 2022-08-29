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
	// Request to resolve a template.
	if ( isset( $_GET['_wp-find-template'] ) ) {
		return true;
	}

	// Admin page or an API request.
	if ( is_admin() || wp_is_json_request() ) {
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

// Only if the user is logged in and can edit posts:
// Override the block template, to force loading post_content instead of the hard-coded pattern file.
// This is so that content and design can be edited or created in-place.
// TODO:
// * Make this work cleanly and sensibly for posts that use the old theme;
// * Add a better indicator of post content vs pattern content than 'THIS IS POST CONTENT'
// * Figure out permissions etc so that preview links can be sent to reviewers
add_action(
	'init',
	function() {
		if ( current_user_can( 'edit_posts' ) ) {
			add_filter(
				'template_include',
				function( $template ) {
					global $_wp_current_template_content;

					$_wp_current_template_content = preg_replace(
						'#<!-- wp:pattern {"slug":"wporg-main-2022/[\w-]+"} /-->#',
						'<p>THIS IS POST CONTENT</p><!-- wp:post-content {"layout":{"inherit":true},"style":{"spacing":{"blockGap":"0px"}}} /-->',
						$_wp_current_template_content,
						1
					);

					return $template;
				}
			);
		}
	}
);
