<?php
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Customproduct
 */
 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
	

$product_id = esc_attr($product);
$product = wc_get_product( $product_id );




$out = '<div class="custom-product-item '.esc_attr($style).' '.esc_attr($class_name).'">
					<div class="cpri-wrapper">
						<img src="'.get_the_post_thumbnail_url( $product->get_id(), 'autozone-services-thumb' ).'">';

$showButton = esc_attr($button);
if ( $showButton == 'true' ) {
	$out .= '	<a href= "?add-to-cart='.$product_id.'" class="button product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="'.$product_id.'"  aria-label="Add “'. $product->get_name() .'” to your cart" rel="nofollow">'.esc_html__( 'Add to cart', 'autozone' ).'</a>';
}


	$out .= '</div>
					<h4><a href="'.get_permalink( $product->get_id() ).'">'. $product->get_name() .'</a></h4>
					<div class="cpri-price">
						<span>'. $product->get_price_html() .'</span>
					</div>
				</div>';


echo $out;