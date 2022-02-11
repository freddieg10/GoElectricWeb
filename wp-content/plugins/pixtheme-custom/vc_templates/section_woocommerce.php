<?php
global $post;
/**
 * Shortcode attributes
 * @var $atts
 * @var $count
 * @var $cats
 * @var $carousel
 * @var $controls
 * @var $min_slides
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Woocommerce
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$min_slides = $min_slides == '' ? 4 : $min_slides;

if( $cats == '' ):
	$out = '<p>'.esc_html__('No categories selected. To fix this, please login to your WP Admin area and set the categories you want to show by editing this shortcode and setting one or more categories in the multi checkbox field "Categories".', 'autozone');
else: 

$out = $css_animation != '' ? '<div class="animated" data-animation="' . esc_attr($css_animation) . '">' : '<div>';
$out .= '	
			
			<div class="'.esc_attr($carousel).' owl-theme '.esc_attr($controls).'" data-min-slides="'.esc_attr($min_slides).'">
			';	
		

	$product_cat_to_query = get_objects_in_term( explode( ",", $cats ), 'product_cat');
	$args = array(
				'post_type' => 'product', 
				'orderby' => 'menu_order',	
				'post__in' => $product_cat_to_query,		 
				'order' => 'ASC',
			);
	if( is_numeric($count) )
		$args['showposts'] = $count;
	else
		$args['posts_per_page'] = -1;
	
$wp_query = new WP_Query( $args );
				 					
	if ($wp_query->have_posts()):
		while ($wp_query->have_posts()) : 							
						$wp_query->the_post();
						global $product;
						$custom = get_post_custom($post->ID);
		
						$cats = wp_get_object_terms($post->ID, 'product_cat');					   
												
						if ($cats){
							$cat_slugs = '';
							$cat_names = '';
							foreach( $cats as $cat ){
								$cat_slugs .= $cat->slug . " ";
								$cat_names .= $cat->name . ", ";
							}
							$cat_names = substr($cat_names, 0, -2);
						}
						
						$link = get_the_permalink($product->id); 
						$thumbnail = get_the_post_thumbnail($post->ID, 'shop_catalog', array('class' => 'cover'));
						
						$attach_ids = $product->get_gallery_attachment_ids();
						$attachment_count = count( $product->get_gallery_attachment_ids() );
						if($attachment_count > 0){
							$image_link = wp_get_attachment_url( $attach_ids[0] ); 
							$default_attr = array(
								'class'	=> "slider_img",
								'alt'   => get_the_title($product->id),
							);
							$image = wp_get_attachment_image( $attach_ids[0], 'shop_catalog', false, $default_attr);
							
						}
$out .= '
			<div class="item">
				<div class="product-box">
					<div class="product-image">
						<a href="'.esc_url($link).'">
							'.$thumbnail.'
						</a>
					</div>
					<div class="product-desc-wrapper">
						<div class="product-title"><span>'.wp_kses_post(get_the_title($product->id)).'</span></div>';
					if ( get_option( 'woocommerce_enable_review_rating' ) !== 'no' ) {
						$out .= '<div class="product-desc"><div class="rating">';
							if ( $rating_html = $product->get_rating_html() ) { 
								$out .= wp_kses_post($rating_html); 
							}
						$out .= '</div></div>';
					}
					$out .= '
						<div class="row-pr">
							<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">';
							$out .= apply_filters( 'woocommerce_loop_add_to_cart_link',
								sprintf( '<a href="%s" data-rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="add-to-cart pull-right %s product_type_%s"><span>%s</span></a>',
									esc_url( $product->add_to_cart_url() ),
									esc_attr( $product->id ),
									esc_attr( $product->get_sku() ),
									esc_attr( isset( $quantity ) ? $quantity : 1 ),
									$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
									esc_attr( $product->product_type ),
									esc_html( $product->add_to_cart_text() )
								),
							$product );
						$out .= '
							</div>
							<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
								<div class="price">'. wp_kses_post($product->get_price_html()).'</div>';
					
						$out .= '
							</div>
						</div>
					</div>
				</div>
			</div>									
        ';
	
		endwhile;
	endif;
 
$out .= '            
			</div>
	';

$out .= '</div>';
endif;	
echo $out;