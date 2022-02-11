<?php
global $post, $PIXAD_Autos;
$Settings = new PIXAD_Settings();
$settings = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );

$validate = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_validation', true ); // Get validation settings


$showInList = pixad::getlistviewfields($validate);
//print_r($showInList);

$validate = pixad::validation( $validate ); // Fix undefined index notice

$auto_translate = unserialize( get_option( '_pixad_auto_translate' ) );
?>
    <?php while ( have_posts() ) : the_post(); ?>

      <?php 
      $comment_args = array( 'status' => 'approve', 'post_id' => $post->ID, );
      $comments = get_comments($comment_args);
      $post_rating = [];
      foreach($comments as $comment){
        $post_rating[] = floatval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
      }
       ?>
        <article class="card clearfix" id="post-<?php the_ID(); ?>">
            <div class="card__img">
                <?php if( has_post_thumbnail() ): ?>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('autozone-auto-cat', array('class' => 'img-responsive')); ?>
                    </a>
                <?php else: ?>
                    <img class="no-image" src="<?php echo PIXAD_AUTO_URI .'assets/img/no_image.jpg'; ?>" alt="no-image">
                <?php endif; ?>

                <?php if( get_post_meta(get_the_ID(), 'pixad_auto_featured_text', true) ): ?>
                    <span class="card__wrap-label"><span class="card__label"><?php echo  get_post_meta( get_the_ID(), 'pixad_auto_featured_text', true ); ?></span></span>
                <?php endif; ?>

                <?php if( $PIXAD_Autos->get_meta('_auto_sale_price') != '' ): ?>
                    <span class="card__wrap-label sale"><?php esc_html_e( 'Sale', 'autozone' ); ?></span>
                <?php endif; ?>
                <?php do_action( 'autozone_autos_single_auto_img', $post ); ?>

            </div>
            <div class="card__inner">
                <h2 class="card__title ui-title-inner"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div class="decor-1"></div>
                <?php if(!empty($post_rating)):?>
                      <div class="star-rating"><span style="width:<?php echo  esc_html( array_sum($post_rating)/count($post_rating) * 20 );?>%"></span></div>
                <?php endif;?>
              <div class="card__desc_wrap">
                <div class="card__description">
                    <p><?php if( has_excerpt() ){
                        the_excerpt();
                        } ?></p>
                </div>
               
                <!-- Car Details -->
                <ul class="card__list list-unstyled">



            <?php foreach ($showInList as $id => $sideAttribute):?>
                  <?php   

                    $settingName =  $showInList[$id]['title'];
                    $settingName = trim($settingName);

               //       $settingName = esc_html__( $settingName.':', 'autozone' );

                    $id='_'.$id; 
                    $id = str_replace('-', '_', $id); 
                    ?>
                   <?php  if( $PIXAD_Autos->get_meta($id) ): ?>
                        <li class="card-list__row">
                      <?php
                      $val_attr =  $PIXAD_Autos->get_meta($id);
                      if(!empty($auto_translate[$val_attr])  ){   
                       //   echo esc_html($auto_translate[$val_attr]);
?>
                              <span class="card-list__title">
                                 <?php

                                    if ($settingName) {
                                     //  esc_html_e( $settingName.':', 'autozone' ); 
                                      echo esc_html($auto_translate[$settingName]).": ";
                                    } else{
                                        $customId = substr( $id, 1);
                                        $сustomSettingName  = $validate[$customId.'_name'];
                                        echo   esc_html($сustomSettingName); 

                                    }

                                ?></span>
                              <span class="card-list__info">
                                <?php 
                                   echo esc_html($auto_translate[$val_attr]); 
                                 ?>
                              </span>
                     <?php }else{ ?>
                              <span class="card-list__title">
                                <?php

                                    if ($settingName) {
                                 //   esc_html_e( $settingName.':', 'autozone' ); 
                                       echo esc_html($auto_translate[$settingName]).": ";
                                    } else{
                                        $customId = substr( $id, 1);
                                        $сustomSettingName  = $validate[$customId.'_name'];
                                        echo   esc_html($сustomSettingName); 

                                    }

                                ?></span>

                              <span class="card-list__info">
                                <?php 
                                if ($id == '_auto_mileage') {
                                    echo number_format($PIXAD_Autos->get_meta('_auto_mileage'), 0, '', "{$settings['autos_thousand']}");                                                
                                }else{
                                    echo esc_html($PIXAD_Autos->get_meta($id)); 
                                }
                               // echo $id
                                    if ($id == '_auto_horsepower') {
                                      echo " ";  esc_html_e( 'hp', 'autozone' );
                                    }elseif ($id == '_auto_engine') {
                                      echo " ";   esc_html_e( 'cm3', 'autozone' );
                                    }elseif ($id == '_auto_doors') {
                                      echo " ";   esc_html_e( 'doors', 'autozone' );
                                    }

                                 ?>
                              </span>
                     <?php } ?>
                         </li>
                   <?php endif; ?>

               <?php endforeach;?>

               <?php if(array_key_exists('auto-date', $showInList)  && $validate['auto-date_show'] && get_the_date() ): ?>
                   <li><span class="card-list__title"><?php esc_html_e( 'Updated :', 'autozone' ); ?></span>
                  <span><?php echo get_the_date(); ?></span></li>
               <?php endif; ?>
                   

                </ul><!-- / Car Details -->
</div> 
              	<?php if( $validate['auto-price_show'] && $PIXAD_Autos->get_meta('_auto_price') ): ?>
                <?php $price = is_numeric($PIXAD_Autos->get_meta('_auto_price')) || $PIXAD_Autos->get_meta('_auto_price') == ''  ? $PIXAD_Autos->get_price() : $auto_translate[$PIXAD_Autos->get_price()]; ?>
                    <div class="card__price"><?php esc_html_e( 'PRICE:' , 'autozone') ?><span class="card__price-number"><?php echo wp_kses_post($price); ?></span></div>
                <?php endif; ?>

                  <?php  
                    $gallery = array();
                    $values = get_post_custom($post->ID);
                    if(class_exists('Pix_Autos')) {
                        if (isset( $values['pixad_auto_gallery_2'][0])) {
                            $gallery = json_decode( pix_baseencode($values['pixad_auto_gallery_2'][0]));
                        }
                    }

                    
                  if(isset( $values['pixad_auto_gallery_2'][0]) && $gallery[0]  !== '-1') {
                            if (!empty($gallery) && array_key_exists('1', $gallery )) {
                                $listClass = 'auto-promo-inline';
                            }else{
                                $listClass ='';
                            }
                            echo "<div class='promo_gallery_wrapper ". $listClass."'><ul>";

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
                               echo '<li>'.$image.'</li>';                  
                          } if(isset( $values['pixad_auto_gallery_2'][0]) && $gallery[0]  !== '-1') {
                      echo "</ul></div>";
                    }?>


            </div>

        </article>
    <?php endwhile; ?>


