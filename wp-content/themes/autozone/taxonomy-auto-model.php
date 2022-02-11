<?php 
/* The taxonomy for displaying autos by body type. */
global $post, $PIXAD_Autos;
$Query = false;
$orderby_arr = array('date', 'title');
$data = array_map( 'esc_attr', $_REQUEST );
$args = array();
foreach($data as $key=>$val){
    if( property_exists('PIXAD_Autos', $key) && $key == 'order' ){
        $temp = explode('-', $val);

        if(isset($temp[0]) && in_array($temp[0], $orderby_arr)){
            $PIXAD_Autos->orderby = $temp[0];
            $PIXAD_Autos->order = strtoupper($temp[1]);
            $PIXAD_Autos->metakey = '';
        }
        elseif(isset($temp[0]) && !in_array($temp[0], $orderby_arr)){
            $PIXAD_Autos->orderby = !in_array($temp[0], array('_auto_price','_auto_year')) ? 'meta_value' : 'meta_value_num';
            $PIXAD_Autos->order = strtoupper($temp[1]);
            $PIXAD_Autos->metakey = $temp[0];
        }
    } elseif( property_exists('PIXAD_Autos', $key) && $key == 'per_page' ) {
        $args[$key] = $val;
    } elseif( $key != 'action' && $key != 'nonce'){
        $args[$key] = $val;
    }
}

$args['model'] = get_queried_object()->slug;
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$term_descr = term_description();



global $post, $PIXAD_Autos;
$Settings = new PIXAD_Settings();
$settings = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );

$validate = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_validation', true ); // Get validation settings

$showInSidebar = pixad::getsideviewfields($validate);
$validate = pixad::validation( $validate ); // Fix undefined index notice

$auto_translate = unserialize( get_option( '_pixad_auto_translate' ) );

$Query = $args;

$custom = isset ($wp_query) ? get_post_custom($wp_query->get_queried_object_id()) : '';
$layout = isset ($custom['pix_page_layout']) ? $custom['pix_page_layout'][0] : '2';
$sidebar = isset ($custom['pix_selected_sidebar'][0]) ? $custom['pix_selected_sidebar'][0] : 'sidebar-1';
if (!is_active_sidebar($sidebar)) $layout = '1';


?>

<?php get_header();?>


<div class="pix-dynamic-content">
 <div id="pixad-listing" class="grid">		

<div class="container">
  <div class="row">

    <?php if ($term_descr != ''): ?>
       <div class="col-md-12"><?php echo wp_kses_post($term_descr) ?></div> 
    <?php endif ?>
    




    <?php if (have_posts()) { ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <?php 
            $comment_args = array( 'status' => 'approve', 'post_id' => $post->ID, );
            $comments = get_comments($comment_args);
            $post_rating = [];
            foreach($comments as $comment){
                $post_rating[] = floatval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
            }
            ?>

              <div class="col-md-4 col-lg-3 col-sm-6">
                           <div class="slider-grid__inner slider-grid__inner_mod-b">
                               
                                <div class="card__img">
                   <?php if( has_post_thumbnail() ): ?>
                     <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('autozone_latest_item', array('class' => 'img-responsive')); ?>
                    </a>

                    
                <?php else: ?>
                    <img class="no-image" src="<?php echo PIXAD_AUTO_URI .'assets/img/no_image.jpg'; ?>" alt="no-image">
                <?php endif; ?>


                <?php if( get_post_meta(get_the_ID(), 'pixad_auto_featured_text', true) ): ?>
                    <span class="card__wrap-label"><span class="card__label"><?php echo  get_post_meta( get_the_ID(), 'pixad_auto_featured_text', true ); ?></span></span>
                <?php endif; ?>


                <?php if( $validate['auto-price_show'] && $PIXAD_Autos->get_meta('_auto_price') ): ?>
               <span class="slider-grid__price_wrap"><span class="slider-grid__price"><span><?php echo wp_kses_post($PIXAD_Autos->get_price()); ?></span></span></span> 
                <?php endif; ?>
				<?php do_action( 'autozone_autos_single_auto_img', $post ); ?>
            </div>
                     <div class="tmpl-gray-footer">
                     	<a class="tmpl-slider-grid__name" href="<?php the_permalink(); ?>"><?php echo wp_kses_post(get_the_title())?></a>
                    <?php if(!empty($post_rating)):?>
                        <div class="star-rating"><span style="width:<?php echo  esc_html( array_sum($post_rating)/count($post_rating) * 20 );?>%"></span></div>
                    <?php endif;?>      
                         
                    <ul class="tmpl-slider-grid__info list-unstyled">
                            
                             <?php foreach ($showInSidebar as $id => $sideAttribute):?>
                                  <?php   $id='_'.$id; 
                                 $id = str_replace('-', '_', $id); 
                                  ?>
                                 <?php  if( $PIXAD_Autos->get_meta($id) ): ?>
                                <li><i class="<?php echo esc_html($sideAttribute['icon'])?>"></i>
                                    <?php
                                    $val_attr =  $PIXAD_Autos->get_meta($id);
                                    if(!empty($auto_translate[$val_attr])  ){
                                      echo esc_html($auto_translate[$val_attr]);
                                    }else{
                                      echo esc_html($PIXAD_Autos->get_meta($id));
                                    }
                                      ?>
                                </li>
                                 <?php endif; ?>

                             <?php endforeach;?>
                         </ul>
                        </div> 

                     </div>  
            </div>     
        <?php endwhile; ?>
         <?php  } else { echo "<h2>Sorry there are no ‘". esc_html($term->name) ."’ available at the moment, please contact us</h2>";}  ?>
</div>


</div>
     
     
     </div>
       </div>

<?php get_footer();?>

