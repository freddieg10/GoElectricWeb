<?php
global $post;
/**
 * Shortcode attributes
 * @var $atts
 * @var $cats
 * @var $offers
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Autos_Cat_Models
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$figure = '';

if( $cats == '' ):
	$out = '<p>'.esc_html__('No Models selected. To fix this, please login to your WP Admin area and set the models you want to show by editing this shortcode and setting one or more models in the multi checkbox field "Models".', 'autozone');
else: 

$out = $css_animation != '' ? '<div class="animated" data-animation="' . esc_attr($css_animation) . '">' : '<div>';
$out .= '	
		<div class="models_list_wrapper">
		';

    $include = array();
    foreach(explode(',', $cats) as $val){
        $term = get_term_by('slug', $val, 'auto-model');
        if( isset($term->term_id) ){
            $include[] = $term->term_id;
        }
    }
	$Settings = new PIXAD_Settings();
    $options = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
    $url_page_listings = get_page_uri( $options['autos_listing_car_page']);

	$args = array( 'taxonomy' => 'auto-model', 'hide_empty' => '0', 'include' => implode(',', $include));
	$autos_categories = get_categories ($args);
	if( $autos_categories ):
			foreach($autos_categories as $auto_cat) :
				$auto_t_id = $auto_cat->term_id;
				$auto_cat_meta = get_option("auto_model_$auto_t_id");
				$auto_cat_thumb_url = get_option("pixad_model_thumb$auto_t_id");
			//	$auto_link = get_term_link( $auto_cat ); // OLD

				$auto_link = home_url() . '/' .  $url_page_listings . '/?make=' . $auto_cat->slug ; // NEW

				if($auto_cat_thumb_url){
					$img_src = wp_get_attachment_image_src( attachment_url_to_postid( $auto_cat_thumb_url ), 'autozone-model-thumb' );	
				}else{
						$img_src[0] = ''.get_template_directory_uri().'/img/brand-logo.jpg' ;
				} 
	$out .= '
				
				
			<div class="models_list_item">
			 <a class="mli_link" href="'.esc_url($auto_link).'">
				<div class="mli_img_wrapper" style="background-image: url('.esc_url($img_src[0]).');">
					
				</div>
				<span class="mli_title">
					'.wp_kses_post($auto_cat->name).'
				</span>
				<div class="mli_count">
					<span>'.wp_kses_post($auto_cat->count).'</span>
				</div>
				</a>
			</div>
	';
			 endforeach;
	endif;
 
$out .= '            
			</div>
	';

$out .= '</div>';
endif;	
echo $out;