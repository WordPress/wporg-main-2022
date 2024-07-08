<?php
// phpcs:disable WordPress.Files.FileName -- Allow underscore for pattern partial.
/**
 * Title: Page in progress
 * Slug: wporg-main-2022/work-in-progress
 * Inserter: no
 *
 * Use this pattern to prevent publicly showing pages that are not ready yet.
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|edge-space","right":"var:preset|spacing|edge-space"}},"border":{"top":{"color":"var:preset|color|black-opacity-15","style":"solid","width":"1px"},"right":{"style":"none","width":"0px"},"bottom":{"style":"none","width":"0px"},"left":{"style":"none","width":"0px"}}},"className":"wporg-page-in-progress","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull wporg-page-in-progress" style="border-top-color:var(--wp--preset--color--black-opacity-15);border-top-style:solid;border-top-width:1px;border-right-style:none;border-right-width:0px;border-bottom-style:none;border-bottom-width:0px;border-left-style:none;border-left-width:0px;padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--edge-space);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--edge-space)">
	<!-- wp:group {"align":"wide","layout":{"type":"constrained","justifyContent":"left"}} -->
	<div class="wp-block-group alignwide">
		<!-- wp:heading {"level":1,"style":{"typography":{"fontStyle":"italic","fontWeight":"400"}}} -->
		<h1 class="wp-block-heading" style="font-style:italic;font-weight:400"><?php _e( 'You&#8217;re looking for what&#8217;s new in WordPress', 'wporg' ); ?></h1>
		<!-- /wp:heading -->

		<!-- wp:paragraph -->
		<p><?php _e( 'Go right to the source:', 'wporg' ); ?></p>
		<!-- /wp:paragraph -->

		<!-- wp:list -->
		<ul class="wp-block-list">
			<!-- wp:list-item -->
			<li><a href="<?php echo esc_url( __( 'https://wordpress.org/news/', 'wporg' ) ); ?>"><?php _e( 'WordPress News', 'wporg' ); ?></a></li>
			<!-- /wp:list-item -->

			<!-- wp:list-item -->
			<li><a href="<?php echo esc_url( __( 'https://developer.wordpress.org/news/', 'wporg' ) ); ?>"><?php _e( 'Developer Blog', 'wporg' ); ?></a></li>
			<!-- /wp:list-item -->

			<!-- wp:list-item -->
			<li><a href="<?php echo esc_url( __( 'https://events.wordpress.org/upcoming-events/', 'wporg' ) ); ?>"><?php _e( 'Upcoming WordPress events', 'wporg' ); ?></a></li>
			<!-- /wp:list-item -->
		</ul>
		<!-- /wp:list -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
