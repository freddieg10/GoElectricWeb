<?php

/**
 * Plugin Name: Auto Booking
 * Description: Booking for Car
 * Author: Templines
 * Author URI: https://templines.com/
 * Version: 2.4.8
 * Text Domain:pixba

 */



require 'plugin-update-checker/plugin-update-checker.php';
$MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'http://assets.templines.com/plugins/pix-booking-auto.json',
    __FILE__,
    'pix-booking-auto'
);



// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * BOOKING AUTO
 */
class Pixad_Booking_AUTO
{

    //all strings class
    public static $strings = array();
    //all settings class
    public static $settings = array();
    public static $discount = 0;

    public function __construct()
    {
        self::init();

        //изменить цену тотал
        add_action('woocommerce_before_calculate_totals', array($this, 'woo_custom_price'));
        add_filter('woocommerce_cart_item_price', array($this, 'woo_cart_item_price'), 99, 3);
        add_filter('woocommerce_get_item_data', array($this, 'woo_add_item_meta'), 10, 2);
        add_action('woocommerce_checkout_create_order_line_item', array($this, 'woo_add_custom_order_line_item_meta'), 10, 4);
        add_filter('woocommerce_cart_item_thumbnail', array($this, 'woo_cart_item_thumbnail'), 10 , 3);
        add_filter('woocommerce_admin_order_item_thumbnail', array($this, 'woo_admin_order_item_thumbnail'), 10 , 3);
        add_filter('woocommerce_cart_item_quantity', array($this, 'woo_cart_item_quantity'), 10, 3);
        add_filter('woocommerce_quantity_input_args', array($this, 'woo_quantity_input_args'), 10, 2);
        add_filter('woocommerce_get_discounted_price',array($this, 'filter_woocommerce_get_discounted_price'), 10, 3 );

        add_action(''.get_template().'_end_auto', array($this, 'theme_booking_form_auto'), 10, 1);
        add_action(''.get_template().'_preview_calendar', array($this, 'theme_booking_preview_calendar'), 10, 1);
        add_action('header_botton_notice', array($this, 'show_notice'), 10, 1);
        add_action('pixba_calendar', array($this, 'calendar_view'), 10, 1);
        add_action('plugins_loaded', array($this, 'pixba_plugin_textdomain'));


        if(!is_admin()){
            add_action('wp_print_scripts', array($this, 'print_script_add'));
        }

        // admin page
        add_action('admin_menu', array($this, 'admin_menu_page'));
        add_action('admin_init', array($this, 'auto_settings_page'));
        add_action('add_meta_boxes', array($this,'add_box_custom_price'));
        add_action('save_post', array($this,'save_postdata_box') );


        function admin_style(){
            wp_register_style('pixba-style-admin-css', plugin_dir_url(__FILE__) . "css/booking-admin.css");
            wp_enqueue_style("pixba-style-admin-css" );
        }
        add_action('admin_head', 'admin_style');
        add_action('admin_print_scripts', array(&$this, 'scripts_method'));

    }

    public static function init()
    {
        if(!get_option('pixba_format_date')){
            add_option('pixba_format_date','j/m/Y');
        }
        if(!get_option('pixba_fix_quantity_with_timepicker')){
            add_option('pixba_fix_quantity_with_timepicker','off');
        }

        if(self::is_show_timepicker()){
            $format_opt = get_option('pixba_format_date', true);
            if(isset($format_opt) && $format_opt != ''){
                $format = $format_opt . ' H:i';
            } else {
                $format = 'm/d/Y H:i';
            }
        } else {
            $format_opt = get_option('pixba_format_date', true);
            if(isset($format_opt) && $format_opt != ''){
                $format = $format_opt;
            } else {
                $format = 'm/d/Y';
            }
        }
        self::$settings = array(
            'data_booking'     => array('time-start', 'time-finish', 'auto_id'),
            'general'     => self::get_general_settings(),
            'woo_id_product'   => get_option('pixba_product_default', false),
            'woo_fields_cart'  => array(
                'auto-name'                             => __('Auto name', 'pixba'),
                'auto_id'                               => __('Auto id', 'pixba'),
                'Start time'                            => __('Start time', 'pixba'),
                'Finish time'                           => __('Finish time', 'pixba'),
                'Start location'                        => __('Start location', 'pixba'),
                //    $start_location   => __('Start location', 'pixba'),
                'Finish location'                       => __('Finish location', 'pixba'),

            ),
            'notice'           => [],
            'date_format'      => $format,
            'data_select_type' => [
                ['title' => __('Total', 'pixba'), 'opt' => 'total'],
                ['title' => __('Day', 'pixba'), 'opt' => 'day'],
            ],
            'admin_page'       => [
                'page_add_field_title' => __('Add new field', 'pixba'),
                'page_add_field_key'   => __('Slug', 'pixba'),
                'page_add_field_name'  => __('Name', 'pixba'),
                'page_add_field_desc'  => __('Description', 'pixba'),
                'page_add_field_opt'   => __('Option', 'pixba'),
                'page_add_field_val'   => __('Price', 'pixba'),
            ],
            'all_keys' => ['is_discount', 'is_discount_all_days', 'is_show_discount_info'],
            'all_array_keys' => [ 'discounts'],

        );
        // Load class strings.
        self::$strings = array(
            'default_title_product'      => __('Booking auto', 'pixba'),
            'default_desc_product'       => __('Product for making a car reservation', 'pixba'),
            'custom_fields_name'         => __('Extra Resource', 'pixba'),
            'location_title'             => __('Location settings', 'pixba'),
            'add_location_title'         => __('Add location', 'pixba'),
            'custom_fields_title'        => __('Custom fields settings', 'pixba'),
            'property_title'             => __('Select properties', 'pixba'),
            'save_location_button'       => __('Save location', 'pixba'),
            'add_field_button'           => __('Add field', 'pixba'),
            'booking_title_page'         => __('Booking Form', 'pixba'),
            'start_location_title_page'  => __('Pick-up Location', 'pixba'),
            'finish_location_title_page' => __('Drop-off Location', 'pixba'),
            'location_title_page'        => __('Location', 'pixba'),
            'start_date_title_page'      => __('Pick-up Date', 'pixba'),
            'finish_date_title_page'     => __('Drop-off Date', 'pixba'),
            'date_incore'                => __('Date is incorrect', 'pixba'),
            'date_is_booked'             => __('Date to be booked, select another date.', 'pixba'),
            'location_incore'            => __('Location is incorrect', 'pixba'),
            'key_incore'                 => __('A key with this name is already in use.', 'pixba'),
            'no_key_incore'              => __('No key', 'pixba'),
            'page_title_admin'           => __('Booking', 'pixba'),
            'Sunday'                     => __('Sunday', 'pixba'),
            'Monday'                     => __('Monday', 'pixba'),
            'Tuesday'                    => __('Tuesday', 'pixba'),
            'Wednesday'                  => __('Wednesday', 'pixba'),
            'Thursday'                   => __('Thursday', 'pixba'),
            'Friday'                     => __('Friday', 'pixba'),
            'Saturday'                   => __('Saturday', 'pixba'),
            'disable'                   => __('Disable', 'pixba'),
            'disable_days_title'         => __('Disabled Week Days', 'pixba'),
            'work_hours_title'           => __('Working time', 'pixba'),
            'booking_style_title'        => __('Booking Style', 'pixba'),
            'hide_time'                  => __('Hide dates', 'pixba'),
            'hide_end_time'              => __('Hide drop-off date', 'pixba'),
            'hide_location'              => __('Hide locations', 'pixba'),
            'hide_timepicker'            => __('Hide timepicker', 'pixba'),
            'format_date'                => __('Date Format', 'pixba'),
            'default_order_button_title' => __('Booking this car', 'pixba'),
            'order_button_title'         => __('Order button title', 'pixba'),
            'order_title'                => __('Order title', 'pixba'),
            'min_date_title'             => __('Available dates start after days', 'pixba'),
            'remove_location_btn'        => __('X', 'pixba'),
            'discount_title'             => __('Сreate discount for cars', 'pixba'),
            'is_show_discount'           => __('Enable discounts', 'pixba'),
            'is_discount_all_days'       => __('Apply discount for all days', 'pixba'),
            'is_show_discount_info'       => __('Show information about discounts', 'pixba'),
            'start_discount'             => __('Start of discount', 'pixba'),
            'end_discount'               => __('End of discounts', 'pixba'),
            'percent_discount'           => __('Discount percentage', 'pixba'),
            'day_discount'               => __('Discount start on this day', 'pixba'),
            'discount_desc'              => __('Description of discount', 'pixba'),
            'add_button_discount'        => __('Add discount', 'pixba'),
            'save'                       => __('Save', 'pixba'),
            'box_custom_price'           => __('Box custom price', 'pixba'),
            'custom_price_catalog'       => __('Custom price in catalog', 'pixba'),
            'custom_price_car_page'      => __('Custom price in car page', 'pixba'),
            'you_discount'               => __('You save %s considering these days', 'pixba'),
        );

        $pixba_locations_with_coord_install =  array(
            '19cfpa62' =>
                array(
                    'name' => 'Location 1',
                    'phone' => '123456789',
                    'company' => 'Location 1',
                    'img' => '#',
                    'lattitude' => '',
                    'longitude' => ''
                ),
            '1r11qzh2' =>
                array (
                    'name' => 'Location 2',
                    'phone' => '123456789',
                    'company' => 'Location 2',
                    'img' => '#',
                    'lattitude' => '',
                    'longitude' => ''
                ),
            '1sac32das' =>
                array (
                    'name' => 'Location 3',
                    'phone' => '123456789',
                    'company' => 'Location 3',
                    'img' => '#',
                    'lattitude' => '',
                    'longitude' => ''
                )
        );

        $pixba_locations_install = array(
            0 => 'Location 1',
            1 => 'Location 2',
            2 => 'Location 3'
        );

        add_option('pixba_locations', $pixba_locations_install);
        add_option('pixba_locations_with_coordinates', $pixba_locations_with_coord_install);

    }

    public static function scripts_method()
    {

        $gmaps_api_key = get_option('pixba_google_api_key', true);
        wp_register_script( 'tmpray_googlemaps-api', 'https://maps.googleapis.com/maps/api/js?libraries=places&key='.$gmaps_api_key);
        wp_print_scripts( 'tmpray_googlemaps-api' );

        wp_enqueue_script('tmpray_geocomplete', plugin_dir_url( __FILE__ ) . 'js/jquery.geocomplete.js', array(), null, false);
        wp_enqueue_script('tmpray_scripts', plugin_dir_url( __FILE__ ) . 'js/scripts.js', array(), null, false);


    }


    public static function google_maps_api_enqueue_scripts (){

        wp_register_script( 'tmpray_googlemaps-api', 'https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyDl9xs4iIG1KcXu8gdnXkdhFbAVJpgKQiM');
        wp_enqueue_script('tmpray_googlemaps-api');

    }

///////////////////////////////////////////////////////////////////////////////////////////
    /////// inside functions
    ///////////////////////////////////////////////////////////////////////////////////////////
    public static function get_general_settings()
    {
        return get_option('pixba_settings', []);
    }
    public static function up_general_settings()
    {
        self::$settings['general'] = get_option('pixba_settings', []);
    }
    public static function get_setting($key, $default = '')
    {
        if (!in_array($key, self::$settings['all_keys'])) {
            return;
        }

        $general = self::$settings['general'];
        if (!empty($general[$key])) {
            return $general[$key];
        } else {
            return $default;
        }

    }
    public static function update_general_settings($key, $val)
    {
        if (!in_array($key, self::$settings['all_keys'])) {
            return;
        }

        $pixba_settings       = self::get_general_settings();
        $pixba_settings[$key] = $val;
        update_option('pixba_settings', $pixba_settings, 0);
    }
    public static function update_array_general_settings($field_key, $arrays_val)
    {

        if (!in_array($field_key, self::$settings['all_array_keys'])) {
            return;
        }

        $pixba_settings       = self::get_general_settings();
        $new_val = [];
        foreach ($arrays_val  as $lvl1_key => $array) {
            foreach ($array as $lvl2_key => $val ) {
                $new_val[$lvl2_key][$lvl1_key] = $val;
            }
        }
        // no empty
        foreach ($new_val as $lvl1_key => $arr) {
            $empty = true;
            foreach ($arr as $key => $value) {
                if(!empty($value)){
                    $empty = false;
                }
            }
            if($empty){
                unset($new_val[$lvl1_key]);
            }
        }
        $pixba_settings[$field_key] = $new_val;;
        update_option('pixba_settings', $pixba_settings, 0);
    }
    public function update_settings_fields()
    {
        //сохранить
        if (!empty($_POST['submit']) && $_POST['submit'] == 'up_settings' && isset($_POST['settings'])) {
            foreach ($_POST['settings'] as $key => $value) {
                self::update_general_settings($key, $value);
            }
        }
        self::up_general_settings();
    }
    public function update_settings_array_fields()
    {
        //сохранить
        if (!empty($_POST['submit']) && $_POST['submit'] == 'up_settings' && isset($_POST['settings'])) {
            foreach ($_POST['settings'] as $key => $value) {
                self::update_array_general_settings($key, $value);
            }
        }
        self::up_general_settings();
    }
    static function get_discount_val($cart_discount_data)
    {
        $pixba_settings     = get_option('pixba_settings', []);
        $discounts = !empty($pixba_settings['discounts']) ? $pixba_settings['discounts'] : [];

        foreach ($discounts as $key => $discount) {



            $valid_discount =  self::is_valid_period($cart_discount_data, $discount);
            if(empty($valid_discount)) continue;

            $percent = floatval( $discount['percent']);
            if($percent < 0){
                $percent = 0;
            }
            if($percent > 100){
                $percent = 100;
            }
            if(($cart_discount_data['quantity'] >= $discount['day'])  ){
                return ['percent' => $percent, 'day' => $discount['day'] ];
            }
        }
        return 0;
    }

    static function get_discounts_arr($cart_discount_data)
    {
        $pixba_settings     = get_option('pixba_settings', []);
        $discounts = !empty($pixba_settings['discounts']) ? $pixba_settings['discounts'] : [];
        if(isset($cart_discount_data['auto_id'])){
            $pixba_auto_discount = get_post_meta( $cart_discount_data['auto_id'], 'pixba_auto_discount', true );
        }

        $use_discounts= [];
        foreach ($discounts as $key => $discount) {

            if(isset($pixba_auto_discount) && !empty($pixba_auto_discount)){
                $discount_to_check = $discount['percent'] . '-' . $discount['day'];
                if(in_array($discount_to_check, $pixba_auto_discount)){
                    $valid_discount =  self::is_valid_period($cart_discount_data, $discount);
                    if(empty($valid_discount)) continue;

                    $percent = floatval( $discount['percent']);
                    if($percent < 0){
                        $percent = 0;
                    }
                    if($percent > 100){
                        $percent = 100;
                    }
                    if(($cart_discount_data['quantity'] >= $discount['day'])  ){
                        $use_discounts[] = ['percent' => $percent, 'day' => $discount['day'] ];
                    }
                }

            } else {
                $valid_discount =  self::is_valid_period($cart_discount_data, $discount);
                if(empty($valid_discount)) continue;

                $percent = floatval( $discount['percent']);
                if($percent < 0){
                    $percent = 0;
                }
                if($percent > 100){
                    $percent = 100;
                }
                if(($cart_discount_data['quantity'] >= $discount['day'])  ){
                    $use_discounts[] = ['percent' => $percent, 'day' => $discount['day'] ];
                }
            }

        }
        return $use_discounts;
    }

    //Change format from j/m/Y to m/j/Y
    public static function pixba_change_format($old_date){
        $date_int = explode("/", $old_date);
        return $date_int[1].'/'.$date_int[0].'/'.$date_int[2];
    }

    //Change format from m/j/Y to  j/m/Y
    public static function pixba_change_format_two($old_date){
        $date_int = explode("/", $old_date);
        return $date_int[1].'/'.$date_int[0].'/'.$date_int[2];
    }

    //Change format from j/m/Y to Y-m-d
    public static function pixba_change_format_to_booked_days($old_date){
        $date_int = explode("/", $old_date);
        return $date_int[2].'-'.$date_int[1].'-'.$date_int[0];
    }

    public static function is_valid_period($cart_discount_data, $discount)
    {
        $pixba_format_date = get_option('pixba_format_date');
        $pixba_hide_timepicker = get_option('pixba_hide_timepicker');
        if (isset($pixba_hide_timepicker) && $pixba_hide_timepicker == 1){
            $format_option = $pixba_format_date . ' H:i:s';
        } else {
            $format_option = $pixba_format_date;
        }

        if($format_option == 'j/m/Y H:i:s' or $format_option == 'j/m/Y'){
            $date_start = self::pixba_change_format($cart_discount_data['start'], $format_option, "m/j/Y");
            $date_end = self::pixba_change_format($cart_discount_data['end'], $format_option, "m/j/Y");
        } else {
            $date_start = $cart_discount_data['start'];
            $date_end = $cart_discount_data['end'];
        }

        /*
           $date_start = DateTime::createFromFormat($format_option, $cart_discount_data['start']);
           $date_end = DateTime::createFromFormat($format_option, $cart_discount_data['end']);

           $t1 = strtotime($discount['start']) <= strtotime($date_start->format('m/d/Y'));
           $t2 = strtotime($discount['start']) >= strtotime($date_end->format('m/d/Y'));
           $t3 = strtotime($discount['end']) <= strtotime($date_start->format('m/d/Y'));
           $t4 = strtotime($discount['end']) >= strtotime($date_end->format('m/d/Y'));
        */

        $t1 = strtotime($discount['start']) <= strtotime($date_start);
        $t2 = strtotime($discount['start']) >= strtotime($date_end);
        $t3 = strtotime($discount['end']) <= strtotime($date_start);
        $t4 = strtotime($discount['end']) >= strtotime($date_end);
        if( ( ($t1 && $t4)  )  ){
            return ['discount' => $discount['percent']];
        }
    }
    static function is_show_time()
    {
        $hide_time = get_option('pixba_hide_time');
        $hide_time = !empty($hide_time) ? $hide_time : false;
        return empty($hide_time);
    }
    static function is_show_end_time()
    {
        $hide_end_time = get_option('pixba_hide_end_time');
        $hide_end_time = !empty($hide_end_time) ? $hide_end_time : false;
        return empty($hide_end_time);
    }
    static function is_show_location()
    {
        $hide_location = get_option('pixba_hide_location');
        $hide_location = !empty($hide_location) ? $hide_location : false;
        return empty($hide_location);
    }

