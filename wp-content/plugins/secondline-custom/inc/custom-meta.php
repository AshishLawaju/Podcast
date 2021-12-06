<?php

function secondline_get_term_options( $field ) {
	$args = $field->args( 'get_terms_args' );
	$args = is_array( $args ) ? $args : array();

	$args = wp_parse_args( $args, array( 'taxonomy' => 'category' ) );

	$taxonomy = $args['taxonomy'];

	$terms = (array) cmb2_utils()->wp_at_least( '4.5.0' )
		? get_terms( $args )
		: get_terms( $taxonomy, $args );

	// Initate an empty array
	$term_options = array();
	if ( ! empty( $terms ) ) {
		foreach ( $terms as $term ) {
			$term_options[ $term->term_id ] = $term->name;
		}
	}

	return $term_options;
}


function secondline_themes_addons_show_categories_ssp(){
	$terms = get_terms( array(
		'taxonomy' => 'series',
		'hide_empty' => true,
	));

	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	foreach ( $terms as $term ) {
		$options[ $term->slug ] = $term->name;
	}
	return $options;
	}
}




add_action( 'cmb2_admin_init', 'secondline_themes_page_meta_box' );
function secondline_themes_page_meta_box() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = 'secondline_themes_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$secondline_themes_cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'metabox_page_settings',
		'title'         => esc_html__('Page Settings', 'secondline-custom-plugin'),
		'object_types'  => array( 'page' ), // Post type,
	) );
	
	
	$secondline_themes_cmb_demo->add_field( array(
		'name'       => esc_html__('Sub-title', 'secondline-custom-plugin'),
		'id'         => $prefix . 'sub_title',
		'type'       => 'text',
	) );

	$secondline_themes_cmb_demo->add_field( array(
		'name'       => esc_html__('Sidebar Display', 'secondline-custom-plugin'),
		'id'         => $prefix . 'page_sidebar',
		'type'       => 'select',
		'options'     => array(
			'hidden-sidebar'   => esc_html__( 'Hide Sidebar', 'secondline-custom-plugin' ),
			'right-sidebar'    => esc_html__( 'Right', 'secondline-custom-plugin' ),
			'left-sidebar'    => esc_html__( 'Left', 'secondline-custom-plugin' ),
		),
	) );
	
	$secondline_themes_cmb_demo->add_field( array(
		'name' => esc_html__('Title Area Background Image', 'secondline-custom-plugin'),
		'id'         => $prefix . 'header_image',
		'type'         => 'file',
		'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
	) );
	
	$secondline_themes_cmb_demo->add_field( array(
		'name'       => esc_html__('Disable Title Area', 'secondline-custom-plugin'),
		'id'         => $prefix . 'disable_page_title',
		'type'       => 'checkbox',
	) );
	
}



add_action( 'cmb2_admin_init', 'secondline_themes_page_header_meta_box' );
function secondline_themes_page_header_meta_box() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = 'secondline_themes_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$secondline_themes_cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'metabox_page_header',
		'title'         => esc_html__('Display Settings', 'secondline-custom-plugin'),
		'object_types'  => array( 'page' ), // Post type,
	) );
		
	
	$secondline_themes_cmb_demo->add_field( array(
		'name'       => esc_html__('Disable Header', 'secondline-custom-plugin'),
		'id'         => $prefix . 'header_disabled',
		'type'       => 'checkbox',
	) );
	
	$secondline_themes_cmb_demo->add_field( array(
		'name'       => esc_html__('Disable Footer', 'secondline-custom-plugin'),
		'id'         => $prefix . 'disable_footer_per_page',
		'type'       => 'checkbox',
	) );


	
}



