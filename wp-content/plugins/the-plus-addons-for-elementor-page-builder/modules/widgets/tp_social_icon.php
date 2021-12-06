<?php 
/*
Widget Name: Social Icon
Description: share social icon list design.
Author: Theplus
Author URI: https://posimyth.com
*/
namespace TheplusAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Schemes\Typography;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class L_ThePlus_Social_Icon extends Widget_Base {
		
	public function get_name() {
		return 'tp-social-icon';
	}

    public function get_title() {
        return esc_html__('Social Icon', 'tpebl');
    }

    public function get_icon() {
        return 'fa fa-share-square-o theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-essential');
    }

    protected function _register_controls() {
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'styles',[
				'label' => esc_html__( 'Style','tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-2',
				'separator' => 'after',
				'options' => [
					'style-1' => esc_html__( 'Style 1 (Pro)','tpebl' ),
					'style-2' => esc_html__( 'Style 2','tpebl' ),
					'style-3' => esc_html__( 'Style 3 (Pro)','tpebl' ),
					'style-4' => esc_html__( 'Style 4 (Pro)','tpebl' ),
					'style-5' => esc_html__( 'Style 5 (Pro)','tpebl' ),
					'style-6' => esc_html__( 'Style 6 (Pro)','tpebl' ),
					'style-7' => esc_html__( 'Style 7 (Pro)','tpebl' ),
					'style-8' => esc_html__( 'Style 8 (Pro)','tpebl' ),
					'style-9' => esc_html__( 'Style 9 (Pro)','tpebl' ),
					'style-10' => esc_html__( 'Style 10 (Pro)','tpebl' ),
					'style-11' => esc_html__( 'Style 11 (Pro)','tpebl' ),
					'style-12' => esc_html__( 'Style 12 (Pro)','tpebl' ),
					'style-13' => esc_html__( 'Style 13 (Pro)','tpebl' ),
					'style-14' => esc_html__( 'Style 14 (Pro)','tpebl' ),
					'style-15' => esc_html__( 'Style 15 (Pro)','tpebl' ),
					'custom' => esc_html__( 'Custom','tpebl' ),
				],
			]
		);		
		$repeater = new \Elementor\Repeater();
		
		$repeater->add_control(
			'pt_plus_social_icons',[
				'label' => esc_html__( 'Social Network Select','tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'image',
				'options' => [
					'none' => esc_html__( 'None','tpebl' ),
					'fa-deviantart' => esc_html__( 'Deviantart ','tpebl' ),
					'fa-digg' => esc_html__( 'Digg ','tpebl' ),
					'fa-dribbble' => esc_html__( 'Dribbble ','tpebl' ),
					'fa-dropbox' => esc_html__( 'Dropbox ','tpebl' ),
					'fa-facebook' => esc_html__( 'Facebook ','tpebl' ),
					'fa-flickr' => esc_html__( 'Flickr ','tpebl' ),
					'fa-foursquare' => esc_html__( 'Foursquare ','tpebl' ),
					'fa-google-plus' => esc_html__( 'Google + ','tpebl' ),
					'fa-instagram' => esc_html__( 'Instagram ','tpebl' ),
					'fa-lastfm' => esc_html__( 'LastFM ','tpebl' ),
					'fa-linkedin' => esc_html__( 'LinkedIN ','tpebl' ),
					'fa-pinterest-p' => esc_html__( 'Pinterest ','tpebl' ),
					'fa-rss' => esc_html__( 'RSS ','tpebl' ),
					'fa-tumblr' => esc_html__( 'Tumblr ','tpebl' ),
					'fa-twitter' => esc_html__( 'Twitter ','tpebl' ),
					'fa-vimeo' => esc_html__( 'Vimeo ','tpebl' ),
					'fa-wordpress' => esc_html__( 'Wordpress ','tpebl' ),
					'fa-youtube' => esc_html__( 'YouTube','tpebl' ),
					'fa-envelope' => esc_html__( 'Mail','tpebl' ),
					'fa-yelp' => esc_html__( 'Yelp','tpebl' ),
					'fa-xing' => esc_html__( 'Xing ','tpebl' ),
					'fa-spotify' => esc_html__( 'Spotify ','tpebl' ),
					'fa-houzz' => esc_html__( 'Houzz ','tpebl' ),
					'fa-skype' => esc_html__( 'Skype ','tpebl' ),
					'fa-slideshare' => esc_html__( 'Slideshare ','tpebl' ),
					'fa-bandcamp' => esc_html__( 'Bandcamp ','tpebl' ),
					'fa-soundcloud' => esc_html__( 'Soundcloud ','tpebl' ),
					'fa-snapchat-ghost' => esc_html__( 'Snapchat ','tpebl' ),
					'fa-behance' => esc_html__( 'Behance ','tpebl' ),
					'fa-windows' => esc_html__( 'Windows','tpebl' ),
					'fa-video-camera' => esc_html__( 'Video ','tpebl' ),
					'fa-tripadvisor' => esc_html__( 'TripAdvisor ','tpebl' ),
					'fa-vk' => esc_html__( 'VK ','tpebl' ),
					'fa-odnoklassniki-square' => esc_html__( 'Odnoklassniki','tpebl' ),
					'fa-odnoklassniki' => esc_html__( 'Odnoklassniki 1','tpebl' ),
					'fa-get-pocket' => esc_html__( 'Get Pocket','tpebl' ),
				],
			]
		);
		$repeater->add_control(
			'social_url',
			[
				'label' => esc_html__( 'Link', 'tpebl' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://www.demo-link.com', 'tpebl' ),
				'default' => [
					'url' => '#',
				],
			]
		);
		$repeater->add_control(
			'social_text',[
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'label' => esc_html__('Title', 'tpebl'),
				'default' => '',
				'dynamic' => ['active'   => true,],
			]
		);
		
		$repeater->add_control(
			'icon_color',[
				'label' => esc_html__('Icon Color', 'tpebl'),
				'type' => Controls_Manager::COLOR,
				'default' => '#d3d3d3',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}:not(.style-12) a' => 'color: {{VALUE}};',
				],
			]
		);
		$repeater->add_control(
			'icon_hover_color',[
				'label' => esc_html__('Icon Hover Color', 'tpebl'),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}:not(.style-12):not(.style-4):hover a' => 'color: {{VALUE}};',
				],
			]
		);
		$repeater->add_control(
			'bg_color',[
				'label' => esc_html__('Background Color', 'tpebl'),
				'type' => Controls_Manager::COLOR,
				'default' => '#404040',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}:not(.style-3):not(.style-9):not(.style-11):not(.style-12) a' => 'background: {{VALUE}};',
				],
			]
		);
		$repeater->add_control(
			'bg_hover_color',[
				'label' => esc_html__('Background Hover Color', 'tpebl'),
				'type' => Controls_Manager::COLOR,
				'default' => '#222222',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}:not(.style-3):not(.style-9):not(.style-11):not(.style-12):hover a' => 'background: {{VALUE}};',
				],
			]
		);
		$repeater->add_control(
			'border_color',[
				'label' => esc_html__('Border Color', 'tpebl'),
				'type' => Controls_Manager::COLOR,
				'default' => '#404040',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}:not(.style-11):not(.style-12):not(.style-13) a' => 'border-color: {{VALUE}};',
				],
			]
		);
		$repeater->add_control(
			'border_hover_color',[
				'label' => esc_html__('Border Hover Color', 'tpebl'),
				'type' => Controls_Manager::COLOR,
				'default' => '#222222',
				'selectors' => [
					'{{WRAPPER}} {{CURRENT_ITEM}}:not(.style-11):not(.style-12):not(.style-13):hover a' => 'border-color: {{VALUE}};',
				],
			]
		);
		$repeater->add_control(
			'loop_magic_scroll',[
				'label'   => esc_html__( 'Magic Scroll', 'tpebl' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'separator' => 'before',
			]
		);
		$repeater->add_control(
			'loop_magic_scroll_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'loop_magic_scroll' => [ 'yes' ],
				],
			]
		);
		$repeater->add_control(
			'plus_tooltip',
			[
				'label'        => esc_html__( 'Tooltip', 'tpebl' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'tpebl' ),
				'label_off'    => esc_html__( 'No', 'tpebl' ),
				'render_type'  => 'template',
				'separator' => 'before',
			]
		);
		$repeater->add_control(
			'plus_tooltip_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'plus_tooltip' => [ 'yes' ],
				],
			]
		);
		$repeater->add_control(
			'plus_mouse_move_parallax',
			[
				'label'        => esc_html__( 'Mouse Move Parallax', 'tpebl' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'tpebl' ),
				'label_off'    => esc_html__( 'No', 'tpebl' ),
				'separator' => 'before',
			]
		);
		$repeater->add_control(
			'plus_mouse_move_parallax_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'plus_mouse_move_parallax' => [ 'yes' ],
				],
			]
		);
		$repeater->add_control(
			'plus_continuous_animation',
			[
				'label'        => esc_html__( 'Continuous Animation', 'tpebl' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'tpebl' ),
				'label_off'    => esc_html__( 'No', 'tpebl' ),
				'separator' => 'before',
			]
		);
		$repeater->add_control(
			'plus_animation_effect',
			[
				'label' => esc_html__( 'Animation Effect', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'pulse',
				'options' => [
					'pulse'  => esc_html__( 'Pulse', 'tpebl' ),
					'floating'  => esc_html__( 'Floating', 'tpebl' ),
					'tossing'  => esc_html__( 'Tossing', 'tpebl' ),
					'rotating'  => esc_html__( 'Rotating', 'tpebl' ),
				],
				'condition' => [
					'plus_continuous_animation' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'plus_animation_hover',
			[
				'label'        => esc_html__( 'Hover Animation', 'tpebl' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'tpebl' ),
				'label_off'    => esc_html__( 'No', 'tpebl' ),
				'condition' => [
					'plus_continuous_animation' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'plus_animation_duration',
			[	
				'label' => esc_html__( 'Duration Time', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => 's',
				'range' => [
					's' => [
						'min' => 0.5,
						'max' => 50,
						'step' => 0.1,
					],
				],
				'default' => [
					'unit' => 's',
					'size' => 1.2,
				],
				'selectors'  => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => 'animation-duration: {{SIZE}}{{UNIT}};-webkit-animation-duration: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'plus_continuous_animation' => 'yes',
				],
			]
		);
		$repeater->add_control(
			'plus_transform_origin',
			[
				'label' => esc_html__( 'Transform Origin', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'center center',
				'options' => [
					'top left'  => esc_html__( 'Top Left', 'tpebl' ),
					'top center"'  => esc_html__( 'Top Center', 'tpebl' ),
					'top right'  => esc_html__( 'Top Right', 'tpebl' ),
					'center left'  => esc_html__( 'Center Left', 'tpebl' ),
					'center center'  => esc_html__( 'Center Center', 'tpebl' ),
					'center right'  => esc_html__( 'Center Right', 'tpebl' ),
					'bottom left'  => esc_html__( 'Bottom Left', 'tpebl' ),
					'bottom center'  => esc_html__( 'Bottom Center', 'tpebl' ),
					'bottom right'  => esc_html__( 'Bottom Right', 'tpebl' ),
				],
				'selectors'  => [
					'{{WRAPPER}} {{CURRENT_ITEM}}' => '-webkit-transform-origin: {{VALUE}};-moz-transform-origin: {{VALUE}};-ms-transform-origin: {{VALUE}};-o-transform-origin: {{VALUE}};transform-origin: {{VALUE}};',
				],
				'render_type'  => 'template',
				'condition' => [
					'plus_continuous_animation' => 'yes',
					'plus_animation_effect' => 'rotating',
				],
			]
		);
		$this->add_control(
            'pt_plus_social_networks',
            [
				'label' => esc_html__( 'Social Network Select', 'tpebl' ),
                'type' => Controls_Manager::REPEATER,
                'default' => [
                    [
                        'pt_plus_social_icons' => '',                       
                    ],
                ],                
				'fields' => $repeater->get_controls(),
                'title_field' => '{{{ pt_plus_social_icons }}}',
				'condition'    => [
					'styles' => [ 'style-2','custom' ],
				],
            ]
        );
		$this->add_control(
			'pt_plus_social_networks_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'styles!' => [ 'style-2','custom' ],
				],
			]
		);

		$this->add_responsive_control(
			'social_align',
			[
				'label' => esc_html__( 'Alignment', 'tpebl' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'text-left' => [
						'title' => esc_html__( 'Left', 'tpebl' ),
						'icon' => 'eicon-text-align-left',
					],
					'text-center' => [
						'title' => esc_html__( 'Center', 'tpebl' ),
						'icon' => 'eicon-text-align-center',
					],
					'text-right' => [
						'title' => esc_html__( 'Right', 'tpebl' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'condition'    => [
					'styles' => [ 'style-2','custom' ],
				],
				'default' => 'text-center',
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
            'section_social_styling',
            [
                'label' => esc_html__('Style', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_responsive_control(
			'social_icon_gap_margin',
			[
				'label' => esc_html__( 'Icons Between Gap', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors' => [
					'{{WRAPPER}} .pt_plus_social_list ul.social_list li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',					
				],
			]
		);
		$this->add_responsive_control(
			'icon_size',
			[
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Font Size', 'tpebl'),
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min'	=> 8,
						'max'	=> 150,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .pt_plus_social_list ul.social_list .style-2 a i.fa,
					{{WRAPPER}} .pt_plus_social_list ul.social_list .custom a' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				
            ]
		);
		$this->add_responsive_control(
			'social_icon_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_social_list ul.social_list .style-2 a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'styles' => ['style-2'],
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .pt_plus_social_list ul.social_list .style-2 a span',
				'condition' => [
					'styles' => ['style-2'],
				],
			]
		);
		$this->add_responsive_control(
            'social_icon_width',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Width', 'tpebl'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 400,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 60,
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .pt_plus_social_list.custom ul.social_list li a' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'styles' => 'custom',
				],
				'separator' => 'before',
            ]
        );
		$this->add_responsive_control(
            'social_icon_height',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Height', 'tpebl'),
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 400,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 40,
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .pt_plus_social_list.custom ul.social_list li a' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'styles' => 'custom',
				],
            ]
        );
		$this->add_control(
			'social_icon_border',
			[
				'label' => esc_html__( 'Box Border', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'no',
				'separator' => 'before',
				'condition' => [
					'styles' => 'custom',
				],
			]
		);
		$this->add_control(
			'social_border_style',
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
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_social_list.custom ul.social_list li a' => 'border-style: {{VALUE}};',
				],
				'condition' => [
					'styles' => 'custom',
					'social_icon_border' => 'yes',
				],
			]
		);
		$this->add_responsive_control(
			'social_border_width',
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
					'{{WRAPPER}} .pt_plus_social_list.custom ul.social_list li a' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'styles' => 'custom',
					'social_icon_border' => 'yes',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_border_style' );
		$this->start_controls_tab(
			'tab_border_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
				'condition' => [
					'styles' => 'custom',
				],
			]
		);
		$this->add_responsive_control(
			'social_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_social_list.custom ul.social_list li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'styles' => 'custom',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_border_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
				'condition' => [
					'styles' => 'custom',
				],
			]
		);
		$this->add_responsive_control(
			'social_border_hover_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .pt_plus_social_list.custom ul.social_list li:hover a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'styles' => 'custom',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_control(
			'social_icon_shadow_options',
			[
				'label' => esc_html__( 'Box Shadow Options', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'styles' => 'custom',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_shadow_style' );
		$this->start_controls_tab(
			'tab_shadow_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
				'condition' => [
					'styles' => 'custom',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'social_icon_box_shadow',
				'selector' => '{{WRAPPER}} .pt_plus_social_list.custom ul.social_list li a',
				'condition' => [
					'styles' => 'custom',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_shadow_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
				'condition' => [
					'styles' => 'custom',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'social_icon_box_hover_shadow',
				'selector' => '{{WRAPPER}} .pt_plus_social_list.custom ul.social_list li:hover a',
				'condition' => [
					'styles' => 'custom',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		
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
			$styles=$settings['styles'];
			$social_align=$settings["social_align"];
			$social_align .= (!empty($settings["social_align_tablet"])) ? ' tsocial' . $settings["social_align_tablet"] : '';
			$social_align .= (!empty($settings["social_align_mobile"])) ? ' msocial' . $settings["social_align_mobile"] : '';
			
			$social_animation =$social_chaffle =$hover_style=$social_text=$link=$link_atts_title=$link_atts_url=$link_atts_target='';
			
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
			
			  $social='<div class="pt_plus_social_list '.esc_attr($social_align).' '.esc_attr($styles).' '.esc_attr($animated_class).'" '.$animation_attr.'>';
				$social .='<ul class="social_list '.esc_attr($social_animation).'">';
			if(!empty($settings['pt_plus_social_networks'])){			
				foreach($settings['pt_plus_social_networks'] as $network) {
				
				$id=rand(1000,10000000);
					if(!empty($network['pt_plus_social_icons']) && !empty($network['social_url']['url'])) {
					
						if(!empty($network['pt_plus_social_icons'])) {
							$icon = $network['pt_plus_social_icons'];
						}
						if ( ! empty( $network['social_url']['url'] ) ) {
							$link_atts_url = 'href="'.esc_url($network["social_url"]["url"]).'"';
						}
						if ( ! empty( $network['social_url']['is_external'] ) ) {
						$link_atts_target = 'target="_blank"';
						}
						if ( ! empty($network['social_url']['nofollow']) ) {
							$link_atts_title = 'rel="nofollow"';
						}
						
						if(!empty($network['social_text']) && ( $styles=='style-2' || $styles=='custom')){
							$social_text='<span class="'.esc_attr($social_chaffle).'" data-lang="en">'.$network['social_text'].'</span>';
						}
						$icon_html = '<i class="fa '.esc_attr($icon).'"></i>';						
						
						$border_hover_color=$icon_color=$icon_hover_color=$bg_color=$bg_hover_color=$border_color='';
						if(!empty($network['icon_color'])){
							$icon_color= $network['icon_color'];
						}
						if(!empty($network['icon_hover_color'])){
							$icon_hover_color= $network['icon_hover_color'];
						}
						if(!empty($network['bg_color'])){
							$bg_color= $network['bg_color'];
						}
						if(!empty($network['bg_hover_color'])){
							$bg_hover_color= $network['bg_hover_color'];
						}
						if(!empty($network['border_color'])){
							$border_color= $network['border_color'];
						}
						if(!empty($network['border_hover_color'])){
							$border_hover_color= $network['border_hover_color'];
						}
						
						
						$continuous_animation='';
						if(!empty($network["plus_continuous_animation"]) && $network["plus_continuous_animation"]=='yes'){
							if($network["plus_animation_hover"]=='yes'){
								$animation_class='hover_';
							}else{
								$animation_class='image-';
							}
							$continuous_animation=$animation_class.$network["plus_animation_effect"];
						}
							$uid_social=uniqid("social").$network['_id'];
							$social .= '<li id="'.esc_attr($uid_social).'" class="elementor-repeater-item-' . $network['_id'] . ' '.esc_attr($styles).'  social-'.esc_attr($icon).' social-'.esc_attr($id).' '.esc_attr($continuous_animation).'" >';
								$social .= '<div class="social-loop-inner ">';
									$social .= '<a '.$link_atts_url.' '.$link_atts_title.' '.$link_atts_target.'>'.$icon_html.$social_text.$hover_style.'</a>';
								$social .= '</div>';
							$social .= '</li>';
					}
				}
			}
			$social .='</ul>';
		$social .='</div>';
		
	echo $social;
	}
    protected function content_template() {
	
    }

}
