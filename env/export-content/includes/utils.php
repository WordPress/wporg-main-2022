<?php
// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped

namespace WordPress_org\Main_2022\ExportToPatterns;

require __DIR__ . '/parser.php';

/**
 * Filter CURL requests to bypass sandboxes and always hit a production server.
 * Docker doesn't use the proxy, so those requests will fail when wordpress.org is sandboxed.
 */
function filter_curl_options( $ch ) {
	curl_setopt( $ch, CURLOPT_CONNECT_TO, array( 'wordpress.org::w.org:' ) );
}
add_action( 'http_api_curl', __NAMESPACE__ . '\filter_curl_options' );

/**
 * Generate the pattern content from a URL.
 */
function generate_pattern( $url, $output_path ) {
	$response = wp_remote_get( $url );

	$status_code = wp_remote_retrieve_response_code( $response );

	if ( is_wp_error( $response ) ) {
		die( esc_html( $response->get_error_message() ) );
	} elseif ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
		die( esc_html( "HTTP Error $status_code \n" ) );
	}

	$data = wp_remote_retrieve_body( $response );

	if ( ! $data ) {
		die( "Unable to fetch {$url}\n" );
	}

	$posts = json_decode( $data );
	$post = $posts[0] ?? null;
	if ( ! isset( $post->content_raw ) ) {
		var_dump( $post );
		die( "No content_raw available at {$url}\n" );
	}

	$parser = new BlockParser();
	$content = $parser->replace_with_i18n( $post->content_raw );

	$header = <<<EOF
<?php
/**
 * Title: {$post->title->rendered}
 * Slug: wporg-main-2022/{$post->slug}
 * Inserter: no
 */

?>

EOF;

	$bytes = file_put_contents( $output_path, $header . $content . "\n" );

	if ( false === $bytes ) {
		die( 'Unable to write to ' . $output_path );
	} else {
		echo 'Wrote ' . size_format( $bytes ) . ' to ' . $output_path . "\n";
	}
}

/**
 * Create a page template to use this pattern.
 */
function generate_template( $slug, $output_path ) {
	$template = <<<EOF
<!-- wp:wporg/global-header {"style":"black-on-white"} /-->

<!-- wp:group {"tagName":"main","layout":{"inherit":true},"className":"entry-content","style":{"spacing":{"blockGap":"0px"}}} -->
<main class="wp-block-group entry-content">
	<!-- wp:pattern {"slug":"wporg-main-2022/{$slug}"} /-->
</main>
<!-- /wp:group -->

<!-- wp:wporg/global-footer {"style":"black-on-white"} /-->

EOF;

	// 'x' mode so we don't overwrite an existing file
	if ( $fp = @fopen( $output_path, 'x' ) ) { // phpcs:ignore
		$bytes = fwrite( $fp, $template );
		fclose( $fp );
		echo 'Wrote ' . size_format( $bytes ) . ' to ' . $output_path . "\n";
	} else {
		echo "Skipping $output_path\n";
	}
}
