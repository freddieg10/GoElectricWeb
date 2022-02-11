<?php
/**
 * The template includes blog post format gallery.
 *
 * @package Pix-Theme
 * @since 1.0
 */
	global $post;
	// get the gallery images
	$size = (is_front_page()) && !is_home() ? 'portfolio-3col' : 'blog-post';
	$gallery = class_exists( 'RW_Meta_Box' ) ? rwmb_meta('post_gallery', 'type=image&size='.$size.'') : '';
 
	$argsThumb = array(
		'order'          => 'ASC',
		'post_type'      => 'attachment',
		'post_parent'    => $post->ID,
		'post_mime_type' => 'image',
		'post_status'    => null,
		//'exclude' => get_post_thumbnail_id()
	);
	$attachments = get_posts($argsThumb);
	$autozone_format  = get_post_format();
	$autozone_format = !in_array($autozone_format, array("quote", "gallery", "video")) ? "standared" : $autozone_format;
	$post_date = strtotime($post->post_date);

	$post_content = get_the_content();
	$post_content = preg_replace("#\[.*?\]#is",'',$post_content);
	$post_content = wp_trim_words($post_content,100,' [...]');

	$categories = wp_get_post_categories($post->ID,array('fields' => 'all'));
	$comments = wp_count_comments($post->ID);

?>



<div class="entry-media">

	<?php
	if ($gallery || $attachment){
	?>

	<div class=" carousel-post enable-owl-carousel owl-product-slider owl-bottom-pagination owl-theme" data-wow-delay="0.7s" data-navigation="true" data-pagination="false" data-single-item="true" data-auto-play="true" data-transition-style="false" data-main-text-animation="false" data-min600="1" data-min800="1" data-min1200="1">
				<?php
				if($gallery){
					foreach ($gallery as $slide) {
						echo '<img src="' . esc_url($slide['url']) . '" width="' . esc_attr($slide['width']) . '" height="' . esc_attr($slide['height']) . '" alt="' .esc_attr($slide['alt']).'" title="' .esc_attr($slide['title']). '" />';
					}
				}elseif ($attachments) {
					foreach ($attachments as $attachment) {
						echo '<img src="'.esc_url(wp_get_attachment_url($attachment->ID, 'full', false, false)).'" alt="'.esc_attr(get_post_meta($attachment->ID, '_wp_attachment_image_alt', true)).'" title="'.esc_attr(get_post_meta($attachment->ID, '_wp_attachment_image_title', true)).'" />';
					}
				}

				?>
	</div>
	<?php } else { ?>
		<?php if ( has_post_thumbnail() ):?>
			  <?php the_post_thumbnail('full', array( 'class' => 'img-responsive' )); ?>
		<?php endif; ?>
	<?php } ?>
</div>

