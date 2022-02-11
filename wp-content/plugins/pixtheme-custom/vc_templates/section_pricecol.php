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
 * @var $monthprice
 * @var $yearprice
 * @var $ispopular
 * @var $btntext
 * @var $link
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Tab
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$type = isset( $type ) ? $type : 'pixflaticon';
$icon = isset( ${"icon_" . $type} ) ? ${"icon_" . $type} : '';
$class = $ispopular == true ? 'p-recommended' : '';
$href = vc_build_link( $link );

$out = do_shortcode($content);

echo $out;