<?php
/**
 * Loader for the environment REST API (Playground runtime).
 *
 * This file is mapped to wp-content/mu-plugins/ via .wp-env.playground.json.
 * It loads the actual implementation from the env/ directory.
 */
if ( file_exists( ABSPATH . 'env/env-api.php' ) ) {
	require_once ABSPATH . 'env/env-api.php';
}
