<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $full_width
 * @var $full_height
 * @var $content_placement
 * @var $parallax
 * @var $parallax_image
 * @var $css
 * @var $el_id
 * @var $video_bg
 * @var $video_bg_url
 * @var $video_bg_parallax
 * @var $content - shortcode content
	$pbgslides
	$pdecor
	$pdecor_color
	$ptextcolor
	$ppadding
    $bgstyle
    $jartype
	$jarspeed
	
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Row
 */
$el_class = $full_height = $parallax_speed_bg = $parallax_speed_video = $full_width = $equal_height = $flex_row = $columns_placement = $content_placement = $parallax = $parallax_image = $css = $el_id = $video_bg = $video_bg_url = $video_bg_parallax = '';
$disable_element = '';
$output = $after_output = $class_slider = $pix_bg_class = $pix_bg_color = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


wp_enqueue_script( 'wpb_composer_front_js' );


$ppadding = $ppadding == '' ? 'pix-vc_row-no-padding' : $ppadding;

/////////////////////////////////////////////
$class_preset_text = ($ptextcolor) ? ' text-'.strtolower($ptextcolor) : '';
if ($ptextcolor == "Default")
	$class_preset_text = "";

$class_bg = $bgstyle == 'attachment' && !empty($bgimage) ? 'background-attachment-fixed' : '';
$jarstretch = $jarstretch == '' ? 'No' : $jarstretch;
if( !empty($bgimage) ){
	$bg_image_id = preg_replace( '/[^\d]/', '', $bgimage );
	$bg_image_src = wp_get_attachment_image_src( $bg_image_id, 'full' );
	if ( ! empty( $bg_image_src[0] ) ) {
		$bg_image_src = $bg_image_src[0];
	}
}

if( in_array($pdecor, array('both', 'top')) ) {
	$pix_bg_color = $pdecor_color == 'colorize' ? 'mod-b' : 'mod-a';
} elseif( $pdecor == 'main-slider-old'){
	$pix_bg_class = 'main-slider-old';
}

/////////////////////////////////////////////

$el_class = $this->getExtraClass( $el_class );

$css_classes = array(
	'vc_row',
	'wpb_row', //deprecated
	'vc_row-fluid',
	$el_class,
	$ppadding,
	$pix_bg_class,
	$class_preset_text,
	vc_shortcode_custom_css_class( $css ),
);

if ( 'yes' === $disable_element ) {
	if ( vc_is_page_editable() ) {
		$css_classes[] = 'vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md';
	} else {
		return '';
	}
}

if (vc_shortcode_custom_css_has_property( $css, array('border', 'background') ) || $video_bg || $parallax) {
	$css_classes[]='vc_row-has-fill';
}

if (!empty($atts['gap'])) {
	$css_classes[] = 'vc_column-gap-'.$atts['gap'];
}

$wrapper_attributes = array();
// build attributes for wrapper
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
if ( ! empty( $full_width ) ) {
	$wrapper_attributes[] = 'data-vc-full-width="true"';
	$wrapper_attributes[] = 'data-vc-full-width-init="false"';
	if ( 'stretch_row_content' === $full_width ) {
		$wrapper_attributes[] = 'data-vc-stretch-content="true"';
	} elseif ( 'stretch_row_content_no_spaces' === $full_width ) {
		$wrapper_attributes[] = 'data-vc-stretch-content="true"';
		$css_classes[] = 'vc_row-no-padding';
	}
	$after_output .= '<div class="vc_row-full-width vc_clearfix"></div>';
}

if ( ! empty( $full_height ) ) {
	$css_classes[] = 'vc_row-o-full-height';
	if ( ! empty( $columns_placement ) ) {
		$flex_row = true;
		$css_classes[] = 'vc_row-o-columns-' . $columns_placement;
		if ( 'stretch' === $columns_placement ) {
			$css_classes[] = 'vc_row-o-equal-height';
		}
	}
}

if ( ! empty( $equal_height ) ) {
	$flex_row = true;
	$css_classes[] = 'vc_row-o-equal-height';
}

if ( ! empty( $content_placement ) ) {
	$flex_row = true;
	$css_classes[] = 'vc_row-o-content-' . $content_placement;
}

if ( ! empty( $flex_row ) ) {
	$css_classes[] = 'vc_row-flex';
}

$has_video_bg = ( ! empty( $video_bg ) && ! empty( $video_bg_url ) && vc_extract_youtube_id( $video_bg_url ) );

