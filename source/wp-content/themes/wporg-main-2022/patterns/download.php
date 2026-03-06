<?php
/**
 * Title: Download
 * Slug: wporg-main-2022/download
 * Inserter: no
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"5rem","right":"var:preset|spacing|edge-space","bottom":"120px","left":"var:preset|spacing|edge-space"}}},"layout":{"inherit":true,"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:5rem;padding-right:var(--wp--preset--spacing--edge-space);padding-bottom:120px;padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:heading {"level":1,"style":{"typography":{"textAlign":"center"}},"fontSize":"heading-1"} -->
<h1 class="wp-block-heading has-text-align-center has-heading-1-font-size"><?php esc_html_e( 'Get WordPress', 'wporg' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"is-style-serif","style":{"typography":{"textAlign":"center"}},"fontSize":"heading-5"} -->
<p class="has-text-align-center is-style-serif has-heading-5-font-size"><?php esc_html_e( 'Everything you need to set up your site just the way you want it.', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"border":{"top":{"color":"var:preset|color|light-grey-1","width":"1px"}},"spacing":{"padding":{"right":"var:preset|spacing|edge-space","left":"var:preset|spacing|edge-space"}}},"layout":{"inherit":true,"type":"constrained"},"anchor":"download-hosting"} -->
<div class="wp-block-group alignfull" id="download-hosting" style="border-top-color:var(--wp--preset--color--light-grey-1);border-top-width:1px;padding-right:var(--wp--preset--spacing--edge-space);padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":"0px"}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"50%","style":{"border":{"right":{"color":"var:preset|color|light-grey-1","width":"1px"}}}} -->
<div class="wp-block-column" style="border-right-color:var(--wp--preset--color--light-grey-1);border-right-width:1px;flex-basis:50%"><!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"80px","right":"var:preset|spacing|60","bottom":"80px","left":"0px"}}},"anchor":"download-install"} -->
<div class="wp-block-group alignwide" id="download-install" style="padding-top:80px;padding-right:var(--wp--preset--spacing--60);padding-bottom:80px;padding-left:0px"><!-- wp:heading {"fontSize":"heading-4"} -->
<h2 class="wp-block-heading has-heading-4-font-size"><?php esc_html_e( 'Download and install it yourself', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"is-style-short-text"} -->
<p class="is-style-short-text"><?php esc_html_e( 'For anyone comfortable getting their own hosting and domain.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:wporg/modal {"closeButtonColor":"white","customCloseButtonColor":"#ffffff","href":"[download_link]","label":"<?php /* translators: [latest_version] is a shortcode and should not be translated. */ esc_html_e( 'Download WordPress [latest_version]', 'wporg' ); ?>"} -->
<?php get_template_part( 'templates/template-parts/modal', 'download' ); ?>
<!-- /wp:wporg/modal -->

<?php if ( do_shortcode( '[download_link]' ) !== do_shortcode( '[download_link_variant]' ) ) : ?>
<!-- wp:wporg/modal {"closeButtonColor":"white","customCloseButtonColor":"#ffffff","href":"[download_link_variant]","label":"<?php /* translators: [latest_version] is a shortcode and should not be translated. */ esc_html_e( 'Download WordPress [latest_version] non-default', 'wporg' ); ?>"} -->
<?php get_template_part( 'templates/template-parts/modal', 'download' ); ?>
<!-- /wp:wporg/modal -->
<?php endif; ?>

