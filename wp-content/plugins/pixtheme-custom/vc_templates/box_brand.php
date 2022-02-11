<?php
$out = $image = '';

extract(shortcode_atts(array(
	'image'=>$image,
	'url'=>'',
	'css_animation' => '',			
), $atts));

$img = wp_get_attachment_image_src( $image, 'large' );
	
$img_output = $img[0];
$image_meta = autozone_wp_get_attachment($image);
$image_alt = $image_meta['alt'] == '' ? $image_meta['title'] : $image_meta['alt'];

 
$out .= '
	<div class="brand-logo">
		<a class="brand-logo-wrap" href="'.esc_url($url).'"><img src="'.esc_url($img_output).'" alt="'.esc_attr($image_alt).'"></a> 
</div>';
	
echo $out;