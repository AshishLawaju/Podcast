<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.


class Widget_SecondlineElementsShowCarousel extends Widget_Base {

	public function get_name() {
		return 'secondline-show-carousel';
	}

	public function get_title() {
		return esc_html__( 'SecondLine - Show Carousel', 'secondline-custom-plugin' );
	}

	public function get_icon() {
		return 'fa fa-clone secondline-themes-secondline-show';
	}

   public function get_categories() {
		return [ 'basic' ];
	}
	
	
	function Widget_SeconelineElementsShowCarousel($widget_instance){
		
	}
	
	protected function _register_controls() {

		
  		$this->start_controls_section(
  			'section_title_global_options',
  			[
  				'label' => esc_html__( 'Show Carousel Settings', 'secondline-custom-plugin' )
  			]
  		);
		
		
		
		$this->add_control(
			'secondline_main_show_count',
			[
				'label' => esc_html__( 'Show Count', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '6',
			]
		);
		
		$this->add_responsive_control(
			'secondline_elements_image_grid_column_count',
			[
  				'label' => esc_html__( 'Columns', 'secondline-custom-plugin' ),
				'label_block' => true,
				'type' => Controls_Manager::SELECT,				
				'desktop_default' => '25%',
				'tablet_default' => '50%',
				'mobile_default' => '100%',
				'options' => [
					'50%' => esc_html__( '2 Columns', 'secondline-custom-plugin' ),
					'33.330%' => esc_html__( '3 Columns', 'secondline-custom-plugin' ),
					'25%' => esc_html__( '4 Columns', 'secondline-custom-plugin' ),
					'20%' => esc_html__( '5 Columns', 'secondline-custom-plugin' ),
					'16.67%' => esc_html__( '6 Columns', 'secondline-custom-plugin' ),
				],
				'selectors' => [
					'{{WRAPPER}} .secondline-carousel-item' => 'width: {{VALUE}};',
				],
				'render_type' => 'template'
			]
		);
		
		
  		$this->add_responsive_control(
  			'secondline_elements_image_grid_margin',
  			[
  				'label' => esc_html__( 'Margin', 'secondline-custom-plugin' ),
  				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .secondline-carousel-margins' => 'margin-left:-{{SIZE}}px; margin-right:-{{SIZE}}px;',
					'{{WRAPPER}} .secondline-carousel-padding-blog' => 'padding: {{SIZE}}px;',
				],
				'render_type' => 'template'
  			]
  		);			
		
		$this->add_control(
			'secondline_elements_show_carousel_bullets',
			[
				'label' => esc_html__( 'Bullets Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);		

		$this->add_control(
			'secondline_elements_show_carousel_arrows',
			[
				'label' => esc_html__( 'Arrows Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);	
		
		$this->add_control(
			'secondline_elements_show_carousel_draggable',
			[
				'label' => esc_html__( 'Draggable Carousel', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);	
		
		$this->add_control(
			'secondline_elements_show_carousel_autoplay',
			[
				'label' => esc_html__( 'Auto Scroll Carousel', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'no',
			]
		);			

		$this->add_control(
			'secondline_elements_show_carousel_height',
			[
				'label' => esc_html__( 'Match Items Height', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);					
		
		$this->add_control(
			'slt_excerpt_length',
			[
				'label' => esc_html__( 'Exerpt Character Limit', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '60',
			]
		);		


		$this->add_control(
			'slt_read_more_txt',
			[
				'label' => esc_html__( 'Read More Text', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Read More',
			]
		);	


		$this->add_control(
			'slt_read_more_icon',
			[
				'label' => esc_html__( 'Read More Icon', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::ICON,
				'label_block' => true,
			]
		);		

		
		
		$this->end_controls_section();
		
		
  		$this->start_controls_section(
  			'section_title_layout_options',
  			[
  				'label' => esc_html__( 'Show Layout', 'secondline-custom-plugin' )
  			]
  		);
		
				
		$this->add_control(
			'secondline_elements_image_transparency_hover',
			[
				'label' => esc_html__( 'Image Transparency on Hover	', 'slt-elements-secondline' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1,
						'step' => 0.01,
					],
				],
				'default' => [
					'size' => '1',
				],
				'selectors' => [
					'{{WRAPPER}} .secondline-themes-default-blog-overlay:hover a img' => 'opacity: {{SIZE}};',
					'{{WRAPPER}} .secondline-themes-feaured-image:hover a img' => 'opacity: {{SIZE}};',
				],
			]
		);
		
		$this->add_control(
			'secondline_elements_show_image_overlay',
			[
				'label' => esc_html__( 'Image Color Overlay', 'slt-elements-secondline' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-themes-feaured-image:before' => 'background-color: {{VALUE}}; display: block',
				],
			]
		);		
		
		$this->add_control(
			'secondline_elements_image_background_color',
			[
				'label' => esc_html__( 'Show Image Background Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-themes-feaured-image' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .secondline-themes-default-blog-overlay' => 'background-color: {{VALUE}}',
				],
			]
		);
			
		

		$this->add_control(
			'secondline_elements_show_carousel_title',
			[
				'label' => esc_html__( 'Title Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		
		
		
		$this->add_control(
			'secondline_elements_show_carousel_cat',
			[
				'label' => esc_html__( 'Category Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => '',
			]
		);
		
		$this->add_control(
			'secondline_elements_show_carousel_show_host',
			[
				'label' => esc_html__( 'Show Host Name Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'secondline_elements_show_carousel_show_host_img',
			[
				'label' => esc_html__( 'Show Host Image Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);		
		

				
		$this->add_control(
			'secondline_elements_show_carousel_excerpt',
			[
				'label' => esc_html__( 'Excerpt Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);		
		
		$this->add_control(
			'secondline_elements_show_carousel_read_more',
			[
				'label' => esc_html__( 'Read More Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);		
	
		$this->add_control(
			'secondline_elements_show_carousel_content',
			[
				'label' => esc_html__( 'Content Area Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);			

		
		$this->end_controls_section();
		
		
  		$this->start_controls_section(
  			'section_title_secondary_options',
  			[
  				'label' => esc_html__( 'Show Query', 'secondline-custom-plugin' )
  			]
  		);
											
		
		$this->add_control(
			'secondline_show_category',
			[
				'label' => esc_html__( 'Narrow by Show Category', 'secondline-custom-plugin' ),
				'description' => esc_html__( 'Enter category slugs to display a specific category. Add-in multiple category slugs seperated by a comma to use multiple categories. ', 'secondline-custom-plugin' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
			]
		);
		
		$this->add_control(
			'secondline_elements_show_order_sorting',
			[
				'label' => esc_html__( 'Order By', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date' => esc_html__( 'Default - Date', 'secondline-custom-plugin' ),
					'title' => esc_html__( 'Show Title', 'secondline-custom-plugin' ),
					'menu_order' => esc_html__( 'Menu Order', 'secondline-custom-plugin' ),
					'modified' => esc_html__( 'Last Modified', 'secondline-custom-plugin' ),
					'comment_count' => esc_html__( 'Comment Count', 'secondline-custom-plugin' ),
					'rand' => esc_html__( 'Random', 'secondline-custom-plugin' ),
				],
			]
		);
		
		
		$this->add_control(
			'secondline_elements_show_order',
			[
				'label' => esc_html__( 'Order', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'DESC',
				'options' => [
					'ASC' => esc_html__( 'Ascending', 'secondline-custom-plugin' ),
					'DESC' => esc_html__( 'Descending', 'secondline-custom-plugin' ),
				],
			]
		);
		
		
		$this->add_control(
			'secondline_main_offset_count',
			[
				'label' => esc_html__( 'Offset Count', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '0',
				'description' => esc_html__( 'Use this to skip shows (Example: Insert 5 to skip the first 5 shows.)', 'secondline-custom-plugin' ),
			]
		);		

		
		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'secondline_elements_section_main_styles',
			[
				'label' => esc_html__( 'Main Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		
		
		$this->add_control(
			'secondline_elements_main_bg_color',
			[
				'label' => esc_html__( 'Main Background Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-show-content, {{WRAPPER}} .secondline-carousel-padding-blog .secondline-themes-default-blog-index' => 'background-color: {{VALUE}}',
				],
			]
		);
		
		
		$this->add_control(
			'secondline_elements_main_border_color',
			[
				'label' => esc_html__( 'Main Border Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-show-content, {{WRAPPER}} .secondline-themes-default-blog-index' => 'border-color: {{VALUE}}',
				],
			]
		);
		
		$this->add_responsive_control(
			'secondline_elements_content_padding',
			[
				'label' => esc_html__( 'Content Padding', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .secondline-show-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		
		$this->end_controls_section();
		
			
		
		$this->start_controls_section(
			'section_styles_title_styles',
			[
				'label' => esc_html__( 'Title Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		
		$this->add_control(
			'secondline_elements_title_styles_color',
			[
				'label' => esc_html__( 'Title Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} h2.secondline-show-title' => 'color: {{VALUE}}',
					'{{WRAPPER}} h2.secondline-show-title a' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_control(
			'secondline_elements_title_styles_hover_color',
			[
				'label' => esc_html__( 'Title Hover Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} h2.secondline-show-title a:hover' => 'color: {{VALUE}}',
				],
			]
		);
		

		
		$this->add_responsive_control(
			'secondline_elements_title_margin',
			[
				'label' => esc_html__( 'Title Margin', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} h2.secondline-show-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'secondline_elements_title_typography',
				'label' => esc_html__( 'Typography', 'secondline-custom-plugin' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} h2.secondline-show-title a',
			]
		);
		
		
		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'section_styles_author_styles',
			[
				'label' => esc_html__( 'Show Host Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		
		$this->add_control(
			'secondline_elements_author_styles_color',
			[
				'label' => esc_html__( 'Show Host Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} span.show-meta-names' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_responsive_control(
			'secondline_elements_author_margin',
			[
				'label' => esc_html__( 'Show Host Margin', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .show-host-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'secondline_elements_author_typography',
				'label' => esc_html__( 'Typography', 'secondline-custom-plugin' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} span.show-meta-names',
			]
		);
		
		
		$this->end_controls_section();
		
		
		$this->start_controls_section(
			'section_styles_category_styles',
			[
				'label' => esc_html__( 'Category Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		
		$this->add_control(
			'secondline_elements_category_styles_color',
			[
				'label' => esc_html__( 'Category Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .show-category-list div' => 'color: {{VALUE}}',
				],
			]
		);
		
		
		
		$this->add_responsive_control(
			'secondline_elements_category_margin',
			[
				'label' => esc_html__( 'Category Margin', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .show-category-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'secondline_elements_category_typography',
				'label' => esc_html__( 'Typography', 'secondline-custom-plugin' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .show-category-list div',
			]
		);
		
		
		$this->end_controls_section();		
		
		
		$this->start_controls_section(
			'section_styles_comment_styles',
			[
				'label' => esc_html__( 'Excerpt Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		
		$this->add_control(
			'secondline_elements_comment_styles_color',
			[
				'label' => esc_html__( 'Excerpt Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-themes-blog-excerpt' => 'color: {{VALUE}}',
					'{{WRAPPER}} .secondline-themes-blog-excerpt a' => 'color: {{VALUE}}',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'secondline_elements_comment_typography',
				'label' => esc_html__( 'Typography', 'secondline-custom-plugin' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .secondline-themes-blog-excerpt',
			]
		);
		
		
		$this->add_responsive_control(
			'secondline_elements_excerpt_padding',
			[
				'label' => esc_html__( 'Excerpt Padding', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .secondline-themes-blog-excerpt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);		
		
		
		
		
		$this->end_controls_section();
		
		
		
		$this->start_controls_section(
			'section_styles_more_link_styles',
			[
				'label' => esc_html__( 'Read More Styles', 'secondline-custom-plugin' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		
		$this->add_control(
			'section_styles_more_link_styles_color',
			[
				'label' => esc_html__( 'Read More Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-carousel-padding-blog a.more-link' => 'color: {{VALUE}}',					
				],
			]
		);
		
		$this->add_control(
			'section_styles_more_link_styles_border',
			[
				'label' => esc_html__( 'Read More Border Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-carousel-padding-blog a.more-link' => 'border-color: {{VALUE}}',					
				],
			]
		);

		$this->add_control(
			'section_styles_more_link_styles_hover',
			[
				'label' => esc_html__( 'Read More Hover Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-carousel-padding-blog a.more-link:hover' => 'color: {{VALUE}}',					
				],
			]
		);				
		
		$this->add_control(
			'section_styles_more_link_styles_hover_border',
			[
				'label' => esc_html__( 'Read More Hover Background Color', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .secondline-carousel-padding-blog a.more-link:hover' => 'background-color: {{VALUE}}',					
					'{{WRAPPER}} a.more-link:hover' => 'border-color: {{VALUE}}',					
				],
			]
		);			
		
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'section_styles_more_link_styles_typography',
				'label' => esc_html__( 'Typography', 'secondline-custom-plugin' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .secondline-carousel-padding-blog a.more-link',
			]
		);
		
		
		$this->end_controls_section();			
		
		
		
	}
	

	protected function render( ) {
		
      $settings = $this->get_settings();


	global $blogloop;
	global $post;
	
	if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } else if ( get_query_var('page') ) {   $paged = get_query_var('page'); } else {  $paged = 1; }
	

	$post_per_page = $settings['secondline_main_show_count'];	
	$offset = $settings['secondline_main_offset_count'];
	$offset_new = $offset + (( $paged - 1 ) * $post_per_page);
	
	if ( ! empty( $settings['secondline_show_category'] ) ) {
	 	$catpostIds = $settings['secondline_show_category']; // get custom field value
	     $catarrayIds = explode(',', $catpostIds); // explode value into an array of ids
	     if(count($catarrayIds) <= 1) // if array contains one element or less, there's spaces after comma's, or you only entered one id
	     {
	         if( strpos($catarrayIds[0], ',') !== false )// if the first array value has commas, there were spaces after ids entered
	         {
	             $catarrayIds = array(); // reset array
	             $catarrayIds = explode(', ', $catpostIds); // explode ids with space after comma's
	         }
	 	 }
		 $operatorcat = 'IN';
 	} else {

	 		$catarrayIds = '';
			$operatorcat = 'NOT IN';					
 	}
	

			
	$args = array(
			'post_type'         => 'secondline_shows',
			  'orderby'         => $settings['secondline_elements_show_order_sorting'],
			  'order'         => $settings['secondline_elements_show_order'],
			  'ignore_sticky_posts' => 1,
			  'posts_per_page'     =>  $post_per_page,
			  'paged' => $paged,
			  'offset' => $offset_new,
			  'tax_query' => array(
				  'relation' => 'AND',
				array(
					'taxonomy' => 'show_category',
					'field'    => 'slug',
					'terms'    => $catarrayIds,
						'operator' => $operatorcat
				),
			  ),
	);

	

	$blogloop = new \WP_Query( $args );
	?>
	


	<div class="secondline-themes-show-carousel-main">
		
		<div class="secondline-carousel-margins">
			<div id="secondline-blog-index-carousel-<?php echo esc_attr($this->get_id()); ?>">
				
				<?php while($blogloop->have_posts()): $blogloop->the_post();?>
				<div class="secondline-carousel-item">
					<div class="secondline-carousel-padding-blog">
							<?php include(locate_template('template-parts/elementor/content-carousel.php')); ?>
					</div>
				</div>
				<?php endwhile; ?>
				
				
			</div>
		</div>
				
		
		
		<div class="clearfix-slt"></div>
		

		
		
	</div><!-- close .secondline-themes-show-carousel-main -->
	
	<script type="text/javascript"> 
	jQuery(document).ready(function($) {
		'use strict';		
		$("#secondline-blog-index-carousel-<?php echo esc_attr($this->get_id()); ?>").flickity({
		  // options
		  imagesLoaded: true,
		  cellSelector: '.secondline-carousel-item',		  
		  cellAlign: 'left',
		  <?php if($settings['secondline_elements_show_carousel_bullets'] != 'yes' ): ?>pageDots: false,<?php endif ?>
		  <?php if($settings['secondline_elements_show_carousel_arrows'] != 'yes' ): ?>prevNextButtons: false,<?php endif ?>
		  <?php if($settings['secondline_elements_show_carousel_draggable'] != 'yes' ): ?>draggable: false,<?php endif ?>		  
		  <?php if($settings['secondline_elements_show_carousel_autoplay'] == 'yes' ): ?>autoPlay: 2500,<?php endif ?>
		  freeScroll: true,
		  wrapAround: true,
		  contain: true
		});	
		
	
		$(".secondline-themes-show-carousel-main").css("opacity", "1");
		
		<?php if($settings['secondline_elements_show_carousel_height'] == 'yes' ): ?>
		$('#secondline-blog-index-carousel-<?php echo esc_attr($this->get_id()); ?>').each(function() {			
			$( this ).find(".secondline-themes-default-blog-index").matchHeight({byRow: false,});
		});
		<?php endif; ?>	
		
	});
	</script>


	<?php wp_reset_postdata();?>
	

	<?php
	
	}

	protected function content_template(){}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_SecondlineElementsShowCarousel() );