$parallax_speed = $parallax_speed_bg;
if ( $has_video_bg ) {
	$parallax = $video_bg_parallax;
	$parallax_speed = $parallax_speed_video;
	$parallax_image = $video_bg_url;
	$css_classes[] = 'vc_video-bg-container';
	wp_enqueue_script( 'vc_youtube_iframe_api_js' );
}

if ( ! empty( $parallax ) && empty($bgstyle) ) {
	wp_enqueue_script( 'vc_jquery_skrollr_js' );
	$wrapper_attributes[] = 'data-vc-parallax="' . esc_attr( $parallax_speed ) . '"'; // parallax speed
	$css_classes[] = 'vc_general vc_parallax vc_parallax-' . $parallax;
	if ( false !== strpos( $parallax, 'fade' ) ) {
		$css_classes[] = 'js-vc_parallax-o-fade';
		$wrapper_attributes[] = 'data-vc-parallax-o-fade="on"';
	} elseif ( false !== strpos( $parallax, 'fixed' ) ) {
		$css_classes[] = 'js-vc_parallax-o-fixed';
	}
	$paralax_fix_before = '<div class="anchor-parallax-fix">';
	$paralax_fix_after = '</div> <!-- END anchor-parallax-fix -->';
}

if ( ! empty( $parallax_image ) && empty($bgimage)  ) {
	if ( $has_video_bg ) {
		$parallax_image_src = $parallax_image;
	} else {
		$parallax_image_id = preg_replace( '/[^\d]/', '', $parallax_image );
		$parallax_image_src = wp_get_attachment_image_src( $parallax_image_id, 'full' );
		if ( ! empty( $parallax_image_src[0] ) ) {
			$parallax_image_src = $parallax_image_src[0];
		}
	}
	$wrapper_attributes[] = 'data-vc-parallax-image="' . esc_attr( $parallax_image_src ) . '"';
}
if ( ! $parallax && $has_video_bg ) {
	$wrapper_attributes[] = 'data-vc-video-bg="' . esc_attr( $video_bg_url ) . '"';
}
$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( array_unique( $css_classes ) ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

if( in_array($pdecor, array('both', 'top')) ){
	$output .= '<div class="wrap-section-border"><div class="bg_inner border-section-top border-section-top_'.esc_attr($pix_bg_color).'"></div></div>';
}

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';
if(!empty($pdecor_col_main)){
	$uniq_class = 'vc-'. md5(uniqid(rand(), true));

	$output .= '<div class="vdecore-bottom '. $uniq_class .'"><div class="decor-wrap">' . '<style>
        .vdecore-bottom.'.$uniq_class.':after, .vdecore-bottom.'.$uniq_class.':before {
            background-color: ' . $pdecor_col_main . ';
        }
    </style>' . '</div></div>';
}


if($bgstyle == 'jarallax' && !empty($bgimage) ){
	wp_enqueue_script( 'jarallax' );
	$class_jarallax = $class_jarallax_inner = '';
	if ( ! empty( $full_width ) ) {
		$class_jarallax = 'jarallax-full-width';
		if ( 'stretch_row_content' === $full_width ) {
			$class_jarallax = 'jarallax-full-width-content';
		} elseif ( 'stretch_row_content_no_spaces' === $full_width ) {
			$class_jarallax = 'jarallax-full-width-content-no-padding';
		}
	}
	$class_jarallax_inner = ! empty( $full_width ) && $jarstretch == "No" ? 'container' : 'jarallax-content-inner';
	$output .= '<div class="jarallax '.esc_attr($class_jarallax).'"';
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
		<div class="'.esc_attr($class_jarallax_inner).'">';
}elseif(!empty($bgimage)){
	$output .= '<div class="'.esc_attr($class_bg).'" style="background-image:url(' . esc_attr($bg_image_src) . ')">';
}

preg_match_all( '/{([^\}]+)/i', $css, $matches, PREG_OFFSET_CAPTURE );
if(isset($matches[1][0][0])){
	foreach( explode( ';', $matches[1][0][0] ) as $val ){
		if( substr_count($val, 'background')>0 && substr_count($val, 'rgba')>0 ){
			foreach( explode( ' ', $val ) as $val_exp ){
				if( substr_count($val_exp, 'rgba')>0 ){
					$output .= '<span class="vc_row-overlay" style="background-color: '.$val_exp.' !important;"></span>';
				}
			}
		}
	}
}

$output .= wpb_js_remove_wpautop( $content );

if( in_array($pdecor, array('both', 'bottom')) ){
	$output .= '<div class="border-section-bottom"></div>';
}

if( $bgstyle == 'jarallax' ){
	$output .= '</div></div>';
}
if( !empty($bgimage) ){
	$output .= '</div>';
}

$output .= '</div>';
$output .= $after_output;

echo $output;