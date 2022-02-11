<?php


	require_once(get_template_directory() . '/library/core/admin/admin-panel/class.customizer.fonts.php');
	require_once(get_template_directory() . '/library/core/admin/admin-panel/general.php');
	require_once(get_template_directory() . '/library/core/admin/admin-panel/loader.php');
	require_once(get_template_directory() . '/library/core/admin/admin-panel/style.php' );
	require_once(get_template_directory() . '/library/core/admin/admin-panel/header.php');
	require_once(get_template_directory() . '/library/core/admin/admin-panel/responsive.php');
	require_once(get_template_directory() . '/library/core/admin/admin-panel/search.php');
	require_once(get_template_directory() . '/library/core/admin/admin-panel/footer.php');
	require_once(get_template_directory() . '/library/core/admin/admin-panel/shop.php');
	require_once(get_template_directory() . '/library/core/admin/admin-panel/blog.php');
	require_once(get_template_directory() . '/library/core/admin/admin-panel/social.php');


	
	function autozone_customize_register( $wp_customize ) {

		// $wp_customize->remove_section('header_image');
		$wp_customize->remove_section('background_image');
		$wp_customize->remove_section('colors');


		/** GENERAL SETTINGS **/
		autozone_customize_general_tab($wp_customize,'autozone');

		/** LOADER SETTINGS **/
		autozone_customize_loader_tab($wp_customize,'autozone');

		/** STYLE SECTION **/

		autozone_customize_style_tab($wp_customize, 'autozone');


		/** HEADER SECTION **/

		autozone_customize_header_tab($wp_customize,'autozone');
		
		
		/** RESPONSIVE SECTION **/

		autozone_customize_responsive_tab($wp_customize,'autozone');


		/** SEARCH SECTION **/

		autozone_customize_search_tab($wp_customize,'autozone');
		

		/** FOOTER SECTION **/

		autozone_customize_footer_tab($wp_customize,'autozone');


		/** SHOP SECTION **/

		autozone_customize_shop_tab($wp_customize,'autozone');


		/** BLOG SECTION **/

		autozone_customize_blog_tab($wp_customize,'autozone');

		/** SOCIAL SECTION **/

		autozone_customize_social_tab($wp_customize,'autozone');


		/** Remove unused sections */

		$removedSections = apply_filters('autozone_admin_customize_removed_sections', array('background_image'));
		foreach ($removedSections as $_sectionName){
			$wp_customize->remove_section($_sectionName);
		}

    }
    
    
	add_action( 'customize_register', 'autozone_customize_register' );
?>