<?php
function autozone_site_menu($class = null) {
    if (function_exists('wp_nav_menu')) {
        wp_nav_menu(array(
            'theme_location' => 'primary_nav',
            'container' => false,
            'menu_class' => $class,
            'walker' => new AutoZone_Walker_Menu(),
        ));
    }
}

function autozone_show_breadcrumbs(){
    if ( class_exists( 'WooCommerce' ) && !is_page_template( 'page-home.php' ) && !is_singular( 'pixad-autos' ) ) woocommerce_breadcrumb();
    if ( is_singular( 'pixad-autos' )) echo autozone_pixad_autos_breadcrumbs();
}

function autozone_pixad_autos_breadcrumbs()
{
    $Settings   = new PIXAD_Settings();
    $settings   = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );

    $home_link        = home_url('/');
    $home_text        = __( 'Home', 'autozone' );
    $vehicle_listings_text = get_the_title($settings['autos_listing_car_page']);
    $vehicle_listings_link = get_permalink($settings['autos_listing_car_page']);
    $delimiter        = ' / ';
    $before           = '<span class="current">';
    $after            = '</span>';

    $wp_the_query   = $GLOBALS['wp_the_query'];
    $queried_object = $wp_the_query->get_queried_object();

    if ( is_singular() )
    {
        $post_object = sanitize_post( $queried_object );
        $title          = apply_filters( 'the_title', $post_object->post_title );
        $post_id        = $post_object->ID;
        $post_link      = $before . $title . $after;

        $make_term_name = '';
        $make_term_link = '';
        $make_terms = get_the_terms( $post_id, 'auto-model' );
        if (!empty($make_terms)) {
            foreach( $make_terms as $make_term) {
                if($make_term->parent == 0){
                    $make_term_name = $make_term->name;
                    $make_term_link = $vehicle_listings_link.'?make='.$make_term->slug;
                    $make_term_id = $make_term->term_id;
                }
            }
        }
        $model_term_name = '';
        $model_term_link = '';
        $model_terms = get_the_terms( $post_id, 'auto-model' );
        if (!empty($model_terms)) {
            foreach( $model_terms as $model_term) {
                if(isset($make_term_id) && $make_term_id != ''){
                    if($model_term->parent == $make_term_id){
                        $model_term_name = $model_term->name;
                        $model_term_link = $make_term_link.'&model='.$model_term->slug;
                    }
                }
            }
        }
    }
    $breadcrumb_output_link  = '';
    $breadcrumb_output_link .= '<div class="breadcrumb woocommerce-breadcrumb">';

    $breadcrumb_output_link .= '<a href="' . $home_link . '">' . $home_text . '</a>';
    $breadcrumb_output_link .= $delimiter;
    $breadcrumb_output_link .= '<a href="' . $vehicle_listings_link . '">' . $vehicle_listings_text . '</a>';
    $breadcrumb_output_link .= $delimiter;
    if($make_term_name != ''){
        $breadcrumb_output_link .= '<a href="' . $make_term_link . '">' . $make_term_name . '</a>';
        $breadcrumb_output_link .= $delimiter;
    }
    if($model_term_name != ''){
        $breadcrumb_output_link .= '<a href="' . $model_term_link . '">' . $model_term_name . '</a>';
        $breadcrumb_output_link .= $delimiter;
    }

    $breadcrumb_output_link .= $post_link;

    $breadcrumb_output_link .= '</div><!-- .breadcrumbs -->';
    return $breadcrumb_output_link;
}

function autozone_wp_get_attachment( $attachment_id ) {
    $attachment = get_post( $attachment_id );

    return array(
        'alt' => is_object($attachment) ? get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ) : '',
        'caption' => is_object($attachment) ? $attachment->post_excerpt : '',
        'description' => is_object($attachment) ? $attachment->post_content : '',
        'href' => is_object($attachment) ? get_permalink( $attachment->ID ) : '',
        'src' => is_object($attachment) ? $attachment->guid : '',
        'title' => is_object($attachment) ? $attachment->post_title : ''
    );
}

function autozone_post_read_more(){
    $btn_name = autozone_get_option('blog_settings_readmore');
    $name = ($btn_name) ? $btn_name : esc_html__('Read More','autozone');
    return esc_attr($name);
}

function autozone_limit_words($string, $word_limit) {

    // creates an array of words from $string (this will be our excerpt)
    // explode divides the excerpt up by using a space character

    $words = explode(' ', $string);

    // this next bit chops the $words array and sticks it back together
    // starting at the first word '0' and ending at the $word_limit
    // the $word_limit which is passed in the function will be the number
    // of words we want to use
    // implode glues the chopped up array back together using a space character
    if($string == "")
        return '';
    else
        return implode(' ', array_slice($words, 0, $word_limit)).'...';
}

function autozone_show_sidebar($type, $custom, $is_autos = 0, $sidebar = 'sidebar-1'){
    global $wp_query;

    $layout = 2;
    $layouts = array(
        1 => 'full',
        2 => 'right',
        3 => 'left',
    );

    if (is_array($custom) && isset($custom['pix_selected_sidebar'])) {
        $sidebar = isset ($custom['pix_selected_sidebar'][0]) ? $custom['pix_selected_sidebar'][0] : $sidebar;
        $layout = isset ($custom['pix_page_layout']) ? $custom['pix_page_layout'][0] : '2';
    }

    if (!is_active_sidebar($sidebar)) $layout = '1';

    if (isset($layouts[$layout]) && $type === $layouts[$layout]) {
        echo (is_search() || $is_autos ? '<div class="sidebar-wrapper col-md-3 sticky-bar"><aside class="sidebar ">' : '<div class="sidebar-wrapper col-md-4"><aside class="sidebar">');
        if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($sidebar)) {
        }
        echo '</aside></div>';
    }else{
        echo '';
    }

}

