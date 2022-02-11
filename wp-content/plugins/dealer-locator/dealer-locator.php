<?php

/**
 * Plugin Name: Dealer Locator
 * Description: Dealer Locator
 * Author: Templines
 * Version: 1.0.1

 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Dealer Locator
 */
class Dealer_Locator_Cars
{
    //all strings class
    public static $strings = array();
    //all settings class
    public static $settings = array();

    public static $autos = array();

    public function __construct()
    {
        self::init();

        // front

        add_action('wp_enqueue_scripts', array(&$this, 'styles_method'));
        add_action('print_footer_scripts', array(&$this, 'hook_css'));
        add_action('plugins_loaded', array(&$this, 'plugin_textdomain'));
        add_shortcode('dealer_locator', array(&$this, 'display_map'));
        if (!empty(self::get_setting('is_show'))) {
            add_action('wp_enqueue_scripts', array(&$this, 'scripts_method'));
        }
        // admin
        add_action('admin_menu', array(&$this, 'admin_menu_page'));
        add_filter('plugin_action_links', array(&$this, 'plugin_action_links'), 10, 2);
        register_activation_hook( __FILE__, array( &$this, 'plugin_activate' ) );
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
                'shadow_url',
            ],
            'default'  => [
                'icon_url'    => plugins_url('dealer-locator/img/spotlight.png'),
                'claster_url' => plugins_url('dealer-locator/img/m1.png'),
                'shadow_url' => plugins_url('dealer-locator/img/shadow.png'),
                'thumb_car_url' => plugins_url('dealer-locator/img/dealer-avatar.jpg'),
                'styles'      => '      /* Always set the map height explicitly to define the size of the div
               * element that contains the map. */
            #dlc_dealers-maps {
                height: 500px;
              }',
                'map_styles'  => 'json data',
            ],
        );
        // Load class strings.
        self::$strings = array(
            'save'                => __('Save', 'dlc_locator'),
            'page_plugins_title'  => __('Settings', 'dlc_locator'),

            'admin_page'          => [
                'title'                       => __('Dealer Locator', 'dlc_locator'),

                'general_block_title'         => __('Settings Google maps', 'dlc_locator'),
                'is_show_title'               => __('Show map', 'dlc_locator'),
                'api_key_title'               => __('Google maps api key', 'dlc_locator'),
                'map_zoom_title'              => __('Zoom', 'dlc_locator'),
                'map_lat_title'               => __('Latitude', 'dlc_locator'),
                'map_lng_title'               => __('Longitude', 'dlc_locator'),
                'map_icon_title'              => __('Icon', 'dlc_locator'),
                'map_icon_width_title'        => __('Icon width', 'dlc_locator'),
                'map_icon_height_title'       => __('Icon height', 'dlc_locator'),
                'map_claster_title'           => __('Claster', 'dlc_locator'),
                'map_claster_width_title'     => __('Claster width', 'dlc_locator'),
                'map_claster_height_title'    => __('Claster height', 'dlc_locator'),
                'map_css_title'               => __('Styles', 'dlc_locator'),
                'map_claster_text_size_title' => __('Сlaster text size', 'dlc_locator'),
                'map_icon_button_title'       => __('Select icon', 'dlc_locator'),
                'map_styles_title'            => __('Map styles, json data ( create map style on https://mapstyle.withgoogle.com )', 'dlc_locator'),
            ],
            'front_page'          => [
                'seller_location'                       => __('Location', 'dlc_locator'),
                'seller_email'                       => __('Email', 'dlc_locator'),
                'seller_phone'                       => __('Phone', 'dlc_locator'),
                'seller_country'                       => __('Country', 'dlc_locator'),
                'seller_company'                       => __('Сompany', 'dlc_locator'),
                'seller_state'                       => __('State', 'dlc_locator'),
                'seller_town'                       => __('Town', 'dlc_locator'),
                'input_search'                       => __('Where are you?', 'dlc_locator'),
            ],
        );
    }

