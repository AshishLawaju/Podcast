<?php
/**
 * The template for displaying search forms
 *
 * @package slt
 */
?>
<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php _ex( 'Search for:', 'label', 'dixie-secondline' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search...', 'placeholder', 'dixie-secondline' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
	</label>
	<input type="submit" class="search-submit" value="<?php echo esc_html__( 'Submit', 'dixie-secondline' ); ?>">
	<div class="clearfix-slt"></div>
</form>