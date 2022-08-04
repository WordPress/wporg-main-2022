<?php
/**
 * Custom meta descriptions.
 *
 * @package WordPressdotorg\MainTheme
 */

namespace WordPressdotorg\Theme\Main_2022;

use WordPressdotorg\API\Serve_Happy\RECOMMENDED_PHP;

/**
 * Add custom open-graph tags for page templates where the content is hard-coded.
 *
 * This is also defined here to allow it to be used on pages where the page template is not included for that page, such as the embed template.
 *
 * @param array $tags Optional. Open Graph tags.
 * @return array Filtered Open Graph tags.
 */
function custom_open_graph_tags( $tags = [] ) {
	$site_title = function_exists( '\WordPressdotorg\site_brand' ) ? \WordPressdotorg\site_brand() : 'WordPress.org';

	// Use `name=""` for description.
	// See Jetpacks Twitter Card for where it happens for the twitter:* fields.
	add_filter(
		'jetpack_open_graph_output',
		function( $html ) {
			return str_replace( '<meta property="description"', '<meta name="description"', $html );
		}
	);

	$post = get_post();

	// Override the Front-page tags.
	if ( is_front_page() ) {
		$desc = get_the_excerpt( $post ) ?: __( 'Open source software which you can use to easily create a beautiful website, blog, or app.', 'wporg' );
		return array(
			'og:type'         => 'website',
			'og:title'        => __( 'Blog Tool, Publishing Platform, and CMS', 'wporg' ) . " - {$site_title}",
			'og:description'  => $desc,
			'description'     => $desc,
			'og:url'          => home_url( '/' ),
			'og:site_name'    => $site_title,
			'og:image'        => 'https://s.w.org/images/home/screen-themes.png?3',
			'og:locale'       => get_locale(),
			'twitter:card'    => 'summary_large_image',
			'twitter:creator' => '@WordPress',
		);
	}

	if ( ! $post || 'page' !== $post->post_type ) {
		return $tags;
	}

	// These values are not correct for our page templates.
	unset( $tags['article:published_time'], $tags['article:modified_time'] );

	$title = get_the_title();
	$desc = get_the_excerpt();

	$tags['og:title']            = $title;
	$tags['twitter:text:title']  = $title;
	$tags['og:description']      = $desc;
	$tags['twitter:description'] = $desc;
	$tags['description']         = $desc;

	return $tags;
}
add_filter( 'jetpack_open_graph_tags', __NAMESPACE__ . '\custom_open_graph_tags' );
// Enable Jetpack opengraph by default
add_filter( 'jetpack_enable_open_graph', '__return_true' );

/**
 * Renders site's attributes for the WordPress.org frontpages (including Rosetta).
 *
 * @see https://developers.google.com/search/docs/guides/enhance-site
 */
function sites_attributes_schema() {
	global $rosetta;

	if ( ! is_front_page() ) {
		return;
	}

	$og_tags         = custom_open_graph_tags();
	$locale_language = 'en';
	$name            = 'WordPress.org';

	if ( ! empty( $rosetta->rosetta->glotpress_locale ) ) {
		$locale_language = $rosetta->rosetta->glotpress_locale->slug;
		$name            = sprintf(
			/* translators: %s: locale native name */
			__( 'WordPress - %s', 'wporg' ),
			$rosetta->rosetta->glotpress_locale->native_name
		);
	}

	?>
<script type="application/ld+json">
{
	"@context":"https://schema.org",
	"@graph":[
		{
			"@type":"Organization",
			"@id":"https://wordpress.org/#organization",
			"url":"https://wordpress.org/",
			"name":"WordPress",
			"logo":{
				"@type":"ImageObject",
				"@id":"https://wordpress.org/#logo",
				"url":"https://s.w.org/style/images/about/WordPress-logotype-wmark.png"
			},
			"sameAs":[
				"https://www.facebook.com/WordPress/",
				"https://twitter.com/WordPress",
				"https://en.wikipedia.org/wiki/WordPress"
			]
		},
		{
			"@type":"WebSite",
			"@id":"<?php echo esc_js( home_url( '/#website' ) ); ?>",
			"url":"<?php echo esc_js( home_url( '/' ) ); ?>",
			"name":"<?php echo esc_js( $name ); ?>",
			"publisher":{
				"@id":"https://wordpress.org/#organization"
			}
		},
		{
			"@type":"WebPage",
			"@id":"<?php echo esc_js( home_url( '/' ) ); ?>",
			"url":"<?php echo esc_js( home_url( '/' ) ); ?>",
			"inLanguage":"<?php echo esc_js( $locale_language ); ?>",
			"name":"<?php echo esc_js( $og_tags['og:title'] ); ?>",
			"description":"<?php echo esc_js( $og_tags['og:description'] ); ?>",
			"isPartOf":{
				"@id":"<?php echo esc_js( home_url( '/#website' ) ); ?>"
			}
		}
	]
}
</script>
	<?php
}
add_action( 'wp_head', __NAMESPACE__ . '\sites_attributes_schema' );

