<?php
global $post;
/**
 * Shortcode attributes
 * @var $atts
 * @var $item_1
 * @var $item_2
 * @var $item_3
 * @var $item_4
 * @var $item_5
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Autos_Slide
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$out = $item_1.','.$item_2.','.$item_3.','.$item_4.','.$item_5;

echo $out;