/**
 * Filter whether comments are open for a given post type.
 *
 * @param string $status       Default status for the given post type,
 *                             either 'open' or 'closed'.
 * @param string $post_type    Post type. Default is `post`.
 * @param string $comment_type Type of comment. Default is `comment`.
 * @return string (Maybe) filtered default status for the given post type.
 */
function autozone_open_comments_for_page( $status, $post_type, $comment_type ) {
    if ( 'page' === $post_type ) {
        return 'open';
    }
    // You could be more specific here for different comment types if desired
    return $status;
}
add_filter( 'get_default_comment_status', 'autozone_open_comments_for_page', 10, 3 );


function autozone_hex2rgb($hex) {
    $hex = str_replace("#", "", $hex);

    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
    }
    $rgb = array($r, $g, $b);
//return $rgb; // returns an array with the rgb values
    return implode(",", $rgb); // returns the rgb values separated by commas
}

// Show admin notice
if ( !function_exists( 'pix_admin_notice' ) ) {
    function pix_admin_notice() {
        $message  = "<p>" . esc_html__("Attention! Please activate your theme first to install all additional plugins and demo content. ", "autozone") . "</p>";
        if(pixtheme_check_is_activated()){
            $message  = "<p>" . esc_html__("Thank you for purchasing our theme. If you have any problems please use our support forum .", "autozone") . "</p>";
        }
        add_option('pix_admin_notice', '1');
        $screen = get_current_screen();
        if ( $screen->id != 'appearance_page_adminpanel' ) {
            if ( get_option('pix_admin_notice') ) {
                echo "
                    <div class='update-nag' id='pix_admin_notice'>
                        <h3 class='pix_notice_title'>" . esc_html__("Welcome to autozone", "autozone") . "</h3>" .
                    $message .
                    "<p>
                            <a href='" . admin_url('themes.php?page=adminpanel') . "' class='button button-primary'><i class='dashicons dashicons-nametag'></i>" . esc_html__("Read more", "autozone") . "</a>
                            <a href='#' class='button pix_hide_notice'><i class='dashicons dashicons-dismiss'></i> " . esc_html__("Hide notice", "autozone") . "</a>
                        </p>
                    </div>
                ";
            }
        }
    }
}
if (current_user_can('switch_themes')) {
    add_action('admin_notices', 'pix_admin_notice', 2);
}

// Hide admin notice
if ( !function_exists( 'pix_callback_hide_admin_notice' ) ) {
    function pix_callback_hide_admin_notice() {
        update_option('pix_admin_notice', '0');
        exit;
    }
}
add_action('wp_ajax_pix_hide_admin_notice', 'pix_callback_hide_admin_notice');

// Update admin notice status
if ( !function_exists( 'pix_admin_notice_update' ) ) {
    function pix_admin_notice_update() {
        update_option('pix_admin_notice', '1');
    }
}
add_action('after_switch_theme', 'pix_admin_notice_update');




// display theme update notice





$allow_url_fopen = ini_get('allow_url_fopen');
if ($allow_url_fopen != 1 ) {
    function autozone_update_notice_error(){ ?>
        <div class="notice notice-error is-dismissible ">
            <h2><?php _e('Theme updates ERROR', 'autozone'); ?></h2>
            <p><?php _e('You need to enable "allow_url_fopen" on your server. Contact to your hosting provider', 'autozone'); ?></p>
        </div>
    <?php }
    add_action('admin_notices', 'autozone_update_notice_error');
} else {

    function get_new_theme_version() {
        /*
        $ctx = stream_context_create(array('http'=>
            array(
                'timeout' => 1,
            )
        ));

        $str  =  file_get_contents('http://assets.templines.com/plugins/theme/autozone/theme.json', false, $ctx);




           $data = json_decode($str, true);
           $newThemeVersion = $data['version'];
        */

        $newThemeVersion = '4.0.4';

        return $newThemeVersion;

    }
    function get_current_theme_version(){
        $newThemeVersion = get_new_theme_version();
        $my_theme = wp_get_theme();

        if ($my_theme->parent() == false) {
            $currentThemeVersion = $my_theme->get( 'Version' );

        } else { // Child Theme
            $childTheme = $my_theme->parent();
            $currentThemeVersion = $childTheme['Version'];

        }

        return  $currentThemeVersion;
    }

    $newThemeVersion = get_new_theme_version();
    $currentThemeVersion = get_current_theme_version();

    $newThemeVersion = str_replace('.', '', $newThemeVersion);
    $currentThemeVersion  = str_replace('.', '', $currentThemeVersion );

    function autozone_update_notice() { ?>
        <?php
        $newThemeVersion = get_new_theme_version();
        $currentThemeVersion =get_current_theme_version();

        $envatoCode = get_theme_mod('pixtheme_licence_settings_code') ? get_theme_mod('pixtheme_licence_settings_code') : '' ;
        $option_name = 'pixtheme_licence_is_activated';
        $option_name_code = 'pixtheme_licence_code';

        ?>
        <div class="notice notice-info is-dismissible update-nag">
            <h2><?php _e('Theme updates ', 'autozone'); ?></h2>
            <p><?php _e('New version available.', 'autozone'); ?></p>


            <?php
            $html_button_out = "Unfortunately, your support period is expired but you can renew your support on market .";
            if ($envatoCode){
                if ( get_option( $option_name ) != false ){
                    if (get_option( $option_name_code ) == $envatoCode){
                        $expiredTime = strtotime(get_option( $option_name ));
                        if ($expiredTime > time()){
                            $html_button_out = "<a class='button button-primary' href='themes.php?theme=autozone'>" . esc_html__("Update Theme", "autozone") . "</a>";
                        }
                    }
                }
            }

            echo esc_html($html_button_out);
            ?>

        </div>

    <?php }

    if ($newThemeVersion  > $currentThemeVersion  ) {
        add_action('admin_notices', 'autozone_update_notice');
    }

}


