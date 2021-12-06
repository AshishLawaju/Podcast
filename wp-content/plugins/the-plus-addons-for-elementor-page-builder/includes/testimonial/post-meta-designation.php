<?php
$testimonial_designation = get_post_meta(get_the_id(), 'theplus_testimonial_designation', true);
if(!empty($testimonial_designation)){
?>
<div class="post-designation"><?php echo esc_html($testimonial_designation); ?></div>
<?php } ?>