<?php 
/*
Widget Name: Accordion/FAQ
Description: Toggle of faq/accordion.
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
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;

use TheplusAddons\L_Theplus_Element_Load;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class L_ThePlus_Accordion extends Widget_Base {
		
	public function get_name() {
		return 'tp-accordion';
	}

    public function get_title() {
        return esc_html__('Accordion', 'tpebl');
    }

    public function get_icon() {
        return 'fa fa-lightbulb-o theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-tabbed');
    }
	
	public function get_keywords() {
		return [ 'accordion', 'tabs', 'toggle' ];
	}
	
    protected function _register_controls() {
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'tab_title',
			[
				'label' => esc_html__( 'Title & Content', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Accordion Title' , 'tpebl' ),
				'dynamic' => [
					'active' => true,
				],
				'label_block' => true,
			]
		);
		$repeater->add_control(
			'content_source',
			[
				'label' => esc_html__( 'Content Source', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'content',
				'options' => [
					'content'  => esc_html__( 'Content', 'tpebl' ),
					'page_template' => esc_html__( 'Page Template (Pro)', 'tpebl' ),
				],
			]
		);
		$repeater->add_control(
		'tab_content',
			[
				'label' => esc_html__( 'Content', 'tpebl' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Accordion Content', 'tpebl' ),
				'show_label' => false,
				'dynamic' => [
					'active'   => true,
				],
				'condition'    => [
					'content_source' => [ 'content' ],
				],
			]
		);
		$repeater->add_control(
			'tab_content_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'content_source' => [ 'page_template' ],
				],
			]
		);

		$repeater->add_control(
			'display_icon',[
				'label'   => esc_html__( 'Show Icon', 'tpebl' ),
				'type'    =>  Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'separator' => 'before',
			]
		);
		$repeater->add_control(
			'display_icon_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'display_icon' => [ 'yes' ],
				],
			]
		);
		$this->add_control(
			'tabs',
			[
				'label' => '',
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'tab_title' => esc_html__( 'Accordion #1', 'tpebl' ),
						'tab_content' => esc_html__( 'I am item content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'tpebl' ),
					],
					[
						'tab_title' => esc_html__( 'Accordion #2', 'tpebl' ),
						'tab_content' => esc_html__( 'I am item content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'tpebl' ),
					],
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'icon_content_section',
			[
				'label' => esc_html__( 'Icon Option', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'display_icon',[
				'label'   => esc_html__( 'Show Icon', 'tpebl' ),
				'type'    =>  Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),	
			]
		);
		$this->add_control(
			'icon_style',
			[
				'label' => esc_html__( 'Icon Font', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'font_awesome',
				'options' => [
					'font_awesome'  => esc_html__( 'Font Awesome', 'tpebl' ),
					'font_awesome_5'  => esc_html__( 'Font Awesome 5', 'tpebl' ),
					'icon_mind' => esc_html__( 'Icons Mind (Pro)', 'tpebl' ),
				],
				'condition' => [
					'display_icon' => 'yes',
				],
			]
		);
		$this->add_control(
			'icon_fontawesome',
			[
				'label' => esc_html__( 'Icon Library', 'tpebl' ),
				'type' => Controls_Manager::ICON,
				'default' => 'fa fa-plus',
				'condition' => [
					'display_icon' => 'yes',
					'icon_style' => 'font_awesome',
				],
			]
		);
		$this->add_control(
			'icon_fontawesome_5',
			[
				'label' => esc_html__( 'Icon Library', 'tpebl' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-plus',
					'library' => 'solid',
				],
				'condition' => [
					'display_icon' => 'yes',
					'icon_style' => 'font_awesome_5',
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
					'display_icon' => 'yes',
					'icon_style' => 'icon_mind',
				],
			]
		);

		$this->add_control(
			'icon_fontawesome_active',
			[
				'label' => esc_html__( 'Active Icon Library', 'tpebl' ),
				'type' => Controls_Manager::ICON,
				'default' => 'fa fa-minus',
				'condition' => [
					'display_icon' => 'yes',
					'icon_style' => 'font_awesome',
				],
			]
		);
		$this->add_control(
			'icon_fontawesome_active_5',
			[
				'label' => esc_html__( 'Icon Library', 'tpebl' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-plus',
					'library' => 'solid',
				],
				'condition' => [
					'display_icon' => 'yes',
					'icon_style' => 'font_awesome_5',
				],
			]
		);
		$this->add_control(
			'title_html_tag',
			[
				'label' => esc_html__( 'Title HTML Tag', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
				],
				'default' => 'div',
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'extra_content_section',
			[
				'label' => esc_html__( 'Extra Option', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'extra_content_section_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'section_toggle_style_icon',
			[
				'label' => esc_html__( 'Icon', 'tpebl' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'display_icon' => 'yes',
				],
			]
		);

		$this->add_control(
			'icon_align',
			[
				'label' => esc_html__( 'Alignment', 'tpebl' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Start', 'tpebl' ),
						'icon' => 'eicon-h-align-left',
					],
					'right' => [
						'title' => esc_html__( 'End', 'tpebl' ),
						'icon' => 'eicon-h-align-right',
					],
				],
				'default' => is_rtl() ? 'right' : 'left',
				'toggle' => false,
				'label_block' => false,
				'condition' => [
					'display_icon' => 'yes',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-accordion .elementor-tab-title .elementor-accordion-icon i:before' => 'color: {{VALUE}};',
				],
				'condition' => [
					'display_icon' => 'yes',
				],
			]
		);

		$this->add_control(
			'icon_active_color',
			[
				'label' => esc_html__( 'Active Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-accordion .elementor-tab-title.active .elementor-accordion-icon i:before' => 'color: {{VALUE}};',
				],
				'condition' => [
					'display_icon' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'icon_space',
			[
				'label' => esc_html__( 'Gap', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-accordion .elementor-accordion-icon.elementor-accordion-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elementor-accordion .elementor-accordion-icon.elementor-accordion-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'display_icon' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'toggle_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .theplus-accordion-wrapper.elementor-accordion .elementor-tab-title .elementor-accordion-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'display_icon' => 'yes',
				],
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title', 'tpebl' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'selector' => '{{WRAPPER}} .theplus-accordion-wrapper .theplus-accordion-item .plus-accordion-header',
			]
		);
		$this->add_control(
			'title_align',
			[
				'label' => esc_html__( 'Title Alignment (Pro Feature)', 'tpebl' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'text-left' => [
						'title' => esc_html__( 'Left', 'tpebl' ),
						'icon' => 'eicon-text-align-left',
					],
					'text-center' => [
						'title' => esc_html__( 'Center', 'tpebl' ),
						'icon' => 'eicon-text-align-center',
					],
					'text-right' => [
						'title' => esc_html__( 'Right', 'tpebl' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'text-left',
				'label_block' => false,
			]
		);
		$this->start_controls_tabs( 'tabs_title_style' );
		$this->start_controls_tab(
			'tab_title_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_control(
			'title_color_option',
			[
				'label' => esc_html__( 'Title Color', 'tpebl' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'solid' => [
						'title' => esc_html__( 'Classic', 'tpebl' ),
						'icon' => 'eicon-paint-brush',
					],
					'gradient' => [
						'title' => esc_html__( 'Gradient', 'tpebl' ),
						'icon' => 'eicon-barcode',
					],
				],
				'label_block' => false,
				'default' => 'solid',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#313131',
				'selectors' => [
					'{{WRAPPER}} .theplus-accordion-wrapper .theplus-accordion-item .plus-accordion-header' => 'color: {{VALUE}}',
				],
				'condition' => [
					'title_color_option' => 'solid',
				],
			]
		);
		$this->add_control(
            'title_gradient_color1',
            [
                'label' => esc_html__('Color 1', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => 'orange',
				'condition' => [
					'title_color_option' => 'gradient',
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
				'condition' => [
					'title_color_option' => 'gradient',
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
				'condition' => [
					'title_color_option' => 'gradient',
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
				'condition' => [
					'title_color_option' => 'gradient',
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
				'condition' => [
					'title_color_option' => 'gradient',
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
					'{{WRAPPER}} .theplus-accordion-wrapper .theplus-accordion-item .plus-accordion-header' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{title_gradient_color1.VALUE}} {{title_gradient_color1_control.SIZE}}{{title_gradient_color1_control.UNIT}}, {{title_gradient_color2.VALUE}} {{title_gradient_color2_control.SIZE}}{{title_gradient_color2_control.UNIT}});-webkit-background-clip: text;-webkit-text-fill-color: transparent;',
				],
				'condition'    => [
					'title_color_option' => 'gradient',
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
					'{{WRAPPER}} .theplus-accordion-wrapper .theplus-accordion-item .plus-accordion-header' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{title_gradient_color1.VALUE}} {{title_gradient_color1_control.SIZE}}{{title_gradient_color1_control.UNIT}}, {{title_gradient_color2.VALUE}} {{title_gradient_color2_control.SIZE}}{{title_gradient_color2_control.UNIT}});-webkit-background-clip: text;-webkit-text-fill-color: transparent;',
				],
				'condition' => [
					'title_color_option' => 'gradient',
					'title_gradient_style' => 'radial',
			],
			'of_type' => 'gradient',
			]
        );
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_title_active',
			[
				'label' => esc_html__( 'Active', 'tpebl' ),
			]
		);
		$this->add_control(
			'title_active_color_option',
			[
				'label' => esc_html__( 'Title Active Color', 'tpebl' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'solid' => [
						'title' => esc_html__( 'Classic', 'tpebl' ),
						'icon' => 'eicon-paint-brush',
					],
					'gradient' => [
						'title' => esc_html__( 'Gradient', 'tpebl' ),
						'icon' => 'eicon-barcode',
					],
				],
				'label_block' => false,
				'default' => 'solid',
			]
		);
		$this->add_control(
			'title_active_color',
			[
				'label' => esc_html__( 'Active Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3351a6',
				'selectors' => [
					'{{WRAPPER}} .theplus-accordion-wrapper .theplus-accordion-item .plus-accordion-header.active' => 'color: {{VALUE}}',
				],
				'condition' => [
					'title_active_color_option' => 'solid',
				],
			]
		);
		$this->add_control(
            'title_active_gradient_color1',
            [
                'label' => esc_html__('Color 1', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => 'orange',
				'condition' => [
					'title_active_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_active_gradient_color1_control',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Color 1 Location', 'tpebl'),
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
					'size' => 0,
				],
				'render_type' => 'ui',
				'condition' => [
					'title_active_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_active_gradient_color2',
            [
                'label' => esc_html__('Color 2', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => 'cyan',
				'condition' => [
					'title_active_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_active_gradient_color2_control',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Color 2 Location', 'tpebl'),
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
					'size' => 100,
					],
				'render_type' => 'ui',
				'condition' => [
					'title_active_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_active_gradient_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Gradient Style', 'tpebl'),
                'default' => 'linear',
                'options' => l_theplus_get_gradient_styles(),
				'condition' => [
					'title_active_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_active_gradient_angle', [
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
					'{{WRAPPER}} .theplus-accordion-wrapper .theplus-accordion-item .plus-accordion-header.active' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{title_active_gradient_color1.VALUE}} {{title_active_gradient_color1_control.SIZE}}{{title_active_gradient_color1_control.UNIT}}, {{title_active_gradient_color2.VALUE}} {{title_active_gradient_color2_control.SIZE}}{{title_active_gradient_color2_control.UNIT}});-webkit-background-clip: text;-webkit-text-fill-color: transparent;',
				],
				'condition'    => [
					'title_active_color_option' => 'gradient',
					'title_active_gradient_style' => ['linear']
				],
				'of_type' => 'gradient',
			]
        );
		$this->add_control(
            'title_active_gradient_position', [
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Position', 'tpebl'),
				'options' => l_theplus_get_position_options(),
				'default' => 'center center',
				'selectors' => [
					'{{WRAPPER}} .theplus-accordion-wrapper .theplus-accordion-item .plus-accordion-header.active' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{title_active_gradient_color1.VALUE}} {{title_active_gradient_color1_control.SIZE}}{{title_active_gradient_color1_control.UNIT}}, {{title_active_gradient_color2.VALUE}} {{title_active_gradient_color2_control.SIZE}}{{title_active_gradient_color2_control.UNIT}});-webkit-background-clip: text;-webkit-text-fill-color: transparent;',
				],
				'condition' => [
					'title_active_color_option' => 'gradient',
					'title_active_gradient_style' => 'radial',
			],
			'of_type' => 'gradient',
			]
        );
		$this->end_controls_tab();
		$this->end_controls_tabs();		
		$this->end_controls_section();
		/*title style*/
		/*Title style*/
		$this->start_controls_section(
            'section_accordion_styling',
            [
                'label' => esc_html__('Title Background', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
			]
        );
		$this->start_controls_tabs( 'tabs_background_style' );
		$this->start_controls_tab(
			'tab_background_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'box_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .theplus-accordion-wrapper .theplus-accordion-item .plus-accordion-header',
				
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_background_active',
			[
				'label' => esc_html__( 'Active', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'box_active_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .theplus-accordion-wrapper .theplus-accordion-item .plus-accordion-header.active',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();		
		$this->end_controls_section();
		/*Title style*/
		/*desc style*/
		$this->start_controls_section(
            'section_desc_styling',
            [
                'label' => esc_html__('Content', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
			]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typography',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'selector' => '{{WRAPPER}} .theplus-accordion-wrapper .theplus-accordion-item .plus-accordion-content .plus-content-editor',
			]
		);
		$this->add_control(
			'desc_color',
			[
				'label' => esc_html__( 'Text Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-accordion-wrapper .theplus-accordion-item .plus-accordion-content .plus-content-editor,{{WRAPPER}} .theplus-accordion-wrapper .theplus-accordion-item .plus-accordion-content .plus-content-editor p' => 'color: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
            'section_content_bg_styling',
            [
                'label' => esc_html__('Content Background', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
			]
        );
		$this->add_control(
			'content_background_options',
			[
				'label' => esc_html__( 'Background Options', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'content_box_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .theplus-accordion-wrapper .theplus-accordion-item .plus-accordion-content',
				'separator' => 'after',
				
			]
		);
		$this->end_controls_section();
		/*desc style*/
		
		/*Hover Animation style*/
		$this->start_controls_section(
            'section_hover_styling',
            [
                'label' => esc_html__('Hover Style', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
			]
        );
		$this->add_control(
			'section_hover_styling_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
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
		$templates = L_Theplus_Element_Load::elementor()->templates_manager->get_source( 'local' )->get_items();
		
		$id_int = substr( $this->get_id_int(), 0, 3 );
		$uid=uniqid("accordion");
				
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
		
		
		?>
		<div class="theplus-accordion-wrapper elementor-accordion <?php echo esc_attr($animated_class); ?>" id="<?php echo esc_attr($uid); ?>" data-accordion-id="<?php echo esc_attr($uid); ?>" data-accordion-type="accordion" data-toogle-speed="300" <?php echo $animation_attr; ?>  role="tablist">
			<?php
			foreach ( $settings['tabs'] as $index => $item ) :
				$tab_count = $index + 1;
				if(1==$tab_count){
					$active_default='active-default';
				}else{
					$active_default='no';
				}
				
				$tab_title_id = 'elementor-tab-title-' . $id_int . $tab_count;
				$tab_content_id = 'elementor-tab-content-' . $id_int . $tab_count;
				
				$tab_title_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );

				$tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'tabs', $index );

				$this->add_render_attribute( $tab_title_setting_key, [
					'id' => $tab_title_id,
					'class' => [ 'elementor-tab-title', 'plus-accordion-header', $active_default ],
					'tabindex' => $id_int . $tab_count,
					'data-tab' => $tab_count,
					'role' => 'tab',
					'aria-controls' => $tab_content_id,
				] );

				$this->add_render_attribute( $tab_content_setting_key, [
					'id' => $tab_content_id,
					'class' => [ 'elementor-tab-content', 'elementor-clearfix', 'plus-accordion-content', $active_default],
					'data-tab' => $tab_count,
					'role' => 'tabpanel',
					'aria-labelledby' => $tab_title_id,
				] );

				$this->add_inline_editing_attributes( $tab_content_setting_key, 'advanced' );
				
				$accordion_toggle_icon='';
				?>
				<div class="theplus-accordion-item">
					<<?php echo l_theplus_validate_html_tag($settings['title_html_tag']); ?> <?php echo $this->get_render_attribute_string( $tab_title_setting_key ); ?>>
						<?php if ( $settings['display_icon']=='yes' ) : ?>
							<?php 
								if($settings['icon_style']=='font_awesome'){
									$icons=$settings['icon_fontawesome'];
									$icons_active=$settings['icon_fontawesome_active'];
								}else if($settings['icon_style']=='font_awesome_5'){
									ob_start();
									\Elementor\Icons_Manager::render_icon( $settings['icon_fontawesome_5'], [ 'aria-hidden' => 'true' ]);
									$icons = ob_get_contents();
									ob_end_clean();
									
									ob_start();
									\Elementor\Icons_Manager::render_icon( $settings['icon_fontawesome_active_5'], [ 'aria-hidden' => 'true' ]);
									$icons_active = ob_get_contents();
									ob_end_clean();
								}else{
									$icons=$icons_active='';
								}
							?>
							<?php if(!empty($icons) && !empty($icons_active)){ 
								$accordion_toggle_icon='<span class="elementor-accordion-icon elementor-accordion-icon-'.esc_attr( $settings['icon_align'] ).'" aria-hidden="true">';
									if(!empty($settings['icon_style']) && $settings['icon_style']=='font_awesome_5'){
										$accordion_toggle_icon .='<span class="elementor-accordion-icon-closed">'.$icons.'</span>';
										$accordion_toggle_icon .='<span class="elementor-accordion-icon-opened">'.$icons_active.'</span>';
									}else{
										$accordion_toggle_icon .='<i class="elementor-accordion-icon-closed '.esc_attr( $icons ).'"></i>';
									$accordion_toggle_icon .='<i class="elementor-accordion-icon-opened '.esc_attr( $icons_active ).'"></i>';
									}									
								$accordion_toggle_icon .='</span>';
							} ?>
						<?php endif; ?>
						<?php if(!empty($settings['icon_align']) && $settings['icon_align']=='left'){
							echo $accordion_toggle_icon;
						} 

						echo '<span style="width:100%">'.$item['tab_title'].'</span>'; ?>
						<?php if(!empty($settings['icon_align']) && $settings['icon_align']=='right'){
							echo $accordion_toggle_icon;
						} ?>
					</<?php echo l_theplus_validate_html_tag($settings['title_html_tag']); ?>>
					
					<?php if(($item['content_source']=='content' && !empty($item['tab_content']))){ ?>
						<div <?php echo $this->get_render_attribute_string( $tab_content_setting_key ); ?>>
							<?php if($item['content_source']=='content' && !empty($item['tab_content'])){
								echo '<div class="plus-content-editor">'.$this->parse_text_editor( $item['tab_content'] ).'</div>';
							}
							?>						
						</div>
					<?php } ?>
					
				</div>
				
			<?php endforeach; ?>
		</div>
		<?php
	}

	protected function content_template() {
	
	}
}
