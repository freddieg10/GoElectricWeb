<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Include Neccessary Backend Files
 * 
 * @since 0.1
 * @require_once
 */
require_once 'backend/meta_boxes.php';
/**
 * Enqueue Scripts && Stylesheets to Backend
 *
 * @since 0.1
 */
add_action( 'admin_enqueue_scripts', 'pixad_autos_enqueue_scripts' );
function pixad_autos_enqueue_scripts() {
	
	$page = isset( $_REQUEST['page'] ) ? sanitize_text_field( $_REQUEST['page'] ) : '';
	$tab  = isset( $_REQUEST['tab'] )  ? sanitize_text_field( $_REQUEST['tab'] ) : '';
	
	// jQuery Bootstrap 3
	wp_register_script( 'bootstrap', PIXAD_AUTO_URI . 'assets/js/bootstrap.min.js', array(), '3.3.0', true ); // In footer
	wp_enqueue_script( 'bootstrap' );
    wp_enqueue_script("jquery");
	// PIXAD Autos Backend Stylesheet
	wp_register_style( 'pixad-autos-backend', PIXAD_AUTO_URI . 'assets/css/pixad-autos-backend.css', array(), '1.0.0' );
	wp_enqueue_style( 'pixad-autos-backend' );

	// FontAwesome
	wp_register_style( 'font-awesome', PIXAD_AUTO_URI . 'assets/css/font-awesome.min.css', array(), '4.2.0' );
	wp_enqueue_style( 'font-awesome' );

	// Chosen CSS
	wp_register_style( 'chosen', PIXAD_AUTO_URI . 'assets/css/chosen.css', array(), '1.4.1' );
	wp_enqueue_style( 'chosen' );

	// Chosen JS
	wp_register_script( 'chosen', PIXAD_AUTO_URI . 'assets/js/chosen.jquery.min.js', array(), '1.4.1', true ); // In footer
	wp_enqueue_script( 'chosen' );

	// Backend
	wp_register_script( 'pixad-backend', PIXAD_AUTO_URI . 'assets/js/backend.js', array(), '1.0.0', true );
	wp_enqueue_script( 'pixad-backend' );

	// Validation
	wp_register_script( 'pixadautos-validation', PIXAD_AUTO_URI . 'assets/js/validation.js' );
	wp_enqueue_script( 'pixadautos-validation' );

	// Color Picker
	if( $page == 'pixads-settings' &&  $tab == 'styling' ) {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
	}
}
/**
 * Add "Transactions" && "Settings" navigation under "pixad-autos" post_type
 *
 * @since 0.1
 */
add_action('admin_menu', 'pixad_autos_submenu_pages');
function pixad_autos_submenu_pages() {
	$Settings = new PIXAD_Settings();
	$settings = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );

	// Add Settings Page
	add_submenu_page(
		'edit.php?post_type=pixad-autos',
		__( 'Settings', 'pixad' ),
		__( 'Settings', 'pixad' ),
		'manage_options',
		'pixads-settings',
		'pixad_autos_settings_page_callback'
	);
}

/**
 * General Settings Page Callback
 *
 * @since 0.1
 */
function pixad_autos_settings_page_callback() {
	$Settings	= new PIXAD_Settings();
	$options	= $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );

	$page 		= isset( $_GET['page'] ) ? esc_attr($_GET['page']) : '';
	$tab  		= isset( $_GET['tab'] ) ? esc_attr( $_GET['tab'] ) : '';
	$action		= isset( $_GET['action'] ) ? esc_attr( $_GET['action'] ) : '';
	$updated	= isset( $updated ) ? $updated : '';

	if( isset( $_POST['action'] ) == 'update' ) {
		$updated = true;
	}

	$general_settings = '';
	//$payment_settings = '';
	//$membership_settings = '';
	//$email_settings = '';
	$currencies_settings = '';
	$validation_settings = '';
	$license_settings = '';
	$styling_settings = '';

	if( $page == 'pixads-setings' && $tab == 'general_settings' ) {
		$general_settings = true;
		$case = 'general_settings';
	}
	else
	if( $page == 'pixads-settings' && $tab == 'payment_gateways' ) {
		$payment_settings = true;
		$case = 'payment_gateways';
	}
	else
	if( $page == 'pixads-settings' && $tab == 'membership' ) {
		$membership_settings = true;
		$case = 'membership';
	}
	else
	if( $page == 'pixads-settings' && $tab == 'email_templates' ) {
		$email_settings = true;
		$case = 'email_templates';
	}
	else
	if( $page == 'pixads-settings' && $tab == 'currencies' ) {
		$currencies_settings = true;
		$case = 'currencies';
	}
	else
	if( $page == 'pixads-settings' && $tab == 'validation' ) {
		$validation_settings = true;
		$case = 'validation';
	}
	else
	if( $page == 'pixads-settings' && $tab == 'jp_license' ) {
		$license_settings = true;
		$case = 'license_settings';
	}
	else
	if( $page == 'pixads-settings' && $tab == 'styling' ) {
		$styling_settings = true;
		$case = 'styling_settings';
	}else{
		$general_settings = true;
		$case = 'general_settings';
	}
