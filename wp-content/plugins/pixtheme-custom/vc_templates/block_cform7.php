<?php
global $post;
$out = '';

extract(shortcode_atts(array(
	'form_id'=>'',
	'css_animation' => '',				
), $atts));

$out = $css_animation != '' ? '<div class="animated" data-animation="' . esc_attr($css_animation) . '">' : '<div>';
$out .= do_shortcode('[contact-form-7 id="'.esc_attr($form_id).'"]');

$out .= '</div>';

echo $out;