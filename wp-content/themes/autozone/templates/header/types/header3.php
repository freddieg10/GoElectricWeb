<?php /* Header Type 3 */
	$post_ID = isset ($wp_query) ? $wp_query->get_queried_object_id() : (isset($post->ID) && $post->ID>0 ? $post->ID : '');
	if( class_exists( 'WooCommerce' ) && autozone_is_woo_page() && autozone_get_option('woo_header_global','1') ){
		$post_ID = get_option( 'woocommerce_shop_page_id' ) ? get_option( 'woocommerce_shop_page_id' ) : $post_ID;
	}

	$autozone_header = apply_filters('autozone_header_settings', $post_ID);
	$bg_color = $autozone_header['header_background'] == 'white' ? 'white' : 'black';
	$menu_canvas = array(
			'fixed' => 'menu-sidebar-fixed left overlay open',
			'horizontal' => 'slidebar-panel-left left '.$autozone_header['header_menu_animation'],
			'vertical' => 'slidebar-panel-left left '.$autozone_header['header_menu_animation'],
	);
	$menu_class = array(
			'fixed' => '',
			'horizontal' => '',
			'vertical' => 'slidebar-nav-middle',
	);
?>

<?php if ($autozone_header['header_sidebar_view'] != 'fixed') : ?>
<div class="slidebar-panel <?php echo esc_attr($menu_class[$autozone_header['header_sidebar_view']]) ?>">
<?php endif; ?>

<div data-off-canvas="<?php echo esc_attr($menu_canvas[$autozone_header['header_sidebar_view']]) ?>" class="

    <?php if ($autozone_header['header_sidebar_view'] == 'fixed') : ?>
        menu-sidebar-fixed
    <?php endif; ?>

	header-background-<?php echo esc_attr( $bg_color ) ?>

	<?php if ( $bg_color == 'white' ) : ?>
        header-color-black
        header-logo-black
	<?php else : ?>
        header-color-white
        header-logo-white
	<?php endif; ?>

	<?php echo esc_attr($autozone_header['header_uniq_class']) ?>
	">

	<div class="side-logo">
		<a class="navbar-brand" href="<?php echo esc_url(home_url('/')) ?>">
		<?php if ( $bg_color == 'black' ) : ?>
			<?php if ($autozone_header['logo']): ?>
				<img class="normal-logo"
				     src="<?php echo esc_url($autozone_header['logo']) ?>"
				     alt="logo"/>
			<?php else: ?>
				<img class="normal-logo"
				     src="<?php echo get_template_directory_uri(); ?>/images/logo-w.png" alt="logo"/>
			<?php endif ?>
		<?php else : ?>
			<?php if ($autozone_header['logo_inverse']): ?>
				<img class="scroll-logo"
				     src="<?php echo esc_url($autozone_header['logo_inverse']) ?>"
				     alt="logo"/>
			<?php else: ?>
				<img class="scroll-logo"
				     src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="logo"/>
			<?php endif ?>
		<?php endif; ?>
		</a>
	</div>


	<?php if (class_exists('WooCommerce') && $autozone_header['header_minicart']) : ?>
		<div class="side-cart">
			<div class="header-cart">
				<a href="<?php echo WC()->cart->get_cart_url(); ?>"><i class="fa fa-cart-plus"
				                                                       aria-hidden="true"></i></a>
				<span class="header-cart-count"><?php echo WC()->cart->cart_contents_count; ?></span>
			</div>
			<span class="title"><?php esc_html_e( 'Your Cart:', 'autozone' )?> <span class="amount"><?php echo WC()->cart->get_cart_total(); ?></span></span>
		</div>
	<?php endif; ?>


	<?php if ( $autozone_header['header_search'] ) : ?>
	<div class="side-search">
		<div class="side-form-search">
			<form action="<?php echo esc_url(site_url()) ?>" method="get">
				<input type="search" class="search-field" placeholder="<?php !autozone_get_option('search_placeholder','') ? esc_html_e('Search...', 'autozone') : esc_attr(autozone_get_option('search_placeholder','')) ?>" name="s" id="search" value="<?php esc_attr(the_search_query()); ?>">
				<button class="button"><i class="fa fa-search"></i></button>
			</form>
		</div>
	</div>
    <?php endif; ?>

	<?php echo autozone_site_menu('nav navbar-nav'); ?>

</div>

<?php if ($autozone_header['header_sidebar_view'] != 'fixed') : ?>
	<div class="slidebar-nav-panel  ">
		<button class="js-open-slidebar-panel-left   toggle-menu-button ">
			<span class="toggle-menu-button-icon"> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> </span>
		</button>
	</div>
<?php endif; ?>

<?php if ($autozone_header['header_sidebar_view'] != 'fixed') : ?>
</div>
<?php endif; ?>