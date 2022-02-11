<?php

/*
 Plugin Name: Compare cars 
 Description:  Compare functionality for Autozone
 Author: Templines
 Version: 1.5.5
 Text Domain:compare_cars
*/


// Exit if accessed directly.

require 'plugin-update-checker/plugin-update-checker.php';
$MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'http://assets.templines.com/plugins/theme/autozone/compare-cars.json',
    __FILE__,
    'compare-cars'
);  


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
include_once 'thumbmaker/class.Kama_Make_Thumb.php';

add_action( 'wp_enqueue_scripts',   'compare_cars_script_987' );
function compare_cars_script_987(){

	wp_register_script( 'compareaddjs', plugin_dir_url( __FILE__ ) . 'js/add-compare.js', array( 'jquery' ) );
	wp_register_script( 'comparejs', plugin_dir_url( __FILE__ ) . 'js/compare.js', array( 'jquery' ) );
	wp_register_style( 'comparecrscss', plugin_dir_url( __FILE__ ) . 'css/compare.css' );
	wp_register_style( 'compareaddcss', plugin_dir_url( __FILE__ ) . 'css/add-compare.css' );
	
	if(!empty(get_option('compare_cars_templ')['template'] )  && get_option('compare_cars_templ')['template']  != -1 )
		
//	if(  get_the_ID() == get_option('compare_cars_templ')['template'] ){
	if ( function_exists('icl_object_id') ) {
     	$page_translate_id = apply_filters( 'wpml_object_id', get_option('compare_cars_templ')['template'], 'page' );
	}
	$page_translate_id = get_the_ID();
	
	
	if( get_the_ID() == get_option('compare_cars_templ')['template'] || get_the_ID() === $page_translate_id ){
		
	  wp_enqueue_style( 'comparecrscss' );
	  wp_enqueue_script( 'comparejs' );
	} 

	wp_enqueue_script( 'compareaddjs' );
	wp_enqueue_style( 'compareaddcss' );

}

add_action (  'wp_print_scripts' ,  'compare_cars_script_print'  ) ; 
function compare_cars_script_print( ) { 

  $template = compare_cars_find_url();
  $arg = array(
		  'post_type' => array( 'pixad-autos',),
		  'posts_per_page' => -1,
		  'fields' => 'ids',
		);
		$query = new WP_Query( $arg );
		$ids = implode(",",$query->posts);
	?>
	 <script type="text/javascript">
	 	document.idPostTemp = '<?php echo esc_attr( $template); ?>';
	 	var text  = {};
	 	text.over = '<?php echo esc_attr( __('You have already added 3 cars' , 'compare_cars')); ?>';
	 	text.add = '<?php echo esc_attr( __(' Added for comparison' , 'compare_cars')); ?>';
	 	text.remove = '<?php echo esc_attr( __(' Removed from comparison' , 'compare_cars')); ?>';
	 	document.compare_cars_data = {};
	 	document.compare_cars_data.description = text;
	 	document.compare_cars_data.idPostTemp = '<?php echo esc_attr( $template); ?>';
	 	document.compare_cars_data.idsAutos = '<?php echo esc_attr( $ids); ?>';

	 </script>
	 <?php 
}
//найти url страницы всех авто
function compare_cars_find_url(){

	$template = '';
	$url = '';
  $pages = get_pages();
  $id_temp = false;
  if(!empty(get_option('_pixad_autos_settings'))){
  	$auto_listing_page = unserialize( get_option( '_pixad_autos_settings'  ));
  	$id_temp = !empty($auto_listing_page['autos_listing_car_page']) ? $auto_listing_page['autos_listing_car_page'] : false ;
	}
  foreach ( $pages as $page ) {
  	$temp = get_post_meta( $page->ID, '_wp_page_template', true );
  	if( $temp == 'autos.php' ){
  		$url = get_permalink( $page->ID );
  		break;
  	}else{
			if($id_temp == $page->ID){
				$url = get_permalink( $id_temp );
				break;
			}
  	}
  }
  if(!empty($url)){
  	$template = $url;
  }else{

		$template = home_url('');
  }
  return $template;
}

function compare_cars_lenght_cookie($value=''){

		$counter = 0;
    if(!empty($_COOKIE["add-to-compare0"])){
        $counter ++;
    }
    if(!empty($_COOKIE["add-to-compare1"])){
        $counter ++;
    }
    if(!empty($_COOKIE["add-to-compare2"])){
        $counter ++;
    }
	return $counter;
}

 function compare_cars_page_url(){

	$val = get_option('compare_cars_templ'); 
	$template = !empty($val['template']) ? $val['template'] : -1;
	return get_permalink( $template );
}