/************************ add update car [Pages] ********************/
function autozone_auto_upload($front_auth = false) {

    $cur_user_id = get_current_user_id();
    if (  isset($_REQUEST['submit']) && isset( $_REQUEST['seller_auto_upload_nonce'] ) && $cur_user_id && ( !empty($front_auth) || wp_verify_nonce( $_REQUEST['seller_auto_upload_nonce'], 'seller_auto_upload' ))){

        $Settings   = new PIXAD_Settings();
        $options    = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
        $status =   isset( $options['autos_status_publiс'] ) ? $options['autos_status_publiс'] : '';
        $status =   !empty( $status ) ? $status: 'pending';
        $autos_demo_mode =   isset( $options['autos_demo_mode'] ) ? $options['autos_demo_mode'] : '';

        $auto_title = sanitize_text_field($_REQUEST['auto-post-title']);
        $auto_description = wp_kses_post($_REQUEST['content']);


        $new_post = array(
            'ID'            => '',
            'post_type'     => 'pixad-autos',
            'post_title'    => $auto_title,
            'post_content'  => $auto_description,
            'post_status'   => $status,
            'post_author'   => $cur_user_id
        );

        $post_id = wp_insert_post($new_post);

        // This will redirect you to the newly created post
        $post = get_post($post_id);
        if ($post_id) {

            if($_REQUEST['auto-make'] != ''){
                $am_term = get_term_by('slug', $_REQUEST['auto-make'], 'auto-model');
                $am_term_parent_id = $am_term->parent;
                if ($am_term_parent_id) {
                    wp_set_object_terms( $post_id, array($_REQUEST['auto-make'], $am_term_parent_id), 'auto-model', false );
                } else {
                    wp_set_object_terms( $post_id, $_REQUEST['auto-make'], 'auto-model', false );
                }
            }

            if(!empty($_REQUEST['auto-body'])){
                wp_set_object_terms( $post_id, $_REQUEST['auto-body'], 'auto-body', false );
            }

            if(!empty($_REQUEST['auto-equipment'])){
                wp_set_object_terms( $post_id, $_REQUEST['auto-equipment'], 'auto-equipment', false );
            }

            $encode_gallery = '';
            if(empty($autos_demo_mode)){
                if (isset($_REQUEST['pixad_auto_gallery_ids']) && $_REQUEST['pixad_auto_gallery_ids'] != '') {
                    $encode_gallery = json_encode(explode(',',$_REQUEST['pixad_auto_gallery_ids']));
                }
            }


            $encode_video = '';
            if (isset($_REQUEST['auto_video_code']) && $_REQUEST['auto_video_code'] != '') {
                $encode_video =  json_encode($_REQUEST['auto_video_code']);
            }

            $options = array(
                '_auto_year'      => sanitize_text_field( $_REQUEST['auto-year'] ),
                '_auto_doors'      => sanitize_text_field( $_REQUEST['auto-doors'] ),
                '_auto_version'      => sanitize_text_field( $_REQUEST['auto-version'] ),
                '_auto_transmission'  => sanitize_text_field( $_REQUEST['auto-transmission'] ),
                '_auto_fuel'      => sanitize_text_field( $_REQUEST['auto-fuel'] ),
                '_auto_price'     => sanitize_text_field( $_REQUEST['auto-price'] ),
                '_auto_mileage'     => sanitize_text_field( $_REQUEST['auto-mileage'] ),
                '_auto_engine'      => sanitize_text_field( $_REQUEST['auto-engine'] ),
                '_auto_warranty'      => sanitize_text_field( $_REQUEST['auto-warranty'] ),
                '_auto_vin'      => sanitize_text_field( $_REQUEST['auto-vin'] ),
                '_auto_horsepower'      => sanitize_text_field( $_REQUEST['auto-horsepower'] ),
                '_auto_seats'      => sanitize_text_field( $_REQUEST['auto-seats'] ),
                '_auto_condition'      => sanitize_text_field( $_REQUEST['auto-condition'] ),
                '_auto_purpose'      => sanitize_text_field( $_REQUEST['auto-purpose'] ),
                '_auto_drive'      => sanitize_text_field( $_REQUEST['auto-drive'] ),
                '_auto_color'      => sanitize_text_field( $_REQUEST['auto-color'] ),
                '_auto-_color_int'      => sanitize_text_field( $_REQUEST['auto-color-int'] ),
                '_seller_first_name'  => sanitize_text_field( $_REQUEST['seller-first-name'] ),
                '_seller_last_name'  => sanitize_text_field( $_REQUEST['seller-last-name'] ),
                '_seller_state'  => sanitize_text_field( $_REQUEST['seller-state'] ),
                '_seller_company'  => sanitize_text_field( $_REQUEST['seller-company'] ),
                '_seller_town'  => sanitize_text_field( $_REQUEST['seller-town'] ),
                '_seller_country'  => sanitize_text_field( $_REQUEST['seller-country'] ),
                '_seller_email'     => sanitize_text_field( $_REQUEST['seller-email'] ),
                '_seller_phone'     => sanitize_text_field( $_REQUEST['seller-phone'] ),
                '_seller_location'      => sanitize_text_field( $_REQUEST['seller-location'] ),
                '_seller_location_lat'  => sanitize_text_field( $_REQUEST['seller-location-lat'] ),
                '_seller_location_long' => sanitize_text_field( $_REQUEST['seller-location-long'] ),
                '_auto_video_code'      => sanitize_text_field( $encode_video ),
                '_thumbnail_id'      => sanitize_text_field( $_REQUEST['_thumbnail_id']),
                'pixad_auto_gallery_video' => sanitize_text_field( $_REQUEST['pixad_auto_gallery_video'] ),
                'pixad_auto_gallery' => sanitize_text_field( $encode_gallery ),
            );
            for ($i=1; $i <= 80; $i++) {
                $options['_custom_'.$i] = sanitize_text_field( $_REQUEST['custom_'.$i] );
            }

            foreach( $options as $key => $value ) {
                update_post_meta( $post_id, $key, $value );
            }

            require_once(ABSPATH . "wp-admin" . '/includes/image.php');
            require_once(ABSPATH . "wp-admin" . '/includes/file.php');
            require_once(ABSPATH . "wp-admin" . '/includes/media.php');

            $attachment_id = media_handle_upload('_thumbnail_id', $post_id);

            if ( is_wp_error( $attachment_id ) ) {
                esc_html_e('Error loading media file.', 'autozone');
            } else {
                set_post_thumbnail( $post_id, $attachment_id );
            }
            $save_data = $_FILES;
            $gallery_attachments = array();

            if(empty($autos_demo_mode)){
                if ( $_FILES['gallery_images'] ) {
                    $files = $_FILES['gallery_images'];
                    foreach ($files['name'] as $key => $value) {
                        if ($files['name'][$key]) {
                            $file = array(
                                'name' => $files['name'][$key],
                                'type' => $files['type'][$key],
                                'tmp_name' => $files['tmp_name'][$key],
                                'error' => $files['error'][$key],
                                'size' => $files['size'][$key]
                            );
                            $_FILES = array ('gallery_images' => $file);
                            foreach ($_FILES as $file => $array) {
                                $gallery_attachments[] = autozone_handle_attachment($file, $post_id);
                            }
                        }
                    }
                }
                if(!empty($gallery_attachments)) {
                    $encode = json_encode($gallery_attachments);
                    update_post_meta($post_id, 'pixad_auto_gallery', $encode);
                }


                if (!empty( $_FILES['files-image'] )) {
                    $files = $_FILES['files-image'];
                    foreach ($files['name'] as $key => $value) {
                        if ($files['name'][$key]) {
                            $file = array(
                                'name' => $files['name'][$key],
                                'type' => $files['type'][$key],
                                'tmp_name' => $files['tmp_name'][$key],
                                'error' => $files['error'][$key],
                                'size' => $files['size'][$key]
                            );

                            $gallery_attachments[] = media_handle_sideload($file, $post_id);
                        }
                    }

                    if (!empty($gallery_attachments)) {
                        $front_encode_gallery =  json_encode($gallery_attachments);
                        update_post_meta( $post_id, 'pixad_auto_gallery', sanitize_text_field( $front_encode_gallery) );
                    }
                }
            }




            $_FILES = $save_data;
            $id_video = '';
            if ( $_FILES['gallery_video'] ) {
                $files = $_FILES['gallery_video'];
                foreach ($files['name'] as $key => $value) {
                    if ($files['name'][$key]) {
                        $file = array(
                            'name' => $files['name'][$key],
                            'type' => $files['type'][$key],
                            'tmp_name' => $files['tmp_name'][$key],
                            'error' => $files['error'][$key],
                            'size' => $files['size'][$key]
                        );
                        $_FILES = array ('gallery_video' => $file);
                        foreach ($_FILES as $file => $array) {
                            $id = (int)autozone_handle_attachment($file, $post_id);
                            $id_video .= $id . ',';
                        }
                    }
                }

            }
            if(!empty($id_video)) {
                update_post_meta($post_id, 'pixad_auto_gallery_video', $id_video);
            }
            $Settings   = new PIXAD_Settings();
            $options    = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
            autozone_add_car_notice_admin($post_id);
            $auto_listing_page = isset($options['autos_listing_car_page']) ? $options['autos_listing_car_page'] : false;
            if(!empty($auto_listing_page)){
                wp_redirect(get_permalink($auto_listing_page) . '?add=ok');
            }else{
                wp_redirect('car-waiting-for-review');
            }

             autozone_email_add_auto();


        } else {
            wp_redirect($_REQUEST['_wp_http_referer']);
        }

    }
}
add_action( 'admin_post_auto_upload_form', 'autozone_auto_upload' );
add_action( 'template_redirect','autozone_upload_form_front' );