    static function is_show_timepicker()
    {
        $hide_timepicker = get_option('pixba_hide_timepicker');
        $hide_timepicker = !empty($hide_timepicker) ? $hide_timepicker : false;

        return empty($hide_timepicker);
    }
    static function get_order_button_title()
    {
        $pixba_order_button_title = get_option('pixba_order_button_title');
        $pixba_order_button_title = $pixba_order_button_title ? $pixba_order_button_title : self::$strings['default_order_button_title'];
        return $pixba_order_button_title;
    }
    static function get_order_title()
    {
        $default_product_id = self::$settings['woo_id_product'];
        if (!empty($default_product_id)) {
            $default_product = get_post($default_product_id);
            if (isset($default_product->post_type) && $default_product->post_type == 'product' && $default_product->post_status === 'publish') {
                return $default_product->post_title;
            }
        }
        // default title
        return self::$strings['default_title_product'];
    }


    public function booking_auto($value = '')
    {
        global $post, $woocommerce;

        $default_product_id = self::$settings['woo_id_product'];

        if ($default_product_id) {
            $default_product = get_post($default_product_id);
            if (isset($default_product->post_type) && $default_product->post_type == 'product' && $default_product->post_status === 'publish') {
            } else {
                $this->set_product_default();
            }
        } else {
            $this->set_product_default();
        }
        //форма бронировнаия авто
        if (isset($_POST['auto_id']) && isset($_POST['booking_auto']) && isset($_POST['add-to-cart']) ) {
            $validate_data = $this->check_data_booking($_POST);

            $auto_id  = $_POST['auto_id'];

            if (get_post_meta($auto_id, '_auto_sale_price', true)) {
                $price = sanitize_text_field(get_post_meta($_POST['auto_id'], '_auto_sale_price', true));
            } elseif (get_post_meta($auto_id, '_auto_price', true)) {
                $price = sanitize_text_field(get_post_meta($_POST['auto_id'], '_auto_price', true));
            } else {

                $pixad_auto_price_in_hour = get_post_meta( $post->ID, 'pixad_auto_price_in_hour', true );
                $t = 1;
                while ($t <= 12){
                    if(isset($_POST['pixad_auto_price_in_hour_text_' . $pixad_auto_price_in_hour[$t]]) && $_POST['pixad_auto_price_in_hour_text_' . $pixad_auto_price_in_hour[$t]] != ''){
                        $price = sanitize_text_field($_POST['pixad_auto_price_in_hour_text_' . $pixad_auto_price_in_hour[$t]]);
                    }
                    $t++;
                }

            }


            $Settings = new PIXAD_Settings();
            $options = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
            $currency = pixad_get_currencies($options['autos_site_currency']);
            $currentTime = new DateTime();
            $pixad_auto_price_season = get_post_meta($auto_id, 'pixad_auto_price_season', []);
            if(isset($pixad_auto_price_season) && !empty($pixad_auto_price_season)){
                foreach ($pixad_auto_price_season as $key => $price){
                    foreach ($price as $p){

                        $date_start = DateTime::createFromFormat('Y-m-d', $p['pixad_auto_price_season_start']);
                        $date_end = DateTime::createFromFormat('Y-m-d', $p['pixad_auto_price_season_end']);
                        $date_start->getTimestamp();
                        $date_end->getTimestamp();
                        $currentTime->getTimestamp();

                        if (($date_start <= $currentTime) && ($currentTime <= $date_end)) {
                            $price = $p['pixad_auto_price_season_price'];
                        }
                    }
                }
            }





            $price = floatval($price) > 0 ? floatval($price) : 0;
            //есть цена
            if (!empty($price) && $price != 0) {

                //есть id продукта по умолчанию
                if ($default_product_id) {
                    $default_product = get_post($default_product_id);
                    //ид принадлежит продукту
                    if (isset($default_product->post_type) && $default_product->post_type == 'product' && $default_product->post_status === 'publish') {
                        $cart_item_data                  = [];
                        $cart_item_data['pixba_booking'] = $_POST['booking'];
                        if (empty($_POST['booking-field'])) {
                            $cart_item_data['pixba_booking']['fields'] = [];
                        } else {
                            $cart_item_data['pixba_booking']['fields'] = $_POST['booking-field'];
                        }
                        if (empty($_POST['pixad_auto_price_in_hour'])) {
                            $cart_item_data['pixba_booking']['price_in_hour'] = [];
                            $cart_item_data['pixba_booking']['price_in_hour_text'] = [];

                        } else {
                            $cart_item_data['pixba_booking']['price_in_hour'] = $_POST['pixad_auto_price_in_hour'];
                            $text_arr = 'pixad_auto_price_in_hour_text_' . $_POST['pixad_auto_price_in_hour'];
                            if (empty($_POST[$text_arr])) {
                                $cart_item_data['pixba_booking']['price_in_hour_text'] = [];
                            } else {
                                $cart_item_data['pixba_booking']['price_in_hour_text'] = $_POST[$text_arr];
                            }
                        }


                        // id
                        $cart_item_data['pixba_booking']['auto_id'] = $_POST['auto_id'];
                        //локации
                        if(self::is_show_location()){
                            if (empty($cart_item_data['pixba_booking']['Start location']) || empty($cart_item_data['pixba_booking']['Finish location'])) {
                                self::$settings['notice'][] = self::$strings['location_incore'];
                            }
                        }

                        // time
                        if(self::is_show_time() && self::is_show_end_time()){
                            if(self::$settings['date_format'] == 'j/m/Y H:i'){
                                $date_format = 'j/m/Y';
                                $start_time_f = strtok( $cart_item_data['pixba_booking']['Start time'], ' ');
                                $finish_time_f = strtok( $cart_item_data['pixba_booking']['Finish time'], ' ');

                            } elseif(self::$settings['date_format'] == 'm/j/Y H:i') {
                                $date_format = 'm/j/Y';
                                $start_time_f = strtok( $cart_item_data['pixba_booking']['Start time'], ' ');
                                $finish_time_f = strtok( $cart_item_data['pixba_booking']['Finish time'], ' ');
                            } else {
                                $date_format = self::$settings['date_format'];
                                $start_time_f = $cart_item_data['pixba_booking']['Start time'];
                                $finish_time_f = $cart_item_data['pixba_booking']['Finish time'];
                            }


                            $start_time = DateTime::createFromFormat($date_format, $start_time_f);
                            $finish_time = DateTime::createFromFormat($date_format, $finish_time_f);

                            if ($finish_time && $start_time) {
                                $time  = date_diff($start_time, $finish_time );
                                $diffInDays = (int)$time->format("%r%a");
                                if ($diffInDays == 0){
                                    $diffInDays = 1;
                                }
                                if ($diffInDays < 1) {
                                    self::$settings['notice'][] = self::$strings['date_incore'];

                                }else{

                                    if(self::is_show_timepicker()){
                                        if ($time->days == 0){
                                            $day = 1;
                                        } else {
                                            $day = $time->days;
                                        }
                                        if ($time->h || $time->i) {
                                            if($time->days != 0){
                                                $day++;
                                            }
                                        }
                                    } else {
                                        if ($time->days == 0){
                                            $day = 1;
                                        } else {
                                            $day = $time->days;
                                        }

                                        if($time->days != 0) {
                                            $day++;
                                        }
                                    }

                                    if ($day < 1) {
                                        //self::$settings['notice'][] = self::$strings['date_incore'];
                                    }
                                }
                            }else{
                                self::$settings['notice'][] = self::$strings['date_incore'];
                            }
                            self::valid_period_to_order($cart_item_data, $_POST['auto_id']);
                        } elseif( self::is_show_time() ) {
                            /*
                            if(!isset($_POST['pixad_auto_price_in_hour'])){
                                self::$settings['notice'][] = self::$strings['date_incore'];
                            } else {
                                $day = 1;
                            }
                            */

                            if($_POST['booking']['Start time'] == ''){
                                self::$settings['notice'][] = self::$strings['date_incore'];
                            } else {
                                $day = 1;
                            }
                        } else {
                            // no time => 1day
                            $day = 1;
                        }

                        if(self::is_show_timepicker()){
                            $fix_quantity = get_option('pixba_fix_quantity_with_timepicker');
                            if($fix_quantity != 'off'){
                                $start_time_f = stristr( $cart_item_data['pixba_booking']['Finish time'], ' ');
                                $start_time_s = strtok( $start_time_f, ':');

                                if (intval($start_time_s) >= intval($fix_quantity)){
                                   // $cart_item_data['quantity']++;
                                }
                            }
                        }



                        if(self::is_show_timepicker()){
                            $fix_quantity = get_option('pixba_fix_quantity_with_timepicker');
                            if($fix_quantity != 'off'){
                                $start_time_f = stristr( $cart_item_data['pixba_booking']['Finish time'], ' ');
                                $start_time_s = strtok( $start_time_f, ':');

                                if (intval($start_time_s) >= intval($fix_quantity)){
                                    $day++;
                                }
                            }
                        }

                        // нет предупреждений, создаем заказ
                        if(empty(self::$settings['notice'])){
                            $woocommerce->cart->empty_cart();
                            $woocommerce->cart->add_to_cart($default_product_id, $day, 0, array(), $cart_item_data);
                            $_POST = null;
                            wp_redirect(wc_get_cart_url());
                            exit;
                        }
                    } else {
                        $this->set_product_default();
                    }
                } else {
                    $this->set_product_default();
                }

            } else {
            }

        }
    }


    ///////////////////////////////////////////////////////////////////////////////////////////
    /////// ADMIN PAGE SETTINGS
    ///////////////////////////////////////////////////////////////////////////////////////////

    public function admin_menu_page()
    {
        if (!current_user_can('edit_pages', get_current_user_id())) {
            return false;
        }

        add_submenu_page('edit.php?post_type=pixad-autos', self::$strings['page_title_admin'], self::$strings['page_title_admin'], 'manage_options', 'pixba-settings-auto', array($this, 'auto_submenu_page'));
    }

