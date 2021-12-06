<?php
/**
 * @package slt
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="secondline-single-container">

		<div class="secondline-blog-single-content">
			<?php if( has_post_format( 'gallery' ) && get_post_meta($post->ID, 'secondline_themes_gallery', true)  ): ?>
				<div class="secondline-featured-image">
					<div class="flexslider secondline-gallery">
					  <ul class="slides">
							<?php $files = get_post_meta( get_the_ID(),'secondline_themes_gallery', 1 ); ?>
							<?php foreach ( (array) $files as $attachment_id => $attachment_url ) : ?>
							<?php $lightbox_secondline = wp_get_attachment_image_src($attachment_id, 'large'); ?>
							<li>
								<a href="<?php echo esc_url($lightbox_secondline[0]);?>" data-rel="prettyPhoto[gallery]" <?php $get_description = get_post($attachment_id)->post_excerpt; if(!empty($get_description)){ echo 'title="' . esc_attr($get_description) . '"'; } ?>>
								<?php echo wp_get_attachment_image( $attachment_id, 'secondline-blog-index' ); ?>
							</a></li>
							<?php endforeach;  ?>
						</ul>
					</div><!-- close .flexslider -->

				</div><!-- close .secondline-featured-image -->		
		
            <?php elseif ( (get_theme_mod('secondline_themes_blog_single_featured_img_display', 'true') == 'true') && ( is_singular('post') || is_singular('podcast') || is_singular('episode') || is_singular('product') || is_singular('download') ) && has_post_thumbnail() && (!get_post_meta($post->ID, 'secondline_themes_disable_img'))) : ?>
		        <div class="secondline-featured-img-single">
		            <?php the_post_thumbnail('full');?>
		        </div>
		    <?php endif;?>      

			
			<div class="secondline-themes-blog-single-excerpt">
				<?php the_content(); ?>
				
				<?php if( function_exists('the_powerpress_content')): ?>
					<?php
						$slt_options_pl = get_option('powerpress_general');
						$slt_player_settings = $slt_options_pl['display_player'];	
					?>
					<?php if(($slt_player_settings == '1') && (function_exists('spp_sl_sppress_plugin_updater'))) : ?>
						<?php $MetaData = get_post_meta($post->ID, 'enclosure', true);?>
						<?php 
						
						$MetaParts = explode("\n", $MetaData, 4);
						if (isset($MetaParts[0])) {
							$meta_url = $MetaParts[0];
						};
						
						if ($meta_url != '') {
							echo do_shortcode('[spp-player url="'. esc_url($meta_url) . '"]');
						}
						
						?>							
					<?php elseif(($slt_player_settings == '1')) : ?>
						<?php the_powerpress_content(); ?>
					<?php endif;?>	
				<?php endif;?>					
			
				<?php wp_link_pages( array(
					'before' => '<div class="secondline-page-nav">' . esc_html__( 'Pages:', 'dixie-secondline' ),
					'after'  => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
					) );
				?>
			</div>
			
			
			<?php the_tags(  '<div class="tags-secondline"><i class="fa fa-tags"></i>', ' ', '</div><div class="clearfix-slt"></div>' ); ?> 
			
			<?php if(get_the_author_meta('description')) : ?>
				<?php get_template_part( 'template-parts/author', 'info' ); ?>
			<?php endif; ?>
			
			<?php get_template_part( 'template-parts/social', 'sharing-single' ); ?>
			
			<div class="clearfix-slt"></div>
			
			<?php if (get_theme_mod( 'secondline_themes_blog_single_comment_area_display', 'true') == 'true') : ?>
				<?php if ( comments_open() || get_comments_number() ) : comments_template(); endif; ?>
			<?php endif;?>	
			
		</div><!-- close .secondline-blog-content -->

	<div class="clearfix-slt"></div>
	
	
	</div><!-- close .secondline-single-container -->
</div><!-- #post-## -->