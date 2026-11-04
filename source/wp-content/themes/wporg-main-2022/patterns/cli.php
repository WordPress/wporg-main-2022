<?php
/**
 * Title: WP-CLI
 * Slug: wporg-main-2022/cli
 * Inserter: no
 */

?>
<!-- wp:group {"metadata":{"name":"Page"},"align":"full","style":{"spacing":{"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull"><!-- wp:group {"metadata":{"name":"Hero"},"align":"full","style":{"spacing":{"padding":{"right":"var:preset|spacing|edge-space","left":"var:preset|spacing|edge-space","top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}},"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"backgroundColor":"charcoal-2","textColor":"white","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-white-color has-charcoal-2-background-color has-text-color has-background has-link-color" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--edge-space);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"30px","left":"var:preset|spacing|40"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%"><!-- wp:heading {"level":1,"style":{"typography":{"fontSize":"70px"}}} -->
<h1 class="wp-block-heading" style="font-size:70px"><?php esc_html_e( 'WP-CLI: Every action, scriptable.', 'wporg' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"is-style-short-text"} -->
<p class="is-style-short-text"><?php esc_html_e( 'The command line for WordPress. No browser required.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--40);margin-bottom:var(--wp--preset--spacing--40)"><!-- wp:button {"className":"is-style-outline-on-dark"} -->
<div class="wp-block-button is-style-outline-on-dark"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( __( 'https://make.wordpress.org/cli/handbook/guides/installing/', 'wporg' ) ); ?>"><?php esc_html_e( 'Install WP-CLI', 'wporg' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline-on-dark"} -->
<div class="wp-block-button is-style-outline-on-dark"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( __( 'https://developer.wordpress.org/cli/commands/', 'wporg' ) ); ?>"><?php esc_html_e( 'Browse commands', 'wporg' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":""} -->
<div class="wp-block-column is-vertically-aligned-center"><!-- wp:image {"id":50979,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="https://wordpress.org/files/2026/04/wp-cli-header-image.jpg" alt="" class="wp-image-50979" /></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Scriptable by design"},"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","right":"var:preset|spacing|edge-space","bottom":"var:preset|spacing|80","left":"var:preset|spacing|edge-space"}},"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"backgroundColor":"charcoal-1","textColor":"white","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-white-color has-charcoal-1-background-color has-text-color has-background has-link-color" style="padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--edge-space);padding-bottom:var(--wp--preset--spacing--80);padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide"><!-- wp:heading {"style":{"spacing":{"margin":{"top":"0"}}}} -->
<h2 class="wp-block-heading" style="margin-top:0"><?php esc_html_e( 'Scriptable by design', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:spacer {"height":"var:preset|spacing|10","style":{"layout":[]}} -->
<div style="height:var(--wp--preset--spacing--10)" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Anything you can do in the WordPress admin, you can do from the terminal. Install and update plugins, import content, create users, run search-replace across a database, rotate keys, manage multisite networks. Bundle any of it into a script, a cron job, or a deploy step. WP-CLI turns WordPress into something you can automate.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:spacer {"height":"var:preset|spacing|10","style":{"layout":[]}} -->
<div style="height:var(--wp--preset--spacing--10)" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline-on-dark"} -->
<div class="wp-block-button is-style-outline-on-dark"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( __( 'https://make.wordpress.org/cli/handbook/guides/quick-start/', 'wporg' ) ); ?>"><?php esc_html_e( 'Get started with WP-CLI', 'wporg' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline-on-dark"} -->
<div class="wp-block-button is-style-outline-on-dark"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( __( 'https://make.wordpress.org/cli/handbook/', 'wporg' ) ); ?>"><?php esc_html_e( 'Read the handbook', 'wporg' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Command grid"},"align":"full","style":{"border":{"top":{"color":"#3b3b3b","width":"1px"},"bottom":{"width":"0px","style":"none"}},"elements":{"link":{"color":{"text":"var:preset|color|light-grey-1"}}},"spacing":{"blockGap":"0"}},"backgroundColor":"charcoal-1","textColor":"light-grey-1","layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group alignfull has-light-grey-1-color has-charcoal-1-background-color has-text-color has-background has-link-color" style="border-top-color:#3b3b3b;border-top-width:1px;border-bottom-style:none;border-bottom-width:0px"><!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"25%"},"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|10","bottom":"var:preset|spacing|40","left":"var:preset|spacing|10"}},"border":{"bottom":{"color":"#3c3c3c","width":"1px"},"top":[],"right":{"color":"#303030","width":"1px"},"left":[]}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"center","justifyContent":"center","flexWrap":"wrap"}} -->
<div class="wp-block-group" style="border-right-color:#303030;border-right-width:1px;border-bottom-color:#3c3c3c;border-bottom-width:1px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--10);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--10)"><!-- wp:image {"id":50761,"width":"24px","height":"24px","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full is-resized"><img src="https://wordpress.org/files/2026/04/plugins-1.png" alt="" class="wp-image-50761" style="object-fit:cover;width:24px;height:24px" /></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"notranslate","style":{"typography":{"fontFamily":"monospace"}},"fontSize":"small"} -->
<p class="notranslate has-small-font-size" style="font-family:monospace">wp plugin</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"extra-small"} -->
<p class="has-extra-small-font-size"><?php esc_html_e( 'Install, activate, update', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"25%"},"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|10","bottom":"var:preset|spacing|40","left":"var:preset|spacing|10"}},"border":{"bottom":{"color":"#3c3c3c","width":"1px"},"top":[],"right":{"color":"#303030","width":"1px"},"left":[]}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"center","justifyContent":"center","flexWrap":"wrap"}} -->
<div class="wp-block-group" style="border-right-color:#303030;border-right-width:1px;border-bottom-color:#3c3c3c;border-bottom-width:1px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--10);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--10)"><!-- wp:image {"id":50771,"width":"24px","height":"24px","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full is-resized"><img src="https://wordpress.org/files/2026/04/themes-3.png" alt="" class="wp-image-50771" style="object-fit:cover;width:24px;height:24px" /></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"notranslate","style":{"typography":{"fontFamily":"monospace"}},"fontSize":"small"} -->
<p class="notranslate has-small-font-size" style="font-family:monospace">wp theme</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"extra-small"} -->
<p class="has-extra-small-font-size"><?php esc_html_e( 'Manage themes and child themes', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"25%"},"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|10","bottom":"var:preset|spacing|40","left":"var:preset|spacing|10"}},"border":{"bottom":{"color":"#3c3c3c","width":"1px"},"top":[],"right":{"color":"#303030","width":"1px"},"left":[]}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"center","justifyContent":"center","flexWrap":"wrap"}} -->
<div class="wp-block-group" style="border-right-color:#303030;border-right-width:1px;border-bottom-color:#3c3c3c;border-bottom-width:1px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--10);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--10)"><!-- wp:image {"id":50763,"width":"24px","height":"24px","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full is-resized"><img src="https://wordpress.org/files/2026/04/export.png" alt="" class="wp-image-50763" style="object-fit:cover;width:24px;height:24px" /></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"notranslate","style":{"typography":{"fontFamily":"monospace"}},"fontSize":"small"} -->
<p class="notranslate has-small-font-size" style="font-family:monospace">wp db</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"extra-small"} -->
<p class="has-extra-small-font-size"><?php esc_html_e( 'Export, import, search-replace', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"25%"},"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|10","bottom":"var:preset|spacing|40","left":"var:preset|spacing|10"}},"border":{"bottom":{"color":"#3c3c3c","width":"1px"},"top":[],"right":{"color":"#303030","width":"1px"},"left":[]}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"center","justifyContent":"center","flexWrap":"wrap"}} -->
<div class="wp-block-group" style="border-right-color:#303030;border-right-width:1px;border-bottom-color:#3c3c3c;border-bottom-width:1px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--10);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--10)"><!-- wp:image {"id":50766,"width":"24px","height":"24px","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full is-resized"><img src="https://wordpress.org/files/2026/04/user.png" alt="" class="wp-image-50766" style="object-fit:cover;width:24px;height:24px" /></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"notranslate","style":{"typography":{"fontFamily":"monospace"}},"fontSize":"small"} -->
<p class="notranslate has-small-font-size" style="font-family:monospace">wp user</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"extra-small"} -->
<p class="has-extra-small-font-size"><?php esc_html_e( 'Create, update, reset passwords', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"25%"},"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|10","bottom":"var:preset|spacing|40","left":"var:preset|spacing|10"}},"border":{"bottom":{"color":"#3c3c3c","width":"1px"},"top":[],"right":{"color":"#303030","width":"1px"},"left":[]}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"center","justifyContent":"center","flexWrap":"wrap"}} -->
<div class="wp-block-group" style="border-right-color:#303030;border-right-width:1px;border-bottom-color:#3c3c3c;border-bottom-width:1px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--10);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--10)"><!-- wp:image {"id":50770,"width":"24px","height":"24px","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full is-resized"><img src="https://wordpress.org/files/2026/04/post.png" alt="" class="wp-image-50770" style="object-fit:cover;width:24px;height:24px" /></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"notranslate","style":{"typography":{"fontFamily":"monospace"}},"fontSize":"small"} -->
<p class="notranslate has-small-font-size" style="font-family:monospace">wp post</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"extra-small"} -->
<p class="has-extra-small-font-size"><?php esc_html_e( 'Bulk create, edit, delete content', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"25%"},"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|10","bottom":"var:preset|spacing|40","left":"var:preset|spacing|10"}},"border":{"bottom":{"color":"#3c3c3c","width":"1px"},"top":[],"right":{"color":"#303030","width":"1px"},"left":[]}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"center","justifyContent":"center","flexWrap":"wrap"}} -->
<div class="wp-block-group" style="border-right-color:#303030;border-right-width:1px;border-bottom-color:#3c3c3c;border-bottom-width:1px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--10);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--10)"><!-- wp:image {"id":50769,"width":"24px","height":"24px","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full is-resized"><img src="https://wordpress.org/files/2026/04/core.png" alt="" class="wp-image-50769" style="object-fit:cover;width:24px;height:24px" /></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"notranslate","style":{"typography":{"fontFamily":"monospace"}},"fontSize":"small"} -->
<p class="notranslate has-small-font-size" style="font-family:monospace">wp core</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"extra-small"} -->
<p class="has-extra-small-font-size"><?php esc_html_e( 'Install, update, verify WordPress', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"25%"},"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|10","bottom":"var:preset|spacing|40","left":"var:preset|spacing|10"}},"border":{"bottom":{"color":"#3c3c3c","width":"1px"},"top":[],"right":{"color":"#303030","width":"1px"},"left":[]}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"center","justifyContent":"center","flexWrap":"wrap"}} -->
<div class="wp-block-group" style="border-right-color:#303030;border-right-width:1px;border-bottom-color:#3c3c3c;border-bottom-width:1px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--10);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--10)"><!-- wp:image {"id":50768,"width":"24px","height":"24px","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full is-resized"><img src="https://wordpress.org/files/2026/04/site.png" alt="" class="wp-image-50768" style="object-fit:cover;width:24px;height:24px" /></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"notranslate","style":{"typography":{"fontFamily":"monospace"}},"fontSize":"small"} -->
<p class="notranslate has-small-font-size" style="font-family:monospace">wp site</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"extra-small"} -->
<p class="has-extra-small-font-size"><?php esc_html_e( 'Manage multisite networks', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"style":{"layout":{"selfStretch":"fixed","flexSize":"25%"},"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|10","bottom":"var:preset|spacing|40","left":"var:preset|spacing|10"}},"border":{"bottom":{"color":"#3c3c3c","width":"1px"},"top":[],"right":{"color":"#303030","width":"1px"},"left":[]}},"layout":{"type":"flex","orientation":"vertical","verticalAlignment":"center","justifyContent":"center","flexWrap":"wrap"}} -->
<div class="wp-block-group" style="border-right-color:#303030;border-right-width:1px;border-bottom-color:#3c3c3c;border-bottom-width:1px;padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--10);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--10)"><!-- wp:image {"id":50767,"width":"24px","height":"24px","scale":"cover","sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full is-resized"><img src="https://wordpress.org/files/2026/04/scheduled.png" alt="" class="wp-image-50767" style="object-fit:cover;width:24px;height:24px" /></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"notranslate","style":{"typography":{"fontFamily":"monospace"}},"fontSize":"small"} -->
<p class="notranslate has-small-font-size" style="font-family:monospace">wp cron</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"fontSize":"extra-small"} -->
<p class="has-extra-small-font-size"><?php esc_html_e( 'Inspect and run scheduled events', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Automate anything"},"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|edge-space","right":"var:preset|spacing|edge-space"},"blockGap":"80px"},"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"backgroundColor":"charcoal-2","textColor":"white","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-white-color has-charcoal-2-background-color has-text-color has-background has-link-color" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--edge-space);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%"><!-- wp:heading {"fontSize":"heading-3"} -->
<h2 class="wp-block-heading has-heading-3-font-size"><?php esc_html_e( 'Automate anything', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:spacer {"height":"var:preset|spacing|10","style":{"layout":[]}} -->
<div style="height:var(--wp--preset--spacing--10)" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:paragraph {"className":"is-style-short-text"} -->
<p class="is-style-short-text"><?php esc_html_e( 'WP-CLI fits wherever you script. Bake it into a deploy pipeline to migrate a database between environments. Wire it into a GitHub Action to verify core integrity on every pull request. Run it from cron to rotate keys, prune transients, or regenerate thumbnails at 3 a.m.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:spacer {"height":"var:preset|spacing|10","style":{"layout":[]}} -->
<div style="height:var(--wp--preset--spacing--10)" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline-on-dark"} -->
<div class="wp-block-button is-style-outline-on-dark"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( __( 'https://developer.wordpress.org/cli/commands/', 'wporg' ) ); ?>"><?php esc_html_e( 'See automation recipes', 'wporg' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%"><!-- wp:code {"className":"notranslate","style":{"border":{"radius":"5px"},"spacing":{"padding":{"top":"var:preset|spacing|20","right":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"var:preset|spacing|20"}},"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"backgroundColor":"charcoal-3","textColor":"white","fontSize":"small"} -->
<pre class="wp-block-code notranslate has-white-color has-charcoal-3-background-color has-text-color has-background has-link-color has-small-font-size" style="border-radius:5px;padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)"><code>wp db export backup.sql
wp search-replace 'https://staging.example.com' 'https://example.com' --all-tables
wp cache flush</code></pre>
<!-- /wp:code --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Extend it"},"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|edge-space","right":"var:preset|spacing|edge-space"},"blockGap":"80px"},"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"backgroundColor":"charcoal-2","textColor":"white","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-white-color has-charcoal-2-background-color has-text-color has-background has-link-color" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--edge-space);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%"><!-- wp:code {"className":"notranslate","style":{"border":{"radius":"5px"},"spacing":{"padding":{"top":"var:preset|spacing|20","right":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"var:preset|spacing|20"}},"elements":{"link":{"color":{"text":"var:preset|color|white"}}}},"backgroundColor":"charcoal-3","textColor":"white","fontSize":"small"} -->
<pre class="wp-block-code notranslate has-white-color has-charcoal-3-background-color has-text-color has-background has-link-color has-small-font-size" style="border-radius:5px;padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)"><code>WP_CLI::add_command( 'hello', function () {
    WP_CLI::success( 'Hello from WP-CLI!' );
} );</code></pre>
<!-- /wp:code --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%"><!-- wp:heading {"fontSize":"heading-3"} -->
<h2 class="wp-block-heading has-heading-3-font-size"><?php esc_html_e( 'Extend it', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:spacer {"height":"var:preset|spacing|10","style":{"layout":[]}} -->
<div style="height:var(--wp--preset--spacing--10)" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:paragraph {"className":"is-style-short-text"} -->
<p class="is-style-short-text"><?php esc_html_e( 'WP-CLI is built to be extended. Write a custom command in a few lines of PHP and ship it as a plugin — or browse the community package index for one that already does what you need.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:spacer {"height":"var:preset|spacing|10","style":{"layout":[]}} -->
<div style="height:var(--wp--preset--spacing--10)" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline-on-dark"} -->
<div class="wp-block-button is-style-outline-on-dark"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( __( 'https://make.wordpress.org/cli/handbook/guides/commands-cookbook/', 'wporg' ) ); ?>"><?php esc_html_e( 'Write a custom command', 'wporg' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline-on-dark"} -->
<div class="wp-block-button is-style-outline-on-dark"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( __( 'https://packagist.org/search/?type=wp-cli-package', 'wporg' ) ); ?>"><?php esc_html_e( 'Browse packages', 'wporg' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Community"},"align":"full","style":{"spacing":{"padding":{"top":"5rem","bottom":"5rem","left":"var:preset|spacing|edge-space","right":"var:preset|spacing|edge-space"},"blockGap":"80px"}},"backgroundColor":"light-grey-2","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-light-grey-2-background-color has-background" style="padding-top:5rem;padding-right:var(--wp--preset--spacing--edge-space);padding-bottom:5rem;padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"40px","left":"40px"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"50%"} -->
<div class="wp-block-column" style="flex-basis:50%"><!-- wp:spacer {"height":"var:preset|spacing|20"} -->
<div style="height:var(--wp--preset--spacing--20)" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:heading {"fontSize":"heading-3"} -->
<h2 class="wp-block-heading has-heading-3-font-size"><?php esc_html_e( 'Maintained by the WordPress community', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:spacer {"height":"var:preset|spacing|10","style":{"layout":[]}} -->
<div style="height:var(--wp--preset--spacing--10)" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:paragraph {"className":"is-style-short-text"} -->
<p class="is-style-short-text"><?php esc_html_e( 'WP-CLI has shipped continuously since 2011, maintained by volunteers from across the WordPress ecosystem. Every release ships under public governance, and contributions take many forms — triage, docs, translation, command authorship, tests.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:spacer {"height":"10px","style":{"layout":[]}} -->
<div style="height:10px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( __( 'https://make.wordpress.org/cli/', 'wporg' ) ); ?>"><?php esc_html_e( 'Contribute', 'wporg' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( __( 'https://github.com/wp-cli/wp-cli/releases', 'wporg' ) ); ?>"><?php esc_html_e( 'Read the release notes', 'wporg' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

<!-- wp:group {"metadata":{"name":"Built for what's next"},"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|edge-space","bottom":"var:preset|spacing|40","left":"var:preset|spacing|edge-space"}},"elements":{"link":{"color":{"text":"var:preset|color|charcoal-1"}}}},"textColor":"charcoal-1","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-charcoal-1-color has-text-color has-link-color" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--edge-space);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:group {"metadata":{"name":"Separator"},"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide"><!-- wp:spacer {"height":"60px","className":"is-style-dots-background","style":{"spacing":{"margin":{"top":"40px","bottom":"40px"}}}} -->
<div style="margin-top:40px;margin-bottom:40px;height:60px" aria-hidden="true" class="wp-block-spacer is-style-dots-background"></div>
<!-- /wp:spacer -->

<!-- wp:spacer {"height":"var:preset|spacing|20"} -->
<div style="height:var(--wp--preset--spacing--20)" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div>
<!-- /wp:group -->

<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column {"width":"66.66%","style":{"spacing":{"padding":{"top":"0","right":"var:preset|spacing|default","bottom":"0","left":"var:preset|spacing|default"}}}} -->
<div class="wp-block-column" style="padding-top:0;padding-right:var(--wp--preset--spacing--default);padding-bottom:0;padding-left:var(--wp--preset--spacing--default);flex-basis:66.66%"><!-- wp:heading {"align":"wide","fontSize":"heading-3"} -->
<h2 class="wp-block-heading alignwide has-heading-3-font-size"><?php esc_html_e( "Built for what's next", 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:spacer {"height":"var:preset|spacing|10","style":{"layout":[]}} -->
<div style="height:var(--wp--preset--spacing--10)" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'The future of web management is autonomous, and WP-CLI is designed to lead the way. Beyond serving as a powerful interface for developers, it provides the standardized, command-driven architecture that AI agents and LLMs need to interact reliably with WordPress. By leveraging the Abilities API, AI connectors, and Model Context Protocol (MCP) support, WP-CLI turns WordPress into a fully agent-ready environment. Whether you are automating routine maintenance or building complex agentic workflows, WP-CLI provides the stable, programmable foundation required for the next generation of intelligence.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"style":{"spacing":{"margin":{"top":"30px"},"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:30px"><!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|blueberry-1"}}}}} -->
<p class="has-link-color"><?php _e( '<a href="https://developer.wordpress.org/cli/commands/#global-parameters">Explore output formats</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|blueberry-1"}}}}} -->
<p class="has-link-color"><?php _e( '<a href="https://developer.wordpress.org/cli/commands/">Read the handbook</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"elements":{"link":{"color":{"text":"var:preset|color|blueberry-1"}}}}} -->
<p class="has-link-color"><?php _e( '<a href="https://github.com/wp-cli/wp-cli">Star on GitHub</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:spacer {"height":"var:preset|spacing|60"} -->
<div style="height:var(--wp--preset--spacing--60)" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"50%"} -->
<div class="wp-block-column" style="flex-basis:50%"><!-- wp:image {"id":50775,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="https://wordpress.org/files/2026/04/WordPress_ASCII_texture.jpg" alt="" class="wp-image-50775" /></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