add_action( 'cmb2_admin_init', 'secondline_themes_index_post_meta_box' );
function secondline_themes_index_post_meta_box() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = 'secondline_themes_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$secondline_themes_cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'metabox_post',
		'title'         => esc_html__('Post Settings', 'secondline-custom-plugin'),
		'object_types'  => array( 'post', 'podcast', 'episode' ), // Post type
	) );
	
	$secondline_themes_cmb_demo->add_field( array(
		'name'       => esc_html__('Disable Featured Image on Post', 'secondline-custom-plugin'),
		'id'         => $prefix . 'disable_img',
		'type'       => 'checkbox',
	) );		
	
	$secondline_themes_cmb_demo->add_field( array(
		'name' => esc_html__('Image Gallery', 'secondline-custom-plugin'),
		'id'         => $prefix . 'gallery',
		'type'         => 'file_list',
		'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
	) );	
    
	$secondline_themes_cmb_demo->add_field( array(
		'name' => esc_html__('Title Area Background Image', 'secondline-custom-plugin'),
		'id'         => $prefix . 'header_image',
		'type'         => 'file',
		'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
	) );    	
	
	$secondline_themes_cmb_demo->add_field( array(
		'name' => esc_html__('External Embed Code (SoundCloud, Libsyn, MixCloud etc.) ', 'secondline-custom-plugin'),
		'id'         => $prefix . 'external_embed',
		'type'       => 'textarea_code',
		'options' => array( 'disable_codemirror' => true ),
	) );	
	
	$secondline_themes_cmb_demo->add_field( array(
		'name' => esc_html__('Episode Number', 'secondline-custom-plugin'),
		'id'         => $prefix . 'episode_number',
		'type'       => 'text',
		'attributes'  => array(
			'type'	=> 'number',
			'min' 	=> '0',
		),
	) );

	$secondline_themes_cmb_demo->add_field( array(
		'name' => esc_html__('Season Number', 'secondline-custom-plugin'),
		'id'         => $prefix . 'season_number',
		'type'       => 'text',
		'attributes'  => array(
			'type'	=> 'number',
			'min' 	=> '0',
		),
	) );	

	
	if ( function_exists( 'tusant_secondline_theme_active' ) || function_exists( 'bolden_secondline_theme_active' ) ) {	
		$secondline_themes_cmb_demo->add_field( array(
			'name' => esc_html__('Parent Show Post', 'secondline-custom-plugin'),
			'desc'           => 'Choose the main Show post that this episode belongs to. This would change the type of the header to display the show data above the actual episode.',
			'id'         => $prefix . 'parent_show_post',
			'type'       => 'select',
			'show_option_none' => true,
			'default'          => 'custom',
			'options_cb'          => 'secondline_get_your_post_type_post_options',
		) );		
	}
}

add_action( 'cmb2_admin_init', 'secondline_themes_ecommerce_meta_box' );
function secondline_themes_ecommerce_meta_box() {

	// Start with an underscore to hide fields from custom fields list
	$prefix = 'secondline_themes_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$secondline_themes_cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'metabox_post_product',
		'title'         => esc_html__('Product Settings', 'secondline-custom-plugin'),
		'object_types'  => array( 'product', 'download' ), // Post type
	) );
	
	$secondline_themes_cmb_demo->add_field( array(
		'name'       => esc_html__('Disable Featured Image', 'secondline-custom-plugin'),
		'id'         => $prefix . 'disable_img',
		'type'       => 'checkbox',
	) );		
    
	$secondline_themes_cmb_demo->add_field( array(
		'name' => esc_html__('Title Area Background Image', 'secondline-custom-plugin'),
		'id'         => $prefix . 'header_image',
		'type'         => 'file',
		'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
	) );    	
}

