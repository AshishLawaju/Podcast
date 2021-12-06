<?php
$postid=get_the_ID();
$client_url = get_post_meta(get_the_id(), 'theplus_clients_url', true);

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="client-post-content">
		<div class="client-content-logo">		
			<a href="<?php echo esc_url($client_url); ?>" target="_blank" rel="noopener noreferrer">
				<?php include L_THEPLUS_INCLUDES_URL. 'client/format-image.php'; ?>
			</a>
		</div>
		<?php if(!empty($display_post_title) && $display_post_title=='yes'){ ?>
			<div class="post-content-bottom">
				<?php include L_THEPLUS_INCLUDES_URL. 'client/post-meta-title.php'; ?>
			</div>
		<?php } ?>
	</div>
</article>