///////////////////////////////////////////////////////////////////////////////////////////
    /////// inside functions
    ///////////////////////////////////////////////////////////////////////////////////////////
    public static function get_general_settings()
    {
        return get_option('dlc_general_settings', []);
    }
    public static function up_general_settings()
    {
        self::$settings['general'] = get_option('dlc_general_settings', []);
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

        $dlc_general_settings       = self::get_general_settings();
        $dlc_general_settings[$key] = $val;
        update_option('dlc_general_settings', $dlc_general_settings, 0);
    }
    public static function plugin_textdomain()
    {
        load_plugin_textdomain('dlc_locator', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }
    public static function scripts_method()
    {
        wp_register_script('markerclusterer-js', plugin_dir_url(__FILE__) . 'inc/markerclusterer.js', array('jquery'));
        wp_register_script('dealer-js', plugin_dir_url(__FILE__) . 'inc/map-dealer.js', array('jquery'));

        if (empty(self::get_setting('google_maps_api_key'))) {
            $map_url = 'https://maps.googleapis.com/maps/api/js';
        } else {
            $map_url = 'https://maps.googleapis.com/maps/api/js?key=' . self::get_setting('google_maps_api_key');
        }
        wp_register_script('gooogle-maps-js', $map_url, array('jquery'));
        
    }
    public static function styles_method()
    {
        wp_register_style('dealer-locator-css', plugin_dir_url(__FILE__) . 'inc/dealer-locator.css');
        wp_enqueue_style('dealer-locator-css');

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
            $meta_data = get_post_meta($add_auto['ID']);
            $price = isset($meta_data['_auto_price']) ? $meta_data['_auto_price'][0] : '';
            $price = $price ? $price : '';
            if(function_exists('get_woocommerce_currency_symbol') && intval($price) > 0){
                $price = get_woocommerce_currency_symbol().$price;
            }

            // $lat  = get_post_meta($add_auto['ID'], '_seller_location_lat', 1);
            $lat  = isset($meta_data['_seller_location_lat']) ? $meta_data['_seller_location_lat'][0] : '';
            // $long = get_post_meta($add_auto['ID'], '_seller_location_long', 1);
            $long = isset($meta_data['_seller_location_long']) ? $meta_data['_seller_location_long'][0] : '';
            if (empty($lat) || empty($long)) {
                continue;
            } //no coordinates
            $seller_first_name = isset($meta_data['_seller_first_name']) ? $meta_data['_seller_first_name'][0] : '';
            $seller_last_name = isset($meta_data['_seller_last_name']) ? $meta_data['_seller_last_name'][0] : '';
            $seller_location = isset($meta_data['_seller_location']) ? $meta_data['_seller_location'][0] : '';
            $seller_company = isset($meta_data['_seller_company']) ? $meta_data['_seller_company'][0] : '';
            $seller_email = isset($meta_data['_seller_email']) ? $meta_data['_seller_email'][0] : '';
            $seller_phone = isset($meta_data['_seller_phone']) ? $meta_data['_seller_phone'][0] : '';
            $seller_country = isset($meta_data['_seller_country']) ? $meta_data['_seller_country'][0] : '';
            $seller_state = isset($meta_data['_seller_state']) ? $meta_data['_seller_state'][0] : '';
            $seller_town = isset($meta_data['_seller_town']) ? $meta_data['_seller_town'][0] : '';

            $thumb = get_the_post_thumbnail_url($add_auto['ID'], 'medium');
            $thumb = !empty($thumb) ? $thumb : self::$settings['default']['shadow_url'];

            $allowed                   = array('ID', 'post_title', 'post_author');
            $add_auto                  = array_intersect_key($add_auto, array_flip($allowed));
            $add_auto['post_url']      = get_permalink($add_auto['ID']);
            $add_auto['thumbnail_url'] = $thumb;
            $add_auto['latitude']      = $lat;
            $add_auto['longitude']     = $long;
            $add_auto['price']         = $price;
            $add_auto['seller_first_name']         = $seller_first_name;
            $add_auto['seller_last_name']         = $seller_last_name;
            $add_auto['seller_location']         = $seller_location;
            $add_auto['seller_company']         = $seller_company;
            $add_auto['seller_phone']         = $seller_phone;
            $add_auto['seller_email']         = $seller_email;
            $add_auto['seller_country']         = $seller_country;
            $add_auto['seller_state']         = $seller_state;
            $add_auto['seller_town']         = $seller_town;
            $map_auto[]                = $add_auto;
        }
        return $map_auto;
    }
    public static function plugin_action_links($links, $file)
    {
        if ($file == plugin_basename(__FILE__)) {
            $dlc_links = '<a href="' . get_admin_url() . 'edit.php?post_type=pixad-autos&page=dlc-locator-settings">' . self::$strings['page_plugins_title'] . '</a>';
            array_unshift($links, $dlc_links);
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
            self::update_general_settings('map_css', '#dlc_dealers-maps{height:550px}');
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
        add_submenu_page('edit.php?post_type=pixad-autos', self::$strings['admin_page']['title'], self::$strings['admin_page']['title'], 'manage_options', 'dlc-locator-settings', array(&$this, 'submenu_page__settings'));
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


        <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['api_key_title']; ?></label>
        <div class="col-lg-9">
            <input name="settings[google_maps_api_key]" class="pixad-form-control" value="<?php echo self::get_setting('google_maps_api_key', ''); ?>">
        </div>


        <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_zoom_title']; ?></label>
        <div class="col-lg-9">
            <input type="number" step="0.00000001" name="settings[map_zoom]" class="pixad-form-control" value="<?php echo self::get_setting('map_zoom', ''); ?>">
        </div>


        <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_lat_title']; ?></label>
        <div class="col-lg-9">
            <input type="number" step="0.00000001" name="settings[map_lat]" class="pixad-form-control" value="<?php echo self::get_setting('map_lat', ''); ?>">
        </div>


        <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_lng_title']; ?></label>
        <div class="col-lg-9">
            <input type="number" step="0.00000001" name="settings[map_lng]" class="pixad-form-control" value="<?php echo self::get_setting('map_lng', ''); ?>">
        </div>


        <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_icon_title']; ?></label>
        <div class="col-lg-9">
            <input size="100" name="settings[icon_url]" class="pixad-form-control" placeholder="<?php echo self::$settings['default']['icon_url']; ?>"
            value="<?php echo self::get_setting('icon_url'); ?>">
        </div>

        <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_icon_width_title']; ?></label>
        <div class="col-lg-9">
            <input size="100" name="settings[icon_width]" class="pixad-form-control" value="<?php echo self::get_setting('icon_width'); ?>">
        </div>

        <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_icon_height_title']; ?></label>
        <div class="col-lg-9">
            <input size="100" name="settings[icon_height]" class="pixad-form-control"  value="<?php echo self::get_setting('icon_height'); ?>">
        </div>


        <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_claster_title']; ?></label>
        <div class="col-lg-9">
            <input size="100" name="settings[claster_url]" class="pixad-form-control" placeholder="<?php echo self::$settings['default']['claster_url']; ?>" value="<?php echo self::get_setting('claster_url'); ?>">
        </div>

        <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_claster_width_title']; ?></label>
        <div class="col-lg-9">
            <input size="100" name="settings[claster_width]" class="pixad-form-control" value="<?php echo self::get_setting('claster_width'); ?>">
        </div>

        <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_claster_height_title']; ?></label>
        <div class="col-lg-9">
            <input size="100" name="settings[claster_height]" class="pixad-form-control"  value="<?php echo self::get_setting('claster_height'); ?>">
        </div>

        <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_claster_text_size_title']; ?></label>
        <div class="col-lg-9">
            <input type="number" size="100" name="settings[claster_text_size]" class="pixad-form-control"  value="<?php echo self::get_setting('claster_text_size'); ?>">
        </div>


        <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_css_title']; ?></label>
        <div class="col-lg-9">
            <textarea placeholder="<?php echo self::$settings['default']['styles']; ?>"  rows="15" cols="100" name="settings[map_css]" class="pixad-form-control"><?php echo self::get_setting('map_css', ''); ?></textarea>
        </div>


        <label class="col-lg-2 pixad-control-label"><?php echo self::$strings['admin_page']['map_styles_title']; ?></label>
        <div class="col-lg-9">
            <textarea placeholder="<?php echo self::$settings['default']['map_styles']; ?>"  rows="15" cols="100" name="settings[map_styles]" class="pixad-form-control"><?php echo wp_unslash(self::get_setting('map_styles', '')); ?></textarea>
        </div>

        <?php
}

///////////////////////////////////////////////////////////////////////////////////////////
    /////// frontend
    ///////////////////////////////////////////////////////////////////////////////////////////

    public function display_map($value = '')
    {
        self::$autos = self::get_map_autos();
        self::html_map_dealer();

        add_action('wp_footer', [ & $this, 'add_js_script_map'], 1);
        wp_enqueue_script('gooogle-maps-js');
        wp_enqueue_script('markerclusterer-js');
        wp_enqueue_script('dealer-js');
        
    }
    public static function add_js_script_map()
    {

        
        $map_data                        = [];
        $map_data['map_id']              = 'dlc_dealers-maps';
        $map_data['panel_id']            = 'dlc_panel-map';
        $map_data['google_maps_api_key'] = self::get_setting('google_maps_api_key', '');
        $map_data['map_zoom']            = self::get_setting('map_zoom', 1);
        $map_data['map_lat']             = self::get_setting('map_lat', 1);
        $map_data['map_lng']             = self::get_setting('map_lng', 1);
        $map_data['icon_url']            = self::get_setting('icon_url', self::$settings['default']['icon_url']);
        $map_data['icon_width']          = self::get_setting('icon_width', 27);
        $map_data['icon_height']         = self::get_setting('icon_height', 43);
        $map_data['claster_url']         = self::get_setting('claster_url', self::$settings['default']['claster_url']);
        $map_data['claster_width']       = self::get_setting('claster_width', 53);
        $map_data['claster_height']      = self::get_setting('claster_height', 53);
        $map_data['claster_text_size']   = self::get_setting('claster_text_size', 14);
        $map_data['shadow_url']         = self::$settings['default']['shadow_url'];
        $map_data['map_styles']          = json_decode(wp_unslash(self::get_setting('map_styles')));
        $map_data['photos']              = self::$autos;
        ?>
        <script>
           var dlcLocatorData =  JSON.parse('<?php print json_encode($map_data)?>' );

           if(!window.dlcMapSettings){
            var dlcMapSettings = [];
           }
            dlcMapSettings.push(dlcLocatorData);
        </script>
        <?php
    }


    static function html_map_dealer()
    {
        ?>
        <section id="dlc_panel-map" class="section-dealers">
    <div class="section-dealers__header">
        <div class="location-search">
            <div class="row">
                <input id="dlc-map-search" placeholder="<?php esc_html_e( self::$strings['front_page']['input_search']); ?>" autocomplete="off">
            </div>
        </div>
    </div>
     <div class="section-dealers_wrap">     
        <div class="row">

        <div class="col-dealer-left">
            <div class="section-dealers__main">
                <div class="b-dealers-group">

                    <!-- <div id="markerlist"></div> -->
                <?php foreach (self::$autos as $key => $auto):
                    $dealer_name = '';
                    $dealer_name .= !empty($auto['seller_first_name']) ? $auto['seller_first_name'].' ' : '';
                    $dealer_name .= !empty($auto['seller_last_name']) ? $auto['seller_last_name'] : '';
                 ?>
                    <div class="b-dealers" data-dealer-id="<?php esc_html_e($auto['ID']) ;?>">
                        <div class="col-md-3 col-md-12">
                            <div class="b-dealers__brand">
                                <?php
                                  echo get_avatar( $auto['post_author'], '', '', '', array('class'=>'b-dealers__img img-fluid','extra_attr'=>'alt="brand"') );
                                 ?>
                            </div>
                        </div>
                        <div class="col-md-9 col-md-12">
                            <div class="b-dealers__main">
                                <?php if (!empty($dealer_name)): ?>
                                    <div class="b-dealers__header">
                                        <div class="b-dealers__title"><?php esc_html_e($dealer_name); ?></div>
                                    </div>
                                <?php endif ?>
                                
                                <div class="b-dealers__body">
                                    <ul class="b-dealers_info">

                                        <?php if (!empty($auto['seller_location'])): ?>
                                            <li>
                                                <strong><?php esc_html_e( self::$strings['front_page']['seller_location']); ?>: </strong><?php esc_html_e($auto['seller_location']); ?>
                                            </li>
                                        <?php endif ?>
                                        <?php if (!empty($auto['seller_phone'])): ?>
                                            <li>
                                                <strong><?php esc_html_e( self::$strings['front_page']['seller_phone']); ?>: </strong><?php esc_html_e($auto['seller_phone']); ?>
                                            </li>
                                        <?php endif ?>
                                        <?php if (!empty($auto['seller_email'])): ?>
                                            <li>
                                                <strong><?php esc_html_e( self::$strings['front_page']['seller_email']); ?>: </strong><?php esc_html_e($auto['seller_email']); ?>
                                            </li>
                                        <?php endif ?>

                                        <?php if (!empty($auto['seller_company'])): ?>
                                            <li>
                                                <strong><?php esc_html_e( self::$strings['front_page']['seller_company']); ?>: </strong><?php esc_html_e($auto['seller_company']); ?>
                                            </li>
                                        <?php endif ?>
                                        <?php if (!empty($auto['seller_country'])): ?>
                                            <li>
                                                <strong><?php esc_html_e( self::$strings['front_page']['seller_country']); ?>: </strong><?php esc_html_e($auto['seller_country']); ?>
                                            </li>
                                        <?php endif ?>
                                        <?php if (!empty($auto['seller_state'])): ?>
                                            <li>
                                                <strong><?php esc_html_e( self::$strings['front_page']['seller_state']); ?>: </strong><?php esc_html_e($auto['seller_state']); ?>
                                            </li>
                                        <?php endif ?>
                                        <?php if (!empty($auto['seller_town'])): ?>
                                            <li>
                                                <strong><?php esc_html_e( self::$strings['front_page']['seller_town']); ?>: </strong><?php esc_html_e($auto['seller_town']); ?>
                                            </li>
                                        <?php endif ?>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="wrap-post-btn"><a class="post-btn btn-effect" href="<?php esc_html_e($auto['post_url']); ?>"><span class="post-btn__inner"><?php esc_attr_e('View Car', 'autozone'); ?></span></a></div>
                        </div>
                    </div><!--  end dealer  -->
                <?php    endforeach; ?>

                </div>

            </div>
        </div>
        <div class="col-dealer-right">
            <div class="b-dealers-map" id="b-dealers-map">
                <div id="dlc_dealers-maps"></div>
            </div>
        </div>
            
        </div>
      </div>

    </section>
        <?php
    }
} //end class
$car_locator = new Dealer_Locator_Cars();