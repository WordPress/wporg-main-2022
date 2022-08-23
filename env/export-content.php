#!/usr/bin/php
<?php
// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped

namespace WordPress_org\Main_2022\ImportTestContent;

/**
 * CLI script for exporting post content from the local DB to local pattern/template files.
 *
 * Intended to be run after import-content.php fetches the latest content from a remote prod/staging server.
 *
 * This is a vanilla PHP script, not a WP script.
 *
 */

// This script should only be called in a CLI environment.
if ( 'cli' != php_sapi_name() ) {
	die();
}

$opts = getopt( 'u:o:', array( 'url:', 'output:' ) );

$url = $opts['u'] ?? $opts['url'] ?? null;
$output = $opts['o'] ?? $opts['output'] ?? null;

if ( $url && $output ) {

	$data = file_get_contents( $url );
	if ( !$data ) {
		die( "Unable to fetch {$url}\n" );
	}

	$posts = json_decode( $data );
	$post = $posts[0] ?? null;
	if ( !isset( $post->content_raw ) ) {
		var_dump( $post );
		die( "No content_raw available at {$url}\n" );
	}

	$header = <<<EOF
<?php
/**
 * Title: {$post->title->rendered}
 * Slug: wporg-main-2022/{$post->slug}
 * Categories:
 */

?>

EOF;

	$output_path = $output;
	$bytes = file_put_contents( $output_path, $header . $post->content_raw . "\n" );

	if ( false === $bytes ) {
		die( 'Unable to write to ' . $output_path );
	} else {
		echo 'Wrote ' . number_format( $bytes ) . ' bytes to ' . $output_path . "\n";
	}
}