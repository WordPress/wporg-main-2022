// eslint-disable-next-line id-length
( function ( $, google, i18n ) {
	google.charts.load( '44', { packages: [ 'corechart', 'table' ] } );
	google.charts.setOnLoadCallback( drawCharts );

	const charts = [
		{
			id: 'wp_versions',
			colName: 'Version',
			sort: 'versions',
			type: 'PieChart',
			url: 'https://api.wordpress.org/stats/wordpress/1.0/',
			data: false,
			dataTransform: function ( data ) {
				// Remove trunk from display.
				for ( const version in data ) {
					if ( parseFloat( version ) >= parseFloat( i18n.trunk ) ) {
						delete data[ version ];
					}
				}

				return data;
			},
		},
		{
			id: 'php_versions',
			colName: 'Version',
			sort: 'versions',
			type: 'PieChart',
			url: 'https://api.wordpress.org/stats/php/1.0/',
			data: false,
		},
		{
			id: 'mysql_versions',
			colName: 'Version',
			sort: 'versions',
			type: 'PieChart',
			url: 'https://api.wordpress.org/stats/mysql/1.0/',
			data: false,
		},
		{
			id: 'locales',
			colName: 'Locale',
			sort: 'alphabeticaly',
			type: 'PieChart',
			url: 'https://api.wordpress.org/stats/locale/1.0/',
			data: false,
		},
	];

	function drawCharts() {
		charts.forEach( ( chart ) => drawChart( chart ) );
	}

	$( document ).on( 'click', 'a.swap-table', function ( event ) {
		event.preventDefault();
		const $this = $( this ),
			chartId = $this.parents( '.wporg-about-stats-section' ).find( '.wporg-stats-chart' ).attr( 'id' ),
			chart = charts.find( ( { id } ) => id === chartId );

		if ( ! chart ) {
			return;
		}

		if ( 'Table' === chart.type ) {
			chart.type = chart.originalType;
			$this.prop( 'title', i18n.viewAsTable );
			$this.toggleClass( 'dashicons-chart-pie' );
			$this.toggleClass( 'dashicons-editor-table' );
		} else {
			chart.originalType = chart.type;
			chart.type = 'Table';
			$this.prop( 'title', i18n.viewAsChart );
			$this.toggleClass( 'dashicons-chart-pie' );
			$this.toggleClass( 'dashicons-editor-table' );
		}

		drawChart( chart );
	} );

	function drawChart( chart ) {
		const $chartContainer = $( '#' + chart.id );

		if ( ! $chartContainer.length ) {
			return;
		}

		if ( ! chart.data ) {
			if ( chart.loading ) {
				return;
			}
			chart.loading = true;

			$.get( {
				url: chart.url,
				success: ( function () {
					return function ( data ) {
						chart.data = data;
						chart.loading = false;
						drawChart( chart );
					};
				} )(),
			} );
			return;
		}

		const data = 'undefined' !== typeof chart.dataTransform ? chart.dataTransform( chart.data ) : chart.data;

		drawGraph( data, $chartContainer[ 0 ], chart.colName, chart.sort, chart.type );
	}

	function drawGraph( data, container, colName, sort, chartType ) {
		const tableData = [];
		let others = null;

		chartType = chartType || 'PieChart';

		for ( const type in data ) {
			if ( 'Others' === type ) {
				// Make sure "Others" is always the last element.
				others = [ type, Number( data[ type ] ) ];
			} else {
				tableData.push( [ type, Number( data[ type ] ) ] );
			}
		}

		if ( 'versions' === sort ) {
			tableData.sort( function ( a, b ) {
				/*
				 * Converts a string such as 'Example 1.1' to '1.01', or 'Example 10.10' to '10.10'.
				 *
				 * This allows for MariaDB 10.10 to appear beside 10.9.
				 */
				const a_version = a[0].replace( /[^0-9.]/g, '' ).replace( /\.(\d{1})$/g, '.0$1' ),
					b_version = b[0].replace( /[^0-9.]/g, '' ).replace( /\.(\d{1})$/g, '.0$1' );

				return b_version - a_version;
			} );
		} else if ( 'alphabeticaly' === sort ) {
			tableData.sort();
		}

		if ( others ) {
			tableData.push( others );
		}

		// Table headers.
		tableData.unshift( [
			{ label: colName, type: 'string' },
			{ label: 'Usage', type: 'number' },
		] );

		const dataTable = google.visualization.arrayToDataTable( tableData );

		// All charts are percentages.
		const formatter = new google.visualization.NumberFormat( {
			suffix: '%',
			fractionDigits: 2,
		} );

		// Apply formatter to second column
		formatter.format( dataTable, 1 );

		const chartOptions = {
			colors: [
				'#f9a87e',
				'#00b9eb',
				'#e35b5b',
				'#826eb4',
				'#6bc373',
				'#ffc733',
				'#bf461d',
				'#cdc5e1',
				'#46b450',
				'#007cb2',
				'#f78b53',
				'#b02828',
				'#008ec2',
				'#9b8bc3',
				'#685890',
				'#bfe7f3',
				'#006799',
				'#ea8484',
				'#f1adad',
				'#0073aa',
				'#389547',
				'#b4b9be',
				'#b5e1b9',
				'#82878c',
				'#00a0d2',
				'#0085ba',
				'#32373c',
				'#72777C',
				'#33b3db',
				'#9a2323',
				'#f56e28',
				'#ca4a1f',
				'#ffb900',
				'#ffd566',
				'#d54e21',
				'#f6a306',
				'#c62d2d',
				'#b4a8d2',
				'#fbc5a9',
				'#555d66',
				'#66c6e4',
				'#a0a5aa',
				'#4e426c',
				'#90d296',
				'#c7e8ca',
				'#31843f',
				'#99d9ed',
				'#dc3232',
				'#cbcdce',
				'#ee8e0d',
				'#ffe399',
			],
			height: 450,
			is3D: false,
			chartArea: {
				top: 65,
				bottom: 60,
				width: '100%',
				height: '100%',
			},
			legend: {
				position: 'right',
				alignment: 'center',
				textStyle: {
					color: '#444',
					fontSize: 13,
				},
			},
			sliceVisibilityThreshold: 0,
			pieSliceTextStyle: {
				color: '#fff',
				fontSize: 12,
			},
			tooltip: {
				text: 'percentage',
				textStyle: {
					color: '#444',
				},
				showColorCode: true,
				trigger: 'selection'
			},
		};

		$( container ).removeClass( 'loading' );
		const chart = new google.visualization.ChartWrapper( { container, dataTable } );

		chart.setChartType( chartType );
		chart.setOptions( chartOptions );
		chart.draw();

		google.visualization.events.addListener(
			chart.getChart(),
			'onmouseover',
			( entry ) => chart.getChart().setSelection( [ { row: entry.row } ] )
		);

		google.visualization.events.addListener(
			chart.getChart(),
			'onmouseout',
			( entry ) => chart.getChart().setSelection( [] )
		);
	}
} )( window.jQuery, window.google, window.wporgPageStats );
