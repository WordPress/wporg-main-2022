<?php

namespace WordPressdotorg\Theme\Main_2022;

use function WordPressdotorg\MU_Plugins\Global_Header_Footer\is_rosetta_site;

require_once __DIR__ . '/inc/page-meta-descriptions.php';
require_once __DIR__ . '/inc/hreflang.php';
require_once __DIR__ . '/inc/capabilities.php';
require_once __DIR__ . '/inc/data-liberation-handbook.php';

// Block files
require_once __DIR__ . '/src/download-counter/index.php';
require_once __DIR__ . '/src/google-search-embed/index.php';
require_once __DIR__ . '/src/random-heading/index.php';
require_once __DIR__ . '/src/release-tables/index.php';
require_once __DIR__ . '/src/remembers-list/index.php';

/**
 * Actions and filters.
 */
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_assets' );
add_action( 'init', __NAMESPACE__ . '\register_shortcodes' );
add_filter( 'wp_img_tag_add_loading_attr', __NAMESPACE__ . '\override_lazy_loading', 10, 2 );
add_filter( 'wporg_block_site_breadcrumbs', __NAMESPACE__ . '\update_site_breadcrumbs' );
add_filter( 'render_block_core/site-title', __NAMESPACE__ . '\use_parent_page_title', 10, 3 );
add_filter( 'render_block_data', __NAMESPACE__ . '\update_header_template_part_class' );
add_filter( 'wporg_block_navigation_menus', __NAMESPACE__ . '\add_site_navigation_menus' );

// Remove table of contents.
add_filter( 'wporg_handbook_toc_should_add_toc', '__return_false' );

// Remove the edit link from handbook titles.
add_filter( 'wporg_markdown_should_filter_title', '__return_false' );

/**
 * Enqueue scripts and styles.
 */
function enqueue_assets() {
	// The parent style is registered as `wporg-parent-2021-style`, and will be loaded unless
	// explicitly unregistered. We can load any child-theme overrides by declaring the parent
	// stylesheet as a dependency.
	wp_enqueue_style(
		'wporg-main-2022-style',
		get_stylesheet_directory_uri() . '/build/style/style-index.css',
		array( 'wporg-parent-2021-style', 'wporg-global-fonts', 'dashicons' ),
		filemtime( __DIR__ . '/build/style/style-index.css' )
	);
	wp_style_add_data( 'wporg-main-2022-style', 'rtl', 'replace' );

	if ( is_page( 'download' ) ) {
		$path        = __DIR__ . '/build/download/index.js';
		$deps_path   = __DIR__ . '/build/download/index.asset.php';
		$script_info = file_exists( $deps_path )
			? require $deps_path
			: array(
				'dependencies' => array(),
				'version'      => filemtime( $path ),
			);

		wp_enqueue_script(
			'wporg-main-2022-download-script',
			get_stylesheet_directory_uri() . '/build/download/index.js',
			$script_info['dependencies'],
			$script_info['version'],
			true
		);

		wp_enqueue_style(
			'wporg-main-2022-download-style',
			get_stylesheet_directory_uri() . '/build/download/style-index.css',
			array(),
			filemtime( __DIR__ . '/build/download/style-index.css' )
		);
		wp_style_add_data( 'wporg-main-2022-download-style', 'rtl', 'replace' );
	}

	if ( is_page( 'stats' ) ) {
		// phpcs:ignore WordPress.WP.EnqueuedResourceParameters
		wp_enqueue_script( 'google-charts', 'https://www.gstatic.com/charts/loader.js', [], null, true );
		wp_enqueue_script( 'wporg-page-stats', get_theme_file_uri( '/js/page-stats.js' ), [ 'jquery', 'google-charts' ], filemtime( __DIR__ . '/js/page-stats.js' ), true );
		wp_localize_script(
			'wporg-page-stats',
			'wporgPageStats',
			[
				'trunk'       => number_format( WP_CORE_STABLE_BRANCH + 0.1, 1 ), /* trunk */
				'viewAsChart' => __( 'View as Chart', 'wporg' ),
				'viewAsTable' => __( 'View as Table', 'wporg' ),
			]
		);
	}

	// Preload the heading font(s).
	if ( is_callable( 'global_fonts_preload' ) ) {
		/* translators: Subsets can be any of cyrillic, cyrillic-ext, greek, greek-ext, vietnamese, latin, latin-ext. */
		$subsets = _x( 'latin', 'Heading font subsets, comma separated', 'wporg' );
		if ( ! in_array( $subsets, [ 'cyrillic', 'cyrillic-ext', 'greek', 'greek-ext', 'vietnamese', 'latin', 'latin-ext' ] ) ) {
			$subsets = 'latin';
		}

		// All headings.
		global_fonts_preload( 'EB Garamond', $subsets );

		if ( is_front_page() ) {
			// The heading on the front-page has some italic.
			global_fonts_preload( 'EB Garamond italic', $subsets );
		}
	}

	if ( get_locale() !== 'en_US' ) {
		wp_enqueue_style(
			'wporg-main-2022-rosetta-style',
			get_stylesheet_directory_uri() . '/build/rosetta/style-index.css',
			array( 'wporg-main-2022-style' ),
			filemtime( __DIR__ . '/build/rosetta/style-index.css' )
		);
	}
}

