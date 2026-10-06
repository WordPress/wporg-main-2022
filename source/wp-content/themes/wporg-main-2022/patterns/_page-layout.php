<?php
// phpcs:disable WordPress.Files.FileName -- Allow underscore for pattern partial.
/**
 * Title: WordPress.org page
 * Slug: wporg-main-2022/page-layout
 * Description: Page with its own title and spacing, ready to be synced into a pattern.
 * Post Types: page
 * Block Types: core/post-content
 * Viewport Width: 1280
 */

declare( strict_types = 1 );

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","right":"var:preset|spacing|edge-space","left":"var:preset|spacing|edge-space","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--edge-space);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:heading {"level":1,"placeholder":"Page title","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|30"}}}} -->
<h1 class="wp-block-heading" style="margin-bottom:var(--wp--preset--spacing--30)"></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"placeholder":"Start writing…"} -->
<p></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
