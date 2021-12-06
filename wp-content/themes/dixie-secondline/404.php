<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package slt
 */

get_header(); ?>

	<div id="page-title-slt">
		<div class="width-container-slt">
			<div id="secondline-themes-page-title-container">
				<h1 class="page-title"><?php esc_html_e( '404 Error', 'dixie-secondline' ); ?></h1>
			</div>
			<div class="clearfix-slt"></div>
		</div>
		<?php if(!is_front_page() && function_exists('bcn_display')) { echo '<div id="bread-crumb-container"><div class="width-container-slt"><div class="breadcrumbs-dixie"><ul id="breadcrumbs-slt"><li><a href="'; echo esc_url( home_url( '/' ) ); echo '">'; echo esc_html_e( 'Home', 'dixie-secondline' );  echo '</a></li>'; bcn_display_list(); echo '</ul><div class="clearfix-slt"></div></div></div></div><div class="clearfix-slt"></div>'; }?>
	</div><!-- #page-title-slt -->

	
	<div id="content-slt">
		<div id="error-page-index">

		<div class="width-container-slt">
			
				<br>				
				<h2><?php esc_html_e( "Oops! This page can&rsquo;t be found.", 'dixie-secondline' ); ?></h2>
				<p><?php esc_html_e( "Sorry, We couldn&rsquo;t find the page you&rsquo;re looking for. Maybe Try one of the links in the navigation or a search.", 'dixie-secondline' ); ?></p>
				<?php get_search_form(); ?>
				
				<br>
				
		
			
		<div class="clearfix-slt"></div>
		</div><!-- close .width-container-slt -->
		</div><!-- close #error-page-index -->
	</div><!-- #content-slt -->
	
<?php get_footer(); ?>