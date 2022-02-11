<?php

	function autozone_customize_search_tab($wp_customize, $theme_name){
	
		$wp_customize->add_section( 'autozone_search_settings' , array(
		    'title'      => esc_html__( 'Search', 'autozone' ),
		    'priority'   => 23,
		) );

		
		$wp_customize->add_setting( 'autozone_search_placeholder' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_setting( 'autozone_search_description' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );



		$wp_customize->add_control(
			'autozone_search_placeholder',
			array(
				'label'    => esc_html__( 'Search Placeholder', 'autozone' ),
				'section'  => 'autozone_search_settings',
				'settings' => 'autozone_search_placeholder',
				'type'     => 'text',
				'priority'   => 10
			)
		);

		$wp_customize->add_control(
			'autozone_search_description',
			array(
				'label'    => esc_html__( 'Search Description', 'autozone' ),
				'section'  => 'autozone_search_settings',
				'settings' => 'autozone_search_description',
				'type'     => 'text',
				'priority'   => 20
			)
		);
		
	}
		
?>