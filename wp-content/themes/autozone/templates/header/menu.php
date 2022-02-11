<?php 
	if ( function_exists('wp_nav_menu')) {
	
		$class = 'nav navbar-nav';
	
		wp_nav_menu(array(
			'theme_location'  => 'primary_nav',
			'container'       => false,
			'menu_id'		  => 'main-menu',
			'menu_class'      => $class,
			'walker'          => new Autozone_Walker_Menu(),
		));
	}
	
?>
