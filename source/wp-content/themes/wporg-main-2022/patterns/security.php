<?php
/**
 * Title: Security 2
 * Slug: wporg-main-2022/security
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
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--edge-space);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:heading {"level":1,"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|30"}}},"fontSize":"heading-2"} -->
<h1 class="wp-block-heading has-heading-2-font-size" style="margin-bottom:var(--wp--preset--spacing--30)"><?php _e( 'Security', 'wporg' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'Learn more about WordPress core software security in this free white paper. You can also download it in&nbsp;<a href="https://github.com/WordPress/Security-White-Paper/blob/master/WordPressSecurityWhitePaper.pdf?raw=true">PDF format</a>.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php _e( 'Overview', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'This document is an analysis and explanation of the WordPress core software development and its related security processes, as well as an examination of the inherent security built directly into the software. Decision makers evaluating WordPress as a content management system or web application framework should use this document in their analysis and decision-making, and for developers to refer to it to familiarize themselves with the security components and best practices of the software.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'The information in this document is up-to-date for the latest stable release of the software, WordPress 4.7 at time of publication, but should be considered relevant also to the most recent versions of the software as backwards compatibility is a strong focus for the WordPress development team. Specific security measures and changes will be noted as they have been added to the core software in specific releases. It is strongly encouraged to always be running the latest stable version of WordPress to ensure the most secure experience possible.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php _e( 'Executive summary', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'WordPress is a dynamic open-source content management system which is used to power millions of websites, web applications, and blogs. It currently powers more than 43% of the top 10 million websites on the Internet. WordPress’ usability, extensibility, and mature development community make it a popular and secure choice for websites of all sizes.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'Since its inception in 2003, WordPress has undergone continual hardening so its core software can address and mitigate common security threats, including the Top 10 list identified by The Open Web Application Security Project (OWASP) as common security vulnerabilities, which are discussed in this document.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'The WordPress Security Team, in collaboration with the WordPress Core Leadership Team and backed by the WordPress global community, works to identify and resolve security issues in the core software available for distribution and installation at WordPress.org, as well as recommending and documenting security best practices for third-party plugin and theme authors.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'Site developers and administrators should pay particular attention to the correct use of core APIs and underlying server configuration which have been the source of common vulnerabilities, as well as ensuring all users employ strong passwords to access WordPress.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php _e( 'An overview of WordPress', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'WordPress is a free and open source content management system (CMS). It is the most widely-used CMS software in the world and it powers more than 43% of the top 10 million websites<sup id="ref1"><a href="#footnote1">1</a></sup>, giving it an estimated 62% market share of all sites using a CMS.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'WordPress is licensed under the General Public License (GPLv2 or later) which provides four core freedoms, and can be considered as the WordPress “bill of rights”:', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list {"ordered":true} -->
<ol><!-- wp:list-item -->
<li><?php _e( 'The freedom to run the program, for any purpose.', 'wporg' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php _e( 'The freedom to study how the program works, and change it to make it do what you wish.', 'wporg' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php _e( 'The freedom to redistribute.', 'wporg' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php _e( 'The freedom to distribute copies of your modified versions to others.', 'wporg' ); ?></li>
<!-- /wp:list-item --></ol>
<!-- /wp:list -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php _e( 'The WordPress Core leadership team', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'The WordPress project is a meritocracy, run by a core leadership team, and led by its co-creator and lead developer, Matt Mullenweg. The team governs all aspects of the project, including core development, WordPress.org, and community initiatives.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'The Core Leadership Team consists of Matt Mullenweg, five lead developers, and more than a dozen core developers with permanent commit access. These developers have final authority on technical decisions, and lead architecture discussions and implementation efforts.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'WordPress has a number of contributing developers. Some of these are former or current committers, and some are likely future committers. These contributing developers are trusted and veteran contributors to WordPress who have earned a great deal of respect among their peers. As needed, WordPress also has guest committers, individuals who are granted commit access, sometimes for a specific component, on a temporary or trial basis.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'The core and contributing developers primarily guide WordPress development. Every version, hundreds of developers contribute code to WordPress. These core contributors are volunteers who contribute to the core codebase in some way.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php _e( 'The WordPress release cycle', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'Each WordPress release cycle is led by one or more of the core WordPress developers. A release cycle usually lasts around 4 months from the initial scoping meeting to launch of the version.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'A release cycle follows the following pattern<sup id="ref2"><a href="#footnote2">2</a></sup>:', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"is-style-list-long-items"} -->
<ul class="is-style-list-long-items"><!-- wp:list-item -->
<li><?php _e( 'Phase 1: Planning and securing team leads. This is done in the #core chat room on Slack. The release lead discusses features for the next release of WordPress. WordPress contributors get involved with that discussion. The release lead will identify team leads for each of the features.', 'wporg' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php _e( 'Phase 2: Development work begins. Team leads assemble teams and work on their assigned features. Regular chats are scheduled to ensure the development keeps moving forward.', 'wporg' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php _e( 'Phase 3: Beta. Betas are released, and beta-testers are asked to start reporting bugs. No more commits for new enhancements or feature requests are carried out from this phase on. Third-party plugin and theme authors are encouraged to test their code against the upcoming changes.', 'wporg' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php _e( 'Phase 4: Release Candidate. There is a string freeze for translatable strings from this point on. Work is targeted on regressions and blockers only.', 'wporg' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php _e( 'Phase 5: Launch. WordPress version is launched and made available in the WordPress Admin for updates.', 'wporg' ); ?></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php _e( 'Version numbering and security releases', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'A major WordPress version is dictated by the first two sequences. For example, 3.5 is a major release, as is 3.6, 3.7, or 4.0. There isn’t a “WordPress 3” or “WordPress 4” and each major release is referred to by its numbering, e.g., “WordPress 3.9.”', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'Major releases may add new user features and developer APIs. Though typically in the software world, a “major” version means you can break backwards compatibility, WordPress strives to never break backwards compatibility. Backwards compatibility is one of the project’s most important philosophies, with the aim of making updates much easier on users and developers alike.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'A minor WordPress version is dictated by the third sequence. Version 3.5.1 is a minor release, as is 3.4.2<sup id="ref3"><a href="#footnote3">3</a></sup>. A minor release is reserved for fixing security vulnerabilities and addressing critical bugs only. Since new versions of WordPress are released so frequently — the aim is every 4-5 months for a major release, and minor releases happen as needed — there is only a need for major and minor releases.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php _e( 'Version backwards compatibility', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'The WordPress project has a strong commitment to backwards compatibility. This commitment means that themes, plugins, and custom code continues to function when WordPress core software is updated, encouraging site owners to keep their WordPress version updated to the latest secure release.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php _e( 'WordPress and security', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php _e( 'The WordPress Security Team', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'The WordPress Security Team is made up of approximately 50 experts including lead developers and security researchers — about half are employees of Automattic (makers of WordPress.com, the earliest and largest WordPress hosting platform on the web), and a number work in the web security field. The team consults with well-known and trusted security researchers and hosting companies<sup id="ref3"><a href="#footnote3">3</a></sup>.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'The WordPress Security Team often collaborates with other security teams to address issues in common dependencies, such as resolving the vulnerability in the PHP XML parser, used by the XML-RPC API that ships with WordPress, in WordPress 3.9.2<sup id="ref4"><a href="#footnote4">4</a></sup>. This vulnerability resolution was a result of a joint effort by both WordPress and Drupal security teams.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php _e( 'WordPress security risks, process, and history', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'The WordPress Security Team believes in Responsible Disclosure by alerting the security team immediately of any potential vulnerabilities. Potential security vulnerabilities can be signaled to the Security Team via the&nbsp;<a href="https://hackerone.com/wordpress">WordPress HackerOne</a><sup id="ref5"><a href="#footnote5">5</a></sup>. The Security Team communicates amongst itself via a private Slack channel, and works on a walled-off, private Trac for tracking, testing, and fixing bugs and security problems.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'Each security report is acknowledged upon receipt, and the team works to verify the vulnerability and determine its severity. If confirmed, the security team then plans for a patch to fix the problem which can be committed to an upcoming release of the WordPress software or it can be pushed as an immediate security release, depending on the severity of the issue.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'For an immediate security release, an advisory is published by the Security Team to the WordPress.org News site<sup id="ref6"><a href="#footnote6">6</a></sup>&nbsp;announcing the release and detailing the changes. Credit for the responsible disclosure of a vulnerability is given in the advisory to encourage and reinforce continued responsible reporting in the future.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'Administrators of the WordPress software see a notification on their site dashboard to upgrade when a new release is available, and following the manual upgrade users are redirected to the About WordPress screen which details the changes. If administrators have automatic background updates enabled, they will receive an email after an upgrade has been completed.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php _e( 'Automatic background updates for security releases', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'Starting with version 3.7, WordPress introduced automated background updates for all minor releases<sup id="ref7"><a href="#footnote7">7</a></sup>, such as 3.7.1 and 3.7.2. The WordPress Security Team can identify, fix, and push out automated security enhancements for WordPress without the site owner needing to do anything on their end, and the security update will install automatically.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'When a security update is pushed for the current stable release of WordPress, the core team will also push security updates for all the releases that are capable of background updates (since WordPress 3.7), so these older but still recent versions of WordPress will receive security enhancements.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'Individual site owners can opt to remove automatic background updates through a simple change in their configuration file, but keeping the functionality is strongly recommended by the core team, as well as running the latest stable release of WordPress.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php _e( '2013 OWASP Top 10', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'The Open Web Application Security Project (OWASP) is an online community dedicated to web application security. The OWASP Top 10 list<sup id="ref8"><a href="#footnote8">8</a></sup>&nbsp;focuses on identifying the most serious application security risks for a broad array of organizations. The Top 10 items are selected and prioritized in combination with consensus estimates of exploitability, detectability, and impact estimates.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'The following sections discuss the APIs, resources, and policies that WordPress uses to strengthen the core software and 3rd party plugins and themes against these potential risks.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading"><?php _e( 'A1 - Injection', 'wporg' ); ?></h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'There is a set of functions and APIs available in WordPress to assist developers in making sure unauthorized code cannot be injected, and help them validate and sanitize data. Best practices and documentation are available<sup id="ref9"><a href="#footnote9">9</a></sup>&nbsp;on how to use these APIs to protect, validate, or sanitize input and output data in HTML, URLs, HTTP headers, and when interacting with the database and filesystem. Administrators can also further restrict the types of file which can be uploaded via filters.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading"><?php _e( 'A2 - Broken Authentication and Session Management', 'wporg' ); ?></h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'WordPress core software manages user accounts and authentication and details such as the user ID, name, and password are managed on the server-side, as well as the authentication cookies. Passwords are protected in the database using standard salting and stretching techniques. Existing sessions are destroyed upon logout for versions of WordPress after 4.0.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading"><?php _e( 'A3 - Cross Site Scripting (XSS)', 'wporg' ); ?></h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'WordPress provides a range of functions which can help ensure that user-supplied data is safe<sup id="ref10"><a href="#footnote10">10</a></sup>. Trusted users, that is administrators and editors on a single WordPress installation, and network administrators only in WordPress Multisite, can post unfiltered HTML or JavaScript as they need to, such as inside a post or page. Untrusted users and user-submitted content is filtered by default to remove dangerous entities, using the KSES library through the&nbsp;<code>wp_kses</code>&nbsp;function.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'As an example, the WordPress core team noticed before the release of WordPress 2.3 that the function&nbsp;<code>the_search_query()</code>&nbsp;was being misused by most theme authors, who were not escaping the function’s output for use in HTML. In a very rare case of slightly breaking backward compatibility, the function’s output was changed in WordPress 2.3 to be pre-escaped.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading"><?php _e( 'A4 - Insecure Direct Object Reference', 'wporg' ); ?></h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'WordPress often provides direct object reference, such as unique numeric identifiers of user accounts or content available in the URL or form fields. While these identifiers disclose direct system information, WordPress’ rich permissions and access control system prevent unauthorized requests.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading"><?php _e( 'A5 - Security Misconfiguration', 'wporg' ); ?></h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'The majority of the WordPress security configuration operations are limited to a single authorized administrator. Default settings for WordPress are continually evaluated at the core team level, and the WordPress core team provides documentation and best practices to tighten security for server configuration for running a WordPress site<sup id="ref11"><a href="#footnote11">11</a></sup>.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading"><?php _e( 'A6 - Sensitive Data Exposure', 'wporg' ); ?></h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'WordPress user account passwords are salted and hashed based on the Portable PHP Password Hashing Framework<sup id="ref12"><a href="#footnote12">12</a></sup>. WordPress’ permission system is used to control access to private information such an registered users’ PII, commenters’ email addresses, privately published content, etc. In WordPress 3.7, a password strength meter was included in the core software providing additional information to users setting their passwords and hints on increasing strength. WordPress also has an optional configuration setting for requiring HTTPS.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading"><?php _e( 'A7 - Missing Function Level Access Control', 'wporg' ); ?></h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'WordPress checks for proper authorization and permissions for any function level access requests prior to the action being executed. Access or visualization of administrative URLs, menus, and pages without proper authentication is tightly integrated with the authentication system to prevent access from unauthorized users.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading"><?php _e( 'A8 - Cross Site Request Forgery (CSRF)', 'wporg' ); ?></h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'WordPress uses cryptographic tokens, called nonces<sup id="ref13"><a href="#footnote13">13</a></sup>, to validate intent of action requests from authorized users to protect against potential CSRF threats. WordPress provides an API for the generation of these tokens to create and verify unique and temporary tokens, and the token is limited to a specific user, a specific action, a specific object, and a specific time period, which can be added to forms and URLs as needed. Additionally, all nonces are invalidated upon logout.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading"><?php _e( 'A9 - Using Components with Known Vulnerabilities', 'wporg' ); ?></h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'The WordPress core team closely monitors the few included libraries and frameworks WordPress integrates with for core functionality. In the past the core team has made contributions to several third-party components to make them more secure, such as the update to fix a cross-site vulnerability in TinyMCE in WordPress 3.5.2<sup id="ref14"><a href="#footnote14">14</a></sup>.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'If necessary, the core team may decide to fork or replace critical external components, such as when the SWFUpload library was officially replaced by the Plupload library in 3.5.2, and a secure fork of SWFUpload was made available by the security team<sup id="ref15"><a href="#footnote15">15</a></sup>&nbsp;for those plugins who continued to use SWFUpload in the short-term.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading"><?php _e( 'A10 - Unvalidated Redirects and Forwards', 'wporg' ); ?></h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'WordPress’ internal access control and authentication system will protect against attempts to direct users to unwanted destinations or automatic redirects. This functionality is also made available to plugin developers via an API,&nbsp;<code>wp_safe_redirect()</code><sup id="ref16"><a href="#footnote16">16</a></sup>.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php _e( 'Further security risks and concerns', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading"><?php _e( 'XXE (XML eXternal Entity) processing attacks', 'wporg' ); ?></h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'When processing XML, WordPress disables the loading of custom XML entities to prevent both External Entity and Entity Expansion attacks. Beyond PHP’s core functionality, WordPress does not provide additional secure XML processing API for plugin authors.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading"><?php _e( 'SSRF (Server Side Request Forgery) Attacks', 'wporg' ); ?></h4>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'HTTP requests issued by WordPress are filtered to prevent access to loopback and private IP addresses. Additionally, access is only allowed to certain standard HTTP ports.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php _e( 'WordPress plugin and theme security', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php _e( 'The default theme', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'WordPress requires a theme to be enabled to render content visible on the frontend. The default theme which ships with core WordPress (currently "Twenty Twenty-Three") has been vigorously reviewed and tested for security reasons by both the team of theme developers plus the core development team.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'The default theme can serve as a starting point for custom theme development, and site developers can create a child theme which includes some customization but falls back on the default theme for most functionality and security. The default theme can be easily removed by an administrator if not needed.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php _e( 'WordPress.org theme and plugin repositories', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'There are approximately 50,000+ plugins and 5,000+ themes listed on the WordPress.org site. These themes and plugins are submitted for inclusion and are manually reviewed by volunteers before making them available on the repository.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'Inclusion of plugins and themes in the repository is not a guarantee that they are free from security vulnerabilities. Guidelines are provided for plugin authors to consult prior to submission for inclusion in the repository<sup id="ref17"><a href="#footnote17">17</a></sup>, and extensive documentation about how to do WordPress theme development<sup id="ref18"><a href="#footnote18">18</a></sup>&nbsp;is provided on the WordPress.org site.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'Each plugin and theme has the ability to be continually developed by the plugin or theme owner, and any subsequent fixes or feature development can be uploaded to the repository and made available to users with that plugin or theme installed with a description of that change. Site administrators are notified of plugins which need to be updated via their administration dashboard.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'When a plugin vulnerability is discovered by the WordPress Security Team, they contact the plugin author and work together to fix and release a secure version of the plugin. If there is a lack of response from the plugin author or if the vulnerability is severe, the plugin/theme is pulled from the public directory, and in some cases, fixed and updated directly by the Security Team.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php _e( 'The Theme Review Team', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'The Theme Review Team is a group of volunteers, led by key and established members of the WordPress community, who review and approve themes submitted to be included in the official WordPress Theme directory. The Theme Review Team maintains the official Theme Review Guidelines<sup id="ref19"><a href="#footnote19">19</a></sup>, the Theme Unit Test Datas<sup id="ref20"><a href="#footnote20">20</a></sup>, and the Theme Check Plugins<sup id="ref21"><a href="#footnote21">21</a></sup>, and attempts to engage and educate the WordPress Theme developer community regarding development best practices. Inclusion in the group is moderated by core committers of the WordPress development team.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php _e( 'The role of the hosting provider in WordPress security', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'WordPress can be installed on a multitude of platforms. Though WordPress core software provides many provisions for operating a secure web application, which were covered in this document, the configuration of the operating system and the underlying web server hosting the software is equally important to keep the WordPress applications secure.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php _e( 'A note about WordPress.com and WordPress security', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'WordPress.com is the largest WordPress installation in the world, and is owned and managed by Automattic, Inc., which was founded by Matt Mullenweg, the WordPress project co-creator. WordPress.com runs on the core WordPress software, and has its own security processes, risks, and solutions<sup id="ref22"><a href="#footnote22">22</a></sup>. This document refers to security regarding the self-hosted, downloadable open source WordPress software available from WordPress.org and installable on any server in the world.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading"><?php _e( 'Appendix', 'wporg' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php _e( 'Core WordPress APIs', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'The WordPress Core Application Programming Interface (API) is comprised of several individual APIs<sup id="ref23"><a href="#footnote23">23</a></sup>, each one covering the functions involved in, and use of, a given set of functionality. Together, these form the project interface which allows plugins and themes to interact with, alter, and extend WordPress core functionality safely and securely.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'While each WordPress API provides best practices and standardized ways to interact with and extend WordPress core software, the following WordPress APIs are the most pertinent to enforcing and hardening WordPress security:', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php _e( 'Database API', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'The Database API<sup id="ref24"><a href="#footnote24">24</a></sup>, added in WordPress 0.71, provides the correct method for accessing data as named values which are stored in the database layer.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php _e( 'Filesystem API', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'The Filesystem API<sup id="ref25"><a href="#footnote25">25</a></sup>, added in WordPress 2.6<sup id="ref26"><a href="#footnote26">26</a></sup>, was originally created for WordPress’ own automatic updates feature. The Filesystem API abstracts out the functionality needed for reading and writing local files to the filesystem to be done securely, on a variety of host types.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( 'It does this through the&nbsp;<code>WP_Filesystem_Base</code>&nbsp;class, and several subclasses which implement different ways of connecting to the local filesystem, depending on individual host support. Any theme or plugin that needs to write files locally should do so using the WP_Filesystem family of classes.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php _e( 'HTTP API', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'The HTTP API<sup id="ref27"><a href="#footnote27">27</a></sup>, added in WordPress 2.7<sup id="ref28"><a href="#footnote28">28</a></sup>&nbsp;and extended further in WordPress 2.8, standardizes the HTTP requests for WordPress. The API handles cookies, gzip encoding and decoding, chunk decoding (if HTTP 1.1), and various other HTTP protocol implementations. The API standardizes requests, tests each method prior to sending, and, based on your server configuration, uses the appropriate method to make the request.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php _e( 'Permissions and current user API', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'The permissions and current user API<sup id="ref29"><a href="#footnote29">29</a></sup>&nbsp;is a set of functions which will help verify the current user’s permissions and authority to perform any task or operation being requested, and can protect further against unauthorized users accessing or performing functions beyond their permitted capabilities.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php _e( 'White paper content License', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php _e( 'The text in this document (not including the WordPress logo or&nbsp;<a href="https://wordpressfoundation.org/trademark-policy/">trademark</a>) is licensed under&nbsp;<a href="https://creativecommons.org/publicdomain/zero/1.0/">CC0 1.0 Universal (CC0 1.0) Public Domain Dedication</a>. You can copy, modify, distribute and perform the work, even for commercial purposes, all without asking permission.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( '<em>A special thank you to Drupal’s&nbsp;</em><a href="https://www.drupal.org/files/drupal-security-whitepaper-1-3_0.pdf"><em>security white paper</em></a><em>, which provided some inspiration.</em>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php _e( 'Additional reading', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:list -->
<ul><!-- wp:list-item -->
<li><?php _e( 'WordPress News&nbsp;<a href="https://wordpress.org/news/">https://wordpress.org/news/</a>', 'wporg' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php _e( 'WordPress Security releases&nbsp;<a href="https://wordpress.org/news/category/security/">https://wordpress.org/news/category/security/</a>', 'wporg' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php _e( 'WordPress Developer Resources&nbsp;<a href="https://developer.wordpress.org/">https://developer.wordpress.org/</a>', 'wporg' ); ?></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:separator {"style":{"spacing":{"margin":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"light-grey-1","className":"is-style-default"} -->
<hr class="wp-block-separator has-text-color has-light-grey-1-color has-alpha-channel-opacity has-light-grey-1-background-color has-background is-style-default" style="margin-top:var(--wp--preset--spacing--60);margin-bottom:var(--wp--preset--spacing--60)" />
<!-- /wp:separator -->

<!-- wp:paragraph -->
<p><?php _e( '<em>Authored by</em>&nbsp;Sara Rosso', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( '<em>Contributions from</em>&nbsp;Barry Abrahamson, Michael Adams, Jon Cave, Helen Hou-Sandí, Dion Hulse, Mo Jangda, Paul Maiorana', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><?php _e( '<em>Version 1.0 March 2015</em>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:separator {"style":{"spacing":{"margin":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"}}},"backgroundColor":"light-grey-1","className":"is-style-default"} -->
<hr class="wp-block-separator has-text-color has-light-grey-1-color has-alpha-channel-opacity has-light-grey-1-background-color has-background is-style-default" style="margin-top:var(--wp--preset--spacing--60);margin-bottom:var(--wp--preset--spacing--60)" />
<!-- /wp:separator -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading"><?php _e( 'Footnotes', 'wporg' ); ?></h3>
<!-- /wp:heading -->

<!-- wp:group {"anchor":"footnotes","style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"constrained"}} -->
<div id="footnotes" class="wp-block-group"><!-- wp:paragraph {"anchor":"footnote1"} -->
<p id="footnote1"><?php _e( '<a href="#ref1">[1]</a>&nbsp;<a href="https://w3techs.com/">https://w3techs.com/</a>, as of December 2019', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote2"} -->
<p id="footnote2"><?php _e( '<a href="#ref2">[2]</a>&nbsp;<a href="https://make.wordpress.org/core/handbook/about/release-cycle/">https://make.wordpress.org/core/handbook/about/release-cycle/</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote3"} -->
<p id="footnote3"><?php _e( '<a href="#ref3">[3]</a>&nbsp;<a href="https://make.wordpress.org/core/handbook/about/release-cycle/version-numbering/">https://make.wordpress.org/core/handbook/about/release-cycle/version-numbering/</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote4"} -->
<p id="footnote4"><?php _e( '<a href="#ref4">[4]</a>&nbsp;<a href="https://wordpress.org/news/2014/08/wordpress-3-9-2/">https://wordpress.org/news/2014/08/wordpress-3-9-2/</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote5"} -->
<p id="footnote5"><?php _e( '<a href="#ref5">[5]</a>&nbsp;<a href="https://hackerone.com/wordpress">https://hackerone.com/wordpress</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote6"} -->
<p id="footnote6"><?php _e( '<a href="#ref6">[6]</a>&nbsp;<a href="https://wordpress.org/news/">https://wordpress.org/news/</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote7"} -->
<p id="footnote7"><?php _e( '<a href="#ref7">[7]</a>&nbsp;<a href="https://wordpress.org/news/2013/10/basie/">https://wordpress.org/news/2013/10/basie/</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote8"} -->
<p id="footnote8"><?php _e( '<a href="#ref8">[8]</a>&nbsp;<a href="https://www.owasp.org/index.php/Top_10_2013-Top_10">https://www.owasp.org/index.php/Top_10_2013-Top_10</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote9"} -->
<p id="footnote9"><?php _e( '<a href="#ref9">[9]</a>&nbsp;<a href="https://developer.wordpress.org/apis/security/">https://developer.wordpress.org/apis/security/</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote10"} -->
<p id="footnote10"><?php _e( '<a href="#ref10">[10]</a>&nbsp;<a href="https://href.li/?https://developer.wordpress.org/apis/security/data-validation/">https://developer.wordpress.org/apis/security/data-validation/</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote11"} -->
<p id="footnote11"><?php _e( '<a href="#ref11">[11]</a>&nbsp;<a href="https://wordpress.org/support/article/hardening-wordpress/">https://wordpress.org/support/article/hardening-wordpress/</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote12"} -->
<p id="footnote12"><?php _e( '<a href="#ref12">[12]</a>&nbsp;<a href="https://www.openwall.com/phpass/">https://www.openwall.com/phpass/</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote13"} -->
<p id="footnote13"><?php _e( '<a href="#ref13">[13]</a>&nbsp;<a href="https://href.li/?https://developer.wordpress.org/apis/security/nonces/">https://developer.wordpress.org/apis/security/nonces/</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote14"} -->
<p id="footnote14"><?php _e( '<a href="#ref14">[14]</a>&nbsp;<a href="https://wordpress.org/news/2013/06/wordpress-3-5-2/">https://wordpress.org/news/2013/06/wordpress-3-5-2/</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote15"} -->
<p id="footnote15"><?php _e( '<a href="#ref15">[15]</a>&nbsp;<a href="https://make.wordpress.org/core/2013/06/21/secure-swfupload/">https://make.wordpress.org/core/2013/06/21/secure-swfupload/</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote16"} -->
<p id="footnote16"><?php _e( '<a href="#ref16">[16]</a>&nbsp;<a href="https://developer.wordpress.org/reference/functions/wp_safe_redirect/">https://developer.wordpress.org/reference/functions/wp_safe_redirect/</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote17"} -->
<p id="footnote17"><?php _e( '<a href="#ref17">[17]</a>&nbsp;<a href="https://wordpress.org/plugins/developers/">https://wordpress.org/plugins/developers/</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote18"} -->
<p id="footnote18"><?php _e( '<a href="#ref18">[18]</a>&nbsp;<a href="https://developer.wordpress.org/themes/getting-started/">https://developer.wordpress.org/themes/getting-started/</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote19"} -->
<p id="footnote19"><?php _e( '<a href="#ref19">[19]</a>&nbsp;<a href="https://make.wordpress.org/themes/handbook/review/">https://make.wordpress.org/themes/handbook/review/</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote20"} -->
<p id="footnote20"><?php _e( '<a href="#ref20">[20]</a>&nbsp;<a href="https://codex.wordpress.org/Theme_Unit_Test">https://codex.wordpress.org/Theme_Unit_Test</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote21"} -->
<p id="footnote21"><?php _e( '<a href="#ref21">[21]</a>&nbsp;<a href="https://wordpress.org/plugins/theme-check/">https://wordpress.org/plugins/theme-check/</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote22"} -->
<p id="footnote22"><?php _e( '<a href="#ref22">[22]</a>&nbsp;<a href="https://automattic.com/security/">https://automattic.com/security/</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote23"} -->
<p id="footnote23"><?php _e( '<a href="#ref23">[23]</a>&nbsp;<a href="https://codex.wordpress.org/WordPress_APIs">https://codex.wordpress.org/WordPress_APIs</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote24"} -->
<p id="footnote24"><?php _e( '<a href="#ref24">[24]</a>&nbsp;<a href="https://developer.wordpress.org/apis/handbook/database/">https://developer.wordpress.org/apis/handbook/database/</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote25"} -->
<p id="footnote25"><?php _e( '<a href="#ref25">[25]</a>&nbsp;<a href="https://codex.wordpress.org/Filesystem_API">https://codex.wordpress.org/Filesystem_API</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote26"} -->
<p id="footnote26"><?php _e( '<a href="#ref26">[26]</a>&nbsp;<a href="https://wordpress.org/support/wordpress-version/version-2-6/">https://wordpress.org/support/wordpress-version/version-2-6/</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote27"} -->
<p id="footnote27"><?php _e( '<a href="#ref27">[27]</a>&nbsp;<a href="https://developer.wordpress.org/plugins/http-api/">https://developer.wordpress.org/plugins/http-api/</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote28"} -->
<p id="footnote28"><?php _e( '<a href="#ref28">[28]</a>&nbsp;<a href="https://wordpress.org/support/wordpress-version/version-2-7/">https://wordpress.org/support/wordpress-version/version-2-7/</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"anchor":"footnote29"} -->
<p id="footnote29"><?php _e( '<a href="#ref29">[29]</a>&nbsp;<a href="https://developer.wordpress.org/reference/functions/current_user_can/">https://developer.wordpress.org/reference/functions/current_user_can/</a>', 'wporg' ); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
