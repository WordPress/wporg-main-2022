import DownloadModalContainer from '../components/download-modal/';

const initDownloadModal = () => {
	const container = document.createElement( 'div' );

	container.setAttribute( 'id', 'wporg__download-modal-container' );
	document.body.appendChild( container );

	wp.element.render( <DownloadModalContainer />, container );
};

const init = () => {
	if ( document.getElementById( 'wporg__download-button' ) ) {
		initDownloadModal();
	}
};

document.body.onload = init;
