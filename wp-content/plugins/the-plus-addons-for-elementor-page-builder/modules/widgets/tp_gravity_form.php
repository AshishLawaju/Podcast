<?php 
/*
Widget Name: Gravity Form
Description: Third party plugin Gravity Form style.
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
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class L_ThePlus_Gravity_Form extends Widget_Base {
		
	public function get_name() {
		return 'tp-gravityt-form';
	}

    public function get_title() {
        return esc_html__('Gravity Form', 'tpebl');
    }

    public function get_icon() {
        return 'fa fa-envelope-o theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-adapted');
    }
		
    protected function _register_controls() {
		/*Layout Content start*/
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Gravity Form', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);		
		$this->add_control(
			'gravity_form',
			[
				'label' => esc_html__( 'Select Form', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'options' => l_theplus_gravity_form(),
				'condition' => [
					'select' => 'gf_default',
				],
			]
		);
		$this->add_control(
			'gravity_form_dm',
			[
				'label' => esc_html__( 'Select Form', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'options' => l_theplus_gravity_form_using_dm(),
				'condition' => [
					'select' => 'gf_dmp',
				],
			]
		);
		$this->add_control(
		    'title_hide',
		    [
				'label'   => esc_html__( 'Title', 'tpebl' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'separator' => 'before',
		    ]
		);
		$this->add_control(
		    'ajax',
		    [
				'label'   => esc_html__( 'Ajax Form Submit', 'tpebl' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'separator' => 'before',
		    ]
		);
		$this->end_controls_section();		
		/*Layout Content end*/
		
		/*extra options start*/
		$this->start_controls_section(
			'extra_options_section',
			[
				'label' => esc_html__( 'Extra Options', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'select',
			[
				'label' => esc_html__( 'Compatibility', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'gf_default',
				'options' => [
					'gf_default'  => esc_html__( 'Gravity Form', 'tpebl' ),
					'gf_dmp' => esc_html__( 'Download Monitor', 'tpebl' ),
				],
			]
		);
		$this->end_controls_section();
		/*extra options end*/
		
		/*form heading start*/
		$this->start_controls_section(
			'section_style_form_heading',
			[
				'label' => esc_html__( 'Form Heading & Description', 'tpebl' ),
				'tab'   => Controls_Manager::TAB_STYLE,				
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'form_heading_typography',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gform_heading .gform_title',				
			]
		);
		$this->add_control(
			'form_heading_color',
			[
				'label' => esc_html__( 'Form Heading', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gform_heading .gform_title' => 'color: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'form_h_desc_typ',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gform_heading .gform_description',				
			]
		);
		$this->add_control(
			'form_h_desc_color',
			[
				'label' => esc_html__( 'Description', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gform_heading .gform_description' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(		
  			'form_h_desc_bottom_space',		
  			[		
  				'label' => esc_html__( 'Bottom space', 'tpebl' ),		
  				'type' => Controls_Manager::SLIDER,		
				'size_units' => [ 'px'],		
				'range' => [		
					'px' => [		
						'min' => 1,		
						'max' => 100,		
					],		
				],		
				'selectors' => [		
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gform_description' => 'margin-bottom: {{SIZE}}{{UNIT}};',		
				],		
  			]		
  		);		
		$this->add_control(			
		'form_heading_align',		
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
				'separator' => 'before',		
				'selectors' => [		
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gform_heading' => 'text-align:{{VALUE}};',		
				],		
				'toggle' => true,		
			]		
		);
		$this->end_controls_section();
		/*form heading end*/
		
		/*heading styling start*/		
		$this->start_controls_section(
			'section_style_head',
			[
				'label' => esc_html__( 'Heading Styling', 'tpebl' ),
				'tab'   => Controls_Manager::TAB_STYLE,				
			]
		);
		$this->add_responsive_control(		
  			'f_head_bottom_space',		
  			[		
  				'label' => esc_html__( 'Bottom space', 'tpebl' ),		
  				'type' => Controls_Manager::SLIDER,		
				'size_units' => [ 'px'],		
				'range' => [		
					'px' => [		
						'min' => 1,		
						'max' => 100,		
					],		
				],		
				'selectors' => [		
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gsection' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',		
				],		
  			]		
  		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'f_head_typography',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gsection_title',
			]
		);
		$this->add_control(
			'f_head_color',
			[
				'label' => esc_html__( 'Heading Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gsection_title' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		/*heading end*/
		
		/*label styling start*/		
		$this->start_controls_section(
			'section_style_label',
			[
				'label' => esc_html__( 'Label Styling', 'tpebl' ),
				'tab'   => Controls_Manager::TAB_STYLE,				
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_typography',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield_label,
				{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_full label,
				{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_left label,
				{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_right label,
				{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .address_city label,
				{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .address_zip label,
				{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .address_country label',
			]
		);
		$this->add_control(
			'label_color',
			[
				'label' => esc_html__( 'Label Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield_label,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_full label,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_left label,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_right label,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .address_city label,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .address_zip label,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .address_country label' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'inline_sub_label_head',
			[
				'label' => esc_html__( 'Sub Label', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'inline_sub_label_typography',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .name_prefix label,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .name_first label,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .name_middle label,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .name_last label,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .name_suffix label,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container.ginput_container_email label',
			]
		);
		$this->add_control(
			'inline_sub_label_color',
			[
				'label' => esc_html__( 'Sub Label Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .name_prefix label,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .name_first label,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .name_middle label,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .name_last label,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .name_suffix label,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container.ginput_container_email label' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'sub_label_desc_typography',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield_description,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper span.gf_step_number,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gsection_description,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper span.ginput_product_price_label,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper span.ginput_quantity_label',
			]
		);
		$this->add_control(
			'sub_label_color',
			[
				'label' => esc_html__( 'Description Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield_description,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper span.gf_step_number,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gsection_description,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper span.ginput_product_price_label,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper span.ginput_quantity_label' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'max_char_color',
			[
				'label' => esc_html__( 'Max Character Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .charleft.ginput_counter' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'req_symbol_color',
			[
				'label' => esc_html__( 'Required Symbol', 'tpebl' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield_required' => 'color: {{VALUE}}',
				],
			]
		);		
		$this->add_responsive_control(
  			'progress_bar_size',
  			[
  				'label' => esc_html__( 'Progress Bar Text Size', 'tpebl' ),
  				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 1500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper h3.gf_progressbar_title' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
  			]
  		);	
		$this->add_control(
			'progress_bar_text_color',
			[
				'label' => esc_html__( 'Progress Bar Text', 'tpebl' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [					
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper h3.gf_progressbar_title' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_responsive_control(
  			'progress_bar_border_size',
  			[
  				'label' => esc_html__( 'Progress Bar Border Size', 'tpebl' ),
  				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 1500,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gf_progressbar' => 'padding: {{SIZE}}{{UNIT}};',
				],
  			]
  		);
		
		$this->add_control(
			'progress_bar_color',
			[
				'label' => esc_html__( 'Progress Bar Border', 'tpebl' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [					
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gf_progressbar' => 'background-color: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);
		$this->add_control(
			'price_color',
			[
				'label' => esc_html__( 'Price', 'tpebl' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [					
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_product_price,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_shipping_price,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper span.ginput_total' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'consent_color',
			[
				'label' => esc_html__( 'consent', 'tpebl' ),
				'type' => Controls_Manager::COLOR,				
				'selectors' => [					
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield_consent_label' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_section();
		/*label styling end*/
		/*Input Field Style*/
		$this->start_controls_section(
			'section_style_input',
			[
				'label' => esc_html__( 'Input Fields Styling', 'tpebl' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'input_typography',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="text"],
				{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper select,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="email"],{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="tel"],{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="url"]',
			]
		);
		$this->add_control(
			'input_placeholder_color',
			[
				'label'     => esc_html__( 'Placeholder Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input::-webkit-input-placeholder,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper  select::-webkit-input-placeholder' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'input_inner_padding',
			[
				'label' => esc_html__( 'Inner Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container input[type="text"],{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container select,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="email"],{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="tel"],{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="url"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->add_responsive_control(
			'input_inner_margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container input[type="text"],{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container select,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="email"],{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="tel"],{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="url"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->start_controls_tabs( 'tabs_input_field_style' );
		$this->start_controls_tab(
			'tab_input_field_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_control(
			'input_field_color',
			[
				'label'     => esc_html__( 'Text Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container input[type="text"],
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container select,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="email"],{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="tel"],{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="url"]' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'input_field_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container input[type="text"],
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container select,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="email"],{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="tel"],{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="url"]',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_input_field_focus',
			[
				'label' => esc_html__( 'Focus', 'tpebl' ),
			]
		);
		$this->add_control(
			'input_field_focus_color',
			[
				'label'     => esc_html__( 'Text Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container input[type="text"]:focus,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container select:focus,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="email"]:focus,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="tel"]:focus,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="url"]:focus' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'input_field_focus_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container input[type="text"]:focus,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container select:focus,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="email"]:focus,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="tel"]:focus,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="url"]:focus',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'input_border_options',
			[
				'label' => esc_html__( 'Border Options', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
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
		
		$this->add_control(
			'border_style',
			[
				'label' => esc_html__( 'Border Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => l_theplus_get_border_style(),
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container input[type="text"],
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container select,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="email"],{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="tel"],{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="url"]' => 'border-style: {{VALUE}};',
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
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container input[type="text"],
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container select,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="email"],{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="tel"],{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="url"]' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'box_border' => 'yes',
				],
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
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container input[type="text"],
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container select,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="email"],{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="tel"],{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="url"]' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container input[type="text"],
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container select,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="email"],{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="tel"],{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="url"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'label' => esc_html__( 'Focus', 'tpebl' ),
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
				'default' => '',
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container input[type="text"]:focus,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container select:focus,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="email"]:focus,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="tel"]:focus,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="url"]:focus' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container input[type="text"]:focus,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container select:focus,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="email"]:focus,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="tel"]:focus,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="url"]:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'box_border' => 'yes',
				],
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
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container input[type="text"],
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container select,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="email"],{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="tel"],{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="url"]',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_shadow_hover',
			[
				'label' => esc_html__( 'Focus', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_active_shadow',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container input[type="text"]:focus,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container select:focus,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="email"]:focus,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="tel"]:focus,{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="url"]:focus',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Input Field Style*/		
		/*textarea field start*/
		$this->start_controls_section(
			'section_style_textarea',
			[
				'label' => esc_html__( 'Textarea Fields Styling', 'tpebl' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'textarea_inner_padding',
			[
				'label' => esc_html__( 'Inner Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->add_responsive_control(
			'textarea_inner_margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container textarea' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'textarea_typography',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container textarea',
			]
		);
		$this->add_control(
			'textarea_placeholder_color',
			[
				'label'     => esc_html__( 'Placeholder Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container  textarea::-webkit-input-placeholder' => 'color: {{VALUE}};',
				],
			]
		);
			$this->start_controls_tabs( 'tabs_textarea_field_style' );
				$this->start_controls_tab(
					'tab_textarea_field_normal',
					[
						'label' => esc_html__( 'Normal', 'tpebl' ),
					]
				);
				$this->add_control(
					'textarea_field_color',
					[
						'label'     => esc_html__( 'Text Color', 'tpebl' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container textarea' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'      => 'textarea_field_bg',
						'types'     => [ 'classic', 'gradient' ],
						'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container textarea',
					]
				);
				$this->end_controls_tab();
				
				$this->start_controls_tab(
					'tab_textarea_field_focus',
					[
						'label' => esc_html__( 'Focus', 'tpebl' ),
					]
				);
				$this->add_control(
					'textarea_field_focus_color',
					[
						'label'     => esc_html__( 'Text Color', 'tpebl' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container textarea:focus' => 'color: {{VALUE}};',
						],
					]
				);
				$this->add_group_control(
					Group_Control_Background::get_type(),
					[
						'name'      => 'textarea_field_focus_bg',
						'types'     => [ 'classic', 'gradient' ],
						'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container textarea:focus',
					]
				);
				$this->end_controls_tab();
		$this->end_controls_tabs();	
		
		$this->add_control(
			'textarea_border_options',
			[
				'label' => esc_html__( 'Border Options', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'ta_box_border',
			[
				'label' => esc_html__( 'Box Border', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'no',
			]
		);
		$this->add_control(
			'ta_border_style',
			[
				'label' => esc_html__( 'Border Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => l_theplus_get_border_style(),
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container textarea' => 'border-style: {{VALUE}};',
				],
				'condition' => [
					'ta_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'ta_box_border_width',
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
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container textarea' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'ta_box_border' => 'yes',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_ta_border_style' );
				$this->start_controls_tab(
					'tab_ta_border_normal',
					[
						'label' => esc_html__( 'Normal', 'tpebl' ),
						'condition' => [
							'ta_box_border' => 'yes',
						],
					]
				);
				$this->add_control(
					'ta_box_border_color',
					[
						'label' => esc_html__( 'Border Color', 'tpebl' ),
						'type' => Controls_Manager::COLOR,				
						'selectors'  => [
							'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container textarea' => 'border-color: {{VALUE}};',
						],
						'condition' => [
							'ta_box_border' => 'yes',
						],
					]
				);
				$this->add_responsive_control(
					'ta_border_radius',
					[
						'label'      => esc_html__( 'Border Radius', 'tpebl' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%' ],
						'selectors'  => [
							'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						'condition' => [
							'ta_box_border' => 'yes',
						],
					]
				);
				$this->end_controls_tab();
				
				$this->start_controls_tab(
					'tab_ta_border_hover',
					[
						'label' => esc_html__( 'Focus', 'tpebl' ),
						'condition' => [
							'ta_box_border' => 'yes',
						],
					]
				);
				$this->add_control(
					'ta_box_border_hover_color',
					[
						'label' => esc_html__( 'Border Color', 'tpebl' ),
						'type' => Controls_Manager::COLOR,
						'default' => '',
						'selectors'  => [
							'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container textarea:focus' => 'border-color: {{VALUE}};',
						],
						'condition' => [
							'ta_box_border' => 'yes',
						],
					]
				);
				$this->add_responsive_control(
					'ta_border_hover_radius',
					[
						'label'      => esc_html__( 'Border Radius', 'tpebl' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%' ],
						'selectors'  => [
							'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container textarea:focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						'condition' => [
							'ta_box_border' => 'yes',
						],
					]
				);
				$this->end_controls_tab();
				$this->end_controls_tabs();
				$this->add_control(
					'ta_shadow_options',
					[
						'label' => esc_html__( 'Box Shadow Options', 'tpebl' ),
						'type' => Controls_Manager::HEADING,
						'separator' => 'before',
					]
				);
		$this->start_controls_tabs( 'tabs_ta_shadow_style' );
		$this->start_controls_tab(
			'tab_ta_shadow_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'ta_box_shadow',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container textarea',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_ta_shadow_hover',
			[
				'label' => esc_html__( 'Focus', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'ta_box_active_shadow',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container textarea:focus',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();		
		$this->end_controls_section();
		/*textarea field end*/
		/*select field start*/
		$this->start_controls_section(
			'section_style_select',
			[
				'label' => esc_html__( 'Select Fields Styling', 'tpebl' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'section_style_select_height',
			[
				'label' => esc_html__( 'Height Auto', 'tpebl' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => __( 'Enable', 'tpebl' ),
				'label_off' => __( 'Disable', 'tpebl' ),
				'default' => 'no',
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container select' => 'height: auto;',
				],
			]
		);
		$this->add_responsive_control(
			'section_style_select_padding',
			[
				'label' => esc_html__( 'Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_container select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		/*select field end*/
		/*Checkbox/Radio Field Style*/
		$this->start_controls_section(
            'section_checked_styling',
            [
                'label' => esc_html__('CheckBox/Radio Field', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		
		$this->start_controls_tabs( 'tabs_checkbox_field_style' );
		$this->start_controls_tab(
			'tab_unchecked_field_bg',
			[
				'label' => esc_html__( 'Check Box', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'checkbox_text_typography',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield_checkbox li label',
			]
		);
		
		$this->add_control(
			'checked_field_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield_checkbox li label' => 'color: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);
		$this->add_responsive_control(
  			'checkbox_typography',
  			[
  				'label' => esc_html__( 'Icon Size', 'tpebl' ),
  				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_checkbox span.gravity_checkbox_label:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],
  			]
  		);	
		$this->add_control(
			'checked_uncheck_color',
			[
				'label'     => esc_html__( 'UnChecked Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_checkbox span.gravity_checkbox_label:before' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'checked_field_color',
			[
				'label'     => esc_html__( 'Checked Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_checkbox input[type=checkbox]:checked + label span.gravity_checkbox_label:before' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'unchecked_field_bgcolor',
			[
				'label'     => esc_html__( 'UnChecked Bg Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_checkbox input[type=checkbox] + label span.gravity_checkbox_label' => 'background: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'checked_field_bgcolor',
			[
				'label'     => esc_html__( 'Checked Bg Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_checkbox input[type=checkbox]:checked + label span.gravity_checkbox_label' => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'check_box_border_options',
			[
				'label' => esc_html__( 'Border Options', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'check_box_border',
			[
				'label' => esc_html__( 'Box Border', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'no',
			]
		);
		
		$this->add_control(
			'check_box_border_style',
			[
				'label' => esc_html__( 'Border Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => l_theplus_get_border_style(),
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_checkbox span.gravity_checkbox_label' => 'border-style: {{VALUE}};',
				],
				'condition' => [
					'check_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'check_box_border_width',
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
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_checkbox span.gravity_checkbox_label' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'check_box_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'unchecked_box_border_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_checkbox span.gravity_checkbox_label' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'check_box_border' => 'yes',
				],
			]
		);
		
		$this->add_responsive_control(
			'unchecked_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_checkbox span.gravity_checkbox_label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'check_box_border' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_radio_field',
			[
				'label' => esc_html__( 'Radio Button', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'radio_text_typography',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield_radio li label',
			]
		);
		$this->add_control(
			'radio_field_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield_radio li label' => 'color: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);
			$this->add_responsive_control(
  			'radio_typography',
  			[
  				'label' => esc_html__( 'Icon Size', 'tpebl' ),
  				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 50,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_radio span.gravity_radio_label:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],
  			]
  		);	
		$this->add_control(
			'radio_uncheck_color',
			[
				'label'     => esc_html__( 'UnChecked Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [					
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_radio span.gravity_radio_label:before' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'radio_field_color',
			[
				'label'     => esc_html__( 'Checked Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [					
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_radio input[type=radio]:checked + label span.gravity_radio_label:before' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'radio_unchecked_field_bgcolor',
			[
				'label'     => esc_html__( 'UnChecked Bg Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_radio input[type=radio] + label span.gravity_radio_label' => 'background: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'radio_checked_field_bgcolor',
			[
				'label'     => esc_html__( 'Checked Bg Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_radio input[type=radio]:checked + label span.gravity_radio_label' => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'radio_border_options',
			[
				'label' => esc_html__( 'Border Options', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'radio_border',
			[
				'label' => esc_html__( 'Box Border', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'no',
			]
		);
		
		$this->add_control(
			'radio_border_style',
			[
				'label' => esc_html__( 'Border Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => l_theplus_get_border_style(),
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_radio span.gravity_radio_label' => 'border-style: {{VALUE}};',
				],
				'condition' => [
					'radio_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'radio_border_width',
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
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_radio span.gravity_radio_label' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'radio_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'radio_unchecked_box_border_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_radio span.gravity_radio_label' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'radio_border' => 'yes',
				],
			]
		);
		
		$this->add_responsive_control(
			'radio_unchecked_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_radio span.gravity_radio_label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'radio_border' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Checkbox/Radio Field Style*/	
		/*file style start*/		
		$this->start_controls_section(
            'section_file_styling',
            [
                'label' => esc_html__('File/Upload Field', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_responsive_control(
			'file_padding',
			[
				'label' => esc_html__( 'Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_fileupload' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'file_margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_fileupload' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'file_typography',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_fileupload input[type="file"]',
			]
		);
		$this->start_controls_tabs( 'tabs_file_style' );
			$this->start_controls_tab(
				'tab_file_normal',
				[
					'label' => esc_html__( 'Normal', 'tpebl' ),
				]
			);
			$this->add_control(
				'file_color',
				[
					'label'     => esc_html__( 'Text Color', 'tpebl' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_fileupload input[type="file"]' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'file_bg_color',
				[
					'label'     => esc_html__( 'Background', 'tpebl' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_fileupload input[type="file"]' => 'background: {{VALUE}};',
					],
				]
			);
			$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'file_border',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_fileupload input[type="file"]',
			]
			);
			$this->add_responsive_control(
				'file_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'tpebl' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_fileupload input[type="file"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'file_shadow',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_fileupload input[type="file"]',
			]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'tab_file_hover',
				[
					'label' => esc_html__( 'Hover', 'tpebl' ),
				]
			);
			$this->add_control(
				'file_color_hover',
				[
					'label'     => esc_html__( 'Text Color', 'tpebl' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_fileupload input[type="file"]:hover' => 'color: {{VALUE}};',
					],
				]
			);
			$this->add_control(
				'file_bg_color_hover',
				[
					'label'     => esc_html__( 'Background', 'tpebl' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_fileupload input[type="file"]:hover' => 'background: {{VALUE}};',
					],
				]
			);
			$this->add_control(
			'file_border_color_hover',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_fileupload input[type="file"]:hover' => 'border-color: {{VALUE}};',
				],
			]
		);		
			$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'file_hover_shadow',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .ginput_container_fileupload input[type="file"]:hover',
			]
			);
			$this->end_controls_tab();
		$this->end_controls_tabs();
		
		$this->add_control(
			'enable_multi_file_upload',
			[
				'label' => esc_html__( 'Enable Multi-File Upload', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'multi_file_upload_switch',
			[
				'label' => esc_html__( 'Multi-File Upload Style', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'no',
			]
		);
		$this->add_responsive_control(
  			'multi_file_upload_text_typo',
  			[
  				'label' => esc_html__( 'Text Size', 'tpebl' ),
  				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input.button.gform_button_select_files' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'multi_file_upload_switch' => 'yes',
				],
  			]
  		);
		$this->start_controls_tabs( 'tabs_multi_file_upload_style' );
			$this->start_controls_tab(
				'multi_file_upload_normal',
				[
					'label' => esc_html__( 'Normal', 'tpebl' ),
					'condition' => [
						'multi_file_upload_switch' => 'yes',
					],
				]
			);
				$this->add_control(
					'mfu_color_normal',
					[
						'label'     => esc_html__( 'Text Color', 'tpebl' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input.button.gform_button_select_files' => 'color: {{VALUE}};',
						],
						'condition' => [
							'multi_file_upload_switch' => 'yes',
						],
					]
				);
				$this->add_control(
					'mfu_bg_normal',
					[
						'label'     => esc_html__( 'Background', 'tpebl' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input.button.gform_button_select_files' => 'background: {{VALUE}};',
						],
						'condition' => [
							'multi_file_upload_switch' => 'yes',
						],
					]
				);
				$this->add_responsive_control(
					'mfu_border_radius',
					[
						'label'      => esc_html__( 'Border Radius', 'tpebl' ),
						'type'       => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%' ],
						'selectors'  => [
							'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input.button.gform_button_select_files' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
						'condition' => [
							'multi_file_upload_switch' => 'yes',
						],
					]
				);
			$this->end_controls_tab();
				$this->start_controls_tab(
					'multi_file_upload_hover',
					[
						'label' => esc_html__( 'Hover', 'tpebl' ),
						'condition' => [
							'multi_file_upload_switch' => 'yes',
						],
					]
				);
				$this->add_control(
					'mfu_color_hover',
					[
						'label'     => esc_html__( 'Text Color', 'tpebl' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input.button.gform_button_select_files:hover' => 'color: {{VALUE}};',
						],
						'condition' => [
							'multi_file_upload_switch' => 'yes',
						],
					]
				);
				$this->add_control(
					'mfu_bg_hover',
					[
						'label'     => esc_html__( 'Background', 'tpebl' ),
						'type'      => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input.button.gform_button_select_files:hover' => 'background: {{VALUE}};',
						],
						'condition' => [
							'multi_file_upload_switch' => 'yes',
						],
					]
				);
				$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*file style end*/		
		/*button Style start*/
		$this->start_controls_section(
            'section_button_styling',
            [
                'label' => esc_html__('Submit/Next/Previous Button', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_responsive_control(
            'button_max_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Width', 'tpebl'),
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 2000,
						'step' => 5,
					],
					'%' => [
						'min' => 10,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="button"],
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="submit"]' => 'width: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'after',
            ]
        );
		$this->add_responsive_control(
			'content_align',
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
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gform_footer' => 'text-align: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="button"],
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="submit"]',
			]
		);
		$this->add_responsive_control(
			'button_inner_padding',
			[
				'label' => esc_html__( 'Inner Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="button"],
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'button_margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="button"],
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="submit"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
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
			'button_color',
			[
				'label'     => esc_html__( 'Button Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gform_button.button' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'button_bg',
			[
				'label'     => esc_html__( 'Button Background', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gform_button.button' => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'nxt_button_color',
			[
				'label'     => esc_html__( 'Next Button Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gform_next_button' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'nxt_button_bg',
			[
				'label'     => esc_html__( 'Next Button Background', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gform_next_button' => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'pre_button_color',
			[
				'label'     => esc_html__( 'Previous Button Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gform_previous_button' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'pre_button_bg',
			[
				'label'     => esc_html__( 'Previous Button Background', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gform_previous_button' => 'background: {{VALUE}};',
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
			'button_color_hover',
			[
				'label'     => esc_html__( 'Button Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gform_button.button:hover' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'button_bg_hover',
			[
				'label'     => esc_html__( 'Button Background', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gform_button.button:hover' => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'nxt_button_hover_color',
			[
				'label'     => esc_html__( 'Next Button Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gform_next_button:hover' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'nxt_button_hover_bg',
			[
				'label'     => esc_html__( 'Next Button Background', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gform_next_button:hover' => 'background: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'pre_button_hover_color',
			[
				'label'     => esc_html__( 'Previous Button Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gform_previous_button:hover' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'pre_button_hover_bg',
			[
				'label'     => esc_html__( 'Previous Button Background', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gform_previous_button:hover' => 'background: {{VALUE}};',
				],
			]
		);	
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'button_border_options',
			[
				'label' => esc_html__( 'Border Options', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'button_box_border',
			[
				'label' => esc_html__( 'Box Border', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'no',
			]
		);
		
		$this->add_control(
			'button_border_style',
			[
				'label' => esc_html__( 'Border Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => l_theplus_get_border_style(),
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="button"],
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="submit"]' => 'border-style: {{VALUE}};',
				],
				'condition' => [
					'button_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'button_box_border_width',
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
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="button"],
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="submit"]' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_box_border' => 'yes',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_button_border_style' );
		$this->start_controls_tab(
			'tab_button_border_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
				'condition' => [
					'button_box_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'button_box_border_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="button"],
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="submit"]' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_box_border' => 'yes',
				],
			]
		);
		
		$this->add_responsive_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="button"],
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'button_box_border' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_button_border_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
				'condition' => [
					'button_box_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'button_box_border_hover_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="button"]:hover,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="submit"]:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'button_border_hover_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="button"]:hover,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="submit"]:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'condition' => [
					'button_box_border' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'button_shadow_options',
			[
				'label' => esc_html__( 'Box Shadow Options', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs( 'tabs_button_shadow_style' );
		$this->start_controls_tab(
			'tab_button_shadow_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_shadow',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="button"],
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="submit"]',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_button_shadow_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_hover_shadow',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="button"]:hover,
					{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper input[type="submit"]:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Send/Submit Button Style*/	
		/*outer Style start*/
		$this->start_controls_section(
            'section_oute_r_styling',
            [
                'label' => esc_html__('Outer Field', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_responsive_control(
			'oute_r_inner_margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper ul li.gfield' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		$this->add_responsive_control(
			'oute_r_inner_padding',
			[
				'label' => esc_html__( 'Inner Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper ul li.gfield' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->start_controls_tabs( 'tabs_oute_r' );
			$this->start_controls_tab(
				'oute_r_normal',
				[
					'label' => esc_html__( 'Normal', 'tpebl' ),
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'oute_r_field_bg',
					'types'     => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper ul li.gfield',
				]
			);
			$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'oute_r__border',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper ul li.gfield',				
			]
			);
			$this->add_responsive_control(
				'oute_r_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'tpebl' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper ul li.gfield' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'oute_r_shadow',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper ul li.gfield',
			]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'oute_r_hover',
				[
					'label' => esc_html__( 'Hover', 'tpebl' ),
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'oute_r_field_bg_hover',
					'types'     => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper ul li.gfield:hover',
				]
			);
			$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'oute_r__border_hover',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper ul li.gfield:hover',
			]
			);
			$this->add_responsive_control(
				'oute_r_border_radius_hover',
				[
					'label'      => esc_html__( 'Border Radius', 'tpebl' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper ul li.gfield:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'oute_r_shadow_hover',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper ul li.gfield:hover',
			]
			);
			$this->end_controls_tab();
		$this->end_controls_tabs();	
		$this->end_controls_section();
		/*outer Style end*/
		/*form container start*/		
		$this->start_controls_section(
            'section_form_container',
            [
                'label' => esc_html__('Form Container', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		
		$this->add_responsive_control(
			'form_cont_padding',
			[
				'label' => esc_html__( 'Inner Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		$this->add_responsive_control(
			'form_cont_margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->start_controls_tabs( 'tabs_form_container' );
			$this->start_controls_tab(
				'form_normal',
				[
					'label' => esc_html__( 'Normal', 'tpebl' ),
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'form_bg',
					'types'     => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper',
				]
			);
			$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'form_border',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper',				
			]
			);
			$this->add_responsive_control(
				'form_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'tpebl' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'form_shadow',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper',
			]
			);
			$this->end_controls_tab();
			$this->start_controls_tab(
				'form_hover',
				[
					'label' => esc_html__( 'Hover', 'tpebl' ),
				]
			);
			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'form_bg_hover',
					'types'     => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper:hover',
				]
			);
			$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'form_border_hover',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper:hover',
			]
			);
			$this->add_responsive_control(
				'form_border_radius_hover',
				[
					'label'      => esc_html__( 'Border Radius', 'tpebl' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'form_shadow_hover',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper:hover',
			]
			);
			$this->end_controls_tab();
			$this->end_controls_tabs();	
		$this->end_controls_section();	
		/*form container end*/
		/*response message start*/
		$this->start_controls_section(
            'section_response_message',
            [
                'label' => esc_html__('Response Message', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		
		$this->start_controls_tabs( 'tabs_response_style' );
		$this->start_controls_tab(
			'tab_response_success',
			[
				'label' => esc_html__( 'Success', 'tpebl' ),
			]
		);		
		$this->add_responsive_control(
			'response_success_margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_confirmation_wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'response_success_padding',
			[
				'label' => esc_html__( 'Inner Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_confirmation_wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'response_success_typography',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_confirmation_wrapper',
			]
		);
		$this->add_control(
			'response_success_color',
			[
				'label'     => esc_html__( 'Text Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_confirmation_wrapper' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'response_success_bg',
					'types'     => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_confirmation_wrapper',
				]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'response_success_border',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gform_confirmation_wrapper',
			]
		);
		$this->add_responsive_control(
			'response_success_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_confirmation_wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_response_validation',
			[
				'label' => esc_html__( 'Validation/Error', 'tpebl' ),
			]
		);
		$this->add_responsive_control(
			'response_validation_padding',
			[
				'label' => esc_html__( 'Inner Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gfield_description.validation_message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				
			]
		);
		$this->add_responsive_control(
			'response_validation_margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gfield_description.validation_message' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'response_validation_typography',
				'selector' => '{{WRAPPER}} .pt_plus_gravity_form .gfield_description.validation_message',
			]
		);
		$this->add_control(
			'response_validation_color',
			[
				'label'     => esc_html__( 'Text Color/Field Border', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gform_wrapper .validation_message,{{WRAPPER}} .gform_wrapper div.validation_error' => 'color: {{VALUE}};',
					'{{WRAPPER}} .gform_wrapper li.gfield_error input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .gform_wrapper li.gfield_error textarea' => 'border-color: {{VALUE}};',
					
					
					'{{WRAPPER}} .gform_wrapper div.validation_error' => 'border-top-color: {{VALUE}}; border-bottom-color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'response_validation_bg',
			[
				'label'     => esc_html__( 'Background', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .gform_wrapper li.gfield.gfield_error,{{WRAPPER}} .gform_wrapper li.gfield.gfield_error.gfield_contains_required.gfield_creditcard_warning' => 'background: {{VALUE}};',
				],
			]
		);		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'response_validation_border',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} .gform_wrapper li.gfield.gfield_error,{{WRAPPER}} .gform_wrapper li.gfield.gfield_error.gfield_contains_required.gfield_creditcard_warning',
			]
		);
		$this->add_responsive_control(
			'response_validation_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .gform_wrapper li.gfield.gfield_error,{{WRAPPER}} .gform_wrapper li.gfield.gfield_error.gfield_contains_required.gfield_creditcard_warning' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*response message end */
		/*extra option*/
		$this->start_controls_section(
            'section_extra_option_styling',
            [
                'label' => esc_html__('Extra Option', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_responsive_control(
            'content_max_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Maximum Width', 'tpebl'),
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 250,
						'max' => 2000,
						'step' => 5,
					],
					'%' => [
						'min' => 10,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper' => 'max-width: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->add_responsive_control(
			'captcha_margin',
			[
				'label' => esc_html__( 'Captcha Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_gravity_form .gform_wrapper .gfield .ginput_recaptcha' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
		/*extra option*/
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
	
	private function get_shortcode() {
		$settings = $this->get_settings();

		if (!$settings['gravity_form'] && (!empty($settings['select']) && $settings['select']=='gf_default')) {
			return '<h3 class="theplus-posts-not-found">'.esc_html__('Please select Gravity Form', 'tpebl').'</h3>';
		}
		
		if (!$settings['gravity_form_dm'] && (!empty($settings['select']) && $settings['select']=='gf_dmp')) {
			return '<h3 class="theplus-posts-not-found">'.esc_html__('Please select Download Monitor Form', 'tpebl').'</h3>';
		}
		
		if((!empty($settings['select']) && $settings['select']=='gf_dmp') && !empty($settings['gravity_form_dm'])){
			$attributes = [
				'id'          => $settings['gravity_form_dm'],		
			];
		}else{		
			$attributes = [
				'id'          => $settings['gravity_form'],
				'title'       => $settings['title_hide'] ? 'true' : 'false',
				'description'       => $settings['title_hide'] ? 'true' : 'false',			
				'ajax'       => !empty($settings['ajax']) ? 'true' : 'false',			
			];
		}

		$this->add_render_attribute( 'shortcode', $attributes );

		$shortcode   = [];
		if((!empty($settings['select']) && $settings['select']=='gf_dmp') && !empty($settings['gravity_form_dm'])){			
			$shortcode[] = sprintf( '[dlm_gf_form download_id = '.$settings['gravity_form_dm'].']', $this->get_render_attribute_string( 'shortcode' ) );
		}else{
			$shortcode[] = sprintf( '[gravityform %s]', $this->get_render_attribute_string( 'shortcode' ) );
		}

		return implode("", $shortcode);
	}

	public function render() {	
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
	
		$output = '<div class="pt_plus_gravity_form '.$animated_class.'" '.$animation_attr.'>';
		$output .= do_shortcode($this->get_shortcode());
		$output .= '</div>';
		echo $output;
	}	
}