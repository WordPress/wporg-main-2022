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
		$desc = $post->post_excerpt ? get_the_excerpt() : __( 'Open source software which you can use to easily create a beautiful website, blog, or app.', 'wporg' );
		return array(
			'og:type'         => 'website',
			'og:title'        => __( 'Blog Tool, Publishing Platform, and CMS', 'wporg' ) . " - {$site_title}",
			'og:description'  => $desc,
			'description'     => $desc,
			'og:url'          => home_url( '/' ),
			'og:site_name'    => $site_title,
			'og:image'        => 'https://wordpress.org/files/2024/04/wordpress-homepage-ogimage-202404.png',
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
add_filter( 'jetpack_open_graph_tags', __NAMESPACE__ . '\custom_open_graph_tags', 11 );
// Enable Jetpack opengraph by default
add_filter( 'jetpack_enable_open_graph', '__return_true' );

/**
 * Prevent Jetpack from looking for a non-existent featured image.
 */
add_filter(
	'jetpack_images_pre_get_images',
	function( $media, $post_id ) {
		if ( ! $post_id || ! has_post_thumbnail( $post_id ) ) {
			return new \WP_Error();
		}
		return $media;
	},
	10,
	2
);

/**
 * Renders site's attributes for the WordPress.org frontpages (including Rosetta).
 *
 * @see https://developers.google.com/search/docs/guides/enhance-site
 */
function sites_attributes_schema() {
	global $rosetta;

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

	if ( is_front_page() ) : ?>
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
	<?php elseif ( is_page( 'download' ) ) : ?>
<script type="application/ld+json">
[
	{
		"@context": "http://schema.org",
		"@type": [
			"SoftwareApplication",
			"Product"
		],
		"name": "WordPress",
		"operatingSystem": [ "Linux", "Windows", "Unix", "Apache", "NGINX" ],
		"url": "<?php the_permalink(); ?>",
		"description": "<?php echo esc_js( $og_tags['og:description'] ); ?>",
		"softwareVersion": "<?php echo esc_js( do_shortcode( '[latest_version]' ) ); ?>",
		"fileFormat": "application/zip",
		"downloadUrl": "<?php echo esc_url( do_shortcode( '[download_link]' ) ); ?>",
		"dateModified": "<?php echo esc_js( do_shortcode( '[latest_version_date]' ) ); ?>",
		"applicationCategory": "WebApplication",
		"offers": {
			"@type": "Offer",
			"url": "<?php the_permalink(); ?>",
			"price": "0.00",
			"priceCurrency": "USD",
			"seller": {
				"@type": "Organization",
				"name": "WordPress.org",
				"url": "https://wordpress.org"
			}
		}
	}
]
</script>
	<?php endif;
}
add_action( 'wp_head', __NAMESPACE__ . '\sites_attributes_schema' );

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
