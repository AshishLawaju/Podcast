<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.


class Widget_SecondLineAddonssubscribe_button extends Widget_Base {

	public function get_name() {
		return 'secondline-addons-psb-element';
	}

	public function get_title() {
		return esc_html__( 'SecondLine - Subscribe Button', 'secondline-custom-plugin' );
	}

	public function get_icon() {
		return 'eicon-button secondline-addons-icon';
	}

   public function get_categories() {
		return [ 'basic' ];
	}
	
	protected function _register_controls() {

		
  		$this->start_controls_section(
  			'section_title_secondline_global_options',
  			[
  				'label' => esc_html__( 'Subscribe Button Selection', 'secondline-custom-plugin' )
  			]
  		);
		
	
		
		$this->add_control(
			'secondline_addons_subscribe_button_list',
			[
				'label' => esc_html__( 'Select your subscribe button', 'secondline-custom-plugin' ),
				'description' => esc_html__( 'You may need to create your first Subscribe Button if you cannot find anything on this list. You can easily add a new button in the admin panel under the "Subscribe Buttons" menu, assuming you have the "Podcast Subscribe Buttons" plugin enabled.', 'secondline-custom-plugin' ),
				'label_block' => true,
				'type' => Controls_Manager::SELECT,
				'options' => secondline_subscribe_button_selection(),
			]
		);
		
		$this->add_control(
			'secondline_addons_button_type',
			[
				'label' => esc_html__( 'Button Type', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'modal' => esc_html__( 'Modal / Pop-Up', 'secondline-custom-plugin' ),
					'list' => esc_html__( 'Vertical List', 'secondline-custom-plugin' ),
					'inline' => esc_html__( 'Inline Buttons', 'secondline-custom-plugin' ),
					'icons' => esc_html__( 'Icons Only', 'secondline-custom-plugin' ),		
				],			
			]
		);		

		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_subscribe_button_styles',
			[
				'label' => esc_html__( 'General Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		
		$this->add_control(
			'secondline_addons_button_position',
			[
				'label' => esc_html__( 'Button Alignment', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'secondline-custom-plugin' ),
						'icon' => 'fas fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'secondline-custom-plugin' ),
						'icon' => 'fas fa-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'secondline-custom-plugin' ),
						'icon' => 'fas fa-align-right',
					],
				],
				'default' => 'center',
				'toggle' => true,				
				'selectors' => [
					'body #main-container-secondline {{WRAPPER}} .secondline-addons-subscribe-button-container' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		
		
		$this->add_responsive_control(
			'secondline_addons_input_padding',
			[
				'label' => esc_html__( 'Button Padding', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'body #main-container-secondline {{WRAPPER}} .secondline-addons-subscribe-button-container a.button.podcast-subscribe-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'secondline_addons_button_type',
							'operator' => '!in',
							'value' => [
								'icons',
							],
						],
					],
				],				
			]
		);
		

		
		$this->add_control(
			'secondline_addons_input_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::DIMENSIONS,
				'separator' => 'before',
				'size_units' => [ 'px' ],
				'selectors' => [
					'body #main-container-secondline {{WRAPPER}} .secondline-addons-subscribe-button-container a.button.podcast-subscribe-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'secondline_addons_button_type',
							'operator' => '!in',
							'value' => [
								'icons',
							],
						],
					],
				],					
			]
		);
		
		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'secondline_addons_input_border',
				'selector' => 'body #main-container-secondline {{WRAPPER}} .secondline-addons-subscribe-button-container a.button.podcast-subscribe-button',
				'conditions' => [
					'terms' => [
						[
							'name' => 'secondline_addons_button_type',
							'operator' => '!in',
							'value' => [
								'icons',
							],
						],
					],
				],					
			]
		);		
		
		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'section_subscribe_button_typography',
			[
				'label' => esc_html__( 'Button Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);
		
		
		$this->add_control(
			'secondline_addons_subscribe_button_color',
			[
				'label' => esc_html__( 'Default Font Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'body #main-container-secondline {{WRAPPER}} .secondline-addons-subscribe-button-container a' => 'color: {{VALUE}} !important;',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'secondline_addons_button_type',
							'operator' => '!in',
							'value' => [
								'icons',
							],
						],
					],
				],					
			]
		);
				
		$this->add_control(
			'secondline_addons_subscribe_button_color_hover',
			[
				'label' => esc_html__( 'Hover Font Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'body #main-container-secondline {{WRAPPER}} .secondline-addons-subscribe-button-container a:hover' => 'color: {{VALUE}} !important;',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'secondline_addons_button_type',
							'operator' => '!in',
							'value' => [
								'icons',
							],
						],
					],
				],					
			]
		);
		
		$this->add_control(
			'secondline_addons_subscribe_button_bg',
			[
				'label' => esc_html__( 'Default Button Background', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'body #main-container-secondline {{WRAPPER}} .secondline-addons-subscribe-button-container a' => 'background-color: {{VALUE}} !important;',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'secondline_addons_button_type',
							'operator' => '!in',
							'value' => [
								'icons',
							],
						],
					],
				],					
			]
		);
				
		$this->add_control(
			'secondline_addons_subscribe_button_bg_hover',
			[
				'label' => esc_html__( 'Hover Background Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'body #main-container-secondline {{WRAPPER}} .secondline-addons-subscribe-button-container a:hover' => 'background-color: {{VALUE}} !important;',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'secondline_addons_button_type',
							'operator' => '!in',
							'value' => [
								'icons',
							],
						],
					],
				],					
			]
		);	

		$this->add_control(
			'secondline_addons_subscribe_button_border_hover',
			[
				'label' => esc_html__( 'Hover Border Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'body #main-container-secondline {{WRAPPER}} .secondline-addons-subscribe-button-container a:hover' => 'border-color: {{VALUE}} !important;',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'secondline_addons_button_type',
							'operator' => '!in',
							'value' => [
								'icons',
							],
						],
					],
				],					
			]
		);			
		
		$this->add_control(
			'secondline_addons_button_default',
			[
				'type' => Controls_Manager::HEADING,
				'label' => esc_html__( 'Typography', 'secondline-custom-plugin' ),
				'separator' => 'before',
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'secondline_addons_subscribe_button_default_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => 'body #main-container-secondline {{WRAPPER}} .secondline-addons-subscribe-button-container a',
				'conditions' => [
					'terms' => [
						[
							'name' => 'secondline_addons_button_type',
							'operator' => '!in',
							'value' => [
								'icons',
							],
						],
					],
				],					
			]
		);
		

		
		$this->end_controls_section();
		
		
		
		$this->end_controls_tabs();
	
		
		
		$this->end_controls_section();
		
		
	}


	protected function render( ) {
		
      $settings = $this->get_settings();
		

	?>
	
	
	<?php if ( ! empty( $settings['secondline_addons_subscribe_button_list'] ) ) : ?>
		<div class="secondline-addons-subscribe-button-container">		
			<?php echo do_shortcode( '[podcast_subscribe id="' . $settings['secondline_addons_subscribe_button_list'] . '" type="' . $settings['secondline_addons_button_type'] . '" ]' ); ?>
		</div><!-- close .secondline-addons-subscribe-button-container -->
	<?php endif; ?>
	
	<?php
	
	}

	protected function content_template(){}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_SecondLineAddonssubscribe_button() );