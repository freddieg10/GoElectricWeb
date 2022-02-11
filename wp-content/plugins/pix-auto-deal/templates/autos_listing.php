<?php
if( ! defined( 'ABSPATH' ) ) 
  exit; // Exit if accessed directly
global  $PIXAD_Autos, $post;
$auto_translate = unserialize( get_option( '_pixad_auto_translate' ) );

if ($autozone_loop->have_posts()) {
while ( $autozone_loop->have_posts() ) : $autozone_loop->the_post();

$comment_args = array( 'status' => 'approve', 'post_id' => get_the_ID(), );
$comments = get_comments($comment_args);
$post_rating = [];
foreach($comments as $comment){
  $post_rating[] = floatval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
}

  $pixad_out .= '

  <article class="card clearfix" id="post-'.get_the_ID().'">
    <div class="card__img">';
      if( has_post_thumbnail() ):
        $pixad_out .= '<a href="'.get_the_permalink().'">
          '.get_the_post_thumbnail( get_the_ID(), 'autozone-auto-cat', array('class' => 'img-responsive')).'
        </a>';
      else:
        $pixad_out .= '<img class="no-image" src="'.PIXAD_AUTO_URI .'assets/img/no_image.jpg" alt="no-image">';
      endif;
      if( get_post_meta(get_the_ID(), 'pixad_auto_featured_text', true) ){ 
        $pixad_out .= '<span class="card__wrap-label"><span class="card__label">'.get_post_meta(get_the_ID(), 'pixad_auto_featured_text', true).'</span></span>';   
      }



if (is_plugin_active('compare-cars/compare-cars.php')) { 
      $pixad_out .=  '<div class="tmpl-list-footer">
        <a class="add-to-compare" data-id="'.get_the_ID().'"data-action="add">
            <span class="add-cmpr"> 
            <i class="icon-speedometer" aria-hidden="true"></i><em class="cmpr-btn-text">Add To Compare</em></span>
            
            <span class="rem-cmpr">
            <i class="icon-speedometer" aria-hidden="true"></i><em class="cmpr-btn-text">Remove From Compare</em></span>   
        </a>';
        if(empty(get_option('compare_cars_templ')) || empty(get_option('compare_cars_templ')['no_favorite'])) :
          $pixad_out .=  '  <a class="car-favorite" data-id="'.get_the_ID().'" data-action="add-favorite">
             <span class="add-fvrt"> 
            <i class="fa fa-star-o"></i>
            </span>
            <span class="rem-fvrt"> 
            <i class="fa fa-star-o"></i>
            </span>
        </a></div>';
        endif;
}


  $pixad_out .= '</div></div>
    <div class="card__inner">
      <h2 class="card__title ui-title-inner"><a href="'.get_the_permalink().'" title="'.esc_attr($strip_title).'">'.get_the_title().'</a></h2>
      <div class="decor-1"></div>';
          if(!empty($post_rating)):
              $pixad_out .= '<div class="star-rating"><span style="width:'.  esc_html( array_sum($post_rating)/count($post_rating) * 20 ).'%"></span></div>';
          endif;

                $pixad_out .= '<div class="card__desc_wrap"> <div class="card__description">';
                  if( has_excerpt() ){
                $pixad_out .= '<p>'.get_the_excerpt().'</p>';
                        }


   $pixad_out .= '   </div>
      <!-- Car Details -->
      <ul class="card__list list-unstyled">';
         foreach ($showInList as $id => $sideAttribute):
                  
                    $settingName = $showInList[$id]['title'];
                    $id='_'.$id; 
                    $id = str_replace('-', '_', $id); 
          
                    if( $PIXAD_Autos->get_meta($id) ) {
                      $pixad_out .= '<li class="card-list__row">';
                      
                      $val_attr =  $PIXAD_Autos->get_meta($id);
                       if(!empty($auto_translate[$val_attr])  ){   
                        //   echo esc_html($auto_translate[$val_attr]);
                            $pixad_out .= '<span class="card-list__title">';
                                     if ($settingName) {
                                      //  $pixad_out .= __($settingName.':', 'pixad' ); 
                                     $pixad_out .= esc_html($auto_translate[$settingName]).": ";
                                     } else{
                                         $customId = substr( $id, 1);
                                         $сustomSettingName  = $validate[$customId.'_name'];
                                         $pixad_out .=    $сustomSettingName; 
                                     }

                               $pixad_out .= '  </span>
                               <span class="card-list__info"> ';
                                 
                                  $pixad_out .= esc_html($auto_translate[$val_attr]); 
                                 
                               $pixad_out .= ' </span> ';
                      }else{ 
                             $pixad_out .= '   <span class="card-list__title '.$settingName.'"> ';

                                     if ($settingName) {
                                       //  $pixad_out .= __($settingName.':', 'pixad' );
                                      $pixad_out .= esc_html($auto_translate[$settingName]).": ";
                                     } else{
                                         $customId = substr( $id, 1);
                                         $сustomSettingName  = $validate[$customId.'_name'];
                                          $pixad_out .=  $сustomSettingName; 

                                     }
                               $pixad_out .= '   </span> 
                               <span class="card-list__info"> ';
                                 if ($id == '_auto_mileage') {
                                     $pixad_out .= number_format($PIXAD_Autos->get_meta('_auto_mileage'), 0, '', "{$settings['autos_thousand']}");                                                
                                 }else{
                                     $pixad_out .= esc_html($PIXAD_Autos->get_meta($id)); 
                                 }
                                  // echo $id
                                     if ($id == '_auto_horsepower') {
                                        $pixad_out .= ' '. __( 'hp', 'pixad' );
                                     }elseif ($id == '_auto_engine') {
                                       $pixad_out .= ' '. __( 'cm3', 'pixad' );
                                     }elseif ($id == '_auto_doors') {
                                       $pixad_out .= ' '. __( 'doors', 'pixad' );
                                     }
                             $pixad_out .= '  </span> ';
                     } 
                          $pixad_out .= ' </li> ';    
                  }                     
          endforeach;

        if(array_key_exists('auto-date', $showInList)  && $validate['auto-date_show'] && get_the_date() ){
                  $pixad_out .= ' <li><span class="card-list__title">'. __( 'Updated :', 'pixad' ) .'</span> ';
                 $pixad_out .= ' <span>'. get_the_date() .'</span></li>';
            }


      $pixad_out .= '
      </ul><!-- / Car Details --></div> ';

      if( $validate['auto-price_show'] ):
        $custom_price_catalog = get_post_meta( $post->ID, 'custom_price_catalog', 1 );
        $price_catalog = $custom_price_catalog ? $custom_price_catalog : $this->get_price();
        $price_catalog = is_numeric($this->get_meta('_auto_price')) || $this->get_meta('_auto_price') == '' ? $this->get_price() : $auto_translate[$this->get_price()];
        $pixad_out .= '<div class="card__price">'.esc_html__( 'PRICE:' , 'pixad').'<span class="card__price-number">'.wp_kses_post($price_catalog).'</span></div>';
      endif;


        $gallery = array();
                    $values = get_post_custom($post->ID);
                    $gallery = json_decode(base64_decode( $values['pixad_auto_gallery_2'][0]));
                  if(isset( $values['pixad_auto_gallery_2'][0]) && $gallery[0]  !== '-1') {
                        
                         if (array_key_exists('1', $gallery )) {
                          $listClass = 'auto-promo-inline';
                        }else{
                          $listClass ='';
                        }
                        $pixad_out .= "<div class='promo_gallery_wrapper ". $listClass."'><ul>"; 
                    }
                    if(isset($gallery[0]) && !empty($gallery[0]) && $gallery[0]  !== '-1')  {
                        // The json decode and base64 decode return an array of image ids
                        $attachment_ids = $gallery;
                    }else{
                        $attachment_ids = array();
                    }
  foreach ( $attachment_ids as $attachment_id ) {
                            //  $image       = wp_get_attachment_image( $attachment_id, 'autozone-auto-single_crop' );
                              $image       = wp_get_attachment_image( $attachment_id, 'autozone-thumb' );
                               $pixad_out .= '<li>'.$image.'</li>';                  
                          } if(isset( $values['pixad_auto_gallery_2'][0]) && $gallery[0]  !== '-1') {
                      $pixad_out .= "</ul></div>";
                    }



  $pixad_out .= '
    </div>

  </article>';
endwhile;
}else{
  $no_found_text = htmlspecialchars_decode($settings['autos_no_found']);
  $pixad_out .= '<div>'.  $no_found_text .' </div>';
}
$pixad_out .= $this->pagenavi($autozone_loop->max_num_pages, $_REQUEST['paged']);

?>
