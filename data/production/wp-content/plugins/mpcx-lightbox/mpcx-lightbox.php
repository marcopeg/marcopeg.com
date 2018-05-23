<?php
/**
 * @link              https://github.com/tronsha/wp-lightbox-plugin
 * @since             1.0.0
 * @package           wp-lightbox-plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Lightbox
 * Plugin URI:        https://github.com/tronsha/wp-lightbox-plugin
 * Description:       Lightbox Plugin
 * Version:           1.2.4
 * Author:            Stefan Hüsges
 * Author URI:        http://www.mpcx.net/
 * Copyright:         Stefan Hüsges
 * Text Domain:       mpcx-lightbox
 * Domain Path:       /languages/
 * License:           MIT
 * License URI:       https://raw.githubusercontent.com/tronsha/wp-lightbox-plugin/master/LICENSE
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define( 'MPCX_LIGHTBOX_VERSION', '1.2.4' );

load_plugin_textdomain( 'mpcx-lightbox', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

register_activation_hook(
	__FILE__,
	function () {
		add_option(
			'mpcx_lightbox', 
			array( 
				'version' => MPCX_LIGHTBOX_VERSION, 
				'gallery' => '', 
				'standalone' => '', 
				'lightbox' => 'lightbox', 
				'title' => '', 
				'ajax' => '', 
				'justified' => '', 
				'justified_height' => '120',
				'justified_margins' => '3',
				'justified_captions' => '1',
				'justified_randomize' => '',
			) 
		);
	}
);

if ( true === is_admin() ) {

	add_action(
		'upgrader_process_complete',
		function ( $object, $options ) {
			if ( 'update' === $options['action'] && 'plugin' === $options['type'] ) {
				if ( true === in_array( plugin_basename( __FILE__ ), $options['plugins'] ) ) {
					include_once plugin_dir_path( __FILE__ ) . 'update.php';
				}
			}
		},
		10,
		2
	);

	add_action(
		'admin_init',
		function () {
			register_setting(
				'mpcx_lightbox',
				'mpcx_lightbox'
			);
		}
	);

	add_action(
		'admin_menu',
		function () {
			add_options_page(
				'Lightbox',
				'Lightbox',
				'manage_options',
				'lightbox',
				function () {
					include plugin_dir_path( __FILE__ ) . 'admin/options.php';
				}
			);
		}
	);

	add_filter(
		'plugin_action_links',
		function ( $actions, $plugin_file ) {
			static $plugin;
			if ( ! isset( $plugin ) ) {
				$plugin = plugin_basename( __FILE__ );
			}
			if ( $plugin == $plugin_file ) {
				$settings = array( 'settings' => '<a href="options-general.php?page=lightbox">' . __( 'Settings', 'mpcx-lightbox' ) . '</a>' );
				$actions  = array_merge( $settings, $actions );
			}

			return $actions;
		},
		10,
		5
	);

	$data = get_option( 'mpcx_lightbox' );
	if ( true === isset( $data['version'] ) && true === version_compare( $data['version'], MPCX_LIGHTBOX_VERSION, '<' ) ) {
            include_once plugin_dir_path( __FILE__ ) . 'update.php';
	}

}

add_filter(
	'wp_get_attachment_link',
	function ( $markup, $id, $size, $permalink, $icon, $text ) {
		$options = get_option( 'mpcx_lightbox' );
		$titleId = intval( $options['title'] );
		$post    = get_post( $id );
		switch ( $titleId ) {
			case 1:
				$title = $post->post_title;
				break;
			case 2:
				$title = $post->post_content;
				break;
			case 3:
				$title = $post->post_excerpt;
				break;
			case 0:
			default:
				return $markup;
		}
		$parts = explode( '>', $markup, 2 );
		if ( false === empty( $title ) && false === empty( $parts[0] ) && false === empty( $parts[1] ) ) {
			switch ( $options['lightbox'] ) {
				case 'fancybox':
					$attributeName = 'data-caption';
					break;
				case 'lightbox':
				default:
					$attributeName = 'data-title';
					break;
			}
			if ( false === strpos( $parts[0], $attributeName ) ) {
				$markup = $parts[0] . ' ' . $attributeName . '=\'' . esc_attr( $title ) . '\'>' . $parts[1];
			}
		}

		return $markup;
	},
	10,
	6
);

add_action(
	'wp_enqueue_scripts',
	function () {
		$jsData            = array();
		$jsData['ajaxUrl'] = admin_url( 'admin-ajax.php' );
		$options           = get_option( 'mpcx_lightbox' );
		if ( 1 !== intval( $options['gallery'] ) ) {
			$jsData['gallery'] = true;
		}
		if ( 1 !== intval( $options['standalone'] ) ) {
			$jsData['standalone'] = true;
		}
		if ( 1 === intval( $options['ajax'] ) ) {
			$jsData['ajax'] = true;
		}
		if ( 1 === intval( $options['justified'] ) ) {
			$jsData['justified'] = true;
			$jsData['justified_height'] = intval($options['justified_height']) > 0 ? intval($options['justified_height']) : 120 ;
			$jsData['justified_margins'] = intval($options['justified_margins']);
			$jsData['justified_captions'] = intval($options['justified_captions']);
			$jsData['justified_randomize'] = intval($options['justified_randomize']);
		}
		switch ( $options['lightbox'] ) {
			case 'fancybox':
				$fileName           = 'fancybox';
				$jsData['lightbox'] = 'fancybox';
				$jsData['title']    = 'caption';
				break;
			case 'lightbox':
			default:
				$fileName           = 'lightbox';
				$jsData['lightbox'] = 'lightbox';
				$jsData['title']    = 'title';
				break;
		}
		wp_register_style(
			'mpcx-lightbox',
			plugin_dir_url( __FILE__ ) . 'public/css/' . $fileName . '.min.css',
			array(),
			MPCX_LIGHTBOX_VERSION
		);
		wp_register_script(
			'mpcx-lightbox',
			plugin_dir_url( __FILE__ ) . 'public/js/' . $fileName . '.min.js',
			array( 'jquery' ),
			MPCX_LIGHTBOX_VERSION,
			true
		);
		wp_register_script(
			'mpcx-images2lightbox',
			plugin_dir_url( __FILE__ ) . 'public/js/images.min.js',
			array( 'jquery' ),
			MPCX_LIGHTBOX_VERSION,
			true
		);
		wp_enqueue_style( 'mpcx-lightbox' );
		wp_enqueue_script( 'mpcx-lightbox' );
		wp_enqueue_script( 'mpcx-images2lightbox' );
		wp_localize_script( 'mpcx-images2lightbox', 'lbData', $jsData );
		if ( true === is_admin_bar_showing() ) {
			wp_add_inline_style( 'admin-bar', '#wpadminbar {z-index: 99990;}' );
		}
		if ( 1 === intval( $options['justified'] ) ) {
			wp_register_style(
				'mpcx-justifiedgallery',
				plugin_dir_url( __FILE__ ) . 'public/css/justifiedgallery.min.css',
				array(),
				MPCX_LIGHTBOX_VERSION
			);
			wp_register_script(
				'mpcx-justifiedgallery',
				plugin_dir_url( __FILE__ ) . 'public/js/justifiedgallery.min.js',
				array( 'jquery' ),
				MPCX_LIGHTBOX_VERSION,
				true
			);
			wp_enqueue_style( 'mpcx-justifiedgallery' );
			wp_enqueue_script( 'mpcx-justifiedgallery' );
		}
	}
);

function lightbox_get_image_title() {
	$options = get_option( 'mpcx_lightbox' );
	$titleId = intval( $options['title'] );
	$post    = get_post( intval( $_POST['postId'] ) );
	switch ( $titleId ) {
		case 1:
			$title = $post->post_title;
			break;
		case 2:
			$title = $post->post_content;
			break;
		case 3:
			$title = $post->post_excerpt;
			break;
		case 0:
		default:
			$title = '';
			break;
	}
	die( json_encode( $title ) );
}

add_action( 'wp_ajax_lightbox_get_image_title', 'lightbox_get_image_title' );
add_action( 'wp_ajax_nopriv_lightbox_get_image_title', 'lightbox_get_image_title' );