add_filter('template_include', 'compare_cars_filter_template_543643');
function compare_cars_filter_template_543643( $template ) {

	if(!empty(get_option('compare_cars_templ')['template'] )  && get_option('compare_cars_templ')['template']  != -1 )
	// if(  get_the_ID() == get_option('compare_cars_templ')['template'] ){
	if ( function_exists('icl_object_id') ) {
     	$page_translate_id = apply_filters( 'wpml_object_id', get_option('compare_cars_templ')['template'], 'page' );
	}
	
	
	
	if( get_the_ID() == get_option('compare_cars_templ')['template'] || get_the_ID() === $page_translate_id ){
		return plugin_dir_path(__FILE__) . "templates/compare-cars.php"; 
	}
	return $template;
}

//****************admin*********************
//страница настроек 
add_action('admin_menu', 'compare_cars_wc_submenu_page_url', 999);

function compare_cars_wc_submenu_page_url() {
  add_submenu_page( 'edit.php?post_type=pixad-autos', __('Compare page', 'compare_cars'), _x('Compare page', 'menu', 'compare_cars'), 'manage_options', 'compare-cars', 'compare_cars_submenu_page' );
}

function compare_cars_submenu_page(){

	?>
	<div class="wrap">
		<h3><?php echo get_admin_page_title() ?></h3>

		<form action="options.php" method="POST">
			<?php
				settings_fields( 'compare_opt_gr' ); 
				do_settings_sections( 'compare_page1' );
				submit_button();
			?>
		</form>
	</div>
	<?php
}

add_action('admin_init', 'compare_cars_settings_page');
function compare_cars_settings_page(){

	register_setting( 'compare_opt_gr', 'compare_cars_templ', 'compare_sanitize_clb' );
	add_settings_section( 'section_id',  __('Compare settings', 'compare_cars'), '', 'compare_page1' ); 
	add_settings_field('primer_field1', __('Select compare page', 'compare_cars'), 'compare_fields_display', 'compare_page1', 'section_id' );
	add_settings_field('compare_field_favorite',  __('Not use favorite', 'compare_cars'), 'compare_fields_favorite', 'compare_page1', 'section_id' );
	add_settings_field('compare_field_comp_icon',  __('Hide Compare icon', 'compare_cars'), 'compare_fields_comp_icon', 'compare_page1', 'section_id' );
	add_settings_field('compare_field_resize',  __('Resize', 'compare_cars'), 'compare_fields_resize', 'compare_page1', 'section_id' );
}

function compare_fields_display(){

	$val = get_option('compare_cars_templ'); 
	$template = !empty($val['template']) ? $val['template'] : -1;
	?>

	<select name="compare_cars_templ[template]"> 
	 <option value="-1">
	<?php echo esc_attr( __( 'Select page', 'compare_cars' ) ); ?></option> 
	 <?php 
	  $pages = get_pages(); 
	  foreach ( $pages as $page ) {
			$option = '<option value="' .  $page->ID . '" ' . selected( $template, $page->ID ) . '>';
			$option .= $page->post_title;
			$option .= '</option>';
			echo $option;
	  }
	 ?>
	</select>

	<?php
}
function compare_fields_favorite(){

	$val = get_option('compare_cars_templ'); 
	$no_favorite = !empty($val['no_favorite']) ? $val['no_favorite'] : false;
	?>
	<label><input type="checkbox" name="compare_cars_templ[no_favorite]" value="1" <?php checked( 1, $no_favorite ) ?> /></label>
	<?php
}
function compare_fields_comp_icon(){

	$val = get_option('compare_cars_templ'); 

	$hide_comp_icon = !empty($val['no_comp_icon']) ? $val['no_comp_icon'] : false;
	?>
	<label><input type="checkbox" name="compare_cars_templ[no_comp_icon]" value="1" <?php checked( 1, $hide_comp_icon ) ?> /></label>
	<?php
}
function compare_fields_resize(){

	$val = get_option('compare_cars_templ'); 
	$resize = !empty($val['resize']) ? $val['resize'] : false;
	?>
	<label><input type="checkbox" name="compare_cars_templ[resize]" value="1" <?php checked( 1, $resize ) ?> /></label>
	<?php
}

function compare_sanitize_clb( $options ){ 

	return $options;
}
//****************end admin*********************

