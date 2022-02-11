<?php

function autozone_fonts_url($post_id) {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	* supported by Lora, translate this to 'off'. Do not translate
	* into your own language.
	*/

	$autozone_font = autozone_get_option('font', get_option('autozone_default_font'));
	$autozone_font_weights = autozone_get_option('font_weights', get_option('autozone_default_font_weights'));

    $autozone = _x( 'on', 'Roboto fonts: on or off', 'autozone' );

	if ( 'off' !== $autozone ) {
		$font_families = array();

        if ( 'off' !== $autozone ) {
			$font_families[] = 'Raleway:300,400,500,600,700,800|Ubuntu:300,400,500,700|Droid+Serif:400italic';
		}

		if( $autozone_font != '' ) {
			$cf = $autozone_font;
			if ( $autozone_font_weights != '' )
				$cf .= ':'.$autozone_font_weights;
			$font_families[] = $cf;
		}

		$query_args = array(
			'family' => str_replace('%2B', '+', urlencode( implode( '|', $font_families ) )),
			'subset' => urlencode( 'latin,cyrillic,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}


add_action('wp_enqueue_scripts', 'autozone_load_styles_and_scripts');
add_filter('body_class','autozone_browser_body_class');

add_filter('woocommerce_enqueue_styles', 'autozone_load_woo_styles');
function autozone_load_woo_styles($styles){
	if (isset($styles['woocommerce-general']) && isset($styles['woocommerce-general']['src'])){
		$styles['woocommerce-general']['src'] = get_template_directory_uri() . '/assets/woocommerce/css/woocommerce.css';
	}
	if (isset($styles['woocommerce-layout']) && isset($styles['woocommerce-layout']['src'])){
		$styles['woocommerce-layout']['src'] = get_template_directory_uri() . '/assets/woocommerce/css/woocommerce-layout.css';
	}
	return $styles;
}

function autozone_load_styles_and_scripts(){

    wp_enqueue_style('style', get_stylesheet_uri());


    wp_enqueue_style('autozone-master', get_template_directory_uri() . '/css/master.css');
    wp_enqueue_style('autozone-assetscss', get_template_directory_uri() . '/assets/assets.min.css');
    wp_enqueue_style('autozone-fonts', autozone_fonts_url(get_the_ID()), array(), null );
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/fonts/fontawesome/css/font-awesome.min.css');
    wp_enqueue_style('autozone-header', get_template_directory_uri() . '/assets/header/header.css');
    wp_enqueue_style('autozone-header-yamm', get_template_directory_uri() . '/assets/header/yamm.css'); 
    wp_enqueue_style('autozone-select2', get_template_directory_uri() . '/assets/select2/css/select2.min.css');
    
    
    
    wp_enqueue_script('migrate', get_template_directory_uri() . '/js/jquery-migrate-1.2.1.js', array('jquery') , '3.3', false);
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js', array('jquery') , '3.3', false);
    wp_enqueue_script('modernizr', get_template_directory_uri() . '/js/modernizr.custom.js', array('jquery') , '3.3', false);
    wp_enqueue_script('autozone-degrees360js', get_template_directory_uri() . '/assets/degrees360/js/main.js', array() , '1.1', true);
    wp_enqueue_script('autozone-mobile360js', get_template_directory_uri() . '/assets/degrees360/js/jquery.mobile.custom.min.js', array() , '1.1', true);
    
     wp_enqueue_script('assets.min.js', get_template_directory_uri() . '/assets/assets.min.js', array('jquery') , '1.2', true);
     wp_enqueue_script('select2', get_template_directory_uri() . '/assets/select2/js/select2.min.js', array('jquery') , '1.0', false);



    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}



    // Waypoint
    wp_enqueue_script('waypoints', get_template_directory_uri() . '/js/waypoints.min.js', array() , '3.3', true);
  
    // Google Maps
    //wp_enqueue_script('google-maps', autozone_google_map_url(), array( 'jquery' ), null , true);


    wp_enqueue_script('slidebar', get_template_directory_uri() . '/assets/header/slidebar.js', array('jquery') , '1.1', true);
    wp_enqueue_script('autozone-header', get_template_directory_uri() . '/assets/header/header.js', array('jquery') , '1.1', true);
    wp_enqueue_script('slidebars', get_template_directory_uri() . '/assets/header/slidebars.js', array('jquery') , '1.1', true);
    wp_enqueue_script('doubletap', get_template_directory_uri() . '/assets/header/doubletap.js', array('jquery') , '1.1', true);
    wp_enqueue_script('stickykit', get_template_directory_uri() . '/assets/sticky-kit/sticky-kit.js', array('jquery') , '1.1', true);

    wp_enqueue_script('wNumb', get_template_directory_uri() . '/js/wNumb.js', array() , '1.1', true); 
    wp_enqueue_script('jquery_number', get_template_directory_uri() . '/js/jquery.number.min.js', array() , '1.1', true);


    wp_enqueue_script('autozone-custom', get_template_directory_uri() . '/js/custom.js', array() , '1.1', true);

 
	ob_start();
    include( get_template_directory().'/css/dynamic-styles.php' );
	$dynamic_styles = ob_get_contents();
	ob_clean();		
	
	wp_add_inline_style( 'autozone-master', $dynamic_styles );

}


function autozone_google_map_url() {
   $map_key = get_theme_mod('autozone_map_api');
    $map_url = 'https://maps.googleapis.com/maps/api/js?key='.$map_key.'&callback=initMap';
    return esc_url_raw( $map_url );
}



function autozone_dynamic_styles() {
	include( get_template_directory().'/css/dynamic-styles.php' );
	exit;
}
//add_action('wp_ajax_dynamic_styles', 'autozone_dynamic_styles');
//add_action('wp_ajax_nopriv_dynamic_styles', 'autozone_dynamic_styles');

function autozone_browser_body_class($classes = '') {
    $classes[] = 'animated-css';
    $classes[] = 'layout-switch';

    if (autozone_get_option('header_settings_type')){
        $headerType = autozone_get_option('header_settings_type');
        $classes[] =  'home-construction-v' . $headerType;
    }

    return $classes;
}

?>