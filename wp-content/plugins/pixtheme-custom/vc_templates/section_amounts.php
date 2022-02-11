<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $disable_carousel
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Amounts
 */
 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


$out = '
		<ul  class="list-progress list-unstyled">
			'.do_shortcode($content).'
		</ul>
	';

echo $out;