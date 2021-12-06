<?php
/**
 * The template for displaying search results pages.
 *
 * @package slt
 */

get_header(); ?>
	
	
	<div id="page-title-slt">
		<div class="width-container-slt">
			<div id="secondline-themes-page-title-container">
				<h1 class="page-title"><?php printf( esc_html__( 'Search results for: %s', 'dixie-secondline' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</div><!-- #secondline-themes-page-title-container -->
			<div class="clearfix-slt"></div>
		</div><!-- close .width-container-slt -->
		<?php if(!is_front_page() && function_exists('bcn_display')) { echo '<div id="bread-crumb-container"><div class="width-container-slt"><div class="breadcrumbs-dixie"><ul id="breadcrumbs-slt"><li><a href="'; echo esc_url( home_url( '/' ) ); echo '">'; echo esc_html_e( 'Home', 'dixie-secondline' );  echo '</a></li>'; bcn_display_list(); echo '</ul><div class="clearfix-slt"></div></div></div></div><div class="clearfix-slt"></div>'; }?>
	</div><!-- #page-title-slt -->
	

		<div id="content-slt" class="site-content">
			<div class="width-container-slt <?php if ( get_theme_mod( 'secondline_themes_blog_cat_sidebar' ) == 'left-sidebar' ) : ?> left-sidebar-slt<?php endif; ?>">
				
					<?php if(get_theme_mod( 'secondline_themes_blog_cat_sidebar' ) == 'left-sidebar' || get_theme_mod( 'secondline_themes_blog_cat_sidebar', 'right-sidebar' ) == 'right-sidebar' ) : ?><div id="main-container-slt"><?php endif; ?>
				
				
					<?php if ( have_posts() ) : ?>
						<div class="secondline-themes-blog-index">
						
							<div class="secondline-masonry-margins"  style="margin-top:-<?php echo esc_attr(get_theme_mod('secondline_themes_blog_index_gap', '20')); ?>px; margin-left:-<?php echo esc_attr(get_theme_mod('secondline_themes_blog_index_gap', '20')); ?>px; margin-right:-<?php echo esc_attr(get_theme_mod('secondline_themes_blog_index_gap', '20')); ?>px;">
								<div class="secondline-blog-index-masonry">
									<?php while ( have_posts() ) : the_post(); ?>
										<div class="secondline-masonry-item secondline-masonry-col-<?php echo esc_attr(get_theme_mod( 'secondline_themes_blog_columns', '1')); ?>">
											<div class="secondline-masonry-padding-blog" style="padding:<?php echo esc_attr(get_theme_mod('secondline_themes_blog_index_gap', '20')); ?>px;">
												<div class="secondline-themes-isotope-animation">
													<?php get_template_part( 'template-parts/content', get_post_format() ); ?>
												</div>
											
											</div>
										</div>
									<?php endwhile; ?>
									
									</div><!-- close .secondline-blog-masonry -->
								</div><!-- close .secondline-masonry-margins -->
							
						</div><!-- close .secondline-themes-blog-index -->
					
					<div class="clearfix-slt"></div>
					
						<?php if (get_theme_mod( 'secondline_themes_blog_pagination', 'default' ) == 'default') : ?>
							<?php secondline_themes_show_pagination_links_slt(); ?>
						<?php endif; ?>
				
						<?php if (get_theme_mod( 'secondline_themes_blog_pagination') == 'load-more') : ?>
							<div id="secondline-load-more-manual"><?php secondline_themes_infinite_content_nav_slt( 'nav-below' ); ?></div>
						<?php endif; ?>
				
						<?php if (get_theme_mod( 'secondline_themes_blog_pagination') == 'infinite-scroll') : ?>
							<?php secondline_themes_infinite_content_nav_slt( 'nav-below' ); ?>
						<?php endif; ?>
					
						<div class="clearfix-slt"></div>
					
					<?php else : ?>
					
						<div class="secondline-themes-blog-index">
							<?php get_template_part( 'template-parts/content', 'none' ); ?>
						</div><!-- close .secondline-masonry-margins -->
					
					<?php endif; ?>
			
				
					<?php if(get_theme_mod( 'secondline_themes_blog_cat_sidebar' ) == 'left-sidebar' || get_theme_mod( 'secondline_themes_blog_cat_sidebar', 'right-sidebar' ) == 'right-sidebar' ) : ?></div><!-- close #main-container-slt --><?php get_sidebar(); ?><?php endif; ?>
				
			<div class="clearfix-slt"></div>
			</div><!-- close .width-container-slt -->
		</div><!-- #content-slt -->
<?php get_footer(); ?>