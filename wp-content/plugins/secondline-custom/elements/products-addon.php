<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.


class Widget_SecondLineAddonsWooProducts extends Widget_Base {

	public function get_name() {
		return 'secondline-addons-woo-product-list';
	}

	public function get_title() {
		return esc_html__( 'SecondLine - Products', 'secondline-custom-plugin' );
	}

	public function get_icon() {
		return 'eicon-woocommerce secondline-addons-icon secondline-themes-secondline-episode';
	}

   public function get_categories() {
		return [ 'general' ];
	}
	
	protected function _register_controls() {

		
  		$this->start_controls_section(
  			'section_title_secondline_global_options',
  			[
  				'label' => esc_html__( 'Product', 'secondline-custom-plugin' )
  			]
  		);
		
		$this->add_control(
			'secondline_woo_product_filter',
			[
				'label' => esc_html__( 'Display', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'recent_products',
				'options' => [
					'recent_products' => esc_html__( 'Products', 'secondline-custom-plugin' ),
					'featured_products' => esc_html__( 'Feaured Products', 'secondline-custom-plugin' ),
					'sale_products' => esc_html__( 'On Sale Products', 'secondline-custom-plugin' ),
					'best_selling_products' => esc_html__( 'Best Selling Products', 'secondline-custom-plugin' ),
					'top_rated_products' => esc_html__( 'Top Rated Products', 'secondline-custom-plugin' ),
				],
			]
		);
		
		$this->add_control(
			'secondline_woo_columns',
			[
				'label' => esc_html__( 'Columns', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'options' => [
					'1' => esc_html__( '1 Column', 'secondline-custom-plugin' ),
					'2' => esc_html__( '2 Columns', 'secondline-custom-plugin' ),
					'3' => esc_html__( '3 Columns', 'secondline-custom-plugin' ),
					'4' => esc_html__( '4 Columns', 'secondline-custom-plugin' ),
					'5' => esc_html__( '5 Columns', 'secondline-custom-plugin' ),
					'6' => esc_html__( '6 Columns', 'secondline-custom-plugin' ),
				],
			]
		);
		
		$this->add_control(
			'secondline_woo_post_count',
			[
				'label' => esc_html__( 'Product Count', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '3',
			]
		);
		
		
		
		$this->add_control(
			'secondline_woo_order_by',
			[
				'label' => esc_html__( 'Order By', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'separator' => 'before',
				'options' => [
					'date' => esc_html__( 'Default - Date', 'secondline-custom-plugin' ),
					'title' => esc_html__( 'Post Title', 'secondline-custom-plugin' ),
					'menu_order' => esc_html__( 'Menu Order', 'secondline-custom-plugin' ),
					'rand' => esc_html__( 'Random', 'secondline-custom-plugin' ),
				],
			]
		);
		
		$this->add_control(
			'secondline_woo_order_asc_desc',
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
			'secondline_post_type_categories',
			[
				'label' => esc_html__( 'Product Categories', 'secondline-custom-plugin' ),
				'type' => Controls_Manager::SELECT2,
				'label_block' => true,
				'multiple' => true,
				'options' => secondline_addons_product_categories(),
			]
		);
		
		$this->end_controls_section();

		
	}


	protected function render( ) {
		
      $settings = $this->get_settings();
		
		$productcatarray = $settings['secondline_post_type_categories']; // get custom field value
		if($productcatarray >= 1 ) { 
			$productcatids = implode(', ', $productcatarray); 
		} else {
			$productcatids = '';
		}

	?>
	



	<div class="secondline-addons-woo-product-list-container">			
		<?php 
			$secondline_filter = esc_attr($settings['secondline_woo_product_filter'] );
			$secondline_cols = esc_attr($settings['secondline_woo_columns'] );
			$secondline_post_count = esc_attr($settings['secondline_woo_post_count'] );
			$secondline_orderby = esc_attr($settings['secondline_woo_order_by'] );
			$secondline_order_asc_desc = esc_attr($settings['secondline_woo_order_asc_desc'] );

			echo do_shortcode('[' . $secondline_filter . ' per_page="' . $secondline_post_count . '" columns="' . $secondline_cols . '" orderby="' . $secondline_orderby . '" order="' . $secondline_order_asc_desc . '" category="' . $productcatids . '"]');
		
		?>
	</div><!-- close .secondline-addons-woo-product-list-container -->
	
	
	<?php
	
	}

	protected function content_template(){}
}


Plugin::instance()->widgets_manager->register_widget_type( new Widget_SecondLineAddonsWooProducts() );