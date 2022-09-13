<?php
// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped

namespace WordPress_org\Main_2022\ExportToPatterns;

require __DIR__ . '/parser.php';

/**
 * Generate the pattern content from a URL.
 */
function generate_pattern( $url, $output_path ) {
	$data = file_get_contents( $url );

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
 * Categories:
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
