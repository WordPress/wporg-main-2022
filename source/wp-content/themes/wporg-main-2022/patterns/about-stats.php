<?php
/**
 * Title: Stats
 * Slug: wporg-main-2022/stats
 * Inserter: no
 */

$sections = array(
	array(
		'id'      => 'wp_versions',
		'heading' => __( 'WordPress versions in use', 'wporg' ),
	),
	array(
		'id'      => 'php_versions',
		'heading' => __( 'PHP versions in use', 'wporg' ),
	),
	array(
		'id'      => 'mysql_versions',
		'heading' => __( 'Database versions in use', 'wporg' ),
	),
	array(
		'id'      => 'locales',
		'heading' => __( 'Languages in use', 'wporg' ),
	),
);

?>
<!-- wp:group {"align":"full","className":"wporg-about-stats-page","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","right":"var:preset|spacing|edge-space","left":"var:preset|spacing|edge-space","bottom":"var:preset|spacing|60"}}},"layout":{"type":"constrained","contentSize":"1280px"}} -->
<div class="wp-block-group alignfull wporg-about-stats-page" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--edge-space);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--edge-space)"><!-- wp:heading {"level":1,"style":{"spacing":{"margin":{"bottom":"var:preset|spacing|30"}}}} -->
<h1 class="wp-block-heading" style="margin-bottom:var(--wp--preset--spacing--30)"><?php esc_html_e( 'Statistics', 'wporg' ); ?></h1>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php esc_html_e( 'These charts give a snapshot of the systems and configurations the WordPress community is running.', 'wporg' ); ?></p>
<!-- /wp:paragraph -->

<?php foreach ( $sections as $section ) : ?>
<!-- wp:group {"className":"wporg-about-stats-wrapper","layout":{"type":"constrained"}} -->
<div class="wp-block-group wporg-about-stats-wrapper"><!-- wp:heading -->
<h2 class="wp-block-heading"><?php echo esc_html( $section['heading'] ); ?></h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"wporg-about-stats-section","layout":{"type":"constrained"}} -->
<div class="wp-block-group wporg-about-stats-section">
<!-- wp:group {"align":"full","className":"wporg-stats-chart loading","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"},"anchor":"<?php echo esc_attr( $section['id'] ); ?>"} -->
<div class="wp-block-group alignfull wporg-stats-chart loading" id="<?php echo esc_attr( $section['id'] ); ?>"></div>
<!-- /wp:group -->

<!-- wp:html -->
<button
	type="button"
	class="swap-table"
	aria-expanded="false"
	aria-controls="<?php echo esc_attr( $section['id'] ); ?>"
><?php esc_html_e( 'View as table', 'wporg' ); ?><span class="swap-table__icon" aria-hidden="true"></span></button>
<!-- /wp:html --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
<?php endforeach; ?>
</div>
<!-- /wp:group -->