function autozone_27856_set_content_type(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','autozone_27856_set_content_type' );

function autozone_upload_form_front()
{
    global $post;
    if(is_admin()) return;
    if(!class_exists('PIXAD_Settings')) return;
    if(!isset($_POST['action']) || $_POST['action'] !== 'auto_upload_form_front') return;

    $Settings   = new PIXAD_Settings();
    $options    = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
    if(empty($options['autos_reg_user'])) return;

    $cur_user_id = get_current_user_id();
    if(empty($cur_user_id) && !empty($options['autos_reg_user'])){
        $user_id = autozone_craate_new_user();
        if(!empty($user_id)){
            $user = get_user_by( 'id', $user_id );
            wp_set_current_user( $user_id, $user->user_login );
            wp_set_auth_cookie( $user_id );
            add_action('wp_head', 'autozone_upload_form_front1234');
        }
    }
}
function autozone_upload_form_front1234(){
    autozone_auto_upload(true);
}
function autozone_get_empty_email_username( $rand = 0){
    $user_data = [];
    $Settings   = new PIXAD_Settings();
    $options    = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
    $finish_url_part = '@test.test';
    if(!empty($options['autos_email_domain'])){
        $finish_url_part = '@'.$options['autos_email_domain'];
    }
    if($rand){
        $number = wp_rand( 9999, 999999 );
        $username = 'dealer'.$number;
        $email =  $username.$finish_url_part;
        $user_data = ['email' => $email, 'username' => $username];
    }else{
        $cu = count_users();
        $username = 'dealer'.$cu['total_users'];
        $email =  $username.$finish_url_part;
        $user_data = ['email' => $email, 'username' => $username];
    }
    if( email_exists($user_data['email']) || username_exists( $user_data['username'] )){
        $user_data = autozone_get_empty_email_username(1);
    }
    return $user_data;
}
function autozone_craate_new_user()
{
    $user_data = autozone_get_empty_email_username();
    $user_login = $user_data['username'];
    $user_email = $user_data['email'];
    $password = wp_generate_password( 12 );

    $userdata = array(
        'user_login' => $user_login,
        'user_pass'  => $password,
        'user_email' => $user_email,
        'nickname'   => $user_login,
        'first_name'   => $user_login,
        'role'       => 'autodealer',
    );

    return wp_insert_user( $userdata ) ;
}

function autozone_auto_update() {

    $cur_user_id = get_current_user_id();


    if (  isset($_REQUEST['submit']) && isset( $_REQUEST['seller_auto_upload_nonce'] ) && wp_verify_nonce( $_REQUEST['seller_auto_upload_nonce'], 'seller_auto_upload' ) && $cur_user_id ){


        $auto_description = wp_kses_post($_REQUEST['auto-description']);

        $post_id = sanitize_text_field($_REQUEST['auto_id']);

        // This will redirect you to the newly created post
        $post = get_post($post_id);
        if ($post_id) {

            if($_REQUEST['auto-make'] != ''){
                wp_set_object_terms( $post_id, $_REQUEST['auto-make'], 'auto-model', false );
            }

            if(!empty($_REQUEST['auto-body'])){
                wp_set_object_terms( $post_id, $_REQUEST['auto-body'], 'auto-body', false );
            }

            if(!empty($_REQUEST['auto-equipment'])){
                wp_set_object_terms( $post_id, $_REQUEST['auto-equipment'], 'auto-equipment', false );
            }
            $encode_gallery = '';
            if (isset($_REQUEST['pixad_auto_gallery_ids']) && $_REQUEST['pixad_auto_gallery_ids'] != '') {
                $encode_gallery =  json_encode(explode(',',$_REQUEST['pixad_auto_gallery_ids']));
            }
            $encode_video = '';
            if (isset($_REQUEST['auto_video_code']) && $_REQUEST['auto_video_code'] != '') {
                $encode_video =  json_encode($_REQUEST['auto_video_code']);
            }
            if ((isset($_REQUEST['content']) || isset($_REQUEST['auto-post-title'])) && $_REQUEST['auto-post-title'] !== '') {
                $new_post = array();
                $new_post['ID'] = $post_id;
                $new_post['post_title'] = sanitize_text_field($_REQUEST['auto-post-title']);
                $new_post['post_content'] = sanitize_text_field( $_REQUEST['content']);
                wp_update_post( wp_slash($new_post) );
            }



            $options = array(
                '_auto_year'      => sanitize_text_field( $_REQUEST['auto-year'] ),
                '_auto_doors'      => sanitize_text_field( $_REQUEST['auto-doors'] ),
                '_auto_version'      => sanitize_text_field( $_REQUEST['auto-version'] ),
                '_auto_transmission'  => sanitize_text_field( $_REQUEST['auto-transmission'] ),
                '_auto_fuel'      => sanitize_text_field( $_REQUEST['auto-fuel'] ),
                '_auto_price'     => sanitize_text_field( $_REQUEST['auto-price'] ),
                '_auto_mileage'     => sanitize_text_field( $_REQUEST['auto-mileage'] ),
                '_auto_engine'      => sanitize_text_field( $_REQUEST['auto-engine'] ),
                '_auto_warranty'      => sanitize_text_field( $_REQUEST['auto-warranty'] ),
                '_auto_vin'      => sanitize_text_field( $_REQUEST['auto-vin'] ),
                '_auto_horsepower'      => sanitize_text_field( $_REQUEST['auto-horsepower'] ),
                '_auto_seats'      => sanitize_text_field( $_REQUEST['auto-seats'] ),
                '_auto_condition'      => sanitize_text_field( $_REQUEST['auto-condition'] ),
                '_auto_purpose'      => sanitize_text_field( $_REQUEST['auto-purpose'] ),
                '_auto_drive'      => sanitize_text_field( $_REQUEST['auto-drive'] ),
                '_auto_color'      => sanitize_text_field( $_REQUEST['auto-color'] ),
                '_auto-_color_int'      => sanitize_text_field( $_REQUEST['auto-color-int'] ),
                '_seller_first_name'  => sanitize_text_field( $_REQUEST['seller-first-name'] ),
                '_seller_last_name'  => sanitize_text_field( $_REQUEST['seller-last-name'] ),
                '_seller_state'  => sanitize_text_field( $_REQUEST['seller-state'] ),
                '_seller_company'  => sanitize_text_field( $_REQUEST['seller-company'] ),
                '_seller_town'  => sanitize_text_field( $_REQUEST['seller-town'] ),
                '_seller_country'  => sanitize_text_field( $_REQUEST['seller-country'] ),
                '_seller_email'     => sanitize_text_field( $_REQUEST['seller-email'] ),
                '_seller_phone'     => sanitize_text_field( $_REQUEST['seller-phone'] ),
                '_seller_location'      => sanitize_text_field( $_REQUEST['seller-location'] ),
                '_seller_location_lat'  => sanitize_text_field( $_REQUEST['seller-location-lat'] ),
                '_seller_location_long' => sanitize_text_field( $_REQUEST['seller-location-long'] ),
                '_auto_video_code'      => sanitize_text_field( $encode_video ),
                '_thumbnail_id'      => sanitize_text_field( $_REQUEST['_thumbnail_id']),
                'pixad_auto_gallery_video' => sanitize_text_field( $_REQUEST['pixad_auto_gallery_video'] ),
                'pixad_auto_gallery' => sanitize_text_field( $encode_gallery ),
            );
            for ($i=1; $i <= 80; $i++) {
                $options['_custom_'.$i] = sanitize_text_field( $_REQUEST['custom_'.$i] );
            }
            foreach( $options as $key => $value ) {
                update_post_meta( $post_id, $key, $value );
            }

            require_once(ABSPATH . "wp-admin" . '/includes/image.php');
            require_once(ABSPATH . "wp-admin" . '/includes/file.php');
            require_once(ABSPATH . "wp-admin" . '/includes/media.php');

            $attachment_id = media_handle_upload('auto-image', $post_id);

            if ( is_wp_error( $attachment_id ) ) {
                esc_html_e('Error loading media file.', 'autozone');
            } else {
                set_post_thumbnail( $post_id, $attachment_id );
            }

            $gallery_attachments = array();
            if ( $_FILES['gallery_images'] ) {
                $files = $_FILES['gallery_images'];
                foreach ($files['name'] as $key => $value) {
                    if ($files['name'][$key]) {
                        $file = array(
                            'name' => $files['name'][$key],
                            'type' => $files['type'][$key],
                            'tmp_name' => $files['tmp_name'][$key],
                            'error' => $files['error'][$key],
                            'size' => $files['size'][$key]
                        );
                        $_FILES = array ('gallery_images' => $file);
                        foreach ($_FILES as $file => $array) {
                            $gallery_attachments[] = autozone_handle_attachment($file, $post_id);
                        }
                    }
                }

            }

            if(!empty($gallery_attachments)) {
                $encode = json_encode($gallery_attachments);
                update_post_meta($post_id, 'pixad_auto_gallery', $encode);
            }

            wp_redirect($_REQUEST['_wp_http_referer']);
        } else {
            wp_redirect($_REQUEST['_wp_http_referer']);
        }

    }
}
add_action( 'admin_post_auto_update_form', 'autozone_auto_update' );

function autozone_ASCSort($f1,$f2){
    if($f1->name < $f2->name) return -1;
    elseif($f1->name > $f2->name) return 1;
    else return 0;
}

function autozone_handle_attachment($file_handler, $post_id, $set_thu=false) {
    // check to make sure its a successful upload
    if ($_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK) __return_false();

    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');

    $attach_id = media_handle_upload( $file_handler, $post_id );

    return $attach_id;
}


function autozone_get_image_id($image_url) {
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ));
    return isset($attachment[0]) ? $attachment[0] : '';
}


