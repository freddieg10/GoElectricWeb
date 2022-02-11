<?php
	/**  Core_Frontend  **/

	require_once(get_template_directory() . '/library/core/frontend/functions.php');
	require_once(get_template_directory() . '/library/core/frontend/vc.php');
		
		
	/* Setup language support & image settings */
	function autozone_setup()
	{
	    // Language support 
	    load_theme_textdomain('autozone', get_template_directory() . '/languages');
	    $locale      = get_locale();
	    $locale_file = get_template_directory() . "/languages/$locale.php";
	    if (is_readable($locale_file)) {
	        require_once(get_template_directory() . "/languages/$locale.php");
	    }
	    
	    // ADD SUPPORT FOR POST THUMBS 
	    add_theme_support('post-thumbnails');

	    add_theme_support('woocommerce');
	    add_theme_support('widgets');

	    $args = array(
	        'flex-width' => true,
	        'width' => 350,
	        'flex-height' => true,
	        'height' => 'auto',
	        'default-image' => get_template_directory_uri() . '/images/logo.jpg'
	    );
	    add_theme_support('custom-header', $args);
	    $args = array(
	        'default-color' => 'FFFFFF'
	    );
	    add_theme_support('custom-background', $args);
	    add_theme_support('post-formats', array(
	        'gallery',
	        'quote',
	        'video'
	    ));

	    add_theme_support("title-tag");
	    add_theme_support('automatic-feed-links');

	}
	
	/* Register 3 navi types */
	function autozone_custom_menus()
    {
	    
	    /* Register Navigations */
        register_nav_menus(array(
            'primary_nav' => esc_html__('Primary Navigation', 'autozone'),
            'top_nav' => esc_html__('Top Navigation', 'autozone'),
        ));
    }
	
	
	add_action('after_setup_theme', 'autozone_setup');
	add_action('init', 'autozone_custom_menus');
?>