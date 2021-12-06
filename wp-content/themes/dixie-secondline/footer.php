<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package slt
 * @since slt 1.0
 */
?>
		
		<?php // Elementor `footer` location
		if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) : ?>		
		
		<?php if (get_theme_mod( 'secondline_themes_footer_elementor_library') ) : ?>
			<div id="dixie-footer-page-builder">
				<?php if(is_page() && get_post_meta($post->ID, 'secondline_disable_footer_per_page', true)): ?><?php else: ?>
				<?php
				if( function_exists( 'elementor_load_plugin_textdomain' ) ) {
					echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( get_theme_mod( 'secondline_themes_footer_elementor_library') );
				}
				?><?php endif; ?>
			</div>
		<?php else: ?>		
		
		<footer id="site-footer" class="<?php echo esc_attr( get_theme_mod('secondline_themes_footer_width', 'secondline-themes-footer-normal-width') ); ?> <?php echo esc_attr( get_theme_mod('secondline_themes_footer_image_location_align') ); ?> <?php echo esc_attr( get_theme_mod('secondline_themes_footer_nav_align') ); ?> <?php echo esc_attr( get_theme_mod('secondline_themes_footer_copyright_location', 'footer-copyright-align-center') ); ?>">
			
			<div id="widget-area-secondline">
			<div class="width-container-slt <?php echo esc_attr(get_theme_mod('secondline_themes_footer_widget_count', 'footer-4-slt')); ?>">
				
				
				<?php if ( get_theme_mod( 'secondline_themes_footer_image_location') == 'top') : ?>
					<?php if ( get_theme_mod( 'secondline_themes_footer_logo_image') ) : ?>
						<div id="secondline-themes-footer-logo"><?php if ( get_theme_mod( 'secondline_themes_footer_logo_link')) : ?><a href="<?php echo esc_url( get_theme_mod('secondline_themes_footer_logo_link') ); ?>"><?php endif ?><img src="<?php echo esc_attr( get_theme_mod( 'secondline_themes_footer_logo_image') ); ?>" alt="<?php bloginfo('name'); ?>"><?php if ( get_theme_mod( 'secondline_themes_footer_logo_link')) : ?></a><?php endif ?></div>
					<?php endif; ?>
				<?php endif ?>
				
				<?php if ( get_theme_mod( 'secondline_themes_footer_icon_location') == 'top') : ?><?php get_template_part( 'footer', 'icons' ); ?><?php endif ?>
				
				<?php if ( get_theme_mod( 'secondline_themes_footer_nav_location') == 'top') : ?>
				<?php wp_nav_menu( array('theme_location' => 'secondline-themes-footer-menu', 'menu_class' => 'secondline-themes-footer-nav-container-class', 'fallback_cb' => false, 'depth' => '1' ) ); ?>
				<?php endif ?>
				
				<div class="clearfix-slt"></div>
				
				<?php if ( is_active_sidebar( 'secondline-themes-footer-widgets' ) ) { ?>
					<?php dynamic_sidebar( 'secondline-themes-footer-widgets' ); ?>					
				<?php } ?>

				<div class="clearfix-slt"></div>
				
				<?php if ( get_theme_mod( 'secondline_themes_footer_icon_location') == 'middle') : ?><?php get_template_part( 'footer', 'icons' ); ?><?php endif ?>
				<?php if ( get_theme_mod( 'secondline_themes_footer_nav_location', 'bottom') == 'middle') : ?>
					<?php wp_nav_menu( array('theme_location' => 'secondline-themes-footer-menu', 'menu_class' => 'secondline-themes-footer-nav-container-class', 'fallback_cb' => false, 'depth' => '1' ) ); ?>
				<?php endif ?>
				
				</div><!-- close .width-container-slt -->
			</div><!-- close #widget-area-slt -->
			
			
			<?php if ( get_theme_mod('secondline_themes_footer_copyright', 'Copyright 2018. Developed by <a href="//secondlinethemes.com/">SecondLine Themes</a>') ) : ?>
			
			<div id="secondline-themes-copyright">
				<div class="width-container-slt">
					
					<?php if ( get_theme_mod( 'secondline_themes_footer_image_location', 'bottom') == 'bottom') : ?>
						<?php if ( get_theme_mod( 'secondline_themes_footer_logo_image' ) ) : ?>
							<div id="secondline-themes-footer-logo"><?php if ( get_theme_mod( 'secondline_themes_footer_logo_link')) : ?><a href="<?php echo esc_url( get_theme_mod('secondline_themes_footer_logo_link') ); ?>"><?php endif ?><img src="<?php echo esc_attr( get_theme_mod( 'secondline_themes_footer_logo_image' ) ); ?>" alt="<?php bloginfo('name'); ?>"><?php if ( get_theme_mod( 'secondline_themes_footer_logo_link')) : ?></a><?php endif ?></div>
						<?php endif; ?>
					<?php endif ?>
					
				</div> <!-- close .width-container-slt -->	
				
				
					<div class="width-container-slt">
						<?php if ( get_theme_mod( 'secondline_themes_footer_icon_location') == 'bottom') : ?><?php get_template_part( 'footer', 'icons' ); ?><?php endif ?>
						
					<?php if ( get_theme_mod( 'secondline_themes_footer_nav_location', 'bottom') == 'bottom') : ?>
					<?php wp_nav_menu( array('theme_location' => 'secondline-themes-footer-menu', 'menu_class' => 'secondline-themes-footer-nav-container-class', 'fallback_cb' => false, 'depth' => '1' ) ); ?>
					<?php endif ?>
				
				
				<div id="copyright-text">
						<?php echo wp_kses(get_theme_mod( 'secondline_themes_footer_copyright', 'Copyright 2018. Developed by <a href="//secondlinethemes.com/">SecondLine Themes</a>' ), true); ?>
				</div>		
				
				</div> <!-- close .width-container-slt -->			
				<div class="clearfix-slt"></div>
					
				
			</div><!-- close #secondline-themes-copyright -->
			<?php endif; ?>
			
		</footer>
		<?php endif;?>
		<?php endif;?>

	</div><!-- close #boxed-layout-slt -->
	
<?php wp_footer(); ?>
</body>
</html>