//filters pages
add_filter( 'display_post_states', 'autozone_add_display_post_states', 15, 2 );
add_filter( 'theme_page_templates', 'autozone_hide_cpt_archive_templates' , 15, 3 );
add_filter( 'template_include', 'autozone_template_loader' );

function autozone_add_display_post_states( $post_states, $post ) {
    if(class_exists('PIXAD_Settings')){
        $Settings   = new PIXAD_Settings();
        $options    = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );

        $auto_sell_page = isset($options['autos_sell_car_page']) ? $options['autos_sell_car_page'] : false;
        $auto_listing_page = isset($options['autos_listing_car_page']) ? $options['autos_listing_car_page'] : false;
        $auto_update_page = isset($options['autos_update_car_page']) ? $options['autos_update_car_page'] : false;
        $auto_my_page = isset($options['autos_my_cars_page']) ? $options['autos_my_cars_page'] : false;

        if ($post->ID == $auto_sell_page){
            $post_states['wc_page_for_shop'] = __( 'Sell Your Car Page', 'autozone' );
        }elseif($post->ID == $auto_listing_page){
            $post_states['wc_page_for_shop'] = __( 'Listing Car Page', 'autozone' );
        }elseif($post->ID == $auto_update_page){
            $post_states['wc_page_for_shop'] = __( 'Car Update Page', 'autozone' );
        }elseif($post->ID == $auto_my_page){
            $post_states['wc_page_for_shop'] = __( 'My Cars Page', 'autozone' );
        }
    }

    return $post_states;
}

