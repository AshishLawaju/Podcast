<?php
/**
 * Easy Digital Downloads Theme Updater
 *
 * @package EDD Sample Theme
 */

// Includes the files needed for the theme updater
if ( !class_exists( 'EDD_Theme_Updater_Admin' ) ) {
	include( dirname( __FILE__ ) . '/theme-updater-admin.php' );
}

// Loads the updater classes
$updater = new EDD_Theme_Updater_Admin(

	// Config settings
	$config = array(
		'remote_api_url' => 'https://secondlinethemes.com', // Site where EDD is hosted
		'item_name'      => 'Dixie WordPress Theme', // Name of theme
		'theme_slug'     => 'dixie-secondline', // Theme slug
		'version'        => esc_attr( wp_get_theme( get_template() )->get( 'Version' ) ),
		'author'         => 'SecondLineThemes', // The author of this theme
		'download_id'    => '452', // Optional, used for generating a license renewal link
		'renew_url'      => '', // Optional, allows for a custom license renewal link
		'beta'           => false, // Optional, set to true to opt into beta versions
	),

	// Strings
	$strings = array(
		'theme-license'             => __( 'Theme License', 'dixie-secondline' ),
		'enter-key'                 => __( 'Enter your theme license key.', 'dixie-secondline' ),
		'license-key'               => __( 'License Key', 'dixie-secondline' ),
		'license-action'            => __( 'License Action', 'dixie-secondline' ),
		'deactivate-license'        => __( 'Deactivate License', 'dixie-secondline' ),
		'activate-license'          => __( 'Activate License', 'dixie-secondline' ),
		'status-unknown'            => __( 'License status is unknown.', 'dixie-secondline' ),
		'renew'                     => __( 'Renew?', 'dixie-secondline' ),
		'unlimited'                 => __( 'unlimited', 'dixie-secondline' ),
		'license-key-is-active'     => __( 'License key is active.', 'dixie-secondline' ),
		'expires%s'                 => __( 'Expires %s.', 'dixie-secondline' ),
		'expires-never'             => __( 'Lifetime License.', 'dixie-secondline' ),
		'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', 'dixie-secondline' ),
		'license-key-expired-%s'    => __( 'License key expired %s.', 'dixie-secondline' ),
		'license-key-expired'       => __( 'License key has expired.', 'dixie-secondline' ),
		'license-keys-do-not-match' => __( 'License keys do not match.', 'dixie-secondline' ),
		'license-is-inactive'       => __( 'License is inactive.', 'dixie-secondline' ),
		'license-key-is-disabled'   => __( 'License key is disabled.', 'dixie-secondline' ),
		'site-is-inactive'          => __( 'Site is inactive.', 'dixie-secondline' ),
		'license-status-unknown'    => __( 'License status is unknown.', 'dixie-secondline' ),
		'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", 'dixie-secondline' ),
		'update-available'          => __('<strong>%1$s %2$s</strong> is available. <a href="%3$s" class="thickbox" title="%4s">Check out what\'s new</a> or <a href="%5$s"%6$s>update now</a>.', 'dixie-secondline' ),
	)

);
