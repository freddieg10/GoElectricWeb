
<?php
/**
 * This template is for displaying part of blog.
 *
 * @package Pix-Theme
 * @since 1.0
 */


?>

<div class="entry-media">
	<?php if ( has_post_thumbnail() ):?>
		<?php the_post_thumbnail('full', array( 'class' => 'img-responsive' )); ?>
	<?php endif; ?>
	<?php if(is_sticky($post->ID)) { ?>
		<a class="entry-btn btn btn-default btn-effect" href="javascript:void(0);"><span class="btn-inner"><?php esc_html_e('FEATURED', 'autozone') ?></span></a>
	<?php } ?>
</div>

