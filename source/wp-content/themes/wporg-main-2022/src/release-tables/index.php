<?php
/**
 * Block Name: Release Tables
 * Description: Display the list of releases.
 *
 * @package wporg
 */

namespace WordPressdotorg\Theme\Main_2022\Release_Tables_Block;

add_action( 'init', __NAMESPACE__ . '\init' );

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function init() {
	register_block_type(
		dirname( dirname( __DIR__ ) ) . '/build/release-tables',
		array(
			'render_callback' => __NAMESPACE__ . '\render',
		)
	);
}

/**
 * Render the block content.
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    Block default content.
 * @param WP_Block $block      Block instance.
 *
 * @return string Returns the block markup.
 */
function render( $attributes, $content, $block ) {
	if ( ! empty( $block->block_type->view_script ) ) {
		wp_enqueue_script( $block->block_type->view_script );
		// Move to footer.
		wp_script_add_data( $block->block_type->view_script, 'group', 1 );
	}

	if ( defined( 'IS_ROSETTA_NETWORK' ) && IS_ROSETTA_NETWORK ) {
		$releases = $GLOBALS['rosetta']->rosetta->get_releases_breakdown();
	} else {
		$releases = \WordPressdotorg\Releases\get_breakdown();
	}

	if ( empty( $releases ) ) {
		return '';
	}

	$block_content = '';

	if ( isset( $releases['latest'] ) ) {
		$block_content .= '<div class="wp-block-wporg-release-tables__section">';
		$block_content .= render_heading( __( 'Latest release', 'wporg' ), 'latest' );
		$block_content .= render_table( [ $releases['latest'] ] );
		$block_content .= '</div>';
	}

	if ( isset( $releases['branches'] ) ) {
		$show_branches = array_slice( $releases['branches'], 0, 2 );
		foreach ( $show_branches as $branch => $branch_releases ) {
			$block_content .= '<div class="wp-block-wporg-release-tables__section">';
			$block_content .= render_heading(
				/* translators: Version number. */
				sprintf( esc_html__( '%s Branch', 'wporg' ), $branch ),
				sprintf( 'branch-%s', sanitize_key( $branch ) )
			);
			$block_content .= render_table( $branch_releases );
			$block_content .= '</div>';
		}

		$more_branches = array_slice( $releases['branches'], 2 );
		if ( $more_branches ) {
			$block_content .= render_heading( __( 'Past releases', 'wporg' ), 'past' );
			foreach ( $more_branches as $branch => $branch_releases ) {
				$block_content .= '<div class="wp-block-wporg-release-tables__section">';
				$block_content .= render_heading(
					/* translators: Version number. */
					sprintf( esc_html__( '%s Branch', 'wporg' ), $branch ),
					sprintf( 'branch-%s', sanitize_key( $branch ) ),
					true
				);
				$block_content .= render_table( $branch_releases );
				$block_content .= '</div>';
			}
		}
	}

	if ( isset( $releases['betas'] ) ) {
		$block_content .= '<div class="wp-block-wporg-release-tables__section">';
		$block_content .= render_heading( __( 'Beta &amp; RC releases', 'wporg' ), 'betas', true );
		$block_content .= '<!-- wp:paragraph --><p>';
		$block_content .= esc_html__( 'These were testing releases and are only available here for archival purposes.', 'wporg' );
		$block_content .= '</p><!-- /wp:paragraph -->';
		$block_content .= render_table( $releases['betas'] );
		$block_content .= '</div>';
	}

	if ( isset( $releases['mu'] ) && count( $releases['mu'] ) ) {
		$block_content .= '<div class="wp-block-wporg-release-tables__section">';
		$block_content .= render_heading( __( 'MU releases', 'wporg' ), 'mu', true );
		$block_content .= '<!-- wp:paragraph --><p>';
		$block_content .= esc_html__( 'WordPress MU releases made prior to MU being merged into WordPress 3.0.', 'wporg' );
		$block_content .= '</p><!-- /wp:paragraph -->';
		$block_content .= render_table( $releases['mu'] );
		$block_content .= '</div>';
	}

	$wrapper_attributes = get_block_wrapper_attributes();
	return sprintf(
		'<div %1$s>%2$s</div>',
		$wrapper_attributes,
		do_blocks( $block_content )
	);
}

