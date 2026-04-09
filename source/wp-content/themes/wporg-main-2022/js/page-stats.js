/* global Chart */
// eslint-disable-next-line id-length
( function ( $, i18n ) {
	/*
	 * Per-chart color ramps drawn from the Dotorg brand palette
	 * (see wporg-parent-2021/theme.json — blueberry, pomegrade,
	 * acid-green, lemon families). Slices are sorted largest →
	 * smallest and colored from the dark anchor to the light
	 * anchor, so the visual gradient mirrors the data ranking.
	 */
	const palettes = {
		blueberry: { dark: '#1d35b4', light: '#dbe1ff' },
		pomegrade: { dark: '#7a1f10', light: '#ffd0c2' },
		acidGreen: { dark: '#0f5e22', light: '#c7ffdb' },
		lemon:     { dark: '#5a4f00', light: '#fff972' },
	};

	/*
	 * The api.wordpress.org/stats/* endpoints are responsible for filtering
	 * long-EOL versions out and rolling them into an "Others" bucket — the
	 * client just sorts and renders whatever the API returns. Recommended
	 * server-side cutoffs (so this page only shows currently-supported runtimes):
	 *   - /stats/wordpress/1.0/ : drop versions below 4.0
	 *   - /stats/php/1.0/       : drop versions below 7.0
	 *   - /stats/mysql/1.0/     : drop MySQL < 5.6 and MariaDB < 10.4
	 */
	const charts = [
		{
			id: 'wp_versions',
			colName: i18n.version,
			palette: palettes.blueberry,
			sort: 'version-desc',
			url: 'https://api.wordpress.org/stats/wordpress/1.0/',
			data: false,
		},
		{
			id: 'php_versions',
			colName: i18n.version,
			palette: palettes.pomegrade,
			sort: 'version-desc',
			url: 'https://api.wordpress.org/stats/php/1.0/',
			data: false,
		},
		{
			id: 'mysql_versions',
			colName: i18n.version,
			palette: palettes.acidGreen,
			sort: 'version-desc',
			url: 'https://api.wordpress.org/stats/mysql/1.0/',
			data: false,
		},
		{
			id: 'locales',
			colName: i18n.locale,
			palette: palettes.lemon,
			sort: 'alphabetical',
			url: 'https://api.wordpress.org/stats/locale/1.0/',
			data: false,
		},
	];

	$( function () {
		charts.forEach( loadChart );
	} );

	function loadChart( chart ) {
		$.get( {
			url: chart.url,
			success: function ( data ) {
				chart.data = data;
				renderChart( chart );
			},
		} );
	}

	// Linear RGB interpolation between two hex colors, returning N stops.
	function buildGradient( darkHex, lightHex, count ) {
		if ( count <= 1 ) {
			return [ darkHex ];
		}
		const dark = hexToRgb( darkHex );
		const light = hexToRgb( lightHex );
		return Array.from( { length: count }, function ( _, i ) {
			const t = i / ( count - 1 );
			return rgbToHex( [
				dark[ 0 ] + ( light[ 0 ] - dark[ 0 ] ) * t,
				dark[ 1 ] + ( light[ 1 ] - dark[ 1 ] ) * t,
				dark[ 2 ] + ( light[ 2 ] - dark[ 2 ] ) * t,
			] );
		} );
	}

	function hexToRgb( hex ) {
		const m = hex.replace( '#', '' );
		return [
			parseInt( m.substr( 0, 2 ), 16 ),
			parseInt( m.substr( 2, 2 ), 16 ),
			parseInt( m.substr( 4, 2 ), 16 ),
		];
	}

	// Compare two version-bearing labels (e.g. "MariaDB 10.10", "8.3", "5.6")
	// numerically per dotted segment, so 10.10 sorts above 10.9.
	function compareVersions( a, b ) {
		const aParts = ( a.match( /[\d.]+/ ) || [ '0' ] )[ 0 ].split( '.' ).map( Number );
		const bParts = ( b.match( /[\d.]+/ ) || [ '0' ] )[ 0 ].split( '.' ).map( Number );
		const len = Math.max( aParts.length, bParts.length );
		for ( let i = 0; i < len; i++ ) {
			const av = aParts[ i ] || 0;
			const bv = bParts[ i ] || 0;
			if ( av !== bv ) {
				return av - bv;
			}
		}
		// Tie-break alphabetically so "MariaDB 10.4" sorts below "MySQL 10.4".
		return a.localeCompare( b );
	}

	function rgbToHex( rgb ) {
		return '#' + rgb.map( function ( v ) {
			const h = Math.round( v ).toString( 16 );
			return h.length === 1 ? '0' + h : h;
		} ).join( '' );
	}

	function renderChart( chart ) {
		const $container = $( '#' + chart.id );
		if ( ! $container.length ) {
			return;
		}

		// Build a list of [label, value] pairs. Versions below the per-chart
		// cutoff get rolled up into a single "Older" entry, and any pre-existing
		// "Others" bucket from the API is pinned to the end.
		const sortable = [];
		let others = null;
		let older = 0;
		for ( const key in chart.data ) {
			const value = Number( chart.data[ key ] );
			if ( key === 'Others' ) {
				others = [ key, value ];
				continue;
			}
			if ( chart.isCurrent && ! chart.isCurrent( key ) ) {
				older += value;
				continue;
			}
			sortable.push( [ key, value ] );
		}

		if ( chart.sort === 'version-desc' ) {
			sortable.sort( function ( a, b ) {
				return compareVersions( b[ 0 ], a[ 0 ] );
			} );
		} else if ( chart.sort === 'alphabetical' ) {
			sortable.sort( function ( a, b ) {
				return a[ 0 ].localeCompare( b[ 0 ] );
			} );
		} else {
			// Default fallback: sort by share, descending.
			sortable.sort( function ( a, b ) {
				return b[ 1 ] - a[ 1 ];
			} );
		}

		// Pin the rolled-up buckets to the end so the gradient runs through
		// the "real" data first and finishes on the catch-alls.
		if ( older > 0 ) {
			sortable.push( [ i18n.older, older ] );
		}
		if ( others ) {
			sortable.push( others );
		}

		const total = sortable.reduce( function ( sum, row ) {
			return sum + row[ 1 ];
		}, 0 );

		// Chart slices are ordered by share descending so the donut reads
		// from biggest to smallest, while the legend keeps its
		// version/alphabetical ordering. Older/Others stay pinned to the end.
		const tail = [];
		const slices = sortable.filter( function ( row ) {
			if ( row[ 0 ] === i18n.older || row[ 0 ] === 'Others' ) {
				tail.push( row );
				return false;
			}
			return true;
		} ).slice().sort( function ( a, b ) {
			return b[ 1 ] - a[ 1 ];
		} ).concat( tail );

		// Color gradient is keyed to the donut's order, so the largest slice
		// gets the darkest brand shade and the smallest the lightest tint.
		// The legend swatches read the same map so a given version is the
		// same color in both places.
		const colors = buildGradient( chart.palette.dark, chart.palette.light, slices.length );
		const colorByLabel = {};
		const indexByLabel = {};
		slices.forEach( function ( row, i ) {
			colorByLabel[ row[ 0 ] ] = colors[ i ];
		} );
		sortable.forEach( function ( row, i ) {
			indexByLabel[ row[ 0 ] ] = i;
		} );

		// Build the layout: a flex row with the chart on the left and a
		// scrollable HTML legend on the right, plus an accordion table that
		// expands beneath the chart on demand.
		$container.removeClass( 'loading' ).empty();

		const $body = $( '<div class="wporg-stats-chart__body"></div>' ).appendTo( $container );

		const $canvasWrap = $(
			'<div class="wporg-stats-chart__canvas-wrap">' +
				'<canvas></canvas>' +
				'<div class="wporg-stats-chart__center" aria-hidden="true">' +
					'<span class="wporg-stats-chart__center-value"></span>' +
					'<span class="wporg-stats-chart__center-label"></span>' +
				'</div>' +
			'</div>'
		).appendTo( $body );

		const $legend = $( '<ul class="wporg-stats-chart__legend"></ul>' ).appendTo( $body );

		sortable.forEach( function ( row, index ) {
			const label = row[ 0 ];
			const value = row[ 1 ];
			const percent = total ? ( ( value / total ) * 100 ).toFixed( 2 ) : '0.00';
			const $item = $(
				'<li class="wporg-stats-chart__legend-item">' +
					'<span class="wporg-stats-chart__legend-swatch" aria-hidden="true"></span>' +
					'<span class="wporg-stats-chart__legend-label"></span>' +
					'<span class="wporg-stats-chart__legend-percent"></span>' +
				'</li>'
			);
			$item.find( '.wporg-stats-chart__legend-swatch' ).css( 'background-color', colorByLabel[ label ] );
			$item.find( '.wporg-stats-chart__legend-label' ).text( label );
			$item.find( '.wporg-stats-chart__legend-percent' ).text( percent + '%' );
			$item.attr( 'data-index', index );
			$item.attr( 'data-label', label );
			// Native browser tooltip surfaces the full label when the column
			// is too narrow to display it (e.g. "English (Aust…)").
			$item.attr( 'title', label + ' — ' + percent + '%' );
			$legend.append( $item );
		} );

		// Accordion table view that lives inside the card, beneath the chart body.
		const $tablePanel = $(
			'<div class="wporg-stats-chart__table" hidden>' +
				'<table>' +
					'<thead><tr><th scope="col"></th><th scope="col"></th><th scope="col" class="is-numeric"></th></tr></thead>' +
					'<tbody></tbody>' +
				'</table>' +
			'</div>'
		).appendTo( $container );

		$tablePanel.find( 'thead th' ).eq( 0 ).text( '' );
		$tablePanel.find( 'thead th' ).eq( 1 ).text( chart.colName );
		$tablePanel.find( 'thead th' ).eq( 2 ).text( i18n.usage );

		const $tbody = $tablePanel.find( 'tbody' );
		sortable.forEach( function ( row, index ) {
			const label = row[ 0 ];
			const value = row[ 1 ];
			const percent = total ? ( ( value / total ) * 100 ).toFixed( 2 ) : '0.00';
			const $tr = $(
				'<tr>' +
					'<td class="wporg-stats-chart__table-swatch-cell"><span class="wporg-stats-chart__legend-swatch" aria-hidden="true"></span></td>' +
					'<th scope="row"></th>' +
					'<td class="is-numeric"></td>' +
				'</tr>'
			);
			$tr.find( '.wporg-stats-chart__legend-swatch' ).css( 'background-color', colorByLabel[ label ] );
			$tr.find( 'th' ).text( label );
			$tr.find( '.is-numeric' ).text( percent + '%' );
			$tbody.append( $tr );
		} );

		// Render the doughnut.
		const canvas = $canvasWrap.find( 'canvas' )[ 0 ];
		const $center = $canvasWrap.find( '.wporg-stats-chart__center' );
		const $centerValue = $center.find( '.wporg-stats-chart__center-value' );
		const $centerLabel = $center.find( '.wporg-stats-chart__center-label' );

		const chartInstance = new Chart( canvas, {
			type: 'doughnut',
			data: {
				labels: slices.map( function ( r ) { return r[ 0 ]; } ),
				datasets: [ {
					data: slices.map( function ( r ) { return r[ 1 ]; } ),
					backgroundColor: slices.map( function ( r ) { return colorByLabel[ r[ 0 ] ]; } ),
					borderColor: '#ffffff',
					borderWidth: 2,
					hoverOffset: 6,
				} ],
			},
			options: {
				cutout: '62%',
				responsive: true,
				maintainAspectRatio: false,
				layout: { padding: 8 },
				plugins: {
					legend: { display: false },
					tooltip: { enabled: false },
				},
				onHover: function ( event, elements ) {
					if ( elements && elements.length ) {
						const sliceIdx = elements[ 0 ].index;
						const row = slices[ sliceIdx ];
						const percent = total ? ( ( row[ 1 ] / total ) * 100 ).toFixed( 2 ) : '0.00';
						$centerValue.text( percent + '%' );
						$centerLabel.text( row[ 0 ] );
						$legend.children().removeClass( 'is-active' );
						$legend.children().eq( indexByLabel[ row[ 0 ] ] ).addClass( 'is-active' );
					} else {
						$centerValue.text( '' );
						$centerLabel.text( '' );
						$legend.children().removeClass( 'is-active' );
					}
				},
			},
		} );

		// Mirror hover state from the legend back to the chart.
		$legend.on( 'mouseenter focusin', '.wporg-stats-chart__legend-item', function () {
			const $this = $( this );
			const label = $this.attr( 'data-label' );
			const legendIdx = parseInt( $this.attr( 'data-index' ), 10 );
			const row = sortable[ legendIdx ];
			const percent = total ? ( ( row[ 1 ] / total ) * 100 ).toFixed( 2 ) : '0.00';
			$centerValue.text( percent + '%' );
			$centerLabel.text( label );
			const sliceIdx = slices.findIndex( function ( r ) {
				return r[ 0 ] === label;
			} );
			if ( sliceIdx !== -1 ) {
				chartInstance.setActiveElements( [ { datasetIndex: 0, index: sliceIdx } ] );
				chartInstance.update();
			}
			$legend.children().removeClass( 'is-active' );
			$this.addClass( 'is-active' );
		} );
		$legend.on( 'mouseleave focusout', '.wporg-stats-chart__legend-item', function () {
			$centerValue.text( '' );
			$centerLabel.text( '' );
			chartInstance.setActiveElements( [] );
			chartInstance.update();
			$legend.children().removeClass( 'is-active' );
		} );
	}

	// Sortable table headers: clicking a <th> toggles asc/desc sort on
	// that column. The swatch column (index 0) is excluded.
	$( document ).on( 'click', '.wporg-stats-chart__table thead th', function () {
		const $th = $( this );
		const $table = $th.closest( 'table' );
		const colIndex = $th.index();

		// Skip the swatch column.
		if ( colIndex === 0 ) {
			return;
		}

		const currentSort = $th.attr( 'aria-sort' );
		const direction = currentSort === 'ascending' ? 'descending' : 'ascending';

		// Reset all headers, then mark this one.
		$table.find( 'thead th' ).removeAttr( 'aria-sort' );
		$th.attr( 'aria-sort', direction );

		const $tbody = $table.find( 'tbody' );
		const rows = $tbody.find( 'tr' ).get();

		rows.sort( function ( a, b ) {
			const aCell = $( a ).children().eq( colIndex );
			const bCell = $( b ).children().eq( colIndex );
			let aVal = aCell.text().trim();
			let bVal = bCell.text().trim();

			// Numeric sort for the percentage column.
			const aNum = parseFloat( aVal );
			const bNum = parseFloat( bVal );
			if ( ! isNaN( aNum ) && ! isNaN( bNum ) ) {
				return direction === 'ascending' ? aNum - bNum : bNum - aNum;
			}

			// Alphabetical for the label column.
			const cmp = aVal.localeCompare( bVal );
			return direction === 'ascending' ? cmp : -cmp;
		} );

		$tbody.append( rows );
	} );

	// Accordion-style toggle: expand the table view beneath the chart.
	$( document ).on( 'click', 'button.swap-table', function ( event ) {
		event.preventDefault();
		const $button = $( this );
		const $section = $button.parents( '.wporg-about-stats-section' );
		const $panel = $section.find( '.wporg-stats-chart__table' );
		if ( ! $panel.length ) {
			return;
		}
		const expanded = $button.attr( 'aria-expanded' ) === 'true';
		$button.attr( 'aria-expanded', expanded ? 'false' : 'true' );
		$panel.prop( 'hidden', expanded );
		$button.contents().filter( function () {
			return this.nodeType === 3;
		} ).first().replaceWith( expanded ? i18n.viewAsTable : i18n.hideTable );
	} );
} )( window.jQuery, window.wporgPageStats );
