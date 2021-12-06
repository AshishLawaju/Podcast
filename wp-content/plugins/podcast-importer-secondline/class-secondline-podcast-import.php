<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Main importer class
class Podcast_Importer_Secondline {

	public function __construct() {

		// Hook for importer cron job
		add_action( 'secondline_import_cron', array($this,'secondline_scheduled_podcast_import') );
		if( !wp_next_scheduled( 'secondline_import_cron' ) ) {
			wp_schedule_event( current_time( 'timestamp' ), 'hourly', 'secondline_import_cron' );
		}

		// Hook for adding admin menus
		if ( is_admin() ) {
			add_action( 'admin_menu', array($this,'secondline_add_page') );
			add_action( 'admin_enqueue_scripts', array($this,'secondline_admin_scripts') );
			add_action( 'admin_init', array($this,'secondline_importer_init') );
		}

	}

	// Load text domain & register custom post type
	function secondline_importer_init() {
		load_plugin_textdomain( 'secondline-podcast-importer', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

		register_post_type(
			'secondline_import',
			array(
				'labels' => array(
					'name' => esc_html__( 'Podcast Imports', 'podcast-importer-secondline' ),
					'singular_name' => esc_html__( 'Podcast Import', 'podcast-importer-secondline' )
				),
				'public' => true,
				'has_archive' => false,
				'supports' => array('title'),
				'can_export' => false,
				'exclude_from_search' => true,
				'show_in_admin_bar'   => false,
				'show_in_nav_menus'   => false,
				'publicly_queryable'  => false,
			)
		);
	}

	// Add a new menu link under Tools
	function secondline_add_page() {
		add_management_page( esc_attr__('Podcast Importer','podcast-importer-secondline'), esc_attr__('Podcast Importer','podcast-importer-secondline'), 'manage_options', 'secondlinepodcastimport', array($this,'secondline_import_front_init'));
	}

	// Load admin scripts
	function secondline_admin_scripts() {
		wp_register_style( 'secondline_admin_styles', esc_url( plugins_url( '/assets/css/admin.css', __FILE__ ) ), false, '1.0.0' );
		wp_enqueue_style( 'secondline_admin_styles' );

		wp_register_script('secondline_admin_scripts', esc_url(plugins_url('/assets/js/admin.js', __FILE__)), false, '1.0.0', true);
		wp_enqueue_script('secondline_admin_scripts');
	}

	function secondline_settings_form($post_id_to_update = false) { ?>
		<?php if ($post_id_to_update) :
			$post_meta = get_post_meta($post_id_to_update);
		endif; ?>

		<form method="POST" action="" class="secondline_import_form">
			<label for="<?php echo esc_attr($post_id_to_update); ?>_podcast_feed" class="slt-form-label"><?php echo esc_html__('Podcast Feed URL', 'podcast-importer-secondline');?></label>
			<input required="required" class="podcast_feed" id="<?php echo esc_attr($post_id_to_update); ?>_podcast_feed" type="url" name="podcast_feed" value="<?php echo esc_url(get_post_meta($post_id_to_update, 'secondline_rss_feed', true)); ?>" placeholder="https://dixie.secondlinethemes.com/feed/podcast"></input>

			<label for="<?php echo esc_attr($post_id_to_update); ?>_post_type_select" class="slt-form-label"><?php echo esc_html__('Post Type', 'podcast-importer-secondline');?></label>
			<select id="<?php echo esc_attr($post_id_to_update); ?>_post_type_select" name="post_type_select" class="post_type_select">
				<?php $this->secondline_post_type_control(get_post_meta($post_id_to_update, 'secondline_import_post_type', true));?>
			</select>

			<div class="clearfaix-slt"></div>

			<label for="<?php echo esc_attr($post_id_to_update); ?>_publish_option_select" class="slt-form-label"><?php echo esc_html__('Post Status', 'podcast-importer-secondline');?></label>
			<select id="<?php echo esc_attr($post_id_to_update); ?>_publish_option_select" name="publish_option_select">
				<?php $secondline_import_publish = get_post_meta($post_id_to_update, 'secondline_import_publish', true); ?>
				<option <?php echo $secondline_import_publish === 'publish' ? ' selected' : ''; ?> value="publish"><?php echo esc_html__('Publish', 'podcast-importer-secondline')?></option>
				<option <?php echo $secondline_import_publish === 'draft' ? ' selected' : ''; ?> value="draft"><?php echo esc_html__('Save as Draft', 'podcast-importer-secondline')?></option>
			</select>

			<div class="clearfix-slt"></div>

			<label for="<?php echo esc_attr($post_id_to_update); ?>_secondline_import_author" class="slt-form-label"><?php echo esc_html__('Post Author', 'podcast-importer-secondline');?></label>

			<?php wp_dropdown_users( array(
				'name' => 'secondline_import_author',
				'selected' => get_post_meta($post_id_to_update, 'secondline_import_author', true)
			) );?>

			<div class="clearfix-slt"></div>

			<label for="<?php echo esc_attr($post_id_to_update); ?>_post_category_select" class="slt-form-label"><?php echo esc_html__('Post Category (or Categories)', 'podcast-importer-secondline');?></label>
			<select id="<?php echo esc_attr($post_id_to_update); ?>_post_category_select" name="post_category_select[]" multiple="multiple">
				<?php $this->secondline_list_categories(get_post_meta($post_id_to_update, 'secondline_import_category', true));?>
			</select>

			<div class="clearfix-slt"></div>

			<?php if(function_exists('tusant_secondline_theme_active') || function_exists('bolden_secondline_theme_active')) : ?>
				<label for="<?php echo esc_attr($post_id_to_update); ?>_secondline_parent_show" class="slt-form-label"><?php echo esc_html__('Parent Show Post', 'podcast-importer-secondline');?></label>
				<select id="<?php echo esc_attr($post_id_to_update); ?>_secondline_parent_show" name="secondline_parent_show">
					<?php $this->secondline_list_shows();?>
				</select>

				<div class="clearfix-slt"></div>
			<?php endif;?>

			<?php if (!$post_id_to_update) : ?>
				<div class="slt-checkbox-container">
					<input type="checkbox" id="<?php echo esc_attr($post_id_to_update); ?>_secondline_continuous_import" name="secondline_continuous_import" />
					<label for="<?php echo esc_attr($post_id_to_update); ?>_secondline_continuous_import"><?php echo esc_html__('Ongoing Import (Enable to continuously import future episodes)', 'podcast-importer-secondline')?></label>
				</div>
			<?php endif; ?>

			<div class="slt-checkbox-container">
				<?php $secondline_import_images = get_post_meta($post_id_to_update, 'secondline_import_images', true); ?>

				<input <?php echo $secondline_import_images === 'on' ? ' checked' : ''; ?> type="checkbox" id="<?php echo esc_attr($post_id_to_update); ?>_secondline_import_images" name="secondline_import_images" />
				<label for="<?php echo esc_attr($post_id_to_update); ?>_secondline_import_images"><?php echo esc_html__('Import Episode Featured Images', 'podcast-importer-secondline')?></label>
			</div>


			<div class="slt-checkbox-container">
				<?php $secondline_import_embed_player = get_post_meta($post_id_to_update, 'secondline_import_embed_player', true); ?>

				<input <?php echo $secondline_import_embed_player === 'on' ? ' checked' : ''; ?> type="checkbox" id="<?php echo esc_attr($post_id_to_update); ?>_secondline_import_embed_player" name="secondline_import_embed_player" />
				<label for="<?php echo esc_attr($post_id_to_update); ?>_secondline_import_embed_player"><?php echo esc_html__('Use an embed audio player instead of the default WordPress player (depending on your podcast host)', 'podcast-importer-secondline')?></label>
			</div>

			<div class="settings-wrapper">
				<h3 class="slt-importer-header advanced-options" ><?php echo esc_html__('Advanced Options', 'podcast-importer-secondline' );?></h3>
				<div class="advanced-settings-wrapper">
					<label for="<?php echo esc_attr($post_id_to_update); ?>_secondline_content_tag" class="slt-form-label"><?php echo esc_html__('Imported Content Tag', 'podcast-importer-secondline');?></label>
					<select id="<?php echo esc_attr($post_id_to_update); ?>_secondline_content_tag" name="secondline_content_tag">
						<?php $secondline_content_tag = get_post_meta($post_id_to_update, 'secondline_content_tag', true); ?>
						<option value="select"><?php echo esc_html__('Select Option', 'podcast-importer-secondline')?></option>
						<option <?php echo $secondline_content_tag === 'content:encoded' ? ' selected' : ''; ?> value="content:encoded"><?php echo esc_html__('content:encoded', 'podcast-importer-secondline')?></option>
						<option <?php echo $secondline_content_tag === 'description' ? ' selected' : ''; ?> value="description"><?php echo esc_html__('description', 'podcast-importer-secondline')?></option>
						<option <?php echo $secondline_content_tag === 'itunes:summary' ? ' selected' : ''; ?> value="itunes:summary"><?php echo esc_html__('itunes:summary', 'podcast-importer-secondline')?></option>
					</select>

					<label for="<?php echo esc_attr($post_id_to_update); ?>_secondline_truncate_post" class="slt-form-label">
						<?php echo esc_html__('Truncate Post Content', 'podcast-importer-secondline');?><br>
						<em>Optional: Will trim the post content when imported to the character amount below.</em>
					</label>
					<input id="<?php echo esc_attr($post_id_to_update); ?>_secondline_truncate_post" type="number" name="secondline_truncate_post" value="<?php echo esc_attr(get_post_meta($post_id_to_update, 'secondline_truncate_post', true)); ?>"></input>

					<div class="slt-checkbox-container">
						<?php $secondline_import_episode_number = get_post_meta($post_id_to_update, 'secondline_import_episode_number', true); ?>
						<input <?php echo $secondline_import_episode_number === 'on' ? ' checked' : ''; ?> type="checkbox" id="<?php echo esc_attr($post_id_to_update); ?>_secondline_import_episode_number" name="secondline_import_episode_number" />
						<label for="<?php echo esc_attr($post_id_to_update); ?>_secondline_import_episode_number"><?php echo esc_html__('Append Episode Number to Post Title', 'podcast-importer-secondline')?></label>
					</div>

					<label for="<?php echo esc_attr($post_id_to_update); ?>_secondline_prepend_title" class="slt-form-label">
						<?php echo esc_html__('Prepend Title', 'podcast-importer-secondline');?><br>
						<em>Optional: Add <code>[podcast_title]</code> to display the show name.</em>
					</label>
					<input type="text" id="<?php echo esc_attr($post_id_to_update); ?>_secondline_prepend_title" name="secondline_prepend_title" placeholder="Ex: My Podcast" value="<?php echo esc_attr(get_post_meta($post_id_to_update, 'secondline_prepend_title', true)); ?>"></input>
				</div>
			</div>

			<div class="clearfix-slt"></div>

			<input type="hidden" name="action" value="secondline_import_initialize" />

			<?php if ($post_id_to_update) : ?>
				<input type="hidden" name="post_id" value="<?php echo esc_attr($post_id_to_update); ?>" />

				<input class="button button-primary" type="submit" name="update" value="Update" />
			<?php else : ?>
				<input class="button button-primary" type="submit" name="submit" value="Import Podcast" />
			<?php endif; ?>

			<?php wp_nonce_field( 'seconline_importer_form', 'secondline_form_nonce' ); ?>
		</form>
	<?php }

	// Main plugin page within the WordPress admin panel
	function secondline_import_front_init() {
		?>
		<div class="slt-plugin-container">
			<div id="slt-form-container">
				<h2 class="slt-importer-header">
					<?php echo esc_html__('Import a Podcast', 'podcast-importer-secondline' );?>
					<?php if(!function_exists('secondline_themes_setup')) :?>
						<em class="slt-notice">
							<a href="https://secondlinethemes.com/?utm_source=import-title-notice" target="_blank">
							<?php echo esc_html__('Powered by SecondLineThemes - WP Podcast Themes', 'podcast-importer-secondline' );?>
							</a>
						</em>
					<?php endif;?>
				</h2>

				<?php
				if(isset($_POST['update'])) :
					$post_id = sanitize_text_field($_POST['post_id']);
					$this->secondline_podcast_update($post_id);
				endif;

				if(!isset($_POST['submit'])) :
					$this->secondline_settings_form();
				else :
					if(isset($this)) {
						$this->secondline_podcast_import();
					}
				endif;
				?>
			</div>

		</div>


		<?php

			// Create section for existing import processes
			global $blogloop;
			global $post;
			$args = array(
				'post_type'    		=> 'secondline_import',
				'posts_per_page'	=>  99,
			);

			$blogloop = new \WP_Query( $args );
			if ($blogloop->have_posts()) :

		?>

			<div class="slt-plugin-container existing-import-container">
				<h2 class="slt-importer-header"><?php echo esc_html__('Scheduled Imports', 'podcast-importer-secondline' );?></h2>
				<span class="slt-importer-notice"><?php echo esc_html__('Scheduled imports automatically sync once every hour.', 'podcast-importer-secondline' );?></span>
				<ul>
					<?php while($blogloop->have_posts()): $blogloop->the_post();?>
						<li>
							<span class="import-process-item">
								<strong><?php the_title();?></strong> - <?php echo get_post_meta($post->ID, 'secondline_rss_feed', true);?>
							</span>

							<span class="delete-button">
								<a href="<?php echo get_delete_post_link( $post->ID, '', true );?>" class="button button-link-delete">
									<?php echo esc_html__('Delete Import', 'podcast-importer-secondline' );?>
								</a>
							</span>

							<button data-import-id="<?php echo esc_attr($post->ID); ?>" class="button button-link-edit">
								Edit Import
							</button>

							<div id="edit-import-form--<?php echo esc_attr($post->ID); ?>" class="edit-import-form">
								<?php $this->secondline_settings_form($post->ID); ?>
							</div>

							<div class="clearfix-slt"></div>
						</li>
					<?php endwhile;?>
				</ul>
			</div>
		<?php endif;?>
		<?php
	}

	function secondline_podcast_update($post_id_to_update) {
		if(!isset($_POST['podcast_feed']) || $_POST['podcast_feed'] == '' ) {
			echo "Must define podcast feed.";
			return false;
		}

		if (isset($_POST['podcast_feed'])) {
			$secondline_rss_feed_url = sanitize_text_field($_POST['podcast_feed']);

			update_post_meta($post_id_to_update, 'secondline_rss_feed', $secondline_rss_feed_url);
		}

		if (isset($_POST['post_type_select'])) {
			$secondline_import_post_type = sanitize_text_field($_POST['post_type_select']);

			update_post_meta($post_id_to_update, 'secondline_import_post_type', $secondline_import_post_type);
		}

		if (isset($_POST['publish_option_select'])) {
			$secondline_import_publish = sanitize_text_field($_POST['publish_option_select']);

			update_post_meta($post_id_to_update, 'secondline_import_publish', $secondline_import_publish);
		}
		if (isset($_POST['post_category_select'])) {
			$secondline_import_category = array_map(null, $_POST['post_category_select']);

			update_post_meta($post_id_to_update, 'secondline_import_category', $secondline_import_category);
		}

		if (isset($_POST['secondline_parent_show'])) {
			$secondline_parent_show = sanitize_text_field($_POST['secondline_parent_show']);

			update_post_meta($post_id_to_update, 'secondline_parent_show', $secondline_parent_show);
		}

		if (isset($_POST['secondline_import_author'])) {
			$secondline_import_author = sanitize_text_field($_POST['secondline_import_author']);

			update_post_meta($post_id_to_update, 'secondline_import_author', $secondline_import_author);
		}

		if (isset($_POST['secondline_continuous_import'])) {
			$secondline_import_continuous = sanitize_text_field($_POST['secondline_continuous_import']);

			update_post_meta($post_id_to_update, 'secondline_import_continuous', $secondline_import_continuous);
		}

		if (isset($_POST['secondline_import_images'])) {
			$secondline_import_images = sanitize_text_field($_POST['secondline_import_images']);

			update_post_meta($post_id_to_update, 'secondline_import_images', $secondline_import_images);
		}

		if (isset($_POST['secondline_import_episode_number'])) {
			$secondline_import_episode_number = sanitize_text_field($_POST['secondline_import_episode_number']);

			update_post_meta($post_id_to_update, 'secondline_import_episode_number', $secondline_import_episode_number);
		}

		if (isset($_POST['secondline_import_embed_player'])) {
			$secondline_import_embed_player = sanitize_text_field($_POST['secondline_import_embed_player']);

			update_post_meta($post_id_to_update, 'secondline_import_embed_player', $secondline_import_embed_player);
		}

		if (isset($_POST['secondline_content_tag'])) {
			$secondline_content_tag = sanitize_text_field($_POST['secondline_content_tag']);

			update_post_meta($post_id_to_update, 'secondline_content_tag', $secondline_content_tag);
		}

		if (isset($_POST['secondline_truncate_post'])) {
			$secondline_truncate_post = sanitize_text_field($_POST['secondline_truncate_post']);

			update_post_meta($post_id_to_update, 'secondline_truncate_post', $secondline_truncate_post);
		}

		if (isset($_POST['secondline_prepend_title'])) {
			$secondline_prepend_title = sanitize_text_field($_POST['secondline_prepend_title']);

			update_post_meta($post_id_to_update, 'secondline_prepend_title', $secondline_prepend_title);
		}
	}

	// Main import function
	function secondline_podcast_import() {

		// Check nonce and user capabilities
		if((check_admin_referer( 'seconline_importer_form', 'secondline_form_nonce' ) == true) && (current_user_can('editor') || current_user_can('administrator')) ) {

			$posts_added_count = 0;

			// Increase the time limit
			set_time_limit(360);

			// Require relevant WordPress core files for processing images
			require_once(ABSPATH . 'wp-admin/includes/media.php');
			require_once(ABSPATH . 'wp-admin/includes/file.php');
			require_once(ABSPATH . 'wp-admin/includes/image.php');

			// Parse the RSS/XML feed
			$secondline_rss_feed = '';
			$secondline_import_post_type = 'post'; 		// default
			$secondline_import_publish = 'publish'; 	// default
			$secondline_import_author = 'admin'; 		// default
			$secondline_import_category = ''; 		// default
			$secondline_import_continuous = 'off'; 		// default
			$secondline_import_images = 'off'; 			// default
			$secondline_import_episode_number = 'off';  // default
			$secondline_content_tag = 'content:encoded'; // default
			$secondline_truncate_post = false; // default
			$secondline_prepend_title = ''; // default
			$secondline_import_embed_player = 'off'; 	// default

			if(isset($_POST['podcast_feed']) && $_POST['podcast_feed'] != '' ) {
				$secondline_rss_feed_url = esc_url( $_POST['podcast_feed'], array( 'http', 'https') );
				$secondline_rss_feed = @simplexml_load_file($secondline_rss_feed_url);
				if(empty($secondline_rss_feed) && !empty($secondline_rss_feed_url)) {

					$ch = curl_init($secondline_rss_feed_url);

					curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');

					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					$result = curl_exec($ch);
					if(substr($result, 0, 5) == "<?xml") {
						$secondline_rss_feed = simplexml_load_string($result);
					} else {
						// Feed is not valid, continue and display error below.
					}
					curl_close($ch);

				}
			}
			if(isset($_POST['post_type_select'])) {
				$secondline_import_post_type = sanitize_text_field($_POST['post_type_select']);
			}
			if(isset($_POST['publish_option_select'])) {
				$secondline_import_publish = sanitize_text_field($_POST['publish_option_select']);
			}
			if(isset($_POST['post_category_select'])) {
				$secondline_import_category = array_map(null, $_POST['post_category_select']);
			}
			if(isset($_POST['secondline_parent_show'])) {
				$secondline_parent_show = sanitize_text_field($_POST['secondline_parent_show']);
			}
			if(isset($_POST['secondline_import_author'])) {
				$secondline_import_author = sanitize_text_field($_POST['secondline_import_author']);
			}
			if(isset($_POST['secondline_continuous_import'])) {
				$secondline_import_continuous = sanitize_text_field($_POST['secondline_continuous_import']);
			}
			if(isset($_POST['secondline_import_images'])) {
				$secondline_import_images = sanitize_text_field($_POST['secondline_import_images']);
			}
			if(isset($_POST['secondline_import_episode_number'])) {
				$secondline_import_episode_number = sanitize_text_field($_POST['secondline_import_episode_number']);
			}
			if(isset($_POST['secondline_import_embed_player'])) {
				$secondline_import_embed_player = sanitize_text_field($_POST['secondline_import_embed_player']);
			}
			if (isset($_POST['secondline_content_tag'])) {
				$secondline_content_tag = sanitize_text_field($_POST['secondline_content_tag']);
			}
			if (isset($_POST['secondline_truncate_post'])) {
				$secondline_truncate_post = sanitize_text_field($_POST['secondline_truncate_post']);
			}
			if (isset($_POST['secondline_prepend_title'])) {
				$secondline_prepend_title = sanitize_text_field($_POST['secondline_prepend_title']);
			}

			// Set up a new post per item that appears in the feed
			if( !empty( $secondline_rss_feed ) ) {

				$episode_count = count( $secondline_rss_feed->channel->item );

				for ( $i = 0; $i < $episode_count; $i ++ ) {

					$item 		 	= $secondline_rss_feed->channel->item[ $i ];
					$itunes      	= $item->children( 'http://www.itunes.com/dtds/podcast-1.0.dtd' );
					$guid		 	= $this->secondline_sanitize_data($item->guid);
					$episode_number = $this->secondline_sanitize_data($itunes->episode);
					$season_number  = $this->secondline_sanitize_data($itunes->season);

					// Get episode duration (in seconds or text) and file size (in bytes)
					$filesize	 = 0; // default value
					$filesize	 = $item->enclosure['length'];
					$filesize 	 = '' . number_format($filesize / 1048576, 2) . 'M';
					$duration 	 = $this->secondline_sanitize_data($itunes->duration);
					if ((!empty($duration)) && (strpos($duration, ':') !== false))
						$duration = $duration;
					elseif(!empty($duration)) {
						$duration = gmdate("H:i:s", $duration);
					} else {
						$duration = '';
					}

					// Ensure posts are published right away (for server/feed timezone conflicts)
					if ( strtotime( (string) $item->pubDate ) < current_time('timestamp') ) {
						$timestamp_post_date = strtotime( (string) $item->pubDate );
					} else {
						$timestamp_post_date = current_time('timestamp');
					}

					$post_date = date( 'Y-m-d H:i:s', $timestamp_post_date );

					if( ($secondline_import_episode_number == 'on') && ($this->secondline_sanitize_data($itunes->episode) != '') ) {
						$post_title  = $this->secondline_sanitize_data($itunes->episode) . ': ' . $this->secondline_sanitize_data($item->title);
					} else {
						$post_title  = $this->secondline_sanitize_data($item->title);
					}

					if (isset($secondline_prepend_title)) {
						$secondline_prepend_title = str_replace('[podcast_title]', $this->secondline_sanitize_data($secondline_rss_feed->channel->title), $secondline_prepend_title);

						$post_title = $secondline_prepend_title . ' ' . $post_title;
					}

					// Set up audio as a shortcode and remove query variables
					$audio_url 	 = (string) $item->enclosure['url'];
					$audio_url 	 = preg_replace( '/(?s:.*)(https?:\/\/(?:[\w\-\.]+[^#?\s]+)(?:\.mp3))(?s:.*)/', '$1', $audio_url );
					$audio_url 	 = preg_replace( '/(?s:.*)(https?:\/\/(?:[\w\-\.]+[^#?\s]+)(?:\.m4a))(?s:.*)/', '$1', $audio_url );
					$feed_link_url = (string) $item->link;
					$secondline_host_checker = false;
					$secondline_match_image_filenames = $this->secondline_match_image_names($secondline_rss_feed_url);
					if(!empty($feed_link_url)) {
						$parsed_feed_url = parse_url($feed_link_url);
						$parsed_feed_host = $parsed_feed_url['host'];
					} else {
						$parsed_feed_host = '';
					}

					if(($secondline_import_embed_player == 'on') && (isset($parsed_feed_host) || isset($secondline_rss_feed_url))) {
						if (preg_match('/fireside.fm/i', $secondline_rss_feed_url)) {
							$feed_link_url = (string) $item->children('fireside', true)->playerEmbedCode;
						}
						if (preg_match('/omny.fm/i', $secondline_rss_feed_url) || preg_match('/omnycontent.com/i', $secondline_rss_feed_url)) {
							$feed_link_url = (string) $item->children('media', true)->content->children('media', true)->player->attributes()->url;
						}
						if (preg_match('/libsyn.com/i', $secondline_rss_feed_url) || preg_match('/omnycontent.com/i', $secondline_rss_feed_url)) {
							$feed_link_url = (string) $item->children('libsyn', true)->itemId;
						}						
						$secondline_audio_shortcode = $this->secondline_embed_validator($parsed_feed_host, $feed_link_url, $audio_url, $secondline_rss_feed_url, $guid);
						$secondline_host_checker = $this->secondline_embed_host_checker($parsed_feed_host, $secondline_rss_feed_url);
					} else {
						$secondline_audio_shortcode = '[audio src="' . esc_url($audio_url) . '"][/audio]';
					}

					// Grab the content
					if (!empty($item->children('itunes', true)->summary) && $secondline_content_tag === 'itunes:summary') {
						$secondline_parsed_content = $this->secondline_sanitize_data($item->children('itunes', true)->summary);
					} elseif(!empty($item->children('itunes', true)->encoded) && $secondline_content_tag === 'content:encoded') {
						$secondline_parsed_content = $this->secondline_sanitize_data($item->children('content', true)->encoded);
					} elseif(!empty($item->description) && $secondline_content_tag === 'description') {
						$secondline_parsed_content = $this->secondline_sanitize_data($item->description);
					// If no preference cuts the mustard, try all the defaults
					} elseif(!empty($item->children('content', true)->encoded)) {
						$secondline_parsed_content = $this->secondline_sanitize_data($item->children('content', true)->encoded);
					} elseif (!empty($item->description)) {
						$secondline_parsed_content = $this->secondline_sanitize_data($item->description);
					} else {
						$secondline_parsed_content = $this->secondline_sanitize_data($itunes->summary);
					}

					if ($secondline_truncate_post) {
						$secondline_parsed_content = substr($secondline_parsed_content, 0, intval($secondline_truncate_post));
					}

					// If none of the popular plugins/themes are available, append the audio shortcode to the post content
					if(!function_exists('ssp_episodes') && !function_exists('powerpress_get_enclosure_data') && !function_exists('spp_sl_sppress_plugin_updater') && !function_exists('secondline_themes_theme_updater') ) {
						$secondline_post_content = $secondline_audio_shortcode . $secondline_parsed_content;
					} else {
						$secondline_post_content = $secondline_parsed_content;
					}


					// Create post data
					$post = array(
						'post_author'  => $secondline_import_author,
						'post_content' => $secondline_post_content,
						'post_date'    => $post_date,
						'post_excerpt' => $this->secondline_sanitize_data($itunes->subtitle),
						'post_status'  => $secondline_import_publish,
						'post_type'    => $secondline_import_post_type,
						'post_title'   => $post_title,
					);


					// Create the post
					global $wpdb;
					$post_id;
					// Check if post already exists, if so - skip. First we'll look for the GUID, then at the title.
					if(!empty($guid) && $guid != '') {
						$query = "SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE (meta_key = 'secondline_imported_guid' AND meta_value LIKE '%$guid%')";
						$guid_count = intval($wpdb->get_var($query));
					} else {
						$guid_count = 0;
					}
					if($guid_count == 0) {

						if( 0 === post_exists( $post_title, "", "", $secondline_import_post_type )) {

							$post_id = wp_insert_post( $post );

							// Continue if the import generate errors
							if ( is_wp_error( $post_id ) ) {
								continue;
							}

							// Add GUID for each post
							add_post_meta( $post_id, 'secondline_imported_guid', $guid, true );

							// Import Episode Number and Season Number
							if ( function_exists('secondline_themes_theme_updater')) {
								if (isset($episode_number) && $episode_number !== '') {
									add_post_meta( $post_id, 'secondline_themes_episode_number', $episode_number, true );
								}
								if (isset($season_number) && $season_number !== '') {
									add_post_meta( $post_id, 'secondline_themes_season_number', $season_number, true );
								}
							}

							// Add embed audio player into the SecondLineThemes custom field
							if ($secondline_import_embed_player == 'on' && $secondline_host_checker && function_exists('secondline_themes_theme_updater')) {
								add_post_meta( $post_id, 'secondline_themes_external_embed', $secondline_audio_shortcode, true );
							} else {

								// Custom Field - Seriously Simple Podcsating
								if (function_exists('ssp_episodes')) {
									add_post_meta( $post_id, 'audio_file', $audio_url, true );
									add_post_meta( $post_id, 'duration', $duration, true );
									add_post_meta( $post_id, 'filesize', $filesize, true );
								}
								// Custom Field - PowerPress
								if ( function_exists('powerpress_get_enclosure_data')) {
									add_post_meta($post_id, 'enclosure', $audio_url, true );
								}
								// Custom Field - Simple Podcast Press
								if ( function_exists('spp_sl_sppress_plugin_updater') ) {
									add_post_meta( $post_id, '_audiourl', $audio_url, true );
								}
								// Custom Field - SecondLineThemes
								if ( function_exists('secondline_themes_theme_updater') && (!function_exists('powerpress_get_enclosure_data') && !function_exists('ssp_episodes') && !function_exists('spp_sl_sppress_plugin_updater'))) {
									add_post_meta( $post_id, 'secondline_themes_external_embed', $secondline_audio_shortcode, true );
								}
							}

							// Add episode categories
							if( !empty($secondline_import_category) ) {
								if( $secondline_import_post_type == 'podcast' ) {
									wp_set_post_terms( $post_id, $secondline_import_category, 'series', false );
								} else {
									wp_set_post_terms( $post_id, $secondline_import_category, 'category', false );
								}
							}

							// Add Parent Show Post
							if( isset($secondline_parent_show) && $secondline_parent_show != "") {
								add_post_meta( $post_id, 'secondline_themes_parent_show_post', $secondline_parent_show, true );
							}

							// Add episode image
							 if (isset($itunes) && isset($item)) { // Check again that feed is not empty
								if( $secondline_import_images == 'on' ) {

									// Grab image URL and file name
									if($itunes && $itunes->image && $itunes->image->attributes() && $itunes->image->attributes()->href) {

										$filename = basename(parse_url($itunes->image->attributes()->href)['path']);
										$filename = (string) $filename;

										// Check if image does not exist in the database and upload it. Otherwise attach the existing image to the post
										$query = "SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE meta_value LIKE '%$filename%'";
										$filename_count = intval($wpdb->get_var($query));

										if($filename_count == 0 || $secondline_match_image_filenames == false) {
											$img_to_import = (string) $itunes->image->attributes()->href;
											if(!post_exists( $post_title, '', '', 'attachment' ) || $secondline_match_image_filenames == false) {
												$attachment = get_page_by_title( $post_title, OBJECT, 'attachment');
												if( empty( $attachment ) || $secondline_match_image_filenames == false ) {
													add_action('add_attachment',array($this,'secondline_import_itunes_image'));
													media_sideload_image($img_to_import, $post_id, $item->title);
													remove_action('add_attachment',array($this,'secondline_import_itunes_image'));
												}
											}
										} else {
											$get_upload_dir = wp_upload_dir()['baseurl'] . '/';
											$filename = pathinfo($filename, PATHINFO_FILENAME); // returns $filename with no extension
											$query_path_to_file = "SELECT meta_value FROM {$wpdb->postmeta} WHERE (meta_key = '_wp_attached_file' AND meta_value LIKE '%$filename%')";
											$filename_path = $wpdb->get_var($query_path_to_file);
											$filename_path = str_replace('-scaled', '', $filename_path);
											$image_src = $get_upload_dir . $filename_path;
											$image_id = $this->secondline_get_image_id($image_src);
											set_post_thumbnail($post_id, $image_id);
										}
									}
								}
							}

							do_action( 'secondline_after_post_import', $post_id, $secondline_rss_feed, $item );

							$posts_added_count ++; // Count successfully imported episodes

						}
					}
				}

				// Return success/error messages
				if($posts_added_count == 0 && $episode_count != 0) { // No episodes imported due to duplicated titles.
					echo esc_html__('No new episodes imported, all episodes already existing in WordPress!', 'podcast-importer-secondline');
					echo '<br><br><span class="slt-existing-post-notice">' . esc_html__('If you have existing draft, private or trashed posts with the same title as your episodes, delete those and run the importer again', 'podcast-importer-secondline') . '</span>';
				} elseif ($episode_count == 0) { // No episodes existing within feed.
					echo esc_html__('Error! Your feed does not contain any episodes.', 'podcast-importer-secondline');
				} else {
					echo '<strong>' . esc_html__('Success! Imported ', 'podcast-importer-secondline') . $posts_added_count . esc_html__(' out of ', 'podcast-importer-secondline') . $episode_count . esc_html__(' episodes', 'podcast-importer-secondline') . '</strong>' ;
				}

				// Check if scheduled import checked and already exists
				if( $secondline_import_continuous == 'on' ) {
					if( 0 === post_exists( $this->secondline_sanitize_data($secondline_rss_feed->channel->title), "", "", 'secondline_import' )) {
						// Create new entry for the scheduled/ongoing import.
						$import_post = array(
							'post_title'   => $this->secondline_sanitize_data($secondline_rss_feed->channel->title),
							'post_type'    => 'secondline_import',
							'post_status'  => 'publish',
						);
						$post_import_id = wp_insert_post( $import_post );
						add_post_meta( $post_import_id, 'secondline_rss_feed', $secondline_rss_feed_url, true );
						add_post_meta( $post_import_id, 'secondline_import_post_type', $secondline_import_post_type, true );
						add_post_meta( $post_import_id, 'secondline_import_publish', $secondline_import_publish, true );
						add_post_meta( $post_import_id, 'secondline_import_category', $secondline_import_category, true );
						add_post_meta( $post_import_id, 'secondline_import_images', $secondline_import_images, true );
						add_post_meta( $post_import_id, 'secondline_import_episode_number', $secondline_import_episode_number, true );
						add_post_meta( $post_import_id, 'secondline_import_author', $secondline_import_author, true );
						add_post_meta( $post_import_id, 'secondline_import_embed_player', $secondline_import_embed_player, true );
						add_post_meta($post_import_id, 'secondline_content_tag', $secondline_content_tag, true);
						add_post_meta($post_import_id, 'secondline_truncate_post', $secondline_truncate_post, true);
						add_post_meta($post_import_id, 'secondline_prepend_title', $secondline_prepend_title, true);

					} else {
						echo '<br><br>' . esc_html__('This podcast is already being scheduled for import. Delete the previous schedule to create a new one.', 'podcast-importer-secondline' ) . '<br><br>';
					}

					// Set up cron job for imports
					add_action('secondline_import_cron', array($this,'secondline_scheduled_podcast_import'));

					if( !wp_next_scheduled( 'secondline_import_cron' ) ) {
						wp_schedule_event( current_time( 'timestamp' ), 'hourly', 'secondline_import_cron' );
					}
				}
			} else {
				echo '<strong>' . esc_html__('Podcast Feed Error! Please use a valid RSS feed URL.', 'podcast-importer-secondline') . '</strong>';
			}
		}
	}


	function secondline_scheduled_podcast_import() {

		// Load post.php class for post manipulations during cron
		if ( ( ! is_admin() ) || ( ! function_exists( 'post_exists' ) ) ) {
			require_once( ABSPATH . 'wp-admin/includes/post.php' );
		}

		// Increase the time limit
		set_time_limit(360);

		// Require relevant WordPress core files for processing images
		require_once(ABSPATH . 'wp-admin/includes/media.php');
		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/image.php');

		// Query all existing shceduled imports
		global $wpdb;
		global $blogloop;
		global $post;
		$args = array(
			'post_type'    		=> 'secondline_import',
			'post_status' 		=> 'publish',
			'posts_per_page'	=>  999,
		);

		$blogloop = new \WP_Query( $args );

		if ($blogloop->have_posts()) {

			while($blogloop->have_posts()) {

				$blogloop->the_post();

				// Grab pre-saved vars per post
				$secondline_rss_feed_url = get_post_meta($post->ID, 'secondline_rss_feed', true);
				$secondline_import_post_type = get_post_meta($post->ID, 'secondline_import_post_type', true);
				$secondline_import_publish = get_post_meta($post->ID, 'secondline_import_publish', true);
				$secondline_import_category = get_post_meta($post->ID, 'secondline_import_category', true);
				$secondline_parent_show = get_post_meta($post->ID, 'secondline_parent_show', true);
				$secondline_import_images = get_post_meta($post->ID, 'secondline_import_images', true);
				$secondline_import_episode_number = get_post_meta($post->ID, 'secondline_import_episode_number', true);
				$secondline_import_author = get_post_meta($post->ID, 'secondline_import_author', true);
				$secondline_import_embed_player = get_post_meta($post->ID, 'secondline_import_embed_player', true);
				$secondline_content_tag = get_post_meta($post->ID, 'secondline_content_tag', true);
				$secondline_truncate_post = get_post_meta($post->ID, 'secondline_truncate_post', true);
				$secondline_prepend_title = get_post_meta($post->ID, 'secondline_prepend_title', true);

				$secondline_rss_feed = @simplexml_load_file($secondline_rss_feed_url);
				if(empty($secondline_rss_feed) && !empty($secondline_rss_feed_url)) {

					$ch = curl_init($secondline_rss_feed_url);

					curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0');

					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					$result = curl_exec($ch);
					if(substr($result, 0, 5) == "<?xml") {
						$secondline_rss_feed = simplexml_load_string($result);
					} else {
						// Feed is not valid, continue and display error below.
					}
					curl_close($ch);

				}

				// Parse the RSS/XML feed
				if(!empty($secondline_rss_feed)) {

					$episode_count = count( $secondline_rss_feed->channel->item );

					for ( $i = 0; $i < $episode_count; $i ++ ) {

						$item = $secondline_rss_feed->channel->item[ $i ];
						$itunes     	 = $item->children( 'http://www.itunes.com/dtds/podcast-1.0.dtd' );
						$post_author 	 = $secondline_import_author;
						$guid			 = $this->secondline_sanitize_data($item->guid);
						$episode_number  = $this->secondline_sanitize_data($itunes->episode);
						$season_number   = $this->secondline_sanitize_data($itunes->season);

						// Get episode duration (in seconds or text) and file size (in bytes)
						$filesize	 = 0; // default value
						$filesize	 = $item->enclosure['length'];
						$filesize 	 = '' . number_format($filesize / 1048576, 2) . 'M';
						$duration 	 = $this->secondline_sanitize_data($itunes->duration);
						if ((!empty($duration)) && (strpos($duration, ':') !== false))
							$duration = $duration;
						elseif(!empty($duration)) {
							$duration = gmdate("H:i:s", $duration);
						} else {
							$duration = '';
						}

						// Ensure posts are published right away (for server/feed timezone conflicts)
						if ( strtotime( (string) $item->pubDate ) < current_time('timestamp') ) {
							$timestamp_post_date = strtotime( (string) $item->pubDate );
						} else {
							$timestamp_post_date = current_time('timestamp');
						}

						$post_date = date( 'Y-m-d H:i:s', $timestamp_post_date );


						if( ($secondline_import_episode_number == 'on') && ($this->secondline_sanitize_data($itunes->episode) != '') ) {
							$post_title  = $this->secondline_sanitize_data($itunes->episode) . ': ' . $this->secondline_sanitize_data($item->title);
						} else {
							$post_title  = $this->secondline_sanitize_data($item->title);
						}

						if (isset($secondline_prepend_title)) {
							$secondline_prepend_title = str_replace('[podcast_title]', $this->secondline_sanitize_data($secondline_rss_feed->channel->title), $secondline_prepend_title);

							$post_title = $secondline_prepend_title . ' ' . $post_title;
						}

						// Set up audio as a shortcode and remove query variables
						$audio_url 	 = (string) $item->enclosure['url'];
						$audio_url 	 = preg_replace( '/(?s:.*)(https?:\/\/(?:[\w\-\.]+[^#?\s]+)(?:\.mp3))(?s:.*)/', '$1', $audio_url );
						$audio_url 	 = preg_replace( '/(?s:.*)(https?:\/\/(?:[\w\-\.]+[^#?\s]+)(?:\.m4a))(?s:.*)/', '$1', $audio_url );
						$feed_link_url = (string) $item->link;
						$secondline_host_checker = false;
						$secondline_match_image_filenames = $this->secondline_match_image_names($secondline_rss_feed_url);
						if(!empty($feed_link_url)) {
							$parsed_feed_url = parse_url($feed_link_url);
							$parsed_feed_host = $parsed_feed_url['host'];
						} else {
							$parsed_feed_host = '';
						}

						if(($secondline_import_embed_player == 'on') && (isset($parsed_feed_host) || isset($secondline_rss_feed_url))) {
							if (preg_match('/fireside.fm/i', $secondline_rss_feed_url)) {
								$feed_link_url = (string) $item->children('fireside', true)->playerEmbedCode;
							}
							if (preg_match('/omny.fm/i', $secondline_rss_feed_url) || preg_match('/omnycontent.com/i', $secondline_rss_feed_url)) {
								$feed_link_url = (string) $item->children('media', true)->content->children('media', true)->player->attributes()->url;
							}
							$secondline_audio_shortcode = $this->secondline_embed_validator($parsed_feed_host, $feed_link_url, $audio_url, $secondline_rss_feed_url, $guid);
							$secondline_host_checker = $this->secondline_embed_host_checker($parsed_feed_host, $secondline_rss_feed_url);
						} else {
							$secondline_audio_shortcode = '[audio src="' . esc_url($audio_url) . '"][/audio]';
						}

						// Set up the post content
						if (!empty($item->children('itunes', true)->summary) && $secondline_content_tag === 'itunes:summary') {
							$secondline_parsed_content = $this->secondline_sanitize_data($item->children('itunes', true)->summary);
						} elseif (!empty($item->children('itunes', true)->encoded) && $secondline_content_tag === 'content:encoded') {
							$secondline_parsed_content = $this->secondline_sanitize_data($item->children('content', true)->encoded);
						} elseif (!empty($item->description) && $secondline_content_tag === 'description') {
							$secondline_parsed_content = $this->secondline_sanitize_data($item->description);
						// If no preference cuts the mustard, try all the defaults
						} elseif (!empty($item->children('content', true)->encoded)) {
							$secondline_parsed_content = $this->secondline_sanitize_data($item->children('content', true)->encoded);
						} elseif (!empty($item->description)) {
							$secondline_parsed_content = $this->secondline_sanitize_data($item->description);
						} else {
							$secondline_parsed_content = $this->secondline_sanitize_data($itunes->summary);
						}

						if ($secondline_truncate_post) {
							$secondline_parsed_content = substr($secondline_parsed_content, 0, intval($secondline_truncate_post));
						}

						// If none of the popular plugins/themes are available, append the audio shortcode to the post content.
						if(!function_exists('ssp_episodes') && !function_exists('powerpress_get_enclosure_data') && !function_exists('spp_sl_sppress_plugin_updater') && !function_exists('secondline_themes_theme_updater') ) {
							$secondline_post_content = $secondline_audio_shortcode . $secondline_parsed_content;
						} else {
							$secondline_post_content = $secondline_parsed_content;
						}

						// Create the post content
						$post = array(
							'post_author'  => $post_author,
							'post_content' => $secondline_post_content,
							'post_date'    => $post_date,
							'post_excerpt' => $this->secondline_sanitize_data($itunes->subtitle),
							'post_status'  => $secondline_import_publish,
							'post_title'   => $post_title,
							'post_type'    => $secondline_import_post_type,
						);

						// Create the post
						global $wpdb;
						$post_id;

						// Check if post already exists, if so - skip. First we'll look for the GUID, then at the title.
						if(!empty($guid) && $guid != '') {
							$query = "SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE (meta_key = 'secondline_imported_guid' AND meta_value LIKE '%$guid%')";
							$guid_count = intval($wpdb->get_var($query));
						} else {
							$guid_count = 0;
						}
						if($guid_count == 0) {

							if( 0 === post_exists( $post_title, "", "", $secondline_import_post_type )) {

								$post_id = wp_insert_post( $post );

								// Continue if the import process errors
								if ( is_wp_error( $post_id ) ) {
									//continue;
								}

								// Add GUID for each post
								add_post_meta( $post_id, 'secondline_imported_guid', $guid, true );

								// Import Episode Number and Season Number
								if ( function_exists('secondline_themes_theme_updater')) {
									if (isset($episode_number) && $episode_number !== '') {
										add_post_meta( $post_id, 'secondline_themes_episode_number', $episode_number, true );
									}
									if (isset($season_number) && $season_number !== '') {
										add_post_meta( $post_id, 'secondline_themes_season_number', $season_number, true );
									}
								}

								// Add embed audio player into the SecondLineThemes custom field
								if ($secondline_import_embed_player == 'on' && $secondline_host_checker) {
									add_post_meta( $post_id, 'secondline_themes_external_embed', $secondline_audio_shortcode, true );
								} else {

									// Custom Field - Seriously Simple Podcsating
									if(function_exists('ssp_episodes')) {
										add_post_meta( $post_id, 'audio_file', $audio_url, true );
										add_post_meta( $post_id, 'duration', $duration, true );
										add_post_meta( $post_id, 'filesize', $filesize, true );
									}
									// Custom Field - PowerPress
									if ( function_exists('powerpress_get_enclosure_data') ) {
										add_post_meta($post_id, 'enclosure', $audio_url, true );
									}
									// Custom Field - Simple Podcast Press
									if ( function_exists('spp_sl_sppress_plugin_updater') ) {
										add_post_meta( $post_id, '_audiourl', $audio_url, true );
									}
									// Custom Field - SecondLineThemes
									if ( function_exists('secondline_themes_theme_updater') && !function_exists('powerpress_get_enclosure_data') && !function_exists('ssp_episodes') && !function_exists('spp_sl_sppress_plugin_updater')  ) {
										add_post_meta( $post_id, 'secondline_themes_external_embed', $secondline_audio_shortcode, true );
									}
								}

								// Add episode categories
								if( !empty($secondline_import_category) ) {
									if( $secondline_import_post_type == 'podcast' ) {
										wp_set_post_terms( $post_id, $secondline_import_category, 'series', false );
									} else {
										wp_set_post_terms( $post_id, $secondline_import_category, 'category', false );
									}
								}

								// Add Parent Show Post
								if($secondline_parent_show != "") {
									add_post_meta( $post_id, 'secondline_themes_parent_show_post', $secondline_parent_show, true );
								}

								// Add episode image
								if (isset($itunes) && isset($item)) { // Workaround for "Node no longer exists" error
									if( $secondline_import_images == 'on' ) {

										if($itunes && $itunes->image && $itunes->image->attributes() && $itunes->image->attributes()->href) {

											$filename = basename(parse_url($itunes->image->attributes()->href)['path']);
											$filename = (string) $filename;

											// Check if image does not exist in the database and upload it. Otherwise attach the existing image to the post
											$query = "SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE meta_value LIKE '%$filename%'";
											$filename_count = intval($wpdb->get_var($query));
											if($filename_count == 0 || $secondline_match_image_filenames == false) {
												$img_to_import = (string) $itunes->image->attributes()->href;
												if(!post_exists( $post_title, '', '', 'attachment' ) || $secondline_match_image_filenames == false) {
													$attachment = get_page_by_title( $post_title, OBJECT, 'attachment');
													if( empty( $attachment ) || $secondline_match_image_filenames == false ) {
														add_action('add_attachment',array($this,'secondline_import_itunes_image'));
														media_sideload_image($img_to_import, $post_id, $item->title);
														remove_action('add_attachment',array($this,'secondline_import_itunes_image'));
													}
												}
											} else {
												$get_upload_dir = wp_upload_dir()['baseurl'] . '/';
												$filename = pathinfo($filename, PATHINFO_FILENAME); // returns $filename with no extension
												$query_path_to_file = "SELECT meta_value FROM {$wpdb->postmeta} WHERE (meta_key = '_wp_attached_file' AND meta_value LIKE '%$filename%')";
												$filename_path = $wpdb->get_var($query_path_to_file);
												$filename_path = str_replace('-scaled', '', $filename_path);
												$image_src = $get_upload_dir . $filename_path;
												$image_id = $this->secondline_get_image_id($image_src);
												set_post_thumbnail($post_id, $image_id);
											}
										}
									}
								}

								do_action( 'secondline_after_post_scheduled_import', $post_id, $secondline_rss_feed, $item );
							}
						}
					}
				}
			}
		}
	}


	// Grab the images and save the image id with the post
	function secondline_import_itunes_image($att_id) {
		$post_img = get_post($att_id);
		update_post_meta($post_img->post_parent,'_thumbnail_id',$att_id);
	}

	// Get image ID by URL
	function secondline_get_image_id($image_url) {
		global $wpdb;
		$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ));
		if (!empty($attachment)) {
			return $attachment[0];
		}
	}

	// Query post types and list as options
	function secondline_post_type_control($value) {
		$secondline_cpts = get_post_types( array( 'public'   => true, 'show_in_nav_menus' => true ) );
		$secondline_exclude_cpts = array( 'elementor_library', 'secondline_psb_post', 'secondline_import', 'secondline_shows', 'attachment', 'product', 'page' );

		foreach ( $secondline_exclude_cpts as $exclude_cpt ) {
			unset($secondline_cpts[$exclude_cpt]);
		}

		foreach ($secondline_cpts as $cpt) {
			$selected = $value === $cpt ? ' selected' : '';
			echo '<option' . $selected . ' value="' . $cpt .  '">' . $cpt . '</option>';
		}
	}

	// Query categories and list as options
	function secondline_list_categories($values) {
		if(function_exists('ssp_episodes')) {
			$args = array('taxonomy' => 'series', 'hide_empty' => false,);
		} else {
			$args = array('taxonomy' => 'category', 'hide_empty' => false,);
		}

		$secondline_cats = get_categories($args);
		foreach ($secondline_cats as $cat) {
			if ( is_array($values) ) {
				$selected = in_array($cat->term_id, $values) ? ' selected' : '';
			} else {
				$selected = '';
			}
			echo '<option' . $selected . ' value="' . $cat->term_id .  '">' . $cat->name . '</option>';
		}
	}

	// Query "Show" posts
	function secondline_list_shows() {

		$args = wp_parse_args( array(
			'post_type'   => 'secondline_shows',
			'numberposts' => 9999,
		) );

		$shows = get_posts( $args );

		$post_options = array();
		if ( $shows ) {
			echo '<option value="" default="default">' . esc_attr__('None','podcast-importer-secondline') . '</option>';
			foreach ( $shows as $post ) {
				echo '<option value="' . $post->ID .  '">' . $post->post_title . '</option>';
			}
		}
	}

	// Return an embed audio player depending on the podcast hosting provider
	function secondline_embed_validator($parsed_feed_host, $embed_url, $audio_url, $secondline_rss_feed_url, $guid) {
		if (strpos($parsed_feed_host, 'transistor.fm') !== false) {

			$fixed_share_url = str_replace('/s/', '/e/', $embed_url);
			$secondline_audio_shortcode = '<iframe src="' . esc_url($fixed_share_url) . '" width="100%" height="180" frameborder="0" scrolling="no" seamless="true" style="width:100%; height:180px;"></iframe>';

		} elseif (strpos($parsed_feed_host, 'anchor.fm') !== false) {

			$fixed_share_url = str_replace('/episodes/', '/embed/episodes/', $embed_url);
			$secondline_audio_shortcode = '<iframe src="' . esc_url($fixed_share_url) . '" height="180px" width="100%" frameborder="0" scrolling="no" style="width:100%; height:180px;"></iframe>';

		} elseif (strpos($parsed_feed_host, 'simplecast.com') !== false) {

			$simplecast_response = wp_remote_get('https://api.simplecast.com/oembed?url=' . rawurlencode($embed_url));
			$simplecast_json = json_decode($simplecast_response['body'], true);
			$simplecast_html = $simplecast_json['html'];
			preg_match('/src="([^"]+)"/', $simplecast_html, $match);
			$fixed_share_url = $match[1];
			$secondline_audio_shortcode = '<iframe src="' . esc_url($fixed_share_url) . '" height="200px" width="100%" frameborder="no" scrolling="no" style="width:100%; height:200px;"></iframe>';

		} elseif (strpos($parsed_feed_host, 'whooshkaa.com') !== false) {

			$whooshkaa_audio_id = substr($embed_url, strpos($embed_url, "?id=") + 4);
			$fixed_share_url = 'https://webplayer.whooshkaa.com/player/episode/id/' . $whooshkaa_audio_id . '?theme=light';
			$secondline_audio_shortcode = '<iframe src="' . esc_url($fixed_share_url) . '" width="100%" height="200" frameborder="0" scrolling="no" style="width: 100%; height: 200px"></iframe>';

		} elseif ((strpos($secondline_rss_feed_url, 'omny.fm') !== false) || (strpos($secondline_rss_feed_url, 'omnycontent.com') !== false)) {

			$secondline_audio_shortcode = '<iframe src="' . esc_url($embed_url) . '" width="100%" height="180px" scrolling="no"  frameborder="0" style="width:100%; height:180px;"></iframe>';

		} elseif (strpos($parsed_feed_host, 'podbean.com') !== false) {

			$secondline_audio_shortcode = wp_oembed_get(esc_url($embed_url)); // oEmbed

		} elseif (strpos($secondline_rss_feed_url, 'megaphone.fm') !== false) {
			$megaphone_audio_link = explode('megaphone.fm/', $audio_url);
			$megaphone_audio_id = explode('.', $megaphone_audio_link[1]);
			$fixed_share_url = 'https://playlist.megaphone.fm/?e=' . $megaphone_audio_id[0];
			$secondline_audio_shortcode = '<iframe src="' . esc_url($fixed_share_url) . '" width="100%" height="210" scrolling="no"  frameborder="0" style="width: 100%; height: 210px"></iframe>';

		} elseif (strpos($secondline_rss_feed_url, 'captivate.fm') !== false) {
			$captivate_audio_link = explode('media/', $audio_url);
			$captivate_audio_id = explode('/', $captivate_audio_link[1]);
			$fixed_share_url = 'https://player.captivate.fm/episode/' . $captivate_audio_id[0];
			$secondline_audio_shortcode = '<iframe src="' . esc_url($fixed_share_url) . '" width="100%" height="170" scrolling="no"  frameborder="0" style="width: 100%; height: 170px"></iframe>';

		} elseif (strpos($audio_url, 'buzzsprout.com') !== false) {
			$buzzsprout_audio_url = explode('.mp3', $audio_url);
			$fixed_share_url = $buzzsprout_audio_url[0] . '?iframe=true';
			$secondline_audio_shortcode = '<iframe src="' . esc_url($fixed_share_url) . '" scrolling="no" width="100%" scrolling="no"  height="200" frameborder="0" style="width: 100%; height: 200px"></iframe>';

		} elseif (strpos($audio_url, 'pinecast.com') !== false) {
			$pinecast_audio_url = explode('.mp3', $audio_url);
			$pinecast_episode_url = str_replace('/listen/', '/player/', $pinecast_audio_url[0]);
			$fixed_share_url = $pinecast_episode_url . '?theme=flat';
			$secondline_audio_shortcode = '<iframe src="' . esc_url($fixed_share_url) . '" scrolling="no" width="100%" scrolling="no"  height="200" frameborder="0" style="width: 100%; height: 200px"></iframe>';

		} elseif (strpos($secondline_rss_feed_url, 'feed.ausha.co') !== false) {
			$ausha_audio_link = explode('audio.ausha.co/', $audio_url);
			$ausha_audio_id = explode('.mp3', $ausha_audio_link[1]);
			$podcastId = $ausha_audio_id[0];
			$secondline_audio_shortcode = '<iframe frameborder="0" height="200px" scrolling="no"  width="100%" src="https://widget.ausha.co/index.html?podcastId=' . $podcastId . '&amp;display=horizontal&amp;v=2"></iframe>';

		} elseif (strpos($secondline_rss_feed_url, 'spreaker.com') !== false) {
			$fixed_share_url = explode('/episode/', $guid);
			if(isset($fixed_share_url[1])) {
				$secondline_audio_shortcode = '<iframe frameborder="0" height="200" scrolling="no" width="100%" src="https://widget.spreaker.com/player?episode_id=' . $fixed_share_url[1] . '"></iframe>';
			} else {
				$secondline_audio_shortcode = '[audio src="' . esc_url($audio_url) . '"][/audio]';
			}

		} elseif (strpos($secondline_rss_feed_url, 'fireside.fm') !== false) {
			$secondline_audio_shortcode = $embed_url . '</iframe>';
			
		} elseif (strpos($secondline_rss_feed_url, 'libsyn.com') !== false) {
			$secondline_audio_shortcode = '<iframe frameborder="0" height="90" scrolling="no" width="100%" src="https://html5-player.libsyn.com/embed/episode/id/' . $embed_url . '" ></iframe>';

		} elseif (strpos($secondline_rss_feed_url, 'audioboom.com') !== false) {
			$fixed_share_url = str_replace('/posts/', '/boos/', $embed_url);
			$secondline_audio_shortcode = '<iframe frameborder="0" height="220" scrolling="no" width="100%" src="' . $fixed_share_url . '/embed/v4"></iframe>';

		} else {

			$secondline_audio_shortcode = '[audio src="' . esc_url($audio_url) . '"][/audio]';

		}

		return $secondline_audio_shortcode;
	}

	function secondline_embed_host_checker($parsed_feed_host, $secondline_rss_feed_url) {
		if ( (preg_match('/transistor.fm|anchor.fm|fireside.fm|simplecast.com|spreaker.com|whooshkaa.com|omny.fm|omnycontent.com|megaphone.fm|podbean.com/i', $parsed_feed_host)) || (preg_match('/megaphone.fm|captivate.fm|ausha.co|omny.fm|omnycontent.com|pinecast.com|audioboom.com|buzzsprout.com/i', $secondline_rss_feed_url) )) {
			$secondline_host_checker = true;
		} else {
			$secondline_host_checker = false;
		}
		return $secondline_host_checker;
	}

	function secondline_match_image_names($secondline_rss_feed_url) {
		if (preg_match('/buzzsprout.com|omny.fm|omnycontent.com/i', $secondline_rss_feed_url)) {
			$secondline_match_image_filenames = false;
		} else {
			$secondline_match_image_filenames = true;
		}
		return $secondline_match_image_filenames;
	}

	// Parse and sanitize data from RSS/XML
	function secondline_sanitize_data($data) {
		$content = array();

		trim( (string) $data );
		$data = str_replace("&nbsp;", "", $data);
		if( preg_match('/^<!\[CDATA\[(.*)\]\]>$/is', $data, $content) ) {
			$data = $content[1];
		} else {
			$data = html_entity_decode($data);
		}

		return $data;
	}

};?>
