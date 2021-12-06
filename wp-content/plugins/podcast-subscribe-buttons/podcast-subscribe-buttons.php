<?php
/*
Plugin Name: Podcast Subscribe Buttons
Description: Easily add custom subscribe (follow) buttons for any podcasting platform or podcast destination
Version: 1.4.1
Author: SecondLine Themes
Author URI: https://secondlinethemes.com
Author Email: support@secondlinethemes.com
License: GNU General Public License v3.0
Text Domain: secondline-psb-custom-buttons
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.


define( 'SECONDLINE_PSB_SUBSCRIBE_ELEMENTS_URL', plugins_url( '/', __FILE__ ) );
define( 'SECONDLINE_PSB_SUBSCRIBE_ELEMENTS_PATH', plugin_dir_path( __FILE__ ) );
define( 'SECONDLINE_PSB_PREFIX', 'secondline_psb_' );


// Translation Setup
add_action('plugins_loaded', 'secondline_psb_theme_elements_buttons');
function secondline_psb_theme_elements_buttons() {
	load_plugin_textdomain( 'secondline-psb-elements-buttons', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );
}

/**
 * Extend list of allowed protocols.
 *
 * @param array $protocols List of default protocols allowed by WordPress.
 *
 * @return array $protocols Updated list including new protocols.
 */
function wporg_extend_allowed_protocols( $protocols ){
    $protocols[] = 'spotify';
    return $protocols;
}
add_filter( 'kses_allowed_protocols' , 'wporg_extend_allowed_protocols' );



/**
 * Registering Custom Post Type
 */
add_action('init', function() {
	
	$block_asset_data = include( plugin_dir_path( __FILE__ ) . 'build/index.asset.php');
	wp_register_script(
		'secondline-themes-psb-block-script',
		plugins_url( 'build/index.js', __FILE__ ),
		$block_asset_data['dependencies'],
		$block_asset_data['version']
	);
	wp_register_style( 'secondline-psb-subscribe-button-styles',  SECONDLINE_PSB_SUBSCRIBE_ELEMENTS_URL . 'assets/css/secondline-psb-styles.css' );
	
	register_block_type( 'secondline-themes/podcast-subscribe-button', array(
		'api_version' => 2,
		'editor_script' => 'secondline-themes-psb-block-script',
		'editor_style' => 'secondline-psb-subscribe-button-styles',
		'render_callback' => 'secondline_psb_subscribe_shortcode',
		'attributes'      => [
			'id' => [
				'type'    => 'integer'
			],
			'use_saved_button' => [
				'type'    => 'integer'
			],
			'secondline_psb_text' => [
				'type'    => 'string'
			],
			'secondline_psb_select_type' => [
				'type'    => 'string'
			],
			'secondline_psb_select_style' => [
				'type'    => 'string'
			],
			'secondline_psb_background_color' => [
				'type'    => 'string'
			],
			'secondline_psb_text_color' => [
				'type'    => 'string'
			],
			'secondline_psb_background_color_hover' => [
				'type'    => 'string'
			],
			'secondline_psb_text_color_hover' => [
				'type'    => 'string'
			],
			'secondline_psb_repeat_subscribe' => [
                'type' => 'array'
            ],
            'alignment' => [
            	'type' => 'string'
            ]
		]
	) );
	
	register_post_type(
		'secondline_psb_post',
		array(
			'labels' => array(
				'name' => esc_html__( 'Subscribe Buttons', 'secondline-psb-custom-buttons' ),
				'singular_name' => esc_html__( 'Subscribe Button', 'secondline-psb-custom-buttons' ),
				'add_new_item'          => sprintf( __( 'Add New %s', 'secondline-psb-custom-buttons' ), __( 'Subscribe Button', 'secondline-psb-custom-buttons' ) ),
				'edit_item'             => sprintf( __( 'Edit %s', 'secondline-psb-custom-buttons' ), __( 'Subscribe Button', 'secondline-psb-custom-buttons' ) ),
				'new_item'              => sprintf( __( 'New %s', 'secondline-psb-custom-buttons' ), __( 'Subscribe Button', 'secondline-psb-custom-buttons' ) ),
				'all_items'             => sprintf( __( 'All %s', 'secondline-psb-custom-buttons' ), __( 'Subscribe Buttons', 'secondline-psb-custom-buttons' ) ),
				'view_item'             => sprintf( __( 'View %s', 'secondline-psb-custom-buttons' ), __( 'Subscribe Button', 'secondline-psb-custom-buttons' ) ),
				'search_items'          => sprintf( __( 'Search %s', 'secondline-psb-custom-buttons' ), __( 'Subscribe Buttons', 'secondline-psb-custom-buttons' ) ),
				'not_found'             => sprintf( __( 'No %s Found', 'secondline-psb-custom-buttons' ), __( 'Subscribe Buttons', 'secondline-psb-custom-buttons' ) ),
				'not_found_in_trash'    => sprintf( __( 'No %s Found In Trash', 'secondline-psb-custom-buttons' ), __( 'Subscribe Button', 'secondline-psb-custom-buttons' ) ),
				'filter_items_list'     => sprintf( __( 'Filter %s list', 'secondline-psb-custom-buttons' ), __( 'Subscribe Button', 'secondline-psb-custom-buttons' ) ),
				'items_list_navigation' => sprintf( __( '%s list navigation', 'secondline-psb-custom-buttons' ), __( 'Subscribe Button', 'secondline-psb-custom-buttons' ) ),
				'items_list'            => sprintf( __( '%s list', 'secondline-psb-custom-buttons' ), __( 'Subscribe Button', 'secondline-psb-custom-buttons' ) ),				
			),
			'public' => true,
			'has_archive' => false,
			'show_in_menu' => false,
			'menu_position' => 90,
			'menu_icon'   => 'dashicons-share',
			'show_in_rest' => true,
			'supports' => array('title'),
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'can_export' => true,
		)
	);
});


