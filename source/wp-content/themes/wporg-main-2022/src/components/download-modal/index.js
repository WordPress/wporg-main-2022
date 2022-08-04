/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { Modal } from '@wordpress/components';

const DownloadModal = ( { onClose } ) => (
	<Modal className="download-modal" title={ __( 'Howdy!', 'wporg' ) } onRequestClose={ onClose }>
		<div>
			<p>
				You&rsquo;re an important part of the global community that has used, built, and transformed the
				platform into what it is today. Find out more ways you can contribute and make an impact on the
				future of the web.
			</p>
			<ul>
				<li>Get involved in WordPress ↗</li>
				<li>Join a local WordPress meetup ↗</li>
				<li>Attend a WordCamp ↗</li>
				<li>Support WordPress and open source education ↗</li>
			</ul>
		</div>
	</Modal>
);

export default DownloadModal;
