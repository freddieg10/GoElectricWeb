<?php

/**
 * Iconc loader for VC
 * version 1.15.11
 */

function autozone_init_vc_icons(){
    $pix_libs = $pix_fonts = $pix_fonts_str = $params = $params1 = $params2 = array();

    if(function_exists('fil_init')) {

        if( array_key_exists( 'vc_iconpicker-type-pixflaticon' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'Flaticon', 'autozone' )] = 'pixflaticon';
        }
        if( array_key_exists( 'vc_iconpicker-type-pixfontawesome' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'Font Awesome', 'autozone' )] = 'pixfontawesome';
        }
        if( array_key_exists( 'vc_iconpicker-type-pixelegant' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'Elegant', 'autozone' )] = 'pixelegant';
        }
        if( array_key_exists( 'vc_iconpicker-type-pixicomoon' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'Icomoon', 'autozone' )] = 'pixicomoon';
        }
        if( array_key_exists( 'vc_iconpicker-type-pixsimple' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'Simple', 'autozone' )] = 'pixsimple';
        }
        if( array_key_exists( 'vc_iconpicker-type-pixcustom1' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'Custom 1', 'autozone' )] = 'pixcustom1';
        }
        if( array_key_exists( 'vc_iconpicker-type-pixcustom2' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'Custom 2', 'autozone' )] = 'pixcustom2';
        }
        if( array_key_exists( 'vc_iconpicker-type-pixcustom3' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'Custom 3', 'autozone' )] = 'pixcustom3';
        }
        if( array_key_exists( 'vc_iconpicker-type-pixcustom4' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'Custom 4', 'autozone' )] = 'pixcustom4';
        }
        if( array_key_exists( 'vc_iconpicker-type-pixcustom5' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'Custom 5', 'autozone' )] = 'pixcustom5';
        }
        if (array_key_exists('vc_iconpicker-type-fontawesome', $GLOBALS['wp_filter'])) {
            $pix_libs[esc_html__('VC Font Awesome', 'autozone')] = 'fontawesome';
        }
        if( get_option('fil_use_vc_icons') ) {

            if (array_key_exists('vc_iconpicker-type-openiconic', $GLOBALS['wp_filter'])) {
                $pix_libs[esc_html__('VC Open Iconic', 'autozone')] = 'openiconic';
            }
            if (array_key_exists('vc_iconpicker-type-typicons', $GLOBALS['wp_filter'])) {
                $pix_libs[esc_html__('VC Typicons', 'autozone')] = 'typicons';
            }
            if (array_key_exists('vc_iconpicker-type-entypo', $GLOBALS['wp_filter'])) {
                $pix_libs[esc_html__('VC Entypo', 'autozone')] = 'entypo';
            }
            if (array_key_exists('vc_iconpicker-type-linecons', $GLOBALS['wp_filter'])) {
                $pix_libs[esc_html__('VC Linecons', 'autozone')] = 'linecons';
            }
        }

        $add_icon_libs = array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Icon library', 'autozone' ),
            'param_name' => 'type',
            'value' => $pix_libs,
            'admin_label' => true,
            'description' => esc_html__( 'Select icon library.', 'autozone' ),
        );

        if (is_array($pix_libs)) {
            $pix_fonts_str[] = $add_icon_libs;

            foreach ($pix_libs as $val) {
                if ($val != ''){
                    $pix_fonts[$val] = array(
                        'type' => 'iconpicker',
                        'heading' => esc_html__('Icon', 'autozone'),
                        'param_name' => 'icon_' . $val,
                        'value' => '',
                        'settings' => array(
                            'emptyIcon' => true,
                            'type' => $val,
                            'iconsPerPage' => 4000,
                        ),
                        'dependency' => array(
                            'element' => 'type',
                            'value' => $val,
                        ),
                        'description' => esc_html__('Select icon from library.', 'autozone'),
                    );
                }

                $pix_fonts_str[] = $pix_fonts[$val];
            }
        }
    }
    return $pix_fonts_str;
}



function autozone_get_vc_icons($pix_fonts_str){
    $result = array();
    if (!empty($pix_fonts_str) && function_exists('fil_init'))
        $result = apply_filters('autozone_vc_icons_loader_show',$pix_fonts_str);
    return array_values($result);

}






?>