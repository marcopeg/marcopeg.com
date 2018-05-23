<?php
/*
Plugin Name: Typewriter - Markdown for WordPress
Plugin URI: http://dev7studios.com/typewriter
Description: Typewriter replaces the Visual Editor with a simple Markdown editor for your posts and pages.
Version: 1.0
Author: Dev7studios
Author URI: http://dev7studios.com
License: GPL2
*/

class Dev7Typewriter {

    private $plugin_path;
    private $plugin_url;

    function __construct() 
    {	
        $this->plugin_path = plugin_dir_path( __FILE__ );
        $this->plugin_url = plugin_dir_url( __FILE__ );
        register_activation_hook( __FILE__, array(&$this, 'activate') );
        
        add_action( 'plugins_loaded', array(&$this, 'init') );
        add_action( 'profile_update', array(&$this, 'disable_rich_editing') );
		add_action( 'user_register', array(&$this, 'disable_rich_editing') );
		add_action( 'wp_login', array(&$this, 'disable_rich_editing') );
		add_filter( 'quicktags_settings', array(&$this, 'quicktags_settings'), 10, 1 );
		add_action( 'admin_print_footer_scripts', array(&$this, 'footer_scripts') );
		add_action( 'admin_print_scripts', array(&$this, 'remove_tinymce') );
		add_action( 'user_edit_form_tag', array(&$this, 'remove_option') );
		
		remove_filter( 'the_content', 'wpautop' );
		remove_filter( 'the_excerpt', 'wpautop' );
		remove_filter( 'the_content', 'wptexturize' );
		remove_filter( 'the_excerpt', 'wptexturize' );
		add_filter( 'the_content', array(&$this, 'do_markdown') );
		add_filter( 'the_excerpt', array(&$this, 'do_markdown') );
    }
    
    function activate( $network_wide ) {
        $this->disable_rich_editing();
    }
    
    function init() {
        load_plugin_textdomain( 'dev7-typewriter', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
    }
    
	function disable_rich_editing() {
		//update_user_option( get_current_user_id(), 'rich_editing', 'false', true );
		global $wpdb;
		$wpdb->query( "UPDATE `" . $wpdb->prefix . "usermeta` SET `meta_value` = 'false' WHERE `meta_key` = 'rich_editing'" );
	}
	
	function quicktags_settings( $qtInit ) {
		$qtInit['buttons'] = ' ';
		return $qtInit;
	}
	
	function footer_scripts() {
		if( has_action( 'admin_print_footer_scripts', 'wp_tiny_mce' ) ){
			remove_action( 'admin_print_footer_scripts', 'wp_tiny_mce', 25 );
		}
		
		if( wp_script_is('quicktags') ){
			?>
			<script type="text/javascript">
			QTags.addButton( 'md_bold', 'b', '**', '**', 'b',' <?php _e( 'Bold', 'dev7-typewriter' ); ?>', 201 );
			QTags.addButton( 'md_italic', 'i', '*', '*', 'i', '<?php _e( 'Italic', 'dev7-typewriter' ); ?>', 202 );
			QTags.addButton( 'md_link', 'link', '[', '](http://)', 'a', '<?php _e( 'Link', 'dev7-typewriter' ); ?>', 203 );
			QTags.addButton( 'md_quote', 'quote', '> ', ' ', 'q', '<?php _e( 'Quote', 'dev7-typewriter' ); ?>', 204 );
			QTags.addButton( 'md_image', 'img', '![Alt Text](http://)', '', 'm', '<?php _e( 'Image', 'dev7-typewriter' ); ?>', 205 );
			QTags.addButton( 'md_code', 'code', '`','`', 'c', '<?php _e( 'Code', 'dev7-typewriter' ); ?>', 206 );
			QTags.addButton( 'md_more', 'more', '<!--more-->', '', 't', '<?php _e( 'More', 'dev7-typewriter' ); ?>', 207 );
			</script>
			<?php
		}
	}
	
	function remove_tinymce() {
		if( has_filter( 'admin_print_footer_scripts', 'wp_tiny_mce' ) || 
			has_filter( 'before_wp_tiny_mce', 'wp_print_editor_js' ) || 
			has_filter( 'after_wp_tiny_mce', 'wp_preload_dialogs' ) ){
			remove_filter( 'admin_print_footer_scripts', 'wp_tiny_mce', 25 );
			remove_filter( 'before_wp_tiny_mce', 'wp_print_editor_js' );
			remove_filter( 'after_wp_tiny_mce', 'wp_preload_dialogs' );
		}
	}
	
	function remove_option() {
		global $wp_rich_edit_exists;
		$wp_rich_edit_exists = false;
	}
	
	function do_markdown( $content ) {
		if( !class_exists( 'Michelf\MarkdownExtra' ) ){
			spl_autoload_register(function( $class ){
				require_once plugin_dir_path( __FILE__ ) .'/includes/markdown/'. preg_replace('{\\\\|_(?!.*\\\\)}', DIRECTORY_SEPARATOR, ltrim($class, '\\')).'.php';
			});
		}
		
		return Michelf\MarkdownExtra::defaultTransform( $content );
	}

}
new Dev7Typewriter();

?>