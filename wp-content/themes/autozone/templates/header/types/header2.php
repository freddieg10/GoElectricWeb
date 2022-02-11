<?php /* Header Type 2 */
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
?>
<header class="header
        
    <?php if ($autozone_header['header_bar']) : ?>
	    header-topbar-view
	    header-topbarbox-1-<?php echo esc_attr($autozone_header['header_topbarbox_1_position']) ?>
        header-topbarbox-2-<?php echo esc_attr($autozone_header['header_topbarbox_2_position']) ?>
    <?php endif; ?>

        header-<?php echo esc_attr($autozone_header['header_layout']) ?>-width

        header-menu-middle

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
						<?php if ($autozone_header['header_email']) : ?>
							<li><i class="icon fa fa-envelope"></i> <?php echo wp_kses_post(autozone_get_option('header_email', '')) ?></li>
						<?php endif; ?>
					</ul>

                
         
					<ul class="nav navbar-nav hidden-xs">
					<?php if ( $autozone_header['header_socials'] ) : ?>
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
					<?php endif; ?>

					

						
					</ul>
			
                
                
     </div> 
                
                
				<div class="header-topbarbox-2">
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
				</div>
			</div>
		</div>
	<?php endif; ?>
		<nav id="nav" class="navbar">
			<div class="container ">
					<div class="col-md-3 col-xs-12">
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
			
					<div class="col-md-2 col-xs-12">
                        
                        
                        <?php if ($autozone_header['header_phone']) : ?>
					<ul class="phone-menu">
                        <li class="no-hover">
                            
                            <i class="icon fa icon-earphones-alt"></i> 
                            
                            <div class="phone-menu-info">
                            <span><?php esc_html_e('Call Support', 'autozone');?></span>
                            
                            <span><?php echo wp_kses_post(autozone_get_option('header_phone', '')) ?></span>
                        </div>
                        </li></ul>
				<?php endif; ?>
                        
                </div>
                
                
             <div class="col-md-4 col-xs-12">
                        
                        
                       <div class="header-navibox-search">   
                           
                           
                            <form action="<?php echo site_url() ?>" method="get" id="search-global-form">
            <div class="input-group top-search">
              <input type="text" class="form-control" value="<?php the_search_query(); ?>" name="s" placeholder="<?php esc_html__('Press Enter to search', 'autozone');?>">
			  <input type="hidden" name="post_type" value="product" />
              <span class="input-group-btn">
              <button class="btn btn-default" type="submit"><span class="icon-magnifier"></span></button>
              </span> </div>
          </form>
                
		 
            
                </div>
                    
                      </div>
                        
                        
					<div class="col-md-3 col-xs-12">
                        
                        
                        
                        <div class="nav-custom-info-wrap">
                    
                    <div class="nav-custom-info nav-custom-cart">
	                    	
								<div class="striped-icon-nav">
                                    
                                    <a href="<?php echo wc_get_cart_url();?>"><span class="theme-fonts-icon_bag_alt"></span></a>
							<span class="header-cart-count"><?php echo WC()->cart->cart_contents_count; ?></span>
                                    
			                 		
			                 	</div>
	                   
                
                        
			</div>  
                    
			<div class="nav-custom-info">
				<div class="striped-icon-nav">
			        <span class="<?php echo esc_attr($autozone_header['header_block2_icon']) ?>"></span>
			    </div>
				<div class="header_type5_block1_content">
					<div class="harrow"></div> 
					<?php echo wp_kses_post(get_theme_mod('autozone_header_block2_content', '')) ?>
				</div>
	        </div>
			<div class="nav-custom-info">
	            <div class="striped-icon-nav">
			        <span class="<?php echo esc_attr($autozone_header['header_block3_icon']) ?>"></span>
			    </div>
	            <div class="header_type5_block1_content">
	            	<div class="harrow"></div>
	            	<?php echo wp_kses_post(get_theme_mod('autozone_header_block3_content', '')) ?>
	            </div>
	        </div>
		</div>
	</div>
	</div>
		</nav>
		<?php if ( $autozone_header['header_menu'] ) : ?>
		<div class="header-navibox-2">
			<div class="container">
				<?php echo autozone_site_menu('yamm main-menu nav navbar-nav ' . esc_attr($hover_effect). ' ' .esc_attr($autozone_header['header_marker'])); ?>
				
			</div>

		</div>
		<?php endif; ?>
	</div>
</header>