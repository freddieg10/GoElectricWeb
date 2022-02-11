<?php


    /* Include main framework file */
    require_once(get_template_directory() . '/library/loader.php');
/*
function SearchFilter($query) {
  if ($query->is_search) {
    $query->set('post_type', 'pixad-autos');
  }
  return $query;
}
add_filter('pre_get_posts','SearchFilter');
*/


function template_chooser($template)   
{    
  global $wp_query;   
  $post_type = get_query_var('post_type');   
  if( $wp_query->is_search && $post_type == 'pixad-autos' )   
  {
    return locate_template('car-search.php');  
  }elseif($wp_query->is_search && $post_type == 'post'){
	  return locate_template('search.php'); 
  }   
  return $template;   
}
add_filter('template_include', 'template_chooser');  




add_action( 'autozone_header_start', 'autozone_header_cart', 10,1 );
function autozone_header_cart($autozone_header)
{

	if(class_exists('WooCommerce') && $autozone_header['header_minicart']){
		echo '<div class="header-navibox-4">';
		echo 	'<div class="header-cart">';
		echo		'<a href="' . wc_get_cart_url() . '"><i class="icon-handbag" aria-hidden="true"></i></a>';
		echo 		'<span class="header-cart-count">' . WC()->cart->cart_contents_count . '</span>';
		echo	  '</div>';
		echo	'</div>';
	}
}

function autozone_sort_auto_price($auto1,$auto2){
      $price1 = INF;
      $price2 = INF;
      $flag1 = 1;
      $flag2 = 1;
      if(!empty( get_post_meta( $auto1->ID, '_auto_price', true ))){
            $var1 = get_post_meta( $auto1->ID, '_auto_price', true );
            if((float)$var1 != 0) {
                  $price1 = (float) $var1;
            }elseif($var1 !== ''){
                  $price1 = INF;
                  $flag1 = 0;
            }
      }
      if(!empty( get_post_meta( $auto2->ID, '_auto_price', true ))){
            $var2 = get_post_meta( $auto2->ID, '_auto_price', true );
            if((float)$var2 != 0){
                  $price2 = (float) $var2;
                  }elseif($var2 !== ''){
                  $price2 = INF;
                  $flag2 = 0;
            }
      }
      if($flag1){
            if( !empty(get_post_meta( $auto1->ID, '_auto_sale_price', true ))){
                  $price1 =  (float) get_post_meta( $auto1->ID, '_auto_sale_price', true );
            }
      }
            if($flag2){
                  if( !empty(get_post_meta( $auto2->ID, '_auto_sale_price', true ))){
                              $price2 =  (float) get_post_meta( $auto2->ID, '_auto_sale_price', true );
                  }
            }

            $data = array_map( 'esc_attr', $_GET );
            if($data['order'] === '_auto_price-asc') $sort =1;
            elseif($data['order'] === '_auto_price-desc')$sort =-1;

            if($sort === 1){
                  if($price1 < $price2) return -1;
      elseif($price1 > $price2) return 1;
      else return 0;
            }elseif($sort === -1){
                  if($price1 < $price2) return 1;
      elseif($price1 > $price2) return -1;
      else return 0;
            }else return 0;
  }





$flag_activate = pixtheme_check_is_activated(); 
if ($flag_activate) {

  if (class_exists('PixthemeCustom')) {
    $pixtheme_plugin_dir = ABSPATH . 'wp-content/plugins/pixtheme-custom/';
    require_once($pixtheme_plugin_dir. '/plugin-update-checker/plugin-update-checker.php');

  $myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'http://assets.templines.com/plugins/theme/autozone/theme.json',
    __FILE__, //Full path to the main plugin file or functions.php.
    'autozone'
  );
    
  }

 // require 'plugin-update-checker/plugin-update-checker.php';


}else{

}
