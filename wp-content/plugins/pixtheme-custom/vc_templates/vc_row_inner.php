<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $css
 * @var $el_id
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Row_Inner
 */
$el_class = $css = $el_id = $jclass = $bg_image_src = '';
$output = $after_output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$disable_element = '';

extract( $atts );

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

$el_class = $this->getExtraClass( $el_class );
$css_classes = array(
	'vc_row',
	'wpb_row', //deprecated
	'vc_inner',
	'vc_row-fluid',
	$el_class,
	$jclass,
	$class_bg,
	$class_preset_text,
	vc_shortcode_custom_css_class( $css ),
);
$wrapper_attributes = array();
// build attributes for wrapper
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}

if ( 'yes' === $disable_element ) {
    if ( vc_is_page_editable() ) {
        $css_classes[] = 'vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md';
    } else {
        return '';
    }
}


$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
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
}elseif(!empty($bgimage)){
	$output .= '<div class"theme-options-bgimage" style="background-image:url(' . esc_attr($bg_image_src) . ')">';
}

$output .= wpb_js_remove_wpautop( $content );

if( $bgstyle == 'jarallax' ){
	$output .= '</div></div>';
}
if( !empty($bgimage) ){
	$output .= '</div>';
}

$output .= '</div>';
$output .= $after_output;

echo ''.$output;