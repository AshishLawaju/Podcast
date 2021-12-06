<?php

/**
 * Plugin Name:       Podcast Importer SecondLine
 * Description:       A simple podcast import plugin with ongoing podcast feed import features.
 * Version:           1.2.5
 * Author:            SecondLineThemes
 * Author URI:        https://secondlinethemes.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       podcast-importer-secondline
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 */
define( 'PODCAST_IMPORTER_SECONDLINE_VERSION', '1.2.5' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-podcast-importer-secondline-activator.php
 */
function activate_podcast_importer_secondline() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-podcast-importer-secondline-activator.php';
	Podcast_Importer_Secondline_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-podcast-importer-secondline-deactivator.php
 */
function deactivate_podcast_importer_secondline() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-podcast-importer-secondline-deactivator.php';
	Podcast_Importer_Secondline_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_podcast_importer_secondline' );
register_deactivation_hook( __FILE__, 'deactivate_podcast_importer_secondline' );


/**
* Allow iframes in generated post content
*/
function podcast_importer_secondline_allow_iframe( $tags, $context ) {
		if ( 'post' === $context ) {
			$tags['iframe'] = array(
				'src'             => true,
				'height'          => true,
				'width'           => true,
				'style'			  		=> true,
				'frameborder'     => true,
				'allowfullscreen' => true,
				'scrolling'		  	=> true,
				'seamless'		  	=> true,
			);
		}
		return $tags;
}
add_filter( 'wp_kses_allowed_html', 'podcast_importer_secondline_allow_iframe', 10, 2 );

/**
* Add oEmbed providers
*/
function podcast_importer_secondline_oembed_providers( $providers ){
	$providers['#https?://(.+).podbean.com/e/.+#i'] = array( 'https://api.podbean.com/v1/oembed', true );
	return $providers;
}
add_filter( 'oembed_providers', 'podcast_importer_secondline_oembed_providers' );


/**
 * Display dismissable admin notices
 */
if ( ! class_exists( 'PAnD' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/dismiss-notices/dismiss-notices.php';
}

function secondline_pis_notice() {
	if( ! function_exists('secondline_themes_setup') ) {
		if ( ! PAnD::is_admin_notice_active( 'disable-import-notice-120' ) ) {
			return;
		}
		?>
		<div data-dismissible="disable-import-notice-120" class="notice notice-info is-dismissible">
			<p><?php esc_html_e( 'Power up your Podcast Website with a dedicated', 'secondline-pis-custom-buttons' ); ?> <a href="https://secondlinethemes.com/themes/?utm_source=import-plugin-notice" target="_blank"><?php esc_html_e( 'Podcast Theme.', 'secondline-pis-custom-buttons' );?></a> <?php esc_html_e( 'Brought to you by the creators of the Podcast Importer plugin!', 'secondline-pis-custom-buttons' ); ?></p>
		</div>
		<?php
	}
}
add_action( 'admin_notices', 'secondline_pis_notice' );
add_action( 'admin_init', array( 'PAnD', 'init' ) );


/* Add 'Setting' link to plugins page */
function secondline_pis_add_settings_link( $links ) {
    $settings_link = '<a href="tools.php?page=secondlinepodcastimport">' . esc_attr__('Settings','secondline-pis-custom-buttons') . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'secondline_pis_add_settings_link' );


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks
 */
require plugin_dir_path( __FILE__ ) . 'class-secondline-podcast-import.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */


function run_podcast_importer_secondline() {
	$plugin = new Podcast_Importer_Secondline();
}
run_podcast_importer_secondline();
