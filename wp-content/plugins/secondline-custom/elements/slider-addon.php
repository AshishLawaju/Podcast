<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.


class Widget_SecondlineElementsPostSlider extends Widget_Base {

	public function get_name() {
		return 'secondline-slider';
	}

	public function get_title() {
		return esc_html__( 'SecondLine - Post Slider', 'secondline-custom-plugin' );
	}

	public function get_icon() {
		return 'fa fa-film secondline-themes-secondline-episode';
	}

   public function get_categories() {
		return [ 'basic' ];
	}
	
	function Widget_SecondlineElementsPostSlider($widget_instance){
		
	}
	
	protected function _register_controls() {

		
  		$this->start_controls_section(
  			'section_title_global_options',
  			[
  				'label' => esc_html__( 'Slider Settings', 'secondline-custom-plugin' )
  			]
  		);
		
		$this->add_control(
			'secondline_main_post_count',
			[
				'label' => esc_html__( 'Post Count', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '2',
			]
		);
		
		
		$this->add_control(
			'secondline_slider_tags',
			[
				'label' => esc_html__( 'Narrow by Filtering Tags', 'secondline-custom-plugin' ),
				'description' => esc_html__( 'Enter filtering tags to display posts with a specific tag. Add-in multiple filtering tags seperated by a comma to use multiple tags. ', 'secondline-custom-plugin' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
			]
		);
		
		
		$this->add_control(
			'secondline_post_category',
			[
				'label' => esc_html__( 'Narrow by Post Category', 'secondline-custom-plugin' ),
				'description' => esc_html__( 'Enter category slugs to display a specific category. Add-in multiple category slugs seperated by a comma to use multiple categories. ', 'secondline-custom-plugin' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
			]
		);
		
		
		$this->add_control(
			'slt_slider_excerpt_length',
			[
				'label' => esc_html__( 'Exerpt Word Count', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '60',
			]
		);			
		
		

		
		
		$this->add_control(
			'secondline_elements_post_order_sorting',
			[
				'label' => esc_html__( 'Order By', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date' => esc_html__( 'Default - Date', 'secondline-custom-plugin' ),
					'title' => esc_html__( 'Post Title', 'secondline-custom-plugin' ),
					'menu_order' => esc_html__( 'Menu Order', 'secondline-custom-plugin' ),
					'modified' => esc_html__( 'Last Modified', 'secondline-custom-plugin' ),
					'comment_count' => esc_html__( 'Comment Count', 'secondline-custom-plugin' ),
					'rand' => esc_html__( 'Random', 'secondline-custom-plugin' ),
				],
			]
		);
		
		
		$this->add_control(
			'secondline_elements_post_order',
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
			]
		);
		
		
		$this->add_control(
			'secondline_elements_post_type_select',
			[
				'label' => esc_html__( 'Select Post Type', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select the post type to display. This feature works for the Post and Podcast types, but is experimental on others.', 'secondline-custom-plugin' ),
				'options' => secondline_themes_post_type_control(),
				'default' => secondline_themes_default_post_type(),				

			]
		);		
		

		
		$this->end_controls_section();

		
 		$this->start_controls_section(
  			'section_title_layout_options',
  			[
  				'label' => esc_html__( 'Slider Layout', 'secondline-custom-plugin' )
  			]
  		);
					
		
		
		$this->add_control(
			'secondline_elements_slider_cat',
			[
				'label' => esc_html__( 'Category Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'secondline_elements_slider_serie',
			[
				'label' => esc_html__( 'Episode & Season Number Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'no',
			]
		);		
		
		$this->add_control(
			'secondline_elements_slider_author',
			[
				'label' => esc_html__( 'Author Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
		
		$this->add_control(
			'secondline_elements_slider_date',
			[
				'label' => esc_html__( 'Date Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'secondline_elements_slider_comment',
			[
				'label' => esc_html__( 'Comment Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
		
		$this->add_control(
			'secondline_elements_slider_duration',
			[
				'label' => esc_html__( 'Duration Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
				
		$this->add_control(
			'secondline_elements_slider_excerpt',
			[
				'label' => esc_html__( 'Exerpt Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);			

		$this->add_control(
			'secondline_elements_slider_player',
			[
				'label' => esc_html__( 'Audio Player Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);				

		
		$this->end_controls_section();		
		
		
		
  		$this->start_controls_section(
  			'section_title_slt_slider_options',
  			[
  				'label' => esc_html__( 'Slider Options', 'secondline-custom-plugin' )
  			]
  		);
		
		$this->add_responsive_control(
			'secondline_elements_slider_main_height',
			[
				'label' => esc_html__( 'Slider Height', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1000,
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1500,
					],
					'vh' => [
						'min' => 10,
						'max' => 150,
					],
				],
				'size_units' => [ 'px', 'vh', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .secondline-elements-slider-background' => 'height:{{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'secondline_elements_slider_transition',
			[
				'label' => esc_html__( 'Slide Transition', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => [
					'fade' => esc_html__( 'Fade', 'secondline-custom-plugin' ),
				],
			]
		);
		
		$this->add_control(
			'secondline_elements_slide_transition_speed',
			[
				'label' => esc_html__( 'Transition Speed', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '500',
			]
		);
		
		$this->add_control(
			'secondline_elements_slider_css3_animation',
			[
				'label' => esc_html__( 'Text Animation', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'secondline_animate_up',
				'options' => [
					'secondline_animate_none' => esc_html__( 'No Animation', 'secondline-custom-plugin' ),
					'secondline_animate_in' => esc_html__( 'Zoom in', 'secondline-custom-plugin' ),
					'secondline_animate_out' => esc_html__( 'Zoom Out', 'secondline-custom-plugin' ),
					'secondline_animate_down' => esc_html__( 'Fade Down', 'secondline-custom-plugin' ),
					'secondline_animate_up' => esc_html__( 'Fade Up', 'secondline-custom-plugin' ),
					'secondline_animate_right' => esc_html__( 'Fade Right', 'secondline-custom-plugin' ),
					'secondline_animate_left' => esc_html__( 'Fade Left', 'secondline-custom-plugin' ),
				],
			]
		);
		
		$this->add_control(
			'secondline_elements_autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'secondline_elements_play_number_speed',
			[
				'label' => esc_html__( 'Autoplay Speed', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '7000'
			]
		);
		
		
		$this->add_control(
			'secondline_elements_slider_pause_hover',
			[
				'label' => esc_html__( 'Pause on Hover', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'secondline_elements_slider_arrow_visiblity',
			[
				'label' => esc_html__( 'Slide Arrows', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'secondline_elements_slider_arrow_visiblity_visible',
				'options' => [
					'secondline_elements_slider_arrow_visiblity_visible' => esc_html__( 'Always Visible', 'secondline-custom-plugin' ),
					'secondline_elements_slider_arrow_visiblity_hover' => esc_html__( 'Visible on Hover', 'secondline-custom-plugin' ),
					'secondline_elements_slider_arrow_visiblity_hidden' => esc_html__( 'Hidden', 'secondline-custom-plugin' ),
				],
			]
		);
		
		$this->add_control(
			'secondline_elements_slider_bullets_visiblity',
			[
				'label' => esc_html__( 'Slide Bullets', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'secondline_elements_slider_dots_visiblity_visible',
				'options' => [
					'secondline_elements_slider_dots_visiblity_visible' => esc_html__( 'Always Visible', 'secondline-custom-plugin' ),
					'secondline_elements_slider_dots_visiblity_hover' => esc_html__( 'Visible on Hover', 'secondline-custom-plugin' ),
					'secondline_elements_slider_dots_visiblity_hidden' => esc_html__( 'Hidden', 'secondline-custom-plugin' ),
				],
			]
		);
		

		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'slt_elements_section_main_styles',
			[
				'label' => esc_html__( 'Main Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		
		$this->add_responsive_control(
			'slt_elements_content_width',
			[
				'label' => esc_html__( 'Content Width', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'size_units' => [ '%', 'px' ],
				'default' => [
					'size' => '75',
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .slider-content-max-width' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		
		$this->add_responsive_control(
			'slt_elements_content_padding',
			[
				'label' => esc_html__( 'Content Padding', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .slider-content-margins' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'slt_elements_content_align',
			[
				'label' => esc_html__( 'Align', 'secondline-custom-plugin' ),
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
					'{{WRAPPER}} .slider-content-alignment-slt' => 'text-align: {{VALUE}}',
				],
			]
		);
	
		$this->add_responsive_control(
			'slt_elements_vertical_position',
			[
				'label' => esc_html__( 'Vertical Position', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'default' => 'middle',
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'secondline-custom-plugin' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'secondline-custom-plugin' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'secondline-custom-plugin' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .slider-text-floating-container' => '{{VALUE}}',
				],
				'selectors_dictionary' => [
					'top' => 'display:block;',
					'middle' => 'display:table-cell; vertical-align:middle;',
					'bottom' => 'position:absolute; bottom:0px;',
				],
			]
		);
		
		
		$this->add_control(
			'slt_elements_background_color',
			[
				'label' => esc_html__( 'Slider Background Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-elements-slider-background' => 'background-color: {{VALUE}}',

				],
			]
		);
		
		
		$this->add_control(
			'slt_elements_slider_overlay_color',
			[
				'label' => esc_html__( 'Slider Overlay Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0.2)',
				'selectors' => [
					'{{WRAPPER}} .slider-background-overlay-color' => 'background-color: {{VALUE}}',

				],
			]
		);

		$this->end_controls_section();		
		
		$this->start_controls_section(
			'slt_elements_section_category_styles',
			[
				'label' => esc_html__( 'Meta Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'slt_elements_category_color',
			[
				'label' => esc_html__( 'Meta Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-themes-post-slider-main .secondline-post-meta, {{WRAPPER}} .secondline-themes-post-slider-main .secondline-post-meta a, {{WRAPPER}} .secondline-themes-post-slider-main .secondline-post-meta span' => 'color: {{VALUE}}',

				],
			]
		);
				

		
		$this->add_responsive_control(
			'slt_elements_category_spacing',
			[
				'label' => esc_html__( 'Margin Bottom', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .secondline-themes-post-slider-main .secondline-post-meta' => 'margin-bottom: {{SIZE}}px',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'slt_elements_content_typography',
				'label' => esc_html__( 'Typography', 'secondline-custom-plugin' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => 'body {{WRAPPER}} .secondline-themes-post-slider-main .secondline-post-meta, body {{WRAPPER}} .secondline-themes-post-slider-main .secondline-post-meta a, body {{WRAPPER}} .secondline-themes-post-slider-main .secondline-post-meta span',
			]
		);
		

		
		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'slt_elements_section_title_styles',
			[
				'label' => esc_html__( 'Title Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		
		
		$this->add_control(
			'slt_elements_title_color',
			[
				'label' => esc_html__( 'Title Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} h2.secondline-blog-slider-title' => 'color: {{VALUE}}',

				],
			]
		);
		
		$this->add_responsive_control(
			'slt_elements_title_spacing',
			[
				'label' => esc_html__( 'Margin Bottom', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} h2.secondline-blog-slider-title' => 'margin-bottom: {{SIZE}}px',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'slt_elements_title_typography',
				'label' => esc_html__( 'Typography', 'secondline-custom-plugin' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} h2.secondline-blog-slider-title',
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
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .secondline-themes-blog-excerpt' => 'color: {{VALUE}}',
					'{{WRAPPER}} .secondline-themes-blog-excerpt a' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_responsive_control(
			'secondline_elements_excerpt_margin',
			[
				'label' => esc_html__( 'Excerpt Margin', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
						'top' => (0),
						'right' => (20),
						'bottom' => (0),
						'left' => (20),
						'unit' => ('%'),
					],
				'selectors' => [
					'{{WRAPPER}} .secondline-themes-blog-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);		
		
		$this->add_responsive_control(
			'secondline_elements_excerpt_align',
			[
				'label' => esc_html__( 'Excerpt Align', 'secondline-custom-plugin' ),
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
					'{{WRAPPER}} .secondline-themes-blog-excerpt' => 'text-align: {{VALUE}}',
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
		
		
		$this->end_controls_section();	

		$this->start_controls_section(
			'section_styles_player_styles',
			[
				'label' => esc_html__( 'Media Player Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		
		$this->add_control(
			'section_styles_player_color',
			[
				'label' => esc_html__( 'Main Background Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr( get_theme_mod('secondline_themes_player_background') ),
				'selectors' => [
					'body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .mejs-container .mejs-inner .mejs-controls .mejs-time-rail span.mejs-time-loaded, body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .mejs-container .mejs-inner .mejs-controls .mejs-time-rail span.mejs-time-total, body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-total' => 'background: {{VALUE}}',					
				],
			]
		);
		
		
		$this->add_control(
			'section_styles_player_text',
			[
				'label' => esc_html__( 'Time Text Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr( get_theme_mod('secondline_themes_player_time_text') ),
				'selectors' => [
					'body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .mejs-inner .mejs-controls span' => 'color: {{VALUE}}',				
				],
			]
		);		
		
		
		
		
		
		$this->add_control(
			'section_styles_player_progress_color',
			[
				'label' => esc_html__( 'Progressed Background Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr( get_theme_mod('secondline_themes_player_progressed') ),
				'selectors' => [
					'body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .mejs-container .mejs-inner .mejs-controls .mejs-time-rail span.mejs-time-current, body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current' => 'background: {{VALUE}}',
				],
			]
		);		
		
		
		$this->add_control(
			'section_styles_player_icon_color',
			[
				'label' => esc_html__( 'Media Buttons Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr( get_theme_mod('secondline_themes_player_progressed') ),
				'selectors' => [
					'body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .mejs-playpause-button.mejs-play button:before, body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .mejs-playpause-button.mejs-pause button:before, body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .mejs-playpause-button.mejs-play button:before, body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .wp-playlist .wp-playlist-next, body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .single-player-container-secondline .mejs-volume-button.mejs-mute button:before, body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .wp-playlist .wp-playlist-prev, body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .mejs-inner .mejs-controls button, body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .mejs-playpause-button.mejs-replay button:before, body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .mejs-button.mejs-jump-forward-button button:before, body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .mejs-button.mejs-skip-back-button button:before' => 'color: {{VALUE}}',
					'body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .mejs-container .mejs-controls .mejs-playpause-button' => 'border-color: {{VALUE}}',
				],
			]
		);		
		
		
		$this->add_control(
			'section_styles_player_icon_color_hover',
			[
				'label' => esc_html__( 'Media Buttons Hover Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr( get_theme_mod('secondline_themes_player_icon_hover') ),
				'selectors' => [
					'body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .mejs-playpause-button.mejs-play:hover button:before, body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .mejs-playpause-button.mejs-pause:hover button:before, body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .secondline-themes-post-slider-main .mejs-playpause-button.mejs-play:hover button:before, body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .single-player-container-secondline .mejs-volume-button.mejs-mute:hover button:before, body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .wp-playlist .wp-playlist-next, body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .wp-playlist .wp-playlist-prev, body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .mejs-inner .mejs-controls button:hover, body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .mejs-playpause-button.mejs-replay:hover button:before, body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .mejs-button.mejs-jump-forward-button:hover button:before, body.secondline-fancy-player #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .mejs-button.mejs-skip-back-button:hover button:before' => 'color: {{VALUE}}',
					'body #main-container-secondline {{WRAPPER}} .mejs-container .mejs-controls .mejs-playpause-button:hover' => 'border-color: {{VALUE}}',
				],
			]
		);			

		
		$this->add_control(
			'section_styles_player_additional_icon_color',
			[
				'label' => esc_html__( 'Right Meta Buttons Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr( get_theme_mod('secondline_themes_player_additional_icon') ),
				'selectors' => [
					'body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main a.powerpress_link_pinw:before, body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main a.podcast-meta-new-window:before, body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main a.powerpress_link_d:before, body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main a.podcast-meta-download:before, body.secondline-fancy-player #main-container-secondline .secondline-themes-post-slider-main .slider-text-floating-container .mejs-container .mejs-controls .mejs-button.mejs-speed-button button' => 'color: {{VALUE}}',
					'body.secondline-fancy-player #main-container-secondline .secondline-themes-post-slider-main .slider-text-floating-container .mejs-container .mejs-controls .mejs-button.mejs-speed-button button' => 'border-color: {{VALUE}}',
				],
			]
		);			
		
		
		
		
		$this->add_control(
			'section_styles_player_icon_control',
			[
				'label' => esc_html__( 'Knob / Control Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default' => esc_attr( get_theme_mod('secondline_themes_player_knob') ),
				'selectors' => [
					'body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .mejs-controls .mejs-time-rail .mejs-time-handle, body #main-container-secondline {{WRAPPER}} .secondline-themes-post-slider-main .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-handle' => 'background: {{VALUE}}; border-color: {{VALUE}}',

				],
			]
		);		

		

		
				
		
		$this->add_responsive_control(
			'secondline_elements_player_margin',
			[
				'label' => esc_html__( 'Margin', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .post-list-player-container-secondline' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);		
		
		
		
		
		
		
		$this->end_controls_section();				
		
	
		
	}
	

	protected function render( ) {
		
      $settings = $this->get_settings();
		
	?>
	
	<?php	
	global $blogloop;
	global $post;

	
	$post_per_page = $settings['secondline_main_post_count'];
	$offset_new = $settings['secondline_main_offset_count'];
	
	if ( ! empty( $settings['secondline_post_category'] ) ) {
	 	$catpostIds = $settings['secondline_post_category']; // get custom field value
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
	
	if ( ! empty( $settings['secondline_slider_tags'] ) ) {
	 	$tagpostIds = $settings['secondline_slider_tags']; // get custom field value
	     $tagarrayIds = explode(',', $tagpostIds); // explode value into an array of ids
	     if(count($tagarrayIds) <= 1) // if array contains one element or less, there's spaces after comma's, or you only entered one id
	     {
	         if( strpos($tagarrayIds[0], ',') !== false )// if the first array value has commas, there were spaces after ids entered
	         {
	             $tagarrayIds = array(); // reset array
	             $tagarrayIds = explode(', ', $tagpostIds); // explode ids with space after comma's
	         }
	 	 }
		 $operatortag = 'IN';
 	} else {

	 		$tagarrayIds = '';
			$operatortag = 'NOT IN';					
 	}	
	
	if(($settings['secondline_elements_post_type_select'] == 'podcast') && taxonomy_exists( 'series' )) {
		$taxonomy_type = 'series';
	} else {
		$taxonomy_type = 'category';
	}	
	

	$args = array(
			  'post_type'         => $settings['secondline_elements_post_type_select'],
			  'orderby'         => $settings['secondline_elements_post_order_sorting'],
			  'order'         => $settings['secondline_elements_post_order'],
			  'ignore_sticky_posts' => 1,
			  'posts_per_page'     =>  $post_per_page,
			  'offset' => $offset_new,
			  'tax_query' => array(
				  'relation' => 'AND',
				array(
					'taxonomy' => $taxonomy_type,
					'field'    => 'slug',
					'terms'    => $catarrayIds,
					'operator' => $operatorcat
				),
			    array(
					'taxonomy' => 'post_tag',
					'field'    => 'name',
					'terms'    => $tagarrayIds,
					'operator' => $operatortag,
				),				 				
			  ),
	);
		

	
	$blogloop = new \WP_Query( $args );
	
	?>
	

	<div class="secondline-themes-post-slider-main <?php echo esc_attr($settings['secondline_elements_slider_arrow_visiblity'] ); ?> <?php echo esc_attr($settings['secondline_elements_slider_bullets_visiblity'] ); ?> <?php if($settings['secondline_elements_slider_cat'] != 'yes' ): ?> secondline_elements_slider_cat<?php endif ?><?php if($settings['secondline_elements_slider_serie'] != 'yes' ): ?> secondline_elements_slider_serie<?php endif ?><?php if($settings['secondline_elements_slider_author'] != 'yes' ): ?> secondline_elements_slider_author<?php endif ?><?php if($settings['secondline_elements_slider_date'] != 'yes' ): ?> secondline_elements_slider_date<?php endif ?><?php if($settings['secondline_elements_slider_comment'] != 'yes' ): ?> secondline_elements_slider_comment<?php endif ?><?php if($settings['secondline_elements_slider_duration'] != 'yes' ): ?> secondline_elements_slider_duration<?php endif ?><?php if($settings['secondline_elements_slider_excerpt'] != 'yes' ): ?> secondline_elements_slider_excerpt<?php endif ?><?php if($settings['secondline_elements_slider_player'] != 'yes' ): ?> secondline_elements_slider_player<?php endif ?>">
		<div id="secondline-elements-secondline-flexslider-<?php echo esc_attr($this->get_id()); ?>" class="flexslider">
			<ul class="slides">
				<?php while($blogloop->have_posts()): $blogloop->the_post();?>
				<li class="<?php echo esc_attr($settings['secondline_elements_slider_css3_animation'] ); ?>">
					<?php include(locate_template('template-parts/elementor/content-slider.php')); ?>
				</li>
				<?php  endwhile; // end of the loop. ?>
			</ul>
		</div><!-- #-elements-secondline-flexslider-<?php echo esc_attr($this->get_id()); ?> -->
	</div><!-- close .secondline-themes-post-slider-main -->
	
	
	<?php wp_reset_postdata();?>
	
	<script type="text/javascript"> 
	jQuery(document).ready(function($) {
		'use strict';
		
		$('#secondline-elements-secondline-flexslider-<?php echo esc_attr($this->get_id()); ?>').flexslider({
			prevText: "",
			nextText: "",
			slideshow:<?php if ( ! empty( $settings['secondline_elements_autoplay'] ) ) : ?>true<?php else: ?>false<?php endif; ?>,
			slideshowSpeed: <?php echo esc_attr($settings['secondline_elements_play_number_speed'] ); ?>,
			animation: "<?php echo esc_attr($settings['secondline_elements_slider_transition'] ); ?>",
			animationSpeed: <?php echo esc_attr($settings['secondline_elements_slide_transition_speed'] ); ?>,
			pauseOnHover: <?php if ( ! empty( $settings['secondline_elements_slider_pause_hover'] ) ) : ?>true<?php else: ?>false<?php endif; ?>,
			before: function(){
					var active_rel = $( '#secondline-elements-secondline-flexslider-<?php echo esc_attr($this->get_id()); ?> iframe' ).attr( 'src', function ( i, val ) { return val; });
					//do something
				},
		});
	

	});
	</script>
	

	<?php
	
	}

	protected function content_template(){}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_SecondlineElementsPostSlider() );