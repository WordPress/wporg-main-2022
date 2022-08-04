#!/usr/bin/php
<?php
// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped

namespace WordPress_org\Main_2022\ImportTestContent;

/**
 * CLI script for generating local test content, fetched from the live learn.wordpress.org site.
 *
 * This needs to be run in a wp-env, for example:
 *
 * yarn run wp-env run cli "php bin/import-test-content.php"
 */

// This script should only be called in a CLI environment.
if ( 'cli' != php_sapi_name() ) {
	die();
}


$opts = getopt( '', array( 'url:' ) );

require dirname( dirname( __FILE__ ) ) . '/wp-load.php';

if ( 'local' !== wp_get_environment_type() ) {
	die( 'Not safe to run on ' . esc_html( get_site_url() ) );
}

if ( empty( $opts['url'] ) || esc_url_raw( $opts['url'], [ 'https' ] ) !== $opts['url'] ) {
	die( 'Invalid url parameter ' . esc_html( $opts['url'] ) );
}

/**
 * Sanitize postmeta from the rest API for the format required by wp_insert_post.
 *
 * @return array An array suitable for meta_input.
 */
function sanitize_meta_input( $meta ) {
	$meta = array( $meta );
	foreach ( $meta as $k => $v ) {
		if ( is_array( $v ) ) {
			$meta[ $k ] = implode( ',', $v );
		}
	}

	return $meta;
}

/**
 * Filter CURL requests to bypass sandboxes and always hit a production server.
 * Docker doesn't use the proxy, so those requests will fail when wordpress.org is sandboxed.
 */
function filter_curl_options( $ch ) {
	curl_setopt( $ch, CURLOPT_CONNECT_TO, array( 'wordpress.org::w.org:' ) );
}

/**
 * Import posts from a remote REST API to the local test site.
 *
 * @param string $rest_url The remote REST API endpoint URL.
 */
function import_rest_to_posts( $rest_url ) {

	add_action( 'http_api_curl', __NAMESPACE__ . '\filter_curl_options' );

	$response = wp_remote_get( $rest_url );
	$status_code = wp_remote_retrieve_response_code( $response );

	if ( is_wp_error( $response ) ) {
		die( esc_html( $response->get_error_message() ) );
	} elseif ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
		die( esc_html( "HTTP Error $status_code \n" ) );
	}

	$body = wp_remote_retrieve_body( $response );
	$data = json_decode( $body );

	foreach ( $data as $post ) {
		echo "Got {$post->type} {$post->id} {$post->slug}\n";

		// Surely there's a neater way to do this.
		$new_post = array(
			'import_id' => $post->id,
			'post_date' => gmdate( 'Y-m-d H:i:s', strtotime( $post->date ) ),
			'post_name' => $post->slug,
			'post_title' => $post->title,
			'post_status' => $post->status,
			'post_type' => $post->type,
			'post_title' => $post->title->rendered,
			'post_content' => ( $post->content_raw ?? $post->content->rendered ),
			'post_excerpt' => wp_strip_all_tags( $post->excerpt->rendered ),
			'post_parent' => $post->parent,
			'comment_status' => $post->comment_status,
			'meta_input' => sanitize_meta_input( $post->meta ),
		);

		$existing_post = get_post( $post->id, ARRAY_A );

		if ( $existing_post ) {
			$new_post = array_merge( $existing_post, $new_post );
			printf(
				"Updating %s [%s]\n",
				html_entity_decode( $post->title->rendered ),
				$existing_post['ID']
			);
		} else {
			printf(
				"Creating %s\n",
				html_entity_decode( $post->title->rendered )
			);
		}

		$new_post_id = wp_insert_post( $new_post, true );

		if ( is_wp_error( $new_post_id ) ) {
			die( esc_html( $new_post_id->get_error_message() ) );
		}

		echo "Inserted $post->type $post->id as $new_post_id\n\n";
	}
}

import_rest_to_posts( $opts['url'] );
