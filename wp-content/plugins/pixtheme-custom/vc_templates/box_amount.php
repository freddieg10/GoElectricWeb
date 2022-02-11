<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $type
 * @var $icon_pixelegant
 * @var $icon_pixflaticon
 * @var $icon_pixicomoon
 * @var $icon_pixfontawesome
 * @var $icon_pixsimple
 * @var $icon_fontawesome
 * @var $icon_openiconic
 * @var $icon_typicons
 * @var $icon_entypo
 * @var $icon_linecons
 * @var $title
 * @var $amount
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Box_Amount
 */
 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$icon = isset( ${"icon_" . $type} ) ? ${"icon_" . $type} : '';

$out = $css_animation != '' ? '<div class="wrap-counters animated" data-animation="' . esc_attr($css_animation) . '">' : '<div class="wrap-counters">';
$out .= '
		
	<div class="row-counters pix-easy-chart">
		<div class="counter-item">
			<div class="icon"><i class="'.esc_attr($icon).'"></i></div>
			<div class="count">
			
				<span class="chart" data-percent="'.esc_attr($amount).'"> 
				<span class="percent">'.wp_kses_post($amount).'</span> 
				<canvas height="0" width="0"></canvas>
			</span></div>
			
			
			<p>'.wp_kses_post($title).'</p>
		</div>
	</div>
			
</div>			

	';  

echo $out;