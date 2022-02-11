<?php
    function autozone_customize_blog_tab($wp_customize, $theme_name){

        $wp_customize->add_section( 'autozone_blog_settings' , array(
            'title'      => esc_html__( 'Blog', 'autozone' ),
            'priority'   => 25,
        ) );

        $wp_customize->add_setting( 'autozone_blog_settings_date' , array(
			'default'     => '1',
			'transport'   => 'refresh',
            'theme_supports' => 'autozone_customize_opt',
		    'sanitize_callback' => 'esc_attr',
		) );
        
		$wp_customize->add_setting( 'autozone_blog_settings_author_name' , array(
			'default'     => '1',
			'transport'   => 'refresh',
            'theme_supports' => 'autozone_customize_opt',
		    'sanitize_callback' => 'esc_attr',
		) );

		$wp_customize->add_setting( 'autozone_blog_settings_author' , array(
			'default'     => '1',
			'transport'   => 'refresh',
            'theme_supports' => 'autozone_customize_opt',
		    'sanitize_callback' => 'esc_attr',
		) );

		$wp_customize->add_setting( 'autozone_blog_settings_comments' , array(
			'default'     => '1',
			'transport'   => 'refresh',
            'theme_supports' => 'autozone_customize_opt',
		    'sanitize_callback' => 'esc_attr',
		) );

        $wp_customize->add_setting( 'autozone_blog_settings_categories' , array(
			'default'     => '1',
			'transport'   => 'refresh',
            'theme_supports' => 'autozone_customize_opt',
		    'sanitize_callback' => 'esc_attr',
		) );

		$wp_customize->add_setting( 'autozone_blog_settings_tags' , array(
			'default'     => '1',
			'transport'   => 'refresh',
            'theme_supports' => 'autozone_customize_opt',
		    'sanitize_callback' => 'esc_attr',
		) );
		
        $wp_customize->add_setting( 'autozone_blog_settings_share' , array(
            'default'     => '1',
            'transport'   => 'refresh',
            'theme_supports' => 'autozone_customize_opt',
            'sanitize_callback' => 'esc_attr',
        ) );
        $wp_customize->add_setting( 'autozone_blog_settings_share_fb' , array(
            'default'     => '1',
            'transport'   => 'refresh',
            'theme_supports' => 'autozone_customize_opt',
            'sanitize_callback' => 'esc_attr',
        ) );
        $wp_customize->add_setting( 'autozone_blog_settings_share_tw' , array(
            'default'     => '1',
            'transport'   => 'refresh',
            'theme_supports' => 'autozone_customize_opt',
            'sanitize_callback' => 'esc_attr',
        ) );
        $wp_customize->add_setting( 'autozone_blog_settings_share_gl' , array(
            'default'     => '1',
            'transport'   => 'refresh',
            'theme_supports' => 'autozone_customize_opt',
            'sanitize_callback' => 'esc_attr',
        ) );
        
        $wp_customize->add_setting( 'autozone_blog_settings_readmore' , array(
            'default'     => esc_html__( 'Read more', 'autozone' ),
            'transport'   => 'refresh',
            'theme_supports' => 'autozone_customize_opt',
		    'sanitize_callback' => 'esc_html',
        ) );


        $wp_customize->add_control(
            'autozone_blog_settings_date',
            array(
                'label'    => esc_html__( 'Display Date on blog posts', 'autozone' ),
                'section'  => 'autozone_blog_settings',
                'settings' => 'autozone_blog_settings_date',
                'type'     => 'select',
                'choices'  => array(
                    '0'  => esc_html__( 'Off', 'autozone' ),
                    '1' => esc_html__( 'On', 'autozone' ),
                ),
                'priority'   => 50
            )
        );
        
        $wp_customize->add_control(
            'autozone_blog_settings_author_name',
            array(
                'label'    => esc_html__( 'Display Author name on blog page and single post', 'autozone' ),
                'section'  => 'autozone_blog_settings',
                'settings' => 'autozone_blog_settings_author_name',
                'type'     => 'select',
                'choices'  => array(
                    '0'  => esc_html__( 'Off', 'autozone' ),
                    '1' => esc_html__( 'On', 'autozone' ),
                ),
                'priority'   => 60
            )
        );
        
        $wp_customize->add_control(
            'autozone_blog_settings_author',
            array(
                'label'    => esc_html__( 'Display About Author block on single post', 'autozone' ),
                'section'  => 'autozone_blog_settings',
                'settings' => 'autozone_blog_settings_author',
                'type'     => 'select',
                'choices'  => array(
                    '0'  => esc_html__( 'Off', 'autozone' ),
                    '1' => esc_html__( 'On', 'autozone' ),
                ),
                'priority'   => 70
            )
        );
        
        $wp_customize->add_control(
            'autozone_blog_settings_comments',
            array(
                'label'    => esc_html__( 'Display Comments on single post', 'autozone' ),
                'section'  => 'autozone_blog_settings',
                'settings' => 'autozone_blog_settings_comments',
                'type'     => 'select',
                'choices'  => array(
                    '0'  => esc_html__( 'Off', 'autozone' ),
                    '1' => esc_html__( 'On', 'autozone' ),
                ),
                'priority'   => 80
            )
        );
        
        $wp_customize->add_control(
            'autozone_blog_settings_categories',
            array(
                'label'    => esc_html__( 'Display Categories', 'autozone' ),
                'section'  => 'autozone_blog_settings',
                'settings' => 'autozone_blog_settings_categories',
                'type'     => 'select',
                'choices'  => array(
                    '0'  => esc_html__( 'Off', 'autozone' ),
                    '1' => esc_html__( 'On', 'autozone' ),
                ),
                'priority'   => 90
            )
        );
        
        $wp_customize->add_control(
            'autozone_blog_settings_tags',
            array(
                'label'    => esc_html__( 'Display Tags', 'autozone' ),
                'section'  => 'autozone_blog_settings',
                'settings' => 'autozone_blog_settings_tags',
                'type'     => 'select',
                'choices'  => array(
                    'off'  => esc_html__( 'Off', 'autozone' ),
                    'on' => esc_html__( 'On', 'autozone' ),
                ),
                'priority'   => 100
            )
        );
        
        $wp_customize->add_control(
            'autozone_blog_settings_share',
            array(
                'label'    => esc_html__( 'Display share buttons on single post', 'autozone' ),
                'section'  => 'autozone_blog_settings',
                'settings' => 'autozone_blog_settings_share',
                'type'     => 'select',
                'choices'  => array(
                    '0'  => esc_html__( 'Off', 'autozone' ),
                    '1' => esc_html__( 'On', 'autozone' ),
                ),
                'priority'   => 110
            )
        );

       $wp_customize->add_control(
            'autozone_blog_settings_share_fb',
            array(
                'label'    => esc_html__( 'Display Facebook share button on single post', 'autozone' ),
                'section'  => 'autozone_blog_settings',
                'settings' => 'autozone_blog_settings_share_fb',
                'type'     => 'select',
                'choices'  => array(
                    '0'  => esc_html__( 'Off', 'autozone' ),
                    '1' => esc_html__( 'On', 'autozone' ),
                ),
                'priority'   => 120
            )
        );
        $wp_customize->add_control(
            'autozone_blog_settings_share_tw',
            array(
                'label'    => esc_html__( 'Display Twitter share button on single post', 'autozone' ),
                'section'  => 'autozone_blog_settings',
                'settings' => 'autozone_blog_settings_share_tw',
                'type'     => 'select',
                'choices'  => array(
                    '0'  => esc_html__( 'Off', 'autozone' ),
                    '1' => esc_html__( 'On', 'autozone' ),
                ),
                'priority'   => 120
            )
        );
        $wp_customize->add_control(
            'autozone_blog_settings_share_gl',
            array(
                'label'    => esc_html__( 'Display Google+ share button on single post', 'autozone' ),
                'section'  => 'autozone_blog_settings',
                'settings' => 'autozone_blog_settings_share_gl',
                'type'     => 'select',
                'choices'  => array(
                    '0'  => esc_html__( 'Off', 'autozone' ),
                    '1' => esc_html__( 'On', 'autozone' ),
                ),
                'priority'   => 120
            )
        );
        


        $wp_customize->add_control(
            'autozone_blog_settings_readmore',
            array(
                'label'    => esc_html__( 'Read More button text', 'autozone' ),
                'section'  => 'autozone_blog_settings',
                'settings' => 'autozone_blog_settings_readmore',
                'type'     => 'textfield',
                'priority'   => 10
            )
        );


    }
?>