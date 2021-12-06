<?php 
/*
Widget Name: Heading Animattion 
Description: Text Animation of style.
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


class L_ThePlus_Heading_Animation extends Widget_Base {
		
	public function get_name() {
		return 'tp-heading-animation';
	}

    public function get_title() {
        return esc_html__('Heading Animation', 'tpebl');
    }

    public function get_icon() {
        return 'fa fa-i-cursor theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-creatives');
    }

    protected function _register_controls() {
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Text Animation', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'anim_styles',[
				'label' => esc_html__( 'Animation Style','tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'style-1' => esc_html__( 'Style 1','tpebl' ),
					'style-2' => esc_html__( 'Style 2','tpebl' ),
					'style-3' => esc_html__( 'Style 3','tpebl' ),
					'style-4' => esc_html__( 'Style 4','tpebl' ),
					'style-5' => esc_html__( 'Style 5','tpebl' ),
					'style-6' => esc_html__( 'Style 6','tpebl' ),
				],
			]
		);
		$this->add_control(
            'prefix',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__('Prefix Text', 'tpebl'),
                'label_block' => true,
                'description' => esc_html__('Enter Text, Which will be visible before the Animated Text.', 'tpebl'),
                'separator' => 'before',
                'default' => esc_html__('This is ', 'tpebl'),
				'dynamic' => [
					'active'   => true,
				],
            ]
        );
		$this->add_control(
			'ani_title',
			[
				'label' => esc_html__( 'Animated Text', 'tpebl' ),
				'type' => Controls_Manager::TEXTAREA,
				'description' => esc_html__( 'You need to add Multiple line by ctrl + Enter Or Shift + Enter for animated text.', 'tpebl' ),
				'rows' => 5,
				'default' => esc_html__( 'Heading', 'tpebl' ),
				'placeholder' => esc_html__( 'Type your description here', 'tpebl' ),
				'dynamic' => [
					'active'   => true,
				],
			]
		);
		$this->add_control(
            'ani_title_tag', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Animated Text Tag', 'tpebl'),
                'default' => 'h1',
                'options' => l_theplus_get_tags_options(),
            ]
        );
		$this->add_control(
            'postfix',
            [
                'type' => Controls_Manager::TEXT,
                'label' => esc_html__('Postfix Text', 'tpebl'),
                'label_block' => true,
                'description' => esc_html__('Enter Text, Which will be visible After the Animated Text.', 'tpebl'),
                'separator' => 'before',
                'default' => esc_html__('Animation', 'tpebl'),
				'dynamic' => [
					'active'   => true,
				],
            ]
        );
		$this->add_responsive_control(
			'heading_text_align',
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
                    '{{WRAPPER}} .pt-plus-heading-animation .pt-plus-cd-headline,{{WRAPPER}} .pt-plus-heading-animation .pt-plus-cd-headline span' => 'text-align: {{VALUE}};',
                ],
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
            'section_prefix_postfix_styling',
            [
                'label' => esc_html__('Prefix and Postfix', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
            'heading_anim_color',
            [
                'label' => esc_html__('Font Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => '#313131',
                'selectors' => [
                    '{{WRAPPER}} .pt-plus-heading-animation .pt-plus-cd-headline,{{WRAPPER}} .pt-plus-heading-animation .pt-plus-cd-headline span' => 'color: {{VALUE}};',
                ],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'prefix_postfix_typography',
				'selector' => '{{WRAPPER}} .pt-plus-heading-animation .pt-plus-cd-headline,{{WRAPPER}} .pt-plus-heading-animation .pt-plus-cd-headline span',
			]
		);
		$this->end_controls_section();
		
		$this->start_controls_section(
            'section_heading_animation_styling',
            [
                'label' => esc_html__('Animated Text', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
            'ani_color',
            [
                'label' => esc_html__('Font Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => '#313131',
                'selectors' => [
                    '{{WRAPPER}} .pt-plus-heading-animation .pt-plus-cd-headline b' => 'color: {{VALUE}};',
                ],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'ani_typography',
				'selector' => '{{WRAPPER}} .pt-plus-heading-animation .pt-plus-cd-headline b',
			]
		);
		$this->add_control(
            'ani_bg_color',
            [
                'label' => esc_html__('Animation Background Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'default' => '#d3d3d3',
				'condition' => [
					'anim_styles!' => ['style-6'],
				],
                'selectors' => [
                    '{{WRAPPER}} .pt-plus-heading-animation:not(.head-anim-style-6) .pt-plus-cd-headline b' => 'background: {{VALUE}};',
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
	 protected function render() {

        $settings = $this->get_settings_for_display();
		$anim_styles=$settings["anim_styles"];
		$prefix=$settings["prefix"];
		$postfix=$settings["postfix"];
		$ani_title=$settings["ani_title"];
		$ani_title_tag=!empty($settings["ani_title_tag"]) ? $settings["ani_title_tag"] : 'h1';
		
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
			
			$heading_animation_back = 'style="';
			if($settings["ani_bg_color"] != "") {
				$heading_animation_back .='background: '.esc_attr($settings["ani_bg_color"]).';';
			}
			$heading_animation_back .= '"';		
				
				
			// Order of replacement
			$order   = array("\r\n", "\n", "\r", "<br/>", "<br>");
			$replace = '|';
				
			// Processes \r\n's first so they aren't converted twice.
			$str = str_replace($order, $replace, $ani_title);
			
			$lines = explode("|", $str);
			
			$count_lines = count($lines);
				
			$background_css='';
			if(!empty($settings["ani_color"])) {
				$background_css .= 'background-color: '.esc_attr($settings["ani_color"]).';';
			}
		
		$uid=uniqid('heading-animation');
		
		$heading_animation ='<div class="pt-plus-heading-animation heading-animation head-anim-'.esc_attr($anim_styles).' '.esc_attr($animated_class).' '.esc_attr($uid).'"  '.$animation_attr.'>';
		
		if ($anim_styles == 'style-1') {	
			$heading_animation .='<'.l_theplus_validate_html_tag($ani_title_tag).' class="pt-plus-cd-headline letters type" >';
			if($prefix != ''){
				$heading_animation .='<span >'.$prefix.' </span>';	
			}
			$heading_animation .='<span class="cd-words-wrapper waiting" '.$heading_animation_back.'>';
			$i=0;
			foreach($lines as $line)
			{
				if($i==0){
					
					$heading_animation .= '<b  class="is-visible"> '.strip_tags($line).'</b>';
					
					}else{
					$heading_animation .= '<b> '.strip_tags($line).'</b>';
				}
				$i++;
			}
			
			$strings = '['; 
			foreach($lines as $key => $line)  
			{ 
				$strings .= trim(htmlspecialchars_decode(strip_tags($line)));
				if($key != ($count_lines-1))
				$strings .= ','; 
			} 
			$strings .= ']';		
			$heading_animation .='</span>';
			if($postfix != ''){
				$heading_animation .='<span > '.esc_html($postfix).' </span>';	
			}
			$heading_animation .='</'.l_theplus_validate_html_tag($ani_title_tag).'>';
		}
		if ($anim_styles == 'style-2') {
			$heading_animation .='<'.l_theplus_validate_html_tag($ani_title_tag).' class="pt-plus-cd-headline rotate-1" >';
			if($prefix != ''){
				$heading_animation .='<span >'.esc_html($prefix).' </span>';	
			}	
			$heading_animation .='<span class="cd-words-wrapper">';
			$i=0;
			foreach($lines as $line)
			{
				if($i==0){
					
					$heading_animation .= '<b  class="is-visible"> '.strip_tags($line).'</b>';
					
					}else{
					$heading_animation .= '<b> '.strip_tags($line).'</b>';
				}
				$i++;
			} 
			$strings = '['; 
			foreach($lines as $key => $line)  
			{ 
				$strings .= trim(htmlspecialchars_decode(strip_tags($line)));
				if($key != ($count_lines-1))
				$strings .= ','; 
			} 
			$strings .= ']';
			$heading_animation .='</span>';	
			if($postfix != ''){
				$heading_animation .='<span > '.esc_html($postfix).' </span>';	
			}
			$heading_animation .='</'.l_theplus_validate_html_tag($ani_title_tag).'>';	
		}
		if ($anim_styles == 'style-3') {
			$heading_animation .='<'.l_theplus_validate_html_tag($ani_title_tag).' class="pt-plus-cd-headline zoom" >';
			if($prefix != ''){
				$heading_animation .='<span >'.esc_html($prefix).' </span>';	
			}	
			$heading_animation .='<span class="cd-words-wrapper">';
			$i=0;
			foreach($lines as $line)
			{
				if($i==0){
					
					$heading_animation .= ' <b  class="is-visible ">'.strip_tags($line).'</b>';
					
					}else{
					$heading_animation .= ' <b>'.strip_tags($line).'</b>';
				}
				$i++;
			}
			
			$strings = '['; 
			foreach($lines as $key => $line)  
			{ 
				$strings .= trim(htmlspecialchars_decode(strip_tags($line)));
				if($key != ($count_lines-1))
				$strings .= ','; 
			} 
			$strings .= ']';
			$heading_animation .='</span>';
			if($postfix != ''){
				$heading_animation .='<span > '.esc_html($postfix).' </span>';	
			}		
			$heading_animation .='</'.l_theplus_validate_html_tag($ani_title_tag).'>';	
		}
		if ($anim_styles == 'style-4') {
			$heading_animation .='<'.l_theplus_validate_html_tag($ani_title_tag).' class="pt-plus-cd-headline loading-bar " >';
			if($prefix != ''){
				$heading_animation .='<span >'.esc_html($prefix).' </span>';	
			}
			$heading_animation .='<span class="cd-words-wrapper">';
			$i=0;
			foreach($lines as $line)
			{
				if($i==0){
					
					$heading_animation .= ' <b class="is-visible ">'.strip_tags($line).'</b>';
					
					}else{
					$heading_animation .= ' <b>'.strip_tags($line).'</b>';
				}
				$i++;
			}
			
			$strings = '['; 
			foreach($lines as $key => $line)  
			{ 
				$strings .= trim(htmlspecialchars_decode(strip_tags($line)));
				if($key != ($count_lines-1))
				$strings .= ','; 
			} 
			$strings .= ']';				
			$heading_animation .='</span>';	
			if($postfix != ''){
				$heading_animation .='<span > '.esc_html($postfix).'</span>';	
			}		
			$heading_animation .='</'.l_theplus_validate_html_tag($ani_title_tag).'>';	
		}		
		if ($anim_styles == 'style-5') {
			$heading_animation .='<'.l_theplus_validate_html_tag($ani_title_tag).' class="pt-plus-cd-headline push" >';
			if($prefix != ''){
				$heading_animation .='<span >'.esc_html($prefix).' </span>';	
			}
			$heading_animation .='<span class="cd-words-wrapper">';
			$i=0;
			foreach($lines as $line)
			{
				if($i==0){
					
					$heading_animation .= '<b  class="is-visible "> '.strip_tags($line).'</b>';
					
					}else{
					$heading_animation .= '<b> '.strip_tags($line).'</b>';
				}
				$i++;
			}
			
			$strings = '['; 
			foreach($lines as $key => $line)  
			{ 
				$strings .= trim(htmlspecialchars_decode(strip_tags($line)));
				if($key != ($count_lines-1))
				$strings .= ','; 
			} 
			$strings .= ']';
			$heading_animation .='</span>';	
			if($postfix != ''){
				$heading_animation .='<span > '.esc_html($postfix).' </span>';	
			}		
			$heading_animation .='</'.l_theplus_validate_html_tag($ani_title_tag).'>';
		}
		if ($anim_styles == 'style-6') {
			$heading_animation .='<'.l_theplus_validate_html_tag($ani_title_tag).' class="pt-plus-cd-headline letters scale" >';
			if($prefix != ''){
				$heading_animation .='<span >'.esc_html($prefix).' </span>';	
			}
			$heading_animation .='<span class="cd-words-wrapper style-6"   >';
			$i=0;
			foreach($lines as $line)
			{
				if($i==0){
					
					$heading_animation .= '<b  class="is-visible ">'.strip_tags($line).'</b>';
					
					}else{
					$heading_animation .= '<b>'.strip_tags($line).'</b>';
				}
				$i++;
			}
			
			$strings = '['; 
			foreach($lines as $key => $line)  
			{ 
				$strings .= trim(htmlspecialchars_decode(strip_tags($line)));
				if($key != ($count_lines-1))
				$strings .= ','; 
			} 
			$strings .= ']';
				$heading_animation .='</span>';	
			if($postfix != ''){
				$heading_animation .='<span > '.esc_html($postfix).' </span>';	
			}
			$heading_animation .='</'.l_theplus_validate_html_tag($ani_title_tag).'>';	
		}
		$heading_animation .='</div>';
				
		$css_rule='';
		$css_rule .= '<style>';
			$css_rule .= '.'.esc_js($uid).' .pt-plus-cd-headline.loading-bar .cd-words-wrapper::after{'.esc_js($background_css).'}';
		$css_rule .= '</style>';
		echo $css_rule.$heading_animation;
	}
    protected function content_template() {
	
    }

}