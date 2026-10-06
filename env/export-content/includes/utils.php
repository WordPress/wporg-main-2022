<?php
// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped

namespace WordPress_org\Main_2022\ExportToPatterns;

use Exception;

require_once __DIR__ . '/parser.php';

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
 *
 * @throws Exception If the request fails or writing the file fails.
 *
 * @param string $url The REST API endpoint URL for the post.
 * @param string $output_path The local file path to write the pattern to.
 * @param bool   $add_title Whether to add the page title when the content has no H1, as page.html does.
 */
function generate_pattern( $url, $output_path, $add_title = true ) {
	$response = wp_remote_get( $url );

	$status_code = wp_remote_retrieve_response_code( $response );

	if ( is_wp_error( $response ) ) {
		throw new Exception( esc_html( $response->get_error_message() ) );
	} elseif ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
		throw new Exception( esc_html( "HTTP Error $status_code \n" ) );
	}

	$data = wp_remote_retrieve_body( $response );

	if ( ! $data ) {
		throw new Exception( esc_html( "Unable to fetch {$url}\n" ) );
	}

	$posts = json_decode( $data );
	$post = $posts[0] ?? null;
	if ( ! isset( $post->content_raw ) ) {
		var_dump( $post );
		throw new Exception( esc_html( "No content_raw available at {$url}\n" ) );
	}

	// WordPress won't register a pattern with an empty Title header, which leaves the page blank.
	if ( '' === trim( $post->title->rendered ) ) {
		throw new Exception( esc_html( "The page at {$url} has no title. Set one in the editor.\n" ) );
	}

	$content = $post->content_raw;
	if ( $add_title && ! has_h1( $content ) ) {
		$content = add_page_title( $content, html_entity_decode( $post->title->rendered, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
	}

	$content = replace_with_i18n( $content );

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
		throw new Exception( esc_html( 'Unable to write to ' . $output_path ) );
	} else {
		echo 'Wrote ' . size_format( $bytes ) . ' to ' . $output_path . "\n";
	}
}

/**
 * Create a page template to use this pattern.
 *
 * @param string $slug The slug of the pattern to include.
 * @param string $output_path The local file path to write the template to.
 */
function generate_template( $slug, $output_path ) {
	$template = <<<EOF
<!-- wp:wporg/global-header /-->

<!-- wp:group {"tagName":"main","layout":{"inherit":true},"className":"entry-content","style":{"spacing":{"blockGap":"0px"}}} -->
<main class="wp-block-group entry-content">
	<!-- wp:pattern {"slug":"wporg-main-2022/{$slug}"} /-->
</main>
<!-- /wp:group -->

<!-- wp:wporg/global-footer /-->

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

/**
 * Whether content has its own H1.
 *
 * @param string $content Raw block content.
 * @return bool
 */
function has_h1( string $content ): bool {
	return (bool) preg_match( '/<h1[\s>]/i', $content );
}

/**
 * Wrap content in page.html's padding, below an H1 with the page title.
 *
 * The inner group mirrors page.html's post-content block, which keeps wide and full-width blocks to the content width.
 *
 * @param string $content Raw block content.
 * @param string $title   Page title, as plain text.
 * @return string Block content.
 */
function add_page_title( string $content, string $title ): string {
	$title = esc_html( $title );

	return <<<EOF
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","right":"var:preset|spacing|edge-space","left":"var:preset|spacing|edge-space","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--edge-space);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:heading {"level":1,"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|30"}}}} -->
<h1 class="wp-block-heading" style="margin-bottom:var(--wp--preset--spacing--30)">{$title}</h1>
<!-- /wp:heading -->

<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group">{$content}</div>
<!-- /wp:group --></div>
<!-- /wp:group -->
EOF;
}