// Add a new menu link under Tools
if ( is_admin() ) {
	add_action( 'admin_menu', 'secondline_psb_add_page');
}
	
function secondline_psb_add_page() {
	add_management_page( esc_attr__('Podcast Subscribe Buttons','secondline-psb-custom-buttons'), esc_attr__('Podcast Subscribe Buttons','secondline-psb-custom-buttons'), 'manage_options', 'edit.php?post_type=secondline_psb_post');
}


/* Add 'Setting' link to plugins page */
function secondline_psb_add_settings_link( $links ) {
    $settings_link = '<a href="edit.php?post_type=secondline_psb_post">' . esc_attr__('Settings','secondline-psb-custom-buttons') . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'secondline_psb_add_settings_link' );



/**
 * Registering Custom Shortcode
 */
function secondline_psb_custom_subscribe_shortcode() {
    add_shortcode( 'podcast_subscribe', 'secondline_psb_subscribe_shortcode' );
}
add_action( 'init', 'secondline_psb_custom_subscribe_shortcode' );

function secondline_psb_subscribe_shortcode( $atts ) {
    global $wp_query, $post;
    
    if(! isset( $atts['id'])) $atts['id'] = -1;
	if(! isset( $atts['use_saved_button'])) {
		if( $atts['id'] != -1 ) $atts['use_saved_button'] = 1;
		else $atts['use_saved_button'] = 0;
	}
	
	$type = isset( $atts['type'] ) ? $atts['type'] : null;

    // If using a saved button (shortcode), grab the data from database (post meta)
    if( intval( $atts['use_saved_button'] ) == 1 ) {
        // If passed an ID, grab the data from database
        $id = $atts['id'];
        $atts = get_metadata('post', $atts['id'],'',true);

	    foreach ($atts as $key => $val) {
	        if( is_array( $atts[ $key ] ) && count( $atts[ $key ] ) > 0 ){
		        $atts[ $key ] = $val[0];
            }
        }
	    $atts['id'] = $id;
	    
	    if( !is_array($atts[ SECONDLINE_PSB_PREFIX . 'repeat_subscribe' ]) ){
		    $atts[ SECONDLINE_PSB_PREFIX . 'repeat_subscribe' ] = unserialize( $atts[ SECONDLINE_PSB_PREFIX . 'repeat_subscribe' ] );
        }
        if( false === $atts ) return false;
    }

    // Normalize data coming from shortcode attributes
    // or from post metadata in $attr variable
    $atts = shortcode_atts( array(
        'id' => uniqid(),
	    SECONDLINE_PSB_PREFIX . 'text' => 'Subscribe',
	    SECONDLINE_PSB_PREFIX . 'select_type' => 'inline',
	    SECONDLINE_PSB_PREFIX . 'select_style' => 'square',
	    SECONDLINE_PSB_PREFIX . 'background_color' => '',
	    SECONDLINE_PSB_PREFIX . 'text_color' => '',
	    SECONDLINE_PSB_PREFIX . 'background_color_hover' => '',
	    SECONDLINE_PSB_PREFIX . 'text_color_hover' => '',
	    SECONDLINE_PSB_PREFIX . 'repeat_subscribe' => [
	            [
		            SECONDLINE_PSB_PREFIX . 'subscribe_platform' => 'Acast',
		            SECONDLINE_PSB_PREFIX . 'subscribe_url' => 'https://',
		            SECONDLINE_PSB_PREFIX . 'custom_link_label' => 'label'
                ]
        ],
        'alignment' => 'none'
    ), $atts );

    // if an optional type attribute was provided, use it to override the configured value
    if( $type !== null ) {
    	$atts[SECONDLINE_PSB_PREFIX . 'select_type'] = $type;
    }
	
    ob_start();
    include SECONDLINE_PSB_SUBSCRIBE_ELEMENTS_PATH . 'template-parts/subscribe-button.php';
    return ob_get_clean();
}

