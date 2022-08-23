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

$opts = getopt( 'u:o:', array( 'url:', 'output:', 'manifest:', 'rest_url:', 'pattern_path:' ) );

$url = $opts['u'] ?? $opts['url'] ?? null;
$output = $opts['o'] ?? $opts['output'] ?? null;
$manifest = $opts['manifest'] ?? null;
$rest_url = $opts['rest_url'] ?? 'http://wordpress.org/main-test/wp-json/wp/v2/pages?context=wporg_export&slug=%s';
$pattern_path = $opts['pattern_path'] ?? 'source/wp-content/themes/wporg-main-2022/patterns/%s';

function generate_pattern( $url, $output_path ) {

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

	$bytes = file_put_contents( $output_path, $header . $post->content_raw . "\n" );

	if ( false === $bytes ) {
		die( 'Unable to write to ' . $output_path );
	} else {
		echo 'Wrote ' . number_format( $bytes ) . ' bytes to ' . $output_path . "\n";
	}
}

if ( $url && $output ) {
	generate_pattern( $url, $output );
} elseif ( $manifest ) {
	$manifest_data = file_get_contents( $manifest );
	$manifest_items = json_decode( $manifest_data );
	if ( !$manifest_data || !$manifest_items ) {
		die( "Unable to read manifest from $manifest/n" );
	}

	foreach( $manifest_items as $item ) {
		if ( $item->slug ) {
			$pattern = $item->pattern ?? $item->slug . '.php';
			$template = $item->template ?? $item->slug . '.html';
			var_dump( sprintf( $rest_url, $item->slug ), sprintf( $pattern_path, $pattern ) );
			generate_pattern( sprintf( $rest_url, $item->slug ), sprintf( $pattern_path, $pattern ) );
		}
	}
}