/**
 * Render a release heading with ID.
 *
 * @param string $text The heading text.
 * @param string $id The string to use for the HTML id attribute.
 *
 * @return string Returns the heading markup.
 */
function render_heading( $text, $id, $subheading = false ) {
	if ( ! $id ) {
		$id = sanitize_key( $text );
	}

	$back_to_top = '';
	if ( 'latest' !== $id ) {
		$back_to_top = '<a class="wp-block-wporg-release-tables__link-top" href="#latest">' . __( 'Back to top', 'wporg' ) . '</a>';
	}

	if ( $subheading ) {
		return sprintf(
			'<!-- wp:heading {"style":{"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"0px"}}},"fontSize":"heading-4"} --><h3 class="has-heading-4-font-size" style="margin-top:var(--wp--preset--spacing--40);margin-bottom:0px" id="%s">%s %s</h3><!-- /wp:heading -->',
			esc_attr( $id ),
			esc_html( $text ),
			$back_to_top
		);
	}

	return sprintf(
		'<!-- wp:heading {"style":{"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"0px"}}},"fontSize":"heading-3"} --><h2 class="has-heading-3-font-size" style="margin-top:var(--wp--preset--spacing--40);margin-bottom:0px" id="%s">%s %s</h2><!-- /wp:heading -->',
		esc_attr( $id ),
		esc_html( $text ),
		$back_to_top
	);
}

/**
 * Render a release table.
 *
 * @param array $releases A list of release versions.
 *
 * @return string Returns the table markup.
 */
function render_table( $releases ) {
	$table = '<!-- wp:table {"className":"is-style-stripes","style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}}} --><figure class="wp-block-table is-style-stripes" style="margin-top:var(--wp--preset--spacing--20)">';
	$table .= '<table>';
	$table .= '<thead>';
	$table .= '<tr>';
	$table .= '<th scope="col" width="15%">' . esc_html__( 'Version', 'wporg' ) . '</th>';
	$table .= '<th scope="col" width="35%">' . esc_html__( 'Release date', 'wporg' ) . '</th>';
	$table .= '<th scope="col" width="25%">' . esc_html__( 'Download zip', 'wporg' ) . '</th>';
	$table .= '<th scope="col" width="25%">' . esc_html__( 'Download tar.gz', 'wporg' ) . '</th>';
	$table .= '</tr>';
	$table .= '</thead>';
	$table .= '<tbody>';
	foreach ( $releases as $version ) {
		$table .= render_table_row( $version );
	}
	$table .= '</tbody></table>';
	$table .= '</figure><!-- /wp:table -->';
	return $table;
}

/**
 * Render a release row.
 *
 * @param array $version A list of links and data about a given release version.
 *
 * @return string Returns the row markup.
 */
function render_table_row( $version ) {
	$row = '<tr>';
	$row .= '<th scope="row">' . esc_html( $version['version'] ) . '</th>';
	$row .= '<td>' . esc_html( date_i18n( get_option( 'date_format' ), $version['builton'] ) ) . '</td>';
	$row .= sprintf( '<td><a href="%1$s">zip</a><br /><small>(<a href="%1$s.md5">md5</a> | <a href="%1$s.sha1">sha1</a>)</small></td>', esc_url( $version['zip_url'] ) );

	// Some releases don't have tar.gz builds.
	if ( $version['targz_url'] ) {
		$row .= sprintf( '<td><a href="%1$s">tar.gz</a><br /><small>(<a href="%1$s.md5">md5</a> | <a href="%1$s.sha1">sha1</a>)</small></td>', esc_url( $version['targz_url'] ) );
	} else {
		$row .= '<td></td>';
	}
	$row .= '</tr>';
	return $row;
}