/* Add Custom Culumns to the Post List */

add_filter('manage_edit-secondline_psb_post_columns', 'secondline_psb_subscribe_column');
function secondline_psb_subscribe_column($columns) {
    $columns['shortcode_psb'] = 'Shortcode';
    return $columns;
}

add_action('manage_posts_custom_column',  'secondline_psb_show_subscribe_column');
function secondline_psb_show_subscribe_column($name) {
    global $post;
    switch ($name) {
        case 'shortcode_psb':
            $shortcode = '[podcast_subscribe id="' . $post->ID .'"]';
            echo $shortcode;
    }
}


/* Add Shortcode Details after Post Title */
add_action( 'edit_form_after_title', 'secondline_psb_edit_form_after_title' );

function secondline_psb_edit_form_after_title() {
	global $post;
	if ( 'secondline_psb_post' == get_post_type() ) {	
		echo '<strong><p>'. esc_html__('Shortcode: ', 'secondline-psb-custom-buttons') .'</p></strong>';
		echo '<code>[podcast_subscribe id="' . $post->ID .'"]</code>';
	}
}

// Enqueue Script & Styles
function secondline_psb_button_scripts() {
    wp_enqueue_style(  'secondline-psb-subscribe-button-styles' );
    wp_enqueue_script( 'secondline_psb_button_modal_script', SECONDLINE_PSB_SUBSCRIBE_ELEMENTS_URL . 'assets/js/modal.min.js', array( 'jquery' ), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'secondline_psb_button_scripts' );


// Calling Custom Metaboxes (CMB2)
require_once SECONDLINE_PSB_SUBSCRIBE_ELEMENTS_PATH.'includes/CMB2/cmb2-init.php';

// Calling Dismiss Notices 
require_once SECONDLINE_PSB_SUBSCRIBE_ELEMENTS_PATH.'includes/dismiss-notices/dismiss-notices.php';


function secondline_psb_notice() {
	if( ! function_exists('secondline_powerpress_options') && ! function_exists('secondline_importer_init') ) {
		if ( ! PAnD::is_admin_notice_active( 'disable-done-notice-120' ) ) {
			return;
		}
		?>
		<div data-dismissible="disable-done-notice-120" class="notice notice-info is-dismissible">
			<p><?php esc_html_e( 'Boost your Podcast Website with a dedicated', 'secondline-psb-custom-buttons' ); ?> <a href="https://secondlinethemes.com/themes/?utm_source=psb-plugin-notice" target="_blank"><?php esc_html_e( 'Podcast Theme.', 'secondline-psb-custom-buttons' );?></a> <?php esc_html_e( 'Brought to you by the creators of the Podcast Subscribe Buttons plugin!', 'secondline-psb-custom-buttons' ); ?></p>
		</div>
		<?php
	}
}
add_action( 'admin_notices', 'secondline_psb_notice' );
add_action( 'admin_init', array( 'PAnD', 'init' ) );

function secondline_psb_icon_extension( $service ) {
	$icon_extension = '.png';
	if( file_exists( dirname( __FILE__ ) . '/assets/img/icons/' . $service . '.svg' ) ) {
		$icon_extension = '.svg';
	}
	return $icon_extension;
}
