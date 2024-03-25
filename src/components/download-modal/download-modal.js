/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { Modal } from '@wordpress/components';

const DownloadModal = ( { onClose } ) => (
	<Modal className="wporg__download-modal" title={ __( 'Howdy!', 'wporg' ) } onRequestClose={ onClose }>
		<>
			<p className="wporg__download-modal-sub-header is-style-serif">
				{ __( 'Thanks for downloading WordPress', 'wporg' ) }
			</p>
			<div className="wporg__download-modal-content">
				<p>
					{ __(
						"You're an important part of the global community that has used, built, and transformed the platform into what it is today. Find out more ways you can contribute and make an impact on the future of the web.",
						'wporg'
					) }
				</p>
				<ul>
					<li>
						<a href="https://make.wordpress.org/">{ __( 'Get involved in WordPress ↗︎', 'wporg' ) }</a>
					</li>
					<li>
						<a href="https://www.meetup.com/pro/wordpress/">
							{ __( 'Join a local WordPress meetup ↗︎', 'wporg' ) }
						</a>
					</li>
					<li>
						<a href="https://central.wordcamp.org/">{ __( 'Attend a WordCamp ↗︎', 'wporg' ) }</a>
					</li>
					<li>
						<a href="https://wordpressfoundation.org/donate/">
							{ __( 'Support WordPress and open source education ↗︎', 'wporg' ) }
						</a>
					</li>
				</ul>
			</div>
		</>
	</Modal>
);

export default DownloadModal;
