<?php
/**
 * SecondLine Theme Customizer
 *
 * @package secondline
 */

function secondline_themes_add_tab_to_panel( $tabs ) {
	
   $tabs['secondline-themes-default-main-font'] = array(
       'name'        => 'secondline-themes-default-main-font',
       'panel'       => 'secondline_themes_general_panel',
       'title'       => esc_html__('Default Theme Fonts', 'dixie-secondline'),
       'description' => 'Overrides <strong>ALL</strong> the default "Main" theme font. Use with caution',
       'sections'    => array(),
   );   
   
   $tabs['secondline-themes-navigation-font'] = array(
       'name'        => 'secondline-themes-navigation-font',
       'panel'       => 'secondline_themes_header_panel',
       'title'       => esc_html__('Navigation', 'dixie-secondline'),
       'description' => '',
       'sections'    => array(),
   );
	
   $tabs['secondline-themes-sub-navigation-font'] = array(
       'name'        => 'secondline-themes-sub-navigation-font',
       'panel'       => 'secondline_themes_header_panel',
       'title'       => esc_html__('Sub-Navigation', 'dixie-secondline'),
       'description' => '',
       'sections'    => array(),
   );
	
	
   $tabs['secondline-themes-body-font'] = array(
       'name'        => 'secondline-themes-body-font',
       'panel'       => 'secondline_themes_body_panel',
       'title'       => esc_html__('Body Main', 'dixie-secondline'),
       'description' => '',
       'sections'    => array(),
   );
	
	
   $tabs['secondline-themes-page-title'] = array(
       'name'        => 'secondline-themes-page-title',
       'panel'       => 'secondline_themes_body_panel',
       'title'       => esc_html__('Page Title', 'dixie-secondline'),
       'description' => '',
       'sections'    => array(),
   );
	
   $tabs['secondline-themes-widgets-font'] = array(
       'name'        => 'secondline-themes-widgets-font',
       'panel'       => 'secondline_themes_footer_panel',
       'title'       => esc_html__('Footer Main', 'dixie-secondline'),
       'description' => '',
       'sections'    => array(),
   );
	
   $tabs['secondline-themes-copyright-font'] = array(
       'name'        => 'secondline-themes-copyright-font',
       'panel'       => 'secondline_themes_footer_panel',
       'title'       => esc_html__('Copyright Text', 'dixie-secondline'),
       'description' => '',
       'sections'    => array(),
   );
	

   $tabs['secondline-themes-footer-nav-font'] = array(
       'name'        => 'secondline-themes-footer-nav-font',
       'panel'       => 'secondline_themes_footer_panel',
       'title'       => esc_html__('Footer Navigation', 'dixie-secondline'),
       'description' => '',
       'sections'    => array(),
   );
	
	
	
	
   $tabs['secondline-themes-default-headings'] = array(
       'name'        => 'secondline-themes-default-headings',
       'panel'       => 'secondline_themes_body_panel',
       'title'       => esc_html__('H1-H6 Headings', 'dixie-secondline'),
       'description' => '',
       'sections'    => array(),
   );
	
	
  
	
   $tabs['secondline-themes-sidebar-headings'] = array(
       'name'        => 'secondline-themes-sidebar-headings',
       'panel'       => 'secondline_themes_body_panel',
       'title'       => esc_html__('Sidebar Options', 'dixie-secondline'),
       'description' => '',
       'sections'    => array(),
   );
	
   $tabs['secondline-themes-button-typography'] = array(
       'name'        => 'secondline-themes-button-typography',
       'panel'       => 'secondline_themes_body_panel',
       'title'       => esc_html__('Button Styles', 'dixie-secondline'),
       'description' => '',
       'sections'    => array(),
   );
	


	
   $tabs['secondline-themes-blog-headings'] = array(
       'name'        => 'secondline-themes-blog-headings',
       'panel'       => 'secondline_themes_blog_panel',
       'title'       => esc_html__('Post Archive Styles', 'dixie-secondline'),
       'description' => '',
       'sections'    => array(),
   );
	
   $tabs['secondline-themes-blog-post-options'] = array(
       'name'        => 'secondline-themes-blog-post-options',
       'panel'       => 'secondline_themes_blog_panel',
       'title'       => esc_html__('Post Options', 'dixie-secondline'),
       'description' => '',
       'sections'    => array(),
   );
	
   $tabs['secondline-themes-blog-post-styles'] = array(
       'name'        => 'secondline-themes-blog-post-styles',
       'panel'       => 'secondline_themes_blog_panel',
       'title'       => esc_html__('Post Styles', 'dixie-secondline'),
       'description' => '',
       'sections'    => array(),
   );

    $tabs['secondline-shop-headings'] = array(
       'name'        => 'secondline-shop-headings',
       'panel'       => 'woocommerce',
       'title'       => esc_html__('Shop Typography', 'dixie-secondline'),
       'description' => '',
       'sections'    => array(),
   );      
	
    // Return the tabs.
    return $tabs;
}
add_filter( 'tt_font_get_settings_page_tabs', 'secondline_themes_add_tab_to_panel' );

