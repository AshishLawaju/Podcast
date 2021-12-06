<?php 
/*
Widget Name: Post Content
Description: Post Content
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


class L_ThePlus_Post_Content extends Widget_Base {
		
	public function get_name() {
		return 'tp-post-content';
	}

    public function get_title() {
        return esc_html__('Post Content', 'tpebl');
    }

    public function get_icon() {
        return 'fa fa-file-text-o theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-builder');
    }

    protected function _register_controls() {
		
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Post Content', 'tpebl' ),
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
            'postContentType', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Content Type', 'tpebl'),
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Full Content', 'tpebl'),
                    'excerpt' => esc_html__('Excerpt', 'tpebl'),                    
                ],
				'condition' => [					
					'posttype' => 'singlepage',
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
					'{{WRAPPER}} .elementor-widget-container' => 'justify-content: {{VALUE}};',
				],		
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
		/*Content Section End*/
		/*Post Excerpts Style*/
		$this->start_controls_section(
            'section_excerpts_style',
            [
                'label' => esc_html__('Excerpts', 'tpebl'),
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
					'{{WRAPPER}} > .elementor-widget-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',	
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'excerptstypography',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} > .elementor-widget-container',			
			]
		);
		$this->start_controls_tabs( 'tabs_excerpts_style' );
		$this->start_controls_tab(
			'tab_excerpts_normal',
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
					'{{WRAPPER}} > .elementor-widget-container' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'boxBg',
				'types'     => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} > .elementor-widget-container',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'boxBorder',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} > .elementor-widget-container',
			]
		);
		$this->add_responsive_control(
			'boxBorderRadius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} > .elementor-widget-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],		
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'boxBoxShadow',
				'selector' => '{{WRAPPER}} > .elementor-widget-container',
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
					'{{WRAPPER}} > .elementor-widget-container:hover:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'boxBgHover',
				'types' => [ 'classic', 'gradient'],
				'selector' => '{{WRAPPER}} > .elementor-widget-container:hover:hover',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'boxBorderHover',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} > .elementor-widget-container:hover:hover',
			]
		);
		$this->add_responsive_control(
			'boxBorderRadiusHover',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} > .elementor-widget-container:hover:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],		
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'boxBoxShadowHover',
				'selector' => '{{WRAPPER}} > .elementor-widget-container:hover:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();
		$this->end_controls_section();
		/*Post Excerpts Style*/
	}
	protected function render($wrapper = false) {
		$settings = $this->get_settings_for_display();
		$posttype = !empty($settings['posttype']) ? $settings['posttype'] : 'singlepage';
		$postContentType = !empty($settings['postContentType']) ? $settings['postContentType'] : 'default';
		if(!empty($posttype) && $posttype=='singlepage'){
			if($postContentType == 'default'){
				static $posts = [];
				$post = get_post();

				if ( post_password_required( $post->ID ) ) {
					echo get_the_password_form( $post->ID );
					return;
				}
				if ( isset( $posts[ $post->ID ] ) ) {
					return;
				}

				$posts[ $post->ID ] = true;
				$editor = L_Theplus_Element_Load::elementor()->editor;
				$editmode = $editor->is_edit_mode();

				if ( L_Theplus_Element_Load::elementor()->preview->is_preview_mode( $post->ID ) ) {
					$content = L_Theplus_Element_Load::elementor()->preview->builder_wrapper( '' );
				} else {
					$document = L_Theplus_Element_Load::elementor()->documents->get( $post->ID );
					if ( $document ) {
						$previewType = $document->get_settings( 'preview_type' );
						$previewId = $document->get_settings( 'preview_id' );

						if ( 0 === strpos( $previewType, 'single' ) && ! empty( $previewId ) ) {
							$post = get_post( $previewId );

							if ( ! $post ) {
								return;
							}
						}
					}
					$editor->set_edit_mode( false );
					$content = L_Theplus_Element_Load::elementor()->frontend->get_builder_content( $post->ID, true );

					if (empty($content)) {
						L_Theplus_Element_Load::elementor()->frontend->remove_content_filter();
						setup_postdata( $post );
						
						$content = apply_filters( 'the_content', get_the_content() );

						wp_link_pages( [
							'before' => '<div class="page-links elementor-page-links"><span class="page-links-title elementor-page-links-title">' . __( 'Pages:', 'tpebl' ) . '</span>','after' => '</div>','link_before' => '<span>','link_after' => '</span>','pagelink' => '<span class="screen-reader-text">' . __( 'Page', 'tpebl' ) . ' </span>%','separator' => '<span class="screen-reader-text">, </span>',
						] );

						L_Theplus_Element_Load::elementor()->frontend->add_content_filter();

						return;
					}else{
						$content = apply_filters( 'the_content', $content );
					}
				} 
				L_Theplus_Element_Load::elementor()->editor->set_edit_mode( $editmode );
				
				if ( $wrapper ) {
					echo '<div class="tp-post-content">' . balanceTags( $content, true ) . '</div>';
				} else {
					echo $content;
				}
			}else if($postContentType == 'excerpt'){
				
				the_excerpt( get_the_ID() );
			}
		}else if(!empty($posttype) && $posttype=='archivepage'){
			if ( is_category() || is_tag() || is_tax() ) {
				echo term_description();
			}
		}
	}
    protected function content_template() {
	
    }
}