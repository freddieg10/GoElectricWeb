<?php

function autozone_import_files() {
    

    
    add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
    
    return array(
        
		
        array(
            'import_file_name'           => esc_html__( 'Dealer Demo', 'autozone' ),
            'import_file_url'            => esc_url('https://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/dealer.xml'),
            'import_widget_file_url'     => esc_url('https://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/autozone.wie'),
            'import_customizer_file_url' => esc_url('https://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/autozone.dat'),
            'import_preview_image_url'   => esc_url('http://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/autozone.jpg'),
            'import_notice'              => 'Please select <a href="../wp-admin/options-permalink.php">Permalink Settings</a> -  Post name for correct work listing page ',
        ),
         
        
         array(
            'import_file_name'           => esc_html__( 'Rental Demo', 'autozone' ),
            'import_file_url'            => esc_url('https://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/rental.xml'),
            'import_widget_file_url'     => esc_url('https://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/rental.wie'),
            'import_customizer_file_url' => esc_url('https://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/rental.dat'),
            'import_preview_image_url'   => esc_url('http://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/rental.jpg'),
             'import_notice'              => 'Please select <a href="../wp-admin/options-permalink.php">Permalink Settings</a> -  Post name for correct work listing page ',
        ),
        
        
        
          array(
            'import_file_name'           => esc_html__( 'Yacht Demo', 'autozone' ),
            'import_file_url'            => esc_url('https://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/yacht.xml'),
            'import_widget_file_url'     => esc_url('https://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/yacht.wie'),
            'import_customizer_file_url' => esc_url('https://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/yacht.dat'),
            'import_preview_image_url'   => esc_url('http://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/yacht.jpg'),
             'import_notice'              => 'Please select <a href="../wp-admin/options-permalink.php">Permalink Settings</a> -  Post name for correct work listing page ',
        ),
        
        
          array(
            'import_file_name'           => esc_html__( 'Taxi Demo', 'autozone' ),
            'import_file_url'            => esc_url('https://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/taxi.xml'),
            'import_widget_file_url'     => esc_url('https://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/taxi.wie'),
            'import_customizer_file_url' => esc_url('https://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/taxi.dat'),
            'import_preview_image_url'   => esc_url('http://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/taxi.jpg'),
             'import_notice'              => 'Please select <a href="../wp-admin/options-permalink.php">Permalink Settings</a> -  Post name for correct work listing page ',
        ),
        
        
          array(
            'import_file_name'           => esc_html__( 'Moto Demo', 'autozone' ),
            'import_file_url'            => esc_url('https://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/moto.xml'),
            'import_widget_file_url'     => esc_url('https://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/moto.wie'),
            'import_customizer_file_url' => esc_url('https://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/moto.dat'),
            'import_preview_image_url'   => esc_url('http://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/moto.jpg'),
             'import_notice'              => 'Please select <a href="../wp-admin/options-permalink.php">Permalink Settings</a> -  Post name for correct work listing page ',
        ),
        
        
         array(
            'import_file_name'           => esc_html__( 'Autoshop Demo', 'autozone' ),
            'import_file_url'            => esc_url('https://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/autoshop.xml'),
            'import_widget_file_url'     => esc_url('https://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/autoshop.wie'),
            'import_customizer_file_url' => esc_url('https://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/autoshop.dat'),
            'import_preview_image_url'   => esc_url('http://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/autoshop.jpg'),
             'import_notice'              => 'Please select <a href="../wp-admin/options-permalink.php">Permalink Settings</a> -  Post name for correct work listing page ',
        ),
        
        
         array(
            'import_file_name'           => esc_html__( 'Air Demo', 'autozone' ),
            'import_file_url'            => esc_url('http://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/air.xml'),
            'import_widget_file_url'     => esc_url('http://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/air.wie'),
            'import_customizer_file_url' => esc_url('http://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/air.dat'),
            'import_preview_image_url'   => esc_url('http://assets.templines.com/plugins/theme/autozone/T8OAwWuku2kVpVCIREiayxpWOAV6rNWvpD15iZJeQwy00vq8/demo/air.jpg'),
             'import_notice'              => 'Please select <a href="../wp-admin/options-permalink.php">Permalink Settings</a> -  Post name for correct work listing page ',
        ),
     
     
       
        
        
    );
	
}
add_filter( 'pt-ocdi/import_files', 'autozone_import_files' );


