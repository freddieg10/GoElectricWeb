<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $image
 * @var $title
 * @var $link
 * @var $button_text
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Box_Service
 */
 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$href = vc_build_link( $link );

$img_id = preg_replace( '/[^\d]/', '', $image );
$img_link = wp_get_attachment_image_src( $img_id, 'large' );
$img_link = $img_link[0];
$image_meta = autozone_wp_get_attachment($img_id);
$image_alt = $image_meta['alt'] == '' ? $image_meta['title'] : $image_meta['alt'];	

$finalbutton = ($button_text == '') ? '': '<a href="'.esc_url($link).'" class="btn btn-border color"><span>'.esc_attr($button_text).'</span></a>';

$out = $css_animation != '' ? '<div class="animated" data-animation="' . esc_attr($css_animation) . '">' : '<div>';
$out .= '
	<div class="h-p-box">
		<img src="'.esc_url($img_link).'" alt="'.esc_attr($image_alt).'">
		<div class="c-box">
			<h3>'.wp_kses_post($title).'</h3>
			<p>'.do_shortcode($content).'</p>
			'.$finalbutton.'
		</div>
	</div>

</div>
'; 

echo $out;