/**
 * Maps page titles to translatable strings.
 *
 * @param string      $title The post title.
 * @param WP_Post|int $post  Optional. Post object or ID.
 * @return string Filtered post tile.
 */
function custom_page_title( $title, $post = null ) {
	if ( ! $post ) {
		return $title;
	}

	$post = get_post( $post );
	if ( ! $post || 'page' !== $post->post_type ) {
		return $title;
	}

	switch ( $post->page_template ) {
		case 'page-about-domains.php':
			$title = esc_html_x( 'Domains', 'Page title', 'wporg' );
			break;

		case 'page-about-accessibility.php':
			$title = esc_html_x( 'Accessibility', 'Page title', 'wporg' );
			break;

		case 'page-about-etiquette.php':
			$title = esc_html_x( 'Etiquette', 'Page title', 'wporg' );
			break;

		case 'page-about-features.php':
			$title = esc_html_x( 'Features', 'Page title', 'wporg' );
			break;

		case 'page-about-history.php':
			$title = esc_html_x( 'History', 'Page title', 'wporg' );
			break;

		case 'page-about-license.php':
			$title = esc_html_x( 'GNU Public License', 'Page title', 'wporg' );
			break;

		case 'page-about-logos.php':
			$title = esc_html_x( 'Graphics &amp; Logos', 'Page title', 'wporg' );
			break;

		case 'page-about-philosophy.php':
			$title = esc_html_x( 'Philosophy', 'Page title', 'wporg' );
			break;

		case 'page-about-privacy.php':
			$title = esc_html_x( 'Privacy Policy', 'Page title', 'wporg' );
			break;

		case 'page-about-requirements.php':
			$title = esc_html_x( 'Requirements', 'Page title', 'wporg' );
			break;

		case 'page-about-roadmap.php':
			$title = esc_html_x( 'Roadmap', 'Page title', 'wporg' );
			break;

		case 'page-about-security.php':
			$title = esc_html_x( 'Security', 'Page title', 'wporg' );
			break;

		case 'page-about-stats.php':
			$title = esc_html_x( 'Statistics', 'Page title', 'wporg' );
			break;

		case 'page-about-swag.php':
			$title = esc_html_x( 'Swag', 'Page title', 'wporg' );
			break;

		case 'page-about-testimonials.php':
			$title = esc_html_x( 'Testimonials', 'Page title', 'wporg' );
			break;

		case 'page-about.php':
			if ( 'single_post_title' === current_filter() ) {
				$title = esc_html_x( 'About Us: Our Mission', 'Page title', 'wporg' );
			} else {
				$title = esc_html_x( 'About', 'Page title', 'wporg' );
			}
			break;

		case 'page-about-privacy-data-erasure-request.php':
			$title = esc_html_x( 'Data Erasure Request', 'Page title', 'wporg' );
			break;

		case 'page-about-privacy-data-export-request.php':
			$title = esc_html_x( 'Data Export Request', 'Page title', 'wporg' );
			break;

		case 'page-about-privacy-cookies.php':
			$title = esc_html_x( 'Cookie Policy', 'Page title', 'wporg' );
			break;

		case 'page-download.php':
			$title = esc_html_x( 'Download', 'Page title', 'wporg' );
			break;

		case 'page-download-beta-nightly.php':
			$title = esc_html_x( 'Beta/Nightly', 'Page title', 'wporg' );
			break;

		case 'page-download-counter.php':
			$title = esc_html_x( 'Counter', 'Page title', 'wporg' );
			break;

		case 'page-download-releases.php':
			$title = esc_html_x( 'Releases', 'Page title', 'wporg' );
			break;

		case 'page-download-source.php':
			$title = esc_html_x( 'Source Code', 'Page title', 'wporg' );
			break;

		case 'page-hosting.php':
			$title = esc_html_x( 'WordPress Hosting', 'Page title', 'wporg' );
			break;

		case 'page-mobile.php':
			$title = esc_html_x( 'WordPress Mobile Apps', 'Page title', 'wporg' );
			break;
	}

	return $title;
}
add_filter( 'the_title', __NAMESPACE__ . '\custom_page_title', 10, 2 );
add_filter( 'single_post_title', __NAMESPACE__ . '\custom_page_title', 10, 2 );

/**
 * Set the document title on the front page.
 */
function document_title_parts( $title ) {
	if ( isset( $title['site'] ) || is_front_page() ) {
		$title['site'] = 'WordPress.org'; // Rosetta will replace as needed.
	}

	if ( is_front_page() ) {
		$title['title'] = __( 'Blog Tool, Publishing Platform, and CMS', 'wporg' );
		unset( $title['tagline'] ); // Remove the tagline from the front-page.
	}

	return $title;
}
add_filter( 'document_title_parts', __NAMESPACE__ . '\document_title_parts' );

/**
 * Add excerpts for pages, so we can use it for opengraph descriptions.
 */
add_action(
	'init',
	function() {
		add_post_type_support( 'page', 'excerpt' );
	}
);
