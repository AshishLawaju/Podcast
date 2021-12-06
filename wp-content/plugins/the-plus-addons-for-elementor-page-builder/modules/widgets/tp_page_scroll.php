<?php 
/*
Widget Name: Page Scroll
Description: Page Scroll
Author: Theplus
Author URI: https://posimyth.com
*/
namespace TheplusAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Core\Responsive\Responsive;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Core\Schemes\Typography;

use TheplusAddons\L_Theplus_Element_Load;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class L_ThePlus_Page_Scroll extends Widget_Base {
		
	
	public function get_name() {
		return 'tp-page-scroll';
	}

    public function get_title() {
        return esc_html__('Page Scroll', 'tpebl');
    }

    public function get_icon() {
        return 'fa fa-rocket theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-creatives');
    }
	public function get_keywords() {
		return ['one page scroll', 'full page js', 'page piling', 'page pilling', 'multi scroll', 'page scroll', 'scroll'];
	}
    protected function _register_controls() {
		$this->start_controls_section(
			'section_page_scroll',
			[
				'label' => esc_html__( 'Page Scroll', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'page_scroll_opt',
			[
				'label' => esc_html__( 'Option', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'tp_full_page',
				'options' => [
					'tp_full_page'  => esc_html__( 'Full Page', 'tpebl' ),
					'tp_page_pilling'  => esc_html__( 'Page Piling (Pro)', 'tpebl' ),					
					'tp_multi_scroll'  => esc_html__( 'Multi Scroll (Pro)', 'tpebl' ),
					'tp_horizontal_scroll'  => esc_html__( 'Horizontal Scroll (Pro)', 'tpebl' ),
				],
			]
		);
		$this->end_controls_section();
		
		/*full page & page pilling content start*/
		$this->start_controls_section(
			'full_pagepilling_content_templates',
			[
				'label' => esc_html__( 'Content', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition'		=> [
					'page_scroll_opt' => ['tp_full_page'],
				],
			]
		);
		$this->add_control(
			'fit_screen_note',
			[
				'label' => esc_html__( 'Make sure your templates have full width On and It will suitable to screen height.', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::HEADING,				
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->add_control(
			'fp_content_template',
			[
				'label'       => esc_html__( 'Elementor Templates', 'tpebl' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => '0',
				'options'     => l_theplus_get_templates(),
				'label_block' => 'true',
			]
		);
		$repeater->add_control(
			'fp-slideid',
			[
				'label' => esc_html__( 'Slide Id', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],				
				'placeholder' => esc_html__( 'slideid', 'tpebl' ),
			]
		);
		$this->add_control(
			'fp_content',
			[
				'label' => '',
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
			]
		);
		$this->end_controls_section();
		/*full page & page pilling content end*/
		/*Horizontal Scroll content end*/
		$this->start_controls_section(
			'hscroll_content_template',
			[
				'label' => esc_html__( 'Content', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition'		=> [
					'page_scroll_opt' => 'tp_horizontal_scroll',
				],
			]
		);
		$this->add_control(
			'hscroll_content_template_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
			]
		);
		$this->end_controls_section();
		/*Horizontal Scroll content end*/
		$this->start_controls_section(
            'settings_section',
            [
                'label' => esc_html__('Extra Options', 'tpebl'),
                'tab' => Controls_Manager::TAB_CONTENT,
				'condition'		=> [
					'page_scroll_opt' => 'tp_horizontal_scroll',
				],
            ]
        );
		$this->add_control(
			'settings_section_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
			]
		);
        $this->end_controls_section();
		/*multi scroll content start*/
		$this->start_controls_section(
			'multi_scroll_content_templates',
			[
				'label' => esc_html__( 'Multi Scroll Content', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition'		=> [
					'page_scroll_opt' => 'tp_multi_scroll',
				],
			]
		);
		$this->add_control(
			'template_full_height_text',
		  	[
                'label'         => esc_html__( 'Make sure your templates have full width On and It will suitable to screen height.', 'tpebl' ),
		     	'type'          => Controls_Manager::RAW_HTML,		     	
		  	]
		);
        $this->add_control(
			'multi_scroll_content_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
			]
		);
        $this->end_controls_section();						
		
		/*full page dots settings start*/
		$this->start_controls_section('dots_settings',
            [
                'label'     => esc_html__('Dots', 'tpebl'),
				'condition' => [
					'page_scroll_opt!' => 'tp_horizontal_scroll',
				],
            ]
        );		
		$this->add_control(
			'show_dots',
			[
				'label' => esc_html__( 'Dots', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'yes',
				'description'   => esc_html__('Works only on the frontend', 'tpebl'),
				'condition' => [
					'page_scroll_opt' => 'tp_full_page',
				],
			]
		);		
		$this->add_control('nav_postion',
            [
                'label'         => esc_html__('Dots Positions', 'tpebl'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'right'   => esc_html__('Right', 'tpebl'),
                    'left'   => esc_html__('Left', 'tpebl'),
                ],
                'default'       => 'right',
				'condition' => [					
					'show_dots' => 'yes',
					'page_scroll_opt' => 'tp_full_page',
				],
            ]
        );
		$this->add_control('nav_dots_tooltips',
            [
                'label'         => esc_html__('Dots Tooltips Text', 'tpebl'),
                'type'          => Controls_Manager::TEXT,
                'description'   => esc_html__('Add Multiple text separated by comma \',\'','tpebl'),
                'condition'     => [
					'page_scroll_opt' => ['tp_full_page'],
                    'show_dots'   => 'yes'					
                ]
            ]
        );
		/*navigation multi scroll*/
		
		$this->add_control(
			'multi_navigation_dots',
            [
                'label'         => esc_html__('Navigation Dots', 'tpebl'),
                'type'          => Controls_Manager::SWITCHER,
				'default'		=> 'yes',
				'condition'		=> [
					'page_scroll_opt' => 'tp_multi_scroll',
				],
                
            ]
        );		
		$this->add_control(
			'multi_navigation_dots_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'page_scroll_opt' => 'tp_multi_scroll',
					'multi_navigation_dots' => 'yes',
				],
			]
		);
		/*navigation multi scroll*/
		
		$this->add_control(
			'scroll_nav_connection',
			[
				'label' => esc_html__( 'Scroll Navigation Connection', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'no',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'scroll_nav_connection_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'scroll_nav_connection' => [ 'yes' ],
				],
			]
		);
		$this->end_controls_section();
		/*full page dots settings end*/
		
		/*Next previous settings end*/
		$this->start_controls_section('next_previous_settings',
            [
                'label'     => esc_html__('Next Previous Button', 'tpebl'),
				'condition' => [
					'page_scroll_opt' => ['tp_full_page'],
				],
            ]
        );
		$this->add_control(
			'show_next_prev',
			[
				'label' => esc_html__( 'Next Previous Button', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'yes',				
			]
		);
		$this->add_control('next_prev_style',
            [
                'label'         => esc_html__('Style', 'tpebl'),
                'type'          => Controls_Manager::SELECT,
                'options'       => [
                    'style-1'   => esc_html__('Style 1 (Pro)', 'tpebl'),
                    'style-2'   => esc_html__('Style 2 (Pro)', 'tpebl'),
                    'style-3'   => esc_html__('Style 3 (Pro)', 'tpebl'),
                    'custom'   => esc_html__('Custom (Pro)', 'tpebl'),
                ],
                'default'       => 'style-1',
				'condition' => [
					'show_next_prev' => 'yes',
				],
            ]
        );
		$this->add_control(
			'next_prev_style_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'show_next_prev' => [ 'yes' ],
				],
			]
		);
		$this->end_controls_section();
		/*Next previous settings end*/
				
		/*paginate settings start*/
		$this->start_controls_section('section_show_paginate',
            [
                'label'     => esc_html__('Paginate', 'tpebl'),
				'condition' => [
					'page_scroll_opt' => ['tp_full_page'],
				],
            ]
        );
		$this->add_control(
			'show_paginate',
			[
				'label' => esc_html__( 'Show Paginate', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'no',				
			]
		);
		$this->add_control(
			'show_paginate_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'show_paginate' => [ 'yes' ],
				],
			]
		);
		$this->end_controls_section();
		/*paginate settings end*/
		
		/*header footer selection start*/
		$this->start_controls_section('section_show_header_footer_opt',
            [
                'label'     => esc_html__('Footer Options', 'tpebl'),
				'condition' => [
					'page_scroll_opt' => ['tp_full_page'],
				],
            ]
        );
		$this->add_control(
			'tp_show_header_footer_note',
			[
				'label' => esc_html__( 'Footer template count in Paginate.', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::HEADING,				
			]
		);			
		$this->add_control(
			'tp_show_footer',
			[
				'label' => esc_html__( 'Footer', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'no',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'tp_show_footer_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'tp_show_footer' => [ 'yes' ],
				],
			]
		);
		$this->end_controls_section();
		/*header footer selection end*/
		
		/*extra option start*/
		$this->start_controls_section('section_show_extra_opt',
            [
                'label'     => esc_html__('Extra Option', 'tpebl'),
				'condition' => [
					'page_scroll_opt' => ['tp_full_page'],
				],
            ]
        );
		$this->add_control(
			'tp_direction',
			[
				'label' => esc_html__( 'Direction', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'vertical',
				'options' => [
					'vertical'  => esc_html__( 'Vertical (Pro)', 'tpebl' ),
					'horizontal'  => esc_html__( 'Horizontal (Pro)', 'tpebl' ),					
				],
				'separator' => 'after',
				'condition' => [
					'page_scroll_opt!' => ['tp_full_page'],
				],
			]
		);
		$this->add_control(
			'tp_fp_hide_hash_id',
			[
				'label' => esc_html__( 'Hide Hash/id in URL', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'no',
				'separator' => 'after',
				'condition' => [
					'page_scroll_opt' => ['tp_full_page'],
				],
			]
		);
		$this->add_control(
			'tp_fp_hide_hash_id_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'page_scroll_opt' => ['tp_full_page'],
					'tp_fp_hide_hash_id' => [ 'yes' ],
				],
			]
		);
		$this->add_control(
			'tp_keyboard_scrolling',
			[
				'label' => esc_html__( 'Keyboard Scrolling', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'yes',
				
			]
		);
		$this->add_control(
			'tp_keyboard_scrolling_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'page_scroll_opt' => ['tp_full_page'],
					'tp_keyboard_scrolling' => [ 'yes' ],
				],
			]
		);
		$this->add_control(
			'tp_scrolling_speed',
			[
				'label' => esc_html__( 'Scrolling Speed (Pro)', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 5000,
				'step' => 5,
				'default' => 700,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'tp_loop_bottom',
			[
				'label' => esc_html__( 'Loop Bottom', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'no',
				'description'   => esc_html__('Scrolling down in the last section should scroll to the first one or not.','tpebl'),
				'separator' => 'before',
			]
		);
		$this->add_control(
			'tp_loop_bottom_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'tp_loop_bottom' => [ 'yes' ],
				],
			]
		);
		$this->add_control(
			'tp_loop_top',
			[
				'label' => esc_html__( 'Loop Top', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'description'   => esc_html__('Scrolling up in the first section should scroll to the last one or not.','tpebl'),
				'default' => 'no',
			]
		);
		$this->add_control(
			'tp_loop_top_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'tp_loop_top' => [ 'yes' ],
				],
			]
		);
		$this->add_control(
			'tp_tablet_off',
			[
				'label' => esc_html__( 'Page Pilling in Tablet', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),				
				'default' => 'no',
				'separator' => 'before',
				'condition' => [
					'page_scroll_opt!' => ['tp_full_page'],
				],
			]
		);
		$this->add_control(
			'tp_tablet_off_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'page_scroll_opt!' => ['tp_full_page'],
					'tp_tablet_off' => [ 'yes' ],
				],
			]
		);
		$this->add_control(
			'tp_mobile_off',
			[
				'label' => esc_html__( 'Page Pilling in Mobile', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'no',
				'condition' => [
					'page_scroll_opt!' => ['tp_full_page'],					
				],
			]
		);
		$this->add_control(
			'tp_mobile_off_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'page_scroll_opt!' => ['tp_full_page'],	
					'tp_mobile_off' => [ 'yes' ],
				],
			]
		);
		$this->add_control(
			'tp_continuous_vertical',
			[
				'label' => esc_html__( 'Continuous Vertical', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'no',
				'separator' => 'before',
				'condition' => [
					'page_scroll_opt!' => ['tp_page_pilling'],
				],
			]
		);
		$this->add_control(
			'tp_continuous_vertical_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'page_scroll_opt!' => ['tp_page_pilling'],
					'tp_continuous_vertical' => [ 'yes' ],
				],
			]
		);
		$this->add_control(
			'tp_responsive_width',
			[
				'label' => esc_html__( 'Responsive Width', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'no',				
				'condition' => [
					'page_scroll_opt!' => ['tp_page_pilling'],
				],
			]
		);
		$this->add_control(
			'res_width_value',
			[
				'label' => esc_html__( 'Responsive Width', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 300,
				'max' => 2000,
				'step' => 5,
				'default' => 0,
				'description'   => esc_html__('ex. 900 < Scroll Normal Site','tpebl'),
				'condition' => [
					'page_scroll_opt!' => ['tp_page_pilling'],
					'tp_responsive_width' => 'yes',
				],
			]
		);
		$this->end_controls_section();
		/*extra option end*/
		
		/*extra option multi scroll start*/
		$this->start_controls_section(
			'section_multi_extra_opt',
            [
                'label'     => esc_html__('Extra Option', 'tpebl'),
				'condition'		=> [
					'page_scroll_opt' => 'tp_multi_scroll',
				],
            ]
        );
		$this->add_control(
			'section_multi_extra_opt_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
			]
		);
		$this->end_controls_section();
		/*extra option multi scroll end*/
		/************** style tag start*****************/
		/*hscroll style*/
		$this->start_controls_section(
            'section_hscroll_styling',
            [
                'label' => esc_html__('Horizontal Scroll Style', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'		=> [
					'page_scroll_opt' => 'tp_horizontal_scroll',
				],
            ]
        );
		$this->add_control(
			'section_hscroll_styling_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
			]
		);
		$this->end_controls_section();
		/*hscroll style*/
		/*dot style start*/
		$this->start_controls_section(
            'section_dot_styling',
            [
                'label' => esc_html__('Dot Style', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'		=> [
					'page_scroll_opt' => ['tp_full_page'],
				],
            ]
        );
		$this->start_controls_tabs( 'tabs_dot_style' );
		$this->start_controls_tab(
			'tab_dot_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);	
		$this->add_control(
			'dots_color_n',
			[
				'label' => esc_html__( 'Dots Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'#fp-nav ul li a span' => 'background: {{VALUE}}',
					'#pp-nav ul li a span,#multiscroll-nav ul li a span' => 'border:1px solid {{VALUE}} !important',
				],
			]
		);		
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_dot_active',
			[
				'label' => esc_html__( 'Active', 'tpebl' ),
				'condition'		=> [
					'page_scroll_opt!' => ['tp_full_page'],
				],
			]
		);
		$this->add_control(
			'dots_color_h',
			[
				'label' => esc_html__( 'Dots Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'#pp-nav ul li .active span,#multiscroll-nav ul li .active span' => 'background: {{VALUE}}',					
				],
			]
		);		
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'dots_tt_head',
			[
				'label' => esc_html__( 'Tooltip Text Option', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'dots_text_padding',
			[
				'label' => esc_html__( 'Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],				
				'selectors' => [
					'#fp-nav ul li .fp-tooltip,#pp-nav ul li .pp-tooltip,#multiscroll-nav ul li .multiscroll-tooltip' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'dots_text_typo_n',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '#fp-nav ul li .fp-tooltip,#pp-nav ul li .pp-tooltip,#multiscroll-nav ul li .multiscroll-tooltip',
				
			]
		);
		$this->add_control(
			'dots_text_color_n',
			[
				'label' => esc_html__( 'Tooltip Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'#fp-nav ul li .fp-tooltip,#pp-nav ul li .pp-tooltip,#multiscroll-nav ul li .multiscroll-tooltip' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'dots_text_bg_color_n',
			[
				'label' => esc_html__( 'Tooltip Background', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'#fp-nav ul li .fp-tooltip,#pp-nav ul li .pp-tooltip,#multiscroll-nav ul li .multiscroll-tooltip' => 'background: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
			'dots_tt_border',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'#fp-nav ul li .fp-tooltip,#pp-nav ul li .pp-tooltip,#multiscroll-nav ul li .multiscroll-tooltip' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		$this->end_controls_section();
		/*dot style end*/
		/*next previous buton start*/
		$this->start_controls_section(
            'section_nxt_prv_styling',
            [
                'label' => esc_html__('Next Previous Button Style', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'		=> [
					'page_scroll_opt' => ['tp_full_page'],
					'next_prev_style!' => ['custom'],
				],
            ]
        );
		$this->add_control(
			'section_nxt_prv_styling_options',
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
            'section_nxt_prv_custom',
            [
                'label' => esc_html__('Next Previous Custom Style', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'		=> [					
					'page_scroll_opt' => ['tp_full_page'],			
					'next_prev_style' => ['custom'],
				],
            ]
        );
		$this->add_control(
			'section_nxt_prv_custom_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
			]
		);
		$this->end_controls_section();
		/*next previous buton end*/
		$this->start_controls_section(
            'section_paginate_custom',
            [
                'label' => esc_html__('Paginate Style', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'		=> [				
					'page_scroll_opt' => ['tp_full_page'],
					'show_paginate' => 'yes',
				],
            ]
        );
		$this->add_control(
			'section_paginate_custom_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
			]
		);
		$this->end_controls_section();
		/*next previous buton end*/	
		/************** style tag end*****************/
	}
	
	
	protected function render() {
		$settings = $this->get_settings_for_display();
		$page_scroll_opt = $settings['page_scroll_opt'];
		$uid_widget=uniqid("ps");
		$id = $this->get_id();
		$data_attr='';
        $widget_id = 'ps'.$this->get_id();
		
        $this->add_inline_editing_attributes('left_side_text', 'advanced');
        $this->add_inline_editing_attributes('right_side_text', 'advanced');
        $this->add_render_attribute('left_side_text', 'class', 'theplus-multiscroll-left-text');
        $this->add_render_attribute('right_side_text', 'class', 'theplus-multiscroll-right-text');
       
		
		/*Full Page*/
		$full_page_content='';
		$full_page_anchors=array();
		$fullpage_opt=array();
		if($page_scroll_opt=='tp_full_page'){
			if(!empty($settings["fp_content"])) {
				$i=1;
				foreach($settings["fp_content"] as $item) {
					if(!empty($item["fp_content_template"])){
						$slideid =(!empty($item['fp-slideid'])) ? $item['fp-slideid'] : 'fp_'.$id.'_'.$i;
						$full_page_anchors[] = $slideid;
						
						$full_page_content .='<div class="section">';
							$full_page_content .=L_Theplus_Element_Load::elementor()->frontend->get_builder_content_for_display($item["fp_content_template"]);
						$full_page_content .='</div>';
						
						$i++;
					}
				}
			}
			
			if(!empty($full_page_anchors)){				
				$fullpage_opt['anchors']=$full_page_anchors;				
			}
			$fullpage_opt["navigationTooltips"] = false;			
			$nav_dots_text = explode(',', $settings['nav_dots_tooltips'] );
			$fullpage_opt["responsiveWidth"] = ($settings["res_width_value"]!='') ? $settings["res_width_value"]: 0;
			
			if(($settings['show_dots']=='yes' && $page_scroll_opt=='tp_full_page') && (!empty($settings['show_dots']) && $page_scroll_opt=='tp_full_page')){				
				$fullpage_opt["navigation"] = true;
				$fullpage_opt["navigationPosition"] = (!empty($settings['nav_postion']) && $settings['nav_postion']=='left') ? 'left' : 'right';
				$fullpage_opt['navigationTooltips']=$nav_dots_text;				
			}else{
				$fullpage_opt["navigation"] = false;
			}
			
			$data_fullpage=json_encode($fullpage_opt);
			$data_attr .= ' data-full-page-opt=\'' . $data_fullpage . '\'';
			
			if(!empty($settings['scroll_nav_connection']) && $settings['scroll_nav_connection']=='yes' && !empty($settings['scrollnav_connect_id'])){
				$data_attr .= ' data-scroll-nav-id="tp-sc-'.esc_attr($settings['scrollnav_connect_id']).'"';
			}
		}
		
		echo '<div id="'.$uid_widget.'" class="tp-page-scroll-wrapper '.$uid_widget.' '.$page_scroll_opt.'" data-id="'.$uid_widget.'" data-option="'.esc_attr($page_scroll_opt).'" '.$data_attr.'>';
		
			if($page_scroll_opt=='tp_full_page'){
				echo $full_page_content;
			}
			
		echo '</div>';	
	}
}