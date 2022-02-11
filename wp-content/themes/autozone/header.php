<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">

<meta name="viewport" content="width=device-width">


<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> data-scrolling-animations="false" data-header="fixed-header">
<?php wp_body_open(); ?>
<?php
    
    
   if ( ! class_exists( 'PixthemeCustom' ) ){
		$additional_custom_class = 'tmpl-plugins-not-activated';
	}else{
		$additional_custom_class = 'tmpl-plugins-activated';
	}


	$post_ID = isset ($wp_query) ? $wp_query->get_queried_object_id() : (isset($post->ID) && $post->ID>0 ? $post->ID : '');
	if( class_exists( 'WooCommerce' ) && autozone_is_woo_page() && autozone_get_option('autozone_woo_header_global','1') ){
		$post_ID = get_option( 'woocommerce_shop_page_id' ) ? get_option( 'woocommerce_shop_page_id' ) : $post_ID;
	}

	$autozone_header = apply_filters('autozone_header_settings', $post_ID);
?>


<?php if( (autozone_get_option('loader_settings_loader','useall') == 'usemain' && is_front_page() ) || autozone_get_option('loader_settings_loader','') == 'useall' ) : ?>
<!-- Loader -->

<?php if (autozone_get_option('loader_settings_img','')) { ?>
	<div id="loader" style="background-image: url(<?php echo esc_url(autozone_get_option('loader_settings_img','')) ?> "></div>
<?php } else { ?>
	<div id="page-preloader">
        
        <div class="thecube">
    		<div class="cube c1"></div>
    		<div class="cube c2"></div>
    		<div class="cube c4"></div>
    		<div class="cube c3"></div>
    	</div>
    
    </div>
    
<?php } ?>






<!-- Loader end -->
<?php endif; ?>



<?php
	include(get_template_directory() . '/templates/header/header_menu/search.php');

	if ( in_array($autozone_header['header_menu_add_position'], array('left', 'right', 'top', 'bottom'))  && $autozone_header['header_type'] != 'header3' ) {
		include(get_template_directory() . '/templates/header/header_menu/slide.php');
	}
	?>
	<div data-off-canvas="slidebar-5 left overlay" class="mobile-slidebar-menu">
		<button class="menu-mobile-button visible-xs-block js-toggle-mobile-slidebar toggle-menu-button">
			<span class="toggle-menu-button-icon"><span></span> <span></span> <span></span> <span></span>
				<span></span> <span></span></span>
		</button>
		<?php
			if ( has_nav_menu( 'mobile_nav' ) ) {
				wp_nav_menu(array(
					'theme_location'  => 'mobile_nav',
	                'container'       => false,
	                'menu_id'		  => 'mobile-menu',
	                'menu_class'      => 'nav navbar-nav'
				));
			} else {
				echo autozone_site_menu('yamm main-menu nav navbar-nav');
			}
		?>
        
            <?php do_action( 'autozone_header_start', $autozone_header); ?>
        
        
	</div>
	<?php
	if ( $autozone_header['header_menu_add_position'] == 'screen' && $autozone_header['header_type'] != 'header3' ) {
		include(get_template_directory() . '/templates/header/header_menu/full-screen.php');
	}
?>

<?php if($autozone_header['header_sidebar_view'] == 'fixed') : ?>
	<!-- FIXED SIDEBAR MENU  -->
	<div class="wrap-left-open ">
<?php endif; ?>
        


<?php
	if($autozone_header['header_type'] == 'header3')
		autozone_get_theme_header();
?>

<?php if($autozone_header['header_menu_animation'] == 'reveal') : ?>
	<!-- ========================== -->
	<!-- CONTAINER SLIDE MENU  -->
	<!-- ========================== -->
	<div data-canvas="container">
<?php endif; ?>
        
   

<div class="layout-theme animated-css <?php echo esc_attr($additional_custom_class)?> "  data-header="<?php echo esc_attr($autozone_header['header_sticky'] != 'sticky' ? 'nosticky' : 'sticky');?>" data-header-top="2"  >

<?php
	if($autozone_header['header_type'] != 'header3')
		autozone_get_theme_header();

	if (!is_page_template('page-home.php')) {
		autozone_load_block('header/title');
	}
?>

<div id="wrapper">



