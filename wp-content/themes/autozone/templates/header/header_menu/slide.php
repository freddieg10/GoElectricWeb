<?php
	$post_ID = isset ($wp_query) ? $wp_query->get_queried_object_id() : (isset($post->ID) && $post->ID>0 ? $post->ID : '');
	if( class_exists( 'WooCommerce' ) && autozone_is_woo_page() && autozone_get_option('autozone_woo_header_global','1') ){
		$post_ID = get_option( 'woocommerce_shop_page_id' ) ? get_option( 'woocommerce_shop_page_id' ) : $post_ID;
	}

	$autozone_header = apply_filters('autozone_header_settings', $post_ID);
	$autozone_header_menu_add_style = isset($post_ID) && $post_ID>0 && get_post_meta($post_ID, 'header_menu_animation', 1) != '' ? get_post_meta($post_ID, 'header_menu_animation', 1) : autozone_get_option('header_menu_animation','overlay');
	$slide_class_arr = array('left' => 'slidebar-1 left', 'right' => 'slidebar-2 right', 'top' => 'slidebar-3 top', 'bottom' => 'slidebar-4 bottom');
	$autozone_header_menu_add_style = in_array($autozone_header['header_menu_add_position'], array('top', 'bottom')) ? 'push' : $autozone_header_menu_add_style;
?>
<!-- ========================== -->
<!-- SLIDE MENU  --> 
<!-- ========================== -->

<div data-off-canvas="<?php echo esc_attr($slide_class_arr[$autozone_header['header_menu_add_position']]) ?> <?php echo esc_attr($autozone_header_menu_add_style) ?>" class="slidebar-menu">
	<?php
		if(autozone_get_option('header_menu_add','')) {
			wp_nav_menu(array(
				'menu'          => autozone_get_option('header_menu_add',''),
				'menu_class'    => 'nav navbar-nav',
			));
		} else {
			esc_html_e('Additional menu has not been selected. Do this in the Theme Options &rarr; Header &rarr; Additional Menu.', 'autozone');
		}
	?>
</div>