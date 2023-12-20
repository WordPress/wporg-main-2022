<?php
/**
 * Title: Requirements
 * Slug: wporg-main-2022/requirements
 * Inserter: no
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","right":"var:preset|spacing|edge-space","left":"var:preset|spacing|edge-space","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--edge-space);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:heading {"level":1,"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|30"}}}} -->
<h1 class="wp-block-heading" style="margin-bottom:var(--wp--preset--spacing--30)"><?php _e( 'Requirements', 'wporg' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'To run WordPress, it’s recommended your host supports:', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul><!-- wp:list-item -->
<li><?php
/* translators: [recommended_php] is a shortcode and should not be translated. */
_e( '<a href="https://www.php.net/">PHP</a> version [recommended_php] or greater.', 'wporg' );
?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php
/* translators: [recommended_mysql], [recommended_mariadb] are shortcodes and should not be translated. */
_e( '<a href="https://www.mysql.com/">MySQL</a> version [recommended_mysql] or greater OR <a href="https://mariadb.org/">MariaDB</a> version [recommended_mariadb] or greater.', 'wporg' );
?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php _e( '<a href="https://wordpress.org/news/2016/12/moving-toward-ssl/">HTTPS</a> support', 'wporg' ); ?></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p><?php _e( 'That’s really it. <a href="https://httpd.apache.org/">Apache</a> or <a href="https://nginx.org/">Nginx</a> is recommended as the most robust and featureful server for running WordPress, but any server that supports PHP and MySQL will do. That said, for the smoothest experience in setting up—and running—your site, <a href="https://wordpress.org/hosting/">each host on the hosting page</a> supports the above and more with no problems.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'For detailed PHP extension recommendations, see the <a href="https://make.wordpress.org/hosting/handbook/handbook/server-environment/">Hosting Handbook</a>.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php
/* translators: [minimum_php] is a shortcode and should not be translated. */
_e( 'Note: If you are in a legacy environment where you only have older PHP or MySQL versions, WordPress also works with PHP [minimum_php]+ and MySQL 5.5.5+. However, these versions have reached their official End Of Life and <strong>may expose your site to security vulnerabilities</strong>.', 'wporg' );
?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php _e( 'Ask your host to run WordPress', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'If you’re unsure whether or not your host can already run WordPress, here’s a request you can copy and paste to send them!', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:quote {"backgroundColor":"white","textColor":"charcoal-4","fontSize":"normal","fontFamily":"inter"} -->
<blockquote class="wp-block-quote has-charcoal-4-color has-white-background-color has-text-color has-background has-inter-font-family has-normal-font-size"><!-- wp:paragraph -->
<p><?php _e( 'I’m interested in running the open source WordPress &lt;https://wordpress.org/&gt; web software, and I was wondering if my account supported the following:', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul><!-- wp:list-item -->
<li><?php
/* translators: [recommended_php] is a shortcode and should not be translated. */
_e( 'PHP [recommended_php] or greater', 'wporg' );
?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php
/* translators: [recommended_mysql], [recommended_mariadb] are shortcodes and should not be translated. */
_e( 'MySQL [recommended_mysql] or greater OR MariaDB [recommended_mariadb] or greater', 'wporg' );
?></li>
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
