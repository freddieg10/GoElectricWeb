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
 * @var $border_color
 * @var $link
 * @var $big_info
 * @var $c_box_info1
 * @var $c_box_info2
 * @var $c_box_info3
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Block_Info_Icon
 */
 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$icon = isset( ${"icon_" . $type} ) ? ${"icon_" . $type} : '';
	
$href = vc_build_link( $link );

$border_color = $border_color != '' ? ' style="border-color:'.esc_attr($border_color).'"' : '';
$big_info = $big_info == '' ? '' : '<div class="big-info">'.wp_kses_post($big_info).'</div>';
$c_box_info1 = $c_box_info1 == '' ? '' : '<div class="c-info">'.wp_kses_post($c_box_info1).'</div>';
$c_box_info2 = $c_box_info2 == '' ? '' : '<div class="c-info">'.wp_kses_post($c_box_info2).'</div>';
$c_box_info3 = $c_box_info3 == '' ? '' : '<div class="c-info">'.wp_kses_post($c_box_info3).'</div>';

$out = $css_animation != '' ? '<div class="pix_block_info_icon text-center circle-box circle-box-3 animated" data-animation="' . esc_attr($css_animation) . '">' : '<div class="pix_block_info_icon text-center circle-box circle-box-3">';
$out .= '
	<div class="c-link-box">
		<a class="btn big-circle" href="'.esc_url($href['url']).'" '.$border_color.'>
			<span class="c-content-block">
				<span class="ef '.esc_attr($icon).'"></span>
				<span class="b-text">'.wp_kses_post($title).'</span>
			</span>
		</a>
		<div class="c-box-info">
			'.$big_info.'
			<div class="b-info">'.do_shortcode($content).'</div>
			'.$c_box_info1.'
			'.$c_box_info2.'
			'.$c_box_info3.'
		</div>
	</div>
</div>
'; 

echo $out;