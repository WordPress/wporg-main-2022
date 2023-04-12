<?php
/**
 * Title: Requirements
 * Slug: wporg-main-2022/requirements
 * Inserter: no
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"right":"var:preset|spacing|60","left":"var:preset|spacing|60","top":"16px","bottom":"16px"}}},"backgroundColor":"white","className":"is-sticky","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-sticky has-white-background-color has-background" style="padding-top:16px;padding-right:var(--wp--preset--spacing--60);padding-bottom:16px;padding-left:var(--wp--preset--spacing--60)"><!-- wp:group {"align":"full","layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignfull"><!-- wp:paragraph {"style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"small"} -->
<p class="has-small-font-size" style="font-style:normal;font-weight:700"><?php _e( 'About', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:navigation {"ref":16421,"textColor":"blueberry-1","backgroundColor":"white","align":"wide","className":"is-style-dropdown-on-mobile","layout":{"type":"flex","justifyContent":"left"},"style":{"spacing":{"blockGap":"24px"}},"fontSize":"small"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","right":"var:preset|spacing|edge-space","left":"var:preset|spacing|edge-space","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--edge-space);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:heading {"level":1,"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|30"}}}} -->
<h1 class="wp-block-heading" style="margin-bottom:var(--wp--preset--spacing--30)"><?php _e( 'Requirements', 'wporg' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'To run WordPress we recommend your host supports:', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul><!-- wp:list-item -->
<li><?php _e( '<a href="https://www.php.net/">PHP</a> version 7.4 or greater.', 'wporg' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php _e( '<a href="https://www.mysql.com/">MySQL</a> version 5.7 or greater OR <a href="https://mariadb.org/">MariaDB</a> version 10.3 or greater.', 'wporg' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php _e( '<a href="https://wordpress.org/news/2016/12/moving-toward-ssl/">HTTPS</a> support', 'wporg' ); ?></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p><?php _e( 'That’s really it. We recommend <a href="https://httpd.apache.org/">Apache</a> or <a href="https://nginx.org/">Nginx</a> as the most robust and featureful server for running WordPress, but any server that supports PHP and MySQL will do. That said, we can’t test every possible environment and <a href="https://wordpress.org/hosting/">each of the hosts on our hosting page</a> supports the above and more with no problems.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'For detailed PHP extension recommendations, see the <a href="https://make.wordpress.org/hosting/handbook/handbook/server-environment/">Hosting Handbook</a>.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'Note: If you are in a legacy environment where you only have older PHP or MySQL versions, WordPress also works with PHP 5.6.20+ and MySQL 5.0+, but these versions have reached official End Of Life and as such <strong>may expose your site to security vulnerabilities</strong>.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php _e( 'Ask for it', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'Here’s a letter you can send to your host; copy and paste!', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:quote {"backgroundColor":"white","textColor":"charcoal-4","fontSize":"normal","fontFamily":"inter"} -->
<blockquote class="wp-block-quote has-charcoal-4-color has-white-background-color has-text-color has-background has-inter-font-family has-normal-font-size"><!-- wp:paragraph -->
<p><?php _e( 'I’m interested in running the open-source WordPress &lt;https://wordpress.org/&gt; web software and I was wondering if my account supported the following:', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul><!-- wp:list-item -->
<li><?php _e( 'PHP 7.4 or greater', 'wporg' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php _e( 'MySQL 5.7 or greater OR MariaDB 10.3 or greater', 'wporg' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php _e( 'Nginx or Apache with mod_rewrite module', 'wporg' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php _e( 'HTTPS support', 'wporg' ); ?></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p><?php _e( 'Thanks!', 'wporg' ); ?></p>
<!-- /wp:paragraph --></blockquote>
<!-- /wp:quote -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php _e( 'Not required, but recommended for better security', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'Hosting is more secure when PHP applications, like WordPress, are run using your account’s username instead of the server’s default shared username. Ask your potential host what steps they take to ensure the security of your account.', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->
