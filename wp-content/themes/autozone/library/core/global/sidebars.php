<?php 


function autozone_init_sidebars(){
	if ( function_exists('register_sidebar') ){
	
		register_sidebar(array(
			'name' => 'WP Default Sidebar',
			'id'	=> 'sidebar-1',
			'before_widget' => '<div id="%1$s" class="%2$s widget block_content">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title"><span>',
			'after_title' => '</span></h4>',
		));
	
		register_sidebar(array(
			'name' => 'Blog Sidebar',
			'id' => 'global-sidebar-1',
			'before_widget' => '<div id="%1$s" class="%2$s widget block_content">',
			'before_title' => '<h4 class="widget-title"><span>',
			'after_title' => '</span></h4>',
			'after_widget' => '</div>',
		));

		register_sidebar(array(
			'name' => 'Auto sidebar',
			'id'	=> 'auto-sidebar-1',
			'before_widget' => '<div id="%1$s" class="%2$s widget block_content widget_mod-a">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title"><span>',
			'after_title' => '</span></h4><div class="decor-1"></div>',
		));

		register_sidebar(array(
			'name' => 'Shop sidebar',
			'id'	=> 'shop-sidebar-1',
			'before_widget' => '<div id="%1$s" class="%2$s widget block_content">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title"><span>',
			'after_title' => '</span></h4>',
		));

		register_sidebar(array(
			'name' => 'Product sidebar',
			'id'	=> 'product-sidebar-1',
			'before_widget' => '<div id="%1$s" class="%2$s widget block_content">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title"><span>',
			'after_title' => '</span></h4>',
		));

		register_sidebar(array(
			'name' => 'Custom Area',
			'id'	=> 'custom-area-1',
			'before_widget' => '<div id="%1$s" class="%2$s widget block_content">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="widget-title"><span>',
			'after_title' => '</span></h4>',
		));
		
		
		
	}
}


add_action('widgets_init','autozone_init_sidebars');