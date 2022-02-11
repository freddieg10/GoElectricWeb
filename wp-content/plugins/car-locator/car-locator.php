<?php

/**
 * Plugin Name: Car Locator
 * Description: Locator for Cars
 * Author: Templines
 * Version: 1.5

 */


require 'plugin-update-checker/plugin-update-checker.php';
$MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'http://assets.templines.com/plugins/theme/autozone/car-locator.json',
    __FILE__,
    'car-locator'
); 

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * CAR LOCATOR TEMPLINES
 */
class Car_Locator_Templines
{
    //all strings class
    public static $strings = array();
    //all settings class
    public static $settings = array();

    public function __construct()
    {
        self::init();

        // front
        add_shortcode('car-locator', array(&$this, 'display_map'));
        add_action('wp_enqueue_scripts', array(&$this, 'styles_method'));
        add_action('print_footer_scripts', array(&$this, 'hook_css'));
        add_action('plugins_loaded', array(&$this, 'plugin_textdomain'));
        if (!empty(self::get_setting('is_show'))) {
            add_action('show_car_map', array(&$this, 'display_map'));
            add_action('wp_enqueue_scripts', array(&$this, 'scripts_method'));
        }
        // admin
        add_filter('plugin_action_links', array(&$this, 'plugin_action_links'), 10, 2);
        add_action('admin_menu', array(&$this, 'admin_menu_page'));
        register_activation_hook( __FILE__, array( &$this, 'plugin_activate' ) );
        //Widget
        require_once 'inc/widget/widget_search_by_radius.php';


    }
    public static function init()
    {
        self::$settings = array(
            'general'  => self::get_general_settings(),
            'all_keys' => [
                'google_maps_api_key',
                'is_show',
                'map_zoom',
                'map_lat',
                'map_lng',
                'icon_url',
                'icon_width',
                'icon_height',
                'claster_url',
                'claster_width',
                'claster_height',
                'claster_text_size',
                'map_icon_id',
                'map_css',
                'map_styles',
                'has_activated',
            ],
            'default'  => [
                'icon_url'    => plugins_url('car-locator/img/spotlight.png'),
                'claster_url' => plugins_url('car-locator/img/m1.png'),
                'styles'      => '      /* Always set the map height explicitly to define the size of the div
               * element that contains the map. */
            #clt-maps {
                height: 500px;
              }',
                'map_styles'  => 'json data',
            ],
        );
        // Load class strings.
        self::$strings = array(
            'save'                => __('Save', 'clt_locator'),
            'info_block_summary'  => __('« Summary', 'clt_locator'),
            'info_block_readmore' => __('Read more »', 'clt_locator'),
            'page_plugins_title'  => __('Settings', 'clt_locator'),

            'admin_page'          => [
                'title'                       => __('Car Locator', 'clt_locator'),

                'general_block_title'         => __('Settings Google maps', 'clt_locator'),
                'is_show_title'               => __('Show map', 'clt_locator'),
                'api_key_title'               => __('Google maps api key', 'clt_locator'),
                'map_zoom_title'              => __('Zoom', 'clt_locator'),
                'map_lat_title'               => __('Latitude', 'clt_locator'),
                'map_lng_title'               => __('Longitude', 'clt_locator'),
                'map_icon_title'              => __('Icon', 'clt_locator'),
                'map_icon_width_title'        => __('Icon width', 'clt_locator'),
                'map_icon_height_title'       => __('Icon height', 'clt_locator'),
                'map_claster_title'           => __('Claster', 'clt_locator'),
                'map_claster_width_title'     => __('Claster width', 'clt_locator'),
                'map_claster_height_title'    => __('Claster height', 'clt_locator'),
                'map_css_title'               => __('Styles', 'clt_locator'),
                'map_claster_text_size_title' => __('Сlaster text size', 'clt_locator'),
                'map_icon_button_title'       => __('Select icon', 'clt_locator'),
                'map_styles_title'            => __('Map styles, json data ( create map style on https://mapstyle.withgoogle.com )', 'clt_locator'),
            ],
        );

    }

