<?php
/**
 * SecondLine Theme Customizer
 *
 * @package slt
 */

get_template_part('inc/customizer/new', 'controls');
get_template_part('inc/customizer/typography', 'controls');


/* Remove Default Theme Customizer Panels that aren't useful */
function secondline_themes_change_default_customizer_panels ( $wp_customize ) {
	$wp_customize->remove_section("themes"); //Remove Active Theme + Theme Changer
	$wp_customize->remove_section("static_front_page"); // Remove Front Page Section		
}
add_action( "customize_register", "secondline_themes_change_default_customizer_panels" );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function secondline_themes_customize_preview_js() {
	wp_enqueue_script( 'secondline_themes_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'secondline_themes_customize_preview_js' );


function secondline_themes_customizer( $wp_customize ) {
	
	
	/* Panel - General */
	$wp_customize->add_panel( 'secondline_themes_general_panel', array(
		'priority'    => 3,
		'title'       => esc_html__( 'General', 'dixie-secondline' ),
		 ) 
 	);
	
	
	/* Section - General - General Layout */
	$wp_customize->add_section( 'secondline_themes_section_general_layout', array(
		'title'          => esc_html__( 'General Options', 'dixie-secondline' ),
		'panel'          => 'secondline_themes_general_panel', // Not typically needed.
		'priority'       => 10,
		) 
	);
	
	
	/* Setting - General - General Layout */
	$wp_customize->add_setting('secondline_themes_site_width',array(
		'default' => '1400',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_site_width', array(
		'label'    => esc_html__( 'Site Width(px)', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_general_layout',
		'priority'   => 15,
		'choices'     => array(
			'min'  => 961,
			'max'  => 3500,
			'step' => 1
		), ) ) 
	);
	
	
	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'secondline_themes_select_color', array(
		'default'	=> '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_select_color', array(
		'label'    => esc_html__( 'Mouse Selection Color', 'dixie-secondline' ),
		'section'  => 'secondline_themes_section_general_layout',
		'priority'   => 20,
		)) 
	);
	
	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'secondline_themes_select_bg', array(
		'default'	=> '#263669',
		'sanitize_callback' => 'secondline_themes_sanitize_customizer',
	) );
	$wp_customize->add_control(new secondline_themes_Customize_Alpha_Color_Control($wp_customize, 'secondline_themes_select_bg', array(
		'default'	=> '#263669',
		'label'    => esc_html__( 'Mouse Selection Background', 'dixie-secondline' ),
		'section'  => 'secondline_themes_section_general_layout',
		'priority'   => 25,
		)) 
	);
	
			
	/* Section - Blog - Blog Index Post Options */
   $wp_customize->add_section( 'secondline_themes_section_image_option', array(
   	'title'          => esc_html__( 'Theme Image Options', 'dixie-secondline' ),
   	'panel'          => 'secondline_themes_general_panel', // Not typically needed.
   	'priority'       => 99,
   ));				
   
   
	/* Setting - General - Site Logo */
	$wp_customize->add_setting( 'secondline_themes_image_cropping' ,array(
		'default' => 'secondline-themes-crop',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_image_cropping', array(
		'label'    => esc_html__( 'Featured Image Cropping', 'dixie-secondline' ),
		'section'  => 'secondline_themes_section_image_option',
		'priority'   => 10,
		'choices'     => array(
			'secondline-themes-crop' => esc_html__( 'Crop Images', 'dixie-secondline' ),
			'secondline-themes-uncrop' => esc_html__( 'Do Not Crop', 'dixie-secondline' ),
		),
		))
	);  	
	
	
	/* Panel - Header */
	$wp_customize->add_panel( 'secondline_themes_header_panel', array(
		'priority'    => 5,
		'title'       => esc_html__( 'Header', 'dixie-secondline' ),
		) 
	);
	
	/* Setting - Header - Page Builder */
	$wp_customize->add_section( 'secondline_themes_header_section_builder', array(
		'title'          => esc_html__( 'Header Page Builder', 'dixie-secondline' ),
		'panel'          => 'secondline_themes_header_panel', // Not typically needed.
		'priority'       => 9,
		) 
	);	
	
	/* Setting - Header Elementor
	https://gist.github.com/ajskelton/27369df4a529ac38ec83980f244a7227
	*/
	$secondline_themes_elementor_library_list =  array(
		'' => 'Choose a template',
	);
	$secondline_themes_elementor_args = array('post_type' => 'elementor_library', 'posts_per_page' => 99);
	$secondline_themes_elementor_posts = get_posts( $secondline_themes_elementor_args );
	foreach($secondline_themes_elementor_posts as $secondline_themes_elementor_post) {
	    $secondline_themes_elementor_library_list[$secondline_themes_elementor_post->ID] = $secondline_themes_elementor_post->post_title;
	}

	$wp_customize->add_setting( 'secondline_themes_header_elementor_library' ,array(
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( 'secondline_themes_header_elementor_library', array(
	  'type' => 'select',
	  'section' => 'secondline_themes_header_section_builder',
	  'priority'   => 5,
	  'label'    => esc_html__( 'Header Elementor Template', 'dixie-secondline' ),
	  'description'    => esc_html__( 'You can add/edit your Header teamplate under ', 'dixie-secondline') . '<a href="' . admin_url() . 'edit.php?post_type=elementor_library">Elementor > My Library</a>',
	  'choices'  => 	   $secondline_themes_elementor_library_list,
	) );	
	
	
	/* Section - General - Site Logo */
	$wp_customize->add_section( 'secondline_themes_section_logo', array(
		'title'          => esc_html__( 'Logo', 'dixie-secondline' ),
		'panel'          => 'secondline_themes_header_panel', // Not typically needed.
		'priority'       => 10,
		) 
	);
	
	/* Setting - General - Site Logo */
	$wp_customize->add_setting( 'secondline_themes_theme_logo' ,array(
		'default' => get_template_directory_uri().'/images/logo.png',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'secondline_themes_theme_logo', array(
		'section' => 'secondline_themes_section_logo',
		'priority'   => 10,
		))
	);
	
	/* Setting - General - Site Logo */
	$wp_customize->add_setting('secondline_themes_theme_logo_width',array(
		'default' => '123',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_theme_logo_width', array(
		'label'    => esc_html__( 'Logo Width (px)', 'dixie-secondline' ),
		'section'  => 'secondline_themes_section_logo',
		'priority'   => 15,
		'choices'     => array(
			'min'  => 0,
			'max'  => 1200,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - General - Site Logo */
	$wp_customize->add_setting('secondline_themes_theme_logo_margin_top',array(
		'default' => '23',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_theme_logo_margin_top', array(
		'label'    => esc_html__( 'Logo Margin Top (px)', 'dixie-secondline' ),
		'section'  => 'secondline_themes_section_logo',
		'priority'   => 20,
		'choices'     => array(
			'min'  => 0,
			'max'  => 250,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - General - Site Logo */
	$wp_customize->add_setting('secondline_themes_theme_logo_margin_bottom',array(
		'default' => '25',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_theme_logo_margin_bottom', array(
		'label'    => esc_html__( 'Logo Margin Bottom (px)', 'dixie-secondline' ),
		'section'  => 'secondline_themes_section_logo',
		'priority'   => 25,
		'choices'     => array(
			'min'  => 0,
			'max'  => 250,
			'step' => 1
		), ) ) 
	);
	

	
	/* Setting - General - Site Logo */
	$wp_customize->add_setting( 'secondline_themes_logo_position' ,array(
		'default' => 'secondline-themes-logo-position-left',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_logo_position', array(
		'label'    => esc_html__( 'Logo Position', 'dixie-secondline' ),
		'section'  => 'secondline_themes_section_logo',
		'priority'   => 50,
		'choices'     => array(
			'secondline-themes-logo-position-left' => esc_html__( 'Left', 'dixie-secondline' ),
			'secondline-themes-logo-position-center' => esc_html__( 'Center (Block)', 'dixie-secondline' ),
			'secondline-themes-logo-position-right' => esc_html__( 'Right', 'dixie-secondline' ),
		),
		))
	);
	


	/* Section - Header - Header Options */
	$wp_customize->add_section( 'secondline_themes_section_header_bg', array(
		'title'          => esc_html__( 'Header Options', 'dixie-secondline' ),
		'panel'          => 'secondline_themes_header_panel', // Not typically needed.
		'priority'       => 20,
		) 
	);

	
	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'secondline_themes_header_width' ,array(
		'default' => 'secondline-themes-header-normal-width',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_header_width', array(
		'label'    => esc_html__( 'Header Layout', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_bg',
		'priority'   => 10,
		'choices'     => array(
			'secondline-themes-header-full-width' => esc_html__( 'Wide', 'dixie-secondline' ),
			'secondline-themes-header-full-width-no-gap' => esc_html__( 'Full-Width', 'dixie-secondline' ),
			'secondline-themes-header-normal-width' => esc_html__( 'Default', 'dixie-secondline' ),
		),
		))
	);
    
    
	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'secondline_themes_header_floating' ,array(
		'default' => 'secondline-themes-header-float',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_header_floating', array(
		'label'    => esc_html__( 'Floating Header', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_bg',
		'priority'   => 10,
		'choices'     => array(
			'secondline-themes-header-float' => esc_html__( 'Enabled', 'dixie-secondline' ),
			'secondline-themes-header-regular' => esc_html__( 'Disabled', 'dixie-secondline' ),
		),
		))
	);    
	


	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'secondline_themes_header_background_color', array(
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Customize_Alpha_Color_Control($wp_customize, 'secondline_themes_header_background_color', array(
		'label'    => esc_html__( 'Header Background Color', 'dixie-secondline' ),
		'section'  => 'secondline_themes_section_header_bg',
		'priority'   => 15,
		)) 
	);
	
	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'secondline_themes_header_border_bottom_color', array(
		'default' =>  'rgba(255,255,255, 0.1)',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Customize_Alpha_Color_Control($wp_customize, 'secondline_themes_header_border_bottom_color', array(
		'default' =>  'rgba(255,255,255, 0.1)',
		'label'    => esc_html__( 'Header Boder Bottom Color', 'dixie-secondline' ),
		'section'  => 'secondline_themes_section_header_bg',
		'priority'   => 16,
		)) 
	);
	
		
	
	/* Setting - General - Page Title */
	$wp_customize->add_setting( 'secondline_themes_header_bg_image' ,array(	
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'secondline_themes_header_bg_image', array(
		'label'    => esc_html__( 'Header Background Image', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_bg',
		'priority'   => 40,
		))
	);
	
	
	
	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'secondline_themes_header_bg_image_image_position' ,array(
		'default' => 'cover',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_header_bg_image_image_position', array(
		'label'    => esc_html__( 'Image Cover', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_bg',
		'priority'   => 50,
		'choices'     => array(
			'cover' => esc_html__( 'Image Cover', 'dixie-secondline' ),
			'repeat-all' => esc_html__( 'Image Pattern', 'dixie-secondline' ),
		),
		))
	);
		
	
	/* Section - Header - Tablet/Mobile Header Options */
	$wp_customize->add_section( 'secondline_themes_section_mobile_header', array(
		'title'          => esc_html__( 'Tablet/Mobile Header Options', 'dixie-secondline' ),
		'panel'          => 'secondline_themes_header_panel', // Not typically needed.
		'priority'       => 23,
		) 
	);
	
	

	
	/* Section - Header - Tablet/Mobile Header Options */
	$wp_customize->add_setting( 'secondline_themes_mobile_header_transparent' ,array(
		'default' => 'default',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_mobile_header_transparent', array(
		'label'    => esc_html__( 'Tablet/Mobile Header Transparent', 'dixie-secondline' ),
		'section'  => 'secondline_themes_section_mobile_header',
		'priority'   => 9,
		'choices'     => array(
			'transparent' => esc_html__( 'Transparent', 'dixie-secondline' ),
			'default' => esc_html__( 'Default', 'dixie-secondline' ),
		),
		))
	);
	
	
	/* Section - Header - Tablet/Mobile Header Options */
	$wp_customize->add_setting( 'secondline_themes_mobile_header_bg', array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_mobile_header_bg', array(
		'label'    => esc_html__( 'Tablet/Mobile Background Color', 'dixie-secondline' ),
		'section'  => 'secondline_themes_section_mobile_header',
		'priority'   => 10,
		)) 
	);
	
	
	/* Section - Header - Tablet/Mobile Header Options */
	$wp_customize->add_setting( 'secondline_themes_mobile_menu_text' ,array(
		'default' => 'off',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_mobile_menu_text', array(
		'label'    => esc_html__( 'Display "Menu" text for Menu', 'dixie-secondline' ),
		'section'  => 'secondline_themes_section_mobile_header',
		'priority'   => 11,
		'choices'     => array(
			'on' => esc_html__( 'Display', 'dixie-secondline' ),
			'off' => esc_html__( 'Hide', 'dixie-secondline' ),
		),
		))
	);
	
	
	
	/* Section - Header - Tablet/Mobile Header Options */
	$wp_customize->add_setting( 'secondline_themes_mobile_top_bar_left' ,array(
		'default' => 'secondline_themes_hide_top_left_bar',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_mobile_top_bar_left', array(
		'label'    => esc_html__( 'Tablet/Mobile Header Top Left', 'dixie-secondline' ),
		'section'  => 'secondline_themes_section_mobile_header',
		'priority'   => 12,
		'choices'     => array(
			'on-slt' => esc_html__( 'Display', 'dixie-secondline' ),
			'secondline_themes_hide_top_left_bar' => esc_html__( 'Hide', 'dixie-secondline' ),
		),
		))
	);
	
	/* Section - Header - Tablet/Mobile Header Options */
	$wp_customize->add_setting( 'secondline_themes_mobile_top_bar_right' ,array(
		'default' => 'secondline_themes_hide_top_left_right',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_mobile_top_bar_right', array(
		'label'    => esc_html__( 'Tablet/Mobile Header Top Right', 'dixie-secondline' ),
		'section'  => 'secondline_themes_section_mobile_header',
		'priority'   => 13,
		'choices'     => array(
			'on-slt' => esc_html__( 'Display', 'dixie-secondline' ),
			'secondline_themes_hide_top_left_right' => esc_html__( 'Hide', 'dixie-secondline' ),
		),
		))
	);

	
	
	/* Section - Header - Tablet/Mobile Header Options */
	$wp_customize->add_setting( 'secondline_themes_mobile_header_nav_padding' ,array(
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( 'secondline_themes_mobile_header_nav_padding', array(
		'label'    => esc_html__( 'Tablet/Mobile Nav Padding', 'dixie-secondline' ),
		'description'    => esc_html__( 'Optional padding above/below the Navigation. Example: 20', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_mobile_header',
		'type' => 'text',
		'priority'   => 25,
		)
	);
	
	
	/* Section - Header - Tablet/Mobile Header Options */
	$wp_customize->add_setting( 'secondline_themes_mobile_header_logo_width' ,array(
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( 'secondline_themes_mobile_header_logo_width', array(
		'label'    => esc_html__( 'Tablet/Mobile Logo Width', 'dixie-secondline' ),
		'description'    => esc_html__( 'Optional logo width. Example: 180', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_mobile_header',
		'type' => 'text',
		'priority'   => 30,
		)
	);
	
	
	
	/* Section - Header - Tablet/Mobile Header Options */
	$wp_customize->add_setting( 'secondline_themes_mobile_header_logo_margin' ,array(
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( 'secondline_themes_mobile_header_logo_margin', array(
		'label'    => esc_html__( 'Tablet/Mobile Logo Margin Top/Bottom', 'dixie-secondline' ),
		'description'    => esc_html__( 'Optional logo margin. Example: 25', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_mobile_header',
		'type' => 'text',
		'priority'   => 35,
		)
	);
	
	
	
	
	
	
	/* Section - Header - Fixed Header */
	$wp_customize->add_section( 'secondline_themes_section_fixed_nav', array(
		'title'          => esc_html__( 'Fixed (Sticky) Header Options', 'dixie-secondline' ),
		'panel'          => 'secondline_themes_header_panel', // Not typically needed.
		'priority'       => 25,
		) 
	);
	
	/* Setting - Header - Fixed Header */
	$wp_customize->add_setting( 'secondline_themes_header_fixed' ,array(
		'default' => 'none-fixed-slt',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_header_fixed', array(
		'section' => 'secondline_themes_section_fixed_nav',
		'priority'   => 10,
		'choices'     => array(
			'fixed-slt' => esc_html__( 'Fixed (Sticky) Header', 'dixie-secondline' ),
			'none-fixed-slt' => esc_html__( 'Disable Fixed Header', 'dixie-secondline' ),
		),
		))
	);
	
	/* Setting - Header - Fixed Header */
	$wp_customize->add_setting( 'secondline_themes_fixed_nav_background_color', array(
		'default' =>  'rgba(255,255,255, 0.7)',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Customize_Alpha_Color_Control($wp_customize, 'secondline_themes_fixed_nav_background_color', array(
		'default' =>  'rgba(255,255,255, 0.7)',
		'label'    => esc_html__( 'Fixed Header Background', 'dixie-secondline' ),
		'section'  => 'secondline_themes_section_fixed_nav',
		'priority'   => 15,
		)) 
	);
	
	/* Setting - Header - Fixed Header */
	$wp_customize->add_setting( 'secondline_themes_fixed_nav_border_color', array(
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
		'default' => 'rgba(0,0,0,0.15)'
	) );
	$wp_customize->add_control(new secondline_themes_Customize_Alpha_Color_Control($wp_customize, 'secondline_themes_fixed_nav_border_color', array(
		'label'    => esc_html__( 'Fixed Header Border Color', 'dixie-secondline' ),
		'section'  => 'secondline_themes_section_fixed_nav',
		'priority'   => 16,
		)) 
	);
	

	/* Setting - Header - Header Options */
	$wp_customize->add_setting( 'secondline_themes_header_drop_shadow' ,array(
		'default' => 'off',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_header_drop_shadow', array(
		'label'    => esc_html__( 'Fixed Header Shadow', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_fixed_nav',
		'priority'   => 17,
		'choices'     => array(
			'on' => esc_html__( 'On', 'dixie-secondline' ),
			'off' => esc_html__( 'Off', 'dixie-secondline' ),
		),
		))
	);
	
	

	
	
	/* Setting - Header - Fixed Header */
	$wp_customize->add_setting( 'secondline_themes_fixed_logo' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'secondline_themes_fixed_logo', array(
		'label'    => esc_html__( 'Fixed Logo', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_fixed_nav',
		'priority'   => 20,
		))
	);
	
	/* Setting - Header - Fixed Header */
	$wp_customize->add_setting('secondline_themes_fixed_logo_width',array(
		'default' => '0',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_fixed_logo_width', array(
		'label'    => esc_html__( 'Fixed Logo Width (px)', 'dixie-secondline' ),
		'description'    => esc_html__( 'Set option to 0 to ignore this field.', 'dixie-secondline' ),
		
		'section'  => 'secondline_themes_section_fixed_nav',
		'priority'   => 30,
		'choices'     => array(
			'min'  => 0,
			'max'  => 1200,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - Header - Fixed Header */
	$wp_customize->add_setting('secondline_themes_fixed_logo_margin_top',array(
		'default' => '0',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_fixed_logo_margin_top', array(
		'label'    => esc_html__( 'Fixed Logo Margin Top (px)', 'dixie-secondline' ),
		'description'    => esc_html__( 'Set option to 0 to ignore this field.', 'dixie-secondline' ),
		
		'section'  => 'secondline_themes_section_fixed_nav',
		'priority'   => 40,
		'choices'     => array(
			'min'  => 0,
			'max'  => 150,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - Header - Fixed Header */
	$wp_customize->add_setting('secondline_themes_fixed_logo_margin_bottom',array(
		'default' => '0',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_fixed_logo_margin_bottom', array(
		'label'    => esc_html__( 'Fixed Logo Margin Bottom (px)', 'dixie-secondline' ),
		'description'    => esc_html__( 'Set option to 0 to ignore this field.', 'dixie-secondline' ),
		
		'section'  => 'secondline_themes_section_fixed_nav',
		'priority'   => 50,
		'choices'     => array(
			'min'  => 0,
			'max'  => 150,
			'step' => 1
		), ) ) 
	);
	
	
	/* Setting - Header - Fixed Header */
	$wp_customize->add_setting('secondline_themes_fixed_nav_padding',array(
		'default' => '0',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_fixed_nav_padding', array(
		'label'    => esc_html__( 'Fixed Nav Padding Top/Bottom', 'dixie-secondline' ),
		'description'    => esc_html__( 'Set option to 0 to ignore this field.', 'dixie-secondline' ),
		'section'  => 'secondline_themes_section_fixed_nav',
		'priority'   => 60,
		'choices'     => array(
			'min'  => 0,
			'max'  => 80,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - Header - Fixed Header */
	$wp_customize->add_setting( 'secondline_themes_fixed_nav_font_color', array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_fixed_nav_font_color', array(
		'label'    => esc_html__( 'Fixed Nav Font Color', 'dixie-secondline' ),
		'section'  => 'secondline_themes_section_fixed_nav',
		'priority'   => 70,
		)) 
	);
	
	
	/* Setting - Header - Fixed Header */
	$wp_customize->add_setting( 'secondline_themes_fixed_nav_font_color_hover', array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_fixed_nav_font_color_hover', array(
		'label'    => esc_html__( 'Fixed Nav Font Hover Color', 'dixie-secondline' ),
		'section'  => 'secondline_themes_section_fixed_nav',
		'priority'   => 80,
		)) 
	);
	
	/* Setting - Header - Fixed Header */
	$wp_customize->add_setting( 'secondline_themes_fixed_nav_font_bg', array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_fixed_nav_font_bg', array(
		'label'    => esc_html__( 'Fixed Nav Background Color', 'dixie-secondline' ),
		'section'  => 'secondline_themes_section_fixed_nav',
		'priority'   => 100,
		)) 
	);
	
	/* Setting - Header - Fixed Header */
	$wp_customize->add_setting( 'secondline_themes_fixed_nav_font_hover_bg', array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_fixed_nav_font_hover_bg', array(
		'label'    => esc_html__( 'Fixed Nav Hover Background', 'dixie-secondline' ),
		'section'  => 'secondline_themes_section_fixed_nav',
		'priority'   => 105,
		)) 
	);
	
	

	

	
	
	
  	/* Section - Header - Header Icons */
  	$wp_customize->add_section( 'secondline_themes_section_header_icons', array(
  		'title'          => esc_html__( 'Header Social Icons', 'dixie-secondline' ),
  		'panel'          => 'secondline_themes_header_panel', // Not typically needed.
  		'priority'       => 100,
  	) );
	
	
	
 	/* Setting - Header - Header Icons */
 	$wp_customize->add_setting( 'secondline_themes_header_icon_color', array(
 		'default'	=> '#ffffff',
 		'sanitize_callback' => 'sanitize_hex_color',
 	) );
 	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_header_icon_color', array(
 		'label'    => esc_html__( 'Icon Color', 'dixie-secondline' ),
 		'section'  => 'secondline_themes_section_header_icons',
 		'priority'   => 5,
 		)) 
 	);
	
	
	

	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_facebook' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_facebook', array(
		'label'          => esc_html__( 'Facebook Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 12,
		)
	);
	
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_twitter' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_twitter', array(
		'label'          => esc_html__( 'Twitter Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 15,
		)
	);
	
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_instagram' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_instagram', array(
		'label'          => esc_html__( 'Instagram Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 20,
		)
	);
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_spotify' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_spotify', array(
		'label'          => esc_html__( 'Spotify Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 25,
		)
	);
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_youtube' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_youtube', array(
		'label'          => esc_html__( 'Youtube Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 30,
		)
	);
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_vimeo' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_vimeo', array(
		'label'          => esc_html__( 'Vimeo Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 35,
		)
	);
	
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_header_rss' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_rss', array(
		'label'          => esc_html__( 'RSS Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 30,
		)
	);
	
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_header_itunes' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_itunes', array(
		'label'          => esc_html__( 'iTunes Podcast Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 30,
		)
	);	
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_header_patreon' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_patreon', array(
		'label'          => esc_html__( 'Patreon Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 30,
		)
	);		
	
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_header_android' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_android', array(
		'label'          => esc_html__( 'Android Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 30,
		)
	);			
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_pinterest' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_pinterest', array(
		'label'          => esc_html__( 'Pinterest Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 45,
		)
	);
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_soundcloud' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_soundcloud', array(
		'label'          => esc_html__( 'Soundcloud Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 50,
		)
	);
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_linkedin' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_linkedin', array(
		'label'          => esc_html__( 'LinkedIn Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 52,
		)
	);
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_snapchat' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_snapchat', array(
		'label'          => esc_html__( 'Snapchat Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 55,
		)
	);
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_tumblr' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_tumblr', array(
		'label'          => esc_html__( 'Tumblr Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 60,
		)
	);
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_flickr' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_flickr', array(
		'label'          => esc_html__( 'Flickr Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 65,
		)
	);
	
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_dribbble' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_dribbble', array(
		'label'          => esc_html__( 'Dribbble Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 70,
		)
	);
	
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_vk' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_vk', array(
		'label'          => esc_html__( 'VK Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 75,
		)
	);
	
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_wordpress' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_wordpress', array(
		'label'          => esc_html__( 'WordPress Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 80,
		)
	);
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_mixcloud' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_mixcloud', array(
		'label'          => esc_html__( 'MixCloud Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 85,
		)
	);
	
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_behance' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_behance', array(
		'label'          => esc_html__( 'Behance Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 90,
		)
	);
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_github' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_github', array(
		'label'          => esc_html__( 'GitHub Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 95,
		)
	);
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_lastfm' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_lastfm', array(
		'label'          => esc_html__( 'Last.fm Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 100,
		)
	);
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_medium' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_medium', array(
		'label'          => esc_html__( 'Medium Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 105,
		)
	);
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_reddit' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_reddit', array(
		'label'          => esc_html__( 'Reddit Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 106,
		)
	);	
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_tripadvisor' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_tripadvisor', array(
		'label'          => esc_html__( 'Trip Advisor Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 110,
		)
	);
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_twitch' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_twitch', array(
		'label'          => esc_html__( 'Twitch Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 115,
		)
	);
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_yelp' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_yelp', array(
		'label'          => esc_html__( 'Yelp Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 120,
		)
	);
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_xing' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_xing', array(
		'label'          => esc_html__( 'Xing Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 121,
		)
	);	
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_skype' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_skype', array(
		'label'          => esc_html__( 'Skype Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 122,
		)
	);		
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_discord' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_discord', array(
		'label'          => esc_html__( 'Discord Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 122,
		)
	);			
	
	
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_mail' ,array(
		'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'secondline_themes_header_mail', array(
		'label'          => esc_html__( 'E-mail Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 150,
		)
	);
	
	
	/* Setting - Header - Header Icons */
	$wp_customize->add_setting( 'secondline_themes_header_wishlist' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_header_wishlist', array(
		'label'          => esc_html__( 'Heart Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_header_icons',
		'type' => 'text',
		'priority'   => 160,
		)
	);
	
	
	
	
	

	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting( 'secondline_themes_nav_align' ,array(
		'default' => 'secondline-themes-nav-right',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_nav_align', array(
		'label'    => esc_html__( 'Navigation Alignment', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-navigation-font',
		'priority'   => 10,
		'choices'     => array(
			'secondline-themes-nav-left' => esc_html__( 'Left', 'dixie-secondline' ),
			'secondline-themes-nav-center' => esc_html__( 'Center', 'dixie-secondline' ),
			'secondline-themes-nav-right' => esc_html__( 'Right', 'dixie-secondline' ),
		),
		))
	);
	

	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting('secondline_themes_nav_font_size',array(
		'default' => '14',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_nav_font_size', array(
		'label'    => esc_html__( 'Navigation Font Size', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-navigation-font',
		'priority'   => 500,
		'choices'     => array(
			'min'  => 0,
			'max'  => 30,
			'step' => 1
		), ) ) 
	);
	
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting('secondline_themes_nav_padding',array(
		'default' => '42',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_nav_padding', array(
		'label'    => esc_html__( 'Navigation Padding Top/Bottom', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-navigation-font',
		'priority'   => 505,
		'choices'     => array(
			'min'  => 5,
			'max'  => 100,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting('secondline_themes_nav_left_right',array(
		'default' => '18',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_nav_left_right', array(
		'label'    => esc_html__( 'Navigation Padding Left/Right', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-navigation-font',
		'priority'   => 510,
		'choices'     => array(
			'min'  => 8,
			'max'  => 80,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting( 'secondline_themes_nav_font_color', array(
		'default'	=> '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_nav_font_color', array(
		'label'    => esc_html__( 'Navigation Font Color', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-navigation-font',
		'priority'   => 520,
		)) 
	);
	
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting( 'secondline_themes_nav_font_color_hover', array(
		'default'	=> '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_nav_font_color_hover', array(
		'label'    => esc_html__( 'Navigation Font Hover Color', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-navigation-font',
		'priority'   => 530,
		)) 
	);
	
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting( 'secondline_themes_nav_bg', array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_nav_bg', array(
		'label'    => esc_html__( 'Navigation Item Background', 'dixie-secondline' ),
		'description'    => esc_html__( 'Remove background by clearing the color.', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-navigation-font',
		'priority'   => 536,
		)) 
	);
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting( 'secondline_themes_nav_bg_hover', array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_nav_bg_hover', array(
		'label'    => esc_html__( 'Navigation Item Background Hover', 'dixie-secondline' ),
		'description'    => esc_html__( 'Remove background by clearing the color.', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-navigation-font',
		'priority'   => 536,
		)) 
	);
	
	

	/* Setting - Header - Navigation */
	$wp_customize->add_setting('secondline_themes_nav_letterspacing',array(
		'default' => '0.5',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_nav_letterspacing', array(
		'label'          => esc_html__( 'Navigation Letter-Spacing (px)', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-navigation-font',
		'priority'   => 540,
		'choices'     => array(
			'min'  => -2,
			'max'  => 10,
			'step' => 0.5
		), ) ) 
	);
	
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting( 'secondline_themes_nav_search' ,array(
		'default' => 'off',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_nav_search', array(
		'label'    => esc_html__( 'Search in Navigation', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-navigation-font',
		'priority'   => 600,
		'choices'     => array(
			'on' => esc_html__( 'On', 'dixie-secondline' ),
			'off' => esc_html__( 'Off', 'dixie-secondline' ),
		),
		))
	);		
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting( 'secondline_themes_nav_cart' ,array(
		'default' => 'off',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_nav_cart', array(
		'label'    => esc_html__( 'WooCommerce Cart', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-navigation-font',
		'priority'   => 600,
		'choices'     => array(
			'on' => esc_html__( 'On', 'dixie-secondline' ),
			'off' => esc_html__( 'Off', 'dixie-secondline' ),
		),
		))
	);	
	

	
	/* Setting - Header - Sub-Navigation */
	$wp_customize->add_setting( 'secondline_themes_sub_nav_bg', array(
		'default' => '#ffffff',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );	
	$wp_customize->add_control(new secondline_themes_Customize_Alpha_Color_Control($wp_customize, 'secondline_themes_sub_nav_bg', array(
		'default' => '#ffffff',
		'label'    => esc_html__( 'Sub-Navigation Background Color', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-sub-navigation-font',
		'priority'   => 10,
		)) 
	);
	
	
	
	/* Setting - Header - Sub-Navigation */
	$wp_customize->add_setting( 'secondline_themes_sub_nav_border_top_color', array(
		'default' => '#b2c3de',
		'sanitize_callback' => 'sanitize_hex_color',
	) );	
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_sub_nav_border_top_color', array(
		'label'    => esc_html__( 'Sub-Navigation Border Top', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-sub-navigation-font',
		'priority'   => 13,
		)) 
	);
	
	
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting('secondline_themes_sub_nav_font_size',array(
		'default' => '13',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_sub_nav_font_size', array(
		'label'    => esc_html__( 'Navigation Font Size', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-sub-navigation-font',
		'priority'   => 510,
		'choices'     => array(
			'min'  => 0,
			'max'  => 30,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - Header - Navigation */
	$wp_customize->add_setting( 'secondline_themes_sub_nav_letterspacing' ,array(
		'default' => '0',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_sub_nav_letterspacing', array(
		'label'          => esc_html__( 'Sub-Navigation Letter-Spacing (px)', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-sub-navigation-font',
		'priority'   => 515,
		'choices'     => array(
			'min'  => -2,
			'max'  => 10,
			'step' => 0.5
		), ) ) 
	);

	
	
	/* Setting - Header - Sub-Navigation */
	$wp_customize->add_setting( 'secondline_themes_sub_nav_font_color', array(
		'default'	=> '#263669',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_sub_nav_font_color', array(
		'label'    => esc_html__( 'Sub-Navigation Font Color', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-sub-navigation-font',
		'priority'   => 520,
		)) 
	);
	
	
	/* Setting - Header - Sub-Navigation */
	$wp_customize->add_setting( 'secondline_themes_sub_nav_hover_font_color', array(
		'default'	=> '#2d2d2d',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_sub_nav_hover_font_color', array(
		'label'    => esc_html__( 'Sub-Navigation Font Hover Color', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-sub-navigation-font',
		'priority'   => 530,
		)) 
	);
	
	

	
	
	/* Setting - Header - Sub-Navigation */
	$wp_customize->add_setting( 'secondline_themes_sub_nav_border_color', array(
		'default'	=> '#efefef',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_sub_nav_border_color', array(
		'label'    => esc_html__( 'Sub-Navigation Divider Color', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-sub-navigation-font',
		'priority'   => 550,
		)) 
	);
	
	
	
	
	
	
	/* Panel - Body */
	$wp_customize->add_panel( 'secondline_themes_body_panel', array(
		'priority'    => 8,
        'title'       => esc_html__( 'Body', 'dixie-secondline' ),
    ) );
	 
	 
	 
 	/* Setting - Body - Body Main */
 	$wp_customize->add_setting( 'secondline_themes_default_link_color', array(
 		'default'	=> '#263669',
 		'sanitize_callback' => 'sanitize_hex_color',
 	) );
 	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_default_link_color', array(
 		'label'    => esc_html__( 'Default Link Color', 'dixie-secondline' ),
 		'section'  => 'tt_font_secondline-themes-body-font',
 		'priority'   => 500,
 		)) 
 	);
	
 	/* Setting - Body - Body Main */
 	$wp_customize->add_setting( 'secondline_themes_default_link_hover_color', array(
 		'default'	=> '#2d2d2d',
 		'sanitize_callback' => 'sanitize_hex_color',
 	) );
 	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_default_link_hover_color', array(
 		'label'    => esc_html__( 'Default Hover Link Color', 'dixie-secondline' ),
 		'section'  => 'tt_font_secondline-themes-body-font',
 		'priority'   => 510,
 		)) 
 	);
	
	

	
	
	/* Setting - Body - Body Main */
	$wp_customize->add_setting( 'secondline_themes_background_color', array(
		'default'	=> '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_background_color', array(
		'label'    => esc_html__( 'Body Background Color', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-body-font',
		'priority'   => 513,
		)) 
	);
	
	/* Setting - Body - Body Main */
	$wp_customize->add_setting( 'secondline_themes_body_bg_image' ,array(		
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'secondline_themes_body_bg_image', array(
		'label'    => esc_html__( 'Body Background Image', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-body-font',
		'priority'   => 525,
		))
	);
	
	/* Setting - Body - Body Main */
	$wp_customize->add_setting( 'secondline_themes_body_bg_image_image_position' ,array(
		'default' => 'cover',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_body_bg_image_image_position', array(
		'label'    => esc_html__( 'Image Cover', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-body-font',
		'priority'   => 530,
		'choices'     => array(
			'cover' => esc_html__( 'Image Cover', 'dixie-secondline' ),
			'repeat-all' => esc_html__( 'Image Pattern', 'dixie-secondline' ),
		),
		))
	);
	
	


	
	/* Setting - Body - Page Title */
	$wp_customize->add_setting('secondline_themes_page_title_padding_top',array(
		'default' => '184',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_page_title_padding_top', array(
		'label'    => esc_html__( 'Page Title Top Padding', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-page-title',
		'priority'   => 501,
		'choices'     => array(
			'min'  => 0,
			'max'  => 350,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - Body - Page Title */
	$wp_customize->add_setting('secondline_themes_page_title_padding_bottom',array(
		'default' => '130',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_page_title_padding_bottom', array(
		'label'    => esc_html__( 'Page Title Bottom Padding', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-page-title',
		'priority'   => 515,
		'choices'     => array(
			'min'  => 0,
			'max'  => 350,
			'step' => 1
		), ) ) 
	);
	
	
	/* Setting - Body - Page Title */
	$wp_customize->add_setting( 'secondline_themes_page_title_underline_color', array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_page_title_underline_color', array(
		'label'    => esc_html__( 'Page Title Underline Color', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-page-title',
		'priority'   => 520,
		)) 
	);
	
	
	/* Setting - General - Page Title */
	$wp_customize->add_setting( 'secondline_themes_page_title_bg_image' ,array(
		'default' => get_template_directory_uri().'/images/page-title.jpg',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'secondline_themes_page_title_bg_image', array(
		'label'    => esc_html__( 'Page Title Background Image', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-page-title',
		'priority'   => 535,
		))
	);
	
	
	/* Setting - General - Page Title */
	$wp_customize->add_setting( 'secondline_themes_page_title_image_position' ,array(
		'default' => 'cover',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_page_title_image_position', array(
		'section' => 'tt_font_secondline-themes-page-title',
		'priority'   => 536,
		'choices'     => array(
			'cover' => esc_html__( 'Image Cover', 'dixie-secondline' ),
			'repeat-all' => esc_html__( 'Image Pattern', 'dixie-secondline' ),
		),
		))
	);
	
	
	
	/* Setting - Body - Page Title */
	$wp_customize->add_setting( 'secondline_themes_page_title_bg_color', array(
		'default' => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_page_title_bg_color', array(
		'label'    => esc_html__( 'Page Title Background Color', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-page-title',
		'priority'   => 580,
		)) 
	);
	
	
	/* Setting - Body - Page Title */
	$wp_customize->add_setting( 'secondline_themes_page_title_overlay_color', array(
		'sanitize_callback' => 'secondline_themes_sanitize_customizer',
	) );
	$wp_customize->add_control(new secondline_themes_Customize_Alpha_Color_Control($wp_customize, 'secondline_themes_page_title_overlay_color', array(
		'label'    => esc_html__( 'Page Title Image Overlay', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-page-title',
		'priority'   => 590,
		)) 
	);
	
	
	
	
	/* Setting - Body - Page Title */
	$wp_customize->add_setting( 'secondline_themes_sidebar_background', array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_sidebar_background', array(
		'label'    => esc_html__( 'Sidebar Background Color', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-sidebar-headings',
		'priority'   => 320,
		)) 
	);
	
	/* Setting - Body - Page Title */
	$wp_customize->add_setting( 'secondline_themes_sidebar_divider', array(
		'default'	=> '#e5e5e5',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_sidebar_divider', array(
		'label'    => esc_html__( 'Sidebar Divider Color', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-sidebar-headings',
		'priority'   => 330,
		)) 
	);
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting('secondline_themes_sidebar_spacing',array(
		'default' => '',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_sidebar_spacing', array(
		'label'    => esc_html__( 'Sidebar Spacing', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-sidebar-headings',
		'priority'   => 335,
		'choices'     => array(
			'min'  => 1,
			'max'  => 120,
			'step' => 1
		), ) )
	);	
	
	
	/* Section - Blog - Blog Index Post Options */
   $wp_customize->add_section( 'secondline_themes_section_blog_index', array(
   	'title'          => esc_html__( 'Post Archive Options', 'dixie-secondline' ),
   	'panel'          => 'secondline_themes_blog_panel', // Not typically needed.
   	'priority'       => 20,
   ) 
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_cat_sidebar' ,array(
		'default' => 'right-sidebar',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_blog_cat_sidebar', array(
		'label'    => esc_html__( 'Category Sidebar', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_blog_index',
		'priority'   => 70,
		'choices' => array(
			'left-sidebar' => esc_html__( 'Left', 'dixie-secondline' ),
			'right-sidebar' => esc_html__( 'Right', 'dixie-secondline' ),
			'no-sidebar' => esc_html__( 'Hidden', 'dixie-secondline' ),
		
		 ),
		))
	);	
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting('secondline_themes_blog_columns',array(
		'default' => '1',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_blog_columns', array(
		'label'    => esc_html__( 'Post Columns', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_blog_index',
		'priority'   => 100,
		'choices'     => array(
			'min'  => 1,
			'max'  => 6,
			'step' => 1
		), ) ) 
	);
	
	
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_pagination' ,array(
		'default' => 'default',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( 'secondline_themes_blog_pagination', array(
		'label'    => esc_html__( 'Post Pagination', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_blog_index',
		'type' => 'select',
		'priority'   => 111,
		'choices' => array(
			'default' => esc_html__( 'Default', 'dixie-secondline' ),
			'infinite-scroll' => esc_html__( 'Infinite Scroll', 'dixie-secondline' ),
			'load-more' => esc_html__( 'Load More Button', 'dixie-secondline' ),
		
		 ),
		)
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_masonry_fit' ,array(
		'default' => 'fitRows',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_blog_masonry_fit', array(
		'label'    => esc_html__( 'Masonry Layout', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_blog_index',
		'priority'   => 115,
		'choices' => array(
			'masonry' => esc_html__( 'On', 'dixie-secondline' ),
			'fitRows' => esc_html__( 'Off', 'dixie-secondline' ),
		
		 ),
		))
	);
	
	
	




   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_transition' ,array(
		'default' => 'secondline-themes-blog-image-no-effect',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( 'secondline_themes_blog_transition', array(
		'label'    => esc_html__( 'Post Image Hover Effect', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_blog_index',
		'type' => 'select',
		'priority'   => 204,
		'choices' => array(
			'secondline-themes-blog-image-scale' => esc_html__( 'Zoom', 'dixie-secondline' ),
			'secondline-themes-blog-image-zoom-grey' => esc_html__( 'Greyscale', 'dixie-secondline' ),
			'secondline-themes-blog-image-zoom-sepia' => esc_html__( 'Sepia', 'dixie-secondline' ),
			'secondline-themes-blog-image-zoom-saturate' => esc_html__( 'Saturate', 'dixie-secondline' ),
			'secondline-themes-blog-image-zoom-shine' => esc_html__( 'Shine', 'dixie-secondline' ),
			'secondline-themes-blog-image-no-effect' => esc_html__( 'No Effect', 'dixie-secondline' ),
		
		 ),
		)
	);
	
	

	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting('secondline_themes_blog_image_opacity',array(
		'default' => '1',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_blog_image_opacity', array(
		'label'    => esc_html__( 'Image Transparency on Hover', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_blog_index',
		'priority'   => 206,
		'choices'     => array(
			'min'  => 0,
			'max'  => 1,
			'step' => 0.05
		), ) ) 
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_image_bg', array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_blog_image_bg', array(
		'label'    => esc_html__( 'Post Image Background Color', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_blog_index',
		'priority'   => 210,
		)) 
	);
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_read_more', array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_blog_read_more', array(
		'label'    => esc_html__( 'Post Archive Read More Color', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-blog-headings',
		'priority'   => 20,
		)) 
	);	
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_meta_author_display' ,array(
		'default' => 'true',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_blog_meta_author_display', array(
		'label'    => esc_html__( 'Author', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_blog_index',
		'priority'   => 335,
		'choices' => array(
			'true' => esc_html__( 'Display', 'dixie-secondline' ),
			'false' => esc_html__( 'Hide', 'dixie-secondline' ),
		
		 ),
		))
	);
	
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_meta_date_display' ,array(
		'default' => 'true',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_blog_meta_date_display', array(
		'label'    => esc_html__( 'Date', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_blog_index',
		'priority'   => 340,
		'choices' => array(
			'true' => esc_html__( 'Display', 'dixie-secondline' ),
			'false' => esc_html__( 'Hide', 'dixie-secondline' ),
		
		 ),
		))
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_serie_display' ,array(
		'default' => 'false',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_blog_serie_display', array(
		'label'    => esc_html__( 'Episode & Season Number', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_blog_index',
		'priority'   => 340,
		'choices' => array(
			'true' => esc_html__( 'Display', 'dixie-secondline' ),
			'false' => esc_html__( 'Hide', 'dixie-secondline' ),		
		 ),
		))
	);		
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_meta_duration_display' ,array(
		'default' => 'true',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_blog_meta_duration_display', array(
		'label'    => esc_html__( 'Duration', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_blog_index',
		'priority'   => 340,
		'choices' => array(
			'true' => esc_html__( 'Display', 'dixie-secondline' ),
			'false' => esc_html__( 'Hide', 'dixie-secondline' ),
		
		 ),
		))
	);	
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_meta_comment_display' ,array(
		'default' => 'true',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_blog_meta_comment_display', array(
		'label'    => esc_html__( 'Comment Count', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_blog_index',
		'priority'   => 340,
		'choices' => array(
			'true' => esc_html__( 'Display', 'dixie-secondline' ),
			'false' => esc_html__( 'Hide', 'dixie-secondline' ),
		
		 ),
		))
	);	
	    
    
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_meta_category_display' ,array(
		'default' => 'true',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_blog_meta_category_display', array(
		'label'    => esc_html__( 'Category', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_blog_index',
		'priority'   => 350,
		'choices' => array(
			'true' => esc_html__( 'Display', 'dixie-secondline' ),
			'false' => esc_html__( 'Hide', 'dixie-secondline' ),
		
		 ),
		))
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_audio_player_display' ,array(
		'default' => 'false',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_blog_audio_player_display', array(
		'label'    => esc_html__( 'Audio Player', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_blog_index',
		'priority'   => 350,
		'choices' => array(
			'true' => esc_html__( 'Display', 'dixie-secondline' ),
			'false' => esc_html__( 'Hide', 'dixie-secondline' ),
		
		 ),
		))
	);	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_excerpt_display' ,array(
		'default' => 'true',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_blog_excerpt_display', array(
		'label'    => esc_html__( 'Excerpt', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_blog_index',
		'priority'   => 350,
		'choices' => array(
			'true' => esc_html__( 'Display', 'dixie-secondline' ),
			'false' => esc_html__( 'Hide', 'dixie-secondline' ),
		
		 ),
		))
	);	
		
	

	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting('secondline_themes_blog_post_height',array(
		'default' => '700',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_blog_post_height', array(
		'label'    => esc_html__( 'Minimum Post Title Height', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-blog-post-options',
		'priority'   => 110,
		'choices'     => array(
			'min'  => 1,
			'max'  => 1200,
			'step' => 1
		), ) ) 
	);

   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting('secondline_themes_blog_post_meta_padding_top',array(
		'default' => '300',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_blog_post_meta_padding_top', array(
		'label'    => esc_html__( 'Post Title Area Top Padding', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-blog-post-options',
		'priority'   => 110,
		'choices'     => array(
			'min'  => 1,
			'max'  => 1200,
			'step' => 1
		), ) ) 
	);	
	

   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting('secondline_themes_blog_post_meta_padding',array(
		'default' => '105',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_blog_post_meta_padding', array(
		'label'    => esc_html__( 'Post Title Area Bottom Padding', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-blog-post-options',
		'priority'   => 110,
		'choices'     => array(
			'min'  => 1,
			'max'  => 1200,
			'step' => 1
		), ) ) 
	);	

	

	
	/* Setting - General - Page Title */
	$wp_customize->add_setting( 'secondline_themes_post_page_title_bg_image' ,array(
		'default' => get_template_directory_uri().'/images/page-title.jpg',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'secondline_themes_post_page_title_bg_image', array(
		'label'    => esc_html__( 'Post Title Background Image', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-blog-post-options',
		'priority'   => 170,
		))
	);
	
	
	/* Setting - General - Page Title */
	$wp_customize->add_setting( 'secondline_themes_page_post_title_image_position' ,array(
		'default' => 'cover',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_page_post_title_image_position', array(
		'section' => 'tt_font_secondline-themes-blog-post-options',
		'priority'   => 180,
		'choices'     => array(
			'cover' => esc_html__( 'Image Cover', 'dixie-secondline' ),
			'repeat-all' => esc_html__( 'Image Pattern', 'dixie-secondline' ),
		),
		))
	);
	
	
	
	/* Setting - Body - Page Title */
	$wp_customize->add_setting( 'secondline_themes_post_title_bg_color', array(
		'default' => '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_post_title_bg_color', array(
		'label'    => esc_html__( 'Page Title Background Color', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-blog-post-options',
		'priority'   => 190,
		)) 
	);
	
	
	/* Setting - Body - Page Title */
	$wp_customize->add_setting( 'secondline_themes_post_title_overlay_color', array(
		'sanitize_callback' => 'secondline_themes_sanitize_customizer',
	) );
	$wp_customize->add_control(new secondline_themes_Customize_Alpha_Color_Control($wp_customize, 'secondline_themes_post_title_overlay_color', array(
		'label'    => esc_html__( 'Page Title Image Overlay', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-blog-post-options',
		'priority'   => 200,
		)) 
	);
	
	
   /* Section - Blog - Blog Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_post_sidebar' ,array(
		'default' => 'right',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_blog_post_sidebar', array(
		'label'    => esc_html__( 'Post Sidebar', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-blog-post-options',
		'priority'   => 330,
		'choices'     => array(
			'left' => esc_html__( 'Left', 'dixie-secondline' ),
			'right' => esc_html__( 'Right', 'dixie-secondline' ),
			'none' => esc_html__( 'No Sidebar', 'dixie-secondline' ),
		),
		))
	);
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_single_featured_img_display' ,array(
		'default' => 'true',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_blog_single_featured_img_display', array(
		'label'    => esc_html__( 'Display Featured Image on Single Posts?', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-blog-post-options',
		'priority'   => 331,
		'choices' => array(
			'true' => esc_html__( 'Display', 'dixie-secondline' ),
			'false' => esc_html__( 'Hide', 'dixie-secondline' ),
		
		 ),
		))
	);		
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_single_tags_display' ,array(
		'default' => 'true',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_blog_single_tags_display', array(
		'label'    => esc_html__( 'Display Tags on Single Posts?', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-blog-post-options',
		'priority'   => 331,
		'choices' => array(
			'true' => esc_html__( 'Display', 'dixie-secondline' ),
			'false' => esc_html__( 'Hide', 'dixie-secondline' ),
		
		 ),
		))
	);		
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_single_comment_area_display' ,array(
		'default' => 'true',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_blog_single_comment_area_display', array(
		'label'    => esc_html__( 'Display Comment Area?', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-blog-post-options',
		'priority'   => 332,
		'choices' => array(
			'true' => esc_html__( 'Display', 'dixie-secondline' ),
			'false' => esc_html__( 'Hide', 'dixie-secondline' ),
		
		 ),
		))
	);		
	

	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_single_meta_author_display' ,array(
		'default' => 'true',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_blog_single_meta_author_display', array(
		'label'    => esc_html__( 'Author', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-blog-post-options',
		'priority'   => 335,
		'choices' => array(
			'true' => esc_html__( 'Display', 'dixie-secondline' ),
			'false' => esc_html__( 'Hide', 'dixie-secondline' ),
		
		 ),
		))
	);
	
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_single_meta_date_display' ,array(
		'default' => 'true',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_blog_single_meta_date_display', array(
		'label'    => esc_html__( 'Date', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-blog-post-options',
		'priority'   => 340,
		'choices' => array(
			'true' => esc_html__( 'Display', 'dixie-secondline' ),
			'false' => esc_html__( 'Hide', 'dixie-secondline' ),
		
		 ),
		))
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_single_serie_display' ,array(
		'default' => 'false',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_blog_single_serie_display', array(
		'label'    => esc_html__( 'Episode & Season Number', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-blog-post-options',
		'priority'   => 345,
		'choices' => array(
			'true' => esc_html__( 'Display', 'dixie-secondline' ),
			'false' => esc_html__( 'Hide', 'dixie-secondline' ),
		
		 ),
		))
	);	
		
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_single_meta_category_display' ,array(
		'default' => 'true',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_blog_single_meta_category_display', array(
		'label'    => esc_html__( 'Category', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-blog-post-options',
		'priority'   => 350,
		'choices' => array(
			'true' => esc_html__( 'Display', 'dixie-secondline' ),
			'false' => esc_html__( 'Hide', 'dixie-secondline' ),
		
		 ),
		))
	);
	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_single_meta_duration_display' ,array(
		'default' => 'true',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_blog_single_meta_duration_display', array(
		'label'    => esc_html__( 'Duration', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-blog-post-options',
		'priority'   => 350,
		'choices' => array(
			'true' => esc_html__( 'Display', 'dixie-secondline' ),
			'false' => esc_html__( 'Hide', 'dixie-secondline' ),
		
		 ),
		))
	);

	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting( 'secondline_themes_blog_single_meta_comment_display' ,array(
		'default' => 'true',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_blog_single_meta_comment_display', array(
		'label'    => esc_html__( 'Comment Count', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-blog-post-options',
		'priority'   => 350,
		'choices' => array(
			'true' => esc_html__( 'Display', 'dixie-secondline' ),
			'false' => esc_html__( 'Hide', 'dixie-secondline' ),
		
		 ),
		))
	);	
	
	
	
	
   /* Section - Blog - Blog Post Options */
 	$wp_customize->add_setting( 'secondline_themes_blog_post_sharing' ,array(
 		'default' => 'off',
 		'sanitize_callback' => 'secondline_themes_sanitize_choices',
 	) );
 	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_blog_post_sharing', array(
 		'label'    => esc_html__( 'Post Sharing', 'dixie-secondline' ),
 		'section' => 'tt_font_secondline-themes-blog-post-options',
 		'priority'   => 605,
 		'choices'     => array(
 			'on' => esc_html__( 'Display', 'dixie-secondline' ),
 			'off' => esc_html__( 'Hide', 'dixie-secondline' ),
 		),
 		))
 	);
	
	

   /* Section - Blog - Post Options */
 	$wp_customize->add_setting( 'secondline_single_sharing_twitter' ,array(
 		'default' =>  '1',
 		'sanitize_callback' => 'secondline_themes_sanitize_choices',
 	) );
 	$wp_customize->add_control( 'secondline_single_sharing_twitter', array(
 		'label'          => esc_html__( 'Twitter Sharing', 'dixie-secondline' ),
 		'section' => 'tt_font_secondline-themes-blog-post-options',
 		'type' => 'checkbox',
 		'priority'   => 605,
 		)
	
 	);
	

   /* Section - Blog - Post Options */
 	$wp_customize->add_setting( 'secondline_single_sharing_facebook' ,array(
 		'default' =>  '1',
 		'sanitize_callback' => 'secondline_themes_sanitize_choices',
 	) );
 	$wp_customize->add_control( 'secondline_single_sharing_facebook', array(
 		'label'          => esc_html__( 'Facebook Sharing', 'dixie-secondline' ),
 		'section' => 'tt_font_secondline-themes-blog-post-options',
 		'type' => 'checkbox',
 		'priority'   => 609,
 		)
	
 	);
	
	
	
   /* Section - Blog - Post Options */
 	$wp_customize->add_setting( 'secondline_single_sharing_pinterest' ,array(
 		'sanitize_callback' => 'secondline_themes_sanitize_choices',
 	) );
 	$wp_customize->add_control( 'secondline_single_sharing_pinterest', array(
 		'label'          => esc_html__( 'Pinterest Sharing', 'dixie-secondline' ),
 		'section' => 'tt_font_secondline-themes-blog-post-options',
 		'type' => 'checkbox',
 		'priority'   => 615,
 		)
	
 	);
	
   /* Section - Blog - Post Options */
 	$wp_customize->add_setting( 'secondline_single_sharing_vk' ,array(
 		'sanitize_callback' => 'secondline_themes_sanitize_choices',
 	) );
 	$wp_customize->add_control( 'secondline_single_sharing_vk', array(
 		'label'          => esc_html__( 'VK Sharing', 'dixie-secondline' ),
 		'section' => 'tt_font_secondline-themes-blog-post-options',
 		'type' => 'checkbox',
 		'priority'   => 620,
 		)
	
 	);
	
	
	
   /* Section - Blog - Post Options */
 	$wp_customize->add_setting( 'secondline_single_sharing_google' ,array(
 		'sanitize_callback' => 'secondline_themes_sanitize_choices',
 	) );
 	$wp_customize->add_control( 'secondline_single_sharing_google', array(
 		'label'          => esc_html__( 'Google+ Sharing', 'dixie-secondline' ),
 		'section' => 'tt_font_secondline-themes-blog-post-options',
 		'type' => 'checkbox',
 		'priority'   => 620,
 		)
	
 	);
	
	
   /* Section - Blog - Post Options */
 	$wp_customize->add_setting( 'secondline_single_sharing_reddit' ,array(
		'default' =>  '1',
 		'sanitize_callback' => 'secondline_themes_sanitize_choices',
 	) );
 	$wp_customize->add_control( 'secondline_single_sharing_reddit', array(
 		'label'          => esc_html__( 'Reddit Sharing', 'dixie-secondline' ),
 		'section' => 'tt_font_secondline-themes-blog-post-options',
 		'type' => 'checkbox',
 		'priority'   => 625,
 		)
	
 	);
	
	
   /* Section - Blog - Post Options */
 	$wp_customize->add_setting( 'secondline_single_sharing_linkedin' ,array(
 		'sanitize_callback' => 'secondline_themes_sanitize_choices',
 	) );
 	$wp_customize->add_control( 'secondline_single_sharing_linkedin', array(
 		'label'          => esc_html__( 'LinkedIn Sharing', 'dixie-secondline' ),
 		'section' => 'tt_font_secondline-themes-blog-post-options',
 		'type' => 'checkbox',
 		'priority'   => 630,
 		)
	
 	);
	
   /* Section - Blog - Post Options */
 	$wp_customize->add_setting( 'secondline_single_sharing_tumblr' ,array(
 		'sanitize_callback' => 'secondline_themes_sanitize_choices',
 	) );
 	$wp_customize->add_control( 'secondline_single_sharing_tumblr', array(
 		'label'          => esc_html__( 'Tumblr Sharing', 'dixie-secondline' ),
 		'section' => 'tt_font_secondline-themes-blog-post-options',
 		'type' => 'checkbox',
 		'priority'   => 635,
 		)
	
 	);
	
   /* Section - Blog - Post Options */
 	$wp_customize->add_setting( 'secondline_single_sharing_stumble' ,array(
 		'sanitize_callback' => 'secondline_themes_sanitize_choices',
 	) );
 	$wp_customize->add_control( 'secondline_single_sharing_stumble', array(
 		'label'          => esc_html__( 'StumbleUpon Sharing', 'dixie-secondline' ),
 		'section' => 'tt_font_secondline-themes-blog-post-options',
 		'type' => 'checkbox',
 		'priority'   => 638,
 		)
	
 	);
	
   /* Section - Blog - Post Options */
 	$wp_customize->add_setting( 'secondline_single_sharing_mail' ,array(
 		'default' =>  '1',
 		'sanitize_callback' => 'secondline_themes_sanitize_choices',
 	) );
 	$wp_customize->add_control( 'secondline_single_sharing_mail', array(
 		'label'          => esc_html__( 'Email Sharing', 'dixie-secondline' ),
 		'section' => 'tt_font_secondline-themes-blog-post-options',
 		'type' => 'checkbox',
 		'priority'   => 640,
 		)
	
 	);
	
	
	
	
	/* Setting - Footer - Footer Widgets */
	$wp_customize->add_section( 'secondline_themes_image_filters', array(
		'title'          => esc_html__( 'Post Title Background Filters', 'dixie-secondline' ),
		'panel'          => 'secondline_themes_blog_panel', // Not typically needed.
		'priority'       => 460,
		) 
	);   	
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting('secondline_themes_post_title_filter_blur',array(
		'default' => '0',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_post_title_filter_blur', array(
		'label'    => esc_html__( 'Blur', 'dixie-secondline' ),
		'section' => 'secondline_themes_image_filters',
		'priority'   => 10,
		'choices'     => array(
			'min'  => 1,
			'max'  => 300,
			'step' => 1
		), ) ) 
	);			
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting('secondline_themes_post_title_filter_grayscale',array(
		'default' => '0',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_post_title_filter_grayscale', array(
		'label'    => esc_html__( 'Grayscale', 'dixie-secondline' ),
		'section' => 'secondline_themes_image_filters',
		'priority'   => 20,
		'choices'     => array(
			'min'  => 1,
			'max'  => 100,
			'step' => 1
		), ) ) 
	);		
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting('secondline_themes_post_title_filter_contrast',array(
		'default' => '100',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_post_title_filter_contrast', array(
		'label'    => esc_html__( 'Contrast', 'dixie-secondline' ),
		'section' => 'secondline_themes_image_filters',
		'priority'   => 30,
		'choices'     => array(
			'min'  => 1,
			'max'  => 300,
			'step' => 1
		), ) ) 
	);		
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting('secondline_themes_post_title_filter_invert',array(
		'default' => '0',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_post_title_filter_invert', array(
		'label'    => esc_html__( 'Invert', 'dixie-secondline' ),
		'section' => 'secondline_themes_image_filters',
		'priority'   => 40,
		'choices'     => array(
			'min'  => 1,
			'max'  => 300,
			'step' => 1
		), ) ) 
	);		
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting('secondline_themes_post_title_filter_saturate',array(
		'default' => '100',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_post_title_filter_saturate', array(
		'label'    => esc_html__( 'Saturate', 'dixie-secondline' ),
		'section' => 'secondline_themes_image_filters',
		'priority'   => 50,
		'choices'     => array(
			'min'  => 1,
			'max'  => 300,
			'step' => 1
		), ) ) 
	);			
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting('secondline_themes_post_title_filter_sepia',array(
		'default' => '0',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_post_title_filter_sepia', array(
		'label'    => esc_html__( 'Sepia', 'dixie-secondline' ),
		'section' => 'secondline_themes_image_filters',
		'priority'   => 60,
		'choices'     => array(
			'min'  => 1,
			'max'  => 300,
			'step' => 1
		), ) ) 
	);			
	
   /* Section - Blog - Blog Index Post Options */
	$wp_customize->add_setting('secondline_themes_post_title_filter_hue',array(
		'default' => '0',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_post_title_filter_hue', array(
		'label'    => esc_html__( 'Hue Rotate', 'dixie-secondline' ),
		'section' => 'secondline_themes_image_filters',
		'priority'   => 60,
		'choices'     => array(
			'min'  => 1,
			'max'  => 300,
			'step' => 1
		), ) ) 
	);	


	
	/* Setting - Body - Button Styles */
	$wp_customize->add_setting('secondline_themes_button_font_size',array(
		'default' => '12',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_button_font_size', array(
		'label'    => esc_html__( 'Button Font Size', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-button-typography',
		'priority'   => 1600,
		'choices'     => array(
			'min'  => 0,
			'max'  => 30,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - Body - Button Styles */
	$wp_customize->add_setting( 'secondline_themes_button_font', array(
		'default'	=> '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_button_font', array(
		'label'    => esc_html__( 'Button Font Color', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-button-typography',
		'priority'   => 1635,
		)) 
	);
	
	/* Setting - Body - Button Styles */
	$wp_customize->add_setting( 'secondline_themes_button_background', array(
		'default'	=> '#263669',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_button_background', array(
		'label'    => esc_html__( 'Button Background Color', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-button-typography',
		'priority'   => 1640,
		)) 
	);
	

	
	/* Setting - Body - Button Styles */
	$wp_customize->add_setting( 'secondline_themes_button_font_hover', array(
		'default'	=> '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_button_font_hover', array(
		'label'    => esc_html__( 'Button Hover Font Color', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-button-typography',
		'priority'   => 1650,
		)) 
	);
	
	/* Setting - Body - Button Styles */
	$wp_customize->add_setting( 'secondline_themes_button_background_hover', array(
		'default'	=> '#2d2d2d',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_button_background_hover', array(
		'label'    => esc_html__( 'Button Hover Background Color', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-button-typography',
		'priority'   => 1680,
		)) 
	);
	

	/* Setting - Body - Button Styles */
	$wp_customize->add_setting( 'secondline_themes_newsletter_button_background', array(
		'default'	=> '#20bb60',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_newsletter_button_background', array(
		'label'    => esc_html__( 'Newsletter Button Background Color', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-button-typography',
		'priority'   => 1680,
		)) 
	);	
	
	/* Setting - Body - Button Styles */
	$wp_customize->add_setting( 'secondline_themes_newsletter_button_background_hover', array(
		'default'	=> '#2d2d2d',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_newsletter_button_background_hover', array(
		'label'    => esc_html__( 'Newsletter Button Hover Background Color', 'dixie-secondline' ),
		'section'  => 'tt_font_secondline-themes-button-typography',
		'priority'   => 1680,
		)) 
	);		
	

	
	
	

	/* Panel - Footer */
	$wp_customize->add_panel( 'secondline_themes_footer_panel', array(
		'priority'    => 11,
        'title'       => esc_html__( 'Footer', 'dixie-secondline' ),
    ) 
 	);
	
	/* Setting - Footer - Footer Widgets */
	$wp_customize->add_section( 'secondline_themes_section_builder', array(
		'title'          => esc_html__( 'Footer Page Builder', 'dixie-secondline' ),
		'panel'          => 'secondline_themes_footer_panel', // Not typically needed.
		'priority'       => 12,
		) 
	);	
	
	/* Setting - Footer Elementor
	https://gist.github.com/ajskelton/27369df4a529ac38ec83980f244a7227
	*/
	$secondline_themes_elementor_library_list =  array(
		'' => 'Choose a template',
	);
	$secondline_themes_elementor_args = array('post_type' => 'elementor_library', 'posts_per_page' => 99);
	$secondline_themes_elementor_posts = get_posts( $secondline_themes_elementor_args );
	foreach($secondline_themes_elementor_posts as $secondline_themes_elementor_post) {
	    $secondline_themes_elementor_library_list[$secondline_themes_elementor_post->ID] = $secondline_themes_elementor_post->post_title;
	}

	$wp_customize->add_setting( 'secondline_themes_footer_elementor_library' ,array(
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_elementor_library', array(
	  'type' => 'select',
	  'section' => 'secondline_themes_section_builder',
	  'priority'   => 5,
	  'label'    => esc_html__( 'Footer Elementor Template', 'dixie-secondline' ),
	  'description'    => esc_html__( 'You can add/edit your footer under ', 'dixie-secondline') . '<a href="' . admin_url() . 'edit.php?post_type=elementor_library">Elementor > My Library</a>',
	  'choices'  => 	   $secondline_themes_elementor_library_list,
	) );	
	
	
	/* Setting - Footer - Footer Main */
	$wp_customize->add_setting( 'secondline_themes_footer_width' ,array(
		'default' => 'secondline-themes-footer-normal-width',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_footer_width', array(
		'label'    => esc_html__( 'Footer Width', 'dixie-secondline' ),
 		'section' => 'tt_font_secondline-themes-widgets-font',
		'priority'   => 10,
		'choices'     => array(
			'secondline-themes-footer-full-width' => esc_html__( 'Full Width', 'dixie-secondline' ),
			'secondline-themes-footer-normal-width' => esc_html__( 'Default', 'dixie-secondline' ),
		),
		))
	);


	
	/* Setting - Footer - Footer Main */
 	$wp_customize->add_setting( 'secondline_themes_footer_background', array(
 		'default'	=> '#2b2d30',
 		'sanitize_callback' => 'sanitize_hex_color',
 	) );
 	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_footer_background', array(
 		'label'    => esc_html__( 'Footer Background', 'dixie-secondline' ),
 		'section' => 'tt_font_secondline-themes-widgets-font',
 		'priority'   => 510,
 		)) 
 	);
	
	/* Setting - Footer - Footer Main */
	$wp_customize->add_setting( 'secondline_themes_footer_main_bg_image' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'secondline_themes_footer_main_bg_image', array(
		'label'    => esc_html__( 'Footer Background Image', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-widgets-font',
		'priority'   => 535,
		))
	);
	
	
	/* Setting - Footer - Footer Main */
	$wp_customize->add_setting( 'secondline_themes_main_image_position' ,array(
		'default' => 'cover',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_main_image_position', array(
		'section' => 'tt_font_secondline-themes-widgets-font',
		'priority'   => 536,
		'choices'     => array(
			'cover' => esc_html__( 'Image Cover', 'dixie-secondline' ),
			'repeat-all' => esc_html__( 'Image Pattern', 'dixie-secondline' ),
		),
		))
	);
	

	/* Setting - Footer - Footer Navigation */
	$wp_customize->add_setting( 'secondline_themes_footer_nav_location' ,array(
		'default' => 'bottom',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_footer_nav_location', array(
		'label'    => esc_html__( 'Footer Navigation Location', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-footer-nav-font',
		'priority'   => 5,
		'choices'     => array(
			'top' => esc_html__( 'Top', 'dixie-secondline' ),
			'middle' => esc_html__( 'Middle', 'dixie-secondline' ),
			'bottom' => esc_html__( 'Bottom', 'dixie-secondline' ),
		),
		))
	);
	
	/* Setting - Footer - Footer Navigation */
	$wp_customize->add_setting( 'secondline_themes_footer_nav_align' ,array(
		'default' => 'right',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_footer_nav_align', array(
		'label'    => esc_html__( 'Footer Navigation Alignment', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-footer-nav-font',
		'priority'   => 10,
		'choices'     => array(
			'secondline_themes_nav_footer_left' => esc_html__( 'Left', 'dixie-secondline' ),
			'secondline_themes_nav_footer_center' => esc_html__( 'Center', 'dixie-secondline' ),
			'right' => esc_html__( 'Right', 'dixie-secondline' ),
		),
		))
	);
	
	
	

	
	
	
	/* Setting - Footer - Footer Widgets */
	$wp_customize->add_section( 'secondline_themes_section_widget_layout', array(
		'title'          => esc_html__( 'Footer Widgets', 'dixie-secondline' ),
		'panel'          => 'secondline_themes_footer_panel', // Not typically needed.
		'priority'       => 450,
		) 
	);
	
 	/* Setting - Footer - Footer Widgets */
 	$wp_customize->add_setting( 'secondline_themes_footer_widget_count' ,array(
 		'default' => 'footer-4-slt',
 		'sanitize_callback' => 'secondline_themes_sanitize_choices',
 	) );
 	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_footer_widget_count', array(
 		'label'    => esc_html__( 'Footer Widget Count', 'dixie-secondline' ),
 		'section' => 'secondline_themes_section_widget_layout',
 		'priority'   => 10,
 		'choices'     => array(
 			'footer-1-slt' => '1',
 			'footer-2-slt' => '2',
			'footer-3-slt' => '3',
			'footer-4-slt' => '4',
			'footer-5-slt' => '5',
 		),
 		))
 	);
	
	
 	/* Setting - Footer - Footer Widgets */
	$wp_customize->add_setting('secondline_themes_widgets_margin_top',array(
		'default' => '120',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_widgets_margin_top', array(
		'label'    => esc_html__( 'Footer Widget Margin Top', 'dixie-secondline' ),
 		'section' => 'secondline_themes_section_widget_layout',
		'priority'   => 20,
		'choices'     => array(
			'min'  => 0,
			'max'  => 150,
			'step' => 1
		), ) ) 
	);
	
	
 	/* Setting - Footer - Footer Widgets */
	$wp_customize->add_setting('secondline_themes_widgets_margin_bottom',array(
		'default' => '80',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_widgets_margin_bottom', array(
		'label'    => esc_html__( 'Footer Widget Margin Bottom', 'dixie-secondline' ),
 		'section' => 'secondline_themes_section_widget_layout',
		'priority'   => 22,
		'choices'     => array(
			'min'  => 0,
			'max'  => 150,
			'step' => 1
		), ) ) 
	);
	
	


	

	
	
	
	
	
	
	
	
	 
	 
	 
	
	
	 
	 
	 
	 
  	
	 
	 

	 
	 
  	/* Section - Footer - Footer Icons */
  	$wp_customize->add_section( 'secondline_themes_section_footer_icons', array(
  		'title'          => esc_html__( 'Footer Icons', 'dixie-secondline' ),
  		'panel'          => 'secondline_themes_footer_panel', // Not typically needed.
  		'priority'       => 500,
  	) );
	
	

	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_icon_location' ,array(
		'default' => 'middle',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_footer_icon_location', array(
		'label'    => esc_html__( 'Footer Icon Location', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'priority'   => 2,
		'choices'     => array(
			'top' => esc_html__( 'Top', 'dixie-secondline' ),
			'middle' => esc_html__( 'Middle', 'dixie-secondline' ),
			'bottom' => esc_html__( 'Bottom', 'dixie-secondline' ),
		),
		))
	);
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_icon_location_align' ,array(
		'default' => 'center',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_footer_icon_location_align', array(
		'label'    => esc_html__( 'Footer Icon Alignment', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'priority'   => 3,
		'choices'     => array(
			'left' => esc_html__( 'Left', 'dixie-secondline' ),
			'center' => esc_html__( 'Center', 'dixie-secondline' ),
			'right' => esc_html__( 'Right', 'dixie-secondline' ),
		),
		))
	);
	


	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting('secondline_themes_footer_icon_size',array(
		'default' => '12',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_footer_icon_size', array(
		'label'    => esc_html__( 'Icon Size', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'priority'   => 4,
		'choices'     => array(
			'min'  => 0,
			'max'  => 50,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting('secondline_themes_footer_margin_top',array(
		'default' => '0', /* 100 */
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_footer_margin_top', array(
		'label'    => esc_html__( 'Icon Margin Top', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'priority'   => 5,
		'choices'     => array(
			'min'  => 0,
			'max'  => 150,
			'step' => 1
		), ) ) 
	);
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting('secondline_themes_footer_margin_bottom',array(
		'default' => '0', /* 75 */
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_footer_margin_bottom', array(
		'label'    => esc_html__( 'Icon Margin Bottom', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'priority'   => 6,
		'choices'     => array(
			'min'  => 0,
			'max'  => 150,
			'step' => 1
		), ) ) 
	);
	
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting('secondline_themes_footer_margin_sides',array(
		'default' => '5',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_footer_margin_sides', array(
		'label'    => esc_html__( 'Icon Margin Left/Right', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'priority'   => 7,
		'choices'     => array(
			'min'  => -3,
			'max'  => 150,
			'step' => 1
		), ) ) 
	);
	
	

	
	
 	/* Setting - Footer - Footer Icons */
 	$wp_customize->add_setting( 'secondline_themes_footer_icon_color', array(
 		'default'	=> 'rgba(255,255,255,0.7)',
 		'sanitize_callback' => 'sanitize_hex_color',
 	) );
 	$wp_customize->add_control(new secondline_themes_Customize_Alpha_Color_Control($wp_customize, 'secondline_themes_footer_icon_color', array(
 		'label'    => esc_html__( 'Footer Icon Color', 'dixie-secondline' ),
 		'section'  => 'secondline_themes_section_footer_icons',
 		'priority'   => 8,
 		)) 
 	);
	

	
 	/* Setting - Footer - Footer Icons */
 	$wp_customize->add_setting( 'secondline_themes_footer_icon_border_color', array(
		'default'	=> 'rgba(255,255,255,0.3)',
 		'sanitize_callback' => 'sanitize_hex_color',
 	) );
 	$wp_customize->add_control(new secondline_themes_Customize_Alpha_Color_Control($wp_customize, 'secondline_themes_footer_icon_border_color', array(
 		'label'    => esc_html__( 'Footer Icon Background Color', 'dixie-secondline' ),
 		'section'  => 'secondline_themes_section_footer_icons',
 		'priority'   => 8,
 		)) 
 	);
	
 	/* Setting - Footer - Footer Icons */
 	$wp_customize->add_setting( 'secondline_themes_footer_hover_icon_color', array(
 		'default'	=> 'rgba(0,0,0,1)',
 		'sanitize_callback' => 'sanitize_hex_color',
 	) );
 	$wp_customize->add_control(new secondline_themes_Customize_Alpha_Color_Control($wp_customize, 'secondline_themes_footer_hover_icon_color', array(
 		'label'    => esc_html__( 'Footer Icon Hover Color', 'dixie-secondline' ),
 		'section'  => 'secondline_themes_section_footer_icons',
 		'priority'   => 9,
 		)) 
 	);
	
 	/* Setting - Footer - Footer Icons */
 	$wp_customize->add_setting( 'secondline_themes_footer_hover_background_icon_color', array(
 		'default'	=> 'rgba(255,255,255,1)',
 		'sanitize_callback' => 'sanitize_hex_color',
 	) );
 	$wp_customize->add_control(new secondline_themes_Customize_Alpha_Color_Control($wp_customize, 'secondline_themes_footer_hover_background_icon_color', array(
 		'label'    => esc_html__( 'Footer Icon Hover Background', 'dixie-secondline' ),
 		'section'  => 'secondline_themes_section_footer_icons',
 		'priority'   => 10,
 		)) 
 	);
	
	
	
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_facebook' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_facebook', array(
		'label'          => esc_html__( 'Facebook Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 13,
		)
	);
	
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_twitter' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_twitter', array(
		'label'          => esc_html__( 'Twitter Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 15,
		)
	);
	
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_instagram' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_instagram', array(
		'label'          => esc_html__( 'Instagram Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 20,
		)
	);
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_spotify' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_spotify', array(
		'label'          => esc_html__( 'Spotify Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 25,
		)
	);
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_youtube' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_youtube', array(
		'label'          => esc_html__( 'Youtube Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 30,
		)
	);	
		
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_vimeo' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_vimeo', array(
		'label'          => esc_html__( 'Vimeo Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 35,
		)
	);
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_rss' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_rss', array(
		'label'          => esc_html__( 'RSS Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 30,
		)
	);
	
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_itunes' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_itunes', array(
		'label'          => esc_html__( 'iTunes Podcast Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 30,
		)
	);	
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_patreon' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_patreon', array(
		'label'          => esc_html__( 'Patreon Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 30,
		)
	);	
	
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_android' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_android', array(
		'label'          => esc_html__( 'Android Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 30,
		)
	);		
	
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_pinterest' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_pinterest', array(
		'label'          => esc_html__( 'Pinterest Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 45,
		)
	);
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_soundcloud' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_soundcloud', array(
		'label'          => esc_html__( 'Soundcloud Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 50,
		)
	);
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_linkedin' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_linkedin', array(
		'label'          => esc_html__( 'LinkedIn Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 52,
		)
	);
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_snapchat' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_snapchat', array(
		'label'          => esc_html__( 'Snapchat Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 55,
		)
	);
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_tumblr' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_tumblr', array(
		'label'          => esc_html__( 'Tumblr Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 60,
		)
	);
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_flickr' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_flickr', array(
		'label'          => esc_html__( 'Flickr Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 65,
		)
	);
	
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_dribbble' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_dribbble', array(
		'label'          => esc_html__( 'Dribbble Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 70,
		)
	);
	
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_vk' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_vk', array(
		'label'          => esc_html__( 'VK Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 75,
		)
	);
	
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_wordpress' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_wordpress', array(
		'label'          => esc_html__( 'WordPress Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 80,
		)
	);
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_mixcloud' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_mixcloud', array(
		'label'          => esc_html__( 'MixCloud Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 85,
		)
	);
	
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_behance' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_behance', array(
		'label'          => esc_html__( 'Behance Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 90,
		)
	);
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_github' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_github', array(
		'label'          => esc_html__( 'GitHub Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 95,
		)
	);
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_lastfm' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_lastfm', array(
		'label'          => esc_html__( 'Last.fm Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 100,
		)
	);
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_medium' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_medium', array(
		'label'          => esc_html__( 'Medium Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 105,
		)
	);
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_reddit' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_reddit', array(
		'label'          => esc_html__( 'Reddit Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 105,
		)
	);	
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_tripadvisor' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_tripadvisor', array(
		'label'          => esc_html__( 'Trip Advisor Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 110,
		)
	);
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_twitch' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_twitch', array(
		'label'          => esc_html__( 'Twitch Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 115,
		)
	);
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_yelp' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_yelp', array(
		'label'          => esc_html__( 'Yelp Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 120,
		)
	);
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_xing' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_xing', array(
		'label'          => esc_html__( 'Xing Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 120,
		)
	);	
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_skype' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_skype', array(
		'label'          => esc_html__( 'Skype Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 120,
		)
	);	
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_discord' ,array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_discord', array(
		'label'          => esc_html__( 'Discord Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 120,
		)
	);		
	
	
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_mail' ,array(
		'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_mail', array(
		'label'          => esc_html__( 'E-mail Icon', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_footer_icons',
		'type' => 'text',
		'priority'   => 150,
		)
	);
	
	
	
	
	

	


	
	/* Setting - Footer - Copyright */
	$wp_customize->add_setting( 'secondline_themes_footer_copyright' ,array(
		'default' =>  'Copyright 2018. Developed by <a href="//secondlinethemes.com/">SecondLine Themes</a>',
		'sanitize_callback' => 'secondline_themes_sanitize_customizer',
	) );
	$wp_customize->add_control( 'secondline_themes_footer_copyright', array(
		'label'          => esc_html__( 'Copyright Text', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-copyright-font',
		'type' => 'textarea',
		'priority'   => 10,
		)
	);
	
	/* Setting - Footer - Copyright */
	$wp_customize->add_setting( 'secondline_themes_copyright_bg', array(
		'sanitize_callback' => 'sanitize_hex_color',
		'default' => '#222426',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_copyright_bg', array(
		'label'    => esc_html__( 'Copyright Background', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-copyright-font',
		'priority'   => 150,
		)) 
	);
	
	

	/* Setting - Footer - Copyright */
	$wp_customize->add_setting( 'secondline_themes_copyright_link', array(
		'default' => '#6d8ae4',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_copyright_link', array(
		'label'    => esc_html__( 'Copyright Link Color', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-copyright-font',
		'priority'   => 530,
		)) 
	);
	
	/* Setting - Footer - Copyright */
	$wp_customize->add_setting( 'secondline_themes_copyright_link_hover', array(
		'default' => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_copyright_link_hover', array(
		'label'    => esc_html__( 'Copyright Link Hover Color', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-copyright-font',
		'priority'   => 540,
		)) 
	);
	
	
	/* Setting - Footer - Footer Icons */
	$wp_customize->add_setting( 'secondline_themes_footer_copyright_location' ,array(
		'default' => 'footer-copyright-align-center',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control(new secondline_themes_Controls_Radio_Buttonset_Control($wp_customize, 'secondline_themes_footer_copyright_location', array(
		'label'    => esc_html__( 'Copyright Text Alignment', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-copyright-font',
		'priority'   => 560,
		'choices'     => array(
			'footer-copyright-align-left' => esc_html__( 'Left', 'dixie-secondline' ),
			'footer-copyright-align-center' => esc_html__( 'Center', 'dixie-secondline' ),
			'footer-copyright-align-right' => esc_html__( 'Right', 'dixie-secondline' ),
		),
		))
	);
	
	
 	
	
	
 	/* Setting - Footer - Footer Widgets */
	$wp_customize->add_setting('secondline_themes_copyright_margin_top',array(
		'default' => '18',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_copyright_margin_top', array(
		'label'    => esc_html__( 'Copyright Padding Top', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-copyright-font',
		'priority'   => 20,
		'choices'     => array(
			'min'  => 0,
			'max'  => 150,
			'step' => 1
		), ) ) 
	);
	
	
 	/* Setting - Footer - Footer Widgets */
	$wp_customize->add_setting('secondline_themes_copyright_margin_bottom',array(
		'default' => '15',
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_copyright_margin_bottom', array(
		'label'    => esc_html__( 'Copyright Padding Bottom', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-copyright-font',
		'priority'   => 22,
		'choices'     => array(
			'min'  => 0,
			'max'  => 150,
			'step' => 1
		), ) ) 
	);

  
  
   
	
	
	
	
	
	
	
	
	
	
	/* Panel - Body */
	$wp_customize->add_panel( 'secondline_themes_blog_panel', array(
		'priority'    => 10,
        'title'       => esc_html__( 'Posts', 'dixie-secondline' ),
    ) );
	
	
	
    /* Section - Body - Blog Typography */
 	$wp_customize->add_setting( 'secondline_themes_blog_content_background', array(
 		'sanitize_callback' => 'sanitize_hex_color',
		'default' => '#ffffff',
 	) );
 	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_blog_content_background', array(
 		'label'    => esc_html__( 'Content Background', 'dixie-secondline' ),
 		'section' => 'tt_font_secondline-themes-blog-headings',
 		'priority'   => 3,
 		)) 
 	);
	
   /* Section - Body - Blog Typography */
	$wp_customize->add_setting( 'secondline_themes_blog_conent_border', array(
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_blog_conent_border', array(
		'label'    => esc_html__( 'Content Border Color', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-blog-headings',
		'priority'   => 4,
		)) 
	);
	
	
	
   /* Section - Body - Blog Typography */
	$wp_customize->add_setting( 'secondline_themes_blog_title_link', array(
		'default' => '#263669',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_blog_title_link', array(
		'label'    => esc_html__( 'Title Color', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-blog-headings',
		'priority'   => 5,
		)) 
	);
	
	
   /* Section - Body - Blog Typography */
	$wp_customize->add_setting( 'secondline_themes_blog_title_link_hover', array(
		'default' => '#2d2d2d',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_blog_title_link_hover', array(
		'label'    => esc_html__( 'Title Hover Color', 'dixie-secondline' ),
		'section' => 'tt_font_secondline-themes-blog-headings',
		'priority'   => 10,
		)) 
	);

	
	
	
	/* Panel - Body */
	$wp_customize->add_panel( 'secondline_themes_media_player', array(
		'priority'    => 10,
        'title'       => esc_html__( 'Media Player', 'dixie-secondline' ),
    ) );
	
	/* Section - General - General Layout */
	$wp_customize->add_section( 'secondline_themes_section_media_player', array(
		'title'          => esc_html__( 'Default Player Style', 'dixie-secondline' ),
		'panel'          => 'secondline_themes_media_player', // Not typically needed.
		'priority'       => 10,
		) 
	);    
	
	
    /* Section - Body - Blog Typography */
 	$wp_customize->add_setting( 'secondline_themes_player_background', array(
 		'sanitize_callback' => 'sanitize_hex_color',	        
 	) );
 	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_player_background', array(
 		'label'    => esc_html__( 'Main Player Background', 'dixie-secondline' ),
        'description'    => esc_html__( 'This option only works with the default WordPress media player', 'dixie-secondline' ),
 		'section' => 'secondline_themes_section_media_player',
 		'priority'   => 3,
 		)) 
 	);
	        

    /* Section - Body - Blog Typography */
 	$wp_customize->add_setting( 'secondline_themes_player_progressed', array(
 		'sanitize_callback' => 'sanitize_hex_color',	
        'default' => '#b2c3de',
 	) );
 	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_player_progressed', array(
 		'label'    => esc_html__( 'Progressed Background Color', 'dixie-secondline' ),
        'default' => '#b2c3de',
        'description'    => esc_html__( 'This option only works with the default WordPress media player', 'dixie-secondline' ),
 		'section' => 'secondline_themes_section_media_player',
 		'priority'   => 4,
 		)) 
 	);

    
        
    /* Section - Body - Blog Typography */
 	$wp_customize->add_setting( 'secondline_themes_player_knob', array(
 		'sanitize_callback' => 'sanitize_hex_color',	
 	) );
 	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_player_knob', array(
 		'label'    => esc_html__( 'Time/Volume Knob Background', 'dixie-secondline' ),
        'description'    => esc_html__( 'This option only works with the default WordPress media player', 'dixie-secondline' ),
 		'section' => 'secondline_themes_section_media_player',
 		'priority'   => 4,
 		)) 
 	);


        
    /* Section - Body - Blog Typography */
 	$wp_customize->add_setting( 'secondline_themes_player_time_text', array(
 		'sanitize_callback' => 'sanitize_hex_color',	
 	) );
 	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_player_time_text', array(
 		'label'    => esc_html__( 'Runtime Text Color', 'dixie-secondline' ),
        'description'    => esc_html__( 'This option only works with the default WordPress media player', 'dixie-secondline' ),
 		'section' => 'secondline_themes_section_media_player',
 		'priority'   => 6,
 		)) 
 	);
        
		
 	/* Setting - Footer - Footer Widgets */
	$wp_customize->add_setting('secondline_themes_player_time_text_size',array(
		'sanitize_callback' => 'secondline_themes_sanitize_choices',
	) );
	$wp_customize->add_control( new secondline_themes_Controls_Slider_Control($wp_customize, 'secondline_themes_player_time_text_size', array(
		'label'    => esc_html__( 'Runtime Text Size', 'dixie-secondline' ),
		'section' => 'secondline_themes_section_media_player',
		'priority'   => 22,
		'choices'     => array(
			'min'  => 0,
			'max'  => 32,
			'step' => 1
		), ) ) 
	);
		
    
    
    /* Section - Body - Blog Typography */
 	$wp_customize->add_setting( 'secondline_themes_player_icon', array(
 		'sanitize_callback' => 'sanitize_hex_color',	
 	) );
 	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_player_icon', array(
 		'label'    => esc_html__( 'Audio Icon Color', 'dixie-secondline' ),
        'description'    => esc_html__( 'This option only works with the default WordPress media player', 'dixie-secondline' ),
 		'section' => 'secondline_themes_section_media_player',
 		'priority'   => 7,
 		)) 
 	);        
        
    /* Section - Body - Blog Typography */
 	$wp_customize->add_setting( 'secondline_themes_player_icon_hover', array(
 		'sanitize_callback' => 'sanitize_hex_color',	
 	) );
 	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_player_icon_hover', array(
 		'label'    => esc_html__( 'Audio Icon Color Hover', 'dixie-secondline' ),
        'description'    => esc_html__( 'Hover colors for the default audio buttons', 'dixie-secondline' ),
 		'section' => 'secondline_themes_section_media_player',
 		'priority'   => 7,
 		)) 
 	);  	    

    /* Section - Body - Blog Typography */
 	$wp_customize->add_setting( 'secondline_themes_player_additional_icon', array(
 		'sanitize_callback' => 'sanitize_hex_color',	
 	) );
 	$wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondline_themes_player_additional_icon', array(
 		'label'    => esc_html__( 'Additional Icon Color', 'dixie-secondline' ),
        'description'    => esc_html__( 'Play in new window / download icons', 'dixie-secondline' ),
 		'section' => 'secondline_themes_section_media_player',
 		'priority'   => 8,
 		)) 
 	);                
        	
	
	
	/* Add WooCommerce Section */	
	$wp_customize->add_setting(
	   'secondline_woocmmerce_product_background', array(
		 'default'	=> '#f5f5f5',
		 'sanitize_callback' => 'secondline_themes_sanitize_customizer',
	   )
	);

	$wp_customize->add_control(
	  new secondline_themes_Customize_Alpha_Color_Control(
		$wp_customize, 'secondline_woocmmerce_product_background', array(
		  'default'	=> '#f5f5f5',
		  'label'    => esc_html__('Single Product Top Background', 'dixie-secondline'),
		  'section' => 'woocommerce_product_catalog',
		  'priority'   => 9,
		)
	  )
	);

	$wp_customize->add_setting(
	  'secondline_woocmmerce_product_index_background', array(
		'default'	=> '#f7f7f7',
		'sanitize_callback' => 'secondline_themes_sanitize_customizer',
	  )
	);

	$wp_customize->add_control(
	  new secondline_themes_Customize_Alpha_Color_Control(
		$wp_customize, 'secondline_woocmmerce_product_index_background', array(
		  'default'	=> '#f7f7f7',
		  'label'    => esc_html__('Product Index Background Color', 'dixie-secondline'),
		  'section' => 'woocommerce_product_catalog',
		  'priority'   => 10,
		)
	  )
	);	
	


	
}
add_action( 'customize_register', 'secondline_themes_customizer' );

