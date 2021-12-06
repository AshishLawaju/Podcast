<?php
/**
 * @package slt
 */
?>

<div class="secondline-elements-slider-background" <?php global $post; if((get_post_meta($post->ID, 'secondline_themes_header_image', true)) != '') : ?>style="background-image:url('<?php echo esc_url( get_post_meta($post->ID, 'secondline_themes_header_image', true));?>')"<?php elseif(has_post_thumbnail()): ?><?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'secondline-themes-blog-post'); ?>style="background-image:url('<?php echo esc_attr($image[0]);?>')"<?php endif; ?>>
	<?php global $post; ?>
	<div class="slider-elements-display-table">

		<div class="slider-text-floating-container">
			<div class="slider-content-max-width">
				<div class="slider-content-margins">
					<div class="slider-content-alignment-slt">

						<a href="<?php the_permalink();?>"><h2 class="secondline-blog-slider-title"><?php the_title(); ?></h2></a>
						<?php if ( 'post' == get_post_type() || 'podcast' == get_post_type() || 'episode' == get_post_type()) : ?>
							<div class="secondline-post-meta">
								<span class="blog-meta-date-display"><a href="<?php the_permalink();?>"><?php the_time(get_option('date_format')); ?></a></span>
							
								<span class="blog-meta-serie-display">
									<?php if( (get_post_meta($post->ID, 'secondline_themes_episode_number', true) && get_post_meta($post->ID, 'secondline_themes_episode_number', true) !== '') || (get_post_meta($post->ID, 'secondline_themes_season_number', true) && get_post_meta($post->ID, 'secondline_themes_season_number', true) !== '') ) {							
																
										if( get_post_meta($post->ID, 'secondline_themes_season_number', true) ) {
										  echo '<div class="blog-meta-serie-season"> ' .esc_html__('Season', 'dixie-secondline') . ' ' . esc_attr(get_post_meta($post->ID, 'secondline_themes_season_number', true)).'</div>';
										  if( get_post_meta($post->ID, 'secondline_themes_episode_number', true) ) {
											echo '<div class="serie-separator"></div>';
										  }
										}
										
										if( get_post_meta($post->ID, 'secondline_themes_episode_number', true) ) {
										  echo '<div class="blog-meta-serie-episode">' . esc_html__('Episode', 'dixie-secondline') . ' ' .esc_html(get_post_meta($post->ID, 'secondline_themes_episode_number', true)).'</div>';
										}
									
									} elseif( function_exists('powerpress_get_enclosure_data') ) {
										$slt_episode_data = powerpress_get_enclosure_data( $post->ID );
										if( !empty($slt_episode_data['season']) ) {
										  echo '<div class="blog-meta-serie-season">' .esc_html__('Season', 'dixie-secondline') . ' ' . esc_attr($slt_episode_data['season']).'</div>';
										  if( !empty($slt_episode_data['episode_no']) ) {
											echo '<div class="serie-separator"></div>';
										  }
										}
										if( !empty($slt_episode_data['episode_no']) ) {
										  echo '<div class="blog-meta-serie-episode">' . esc_html__('Episode', 'dixie-secondline') . ' ' . esc_attr($slt_episode_data['episode_no']).'</div>';							  
										}
									} ?>
								</span>
								
								<span class="blog-meta-author-display"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?></a></span>
								<?php if(get_post_type() == 'podcast') :?>
									<span class="blog-meta-category-list">
										<?php $terms = get_the_terms( $post->ID , 'series' );
										if($terms) {
											$len = count($terms);
											$i = 0;
											foreach ( $terms as $term ) {
												$term_link = get_term_link( $term, 'series' );
												if( is_wp_error( $term_link ) )
												continue;
												echo esc_attr($term->name);
												if($i != $len - 1) {
													echo ', ';
												}
												$i++;
											}
										}
									;?>
									</span>
								<?php else: ?>
									<span class="blog-meta-category-list"><?php the_category(', '); ?></span>
								<?php endif;?>

								<?php
									if( function_exists('powerpress_get_enclosure_data') ) {
										$slt_episode_data = powerpress_get_enclosure_data( $post->ID );
										if( !empty($slt_episode_data['duration']) ) {
										  echo '<span class="blog-meta-time-slt">'.esc_attr($slt_episode_data['duration']).'</span>';
										}
									}
									if(function_exists('ssp_episodes') && get_post_meta( $post-> ID, 'audio_file', true)) {
										$duration = get_post_meta( $post->ID, 'duration', true );
										if ( !empty($duration) ) {
											$duration = apply_filters( 'ssp_file_duration', $duration, $post->ID );
											echo '<span class="blog-meta-time-slt">'. esc_attr($duration).'</span>';
										}
										$filesize = get_post_meta( $post->ID, 'filesize', true );
										if ( !empty($filesize) ) {
											$filesize = apply_filters( 'ssp_file_filesize', $filesize, $post->ID );
											echo '<span class="blog-meta-time-slt">'. esc_attr($filesize).'</span>';
										}
									}
									;?>
								<span class="blog-meta-comments"><?php comments_popup_link( '' . wp_kses( __( '0 Comments', 'dixie-secondline' ), true ) . '', wp_kses( __( '1 Comment', 'dixie-secondline' ), true), wp_kses( __( '% Comments', 'dixie-secondline' ), true ) ); ?></span>

							</div>
						<?php endif; ?>

						<div class="secondline-themes-blog-excerpt">
							<?php if ( ! empty( $settings['secondline_elements_slider_excerpt'] ) ) : ?>
								<div class="slt-addon-excerpt">
									<?php if(has_excerpt() ): ?><?php the_excerpt(); ?><?php else: ?><p><?php echo secondline_addons_excerpt($settings['slt_slider_excerpt_length'] ); ?></p><?php endif; ?>
								</div>
							<?php endif; ?>
						</div>

						<div class="single-player-container-secondline">
							<?php get_template_part( 'template-parts/audio-components/audio', 'logic'); ?>
						</div>

					</div>

				</div>
			</div><!-- close .slider-content-max-width -->
		</div><!-- close .slider-text-floating-container -->


	</div><!-- close .slider-elements-display-table -->


	<div class="slider-background-overlay-color"></div>
	<div class="clearfix-slt"></div>

</div><!-- close .secondline-elements-slider-background -->
