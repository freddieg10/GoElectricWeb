<?php
$out = $css_class = '';

extract(shortcode_atts(array(
	'sidebar'=>'',
	'css_animation' => '',
), $atts));

if ( is_active_sidebar( $sidebar ) ) { 
	ob_start();
	dynamic_sidebar($sidebar);
	$out = $css_animation != '' ? '<div class="animated" data-animation="' . esc_attr($css_class) . '">' : '';
	$out .= ob_get_contents();
	$out .= $css_animation != '' ? '</div>' : '';
	ob_end_clean();
};

echo $out;