/**
 * Load the shortcodes available for the theme.
 */
function register_shortcodes() {
	include __DIR__ . '/inc/shortcodes.php';
}

/**
 * Prevents adding loading="lazy" to the editor section's background.
 *
 * @param string|bool $value   The `loading` attribute value.
 * @param string      $image   The HTML `img` tag to be filtered.
 *
 * @return string The filtered loading value.
 */
function override_lazy_loading( $value, $image ) {
	if ( str_contains( $image, 'Editor.webp' ) ) {
		// False removes the `loading` attribute entirely.
		return false;
	}
	return $value;
}

/**
 * Use the page heirarchy to display breadcrumbs.
 */
function update_site_breadcrumbs( $breadcrumbs ) {

	// Handle breadcrumbs for the data liberation section.
	if ( is_singular( 'and-handbook' ) ) {
		return array(
			array(
				'url' => home_url( '/data-liberation' ),
				'title' => __( 'Home', 'wporg' ),
			),
			array(
				'url' => home_url( '/data-liberation/and' ),
				'title' => __( 'Guides', 'wporg' ),
			),
			array(
				'url' => false,
				'title' => get_the_title(),
			)
		);
	}

	$parent = get_post_parent();
	if ( ! $parent ) {
		return $breadcrumbs;
	}

	$breadcrumbs = array();
	$breadcrumbs[] = array(
		'url' => false,
		'title' => get_the_title(),
	);

	while ( $parent ) {
		$breadcrumbs[] = array(
			'url' => get_permalink( $parent->ID ),
			'title' => $parent->post_title,
		);
		$parent = get_post_parent( $parent );
	}

	return array_reverse( $breadcrumbs );
}

/**
 * Provide a list of local navigation menus.
 */
