<?php 
/*
Widget Name: Contact Form 7
Description: Third party plugin contact form 7 style.
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


class L_ThePlus_Contact_Form_7 extends Widget_Base {
		
	public function get_name() {
		return 'tp-contact-form-7';
	}

    public function get_title() {
        return esc_html__('Contact Form 7', 'tpebl');
    }

    public function get_icon() {
        return 'fa fa-envelope theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-adapted');
    }
	
    protected function _register_controls() {
		/*Layout Content*/
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'contact_form',
			[
				'label' => esc_html__( 'Select Form', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'options' => l_theplus_get_contact_form_post(),
			]
		);
		$this->add_control(
			'form_style',
			[
				'label' => esc_html__( 'Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => l_theplus_get_style_list(1),
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
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
			]
		);
		$this->end_controls_section();
		/*Layout Content*/
		/*Extra option*/
		$this->start_controls_section(
			'extra_content_section',
			[
				'label' => esc_html__( 'Extra Options', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'outer_field_class',
			[
				'label' => esc_html__( 'Outer Section Styling', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'label',
				'options' => [
					'label'  => esc_html__( 'Default Label Field', 'tpebl' ),
					'custom'  => esc_html__( 'Custom Class (.tp-cf7-outer)', 'tpebl' ),
				],
				'description' => esc_html__( 'For Outer Section you can select styling option values to Label or to Custom class.','tpebl'),
			]
		);
		$this->end_controls_section();
		/*Extra option*/		
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
				'selector' => '{{WRAPPER}} .theplus-contact-form .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file)',
			]
		);
		$this->add_control(
			'input_placeholder_color',
			[
				'label'     => esc_html__( 'Placeholder Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-contact-form .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file)::placeholder' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .theplus-contact-form .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .theplus-contact-form .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .theplus-contact-form .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file)' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'input_field_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .theplus-contact-form .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file)',
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
					'{{WRAPPER}} .theplus-contact-form .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file):focus' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'input_field_focus_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .theplus-contact-form .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file):focus',
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
					'{{WRAPPER}} .theplus-contact-form .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file)' => 'border-style: {{VALUE}};',
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
					'{{WRAPPER}} .theplus-contact-form .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file)' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			]
		);
		$this->add_control(
			'box_border_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file)' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .theplus-contact-form .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_border_hover',
			[
				'label' => esc_html__( 'Focus', 'tpebl' ),
			]
		);
		$this->add_control(
			'box_border_hover_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file):focus' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .theplus-contact-form .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file):focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .theplus-contact-form .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file)',
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
				'selector' => '{{WRAPPER}} .theplus-contact-form .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file):focus',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Input Field Style*/
		/*Textarea Style*/
		$this->start_controls_section(
            'section_textarea_styling',
            [
                'label' => esc_html__('TextArea (Message) Field', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'textarea_typography',
				'selector' => '{{WRAPPER}} .theplus-contact-form textarea.wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file)',
			]
		);
		$this->add_control(
			'textarea_placeholder_color',
			[
				'label'     => esc_html__( 'Placeholder Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-contact-form textarea.wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file)::placeholder' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'textarea_inner_padding',
			[
				'label' => esc_html__( 'Inner Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .theplus-contact-form textarea.wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .theplus-contact-form textarea.wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
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
					'{{WRAPPER}} .theplus-contact-form textarea.wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file)' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'textarea_field_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .theplus-contact-form textarea.wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file)',
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
					'{{WRAPPER}} .theplus-contact-form textarea.wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file):focus' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'textarea_field_focus_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .theplus-contact-form textarea.wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file):focus',
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
			'textarea_box_border',
			[
				'label' => esc_html__( 'Box Border', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'no',
			]
		);
		
		$this->add_control(
			'textarea_border_style',
			[
				'label' => esc_html__( 'Border Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => l_theplus_get_border_style(),
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form textarea.wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file)' => 'border-style: {{VALUE}};',
				],
				'condition' => [
					'textarea_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'textarea_box_border_width',
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
					'{{WRAPPER}} .theplus-contact-form textarea.wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file)' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'textarea_box_border' => 'yes',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_textarea_border_style' );
		$this->start_controls_tab(
			'tab_textarea_border_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_control(
			'textarea_box_border_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form textarea.wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file)' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'textarea_box_border' => 'yes',
				],
			]
		);
		
		$this->add_responsive_control(
			'textarea_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form textarea.wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_textarea_border_hover',
			[
				'label' => esc_html__( 'Focus', 'tpebl' ),
			]
		);
		$this->add_control(
			'textarea_box_border_hover_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form textarea.wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file):focus' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'textarea_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'textarea_border_hover_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form textarea.wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file):focus' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'textarea_shadow_options',
			[
				'label' => esc_html__( 'Box Shadow Options', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs( 'tabs_textarea_shadow_style' );
		$this->start_controls_tab(
			'tab_textarea_shadow_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'textarea_box_shadow',
				'selector' => '{{WRAPPER}} .theplus-contact-form textarea.wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file)',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_textarea_shadow_hover',
			[
				'label' => esc_html__( 'Focus', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'textarea_box_active_shadow',
				'selector' => '{{WRAPPER}} .theplus-contact-form textarea.wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):not(.wpcf7-file):focus',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Textarea Style*/
		/*Checkbox Field Style*/
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
				'name' => 'checkbox_typography',
				'selector' => '{{WRAPPER}} .theplus-contact-form span.wpcf7-form-control-wrap .input__checkbox_btn',
			]
		);
		$this->add_control(
			'checked_field_color',
			[
				'label'     => esc_html__( 'Checked Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-contact-form .input__checkbox_btn .toggle-button__icon:after' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'unchecked_field_bgcolor',
			[
				'label'     => esc_html__( 'UnChecked Bg Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-contact-form .input__checkbox_btn .toggle-button__icon' => 'background: {{VALUE}};',
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
					'{{WRAPPER}} .theplus-contact-form .input__checkbox_btn .toggle-button__icon:after' => 'background: {{VALUE}};',
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
					'{{WRAPPER}} .theplus-contact-form .input__checkbox_btn .toggle-button__icon' => 'border-style: {{VALUE}};',
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
					'{{WRAPPER}} .theplus-contact-form .input__checkbox_btn .toggle-button__icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form .input__checkbox_btn .toggle-button__icon' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .theplus-contact-form .input__checkbox_btn .toggle-button__icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_checked_field_bg',
			[
				'label' => esc_html__( 'Radio Button', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'radio_typography',
				'selector' => '{{WRAPPER}} .theplus-contact-form span.wpcf7-form-control-wrap .input__radio_btn',
			]
		);
		$this->add_control(
			'radio_field_color',
			[
				'label'     => esc_html__( 'Checked Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-contact-form .input__radio_btn .toggle-button__icon:after' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'radio_unchecked_field_bgcolor',
			[
				'label'     => esc_html__( 'UnChecked Bg Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-contact-form .input__radio_btn .toggle-button__icon' => 'background: {{VALUE}};',
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
					'{{WRAPPER}} .theplus-contact-form .input__radio_btn .toggle-button__icon:after' => 'background: {{VALUE}};',
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
					'{{WRAPPER}} .theplus-contact-form .input__radio_btn .toggle-button__icon' => 'border-style: {{VALUE}};',
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
					'{{WRAPPER}} .theplus-contact-form .input__radio_btn .toggle-button__icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form .input__radio_btn .toggle-button__icon' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .theplus-contact-form .input__radio_btn .toggle-button__icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Checkbox/Radio Field Style*/
		
		/*Choose File Field Style*/
		$this->start_controls_section(
            'section_choose_file_styling',
            [
                'label' => esc_html__('File/Upload Field', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'file_label_typography',
				'selector' => '{{WRAPPER}} .theplus-contact-form .wpcf7-file + .input__file_btn',
			]
		);
		$this->add_responsive_control(
			'file_field_min_height',
			[
				'label' => esc_html__( 'Min Height Field', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 600,
						'step' => 2,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .theplus-contact-form span.wpcf7-form-control-wrap.your-file.cf7-style-file' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'file_text_field_color',
			[
				'label'     => esc_html__( 'Text Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'default' => '#212121',
				'selectors' => [
					'{{WRAPPER}} .theplus-contact-form span.wpcf7-form-control-wrap.cf7-style-file .input__file_btn span' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'file_icon_field_color',
			[
				'label'     => esc_html__( 'Icon Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'default' => '#212121',
				'selectors' => [
					'{{WRAPPER}} .theplus-contact-form span.wpcf7-form-control-wrap.cf7-style-file .input__file_btn svg *' => 'fill: {{VALUE}};stroke:none;',
				],
				'separator' => 'after',
			]
		);
		$this->add_control(
			'file_field_align',
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
					'flex-end' => [
						'title' => esc_html__( 'Right', 'tpebl' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'toggle' => true,
				'label_block' => false,
				'selectors' => [
					'{{WRAPPER}} .theplus-contact-form span.wpcf7-form-control-wrap.cf7-style-file' => '-webkit-justify-content: {{VALUE}};-ms-flex-pack: {{VALUE}};justify-content: {{VALUE}};',
					'{{WRAPPER}} .theplus-contact-form span.wpcf7-form-control-wrap.cf7-style-file span' => 'text-align: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'file_field_style',
			[
				'label' => esc_html__( 'Style', 'tpebl' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'block' => [
						'title' => esc_html__( 'Style 1', 'tpebl' ),
						'icon' => 'fa fa-arrows-v',
					],
				],
				'default' => 'center',
				'toggle' => true,
				'label_block' => false,
				'selectors' => [
					'{{WRAPPER}} .theplus-contact-form span.wpcf7-form-control-wrap.cf7-style-file .input__file_btn svg,{{WRAPPER}} .theplus-contact-form span.wpcf7-form-control-wrap.cf7-style-file span' => 'display:{{VALUE}};margin: 0 auto;text-align:center;',
				],
				'separator' => 'after',
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'file_field_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .theplus-contact-form span.wpcf7-form-control-wrap.cf7-style-file .wpcf7-file + .input__file_btn',
			]
		);
		$this->add_control(
			'file_border_options',
			[
				'label' => esc_html__( 'Border Options', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'file_box_border',
			[
				'label' => esc_html__( 'Box Border', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'no',
			]
		);
		
		$this->add_control(
			'file_border_style',
			[
				'label' => esc_html__( 'Border Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => l_theplus_get_border_style(),
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form .cf7-style-file .wpcf7-file + .input__file_btn' => 'border-style: {{VALUE}};',
				],
				'condition' => [
					'file_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'file_box_border_width',
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
					'{{WRAPPER}} .theplus-contact-form .cf7-style-file .wpcf7-file + .input__file_btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'file_box_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'file_box_border_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form .cf7-style-file .wpcf7-file + .input__file_btn' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'file_box_border' => 'yes',
				],
			]
		);
		
		$this->add_responsive_control(
			'file_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form .cf7-style-file .wpcf7-file + .input__file_btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		/*Choose File Field Style*/
		/*Outer Field Style*/
		$this->start_controls_section(
            'section_outer_styling',
            [
                'label' => esc_html__('Outer(Field) Styling', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'outer_typography',
				'selector' => '{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-label form.wpcf7-form  label,{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-custom form.wpcf7-form .tp-cf7-outer',
			]
		);
		
		$this->add_responsive_control(
			'outer_inner_padding',
			[
				'label' => esc_html__( 'Inner Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-label form.wpcf7-form  label,{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-custom form.wpcf7-form .tp-cf7-outer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->add_responsive_control(
			'outer_inner_margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-label form.wpcf7-form  label,{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-custom form.wpcf7-form .tp-cf7-outer' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->start_controls_tabs( 'tabs_outer_field_style' );
		$this->start_controls_tab(
			'tab_outer_field_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_control(
			'outer_field_color',
			[
				'label'     => esc_html__( 'Text Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-label form.wpcf7-form  label,{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-custom form.wpcf7-form .tp-cf7-outer' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'outer_field_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-label form.wpcf7-form  label,{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-custom form.wpcf7-form .tp-cf7-outer',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_outer_field_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_control(
			'outer_field_focus_color',
			[
				'label'     => esc_html__( 'Text Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-label form.wpcf7-form  label:hover,{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-custom form.wpcf7-form .tp-cf7-outer:hover' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'outer_field_focus_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-label form.wpcf7-form  label:hover,{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-custom form.wpcf7-form .tp-cf7-outer:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'outer_border_options',
			[
				'label' => esc_html__( 'Border Options', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'outer_box_border',
			[
				'label' => esc_html__( 'Box Border', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'no',
			]
		);
		
		$this->add_control(
			'outer_border_style',
			[
				'label' => esc_html__( 'Border Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => l_theplus_get_border_style(),
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-label form.wpcf7-form  label,{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-custom form.wpcf7-form .tp-cf7-outer' => 'border-style: {{VALUE}};',
				],
				'condition' => [
					'outer_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'outer_box_border_width',
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
					'{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-label form.wpcf7-form  label,{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-custom form.wpcf7-form .tp-cf7-outer' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'outer_box_border' => 'yes',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_outer_border_style' );
		$this->start_controls_tab(
			'tab_outer_border_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_control(
			'outer_box_border_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-label form.wpcf7-form  label,{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-custom form.wpcf7-form .tp-cf7-outer' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'outer_box_border' => 'yes',
				],
			]
		);
		
		$this->add_responsive_control(
			'outer_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-label form.wpcf7-form  label,{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-custom form.wpcf7-form .tp-cf7-outer' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_outer_border_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_control(
			'outer_box_border_hover_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-label form.wpcf7-form  label:hover,{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-custom form.wpcf7-form .tp-cf7-outer:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'outer_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'outer_border_hover_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-label form.wpcf7-form  label:hover,{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-custom form.wpcf7-form .tp-cf7-outer:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'outer_shadow_options',
			[
				'label' => esc_html__( 'Box Shadow Options', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs( 'tabs_outer_shadow_style' );
		$this->start_controls_tab(
			'tab_outer_shadow_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'outer_box_shadow',
				'selector' => '{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-label form.wpcf7-form  label,{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-custom form.wpcf7-form .tp-cf7-outer',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_outer_shadow_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'outer_box_active_shadow',
				'selector' => '{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-label form.wpcf7-form  label:hover,{{WRAPPER}} .theplus-contact-form.style-1.plus-cf7-custom form.wpcf7-form .tp-cf7-outer:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Outer Field Style*/
		$this->start_controls_section(
            'section_button_styling',
            [
                'label' => esc_html__('Submit/Send Button', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_responsive_control(
            'button_max_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Maximum Width', 'tpebl'),
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
					'{{WRAPPER}} .theplus-contact-form input.wpcf7-form-control.wpcf7-submit' => 'max-width: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'after',
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .theplus-contact-form input.wpcf7-form-control.wpcf7-submit',
			]
		);
		$this->add_responsive_control(
			'button_inner_padding',
			[
				'label' => esc_html__( 'Inner Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .theplus-contact-form input.wpcf7-form-control.wpcf7-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .theplus-contact-form input.wpcf7-form-control.wpcf7-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'label'     => esc_html__( 'Text Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-contact-form input.wpcf7-form-control.wpcf7-submit' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .theplus-contact-form input.wpcf7-form-control.wpcf7-submit',
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
			'button_hover_color',
			[
				'label'     => esc_html__( 'Text Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-contact-form input.wpcf7-form-control.wpcf7-submit:hover' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'button_hover_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .theplus-contact-form input.wpcf7-form-control.wpcf7-submit:hover',
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
					'{{WRAPPER}} .theplus-contact-form input.wpcf7-form-control.wpcf7-submit' => 'border-style: {{VALUE}};',
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
					'{{WRAPPER}} .theplus-contact-form input.wpcf7-form-control.wpcf7-submit' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			]
		);
		$this->add_control(
			'button_box_border_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form input.wpcf7-form-control.wpcf7-submit' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .theplus-contact-form input.wpcf7-form-control.wpcf7-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_button_border_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_control(
			'button_box_border_hover_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form input.wpcf7-form-control.wpcf7-submit:hover' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .theplus-contact-form input.wpcf7-form-control.wpcf7-submit:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
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
				'selector' => '{{WRAPPER}} .theplus-contact-form input.wpcf7-form-control.wpcf7-submit',
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
				'selector' => '{{WRAPPER}} .theplus-contact-form input.wpcf7-form-control.wpcf7-submit:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Send/Submit Button Style*/
		/*Response Message Style*/
		$this->start_controls_section(
            'section_response_msg_styling',
            [
                'label' => esc_html__('Response Message', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'response_msg_typography',
				'selector' => '{{WRAPPER}} .wpcf7-response-output',
			]
		);
		$this->add_responsive_control(
			'response_msg_padding',
			[
				'label' => esc_html__( 'Inner Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .theplus-contact-form .wpcf7-response-output' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'response_msg_margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%'],
				'selectors' => [
					'{{WRAPPER}} .theplus-contact-form .wpcf7-response-output' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->start_controls_tabs( 'tabs_response_style' );
		$this->start_controls_tab(
			'tab_response_success',
			[
				'label' => esc_html__( 'Success', 'tpebl' ),
			]
		);
		$this->add_control(
			'response_success_color',
			[
				'label'     => esc_html__( 'Text Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-contact-form .wpcf7-response-output.wpcf7-mail-sent-ok' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'response_success_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .theplus-contact-form .wpcf7-response-output.wpcf7-mail-sent-ok',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_response_validate',
			[
				'label' => esc_html__( 'Validation', 'tpebl' ),
			]
		);
		$this->add_control(
			'response_validate_color',
			[
				'label'     => esc_html__( 'Text Color', 'tpebl' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .theplus-contact-form .wpcf7-response-output.wpcf7-validation-errors,{{WRAPPER}} .theplus-contact-form  .wpcf7-response-output.wpcf7-acceptance-missing' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'response_validate_bg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .theplus-contact-form .wpcf7-response-output.wpcf7-validation-errors,{{WRAPPER}} .theplus-contact-form  .wpcf7-response-output.wpcf7-acceptance-missing',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'response_box_border',
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
			'response_border_style',
			[
				'label' => esc_html__( 'Border Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => l_theplus_get_border_style(),
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form .wpcf7-response-output' => 'border-style: {{VALUE}};',
				],
				'condition' => [
					'response_box_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'response_msg_border_width',
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
					'{{WRAPPER}} .theplus-contact-form .wpcf7-response-output' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'response_box_border' => 'yes',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_response_msg' );
		$this->start_controls_tab(
			'tab_response_msg_success',
			[
				'label' => esc_html__( 'Success', 'tpebl' ),
			]
		);
		$this->add_control(
			'success_border_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form .wpcf7-response-output.wpcf7-mail-sent-ok' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'response_box_border' => 'yes',
				],
			]
		);
		
		$this->add_responsive_control(
			'success_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form .wpcf7-response-output.wpcf7-mail-sent-ok' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_response_msg_validate',
			[
				'label' => esc_html__( 'Validation', 'tpebl' ),
			]
		);
		$this->add_control(
			'validate_border_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form .wpcf7-response-output.wpcf7-validation-errors,{{WRAPPER}} .theplus-contact-form  .wpcf7-response-output.wpcf7-acceptance-missing' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'response_box_border' => 'yes',
				],
			]
		);
		
		$this->add_responsive_control(
			'validate_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form .wpcf7-response-output.wpcf7-validation-errors,{{WRAPPER}} .theplus-contact-form  .wpcf7-response-output.wpcf7-acceptance-missing' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Response Message Style*/
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
						'max' => 1000,
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
					'{{WRAPPER}} .theplus-contact-form' => 'max-width: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->add_control(
			'required_field_color',
			[
				'label' => esc_html__( 'Required Text Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form span.wpcf7-form-control-wrap .wpcf7-not-valid-tip' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'required_field_bgcolor',
			[
				'label' => esc_html__( 'Required Background Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors'  => [
					'{{WRAPPER}} .theplus-contact-form span.wpcf7-form-control-wrap .wpcf7-not-valid-tip' => 'background: {{VALUE}}',
					'{{WRAPPER}} .theplus-contact-form span.wpcf7-not-valid-tip:before' => 'border-bottom-color: {{VALUE}}',
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
	private function get_shortcode() {
		$settings = $this->get_settings_for_display();

		if (!$settings['contact_form']) {
			return '<div class="theplus-contact-form-alert">'.esc_html__('Please select a Contact Form From Setting!', 'tpebl').'</div>';
		}

		$attributes = [
			'id'	=> $settings['contact_form'],
		];

		$this->add_render_attribute( 'form_shortcode', $attributes );

		$shortcode   = [];
		$shortcode[] = sprintf( '[contact-form-7 %s]', $this->get_render_attribute_string( 'form_shortcode' ) );

		return implode("", $shortcode);
	}

	public function render() {
		$settings = $this->get_settings_for_display();
		$form_style=$settings["form_style"];
		$outer_field_class=$settings["outer_field_class"];
		
		$content_align=' text-'.$settings['content_align'];
		$content_align_tablet= (!empty($settings['content_align_tablet'])) ? ' text--tablet'.$settings['content_align_tablet'] : '';
		$content_align_mobile=(!empty($settings['content_align_mobile'])) ? ' text--mobile'.$settings['content_align_mobile'] : '';
								
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
			
			$output ='<div class="theplus-contact-form '.esc_attr($form_style).' plus-cf7-'.esc_attr($outer_field_class).' '.esc_attr($content_align).' '.esc_attr($content_align_tablet).' '.esc_attr($content_align_mobile).' '.esc_attr($animated_class).'" '.$animation_attr.'>';
				$output .= do_shortcode( $this->get_shortcode() );				
			$output .= '</div>';
		echo $output;
	}
    protected function content_template() {
	
    }
}
