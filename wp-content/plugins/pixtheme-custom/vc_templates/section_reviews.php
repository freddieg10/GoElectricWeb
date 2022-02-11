<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $reviews_per_page
 * @var $disable_carousel
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Reviews
 */
 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$disable_carousel = $disable_carousel == 1 ? 'owl-carousel  enable-owl-carousel' : '';

$section_cont = explode( '[/section_review]', $content );
array_pop($section_cont);
if( is_array( $section_cont ) && !empty( $section_cont ) ){
	$i=0;
	$out_cont = '';
	foreach( $section_cont as $option ){
		$i++;		
		$out_cont .= do_shortcode($option.'[/section_review]');			   
	}		         
}

$out = '<div class="slider-reviews '.esc_attr($disable_carousel).' owl-theme owl-theme_mod-a" data-min480="1" data-min768="2" data-min992="'.esc_attr($reviews_per_page).'" data-min1200="'.esc_attr($reviews_per_page).'" data-pagination="true" data-navigation="false" data-auto-play="400000" data-stop-on-hover="true" >
			'.$out_cont.'
		</div>
	';

echo $out;