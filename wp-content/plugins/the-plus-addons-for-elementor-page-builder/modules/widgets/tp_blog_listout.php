<?php 
/*
Widget Name: Blog Post Listing
Description: Different style of Blog Post listing layouts.
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
use Elementor\Group_Control_Image_Size;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly


class L_ThePlus_Blog_ListOut extends Widget_Base {
		
	public function get_name() {
		return 'tp-blog-listout';
	}

    public function get_title() {
        return esc_html__('Blog/Post Listing', 'tpebl');
    }

    public function get_icon() {
        return 'fa fa-newspaper-o theplus_backend_icon';
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
					'style-4' => esc_html__('Style 4 (PRO)', 'tpebl' ),
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
					'style!' => [ 'style-1' ],
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
				'label_block' => true,
				'multiple'   => true,
				'options' => l_theplus_get_categories(),
				'separator' => 'before',
			]
		);
		$this->add_control(
			'post_tags',
			[
				'type' => Controls_Manager::SELECT2,
				'label'      => esc_html__( 'Select Tags', 'tpebl' ),
				'default'    => '',
				'label_block' => true,
				'multiple'   => true,
				'options' => l_theplus_get_tags(),
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
		$this->add_control(
			'plus_pro_metro_column_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'metro_column!' => '3',
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
					'{{WRAPPER}} .blog-list .post-inner-loop .grid-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
			'display_title_limit',
			[
				'label' => esc_html__( 'Title Limit', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'no',							
			]
		);
		$this->add_control(
			'display_title_limit_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'display_title_limit' => [ 'yes' ],
				],
			]
		);
		$this->add_control(
			'display_post_category',
			[
				'label' => esc_html__( 'Display Category Post', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'yes',
				'condition' => [
					'style!' => ['style-1']
				],
			]
		);
		$this->add_control(
			'display_post_category_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'style!' => ['style-1'],
					'display_post_category' => [ 'yes' ],
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
			]
		);		
		$this->add_control(
			'post_excerpt_count',
			[
				'label' => esc_html__( 'Excerpt/Content Count', 'tpebl' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 5,
				'max' => 500,
				'step' => 2,
				'default' => 30,
				'separator' => 'after',
				'condition'   => [
					'display_excerpt'    => 'yes',
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
					'layout!'    => 'carousel',
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
			'display_post_meta',
			[
				'label' => esc_html__( 'Display Post Meta', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),
				'default' => 'yes',
			]
		);
		$this->add_control(
			'post_meta_tag_style',
			[
				'label' => esc_html__( 'Post Meta Tag', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => l_theplus_get_style_list(1),				
				'condition'   => [
					'display_post_meta'    => 'yes',
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
					'layout!' => 'carousel',
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
		$this->add_control(
			'post_extra_option',
			[
				'label' => esc_html__( 'More Post Loading Options', 'tpebl' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [					
					'none' => esc_html__( 'Select Options', 'tpebl' ),
					'pagination'  => esc_html__( 'Pagination', 'tpebl' ),
					'load_more'  => esc_html__( 'Load More', 'tpebl' ),
					'lazy_load'  => esc_html__( 'Lazy Load', 'tpebl' ),
				],
				'separator' => 'before',
				'condition' => [
					'layout!' => ['carousel'],
				],
			]
		);
		$this->add_control(
			'post_extra_pro_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
				'condition'    => [
					'post_extra_option!' => [ 'none' ],
				],
			]
		);
		$this->end_controls_section();
		/*post Extra options*/
		/*post meta tag*/
		$this->start_controls_section(
            'section_meta_tag_style',
            [
                'label' => esc_html__('Post Meta Tag', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'display_post_meta'    => 'yes',
				],
            ]
        );
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'meta_tag_typography',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .blog-list .post-inner-loop .post-meta-info span',
			]
		);
		$this->start_controls_tabs( 'tabs_post_meta_style' );
		$this->start_controls_tab(
			'tab_post_meta_normal',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),				
			]
		);
		$this->add_control(
			'post_meta_color',
			[
				'label' => esc_html__( 'Post Meta Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .blog-list .post-inner-loop .post-meta-info span,{{WRAPPER}} .blog-list .post-inner-loop .post-meta-info span a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tab_post_meta_hover',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_control(
			'post_meta_color_hover',
			[
				'label' => esc_html__( 'Post Meta Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .blog-list .post-inner-loop .blog-list-content:hover .post-meta-info span,{{WRAPPER}} .blog-list .post-inner-loop .blog-list-content:hover .post-meta-info span a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();		
		$this->end_controls_section();
		/*post meta tag*/
		/*Post category*/
		$this->start_controls_section(
            'section_post_category_style',
            [
                'label' => esc_html__('Category Post', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition'   => [
					'display_post_category'    => 'yes',
					'style!' => 'style-1',
				],
            ]
        );
		$this->add_control(
			'section_post_category_style_options',
			[
				'label' => esc_html__( 'Unlock more possibilities', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'description' => theplus_pro_ver_notice(),
				'classes' => 'plus-pro-version',
			]
		);
		$this->end_controls_section();
		/*Post category*/
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
				'selector' => '{{WRAPPER}} .blog-list .post-inner-loop .post-title,{{WRAPPER}} .blog-list .post-inner-loop .post-title a',
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
					'{{WRAPPER}} .blog-list .post-inner-loop .post-title,{{WRAPPER}} .blog-list .post-inner-loop .post-title a' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .blog-list .post-inner-loop .blog-list-content:hover .post-title,{{WRAPPER}} .blog-list .post-inner-loop .blog-list-content:hover .post-title a' => 'color: {{VALUE}}',
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
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .blog-list .post-inner-loop .entry-content,{{WRAPPER}} .blog-list .post-inner-loop .entry-content p',
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
					'{{WRAPPER}} .blog-list .post-inner-loop .entry-content,{{WRAPPER}} .blog-list .post-inner-loop .entry-content p' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .blog-list .post-inner-loop .blog-list-content:hover .entry-content,{{WRAPPER}} .blog-list .post-inner-loop .blog-list-content:hover .entry-content p' => 'color: {{VALUE}}',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
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
				'selector' => '{{WRAPPER}} .blog-list.blog-style-1 .post-content-bottom',
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
				'selector' => '{{WRAPPER}} .blog-list.blog-style-1 .blog-list-content:hover .post-content-bottom',
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
				'options' => l_theplus_get_style_list(1,'yes'),
			]
		);
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
					'{{WRAPPER}} .blog-list .post-inner-loop .grid-item .blog-list-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'style!' => ['style-1','style-4'],
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
		$this->add_responsive_control(
			'border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .blog-list .post-inner-loop .grid-item .blog-list-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
		$this->add_responsive_control(
			'border_hover_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .blog-list .post-inner-loop .grid-item .blog-list-content:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'box_border' => 'yes',
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
				'selector'  => '{{WRAPPER}} .blog-list .post-inner-loop .grid-item .blog-list-content',
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
				'selector'  => '{{WRAPPER}} .blog-list .post-inner-loop .grid-item .blog-list-content:hover',
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
		$post_title_tag=$settings["post_title_tag"];
		
		$post_category=$settings['post_category'];
		$post_tags=$settings['post_tags'];		
		
		$display_post_meta=$settings["display_post_meta"];
		$post_meta_tag_style=$settings["post_meta_tag_style"];
		
		
		$display_excerpt=$settings["display_excerpt"];
		$post_excerpt_count=$settings["post_excerpt_count"];
		
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
			if(isset($settings["metro_style_".$metro_columns]) && !empty($settings["metro_style_".$metro_columns])){
				$layout_attr .=' data-metro-style="'.esc_attr($settings["metro_style_".$metro_columns]).'" ';
			}
		}
		
		$data_class .=' blog-'.$style;
		$data_class .=' hover-image-'.$settings["hover_image_style"];		
		
		$output=$data_attr='';	
		
		$ji=1;$ij='';
		$uid=uniqid("post");
		
		$data_attr .=' data-id="'.esc_attr($uid).'"';
		$data_attr .=' data-style="'.esc_attr($style).'"';
		$tablet_metro_class=$tablet_ij='';
		
		if ( ! $query->have_posts() ) {
			$output .='<h3 class="theplus-posts-not-found">'.esc_html__( "Posts not found", "tpebl" ).'</h3>';
		}else{
			if($style=='style-1'){
				$output .= '<div id="pt-plus-blog-post-list" class="blog-list '.esc_attr($uid).' '.esc_attr($data_class).' '.$animated_class.'" '.$layout_attr.' '.$data_attr.' '.$animation_attr.' data-enable-isotope="1">';
				
				$output .= '<div id="'.esc_attr($uid).'" class="tp-row post-inner-loop '.esc_attr($uid).' ">';
				while ( $query->have_posts() ) {
				
					$query->the_post();
					$post = $query->post;
					
					if($layout=='metro'){
						$metro_columns=$settings['metro_column'];
						if(!empty($settings["metro_style_".$metro_columns])){
							$ij=l_theplus_metro_style_layout($ji,$settings['metro_column'],$settings["metro_style_".$metro_columns]);
						}						
					}
					
					//grid item loop
					$output .= '<div class="grid-item metro-item'.esc_attr($ij).' '.esc_attr($tablet_metro_class).' '.$desktop_class.' '.$tablet_class.' '.$mobile_class.' '.$animated_columns.'">';				
					if(!empty($style)){
						ob_start();
						include L_THEPLUS_PATH. 'includes/blog/blog-style-1.php';
						$output .= ob_get_contents();
						ob_end_clean();
					}
					$output .='</div>';
					
					$ji++;
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
		
		$query_args = array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'posts_per_page'      => intval( $settings['display_posts'] ),
			'orderby'      =>  $settings['post_order_by'],
			'order'      => $settings['post_order'],
		);

		$offset = $settings['post_offset'];
		$offset = ! empty( $offset ) ? absint( $offset ) : 0;
		
		
		if ( $offset ) {
			$query_args['offset'] = $offset;
		}
		
		if ( '' !== $settings['post_category'] ) {			
			$query_args['category__in'] = $settings['post_category'];
		}
		if ( '' !== $settings['post_tags'] ) {
			$query_args['tag__in'] = $settings['post_tags'];
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
