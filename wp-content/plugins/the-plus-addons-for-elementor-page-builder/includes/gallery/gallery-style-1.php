<?php 
	if($attachment){
		$image_id = $attachment->ID;
	}else{
		$image_id = $image_id;
	}
	
	$full_image='';
	$full_image=wp_get_attachment_url($image_id ,'full');

$bg_attr='';
if($layout=='metro'){	
	if ( !empty($full_image) ) {
		$bg_attr='style="background:url('.$full_image.')"';
	}else{
		$bg_attr = l_theplus_loading_image_grid($postid,'background');
	}
} ?>
	<div class="gallery-list-content">

	<?php if($layout!='metro'){ ?>
	<div class="post-content-image">
		<?php include L_THEPLUS_INCLUDES_URL. 'gallery/format-image.php'; ?>
	</div>
	<?php } ?>
	<div class="post-content-center">		
		<div class="post-hover-content">
			<?php if(!empty($display_icon_zoom) && $display_icon_zoom=='yes'){
				include L_THEPLUS_INCLUDES_URL. 'gallery/meta-icon.php';
			} ?>
			<?php if(!empty($image_icon) && !empty($list_img)){ ?>
				<div class="gallery-list-icon"><?php echo $list_img; ?></div>
			<?php } ?>
			<?php if(!empty($display_title) && $display_title=='yes'){
				include L_THEPLUS_INCLUDES_URL. 'gallery/meta-title.php';
			} ?>
			<?php if(!empty($display_excerpt) && $display_excerpt=='yes' && !empty($caption)){ 
				include L_THEPLUS_INCLUDES_URL. 'gallery/get-excerpt.php';
			} ?>
		</div>
	</div>
	<?php if($layout=='metro'){ ?>
		<div class="gallery-bg-image-metro" <?php echo $bg_attr; ?>></div>
	<?php } ?>
	</div>