<div class="secondline-author-container">
	
	<div class="secondline-author-image-title">
		<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_avatar( get_the_author_meta('user_email'), $size = '150'); ?></a>
		<h5 class="author-heading"><?php the_author_posts_link(); ?></h5>
		<?php if(get_the_author_meta('secondline_user_sub_headline')) : ?><h6 class="sub-author-heading"><?php echo get_the_author_meta('secondline_user_sub_headline'); ?></h6><?php endif; ?>
		
		
		<?php 
		$current_user = wp_get_current_user();
		if ($post->post_author == $current_user->ID )  {  ?><a href="<?php echo get_edit_user_link(); ?>" id="edit-profile"><?php esc_html_e( 'Edit Profile', 'dixie-secondline' ); ?></a><?php } ?>
	</div>

	
	<div class="secondline-author-main">
		
		
		<div class="secondline-author-main-padding">
			
			<h5 class="secondline-about-the-author"><?php echo esc_html__( 'About the Author', 'dixie-secondline' )?></h5>
		
			<?php echo the_author_meta('description'); ?>		
		
			<div class="secondline-author-icons">
				<?php if(get_the_author_meta('secondline_authorurl')) : ?><a href="<?php echo get_the_author_meta('secondline_authorurl'); ?>" target="_blank" class="author-slt"><i class="fas fa-link"></i></a><?php endif; ?>
				<?php if(get_the_author_meta('secondline_facebookurl')) : ?><a href="<?php echo get_the_author_meta('secondline_facebookurl'); ?>" target="_blank" class="facebook-slt"><i class="fab fa-facebook"></i></a><?php endif; ?>
				<?php if(get_the_author_meta('secondline_twitterurl')) : ?><a href="<?php echo get_the_author_meta('secondline_twitterurl'); ?>" target="_blank" class="twitter-slt"><i class="fab fa-twitter"></i></a><?php endif; ?>
				<?php if(get_the_author_meta('secondline_dribbbleurleurl')) : ?><a href="<?php echo get_the_author_meta('secondline_dribbbleurleurl'); ?>" target="_blank" class="dribbble-slt"><i class="fab fa-dribbble"></i></a><?php endif; ?>
				<?php if(get_the_author_meta('secondline_linkedinurl')) : ?><a href="<?php echo get_the_author_meta('secondline_linkedinurl'); ?>" target="_blank" class="linkedin-slt"><i class="fab fa-linkedin"></i></a><?php endif; ?>
				<?php if(get_the_author_meta('secondline_pinteresturl')) : ?><a href="<?php echo get_the_author_meta('secondline_pinteresturl'); ?>" target="_blank" class="pinterest-slt"><i class="fab fa-pinterest"></i></a><?php endif; ?>
				<?php if(get_the_author_meta('secondline_instagramurl')) : ?><a href="<?php echo get_the_author_meta('secondline_instagramurl'); ?>" target="_blank" class="instagram-slt"><i class="fab fa-instagram"></i></a><?php endif; ?>
				<?php if(get_the_author_meta('secondline_youtubeurl')) : ?><a href="<?php echo get_the_author_meta('secondline_youtubeurl'); ?>" target="_blank" class="youtube-slt"><i class="fab fa-youtube"></i></a><?php endif; ?>
				<?php if(get_the_author_meta('secondline_vimeourl')) : ?><a href="<?php echo get_the_author_meta('secondline_vimeourl'); ?>" target="_blank" class="vimeo-slt"><i class="fab fa-vimeo"></i></a><?php endif; ?>
				<?php if(get_the_author_meta('secondline_soundcloudurl')) : ?><a href="<?php echo get_the_author_meta('secondline_soundcloudurl'); ?>" target="_blank" class="soundcloud-slt"><i class="fab fa-soundcloud"></i></a><?php endif; ?>
				<?php if(get_the_author_meta('secondline_mixcloudurl')) : ?><a href="<?php echo get_the_author_meta('secondline_mixcloudurl'); ?>" target="_blank" class="mixcloud-slt"><i class="fab fa-mixcloud"></i></a><?php endif; ?>
				<?php if(get_the_author_meta('secondline_emailmailto')) : ?><a href="mailto:<?php echo get_the_author_meta('secondline_emailmailto'); ?>" class="mail-slt"><i class="fas fa-envelope"></i></a><?php endif; ?>
			</div>
			
			
		</div>
	</div>
	
	<div class="clearfix-slt"></div>
</div>