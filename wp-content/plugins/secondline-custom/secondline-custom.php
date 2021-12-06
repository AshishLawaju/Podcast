<?php
/*
Plugin Name: SecondLine Custom Addons
Text Domain: secondline-custom-plugin
Plugin URI: https://secondlinethemes.com
Description: Theme Addons for SecondLine Themes
Version: 2.0.6
Author: SecondLine Themes
Author URI: https://secondlinethemes.com
Author Email: support@secondlinethemes.com
License: GNU General Public License v3.0
Text Domain: secondline-custom-plugin
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

if ( ! defined( 'SECONDLINE_THEME_ELEMENTS_URL' )) {
	define( 'SECONDLINE_THEME_ELEMENTS_URL', plugins_url( '/', __FILE__ ) );
}
if ( ! defined( 'SECONDLINE_THEME_ELEMENTS_PATH' )) {
	define( 'SECONDLINE_THEME_ELEMENTS_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'SLT_VERSION' )) {
	define( 'SLT_VERSION', '201' );
}

// Plugin Setup
add_action('plugins_loaded', 'secondline_theme_elements_plugin');

if(!function_exists('secondline_theme_elements_plugin')) {
	function secondline_theme_elements_plugin() {
		// Load Text Domain
		load_plugin_textdomain( 'secondline-elements-plugin', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
		// Calling new Page Builder Elements
		require_once SECONDLINE_THEME_ELEMENTS_PATH.'inc/elementor-helper.php';
	}
}

/**
 * Registering Custom Post Type
 */

add_action('init', 'secondline_custom_post_type_init');
function secondline_custom_post_type_init() {	
	if ( function_exists( 'tusant_secondline_theme_active' ) || function_exists( 'bolden_secondline_theme_active' ) ) {
		register_post_type(
			'secondline_shows',
			array(
				'labels' => array(
					'name' => esc_html__( 'Shows', 'secondline-custom-plugin' ),
					'singular_name' => esc_html__( 'Show', 'secondline-custom-plugin' )
				),
				'public' => true,
				'has_archive' => false,
				'menu_position' => 5,
				'menu_icon'   => 'dashicons-tickets-alt',
				'rewrite' => array('slug' => 'show'),
				'supports' => array('title', 'editor', 'thumbnail'),
				'can_export' => true,
			)
		);
		register_taxonomy(
			'show_category', 'secondline_shows', 
			array(
				'hierarchical' => true, 
				'label' => esc_html__( 'Show Categories', 'secondline-custom-plugin' ), 
				'query_var' => true, 
				'rewrite' => true
			)
		);
	}
	
	// Calling Custom Metaboxes (CMB2)
	if(function_exists('satchmo_secondline_theme_active')) {
		// Do nothing, loaded from within the theme folder
	} else {
		require_once SECONDLINE_THEME_ELEMENTS_PATH.'inc/custom-meta.php';
	}	
	
}

add_action('init', 'secondline_themes_add_post_formats_to_page');
if(!function_exists('secondline_themes_add_post_formats_to_page')) {
	function secondline_themes_add_post_formats_to_page(){
		if(function_exists('ssp_episodes')) {
			add_post_type_support( 'podcast', 'post-formats' );
			register_taxonomy_for_object_type( 'post_format', 'podcast' );
		}
	}
}


// CSS Styles in Admin
if(!function_exists('secondline_theme_elements_wp_admin_style')) {
	function secondline_theme_elements_wp_admin_style() {
		wp_register_style( 'secondline-elements-plugin-admin-styles',  SECONDLINE_THEME_ELEMENTS_URL . 'assets/css/admin.css' );	
		wp_enqueue_style( 'secondline-elements-plugin-admin-styles' );
		wp_enqueue_script( 'secondline_themes_import_data', plugin_dir_url( __FILE__ ) . 'assets/js/importdata.js' );
	}
}
add_action( 'admin_enqueue_scripts', 'secondline_theme_elements_wp_admin_style' );


if(!function_exists('secondline_custom_plugin_scripts')) {
	function secondline_custom_plugin_scripts() {      

		// Enqueue mediaelement.js scripts 
		wp_enqueue_script( 'secondline-audio-player', plugin_dir_url( __FILE__ ) . 'assets/js/audio/mediaelement-and-player.js', array( 'jquery' ), SLT_VERSION, true );
		wp_enqueue_script( 'secondline-audio-player-playlist', plugin_dir_url( __FILE__ ) . 'assets/js/audio/mediaelement-playlist.js', array( 'jquery'), SLT_VERSION, true );
		wp_enqueue_script( 'secondline-audio-player-skip-back', plugin_dir_url( __FILE__ ) . 'assets/js/audio/mediaelement-skip-back.js', array( 'jquery'), SLT_VERSION, true );
		wp_enqueue_script( 'secondline-audio-player-jump-forward', plugin_dir_url( __FILE__ ) . 'assets/js/audio/mediaelement-jump-forward.js', array( 'jquery'), SLT_VERSION, true );
		wp_enqueue_script( 'secondline-audio-player-speed', plugin_dir_url( __FILE__ ) . 'assets/js/audio/mediaelement-speed.js', array( 'jquery'), SLT_VERSION, true );
		
		// Enqueue custom audio player JS
		wp_enqueue_script( 'secondline-audio-main', plugin_dir_url( __FILE__ ) . 'assets/js/audio/secondline-audio.js', array( 'jquery' ), SLT_VERSION, true );
		
		// Enqueue custom audio player CSS
		wp_register_style( 'secondline-audio-player-styles',  SECONDLINE_THEME_ELEMENTS_URL . 'assets/css/secondline-audio.css' );
		wp_enqueue_style( 'secondline-audio-player-styles' );
		
		// Remove default mediaelement.js script (already loaded above)
		wp_deregister_script( 'mediaelement' );
					   
	}
}

