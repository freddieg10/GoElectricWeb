<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $title_strong
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
 * @var $link
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Review
 */
 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$icon = isset( ${"icon_" . $type} ) ? ${"icon_" . $type} : '';
$href = vc_build_link( $link );
$a_href = empty($href['url']) ? wp_kses_post($title).' <strong>'.wp_kses_post($title_strong).'</strong>' : '<a href="'.esc_url($href['url']).'">'.wp_kses_post($title).' <strong>'.wp_kses_post($title_strong).'</strong></a>';

$out = '
		<div class="list-services">
			<i class="icon '.esc_attr($icon).'"></i>
			<div class="decor-1"></div>
			<div class="list-services__inner">
				<h3 class="list-services__title">'.wp_kses_post($a_href).'</h3>
				<div class="list-services__description">'.do_shortcode($content).'</div>
			</div>
		</div>
	';

echo $out;