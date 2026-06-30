<?php
/**
 * Bootstrap a usable local site for WordPress Playground CLI.
 */

require_once '/wordpress/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/plugin.php';

$playground_plugins = array(
	'block-visibility/block-visibility.php',
	'gutenberg/gutenberg.php',
	'handbook/handbook.php',
	'jetpack/jetpack.php',
	'wordpress-importer/wordpress-importer.php',
	'wporg-markdown/plugin.php',
);

foreach ( $playground_plugins as $playground_plugin ) {
	if ( file_exists( WP_PLUGIN_DIR . '/' . $playground_plugin ) && ! is_plugin_active( $playground_plugin ) ) {
		activate_plugin( $playground_plugin, '', false, true );
	}
}

$theme = wp_get_theme( 'wporg-main-2022' );
if ( $theme->exists() && ! $theme->errors() ) {
	switch_theme( 'wporg-main-2022' );
}

update_option( 'blogname', 'WordPress.org Local' );
update_option( 'blogdescription', 'Blog Tool, Publishing Platform, and CMS' );
update_option( 'permalink_structure', '/%year%/%monthnum%/%postname%/' );

$manifest = json_decode( file_get_contents( '/wordpress/env/page-manifest.json' ), true );
$known_slugs = array_column( $manifest, 'slug' );
$prefix_to_path = function( $prefix ) use ( $known_slugs ) {
	$prefix_path = array();

	while ( $prefix ) {
		$matched_slug = '';

		foreach ( $known_slugs as $slug ) {
			if ( $prefix === $slug || str_starts_with( $prefix, $slug . '-' ) ) {
				if ( strlen( $slug ) > strlen( $matched_slug ) ) {
					$matched_slug = $slug;
				}
			}
		}

		if ( ! $matched_slug ) {
			return str_replace( '-', '/', $prefix );
		}

		$prefix_path[] = $matched_slug;
		$prefix = ltrim( substr( $prefix, strlen( $matched_slug ) ), '-' );
	}

	return implode( '/', $prefix_path );
};
$playground_pages = array();
foreach ( $manifest as $manifest_page ) {
	$playground_path = $manifest_page['slug'];

	if ( ! empty( $manifest_page['pattern'] ) ) {
		$pattern_slug = preg_replace( '/\.php$/', '', $manifest_page['pattern'] );
		$suffix       = '-' . $manifest_page['slug'];
		$prefix       = str_ends_with( $pattern_slug, $suffix ) ? substr( $pattern_slug, 0, -strlen( $suffix ) ) : $pattern_slug;

		if ( $prefix && $prefix !== $pattern_slug ) {
			$playground_path = $prefix_to_path( $prefix ) . '/' . $manifest_page['slug'];
		}
	}

	$playground_pages[ $playground_path ] = array(
		'title'    => ucwords( str_replace( '-', ' ', $manifest_page['slug'] ) ),
		'template' => ! empty( $manifest_page['template'] ) && 'front-page.html' !== $manifest_page['template'] ? preg_replace( '/\.html$/', '', $manifest_page['template'] ) : '',
	);
}

$page_ids = array();

foreach ( $playground_pages as $playground_path => $playground_page ) {
	$parts       = explode( '/', $playground_path );
	$slug        = array_pop( $parts );
	$parent_path = implode( '/', $parts );
	$parent_id   = $parent_path && isset( $page_ids[ $parent_path ] ) ? $page_ids[ $parent_path ] : 0;
	$existing    = get_page_by_path( $playground_path );

	if ( $existing ) {
		$page_id = $existing->ID;
		wp_update_post(
			array(
				'ID'          => $page_id,
				'post_title'  => $playground_page['title'],
				'post_parent' => $parent_id,
			)
		);
	} else {
		$page_id = wp_insert_post(
			array(
				'post_type'   => 'page',
				'post_title'  => $playground_page['title'],
				'post_status' => 'publish',
				'post_name'   => $slug,
				'post_parent' => $parent_id,
			)
		);
	}

	if ( ! is_wp_error( $page_id ) ) {
		$page_ids[ $playground_path ] = $page_id;

		if ( ! empty( $playground_page['template'] ) ) {
			update_post_meta( $page_id, '_wp_page_template', $playground_page['template'] );
		}
	}
}

if ( ! empty( $page_ids['home'] ) ) {
	update_option( 'page_on_front', $page_ids['home'] );
	update_option( 'show_on_front', 'page' );
}

flush_rewrite_rules();