function autozone_hide_cpt_archive_templates( $page_templates, $theme, $post ) {
    if(class_exists('PIXAD_Settings')){
        $Settings   = new PIXAD_Settings();
        $options    = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );

        $auto_sell_page = isset($options['autos_sell_car_page']) ? $options['autos_sell_car_page'] : false;
        $auto_listing_page = isset($options['autos_listing_car_page']) ? $options['autos_listing_car_page'] : false;
        $auto_update_page = isset($options['autos_update_car_page']) ? $options['autos_update_car_page'] : false;
        $auto_my_page = isset($options['autos_my_cars_page']) ? $options['autos_my_cars_page'] : false;

        if ( $post && (int)$auto_sell_page === absint( $post->ID ) ) {
            $page_templates = array();
        }elseif($post && (int)$auto_listing_page === absint( $post->ID )){
            $page_templates = array();
        }elseif($post && (int)$auto_update_page === absint( $post->ID )){
            $page_templates = array();
        }elseif($post && (int)$auto_my_page === absint( $post->ID )){
            $page_templates = array();
        }
    }
    return $page_templates;
}


function autozone_template_loader( $template ) {
    if(class_exists('PIXAD_Settings')){
        $Settings   = new PIXAD_Settings();
        $options    = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );

        $auto_sell_page = isset($options['autos_sell_car_page']) ? $options['autos_sell_car_page'] : false;
        $auto_listing_page = isset($options['autos_listing_car_page']) ? $options['autos_listing_car_page'] : false;
        $auto_update_page = isset($options['autos_update_car_page']) ? $options['autos_update_car_page'] : false;
        $auto_my_page = isset($options['autos_my_cars_page']) ? $options['autos_my_cars_page'] : false;

        $object = get_queried_object();

        if ( is_embed() ) {
            return $template;
        }

        if(!empty($object) && !empty($object->ID) ){
            if ($object->ID == (int)$auto_sell_page){
                $template = locate_template('auto-load.php');
            }elseif($object->ID == (int)$auto_update_page){
                $template = locate_template('auto-update.php');
            }elseif($object->ID == (int)$auto_listing_page){
                $template = locate_template('autos.php');
            }elseif($object->ID == (int)$auto_my_page){
                $template = locate_template('autos-user.php');
            }
        }

    }
    return $template;
}
// добавить поле, инфо добавления авто
function autozone_add_car_notice_admin($auto_id){
    $id = (int)$auto_id;
    $notice_admin_auto = get_option('notice_admin_auto');
    $notices = explode(',', $notice_admin_auto);
    if(!empty($id) && !in_array($id, $notices)){
        $str = '';
        if(!empty(get_option('notice_admin_auto'))){
            $str = get_option('notice_admin_auto');
        }
        $str .= $id . ',';
        update_option('notice_admin_auto', $str);
    }
}
// предупредить админа о создании нового авто
add_action('admin_notices', function(){

    $str_ids = get_option('notice_admin_auto');
    $html = '';
    $url  = [];
    $new_ids = [];
    $str_new_ids = '';
    if(!empty($str_ids)){
        $ids = explode(',', $str_ids);
        if(!empty($ids)){
            foreach( $ids as $id ){
                $cur_id = (int) $id;
                if(!empty($cur_id)){
                    $post = get_post($cur_id);
                    if($post->post_status === 'pending'){
                        $new_ids[] = $cur_id;
                        $html .= '<li class="notice-admin-pending">'.esc_html(get_the_author_meta('user_nicename', $post->post_author)).' added new car: <a href="'.get_permalink($cur_id).'">'.$post->post_title.'</li></a>';
                    }
                }
            }
        }
    }
    if(!empty($new_ids)){
        foreach ($new_ids as  $id) {
            $str_new_ids .=  $id . ',';
        }
    }
    update_option('notice_admin_auto', $str_new_ids);
    if(!empty($html)){
        echo '<div class="update-nag"><p>'.esc_attr__('The post waiting for the approval of the administrator', 'autozone').'.</p><ul>'.$html.'</ul></div>';
    }

});
add_action( 'wp_insert_post', 'autozone_insert_car_notice_admin', 10, 3 );
function autozone_insert_car_notice_admin( $post_id, $post, $update ) {
    if( $post->post_type === 'pixad-autos'){
        autozone_add_car_notice_admin($post_id);
    }
}



