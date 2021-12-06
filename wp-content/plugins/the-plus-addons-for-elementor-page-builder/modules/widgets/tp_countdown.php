<?php 
/*
Widget Name: Countdown 
Description: Display countdown.
Author: Theplus
Author URI: https://posimyth.com
*/
namespace TheplusAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class L_ThePlus_Countdown extends Widget_Base {
		
	public function get_name() {
		return 'tp-countdown';
	}

    public function get_title() {
        return esc_html__('Countdown', 'tpebl');
    }

    public function get_icon() {
        return 'fa fa-clock-o theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-essential');
    }

    protected function _register_controls() {
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Countdown Date', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'counting_timer',
			[
				'label' => esc_html__( 'Launch Date', 'tpebl' ),
				'type' => Controls_Manager::DATE_TIME,
				'default'     => date( 'Y-m-d H:i', strtotime( '+1 month' ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) ),
				'description' => sprintf( esc_html__( 'Date set according to your timezone: %s.', 'tpebl' ), Utils::get_timezone_string() ),
			]
		);
		$this->add_control(
			'inline_style',
			[
				'label' => esc_html__( 'Inline Style', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'tpebl' ),
				'label_off' => esc_html__( 'Off', 'tpebl' ),
				'default' => 'no',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
            'section_downcount',
            [
                'label' => esc_html__('Label', 'tpebl'),
            ]
        );
		$this->add_control(
			'show_labels',
			[
				'label'   => esc_html__( 'Show Labels', 'tpebl' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		$this->add_control(
            'text_days',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__('Days Section Text', 'tpebl'),
                'label_block' => true,
                'separator' => 'before',
                'default' => esc_html__('Days', 'tpebl'),
				'condition'    => [
					'show_labels!' => '',
				],
            ]
        );
		$this->add_control(
            'text_hours',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__('Hours Section Text', 'tpebl'),
                'label_block' => true,
                'separator' => 'before',
                'default' => esc_html__('Hours', 'tpebl'),
				'condition'    => [
					'show_labels!' => '',
				],
            ]
        );
		$this->add_control(
            'text_minutes',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__('Minutes Section Text', 'tpebl'),
                'label_block' => true,
                'separator' => 'before',
                'default' => esc_html__('Minutes', 'tpebl'),
                'condition'    => [
					'show_labels!' => '',
				],
            ]
        );
		$this->add_control(
            'text_seconds',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__('Seconds Section Text', 'tpebl'),
                'label_block' => true,
                'separator' => 'before',
                'default' => esc_html__('Seconds', 'tpebl'),
				'condition'    => [
					'show_labels!' => '',
				],
            ]
        );
		$this->end_controls_section();
		$this->start_controls_section(
            'section_styling',
            [
                'label' => esc_html__('Counter Styling', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,				
            ]
        );
		$this->add_control(
            'number_text_color',
            [
                'label' => esc_html__('Counter Font Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .pt_plus_countdown li > span' => 'color: {{VALUE}};',
                ],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'numbers_typography',
				'scheme'   => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}}  .pt_plus_countdown li > span',
				'separator' => 'after',
			)
		);
		$this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'label' => esc_html__('Label Typography', 'tpebl'),
                'selector' => '{{WRAPPER}} .pt_plus_countdown li > h6',
				'separator' => 'after',
				'condition'    => [
					'show_labels!' => '',
				],
            ]
        );
		$this->start_controls_tabs( 'tabs_days_style' );

		$this->start_controls_tab(
			'tab_day_style',
			[
				'label' => esc_html__( 'Days', 'tpebl' ),
			]
		);
		$this->add_control(
            'days_text_color',
            [
                'label' => esc_html__('Text Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .pt_plus_countdown li.count_1 h6' => 'color:{{VALUE}};',
                ],
            ]
        );
		$this->add_control(
            'days_border_color',
            [
                'label' => esc_html__('Border Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .pt_plus_countdown li.count_1' => 'border-color:{{VALUE}};',
                ],
                'condition'    => [
                    'inline_style!' => 'yes',
                ],
            ]
        );
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'days_background',
				'label'     => esc_html__("Days Background",'tpebl'),
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt_plus_countdown li.count_1',
				
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_hour_style',
			[
				'label' => esc_html__( 'Hours', 'tpebl' ),
			]
		);
		$this->add_control(
            'hours_text_color',
            [
                'label' => esc_html__('Text Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .pt_plus_countdown li.count_2 h6' => 'color:{{VALUE}};',
                ],
            ]
        );
		$this->add_control(
            'hours_border_color',
            [
                'label' => esc_html__('Border Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .pt_plus_countdown li.count_2' => 'border-color:{{VALUE}};',
                ],
                'condition'    => [
                    'inline_style!' => 'yes',
                ],
            ]
        );
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'hours_background',
				'label'     => esc_html__("Background",'tpebl'),
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt_plus_countdown li.count_2',				
			]
		);
		$this->end_controls_tab();
		
		$this->start_controls_tab(
			'tab_minute_style',
			[
				'label' => esc_html__( 'Minutes', 'tpebl' ),
			]
		);
		$this->add_control(
            'minutes_text_color',
            [
                'label' => esc_html__('Text Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .pt_plus_countdown li.count_3 h6' => 'color:{{VALUE}};',
                ],
            ]
        );
		$this->add_control(
            'minutes_border_color',
            [
                'label' => esc_html__('Border Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .pt_plus_countdown li.count_3' => 'border-color:{{VALUE}};',
                ],
                'condition'    => [
                    'inline_style!' => 'yes',
                ],
            ]
        );
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'minutes_background',
				'label'     => esc_html__("Background",'tpebl'),
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt_plus_countdown li.count_3',				
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_second_style',
			[
				'label' => esc_html__( 'Seconds', 'tpebl' ),
			]
		);
		$this->add_control(
            'seconds_text_color',
            [
                'label' => esc_html__('Text Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .pt_plus_countdown li.count_4 h6' => 'color:{{VALUE}};',
                ],
            ]
        );
		$this->add_control(
            'seconds_border_color',
            [
                'label' => esc_html__('Border Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .pt_plus_countdown li.count_4' => 'border-color:{{VALUE}};',
                ],
                'condition'    => [
                    'inline_style!' => 'yes',
                ],
            ]
        );
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'seconds_background',
				'label'     => esc_html__("Background",'tpebl'),
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .pt_plus_countdown li.count_4',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_responsive_control(
			'counter_padding',
			[
				'label' => esc_html__( 'Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .pt_plus_countdown li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		$this->add_responsive_control(
			'counter_margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],				
				'selectors' => [
					'{{WRAPPER}} .pt_plus_countdown li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		$this->add_control(
			'count_border_style',
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
				'separator' => 'before',
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_countdown li' => 'border-style: {{VALUE}};',
				],
			]
		);
		$this->add_responsive_control(
			'count_border_width',
			[
				'label' => esc_html__( 'Border Width', 'tpebl' ),
				'type'  => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top'    => 3,
					'right'  => 3,
					'bottom' => 3,
					'left'   => 3,
				],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_countdown li' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'count_border_style!' => 'none',
				]
			]
		);
		$this->add_control(
			'count_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_countdown li' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'count_hover_shadow',
				'selector' => '{{WRAPPER}} .pt_plus_countdown li',
				'separator' => 'before',
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
		
		$data_attr='';
		
		
		$uid=uniqid('count_down');
			if (empty($settings['show_labels'])){
				$show_labels=$settings['show_labels'];
			}else{
				$show_labels='yes';
			}
			if (empty($settings['text_days'])){
				$text_days='Days';
			}else{
				$text_days=$settings['text_days'];
			}
			
			if (empty($settings['text_hours'])){
				$text_hours='Hours';
			}else{
				$text_hours=$settings['text_hours'];
			}
			
			if (empty($settings['text_minutes'])){
				$text_minutes='Minutes';
			}else{
				$text_minutes=$settings['text_minutes'];
			}
			
			if (empty($settings['text_seconds'])){
				$text_seconds='Seconds';
			}else{
				$text_seconds=$settings['text_seconds'];
			}
			$offset_time=get_option('gmt_offset');
			if(!empty($settings['counting_timer'])){
				$counting_timer=$settings['counting_timer'];
				$counting_timer= date('m/d/Y H:i:s',strtotime($counting_timer) );
			}else{
				$counting_timer='08/31/2019 12:00:00';
			}
			$data_attr .=' data-days="'.esc_attr($text_days).'"';
			$data_attr .=' data-hours="'.esc_attr($text_hours).'"';
			$data_attr .=' data-minutes="'.esc_attr($text_minutes).'"';
			$data_attr .=' data-seconds="'.esc_attr($text_seconds).'"';
			
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
			
			$inline_style= (!empty($settings["inline_style"]) && $settings["inline_style"]=='yes') ? 'count-inline-style' : '';
			?>
			<ul class="pt_plus_countdown <?php echo esc_attr($uid); ?> <?php echo esc_attr($inline_style); ?> <?php echo $animated_class; ?>" <?php echo $data_attr; ?> data-timer="<?php echo esc_attr($counting_timer); ?>" data-offset="<?php echo esc_attr($offset_time); ?>" <?php echo $animation_attr; ?>>
					<li class="count_1">
						<span class="days">00</span>
						<?php if(!empty($show_labels) && $show_labels=='yes'){ ?>
							<h6 class="days_ref"><?php echo esc_html($text_days); ?></h6>
						<?php } ?>
					</li>
					<li class="count_2">
						<span class="hours">00</span>
						<?php if(!empty($show_labels) && $show_labels=='yes'){ ?>
							<h6 class="hours_ref"><?php echo esc_html($text_hours); ?></h6>
						<?php } ?>
					</li>
					<li class="count_3">
						<span class="minutes">00</span>
						<?php if(!empty($show_labels) && $show_labels=='yes'){ ?>
						<h6 class="minutes_ref"><?php echo esc_html($text_minutes); ?></h6>
						<?php } ?>
					</li>
					<li class="count_4">
						<span class="seconds last">00</span>
						<?php if(!empty($show_labels) && $show_labels=='yes'){ ?>
						<h6 class="seconds_ref"><?php echo esc_html($text_seconds); ?></h6>
						<?php } ?>
					</li>
				</ul>
			<?php 
	}
    protected function content_template() {
	
    }

}