add_action( 'cmb2_admin_init', 'secondline_themes_index_show_meta_box' );
function secondline_themes_index_show_meta_box() {
	if ( function_exists( 'tusant_secondline_theme_active' ) || function_exists( 'bolden_secondline_theme_active' ) ) {
		// Start with an underscore to hide fields from custom fields list
		$prefix = 'secondline_themes_';

		/**
		 * Sample metabox to demonstrate each field type included
		 */
		$secondline_themes_cmb_demo = new_cmb2_box( array(
			'id'            => $prefix . 'metabox_show',
			'title'         => esc_html__('Show Settings', 'secondline-custom-plugin'),
			'object_types'  => array( 'secondline_shows' ), // Post type
		) );
		
		$secondline_themes_cmb_demo->add_field( array(
			'name'       => esc_html__('Disable Featured Image on Header', 'secondline-custom-plugin'),
			'desc'           => 'Enable/Disable the featured image that shows up on the single show page inside the header.',
			'id'         => $prefix . 'disable_img',
			'default'	 => false,
			'type'       => 'checkbox',
		) );		
		
		$secondline_themes_cmb_demo->add_field( array(
			'name' => esc_html__('Title Area Background Image', 'secondline-custom-plugin'),
			'desc'           => 'Insert the background image here. This would show up on the single show page as a background of the header.',
			'id'         => $prefix . 'header_image',
			'type'         => 'file',
			'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
		) );    	
		
		$secondline_themes_cmb_demo->add_field( array(
			'name'       => esc_html__('Header Show Description', 'secondline-custom-plugin'),
			'desc'           => 'Insert a short description here. This would show up on the single show page inside the header.',
			'id'         => $prefix . 'show_short_desc',
			'type'       => 'textarea_small',
		) );		
			
		if ( function_exists( 'ssp_get_upload_directory' ) ) {
			
			$secondline_themes_cmb_demo->add_field( array(
				'name'           => 'Podcast Series/Category To Display',
				'desc'           => 'Select the Podcast series/category that should be linked with this show. This would automatically display all related episodes inside the show page.',
				'id'             => $prefix . 'show_category_selection',
				'type'           => 'multicheck_inline',
				'options_cb'     => 'secondline_themes_addons_show_categories_ssp',
				'get_terms_args' => array(
					'taxonomy'   => 'series',
					'hide_empty' => false,
					'post_type'	 => 'podcast',
				),
				'select_all_button' => false,
			) );			
			
			
		} else {
		
			$secondline_themes_cmb_demo->add_field( array(
				'name'           => 'Post Category To Display',
				'desc'           => 'Select the post category (or categories) that should be linked with this show. This would automatically display all related episodes inside the show page.',
				'id'             => $prefix . 'show_category_selection',
				'type'           => 'multicheck_inline',
				'options_cb'     => 'secondline_get_term_options',
				'get_terms_args' => array(
					'taxonomy'   => 'category',
					'hide_empty' => false,
					'post_type'	 => 'post',
				),
				'select_all_button' => false,
			) );	
		}
		
		$secondline_themes_cmb_demo->add_field( array(
			'name'       => esc_html__('Disable Episode List on Show Page?', 'secondline-custom-plugin'),
			'desc'           => 'Enable/Disable the automatic list of episodes that appears on the single show page.',
			'id'         => $prefix . 'disable_list',
			'default'	 => false,
			'type'       => 'checkbox',
		) );		
		
		$secondline_themes_cmb_demo->add_field( array(
			'name'       => esc_html__('Show Hosts', 'secondline-custom-plugin'),
			'desc'           => 'Insert the name (names) of the show host (hosts) here, example: Jon Doe & Linda Doe',
			'id'         => $prefix . 'show_hosts',
			'type'       => 'text',
		) );		
		
		$secondline_themes_cmb_demo->add_field( array(
			'name'       => esc_html__('Show Hosts Avatar', 'secondline-custom-plugin'),
			'desc'           => 'Insert one image of the show hosts. (Recommended dimensions of 150x150 px)',
			'id'         => $prefix . 'show_hosts_img',
			'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
			'type'       => 'file',
		) );	

		$secondline_themes_cmb_demo->add_field( array(
			'name'       => esc_html__('Show Website Link', 'secondline-custom-plugin'),
			'desc'           => 'Insert the URL of the shows separate website. (Optional)',
			'id'         => $prefix . 'show_website',
			'type'       => 'text_url',
		) );		
		
		$secondline_themes_cmb_demo->add_field( array(
			'name'       => esc_html__('Show RSS Feed Link', 'secondline-custom-plugin'),
			'desc'           => 'Add an RSS link to your website header to comply with Google Podcasts (Optional, recommended)',
			'id'         => $prefix . 'show_rss_feed',
			'type'       => 'text_url',
		) );		
	}
}


