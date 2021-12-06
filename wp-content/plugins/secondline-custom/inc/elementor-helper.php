<?php
namespace Elementor;


//Query List
function secondline_elements_post_lists(){
	global $post;
	$sltposts = new \WP_Query( array( 'post_type' => 'post', 'posts_per_page' => '99999', ) );	

	if ( $sltposts->have_posts() ) {
		$options = array();
		$options['none'] = '-';
		while ( $sltposts->have_posts() ) {
			$sltposts->the_post();
			$options[get_the_id()] = get_the_title();
		}		

		wp_reset_postdata();
		
	} else {
		// no posts found
	}	


	return $options;	
	
}


//Query List
function secondline_elements_show_grid(){
	global $post;
	$sltposts = new \WP_Query( array( 'post_type' => 'secondline_shows', 'posts_per_page' => '99999', ) );	

	if ( $sltposts->have_posts() ) {
		$options = array();
		$options['none'] = '-';
		while ( $sltposts->have_posts() ) {
			$sltposts->the_post();
			$options[get_the_id()] = get_the_title();
		}		

		wp_reset_postdata();
		
	} else {
		// no posts found
	}	


	return $options;	
	
}

//Query Post Types
function secondline_themes_post_type_control(){
	
	$secondline_cpts = get_post_types( array( 'public'   => true, 'show_in_nav_menus' => true ) );
	$secondline_exclude_cpts = array( 'elementor_library', 'secondline_import', 'secondline_shows', 'secondline_psb_post', 'attachment', 'product', 'page' );
	
	
	foreach ( $secondline_exclude_cpts as $exclude_cpt ) {
		unset($secondline_cpts[$exclude_cpt]);
	}
	

	$post_types = array_merge($secondline_cpts);
	return $post_types;
}

function secondline_themes_default_post_type(){
	
	if(function_exists('ssp_episodes') && post_type_exists('podcast')) {
		$default_post_type = 'podcast';
	} else {
		$default_post_type = 'post';
	}
	
	return $default_post_type;
}


// Query Contact Forms
if ( function_exists( 'wpcf7' ) ) {
	function secondline_contact_form_selection(){
		$contactlist = get_posts(array(
			'post_type' => 'wpcf7_contact_form',
			'showposts' => 999,
		));
		$posts = array();
		
		if ( ! empty( $contactlist ) && ! is_wp_error( $contactlist ) ){
			
		$i = 0;
		foreach ( $contactlist as $post ) {	
		   if($i == 0) {
				$options[ 0 ] = esc_html__( 'Choose a Contact form', 'secondline-custom-plugin' );
		   }	
			$options[ $post->ID ] = $post->post_title;
			 $i++;
		} 
		return $options;
		}
	}
}


// Query Subscribe Buttons
if ( function_exists( 'secondline_psb_theme_elements_buttons' ) ) {
	function secondline_subscribe_button_selection(){
		$buttonlist = get_posts(array(
			'post_type' => 'secondline_psb_post',
			'showposts' => 999,
		));
		$posts = array();
		
		if ( ! empty( $buttonlist ) && ! is_wp_error( $buttonlist ) ){
			
		$i = 0;
		foreach ( $buttonlist as $post ) {	
		   if($i == 0) {
				$options[ 0 ] = esc_html__( 'Choose a Subscribe Button', 'secondline-custom-plugin' );
		   }	
			$options[ $post->ID ] = $post->post_title;
			 $i++;
		} 
		return $options;
		}
	}
}


if ( function_exists( 'WC' ) ) {
//Query Product Categories List by Slug
	function secondline_addons_product_categories() {		
		$terms = get_terms( array(
			'taxonomy' => 'product_cat',
			'hide_empty' => true,
		));
		
		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				$options[ $term->slug ] = $term->name;
			}
			return $options;
		}
	}
}

// Getting Page List
function secondline_page_list_selection(){
	$pagelist = get_posts(array(
		'post_type' => 'elementor_library',
		'showposts' => 999,
	));
	$posts = array();
	
	if ( ! empty( $pagelist ) && ! is_wp_error( $pagelist ) ){
	foreach ( $pagelist as $post ) {
		$options[ $post->ID ] = $post->post_title;
	} 
	return $options;
	}
}


// Parse and sanitize data from RSS/XML
function secondline_plugin_sanitize_data($data) {
	$content = array();
		
	trim( (string) $data );
	if( preg_match('/^<!\[CDATA\[(.*)\]\]>$/is', $data, $content) ) {
		$data = $content[1];
	} else {
		$data = html_entity_decode($data);
	}
	
	return $data;
}