<?php
/**
 * SecondLine functions and definitions
 *
 * @package secondline
 * @since secondline 1.0
 */


if ( ! defined( 'SECONDLINE_DEBUG' ) ) :
	/**
	 * Check to see if development mode is active.
	 * If set to false, the theme will load un-minified assets.
	 */
	define( 'SECONDLINE_DEBUG', false );
endif;
 

if ( ! function_exists( 'secondline_themes_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since secondline 1.0
 */
	
function secondline_themes_setup() {
	
	// Post Thumbnails - Default Image Sizes
	add_theme_support( 'post-thumbnails' );
	
	add_image_size('secondline-themes-index-single-column', 350, 325, true);
    add_image_size('secondline-themes-blog-index', 800, 500, true);
    add_image_size('secondline-themes-single-post-addon', 400, 250, true);
	add_image_size('secondline-themes-blog-post', 1400, 700, true);
	add_image_size('secondline-woocommerce-single', 600, 650, true);
	// Add uncropped image sizes
	add_image_size('secondline-themes-index-single-column-uncropped', 350, 9999, false);
	add_image_size('secondline-themes-blog-index-uncropped', 800, 9999, false);
	add_image_size('secondline-themes-single-post-uncropped', 400, 9999, false);	

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on this one, use a find and replace
	 * to change 'dixie-secondline' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'dixie-secondline', get_template_directory() . '/languages' );
	
	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio', 'quote', 'link', 'image' ) );

	
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	
	
	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'secondline-themes-primary' => esc_html__( 'Primary Menu', 'dixie-secondline' ),
		'secondline-themes-mobile-menu' => esc_html__( 'Mobile Menu', 'dixie-secondline' ),
		'secondline-themes-footer-menu' => esc_html__( 'Footer Menu', 'dixie-secondline' ),
	) );
	
	

}
endif; // secondline_themes_setup
add_action( 'after_setup_theme', 'secondline_themes_setup' );



/* Remove Default SimplePodcastPress & PodLove Player */
global $ob_wp_simplepodcastpress;
remove_filter('the_content', array($ob_wp_simplepodcastpress, 'spp_the_content'));
remove_filter( 'the_content', 'podlove_autoinsert_templates_into_content' );



/* Remove Various Splash Welcome Screens */
function secondline_themes_remove_splash_screens() { 
	delete_transient( 'elementor_activation_redirect' );
	delete_transient( 'wpforms_activation_redirect' );
}
add_action( 'init', 'secondline_themes_remove_splash_screens' );

/* Remove SSP Splash Screen */
function secondline_themes_redirect_admin_page() {
    $my_current_screen = get_current_screen();
    if (isset($my_current_screen->base) && $my_current_screen->base == 'podcast_page_upgrade') {
		$slt_redirect = ( isset( $_GET['ssp_redirect'] ) ? filter_var( $_GET['ssp_redirect'], FILTER_SANITIZE_STRING ) : '' );
		$slt_dismiss_url = add_query_arg( array( 'ssp_dismiss_upgrade' => 'dismiss', 'ssp_redirect' => rawurlencode( $slt_redirect ) ), admin_url( 'index.php' ) );	
		wp_redirect( $slt_dismiss_url );		
    }
}
add_action('current_screen', 'secondline_themes_redirect_admin_page');



/* Elementor Pro Add Header/Footer Builder Option */
function secondline_themes_register_elementor_locations( $elementor_theme_manager ) {
	$elementor_theme_manager->register_location( 'header' );
	$elementor_theme_manager->register_location( 'footer' );
}
add_action( 'elementor/theme/register_locations', 'secondline_themes_register_elementor_locations' );


/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since slt 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = esc_attr( get_theme_mod('secondline_themes_site_width', '1200') ); /* pixels */


/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since slt 1.0
 */
