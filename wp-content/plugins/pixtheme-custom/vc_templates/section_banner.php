<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $adv_title
 * @var $use_decor
 * @var $image1
 * @var $img_text1
 * @var $link1
 * @var $image2
 * @var $img_text2
 * @var $link2
 * @var $image3
 * @var $img_text3
 * @var $link3
 * @var $image4
 * @var $img_text4
 * @var $link4
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Banner
 */
 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$href1 = vc_build_link( $link1 );
$href2 = vc_build_link( $link2 );
$href3 = vc_build_link( $link3 );
$href4 = vc_build_link( $link4 );

if ($href1['url']) {
	$href1_class = '';
}else{
	$href1_class = 'link-img__link_disabled';
}
if ($href2['url']) {
	$href2_class = '';
}else{
	$href2_class = 'link-img__link_disabled';
}
if ($href3['url']) {
	$href3_class = '';
}else{
	$href3_class = 'link-img__link_disabled';
}
if ($href4['url']) {
	$href4_class = '';
}else{
	$href4_class = 'link-img__link_disabled';
}

$img_id = preg_replace( '/[^\d]/', '', $image1 );
$img_link = wp_get_attachment_image_src( $img_id, 'medium' );
$img_link1 = $img_link[0];
$image_meta = autozone_wp_get_attachment($img_id);
$image_alt1 = $image_meta['alt'] == '' ? $image_meta['title'] : $image_meta['alt'];

$img_id = preg_replace( '/[^\d]/', '', $image2 );
$img_link = wp_get_attachment_image_src( $img_id, 'medium' );
$img_link2 = $img_link[0];
$image_meta = autozone_wp_get_attachment($img_id);
$image_alt2 = $image_meta['alt'] == '' ? $image_meta['title'] : $image_meta['alt'];

$img_id = preg_replace( '/[^\d]/', '', $image3 );
$img_link = wp_get_attachment_image_src( $img_id, 'medium' );
$img_link3 = $img_link[0];
$image_meta = autozone_wp_get_attachment($img_id);
$image_alt3 = $image_meta['alt'] == '' ? $image_meta['title'] : $image_meta['alt'];

$img_id = preg_replace( '/[^\d]/', '', $image4 );
$img_link = wp_get_attachment_image_src( $img_id, 'medium' );
$img_link4 = $img_link[0];
$image_meta = autozone_wp_get_attachment($img_id);
$image_alt4 = $image_meta['alt'] == '' ? $image_meta['title'] : $image_meta['alt'];

$out = $css_animation != '' ? '<div class="animated" data-animation="' . esc_attr($css_animation) . '">' : '<div>';

$adv_title = !empty($adv_title) ? '<div class="main-block__label">'.wp_kses_post($adv_title).'</div><div class="decor-1 center-block"></div>' : '';
$decor = isset($use_decor) && $use_decor == true ? '<div class="decor-2"><i class="icon fa fa-caret-down"></i></div>' : '';

$img_text1 = !empty($img_text1) ? '<div class="link-img__wrap-title"><span class="link-img__title">'.wp_kses_post($img_text1).'</span></div>' : '';
$img_text2 = !empty($img_text2) ? '<div class="link-img__wrap-title"><span class="link-img__title">'.wp_kses_post($img_text2).'</span></div>' : '';
$img_text3 = !empty($img_text3) ? '<div class="link-img__wrap-title"><span class="link-img__title">'.wp_kses_post($img_text3).'</span></div>' : '';
$img_text4 = !empty($img_text4) ? '<div class="link-img__wrap-title"><span class="link-img__title">'.wp_kses_post($img_text4).'</span></div>' : '';

$out .= '
	<div class="col-xs-12">
		<div class="main-block text-center">
			'.$adv_title.'
			<h1 class="main-block__title"><strong>'.wp_kses_post($title).'</strong>'.esc_html(do_shortcode($content)).'</h1>
			'.$decor.'
		</div>
		<div class="wrap-link-img">
			<ul class="link-img link-img_mod-a list-inline">
				<li class="link-img__item">
					<a class="link-img__link '.$href1_class.'" href="'.esc_url($href1['url']).'">
						<img class="img-responsive" src="'.esc_url($img_link1).'" height="250" width="170" alt="'.esc_attr($image_alt1).'">
						'.$img_text1.'
					</a>
				</li>
				<li class="link-img__item">
					<a class="link-img__link '.$href2_class.'" href="'.esc_url($href2['url']).'">
						<img class="img-responsive" src="'.esc_url($img_link2).'" height="250" width="170" alt="'.esc_attr($image_alt2).'">
						'.$img_text2.'
					</a>
				</li>
			</ul>
			<ul class="link-img link-img_mod-b list-inline">
				<li class="link-img__item">
					<a class="link-img__link '.$href3_class.'" href="'.esc_url($href3['url']).'">
						<img class="img-responsive" src="'.esc_url($img_link3).'" height="250" width="170" alt="'.esc_attr($image_alt3).'">
						'.$img_text3.'
					</a>
				</li>
				<li class="link-img__item">
					<a class="link-img__link '.$href4_class.'" href="'.esc_url($href4['url']).'">
						<img class="img-responsive" src="'.esc_url($img_link4).'" height="250" width="170" alt="'.esc_attr($image_alt4).'">
						'.$img_text4.'
					</a>
				</li>
			</ul>
		</div>
	</div>';

$out .= '</div>';
echo $out;