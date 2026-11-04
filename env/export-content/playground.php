<?php
/**
 * Runs the pattern export in WordPress Playground, which has no WP-CLI for `wp eval-file`.
 *
 * Usage: npm run playground -- php -- /wordpress/env/export-content/playground.php
 */

declare( strict_types = 1 );

require '/wordpress/wp-load.php';

$args = array( '/wordpress/env/page-manifest.json' );

require __DIR__ . '/index.php';
