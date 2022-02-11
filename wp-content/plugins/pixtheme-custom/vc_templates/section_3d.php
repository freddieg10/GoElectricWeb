<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $image
 * @var $number
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_3d
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$out = '';

$img_id = preg_replace( '/[^\d]/', '', $image );
$img_link = wp_get_attachment_image_src( $img_id, 'full' );
$img_link = $img_link[0];
$image_meta = autozone_wp_get_attachment($img_id);
$image_alt = $image_meta['alt'] == '' ? $image_meta['title'] : $image_meta['alt'];
$number = $number == '' ? 16 : $number;


$out = '
		<div class="cd-product-viewer-wrapper" data-frame="'.esc_attr($number).'" data-friction="0.33">
			<div>
				<style scoped> html .cd-product-viewer-wrapper .product-sprite{background: url('.esc_url($img_link).') no-repeat center center; background-size: 100%;}</style>
				<figure class="product-viewer">
					<div class="product-sprite" data-image="'.esc_url($img_link).'"></div>
				</figure> <!-- .product-viewer -->

				<div class="cd-product-viewer-handle">
					<span class="fill"></span>
					<span class="handle">'.esc_html__( 'Handle', 'autozone' ).'</span>
				</div>
			</div>
		</div> 
	';

echo $out;