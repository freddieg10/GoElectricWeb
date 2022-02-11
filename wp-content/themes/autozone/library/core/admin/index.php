<?php
	
	/*  Redirect To Theme Options Page on Activation  */
	if (is_admin() && isset($_GET['activated'])) {
	    wp_redirect(admin_url('themes.php'));
	}
	
	/*  Load custom admin scripts & styles  */
	function autozone_load_custom_wp_admin_style()	{
		wp_enqueue_media();
		
		wp_register_script( 'autozone_custom_wp_admin_script', get_template_directory_uri() . '/js/custom-admin.js', array( 'jquery' ) );
	    wp_localize_script( 'autozone_custom_wp_admin_script', 'meta_image',
	        array(
	            'title' => esc_html__( 'Choose or Upload an Image', 'autozone' ),
	            'button' => esc_html__( 'Use this image', 'autozone' ),
	        )
	    );

		// ion.rangeSlider
        wp_enqueue_style('ion.rangeSlider', get_template_directory_uri() . '/library/core/admin/js/ion-rangeSlider/css/ion.rangeSlider.css');
        wp_enqueue_style('ion.rangeSlider.skinModern', get_template_directory_uri() . '/library/core/admin/js/ion-rangeSlider/css/ion.rangeSlider.skinNice.css');
        wp_enqueue_script('ion.rangeSlider', get_template_directory_uri() . '/library/core/admin/js/ion-rangeSlider/js/ion.rangeSlider.min.js', array('jquery') , false, true);
        wp_enqueue_script('wNumb', get_template_directory_uri() . '/library/core/admin/js/ion-rangeSlider/js/wNumb.js', array('jquery'), false, true);
        

	    wp_enqueue_script( 'autozone_custom_wp_admin_script' );
	    wp_enqueue_style('autozone-custom', get_template_directory_uri() . '/css/custom-admin.css');
	    
	    // Add the color picker css file
	    wp_enqueue_style( 'wp-color-picker' );
	    // Include our custom jQuery file with WordPress Color Picker dependency
	    wp_enqueue_script( 'autozone-color', get_template_directory_uri() . '/js/custom-script.js', array( 'wp-color-picker' ), false, true );
	}
	
	function autozone_add_editor_styles() {
		add_editor_style( 'autozone-editor-style.css' );
	}
	function autozone_customizer_callback() {
		wp_enqueue_script( 'autozone-customizer-preview', get_template_directory_uri() . '/library/core/admin/js/customizer-preview.js', array( 'jquery', 'customize-preview' ) );
	}

	add_filter('login_headerurl', function(){return get_home_url('/');});
	add_filter('login_headertitle', function(){return false;});
	add_action('admin_enqueue_scripts', 'autozone_load_custom_wp_admin_style');
	add_action('admin_init', 'autozone_add_editor_styles' );
	add_action('customize_preview_init', 'autozone_customizer_callback');

    
    function autozone_staticblock_admin_notice(){
    
        add_option('pix_adm_notice_stblock', '1');
        if ( get_option('pix_adm_notice_stblock') ) {


	        $post_type = isset($_GET['post_type']) ?  $_GET['post_type'] : ''  ;
	    
	        if ( isset($_GET['post'] ))
	            $post_type =   get_post($_GET['post'])->post_type;
	    
	        if ( $post_type == 'staticblocks'  ) {
	            echo '<div id="pix_adm_notice_stblock" class="notice notice-error  tmpl-notice-error"> 
	                     <p>
	                     '.esc_html__( 'Please activate WPBakery Page Builder  for Static Blocks post type', 'autozone' ).'
	                     <a href="'.get_admin_url().'admin.php?page=vc-roles">'.esc_html__( 'here', 'autozone' ).'</a>
	                     ' . "<a href='#' class='button adm_notice_stblock'><i class='dashicons dashicons-dismiss'></i> " . esc_html__("Hide notice", "autozone") . '</a></p>'  . 
	                     '</div>';
	        }
    	}
    }
        add_action('admin_notices', 'autozone_staticblock_admin_notice');
	// Hide admin notice
	if ( !function_exists( 'pix_hide_notice_stblock' ) ) {
	    function pix_hide_notice_stblock() {
	        update_option('pix_adm_notice_stblock', '0');
	        exit;
	    }
	}
	add_action('wp_ajax_pix_hide_notice_stblock', 'pix_hide_notice_stblock');
	// Update admin notice status 
	if ( !function_exists( 'pix_admin_notice_update_stblock' ) ) {
	    function pix_admin_notice_update_stblock() {
	        update_option('pix_adm_notice_stblock', '1');
	    }
	}
	add_action('after_switch_theme', 'pix_admin_notice_update_stblock');
	
	
	/* Admin Panel */
	require_once(get_template_directory() . '/library/core/admin/admin-panel.php');
	
	
	require_once(get_template_directory() . '/library/core/admin/class-tgm-plugin-activation.php');
	
	if (class_exists('PixthemeCustom')) {
		$pixtheme_plugin_dir = ABSPATH . 'wp-content/plugins/pixtheme-custom/';
		require_once($pixtheme_plugin_dir. '/post-fields.php');
	}

	require_once(get_template_directory() . '/library/core/admin/functions.php');
	

?>