<?php 
$postid=get_the_ID();
$bg_attr='';

if($layout=='metro'){
		$featured_image=get_the_post_thumbnail_url($postid,'full');
		if ( !empty($featured_image) ) {
			$bg_attr=l_theplus_loading_bg_image($postid);
		}else{
			$bg_attr = l_theplus_loading_image_grid($postid,'background');
		}
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="blog-list-content">
		<?php if($layout!='metro'){ ?>
		<div class="post-content-image">
			<a href="<?php echo esc_url(get_the_permalink()); ?>">
				<?php include L_THEPLUS_INCLUDES_URL. 'blog/format-image.php'; ?>
			</a>			
		</div>
		<?php } ?>
		<div class="post-content-bottom">
			<?php if(!empty($display_post_meta) && $display_post_meta=='yes'){ ?>
				<div class="post-meta-info style-1">
					<?php include L_THEPLUS_INCLUDES_URL. 'blog/meta-date.php'; ?>
					<span>|</span> <span class="post-author"><?php echo __('By ', 'tpebl'); ?> <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><?php echo get_the_author(); ?></a> </span>
				</div>
			<?php } ?>
			<?php include L_THEPLUS_INCLUDES_URL. 'blog/post-meta-title.php'; ?>
			<div class="post-hover-content">
				<?php if(!empty($display_excerpt) && $display_excerpt=='yes' && get_the_excerpt()){ 
					include L_THEPLUS_INCLUDES_URL. 'blog/get-excerpt.php';
				} ?>
			</div>
		</div>
		<?php if($layout=='metro'){ 
			$lazybgclass='';
			if(tp_has_lazyload()){
				$lazybgclass =' lazy-background';
			}
		?>
		<a href="<?php echo esc_url(get_the_permalink()); ?>"><div class="blog-bg-image-metro <?php echo $lazybgclass; ?>" <?php echo $bg_attr; ?>></div></a>
		<?php } ?>
	</div>
</article>