<!-- wp:buttons {"style":{"spacing":{"blockGap":"10px"}},"layout":{"type":"flex","justifyContent":"left"}} -->
<div class="wp-block-buttons"><!-- wp:button {"textColor":"blue-1","className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-blue-1-color has-text-color wp-element-button" href="<?php echo esc_url( __( 'https://developer.wordpress.org/advanced-administration/before-install/howto-install/', 'wporg' ) ); ?>"><?php esc_html_e( 'Installation guide', 'wporg' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"is-style-short-text","textColor":"charcoal-4","fontSize":"small"} -->
<p class="is-style-short-text has-charcoal-4-color has-text-color has-small-font-size"><?php
/* translators: [recommended_php], [recommended_mysql], [recommended_mariadb] are shortcodes and should not be translated. */
esc_html_e( 'Recommend PHP [recommended_php] or greater and MySQL version [recommended_mysql] or MariaDB version [recommended_mariadb] or greater.', 'wporg' );
?></p>
<!-- /wp:paragraph -->

<!-- wp:navigation {"ref":17028,"textColor":"blueberry-1","overlayMenu":"never","className":"is-style-dots","style":{"spacing":{"blockGap":"0px"}},"fontSize":"small","menuSlug":"download"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"50%"} -->
<div class="wp-block-column" style="flex-basis:50%"><!-- wp:group {"align":"wide","style":{"spacing":{"padding":{"top":"80px","right":"0px","bottom":"80px","left":"var:preset|spacing|60"}}},"anchor":"hosting"} -->
<div class="wp-block-group alignwide" id="hosting" style="padding-top:80px;padding-right:0px;padding-bottom:80px;padding-left:var(--wp--preset--spacing--60)"><!-- wp:heading {"fontSize":"heading-4"} -->
<h2 class="wp-block-heading has-heading-4-font-size"><?php esc_html_e( 'Set up with a hosting provider', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"is-style-short-text"} -->
<p class="is-style-short-text"><?php esc_html_e( 'For anyone looking for the simplest way to start.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( __( 'https://wordpress.org/hosting/', 'wporg' ) ); ?>"><?php esc_html_e( 'See all recommended hosts', 'wporg' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"right":"var:preset|spacing|edge-space","left":"var:preset|spacing|edge-space","top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}},"border":{"color":null,"style":null,"width":null,"top":{"color":"var:preset|color|light-grey-1","style":"solid","width":"1px"},"right":[],"bottom":[],"left":[]}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull" style="border-top-color:var(--wp--preset--color--light-grey-1);border-top-style:solid;border-top-width:1px;padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--edge-space);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:paragraph {"align":"center","className":"has-text-align-center","style":{"typography":{"textAlign":"center"}},"anchor":"external-link"} -->
<p class="has-text-align-center" id="external-link"><?php _e( 'Still not sure? Explore the WordPress Playground, a live demo environment right from your browser. <a href="https://wordpress.org/playground/">Try WordPress ↗</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"left":"var:preset|spacing|edge-space","right":"var:preset|spacing|edge-space"}}},"backgroundColor":"blueberry-4","layout":{"inherit":true,"type":"constrained"},"anchor":"features"} -->
<div class="wp-block-group alignfull has-blueberry-4-background-color has-background" id="features" style="padding-right:var(--wp--preset--spacing--edge-space);padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|30","left":"var:preset|spacing|70"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"50%","style":{"spacing":{"padding":{"right":"0"}}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="padding-right:0;flex-basis:50%"><!-- wp:list {"className":"is-style-features"} -->
<ul class="wp-block-list is-style-features"><!-- wp:list-item -->
<li><?php esc_html_e( 'Simple', 'wporg' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Intuitive', 'wporg' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Extendable', 'wporg' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Free', 'wporg' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php esc_html_e( 'Open', 'wporg' ); ?></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"50%","style":{"spacing":{"padding":{"top":"60px","right":"0","bottom":"60px","left":"0"}}},"layout":{"inherit":false}} -->
<div class="wp-block-column is-vertically-aligned-center" style="padding-top:60px;padding-right:0;padding-bottom:60px;padding-left:0;flex-basis:50%"><!-- wp:heading {"fontSize":"heading-4"} -->
<h2 class="wp-block-heading has-heading-4-font-size"><?php esc_html_e( 'Powerful right out of the box', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"is-style-short-text"} -->
<p class="is-style-short-text"><?php esc_html_e( 'WordPress combines simplicity for users and publishers with under-the-hood complexity for developers. Discover the features that come standard with WordPress, and extend what the platform can do with the thousands of plugins available.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( '<a href="https://wordpress.org/about/features/">See all WordPress features ↗</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"160px","right":"var:preset|spacing|edge-space","bottom":"160px","left":"var:preset|spacing|edge-space"}},"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"backgroundColor":"blueberry-1","textColor":"white","layout":{"inherit":true,"type":"constrained"},"anchor":"resources"} -->
<div class="wp-block-group alignfull has-white-color has-blueberry-1-background-color has-text-color has-background has-link-color" id="resources" style="padding-top:160px;padding-right:var(--wp--preset--spacing--edge-space);padding-bottom:160px;padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":"120px"}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"fontSize":"heading-2"} -->
<h2 class="wp-block-heading has-heading-2-font-size"><?php esc_html_e( "You've got WordPress. What's next?", 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"is-style-short-text"} -->
<p class="is-style-short-text"><?php esc_html_e( 'If you need help getting started, these resources can help you find your way.', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:list {"className":"is-style-links-list"} -->
<ul class="wp-block-list is-style-links-list"><!-- wp:list-item -->
<li><?php _e( '<a href="https://learn.wordpress.org/course/getting-started-with-wordpress-get-setup/">WordPress courses ↗</a>', 'wporg' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php _e( '<a href="https://developer.wordpress.org/">Developer resources ↗</a>', 'wporg' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php _e( '<a href="https://wordpress.org/documentation/">Documentation ↗</a>', 'wporg' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php _e( '<a href="https://wordpress.org/support/forum/installation/">User forums ↗</a>', 'wporg' ); ?></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"120px","right":"var:preset|spacing|edge-space","bottom":"120px","left":"var:preset|spacing|edge-space"}}},"anchor":"mobile"} -->
<div class="wp-block-group alignfull" id="mobile" style="padding-top:120px;padding-right:var(--wp--preset--spacing--edge-space);padding-bottom:120px;padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:heading {"style":{"typography":{"textAlign":"center"}},"fontSize":"heading-2"} -->
<h2 class="wp-block-heading has-text-align-center has-heading-2-font-size"><?php esc_html_e( 'Inspiration strikes anywhere', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"textAlign":"center"}}} -->
<p class="has-text-align-center"><?php esc_html_e( 'Create and update content on the go with the WordPress app.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
<div class="wp-block-group"><!-- wp:image {"lightbox":{"enabled":false},"width":"150px","height":"45px","linkDestination":"custom"} -->
<figure class="wp-block-image is-resized"><a href="https://apps.apple.com/app/id335703880?pt=299112&amp;ct=wordpress.org&amp;mt=8"><img src="https://wordpress.org/wp-content/themes/pub/wporg-main/images/badge-apple.png" alt="<?php esc_attr_e( 'Download on the Apple App Store', 'wporg' ); ?>" style="width:150px;height:45px" /></a></figure>
<!-- /wp:image -->

<!-- wp:image {"lightbox":{"enabled":false},"width":"150px","height":"45px","linkDestination":"custom"} -->
<figure class="wp-block-image is-resized"><a href="https://play.google.com/store/apps/details?id=org.wordpress.android"><img src="https://wordpress.org/wp-content/themes/pub/wporg-main/images/badge-google-play.png" alt="<?php esc_attr_e( 'Get it on Google Play', 'wporg' ); ?>" style="width:150px;height:45px" /></a></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