//подсказка для сравнения
add_action( 'get_footer', 'compare_cars_hint' );
function compare_cars_hint( $name ){

	echo('<div class="single-add-to-compare">
	<div class="container">
		<div class="row">
			<div class="col-md-9 col-sm-9">
				<div class="single-add-to-compare-left">
					<i class="add-to-compare-icon auto-icon-speedometr2"></i>
					<span class="auto-title h5"></span>
				</div>
			</div>
			<div class="col-md-3 col-sm-3">
				<a href="' .  compare_cars_page_url(0)  . '" class="compare-fixed-link pull-right heading-font">' .  __('VIEW ALL CARS FOR COMPARE' , 'compare_cars') .'</a>
			</div>
		</div>
	</div>
</div>');
}

//favorite
function compare_cars_get_ids_favorite()
{

	$cook = '';
	if(!empty($_COOKIE["compare_favoriteID"])){
	  $cook =  htmlspecialchars($_COOKIE["compare_favoriteID"]);
	}
	$arr_auto_ids = explode(",", $cook);
	return  array_diff($arr_auto_ids, array(''));
}

//вывести любимые авто на первой странице пагинации
add_action( 'autozone_autos_content', 'compare_cars_autos_content', 10,1 );
function compare_cars_autos_content($a ){

	global $post, $PIXAD_Autos,$wp_query;
	$paged = (int) $wp_query->query_vars['paged'];
	if($paged > 1) return;

	$favorite = compare_cars_get_ids_favorite();

	if(count($favorite) === 0) return;

	$arg = array(
	  'post_type' => array(  'pixad-autos',),
	  'posts_per_page' => -1,
	  'post__in' => $favorite,
	  // 'orderby' => 'meta_value_num',
		// 'meta_key' => '_auto_sale_price',
	);
	$wp_query = new WP_Query( $arg );
	get_template_part( 'loop', 'autos' );
	wp_reset_postdata();

}

//убрать из листинга любимое авто 
add_filter( 'autozone_autos_arg_content_list', 'compare_cars_autos_arg' );
function compare_cars_autos_arg($arg){
	$new_arr = compare_cars_get_ids_favorite();
	$post__not_in = !empty($arg['post__not_in']) ? $arg['post__not_in'] : [];
	$arg['post__not_in'] = array_merge( $new_arr , $post__not_in);
	return $arg;
}

//кнопки добавить/удалить сравнение, любимое
add_action( 'autozone_autos_single_auto_img', 'compare_cars_list_footer', 10,1 );
function compare_cars_list_footer($post ){

	global $post; ?>
    <div class="tmpl-list-footer">
        <a class="add-to-compare" data-id="<?php the_ID(); ?>" data-action="add">
            
            
            <span class="add-cmpr"> 
            <i class="icon-speedometer" aria-hidden="true"></i>
                <em class="cmpr-btn-text"><?php _e('Add To Compare', 'compare_cars'); ?></em>
             </span>
            
            <span class="rem-cmpr">
            <i class="icon-speedometer" aria-hidden="true"></i>
            <em class="cmpr-btn-text"><?php _e('Remove From Compare', 'compare_cars'); ?></em>
             </span>
        
        </a>
      <?php if(empty(get_option('compare_cars_templ')) || empty(get_option('compare_cars_templ')['no_favorite'])) : ?>
        <a class="car-favorite" data-id="<?php the_ID(); ?>" data-action="add-favorite">
            
             <span class="add-fvrt"> 
            <i class="fa fa-star-o"></i>
            </span>
            
            <span class="rem-fvrt"> 
            <i class="fa fa-star-o"></i>
            </span>
        
        
        </a>
      <?php endif; ?>
    </div>
    <?php 
}

//добавть в хедер кнопки
add_action( 'wp_loaded', function(){
	if(empty(get_option('compare_cars_templ')) || empty(get_option('compare_cars_templ')['no_favorite'])){
				add_action( 'autozone_header_start', 'compare_cars_button_favorite', 20 );
}} );
add_action( 'wp_loaded', function(){
		remove_action( 'autozone_header_start', 'autozone_header_cart', 10 );
		add_action( 'autozone_header_start', 'compare_cars_header_cart', 10,1 );
		add_action( 'autozone_header_start', 'compare_cars_button_compare', 15,1 );
} );

	
function compare_cars_button_compare($autozone_header){

	$val = get_option('compare_cars_templ'); 
	$hide_comp_icon =  !empty($val['no_comp_icon']) ? $val['no_comp_icon'] : false;
 	if( !(class_exists('WooCommerce') && (is_woocommerce() || is_cart() || is_checkout())) && !$hide_comp_icon ): ?>
	<div class="header-navibox-compare">
		<a href="<?php echo compare_cars_page_url();?>">
           
				<span class="list-label heading-font"><i class="icon-speedometer" aria-hidden="true"></i></span>
				<span class="list-badge"><span class="current-cars-in-compare" data-counter="compare-count"><?php echo compare_cars_lenght_cookie();  ?></span></span>
                <span class="compare-page-name"><?php esc_html_e( 'Compare Page', 'compare_cars' ); ?></span>
            
            
			</a>
	</div>
	<?php endif;
}

function compare_cars_button_favorite($autozone_header){

 if(  !(class_exists('WooCommerce') && (is_woocommerce() || is_cart() || is_checkout())) ): ?>

	<?php endif;
}

function compare_cars_header_cart($autozone_header){

		if(class_exists('WooCommerce') && $autozone_header['header_minicart'] && (is_woocommerce() || is_cart() || is_checkout())){
		echo '<div class="header-navibox-4">';
		echo 	'<div class="header-cart">';
		echo		'<a href="' . wc_get_cart_url() . '"><i class="icon-handbag" aria-hidden="true"></i></a>';
		echo 		'<span class="header-cart-count">' . WC()->cart->cart_contents_count . '</span>';
		echo	  '</div>';
		echo	'</div>';
	}
}


//до цикла авто
add_action( 'autozone_start_loop_autos', 'compare_car_start_loop_autos', 10,1 );
function compare_car_start_loop_autos($attr ){

	global $post, $PIXAD_Autos,$wp_query;
	$paged = (int) $wp_query->query_vars['paged'];

  //favarite
	if($paged === 1) {
		$favorite = compare_cars_get_ids_favorite();
		if(count($favorite) !== 0) {
			$arg = array(
			  'post_type' => array(  'pixad-autos',),
			  'posts_per_page' => -1,
			  'post__in' => $favorite,
			  // 'orderby' => 'meta_value_num',
				// 'meta_key' => '_auto_sale_price',
			);
			$query_favorite = new WP_Query( $arg );
			foreach ($query_favorite->posts as  $post) {
			 array_unshift($wp_query->posts, $post); 
			}
			wp_reset_postdata();

		}
	}


	$wp_query->post_count = count($wp_query->posts);
	// usort($wp_query->posts,'compare_car_sort_auto_price');
}

//после цикла авто
add_action( 'autozone_finish_loop_autos', 'compare_car_finish_loop_autos', 10,1 );
function compare_car_finish_loop_autos($count ){

	global $post, $PIXAD_Autos,$wp_query;
	$wp_query->post_count = $count;
}

//сортировка по цене
function compare_car_sort_auto_price($auto1,$auto2){
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


// add_filter( 'autozone_ajax_start_loop_autos', 'compare_car_ajax_loop', 10, 1 );
function compare_car_ajax_loop($autozone_loop){

	// global $post, $PIXAD_Autos,$wp_query;
	if(is_object($autozone_loop)){

		$paged = (int) $autozone_loop->query_vars['paged'];
	  $url = $_SERVER['REQUEST_URI'];
	  if ( strstr($url, 'order=_auto_price-desc') || strstr($url, 'order=_auto_price-asc') ) {
	      usort($autozone_loop->posts,'compare_car_sort_auto_price');
	  }
		if($paged === 1) {
			$favorite = compare_cars_get_ids_favorite();
			if(count($favorite) !== 0) {
				$arg = array(
				  'post_type' => array(  'pixad-autos',),
				  'posts_per_page' => -1,
				  'post__in' => $favorite,
				  // 'orderby' => 'meta_value_num',
					// 'meta_key' => '_auto_sale_price',
				);
				$query_favorite = new WP_Query( $arg );
				foreach ($query_favorite->posts as  $post) {
				 array_unshift($autozone_loop->posts, $post); 
				}
				wp_reset_postdata();

			}
		}


		$autozone_loop->post_count = count($autozone_loop->posts);
		
	}
	return $autozone_loop;
}

// изменить вид страницы сравнения в админке
add_filter( 'display_post_states', 'compare_add_display_post_states', 15, 2 );
add_filter( 'template_include', 'compare_template_loader' );

function compare_add_display_post_states( $post_states, $post ) {

    $auto_listing_page = false;
	  if(!empty(get_option('_pixad_autos_settings'))){
	  	$settings = unserialize( get_option( '_pixad_autos_settings'  ));
	  	$auto_listing_page = !empty($settings['autos_listing_car_page']) ? $settings['autos_listing_car_page'] : false ;
		}

		if(!empty(get_option('compare_cars_templ')['template'] )  && get_option('compare_cars_templ')['template']  != -1 )
		if(  $post->ID == get_option('compare_cars_templ')['template'] ){
			 $post_states['wc_page_for_shop'] = __( 'Compare Page', 'compare_cars' );
		}
        
    return $post_states;
}
function compare_template_loader( $template ) {

    $auto_listing_page = false;
	  if(!empty(get_option('_pixad_autos_settings'))){
	  	$settings = unserialize( get_option( '_pixad_autos_settings'  ));
	  	$auto_listing_page = !empty($settings['autos_listing_car_page']) ? $settings['autos_listing_car_page'] : false ;
		}
    $object = get_queried_object();
    
    if ( is_embed() ) {
        return $template;
    }

	if(!empty($object) && !empty($object->ID)  && ($object->ID == (int)$auto_listing_page)){
        $template = locate_template('compare-cars.php');
    }

    return $template;
}

add_action( 'plugins_loaded', 'compare_car_load_plugin_textdomain' );
 
function compare_car_load_plugin_textdomain() {
	load_plugin_textdomain( 'compare_cars', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' ); 
}