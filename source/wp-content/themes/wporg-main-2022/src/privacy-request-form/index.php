<?php
/**
 * Block Name: Privacy Request Form
 * Description: Display a GDPR data export or erasure request form.
 *
 * @package wporg
 */

namespace WordPressdotorg\Theme\Main_2022\Privacy_Request_Form;

use function WordPressdotorg\Theme\Main_2022\privacy_process_request;
use function WordPressdotorg\Theme\Main_2022\reCAPTCHA\enqueue_script;
use function WordPressdotorg\Theme\Main_2022\reCAPTCHA\display_submit_button;

add_action( 'init', __NAMESPACE__ . '\init' );

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function init() {
	register_block_type(
		dirname( dirname( __DIR__ ) ) . '/build/privacy-request-form',
		array(
			'render_callback' => __NAMESPACE__ . '\render',
		)
	);
}

/**
 * Render the block content.
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    Block default content.
 * @param WP_Block $block      Block instance.
 *
 * @return string Returns the block markup.
 */
function render( $attributes, $content, $block ) {
	$type = $attributes['type'] ?? 'export';

	if ( ! in_array( $type, [ 'export', 'erase' ], true ) ) {
		return '';
	}

	nocache_headers();

	$form_id = ( 'export' === $type ) ? 'export-request-form' : 'erase-request-form';

	enqueue_script( $form_id );

	$result = privacy_process_request( $type );

	$email         = $result['email'];
	$error_message = $result['error_message'];
	$success       = $result['success'];
	$nonce_action  = $result['nonce_action'];

	if ( ! $email && is_user_logged_in() ) {
		$email = wp_get_current_user()->user_email;
	}

	ob_start();

	if ( $error_message ) {
		printf(
			'<div class="notice notice-error notice-alt"><p>%s</p></div>',
			wp_kses_post( $error_message )
		);
	} elseif ( $success ) {
		printf(
			'<div class="notice notice-success notice-alt"><p>%s</p></div>',
			esc_html__( 'Please check your email for a confirmation link, and follow the instructions to authenticate your request.', 'wporg' )
		);
	}

	if ( ! $success || 'export' === $type ) {
		$submit_text = ( 'export' === $type )
			? __( 'Accept Declaration and Request Export', 'wporg' )
			: __( 'Accept Declaration and Request Permanent Account Deletion', 'wporg' );

		$declaration = ( 'export' === $type )
			? __( 'By submitting this form, you declare that you are the individual owner of the specified email address and its associated accounts; and that all submitted information including any supplemental details necessary to verify your identity are true.', 'wporg' )
			: __( 'By submitting this form, you declare that you are the individual owner of the specified email address and its associated accounts; and that all submitted information including any supplemental details necessary to verify your identity are true. You also declare that it is your intention for accounts associated with that email address to be permanently deleted.', 'wporg' );

		printf(
			'<form id="%s" class="privacy-request-form" method="POST" action="#">',
			esc_attr( $form_id )
		);
		printf(
			'<label for="email">%s</label>',
			esc_html__( 'Email Address', 'wporg' )
		);
		printf(
			'<input type="email" name="email" id="email" placeholder="%s" required value="%s" />',
			/* translators: Example placeholder email address */
			esc_attr__( 'you@example.com', 'wporg' ),
			esc_attr( $email )
		);
		printf( '<p>%s</p>', esc_html( $declaration ) );

		display_submit_button( $submit_text, 'wp-block-button__link wp-element-button' );

		if ( is_user_logged_in() ) {
			wp_nonce_field( $nonce_action );
		}

		echo '</form>';

		printf(
			'<p>%s</p>',
			esc_html__( 'Please Note: Before we can begin processing your request, we&#8217;ll require that you verify ownership of the email address. If the email address is associated with an account, we&#8217;ll also require you to log in to that account first.', 'wporg' )
		);
	}

	$wrapper_attributes = get_block_wrapper_attributes();
	return sprintf( '<div %s>%s</div>', $wrapper_attributes, ob_get_clean() );
}