add_action( 'cmb2_admin_init', 'secondline_themes_index_show_social_meta_box' );
function secondline_themes_index_show_social_meta_box() {

	if ( function_exists( 'tusant_secondline_theme_active' ) || function_exists( 'bolden_secondline_theme_active' ) ) {
	
		// Start with an underscore to hide fields from custom fields list
		$prefix = 'secondline_themes_';

		/**
		 * Sample metabox to demonstrate each field type included
		 */
		$secondline_themes_cmb_demo = new_cmb2_box( array(
			'id'            => $prefix . 'metabox_show_subscribe',
			'title'         => esc_html__('Subscribe & Social Links', 'secondline-custom-plugin'),
			'object_types'  => array( 'secondline_shows' ), // Post type
		) );
		
		$secondline_themes_cmb_demo->add_field( array(
			'name'       => esc_html__('Disable Subscribe Button?', 'secondline-custom-plugin'),
			'desc'           => 'Enable/Disable the subscribe button',
			'id'         => $prefix . 'show_subscribe_button',
			'default'	 => false,
			'type'       => 'checkbox',
		) );	
		
		
		$slt_subscribe_group_field_id = $secondline_themes_cmb_demo->add_field( array(
			'id'          => $prefix . 'repeat_subscribe',
			'type'        => 'group',
			'description' => esc_attr__( 'Add Subscribe Button Links', 'secondline-custom-plugin' ),
			// 'repeatable'  => false, // use false if you want non-repeatable group
			'options'     => array(
				'group_title'   => esc_attr__( 'Subscribe Link {#}', 'secondline-custom-plugin' ), // since version 1.1.4, {#} gets replaced by row number
				'add_button'    => esc_attr__( 'Add Another Link', 'secondline-custom-plugin' ),
				'remove_button' => esc_attr__( 'Remove Link', 'secondline-custom-plugin' ),
				'sortable'      => true, // beta
				'closed'		=> true,
			),
		) );

		// Id's for group's fields only need to be unique for the group. Prefix is not needed.
		$secondline_themes_cmb_demo->add_group_field( $slt_subscribe_group_field_id, array(
			'name' => 'Subscribe Platform',
			'id'   => $prefix . 'subscribe_platform',
			'type' => 'select',
			'options' => array(
			'Acast' => esc_attr__( 'Acast', 'secondline-custom-plugin' ),
			'Amazon-Alexa' => esc_attr__( 'Amazon Alexa', 'secondline-custom-plugin' ),
			'Anchor' => esc_attr__( 'Anchor', 'secondline-custom-plugin' ),
			'Apple-Podcasts' => esc_attr__( 'Apple Podcasts', 'secondline-custom-plugin' ),
			'Blubrry' => esc_attr__( 'Blubrry', 'secondline-custom-plugin' ),
			'Breaker' => esc_attr__( 'Breaker', 'secondline-custom-plugin' ),
			'Bullhorn' => esc_attr__( 'Bullhorn', 'secondline-custom-plugin' ),
			'CastBox' => esc_attr__( 'Castbox', 'secondline-custom-plugin' ),
			'Castro' => esc_attr__( 'Castro', 'secondline-custom-plugin' ),
			'Deezer' => esc_attr__( 'Deezer', 'secondline-custom-plugin' ),
			'Downcast' => esc_attr__( 'Downcast', 'secondline-custom-plugin' ),
			'Google-Play' => esc_attr__( 'Google Play', 'secondline-custom-plugin' ),			
			'Google-Podcasts' => esc_attr__( 'Google Podcasts', 'secondline-custom-plugin' ),
			'iHeartRadio' => esc_attr__( 'iHeartRadio', 'secondline-custom-plugin' ),					
			'iTunes' => esc_attr__( 'iTunes', 'secondline-custom-plugin' ),			
			'Laughable' => esc_attr__( 'Laughable', 'secondline-custom-plugin' ),
			'Libsyn' => esc_attr__( 'Libsyn', 'secondline-custom-plugin' ),
			'Listen-Notes' => esc_attr__( 'Listen Notes', 'secondline-custom-plugin' ),
			'Miro' => esc_attr__( 'Miro', 'secondline-custom-plugin' ),
			'MixCloud' => esc_attr__( 'MixCloud', 'secondline-custom-plugin' ),
			'MyTuner-Radio' => esc_attr__( 'MyTuner Radio', 'secondline-custom-plugin' ),
			'Overcast' => esc_attr__( 'Overcast', 'secondline-custom-plugin' ),
			'OwlTail' => esc_attr__( 'OwlTail', 'secondline-custom-plugin' ),
			'Pandora' => esc_attr__( 'Pandora', 'secondline-custom-plugin' ),
			'Player.fm' => esc_attr__( 'Player.fm', 'secondline-custom-plugin' ),			
			'Plex' => esc_attr__( 'Plex', 'secondline-custom-plugin' ),			
			'PocketCasts' => esc_attr__( 'PocketCasts', 'secondline-custom-plugin' ),		
			'Podbean' => esc_attr__( 'Podbean', 'secondline-custom-plugin' ),			
			'Podcast.de' => esc_attr__( 'Podcast.de', 'secondline-custom-plugin' ),			
			'Podcast-Addict' => esc_attr__( 'Podcast Addict', 'secondline-custom-plugin' ),
			'Podcast-Republic' => esc_attr__( 'Podcast Republic', 'secondline-custom-plugin' ),
			'Podchaser' => esc_attr__( 'Podchaser', 'secondline-custom-plugin' ),
			'Podcoin' => esc_attr__( 'Podcoin', 'secondline-custom-plugin' ),
			'Podkicker' => esc_attr__( 'Podkicker', 'secondline-custom-plugin' ),
			'Podknife' => esc_attr__( 'Podknife', 'secondline-custom-plugin' ),
			'Podtail' => esc_attr__( 'Podtail', 'secondline-custom-plugin' ),
			'Radio-Public' => esc_attr__( 'Radio Public', 'secondline-custom-plugin' ),
			'RedCircle' => esc_attr__( 'RedCircle', 'secondline-custom-plugin' ),
			'RSS' => esc_attr__( 'RSS', 'secondline-custom-plugin' ),
			'RSSRadio' => esc_attr__( 'RSSRadio', 'secondline-custom-plugin' ),
			'SoundCloud' => esc_attr__( 'SoundCloud', 'secondline-custom-plugin' ),
			'Spotify' => esc_attr__( 'Spotify', 'secondline-custom-plugin' ),
			'Spreaker' => esc_attr__( 'Spreaker', 'secondline-custom-plugin' ),
			'Stitcher' => esc_attr__( 'Stitcher', 'secondline-custom-plugin' ),
			'The-Podcast-App' => esc_attr__( 'The Podcast App', 'secondline-custom-plugin' ),
			'TuneIn' => esc_attr__( 'TuneIn', 'secondline-custom-plugin' ),
			'VKontakte' => esc_attr__( 'VKontakte', 'secondline-custom-plugin' ),
			'We.fo' => esc_attr__( 'We.fo', 'secondline-custom-plugin' ),
			'Yandex' => esc_attr__( 'Yandex', 'secondline-custom-plugin' ),
			'YouTube' => esc_attr__( 'YouTube', 'secondline-custom-plugin' ),
			'custom' => esc_attr__( 'Custom Link', 'secondline-custom-plugin' ),
			),		
			//'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
		) );

		$secondline_themes_cmb_demo->add_group_field( $slt_subscribe_group_field_id, array(
			'name' => 'Link',
			'id'   => $prefix . 'subscribe_url',
			'type' => 'text_url',
		) );
		
		$secondline_themes_cmb_demo->add_group_field( $slt_subscribe_group_field_id, array(
			'name' => 'Custom Link - Label',
			'description' => 'Works only for the "Custom" link.',
			'id'   => $prefix . 'custom_link_label',
			'type' => 'text',
		) );
			
		
		
		
		
		$slt_social_group_field_id = $secondline_themes_cmb_demo->add_field( array(
			'id'          => $prefix . 'repeat_social',
			'type'        => 'group',
			'description' => esc_attr__( 'Add Social Icon Links', 'secondline-custom-plugin' ),
			'options'     => array(
				'group_title'   => esc_attr__( 'Social Icon {#}', 'secondline-custom-plugin' ), // since version 1.1.4, {#} gets replaced by row number
				'add_button'    => esc_attr__( 'Add Another Icon', 'secondline-custom-plugin' ),
				'remove_button' => esc_attr__( 'Remove Icon', 'secondline-custom-plugin' ),
				'sortable'      => true, // beta
				'closed'		=> true,
			),
		) );

		// Add new field
		$secondline_themes_cmb_demo->add_group_field( $slt_social_group_field_id, array(
		  'name'        => __( 'Select Icon', 'textdomain' ),
		  'id'   		=> $prefix . 'social_icon',
		  'type'        => 'fontawesome_icon', // This field type
		) );

		$secondline_themes_cmb_demo->add_group_field( $slt_social_group_field_id, array(
			'name' => 'Link',
			'id'   => $prefix . 'social_url',
			'type' => 'text_url',
		) );
			
	}		
}




