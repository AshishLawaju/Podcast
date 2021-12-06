<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package secondline
 */

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

function secondline_woocommerce_support() {
    add_theme_support( 'woocommerce', array(

        'product_grid'          => array(
            'default_rows'    => 2,
            'min_rows'        => 1,
            'max_rows'        => 6,
            'default_columns' => 2,
            'min_columns'     => 1,
            'max_columns'     => 5,
        ),
    ) );
}
add_action( 'after_setup_theme', 'secondline_woocommerce_support' );

add_theme_support( 'wc-product-gallery-slider' );

/**
 * Change number of related products output
 */
function woo_related_products_limit() {
  global $product;

	$args['posts_per_page'] = 3;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'secondline_themes_related_products_args' );
  function secondline_themes_related_products_args( $args ) {
	$args['posts_per_page'] = 3; // 4 related products
	$args['columns'] = 3; // arranged in 2 columns
	return $args;
}


/* Removing Close At end of Index */
if ( ! function_exists( 'woocommerce_template_loop_product_link_close' ) ) {
	/**
	 * Insert the opening anchor tag for products in the loop.
	 */
	function woocommerce_template_loop_product_link_close() {
		echo '';
	}
}


/* Closing Link before image and surrounding title with link */
if ( ! function_exists( 'woocommerce_template_loop_product_title' ) ) {

	/**
	 * Show the product title in the product loop. By default this is an H2.
	 */
	function woocommerce_template_loop_product_title() {
		global $product;

		$link_title = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

		echo '</a><div class="secondline-woocommerce-index-content-bg"><a href="' . esc_url( $link_title ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link"><h2 class="woocommerce-loop-product__title">' . get_the_title() . '</h2></a>';
	}

}

if ( ! function_exists( 'woocommerce_template_loop_category_title' ) ) {

	/**
	 * Show the subcategory title in the product loop.
	 *
	 * @param object $category Category object.
	 */
	function woocommerce_template_loop_category_title( $category ) {
		?>
		</a>
		<div class="secondline-woocommerce-index-content-bg">
		<?php echo '<a href="' . esc_url( get_term_link( $category, 'product_cat' ) ) . '">'; ?>
		<h2 class="woocommerce-loop-category__title">
			<?php

			echo esc_html( $category->name );

			if ( $category->count > 0 ) {
				echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . esc_html( $category->count ) . ')</mark>', $category ); // WPCS: XSS ok.
			}
			?>
		</h2></a>
		</div><!-- close .secondline-woocommerce-index-content-bg -->
		<?php
	}
}


if ( ! function_exists( 'woocommerce_template_loop_add_to_cart' ) ) {

	/**
	 * Get the add to cart template for the loop.
	 *
	 * @param array $args Arguments.
	 */
	function woocommerce_template_loop_add_to_cart( $args = array() ) {
		global $product;

		if ( $product ) {
			$defaults = array(
				'quantity'   => 1,
				'class'      => implode( ' ', array_filter( array(
					'button',
					'product_type_' . esc_attr($product->get_type()),
					$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
					$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
				) ) ),
				'attributes' => array(
					'data-product_id'  => $product->get_id(),
					'data-product_sku' => $product->get_sku(),
					'aria-label'       => $product->add_to_cart_description(),
					'rel'              => 'nofollow',
				),
			);

			$args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );

			if ( isset( $args['attributes']['aria-label'] ) ) {
				$args['attributes']['aria-label'] = strip_tags( $args['attributes']['aria-label'] );
			}

			wc_get_template( 'loop/add-to-cart.php', $args );
			echo "</div><!-- close .secondline-woocommerce-index-content-bg -->";
		}
	}
}
