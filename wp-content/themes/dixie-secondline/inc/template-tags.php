<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package slt
 */


add_filter( 'secondline_themes_filter_embeds', 'wp_oembed_get' );


/* Logo */
function secondline_themes_logo() {
	global $post;
?>
	<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
		
	<?php if ( get_theme_mod( 'secondline_themes_theme_logo', get_template_directory_uri() . '/images/logo.png' ) ) : ?>
		<img src="<?php echo esc_attr( get_theme_mod( 'secondline_themes_theme_logo', get_template_directory_uri() . '/images/logo.png' ) ); ?>" alt="<?php bloginfo('name'); ?>" class="secondline-themes-default-logo	<?php if ( get_theme_mod( 'secondline_themes_fixed_logo' ) ) : ?> secondline-themes-default-logo-hide<?php endif; ?>">
	<?php endif; ?>
	
	<?php if ( get_theme_mod( 'secondline_themes_fixed_logo' ) ) : ?>
		<img src="<?php echo esc_attr( get_theme_mod( 'secondline_themes_fixed_logo') ); ?>" alt="<?php bloginfo('name'); ?>" class="secondline-themes-fixed-logo">
	<?php endif; ?>
	</a>
<?php
}


/* Header/Page Title Options */
function secondline_themes_page_title() {
	global $post;
?>
	class="

		<?php echo esc_attr( get_theme_mod( 'secondline_themes_header_width', 'secondline-themes-header-normal-width') ); ?> 
		<?php echo esc_attr( get_theme_mod( 'secondline_themes_header_floating', 'secondline-themes-header-float') ); ?> 
		<?php echo esc_attr( get_theme_mod( 'secondline_themes_logo_position', 'secondline-themes-logo-position-left') ); ?> 
		<?php if(is_page() && get_post_meta($post->ID, 'secondline_themes_header_disabled', true)): ?> secondline-disable-header-per-page<?php endif; ?>
		<?php if(is_page() && get_post_meta($post->ID, 'secondline_themes_disable_footer_per_page', true)): ?> secondline-disable-footer-per-page<?php endif; ?>	
<?php if ( get_theme_mod( 'secondline_themes_nav_search', 'off') == 'off') : ?> secondline-themes-search-icon-off<?php endif; ?>		
		  secondline-themes-one-page-nav-off
	"
<?php
}


function secondline_themes_navigation() {
?>
	
	<?php if (get_theme_mod( 'secondline_themes_header_fixed', 'none-fixed-slt' ) == 'fixed-slt' && get_theme_mod( 'secondline_themes_logo_position', 'secondline-themes-logo-position-left' ) == 'secondline-themes-logo-position-center' ) : ?><div id="secondline-fixed-nav"><?php endif; ?>
	
	<div class="width-container-slt optional-centered-area-on-mobile">
	
		<div class="mobile-menu-icon-slt noselect"><i class="fa fa-bars"></i><?php if (get_theme_mod( 'secondline_themes_mobile_menu_text') == 'on' ) : ?><span class="secondline-mobile-menu-text"><?php echo esc_html__( 'Menu', 'dixie-secondline' )?></span><?php endif; ?></div>
		
		<div id="secondline-themes-header-search-icon" class="noselect">
			<i class="fa fa-search"></i>
			<div id="panel-search-secondline">
				<?php get_search_form(); ?><div class="clearfix-slt"></div>
			</div>
		</div>	
		
		<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<?php if ( get_theme_mod( 'secondline_themes_nav_cart', 'off') == 'on') : ?>
				<?php global $woocommerce; ?>
				<a id="secondline-themes-header-cart-icon" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
					<i class="fas fa-shopping-cart"></i>
					<span class="shopping-cart-header-count"><?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'dixie-secondline'), $woocommerce->cart->cart_contents_count);?></span>
				</a>
			<?php endif;?>		
		<?php endif;?>	
		
		<div id="secondline-inline-icons"><?php get_template_part( 'header/header', 'icons' ); ?></div>
		
		<div id="secondline-nav-container">
			<nav id="site-navigation" class="main-navigation">
				<?php wp_nav_menu( array('theme_location' => 'secondline-themes-primary', 'menu_class' => 'sf-menu', 'fallback_cb' => false ) ); ?><div class="clearfix-slt"></div>
			</nav>
			<div class="clearfix-slt"></div>
		</div><!-- close #secondline-nav-container -->
		

		
		<div class="clearfix-slt"></div>
	</div><!-- close .width-container-slt -->
	
	<?php if (get_theme_mod( 'secondline_themes_header_fixed', 'none-fixed-slt' ) == 'fixed-slt' && get_theme_mod( 'secondline_themes_logo_position', 'secondline-themes-logo-position-left' ) == 'secondline-themes-logo-position-center' ) : ?></div><?php endif; ?>
		
