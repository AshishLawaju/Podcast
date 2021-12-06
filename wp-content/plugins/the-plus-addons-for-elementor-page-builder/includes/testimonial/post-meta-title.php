<?php 
$testimonial_title = get_post_meta(get_the_id(), 'theplus_testimonial_title', true); 
	
if(empty($post_title_tag)){
	$post_title_tag='h3';
}

if(!empty($testimonial_title)){ ?>
	<<?php echo l_theplus_validate_html_tag($post_title_tag); ?> class="testimonial-author-title"><?php echo esc_html($testimonial_title); ?></<?php echo l_theplus_validate_html_tag($post_title_tag); ?>>
<?php } ?>