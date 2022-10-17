<?php
/**
 * Block Name: Download Counter
 * Description: Display the download counter for a given WordPress version.
 *
 * @package wporg
 */

namespace WordPressdotorg\Theme\Main_2022\Download_Counter_Block;

use WP_REST_Request;

add_action( 'init', __NAMESPACE__ . '\init' );
add_action( 'rest_api_init', __NAMESPACE__ . '\add_counter_endpoint' );

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function init() {
	register_block_type(
		dirname( dirname( __DIR__ ) ) . '/build/download-counter',
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
	if ( ! empty( $block->block_type->view_script ) ) {
		wp_enqueue_script( $block->block_type->view_script );
		// Move to footer.
		wp_script_add_data( $block->block_type->view_script, 'group', 1 );
	}

	$branch = WP_CORE_STABLE_BRANCH;
	// If set, use the URL query string parameter for the branch.
	// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	if ( isset( $_GET['branch'] ) && validate_branch( wp_unslash( $_GET['branch'] ) ) ) {
		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$branch = wp_unslash( $_GET['branch'] );
	}

	$wrapper_attributes = get_block_wrapper_attributes();
	return sprintf(
		'<div %1$s data-branch="%2$s">%3$s</div>',
		$wrapper_attributes,
		$branch,
		get_download_count( $branch )
	);
}

/**
 * Validate that the given string is a valid branch.
 *
 * @param string $branch
 *
 * @return boolean
 */
function validate_branch( $branch ) {
	return (
		preg_match( '/^[0-9]+\.[0-9]$/', $branch ) &&
		version_compare( WP_CORE_STABLE_BRANCH, $branch, '>=' )
	);
}

/**
 * Set up the counter endpoints.
 */
function add_counter_endpoint() {
	register_rest_route(
		'wporg/v1',
		'/core-downloads/',
		array(
			'methods' => 'GET',
			'callback' => function( WP_REST_Request $request ) {
				return get_download_count( WP_CORE_STABLE_BRANCH );
			},
			'permission_callback' => '__return_true',
		)
	);
	register_rest_route(
		'wporg/v1',
		'/core-downloads/(?P<branch>[0-9.]+)',
		array(
			'methods' => 'GET',
			'callback' => function( WP_REST_Request $request ) {
				$branch = $request->get_param( 'branch' );
				return get_download_count( $branch ?? WP_CORE_STABLE_BRANCH );
			},
			'permission_callback' => '__return_true',
			'args' => array(
				'branch' => array(
					'validate_callback' => function( $param, $request, $key ) {
						return validate_branch( $param );
					},
				),
			),
		)
	);
}

/**
 * Return the current download count for a branch.
 *
 * @param string $branch A version number, will fetch download count for this version.
 *
 * @return WP_Error|int The download count (or error).
 */
function get_download_count( $branch ) {
	global $wpdb;

	if ( 'local' === wp_get_environment_type() ) {
		// Generate a semi-random number like a download count.
		// 8 digits to have a suitably long number, based on the current time so it generally trends upward.
		// Add a random offset so the number changes more every 5 seconds.
		$num = substr( time(), -9 ) + rand( 10, 100 );
	} else {
		$num = $wpdb->get_var(
			$wpdb->prepare(
				'SELECT SUM(downloads) FROM download_counts WHERE `release` LIKE %s AND `release` NOT LIKE %s',
				$wpdb->esc_like( $branch ) . '%',
				'%-%'
			)
		);
	}

	return esc_html( number_format_i18n( $num ) );
}
