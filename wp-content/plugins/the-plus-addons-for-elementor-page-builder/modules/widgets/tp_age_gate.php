<?php 
/*
Widget Name: Age Gate
Description: Age gate
Author: Theplus
Author URI: https://posimyth.com
*/
namespace TheplusAddons\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

use TheplusAddons\Theplus_Element_Load;
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class L_ThePlus_Age_Gate extends Widget_Base {
		
	public function get_name() {
		return 'tp-age-gate';
	}

    public function get_title() {
        return esc_html__('Age Gate', 'tpebl');
    }

    public function get_icon() {
        return 'fas fa-user-shield theplus_backend_icon';
    }

    public function get_categories() {
        return array('plus-essential');
    }

    protected function _register_controls() {
		/* Layout Tab */
		$this->start_controls_section(
			'age_head_content_section',
			[
				'label' => esc_html__( 'Layout', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
            'age_verify_method', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Method', 'tpebl'),
                'default' => 'method-1',
                'options' => [
                    'method-1' => esc_html__('Age Confirmation', 'tpebl'),
                    'method-2' => esc_html__('Birth Date', 'tpebl'), 
                    'method-3' => esc_html__('Boolean', 'tpebl'),                   
                ],
            ]
        );
        $this->add_control(
			'backend_preview',[
				'label'   => esc_html__( 'Backend Visibility', 'tpebl' ),
				'type'    =>  Controls_Manager::SWITCHER,
				'default' => 'yes',
				'label_on' => esc_html__( 'Show', 'tpebl' ),
				'label_off' => esc_html__( 'Hide', 'tpebl' ),	
				'description' => esc_html__( 'Note : Keep this disabled, If you do not want that to load on editor page. Either It will highjack your whole page.', 'tpebl' ),
				'separator' => 'before',
			]
		);
		$this->end_controls_section();
		/* Layout Tab */
		/*Content Tab */
		$this->start_controls_section(
			'age_actContent_section',
			[
				'label' => esc_html__( 'Content', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
        $this->add_control(
            'age_icon_img_type',
            [
				'label' => esc_html__( 'Logo', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'yes',
			]
        );
		 $this->add_control(
			'age_head_img',
			[
				'label' => esc_html__( 'Logo', 'tpebl' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => ['active'   => true,],
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'age_icon_img_type' => 'yes',
				],

			]
		);
		$this->add_control(
            'age_gate_title',
            [
				'label' => esc_html__( 'Title', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'yes',
				'separator' => 'before',
			]
        );
		$this->add_control(
			'age_gate_title_input',
			[
				'label' => esc_html__( 'Title', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => [ 'active' => true,],
				'default' => esc_html__( 'Age Verification', 'tpebl' ),
				'placeholder' => esc_html__( 'Enter Your Title', 'tpebl' ),	
				'label_block' => true,			
				'condition' => [
					'age_gate_title' => 'yes',
				],
			]
		);
		$this->add_control(
            'age_gate_description',
            [
				'label' => esc_html__( 'Description', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'yes',
				'separator' => 'before',				
			]
        );
        $this->add_control(
            'age_gate_description_input',
            [   
            	'label' => esc_html__( 'Description', 'tpebl' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'You must be 18 years old to visit our website.', 'tpebl' ),
				'placeholder' => esc_html__( 'Enter Description', 'tpebl' ),
				'dynamic' => ['active'   => true,],
				'condition' => [
					'age_verify_method' => 'method-1',
					'age_gate_description' => 'yes',
				],
            ]
        );
        $this->add_control(
            'age_gate_description_inputwo',
            [   
            	'label' => esc_html__( 'Description', 'tpebl' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'You must be 18 years old to visit our website. Enter your birthdate below, your age will be calculated automatically.', 'tpebl' ),
				'placeholder' => esc_html__( 'Enter Description', 'tpebl' ),
				'dynamic' => ['active'   => true,],
				'condition' => [
					'age_verify_method' => 'method-2',
					'age_gate_description' => 'yes',
				],
            ]
        );
        $this->add_control(
            'age_gate_description_inputhree',
            [   
            	'label' => esc_html__( 'Description', 'tpebl' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'You must be 18 years old to visit our website. Select your preference below.', 'tpebl' ),
				'placeholder' => esc_html__( 'Enter Description', 'tpebl' ),
				'dynamic' => ['active'   => true,],
				'condition' => [
					'age_verify_method' => 'method-3',
					'age_gate_description' => 'yes',
				],
            ]
        );
        $this->add_control(
			'chkinput_text',
			[
				'label' => esc_html__( 'Check Input Text', 'tpebl' ),
				'type' => Controls_Manager::TEXTAREA,
				'dynamic' => ['active'   => true,],
				'default' => esc_html__( 'I confirm that I am 18 years old or over', 'tpebl' ),
				'placeholder' => esc_html__( 'Enter Text', 'tpebl' ),
				'separator' => 'before',
				'condition' => [
					'age_verify_method' => 'method-1',
				],	

			]
		);
		$this->add_control(
			'birthyears',
			[
				'label' => esc_html__( 'Minimum Age Limit', 'tpebl' ),
				'type' => Controls_Manager::NUMBER,
				'dynamic' => [
					'active' => true,
				],
				'min' => 6,
				'max' => 100,
				'default' => 18,
				'condition' => [
					'age_verify_method' => 'method-2',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'db_max_width',
			[
				'label' => esc_html__( 'Form Content Max-width', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,	
				'separator' => 'before',			
				'range' => [					
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'render_type' => 'ui',			
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-wrapper .tp-agegate-method' => 'max-width: {{SIZE}}%;',
				],
				'condition' => [
					'age_verify_method' => ['method-2','method-3'],
				],
			]
		);
		$this->add_control(
			'FirstBTn_options',
			[
				'label' => esc_html__( 'First Button Options', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_control(
			'button_text',
			[
				'label' => esc_html__( 'Button Text', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => ['active'   => true,],
				'default' => esc_html__( 'Enter', 'tpebl' ),
				'placeholder' => esc_html__( 'Enter Text', 'tpebl' ),
			]
		);
		$this->add_control(
            'icon_action',
            [
				'label' => esc_html__( 'Button Icon', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'yes',		
			]
        );
		$this->add_control(
			'button_icon',
			[
				'label' => esc_html__( 'Button Icon', 'tpebl' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-book-open',
					'library' => 'solid',
				],
				'condition' => [
					'icon_action' => 'yes',
				],
			]
		);
		$this->add_control(
            'icon_position', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Icon Position', 'tpebl'),
                'default' => 'age_icon_prefix',
                'options' => [                   
                    'age_icon_prefix' => esc_html__('Prefix', 'tpebl'), 
                     'age_icon_postfix' => esc_html__('Postfix', 'tpebl'),                   
                ],
                'condition' => [
                	'icon_action' => 'yes',
				],
            ]
        ); 
        $this->add_control(
			'SecondBTn_options',
			[
				'label' => esc_html__( 'Second Button Options', 'tpebl' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'age_verify_method' => 'method-3',
				],
			]
		);
        $this->add_control(
			'second_button_text',
			[
				'label' => esc_html__( 'Button Text', 'tpebl' ),
				'type' => Controls_Manager::TEXT,
				'dynamic' => ['active'   => true,],
				'default' => esc_html__( 'No', 'tpebl' ),
				'placeholder' => esc_html__( 'Enter Text', 'tpebl' ),
				'condition' => [
					'age_verify_method' => 'method-3',
				],
			]
		);
		$this->add_control(
            'second_icon_action',
            [
				'label' => esc_html__( 'Button Icon', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'yes',
				'condition' => [
					'age_verify_method' => 'method-3',
				],			
			]
        );
		$this->add_control(
			'second_button_icon',
			[
				'label' => esc_html__( 'Button Icon', 'tpebl' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-book-reader',
					'library' => 'solid',
				],
				'condition' => [
					'age_verify_method' => 'method-3',
					'second_icon_action' => 'yes',
				],
			]
		);
		$this->add_control(
            'second_icon_position', [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__('Icon Position', 'tpebl'),
                'default' => 'age_scnd_icon_prefix',
                'options' => [                   
                    'age_scnd_icon_prefix' => esc_html__('Prefix', 'tpebl'), 
                     'age_scnd_icon_postfix' => esc_html__('Postfix', 'tpebl'),                   
                ],
                'condition' => [
                	'age_verify_method' => 'method-3',
                	'second_icon_action' => 'yes',
				],
            ]
        );
        $this->add_control(
            'age_extra_info_switch',
            [
				'label' => esc_html__( 'Extra Info', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'yes',
				'separator' => 'before',
			]
        );
		$this->add_control(
            'age_extra_info',
            [   
            	'label' => esc_html__( 'Extra Info', 'tpebl' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'By entering this site you are agreeing to the Terms of Use and Privacy Policy.', 'tpebl' ),
				'placeholder' => esc_html__( 'Type your extra info here', 'tpebl' ),
				'dynamic' => [
					'active'   => true,

				],
				'condition' => [
                	'age_extra_info_switch' => 'yes',
				],
            ]
        );
        $this->add_control(
			'age_gate_wrong_message',
            [   
            	'label' => esc_html__( 'Error Message', 'tpebl' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => esc_html__( 'Sorry...!!! You are not eligible for this website', 'tpebl' ),
				'placeholder' => esc_html__( 'Enter Your Message', 'tpebl' ),
				'dynamic' => ['active'   => true,],
				'condition' => [
					'age_verify_method' => ['method-2','method-3'],
				],
				'separator' => 'before',
            ]
		);		
        $this->add_responsive_control(
			'age_gate_align',
			[
				'label' => esc_html__( 'Alignment', 'tpebl' ),
				'type' => Controls_Manager::CHOOSE,
				'default' => 'center',
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
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-wrapper .tp-agegate-inner-wrapper .tp-agegate-boxes,
					{{WRAPPER}} .tp-agegate-wrapper .tp-agegate-inner-wrapper .tp-agegate-boxes *:not(.tp-age-btn-ex)' => 'align-items: {{VALUE}};justify-content: {{VALUE}};',			
				],
			]
		);
		$this->add_control(
			'age_gate_align_txtera',
			[
				'label'   => esc_html__( 'Textarea Alignment', 'tpebl' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => [
					'left'    => [
						'title' => esc_html__( 'Left', 'tpebl' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'tpebl' ),
						'icon'  => 'fa fa-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'tpebl' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'selectors'  => [
					'{{WRAPPER}} .tp-agegate-wrapper .tp-agegate-inner-wrapper .tp-agegate-boxes,
					{{WRAPPER}} .tp-agegate-wrapper .tp-agegate-inner-wrapper .tp-agegate-boxes *:not(.tp-age-btn-ex)' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->end_controls_section();
		/* Content Tab */
		/* Extra Option Tab */
		$this->start_controls_section(
			'ag_extra_opt',
			[
				'label' => esc_html__( 'Extra Option', 'tpebl' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		$this->add_control(
            'age_sec_bg_image_switch',
            [
				'label' => esc_html__( 'Background Image', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'no',
				'separator' => 'before',
			]
        );
		$this->add_control(
			'age_sec_bg_image',
			[
				'label' => esc_html__( 'Background', 'tpebl' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => ['active'   => true,],
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'age_sec_bg_image_switch' => 'yes',
				],
				'separator' => 'before',
			]
		);
		$this->add_control(
			'age_bgImg_pos',
			[
				'label' => esc_html__( 'Background Position', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'center center',
				'options' => l_theplus_get_image_position_options(),
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-wrapper' => 'background-position:{{VALUE}} !important;',
				],
				'condition' => [
					'age_sec_bg_image_switch' => 'yes',
				],
			]
		);
		$this->add_control(
			'age_sec_bg_overlay_color',
			[
				'label' => esc_html__( 'Overlay Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-wrapper:after' => 'background: {{VALUE}};',
				],
				'condition' => [
					'age_sec_bg_image_switch' => 'yes',
				],
			]
		);
	    $this->add_control(
            'age_side_image_show',
            [
				'label' => esc_html__( 'Right Side Image', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'no',
				'separator' => 'before',
			]
        );
		$this->add_control(
			'age_side_img',
			[
				'label' => esc_html__( 'Image', 'tpebl' ),
				'type' => Controls_Manager::MEDIA,
				'dynamic' => ['active'   => true,],
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'age_side_image_show' => 'yes',
				],
			]
		);
		$this->add_control(
			'age_rightImg_pos',
			[
				'label' => esc_html__( 'Right Image Position', 'tpebl' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'center center',
				'options' => l_theplus_get_image_position_options(),
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes.tp-equ-width-50' => 'background-position:{{VALUE}} !important;',
				],
				'condition' => [
					'age_side_image_show' => 'yes',
				],
			]
		);
		$this->add_control(
            'age_cookies',
            [
				'label' => esc_html__( 'Cookies', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'yes',
				'separator' => 'before',
			]
        );
		$this->add_control(
			'age_cookies_days',
			[
				'label' => esc_html__( 'Cookies Expiry Time', 'tpebl' ),
				'type' => Controls_Manager::NUMBER,
				'dynamic' => [
					'active' => true,
				],
				'min' => 1,
				'max' => 365,
				'default' => 10,
				'condition' => [
					'age_cookies' => 'yes',
				],
			]
		);
		$this->add_control(
			'age_gate_cookiNote',
			[				
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => esc_html__( 'Note : Set The Number Of Days Cookies To Be Saved.', 'tpebl' ),
				'content_classes' => 'tp-widget-description',
				'condition' => [
					'age_cookies' => 'yes',
				],	
			]
		);
		$this->end_controls_section();
		/* Extra Option Tab */
		/* Logo Style */
		$this->start_controls_section(
            'age_logo_styling',
            [
                'label' => esc_html__('Logo', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [					
					'age_icon_img_type' => 'yes',
				],					
            ]
        );
       $this->add_responsive_control(
            'logo_size',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Logo Size', 'tpebl'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
						'step' => 1,
					],
				],
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-inner-wrapper .tp-agegate-boxes .tp-age-ii .tp-agegate-image' => 'max-width: {{SIZE}}{{UNIT}}',
				],
            ]
        );
        $this->add_responsive_control(
			'logo_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-agegate-inner-wrapper .tp-agegate-boxes .tp-age-ii .tp-agegate-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],			
			]
		);   
        $this->add_responsive_control(
			'logo_margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-inner-wrapper .tp-agegate-boxes .tp-age-ii .tp-agegate-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],		
			]
		);
        $this->end_controls_section();
      	/* Logo Style */
        /*Title Style*/
		$this->start_controls_section(
            'age_title_styling',
            [
                'label' => esc_html__('Title', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
                 'condition' => [					
					'age_gate_title' => 'yes',
				],						
            ]
        );       
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typo',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tp-agegate-boxes .tp-agegate-title',
				'separator' => 'before',	
			]
		);
		$this->add_responsive_control(
			'title_padding',
			[
				'label' => esc_html__( 'Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-agegate-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		$this->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-agegate-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',		
			]
		);
		$this->start_controls_tabs( 'age_title_color' );
		$this->start_controls_tab(
			'title_color_n',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_control(
			'titleNmlColor',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-agegate-title' => 'color: {{VALUE}};',
				],				
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'title_color_h',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),				
			]
		);
		$this->add_control(
			'titleHvrColor',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-title' => 'color: {{VALUE}};',
				],				
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();			
        $this->end_controls_section();
        /*Title Style*/
        /*Description Style*/
		$this->start_controls_section(
            'age_desc_styling',
            [
                'label' => esc_html__('Description', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,	
                 'condition' => [					
					'age_gate_description' => 'yes',
				],					
            ]
        );
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'desc_typo',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tp-agegate-boxes .tp-agegate-description',				
			]
		);
		$this->add_responsive_control(
			'desc_padding',
			[
				'label'      => esc_html__( 'Padding', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-agegate-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		$this->add_responsive_control(
			'desc_margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-agegate-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',		
			]
		);
		$this->start_controls_tabs( 'age_desc_color' );
		$this->start_controls_tab(
			'desc_color_n',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),				
			]
		);
		$this->add_control(
			'descNmlColor',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-agegate-description' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'descNmlBG',
				'label' => esc_html__( 'Background Type', 'tpebl' ),
			    'types' => [ 'classic', 'gradient' ],
			    'selector' => '{{WRAPPER}} .tp-agegate-boxes .tp-agegate-description',   
			]
		);
		 $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'descNmlBorder',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} .tp-agegate-boxes .tp-agegate-description',
			]
	    );
		$this->add_responsive_control(
			'descNmlBRadius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-agegate-description' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'desc_color_h',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),				
			]
		);
		$this->add_control(
			'descHvrColor',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-description' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
			   'name' => 'descHvrBG',
			   'label' => esc_html__( 'Background Type', 'tpebl' ),
			   'types' => [ 'classic', 'gradient' ],
			   'selector' => '{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-description',
			]
		);
		 $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'descHvrBorder',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-description',	
			]
	    );
		$this->add_responsive_control(
			'descHvrBRadius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-description' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();	
        $this->end_controls_section();
        /*Description Style*/
        /*Checkbox Icon/Text Style*/
		$this->start_controls_section(
            'age_chktxt_styling',
            [
                'label' => esc_html__('Checkbox Icon/Text', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
                 'condition' => [					
					'age_verify_method' => 'method-1',
				],						
            ]
        );      
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'chktxt_typo',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .agc_checkbox',
				'separator' => 'before',	
			]
		);
		$this->add_responsive_control(
			'chktxt_padding',
			[
				'label' => esc_html__( 'Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .agc_checkbox' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		$this->add_responsive_control(
			'chktxt_margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .agc_checkbox' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',		
			]
		);
		$this->start_controls_tabs( 'age_chktxt_color' );
		$this->start_controls_tab(
			'chktxt_color_n',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_control(
			'chktxtNmlColor',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .agc_checkbox' => 'color: {{VALUE}};',
				],
				
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'chktxt_color_h',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),				
			]
		);
		$this->add_control(
			'chktxtHvrColor',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .agc_checkbox' => 'color: {{VALUE}};',
				],				
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();			
        $this->end_controls_section();
        /*Checkbox Icon/Text Style*/
        /*Input Field Style*/
		$this->start_controls_section(
            'age_inputdate_styling',
            [
                'label' => esc_html__('Input Field', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,	
                'condition' => [					
					'age_verify_method' => 'method-2',
				],					
            ]
        );
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'inputdate_typo',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_verify_birthdate',
			]
		);
        $this->add_responsive_control(
			'inputdate_margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_verify_birthdate' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'inputdate_padding',
			[
				'label' => esc_html__( 'Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_verify_birthdate' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',	
			]
		);
		$this->start_controls_tabs( 'age_inputdate_tab' );
		$this->start_controls_tab(
			'inputdate_n',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_control(
            'inputdate_color',
            [
                'label' => esc_html__('Text Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_verify_birthdate' => 'color:{{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'inputdate_background',
				'label' => esc_html__( 'Background Type', 'tpebl' ),
			    'types' => [ 'classic', 'gradient' ],
			    'selector' => '{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_verify_birthdate',  
			]
		);		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'inputdate_border',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_verify_birthdate',
			]
		);
		$this->add_responsive_control(
			'inputdate_bradius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_verify_birthdate'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',				
				],
				'separator' => 'after',	
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'inputdate_Shadow',
				'label' => esc_html__( 'Box Shadow', 'tpebl' ),
				'selector' => '{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_verify_birthdate',				
			]
		);	
		$this->end_controls_tab();
		$this->start_controls_tab(
			'inputdate_h',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_control(
            'inputdate_color_h',
            [
                'label' => esc_html__('Text Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .age_verify_birthdate'=> 'color:{{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'inputdate_background_h',
				'label' => esc_html__( 'Background Type', 'tpebl' ),
			    'types' => [ 'classic', 'gradient' ],
			    'selector' => '{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .age_verify_birthdate',    
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'inputdate_border_h',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' =>  '{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .age_verify_birthdate',
			]
		);
		$this->add_responsive_control(
			'inputdate_bradius_h',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					 '{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .age_verify_birthdate' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',			
				],
				'separator' => 'after',	
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'inputdate_Shadow_h',
				'label' => esc_html__( 'Box Shadow', 'tpebl' ),
				'selector' =>  '{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .age_verify_birthdate',				
			]
		);	
		$this->end_controls_tab();
		$this->end_controls_tabs();
        $this->end_controls_section();
        /*Input Field Style*/
        /*First button Style*/
		$this->start_controls_section(
            'age_firstbtn_styling',
            [
                'label' => esc_html__('First Button', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,					
            ]
        );
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'fbtn_typo',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_vms .age_vmb,
					{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_verify_method_btnsubmit,
					{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .tp-age-btn-yes',				
			]
		);
		$this->add_responsive_control(
			'fbtn_padding',
			[
				'label' => esc_html__( 'Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_vms .age_vmb,
					{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_verify_method_btnsubmit,
					{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .tp-age-btn-yes' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],	
			]
		);
        $this->add_responsive_control(
			'fbtn_margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_vms,
					{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_verify_method_btnsubmit,
					{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .tp-age-btn-yes' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->start_controls_tabs( 'age_firstbtn_tab' );
		$this->start_controls_tab(
			'fbtn_n',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_control(
            'fbtn_color',
            [
                'label' => esc_html__('Text Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_vms .age_vmb,
					{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_verify_method_btnsubmit,
					{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .tp-age-btn-yes' => 'color: {{VALUE}};',
                ],
            ]
        );
         $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'fbtn_background',
				'label' => esc_html__( 'Background Type', 'tpebl' ),
			    'types' => [ 'classic', 'gradient' ],
			    'selector' => '{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_vms .age_vmb,
				{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_verify_method_btnsubmit,
				{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .tp-age-btn-yes',		    
			]
		);	
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'fbtn_border',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_vms .age_vmb,
					{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_verify_method_btnsubmit,
					{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .tp-age-btn-yes',
			]
		);
		$this->add_responsive_control(
			'fbtn_bradius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_vms .age_vmb,
					{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_verify_method_btnsubmit,
					{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .tp-age-btn-yes'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',				
				],	
				'separator' => 'after',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'fbtn_Shadow',
				'label' => esc_html__( 'Box Shadow', 'tpebl' ),
				'selector' => '{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_vms .age_vmb,
					{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .age_verify_method_btnsubmit,
					{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .tp-age-btn-yes',	
			]
		);	
		$this->end_controls_tab();
		$this->start_controls_tab(
			'fbtn_h',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_control(
            'fbtn_color_h',
            [
                'label' => esc_html__('Text Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .age_vms .age_vmb,
					{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .age_verify_method_btnsubmit,
					{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .tp-age-btn-yes'=> 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'fbtn_background_h',
				'label' => esc_html__( 'Background Type', 'tpebl' ),
			    'types' => [ 'classic', 'gradient' ],
			    'selector' => '{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .age_vms .age_vmb,
				{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .age_verify_method_btnsubmit,
				{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .tp-age-btn-yes',   
			]
		);	
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'fbtn_border_h',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' =>  '{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .age_vms .age_vmb,
					{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .age_verify_method_btnsubmit,
					{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .tp-age-btn-yes',
			]
		);
		$this->add_responsive_control(
			'fbtn_bradius_h',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					 '{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .age_vms .age_vmb,
					{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .age_verify_method_btnsubmit,
					{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .tp-age-btn-yes' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',			
				],
				'separator' => 'after',	
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'fbtn_Shadow_h',
				'label' => esc_html__( 'Box Shadow', 'tpebl' ),
				'selector' =>  '{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .age_vms .age_vmb,
					{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .age_verify_method_btnsubmit,
					{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .tp-age-btn-yes',
				
			]
		);	
		$this->end_controls_tab();
		$this->end_controls_tabs();
        $this->end_controls_section();
        /*First button Style*/
        /*First button icon Style*/
		$this->start_controls_section(
            'age_tglicon_styling',
            [
                'label' => esc_html__('First Button Icon', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,	
                'condition' => [
					'icon_action' => 'yes',
				],					
            ]
        );
        $this->add_responsive_control(
            'tgl_icn_size',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Size', 'tpebl'),
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
						'step' => 1,
					],
				],				
				'render_type' => 'ui',				
				'selectors' => [
					'{{WRAPPER}} .tp-method-1 .tp-agegate-boxes .tp-agegate-method .age_vmb i,{{WRAPPER}} .tp-method-2 .tp-agegate-boxes .tp-agegate-method .age_verify_method_btnsubmit i,{{WRAPPER}} .tp-method-3 .tp-agegate-boxes .tp-agegate-method .tp-age-btn-yes i' => 'font-size: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->add_responsive_control(
            'tgl_icn_space',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Offset', 'tpebl'),
				'size_units' => [ 'px','%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
					'%' => [
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
				'selectors' => [
					'{{WRAPPER}} .tp-method-1 .tp-agegate-boxes .tp-agegate-method .age_vmb i,{{WRAPPER}} .tp-method-2 .tp-agegate-boxes .tp-agegate-method .age_verify_method_btnsubmit i,{{WRAPPER}} .tp-method-3 .tp-agegate-boxes .tp-agegate-method .tp-age-btn-yes i' => 'margin-right: {{SIZE}}{{UNIT}}',
				],
				'condition'    => [
				 	'icon_position' => [ 'age_icon_postfix' ],
				],				
            ]
        );
		$this->add_responsive_control(
            'tgl_icn_space_left',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Offset', 'tpebl'),
				'size_units' => [ 'px','%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
					'%' => [
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
				'selectors' => [
					'{{WRAPPER}} .tp-method-1 .tp-agegate-boxes .tp-agegate-method .age_vmb i,{{WRAPPER}} .tp-method-2 .tp-agegate-boxes .tp-agegate-method .age_verify_method_btnsubmit i,{{WRAPPER}} .tp-method-3 .tp-agegate-boxes .tp-agegate-method .tp-age-btn-yes i' => 'margin-left: {{SIZE}}{{UNIT}}',
				],
				'condition'    => [
				 	'icon_position' => [ 'age_icon_prefix' ],
				],
            ]
        );
        $this->add_responsive_control(
			'tgl_margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .tp-method-1 .tp-agegate-boxes .tp-agegate-method .age_vmb i,{{WRAPPER}} .tp-method-2 .tp-agegate-boxes .tp-agegate-method .age_verify_method_btnsubmit i,{{WRAPPER}} .tp-method-3 .tp-agegate-boxes .tp-agegate-method .tp-age-btn-yes i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
        $this->start_controls_tabs( 'tgl_icon_color' );
		$this->start_controls_tab(
			'tglicn_color_n',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_control(
			'tglNormalColor',
			[
				'label' => esc_html__( 'Icon Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-method-1 .tp-agegate-boxes .tp-agegate-method .age_vmb i,{{WRAPPER}} .tp-method-2 .tp-agegate-boxes .tp-agegate-method .age_verify_method_btnsubmit i,{{WRAPPER}} .tp-method-3 .tp-agegate-boxes .tp-agegate-method .tp-age-btn-yes i' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'tglicn_color_h',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_control(
			'tglHoverColor',
			[
				'label' => esc_html__( 'Icon Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-method-1 .tp-agegate-boxes:hover .tp-agegate-method .age_vmb i,{{WRAPPER}} .tp-method-2 .tp-agegate-boxes:hover .tp-agegate-method .age_verify_method_btnsubmit i,{{WRAPPER}} .tp-method-3 .tp-agegate-boxes:hover .tp-agegate-method .tp-age-btn-yes i' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
	    $this->end_controls_tabs();
        $this->end_controls_section();
        /*First button icon Style*/
        /*Second button Style*/
		$this->start_controls_section(
            'age_scndbtn_styling',
            [
                'label' => esc_html__('Second Button', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [					
					'age_verify_method' => 'method-3',
				],						
            ]
        );
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'sbtn_typo',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .tp-age-btn-no',
			]
		);       
		$this->add_responsive_control(
			'sbtn_padding',
			[
				'label' => esc_html__( 'Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .tp-age-btn-no' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],		
			]
		);
		$this->add_responsive_control(
			'sbtn_margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .tp-age-btn-no' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->start_controls_tabs( 'age_scndbtn_tab' );
		$this->start_controls_tab(
			'sbtn_n',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_control(
            'sbtn_color',
            [
                'label' => esc_html__('Text Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .tp-age-btn-no' => 'color:{{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'sbtn_background',
				'label' => esc_html__( 'Background Type', 'tpebl' ),
			    'types' => [ 'classic', 'gradient' ],
			    'selector' => '{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .tp-age-btn-no',
			]
		);		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'sbtn_border',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .tp-age-btn-no',
			]
		);
		$this->add_responsive_control(
			'sbtn_bradius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .tp-age-btn-no' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',				
				],	
				'separator' => 'after',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'sbtn_Shadow',
				'label' => esc_html__( 'Box Shadow', 'tpebl' ),
				'selector' => '{{WRAPPER}} .tp-agegate-boxes .tp-agegate-method .tp-age-btn-no',	
			]
		);	
		$this->end_controls_tab();
		$this->start_controls_tab(
			'sbtn_h',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_control(
            'sbtn_color_h',
            [
                'label' => esc_html__('Text Color', 'tpebl'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .tp-age-btn-no' => 'color:{{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'sbtn_background_h',
				'label' => esc_html__( 'Background Type', 'tpebl' ),
			    'types' => [ 'classic', 'gradient' ],
			    'selector' => '{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .tp-age-btn-no',   
			]
		);		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'sbtn_border_h',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .tp-age-btn-no',
			]
		);
		$this->add_responsive_control(
			'sbtn_bradius_h',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .tp-age-btn-no' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',				
				],	
				'separator' => 'after',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'sbtn_Shadow_h',
				'label' => esc_html__( 'Box Shadow', 'tpebl' ),
				'selector' => '{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-method .tp-age-btn-no',
			]
		);	
		$this->end_controls_tab();
		$this->end_controls_tabs();
        $this->end_controls_section();
        /*Second button Style*/
        /*Second button icon Style*/
		$this->start_controls_section(
            'scndBtn_icn_styling',
            [
                'label' => esc_html__('Second Button Icon', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,	
                'condition' => [
					'age_verify_method' => 'method-3',
					'second_icon_action' => 'yes',
				],					
            ]
        );
        $this->add_responsive_control(
            'scndBtn_icn_size',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Icon Size', 'tpebl'),
				'size_units' => [ 'px'],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
						'step' => 1,
					],
				],				
				'render_type' => 'ui',				
				'selectors' => [
					'{{WRAPPER}} .tp-method-3 .tp-agegate-boxes .tp-agegate-method .tp-age-btn-no i' => 'font-size: {{SIZE}}{{UNIT}}',
				],
            ]
        );
		$this->add_responsive_control(
            'scndBtn_icn_space',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Offset', 'tpebl'),
				'size_units' => [ 'px','%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
					'%' => [
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
				'selectors' => [
					'{{WRAPPER}} .tp-method-3 .tp-agegate-boxes .tp-agegate-method .tp-age-btn-no i' => 'margin-right: {{SIZE}}{{UNIT}}',
				],
				'condition'    => [
				 	'second_icon_position' => [ 'age_scnd_icon_postfix' ],
				 ],				
            ]
        );
		$this->add_responsive_control(
            'scndBtn_icn_space_left',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Offset', 'tpebl'),
				'size_units' => [ 'px','%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					],
					'%' => [
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
				'selectors' => [
					'{{WRAPPER}} .tp-method-3 .tp-agegate-boxes .tp-agegate-method .tp-age-btn-no i' => 'margin-left: {{SIZE}}{{UNIT}}',
				],
				 'condition'    => [
				 	'second_icon_position' => [ 'age_scnd_icon_prefix' ],
				],
            ]
        );
        $this->add_responsive_control(
			'scndBtn_margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .tp-method-3 .tp-agegate-boxes .tp-agegate-method .tp-age-btn-no i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
        $this->start_controls_tabs( 'scndBtn_icon_color' );
		$this->start_controls_tab(
			'scndBtnicn_color_n',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_control(
			'scndBtnNormalColor',
			[
				'label' => esc_html__( 'Icon Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-method-3 .tp-agegate-boxes .tp-agegate-method .tp-age-btn-no i' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'scndBtnicn_color_h',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_control(
			'scndBtnHoverColor',
			[
				'label' => esc_html__( 'Icon Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-method-3 .tp-agegate-boxes:hover .tp-agegate-method .tp-age-btn-no i' => 'color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();
	    $this->end_controls_tabs();
        $this->end_controls_section();
        /*Second button icon Style*/
        /*Extra info Style*/
		$this->start_controls_section(
            'age_einfo_styling',
            [
                'label' => esc_html__('Extra Info', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                	'age_extra_info_switch' => 'yes',
				],					
            ]
        );
       $this->add_responsive_control(
            'einfo_Size',
            [
                'type' => Controls_Manager::SLIDER,
				'label' => esc_html__('Text Size', 'tpebl'),
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 500,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 25,
				],				
				'render_type' => 'ui',
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-agegate-extra-info' => 'font-size: {{SIZE}}{{UNIT}}',
				],
            ]
        );       
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'info_typo',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tp-agegate-boxes .tp-agegate-extra-info',
				 'separator' => 'before',	
			]
		);
		$this->add_responsive_control(
			'info_padding',
			[
				'label' => esc_html__( 'Padding', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-agegate-extra-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		$this->add_responsive_control(
			'info_margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-agegate-extra-info' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',		
			]
		);
		$this->start_controls_tabs( 'age_einfo_color' );
		$this->start_controls_tab(
			'einfo_color_n',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_control(
			'einfoNmlColor',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-agegate-extra-info' => 'color: {{VALUE}};',
				],				
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'einfo_color_h',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),	
			]
		);
		$this->add_control(
			'einfoHvrColor',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes:hover .tp-agegate-extra-info' => 'color: {{VALUE}};',
				],	
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();	
        $this->end_controls_section();
        /*Extra info Style*/
        /*Error Message Style*/
		$this->start_controls_section(
            'age_message_styling',
            [
                'label' => esc_html__('Error Message', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'age_verify_method' => ['method-2','method-3'],
				],
            ]
        );
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'msg_typo',
				'label' => esc_html__( 'Typography', 'tpebl' ),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .tp-agegate-boxes .tp-age-wm',	
			]
		);
		$this->add_responsive_control(
			'msg_padding',
			[
				'label'      => esc_html__( 'Padding', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-age-wm' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],				
			]
		);
		$this->add_responsive_control(
			'msg_margin',
			[
				'label' => esc_html__( 'Margin', 'tpebl' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em'],				
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-age-wm' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',		
			]
		);
		 $this->start_controls_tabs( 'age_msg_color' );
		$this->start_controls_tab(
			'msg_color_n',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),	
			]
		);
		$this->add_control(
			'msgNmlColor',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-age-wm' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'msgNmlBG',
				'label' => esc_html__( 'Background Type', 'tpebl' ),
			    'types' => [ 'classic', 'gradient' ],
			    'selector' => '{{WRAPPER}} .tp-agegate-boxes .tp-age-wm', 
			]
		);
		 $this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'msgNmlBorder',
					'label' => esc_html__( 'Border', 'tpebl' ),
					'selector' => '{{WRAPPER}} .tp-agegate-boxes .tp-age-wm',
				]
	    );
		$this->add_responsive_control(
			'msgNmlBRadius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-agegate-boxes .tp-age-wm' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'msgNmlShadow',
				'label' => esc_html__( 'Box Shadow', 'tpebl' ),
				'selector' => '{{WRAPPER}} .tp-agegate-boxes .tp-age-wm',
			]
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'msg_color_h',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),				
			]
		);
		$this->add_control(
			'msgHvrColor',
			[
				'label' => esc_html__( 'Color', 'tpebl' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-boxes:hover .tp-age-wm' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
			   'name' => 'msgHvrBG',
			   'label' => esc_html__( 'Background Type', 'tpebl' ),
			   'types' => [ 'classic', 'gradient' ],
			   'selector' => '{{WRAPPER}} .tp-agegate-boxes:hover .tp-age-wm',
			]
		);
		 $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'msgHvrBorder',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} .tp-agegate-boxes:hover .tp-age-wm',	
			]
	    );
		$this->add_responsive_control(
			'msgHvrBRadius',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-agegate-boxes:hover .tp-age-wm' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'msgHvrShadow',
				'label' => esc_html__( 'Box Shadow', 'tpebl' ),
				'selector' => '{{WRAPPER}} .tp-agegate-boxes:hover .tp-age-wm',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();	
        $this->end_controls_section();
        /*Error Message Style*/		
		/*Box Bg Style*/
		$this->start_controls_section(
            'age_box_styling',
            [
                'label' => esc_html__('Box', 'tpebl'),
                'tab' => Controls_Manager::TAB_STYLE,					
            ]
        );
        $this->add_control(
            'box_position',
            [
				'label' => esc_html__( 'Box Position', 'tpebl' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'default' => 'no',
			]
        );
        $this->add_responsive_control(
			'box_left_auto', [
				'label'   => esc_html__( 'Left (Auto)', 'tpebl' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'condition'    => [
					'box_position' => [ 'yes' ],
				],			
			]
		);
		$this->add_responsive_control(
			'box_pos_xposition', [
				'label' => esc_html__( 'Left', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px','%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'separator' => 'after',
				'condition'    => [
					'box_position' => [ 'yes' ],
					'box_left_auto' => [ 'yes' ],
				],
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-inner-wrapper' => 'margin-left: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'box_right_auto',[
				'label'   => esc_html__( 'Right (Auto)', 'tpebl' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
				'label_on' => esc_html__( 'Enable', 'tpebl' ),
				'label_off' => esc_html__( 'Disable', 'tpebl' ),
				'condition'    => [
					'box_position' => [ 'yes' ],
				],
			]
		);
		$this->add_responsive_control(
			'box_pos_rightposition',[
				'label' => esc_html__( 'Right', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px','%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'condition'    => [
					'box_position' => [ 'yes' ],
					'box_right_auto' => [ 'yes' ],
				],
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-inner-wrapper' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_responsive_control(
			'box_width',
			[
				'label' => esc_html__( 'Box Width', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'separator' => 'before',
				'size_units' => ['px','%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 500,
				],
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-inner-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'box_height',
			[
				'label' => esc_html__( 'Box Height', 'tpebl' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px','%'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 400,
				],
				'selectors' => [
					'{{WRAPPER}} .tp-agegate-inner-wrapper' => 'min-height: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);
		$this->start_controls_tabs( 'age_box_bgcolor' );
		$this->start_controls_tab(
			'box_bg_n',
			[
				'label' => esc_html__( 'Normal', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'box_backgroundNml',
				'label' => esc_html__( 'Background Type', 'tpebl' ),
			    'types' => [ 'classic', 'gradient' ],
			    'selector' => '{{WRAPPER}} .tp-agegate-inner-wrapper',				    
			]
		);		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'box_borderNml',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} .tp-agegate-inner-wrapper',
			]
		);
		$this->add_responsive_control(
			'box_bradiusNml',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-agegate-inner-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',				
				],	
				'separator' => 'after',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_ShadowNml',
				'label' => esc_html__( 'Box Shadow', 'tpebl' ),
				'selector' => '{{WRAPPER}} .tp-agegate-inner-wrapper',	
			]
		);	
		$this->end_controls_tab();
		$this->start_controls_tab(
			'box_bg_h',
			[
				'label' => esc_html__( 'Hover', 'tpebl' ),
			]
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'box_backgroundHvr',
				'label' => esc_html__( 'Background Type', 'tpebl' ),
			    'types' => [ 'classic', 'gradient' ],
			    'selector' => '{{WRAPPER}} .tp-agegate-inner-wrapper:hover',				    
			]
		);		
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'box_borderHvr',
				'label' => esc_html__( 'Border', 'tpebl' ),
				'selector' => '{{WRAPPER}} .tp-agegate-inner-wrapper:hover',
			]
		);
		$this->add_responsive_control(
			'box_bradiusHvr',
			[
				'label'      => esc_html__( 'Border Radius', 'tpebl' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .tp-agegate-inner-wrapper:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',				
				],	
				'separator' => 'after',
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_ShadowHvr',
				'label' => esc_html__( 'Box Shadow', 'tpebl' ),
				'selector' => '{{WRAPPER}} .tp-agegate-inner-wrapper:hover',
			]
		);
		$this->end_controls_tab();
		$this->end_controls_tabs();	
        $this->end_controls_section();
        /*Box Bg Style*/     	
	}

	protected function render() {
		$settings = $this->get_settings_for_display();			
		$age_icon_img_type = $settings['age_icon_img_type'];
		$age_gate_title = $settings['age_gate_title'];
		$age_gate_title_input = $settings['age_gate_title_input'];
		$age_gate_description = $settings['age_gate_description'];
		$age_gate_description_input = $settings['age_gate_description_input'];
		$age_gate_description_inputwo = $settings['age_gate_description_inputwo'];
		$age_gate_description_inputhree = $settings['age_gate_description_inputhree'];
		$age_extra_info_switch = $settings['age_extra_info_switch'];
		$age_extra_info = $settings['age_extra_info'];
		$age_gate_wrong_message = $settings['age_gate_wrong_message'];
		$age_side_image_show = $settings['age_side_image_show'];
		$chkinput_text = !empty($settings['chkinput_text']) ? $settings['chkinput_text'] : '';
		$button_text = !empty($settings['button_text']) ? $settings['button_text'] : '';	 
		$icon_position=!empty($settings['icon_position']) ? $settings['icon_position'] : 'age_icon_prefix';
		$second_button_text = !empty($settings['second_button_text']) ? $settings['second_button_text'] : '';	
		$second_icon_position=!empty($settings['second_icon_position']) ? $settings['second_icon_position'] : 'age_scnd_icon_prefix';	 

		$button_icon=$second_button_icon=$right_img_class=$bg_image_main_wrapper=$data_attr=$lazybgclass1='';		
		if(!empty($age_side_image_show) && $age_side_image_show=='yes'){
			$right_img_class = 'tp-equ-width-50';
		}				
		if(!empty($settings['age_sec_bg_image_switch']) && $settings['age_sec_bg_image_switch']=='yes' && !empty($settings['age_sec_bg_image']['url'])){
			if(tp_has_lazyload()){			
				$lazybgclass1 =' lazy-background';
			}
			$bg_image_main_wrapper = 'style="background-image:url('.$settings['age_sec_bg_image']['url'].');background-size:cover;   background-attachment:inherit;background-position:center center;"';
		}		
		$age_cookies_days = !empty($settings['age_cookies_days']) ? $settings['age_cookies_days'] : '10';					 
		if(!empty($settings['age_cookies']) && $settings['age_cookies']=='yes' && !empty($age_cookies_days)){	
			$data_attr .='data-age_cookies_days="'.$age_cookies_days.'"';
		}		
		if(!empty($settings['age_verify_method']) && $settings['age_verify_method']=='method-2'){
			$birthyears = !empty($settings['birthyears']) ? $settings['birthyears'] : '18';
			$data_attr .=' data-userbirth="'.$birthyears.'"';
		}
		if((\Elementor\Plugin::$instance->editor->is_edit_mode()) && $settings["backend_preview"] != 'yes'){
			$output ='<h3 class="theplus-posts-not-found">'.esc_html__( "Note : You may use this widget on Header or Footer Template directly. It will load it on all pages throughout the website.", "theplus" ).'</h3>';
		}else{
			$output ='<div class="tp-agegate-wrapper '.$lazybgclass1.' tp-'.$settings['age_verify_method'].'" '.$bg_image_main_wrapper.' '.$data_attr.'>';
				$output .='<div class="tp-agegate-inner-wrapper">';
						$output .='<div class="tp-agegate-boxes '.$right_img_class.'">';
						   if(!empty($age_gate_wrong_message)){
								$output .= '<div class="tp-age-wm">'.$age_gate_wrong_message.'</div>';
							}
							if(!empty($age_icon_img_type) && $age_icon_img_type=='yes' && !empty($settings['age_head_img']['url'])){
									$image_id=$settings["age_head_img"]["id"];
									if(!empty($image_id)){
										$imgSrc= tp_get_image_rander( $image_id,'full', [ 'class' => 'tp-agegate-image' ] );
										$output .= '<div class="tp-age-ii">'.$imgSrc.'</div>';
									}else{
										$output .= '<div class="tp-age-ii"><img src='.$settings['age_head_img']['url'].' class="tp-agegate-image"></div>';
									}
									
							}
							if(!empty($age_gate_title) && $age_gate_title=='yes' && !empty($age_gate_title_input)){
								$output .= '<div class="tp-agegate-title">'.$age_gate_title_input.'</div>';
							}
							if(!empty($settings['age_verify_method'])){
								$Method_With_Desc='';
								if($settings['age_verify_method']=='method-1' && !empty($age_gate_description) && $age_gate_description=='yes' && !empty($age_gate_description_input)){
									$Method_With_Desc = $age_gate_description_input;
								}
								if($settings['age_verify_method']=='method-2' && !empty($age_gate_description) && $age_gate_description=='yes' && !empty($age_gate_description_inputwo)){
									$Method_With_Desc = $age_gate_description_inputwo;
								}
								if($settings['age_verify_method']=='method-3' && !empty($age_gate_description) && $age_gate_description=='yes' && !empty($age_gate_description_inputhree)){
									$Method_With_Desc = $age_gate_description_inputhree;
								}
							}
							if(!empty($Method_With_Desc)){
								$output .= '<div class="tp-agegate-description">'.$Method_With_Desc.'</div>';
							}							
							$output .='<div class="tp-agegate-method">';
								if(!empty($settings['age_verify_method'])){
									if($settings['age_verify_method']=='method-1'){
										$content_icon_before=$content_icon_after='';
										if (!empty($settings['icon_action']) && $settings['icon_action']=='yes'){
											if(!empty($settings["button_icon"])){
												ob_start();
												\Elementor\Icons_Manager::render_icon( $settings["button_icon"], [ 'aria-hidden' => 'true' ]);
												$button_icon = ob_get_contents();
												ob_end_clean();						
											}
										    if(!empty($icon_position) && $icon_position=='age_icon_prefix'){
											  $content_icon_before = $button_icon;                
										    }else if(!empty($icon_position) && $icon_position=='age_icon_postfix'){
											  $content_icon_after = $button_icon;                  
										    }
										}
										$output .='<div class="agc_checkbox">';
											$output .='<label for="age_vmc"><input type="checkbox" class="age_vmc" name="agc_check" id="age_vmc"><span class="tp-age-checkmark"></span>'.esc_html($chkinput_text).'</label>';
										$output .='</div>';
										$output .='<div class="age_vms">';
											$output .='<button type="submit" class="age_vmb tp-age-btn-ex" style="opacity:0.5;" >'.$content_icon_before.''.esc_html($button_text).''.$content_icon_after.'</button>';
										$output .='</div>';
									}									
									if($settings['age_verify_method']=='method-2'){
									    $content_icon_before=$content_icon_after='';
										if (!empty($settings['icon_action']) && $settings['icon_action']=='yes'){
											if(!empty($settings["button_icon"])){
												ob_start();
												\Elementor\Icons_Manager::render_icon( $settings["button_icon"], [ 'aria-hidden' => 'true' ]);
												$button_icon = ob_get_contents();
												ob_end_clean();						
											}
										    if(!empty($icon_position) && $icon_position=='age_icon_prefix'){
											 $content_icon_before = $button_icon;                
										    }else if(!empty($icon_position) && $icon_position=='age_icon_postfix'){
											  $content_icon_after = $button_icon;
										    }
										}
										$output .='<input type="date" class="age_verify_birthdate" name="age_birth" value="'.date('Y-m-d').'">';
										$output .='<button type="submit" class="age_verify_method_btnsubmit tp-age-btn-ex">'.$content_icon_before.''.esc_html($button_text).''.$content_icon_after.'</button>';
									}
									if($settings['age_verify_method']=='method-3'){
									    $content_icon_before=$content_icon_after='';
									    if (!empty($settings['icon_action']) && $settings['icon_action']=='yes'){
											if(!empty($settings["button_icon"])){
												ob_start();
												\Elementor\Icons_Manager::render_icon( $settings["button_icon"], [ 'aria-hidden' => 'true' ]);
												$button_icon = ob_get_contents();
												ob_end_clean();						
											}
										    if(!empty($icon_position) && $icon_position=='age_icon_prefix'){
											  $content_icon_before = $button_icon;                
										    }else if(!empty($icon_position) && $icon_position=='age_icon_postfix'){
											  $content_icon_after = $button_icon;                  
										    }
										}									
										$output .='<button type="submit" class="tp-age-btn-yes tp-age-btn-ex" name="tp-age-btn-yes"  >'.$content_icon_before.''.esc_html($button_text).''.$content_icon_after.'</button>';
										$content_scnd_icon_before=$content_scnd_icon_after='';
									    if (!empty($settings['second_icon_action']) && $settings['second_icon_action']=='yes'){
											if(!empty($settings["second_button_icon"])){
												ob_start();
												\Elementor\Icons_Manager::render_icon( $settings["second_button_icon"], [ 'aria-hidden' => 'true' ]);
												$second_button_icon = ob_get_contents();
												ob_end_clean();						
											}
										    if(!empty($second_icon_position) && $second_icon_position=='age_scnd_icon_prefix'){
											  $content_scnd_icon_before = $second_button_icon;
										    }else if(!empty($second_icon_position) && $second_icon_position=='age_scnd_icon_postfix'){
											  $content_scnd_icon_after = $second_button_icon;
										    }
										}
										$output .='<button type="submit" class="tp-age-btn-no tp-age-btn-ex" name="tp-age-btn-no">'.$content_scnd_icon_before.''.esc_html($second_button_text).''.$content_scnd_icon_after.'</button>';
									}
								}
							$output .='</div>';
							if(!empty($age_extra_info_switch) && $age_extra_info_switch=='yes' && !empty($age_extra_info)){
								$output .= '<div class="tp-agegate-extra-info">'.$age_extra_info.'</div>';
							}
						$output .='</div>';
						if(!empty($age_side_image_show) && $age_side_image_show=='yes' && !empty($settings['age_side_img']['url'])){
							$lazybgclass='';
							if(tp_has_lazyload()){			
								$lazybgclass =' lazy-background';
							}
							$output .='<div class="tp-agegate-boxes '.$lazybgclass.' '.$right_img_class.'" style="background-image:url('.$settings['age_side_img']['url'].');background-size:cover;   background-attachment:inherit;">';
							$output .='</div>';
						}				
				$output .='</div>';
			$output .='</div>';
		}
		echo $output;		
	}
    protected function content_template() {
		
	}
}