// Calling Audio Customizer Options
require_once SECONDLINE_THEME_ELEMENTS_PATH.'inc/customizer/customizer-settings.php';

if(get_theme_mod('secondline_themes_fancy_player', 'secondline-themes-fancy-player') == 'secondline-themes-fancy-player') {
	add_action( 'wp_enqueue_scripts', 'secondline_custom_plugin_scripts' );
	add_filter( 'body_class', 'secondline_audio_player_bodyclass' );
}

function secondline_audio_player_bodyclass($classes) {
    $classes[] = 'secondline-fancy-player';
	if(get_option('ss_podcasting_player_style') == 'larger') {
	$classes[] = 'secondline-ssp-larger-player';
	}
    return $classes;
}

// Calling Instagram Widget
require_once SECONDLINE_THEME_ELEMENTS_PATH.'inc/wp-instagram-widget.php';

// Calling Custom Icon Picker (CMB2)
require_once SECONDLINE_THEME_ELEMENTS_PATH.'inc/cmb2-icon-picker/cmb2-fontawesome-picker.php';


if(!function_exists('secondline_theme_elements_load_elements')) {
	function secondline_theme_elements_load_elements(){
		require_once SECONDLINE_THEME_ELEMENTS_PATH.'elements/post-addon.php';	
		
		// If site has more than 1,000 posts -> don't load the single post addon. Improves performance.
		$secondline_count_posts = wp_count_posts('post');
		if($secondline_count_posts->publish < 1000) {
			require_once SECONDLINE_THEME_ELEMENTS_PATH.'elements/single-post-addon.php';
		}
		require_once SECONDLINE_THEME_ELEMENTS_PATH.'elements/slider-addon.php';
		require_once SECONDLINE_THEME_ELEMENTS_PATH.'elements/playlist-addon.php';
		
		if ( function_exists( 'tusant_secondline_theme_active' ) || function_exists( 'bolden_secondline_theme_active' ) ) {
			require_once SECONDLINE_THEME_ELEMENTS_PATH.'elements/show-carousel-addon.php';
			require_once SECONDLINE_THEME_ELEMENTS_PATH.'elements/show-grid-addon.php';
			require_once SECONDLINE_THEME_ELEMENTS_PATH.'elements/show-slider-addon.php';
		}
		
		if ( function_exists( 'WC' ) ) {
			require_once SECONDLINE_THEME_ELEMENTS_PATH.'elements/products-addon.php';
		}
		
		if ( function_exists( 'wpcf7' ) ) {
			require_once SECONDLINE_THEME_ELEMENTS_PATH.'elements/contact-addon.php';
		}		
		
		if ( function_exists( 'secondline_psb_theme_elements_buttons' ) ) {
			require_once SECONDLINE_THEME_ELEMENTS_PATH.'elements/psb-addon.php';
		}	

		require_once SECONDLINE_THEME_ELEMENTS_PATH.'elements/host-addon.php';		
		
	}
}
add_action('elementor/widgets/widgets_registered','secondline_theme_elements_load_elements');


// Elementor Admin Styles
add_action( 'elementor/editor/before_enqueue_scripts', function() {
	
	wp_register_style( 'secondline-elements-secondline-admin-styles',  SECONDLINE_THEME_ELEMENTS_URL . 'assets/css/elementor-custom.css' );
	wp_enqueue_style( 'secondline-elements-secondline-admin-styles', [ 'elementor-editor', ] );
   
	if(!function_exists('elementor_pro_load_plugin')) {
		wp_register_style( 'secondline-elements-secondline-pro-styles',  SECONDLINE_THEME_ELEMENTS_URL . 'assets/css/elementor-custom-pro.css' );
		wp_enqueue_style( 'secondline-elements-secondline-pro-styles', [ 'elementor-editor', ] );   
	}
   
	
} );

// SSP Filter - Disable fetching filesize and duration of remote files.
if(!function_exists('secondline_disable_ssp_external_file_handling')) {
	function secondline_disable_ssp_external_file_handling() {
		return false;
	}
}
add_filter( 'ssp_enable_get_file_duration', 'secondline_disable_ssp_external_file_handling' );
add_filter( 'ssp_enable_get_file_size', 'secondline_disable_ssp_external_file_handling' );


// Backup Importer. Don't duplicate!
if ( !class_exists( 'Radium_Theme_Demo_Data_Importer' ) ) {

	require_once( dirname( __FILE__ ) . '/importer/radium-importer.php' ); //load admin theme data importer

	class Radium_Theme_Demo_Data_Importer extends Radium_Theme_Importer {

		/**
		 * Holds a copy of the object for easy reference.
		 *
		 * @since 0.0.1
		 *
		 * @var object
		 */
		private static $instance;

		/**
		 * Set name of the widgets json file
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $widgets_file_name       = 'widgets.json';

		/**
		 * Set name of the content file
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $content_demo_file_name  = 'content.xml';
		
		/**
		 * Holds a copy of the widget settings
		 *
		 * @since 0.0.2
		 *
		 * @var string
		 */
		public $widget_import_results;

		/**
		 * Constructor. Hooks all interactions to initialize the class.
		 *
		 * @since 0.0.1
		 */
		public function __construct() {

			$this->demo_files_path = get_template_directory() . '/demo-files/';
			$this->theme_name1="secondline-themes";
			$ddd = get_template_directory_uri() . '/demo-files/'; 
			$this->theme_namess=$ddd;	
			self::$instance = $this;
			parent::__construct();

		}

	}

	new Radium_Theme_Demo_Data_Importer;

}

