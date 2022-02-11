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
 * @var $tab_id
 * @var $title
 * @var $cont_title
 * @var $btn_text
 * @var $link
 * @var $btn_icon
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Tab
 */
 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$href = vc_build_link( $link );

$btn = $btn_text == '' ? '' : '
			<a class="btn extra-color text-uppercase" href="'.esc_url($href['url']).'">
				<span class="ef '.esc_attr($btn_icon).'"></span>
				<span>'.wp_kses_post($btn_text).'</span>
			</a>';
			
$out = '
		<div id="tab-' . esc_attr(( empty( $tab_id ) ? sanitize_title( $title ) : $tab_id )) . '" class="tab-pane fade">
			<h3>'.wp_kses_post($cont_title).'</h3>
			'.do_shortcode($content).'
			'.$btn.'
		</div>
	';

echo $out;