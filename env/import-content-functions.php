<?php
/**
 * Import content functions, shared between CLI script and REST API.
 */

/**
 * Filter CURL requests to bypass sandboxes and always hit a production server.
 */
function wporg_env_filter_curl_options( $ch ) {
	curl_setopt( $ch, CURLOPT_CONNECT_TO, array( 'wordpress.org::w.org:' ) );
}

/**
 * Sanitize postmeta from the REST API for the format required by wp_insert_post.
 */
function wporg_env_sanitize_meta_input( $meta ) {
	$meta = array( $meta );
	foreach ( $meta as $k => $v ) {
		if ( is_array( $v ) ) {
			$meta[ $k ] = implode( ',', $v );
		}
	}
	return $meta;
}

/**
 * Import posts from a remote REST API to the local site.
 *
 * @param string $rest_url The remote REST API endpoint URL.
 * @return array Log messages.
 */
function wporg_env_import_rest_to_posts( $rest_url ) {
	$log = array();

	add_action( 'http_api_curl', 'wporg_env_filter_curl_options' );

	$response    = wp_remote_get( $rest_url, array( 'timeout' => 60 ) );
	$status_code = wp_remote_retrieve_response_code( $response );

	if ( is_wp_error( $response ) ) {
		$log[] = 'Error: ' . $response->get_error_message();
		return $log;
	} elseif ( 200 !== $status_code ) {
		$log[] = "Error: HTTP $status_code";
		return $log;
	}

	$data = json_decode( wp_remote_retrieve_body( $response ) );

	foreach ( $data as $post ) {
		$new_post = array(
			'import_id'      => $post->id,
			'post_date'      => gmdate( 'Y-m-d H:i:s', strtotime( $post->date ) ),
			'post_name'      => $post->slug,
			'post_title'     => $post->title->rendered,
			'post_status'    => $post->status,
			'post_type'      => $post->type,
			'post_content'   => ( $post->content_raw ?? $post->content->rendered ),
			'post_excerpt'   => wp_strip_all_tags( $post->excerpt->rendered ),
			'post_parent'    => $post->parent,
			'comment_status' => $post->comment_status,
			'meta_input'     => wporg_env_sanitize_meta_input( $post->meta ),
		);

		$existing_post = get_post( $post->id, ARRAY_A );

		if ( $existing_post ) {
			$new_post = array_merge( $existing_post, $new_post );
			$log[]    = sprintf( 'Updating %s [%s]', html_entity_decode( $post->title->rendered ), $existing_post['ID'] );
		} else {
			$log[] = sprintf( 'Creating %s', html_entity_decode( $post->title->rendered ) );
		}

		$new_post_id = wp_insert_post( $new_post, true );

		if ( is_wp_error( $new_post_id ) ) {
			$log[] = 'Error: ' . $new_post_id->get_error_message();
		} else {
			$log[] = "Inserted {$post->type} {$post->id} as {$new_post_id}";
		}
	}

	return $log;
}
