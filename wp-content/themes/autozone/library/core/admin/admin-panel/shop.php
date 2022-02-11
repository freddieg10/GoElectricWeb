<?php
	
	function autozone_customize_shop_tab($wp_customize, $theme_name){

		$autozone_pix_slider = array( 0 => esc_html__( 'No RevSlider', 'autozone' ) );
		if (class_exists('RevSlider')) {
			$arr = array( 0 => esc_html__( 'No RevSlider', 'autozone' ) );

			$pix_sliders 	= new RevSlider();
			$pix_arrSliders = $pix_sliders->getArrSliders();

			foreach($pix_arrSliders as $slider){
			  $arr[$slider->getAlias()] = $slider->getTitle();
			}
			if($arr){
			  $autozone_pix_slider = $arr;
			}

		}

		$wp_customize->add_section( 'autozone_shop_settings' , array(
		    'title'      => esc_html__( 'Shop', 'autozone' ),
		    'priority'   => 24,
		) );

		$wp_customize->add_setting( 'autozone_shop_header_slider' , array(
			'default'     => 0,
			'transport'   => 'refresh',
			'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_setting( 'autozone_shop_header_image' , array(
			'default'     => '',
			'transport'   => 'refresh',
			'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_control(
			'autozone_shop_header_slider',
			array(
				'label'    => esc_html__( 'Header RevSlider On Main Shop Page', 'autozone' ),
				'section'  => 'autozone_shop_settings',
				'settings' => 'autozone_shop_header_slider',
				'type'     => 'select',
				'choices'  => $autozone_pix_slider
			)
		);

        $wp_customize->add_control(
	        new WP_Customize_Image_Control(
	            $wp_customize,
	            'autozone_shop_header_image',
				array(
				   'label'      => esc_html__( 'Header Image', 'autozone' ),
				   'section'    => 'autozone_shop_settings',
				   'context'    => 'autozone_shop_header_image',
				   'settings'   => 'autozone_shop_header_image',
				   'priority'   => 10
				)
	       )
	    );


				
	}
?>