<?php
}



function secondline_themes_blog_link() {
	global $post;
?>								
<a href="<?php the_permalink(); ?>">														
	
<?php
}




function secondline_themes_blog_post_title() {
	global $post;
?>

				<a href="<?php the_permalink(); ?>">
					
	
<?php
}






/* Modify Default Category Widget */
add_filter('wp_list_categories', 'secondline_themes_add_span_cat_count');
function secondline_themes_add_span_cat_count($links) {
	$links = str_replace('</a> (', ' <span class="count">', $links);
	
	$links = str_replace('(', '', $links);
	
	$links = str_replace(')', '</span></a>', $links);
	return $links;
}

add_filter('get_archives_link', 'secondline_themes_archive_count_span');
function secondline_themes_archive_count_span($links) {
	$links = str_replace('</a>&nbsp;(', ' <span class="count">', $links);
	$links = str_replace(')', '</span></a>', $links);
return $links;
}



function secondline_themes_blog_index_gallery() {
?>								
								href="<?php the_permalink(); ?>"
	
<?php
}




/* remove more link jump */
function secondline_themes_remove_more_link_scroll( $link ) {
	$link = preg_replace( '|#more-[0-9]+|', '', $link );
	return $link;
}
add_filter( 'the_content_more_link', 'secondline_themes_remove_more_link_scroll' );




if ( ! function_exists( 'secondline_themes_show_pagination_links_slt' ) ) :
function secondline_themes_show_pagination_links_slt()
{
    global $wp_query;

    $page_tot   = $wp_query->max_num_pages;
    $page_cur   = get_query_var( 'paged' );
    $big        = 999999999;

    if ( $page_tot == 1 ) return;

    echo paginate_links( array(
            'base'      => str_replace( $big, '%#%',get_pagenum_link( 999999999, false ) ), // need an unlikely integer cause the url can contains a number
            'format'    => '?paged=%#%',
            'current'   => max( 1, $page_cur ),
            'total'     => $page_tot,
            'prev_next' => true,
				'prev_text'    => esc_html__('&lsaquo;', 'dixie-secondline'),
				'next_text'    => esc_html__('&rsaquo;', 'dixie-secondline'),
            'end_size'  => 1,
            'mid_size'  => 2,
            'type'      => 'list'
        )
    );
}
endif;





if ( ! function_exists( 'secondline_themes_show_pagination_links_blog' ) ) :
function secondline_themes_show_pagination_links_blog()
{	
    global $blogloop;

    $page_tot   = $blogloop->max_num_pages;
	 if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } else if ( get_query_var('page') ) {   $paged = get_query_var('page'); } else {  $paged = 1; }
    $big        = 999999999;

    if ( $page_tot == 1 ) return;

    echo paginate_links( array(
            'base'      => str_replace( $big, '%#%',get_pagenum_link( 999999999, false ) ), // need an unlikely integer cause the url can contains a number
            'format'    => '?paged=%#%',
            'current'   => max( 1, $paged ),
            'total'     => $page_tot,
            'prev_next' => true,
				'prev_text'    => esc_html__('&lsaquo;', 'dixie-secondline'),
				'next_text'    => esc_html__('&rsaquo;', 'dixie-secondline'),
            'end_size'  => 1,
            'mid_size'  => 2,
            'type'      => 'list'
        )
    );
}
endif;







