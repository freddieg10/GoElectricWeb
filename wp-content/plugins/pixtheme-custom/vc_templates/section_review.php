<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $image
 * @var $name
 * @var $position
 * @var $link
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Review
 */
 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$img_id = preg_replace( '/[^\d]/', '', $image );
$img_link = wp_get_attachment_image_src( $img_id, 'large' );
$img_link = $img_link[0];
$image_meta = autozone_wp_get_attachment($img_id);
$image_alt = $image_meta['alt'] == '' ? $image_meta['title'] : $image_meta['alt'];

			
$out = '
		<div class="reviews">
			<h3 class="reviews__title">'.wp_kses_post($title).'</h3>
			<div class="decor-1"></div>
			<div class="reviews__text">
				'.do_shortcode($content).'
			</div>
			<div class="reviews__img"><img class="img-responsive" src="'.esc_url($img_link).'" height="55" width="55" alt="'.esc_attr($image_alt).'"></div>
			<div class="reviews__inner">
				<div class="reviews__name">'.wp_kses_post($name).'</div>
				<div class="reviews__category">'.wp_kses_post($position).'</div>
			</div>
		</div>
	';

echo $out;