// шаблон вывода select полей
function autozone_temp_select_cond($field, $validate){
    $show = isset($field['show']) ? $field['show'] : $field['field'].'_show';
    $req = isset($field['show']) ? $field['show'] : $field['field'].'_req';
    $placeholder = isset($field['placeholder']) ? $field['placeholder'] : '';
    ?>
    <select name="<?php echo esc_attr($field['field']); ?>" <?php echo isset($validate[$req]) ? 'required' : ''; ?> class="pixad-form-control">
        <option value=""><?php _e( '-- Please Select --', 'autozone' ); ?></option>
        <option value="new" <?php if(pixad_get_meta('_auto_condition')=='new') echo 'selected'; ?>><?php _e( 'New', 'autozone' ); ?></option>
        <option value="used" <?php if(pixad_get_meta('_auto_condition')=='used') echo 'selected'; ?>><?php _e( 'Used', 'autozone' ); ?></option>
        <option value="driver" <?php if(pixad_get_meta('_auto_condition')=='driver') echo 'selected'; ?>><?php _e( 'Driver', 'autozone' ); ?></option>
        <option value="non driver" <?php if(pixad_get_meta('_auto_condition')=='non driver') echo 'selected'; ?>><?php _e( 'Non driver', 'autozone' ); ?></option>
        <option value="projectcar" <?php if(pixad_get_meta('_auto_condition')=='projectcar') echo 'selected'; ?>><?php _e( 'Projectcar', 'autozone' ); ?></option>
        <option value="barnfind" <?php if(pixad_get_meta('_auto_condition')=='barnfind') echo 'selected'; ?>><?php _e( 'Barnfind', 'autozone' ); ?></option>
    </select>
    <?php
}
function autozone_temp_select_purpose($field, $validate){
    $show = isset($field['show']) ? $field['show'] : $field['field'].'_show';
    $req = isset($field['show']) ? $field['show'] : $field['field'].'_req';
    $placeholder = isset($field['placeholder']) ? $field['placeholder'] : '';
    ?>
    <select name="<?php echo esc_attr($field['field']); ?>" <?php echo isset($validate[$req]) ? 'required' : ''; ?> class="pixad-form-control">
        <option value=""><?php _e( '-- Please Select --', 'autozone' ); ?></option>
        <option value="sell" <?php if(pixad_get_meta('_auto_purpose')=='sell') echo 'selected'; ?>><?php _e( 'Sell', 'autozone' ); ?></option>
        <option value="rent" <?php if(pixad_get_meta('_auto_purpose')=='rent') echo 'selected'; ?>><?php _e( 'Rent', 'autozone' ); ?></option>
        <option value="sold" <?php if(pixad_get_meta('_auto_purpose')=='sold') echo 'selected'; ?>><?php _e( 'Sold', 'autozone' ); ?></option>
    </select>
    <?php
}
function autozone_temp_select_warranty($field, $validate){
    $show = isset($field['show']) ? $field['show'] : $field['field'].'_show';
    $req = isset($field['show']) ? $field['show'] : $field['field'].'_req';
    $placeholder = isset($field['placeholder']) ? $field['placeholder'] : '';
    ?>
    <select  name="<?php echo esc_attr($field['field']); ?>" <?php echo isset($validate[$req]) ? 'required' : ''; ?> class="pixad-form-control">
        <option value="no" <?php selected( 'no', pixad_get_meta('_auto_warranty'), true ); ?>><?php _e( 'No', 'autozone' ); ?></option>
        <option value="yes" <?php selected( 'yes', pixad_get_meta('_auto_warranty'), true ); ?>><?php _e( 'Yes', 'autozone' ); ?></option>
    </select>
    <?php
}
function autozone_temp_select_drive($field, $validate){
    $show = isset($field['show']) ? $field['show'] : $field['field'].'_show';
    $req = isset($field['show']) ? $field['show'] : $field['field'].'_req';
    $placeholder = isset($field['placeholder']) ? $field['placeholder'] : '';
    ?>
    <select  name="<?php echo esc_attr($field['field']); ?>" <?php echo isset($validate[$req]) ? 'required' : ''; ?> class="pixad-form-control">
        <option value=""><?php _e( '-- Please Select --', 'autozone' ); ?></option>
        <option value="front" <?php if(pixad_get_meta('_auto_drive')=='front') echo 'selected'; ?>><?php _e( 'Front', 'autozone' ); ?></option>
        <option value="rear" <?php if(pixad_get_meta('_auto_drive')=='rear') echo 'selected'; ?>><?php _e( 'Rear', 'autozone' ); ?></option>
        <option value="4x4" <?php if(pixad_get_meta('_auto_drive')=='4x4') echo 'selected'; ?>><?php _e( '4x4', 'autozone' ); ?></option>
    </select>
    <?php
}
function autozone_temp_select_doors($field, $validate){
    $show = isset($field['show']) ? $field['show'] : $field['field'].'_show';
    $req = isset($field['show']) ? $field['show'] : $field['field'].'_req';
    $placeholder = isset($field['placeholder']) ? $field['placeholder'] : '';
    ?>
    <select  name="<?php echo esc_attr($field['field']); ?>" <?php echo isset($validate[$req]) ? 'required' : ''; ?> class="pixad-form-control">
        <option value=""><?php _e( '-- Please Select --', 'autozone' ); ?></option>
        <?php pixad_get_options_range( 2, 5, pixad_get_meta('_auto_doors') ); ?>
    </select>
    <?php
}



