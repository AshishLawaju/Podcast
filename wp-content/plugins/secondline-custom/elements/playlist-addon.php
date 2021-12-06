<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.


class Widget_SecondlineElementsPlaylist extends Widget_Base {

	public function get_name() {
		return 'secondline-playlist';
	}

	public function get_title() {
		return esc_html__( 'SecondLine - Playlist', 'secondline-custom-plugin' );
	}

	public function get_icon() {
		return 'fa fa-th secondline-themes-secondline-episode';
	}

   public function get_categories() {
		return [ 'basic' ];
	}
	
	
	function Widget_SeconelineElementsPlaylist($widget_instance){
		
	}
	
	protected function _register_controls() {

		
  		$this->start_controls_section(
  			'section_title_global_options',
  			[
  				'label' => esc_html__( 'Playlist Settings', 'secondline-custom-plugin' )
  			]
  		);
	
		$this->add_control(
			'secondline_main_source_type',
			[
				'label' => esc_html__( 'Playlist Source', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'rss' => esc_html__( 'RSS Feed', 'secondline-custom-plugin' ),
					'posts' => esc_html__( 'Existing Posts', 'secondline-custom-plugin' ),
				],
			]
		);		
		
		
		$this->add_control(
			'secondline_elements_post_type_select',
			[
				'label' => esc_html__( 'Select Post Type', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select the post type to pull posts from.', 'secondline-custom-plugin' ),
				'options' => secondline_themes_post_type_control(),
				'default' => secondline_themes_default_post_type(),				
				'conditions' => [
					'terms' => [
						[
							'name' => 'secondline_main_source_type',
							'operator' => 'in',
							'value' => [
								'posts',
							],
						],
					],
				],				

			]
		);		
		
		
		$this->add_control(
			'secondline_elements_rss_feed_url',
			[
				'label' => esc_html__( 'RSS Feed URL', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::TEXT,
				'description' => esc_html__( 'Insert the feed URL to build the playlist.', 'secondline-custom-plugin' ),
				'conditions' => [
					'terms' => [
						[
							'name' => 'secondline_main_source_type',
							'operator' => 'in',
							'value' => [
								'rss',
							],
						],
					],
				],				
			]
		);			
		
		
		$this->add_control(
			'secondline_main_post_count',
			[
				'label' => esc_html__( 'Maximum Playlist Items', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '12',
			]
		);
		
		
		$this->add_control(
			'secondline_post_category',
			[
				'label' => esc_html__( 'Narrow by Category', 'secondline-custom-plugin' ),
				'description' => esc_html__( 'Enter category slugs to display a specific category. Add-in multiple category slugs seperated by a comma to use multiple categories. ', 'secondline-custom-plugin' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'conditions' => [
					'terms' => [
						[
							'name' => 'secondline_main_source_type',
							'operator' => 'in',
							'value' => [
								'posts',
							],
						],
					],
				],					
			]
		);		
		
		$this->add_control(
			'secondline_elements_post_order_sorting',
			[
				'label' => esc_html__( 'Order By', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date' => esc_html__( 'Default - Date', 'secondline-custom-plugin' ),
					'title' => esc_html__( 'Post Title', 'secondline-custom-plugin' ),
					'menu_order' => esc_html__( 'Menu Order', 'secondline-custom-plugin' ),
					'modified' => esc_html__( 'Last Modified', 'secondline-custom-plugin' ),
					'comment_count' => esc_html__( 'Comment Count', 'secondline-custom-plugin' ),
					'rand' => esc_html__( 'Random', 'secondline-custom-plugin' ),
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'secondline_main_source_type',
							'operator' => 'in',
							'value' => [
								'posts',
							],
						],
					],
				],					
			]
		);	
		
		
		$this->add_control(
			'secondline_elements_post_order',
			[
				'label' => esc_html__( 'Order', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'ASC' => esc_html__( 'Ascending', 'secondline-custom-plugin' ),
					'DESC' => esc_html__( 'Descending', 'secondline-custom-plugin' ),
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'secondline_main_source_type',
							'operator' => 'in',
							'value' => [
								'posts',
							],
						],
					],
				],					
			]
		);		
		
		$this->add_control(
			'secondline_main_audio_layout',
			[
				'label' => esc_html__( 'Audio Button Layout', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'vertical',
				'options' => [
					'vertical' => esc_html__( 'Vertical', 'secondline-custom-plugin' ),
					'horizontal' => esc_html__( 'Horizontal', 'secondline-custom-plugin' ),
				],
			]
		);		
		

		
		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'section_styles_player_styles',
			[
				'label' => esc_html__( 'Media Player Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'section_styles_player_color',
			[
				'label' => esc_html__( 'Top/Now-Playing Background', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr( get_theme_mod('secondline_themes_player_background') ),
				'selectors' => [
					'body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .mejs-playlist-current.mejs-layer' => 'background: {{VALUE}}',					
				],
			]
		);

		$this->add_control(
			'section_styles_playing_color',
			[
				'label' => esc_html__( 'Now-Playing Font Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr( get_theme_mod('secondline_themes_player_background') ),
				'selectors' => [
					'body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .mejs-playlist-current.mejs-layer p' => 'color: {{VALUE}}',					
				],
			]
		);		
		
		$this->add_control(
			'section_styles_controls_bg_color',
			[
				'label' => esc_html__( 'Controls Section Background', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr( get_theme_mod('secondline_themes_player_background') ),
				'selectors' => [
					'body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .secondline_playlist .mejs-container .mejs-controls' => 'background: {{VALUE}}',					
				],
			]
		);		
		
		$this->add_control(
			'section_styles_track_bg_color',
			[
				'label' => esc_html__( 'Tracks Section Background', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .secondline-themes-playlist-element .mejs-playlist-layer.mejs-playlist-selector ul, body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .secondline-themes-playlist-element .mejs-playlist-layer.mejs-playlist-selector li' => 'background-color: {{VALUE}}',					
				],
			]
		);	
		
		$this->add_control(
			'section_styles_track_font_color',
			[
				'label' => esc_html__( 'Tracks Font Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .secondline-themes-playlist-element .mejs-playlist-layer.mejs-playlist-selector ul, body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .secondline-themes-playlist-element .mejs-playlist-layer.mejs-playlist-selector li' => 'color: {{VALUE}}',					
				],
			]
		);			

		$this->add_control(
			'section_styles_player_bg',
			[
				'label' => esc_html__( 'Audio Background Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr( get_theme_mod('secondline_themes_player_background') ),
				'selectors' => [
					'body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .mejs-container .mejs-inner .mejs-controls .mejs-time-rail span.mejs-time-loaded, body #main-container-secondline {{WRAPPER}} .mejs-container .mejs-inner .mejs-controls .mejs-time-rail span.mejs-time-total, body #main-container-secondline {{WRAPPER}} .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-total' => 'background: {{VALUE}}',					
				],
			]
		);
			
		$this->add_control(
			'section_styles_player_text',
			[
				'label' => esc_html__( 'Time Text Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr( get_theme_mod('secondline_themes_player_time_text') ),
				'selectors' => [
					'body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .secondline_playlist .mejs-inner .mejs-time .mejs-currenttime, body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .secondline_playlist .mejs-inner .mejs-time .mejs-duration' => 'color: {{VALUE}} !important;',				
				],
			]
		);		
		
		
		$this->add_control(
			'section_styles_player_progress_color',
			[
				'label' => esc_html__( 'Progressed Background Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr( get_theme_mod('secondline_themes_player_progressed') ),
				'selectors' => [
					'body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .mejs-container .mejs-inner .mejs-controls .mejs-time-rail span.mejs-time-current, body #main-container-secondline {{WRAPPER}} .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current' => 'background: {{VALUE}}',
				],
			]
		);		
		
		$this->add_control(
			'section_styles_player_icon_color',
			[
				'label' => esc_html__( 'Media Buttons Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr( get_theme_mod('secondline_themes_player_icon') ),
				'selectors' => [
					'body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .mejs-playpause-button.mejs-play button:before, body #main-container-secondline {{WRAPPER}} .mejs-playpause-button.mejs-pause button:before, body #main-container-secondline {{WRAPPER}}   .mejs-playpause-button.mejs-play button:before, body #main-container-secondline {{WRAPPER}}  .wp-playlist .wp-playlist-next, body #main-container-secondline {{WRAPPER}}  .wp-playlist .wp-playlist-prev, body #main-container-secondline {{WRAPPER}} .mejs-inner .mejs-controls button, body #main-container-secondline {{WRAPPER}} .mejs-inner .mejs-controls button:before' => 'color: {{VALUE}}',
					'body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .mejs-container .mejs-controls .mejs-playpause-button' => 'border-color: {{VALUE}}',
					'body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .mejs-button.mejs-speed-button button' => 'border-color: {{VALUE}}',
				],
			]
		);		
		
		$this->add_control(
			'section_styles_player_icon_color_hover',
			[
				'label' => esc_html__( 'Media Buttons Hover Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr( get_theme_mod('secondline_themes_player_icon_hover') ),
				'selectors' => [
					'body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .mejs-playpause-button.mejs-play:hover button:before, body #main-container-secondline {{WRAPPER}} .mejs-playpause-button.mejs-pause:hover button:before, body #main-container-secondline {{WRAPPER}}   .mejs-playpause-button.mejs-play:hover button:before, body #main-container-secondline {{WRAPPER}}  .wp-playlist .wp-playlist-next, body #main-container-secondline {{WRAPPER}}  .wp-playlist .wp-playlist-prev, body #main-container-secondline {{WRAPPER}} .mejs-inner .mejs-controls button:hover, body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .mejs-inner .mejs-button:hover button:before,body #main-container-secondline {{WRAPPER}} .mejs-inner .mejs-controls .mejs-volume-button:hover button:before' => 'color: {{VALUE}}',
					'body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .mejs-container .mejs-controls .mejs-playpause-button:hover' => 'border-color: {{VALUE}}',
					'body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .mejs-button.mejs-speed-button button:hover' => 'border-color: {{VALUE}}',
				],
			]
		);			
		
		$this->add_control(
			'section_styles_player_icon_control',
			[
				'label' => esc_html__( 'Knob / Control Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr( get_theme_mod('secondline_themes_player_knob') ),
				'selectors' => [
					'body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .mejs-controls .mejs-time-rail .mejs-time-handle, body #main-container-secondline {{WRAPPER}} .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-handle' => 'background: {{VALUE}}; border-color: {{VALUE}}',

				],
			]
		);		
		
		$this->end_controls_section();

	}
	

	protected function render( ) {
		
    $settings = $this->get_settings();

	if($settings['secondline_main_source_type'] == 'posts' ) {
		global $blogloop;
		global $post;
		
		
		if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } else if ( get_query_var('page') ) {   $paged = get_query_var('page'); } else {  $paged = 1; }

		$post_per_page = $settings['secondline_main_post_count'];	
		
		if ( ! empty( $settings['secondline_post_category'] ) ) {
			$catpostIds = $settings['secondline_post_category']; 
			$catarrayIds = explode(',', $catpostIds); 
			if(count($catarrayIds) <= 1) {
				if( strpos($catarrayIds[0], ',') !== false ) {
					$catarrayIds = array(); 
					$catarrayIds = explode(', ', $catpostIds);
				}
			}
			$operatorcat = 'IN';
		} else {
			$catarrayIds = '';
			$operatorcat = 'NOT IN';					
		}
		
		if(($settings['secondline_elements_post_type_select'] == 'podcast') && taxonomy_exists( 'series' )) {
			$taxonomy_type = 'series';
		} else {
			$taxonomy_type = 'category';
		}
				
		$args = array(
				'post_type'			=> $settings['secondline_elements_post_type_select'],
				'orderby'				=> $settings['secondline_elements_post_order_sorting'],
				'order'				=> $settings['secondline_elements_post_order'],
				'ignore_sticky_posts' => 1,
				'posts_per_page'     	=> $post_per_page,
				'paged' 				=> $paged,
				'tax_query' => array(
					'relation' => 'AND',
					array(
						'taxonomy' => $taxonomy_type,
						'field'    => 'slug',
						'terms'    => $catarrayIds,
							'operator' => $operatorcat
					),
				),
		);

		

		$blogloop = new \WP_Query( $args );
	
	}
	
	?>
	


	<div id="<?php echo esc_attr($this->get_id()); ?>" class="secondline-themes-playlist-element">

		<div class="secondline_playlist">
			<audio class="mep-playlist"	data-showplaylist="true" controls="controls" autoplay="false" preload="auto" style="max-width: 100%;">
				<?php if($settings['secondline_main_source_type'] == 'posts' ): ?>
					<?php $audio_file_path = '';?>
					<?php while($blogloop->have_posts()): $blogloop->the_post();
						if(get_post_meta($post->ID, '_audiourl', true) !== null && get_post_meta($post->ID, '_audiourl', true) !== '') {      
							$audio_file_path = get_post_meta($post->ID, '_audiourl', true);
						} elseif (get_post_meta($post->ID, 'enclosure', true) !== null && get_post_meta($post->ID, 'enclosure', true) !== '') {
							$MetaData = get_post_meta($post->ID, 'enclosure', true);						 						
							$MetaParts = explode("\n", $MetaData, 4);
							if (isset($MetaParts[0])) {
								$meta_url = $MetaParts[0];
							};						
							if ($meta_url != '') {
								$audio_file_path = $meta_url;
							}
						} elseif (get_post_meta($post->ID, 'audio_file', true) !== null && get_post_meta($post->ID, 'audio_file', true) !== '') {
							$audio_file_path = get_post_meta($post->ID, 'audio_file', true);
						} elseif (get_post_meta($post->ID, 'secondline_themes_external_embed', true) !== null && get_post_meta($post->ID, 'secondline_themes_external_embed', true) !== '') {							
							$secondline_playlist_audio_url = get_post_meta($post->ID, 'secondline_themes_external_embed', true);
							if (strpos($secondline_playlist_audio_url, '.mp3') !== false) {
								$audio_file_path = get_post_meta($post->ID, 'secondline_themes_external_embed', true);
								$audio_file_path = str_replace('[audio', '', $audio_file_path);
								$audio_file_path = str_replace('[/audio]', '', $audio_file_path);
								$audio_file_path = str_replace(']', '', $audio_file_path);								
								$audio_file_path = str_replace('src="', '', $audio_file_path);
								$audio_file_path = str_replace('"', '', $audio_file_path);
							};
						}
						//@TODO: - Try adding PodLove audio
						?>
	
					<source src="<?php echo esc_url($audio_file_path);?>" title="<?php the_title();?>" data-playlist-thumbnail="<?php echo get_the_post_thumbnail_url();?>" type="audio/mpeg"/>	
					<?php endwhile;?>	
				<?php elseif($settings['secondline_main_source_type'] == 'rss' ): ?>
					<?php
					// Set up a new post per item that appears in the feed
					if( isset( $settings['secondline_elements_rss_feed_url'] ) ) {
						$secondline_rss_feed_url = $settings['secondline_elements_rss_feed_url'];
						$episode_limit = $settings['secondline_main_post_count'];						
						$secondline_rss_feed = @simplexml_load_file($secondline_rss_feed_url);
						if(!empty($secondline_rss_feed)) {
							$episode_count = count( $secondline_rss_feed->channel->item );
							for ( $i = 0; $i < $episode_count && $i < $episode_limit; $i ++ ) {
								if(isset($secondline_rss_feed->channel->item[ $i ]) && isset($i)) {
									$item  = $secondline_rss_feed->channel->item[ $i ];
								}
								$itunes      = $item->children( 'http://www.itunes.com/dtds/podcast-1.0.dtd' );					
								$post_title  = esc_attr($item->title);
								$duration 	 = secondline_plugin_sanitize_data($itunes->duration);
								$filename	 = '';
								$audio_url 	 = (string) $item->enclosure['url'];
								$audio_url 	 = preg_replace( '/(?s:.*)(https?:\/\/(?:[\w\-\.]+[^#?\s]+)(?:\.mp3))(?s:.*)/', '$1', $audio_url );					

								if ((!empty($duration)) && (strpos($duration, ':') !== false))
									$duration = $duration;	
								elseif(!empty($duration)) {
									$duration = gmdate("H:i:s", $duration);
								} else {
									$duration = '';
								}																													
																											
								// Add episode image
								if (isset($itunes) && isset($item)) { // Check again that feed is not empty		
									// Grab image URL and file name
									if($itunes && $itunes->image && $itunes->image->attributes() && $itunes->image->attributes()->href) {			
										$filename = $itunes->image->attributes()->href;
									}
								}

								echo '<source src="'. $audio_url .'" title="'. $post_title .'" data-playlist-thumbnail="'. $filename .'" data-playlist-duration="'. $duration .'" type="audio/mpeg" />';							
							}
						}						
					} else {
						echo '<strong>' . esc_html__('Podcast Feed Error! Please use a valid RSS feed URL.', 'podcast-importer-secondline') . '</strong>';
					}		
				
					?>

				<?php endif;?>		
			</audio>		
		</div>
	</div>
				
	<div class="clearfix-slt"></div>
	
	<script type="text/javascript"> 
	jQuery(document).ready(function($) {
		'use strict';
		/* Playlist Init */
		$(".secondline-themes-playlist-element#<?php echo esc_attr($this->get_id()); ?> audio").mediaelementplayer({
			'classPrefix': 'mejs-',
			'isVideo': false,
			'autoplay': false,
			'playlist': true,
			audioVolume: "<?php echo esc_attr($settings['secondline_main_audio_layout']); ?>",
			playlistposition: 'bottom',
			features: ['playlistfeature', 'prevtrack', 'playpause', 'nexttrack', 'current', 'progress', 'duration', 'volume', 'skipback', 'jumpforward', 'speed', 'playlist'],
			prevText: 'Previous',
			nextText: 'Next',
			playlistTitle: '',
			currentMessage: '',
		})
		
		$(".secondline-themes-playlist-element#<?php echo esc_attr($this->get_id()); ?>").find('.mejs-controls').append('<button class="playlist-toggle"><i class="fas fa-bars"></i></button>');
		$(".secondline-themes-playlist-element#<?php echo esc_attr($this->get_id()); ?>").find('.mejs-playlist-item-inner:not(:has(.mejs-playlist-item-thumbnail))').prepend( '<i class="no-thumb-slt fas fa-image"></i></button>' );
		
		$(".secondline-themes-playlist-element#<?php echo esc_attr($this->get_id()); ?>").on("click", function() {
			if ($(".secondline-themes-playlist-element#<?php echo esc_attr($this->get_id()); ?> .mejs-playlist-current img").length) {
				// do nothing if there is an existing image
			} else { 
				$(".secondline-themes-playlist-element#<?php echo esc_attr($this->get_id()); ?> .mejs-playlist-current").prepend('<img src="" />');	
			}
		});		
		
		if ($(".secondline-themes-playlist-element#<?php echo esc_attr($this->get_id()); ?> .mejs-playlist-current img").length) {
			// do nothing if there is an existing image
		} else { 
			$(".secondline-themes-playlist-element#<?php echo esc_attr($this->get_id()); ?> .mejs-playlist-current").prepend('<img src="" />');	
		}
		
		$(".secondline-themes-playlist-element#<?php echo esc_attr($this->get_id()); ?> .playlist-toggle").on("click", function() {
			$(".secondline-themes-playlist-element#<?php echo esc_attr($this->get_id()); ?> .mejs-container").toggleClass('playlist_hidden');			
			$(".secondline-themes-playlist-element#<?php echo esc_attr($this->get_id()); ?> .secondline_playlist").toggleClass('fluid_playlist_height');
		});							

		
	});
	</script>
	


	<?php wp_reset_postdata();?>
	

	<?php
	
	}

	protected function content_template(){}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_SecondlineElementsPlaylist() );