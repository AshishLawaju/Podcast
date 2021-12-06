<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://secondlinethemes.com/
 * @since      1.0.0
 *
 * @package    Podcast_Importer_Secondline
 * @subpackage Podcast_Importer_Secondline/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Podcast_Importer_Secondline
 * @subpackage Podcast_Importer_Secondline/includes
 * @author     SecondLineThemes <support@secondlinethemes.com>
 */
class Podcast_Importer_Secondline_Deactivator {

	/**
	 * Remove cron event on plugin deactivation.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		$secondline_next_scheduled = wp_next_scheduled( 'secondline_importer_cron' );
		wp_unschedule_event($secondline_next_scheduled, 'hourly', 'secondline_importer_cron');
	}

}
