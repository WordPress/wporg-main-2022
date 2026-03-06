<?php
/**
 * Functions for the Privacy Tools - Exports and Erasures.
 *
 * @package WordPressdotorg\Theme\Main_2022
 */

namespace WordPressdotorg\Theme\Main_2022;

use WordPressdotorg\Theme\Main_2022\reCAPTCHA;
use WordPressdotorg\GDPR\Main as GDPR_Main;

/**
 * Processes privacy requests.
 *
 * @param string $type Type of request.
 *
 * @return array
 */
function privacy_process_request( $type ) {
	$email         = false;
	$error_message = false;
	$success       = false;
	$nonce_action  = 'request_' . $type;

	if ( empty( $_POST['email'] ) || ! is_string( $_POST['email'] ) || ! $type || ! in_array( $type, [ 'erase', 'export' ], true ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
		return compact( 'email', 'error_message', 'success', 'nonce_action' );
	}

	$email           = trim( wp_unslash( $_POST['email'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$requesting_user = is_user_logged_in() ? wp_get_current_user()->user_login : false;
	$email_user      = get_user_by( 'email', $email );

	// Check to see if the user is blocked, meaning they cannot log in.
	$blocked_user = false;
	if ( $email_user instanceof \WP_User && defined( 'WPORG_SUPPORT_FORUMS_BLOGID' ) ) {
		$support_user = new \WP_User( $email_user->ID, '', WPORG_SUPPORT_FORUMS_BLOGID );
		if ( ! empty( $support_user->allcaps['bbp_blocked'] ) ) {
			$blocked_user = true;
		}
	}

	if ( ! ReCAPTCHA\check_status() ) {
		$error_message = esc_html__( 'Your form session has expired. Please try again.', 'wporg' );
	} elseif (
		is_user_logged_in() &&
		! wp_verify_nonce( isset( $_POST['_wpnonce'] ) ? wp_unslash( $_POST['_wpnonce'] ) : '', $nonce_action ) // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	) {
		$error_message = esc_html__( 'Your form session has expired. Please try again.', 'wporg' );
	} elseif (
		false !== $email_user && $email_user->user_login !== $requesting_user && ! $blocked_user
	) {
		if ( is_user_logged_in() ) {
			$error_message = sprintf(
				/* translators: %s: link to the Login form */
				__( 'The provided email address belongs to a different WordPress.org account. Please <a href="%s">log in to the account first</a>.', 'wporg' ),
				wp_logout_url( wp_login_url( get_permalink() ) )
			);
		} else {
			$error_message = sprintf(
				/* translators: %s: link to the Login form */
				__( 'The provided email address belongs to a WordPress.org account. Please <a href="%s">log in to the account first</a>.', 'wporg' ),
				wp_login_url( get_permalink() )
			);
		}
	} else {
		if ( 'export' === $type ) {
			$api_method = 'create-data-export-request';
		} elseif ( 'erase' === $type ) {
			$api_method = 'create-account-erasure-request';
		}

		$api_request = GDPR_Main::instance()->call_api_for_site(
			'wordpress.org/',
			[
				'email'           => $email,
				'requesting_user' => $requesting_user,
			],
			$api_method,
			'POST'
		);

		if ( is_wp_error( $api_request ) ) {
			$error_message = $api_request->get_error_message();

			if ( 'duplicate_request' === $api_request->get_error_code() ) {
				$error_message = esc_html__( 'A request for this email address already exists. Please check your spam folder for your confirmation email.', 'wporg' );
			} elseif ( 'invalid_identifier' === $api_request->get_error_code() ) {
				$error_message = esc_html__( 'The provided email was invalid. Please check the address and try again.', 'wporg' );
			}
		} elseif ( ! empty( $api_request['created'] ) ) {
			$success = true;
		}
	}

	return compact( 'email', 'error_message', 'success', 'nonce_action' );
}
