<?php 
/*
Widget Name: Blockquote
Description: Author Quote Style.
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

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class L_ThePlus_Block_Quote extends Widget_Base {
		
	public function get_name() {
		return 'tp-blockquote';
	}

    public function get_title() {
        return esc_html__('Blockquote', 'tpebl');
    }

    public function get_icon() {
        return 'fa fa-quote-left theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-essential');
    }

    protected function _register_controls() {
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Blockquote', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'style',
			[
				'label' => esc_html__( 'Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => l_theplus_get_style_list(2),
			]
		);
		$this->add_control(
			'content_description',
			[
				'label' => esc_html__( 'Quote Description', 'tpebl' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( '"I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo."', 'tpebl' ),
				'placeholder' => esc_html__( 'Type your block quote here', 'tpebl' ),
				'dynamic' => [
					'active'   => true,
				],
			]
		);
		$this->add_control(
			'quote_author',
			[
				'label' => esc_html__( 'Author', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'John Doe', 'tpebl' ),
				'dynamic' => [
					'active'   => true,
				],
				'condition' => [
					'style' => 'style-2',
				],
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
					'justify' => [
						'title' => esc_html__( 'Justify', 'tpebl' ),
						'icon' => 'eicon-text-align-justify',
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'prefix_class' => 'text-%s',
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
            'section_styling',
            [
                'label' => esc_html__('Typography', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => esc_html__('Typography', 'tpebl'),
                'selector' => '{{WRAPPER}} .plus_blockquote blockquote.quote-text > span,{{WRAPPER}} .plus_blockquote blockquote.quote-text',
            ]
        );
		$this->start_controls_tabs( 'tabs_quote_style' );
		$this->start_controls_tab(
			'tab_quote_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_control(
            'content_color',
            [
                'label' => esc_html__('Text Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => '#888',
                'selectors' => [
                    '{{WRAPPER}} .plus_blockquote blockquote.quote-text > span,{{WRAPPER}} .plus_blockquote blockquote.quote-text p,{{WRAPPER}} .plus_blockquote blockquote.quote-text' => 'color:{{VALUE}};',
                ],
            ]
        );
		$this->add_control(
            'author_color',
            [
                'label' => esc_html__('Author Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => '#888',
                'selectors' => [
                    '{{WRAPPER}} .plus_blockquote .quote-text .quote_author' => 'color:{{VALUE}};',
                ],
				'condition' => [
					'style' => 'style-2',
				],
            ]
        );
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_quote_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_control(
            'content_hover_color',
            [
                'label' => esc_html__('Text Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .plus_blockquote:hover blockquote.quote-text > span,{{WRAPPER}} .plus_blockquote:hover blockquote.quote-text p,{{WRAPPER}} .plus_blockquote:hover blockquote.quote-text' => 'color:{{VALUE}};',
                ],
            ]
        );
		$this->add_control(
            'author_hover_color',
            [
                'label' => esc_html__('Author Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .plus_blockquote:hover .quote-text .quote_author' => 'color:{{VALUE}};',
                ],
				'condition' => [
					'style' => 'style-2',
				],
            ]
        );
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'quote_color',
			[
				'label' => esc_html__( 'Quote Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#888',
				'selectors'  => [
					'{{WRAPPER}} .plus_blockquote.quote-style-2 .quote-left' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [
					'style' => 'style-2',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'text_shadow',
				'label' => esc_html__( 'Text Shadow', 'tpebl' ),
				'selector' => '{{WRAPPER}} .plus_blockquote.quote-style-2 .quote-left',
				'separator' => 'before',
				'condition' => [
					'style' => 'style-2',
				],
			]
		);
		$this->add_control(
			'quote_padding',
			[
				'label' => esc_html__( 'Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .plus_blockquote' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'quote_margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .plus_blockquote' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		/*background option*/
		$this->start_controls_section(
            'section_bg_option_styling',
            [
                'label' => esc_html__('Background Options', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
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
					'{{WRAPPER}} .plus_blockquote' => 'border-style: {{VALUE}};',
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
					'{{WRAPPER}} .plus_blockquote' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .plus_blockquote' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .plus_blockquote' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_border_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_control(
			'box_border_hover_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .plus_blockquote:hover' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .plus_blockquote:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector'  => '{{WRAPPER}} .plus_blockquote',
				
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
				'selector'  => '{{WRAPPER}} .plus_blockquote:hover',
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
				'selector' => '{{WRAPPER}} .plus_blockquote',
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
				'selector' => '{{WRAPPER}} .plus_blockquote:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*background option*/
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
		$content_description = $settings['content_description'];
		$quote_style = $settings['style'];
		$quote_author = $settings['quote_author'];
		
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
			
			$text_block ='<div class="pt-plus-text-block-wrapper" >';
				$text_block .='<div class="text_block_parallax">';
					$text_block .='<div class="plus_blockquote quote-'.esc_attr($quote_style).' '.esc_attr($animated_class).'" '.$animation_attr.'>';
						$text_block .= '<blockquote class="quote-text">';
							if($quote_style=='style-2'){
								$text_block .= '<i class="fa fa-quote-left quote-left" aria-hidden="true"></i>';
							}
							$text_block .= '<span>'.$content_description.'</span>';
							if($quote_style=='style-2' && !empty($quote_author)){
								$text_block .= '<p class="quote_author">'.esc_html($quote_author).'</p>';
							}
						$text_block .= '</blockquote>';
					$text_block .='</div>';
				$text_block .='</div>';
			$text_block .='</div>';
			
		echo $text_block;
	}
	
    protected function content_template() {
	
    }

}