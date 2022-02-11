<?php /* Header Type 1 */
	$post_ID = isset ($wp_query) ? $wp_query->get_queried_object_id() : (isset($post->ID) && $post->ID>0 ? $post->ID : '');
	if( class_exists( 'WooCommerce' ) && autozone_is_woo_page() && autozone_get_option('woo_header_global','1') ){
		$post_ID = get_option( 'woocommerce_shop_page_id' ) ? get_option( 'woocommerce_shop_page_id' ) : $post_ID;
	}

	$autozone_header = apply_filters('autozone_header_settings', $post_ID);


	$autozone_header['header_background'] = $autozone_header['header_background'] == '' ? 'white' : $autozone_header['header_background'];
	$hover_effect = $autozone_header['header_hover_effect'] > 0 ? 'cl-effect-'.$autozone_header['header_hover_effect'] : '';

	$autozone_logo_stl = autozone_get_option('general_settings_logo_width') != '' ? 'max-width:'.esc_attr(autozone_get_option('general_settings_logo_width')).'px;' : '';
    $autozone_logo_stl .= autozone_get_option('general_settings_logo_vertical_pos') != '' ? 'top:'.esc_attr(autozone_get_option('general_settings_logo_vertical_pos')).'px;' : '';
    $autozone_logo_stl .= autozone_get_option('general_settings_logo_horizontal_pos') != '' ? 'left:'.esc_attr(autozone_get_option('general_settings_logo_horizontal_pos')).'px;' : '';
    $autozone_logo_stl = $autozone_logo_stl != '' ? 'style="'.($autozone_logo_stl).'"' : '';

		$autozone_opts = array();
	if (class_exists('PIXAD_Settings')){
		$Settings = new PIXAD_Settings();
		$autozone_opts = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );	
	}

