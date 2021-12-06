<?php 
$postid=get_the_ID();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="testimonial-list-content d-flex flex-row flex-wrap tp-align-items-center">		
		<div class="post-content-image flex-column flex-wrap">
			<?php include L_THEPLUS_INCLUDES_URL. 'testimonial/format-image.php'; ?>
			
		</div>
		<div class="testimonial-content-text flex-column flex-wrap">
			<?php include L_THEPLUS_INCLUDES_URL. 'testimonial/post-meta-logo.php'; ?>
			<?php include L_THEPLUS_INCLUDES_URL. 'testimonial/post-meta-title.php'; ?>
			<?php include L_THEPLUS_INCLUDES_URL. 'testimonial/get-excerpt.php'; ?>
			<div class="author-left-text">
				<?php include L_THEPLUS_INCLUDES_URL. 'testimonial/post-title.php'; ?>
				<?php include L_THEPLUS_INCLUDES_URL. 'testimonial/post-meta-designation.php'; ?>
			</div>
		</div>
	</div>
</article>
