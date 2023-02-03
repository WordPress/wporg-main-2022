<?php

namespace WordPressdotorg\Theme\Main_2022;

defined( 'WPINC' ) || die();

/**
 * Actions and filters.
 */
add_filter( 'map_meta_cap', __NAMESPACE__ . '\map_meta_caps', 20, 4 ); // Needs to fire after meta caps in wporg-internal-notes.
add_action( 'admin_init', __NAMESPACE__ . '\add_or_update_designer_role' );
add_filter( 'rest_request_before_callbacks', __NAMESPACE__ . '\check_caps_for_page_update', 10, 3 );

/**
 * Filter a rest api request, run fine-grained permission checks for Designer users.
 *
 * @param mixed           $response Result to send to the client.
 * @param array           $handler  Route handler used for the request.
 * @param WP_REST_Request $request  Request used to generate the response.
 *
 * @return mixed
 */
function check_caps_for_page_update( $response, $handler, $request ) {
	// Extra permissions check for designers when changing a page.
	// Note: this is specific to the post edit API route. It won't affect other methods of updating a page, such as other endpoints or direct PHP calls.
	// It's probably sufficient for the purpose of this plugin, which is a safety measure, not a security check.
	$user = get_current_user();
	if ( $user && in_array( 'designer', $user->roles ) ) {
		if ( 'PUT' === $request->get_method() && $request->has_param( 'id' ) && $request->get_route() == rest_get_route_for_post( $request->get_param( 'id' ) ) ) {
			if ( 'page' === get_post_type( $request->get_param( 'id' ) ) ) {
				$page = get_post( $request->get_param( 'id' ) );
				if ( $request->has_param( 'status' ) && 'publish' !== $request->get_param( 'status' ) && 'publish' === get_post_status( $page->ID ) ) {
					$response = new \WP_Error(
						'rest_forbidden',
						__( 'Sorry, you are not allowed to change the post status.', 'wporg' ),
						array( 'status' => rest_authorization_required_code() )
					);
				} elseif ( $request->has_param( 'password' ) && $request->get_param( 'password' ) !== $page->post_password ) {
					$response = new \WP_Error(
						'rest_forbidden',
						__( 'Sorry, you are not allowed to change the post password.', 'wporg' ),
						array( 'status' => rest_authorization_required_code() )
					);
				} elseif ( $request->has_param( 'slug' ) && $request->get_param( 'slug' ) !== $page->post_name ) {
					$response = new \WP_Error(
						'rest_forbidden',
						__( 'Sorry, you are not allowed to change the post slug.', 'wporg' ),
						array( 'status' => rest_authorization_required_code() )
					);
				} elseif ( $request->has_param( 'featured_media' ) && $request->get_param( 'featured_media' ) !== get_post_thumbnail_id( $page ) ) {
					$response = new \WP_Error(
						'rest_forbidden',
						__( 'Sorry, you are not allowed to change the featured image.', 'wporg' ),
						array( 'status' => rest_authorization_required_code() )
					);
				} elseif ( $request->has_param( 'template' ) && $request->get_param( 'template' ) !== $page->page_template ) {
					$response = new \WP_Error(
						'rest_forbidden',
						__( 'Sorry, you are not allowed to change the template.', 'wporg' ),
						array( 'status' => rest_authorization_required_code() )
					);
				} elseif ( $request->has_param( 'title' ) && $request->get_param( 'title' ) !== html_entity_decode( $page->post_title ) ) {
					$response = new \WP_Error(
						'rest_forbidden',
						__( 'Sorry, you are not allowed to change the title.', 'wporg' ),
						array( 'status' => rest_authorization_required_code() )
					);
				}
			}
		}
	}
	return $response;
}

/**
 * Map primitive caps to our custom caps.
 *
 * @param array  $required_caps
 * @param string $current_cap
 * @param int    $user_id
 * @param mixed  $args
 *
 * @return mixed
 */
