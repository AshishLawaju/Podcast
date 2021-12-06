<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.


class Widget_SecondlineElementsShowList extends Widget_Base {

	public function get_name() {
		return 'secondline-show-list';
	}

	public function get_title() {
		return esc_html__( 'SecondLine - Show Grid', 'secondline-custom-plugin' );
	}

	public function get_icon() {
		return 'fa fa-th secondline-themes-secondline-show';
	}

   public function get_categories() {
		return [ 'basic' ];
	}
	
	
	function Widget_SeconelineElementsShowList($widget_instance){
		
	}
	
	protected function _register_controls() {

		
  		$this->start_controls_section(
  			'section_title_global_options',
  			[
  				'label' => esc_html__( 'Show List Settings', 'secondline-custom-plugin' )
  			]
  		);
		
		
		
		$this->add_control(
			'secondline_main_show_count',
			[
				'label' => esc_html__( 'Show Count', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '6',
			]
		);
		
		$this->add_responsive_control(
			'secondline_elements_image_grid_column_count',
			[
  				'label' => esc_html__( 'Columns', 'secondline-custom-plugin' ),
				'label_block' => true,
				'type' => Controls_Manager::SELECT,				
				'desktop_default' => '33.330%',
				'tablet_default' => '50%',
				'mobile_default' => '100%',
				'options' => [
					'50%' => esc_html__( '2 Columns', 'secondline-custom-plugin' ),
					'33.330%' => esc_html__( '3 Columns', 'secondline-custom-plugin' ),
					'25%' => esc_html__( '4 Columns', 'secondline-custom-plugin' ),
					'20%' => esc_html__( '5 Columns', 'secondline-custom-plugin' ),
					'16.67%' => esc_html__( '6 Columns', 'secondline-custom-plugin' ),
				],
				'selectors' => [
					'{{WRAPPER}} .secondline-masonry-item' => 'width: {{VALUE}};',
				],
				'render_type' => 'template'
			]
		);
		
		
  		$this->add_responsive_control(
  			'secondline_elements_image_grid_margin',
  			[
  				'label' => esc_html__( 'Margin', 'secondline-custom-plugin' ),
  				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .secondline-masonry-margins' => 'margin-left:-{{SIZE}}px; margin-right:-{{SIZE}}px;',
					'{{WRAPPER}} .secondline-masonry-padding-blog' => 'padding: {{SIZE}}px;',
				],
				'render_type' => 'template'
  			]
  		);
		
		
		
		
		
		
		$this->add_control(
			'secondline_elements_shows_masonry',
			[
				'label' => esc_html__( 'Masonry Layout', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'secondline_elements_shows_match_height',
			[
				'label' => esc_html__( 'Force Image Height', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);		
		
		
		$this->add_control(
			'secondline_elements_show_list_pagination',
			[
				'label' => esc_html__( 'Show Pagination', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no-pagination',
				'options' => [
					'no-pagination' => esc_html__( 'No Pagination', 'secondline-custom-plugin' ),
					'default' => esc_html__( 'Default Pagination', 'secondline-custom-plugin' ),
					'load-more' => esc_html__( 'Load More Shows', 'secondline-custom-plugin' ),
					'infinite-scroll' => esc_html__( 'Inifinite Scroll', 'secondline-custom-plugin' ),
				],
			]
		);
		
		$this->add_control(
			'secondline_main_show_load_more',
			[
				'label' => esc_html__( 'Load More Text', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'More Shows',
				'condition' => [
					'secondline_elements_show_list_pagination' => 'load-more',
				],
			]
		);
		
		
		$this->add_control(
			'slt_excerpt_length',
			[
				'label' => esc_html__( 'Exerpt Word Limit', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '60',
			]
		);		


		$this->add_control(
			'slt_read_more_txt',
			[
				'label' => esc_html__( 'Read More Text', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Read More',
			]
		);	


		$this->add_control(
			'slt_read_more_icon',
			[
				'label' => esc_html__( 'Read More Icon', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::ICON,
				'label_block' => true,
			]
		);		

		
		
		$this->end_controls_section();
		
		
  		$this->start_controls_section(
  			'section_title_layout_options',
  			[
  				'label' => esc_html__( 'Show Layout', 'secondline-custom-plugin' )
  			]
  		);
		
				
		$this->add_control(
			'secondline_elements_image_transparency_hover',
			[
				'label' => esc_html__( 'Image Transparency on Hover	', 'slt-elements-secondline' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.01,
					],
				],
				'default' => [
					'size' => '1',
				],
				'selectors' => [
					'{{WRAPPER}} .secondline-themes-default-blog-overlay:hover a img' => 'opacity: {{SIZE}};',
					'{{WRAPPER}} .secondline-themes-feaured-image:hover a img' => 'opacity: {{SIZE}};',
				],
			]
		);
		
		$this->add_control(
			'secondline_elements_image_background_color',
			[
				'label' => esc_html__( 'Show Image Background Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-themes-feaured-image' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .secondline-themes-default-blog-overlay' => 'background-color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'secondline_elements_show_image_overlay',
			[
				'label' => esc_html__( 'Image Color Overlay', 'slt-elements-secondline' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-themes-feaured-image:before' => 'background-color: {{VALUE}}; display: block',
				],
			]
		);		
				
			
		

		$this->add_control(
			'secondline_elements_show_list_title',
			[
				'label' => esc_html__( 'Title Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		
		
		
		$this->add_control(
			'secondline_elements_show_list_cat',
			[
				'label' => esc_html__( 'Category Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'secondline_elements_show_carousel_show_host',
			[
				'label' => esc_html__( 'Show Host Name Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'secondline_elements_show_carousel_show_host_img',
			[
				'label' => esc_html__( 'Show Host Image Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);			
						
		$this->add_control(
			'secondline_elements_show_list_excerpt',
			[
				'label' => esc_html__( 'Exerpt Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);		
		
		$this->add_control(
			'secondline_elements_show_list_read_more',
			[
				'label' => esc_html__( 'Read More Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);		
		
		$this->add_control(
			'secondline_elements_show_list_content',
			[
				'label' => esc_html__( 'Content Area Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);			

		
		$this->end_controls_section();
		
		
  		$this->start_controls_section(
  			'section_title_secondary_options',
  			[
  				'label' => esc_html__( 'Show Query', 'secondline-custom-plugin' )
  			]
  		);
				
		
		$this->add_control(
			'secondline_show_category',
			[
				'label' => esc_html__( 'Narrow by Show Category', 'secondline-custom-plugin' ),
				'description' => esc_html__( 'Enter category slugs to display a specific category. Add-in multiple category slugs seperated by a comma to use multiple categories. ', 'secondline-custom-plugin' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
			]
		);
		
		$this->add_control(
			'secondline_elements_show_order_sorting',
			[
				'label' => esc_html__( 'Order By', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date' => esc_html__( 'Default - Date', 'secondline-custom-plugin' ),
					'title' => esc_html__( 'Show Title', 'secondline-custom-plugin' ),
					'menu_order' => esc_html__( 'Menu Order', 'secondline-custom-plugin' ),
					'modified' => esc_html__( 'Last Modified', 'secondline-custom-plugin' ),
					'comment_count' => esc_html__( 'Comment Count', 'secondline-custom-plugin' ),
					'rand' => esc_html__( 'Random', 'secondline-custom-plugin' ),
				],
			]
		);
		
		
		$this->add_control(
			'secondline_elements_show_order',
			[
				'label' => esc_html__( 'Order', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'ASC' => esc_html__( 'Ascending', 'secondline-custom-plugin' ),
					'DESC' => esc_html__( 'Descending', 'secondline-custom-plugin' ),
				],
			]
		);
		
		
		$this->add_control(
			'secondline_main_offset_count',
			[
				'label' => esc_html__( 'Offset Count', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '0',
				'description' => esc_html__( 'Use this to skip shows (Example: Insert 5 to skip the first 5 shows.)', 'secondline-custom-plugin' ),
			]
		);		

		
		$this->add_control(
			'secondline_elements_category_sorting_on',
			[
				'label' => esc_html__( 'Category Sorting', 'secondline-custom-plugin' ),
				'description' => esc_html__( 'Sort by Show Caregories', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
			]
		);
		
		$this->add_control(
			'secondline_elements_category_sorting_text',
			[
				'label' => esc_html__( 'Sorting Text for All Shows', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => esc_html__( 'All', 'secondline-custom-plugin' ),
			]
		);
		
		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'secondline_elements_section_main_styles',
			[
				'label' => esc_html__( 'Main Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		
		$this->add_control(
			'secondline_elements_main_bg_color',
			[
				'label' => esc_html__( 'Main Background Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-blog-content' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .overlay-blog-gradient' => 'background-color: {{VALUE}}',
				],
			]
		);
		
		
		$this->add_control(
			'secondline_elements_main_border_color',
			[
				'label' => esc_html__( 'Main Border Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-blog-content' => 'border: 1px solid {{VALUE}}',
				],
			]
		);
		
		$this->add_responsive_control(
			'secondline_elements_content_padding',
			[
				'label' => esc_html__( 'Content Padding', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .secondline-blog-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .overlay-secondline-blog-content-padding' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		
		$this->end_controls_section();
		
		
  		
		$this->start_controls_section(
			'section_styles_category_styles',
			[
				'label' => esc_html__( 'Category Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		
		$this->add_control(
			'secondline_elements_category_styles_color',
			[
				'label' => esc_html__( 'Category Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .overlay-blog-meta-category-list span' => 'color: {{VALUE}}',
					'{{WRAPPER}} .blog-meta-category-list a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .blog-meta-category-list a:hover' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'secondline_elements_category_styles_border',
			[
				'label' => esc_html__( 'Category Border', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .overlay-blog-meta-category-list span' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .blog-meta-category-list a' => 'border-color: {{VALUE}}',
				],
			]
		);
		
		
		$this->add_responsive_control(
			'secondline_elements_category_margin',
			[
				'label' => esc_html__( 'Category Margin', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .overlay-blog-meta-category-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .blog-meta-category-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'secondline_elements_category_typography',
				'label' => esc_html__( 'Typography', 'secondline-custom-plugin' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .overlay-blog-meta-category-list span, {{WRAPPER}} .blog-meta-category-list a',
			]
		);
		
		
		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'section_styles_title_styles',
			[
				'label' => esc_html__( 'Title Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		
		$this->add_control(
			'secondline_elements_title_styles_color',
			[
				'label' => esc_html__( 'Title Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} h2.overlay-secondline-blog-title' => 'color: {{VALUE}}',
					'{{WRAPPER}} h2.secondline-blog-title' => 'color: {{VALUE}}',
					'{{WRAPPER}} h2.secondline-blog-title a' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'secondline_elements_title_styles_hover_color',
			[
				'label' => esc_html__( 'Title Hover Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} h2.secondline-blog-title a:hover' => 'color: {{VALUE}}',
				],
			]
		);
		

		
		$this->add_responsive_control(
			'secondline_elements_title_margin',
			[
				'label' => esc_html__( 'Title Margin', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} h2.overlay-secondline-blog-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} h2.secondline-blog-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'secondline_elements_title_typography',
				'label' => esc_html__( 'Typography', 'secondline-custom-plugin' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} h2.secondline-blog-title, {{WRAPPER}} h2.overlay-secondline-blog-title',
			]
		);
		
		
		$this->end_controls_section();
		
		
	$this->start_controls_section(
			'section_styles_author_styles',
			[
				'label' => esc_html__( 'Show Host Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		
		$this->add_control(
			'secondline_elements_author_styles_color',
			[
				'label' => esc_html__( 'Show Host Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} span.show-meta-names' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_responsive_control(
			'secondline_elements_author_margin',
			[
				'label' => esc_html__( 'Show Host Margin', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .show-host-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'secondline_elements_author_typography',
				'label' => esc_html__( 'Typography', 'secondline-custom-plugin' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} span.show-meta-names',
			]
		);
		
		
		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'section_styles_comment_styles',
			[
				'label' => esc_html__( 'Excerpt Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		
		$this->add_control(
			'secondline_elements_comment_styles_color',
			[
				'label' => esc_html__( 'Excerpt Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-themes-blog-excerpt' => 'color: {{VALUE}}',
					'{{WRAPPER}} .secondline-themes-blog-excerpt a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .overlay-blog-floating-comments-viewcount' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'secondline_elements_comment_typography',
				'label' => esc_html__( 'Typography', 'secondline-custom-plugin' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .secondline-themes-blog-excerpt',
			]
		);
		
		
		$this->add_responsive_control(
			'secondline_elements_excerpt_padding',
			[
				'label' => esc_html__( 'Excerpt Padding', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .secondline-themes-blog-excerpt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);		
		
		
		
		
		$this->end_controls_section();
		
		
		
		$this->start_controls_section(
			'section_styles_more_link_styles',
			[
				'label' => esc_html__( 'Read More Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		
		$this->add_control(
			'section_styles_more_link_styles_color',
			[
				'label' => esc_html__( 'Read More Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .show-grid-index a.more-link' => 'color: {{VALUE}}',					
				],
			]
		);
		
		$this->add_control(
			'section_styles_more_link_styles_border',
			[
				'label' => esc_html__( 'Read More Border Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .show-grid-index a.more-link' => 'border-color: {{VALUE}}',					
				],
			]
		);

		$this->add_control(
			'section_styles_more_link_styles_hover',
			[
				'label' => esc_html__( 'Read More Hover Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .show-grid-index a.more-link:hover' => 'color: {{VALUE}}',					
				],
			]
		);				
		
		$this->add_control(
			'section_styles_more_link_styles_hover_border',
			[
				'label' => esc_html__( 'Read More Hover Background Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [							
					'{{WRAPPER}} .show-grid-index a.more-link:hover' => 'border-color: {{VALUE}}',									
					'{{WRAPPER}} a.more-link:hover' => 'background-color: {{VALUE}}',
				],
			]
		);			
		
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'section_styles_more_link_styles_typography',
				'label' => esc_html__( 'Typography', 'secondline-custom-plugin' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .show-grid-index a.more-link',
			]
		);
		
		
		$this->end_controls_section();			
		
		
		
		$this->start_controls_section(
			'section_styles_load_more_styles',
			[
				'label' => esc_html__( 'Load More Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'section_styles_load_more_icon',
			[
				'type' => Controls_Manager::ICON,
				'label_block' => true,
				'default' => '',
			]
		);
		
		$this->add_control(
			'section_styles_load_more_icon_indent',
			[
				'label' => esc_html__( 'Icon Spacing', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .infinite-nav-slt a span i' => 'margin-left: {{SIZE}}px;',
				],
			]
		);
		
		
		$this->add_responsive_control(
			'secondline_elements_load_more_padding',
			[
				'label' => esc_html__( 'Padding', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .infinite-nav-slt a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'secondline_elements_load_moretypography',
				'label' => esc_html__( 'Typography', 'secondline-custom-plugin' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .infinite-nav-slt a',
			]
		);
		
		
		
		
		$this->start_controls_tabs( 'slt_elements_button_tabs' );

		$this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'secondline-custom-plugin' ) ] );

		$this->add_control(
			'slt_elements_button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .infinite-nav-slt a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'slt_elements_button_background_color',
			[
				'label' => esc_html__( 'Background Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .infinite-nav-slt a' => 'background-color: {{VALUE}};',
				],
			]
		);

		
		$this->end_controls_tab();

		$this->start_controls_tab( 'slt_elements_hover', [ 'label' => esc_html__( 'Hover', 'secondline-custom-plugin' ) ] );

		$this->add_control(
			'slt_elements_button_hover_text_color',
			[
				'label' => esc_html__( 'Text Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .infinite-nav-slt a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'slt_elements_button_hover_background_color',
			[
				'label' => esc_html__( 'Background Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .infinite-nav-slt a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		
		$this->end_controls_tabs();
		
		
		
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_styles_filter_styles',
			[
				'label' => esc_html__( 'Filtering Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		
		$this->add_control(
			'secondline_elements_filter_border_color',
			[
				'label' => esc_html__( 'Bottom Border', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.secondline-filter-button-group' => 'border-color: {{VALUE}}',
				],
			]
		);
		
		
		$this->add_control(
			'secondline_elements_filter_font_color',
			[
				'label' => esc_html__( 'Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.secondline-filter-button-group li' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'secondline_elements_filter_font_selected_color',
			[
				'label' => esc_html__( 'Selected Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.secondline-filter-button-group li.slt-checked' => 'color: {{VALUE}}',
					'{{WRAPPER}} ul.secondline-filter-button-group li:hover' => 'color: {{VALUE}}',
				],
			]
		);
		

		$this->add_control(
			'secondline_elements_filter_font_border_color',
			[
				'label' => esc_html__( 'Default Border', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.secondline-filter-button-group li' => 'border-color: {{VALUE}}',
				],
			]
		);
		
		
		$this->add_control(
			'secondline_elements_filter_font_selected_border_color',
			[
				'label' => esc_html__( 'Selected Border', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.secondline-filter-button-group li.slt-checked' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} ul.secondline-filter-button-group li:hover' => 'border-color: {{VALUE}}',
				],
			]
		);
		
		
		$this->add_control(
			'secondline_elements_filter_bg_color',
			[
				'label' => esc_html__( 'Default Background', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.secondline-filter-button-group li' => 'background-color: {{VALUE}}',
				],
			]
		);			
		
		$this->add_control(
			'secondline_elements_filter_selected_bg_color',
			[
				'label' => esc_html__( 'Selected/Hover Background', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} ul.secondline-filter-button-group li.slt-checked' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} ul.secondline-filter-button-group li:hover' => 'background-color: {{VALUE}}',
				],
			]
		);			
		
		$this->add_responsive_control(
			'secondline_elements_fliltering_margin',
			[
				'label' => esc_html__( 'Padding', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} ul.secondline-filter-button-group li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'secondline_elements_filtering_align',
			[
				'label' => esc_html__( 'Filters Align', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'secondline-custom-plugin' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'secondline-custom-plugin' ),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'secondline-custom-plugin' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} ul.secondline-filter-button-group' => 'text-align: {{VALUE}}',
				],
			]
		);			
		
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'secondline_elements_filtering_typography',
				'label' => esc_html__( 'Typography', 'secondline-custom-plugin' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ul.secondline-filter-button-group li',
			]
		);
		
		$this->end_controls_section();
			
		
		
		
		
		
		
		
		
	}
	

	protected function render( ) {
		
      $settings = $this->get_settings();


	global $blogloop;
	global $post;
	
	
	if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } else if ( get_query_var('page') ) {   $paged = get_query_var('page'); } else {  $paged = 1; }
	

	$post_per_page = $settings['secondline_main_show_count'];	
	$offset = $settings['secondline_main_offset_count'];
	$offset_new = $offset + (( $paged - 1 ) * $post_per_page);
	
	if ( ! empty( $settings['secondline_show_category'] ) ) {
	 	$catpostIds = $settings['secondline_show_category']; // get custom field value
	     $catarrayIds = explode(',', $catpostIds); // explode value into an array of ids
	     if(count($catarrayIds) <= 1) // if array contains one element or less, there's spaces after comma's, or you only entered one id
	     {
	         if( strpos($catarrayIds[0], ',') !== false )// if the first array value has commas, there were spaces after ids entered
	         {
	             $catarrayIds = array(); // reset array
	             $catarrayIds = explode(', ', $catpostIds); // explode ids with space after comma's
	         }
	 	 }
		 $operatorcat = 'IN';
 	} else {

	 		$catarrayIds = '';
			$operatorcat = 'NOT IN';					
 	}
	
	
	
			
	$args = array(
			'post_type'         => 'secondline_shows',
			  'orderby'         => $settings['secondline_elements_show_order_sorting'],
			  'order'         => $settings['secondline_elements_show_order'],			
			  'ignore_sticky_posts' => 1,
			  'posts_per_page'     =>  $post_per_page,
			  'paged' => $paged,
			  'offset' => $offset_new,
			  'tax_query' => array(
				  'relation' => 'AND',
				array(
					'taxonomy' => 'show_category',
					'field'    => 'slug',
					'terms'    => $catarrayIds,
						'operator' => $operatorcat
				),
			  ),
	);

	

	$blogloop = new \WP_Query( $args );
	?>
	


	<div class="secondline-themes-show-list-main">

		<?php if($settings['secondline_elements_category_sorting_on'] == 'yes' ): ?>
			
			<ul class="secondline-filter-button-group secondline-filter-group-<?php echo esc_attr($this->get_id()); ?>">
				<?php if($settings['secondline_show_category']): ?>
				<?php
					$i = 0;
					$args = array(
					    'hide_empty'             => '0',
					    'slug'              => $catarrayIds,
					); 
					$terms = get_terms( 'show_category', $args );
					if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
						echo '<li class="slt-checked" data-filter="*">' . $settings['secondline_elements_category_sorting_text'] .'</li> ';	
				
						foreach ( $terms as $term ) { 
						if ($i == 0) {
						echo '<li data-filter=".'.$term->slug.'">' .$term->name .'</li> ';	
						} else if ($i > 0)  {
						echo '<li data-filter=".'.$term->slug.'">' .$term->name .'</li> ';	
						}
						$i++;
						}
					}	
				?>
				<?php else : ?>
					<?php
						$i = 0;
						$terms = get_terms( 'show_category', 'hide_empty=0' );
						if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
							echo '<li class="slt-checked" data-filter="*">' . $settings['secondline_elements_category_sorting_text'] .'</li> ';	
				
							foreach ( $terms as $term ) { 
							if ($i == 0) {
							echo '<li data-filter=".'.$term->slug.'">' .$term->name .'</li> ';	
							} else if ($i > 0)  {
							echo '<li data-filter=".'.$term->slug.'">' .$term->name .'</li> ';	
							}
							$i++;
							}
						}	
					?>
				<?php endif ?>
			</ul>
			
			<div class="clearfix-slt"></div>

		<?php endif ?>

		
		<div class="secondline-masonry-margins">
			<div id="secondline-blog-index-masonry-<?php echo esc_attr($this->get_id()); ?>">
				
				<?php while($blogloop->have_posts()): $blogloop->the_post();?>
				<div class="secondline-masonry-item <?php if($settings['secondline_elements_category_sorting_on'] == 'yes' ): ?><?php  $terms = get_the_terms( $post->ID , 'show_category' );  if ( !empty( $terms ) ) : 	foreach ( $terms as $term ) { 	$term_link = get_term_link( $term, 'show_category' ); if( is_wp_error( $term_link ) ) continue; echo " ". $term->slug ; }  endif; ?><?php endif ?>">
					<div class="secondline-masonry-padding-blog <?php if($settings['secondline_elements_show_list_content'] != 'yes' ): ?> secondline_elements_show_list_content<?php endif ?><?php if($settings['secondline_elements_show_list_title'] != 'yes' ): ?> secondline_elements_show_list_title<?php endif ?><?php if($settings['secondline_elements_show_list_cat'] != 'yes' ): ?> secondline_elements_show_list_cat<?php endif ?> secondline_elements_show_list_disable_match<?php if($settings['secondline_elements_show_list_excerpt'] != 'yes' ): ?> secondline_elements_show_list_excerpt<?php endif ?><?php if($settings['secondline_elements_show_list_read_more'] != 'yes' ): ?> secondline_elements_show_list_read_more<?php endif ?><?php if($settings['secondline_elements_image_grid_column_count'] == '100%') :?> single-column-slt<?php else: ?> grid-columns-slt<?php endif;?> <?php if ($settings['secondline_elements_shows_masonry'] == 'yes' ) : ?>masonry-secondline<?php else: ?>fitRows-secondline <?php endif; ?>">
						<div class="secondline-themes-isotope-animation">
							<?php include(locate_template('template-parts/elementor/content-show-grid.php')); ?>
						</div>
					</div>
				</div>
				<?php endwhile; ?>
				
				
			</div>
		</div>
				
		
		
		<div class="clearfix-slt"></div>
		
	
		<?php if ( $settings['secondline_elements_show_list_pagination'] == 'default' ) : ?>
			<?php
			
			$page_tot = ceil(($blogloop->found_posts - $offset) / $post_per_page);
			
			if ( $page_tot > 1 ) {
			$big        = 999999999;
	      echo paginate_links( array(
	              'base'      => str_replace( $big, '%#%',get_pagenum_link( 999999999, false ) ), // need an unlikely integer cause the url can contains a number
	              'format'    => '?paged=%#%',
	              'current'   => max( 1, $paged ),
	              'total'     => ceil(($blogloop->found_posts - $offset) / $post_per_page),
	              'prev_next' => true,
	  				'prev_text'    => esc_html__('&lsaquo;', 'secondline-custom-plugin'),
	  				'next_text'    => esc_html__('&rsaquo;', 'secondline-custom-plugin'),
	              'end_size'  => 1,
	              'mid_size'  => 2,
	              'type'      => 'list'
	          )
	      );
			}
			?>
		<?php endif; ?>

		<?php if ( $settings['secondline_elements_show_list_pagination'] == 'load-more' ) : ?>
			
			<?php $page_tot = ceil(($blogloop->found_posts - $offset) / $post_per_page); if ( $page_tot > 1 ) : ?>
				<div id="secondline-load-more-manual">
				<div id="infinite-nav-slt-<?php echo esc_attr($this->get_id()); ?>" class="infinite-nav-slt"><div class="nav-previous"><?php next_posts_link( $settings['secondline_main_show_load_more']
. '<span><i class="fa ' . $settings['section_styles_load_more_icon'] . '"></i></span>', $blogloop->max_num_pages ); ?></div></div>
				</div>
			<?php endif ?>
		<?php endif; ?>
	
		<?php if ( $settings['secondline_elements_show_list_pagination'] == 'infinite-scroll' ) : ?>
			<?php $page_tot = ceil(($blogloop->found_posts - $offset) / $post_per_page); if ( $page_tot > 1 ) : ?><div id="infinite-nav-slt-<?php echo esc_attr($this->get_id()); ?>" class="infinite-nav-slt"><div class="nav-previous"><?php next_posts_link( 'Next', $blogloop->max_num_pages ); ?></div></div><?php endif ?>
		<?php endif; ?>
	
		
		
	</div><!-- close .secondline-themes-show-list-main -->
	
	<script type="text/javascript"> 
	jQuery(document).ready(function($) {
		'use strict';
		/* Default Isotope Load Code */
		var $container<?php echo esc_attr($this->get_id()); ?> = $("#secondline-blog-index-masonry-<?php echo esc_attr($this->get_id()); ?>").isotope();
		var $imgs = $('#secondline-blog-index-masonry-<?php echo esc_attr($this->get_id()); ?> img');
		$container<?php echo esc_attr($this->get_id()); ?>.imagesLoaded( function() {
			$(".secondline-masonry-item").addClass("opacity-secondline");
			$container<?php echo esc_attr($this->get_id()); ?>.isotope({
				itemSelector: "#secondline-blog-index-masonry-<?php echo esc_attr($this->get_id()); ?> .secondline-masonry-item",				
				percentPosition: true,
				<?php if(is_rtl()) :?>originLeft: false,<?php endif;?>
				layoutMode: <?php if ( ! empty( $settings['secondline_elements_shows_masonry'] ) ) : ?>"masonry"<?php else: ?>"fitRows" <?php endif; ?> 
	 		});
			
			$imgs.load(function () {
				$container<?php echo esc_attr($this->get_id()); ?>.isotope('layout');
			});					
			
		});
		/* END Default Isotope Code */		
		
		
		<?php if($settings['secondline_elements_category_sorting_on'] == 'yes'): ?>
		$('.secondline-filter-group-<?php echo esc_attr($this->get_id()); ?>').on( 'click', 'li', function() {
		  var filterValue = $(this).attr('data-filter');
		  $container<?php echo esc_attr($this->get_id()); ?>.isotope({ filter: filterValue });
		});
		
    	  $('.secondline-filter-group-<?php echo esc_attr($this->get_id()); ?>').each( function( i, buttonGroup ) {
    		var $buttonGroup = $( buttonGroup );
    		$buttonGroup.on( 'click', 'li', function() {
    		  $buttonGroup.find('.slt-checked').removeClass('slt-checked');
    		  $( this ).addClass('slt-checked');
    		});
    	  });
		<?php endif ?>		
		
		
		
		<?php if ( $settings['secondline_elements_show_list_pagination'] == 'infinite-scroll' || $settings['secondline_elements_show_list_pagination'] == 'load-more' ) : ?>
					
		/* Begin Infinite Scroll */
		$container<?php echo esc_attr($this->get_id()); ?>.infinitescroll({
		errorCallback: function(){  $("#infinite-nav-slt-<?php echo esc_attr($this->get_id()); ?>").delay(500).fadeOut(500, function(){ $(this).remove(); }); },
		  navSelector  : "#infinite-nav-slt-<?php echo esc_attr($this->get_id()); ?>",  
		  nextSelector : "#infinite-nav-slt-<?php echo esc_attr($this->get_id()); ?> .nav-previous a", 
		  itemSelector : "#secondline-blog-index-masonry-<?php echo esc_attr($this->get_id()); ?> .secondline-masonry-item", 
	   		loading: {
	   		 	img: "<?php echo esc_url( get_template_directory_uri() );?>/images/loader.gif",
	   			 msgText: "",
	   		 	finishedMsg: "<div id='no-more-posts'><?php esc_html_e( "No more posts", "secondline-custom-plugin" ); ?></div>",
	   		 	speed: 0, }
		  },
		  
		  
		  // trigger Isotope as a callback
		  function( newElements ) {
			  	  			  
		     $(".secondline-themes-gallery").flexslider({
		 		animation: "fade",      
		 		slideDirection: "horizontal", 
		 		slideshow: false,   
		 		smoothHeight: false,
		 		slideshowSpeed: 7000,  
		 		animationSpeed: 1000,        
		 		directionNav: true,             
		 		controlNav: true,
		 		prevText: "",   
		 		nextText: "",
		     });
			  
		    	$(".secondline-themes-default-blog-overlay a[data-rel^=\'prettyPhoto\'], .secondline-themes-feaured-image a[data-rel^=\'prettyPhoto\']").prettyPhoto({
		  			theme: "pp_default",
		    			hook: "data-rel",
		  			opacity: 0.7,
		    			show_title: false, 
		    			deeplinking: false,
		    			overlay_gallery: false,
		    			custom_markup: "",
		  			default_width: 1100,
		  			default_height: 619,
		    		social_tools:""
		    	});
				
				$(".secondline-themes-default-blog-overlay, .secondline-themes-default-blog-index").fitVids();
				

		    var $newElems = $( newElements );
 	
				$newElems.imagesLoaded(function(){
					
				$container<?php echo esc_attr($this->get_id()); ?>.isotope( "appended", $newElems );
				$(".secondline-masonry-item, #main-container-secondline .mejs-container").addClass("opacity-secondline");				
				 									
				
				if (window.innerWidth > 959) {
					
					$("#main-container-secondline #secondline-blog-index-masonry-<?php echo esc_attr($this->get_id()); ?> .mejs-container, #main-container-secondline #secondline-blog-index-masonry-<?php echo esc_attr($this->get_id()); ?> p.powerpress_links a, #main-container-secondline #secondline-blog-index-masonry-<?php echo esc_attr($this->get_id()); ?> .podcast_meta a").addClass("opacity-secondline");      
							  
					
				};  
				
				if (window.innerWidth > 959) {
					$(".single-column-slt .secondline-themes-feaured-image img").addClass("match-height-slt");
					$(".single-column-slt .secondline-blog-content").addClass("match-height-slt");
					$(".single-column-slt.secondline_elements_show_list_disable_match .secondline-themes-feaured-image img").removeClass("match-height-slt");
					$(".single-column-slt.secondline_elements_show_list_disable_match .secondline-blog-content").removeClass("match-height-slt");
					$("body .grid-columns-slt.masonry-secondline .secondline-blog-content").removeClass("match-height-slt");
				
					$('.match-height-slt').matchHeight();
					$('body .grid-columns-slt.fitRows-secondline .secondline-blog-content').matchHeight({byRow: true,});
				};				
				
				
				
			});

		  }
		);
	    /* END Infinite Scroll */
		<?php endif; ?>
		
		
		<?php if ( $settings['secondline_elements_show_list_pagination'] == 'load-more' ) : ?>
		/* PAUSE FOR LOAD MORE */
		$(window).unbind(".infscr");
		// Resume Infinite Scroll
		$("#infinite-nav-slt-<?php echo esc_attr($this->get_id()); ?> .nav-previous a").click(function(){
			$container<?php echo esc_attr($this->get_id()); ?>.infinitescroll("retrieve");
			return false;
		});
		/* End Infinite Scroll */
		<?php endif; ?>
		
	});
	</script>
	


	<?php wp_reset_postdata();?>
	

	<?php
	
	}

	protected function content_template(){}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_SecondlineElementsShowList() );