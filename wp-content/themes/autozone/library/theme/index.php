<?php 
	/**  Theme_index  **/

	/* Define library Theme path */

    $autozone_themeFiles = array(
        'styles_scripts',
        'functions',
		'filters',
	    'vc_templates',
	    'blog',
	    'comment_walker',
		'menu_walker',
		'woo',
	    'pagenavi',
        'import',
        'auto_calculator'
    );

    autozone_load_files($autozone_themeFiles, '/library/theme/');


	add_action('after_setup_theme', 'autozone_theme_support_setup');
	function autozone_theme_support_setup(){

		$witdh_img_auto_cat  = get_theme_mod('autozone_car_page_img_width');
		$height_img_auto_cat = get_theme_mod('autozone_car_page_img_height');




		add_theme_support('autozone_customize_opt');
		add_theme_support('default_customize_opt');
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
		add_image_size('autozone-auto-thumb', 117, 66, true);
		add_image_size('autozone-thumb', 117, 66, false);
		add_image_size('autozone-body-thumb', 200, 130, false);
		// add_image_size('autozone-auto-cat', 235, 196, true);
		add_image_size('autozone-auto-cat', $witdh_img_auto_cat, $height_img_auto_cat, true);
	    add_image_size('autozone-auto-single', 850, 480, false);
		add_image_size('autozone-auto-single_crop', 750, 420, true);
	    add_image_size('autozone_latest_item_feature', 470, 392, true);
	    add_image_size('autozone_latest_item', 320, 181, true);
	    add_image_size('autozone-post-thumb', 470, 280, true);
	   add_image_size('autozone-promo-thumb', 350, 280, false); 

	    update_option( 'autozone_default_main_color', '#dc2d13' );
	    
	    
	    $autozone_translate = array(
			'automatic' => __( 'Automatic', 'autozone' ),
			'manual' => __( 'Manual', 'autozone' ),
			'semi-automatic' => __( 'Semi-Automatic', 'autozone' ),
			'diesel' => __( 'Diesel', 'autozone' ),
			'electric' => __( 'Electric', 'autozone' ),
			'petrol' => __( 'Petrol', 'autozone' ),
			'hybrid' => __( 'Hybrid', 'autozone' ),
			'plugin_electric' => __( 'Plugin electric', 'autozone' ),
			'petrol+cng' => __( 'Petrol+CNG', 'autozone'  ),
			'lpg' => __( 'LPG', 'autozone'  ),
			'new' => __( 'New', 'autozone' ),
			'used' => __( 'Used', 'autozone' ),
			'driver' => __( 'Driver', 'autozone' ),
			'non driver' => __( 'Non driver', 'autozone' ),
			'barnfind' => __( 'Barnfind', 'autozone' ),
			'projectcar' => __( 'Projectcar', 'autozone' ),
			'in stock' => __( 'In stock', 'autozone' ),
			'expected' => __( 'Expected', 'autozone' ),
			'out of stock' => __( 'Out of stock', 'autozone' ),
			'front' => __( 'Front', 'autozone' ),
			'rear' => __( 'Rear', 'autozone' ),
			'left' => __( 'Left', 'autozone' ),
			'right' => __( 'Right', 'autozone' ),
			'fixed' => __( 'Fixed', 'autozone' ),
			'negotiable' => __( 'Negotiable', 'autozone' ),
			'no' => __( 'No', 'autozone' ),
			'yes' => __( 'Yes', 'autozone' ),
			'Featured' => __( 'Featured', 'autozone' ),
			'Sold' => __( 'Sold', 'autozone' ),
			'Request' => __( 'Request', 'autozone' ),
			'Reserved' => __( 'Reserved', 'autozone' ),
			'POA' => __( 'POA', 'autozone' ),
			'white' => __( 'white', 'autozone' ),
			'silver' => __( 'silver', 'autozone' ),
			'black' => __( 'black', 'autozone' ),
			'grey' => __( 'grey', 'autozone' ),
			'blue' => __( 'blue', 'autozone' ),
			'red' => __( 'red', 'autozone' ),
			'brown' => __( 'brown', 'autozone' ),
			'beige' => __( 'beige', 'autozone' ),
			'green' => __( 'green', 'autozone' ),
			'yellow' => __( 'yellow', 'autozone' ),
			'orange' => __( 'orange', 'autozone' ),
			'purple' => __( 'purple', 'autozone' ),
			'Year' => __( 'Year', 'autozone' ),
			'Drive' => __( 'Drive', 'autozone' ),
			'Auto Make' => __( 'Auto Make', 'autozone' ),
			'Auto Model' => __( 'Auto Model', 'autozone' ),
			'Auto Version' => __( 'Auto Version', 'autozone' ),
			'Mileage' => __( 'Mileage', 'autozone' ),
			'Fuel' => __( 'Fuel', 'autozone' ),
			'Engine' => __( 'Engine', 'autozone' ),
			'Horsepower' => __( 'Horsepower', 'autozone' ),
			'Transmission' => __( 'Transmission', 'autozone' ),
			'Doors' => __( 'Doors', 'autozone' ),
			'Seats' => __( 'Seats', 'autozone' ),
			'Color' => __( 'Color', 'autozone' ),
			'Interior Color' => __( 'Interior Color', 'autozone' ),
			'Condition' => __( 'Condition', 'autozone' ),
			'Purpose' => __( 'Purpose', 'autozone' ),
			'VIN' => __( 'VIN', 'autozone' ),
			'Price' => __( 'Price', 'autozone' ),
			'Sale Price' => __( 'Sale Price', 'autozone' ),
			'Stock Status' => __( 'Stock Status', 'autozone' ),
			'Price Type' => __( 'Price Type', 'autozone' ),
			'Warranty' => __( 'Warranty', 'autozone' ),
			'Currency' => __( 'Currency', 'autozone' ),
			'Updated Date' => __( 'Updated Date', 'autozone' ),

		);

        update_option( '_pixad_auto_translate', serialize( $autozone_translate ) );
	        
	}

	if ( ! isset( $content_width ) ) {
		$content_width = 1200;
	}

		include_once( get_template_directory() . '/library/about.php');

?>