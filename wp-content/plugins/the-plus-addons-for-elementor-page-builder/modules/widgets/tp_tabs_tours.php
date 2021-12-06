<?php 
/*
Widget Name: Tabs And Tours
Description: Toggle of a tabs and tours content.
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
use Elementor\Group_Control_Image_Size;
use TheplusAddons\L_Theplus_Element_Load;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class L_ThePlus_Tabs_Tours extends Widget_Base {
		
	public function get_name() {
		return 'tp-tabs-tours';
	}

    public function get_title() {
        return esc_html__('Tabs/Tours', 'tpebl');
    }

    public function get_icon() {
        return 'fa fa-th-list theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-tabbed');
    }
	public function get_keywords() {
		return ['tabs', 'tours', 'tabbed content'];
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
				'default' => esc_html__( 'Tab Title' , 'tpebl' ),
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
				'default' => esc_html__( 'Content', 'tpebl' ),
				'show_label' => false,
				'dynamic' => ['active'   => true,],
				'condition'    => [
					'content_source' => [ 'content' ],
				],
			]
		);
		$repeater->add_control(
			'content_template_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'   => ['content_source' => "page_template"],
			]
		);		
		$repeater->add_control(
			'display_icon',[
				'label'   => esc_html__( 'Show Inner Icon', 'tpebl' ),
				'type'    =>  Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),	
				'separator' => 'before',
				'condition'    => [
					'content_source' => [ 'content' ],
				],
			]
		);
		$repeater->add_control(
			'icon_style',
			[
				'label' => esc_html__( 'Icon Font', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'font_awesome',
				'options' => [
					'font_awesome'  => esc_html__( 'Font Awesome', 'tpebl' ),
					'icon_mind' => esc_html__( 'Icons Mind (Pro)', 'tpebl' ),
					'image' => esc_html__( 'Image (Pro)', 'tpebl' ),
				],
				'condition' => [
					'content_source' => [ 'content' ],
					'display_icon' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'icon_fontawesome',
			[
				'label' => esc_html__( 'Icon Library', 'tpebl' ),
				'type' => Controls_Manager::ICON,
				'default' => 'fa fa-plus',
				'separator' => 'before',
				'condition' => [
					'content_source' => [ 'content' ],
					'display_icon' => 'yes',
					'icon_style' => 'font_awesome',
				],
			]
		);
		$repeater->add_control(
			'icons_mind_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'content_source' => [ 'content' ],
					'display_icon' => 'yes',
					'icon_style' => ['icon_mind','image'],
				],
			]
		);		
		$repeater->add_control(
			'display_icon1',[
				'label'   => esc_html__( 'Show Outer Icon', 'tpebl' ),
				'type'    =>  Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),	
				'separator' => 'before',
				'condition'    => [
					'content_source' => [ 'content' ],
				],
			]
		);
		$repeater->add_control(
			'display_icon1_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'content_source' => [ 'content' ],
					'display_icon1' => [ 'yes' ],
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
						'tab_title' => esc_html__( 'Tab #1', 'tpebl' ),
						'tab_content' => esc_html__( 'I am item content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'tpebl' ),
					],
					[
						'tab_title' => esc_html__( 'Tab #2', 'tpebl' ),
						'tab_content' => esc_html__( 'I am item content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'tpebl' ),
					],
				],
				'title_field' => '{{{ tab_title }}}',
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'layout_content_section',
			[
				'label' => esc_html__( 'Layout', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'tabs_type',
			[
				'label' => esc_html__( 'Layout', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' => esc_html__( 'Horizontal', 'tpebl' ),
					'vertical' => esc_html__( 'Vertical', 'tpebl' ),
				],
				'prefix_class' => 'elementor-tabs-view-',
				
			]
		);
		$this->add_control(
			'tabs_align_horizontal',
			[
				'label' => esc_html__( 'Navigation Position', 'tpebl' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'tpebl' ),
						'icon' => 'fa fa-level-up',
					],					
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'tpebl' ),
						'icon' => 'fa fa-level-down',
					],
				],
				'default' => 'top',
				'label_block' => false,
				'separator' => 'after',
				'condition'    => [
					'tabs_type' => [ 'horizontal' ],
				],
			]
		);
		$this->add_control(
			'tabs_align_vertical',
			[
				'label' => esc_html__( 'Navigation Position', 'tpebl' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'tpebl' ),
						'icon' => 'eicon-text-align-left',
					],					
					'right' => [
						'title' => esc_html__( 'Right', 'tpebl' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
				'label_block' => false,
				'separator' => 'after',
				'condition'    => [
					'tabs_type' => [ 'vertical' ],
				],
			]
		);
		$this->add_control(
			'tabs_swiper',[
				'label'   => esc_html__( 'Swiper Effect', 'tpebl' ),
				'type'    =>  Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__( 'On', 'tpebl' ),
				'label_off' => esc_html__( 'Off', 'tpebl' ),
				'separator' => 'before',
				'condition'    => [
					'tabs_type' => [ 'horizontal' ],
				],
			]
		);
		$this->add_control(
			'tabs_swiper_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'tabs_type' => [ 'horizontal' ],
					'tabs_swiper' => [ 'yes' ],
				],
			]
		);
		$this->add_control(
			'on_hover_tabs',[
				'label'   => esc_html__( 'On Hover Tab', 'tpebl' ),
				'type'    =>  Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'separator' => 'before',
			]
		);
		$this->add_control(
			'on_hover_tabs_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'on_hover_tabs' => [ 'yes' ],
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_toggle_style_icon',
			[
				'label' => esc_html__( 'Icon', 'tpebl' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
            'icon_size',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Size', 'tpebl'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header .tab-icon-wrap,{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title .tab-icon-wrap' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header .tab-icon-image' => 'max-width: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header .tab-icon-wrap,{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title .tab-icon-wrap' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_active_color',
			[
				'label' => esc_html__( 'Active Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header:hover .tab-icon-wrap,{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header.active .tab-icon-wrap,{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title.active .tab-icon-wrap' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_space',
			[
				'label' => esc_html__( 'Spacing', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav:not(.full-width-icon) .plus-tab-header .tab-icon-wrap,{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title .tab-icon-wrap' => 'padding-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .theplus-tabs-wrapper ul.plus-tabs-nav.full-width-icon .plus-tab-header .tab-icon-wrap' => 'padding-right: 0;padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'full_icon',[
				'label'   => esc_html__( 'Full Width Icon', 'tpebl' ),
				'type'    =>  Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),	
				'separator' => 'before',
			]
		);
		$this->add_control(
			'full_icon_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'full_icon' => [ 'yes' ],
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'section_toggle_style_icon_outer',
			[
				'label' => esc_html__( 'Outer Icon', 'tpebl' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'section_toggle_style_icon_outer_options',
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
			'section_title_style',
			[
				'label' => esc_html__( 'Tab Title Bar', 'tpebl' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'nav_vertical_width',
			[
				'label' => esc_html__( 'Navigation Width', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' , 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 600,
						'step' => 2,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 25,
				],
				'selectors'  => [
					'{{WRAPPER}}.elementor-tabs-view-vertical .theplus-tabs-nav-wrapper' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'tabs_type' => 'vertical',
				],
				
			]
		);
		$this->add_control(
			'nav_vertical_align',
			[
				'label' => esc_html__( 'Vertical Alignment', 'tpebl' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'align-top' => [
						'title' => esc_html__( 'Top', 'tpebl' ),
						'icon' => 'fa fa-arrow-up',
					],
					'align-center' => [
						'title' => esc_html__( 'Center', 'tpebl' ),
						'icon' => 'eicon-text-align-center',
					],
					'align-bottom' => [
						'title' => esc_html__( 'Bottom', 'tpebl' ),
						'icon' => 'fa fa-arrow-down',
					],
				],
				'default' => 'align-top',
				'label_block' => false,
				'separator' => 'after',
				'condition' => [
					'tabs_type' => 'vertical',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'selector' => '{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header,{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title',
			]
		);
		$this->add_control(
			'nav_align',
			[
				'label' => esc_html__( 'Nav Alignment', 'tpebl' ),
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
		$this->add_control(
			'nav_full_width',
			[
				'label' => esc_html__( 'Nav Full-Width', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'tpebl' ),
				'label_off' => esc_html__( 'No', 'tpebl' ),
				'default' => 'no',
			]
		);
		$this->add_control(
			'nav_full_width_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'nav_full_width' => [ 'yes' ],
				],
			]
		);
		$this->add_control(
			'nav_title_display',
			[
				'label' => esc_html__( 'Title On/Off', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'tpebl' ),
				'label_off' => esc_html__( 'Off', 'tpebl' ),
				'default' => 'yes',
				'separator' => 'after',
			]
		);
		$this->add_control(
			'nav_same_width',
			[
				'label' => esc_html__( 'Nav Equal Width', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'tpebl' ),
				'label_off' => esc_html__( 'No', 'tpebl' ),
				'default' => 'no',
			]
		);
		$this->add_control(
			'nav_same_width_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'nav_same_width' => [ 'yes' ],
				],
			]
		);
		$this->add_control(
			'nav_color_options',
			[
				'label' => esc_html__( 'Title Color Options', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
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
						'icon' => 'fa fa-barcode',
					],
				],
				'default' => 'solid',
				'label_block' => false,
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#313131',
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header,{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header span:not(.tab-icon-wrap),{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title span:not(.tab-icon-wrap)' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{title_gradient_color1.VALUE}} {{title_gradient_color1_control.SIZE}}{{title_gradient_color1_control.UNIT}}, {{title_gradient_color2.VALUE}} {{title_gradient_color2_control.SIZE}}{{title_gradient_color2_control.UNIT}});-webkit-background-clip: text;-webkit-text-fill-color: transparent;',
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
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header span:not(.tab-icon-wrap),{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title span:not(.tab-icon-wrap)' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{title_gradient_color1.VALUE}} {{title_gradient_color1_control.SIZE}}{{title_gradient_color1_control.UNIT}}, {{title_gradient_color2.VALUE}} {{title_gradient_color2_control.SIZE}}{{title_gradient_color2_control.UNIT}});-webkit-background-clip: text;-webkit-text-fill-color: transparent;',
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
						'icon' => 'fa fa-barcode',
					],
				],
				'default' => 'solid',
				'label_block' => false,
			]
		);
		$this->add_control(
			'title_active_color',
			[
				'label' => esc_html__( 'Active Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3351a6',
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header:hover,{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header.active,{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title.active' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header:hover span:not(.tab-icon-wrap),{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header.active span:not(.tab-icon-wrap),{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title.active span:not(.tab-icon-wrap)' => 'background-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{title_active_gradient_color1.VALUE}} {{title_active_gradient_color1_control.SIZE}}{{title_active_gradient_color1_control.UNIT}}, {{title_active_gradient_color2.VALUE}} {{title_active_gradient_color2_control.SIZE}}{{title_active_gradient_color2_control.UNIT}});-webkit-background-clip: text;-webkit-text-fill-color: transparent;',
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
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header:hover span:not(.tab-icon-wrap),{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header.active span:not(.tab-icon-wrap),{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title.active span:not(.tab-icon-wrap)' => 'background-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{title_active_gradient_color1.VALUE}} {{title_active_gradient_color1_control.SIZE}}{{title_active_gradient_color1_control.UNIT}}, {{title_active_gradient_color2.VALUE}} {{title_active_gradient_color2_control.SIZE}}{{title_active_gradient_color2_control.UNIT}});-webkit-background-clip: text;-webkit-text-fill-color: transparent;',
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
		//start underline
		$this->start_controls_section(
			'section_tab_underline',
			[
				'label' => esc_html__( 'Under Line', 'tpebl' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'tab_title_underline_display',
			[
				'label' => esc_html__( 'Underline', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'no',
			]
		);
		$this->add_control(
			'tab_title_underline_display_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'tab_title_underline_display' => [ 'yes' ],
				],
			]
		);
		$this->end_controls_section();
		//end underline
		$this->start_controls_section(
			'section_title_bg_style',
			[
				'label' => esc_html__( 'Tab Title Bar Background', 'tpebl' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'nav_inner_margin',
			[
				'label' => esc_html__( 'Nav Inner Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header,{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'nav_inner_padding',
			[
				'label' => esc_html__( 'Nav Inner Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header,{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'nav_title_space',
			[
				'label' => esc_html__( 'Navigation Between Space', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors'  => [
					'{{WRAPPER}}.elementor-tabs-view-horizontal .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header' => 'margin-left: {{SIZE}}{{UNIT}};margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.elementor-tabs-view-horizontal .theplus-tabs-wrapper .plus-tabs-nav li:first-child .plus-tab-header' => 'margin-left:0;',
					'{{WRAPPER}}.elementor-tabs-view-horizontal .theplus-tabs-wrapper .plus-tabs-nav li:last-child .plus-tab-header' => 'margin-right:0;',
					'{{WRAPPER}}.elementor-tabs-view-vertical .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header' => 'margin-top: {{SIZE}}{{UNIT}};margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.elementor-tabs-view-vertical .theplus-tabs-wrapper .plus-tabs-nav li:first-child .plus-tab-header' => 'margin-top:0;',
					'{{WRAPPER}}.elementor-tabs-view-vertical .theplus-tabs-wrapper .plus-tabs-nav li:last-child .plus-tab-header' => 'margin-bottom:0;',
					
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'nav_box_border',
			[
				'label' => esc_html__( 'Box Border', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'no',
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'nav_border_style',
			[
				'label' => esc_html__( 'Border Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => l_theplus_get_border_style(),
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header' => 'border-style: {{VALUE}};',
				],
				'condition' => [
					'nav_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'nav_border_width',
			[
				'label' => esc_html__( 'Border Width', 'tpebl' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top'    => 1,
					'right'  => 1,
					'bottom' => 1,
					'left'   => 1,
				],
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'nav_box_border' => 'yes',
				],
			]
		);
		$this->start_controls_tabs( 'nav_box_border_style' );
		$this->start_controls_tab(
			'nav_border_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
				'condition' => [
					'nav_box_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'nav_border_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'nav_box_border' => 'yes',
				],
			]
		);
		
		$this->add_responsive_control(
			'nav_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'nav_box_border' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'nav_border_active',
			[
				'label' => esc_html__( 'Active', 'tpebl' ),
				'condition' => [
					'nav_box_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'nav_border_active_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header:hover,{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header.active' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'nav_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'nav_border_active_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header:hover,{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header.active' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'nav_box_border' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->start_controls_tabs( 'nav_background_style' );
		$this->start_controls_tab(
			'nav_background_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'nav_box_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header',
				
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'nav_background_active',
			[
				'label' => esc_html__( 'Active', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'nav_box_active_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header:hover,{{WRAPPER}} .theplus-tabs-wrapper .plus-tabs-nav .plus-tab-header.active',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();		
		$this->end_controls_section();
		/*title bg style*/
		/*Tab Nav background style*/
		$this->start_controls_section(
            'section_nav_bg_styling',
            [
                'label' => esc_html__('Navigation Area Background', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
			]
        );
		$this->add_control(
			'section_nav_bg_styling_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
			]
		);
		$this->end_controls_section();
		/*tab Nav background style*/
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
				'selector' => '{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-content-wrapper .plus-tab-content .plus-content-editor',
			]
		);
		$this->add_control(
			'desc_color',
			[
				'label' => esc_html__( 'Desc Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-content-wrapper .plus-tab-content .plus-content-editor,{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-content-wrapper .plus-tab-content .plus-content-editor p' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		/*desc style*/
		$this->start_controls_section(
		'section_desc_bg_styling',
            [
                'label' => esc_html__('Content Background', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
			]
        );
		$this->add_responsive_control(
			'content_tab_margin',
			[
				'label' => esc_html__( 'Content Margin Space', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-content-wrapper,{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion.mobile-accordion-tab .theplus-tabs-content-wrapper .plus-tab-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'content_tab_padding',
			[
				'label' => esc_html__( 'Content Inner Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-content-wrapper,{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion.mobile-accordion-tab .theplus-tabs-content-wrapper .plus-tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'content_background_options',
			[
				'label' => esc_html__( 'Background Options', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'content_box_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .theplus-tabs-wrapper .theplus-tabs-content-wrapper',
				
			]
		);		
		$this->end_controls_section();		
		/* Extra option */
		$this->start_controls_section(
            'section_extra_options',
            [
                'label' => esc_html__('Extra Options', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
			]
        );
		$this->add_control(
			'section_extra_pro_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
			]
		);
		$this->add_control(
			'tab_nav_responsive',
			[
				'label'   => esc_html__( 'Tab Navigation Responsive', 'tpebl' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''  => esc_html__( 'None', 'tpebl' ),
					'nav_full' => esc_html__( 'Full Width (PRO) ', 'tpebl' ),
					'nav_one' => esc_html__( 'One By One (PRO)', 'tpebl' ),
					'tab_accordion' => esc_html__( 'Force Accordion', 'tpebl' ),
				],
				'separator' => 'before',
				'description' => esc_html__('These options are for making your tabs look different in small devices. You can select none, If you want to keep your settings.','tpebl'),
			]
		);
		$this->add_control(
			'tab_nav_responsive_pro_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition' => [
					'tab_nav_responsive!' => 'tab_accordion',
				],
			]
		);
		$this->add_control(
			'tab_accordion_options',
			[
				'label' => esc_html__( 'Accordion Navigation Options', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'tab_nav_responsive' => 'tab_accordion',
				],
			]
		);		
		$this->start_controls_tabs( 'accordion_background_style' );
		$this->start_controls_tab(
			'accordion_background_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
				'condition' => [
					'tab_nav_responsive' => 'tab_accordion',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'accordion_box_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title',
				'condition' => [
					'tab_nav_responsive' => 'tab_accordion',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'accordion_background_active',
			[
				'label' => esc_html__( 'Active', 'tpebl' ),
				'condition' => [
					'tab_nav_responsive' => 'tab_accordion',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'accordion_box_active_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .theplus-tabs-wrapper.mobile-accordion .elementor-tab-mobile-title.active',
				'condition' => [
					'tab_nav_responsive' => 'tab_accordion',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();		
		$this->end_controls_section();
		/* Extra option */
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
	
    protected function render() {
		$settings = $this->get_settings_for_display();
		$templates = L_Theplus_Element_Load::elementor()->templates_manager->get_source( 'local' )->get_items();
		
		$tabs = $this->get_settings_for_display( 'tabs' );
		$nav_align=$settings["nav_align"];
		$id_int = substr( $this->get_id_int(), 0, 3 );		
		$nav_vertical_align = $settings['nav_vertical_align'];
		$uid=uniqid("tabs");
		
				
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
		
			$tab_nav ='<div class="theplus-tabs-nav-wrapper elementor-tabs-wrapper '.esc_attr($nav_align).' '.esc_attr($nav_vertical_align).' ">';
				$tab_nav .='<ul class="plus-tabs-nav">';
				foreach ( $tabs as $index => $item ) :
					$tab_count = $index + 1;					
					
					$tab_title_id = 'elementor-tab-title-' . $id_int . $tab_count;
					$tab_content_id = 'elementor-tab-content-' . $id_int . $tab_count;
					
					$tab_title_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );
					$tabh_bg = tp_bg_lazyLoad($settings['nav_box_background_image'],$settings['nav_box_active_background_image']);
					$this->add_render_attribute( $tab_title_setting_key, [
						'id' => $tab_title_id,
						'class' => [ 'elementor-tab-title' , 'elementor-tab-desktop-title' , 'plus-tab-header'.$tabh_bg],
						'data-tab' => $tab_count,
						'tabindex' => $id_int . $tab_count,
						'role' => 'tab',
						'aria-controls' => $tab_content_id,
					] );
					
					$tab_nav .='<li>';
					$tab_nav .='<div '.$this->get_render_attribute_string( $tab_title_setting_key ).'>';
					$image_alt='';
						if ( $item['display_icon']=='yes' ) :
							$icons=$icon_image='';
							if($item['icon_style']=='font_awesome'){
								$icons=$item['icon_fontawesome'];									
							}
							if(!empty($icons) || !empty($icon_image)){
							$tab_nav .='<span class="tab-icon-wrap" aria-hidden="true">';
								if($item['icon_style']!='image'){
									$tab_nav .='<i class="tab-icon '.esc_attr( $icons ).'"></i>';
								}else{
									$tab_nav .='<img src="'.esc_url($icon_image).'" class="tab-icon tab-icon-image" alt="'.esc_attr($image_alt).'" />';
								}
								$tab_nav .='</span>';
							}
						endif;
						if($settings["nav_title_display"]=='yes'){
							$tab_nav .='<span>'.$item['tab_title'].'</span>';
						}
					$tab_nav .='</div>';
					
					$tab_nav .='</li>';
				endforeach;
				$tab_nav .='</ul>';
			$tab_nav .='</div>';
			$tabccon_bg = tp_bg_lazyLoad($settings['content_box_background_image']);
			$tab_content ='<div class="theplus-tabs-content-wrapper elementor-tabs-content-wrapper '.$tabccon_bg.'">';
				foreach ( $tabs as $index => $item ) :
					$tab_count = $index + 1;
					
					$tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'tabs', $index );

					$tab_title_mobile_setting_key = $this->get_repeater_setting_key( 'tab_title_mobile', 'tabs', $tab_count );
					
					$this->add_render_attribute( $tab_content_setting_key, [
						'id' => $tab_content_id,
						'class' => [ 'elementor-tab-content', 'elementor-clearfix','plus-tab-content'],
						'data-tab' => $tab_count,
						'role' => 'tabpanel',
						'aria-labelledby' => $tab_title_id,
					] );
					$acmob_bg = tp_bg_lazyLoad($settings['accordion_box_background_image'],$settings['accordion_box_active_background_image']);
					$this->add_render_attribute( $tab_title_mobile_setting_key, [
						'class' => [ 'elementor-tab-title', 'elementor-tab-mobile-title',$acmob_bg,$nav_align ],
						'tabindex' => $id_int . $tab_count,
						'data-tab' => $tab_count,
						'role' => 'tab',
					] );

					$this->add_inline_editing_attributes( $tab_content_setting_key, 'advanced' );
					
					$tab_content .='<div '.$this->get_render_attribute_string( $tab_title_mobile_setting_key ).'>';
					$image_alt='';
						if ( $item['display_icon']=='yes' ) :
							$icons=$icon_image='';
							if($item['icon_style']=='font_awesome'){
								$icons=$item['icon_fontawesome'];									
							}
							if(!empty($icons) || !empty($icon_image)){
								$tab_content .='<span class="tab-icon-wrap" aria-hidden="true">';
									if($item['icon_style']!='image'){
										$tab_content .='<i class="tab-icon '.esc_attr( $icons ).'"></i>';
									}else{
										$tab_content .='<img src="'.esc_url($icon_image).'" class="tab-icon tab-icon-image" alt="'.esc_attr($image_alt).'" />';
									}
								$tab_content .='</span>';
							}
						endif;
						$tab_content .='<span>'.$item['tab_title'].'</span>';
					$tab_content .='</div>';
					$tab_content .='<div '.$this->get_render_attribute_string( $tab_content_setting_key ).'>';
						if($item['content_source']=='content' && !empty($item['tab_content'])){
							$tab_content .='<div class="plus-content-editor">'.$this->parse_text_editor( $item['tab_content'] ).'</div>';
						}						
					$tab_content .='</div>';
				endforeach;
			$tab_content .='</div>';
		
		$default_active='';
		$default_active .= ' data-tab-default="0"';		
		$default_active .= ' data-tab-hover="no"';
		
		$responsive_class='';
		if($settings["tab_nav_responsive"]=='tab_accordion'){
			$responsive_class='mobile-accordion';
		}
		
		$output ='<div class="theplus-tabs-wrapper elementor-tabs '.esc_attr($animated_class).' '.esc_attr($responsive_class).'" id="'.esc_attr($uid).'" data-tabs-id="'.esc_attr($uid).'"  '.$default_active.' '.$animation_attr.' role="tablist">';
			if($settings["tabs_type"]=='horizontal'){
				if($settings['tabs_align_horizontal']=='top'){
					$output .= $tab_nav.$tab_content;
				}
				if($settings['tabs_align_horizontal']=='bottom'){
					$output .= $tab_content.$tab_nav;
				}
			}
			if($settings["tabs_type"]=='vertical'){
				if($settings['tabs_align_vertical']=='left'){
					$output .= $tab_nav.$tab_content;
				}
				if($settings['tabs_align_vertical']=='right'){
					$output .= $tab_content.$tab_nav;
				}
			}
		$output .='</div>';
		echo $output;
	}

	protected function content_template() {
	
	}
}
