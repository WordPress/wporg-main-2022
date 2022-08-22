/**
 * WordPress dependencies
 */
import { useEffect, useState } from '@wordpress/element';

/**
 * Internal dependencies
 */
import DownloadModal from './download-modal';

const DownloadModalContainer = () => {
	const [ showModal, setShowModal ] = useState( false );

	useEffect( () => {
		const downloadButtonLink = document.querySelector( '#wporg__download-button .wp-block-button__link' );

		if ( ! downloadButtonLink ) {
			return;
		}

		downloadButtonLink.addEventListener( 'click', () => {
			setShowModal( true );
		} );

		return () => {
			downloadButtonLink.removeEventListener( 'click' );
		};
	}, [] );

	return showModal ? (
		<DownloadModal
			onClose={ () => {
				setShowModal( false );
			} }
		/>
	) : null;
};

export default DownloadModalContainer;