    public function auto_settings_page()
    {

        register_setting('pixba_settings_woo', 'pixba_locations', array($this, 'sanitize_clb'));
        add_settings_section('pixba_section_id', '', '', 'pixba_field_loc');
        add_settings_field('pixba_field1', '', array($this, 'display_admin_loaction_field'), 'pixba_field_loc', 'pixba_section_id');



        // Опции рабочего времени

        $args = array(
            'type'              => 'array',
            'description'       => '',
            'sanitize_callback' => null,
            'show_in_rest'      => false,
        );
        register_setting('pixba_settings_woo', 'pixba_work_days', $args);
        register_setting('pixba_settings_woo', 'pixba_work_time', $args);

        register_setting('pixba_settings_woo', 'pixba_min_date');

        register_setting('pixba_settings_woo', 'pixba_style');


        add_settings_field( 'pixba_work_field1', array($this, 'display_admin_work_field'), 'pixba_field_loc', 'pixba_section_id');
        add_settings_field( 'pixba_time_field1', array($this, 'display_admin_work_field'), 'pixba_field_loc', 'pixba_section_id');

        add_settings_field( 'pixba_min_date_field1', array($this, 'display_admin_work_field'), 'pixba_field_loc', 'pixba_section_id');
        add_settings_field( 'pixba_style_field1', array($this, 'display_admin_style_field'), 'pixba_field_loc', 'pixba_section_id');

    }
    //html  страницы настроек и сохранить новые поля для бронирования авто
    public function auto_submenu_page()
    {
        self::update_settings_fields();
        self::update_settings_array_fields();

        //сохранить. добавить локации
        if (!empty($_POST['submit']) && $_POST['submit'] == 'save_location' && !empty($_POST['pixba_locations'])) {
            $new_array = array_diff($_POST['pixba_locations'], array(''));
            update_option('pixba_locations', $new_array);

            foreach ($new_array as $key => $value) {
                if ($value && function_exists ( 'icl_register_string' )) {
                    icl_register_string('pixba', $value, $value);
                }
            }
        }

        if (!empty($_POST['submit']) && $_POST['submit'] == 'save_location' && !empty($_POST['pixba_locations_with_coordinates'])) {
            update_option('pixba_locations_with_coordinates', $_POST['pixba_locations_with_coordinates']);

            //foreach ($new_array as $key => $value) {
            // if ($value && function_exists ( 'icl_register_string' )) {
            //      icl_register_string('pixba', $value, $value);
            //  //   }
            // }

        }
        //Cохранить добавить рабочие дни



        if (!empty($_POST['submit']) && $_POST['submit'] == 'save_work_days') {

            if (array_key_exists('pixba_work_days', $_POST)) {
                $days_array = array_diff($_POST['pixba_work_days'], array(''));
                $i=0;
                foreach ($_POST['pixba_work_days'] as $key => $value) {
                    $days_array[$i] = $value;
                    $i++;
                }
                $days_array  = implode(",", $days_array );

                update_option('pixba_work_days', $days_array);
            } else {
                update_option('pixba_work_days', '');
            }

            if(isset($_POST['pixba_fix_quantity_with_timepicker'])){
                update_option('pixba_fix_quantity_with_timepicker', $_POST['pixba_fix_quantity_with_timepicker']);
            }

            if (array_key_exists('pixba_work_time', $_POST)) {
                $time_array = array_diff($_POST['pixba_work_time'], array(''));
                $i=0;
                foreach ($_POST['pixba_work_time'] as $key => $value) {
                    $time_array[$i] = $value;
                    $i++;
                }
                $time_array  = implode(",", $time_array );

                update_option('pixba_work_time', $time_array);
            } else {
                update_option('pixba_work_time', '');

            }
            if (array_key_exists('pixba_min_date', $_POST)) {
                $min_date = $_POST['pixba_min_date'];
                update_option('pixba_min_date', $min_date);
            }

        }

        // saved block booking style
        if (!empty($_POST['submit']) && $_POST['submit'] === 'save_booking_style') {

            if (array_key_exists('pixba_style', $_POST)) {
                $pix_style = $_POST['pixba_style'];
                update_option('pixba_style', $pix_style);
            }
            if (array_key_exists('pixba_hide_time', $_POST)) {
                $pixba_hide_time = $_POST['pixba_hide_time'];
                update_option('pixba_hide_time', $pixba_hide_time, 0);
            }
            if (array_key_exists('pixba_hide_end_time', $_POST)) {
                $pixba_hide_end_time = $_POST['pixba_hide_end_time'];
                update_option('pixba_hide_end_time', $pixba_hide_end_time, 0);
            }
            if (array_key_exists('pixba_hide_location', $_POST)) {
                $pixba_hide_location = $_POST['pixba_hide_location'];
                update_option('pixba_hide_location', $pixba_hide_location, 0);
            }
            if (array_key_exists('pixba_hide_timepicker', $_POST)) {
                $pixba_hide_timepicker = $_POST['pixba_hide_timepicker'];
                update_option('pixba_hide_timepicker', $pixba_hide_timepicker, 0);
            }

            if (array_key_exists('pixba_format_date', $_POST)) {
                $pixba_format_date = $_POST['pixba_format_date'];
                update_option('pixba_format_date', $pixba_format_date, 0);
            }
            if (array_key_exists('pixba_order_button_title', $_POST)) {
                $order_button_title = $_POST['pixba_order_button_title'];
                update_option('pixba_order_button_title', $order_button_title, 0);
                if (function_exists ( 'icl_register_string' )) {
                    icl_register_string('pixba', $order_button_title, $order_button_title );
                }

            }
            if (array_key_exists('pixba_google_api_key', $_POST)) {
                $pixba_google_api_key = $_POST['pixba_google_api_key'];
                update_option('pixba_google_api_key', $pixba_google_api_key, 0);
            }
            if (array_key_exists('pixba_order_title', $_POST)) {
                $pixba_order_title = esc_html($_POST['pixba_order_title']);
                $default_product_id = self::$settings['woo_id_product'];
                if (!empty($default_product_id)) {
                    $default_product = get_post($default_product_id);
                    if (isset($default_product->post_type) && $default_product->post_type == 'product' && $default_product->post_status === 'publish') {
                        $p_post = array();
                        $p_post['ID'] = $default_product_id;
                        $p_post['post_title'] = $pixba_order_title;

                        wp_update_post( wp_slash($p_post) );
                    }
                }
            }
        }


        //добавить новое поле для woo
        if (!empty($_POST['pixba_new_field_key']) && !empty($_POST['pixba_new_field_name']) && !empty($_POST['pixba_new_field_desc']) && !empty($_POST['pixba_new_field_opt'])) {
            $fields        = get_option('pixba_custom_fields');
            $field         = [];
            $field['category']  = $_POST['pixba_new_field_category'];
            $field['icon']  = $_POST['pixba_new_field_icon'];
            $field['key']  = $_POST['pixba_new_field_key'];
            $field['name'] = $_POST['pixba_new_field_name'];
            $field['desc'] = $_POST['pixba_new_field_desc'];
            $field['opt']  = $_POST['pixba_new_field_opt'];
            $field['val']  = '';

            $field_error = '';
            if (is_array($fields)) {
                foreach ($fields as $key => $data) {
                    if ($data['key'] == $field['key']) {
                        $field_error                = 1;
                        self::$settings['notice'][] = self::$strings['key_incore'];
                    }
                }
            }

            if (empty($field_error)) {
                //нет ошибок, сохранить
                $fields[] = $field;
                update_option('pixba_custom_fields', $fields);
            }
        }

        //сохранить изменения в поле woo
        if (!empty($_POST['submit']) && $_POST['submit'] == 'save_change_field') {
            $fields            = get_option('pixba_custom_fields');
            $new_field         = [];
            $new_field['icon']  = $_POST['icon'];
            $new_field['category']  = $_POST['category'];
            $new_field['key']  = $_POST['key'];
            $new_field['name'] = $_POST['name'];
            $new_field['desc'] = $_POST['desc'];
            $new_field['opt']  = $_POST['opt'];
            $new_field['val']  = $_POST['val'];
            $field_error       = '';


            if ($new_field['name'] && function_exists ( 'icl_register_string' )) {
                icl_register_string('pixba', $new_field['name'], $new_field['name'] );
            }


            $is_key = 0;
            foreach ($fields as $key => $data) {
                if ($data['key'] == $new_field['key']) {
                    $is_key = 1;
                }
            }
            if (!$is_key) {
                $field_error                = 1;
                self::$settings['notice'][] = self::$strings['no_key_incore'];
            }
            if (empty($field_error)) {
                //нет ошибок, сохранить
                foreach ($fields as $key => $field) {
                    if ($field['key'] == $new_field['key']) {
                        $fields[$key] = $new_field;
                        update_option('pixba_custom_fields', $fields);
                        break;
                    }
                }
            }
        }
        //удалить поле woo
        if (!empty($_POST['submit']) && $_POST['submit'] == 'delete_field') {
            $fields = get_option('pixba_custom_fields');
            if (!is_array($fields)) {
                $old_fields = $fields;
                $fields     = [];
                $fields[]   = $old_fields;
            }
            $new_field         = [];
            $new_field['key']  = $_POST['key'];
            $new_field['name'] = $_POST['name'];
            $new_field['desc'] = $_POST['desc'];
            $new_field['opt']  = $_POST['opt'];
            $new_field['val']  = $_POST['val'];
            $field_error       = '';

            $is_key = 0;
            foreach ($fields as $key => $data) {
                if ($data['key'] == $new_field['key']) {
                    $is_key = 1;
                }
            }
            if (!$is_key) {
                $field_error                = 1;
                self::$settings['notice'][] = 'Нет ключа';
            }
            if (empty($field_error)) {
                //нет ошибок, удалить

                foreach ($fields as $key => $field) {
                    if ($field['key'] == $new_field['key']) {
                        unset($fields[$key]);
                        update_option('pixba_custom_fields', $fields);
                        break;
                    }
                }
            }
        }
        ?>
<div class="wrap">
    <h3><?php echo get_admin_page_title() ?></h3>
    <div class="booking-wrapper-location">

        <?php self::display_admin_style_field();?>

    </div>


    <div class="booking-wrapper-location">
        <div class="col-md-12">
            <h3><?php echo self::$strings['location_title']; ?></h3>
        </div>
        <div class="col-md-12">
            <?php self::display_admin_loaction_field();?>
        </div>
    </div>


    <div class="booking-wrapper-location">
        <?php self::fix_quantity_with_timepicker();?>

        <?php self::display_admin_work_field();?>

    </div>




    <div class="booking-wrapper-custom-fields">
        <div class="col-lg-12">
            <h3><?php echo self::$strings['custom_fields_title']; ?></h3>
        </div>
        <?php
                foreach (self::$settings['notice'] as $key => $notice) {
                    echo '<div class="booking-notice">' . $notice . '</div>';
                }
                self::display_auto_fields();
                self::display_new_field();
                ?>
    </div>

    <div class="booking-wrapper-custom-fields">
        <div class="col-lg-12">
            <h3><?php echo self::$strings['discount_title']; ?></h3>
        </div>
        <form method="post" class="pixad-form-horizontal" role="form">



            <div class="col-lg-12">
                <input type="hidden" name="settings[is_discount]" value="">
                <input type="checkbox" name="settings[is_discount]" value="1" <?php checked(1, self::get_setting('is_discount'))?> />
                <?php echo self::$strings['is_show_discount']; ?>
            </div>
            <div class="col-lg-12">
                <input type="hidden" name="settings[is_discount_all_days]" value="">
                <input type="checkbox" name="settings[is_discount_all_days]" value="1" <?php checked(1, self::get_setting('is_discount_all_days'))?> />
                <?php echo self::$strings['is_discount_all_days']; ?>
            </div>
            <div class="col-lg-12">
                <input type="hidden" name="settings[is_show_discount_info]" value="">
                <input type="checkbox" name="settings[is_show_discount_info]" value="1" <?php checked(1, self::get_setting('is_show_discount_info'))?> />
                <?php echo self::$strings['is_show_discount_info']; ?>
            </div>
            <?php

                    ?>
            <div class="col-lg-12"> &nbsp; </div>

            <div class="col-lg-2">
                <label class="pixad-control-label"><?php echo self::$strings['start_discount']; ?></label>
            </div>
            <div class="col-lg-2">
                <label class="pixad-control-label"><?php echo self::$strings['end_discount']; ?></label>
            </div>
            <div class="col-lg-2">
                <label class="pixad-control-label"><?php echo self::$strings['percent_discount']; ?></label>
            </div>
            <div class="col-lg-2">
                <label class="pixad-control-label"><?php echo self::$strings['day_discount']; ?></label>
            </div>
            <div class="col-lg-2">
                <label class="pixad-control-label"><?php echo self::$strings['discount_desc']; ?></label>
            </div>

            <input type="hidden" name="action" value="save">
            <div class="settings-discount">
                <?php self::html_admin_discounts(); ?>
            </div>
            <div class="pixad-form-group">
                <div class="col-lg-3">
                    <button type="button" name="add_discount" class="button button-primary booking-submit-save" value="add"><?php echo self::$strings['add_button_discount']; ?></button>
                </div>
            </div>

            <div class="col-lg-2 pixad-control-label"></div>
            <button type="submit" name="submit" class="button button-primary booking-submit-save col-lg-3" value="up_settings"><?php echo self::$strings['save']; ?></button>
        </form>

    </div>

</div>
<script type="text/javascript">
    ;
    jQuery(document).ready(function() {
        "use strict";
        jQuery("button[name=add_discount]").on('click', '', function(event) {
            event.preventDefault();
            var element = '<div class="pixad-form-group"><div class="col-lg-2"><input type="date" name="settings[discounts][start][]" class="pixad-form-control" "></div><div class="col-lg-2"><input type="date" name="settings[discounts][end][]" class="pixad-form-control"></div><div class="col-lg-2"><input type="number" step="0.00000001" min="0" max="100"  name="settings[discounts][percent][]" class="pixad-form-control"></div><div class="col-lg-2"><input type="number" step="1" min="1" max="100"  name="settings[discounts][day][]" class="pixad-form-control" ></div><div class="col-lg-2"><input type="text" maxlength="200" name="settings[discounts][desc][]" class="pixad-form-control"></div></div>';
            jQuery(".settings-discount").append(element);

        });


        jQuery('.settings-discount').on('click', '.remove_discount', function(event) {
            event.preventDefault();
            jQuery(this).parent('.pixad-form-group').remove();
            jQuery(this).remove();
        });
        jQuery('.remove_discount').click(function(event) {
            event.preventDefault();
            jQuery(this).parent('.pixad-form-group').remove();
            jQuery(this).remove();
        });


    });

</script>
<?php
    }

    function html_admin_discounts($value='')
    {
        $pixba_settings     = get_option('pixba_settings', []);
        $discounts = !empty($pixba_settings['discounts']) ? $pixba_settings['discounts'] : [];
        if(empty($discounts)){
            $discounts = [['start' => '', 'end'=>'','percent'=>'','day'=>'']];
        }
        foreach ($discounts as $key => $discount) {
            $discount['start'] = !empty( $discount['start']) ?  $discount['start'] : '';
            $discount['end'] = !empty( $discount['end']) ?  $discount['end'] : '';
            $discount['percent'] = !empty( $discount['percent']) ?  $discount['percent'] : '';
            $discount['day'] = !empty( $discount['day']) ?  $discount['day'] : '';
            $discount['desc'] = !empty( $discount['desc']) ?  $discount['desc'] : '';
            ?>

<div class="pixad-form-group">
    <div class="col-lg-2">
        <input type="date" name="settings[discounts][start][]" class="pixad-form-control" value="<?php echo $discount['start']; ?>">
    </div>
    <div class="col-lg-2">
        <input type="date" name="settings[discounts][end][]" class="pixad-form-control" value="<?php echo $discount['end']; ?>">
    </div>
    <div class="col-lg-2">
        <input type="number" step="0.00000001" min="0" max="100" name="settings[discounts][percent][]" class="pixad-form-control" value="<?php echo $discount['percent']; ?>">
    </div>
    <div class="col-lg-2">
        <input type="number" step="1" min="1" max="100" name="settings[discounts][day][]" class="pixad-form-control" value="<?php echo $discount['day']; ?>">
    </div>
    <div class="col-lg-2">
        <input type="text" maxlength="200" name="settings[discounts][desc][]" class="pixad-form-control" value="<?php echo esc_html($discount['desc']); ?>">
    </div>
    <a class="remove_discount button button-secondary">X</a>

</div>
<?php
        }

    }
    //все созданные кастомные поля
    public function display_auto_fields()
    {
        $custom_fields     = get_option('pixba_custom_fields');
        $html_field        = [];
        $data_options_keys = [];
        if (!empty($custom_fields)) {
            foreach ($custom_fields as $key => $field) {

                $options_key          = [];
                $options_key['opt']   = $field['key'];
                $options_key['title'] = $field['name'];
                $data_options_keys[]  = $options_key;
                if(!isset($field['category'])){
                    $field['category'] = '';
                }
                if(!isset($field['icon'])){
                    $field['icon'] = '';
                }
                $html_options     = self::html_options(self::$settings['data_select_type'], $field['opt']);
                $new_html         = [];
                $new_html['key']  = $field['key'];
                $new_html['html'] = '
                <div class="pixad-form-group">
                    <div class="pixad-form-group">
                        <label class="col-lg-2 pixad-control-label">
                            ' . __("Category", "pixba") . '
                        </label>
                        <div class="col-lg-9">
                            <input name="category" class="pixad-form-control" value="' . $field['category'] . '">
                        </div>
                    </div>
                    <div class="pixad-form-group">
                        <label class="col-lg-2 pixad-control-label">
                            ' . __("Category Icon", "pixba") . '
                        </label>
                        <div class="col-lg-9">
                            <input name="icon" class="pixad-form-control" value="' . $field['icon'] . '">
                        </div>
                    </div>
                    <div class="pixad-form-group">
                        <label class="col-lg-2 pixad-control-label">
                            ' . self::$settings['admin_page']['page_add_field_name'] . '
                        </label>
                        <div class="col-lg-9">
                            <input name="name" class="pixad-form-control" value="' . $field['name'] . '">
                        </div>
                    </div>
                    <div class="pixad-form-group">
                        <label class="col-lg-2 pixad-control-label">
                            ' . self::$settings['admin_page']['page_add_field_desc'] . '
                        </label>
                        <div class="col-lg-9">
                            <input name="desc" class="pixad-form-control" value="' . $field['desc'] . '">
                        </div>
                    </div>
                    <div class="pixad-form-group">
                        <label class="col-lg-2 pixad-control-label">
                            ' . self::$settings['admin_page']['page_add_field_opt'] . '
                        </label>
                        <div class="col-lg-9">
                        <select name="opt" class="pixad-form-control">
                            ' . $html_options . '
                        </select>
                        </div>
                    </div>
                    <div class="pixad-form-group">
                        <label class="col-lg-2 pixad-control-label">
                            ' . self::$settings['admin_page']['page_add_field_val'] . '
                        </label>
                        <div class="col-lg-9">
                            <input name="val" class="pixad-form-control" value="' . $field['val'] . '">
                        </div>
                    </div>
                </div>
                <input type="hidden" name="key" value="' . $field['key'] . '">
                ';
                $html_field[] = $new_html;
            }
        }

        $html_select_key = self::html_options($data_options_keys, '');
        $html_field_end  = '<div class="item col-md-12">

                    <label class="col-lg-2 pixad-control-label">

                    </label>
                    <button type="submit" name="submit" class="button button-primary booking-submit-save col-lg-3" value="save_change_field">SAVE</button>
                    <button type="submit" name="submit" class="button col-lg-3" value="delete_field">DELETE</button>

                </div>';
        $html_select_field =
            '<div>' . self::$strings['property_title'] . '</div>
                <select name="booking-select-custom-field" class="pixad-form-control booking-select-custom-field">
                    ' . $html_select_key . '
                </select>';

        echo '<div class="booking-settings__wrapper col-md-12">';
        echo '<div class="col-md-3">';
        echo $html_select_field;
        echo '</div>';
        foreach ($html_field as $key => $field) {
            $none = '';
            if ($key > 0) {
                $none = 'none';
            }

            echo '<div style="display:' . $none . '" class="col-md-8 booking-option-wrapper" data-bookingkey="' . $field['key'] . '" ><form action="" method="POST">';
            echo $field['html'] . $html_field_end;
            echo '</form></div>';
        }

        echo '</div>';
    }
    public function display_new_field()
    {

        $html_options = self::html_options(self::$settings['data_select_type'], '');

        $idf = uniqid('').'-'.rand(100,9999);

        echo '
        <div class="booking-block col-lg-12">
                <div class="pixad-form-group">
                    <div class="col-lg-12"><h3>' . self::$settings['admin_page']['page_add_field_title'] . '</h3></div>
                </div>
            <form method="post" class="pixad-form-horizontal" role="form">
                <input type="hidden" name="action" value="save">

                <div class="pixad-form-group">
                    <label class="col-lg-2 pixad-control-label">
                        ' . __("Category", "pixba") . '
                    </label>
                    <div class="col-lg-9">
                        <input name="pixba_new_field_category" class="pixad-form-control" value="">
                    </div>
                </div>
                <div class="pixad-form-group">
                    <label class="col-lg-2 pixad-control-label">
                        ' . __("Category Icon", "pixba") . '
                    </label>
                    <div class="col-lg-9">
                        <input name="pixba_new_field_icon" class="pixad-form-control" value="">
                    </div>
                </div>
                <div class="pixad-form-group">
                    <label class="col-lg-2 pixad-control-label">
                        ' . self::$settings['admin_page']['page_add_field_key'] . '
                    </label>
                    <div class="col-lg-9">
                        <input name="pixba_new_field_key" class="pixad-form-control" value="">
                    </div>
                </div>

                <div class="pixad-form-group">
                    <label class="col-lg-2 pixad-control-label">
                        ' . self::$settings['admin_page']['page_add_field_name'] . '
                    </label>
                    <div class="col-lg-9">
                        <input name="pixba_new_field_name" class="pixad-form-control" value="">
                    </div>
                </div>

                <div class="pixad-form-group">
                    <label class="col-lg-2 pixad-control-label">
                        ' . self::$settings['admin_page']['page_add_field_desc'] . '
                    </label>
                    <div class="col-lg-9">
                        <input name="pixba_new_field_desc" class="pixad-form-control" value="">
                    </div>
                </div>

                <div class="pixad-form-group">
                    <label class="col-lg-2 pixad-control-label">
                        ' . self::$settings['admin_page']['page_add_field_opt'] . '
                    </label>
                    <div class="col-lg-9">
                        <select name="pixba_new_field_opt" class="pixad-form-control">
                        ' . $html_options . '
                        </select>
                    </div>
                </div>
            <div class="col-lg-2 pixad-control-label"></div>
            <button type="submit" name="submit" class="button button-primary booking-submit-save col-lg-3" value="add field">' . self::$strings['add_field_button'] . '</button>
            </form>
            </div>
            <style>
            .booking-notice{
                display:flex;
                color: #fff;
                font-size: 13px;
                line-height: 22px;
                width: 100%;
                background-color: #DF5468;
                margin-bottom: 15px;
                padding: 5px 10px;
            }
            .booking-wrapper-custom-fields{
                margin-top: 30px;
            }
            .booking-wrapper-location{
                display: flex;
                flex-direction: column;
            }
            select#pixba_style{
                width: 168px;
            }
            .booking-wrapper-location .col-md-1{
                    margin-right: 15px;
            }
            .booking-wrapper-location .col-md-12 h3{
                display: inline-block;
            }
            .booking-wrapper-location .col-md-12 label{
                display: inline-block;
                margin-right: 10px;
            }
            .booking-settings__wrapper{
                display:inline-block;
            }
            .booking-block{
                margin-top:10px;
                background-color:#f2f0f0;
            }
            .wp-core-ui .booking-submit-save{
                margin-right:30px;
            }
            </style>
                ';
        ?>
<script type="text/javascript">
    var select_key = jQuery('.booking-select-custom-field').val();

