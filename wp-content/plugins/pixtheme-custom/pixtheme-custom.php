<?php
/***********************************

	Plugin Name:  PixthemeCustom
	Plugin URI:   http://templines.com/
	Description:  Additional functionality for Autozone
	Version:      2.4
	Author:       Templines
	Author URI:   http://templines.com	
	Text Domain:pixtheme
	Domain Path:  /languages/
	
***********************************/

require 'plugin-update-checker/plugin-update-checker.php';
$MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'http://assets.templines.com/plugins/theme/autozone/pixtheme-custom.json',
    __FILE__,
    'pixtheme-custom'
);  


if ( ! defined( 'ABSPATH' ) ) {
	exit; // disable direct access
}

/** Register widget for brands */
add_action('plugins_loaded', 'pixtheme_load_textdomain');
function pixtheme_load_textdomain() {
	load_plugin_textdomain( 'pixtheme', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}

require_once('pixtheme-custom-widgets.php');
require_once('pixtheme-import.php');
require_once('shortcode.php');

function autozone_email_add_auto(){
    if (class_exists('PIXAD_Settings')){
        $Settings   = new PIXAD_Settings();
        $options    = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
    }

    $args = array(
        'role'    => 'administrator'
    );
    $users = get_users( $args );
    $admin_email = array();
    foreach ($users as $user){
        $admin_email[] = $user->user_email;
    }
    if(isset( $_REQUEST['_thumbnail_id']) && $_REQUEST['_thumbnail_id'] != ''){
        $image_id = $_REQUEST['_thumbnail_id'];
    }

    $auto_to_email = '';
    if(isset($_REQUEST['auto-post-title']) && $_REQUEST['auto-post-title'] != ''){
        $auto_to_email .= '<h2>' . $_REQUEST['auto-post-title'] . '</h2>';
    }
    if(isset($_REQUEST['auto-make']) && $_REQUEST['auto-make'] != ''){
        $am_term = get_term_by('slug', $_REQUEST['auto-make'], 'auto-model');
        $am_term_parent_id = $am_term->parent;
        $parent_model = get_term_by('id', $am_term_parent_id, 'auto-model');
        $model = $parent_model->name . ' ' . $am_term->name;

        $auto_to_email .= '<p>' . esc_attr('Auto Model: ', 'autozone') . '<strong>' . $model . '</strong></p>';
    }
    if(isset($_REQUEST['auto-price']) && $_REQUEST['auto-price'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Auto Price: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['auto-price'] ) . '</strong></p>';
    }
    if(isset($_REQUEST['auto-year']) && $_REQUEST['auto-year'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Auto Year: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['auto-year'] )  . '</strong></p>';
    }



    if(isset($_REQUEST['auto-transmission']) && $_REQUEST['auto-transmission'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Transmission: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['auto-transmission'] )  . '</strong></p>';
    }
    if(isset($_REQUEST['auto-condition']) && $_REQUEST['auto-condition'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Auto Condition: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['auto-condition'] )  . '</strong></p>';
    }
    if(isset($_REQUEST['auto-purpose']) && $_REQUEST['auto-purpose'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Auto Purpose: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['auto-purpose'] )  . '</strong></p>';
    }
    if(isset($_REQUEST['auto-drive']) && $_REQUEST['auto-drive'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Auto Drive: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['auto-drive'] )  . '</strong></p>';
    }
    if(isset($_REQUEST['auto-color']) && $_REQUEST['auto-color'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Color: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['auto-color'] )  . '</strong></p>';
    }
    if(isset($_REQUEST['auto-color-int']) && $_REQUEST['auto-color-int'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Interior Color: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['auto-color-int'] )  . '</strong></p>';
    }
    if(isset($_REQUEST['auto-doors']) && $_REQUEST['auto-doors'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Doors: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['auto-doors'] )  . '</strong></p>';
    }
    if(isset($_REQUEST['auto-fuel']) && $_REQUEST['auto-fuel'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Fuel Type: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['auto-fuel'] )  . '</strong></p>';
    }
    if(isset($_REQUEST['auto-mileage']) && $_REQUEST['auto-mileage'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Mileage: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['auto-mileage'] )  . '</strong></p>';
    }
    if(isset($_REQUEST['auto-engine']) && $_REQUEST['auto-engine'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Engine, cm3: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['auto-engine'] )  . '</strong></p>';
    }
    if(isset($_REQUEST['auto-warranty']) && $_REQUEST['auto-warranty'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Warranty: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['auto-warranty'] )  . '</strong></p>';
    }
    if(isset($_REQUEST['auto-vin']) && $_REQUEST['auto-vin'] != ''){
        $auto_to_email .= '<p>' . esc_attr('VIN: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['auto-vin'] )  . '</strong></p>';
    }
    if(isset($_REQUEST['auto-horsepower']) && $_REQUEST['auto-horsepower'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Horsepower, hp: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['auto-horsepower'] )  . '</strong></p>';
    }
    if(isset($_REQUEST['auto-seats']) && $_REQUEST['auto-seats'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Seating Capacity: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['auto-seats'] )  . '</strong></p>';
    }
    if(isset($_REQUEST['auto-version']) && $_REQUEST['auto-version'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Auto Version: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['auto-version'] )  . '</strong></p>';
    }

    if(isset($_REQUEST['auto-body']) && $_REQUEST['auto-body'] != ''){
        $auto_body = $_REQUEST['auto-body'];
        $term_names = '';
        foreach ($auto_body as $b) {
            $t_slug = $b;
            $term = get_term_by( 'slug', $t_slug, 'auto-body' );
            if( !next( $auto_body ) ) {
                $term_names .= $term->name;
            } else {
                $term_names .= $term->name.', ';
            }
        }
        $auto_to_email .= '<p>' . esc_attr('Auto Body: ', 'autozone') . '<strong>' . sanitize_text_field( $term_names )  . '</strong></p>';
    }
    if(isset($_REQUEST['auto-equipment']) && $_REQUEST['auto-equipment'] != ''){
        $auto_equipment = $_REQUEST['auto-equipment'];

        $term_names = '';
        foreach ($auto_equipment as $b) {
            $t_slug = $b;
            $term = get_term_by( 'slug', $t_slug, 'auto-equipment' );
            if( !next( $auto_equipment ) ) {
                $term_names .= $term->name;
            } else {
                $term_names .= $term->name.', ';
            }
        }
        $auto_to_email .= '<p>' . esc_attr('Car Equipment: ', 'autozone') . '<strong>' . sanitize_text_field( $term_names )  . '</strong></p>';
    }


    if(isset($_REQUEST['seller-first-name']) && $_REQUEST['seller-first-name'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Seller first name: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['seller-first-name'] )  . '</strong></p>';
    }
    if(isset($_REQUEST['seller-last-name']) && $_REQUEST['seller-last-name'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Seller last name: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['seller-last-name'] )  . '</strong></p>';
    }
    if(isset($_REQUEST['seller-phone']) && $_REQUEST['seller-phone'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Seller phone: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['seller-phone'] )  . '</strong></p>';
    }
    if(isset($_REQUEST['seller-email']) && $_REQUEST['seller-email'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Seller email: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['seller-email'] )  . '</strong></p>';
    }
    if(isset($_REQUEST['seller-country']) && $_REQUEST['seller-country'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Seller country: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['seller-country'] )  . '</strong></p>';
    }
    if(isset($_REQUEST['seller-state']) && $_REQUEST['seller-state'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Seller state: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['seller-state'] )  . '</strong></p>';
    }
    if(isset($_REQUEST['seller-location']) && $_REQUEST['seller-location'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Seller location: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['seller-location'] )  . '</strong></p>';
    }
    if(isset($_REQUEST['seller-company']) && $_REQUEST['seller-company'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Seller company: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['seller-company'] )  . '</strong></p>';
    }
    if(isset($_REQUEST['seller-town']) && $_REQUEST['seller-town'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Seller town: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['seller-town'] )  . '</strong></p>';
    }

    if(isset($_REQUEST['content']) && $_REQUEST['content'] != ''){
        $auto_to_email .= '<p>' . esc_attr('Description: ', 'autozone') . '<strong>' . sanitize_text_field( $_REQUEST['content'] )  . '</strong></p>';
    }

    if(isset($image_id) && $image_id != ''){
        $auto_to_email .= '<img src="' . wp_get_attachment_image_url($image_id) . '">';
    }

    if (isset($options['autos_send_to_email']) && $options['autos_send_to_email'] == '1'){
        wp_mail( $admin_email, 'New Auto', $auto_to_email);
    }
}


function register_pixtheme_custom_widget() {
	if (class_exists('YITH_WCBR')){
		register_widget( 'Pixtheme_StaticBlock_Widget' );
	}
}
add_action( 'widgets_init', 'register_pixtheme_custom_widget' );


if ( ! class_exists( 'PixthemeCustom' ) ) :

/************* STATICBLOCK ***************/

	class PixthemeCustom {
		
		static function pixtheme_init(){
			$labels = array(
				'name'               => _x( 'Static Blocks', 'post type general name', 'pixtheme' ),
				'singular_name'      => _x( 'Static Block', 'post type singular name', 'pixtheme' ),
				'menu_name'          => _x( 'Static Blocks', 'admin menu', 'pixtheme' ),
				'name_admin_bar'     => _x( 'Static Block', 'add new on admin bar', 'pixtheme' ),
				'add_new'            => _x( 'Add New', 'book', 'pixtheme' ),
				'add_new_item'       => __( 'Add New Block', 'pixtheme' ),
				'new_item'           => __( 'New Block', 'pixtheme' ),
				'edit_item'          => __( 'Edit Block', 'pixtheme' ),
				'view_item'          => __( 'View Block', 'pixtheme' ),
				'all_items'          => __( 'All Blocks', 'pixtheme' ),
				'search_items'       => __( 'Search Block', 'pixtheme' ),
				'parent_item_colon'  => __( 'Parent Block:', 'pixtheme' ),
				'not_found'          => __( 'No blocks found.', 'pixtheme' ),
				'not_found_in_trash' => __( 'No blocks found in Trash.', 'pixtheme' )
			);
	
			$args = array(
				'labels'             => $labels,
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'staticblock' ),
				'capability_type'    => 'post',
				'has_archive'        => 'staticblocks',
				'hierarchical'       => false,
				'menu_position'      => 8,
				'supports'           => array( 'title', 'editor',  'thumbnail', 'page-attributes', 'comments' ),
				'menu_icon'			 => get_template_directory_uri() . "/images/pix-static.png"
			);
		
	
	        register_post_type( 'staticblocks', $args );
		}
		
		
		
		
		
		

		
		
	}
	
	if(!function_exists('pix_show_productpage_static_block')) {
			function pix_show_productpage_static_block() {
			    $product = get_post(get_the_ID());
				// Do not show this on variable products
				if ( $product->product_type <> 'variable' ) {
					$args = array(
						'post_type'        => 'staticblocks',
						'post_status'      => 'publish',
					);
					$staticBlocksData = get_posts( $args );
					foreach($staticBlocksData as $_block){
						$staticBlocks[$_block->ID] = $_block->post_title;
					}
				
				
					
		
					
					$staticblock = get_post_meta( $product->ID, '_static_bottom', true );
		
					echo '<div class="show_if_simple show_if_variable">';
					pixtheme_wp_select_multiple( array( 
						'id' => '_static_bottom', 
						'label' => __( 'Static Block Description', 'pixtheme' ), 
						'options' => $staticBlocks, 
						'name' => '_static_bottom[]',
						'desc_tip' => true, 
						'description' => __( 'Select the block to display at the bottom of the product page' , 'pixtheme'),
						'value' => explode(",",$staticblock)
					) );
			
					echo '</div>';
				}
			}
		}
		
		
		if(!function_exists('pixtheme_add_bottom_block_product')) {
			function pixtheme_add_bottom_block_product() {
				$output = "";
				$product = get_post(get_the_ID());
				$staticblockIDs = get_post_meta( $product->ID, '_static_bottom', true );
				$staticblockIDsExploded = explode(',',$staticblockIDs);
				foreach($staticblockIDsExploded as $_staticblockID){
					if (!is_numeric($_staticblockID)) continue;
					$staticblock = get_post($_staticblockID);
					$output .= '<div class="container">' . apply_filters( 'the_content',$staticblock->post_content) . '</div>';
				}
				
				echo $output;
			}
		}
		
		
		
		if(!function_exists('pixtheme_woocommerce_product_quick_edit_save')) {
			function pixtheme_woocommerce_product_quick_edit_save($product_id){
				
				if ( isset( $_REQUEST['_static_bottom'] ) ){
					if (!get_post_meta( $product_id, '_static_bottom', true )){
						add_post_meta($product_id, '_static_bottom', wc_clean( implode(",",$_REQUEST['_static_bottom'] )));
					}else{
						update_post_meta( $product_id, '_static_bottom', wc_clean( implode(",",$_REQUEST['_static_bottom'] )) );	
					}
					
				}else{
					if (get_post_meta( $product_id, '_static_bottom', true )){
						update_post_meta( $product_id, '_static_bottom', wc_clean( "," ) );	
					}
				}
			}
		}
				
		
		
		
		if(!function_exists('pixtheme_staticblocks_get')) {
		    function pixtheme_staticblocks_get () {
		        $return_array = array();
		        $args = array( 'post_type' => 'staticblocks', 'posts_per_page' => 30);     
				$myposts = get_posts( $args );
		        $i=0;
		        foreach ( $myposts as $post ) {
		            $i++;
		            $return_array[$i]['label'] = get_the_title($post->ID);
		            $return_array[$i]['value'] = $post->ID;
		        } 
		        wp_reset_postdata();
		        return $return_array;
		    }
		}
		
		
		if(!function_exists('pixtheme_staticblocks_show')) {
		    function pixtheme_staticblocks_show ($id = false) {
		        echo pixtheme_staticblocks_single($id);
		    }
		}
		
		
		if(!function_exists('pixtheme_staticblocks_single')) {
		    function pixtheme_staticblocks_single($id = false) {
		    	if(!$id) return;
		    	
		    	$output = false;
		    	
		    	$output = wp_cache_get( $id, 'pixtheme_staticblocks_single' );
		    	
			    if ( !$output ) {
			   
			        $args = array( 'include' => $id,'post_type' => 'staticblocks', 'posts_per_page' => 1);
			        $output = '';
			        $myposts = get_posts( $args );
			        foreach ( $myposts as $post ) {
			        	setup_postdata($post);
						
			        	$output = do_shortcode(get_the_content($post->ID));
			        	
						$shortcodes_custom_css = get_post_meta( $post->ID, '_wpb_shortcodes_custom_css', true );
						if ( ! empty( $shortcodes_custom_css ) ) {
							$output .= '<style type="text/css" data-type="vc_shortcodes-custom-css">';
							$output .= $shortcodes_custom_css;
							$output .= '</style>';
						}
			        } 
			        wp_reset_postdata();
			        
			        wp_cache_add( $id, $output, 'pixtheme_staticblocks_single' );
			    }
			    
		        return $output;
		   }
		}
		
		
		


function pixtheme_post_type_link_filter_function( $post_link, $id = 0, $leavename = FALSE ) {
    if ( strpos('%portfolio_category%', $post_link)  < 0 ) {
      return $post_link;
    }
    $post = get_post($id);
    if ( !is_object($post) || $post->post_type != 'portfolio' ) {
      return $post_link;
    }
    $terms = wp_get_object_terms($post->ID, 'portfolio_category');
    if ( !$terms ) {
      return str_replace('portfolio/category/%portfolio_category%/', '', $post_link);
    }
    return str_replace('%portfolio_category%', $terms[0]->slug, $post_link);
}
  
add_filter('post_type_link', 'pixtheme_post_type_link_filter_function', 1, 3);


		
		
		
endif;



add_action( 'init', array('PixthemeCustom','pixtheme_init') );
add_action( 'woocommerce_product_options_advanced', 'pix_show_productpage_static_block', 55 );
add_action('save_post','pixtheme_woocommerce_product_quick_edit_save');
add_action('woocommerce_after_single_product_summary','pixtheme_add_bottom_block_product',15);


/************** Multiselect Field***************/
function pixtheme_wp_select_multiple( $field ) {
    global $thepostid, $post, $woocommerce;

    $thepostid              = empty( $thepostid ) ? $post->ID : $thepostid;
    $field['class']         = isset( $field['class'] ) ? $field['class'] : 'select short';
    $field['wrapper_class'] = isset( $field['wrapper_class'] ) ? $field['wrapper_class'] : '';
    $field['name']          = isset( $field['name'] ) ? $field['name'] : $field['id'];
    $field['value']         = isset( $field['value'] ) ? $field['value'] : ( get_post_meta( $thepostid, $field['id'], true ) ? get_post_meta( $thepostid, $field['id'], true ) : array() );

    echo '<p class="form-field ' . esc_attr( $field['id'] ) . '_field ' . esc_attr( $field['wrapper_class'] ) . '"><label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label><select id="' . esc_attr( $field['id'] ) . '" name="' . esc_attr( $field['name'] ) . '" class="' . esc_attr( $field['class'] ) . '" multiple="multiple">';

    foreach ( $field['options'] as $key => $value ) {

        echo '<option value="' . esc_attr( $key ) . '" ' . ( in_array( $key, $field['value'] ) ? 'selected="selected"' : '' ) . '>' . esc_html( $value ) . '</option>';

    }

    echo '</select> ';

    if ( ! empty( $field['description'] ) ) {

        if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
            echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . esc_url( WC()->plugin_url() ) . '/assets/images/help.png" height="16" width="16" />';
        } else {
            echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
        }

    }
    echo '</p>';
}
/********************************************/


/** Set custom VC directory */
global $vc_manager;

if ($vc_manager){
    $vc_manager->setCustomUserShortcodesTemplateDir(dirname( __FILE__ ) . '/vc_templates');

}

?>