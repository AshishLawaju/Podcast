<?php
/**
 * @package slt
 */
?>


	<div id="page-title-slt-post-page">
		<div id="blog-post-title-meta-container" <?php if(get_post_meta($post->ID, 'secondline_themes_external_embed', true)) : ?>class="slt-no-embed-player"<?php endif;?>>
			<div class="width-container-slt">

		    	<h1 class="blog-page-title"><?php the_title(); ?></h1>

                <?php if( is_singular('post') || is_singular('podcast') || is_singular('episode') ) :?>
					<div class="single-secondline-post-meta">

						<?php if (get_theme_mod( 'secondline_themes_blog_single_meta_date_display', 'true') == 'true') : ?><span class="blog-meta-date-display"><?php the_time(get_option('date_format')); ?></span><?php endif; ?>

						<?php if (get_theme_mod( 'secondline_themes_blog_single_serie_display', 'false') == 'true') : ?>
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
						<?php endif; ?>							


						<?php if (get_theme_mod( 'secondline_themes_blog_single_meta_author_display', 'true') == 'true') : ?><span class="blog-meta-author-display"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?></a></span><?php endif; ?>

						<?php if (get_theme_mod( 'secondline_themes_blog_single_meta_category_display', 'true') == 'true') : ?>
							<?php if(get_post_type() == 'podcast') :?>
								<span class="single-blog-meta-category-list">
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
								<span class="single-blog-meta-category-list"><?php the_category(', '); ?></span>
							<?php endif;?>
						<?php endif; ?>



						<?php if (get_theme_mod( 'secondline_themes_blog_single_meta_duration_display', 'true') == 'true') : ?>
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

							?>
						<?php endif;?>

						<?php if (get_theme_mod( 'secondline_themes_blog_single_meta_comment_display', 'true') == 'true') : ?><span class="blog-meta-comments"><?php comments_popup_link( '' . wp_kses( __( '0 Comments', 'dixie-secondline' ), true ) . '', wp_kses( __( '1 Comment', 'dixie-secondline' ), true), wp_kses( __( '% Comments', 'dixie-secondline' ), true ) ); ?></span><?php endif; ?>

					</div>
				<?php endif;?>

				<div id="single-post-player">
					<div id="player-float-secondline">
						<div class="single-player-container-secondline">
							<?php get_template_part( 'template-parts/audio-components/audio', 'logic'); ?>
						</div>
					</div>
				</div>

	    <div class="clearfix-slt"></div>
			</div><!-- close .width-container-slt -->
		</div><!-- close #blog-post-title-meta-container -->
	</div><!-- #page-title-slt -->
