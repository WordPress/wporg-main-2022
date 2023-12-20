<?php

namespace WordPressdotorg\Theme\Main_2022;

defined( 'WPINC' ) || die();

add_filter( 'handbooks_config', __NAMESPACE__ . '\add_data_liberation_handbook' );

/**
 * Configures the Data liberation "handbook" (guides).
 *
 * Requires the site to be running the Handbook & WPORG Markdown plugins.
 */
function add_data_liberation_handbook( $handbooks ) {
	$handbooks['and'] = [
		'label'    => 'Data Liberation Guides',
		'manifest' => 'https://raw.githubusercontent.com/WordPress/data-liberation/add/manifest/assets/manifest.json', // TODO: See https://github.com/WordPress/data-liberation/pull/46
		'slug'     => 'and',
	];

	return $handbooks;
}
