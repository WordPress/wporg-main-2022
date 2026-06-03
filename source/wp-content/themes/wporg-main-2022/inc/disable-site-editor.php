<?php

namespace WordPressdotorg\Theme\Main_2022;

defined( 'WPINC' ) || die();

/**
 * Disable the Site Editor for this theme.
 *
 * Templates and template parts for this site are managed as files in the theme
 * (and via the content-update pipeline), not in the database. Editing them in the
 * Site Editor creates database overrides that diverge from the source files and can
 * silently break the automated content export (e.g. emptying a page's content when it
 * is moved onto a Site Editor template). To prevent that, the Site Editor is disabled.
 *
 * Note: super admins bypass normal capability checks, so simply hiding the menu or
 * relying on `current_user_can()` is not enough. The redirect and REST guards below
 * return regardless of the current user, and the capability mapping uses `do_not_allow`,
 * which is the one primitive cap a super admin is still denied.
 */

/**
 * Actions and filters.
 */
add_action( 'admin_menu', __NAMESPACE__ . '\remove_site_editor_menu', 999 );
add_action( 'admin_bar_menu', __NAMESPACE__ . '\remove_site_editor_admin_bar', 999 );
add_action( 'admin_init', __NAMESPACE__ . '\block_site_editor_screen' );
add_filter( 'map_meta_cap', __NAMESPACE__ . '\block_template_editing_caps', 10, 4 );
add_filter( 'rest_request_before_callbacks', __NAMESPACE__ . '\block_template_rest_writes', 10, 3 );

/**
 * Remove the "Editor" (Site Editor) item from the Appearance menu.
 */
function remove_site_editor_menu() {
	remove_submenu_page( 'themes.php', 'site-editor.php' );
}

/**
 * Remove the "Edit site" link from the admin bar.
 *
 * @param \WP_Admin_Bar $wp_admin_bar The admin bar instance.
 */
function remove_site_editor_admin_bar( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'site-editor' );
}

/**
 * Block direct access to the Site Editor screen.
 *
 * This fires for every request to `site-editor.php` regardless of the current user,
 * so it also stops super admins and the post editor's "Edit template" deep links.
 */
function block_site_editor_screen() {
	global $pagenow;

	if ( 'site-editor.php' === $pagenow ) {
		wp_safe_redirect( admin_url() );
		exit;
	}
}

/**
 * Deny the capabilities to edit or delete existing templates and template parts.
 *
 * Returning `do_not_allow` is the only way to deny these caps for a super admin, who
 * would otherwise pass any `current_user_can()` check.
 *
 * @param string[] $required_caps The mapped primitive capabilities.
 * @param string   $cap           The requested meta capability.
 * @param int      $user_id       The user ID.
 * @param array    $args          Context, where `$args[0]` is usually the object ID.
 *
 * @return string[]
 */
function block_template_editing_caps( $required_caps, $cap, $user_id, $args ) {
	$object_meta_caps = array( 'edit_post', 'delete_post', 'publish_post' );

	if ( in_array( $cap, $object_meta_caps, true ) && ! empty( $args[0] ) ) {
		$post = get_post( $args[0] );
		if ( $post && in_array( $post->post_type, array( 'wp_template', 'wp_template_part' ), true ) ) {
			return array( 'do_not_allow' );
		}
	}

	return $required_caps;
}

/**
 * Block REST writes to the templates and template-parts endpoints.
 *
 * The Site Editor saves entirely through these endpoints, so this stops template changes
 * even if the editor UI is reached some other way. It returns a `WP_Error` directly, which
 * applies to every user including super admins. Reads (GET) are left alone.
 *
 * @param mixed            $response The current response, possibly a WP_Error from an earlier filter.
 * @param array            $handler  The matched route handler.
 * @param \WP_REST_Request $request  The request being dispatched.
 *
 * @return mixed
 */
function block_template_rest_writes( $response, $handler, $request ) {
	if ( is_wp_error( $response ) ) {
		return $response;
	}

	if ( ! in_array( $request->get_method(), array( 'POST', 'PUT', 'PATCH', 'DELETE' ), true ) ) {
		return $response;
	}

	if ( preg_match( '#/wp/v2/(templates|template-parts)(/|$)#', $request->get_route() ) ) {
		return new \WP_Error(
			'rest_forbidden',
			__( 'Editing templates is disabled. Templates are managed in the theme files.', 'wporg' ),
			array( 'status' => rest_authorization_required_code() )
		);
	}

	return $response;
}
