<?php
/**
 * The template for displaying all single posts.
 *
 * @package secondline
 */

	global $post;
	if($post->ID == (get_theme_mod( 'secondline_themes_header_elementor_library') || get_theme_mod( 'secondline_themes_footer_elementor_library'))) {
		wp_head();
	} else {
		get_header();	
	}

	/*
	*
	* Load Elementor content section for the canvas
	*
	*/
	\Elementor\Plugin::$instance->modules_manager->get_modules( 'page-templates' )->print_content();


	if($post->ID == (get_theme_mod( 'secondline_themes_header_elementor_library') || get_theme_mod( 'secondline_themes_footer_elementor_library'))) {
		wp_footer();
	} else {
		get_footer();	
	}
	
 ;?>