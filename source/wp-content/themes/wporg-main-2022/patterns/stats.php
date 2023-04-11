<?php
/**
 * Title: Stats
 * Slug: wporg-main-2022/stats
 * Inserter: no
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"right":"var:preset|spacing|60","left":"var:preset|spacing|60","top":"16px","bottom":"16px"}}},"backgroundColor":"white","className":"is-sticky","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-sticky has-white-background-color has-background" style="padding-top:16px;padding-right:var(--wp--preset--spacing--60);padding-bottom:16px;padding-left:var(--wp--preset--spacing--60)"><!-- wp:group {"align":"full","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignfull"><!-- wp:paragraph {"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"small"} -->
<p class="has-small-font-size" style="font-style:normal;font-weight:700"><?php _e( 'About', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:navigation {"ref":16892,"textColor":"blueberry-1","backgroundColor":"white","align":"wide","className":"is-style-dropdown-on-mobile","layout":{"type":"flex","justifyContent":"left"},"style":{"spacing":{"blockGap":"24px"}},"fontSize":"small"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","right":"var:preset|spacing|edge-space","left":"var:preset|spacing|edge-space","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--edge-space);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:heading {"level":1,"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|30"}}}} -->
<h1 class="wp-block-heading" style="margin-bottom:var(--wp--preset--spacing--30)"><?php _e( 'Statistics', 'wporg' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'Here are some charts showing what sorts of systems people are running WordPress on. (You’ll need JavaScript enabled to see them.)', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"anchor":"","className":"wporg-about-stats-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group wporg-about-stats-section"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php _e( 'WordPress Version <a class="swap-table dashicons dashicons-editor-table" title="View as Table" aria-hidden="true"></a>', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:group {"align":"full","anchor":"wp_versions","className":"wporg-stats-chart loading","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<div class="wp-block-group alignfull wporg-stats-chart loading" id="wp_versions"></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"anchor":"","className":"wporg-about-stats-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group wporg-about-stats-section"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php _e( 'PHP Version <a class="swap-table dashicons dashicons-editor-table" title="View as Table" aria-hidden="true"></a>', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:group {"align":"full","anchor":"php_versions","className":"wporg-stats-chart loading","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<div class="wp-block-group alignfull wporg-stats-chart loading" id="php_versions"></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"anchor":"","className":"wporg-about-stats-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group wporg-about-stats-section"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php _e( 'MySQL Version <a class="swap-table dashicons dashicons-editor-table" title="View as Table" aria-hidden="true"></a>', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:group {"align":"full","anchor":"mysql_versions","className":"wporg-stats-chart loading","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<div class="wp-block-group alignfull wporg-stats-chart loading" id="mysql_versions"></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"anchor":"","className":"wporg-about-stats-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group wporg-about-stats-section"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php _e( 'Locales <a class="swap-table dashicons dashicons-editor-table" title="View as Table" aria-hidden="true"></a>', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:group {"align":"full","anchor":"locales","className":"wporg-stats-chart loading","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<div class="wp-block-group alignfull wporg-stats-chart loading" id="locales"></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
