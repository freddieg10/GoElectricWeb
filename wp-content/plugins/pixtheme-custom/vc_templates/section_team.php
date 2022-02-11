<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $min_slides
 * @var $carousel
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Team
 */
 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$out = $css_animation != '' ? '<div class="animated" data-animation="' . esc_attr($css_animation) . '">' : '<div>';

$section_cont = explode( '[/section_team_member]', $content );
array_pop($section_cont);
if( is_array( $section_cont ) && !empty( $section_cont ) ){
	$i=0;
	$out_cont = '';
	foreach( $section_cont as $option ){
		$i++;		
		$out_cont .= do_shortcode($option.'[/section_team_member]');			   
	}		         
}

$out .= '
		<ul class="list-staff list-unstyled">
			'.$out_cont.'
		</ul>
	';

$out .= '</div>'; 
echo $out;