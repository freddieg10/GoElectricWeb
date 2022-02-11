<?php

/********** WOOCOMERCE **********/

add_filter( 'loop_shop_per_page', function($cols){return autozone_get_option('autozone_products_per_page','6');}, 20 );

if (!function_exists('autozone_loop_columns')) {
	function autozone_loop_columns() {
		return 3; // 3 products per row
	}
}
add_filter('loop_shop_columns', 'autozone_loop_columns');


function autozone_product_cat_register_meta() {
	//register_meta( 'term', 'cat_icon', 'autozone_sanitize_cat_icon' );
}
/**
 * Sanitize the details custom meta field.
 *
 * @param  string $details The existing details field.
 * @return string          The sanitized details field
 */

function autozone_sanitize_cat_icon( $cat_icon ) {
	return esc_attr( $cat_icon );
}

add_action( 'product_cat_add_form_fields', 'autozone_product_cat_add_details_meta' );
/**
 * Add a details metabox to the Add New Product Category page.
 *
 * For adding a details metabox to the WordPress admin when
 * creating new product categories in WooCommerce.
 *
 */
function autozone_product_cat_add_details_meta() {
	wp_nonce_field( basename( __FILE__ ), 'autozone_product_cat_details_nonce' );
	?>
	<div class="form-field">
		<label for="autozone-product-cat_icon"><?php esc_html_e( 'Icon Class', 'autozone' ); ?></label>
		<input name="autozone-product-cat_icon" id="autozone-product-cat_icon">
		<p class="description"><?php esc_html_e( 'Icon class for category (auto15)', 'autozone' ); ?></p>
	</div>
	<?php
}

add_action( 'product_cat_edit_form_fields', 'autozone_product_cat_edit_details_meta' );
/**
 * Add a details metabox to the Edit Product Category page.
 *
 * For adding a details metabox to the WordPress admin when
 * editing an existing product category in WooCommerce.
 *
 * @param  object $term The existing term object.
 */
function autozone_product_cat_edit_details_meta( $term ) {
	$product_cat_icon = get_woocommerce_term_meta( $term->term_id, 'cat_icon', true );
	if ( ! $product_cat_icon ) {
		$product_cat_icon = '';
	}

	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="autozone-product-cat_icon"><?php esc_html_e( 'Icon', 'autozone' ); ?></label></th>
		<td>
			<?php wp_nonce_field( basename( __FILE__ ), 'autozone_product_cat_details_nonce' ); ?>
			<input type="text" name="autozone-product-cat_icon" id="autozone-product-cat_icon" value="<?php echo esc_attr( $product_cat_icon ) ? esc_attr( $product_cat_icon ) : ''; ?>">
			<p class="description"><?php esc_html_e( 'Icon class for category (auto15)', 'autozone' ); ?></p>
		</td>
	</tr>
	<?php
}

add_action( 'create_product_cat', 'autozone_product_cat_details_meta_save' );
add_action( 'edit_product_cat', 'autozone_product_cat_details_meta_save' );
/**
 * Save Product Category details meta.
 *
 * Save the product_cat details meta POSTed from the
 * edit product_cat page or the add product_cat page.
 *
 * @param  int $term_id The term ID of the term to update.
 */
function autozone_product_cat_details_meta_save( $term_id ) {
	if ( ! isset( $_POST['autozone_product_cat_details_nonce'] ) || ! wp_verify_nonce( $_POST['autozone_product_cat_details_nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	$old_details = get_woocommerce_term_meta( $term_id, 'cat_icon', true );
	$new_details = isset( $_POST['autozone-product-cat_icon'] ) ? $_POST['autozone-product-cat_icon'] : '';
	if ( $old_details && '' === $new_details ) {
		delete_woocommerce_term_meta( $term_id, 'cat_icon' );
	} else if ( $old_details !== $new_details ) {
		update_woocommerce_term_meta(
			$term_id,
			'cat_icon',
			autozone_sanitize_cat_icon( $new_details )
		);
	}
}


function autozone_is_woo_page () {
        if(  function_exists ( "is_woocommerce" ) && is_woocommerce()){
                return true;
        }
        $woocommerce_keys   =   array ( "woocommerce_shop_page_id" ,
                                        "woocommerce_terms_page_id" ,
                                        "woocommerce_cart_page_id" ,
                                        "woocommerce_checkout_page_id" ,
                                        "woocommerce_pay_page_id" ,
                                        "woocommerce_thanks_page_id" ,
                                        "woocommerce_myaccount_page_id" ,
                                        "woocommerce_edit_address_page_id" ,
                                        "woocommerce_view_order_page_id" ,
                                        "woocommerce_change_password_page_id" ,
                                        "woocommerce_logout_page_id" ,
                                        "woocommerce_lost_password_page_id" ) ;
        foreach ( $woocommerce_keys as $wc_page_id ) {
                if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
                        return true ;
                }
        }
        return false;
}