?>
	<div class="wrap">
		<h3><?php _e( 'Autos Settings', 'pixad' ); ?></h3>

		<h3 class="nav-tab-wrapper">

			<a href="<?php echo esc_url( admin_url() ); ?>edit.php?post_type=pixad-autos&page=pixads-settings&tab=general_settings" class="nav-tab <?php if($general_settings): ?>nav-tab-active<?php endif; ?>">
				<?php _e( 'General Settings', 'pixad' ); ?>
			</a>


			<a href="<?php echo esc_url( admin_url() ); ?>edit.php?post_type=pixad-autos&page=pixads-settings&tab=currencies" class="nav-tab <?php if($currencies_settings): ?>nav-tab-active<?php endif; ?>">
				<?php _e( 'Currencies', 'pixad' ); ?>
			</a>

			<a href="<?php echo esc_url( admin_url() ); ?>edit.php?post_type=pixad-autos&page=pixads-settings&tab=validation" class="nav-tab <?php if($validation_settings): ?>nav-tab-active<?php endif; ?>">
				<?php _e( 'Auto Fields', 'pixad' ); ?>
			</a>


		</h3>

		<?php
		// Switch between tabs
		switch( $case ):

			case $case == 'general_settings':
				 require_once 'backend/settings.php';
			break;

			case $case == 'currencies':
				 require_once 'backend/currencies.php';
			break;

			case $case == 'validation':
				 require_once 'backend/validation.php';
			break;

			default: require_once 'backend/settings.php';

		endswitch; ?>

		<script type="text/javascript">
		jQuery(document).ready(function($){
			$('.chosen-select').chosen();
		});
		</script>

	</div>

<?php }

/**
 * Upgrade to Premium Callback
 *
 * @since 0.9
 */
function pixad_autos_upgrade_callback() {
	require_once 'backend/upgrade.php';
}

/**
 * Create Selectable Options With Applied Number Range
 *
 * @since 0.1
 */
function pixad_get_options_range( $from, $to, $selected, $step=1 ) {
	$numbers = range( $from, $to, $step );
	
	foreach( $numbers as $number ) {
		if( $number == $selected ) {
			echo '<option value="'.$number.'" selected>'.$number.'</option>';
		}else{
			echo '<option value="'.$number.'">'.$number.'</option>';
		}
		
	}
}


function soj_manage_posts_by_role(){
    global $user_ID;
    if(isset($_GET['post_type']) && $_GET['post_type'] == 'pixad-autos'){


        $content = '';
        $content .= '<select name="role" class="pixad-autos-role-filter">';
        $content .= '<option value="all">All Roles</option>';
        $content .= '<option value="administrator">Administrator</option>';
        $content .= '<option value="autodealer">Autodealer</option>';
        $content .= '</select>';
        echo($content);

    }
}
add_action('restrict_manage_posts', 'soj_manage_posts_by_role');


function soj_manage_posts_by_author(){
    global $user_ID;
    if(isset($_GET['post_type']) && $_GET['post_type'] == 'pixad-autos'){
        $params = array(
            'name' => 'author',
            'show_option_all' => 'All authors',
            'role__in' => array('administrator', 'autodealer')
        );

        if ( isset($_GET['user']) )
            $params['selected'] = $_GET['user']; // choose selected user by $_GET variable

        wp_dropdown_users( $params );
    }
}
add_action('restrict_manage_posts', 'soj_manage_posts_by_author');

function soj_manage_posts_by_tax(){
    if(isset($_GET['post_type']) && $_GET['post_type'] == 'pixad-autos'){
        global $typenow;
        global $wp_query;

        $content = '';
        $content .= '<select name="purpose" class="pixad-autos-purpose-filter">';
        $content .= '<option value="all">All Purpose</option>';
        $content .= '<option value="sell">Sell</option>';
        $content .= '<option value="sold">Sold</option>';
        $content .= '<option value="rent">Rent</option>';
        $content .= '</select>';
        echo($content);
    }
}
add_action('restrict_manage_posts', 'soj_manage_posts_by_tax');

function wisdom_sort_plugins_by_slug( $query ) {
    global $pagenow;
    // Get the post type
    if(isset($_GET['post_type']) && $_GET['post_type'] == 'pixad-autos'){
        if(isset($_GET['purpose']) && $_GET['purpose'] != ''){
            if($_GET['purpose'] != 'all'){
                $query->query_vars['meta_key'] = '_auto_purpose';
                $query->query_vars['meta_value'] = $_GET['purpose'];
                $query->query_vars['meta_compare'] = 'LIKE';
            }
        }
    }

    if(isset($_GET['post_type']) && $_GET['post_type'] == 'pixad-autos'){
        if(isset($_GET['role']) && $_GET['role'] != ''){
            if($_GET['role'] != 'all'){
                $ids = '';
                $user_meta = get_users(['role__in'     => array($_GET['role'])]);
                foreach ($user_meta as $user){
                    $ids .= $user->ID;
                }
                $query->query_vars['author'] = $ids;
            }
        }
    }
}
add_filter( 'parse_query', 'wisdom_sort_plugins_by_slug' );
add_theme_support('post-thumbnails');