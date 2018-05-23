<?php
/**
 * @link    https://github.com/tronsha/wp-lightbox-plugin
 * @package wp-lightbox-plugin
 */

define( 'MPCX_LIGHTBOX_UPDATE_VERSION', '1.2.4' );
$data = get_option( 'mpcx_lightbox' );
if ( true === isset( $data['version'] ) && true === version_compare( $data['version'], MPCX_LIGHTBOX_UPDATE_VERSION, '<' ) ) {

	if ( true === version_compare( $data['version'], '1.2.4', '<' ) ) {
		$data['justified_height'] = '120';
		$data['justified_margins'] = '3';
		$data['justified_captions'] = '1';
	}

}
$data['version'] = MPCX_LIGHTBOX_UPDATE_VERSION;
update_option( 'mpcx_lightbox', $data );
