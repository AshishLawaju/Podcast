<?php
/*
Widget Name: Heading Title 
Description: Creative Heading Options.
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
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Text_Shadow;


if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class L_Theplus_Ele_Heading_Title extends Widget_Base {
		
	public function get_name() {
		return 'tp-heading-title';
	}

    public function get_title() {
        return esc_html__('Heading Title', 'tpebl');
    }

    public function get_icon() {
        return 'fa fa-header theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-essential');
    }
	
	protected function _register_controls() {
		/*tab Layout */
		$this->start_controls_section(
			'heading_title_layout_section',
			[
				'label' => esc_html__( 'Content', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
            'heading_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Style', 'tpebl'),
                'default' => 'style_1',
                'options' => [
                    'style_1' => esc_html__('Modern', 'tpebl'),
                    'style_2' => esc_html__('Simple', 'tpebl'),
                    'style_4' => esc_html__('Classic', 'tpebl'),
                    'style_5' => esc_html__('Double Border', 'tpebl'),
                    'style_6' => esc_html__('Vertical Border', 'tpebl'),
                    'style_7' => esc_html__('Dashing Dots', 'tpebl'),
                    'style_8' => esc_html__('Unique', 'tpebl'),
                    'style_9' => esc_html__('Stylish', 'tpebl'),
                ],
            ]
        );
		$this->add_control(
			'select_heading',
			[
				'label' => esc_html__( 'Select Heading', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'  => esc_html__( 'Default', 'tpebl' ),
					'page_title' => esc_html__( 'Page Title', 'tpebl' ),					
				],
			]
		);
		$this->add_control(
            'title',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__('Heading Title', 'tpebl'),
                'label_block' => true,
                'default' => esc_html__('Heading', 'tpebl'),
				'dynamic' => [
					'active'   => true,
				],
				'condition' => [
					'select_heading' => 'default',
				],
            ]
        );		
		$this->add_control(
            'sub_title',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__('Sub Title', 'tpebl'),
                'label_block' => true,
                'separator' => 'before',
                'default' => esc_html__('Sub Title', 'tpebl'),
				'dynamic' => [
					'active'   => true,
				],
            ]
        );
		$this->add_control(
            'title_s',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__('Extra Title', 'tpebl'),
                'label_block' => true,
                'separator' => 'before',
                'default' => esc_html__('Title', 'tpebl'),
				'dynamic' => [
					'active'   => true,
				],
            ]
        );
		$this->add_control(
            'heading_s_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Extra Title Position', 'tpebl'),
                'default' => 'text_after',
                'options' => [
                    'text_after' => esc_html__('Prefix', 'tpebl'),
                    'text_before' => esc_html__('Postfix', 'tpebl'),
                ],
            ]
        );
		$this->add_responsive_control(
			'sub_title_align',
			[
				'label' => esc_html__( 'Alignment', 'tpebl' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'tpebl' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'tpebl' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'tpebl' ),
						'icon' => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => esc_html__( 'Justify', 'tpebl' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'prefix_class' => 'text-%s',
				'default' => 'center',
				 'separator' => 'before',				
			]
		);
		$this->add_control(
			'heading_title_subtitle_limit',
			[
				'label' => esc_html__( 'Heading Title & Sub Title Limit', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'no',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'display_heading_title_limit',
			[
				'label' => esc_html__( 'Heading Title Limit', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'no',
				'separator' => 'before',
				'condition'   => [
					'heading_title_subtitle_limit'    => 'yes',
				],
			]
		);
		$this->add_control(
            'display_heading_title_by', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Limit on', 'tpebl'),
                'default' => 'char',
                'options' => [
                    'char' => esc_html__('Character', 'tpebl'),
                    'word' => esc_html__('Word', 'tpebl'),                    
                ],
				'condition'   => [
					'heading_title_subtitle_limit'    => 'yes',
					'display_heading_title_limit'    => 'yes',
				],
            ]
        );
		$this->add_control(
			'display_heading_title_input',
			[
				'label' => esc_html__( 'Heading Title Count', 'tpebl' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 1000,
				'step' => 1,				
				'condition'   => [
					'heading_title_subtitle_limit'    => 'yes',
					'display_heading_title_limit'    => 'yes',
				],
			]
		);
		$this->add_control(
			'display_title_3_dots',
			[
				'label' => esc_html__( 'Display Dots', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'yes',
				'condition'   => [
					'heading_title_subtitle_limit'    => 'yes',
					'display_heading_title_limit'    => 'yes',
				],
			]
		);
		
		$this->add_control(
			'display_sub_title_limit',
			[
				'label' => esc_html__( 'Sub Title Limit', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'no',
				'separator' => 'before',
				'condition'   => [
					'heading_title_subtitle_limit'    => 'yes',
				],
			]
		);
		$this->add_control(
            'display_sub_title_by', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Limit on', 'tpebl'),
                'default' => 'char',
                'options' => [
                    'char' => esc_html__('Character', 'tpebl'),
                    'word' => esc_html__('Word', 'tpebl'),                    
                ],
				'condition'   => [
					'heading_title_subtitle_limit'    => 'yes',
					'display_sub_title_limit'    => 'yes',
				],
            ]
        );
		$this->add_control(
			'display_sub_title_input',
			[
				'label' => esc_html__( 'Sub Title Count', 'tpebl' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 1000,
				'step' => 1,				
				'condition'   => [
					'heading_title_subtitle_limit'    => 'yes',
					'display_sub_title_limit'    => 'yes',
				],
			]
		);
		$this->add_control(
			'display_sub_title_3_dots',
			[
				'label' => esc_html__( 'Display Dots', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'yes',
				'condition'   => [
					'heading_title_subtitle_limit'    => 'yes',
					'display_sub_title_limit'    => 'yes',
				],
			]
		);
		$this->end_controls_section();
		/*tab style/Layout*/		
		
		/*tab style*/
		$this->start_controls_section(
            'section_styling',
            [
                'label' => esc_html__('Separator Settings', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'    => [
					'heading_style!' => ['style_1','style_2','style_8'],
				],
            ]
        );
		$this->add_control(
            'double_color',
            [
                'label' => esc_html__('Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => '#4d4d4d',
                'selectors' => [
                    '{{WRAPPER}} .heading.style-5 .heading-title:before,{{WRAPPER}} .heading.style-5 .heading-title:after' => 'background: {{VALUE}};',
                ],
				'condition'    => [
					'heading_style' => 'style_5',
				],
            ]
        );
		$this->add_control(
            'double_top',
			[
				'label' => esc_html__( 'Top Separator Height', 'tpebl' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'min' => -50,
				'step' => 1,
				'default' => 6,
				'condition'    => [
					'heading_style' => 'style_5',
				],
				'selectors' => [
                    '{{WRAPPER}} .heading.style-5 .heading-title:before' => 'height: {{VALUE}}px;',
                ],
				
			]
        );
		$this->add_control(
            'double_bottom',
			[
				'label' => esc_html__( 'Bottom Separator Height', 'tpebl' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'min' => -50,
				'step' => 1,
				'default' => 2,
				'condition'    => [
					'heading_style' => 'style_5',
				],
				'selectors' => [
                    '{{WRAPPER}} .heading.style-5 .heading-title:after' => 'height: {{VALUE}}px;',
                ],
				
			]
        );
		$this->add_control(
			'sep_img',
			[
				'label' => esc_html__( 'Separator With Image', 'tpebl' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'condition'    => [
					'heading_style' => 'style_4',
				],
			]
		);
		$this->add_control(
            'sep_clr',
            [
                'label' => esc_html__('Separator Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => '#4099c3',
                'selectors' => [
                    '{{WRAPPER}} .heading .title-sep' => 'border-color: {{VALUE}};',
                ],
				'condition'    => [
					'heading_style' => ['style_4','style_9'],
				],
            ]
        );
		$this->add_control(
            'sep_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Separator Width', 'tpebl'),
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'range' => [
					'' => [
						'min' => 0,
						'max' => 100,
						'step' => 2,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
                    '{{WRAPPER}} .heading .title-sep,{{WRAPPER}} .heading .seprator' => 'width: {{SIZE}}{{UNIT}};',
                ],
				'condition'    => [
					'heading_style' => ['style_4','style_9'],
				],
            ]
        );
		$this->add_control(
            'dot_color',
            [
                'label' => esc_html__('Separator Dot Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ca2b2b',
                'selectors' => [
					'{{WRAPPER}} .heading .sep-dot' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .heading.style-7 .head-title:after' => 'color: {{VALUE}}; text-shadow: 15px 0 {{VALUE}}, -15px 0 {{VALUE}};',
                ],
				'condition'    => [
					'heading_style' => ['style_7','style_9'],
				],
            ]
        );
		$this->add_control(
            'sep_height',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Separator Height', 'tpebl'),
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 2,
				],
				'range' => [
					'' => [
						'min' => 0,
						'max' => 10,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
                    '{{WRAPPER}} .heading .title-sep' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
				'condition'    => [
					'heading_style' => 'style_4',
				],
            ]
        );
		$this->add_control(
            'top_clr',
            [
                'label' => esc_html__('Separator Vertical Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => '#1e73be',
                'selectors' => [
                    '{{WRAPPER}} .heading .vertical-divider' => 'background-color: {{VALUE}};',
                ],
				'condition'    => [
					'heading_style' => 'style_6',
				],
            ]
        );
		$this->end_controls_section();
		/*tab style*/
		/*tab Main Title Style*/
		$this->start_controls_section(
            'section_title_styling',
            [
                'label' => esc_html__('Main Title', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'    => [
					'title!' => '',
				],	
								
            ]
        );
		$this->add_control(
            'title_h', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Title Tag', 'tpebl'),
                'default' => 'h2',
                'options' => l_theplus_get_tags_options('a'),
            ]
        );
		$this->add_control(
			'title_link',
			[
				'label' => esc_html__( 'Heading Title Link', 'tpebl' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'separator' => 'after',
				'placeholder' => esc_html__( 'https://www.demo-link.com', 'tpebl' ),
				'condition' => [
					'title_h' => 'a',
				],
			]
		);	
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'tpebl'),
                'selector' => '{{WRAPPER}} .heading .heading-title',
            ]
        );
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'tpebl' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'solid' => [
						'title' => esc_html__( 'Solid', 'tpebl' ),
						'icon' => 'eicon-paint-brush',
					],
					'gradient' => [
						'title' => esc_html__( 'Gradient', 'tpebl' ),
						'icon' => 'fa fa-barcode',
					],
				],
				'label_block' => false,
				'default' => 'solid',
				'toggle' => true,
			]
		);
		$this->add_control(
			'title_solid_color',
			[
				'label'     => esc_html__( 'Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .heading .heading-title' => 'color: {{VALUE}};',
				],
				'default' => '#313131',
				'condition'    => [
					'title_color' => ['solid'],
				],
			]
		);
		$this->add_control(
            'title_gradient_color1',
            [
                'label' => esc_html__('Color 1', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => 'orange',
				'condition'    => [
					'title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_gradient_color1_control',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Color 1 Location', 'tpebl'),
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'render_type' => 'ui',
				'condition'    => [
					'title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_gradient_color2',
            [
                'label' => esc_html__('Color 2', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => 'cyan',
				'condition'    => [
					'title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_gradient_color2_control',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Color 2 Location', 'tpebl'),
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'render_type' => 'ui',
				'condition'    => [
					'title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_gradient_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Gradient Style', 'tpebl'),
                'default' => 'linear',
                'options' => l_theplus_get_gradient_styles(),
				'condition'    => [
					'title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_gradient_angle', [
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Gradient Angle', 'tpebl'),
				'size_units' => [ 'deg' ],
				'default' => [
					'unit' => 'deg',
					'size' => 180,
				],
				'range' => [
					'deg' => [
						'step' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .heading .heading-title' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{title_gradient_color1.VALUE}} {{title_gradient_color1_control.SIZE}}{{title_gradient_color1_control.UNIT}}, {{title_gradient_color2.VALUE}} {{title_gradient_color2_control.SIZE}}{{title_gradient_color2_control.UNIT}})',
				],
				'condition'    => [
					'title_color' => ['gradient'],
					'title_gradient_style' => ['linear']
				],
				'of_type' => 'gradient',
			]
        );
		$this->add_control(
            'title_gradient_position', [
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Position', 'tpebl'),
				'options' => l_theplus_get_position_options(),
				'default' => 'center center',
				'selectors' => [
					'{{WRAPPER}} .heading .heading-title' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{title_gradient_color1.VALUE}} {{title_gradient_color1_control.SIZE}}{{title_gradient_color1_control.UNIT}}, {{title_gradient_color2.VALUE}} {{title_gradient_color2_control.SIZE}}{{title_gradient_color2_control.UNIT}})',
				],
				'condition' => [
					'title_color' => [ 'gradient' ],
					'title_gradient_style' => 'radial',
				],
				'of_type' => 'gradient',
			]
        );
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'title_shadow',
				'selectors' => '{{WRAPPER}} .heading .heading-title',
				'separator' => 'before',
			]
		);
		$this->add_control(
            'special_effect',
            [
				'label'   => esc_html__( 'Special Effect', 'tpebl' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'separator' => 'before',
				'condition' => [
					'heading_style' => [ 'style_1','style_2','style_8' ],
				],
			]			
		);
		$this->add_control(
			'special_effect_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'heading_style' => [ 'style_1','style_2','style_8' ],
					'special_effect' => 'yes',
				],
			]
		);
		$this->end_controls_section();
		/*tab Title Style*/
		/*tab Sub Title Style*/
		$this->start_controls_section(
            'section_sub_title_styling',
            [
                'label' => esc_html__('Sub Title', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'    => [
					'sub_title!' => '',
				],
            ]
        );
		$this->add_control(
            'sub_title_tag', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Subtitle Tag', 'tpebl'),
                'default' => 'h3',
                'options' => l_theplus_get_tags_options(),
            ]
        );
		
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sub_title_typography',
                'label' => esc_html__('Typography', 'tpebl'),
                'selector' => '{{WRAPPER}} .heading .heading-sub-title',
            ]
        );
		$this->add_control(
			'sub_title_color',
			[
				'label' => esc_html__( 'Subtitle Title Color', 'tpebl' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'solid' => [
						'title' => esc_html__( 'Solid', 'tpebl' ),
						'icon' => 'eicon-paint-brush',
					],
					'gradient' => [
						'title' => esc_html__( 'Gradient', 'tpebl' ),
						'icon' => 'fa fa-barcode',
					],
				],
				'label_block' => false,
				'default' => 'solid',
				'toggle' => true,
			]
		);
		$this->add_control(
			'sub_title_solid_color',
			[
				'label'     => esc_html__( 'Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .heading .heading-sub-title' => 'color: {{VALUE}};',
				],
				'default' => '#313131',
				'condition'    => [
					'sub_title_color' => ['solid'],
				],
			]
		);
		$this->add_control(
            'sub_title_gradient_color1',
            [
                'label' => esc_html__('Color 1', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => 'orange',
				'condition'    => [
					'sub_title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'sub_title_gradient_color1_control',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Color 1 Location', 'tpebl'),
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'render_type' => 'ui',
				'condition'    => [
					'sub_title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'sub_title_gradient_color2',
            [
                'label' => esc_html__('Color 2', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => 'cyan',
				'condition'    => [
					'sub_title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'sub_title_gradient_color2_control',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Color 2 Location', 'tpebl'),
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'render_type' => 'ui',
				'condition'    => [
					'sub_title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'sub_title_gradient_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Gradient Style', 'tpebl'),
                'default' => 'linear',
                'options' => l_theplus_get_gradient_styles(),
				'condition'    => [
					'sub_title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'sub_title_gradient_angle', [
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Gradient Angle', 'tpebl'),
				'size_units' => [ 'deg' ],
				'default' => [
					'unit' => 'deg',
					'size' => 180,
				],
				'range' => [
					'deg' => [
						'step' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .heading .heading-sub-title' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{sub_title_gradient_color1.VALUE}} {{sub_title_gradient_color1_control.SIZE}}{{sub_title_gradient_color1_control.UNIT}}, {{sub_title_gradient_color2.VALUE}} {{sub_title_gradient_color2_control.SIZE}}{{sub_title_gradient_color2_control.UNIT}})',
				],
				'condition'    => [
					'sub_title_color' => ['gradient'],
					'sub_title_gradient_style' => ['linear']
				],
				'of_type' => 'gradient',
			]
        );
		$this->add_control(
            'sub_title_gradient_position', [
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Position', 'tpebl'),
				'options' => l_theplus_get_position_options(),
				'default' => 'center center',
				'selectors' => [
					'{{WRAPPER}} .heading .heading-sub-title' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{sub_title_gradient_color1.VALUE}} {{sub_title_gradient_color1_control.SIZE}}{{sub_title_gradient_color1_control.UNIT}}, {{sub_title_gradient_color2.VALUE}} {{sub_title_gradient_color2_control.SIZE}}{{sub_title_gradient_color2_control.UNIT}})',
				],
				'condition' => [
					'sub_title_color' => [ 'gradient' ],
					'sub_title_gradient_style' => 'radial',
				],
				'of_type' => 'gradient',
			]
        );
		$this->end_controls_section();
		/*tab Extra Title Style*/
		/*tab Ex Title Style*/
		$this->start_controls_section(
            'section_extra_title_styling',
            [
                'label' => esc_html__('Extra Title', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'    => [
					'heading_style' => 'style_1',
					'title_s!' => '',
				],
            ]
        );
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'ex_title_typography',
                'label' => esc_html__('Typography', 'tpebl'),
                'selector' => '{{WRAPPER}} .heading .title-s',
            ]
        );
		$this->add_control(
			'ex_title_color',
			[
				'label' => esc_html__( 'Extra Title Color', 'tpebl' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'solid' => [
						'title' => esc_html__( 'Solid', 'tpebl' ),
						'icon' => 'eicon-paint-brush',
					],
					'gradient' => [
						'title' => esc_html__( 'Gradient', 'tpebl' ),
						'icon' => 'fa fa-barcode',
					],
				],
				'label_block' => false,
				'default' => 'solid',
				'toggle' => true,
			]
		);
		$this->add_control(
			'ex_title_solid_color',
			[
				'label'     => esc_html__( 'Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .heading .title-s' => 'color: {{VALUE}};',
				],
				'default' => '#313131',
				'condition'    => [
					'ex_title_color' => ['solid'],
				],
			]
		);
		$this->add_control(
            'ex_title_gradient_color1',
            [
                'label' => esc_html__('Color 1', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => 'orange',
				'condition'    => [
					'ex_title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'ex_title_gradient_color1_control',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Color 1 Location', 'tpebl'),
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'render_type' => 'ui',
				'condition'    => [
					'ex_title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'ex_title_gradient_color2',
            [
                'label' => esc_html__('Color 2', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => 'cyan',
				'condition'    => [
					'ex_title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'ex_title_gradient_color2_control',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Color 2 Location', 'tpebl'),
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'render_type' => 'ui',
				'condition'    => [
					'ex_title_color' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'ex_title_gradient_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Gradient Style', 'tpebl'),
                'default' => 'linear',
                'options' => l_theplus_get_gradient_styles(),
				'condition'    => [
					'ex_title_color' => 'gradient',
					],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'ex_title_gradient_angle', [
				'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Gradient Angle', 'tpebl'),
				'size_units' => [ 'deg' ],
				'default' => [
					'unit' => 'deg',
					'size' => 180,
				],
				'range' => [
					'deg' => [
						'step' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .heading .title-s' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{ex_title_gradient_color1.VALUE}} {{ex_title_gradient_color1_control.SIZE}}{{ex_title_gradient_color1_control.UNIT}}, {{ex_title_gradient_color2.VALUE}} {{ex_title_gradient_color2_control.SIZE}}{{ex_title_gradient_color2_control.UNIT}})',
				],
				'condition'    => [
					'ex_title_color' => ['gradient'],
					'ex_title_gradient_style' => ['linear']
				],
				'of_type' => 'gradient',
			]
        );
		$this->add_control(
            'ex_title_gradient_position', [
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Position', 'tpebl'),
				'options' => l_theplus_get_position_options(),
				'default' => 'center center',
				'selectors' => [
					'{{WRAPPER}} .heading .title-s' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{ex_title_gradient_color1.VALUE}} {{ex_title_gradient_color1_control.SIZE}}{{ex_title_gradient_color1_control.UNIT}}, {{ex_title_gradient_color2.VALUE}} {{ex_title_gradient_color2_control.SIZE}}{{ex_title_gradient_color2_control.UNIT}})',
				],
				'condition' => [
					'ex_title_color' => [ 'gradient' ],
					'ex_title_gradient_style' => 'radial',
				],
				'of_type' => 'gradient',
			]
        );
		$this->end_controls_section();
		/*tab Extra Title Style*/
		
		
		/*tab Setting option*/
		$this->start_controls_section(
            'section_settings_option_styling',
            [
                'label' => esc_html__('Advanced', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		
		$this->add_control(
            'position',
            [
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Title Position', 'tpebl'),
				'default' => 'after',
				'options' => [
					'before' => esc_html__('Before Title', 'tpebl'),
					'after' => esc_html__('After Title', 'tpebl'),
				],
			]
		);
		$this->add_control(
            'mobile_center_align',
            [
				'type' => Controls_Manager::SWITCHER,
				'label' => esc_html__('Center Alignment In Mobile', 'tpebl'),
				'default' => 'no',				
			]
		);
		$this->end_controls_section();
		/*tab Extra Title Style*/
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
				'label'   => esc_html__( 'Choose Animation Effect', 'tpebl' ),
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
	protected function l_limit_words($string, $word_limit){
		$words = explode(" ",$string);
		return implode(" ",array_splice($words,0,$word_limit));
	}
	
	protected function render() {

	$settings = $this->get_settings_for_display();
	
		$heading_style=$settings["heading_style"];
		$heading_title_text='';
		if(!empty($settings["select_heading"]) && $settings["select_heading"]=="page_title"){
			$heading_title_text = get_the_title();
		}else if(!empty($settings["title"])){
			if((!empty($settings['display_heading_title_limit']) && $settings['display_heading_title_limit']=='yes') && !empty($settings['display_heading_title_input'])){
				if(!empty($settings['display_heading_title_by'])){				
					if($settings['display_heading_title_by']=='char'){												
						$heading_title_text = substr($settings['title'],0,$settings['display_heading_title_input']);								
					}else if($settings['display_heading_title_by']=='word'){
						$heading_title_text = $this->l_limit_words($settings['title'],$settings['display_heading_title_input']);					
					}
				}				
				if($settings['display_heading_title_by']=='char'){
					if(strlen($settings["title"]) > $settings['display_heading_title_input']){
						if(!empty($settings['display_title_3_dots']) && $settings['display_title_3_dots']=='yes'){
							$heading_title_text .='...';
						}
					}
				}else if($settings['display_heading_title_by']=='word'){
					if(str_word_count($settings["title"]) > $settings['display_heading_title_input']){
					if(!empty($settings['display_title_3_dots']) && $settings['display_title_3_dots']=='yes'){
						$heading_title_text .='...';
					}
				}
				}
				
				
			}else{				
				$heading_title_text =$settings["title"];
			}
		}
		
		$imgSrc=$sub_gradient_cass =$title_s_gradient_cass =$title_gradient_cass ='';
		if(!empty($settings["sep_img"]["url"])){
			$image_id=$settings["sep_img"]["id"];				
			$imgSrc= tp_get_image_rander( $image_id,'full', [ 'class' => 'service-img' ] );
		}
		
		if($settings["title_color"] == "gradient") {
			$title_gradient_cass = 'heading-title-gradient';
		}
		if($settings["ex_title_color"] == "gradient") {
			$title_s_gradient_cass = 'heading-title-gradient';
		}
		if($settings["sub_title_color"] == "gradient") {
			$sub_gradient_cass = 'heading-title-gradient';
		}
			
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
			
			$style_class='';
			if($heading_style =="style_1"){
				$style_class = 'style-1';
			}else if($heading_style =="style_2"){
				$style_class = 'style-2';
			}else if($heading_style =="style_4"){
				$style_class = 'style-4';
			}else if($heading_style =="style_5"){
				$style_class = 'style-5';
			}else if($heading_style =="style_6"){
				$style_class = 'style-6';
			}else if($heading_style =="style_7"){
				$style_class = 'style-7';
			}else if($heading_style =="style_8"){
				$style_class = 'style-8';
			}else if($heading_style =="style_9"){
				$style_class = 'style-9';
			}else if($heading_style =="style_10"){
				$style_class = 'style-10';
			}else if($heading_style =="style_11"){
				$style_class = 'style-11';
			}
			
			$uid=uniqid('heading_style');
			
			$heading ='<div class="heading heading_style '.esc_attr($uid).' '.esc_attr($style_class).' '.$animated_class.'" '.$animation_attr.'>';
			
				$mobile_center='';
				if(!empty($settings["mobile_center_align"]) && $settings["mobile_center_align"]=='yes'){
					if ($heading_style =="style_1" || $heading_style =="style_2" || $heading_style =="style_4" || $heading_style =="style_5"  || $heading_style =="style_7" || $heading_style =="style_9"){
						$mobile_center='heading-mobile-center';
					}			
				}
				$heading .='<div class="sub-style" >';

				if ($heading_style =="style_6"){
				$heading .='<div class="vertical-divider top"> </div>';
				}
					$title_con= $s_title_con = $title_s_before ='';
					
					if($heading_style =="style_1" ){
									$title_s_before .='<span class="title-s '.$title_s_gradient_cass.'"> '.$settings["title_s"].' </span>';
					}
						
						if(!empty($heading_title_text)){
						
							
							
							
							if ( ! empty( $settings['title_link']['url'] ) && $settings["title_h"]=='a') {
								$this->add_render_attribute( 'titlehref', 'href' ,$settings['title_link']['url'] );
								if ( $settings['title_link']['is_external'] ) {
									$this->add_render_attribute( 'titlehref', 'target', '_blank' );
								}
								if ( $settings['title_link']['nofollow'] ) {
									$this->add_render_attribute( 'titlehref', 'rel', 'nofollow' );
								}
							}
							
			
							$title_con ='<div class="head-title '.esc_attr($mobile_center).'" > ';
								$title_con .='<'.esc_attr(l_theplus_validate_html_tag($settings["title_h"])).' '.$this->get_render_attribute_string( "titlehref" ).' class="heading-title '.esc_attr($mobile_center).'  '.esc_attr($title_gradient_cass).'"  data-hover="'.esc_attr($heading_title_text).'">';
								if($settings["heading_s_style"]=="text_before"){
									$title_con.= $title_s_before.$heading_title_text;
								}else{
									$title_con.= $heading_title_text.$title_s_before;
								}
								$title_con .='</'.esc_attr(l_theplus_validate_html_tag($settings["title_h"])).'>';

								if ($heading_style =="style_4" || $heading_style =="style_9"){
									$title_con .='<div class="seprator sep-l" >';
									$title_con .='<span class="title-sep sep-l" ></span>';
									if ($heading_style =="style_9" ){
										$title_con .='<div class="sep-dot">.</div>';
									}else{	
									  if($imgSrc !=''){  
										$title_con .='<div class="sep-mg">'.$imgSrc.'</div>';
									  }
									}
									$title_con .='<span class="title-sep sep-r" ></span>';
									$title_con .='</div>';
								}
							$title_con .='</div>';
						}
						$sub_title_dis ='';
						if($settings["sub_title"] !=""){
							if((!empty($settings['display_sub_title_limit']) && $settings['display_sub_title_limit']=='yes') && !empty($settings['display_sub_title_input'])){			
									if(!empty($settings['display_sub_title_by'])){				
										if($settings['display_sub_title_by']=='char'){
											$sub_title_dis = substr($settings['sub_title'],0,$settings['display_sub_title_input']);										
										}else if($settings['display_sub_title_by']=='word'){
											$sub_title_dis = $this->l_limit_words($settings['sub_title'],$settings['display_sub_title_input']);					
										}
									}
										
										if($settings['display_sub_title_by']=='char'){
											if(strlen($settings["sub_title"]) > $settings['display_heading_title_input']){
												if(!empty($settings['display_sub_title_3_dots']) && $settings['display_sub_title_3_dots']=='yes'){
													$sub_title_dis .='...';
												}
											}
										}else if($settings['display_sub_title_by']=='word'){
											if(str_word_count($settings["sub_title"]) > $settings['display_heading_title_input']){
												if(!empty($settings['display_sub_title_3_dots']) && $settings['display_sub_title_3_dots']=='yes'){
													$sub_title_dis .='...';
												}
											}
										}
												
								}else{
									$sub_title_dis = $settings['sub_title'];
								}
							$s_title_con ='<div class="sub-heading">';
							$s_title_con .='<'.esc_attr(l_theplus_validate_html_tag($settings["sub_title_tag"])).' class="heading-sub-title '.esc_attr($mobile_center).' '.$sub_gradient_cass.'"> '.$sub_title_dis.' </'.esc_attr(l_theplus_validate_html_tag($settings["sub_title_tag"])).'>';
							$s_title_con .='</div>';
						}
						if($settings["position"] =="before"){
							$heading.= $s_title_con.$title_con;
							
						}if($settings["position"] =="after"){
							$heading.= $title_con.$s_title_con;
						}
				if ($heading_style =="style_6"){
					$heading .='<div class="vertical-divider bottom"> </div>';
				}
				$heading.='</div>';
			$heading.='</div>';

		echo $heading;
	}
    protected function content_template() {
	
    }

}
