/**
 * WordPress dependencies
 */
import { Button } from '@wordpress/components';
import { useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import DownloadModal from '../download-modal';

const DownloadButton = () => {
	const [ showModal, setShowModal ] = useState( false );

	return (
		<>
			<Button className="download-button" isLink onClick={ () => setShowModal( true ) }>
				{ __( 'Download WordPress 6.0.1', 'wporg' ) }
			</Button>

			{ showModal && (
				<DownloadModal
					onClose={ () => {
						setShowModal( false );
					} }
				/>
			) }
		</>
	);
};

export default DownloadButton;
