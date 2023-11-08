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
		$block_content .= '<div class="wp-block-wporg-release-tables__section" id="latest">';
		$block_content .= render_heading( __( 'Latest release', 'wporg' ) );
		$block_content .= render_table( [ $releases['latest'] ] );
		$block_content .= '</div>';
	}

	if ( isset( $releases['branches'] ) ) {
		$show_branches = array_slice( $releases['branches'], 0, 2 );
		foreach ( $show_branches as $branch => $branch_releases ) {
			$block_content .= sprintf(
				'<div class="wp-block-wporg-release-tables__section" id="%s">',
				sprintf( 'branch-%s', sanitize_key( $branch ) )
			);
			/* translators: Version number. */
			$block_content .= render_heading( sprintf( esc_html__( '%s Branch', 'wporg' ), $branch ) );
			$block_content .= render_table( $branch_releases );
			$block_content .= '</div>';
		}

		$more_branches = array_slice( $releases['branches'], 2 );
		if ( $more_branches ) {
			$block_content .= render_heading( __( 'Past releases', 'wporg' ) );

			$block_content .= '<ul role="tablist">';
			foreach ( $more_branches as $branch => $branch_releases ) {
				$tab_string = '<li role="presentation"><a role="tab" href="#%1$s" aria-controls="%1$s" aria-selected="false">%2$s</a></li>';
				$block_content .= sprintf(
					$tab_string,
					sprintf( 'branch-%s', sanitize_key( $branch ) ),
					$branch
				);
			}
			if ( isset( $releases['betas'] ) ) {
				$block_content .= sprintf(
					$tab_string,
					'betas',
					__( 'Beta &amp; RC releases', 'wporg' )
				);
			}
			if ( isset( $releases['mu'] ) && count( $releases['mu'] ) ) {
				$block_content .= sprintf(
					$tab_string,
					'mu',
					__( 'MU releases', 'wporg' )
				);
			}
			$block_content .= '</ul>';

			foreach ( $more_branches as $branch => $branch_releases ) {
				$block_content .= sprintf(
					'<div class="wp-block-wporg-release-tables__section" id="%s" aria-hidden="true">',
					sprintf( 'branch-%s', sanitize_key( $branch ) ),
				);
				$block_content .= render_heading(
					/* translators: Version number. */
					sprintf( esc_html__( '%s Branch', 'wporg' ), $branch ),
					3
				);
				$block_content .= render_table( $branch_releases );
				$block_content .= '</div>';
			}
		}
	}

	if ( isset( $releases['betas'] ) ) {
		$block_content .= '<div class="wp-block-wporg-release-tables__section" id="betas" aria-hidden="true">';
		$block_content .= render_heading( __( 'Beta &amp; RC releases', 'wporg' ), 3 );
		$block_content .= '<!-- wp:paragraph --><p>';
		$block_content .= esc_html__( 'These were testing releases and are only available here for archival purposes.', 'wporg' );
		$block_content .= '</p><!-- /wp:paragraph -->';
		$block_content .= render_table( $releases['betas'] );
		$block_content .= '</div>';
	}

	if ( isset( $releases['mu'] ) && count( $releases['mu'] ) ) {
		$block_content .= '<div class="wp-block-wporg-release-tables__section" id="mu" aria-hidden="true">';
		$block_content .= render_heading( __( 'MU releases', 'wporg' ), 3 );
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
 * @param string $text  The heading text.
 * @param int    $level A value 1-6 to use for the heading level.
 *
 * @return string Returns the heading markup.
 */
function render_heading( $text, int $level = 2 ) {
	if ( $level < 1 || $level > 6 ) {
		$level = 2;
	}

	return sprintf(
		'<!-- wp:heading {"style":{"spacing":{"margin":{"top":"var:preset|spacing|40","bottom":"0px"}}},"fontSize":"heading-%2$s"} --><h%1$s class="has-heading-%2$s-font-size" style="margin-top:var(--wp--preset--spacing--40);margin-bottom:0px">%3$s</h%1$s><!-- /wp:heading -->',
		$level,
		$level + 1,
		esc_html( $text )
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
	$table .= '<th scope="col" class="wp-block-wporg-release-tables__cell-version"><span class="screen-reader-text">' . esc_html__( 'Version', 'wporg' ) . '</span></th>';
	$table .= '<th scope="col" class="wp-block-wporg-release-tables__cell-date"><span class="screen-reader-text">' . esc_html__( 'Release date', 'wporg' ) . '</span></th>';
	$table .= '<th scope="col" class="wp-block-wporg-release-tables__cell-zip"><span class="screen-reader-text">' . esc_html__( 'Download zip', 'wporg' ) . '</span></th>';
	$table .= '<th scope="col" class="wp-block-wporg-release-tables__cell-targz"><span class="screen-reader-text">' . esc_html__( 'Download tar.gz', 'wporg' ) . '</span></th>';
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
 * Find the microsite url for a given version.
 *
 * @param string $version The version number to find the microsite url for.
 *
 * @return string|null Returns the microsite url if found, otherwise null.
 */
function find_microsite_url_for_version( $version ) {
	// attempt to find the microsite url only if the version number matches the format major.minor
	if ( ! preg_match( '/^\d+\.\d+$/', $version ) ) {
		return null;
	}

	global $post;
	$child_pages = get_pages( array( 'child_of' => $post->ID ) );
	$version_hyphenated = str_replace( '.', '-', $version );

	foreach ( $child_pages as $child_page ) {
		if ( $version_hyphenated === $child_page->post_name ) {
			return get_permalink( $child_page->ID );
		}
	}

	return null;
}

/**
 * Render a release row.
 *
 * @param array $version A list of links and data about a given release version.
 *
 * @return string Returns the row markup.
 */
function render_table_row( $version ) {
	$version_number = $version['version'];
	$microsite_url = find_microsite_url_for_version( $version_number );

	$row = '<tr>';
	$row .= '<th class="wp-block-wporg-release-tables__cell-version" scope="row">';
	$row .= isset( $microsite_url )
		? sprintf(
			'<a href="%1$s">%2$s</a>',
			esc_url( $microsite_url ),
			esc_html( $version_number ),
		)
		: esc_html( $version_number );
	$row .= '</th>';
	$row .= '<td class="wp-block-wporg-release-tables__cell-date">' . esc_html( date_i18n( get_option( 'date_format' ), $version['builton'] ) ) . '</td>';
	$row .= sprintf( '<td class="wp-block-wporg-release-tables__cell-zip"><a href="%1$s">zip</a><br /><small>(<a href="%1$s.md5">md5</a> &#183; <a href="%1$s.sha1">sha1</a>)</small></td>', esc_url( $version['zip_url'] ) );

	// Some releases don't have tar.gz builds.
	if ( $version['targz_url'] ) {
		$row .= sprintf( '<td class="wp-block-wporg-release-tables__cell-targz"><a href="%1$s">tar.gz</a><br /><small>(<a href="%1$s.md5">md5</a> &#183; <a href="%1$s.sha1">sha1</a>)</small></td>', esc_url( $version['targz_url'] ) );
	} else {
		$row .= '<td class="wp-block-wporg-release-tables__cell-targz"></td>';
	}
	$row .= '</tr>';
	return $row;
}
