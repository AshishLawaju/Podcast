<?php 
/*
Widget Name: Button
Description: creative of button style.
Author: Theplus
Author URI: https://posimyth.com
*/
namespace TheplusAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Box_Shadow;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class L_ThePlus_Button extends Widget_Base {
		
	public function get_name() {
		return 'tp-button';
	}

    public function get_title() {
        return esc_html__('TP Button', 'tpebl');
    }

    public function get_icon() {
        return 'fa fa-link theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-essential');
    }
	
    protected function _register_controls() {
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
            'button_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Button Style', 'tpebl'),
                'default' => 'style-1',
                'options' => [
                    'style-1' => esc_html__('Style 1', 'tpebl'),
                    'style-2' => esc_html__('Style 2 (PRO)', 'tpebl'),
                    'style-3' => esc_html__('Style 3 (PRO)', 'tpebl'),
                    'style-4' => esc_html__('Style 4', 'tpebl'),
                    'style-5' => esc_html__('Style 5 (PRO)', 'tpebl'),
                    'style-6' => esc_html__('Style 6 (PRO)', 'tpebl'),
                    'style-7' => esc_html__('Style 7 (PRO)', 'tpebl'),
					'style-8' => esc_html__('Style 8', 'tpebl'),
					'style-9' => esc_html__('Style 9 (PRO)', 'tpebl'),
					'style-10' => esc_html__('Style 10 (PRO)', 'tpebl'),
					'style-11' => esc_html__('Style 11', 'tpebl'),
					'style-12' => esc_html__('Style 12', 'tpebl'),
					'style-13' => esc_html__('Style 13', 'tpebl'),
					'style-14' => esc_html__('Style 14 (PRO)', 'tpebl'),
					'style-15' => esc_html__('Style 15 (PRO)', 'tpebl'),
					'style-16' => esc_html__('Style 16 (PRO)', 'tpebl'),
					'style-17' => esc_html__('Style 17 (PRO)', 'tpebl'),
					'style-18' => esc_html__('Style 18 (PRO)', 'tpebl'),
					'style-19' => esc_html__('Style 19 (PRO)', 'tpebl'),
					'style-20' => esc_html__('Style 20', 'tpebl'),
					'style-21' => esc_html__('Style 21 (PRO)', 'tpebl'),
					'style-22' => esc_html__('Style 22 (PRO)', 'tpebl'),
					'style-24' => esc_html__('Style 23 (PRO)', 'tpebl'),
                ],
            ]
        );
		$this->add_control(
			'button_text',
			[
				'label' => esc_html__( 'Text', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Read More', 'tpebl' ),
				'placeholder' => esc_html__( 'Read More', 'tpebl' ),
			]
		);		
		$this->add_control(
			'button_hover_text',
			[
				'label' => esc_html__( 'Hover Text', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [
					'active' => true,
				],
				'default' => esc_html__( 'Click Here', 'tpebl' ),
				'placeholder' => esc_html__( 'Click Here', 'tpebl' ),
				'condition' => [
					'button_style' => ['style-4','style-11','style-14'],
				],
			]
		);
		$this->add_control(
			'button_link',
			[
				'label' => esc_html__( 'Link', 'tpebl' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'separator' => 'before',
				'placeholder' => esc_html__( 'https://www.demo-link.com', 'tpebl' ),
				'default' => [
					'url' => '#',
				],
			]
		);	
		$this->add_control(
			'button_custom_attributes',
			[
				'label'     => __( 'Add Custom Attributes', 'tpebl' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'tpebl' ),
				'label_off'    => esc_html__( 'No', 'tpebl' ),
				'default' => 'no',
			]
		);
		$this->add_control(
			'button_custom_attributes_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'button_custom_attributes' => [ 'yes' ],
				],
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
            'section_button_styling',
            [
                'label' => esc_html__('Layout', 'tpebl'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
		$this->add_responsive_control(
			'button_align',
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
			]
		);
				
		$this->add_control(
            'btn_hover_style', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Button Style', 'tpebl'),
                'default' => 'hover-left',
                'options' => [
                    'hover-left' => esc_html__('On Left', 'tpebl'),
                    'hover-right' => esc_html__('On Right', 'tpebl'),
                    'hover-top' => esc_html__('On Top', 'tpebl'),
                    'hover-bottom' => esc_html__('On Bottom', 'tpebl'),
                ],
				'condition' => [
					'button_style' => ['style-11','style-13'],
				],
            ]
        );
		$this->end_controls_section();
		$this->start_controls_section(
            'section_button_icon_styling',
            [
                'label' => esc_html__('Icon Settings', 'tpebl'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
		$this->add_control(
			'button_icon_style',
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
					'button_style!' => ['style-3','style-6','style-7','style-9'],
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
					'button_style!' => ['style-3','style-6','style-7','style-9'],
					'button_icon_style' => 'font_awesome',
				],
			]
		);
		$this->add_control(
			'button_icon_5',
			[
				'label' => esc_html__( 'Icon Library', 'tpebl' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-plus',
					'library' => 'solid',
				],
				'condition' => [
					'button_style!' => ['style-3','style-6','style-7','style-9'],
					'button_icon_style' => 'font_awesome_5',
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
					'button_style!' => ['style-3','style-6','style-7','style-9','style-17'],
					'button_icon_style!' => '',
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
					'button_style!' => ['style-3','style-6','style-7','style-9','style-17'],
					'button_icon_style!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .button-link-wrap i.button-after' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .button-link-wrap i.button-before' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 200,
					],
				],
				'separator' => 'before',
				'condition' => [
					'button_style!' => ['style-3','style-6','style-7','style-9','style-17'],
					'button_icon_style!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .button-link-wrap i.btn-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
            'section_extra_styling',
            [
                'label' => esc_html__('Extra', 'tpebl'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
		$this->add_control(
			'section_extra_styling_options',
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
            'section_styling',
            [
                'label' => esc_html__('Typography and Cosmetics', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );		
		$this->add_responsive_control(
			'button_padding',
			[
				'label' => esc_html__( 'Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],
				'default' => [
							'top' => '15',
							'right' => '30',
							'bottom' => '15',
							'left' => '30',
							'isLinked' => false 
				],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_button:not(.button-style-11):not(.button-style-17) .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap > span,{{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap::before,.pt_plus_button.button-style-17 .button-link-wrap > span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt_plus_button.button-style-4 .button-link-wrap,
								{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap,
								{{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap,
								{{WRAPPER}} .pt_plus_button.button-style-20 .button-link-wrap',				
				'condition' => [
					'button_style!' => ['style-1','style-6','style-7','style-9','style-12','style-13'],
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
					'{{WRAPPER}} .pt_plus_button.button-style-4 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-12 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-13 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-20 .button-link-wrap' => 'border-style: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [
					'button_style' => ['style-4','style-8','style-11','style-12','style-13','style-20'],
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
					'{{WRAPPER}} .pt_plus_button.button-style-4 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-12 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-13 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-20 .button-link-wrap' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_style' => ['style-4','style-8','style-11','style-12','style-13','style-20'],
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
					'{{WRAPPER}} .pt_plus_button.button-style-4 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-12 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-13 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-20 .button-link-wrap' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .pt_plus_button.button-style-18 .button-link-wrap' => 'background: {{VALUE}};',
				],
				'condition' => [
					'button_style' => ['style-4','style-8','style-11','style-12','style-13','style-20'],
					'button_border_style!' => 'none'
				],
			]
		);

		$this->add_responsive_control(
			'button_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_button.button-style-4 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-12 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-13 .button-link-wrap,{{WRAPPER}} .pt_plus_button.button-style-20 .button-link-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_style' => ['style-4','style-8','style-11','style-12','style-13','style-20'],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .pt_plus_button.button-style-4 .button-link-wrap,
							   {{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap,
							   {{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap,
							   {{WRAPPER}} .pt_plus_button.button-style-12 .button-link-wrap,
							   {{WRAPPER}} .pt_plus_button.button-style-13 .button-link-wrap,
							   {{WRAPPER}} .pt_plus_button.button-style-20 .button-link-wrap',
				'condition' => [
					'button_style' => ['style-4','style-8','style-11','style-12','style-13','style-20'],
				],
			]
		);
		$this->add_control(
			'btn_bottom_border_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'button_style' => 'style-1',
				],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_button .button-link-wrap .button_line' => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_control(
            'bottom_border_height',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Border Height', 'tpebl'),
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 1,
				],
				'range' => [
					'px' => [
						'min'	=> 1,
						'max'	=> 20,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'condition' => [
					'button_style' => 'style-1',
				],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_button .button-link-wrap .button_line' => 'height: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap::before' => 'color: {{VALUE}};',					
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_hover_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt_plus_button.button-style-4 .button-link-wrap::after,
								{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap:hover,
								{{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap::before,
								{{WRAPPER}} .pt_plus_button.button-style-12 .button-link-wrap::before,
								{{WRAPPER}} .pt_plus_button.button-style-13 .button-link-wrap::before,{{WRAPPER}} .pt_plus_button.button-style-13 .button-link-wrap::after,
								{{WRAPPER}} .pt_plus_button.button-style-20 .button-link-wrap:after,',
				'condition' => [
					'button_style!' => ['style-1','style-6','style-7','style-9'],
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
					'{{WRAPPER}} .pt_plus_button.button-style-4 .button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_button.button-style-12 .button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_button.button-style-13 .button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_button.button-style-20 .button-link-wrap:hover' => 'border-color: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [
					'button_style' => ['style-4','style-8','style-11','style-12','style-13','style-20'],
					'button_border_style!' => 'none'
				],
			]
		);

		$this->add_responsive_control(
			'button_hover_radius',
			[
				'label'      => esc_html__( 'Hover Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_button.button-style-4 .button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_button.button-style-12 .button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_button.button-style-13 .button-link-wrap:hover,
					{{WRAPPER}} .pt_plus_button.button-style-20 .button-link-wrap:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_style' => ['style-4','style-8','style-11','style-12','style-13','style-20'],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_hover_shadow',
				'selector' => '{{WRAPPER}} .pt_plus_button.button-style-4 .button-link-wrap:hover,
							   {{WRAPPER}} .pt_plus_button.button-style-8 .button-link-wrap:hover,
							   {{WRAPPER}} .pt_plus_button.button-style-11 .button-link-wrap:hover,
							   {{WRAPPER}} .pt_plus_button.button-style-12 .button-link-wrap:hover,
							   {{WRAPPER}} .pt_plus_button.button-style-13 .button-link-wrap:hover,
							   {{WRAPPER}} .pt_plus_button.button-style-20 .button-link-wrap:hover,',
				'condition' => [
					'button_style' => ['style-4','style-8','style-11','style-12','style-13','style-20'],
				],
			]
		);
		$this->add_control(
			'btn_bottom_border_hover_color',
			[
				'label' => esc_html__( 'Border Hover Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'button_style' => 'style-1',
				],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_button .button-link-wrap:hover .button_line' => 'background: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		
		$this->start_controls_section(
            'section_extra_effect_styling',
            [
                'label' => esc_html__('Special', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
			'btn_magic_scroll',
			[
				'label'        => esc_html__( 'Magic Scroll', 'tpebl' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'tpebl' ),
				'label_off'    => esc_html__( 'No', 'tpebl' ),
				'render_type'  => 'template',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'plus_pro_magic_scroll_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'btn_magic_scroll' => [ 'yes' ],
				],
			]
		);		
		$this->add_control(
			'plus_tooltip',
			[
				'label'        => esc_html__( 'Tooltip', 'tpebl' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'tpebl' ),
				'label_off'    => esc_html__( 'No', 'tpebl' ),
				'render_type'  => 'template',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'plus_pro_tooltip_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'plus_tooltip' => [ 'yes' ],
				],
			]
		);		
		$this->add_control(
            'btn_special_effect',
            [
				'label'   => esc_html__( 'Special Effect', 'tpebl' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'plus_pro_overlay_effect_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'btn_special_effect' => [ 'yes' ],
				],
			]
		);
		$this->add_control(
			'plus_mouse_move_parallax',
			[
				'label'        => esc_html__( 'Mouse Move Parallax', 'tpebl' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'tpebl' ),
				'label_off'    => esc_html__( 'No', 'tpebl' ),			
				'render_type'  => 'template',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'plus_pro_mouse_move_parallax_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'plus_mouse_move_parallax' => [ 'yes' ],
				],
			]
		);
		$this->add_control(
			'plus_continuous_animation',
			[
				'label'        => esc_html__( 'Continuous Animation', 'tpebl' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'tpebl' ),
				'label_off'    => esc_html__( 'No', 'tpebl' ),					
				'render_type'  => 'template',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'plus_pro_continuous_animation_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'plus_continuous_animation' => [ 'yes' ],
				],
			]
		);
		$this->add_control(
            'full_width_btn',
            [
				'label'   => esc_html__( 'Full-Width Button', 'tpebl' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'btn_hover_effects',
			[
				'label'   => esc_html__( 'Button Hover Effects', 'tpebl' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'separator' => 'before',
				'options' => l_theplus_get_content_hover_effect_options(),
			]
		);		
		$this->add_control(
            'shake_animate',
            [
				'label'   => esc_html__( 'Interval Shake Animate', 'tpebl' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'shake_animate_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'shake_animate' => [ 'yes' ],
				],
			]
		);
		$this->end_controls_section();
		
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
		$hover_class=$full_button_width=$data_class=$button_hover_text='';
		
		
		
		$hover_class = '';		
		$btn_hover_effects=$settings["btn_hover_effects"];
		if ($btn_hover_effects == "push") {
			$hover_class .= 'content_hover_push';
		}
		
		if ( ! empty( $settings['button_link']['url'] ) ) {
			$this->add_render_attribute( 'button', 'href', $settings['button_link']['url'] );
			if ( $settings['button_link']['is_external'] ) {
				$this->add_render_attribute( 'button', 'target', '_blank' );
			}
			if ( $settings['button_link']['nofollow'] ) {
				$this->add_render_attribute( 'button', 'rel', 'nofollow' );
			}
		}
		
		$this->add_render_attribute( 'button', 'class', 'button-link-wrap' );
		$this->add_render_attribute( 'button', 'role', 'button' );
					
		if(!empty($settings['button_hover_text'])){
			$this->add_render_attribute( 'button', 'data-hover', $settings['button_hover_text'] );
		}else{
			$this->add_render_attribute( 'button', 'data-hover', $settings['button_text'] );
		}
		$button_style = $settings['button_style'];
		$button_align=' text-'.$settings['button_align'];
		$button_align .=(!empty($settings['button_align_tablet'])) ? ' text--tablet'.$settings['button_align_tablet'] : '';
		$button_align .=(!empty($settings['button_align_mobile'])) ? ' text--mobile'.$settings['button_align_mobile'] : '';
		$btn_hover_style = $settings['btn_hover_style'];
		$button_text = $settings['button_text'];
		$button_hover_text = $settings['button_hover_text'];
		$uid=uniqid('btn');
		$data_class= $uid;
		$data_class .=' button-'.$button_style.' ';
		
		if($button_style=='style-11' || $button_style=='style-13'){
			$data_class .=' '.$btn_hover_style.' ';
		}
		
		if(!empty($settings['full_width_btn']) && $settings['full_width_btn']=='yes'){
			$data_class .=' full-button ';
			$full_button_width=' full-button ';
		}
		if(!empty($settings['transition_hover']) && $settings['transition_hover']=='yes'){
			$data_class .=' trnasition_hover ';
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
				
		$uid_button=uniqid("button");		
		
		$the_button ='<div class="pt-plus-button-wrapper  '.esc_attr($button_align).'">';
			$the_button .='<div class="button_parallax '.esc_attr($full_button_width).'">';			
				$the_button .='<div id="'.esc_attr($uid_button).'"  class="'.esc_attr($button_align).' ts-button content_hover_effect ' . esc_attr($hover_class) . ' '.esc_attr($full_button_width).' " >';
					$the_button .='<div class="pt_plus_button '.$data_class.' '.$animated_class.' " '.$animation_attr.'>';
						$the_button .= '<div class="animted-content-inner ">';
							$the_button .='<a '.$this->get_render_attribute_string( "button" ).' >';
							$the_button .= $this->render_text();
							$the_button .='</a>';
						$the_button .='</div>';
					$the_button .='</div>';
				$the_button .='</div>';			
			$the_button .='</div>';
		$the_button .='</div>';
		
		echo $the_button;
	}
    protected function content_template() {
	
    }
	
	protected function render_text() {	
		$icons_after=$icons_before=$button_text=$style_content='';
		$settings = $this->get_settings_for_display();		
		$button_style = $settings['button_style'];
		$before_after = $settings['before_after'];
		$button_text = $settings['button_text'];
		
		if($settings["button_icon_style"]=='font_awesome'){
			$icons=$settings["button_icon"];
		}else if($settings["button_icon_style"]=='font_awesome_5'){
			ob_start();
			\Elementor\Icons_Manager::render_icon( $settings['button_icon_5'], [ 'aria-hidden' => 'true' ]);
			$icons = ob_get_contents();
			ob_end_clean();
		}else{
			$icons='';
		}
		
		if($before_after=='before' && !empty($icons)){
			if(!empty($settings["button_icon_style"]) && $settings["button_icon_style"]=='font_awesome_5'){
				$icons_before = '<span class="btn-icon button-before">'.$icons.'</span>';
			}else{
				$icons_before = '<i class="btn-icon button-before '.esc_attr($icons).'"></i>';
			}			
		}
		if($before_after=='after' && !empty($icons)){
			if(!empty($settings["button_icon_style"]) && $settings["button_icon_style"]=='font_awesome_5'){
				 $icons_after = '<span class="btn-icon button-after">'.$icons.'</span>';
			}else{
				 $icons_after = '<i class="btn-icon button-after '.esc_attr($icons).'"></i>';
			}		  
		}
		
		if($button_style=='style-1'){
			$button_text =$icons_before.$button_text . $icons_after;
			$style_content='<div class="button_line"></div>';
		}
		if($button_style=='style-8'){
			$button_text =$icons_before . $button_text . $icons_after;
		}
		if($button_style=='style-4'){
			$button_text =$icons_before.$button_text . $icons_after;
		}		
		if($button_style=='style-11'){
			$button_text ='<span>'.$icons_before . $button_text . $icons_after.'</span>';
		}
		if($button_style=='style-12' || $button_style=='style-15' || $button_style=='style-16'){
			$button_text ='<span>'.$icons_before . $button_text . $icons_after.'</span>';
		}
		if($button_style=='style-13'){
			$button_text ='<span>'.$icons_before . $button_text . $icons_after.'</span>';			
		}
		if($button_style=='style-20'){
			$button_text =$icons_before .'<span>'. esc_html($button_text) .'</span>'. $icons_after;
		}
		return $button_text.$style_content;
	}
}
