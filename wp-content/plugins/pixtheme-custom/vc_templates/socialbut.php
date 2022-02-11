<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
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
 * @var $link
 * Shortcode class
 * @var $this WPBakeryShortCode_Socialbut
 */
$out = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$href = vc_build_link( $link );
$url = empty($href['url']) ? '#' : $href['url'];
$blank = empty($href['target'])  ? '_self' : $href['target'];

$icon = isset( ${"icon_" . $type} ) ? ${"icon_" . $type} : '';

$out = '
		<li><a target="'.esc_attr($blank).'" href="'.esc_url($url).'" class="icon fa '.esc_attr($icon).'" ></a></li>
	';

echo $out;