    jQuery('.booking-select-custom-field').change(function() {
        jQuery('.booking-settings__wrapper').find('.booking-option-wrapper').each(function(index, el) {
            if (jQuery(this).data('bookingkey') == jQuery('.booking-select-custom-field').val()) {
                jQuery(this).show();
            } else {
                jQuery(this).hide();
            }

        });
    });
    jQuery('.booking-add_location').click(function(event) {
        var id = Math.random().toString(36).substr(2, 6);;
        var $id_html = '#pix-address-' + id;
        if (jQuery(this).data('submit') == 'add_location') {
            var remove_title = jQuery('.remove_location').first().text();
            jQuery(this).closest('.booking-location-all_wrapper').find('.booking-location-all').append('' +
                '<div class="col-b">' +
                '<input id="pix-address-' + id + '" name="pixba_locations_with_coordinates[' + id + '][name]" class="pixad-form-control" value="">' +
                '<input type="hidden" id="pix-address-' + id + '" name="pixba_locations[]" class="pixad-form-control" value="">' +
                '<input id="pix-address-' + id + '" name="pixba_locations_with_coordinates[' + id + '][phone]" class="pixad-form-control" placeholder="Phone" value="">' +
                '<input id="pix-address-' + id + '" name="pixba_locations_with_coordinates[' + id + '][company]" class="pixad-form-control" placeholder="Company" value="">' +
                '<input type="hidden" class="pixad-form-control" id="pixba-lat-' + id + '" name="pixba_locations_with_coordinates[' + id + '][lattitude]" value="">' +
                '<input type="hidden" class="pixad-form-control" id="pixba-long-' + id + '" name="pixba_locations_with_coordinates[' + id + '][longitude]" value="">' +
                '<a class="remove_location button button-secondary">' + remove_title + '</a>' +
                '</div>');

            jQuery('#pix-address-' + id + '').geocomplete({
                location: false
            }).bind('geocode:result', function(e, result) {
                jQuery('#pixba-lat-' + id).val(result.geometry.location.lat());
                jQuery('#pixba-long-' + id).val(result.geometry.location.lng());
                jQuery(this).val(result.formatted_address);
            });

        } else {

        }
    });




    jQuery('.booking-location-all_wrapper').on('click', '.remove_location', function(event) {
        event.preventDefault();
        jQuery(this).siblings('.pixad-form-control').remove();
        jQuery(this).remove();
    });
    jQuery('.remove_location').click(function(event) {
        event.preventDefault();
        jQuery(this).siblings('.pixad-form-control').remove();
        jQuery(this).remove();
    });

</script>
<?php
    }
    public static function display_admin_loaction_field($value = '')
    {
        $locations = get_option('pixba_locations');
        $locations_with_coordinates = get_option('pixba_locations_with_coordinates');
        echo '<form action="" method="POST">';
        echo '<div class="col-lg-b">';
        echo '<div class="booking-location-all_wrapper">';
        echo '<div class="booking-location-all">';
        if (is_array($locations) && !is_array($locations_with_coordinates)) {
            foreach ($locations as $key => $value) {
                echo '<div class="col-lg-b">
                                <input type="hidden" name="pixba_locations[]" class="pixad-form-control" value="' . $value . '">
                                <a class="remove_location button button-secondary">' . self::$strings['remove_location_btn'] . '</a>
                            </div>';
            }
        }


        if (is_array($locations_with_coordinates)) {
            foreach ($locations_with_coordinates as $key => $value) {
                //echo $value['name'].'<br>';
                echo '<div class="col-lg-b">
                                <input id="pix-address-'.$key.'" name="pixba_locations_with_coordinates['.$key.'][name]" class="pixad-form-control" value="' . $value['name'] . '">
                                <input type="hidden" id="pix-address-'.$key.'" name="pixba_locations[]" class="pixad-form-control" value="' . $value['name'] . '">
                                <input id="pix-address-'.$key.'" name="pixba_locations_with_coordinates['.$key.'][phone]" class="pixad-form-control" placeholder="Phone" value="' . $value['phone'] . '">
                                <input id="pix-address-'.$key.'" name="pixba_locations_with_coordinates['.$key.'][company]" class="pixad-form-control" placeholder="Company" value="' . $value['company'] . '">
                                <input id="pix-address-'.$key.'" name="pixba_locations_with_coordinates['.$key.'][img]" class="pixad-form-control" placeholder="Image URL" value="' . $value['img'] . '">
                                <input type="hidden" class="pixad-form-control" id="pixba-lat-'.$key.'" name="pixba_locations_with_coordinates['.$key.'][lattitude]" value="'.$value['lattitude'].'">
                                <input type="hidden" class="pixad-form-control" id="pixba-long-'.$key.'" name="pixba_locations_with_coordinates['.$key.'][longitude]" value="'.$value['longitude'].'">
                               <a class="remove_location button button-secondary">' . self::$strings['remove_location_btn'] . '</a>
                            </div>
                            <script>
                                jQuery("#pix-address-'.$key.'").geocomplete({
                                        location: false
                                    }).bind("geocode:result",function (e, result) {
                                        
                                        jQuery("#pixba-lat-'.$key.'").val(result.geometry.location.lat());
                                        jQuery("#pixba-long-'.$key.'").val(result.geometry.location.lng());
                                        jQuery(this).val(result.formatted_address);
                                    });
                            </script>
                            ';
            }
        }

        echo '</div>';
        echo '<div class="col-lg-b">
                        <div class="button booking-add_location col-lg-12" data-submit="add_location">' . self::$strings['add_location_title'] . '</div>
                    </div>';
        echo '</div>';
        echo '<div class="col-lg-booking-save_location">
                        <button type="submit" name="submit" class="button button-primary booking-save_location" value="save_location">' . self::$strings['save_location_button'] . '</button>
                    </div>';
        echo '</div>';
        echo '</form>';
    }



    public static function display_admin_work_field(){
        $work_days = get_option('pixba_work_days');
        $work_time = get_option('pixba_work_time');
        $min_date = get_option('pixba_min_date');

        echo "<div class='row'><div class='col-md-2'>
                <h3>" . self::$strings['disable_days_title'] . "</h3>";
        echo '<form action="" method="POST">';



        echo '<select name="pixba_work_days[]" id="work_days" multiple data-days="'.$work_days.'" size="7">';
        echo '<option value="0">' . self::$strings['Sunday'] . '</option>';
        echo '<option value="1">' . self::$strings['Monday'] . '</option>';
        echo '<option value="2">' . self::$strings['Tuesday'] . '</option>';
        echo '<option value="3">' . self::$strings['Wednesday'] . '</option>';
        echo '<option value="4">' . self::$strings['Thursday'] . '</option>';
        echo '<option value="5">' . self::$strings['Friday'] . '</option>';
        echo '<option value="6">' . self::$strings['Saturday'] . '</option>';
        echo '<option value="disable">' . self::$strings['disable'] . '</option>';
        echo '</select>';
        echo "</div><div class='col-md-2' > <h3>" . self::$strings['work_hours_title'] . "</h3>";
        echo '<select name="pixba_work_time[]" id="work_time" multiple data-time="'.$work_time.'" size="12">';
        echo '<option value="00:00">00:00</option>';
        echo '<option value="01:00">01:00</option>';
        echo '<option value="02:00">02:00</option>';
        echo '<option value="03:00">03:00</option>';
        echo '<option value="04:00">04:00</option>';
        echo '<option value="05:00">05:00</option>';
        echo '<option value="06:00">06:00</option>';
        echo '<option value="07:00">07:00</option>';
        echo '<option value="08:00">08:00</option>';
        echo '<option value="09:00">09:00</option>';
        echo '<option value="10:00">10:00</option>';
        echo '<option value="11:00">11:00</option>';
        echo '<option value="12:00">12:00</option>';
        echo '<option value="13:00">13:00</option>';
        echo '<option value="14:00">14:00</option>';
        echo '<option value="15:00">15:00</option>';
        echo '<option value="16:00">16:00</option>';
        echo '<option value="17:00">17:00</option>';
        echo '<option value="18:00">18:00</option>';
        echo '<option value="19:00">19:00</option>';
        echo '<option value="20:00">20:00</option>';
        echo '<option value="21:00">21:00</option>';
        echo '<option value="22:00">22:00</option>';
        echo '<option value="23:00">23:00</option>';
        echo '</select>';

        echo "</div><div class='col-md-2'><h3>" . self::$strings['min_date_title'] . "</h3><input type='text' value='".$min_date."' name='pixba_min_date'></div>";


        $fix_quantity_with_timepicker = get_option('pixba_fix_quantity_with_timepicker');
        echo "<div class='col-md-2'>
                <h3>" . __('Rent Start') . "</h3>";
        echo '<form action="" method="POST">';
        echo '<select name="pixba_fix_quantity_with_timepicker" id="pixba_fix_quantity_with_timepicker" size="12" data-quantity-fix="'.$fix_quantity_with_timepicker.'">';

        echo '<option value="off">Off</option>';
        echo '<option value="00:00">00:00</option>';
        echo '<option value="01:00">01:00</option>';
        echo '<option value="02:00">02:00</option>';
        echo '<option value="03:00">03:00</option>';
        echo '<option value="04:00">04:00</option>';
        echo '<option value="05:00">05:00</option>';
        echo '<option value="06:00">06:00</option>';
        echo '<option value="07:00">07:00</option>';
        echo '<option value="08:00">08:00</option>';
        echo '<option value="09:00">09:00</option>';
        echo '<option value="10:00">10:00</option>';
        echo '<option value="11:00">11:00</option>';
        echo '<option value="12:00">12:00</option>';
        echo '<option value="13:00">13:00</option>';
        echo '<option value="14:00">14:00</option>';
        echo '<option value="15:00">15:00</option>';
        echo '<option value="16:00">16:00</option>';
        echo '<option value="17:00">17:00</option>';
        echo '<option value="18:00">18:00</option>';
        echo '<option value="19:00">19:00</option>';
        echo '<option value="20:00">20:00</option>';
        echo '<option value="21:00">21:00</option>';
        echo '<option value="22:00">22:00</option>';
        echo '<option value="23:00">23:00</option>';

        /*
        if ($fix_quantity_with_timepicker == 'on'){
            echo '<option value="on" selected>' . __('On', 'pixba') . '</option>';
        } else {
            echo '<option value="on">' . __('On', 'pixba') . '</option>';
        }

        if ($fix_quantity_with_timepicker == 'off'){
            echo '<option value="off" selected>' . __('Off', 'pixba') . '</option>';
        } else {
            echo '<option value="off">' . __('Off', 'pixba') . '</option>';
        }
        */
        echo '</select>';
        echo "</div>";

        echo "</div>";





        echo '<button type="submit" name="submit" class="button button-primary btn_save_work_days" value="save_work_days">Save</button>';
        echo '</form>';  ?>



<script type="text/javascript">
    var work_days = jQuery('#work_days').data('days');
    var work_days_array = JSON.parse("[" + work_days + "]");

    jQuery.each(work_days_array, function(index, value) {
        jQuery('#work_days option[value="' + value + '"]').attr('selected', 'selected');
    });

    var work_time = jQuery('#work_time').data('time');
    var work_time_array = work_time.split(',');

    jQuery.each(work_time_array, function(index, value) {
        jQuery('#work_time option[value="' + value + '"]').attr('selected', 'selected');


    });

    var quantity_fix = jQuery('#pixba_fix_quantity_with_timepicker').data('quantity-fix');
    jQuery('#pixba_fix_quantity_with_timepicker option[value="' + quantity_fix + '"]').attr('selected', 'selected');

    var pix_style = jQuery('#pixba_style').data('style');
    jQuery('#pixba_style option[value="' + pix_style + '"]').attr('selected', 'selected');

</script>


<?php }
    public static function fix_quantity_with_timepicker(){






       // echo '<button type="submit" name="submit" class="button button-primary btn_save_work_days" value="save_work_days">Save</button>';
        echo '</form>';  ?>
<script type="text/javascript">
    var quantity_fix = jQuery('#pixba_fix_quantity_with_timepicker').data('quantity-fix');
    jQuery('#pixba_fix_quantity_with_timepicker option[value="' + quantity_fix + '"]').attr('selected', 'selected');

</script>

<?php }



    public static function display_admin_style_field(){

        $pix_style = get_option('pixba_style');
        $pixba_format_date = get_option('pixba_format_date');


        $pixba_hide_time = !self::is_show_time();
        $pixba_hide_end_time = !self::is_show_end_time();
        $pixba_hide_location = !self::is_show_location();
        $pixba_hide_timepicker = !self::is_show_timepicker();
        $pixba_order_button_title = self::get_order_button_title();
        $pixba_order_title = self::get_order_title();
        $pixba_google_api_key = get_option('pixba_google_api_key', true);
        echo "<form action='' method='POST'>";
        echo "<div class='row'>";
            echo "<div class='col-md-2'>
                <h3>" . self::$strings['booking_style_title'] . "</h3>";
        echo '<select name="pixba_style" id="pixba_style" data-style="'.$pix_style.'">';
        echo '<option value="sidebar">Sidebar</option>';
        echo '<option value="popup">Popup</option>';
        echo '</select>';

        echo '</div>';


        echo '<div class="col-md-2"><h3>'.__("Google Maps API key", "pixba").'</h3>';
        echo '<label><input type="text" name="pixba_google_api_key" placeholder="'.__("Google Maps API key", "pixba").'" value="'.esc_html($pixba_google_api_key).'"/></label>';
        echo '</div>';


        echo '<div class="col-md-2"><h3>'.self::$strings['order_button_title'].'</h3>';
        echo '<label><input type="text" name="pixba_order_button_title" value="'.esc_html($pixba_order_button_title).'" /></label>';
        echo '</div>';

        echo '<div class="col-md-2"><h3>'.self::$strings['order_title'].'</h3>';
        echo '<label><input type="text" name="pixba_order_title" value="'.esc_html($pixba_order_title).'" /></label>';
        echo '</div>';


        echo '<div class="col-md-2">';
        echo '<h3>'.self::$strings['format_date'].'</h3>';
        echo '<label><select name="pixba_format_date">';
        if($pixba_format_date == 'm/j/Y'){
            echo '<option value="m/j/Y" selected>m/j/Y</option>';
        } else {
            echo '<option value="m/j/Y">m/j/Y</option>';
        }

        if($pixba_format_date == 'j/m/Y'){
            echo '<option value="j/m/Y" selected>j/m/Y</option>';
        } else {
            echo '<option value="j/m/Y">j/m/Y</option>';
        }
        echo '</select></label>';
       // echo '<label><input type="text" name="pixba_format_date" value="' . $pixba_format_date . '"/></label>';
        echo '</div>';



        echo '<div class="col-md-12">';
        echo '<input type="hidden" name="pixba_hide_time" value="" />';
        echo '<label><input type="checkbox" name="pixba_hide_time" value="1" '. checked( 1, $pixba_hide_time, false ).'/></label><h3>'.self::$strings['hide_time'].'</h3>';
        echo '</div>';


        echo '<div class="col-md-12">';
        echo '<input type="hidden" name="pixba_hide_end_time" value="" />';
        echo '<label><input type="checkbox" name="pixba_hide_end_time" value="1" '. checked( 1, $pixba_hide_end_time, false ).'/></label>';
        echo '<h3>'.self::$strings['hide_end_time'].'</h3>';
        echo '</div>';





        echo '<div class="col-md-12">';
        echo '<input type="hidden" name="pixba_hide_timepicker" value="" />';
        echo '<label><input type="checkbox" name="pixba_hide_timepicker" value="1" '. checked( 1, $pixba_hide_timepicker, false ).'/></label>';
        echo '<h3>'.self::$strings['hide_timepicker'].'</h3>';
        echo '</div>';




        echo '<div class="col-md-12">';
        echo '<input type="hidden" name="pixba_hide_location" value="" />';
        echo '<label><input type="checkbox" name="pixba_hide_location" value="1" '. checked( 1, $pixba_hide_location, false ).'/></label>';
        echo '<h3>'.self::$strings['hide_location'].'</h3>';
        echo '</div>';



        echo '</div>';

        echo '<div class="col-md-12"><button type="submit" name="submit" class="button button-primary btn_save_work_days booking-save_location" value="save_booking_style">Save</button></div>';
        echo '</form>';  ?>

<script type="text/javascript">
    var pix_style = jQuery('#pixba_style').data('style');
    jQuery('#pixba_style option[value="' + pix_style + '"]').attr('selected', 'selected');

</script>
<?php }




    //создать элементы option html
    public static function html_options($data_select, $type_field)
    {
        $html_option = '';
        foreach ($data_select as $key => $option) {
            $selected = $option['opt'] == $type_field ? 'selected' : '';
            $html_option .= '<option ' . $selected . '  value="' . $option['opt'] . '">' . __($option['title'], 'pixba') . '</option>';
        }
        return $html_option;
    }
    public function on_include($value = '')
    {
        add_action('template_redirect', array($this, 'template_include'), 999);
    }
    public static function get_id_booking_product($value = '')
    {
        return get_option('pixba_product_default', false);
    }

    public function check_data_booking($data_booking)
    {
        $notice_field = $this->empty_booking_field($data_booking);
        if ($notice_field !== 0) {
//отсутствуют обязательных данных
            $this->notice_request_booking($notice_field);
        } else {
            $validate_data = $this->validate_data_booking($data_booking);
            if ($validate_data !== 0) {
                //валидация данных успешна
                return $validate_data;
            } else {
                $this->notice_request_booking();
            }
        }
        return 0;

    }

    public function validate_data_booking($data_booking)
    {
        $validate_data          = array();
        $auto_id                = intval($data_booking['auto_id']);

        if (get_post_meta($auto_id, '_auto_sale_price', true)) {
            $price   = sanitize_text_field(get_post_meta($_POST['auto_id'], '_auto_sale_price', true));
        } else {
            $price   = sanitize_text_field(get_post_meta($_POST['auto_id'], '_auto_price', true));
        }
        $price                  = floatval($price) > 0 ? floatval($price) : 0;
        $validate_data['price'] = $price;
        if ($price === 0) {
            //неправильная цена
            return 0;
        }
        $time_start                   = date($data_booking['time-start']);
        $validate_data['time-start']  = $time_start;
        $time_finish                  = date($data_booking['time-finish']);
        $validate_data['time-finish'] = $time_finish;
        return $validate_data;
    }
    public function empty_booking_field($data_booking)
    {
        foreach ($this::$settings['data_booking'] as $field) {
            if (!isset($data_booking[$field])) {
                return $field;
            }
        }
        return 0;

    }
    public function notice_request_booking($value = '')
    {

    }
    public function success_response($value = '')
    {

    }

    public function template_include()
    {
        global $post;
        // if (is_single() && isset($post->post_type) && $post->post_type === 'pixad-autos') {
        add_action('wp_enqueue_scripts', array($this, 'add_include'));
        $this->booking_auto();
        // }
    }

    public function add_include()
    {

        wp_register_script('pix-periodpicker-js', plugin_dir_url(__FILE__) . 'js/jquery.periodpicker.full.min.js', array('jquery'));
        wp_register_script('pix-timepicker-js', plugin_dir_url(__FILE__) . 'js/jquery.timepicker.min.js', array('jquery'));
        wp_register_script('pix-datetimepicker-js', plugin_dir_url(__FILE__) . 'js/jquery.datetimepicker.full.min.js', array('jquery'));
        wp_register_script('pix-booking-auto-js', plugin_dir_url(__FILE__) . 'js/pix-booking-auto.js', array('pix-periodpicker-js'));
        wp_register_script('pix-fullcalendar-js', plugin_dir_url(__FILE__) . 'js/fullcalendar.js', array('jquery'));

        wp_register_script('pix-preview-calendar-js', plugin_dir_url(__FILE__) . 'js/preview-calendar.js', array('jquery'));

        wp_register_style('pix-periodpicker-css', plugin_dir_url(__FILE__) . 'css/jquery.periodpicker.min.css');
        wp_register_style('pix-timepicker-css', plugin_dir_url(__FILE__) . 'css/jquery.timepicker.min.css');
        wp_register_style('pix-datetimepicker-css', plugin_dir_url(__FILE__) . 'css/jquery.datetimepicker.css');
        wp_register_style('pixba-style-css', plugin_dir_url(__FILE__) . 'css/booking.css');
        wp_register_style('pixba-fullcalendar-css', plugin_dir_url(__FILE__) . 'css/fullcalendar.css');
        wp_register_style('pixba-style-admin-css', plugin_dir_url(__FILE__) . 'css/booking-admin.css');

        wp_enqueue_script('pix-periodpicker-js');
        wp_enqueue_script('pix-timepicker-js');
        wp_enqueue_script('pix-datetimepicker-js');
        wp_enqueue_script('pix-fullcalendar-js');
        wp_enqueue_script('pix-preview-calendar-js');
        wp_enqueue_script('pix-booking-auto-js');

        wp_enqueue_style('pix-periodpicker-css');
        wp_enqueue_style('pix-timepicker-css');
        wp_enqueue_style('pix-datetimepicker-css');
        wp_enqueue_style('pixba-style-css');
        wp_enqueue_style('pixba-fullcalendar-css');
        wp_enqueue_style('pixba-style-admin-css');


    }


