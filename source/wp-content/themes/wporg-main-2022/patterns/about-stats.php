<?php
/**
 * Title: Stats
 * Slug: wporg-main-2022/stats
 * Inserter: no
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","right":"var:preset|spacing|edge-space","left":"var:preset|spacing|edge-space","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--edge-space);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:heading {"level":1,"align":"wide","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|30"}}}} -->
<h1 class="wp-block-heading alignwide" style="margin-bottom:var(--wp--preset--spacing--30)"><?php esc_html_e( 'Statistics', 'wporg' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"wide"} -->
<p class="alignwide"><?php esc_html_e( 'These charts give a snapshot of the systems and configurations the WordPress community is running.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"wporg-about-stats-wrapper","layout":{"type":"constrained"}} -->
<div class="wp-block-group wporg-about-stats-wrapper"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'WordPress versions in use', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"wporg-about-stats-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group wporg-about-stats-section">
<!-- wp:group {"align":"full","className":"wporg-stats-chart loading","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"},"anchor":"wp_versions"} -->
<div class="wp-block-group alignfull wporg-stats-chart loading" id="wp_versions"></div>
<!-- /wp:group -->

<!-- wp:html -->
<button type="button" class="swap-table" aria-expanded="false" aria-controls="wp_versions"><?php esc_html_e( 'View as table', 'wporg' ); ?><span class="swap-table__icon" aria-hidden="true"></span></button>
<!-- /wp:html --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"wporg-about-stats-wrapper","layout":{"type":"constrained"}} -->
<div class="wp-block-group wporg-about-stats-wrapper"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'PHP versions in use', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"wporg-about-stats-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group wporg-about-stats-section">
<!-- wp:group {"align":"full","className":"wporg-stats-chart loading","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"},"anchor":"php_versions"} -->
<div class="wp-block-group alignfull wporg-stats-chart loading" id="php_versions"></div>
<!-- /wp:group -->

<!-- wp:html -->
<button type="button" class="swap-table" aria-expanded="false" aria-controls="php_versions"><?php esc_html_e( 'View as table', 'wporg' ); ?><span class="swap-table__icon" aria-hidden="true"></span></button>
<!-- /wp:html --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"wporg-about-stats-wrapper","layout":{"type":"constrained"}} -->
<div class="wp-block-group wporg-about-stats-wrapper"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Database versions in use', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"wporg-about-stats-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group wporg-about-stats-section">
<!-- wp:group {"align":"full","className":"wporg-stats-chart loading","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"},"anchor":"mysql_versions"} -->
<div class="wp-block-group alignfull wporg-stats-chart loading" id="mysql_versions"></div>
<!-- /wp:group -->

<!-- wp:html -->
<button type="button" class="swap-table" aria-expanded="false" aria-controls="mysql_versions"><?php esc_html_e( 'View as table', 'wporg' ); ?><span class="swap-table__icon" aria-hidden="true"></span></button>
<!-- /wp:html --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"wporg-about-stats-wrapper","layout":{"type":"constrained"}} -->
<div class="wp-block-group wporg-about-stats-wrapper"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Languages in use', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"wporg-about-stats-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group wporg-about-stats-section">
<!-- wp:group {"align":"full","className":"wporg-stats-chart loading","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"},"anchor":"locales"} -->
<div class="wp-block-group alignfull wporg-stats-chart loading" id="locales"></div>
<!-- /wp:group -->

<!-- wp:html -->
<button type="button" class="swap-table" aria-expanded="false" aria-controls="locales"><?php esc_html_e( 'View as table', 'wporg' ); ?><span class="swap-table__icon" aria-hidden="true"></span></button>
<!-- /wp:html --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
