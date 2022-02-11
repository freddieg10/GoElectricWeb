<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) 
    exit;

/**
 * Fire Action on Plugin Installation
 *
 * @since 0.1
 */
class PIXAD_Auto_Install {
    /**
     * Insert Default Data into Database
     *
     * @since 0.1
     */
    static function install() {
        global $wpdb;

        /**
         * Insert Default Settings "_pixad_autos_settings"
         * ===========================================
         * @since 0.1
         */
        if( ! get_option( '_pixad_autos_settings' ) ) {
            $pixad_autos_settings = array(
                'mode'						=> 'pixads',
                'autos_site_currency'		=> 'USD',
                'autos_thousand'            => ',',
                'autos_decimal'             => '.',
                'autos_decimal_number'      => '2',
                'autos_price_text'      	=> '',
                'autos_max_price'			=> '100000',
                'autos_min_year'            => '1950',
                'autos_per_page'			=> '9',
                'autos_order'				=> 'date-desc',
                'autos_equipment'			=> '0',
            );
            update_option( '_pixad_autos_settings', serialize( $pixad_autos_settings ) );
        }

		$pixad_autos_translate = array(
			'automatic' => __( 'Automatic', 'pixad' ),
			'manual' => __( 'Manual', 'pixad' ),
			'semi-automatic' => __( 'Semi-Automatic', 'pixad' ),
			'diesel' => __( 'Diesel', 'pixad' ),
			'electric' => __( 'Electric', 'pixad' ),
			'petrol' => __( 'Petrol', 'pixad' ),
			'hybrid' => __( 'Hybrid', 'pixad' ),
            'plugin_electric' => __( 'Plugin electric', 'pixad' ),
			'petrol+cng' => __( 'Petrol+CNG', 'pixad' ),
            'lpg' => __( 'LPG', 'pixad' ),
			'new' => __( 'New', 'pixad' ),
			'used' => __( 'Used', 'pixad' ),
			'driver' => __( 'Driver', 'pixad' ),
			'non driver' => __( 'Non driver', 'pixad' ),
			'barnfind' => __( 'Barnfind', 'pixad' ),
			'projectcar' => __( 'Projectcar', 'pixad' ),
			'in stock' => __( 'In stock', 'pixad' ),
			'expected' => __( 'Expected', 'pixad' ),
			'out of stock' => __( 'Out of stock', 'pixad' ),
			'front' => __( 'Front', 'pixad' ),
			'rear' => __( 'Rear', 'pixad' ),
			'fixed' => __( 'Fixed', 'pixad' ),
			'negotiable' => __( 'Negotiable', 'pixad' ),
			'no' => __( 'No', 'pixad' ),
			'yes' => __( 'Yes', 'pixad' ),
			'Featured' => __( 'Featured', 'pixad' ),
			'Sold' => __( 'Sold', 'pixad' ),
			'rent' => __( 'Rent', 'pixad' ),
			'selling' => __( 'Selling', 'pixad' ),
			'Request' => __( 'Request', 'pixad' ),
			'Reserved' => __( 'Reserved', 'pixad' ),
            'POA' => __( 'POA', 'pixad' ),
			'white' => __( 'white', 'pixad' ),
			'silver' => __( 'silver', 'pixad' ),
			'black' => __( 'black', 'pixad' ),
			'grey' => __( 'grey', 'pixad' ),
			'blue' => __( 'blue', 'pixad' ),
			'red' => __( 'red', 'pixad' ),
			'brown' => __( 'brown', 'pixad' ),
			'beige' => __( 'beige', 'pixad' ),
			'green' => __( 'green', 'pixad' ),
			'yellow' => __( 'yellow', 'pixad' ),
			'orange' => __( 'orange', 'pixad' ),
			'purple' => __( 'purple', 'pixad' ),

		);
        update_option( '_pixad_auto_translate', serialize( $pixad_autos_translate ) );


        if( ! get_option('_pixad_autos_validation' ) ) {
            $defaults = array(
                'auto-version_req' => '',
                'auto-version_show' => 'on',
                'auto-year_req' => 'on',
                'auto-year_show' => 'on',
                'auto-year_icon' => 'autofont-steering-wheel-1',
                'auto-year_side' => 'on',
                'auto-year_list' => 'on',
                'auto-mileage_req' => 'on',
                'auto-mileage_show' => 'on',
                'auto-mileage_icon' => 'autofont-highway',
                'auto-mileage_side' => 'on',
                'auto-mileage_list' => 'on',
                'auto-fuel_req' => 'on',
                'auto-fuel_show' => 'on',
                'auto-fuel_list' => 'on',
                'auto-engine_req' => 'on',
                'auto-engine_show' => 'on',
                'auto-engine_list' => 'on',
                'auto-horsepower_req' => 'on',
                'auto-horsepower_show' => 'on',
                'auto-horsepower_icon' => 'autofont-speedometer',
                'auto-horsepower_side' => 'on',
                'auto-horsepower_list' => 'on',
                'auto-transmission_req' => 'on',
                'auto-transmission_show' => 'on',
                'auto-drive_req' => 'on',
                'auto-drive_show' => 'on',
                'auto-drive_list' => 'on',
                'auto-doors_req' => 'on',
                'auto-doors_show' => 'on',
                'auto-seats_req' => 'on',
                'auto-seats_show' => 'on',
                'auto-color_req' => '',
                'auto-color_show' => 'on',
                'auto-color-int_req' => '',
                'auto-color-int_show' => 'on',
                'auto-condition_req' => '',
                'auto-condition_show' => 'on',
                'auto-condition_list' => 'on',
                'auto-purpose_req' => 'on',
                'auto-purpose_show' => 'on',
                'auto-vin_req' => '',
                'auto-vin_show' => 'on',
                'auto-price_req' => 'on',
                'auto-price_show' => 'on',
                'auto-sale-price_show' => 'on',
                'auto-stock-status_req' => '',
                'auto-stock-status_show' => 'on',
                'auto-stock-status_list' => 'on',
                'auto-price-type_req' => 'on',
                'auto-price-type_show' => 'on',
                'auto-warranty_req' => 'on',
                'auto-warranty_show' => 'on',
                'auto-currency_req' => 'on',
                'auto-currency_show' => 'on',
                'first-name_req' => 'on',
                'first-name_show' => 'on',
                'last-name_req' => 'on',
                'last-name_show' => 'on',
                'seller-company_req' => '',
                'seller-company_show' => 'on',
                'seller-email_req' => 'on',
                'seller-email_show' => 'on',
                'seller-phone_req' => 'on',
                'seller-phone_show' => 'on',
                'seller-country_req' => 'on',
                'seller-country_show' => 'on',
                'seller-state_req' => '',
                'seller-state_show' => 'on',
                'seller-town_req' => 'on',
                'seller-town_show' => 'on',
                'seller-location_req' => 'on',
                'seller-location_show' => 'on',
				'seller-location-lat_req' => 'on',
                'seller-location-lat_show' => 'on',
				'seller-location-long_req' => 'on',
                'seller-location-long_show' => 'on',

				'auto-date_show' => 'on',
            );
            update_option( '_pixad_autos_validation', serialize( $defaults ) );
        }

        /**
         * Insert Default Currencies "_pixad_currencies"
         * ==========================================
         * @since 0.4
         */
        if( !get_option( '_pixad_autos_currencies' ) ) {
            $pixad_autos_currencies = array(
                'USD' => array(
                        'iso'		=> 'USD',
                        'name'		=> 'United States Dollar',
                        'symbol'	=> '&#36;',
                        'position'	=> 'left'
                ),
                'EUR' => array(
                    'iso'		=> 'EUR',
                    'name'		=> 'Euro Member Countries',
                    'symbol'	=> '&#8364;',
                    'position'	=> 'left'
                ),
                'GBP' => array(
                    'iso'		=> 'GBP',
                    'name'		=> 'United Kingdom Pound',
                    'symbol'	=> '&#163;',
                    'position'	=> 'left'
                ),
                'NONE' => array(
                    'iso'       => 'NONE',
                    'name'      => 'NONE',
                    'symbol'    => '',
                    'position'  => 'left'
                ),

            );
            update_option( '_pixad_autos_currencies', serialize( $pixad_autos_currencies ) );
        }


    }
}
register_activation_hook( PIXAD_AUTO_DIR . 'pixad-autos.php', array( 'PIXAD_Auto_Install', 'install' ) );
?>