?>


	<header class="header

    <?php if ($autozone_header['header_bar']) : ?>
	    header-topbar-view
	    header-topbarbox-1-<?php echo esc_attr($autozone_header['header_topbarbox_1_position']) ?>
        header-topbarbox-2-<?php echo esc_attr($autozone_header['header_topbarbox_2_position']) ?>
    <?php endif; ?>

        header-<?php echo esc_attr($autozone_header['header_layout']) ?>-width

    <?php if (in_array($autozone_header['header_sticky'], array('sticky', 'fixed'))) : ?>
        navbar-fixed-top
    <?php endif; ?>

		header-background-<?php echo esc_attr( $autozone_header['header_background'] ) ?><?php echo esc_attr( in_array($autozone_header['header_background'], array('trans-white', 'trans-black')) ? '-rgba0' . $autozone_header['header_transparent'] : '' ) ?>

	<?php if ( in_array($autozone_header['header_background'], array('trans-white', 'white')) ) : ?>
        header-color-black
        header-logo-black
	<?php else : ?>
        header-color-white
        header-logo-white
	<?php endif; ?>

        header-navibox-1-<?php echo esc_attr($autozone_header['header_navibox_1_position']) ?>
        header-navibox-2-<?php echo esc_attr($autozone_header['header_navibox_2_position']) ?>
        header-navibox-3-<?php echo esc_attr($autozone_header['header_navibox_3_position']) ?>
        header-navibox-4-<?php echo esc_attr($autozone_header['header_navibox_4_position']) ?>

	<?php echo esc_attr($autozone_header['mobile_sticky']) ?>
	<?php echo esc_attr($autozone_header['mobile_topbar']) ?>
	<?php echo esc_attr($autozone_header['tablet_minicart']) ?>
	<?php echo esc_attr($autozone_header['tablet_search']) ?>
	<?php echo esc_attr($autozone_header['tablet_phone']) ?>
	<?php echo esc_attr($autozone_header['tablet_socials']) ?> 

	<?php echo esc_attr($autozone_header['header_uniq_class']) ?>

       ">
		<div class="container container-boxed-width">
		<?php if ($autozone_header['header_bar']) : ?>
			<div class="top-bar">

				<div class="container">
					<div class="header-topbarbox-1">
						<ul>
                            <li>   <?php  if ( function_exists ( 'wpm_language_switcher' ) ) wpm_language_switcher (); ?></li>
							<?php if ($autozone_header['header_phone']) : ?>
								<li class="no-hover header-phone"><i class="icon fa fa-phone"></i> <?php echo wp_kses_post(autozone_get_option('header_phone', '')) ?> </li>
							<?php endif; ?>
							<?php if ($autozone_header['header_email']) : ?>
								<li class="no-hover header-email"><i class="icon fa fa-envelope"></i> <a href="mailto:<?php echo wp_kses_post(autozone_get_option('header_email', '')) ?>"><?php echo wp_kses_post(autozone_get_option('header_email', '')) ?></a></li>
							<?php endif; ?>
                            
						</ul>
					</div>
					<div class="header-topbarbox-2">
                        <?php if (!is_user_logged_in()){ ?>
                            <?php if($autozone_opts['autos_reg_user'] == 0){?>
                                <?php if(class_exists('Car_Subscriber')){?>
                                    <div class="fl-login-register--header fl-top-wrapper-right">
                                    <span class="fl-dropdown-login">
                                        <?php echo esc_html__('Login','autozone'); ?>
                                    </span>

                                    <?php if ( get_option('users_can_register') ) { ?>
                                        <span class="fl-header-register-delimiter"><?php echo esc_html__('or','autozone'); ?></span>
                                        <!-- Start Register-->
                                        <span class="fl-dropdown-register">
                                           <?php echo esc_html__('Register','autozone'); ?>
                                        </span>
                                        <!-- End Register-->
                                    <?php } ?>
                                    <div class="fl-login-sub-menu ">
                                        <?php  carsubscriber_login_show(); ?>
                                    </div>
                                <?php } ?>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <?php
                            $user = wp_get_current_user();
                            ?>
                            <?php if($user->roles[0] == 'administrator' || $user->roles[0] == 'autodealer') {?>
                                <a href="<?php echo esc_url(get_admin_url());?>" class="fl-login-register--header"><i class="fa fa-user" aria-hidden="true"></i><?php echo esc_html($user->user_login, 'autozone');?></a>
                            <?php } else {?>
                                <span class="fl-login-register--header"><i class="fa fa-user" aria-hidden="true"></i><?php echo esc_html($user->user_login, 'autozone');?></span>

                            <?php } ?>
                        <?php } ?>
                        <?php
                        if ( has_nav_menu( 'top_nav' ) ) {
                            wp_nav_menu(array(
                                'theme_location'  => 'top_nav',
                                'container'       => false,
                                'menu_id'		  => 'top-menu',
                                'menu_class'      => '',
                                'depth'           => 1
                            ));
                        }
                        ?>
		                <?php if ( $autozone_header['header_socials'] ) : ?>
						<ul class="nav navbar-nav hidden-xs">
							<?php if (autozone_get_option('social_facebook', '')) { ?>
								<li class="header-social-link"><a href="<?php echo esc_url(autozone_get_option('social_facebook', '')); ?>"
								       target="_blank"><i class="fa fa-facebook"></i></a></li>
							<?php } ?>
							<?php if (autozone_get_option('social_vk', '')) { ?>
								<li class="header-social-link"><a href="<?php echo esc_url(autozone_get_option('social_vk', '')); ?>"
								       target="_blank"><i class="fa fa-vk"></i></a></li>
							<?php } ?>
							<?php if (autozone_get_option('social_youtube', '')) { ?>
								<li class="header-social-link"><a href="<?php echo esc_url(autozone_get_option('social_youtube', '')); ?>"
								       target="_blank"><i class="fa fa-youtube"></i></a></li>
							<?php } ?>
							<?php if (autozone_get_option('social_vimeo', '')) { ?>
								<li class="header-social-link"><a href="<?php echo esc_url(autozone_get_option('social_vimeo', '')); ?>"
								       target="_blank"><i class="fa fa-vimeo"></i></a></li>
							<?php } ?>
							<?php if (autozone_get_option('social_twitter', '')) { ?>
								<li class="header-social-link"><a href="<?php echo esc_url(autozone_get_option('social_twitter', '')); ?>"
								       target="_blank"><i class="fa fa-twitter"></i></a></li>
							<?php } ?>
							<?php if (autozone_get_option('social_google', '')) { ?>
								<li class="header-social-link"><a href="<?php echo esc_url(autozone_get_option('social_google', '')); ?>"
								       target="_blank"><i class="fa fa-google-plus"></i></a></li>
							<?php } ?>
							<?php if (autozone_get_option('social_tumblr', '')) { ?>
								<li class="header-social-link"><a href="<?php echo esc_url(autozone_get_option('social_tumblr', '')); ?>"
								       target="_blank"><i class="fa fa-tumblr"></i></a></li>
							<?php } ?>
							<?php if (autozone_get_option('social_instagram', '')) { ?>
								<li class="header-social-link"><a href="<?php echo esc_url(autozone_get_option('social_instagram', '')); ?>"
								       target="_blank"><i class="fa fa-instagram"></i></a></li>
							<?php } ?>
							<?php if (autozone_get_option('social_pinterest', '')) { ?>
								<li class="header-social-link"><a href="<?php echo esc_url(autozone_get_option('social_pinterest', '')); ?>"
								       target="_blank"><i class="fa fa-pinterest"></i></a></li>
							<?php } ?>
							<?php if (autozone_get_option('social_linkedin', '')) { ?>
								<li class="header-social-link"><a href="<?php echo esc_url(autozone_get_option('social_linkedin', '')); ?>"
								       target="_blank"><i class="fa fa-linkedin"></i></a></li>
							<?php } ?>
							<?php if (autozone_get_option('social_custom_url_1', '')) { ?>
								<li class="header-social-link"><a href="<?php echo esc_url(autozone_get_option('social_custom_url_1', '')); ?>"
								       target="_blank"><i
												class="fa <?php echo esc_attr(autozone_get_option('social_custom_icon_1', '')); ?>"></i></a>
								</li>
							<?php } ?>
							<?php if (autozone_get_option('social_custom_url_2', '')) { ?>
								<li class="header-social-link"><a href="<?php echo esc_url(autozone_get_option('social_custom_url_2', '')); ?>"
								       target="_blank"><i
												class="fa <?php echo esc_attr(autozone_get_option('social_custom_icon_2', '')); ?>"></i></a>
								</li>
							<?php } ?>
							<?php if (autozone_get_option('social_custom_url_3', '')) { ?>
								<li class="header-social-link"><a href="<?php echo esc_url(autozone_get_option('social_custom_url_3', '')); ?>"
								       target="_blank"><i
												class="fa <?php echo esc_attr(autozone_get_option('social_custom_icon_3', '')); ?>"></i></a>
								</li>
							<?php } ?>
						</ul>	
						<?php endif; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>
			<nav id="nav" class="navbar">
				<div class="container ">
					<div class="header-navibox-1">
						<button class="menu-mobile-button visible-xs-block js-toggle-mobile-slidebar toggle-menu-button ">
							<span class="toggle-menu-button-icon"><span></span> <span></span> <span></span> <span></span>
								<span></span> <span></span></span>
						</button>
						<a class="navbar-brand scroll" href="<?php echo esc_url(home_url('/')) ?>" <?php echo wp_kses_post($autozone_logo_stl)?>>
							<?php if ($autozone_header['logo']): ?>
								<img class="normal-logo"
								     src="<?php echo esc_url($autozone_header['logo']) ?>"
								     alt="logo"/>
							<?php else: ?>
								<img class="normal-logo"
								     src="<?php echo get_template_directory_uri(); ?>/images/logo-w.png" alt="logo"/>
							<?php endif ?>
							<?php if ($autozone_header['logo_inverse']): ?>
								<img class="scroll-logo hidden-xs"
								     src="<?php echo esc_url($autozone_header['logo_inverse']) ?>"
								     alt="logo"/>
							<?php else: ?>
								<img class="scroll-logo hidden-xs"
								     src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="logo"/>
							<?php endif ?>
						</a>
					</div>

					
                    
					<div class="header-navibox-3">

						<ul class="nav navbar-nav hidden-xs">
							<?php if ( $autozone_header['header_search'] ) : ?>
							<li class="header-search-icon"><a class="btn_header_search" href="#"><i class="fa fa-search"></i></a></li>
						    <?php endif; ?>

							<?php if ( $autozone_header['header_menu_add_position'] != 'disable' ) : ?>
							<li>
								<button class=" js-toggle-<?php echo esc_attr($autozone_header['header_menu_add_position'] == 'screen' ? 'screen' : $autozone_header['header_menu_add_position'].'-slidebar') ?> toggle-menu-button ">
									<span class="toggle-menu-button-icon"><span></span> <span></span> <span></span>
										<span></span> <span></span> <span></span></span>
								</button>
							</li>
							<?php endif; ?>

							<?php if ( isset($autozone_opts['autos_sell_car_page']) && $autozone_opts['autos_sell_car_page'] != '' &&  $autozone_header['header_sell_button']) : ?>
							<li class="no-hover header-button">
                                <a class="autozone-sell-car" href="<?php echo esc_url(get_permalink($autozone_opts['autos_sell_car_page'])) ?>"><?php echo wp_kses_post(autozone_get_option('header_button_text', esc_html__('Sell Your Car', 'autozone'))) ?></a>
                            </li>
							<?php endif; ?>
                            
                             <?php if ( $autozone_header['header_custom_button']) :  ?>
                              <li class="no-hover header-button">
								<a class="autozone-custom-button" href="<?php echo esc_attr($autozone_header['header_custom_button_link']); ?>">
                                    <?php // echo esc_attr($autozone_header['header_custom_button_name']); ?>
									<?php   _e($autozone_header['header_custom_button_name'], 'autozone') ?>
									<?php 
										if(has_action('wpml_register_single_string')) {
    									$header_custom_button_name      = strip_tags($autozone_header['header_custom_button_name']);
    									do_action( 'wpml_register_single_string', 'autozone', 'Custom Button name', $header_custom_button_name );
										}
									?>				
                                </a>
							</li>
						<?php endif; ?>
						</ul>
					</div>
                    
                    <?php do_action( 'autozone_header_start', $autozone_header); ?>
                    
                    
					<?php if ( $autozone_header['header_menu'] ) : ?>
					<div class="header-navibox-2">
						<?php echo autozone_site_menu('yamm main-menu nav navbar-nav ' . esc_attr($hover_effect). ' ' .esc_attr($autozone_header['header_marker']) ); ?>
					</div>
					<?php endif; ?>
				</div>
			</nav>
		</div>
	</header>
