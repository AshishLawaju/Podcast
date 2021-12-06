<?php 
/*
Widget Name: Gallery Listing
Description: Different style of gallery listing layouts.
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


class L_ThePlus_Gallery_ListOut extends Widget_Base {
		
	public function get_name() {
		return 'tp-gallery-listout';
	}

    public function get_title() {
        return esc_html__('Gallery Listing', 'tpebl');
    }

    public function get_icon() {
        return 'fa fa-grav theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-listing');
    }
	
    protected function _register_controls() {
		
		$this->start_controls_section(
			'layout_content_section',
			[
				'label' => esc_html__( 'Layout', 'tpebl' ),
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
			'style_pro_options',
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
					'grid'  => esc_html__( 'Grid', 'tpebl' ),
					'masonry' => esc_html__( 'Masonry', 'tpebl' ),
					'metro' => esc_html__( 'Metro', 'tpebl' ),
					'carousel' => esc_html__( 'Carousel (PRO)', 'tpebl' ),
				],
			]
		);
		$this->add_control(
			'popup_style',
			[
				'label' => esc_html__( 'Popup Layout', 'tpebl' ),
				'type' => Controls_Manager::SELECT,				
				'default' => 'default',
				'separator' => 'before',
				'options' => [
					'default'  => esc_html__( 'Default Light-box', 'tpebl' ),
				],
			]
		);
		$this->end_controls_section();
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
			'gallery_options',
			[
				'label' => esc_html__( 'Select Option', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => [
					"normal" => esc_html__("Normal", 'tpebl'),
					"repeater" => esc_html__("Repeater (PRO)", 'tpebl'),
					"acf_gallery" => esc_html__("ACF Gallery (PRO)", 'tpebl'),
				],
			]
		);
		$this->add_control(
			'gallery_images',
			[
				'label' => esc_html__( 'Add Images', 'tpebl' ),
				'type' => Controls_Manager::GALLERY,
				'default' => [],
				'condition' => [
					'gallery_options' => ['normal']
				],
			]
		);
		$this->add_control(
			'loop_gallery_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'gallery_options' => ['repeater','acf_gallery'],
				],
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
					'layout!' => ['metro','carousel']
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
					'layout!' => ['metro','carousel']
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
					'layout!' => ['metro','carousel']
				],
			]
		);
		$this->add_control(
			'metro_column',
			[
				'label' => esc_html__( 'Metro Column', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'options' => [
					"3" => esc_html__("Column 3", 'tpebl'),
					"4" => esc_html__("Column 4 (PRO)", 'tpebl'),
					"5" => esc_html__("Column 5 (PRO)", 'tpebl'),
					"6" => esc_html__("Column 6 (PRO)", 'tpebl'),
				],
				'condition' => [
					'layout' => ['metro']
				],
			]
		);
		$this->add_control(
			'metro_style_3',
			[
				'label' => esc_html__( 'Metro Style', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => l_theplus_get_style_list(1),
				'condition' => [
					'metro_column' => '3',
					'layout' => ['metro']
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
					'{{WRAPPER}} .gallery-list .post-inner-loop .grid-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'display_title',
			[
				'label' => esc_html__( 'Display Title', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'post_title_tag',
			[
				'label' => esc_html__( 'Title Tag', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => l_theplus_get_tags_options(),
				'condition' => [
					'display_title' => 'yes'
				],
			]
		);
		$this->add_control(
			'display_excerpt',
			[
				'label' => esc_html__( 'Display Excerpt/Content', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'display_box_link',
			[
				'label' => __( 'Box Link', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Enable', 'tpebl' ),
				'label_off' => __( 'Disable', 'tpebl' ),
				'default' => 'no',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'display_box_link_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'display_box_link' => [ 'yes' ],
				],
			]
		);		
		$this->add_control(
			'filter_category',
			[
				'label' => esc_html__( 'Category Wise Filter', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'no',
				'separator' => 'before',
				'condition' => [
					'gallery_options' => 'repeater',
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
					'gallery_options' => 'repeater',
					'filter_category' => [ 'yes' ],
				],
			]
		);
		$this->end_controls_section();
		/*post Extra options*/
		
		/*Icon Zoom*/
		$this->start_controls_section(
            'section_icon_zoom_style',
            [
                'label' => esc_html__('Popup Icon', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
			'display_icon_zoom',
			[
				'label' => esc_html__( 'Display Icon', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'custom_icon_image',
			[
				'label' => esc_html__( 'Custom Icon', 'tpebl' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
				],
				'condition' => [
					'display_icon_zoom'    => 'yes',
				],
			]
		);

		$this->add_responsive_control(
            'icon_size',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Size', 'tpebl'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 22,
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .gallery-list .meta-search-icon a' => 'font-size: {{SIZE}}{{UNIT}};max-width:calc({{SIZE}}{{UNIT}} + 10px );',
				],
				'condition' => [
					'display_icon_zoom'    => 'yes',
				],
            ]
        );
		
		$this->start_controls_tabs( 'tabs_icon_style' );
		$this->start_controls_tab(
			'tab_icon_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
				'condition' => [
					'display_icon_zoom'    => 'yes',
				],
			]
		);
		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .gallery-list .meta-search-icon a' => 'color: {{VALUE}}',
				],
				'condition' => [
					'display_icon_zoom'    => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_icon_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
				'condition' => [
					'display_icon_zoom'    => 'yes',
				],
			]
		);
		$this->add_control(
			'icon_hover_color',
			[
				'label' => esc_html__( 'Icon Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .gallery-list .post-inner-loop .gallery-list-content:hover .meta-search-icon a' => 'color: {{VALUE}}',
				],
				'condition' => [
					'display_icon_zoom'    => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_responsive_control(
            'icon_bottom_space',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Bottom Space', 'tpebl'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 80,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 12,
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .gallery-list .meta-search-icon' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'before',
				'condition' => [
					'display_icon_zoom'    => 'yes',
				],
            ]
        );
		$this->end_controls_section();
		/*Icon Zoom*/
		/*Repeater Icon*/
		$this->start_controls_section(
            'section_repeat_icon_style',
            [
                'label' => esc_html__('Extra Icon', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'gallery_options' => 'repeater',
				],
            ]
        );
		$this->add_control(
			'section_repeat_icon_style_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
			]
		);
		$this->end_controls_section();
		/*Repeater Icon*/
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
				'selector' => '{{WRAPPER}} .gallery-list .post-inner-loop .post-title,{{WRAPPER}} .gallery-list .post-inner-loop .post-title a',
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
					'{{WRAPPER}} .gallery-list .post-inner-loop .post-title,{{WRAPPER}} .gallery-list .post-inner-loop .post-title a' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .gallery-list .post-inner-loop .gallery-list-content:hover .post-title,{{WRAPPER}} .gallery-list .post-inner-loop .gallery-list-content:hover .post-title a' => 'color: {{VALUE}}',
				],
			]
		);		
		$this->end_controls_tab();
		$this->end_controls_tabs();		
		$this->end_controls_section();
		/*Post Title*/		
		/*Post Excerpt*/
		$this->start_controls_section(
            'section_excerpt_style',
            [
                'label' => esc_html__('Excerpt/Content', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'display_excerpt'    => 'yes',
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'excerpt_typography',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .gallery-list .post-inner-loop .entry-content',
			]
		);
		$this->start_controls_tabs( 'tabs_excerpt_style' );
		$this->start_controls_tab(
			'tab_excerpt_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),				
			]
		);
		$this->add_control(
			'excerpt_color',
			[
				'label' => esc_html__( 'Content Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .gallery-list .post-inner-loop .entry-content,{{WRAPPER}} .gallery-list .post-inner-loop .entry-content p' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_excerpt_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_control(
			'excerpt_hover_color',
			[
				'label' => esc_html__( 'Content Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .gallery-list .post-inner-loop .gallery-list-content:hover .entry-content,{{WRAPPER}} .gallery-list .post-inner-loop .gallery-list-content:hover .entry-content p' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->add_responsive_control(
            'content_top_space',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Top Space', 'tpebl'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'render_type' => 'ui',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .gallery-list .post-inner-loop .entry-content' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->end_controls_section();
		/*Post Excerpt*/
		/*Content Background*/
		$this->start_controls_section(
            'section_content_bg_style',
            [
                'label' => esc_html__('Content Background', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
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
				'name'      => 'contnet_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .gallery-list.gallery-style-1 .gallery-list-content .post-content-center',
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
				'name' => 'content_hover_background',
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .gallery-list.gallery-style-1 .gallery-list-content:hover .post-content-center',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Content Background*/
		/*Post Featured Image*/
		$this->start_controls_section(
            'section_post_image_style',
            [
                'label' => esc_html__('Featured Image', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
		$this->add_control(
			'hover_image_style',
			[
				'label' => esc_html__( 'Image Hover Effect', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => l_theplus_get_style_list(1),
			]
		);
		$this->start_controls_tabs( 'tabs_image_style' );
		$this->start_controls_tab(
			'tab_image_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),				
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'overlay_image_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .gallery-list .gallery-list-content .gallery-image:before,{{WRAPPER}} .gallery-list.list-isotope-metro .gallery-list-content .gallery-bg-image-metro:before',
			]
		);
		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'css_filters',
				'selector' => '{{WRAPPER}} .gallery-list .gallery-list-content .gallery-image img,{{WRAPPER}} .gallery-list .gallery-list-content  .gallery-bg-image-metro',
				'separator' => 'before',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_image_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overlay_image_hover_background',
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} .gallery-list.gallery-style-1 .grid-item .post-content-center,{{WRAPPER}} .gallery-list .gallery-list-content:hover .gallery-image:before,{{WRAPPER}} .gallery-list.list-isotope-metro .gallery-list-content:hover .gallery-bg-image-metro:before',
			]
		);
		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'hover_css_filters',
				'selector' => '{{WRAPPER}} .gallery-list .gallery-list-content:hover .gallery-image img,{{WRAPPER}} .gallery-list .gallery-list-content:hover  .gallery-bg-image-metro',
				'separator' => 'before',
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
					'gallery_options' => 'repeater',
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
					'{{WRAPPER}} .gallery-list .post-inner-loop .grid-item .gallery-list-content' => 'border-style: {{VALUE}};',
				],
				'condition' => [
					'box_border' => 'yes',
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
					'{{WRAPPER}} .gallery-list .post-inner-loop .grid-item .gallery-list-content' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'box_border_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .gallery-list .post-inner-loop .grid-item .gallery-list-content' => 'border-color: {{VALUE}};',
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
					'{{WRAPPER}} .gallery-list .post-inner-loop .grid-item .gallery-list-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_border_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
				'condition' => [
					'box_border' => 'yes',
				],
			]
		);
		$this->add_control(
			'box_border_hover_color',
			[
				'label' => esc_html__( 'Border Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#252525',
				'selectors'  => [
					'{{WRAPPER}} .gallery-list .post-inner-loop .grid-item .gallery-list-content:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'box_border' => 'yes',
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
					'{{WRAPPER}} .gallery-list .post-inner-loop .grid-item .gallery-list-content:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'box_border' => 'yes',
				],
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
				'selector' => '{{WRAPPER}} .gallery-list .post-inner-loop .grid-item .gallery-list-content',
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
				'name'     => 'box_active_shadow',
				'selector' => '{{WRAPPER}} .gallery-list .post-inner-loop .grid-item .gallery-list-content:hover',
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
			'plus_tilt_parallax',
			[
				'label'        => esc_html__( 'Tilt 3D Parallax', 'tpebl' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'tpebl' ),
				'label_off'    => esc_html__( 'No', 'tpebl' ),					
				'render_type'  => 'template',
				'separator' => 'before',
			]
		);
		$this->add_control(
			'plus_tilt_parallax_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'plus_tilt_parallax' => [ 'yes' ],
				],
			]
		);
		$this->add_control(
			'plus_mouse_move_parallax',
			[
				'label'        => esc_html__( 'Mouse Move Parallax', 'tpebl' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'tpebl' ),
				'label_off'    => esc_html__( 'No', 'tpebl' ),					
				'render_type'  => 'template',
				'separator' => 'before',
			]
		);
		$this->add_control(
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
		$this->add_control(
			'messy_column',
			[
				'label' => esc_html__( 'Messy Columns', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'tpebl' ),
				'label_off' => esc_html__( 'Off', 'tpebl' ),				
				'default' => 'no',
				'separator' => 'before',
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
		$style=$settings["style"];
		$layout=$settings["layout"];
		$display_title=$settings["display_title"];
		$post_title_tag=$settings["post_title_tag"];
		$popup_style=$settings["popup_style"];
		$popup_attr=$popup_attr_icon='';
		if($popup_style=='default'){
			$popup_attr = 'data-elementor-open-lightbox="default" data-elementor-lightbox-slideshow="'.$this->get_id().'"';
			$popup_attr_icon = 'data-elementor-open-lightbox="default" data-elementor-lightbox-slideshow="icn-'.$this->get_id().'"';
			$popup_attr_icon1 = 'data-elementor-open-lightbox="default" data-elementor-lightbox-slideshow="icn1-'.$this->get_id().'"';
		}
		
		$display_icon_zoom=$settings["display_icon_zoom"];		
		
		$display_excerpt=$settings["display_excerpt"];
		
		//animation load
		$animation_effects=$settings["animation_effects"];
		$animation_delay= (!empty($settings["animation_delay"]["size"])) ? $settings["animation_delay"]["size"] : 50;
		$animation_stagger=(!empty($settings["animation_stagger"]["size"])) ? $settings["animation_stagger"]["size"] : 150;
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
		if($layout!='carousel' && $layout!='metro'){
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
		if($layout=='metro'){
			$metro_columns=$settings['metro_column'];
			$layout_attr .=' data-metro-columns="'.esc_attr($metro_columns).'" ';
			$layout_attr .=' data-metro-style="'.esc_attr($settings["metro_style_".$metro_columns]).'" ';			
		}
		
		$data_class .=' gallery-'.$style;
		$data_class .=' hover-image-'.$settings["hover_image_style"];
		
		
		$output=$data_attr='';
		
		
		$ji=1;$ij=0;
		$uid=uniqid("post");		
		$data_attr .=' data-id="'.esc_attr($uid).'"';
		$data_attr .=' data-style="'.esc_attr($style).'"';
		$tablet_metro_class=$tablet_ij='';
		if ( ($settings['gallery_options']=='normal' && empty($settings['gallery_images']))) {
			$output .='<h3 class="theplus-posts-not-found">'.esc_html__( "Please select a multiple images gallery", "tpebl" ).'</h3>';
		}else{
			if($style=='style-1'){
				$output .= '<div id="pt-plus-gallery-list" class="gallery-list '.esc_attr($uid).' '.esc_attr($data_class).' '.$animated_class.' " '.$layout_attr.' '.$data_attr.' '.$animation_attr.' data-enable-isotope="1">';
				
				$output .= '<div id="'.esc_attr($uid).'" class="tp-row post-inner-loop '.esc_attr($uid).'">';
				
				//Normal Multiple Images
				if ( !empty($settings['gallery_images']) && $settings['gallery_options']=='normal') {
					foreach ( $settings['gallery_images'] as $image ) {
						$image_id=$image['id'];
						$attachment = get_post($image_id);
						$title=$description=$caption=$image_alt=$target=$nofollow='';
						if($attachment){
							$image_alt=get_post_meta($image_id, '_wp_attachment_image_alt', true);
							$caption=$attachment->post_excerpt;
							$description=$attachment->post_content;
							$title=$attachment->post_title;
						}
						
						if($layout=='metro'){
							$metro_columns=$settings['metro_column'];
							if(!empty($settings["metro_style_".$metro_columns])){
								$ij=l_theplus_metro_style_layout($ji,$settings['metro_column'],$settings["metro_style_".$metro_columns]);
							}
						}						
						//grid item loop
						$output .= '<div class="grid-item metro-item'.esc_attr($ij).' '.$desktop_class.' '.$tablet_class.' '.$mobile_class.' '.$animated_columns.'" >';						
						if(!empty($style)){
							ob_start();
								include L_THEPLUS_PATH. 'includes/gallery/gallery-'.esc_attr($style).'.php'; 
								$output .= ob_get_contents();
							ob_end_clean();
						}
						$output .='</div>';
						
						$ji++;
					}
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
}
