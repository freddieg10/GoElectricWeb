<?php 
	
	function autozone_customize_loader_tab($wp_customize, $theme_name){
	
		$wp_customize->add_section( 'autozone_loader_settings' , array(
		    'title'      => esc_html__( 'Loader Settings', 'autozone' ),
		    'priority'   => 20,
		) );
        
        
      

		$wp_customize->add_setting( 'autozone_loader_settings_loader' , array(
		    'default'     => '',
		    'transport'   => 'refresh',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		
		
		
        
	   
		$wp_customize->add_control(
			'autozone_loader_settings_loader',
			array(
				'label'    => esc_html__( 'Page Loader', 'autozone' ),
				'section'  => 'autozone_loader_settings',
				'settings' => 'autozone_loader_settings_loader',
				'type'     => 'select',
				'choices'  => array(
					'off'  => esc_html__( 'Off', 'autozone' ),
					'usemain' => esc_html__( 'Use on main', 'autozone' ),
					'useall' => esc_html__( 'Use on all pages', 'autozone' ),
				),
				'priority'   => 10
			)
		);

        $wp_customize->add_setting( 'autozone_loader_settings_img' , array(
			'default'     => '',
			'transport'   => 'refresh',
			'sanitize_callback' => 'sanitize_text_field'
		) );

				$wp_customize->add_control(
	        new WP_Customize_Image_Control(
	            $wp_customize,
	            'autozone_loader_settings_img',
				array(
				   'label'      => esc_html__( 'Page Loader', 'autozone' ),
				   'section'    => 'autozone_loader_settings',
				   'context'    => 'autozone_loader_settings_img',
				   'settings'   => 'autozone_loader_settings_img',
				   'priority'   => 50
				)
	       )
	    );

		        $wp_customize->add_setting( 'autozone_filter_loader_settings_img' , array(
			'default'     => '',
			'transport'   => 'refresh',
			'sanitize_callback' => 'sanitize_text_field'
		) );

				$wp_customize->add_control(
	        new WP_Customize_Image_Control(
	            $wp_customize,
	            'autozone_filter_loader_settings_img',
				array(
				   'label'      => esc_html__( 'Filter Loader', 'autozone' ),
				   'section'    => 'autozone_loader_settings',
				   'context'    => 'autozone_filter_loader_settings_img',
				   'settings'   => 'autozone_filter_loader_settings_img',
				   'priority'   => 50
				)
	       )
	    );		
       

		
		
	}
	
	