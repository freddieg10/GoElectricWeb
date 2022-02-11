<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $disable_carousel
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Services
 */
 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$disable_carousel = $disable_carousel == 1 ? 'owl-carousel enable-owl-carousel' : '';

$section_cont = explode( '[/section_service]', $content );
$out_cont = '';
array_pop($section_cont);
if( is_array( $section_cont ) && !empty( $section_cont ) ){
	$i=0;
	$out_cont = '';
	foreach( $section_cont as $option ){
		$i++;		
		$out_cont .= do_shortcode($option.'[/section_service]');
	}		         
}

$out = '
		<div  class="slider-services '.esc_attr($disable_carousel).' owl-theme owl-theme_mod-a" data-min480="2" data-min768="3" data-min992="4" data-min1200="4" data-pagination="true" data-navigation="false" data-auto-play="4000" data-stop-on-hover="true">
			'.$out_cont.'
		</div>
	';

echo $out;