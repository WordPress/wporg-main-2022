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
add_filter( 'render_block_core/site-title', __NAMESPACE__ . '\use_parent_page_title', 10, 3 );
add_filter( 'render_block_data', __NAMESPACE__ . '\update_header_template_part_class' );
add_filter( 'wporg_block_navigation_menus', __NAMESPACE__ . '\add_site_navigation_menus' );
add_filter( 'the_title', __NAMESPACE__ . '\translate_the_title', 1, 2 );
add_filter( 'single_post_title', __NAMESPACE__ . '\translate_the_title', 1, 2 );
add_filter( 'render_block_core/social-link', __NAMESPACE__ . '\inject_podcast_social_icons', 10, 2 );

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
		if ( 'ja' === get_locale() ) {
			global_fonts_preload( 'Noto Serif JP', 'cjk' );
		} else if ( 'ckb' === get_locale() ) {
			global_fonts_preload( 'Noto Kufi', 'arabic' );
		} else {
			/*
			 * translators: Font subset for your locale. Can be any of cyrillic,
			 * cyrillic-ext, greek, greek-ext, vietnamese, latin, latin-ext.
			 * Do not translate into your own language.
			 */
			$subsets = _x( 'latin', 'EB Garamond subsets, comma separated', 'wporg' );
			// All headings.
			global_fonts_preload( 'EB Garamond', $subsets );
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
 * Provide a list of local navigation menus.
 */
function add_site_navigation_menus( $menus ) {
	$about_details = array(
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
	);
	$about_technology = array(
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
	);
	$about_people = array(
		array(
			'label' => __( 'Philosophy', 'wporg' ),
			'url' => '/about/philosophy/',
		),
		array(
			'label' => __( 'Etiquette', 'wporg' ),
			'url' => '/about/etiquette/',
		),
		array(
			'label' => __( 'Logos', 'wporg' ),
			'url' => '/about/logos/',
		),
		array(
			'label' => __( 'People of WordPress', 'wporg' ),
			'url' => 'https://wordpress.org/news/category/community/',
		),
	);
	$about_home = array(
		array(
			'label' => __( 'The technology', 'wporg' ),
			'submenu' => $about_technology,
		),
		array(
			'label' => __( 'The details', 'wporg' ),
			'submenu' => $about_details,
		),
		array(
			'label' => __( 'The people', 'wporg' ),
			'submenu' => $about_people,
		),
	);
	return array(
		'about-home' => $about_home,
		'about-details' => $about_details,
		'about-technology' => $about_technology,
		'about-people' => $about_people,
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
	if ( is_home() || is_single() || is_archive() ) {
		return str_replace(
			array( home_url(), get_bloginfo( 'name' ) ),
			array( home_url( '/news/' ), __( 'News', 'wporg' ) ),
			$block_content
		);
	}

	if ( is_page( 'about' ) ) {
		return str_replace(
			array( home_url(), get_bloginfo( 'name' ) ),
			array( home_url( '/about/' ), __( 'About', 'wporg' ) ),
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
		$title = get_the_title( $parent );
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

/**
 * Replace the title with the translated page title.
 *
 * @param string $title   The current title, ignored.
 * @param int    $post_id The post_id of the page.
 *
 * @return string
 */
function translate_the_title( $title, $post_id = null ) {
	if ( is_admin() ) {
		return $title;
	}

	$post = get_post( $post_id );
	if ( $post && 'page' === $post->post_type ) {
		$title = translate( $post->post_title, 'wporg' ); // phpcs:ignore
	}

	return $title;
}

/**
 * Inject social icons for podcast services.
 *
 * This does not register a custom service, it just overrides based on the icon URL for the default (chain) service.
 *
 * @param string $block_content The block content.
 * @param array  $block         The full block, including name and attributes.
 *
 * @return string Updated block content.
 */
function inject_podcast_social_icons( $block_content, $block ) {
	if ( 'chain' !== $block['attrs']['service'] ) {
		return $block_content;
	}
	$icon = '';
	if ( str_contains( $block['attrs']['url'], 'podcasts.apple.com/' ) ) {
		// Apple Podcasts.
		$icon = '<svg xmlns="http://www.w3.org/2000/svg" viewbox="-15 -15 300 300" width="24" height="24"><path d="M60.196 0A59.94 59.94 0 0 0 .12 60.075v149.85A59.94 59.94 0 0 0 60.196 270h149.85a59.95 59.95 0 0 0 55.538-37.064 59.931 59.931 0 0 0 4.537-23.011V60.075a59.932 59.932 0 0 0-17.556-42.519A59.946 59.946 0 0 0 210.046 0H60.196Zm73.406 28.89c26.28 0 50.04 10.148 68.13 29.104 13.77 14.31 21.51 29.464 25.47 49.41 1.35 6.638 1.35 24.75.079 32.22a95.69 95.69 0 0 1-36.45 59.58c-6.84 5.175-23.58 14.186-26.28 14.186-.99 0-1.08-1.023-.63-5.175.81-6.66 1.62-8.043 5.4-9.63 6.03-2.52 16.29-9.832 22.59-16.143a86.003 86.003 0 0 0 22.59-39.78c2.34-9.27 2.07-29.88-.54-39.42-8.19-30.33-32.94-53.91-63.27-60.21-8.82-1.8-24.84-1.8-33.75 0-30.69 6.3-56.07 31.05-63.81 62.19-2.07 8.46-2.07 29.07 0 37.53 5.13 20.61 18.45 39.51 35.91 50.76 3.42 2.25 7.56 4.59 9.27 5.31 3.78 1.62 4.59 2.97 5.31 9.63.45 4.05.337 5.22-.63 5.22-.63 0-5.22-1.98-10.08-4.32l-.45-.338c-27.81-13.68-45.63-36.832-52.11-67.635-1.62-7.942-1.89-26.91-.338-34.2 4.05-19.575 11.79-34.875 24.66-48.42 18.54-19.541 42.39-29.88 68.94-29.88l-.011.011Zm1.508 31.613c4.601.045 9.033.45 12.442 1.192 31.32 6.975 53.55 38.34 49.23 69.458-1.71 12.532-6.03 22.837-13.68 32.4-3.78 4.837-12.96 12.937-14.58 12.937-.259 0-.54-3.06-.54-6.783V162.9l4.68-5.58c17.64-21.127 16.38-50.647-2.88-70.02-7.47-7.537-16.11-11.97-27.27-14.017-7.2-1.328-8.73-1.328-16.29-.09-11.475 1.879-20.362 6.322-28.26 14.13-19.35 19.17-20.61 48.847-2.97 69.997l4.646 5.58v6.84c0 3.78-.303 6.84-.675 6.84-.337 0-2.97-1.8-5.76-4.05l-.382-.123c-9.36-7.47-17.64-20.723-21.06-33.717-2.07-7.852-2.07-22.77.09-30.6 5.67-21.127 21.24-37.519 42.84-45.214 4.612-1.63 12.746-2.474 20.407-2.373h.012Zm-1.463 33.637c3.488 0 6.975.675 9.495 2.003 5.49 2.846 9.99 8.381 11.7 14.164 5.22 17.752-13.59 33.3-30.6 25.357h-.169c-8.01-3.724-12.33-10.755-12.42-19.912 0-8.247 4.59-15.424 12.51-19.632 2.52-1.316 6.008-1.98 9.495-1.98h-.011Zm-.124 53.19c11.115-.045 19.193 3.927 22.163 10.913 2.227 5.22 1.395 21.735-2.453 48.397-2.61 18.63-4.05 23.333-7.65 26.505-4.95 4.388-11.97 5.603-18.63 3.24h-.033c-8.055-2.891-9.788-6.806-13.095-29.745-3.837-26.662-4.68-43.177-2.453-48.397 2.948-6.93 10.958-10.868 22.163-10.913h-.012Z"/></svg>';
	} else if ( str_contains( $block['attrs']['url'], 'pca.st/' ) ) {
		// Pocket Casts.
		$icon = '<svg xmlns="http://www.w3.org/2000/svg" viewbox="-15 -15 300 300" width="24" height="24"><path d="M135.418.006c-74.565 0-135 60.435-135 135s60.435 135 135 135 135-60.435 135-135-60.435-135-135-135Zm40.095 135c0-22.14-17.955-40.095-40.095-40.095s-40.095 17.944-40.095 40.095c0 22.14 17.944 40.095 40.095 40.095v22.905c-34.796 0-63-28.204-63-63s28.204-63 63-63 63 28.204 63 63h-22.905Zm38.655 0c0-43.493-35.257-78.75-78.75-78.75-43.492 0-78.75 35.257-78.75 78.75 0 43.492 35.258 78.75 78.75 78.75v26.246c-57.994 0-104.996-47.014-104.996-104.996 0-57.994 47.014-104.996 104.996-104.996 57.994 0 104.996 47.013 104.996 104.996h-26.246Z"/></svg>';
	} else if ( str_contains( $block['attrs']['url'], 'stitcher.com/' ) ) {
		// Stitcher.
		$icon = '<svg xmlns="http://www.w3.org/2000/svg" viewbox="-15 -15 300 300" width="24" height="24"><path d="M203.812 95.807h45.837v77.94h-45.837v-77.94ZM.193 99.609h45.838v87.784H.193V99.609ZM51.27 84.67h45.608v96.435H51.27V84.669Zm50.847 8.157h45.609v99.112h-45.609V92.826Zm50.847-14.76h45.609v103.027h-45.609V78.065Z"/></svg>';
	}

	if ( $icon ) {
		$before        = explode( '<svg', $block_content );
		$after         = explode( '</svg>', $before[1] );
		$block_content = $before[0] . $icon . $after[1];
	}

	return $block_content;
}

/**
 * Prevent easy access to the Site Editor.
 *
 * See https://github.com/WordPress/wporg-main-2022/issues/390.
 */
add_action(
	'admin_menu',
	function() {
		remove_submenu_page( 'themes.php', 'site-editor.php' );
	}
);

add_action(
	'admin_bar_menu',
	function ( $wp_admin_bar ) {
		$wp_admin_bar->remove_node( 'site-editor' );
	},
	499 // Before the wporg-mu-plugins action.
);
