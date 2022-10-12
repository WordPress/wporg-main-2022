<?php
/**
 * Title: Source Code
 * Slug: wporg-main-2022/source
 * Inserter: no
 */

?>
<!-- wp:group {"align":"full","style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}},"spacing":{"padding":{"top":"var:preset|spacing|20","right":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"var:preset|spacing|20"}}},"backgroundColor":"blueberry-1","textColor":"white","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-white-color has-blueberry-1-background-color has-text-color has-background has-link-color" style="padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)"><!-- wp:group {"align":"wide","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide"><!-- wp:paragraph {"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"normal"} -->
<p class="has-normal-font-size" style="font-style:normal;font-weight:700"><?php _e( 'Download', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:navigation {"ref":11576,"overlayMenu":"never"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:columns {"align":"wide","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}}} -->
<div class="wp-block-columns alignwide" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:column {"width":"33.33%"} -->
<div class="wp-block-column" style="flex-basis:33.33%"><!-- wp:heading {"level":1,"style":{"spacing":{"padding":{"right":"var:preset|spacing|60"}}},"fontSize":"heading-2"} -->
<h1 class="has-heading-2-font-size" style="padding-right:var(--wp--preset--spacing--60)"><?php _e( 'Source Code', 'wporg' ); ?></h1>
<!-- /wp:heading --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"66.66%"} -->
<div class="wp-block-column" style="flex-basis:66.66%"><!-- wp:paragraph -->
<p><?php _e( 'If you’d like to browse the WordPress source and inline documentation, we have a <a href="https://developer.wordpress.org/reference/">convenient developer reference</a> and a <a href="https://core.trac.wordpress.org/browser/">code browser</a>. We also have guides for <a href="https://make.wordpress.org/core/handbook/contribute/svn/">contributing with Subversion</a> and <a href="https://make.wordpress.org/core/handbook/contribute/git/">contributing with Git</a>.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'The built WordPress source, <a href="https://wordpress.org/about/license/">licensed</a> under the GNU General Public License version 2 (or later), can be <a href="https://build.trac.wordpress.org/browser">browsed online</a> or checked out locally with Subversion or Git:', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul><!-- wp:list-item -->
<li><?php _e( 'Subversion: ', 'wporg' ); ?><code><strong><?php _e( 'https://core.svn.wordpress.org/', 'wporg' ); ?></strong></code></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php _e( 'Git mirror: ', 'wporg' ); ?><code><strong><?php _e( 'git://core.git.wordpress.org/', 'wporg' ); ?></strong></code></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p><?php _e( 'WordPress minifies core JavaScript files using UglifyJS and CSS using clean-css, all via the <a href="https://gruntjs.com/">Grunt</a> JavaScript-based task runner. The development source that includes un-minified versions of these files, along with the build scripts, can be <a href="https://core.trac.wordpress.org/browser">browsed online</a> or checked out locally with Subversion or Git:', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul><!-- wp:list-item -->
<li><?php _e( 'Subversion: ', 'wporg' ); ?><code><strong><?php _e( 'https://develop.svn.wordpress.org/', 'wporg' ); ?></strong></code></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php _e( 'Git mirror: ', 'wporg' ); ?><code><strong><?php _e( 'git://develop.git.wordpress.org/', 'wporg' ); ?></strong></code></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p><?php _e( 'The source code for any program binaries or minified external scripts that are included with WordPress can be freely obtained from our <a href="https://code.trac.wordpress.org/browser/wordpress-sources">sources repository</a>.', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->