function map_meta_caps( $required_caps, $current_cap, $user_id, $args ) {
	if ( 'edit_page' === $current_cap || 'edit_post' === $current_cap ) {
		// Special safety limits for Designer role when editing pages
		// phpcs:disable WordPress.Security.NonceVerification.Missing
		$user = get_user_by( 'id', $user_id );
		if ( $user && in_array( 'designer', $user->roles ) ) {
			if ( isset( $_SERVER['REQUEST_METHOD'] ) && 'POST' === $_SERVER['REQUEST_METHOD']
				&& isset( $_POST['action'] ) && 'inline-save' === $_POST['action']
				&& isset( $_POST['post_type'] ) && 'page' === $_POST['post_type'] ) {

				if ( isset( $_POST['post_ID'] ) ) {
					$page = get_post( intval( wp_unslash( $_POST['post_ID'] ) ) );
				}

				if ( ! $page ) {
					return $required_caps;
				}

				// The form uses 'default' to mean ''
				if ( '' === $page->page_template ) {
					$page->page_template = 'default';
				}

				// Effectively the same checks as check_caps_for_page_update() above.
				if ( isset( $_POST['_status'] ) && $page->post_status !== $_POST['_status'] ) {
					$required_caps[] = 'do_not_allow';
				} elseif ( isset( $_POST['post_password'] ) && $page->post_password !== $_POST['post_password'] ) {
					$required_caps[] = 'do_not_allow';
				} elseif ( isset( $_POST['post_name'] ) && $page->post_name !== $_POST['post_name'] ) {
					$required_caps[] = 'do_not_allow';
				} elseif ( isset( $_POST['keep_private'] ) && 'private' === $_POST['keep_private'] ) {
					$required_caps[] = 'do_not_allow';
				} elseif ( isset( $_POST['page_template'] ) && $page->page_template !== $_POST['page_template'] ) {
					$required_caps[] = 'do_not_allow';
				} elseif ( isset( $_POST['post_title'] ) && sanitize_title( $page->post_title ) !== sanitize_title( wp_unslash( $_POST['post_title'] ) ) ) {
					$required_caps[] = 'do_not_allow';
				}
			}
		}
	}

	return $required_caps;
}



/**
 * Add the Designer role if it doesn't exist yet, or ensure it has the correct capabilities.
 *
 * Once a role has been added, and is stored in the database, it can't be changed using `add_role` because it
 * will return early.
 *
 * @return \WP_Role|null
 */
function add_or_update_designer_role() {
	$role_caps = get_designer_role_caps();
	$new_role  = get_role( 'designer' );

	if ( is_null( $new_role ) ) {
		$new_role = add_role(
			'designer',
			__( 'Designer', 'wporg' ),
			$role_caps
		);
	} else {
		$caps_to_remove = array_diff(
			array_keys( $new_role->capabilities, true, true ),
			array_keys( $role_caps, true, true )
		);

		foreach ( $caps_to_remove as $remove ) {
			$new_role->remove_cap( $remove );
		}

		$caps_to_add = array_diff(
			array_keys( $role_caps, true, true ),
			array_keys( $new_role->capabilities, true, true )
		);

		foreach ( $caps_to_add as $add ) {
			$new_role->add_cap( $add );
		}
	}

	return $new_role;
}

/**
 * Generate a list of capabilities for the Designer role.
 *
 * A Designer is essentially in between Author and Editor. They can edit existing pages, but can't delete or un-publish something.
 *
 * @return bool[]
 */
function get_designer_role_caps() {
	// Start with an author, and add extra caps.
	$role_caps = get_role( 'author' )->capabilities;

	$role_caps['edit_published_pages'] = true;
	$role_caps['edit_others_pages']    = true;
	$role_caps['publish_pages']        = true;
	$role_caps['edit_pages']           = true;
	unset( $role_caps['delete_posts'] ); // Mainly to prevent deleting media

	return $role_caps;
}
