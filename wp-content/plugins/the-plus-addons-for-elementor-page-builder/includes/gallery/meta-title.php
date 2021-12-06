<?php 
if(!isset($post_title_tag) && empty($post_title_tag)){
	$post_title_tag='h3';
} ?>
<<?php echo l_theplus_validate_html_tag($post_title_tag); ?> class="post-title">
	<?php 
	if($popup_style!='no'){ ?>				
		<a href="<?php echo esc_url($full_image); ?>" <?php echo $popup_attr; ?>><?php echo esc_html($title); ?></a>				
	<?php }else{ 
		echo esc_html($title); 
	} ?>
</<?php echo l_theplus_validate_html_tag($post_title_tag); ?>>