if ( ! function_exists( 'secondline_themes_infinite_content_nav_slt' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since Twenty Twelve 1.0
 */
function secondline_themes_infinite_content_nav_slt( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<div id="infinite-nav-slt-default" class="infinite-nav-slt">
			<div class="nav-previous"><?php next_posts_link( wp_kses( __('Load More', 'dixie-secondline' ) , TRUE) ); ?></div>
		</div>
	<?php endif;
}
endif;





if ( ! function_exists( 'secondline_themes_content_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function secondline_themes_content_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="secondline-themes-post-navigation">
		<div class="secondline-themes-nav-links">
			<?php
				previous_post_link( '<div class="secondline-themes-nav-previous">%link</div>', '<i class="fa fa-long-arrow-left" aria-hidden="true"></i>' ); ?>
				
							<div class="secondline-themes-post-nav-back"><a href="<?php 
				if( get_option( 'page_for_posts' ) ) { 
				  echo get_permalink( get_option( 'page_for_posts' ) ); 
				} else { 
				  echo esc_url( home_url() ); 
				} 
				?>"><i class="fa fa-th" aria-hidden="true"></i></a></div>
				
			<?php	next_post_link( '<div class="secondline-themes-nav-next">%link</div>', '<i class="fa fa-long-arrow-right" aria-hidden="true"></i>' );
			?>
		<div class="clearfix-slt"></div>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;



/* Remove "Category" and "Tag" from the archive title */
add_filter( 'get_the_archive_title', function ($title) {

    if ( is_category() ) {

            $title = single_cat_title( '', false );

        } elseif ( is_tag() ) {

            $title = single_tag_title( '', false );

        }

    return $title;

});



/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function secondline_themes_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'secondline_themes_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'secondline_themes_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so secondline_themes_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so secondline_themes_categorized_blog should return false.
		return false;
	}
}



/**
 * Flush out the transients used in secondline_themes_categorized_blog.
 */
function secondline_themes_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'secondline_themes_categories' );
}
add_action( 'edit_category', 'secondline_themes_category_transient_flusher' );
add_action( 'save_post',     'secondline_themes_category_transient_flusher' );




/* EXERPT TRIM */

function secondline_addons_excerpt($limit) {
	  $excerpt = explode(' ', get_the_excerpt(), $limit);
	  if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	  } else {
		$excerpt = implode(" ",$excerpt);
	  }	
	  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
	  return $excerpt;
}


function secondline_excerpt_more( $more ) {
    return '...';
}
add_filter('excerpt_more', 'secondline_excerpt_more');



/* Minify Customizer CSS */
function secondline_minify_css( $css ) {
	// Remove comments.
	$css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css );

	// Backup values within single or double quotes.
	preg_match_all( '/(\'[^\']*?\'|"[^"]*?")/ims', $css, $hit, PREG_PATTERN_ORDER );
	$count = count( $hit[1] );
	for ( $i = 0; $i < $count; $i++ ) {
		$css = str_replace( $hit[1][ $i ], '##########' . $i . '##########', $css );
	}

	// Remove traling semicolon of selector's last property.
	$css = preg_replace( '/;[\s\r\n\t]*?}[\s\r\n\t]*/ims', "}\r\n", $css );

	// Remove any whitespace between semicolon and property-name.
	$css = preg_replace( '/;[\s\r\n\t]*?([\r\n]?[^\s\r\n\t])/ims', ';$1', $css );

	// Remove any whitespace surrounding property-colon.
	$css = preg_replace( '/[\s\r\n\t]*:[\s\r\n\t]*?([^\s\r\n\t])/ims', ':$1', $css );

	// Remove any whitespace surrounding selector-comma.
	$css = preg_replace( '/[\s\r\n\t]*,[\s\r\n\t]*?([^\s\r\n\t])/ims', ',$1', $css );

	// Remove any whitespace surrounding opening parenthesis.
	$css = preg_replace( '/[\s\r\n\t]*{[\s\r\n\t]*?([^\s\r\n\t])/ims', '{$1', $css );

	// Remove any whitespace between numbers and units.
	$css = preg_replace( '/([\d\.]+)[\s\r\n\t]+(px|em|pt|%)/ims', '$1$2', $css );

	// Shorten zero-values.
	$css = preg_replace( '/([^\d\.]0)(px|em|pt|%)/ims', '$1', $css );

	// Constrain multiple whitespaces.
	$css = preg_replace( '/\p{Zs}+/ims', ' ', $css );

	// Remove newlines.
	$css = str_replace( array( "\r\n", "\r", "\n" ), '', $css );

	// Restore backupped values within single or double quotes.
	$count = count( $hit[1] );
	for ( $i = 0; $i < $count; $i++ ) {
		$css = str_replace( '##########' . $i . '##########', $hit[1][ $i ], $css );
	}
	return $css;
}



