<?php
/**
 * Merlin WP configuration file.
 *
 * @package   Merlin WP
 * @version   @@pkg.version
 * @link      https://merlinwp.com/
 * @author    Rich Tabor, from ThemeBeans.com & the team at ProteusThemes.com
 * @copyright Copyright (c) 2018, Merlin WP of Inventionn LLC
 * @license   Licensed GPLv3 for Open Source Use
 */

if ( ! class_exists( 'Merlin' ) ) {
	return;
}

/**
 * Set directory locations, text strings, and settings.
 */
$wizard = new Merlin(

	$config = array(
		'directory'            => 'inc/merlin', // Location / directory where Merlin WP is placed in your theme.
		'merlin_url'           => 'merlin', // The wp-admin page slug where Merlin WP loads.
		'parent_slug'          => 'themes.php', // The wp-admin parent page slug for the admin menu item.
		'capability'           => 'manage_options', // The capability required for this menu to be displayed to the user.
		'child_action_btn_url' => 'https://codex.wordpress.org/child_themes', // URL for the 'child-action-link'.
		'dev_mode'             => false, // Enable development mode for testing.
		'license_step'         => true, // EDD license activation step.
		'license_required'     => false, // Require the license activation step.
		'license_help_url'     => '', // URL for the 'license-tooltip'.
		'edd_remote_api_url'   => 'https://secondlinethemes.com', // EDD_Theme_Updater_Admin remote_api_url.
		'edd_item_name'        => 'Dixie WordPress Theme', // EDD_Theme_Updater_Admin item_name.
		'edd_theme_slug'       => 'dixie-secondline', // EDD_Theme_Updater_Admin item_slug.
		'ready_big_button_url' => home_url(), // Link for the big button on the ready step.
	),
	$strings = array(
		'admin-menu'               => esc_html__( 'Theme Setup Wizard', 'dixie-secondline' ),

		/* translators: 1: Title Tag 2: Theme Name 3: Closing Title Tag */
		'title%s%s%s%s'            => esc_html__( '%1$s%2$s Themes &lsaquo; Theme Setup: %3$s%4$s', 'dixie-secondline' ),
		'return-to-dashboard'      => esc_html__( 'Return to the dashboard', 'dixie-secondline' ),
		'ignore'                   => esc_html__( 'Disable this wizard', 'dixie-secondline' ),

		'btn-skip'                 => esc_html__( 'Skip', 'dixie-secondline' ),
		'btn-next'                 => esc_html__( 'Next', 'dixie-secondline' ),
		'btn-start'                => esc_html__( 'Start', 'dixie-secondline' ),
		'btn-no'                   => esc_html__( 'Cancel', 'dixie-secondline' ),
		'btn-plugins-install'      => esc_html__( 'Install', 'dixie-secondline' ),
		'btn-child-install'        => esc_html__( 'Install', 'dixie-secondline' ),
		'btn-content-install'      => esc_html__( 'Install', 'dixie-secondline' ),
		'btn-import'               => esc_html__( 'Import', 'dixie-secondline' ),
		'btn-license-activate'     => esc_html__( 'Activate', 'dixie-secondline' ),
		'btn-license-skip'         => esc_html__( 'Skip', 'dixie-secondline' ),

		/* translators: Theme Name */
		'license-header%s'         => esc_html__( 'Activate %s', 'dixie-secondline' ),
		/* translators: Theme Name */
		'license-header-success%s' => esc_html__( '%s is Activated', 'dixie-secondline' ),
		/* translators: Theme Name */
		'license%s'                => esc_html__( 'Enter your license key to enable remote updates and theme support.', 'dixie-secondline' ),
		'license-label'            => esc_html__( 'License key', 'dixie-secondline' ),
		'license-success%s'        => esc_html__( 'The theme is already registered, so you can go to the next step!', 'dixie-secondline' ),
		'license-json-success%s'   => esc_html__( 'Your theme is activated! Remote updates and theme support are enabled.', 'dixie-secondline' ),
		'license-tooltip'          => esc_html__( 'Need help?', 'dixie-secondline' ),

		/* translators: Theme Name */
		'welcome-header%s'         => esc_html__( 'Welcome to %s', 'dixie-secondline' ),
		'welcome-header-success%s' => esc_html__( 'Hi. Welcome back', 'dixie-secondline' ),
		'welcome%s'                => esc_html__( 'This wizard will set up your theme, install plugins, and import content. It is optional & should take only a few minutes.', 'dixie-secondline' ),
		'welcome-success%s'        => esc_html__( 'You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.', 'dixie-secondline' ),

		'child-header'             => esc_html__( 'Install Child Theme', 'dixie-secondline' ),
		'child-header-success'     => esc_html__( 'You\'re good to go!', 'dixie-secondline' ),
		'child'                    => esc_html__( 'Let\'s build & activate a child theme so you may easily make theme changes.', 'dixie-secondline' ),
		'child-success%s'          => esc_html__( 'Your child theme has already been installed and is now activated, if it wasn\'t already.', 'dixie-secondline' ),
		'child-action-link'        => esc_html__( 'Learn about child themes', 'dixie-secondline' ),
		'child-json-success%s'     => esc_html__( 'Awesome. Your child theme has already been installed and is now activated.', 'dixie-secondline' ),
		'child-json-already%s'     => esc_html__( 'Awesome. Your child theme has been created and is now activated.', 'dixie-secondline' ),

		'plugins-header'           => esc_html__( 'Install Plugins', 'dixie-secondline' ),
		'plugins-header-success'   => esc_html__( 'You\'re up to speed!', 'dixie-secondline' ),
		'plugins'                  => esc_html__( 'Let\'s install some essential WordPress plugins to get your site up to speed.', 'dixie-secondline' ),
		'plugins-success%s'        => esc_html__( 'The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'dixie-secondline' ),
		'plugins-action-link'      => esc_html__( 'Advanced', 'dixie-secondline' ),

		'import-header'            => esc_html__( 'Import Content', 'dixie-secondline' ),
		'import'                   => esc_html__( 'Let\'s import content to your website, to help you get familiar with the theme. This will add the demo content to your website, so if you have existing content, you can skip this step.', 'dixie-secondline' ),
		'import-action-link'       => esc_html__( 'Advanced', 'dixie-secondline' ),

		'ready-header'             => esc_html__( 'All done. Have fun!', 'dixie-secondline' ),

		/* translators: Theme Author */
		'ready%s'                  => esc_html__( 'Your theme has been all set up. Enjoy your new theme by %s.', 'dixie-secondline' ),
		'ready-action-link'        => esc_html__( 'More Info', 'dixie-secondline' ),
		'ready-big-button'         => esc_html__( 'View your website', 'dixie-secondline' ),
		'ready-link-1'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://secondlinethemes.com/docs/dixie/', esc_html__( 'Read the Documentation', 'dixie-secondline' ) ),
		'ready-link-2'             => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'mailto:support@secondlinethemes.com', esc_html__( 'Get Theme Support', 'dixie-secondline' ) ),
		'ready-link-3'             => sprintf( '<a href="%1$s">%2$s</a>', admin_url( 'customize.php' ), esc_html__( 'Start Customizing', 'dixie-secondline' ) ),
	)
);



