<?php
// phpcs:disable WordPress.Files.FileName -- Allow underscore for pattern partial.
/**
 * Title: Inactive locale notice
 * Slug: wporg-main-2022/inactive-locale-notice
 * Inserter: no
 *
 * Tells visitors of a locale site whose translation is inactive to download the English release.
 */

declare( strict_types = 1 );

use function WordPressdotorg\Theme\Main_2022\is_inactive_locale;

if ( ! is_inactive_locale() ) {
	return;
}

$locale_name = $GLOBALS['rosetta']->rosetta->get_glotpress_locale()->english_name;

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|edge-space","left":"var:preset|spacing|edge-space"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--edge-space);padding-left:var(--wp--preset--spacing--edge-space)">
	<!-- wp:wporg/notice {"type":"alert","align":"wide"} -->
	<div class="wp-block-wporg-notice alignwide is-alert-notice">
		<div class="wp-block-wporg-notice__icon"></div>
		<div class="wp-block-wporg-notice__content">
			<p>
			<?php
			printf(
				wp_kses_post(
					/* translators: 1: Language name, in English. 2: URL of the Polyglots team. 3: URL of the English download page. */
					__( 'This translation of WordPress is currently inactive. If you’re interested in translating WordPress to %1$s, join the <a href="%2$s">Polyglots team</a> and find out how. <a href="%3$s">Download the English (US) version instead</a>.', 'wporg' )
				),
				esc_html( $locale_name ),
				esc_url( 'https://make.wordpress.org/polyglots/' ),
				esc_url( 'https://wordpress.org/download/' )
			);
			?>
			</p>
		</div>
	</div>
	<!-- /wp:wporg/notice -->
</div>
<!-- /wp:group -->
