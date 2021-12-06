<?php 
/*
Widget Name: Post Author
Description: Post Author
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


class L_ThePlus_Post_Author extends Widget_Base {
		
	public function get_name() {
		return 'tp-post-author';
	}

    public function get_title() {
        return esc_html__('Post Author', 'tpebl');
    }

    public function get_icon() {
        return 'fa fa-user theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-builder');
    }
	
    protected function _register_controls() {
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Post Author', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'style',
			[
				'label' => esc_html__( 'Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					"style-1" => esc_html__("Style 1", 'tpebl'),
					"style-2" => esc_html__("Style 2", 'tpebl'),
				],
			]
		);
		$this->add_responsive_control(
            'st2_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Max Width', 'tpebl'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
						'step' => 1,
					],
				],				
				'render_type' => 'ui',
				'condition'    => [
					'style' => 'style-2',					
				],
				'selectors' => [
					'{{WRAPPER}} .tp-author-details.style-2' => 'max-width: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->add_responsive_control(
			'st2_content_align',
			[
				'label' => esc_html__( 'Content Alignment', 'tpebl' ),
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
				'condition'    => [
					'style' => 'style-2',					
				],
				'selectors' => [
					'{{WRAPPER}} .tp-author-details.style-2 *' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',	
			]
		);
		$this->add_responsive_control(
			'st2_align',
			[
				'label' => esc_html__( 'Box Alignment', 'tpebl' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'tpebl' ),
						'icon' => 'eicon-text-align-left',
					],
					'unset' => [
						'title' => esc_html__( 'Center', 'tpebl' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'tpebl' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'unset',
				'condition'    => [
					'style' => 'style-2',					
				],
				'selectors' => [
					'{{WRAPPER}} .tp-author-details.style-2' => 'float: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
		/*Content Section End*/
		/*Post Author Name*/
		$this->start_controls_section(
            'section_author_name_style',
            [
                'label' => esc_html__('Author Name', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'ShowName',
            [
				'label' => esc_html__( 'Show Author Name', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'yes',	
			]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'nameTypo',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tp-author-details .author-name',
				'condition' => [
					'ShowName' => 'yes',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_author_style' );
		$this->start_controls_tab(
			'tab_author_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
				'condition' => [
					'ShowName' => 'yes',
				],				
			]
		);
		$this->add_control(
			'nameNormalColor',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tp-author-details .author-name' => 'color: {{VALUE}}',
				],
				'condition' => [
					'ShowName' => 'yes',
				],	
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_author_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
				'condition' => [
					'ShowName' => 'yes',
				],	
			]
		);
		$this->add_control(
			'nameHoverColor',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tp-author-details:hover .author-name' => 'color: {{VALUE}}',
				],
				'condition' => [
					'ShowName' => 'yes',
				],	
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();		
		$this->end_controls_section();
		/*Post Author Name*/
		
		/*Post Author Role*/
		$this->start_controls_section(
            'section_author_role_style',
            [
                'label' => esc_html__('Author Role', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'ShowRole',
            [
				'label' => esc_html__( 'Show Author Role', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'yes',	
			]
        );
		$this->add_control(
			'roleLabel',
			[
				'label' => esc_html__( 'Label', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => ['active' => true,],
				'default' => esc_html__( 'Role : ', 'tpebl' ),
				'placeholder' => esc_html__( 'Enter Label', 'tpebl' ),
				'condition' => [
					'ShowRole' => 'yes',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'roleTypo',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tp-author-details .tp-author-role',
				'condition' => [
					'ShowRole' => 'yes',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_author_role_style' );
		$this->start_controls_tab(
			'tab_author_role_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
				'condition' => [
					'ShowRole' => 'yes',
				],				
			]
		);
		$this->add_control(
			'roleNormalColor',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tp-author-details .tp-author-role' => 'color: {{VALUE}}',
				],
				'condition' => [
					'ShowRole' => 'yes',
				],	
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_author_role_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
				'condition' => [
					'ShowRole' => 'yes',
				],	
			]
		);
		$this->add_control(
			'roleHoverColor',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tp-author-details:hover .tp-author-role' => 'color: {{VALUE}}',
				],
				'condition' => [
					'ShowRole' => 'yes',
				],	
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();		
		$this->end_controls_section();
		/*Post Author role*/
		/*Post Author Bio*/
		$this->start_controls_section(
            'section_author_bio_style',
            [
                'label' => esc_html__('Author Bio', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'ShowBio',
            [
				'label' => esc_html__( 'Show Bio', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'yes',	
			]
        );
		$this->add_responsive_control(
			'bioMargin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],				
				'selectors' => [
					'{{WRAPPER}} .tp-author-details .author-bio' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'ShowBio' => 'yes',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'bioTypo',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tp-author-details .author-bio',
				'condition' => [
					'ShowBio' => 'yes',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_author_bio_style' );
		$this->start_controls_tab(
			'tab_author_bio_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
				'condition' => [
					'ShowBio' => 'yes',
				],				
			]
		);
		$this->add_control(
			'bioNormalColor',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tp-author-details .author-bio' => 'color: {{VALUE}}',
				],
				'condition' => [
					'ShowBio' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_author_bio_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
				'condition' => [
					'ShowBio' => 'yes',
				],
			]
		);
		$this->add_control(
			'bioHoverColor',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tp-author-details:hover .author-bio' => 'color: {{VALUE}}',
				],
				'condition' => [
					'ShowBio' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();		
		$this->end_controls_section();
		/*Post Author Bio*/
		/*Post Author Avatar*/
		$this->start_controls_section(
            'section_author_avtar_style',
            [
                'label' => esc_html__('Author Avatar', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'ShowAvatar',
            [
				'label' => esc_html__( 'Show Avatar', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'yes',	
			]
        );
        $this->add_responsive_control(
            'avatarWidth',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Avatar Width', 'tpebl'),
				'size_units' => [ 'px','em' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
						'step' => 1,
					],
				],				
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-author-details .author-avatar' => 'max-width: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
				'condition' => [
					'ShowAvatar' => 'yes',
				],
            ]
        );
        $this->add_responsive_control(
			'avatarBorderRadius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-author-details .author-avatar,{{WRAPPER}} .tp-author-details .author-avatar img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],	
				'condition' => [
					'ShowAvatar' => 'yes',
				],			
			]
		);	
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'avatarBoxShadow',
				'selector' => '{{WRAPPER}} .tp-author-details .author-avatar',
				'condition' => [
					'ShowAvatar' => 'yes',
				],	
			]
		);
        $this->end_controls_section();
		/*Post Author Avatar*/
	    /*Post Social Links*/
		$this->start_controls_section(
            'section_social_links_style',
            [
                'label' => esc_html__('Social Links', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'ShowSocial',
            [
				'label' => esc_html__( 'Show Social', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'yes',	
			]
        );
        $this->add_responsive_control(
            'socialSize',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Social Size', 'tpebl'),
				'size_units' => [ 'px','em' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 1000,
						'step' => 1,
					],
				],				
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-author-details ul.author-social li a' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
				'condition' => [
					'ShowSocial' => 'yes',
				],	
            ]
        );	
        $this->start_controls_tabs( 'tabs_social_style' );
		$this->start_controls_tab(
			'tab_social_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
				'condition' => [
					'ShowSocial' => 'yes',
				],				
			]
		);
		$this->add_control(
			'socialNormalColor',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tp-author-details ul.author-social li a' => 'color: {{VALUE}}',
				],
				'condition' => [
					'ShowSocial' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_social_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
				'condition' => [
					'ShowSocial' => 'yes',
				],
			]
		);
		$this->add_control(
			'socialHoverColor',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .tp-author-details ul.author-social li a:hover' => 'color: {{VALUE}}',
				],
				'condition' => [
					'ShowSocial' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();	
        $this->end_controls_section();
		/*Post Social Links*/
		/*Content Background*/
		$this->start_controls_section(
            'section_content_bg_style',
            [
                'label' => esc_html__('Content Background', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_responsive_control(
			'padding',
			[
				'label' => esc_html__( 'Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
							'top' => '',
							'right' => '',
							'bottom' => '',
							'left' => '',
							'isLinked' => false 
				],
				'selectors' => [
					'{{WRAPPER}} .tp-author-details' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',	
			]
		);
		$this->start_controls_tabs( 'tabs_content_bg_style' );
		$this->start_controls_tab(
			'tab_content_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),				
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'boxBg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .tp-author-details',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'boxBorder',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} .tp-author-details',	
			]
		);
		$this->add_responsive_control(
			'boxBorderRadius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-author-details' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],		
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'boxBoxShadow',
				'selector' => '{{WRAPPER}} .tp-author-details',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_content_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'boxBgHover',
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .tp-author-details:hover',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'boxBorderHover',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} .tp-author-details:hover',
			]
		);
		$this->add_responsive_control(
			'boxBorderRadiusHover',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-author-details:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],			
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'boxBoxShadowHover',
				'selector' => '{{WRAPPER}} .tp-author-details:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Content Background*/
	}
		
    protected function render() {

       $settings = $this->get_settings_for_display();

        $post_id = get_queried_object_id();
		$post = get_queried_object();
		$uid_psauthor=uniqid('tp-author');
		$style = (!empty($settings['style'])) ? $settings['style'] : 'style-1';
		$ShowName = (!empty($settings['ShowName'])) ? $settings['ShowName'] : false;
		$ShowRole = (!empty($settings['ShowRole'])) ? $settings['ShowRole'] : false;
		$ShowBio = (!empty($settings['ShowBio'])) ? $settings['ShowBio'] : false;
		$ShowAvatar = (!empty($settings['ShowAvatar'])) ? $settings['ShowAvatar'] : false;
		$ShowSocial = (!empty($settings['ShowSocial'])) ? $settings['ShowSocial'] : false;

		$outputavatar=$outputname=$outputrole=$outputbio=$authorsocial='';
		if(!empty($post)){
			$author_page_url = get_author_posts_url($post->post_author);
			$avatar_url = get_avatar_url($post->post_author);
			$author_bio =  get_the_author_meta('user_description',$post->post_author);
			if($ShowName){
				$author_name = get_the_author_meta('display_name', $post->post_author);
				$outputname .='<a href="'.esc_url($author_page_url).'" class="author-name tp-author-trans" rel="'.esc_attr__('author','tpebl').'" >'.$author_name.'</a>';
			}	
			if($ShowRole){
				$outputrole .='<span class="tp-author-role">'.esc_html($settings['roleLabel']).get_the_author().'</span>';
			}
			if($ShowAvatar){
				$outputavatar .= '<a href="'.esc_url($author_page_url).'" rel="'.esc_attr__('author','tpebl').'" class="author-avatar tp-author-trans"><img src="'.esc_url($avatar_url).'" /></a>';
			}
			if($ShowBio){
				$outputbio .= '<div class="author-bio tp-author-trans" >'.$author_bio.'</div>';
			}
			if($ShowSocial){
				$author_website =  get_the_author_meta('user_url',$post->post_author);
				$author_email =  get_the_author_meta('email',$post->post_author);
				$author_number = get_the_author_meta('tp_phone_number', $post->post_author);
				$author_facebook = get_the_author_meta('tp_profile_facebook', $post->post_author);
				$author_twitter = get_the_author_meta('tp_profile_twitter', $post->post_author);
				$author_instagram = get_the_author_meta('tp_profile_instagram', $post->post_author);
							
				$authorsocial .= '<ul class="author-social">';
					if(!empty($author_website)){
						$authorsocial .= '<li><a href="'.esc_url($author_website).'" rel="'.esc_attr__("website","theplus").'" target="_blank"><i class="fas fa-globe-americas"></i></a></li>';
					}
					if(!empty($author_email)){
						$authorsocial .= '<li><a href="mailto:'.esc_attr($author_email).'" rel="'.esc_attr__("email","theplus").'"><i class="fas fa-envelope"></i></a></li>';
					}
					if(!empty($author_number)){
						$authorsocial .= '<li><a href="tel:'.esc_attr($author_number).'" rel="'.esc_attr__("author_number","theplus").'"><i class="fas fa-phone-alt"></i></a></li>';
					}
					if(!empty($author_facebook)){
						$authorsocial .= '<li><a href="'.esc_url($author_facebook).'" rel="'.esc_attr__("facebook","theplus").'" target="_blank"><i class="fab fa-facebook-f"></i></a></li>';
					}
					if(!empty($author_twitter)){
						$authorsocial .= '<li><a href="'.esc_url($author_twitter).'" rel="'.esc_attr__("twitter","theplus").'" target="_blank"><i class="fab fa-twitter" ></i></a></li>';
					}
					if(!empty($author_instagram)){
						$authorsocial .= '<li><a href="'.esc_url($author_instagram).'" rel="'.esc_attr__("instagram","theplus").'" target="_blank"><i class="fab fa-instagram"></i></a></li>';
					}					
				$authorsocial .='</ul>';
			}
		}
		$output = '<div class="tp-post-author-info">';
			$ll_bg = tp_bg_lazyLoad($settings['boxBg_image'],$settings['boxBgHover_image']);
			$output .= '<div class="tp-author-details '.esc_attr($style).' '.$ll_bg.'">';
				if($ShowAvatar){
					$output .=$outputavatar;
				}
				$output .='<div class="author-info">';
					if($ShowName){
						$output .=$outputname;
					}
					if($ShowRole){
						$output .=$outputrole;
					}
					if($ShowBio){
						$output .=$outputbio;
					}
					if($ShowSocial){
						$output .=$authorsocial;
					}
				$output .= '</div>';
			$output .= '</div>';
		$output .= "</div>";
		echo $output; 			
	}
	
    protected function content_template() {
	
    }
}