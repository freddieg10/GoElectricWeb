<?php /* Header Background Image tamplate */ ?>

<?php
	global $wp_filter;
	$autozone_bg_image = autozone_get_option('header_bg_image', '') ? autozone_get_option('header_bg_image', '') : get_template_directory_uri().'/images/page-img.jpg';
	$autozone_shop_cat_bg_image = autozone_get_option('header_shop_cat_bg_image', '') ? autozone_get_option('header_shop_cat_bg_image', '') : get_template_directory_uri().'/images/page-img.jpg';
	$autozone_overlay = autozone_hex2rgb(autozone_get_option('header_bg_color', '#000000'));
	$autozone_opacity = '0.'.autozone_get_option('header_bg_opacity', '8');

    if ( class_exists( 'PIXAD_Settings' ) ){
        $Settings = new PIXAD_Settings();
        $settings = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );

    } else{
        $settings['autos_listing_car_page'] ='';
    }



    if( is_page_template('autos.php')  && !empty($wp_filter['show_car_map']) ){

        do_action( 'show_car_map', ['location' => 'header'] );

    } elseif($settings['autos_listing_car_page'] == get_the_ID() && !empty($wp_filter['show_car_map']) ){
        do_action( 'show_car_map', ['location' => 'header'] );

    } else {
?>

		<div class="block-title__inner section-bg section-bg_second" style="background-image:url(
		  <?php if ( class_exists( 'WooCommerce' ) && is_shop() ) :
			  		$thumbnail_id = get_post_thumbnail_id( wc_get_page_id('shop'));
					$image = wp_get_attachment_url( $thumbnail_id );
					$image = $image == '' ? $autozone_shop_cat_bg_image : $image;
				?>
		  <?php echo esc_url($image) ?>);" >
		  <?php
			 	elseif ( class_exists( 'WooCommerce' ) && is_product_category() ) :
					//$cat = $wp_query->get_queried_object();
			    	//$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
					//$image = wp_get_attachment_url( $thumbnail_id );
                    $image = $autozone_shop_cat_bg_image;
                    if(!isset($image) && $image != ''){
                        $image = '';
                    }
				?>
		  <?php echo esc_url($image) ?>);" >
		  <?php
			 	elseif ( class_exists( 'WooCommerce' ) && is_product() && !empty($post->ID)) :
					$terms = get_the_terms( $post->ID, 'product_cat' );
					$image = '';
					if($terms)
					foreach ($terms as $term) {
						$thumbnail_id = get_term_meta ( $term->term_id, 'thumbnail_id', true );
						$image = wp_get_attachment_url( $thumbnail_id );
						if($image != '')
							break;
					}
                    $image = $autozone_shop_cat_bg_image;
                    if(!isset($image) && $image != ''){
                        $image = '';
                    }
					echo esc_url($image) ?>
		  );" >
		  <?php
			 	elseif ( is_home() || is_archive() || is_page_template('blog-template.php') ) :
					$term = isset ($wp_query) ? $wp_query->get_queried_object() : '';			
					$image = '';
					if(is_object($term) && $term->taxonomy == 'category') {
						$post_thumbnail_id = get_post_thumbnail_id($term->term_id);
						$image = wp_get_attachment_url( $post_thumbnail_id );
					}
					elseif(is_object($term)){
						$image = get_option("autozone_tax_thumb".$term->term_id);
					}
					$image = $image == '' ? $autozone_bg_image : $image;
					echo esc_url($image) ?>
		  );" >
		  <?php	 
				elseif ( is_single() && get_post_type($post->ID) == 'post' ) :
					$categories = get_the_category($post->ID);
					$image = '';
					if($categories){					
						foreach($categories as $category) {
							$image = get_option('autozone_tax_thumb' . $category->term_id);
							if($image != '')
								break;
						}					
					}
					$image = $image == '' ? $autozone_bg_image : $image;
					echo esc_url($image) ?>
		  );" >
		  <?php
				elseif( get_post_type() != 'pixad-autos' ) :
					if( has_post_thumbnail() ): 
						$post_thumbnail_id = get_post_thumbnail_id($post->ID);
						$post_thumbnail_url = wp_get_attachment_url( $post_thumbnail_id );?>
		  <?php 		echo esc_url($post_thumbnail_url) ?>
		  );" >
		  <?php 	else:?>
		  <?php 		echo esc_attr($autozone_bg_image); ?>);" >
		  <?php 	endif;
		  		else: 
		  			echo esc_attr($autozone_bg_image); ?>);" >

		  <?php	endif;?>
		        <span class="vc_row-overlay" style="background-color: rgba(<?php echo  esc_attr($autozone_overlay); ?>,<?php echo  esc_attr($autozone_opacity); ?>) !important;"></span>
				<div class="bg-inner">
					<?php autozone_load_block('header/header_title')?>
					<div class="decor-1 center-block"></div>
					<?php autozone_show_breadcrumbs()?>
				</div><!-- end bg-inner -->

		</div><!-- end block-title__inner -->
		<?php 
	}