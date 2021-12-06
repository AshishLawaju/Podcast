<?php 
if(!isset($post_title_tag) && empty($post_title_tag)){
	$post_title_tag='h3';
} ?>
<<?php echo l_theplus_validate_html_tag($post_title_tag); ?> class="post-title">
	<a href="<?php echo esc_url(get_the_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a>
</<?php echo l_theplus_validate_html_tag($post_title_tag); ?>>