<?php 
/*
Widget Name: Pricing Table
Description: unique design of pricing table.
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

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class L_ThePlus_Pricing_Table extends Widget_Base {
		
	public function get_name() {
		return 'tp-pricing-table';
	}

    public function get_title() {
        return esc_html__('Pricing Table', 'tpebl');
    }

    public function get_icon() {
        return 'fa fa-money theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-essential');
    }
	
    protected function _register_controls() {
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Layout', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'pricing_table_style',
			[
				'label' => esc_html__( 'Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'style-1'  => esc_html__( 'Style 1', 'tpebl' ),
					'style-2'  => esc_html__( 'Style 2 (PRO)', 'tpebl' ),
					'style-3'  => esc_html__( 'Style 3 (PRO)', 'tpebl' ),
				],
			]
		);
		$this->add_control(
			'pricing_table_style_pro_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'pricing_table_style!' => [ 'style-1' ],
				],
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'title_content_section',
			[
				'label' => esc_html__( 'Title Section', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'pricing_table_style' => 'style-1',
				],
			]
		);
		$this->add_control(
			'title_heading',
			[
				'label' => esc_html__( 'Title', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'title_style',
			[
				'label' => esc_html__( 'Title Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'style-1'  => esc_html__( 'Style 1', 'tpebl' ),
				],
			]
		);
		$this->add_control(
			'pricing_title',
			[
				'label' => esc_html__( 'Title', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Professional', 'tpebl' ),
				'dynamic' => ['active'   => true,],
			]
		);
		$this->add_control(
			'pricing_subtitle',
			[
				'label' => esc_html__( 'Sub Title', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => ['active'   => true,],
			]
		);
		$this->add_control(
			'icons_heading',
			[
				'label' => esc_html__( 'Icon Options', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'image_icon',
			[
				'label' => esc_html__( 'Select Icon', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'description' => esc_html__('You can select Icon, Custom Image or SVG using this option.','tpebl'),
				'default' => '',
				'options' => [
					''  => esc_html__( 'None', 'tpebl' ),
					'icon' => esc_html__( 'Icon', 'tpebl' ),
					'image' => esc_html__( 'Image', 'tpebl' ),
					'svg' => esc_html__( 'Svg (PRO)', 'tpebl' ),
				],
			]
		);
		$this->add_control(
			'svg_icon_pro_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'image_icon' => 'svg',
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
				'media_type' => 'image',
				'dynamic' => ['active'   => true,],
				'condition' => [
					'image_icon' => 'image',
				],
			]
		);
		$this->add_control(
			'icon_font_style',
			[
				'label' => esc_html__( 'Icon Font', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'font_awesome',
				'options' => [
					'font_awesome'  => esc_html__( 'Font Awesome', 'tpebl' ),
					'icon_mind' => esc_html__( 'Icons Mind (PRO)', 'tpebl' ),
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
					'icon_font_style' => 'font_awesome',
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
					'icon_font_style' => 'icon_mind',
				],
			]
		);		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'price_content_section',
			[
				'label' => esc_html__( 'Price', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'pricing_table_style' => 'style-1',
				],
			]
		);
		$this->add_control(
			'price_style',
			[
				'label' => esc_html__( 'Price Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'style-1'  => esc_html__( 'Style 1', 'tpebl' ),
					'style-2'  => esc_html__( 'Style 2 (PRO)', 'tpebl' ),
					'style-3'  => esc_html__( 'Style 3 (PRO)', 'tpebl' ),
				],
			]
		);
		$this->add_control(
			'price_style_pro_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'price_style!' => 'style-1',
				],
			]
		);

		$this->add_control(
			'price_prefix',
			[
				'label' => esc_html__( 'Prefix Text', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '$', 'tpebl' ),
				'placeholder' => esc_html__( 'Enter text of Price Prefix.. Ex. $,Rs,...', 'tpebl' ),
				'dynamic' => ['active'   => true,],
				'condition' => [
					'price_style' => 'style-1',
				],
			]
		);
		$this->add_control(
			'price',
			[
				'label' => esc_html__( 'Value Of Price', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '59.99', 'tpebl' ),
				'placeholder' => esc_html__( 'Enter value of Price.. Ex. 49,69...', 'tpebl' ),
				'dynamic' => ['active'   => true,],
				'condition' => [
					'price_style' => 'style-1',
				],
			]
		);
		$this->add_control(
			'price_postfix',
			[
				'label' => esc_html__( 'Postfix Text', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Per Month', 'tpebl' ),
				'placeholder' => esc_html__( 'Enter text of Price Postfix.. Ex. Per Month...', 'tpebl' ),
				'dynamic' => ['active'   => true,],
				'condition' => [
					'price_style' => 'style-1',
				],
			]
		);
		$this->end_controls_section();
		/*Previous Price*/
		$this->start_controls_section(
			'previous_price_content_section',
			[
				'label' => esc_html__( 'Previous Price', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'pricing_table_style' => 'style-1',
				],
			]
		);
		$this->add_control(
			'show_previous_price',
			[
				'label'        => esc_html__( 'Display Previous Price', 'tpebl' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'tpebl' ),
				'label_off'    => esc_html__( 'No', 'tpebl' ),
			]
		);
		$this->add_control(
			'previous_price_prefix',
			[
				'label' => esc_html__( 'Prefix Text', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '$', 'tpebl' ),
				'placeholder' => esc_html__( 'Enter text of Price Prefix.. Ex. $,Rs,...', 'tpebl' ),
				'dynamic' => ['active'   => true,],
				'condition' => [
					'show_previous_price' => 'yes',
				],
			]
		);
		$this->add_control(
			'previous_price',
			[
				'label' => esc_html__( 'Value Of Price', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '59.99', 'tpebl' ),
				'placeholder' => esc_html__( 'Enter value of Price.. Ex. 49,69...', 'tpebl' ),
				'dynamic' => ['active'   => true,],
				'condition' => [
					'show_previous_price' => 'yes',
				],
			]
		);
		$this->add_control(
			'previous_price_postfix',
			[
				'label' => esc_html__( 'Postfix Text', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__( 'Enter text of Price Postfix.. Ex. Rs,%..', 'tpebl' ),
				'dynamic' => ['active'   => true,],
				'condition' => [
					'show_previous_price' => 'yes',
				],
			]
		);
		$this->end_controls_section();
		/*Previous Price*/
		$this->start_controls_section(
			'content_description_section',
			[
				'label' => esc_html__( 'Content Description', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'pricing_table_style' => 'style-1',
				],
			]
		);
		$this->add_control(
			'content_style',
			[
				'label' => esc_html__( 'Content Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'stylist_list',
				'options' => [
					'stylist_list'  => esc_html__( 'Stylish List', 'tpebl' ),
					'wysiwyg_content'  => esc_html__( 'WYSIWYG', 'tpebl' ),
				],
			]
		);
		$this->add_control(
			'content_list_style',
			[
				'label' => esc_html__( 'Content List Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'style-1'  => esc_html__( 'Style 1', 'tpebl' ),
					'style-2'  => esc_html__( 'Style 2', 'tpebl' ),
				],
				'condition' => [
					'content_style' => 'stylist_list',
				],
			]
		);
		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'list_description',
			[
				'label' => esc_html__( 'List Description', 'tpebl' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'I am text block.', 'tpebl' ),
				'placeholder' => esc_html__( 'Type your description here', 'tpebl' ),
				'dynamic' => ['active'   => true,],
			]
		);
		$repeater->add_control(
			'list_icon_style',
			[
				'label' => esc_html__( 'Icon Font', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'font_awesome',
				'options' => [
					'font_awesome'  => esc_html__( 'Font Awesome (Pro)', 'tpebl' ),
					'icon_mind' => esc_html__( 'Icons Mind (Pro)', 'tpebl' ),
				],
			]
		);
		$repeater->add_control(
			'list_icons_mind_pro',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'list_icon_style' => ['font_awesome','icon_mind'],
				],
			]
		);
		$repeater->add_control(
			'show_tooltips',
			[
				'label'        => esc_html__( 'Tooltip options', 'tpebl' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'tpebl' ),
				'label_off'    => esc_html__( 'No', 'tpebl' ),
				'render_type'  => 'template',
				'separator' => 'before',
			]
		);
		$repeater->add_control(
			'show_tooltips_pro',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'show_tooltips' => 'yes',
				],
			]
		);
		$this->add_control(
			'icon_list',
			[
				'label' => '',
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'list_description' => esc_html__( 'List Item 1', 'tpebl' ),
					],
					[
						'list_description' => esc_html__( 'List Item 2', 'tpebl' ),
					],
					[
						'list_description' => esc_html__( 'List Item 3', 'tpebl' ),
					],
				],
				'title_field' => '{{{ list_description }}}',
				'condition' => [
					'content_style' => 'stylist_list',
				],
			]
		);
		$this->add_control(
			'content_wysiwyg_style',
			[
				'label' => esc_html__( 'Content Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'style-1'  => esc_html__( 'Style 1', 'tpebl' ),
					'style-2'  => esc_html__( 'Style 2', 'tpebl' ),
				],
				'condition' => [
					'content_style' => 'wysiwyg_content',
				],
			]
		);
		$this->add_control(
			'content_wysiwyg',
			[
				'label' => esc_html__( 'Content', 'tpebl' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'tpebl' ),
				'dynamic' => ['active'   => true,],
				'condition' => [
					'content_style' => 'wysiwyg_content',
				],
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
            'button_section',
            [
                'label' => esc_html__('Button', 'tpebl'),
                'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'pricing_table_style' => 'style-1',
				],
            ]
        );
		$this->add_control(
			'display_button',
			[
				'label' => esc_html__( 'Button', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
            'button_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Button Style', 'tpebl'),
                'default' => 'style-8',
                'options' => [
                    'style-7' => esc_html__('Style 1 (PRO)', 'tpebl'),
                    'style-8' => esc_html__('Style 2', 'tpebl'),
                    'style-9' => esc_html__('Style 3 (PRO)', 'tpebl'),                    
                ],
				'condition' => [
					'display_button' => 'yes',
				],
            ]
        );
		$this->add_control(
			'button_style_pro_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'display_button' => 'yes',
					'button_style!' => 'style-8',
				],
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => esc_html__( 'Button Text', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Free Trial', 'tpebl' ),
				'dynamic' => ['active'   => true,],
				'condition' => [
					'display_button' => 'yes',
					'button_style' => 'style-8',
				],
			]
		);
		$this->add_control(
			'button_link',
			[
				'label' => esc_html__( 'Button Link', 'tpebl' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://www.demo-link.com', 'tpebl' ),
				'default' => [
					'url' => '#',
				],
				'condition' => [
					'display_button' => 'yes',
					'button_style' => 'style-8',
				],
			]
		);
		$this->add_control(
			'button_icon_style',
			[
				'label' => esc_html__( 'Icon Font', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'font_awesome',
				'options' => [
					''  => esc_html__( 'None', 'tpebl' ),
					'font_awesome'  => esc_html__( 'Font Awesome', 'tpebl' ),
					'icon_mind' => esc_html__( 'Icons Mind (Pro)', 'tpebl' ),
				],
				'condition' => [
					'display_button' => 'yes',
					'button_style!' => ['style-7','style-9'],
				],
			]
		);
		$this->add_control(
			'button_icon',
			[
				'label' => esc_html__( 'Icon', 'tpebl' ),
				'type' => Controls_Manager::ICON,
				'label_block' => true,
				'default' => 'fa fa-chevron-right',
				'condition' => [
					'display_button' => 'yes',
					'button_style!' => ['style-7','style-9'],
					'button_icon_style' => 'font_awesome',
				],
			]
		);
		$this->add_control(
			'button_icons_mind_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'display_button' => 'yes',
					'button_style!' => ['style-7','style-9'],
					'button_icon_style' => 'icon_mind',
				],
			]
		);
		$this->add_control(
			'before_after',
			[
				'label' => esc_html__( 'Icon Position', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'after',
				'options' => [
					'after' => esc_html__( 'After', 'tpebl' ),
					'before' => esc_html__( 'Before', 'tpebl' ),
				],
				'condition' => [
					'display_button' => 'yes',
					'button_style!' => ['style-7','style-9'],
					'button_icon_style!' => ['','icon_mind'],
				],
			]
		);
		$this->add_control(
			'icon_spacing',
			[
				'label' => esc_html__( 'Icon Spacing', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 100,
					],
				],
				'condition' => [
					'display_button' => 'yes',
					'button_style!' => ['style-7','style-9'],
					'button_icon_style!' => ['','icon_mind'],
				],
				'selectors' => [
					'{{WRAPPER}} .button-link-wrap i.button-after' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .button-link-wrap i.button-before' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]			
		);
		$this->end_controls_section();
		/* button content*/
		/*Call to Action*/
		$this->start_controls_section(
            'call_to_action_section',
            [
                'label' => esc_html__('Call to Action', 'tpebl'),
                'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'pricing_table_style' => 'style-1',
				],
            ]
        );
		$this->add_control(
			'call_to_action_section_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
			]
		);

		$this->end_controls_section();
		/*Call to Action*/
		/*Ribbon/pin */
		$this->start_controls_section(
            'ribbon_pin_section',
            [
                'label' => esc_html__('Ribbon', 'tpebl'),
                'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'pricing_table_style' => 'style-1',
				],
            ]
        );
		$this->add_control(
			'display_ribbon_pin',
			[
				'label' => esc_html__( 'Display Ribbon', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'tpebl' ),
				'label_off' => esc_html__( 'No', 'tpebl' ),
				'default' => 'no',
			]
		);
		$this->add_control(
			'ribbon_pin_style',
			[
				'label' => esc_html__( 'Ribbon Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'style-1'  => esc_html__( 'Style 1 (Pro)', 'tpebl' ),
					'style-2'  => esc_html__( 'Style 2 (Pro)', 'tpebl' ),
					'style-3'  => esc_html__( 'Style 3 (Pro)', 'tpebl' ),
				],
				'condition' => [
					'display_ribbon_pin' => 'yes',
				],
			]
		);
		$this->add_control(
			'ribbon_pin_style_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'display_ribbon_pin' => 'yes',
				],
			]
		);

		$this->end_controls_section();
		/*Ribbon/pin */
		/*svg style*/
		$this->start_controls_section(
            'section_svg_styling',
            [
                'label' => esc_html__('Svg Style', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'image_icon' => 'svg',
				],
            ]
        );
		$this->add_control(
			'section_svg_styling_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
			]
		);

		$this->end_controls_section();
		/*svg style*/
		/* icons style */
		$this->start_controls_section(
            'section_icon_styling',
            [
                'label' => esc_html__('Icon Style', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'image_icon' => 'icon',
				],
            ]
        );
		$this->add_control(
			'icon_style',
			[
				'label' => esc_html__( 'Icon Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'square',
				'options' => [
					''  => esc_html__( 'None', 'tpebl' ),
					'square' => esc_html__( 'Square', 'tpebl' ),
					'rounded' => esc_html__( 'Rounded', 'tpebl' ),
					'hexagon' => esc_html__( 'Hexagon (PRO)', 'tpebl' ),
					'pentagon' => esc_html__( 'Pentagon (PRO)', 'tpebl' ),
					'square-rotate' => esc_html__( 'Square Rotate (PRO)', 'tpebl' ),
				],
			]
		);
		$this->add_control(
            'icon_size',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Size', 'tpebl'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 25,
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-table-inner .pricing-icon' => 'font-size: {{SIZE}}{{UNIT}} !important;',
				],
            ]
        );
		$this->add_control(
            'icon_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Width', 'tpebl'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 250,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 50,
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-table-inner .pricing-icon' => 'width: {{SIZE}}{{UNIT}} !important;height: {{SIZE}}{{UNIT}} !important;line-height: {{SIZE}}{{UNIT}} !important;text-align: center;',
				],
            ]
        );
		$this->start_controls_tabs( 'tabs_icon_style' );
		$this->start_controls_tab(
			'tab_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_control(
			'icon_color_option',
			[
				'label' => esc_html__( 'Icon Color', 'tpebl' ),
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
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-table-inner .pricing-icon' => 'color: {{VALUE}}',
				],
				'condition' => [
					'icon_color_option' => 'solid',
				],
				'separator' => 'after',
			]
		);
		$this->add_control(
            'icon_gradient_color1',
            [
                'label' => esc_html__('Color 1', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => 'orange',
				'condition' => [
					'icon_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'icon_gradient_color1_control',
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
					'icon_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'icon_gradient_color2',
            [
                'label' => esc_html__('Color 2', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => 'cyan',
				'condition' => [
					'icon_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'icon_gradient_color2_control',
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
					'icon_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'icon_gradient_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Gradient Style', 'tpebl'),
                'default' => 'linear',
                'options' => l_theplus_get_gradient_styles(),
				'condition' => [
					'icon_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'icon_gradient_angle', [
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
					'{{WRAPPER}} .plus-pricing-table .pricing-table-inner .pricing-icon' => 'background-color: transparent;-webkit-background-clip: text;-webkit-text-fill-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{icon_gradient_color1.VALUE}} {{icon_gradient_color1_control.SIZE}}{{icon_gradient_color1_control.UNIT}}, {{icon_gradient_color2.VALUE}} {{icon_gradient_color2_control.SIZE}}{{icon_gradient_color2_control.UNIT}})',
				],
				'condition'    => [
					'icon_color_option' => 'gradient',
					'icon_gradient_style' => ['linear']
				],
				'of_type' => 'gradient',
				'separator' => 'after',
			]
        );
		$this->add_control(
            'icon_gradient_position', [
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Position', 'tpebl'),
				'options' => l_theplus_get_position_options(),
				'default' => 'center center',
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-table-inner .pricing-icon' => 'background-color: transparent;-webkit-background-clip: text;-webkit-text-fill-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{icon_gradient_color1.VALUE}} {{icon_gradient_color1_control.SIZE}}{{icon_gradient_color1_control.UNIT}}, {{icon_gradient_color2.VALUE}} {{icon_gradient_color2_control.SIZE}}{{icon_gradient_color2_control.UNIT}})',
				],
				'condition' => [
					'icon_color_option' => 'gradient',
					'icon_gradient_style' => 'radial',
				],
				'of_type' => 'gradient',
				'separator' => 'after',
				
			]
        );
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'icon_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .plus-pricing-table .pricing-table-inner .pricing-icon',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'icon_border_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-table-inner .pricing-icon' => 'border-color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'icon_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .plus-pricing-table .pricing-table-inner .pricing-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'icon_box_shadow',
				'selector' => '{{WRAPPER}} .plus-pricing-table .pricing-table-inner .pricing-icon',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_control(
			'icon_hover_color_option',
			[
				'label' => esc_html__( 'Icon Hover Color', 'tpebl' ),
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
			'icon_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-table-inner:hover .pricing-icon' => 'color: {{VALUE}}',
				],
				'condition' => [
					'icon_hover_color_option' => 'solid',
				],
				'separator' => 'after',
			]
		);
		$this->add_control(
            'icon_hover_gradient_color1',
            [
                'label' => esc_html__('Color 1', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => 'orange',
				'condition' => [
					'icon_hover_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'icon_hover_gradient_color1_control',
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
					'icon_hover_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'icon_hover_gradient_color2',
            [
                'label' => esc_html__('Color 2', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => 'cyan',
				'condition' => [
					'icon_hover_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'icon_hover_gradient_color2_control',
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
					'icon_hover_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'icon_hover_gradient_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Gradient Style', 'tpebl'),
                'default' => 'linear',
                'options' => l_theplus_get_gradient_styles(),
				'condition' => [
					'icon_hover_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'icon_hover_gradient_angle', [
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
					'{{WRAPPER}} .plus-pricing-table .pricing-table-inner:hover .pricing-icon' => 'background-color: transparent;-webkit-background-clip: text;-webkit-text-fill-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{icon_hover_gradient_color1.VALUE}} {{icon_hover_gradient_color1_control.SIZE}}{{icon_hover_gradient_color1_control.UNIT}}, {{icon_hover_gradient_color2.VALUE}} {{icon_hover_gradient_color2_control.SIZE}}{{icon_hover_gradient_color2_control.UNIT}})',
				],
				'condition'    => [
					'icon_hover_color_option' => 'gradient',
					'icon_hover_gradient_style' => ['linear']
				],
				'of_type' => 'gradient',
				'separator' => 'after',
			]
        );
		$this->add_control(
            'icon_hover_gradient_position', [
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Position', 'tpebl'),
				'options' => l_theplus_get_position_options(),
				'default' => 'center center',
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-table-inner:hover .pricing-icon' => 'background-color: transparent;-webkit-background-clip: text;-webkit-text-fill-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{icon_hover_gradient_color1.VALUE}} {{icon_hover_gradient_color1_control.SIZE}}{{icon_hover_gradient_color1_control.UNIT}}, {{icon_hover_gradient_color2.VALUE}} {{icon_hover_gradient_color2_control.SIZE}}{{icon_hover_gradient_color2_control.UNIT}})',
				],
				'condition' => [
					'icon_hover_color_option' => 'gradient',
					'icon_hover_gradient_style' => 'radial',
				],
				'of_type' => 'gradient',
				'separator' => 'after',
			]
        );
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'icon_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .plus-pricing-table .pricing-table-inner:hover .pricing-icon',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'icon_border_hover_color',
			[
				'label' => esc_html__( 'Hover Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-table-inner:hover .pricing-icon' => 'border-color: {{VALUE}}',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'icon__hover_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .plus-pricing-table .pricing-table-inner:hover .pricing-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'icon_hover_box_shadow',
				'selector' => '{{WRAPPER}} .plus-pricing-table .pricing-table-inner:hover .pricing-icon',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();		
		$this->end_controls_section();		
		/*icon style*/
		
		/*title style*/
		$this->start_controls_section(
            'section_title_styling',
            [
                'label' => esc_html__('Title Style', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pricing_title!' => '',
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'selector' => '{{WRAPPER}} .plus-pricing-table .pricing-title',
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
				'label_block' => false,
				'default' => 'solid',
			]
		);
		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-title' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .plus-pricing-table .pricing-title' => 'background-color: transparent;-webkit-background-clip: text;-webkit-text-fill-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{title_gradient_color1.VALUE}} {{title_gradient_color1_control.SIZE}}{{title_gradient_color1_control.UNIT}}, {{title_gradient_color2.VALUE}} {{title_gradient_color2_control.SIZE}}{{title_gradient_color2_control.UNIT}})',
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
					'{{WRAPPER}} .plus-pricing-table .pricing-title' => 'background-color: transparent;-webkit-background-clip: text;-webkit-text-fill-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{title_gradient_color1.VALUE}} {{title_gradient_color1_control.SIZE}}{{title_gradient_color1_control.UNIT}}, {{title_gradient_color2.VALUE}} {{title_gradient_color2_control.SIZE}}{{title_gradient_color2_control.UNIT}})',
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
			'tab_title_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_control(
			'title_hover_color_option',
			[
				'label' => esc_html__( 'Title Hover Color', 'tpebl' ),
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
				'label_block' => false,
				'default' => 'solid',
			]
		);
		$this->add_control(
			'title_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-table-inner:hover .pricing-title' => 'color: {{VALUE}}',
				],
				'condition' => [
					'title_hover_color_option' => 'solid',
				],
			]
		);
		$this->add_control(
            'title_hover_gradient_color1',
            [
                'label' => esc_html__('Color 1', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => 'orange',
				'condition' => [
					'title_hover_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_hover_gradient_color1_control',
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
					'title_hover_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_hover_gradient_color2',
            [
                'label' => esc_html__('Color 2', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => 'cyan',
				'condition' => [
					'title_hover_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_hover_gradient_color2_control',
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
					'title_hover_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_hover_gradient_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Gradient Style', 'tpebl'),
                'default' => 'linear',
                'options' => l_theplus_get_gradient_styles(),
				'condition' => [
					'title_hover_color_option' => 'gradient',
				],
				'of_type' => 'gradient',
            ]
        );
		$this->add_control(
            'title_hover_gradient_angle', [
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
					'{{WRAPPER}} .plus-pricing-table .pricing-table-inner:hover .pricing-title' => 'background-color: transparent;-webkit-background-clip: text;-webkit-text-fill-color: transparent; background-image: linear-gradient({{SIZE}}{{UNIT}}, {{title_hover_gradient_color1.VALUE}} {{title_hover_gradient_color1_control.SIZE}}{{title_hover_gradient_color1_control.UNIT}}, {{title_hover_gradient_color2.VALUE}} {{title_hover_gradient_color2_control.SIZE}}{{title_hover_gradient_color2_control.UNIT}})',
				],
				'condition'    => [
					'title_hover_color_option' => 'gradient',
					'title_hover_gradient_style' => ['linear']
				],
				'of_type' => 'gradient',
			]
        );
		$this->add_control(
            'title_hover_gradient_position', [
				'type' => Controls_Manager::SELECT,
				'label' => esc_html__('Position', 'tpebl'),
				'options' => l_theplus_get_position_options(),
				'default' => 'center center',
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-table-inner:hover .pricing-title' => 'background-color: transparent;-webkit-background-clip: text;-webkit-text-fill-color: transparent; background-image: radial-gradient(at {{VALUE}}, {{title_hover_gradient_color1.VALUE}} {{title_hover_gradient_color1_control.SIZE}}{{title_hover_gradient_color1_control.UNIT}}, {{title_hover_gradient_color2.VALUE}} {{title_hover_gradient_color2_control.SIZE}}{{title_hover_gradient_color2_control.UNIT}})',
				],
				'condition' => [
					'title_hover_color_option' => 'gradient',
					'title_hover_gradient_style' => 'radial',
				],
			'of_type' => 'gradient',
			]
        );
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*title style*/
		/*subtitle style*/
		$this->start_controls_section(
            'section_subtitle_styling',
            [
                'label' => esc_html__('SubTitle Style', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pricing_subtitle!' => '',
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subtitle_typography',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'selector' => '{{WRAPPER}} .plus-pricing-table .pricing-table-inner .pricing-subtitle',
			]
		);
		$this->add_control(
			'subtitle_color',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-table-inner .pricing-subtitle' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'subtitle_Hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-table-inner:hover .pricing-subtitle' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		/*subtitle style*/
		/*Previous Price Style*/
		$this->start_controls_section(
            'section_previous_price_styling',
            [
                'label' => esc_html__('Previous Price Style', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_previous_price' => 'yes',
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'previous_price_typography',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'selector' => '{{WRAPPER}} .plus-pricing-table .pricing-previous-price-wrap',
			]
		);
		$this->add_control(
			'previous_price_align',
			[
				'label' => esc_html__( 'Price Alignment', 'tpebl' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'top' => [
						'title' => esc_html__( 'Top', 'tpebl' ),
						'icon' => 'fa fa-level-up',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'tpebl' ),
						'icon' => 'eicon-text-align-center',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'tpebl' ),
						'icon' => 'fa fa-level-down',
					],
				],
				'default' => 'top',
				'toggle' => true,
				'label_block' => false,
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-previous-price-wrap' => 'vertical-align: {{VALUE}};',
				],
			]
		);
		$this->start_controls_tabs( 'previous_price_style_tab' );
		$this->start_controls_tab(
			'previous_price_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		
		$this->add_control(
			'previous_price_color',
			[
				'label' => esc_html__( 'Price Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-previous-price-wrap' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'previous_price_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_control(
			'previous_price_hover_color',
			[
				'label' => esc_html__( 'Price Hover Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-table-inner:hover .pricing-previous-price-wrap' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Previous Price Style*/		
		/*Price Style */
		$this->start_controls_section(
            'section_price_styling',
            [
                'label' => esc_html__('Price Style', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
			'price_style_heading',
			[
				'label' => esc_html__( 'Price Main', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'selector' => '{{WRAPPER}} .plus-pricing-table .pricing-price-wrap.style-1 span.price-prefix-text,{{WRAPPER}} .plus-pricing-table .pricing-price-wrap.style-1 .pricing-price',
			]
		);
		$this->start_controls_tabs( 'price_style_tab' );
		$this->start_controls_tab(
			'price_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		
		$this->add_control(
			'price_color',
			[
				'label' => esc_html__( 'Price Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-price-wrap.style-1 span.price-prefix-text,{{WRAPPER}} .plus-pricing-table .pricing-price-wrap.style-1 .pricing-price' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'price_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_control(
			'price_hover_color',
			[
				'label' => esc_html__( 'Price Hover Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-table-inner:hover .pricing-price-wrap.style-1 span.price-prefix-text,{{WRAPPER}} .plus-pricing-table .pricing-table-inner:hover .pricing-price-wrap.style-1 .pricing-price' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'price_postfix_style_heading',
			[
				'label' => esc_html__( 'Postfix', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_postfix_typography',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'selector' => '{{WRAPPER}} .plus-pricing-table .pricing-price-wrap.style-1 span.price-postfix-text',
			]
		);
		$this->start_controls_tabs( 'price_postfix_style_tab' );
		$this->start_controls_tab(
			'price_postfix_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		
		$this->add_control(
			'price_postfix_color',
			[
				'label' => esc_html__( 'Postfix Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-price-wrap span.price-postfix-text' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'price_postfix_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_control(
			'price_postfix_hover_color',
			[
				'label' => esc_html__( 'Postfix Hover Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-table-inner:hover .pricing-price-wrap span.price-postfix-text' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Price Style */
		/*Content style*/
		$this->start_controls_section(
            'section_content_styling',
            [
                'label' => esc_html__('Content Style', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'selector' => '{{WRAPPER}} .plus-pricing-table .pricing-content-wrap.content-desc .pricing-content',
				'condition' => [
					'content_style' => 'wysiwyg_content',
				],
			]
		);
		$this->add_control(
			'content_text_color',
			[
				'label' => esc_html__( 'Content Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-content-wrap.content-desc .pricing-content,{{WRAPPER}} .plus-pricing-table .pricing-content-wrap.content-desc .pricing-content p' => 'color: {{VALUE}};',
				],
				'condition' => [
					'content_style' => 'wysiwyg_content',
				],
			]
		);
		$this->add_control(
			'content_border_width_color',
			[
				 'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Border Width', 'tpebl'),
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 2,
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-content-wrap.content-desc.style-1 hr.border-line' => 'margin: 30px {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'content_style' => 'wysiwyg_content',
					'content_wysiwyg_style' => 'style-1'
				],
			]
		);
		$this->add_control(
			'content_border_top_color',
			[
				'label' => esc_html__( 'Border Top Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-content-wrap.content-desc.style-1 hr.border-line' => 'border-top:1px solid;border-top-color: {{VALUE}};',
				],
				'condition' => [
					'content_style' => 'wysiwyg_content',
					'content_wysiwyg_style' => 'style-1'
				],
			]
		);
		$this->add_control(
			'list_content_typography_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'content_style' => 'stylist_list',
				],
			]
		);
		$this->add_responsive_control(
			'desc_content_alignment',
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
				],
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table .pricing-content-wrap.content-desc .pricing-content,{{WRAPPER}} .plus-pricing-table .pricing-content-wrap.content-desc .pricing-content p' => 'text-align: {{VALUE}}',
				],
				'condition' => [
					'content_style' => 'wysiwyg_content',
				],
				'default' => '',
				'toggle' => true,				
			]
		);
		$this->end_controls_section();
		/*Content style*/
		
		/*Content background style*/
		$this->start_controls_section(
            'section_content_bg_styling',
            [
                'label' => esc_html__('Content Background Style', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'content_style' => 'stylist_list',
				],
            ]
        );
		$this->add_control(
			'section_content_bg_styling_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
			]
		);

		$this->end_controls_section();
		/*Content background style*/
		$this->start_controls_section(
            'section_tooltip_option_styling',
            [
                'label' => esc_html__('Tooltip Options', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
			'section_tooltip_option_styling_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
			]
		);
		$this->end_controls_section();
		/*button style*/
		$this->start_controls_section(
            'section_button_styling',
            [
                'label' => esc_html__('Button Style', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'display_button' => 'yes',
				],
            ]
        );
		$this->add_control(
            'button_top_space',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Button Above Space', 'tpebl'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .pt-plus-button-wrapper' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'display_button' => 'yes',
				],
            ]
        );
		$this->add_responsive_control(
			'button_padding',
			[
				'label' => esc_html__( 'Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],
				'default' => [
							'top' => '8',
							'right' => '35',
							'bottom' => '8',
							'left' => '35',
							'isLinked' => false 
				],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_button .button-link-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .pt_plus_button .button-link-wrap',
			]
		);
		
		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		
		$this->add_control(
			'btn_text_color',
			[
				'label' => esc_html__( 'Text Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_button .button-link-wrap' => 'color: {{VALUE}};',
					'{{WRAPPER}} .pt_plus_button.button-style-7 .button-link-wrap:after' => 'border-color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap',
				'separator' => 'after',
				'condition' => [
					'button_style!' => ['style-7','style-9'],
				],
			]
		);
		$this->add_control(
			'button_border_style',
			[
				'label'   => esc_html__( 'Border Style', 'tpebl' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'none'   => esc_html__( 'None', 'tpebl' ),
					'solid'  => esc_html__( 'Solid', 'tpebl' ),
					'dotted' => esc_html__( 'Dotted', 'tpebl' ),
					'dashed' => esc_html__( 'Dashed', 'tpebl' ),
					'groove' => esc_html__( 'Groove', 'tpebl' ),
				],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap' => 'border-style: {{VALUE}};',
				],
				'condition' => [
					'button_style' => ['style-8'],
				],
			]
		);

		$this->add_responsive_control(
			'button_border_width',
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
					'{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_style' => ['style-8'],
					'button_border_style!' => 'none',
				]
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#313131',
				'selectors' => [
					'{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_style' => ['style-8'],
					'button_border_style!' => 'none'
				],
				'separator' => 'after',
			]
		);

		$this->add_responsive_control(
			'button_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_style' => ['style-8'],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '
							   {{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap',
				'condition' => [
					'button_style' => ['style-8'],
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_control(
			'btn_text_hover_color',
			[
				'label' => esc_html__( 'Text Hover Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_button .button-link-wrap:hover' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap:hover',
				'separator' => 'after',
				'condition' => [
					'button_style!' => ['style-7','style-9'],
				],
			]
		);
		$this->add_control(
			'button_border_hover_color',
			[
				'label'     => esc_html__( 'Hover Border Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#313131',
				'selectors' => [
					'{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_style' => ['style-8'],
					'button_border_style!' => 'none'
				],
				'separator' => 'after',
			]
		);
		

		$this->add_responsive_control(
			'button_hover_radius',
			[
				'label'      => esc_html__( 'Hover Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_style' => ['style-8'],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_hover_shadow',
				'selector' => '{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap:hover',
				'condition' => [
					'button_style' => ['style-8'],
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		$this->start_controls_section(
            'section_call_to_action_styling',
            [
                'label' => esc_html__('Call To Action(CTA)', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
			'section_call_to_action_styling_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
			]
		);
		$this->end_controls_section();
		/*button style*/
		/*Ribbon Style*/
		$this->start_controls_section(
            'section_ribbon_pin_styling',
            [
                'label' => esc_html__('Ribbon/Pin', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'display_ribbon_pin' => 'yes',
				],
            ]
        );
		$this->add_control(
			'section_ribbon_pin_styling_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
			]
		);

		$this->end_controls_section();
		/*Ribbon Style*/
		/*background option*/
		$this->start_controls_section(
            'section_bg_option_styling',
            [
                'label' => esc_html__('Background Options', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_responsive_control(
			'bg_padding',
			[
				'label' => esc_html__( 'Inner Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .plus-pricing-table.pricing-style-1 .pricing-table-inner,{{WRAPPER}} .plus-pricing-table.pricing-style-2 .pricing-table-inner,{{WRAPPER}} .plus-pricing-table.pricing-style-3 .pricing-top-part' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'box_border',
			[
				'label' => esc_html__( 'Box Border', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'no',
			]
		);
		$this->start_controls_tabs( 'tabs_border_style' );
		$this->start_controls_tab(
			'tab_border_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'box_border_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .plus-pricing-table.pricing-style-1 .pricing-table-inner,{{WRAPPER}} .plus-pricing-table.pricing-style-2 .pricing-table-inner,{{WRAPPER}} .plus-pricing-table.pricing-style-3 .pricing-top-part' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'box_border_width',
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
					'{{WRAPPER}} .plus-pricing-table.pricing-style-1 .pricing-table-inner,{{WRAPPER}} .plus-pricing-table.pricing-style-2 .pricing-table-inner,{{WRAPPER}} .plus-pricing-table.pricing-style-3 .pricing-top-part' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .plus-pricing-table.pricing-style-1 .pricing-table-inner,{{WRAPPER}} .plus-pricing-table.pricing-style-2 .pricing-table-inner,{{WRAPPER}} .plus-pricing-table.pricing-style-3 .pricing-top-part' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_border_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'box_border_hover_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .plus-pricing-table.pricing-style-1:hover .pricing-table-inner,{{WRAPPER}} .plus-pricing-table.pricing-style-2:hover .pricing-table-inner,{{WRAPPER}} .plus-pricing-table.pricing-style-3:hover .pricing-top-part' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'border_hover_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .plus-pricing-table.pricing-style-1:hover .pricing-table-inner,{{WRAPPER}} .plus-pricing-table.pricing-style-2:hover .pricing-table-inner,{{WRAPPER}} .plus-pricing-table.pricing-style-3:hover .pricing-top-part' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'background_options',
			[
				'label' => esc_html__( 'Background Options', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'bg_hover_animation',
			[
				'label' => esc_html__( 'Background Hover Animation', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'hover_normal',
				'options' => [
					'hover_normal'  => esc_html__( 'Select Hover Bg Animation', 'tpebl' ),
					'hover_fadein'  => esc_html__( 'FadeIn (Pro)', 'tpebl' ),
					'hover_slide_left' => esc_html__( 'SlideInLeft (Pro)', 'tpebl' ),
					'hover_slide_right' => esc_html__( 'SlideInRight (Pro)', 'tpebl' ),
					'hover_slide_top' => esc_html__( 'SlideInTop (Pro)', 'tpebl' ),
					'hover_slide_bottom' => esc_html__( 'SlideInBotton (Pro)', 'tpebl' ),
				],
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
				'selector'  => '{{WRAPPER}} .plus-pricing-table.pricing-style-1 .pricing-table-inner',
				
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_background_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'box_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .plus-pricing-table.pricing-style-1:hover .pricing-table-inner',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'shadow_options',
			[
				'label' => esc_html__( 'Box Shadow Options', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs( 'tabs_shadow_style' );
		$this->start_controls_tab(
			'tab_shadow_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}} .plus-pricing-table.pricing-style-1 .pricing-table-inner,{{WRAPPER}} .plus-pricing-table.pricing-style-2 .pricing-table-inner,{{WRAPPER}} .plus-pricing-table.pricing-style-3 .pricing-top-part',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_shadow_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_hover_shadow',
				'selector' => '{{WRAPPER}} .plus-pricing-table.pricing-style-1:hover .pricing-table-inner,{{WRAPPER}} .plus-pricing-table.pricing-style-2:hover .pricing-table-inner,{{WRAPPER}} .plus-pricing-table.pricing-style-3:hover .pricing-top-part',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*background option*/
		/*Extra option*/
		$this->start_controls_section(
            'section_extra_options_styling',
            [
                'label' => esc_html__('Extra Effects', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
            'transform_scale',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Scale Zoom', 'tpebl'),
				'default' => [
					'unit' => '',
					'size' => 1,
				],
				'range' => [
					'' => [
						'min'	=> 0.6,
						'max'	=> 1.8,
						'step' => 0.05,
					],
				],
				'render_type' => 'ui',
				'selectors'  => [
					'{{WRAPPER}} .plus-pricing-table.pricing-style-1 .pricing-table-inner,{{WRAPPER}} .plus-pricing-table.pricing-style-2 .pricing-table-inner,{{WRAPPER}} .plus-pricing-table.pricing-style-3 .pricing-top-part' => 'transform: scale({{SIZE}});',
				],
            ]
        );
		$this->end_controls_section();
		/*Extra option*/
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
		$pricing_style = $settings["pricing_table_style"];
		$title_style = $settings["title_style"];
		
		
		/*title */
		$pricing_title = $settings["pricing_title"];
		$title='';
		if(!empty($pricing_title)){
			$title .='<div class="pricing-title-wrap">';
				$title .='<div class="pricing-title">'.esc_attr($pricing_title).'</div>';
			$title .='</div>';
		}
		/*title */
		
		/*subtitle */
		$pricing_subtitle = $settings["pricing_subtitle"];
		$subtitle='';
		if(!empty($pricing_subtitle)){
			$subtitle .='<div class="pricing-subtitle-wrap">';
				$subtitle .='<div class="pricing-subtitle">'.esc_attr($pricing_subtitle).'</div>';
			$subtitle .='</div>';
		}
		/*subtitle */
		
		/* Icon content */
		$icons_content='';
		$image_icon=$settings["image_icon"];
		if($image_icon == 'image'){
			if($settings["select_image"]["url"]!=''){
				$image_id=$settings["select_image"]["id"];				
				$imgSrc= tp_get_image_rander( $image_id,'full', [ 'class' => 'pricing-icon-img' ] );
			}else{
				$imgSrc = '';
			}
			$icons_content='<div class="pricing-icon">'.$imgSrc.'</div>';
		}
		
		$icon_style=$settings["icon_style"];
			if($icon_style == 'square'){
				$service_icon_style = 'icon-squre';
			} 
			if($icon_style == 'rounded'){
				$service_icon_style = 'icon-rounded';
			}
		if($image_icon == 'icon'){
			if($settings["icon_font_style"]=='font_awesome'){
				$icons = $settings["icon_fontawesome"];
			}else{
				$icons = '';
			}
			$icon_bg = tp_bg_lazyLoad($settings['icon_background_image'],$settings['icon_hover_background_image']);
			if(!empty($icons)){
				$icons_content = '<div class="pricing-icon '.esc_attr($service_icon_style).' '.$icon_bg.'"><i class=" '.esc_attr($icons).' "></i></div>';
			}
		}
		$border_stroke_color='none';
		/* Icon content */
		
		/*content description*/
		$content_style = $settings['content_style'];
		$pricing_content ='';
		$i=0;
		if($content_style =='wysiwyg_content' && !empty($settings["content_wysiwyg"])){
			$pricing_content .='<div class="pricing-content-wrap content-desc '.$settings["content_wysiwyg_style"].'">';
				if($settings["content_wysiwyg_style"]=='style-1'){
					$pricing_content .='<hr class="border-line" />';
				}
				$pricing_content .='<div class="pricing-content">';
					$pricing_content .=$settings["content_wysiwyg"];
				$pricing_content .='</div>';
				$pricing_content .= '<div class="content-overlay-bg-color"></div>';
			$pricing_content .='</div>';
		}else if($content_style =='stylist_list'){
			$pricing_content .='<div class="pricing-content-wrap listing-content '.$settings["content_list_style"].'">';
				$pricing_content .='<ul class="plus-icon-list-items">';
					
					foreach ( $settings['icon_list'] as $index => $item ) :
						$repeater_setting_key = $this->get_repeater_setting_key( 'text', 'icon_list', $index );

						$this->add_render_attribute( $repeater_setting_key, 'class', 'plus-icon-list-text' );

						$this->add_inline_editing_attributes( $repeater_setting_key );						
						
						$pricing_content .='<li class="plus-icon-list-item elementor-repeater-item-'.esc_attr($item['_id']).'" data-local="true">';
						
						if ( ! empty( $icons ) ) :
							$pricing_content .='<span class="plus-icon-list-icon">';
							$pricing_content .='</span>';
						endif;
						$pricing_content .='<span '.$this->get_render_attribute_string( $repeater_setting_key ).'>'.$item["list_description"].'</span>';						
						$pricing_content .='</li>';
						$i++;
					endforeach;						
				$pricing_content .='</ul>';				
				
				if($settings["content_list_style"]=='style-1'){
					$pricing_content .= '<div class="content-overlay-bg-color"></div>';
				}
			$pricing_content .='</div>';
		}
		/*content description*/
		
		/*Previous Price*/
		$previous_price_content='';
		if(!empty($settings['show_previous_price']) && $settings['show_previous_price']=='yes'){
			$previous_price_prefix = $settings["previous_price_prefix"];
			$previous_price = $settings["previous_price"];
			$previous_price_postfix = $settings["previous_price_postfix"];
			$previous_price_content .='<span class="pricing-previous-price-wrap">'.$previous_price_prefix.$previous_price.$previous_price_postfix.'</span>';			
		}
		/*Previous Price*/
		
		/*Price content*/
		$price_style=$settings["price_style"];
		$price_prefix = $settings["price_prefix"];
		$price = $settings["price"];
		$price_postfix = $settings["price_postfix"];
		
		$price_content ='<div class="pricing-price-wrap '.$price_style.'">';
			$price_content .= $previous_price_content;
			if(!empty($price_prefix)){
				$price_content .='<span class="price-prefix-text">'.$price_prefix.'</span>';
			}
			if(!empty($price)){
				$price_content .='<span class="pricing-price">'.$price.'</span>';
			}
			if(!empty($price_postfix)){
				$price_content .='<span class="price-postfix-text">'.$price_postfix.'</span>';
			}
		$price_content .='</div>';
		/*Price content*/
		
		/* button */
		$the_button='';
		if($settings['display_button'] == 'yes'){
		if ( ! empty( $settings['button_link']['url'] ) ) {
			$this->add_render_attribute( 'button', 'href', $settings['button_link']['url'] );
			if ( $settings['button_link']['is_external'] ) {
				$this->add_render_attribute( 'button', 'target', '_blank' );
			}
			if ( $settings['button_link']['nofollow'] ) {
				$this->add_render_attribute( 'button', 'rel', 'nofollow' );
			}
		}
		$btn_bg = tp_bg_lazyLoad($settings['button_background_image'],$settings['button_hover_background_image']);
		$this->add_render_attribute( 'button', 'class', 'button-link-wrap'.$btn_bg );
		$this->add_render_attribute( 'button', 'role', 'button' );
		
		$button_style = $settings['button_style'];
		$button_text = $settings['button_text'];
		$btn_uid=uniqid('btn');
		$data_class= $btn_uid;
		$data_class .=' button-'.$button_style.' ';
		
		$the_button ='<div class="pt-plus-button-wrapper">';
			$the_button .='<div class="button_parallax">';
				$the_button .='<div class="ts-button">';
					$the_button .='<div class="pt_plus_button '.$data_class.'">';
						$the_button .= '<div class="animted-content-inner">';
							$the_button .='<a '.$this->get_render_attribute_string( "button" ).'>';
							$the_button .= $this->render_text();
							$the_button .='</a>';
						$the_button .='</div>';
					$the_button .='</div>';
				$the_button .='</div>';
			$the_button .='</div>';
		$the_button .='</div>';
		}
		/* button */
		
		$title_style_content='';
		if($settings["title_style"]=='style-1'){
				$title_style_content .='<div class="pricing-title-content style-1">';
					$title_style_content .=$icons_content;
					$title_style_content .=$title;
					$title_style_content .=$subtitle;
				$title_style_content .='</div>';
		}
		
		$pricing_output='';
		if($pricing_style=='style-1'){
			$pricing_output .= $title_style_content;
			$pricing_output .= $price_content;
			$pricing_output .= $the_button;
			$pricing_output .= $pricing_content;
			$pricing_output .= '<div class="pricing-overlay-color"></div>';			
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
			
			
			$output = '<div id="plus-pricing-table" class="plus-pricing-table pricing-'.esc_attr($pricing_style).' '.esc_attr($animated_class).'" '.$animation_attr.'>';
				$pt_bg = tp_bg_lazyLoad($settings['box_background_image'],$settings['box_hover_background_image']);
				$output .= '<div class="pricing-table-inner '.$pt_bg.'">';
					$output .= $pricing_output;
				$output .='</div>';
				
			$output .='</div>';
		echo $output;
	}
	
    protected function content_template() {
	
    }
	protected function render_text() {	
		$icons_after=$icons_before='';
		$settings = $this->get_settings_for_display();
		
		$button_style = $settings['button_style'];
		$before_after = $settings['before_after'];
		$button_text = $settings['button_text'];
		
		if($settings["button_icon_style"]=='font_awesome'){
			$icons=$settings["button_icon"];
		}else{
			$icons='';
		}
		if($before_after=='before' && !empty($icons)){
			$icons_before = '<i class="btn-icon button-before '.esc_attr($icons).'"></i>';
		}
		if($before_after=='after' && !empty($icons)){
		   $icons_after = '<i class="btn-icon button-after '.esc_attr($icons).'"></i>';
		}
		
		if($button_style=='style-8'){
			$button_text =$icons_before . $button_text . $icons_after;
		}		
		return $button_text;
	}
}