function add_site_navigation_menus( $menus ) {
	return array(
		'about-details' => array(
			array(
				'label' => __( 'Domains', 'wporg' ),
				'url' => '/about/domains/',
			),
			array(
				'label' => __( 'License', 'wporg' ),
				'url' => '/about/license/',
			),
			array(
				'label' => __( 'Accessibility', 'wporg' ),
				'url' => '/about/accessibility/',
			),
			array(
				'label' => __( 'Privacy Policy', 'wporg' ),
				'url' => '/about/privacy/',
			),
			array(
				'label' => __( 'Statistics', 'wporg' ),
				'url' => '/about/stats/',
			),
		),
		'about-technology' => array(
			array(
				'label' => __( 'Requirements', 'wporg' ),
				'url' => '/about/requirements/',
			),
			array(
				'label' => __( 'Features', 'wporg' ),
				'url' => '/about/features/',
			),
			array(
				'label' => __( 'Security', 'wporg' ),
				'url' => '/about/security/',
			),
			array(
				'label' => __( 'Roadmap', 'wporg' ),
				'url' => '/about/roadmap/',
			),
			array(
				'label' => __( 'History', 'wporg' ),
				'url' => '/about/history/',
			),
		),
		'about-people' => array(
			array(
				'label' => __( 'Philosophy', 'wporg' ),
				'url' => '/about/philosophy/',
			),
			array(
				'label' => __( 'Etiquette', 'wporg' ),
				'url' => '/about/etiquette/',
			),
			array(
				'label' => __( 'Swag', 'wporg' ),
				'url' => 'https://mercantile.wordpress.org/',
			),
			array(
				'label' => __( 'Logos', 'wporg' ),
				'url' => '/about/logos/',
			),
			array(
				'label' => __( 'People of WordPress', 'wporg' ),
				'url' => 'https://wordpress.org/news/category/community/',
			),
		),
		'download' => array(
			array(
				'label' => __( 'Releases', 'wporg' ),
				'url' => '/download/releases/',
			),
			array(
				'label' => __( 'Nightly', 'wporg' ),
				'url' => '/download/beta-nightly/',
			),
			array(
				'label' => __( 'Counter', 'wporg' ),
				'url' => '/download/counter/',
			),
			array(
				'label' => __( 'Source', 'wporg' ),
				'url' => '/download/source/',
			),
		),
	);
}

/**
 * Replace the site title & link with the parent page title.
 *
 * The About and Download sections are pseudo-individual sites, so when site title
 * is used there, it should reference the parent page.
 *
 * @param string   $block_content The block content.
 * @param array    $block         The full block, including name and attributes.
 * @param WP_Block $instance      The block instance.
 */
function use_parent_page_title( $block_content, $block, $instance ) {

	// Handle the site title for data liberation.
	if ( is_post_type_archive( 'and-handbook' ) || is_singular( 'and-handbook' ) ) {
		return str_replace(
			array( home_url(), get_bloginfo( 'name' ) ),
			array( home_url( '/data-liberation' ), __( 'Data Liberation', 'wporg' ) ),
			$block_content
		);
	}

	if ( is_home() || is_single() || is_archive() ) {
		return str_replace(
			array( home_url(), get_bloginfo( 'name' ) ),
			array( home_url( '/news/' ), __( 'News', 'wporg' ) ),
			$block_content
		);
	}

	$parent = get_post_parent();
	if ( ! $parent ) {
		return $block_content;
	}

	// Loop up to the first child page, this is the section title.
	while ( $parent ) {
		$url = get_permalink( $parent->ID );
		$title = $parent->post_title;
		$parent = get_post_parent( $parent );
	}

	return str_replace(
		array( home_url(), get_bloginfo( 'name' ) ),
		array( $url, $title ),
		$block_content
	);
}

/**
 * Register the Rosetta header menu.
 */
add_action(
	'after_setup_theme',
	function() {
		register_nav_menus(
			array(
				'rosetta_main' => 'Rosetta',
			)
		);
	}
);

/**
 * Add the has-display-contents class to the header template so that the fixed local nav bar works.
 *
 * @param array $block The parsed block data.
 *
 * @return array
 */
function update_header_template_part_class( $block ) {
	if ( ! empty( $block['blockName'] ) && 'core/template-part' === $block['blockName'] ) {
		if ( 'header' === $block['attrs']['slug'] ) {
			if ( isset( $block['attrs']['className'] ) ) {
				$block['attrs']['className'] .= ' has-display-contents';
			} else {
				$block['attrs']['className'] = 'has-display-contents';
			}
		}
	}
	return $block;
}