function autozone_after_import( $selected_import ) {
    
    
    
    

    $menu_arr = array();
    
    
    
     $term = get_term_by('slug', 'sedans', 'auto-body');
    if( isset($term->term_id) ){
        $auto_t_id = $term->term_id;
        update_option("pixad_body_thumb$auto_t_id", content_url().'/uploads/2016/09/2016-honda-civic-front_10909_032_376x188_wa-200x107.png');
    }
    
    
    $term = get_term_by('slug', 'luxury-cars', 'auto-body');
    if( isset($term->term_id) ){
        $auto_t_id = $term->term_id;
        update_option("pixad_body_thumb$auto_t_id", content_url().'/uploads/2016/09/banner-new4-196x130.png');
    }
    $term = get_term_by('slug', 'suvs', 'auto-body');
    if( isset($term->term_id) ){
        $auto_t_id = $term->term_id;
        update_option("pixad_body_thumb$auto_t_id", content_url().'/uploads/2016/09/10474_31.png');
    }
    $term = get_term_by('slug', 'sports', 'auto-body');
    if( isset($term->term_id) ){
        $auto_t_id = $term->term_id;
        update_option("pixad_body_thumb$auto_t_id", content_url().'/uploads/2016/09/lamba.png');
    }
    $term = get_term_by('slug', 'truck', 'auto-body');
    if( isset($term->term_id) ){
        $auto_t_id = $term->term_id;
        update_option("pixad_body_thumb$auto_t_id", content_url().'/uploads/2016/09/truck.png');
    }
    $term = get_term_by('slug', 'vans-trucks', 'auto-body');
    if( isset($term->term_id) ){
        $auto_t_id = $term->term_id;
        update_option("pixad_body_thumb$auto_t_id", content_url().'/uploads/2016/09/2016-Ford-TransitConnect-XLT.png');
    }
    
    
    
    $term = get_term_by('slug', 'audi', 'auto-model');
    if( isset($term->term_id) ){
        $auto_t_id = $term->term_id;
        update_option("pixad_model_thumb$auto_t_id", content_url().'/uploads/2018/07/audi.jpg');
    }
    
    $term = get_term_by('slug', 'bmw', 'auto-model');
    if( isset($term->term_id) ){
        $auto_t_id = $term->term_id;
        update_option("pixad_model_thumb$auto_t_id", content_url().'/uploads/2018/07/bmw.jpg');
    }
    
     $term = get_term_by('slug', 'mercedes-benz', 'auto-model');
    if( isset($term->term_id) ){
        $auto_t_id = $term->term_id;
        update_option("pixad_model_thumb$auto_t_id", content_url().'/uploads/2018/07/Mercedes.jpg');
    }
    
     $term = get_term_by('slug', 'lamborghini', 'auto-model');
    if( isset($term->term_id) ){
        $auto_t_id = $term->term_id;
        update_option("pixad_model_thumb$auto_t_id", content_url().'/uploads/2018/07/Lamborghini.jpg');
    }
    
    
     $term = get_term_by('slug', 'lexus', 'auto-model');
    if( isset($term->term_id) ){
        $auto_t_id = $term->term_id;
        update_option("pixad_model_thumb$auto_t_id", content_url().'/uploads/2018/07/Lexus-Logo.jpg');
    }
    
    
     $term = get_term_by('slug', 'ferrari', 'auto-model');
    if( isset($term->term_id) ){
        $auto_t_id = $term->term_id;
        update_option("pixad_model_thumb$auto_t_id", content_url().'/uploads/2018/07/FERRARI.jpg');
    }
    
    
       $term = get_term_by('slug', 'bentley', 'auto-model');
    if( isset($term->term_id) ){
        $auto_t_id = $term->term_id;
        update_option("pixad_model_thumb$auto_t_id", content_url().'/uploads/2018/07/BENTLEY.jpg');
    }
    
    
    
    
    
    
   
    

    
         if ( 'Dealer Demo' === $selected_import['import_file_name'] ) {
    	 $main_menu = get_term_by('name', 'main-menu', 'nav_menu');
    //$top_menu = get_term_by('name', 'top', 'nav_menu');
    } 
    
        
    elseif ('Rental Demo' === $selected_import['import_file_name']) {
		 $main_menu = get_term_by('name', 'rental-menu', 'nav_menu');
    //$top_menu = get_term_by('name', 'top', 'nav_menu');
	} 
    
    
        elseif ('Yacht Demo' === $selected_import['import_file_name']) {
		 $main_menu = get_term_by('name', 'yacht-menu', 'nav_menu');
    //$top_menu = get_term_by('name', 'top', 'nav_menu');
	} 
    
    
    
        elseif ('Taxi Demo' === $selected_import['import_file_name']) {
		 $main_menu = get_term_by('name', 'taxi-menu', 'nav_menu');
    //$top_menu = get_term_by('name', 'top', 'nav_menu');
	} 
    
    
      elseif ('Moto Demo' === $selected_import['import_file_name']) {
		 $main_menu = get_term_by('name', 'moto-menu', 'nav_menu');
    //$top_menu = get_term_by('name', 'top', 'nav_menu');
	} 
    
    
    elseif ('Autoshop Demo' === $selected_import['import_file_name']) {
		 $main_menu = get_term_by('name', 'autoshop-menu', 'nav_menu');
       //$top_menu = get_term_by('name', 'autoshop-top', 'nav_menu');
	} 
    
    
     elseif ('Air Demo' === $selected_import['import_file_name']) {
		 $main_menu = get_term_by('name', 'air-menu', 'nav_menu');
       //$top_menu = get_term_by('name', 'autoshop-top', 'nav_menu');
	} 
    
    
    
    
    if(is_object($main_menu)) {
    	$menu_arr['primary_nav'] = $main_menu->term_id;
    }
    if(is_object($top_menu)) {
    	$menu_arr['top_nav'] = $top_menu->term_id;
    }
    
    
    set_theme_mod( 'nav_menu_locations', $menu_arr );
    
    
    
     if ( 'Dealer Demo' === $selected_import['import_file_name'] ) {
    	
        
           $slider_array = array(
             plugin_dir_path(__FILE__)."/revslider/home_slider.zip",
             plugin_dir_path(__FILE__)."/revslider/repair.zip",
    );
        
        
    } 
    
        
      
     if ( 'Yacht Demo' === $selected_import['import_file_name'] ) {
    	
        
           $slider_array = array(
             plugin_dir_path(__FILE__)."/revslider/yacht.zip",
    );
        
        
    } 
    
    
    
     if ( 'Air Demo' === $selected_import['import_file_name'] ) {
    	
        
           $slider_array = array(
             plugin_dir_path(__FILE__)."/revslider/air.zip",
    );
        
        
    } 
    
    
    if ( 'Rental Demo' === $selected_import['import_file_name'] ) {
    	
        
           $slider_array = array(
             plugin_dir_path(__FILE__)."/revslider/home_slider.zip",
    );
        
        
    } 
    
    
    
     
     if ( 'Taxi Demo' === $selected_import['import_file_name'] ) {
    	
        
           $slider_array = array(
             plugin_dir_path(__FILE__)."/revslider/taxi.zip",
    );
        
        
    } 
    
    
    
    if ( 'Moto Demo' === $selected_import['import_file_name'] ) {
    	
        
           $slider_array = array(
             plugin_dir_path(__FILE__)."/revslider/moto.zip",
    );
        
        
    } 
    
        
    if ( 'Autoshop Demo' === $selected_import['import_file_name'] ) {
    	
        
           $slider_array = array(
             plugin_dir_path(__FILE__)."/revslider/autoshop.zip",
    );
        
        
    } 


    $front_page_id = get_page_by_title( 'Home' );
    $blog_page_id  = get_page_by_title( 'Blog' );
    
    
      update_option( 'show_on_front', 'page' );

      
    
 if ( 'Dealer Demo' === $selected_import['import_file_name'] ) {
    	update_option( 'page_on_front', 7163 );
    } 
    
        
    elseif ('Rental Demo' === $selected_import['import_file_name']) {
		update_option( 'page_on_front', 16725 );
	}
    
    
        elseif ('Yacht Demo' === $selected_import['import_file_name']) {
		update_option( 'page_on_front', 17427 );
	}
    
    
      elseif ('Taxi Demo' === $selected_import['import_file_name']) {
		update_option( 'page_on_front', 17636 );
	}
    
    
      elseif ('Moto Demo' === $selected_import['import_file_name']) {
		update_option( 'page_on_front', 17073 );
	}
    
    
      elseif ('Autoshop Demo' === $selected_import['import_file_name']) {
		update_option( 'page_on_front', 17098 );
	}
    
    
    
      elseif ('Air Demo' === $selected_import['import_file_name']) {
		update_option( 'page_on_front', 17443 );
	}

    
    
    
    update_option( 'page_for_posts', $blog_page_id->ID );
    
    
    
     if ( 'Dealer Demo' === $selected_import['import_file_name'] ) {
    	set_theme_mod( 'autozone_footer_block', '2101' );
    } 
    
     if ( 'Rental Demo' === $selected_import['import_file_name'] ) {
    	set_theme_mod( 'autozone_footer_block', '2101' );
    } 
    
    
     if ( 'Yacht Demo' === $selected_import['import_file_name'] ) {
    	set_theme_mod( 'autozone_footer_block', '2101' );
    } 
    
    
     if ( 'Air Demo' === $selected_import['import_file_name'] ) {
    	set_theme_mod( 'autozone_footer_block', '17761' );
    } 
    
    
     if ( 'Taxi Demo' === $selected_import['import_file_name'] ) {
    	set_theme_mod( 'autozone_footer_block', '17908' );
    } 
    
     if ( 'Autoshop Demo' === $selected_import['import_file_name'] ) {
    	set_theme_mod( 'autozone_footer_block', '2101' );
    } 
    
    
    
     if ( 'Dealer Demo' === $selected_import['import_file_name'] ) {
    	
         
          $Settings   = new PIXAD_Settings();
        $args = array(
      'autos_my_cars_page'      => '16819',
      'autos_listing_car_page'  => '104',
      'autos_sell_car_page'     => '16822',
      'autos_update_car_page'   => '16826',
      'autos_list_style'        => 'Grid',
      'autos_max_price'        => '9999',
      'autos_site_currency'      => 'USD',
      'autos_thousand'      => ',',
      'autos_decimal'      => '.',
      'autos_decimal_number'      => '0',
      'autos_price_text'      => '',
      'autos_per_page'      => '9',
      'autos_equipment'      => 'No',
      'autos_decimal_number'      => '0',
            
            
            
  );
         
         
           
          $args_validation = array(
      'auto-price_show'     => 'on',
      
      'auto-fuel_show'     => 'on',
      'auto-fuel_list'     => 'on',
      'auto-engine_show'     => 'on',
      'auto-engine_list'     => 'on',
      'auto-horsepower_show'     => 'on',
      'auto-horsepower_list'     => 'on',
      'auto-condition_show'     => 'on',
      'auto-condition_list'     => 'on',
      'auto-condition_show'     => 'on',
      'auto-condition_list'     => 'on',

      'auto-year_show'     => 'on',
      'auto-year_side'     => 'on',
      'auto-year_list'     => 'on',
      'auto-year_icon'     => 'autofont-steering-wheel-1',
              
      'auto-mileage_show'     => 'on',
      'auto-mileage_side'     => 'on',
      'auto-mileage_list'     => 'on',
      'auto-mileage_icon'     => 'autofont-highway',
              
              
      'auto-horsepower_show'     => 'on',
      'auto-horsepower_side'     => 'on',
      'auto-horsepower_list'     => 'on',
      'auto-horsepower_icon'     => 'autofont-speedometer',

     
      

                   
  ); 
         
         

         
         
    } 
    
     if ( 'Rental Demo' === $selected_import['import_file_name'] ) {
    	
         
          $Settings   = new PIXAD_Settings();
        $args = array(
      'autos_my_cars_page'      => '16819',
      'autos_listing_car_page'  => '17536',
      'autos_sell_car_page'     => '16822',
      'autos_update_car_page'   => '16826',
      'autos_list_style'        => 'Grid',
      'autos_max_price'        => '9999',
      'autos_site_currency'      => 'USD',
      'autos_thousand'      => ',',
      'autos_decimal'      => '.',
      'autos_decimal_number'      => '0',
      'autos_price_text'      => '',
      'autos_per_page'      => '9',
      'autos_equipment'      => 'No',
            
            
  );
       
         
          $args_validation = array(
      'auto-version_show'  => 'on',
      'auto-year_show'     => 'on',
      'auto-price_show'     => 'on',
      'auto-mileage_show'  => 'on',
      'auto-fuel_show'     => 'on',
      'auto-engine_show'   => 'on',
      'auto-horsepower_show' => 'on',
      'auto-year_side'     => 'on',
      'auto-mileage_side'  => 'on',
      'auto-horsepower_side' => 'on',
      'auto-year_list'     => 'on',
      'auto-mileage_list'  => 'on',
      'auto-fuel_list'     => 'on',
      'auto-engine_list'   => 'on',
      'auto-horsepower_list' => 'on', 
      'auto-year_icon'     => 'autofont-steering-wheel-1',
      'auto-mileage_icon'  => 'autofont-highway',
      'auto-horsepower_icon' => 'autofont-speedometer',     
      'custom_1_name'      => 'Engine Model',
      'custom_2_name'      => 'Length',
      'custom_3_name'      => 'Gross Weight',
      'custom_4_name'      => 'Hull Material',
      'custom_5_name'      => 'Draft',
      'custom_6_name'      => 'Fuel Capacity',
      'custom_7_name'      => 'Fuel Type',
      'custom_8_name'      => 'Manufacturer',
      'custom_9_name'      => 'Passengers',
      'custom_10_name'      => 'Max Speed',
      'custom_1_show'      => 'on',
      'custom_2_show'      => 'on',
      'custom_3_show'      => 'on',
      'custom_4_show'      => 'on',
      'custom_5_show'      => 'on',
      'custom_6_show'      => 'on',
      'custom_7_show'      => 'on',
      'custom_8_show'      => 'on',
      'custom_9_show'      => 'on',
      'custom_10_show'      => 'on',
          
      'custom_1_side'      => 'on',
      'custom_9_side'      => 'on',
      'custom_10_side'      => 'on',
      'custom_1_icon'      => 'icon-settings',
      'custom_9_icon'      => 'icon-users',
      'custom_10_icon'      => 'icon-speedometer',
                   
  );
      $comare_hide_settings =  array('template' => -1, 'no_favorite' => 1, 'no_comp_icon' => 1 );
      update_option('compare_cars_templ', $comare_hide_settings);



  } 
    
    
    
    
     if ( 'Yacht Demo' === $selected_import['import_file_name'] ) {
    	
         
          $Settings   = new PIXAD_Settings();
        $args = array(
      'autos_my_cars_page'      => '16819',
      'autos_listing_car_page'  => '17042',
      'autos_list_style'        => 'List',
      'autos_max_price'        => '999',
      'autos_site_currency'      => 'USD',
      'autos_thousand'      => ',',
      'autos_decimal'      => '.',
      'autos_decimal_number'      => '0',
      'autos_price_text'      => '',
      'autos_per_page'      => '9',
      'autos_equipment'      => 'No',
                      
  );

      $args_validation = array(
      'custom_1_name'      => 'Engine Model',
      'custom_2_name'      => 'Length',
      'custom_3_name'      => 'Gross Weight',
      'custom_4_name'      => 'Hull Material',
      'custom_5_name'      => 'Draft',
      'custom_6_name'      => 'Fuel Capacity',
      'custom_7_name'      => 'Fuel Type',
      'custom_8_name'      => 'Manufacturer',
      'custom_9_name'      => 'Passengers',
      'custom_10_name'      => 'Max Speed',
      'custom_1_show'      => 'on',
      'custom_2_show'      => 'on',
      'custom_3_show'      => 'on',
      'custom_4_show'      => 'on',
      'custom_5_show'      => 'on',
      'custom_6_show'      => 'on',
      'custom_7_show'      => 'on',
      'custom_8_show'      => 'on',
      'custom_9_show'      => 'on',
      'custom_10_show'      => 'on',
          
      'custom_1_side'      => 'on',
      'custom_9_side'      => 'on',
      'custom_10_side'      => 'on',
      'custom_1_icon'      => 'icon-settings',
      'custom_9_icon'      => 'icon-users',
      'custom_10_icon'      => 'icon-speedometer',
                   
  );
      $comare_hide_settings =  array('template' => -1, 'no_favorite' => 1, 'no_comp_icon' => 1 );
      update_option('compare_cars_templ', $comare_hide_settings);



  } 
    
    
        
    
     if ( 'Air Demo' === $selected_import['import_file_name'] ) {
    	
         
          $Settings   = new PIXAD_Settings();
        $args = array(
      'autos_my_cars_page'      => '16819',
      'autos_listing_car_page'  => '17042',
      'autos_list_style'        => 'List',
      'autos_max_price'        => '999',
      'autos_site_currency'      => 'USD',
      'autos_thousand'      => ',',
      'autos_decimal'      => '.',
      'autos_decimal_number'      => '0',
      'autos_price_text'      => '',
      'autos_per_page'      => '9',
      'autos_equipment'      => 'No',
                      
  );

      $args_validation = array(
      'custom_1_name'      => 'Engine Model',
      'custom_2_name'      => 'Length',
      'custom_3_name'      => 'Gross Weight',
      'custom_4_name'      => 'Hull Material',
      'custom_5_name'      => 'Draft',
      'custom_6_name'      => 'Fuel Capacity',
      'custom_7_name'      => 'Fuel Type',
      'custom_8_name'      => 'Manufacturer',
      'custom_9_name'      => 'Passengers',
      'custom_10_name'      => 'Max Speed',
      'custom_1_show'      => 'on',
      'custom_2_show'      => 'on',
      'custom_3_show'      => 'on',
      'custom_4_show'      => 'on',
      'custom_5_show'      => 'on',
      'custom_6_show'      => 'on',
      'custom_7_show'      => 'on',
      'custom_8_show'      => 'on',
      'custom_9_show'      => 'on',
      'custom_10_show'      => 'on',
          
      'custom_1_side'      => 'on',
      'custom_9_side'      => 'on',
      'custom_10_side'      => 'on',
      'custom_1_icon'      => 'icon-settings',
      'custom_9_icon'      => 'icon-users',
      'custom_10_icon'      => 'icon-speedometer',
                   
  );
      $comare_hide_settings =  array('template' => -1, 'no_favorite' => 1, 'no_comp_icon' => 1 );
      update_option('compare_cars_templ', $comare_hide_settings);



  } 
    
    
    
      if ( 'Taxi Demo' === $selected_import['import_file_name'] ) {
    	
         
          $Settings   = new PIXAD_Settings();
        $args = array(
      'autos_my_cars_page'      => '16819',
      'autos_listing_car_page'  => '17042',
      'autos_list_style'        => 'List',
      'autos_max_price'        => '999',
      'autos_site_currency'      => 'USD',
      'autos_thousand'      => ',',
      'autos_decimal'      => '.',
      'autos_decimal_number'      => '0',
      'autos_price_text'      => '',
      'autos_per_page'      => '9',
      'autos_equipment'      => 'No',
                      
  );

      $args_validation = array(
      'custom_1_name'      => 'Engine Model',
      'custom_2_name'      => 'Length',
      'custom_3_name'      => 'Gross Weight',
      'custom_4_name'      => 'Hull Material',
      'custom_5_name'      => 'Draft',
      'custom_6_name'      => 'Fuel Capacity',
      'custom_7_name'      => 'Fuel Type',
      'custom_8_name'      => 'Manufacturer',
      'custom_9_name'      => 'Passengers',
      'custom_10_name'      => 'Max Speed',
      'custom_1_show'      => 'on',
      'custom_2_show'      => 'on',
      'custom_3_show'      => 'on',
      'custom_4_show'      => 'on',
      'custom_5_show'      => 'on',
      'custom_6_show'      => 'on',
      'custom_7_show'      => 'on',
      'custom_8_show'      => 'on',
      'custom_9_show'      => 'on',
      'custom_10_show'      => 'on',
          
      'custom_1_side'      => 'on',
      'custom_9_side'      => 'on',
      'custom_10_side'      => 'on',
      'custom_1_icon'      => 'icon-settings',
      'custom_9_icon'      => 'icon-users',
      'custom_10_icon'      => 'icon-speedometer',
                   
  );
      $comare_hide_settings =  array('template' => -1, 'no_favorite' => 1, 'no_comp_icon' => 1 );
      update_option('compare_cars_templ', $comare_hide_settings);



  } 
    
    
    
    
       if ( 'Moto Demo' === $selected_import['import_file_name'] ) {
    	
         
          $Settings   = new PIXAD_Settings();
        $args = array(
      'autos_my_cars_page'      => '16819',
      'autos_listing_car_page'  => '104',
      'autos_list_style'        => 'List',
      'autos_max_price'        => '999',
      'autos_site_currency'      => 'USD',
      'autos_thousand'      => ',',
      'autos_decimal'      => '.',
      'autos_decimal_number'      => '0',
      'autos_price_text'      => '',
      'autos_per_page'      => '9',
      'autos_equipment'      => 'No',
                      
  );

      $args_validation = array(
      'custom_1_name'      => 'Engine Type',
      'custom_2_name'      => 'Displacement',
      'custom_3_name'      => 'Bore x Stroke',
      'custom_4_name'      => 'Compression Ratio',
      'custom_5_name'      => 'Maximum Power',
      'custom_6_name'      => 'Maximum Torque',
      'custom_7_name'      => 'Starter System',
      'custom_8_name'      => 'Ground Clearance',
      'custom_9_name'      => 'Length (mm)',
      'custom_10_name'      => 'Width (mm)',
      'custom_11_name'      => 'Height (mm)',
      'custom_12_name'      => 'Wheel Base (mm)',
      'custom_13_name'      => 'Weight (kg)',
      'custom_1_show'      => 'on',
      'custom_2_show'      => 'on',
      'custom_3_show'      => 'on',
      'custom_4_show'      => 'on',
      'custom_5_show'      => 'on',
      'custom_6_show'      => 'on',
      'custom_7_show'      => 'on',
      'custom_8_show'      => 'on',
      'custom_9_show'      => 'on',
      'custom_10_show'      => 'on',
      'custom_11_show'      => 'on',
      'custom_12_show'      => 'on',
      'custom_13_show'      => 'on',
          
      'custom_4_side'      => 'on',
      'custom_7_side'      => 'on',
      'custom_4_icon'      => 'autofont-speedometer',
      'custom_7_icon'      => 'autofont-power',
      'custom_1_list'      => 'on',
      'custom_2_list'      => 'on',
      'custom_3_list'      => 'on',
      'custom_4_list'      => 'on',
      'custom_7_list'      => 'on',   

      'auto-year_show'     => 'on',
      'auto-year_side'     => 'on',
      'auto-year_list'     => 'on',
      'auto-year_icon'     => 'autofont-helmet-2',
          
          
      'auto-warranty_show'     => 'on',
      'first-name_show'     => 'on',
      'auto-currency_show'     => 'on',
      'last-name_show'     => 'on',
      'seller-company_show'     => 'on',
      'auto-warranty_show'     => 'on',
      'seller-email_show'     => 'on',     
      'seller-phone_show'     => 'on',         
      'seller-country_show'     => 'on',     
      'seller-state_show'     => 'on',
      'seller-town_show'     => 'on', 
      'seller-location_show'     => 'on', 
      'seller-location-lat_show'     => 'on', 
      'seller-location-long_show'     => 'on',  
      'auto-date_show'     => 'on',  
           
                   
  );
      $comare_hide_settings =  array('template' => -1, 'no_favorite' => 1, 'no_comp_icon' => 1 );
      update_option('compare_cars_templ', $comare_hide_settings);



  } 
    
    
   
       if ( 'Autoshop Demo' === $selected_import['import_file_name'] ) {
    	
         
          $Settings   = new PIXAD_Settings();
        $args = array(
      'autos_my_cars_page'      => '16819',
      'autos_listing_car_page'  => '104',
      'autos_list_style'        => 'List',
      'autos_max_price'        => '999',
      'autos_site_currency'      => 'USD',
      'autos_thousand'      => ',',
      'autos_decimal'      => '.',
      'autos_decimal_number'      => '0',
      'autos_price_text'      => '',
      'autos_per_page'      => '9',
      'autos_equipment'      => 'No',
                      
  );

      $args_validation = array(
      'custom_1_name'      => 'Engine Type',
      'custom_2_name'      => 'Displacement',
      'custom_3_name'      => 'Bore x Stroke',
      'custom_4_name'      => 'Compression Ratio',
      'custom_5_name'      => 'Maximum Power',
      'custom_6_name'      => 'Maximum Torque',
      'custom_7_name'      => 'Starter System',
      'custom_8_name'      => 'Ground Clearance',
      'custom_9_name'      => 'Length (mm)',
      'custom_10_name'      => 'Width (mm)',
      'custom_11_name'      => 'Height (mm)',
      'custom_12_name'      => 'Wheel Base (mm)',
      'custom_13_name'      => 'Weight (kg)',
      'custom_1_show'      => 'on',
      'custom_2_show'      => 'on',
      'custom_3_show'      => 'on',
      'custom_4_show'      => 'on',
      'custom_5_show'      => 'on',
      'custom_6_show'      => 'on',
      'custom_7_show'      => 'on',
      'custom_8_show'      => 'on',
      'custom_9_show'      => 'on',
      'custom_10_show'      => 'on',
      'custom_11_show'      => 'on',
      'custom_12_show'      => 'on',
      'custom_13_show'      => 'on',
          
      'custom_4_side'      => 'on',
      'custom_7_side'      => 'on',
      'custom_4_icon'      => 'autofont-speedometer',
      'custom_7_icon'      => 'autofont-power',
      'custom_1_list'      => 'on',
      'custom_2_list'      => 'on',
      'custom_3_list'      => 'on',
      'custom_4_list'      => 'on',
      'custom_7_list'      => 'on',   

      'auto-year_show'     => 'on',
      'auto-year_side'     => 'on',
      'auto-year_list'     => 'on',
      'auto-year_icon'     => 'autofont-helmet-2',
          
          
      'auto-warranty_show'     => 'on',
      'first-name_show'     => 'on',
      'auto-currency_show'     => 'on',
      'last-name_show'     => 'on',
      'seller-company_show'     => 'on',
      'auto-warranty_show'     => 'on',
      'seller-email_show'     => 'on',     
      'seller-phone_show'     => 'on',         
      'seller-country_show'     => 'on',     
      'seller-state_show'     => 'on',
      'seller-town_show'     => 'on', 
      'seller-location_show'     => 'on', 
      'seller-location-lat_show'     => 'on', 
      'seller-location-long_show'     => 'on',  
      'auto-date_show'     => 'on',  
           
                   
  );
      $comare_hide_settings =  array('template' => -1, 'no_favorite' => 1, 'no_comp_icon' => 1 );
      update_option('compare_cars_templ', $comare_hide_settings);



  } 
    
    
// update_option('permalink_structure', '/%year%/%monthnum%/%day%/%postname%/');


$Settings->update( 'WP_OPTIONS', '_pixad_autos_settings', serialize( $args ) );
$Settings->update( 'WP_OPTIONS', '_pixad_autos_validation', serialize( $args_validation ) );   
    

    $absolute_path = __FILE__;
    $path_to_file = explode( 'wp-content', $absolute_path );
    $path_to_wp = $path_to_file[0];

    require_once( $path_to_wp.'/wp-load.php' );
    require_once( $path_to_wp.'/wp-includes/functions.php');

    $slider = new RevSlider();

    foreach($slider_array as $filepath){
     $slider->importSliderFromPost(true,true,$filepath);
    }
	
	update_post_meta($blog_page_id->ID,'pix_selected_sidebar','sidebar-1');

}

add_action( 'pt-ocdi/after_import', 'autozone_after_import' );

?>