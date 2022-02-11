<?php

	/******* TGM Plugin ********/
add_action('tgmpa_register', 'autozone_register_required_plugins');

function autozone_register_required_plugins() {
    
    
        $str_plugin_url = 'http://support.templines.com/plugins-load/';
    if(function_exists('pix_theme_code_info')){
        $theme_code = pix_theme_code_info();
        $get_params = array(
            'edd_action' => 'plugins_activation',
            'license_key'    => $theme_code['envato_code'],
            'theme'      => $theme_code['theme'],
            'theme_id'  => $theme_code['theme_id'],
            'url'        => home_url()
        );
        $str_get_params = '';
        if(!empty($theme_code['envato_code']) && !empty($theme_code['theme_id']) && !empty($theme_code['theme']) ){
          $str_get_params = '?' . http_build_query($get_params);
        }
        $str_plugin_url .= $str_get_params;
    }
    
    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(


		/**************************************
        --------  WooCommerce Plugins  --------
		**************************************/

		array(
			'name' => esc_html__('WooCommerce  ', 'autozone'), // The plugin name
			'slug' => 'woocommerce', // The plugin slug (typically the folder name)
			'required' => true, // If false, the plugin is only 'recommended' instead of required
		) ,



		/*************************************
		--------  WordPress Plugins  ---------
        *************************************/

     	array(
			'name' => esc_html__('Contact Form 7', 'autozone'), // The plugin name
			'slug' => 'contact-form-7', // The plugin slug (typically the folder name)
			'required' => true, // If false, the plugin is only 'recommended' instead of required
		) ,
        
        array(
			'name' => esc_html__('Regenerate Thumbnails   ', 'autozone'), // The plugin name
			'slug' => 'regenerate-thumbnails', // The plugin slug (typically the folder name)
			'required' => false, // If false, the plugin is only 'recommended' instead of required
		) ,

        array(
            'name' => esc_html__('Simple Page Ordering   ', 'autozone'), // The plugin name
            'slug' => 'simple-page-ordering', // The plugin slug (typically the folder name)
            'required' => false, // If false, the plugin is only 'recommended' instead of required
        ),

		array(
            'name' => esc_html__('Category Order and Taxonomy Terms Order   ', 'autozone'), // The plugin name
            'slug' => 'taxonomy-terms-order', // The plugin slug (typically the folder name)
            'required' => true, // If false, the plugin is only 'recommended' instead of required
        ),

		array(
			'name' => esc_html__('Mailchimp  ', 'autozone'), // The plugin name
			'slug' => 'mailchimp-for-wp', // The plugin slug (typically the folder name)
			'required' => true, // If false, the plugin is only 'recommended' instead of required
		),

		array(
            'name' => esc_html__('WordPress Importer  ', 'autozone'), // The plugin name
            'slug' => 'wordpress-importer', // The plugin slug (typically the folder name)
            'required' => true, // If false, the plugin is only 'recommended' instead of required
        ),

        array(
            'name' => esc_html__('Meta Box  ( not disable ) ', 'autozone'), // The plugin name
            'slug' => 'meta-box', // The plugin slug (typically the folder name)
            'required' => true, // If false, the plugin is only 'recommended' instead of required
        ),

        array(
            'name' => esc_html__('One Click Demo Import ', 'autozone'), // The plugin name
            'slug' => 'one-click-demo-import', // The plugin slug (typically the folder name)
            'required' => true, // If false, the plugin is only 'recommended' instead of required
        ),
        
        
        array(
            'name' => esc_html__('Theme My Login( only for Auto Dealer options ) ', 'autozone'), // The plugin name
            'slug' => 'theme-my-login', // The plugin slug (typically the folder name)
            'required' => true, // If false, the plugin is only 'recommended' instead of required
        ),
        
        
          array(
            'name' => esc_html__('Page scroll to id', 'autozone'), // The plugin name
            'slug' => 'page-scroll-to-id', // The plugin slug (typically the folder name)
            'required' => true, // If false, the plugin is only 'recommended' instead of required
        ),
        
        
         array(
            'name' => esc_html__('Classic Editor', 'autozone'), // The plugin name
            'slug' => 'classic-editor', // The plugin slug (typically the folder name)
            'required' => true, // If false, the plugin is only 'recommended' instead of required
        ),
        
        
        array(
            'name' => esc_html__('Perfect WooCommerce Brands', 'autozone'), // The plugin name
            'slug' => 'perfect-woocommerce-brands', // The plugin slug (typically the folder name)
            'required' => true, // If false, the plugin is only 'recommended' instead of required
        ),
        
        
    

        /*************************************
        --------  Templines Plugins  ---------
        *************************************/

          array(
                'name' => esc_html__( 'Revolution Slider  ', 'autozone'), // The plugin name
                'slug' => 'revslider', // The plugin slug (typically the folder name)
                'source' => esc_url('http://assets.templines.com/plugins/revslider.zip'), // The plugin source
                'required' => true, // If false, the plugin is only 'recommended' instead of required
                'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url' => ''
            ) ,

            array(
                'name' => esc_html__( 'WPBakery Visual Composer ( required ) ', 'autozone'), // The plugin name
                'slug' => 'js_composer', // The plugin slug (typically the folder name)
                'source' => esc_url('http://assets.templines.com/plugins/js_composer.zip'), // The plugin source
                'required' => true, // If false, the plugin is only 'recommended' instead of required
                'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                'external_url' => ''
            ) ,

        
        
		array(
			'name' => esc_html__( 'Kaswara Modern VC Addons ( required ) ', 'autozone'), // The plugin name
			'slug' => 'kaswara', // The plugin slug (typically the folder name)
            'source' =>  'http://assets.templines.com/plugins/kaswara.zip', // The plugin source
			'required' => true, // If false, the plugin is only 'recommended' instead of required
			'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' => ''
		) ,
        
        
        
        array(
            'name' => esc_html__('Booking auto ( required )', 'autozone'), // The plugin name
            'slug' => 'pix-booking-auto', // The plugin slug (typically the folder name)
            'source' =>  $str_plugin_url.'&plugin='.'pix-booking-auto.zip', // The plugin source 
            'source' =>  'http://assets.templines.com/plugins/pix-booking-auto.zip', // The plugin source
            'required' => true, // If false, the plugin is only 'recommended' instead of required
            'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url' => '' // If set, overrides default API URL and points to an external URL
        ),
        

        array(
            'name' => esc_html__('Font Icons Loader ( required ) ', 'autozone'), // The plugin name
            'slug' => 'font-icons-loader', // The plugin slug (typically the folder name)
            'source' =>  $str_plugin_url.'&plugin='.'font-icons-loader.zip', // The plugin source 
            'required' => true, // If false, the plugin is only 'recommended' instead of required
            'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url' => '' // If set, overrides default API URL and points to an external URL
        ),
        
        
         array(
            'name' => esc_html__('Auto Deal Core ( required )', 'autozone'), // The plugin name
            'slug' => 'pix-auto-deal', // The plugin slug (typically the folder name)
            'source' =>  $str_plugin_url.'&plugin='.'pix-auto-deal.zip', // The plugin source 
            'required' => true, // If false, the plugin is only 'recommended' instead of required
            'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url' => '' // If set, overrides default API URL and points to an external URL
        ),
        
        
        array(
            'name' => esc_html__('Compare cars  ', 'autozone'), // The plugin name
            'slug' => 'compare-cars', // The plugin slug (typically the folder name)
            'source' =>  $str_plugin_url.'&plugin='.'compare-cars.zip', // The plugin source 
            'required' => true, // If false, the plugin is only 'recommended' instead of required
            'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url' => '' // If set, overrides default API URL and points to an external URL
        ),

        array(
            'name' => esc_html__('Theme Core ( required )', 'autozone'), // The plugin name
            'slug' => 'pixtheme-custom', // The plugin slug (typically the folder name)
            'source' =>  $str_plugin_url.'&plugin='.'pixtheme-custom.zip', // The plugin source 
            'required' => true, // If false, the plugin is only 'recommended' instead of required
            'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url' => '' // If set, overrides default API URL and points to an external URL
        ),
        
        
        array(
            'name' => esc_html__('Car locator', 'autozone'), // The plugin name
            'slug' => 'car-locator', // The plugin slug (typically the folder name)
            'source' =>  $str_plugin_url.'&plugin='.'car-locator.zip', // The plugin source 
            'required' => true, // If false, the plugin is only 'recommended' instead of required
            'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url' => '' // If set, overrides default API URL and points to an external URL
        ),
        
        
        array(
            'name' => esc_html__('Dealer locator', 'autozone'), // The plugin name
            'slug' => 'dealer-locator', // The plugin slug (typically the folder name)
            'source' =>  $str_plugin_url.'&plugin='.'dealer-locator.zip', // The plugin source 
            'required' => true, // If false, the plugin is only 'recommended' instead of required
            'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url' => '' // If set, overrides default API URL and points to an external URL
        ),
        
        
        array(
            'name' => esc_html__('Dealer subscriber', 'autozone'), // The plugin name
            'slug' => 'car-subscriber', // The plugin slug (typically the folder name)
            'source' =>  $str_plugin_url.'&plugin='.'car-subscriber.zip', // The plugin source 
            'required' => true, // If false, the plugin is only 'recommended' instead of required
            'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url' => '' // If set, overrides default API URL and points to an external URL
        ),



    );
    
    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'id' => 'tgmpa', // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '', // Default absolute path to pre-packaged plugins.
        'menu' => 'tgmpa-install-plugins', // Menu slug.
        'has_notices' => true, // Show admin notices or not.
        'dismissable' => true, // If false, a user cannot dismiss the nag message.
        'dismiss_msg' => '', // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false, // Automatically activate plugins after installation or not.
        'message' => '', // Message to output right before the plugins table.
        'strings' => array(
            'page_title' => esc_html__('Install Required Plugins', 'autozone'),
            'menu_title' => esc_html__('Install Plugins', 'autozone'),
            'installing' => esc_html__('Installing Plugin: %s', 'autozone'), // %s = plugin name.
            'oops' => esc_html__('Something went wrong with the plugin API.', 'autozone'),
            'notice_can_install_required' => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'autozone'), // %1$s = plugin name(s).
            'notice_can_install_recommended' => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'autozone'), // %1$s = plugin name(s).
            'notice_cannot_install' => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'autozone'), // %1$s = plugin name(s).
            'notice_can_activate_required' => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'autozone'), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'autozone'), // %1$s = plugin name(s).
            'notice_cannot_activate' => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'autozone'), // %1$s = plugin name(s).
            'notice_ask_to_update' => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'autozone'), // %1$s = plugin name(s).
            'notice_cannot_update' => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'autozone'), // %1$s = plugin name(s).
            'install_link' => _n_noop('Begin installing plugin', 'Begin installing plugins', 'autozone'),
            'activate_link' => _n_noop('Begin activating plugin', 'Begin activating plugins', 'autozone'),
            'return' => esc_html__('Return to Required Plugins Installer', 'autozone'),
            'plugin_activated' => esc_html__('Plugin activated successfully.', 'autozone'),
            'complete' => esc_html__('All plugins installed and activated successfully. %s', 'autozone'), // %s = dashboard link.
            'nag_type' => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );
    
    tgmpa($plugins, $config);
    
}
	
?>