<?php 
/*
Widget Name: Team Member Listing
Description: Different style of Team Member taxonomy Post listing layouts.
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
use Elementor\Group_Control_Css_Filter;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class L_ThePlus_Team_Member_ListOut extends Widget_Base {
		
	public function get_name() {
		return 'tp-team-member-listout';
	}

    public function get_title() {
        return esc_html__('Team Member Listing', 'tpebl');
    }

    public function get_icon() {
        return 'fa fa-users theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-listing');
    }
	
    protected function _register_controls() {
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content Layout', 'tpebl' ),
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
					'style-1'  => esc_html__( 'Style 1', 'tpebl' ),
					'style-2' => esc_html__( 'Style 2 (PRO)', 'tpebl' ),
					'style-3' => esc_html__( 'Style 3 (PRO)', 'tpebl' ),
					'style-4' => esc_html__( 'Style 4 (PRO)', 'tpebl' ),
				],
			]
		);
		$this->add_control(
			'plus_pro_style_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'style!' => ['style-1'],
				],
			]
		);
		$this->add_control(
			'layout',
			[
				'label' => esc_html__( 'Layout', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'grid',
				'options' => [
					'grid' => esc_html__( 'Grid', 'tpebl' ),
					'masonry' => esc_html__( 'Masonry', 'tpebl' ),
					'carousel' => esc_html__( 'Carousel (PRO)', 'tpebl' ),
				],
			]
		);
		$this->add_control(
			'layout_pro_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'layout' => 'carousel',
				],
			]
		);
		$this->add_control(
			'content_alignment',
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
				'label_block' => false,
				'toggle' => true,
			]
		);
		$this->add_control(
			'disable_link',
			[
				'label' => esc_html__( 'Disable Link', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Disable', 'tpebl' ),
				'label_off' => esc_html__( 'Enable', 'tpebl' ),				
				'default' => '',
			]
		);
		$this->add_control(
			'disable_link_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'disable_link' => [ 'yes' ],
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'content_source_section',
			[
				'label' => esc_html__( 'Content Source', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'post_category',
			[
				'type' => Controls_Manager::SELECT2,
				'label'      => esc_html__( 'Select Category', 'tpebl' ),
				'default'    => '',
				'multiple'   => true,
				'label_block' => true,
				'options' => l_theplus_get_team_member_categories(),
				'separator' => 'before',
			]
		);
		$this->add_control(
			'display_posts',
			[
				'label' => esc_html__( 'Maximum Posts Display', 'tpebl' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 200,
				'step' => 1,
				'default' => 8,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'post_offset',
			[
				'label' => esc_html__( 'Offset Posts', 'tpebl' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 50,
				'step' => 1,
				'default' => '',
				'description' => esc_html__('Hide posts from the beginning of listing.','tpebl'),
			]
		);
		$this->add_control(
			'post_order_by',
			[
				'label' => esc_html__( 'Order By', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => l_theplus_orderby_arr(),
			]
		);
		$this->add_control(
			'post_order',
			[
				'label' => esc_html__( 'Order', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => l_theplus_order_arr(),
			]
		);
		
		$this->end_controls_section();
		/*columns*/
		$this->start_controls_section(
			'columns_section',
			[
				'label' => esc_html__( 'Columns Manage', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
					'layout!' => ['carousel']
				],
			]
		);
		$this->add_control(
			'desktop_column',
			[
				'label' => esc_html__( 'Desktop Column', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'options' => l_theplus_get_columns_list(),
				'condition' => [
					'layout!' => ['carousel']
				],
			]
		);
		$this->add_control(
			'tablet_column',
			[
				'label' => esc_html__( 'Tablet Column', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => '4',
				'options' => l_theplus_get_columns_list(),
				'condition' => [
					'layout!' => ['carousel']
				],
			]
		);
		$this->add_control(
			'mobile_column',
			[
				'label' => esc_html__( 'Mobile Column', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => '6',
				'options' => l_theplus_get_columns_list(),
				'condition' => [
					'layout!' => ['carousel']
				],
			]
		);
		$this->add_responsive_control(
			'columns_gap',
			[
				'label' => esc_html__( 'Columns Gap/Space Between', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default' =>[
					'top' => "15",
					'right' => "15",
					'bottom' => "15",
					'left' => "15",				
				],
				'separator' => 'before',
				'condition' => [
					'layout!' => ['carousel']
				],
				'selectors' => [
					'{{WRAPPER}} .team-member-list .post-inner-loop .grid-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_section();
		/*columns*/
		/*post Extra options*/
		$this->start_controls_section(
			'extra_option_section',
			[
				'label' => esc_html__( 'Extra Options', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'post_title_tag',
			[
				'label' => esc_html__( 'Title Tag', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => l_theplus_get_tags_options(),
				'separator' => 'after',
			]
		);
		$this->add_control(
			'display_designation',
			[
				'label' => esc_html__( 'Display Designation', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'display_social_icon',
			[
				'label' => esc_html__( 'Display Social Icon', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'yes',
				'separator' => 'before',
				'condition' => [
					'style' => ['style-1','style-3','style-4'],
				],
			]
		);
		$this->add_control(
			'display_thumbnail',
			[
				'label' => esc_html__( 'Display Image Size', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'no',
				'condition'   => [
					'layout!'    => 'carousel'
				],
			]
		);
		$this->add_control(
			'display_thumbnail_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'layout!'    => 'carousel',
					'display_thumbnail' => [ 'yes' ],
				],
			]
		);
		$this->add_control(
			'filter_category',
			[
				'label' => esc_html__( 'Category Wise Filter', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'no',
				'separator' => 'before',
				'condition' => [
					'layout!' => 'carousel'
				],
			]
		);
		$this->add_control(
			'filter_category_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'layout!' => 'carousel',
					'filter_category' => [ 'yes' ],
				],
			]
		);
		$this->end_controls_section();
		/*post Extra options*/
			
		/*Post Title*/
		$this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__('Title', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .team-member-list .post-title,{{WRAPPER}} .team-member-list .post-title a',
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
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .team-member-list .post-title,{{WRAPPER}} .team-member-list .post-title a' => 'color: {{VALUE}}',
				],
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
			'title_hover_color',
			[
				'label' => esc_html__( 'Title Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .team-member-list .team-list-content:hover .post-title,{{WRAPPER}} .team-member-list .team-list-content:hover .post-title a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Post Title*/
		/*Designation*/
		$this->start_controls_section(
            'section_designation_style',
            [
                'label' => esc_html__('Designation', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'display_designation'    => 'yes',
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'designation_typography',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .team-member-list .member-designation',
			]
		);
		$this->start_controls_tabs( 'tabs_designation_style' );
		$this->start_controls_tab(
			'tab_designation_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),				
			]
		);
		$this->add_control(
			'designation_color',
			[
				'label' => esc_html__( 'Text Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .team-member-list .member-designation' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_designation_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_control(
			'designation_color_hover',
			[
				'label' => esc_html__( 'Text Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .team-member-list .team-list-content:hover .member-designation' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Designation*/	
		/*Social Icon*/
		$this->start_controls_section(
            'section_social_icon_style',
            [
                'label' => esc_html__('Social Icon', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'style' => ['style-1'],
					'display_social_icon'  => 'yes',
				],
            ]
        );
		$this->start_controls_tabs( 'tabs_social_icon_style' );
		$this->start_controls_tab(
			'tab_social_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),				
			]
		);
		$this->add_control(
			'social_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .team-member-list.team-style-1 .team-social-content .team-social-list li a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_social_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_control(
			'social_icon_color_hover',
			[
				'label' => esc_html__( 'Icon Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .team-member-list.team-style-1 .team-social-content .team-social-list li a:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Social Icon*/	
		
		/*Post Featured Image*/
		$this->start_controls_section(
            'section_post_image_style',
            [
                'label' => esc_html__('Featured Image', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_responsive_control(
			'featured_image_padding',
			[
				'label'      => esc_html__( 'Padding', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .team-member-list .post-content-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'featured_image_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .team-member-list .team-profile img,{{WRAPPER}} .team-member-list .post-content-image,{{WRAPPER}} .team-member-list.team-style-2 .team-profile' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs( 'tabs_image_shadow_style' );
		
		$this->start_controls_tab(
			'tab_image_shadow_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .team-member-list .post-content-image img',
				
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'image_shadow',
				'selector' => '{{WRAPPER}} .team-member-list .post-content-image',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_image_shadow_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_hover_filters',
				'selector' => '{{WRAPPER}} .team-member-list .team-list-content:hover .post-content-image img',
				
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Post Featured Image*/		
		/*Filter Category style*/
		$this->start_controls_section(
            'section_filter_category_styling',
            [
                'label' => esc_html__('Filter Category', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'filter_category' => 'yes',
				],
			]
        );
		$this->add_control(
			'section_filter_category_styling_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
			]
		);
		$this->end_controls_section();
		/*Filter Category style*/
		/*Box Loop style*/
		$this->start_controls_section(
            'section_box_loop_styling',
            [
                'label' => esc_html__('Box Loop Background Style', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
			]
        );
		$this->add_responsive_control(
			'content_inner_padding',
			[
				'label' => esc_html__( 'Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .team-member-list .team-list-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
		$this->add_responsive_control(
			'border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .team-member-list .team-list-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
		$this->add_responsive_control(
			'border_hover_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .team-member-list .team-list-content:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
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
				'selector'  => '{{WRAPPER}} .team-member-list .team-list-content',
				
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
				'name'      => 'box_active_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .team-member-list .team-list-content:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();		
		$this->end_controls_section();
		/*Box Loop style*/
		/*carousel option*/
		$this->start_controls_section(
            'section_carousel_options_styling',
            [
                'label' => esc_html__('Carousel Options', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'layout' => 'carousel',
				],
            ]
        );
		$this->add_control(
			'section_carousel_options_styling_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
			]
		);
		$this->end_controls_section();
		/*carousel option*/
		
		/*Extra options*/
		$this->start_controls_section(
            'section_extra_options_styling',
            [
                'label' => esc_html__('Extra Options', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
			'messy_column',
			[
				'label' => esc_html__( 'Messy Columns', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'tpebl' ),
				'label_off' => esc_html__( 'Off', 'tpebl' ),				
				'default' => 'no',
			]
		);
		$this->add_control(
			'messy_column_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'messy_column' => [ 'yes' ],
				],
			]
		);		
		$this->end_controls_section();
		/*Extra options*/
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
			'animated_column_list',
			[
				'label'   => esc_html__( 'List Load Animation', 'tpebl' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					''  => esc_html__( 'Content Animation Block', 'tpebl' ),
					'stagger' => esc_html__( 'Stagger Based Animation', 'tpebl' ),
					'columns' => esc_html__( 'Columns Based Animation', 'tpebl' ),
				],
				'condition'    => [
					'animation_effects!' => [ 'no-animation' ],
				],
			]
		);
		$this->add_control(
            'animation_stagger',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Animation Stagger', 'tpebl'),
				'default' => [
					'unit' => '',
					'size' => 150,
				],
				'range' => [
					'' => [
						'min'	=> 0,
						'max'	=> 6000,
						'step' => 10,
					],
				],
				'condition' => [
					'animation_effects!' => [ 'no-animation' ],
					'animated_column_list' => 'stagger',
				],
            ]
        );
		$this->add_control(
            'animation_duration_default',
            [
				'label'   => esc_html__( 'Animation Duration', 'tpebl' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'condition'    => [
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
		$query_args = $this->get_query_args();
		$query = new \WP_Query( $query_args );
		$style=$settings["style"];
		$layout=$settings["layout"];
		$team_name=l_theplus_team_member_post_name();
		$team_taxonomy=l_theplus_team_member_post_category();
		
		$post_title_tag=$settings["post_title_tag"];
		$display_designation=$settings["display_designation"];
		$display_social_icon=$settings["display_social_icon"];
		
		$post_category=$settings['post_category'];
		
		$content_alignment=($settings["content_alignment"]!='') ? 'text-'.$settings["content_alignment"] : '';
		
		//animation load
		$animation_effects=$settings["animation_effects"];
		$animation_delay= (!empty($settings["animation_delay"]["size"])) ? $settings["animation_delay"]["size"] : 50;
		$animation_stagger=(!empty($settings["animation_stagger"]["size"])) ? $settings["animation_stagger"]["size"] :150;
		$animated_columns='';
		
		if($animation_effects=='no-animation'){
			$animated_class='';
			$animation_attr='';
		}else{
			$animate_offset = l_theplus_scroll_animation();
			$animated_class = 'animate-general';
			$animation_attr = ' data-animate-type="'.esc_attr($animation_effects).'" data-animate-delay="'.esc_attr($animation_delay).'"';
			$animation_attr .= ' data-animate-offset="'.esc_attr($animate_offset).'"';
			if($settings["animated_column_list"]=='stagger'){
				$animated_columns='animated-columns';
				$animation_attr .=' data-animate-columns="stagger"';
				$animation_attr .=' data-animate-stagger="'.esc_attr($animation_stagger).'"';
			}else if($settings["animated_column_list"]=='columns'){
				$animated_columns='animated-columns';
				$animation_attr .=' data-animate-columns="columns"';
			}
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
		
		//columns
		$desktop_class=$tablet_class=$mobile_class='';
		if( $layout!='metro'){
			$desktop_class='tp-col-lg-'.esc_attr($settings['desktop_column']);
			$tablet_class='tp-col-md-'.esc_attr($settings['tablet_column']);
			$mobile_class='tp-col-sm-'.esc_attr($settings['mobile_column']);
			$mobile_class .=' tp-col-'.esc_attr($settings['mobile_column']);
		}
		
		//layout
		$layout_attr=$data_class='';
		if($layout!=''){
			$data_class .=l_theplus_get_layout_list_class($layout);
			$layout_attr=l_theplus_get_layout_list_attr($layout);
		}else{
			$data_class .=' list-isotope';
		}
		
		$data_class .=' team-'.$style;
		
		
		$output=$data_attr='';		
		
		$uid=uniqid("post");
		
		$data_attr .=' data-id="'.esc_attr($uid).'"';
		$data_attr .=' data-style="'.esc_attr($style).'"';
		
		if ( ! $query->have_posts() ) {
			$output .='<h3 class="theplus-posts-not-found">'.esc_html__( "Posts not found", "tpebl" ).'</h3>';
		}else{
			if($style=="style-1" && $layout!='carousel'){	
				$output .= '<div id="theplus-team-member-list" class="team-member-list '.esc_attr($uid).' '.esc_attr($data_class).' '.$animated_class.'" '.$layout_attr.' '.$data_attr.' '.$animation_attr.' data-enable-isotope="1">';
								
				$output .= '<div id="'.esc_attr($uid).'" class="tp-row post-inner-loop '.esc_attr($uid).' '.esc_attr($content_alignment).'">';
				while ( $query->have_posts() ) {
				
					$query->the_post();
					$post = $query->post;
					
					
					$designation='';
					$designation_team = get_post_meta( get_the_ID(), 'theplus_tm_designation', true );
					if ( ! empty( $designation_team ) ) {
						$designation='<div class="member-designation">'.esc_html($designation_team).'</div>';
					}					
					
					$website = get_post_meta( get_the_ID(), 'theplus_tm_website_url', true );
					$facebook_link = get_post_meta( get_the_ID(), 'theplus_tm_face_link', true );
					$google_link = get_post_meta( get_the_ID(), 'theplus_tm_googgle_link', true );
					$insta_link = get_post_meta( get_the_ID(), 'theplus_tm_insta_link', true );
					$twit_link = get_post_meta( get_the_ID(), 'theplus_tm_twit_link', true );
					$linked_link = get_post_meta( get_the_ID(), 'theplus_tm_linked_link', true );
					$email_link = get_post_meta( get_the_ID(), 'theplus_tm_email_link', true );
					$phone_link = get_post_meta( get_the_ID(), 'theplus_tm_phone_link', true );
					$team_social_contnet='';
					if(!empty($website) || !empty($facebook_link) || !empty($google_link) || !empty($insta_link) || !empty($twit_link) || !empty($linked_link) || !empty($email_link) || !empty($phone_link)){
						$team_social_contnet .='<div class="team-social-content">';
							$team_social_contnet .='<ul class="team-social-list">';
								if(!empty($website)){
									$team_social_contnet .='<li class="team-profile-link"><a href="'.esc_url($website).'" target="_blank"><i class="fa fa-globe" aria-hidden="true"></i></a>';
								}
								if(!empty($facebook_link)){
									$team_social_contnet .='<li class="fb-link"><a href="'.esc_url($facebook_link).'" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>';
								}
								if(!empty($twit_link)){
									$team_social_contnet .='<li class="twitter-link"><a href="'.esc_url($twit_link).'" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a>';
								}
								if(!empty($insta_link)){
									$team_social_contnet .='<li class="instagram-link"><a href="'.esc_url($insta_link).'" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>';
								}
								if(!empty($google_link)){
									$team_social_contnet .='<li class="gplus-link"><a href="'.esc_url($google_link).'" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a>';
								}
								if(!empty($linked_link)){
									$team_social_contnet .='<li class="linkedin-link"><a href="'.esc_url($linked_link).'" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a>';
								}
								if(!empty($email_link)){
									$team_social_contnet .='<li class="team-profile-link"><a href="mailto:'.esc_attr($email_link).'" target="_blank"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>';
								}
								if(!empty($phone_link)){
									$team_social_contnet .='<li class="team-profile-link"><a href="tel:'.esc_attr($phone_link).'" target="_blank"><i class="fa fa-phone" aria-hidden="true"></i></a>';
								}
							$team_social_contnet .='</ul>';
						$team_social_contnet .='</div>';
					}
					
					//grid item loop
					$output .= '<div class="grid-item '.$desktop_class.' '.$tablet_class.' '.$mobile_class.' '.$animated_columns.'">';				
					if(!empty($style)){
						ob_start();
						include L_THEPLUS_PATH. 'includes/team-member/team-member-'.esc_attr($style).'.php'; 
						$output .= ob_get_contents();
						ob_end_clean();
					}
					$output .='</div>';
					
				}
				$output .='</div>';
				
				$output .='</div>';
			}else{
				$output .='<h3 class="theplus-posts-not-found">'.esc_html__( "This Style Premium Version", "tpebl" ).'</h3>';
			}
		}
			
			echo $output;
			wp_reset_postdata();
	}
	
    protected function content_template() {
	
    }
	
	protected function get_query_args() {
		$settings = $this->get_settings_for_display();
		$team_name=l_theplus_team_member_post_name();
		$team_taxonomy=l_theplus_team_member_post_category();
		$terms = get_terms( array('taxonomy' => $team_taxonomy, 'hide_empty' => true) );
		$category=array();
		$post_category=$settings['post_category'];
		
		if ( $terms != null && !empty($post_category)){
			foreach( $terms as $term ) {
				if(in_array($term->term_id,$post_category)){					
					$category[]=$term->slug;
				}				
			}
		}
		
		$query_args = array(
			'post_type'           => $team_name,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'posts_per_page'      => intval( $settings['display_posts'] ),
			'orderby'      =>  $settings['post_order_by'],
			'order'      => $settings['post_order'],
		);
		if ( $terms != null && !empty($post_category)){
			$query_args['tax_query'] = array(
				 array( 'taxonomy' => $team_taxonomy, 'field' => 'slug', 'terms' => $category )
			);
		}
		
		$offset = $settings['post_offset'];
		$offset = ! empty( $offset ) ? absint( $offset ) : 0;

		if ( $offset ) {
			$query_args['offset'] = $offset;
		}
		global $paged;
		if ( get_query_var('paged') ) {
			$paged = get_query_var('paged');
		}
		elseif ( get_query_var('page') ) {
			$paged = get_query_var('page');
		}
		else {
			$paged = 1;
		}
		$query_args['paged'] = $paged;
		
		return $query_args;
	}	
}
