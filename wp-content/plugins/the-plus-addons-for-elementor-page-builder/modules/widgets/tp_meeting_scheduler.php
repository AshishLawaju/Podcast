<?php 
/*
Widget Name: Meeting Scheduler
Description: Meeting Scheduler.
Author: Theplus
Author URI: https://posimyth.com
*/
namespace TheplusAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class L_ThePlus_Meeting_Scheduler extends Widget_Base {
		
	public function get_name() {
		return 'tp-meeting-scheduler';
	}

    public function get_title() {
        return esc_html__('Meeting Scheduler', 'tpebl');
    }

    public function get_icon() {
        return 'fa fa-calendar theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-adapted');
    }
	public function get_keywords() {
		return ['meeting scheduler','calendly','freebusy','free busy','meetingbird','meeting bird','vyte','xai','x ai'];
	}

    protected function _register_controls() {		
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Meeting Scheduler', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'scheduler_select',
			[
				'label' => esc_html__( 'Select', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'calendly',
				'options' => [
					'calendly'  => esc_html__( 'Calendly', 'tpebl' ),
					'freebusy'  => esc_html__( 'Freebusy', 'tpebl' ),
					'meetingbird'  => esc_html__( 'Meetingbird', 'tpebl' ),
					'vyte'  => esc_html__( 'Vyte', 'tpebl' ),
					'xai'  => esc_html__( 'X Ai', 'tpebl' ),
				],
			]
		);
		$this->add_control(
			'calendly_username',
			[
				'label' => esc_html__( 'User Name', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__( 'Enter User Name', 'tpebl' ),
				'description' => 'How to get Username from Calendly?  <a href="https://help.calendly.com/hc/en-us" class="theplus-btn" target="_blank">Get Steps!</a>',
				'dynamic' => ['active'=> true,],
				'condition'    => [
					'scheduler_select' => 'calendly',
				],
			]
		);
		$this->add_control(
			'calendly_time',
			[
				'label' => esc_html__( 'Time', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => '15min',
				'options' => [
					'15min'  => esc_html__( '15 Minutes', 'tpebl' ),					
					'30min'  => esc_html__( '30 Minutes', 'tpebl' ),					
					'60min'  => esc_html__( '60 Minutes', 'tpebl' ),					
					''  => esc_html__( 'All', 'tpebl' ),					
				],
				'condition'    => [
					'scheduler_select' => 'calendly',
				],
			]
		);
		$this->add_control(
			'calendly_event',
			[
				'label' => esc_html__( 'Display Event Type', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'yes',
				'condition'    => [
					'scheduler_select' => 'calendly',
					'calendly_time!' => '',
				],
			]
		);
		$this->add_control(
            'calendly_height',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Height', 'tpebl'),
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 10,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 650,
				],
				'render_type' => 'ui',
				'condition' => [
					'scheduler_select' => 'calendly',
				],
				'selectors' => [
					'{{WRAPPER}} .calendly-inline-widget,{{WRAPPER}} .calendly-wrapper' => 'height:{{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->add_control(
			'freebusy_url',
			[
				'label' => esc_html__( 'URL', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__( 'Enter URL', 'tpebl' ),
				'description' => 'How to get Freebusy URL?  <a href="https://help.freebusy.io/en/articles/3313368-how-to-share-your-availability-by-generating-a-link-though-your-freebusy-account" class="theplus-btn" target="_blank">Get Steps!</a>',
				'dynamic' => ['active'=> true,],
				'condition'    => [
					'scheduler_select' => 'freebusy',
				],
			]
		);
		$this->add_control(
            'freebusy_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Width', 'tpebl'),
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 10,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 600,
				],
				'render_type' => 'ui',
				'condition' => [
					'scheduler_select' => 'freebusy',
				],
            ]
        );
		$this->add_control(
            'freebusy_height',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Height', 'tpebl'),
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 10,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 600,
				],
				'render_type' => 'ui',
				'condition' => [
					'scheduler_select' => 'freebusy',
				],
            ]
        );
		$this->add_control(
			'freebusy_scroll',
			[
				'label' => esc_html__( 'Scroll Bar', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'no',
				'condition'    => [
					'scheduler_select' => 'freebusy',
				],
			]
		);
		$this->add_control(
			'meetingbird_url',
			[
				'label' => esc_html__( 'URL', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__( 'Enter URL', 'tpebl' ),				
				'description' => 'How to get Meeting Bird URL?  <a href="https://help.meetingbird.com/en/collections/168865-getting-started" class="theplus-btn" target="_blank">Get Steps!</a>',
				'dynamic' => ['active'=> true,],
				'condition'    => [
					'scheduler_select' => 'meetingbird',
				],
			]
		);
		$this->add_control(
            'meetingbird_height',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Min. Height', 'tpebl'),
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 10,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 600,
				],
				'render_type' => 'ui',
				'condition' => [
					'scheduler_select' => 'meetingbird',
				],
            ]
        );
		$this->add_control(
			'vyte_url',
			[
				'label' => esc_html__( 'URL', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__( 'Enter URL', 'tpebl' ),
				'description' => 'If you need help getting details. <a href="https://support.vyte.in/en/" class="theplus-btn" target="_blank">Helpdesk!</a>',
				'dynamic' => ['active'=> true,],
				'condition'    => [
					'scheduler_select' => 'vyte',
				],
			]
		);
		$this->add_control(
            'vyte_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Width', 'tpebl'),
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 10,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 600,
				],
				'render_type' => 'ui',
				'condition' => [
					'scheduler_select' => 'vyte',
				],
            ]
        );
		$this->add_control(
            'vyte_height',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Height', 'tpebl'),
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 10,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 600,
				],
				'render_type' => 'ui',
				'condition' => [
					'scheduler_select' => 'vyte',
				],
            ]
        );
		$this->add_control(
			'xai_username',
			[
				'label' => esc_html__( 'User Name', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__( 'Enter User Name', 'tpebl' ),
				'description' => 'If you need help getting details. <a href="https://help.x.ai/en/" class="theplus-btn" target="_blank">Helpdesk!</a>',
				'dynamic' => ['active'=> true,],
				'condition'    => [
					'scheduler_select' => 'xai',
				],
			]
		);
		$this->add_control(
			'xai_pagename',
			[
				'label' => esc_html__( 'Page Name', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'placeholder' => esc_html__( 'Enter Page Name', 'tpebl' ),
				'dynamic' => ['active'=> true,],
				'condition'    => [
					'scheduler_select' => 'xai',
				],
			]
		);
		$this->end_controls_section();
		/*style start*/
		$this->start_controls_section(
			'calendly_style',
				[
					'label' => esc_html__( 'Calendly Style', 'tpebl' ),
					'tab' => Controls_Manager::TAB_STYLE,
					'condition'    => [
						'scheduler_select' => 'calendly',
					],
				]
		);
		$this->add_control(
			'calendly_text_color',
			[
				'label' => esc_html__( 'Text', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
			]
		);
		$this->add_control(
			'calendly_primary_color',
			[
				'label' => esc_html__( 'Link', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
			]
		);
		$this->add_control(
			'calendly_background_color',
			[
				'label' => esc_html__( 'Background', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
			]
		);
		$this->end_controls_section();
		/*style end*/
	}
	
	 protected function render() {
        $settings = $this->get_settings_for_display();
		$scheduler_select=$settings['scheduler_select'];
		
		$output=$time_output=$calendly_event=$xai_output='';
		
		if(!empty($scheduler_select) && $scheduler_select=='calendly'){
			if(!empty($settings['calendly_username'])){
				
				$time=$settings['calendly_time'];
				if($time==''){
					$time_output .='';
				}else{
					$time_output .='/'.$time.'/';
				}
				$calendly_text_color = !empty($settings['calendly_text_color']) ? "&text_color=" . str_replace( '#', '', $settings['calendly_text_color'] ): '';
				$calendly_primary_color = !empty($settings['calendly_primary_color']) ? "&primary_color=" . str_replace( '#', '', $settings['calendly_primary_color'] ): '';
				$calendly_background_color = !empty($settings['calendly_background_color']) ? "&background_color=" . str_replace( '#', '', $settings['calendly_background_color'] ): '';
				
				if(!empty($settings['calendly_event']) && $settings['calendly_event']=='yes'){
					$calendly_event = '';
				}else{
					$calendly_event='hide_event_type_details=1';
				}
				$output .= '<div class="calendly-inline-widget" data-url="https://calendly.com/'.$settings['calendly_username'].$time_output.'?'.$calendly_event.$calendly_text_color.$calendly_primary_color.$calendly_background_color.'">';
				$output .= '</div>';
				$output .= ' <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js"></script>';
				if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ){
					$output .= '<div class="calendly-wrapper" style="width:100%; position:absolute; top:0; left:0; z-index:100;"></div>';
				}                
			}
		}else if(!empty($scheduler_select) && $scheduler_select=='freebusy'){
			$freebusy_scroll= !empty($settings['freebusy_scroll']) ? $settings['freebusy_scroll'] : 'no';
			
			if(!empty($settings['freebusy_url'])){
				$output .= '<iframe src="'.$settings['freebusy_url'].'" width="'.$settings['freebusy_width']['size'].'" height="'.$settings['freebusy_height']['size'].'" frameborder="0" scrolling="'.$freebusy_scroll.'"></iframe>';
			}
			
		}else if(!empty($scheduler_select) && $scheduler_select=='meetingbird'){
			if(!empty($settings['meetingbird_url'])){
				$output .= '<iframe src="'.$settings['meetingbird_url'].'" style="width: 100%; border: none; min-height: '.$settings['meetingbird_height']['size'].'px;"></iframe>';
			}
		}else if(!empty($scheduler_select) && $scheduler_select=='vyte'){
			if(!empty($settings['vyte_url'])){
				$output .= '<iframe src="'.$settings['vyte_url'].'" width="'.$settings['vyte_width']['size'].'" height="'.$settings['vyte_height']['size'].'" frameborder="0"></iframe>';
			}
		}else if(!empty($scheduler_select) && $scheduler_select=='xai'){
			if(!empty($settings['xai_username'])){
				if(!empty($settings['xai_pagename'])){
					$xai_output .= '/'.$settings['xai_pagename'];
				}
				$output .= '<script type="text/javascript" src="https://x.ai/embed/xdotai-embed.js" id="xdotaiEmbed" data-page="/'.$settings['xai_username'].$xai_output.'" data-height data-width data-element async></script>';
			}			
		}
		
		echo $output;
	}
    protected function content_template() {
	
    }

}
