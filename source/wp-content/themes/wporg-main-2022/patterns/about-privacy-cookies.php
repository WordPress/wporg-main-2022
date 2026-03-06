<?php
/**
 * Title: Cookie Policy
 * Slug: wporg-main-2022/cookies
 * Inserter: no
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","right":"var:preset|spacing|edge-space","left":"var:preset|spacing|edge-space","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--edge-space);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:heading {"level":1,"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|30"}}}} -->
<h1 class="wp-block-heading" style="margin-bottom:var(--wp--preset--spacing--30)"><?php esc_html_e( 'Cookie Policy', 'wporg' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Cookies', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php
printf(
	wp_kses_post(
		/* translators: %s: Link to the Privacy Policy. */
		__( 'Our <a href="%s">Privacy Policy</a> explains our principles when it comes to the collection, processing, and storage of your information. The Cookie Policy specifically explains how we, our partners, and users of our services deploy cookies, as well as the options you have to control them.', 'wporg' )
	),
	esc_url( home_url( '/about/privacy/' ) )
);
?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'What are cookies?', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Cookies are small pieces of data, stored in text files, that are stored on your computer or other device when websites are loaded in a browser. They are widely used to &#8216;remember&#8217; you and your preferences, either for a single visit (through a &#8216;session cookie&#8217;) or for multiple repeat visits (using a &#8216;persistent cookie&#8217;). They ensure a consistent and efficient experience for visitors, and perform essential functions such as allowing users to register and remain logged in. Cookies may be set by the site that you are visiting (known as &#8216;first party cookies&#8217;), or by third parties, such as those who serve content or provide advertising or analytics services on the website (&#8216;third party cookies&#8217;).', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Cookies set by WordPress.org', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'We use cookies for a number of different purposes. Some cookies are necessary for technical reasons; some enable a personalized experience for both visitors and registered users; and some allow the display of advertising from selected third party networks. Some of these cookies may be set when a page is loaded, or when a visitor takes a particular action (clicking the &#8216;like&#8217; or &#8216;follow&#8217; button on a post, for example).', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Below the different categories of cookies set by WordPress.org are outlined, with specific examples detailed in the tables that follow. This includes their name and purpose. Certain cookies are only set for logged-in visitors, whereas others are set for any visitors, and these are marked below accordingly. Where a cookie only applies to specific subdomains, they are included under the relevant header.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong><?php esc_html_e( 'Strictly Necessary', 'wporg' ); ?></strong>: <?php esc_html_e( 'These are the cookies that are essential for WordPress.org to perform basic functions. These include those required to allow registered users to authenticate and perform account related functions.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong><?php esc_html_e( 'Functionality', 'wporg' ); ?></strong>: <?php esc_html_e( 'These cookies are used to store preferences set by users such as account name, language, and location.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong><?php esc_html_e( 'Performance', 'wporg' ); ?></strong>: <?php esc_html_e( 'Performance cookies collect information on how users interact with websites hosted on WordPress.org, including what pages are visited most, as well as other analytical data. These details are only used to improve how the website functions.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong><?php esc_html_e( 'Tracking', 'wporg' ); ?></strong>: <?php esc_html_e( 'These are set by trusted third party networks (e.g. Google Analytics) to track details such as the number of unique visitors, and pageviews to help improve the user experience.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong><?php esc_html_e( 'Third Party/Embedded Content', 'wporg' ); ?></strong>: <?php esc_html_e( 'WordPress.org makes use of different third party applications and services to enhance the experience of website visitors. These include social media platforms such as Facebook and Twitter (through the use of sharing buttons), or embedded content from YouTube and Vimeo. As a result, cookies may be set by these third parties, and used by them to track your online activity. We have no direct control over the information that is collected by these cookies.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'wordpress.org', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:table -->
<figure class="wp-block-table"><table><thead><tr><th><?php esc_html_e( 'Cookie', 'wporg' ); ?></th><th><?php esc_html_e( 'Duration', 'wporg' ); ?></th><th><?php esc_html_e( 'Purpose', 'wporg' ); ?></th><th><?php esc_html_e( 'Logged-in Users Only?', 'wporg' ); ?></th></tr></thead><tbody><tr><td>_ga</td><td><?php esc_html_e( '2 years', 'wporg' ); ?></td><td><a href="https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage#gtagjs_google_analytics_4_-_cookie_usage"><?php esc_html_e( 'Google Analytics', 'wporg' ); ?></a> - <?php esc_html_e( 'Used to distinguish users.', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>_ga_&lt;property-id&gt;</td><td><?php esc_html_e( '2 years', 'wporg' ); ?></td><td><a href="https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage#gtagjs_google_analytics_4_-_cookie_usage"><?php esc_html_e( 'Google Analytics', 'wporg' ); ?></a> - <?php esc_html_e( 'Used to persist session state.', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>devicePixelRatio</td><td><?php esc_html_e( 'Browser default (1 year)', 'wporg' ); ?></td><td><?php esc_html_e( 'Used to make the site responsive to the visitor&#8217;s screen size.', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>wordpress_test_cookie</td><td><?php esc_html_e( 'Session', 'wporg' ); ?></td><td><?php esc_html_e( 'Tests that the browser accepts cookies.', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>tk_ai</td><td><?php esc_html_e( '24 hours', 'wporg' ); ?></td><td><a href="https://jetpack.com/support/cookies/"><?php esc_html_e( 'Jetpack', 'wporg' ); ?></a> - <?php esc_html_e( 'Stores the unique identifier for the publisher to enable Jetpack to collect data.', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>tk_lr</td><td><?php esc_html_e( '1 year', 'wporg' ); ?></td><td><a href="https://jetpack.com/support/cookies/"><?php esc_html_e( 'Jetpack', 'wporg' ); ?></a> - <?php esc_html_e( 'Stores the unique identifier for the publisher to enable Jetpack to collect data.', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>tk_or</td><td><?php esc_html_e( '5 years', 'wporg' ); ?></td><td><a href="https://jetpack.com/support/cookies/"><?php esc_html_e( 'Jetpack', 'wporg' ); ?></a> - <?php esc_html_e( 'Stores the unique identifier for the publisher to enable Jetpack to collect data.', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>wp-settings-{user_id}</td><td><?php esc_html_e( '1 year', 'wporg' ); ?></td><td><?php esc_html_e( 'Used to persist a user&#8217;s wp-admin configuration.', 'wporg' ); ?></td><td><?php esc_html_e( 'Yes', 'wporg' ); ?></td></tr><tr><td>wporg_logged_in<br/>wporg_sec</td><td><?php esc_html_e( '14 days if you select &#8220;Remember Me&#8221; when logging in. Otherwise, Session.', 'wporg' ); ?></td><td><?php esc_html_e( 'Used to check whether the current visitor is a logged-in WordPress.org user.', 'wporg' ); ?></td><td><?php esc_html_e( 'Yes', 'wporg' ); ?></td></tr><tr><td>wporg_locale</td><td><?php esc_html_e( '1 year', 'wporg' ); ?></td><td><?php esc_html_e( 'Used to persist a user&#8217;s locale configuration.', 'wporg' ); ?></td><td><?php esc_html_e( 'Yes', 'wporg' ); ?></td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'make.wordpress.org', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:table -->
<figure class="wp-block-table"><table><thead><tr><th><?php esc_html_e( 'Cookie', 'wporg' ); ?></th><th><?php esc_html_e( 'Duration', 'wporg' ); ?></th><th><?php esc_html_e( 'Purpose', 'wporg' ); ?></th><th><?php esc_html_e( 'Logged-in Users Only?', 'wporg' ); ?></th></tr></thead><tbody><tr><td>_ga</td><td><?php esc_html_e( '2 years', 'wporg' ); ?></td><td><a href="https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage#gtagjs_google_analytics_4_-_cookie_usage"><?php esc_html_e( 'Google Analytics', 'wporg' ); ?></a> - <?php esc_html_e( 'Used to distinguish users.', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>_ga_&lt;property-id&gt;</td><td><?php esc_html_e( '2 years', 'wporg' ); ?></td><td><a href="https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage#gtagjs_google_analytics_4_-_cookie_usage"><?php esc_html_e( 'Google Analytics', 'wporg' ); ?></a> - <?php esc_html_e( 'Used to persist session state.', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>welcome-{blog_id}</td><td><?php esc_html_e( 'Permanent', 'wporg' ); ?></td><td><?php esc_html_e( 'Used to record if you&#8217;ve chosen to hide the &#8220;Welcome&#8221; message at the top of the corresponding blog.', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>showComments</td><td><?php esc_html_e( '10 years', 'wporg' ); ?></td><td><?php esc_html_e( 'Used to determine if you prefer comments to be shown or hidden when reading the site.', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( '*.trac.wordpress.org', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:table -->
<figure class="wp-block-table"><table><thead><tr><th><?php esc_html_e( 'Cookie', 'wporg' ); ?></th><th><?php esc_html_e( 'Duration', 'wporg' ); ?></th><th><?php esc_html_e( 'Purpose', 'wporg' ); ?></th><th><?php esc_html_e( 'Logged-in Users Only?', 'wporg' ); ?></th></tr></thead><tbody><tr><td>_ga</td><td><?php esc_html_e( '2 years', 'wporg' ); ?></td><td><a href="https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage#gtagjs_google_analytics_4_-_cookie_usage"><?php esc_html_e( 'Google Analytics', 'wporg' ); ?></a> - <?php esc_html_e( 'Used to distinguish users.', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>_ga_&lt;property-id&gt;</td><td><?php esc_html_e( '2 years', 'wporg' ); ?></td><td><a href="https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage#gtagjs_google_analytics_4_-_cookie_usage"><?php esc_html_e( 'Google Analytics', 'wporg' ); ?></a> - <?php esc_html_e( 'Used to persist session state.', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>trac_form_token</td><td><?php esc_html_e( 'Session', 'wporg' ); ?></td><td><?php esc_html_e( 'Used as a security token for cross-site request forgery protection.', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>trac_session</td><td><?php esc_html_e( '90 days', 'wporg' ); ?></td><td><?php esc_html_e( 'Used to keep anonymous session information.', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'codex.wordpress.org', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:table -->
<figure class="wp-block-table"><table><thead><tr><th><?php esc_html_e( 'Cookie', 'wporg' ); ?></th><th><?php esc_html_e( 'Duration', 'wporg' ); ?></th><th><?php esc_html_e( 'Purpose', 'wporg' ); ?></th><th><?php esc_html_e( 'Logged-in Users Only?', 'wporg' ); ?></th></tr></thead><tbody><tr><td>_ga</td><td><?php esc_html_e( '2 years', 'wporg' ); ?></td><td><a href="https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage#gtagjs_google_analytics_4_-_cookie_usage"><?php esc_html_e( 'Google Analytics', 'wporg' ); ?></a> - <?php esc_html_e( 'Used to distinguish users.', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>_ga_&lt;property-id&gt;</td><td><?php esc_html_e( '2 years', 'wporg' ); ?></td><td><a href="https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage#gtagjs_google_analytics_4_-_cookie_usage"><?php esc_html_e( 'Google Analytics', 'wporg' ); ?></a> - <?php esc_html_e( 'Used to persist session state.', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>codexToken</td><td><?php esc_html_e( '6 months', 'wporg' ); ?></td><td><?php esc_html_e( 'Used to check whether the current visitor is a logged-in WordPress.org user. Only set if you select &#8220;Keep me logged in&#8221; when logging in.', 'wporg' ); ?></td><td><?php esc_html_e( 'Yes', 'wporg' ); ?></td></tr><tr><td>codexUserId<br/>codexUserName</td><td><?php esc_html_e( '6 months', 'wporg' ); ?></td><td><?php esc_html_e( 'Used to check whether the current visitor is a logged-in WordPress.org user.', 'wporg' ); ?></td><td><?php esc_html_e( 'Yes', 'wporg' ); ?></td></tr><tr><td>codex_session</td><td><?php esc_html_e( 'Session', 'wporg' ); ?></td><td><?php esc_html_e( 'Used to check whether the current visitor is a logged-in WordPress.org user.', 'wporg' ); ?></td><td><?php esc_html_e( 'Yes', 'wporg' ); ?></td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( '*.wordcamp.org', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:table -->
<figure class="wp-block-table"><table><thead><tr><th><?php esc_html_e( 'Cookie', 'wporg' ); ?></th><th><?php esc_html_e( 'Duration', 'wporg' ); ?></th><th><?php esc_html_e( 'Purpose', 'wporg' ); ?></th><th><?php esc_html_e( 'Logged-in Users Only?', 'wporg' ); ?></th></tr></thead><tbody><tr><td>_ga</td><td><?php esc_html_e( '2 years', 'wporg' ); ?></td><td><a href="https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage#gtagjs_google_analytics_4_-_cookie_usage"><?php esc_html_e( 'Google Analytics', 'wporg' ); ?></a> - <?php esc_html_e( 'Used to distinguish users.', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>_ga_&lt;property-id&gt;</td><td><?php esc_html_e( '2 years', 'wporg' ); ?></td><td><a href="https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage#gtagjs_google_analytics_4_-_cookie_usage"><?php esc_html_e( 'Google Analytics', 'wporg' ); ?></a> - <?php esc_html_e( 'Used to persist session state.', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>camptix_client_stats</td><td><?php esc_html_e( '1 year', 'wporg' ); ?></td><td><?php esc_html_e( 'Used to track unique visitors to tickets page on a WordCamp site', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>wp-saving-post</td><td><?php esc_html_e( '1 day', 'wporg' ); ?></td><td><?php esc_html_e( 'Used to track if there is saved post exists for a post currently being edited. If exists then let user restore the data', 'wporg' ); ?></td><td><?php esc_html_e( 'Yes', 'wporg' ); ?></td></tr><tr><td>comment_author_{hash}</td><td><?php esc_html_e( '347 days', 'wporg' ); ?></td><td><?php esc_html_e( 'Used to tracked comment author name, if &#8220;Save my name, email, and website in this browser for the next time I comment.&#8221; is checked', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>comment_author_email_{hash}</td><td><?php esc_html_e( '347 days', 'wporg' ); ?></td><td><?php esc_html_e( 'Used to tracked comment author email, if &#8220;Save my name, email, and website in this browser for the next time I comment.&#8221; is checked', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>comment_author_url_{hash}</td><td><?php esc_html_e( '347 days', 'wporg' ); ?></td><td><?php esc_html_e( 'Used to track comment author url, if &#8220;Save my name, email, and website in this browser for the next time I comment.&#8221; checkbox is checked', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>wp-postpass_{hash}</td><td><?php esc_html_e( '10 days', 'wporg' ); ?></td><td><?php esc_html_e( 'Used to maintain session if a post is password protected', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>wp-settings-{user}</td><td><?php esc_html_e( '1 year', 'wporg' ); ?></td><td><?php esc_html_e( 'Used to preserve user&#8217;s wp-admin settings', 'wporg' ); ?></td><td><?php esc_html_e( 'Yes', 'wporg' ); ?></td></tr><tr><td>wp-settings-time-{user}</td><td><?php esc_html_e( '1 year', 'wporg' ); ?></td><td><?php esc_html_e( 'Time at which wp-settings-{user} was set', 'wporg' ); ?></td><td><?php esc_html_e( 'Yes', 'wporg' ); ?></td></tr><tr><td>tix_view_token</td><td><?php esc_html_e( '2 days', 'wporg' ); ?></td><td><?php esc_html_e( 'Used for session managing private CampTix content', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>tk_ai</td><td><?php esc_html_e( 'Browser default', 'wporg' ); ?></td><td><?php esc_html_e( 'Used for tracking', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>jetpackState</td><td><?php esc_html_e( 'Session', 'wporg' ); ?></td><td><?php esc_html_e( 'Used for maintaining Jetpack State', 'wporg' ); ?></td><td><?php esc_html_e( 'Yes', 'wporg' ); ?></td></tr><tr><td>jpp_math_pass</td><td><?php esc_html_e( 'Session', 'wporg' ); ?></td><td><?php esc_html_e( 'Verifies that a user answered the math problem correctly while logging in.', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>stnojs</td><td><?php esc_html_e( '2 days', 'wporg' ); ?></td><td><?php esc_html_e( 'Remember if user do not want JavaScript executed', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr><tr><td>wordpress_logged_in_{hash}</td><td><?php esc_html_e( 'Session', 'wporg' ); ?></td><td><?php esc_html_e( 'Remember User session', 'wporg' ); ?></td><td><?php esc_html_e( 'Yes', 'wporg' ); ?></td></tr><tr><td>wordpress_test_cookie</td><td><?php esc_html_e( 'Session', 'wporg' ); ?></td><td><?php esc_html_e( 'Test if cookie can be set', 'wporg' ); ?></td><td><?php esc_html_e( 'No', 'wporg' ); ?></td></tr></tbody></table></figure>
<!-- /wp:table -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php esc_html_e( 'Controlling Cookies', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Visitors may wish to restrict the use of cookies, or completely prevent them from being set. Most browsers provide for ways to control cookie behavior such as the length of time they are stored &#8212; either through built-in functionality or by utilizing third party plugins.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php
printf(
	wp_kses_post(
		/* translators: %1$s: aboutcookies.org URL, %2$s: youronlinechoices.eu URL, %3$s: aboutads.info URL */
		__( 'To find out more on how to manage and delete cookies, visit <a href="%1$s">aboutcookies.org</a>. For more details on advertising cookies, and how to manage them, visit <a href="%2$s">youronlinechoices.eu</a> (EU based), or <a href="%3$s">aboutads.info</a> (US based).', 'wporg' )
	),
	'https://www.aboutcookies.org/',
	'https://youronlinechoices.eu/',
	'http://www.aboutads.info/choices/'
);
?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'Some specific opt-out programs are available here:', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Google Analytics - <a href="https://tools.google.com/dlpage/gaoptout">https://tools.google.com/dlpage/gaoptout</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'It&#8217;s important to note that restricting or disabling the use of cookies can limit the functionality of sites, or prevent them from working correctly at all.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:image {"linkDestination":"custom"} -->
<figure class="wp-block-image"><a href="https://creativecommons.org/licenses/by-sa/4.0/"><img src="https://s.w.org/images/home/ccbysa40.png" alt="<?php esc_attr_e( 'Creative Commons License', 'wporg' ); ?>" /></a></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->
