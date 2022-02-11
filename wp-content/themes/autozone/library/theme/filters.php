<?php
/**
 * The template for registering metabox.
 *
 * @package PixTheme
 * @since 1.0
 */

add_filter( 'autozone_header_settings', 'autozone_header_settings_var' );
function autozone_header_settings_var( $post_ID=0 ){

	$autozone['page_layout'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'page_layout', 1) != '' ? get_post_meta($post_ID, 'page_layout', 1) : autozone_get_option('page_layout','wide');

	/// Header global parameters
	$autozone['header_type'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_type', 1) != '' ? get_post_meta($post_ID, 'header_type', 1) : autozone_get_option('header_type','header1');
	$autozone['header_sidebar_view'] = $autozone['header_type'] == 'header3' ? (get_post_meta($post_ID, 'header_sidebar_view', 1) != '' ? get_post_meta($post_ID, 'header_sidebar_view', 1) : autozone_get_option('header_sidebar_view','fixed')) : '';
	$autozone['header_background'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_background', 1) != '' ? get_post_meta($post_ID, 'header_background', 1) : (autozone_get_option('header_background','trans-black'));
	$autozone['header_transparent'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_transparent', 1) != '' ? get_post_meta($post_ID, 'header_transparent', 1) : autozone_get_option('header_transparent','0');
	$autozone['header_hover_effect'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_hover_effect', 1) != '' ? get_post_meta($post_ID, 'header_hover_effect', 1) : autozone_get_option('header_hover_effect','0');
	$autozone['header_marker'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_marker', 1) != '' ? get_post_meta($post_ID, 'header_marker', 1) : autozone_get_option('header_marker','menu-marker-arrow');
	$autozone['header_layout'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_layout', 1) != '' ? get_post_meta($post_ID, 'header_layout', 1) : autozone_get_option('header_layout','normal');
	$autozone['header_bar'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_bar', 1) != '' ? get_post_meta($post_ID, 'header_bar', 1) : autozone_get_option('header_bar','0');
	$autozone['header_sticky'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_sticky', 1) != '' ? get_post_meta($post_ID, 'header_sticky', 1) : autozone_get_option('header_sticky','sticky');
	$autozone['mobile_sticky'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'mobile_sticky', 1) != '' ? get_post_meta($post_ID, 'mobile_sticky', 1) : autozone_get_option('mobile_sticky','');

	/// Header menu settings
	$autozone['header_menu'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_menu', 1) != '' ? get_post_meta($post_ID, 'header_menu', 1) : autozone_get_option('header_menu','1');
	$autozone['header_menu_add'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_menu_add', 1) != '' ? get_post_meta($post_ID, 'header_menu_add', 1) : autozone_get_option('header_menu_add','');
	$autozone['header_menu_add_position'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_menu_add_position', 1) != '' ? get_post_meta($post_ID, 'header_menu_add_position', 1) : autozone_get_option('header_menu_add_position','disable');
	$autozone['header_menu_animation'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_menu_animation', 1) != '' ? get_post_meta($post_ID, 'header_menu_animation', 1) : autozone_get_option('header_menu_animation','overlay');

	/// Header widgets
	$autozone['header_minicart'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_minicart', 1) != '' ? get_post_meta($post_ID, 'header_minicart', 1) : autozone_get_option('header_minicart','1');
	$autozone['header_search'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_search', 1) != '' ? get_post_meta($post_ID, 'header_search', 1) : autozone_get_option('header_search','1');
	$autozone['header_socials'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_socials', 1) != '' ? get_post_meta($post_ID, 'header_socials', 1) : autozone_get_option('header_socials','1');

  $autozone['header_sell_button'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_sell_button', 1) != '' ? get_post_meta($post_ID, 'header_sell_button', 1) : autozone_get_option('header_sell_button','1');

	$autozone['header_custom_button'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_custom_button', 1) != '' ? get_post_meta($post_ID, 'header_custom_button', 1) : autozone_get_option('header_custom_button','1');

	$autozone['header_custom_button_name'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_custom_button_name', 1) != '' ? get_post_meta($post_ID, 'header_custom_button_name', 1) : autozone_get_option('header_custom_button_name', '');
	$autozone['header_custom_button_link'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_custom_button_link', 1) != '' ? get_post_meta($post_ID, 'header_custom_button_link', 1) : autozone_get_option('header_custom_button_link', '');

	$class = '';
//	print_r($autozone);
	foreach($autozone as $key => $val){
		if(!in_array($key, array('header_transparent', 'header_sticky', 'mobile_sticky', 'header_menu_animation')))
		$class .= $val.'-';
	}
	$autozone['header_uniq_class'] = substr($class, 0, -1);

	$autozone['header_phone'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_phone', 1) != '' ? get_post_meta($post_ID, 'header_phone', 1) : autozone_get_option('header_phone', '');
	$autozone['header_email'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_email', 1) != '' ? get_post_meta($post_ID, 'header_email', 1) : autozone_get_option('header_email', '');

	/// Header elements position
	$autozone['header_topbarbox_1_position'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_topbarbox_1_position', 1) != '' ? get_post_meta($post_ID, 'header_topbarbox_1_position', 1) : autozone_get_option('header_topbarbox_1_position','left',0);
	$autozone['header_topbarbox_2_position'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_topbarbox_2_position', 1) != '' ? get_post_meta($post_ID, 'header_topbarbox_2_position', 1) : autozone_get_option('header_topbarbox_2_position','right',0);
	$autozone['header_navibox_1_position'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_navibox_1_position', 1) != '' ? get_post_meta($post_ID, 'header_navibox_1_position', 1) : autozone_get_option('header_navibox_1_position','left');
	$autozone['header_navibox_2_position'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_navibox_2_position', 1) != '' ? get_post_meta($post_ID, 'header_navibox_2_position', 1) : autozone_get_option('header_navibox_2_position','right');
	$autozone['header_navibox_3_position'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_navibox_3_position', 1) != '' ? get_post_meta($post_ID, 'header_navibox_3_position', 1) : autozone_get_option('header_navibox_3_position','right');
	$autozone['header_navibox_4_position'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_navibox_4_position', 1) != '' ? get_post_meta($post_ID, 'header_navibox_4_position', 1) : autozone_get_option('header_navibox_4_position','right');

	/// Responsive
	$autozone['mobile_sticky'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'mobile_sticky', 1) != '' ? get_post_meta($post_ID, 'mobile_sticky', 1) : autozone_get_option('mobile_sticky','');
	$autozone['mobile_topbar'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'mobile_topbar', 1) != '' ? get_post_meta($post_ID, 'mobile_topbar', 1) : autozone_get_option('mobile_topbar','');
	$autozone['tablet_minicart'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'tablet_minicart', 1) != '' ? get_post_meta($post_ID, 'tablet_minicart', 1) : autozone_get_option('tablet_minicart','');
	$autozone['tablet_search'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'tablet_search', 1) != '' ? get_post_meta($post_ID, 'tablet_search', 1) : autozone_get_option('tablet_search','');
	$autozone['tablet_phone'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'tablet_phone', 1) != '' ? get_post_meta($post_ID, 'tablet_phone', 1) : autozone_get_option('tablet_phone','');
	$autozone['tablet_socials'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'tablet_socials', 1) != '' ? get_post_meta($post_ID, 'tablet_socials', 1) : autozone_get_option('tablet_socials','');


	/// Logo
	$autozone['logo'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_logo', 1) != '' ? get_post_meta($post_ID, 'header_logo', 1) : autozone_get_option('general_settings_logo','');
	$autozone['logo_inverse'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_logo_inverse', 1) != '' ? get_post_meta($post_ID, 'header_logo_inverse', 1) : autozone_get_option('general_settings_logo_inverse','');

	// Header Blocks
	$autozone['header_block1_icon'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_block1_icon', 1) != '' ? get_post_meta($post_ID, 'header_block1_icon', 1) : autozone_get_option('header_block1_icon','');
	$autozone['header_block2_icon'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_block2_icon', 1) != '' ? get_post_meta($post_ID, 'header_block2_icon', 1) : autozone_get_option('header_block2_icon','');
	$autozone['header_block3_icon'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_block3_icon', 1) != '' ? get_post_meta($post_ID, 'header_block3_icon', 1) : autozone_get_option('header_block3_icon','');
	$autozone['header_block1_content'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_block1_content', 1) != '' ? get_post_meta($post_ID, 'header_block1_content', 1) : autozone_get_option('header_block1_content','');
	$autozone['header_block2_content'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_block2_content', 1) != '' ? get_post_meta($post_ID, 'header_block2_content', 1) : autozone_get_option('header_block2_content','');
	$autozone['header_block3_content'] = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_block3_content', 1) != '' ? get_post_meta($post_ID, 'header_block3_content', 1) : autozone_get_option('header_block3_content','');



	return $autozone;
}


function autozone_footer_script( $script ){
	$out = '';
	if( autozone_get_option('header_adm_bar', '0') ){
		$out .= "
		<script>
			jQuery(document).ready(function($){
				$('html').addClass('html-margin-top');
                $('#wpadminbar').addClass('wpadmin-opacity');
            });
         </script>";
	}
	if ( !empty($script) ) {
		$out .= $script;
	}
	return $out;
}
add_filter( 'autozone_script_footer', 'autozone_footer_script' );



add_filter('rwmb_meta_boxes', 'autozone_register_meta_boxes');
function autozone_register_meta_boxes( $meta_boxes ) {
	
    $meta_boxes[] = array(
        'id' => 'post_format',
        'title' => esc_html__( 'Post Format Options', 'autozone' ),
        'post_types' => array( 'post' ),
        'context' => 'normal',
        'priority' => 'low',
        'fields' => array(
            array(
                'name' => esc_html__('Post Standared:', 'autozone' ),
                'id'   => 'post_standared',
                'type' => 'file_advanced',
                'max_file_uploads' => 4,
                'mime_type' => 'application,audio,video,image',
            ),
            array(
                'name' => esc_html__('Post Gallery:','autozone'),
                'id'   => 'post_gallery',
                'type' => 'plupload_image',
                'max_file_uploads' => 25,
            ),
            array(
                'name'  => esc_html__('Quote Source:', 'autozone'),
                'id'    => 'post_quote_source',
                'desc'  => '',
                'type'  => 'text',
                'std'   => '',
            ),
            array(
                'name'  => esc_html__('Quote Content:', 'autozone'),
                'id'    => 'post_quote_content',
                'desc'  => '',
                'type'  => 'textarea',
                'std'   => '',
            ),
            array(
                'name'  => esc_html__('Video','autozone'),
                'id'    => 'post_video',
                'desc'  => 'Video URL',
                'type'  => 'textarea',
                'std'   => '',
            )
        )

    );

    return $meta_boxes;
}