// вывести поля страницы обновления авто
function autozone_temp_field_update_car($field, $validate){

    $show = isset($field['show']) ? $field['show'] : $field['field'].'_show';
    $req = isset($field['show']) ? $field['show'] : $field['field'].'_req';
    $placeholder = isset($field['placeholder']) ? $field['placeholder'] : '';

    if( isset($validate[$show]) || isset($validate[$req]) ): ?>
        <div class="pixad-form-group">
            <label class="pixad-control-label">
                <?php echo esc_attr($field['name']) ?> <?php echo isset($validate[$req]) ? '<span class="required-field">*</span>' : ''; ?>
            </label>
            <div class="pixad-control-input">
                <?php if($field['type'] === 'select') : ?>
                    <?php if(!empty($field['temp']) && function_exists($field['temp'])){
                        $field['temp']($field, $validate);
                    } ?>
                <?php endif; ?>
                <?php if($field['type'] === 'text') : ?>
                    <input name="<?php echo esc_attr($field['field']); ?>" type="text" <?php echo isset($validate[$req]) ? 'required' : ''; ?> placeholder="<?php echo esc_html( $placeholder); ?>" value="<?php echo pixad_get_meta($field['slug']); ?>" class="pixad-form-control">
                    <span class="errengine"></span>
                <?php endif; ?>
            </div>
        </div>
    <?php endif;
}



// подгрузить медиа в фронтенд
function autozone_enqueue_media() {
    wp_enqueue_media();
    wp_enqueue_script('autozone-upload', get_template_directory_uri() . '/js/custom-upload.js', array() , '1.1', true);
}

// фильтр, показывает только свои медиа в wp.media
add_filter( 'ajax_query_attachments_args', 'show_current_user_attachments', 10, 1 );
function show_current_user_attachments( $query = array() ) {
    $user_id = get_current_user_id();
    if(!current_user_can('edit_pages')){
        if( $user_id ) {
            $query['author'] = $user_id;
        }
    }

    return $query;
}



// COMMENT RATING
add_action( 'comment_form_logged_in_after', 'pix_extend_comment_rating_fields' );
add_filter( 'comment_text', 'pix_extend_comment_rating');
add_action( 'comment_post', 'pix_save_extend_comment_meta_rating' );
add_filter('comment_form_fields', 'pix_reorder_comment_fields' );
function pix_extend_comment_rating_fields() {
    global $post;

    if($post->post_type == 'pixad-autos'){
        echo '<div class="comment-form-rating col-md-12">
        <label for="rating">'.esc_attr__('Your rating', 'autozone').'</label>
        <select name="rating" id="rating-autos" aria-required="true" required="" style="display: none;">
                            <option value="">Rate…</option>
                            <option value="5">Perfect</option>
                            <option value="4">Good</option>
                            <option value="3">Average</option>
                            <option value="2">Not that bad</option>
                            <option value="1">Very poor</option>
                        </select></div>';
    }
}
function pix_save_extend_comment_meta_rating( $comment_id ){
    if( !empty( $_POST['rating'] ) ){
        $rating = intval($_POST['rating']);
        add_comment_meta( $comment_id, 'rating', $rating );
    }
}
function pix_extend_comment_rating( $text ){
    global $post;
    if($post->post_type == 'pixad-autos'){
        if( $rating = intval( get_comment_meta( get_comment_ID(), 'rating', true ) ) ) {

            $commentrating = '<div class="star-rating"><span style="width:' . ( $rating * 20 ) . '%">' . sprintf( __( '%s out of 5', 'autozone' ), $rating ) . '</span></div>';
            $text = $commentrating . $text;
            return $text;
        } else {
            return $text;
        }
    }
    return $text;
}
function pix_reorder_comment_fields( $fields ){
    $new_fields = array(); // сюда соберем поля в новом порядке
    if(array_key_exists('rating', $fields)){
        $order = array('rating', 'author','email','comment');
    }else{
        $order = array( 'author','email','comment');
    }
    foreach( $order as $key ){
        $new_fields[ $key ] = $fields[ $key ];
        unset( $fields[ $key ] );
    }
    // если остались еще какие-то поля добавим их в конец
    if( $fields )
        foreach( $fields as $key => $val )
            $new_fields[ $key ] = $val;

    return $new_fields;
}

