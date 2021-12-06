<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package slt
 * @since slt 1.0
 */

if ( ! is_active_sidebar( 'secondline-themes-sidebar' ) ) {
	return;
}
?>

<div class="sidebar">
		<?php dynamic_sidebar( 'secondline-themes-sidebar' ); ?>
</div><!-- close .sidebar -->