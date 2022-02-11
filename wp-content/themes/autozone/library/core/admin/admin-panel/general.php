<?php 
	
	function autozone_customize_general_tab($wp_customize, $theme_name){
	
		$wp_customize->add_section( 'autozone_general_settings' , array(
		    'title'      => esc_html__( 'General Settings', 'autozone' ),
		    'priority'   => 20,
		) );
        
        
        $wp_customize->add_setting( 'autozone_map_api' , array(
            'default'     => '1sadgjjhghk2asd3wer452fsgsa6789',
            'transport'   => 'refresh',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'autozone_map_api',
            array(
                'label' => esc_html__( 'Google Map Api Key', 'autozone' ),
                'type' => 'text',
                'section' => 'autozone_general_settings',
                'settings' => 'autozone_map_api',
                'priority'   => 120
            )
        );






        $wp_customize->add_setting( 'autozone_car_page_img_width' , array(
            'default'     => '235',
            'transport'   => 'refresh',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'autozone_car_page_img_width',
            array(
                'label' => esc_html__( 'IMG Width on car listing page', 'autozone' ),
                'type' => 'text',
                'section' => 'autozone_general_settings',
                'settings' => 'autozone_car_page_img_width',
                'priority'   => 120
            )
        );
        $wp_customize->add_setting( 'autozone_car_page_img_height' , array(
            'default'     => '196',
            'transport'   => 'refresh',
            'sanitize_callback' => 'esc_attr'
        ) );
        $wp_customize->add_control(
            'autozone_car_page_img_height',
            array(
                'label' => esc_html__( 'IMG Height on car listing page', 'autozone' ),
                'type' => 'text',
                'section' => 'autozone_general_settings',
                'settings' => 'autozone_car_page_img_height',
                'priority'   => 120
            )
        );







		
		
		/* logo image */ 
		
		$wp_customize->add_setting( 'autozone_general_settings_logo' , array(
			'default'     => '',
			'transport'   => 'refresh',
			'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_setting( 'autozone_general_settings_logo_inverse' , array(
			'default'     => '',
			'transport'   => 'refresh',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_setting( 'autozone_general_settings_404_image' , array(
			'default'     => '',
			'transport'   => 'refresh',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		
		$wp_customize->add_setting( 'autozone_general_settings_logo_text' , array(
		    'default'     => '',
		    'transport'   => 'refresh',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_setting( 'autozone_general_settings_map_api' , array(
		    'default'     => '',
		    'transport'   => 'refresh',
			'sanitize_callback' => 'sanitize_text_field'
		) );


		
		
		$wp_customize->add_control(
	        new WP_Customize_Image_Control(
	            $wp_customize,
	            'autozone_general_settings_logo',
				array(
				   'label'      => esc_html__( 'Logo image light', 'autozone' ),
				   'section'    => 'autozone_general_settings',
				   'context'    => 'autozone_general_settings_logo',
				   'settings'   => 'autozone_general_settings_logo',
				   'priority'   => 50
				)
	       )
	    );

	    $wp_customize->add_control(
	        new WP_Customize_Image_Control(
	            $wp_customize,
	            'autozone_general_settings_logo_inverse',
				array(
				   'label'      => esc_html__( 'Logo image dark', 'autozone' ),
				   'section'    => 'autozone_general_settings',
				   'context'    => 'autozone_general_settings_logo_inverse',
				   'settings'   => 'autozone_general_settings_logo_inverse',
				   'priority'   => 60
				)
	       )
	    );

	$wp_customize->add_control(
	        new WP_Customize_Image_Control(
	            $wp_customize,
	            'autozone_general_settings_404_image',
				array(
				   'label'      => esc_html__( '404 Image', 'autozone' ),
				   'section'    => 'autozone_general_settings',
				   'context'    => 'autozone_general_settings_404_image',
				   'settings'   => 'autozone_general_settings_404_image',
				   'priority'   => 61
				)
	       )
	    );
        

	
		
        
       






		$wp_customize->add_setting( 'autozone_general_settings_logo_width' , array(
		    'default'     => '',
		    'transport'   => 'refresh',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
			'autozone_general_settings_logo_width',
			array(
				'label'    => esc_html__( 'Logo Max Width', 'autozone' ),
				'description'=> esc_html__( 'Retina Logo should be 2x large than max width', 'autozone' ),
				'section'  => 'autozone_general_settings',
				'settings' => 'autozone_general_settings_logo_width',
				'type'     => 'text',
				'priority'   => 62
			)
		);

		$wp_customize->add_setting(	'autozone_general_settings_logo_horizontal_pos', array(
				'default' => '0',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control(
			new Autozone_Slider_Single_Control(
				$wp_customize,
				'autozone_general_settings_logo_horizontal_pos',
				array(
					'label' => esc_html__( 'Logo Horizontal Position', 'autozone' ),
					'section' => 'autozone_general_settings',
					'settings' => 'autozone_general_settings_logo_horizontal_pos',
					'min' => -100,
					'max' => 100,
					'priority'   => 64
				)
			)
		);

		$wp_customize->add_setting(	'autozone_general_settings_logo_vertical_pos', array(
				'default' => '0',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control(
			new Autozone_Slider_Single_Control(
				$wp_customize,
				'autozone_general_settings_logo_vertical_pos',
				array(
					'label' => esc_html__( 'Logo Vertical Position', 'autozone' ),
					'section' => 'autozone_general_settings',
					'settings' => 'autozone_general_settings_logo_vertical_pos',
					'min' => -100,
					'max' => 100,
					'priority'   => 66
				)
			)
		);
	








		
	}
	
	