/**
 * Filter the blog page title from your demo content.
 * If your demo's blog page title is "Blog", you don't need this.
 *
 * @param string $output Index blogroll page title.
 */
function secondline_merlin_content_blog_page_title( $output ) {
	return 'Episode Archives';
}
add_filter( 'merlin_content_blog_page_title', 'secondline_merlin_content_blog_page_title' );

/**
 * Add your widget area to unset the default widgets from.
 * If your theme's first widget area is "sidebar-1", you don't need this.
 *
 * @see https://stackoverflow.com/questions/11757461/how-to-populate-widgets-on-sidebar-on-theme-activation
 *
 * @param  array $widget_areas Arguments for the sidebars_widgets widget areas.
 * @return array of arguments to update the sidebars_widgets option.
 */
function secondline_merlin_unset_default_widgets_args( $widget_areas ) {

	$widget_areas = array(
		'secondline-themes-sidebar' => array(),
	);

	return $widget_areas;
}
add_filter( 'merlin_unset_default_widgets_args', 'secondline_merlin_unset_default_widgets_args' );

/**
 * Custom content for the generated child theme's functions.php file.
 *
 * @param string $output Generated content.
 * @param string $slug Parent theme slug.
 */
function secondline_generate_child_functions_php( $output, $slug ) {

	$slug_no_hyphens = strtolower( preg_replace( '#[^a-zA-Z]#', '', $slug ) );

	$output = "
		<?php
		/**
		 * Theme functions and definitions.
		 */
		function {$slug_no_hyphens}_child_enqueue_styles() {

		    wp_enqueue_style( '{$slug}-style' , get_template_directory_uri() . '/style.css' );

		    wp_enqueue_style( '{$slug}-child-style',
		        get_stylesheet_directory_uri() . '/style.css',
		        array( '{$slug}-style' ),
		        wp_get_theme()->get('Version')
		    );
			
		    if ( is_rtl() ) {
		        wp_enqueue_style( '{$slug}-rtl', get_template_directory_uri() . '/rtl.css' );
		    }	
			
		}

		add_action(  'wp_enqueue_scripts', '{$slug_no_hyphens}_child_enqueue_styles' );\n
	";

	// Let's remove the tabs so that it displays nicely.
	$output = trim( preg_replace( '/\t+/', '', $output ) );

	// Filterable return.
	return $output;
}
add_filter( 'merlin_generate_child_functions_php', 'secondline_generate_child_functions_php', 10, 2 );


/**
 * Define the demo import files (local files).
 *
 * You have to use the same filter as in above example,
 * but with a slightly different array keys: local_*.
 * The values have to be absolute paths (not URLs) to your import files.
 * To use local import files, that reside in your theme folder,
 * please use the below code.
 * Note: make sure your import files are readable!
 */
function secondline_merlin_local_import_files() {
	return array(
		array(
			'import_file_name'             => 'Demo Import',
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'demo-files/content.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'demo-files/widgets.json',
			'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'demo-files/theme_option.dat',

			'import_preview_image_url'     => trailingslashit( get_template_directory() ) . 'screenshot.png',
			//'import_notice'                => esc_attr__( 'After you import this demo, you will have to setup the slider separately.', 'dixie-secondline' ),
			'preview_url'                  => 'https://dixie.secondlinethemes.com/',
		),
	);
}
add_filter( 'merlin_import_files', 'secondline_merlin_local_import_files' );

/**
 * Execute custom code after the whole import has finished.
 */
function secondline_merlin_after_import_setup() {
	// Assign menus to their locations.
	$main_menu = get_term_by( 'name', 'Main Navigation', 'nav_menu' );

	set_theme_mod(
		'nav_menu_locations', array(
			'secondline-themes-primary' => $main_menu->term_id,
		)
	);

	// Assign front page and posts page (blog page).
	$front_page_id = get_page_by_title( 'Home' );
	$blog_page_id  = get_page_by_title( 'Episode Archives' );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $front_page_id->ID );
	update_option( 'page_for_posts', $blog_page_id->ID );

}
add_action( 'merlin_after_all_import', 'secondline_merlin_after_import_setup' );