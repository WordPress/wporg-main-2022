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

	// Preview. Can't call is_preview() this early in the process.
	if ( isset( $_GET['preview'] ) && isset( $_GET['preview_id'] ) ) {
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

// Only if the user is logged in and can edit posts:
// Override the block template, to force loading post_content instead of the hard-coded pattern file.
// This is so that content and design can be edited or created in-place.
add_action(
	'init',
	function() {
		if ( current_user_can( 'edit_posts' ) ) {
			add_filter(
				'template_include',
				function( $template ) {
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
							add_action( 'admin_bar_menu', __NAMESPACE__ . '\admin_bar_preview_indicator', 1000 );
						}
					}

					return $template;
				}
			);
		}
	}
);
