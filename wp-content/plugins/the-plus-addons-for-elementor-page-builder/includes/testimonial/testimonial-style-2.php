<?php 
$postid=get_the_ID();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="testimonial-list-content">
		<div class="testimonial-content-text">
			<?php include L_THEPLUS_INCLUDES_URL. 'testimonial/get-excerpt.php'; ?>
			<?php include L_THEPLUS_INCLUDES_URL. 'testimonial/post-meta-title.php'; ?>
		</div>
		<div class="post-content-image">
			<?php include L_THEPLUS_INCLUDES_URL. 'testimonial/format-image.php'; ?>
			<?php include L_THEPLUS_INCLUDES_URL. 'testimonial/post-title.php'; ?>
			<?php include L_THEPLUS_INCLUDES_URL. 'testimonial/post-meta-designation.php'; ?>
		</div>		
	</div>
</article>
