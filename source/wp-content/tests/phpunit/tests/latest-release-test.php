<?php
/**
 * Test when a locale offers the English latest release.
 */

declare( strict_types = 1 );

use function WordPressdotorg\Theme\Main_2022\get_newer_english_release;

require_once dirname( __DIR__, 3 ) . '/themes/wporg-main-2022/inc/latest-release.php';

/**
 * Tests for comparing a locale's latest release with the English one.
 */
class Latest_Release_Test extends WP_UnitTestCase {
	/**
	 * Define the release constants the wordpress.org config provides.
	 */
	public static function set_up_before_class(): void {
		parent::set_up_before_class();

		if ( ! defined( 'WP_CORE_STABLE_BRANCH' ) ) {
			define( 'WP_CORE_STABLE_BRANCH', '7.1' );
		}
		if ( ! defined( 'WP_CORE_LATEST_RELEASE' ) ) {
			define( 'WP_CORE_LATEST_RELEASE', '7.1.4' );
		}
	}

	/**
	 * Skip if the environment defines different release constants.
	 */
	public function set_up(): void {
		parent::set_up();

		if ( '7.1' !== WP_CORE_STABLE_BRANCH || '7.1.4' !== WP_CORE_LATEST_RELEASE ) {
			$this->markTestSkipped( 'The environment defines its own release constants.' );
		}
	}

	/**
	 * Data provider for a locale's latest release, and the English version it should offer instead.
	 *
	 * @return array
	 */
	public function data_locale_releases(): array {
		return array(
			'no release'                    => array( null, '7.1.4' ),
			'older branch'                  => array( array( 'version' => '7.0.4' ), '7.1.4' ),
			'current branch, older point'   => array( array( 'version' => '7.1.3' ), null ),
			'newer branch, two-digit minor' => array( array( 'version' => '7.10' ), null ),
		);
	}

	/**
	 * Test that only a locale on an older branch offers the English release.
	 *
	 * @dataProvider data_locale_releases
	 *
	 * @param array|null  $locale_latest The locale's latest release.
	 * @param string|null $expected      The English version offered, or null for none.
	 */
	public function test_english_release_for_locales_on_older_branches( ?array $locale_latest, ?string $expected ): void {
		$release = get_newer_english_release( $locale_latest );

		$this->assertSame( $expected, $release['version'] ?? null );
	}
}
