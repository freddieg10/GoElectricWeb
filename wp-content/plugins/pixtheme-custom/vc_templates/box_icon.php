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
 * @var $position
 * @var $title
 * @var $link
 * @var $btn_text
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Box_Icon
 */
 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$href = vc_build_link( $link );

$icon = isset( ${"icon_" . $type} ) ? ${"icon_" . $type} : '';
$position = $position == '' ? 'icon-left' : $position;

$out = $css_animation != '' ? '<div class="animated" data-animation="' . esc_attr($css_animation) . '">' : '<div>';
$btn = $btn_text == '' ? '' : '
			<a class="btn btn-success btn-sm" href="'.esc_url($href['url']).'">
				<span>'.wp_kses_post($btn_text).'</span>
			</a>';

$out .= '
		<div class="listing '.esc_attr($position).'">
			<span class="fl-ic '.esc_attr($icon).'"></span>										
			<div class="list-content">
				<h4>'.wp_kses_post($title).'</h4>
				<div>'.do_shortcode($content).'</div>
			</div>
			'.$btn.'
		</div>
	';		

$out .= '</div>'; 

echo $out;