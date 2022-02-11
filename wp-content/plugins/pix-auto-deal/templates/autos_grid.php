<?php
if( ! defined( 'ABSPATH' ) ) 
    exit; // Exit if accessed directly
global  $PIXAD_Autos, $post;
    $Settings = new PIXAD_Settings();
    $settings = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
$auto_translate = unserialize( get_option( '_pixad_auto_translate' ) );
$pixad_out .= '<div class="row">';
if ($autozone_loop->have_posts()) {
while ( $autozone_loop->have_posts() ) : $autozone_loop->the_post();
$comment_args = array( 'status' => 'approve', 'post_id' => get_the_ID(), );
$comments = get_comments($comment_args);
$post_rating = [];
foreach($comments as $comment){
  $post_rating[] = floatval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
}


    $pixad_out .= ' <div class="col-md-4">
                           <div class="slider-grid__inner slider-grid__inner_mod-b">
                               
                                <div class="card__img">';
    if( has_post_thumbnail() ):
            $pixad_out .= '<a href="'.get_the_permalink().'">
                    '.get_the_post_thumbnail( get_the_ID(), 'autozone_latest_item', array('class' => 'img-responsive')).'
                </a>';
    else:
        $pixad_out .= '<img class="no-image" src="'.PIXAD_AUTO_URI .'assets/img/no_image.jpg" alt="no-image">';
    endif;
    if( get_post_meta(get_the_ID(), 'pixad_auto_featured_text', true) ){
                $pixad_out .= '<span class="card__wrap-label"><span class="card__label">'.get_post_meta(get_the_ID(), 'pixad_auto_featured_text', true).'</span></span>';
            }
if( $validate['auto-price_show'] && $this->get_meta('_auto_price') ):
$custom_price_catalog = get_post_meta( $post->ID, 'custom_price_catalog', 1 );
$price_catalog = $custom_price_catalog ? $custom_price_catalog : $this->get_price();
 $price_catalog = is_numeric($this->get_meta('_auto_price')) || $this->get_meta('_auto_price') == '' ? $this->get_price() : $auto_translate[$this->get_price()];
$pixad_out .= '<span class="slider-grid__price_wrap"><span class="slider-grid__price"><span>'.wp_kses_post($price_catalog).'</span></span></span>';
endif;


if (is_plugin_active('compare-cars/compare-cars.php')) { 
        $pixad_out .=  '<div class="tmpl-list-footer">
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
$pixad_out .=  '</div>';
}


$pixad_out .= ' </div><div class="tmpl-gray-footer">                   
          <a class="tmpl-slider-grid__name" href="'.get_the_permalink().'" title="'.esc_attr($strip_title).'">'.get_the_title().'</a>';

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




$pixad_out .= '</ul></div></div></div>';




endwhile;
}else{
$no_found_text = htmlspecialchars_decode($settings['autos_no_found']);
$pixad_out .= '<div>'.  $no_found_text .' </div>';

}

$pixad_out .= '</div>';
$pixad_out .= $this->pagenavi($autozone_loop->max_num_pages, $_REQUEST['paged']);

?>
