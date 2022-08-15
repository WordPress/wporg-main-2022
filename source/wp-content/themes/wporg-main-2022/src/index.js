import DownloadModalContainer from './components/download-modal/';

const initDownloadModal = () => {
	const downloadModalContainerEl = document.createElement( 'div' );
	const downloadModalContainerId = 'wporg__download-modal-container';

	downloadModalContainerEl.setAttribute( 'id', downloadModalContainerId );
	document.body.appendChild( downloadModalContainerEl );

	wp.element.render( <DownloadModalContainer />, document.getElementById( downloadModalContainerId ) );
};

const init = () => {
	if ( document.getElementById( 'wporg__download-button' ) ) {
		initDownloadModal();
	}
};

document.body.onload = init;
