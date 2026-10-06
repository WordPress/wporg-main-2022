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
 * @throws Exception If the request fails, the generated code is unexpected, or writing the file fails.
 *
 * @param string    $url The REST API endpoint URL for the post.
 * @param string    $output_path The local file path to write the pattern to.
 * @param bool|null $add_title Whether to add the page title above the content, as page.html does. Null adds it when the content has no H1.
 */
function generate_pattern( $url, $output_path, $add_title = null ) {
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

	// Pattern files are PHP; only the export's own translation calls should open PHP in them.
	$content = str_replace( '<?', '&lt;?', $post->content_raw );
	if ( $add_title ?? ! has_h1( $content ) ) {
		$content = add_page_title( $content, html_entity_decode( $post->title->rendered, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
	}

	$code = get_pattern_header( $post->title->rendered, $post->slug ) . replace_with_i18n( $content ) . "\n";
	validate_pattern_code( $code );

	$bytes = file_put_contents( $output_path, $code );

	if ( false === $bytes ) {
		throw new Exception( esc_html( 'Unable to write to ' . $output_path ) );
	} else {
		echo 'Wrote ' . size_format( $bytes ) . ' to ' . $output_path . "\n";
	}
}

/**
 * Build the docblock header of a pattern file.
 *
 * @param string $title Pattern title.
 * @param string $slug  Page slug.
 * @return string PHP header.
 */
function get_pattern_header( string $title, string $slug ): string {
	// Keep the title to a single header line inside the docblock. Splitting `*/` can't form a new one, unlike removing it.
	$title = str_replace( array( '*/', "\r", "\n" ), array( '* /', ' ', ' ' ), $title );

	return <<<EOF
<?php
/**
 * Title: {$title}
 * Slug: wporg-main-2022/{$slug}
 * Inserter: no
 */

?>

EOF;
}

/**
 * Make sure generated pattern code only contains the PHP the export writes: string literals passed to translation functions, and translator comments.
 *
 * @throws Exception If the code contains any other PHP.
 *
 * @param string $code Pattern file contents.
 */
function validate_pattern_code( string $code ): void {
	$functions = array( '__', '_e', 'esc_attr_e', 'esc_html_e', 'esc_url' );
	$tokens    = array( T_OPEN_TAG, T_CLOSE_TAG, T_INLINE_HTML, T_WHITESPACE, T_COMMENT, T_DOC_COMMENT, T_ECHO, T_CONSTANT_ENCAPSED_STRING );

	foreach ( token_get_all( $code ) as $token ) {
		if ( is_array( $token ) ) {
			$allowed = T_STRING === $token[0] ? in_array( $token[1], $functions, true ) : in_array( $token[0], $tokens, true );
			$text    = $token[1];

			// With short_open_tag off, `<?` is tokenized as HTML, but a server with it on would run what follows.
			if ( ( T_INLINE_HTML === $token[0] && str_contains( $text, '<?' ) ) || ( T_OPEN_TAG === $token[0] && '<?php' !== rtrim( $text ) ) ) {
				$allowed = false;
			}
		} else {
			$allowed = in_array( $token, array( '(', ')', ',', ';' ), true );
			$text    = $token;
		}

		if ( ! $allowed ) {
			throw new Exception( esc_html( "Unexpected PHP in the generated pattern: {$text}\n" ) );
		}
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
 * Whether content renders its own H1.
 *
 * @param string $content Raw block content.
 * @return bool
 */
function has_h1( string $content ): bool {
	return preg_match( '/<h1[\s>]/i', $content ) || blocks_render_h1( parse_blocks( $content ) );
}

/**
 * Whether any of the blocks renders an H1 dynamically.
 *
 * Synced patterns and pattern references count too: their content isn't in the page, so it may hold one.
 *
 * @param array[] $blocks Parsed blocks.
 * @return bool
 */
function blocks_render_h1( array $blocks ): bool {
	foreach ( $blocks as $block ) {
		$is_h1_title = 'core/post-title' === $block['blockName'] && 1 === ( $block['attrs']['level'] ?? 2 );

		if (
			$is_h1_title ||
			in_array( $block['blockName'], array( 'wporg/random-heading', 'core/block', 'core/pattern' ), true ) ||
			blocks_render_h1( $block['innerBlocks'] )
		) {
			return true;
		}
	}

	return false;
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