/**
 * How to add a font control to your tab
 *
 * @see  parse_font_control_array() - in class EGF_Register_Options
 *       in includes/class-egf-register-options.php to see the full
 *       properties you can add for each font control.
 *
 *
 * @param   array $controls - Existing Controls.
 * @return  array $controls - Controls with controls added/removed.
 *
 * @since 1.0
 * @version 1.0
 *
 */
function secondline_themes_add_control_to_tab( $controls ) {

    /**
     * 1. Removing default styles because we add-in our own
     */
    unset( $controls['tt_default_body'] );
    unset( $controls['tt_default_heading_1'] );
    unset( $controls['tt_default_heading_2'] );
    unset( $controls['tt_default_heading_3'] );
    unset( $controls['tt_default_heading_4'] );
    unset( $controls['tt_default_heading_5'] );
    unset( $controls['tt_default_heading_6'] );
	 
	 
    /**
     * 2. Now custom examples that are theme specific
     */
	 
    $controls['secondline_themes_default_main_font'] = array(
        'name'       => 'secondline_themes_default_main_font',
 		'type'       => 'font',
        'title'      =>  esc_html__('Default Main Theme Font', 'dixie-secondline'),
        'tab'        => 'secondline-themes-default-main-font',
        'properties' => array( 
			'selector'	=> 'body, body input, body textarea, select, body label.wpforms-field-sublabel, body label.wpforms-field-label, #page-title-slt h4, #secondline-checkout-basket, #panel-search-secondline, .sf-menu ul, body .secondline-themes-post-slider-main .secondline-post-meta span a, body .secondline-themes-post-slider-main .secondline-post-meta span, .secondline-post-meta, .secondline-themes-default-blog-index .secondline-post-meta, body .secondline-themes-post-slider-main .secondline-post-meta, .single-secondline-post-meta, .sidebar, footer#site-footer, #copyright-text',
			'force_styles'	=> apply_filters( 'tt_font_force_styles', true ),	
		),
 		 'default' => array(
 			'subset'                     => 'latin',
 			'font_id'                    => '',
 			'font_name'                  => '',
 		),
    );	 
	 
	 
    $controls['secondline_themes_default_secondary_font'] = array(
        'name'       => 'secondline_themes_default_secondary_font',
 		'type'       => 'font',
        'title'      =>  esc_html__('Default Secondary Theme Font', 'dixie-secondline'),
        'tab'        => 'secondline-themes-default-main-font',
        'properties' => array( 
			'selector'	=> '#content-slt a.wp-block-button__link, h1, h2, h3, h4, h5, h6, #bread-crumb-container ul#breadcrumbs-slt, nav#secondline-themes-right-navigation ul li a, h2.mega-menu-heading, nav#site-navigation, h2.mega-menu-heading, nav#site-navigation, body .secondline-themes-sticky-post, a.more-link, .tags-secondline a, ul.blog-single-social-sharing, ul.secondline-filter-button-group li, .widget ul span.count, .secondline-page-nav span, .secondline-page-nav a, #content-slt ul.page-numbers li span.current, #content-slt ul.page-numbers li a, .infinite-nav-slt a, a#edit-profile, #main-container-secondline .form-submit input#submit, #main-container-secondline input.button, #main-container-secondline #customer_login input.button, #main-container-secondline button.button, #main-container-secondline a.button, #main-container-secondline .elementor-button-text, #newsletter-form-fields input.button, a.secondline-themes-button, .post-password-form input[type=submit], #respond input#submit, .wpcf7-form input.wpcf7-submit, #main-container-secondline .wp-block-button a.wp-block-button__link, #content-slt button.wpforms-submit, .mc4wp-form input[type="submit"], ul.secondline-themes-category-list li a, footer#site-footer #secondline-themes-copyright ul.secondline-themes-footer-nav-container-class a, footer#site-footer ul.secondline-themes-footer-nav-container-class a',
			'force_styles'	=> apply_filters( 'tt_font_force_styles', true ),	
		),
 		 'default' => array(
 			'subset'                     => 'latin',
 			'font_id'                    => '',
 			'font_name'                  => '',
			'font_weight'                => '',
 		),
    );	 
	 
    $controls['secondline_themes_body_font_family'] = array(
        'name'       => 'secondline_themes_body_font_family',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Body Font', 'dixie-secondline'),
        'tab'        => 'secondline-themes-body-font',
        'properties' => array( 'selector'   => 'body, body input, body textarea, select, body label.wpforms-field-sublabel, body label.wpforms-field-label' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 			'font_id'                    => 'open_sans',
 			'font_name'                  => 'Open Sans',
 			'font_weight_style'          => 'regular',
 			'font_color'                 => '#3b5987',
 		),
    );
	 
	 
	 
    $controls['secondline_themes_nav_font_family'] = array(
        'name'       => 'secondline_themes_nav_font_family',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Navigation Font Family', 'dixie-secondline'),
        'tab'        => 'secondline-themes-navigation-font',
        'properties' => array( 'selector'   => 'nav#site-navigation, nav#secondline-themes-right-navigation, body .sf-menu a' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 			'font_id'                    => 'roboto',
 			'font_name'                  => 'Roboto',
 			'font_weight_style'          => '500',
 		),
    );
	 
	 
    $controls['secondline_themes_sub_nav_font_family'] = array(
        'name'       => 'secondline_themes_sub_nav_font_family',
 	'type'        => 'font',
        'title'      =>  esc_html__('Sub-Navigation Font Family', 'dixie-secondline'),
        'tab'        => 'secondline-themes-sub-navigation-font',
        'properties' => array( 'selector'   => 'body .sf-menu ul, body .sf-menu ul a, #main-nav-mobile' ),
 	'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 
	 
    $controls['secondline_themes_page_title_font_family'] = array(
        'name'       => 'secondline_themes_page_title_font_family',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Page Title Font', 'dixie-secondline'),
        'tab'        => 'secondline-themes-page-title',
        'properties' => array( 'selector'   => '#page-title-slt h1' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 
	 
    $controls['secondline_themes_page_sub_title_font_family'] = array(
        'name'       => 'secondline_themes_page_sub_title_font_family',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Page Sub-Title Font', 'dixie-secondline'),
        'tab'        => 'secondline-themes-page-title',
        'properties' => array( 'selector'   => '#page-title-slt h4' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 
	 
	 
    $controls['secondline_themes_heading_h1'] = array(
        'name'       => 'secondline_themes_heading_h1',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Heading 1', 'dixie-secondline'),
        'tab'        => 'secondline-themes-default-headings',
        'properties' => array( 'selector'   => 'h1' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	
    $controls['secondline_themes_heading_h2'] = array(
        'name'       => 'secondline_themes_heading_h2',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Heading 2', 'dixie-secondline'),
        'tab'        => 'secondline-themes-default-headings',
        'properties' => array( 'selector'   => 'h2' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	
    $controls['secondline_themes_heading_h3'] = array(
        'name'       => 'secondline_themes_heading_h3',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Heading 3', 'dixie-secondline'),
        'tab'        => 'secondline-themes-default-headings',
        'properties' => array( 'selector'   => 'h3' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	
    $controls['secondline_themes_heading_h4'] = array(
        'name'       => 'secondline_themes_heading_h4',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Heading 4', 'dixie-secondline'),
        'tab'        => 'secondline-themes-default-headings',
        'properties' => array( 'selector'   => 'h4' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
    $controls['secondline_themes_heading_h5'] = array(
        'name'       => 'secondline_themes_heading_h5',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Heading 5', 'dixie-secondline'),
        'tab'        => 'secondline-themes-default-headings',
        'properties' => array( 'selector'   => 'h5' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
    $controls['secondline_themes_heading_h6'] = array(
        'name'       => 'secondline_themes_heading_h6',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Heading 6', 'dixie-secondline'),
        'tab'        => 'secondline-themes-default-headings',
        'properties' => array( 'selector'   => 'h6' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
	 
	 
    $controls['secondline_themes_widget_font_family'] = array(
        'name'       => 'secondline_themes_widget_font_family',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Footer Main Font', 'dixie-secondline'),
        'tab'        => 'secondline-themes-widgets-font',
        'properties' => array( 'selector'   => 'footer#site-footer' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 
    $controls['secondline_themes_widget_font_link'] = array(
        'name'       => 'secondline_themes_widget_font_link',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Footer Link', 'dixie-secondline'),
        'tab'        => 'secondline-themes-widgets-font',
        'properties' => array( 'selector'   => 'footer#site-footer a' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 
	 
    $controls['secondline_themes_widget_font_link_hover'] = array(
        'name'       => 'secondline_themes_widget_font_link_hover',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Footer Link Hover', 'dixie-secondline'),
        'tab'        => 'secondline-themes-widgets-font',
        'properties' => array( 'selector'   => 'footer#site-footer a:hover' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 
	 
    $controls['secondline_themes_copyright_font_family'] = array(
        'name'       => 'secondline_themes_copyright_font_family',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Copyright Font', 'dixie-secondline'),
        'tab'        => 'secondline-themes-copyright-font',
        'properties' => array( 'selector'   => '#copyright-text' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 
	 
    $controls['secondline_themes_footer_nav_link'] = array(
        'name'       => 'secondline_themes_footer_nav_link',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Footer Navigation', 'dixie-secondline'),
        'tab'        => 'secondline-themes-footer-nav-font',
        'properties' => array( 'selector'   => 'footer#site-footer #secondline-themes-copyright ul.secondline-themes-footer-nav-container-class a, footer#site-footer ul.secondline-themes-footer-nav-container-class a' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 
    $controls['secondline_themes_footer_nav_link_hover'] = array(
        'name'       => 'secondline_themes_footer_nav_link_hover',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Footer Navigation Hover', 'dixie-secondline'),
        'tab'        => 'secondline-themes-footer-nav-font',
        'properties' => array( 'selector'   => 'footer#site-footer #secondline-themes-copyright ul.secondline-themes-footer-nav-container-class li.current-menu-item a, footer#site-footer  #secondline-themes-copyright ul.secondline-themes-footer-nav-container-class a:hover, footer#site-footer ul.secondline-themes-footer-nav-container-class li.current-menu-item a, footer#site-footer ul.secondline-themes-footer-nav-container-class a:hover' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 
	 
    $controls['secondline_themes_widget_font_heading'] = array(
        'name'       => 'secondline_themes_widget_font_heading',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Footer Widget Heading', 'dixie-secondline'),
        'tab'        => 'secondline-themes-widgets-font',
        'properties' => array( 'selector'   => 'footer#site-footer h4.widget-title' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 

	 
    $controls['secondline_themes_button_font_family'] = array(
        'name'       => 'secondline_themes_button_font_family',
 	'type'        => 'font',
        'title'      =>  esc_html__('Button Font Family', 'dixie-secondline'),
        'tab'        => 'secondline-themes-button-typography',
        'properties' => array( 'selector'   => '#main-container-secondline .wp-block-button a.wp-block-button__link, #main-container-secondline button.button, #main-container-secondline a.button, #infinite-nav-slt a, .post-password-form input[type=submit], #respond input#submit, .wpcf7-form input.wpcf7-submit, #content-slt button.wpforms-submit' ),
 	    'default' => array(
		'subset'                     => 'latin',
		'text_decoration'            => 'none',
 		),
    );
	 
	 
    $controls['secondline_themes_blog_category_font'] = array(
        'name'       => 'secondline_themes_blog_category_font',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Category', 'dixie-secondline'),
        'tab'        => 'secondline-themes-blog-headings',
        'properties' => array( 'selector'   => '.blog-meta-category-list a, .blog-meta-category-list a:hover' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 
	 
    $controls['secondline_themes_blog_title_font'] = array(
        'name'       => 'secondline_themes_blog_title_font',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Title', 'dixie-secondline'),
        'tab'        => 'secondline-themes-blog-headings',
        'properties' => array( 'selector'   => 'h2.secondline-blog-title' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 
	 
    $controls['secondline_themes_blog_byline_font'] = array(
        'name'       => 'secondline_themes_blog_byline_font',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Meta and Date', 'dixie-secondline'),
        'tab'        => 'secondline-themes-blog-headings',
        'properties' => array( 'selector'   => '.secondline-post-meta' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 
    $controls['secondline_themes_blog_byline_link_font'] = array(
        'name'       => 'secondline_themes_blog_byline_link_font',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Meta Link', 'dixie-secondline'),
        'tab'        => 'secondline-themes-blog-headings',
        'properties' => array( 'selector'   => '.secondline-post-meta a:hover, .secondline-post-meta a' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 
	 
	 
    $controls['secondline_themes_blog_post_title'] = array(
        'name'       => 'secondline_themes_blog_post_title',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Post Title', 'dixie-secondline'),
        'tab'        => 'secondline-themes-blog-post-styles',
        'properties' => array( 'selector'   => 'h1.blog-page-title' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 
    $controls['secondline_themes_blog_post_meta'] = array(
        'name'       => 'secondline_themes_blog_post_meta',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Post Meta', 'dixie-secondline'),
        'tab'        => 'secondline-themes-blog-post-styles',
        'properties' => array( 'selector'   => '.single-secondline-post-meta, .single-secondline-post-meta a, .single-secondline-post-meta a:hover' ),
 		 'default' => array(
 			'subset'                     => 'latin',
 		),
    );
	 

	 
	 

	 
    $controls['secondline_themes_sidebar_default'] = array(
        'name'       => 'secondline_themes_sidebar_default',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Sidebar Default Text', 'dixie-secondline'),
        'tab'        => 'secondline-themes-sidebar-headings',
        'properties' => array( 'selector'   => '.sidebar' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
	 
    $controls['secondline_themes_sidebar_heading'] = array(
        'name'       => 'secondline_themes_sidebar_heading',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Sidebar Heading', 'dixie-secondline'),
        'tab'        => 'secondline-themes-sidebar-headings',
        'properties' => array( 'selector'   => '.sidebar h4.widget-title' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
    $controls['secondline_themes_sidebar_link'] = array(
        'name'       => 'secondline_themes_sidebar_link',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Sidebar Default Link', 'dixie-secondline'),
        'tab'        => 'secondline-themes-sidebar-headings',
        'properties' => array( 'selector'   => '.sidebar a' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	 
    $controls['secondline_themes_sidebar_link_hover'] = array(
        'name'       => 'secondline_themes_sidebar_link_hover',
 		 'type'        => 'font',
        'title'      =>  esc_html__('Sidebar Link Hover', 'dixie-secondline'),
        'tab'        => 'secondline-themes-sidebar-headings',
        'properties' => array( 'selector'   => '.sidebar ul li.current-cat, .sidebar ul li.current-cat a, .sidebar a:hover' ),
 		 'default' => array(
 	 			'subset'                     => 'latin',
 	 			'text_decoration'            => 'none',
 			),
    );
	
    $controls['secondline_shop_index_heading'] = array(
        'name'       => 'secondline_shop_index_heading',
        'type'        => 'font',
        'title'      =>  esc_html__('Shop Index Heading', 'dixie-secondline'),
        'tab'        => 'secondline-shop-headings',
        'properties' => array( 'selector'   => 'body #content-slt ul.products h2.woocommerce-loop-product__title, body #content-slt ul.products h2.woocommerce-loop-category__title' ),
         'default' => array(
                'subset'    => 'latin',
                'text_decoration'    => 'none',
            ),
    );

    $controls['secondline_shop_index_heading_hover'] = array(
        'name'       => 'secondline_shop_index_heading_hover',
        'type'        => 'font',
        'title'      =>  esc_html__('Shop Index Heading Hover', 'dixie-secondline'),
        'tab'        => 'secondline-shop-headings',
        'properties' => array( 'selector'   => 'body #content-slt ul.products a:hover h2.woocommerce-loop-category__title, body #content-slt ul.products a:hover h2.woocommerce-loop-product__title' ),
         'default' => array(
                'subset'    => 'latin',
                'text_decoration'    => 'none',
            ),
    );


    $controls['secondline_shop_index_price'] = array(
        'name'       => 'secondline_shop_index_price',
        'type'        => 'font',
        'title'      =>  esc_html__('Shop Index Price', 'dixie-secondline'),
        'tab'        => 'secondline-shop-headings',
        'properties' => array( 'selector'   => 'body #content-slt ul.products span.price span.amount' ),
         'default' => array(
                'subset'    => 'latin',
                'text_decoration'    => 'none',
            ),
    );

    $controls['secondline_shop_post_heading'] = array(
        'name'       => 'secondline_shop_post_heading',
        'type'        => 'font',
        'title'      =>  esc_html__('Shop Post Heading', 'dixie-secondline'),
        'tab'        => 'secondline-shop-headings',
        'properties' => array( 'selector'   => 'body #secondline-woocommerce-single-top h1.product_title' ),
         'default' => array(
                'subset'    => 'latin',
                'text_decoration'    => 'none',
            ),
    );


    $controls['secondline_shop_post_price'] = array(
        'name'       => 'secondline_shop_post_price',
        'type'        => 'font',
        'title'      =>  esc_html__('Shop Post Price', 'dixie-secondline'),
        'tab'        => 'secondline-shop-headings',
        'properties' => array( 'selector'   => '#secondline-woocommerce-single-top p.price, body #secondline-woocommerce-single-top p.price span.amount' ),
         'default' => array(
                'subset'    => 'latin',
                'text_decoration'    => 'none',
            ),
    );		
	 
	 
	// Return the controls.
    return $controls;
}
add_filter( 'tt_font_get_option_parameters', 'secondline_themes_add_control_to_tab' );