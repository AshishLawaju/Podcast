<?php
/**
 * @package slt
 */
?>
<section class="no-results-slt not-found-slt">
	
	<h2 class="page-title-slt"><?php esc_html_e( 'Nothing Found', 'dixie-secondline' ); ?></h2>

	<div class="page-content-slt">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'dixie-secondline' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'dixie-secondline' ); ?></p>
			<div id="no-results-slt"><?php get_search_form(); ?></div>

		<?php else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'dixie-secondline' ); ?></p>
			<div id="no-results-slt"><?php get_search_form(); ?></div>
			
		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->