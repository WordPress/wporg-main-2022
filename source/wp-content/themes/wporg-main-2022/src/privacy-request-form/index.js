/**
 * WordPress dependencies
 */
import { useBlockProps } from '@wordpress/block-editor';
import { SelectControl } from '@wordpress/components';
import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import metadata from './block.json';

function Edit( { attributes, setAttributes } ) {
	return (
		<div { ...useBlockProps() }>
			<SelectControl
				label="Request Type"
				value={ attributes.type }
				options={ [
					{ label: 'Data Export', value: 'export' },
					{ label: 'Data Erasure', value: 'erase' },
				] }
				onChange={ ( type ) => setAttributes( { type } ) }
			/>
			<p><em>Privacy request form will render here.</em></p>
		</div>
	);
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