///////////////////////////////////////////////////////////////////////////////////////////
    /////// inside functions
    ///////////////////////////////////////////////////////////////////////////////////////////
    public static function get_general_settings()
    {
        return get_option('clt_general_settings', []);
    }
    public static function up_general_settings()
    {
        self::$settings['general'] = get_option('clt_general_settings', []);
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

        $clt_general_settings       = self::get_general_settings();
        $clt_general_settings[$key] = $val;
        update_option('clt_general_settings', $clt_general_settings, 0);
    }
    public static function plugin_textdomain()
    {
        load_plugin_textdomain('clt_locator', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }



    public static function scripts_method()
    {
        // wp_register_script( 'tmpray_googlemaps-api', 'https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyB6KlsNUGcsMYLNFvXxymTw9oOEHflWRrE');
        // wp_print_scripts( 'tmpray_googlemaps-api' );
        //wp_enqueue_script('tmpray_scripts', plugin_dir_url( __FILE__ ) . 'inc/scripts.js', array('jquery'), null, false);
        wp_enqueue_script('tmpray_geocomplete', plugin_dir_url( __FILE__ ) . 'inc/jquery.geocomplete.js', array('jquery'), null, false);

        wp_register_script('markerclusterer-js', plugin_dir_url(__FILE__) . 'inc/markerclusterer.js', array('jquery'));
        wp_register_script('map-cars-locator-js', plugin_dir_url(__FILE__) . 'inc/map-cars-locator.js', array('jquery'));
        wp_enqueue_script('markerclusterer-js');
        wp_enqueue_script('map-cars-locator-js');

    }



    public static function register_scripts_method()
    {
        wp_register_script('markerclusterer-js', plugin_dir_url(__FILE__) . 'inc/markerclusterer.js', array('jquery'));

    }
    public static function styles_method()
    {
        wp_register_style('markerclusterer-css', plugin_dir_url(__FILE__) . 'inc/car-locator.css');
        wp_enqueue_style('markerclusterer-css');

    }
    public static function hook_css()
    {
        echo '<style>' . self::get_setting('map_css') . '</style>';
    }
    public static function get_map_autos()
    {
        $map_auto = [];
        $autos    = get_posts(array(
            'numberposts'      => 1000,
            'category'         => 0,
            'orderby'          => 'date',
            'order'            => 'DESC',
            'include'          => array(),
            'exclude'          => array(),
            'meta_key'         => '',
            'meta_value'       => '',
            'post_type'        => 'pixad-autos',
            'suppress_filters' => true,
        ));
        foreach ($autos as $key => $auto) {
            $add_auto = (array) $auto;
            $price = get_post_meta($add_auto['ID'], '_auto_price', 1);
            $price = $price ? $price : '';

            if(function_exists('get_woocommerce_currency_symbol') && intval($price) > 0){
                $price = get_woocommerce_currency_symbol().$price;
            }

            $lat  = get_post_meta( $add_auto['ID'], 'pixad_auto_booking_lattitude', true );
            $long = get_post_meta( $add_auto['ID'], 'pixad_auto_booking_longitude', true );
            $long = get_post_meta( $add_auto['ID'], 'pixad_auto_booking_longitude', true );
            if (empty($lat) || empty($long)) {
                continue;
            } //no coordinates

            $allowed                   = array('ID', 'post_title');
            $add_auto                  = array_intersect_key($add_auto, array_flip($allowed));
            $add_auto['post_url']      = get_permalink($add_auto['ID']);
            $add_auto['thumbnail_url'] = get_the_post_thumbnail_url($add_auto['ID'], 'medium');
            $add_auto['latitude']      = $lat;
            $add_auto['longitude']     = $long;
            $add_auto['price']         = $price;
            $map_auto[]                = $add_auto;
        }
        return $map_auto;
    }

    public static function get_map_booking_address()
    {
        $map_adress = [];
        $locations_with_coordinates = get_option('pixba_locations_with_coordinates');
        foreach ($locations_with_coordinates as $key => $address) {

            $lat  = $address['lattitude'];
            $long = $address['longitude'];
            $long = $address['longitude'];
            if (empty($lat) || empty($long)) {
                continue;
            } //no coordinates

            $allowed                     = array('ID', 'post_title');
            $add_adress                  = array_intersect_key($address, array_flip($allowed));
            $add_adress['phone']         = $address['phone'];
            $add_adress['company']       = $address['company'];
            $add_adress['img']           = $address['img'];
            $add_adress['latitude']      = $lat;
            $add_adress['longitude']     = $long;
            $map_adress[]                = $add_adress;
        }
        return $map_adress;
    }

    public static function get_map_autos_all()
    {
        $map_auto = [];
        $autos    = get_posts(array(
            'numberposts'      => 1000,
            'category'         => 0,
            'orderby'          => 'date',
            'order'            => 'DESC',
            'include'          => array(),
            'exclude'          => array(),
            'meta_key'         => '',
            'meta_value'       => '',
            'post_type'        => 'pixad-autos',
            'suppress_filters' => true,
        ));
        foreach ($autos as $key => $auto) {
            $add_auto = (array) $auto;
            $price = get_post_meta($add_auto['ID'], '_auto_price', 1);
            $price = $price ? $price : '';

            if(function_exists('get_woocommerce_currency_symbol') && intval($price) > 0){
                $price = get_woocommerce_currency_symbol().$price;
            }



            $allowed                   = array('ID', 'post_title');
            $add_auto                  = array_intersect_key($add_auto, array_flip($allowed));
            $add_auto['post_url']      = get_permalink($add_auto['ID']);
            $add_auto['thumbnail_url'] = get_the_post_thumbnail_url($add_auto['ID'], 'medium');
            $add_auto['price']         = $price;
            $map_auto[]                = $add_auto;
        }
        return $map_auto;
    }

    public static function plugin_action_links($links, $file)
    {
        if ($file == plugin_basename(__FILE__)) {
            $clt_links = '<a href="' . get_admin_url() . 'edit.php?post_type=pixad-autos&page=clt-settings">' . self::$strings['page_plugins_title'] . '</a>';
            array_unshift($links, $clt_links);
        }
        return $links;
    }
    public static function plugin_activate()
    {
        // first activated
        if(empty(self::get_setting('has_activated'))){
            self::update_general_settings('is_show', 1);
            self::update_general_settings('map_zoom', 5);
            self::update_general_settings('map_lat', 50);
            self::update_general_settings('map_lng', 10);
            self::update_general_settings('claster_text_size', 12);
            self::update_general_settings('map_css', '#clt-maps{height:550px}');
            self::update_general_settings('map_styles', '[{"elementType": "geometry", "stylers": [{"color": "#212121" }]},{ "elementType": "labels.icon","stylers": [ {"visibility": "off"}]},{ "elementType": "labels.text.fill", "stylers": [ { "color": "#757575"}]},{"elementType": "labels.text.stroke", "stylers": [{"color": "#212121"}]},{ "featureType": "administrative","elementType": "geometry","stylers": [ {"color": "#757575"} ]},{"featureType": "administrative.country", "elementType": "labels.text.fill","stylers": [{"color": "#9e9e9e"}]},{"featureType": "administrative.land_parcel","stylers": [ {"visibility": "off" } ]},{"featureType": "administrative.locality","elementType": "labels.text.fill", "stylers": [{  "color": "#bdbdbd" } ]},{ "featureType": "poi", "elementType": "labels.text.fill", "stylers": [ {"color": "#757575" } ]},{ "featureType": "poi.park", "elementType": "geometry","stylers": [ {  "color": "#181818" }]},{"featureType": "poi.park", "elementType": "labels.text.fill", "stylers": [  {"color": "#616161" } ]}, { "featureType": "poi.park", "elementType": "labels.text.stroke", "stylers": [  {  "color": "#1b1b1b" } ]},{ "featureType": "road", "elementType": "geometry.fill","stylers": [ {"color": "#2c2c2c" } ] },{ "featureType": "road", "elementType": "labels.text.fill","stylers": [ {  "color": "#8a8a8a" } ] },{ "featureType": "road.arterial", "elementType": "geometry", "stylers": [  {  "color": "#373737" }  ] }, { "featureType": "road.highway", "elementType": "geometry", "stylers": [ {  "color": "#3c3c3c"  } ]}, { "featureType": "road.highway.controlled_access", "elementType": "geometry","stylers": [  {   "color": "#4e4e4e"  } ]}, { "featureType": "road.local", "elementType": "labels.text.fill","stylers": [   {   "color": "#616161" } ]},{ "featureType": "transit", "elementType": "labels.text.fill", "stylers": [   {  "color": "#757575" } ] }, { "featureType": "water", "elementType": "geometry", "stylers": [ {  "color": "#000000" }]}, { "featureType": "water", "elementType": "labels.text.fill", "stylers": [  {  "color": "#3d3d3d" } ] }]');
            self::update_general_settings('has_activated', 1);
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
        // pixad-autos
        add_submenu_page('edit.php?post_type=pixad-autos', self::$strings['admin_page']['title'], self::$strings['admin_page']['title'], 'manage_options', 'clt-settings', array(&$this, 'submenu_page__settings'));
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
    public function submenu_page__settings()
    {
        self::update_settings_fields();
        ?>
        <div class="wrap">
            <h3><?php echo get_admin_page_title() ?></h3>
            <div class="block-settings">
                <div class="booking-block col-lg-12">
                    <div class="pixad-form-group">
                        <div class="col-lg-12"><h3><?php echo self::$strings['admin_page']['general_block_title']; ?></h3></div>
                    </div>
                    <form method="post" class="pixad-form-horizontal" role="form">
                        <input type="hidden" name="action" value="save">

                        <div class="pixad-form-group">
                            <?php self::display_all_fields();?>
                        </div>

                        <div class="col-lg-2 pixad-control-label"></div>
                        <button type="submit" name="submit" class="button button-primary booking-submit-save col-lg-3" value="up_settings"><?php echo self::$strings['save']; ?></button>
                    </form>
                </div>
            </div>

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
            .clt-block-field{
                display: flex;
                align-items: baseline;
            }
        </style>
        <?php
    }
    public function display_all_fields()
    {
        $val            = get_option('compare_cars_templ');
        $hide_comp_icon = !empty($val['no_comp_icon']) ? $val['no_comp_icon'] : false;
        ?>
        <div class="clt-block-field">
            <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['is_show_title']; ?></label>
            <div class="col-lg-9">
                <input type="hidden" name="settings[is_show]" value="">
                <input type="checkbox" name="settings[is_show]" value="1" <?php checked(1, self::get_setting('is_show'))?> />
            </div>
        </div>

        <div class="clt-block-field">
            <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['api_key_title']; ?></label>
            <div class="col-lg-9">
                <input name="settings[google_maps_api_key]" class="pixad-form-control" value="<?php echo self::get_setting('google_maps_api_key', ''); ?>">
            </div>
        </div>

        <div class="clt-block-field">
            <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_zoom_title']; ?></label>
            <div class="col-lg-9">
                <input type="number" step="0.00000001" name="settings[map_zoom]" class="pixad-form-control" value="<?php echo self::get_setting('map_zoom', ''); ?>">
            </div>
        </div>

        <div class="clt-block-field">
            <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_lat_title']; ?></label>
            <div class="col-lg-9">
                <input type="number" step="0.00000001" name="settings[map_lat]" class="pixad-form-control" value="<?php echo self::get_setting('map_lat', ''); ?>">
            </div>
        </div>

        <div class="clt-block-field">
            <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_lng_title']; ?></label>
            <div class="col-lg-9">
                <input type="number" step="0.00000001" name="settings[map_lng]" class="pixad-form-control" value="<?php echo self::get_setting('map_lng', ''); ?>">
            </div>
        </div>

        <div class="clt-block-field">
            <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_icon_title']; ?></label>
            <div class="col-lg-9">
                <input size="100" name="settings[icon_url]" class="pixad-form-control" placeholder="<?php echo self::$settings['default']['icon_url']; ?>"
                       value="<?php echo self::get_setting('icon_url'); ?>">
            </div>
        </div>

        <div class="clt-block-field">
            <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_icon_width_title']; ?></label>
            <div class="col-lg-9">
                <input size="100" name="settings[icon_width]" class="pixad-form-control" value="<?php echo self::get_setting('icon_width'); ?>">
            </div>
        </div>

        <div class="clt-block-field">
            <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_icon_height_title']; ?></label>
            <div class="col-lg-9">
                <input size="100" name="settings[icon_height]" class="pixad-form-control"  value="<?php echo self::get_setting('icon_height'); ?>">
            </div>
        </div>

        <div class="clt-block-field">
            <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_claster_title']; ?></label>
            <div class="col-lg-9">
                <input size="100" name="settings[claster_url]" class="pixad-form-control" placeholder="<?php echo self::$settings['default']['claster_url']; ?>" value="<?php echo self::get_setting('claster_url'); ?>">
            </div>
        </div>

        <div class="clt-block-field">
            <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_claster_width_title']; ?></label>
            <div class="col-lg-9">
                <input size="100" name="settings[claster_width]" class="pixad-form-control" value="<?php echo self::get_setting('claster_width'); ?>">
            </div>
        </div>

        <div class="clt-block-field">
            <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_claster_height_title']; ?></label>
            <div class="col-lg-9">
                <input size="100" name="settings[claster_height]" class="pixad-form-control"  value="<?php echo self::get_setting('claster_height'); ?>">
            </div>
        </div>

        <div class="clt-block-field">
            <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_claster_text_size_title']; ?></label>
            <div class="col-lg-9">
                <input type="number" size="100" name="settings[claster_text_size]" class="pixad-form-control"  value="<?php echo self::get_setting('claster_text_size'); ?>">
            </div>
        </div>

        <div class="clt-block-field">
            <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_css_title']; ?></label>
            <div class="col-lg-9">
                <textarea placeholder="<?php echo self::$settings['default']['styles']; ?>"  rows="15" cols="100" name="settings[map_css]" class="pixad-form-control"><?php echo self::get_setting('map_css', ''); ?></textarea>
            </div>
        </div>

        <div class="clt-block-field">
            <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_styles_title']; ?></label>
            <div class="col-lg-9">
                <textarea placeholder="<?php echo self::$settings['default']['map_styles']; ?>"  rows="15" cols="100" name="settings[map_styles]" class="pixad-form-control"><?php echo wp_unslash(self::get_setting('map_styles', '')); ?></textarea>
            </div>
        </div>

        <?php
    }

///////////////////////////////////////////////////////////////////////////////////////////
    /////// frontend
    ///////////////////////////////////////////////////////////////////////////////////////////
    public function display_map($value = '')
    {
        echo '<div id="clt-maps"></div>';

        add_action('print_footer_scripts', [ & $this, 'add_js_script_map']);


    }
    public static function add_js_script_map()
    {

        $map_autos                       = self::get_map_booking_address();
        $map_data                        = [];
        $map_data['map_id']              = 'clt-maps';
        $map_data['google_maps_api_key'] = self::get_setting('google_maps_api_key', '');

        if(isset($_POST['pixad-car-locator-lat']) && $_POST['pixad-car-locator-lat'] != ''){
            $map_data['map_lat']             = $_POST['pixad-car-locator-lat'];
        } else {
            $map_data['map_lat']             = self::get_setting('map_lat', 1);
        }

        if(isset($_POST['pixad-car-locator-long']) && $_POST['pixad-car-locator-long'] != ''){
            $map_data['map_lng']             = $_POST['pixad-car-locator-long'];
        } else {
            $map_data['map_lng']             = self::get_setting('map_lng', 1);
        }

        if(isset($_POST['pixad-car-locator-radius']) && $_POST['pixad-car-locator-radius'] != ''){
            if($_POST['pixad-car-locator-radius'] <= 100){
                $map_data['map_zoom']   = 13;
            }elseif ($_POST['pixad-car-locator-radius'] <= 200){
                $map_data['map_zoom']   = 8;

            }elseif ($_POST['pixad-car-locator-radius'] <= 300){
                $map_data['map_zoom']   = 7;

            }elseif ($_POST['pixad-car-locator-radius'] <= 400){
                $map_data['map_zoom']   = 6;

            }elseif ($_POST['pixad-car-locator-radius'] <= 500){
                $map_data['map_zoom']   = 5;

            }elseif ($_POST['pixad-car-locator-radius'] <= 600){
                $map_data['map_zoom']   = 4;

            }elseif ($_POST['pixad-car-locator-radius'] <= 700){
                $map_data['map_zoom']   = 3;

            }elseif ($_POST['pixad-car-locator-radius'] <= 800){
                $map_data['map_zoom']   = 3;

            }elseif ($_POST['pixad-car-locator-radius'] <= 900){
                $map_data['map_zoom']   = 3;

            }elseif ($_POST['pixad-car-locator-radius'] <= 1000){
                $map_data['map_zoom']   = 2;

            }

        } else {
            $map_data['map_zoom']            = self::get_setting('map_zoom', 1);

        }



        $map_data['icon_url']            = self::get_setting('icon_url', self::$settings['default']['icon_url']);
        $map_data['icon_width']          = self::get_setting('icon_width', 27);
        $map_data['icon_height']         = self::get_setting('icon_height', 43);
        $map_data['claster_url']         = self::get_setting('claster_url', self::$settings['default']['claster_url']);
        // $map_data['claster_url']         = self::get_setting('claster_url', self::$settings['default']['claster_url']);
        $map_data['claster_width']       = self::get_setting('claster_width', 53);
        $map_data['claster_height']      = self::get_setting('claster_height', 53);
        $map_data['claster_text_size']   = self::get_setting('claster_text_size', 14);
        $map_data['info_block_summary']  = self::$strings['info_block_summary'];
        $map_data['info_block_readmore'] = self::$strings['info_block_readmore'];
        $map_data['map_styles']          = json_decode(wp_unslash(self::get_setting('map_styles')));
        $map_data['photos']              = $map_autos;

        ?>
        <script>



            var cltLocatorData =  JSON.parse('<?php print json_encode($map_data)?>' );
            if(!window.cltMapSettings){
                var cltMapSettings = [];
            }

            cltMapSettings.push(cltLocatorData);
        </script>

        <?php
// echo '<script async defer src="https://maps.googleapis.com/maps/api/js?callback=cltInitMap&key=' . self::get_setting('google_maps_api_key') . '"></script>';
        if (empty(self::get_setting('google_maps_api_key'))) {
            echo '<script async defer src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=cltInitMap"></script>';

        } else {
            echo '<script async defer src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=cltInitMap&key=' . self::get_setting('google_maps_api_key') . '"></script>';
        }

        echo '<script type="text/javascript" src="'.plugin_dir_url( __FILE__ ) . 'js/jquery.geocomplete.js"></script>';
        ?>
        <script>
            jQuery(document).ready(function(){
                jQuery('.pixad--city').geocomplete({
                    location: false
                }).bind('geocode:result',function (e, result) {
                    jQuery('#pixad-car-locator-lat').val(result.geometry.viewport.Za.j);
                    jQuery('#pixad-car-locator-long').val(result.geometry.viewport.Va.j);
                    jQuery('#car-locator-radius').val(0);
                });
            })
        </script>
        <?php
    }
} //end class
$car_locator = new Car_Locator_Templines();







function car_locator_get_distance($latitude1, $longitude1, $latitude2, $longitude2) {
    $earth_radius = 6371;
    $dLat = deg2rad($latitude2 - $latitude1);
    $dLon = deg2rad($longitude2 - $longitude1);
    $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * sin($dLon/2) * sin($dLon/2);
    $c = 2 * asin(sqrt($a));
    $d = $earth_radius * $c;
    return $d;
}


function car_locator_get_distance_all($latitude1, $longitude1, $autos_long_lat, $radius){
    foreach ($autos_long_lat as $value){
        $distance = car_locator_get_distance($latitude1, $longitude1, $value['lat'][1], $value['long'][1]);
        if($distance < $radius){
            return  $value['title'].' внутри радиуса' . $radius . ' км от ' . $longitude1 . '<br>';
        }
    }
}

