<?php 
/*
Widget Name: TP Hover card
Description: Hover Card
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
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;

use TheplusAddons\L_Theplus_Element_Load;
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class L_ThePlus_Hovercard extends Widget_Base {
		
	public function get_name() {
		return 'tp-hovercard';
	}

    public function get_title() {
        return esc_html__('Hover Card', 'tpebl');
    }

    public function get_icon() {
        return 'fa fa-square theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-essential');
    }

    protected function _register_controls() {
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Hover Card', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$repeater = new \Elementor\Repeater();
		$repeater->start_controls_tabs( 'tabs_tag_open_close' );

		$repeater->start_controls_tab(
			'tab_open_tag',
			[
				'label' => esc_html__( 'Open', 'tpebl' ),
			]
		);
		$repeater->add_control(
			'open_tag',
			[
				'label' => esc_html__( 'Open Tag', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'div',
				'options' => [
					'div'  => esc_html__( 'Div', 'tpebl' ),
					'span'  => esc_html__( 'Span', 'tpebl' ),					
					'h1' => esc_html__( 'H1', 'tpebl' ),
					'h2' => esc_html__( 'H2', 'tpebl' ),
					'h3' => esc_html__( 'H3', 'tpebl' ),
					'h4' => esc_html__( 'H4', 'tpebl' ),
					'h5' => esc_html__( 'H5', 'tpebl' ),
					'h6' => esc_html__( 'H6', 'tpebl' ),
					'h6' => esc_html__( 'H6', 'tpebl' ),
					'p' => esc_html__( 'p', 'tpebl' ),
					'a' => esc_html__( 'a', 'tpebl' ),
					'none'  => esc_html__( 'None', 'tpebl' ),
				],
			]
		);		
		$repeater->add_control(
			'a_link',
			[
				'label' => esc_html__( 'Link', 'tpebl' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'separator' => 'after',
				'placeholder' => esc_html__( 'https://www.demo-link.com', 'tpebl' ),
				'condition' => [
					'open_tag' => 'a',
				],
			]
		);
		$repeater->add_control(
			'open_tag_class',
			[
				'label' => esc_html__( 'Enter Class', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => ['active'   => true,],
				'condition' => [
					'open_tag!' => 'none',
				],
			]
		);
		$repeater->end_controls_tab();
		$repeater->start_controls_tab(
			'tab_close_tag',
			[
				'label' => esc_html__( 'Close', 'tpebl' ),
			]
		);
		$repeater->add_control(
			'close_tag',
			[
				'label' => esc_html__( 'Close Tag', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'close',
				'options' => [
					'close'  => esc_html__( 'Default', 'tpebl' ),
					'div'  => esc_html__( 'Div', 'tpebl' ),
					'span'  => esc_html__( 'Span', 'tpebl' ),					
					'h1' => esc_html__( 'H1', 'tpebl' ),
					'h2' => esc_html__( 'H2', 'tpebl' ),
					'h3' => esc_html__( 'H3', 'tpebl' ),
					'h4' => esc_html__( 'H4', 'tpebl' ),
					'h5' => esc_html__( 'H5', 'tpebl' ),
					'h6' => esc_html__( 'H6', 'tpebl' ),
					'h6' => esc_html__( 'H6', 'tpebl' ),
					'p' => esc_html__( 'p', 'tpebl' ),
					'a' => esc_html__( 'a', 'tpebl' ),
					'none'  => esc_html__( 'None', 'tpebl' ),
				],
			]
		);
		$repeater->end_controls_tab();
		$repeater->end_controls_tabs();	
		
		$repeater->add_control(
            'content_tag', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Content', 'tpebl'),
                'default' => 'none',
                'options' => [
					'none'  => esc_html__( 'None', 'tpebl' ),
					'text'  => esc_html__( 'Text', 'tpebl' ),
					'image'  => esc_html__( 'Image', 'tpebl' ),
					'html'  => esc_html__( 'HTML', 'tpebl' ),
					'style'  => esc_html__( 'Style', 'tpebl' ),
					'script'  => esc_html__( 'Script', 'tpebl' ),
				],
				'separator' => 'before',
            ]
        );
		$repeater->add_control(
			'text_content',
			[
				'label'     => esc_html__( 'Text', 'tpebl' ),
				'type'      => Controls_Manager::TEXTAREA,
				'dynamic'   => ['active' => true,],
				'default' => esc_html__( 'The Plus', 'tpebl' ),
				'condition' => [
					'content_tag' => 'text',
				],
			]
		);
		$repeater->add_control(
			'media_content',
			[
				'type' => Controls_Manager::MEDIA,
				'label' => esc_html__('Media', 'tpebl'),
				'dynamic' => ['active'   => true,],
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'content_tag' => 'image',
				],
			]
		);
		$repeater->add_control(
			'html_content',
			[
				'label' => esc_html__( 'HTML Content', 'tpebl' ),
				'type' => Controls_Manager::WYSIWYG,				
				'default' => esc_html__( 'I am text block. Click edit button to change this text.', 'tpebl' ),
				'dynamic' => ['active'   => true,],
				'condition' => [
					'content_tag' => 'html',
				],
			]
		);
		$repeater->add_control(
			'style_content',
			[
				'label'     => esc_html__( 'Custom Style', 'tpebl' ),
				'type'      => Controls_Manager::TEXTAREA,
				'dynamic'   => ['active' => true,],
				'default' =>'',
				'condition' => [
					'content_tag' => 'style',
				],
			]
		);
		$repeater->add_control(
			'script_content',
			[
				'label'     => esc_html__( 'Custom Script', 'tpebl' ),
				'type'      => Controls_Manager::TEXTAREA,
				'dynamic'   => ['active' => true,],
				'default' => '',
				'condition' => [
					'content_tag' => 'script',
				],
			]
		);
		$repeater->add_control(
			'style_heading',[
				'label' => esc_html__( 'Style', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition'    => [
					'open_tag!' => 'none',
				],
			]
		);
		$repeater->add_control(
            'position', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Position', 'tpebl'),
                'default' => 'relative',
                'options' => [
					'relative'  => esc_html__( 'Relative', 'tpebl' ),
					'absolute'  => esc_html__( 'Absolute', 'tpebl' ),
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}'=> 'position: {{VALUE}}',
				],
				'condition'    => [
					'open_tag!' => 'none',
				],
            ]
        );
		$repeater->add_control(
            'display', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Display', 'tpebl'),
                'default' => 'initial',
                'options' => [
					'block'  => esc_html__( 'Block', 'tpebl' ),
					'inline-block'  => esc_html__( 'Inline Block', 'tpebl' ),
					'flex'  => esc_html__( 'Flex', 'tpebl' ),
					'inline-flex'  => esc_html__( 'Inline Flex', 'tpebl' ),
					'initial'  => esc_html__( 'Initial', 'tpebl' ),
					'inherit'  => esc_html__( 'Inherit', 'tpebl' ),
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} ' => 'display: {{VALUE}}',
				],
				'condition'    => [
					'open_tag!' => 'none',
				],
            ]
        );
		$repeater->add_control(
            'flex_direction', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Flex Direction', 'tpebl'),
                'default' => 'unset',
                'options' => [
					'column'  => esc_html__( 'column', 'tpebl' ),
					'column-reverse'  => esc_html__( 'column-reverse', 'tpebl' ),
					'row'  => esc_html__( 'row', 'tpebl' ),
					'unset'  => esc_html__( 'unset', 'tpebl' ),
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} ' => 'flex-direction: {{VALUE}}',
				],
				'condition'    => [
					'open_tag!' => 'none',
					'display' => ['flex','inline-flex'],
				],
            ]
        );
		$repeater->add_control(
			'display_alignmet_opt', [
				'label'   => esc_html__( 'Alignment CSS Options', 'tpebl' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'condition' => [
					'open_tag!' => 'none',					
				],
			]
		);
		$repeater->add_control(
			'text_align',
			[
				'label' => esc_html__( 'Text Align', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => [
					'left'  => esc_html__( 'Left', 'tpebl' ),
					'center'  => esc_html__( 'Center', 'tpebl' ),
					'right'  => esc_html__( 'Right', 'tpebl' ),
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} ' => 'text-align:{{VALUE}};',
				],
				'condition' => [
					'open_tag!' => 'none',
					'display_alignmet_opt' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'align_items',
			[
				'label' => esc_html__( 'Align Items', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => [
					'flex-start'  => esc_html__( 'Flex Start', 'tpebl' ),
					'center'  => esc_html__( 'Center', 'tpebl' ),
					'flex-end'  => esc_html__( 'Flex End', 'tpebl' ),
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} ' => 'align-items:{{VALUE}};',
				],
				'condition' => [
					'open_tag!' => 'none',
					'display' => ['flex','inline-flex'],
					'display_alignmet_opt' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'justify_content',
			[
				'label' => esc_html__( 'Justify Content', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => [
					'flex-start'  => esc_html__( 'Flex Start', 'tpebl' ),
					'center'  => esc_html__( 'Center', 'tpebl' ),
					'flex-end'  => esc_html__( 'Flex End', 'tpebl' ),
					'space-around'  => esc_html__( 'Space Around', 'tpebl' ),
					'space-between'  => esc_html__( 'Space Between', 'tpebl' ),
					'space-evenly'  => esc_html__( 'Space Evenly', 'tpebl' ),
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} ' => 'justify-content:{{VALUE}};',
				],
				'condition' => [
					'open_tag!' => 'none',
					'display' => ['flex','inline-flex'],
					'display_alignmet_opt' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'vertical_align',
			[
				'label' => esc_html__( 'Vertical Align', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'middle',
				'options' => [
					'top'  => esc_html__( 'Top', 'tpebl' ),
					'middle'  => esc_html__( 'Middle', 'tpebl' ),
					'bottom'  => esc_html__( 'Bottom', 'tpebl' ),
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} ' => 'vertical-align:{{VALUE}};',
				],
				'condition' => [
					'open_tag!' => 'none',
					'display' => ['flex','inline-flex'],
					'display_alignmet_opt' => 'yes',
				],
			]
		);
		$repeater->add_responsive_control(
			'margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],				
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
				'condition' => [
					'open_tag!' => 'none',
				],
			]
		);
		$repeater->add_responsive_control(
			'padding',
			[
				'label' => esc_html__( 'Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'open_tag!' => 'none',
				],
			]
		);
		$repeater->add_control(
			'top_offset_switch', [
				'label'   => esc_html__( 'Top (Auto / PX)', 'tpebl' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__( 'PX', 'tpebl' ),
				'label_off' => esc_html__( 'Auto', 'tpebl' ),
				'condition' => [
					'open_tag!' => 'none',
					'position' => 'absolute',
				],
			]
		);
		$repeater->add_control(
            'top_offset',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Top Offset', 'tpebl'),
				'size_units' => [ 'px' ],				
				'range' => [
					'px' => [
						'min'	=> -300,
						'max'	=> 300,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'condition' => [
					'open_tag!' => 'none',
					'position' => 'absolute',
					'top_offset_switch' => 'yes',
				],
            ]
        );
		$repeater->add_control(
			'bottom_offset_switch', [
				'label'   => esc_html__( 'Bottom (Auto / PX)', 'tpebl' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__( 'PX', 'tpebl' ),
				'label_off' => esc_html__( 'Auto', 'tpebl' ),
				'condition' => [
					'open_tag!' => 'none',
					'position' => 'absolute',
				],
			]
		);
		$repeater->add_control(
            'bottom_offset',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Bottom Offset', 'tpebl'),
				'size_units' => [ 'px' ],				
				'range' => [
					'px' => [
						'min'	=> -300,
						'max'	=> 300,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'condition' => [
					'open_tag!' => 'none',
					'position' => 'absolute',
					'bottom_offset_switch' => 'yes',
				],
            ]
        );
		$repeater->add_control(
			'left_offset_switch', [
				'label'   => esc_html__( 'Left (Auto / PX)', 'tpebl' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__( 'PX', 'tpebl' ),
				'label_off' => esc_html__( 'Auto', 'tpebl' ),
				'condition' => [
					'open_tag!' => 'none',
					'position' => 'absolute',
				],
			]
		);
		$repeater->add_control(
            'left_offset',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Left Offset', 'tpebl'),
				'size_units' => [ 'px' ],				
				'range' => [
					'px' => [
						'min'	=> -300,
						'max'	=> 300,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'condition' => [
					'open_tag!' => 'none',
					'position' => 'absolute',
					'left_offset_switch' => 'yes',
				],
            ]
        );
		$repeater->add_control(
			'right_offset_switch', [
				'label'   => esc_html__( 'Right (Auto / PX)', 'tpebl' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__( 'PX', 'tpebl' ),
				'label_off' => esc_html__( 'Auto', 'tpebl' ),
				'condition' => [
					'open_tag!' => 'none',
					'position' => 'absolute',
				],
			]
		);
		$repeater->add_control(
            'right_offset',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Right Offset', 'tpebl'),
				'size_units' => [ 'px' ],				
				'range' => [
					'px' => [
						'min'	=> -300,
						'max'	=> 300,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'condition' => [
					'open_tag!' => 'none',
					'position' => 'absolute',
					'right_offset_switch' => 'right_offset_switch',
				],
            ]
        );
		$repeater->add_control(
			'width_height', [
				'label'   => esc_html__( 'Width/Height Options', 'tpebl' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'condition' => [
					'open_tag!' => 'none',
				],
			]
		);
		$repeater->add_responsive_control(
            'width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Width', 'tpebl'),
				'size_units' => [ 'px','%','vh' ],				
				'range' => [
					'px' => [
						'min'	=> 0,
						'max'	=> 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',				
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} ' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'open_tag!' => 'none',
					'width_height' => 'yes',
				],
            ]
        );
		$repeater->add_responsive_control(
            'min_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Min. Width', 'tpebl'),
				'size_units' => [ 'px','%','vh' ],				
				'range' => [
					'px' => [
						'min'	=> 0,
						'max'	=> 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',				
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} ' => 'min-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'open_tag!' => 'none',
					'width_height' => 'yes',
				],
            ]
        );
		$repeater->add_responsive_control(
            'height',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Height', 'tpebl'),
				'size_units' => [ 'px','%','vh' ],				
				'range' => [
					'px' => [
						'min'	=> 0,
						'max'	=> 700,
						'step' => 1,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',				
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} ' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'open_tag!' => 'none',
					'width_height' => 'yes',
				],
            ]
        );
		$repeater->add_responsive_control(
            'min_height',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Min. Height', 'tpebl'),
				'size_units' => [ 'px','%','vh' ],				
				'range' => [
					'px' => [
						'min'	=> 0,
						'max'	=> 700,
						'step' => 1,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
					'vh' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',				
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} ' => 'min-height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'open_tag!' => 'none',
					'width_height' => 'yes',
				],
            ]
        );
		$repeater->add_responsive_control(
            'z_index',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Z-Index', 'tpebl'),
				'size_units' => [ 'px' ],				
				'range' => [
					'px' => [
						'min'	=> 0,
						'max'	=> 1000,
						'step' => 1,
					],
				],
				'render_type' => 'ui',				
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} ' => 'z-index: {{SIZE}};',
				],
				'condition' => [
					'open_tag!' => 'none',
				],
            ]
        );
		$repeater->add_control(
			'overflow',
			[
				'label' => esc_html__( 'Overflow', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'visible',
				'options' => [
					'hidden'  => esc_html__( 'Hidden', 'tpebl' ),
					'visible'  => esc_html__( 'Visible', 'tpebl' ),
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} ' => 'overflow:{{VALUE}} !important;',
				],
				'condition' => [
					'open_tag!' => 'none',
				],
			]
		);
		$repeater->add_control(
			'visibility',
			[
				'label' => esc_html__( 'Visibility', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'unset',
				'options' => [
					'unset'  => esc_html__( 'Unset', 'tpebl' ),
					'hidden'  => esc_html__( 'Hidden', 'tpebl' ),
					'visible'  => esc_html__( 'Visible', 'tpebl' ),
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} ' => 'visibility:{{VALUE}} !important;',
				],
				'condition' => [
					'open_tag!' => 'none',
				],
			]
		);
		$repeater->add_control(
			'bg_opt_heading',[
				'label' => esc_html__( 'Background Style', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition'    => [
					'open_tag!' => 'none',
				],
			]
		);	
		$repeater->add_control(
			'bg_opt', [
				'label'   => esc_html__( 'Background', 'tpebl' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'condition' => [
					'open_tag!' => 'none',
				],
			]
		);
		$repeater->start_controls_tabs( 'tabs_background_options' );
			$repeater->start_controls_tab(
				'bg_opt_normal',
				[
					'label' => esc_html__( 'Normal', 'tpebl' ),
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',						
					],
				]
			);
			$repeater->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'bg_opt_bg',
					'types'     => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',						
					],
				]
			);
			$repeater->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'bg_opt_border',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
				'condition' => [
					'open_tag!' => 'none',
					'bg_opt' => 'yes',						
				],
			]
			);
			$repeater->add_responsive_control(
				'bg_opt_br',
				[
					'label'      => esc_html__( 'Border Radius', 'tpebl' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',						
					],
				]
			);
			$repeater->add_group_control(
			Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'bg_opt_shadow',
					'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'transition',
				[
					'label' => esc_html__( 'Transition css', 'tpebl' ),
					'type' => Controls_Manager::TEXT,				
					'placeholder' => esc_html__( 'all .3s linear', 'tpebl' ),
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}}' => '-webkit-transition: {{VALUE}};-moz-transition: {{VALUE}};-o-transition: {{VALUE}};-ms-transition: {{VALUE}};'
					],
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',						
					],
					'separator' => 'before',
				]
			);
			$repeater->add_control(
				'transform',
				[
					'label' => esc_html__( 'Transform css', 'tpebl' ),
					'type' => Controls_Manager::TEXT,				
					'placeholder' => esc_html__( 'rotate(10deg) scale(1.1)', 'tpebl' ),
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}}' => 'transform: {{VALUE}};-ms-transform: {{VALUE}};-moz-transform: {{VALUE}};-webkit-transform: {{VALUE}};'
					],
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',						
					],
				]
			);
			$repeater->add_group_control(
				Group_Control_Css_Filter::get_type(),
				[
					'name' => 'css_filters',
					'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',						
					],
				]
			);
			$repeater->add_control(
				'opacity',[
					'label' => esc_html__( 'Opacity', 'tpebl' ),
					'type' => Controls_Manager::SLIDER,					
					'range' => [
						'%' => [
							'max' => 1,
							'min' => 0.10,
							'step' => 0.01,
						],
					],
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}}' => 'opacity: {{SIZE}};',
					],
					'condition'    => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',	
					],
				]
			);
			$repeater->end_controls_tab();
			$repeater->start_controls_tab(
				'bg_opt_hover',
				[
					'label' => esc_html__( 'Hover', 'tpebl' ),
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',						
					],
				]
			);
			$repeater->add_control(
				'cst_hover', [
					'label'   => esc_html__( 'Custom Hover', 'tpebl' ),
					'type'    => Controls_Manager::SWITCHER,
					'default' => 'no',
					'label_on' => esc_html__( 'Enable', 'tpebl' ),
					'label_off' => esc_html__( 'Disable', 'tpebl' ),
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',	
					],
				]
			);
			$repeater->add_control(
				'cst_hover_class',
				[
					'label' => esc_html__( 'Enter Class', 'tpebl' ),
					'type' => Controls_Manager::TEXT,
					'default' => '',
					'dynamic' => ['active' => true,],
					'label_block' => true,
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
					],
				]
			);
			$repeater->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'      => 'bg_opt_bg_hover',
					'types'     => [ 'classic', 'gradient' ],
					'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}:hover',
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover!' => 'yes',
					],
				]
			);
			$repeater->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'bg_opt_border_hover',
					'label' => esc_html__( 'Border', 'tpebl' ),
					'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}:hover',
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover!' => 'yes',
					],
				]
			);
			$repeater->add_responsive_control(
				'bg_opt_br_hover',
				[
					'label'      => esc_html__( 'Border Radius', 'tpebl' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors'  => [
						'{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover!' => 'yes',
					],
				]
			);
			$repeater->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name'     => 'bg_opt_shadow_hover',
					'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}:hover',
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover!' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'transition_hover',
				[
					'label' => esc_html__( 'Transition css', 'tpebl' ),
					'type' => Controls_Manager::TEXT,				
					'placeholder' => esc_html__( 'all .3s linear', 'tpebl' ),
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}}:hover' => '-webkit-transition: {{VALUE}};-moz-transition: {{VALUE}};-o-transition: {{VALUE}};-ms-transition: {{VALUE}};'
					],
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover!' => 'yes',
					],
					'separator' => 'before',
				]
			);			
			$repeater->add_control(
				'transform_hover',
				[
					'label' => esc_html__( 'Transform css', 'tpebl' ),
					'type' => Controls_Manager::TEXT,				
					'placeholder' => esc_html__( 'rotate(10deg) scale(1.1)', 'tpebl' ),
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'transform: {{VALUE}};-ms-transform: {{VALUE}};-moz-transform: {{VALUE}};-webkit-transform: {{VALUE}};'
					],
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover!' => 'yes',
					],
				]
			);			
			$repeater->add_group_control(
				Group_Control_Css_Filter::get_type(),
				[
					'name' => 'css_filters_hover',
					'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}:hover',
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover!' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'opacity_hover',[
					'label' => esc_html__( 'Opacity', 'tpebl' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'%' => [
							'max' => 1,
							'min' => 0.10,
							'step' => 0.01,
						],
					],
					'selectors' => [
						'{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'opacity: {{SIZE}};',
					],
					'condition'    => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover!' => 'yes',
					],
				]
			);
			/*hover custom background start*/			
			$repeater->add_control(
				'b_color_option',
				[
					'label' => esc_html__( 'Background', 'tpebl' ),
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
						'image' => [
							'title' => esc_html__( 'Image', 'tpebl' ),
							'icon' => 'fa fa-file-image-o',
						],
					],
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
					],
					'label_block' => false,
					'default' => 'solid',
				]
			);
			$repeater->add_control(
				'b_color_solid',
				[
					'label' => esc_html__( 'Color', 'tpebl' ),
					'type' => Controls_Manager::COLOR,					
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'b_color_option' => 'solid',
					],
				]
			);
			$repeater->add_control(
				'b_gradient_color1',
				[
					'label' => esc_html__('Color 1', 'tpebl'),
					'type' => Controls_Manager::COLOR,
					'default' => 'orange',
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'b_color_option' => 'gradient',
					],
					'of_type' => 'gradient',
				]
			);
			$repeater->add_control(
				'b_gradient_color1_control',
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
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'b_color_option' => 'gradient',
					],
					'of_type' => 'gradient',
				]
			);
			$repeater->add_control(
				'b_gradient_color2',
				[
					'label' => esc_html__('Color 2', 'tpebl'),
					'type' => Controls_Manager::COLOR,
					'default' => 'cyan',
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'b_color_option' => 'gradient',
					],
					'of_type' => 'gradient',
				]
			);
			$repeater->add_control(
				'b_gradient_color2_control',
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
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'b_color_option' => 'gradient',
					],
					'of_type' => 'gradient',
				]
			);
			$repeater->add_control(
				'b_gradient_style', [
					'type' => Controls_Manager::SELECT,
					'label' => esc_html__('Gradient Style', 'tpebl'),
					'default' => 'linear',
					'options' => l_theplus_get_gradient_styles(),
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'b_color_option' => 'gradient',
					],
					'of_type' => 'gradient',
				]
			);
			$repeater->add_control(
				'b_gradient_angle', [
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
					'condition'    => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'b_color_option' => 'gradient',
						'b_gradient_style' => ['linear']
					],
					'of_type' => 'gradient',
				]
			);
			$repeater->add_control(
				'b_gradient_position', [
					'type' => Controls_Manager::SELECT,
					'label' => esc_html__('Position', 'tpebl'),
					'options' => l_theplus_get_position_options(),
					'default' => 'center center',					
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'b_color_option' => 'gradient',
						'b_gradient_style' => 'radial',
				],
				'of_type' => 'gradient',
				]
			);
			$repeater->add_control(
				'b_h_image', [
					'type' => Controls_Manager::MEDIA,
					'label' => esc_html__('Background Image', 'tpebl'),
					'dynamic' => ['active'   => true,],				
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'b_color_option' => 'image',
					],
				]
			);
			$repeater->add_control(
				'b_h_image_position', [
					'type' => Controls_Manager::SELECT,
					'label' => esc_html__('Image Position', 'tpebl'),
					'default' => 'center center',
					'options' => [
						'' => esc_html__( 'Default','tpebl' ),
						'top left' => esc_html__( 'Top Left','tpebl' ),
						'top center' => esc_html__( 'Top Center','tpebl' ),
						'top right' => esc_html__( 'Top Right','tpebl' ),
						'center left' => esc_html__( 'Center Left','tpebl' ),
						'center center' => esc_html__( 'Center Center','tpebl' ),
						'center right' => esc_html__( 'Center Right', 'tpebl' ),
						'bottom left' => esc_html__( 'Bottom Left', 'tpebl' ),
						'bottom center' => esc_html__( 'Bottom Center','tpebl' ),
						'bottom right' => esc_html__( 'Bottom Right','tpebl' ),
					],				
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'b_color_option' => 'image',
						'b_h_image[url]!' => '',
					],			
				]
			);
			$repeater->add_control(
				'b_h_image_attach', [
					'type' => Controls_Manager::SELECT,
					'label' => esc_html__('Attachment', 'tpebl'),
					'default' => 'scroll',
					'options' => [
						'' => esc_html__( 'Default', 'tpebl' ),
						'scroll' => esc_html__( 'Scroll', 'tpebl' ),
						'fixed' => esc_html__( 'Fixed', 'tpebl' ),
					],				
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'b_color_option' => 'image',
						'b_h_image[url]!' => '',
					],		
				]
			);
			$repeater->add_control(
				'b_h_image_repeat', [
					'type' => Controls_Manager::SELECT,
					'label' => esc_html__('Repeat', 'tpebl'),
					'default' => 'repeat',
					'options' => [
						'' => esc_html__( 'Default', 'tpebl' ),
						'no-repeat' => esc_html__( 'No-repeat', 'tpebl' ),
						'repeat' => esc_html__( 'Repeat', 'tpebl' ),
						'repeat-x' => esc_html__( 'Repeat-x','tpebl' ),
						'repeat-y' => esc_html__( 'Repeat-y','tpebl' ),
					],
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'b_color_option' => 'image',
						'b_h_image[url]!' => '',
					],		
				]
			);
			$repeater->add_control(
				'b_h_image_size', [
					'type' => Controls_Manager::SELECT,
					'label' => esc_html__('Background Size', 'tpebl'),
					'default' => 'cover',
					'options' => [
						'' => esc_html__( 'Default', 'tpebl' ),
						'auto' => esc_html__( 'Auto', 'tpebl' ),
						'cover' => esc_html__( 'Cover', 'tpebl' ),
						'contain' => esc_html__( 'Contain', 'tpebl' ),
					],				
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'b_color_option' => 'image',
						'b_h_image[url]!' => '',
					],		
				]
			);
			$repeater->add_control(
				'b_h_border_style',
				[
					'label' => esc_html__( 'Border Style', 'tpebl' ),
					'type' => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						'' => esc_html__( 'None', 'tpebl' ),
						'solid' => esc_html__( 'Solid', 'tpebl' ),
						'dashed' => esc_html__( 'Dashed', 'tpebl' ),
						'dotted' => esc_html__( 'Dotted', 'tpebl' ),
						'groove' => esc_html__( 'Groove',  'tpebl' ),
						'inset' => esc_html__( 'Inset','tpebl' ),
						'outset' => esc_html__( 'Outset','tpebl' ),
						'ridge' => esc_html__( 'Ridge', 'tpebl' ),
					],
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
					],
				]
			);
			$repeater->add_responsive_control(
				'b_h_border_width',
				[
					'label' => esc_html__( 'Border Width', 'tpebl' ),
					'type'  => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'b_h_border_style!' => '',
					],
				]
			);
			$repeater->add_control(
				'b_h_border_color',
				[
					'label' => esc_html__( 'Border Color', 'tpebl' ),
					'type' => Controls_Manager::COLOR,					
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'b_h_border_style!' => '',
					],
				]
			);
			$repeater->add_responsive_control(
				'b_h_border_radius',
				[
					'label'      => esc_html__( 'Border Radius', 'tpebl' ),
					'type'       => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],					
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'box_shadow_hover_cst',
				[
					'label' => esc_html__( 'Box Shadow', 'tpebl' ),
					'type' => Controls_Manager::POPOVER_TOGGLE,
					'label_off' => __( 'Default', 'tpebl' ),
					'label_on' => __( 'Custom', 'tpebl' ),
					'return_value' => 'yes',
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
					],
				]
			);			
			$repeater->start_popover();
			$repeater->add_control(
				'box_shadow_color',
				[
					'label' => esc_html__( 'Color', 'tpebl' ),
					'type' => Controls_Manager::COLOR,
					'default' => 'rgba(0,0,0,0.5)',
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'box_shadow_hover_cst' => 'yes',		
					],
				]
			);
			$repeater->add_control(
				'box_shadow_horizontal',
				[
					'label' => esc_html__( 'Horizontal', 'tpebl' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'max' => -100,
							'min' => 100,
							'step' => 2,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 0,
					],
					'condition'    => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'box_shadow_hover_cst' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'box_shadow_vertical',
				[
					'label' => esc_html__( 'Vertical', 'tpebl' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'max' => -100,
							'min' => 100,
							'step' => 2,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 0,
					],
					'condition'    => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'box_shadow_hover_cst' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'box_shadow_blur',
				[
					'label' => esc_html__( 'Blur', 'tpebl' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'max' => 0,
							'min' => 100,
							'step' => 1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 10,
					],
					'condition'    => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'box_shadow_hover_cst' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'box_shadow_spread',
				[
					'label' => esc_html__( 'Spread', 'tpebl' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'range' => [
						'px' => [
							'max' => -100,
							'min' => 100,
							'step' => 2,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 0,
					],
					'condition'    => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'box_shadow_hover_cst' => 'yes',
					],
				]
			);
			$repeater->end_popover();			
			
			$repeater->add_control(
				'transition_hover_cst',
				[
					'label' => esc_html__( 'Transition css', 'tpebl' ),
					'type' => Controls_Manager::TEXT,				
					'placeholder' => esc_html__( 'all .3s linear', 'tpebl' ),					
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
					],
					'separator' => 'before',
				]
			);
			$repeater->add_control(
				'transform_hover_cst',
				[
					'label' => esc_html__( 'Transform css', 'tpebl' ),
					'type' => Controls_Manager::TEXT,				
					'placeholder' => esc_html__( 'rotate(10deg) scale(1.1)', 'tpebl' ),
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
					],
				]
			);
			
			$repeater->add_control(
				'css_filter_hover_cst',
				[
					'label' => esc_html__( 'CSS Filter', 'tpebl' ),
					'type' => Controls_Manager::POPOVER_TOGGLE,
					'label_off' => __( 'Default', 'tpebl' ),
					'label_on' => __( 'Custom', 'tpebl' ),
					'return_value' => 'yes',
					'condition' => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
					],
				]
			);			
			$repeater->start_popover();
			$repeater->add_control(
				'css_filter_blur',
				[
					'label' => esc_html__( 'Blur', 'tpebl' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 10,
							'min' => 0,
							'step' => 0.1,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 0,
					],
					'condition'    => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'css_filter_hover_cst' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'css_filter_brightness',
				[
					'label' => esc_html__( 'Brightness', 'tpebl' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 200,
							'min' => 0,
							'step' => 2,
						],
					],
					'default' => [
						'unit' => '%',
						'size' => 100,
					],
					'condition'    => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'css_filter_hover_cst' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'css_filter_contrast',
				[
					'label' => esc_html__( 'Contrast', 'tpebl' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 200,
							'min' => 0,
							'step' => 2,
						],
					],
					'default' => [
						'unit' => '%',
						'size' => 100,
					],
					'condition'    => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'css_filter_hover_cst' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'css_filter_saturation',
				[
					'label' => esc_html__( 'Saturation', 'tpebl' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 200,
							'min' => 0,
							'step' => 2,
						],
					],
					'default' => [
						'unit' => '%',
						'size' => 100,
					],
					'condition'    => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'css_filter_hover_cst' => 'yes',
					],
				]
			);
			$repeater->add_control(
				'css_filter_hue',
				[
					'label' => esc_html__( 'Hue', 'tpebl' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 360,
							'min' => 0,
							'step' => 5,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 0,
					],
					'condition'    => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
						'css_filter_hover_cst' => 'yes',
					],
				]
			);
			$repeater->end_popover();
			
			$repeater->add_control(
				'opacity_hover_cst',
				[
					'label' => esc_html__( 'Opacity', 'tpebl' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'%' => [
							'max' => 1,
							'min' => 0.10,
							'step' => 0.01,
						],
					],
					'condition'    => [
						'open_tag!' => 'none',
						'bg_opt' => 'yes',
						'cst_hover' => 'yes',
					],
				]
			);
			/*hover custom background end*/
			$repeater->end_controls_tab();
		$repeater->end_controls_tabs();
		
		$repeater->add_control(
			'text_heading',[
				'label' => esc_html__( 'Text Style', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition'    => [
					'content_tag' => 'text',
				],
			]
		);	
		$repeater->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
				'condition' => [
					'content_tag' => 'text',			
				],
			]
		);
		$repeater->start_controls_tabs( 'tabs_text_style' );
		$repeater->start_controls_tab(
			'tab_text_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
				'condition' => [
					'content_tag' => 'text',			
				],
			]
		);
		$repeater->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'color: {{VALUE}};',
				],
				'condition' => [
					'content_tag' => 'text',			
				],
			]
		);
		$repeater->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'label' => esc_html__( 'Text Shadow', 'tpebl' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
				'condition' => [
					'content_tag' => 'text',			
				],
			]
		);
		$repeater->end_controls_tab();
		$repeater->start_controls_tab(
			'tab_text_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
				'condition' => [
					'content_tag' => 'text',			
				],
			]
		);
		$repeater->add_control(
			'cst_text_hover', [
				'label'   => esc_html__( 'Custom Hover', 'tpebl' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'condition' => [
					'content_tag' => 'text',
				],
			]
		);		
		$repeater->add_control(
			'text_color_h',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'content_tag' => 'text',
					'cst_text_hover!' => 'yes',
				],
			]
		);
		$repeater->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow_h',
				'label' => esc_html__( 'Text Shadow', 'tpebl' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}:hover',
				'condition' => [
					'content_tag' => 'text',
					'cst_text_hover!' => 'yes',					
				],
			]
		);
		$repeater->add_control(
			'cst_text_hover_class',
			[
				'label' => esc_html__( 'Enter Class', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => ['active' => true,],
				'label_block' => true,
				'condition' => [
					'content_tag' => 'text',
					'cst_text_hover' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'text_color_h_cst',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'condition' => [
					'content_tag' => 'text',
					'cst_text_hover' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'text_shadow_hover_cst',
			[
				'label' => esc_html__( 'Text Shadow', 'tpebl' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'tpebl' ),
				'label_on' => __( 'Custom', 'tpebl' ),
				'return_value' => 'yes',
				'condition' => [
					'content_tag' => 'text',
					'cst_text_hover' => 'yes',
				],
			]
		);			
		$repeater->start_popover();
		$repeater->add_control(
			'ts_color',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0.5)',
				'condition' => [
					'content_tag' => 'text',
					'cst_text_hover' => 'yes',
					'text_shadow_hover_cst' => 'yes',		
				],
			]
		);
		$repeater->add_control(
			'ts_horizontal',
			[
				'label' => esc_html__( 'Horizontal', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'max' => -100,
						'min' => 100,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'condition'    => [
					'content_tag' => 'text',
					'cst_text_hover' => 'yes',
					'text_shadow_hover_cst' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'ts_vertical',
			[
				'label' => esc_html__( 'Vertical', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'max' => -100,
						'min' => 100,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'condition'    => [
					'content_tag' => 'text',
					'cst_text_hover' => 'yes',
					'text_shadow_hover_cst' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'ts_blur',
			[
				'label' => esc_html__( 'Blur', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'max' => 0,
						'min' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'condition'    => [
					'content_tag' => 'text',
					'cst_text_hover' => 'yes',
					'text_shadow_hover_cst' => 'yes',
				],
			]
		);
		$repeater->end_popover();
		$repeater->end_controls_tab();
		$repeater->end_controls_tabs();
		
		$repeater->add_control(
			'image_heading',[
				'label' => esc_html__( 'Image Style', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition'    => [
					'content_tag' => 'image',
				],
			]
		);
		$repeater->add_control(
            'image_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Width', 'tpebl'),
				'size_units' => [ 'px' ],				
				'range' => [
					'px' => [
						'min'	=> 1,
						'max'	=> 1000,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'condition' => [
					'content_tag' => 'image',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} ' => 'width: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$repeater->add_control(
            'image_max_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Max. Width', 'tpebl'),
				'size_units' => [ 'px' ],				
				'range' => [
					'px' => [
						'min'	=> 1,
						'max'	=> 1000,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'condition' => [
					'content_tag' => 'image',
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}} ' => 'max-width: {{SIZE}}{{UNIT}};',
				],
            ]
        );
		$repeater->start_controls_tabs( 'tabs_image' );
		$repeater->start_controls_tab(
			'tab_image',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
				'condition' => [
					'content_tag' => 'image',
				],
			]
		);
		$repeater->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
				'condition' => [
					'content_tag' => 'image',						
				],
			]
		);
		$repeater->add_responsive_control(
			'image_br',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'content_tag' => 'image',					
				],
			]
		);
		$repeater->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'image_shadow',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
				'condition' => [
					'content_tag' => 'image',
				],
			]
		);
		$repeater->add_control(
			'image_opacity',[
				'label' => esc_html__( 'Opacity', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,					
				'range' => [
					'%' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'opacity: {{SIZE}};',
				],
				'condition'    => [
					'content_tag' => 'image',
				],
			]
		);
		$repeater->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'image_css_filters',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}',
				'condition' => [
					'content_tag' => 'image',						
				],
			]
		);
		$repeater->end_controls_tab();
		$repeater->start_controls_tab(
			'tab_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
				'condition' => [
					'content_tag' => 'image',
				],
			]
		);
		$repeater->add_control(
			'cst_image_hover', [
				'label'   => esc_html__( 'Custom Hover', 'tpebl' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'condition' => [
					'content_tag' => 'image',
				],
			]
		);		
		$repeater->add_control(
			'cst_image_hover_class',
			[
				'label' => esc_html__( 'Enter Class', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => ['active' => true,],
				'label_block' => true,
				'condition' => [
					'content_tag' => 'image',
					'cst_image_hover' => 'yes',
				],
			]
		);
		$repeater->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border_h',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}:hover',
				'condition' => [
					'content_tag' => 'image',
					'cst_image_hover!' => 'yes',
				],
			]
		);
		$repeater->add_responsive_control(
			'image_br_h',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'content_tag' => 'image',
					'cst_image_hover!' => 'yes',
				],
			]
		);
		$repeater->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'image_shadow_h',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}:hover',
				'condition' => [
					'content_tag' => 'image',
					'cst_image_hover!' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'image_opacity_h',[
				'label' => esc_html__( 'Opacity', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,					
				'range' => [
					'%' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}:hover' => 'opacity: {{SIZE}};',
				],
				'condition'    => [
					'content_tag' => 'image',
					'cst_image_hover!' => 'yes',
				],
			]
		);
		$repeater->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'image_css_filters_h',
				'selector' => '{{WRAPPER}} {{CURRENT_ITEM}}:hover',
				'condition' => [
					'content_tag' => 'image',
					'cst_image_hover!' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'image_h_border_style',
			[
				'label' => esc_html__( 'Border Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => esc_html__( 'None', 'tpebl' ),
					'solid' => esc_html__( 'Solid', 'tpebl' ),
					'dashed' => esc_html__( 'Dashed', 'tpebl' ),
					'dotted' => esc_html__( 'Dotted', 'tpebl' ),
					'groove' => esc_html__( 'Groove',  'tpebl' ),
					'inset' => esc_html__( 'Inset','tpebl' ),
					'outset' => esc_html__( 'Outset','tpebl' ),
					'ridge' => esc_html__( 'Ridge', 'tpebl' ),
				],
				'condition' => [
					'content_tag' => 'image',
					'cst_image_hover' => 'yes',
				],
			]
		);
		$repeater->add_responsive_control(
			'image_h_border_width',
			[
				'label' => esc_html__( 'Border Width', 'tpebl' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'condition' => [
					'content_tag' => 'image',
					'cst_image_hover' => 'yes',
					'image_h_border_style!' => '',
				],
			]
		);
		$repeater->add_control(
			'image_h_border_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,					
				'condition' => [
					'content_tag' => 'image',
					'cst_image_hover' => 'yes',
					'image_h_border_style!' => '',
				],
			]
		);
		$repeater->add_responsive_control(
			'image_h_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],					
				'condition' => [
					'content_tag' => 'image',
					'cst_image_hover' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'image_box_shadow_hover_cst',
			[
				'label' => esc_html__( 'Box Shadow', 'tpebl' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'tpebl' ),
				'label_on' => __( 'Custom', 'tpebl' ),
				'return_value' => 'yes',
				'condition' => [
					'content_tag' => 'image',
					'cst_image_hover' => 'yes',
				],
			]
		);			
		$repeater->start_popover();
		$repeater->add_control(
			'image_box_shadow_color',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0.5)',
				'condition' => [
					'content_tag' => 'image',
					'cst_image_hover' => 'yes',
					'image_box_shadow_hover_cst' => 'yes',		
				],
			]
		);
		$repeater->add_control(
			'image_box_shadow_horizontal',
			[
				'label' => esc_html__( 'Horizontal', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'max' => -100,
						'min' => 100,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'condition'    => [
					'content_tag' => 'image',
					'cst_image_hover' => 'yes',
					'image_box_shadow_hover_cst' => 'yes',	
				],
			]
		);
		$repeater->add_control(
			'image_box_shadow_vertical',
			[
				'label' => esc_html__( 'Vertical', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'max' => -100,
						'min' => 100,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'condition'    => [
					'content_tag' => 'image',
					'cst_image_hover' => 'yes',
					'image_box_shadow_hover_cst' => 'yes',	
				],
			]
		);
		$repeater->add_control(
			'image_box_shadow_blur',
			[
				'label' => esc_html__( 'Blur', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'max' => 0,
						'min' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'condition'    => [
					'content_tag' => 'image',
					'cst_image_hover' => 'yes',
					'image_box_shadow_hover_cst' => 'yes',	
				],
			]
		);
		$repeater->add_control(
			'image_box_shadow_spread',
			[
				'label' => esc_html__( 'Spread', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'max' => -100,
						'min' => 100,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'condition'    => [
					'content_tag' => 'image',
					'cst_image_hover' => 'yes',
					'image_box_shadow_hover_cst' => 'yes',	
				],
			]
		);
		$repeater->end_popover();
		$repeater->add_control(
			'image_opacity_hover_cst',
			[
				'label' => esc_html__( 'Opacity', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'%' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'condition'    => [
					'content_tag' => 'image',
					'cst_image_hover' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'image_css_filter_hover_cst',
			[
				'label' => esc_html__( 'CSS Filter', 'tpebl' ),
				'type' => Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'tpebl' ),
				'label_on' => __( 'Custom', 'tpebl' ),
				'return_value' => 'yes',
				'condition' => [
					'content_tag' => 'image',
					'cst_image_hover' => 'yes',
				],
			]
		);			
		$repeater->start_popover();
		$repeater->add_control(
			'image_css_filter_blur',
			[
				'label' => esc_html__( 'Blur', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 10,
						'min' => 0,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'condition'    => [
					'content_tag' => 'image',
					'cst_image_hover' => 'yes',
					'image_css_filter_hover_cst' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'image_css_filter_brightness',
			[
				'label' => esc_html__( 'Brightness', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 200,
						'min' => 0,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'condition'    => [
					'content_tag' => 'image',
					'cst_image_hover' => 'yes',
					'image_css_filter_hover_cst' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'image_css_filter_contrast',
			[
				'label' => esc_html__( 'Contrast', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 200,
						'min' => 0,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'condition'    => [
					'content_tag' => 'image',
					'cst_image_hover' => 'yes',
					'image_css_filter_hover_cst' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'image_css_filter_saturation',
			[
				'label' => esc_html__( 'Saturation', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 200,
						'min' => 0,
						'step' => 2,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'condition'    => [
					'content_tag' => 'image',
					'cst_image_hover' => 'yes',
					'image_css_filter_hover_cst' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'image_css_filter_hue',
			[
				'label' => esc_html__( 'Hue', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 360,
						'min' => 0,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'condition'    => [
					'content_tag' => 'image',
					'cst_image_hover' => 'yes',
					'image_css_filter_hover_cst' => 'yes',
				],
			]
		);
		$repeater->end_popover();
		$repeater->end_controls_tab();
		$repeater->end_controls_tabs();	
		
		$this->add_control(
            'hover_card_content',
            [
				'label' => esc_html__( 'Content [ Start Tag -- End Tag ]', 'tpebl' ),
                'type' => Controls_Manager::REPEATER,               
				'fields' => $repeater->get_controls(),
				'title_field' => '{{content_tag}} [ {{open_tag }} -- {{close_tag}} ]',				
            ]
        );
		$this->end_controls_section();
	}
	private $post_id;
	 protected function render() {
		 $settings = $this->get_settings_for_display();
		 
		  $loopitem=$loopcss='';
			$i=1;
			$hover_card = '<div class="tp-hover-card-wrapper">';
			
				foreach($settings['hover_card_content'] as $item) {					
						
						$open_tag='';
						if(!empty($item['open_tag']) && $item['open_tag']!='none'){
							$open_tag = l_theplus_validate_html_tag($item['open_tag']);
							
							$this->add_render_attribute( 'loop_attr'.$i, 'class', 'elementor-repeater-item-' . $item['_id']);
						}
						
						$class='';
						if(!empty($item['open_tag_class'])){
							$this->add_render_attribute( 'loop_attr'.$i, 'class', $item['open_tag_class'] );
						}
						if($item['content_tag']=='image' && !empty($item['media_content']['url'])){
							$this->add_render_attribute( 'loop_attr_img'.$i, 'class', 'elementor-repeater-item-' . $item['_id'].'.loop-inner');
						}
						
						$close_tag='';
						if(!empty($item['close_tag']) && $item['close_tag']=='close'){
							$close_tag = l_theplus_validate_html_tag($open_tag);
						}else if(!empty($item['close_tag']) && $item['close_tag']!='close' && $item['close_tag']!='none'){
							$close_tag = l_theplus_validate_html_tag($item['close_tag']);
						}
						
						/*a link*/
						if(!empty($item['open_tag']) && $item['open_tag']=="a"){
							if ( ! empty( $item['a_link']['url'] ) ) {
								$this->add_render_attribute( 'loop_attr'.$i, 'href', $item['a_link']['url'] );
								if ( $item['a_link']['is_external'] ) {
									$this->add_render_attribute( 'loop_attr'.$i, 'target', '_blank' );
								}
								if ( $item['a_link']['nofollow'] ) {
									$this->add_render_attribute( 'loop_attr'.$i, 'rel', 'nofollow' );
								}
							}							
						}
						
						
						/*Open Tag start*/
						if(!empty($open_tag)){
							$loopitem .= '<'.l_theplus_validate_html_tag($open_tag).' '.$this->get_render_attribute_string( "loop_attr".$i ).'>';
						}
						/*Open Tag end*/
						
						/*content start*/
						if(!empty($item['content_tag']) && $item['content_tag'] != 'none'){
							if($item['content_tag']=='text' && !empty($item['text_content'])){
								$loopitem .= $item['text_content'];
							}
							
							if($item['content_tag']=='image' && !empty($item['media_content']['url'])){
								$loopitem .= '<img '.$this->get_render_attribute_string( "loop_attr_img".$i ).' src="'.$item['media_content']['url'].'" />';
							}
							
							if($item['content_tag']=='html' && !empty($item['html_content'])){
								$loopitem .=$item['html_content'];
							}
							if($item['content_tag']=='style' && !empty($item['style_content'])){
								$loopitem .='<style>'.$item['style_content'].'</style>';
							}
							
							if($item['content_tag']=='script' && !empty($item['script_content'])){
								$loopitem .=wp_print_inline_script_tag($item['script_content']);
							}
						}
						/*content start*/
						
						/*Close Tag start*/
						if(!empty($item['close_tag']) && $item['close_tag']!='none'){
							$loopitem .= '</'.l_theplus_validate_html_tag($close_tag).'>';
						}
						/*Close Tag end*/
						
						
						/*style for absolute start*/
						if(!empty($item['position']) && $item['position']=='absolute'){
							
							$tov=$bov=$lov=$rov='auto';
							if((!empty($item['top_offset_switch']) && $item['top_offset_switch']=='yes') && !empty($item['top_offset']['size'])){
								$tov = $item['top_offset']['size'].$item['top_offset']['unit'];
							}
							if((!empty($item['bottom_offset_switch']) && $item['bottom_offset_switch']=='yes') && !empty($item['bottom_offset']['size'])){
								$bov = $item['bottom_offset']['size'].$item['bottom_offset']['unit'];
							}
							if((!empty($item['left_offset_switch']) && $item['left_offset_switch']=='yes') && !empty($item['left_offset']['size'])){
								$lov = $item['left_offset']['size'].$item['left_offset']['unit'];
							}
							if((!empty($item['right_offset_switch']) && $item['right_offset_switch']=='yes') && !empty($item['right_offset']['size'])){
								$rov = $item['right_offset']['size'].$item['right_offset']['unit'];
							}
							
							$loopcss .='.elementor-element'.$this->get_unique_selector().'  .elementor-repeater-item-'.$item['_id'].'{top: '.$tov.';bottom: '.$bov.';left: '.$lov.';right: '.$rov.';}';
						}
						/*style for absolute end*/
						
						/*style tag for hover start*/
						$get_ele_pre='';
						if((!empty($item['cst_hover']) && $item['cst_hover']=='yes') || (!empty($item['cst_text_hover']) && $item['cst_text_hover']=='yes') || (!empty($item['cst_image_hover']) && $item['cst_image_hover']=='yes')){
							
							$get_ele_pre = '.elementor-element'.$this->get_unique_selector().' '.$item['cst_hover_class'].':hover .elementor-repeater-item-'.$item['_id'];
														
							if(!empty($item['cst_hover_class'])){
									if(!empty($item['b_color_option']) && $item['b_color_option']=='solid'){
										if(!empty($item['b_color_solid'])){
											$loopcss .=  $get_ele_pre.'{background-color:'.$item['b_color_solid'].' !important;}';
										}										
									}else if(!empty($item['b_color_option']) && $item['b_color_option']=='gradient'){
										if(!empty($item['b_gradient_style']) && $item['b_gradient_style']=='linear'){
											if(!empty($item['b_gradient_color1']) && !empty($item['b_gradient_color2'])){
												$loopcss .=$get_ele_pre.'{background-image: linear-gradient('.$item['b_gradient_angle']['size'].$item['b_gradient_angle']['unit'].', '.$item['b_gradient_color1'].' '.$item['b_gradient_color1_control']['size'].$item['b_gradient_color1_control']['unit'].', '.$item['b_gradient_color2'].' '.$item['b_gradient_color2_control']['size'].$item['b_gradient_color2_control']['unit'].') !important}';
											}												
										}else if(!empty($item['b_gradient_style']) && $item['b_gradient_style']=='radial'){
											if(!empty($item['b_gradient_color1']) && !empty($item['b_gradient_color2'])){
												$loopcss .=$get_ele_pre.'{background-image: radial-gradient(at '.$item['b_gradient_position'].', '.$item['b_gradient_color1'].' '.$item['b_gradient_color1_control']['size'].$item['b_gradient_color1_control']['unit'].', '.$item['b_gradient_color2'].' '.$item['b_gradient_color2_control']['size'].$item['b_gradient_color2_control']['unit'].') !important}';
											}												
										}
									}else if(!empty($item['b_color_option']) && $item['b_color_option']=='image'){
										if(!empty($item['b_h_image']['url'])){
											$loopcss .=$get_ele_pre.'{background-image:url('.$item['b_h_image']['url'].') !important;background-position:'.$item['b_h_image_position'].' !important;background-attachment:'.$item['b_h_image_attach'].' !important;background-repeat:'.$item['b_h_image_repeat'].' !important;background-size:'.$item['b_h_image_size'].' !important;}';	
										}
									}
									
									if(!empty($item['b_h_border_style'])){
										$loopcss .=$get_ele_pre.'{border-style:'.$item['b_h_border_style'].' !important;border-width: '.$item['b_h_border_width']['top'].$item['b_h_border_width']['unit'].' '.$item['b_h_border_width']['right'].$item['b_h_border_width']['unit'].' '.$item['b_h_border_width']['bottom'].$item['b_h_border_width']['unit'].' '.$item['b_h_border_width']['left'].$item['b_h_border_width']['unit'].' !important;border-color:'.$item['b_h_border_color'].' !important;}';
									}
									
									if(!empty($item['b_h_border_radius'])){										
										if(!empty($item['b_h_border_radius']['top']) || !empty($item['b_h_border_radius']['right']) || !empty($item['b_h_border_radius']['bottom']) || !empty($item['b_h_border_radius']['left'])){
											$loopcss .=$get_ele_pre.'{border-radius: '.$item['b_h_border_radius']['top'].$item['b_h_border_radius']['unit'].' '.$item['b_h_border_radius']['right'].$item['b_h_border_radius']['unit'].' '.$item['b_h_border_radius']['bottom'].$item['b_h_border_radius']['unit'].' '.$item['b_h_border_radius']['left'].$item['b_h_border_radius']['unit'].' !important;}';
										}										
									}
									
									if(!empty($item['box_shadow_hover_cst']) && $item['box_shadow_hover_cst']=='yes'){
										$loopcss .=$get_ele_pre.'{box-shadow: '.$item['box_shadow_horizontal']['size'].'px '.$item['box_shadow_vertical']['size'].'px '.$item['box_shadow_blur']['size'].'px '.$item['box_shadow_spread']['size'].'px '.$item['box_shadow_color'].' !important;}';
									}
									
									if(!empty($item['transition_hover_cst'])){
										$loopcss .= $get_ele_pre.'{ -webkit-transition: '.$item['transition_hover_cst'].' !important;-moz-transition: '.$item['transition_hover_cst'].' !important;-o-transition:'.$item['transition_hover_cst'].' !important;-ms-transition: '.$item['transition_hover_cst'].' !important;}';
									}
									if(!empty($item['transform_hover_cst'])){
										$loopcss .= $get_ele_pre.'{ transform: '.$item['transform_hover_cst'].' !important;-ms-transform: '.$item['transform_hover_cst'].' !important;-moz-transform:'.$item['transform_hover_cst'].' !important;-webkit-transform: '.$item['transform_hover_cst'].' !important;}';
									}
									if(!empty($item['css_filter_hover_cst']) && $item['css_filter_hover_cst']=='yes'){
										$loopcss .= $get_ele_pre.'{filter:brightness( '.$item['css_filter_brightness']['size'].'% ) contrast( '.$item['css_filter_contrast']['size'].'% ) saturate( '.$item['css_filter_saturation']['size'].'% ) blur( '.$item['css_filter_blur']['size'].'px ) hue-rotate( '.$item['css_filter_hue']['size'].'deg ) !important}';
									}
									if(!empty($item['opacity_hover_cst']['size'])){
										$loopcss .= $get_ele_pre.'{ opacity: '.$item['opacity_hover_cst']['size'].' !important;}';
									}
								
							}
							
							if(!empty($item['cst_text_hover_class'])){
								if(!empty($item['text_color_h_cst'])){
									$loopcss .= $get_ele_pre.'{ color: '.$item['text_color_h_cst'].' !important;}';
								}
								
								if(!empty($item['ts_color'])){
									$loopcss .= $get_ele_pre.'{ text-shadow : '.$item['ts_horizontal']['size'].'px '.$item['ts_vertical']['size'].'px '.$item['ts_blur']['size'].'px '.$item['ts_color'].' !important;}';
								}								
							}
							
							if(!empty($item['cst_image_hover_class'])){
								if(!empty($item['image_h_border_style'])){
									$loopcss .=$get_ele_pre.' img{border-style:'.$item['image_h_border_style'].' !important;border-width: '.$item['image_h_border_width']['top'].$item['image_h_border_width']['unit'].' '.$item['image_h_border_width']['right'].$item['image_h_border_width']['unit'].' '.$item['image_h_border_width']['bottom'].$item['image_h_border_width']['unit'].' '.$item['image_h_border_width']['left'].$item['image_h_border_width']['unit'].' !important;border-color:'.$item['image_h_border_color'].' !important;}';
								}								
								if(!empty($item['image_h_border_radius'])){										
									if(!empty($item['image_h_border_radius']['top']) || !empty($item['image_h_border_radius']['right']) || !empty($item['image_h_border_radius']['bottom']) || !empty($item['image_h_border_radius']['left'])){
										$loopcss .=$get_ele_pre.' img{border-radius: '.$item['image_h_border_radius']['top'].$item['image_h_border_radius']['unit'].' '.$item['image_h_border_radius']['right'].$item['image_h_border_radius']['unit'].' '.$item['image_h_border_radius']['bottom'].$item['image_h_border_radius']['unit'].' '.$item['image_h_border_radius']['left'].$item['image_h_border_radius']['unit'].' !important;}';
									}										
								}								
								if(!empty($item['image_box_shadow_hover_cst']) && $item['image_box_shadow_hover_cst']=='yes'){
									$loopcss .=$get_ele_pre.' img{box-shadow: '.$item['image_box_shadow_horizontal']['size'].'px '.$item['image_box_shadow_vertical']['size'].'px '.$item['image_box_shadow_blur']['size'].'px '.$item['image_box_shadow_spread']['size'].'px '.$item['image_box_shadow_color'].' !important;}';
								}
								if(!empty($item['image_opacity_hover_cst']['size'])){
									$loopcss .= $get_ele_pre.' img{ opacity: '.$item['image_opacity_hover_cst']['size'].' !important;}';
								}	
								if(!empty($item['image_css_filter_hover_cst']) && $item['image_css_filter_hover_cst']=='yes'){
									$loopcss .= $get_ele_pre.' img{filter:brightness( '.$item['image_css_filter_brightness']['size'].'% ) contrast( '.$item['image_css_filter_contrast']['size'].'% ) saturate( '.$item['image_css_filter_saturation']['size'].'% ) blur( '.$item['image_css_filter_blur']['size'].'px ) hue-rotate( '.$item['image_css_filter_hue']['size'].'deg ) !important}';
								}															
							}							
						}
						/*style tag for hover end*/
						
				$i++;
				}
				
			$hover_card .= $loopitem;
			$hover_card .= '</div>';
				$loopcss .='.tp-hover-card-wrapper{position:relative;display:block;width:100%;height:100%;}
				.tp-hover-card-wrapper * {transition:all 0.3s linear}';
				if(!empty($loopcss)){
					$hover_card .='<style>'.$loopcss.'</style>';
				}
				
		echo $hover_card;
	}
	
    protected function content_template() {
	
    }

}
