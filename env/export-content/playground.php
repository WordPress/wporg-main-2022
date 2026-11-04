<?php
/**
 * Runs the pattern export in WordPress Playground, which has no WP-CLI for `wp eval-file`.
 *
 * Usage: npm run build:patterns
 */

declare( strict_types = 1 );

require dirname( __DIR__, 2 ) . '/wp-load.php';

$args = array( dirname( __DIR__ ) . '/page-manifest.json' );

require __DIR__ . '/index.php';
