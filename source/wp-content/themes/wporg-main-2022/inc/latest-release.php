<?php
/**
 * The latest release a site offers for download.
 *
 * @package WordPressdotorg\Theme\Main_2022
 */

declare( strict_types = 1 );

namespace WordPressdotorg\Theme\Main_2022;

/**
 * Get the English latest release, if a locale's latest release is on an older branch.
 *
 * Point releases aren't compared, so a locale doesn't switch to English in the hours before it builds one.
 *
 * @param array|null $locale_latest The locale's latest release, if it has one.
 *
 * @return array|null The English release in the format of a locale release, or null if the locale has the current branch.
 */
function get_newer_english_release( ?array $locale_latest ): ?array {
	if ( ! defined( 'WP_CORE_LATEST_RELEASE' ) || ! defined( 'WP_CORE_STABLE_BRANCH' ) ) {
		return null;
	}

	if ( preg_match( '/^\d+\.\d+/', (string) ( $locale_latest['version'] ?? '' ), $branch ) && version_compare( $branch[0], WP_CORE_STABLE_BRANCH, '>=' ) ) {
		return null;
	}

	$version = WP_CORE_LATEST_RELEASE;

	return array(
		'version'   => $version,
		'builton'   => get_english_release_date( $version ),
		'zip_url'   => "https://wordpress.org/wordpress-{$version}.zip",
		'targz_url' => "https://wordpress.org/wordpress-{$version}.tar.gz",
		'english'   => true,
	);
}

/**
 * Get when an English release was built, from its zip.
 *
 * @param string $version Release version.
 *
 * @return int|null Unix timestamp, or null if the zip isn't on this server.
 */
function get_english_release_date( string $version ): ?int {
	$zip = defined( 'WPORG_WP_RELEASES_PATH' ) ? WPORG_WP_RELEASES_PATH . "wordpress-{$version}.zip" : '';

	return $zip && file_exists( $zip ) ? (int) filemtime( $zip ) : null;
}

/**
 * Get the locale's latest public release, unless it's on an older branch than the English one.
 *
 * @return array|null The locale's release, or null on wordpress.org, or when the site should offer the English release.
 */
function get_locale_latest_release(): ?array {
	if ( ! defined( 'IS_ROSETTA_NETWORK' ) || ! IS_ROSETTA_NETWORK || empty( $GLOBALS['rosetta'] ) ) {
		return null;
	}

	$release = $GLOBALS['rosetta']->rosetta->get_latest_public_release();
	if ( ! $release || get_newer_english_release( $release ) ) {
		return null;
	}

	return $release;
}

/**
 * Whether the locale's translation of WordPress is inactive: it has releases, but none recent enough to offer.
 *
 * @return bool True on a Rosetta site whose latest release is too old to offer.
 */
function is_inactive_locale(): bool {
	if ( ! defined( 'IS_ROSETTA_NETWORK' ) || ! IS_ROSETTA_NETWORK || empty( $GLOBALS['rosetta'] ) ) {
		return false;
	}

	$rosetta = $GLOBALS['rosetta']->rosetta;

	return ! $rosetta->get_latest_public_release() && (bool) $rosetta->get_latest_release();
}
