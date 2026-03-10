<?php
/**
 * Template part for displaying the download modal content.
 */

?>
<!-- wp:group 
{"style":{"elements":{"link":{"color":{"text":"var:preset|color|white"}}},"spacing":{"padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|30","left":"var:preset|spacing|40","right":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|10"}},"backgroundColor":"blueberry-1","textColor":"white","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-white-color has-blueberry-1-background-color has-text-color has-background has-link-color" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--40)"><!-- wp:heading {"style":{"spacing":{"margin":{"top":"0"}}}} -->
<h2 class="wp-block-heading" style="margin-top:0"><?php esc_html_e( 'Howdy!', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"fontSize":"extra-large","fontFamily":"eb-garamond"} -->
<p class="has-eb-garamond-font-family has-extra-large-font-size"><?php esc_html_e( 'Thanks for downloading WordPress', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)"><!-- wp:paragraph {"className":"is-style-default"} -->
<p class="is-style-default"><?php esc_html_e( "You're an important part of the global community that has used, built, and transformed the platform into what it is today. Find out more ways you can contribute and make an impact on the future of the web.", 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"is-style-default","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group is-style-default"><!-- wp:paragraph -->
<p><?php _e( '<a href="https://make.wordpress.org/">Get involved in WordPress ↗︎</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( '<a href="https://www.meetup.com/pro/wordpress/">Join a local WordPress meetup ↗︎</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( '<a href="https://central.wordcamp.org/">Attend a WordCamp ↗︎</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( '<a href="https://wordpressfoundation.org/donate/">Support WordPress and open source education ↗︎</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
