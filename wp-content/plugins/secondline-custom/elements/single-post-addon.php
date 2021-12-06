<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.


class Widget_SecondlineElementsSinglePost extends Widget_Base {

	public function get_name() {
		return 'secondline-single-post';
	}

	public function get_title() {
		return esc_html__( 'SecondLine - Single Post', 'secondline-custom-plugin' );
	}

	public function get_icon() {
		return 'fa fa-file-text secondline-themes-secondline-episode';
	}

   public function get_categories() {
		return [ 'basic' ];
	}
	
	
	function Widget_SeconelineElementsSinglePost($widget_instance){
		
	}
	
	protected function _register_controls() {

		
  		$this->start_controls_section(
  			'section_title_global_options',
  			[
  				'label' => esc_html__( 'Single Post Settings', 'secondline-custom-plugin' )
  			]
  		);
		
		$this->add_control(
			'secondline_post_name',
			[
				'label' => esc_html__( 'Choose Specific Post', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT2,
				'options' => secondline_elements_post_lists(),
			]
		);			
		
		
  		$this->add_responsive_control(
  			'secondline_elements_image_grid_margin',
  			[
  				'label' => esc_html__( 'Left/Right Margin (In %)', 'secondline-custom-plugin' ),
  				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .secondline-slt-elementor-post-margins' => 'margin-left:{{SIZE}}%; margin-right:{{SIZE}}%;',
					'{{WRAPPER}} .secondline-slt-elementor-post-padding-blog' => 'padding: 0px;',
					'{{WRAPPER}} .secondline-slt-elementor-post-item' => 'width: 100%;',
				],
				'render_type' => 'template'
  			]
  		);
		
		
  		$this->add_responsive_control(
  			'secondline_elements_top_bottom_spacing',
  			[
  				'label' => esc_html__( 'Top Location (In px)', 'secondline-custom-plugin' ),
  				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -300,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .secondline-themes-single-post-main' => 'position: relative; top: {{SIZE}}px',
				],
				'render_type' => 'template'
  			]
  		);		
		
		
		$this->add_control(
			'slt_excerpt_length',
			[
				'label' => esc_html__( 'Exerpt Word Count', 'secondline-custom-plugin' ),
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
			'slt_read_more_icon_single',
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
  				'label' => esc_html__( 'Post Layout', 'secondline-custom-plugin' )
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
				'label' => esc_html__( 'Post Image Background Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-themes-feaured-image' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .secondline-themes-default-blog-overlay' => 'background-color: {{VALUE}}',
				],
			]
		);
			
		
		$this->add_control(
			'secondline_elements_single_post_img',
			[
				'label' => esc_html__( 'Image Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'no',
			]
		);		
		
		
		$this->add_control(
			'secondline_elements_single_post_cat',
			[
				'label' => esc_html__( 'Category Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'secondline_elements_single_post_serie',
			[
				'label' => esc_html__( 'Episode & Season Number', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'no',
			]
		);		
		
		$this->add_control(
			'secondline_elements_single_post_author',
			[
				'label' => esc_html__( 'Author Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
		
		$this->add_control(
			'secondline_elements_single_post_date',
			[
				'label' => esc_html__( 'Date Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'secondline_elements_single_post_comment',
			[
				'label' => esc_html__( 'Comment Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
		
		$this->add_control(
			'secondline_elements_single_post_duration',
			[
				'label' => esc_html__( 'Duration Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
				
		$this->add_control(
			'secondline_elements_single_post_excerpt',
			[
				'label' => esc_html__( 'Exerpt Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);		
		
		$this->add_control(
			'secondline_elements_single_post_read_more',
			[
				'label' => esc_html__( 'Read More Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'no',
			]
		);		

		$this->add_control(
			'secondline_elements_single_post_player',
			[
				'label' => esc_html__( 'Audio Player Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
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
				'default' => '',
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
		
		
		$this->add_control(
			'secondline_elements_main_shadow',
			[
				'label' => esc_html__( 'Main Box Shadow', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'no',
				'separator' => 'before',
				'render_type' => 'ui',	
				'label_on' => esc_html__( 'On', 'secondline-custom-plugin' ),
				'label_off' => esc_html__( 'Off', 'secondline-custom-plugin' ),
			]
		);	

		$this->add_control(
			'secondline_elements_shadow_type',
			[
				'label' => esc_html__( 'Box Shadow Options', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::BOX_SHADOW,
				'condition' => [
					'secondline_elements_main_shadow!' => '',
				],
				'render_type' => 'ui',
			]
		);
		
		$this->add_control(
			'secondline_elements_shadow_position',
			[		
				'label' => esc_html__( 'Position', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					' ' => esc_html__( 'Outline', 'secondline-custom-plugin' ),
					'inset' => esc_html__( 'Inset', 'secondline-custom-plugin' ),
				],
				'condition' => [
					'secondline_elements_main_shadow!' => '',
				],
				'default' => ' ',
				'selectors' => [
					'{{WRAPPER}} .secondline-slt-elementor-post-item' => 'box-shadow: {{secondline_elements_shadow_type.HORIZONTAL}}px {{secondline_elements_shadow_type.VERTICAL}}px {{secondline_elements_shadow_type.BLUR}}px {{secondline_elements_shadow_type.SPREAD}}px {{secondline_elements_shadow_type.COLOR}} {{VALUE}}; -webkit-box-shadow: {{secondline_elements_shadow_type.HORIZONTAL}}px {{secondline_elements_shadow_type.VERTICAL}}px {{secondline_elements_shadow_type.BLUR}}px {{secondline_elements_shadow_type.SPREAD}}px {{secondline_elements_shadow_type.COLOR}} {{VALUE}}; -moz-box-shadow: {{secondline_elements_shadow_type.HORIZONTAL}}px {{secondline_elements_shadow_type.VERTICAL}}px {{secondline_elements_shadow_type.BLUR}}px {{secondline_elements_shadow_type.SPREAD}}px {{secondline_elements_shadow_type.COLOR}} {{VALUE}};',							
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
			'secondline_elements_title_align',
			[
				'label' => esc_html__( 'Title Align', 'secondline-custom-plugin' ),
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
					'{{WRAPPER}} h2.secondline-blog-title, {{WRAPPER}} h2.secondline-blog-title a' => 'text-align: {{VALUE}}',
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
				'label' => esc_html__( 'Author/Date Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		
		$this->add_control(
			'secondline_elements_author_styles_color',
			[
				'label' => esc_html__( 'Author/Date Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-post-meta' => 'color: {{VALUE}}',
					'{{WRAPPER}} .secondline-post-meta a' => 'color: {{VALUE}}',
					'{{WRAPPER}} .secondline-post-meta a:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .secondline-themes-default-blog-overlay .secondline-post-meta' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_responsive_control(
			'secondline_elements_author_align',
			[
				'label' => esc_html__( 'Title Align', 'secondline-custom-plugin' ),
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
					'{{WRAPPER}} .secondline-post-meta' => 'text-align: {{VALUE}}',
				],
			]
		);			
		
		$this->add_responsive_control(
			'secondline_elements_author_margin',
			[
				'label' => esc_html__( 'Author/Date Margin', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .secondline-post-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'secondline_elements_author_typography',
				'label' => esc_html__( 'Typography', 'secondline-custom-plugin' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .secondline-post-meta',
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
				],
			]
		);
		
		$this->add_responsive_control(
			'secondline_elements_excerpt_margin',
			[
				'label' => esc_html__( 'Excerpt Margin', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .secondline-themes-blog-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);		
		
		$this->add_responsive_control(
			'secondline_elements_excerpt_align',
			[
				'label' => esc_html__( 'Title Align', 'secondline-custom-plugin' ),
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
					'{{WRAPPER}} a.more-link' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'section_styles_more_link_styles_typography',
				'label' => esc_html__( 'Typography', 'secondline-custom-plugin' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} a.more-link',
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
				'selectors' => [
					'body #main-container-secondline {{WRAPPER}} #single-player-container-secondline .mejs-container .mejs-inner .mejs-controls .mejs-time-rail span.mejs-time-loaded, body #main-container-secondline {{WRAPPER}} #single-player-container-secondline .mejs-container .mejs-inner .mejs-controls .mejs-time-rail span.mejs-time-total, body #main-container-secondline {{WRAPPER}} #single-player-container-secondline .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-total' => 'background: {{VALUE}}',
				],
			]
		);
		
		
		$this->add_control(
			'section_styles_player_progress_color',
			[
				'label' => esc_html__( 'Progressed Background Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'body #main-container-secondline {{WRAPPER}} #single-player-container-secondline .mejs-container .mejs-inner .mejs-controls .mejs-time-rail span.mejs-time-current, body #main-container-secondline {{WRAPPER}} #single-player-container-secondline .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current' => 'background: {{VALUE}}',
				],
			]
		);		
		
		
		$this->add_control(
			'section_styles_player_icon_color',
			[
				'label' => esc_html__( 'Buttons Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'body #main-container-secondline {{WRAPPER}} #single-player-container-secondline .mejs-playpause-button.mejs-play button:before, body #main-container-secondline {{WRAPPER}} #single-player-container-secondline .mejs-playpause-button.mejs-pause button:before, body #main-container-secondline {{WRAPPER}} #single-player-container-secondline #single-player-container-secondline .mejs-playpause-button.mejs-play button:before, body #main-container-secondline {{WRAPPER}} #single-player-container-secondline .wp-playlist .wp-playlist-next, body #main-container-secondline {{WRAPPER}} #single-player-container-secondline .wp-playlist .wp-playlist-prev, body #main-container-secondline {{WRAPPER}} #single-player-container-secondline .mejs-inner .mejs-controls span, body #main-container-secondline {{WRAPPER}} #single-player-container-secondline .mejs-inner .mejs-controls button, body #main-container-secondline {{WRAPPER}} #single-player-container-secondline a.powerpress_link_pinw:before, body #main-container-secondline {{WRAPPER}} #single-player-container-secondline a.podcast-meta-new-window:before, body #main-container-secondline {{WRAPPER}} #single-player-container-secondline a.powerpress_link_d:before, body #main-container-secondline {{WRAPPER}} #single-player-container-secondline a.podcast-meta-download:before' => 'color: {{VALUE}}',
				],
			]
		);				


		$this->add_control(
			'section_styles_player_icon_control_single',
			[
				'label' => esc_html__( 'Knob / Control Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'body #main-container-secondline {{WRAPPER}} #single-player-container-secondline .mejs-controls .mejs-time-rail .mejs-time-handle, body #main-container-secondline {{WRAPPER}} #single-player-container-secondline .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-handle' => 'background: {{VALUE}}; border-color: {{VALUE}}',
				],
			]
		);			
		
		

		
		
		  $this->add_responsive_control(
  			'secondline_elements_top_player_location',
  			[
  				'label' => esc_html__( 'Top Location (In px)', 'secondline-custom-plugin' ),
  				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => -300,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} #single-player-container-secondline' => 'position: relative; top: {{SIZE}}px',
				],
				'render_type' => 'template'
  			]
  		);	
		
		$this->end_controls_section();			
				
		
		
		
		
		
	}
	

	protected function render( ) {
		
      $settings = $this->get_settings();


	global $blogloop;
	global $post;
	
	
	if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } else if ( get_query_var('page') ) {   $paged = get_query_var('page'); } else {  $paged = 1; }
	

	$post_per_page = 1;	
			
	$args = array(
			  'p'			=> $settings['secondline_post_name'],
			  'posts_per_page'  => $post_per_page,
			  'paged' 			=> $paged,
	);

	

	$blogloop = new \WP_Query( $args );
	?>
	


	<div class="secondline-themes-single-post-main">
	
		<div class="secondline-slt-elementor-post-margins">
			<div id="secondline-blog-index-slt-elementor-post-<?php echo esc_attr($this->get_id()); ?>">
				
				<?php while($blogloop->have_posts()): $blogloop->the_post();?>
				<div class="secondline-slt-elementor-post-item">
					<div class="secondline-slt-elementor-post-padding-blog <?php if($settings['secondline_elements_single_post_cat'] != 'yes' ): ?> secondline_elements_single_post_cat<?php endif ?><?php if($settings['secondline_elements_single_post_serie'] != 'yes' ): ?> secondline_elements_single_post_serie<?php endif ?><?php if($settings['secondline_elements_single_post_img'] != 'yes' ): ?> secondline_elements_single_post_img<?php endif ?><?php if($settings['secondline_elements_single_post_author'] != 'yes' ): ?> secondline_elements_single_post_author<?php endif ?><?php if($settings['secondline_elements_single_post_date'] != 'yes' ): ?> secondline_elements_single_post_date<?php endif ?><?php if($settings['secondline_elements_single_post_comment'] != 'yes' ): ?> secondline_elements_single_post_comment<?php endif ?><?php if($settings['secondline_elements_single_post_duration'] != 'yes' ): ?> secondline_elements_single_post_duration<?php endif ?><?php if($settings['secondline_elements_single_post_excerpt'] != 'yes' ): ?> secondline_elements_single_post_excerpt<?php endif ?><?php if($settings['secondline_elements_single_post_read_more'] != 'yes' ): ?> secondline_elements_single_post_read_more<?php endif ?><?php if($settings['secondline_elements_single_post_player'] != 'yes' ): ?> secondline_elements_single_post_player<?php endif ?>">
						<div class="secondline-themes-slt-post-addon-i-animation">
							<?php include(locate_template('template-parts/elementor/content-single-post.php')); ?>
						</div>
					</div>
				</div>
				<?php endwhile; ?>
				
				
			</div>
		</div>
				
		
		
		<div class="clearfix-slt"></div>
		
	
	
		
		
	</div><!-- close .secondline-themes-single-post-main -->
		
	
	<?php wp_reset_postdata();?>
	

	<?php
	
	}

	protected function content_template(){}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_SecondlineElementsSinglePost() );