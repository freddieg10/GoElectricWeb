<?php
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Customauto
 */
 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

global $post, $PIXAD_Autos;

$Settings = new PIXAD_Settings(); 
$settings = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );

$validate = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_validation', true ); // Get validation settings

$showInSidebar = pixad::getsideviewfields($validate);
$validate = pixad::validation( $validate ); // Fix undefined index notice

$post_id = esc_attr($auto);
$args = array(
			'post_status' => 'publish',
			'post_type' => 'pixad-autos',
			'p' => $post_id
		);
$wp_query = new WP_Query( $args );
while ($wp_query->have_posts()) : 							
		$wp_query->the_post();

$comment_args = array( 'status' => 'approve', 'post_id' => get_the_ID(), );
$comments = get_comments($comment_args);
$post_rating = [];
foreach($comments as $comment){
  $post_rating[] = floatval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
}
     $pixad_out = '
         <div class="slider-grid__inner slider-grid__inner_mod-b custom-auto-'.esc_attr($style).' '.esc_attr($class_name).'">
              <div class="card__img">';
                    if( has_post_thumbnail() ):
                        $pixad_out .= '<a href="'.get_the_permalink().'">
                    '.get_the_post_thumbnail( get_the_ID(), 'autozone_latest_item', array('class' => 'img-responsive')).'</a>';
                    else:
                        $pixad_out .= '<img class="no-image" src="'.PIXAD_AUTO_URI .'assets/img/no_image.jpg" alt="no-image">';
                    endif;

                    if( get_post_meta(get_the_ID(), 'pixad_auto_featured_text', true) ){
                        $pixad_out .= '<span class="card__wrap-label"><span class="card__label">'.get_post_meta(get_the_ID(), 'pixad_auto_featured_text', true).'</span></span>';
                    }              
                    if( $validate['auto-price_show'] && $PIXAD_Autos->get_meta('_auto_price') ):
                        $pixad_out .= '<span class="slider-grid__price_wrap"><span class="slider-grid__price"><span>'.wp_kses_post($PIXAD_Autos->get_price()).'</span></span></span>';
                    endif;

                    if (function_exists('compare_cars_script_987')) { 
                        $pixad_out .='<div class="tmpl-list-footer">
                                        <a class="add-to-compare" data-id="'.get_the_ID().'"data-action="add">
                                            <span class="add-cmpr"> 
                                                <i class="icon-speedometer" aria-hidden="true"></i>
                                                <em class="cmpr-btn-text">Add To Compare</em>
                                            </span>           
                                            <span class="rem-cmpr">
                                               <i class="icon-speedometer" aria-hidden="true"></i>
                                               <em class="cmpr-btn-text">Remove From Compare</em>
                                            </span>   
                                        </a>';
                                        if(empty(get_option('compare_cars_templ')) || empty(get_option('compare_cars_templ')['no_favorite'])) :
                       $pixad_out .=  '<a class="car-favorite" data-id="'.get_the_ID().'" data-action="add-favorite">
                                          <span class="add-fvrt"> 
                                            <i class="fa fa-star-o"></i>
                                          </span>
                                          <span class="rem-fvrt"> 
                                            <i class="fa fa-star-o"></i>
                                          </span>
                                        </a>';
                                       endif;
                      $pixad_out .= '</div>';
                    }
$pixad_out .= '</div>';
$pixad_out .= '<div class="tmpl-gray-footer">
                  <span class="tmpl-slider-grid__name">'.get_the_title().'</span> ';
                    if(!empty($post_rating)):
                        $pixad_out .= '<div class="star-rating"><span style="width:'.  esc_html( array_sum($post_rating)/count($post_rating) * 20 ).'%"></span></div>';
                    endif;
                $pixad_out .= '<ul class="tmpl-slider-grid__info list-unstyled">';
                  foreach ($showInSidebar as $id => $sideAttribute):
                     $id='_'.$id; 
                     $id = str_replace('-', '_', $id);
                     if( $PIXAD_Autos->get_meta($id) ):                     
                        $pixad_out .= '<li><i class="'.  esc_html($sideAttribute['icon']).'"></i>'.  
                             wp_kses_post(ucfirst($PIXAD_Autos->get_meta($id))) .
                        '</li>';  
                     endif; 
                  endforeach;
$pixad_out .= '</ul></div></div>';
endwhile;
	echo $pixad_out;