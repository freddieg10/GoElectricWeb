<?php

function autozone_customize_style_tab($wp_customize, $theme_name) {

	$wp_customize->add_panel('autozone_style_panel',  array(
        'title' => 'Style',
        'priority' => 25,
        )
    );


	/// COLOR SETTINGS ///

	$wp_customize->add_section( 'autozone_style_settings' , array(
	    'title'      => esc_html__( 'Color', 'autozone' ),
	    'priority'   => 20,
		'panel' => 'autozone_style_panel'
	) );


	$wp_customize->add_setting(
		'autozone_style_settings_main_color',
		array(
			'default' => get_option('autozone_default_main_color'),
			'transport'   => 'refresh',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'autozone_style_settings_main_color',
			array(
				'label' => esc_html__( 'Main Color', 'autozone' ),
				'section' => 'autozone_style_settings',
				'settings' => 'autozone_style_settings_main_color',
				'priority'   => 10
			)
		)
	);



	/// FONT SETTINGS ///

	$wp_customize->add_section( 'autozone_style_font_settings' , array(
		'title'      => esc_html__( 'Fonts', 'autozone' ),
		'priority'   => 30,
		'panel' => 'autozone_style_panel',
	) );

	$wp_customize->add_setting( 'autozone_font' , array(
		'default'     => get_option('autozone_default_font'),
		'transport'   => 'refresh',
		'sanitize_callback' => 'esc_attr'
	) );
    $wp_customize->add_control(
        new Autozone_Google_Fonts_Control(
			$wp_customize,
			'autozone_font',
			array(
				'label' => esc_html__( 'Font', 'autozone' ),
				'section' => 'autozone_style_font_settings',
				'settings' => 'autozone_font',
				'priority'   => 20
			)
		)
	);

	$wp_customize->add_setting( 'autozone_font_weights' , array(
		'default'     => get_option('autozone_default_font_weights'),
		'transport'   => 'postMessage',
		'sanitize_callback' => 'esc_attr'
	) );
    $wp_customize->add_control(
        new Autozone_Google_Font_Weight_Control(
			$wp_customize,
			'autozone_font_weights',
			array(
				'label' => esc_html__( 'Font Variants to Load', 'autozone' ),
				'section' => 'autozone_style_font_settings',
				'settings' => 'autozone_font_weights',
				'hidden_class' => 'font_value',
				'container_class' => 'font',
				'priority'   => 30
			)
		)
	);


}

