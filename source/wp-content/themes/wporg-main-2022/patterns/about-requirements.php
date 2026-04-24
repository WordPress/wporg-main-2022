<?php
/**
 * Title: Requirements
 * Slug: wporg-main-2022/requirements
 * Inserter: no
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","right":"var:preset|spacing|edge-space","left":"var:preset|spacing|edge-space","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--edge-space);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:heading {"level":1,"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|30"}}}} -->
<h1 class="wp-block-heading" style="margin-bottom:var(--wp--preset--spacing--30)"><?php esc_html_e( 'Requirements', 'wporg' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'To run WordPress, we recommend your host supports the following — a safe, modern baseline for performance and security.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:columns {"verticalAlignment":"stretch","style":{"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"},"blockGap":{"left":"var:preset|spacing|30"}}}} -->
<div class="wp-block-columns are-vertically-aligned-stretch" style="margin-top:var(--wp--preset--spacing--40);margin-bottom:var(--wp--preset--spacing--40)"><!-- wp:column {"verticalAlignment":"stretch","backgroundColor":"light-grey-2","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40"}},"border":{"radius":"8px","top":{"color":"var:preset|color|blueberry-1","width":"3px"}}}} -->
<div class="wp-block-column is-vertically-aligned-stretch has-light-grey-2-background-color has-background" style="border-top-color:var(--wp--preset--color--blueberry-1);border-top-width:3px;border-radius:8px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)"><!-- wp:heading {"level":3,"style":{"spacing":{"margin":{"top":"0","bottom":"var:preset|spacing|20"}}}} -->
<h3 class="wp-block-heading" style="margin-top:0;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'PHP', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php
/* translators: [recommended_php] is a shortcode and should not be translated. */
_e( 'Version <strong>[recommended_php]</strong> or greater.', 'wporg' );
?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size"><?php _e( 'Powers WordPress on your server. <a href="https://www.php.net/">Learn more →</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"stretch","backgroundColor":"light-grey-2","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40"}},"border":{"radius":"8px","top":{"color":"var:preset|color|blueberry-1","width":"3px"}}}} -->
<div class="wp-block-column is-vertically-aligned-stretch has-light-grey-2-background-color has-background" style="border-top-color:var(--wp--preset--color--blueberry-1);border-top-width:3px;border-radius:8px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)"><!-- wp:heading {"level":3,"style":{"spacing":{"margin":{"top":"0","bottom":"var:preset|spacing|20"}}}} -->
<h3 class="wp-block-heading" style="margin-top:0;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Database', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php
/* translators: [recommended_mariadb], [recommended_mysql] are shortcodes and should not be translated. */
_e( 'MariaDB <strong>[recommended_mariadb]</strong>+ or MySQL <strong>[recommended_mysql]</strong>+.', 'wporg' );
?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size"><?php _e( 'Stores your content and settings. <a href="https://mariadb.org/">MariaDB</a> · <a href="https://www.mysql.com/">MySQL</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"stretch","backgroundColor":"light-grey-2","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40"}},"border":{"radius":"8px","top":{"color":"var:preset|color|blueberry-1","width":"3px"}}}} -->
<div class="wp-block-column is-vertically-aligned-stretch has-light-grey-2-background-color has-background" style="border-top-color:var(--wp--preset--color--blueberry-1);border-top-width:3px;border-radius:8px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)"><!-- wp:heading {"level":3,"style":{"spacing":{"margin":{"top":"0","bottom":"var:preset|spacing|20"}}}} -->
<h3 class="wp-block-heading" style="margin-top:0;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'HTTPS', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Required for every install.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"small"} -->
<p class="has-small-font-size"><?php _e( 'Encrypts your site’s connection. <a href="https://wordpress.org/news/2016/12/moving-toward-ssl/">Why HTTPS matters →</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:paragraph -->
<p><?php _e( 'That’s really it. <a href="https://httpd.apache.org/">Apache</a> or <a href="https://nginx.org/">Nginx</a> is recommended as the most robust and featureful server for running WordPress, but any server that supports PHP and MySQL will do. For the smoothest experience setting up — and running — your site, <a href="https://wordpress.org/hosting/">each host on the hosting page</a> supports the above and more with no problems.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'For detailed PHP extension recommendations, see the <a href="https://make.wordpress.org/hosting/handbook/handbook/server-environment/">Hosting Handbook</a>.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"backgroundColor":"lemon-3","textColor":"charcoal-1","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","right":"var:preset|spacing|40","bottom":"var:preset|spacing|30","left":"var:preset|spacing|40"},"margin":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}},"border":{"radius":"8px"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group has-charcoal-1-color has-lemon-3-background-color has-text-color has-background" style="border-radius:8px;margin-top:var(--wp--preset--spacing--40);margin-bottom:var(--wp--preset--spacing--40);padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--40)"><!-- wp:heading {"level":4,"style":{"spacing":{"margin":{"top":"0","bottom":"var:preset|spacing|20"}}}} -->
<h4 class="wp-block-heading" style="margin-top:0;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Running on legacy versions?', 'wporg' ); ?></h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php
/* translators: [minimum_php] is a shortcode and should not be translated. */
_e( 'WordPress will still run on PHP [minimum_php]+ and MySQL 5.5.5+, but those versions have reached official End Of Life and <strong>may expose your site to security vulnerabilities</strong>. Upgrading is strongly recommended.', 'wporg' );
?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Ask your host to run WordPress', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'If you’re unsure whether your host can already run WordPress, here’s a request you can copy and send them:', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:quote {"backgroundColor":"white","textColor":"charcoal-4","fontSize":"normal","fontFamily":"inter"} -->
<blockquote class="wp-block-quote has-charcoal-4-color has-white-background-color has-text-color has-background has-inter-font-family has-normal-font-size"><!-- wp:paragraph -->
<p><?php esc_html_e( 'I’m interested in running the open source WordPress <https://wordpress.org/> web software, and I was wondering if my account supported the following:', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li><?php
/* translators: [recommended_php] is a shortcode and should not be translated. */
esc_html_e( 'PHP [recommended_php] or greater', 'wporg' );
?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php
/* translators: [recommended_mariadb], [recommended_mysql] are shortcodes and should not be translated. */
esc_html_e( 'MariaDB version [recommended_mariadb] or greater OR MySQL version [recommended_mysql] or greater', 'wporg' );
?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Nginx or Apache with mod_rewrite module', 'wporg' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'HTTPS support', 'wporg' ); ?></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Thanks!', 'wporg' ); ?></p>
<!-- /wp:paragraph --></blockquote>
<!-- /wp:quote -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Not required, but recommended for better security', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Hosting is more secure when PHP applications, like WordPress, are run using your account’s username instead of the server’s default shared username. Ask your potential host what steps they take to ensure the security of your account.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--40)"><!-- wp:button {"backgroundColor":"blueberry-1","textColor":"white"} -->
<div class="wp-block-button"><a class="wp-block-button__link has-white-color has-blueberry-1-background-color has-text-color has-background wp-element-button" href="https://wordpress.org/download/"><?php esc_html_e( 'Download WordPress', 'wporg' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="https://wordpress.org/hosting/"><?php esc_html_e( 'Browse recommended hosts', 'wporg' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