///////////////////////////////////////////////////////////////////////////////////////////
    /////// Product
    ///////////////////////////////////////////////////////////////////////////////////////////
    public function set_product_default($value = '')
    {
        global $post;
        $new_id = $this->create_product_variation(array(
            'author'        => '', // optional
            'title'         => self::$strings['default_title_product'],
            'content'       => self::$strings['default_desc_product'],
            'excerpt'       => 'The product short description…',
            'regular_price' => '16', // product regular price
            'sale_price'    => '', // product sale price (optional)
            'stock'         => '10', // Set a minimal stock quantity
            'image_id'      => '', // optional
            'gallery_ids'   => array(), // optional
            'sku'           => '', // optional
            'tax_class'     => '', // optional
            'weight'        => '', // optional
        ));
        $this->add_variation_product($new_id);
        update_option('pixba_product_default', $new_id);
    }
    public static function sort_discounts($a, $b)
    {
        $start_sort_a = intval( $a['day']);
        $start_sort_b = intval( $b['day']);

        if ($start_sort_a == $start_sort_b) {
            return 0;
        }
        return ($start_sort_a < $start_sort_b) ? 1 : -1;
    }
    function calculate_discount_price($price, $discount)
    {
        return $price * (100 - $discount) / 100;
    }



    function get_day_discount_percent()
    {
        $percent = 0;
        $on_discount = self::get_setting('is_discount');

        if(!empty($on_discount)){
            $items =  WC()->cart->get_cart();
            $item_count = count($items);
            $discount_data = [];
            //  1 product = auto
            if($item_count === 1){
                foreach ( $items as $hash => $cart_item ) {

                    if(  $cart_item['product_id'] !== self::$settings['woo_id_product'] ) {
                        $discount_data['start'] = $cart_item['pixba_booking']['Start time'];
                        $discount_data['end'] = $cart_item['pixba_booking']['Finish time'];
                        $discount_data['quantity'] = $cart_item['quantity'];
                        $discount_data['auto_id'] = $cart_item['pixba_booking']['auto_id'];
                    }
                }
                $use_discounts = self::get_discounts_arr($discount_data);

                usort($use_discounts, array('Pixad_Booking_AUTO','sort_discounts'));
                $discount = array_shift($use_discounts);
                $percent =  $discount['percent'];
            }
        }
        return $percent;
    }
    // set discounts
    function filter_woocommerce_get_discounted_price( $price, $values, $instance ) {
        $discount = self::get_discount_total();
        $extra_price = 0;
        $on_discount = self::get_setting('is_discount');
        $is_discount_all_days = self::get_setting('is_discount_all_days');
        if(!empty($on_discount) ){
            $quantity = 0;
            $items =  WC()->cart->get_cart();
            $item_count = count($items);
            $discount_data = [];
            // 1 product = auto

            if($item_count === 1){

                // extra product price
                foreach ($items as $cart_item_key => $cart_item) {



                    if ($cart_item['data']->get_id() == self::$settings['woo_id_product']) {
                        if (!empty($cart_item['pixba_booking']['fields'])) {
                            $all_fields       = get_option('pixba_custom_fields');
                            $data_cart_fields = $cart_item['pixba_booking']['fields'];
                            foreach ($data_cart_fields as $key_cart_fields => $cart_field) {
                                foreach ($all_fields as $key => $field_data) {
                                    if ($field_data['key'] == $key_cart_fields) {
                                        if ($field_data['opt'] == 'total') {
                                            $extra_price += floatval($field_data['val']) ;
                                        } else {
                                            $extra_price += floatval($field_data['val']) * $cart_item['quantity'];
                                        }
                                    }
                                }
                            }
                        }
                    }


                }
            }
        } else {
            $quantity = 0;
            $items =  WC()->cart->get_cart();
            $item_count = count($items);

            $discount_data = [];
            // 1 product = auto

            if($item_count === 1){
                // extra product price
                foreach ($items as $cart_item_key => $cart_item) {

                    if ($cart_item['data']->get_id() == self::$settings['woo_id_product']) {
                        if (!empty($cart_item['pixba_booking']['fields'])) {
                            $all_fields       = get_option('pixba_custom_fields');
                            $data_cart_fields = $cart_item['pixba_booking']['fields'];
                            foreach ($data_cart_fields as $key_cart_fields => $cart_field) {
                                foreach ($all_fields as $key => $field_data) {
                                    if ($field_data['key'] == $key_cart_fields) {
                                        if ($field_data['opt'] == 'total') {
                                            $extra_price += floatval($field_data['val']) ;
                                        } else {
                                            $extra_price += floatval($field_data['val']) * $cart_item['quantity'];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }





        if (get_post_meta($cart_item['pixba_booking']['auto_id'], '_auto_price', true)) {
            $price_in_day = sanitize_text_field(get_post_meta($cart_item['pixba_booking']['auto_id'], '_auto_price', true));
        }
        $pixad_auto_price_season    = get_post_meta($cart_item['pixba_booking']['auto_id'], 'pixad_auto_price_season', []);
        $start_time =  DateTime::createFromFormat('d/m/Y', strtok($cart_item['pixba_booking']['Start time'], ' '));
        $start_time_price_in_day =  DateTime::createFromFormat('d/m/Y', strtok($cart_item['pixba_booking']['Start time'], ' '));
        $start_time_total =  DateTime::createFromFormat('d/m/Y', strtok($cart_item['pixba_booking']['Start time'], ' '));
        $finish_time =  DateTime::createFromFormat('d/m/Y', strtok($cart_item['pixba_booking']['Finish time'], ' '));
        $start_time->getTimestamp();
        $start_time_price_in_day->getTimestamp();
        $start_time_total->getTimestamp();
        $finish_time->getTimestamp();

        if(isset($pixad_auto_price_season) && !empty($pixad_auto_price_season)){
            foreach ($pixad_auto_price_season as $key => $prices){
                $season_prices = $prices;
            }
            $all_date_prices = array();
            $i = 1;

            while ($i <= $cart_item['quantity']):
                foreach ($season_prices as $p){
                    $date_start = DateTime::createFromFormat('Y-m-d', $p['pixad_auto_price_season_start']);
                    $date_end = DateTime::createFromFormat('Y-m-d', $p['pixad_auto_price_season_end']);
                    $date_start->getTimestamp();
                    $date_end->getTimestamp();

                    if (($date_start <= $start_time) && ($start_time <= $date_end)) {
                        $all_date_prices[$start_time->format('Y-m-d')] = $p['pixad_auto_price_season_price'];
                    }
                }
                $start_time->modify('+ 1 day');
                $i++;
            endwhile;

            $j = 1;
            while ($j <= $cart_item['quantity']):
                if(empty($all_date_prices[$start_time_price_in_day->format('Y-m-d')]) && !isset($all_date_prices[$start_time_price_in_day->format('Y-m-d')])){
                    $all_date_prices[$start_time_price_in_day->format('Y-m-d')] = $price_in_day;
                }
                $start_time_price_in_day->modify('+ 1 day');
                $j++;
            endwhile;

            $season_price_total = 0;
            $k = 1;
            while ($k <= $cart_item['quantity']):
                $season_price_total += $all_date_prices[$start_time_total->format('Y-m-d')];
                $start_time_total->modify('+ 1 day');
                $k++;
            endwhile;
            //var_dump($all_date_prices);

            return ($season_price_total + $extra_price - $discount);

        } else {

            return ($price + $extra_price - $discount);
        }





    }

    public function to_string_attribute($attr_val)
    {
        $str_arr = '';
        foreach ($attr_val as $key => $val) {

            if ($key == 0) {
                $str_arr = $val;
            } else {
                $str_arr .= ' | ' . $val;
            }
        }
        return $str_arr;
    }
    public function add_variation_product($post_id)
    {
        $cars                      = array('cars');
        $info                      = array('property');
        $att_all                   = [];
        $att_all['car']            = $cars;
        $att_all['info']           = $info;
        $arr_attr_to_paren_product = [];
        foreach ($att_all as $key => $value) {
            $arr_attr_to_paren_product[$key] = $this->to_string_attribute($value);
        }
        $my_product_attributes = $arr_attr_to_paren_product;
        self::wcproduct_set_attributes($post_id, $my_product_attributes);

        foreach ($cars as $key_car => $car) {
            foreach ($info as $key_inf => $inf) {
                $_pv = new WC_Product_Variation();
                $_pv->set_parent_id($post_id);
                $_pv->set_manage_stock('false');
                $_pv->set_status('publish');
                $_pv->set_regular_price(50);
                $_pv->set_sale_price(50);
                $_pv->set_menu_order(0);
                $ar_attr         = [];
                $ar_attr['car']  = $car;
                $ar_attr['info'] = $inf;
                $_pv->set_attributes($ar_attr);

                update_post_meta($_pv->get_id(), 'attribute_' . 'car', $car);
                update_post_meta($_pv->get_id(), 'attribute_' . 'info', $inf);
                $_pv->save();
            }
        }

        $data                         = [];
        $data['attribute_names']      = [];
        $data['attribute_values']     = [];
        $data['attribute_position']   = [];
        $data['attribute_visibility'] = [];
        $data['attribute_variation']  = [];
        foreach ($att_all as $key => $value) {
            $data['attribute_names'][]      = $key;
            $data['attribute_position'][]   = '0';
            $data['attribute_values'][]     = $this->to_string_attribute($value);
            $data['attribute_visibility'][] = '1';
            $data['attribute_variation'][]  = '1';
        }
        $attributes = WC_Meta_Box_Product_Data::prepare_attributes($data);
        $product_id = absint($post_id);
        $classname  = WC_Product_Factory::get_product_classname($product_id, 'variable');
        $product    = new $classname($product_id);
        $product->set_attributes($attributes);
        $product->save();

    }
    public function save_product_attribute_from_name($name, $label = '', $set = true)
    {
        if (!function_exists('get_attribute_id_from_name')) {
            return;
        }

        global $wpdb;

        $label        = $label == '' ? ucfirst($name) : $label;
        $attribute_id = get_attribute_id_from_name($name);

        if (empty($attribute_id)) {
            $attribute_id = null;
        } else {
            $set = false;
        }
        $args = array(
            'attribute_id'      => $attribute_id,
            'attribute_name'    => $name,
            'attribute_label'   => $label,
            'attribute_type'    => 'select',
            'attribute_orderby' => 'menu_order',
            'attribute_public'  => 0,
        );

        if (empty($attribute_id)) {
            $wpdb->insert("{$wpdb->prefix}woocommerce_attribute_taxonomies", $args);
        }

        if ($set) {
            $attributes           = wc_get_attribute_taxonomies();
            $args['attribute_id'] = get_attribute_id_from_name($name);
            $attributes[]         = (object) $args;
            set_transient('wc_attribute_taxonomies', $attributes);
        } else {
            return;
        }
    }

    public function get_attribute_id_from_name($name)
    {
        global $wpdb;
        $attribute_id = $wpdb->get_col("SELECT attribute_id
        FROM {$wpdb->prefix}woocommerce_attribute_taxonomies
        WHERE attribute_name LIKE '$name'");
        return reset($attribute_id);
    }

    public function create_product_variation($data)
    {
        $postname = sanitize_title($data['title']);
        $author   = empty($data['author']) ? '1' : $data['author'];

        $post_data = array(
            'post_author'  => $author,
            'post_name'    => $postname,
            'post_title'   => $data['title'],
            'post_content' => $data['content'],
            'post_excerpt' => $data['excerpt'],
            'post_status'  => 'publish',
            'ping_status'  => 'closed',
            'post_type'    => 'product',
        );
        $product_id = wp_insert_post($post_data);
        $terms      = array('exclude-from-catalog', 'exclude-from-search');
        wp_set_object_terms($product_id, $terms, 'product_visibility');
        $product = new WC_Product_Variable($product_id);
        $product->save();

        return $product_id;
    }

///////////////////////////////////////////////////////////////////////////////////////////
/////// WOOCOMMERCE
///////////////////////////////////////////////////////////////////////////////////////////

    //изменить корзину woo, добавляет поля
    public function woo_add_item_meta($item_data, $cart_item)
    {
        if (!empty($cart_item['pixba_booking'])) {
            foreach (self::$settings['woo_fields_cart'] as $key => $text_field) {
                $new_field = '';
                if ($key == 'auto_id') {
                    $post_auto = get_post($cart_item['pixba_booking'][$key]);
                    $url       = get_permalink($post_auto->ID);
                    $new_field = '<a href="' . $url . '" class="booking-attr-cart">' . $post_auto->post_title . '</a>';
                }
                if (!empty($new_field)) {
                    if (array_key_exists($key, $cart_item['pixba_booking'])) {
                        $item_data[] = array(
                            'key'   => $new_field,
                            'value' => '',
                        );
                        $new_field = null;
                    }
                } else {
                    if (array_key_exists($key, $cart_item['pixba_booking'])) {
                        if($key == 'Finish time'){
                            if(self::is_show_end_time()){
                                $item_data[] = array(
                                    // 'key'   => $key,
                                    'key'   => __($text_field, 'pixba'),
                                    'value' => $cart_item['pixba_booking'][$key],
                                );
                            }
                        } else {
                            $item_data[] = array(
                                // 'key'   => $key,
                                'key'   => __($text_field, 'pixba'),
                                'value' => $cart_item['pixba_booking'][$key],
                            );
                        }

                    }
                }

            }
            //добавиь кастомные поля
            if (!empty($cart_item['pixba_booking']['fields'])) {
                $all_fields       = get_option('pixba_custom_fields');
                $data_cart_fields = $cart_item['pixba_booking']['fields'];
                foreach ($data_cart_fields as $key_cart_fields => $cart_field) {
                    foreach ($all_fields as $key => $field_data) {
                        if ($field_data['key'] == $key_cart_fields) {
                            $item_data[] = array(
                                'key'   => self::$strings['custom_fields_name'],
                                'value' => '<span class="field-name">' . $field_data['name'] . '</span>' . ' - ' . '<span class="field-price">' . $cart_field . get_woocommerce_currency_symbol() . '</span>',
                            );
                        }
                    }
                }
            }
        }

        return $item_data;
    }
    //добавить в поля заказа кастомные поля
    public function woo_add_custom_order_line_item_meta($item, $cart_item_key, $values, $order)
    {

        if (!empty($values['pixba_booking'])) {
            foreach (self::$settings['woo_fields_cart'] as $key => $text_field) {
                $text_field = $key;
                if ($key == 'auto_id') {
                    $post_auto  = get_post($values['pixba_booking'][$key]);
                    $url        = get_permalink($post_auto->ID);
                    $text_field = '<a href="' . $url . '" class="booking-attr-cart">' . $post_auto->post_title . '</a>';
                    $item->add_meta_data('auto_id', $post_auto->ID);
                }

                if (array_key_exists($key, $values['pixba_booking'])) {
                    if($key == 'Finish time'){
                        if(self::is_show_end_time()){
                            $item->add_meta_data(__($text_field, 'pixba'), $values['pixba_booking'][$key]);
                        }
                    } else {
                        $item->add_meta_data(__($text_field, 'pixba'), $values['pixba_booking'][$key]);

                    }
                    //   $item->add_meta_data($text_field, $values['pixba_booking'][$key]);
                }
            }

            if (!empty($values['pixba_booking']['fields'])) {
                $all_fields       = get_option('pixba_custom_fields');
                $data_cart_fields = $values['pixba_booking']['fields'];

                foreach ($data_cart_fields as $key_cart_fields => $cart_field) {
                    foreach ($all_fields as $key => $field_data) {
                        if ($field_data['key'] == $key_cart_fields) {
                            $item->add_meta_data(self::$strings['custom_fields_name'], $field_data['name']);
                        }
                    }
                }
            }
        }
        var_dump($item);
    }


    //изменить цену от кастоных свойств
    public function woo_custom_price($cart_object)
    {
        if (is_admin() && !defined('DOING_AJAX')) {
            return;
        }

        $extra_price = 0;


        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            if ($cart_item['data']->get_id() == self::$settings['woo_id_product']) {
                $auto_id      = $cart_item['pixba_booking']['auto_id'];
                if (get_post_meta($auto_id, '_auto_sale_price', true)) {
                    $price  = get_post_meta($auto_id, '_auto_sale_price', true);
                } else {
                    $price  = get_post_meta($auto_id, '_auto_price', true);

                }
                if(isset($cart_item['pixba_booking']['price_in_hour']) && !empty($cart_item['pixba_booking']['price_in_hour']) && $cart_item['pixba_booking']['price_in_hour'] != ''){
                    $price = $cart_item['pixba_booking']['price_in_hour'];
                }



                $Settings = new PIXAD_Settings();
                $options = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
                $currency = pixad_get_currencies($options['autos_site_currency']);
                $currentTime = new DateTime();
                $pixad_auto_price_season = get_post_meta($auto_id, 'pixad_auto_price_season', []);
                foreach ($pixad_auto_price_season as $key => $price){
                    foreach ($price as $p){
                        $date_start = DateTime::createFromFormat('Y-m-d', $p['pixad_auto_price_season_start']);
                        $date_end = DateTime::createFromFormat('Y-m-d', $p['pixad_auto_price_season_end']);
                        $date_start->getTimestamp();
                        $date_end->getTimestamp();
                        $currentTime->getTimestamp();
                        if (($date_start <= $currentTime) && ($currentTime <= $date_end)) {
                            $price = $p['pixad_auto_price_season_price'];
                        }
                    }
                }


                $custom_price = floatval($price) > 0 ? floatval($price) : 0;

                $is_discount_all_days = self::get_setting('is_discount_all_days');
                if(!empty($is_discount_all_days)){
                    $percent = self::get_day_discount_percent();
                    $custom_price = self::calculate_discount_price($custom_price, $percent);

                }

                // extra product price
                if (!empty($cart_item['pixba_booking']['fields'])) {
                    $all_fields       = get_option('pixba_custom_fields');
                    $data_cart_fields = $cart_item['pixba_booking']['fields'];
                    foreach ($data_cart_fields as $key_cart_fields => $cart_field) {
                        foreach ($all_fields as $key => $field_data) {
                            if ($field_data['key'] == $key_cart_fields) {
                                if ($field_data['opt'] == 'total') {
                                    $extra_price += floatval($field_data['val']) ;
                                } else {
                                    $extra_price += floatval($field_data['val']) * $cart_item['quantity'];
                                }
                            }
                        }
                    }
                }


                $cart_item['data']->set_price($custom_price);
            }
        }

    }

    //woo html измениь цену в корзине
    public function woo_cart_item_price($price, $cart_item, $cart_item_key)
    {
        if ($cart_item['data']->get_id() == self::$settings['woo_id_product']) {

            $auto_id      = $cart_item['pixba_booking']['auto_id'];
            $is_discount_all_days = self::get_setting('is_discount_all_days');

            if (get_post_meta($auto_id, '_auto_sale_price', true)) {
                $price  = get_post_meta($auto_id, '_auto_sale_price', true);
            } else {
                $price  = get_post_meta($auto_id, '_auto_price', true);
            }

            if(isset($cart_item['pixba_booking']['price_in_hour']) && $cart_item['pixba_booking']['price_in_hour'] != '' && $cart_item['pixba_booking']['price_in_hour'] != NULL){
                $price = $cart_item['pixba_booking']['price_in_hour'];
            } else {
                $Settings = new PIXAD_Settings();
                $options = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
                $currency = pixad_get_currencies($options['autos_site_currency']);
                $currentTime = new DateTime();
                $pixad_auto_price_season = get_post_meta($auto_id, 'pixad_auto_price_season', []);
                if(isset($pixad_auto_price_season) && !empty($pixad_auto_price_season)){
                    foreach ($pixad_auto_price_season as $key => $prices){
                        foreach ($prices as $p){
                            $date_start = DateTime::createFromFormat('Y-m-d', $p['pixad_auto_price_season_start']);
                            $date_end = DateTime::createFromFormat('Y-m-d', $p['pixad_auto_price_season_end']);
                            $date_start->getTimestamp();
                            $date_end->getTimestamp();
                            $currentTime->getTimestamp();

                            if (($date_start <= $currentTime) && ($currentTime <= $date_end)) {
                                $price = $p['pixad_auto_price_season_price'];
                            }
                        }
                    }
                }
            }



            $price = floatval($price) > 0 ? floatval($price) : 0;

            $percent = self::get_day_discount_percent();

            $price = self::calculate_discount_price($price, $percent);


            if (get_post_meta($cart_item['pixba_booking']['auto_id'], '_auto_price', true)) {
                $price_in_day = sanitize_text_field(get_post_meta($cart_item['pixba_booking']['auto_id'], '_auto_price', true));
            }
            $pixad_auto_price_season    = get_post_meta($cart_item['pixba_booking']['auto_id'], 'pixad_auto_price_season', []);
            $start_time =  DateTime::createFromFormat('d/m/Y', strtok($cart_item['pixba_booking']['Start time'], ' '));
            $start_time_price_in_day =  DateTime::createFromFormat('d/m/Y', strtok($cart_item['pixba_booking']['Start time'], ' '));
            $start_time_total =  DateTime::createFromFormat('d/m/Y', strtok($cart_item['pixba_booking']['Start time'], ' '));
            $finish_time =  DateTime::createFromFormat('d/m/Y', strtok($cart_item['pixba_booking']['Finish time'], ' '));
            $start_time->getTimestamp();
            $start_time_price_in_day->getTimestamp();
            $start_time_total->getTimestamp();
            $finish_time->getTimestamp();

            if(isset($pixad_auto_price_season) && !empty($pixad_auto_price_season)){
                foreach ($pixad_auto_price_season as $key => $prices){
                    $season_prices = $prices;
                }
                $all_date_prices = array();
                $all_date_prices_html = [];
                $all_date_prices_html_res = '';
                $i = 1;

                while ($i <= $cart_item['quantity']):
                    foreach ($season_prices as $p){
                        $date_start = DateTime::createFromFormat('Y-m-d', $p['pixad_auto_price_season_start']);
                        $date_end = DateTime::createFromFormat('Y-m-d', $p['pixad_auto_price_season_end']);
                        $date_start->getTimestamp();
                        $date_end->getTimestamp();

                        if (($date_start <= $start_time) && ($start_time <= $date_end)) {
                            $all_date_prices[$start_time->format('Y-m-d')] = $p['pixad_auto_price_season_price'];
                            $all_date_prices_html[$start_time->format('Ymd')] = '<span class="day_price">' . $start_time->format('F d') . ' - ' .  $p['pixad_auto_price_season_price'] . get_woocommerce_currency_symbol() . '</span>';

                        }

                    }
                    $start_time->modify('+ 1 day');
                    $i++;
                endwhile;

                $j = 1;
                while ($j <= $cart_item['quantity']):
                    if(empty($all_date_prices[$start_time_price_in_day->format('Y-m-d')]) && !isset($all_date_prices[$start_time_price_in_day->format('Y-m-d')])){
                        $all_date_prices[$start_time_price_in_day->format('Y-m-d')] = $price_in_day;
                        $all_date_prices_html[$start_time_price_in_day->format('Ymd')] = '<span class="day_price">' . $start_time_price_in_day->format('F d') . ' - ' .  $price_in_day . get_woocommerce_currency_symbol() . '</span>';
                    }
                    $start_time_price_in_day->modify('+ 1 day');
                    $j++;
                endwhile;

                $season_price_total = 0;
                $k = 1;
                while ($k <= $cart_item['quantity']):
                    $season_price_total += $all_date_prices[$start_time_total->format('Y-m-d')];
                    $start_time_total->modify('+ 1 day');
                    $k++;
                endwhile;
                //$price = '<span class="my_price">' . $price . get_woocommerce_currency_symbol() . '</span>' . $all_date_prices_html;
                //$price =  $all_date_prices_html;
                ksort($all_date_prices_html);

                foreach ($all_date_prices_html as $key => $val){
                    $all_date_prices_html_res .= $val;
                }
                $price = $all_date_prices_html_res;
            } else {
                $price = wc_price($price);
            }

        }


        return $price;
    }

    public static function get_discount_total($new = false)
    {
        if(!empty(self::$discount) && $new){
            return self::$discount;
        }

        $discount = 0;
        $extra_price = 0;
        $on_discount = self::get_setting('is_discount');
        $is_discount_all_days = self::get_setting('is_discount_all_days');
        if(!empty($on_discount) ){
            $quantity = 0;
            $items =  WC()->cart->get_cart();
            $item_count = count($items);
            $discount_data = [];
            // 1 product = auto

            if($item_count === 1){
                // discount
                if(empty($is_discount_all_days)){

                    foreach ( $items as $hash => $cart_item ) {
                        $price_in_day = $cart_item['data']->get_price();
                        if(  $cart_item['product_id'] !== self::$settings['woo_id_product'] ) {
                            $discount_data['start'] = $cart_item['pixba_booking']['Start time'];
                            $discount_data['end'] = $cart_item['pixba_booking']['Finish time'];
                            $discount_data['quantity'] = $cart_item['quantity'];
                            $discount_data['auto_id'] = $cart_item['pixba_booking']['auto_id'];
                        }
                    }

                    $use_discounts = self::get_discounts_arr($discount_data);

                    usort($use_discounts, array('Pixad_Booking_AUTO','sort_discounts'));

                    $pre_day = 0;

                    $k = 0;
                    $len = count($use_discounts);
                    foreach ($use_discounts as $key => $use_discount) {
                        if ($k == 0) {
                            $discount_percent = $use_discount['percent'];
                            $discount_day = intval( $use_discount['day']);
                            $discount_quantity = $discount_data['quantity']; // - $discount_day + 1 -$pre_day
                            $discount += $discount_quantity *  $price_in_day  * $discount_percent/100;
                            $pre_day = $discount_data['quantity'] - $discount_day + 1;
                        }
                        $k++;
                    }
                }
            }
        }
        self::$discount = $discount;
        return self::$discount;

    }
    //woo измениь поле количество в корзине
    public static function woo_cart_item_quantity($product_quantity, $cart_item_key, $cart_item)
    {

        if (!empty($cart_item['pixba_booking'])) {

            if (intval($cart_item['quantity']) > 0) {

             

                if(self::is_show_time()){
                    $discount = self::get_discount_total(true);

                    $html_out = '';
                    $on_discount = self::get_setting('is_discount');
                    $pixba_hide_time = !self::is_show_time();
                    $pixba_settings     = get_option('pixba_settings', []);
                    $discounts = !empty($pixba_settings['discounts']) ? $pixba_settings['discounts'] : [];

                    $discount_html = self::get_desc_discont_html(['discounts' => $discounts, 'on_discount' => $on_discount, 'pixba_hide_time' => $pixba_hide_time]);
                    if(!empty($discount)){
                        $discount_woo = esc_html( get_woocommerce_currency_symbol(). $discount);
                        $discount_html = '<span class="booking-price-info">'.sprintf( self::$strings['you_discount'], $discount_woo ).'</span>';
                    }
                    if(isset($cart_item['pixba_booking']['price_in_hour']) && $cart_item['pixba_booking']['price_in_hour'] != ' '&& $cart_item['pixba_booking']['price_in_hour'] != NULL){
                        if (isset($cart_item['pixba_booking']['price_in_hour_text']) && $cart_item['pixba_booking']['price_in_hour_text'] != ''){
                            $price_in_hour_text = $cart_item['pixba_booking']['price_in_hour_text'];
                            $html_out = $price_in_hour_text;
                        }
                    } else {
                        $html_out =  $cart_item['quantity'] . __(' Day(s)', 'pixba')
                            .'<br/>'.$discount_html;
                    }



                    return $html_out;
                }else{

                    return $cart_item['quantity'];
                }


            }
        }

        return $product_quantity;
    }
    //Html для кастомного свойства woo
    public static function field_check_form($field)
    {
        $title_field = '';
        foreach (self::$settings['data_select_type'] as $key => $sett_field) {
            if ($sett_field['opt'] == $field['opt']) {
                $title_field = $sett_field['title'];
            }
        }

        ?>
<?php
        if(isset($field['icon']) && $field['icon'] != ''){
            echo '<span class="extra_service_category_icon ' . $field['icon'] . '"></span>';
        }
        if(isset($field['category']) && $field['category'] != ''){
            echo '<span class="extra_service_category">' . $field['category'] . '</span>';
        }

        ?>
<div class="extra_service_title_item">
    <div class="extr-left">
        <input name="booking-field[<?php echo $field['key']; ?>]" type="checkbox" value="<?php echo $field['val']; ?>">
        <?php
                    if (function_exists('icl_register_string')) {
                        echo apply_filters( 'wpml_translate_single_string', $field['name'], 'pixba', $field['name']);
                    }else{
                        echo $field['name'];
                    }
                    ?>
        </input>
    </div>
    <div class="extr-right">
        <div class="resource">
            <span class="dur_price">
                <span class="woocommerce-Price-amount amount">
                    <span class="woocommerce-Price-currencySymbol">
                        <?php echo get_woocommerce_currency_symbol(); ?>
                    </span>
                    <?php echo $field['val']; ?>
                </span>
            </span>
            <span class="slash">
                /
            </span>
            <span class="dur_val">
            </span>
            <span class="dur_type">
                <?php echo __($title_field, 'pixba'); ?>
            </span>
        </div>
    </div>
</div>

<?php
    }
    public static function field_check_form_front($field)
    {
        $title_field = '';
        foreach (self::$settings['data_select_type'] as $key => $sett_field) {
            if ($sett_field['opt'] == $field['opt']) {
                $title_field = $sett_field['title'];
            }
        }

        ?>
<?php
        if(isset($field['icon']) && $field['icon'] != ''){
            echo '<span class="extra_service_category_icon ' . $field['icon'] . '"></span>';
        }
        if(isset($field['category']) && $field['category'] != ''){
            echo '<span class="extra_service_category">' . $field['category'] . '</span>';
        }

        ?>
<div class="extra_service_title_item">
    <div class="extr-left">
        <?php  $id_text = self::slugify($field['key']); ?>
        <input name="booking-field[<?php echo $field['key']; ?>]" class="booking-field-extra" type="checkbox" data-name="<?php echo $id_text; ?>" value="<?php echo $field['val']; ?>">
        <?php
                    if (function_exists('icl_register_string')) {
                        echo apply_filters( 'wpml_translate_single_string', $field['name'], 'pixba', $field['name']);
                    }else{
                        echo $field['name'];
                    }
                    ?>
        </input>
    </div>
    <div class="extr-right">
        <div class="resource">
            <span class="dur_price">
                <span class="woocommerce-Price-amount amount">
                    <span class="woocommerce-Price-currencySymbol">
                        <?php echo get_woocommerce_currency_symbol(); ?>
                    </span>
                    <?php echo $field['val']; ?>
                </span>
            </span>
            <span class="slash">
                /
            </span>
            <span class="dur_val">
            </span>
            <span class="dur_type">
                <?php echo __($title_field, 'pixba'); ?>
            </span>
        </div>
    </div>
</div>
<?php
    }

    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public static function field_check_form_hidden($field)
    {
        $id_text = self::slugify($field['key']);
        ?>

<input name="booking-field[<?php echo $field['key']; ?>]" class="pixba_booking_extra_hidden" id="pixba_booking_extra_hidden_<?php echo $id_text; ?>" type="checkbox" value="<?php echo $field['val']; ?>" />

<?php
    }
    public static function all_check_field()
    {
        $custom_fields = get_option('pixba_custom_fields');

        if(isset($custom_fields) && !empty($custom_fields)){
            $count_fields = count($custom_fields);
            if($count_fields > 10){
                if(is_array($custom_fields))
                    $e = 1;
                foreach ($custom_fields as $key => $field) {
                    if ($e == 1){
                        echo '<a data-toggle="modal" data-target="#single-pixad-extra-modal">' . __('Add Extra Resource', 'pixba') . '<span id="extra_checked_count"></span></a>';

                    }
                    self::field_check_form_hidden($field);
                    $e++;
                }
            } else {

                if(is_array($custom_fields))
                    $category ='';
                $icon ='';
                foreach ($custom_fields as $key => $field) {

                   if(isset($field['category'])){
                        if ( $category == $field['category']){
                            $field['category'] = '';
                        } else {
                            $category = $field['category'];
                        }
                   }
                    if(isset($field['icon'])){
                        if ( $icon == $field['icon']){
                            $field['icon'] = '';
                        } else {
                            $icon = $field['icon'];
                        }
                    }
                    self::field_check_form($field);
                }
            }
        }

    }
    public static function show_notice()
    {
        foreach (self::$settings['notice'] as $key => $notice) {
            echo '<div class="booking-notice">' . $notice . '</div>';
        }
    }
    public static function get_desc_discont_html($args = [])
    {
        extract($args);
        $is_discount_all_days = self::get_setting('is_discount_all_days');
        $is_show = self::get_setting('is_show_discount_info');
        $discount_html = '';
        $pixba_auto_discount = get_post_meta( get_the_ID(), 'pixba_auto_discount', true );

        if(!empty($discounts) && !empty($on_discount) && $is_show ){
            $percent = $discounts[0]['percent'];
            $day = $discounts[0]['day'];
            if(empty($is_discount_all_days)){
                foreach ($discounts as $key => $discount) {
                    $discount_name = $discount['percent'] . '-' . $discount['day'];
                    if(isset($pixba_auto_discount[0]) && !empty($pixba_auto_discount[0])){
                        if ($pixba_auto_discount[0] == $discount_name){
                            if(empty($discount['desc'])){
                                $discount_html .= '<span class="booking-price-info"> Save Up '.$discount['percent'].'%  to rental from '.$discount['day'].' days </span>';
                            }else{
                                $discount_html .= '<span class="booking-price-info">'.esc_html($discount['desc']).'</span>' ;
                            }
                        }
                    } else {
                        if(empty($discount['desc'])){
                            $discount_html .= '<span class="booking-price-info"> Save Up '.$discount['percent'].'%  to rental from '.$discount['day'].' days </span>';
                        }else{
                            $discount_html .= '<span class="booking-price-info">'.esc_html($discount['desc']).'</span>' ;
                        }
                    }

                }

            }else{

                foreach ($discounts as $key => $discount) {
                    if(empty($discount['desc'])){
                        $discount_html .= '<span class="booking-price-info"> Save Up '.$discount['percent'].'%  to rental on '.$discount['day'].' days </span>';
                    }else{
                        $discount_html .= '<span class="booking-price-info">'.esc_html($discount['desc']).'</span>' ;
                    }
                }
            }

        }

        return $discount_html;
    }
    public function theme_booking_form_auto($post)
    {
        $on_discount = self::get_setting('is_discount');
        $auto_id_s = $post->ID;
        $Auto = new PIXAD_Autos();
        $Auto->Query_Args( array('auto_id' => $post->ID) );
        $pixba_style = get_option('pixba_style');
        $pixba_hide_time = !self::is_show_time();
        $pixba_hide_location = !self::is_show_location();
        $pixba_hide_timepicker = !self::is_show_timepicker();
        $pixba_settings     = get_option('pixba_settings', []);
        $discounts = !empty($pixba_settings['discounts']) ? $pixba_settings['discounts'] : [];
        $discount_html = self::get_desc_discont_html(['discounts' => $discounts, 'on_discount' => $on_discount, 'pixba_hide_time' => $pixba_hide_time]);
        $custom_price_car_page = get_post_meta( $post->ID, 'custom_price_car_page', 1 );
        $price_car_page = $custom_price_car_page ? $custom_price_car_page : $Auto->get_price();
        $price_to_check =  $custom_price_car_page ? $custom_price_car_page : $Auto->get_meta('_auto_price');
        if(isset($price_to_check) && $price_to_check == ''){
            $price_car_page_css = 'no_price';
        } else {
            $price_car_page_css = '';
        }


        $Settings = new PIXAD_Settings();
        $options = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
        $currency = pixad_get_currencies($options['autos_site_currency']);
        $currentTime = new DateTime();
        $pixad_auto_price_season = get_post_meta($post->ID, 'pixad_auto_price_season', []);
        foreach ($pixad_auto_price_season as $key => $price){
            foreach ($price as $p){

                $date_start = DateTime::createFromFormat('Y-m-d', $p['pixad_auto_price_season_start']);
                $date_end = DateTime::createFromFormat('Y-m-d', $p['pixad_auto_price_season_end']);
                $date_start->getTimestamp();
                $date_end->getTimestamp();
                $currentTime->getTimestamp();

                if (($date_start <= $currentTime) && ($currentTime <= $date_end)) {
                    $price_car_page = $currency['symbol'].$p['pixad_auto_price_season_price'] . __('/per day', 'pixba');
                    $price_car_page .= '<span class="price_description">'. __('Price from ', 'pixba') . $date_start->format('d F') . __(' to ', 'pixba') . $date_end->format('d F') . '</span>';
                }
            }
        }


        ?>
<div class="booking_form <?php echo esc_attr($price_car_page_css)?>" id="booking_form">
    <?php if ($pixba_style != 'popup') : ?>
    <span class="car-details__price-inner"><?php echo wp_kses_post($price_car_page); ?></span>
    <?php endif; ?>
    <h3 class="booking_form_title"><?php echo self::$strings['booking_title_page']; ?></h3>
    <?php
            foreach (self::$settings['notice'] as $key => $notice) {
                echo '<div class="booking-notice">' . __( $notice, 'pixba') . '</div>';
            }
            global $wp
            ?>
    <form class="form booking-auto-form" data-mesg_required="This field is required." enctype="multipart/form-data" id="booking_form" method="post" novalidate="novalidate">

        <div class="wrap_fields">
            <?php
                    // location
                    if(self::is_show_location()){ ?>
            <?php
                        $location_pick = get_post_meta( $post->ID, 'pixad_auto_location_pick', true );
                        $location_drop = get_post_meta( $post->ID, 'pixad_auto_location_drop', true );
                        $locations = get_option('pixba_locations');

                        //With Coordinates
                        $location_pick_with_coordinates = get_post_meta( $post->ID, 'pixad_auto_location_pick_with_coordinates', true );
                        $location_drop_with_coordinates = get_post_meta( $post->ID, 'pixad_auto_location_drop_with_coordinates', true );
                        $locations_with_coordinates = get_option('pixba_locations_with_coordinates');

                        if(isset($location_pick_with_coordinates) && !empty($location_pick_with_coordinates)){
                            foreach ($location_pick_with_coordinates as $pick){
                                if(isset($pick['name']) && !empty($pick['name']) && $pick['name'] != ''){
                                    $name_pick[] = $pick['name'];
                                }
                            }
                        }

                        if(isset($location_drop_with_coordinates) && !empty($location_drop_with_coordinates)){
                            foreach ($location_drop_with_coordinates as $local){
                                if(isset($local['name']) && !empty($local['name']) && $local['name'] != ''){
                                    $name_drop[] = $local['name'];
                                }
                            }
                        }
                        ?>
            <?php if(!empty($location_pick_with_coordinates) && !empty($location_drop_with_coordinates)) {
                            ?>
            <div class="rb_field">
                <label><?php  echo __(self::$strings['start_location_title_page'], 'pixba'); ?></label>
                <select class="required" name="booking[Start location]">
                    <option value="">
                        <?php esc_html_e( 'Select Location', 'pixba' ) ?>
                    </option>

                    <?php
                                    if(!empty($name_pick)){
                                        foreach ($location_pick_with_coordinates as $key => $local) {
                                            $pick_name = $local['name'];
                                            if(isset($pick_name) && $pick_name!=''){
                                                echo '<option value="' . $local['name']. '">';
                                                if (function_exists('icl_register_string')) {
                                                    echo apply_filters( 'wpml_translate_single_string', $local['name'], 'pixba', $local['name']);
                                                }else{
                                                    echo $local['name'];
                                                }
                                                echo'</option>';
                                            }
                                        }
                                    } elseif(empty($name_pick)) {
                                        foreach ($locations_with_coordinates as $key => $local) {
                                            if(isset($local['name']) && $local['name'] !='' && !empty($local['name'])){
                                                echo '<option value="' . $local['name']. '">';
                                                if (function_exists('icl_register_string')) {
                                                    echo apply_filters( 'wpml_translate_single_string', $local['name'], 'pixba', $local['name']);
                                                }else{
                                                    echo $local['name'];
                                                }
                                                echo'</option>';
                                            }
                                        }
                                    } elseif(!empty($location_pick)) { ?>
                    <?php
                                        foreach ($location_pick as $key => $local) {
                                            echo '<option value="' . $local . '">';
                                            if (function_exists('icl_register_string')) {
                                                echo apply_filters( 'wpml_translate_single_string', $local, 'pixba', $local);
                                            }else{
                                                echo $local;
                                            }
                                            echo'</option>';
                                        }
                                        ?>
                    <?php } elseif(!empty($locations)) { ?>
                    <?php
                                        foreach ($locations as $key => $local) {
                                            echo '<option value="' . $local . '">';
                                            if (function_exists('icl_register_string')) {
                                                echo apply_filters( 'wpml_translate_single_string', $local, 'pixba', $local);
                                            }else{
                                                echo $local;
                                            }
                                            echo'</option>';
                                        }
                                        ?>
                    <?php } ?>
                </select>
            </div>
            <div class="rb_field">
                <label><?php  echo __( self::$strings['finish_location_title_page'], 'pixba'); ?></label>
                <select class="required" name="booking[Finish location]">
                    <option value="">
                        <?php esc_html_e( 'Select Location', 'pixba' ) ?>
                    </option>
                    <?php
                                    if(!empty($name_drop)){
                                        foreach ($location_drop_with_coordinates as $key => $local) {
                                            $pick_name = $local['name'];
                                            if(isset($pick_name) && $pick_name!=''){
                                                echo '<option value="' . $local['name']. '">';
                                                if (function_exists('icl_register_string')) {
                                                    echo apply_filters( 'wpml_translate_single_string', $local['name'], 'pixba', $local['name']);
                                                }else{
                                                    echo $local['name'];
                                                }
                                                echo'</option>';
                                            }
                                        }
                                    } elseif(empty($name_drop)) {
                                        foreach ($locations_with_coordinates as $key => $local) {
                                            if(isset($local['name']) && $local['name'] !='' && !empty($local['name'])){
                                                echo '<option value="' . $local['name']. '">';
                                                if (function_exists('icl_register_string')) {
                                                    echo apply_filters( 'wpml_translate_single_string', $local['name'], 'pixba', $local['name']);
                                                }else{
                                                    echo $local['name'];
                                                }
                                                echo'</option>';
                                            }
                                        }
                                    } elseif(!empty($location_drop)) { ?>
                    <?php
                                        foreach ($location_drop as $key => $local) {
                                            echo '<option value="' . $local . '">';
                                            if (function_exists('icl_register_string')) {
                                                echo apply_filters( 'wpml_translate_single_string', $local, 'pixba', $local);
                                            }else{
                                                echo $local;
                                            }
                                            echo'</option>';
                                        }
                                        ?>
                    <?php } else { ?>
                    <?php
                                        foreach ($locations as $key => $local) {
                                            echo '<option value="' . $local . '">';
                                            if (function_exists('icl_register_string')) {
                                                echo apply_filters( 'wpml_translate_single_string', $local, 'pixba', $local);
                                            }else{
                                                echo $local;
                                            }
                                            echo'</option>';
                                        }
                                        ?>
                    <?php } ?>
                    ?>
                </select>
            </div>
            <?php } else { ?>
            <div class="rb_field">
                <label><?php  echo __( self::$strings['start_location_title_page'], 'pixba'); ?></label>
                <select class="required" name="booking[Start location]">
                    <option value="">
                        <?php esc_html_e( 'Select Location', 'pixba' ) ?>
                    </option>
                    <?php
                                    foreach ($locations as $key => $local) {
                                        echo '<option value="' . $local . '">';
                                        if (function_exists('icl_register_string')) {
                                            echo apply_filters( 'wpml_translate_single_string', $local, 'pixba', $local);
                                        }else{
                                            echo $local;
                                        }
                                        echo'</option>';
                                    }
                                    ?>
                </select>
            </div>
            <div class="rb_field">
                <label><?php  echo __( self::$strings['finish_location_title_page'], 'pixba'); ?></label>
                <select class="required" name="booking[Finish location]">
                    <option value="">
                        <?php esc_html_e( 'Select Location', 'pixba' ) ?>
                    </option>
                    <?php
                                    foreach ($locations as $key => $local) {
                                        echo '<option value="' . $local . '">';
                                        if (function_exists('icl_register_string')) {
                                            echo apply_filters( 'wpml_translate_single_string', $local, 'pixba', $local);
                                        }else{
                                            echo $local;
                                        }
                                        echo'</option>';
                                    }
                                    ?>
                </select>
            </div>
            <?php } ?>
            <?php
                    } //end location

                    // time
                    if(self::is_show_time()){

                        $work_days = get_option('pixba_work_days');
                        $work_time = get_option('pixba_work_time');
                        $min_date = get_option('pixba_min_date');

                        if (!self::is_show_end_time()) {
                            $class_end_time = 'hide_end_time';
                        } else {
                            $class_end_time = '';
                        }
                        ?>
            <div class="rb_field">
                <label><?php  echo __( self::$strings['start_date_title_page'], 'pixba'); ?></label>
                <input type="text" name="booking[Start time]" placeholder="<?php esc_html_e( 'Select date', 'pixba' )?>" value="" id="datetimepicker_simple" data-min_date="<?php echo $min_date ?>" data-work_days="<?php echo $work_days; ?>" data-work_time="<?php echo $work_time; ?>" autocomplete="off" readonly>
                <input type="hidden" id="pixad_format_date" value="<?php echo self::$settings['date_format'];?>">

            </div>
            <div class="rb_field <?php esc_attr_e($class_end_time); ?>">
                <label><?php echo __( self::$strings['finish_date_title_page'], 'pixba'); ?></label>
                <input type="text" class="<?php esc_attr_e($class_end_time); ?>" name="booking[Finish time]" placeholder="<?php esc_html_e( 'Select date', 'pixba' )?>" value="" id="datetimepicker_end" autocomplete="off" readonly>
            </div>
            <?php
                        $pixad_auto_price_in_hour = get_post_meta( $post->ID, 'pixad_auto_price_in_hour', true );
                        $pixad_auto_price_in_hour_text = get_post_meta( $post->ID, 'pixad_auto_price_in_hour_text', true );
                        $t = 1;
                        ?>
            <script>
                jQuery.noConflict()(function($) {
                    jQuery(".hours_price_title_contain input").on("click", function() {
                        $(".hours_price_title_contain input").not(this).prop("checked", false);
                    });
                });

            </script>
            <div class="hours_price_title_contain">
                <?php while ($t <= 12){ ?>
                <?php if(isset($pixad_auto_price_in_hour[$t]) && $pixad_auto_price_in_hour[$t] != ''){?>
                <div class="hours_price_title_item">
                    <?php if(isset($pixad_auto_price_in_hour[$t]) && $pixad_auto_price_in_hour[$t] != ''){?>
                    <label class="pixad_price_hour" for="pixad_price_<?php echo $pixad_auto_price_in_hour[$t]; ?>">
                        <input type="checkbox" id="pixad_price_<?php echo $pixad_auto_price_in_hour[$t]; ?>" name="pixad_auto_price_in_hour" value="<?php echo $pixad_auto_price_in_hour[$t]; ?>">
                        <?php if(isset($pixad_auto_price_in_hour_text[$t]) && $pixad_auto_price_in_hour_text[$t] != ''){ ?>
                        <span class="pixad_auto_price_in_hour_text"><?php echo $pixad_auto_price_in_hour_text[$t];?></span>
                        <input type="hidden" name="pixad_auto_price_in_hour_text_<?php echo $pixad_auto_price_in_hour[$t]; ?>" value="<?php echo $pixad_auto_price_in_hour_text[$t];?>" />
                        <?php } ?>
                        <span class="pixad_tire"><?php //echo esc_attr(' - ');?></span>
                        <span class="pixad_auto_price_in_hour"><?php echo get_woocommerce_currency_symbol(); ?><?php echo $pixad_auto_price_in_hour[$t]; ?></span>
                    </label>
                    <?php } ?>
                </div>
                <?php } ?>
                <?php $t++; } ?>
            </div>

            <?php } // if pixba_hide_time ?>

            <div class="pixba_contact_modal">
                <?php $pixad_auto_booking_contact_btn_text = get_post_meta( $post->ID, 'pixad_auto_booking_contact_btn_text', true ); ?>
                <?php if (isset($pixad_auto_booking_contact_btn_text) && $pixad_auto_booking_contact_btn_text != ''){ ?>
                <a class="pixba_contact_modal_btn" data-toggle="modal" data-target="#single-pixad-autos-modal">
                    <?php echo esc_attr($pixad_auto_booking_contact_btn_text, 'pixba');?>
                </a>
                <?php } ?>
            </div>

            <?php if(self::is_show_timepicker()){ ?>
            <input type="hidden" id="booking_timepicker" value="1">
            <?php }?>
        </div>
        <?php echo $discount_html; ?>
        <div class="extra_service">
            <?php $custom_fields = get_option('pixba_custom_fields');
                    if(is_array($custom_fields)){
                        $custom_fields_count =  count($custom_fields);
                    }
                    ?>
            <?php if (isset($custom_fields_count)) { ?>
            <?php if ($custom_fields_count < 10) { ?>
            <h3 class="extra_service_title"><?php echo __( self::$strings['custom_fields_name'], 'pixba'); ?></h3>
            <?php } ?>
            <?php } ?>
            <div class="ovacrs_resource">
                <?php self::all_check_field();?>

            </div>
        </div>
        <input name="auto_id" type="hidden" value="<?php echo $auto_id_s ?>" />
        <input name="booking_auto" type="hidden" value="1" />
        <input name="add-to-cart" type="hidden" value="1" />
        <button class="submit btn_tran" type="submit">
            <?php
                    if (function_exists('icl_register_string')) {
                        echo apply_filters( 'wpml_translate_single_string', self::get_order_button_title(), 'pixba', self::get_order_button_title());
                    }else{
                        esc_html_e( self::get_order_button_title() );
                    }
                    ?>
        </button>

    </form>

</div>
<?php

    }


    // Preview Calendar
    // Вывод(themename)_preview_calendar
    public function theme_booking_preview_calendar($post = null, $booking_preview_function ='') {
        $id_auto =$html_class='';
        if($post != null){
            $id_auto = $post;
        }
        $boounctions = $booking_preview_function;
        if($boounctions !=''){
            $booking_preview = 'enable';
        } else {
            $booking_preview = 'disable';
        }
        $last_child = array_keys(self::get_order_time($id_auto));
        $last_key = end($last_child);
        $calendar_array_data = '[';
        foreach (self::get_order_time($id_auto) as $key => $period) {
            if( $last_key == $key ){
                if(isset($period['finish-time']) && $period['finish-time'] !='' && $period['finish-time'] != esc_html__( 'Select date', 'pixba' )){
                    $calendar_array_data .= '{"start": "'.$period['start-time'].'",  "end": "'.$period['finish-time'].'"}';
                } else {
                    $calendar_array_data .= '{"start": "'.$period['start-time'].'"}';
                }
            } else {
                if(isset($period['finish-time']) && $period['finish-time'] !='' && $period['finish-time'] != esc_html__( 'Select date', 'pixba' )) {
                    $calendar_array_data .= '{"start": "' . $period['start-time'] . '",  "end": "' . $period['finish-time'] . '"},';
                }else{
                    $calendar_array_data .= '{"start": "'.$period['start-time'].'"},';
                }
            }
        }

        $pixad_calendar_show = get_post_meta( $post, 'pixba_calendar_view' );
        if(!empty(self::get_order_time($id_auto))){
            $html_class ='';
        } else {
            if($pixad_calendar_show[0]  == 'show'){
                $html_class ='preview-calendar';
            }
        }
        $calendar_array_data .= ']';


        ?>
<!-- CALENDAR -->
<?php if(!empty(self::get_order_time($id_auto) && $pixad_calendar_show[0] == 'show')) { ?>
<?php

            ?>
<section class="widget">
    <h3 class="widget-title"><?php esc_html_e( 'Booking calendar', 'pixba' ) ?></h3>
    <div class="decor-1"></div>
    <div class="widget-content">
        <input id="pixad_date_format_calendar" type="hidden" value="<?php echo  date('H:i ' .get_option('date_format'))?>">
        <input id="pixad_calendar_lang" type="hidden" value="<?php echo get_locale()?>">

        <section class="widget-post1 clearfix">
            <div class="calendar-wrap cf">
                <div class="booking-preview-calendar <?php echo $html_class;?>"></div>
                <div class="reverved-preview">
                    <div class="preview-booking"></div>
                    <span><?php esc_html_e( 'Reserved', 'pixba' ) ?></span>
                </div>
                <input type="hidden" id="booking-calendar-data" value='<?php print_r($calendar_array_data);?>' />
            </div>
        </section>
    </div>
</section>


<?php } ?>
<!-- CALENDAR End-->
<?php

    }


    public static function calendar_view($post)
    {
        ?>
<div class="pixba-calendar__wrapper">
    <input type="text" name="" value="<?php echo current_time(get_option('date_format')); ?>" id="datetimepicker_calenda " style="display: none;">
</div>
<?php
    }
    public static function render_metabox($post)
    {

        ?>
<table class="form-table company-info">

    <tr>
        <th>
            Адреса компании <span class="dashicons dashicons-plus-alt add-company-address"></span>
        </th>
        <td class="company-address-list">
            <?php
                    $input = '
                    <span class="item-address">
                        <input type="text" name="' . 'optnew' . '[]" value="%s">
                        <span class="dashicons dashicons-trash remove-company-address"></span>
                    </span>
                    ';

                    $addresses = get_post_meta($post->ID, 'optnew', true);

                    if (is_array($addresses)) {
                        foreach ($addresses as $addr) {
                            printf($input, esc_attr($addr));
                        }
                    } else {
                        printf($input, '');
                    }
                    ?>
        </td>
    </tr>

</table>

<?php
    }
    public static function woo_quantity_input_args($arg, $product)
    {
        return $arg;
    }
    //добавить атрбуты к продукту
    public static function wcproduct_set_attributes($post_id, $attributes)
    {
        $product            = wc_get_product($post_id);
        $old_attributes     = $product->get_attributes();
        $product_attributes = [];
        foreach ($old_attributes as $name => $value) {
            $product_attributes[] = array(
                'name'         => htmlspecialchars(stripslashes($name)), // set attribute name
                'value'        => $value, // set attribute value
                'position'     => 1,
                'is_visible'   => 1,
                'is_variation' => 1,
                'is_taxonomy'  => 0,
            );
        }
        foreach ($attributes as $name => $value) {
            $product_attributes[] = array(
                'name'         => htmlspecialchars(stripslashes($name)), // set attribute name
                'value'        => $value,
                'is_visible'   => 1,
                'is_variation' => 1,
                'is_taxonomy'  => 0,
            );
        }
        update_post_meta($post_id, '_product_attributes', $product_attributes);
    }
    public static function pixba_plugin_textdomain()
    {
        load_plugin_textdomain('pixba', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }
    public static function print_script_add( ) {

        global $post;
        $pixba_format_date = get_option('pixba_format_date');
        if(!empty($post)){

            if ( function_exists('icl_object_id') ) {
                $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc');
                foreach ($languages as $key) {
                    $id =  apply_filters( 'wpml_object_id', $post->ID, 'post', false, $key['language_code']);
                    $calendar_data = self::get_order_time( $id );
                    if (!empty($calendar_data)) {
                        break;
                    }
                }
            }else{
                $calendar_data = self::get_order_time( $post->ID );
            }
        }else{
            $calendar_data = [];
        }
        if(isset($calendar_data) && !empty($calendar_data)){
            foreach ($calendar_data as $c){
                if (isset($c['start-time']) && $c['start-time']!='' && isset($c['finish-time']) && $c['finish-time']!=''){
                    $start_date_str = strtok($c['start-time'], ' ');
                    $finish_date_str = strtok($c['finish-time'], ' ');
                    if($pixba_format_date == 'm/j/Y'){
                        $start_date_str = self::pixba_change_format_two($start_date_str);
                        $finish_date_str = self::pixba_change_format_two($finish_date_str);
                    }

                    $start_date =  new DateTime(self::pixba_change_format_to_booked_days($start_date_str));
                    $end_date = new DateTime(self::pixba_change_format_to_booked_days($finish_date_str));

                    $period = new DatePeriod(
                        $start_date,
                        new DateInterval('P1D'),
                        $end_date
                    );
                    foreach ($period as $key => $value) {
                        if($pixba_format_date == 'm/j/Y'){
                            $calendar_data_new[] = $value->format('m/j/Y');
                        } elseif ($pixba_format_date == 'j/m/Y'){
                            $calendar_data_new[] = $value->format('j/m/Y');
                        }
                    }
                    if($pixba_format_date == 'm/j/Y'){
                        $calendar_data_new[] = $end_date->format('m/j/Y');
                    } elseif ($pixba_format_date == 'j/m/Y'){
                        $calendar_data_new[] = $end_date->format('j/m/Y');
                    }


                }else{
                    $calendar_data_new = '';
                }
            }
        }else{
            $calendar_data_new = [];
        }




        ?>
<script type="text/javascript">
    var pixbaBookedDay = JSON.parse('<?php print json_encode($calendar_data) ?>');

</script>
<script type="text/javascript">
    var pixbaBookedDayNew = JSON.parse('<?php print json_encode($calendar_data_new) ?>');

</script>
<?php
    }
    //получить Id заказов бронирования авто
    public static function get_orders_ids($order_status = array('wc-processing', 'wc-on-hold')){
        global $wpdb;
        $product_id = self::$settings['woo_id_product'];
        $results = $wpdb->get_col(" 
         SELECT order_items.order_id 
         FROM {$wpdb->prefix}woocommerce_order_items as order_items 
         LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id 
         LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID 
         WHERE posts.post_type = 'shop_order' 
         AND posts.post_status IN ('" . implode("','", $order_status) . "') 
         AND order_items.order_item_type = 'line_item' 
         AND order_item_meta.meta_key = '_product_id' 
         AND order_item_meta.meta_value = '$product_id' 
        ");

        return $results;
    }
    // получить все периоды бронироания авто
    public static function get_order_time($curent_auto_id)
    {
        $calendar = [];
        $orders_ids = self::get_orders_ids();
        $pixba_min_date = get_option('pixba_min_date', true);
        foreach ($orders_ids as  $order_id) {
            $order = wc_get_order( $order_id );
            foreach( $order->get_items() as $item_id => $item_product ){
                $start_time_text = __('Start time', 'pixba');
                $start_time = $item_product->get_meta( $start_time_text, true );
                $finish_time_text = __('Finish time', 'pixba');
                $finish_time = $item_product->get_meta( $finish_time_text, true );
                $auto_id = $item_product->get_meta( 'auto_id', true );
                if(!empty($start_time) && !empty($finish_time) && $curent_auto_id == $auto_id){

                    if(intval($pixba_min_date) != 0 && $pixba_min_date != ''){
                        if(self::is_show_timepicker()){
                            $format_opt = get_option('pixba_format_date', true);
                            if(isset($format_opt) && $format_opt != ''){
                                $format = $format_opt . ' H:i';
                            } else {
                                $format = 'm/d/Y H:i';
                            }
                        } else {
                            $format_opt = get_option('pixba_format_date', true);
                            if(isset($format_opt) && $format_opt != ''){
                                $format = $format_opt;
                            } else {
                                $format = 'm/d/Y';
                            }
                        }
                        $finish = DateTime::createFromFormat($format, $finish_time);

                        $finish->modify('+'.$pixba_min_date.' day');
                        $calendar[] = ['start-time' => $start_time, 'finish-time' => $finish->format($format)];
                    } else {
                        $calendar[] = ['start-time' => $start_time, 'finish-time' => $finish_time];
                    }



                }



            }
        }
        return $calendar;
    }
    public static function get_orders_periods()
    {
        $calendar = [];
        $orders_ids = self::get_orders_ids();
        foreach ($orders_ids as  $order_id) {
            $order = wc_get_order( $order_id );
            foreach( $order->get_items() as $item_id => $item_product ){
                $start_time = $item_product->get_meta( 'Start time', true );
                $finish_time = $item_product->get_meta( 'Finish time', true );
                $auto_id = $item_product->get_meta( 'auto_id', true );
                if(!empty($start_time) && !empty($finish_time)){
                    $calendar[$auto_id][$order->get_id()] = ['start-time' => $start_time, 'finish-time' => $finish_time];
                }
            }
        }
        return $calendar;
    }
    public static function in_period_autos($filter_period)
    {

        $equal_period = [];
        $autos_periods = self::get_orders_periods();
        // return $autos_periods;
        foreach ($autos_periods as $id_auto => $order) {
            foreach ($order as $key => $period) {

                $t1_equally = strtotime($period['start-time']) == strtotime($filter_period['finish-time']);
                $t2_equally = strtotime($period['finish-time']) == strtotime($filter_period['start-time']);
                $t1 = strtotime($period['start-time']) < strtotime($filter_period['start-time']);
                $t2 = strtotime($period['start-time']) < strtotime($filter_period['finish-time']);
                $t3 = strtotime($period['finish-time']) < strtotime($filter_period['start-time']);
                $t4 = strtotime($period['finish-time']) < strtotime($filter_period['finish-time']);
                // есть смежные даты бронирования
                if($t1_equally || $t2_equally){
                    $equal_period[] = $id_auto . '';
                }else{
                    // есть в брони
                    if( ( ($t1 ^ $t2) ||  ($t3 ^ $t4) )  ){
                        //   if( ( ($t1 && $t2) &&  ($t3 && $t4) )  ){
                        $equal_period[] = $id_auto . '';
                        break;
                    }
                }
            }
        }
        return $equal_period;
    }

    public static function valid_period_to_order($cart_item_data, $id_auto)
    {
        foreach (self::get_order_time($id_auto) as $key => $period) {

            $t1_equally = strtotime($period['start-time']) == strtotime($cart_item_data['pixba_booking']['Finish time']);
            $t2_equally = strtotime($period['finish-time']) == strtotime($cart_item_data['pixba_booking']['Start time']);
            $t1 = strtotime($period['start-time']) < strtotime($cart_item_data['pixba_booking']['Start time']);
            $t2 = strtotime($period['start-time']) < strtotime($cart_item_data['pixba_booking']['Finish time']);
            $t3 = strtotime($period['finish-time']) < strtotime($cart_item_data['pixba_booking']['Start time']);
            $t4 = strtotime($period['finish-time']) < strtotime($cart_item_data['pixba_booking']['Finish time']);
            // есть смежные даты бронирования
            if($t1_equally || $t2_equally){
            }else{
                // есть в брони
                if( ( ($t1 ^ $t2) ||  ($t3 ^ $t4) )  ){
                    self::$settings['notice'][] = self::$strings['date_is_booked'];
                }
            }
        }
    }
    public static function  woo_cart_item_thumbnail($image, $cart_item, $cart_item_key)
    {
        if(!empty($cart_item['pixba_booking'])){
            $auto_post =    get_post($cart_item['pixba_booking']['auto_id']);
            $thumb = get_the_post_thumbnail( $auto_post->ID, 'thumbnail' );
            if(!empty($thumb)){
                return $thumb;
            }
        }
        return $image;
    }

    public static function woo_admin_order_item_thumbnail($image, $cart_item, $cart_item_key)
    {
        global $post;
        $auto_id = $cart_item_key->get_meta( 'auto_id', true );
        if(!empty($auto_id)){
            $thumb = get_the_post_thumbnail( $auto_id, 'thumbnail' );
            if(!empty($thumb)){
                return $thumb;
            }
        }
        return $image;
    }


    function add_box_custom_price(){
        add_meta_box( 'myplugin_sectionid', esc_attr(self::$strings['box_custom_price']), array($this,'meta_box_box_custom_price'), 'pixad-autos', 'side', 'low' );
    }
    function meta_box_box_custom_price( $post, $meta ){
        $screens = $meta['args'];
        wp_nonce_field( plugin_basename(__FILE__), 'pba-nonce' );
        $catalog = get_post_meta( $post->ID, 'custom_price_catalog', 1 );
        $car_page = get_post_meta( $post->ID, 'custom_price_car_page', 1 );
        echo '<label for="custom_price_catalog">' . esc_attr(self::$strings['custom_price_catalog']) . '</label> ';
        echo '<input type="text" name="custom_price_catalog" value="'. $catalog .'" size="25" /></br>';
        echo '<label for="custom_price_car_page">' . esc_attr(self::$strings['custom_price_car_page']) . '</label> ';
        echo '<input type="text" name="custom_price_car_page" value="'. $car_page .'" size="25" />';
    }
    function save_postdata_box( $post_id ) {

        if (  !isset( $_POST['custom_price_catalog'] ) ||  !isset( $_POST['custom_price_car_page'])) return;
        if ( ! wp_verify_nonce( $_POST['pba-nonce'], plugin_basename(__FILE__) ) )
            return;
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
            return;
        if( ! current_user_can( 'edit_post', $post_id ) )
            return;



        if (  isset( $_POST['custom_price_catalog'] ) ){
            $data = sanitize_text_field( $_POST['custom_price_catalog'] );
            update_post_meta( $post_id, 'custom_price_catalog', $data );
        }
        if (  isset( $_POST['custom_price_car_page'] ) ){
            $data = sanitize_text_field( $_POST['custom_price_car_page'] );
            update_post_meta( $post_id, 'custom_price_car_page', $data );
        }
    }


}

//Radius Function
function pixba_get_distance($latitude1, $longitude1, $latitude2, $longitude2) {
    $earth_radius = 6371;
    $dLat = deg2rad($latitude2 - $latitude1);
    $dLon = deg2rad($longitude2 - $longitude1);
    $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);
    $c = 2 * asin(sqrt($a));
    $d = $earth_radius * $c;
    return $d;
}


if( !function_exists('is_plugin_active') ) {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

}
if (is_plugin_active('woocommerce/woocommerce.php')) {
    $booking = new Pixad_Booking_AUTO;
    $booking->on_include();
}