//HTML Text
function secondline_themes_sanitize_customizer( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

//no-HTML text
function secondline_themes_sanitize_choices( $input ) {
	return wp_filter_nohtml_kses( $input );
}

function secondline_themes_customizer_styles() {
	global $post;
	
	//https://codex.wordpress.org/Function_Reference/wp_add_inline_style
	wp_enqueue_style( 'secondline-themes-custom-style', get_template_directory_uri() . '/css/secondline_themes_custom_styles.css' );

   if ( get_theme_mod( 'secondline_themes_header_bg_image')  ) {
      $secondline_themes_header_bg_image = "background-image:url(" . esc_attr( get_theme_mod( 'secondline_themes_header_bg_image' ) ) . ");";
	}	else {
		$secondline_themes_header_bg_image = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_header_drop_shadow') == 'on' ) {
      $secondline_themes_header_shadow_option = ".secondline-fixed-scrolled header#masthead-slt { box-shadow: 0px 2px 6px rgba(0,0,0, 0.06); }";
	}	else {
		$secondline_themes_header_shadow_option = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_header_bg_image_image_position', 'cover') == 'cover' ) {
      $secondline_themes_header_bg_cover = "background-repeat: no-repeat; background-position:center center; background-size: cover;";
	}	else {
		$secondline_themes_header_bg_cover = "background-repeat:repeat-all; ";
	}
	
   if ( get_theme_mod( 'secondline_themes_body_bg_image') ) {
      $secondline_themes_body_bg = "background-image:url(" .   esc_attr( get_theme_mod( 'secondline_themes_body_bg_image') ). ");";
	}	else {
		$secondline_themes_body_bg = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_body_bg_image_image_position', 'cover') == 'cover') {
      $secondline_themes_body_bg_cover = "background-repeat: no-repeat; background-position:center center; background-size: cover; background-attachment: fixed;";
	}	else {
		$secondline_themes_body_bg_cover = "background-repeat:repeat-all;";
	}
	
   if ( get_theme_mod( 'secondline_themes_page_title_image_position', 'cover') == 'cover' ) {
      $secondline_themes_page_tite_bg_cover = "background-repeat: no-repeat; background-position:center center; background-size: cover;";
	}	else {
		$secondline_themes_page_tite_bg_cover = "background-repeat:repeat-all;";
	}
	
	
   if ( get_theme_mod( 'secondline_themes_page_post_title_image_position', 'cover') == 'cover' ) {
      $secondline_themes_post_tite_bg_cover = "background-repeat: no-repeat; background-position:center center; background-size: cover;";
	}	else {
		$secondline_themes_post_tite_bg_cover = "background-repeat:repeat-all;";
	}
	
	if ( get_theme_mod( 'secondline_themes_blog_single_tags_display', 'true') == 'true' ) {
      $secondline_themes_blog_single_tags_display = "";
	}	else {
		$secondline_themes_blog_single_tags_display = "body .tags-secondline {display:none;}";
	}
	
   if ( get_theme_mod( 'secondline_themes_page_title_overlay_color') ) {
      $secondline_themes_page_tite_overlay_image_cover = "#page-title-slt:before {background:" .  esc_attr( get_theme_mod('secondline_themes_page_title_overlay_color') ) . "; }";
	}	else {
		$secondline_themes_page_tite_overlay_image_cover = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_post_title_filter_blur') || get_theme_mod( 'secondline_themes_post_title_filter_grayscale') || get_theme_mod( 'secondline_themes_post_title_filter_contrast') || get_theme_mod( 'secondline_themes_post_title_filter_invert') || get_theme_mod( 'secondline_themes_post_title_filter_saturate') || get_theme_mod( 'secondline_themes_post_title_filter_sepia') ) {
		$secondline_themes_post_title_filter = "body.single-post #page-title-slt-post-page:before, body.single-post #page-title-slt-show-page:before, body.single-podcast #page-title-slt-post-page:before, body.single-podcast #page-title-slt-show-page:before { backdrop-filter: blur(" .  esc_attr( get_theme_mod('secondline_themes_post_title_filter_blur', '0') ) . "px) grayscale(" .  esc_attr( get_theme_mod('secondline_themes_post_title_filter_grayscale', '0') ) . "%) contrast(" .  esc_attr( get_theme_mod('secondline_themes_post_title_filter_contrast', '100') ) . "%) invert(" .  esc_attr( get_theme_mod('secondline_themes_post_title_filter_invert', '0') ) . "%) saturate(" .  esc_attr( get_theme_mod('secondline_themes_post_title_filter_saturate', '100') ) . "%) sepia(" .  esc_attr( get_theme_mod('secondline_themes_post_title_filter_sepia', '0') ) . "%) hue-rotate(" .  esc_attr( get_theme_mod('secondline_themes_post_title_filter_hue', '0') ) . "deg); -webkit-backdrop-filter: blur(" .  esc_attr( get_theme_mod('secondline_themes_post_title_filter_blur', '0') ) . "px) grayscale(" .  esc_attr( get_theme_mod('secondline_themes_post_title_filter_grayscale', '0') ) . "%) contrast(" .  esc_attr( get_theme_mod('secondline_themes_post_title_filter_contrast', '100') ) . "%) invert(" .  esc_attr( get_theme_mod('secondline_themes_post_title_filter_invert', '0') ) . "%) saturate(" .  esc_attr( get_theme_mod('secondline_themes_post_title_filter_saturate', '100') ) . "%) sepia(" .  esc_attr( get_theme_mod('secondline_themes_post_title_filter_sepia', '0') ) . "%) hue-rotate(" .  esc_attr( get_theme_mod('secondline_themes_post_title_filter_hue', '0') ) . "deg)" . ";}";
	}	else {
		$secondline_themes_post_title_filter = "";
	}	
	
   if ( get_theme_mod( 'secondline_themes_post_title_overlay_color') ) {
      $secondline_themes_post_tite_overlay_image_cover = "#page-title-slt-post-page .secondline-themes-gallery .blog-single-gallery-post-format:before, #page-title-slt-post-page:before {background:" .  esc_attr( get_theme_mod('secondline_themes_post_title_overlay_color') ) . "; }";
	}	else {
		$secondline_themes_post_tite_overlay_image_cover = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_fixed_logo_width', '0') != '0' ) {
      $secondline_themes_fixed_logo_width = "width:" .  esc_attr( get_theme_mod('secondline_themes_fixed_logo_width', '70') ) . "px;";
	}	else {
		$secondline_themes_fixed_logo_width = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_fixed_logo_margin_top', '0') != '0' ) {
      $secondline_themes_fixed_logo_top = "padding-top:" .  esc_attr( get_theme_mod('secondline_themes_fixed_logo_margin_top', '31') ) . "px;";
	}	else {
		$secondline_themes_fixed_logo_top = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_fixed_logo_margin_bottom', '0') != '0' ) {
      $secondline_themes_fixed_logo_bottom = "padding-bottom:" .  esc_attr( get_theme_mod('secondline_themes_fixed_logo_margin_bottom', '31') ) . "px;";
	}	else {
		$secondline_themes_fixed_logo_bottom = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_fixed_nav_padding', '0') != '0' ) {
      $secondline_themes_fixed_nav_padding = "
		.secondline-fixed-scrolled .secondline-mini-banner-icon {
			top:" . esc_attr( (get_theme_mod('secondline_themes_fixed_nav_padding') - get_theme_mod('secondline_themes_nav_font_size', '14')) - 4 ). "px;
		}
		.secondline-fixed-scrolled #secondline-inline-icons .secondline-themes-social-icons a {
			padding-top:" . esc_attr( get_theme_mod('secondline_themes_fixed_nav_padding') - 3 ). "px;
			padding-bottom:" . esc_attr( get_theme_mod('secondline_themes_fixed_nav_padding') - 3 ). "px;
		}
		nav#secondline-themes-right-navigation ul {
			padding-top:" . esc_attr( get_theme_mod('secondline_themes_fixed_nav_padding') - 20 ). "px;
		}
		.secondline-fixed-scrolled #secondline-shopping-cart-count span.secondline-cart-count { top:" . esc_attr( get_theme_mod('secondline_themes_fixed_nav_padding') ). "px; }
		.secondline-fixed-scrolled #secondline-themes-header-search-icon i.fa-search, .secondline-fixed-scrolled #secondline-themes-header-cart-icon {
			padding-top:" . esc_attr( get_theme_mod('secondline_themes_fixed_nav_padding') - 5  ). "px;
			padding-bottom:" . esc_attr( get_theme_mod('secondline_themes_fixed_nav_padding') - 5 ). "px;
		}
		secondline-fixed-scrolled #secondline-shopping-cart-count a.secondline-count-icon-nav i.shopping-cart-header-icon {
					padding-top:" . esc_attr( get_theme_mod('secondline_themes_fixed_nav_padding') - 6  ). "px;
					padding-bottom:" . esc_attr( get_theme_mod('secondline_themes_fixed_nav_padding') - 6 ). "px;
		}
		.secondline-fixed-scrolled .sf-menu a {
			padding-top:" . esc_attr( get_theme_mod('secondline_themes_fixed_nav_padding') ). "px;
			padding-bottom:" . esc_attr( get_theme_mod('secondline_themes_fixed_nav_padding') ). "px;
		}
			";
	}	else {
		$secondline_themes_fixed_nav_padding = "";
	}
	
	
   if (  get_theme_mod( 'secondline_themes_fixed_nav_font_color') ) {
      $secondline_themes_fixed_nav_option_font_color = "
			.secondline-fixed-scrolled .active-mobile-icon-slt .mobile-menu-icon-slt, .secondline-fixed-scrolled .mobile-menu-icon-slt,  .secondline-fixed-scrolled .mobile-menu-icon-slt:hover,
	.secondline-fixed-scrolled #secondline-themes-header-search-icon i.fa-search,
	.secondline-fixed-scrolled #secondline-inline-icons .secondline-themes-social-icons a, .secondline-fixed-scrolled .sf-menu a, .secondline-fixed-scrolled #secondline-themes-header-cart-icon {
		color:" . esc_attr( get_theme_mod('secondline_themes_fixed_nav_font_color') ) . ";
	}";
	}	else {
		$secondline_themes_fixed_nav_option_font_color = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_fixed_nav_font_color_hover') ) {
      $secondline_themes_optional_fixed_nav_font_hover = "
		.secondline-fixed-scrolled #secondline-themes-header-search-icon:hover i.fa-search, .secondline-fixed-scrolled #secondline-themes-header-search-icon.active-search-icon-slt i.fa-search, .secondline-fixed-scrolled #secondline-inline-icons .secondline-themes-social-icons a:hover, .secondline-fixed-scrolled .sf-menu a:hover, .secondline-fixed-scrolled .sf-menu li.sfHover a, .secondline-fixed-scrolled .sf-menu li.current-menu-item a, .secondline-fixed-scrolled #secondline-themes-header-cart-icon:hover {
		color:" . esc_attr( get_theme_mod('secondline_themes_fixed_nav_font_color_hover') ) . ";
	}";
	}	else {
		$secondline_themes_optional_fixed_nav_font_hover = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_nav_bg') ) {
      $secondline_themes_optional_nav_bg = "background:" . esc_attr( get_theme_mod('secondline_themes_nav_bg') ). ";";
	}	else {
		$secondline_themes_optional_nav_bg = "";
	}
	
	
   if ( get_theme_mod( 'secondline_themes_slt_scroll_top', 'scroll-off-slt') == "scroll-off-slt" ) {
      $secondline_themes_scroll_top_disable = "display:none;";
	}	else {
		$secondline_themes_scroll_top_disable = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_copyright_bg', '#222426')) {
      $secondline_themes_copyright_optional_bg = "background:".  esc_attr( get_theme_mod('secondline_themes_copyright_bg', '#222426') ). "; ";
	}	else {
		$secondline_themes_copyright_optional_bg = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_nav_bg_hover') ) {
      $secondline_themes_optiona_nav_bg_hover = ".sf-menu a:hover, .sf-menu li.sfHover a, .sf-menu li.current-menu-item a { background:".  esc_attr( get_theme_mod('secondline_themes_nav_bg_hover') ). "; }";
	}	else {
		$secondline_themes_optiona_nav_bg_hover = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_fixed_nav_font_bg') ) {
      $secondline_themes_optiona_fixed_nav_font_bg = ".secondline-fixed-scrolled .sf-menu a { background:".  esc_attr( get_theme_mod('secondline_themes_fixed_nav_font_bg') ). "; }";
	}	else {
		$secondline_themes_optiona_fixed_nav_font_bg = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_fixed_nav_font_hover_bg') ) {
      $secondline_themes_optiona_fixed_nav_hover_bg = ".secondline-fixed-scrolled .sf-menu a:hover, .secondline-fixed-scrolled .sf-menu li.sfHover a, .secondline-fixed-scrolled .sf-menu li.current-menu-item a { background:".  esc_attr( get_theme_mod('secondline_themes_fixed_nav_font_hover_bg') ). "; }";
	}	else {
		$secondline_themes_optiona_fixed_nav_hover_bg = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_fixed_nav_font_color') ) {
      $secondline_themes_option_fixed_nav_font_color = ".secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled #secondline-inline-icons .secondline-themes-social-icons a, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled #secondline-themes-header-search-icon i.fa-search, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu a, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled #secondline-inline-icons .secondline-themes-social-icons a, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled #secondline-themes-header-search-icon i.fa-search, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu a, .secondline-fixed-scrolled #secondline-themes-header-cart-icon {
		color:". esc_attr( get_theme_mod('secondline_themes_fixed_nav_font_color') ). ";
	}";
	}	else {
		$secondline_themes_option_fixed_nav_font_color = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_fixed_nav_font_color_hover') ) {
      $secondline_themes_option_stickY_nav_font_hover_color = ".secondline_themes_force_light_navigation_color .secondline-fixed-scrolled #secondline-themes-header-search-icon:hover i.fa-search, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled #secondline-themes-header-search-icon.active-search-icon-slt i.fa-search, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled #secondline-inline-icons .secondline-themes-social-icons a:hover,  .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu a:hover, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover a, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.current-menu-item a,
	.secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled #secondline-themes-header-search-icon:hover i.fa-search, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled #secondline-themes-header-search-icon.active-search-icon-slt i.fa-search, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled #secondline-inline-icons .secondline-themes-social-icons a:hover,  .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu a:hover, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover a, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.current-menu-item a, .secondline-fixed-scrolled #secondline-themes-header-cart-icon {
		color:" . esc_attr( get_theme_mod('secondline_themes_fixed_nav_font_color_hover') ) . ";
	}";
	}	else {
		$secondline_themes_option_stickY_nav_font_hover_color = "";
	}
	


	
   if ( get_theme_mod( 'secondline_themes_fixed_nav_highlight_font') ) {
      $secondline_themes_option_fixed_hightlight_font_color = "body .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.highlight-button a:before, body .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.highlight-button a:before, .secondline-fixed-scrolled .sf-menu li.sfHover.highlight-button a, .secondline-fixed-scrolled .sf-menu li.current-menu-item.highlight-button a, .secondline-fixed-scrolled .sf-menu li.highlight-button a, .secondline-fixed-scrolled .sf-menu li.highlight-button a:hover { color:".  esc_attr( get_theme_mod('secondline_themes_fixed_nav_highlight_font') ). "; }";
	}	else {
		$secondline_themes_option_fixed_hightlight_font_color = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_fixed_nav_highlight_button') ) {
      $secondline_themes_option_fixed_hightlight_bg_color = "body .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.highlight-button a:hover, body .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.highlight-button a:hover, body .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.highlight-button a:before, body  .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.highlight-button a:before, .secondline-fixed-scrolled .sf-menu li.current-menu-item.highlight-button a:before, .secondline-fixed-scrolled .sf-menu li.highlight-button a:before { background:".  esc_attr( get_theme_mod('secondline_themes_fixed_nav_highlight_button') ). "; }";
	}	else {
		$secondline_themes_option_fixed_hightlight_bg_color = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_fixed_nav_highlight_button_hover') ) {
      $secondline_themes_option_fixed_hightlight_bg_color_hover = "body .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.highlight-button a:hover:before,  body .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.highlight-button a:hover:before,
	body .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.current-menu-item.highlight-button a:hover:before, body .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.highlight-button a:hover:before, .secondline-fixed-scrolled .sf-menu li.current-menu-item.highlight-button a:hover:before, .secondline-fixed-scrolled .sf-menu li.highlight-button a:hover:before { background:".  esc_attr( get_theme_mod('secondline_themes_fixed_nav_highlight_button_hover') ). "; }";
	}	else {
		$secondline_themes_option_fixed_hightlight_bg_color_hover = "";
	}

   if ( get_theme_mod( 'secondline_themes_mobile_header_bg') ) {
      $secondline_themes_mobile_header_bg_color = ".secondline-themes-transparent-header header#masthead-slt, header#masthead-slt {background:". esc_attr( get_theme_mod('secondline_themes_mobile_header_bg') ) . ";  }";
	}	else {
		$secondline_themes_mobile_header_bg_color = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_mobile_header_logo_width') ) {
      $secondline_themes_mobile_header_logo_width = "body #logo-slt img { width:" . esc_attr( get_theme_mod('secondline_themes_mobile_header_logo_width') ). "px; } ";
	}	else {
		$secondline_themes_mobile_header_logo_width = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_mobile_header_logo_margin') ) {
      $secondline_themes_mobile_header_logo_margin_top = " body #logo-slt img { padding-top:". esc_attr( get_theme_mod('secondline_themes_mobile_header_logo_margin') ). "px; padding-bottom:". esc_attr( get_theme_mod('secondline_themes_mobile_header_logo_margin') ). "px; }";
	}	else {
		$secondline_themes_mobile_header_logo_margin_top = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_header_border_bottom_color', 'rgba(255,255,255, 0.1)') ) {
      $secondline_themes_main_header_border = "
		 header#masthead-slt:after { display:block; background:" . esc_attr( get_theme_mod('secondline_themes_header_border_bottom_color' , 'rgba(255,255,255, 0.1)' ) ) . ";
	}";
	}	else {
		$secondline_themes_main_header_border = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_fixed_nav_border_color', 'rgba(0,0,0,0.15)') ) {
      $secondline_themes_fixed_nav_border = "
		 .secondline-fixed-scrolled  header#masthead-slt:after { display:block; background:" . esc_attr( get_theme_mod('secondline_themes_fixed_nav_border_color', 'rgba(0,0,0,0.15)') ) . ";
	}";
	}	else {
		$secondline_themes_fixed_nav_border = ".secondline-fixed-scrolled header#masthead-slt:after { opacity:0; }";
	}
	
   if ( get_theme_mod( 'secondline_themes_mobile_header_nav_padding') ) {
      $secondline_themes_mobile_header_nav_padding_top = "		#secondline-shopping-cart-count span.secondline-cart-count {top:" . esc_attr( get_theme_mod('secondline_themes_mobile_header_nav_padding')  ) . "px;}
		.mobile-menu-icon-slt {padding-top:" . esc_attr( get_theme_mod('secondline_themes_mobile_header_nav_padding') - 3 ) . "px; padding-bottom:" . esc_attr( get_theme_mod('secondline_themes_mobile_header_nav_padding') - 5 ) . "px; }
		#secondline-shopping-cart-count a.secondline-count-icon-nav i.shopping-cart-header-icon {
			padding-top:" . esc_attr( get_theme_mod('secondline_themes_mobile_header_nav_padding') - 6 ) . "px;
			padding-bottom:" . esc_attr( get_theme_mod('secondline_themes_mobile_header_nav_padding') - 6 ) . "px;
		}";
	}	else {
		$secondline_themes_mobile_header_nav_padding_top = "";
	}
	

	
   if ( get_theme_mod( 'secondline_themes_footer_main_bg_image') ) {
      $secondline_themes_footer_bg_image = "background-image:url(" . esc_attr( get_theme_mod( 'secondline_themes_footer_main_bg_image') ) . ");";
	}	else {
		$secondline_themes_footer_bg_image = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_main_image_position', 'cover') == 'cover' ) {
      $secondline_themes_main_image_position_cover = "background-repeat: no-repeat; background-position:center center; background-size: cover;";
	}	else {
		$secondline_themes_main_image_position_cover = "background-repeat:repeat-all;";
	}
	
	
   if (  function_exists('z_taxonomy_image_url') && z_taxonomy_image_url() ) {
      $secondline_themes_custom_tax_page_title_img = "body #page-title-slt {background-image:url('" . esc_url( z_taxonomy_image_url() ) . "'); }";
	}	else {
		$secondline_themes_custom_tax_page_title_img = "";
	}
	
   if ( is_page() && get_post_meta($post->ID, 'secondline_themes_header_image', true ) ) {
      $secondline_themes_custom_page_title_img = "body #page-title-slt {background-image:url('" . esc_url( get_post_meta($post->ID, 'secondline_themes_header_image', true)) . "'); }";
	}	else {
		$secondline_themes_custom_page_title_img = "";
	}
    
   if ( ( is_singular('post') || is_singular('podcast') || is_singular('episode') || is_singular('product') || is_singular('download') ) && get_post_meta($post->ID, 'secondline_themes_header_image', true ) ) {
      $secondline_themes_custom_post_slt_title_img = "body #page-title-slt-post-page {background-image:url('" . esc_url( get_post_meta($post->ID, 'secondline_themes_header_image', true)) . "'); }";
	}	else {
		$secondline_themes_custom_post_slt_title_img = "";
	}    
    
   if ( get_option( 'page_for_posts' ) ) {
		$cover_page = get_page( get_option( 'page_for_posts' ));
		 if ( is_home() && get_post_meta($cover_page->ID, 'secondline_themes_header_image', true) || is_singular( 'post') && get_post_meta($cover_page->ID, 'secondline_themes_header_image', true)|| is_category( ) && get_post_meta($cover_page->ID, 'secondline_themes_header_image', true) ) {
			$secondline_themes_blog_header_img = "body #page-title-slt {background-image:url('" .  esc_url( get_post_meta($cover_page->ID, 'secondline_themes_header_image', true) ). "'); }";
		} else {
		$secondline_themes_blog_header_img = ""; }
	}	else {
		$secondline_themes_blog_header_img = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_page_title_underline_color') ) {
      $secondline_themes_page_title_optional_underline = "#page-title-slt h1:after {background:" . esc_attr( get_theme_mod('secondline_themes_page_title_underline_color') )  . "; display:block;}";
	}	else {
		$secondline_themes_page_title_optional_underline = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_top_header_background', '#4c4b46') ) {
      $secondline_themes_top_header_background_option = "background:" . esc_attr( get_theme_mod('secondline_themes_top_header_background', '#4c4b46') )  . ";";
	}	else {
		$secondline_themes_top_header_background_option = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_top_header_border_bottom') ) {
      $secondline_themes_top_header_border_bottom_option = "border-bottom:1px solid " . esc_attr( get_theme_mod('secondline_themes_top_header_border_bottom') )  . ";";
	}	else {
		$secondline_themes_top_header_border_bottom_option = "";
	}
	
	
   if ( get_theme_mod( 'secondline_themes_blog_content_background', '#ffffff') ) {
      $secondline_themes_blog_background_content = ".secondline-blog-content { background:".  esc_attr( get_theme_mod('secondline_themes_blog_content_background', '#ffffff') ). "; }";
	}	else {
		$secondline_themes_blog_background_content = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_blog_conent_border') ) {
      $secondline_themes_blog_background_content_border = ".secondline-blog-content { border:1px solid ".  esc_attr( get_theme_mod('secondline_themes_blog_conent_border') ). ";  }";
	}	else {
		$secondline_themes_blog_background_content_border = "";
	}
	
   if ( get_theme_mod( 'secondline_themes_blog_excerpt_display') == 'false' ) {
      $secondline_themes_blog_excerpt_display = "body.archive .secondline-themes-default-blog-index .secondline-themes-blog-excerpt p, body.search .secondline-themes-default-blog-index .secondline-themes-blog-excerpt p {display: none;}";
	}	else {
		$secondline_themes_blog_excerpt_display = "";
	}	
	
	if ( get_theme_mod( 'secondline_themes_blog_audio_player_display', 'false') == 'false' ) {
		$secondline_themes_blog_audio_player_display = "body.blog .post-list-player-container-secondline, body.archive .post-list-player-container-secondline, body.search .post-list-player-container-secondline {display: none;}";
	} else {
		$secondline_themes_blog_audio_player_display = "";
	}		
	

    $secondline_themes_boxed_layout = "";
	
	$secondline_themes_custom_css = "
	$secondline_themes_custom_page_title_img
	$secondline_themes_custom_tax_page_title_img
	$secondline_themes_blog_header_img
    $secondline_themes_custom_post_slt_title_img
	body #logo-slt img {
		width:" .  esc_attr( get_theme_mod('secondline_themes_theme_logo_width', '123') ) . "px;
		padding-top:" .  esc_attr( get_theme_mod('secondline_themes_theme_logo_margin_top', '23') ) . "px;
		padding-bottom:" .  esc_attr( get_theme_mod('secondline_themes_theme_logo_margin_bottom', '25') ) . "px;
	}
	#boxed-layout-slt #content-slt p.stars a, #boxed-layout-slt #content-slt p.stars a:hover, #boxed-layout-slt #content-slt .star-rating, a, body #content-slt ul.products li.product .price, #secondline-woocommerce-single-top p.price, .secondline-post-meta i, #secondline-woocommerce-single-bottom .woocommerce-tabs ul.wc-tabs li.active a,
	.woocommerce-variation .woocommerce-variation-price, .woocommerce-variation .woocommerce-variation-price span.price span, body.woocommerce #content-slt div.product span.price, #secondline-woocommerce-single-bottom .woocommerce-tabs ul.wc-tabs li.active a {
		color:" .  esc_attr( get_theme_mod('secondline_themes_default_link_color', '#263669') ) . ";
	}
	a:hover {
		color:" .  esc_attr( get_theme_mod('secondline_themes_default_link_hover_color', '#2d2d2d') ). ";
	}
	header .sf-mega {margin-left:-" .  esc_attr( get_theme_mod('secondline_themes_site_width', '1400') / 2 ) . "px; width:" .  esc_attr( get_theme_mod('secondline_themes_site_width', '1400') ) . "px;}
	body .elementor-section.elementor-section-boxed > .elementor-container {max-width:" .  esc_attr( get_theme_mod('secondline_themes_site_width', '1400') ) . "px;}
	.width-container-slt {  width:" .  esc_attr( get_theme_mod('secondline_themes_site_width', '1400') ) . "px; }
	body.secondline-themes-header-sidebar-before #secondline-inline-icons .secondline-themes-social-icons, body.secondline-themes-header-sidebar-before:before, header#masthead-slt {
		background-color:" .  esc_attr( get_theme_mod('secondline_themes_header_background_color') ) . ";
		$secondline_themes_header_bg_image
		$secondline_themes_header_bg_cover
	}
	$secondline_themes_header_shadow_option
	$secondline_themes_main_header_border
	$secondline_themes_fixed_nav_border
	body {
		background-color:" .   esc_attr( get_theme_mod('secondline_themes_background_color', '#ffffff') ). ";
		$secondline_themes_body_bg
		$secondline_themes_body_bg_cover
	}
	#page-title-slt {
		background-color:" .   esc_attr( get_theme_mod('secondline_themes_page_title_bg_color', '#000000') ). ";
		background-image:url(" .   esc_attr( get_theme_mod( 'secondline_themes_page_title_bg_image',  get_template_directory_uri().'/images/page-title.jpg' ) ). ");
		padding-top:" . esc_attr( get_theme_mod('secondline_themes_page_title_padding_top', '184') ). "px;
		padding-bottom:" .  esc_attr( get_theme_mod('secondline_themes_page_title_padding_bottom', '130') ). "px;
		$secondline_themes_page_tite_bg_cover
	}
	$secondline_themes_page_tite_overlay_image_cover
	$secondline_themes_page_title_optional_underline
	.sidebar-item { background:" .   esc_attr( get_theme_mod('secondline_themes_sidebar_background') ). "; }
	.sidebar-item { margin-bottom:" .   esc_attr( get_theme_mod('secondline_themes_sidebar_spacing') ). "px; }
	.sidebar ul ul, .sidebar ul li, .widget .widget_shopping_cart_content p.buttons { border-color:" .   esc_attr( get_theme_mod('secondline_themes_sidebar_divider', '#e5e5e5') ). "; }
	
	/* START BLOG STYLES */	
	#page-title-slt-post-page {
		background-color: " . esc_attr( get_theme_mod('secondline_themes_post_title_bg_color', '#000000') ) . ";
		background-image:url(" .   esc_attr( get_theme_mod( 'secondline_themes_post_page_title_bg_image',  get_template_directory_uri().'/images/page-title.jpg' ) ). ");
		$secondline_themes_post_tite_bg_cover
	}
	$secondline_themes_post_tite_overlay_image_cover
	$secondline_themes_post_title_filter
	$secondline_themes_blog_single_tags_display

	.secondline-themes-feaured-image {background:" . esc_attr( get_theme_mod('secondline_themes_blog_image_bg') ) . ";}
	body.blog a.more-link, body.archive a.more-link, body.search a.more-link {color:" . esc_attr( get_theme_mod('secondline_themes_blog_read_more') ) . ";}
	.secondline-themes-default-blog-overlay:hover a img, .secondline-themes-feaured-image:hover a img { opacity:" . esc_attr( get_theme_mod('secondline_themes_blog_image_opacity', '1') ) . ";}
	h2.secondline-blog-title a {color:" . esc_attr( get_theme_mod('secondline_themes_blog_title_link', '#263669') ) . ";}
	h2.secondline-blog-title a:hover {color:" . esc_attr( get_theme_mod('secondline_themes_blog_title_link_hover', '#2d2d2d') ) . ";}
	body h2.overlay-secondline-blog-title, body .overlay-blog-meta-category-list span, body .secondline-themes-default-blog-overlay .secondline-post-meta, body  .overlay-blog-floating-comments-viewcount {color:" . esc_attr( get_theme_mod('secondline_themes_overlay_blog_title_link', '#ffffff') ) . ";}
	$secondline_themes_blog_background_content
	$secondline_themes_blog_background_content_border
	#page-title-slt-post-page, #page-title-slt-post-page .secondline-themes-gallery .blog-single-gallery-post-format { min-height:" . esc_attr( get_theme_mod('secondline_themes_blog_post_height', '700') ) . "px; }
	#blog-post-title-meta-container { padding-top:" . esc_attr( get_theme_mod('secondline_themes_blog_post_meta_padding_top', '300') ) . "px; padding-bottom:" . esc_attr( get_theme_mod('secondline_themes_blog_post_meta_padding', '105') ) . "px; }
	$secondline_themes_blog_audio_player_display
	$secondline_themes_blog_excerpt_display
	/* END BLOG STYLES */
	
	/* START BUTTON STYLES */
	#boxed-layout-slt .form-submit input#submit, #boxed-layout-slt input.button, #boxed-layout-slt #customer_login input.button, #boxed-layout-slt button.button, #boxed-layout-slt a.button, .infinite-nav-slt a, #newsletter-form-fields input.button, a.secondline-themes-button, .secondline-themes-sticky-post, .post-password-form input[type=submit], #respond input#submit, .wpcf7-form input.wpcf7-submit, #main-container-secondline .form-submit input#submit, #main-container-secondline input.button, #main-container-secondline button.button, #main-container-secondline a.button, #main-container-secondline .wp-block-button a.wp-block-button__link, #content-slt button.wpforms-submit {
		font-size:" . esc_attr( get_theme_mod('secondline_themes_button_font_size', '12') ) . "px;
		background:" . esc_attr( get_theme_mod('secondline_themes_button_background', '#263669') ) . ";
		color:" . esc_attr( get_theme_mod('secondline_themes_button_font', '#ffffff') ) . ";
	}
	#boxed-layout-slt button.button, #boxed-layout-slt a.button { font-size:" . esc_attr( get_theme_mod('secondline_themes_button_font_size', '12') - 1 ) . "px; }
	#boxed-layout-slt .form-submit input#submit:hover, #boxed-layout-slt input.button:hover, #boxed-layout-slt #customer_login input.button:hover, #boxed-layout-slt button.button:hover, #boxed-layout-slt a.button:hover, .infinite-nav-slt a:hover, #newsletter-form-fields input.button:hover, a.secondline-themes-button:hover, .post-password-form input[type=submit]:hover, #respond input#submit:hover, .wpcf7-form input.wpcf7-submit:hover, #main-container-secondline .wp-block-button a.wp-block-button__link:hover, #content-slt button.wpforms-submit:hover {
		background:" . esc_attr( get_theme_mod('secondline_themes_button_background_hover', '#2d2d2d') ) . ";
		color:" . esc_attr( get_theme_mod('secondline_themes_button_font_hover', '#ffffff') ) . ";
	}
	form#mc-embedded-subscribe-form  .mc-field-group input:focus, .widget select:focus, #newsletter-form-fields input:focus, .wpcf7-form select:focus, blockquote, .post-password-form input:focus, .search-form input.search-field:focus, #respond textarea:focus, #respond input:focus, .wpcf7-form input:focus, .wpcf7-form textarea:focus, .wp-block-pullquote, #content-slt .wpforms-container select:focus, #content-slt .wpforms-container input:focus, #content-slt .wpforms-container textarea:focus { border-color:" . esc_attr( get_theme_mod('secondline_themes_button_background', '#263669') ) . ";  }
	
	body .mc4wp-form input[type='submit'] {background-color:" . esc_attr( get_theme_mod('secondline_themes_newsletter_button_background', '#20bb60') ) . ";  }
	body .mc4wp-form input[type='submit']:hover {background-color:" . esc_attr( get_theme_mod('secondline_themes_newsletter_button_background_hover', '#2d2d2d') ) . ";  }
	
	/* END BUTTON STYLES */
	
	/* START Fixed Nav Styles */
	.secondline-themes-transparent-header .secondline-fixed-scrolled header#masthead-slt, .secondline-fixed-scrolled header#masthead-slt, #secondline-fixed-nav.secondline-fixed-scrolled { background-color:" .   esc_attr( get_theme_mod('secondline_themes_fixed_nav_background_color', 'rgba(255,255,255, 0.7)') ) ."; }
	body .secondline-fixed-scrolled #logo-slt img {
		$secondline_themes_fixed_logo_width
		$secondline_themes_fixed_logo_top
		$secondline_themes_fixed_logo_bottom
	}
	$secondline_themes_fixed_nav_padding
	$secondline_themes_fixed_nav_option_font_color	
	$secondline_themes_optional_fixed_nav_font_hover
	/* END Fixed Nav Styles */
	/* START Main Navigation Customizer Styles */
	#secondline-shopping-cart-count a.secondline-count-icon-nav, nav#site-navigation { letter-spacing: ". esc_attr( get_theme_mod('secondline_themes_nav_letterspacing', '0.5') ). "px; }
	#secondline-inline-icons .secondline-themes-social-icons a {
		color:" . esc_attr( get_theme_mod('secondline_themes_nav_font_color', '#ffffff') ). ";
		padding-top:" . esc_attr( get_theme_mod('secondline_themes_nav_padding', '42') +1 ). "px;
		padding-bottom:" . esc_attr( get_theme_mod('secondline_themes_nav_padding', '42') +1 ). "px;
		font-size:" . esc_attr( get_theme_mod('secondline_themes_nav_font_size', '14')  ). "px;
	}
	.mobile-menu-icon-slt {
		min-width:" . esc_attr( get_theme_mod('secondline_themes_nav_font_size', '14') + 6 ). "px;
		color:" . esc_attr( get_theme_mod('secondline_themes_nav_font_color', '#ffffff') ). ";
		padding-top:" . esc_attr( get_theme_mod('secondline_themes_nav_padding', '42') - 3 ). "px;
		padding-bottom:" . esc_attr( get_theme_mod('secondline_themes_nav_padding', '42') - 5 ). "px;
		font-size:" . esc_attr( get_theme_mod('secondline_themes_nav_font_size', '14') + 6 ). "px;
	}
	.mobile-menu-icon-slt span.secondline-mobile-menu-text {
		font-size:" . esc_attr( get_theme_mod('secondline_themes_nav_font_size', '14') ). "px;
	}
	#secondline-shopping-cart-count span.secondline-cart-count {
		top:" . esc_attr( get_theme_mod('secondline_themes_nav_padding', '42') - 1). "px;
	}
	#secondline-shopping-cart-count a.secondline-count-icon-nav i.shopping-cart-header-icon {
		color:" . esc_attr( get_theme_mod('secondline_themes_nav_cart_icon_main_color', '#ffffff') ). ";
		background:" . esc_attr( get_theme_mod('secondline_themes_nav_cart_icon_main_bg', '#213a70') ). ";
		padding-top:" . esc_attr( get_theme_mod('secondline_themes_nav_padding', '42') - 6 ). "px;
		padding-bottom:" . esc_attr( get_theme_mod('secondline_themes_nav_padding', '42') - 6 ). "px;
		font-size:" . esc_attr( get_theme_mod('secondline_themes_nav_font_size', '14') + 12 ). "px;
	}
	#secondline-shopping-cart-count a.secondline-count-icon-nav i.shopping-cart-header-icon:hover,
	.activated-class #secondline-shopping-cart-count a.secondline-count-icon-nav i.shopping-cart-header-icon { 
		color:" . esc_attr( get_theme_mod('secondline_themes_nav_cart_icon_main_color', '#ffffff') ). ";
		background:" . esc_attr( get_theme_mod('secondline_themes_nav_cart_icon_main_bg_hover', '#254682') ). ";
	}
	#secondline-themes-header-search-icon i.fa-search, #secondline-themes-header-cart-icon {
		color:" . esc_attr( get_theme_mod('secondline_themes_nav_font_color', '#ffffff') ). ";
		padding-top:" . esc_attr( get_theme_mod('secondline_themes_nav_padding', '42') ). "px;
		padding-bottom:" . esc_attr( get_theme_mod('secondline_themes_nav_padding', '42') ). "px;
		font-size:" . esc_attr( get_theme_mod('secondline_themes_nav_font_size', '14') + 1 ). "px;
		line-height: 1;
	}
	nav#secondline-themes-right-navigation ul {
		padding-top:" . esc_attr( get_theme_mod('secondline_themes_nav_padding', '42') - 20 ). "px;
	}
	nav#secondline-themes-right-navigation ul li a {
		font-size:" . esc_attr( get_theme_mod('secondline_themes_nav_font_size', '14') ). "px;
	}
	.sf-menu a {
		color:" . esc_attr( get_theme_mod('secondline_themes_nav_font_color', '#ffffff') ). ";
		padding-top:" . esc_attr( get_theme_mod('secondline_themes_nav_padding', '42') ). "px;
		padding-bottom:" . esc_attr( get_theme_mod('secondline_themes_nav_padding', '42') ). "px;
		font-size:" . esc_attr( get_theme_mod('secondline_themes_nav_font_size', '14') ). "px;
		$secondline_themes_optional_nav_bg
	}
	.secondline_themes_force_light_navigation_color .secondline-fixed-scrolled  #secondline-inline-icons .secondline-themes-social-icons a,
	.secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled  #secondline-inline-icons .secondline-themes-social-icons a,
	.secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled #secondline-themes-header-search-icon i.fa-search, 
	.secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu a,
	.secondline_themes_force_light_navigation_color .secondline-fixed-scrolled #secondline-themes-header-search-icon i.fa-search, 
	.secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu a  {
		color:" . esc_attr( get_theme_mod('secondline_themes_nav_font_color', '#ffffff') ). ";
	}
	.secondline_themes_force_light_navigation_color .secondline-fixed-scrolled  #secondline-inline-icons .secondline-themes-social-icons a:hover,
	.secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled  #secondline-inline-icons .secondline-themes-social-icons a:hover,
	.active-mobile-icon-slt .mobile-menu-icon-slt,
	.mobile-menu-icon-slt:hover,
	.secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled #secondline-themes-header-search-icon:hover i.fa-search, 
	.secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled #secondline-themes-header-search-icon.active-search-icon-slt i.fa-search, 
	.secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled #secondline-inline-icons .secondline-themes-social-icons a:hover, 
	.secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled #secondline-shopping-cart-count a.secondline-count-icon-nav:hover, 
	.secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu a:hover, 
	.secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover a, 
	.secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.current-menu-item a,
	.secondline_themes_force_light_navigation_color .secondline-fixed-scrolled #secondline-themes-header-search-icon:hover i.fa-search, 
	.secondline_themes_force_light_navigation_color .secondline-fixed-scrolled #secondline-themes-header-search-icon.active-search-icon-slt i.fa-search, 
	.secondline_themes_force_light_navigation_color .secondline-fixed-scrolled #secondline-inline-icons .secondline-themes-social-icons a:hover, 
	.secondline_themes_force_light_navigation_color .secondline-fixed-scrolled #secondline-shopping-cart-count a.secondline-count-icon-nav:hover, 
	.secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu a:hover, 
	.secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover a, 
	.secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.current-menu-item a,
	#secondline-themes-header-search-icon:hover i.fa-search, #secondline-themes-header-search-icon.active-search-icon-slt i.fa-search, #secondline-inline-icons .secondline-themes-social-icons a:hover, #secondline-shopping-cart-count a.secondline-count-icon-nav:hover, .sf-menu a:hover, .sf-menu li.sfHover a, .sf-menu li.current-menu-item a, #secondline-themes-header-cart-icon:hover {
		color:". esc_attr( get_theme_mod('secondline_themes_nav_font_color_hover', '#ffffff') ) . ";
	}
    .sf-menu a:hover:before, .sf-menu li.sfHover a:before, .sf-menu li.current-menu-item a:before {
        background:". esc_attr( get_theme_mod('secondline_themes_nav_font_color_hover', '#ffffff') ) . ";
        opacity: 1;
    }
    
	#secondline-checkout-basket, .sf-menu ul {
		background:".  esc_attr( get_theme_mod('secondline_themes_sub_nav_bg', '#ffffff') ). ";
	}	
	body #panel-search-secondline {
		background:".  esc_attr( get_theme_mod('secondline_themes_header_background_color') ). ";
	}		
	#main-nav-mobile { background:".  esc_attr( get_theme_mod('secondline_themes_sub_nav_bg', '#ffffff') ). "; }
	#main-nav-mobile { border-top:2px solid ".  esc_attr( get_theme_mod('secondline_themes_sub_nav_border_top_color', '#b2c3de') ). "; }
	ul.mobile-menu-slt li a { color:" . esc_attr( get_theme_mod('secondline_themes_sub_nav_font_color', '#263669') ) . "; }
	ul.mobile-menu-slt .sf-mega .sf-mega-section li a, ul.mobile-menu-slt .sf-mega .sf-mega-section, ul.mobile-menu-slt.collapsed li a, .sf-menu li li:last-child li a, .sf-mega li:last-child li a {border-color:" . esc_attr( get_theme_mod('secondline_themes_sub_nav_border_color', '#efefef') ) . ";}
	
	#panel-search-secondline, .sf-menu ul {border-color:".  esc_attr( get_theme_mod('secondline_themes_sub_nav_border_top_color', '#b2c3de') ). ";}
	.sf-menu li li a { 
		letter-spacing:".  esc_attr( get_theme_mod('secondline_themes_sub_nav_letterspacing', '0') ). "px;
		font-size:".  esc_attr( get_theme_mod('secondline_themes_sub_nav_font_size', '13') ). "px;
	}
	#secondline-checkout-basket .secondline-sub-total {
		font-size:".  esc_attr( get_theme_mod('secondline_themes_sub_nav_font_size', '13' ) ). "px;
	}
	#panel-search-secondline input, #secondline-checkout-basket ul#secondline-cart-small li.empty { 
		font-size:".  esc_attr( get_theme_mod('secondline_themes_sub_nav_font_size', '13' ) ). "px;
	}
	.secondline-fixed-scrolled #secondline-checkout-basket, .secondline-fixed-scrolled #secondline-checkout-basket a, .secondline-fixed-scrolled .sf-menu li.sfHover li a, .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li a, .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li a, .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li a, .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li a, #panel-search-secondline .search-form input.search-field, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li a, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li a, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li a, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li a, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li a, .secondline_themes_force_dark_navigation_color .sf-menu li.sfHover li a, .secondline_themes_force_dark_navigation_color .sf-menu li.sfHover li.sfHover li a, .secondline_themes_force_dark_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li a, .secondline_themes_force_dark_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li a, .secondline_themes_force_dark_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li a, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li a, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li a, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li a, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li a, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li a, .secondline_themes_force_light_navigation_color .sf-menu li.sfHover li a, .secondline_themes_force_light_navigation_color .sf-menu li.sfHover li.sfHover li a, .secondline_themes_force_light_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li a, .secondline_themes_force_light_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li a, .secondline_themes_force_light_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li a, .sf-menu li.sfHover.highlight-button li a, .sf-menu li.current-menu-item.highlight-button li a, .secondline-fixed-scrolled #secondline-checkout-basket a.cart-button-header-cart:hover, .secondline-fixed-scrolled #secondline-checkout-basket a.checkout-button-header-cart:hover, #secondline-checkout-basket a.cart-button-header-cart:hover, #secondline-checkout-basket a.checkout-button-header-cart:hover, #secondline-checkout-basket, #secondline-checkout-basket a, .sf-menu li.sfHover li a, .sf-menu li.sfHover li.sfHover li a, .sf-menu li.sfHover li.sfHover li.sfHover li a, .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li a, .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li a {
		color:" . esc_attr( get_theme_mod('secondline_themes_sub_nav_font_color', '#263669') ) . ";
	}
	.secondline-fixed-scrolled .sf-menu li li a:hover,  .secondline-fixed-scrolled .sf-menu li.sfHover li a, .secondline-fixed-scrolled .sf-menu li.current-menu-item li a, .sf-menu li.sfHover li a, .sf-menu li.sfHover li.sfHover li a, .sf-menu li.sfHover li.sfHover li.sfHover li a, .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li a, .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li a { 
		background:none;
	}
	.secondline-fixed-scrolled #secondline-checkout-basket a:hover, .secondline-fixed-scrolled #secondline-checkout-basket ul#secondline-cart-small li h6, .secondline-fixed-scrolled #secondline-checkout-basket .secondline-sub-total span.total-number-add, .secondline-fixed-scrolled .sf-menu li.sfHover li a:hover, .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover a, .secondline-fixed-scrolled .sf-menu li.sfHover li li a:hover, .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover a, .secondline-fixed-scrolled .sf-menu li.sfHover li li li a:hover, .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover a:hover, .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a, .secondline-fixed-scrolled .sf-menu li.sfHover li li li li a:hover, .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a, .secondline-fixed-scrolled .sf-menu li.sfHover li li li li li a:hover, .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li a:hover, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover a, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li li a:hover, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover a, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li li li a:hover, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover a:hover, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li li li li a:hover, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li li li li li a:hover, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a, .secondline_themes_force_dark_navigation_color .sf-menu li.sfHover li a:hover, .secondline_themes_force_dark_navigation_color .sf-menu li.sfHover li.sfHover a, .secondline_themes_force_dark_navigation_color .sf-menu li.sfHover li li a:hover, .secondline_themes_force_dark_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover a, .secondline_themes_force_dark_navigation_color .sf-menu li.sfHover li li li a:hover, .secondline_themes_force_dark_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover a:hover, .secondline_themes_force_dark_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a, .secondline_themes_force_dark_navigation_color .sf-menu li.sfHover li li li li a:hover, .secondline_themes_force_dark_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .secondline_themes_force_dark_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a, .secondline_themes_force_dark_navigation_color .sf-menu li.sfHover li li li li li a:hover, .secondline_themes_force_dark_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .secondline_themes_force_dark_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li a:hover, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover a, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li li a:hover, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover a, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li li li a:hover, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover a:hover, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li li li li a:hover, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li li li li li a:hover, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a, .secondline_themes_force_light_navigation_color .sf-menu li.sfHover li a:hover, .secondline_themes_force_light_navigation_color .sf-menu li.sfHover li.sfHover a, .secondline_themes_force_light_navigation_color .sf-menu li.sfHover li li a:hover, .secondline_themes_force_light_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover a, .secondline_themes_force_light_navigation_color .sf-menu li.sfHover li li li a:hover, .secondline_themes_force_light_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover a:hover, .secondline_themes_force_light_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a, .secondline_themes_force_light_navigation_color .sf-menu li.sfHover li li li li a:hover, .secondline_themes_force_light_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .secondline_themes_force_light_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a, .secondline_themes_force_light_navigation_color .sf-menu li.sfHover li li li li li a:hover, .secondline_themes_force_light_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .secondline_themes_force_light_navigation_color .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a, .sf-menu li.sfHover.highlight-button li a:hover, .sf-menu li.current-menu-item.highlight-button li a:hover, #secondline-checkout-basket a.cart-button-header-cart, #secondline-checkout-basket a.checkout-button-header-cart, #secondline-checkout-basket a:hover, #secondline-checkout-basket ul#secondline-cart-small li h6, #secondline-checkout-basket .secondline-sub-total span.total-number-add, .sf-menu li.sfHover li a:hover, .sf-menu li.sfHover li.sfHover a, .sf-menu li.sfHover li li a:hover, .sf-menu li.sfHover li.sfHover li.sfHover a, .sf-menu li.sfHover li li li a:hover, .sf-menu li.sfHover li.sfHover li.sfHover a:hover, .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a, .sf-menu li.sfHover li li li li a:hover, .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a, .sf-menu li.sfHover li li li li li a:hover, .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a:hover, .sf-menu li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover li.sfHover a { 
		color:". esc_attr( get_theme_mod('secondline_themes_sub_nav_hover_font_color', '#2d2d2d') ) . ";
	}
	
	.secondline_themes_force_dark_navigation_color .secondline-fixed-scrolled #secondline-shopping-cart-count span.secondline-cart-count,
	.secondline_themes_force_light_navigation_color .secondline-fixed-scrolled #secondline-shopping-cart-count span.secondline-cart-count,
	#secondline-shopping-cart-count span.secondline-cart-count { 
		background:" . esc_attr( get_theme_mod('secondline_themes_nav_cart_background', '#ffffff') ) . "; 
		color:" . esc_attr( get_theme_mod('secondline_themes_nav_cart_color', '#0a0715') ) . ";
	}
	.secondline-fixed-scrolled .sf-menu .secondline-mini-banner-icon,
	.secondline-mini-banner-icon {
		color:#ffffff;
	}
	.secondline-mini-banner-icon {
		top:" . esc_attr( (get_theme_mod('secondline_themes_nav_padding', '42') - get_theme_mod('secondline_themes_nav_font_size', '14')) - 4 ). "px;
		right:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') / 2 ) . "px; 
	}
	

	.secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.current-menu-item.highlight-button a:hover:before, .secondline_themes_force_light_navigation_color .secondline-fixed-scrolled .sf-menu li.highlight-button a:hover:before, .sf-menu li.current-menu-item.highlight-button a:hover:before, .sf-menu li.highlight-button a:hover:before {
		width:100%;
	}
	
	#secondline-checkout-basket ul#secondline-cart-small li, #secondline-checkout-basket .secondline-sub-total, #panel-search-secondline .search-form input.search-field, .sf-mega li:last-child li a, body header .sf-mega li:last-child li a, .sf-menu li li a, .sf-mega h2.mega-menu-heading, .sf-mega ul, body .sf-mega ul, #secondline-checkout-basket .secondline-sub-total, #secondline-checkout-basket ul#secondline-cart-small li { 
		border-color:" . esc_attr( get_theme_mod('secondline_themes_sub_nav_border_color', '#efefef') ) . ";
	}
	
	#secondline-inline-icons .secondline-themes-social-icons a {
		padding-left:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') -  7 ). "px;
		padding-right:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') - 7 ). "px;
	}
	#secondline-themes-header-search-icon i.fa-search, #secondline-themes-header-cart-icon {
		padding-left:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') ). "px;
		padding-right:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') ). "px;
	}
	#secondline-inline-icons .secondline-themes-social-icons {
		padding-right:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') - 7 ). "px;
	}
	.sf-menu a {
		padding-left:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') ). "px;
		padding-right:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') ). "px;
	}
	
	.sf-menu li.highlight-button { 
		margin-right:". esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') - 7 ) . "px;
		margin-left:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') - 7 ) . "px;
	}
	.sf-arrows .sf-with-ul {
		padding-right:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') + 15 ) . "px;
	}
	.sf-arrows .sf-with-ul:after { 
		right:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') + 9 ) . "px;
	}
	
	.rtl .sf-arrows .sf-with-ul {
		padding-right:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') ) . "px;
		padding-left:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') + 15 ) . "px;
	}
	.rtl  .sf-arrows .sf-with-ul:after { 
		right:auto;
		left:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') + 9 ) . "px;
	}
	
	@media only screen and (min-width: 960px) and (max-width: 1300px) {
		#page-title-slt-post-page, #page-title-slt-post-page .secondline-themes-gallery .blog-single-gallery-post-format { min-height:" . esc_attr( get_theme_mod('secondline_themes_blog_post_height', '700') - 80 ) . "px; }
		nav#secondline-themes-right-navigation ul li a {
			padding-left:16px;
			padding-right:16px;
		}
		#post-secondary-page-title-slt, #page-title-slt {
			padding-top:" . esc_attr( get_theme_mod('secondline_themes_page_title_padding_top', '184') - 10 ). "px;
			padding-bottom:" . esc_attr( get_theme_mod('secondline_themes_page_title_padding_bottom', '130') - 10 ). "px;
		}	
		.sf-menu a {
			padding-left:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') - 4 ). "px;
			padding-right:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') - 4 ). "px;
		}
		.sf-menu li.highlight-button { 
			margin-right:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') - 12 ). "px;
			margin-left:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') - 12 ). "px;
		}
		.sf-arrows .sf-with-ul {
			padding-right:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') + 13 ). "px;
		}
		.sf-arrows .sf-with-ul:after { 
			right:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') + 7 ). "px;
		}
		.rtl .sf-arrows .sf-with-ul {
			padding-left:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18')  ). "px;
			padding-left:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') + 13 ). "px;
		}
		.rtl .sf-arrows .sf-with-ul:after { 
			right:auto;
			left:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') + 7 ). "px;
		}
		#secondline-inline-icons .secondline-themes-social-icons a {
			padding-left:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') -  12 ). "px;
			padding-right:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') - 12 ). "px;
		}
		#secondline-themes-header-search-icon i.fa-search, #secondline-themes-header-cart-icon {
			padding-left:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') - 4). "px;
			padding-right:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') - 4). "px;
		}
		#secondline-inline-icons .secondline-themes-social-icons {
			padding-right:" . esc_attr( get_theme_mod('secondline_themes_nav_left_right', '18') - 12 ). "px;
		}
	}
	
	$secondline_themes_optiona_nav_bg_hover
	$secondline_themes_optiona_fixed_nav_font_bg	
	$secondline_themes_optiona_fixed_nav_hover_bg
	$secondline_themes_option_fixed_nav_font_color	
	$secondline_themes_option_stickY_nav_font_hover_color
	$secondline_themes_option_fixed_hightlight_bg_color
	$secondline_themes_option_fixed_hightlight_font_color
	$secondline_themes_option_fixed_hightlight_bg_color_hover
	/* END Main Navigation Customizer Styles */
	header .secondline-themes-social-icons a, header #secondline-inline-icons .secondline-themes-social-icons a {
		color:" . esc_attr( get_theme_mod('secondline_themes_header_icon_color', '#ffffff') ) . ";
	}

	
	
    /* MEJS PLAYER */
    body #main-container-secondline .single-player-container-secondline .mejs-container .mejs-inner .mejs-controls .mejs-time-rail span.mejs-time-current, body #main-container-secondline .single-player-container-secondline .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, body #main-container-secondline .mejs-container .mejs-inner .mejs-controls .mejs-time-rail span.mejs-time-current, body #main-container-secondline .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current, body #main-container-secondline .wp-playlist-item.wp-playlist-playing, body #main-container-secondline .wp-playlist-item.wp-playlist-playing:hover {
        background:" .  esc_attr( get_theme_mod('secondline_themes_player_progressed', '#b2c3de') ) . ";
    }    
    
    body #main-container-secondline .mejs-container .mejs-inner .mejs-controls .mejs-time-rail span.mejs-time-loaded, body #main-container-secondline .mejs-container .mejs-inner .mejs-controls .mejs-time-rail span.mejs-time-total, body #main-container-secondline .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-total, body #main-container-secondline .single-player-container-secondline .mejs-container .mejs-inner .mejs-controls .mejs-time-rail span.mejs-time-loaded, body #main-container-secondline .single-player-container-secondline .mejs-container .mejs-inner .mejs-controls .mejs-time-rail span.mejs-time-total, body #main-container-secondline .single-player-container-secondline .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-total {
        background:" .  esc_attr( get_theme_mod('secondline_themes_player_background') ) . ";
    }
    
    body #main-container-secondline .mejs-controls .mejs-time-rail .mejs-time-handle, body #main-container-secondline .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-handle {
        background:" .  esc_attr( get_theme_mod('secondline_themes_player_knob') ) . ";
        border-color:" .  esc_attr( get_theme_mod('secondline_themes_player_knob') ) . ";
    }
    
    body #main-container-secondline .mejs-inner .mejs-controls span, body #main-container-secondline .mejs-inner .mejs-time .mejs-currenttime, #main-container-secondline .mejs-inner .mejs-time  .mejs-duration {
        color:" .  esc_attr( get_theme_mod('secondline_themes_player_time_text') ) . ";
		font-size:" .  esc_attr( get_theme_mod('secondline_themes_player_time_text_size') ) . "px;
    }
    
    body #main-container-secondline .mejs-playpause-button.mejs-play button:before, body #main-container-secondline .mejs-playpause-button.mejs-pause button:before, body #main-container-secondline .mejs-playpause-button.mejs-play button:before, body #main-container-secondline .wp-playlist .wp-playlist-next, body #main-container-secondline .wp-playlist .wp-playlist-prev, body #main-container-secondline .mejs-inner .mejs-controls button, body #main-container-secondline .mejs-container .mejs-controls .mejs-playlist.sle-selected button, #main-container-secondline .wp-playlist .wp-playlist-next:hover, #main-container-secondline  .wp-playlist .wp-playlist-prev:hover, body #main-container-secondline .mejs-inner .mejs-controls button:hover, #main-container-secondline .single-player-container-secondline .mejs-playpause-button.mejs-play button:before, body #main-container-secondline .mejs-button.mejs-jump-forward-button button:before, body #main-container-secondline .mejs-button.mejs-skip-back-button button:before {
        color:" .  esc_attr( get_theme_mod('secondline_themes_player_icon') ) . ";
    }
	
	body #main-container-secondline .mejs-container .mejs-controls .mejs-playlist.sle-selected button,
	#main-container-secondline .wp-playlist .wp-playlist-next:hover, #main-container-secondline  .wp-playlist .wp-playlist-prev:hover,
	body #main-container-secondline .mejs-inner .mejs-controls .mejs-playpause-button:hover button,
	body #main-container-secondline .mejs-playpause-button.mejs-play:hover button:before, body #main-container-secondline .mejs-playpause-button.mejs-pause:hover button:before, body #main-container-secondline .mejs-playpause-button.mejs-play button:hover:before, body #main-container-secondline .wp-playlist .wp-playlist-next:hover, body #main-container-secondline .wp-playlist .wp-playlist-prev:hover, body #main-container-secondline .mejs-inner .mejs-controls button:hover, body #main-container-secondline .mejs-container .mejs-controls .mejs-playlist.sle-selected button:hover, #main-container-secondline .wp-playlist .wp-playlist-next:hover, #main-container-secondline  .wp-playlist .wp-playlist-prev:hover, body #main-container-secondline .mejs-inner .mejs-controls button:hover, #main-container-secondline .single-player-container-secondline .mejs-playpause-button.mejs-play button:hover:before , #main-container-secondline .single-player-container-secondline .mejs-volume-button.mejs-mute button:hover:before, body #main-container-secondline .mejs-button.mejs-jump-forward-button:hover button:before, body #main-container-secondline .mejs-button.mejs-skip-back-button:hover button:before	{
		color:" .  esc_attr( get_theme_mod('secondline_themes_player_icon_hover') ) . ";
	}	
    
    body #main-container-secondline a.powerpress_link_pinw:before, body #main-container-secondline a.podcast-meta-new-window:before, body #main-container-secondline a.powerpress_link_d:before, body #main-container-secondline a.podcast-meta-download:before,
	body #main-container-secondline .mejs-button.mejs-speed-button button {
        color:" .  esc_attr( get_theme_mod('secondline_themes_player_additional_icon') ) . ";
    }    
	
	body #main-container-secondline .mejs-button.mejs-speed-button button {
		border-color:" .  esc_attr( get_theme_mod('secondline_themes_player_additional_icon') ) . ";
	}   
    
    
    /* END MEJS PLAYER */	
	
	
	/* START FOOTER STYLES */
	footer#site-footer {
		background: " . esc_attr(get_theme_mod('secondline_themes_footer_background', '#2b2d30')) . ";
		$secondline_themes_footer_bg_image
		$secondline_themes_main_image_position_cover
	}
	footer#site-footer #secondline-themes-copyright a {  color: " . esc_attr(get_theme_mod('secondline_themes_copyright_link', '#6d8ae4')) . ";}
	footer#site-footer #secondline-themes-copyright a:hover { color: " . esc_attr(get_theme_mod('secondline_themes_copyright_link_hover', '#ffffff')) . "; }
	#secondline-themes-copyright { 
		$secondline_themes_copyright_optional_bg
	}
	#secondline-themes-lower-widget-container .widget, #widget-area-secondline .widget { padding:" . esc_attr(get_theme_mod('secondline_themes_widgets_margin_top', '120')) . "px 0px " . esc_attr(get_theme_mod('secondline_themes_widgets_margin_bottom', '80')) . "px 0px; }
	#copyright-text { padding:" . esc_attr(get_theme_mod('secondline_themes_copyright_margin_top', '18')) . "px 0px " . esc_attr(get_theme_mod('secondline_themes_copyright_margin_bottom', '15')) . "px 0px; }
	footer#site-footer .secondline-themes-social-icons {
		padding-top:" . esc_attr(get_theme_mod('secondline_themes_footer_margin_top', '0')) . "px;
		padding-bottom:" . esc_attr(get_theme_mod('secondline_themes_footer_margin_bottom', '0')) . "px;
	}
	footer#site-footer ul.secondline-themes-social-widget li a , footer#site-footer #secondline-themes-copyright .secondline-themes-social-icons a, footer#site-footer .secondline-themes-social-icons a {
		color:" . esc_attr(get_theme_mod('secondline_themes_footer_icon_color', 'rgba(255,255,255,0.7)')) . ";
	}
	.sidebar ul.secondline-themes-social-widget li a, footer#site-footer ul.secondline-themes-social-widget li a, footer#site-footer .secondline-themes-social-icons a {
		background:" . esc_attr(get_theme_mod('secondline_themes_footer_icon_border_color', 'rgba(255,255,255,0.3)')) . ";
	}
	footer#site-footer ul.secondline-themes-social-widget li a:hover, footer#site-footer #secondline-themes-copyright .secondline-themes-social-icons a:hover, footer#site-footer .secondline-themes-social-icons a:hover {
		color:" . esc_attr(get_theme_mod('secondline_themes_footer_hover_icon_color', 'rgba(0,0,0,1)')) . ";
	}
	.sidebar ul.secondline-themes-social-widget li a:hover, footer#site-footer ul.secondline-themes-social-widget li a:hover, footer#site-footer .secondline-themes-social-icons a:hover {
		background:" . esc_attr(get_theme_mod('secondline_themes_footer_hover_background_icon_color', 'rgba(255,255,255,1)')) . ";
	}
	footer#site-footer .secondline-themes-social-icons li a {
		margin-right:" . esc_attr(get_theme_mod('secondline_themes_footer_margin_sides', '5')) . "px;
		margin-left:" . esc_attr(get_theme_mod('secondline_themes_footer_margin_sides', '5')) . "px;
	}
	footer#site-footer .secondline-themes-social-icons a, footer#site-footer #secondline-themes-copyright .secondline-themes-social-icons a {
		font-size:" . esc_attr(get_theme_mod('secondline_themes_footer_icon_size', '12')) . "px;
        width:" . esc_attr(get_theme_mod('secondline_themes_footer_icon_size', '12')) . "px;
        height:" . esc_attr(get_theme_mod('secondline_themes_footer_icon_size', '12')) . "px;
        line-height:" . esc_attr(get_theme_mod('secondline_themes_footer_icon_size', '12')) . "px;
	}
	#secondline-themes-footer-logo { max-width:" . esc_attr( get_theme_mod('secondline_themes_footer_logo_width', '250') ) . "px; padding-top:" . esc_attr( get_theme_mod('secondline_themes_footer_logo_margin_top', '45') ) . "px; padding-bottom:" . esc_attr( get_theme_mod('secondline_themes_footer_logo_margin_bottom', '0') ) . "px; padding-right:" . esc_attr( get_theme_mod('secondline_themes_footer_logo_margin_right', '0') ) . "px; padding-left:" . esc_attr( get_theme_mod('secondline_themes_footer_logo_margin_left', '0') ) . "px; }
	
	/* END FOOTER STYLES */
	
	 #secondline-woocommerce-single-top, #secondline-woocommerce-messages-top {
	   background-color:" . esc_attr( get_theme_mod('secondline_woocmmerce_product_background', '#f5f5f5') ) . ";
	 }

	 body .secondline-woocommerce-index-content-bg {
	   background:" . esc_attr( get_theme_mod('secondline_woocmmerce_product_index_background', '#f7f7f7') ) . ";
	 }		
	
	@media only screen and (max-width: 959px) { 
		
		#page-title-slt-post-page, #page-title-slt-post-page .secondline-themes-gallery .blog-single-gallery-post-format { min-height:" . esc_attr( get_theme_mod('secondline_themes_blog_post_height', '700') - 120 ) . "px; }
		
		#post-secondary-page-title-slt, #page-title-slt {
			padding-top:" . esc_attr( get_theme_mod('secondline_themes_page_title_padding_top', '184') - 30 ). "px;
			padding-bottom:" . esc_attr( get_theme_mod('secondline_themes_page_title_padding_bottom', '130') - 30 ). "px;
		}
		.secondline-themes-transparent-header header#masthead-slt {
			background-color:". esc_attr( get_theme_mod('secondline_themes_header_background_color') ). ";
			$secondline_themes_header_bg_image
			$secondline_themes_header_bg_cover
		}
		$secondline_themes_mobile_header_bg_color
		$secondline_themes_mobile_header_logo_width
		$secondline_themes_mobile_header_logo_margin_top
		$secondline_themes_mobile_header_nav_padding_top
	}
	@media only screen and (max-width: 959px) {
		#secondline-themes-lower-widget-container .widget, #widget-area-secondline .widget { padding:" . esc_attr(get_theme_mod('secondline_themes_widgets_margin_top', '120') - 30 ) . "px 0px " . esc_attr(get_theme_mod('secondline_themes_widgets_margin_bottom', '80') - 30 ) . "px 0px; }
	}
	@media only screen and (min-width: 960px) and (max-width: ". esc_attr( get_theme_mod('secondline_themes_site_width', '1400') + 100 ) . "px) {
        body #main-container-secondline .width-container-slt, .width-container-slt {
			width:92%; 
            padding: 0;
			position:relative;
            padding-left: 0px;
            padding-right: 0px;
		}
        
        body .elementor-section.elementor-section-boxed > .elementor-container {max-width:92%;}
        
        body #main-container-secondline {
            width: 100%;
        }

		
		footer#site-footer.secondline-themes-footer-full-width .width-container-slt,
		.secondline-themes-page-title-full-width #page-title-slt .width-container-slt,
		.secondline-themes-header-full-width header#masthead-slt .width-container-slt {
			width:92%; 
			position:relative;
			padding:0px;
		}
		.secondline-themes-header-full-width-no-gap.secondline-themes-header-cart-width-adjustment header#masthead-slt .width-container-slt,
		.secondline-themes-header-full-width.secondline-themes-header-cart-width-adjustment header#masthead-slt .width-container-slt {
			width:98%;
			margin-left:2%;
			padding-right:0;
		}
		#secondline-shopping-cart-toggle.activated-class a i.shopping-cart-header-icon,
		#secondline-shopping-cart-count i.shopping-cart-header-icon {
			padding-left:24px;
			padding-right:24px;
		}
		#secondline-shopping-cart-count span.secondline-cart-count {
			right:14px;
		}
		header .sf-mega {
			margin-right:2%;
			width:98%; 
			left:0px;
			margin-left:auto;
		}
	}
	$secondline_themes_boxed_layout
	::-moz-selection {color:" . esc_attr( get_theme_mod('secondline_themes_select_color', '#ffffff') ) . ";background:" . esc_attr( get_theme_mod('secondline_themes_select_bg', '#263669') ) . ";}
	::selection {color:" . esc_attr( get_theme_mod('secondline_themes_select_color', '#ffffff') ) . ";background:" . esc_attr( get_theme_mod('secondline_themes_select_bg', '#263669') ) . ";}
	";

	/**
	* Combine the values from above and minifiy them.
	*/
	$secondline_themes_custom_css = secondline_minify_css( $secondline_themes_custom_css );
	wp_add_inline_style( 'secondline-themes-custom-style', wp_strip_all_tags( $secondline_themes_custom_css ) );	
	
}
add_action( 'wp_enqueue_scripts', 'secondline_themes_customizer_styles' );