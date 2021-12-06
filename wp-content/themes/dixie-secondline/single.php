<?php
/**
 * The template for displaying all single posts.
 *
 * @package slt
 */

get_header(); ?>
	
	<?php while ( have_posts() ) : the_post(); ?>
	
	<?php get_template_part( 'template-parts/post-title/title', 'default' ); ?>
	
	<div id="content-slt" class="site-content-blog-post">

		<div class="width-container-slt <?php if ( get_theme_mod( 'secondline_themes_blog_post_sidebar') == 'left') : ?> left-sidebar-slt<?php endif; ?>">
				
				<?php if ( get_theme_mod( 'secondline_themes_blog_post_sidebar', 'right') == 'right' || get_theme_mod( 'secondline_themes_blog_post_sidebar', 'right') == 'left') : ?><div id="main-container-slt"><?php endif; ?>

					<?php get_template_part( 'template-parts/content', 'single' ); ?>					
	
				<?php if ( get_theme_mod( 'secondline_themes_blog_post_sidebar', 'right') =='right' || get_theme_mod( 'secondline_themes_blog_post_sidebar', 'right') =='left') : ?></div><!-- close #main-container-slt --><?php get_sidebar(); ?><?php endif; ?>

				
		<div class="clearfix-slt"></div>
		</div><!-- close .width-container-slt -->
		
	</div><!-- #content-slt -->
	
	
	<?php endwhile; // end of the loop. ?>	

<?php get_footer(); ?>