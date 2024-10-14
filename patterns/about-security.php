<?php
/**
 * Title: Security
 * Slug: wporg-main-2022/security
 * Inserter: no
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","right":"var:preset|spacing|edge-space","left":"var:preset|spacing|edge-space","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--edge-space);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:heading {"level":1,"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|30"}}}} -->
<h1 class="wp-block-heading" style="margin-bottom:var(--wp--preset--spacing--30)"><?php _e( 'Security', 'wporg' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php
/* translators: [market_share] is a shortcode and should not be translated. */
_e( 'We take the security of the WordPress project and the ecosystem seriously. With <a href="https://wordpress.org/about/history/">over 20 years of history</a> and powering more than [market_share] of the web, we&#039;re committed to ensuring security for all, from solo bloggers to enterprise organizations.', 'wporg' );
?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'WordPress encourages responsible disclosure of vulnerabilities in WordPress core, in plugins and themes available on WordPress.org, or in the wider WordPress ecosystem.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"pomegrade-3","layout":{"type":"constrained"}} -->
<div class="wp-block-group has-pomegrade-3-background-color has-background" style="padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)"><!-- wp:paragraph -->
<p><?php _e( 'If you believe you have found a vulnerability in WordPress, please keep it confidential and <a href="https://make.wordpress.org/core/handbook/testing/reporting-security-vulnerabilities/">report it to the WordPress Security Team</a>.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'If you believe you have found a vulnerability in a WordPress plugin or theme available on WordPress.org, please keep it confidential.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul><!-- wp:list-item -->
<li><?php _e( 'For plugin vulnerabilities, <a href="https://developer.wordpress.org/plugins/wordpress-org/plugin-security/reporting-plugin-security-issues/">report it to the plugin developer and the plugins team</a>.', 'wporg' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php _e( 'For theme vulnerabilities, <a href="https://developer.wordpress.org/themes/theme-security/theme-security-issues/">report it to the theme developer and the theme review team</a>.', 'wporg' ); ?></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list --></div>
<!-- /wp:group -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php _e( 'Our process', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php
/* translators: [market_share] is a shortcode and should not be translated. */
_e( 'The WordPress project is committed to providing a stable, secure, trusted platform for more than [market_share] of the web. The <a href="https://make.wordpress.org/core/handbook/contribute/codebase/">core WordPress software development lifecycle</a> includes code review throughout the process, with open-source contributions reviewed by trusted committers.', 'wporg' );
?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'The WordPress Security Team works to identify and resolve security issues across the WordPress core software, harden the software against threats such as the <a href="https://owasp.org/www-project-top-ten/">OWASP Top Ten</a>, and <a href="https://developer.wordpress.org/apis/security/">provide guidance</a> across the ecosystem.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'In addition to more than 50 trusted experts, including lead developers, security researchers, and key contributors to every component of WordPress, <a href="https://wordpress.org/five-for-the-future/">sponsored members of the Security Team</a> dedicate time to identifying and addressing concerns in the software and ecosystem.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'To address responsibly-disclosed security vulnerabilities, the Security Team works to develop fixes, create robust test cases, and <a href="https://wordpress.org/news/category/security/">release those fixes in bugfix releases</a>. While only the latest version of WordPress is officially supported, the Security Team also <a href="https://make.wordpress.org/security/2022/09/07/dropping-security-updates-for-wordpress-versions-3-7-through-4-0/">backports fixes to older versions as a courtesy</a>, to ensure older sites receive critical security fixes via auto-updates.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'The Security Team also works directly with significant web hosting operators and security ecosystem providers to detect and mitigate threats to WordPress-based sites, including coordinating release rollouts and developing web application firewall (WAF) mitigations.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"spacing":{"padding":{"top":"var:preset|spacing|20","bottom":"var:preset|spacing|20","left":"var:preset|spacing|20","right":"var:preset|spacing|20"}}},"backgroundColor":"blueberry-4"} -->
<p class="has-blueberry-4-background-color has-background" style="padding-top:var(--wp--preset--spacing--20);padding-right:var(--wp--preset--spacing--20);padding-bottom:var(--wp--preset--spacing--20);padding-left:var(--wp--preset--spacing--20)"><?php _e( 'Learn more about the <a href="https://github.com/WordPress/Security-White-Paper/blob/master/WordPressSecurityWhitePaper.pdf?raw=true">WordPress project&#039;s security stance in our whitepaper</a>.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php _e( 'Plugin Developers', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'The <a href="https://developer.wordpress.org/apis/security/">Security guide in the Common APIs handbook</a> is your go-to guide for secure development principles.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'If you believe you&#039;ve identified a security problem in your own plugin, the WordPress plugins team is here to support you.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( '<a href="https://developer.wordpress.org/plugins/wordpress-org/plugin-security/">Find out more about how to address security issues in your plugin.</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php _e( 'Theme Developers', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"is-style-default"} -->
<p class="is-style-default"><?php _e( 'The <a href="https://developer.wordpress.org/apis/security/">Security guide in the Common APIs handbook</a> is your go-to guide for secure development principles.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'If you believe you&#039;ve identified a security problem in your own theme, the WordPress theme review team is here to support you.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( '<a href="https://developer.wordpress.org/themes/theme-security/theme-security-issues/">Find out more about how to address security issues in your theme.</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"100%","layout":{"type":"default"}} -->
<div class="wp-block-column" style="flex-basis:100%"><!-- wp:heading {"textAlign":"left"} -->
<h2 class="wp-block-heading has-text-align-left"><?php _e( 'Web Hosts', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"left"} -->
<p class="has-text-align-left"><?php _e( 'The <a href="https://developer.wordpress.org/advanced-administration/security/">Security guide in the Advanced Administration handbook</a> contains key information on how to secure your hosting environment.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"align":"left"} -->
<p class="has-text-align-left"><?php _e( 'We also strongly recommend <a href="https://cheatsheetseries.owasp.org/cheatsheets/Vulnerability_Disclosure_Cheat_Sheet.html#receiving-vulnerability-reports">publishing a responsible disclosure policy</a> of your own.', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
