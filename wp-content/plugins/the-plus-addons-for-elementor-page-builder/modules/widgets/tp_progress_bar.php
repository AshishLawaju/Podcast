<?php 
/*
Widget Name: Progress Bar
Description: Progress Bar
Author: Theplus
Author URI: https://posimyth.com
*/
namespace TheplusAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Image_Size;

use TheplusAddons\L_Theplus_Element_Load;
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class L_ThePlus_Progress_Bar extends Widget_Base {
		
	public function get_name() {
		return 'tp-progress-bar';
	}

    public function get_title() {
        return esc_html__('Progress Bar', 'tpebl');
    }

    public function get_icon() {
        return 'fa fa-pie-chart theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-essential');
    }
	
	public function get_keywords() {
		return [ 'pie chart', 'progress bar', 'chart'];
	}

    protected function _register_controls() {
		
		/* Progress Bar */
		
		$this->start_controls_section(
			'progress_bar',
			[
				'label' => esc_html__( 'Progress Bar', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'main_style',
			[
				'label' => esc_html__( 'Select Main Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'progressbar',
				'options' => [
					'progressbar'  => esc_html__( 'Progress Bar', 'tpebl' ),
					'pie_chart' => esc_html__( 'Pie Chart', 'tpebl' ),
				],
			]
		);
		
		$this->add_control(
			'pie_chart_style',
			[
				'label' => esc_html__( 'Pie Chart Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style_1',
				'options' => [
					'style_1' => esc_html__( 'Style 1', 'tpebl' ),
					'style_2'  => esc_html__( 'Style 2', 'tpebl' ),
					'style_3'  => esc_html__( 'Style 3', 'tpebl' ),
				],
				'condition'    => [
					'main_style' => [ 'pie_chart' ],
				],
			]
		);
		$this->add_control(
			'progressbar_style',
			[
				'label' => esc_html__( 'Progress Bar Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style_1',
				'options' => [
					'style_1' => esc_html__( 'Style 1', 'tpebl' ),
					'style_2'  => esc_html__( 'Style 2', 'tpebl' ),
				],
				'condition'    => [
					'main_style' => [ 'progressbar' ],
				],
			]
		);
		$this->add_control(
			'pie_border_style',
			[
				'label' => esc_html__( 'Pie Chart Round Styles', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style_1',
				'options' => [
					'style_1' => esc_html__( 'Style 1', 'tpebl' ),
					'style_2'  => esc_html__( 'Style 2', 'tpebl' ),					
				],
				'condition'    => [
					'main_style' => [ 'pie_chart' ],
					],
			]
		);
		$this->add_control(
			'progress_bar_size',
			[
				'label' => esc_html__( 'Progress Bar Height', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'small',
				'options' => [
					'small' => esc_html__( 'Small Height', 'tpebl' ),					
					'medium' => esc_html__( 'Medium Height', 'tpebl' ),					
					'large' => esc_html__( 'Large Height', 'tpebl' ),					
				],
				'condition'    => [
					'main_style' => [ 'progressbar' ],
					'progressbar_style' => [ 'style_1' ],
				],
			]
		);
		
		$this->add_control(
			'value_width',
			[
				'label' => esc_html__( 'Dynamic Value (0-100)', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%' ],
				'range' => [					
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'condition'    => [					
					'main_style' => [ 'progressbar' ],
				],
				'default' => [
					'unit' => '%',
					'size' => 59,
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'The Plus', 'tpebl' ),
				'separator' => 'before',
				'dynamic' => ['active'   => true,],
			]
		);
		$this->add_control(
			'sub_title',
			[
				'label' => esc_html__( 'Sub Title', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'The Plus', 'tpebl' ),
				'separator' => 'before',
				'dynamic' => ['active'   => true,],
			]
		);
		
		$this->add_control(
			'number',
			[
				'label' => esc_html__( 'Number', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '59', 'tpebl' ),
				'placeholder' => esc_html__( 'Enter Number Ex. 50 , 60', 'tpebl' ),
				'separator' => 'before',
				'dynamic' => ['active'   => true,],
			]
		);
		$this->add_control(
			'symbol',
			[
				'label' => esc_html__( 'Prefix/Postfix Symbol', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '%', 'tpebl' ),
				'placeholder' => esc_html__( 'Enter Symbol', 'tpebl' ),
				'dynamic' => ['active'   => true,],
			]
		);
		$this->add_control(
			'symbol_position',
			[
				'label' => esc_html__( 'Symbol Position', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'after',
				'options' => [
					'after' => esc_html__( 'After Number', 'tpebl' ),
					'before'  => esc_html__( 'Before Number', 'tpebl' ),
				],				
				'condition'    => [
					'symbol!' => '',
				],
			]
		);	
		
		$this->end_controls_section();
		$this->start_controls_section(
			'icon_progress_bar',
			[
				'label' => esc_html__( 'Icon', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'image_icon',
			[
				'label' => esc_html__( 'Select Icon', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'description' => esc_html__('You can select Icon, Custom Image using this option.','tpebl'),
				'default' => 'icon',
				'options' => [
					''  => esc_html__( 'None', 'tpebl' ),
					'icon' => esc_html__( 'Icon', 'tpebl' ),
					'image' => esc_html__( 'Image', 'tpebl' ),					
				],
			]
		);
		$this->add_control(
			'select_image',
			[
				'label' => esc_html__( 'Use Image As icon', 'tpebl' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'dynamic' => ['active'   => true,],
				'media_type' => 'image',
				'condition' => [
					'image_icon' => 'image',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'select_image_thumbnail',
				'default' => 'full',
				'separator' => 'none',
				'separator' => 'after',
			]
		);
		$this->add_control(
			'type',
			[
				'label' => esc_html__( 'Icon Font', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'font_awesome',
				'options' => [
					'font_awesome'  => esc_html__( 'Font Awesome', 'tpebl' ),
					'icon_mind' => esc_html__( 'Icons Mind (Pro)', 'tpebl' ),
				],
				'condition' => [
					'image_icon' => 'icon',
				],
			]
		);
		$this->add_control(
			'icon_fontawesome',
			[
				'label' => esc_html__( 'Icon Library', 'tpebl' ),
				'type' => Controls_Manager::ICON,
				'default' => 'fa fa-bank',
				'condition' => [
					'image_icon' => 'icon',
					'type' => 'font_awesome',
				],	
			]
		);
		$this->add_control(
			'icons_mind_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'image_icon' => 'icon',
					'type' => 'icon_mind',
				],
			]
		);
		$this->add_control(
			'icon_postition',
			[
				'label' => esc_html__( 'Icon Title Before after', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'before',
				'options' => [
					'before' => esc_html__( 'Before', 'tpebl' ),
					'after'  => esc_html__( 'After', 'tpebl' ),
				],
				'condition'    => [
					'image_icon' => [ 'icon','image','svg' ],
				],
			]
		);
		$this->end_controls_section();
		/* Progress Bar*/
		
		
		/*<-----Style tag ----> */
		/* Icon Style*/
		$this->start_controls_section(
            'section_pie_chart_styling',
            [
                'label' => esc_html__('Pie Chart Setting', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'    => [
					'main_style' => [ 'pie_chart' ],
				],
            ]
        );
		$this->add_control(
			'pie_value',
			[
				'label' => esc_html__( 'Dynamic Value (0-1)', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%' ],
				'range' => [					
					'%' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 0.6,
				],
				'condition'    => [					
					'main_style' => [ 'pie_chart' ],
				],
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'pie_size',
			[
				'label' => esc_html__( 'Pie Chart Circle Size', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px' ],
				'range' => [					
					'px' => [
						'min' => 0,
						'max' => 700,
						'step' => 2,
					],
				],
				'render_type' => 'template',
				'default' => [
					'unit' => 'px',
					'size' => 200,
				],
				'selectors' => [					
					'{{WRAPPER}} .pt-plus-circle' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
				'condition'    => [					
					'main_style' => [ 'pie_chart' ],
				],
			]
		);
		
		
		$this->add_control(
			'pie_thickness',
			[
				'label' => esc_html__( 'Thickness', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px' ],
				'range' => [					
					'%' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 5,
				],
				'condition'    => [					
					'main_style' => [ 'pie_chart' ],
				],
			]
		);
		$this->add_control(
			'data_empty_fill',
			[
				'label' => esc_html__( 'Pie Empty Color', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',				
				'condition'    => [
					'main_style' => [ 'pie_chart' ],
					'pie_chart_style!' => [ 'style_2' ],
				],
			]
		);		
		$this->add_control(
			'pie_empty_color',
			[
				'label' => esc_html__( 'pie Chart Empty Color', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition'    => [
					'main_style' => [ 'pie_chart1' ],
					'pie_chart_style!' => [ 'style_2' ],
				],
			]
		);
		$this->add_control(
			'pie_fill',
			[
				'label' => esc_html__( 'Chart Fill Color', 'tpebl' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'classic' => [
						'title' => esc_html__( 'Classic', 'tpebl' ),
						'icon' => 'eicon-paint-brush',
					],
					'gradient' => [
						'title' => esc_html__( 'Gradient', 'tpebl' ),
						'icon' => 'fa fa-barcode',
					],
				],
				'condition'    => [
					'main_style' => [ 'pie_chart' ],
				],
				'label_block' => false,
				'default' => 'classic',
			]
		);
		
		$this->add_control(
            'pie_fill_classic',
            [
                'label' => esc_html__('Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => 'orange',
				'condition' => [
					'main_style' => [ 'pie_chart' ],
					'pie_fill' => 'classic',
				],
				
            ]
        );
		$this->add_control(
            'pie_fill_gradient_color1',
            [
                'label' => esc_html__('Color 1', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => 'orange',
				'condition' => [
					'main_style' => [ 'pie_chart' ],
					'pie_fill' => 'gradient',
				],
				
            ]
        );
		$this->add_control(
            'pie_fill_gradient_color2',
            [
                'label' => esc_html__('Color 2', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => 'green',
				'condition' => [
					'main_style' => [ 'pie_chart' ],
					'pie_fill' => 'gradient',
				],
				
            ]
        );
		$this->end_controls_section();
		
		$this->start_controls_section(
            'section_title_styling',
            [
                'label' => esc_html__('Title Setting', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'selector' => '{{WRAPPER}} .progress_bar .prog-title.prog-icon .progress_bar-title,{{WRAPPER}} .pt-plus-pie_chart .progress_bar-title',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} span.progress_bar-title,
					{{WRAPPER}} .progress_bar-media.large .prog-title.prog-icon.large .progres-ims,
					{{WRAPPER}} .progress_bar-media.large .prog-title.prog-icon.large .progress_bar-title' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'title_margin',
			[
				'label' => esc_html__( 'Title Left Margin', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%' ],
				'range' => [					
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} span.progress_bar-title.
					{{WRAPPER}} .progress_bar-media.large .prog-title.prog-icon.large .progres-ims,
					{{WRAPPER}} .progress_bar-media.large .prog-title.prog-icon.large .progress_bar-title' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
				'condition'    => [					
					'main_style' => [ 'progressbar' ],
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
            'section_subtitle_styling',
            [
                'label' => esc_html__('Sub Title Setting', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'selector' => '{{WRAPPER}} .progress_bar .prog-title.prog-icon .progress_bar-sub_title,{{WRAPPER}} .pt-plus-pie_chart .progress_bar-sub_title',
			]
		);
		$this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Sub Title Color', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .progress_bar-sub_title' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->end_controls_section();
		$this->start_controls_section(
            'section_number_styling',
            [
                'label' => esc_html__('Number Setting', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'number_typography',
				'label' => esc_html__( 'Typography', 'tpebl' ),				
				'selector' => '{{WRAPPER}} .progress_bar .counter-number .theserivce-milestone-number',
			]
		);
		$this->add_control(
			'number_color',
			[
				'label' => esc_html__( 'Number Color', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .progress_bar .counter-number .theserivce-milestone-number' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
            'section_number_pre_pos_styling',
            [
                'label' => esc_html__('Number Prefix/Postfix Style', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'prefix_postfix_typography',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'selector' => '{{WRAPPER}} .progress_bar .counter-number .theserivce-milestone-symbol',
			]
		);
		$this->add_control(
			'prefix_postfix_symbol_color',
			[
				'label' => esc_html__( 'Prefix/Postfix Color', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .progress_bar .counter-number .theserivce-milestone-symbol' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->end_controls_section();
		$this->start_controls_section(
            'section_icon_styling',
            [
                'label' => esc_html__('Icon/Image Setting', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		
		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'condition'    => [					
					'image_icon' => [ 'icon' ],
				],
				'selectors' => [
					'{{WRAPPER}} span.progres-ims' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px' ],
				'range' => [					
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'condition'    => [					
					'image_icon' => [ 'icon' ],
				],
				'selectors' => [
					'{{WRAPPER}} .progress_bar .prog-title.prog-icon span.progres-ims,{{WRAPPER}} .pt-plus-circle .pianumber-css .progres-ims,{{WRAPPER}} .pt-plus-pie_chart .pie_chart .progres-ims' => 'font-size: {{SIZE}}{{UNIT}};',					
				],
				
			]
		);
		
		$this->add_control(
			'image_size',
			[
				'label' => esc_html__( 'Image Size', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px' ],				
				'range' => [					
					'px' => [
						'min' => 0,
						'max' => 300,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 40,
				],
				'condition'    => [					
					'image_icon' => [ 'image' ],
				],
				'selectors' => [
					'{{WRAPPER}} .progress_bar .progres-ims img.progress_bar-img' => 'height: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',					
				],
				
			]
		);
		$this->add_responsive_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Image Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .progress_bar .progres-ims img.progress_bar-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'    => [					
					'image_icon' => [ 'image' ],
				],
			]
		);
		
		$this->end_controls_section();
		$this->start_controls_section(
            'section_progress_bar_styling',
            [
                'label' => esc_html__('Progress Bar Setting', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'    => [					
					'main_style' => [ 'progressbar' ],
				],
            ]
        );
		$this->add_control(
			'progress_bar_margin',
			[
				'label' => esc_html__( 'Progress Bar Top Margin', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['%' ],
				'range' => [					
					'%' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .progress_bar-skill.skill-fill' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition'    => [					
					'main_style' => [ 'progressbar' ],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'progress_filled_color',
				'label' => esc_html__( 'Filled Color', 'tpebl' ),
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .progress_bar-skill-bar-filled',
			]
		);
		$this->add_control(
			'progress_empty_color',
			[
				'label' => esc_html__( 'Empty Color', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::COLOR,
			]
		);
		$this->add_control(
			'progress_seprator_color',
			[
				'label' => esc_html__( 'Seprator Color', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .progress-style_2 .progress_bar-skill-bar-filled:after' => 'border-color: {{VALUE}}',
				],
				'condition'    => [					
					'progressbar_style' => [ 'style_2' ],
				],
			]
		);
		$this->end_controls_section();
		/*Adv tab*/
		$this->start_controls_section(
            'section_plus_extra_adv',
            [
                'label' => esc_html__('Plus Extras', 'tpebl'),
                'tab' => Controls_Manager::TAB_ADVANCED,
            ]
        );
		$this->end_controls_section();
		/*Adv tab*/
		$this->start_controls_section(
            'section_animation_styling',
            [
                'label' => esc_html__('On Scroll View Animation', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
			'animation_effects',
			[
				'label'   => esc_html__( 'In Animation Effect', 'tpebl' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'no-animation',
				'options' => l_theplus_get_animation_options(),
			]
		);
		$this->add_control(
            'animation_delay',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Animation Delay', 'tpebl'),
				'default' => [
					'unit' => '',
					'size' => 50,
				],
				'range' => [
					'' => [
						'min'	=> 0,
						'max'	=> 4000,
						'step' => 15,
					],
				],
				'condition' => [
					'animation_effects!' => 'no-animation',
				],
            ]
        );
		$this->add_control(
            'animation_duration_default',
            [
				'label'   => esc_html__( 'Animation Duration', 'tpebl' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'condition' => [
					'animation_effects!' => 'no-animation',
				],
			]
		);
		$this->add_control(
            'animate_duration',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Duration Speed', 'tpebl'),
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'range' => [
					'px' => [
						'min'	=> 100,
						'max'	=> 10000,
						'step' => 100,
					],
				],
				'condition' => [
					'animation_effects!' => 'no-animation',
					'animation_duration_default' => 'yes',
				],
            ]
        );
		$this->add_control(
			'animation_out_effects',
			[
				'label'   => esc_html__( 'Out Animation Effect', 'tpebl' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'no-animation',
				'options' => l_theplus_get_out_animation_options(),
				'separator' => 'before',
				'condition' => [
					'animation_effects!' => 'no-animation',
				],
			]
		);
		$this->add_control(
            'animation_out_delay',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Out Animation Delay', 'tpebl'),
				'default' => [
					'unit' => '',
					'size' => 50,
				],
				'range' => [
					'' => [
						'min'	=> 0,
						'max'	=> 4000,
						'step' => 15,
					],
				],
				'condition' => [
					'animation_effects!' => 'no-animation',
					'animation_out_effects!' => 'no-animation',
				],
            ]
        );
		$this->add_control(
            'animation_out_duration_default',
            [
				'label'   => esc_html__( 'Out Animation Duration', 'tpebl' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'condition' => [
					'animation_effects!' => 'no-animation',
					'animation_out_effects!' => 'no-animation',
				],
			]
		);
		$this->add_control(
            'animation_out_duration',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Duration Speed', 'tpebl'),
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'range' => [
					'px' => [
						'min'	=> 100,
						'max'	=> 10000,
						'step' => 100,
					],
				],
				'condition' => [
					'animation_effects!' => 'no-animation',
					'animation_out_effects!' => 'no-animation',
					'animation_out_duration_default' => 'yes',
				],
            ]
        );
		$this->end_controls_section();

	}
	
	 protected function render() {
		$settings = $this->get_settings_for_display();		
		$animation_effects=$settings["animation_effects"];
			$animation_delay= (!empty($settings["animation_delay"]["size"])) ? $settings["animation_delay"]["size"] : 50;
			if($animation_effects=='no-animation'){
				$animated_class = '';
				$animation_attr = '';
			}else{
				$animate_offset = l_theplus_scroll_animation();
				$animated_class = 'animate-general';
				$animation_attr = ' data-animate-type="'.esc_attr($animation_effects).'" data-animate-delay="'.esc_attr($animation_delay).'"';
				$animation_attr .= ' data-animate-offset="'.esc_attr($animate_offset).'"';
				if($settings["animation_duration_default"]=='yes'){
					$animate_duration=$settings["animate_duration"]["size"];
					$animation_attr .= ' data-animate-duration="'.esc_attr($animate_duration).'"';
				}
				if(!empty($settings["animation_out_effects"]) && $settings["animation_out_effects"]!='no-animation'){
					$animation_attr .= ' data-animate-out-type="'.esc_attr($settings["animation_out_effects"]).'" data-animate-out-delay="'.esc_attr($settings["animation_out_delay"]["size"]).'"';					
					if($settings["animation_out_duration_default"]=='yes'){						
						$animation_attr .= ' data-animate-out-duration="'.esc_attr($settings["animation_out_duration"]["size"]).'"';
					}
				}
			}
		
		$main_style = $settings['main_style'];					
		$pie_chart_style = $settings['pie_chart_style'];					
		$pie_border_style = $settings['pie_border_style'];		
		$pie_empty_color = ($settings['pie_empty_color']!='') ? $settings['pie_empty_color'] : '#8072fc';
		$progress_empty_color = ($settings['progress_empty_color']!='') ? $settings['progress_empty_color'] : '#8072fc';
		
		$progressbar_style = $settings['progressbar_style'];					
		$progress_bar_size = $settings['progress_bar_size'];												
		$pie_size = (!empty($settings['pie_size']['size'])) ? $settings['pie_size']['size'] : 200;												
		$title = $settings['title'];					
		$subtitle = $settings['sub_title'];					
		$image_icon = $settings['image_icon'];					
						
		
		 $title_content='';
		if(!empty($title)){
			 $title_content= '<span class="progress_bar-title"> '.esc_html($title).' </span>';
		}
		
		$subtitle_content='';
		if(!empty($subtitle)){
			 $subtitle_content= '<div class="progress_bar-sub_title"> '.esc_html($subtitle).' </div>';;
		}
		if($pie_size != ''){
		$inner_width = ' style="';
			$inner_width .= 'width: '.esc_attr($pie_size).'px;';
			$inner_width .= 'height: '.esc_attr($pie_size).'px;';
		$inner_width .= '"';
		}
		
		$progress_bar_img='';
		if($image_icon == 'image' && !empty($settings['select_image']["url"])){
			$image_id=$settings["select_image"]["id"];				
			$img_src= tp_get_image_rander( $image_id,$settings['select_image_thumbnail_size'], [ 'class' => 'progress_bar-img' ] );
			$progress_bar_img='<span class="progres-ims">'.$img_src.'</span>';
		}
		if($image_icon == 'icon'){
			if($settings["type"]=='font_awesome'){
				$icons = $settings["icon_fontawesome"];
			}else{
				$icons = '';
			}
			$progress_bar_img = '<span class="progres-ims"><i class=" '.esc_attr($icons).'"></i></span>';
		}
		
		if($settings['icon_postition'] == 'after'){
			$icon_text = $title_content.$progress_bar_img.$subtitle_content;
		}else{
			$icon_text = $progress_bar_img.$title_content.$subtitle_content;
		}
		
		if(!empty($settings['symbol'])) {
		  if($settings['symbol_position']=="after"){
			$symbol2 = '<span class="theserivce-milestone-number icon-milestone" data-counterup-nums="'.esc_attr($settings['number']).'">'.esc_html($settings['number']).'</span><span class="theserivce-milestone-symbol">'.esc_html($settings['symbol']).'</span>';
			}elseif($settings['symbol_position']=="before"){
				$symbol2 = '<span class="theserivce-milestone-symbol">'.esc_html($settings['symbol']).'</span><span class="theserivce-milestone-number" data-counterup-nums="'.esc_attr($settings['number']).'">'.esc_html($settings['number']).'</span>';
			}
		} else {
			$symbol2 = '<span class="theserivce-milestone-number icon-milestone" data-counterup-nums="'.esc_attr($settings['number']).'">'.esc_html($settings['number']).'</span>';
		}
		if($settings['pie_fill'] =='gradient'){
			$data_fill_color = ' data-fill="{&quot;gradient&quot;: [&quot;' . $settings['pie_fill_gradient_color1'] . '&quot;,&quot;' . $settings['pie_fill_gradient_color2'] . '&quot;]}" ';
		}else{
		$data_fill_color = ' data-fill="{&quot;color&quot;: &quot;'.$settings['pie_fill_classic'].'&quot;}" ';
		}
		if($main_style == 'pie_chart_style'){
			if($pie_chart_style == 'style_1'){
				if($symbol2!= ''){
				$number_markup = '<h5 class="counter-number">'.$progress_bar_img.$symbol2.'</h5>';
				}
			}else{
				if($symbol2!= ''){
				$number_markup = '<h5 class="counter-number">'.$symbol2.'</h5>';
				}
			}
		}else{
			if($symbol2!= ''){
				$number_markup = '<h5 class="counter-number">'.$symbol2.'</h5>';
				}
		}
		$pie_border_after='';
		if($pie_border_style == "style_2") {
			$pie_border_after = "pie_border_after";
			$pie_empty_color1 = "transparent";
		}else{
			$pie_empty_color1 = $pie_empty_color;
		}
		
		$progress_width= (!empty($settings["value_width"]["size"])) ? $settings["value_width"]["size"].'%' : '59%';		
		$uid=uniqid("progress_bar");
		$progress_bar ='<div class="progress_bar pt-plus-peicharts progress-skill-bar '.esc_attr($uid).' progress_bar-'.esc_attr($main_style).' '.$animated_class.'" '.$animation_attr.' data-empty="'.esc_attr($pie_empty_color).'" data-uid="'.esc_attr($uid).'" >';
			if($main_style == 'progressbar'){
				$icon_bg = tp_bg_lazyLoad($settings['progress_filled_color_image']);
				if($progressbar_style == 'style_1'){			
					if($progress_bar_size != 'large'){
						$progress_bar .= '<div class="progress_bar-media">';
							$progress_bar .= '<div class="prog-title prog-icon">';
								$progress_bar .= $icon_text; 
							$progress_bar .= '</div>'; 	
							$progress_bar .=$number_markup;
						$progress_bar .= '</div>';	
							
							$progress_bar .= '<div class="progress_bar-skill skill-fill '.esc_attr($progress_bar_size).'" style="background-color:'.esc_attr($progress_empty_color).'">';
								$progress_bar .= '<div class="progress_bar-skill-bar-filled '.$icon_bg.'" data-width="'.esc_attr($progress_width).'">	</div>';
							$progress_bar .= '</div>';
					}else{
							$progress_bar .= '<div class="progress_bar-skill skill-fill '.esc_attr($progress_bar_size).'" style="background-color:'.esc_attr($progress_empty_color).'" >';
								$progress_bar .= '<div class="progress_bar-skill-bar-filled '.$icon_bg.'" data-width="'.esc_attr($progress_width).'">	</div>';
								$progress_bar .= '<div class="progress_bar-media '.esc_attr($progress_bar_size).' ">';	
									$progress_bar .= '<div class="prog-title prog-icon '.esc_attr($progress_bar_size).'">';
										$progress_bar .= $progress_bar_img.$title_content; 	
									$progress_bar .= '</div>';
									$progress_bar .=$number_markup;
								$progress_bar .= '</div>';
							$progress_bar .= '</div>';
							
						}
				}else if($progressbar_style == 'style_2'){
						$progress_bar .= '<div class="progress_bar-media">';	
							$progress_bar .= '<div class="prog-title prog-icon">';
								$progress_bar .= $icon_text; 	
							$progress_bar .= '</div>'; 	
							$progress_bar .=$number_markup;
						$progress_bar .= '</div>';	
						$progress_bar .= '<div class="progress_bar-skill skill-fill progress-'.esc_attr($progressbar_style).'" style="background-color:'.esc_attr($progress_empty_color).'">';
							$progress_bar .= '<div class="progress_bar-skill-bar-filled '.$icon_bg.'"  data-width="'.esc_attr($progress_width).'">	</div>';
						$progress_bar .= '</div>';
				
				}
			}
			
			if(!empty($settings['data_empty_fill'])){
				$data_empty_fill=$settings['data_empty_fill'];
			}else{
				$data_empty_fill='transparent';
			}
			
			if($main_style == 'pie_chart'){
					$progress_bar .= '<div class="pt-plus-piechart '.esc_attr($pie_border_after).' pie-'.esc_attr($pie_chart_style).'"  '.$data_fill_color.' data-emptyfill="'.$data_empty_fill.'" data-value="'.$settings['pie_value']['size'].'"  data-size="'.$settings['pie_size']['size'].'" data-thickness="'.$settings['pie_thickness']['size'].'"  data-animation-start-value="0"  data-reverse="false">';
					
						$progress_bar .= '<div class="pt-plus-circle" '.$inner_width.'>';
							$progress_bar .='<div class="pianumber-css" >';
							if($pie_chart_style != 'style_3'){
								$progress_bar .= $number_markup;
							}else{	
								$progress_bar .= $progress_bar_img;
							}
							$progress_bar .= '</div>';	
						$progress_bar .= '</div>';
					$progress_bar .= '</div>';
						if($pie_chart_style == 'style_1'){
							$progress_bar .= '<div class="pt-plus-pie_chart" >';
								$progress_bar .= $title_content;
								$progress_bar .= $subtitle_content;
							$progress_bar .= '</div>';	
						}else if($pie_chart_style == 'style_2'){
							$progress_bar .= '<div class="pt-plus-pie_chart style-2" >';
								$progress_bar .= '<div class="pie_chart " >';
									$progress_bar .= $progress_bar_img;
								$progress_bar .= '</div >';	
								$progress_bar .= '<div class="pie_chart-style2">';
								$progress_bar .= $title_content;
								$progress_bar .= $subtitle_content;
								$progress_bar .= '</div>';
									
							$progress_bar .= '</div>';	
						}else if($pie_chart_style == 'style_3'){
							$progress_bar .= '<div class="pt-plus-pie_chart style-3">';
								$progress_bar .= '<div class="pie_chart " >';
									$progress_bar .= $number_markup;
								$progress_bar .= '</div >';	
								$progress_bar .= '<div class="pie_chart-style3">';
								$progress_bar .= $title_content;
								$progress_bar .= $subtitle_content;
								$progress_bar .= '</div>';
									
							$progress_bar .= '</div>';	
						}
						
					}
		$progress_bar .='</div>';
		$inline_js_script = '( function ( $ ) { 
		"use strict";
		$( document ).ready(function() {
			var elements = document.querySelectorAll(".pt-plus-piechart");
			Array.prototype.slice.apply(elements).forEach(function(el) {
				var $el = jQuery(el);
				//$el.circleProgress({value: 0});
				new Waypoint({
					element: el,
					handler: function() {
						if(!$el.hasClass("done-progress")){
						setTimeout(function(){
							$el.circleProgress({
								value: $el.data("value"),
								emptyFill: $el.data("emptyfill"),
								startAngle: -Math.PI/4*2,
							});
							//  this.destroy();
						}, 800);
						$el.addClass("done-progress");
						}
					},
					offset: "80%"
				});
			});
		});
		$(window).on("load resize scroll", function(){
			$(".pt-plus-peicharts").each( function(){
				var height=$("canvas",this).outerHeight();
				var width=$("canvas",this).outerWidth();
				$(".pt-plus-circle",this).css("height",height+"px");
				$(".pt-plus-circle",this).css("width",width+"px");
			});
		});
	} ( jQuery ) );';
	
		$progress_bar .= wp_print_inline_script_tag($inline_js_script);
		echo $progress_bar;
	}
	
    protected function content_template() {
		
    }

}
