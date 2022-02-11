<?php 
/***
Template Name: Car listing page
The template for displaying all pages.
***/
global $post, $PIXAD_Autos, $wp;
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

if(get_post_meta(get_the_ID(), 'pix_page_purpose', true) === ""){
    if(isset($_GET['purpose']) && $_GET['purpose'] != ''){
        $autos_purpose = $_GET['purpose'];
    } else {
        $autos_purpose = '';
    }
} else {
    $autos_purpose = get_post_meta(get_the_ID(), 'pix_page_purpose', true);
}
$args['purpose'] = $autos_purpose;

$Query = $args;



$custom = isset ($wp_query) ? get_post_custom($wp_query->get_queried_object_id()) : '';
$layout = isset ($custom['pix_page_layout']) ? $custom['pix_page_layout'][0] : '2';
$sidebar = isset ($custom['pix_selected_sidebar'][0]) ? $custom['pix_selected_sidebar'][0] : 'sidebar-1';
if (!is_active_sidebar($sidebar)) $layout = '1';

    if(!empty($_GET['add']) && 'ok' === $_GET['add']){

            $message_car_add = '<div class="add-car-to-site">
            <div class="container">
                <div class="row">
                    <div class="col-md-9 col-sm-9">
                        <div class="">
                            <span class="auto-title h5">'.  esc_attr__('Your request has been submitted and once approved your car will be available for sale .', 'autozone') . '</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                    </div>
                </div>
            </div>
        </div>';
    }

?>

<?php get_header();?>

<div class="container autos-container">
    <div class="row">

        <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
            <div class="rtd"> <?php the_content(); ?></div>
        <?php endwhile; ?>

        <?php autozone_show_sidebar('left', $custom, 1) ?>

        <div class="<?php if ($layout == 1):?>col-md-12<?php else:?>col-md-9<?php endif;?>">
          <?php
          if(isset($message_car_add)){
            echo wp_specialchars_decode($message_car_add);
          }
            ?>
            <main class="main-content">

                <?php get_template_part( 'autos', 'sorting' ); ?>

                <div class="pix-dynamic-content">

                    <?php get_template_part( 'autos', 'loader' ); ?>

					
					<?php 


                if (class_exists('PIXAD_Settings')) {

                    $Settings	= new PIXAD_Settings();
                    $settings	= $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );

                    $list_style = $settings['autos_list_style'];

                    $args = $PIXAD_Autos->Query_Args( $Query );


                    $order = $settings['autos_order'];

                    $url = filter_input(INPUT_SERVER, 'REQUEST_URI');

                    if(strstr($url, 'order=_auto_make-desc')  || $order === '_auto_make-desc' ){
                       $args['orderby'] = 'title';
                       $args['order'] = 'DESC'; 
                               
                    }elseif(strstr($url, 'order=_auto_make-asc')  || $order === '_auto_make-asc' ){
                       $args['orderby'] = 'title';
                       $args['order'] = 'ASC';         
                    } 
                    
                    
                    if( strstr($url, 'order=_auto_price-desc')  || $order === '_auto_price-desc' ) { 
                      $args['meta_key'] = '_auto_price';
                      $args['orderby'] = 'meta_value_num';
                      $args['order'] = 'DESC';
                    
                      $wp_query = new WP_Query( apply_filters( 'autozone_autos_arg_content_list', $args ) );
                            //   usort($wp_query->posts,'autoimage_sort_auto_price');
                    
                    
                    }elseif(strstr($url, 'order=_auto_price-asc') ||  $order === '_auto_price-asc'){
                      $args['meta_key'] = '_auto_price';
                      $args['orderby'] = 'meta_value_num';
                      $args['order'] = 'ASC';
                    
                      $wp_query = new WP_Query( apply_filters( 'autozone_autos_arg_content_list', $args ) );
                    }else{
                      $wp_query = new WP_Query( apply_filters( 'autozone_autos_arg_content_list', $args ) );
                    } 




                     //   $wp_query = new WP_Query( apply_filters( 'autozone_autos_arg_content_list', $PIXAD_Autos->Query_Args( $Query ) ) );

                        $post_counter = $wp_query->post_count;





                    do_action( 'autozone_start_loop_autos', $PIXAD_Autos);

							 if ( strstr($url, '?view_type=list') ) {?>
								  <div id="pixad-listing" class="list">						
                   					    <?php
                    get_template_part( 'loop', 'autos' );
                    echo pixad_wp_pagenavi();
                    ?>
                    			</div>
							 <?php  } elseif  ( strstr($url, '?view_type=grid') ){?>
								
					 			 <div id="pixad-listing" class="grid">					
                   					 <?php
                                 
                    get_template_part( 'loop', 'autosgrid' );
                    echo pixad_wp_pagenavi();
                    ?>
                  					 
                    			</div>
							 <?php }elseif  ( $list_style == 'Grid'){?>
                
           							 <div id="pixad-listing" class="grid">            
                             <?php

                    get_template_part( 'loop', 'autosgrid' );
                    echo pixad_wp_pagenavi();
                    ?>
                            
                          </div>
               <?php       
                 
               }elseif  ( $list_style == 'List'){?>

           							 <div id="pixad-listing" class="list">            
                             <?php
   
                    get_template_part( 'loop', 'autos' );
                    echo pixad_wp_pagenavi();
                    
                    ?>
                            
                          </div>
               <?php       
                 
               }          
            ?> 
            <?php do_action( 'autozone_finish_loop_autos', $post_counter); ?>
					
			<?php  }else{ echo "Plugin PixAutoDeal not installed";} ?>   		
                </div>

            </main><!-- end main-content -->
        </div><!-- end col -->

        <?php autozone_show_sidebar('right', $custom, 1) ?>

    </div><!-- end row -->
</div>

<?php get_footer();?>
