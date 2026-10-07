/**
 * WordPress dependencies
 */
import { useBlockProps } from '@wordpress/block-editor';
import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import metadata from './block.json';
import './style.scss';

function Edit() {
	return <div { ...useBlockProps() }>Google Search</div>;
}

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
} );
