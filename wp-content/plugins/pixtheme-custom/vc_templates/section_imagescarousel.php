<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $images
 * @var $img_size
 * @var $autoplay
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Imagescarousel
 */
 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$out = $temp_out = '';

wp_enqueue_script( 'autozone_carousel_js' );
wp_enqueue_style( 'autozone_carousel_css' );

$images = explode( ',', $images );
$autoplay = is_numeric($autoplay) && $autoplay == '1' ? 'true' : 'false';

foreach( $images as $image ){
	if ( $image > 0 ) {
		$img_thumbnail = wpb_getImageBySize( array( 'attach_id' => $image, 'thumb_size' => $img_size, 'class' => 'img-responsive' ) );
		$image_meta = autozone_wp_get_attachment($image);
		$image_title = $image_meta['title'];
	} else {
		$img_thumbnail = array();
		$img_thumbnail['thumbnail'] = '<img src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
		$img_thumbnail['p_img_large'][0] = vc_asset_url( 'vc/no_image.png' );
	}

	if (!filter_var($image_title, FILTER_VALIDATE_URL) === false) {
	    $temp_out .=	'
			<div class="slider-gallery__item">
				<a class="slider-gallery__link" href="'.esc_url($image_title).'" >
					'.$img_thumbnail['thumbnail'].'
                    <div class="slider-gallery__hover">
                        <i class="icon icon_video-link icon-control-play"></i>
                        <div class="slider-gallery__title"></div>
                    </div>
                </a>
            </div>
		';
	} else {
	    $temp_out .= '
			<div class="slider-gallery__item">
				<a class="slider-gallery__link" href="'.esc_url($img_thumbnail['p_img_large'][0]).'">
					'.$img_thumbnail['thumbnail'].'
                    <div class="slider-gallery__hover">
                        <i class="icon icon-magnifier-add"></i>
                        <div class="slider-gallery__title">'.wp_kses_post($image_title).'</div>
                    </div>
                </a>
            </div>
		';
	}

}
$out = $css_animation != '' ? '<div class="animated" data-animation="' . esc_attr($css_animation) . '">' : '<div>';
$out .= '
	<div class="slider-gallery owl-carousel owl-theme owl-theme_mod-a enable-owl-carousel" data-min480="2" data-min768="3" data-min992="4" data-min1200="4" data-pagination="true" data-navigation="false" data-stop-on-hover="true" data-auto-play="'.esc_attr($autoplay).'">

        '.$temp_out.'
        	   
	</div>
	
</div>
	';	
echo $out;