add_action( 'cmb2_admin_init', 'secondline_user_meta_box' );
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function secondline_user_meta_box() {
	
	// Start with an underscore to hide fields from custom fields list
	$prefix = 'secondline_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$secondline_cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'user_author_info',
		'title'         => esc_html__('Author Settings', 'secondline-custom-plugin'),
		'object_types'     => array( 'user' ), // Tells CMB2 to use user_meta vs post_meta

	) );
	
	$secondline_cmb_demo->add_field( array(
		'name'     => esc_html__( 'Author Information', 'secondline-custom-plugin' ),
		'id'       => $prefix . 'extra_info',
		'type'     => 'title',
		'on_front' => false,
	) );
	

	$secondline_cmb_demo->add_field( array(
		'name' => esc_html__( 'Author Sub-headline', 'secondline-custom-plugin' ),
		'desc' => esc_html__( 'Leave blank to hide this field', 'secondline-custom-plugin' ),
		'id'   => $prefix . 'user_sub_headline',
		'type' => 'text',
	) );
	
	$secondline_cmb_demo->add_field( array(
		'name' => esc_html__( 'Author Website URL', 'secondline-custom-plugin' ),
		'desc' => esc_html__( 'Leave blank to hide this field', 'secondline-custom-plugin' ),
		'id'   => $prefix . 'authorurl',
		'type' => 'text_url',
	) );

	$secondline_cmb_demo->add_field( array(
		'name' => esc_html__( 'Facebook URL', 'secondline-custom-plugin' ),
		'desc' => esc_html__( 'Leave blank to hide this field', 'secondline-custom-plugin' ),
		'id'   => $prefix . 'facebookurl',
		'type' => 'text_url',
	) );

	$secondline_cmb_demo->add_field( array(
		'name' => esc_html__( 'Twitter URL', 'secondline-custom-plugin' ),
		'desc' => esc_html__( 'Leave blank to hide this field', 'secondline-custom-plugin' ),
		'id'   => $prefix . 'twitterurl',
		'type' => 'text_url',
	) );
	
	$secondline_cmb_demo->add_field( array(
		'name' => esc_html__( 'Dribbble URL', 'secondline-custom-plugin' ),
		'desc' => esc_html__( 'Leave blank to hide this field', 'secondline-custom-plugin' ),
		'id'   => $prefix . 'dribbbleurlurl',
		'type' => 'text_url',
	) );


	$secondline_cmb_demo->add_field( array(
		'name' => esc_html__( 'Linkedin URL', 'secondline-custom-plugin' ),
		'desc' => esc_html__( 'Leave blank to hide this field', 'secondline-custom-plugin' ),
		'id'   => $prefix . 'linkedinurl',
		'type' => 'text_url',
	) );
	
	$secondline_cmb_demo->add_field( array(
		'name' => esc_html__( 'Pinterest URL', 'secondline-custom-plugin' ),
		'desc' => esc_html__( 'Leave blank to hide this field', 'secondline-custom-plugin' ),
		'id'   => $prefix . 'pinteresturl',
		'type' => 'text_url',
	) );
	
	$secondline_cmb_demo->add_field( array(
		'name' => esc_html__( 'MixCloud URL', 'secondline-custom-plugin' ),
		'desc' => esc_html__( 'Leave blank to hide this field', 'secondline-custom-plugin' ),
		'id'   => $prefix . 'mixcloudurl',
		'type' => 'text_url',
	) );
	
	
	$secondline_cmb_demo->add_field( array(
		'name' => esc_html__( 'Google+ URL', 'secondline-custom-plugin' ),
		'desc' => esc_html__( 'Leave blank to hide this field', 'secondline-custom-plugin' ),
		'id'   => $prefix . 'googleplusurl',
		'type' => 'text_url',
	) );
	
	$secondline_cmb_demo->add_field( array(
		'name' => esc_html__( 'Instagram URL', 'secondline-custom-plugin' ),
		'desc' => esc_html__( 'Leave blank to hide this field', 'secondline-custom-plugin' ),
		'id'   => $prefix . 'instagramurl',
		'type' => 'text_url',
	) );
	
	

	
	$secondline_cmb_demo->add_field( array(
		'name' => esc_html__( 'Youtube URL', 'secondline-custom-plugin' ),
		'desc' => esc_html__( 'Leave blank to hide this field', 'secondline-custom-plugin' ),
		'id'   => $prefix . 'youtubeurl',
		'type' => 'text_url',
	) );
	


	$secondline_cmb_demo->add_field( array(
		'name' => esc_html__( 'Vimeo URL', 'secondline-custom-plugin' ),
		'desc' => esc_html__( 'Leave blank to hide this field', 'secondline-custom-plugin' ),
		'id'   => $prefix . 'vimeourl',
		'type' => 'text_url',
	) );
	
	$secondline_cmb_demo->add_field( array(
		'name' => esc_html__( 'Soundcloud URL', 'secondline-custom-plugin' ),
		'desc' => esc_html__( 'Leave blank to hide this field', 'secondline-custom-plugin' ),
		'id'   => $prefix . 'soundcloudurl',
		'type' => 'text_url',
	) );
	
	
	$secondline_cmb_demo->add_field( array(
		'name' => esc_html__( 'MixCloud URL', 'secondline-custom-plugin' ),
		'desc' => esc_html__( 'Leave blank to hide this field', 'secondline-custom-plugin' ),
		'id'   => $prefix . 'mixcloudurl',
		'type' => 'text_url',
	) );

	
	
	
	$secondline_cmb_demo->add_field( array(
		'name' => esc_html__( 'E-mail Address', 'secondline-custom-plugin' ),
		'desc' => esc_html__( 'Leave blank to hide this field', 'secondline-custom-plugin' ),
		'id'   => $prefix . 'emailmailto',
		'type' => 'text',
	) );
	

}




