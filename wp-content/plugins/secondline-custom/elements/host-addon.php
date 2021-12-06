<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.


class Widget_SecondLineAddonsTeam_Member extends Widget_Base {

	public function get_name() {
		return 'secondline-addons-team-member';
	}

	public function get_title() {
		return esc_html__( 'SecondLine - Show Host', 'secondline-custom-plugin' );
	}

	public function get_icon() {
		return 'fas fa-user secondline-addons-icon';
	}

   public function get_categories() {
		return [ 'basic' ];
	}
	
	public function get_script_depends() { 
		return [ 'secondline_addons_team_js' ]; 
	}
	
	protected function _register_controls() {

		
  		
		
		
  		$this->start_controls_section(
  			'section_title_secondline_global_options',
  			[
  				'label' => esc_html__( 'Main Content', 'secondline-custom-plugin' )
  			]
  		);
		
		$this->add_control(
			'secondline_addons_team_title_text',
			[
				'label' => esc_html__( 'Name', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Mario Davis', 'secondline-custom-plugin' ),
			]
		);
		
		$this->add_inline_editing_attributes( 'secondline_addons_team_title_text', 'none' );
		
		$this->add_control(
			'secondline_addons_team_job_title_text',
			[
				'label' => esc_html__( 'Title', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Show Host', 'secondline-custom-plugin' ),
			]
		);
		$this->add_inline_editing_attributes( 'secondline_addons_team_job_title_text', 'none' );
		
		
		$this->add_control(
			'secondline_addons_team_sub_title_description',
			[
				'label' => esc_html__( 'Description', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Add a description for your show host or guest here!', 'secondline-custom-plugin' ),
			]
		);
		$this->add_inline_editing_attributes( 'secondline_addons_team_sub_title_description', 'none' );
		
		$this->add_control(
			'secondline_addons_team_button',
			[
				'label' => esc_html__( 'Button', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::TEXT,
			]
		);
		
		$this->add_control(
			'secondline_addons_team_button_icon',
			[
				'label' => esc_html__( 'Icon', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::ICONS,
				'condition' => [
					'secondline_addons_team_button!' => '',
				],
			]
		);

		$this->add_control(
			'secondline_addons_team_button_icon_align',
			[
				'label' => esc_html__( 'Icon Position', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => [
					'left' => esc_html__( 'Before', 'secondline-custom-plugin' ),
					'right' => esc_html__( 'After', 'secondline-custom-plugin' ),
				],
				'condition' => [
					'secondline_addons_team_button_icon!' => '',
				],
			]
		);

		$this->add_control(
			'secondline_addons_team_button_icon_indent',
			[
				'label' => esc_html__( 'Icon Spacing', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'max' => 50,
					],
				],
				'condition' => [
					'secondline_addons_team_button_icon!' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .open-team-member-button-icon-right' => 'margin-left: {{SIZE}}px;',
					'{{WRAPPER}} .open-team-member-button-icon-left' => 'margin-right: {{SIZE}}px;',
				],
			]
		);
		
		$this->add_control(
			'secondline_addons_team_link',
			[
				'type' => Controls_Manager::URL,
				'placeholder' => 'https://secondlinethemes.com',
				'label' => esc_html__( 'Link', 'secondline-custom-plugin' ),
			]
		);

		$this->end_controls_section();
			
  		$this->start_controls_section(
  			'section_title_secondline_image_options',
  			[
  				'label' => esc_html__( 'Image Options', 'secondline-custom-plugin' )
  			]
  		);
		
		$this->add_control(
			'secondline_addons_team_image',
			[
				'type' => Controls_Manager::MEDIA,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'full',
				'condition' => [
					'secondline_addons_team_image[url]!' => '',
				],
			]
		);
		
		$this->add_control(
			'secondline_addons_image_align',
			[
				'label' => esc_html__( 'Image Align', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'secondline_addons_image_align_top' => esc_html__( 'Top', 'secondline-custom-plugin' ),
					'secondline_addons_image_align_left' => esc_html__( 'Left', 'secondline-custom-plugin' ),
					'secondline_addons_image_align_right' => esc_html__( 'Right', 'secondline-custom-plugin' ),
				],
				'condition' => [
					'secondline_addons_team_image[url]!' => '',
				],
			]
		);
		
		$this->add_control(
			'secondline_addons_social_icon_overlay',
			[
				'label' => esc_html__( 'Overlay Content', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'secondline_addons_icon_default' => esc_html__( 'No Overlay', 'secondline-custom-plugin' ),
					'secondline_addons_icon_overlay_image' => esc_html__( 'Overlay Icons', 'secondline-custom-plugin' ),
					'secondline_addons_content_overlay_image' => esc_html__( 'Overlay All Content', 'secondline-custom-plugin' ),
				],
				'default' => 'secondline_addons_icon_default',
				'condition' => [
					'secondline_addons_social_show_hide!' => '',
				],
			]
		);
		
		$this->add_control(
			'secondline_addons_icon_overlay_background',
			[
				'label' => esc_html__( 'Overlay Background', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default' => "#cccccc",
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-image .secondline-addons-content-container-overlay' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'secondline_addons_social_icon_overlay!' => 'secondline_addons_icon_default',
				],
			]
		);
		
		
		$this->end_controls_section();
		
		
  		$this->start_controls_section(
  			'section_title_secondline_social_icon_options',
  			[
  				'label' => esc_html__( 'Social Icons', 'secondline-custom-plugin' )
  			]
  		);

		$this->add_control(
			'secondline_addons_social_show_hide',
			[
				'label' => esc_html__( 'Display Social Icons?', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		
		
		$this->add_control(
			'secondline_addons_social_icon_list',
			[
				'type' => Controls_Manager::REPEATER,
				'condition' => [
					'secondline_addons_social_show_hide!' => '',
				],
				'default' => [
					[
						'social' => [
							'value' => 'fab fa-facebook',
							'library' => 'fa-brands',
						],
					],
					[
						'social' => [
							'value' => 'fab fa-twitter',
							'library' => 'fa-brands',
						],
					],
					[
						'social' => [
							'value' => 'fab fa-linkedin',
							'library' => 'fa-brands',
						],
					],
					[
						'social' => [
							'value' => 'fab fa-instagram',
							'library' => 'fa-brands',
						],
					],
				],
				'fields' => [
					[
						'name' => 'social',
						'label' => esc_html__( 'Icon', 'secondline-custom-plugin' ),
						'type' => Controls_Manager::ICONS,
						'label_block' => true,
						'recommended' => [
							'fa-brands' => [
								'android',
								'apple',
								'behance',
								'bitbucket',
								'codepen',
								'delicious',
								'deviantart',
								'digg',
								'dribbble',
								'envelope',
								'facebook',
								'facebook-f',
								'flickr',
								'foursquare',
								'free-code-camp',
								'github',
								'gitlab',
								'globe',
								'google-plus',
								'houzz',
								'instagram',
								'jsfiddle',
								'link',
								'linkedin',
								'linkedin-in',
								'medium',
								'meetup',
								'mixcloud',
								'odnoklassniki',
								'pinterest',
								'product-hunt',
								'reddit',
								'rss',
								'shopping-cart',
								'skype',
								'slideshare',
								'snapchat',
								'soundcloud',
								'spotify',
								'stack-overflow',
								'steam',
								'stumbleupon',
								'telegram',
								'thumb-tack',
								'tripadvisor',
								'tumblr',
								'twitch',
								'twitter',
								'viber',
								'vimeo',
								'vk',
								'weibo',
								'weixin',
								'whatsapp',
								'wordpress',
								'xing',
								'yelp',
								'youtube',
								'500px',
							],
						],
					],
					[
						'name' => 'link',
						'label' => esc_html__( 'Link', 'secondline-custom-plugin' ),
						'type' => Controls_Manager::URL,
						'label_block' => true,
						'default' => [
							'url' => '',
							'is_external' => 'true',
						],
						'placeholder' => esc_html__( 'https://secondlinethemes.com', 'secondline-custom-plugin' ),
					],
				],
				'title_field' => '<i class="fab fa-{{{ elementor.helpers.getSocialNetworkNameFromIcon( social ) }}}"></i> - {{{ elementor.helpers.getSocialNetworkNameFromIcon( social ).replace( /\b\w/g, function( letter ){ return letter.toUpperCase() } ) }}}',
			]
		);
		
		
		
		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'section_team_main_styles',
			[
				'label' => esc_html__( 'Main Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		
		
		$this->add_control(
			'secondline_addons_team_main_background',
			[
				'label' => esc_html__( 'Background Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'default' => "#ffffff",
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-member-container' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'secondline_addons_team_padding',
			[
				'label' => esc_html__( 'Content Padding', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'secondline_addons_team_radius',
			[
				'label' => esc_html__( 'Border Radius', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-member-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'secondline_addons_team_border',
				'selector' => '{{WRAPPER}}  .secondline-addons-team-member-container',
			]
		);
		
		
		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'section_team_image_styles',
			[
				'label' => esc_html__( 'Image Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		
		$this->add_responsive_control(
			'secondline_team_image_align',
			[
				'label' => esc_html__( 'Align', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'secondline-custom-plugin' ),
						'icon' => 'fas fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'secondline-custom-plugin' ),
						'icon' => 'fas fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'secondline-custom-plugin' ),
						'icon' => 'fas fa-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-image' => 'text-align: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'secondline_team_image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-image img' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'secondline_team_image_spacing',
			[
				'label' => esc_html__( 'Spacing', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -15,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'section_team_text_styles',
			[
				'label' => esc_html__( 'Content Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		
		
		$this->add_control(
			'secondline_team_title_heading',
			[
				'type' => Controls_Manager::HEADING,
				'label' => esc_html__( 'Name', 'secondline-custom-plugin' ),
			]
		);
		
		$this->add_control(
			'secondline_addons_team_title_color',
			[
				'label' => esc_html__( 'Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-member-container h4.secondline-addons-team-heading' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'secondline_team_title_spacing',
			[
				'label' => esc_html__( 'Spacing', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -15,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-member-container h4.secondline-addons-team-heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'secondline_team_title_align',
			[
				'label' => esc_html__( 'Align', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'secondline-custom-plugin' ),
						'icon' => 'fas fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'secondline-custom-plugin' ),
						'icon' => 'fas fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'secondline-custom-plugin' ),
						'icon' => 'fas fa-align-right',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-member-container h4.secondline-addons-team-heading' => 'text-align: {{VALUE}}',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'secondline_addons_team_title_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .secondline-addons-team-member-container h4.secondline-addons-team-heading',
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'heading_text_shadow',
				'selector' => '{{WRAPPER}} .secondline-addons-team-member-container h4.secondline-addons-team-heading',
			]
		);
		
		
		
		$this->add_control(
			'secondline_addons_team_job_title',
			[
				'type' => Controls_Manager::HEADING,
				'label' => esc_html__( 'Job Position', 'secondline-custom-plugin' ),
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'secondline_addons_team_job_color',
			[
				'label' => esc_html__( 'Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-member-container h5.secondline-addons-team-job-title' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'secondline_team_job_spacing',
			[
				'label' => esc_html__( 'Spacing', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -15,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-member-container h5.secondline-addons-team-job-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'secondline_team_job_align',
			[
				'label' => esc_html__( 'Align', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'secondline-custom-plugin' ),
						'icon' => 'fas fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'secondline-custom-plugin' ),
						'icon' => 'fas fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'secondline-custom-plugin' ),
						'icon' => 'fas fa-align-right',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-member-container h5.secondline-addons-team-job-title' => 'text-align: {{VALUE}}',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'secondline_addons_team_job_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .secondline-addons-team-member-container h5.secondline-addons-team-job-title',
			]
		);
		
		
		
		$this->add_control(
			'secondline_addons_team_description',
			[
				'type' => Controls_Manager::HEADING,
				'label' => esc_html__( 'Description Styles', 'secondline-custom-plugin' ),
				'separator' => 'before',
			]
		);
		
		$this->add_control(
			'secondline_addons_team_description_color',
			[
				'label' => esc_html__( 'Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-member-container .secondline-addons-team-description' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'secondline_team_description_spacing',
			[
				'label' => esc_html__( 'Spacing', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -15,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-member-container .secondline-addons-team-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'secondline_team_description_align',
			[
				'label' => esc_html__( 'Align', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'secondline-custom-plugin' ),
						'icon' => 'fas fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'secondline-custom-plugin' ),
						'icon' => 'fas fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'secondline-custom-plugin' ),
						'icon' => 'fas fa-align-right',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-member-container .secondline-addons-team-description' => 'text-align: {{VALUE}}',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'secondline_addons_team_description_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .secondline-addons-team-member-container .secondline-addons-team-description',
			]
		);

		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'section_team_button_styles',
			[
				'label' => esc_html__( 'Button Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		
		$this->add_control(
			'secondline_addons_button_spacing',
			[
				'label' => esc_html__( 'Spacing', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -15,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-member-container .secondline-addons-button' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'secondline_button_alignment',
			[
				'label' => esc_html__( 'Align', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'secondline-custom-plugin' ),
						'icon' => 'fas fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'secondline-custom-plugin' ),
						'icon' => 'fas fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'secondline-custom-plugin' ),
						'icon' => 'fas fa-align-right',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-button-align' => 'text-align: {{VALUE}}',
				],
			]
		);
		
		
		$this->add_control(
			'secondline_flip_box_rear_button_padding',
			[
				'label' => esc_html__( 'Padding', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-member-container .secondline-addons-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'secondline_addons_button_border_radius',
			[
				'label' => esc_html__( 'Button Border Radius', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-member-container .secondline-addons-button' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
             'name' => 'secondline_flip_box_rear_btn_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .secondline-addons-team-member-container .secondline-addons-button',
			]
		);
		
		$this->start_controls_tabs( 'secondline_addons_button_tabs' );

		$this->start_controls_tab( 'normal', [ 'label' => esc_html__( 'Normal', 'secondline-custom-plugin' ) ] );

		$this->add_control(
			'secondline_addons_button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-member-container .secondline-addons-button' => 'color: {{VALUE}};',
				],
			]
		);
		

		
		$this->add_control(
			'secondline_addons_button_background_color',
			[
				'label' => esc_html__( 'Background Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-member-container .secondline-addons-button' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'secondline_addons_rear_btn_border',
				'selector' => '{{WRAPPER}} .secondline-addons-team-member-container .secondline-addons-button',
			]
		);

		
		$this->end_controls_tab();

		$this->start_controls_tab( 'secondline_addons_hover', [ 'label' => esc_html__( 'Hover', 'secondline-custom-plugin' ) ] );

		$this->add_control(
			'secondline_addons_button_hover_text_color',
			[
				'label' => esc_html__( 'Text Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-member-container .secondline-addons-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondline_addons_button_hover_background_color',
			[
				'label' => esc_html__( 'Background Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-member-container .secondline-addons-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondline_addons_button_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-team-member-container .secondline-addons-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();
		
		$this->end_controls_tabs();
		
		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'btn_text_shadow',
				'selector' => '{{WRAPPER}} .secondline-addons-team-member-container .secondline-addons-button',
			]
		);
		
		
		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'section_team_social_icons_styles',
			[
				'label' => esc_html__( 'Social Icon Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		

		$this->add_responsive_control(
			'secondline_addons_social_size',
			[
				'label' => esc_html__( 'Size', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 8,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-icons-container a' => 'font-size:{{SIZE}}{{UNIT}};',
				],
			]
		);
		
		
		$this->add_responsive_control(
			'secondline_addons_social_padding',
			[
				'label' => esc_html__( 'Padding', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-icons-container a' => 'line-height:{{SIZE}}{{UNIT}}; min-width:{{SIZE}}{{UNIT}}; min-height:{{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'secondline_addons_social_spacing',
			[
				'label' => esc_html__( 'Spacing', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -10,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-icons-container a' => 'margin:0px {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}};',
				],
			]
		);
		
				
		
		$this->add_responsive_control(
			'secondline_social_icon_alignment',
			[
				'label' => esc_html__( 'Align', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'secondline-custom-plugin' ),
						'icon' => 'fas fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'secondline-custom-plugin' ),
						'icon' => 'fas fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'secondline-custom-plugin' ),
						'icon' => 'fas fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-icons-container' => 'text-align: {{VALUE}}',
				],
			]
		);
		
		
		$this->add_control(
			'secondline_addons_icon_radius',
			[
				'label' => esc_html__( 'Border Radius', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors' => [
					'{{WRAPPER}}  .secondline-addons-icons-container a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		
		
		$this->start_controls_tabs( 'secondline_addons_social_tabs' );
		
		$this->start_controls_tab( 'normal_social_tab', [ 'label' => esc_html__( 'Normal', 'secondline-custom-plugin' ) ] );

		$this->add_control(
			'secondline_addons_socia_text_color',
			[
				'label' => esc_html__( 'Text Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-icons-container a' => 'color: {{VALUE}};',
				],
			]
		);
		

		
		$this->add_control(
			'secondline_addons_social_background_color',
			[
				'label' => esc_html__( 'Background Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-icons-container a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'secondline_addons_icon_border',
				'selector' => '{{WRAPPER}} .secondline-addons-icons-container a',
			]
		);

		
		$this->end_controls_tab();

		$this->start_controls_tab( 'secondline_addons_hover_social', [ 'label' => esc_html__( 'Hover', 'secondline-custom-plugin' ) ] );

		$this->add_control(
			'secondline_addons_social_hover_text_color',
			[
				'label' => esc_html__( 'Text Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-icons-container a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondline_addons_social_hover_background_color',
			[
				'label' => esc_html__( 'Background Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-icons-container a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'secondline_addons_social_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-addons-icons-container a:hover' => 'border-color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_tab();
		
		
		
		$this->end_controls_section();
		
		
		
		
	}


	protected function render( ) {
		
      $settings = $this->get_settings();
		
	?>
	
	

	<div class="secondline-addons-team-member-container <?php echo esc_attr($settings['secondline_addons_image_align'] ); ?>">	
		
	 <?php if ( ! empty( $settings['secondline_addons_team_image']['url'] ) ) : ?>
		<?php $image = $settings['secondline_addons_team_image'];  $image_url = Group_Control_Image_Size::get_attachment_image_src( $image['id'], 'thumbnail', $settings ); ?>
		<div class="secondline-addons-team-image"><?php if ( ! empty( $settings['secondline_addons_team_link']['url'] ) ) : ?><a href="<?php echo esc_url($settings['secondline_addons_team_link']['url']); ?>" <?php if ( ! empty( $settings['secondline_addons_team_link']['is_external'] ) ) : ?>target="_blank"<?php endif; ?> <?php if ( ! empty( $settings['secondline_addons_team_link']['nofollow'] ) ) : ?>rel="nofollow"<?php endif; ?>><?php endif; ?><img src="<?php echo esc_url($image_url);?>" alt="<?php echo esc_attr($settings['secondline_addons_team_title_text'] ); ?>"><?php if ( ! empty( $settings['secondline_addons_team_link']['url'] ) ) : ?></a><?php endif; ?>
		
		<?php if ( ! empty( $settings['secondline_addons_social_show_hide'] ) && $settings['secondline_addons_social_icon_overlay'] == "secondline_addons_icon_overlay_image"  ) : ?>
		<div class="secondline-addons-content-container-overlay">
			<div class="secondline-addons-overlay-table">
				<div class="secondline-addons-overlay-table-cell">
					<div class="secondline-addons-icons-container">
					
					<?php foreach ( $settings['secondline_addons_social_icon_list'] as $item ) : ?>
						<?php if ( ! empty( $item['social'] ) ) : ?>
							<?php $target = $item['link']['is_external'] ? ' target="_blank"' : ''; ?>
							<a class="secondline-addons-team-social" href="<?php echo esc_attr( $item['link']['url'] ); ?>"<?php echo $target; ?> <?php if ( ! empty( $item['link']['nofollow'] ) ) : ?>rel="nofollow"<?php endif; ?>><?php \Elementor\Icons_Manager::render_icon( $item['social'], [ 'aria-hidden' => 'true' ] ); ?></a>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
				</div>
			</div>
		</div><!-- close .secondline-addons-icons-container -->
		<?php endif; ?>
		
		<?php if ( $settings['secondline_addons_social_icon_overlay'] == "secondline_addons_content_overlay_image"  ) : ?>
		<div class="secondline-addons-content-container-overlay">
			<div class="secondline-addons-overlay-table">
				<div class="secondline-addons-overlay-table-cell">
					
					<div class="secondline-addons-team-content">
						<?php if ( ! empty( $settings['secondline_addons_team_title_text'] ) ) : ?>
							<?php if ( ! empty( $settings['secondline_addons_team_link']['url'] ) ) : ?><a href="<?php echo esc_url($settings['secondline_addons_team_link']['url']); ?>" <?php if ( ! empty( $settings['secondline_addons_team_link']['is_external'] ) ) : ?>target="_blank"<?php endif; ?>><?php endif; ?><h4 class="secondline-addons-team-heading"><?php echo '<div ' . $this->get_render_attribute_string( 'secondline_addons_team_title_text' ) . '>' . $this->get_settings( 'secondline_addons_team_title_text' ) . '</div>';?></h4><?php if ( ! empty( $settings['secondline_addons_team_link']['url'] ) ) : ?></a><?php endif; ?>
						<?php endif; ?>
						<?php if ( ! empty( $settings['secondline_addons_team_job_title_text'] ) ) : ?>
							<h5 class="secondline-addons-team-job-title"><?php echo '<div ' . $this->get_render_attribute_string( 'secondline_addons_team_job_title_text' ) . '>' . $this->get_settings( 'secondline_addons_team_job_title_text' ) . '</div>';?></h5>
						<?php endif; ?>
						<?php if ( ! empty( $settings['secondline_addons_team_sub_title_description'] ) ) : ?>
							<div class="secondline-addons-team-description">
								<?php echo '<div ' . $this->get_render_attribute_string( 'secondline_addons_team_sub_title_description' ) . '>' . $this->get_settings( 'secondline_addons_team_sub_title_description' ) . '</div>';?></div>
						<?php endif; ?>
		
		
						<?php if ( ! empty( $settings['secondline_addons_team_button'] ) ) : ?>
							<div class="secondline-addons-button-align"><?php if ( ! empty( $settings['secondline_addons_team_link']['url'] ) ) : ?><a href="<?php echo esc_url($settings['secondline_addons_team_link']['url']); ?>" <?php if ( ! empty( $settings['secondline_addons_team_link']['is_external'] ) ) : ?>target="_blank"<?php endif; ?>><?php endif; ?><div class="secondline-addons-button">
								<?php if ( ! empty( $settings['secondline_addons_team_button_icon'] ) && $settings['secondline_addons_team_button_icon_align'] == 'left' ) : ?>
									<?php \Elementor\Icons_Manager::render_icon( $settings['secondline_addons_team_button_icon'], [ 'aria-hidden' => 'true', 'class' => 'open-team-member-button-icon-left' ] ); ?>
								<?php endif; ?>
								<?php echo esc_attr($settings['secondline_addons_team_button'] ); ?>
								<?php if ( ! empty( $settings['secondline_addons_team_button_icon'] ) && $settings['secondline_addons_team_button_icon_align'] == 'right' ) : ?>
									<?php \Elementor\Icons_Manager::render_icon( $settings['secondline_addons_team_button_icon'], [ 'aria-hidden' => 'true', 'class' => 'open-team-member-button-icon-right' ] ); ?>
								<?php endif; ?>
							</div><?php if ( ! empty( $settings['secondline_addons_team_link']['url'] ) ) : ?></a><?php endif; ?></div>
						<?php endif; ?>
		
		
		
						<?php if ( ! empty( $settings['secondline_addons_social_show_hide'] ) ): ?>
						<div class="secondline-addons-icons-container">
							<?php foreach ( $settings['secondline_addons_social_icon_list'] as $item ) : ?>
								<?php if ( ! empty( $item['social'] ) ) : ?>
									<?php $target = $item['link']['is_external'] ? ' target="_blank"' : ''; ?>									
									<a class="secondline-addons-team-social" href="<?php echo esc_attr( $item['link']['url'] ); ?>"<?php echo $target; ?> <?php if ( ! empty( $item['link']['nofollow'] ) ) : ?>rel="nofollow"<?php endif; ?>><?php \Elementor\Icons_Manager::render_icon( $item['social'], [ 'aria-hidden' => 'true'] ); ?></a>
								<?php endif; ?>
							<?php endforeach; ?>
						</div><!-- close .secondline-addons-icons-container -->
						<?php endif; ?>
		
						<div class="clearfix-secondline-addon"></div>
		
					</div>
					
				</div>
			</div>
		</div><!-- close .secondline-addons-icons-container -->
		<?php endif; ?>
		
		</div>
	 <?php endif; ?>		
	 
	 
	 <?php if ( $settings['secondline_addons_social_icon_overlay'] != "secondline_addons_content_overlay_image"  ) : ?>
	<div class="secondline-addons-team-content">
		<?php if ( ! empty( $settings['secondline_addons_team_title_text'] ) ) : ?>
			<?php if ( ! empty( $settings['secondline_addons_team_link']['url'] ) ) : ?><a href="<?php echo esc_url($settings['secondline_addons_team_link']['url']); ?>" <?php if ( ! empty( $settings['secondline_addons_team_link']['is_external'] ) ) : ?>target="_blank"<?php endif; ?>><?php endif; ?><h4 class="secondline-addons-team-heading"><?php echo '<div ' . $this->get_render_attribute_string( 'secondline_addons_team_title_text' ) . '>' . $this->get_settings( 'secondline_addons_team_title_text' ) . '</div>';?></h4><?php if ( ! empty( $settings['secondline_addons_team_link']['url'] ) ) : ?></a><?php endif; ?>
		<?php endif; ?>
		<?php if ( ! empty( $settings['secondline_addons_team_job_title_text'] ) ) : ?>
			<h5 class="secondline-addons-team-job-title"><?php echo '<div ' . $this->get_render_attribute_string( 'secondline_addons_team_job_title_text' ) . '>' . $this->get_settings( 'secondline_addons_team_job_title_text' ) . '</div>';?></h5>
		<?php endif; ?>
		<?php if ( ! empty( $settings['secondline_addons_team_sub_title_description'] ) ) : ?>
			<div class="secondline-addons-team-description"><?php echo '<div ' . $this->get_render_attribute_string( 'secondline_addons_team_sub_title_description' ) . '>' . $this->get_settings( 'secondline_addons_team_sub_title_description' ) . '</div>';?></div>
		<?php endif; ?>
		
		
		<?php if ( ! empty( $settings['secondline_addons_team_button'] ) ) : ?>
			<div class="secondline-addons-button-align"><?php if ( ! empty( $settings['secondline_addons_team_link']['url'] ) ) : ?><a href="<?php echo esc_url($settings['secondline_addons_team_link']['url']); ?>" <?php if ( ! empty( $settings['secondline_addons_team_link']['is_external'] ) ) : ?>target="_blank"<?php endif; ?>><?php endif; ?><div class="secondline-addons-button">
				<?php if ( ! empty( $settings['secondline_addons_team_button_icon'] ) && $settings['secondline_addons_team_button_icon_align'] == 'left' ) : ?>
					<?php \Elementor\Icons_Manager::render_icon( $settings['secondline_addons_team_button_icon'], [ 'aria-hidden' => 'true', 'class' => 'open-team-member-button-icon-left' ] ); ?>
				<?php endif; ?>
				<?php echo esc_attr($settings['secondline_addons_team_button'] ); ?>
				<?php if ( ! empty( $settings['secondline_addons_team_button_icon'] ) && $settings['secondline_addons_team_button_icon_align'] == 'right' ) : ?>
					<?php \Elementor\Icons_Manager::render_icon( $settings['secondline_addons_team_button_icon'], [ 'aria-hidden' => 'true', 'class' => 'open-team-member-button-icon-right' ] ); ?>
				<?php endif; ?>
			
			</div><?php if ( ! empty( $settings['secondline_addons_team_link']['url'] ) ) : ?></a><?php endif; ?></div>
		<?php endif; ?>
		
		
		
		<?php if ( ! empty( $settings['secondline_addons_social_show_hide'] ) && $settings['secondline_addons_social_icon_overlay'] == "secondline_addons_icon_default"  ) : ?>
		<div class="secondline-addons-icons-container">
			<?php foreach ( $settings['secondline_addons_social_icon_list'] as $item ) : ?>
				<?php if ( ! empty( $item['social'] ) ) : ?>
					<?php $target = $item['link']['is_external'] ? ' target="_blank"' : ''; ?>
					<a class="secondline-addons-team-social" href="<?php echo esc_attr( $item['link']['url'] ); ?>"<?php echo $target; ?> <?php if ( ! empty( $item['link']['nofollow'] ) ) : ?>rel="nofollow"<?php endif; ?>><?php \Elementor\Icons_Manager::render_icon( $item['social'], [ 'aria-hidden' => 'true'] ); ?></a>
				<?php endif; ?>
			<?php endforeach; ?>
		</div><!-- close .secondline-addons-icons-container -->
		<?php endif; ?>
		
		<div class="clearfix-secondline-addon"></div>
		
	</div>
	<?php endif; ?>
	
	<div class="clearfix-secondline-addon"></div>
	
	</div><!-- close .secondline-addons-team-member-container -->
	
	
	<?php
	
	}

	protected function content_template(){}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_SecondLineAddonsTeam_Member() );