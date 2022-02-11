<!-- ========================== --> 
<!-- FULL SCREEN MENU  --> 
<!-- ========================== -->

<div class="wrap-fixed-menu" id="fixedMenu">
	<nav class="fullscreen-center-menu">

		<?php
			if(autozone_get_option('header_menu_add','')) {
				wp_nav_menu(array(
					'menu'          => autozone_get_option('header_menu_add',''),
					'menu_class'    => 'nav navbar-nav',
				));
			} else {
				esc_html_e('Additional menu has not been selected. Do this in the Customize &rarr; Header &rarr; Additional Menu.', 'autozone');
			}
		?>
    </nav>
	<button type="button" class="fullmenu-close"><i class="fa fa-times"></i></button>
</div>
