<?php
/**
 * REST API endpoints for local environment setup and content export.
 *
 * These endpoints replace WP-CLI commands, enabling use with the
 * wp-env Playground runtime (which doesn't support `wp-env run`).
 */

defined( 'WPINC' ) || die();

add_action( 'rest_api_init', 'wporg_env_register_api_routes' );

function wporg_env_register_api_routes() {
	register_rest_route(
		'wporg-env/v1',
		'/setup',
		array(
			'methods'             => 'POST',
			'callback'            => 'wporg_env_api_setup',
			'permission_callback' => 'wporg_env_api_permission_check',
		)
	);

	register_rest_route(
		'wporg-env/v1',
		'/export-patterns',
		array(
			'methods'             => 'POST',
			'callback'            => 'wporg_env_api_export_patterns',
			'permission_callback' => 'wporg_env_api_permission_check',
		)
	);
}

function wporg_env_api_permission_check() {
	return 'local' === wp_get_environment_type();
}

/**
 * Setup the local environment: activate theme, set options, import content.
 */
function wporg_env_api_setup() {
	$log = array();

	// Activate theme.
	switch_theme( 'wporg-main-2022' );
	$log[] = 'Activated theme: wporg-main-2022';

	// Set permalink structure.
	global $wp_rewrite;
	$wp_rewrite->set_permalink_structure( '/%year%/%monthnum%/%postname%/' );
	flush_rewrite_rules( true );
	$log[] = 'Set permalink structure';

	// Update options.
	update_option( 'blogname', 'WordPress.org' );
	update_option( 'blogdescription', 'Blog Tool, Publishing Platform, and CMS' );
	update_option( 'show_on_front', 'page' );
	$log[] = 'Updated site options';

	// Import content from wordpress.org.
	require_once ABSPATH . 'env/import-content-functions.php';

	$urls = array(
		'https://wordpress.org/wp-json/wp/v2/posts?context=wporg_export&per_page=50',
		'https://wordpress.org/wp-json/wp/v2/pages?context=wporg_export&per_page=50',
	);

	foreach ( $urls as $url ) {
		$result = wporg_env_import_rest_to_posts( $url );
		$log    = array_merge( $log, $result );
	}

	// Set front page.
	$home_page = get_posts(
		array(
			'post_type'      => 'page',
			'name'           => 'home',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);

	if ( ! empty( $home_page ) ) {
		update_option( 'page_on_front', $home_page[0] );
		$log[] = 'Front page set to ID: ' . $home_page[0];
	}

	return new WP_REST_Response( array( 'log' => $log ), 200 );
}

/**
 * Export patterns from the page manifest.
 *
 * Accepts the manifest JSON as the request body.
 * Returns an array of files with their paths and content.
 */
function wporg_env_api_export_patterns( $request ) {
	require_once ABSPATH . 'env/export-content/includes/utils.php';

	$manifest_items = json_decode( $request->get_body() );
	if ( empty( $manifest_items ) ) {
		return new WP_Error( 'invalid_manifest', 'Invalid or empty manifest JSON.', array( 'status' => 400 ) );
	}

	$rest_url = 'https://wordpress.org/wp-json/wp/v2/pages?context=wporg_export&slug=%s';
	$files    = array();
	$errors   = array();

	foreach ( $manifest_items as $item ) {
		if ( empty( $item->slug ) ) {
			continue;
		}

		$pattern_filename  = $item->pattern ?? $item->slug . '.php';
		$template_filename = $item->template ?? $item->slug . '.html';

		try {
			$pattern_content = wporg_env_generate_pattern_content( sprintf( $rest_url, $item->slug ) );
			$files[]         = array(
				'type'    => 'pattern',
				'path'    => 'patterns/' . $pattern_filename,
				'content' => $pattern_content,
			);
		} catch ( \Exception $e ) {
			$errors[] = $item->slug . ': ' . $e->getMessage();
		}

		$template_content = wporg_env_generate_template_content( $item->slug );
		$files[]          = array(
			'type'    => 'template',
			'path'    => 'templates/' . $template_filename,
			'content' => $template_content,
		);
	}

	return new WP_REST_Response(
		array(
			'files'  => $files,
			'errors' => $errors,
		),
		empty( $errors ) ? 200 : 207
	);
}

/**
 * Generate pattern content from a REST API URL.
 */
function wporg_env_generate_pattern_content( $url ) {
	$response    = wp_remote_get( $url );
	$status_code = wp_remote_retrieve_response_code( $response );

	if ( is_wp_error( $response ) ) {
		throw new \Exception( $response->get_error_message() );
	} elseif ( 200 !== $status_code ) {
		throw new \Exception( "HTTP Error $status_code" );
	}

	$posts = json_decode( wp_remote_retrieve_body( $response ) );
	$post  = $posts[0] ?? null;

	if ( ! isset( $post->content_raw ) ) {
		throw new \Exception( "No content_raw available at {$url}" );
	}

	$content = WordPress_org\Main_2022\ExportToPatterns\replace_with_i18n( $post->content_raw );

	$header = "<?php\n/**\n * Title: {$post->title->rendered}\n * Slug: wporg-main-2022/{$post->slug}\n * Inserter: no\n */\n\n?>\n\n";

	return $header . $content . "\n";
}

/**
 * Generate template content for a pattern slug.
 */
function wporg_env_generate_template_content( $slug ) {
	return <<<EOF
<!-- wp:wporg/global-header {"style":"black-on-white"} /-->

<!-- wp:group {"tagName":"main","layout":{"inherit":true},"className":"entry-content","style":{"spacing":{"blockGap":"0px"}}} -->
<main class="wp-block-group entry-content">
	<!-- wp:pattern {"slug":"wporg-main-2022/{$slug}"} /-->
</main>
<!-- /wp:group -->

<!-- wp:wporg/global-footer {"style":"black-on-white"} /-->

EOF;
}
