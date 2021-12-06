<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version   1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

	<?php do_action( 'woocommerce_before_main_content' ); ?>

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

			<?php while ( have_posts() ) : the_post(); ?>

				<?php wc_get_template_part( 'content', 'single-product' ); ?>

			<?php endwhile; // end of the loop. ?>

			<?php do_action( 'woocommerce_after_main_content' ); ?>


	</div><!-- #content-slt -->

<?php get_footer( 'shop' );
/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