function secondline_themes_widgets_init() {
	register_sidebar( array(
		'name' => esc_html__( 'Sidebar', 'dixie-secondline' ),
		'description'   => esc_html__('Default sidebar', 'dixie-secondline'),
		'id' => 'secondline-themes-sidebar',
		'before_widget' => '<div id="%1$s" class="sidebar-item widget %2$s">',
		'after_widget' => '<div class="sidebar-divider-slt"></div></div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
	
	register_sidebar( array(
		'name' => esc_html__( 'Mobile/Tablet Sidebar', 'dixie-secondline' ),
		'description'   => esc_html__('Mobile/Tablet sidebar', 'dixie-secondline'),
		'id' => 'secondline-themes-mobile-sidebar',
		'before_widget' => '<div id="%1$s" class="sidebar-item widget %2$s">',
		'after_widget' => '<div class="sidebar-divider-slt"></div></div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
			
	register_sidebar( array(
		'name' => esc_html__( 'Footer Widgets', 'dixie-secondline' ),
		'description' => esc_html__( 'Footer Widgets', 'dixie-secondline' ),
		'id' => 'secondline-themes-footer-widgets',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
	
	register_sidebar( array(
		'name' => esc_html__( 'Shop Sidebar', 'dixie-secondline' ),
		'description'   => esc_html__('Sidebar on shop pages', 'dixie-secondline'),
		'id' => 'secondline-sidebar-shop',
		'before_widget' => '<div id="%1$s" class="sidebar-item widget %2$s">',
		'after_widget' => '<div class="sidebar-divider-slt"></div><div class="clearfix-slt"></div></div>',
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );	
	
	
}
add_action( 'widgets_init', 'secondline_themes_widgets_init' );




/**
 * Enqueue scripts and styles
 */
function secondline_themes_scripts() {
	
	wp_enqueue_style( 'wp-mediaelement' );
	wp_enqueue_script( 'wp-mediaelement' );
	
	wp_enqueue_style( 'secondline-style', get_stylesheet_uri());
	wp_enqueue_style( 'secondline-google-fonts', secondline_themes_fonts_url(), array( 'secondline-style' ), '1.0.0' );
	wp_enqueue_style( 'secondline-gen-icons', get_template_directory_uri() . '/inc/genericons-neue/Genericons-Neue.min.css', array( 'secondline-style' ), '1.0.0' );
	wp_add_inline_style( 'secondline-style', secondline_gutenberg_colors() );
	
	if ( SECONDLINE_DEBUG ) {
		wp_enqueue_script( 'fitvids', get_template_directory_uri() . '/js/fitvids.min.js', array( 'jquery' ), '20170801', true );
		wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/flexslider.min.js', array( 'jquery' ), '20170801', true );
		wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/isotope.min.js', array( 'jquery' ), '20170801', true );
		wp_enqueue_script( 'matchheight', get_template_directory_uri() . '/js/matchheight.min.js', array( 'jquery' ), '20170801', true );
		wp_enqueue_script( 'onepage', get_template_directory_uri() . '/js/onepage.min.js', array( 'jquery' ), '20170801', true );
		wp_enqueue_script( 'prettyphoto', get_template_directory_uri() . '/js/prettyphoto.min.js', array( 'jquery' ), '20170801', true );
		wp_enqueue_script( 'scrolltofixed', get_template_directory_uri() . '/js/scrolltofixed.min.js', array( 'jquery' ), '20170801', true );
		wp_enqueue_script( 'slimmenu', get_template_directory_uri() . '/js/slimmenu.min.js', array( 'jquery' ), '20170801', true );
		wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish.min.js', array( 'jquery' ), '20170801', true );		
	} else {
		wp_enqueue_script( 'secondline-vendors-min', get_theme_file_uri( '/js/min/vendors.min.js' ), array( 'jquery' ), '20190610', true );
	}		
	wp_enqueue_script( 'secondline-scripts', get_template_directory_uri() . '/js/secondline-script.js', array( 'jquery' ), '20170801', true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
}
add_action( 'wp_enqueue_scripts', 'secondline_themes_scripts' );



/**
 * Enqueue google fonts
 */
function secondline_themes_fonts_url() {
    $secondline_themes_font_url = '';

    /*
    Translators: If there are characters in your language that are not supported
    by chosen font(s), translate this to 'off'. Do not translate into your own language.
     */
    if ( 'off' !== _x( 'on', 'Google font: on or off', 'dixie-secondline' ) ) {
        $secondline_themes_font_url = add_query_arg( 'family', urlencode( 'Open Sans:400,600,700|Roboto:400,500,700|&subset=latin' ), "//fonts.googleapis.com/css" );
    }
	 
    return $secondline_themes_font_url;
}


/**
 * Load theme updater functions.
 * Action is used so that child themes can easily disable.
 */

function secondline_themes_theme_updater() {
    require( get_template_directory() . '/updater/theme-updater.php' );
}
add_action( 'after_setup_theme', 'secondline_themes_theme_updater' );


/**
* Add support for Gutenberg.
*
* @link https://wordpress.org/gutenberg/handbook/reference/theme-support/
*/
function secondline_themes_supported_features() {
    add_theme_support( 'editor-color-palette', array(
        array(
            'name' => esc_html__( 'White', 'dixie-secondline' ),
            'slug' => 'white',
            'color' => '#ffffff',
        ),
        array(
            'name' => esc_html__( 'Black', 'dixie-secondline' ),
            'slug' => 'black',
            'color' => '#000000',
        ),	
        array(
            'name' => esc_html__( 'Dark Gray', 'dixie-secondline' ),
            'slug' => 'dark-gray',
            'color' => '#2d2d2d',
        ),		
        array(
            'name' => esc_html__( 'Navy Blue', 'dixie-secondline' ),
            'slug' => 'navy-blue',
            'color' => '#3b5987',
        ),			
        array(
            'name' => esc_html__( 'Light Blue', 'dixie-secondline' ),
            'slug' => 'light-blue',
            'color' => '#b2c3de',
        ),	
        array(
            'name' => esc_html__( 'Main Button Background', 'dixie-secondline' ),
            'slug' => 'button-background',
            'color' => get_theme_mod('secondline_themes_button_background', '#263669', true),
        ),		
        array(
            'name' => esc_html__( 'Main Button Background Hover', 'dixie-secondline' ),
            'slug' => 'button-background-hover',
            'color' => get_theme_mod('secondline_themes_button_background_hover', '#2d2d2d', true),
        ),				
	));
	
	add_theme_support( 'align-wide' );

}

add_action( 'after_setup_theme', 'secondline_themes_supported_features' );

/**
* Enqueue editor styles for Gutenberg
*/
 
function dixie_secondline_editor_styles() {
    wp_enqueue_style( 'secondline-themes-editor-style', get_template_directory_uri() . '/css/slt-editor-style.css' );
    wp_enqueue_style( 'secondline-google-fonts-editor', secondline_themes_fonts_url(), array( 'secondline-themes-editor-style' ), '1.0.0' );
	wp_add_inline_style( 'secondline-themes-editor-style', secondline_gutenberg_editor_colors() );
}
add_action( 'enqueue_block_editor_assets', 'dixie_secondline_editor_styles' );


/**
 * Custom Block Editor Styles
 */
require get_template_directory() . '/inc/block-editor-functions.php';


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Theme Customizer
 */
require get_template_directory() . '/inc/default-customizer.php';

/**
 * JS Customizer Out
 */
require get_template_directory() . '/inc/js-customizer.php';


/**
 * Elementor Page Builder Functions
 */
require get_template_directory() . '/inc/elementor-functions.php';

/**
 * WooCommerce Functions
 */
require get_template_directory() . '/inc/woocommerce-functions.php';

/**
 * Audio Specific Functions
 */
require get_template_directory() . '/inc/audio-functions.php';



/**
 * Load Plugin TGMPA
 */
require get_template_directory() . '/inc/tgm-plugin-activation/plugin-activation.php';


/**
 * Load MerlinWP
 */
require_once get_parent_theme_file_path( '/inc/merlin/vendor/autoload.php' );
require_once get_parent_theme_file_path( '/inc/merlin/class-merlin.php' );
require_once get_parent_theme_file_path( '/inc/merlin/merlin-config.php' );
