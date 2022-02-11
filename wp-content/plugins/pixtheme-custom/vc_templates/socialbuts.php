<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Socialbuts
 */
$out = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


$out = '
			<ul class="social-links list-inline">
				'.do_shortcode($content).'
			</ul>
	';

echo $out;