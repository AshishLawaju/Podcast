<?php 
	global $post;
	$postid = get_the_ID();
	$featured_image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
	
	if(! empty( $featured_image_url )){
		$featured_image= tp_get_image_rander( get_the_ID(), 'full', [], 'post' );
	}else{
		$featured_image=l_theplus_get_thumb_url();
		$featured_image='<img width="600" height="600" loading="lazy" data-src="'.esc_url($featured_image).'" class="tp-lazyload" alt="'.esc_attr(get_the_title()).'">';
	}
	
?>
	<div class="client-featured-logo">
		<span class="thumb-wrap">
			<?php echo $featured_image; ?>
		</span>
	</div>