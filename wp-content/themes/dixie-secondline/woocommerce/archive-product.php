<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see			https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>

	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<?php $your_shop_page = get_post( wc_get_page_id( 'shop' ) ); ?>
		<div id="page-title-slt" <?php if( ($your_shop_page !='') && get_post_meta($your_shop_page->ID, 'secondline_themes_header_image', true) !='') : ?> style="background-image:url('<?php echo esc_url( get_post_meta($your_shop_page->ID, 'secondline_themes_header_image', true)); ?>');"<?php endif;?>>
				<div id="secondline-themes-page-title-container">
					<div class="width-container-slt">
					<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
					<?php if( ($your_shop_page !='') && get_post_meta($your_shop_page->ID, 'secondline_sub_title', true)): ?><h4 class="secondline-sub-title"><?php echo esc_html( get_post_meta($your_shop_page->ID, 'secondline_sub_title', true) );?></h4><?php endif; ?>
					</div><!-- close .width-container-slt -->
				</div><!-- close #secondline-themes-page-title-container -->
				<div class="clearfix-slt"></div>
		</div><!-- #page-title-slt -->
	<?php endif; ?>



	<div id="content-slt">
		<div class="width-container-slt<?php if( ($your_shop_page !='') && get_post_meta($your_shop_page->ID, 'secondline_themes_page_sidebar', true) == 'left-sidebar' ) : ?> left-sidebar-slt<?php endif; ?>">
			<?php if( ($your_shop_page !='') && get_post_meta($your_shop_page->ID, 'secondline_themes_page_sidebar', true) == 'right-sidebar' || ($your_shop_page !='') && get_post_meta($your_shop_page->ID, 'secondline_themes_page_sidebar', true) == 'left-sidebar' ) : ?><div id="main-container-slt"><?php endif; ?>


				<?php do_action( 'woocommerce_archive_description' ); ?>

				<?php
				if ( woocommerce_product_loop() ) {

					do_action( 'woocommerce_before_shop_loop' );

					woocommerce_product_loop_start();

					if ( wc_get_loop_prop( 'total' ) ) {
						while ( have_posts() ) {
							the_post();

							do_action( 'woocommerce_shop_loop' );

							wc_get_template_part( 'content', 'product' );
						}
					}

					woocommerce_product_loop_end();

					do_action( 'woocommerce_after_shop_loop' );
				} else {

					do_action( 'woocommerce_no_products_found' );
				}


				do_action( 'woocommerce_after_main_content' );


				?>


				<?php if( ($your_shop_page !='') && get_post_meta($your_shop_page->ID, 'secondline_themes_page_sidebar', true) == 'right-sidebar' || ($your_shop_page !='') && get_post_meta($your_shop_page->ID, 'secondline_themes_page_sidebar', true) == 'left-sidebar' ) : ?>
					</div><!-- close #main-container-slt -->
					<div class="sidebar">
						<?php dynamic_sidebar( 'secondline-sidebar-shop' ); ?>
					</div><!-- close .sidebar -->
				<?php endif; ?>

			<div class="clearfix-slt"></div>
		</div><!-- close .width-container-slt -->
	</div><!-- #content-slt -->


<?php get_footer( 'shop' ); ?>
