<?php

	function autozone_header_type_callback( $control ) {
	    if ( $control->manager->get_setting('autozone_header_type')->value() == 'header3' ) {
	        return true;
	    } else {
	        return false;
	    }
	}

	function autozone_header_type12_callback( $control ) {
	    if ( $control->manager->get_setting('autozone_header_type')->value() != 'header3' ) {
	        return true;
	    } else {
	        return false;
	    }
	}

	function autozone_header_background_callback( $control ) {
	    if (  in_array($control->manager->get_setting('autozone_header_background')->value(), array('trans-white', 'trans-black')) ) {
	        return true;
	    } else {
	        return false;
	    }
	}

	function autozone_header_menu_callback( $control ) {
	    if (  $control->manager->get_setting('autozone_header_menu')->value() != 0 ) {
	        return true;
	    } else {
	        return false;
	    }
	}

	function autozone_customize_header_tab($wp_customize, $theme_name){

		$wp_customize->add_panel('autozone_header_panel',  array(
            'title' => 'Header',
            'priority' => 21,
            )
        );

		$wp_customize->add_section( 'autozone_header_settings' , array(
		    'title'      => esc_html__( 'General Settings', 'autozone' ),
		    'priority'   => 5,
			'panel' => 'autozone_header_panel'
		) );

		$wp_customize->add_setting( 'autozone_header_type' , array(
				'default'     => 'header1',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'autozone_header_type',
            array(
                'label'    => esc_html__( 'Type', 'autozone' ),
                'section'  => 'autozone_header_settings',
                'settings' => 'autozone_header_type',
                'type'     => 'select',
                'choices'  => array(
                   'header1'  => esc_html__( 'Classic', 'autozone' ),
                   'header2' => esc_html__( 'Shop', 'autozone' ),
                ),
                'priority'   => 10
            )
        );


		$wp_customize->add_setting( 'autozone_header_sidebar_view' , array(
				'default'     => 'fixed',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'autozone_header_sidebar_view',
            array(
                'label'    => esc_html__( 'Sidebar View', 'autozone' ),
                'section'  => 'autozone_header_settings',
                'settings' => 'autozone_header_sidebar_view',
                'type'     => 'select',
                'choices'  => array(
                    'fixed'  => esc_html__( 'Fixed', 'autozone' ),
                    'horizontal' => esc_html__( 'Horizontal Button', 'autozone' ),
		            'vertical' => esc_html__( 'Vertical Button', 'autozone' ),
                ),
                'active_callback' => 'autozone_header_type_callback',
                'priority'   => 20
            )
        );


		$wp_customize->add_setting( 'autozone_header_sticky' , array(
				'default'     => '0',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'autozone_header_sticky',
            array(
                'label'         => esc_html__( 'Behavior', 'autozone' ),
                'section'       => 'autozone_header_settings',
                'settings'      => 'autozone_header_sticky',
                'type'          => 'select',
                'choices'       => array(
                    '0' => esc_html__( 'Default', 'autozone' ),
                    'sticky'  => esc_html__( 'Fixed Header', 'autozone' ),
		            'fixed'  => esc_html__( 'Sticky Header', 'autozone' ),
                ),
                'priority'   => 30
            )
        );


		$wp_customize->add_setting( 'autozone_header_menu' , array(
				'default'     => '1',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'autozone_header_menu',
            array(
                'label'    => esc_html__( 'Menu', 'autozone' ),
                'section'  => 'autozone_header_settings',
                'settings' => 'autozone_header_menu',
                'type'     => 'select',
                'choices'  => array(
                    '1'  => esc_html__( 'On', 'autozone' ),
                    '0' => esc_html__( 'Off', 'autozone' ),
                ),
                'priority'   => 40
            )
        );


		$wp_customize->add_setting( 'autozone_header_menu_add' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$args = array(
			'taxonomy' => 'nav_menu',
			'hide_empty' => true,
		);
		$menus = get_terms( $args );
		$menus_arr = array();
		$menus_arr[''] = esc_html__( 'Select Menu', 'autozone' );
		foreach ($menus as $key => $value) {
			if(is_object($value)) {
				$menus_arr[$value->term_id] = $value->name;
			}
		}
        $wp_customize->add_control(
            'autozone_header_menu_add',
            array(
                'label'         => esc_html__( 'Additional Menu', 'autozone' ),
                'section'       => 'autozone_header_settings',
                'settings'      => 'autozone_header_menu_add',
                'type'          => 'select',
                'choices'       => $menus_arr,
                'active_callback' => 'autozone_header_type12_callback',
                'priority'   => 50
            )
        );


		$wp_customize->add_setting( 'autozone_header_menu_add_position' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'autozone_header_menu_add_position',
            array(
                'label'    => esc_html__( 'Additional Menu Position', 'autozone' ),
                'section'  => 'autozone_header_settings',
                'settings' => 'autozone_header_menu_add_position',
                'type'     => 'select',
                'choices'  => array(
                    'left'  => esc_html__( 'Left Sidebar', 'autozone' ),
                    'right' => esc_html__( 'Right Sidebar', 'autozone' ),
		            'top' => esc_html__( 'Top Sidebar', 'autozone' ),
		            'bottom'  => esc_html__( 'Bottom Sidebar', 'autozone' ),
                    'screen' => esc_html__( 'Full Screen', 'autozone' ),
		            'disable' => esc_html__( 'Disabled', 'autozone' ),
                ),
                'active_callback' => 'autozone_header_type12_callback',
                'priority'   => 60
            )
        );


        $wp_customize->add_setting( 'autozone_header_advanced_page' , array(
				'default'     => '0',
				'transport'   => 'postMessage',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'autozone_header_advanced_page',
            array(
                'label'    => esc_html__( 'Advanced Options on Page', 'autozone' ),
                'description'   => '',
                'section'  => 'autozone_header_settings',
                'settings' => 'autozone_header_advanced_page',
                'type'     => 'select',
                'choices'  => array(
                    '0' => esc_html__( 'Off', 'autozone' ),
                    '1'  => esc_html__( 'On', 'autozone' ),
                ),
                'priority'   => 70
            )
        );
		class Text_Editor_Custom_Control extends WP_Customize_Control
		{
		    public $type = 'textarea';
		    public function render_content() {
		    	echo '<span class="customize-control-title">' . esc_html( $this->label ) . '</span>';
		        $settings = array(
		            'media_buttons' => false,
		            'quicktags' => true,
		            'textarea_rows' => 5
		        );
		        $this->filter_editor_setting_link();
		        wp_editor($this->value(), $this->id, $settings );
		        do_action('admin_footer');
		        do_action('admin_print_footer_scripts');
		    }
		    private function filter_editor_setting_link() {
		        add_filter( 'the_editor', function( $output ) { 
		        	return preg_replace( '/<textarea/', '<textarea ' . $this->get_link(), $output, 1 ); 
		        } );
		    }
		}
		function editor_customizer_script() {
		    wp_enqueue_script( 'wp-editor-customizer', get_template_directory_uri() . '/library/core/admin/js/customizer.js', array( 'jquery' ), rand(), true );
		}
		add_action( 'customize_controls_enqueue_scripts', 'editor_customizer_script' );

		$wp_customize->add_setting( 'autozone_header_block1_icon' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control( 'autozone_header_block1_icon',
            array(
                'label'         => esc_html__( 'Block #1 Icon Class', 'autozone' ),
                'section'       => 'autozone_header_settings',
                'settings'      => 'autozone_header_block1_icon',
                'type'          => 'text',
                'priority'   => 12,
       
            )
        ); 
		$wp_customize->add_setting( 'autozone_header_block1_content' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'wp_kses_post'
		) );
		$wp_customize -> add_control(
		    new Text_Editor_Custom_Control(
		        $wp_customize,
		        'autozone_header_block1_content',
		        array(
		            'label'         => esc_html__( 'Block #1 Content', 'autozone' ),
	                'section'       => 'autozone_header_settings',
	                'settings'      => 'autozone_header_block1_content',
	                'priority'   => 12,
	                
		        )
		    )
		); 
        $wp_customize->add_setting( 'autozone_header_block2_icon' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control( 'autozone_header_block2_icon',
            array(
                'label'         => esc_html__( 'Block #2 Icon Class', 'autozone' ),
                'section'       => 'autozone_header_settings',
                'settings'      => 'autozone_header_block2_icon',
                'type'          => 'text',
                'priority'   => 12,
                
            )
        );
		$wp_customize->add_setting( 'autozone_header_block2_content' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'wp_kses_post'
		) );
		$wp_customize -> add_control(
		    new Text_Editor_Custom_Control(
		        $wp_customize,
		        'autozone_header_block2_content',
		        array(
		            'label'         => esc_html__( 'Block #2 Content', 'autozone' ),
	                'section'       => 'autozone_header_settings',
	                'settings'      => 'autozone_header_block2_content',
	                'priority'   => 12,
	               
		        )
		    )
		);
        $wp_customize->add_setting( 'autozone_header_block3_icon' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control( 'autozone_header_block3_icon',
            array(
                'label'         => esc_html__( 'Block #3 Icon Class', 'autozone' ),
                'section'       => 'autozone_header_settings',
                'settings'      => 'autozone_header_block3_icon',
                'type'          => 'text',
                'priority'   => 12,
                
            )
        );
		$wp_customize->add_setting( 'autozone_header_block3_content' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'wp_kses_post'
		) );
		$wp_customize -> add_control(
		    new Text_Editor_Custom_Control(
		        $wp_customize,
		        'autozone_header_block3_content',
		        array(
		            'label'         => esc_html__( 'Block #3 Content', 'autozone' ),
	                'section'       => 'autozone_header_settings',
	                'settings'      => 'autozone_header_block3_content',
	                'priority'   => 12,
	                
		        )
		    )
		);
		/// HEADER STYLE ///

		$wp_customize->add_section( 'autozone_header_settings_style' , array(
		    'title'      => esc_html__( 'Style', 'autozone' ),
		    'priority'   => 10,
			'panel' => 'autozone_header_panel'
		) );


		$wp_customize->add_setting( 'autozone_header_layout' , array(
				'default'     => 'normal',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'autozone_header_layout',
            array(
                'label'    => esc_html__( 'Layout', 'autozone' ),
                'section'  => 'autozone_header_settings_style',
                'settings' => 'autozone_header_layout',
                'type'     => 'select',
                'choices'  => array(
                    'normal'  => esc_html__( 'Normal', 'autozone' ),
                    'boxed' => esc_html__( 'Boxed', 'autozone' ),
		            'full' => esc_html__( 'Full Width', 'autozone' ),
                ),
                'priority'   => 10
            )
        );


		$wp_customize->add_setting( 'autozone_header_background' , array(
				'default'     => 'trans-black',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'autozone_header_background',
            array(
                'label'    => esc_html__( 'Background', 'autozone' ),
                'description'   => esc_html__( 'Background header color', 'autozone' ),
                'section'  => 'autozone_header_settings_style',
                'settings' => 'autozone_header_background',
                'type'     => 'select',
                'choices'  => array(
                    ''  => esc_html__( 'Default', 'autozone' ),
                    'white' => esc_html__( 'White', 'autozone' ),
		            'black' => esc_html__( 'Black', 'autozone' ),
	                'trans-white' => esc_html__( 'Transparent White', 'autozone' ),
		            'trans-black' => esc_html__( 'Transparent Black', 'autozone' ),
                ),
                'priority'   => 20
            )
        );


		$wp_customize->add_setting( 'autozone_header_transparent' , array(
				'default'     => '4',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'autozone_header_transparent',
            array(
                'label'    => esc_html__( 'Transparent', 'autozone' ),
                'section'  => 'autozone_header_settings_style',
                'settings' => 'autozone_header_transparent',
                'type'     => 'select',
                'choices'  => array(
                    '0' => "0.0",
					'1' => "0.1",
					'2' => "0.2",
					'3' => "0.3",
					'4' => "0.4",
					'5' => "0.5",
					'6' => "0.6",
					'7' => "0.7",
					'8' => "0.8",
					'9' => "0.9",
                ),
                'priority'   => 30
            )
        );


        $wp_customize->add_setting( 'autozone_header_menu_animation' , array(
				'default'     => 'overlay',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'autozone_header_menu_animation',
            array(
                'label'         => esc_html__( 'Sidebar Menu Animation', 'autozone' ),
                'description'   => esc_html__( 'Overlay or reveal Sidebar menu animation', 'autozone' ),
                'section'       => 'autozone_header_settings_style',
                'settings'      => 'autozone_header_menu_animation',
                'type'          => 'select',
                'choices'       => array(
                    'overlay' => esc_html__( 'Overlay', 'autozone' ),
                    'reveal'  => esc_html__( 'Reveal', 'autozone' ),
                ),
                'priority'   => 40
            )
        );


		$wp_customize->add_setting( 'autozone_header_hover_effect' , array(
				'default'     => '0',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'autozone_header_hover_effect',
            array(
                'label'    => esc_html__( 'Menu Hover Effect', 'autozone' ),
                'section'  => 'autozone_header_settings_style',
                'settings' => 'autozone_header_hover_effect',
                'type'     => 'select',
                'choices'  => array(
                    '0' => esc_html__( 'Without effect', 'autozone' ),
					'1' => "brackets",
					'12' => "circles",
					'18' => "crosses",
                ),
                'active_callback' => 'autozone_header_menu_callback',
                'priority'   => 50
            )
        );


		$wp_customize->add_setting( 'autozone_header_marker' , array(
				'default'     => 'menu-marker-arrow',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
			'autozone_header_marker',
			array(
				'label'    => esc_html__( 'Menu Markers', 'autozone' ),
				'section'  => 'autozone_header_settings_style',
				'settings' => 'autozone_header_marker',
				'type'     => 'select',
				'choices'  => array(
						'menu-marker-arrow'  => esc_html__( 'Arrows', 'autozone' ),
						'menu-marker-dot' => esc_html__( 'Dots', 'autozone' ),
						'no-marker' => esc_html__( 'Without markers', 'autozone' ),
				),
				'active_callback' => 'autozone_header_menu_callback',
				'priority'   => 60
			)
		);




        /// HEADER ELEMENTS ///

		$wp_customize->add_section( 'autozone_header_settings_elements' , array(
		    'title'      => esc_html__( 'Elements', 'autozone' ),
		    'priority'   => 15,
			'panel' => 'autozone_header_panel'
		) );


		$wp_customize->add_setting( 'autozone_header_bar' , array(
				'default'     => '0',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
			'autozone_header_bar',
			array(
				'label'    => esc_html__( 'Top Bar', 'autozone' ),
				'section'  => 'autozone_header_settings_elements',
				'settings' => 'autozone_header_bar',
				'type'     => 'select',
				'choices'  => array(
						'1'  => esc_html__( 'On', 'autozone' ),
						'0' => esc_html__( 'Off', 'autozone' ),
				),
				'priority'   => 10
			)
		);


		$wp_customize->add_setting( 'autozone_header_minicart' , array(
				'default'     => '1',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'autozone_header_minicart',
            array(
                'label'    => esc_html__( 'Minicart', 'autozone' ),
                'section'  => 'autozone_header_settings_elements',
                'settings' => 'autozone_header_minicart',
                'type'     => 'select',
                'choices'  => array(
                    '1'  => esc_html__( 'On', 'autozone' ),
                    '0' => esc_html__( 'Off', 'autozone' ),
                ),
                'priority'   => 20
            )
        );


		$wp_customize->add_setting( 'autozone_header_search' , array(
				'default'     => '1',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'autozone_header_search',
            array(
                'label'    => esc_html__( 'Search', 'autozone' ),
                'section'  => 'autozone_header_settings_elements',
                'settings' => 'autozone_header_search',
                'type'     => 'select',
                'choices'  => array(
                    '1'  => esc_html__( 'On', 'autozone' ),
                    '0' => esc_html__( 'Off', 'autozone' ),
                ),
                'priority'   => 30
            )
        );


		$wp_customize->add_setting( 'autozone_header_socials' , array(
				'default'     => '1',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'autozone_header_socials',
            array(
                'label'    => esc_html__( 'Socials', 'autozone' ),
                'section'  => 'autozone_header_settings_elements',
                'settings' => 'autozone_header_socials',
                'type'     => 'select',
                'choices'  => array(
                    '1'  => esc_html__( 'On', 'autozone' ),
                    '0' => esc_html__( 'Off', 'autozone' ),
                ),
                'priority'   => 40
            )
        );



	$wp_customize->add_setting( 'autozone_header_sell_button' , array(
				'default'     => '1',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'autozone_header_sell_button',
            array(
                'label'    => esc_html__( 'Sell Button', 'autozone' ),
                'section'  => 'autozone_header_settings_elements',
                'settings' => 'autozone_header_sell_button',
                'type'     => 'select',
                'choices'  => array(
                    '1'  => esc_html__( 'On', 'autozone' ),
                    '0' => esc_html__( 'Off', 'autozone' ),
                ),
                'priority'   => 50
            )
        );

		$wp_customize->add_setting( 'autozone_header_custom_button' , array(
				'default'     => '0',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'autozone_header_custom_button',
            array(
                'label'    => esc_html__( 'Custom Button', 'autozone' ),
                'section'  => 'autozone_header_settings_elements',
                'settings' => 'autozone_header_custom_button',
                'type'     => 'select',
                'choices'  => array(
                    '1'  => esc_html__( 'On', 'autozone' ),
                    '0' => esc_html__( 'Off', 'autozone' ),
                ),
                'priority'   => 60
            )
        );	

		$wp_customize->add_setting( 'autozone_header_custom_button_name' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
			'autozone_header_custom_button_name',
			array(
				'label'    => esc_html__( 'Custom Button Name', 'autozone' ),
				'section'  => 'autozone_header_settings_elements',
				'settings' => 'autozone_header_custom_button_name',
				'type'     => 'text',
				'priority'   => 70
			)
		);
		$wp_customize->add_setting( 'autozone_header_custom_button_link' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
			'autozone_header_custom_button_link',
			array(
				'label'    => esc_html__( 'Custom Button Link', 'autozone' ),
				'section'  => 'autozone_header_settings_elements',
				'settings' => 'autozone_header_custom_button_link',
				'type'     => 'text',
				'priority'   => 80
			)
		);








		/// HEADER ELEMENTS POSITION ///

		$wp_customize->add_section( 'autozone_header_settings_elements_position' , array(
		    'title'      => esc_html__( 'Elements Position', 'autozone' ),
		    'priority'   => 20,
			'panel' => 'autozone_header_panel'
		) );


		$wp_customize->add_setting( 'autozone_header_topbarbox_1_position' , array(
				'default'     => 'left',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'autozone_header_topbarbox_1_position',
            array(
                'label'    => esc_html__( 'Top Bar Email', 'autozone' ),
                'section'  => 'autozone_header_settings_elements_position',
                'settings' => 'autozone_header_topbarbox_1_position',
                'type'     => 'select',
                'choices'  => array(
                    'left'  => esc_html__( 'Left', 'autozone' ),
                    'right' => esc_html__( 'Right', 'autozone' ),
                ),
                'priority'   => 50
            )
        );

		$wp_customize->add_setting( 'autozone_header_topbarbox_2_position' , array(
				'default'     => 'right',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'autozone_header_topbarbox_2_position',
            array(
                'label'    => esc_html__( 'Top Bar Menu', 'autozone' ),
                'section'  => 'autozone_header_settings_elements_position',
                'settings' => 'autozone_header_topbarbox_2_position',
                'type'     => 'select',
                'choices'  => array(
                    'left'  => esc_html__( 'Left', 'autozone' ),
                    'right' => esc_html__( 'Right', 'autozone' ),
                ),
                'priority'   => 60
            )
        );


		$wp_customize->add_setting( 'autozone_header_navibox_1_position' , array(
				'default'     => 'left',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'autozone_header_navibox_1_position',
            array(
                'label'    => esc_html__( 'Logo', 'autozone' ),
                'section'  => 'autozone_header_settings_elements_position',
                'settings' => 'autozone_header_navibox_1_position',
                'type'     => 'select',
                'choices'  => array(
                    'left'  => esc_html__( 'Left', 'autozone' ),
                    'right' => esc_html__( 'Right', 'autozone' ),
                ),
                'priority'   => 70
            )
        );


		$wp_customize->add_setting( 'autozone_header_navibox_2_position' , array(
				'default'     => 'right',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'autozone_header_navibox_2_position',
            array(
                'label'    => esc_html__( 'Main Menu', 'autozone' ),
                'section'  => 'autozone_header_settings_elements_position',
                'settings' => 'autozone_header_navibox_2_position',
                'type'     => 'select',
                'choices'  => array(
                    'left'  => esc_html__( 'Left', 'autozone' ),
                    'right' => esc_html__( 'Right', 'autozone' ),
                ),
                'priority'   => 80
            )
        );


		$wp_customize->add_setting( 'autozone_header_navibox_3_position' , array(
				'default'     => 'right',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'autozone_header_navibox_3_position',
            array(
                'label'    => esc_html__( 'Socials And Phone', 'autozone' ),
                'section'  => 'autozone_header_settings_elements_position',
                'settings' => 'autozone_header_navibox_3_position',
                'type'     => 'select',
                'choices'  => array(
                    'left'  => esc_html__( 'Left', 'autozone' ),
                    'right' => esc_html__( 'Right', 'autozone' ),
                ),
                'priority'   => 90
            )
        );


		$wp_customize->add_setting( 'autozone_header_navibox_4_position' , array(
				'default'     => 'right',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
            'autozone_header_navibox_4_position',
            array(
                'label'    => esc_html__( 'Minicart', 'autozone' ),
                'section'  => 'autozone_header_settings_elements_position',
                'settings' => 'autozone_header_navibox_4_position',
                'type'     => 'select',
                'choices'  => array(
                    'left'  => esc_html__( 'Left', 'autozone' ),
                    'right' => esc_html__( 'Right', 'autozone' ),
                ),
                'priority'   => 100
            )
        );


		$wp_customize->add_setting( 'autozone_header_adm_bar' , array(
				'default'     => '0',
				'sanitize_callback' => 'sanitize_text_field'
		) );
        $wp_customize->add_control(
            'autozone_header_adm_bar',
            array(
                'label'    => esc_html__( 'Admin Bar Opacity', 'autozone' ),
                'description'   => '',
                'section'  => 'autozone_header_settings_elements_position',
                'settings' => 'autozone_header_adm_bar',
                'type'     => 'select',
                'choices'  => array(
                    '0'  => esc_html__( 'No', 'autozone' ),
                    '1' => esc_html__( 'Yes', 'autozone' ),
                ),
                'priority'   => 110
            )
        );





        /// HEADER INFO ///

		$wp_customize->add_section( 'autozone_header_settings_info' , array(
		    'title'      => esc_html__( 'Phone and email', 'autozone' ),
		    'priority'   => 25,
			'panel' => 'autozone_header_panel'
		) );


		$wp_customize->add_setting( 'autozone_header_phone' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
			'autozone_header_phone',
			array(
				'label'    => esc_html__( 'Phone', 'autozone' ),
				'section'  => 'autozone_header_settings_info',
				'settings' => 'autozone_header_phone',
				'type'     => 'text',
				'priority'   => 10
			)
		);


		$wp_customize->add_setting( 'autozone_header_email' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
			'autozone_header_email',
			array(
				'label'    => esc_html__( 'Email', 'autozone' ),
				'section'  => 'autozone_header_settings_info',
				'settings' => 'autozone_header_email',
				'type'     => 'text',
				'priority'   => 20
			)
		);



		/// HEADER BACKGROUND ///

		$wp_customize->add_section( 'autozone_header_settings_bg' , array(
		    'title'      => esc_html__( 'Background', 'autozone' ),
		    'priority'   => 30,
			'panel' => 'autozone_header_panel'
		) );


		$wp_customize->add_setting( 'autozone_header_bg_image' , array(
				'default'     => '',
				'transport'   => 'refresh',
				'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control(
	        new WP_Customize_Image_Control(
	            $wp_customize,
	            'autozone_header_bg_image',
				array(
				   'label'      => esc_html__( 'Background image', 'autozone' ),
				   'section'    => 'autozone_header_settings_bg',
				   'context'    => 'autozone_header_bg_image',
				   'settings'   => 'autozone_header_bg_image',
				   'priority'   => 10
				)
	       )
	    );

	    $wp_customize->add_setting( 'autozone_header_bg_color' , array(
				'default'     => '#000000',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
	        new WP_Customize_Color_Control(
	            $wp_customize,
	            'autozone_header_bg_color',
				array(
				   'label'      => esc_html__( 'Overlay Color', 'autozone' ),
				   'section'    => 'autozone_header_settings_bg',
				   'settings'   => 'autozone_header_bg_color',
				   'priority'   => 20
				)
	       )
	    );

		$wp_customize->add_setting( 'autozone_header_bg_opacity' , array(
				'default'     => '8',
				'transport'   => 'refresh',
				'sanitize_callback' => 'esc_attr'
		) );
		$wp_customize->add_control(
            'autozone_header_bg_opacity',
            array(
                'label'    => esc_html__( 'Overlay Opacity', 'autozone' ),
                'section'  => 'autozone_header_settings_bg',
                'settings' => 'autozone_header_bg_opacity',
                'type'     => 'select',
                'choices'  => array(
                    '0' => "0.0",
					'1' => "0.1",
					'2' => "0.2",
					'3' => "0.3",
					'4' => "0.4",
					'5' => "0.5",
					'6' => "0.6",
					'7' => "0.7",
					'8' => "0.8",
					'9' => "0.9",
                ),
                'priority'   => 30
            )
        );




		//SHOP CATEGORY BACKGROUND

        $wp_customize->add_setting( 'autozone_header_shop_cat_bg_image' , array(
            'default'     => '',
            'transport'   => 'refresh',
            'sanitize_callback' => 'sanitize_text_field'
        ) );
        $wp_customize->add_control(
            new WP_Customize_Image_Control(
                $wp_customize,
                'autozone_header_shop_cat_bg_image',
                array(
                    'label'      => esc_html__( 'Shop Background image', 'autozone' ),
                    'section'    => 'autozone_header_settings_bg',
                    'context'    => 'autozone_header_shop_cat_bg_image',
                    'settings'   => 'autozone_header_shop_cat_bg_image',
                    'priority'   => 10
                )
            )
        );




	}
		
?>