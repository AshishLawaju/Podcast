<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package slt
 */
?>
<?php if(get_post_meta($post->ID, 'secondline_themes_page_sidebar', true) == 'right-sidebar' || get_post_meta($post->ID, 'secondline_themes_page_sidebar', true) ==  'left-sidebar' ) : ?><div id="main-container-slt"><?php endif; ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
		<div class="page-content-slt">
			
			<?php the_content(); ?>
			
			<?php wp_link_pages( array(
					'before' => '<div class="secondline-page-nav">' . esc_html__( 'Pages:', 'dixie-secondline' ),
					'after'  => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );
			?>
		</div><!-- .entry-content -->
	
	</div><!-- #post-## -->

	<?php if ( comments_open() || get_comments_number() ) : comments_template(); endif; ?>

<?php if(get_post_meta($post->ID, 'secondline_themes_page_sidebar', true) == 'right-sidebar' || get_post_meta($post->ID, 'secondline_themes_page_sidebar', true) ==  'left-sidebar' ) : ?></div><!-- close #main-container-slt --><?php get_sidebar(); ?><div class="clearfix-slt"></div><?php endif; ?>