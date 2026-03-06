<?php
/**
 * Loader for the environment REST API.
 *
 * The actual implementation lives in env/env-api.php and is mapped via
 * .wp-env.json file mapping for Docker. This loader ensures it also
 * works when the mu-plugins directory is mapped as a whole (e.g. with
 * the Playground runtime).
 */
if ( file_exists( ABSPATH . 'env/env-api.php' ) ) {
	require_once ABSPATH . 'env/env-api.php';
}
