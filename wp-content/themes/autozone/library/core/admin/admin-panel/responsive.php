<?php

	function autozone_customize_responsive_tab($wp_customize, $theme_name){
	
		$wp_customize->add_section( 'autozone_responsive_settings' , array(
		    'title'      => esc_html__( 'Responsive', 'autozone' ),
		    'priority'   => 22,
		) );

		$wp_customize->add_setting( 'autozone_general_settings_responsive' , array(
		    'default'     => '',
		    'transport'   => 'refresh',
			'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_setting( 'autozone_mobile_sticky' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_setting( 'autozone_mobile_topbar' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_setting( 'autozone_tablet_minicart' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_setting( 'autozone_tablet_search' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_setting( 'autozone_tablet_phone' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_setting( 'autozone_tablet_socials' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );



		$wp_customize->add_control(
			'autozone_general_settings_responsive',
			array(
				'label'    => esc_html__( 'Responsive', 'autozone' ),
				'section'  => 'autozone_responsive_settings',
				'settings' => 'autozone_general_settings_responsive',
				'type'     => 'select',
				'choices'  => array(
					'off'  => esc_html__( 'Off', 'autozone' ),
					'on'   => esc_html__( 'On', 'autozone' ),
				),
				'priority'   => 5
			)
		);

		$wp_customize->add_control(
            'autozone_mobile_sticky',
            array(
                'label'    => esc_html__( 'Header Mobile Behavior', 'autozone' ),
                'description'   => esc_html__( 'Off header sticky or fixed on mobile', 'autozone' ),
                'section'  => 'autozone_responsive_settings',
                'settings' => 'autozone_mobile_sticky',
                'type'     => 'select',
                'choices'  => array(
                    ''  => esc_html__( 'Global', 'autozone' ),
                    'mobile-no-sticky' => esc_html__( 'No Sticky', 'autozone' ),
		            'mobile-no-fixed' => esc_html__( 'No Fixed', 'autozone' ),
                ),
                'priority'   => 10
            )
        );

        $wp_customize->add_control(
            'autozone_mobile_topbar',
            array(
                'label'    => esc_html__( 'Header Mobile Behavior', 'autozone' ),
                'description'   => esc_html__( 'Off header top bar on mobile', 'autozone' ),
                'section'  => 'autozone_responsive_settings',
                'settings' => 'autozone_mobile_sticky',
                'type'     => 'select',
                'choices'  => array(
                    ''  => esc_html__( 'Global', 'autozone' ),
                    'no-mobile-topbar' => esc_html__( 'Off', 'autozone' ),
                ),
                'priority'   => 20
            )
        );

        $wp_customize->add_control(
            'autozone_tablet_minicart',
            array(
                'label'    => esc_html__( 'Tablet Minicart', 'autozone' ),
                'description'   => esc_html__( 'Off header cart on tablet', 'autozone' ),
                'section'  => 'autozone_responsive_settings',
                'settings' => 'autozone_tablet_minicart',
                'type'     => 'select',
                'choices'  => array(
                    ''  => esc_html__( 'Global', 'autozone' ),
                    'no-tablet-minicart' => esc_html__( 'Off', 'autozone' ),
                ),
                'priority'   => 30
            )
        );

        $wp_customize->add_control(
            'autozone_tablet_search',
            array(
                'label'    => esc_html__( 'Tablet Search', 'autozone' ),
                'description'   => esc_html__( 'Off header search on tablet', 'autozone' ),
                'section'  => 'autozone_responsive_settings',
                'settings' => 'autozone_tablet_search',
                'type'     => 'select',
                'choices'  => array(
                    ''  => esc_html__( 'Global', 'autozone' ),
                    'no-tablet-search' => esc_html__( 'Off', 'autozone' ),
                ),
                'priority'   => 40
            )
        );

        $wp_customize->add_control(
            'autozone_tablet_phone',
            array(
                'label'    => esc_html__( 'Tablet Header Phone', 'autozone' ),
                'description'   => esc_html__( 'Off header phone on tablet', 'autozone' ),
                'section'  => 'autozone_responsive_settings',
                'settings' => 'autozone_tablet_phone',
                'type'     => 'select',
                'choices'  => array(
                    ''  => esc_html__( 'Global', 'autozone' ),
                    'no-tablet-phone' => esc_html__( 'Off', 'autozone' ),
                ),
                'priority'   => 50
            )
        );

        $wp_customize->add_control(
            'autozone_tablet_socials',
            array(
                'label'    => esc_html__( 'Tablet Socials', 'autozone' ),
                'description'   => esc_html__( 'Off header social icons on tablet', 'autozone' ),
                'section'  => 'autozone_responsive_settings',
                'settings' => 'autozone_tablet_socials',
                'type'     => 'select',
                'choices'  => array(
                    ''  => esc_html__( 'Global', 'autozone' ),
                    'no-tablet-socials' => esc_html__( 'Off', 'autozone' ),
                ),
                'priority'   => 60
            )
        );
		
	}
		
?>