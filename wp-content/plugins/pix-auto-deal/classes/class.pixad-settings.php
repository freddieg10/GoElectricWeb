<?php
class PIXAD_Settings
{
	/**
	 * Update | Save | Create - update_option
	 * ======================================
	 * $table:
	 * WP_OPTIONS
	 * PIXAD_CURRENCIES
	 *
	 * @since 0.2
	 */
	public function update( $table, $key, $value, $post_id = false, $array = false ) {
		switch( $table ):
			
			/**
			 * Update single wp_options
			 * ========================
			 * @since 0.2
			 */
			case $table == 'WP_OPTIONS' && $array == false:
				 if( update_option( $key, $value ) )
					echo $this->success();
			break;
			
			/**
			 * Update array wp_options
			 * =======================
			 * @since 0.2
			 */
			case $table == 'WP_OPTIONS' && $array == true:
				foreach( $value as $arname => $aroption ) {
					update_option( $key, $arname, $aroption );
				}
				echo $this->success();
			break;
			
			/**
			 * Update _jp_autos_currencies
			 * ==========================
			 * @since 0.4
			 */
			case $table == 'PIXAD_CURRENCIES':
				 if( update_option( $key, $value ) )
					echo $this->success();
			break;
		
		endswitch;
	}
	/**
	 * Delete Settings From Database
	 *
	 * $table:
	 * WP_OPTIONS
	 * WP_POSTMETA
	 *
	 * @since 1.0
	 */
	public function delete( $table, $key, $post_id = false, $user_id = false, $meta_key = false, $meta_value = false ) {
		switch( $table ):
			
			/**
			 * Delete from WP_OPTIONS
			 * ======================
			 * @since 1.0
			 */
			case $table == 'WP_OPTIONS':
				 if( delete_option( $key ) )
					echo $this->success();
			break;
		
		endswitch;
	}
	/**
	 * Get option from database
	 *
	 * WP_OPTIONS
	 * WP_POSTMETA
	 *
	 * @since 1.0
	 * @return string || array
	 */
	public function getSettings( $table, $key, $unserialize = false, $user_id = false ) {
		$settings = false; // default settings status, once settings is updated return true
		
		switch( $table ):
		
			case $table == 'WP_OPTIONS' && $unserialize == false:
				 
				 if( get_option( $key ) )
					 $settings = get_option( $key );
				 
			break;
			
			case $table == 'WP_OPTIONS' && $unserialize == true:
			
				 if( get_option( $key ) )
					 $settings = unserialize( get_option( $key ) );
					
			break;
		
		endswitch;

		return $settings;
	}

   public static function getAllSettings( ) {
	    $settings = array(
            "auto-make" => "Auto Make",
            "auto-model" => "Auto Model",
            "auto-version" => "Auto Version",
            "auto-year" => "Year",
            "auto-mileage" => "Mileage",
            "auto-fuel" => "Fuel",
            "auto-engine" => "Engine",
            "auto-horsepower" => "Horsepower",
            "auto-transmission" => "Transmission",
            "auto-drive" => "Drive",
            "auto-doors" => "Doors",
            "auto-seats" => "Seats",
            "auto-color" => "Color",
            "auto-color-int" => "Interior Color",
            "auto-condition" => "Condition",
            "auto-purpose" => "Purpose",
            "auto-vin" => "VIN",
            "auto-price" => "Price",
            "auto-sale-price" => "Sale Price",
            "auto-stock-status" => "Stock Status",
            "auto-price-type" => "Price Type",
            "auto-warranty" => "Warranty",
            "auto-currency" => "Currency",
            "first-name" => "Seller First Name",
            "last-name" => "Seller Last Name",
            "seller-company" => "Seller Company",
            "seller-email" => "Seller Email",
            "seller-phone" => "Seller Phone",
            "seller-country" => "Seller Country",
            "seller-state" => "Seller State",
            "seller-town" => "Seller Town",
            "seller-location" => "Seller Location",
            "seller-location-lat" => "Seller Location Latitude",
            "seller-location-long" => "Seller Location Longitude",
            "auto-date" => "Updated Date"
        );

        return $settings;
    }












	/**
	 * If operation successful, show message
	 *
	 * @since 1.0
	 */
	public function success( $type = null ) {
		if( $type == 'update' ) {
			$message = 'Settings updated!';
		} else {
			$message = 'Settings saved!';
		}
		return	'
			<div id="setting-error-settings_updated" class="updated settings-error">
				<p><strong>'. __( $message, 'pixad' ) .'</strong></p>
			</div>
			<meta http-equiv="refresh" content="0" url="'.$_SERVER['PHP_SELF'].'">
				';
	}
	/**
	 * If operation failed, show message
	 *
	 * @since 1.0
	 */
	public function failed() {
		return	'
			<div id="setting-error-settings_updated" class="error settings-error">
				<p><strong>'. __( 'Operation failed.', 'pixad' ) .'</strong></p>
			</div>
			<meta http-equiv="refresh" content="0" url="'.$_SERVER['PHP_SELF'].'">
				';
	}
}
?>