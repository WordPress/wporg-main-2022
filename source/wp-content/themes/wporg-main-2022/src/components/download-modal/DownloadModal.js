/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { Modal } from '@wordpress/components';

const DownloadModal = ( { onClose } ) => (
	<Modal className="wporg__download-modal" title={ __( 'Howdy!', 'wporg' ) } onRequestClose={ onClose }>
		<>
			<p className="wporg__download-modal-sub-header is-style-serif">Thanks for downloading WordPress</p>
			<div className="wporg__download-modal-content">
				<p>
					You&rsquo;re an important part of the global community that has used, built, and transformed
					the platform into what it is today. Find out more ways you can contribute and make an impact on
					the future of the web.
				</p>
				<ul>
					<li>
						<a href="https://make.wordpress.org/">Get involved in WordPress ↗</a>
					</li>
					<li>
						<a href="https://www.meetup.com/pro/wordpress/">Join a local WordPress meetup ↗</a>
					</li>
					<li>
						<a href="https://central.wordcamp.org/">Attend a WordCamp ↗</a>
					</li>
					<li>
						<a href="https://wordpressfoundation.org/donate/">
							Support WordPress and open source education ↗
						</a>
					</li>
				</ul>
			</div>
		</>
	</Modal>
);

export default DownloadModal;
