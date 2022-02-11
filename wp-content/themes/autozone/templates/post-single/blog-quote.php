<?php
	global $post;
	// get meta options/values
	$autozone_content = class_exists( 'RW_Meta_Box' ) ? rwmb_meta('post_quote_content') : '';
	$autozone_source = class_exists( 'RW_Meta_Box' ) ? rwmb_meta('post_quote_source') : '';
	$autozone_format  = get_post_format();
	$autozone_format = !in_array($autozone_format, array("quote", "gallery", "video")) ? "standared" : $autozone_format;
	$post_date = strtotime($post->post_date);

	$categories = wp_get_post_categories($post->ID,array('fields' => 'all'));
	$comments = wp_count_comments($post->ID);
?>

<div class="entry-media">
	<blockquote>
		<?php echo wp_kses_post($autozone_content); ?>
		<div class="blog-quote-source"><?php echo wp_kses_post($autozone_source)?></div>
	</blockquote>
	<a href="<?php esc_url(the_permalink())?>" class="btn button-border font-additional font-weight-bold hvr-rectangle-out hover-focus-bg hover-focus-border before-bg"><?php echo autozone_post_read_more()?></a>
</div>
