<?php if(!empty($settings["custom_icon_image"]["url"])){
	$icon_content ='<img src="'.esc_url($settings["custom_icon_image"]["url"]).'" alt="'.esc_attr('zoom','tpebl').'"/>';
}else{
	$icon_content ='<i class="fas fa-search-plus" aria-hidden="true"></i>';
} ?>
<div class="meta-search-icon">	
		<a href="<?php echo esc_url($full_image); ?>" <?php echo $popup_attr_icon; ?>><?php echo $icon_content; ?></a>
</div>