<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $width
 * @var $css
 * @var $offset
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column
 */
$el_class = $width = $css = $offset = $bg_image_src = '';
$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$width = wpb_translateColumnWidthToSpan( $width );
$width = vc_column_offset_class_merge( $offset, $width );

$jclass = $bgstyle == 'jarallax' ? 'vc_row_use_jarallax' : '';
$class_preset_text = ($ptextcolor) ? ' text-'.strtolower($ptextcolor) : '';
if ($ptextcolor == "Default")
	$class_preset_text = "";
$class_bg = $bgstyle == 'attachment' && !empty($bgimage) ? 'background-attachment-fixed' : '';
if( !empty($bgimage) ){
	$bg_image_id = preg_replace( '/[^\d]/', '', $bgimage );
	$bg_image_src = wp_get_attachment_image_src( $bg_image_id, 'full' );
	if ( ! empty( $bg_image_src[0] ) ) {
		$bg_image_src = $bg_image_src[0];
	}
}

$css_classes = array(
	$this->getExtraClass( $el_class ),
	'wpb_column',
	'vc_column_container',
	$width,
	$jclass,
	$class_preset_text,
);

if (vc_shortcode_custom_css_has_property( $css, array('border', 'background') )) {
	$css_classes[]='vc_col-has-fill';
}

$wrapper_attributes = array();

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
if($bgstyle == 'attachment' && !empty($bgimage)) {
	$output .= '<div class="vc_column-inner ' . esc_attr($class_bg) . ' ' . esc_attr(trim(vc_shortcode_custom_css_class($css))) . '" style="background-image:url(' . esc_attr($bg_image_src) . ')" >';
}else{
	$output .= '<div class="vc_column-inner ' . esc_attr(trim(vc_shortcode_custom_css_class($css))) . '" >';
}
$output .= '<div class="wpb_wrapper">';

if($bgstyle == 'jarallax' && !empty($bgimage) ){
	wp_enqueue_script( 'jarallax' );
	$output .= '<div class="jarallax"';
	$arr_jarallax = array();
	if($jartype != 'Default' && $jartype != '')
		$arr_jarallax['type'] = $jartype;
	if($jarspeed != '')
		$arr_jarallax['speed'] = $jarspeed;
	if(empty($arr_jarallax))
		$arr_jarallax['speed'] = '0.2';
	$output .= ' data-jarallax=\''.json_encode($arr_jarallax).'\''; // parallax image
	$output .= ' style="background-image:url(' . esc_attr($bg_image_src) . ')"'; // parallax image
	$output .= '>
	<div class="jarallax-content">
		<div class="jarallax-content-inner">';
}

$output .= wpb_js_remove_wpautop( $content );

if( $bgstyle == 'jarallax' ){
	$output .= '</div></div></div>';
}

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;
