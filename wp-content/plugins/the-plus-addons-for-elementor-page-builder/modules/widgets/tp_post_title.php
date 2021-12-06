<?php 
/*
Widget Name: Post Title
Description: Post Title
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

use TheplusAddons\L_Theplus_Element_Load;
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class L_ThePlus_Post_Title extends Widget_Base {
		
	public function get_name() {
		return 'tp-post-title';
	}

    public function get_title() {
        return esc_html__('Post Title', 'tpebl');
    }

    public function get_icon() {
        return 'fa fa-underline theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-builder');
    }

    protected function _register_controls() {
		/*Post Title*/
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Post Title', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'posttype',
			[
				'label' => esc_html__( 'Post Types', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'singlepage',
				'options' => [
					'singlepage' => esc_html__('Single Page', 'tpebl'),
					'archivepage' => esc_html__('Archive Page', 'tpebl'),
				],
			]
		);
		$this->add_control(
			'titleprefix',
			[
				'label' => esc_html__( 'Prefix Text', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => [
					'active'   => true,
				],
			]
		);
		$this->add_control(
			'titlepostfix',
			[
				'label' => esc_html__( 'Postfix Text', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'dynamic' => [
					'active'   => true,
				],
			]
		);
		$this->add_control(
			'titleTag',
			[
				'label' => esc_html__( 'Tag', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => [
					'h1' => esc_html__('H1', 'tpebl'),
					'h2' => esc_html__('H2', 'tpebl'),
					'h3' => esc_html__('H3', 'tpebl'),
					'h4' => esc_html__('H4', 'tpebl'),
					'h5' => esc_html__('H5', 'tpebl'),
					'h6' => esc_html__('H6', 'tpebl'),
					'div' => esc_html__('Div', 'tpebl'),
					'span' => esc_html__('Span', 'tpebl'),
					'p' => esc_html__('P', 'tpebl'),
				],
			]
		);
		$this->add_responsive_control(
			'alignment',
			[
				'label' => esc_html__( 'Alignment', 'tpebl' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'flex-start',		
				'options' => [
					'flex-start' => [
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
				'selectors' => [
					'{{WRAPPER}} .tp-post-title' => 'justify-content: {{VALUE}};',
				],		
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
		/*Post Title*/
		/*Extra Options*/
		$this->start_controls_section(
			'extra_opt_section',
			[
				'label' => esc_html__( 'Extra Options', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'titleLink',[
				'label'   => esc_html__( 'Link', 'tpebl' ),
				'type'    =>  Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
			]
		);
		$this->add_control(
			'limitCountType',
			[
				'label' => esc_html__( 'Length Limit', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__('No Limit', 'tpebl'),
					'limitByLetter' => esc_html__('Based on Letters', 'tpebl'),
					'limitByWord' => esc_html__('Based on Words', 'tpebl'),
				],
			]
		);		
		$this->add_control(
			'titleLimit',
			[
				'label' => esc_html__( 'Limit of Words/Character', 'tpebl' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 5000,
				'step' => 1,
				'default' => 10,
				'condition' => [					
					'limitCountType!' => 'default',
				],
			]
		);
		$this->end_controls_section();	
		/*Extra Options*/	
		/*Post Title Style*/
		$this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__('Title', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_responsive_control(
			'padding',
			[
				'label' => esc_html__( 'Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tp-post-title a,{{WRAPPER}} .tp-post-title .tp-entry-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',	
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tp-post-title a,{{WRAPPER}} .tp-post-title .tp-entry-title',	
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
			'NormalColor',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tp-post-title a,{{WRAPPER}} .tp-post-title .tp-entry-title' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'boxBg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tp-post-title a,{{WRAPPER}} .tp-post-title .tp-entry-title',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'boxBorder',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} .tp-post-title a,{{WRAPPER}} .tp-post-title .tp-entry-title',
			]
		);
		$this->add_responsive_control(
			'boxBorderRadius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-post-title a,{{WRAPPER}} .tp-post-title .tp-entry-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],			
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'boxBoxShadow',
				'selector' => '{{WRAPPER}} .tp-post-title a,{{WRAPPER}} .tp-post-title .tp-entry-title',
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
			'HoverColor',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tp-post-title a:hover,{{WRAPPER}} .tp-post-title .tp-entry-title:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'boxBgHover',
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .tp-post-title a:hover,{{WRAPPER}} .tp-post-title .tp-entry-title:hover',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'boxBorderHover',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} .tp-post-title a:hover,{{WRAPPER}} .tp-post-title .tp-entry-title:hover',
			]
		);
		$this->add_responsive_control(
			'boxBorderRadiusHover',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-post-title a:hover,{{WRAPPER}} .tp-post-title .tp-entry-title:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],		
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'boxBoxShadowHover',
				'selector' => '{{WRAPPER}} .tp-post-title a:hover,{{WRAPPER}} .tp-post-title .tp-entry-title:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Post Title Style*/
		/*Post prefix postfix*/
		$this->start_controls_section(
            'section_prepost_style',
            [
                'label' => esc_html__('Prefix/Postfix', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'conditions' => [
				    'relation' => 'or',
				    'terms' => [
				    	[
				        	'name' => 'titleprefix','operator' => '!=','value' => '',
				        ],
						[   							
							'name' => 'titlepostfix','operator' => '!=','value' => '',
						],
				    ],
				],
            ]
        );
		$this->add_responsive_control(
			'prepostpadding',
			[
				'label' => esc_html__( 'Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .tp-post-title .tp-post-title-prepost' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',	
			]
		);
		$this->add_responsive_control(
            'preoffset',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Prefix Offset', 'tpebl'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-post-title .tp-post-title-prepost.tp-prefix' => 'margin-right: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->add_responsive_control(
            'postoffset',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Postfix Offset', 'tpebl'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-post-title .tp-post-title-prepost.tp-postfix' => 'margin-left: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'preposttypography',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tp-post-title .tp-post-title-prepost',
				'separator' => 'after',	
			]
		);
		$this->add_control(
			'prepostColor',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tp-post-title .tp-post-title-prepost' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'prepostboxBg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tp-post-title .tp-post-title-prepost',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'prepostboxBorder',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} .tp-post-title .tp-post-title-prepost',
			]
		);
		$this->add_responsive_control(
			'prepostboxBorderRadius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-post-title .tp-post-title-prepost' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],		
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'prepostboxBoxShadow',
				'selector' => '{{WRAPPER}} .tp-post-title .tp-post-title-prepost',
			]
		);
		$this->end_controls_section();
		/*Post Prefix postfix*/
	}
	protected function render() {
		$settings = $this->get_settings_for_display();
		$post_id = get_the_ID();
		
	    $titletag = (!empty($settings['titleTag'])) ? $settings['titleTag'] : 'h3';
	    $titleLink = (!empty($settings['titleLink'])) ? $settings['titleLink'] : 'no';
        $limitCountType = (!empty($settings['limitCountType'])) ? $settings['limitCountType'] : '';
        $text_limit = (!empty($settings['titleLimit'])) ? $settings['titleLimit'] : '';
        $titleprefix = (!empty($settings['titleprefix'])) ? $settings['titleprefix'] : '';
        $titlepostfix = (!empty($settings['titlepostfix'])) ? $settings['titlepostfix'] : '';
		
		if($settings['posttype']=='archivepage'){
			add_filter( 'get_the_archive_title', function ($title) {    
				if ( is_category() ) {    
					$title = single_cat_title( '', false );    
				} else if ( is_tag() ) {    
					$title = single_tag_title( '', false );    
				} else if ( is_author() ) {    
					$title = '<span class="vcard">' . get_the_author() . '</span>' ;    
				} else if ( is_tax() ) {
					$title = sprintf( __( '%1$s' ), single_term_title( '', false ) );
				} else if (is_post_type_archive()) {
					$title = post_type_archive_title( '', false );
				} else if (is_search()) {
					$title = get_search_query();
				}
				return $title;    
			});
		}
					
		if(!empty($settings['posttype'])){
			if( $limitCountType == 'limitByWord' ){
				if($settings['posttype']=='singlepage'){
					$title = wp_trim_words(get_the_title($post_id),$text_limit);
				}else if($settings['posttype']=='archivepage'){
					$title = wp_trim_words(get_the_archive_title(),$text_limit);
				}			
			} else if( $limitCountType == 'limitByLetter' ){
				if($settings['posttype']=='singlepage'){
					$title = substr(wp_trim_words(get_the_title($post_id)),0, $text_limit) . '...';
				}else if($settings['posttype']=='archivepage'){
					$title = substr(wp_trim_words(get_the_archive_title()),0, $text_limit) . '...';
				}				
			} else {
				if($settings['posttype']=='singlepage'){
					$title = get_the_title($post_id);
				}else if($settings['posttype']=='archivepage'){					
					$title = get_the_archive_title();
				}				
			}
		}
		
		$output = '<div class="tp-post-title">';
			if(!empty($titleprefix)){
				$output .='<span class="tp-post-title-prepost tp-prefix">'.esc_html($titleprefix).'</span>';
			}
			if(!empty($titleLink) && $titleLink=='yes'){
				$output .= '<a href="'.get_the_permalink().'" >';
			}
			$output .= '<'.l_theplus_validate_html_tag($titletag).' class="tp-entry-title">';								
						$output .= $title;				
			$output .= '</'.l_theplus_validate_html_tag($titletag).'>';
			if(!empty($titleLink) && $titleLink=='yes'){
				$output .= "</a>";
			}
			if(!empty($titlepostfix)){
				$output .='<span class="tp-post-title-prepost tp-postfix">'.esc_html($titlepostfix).'</span>';
			}
		$output .= "</div>";
		
		 echo $output; 		
	}
	
    protected function content_template() {
	
    }
}