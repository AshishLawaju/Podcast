<?php
$testimonial_author_text = get_post_meta(get_the_id(), 'theplus_testimonial_author_text', true);
$testimonial_author_text = wpautop( $testimonial_author_text );
if(!empty($testimonial_author_text)){
?>
<div class="entry-content"><?php echo $testimonial_author_text; ?></div>
<?php } ?>