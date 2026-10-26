/**
 * WordPress dependencies
 */

import { Disabled, PanelBody, RangeControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

export default function Edit( { attributes, name, setAttributes } ) {
	const { columns } = attributes;
	return (
		<div { ...useBlockProps() }>
			<InspectorControls>
				<PanelBody title={ __( 'Settings', 'wporg' ) }>
					<RangeControl
						label={ __( 'Columns', 'wporg' ) }
						value={ columns }
						onChange={ ( newNumber ) => setAttributes( { columns: parseInt( newNumber ) } ) }
						min={ Math.max( 1, 1 ) }
						max={ Math.max( 6, 10 ) }
					/>
				</PanelBody>
			</InspectorControls>
			<Disabled>
				<ServerSideRender block={ name } attributes={ attributes } />
			</Disabled>
		</div>
	);
}
