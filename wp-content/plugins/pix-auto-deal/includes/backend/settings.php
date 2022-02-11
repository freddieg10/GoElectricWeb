<!-- General Settings -->
<?php 
// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;
	
$Settings = new PIXAD_Settings();
$options = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );

if (array_key_exists('autos_price_text', $_POST) && function_exists ( 'icl_register_string' ) ) {
     icl_register_string('pixad', $_POST['autos_price_text'], $_POST['autos_price_text'] );
}  

$_POST['autos_site_currency']		= isset( $_POST['autos_site_currency'] ) ? $_POST['autos_site_currency'] : '';
$_POST['autos_list_style']		= isset( $_POST['autos_list_style'] ) ? $_POST['autos_list_style'] : '';
$_POST['autos_thousand']			= isset( $_POST['autos_thousand'] ) ? $_POST['autos_thousand'] : '';
$_POST['autos_decimal']			    = isset( $_POST['autos_decimal'] ) ? $_POST['autos_decimal'] : '';
$_POST['autos_decimal_number']		= isset( $_POST['autos_decimal_number'] ) ? $_POST['autos_decimal_number'] : '';
$_POST['autos_price_text']			= isset( $_POST['autos_price_text'] ) ? $_POST['autos_price_text'] : '';
$_POST['autos_max_price']			= isset( $_POST['autos_max_price'] ) ? $_POST['autos_max_price'] : '';
$_POST['autos_min_year']			= isset( $_POST['autos_min_year'] ) ? $_POST['autos_min_year'] : '';
$_POST['autos_per_page']			= isset( $_POST['autos_per_page'] ) ? $_POST['autos_per_page'] : '';
$_POST['autos_ajax_scroll_up']			= isset( $_POST['autos_ajax_scroll_up'] ) ? $_POST['autos_ajax_scroll_up'] : '';
$_POST['autos_order']				= isset( $_POST['autos_order'] ) ? $_POST['autos_order'] : '';
$_POST['autos_equipment']			= isset( $_POST['autos_equipment'] ) ? $_POST['autos_equipment'] : '';
$_POST['autos_my_cars_page']		= isset( $_POST['autos_my_cars_page'] ) ? $_POST['autos_my_cars_page'] : '';
$_POST['autos_sell_car_page']		= isset( $_POST['autos_sell_car_page'] ) ? $_POST['autos_sell_car_page'] : '';
$_POST['autos_update_car_page']		= isset( $_POST['autos_update_car_page'] ) ? $_POST['autos_update_car_page'] : '';
$_POST['autos_listing_car_page']		= isset( $_POST['autos_listing_car_page'] ) ? $_POST['autos_listing_car_page'] : '';
$_POST['autos_email_domain'] = isset( $_POST['autos_email_domain'] ) ? $_POST['autos_email_domain'] : '';
$_POST['autos_demo_mode'] = isset( $_POST['autos_demo_mode'] ) ? $_POST['autos_demo_mode'] : '';
$_POST['autos_send_to_email'] = isset( $_POST['autos_send_to_email'] ) ? $_POST['autos_send_to_email'] : '';

$currencies = unserialize( get_option( '_pixad_autos_currencies' ) );
$options['autos_price_text'] = isset($options['autos_price_text']) ? $options['autos_price_text'] : '';
$options['autos_sell_car_page'] = isset( $options['autos_sell_car_page'] ) ? $options['autos_sell_car_page'] : '';	
$options['autos_update_car_page'] = isset( $options['autos_update_car_page'] ) ? $options['autos_update_car_page'] : '';
$options['autos_listing_car_page'] = isset( $options['autos_listing_car_page'] ) ? $options['autos_listing_car_page'] : '';
$options['autos_my_cars_page'] = isset( $options['autos_my_cars_page'] ) ? $options['autos_my_cars_page'] : '';
$options['autos_status_publiс'] = isset( $options['autos_status_publiс'] ) ? $options['autos_status_publiс'] : '';
$options['autos_email_domain'] = isset( $options['autos_email_domain'] ) ? $options['autos_email_domain'] : '';
$options['autos_demo_mode'] = isset( $options['autos_demo_mode'] ) ? $options['autos_demo_mode'] : '';
$options['autos_send_to_email'] = isset( $options['autos_send_to_email'] ) ? $options['autos_send_to_email'] : '';
$statuses = ['publish' =>  esc_html( 'Published post', 'pixad' ),'pending' => esc_html( 'Post on moderation', 'pixad' ), 'draft' => esc_html( 'Draft', 'pixad' ),];
$_POST['autos_no_found'] = isset( $_POST['autos_no_found'] ) ? $_POST['autos_no_found'] : '';
$_POST['autos_reg_user'] = isset( $_POST['autos_reg_user'] ) ? $_POST['autos_reg_user'] : '';


$pages = get_pages();

##############################################################
# SAVE GENERAL SETTINGS INTO DATABASE
##############################################################
if( isset( $_POST['action'] ) && $_POST['action'] == 'save' ):
	
	$args = array(
			'autos_site_currency'		=> esc_attr($_POST['autos_site_currency']),
			'autos_list_style'			=> esc_attr($_POST['autos_list_style']),
			'autos_thousand'			=> esc_attr($_POST['autos_thousand']),
			'autos_decimal'			    => esc_attr($_POST['autos_decimal']),
			'autos_decimal_number'		=> esc_attr($_POST['autos_decimal_number']),
			'autos_price_text'			=> esc_attr($_POST['autos_price_text']),
			'autos_max_price'			=> esc_attr($_POST['autos_max_price']),
			'autos_min_year'			=> esc_attr($_POST['autos_min_year']),
			'autos_per_page'			=> esc_attr($_POST['autos_per_page']),
			'autos_ajax_scroll_up'			=> esc_attr($_POST['autos_ajax_scroll_up']),
			'autos_order'				=> esc_attr($_POST['autos_order']),
			'autos_equipment'			=> esc_attr($_POST['autos_equipment']),
            'autos_my_cars_page'       	=> esc_attr($_POST['autos_my_cars_page']),
            'autos_sell_car_page'       => esc_attr($_POST['autos_sell_car_page']),
			'autos_update_car_page'     => esc_attr($_POST['autos_update_car_page']),
			'autos_listing_car_page'    => esc_attr($_POST['autos_listing_car_page']),
			'autos_status_publiс'     	=> esc_attr($_POST['autos_status_publiс']),
			'autos_no_found'			=> esc_attr($_POST['autos_no_found']),
			'autos_reg_user'			=> esc_attr($_POST['autos_reg_user']),
			'autos_email_domain'		=> esc_attr($_POST['autos_email_domain']),
			'autos_demo_mode'			=> esc_attr($_POST['autos_demo_mode']),
			'autos_send_to_email'			=> esc_attr($_POST['autos_send_to_email']),
	);




	// Save General Settings
	$Settings->update( 'WP_OPTIONS', '_pixad_autos_settings', serialize( $args ) );
    $options['autos_my_cars_page'] = isset( $_POST['autos_my_cars_page'] ) ? $_POST['autos_my_cars_page'] : '';
    $options['autos_sell_car_page'] = isset( $_POST['autos_sell_car_page'] ) ? $_POST['autos_sell_car_page'] : '';
	$options['autos_update_car_page'] = isset( $_POST['autos_update_car_page'] ) ? $_POST['autos_update_car_page'] : '';	
	$options['autos_listing_car_page'] = isset( $_POST['autos_listing_car_page'] ) ? $_POST['autos_listing_car_page'] : '';	
	
endif; ?>
<div class="pixad-panel">
	<div class="pixad-panel-heading">
		<span class="pixad-panel-title"><?php esc_html_e( 'General Settings', 'pixad' ); ?></span>
	</div>
	<div class="pixad-panel-body">
		<form method="post" class="pixad-form-horizontal" role="form">
			<input type="hidden" name="action" value="save">
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label"></label>
				<div class="col-lg-9"><h3><?php esc_html_e( 'General Settings', 'pixad' ); ?></h3></div>
			</div>

			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php esc_html_e( 'Site currency', 'pixad' ); ?>
					<i class="fa fa-question-circle" title="<?php esc_html_e( 'Set site currency.', 'pixad' ); ?>" data-toggle="tooltip" data-placement="top"></i>
				</label>
				<div class="col-lg-9">
					<select name="autos_site_currency" class="pixad-form-control">
					

					<?php if( $currencies ): foreach( $currencies as $currency ): ?>

						<option value="<?php echo $currency['iso']; ?>" <?php selected( $options['autos_site_currency'], $currency['iso'], true ); ?>><?php echo $currency['iso']; ?></option>

					<?php endforeach; else: ?>

						<option value="EUR" <?php selected( $options['autos_site_currency'], 'EUR', true ); ?>><?php echo 'EUR'; ?></option>
						<option value="USD" <?php selected( $options['autos_site_currency'], 'USD', true ); ?>><?php echo 'USD'; ?></option>

					<?php endif; ?>
					</select>
				</div>
			</div>
			  <div class="pixad-form-group">
                <label class="col-lg-2 pixad-control-label">
                    <?php esc_html_e( 'List style', 'pixad' ); ?>
                    <i class="fa fa-question-circle" title="<?php esc_html_e( 'Set list style  for car listing page', 'pixad' ); ?>" data-toggle="tooltip" data-placement="top"></i>
                </label>
                <div class="col-lg-9">
								<select name="autos_list_style" class="pixad-form-control">
										<option value="Grid" <?php selected( $options['autos_list_style'], 'Grid', true ); ?>><?php echo 'Grid'; ?></option>
										<option value="List" <?php selected( $options['autos_list_style'], 'List', true ); ?>><?php echo 'List'; ?></option>	
							</select>
                </div>
            </div>
			

			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php esc_html_e( 'Thousand Separator', 'pixad' ); ?>
					<i class="fa fa-question-circle" title="<?php esc_html_e( 'This sets the thousand separator of displayed prices and mileage.', 'pixad' ); ?>" data-toggle="tooltip" data-placement="top"></i>
				</label>
				<div class="col-lg-9">
					<input name="autos_thousand" class="pixad-form-control" value="<?php echo isset($options['autos_thousand']) ? esc_attr($options['autos_thousand']) : ',' ?>">
				</div>
			</div>

			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php esc_html_e( 'Decimal Separator', 'pixad' ); ?>
					<i class="fa fa-question-circle" title="<?php esc_html_e( 'This sets the decimal separator of displayed prices.', 'pixad' ); ?>" data-toggle="tooltip" data-placement="top"></i>
				</label>
				<div class="col-lg-9">
					<input name="autos_decimal" class="pixad-form-control" value="<?php echo isset($options['autos_decimal']) ? esc_attr($options['autos_decimal']) : '.' ?>">
				</div>
			</div>

			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php esc_html_e( 'Number of Decimals', 'pixad' ); ?>
					<i class="fa fa-question-circle" title="<?php esc_html_e( 'This sets the number of decimal points shown in displayed prices.', 'pixad' ); ?>" data-toggle="tooltip" data-placement="top"></i>
				</label>
				<div class="col-lg-9">
					<input name="autos_decimal_number" class="pixad-form-control" value="<?php echo isset($options['autos_decimal_number']) ? esc_attr($options['autos_decimal_number']) : '2' ?>">
				</div>
			</div>
      
      <div class="pixad-form-group">
          <label class="col-lg-2 pixad-control-label">
              <?php esc_html_e( 'Car listing page', 'pixad' ); ?>
              <i class="fa fa-question-circle" title="<?php esc_html_e( 'Set page for car listing', 'pixad' ); ?>" data-toggle="tooltip" data-placement="top"></i>
          </label>
          <div class="col-lg-9">
              <select name="autos_listing_car_page" class="pixad-form-control">
                  <option <?php selected( $options['autos_listing_car_page'], '', true ); ?> value=""><?php echo esc_html_e('Select page','pixad')?></option>
                  <?php foreach ($pages as $page): ?>
                      <option <?php selected( $options['autos_listing_car_page'], $page->ID, true ); ?> value="<?= $page->ID ?>"><?= $page->post_title ?></option>
                  <?php endforeach;?>
              </select>
          </div>
      </div>
      <div class="pixad-form-group">
          <label class="col-lg-2 pixad-control-label">
              <?php esc_html_e( 'Sell your car page', 'pixad' ); ?>
              <i class="fa fa-question-circle" title="<?php esc_html_e( 'Set page for selling cars', 'pixad' ); ?>" data-toggle="tooltip" data-placement="top"></i>
          </label>
          <div class="col-lg-9">
              <select name="autos_sell_car_page" class="pixad-form-control">
                  <option <?php selected( $options['autos_sell_car_page'], '', true ); ?> value=""><?php echo esc_html_e('Select page','pixad')?></option>
                  <?php foreach ($pages as $page): ?>
                      <option <?php selected( $options['autos_sell_car_page'], $page->ID, true ); ?> value="<?= $page->ID ?>"><?= $page->post_title ?></option>
                  <?php endforeach;?>
              </select>
          </div>
      </div>
      
      
      <div class="pixad-form-group">
          <label class="col-lg-2 pixad-control-label">
              <?php esc_html_e( 'Autos order', 'pixad' ); ?>
              <i class="fa fa-question-circle" title="<?php esc_html_e( 'Default order.', 'pixad' ); ?>" data-toggle="tooltip" data-placement="top"></i>
          </label>
          <div class="col-lg-9">
              <?php $order_display = isset($options['autos_order']) ? $options['autos_order'] : 'date-desc'; ?>
              <select name="autos_order" class="pixad-form-control">
                  <option value="date-desc" <?php selected( $order_display, 'date-desc', true ); ?>><?php esc_html_e( 'Last Added', 'pixad' ); ?></option>
                  <option value="date-asc" <?php selected( $order_display, 'date-asc', true ); ?>><?php esc_html_e( 'First Added', 'pixad' ); ?></option>
                  <option value="_auto_price-asc" <?php selected( $order_display, '_auto_price-asc', true ); ?>><?php esc_html_e( 'Cheap First', 'pixad' ); ?></option>
                  <option value="_auto_price-desc" <?php selected( $order_display, '_auto_price-desc', true ); ?>><?php esc_html_e( 'Expensive First', 'pixad' ); ?></option>
                  <option value="_auto_make-asc" <?php selected( $order_display, '_auto_make-asc', true ); ?>><?php esc_html_e( 'Make A-Z', 'pixad' ); ?></option>
                  <option value="_auto_make-desc" <?php selected( $order_display, '_auto_make-desc', true ); ?>><?php esc_html_e( 'Make Z-A', 'pixad' ); ?></option>
                  <option value="_auto_year-asc" <?php selected( $order_display, '_auto_year-asc', true ); ?>><?php esc_html_e( 'Old First', 'pixad' ); ?></option>
                  <option value="_auto_year-desc" <?php selected( $order_display, '_auto_year-desc', true ); ?>><?php esc_html_e( 'New First', 'pixad' ); ?></option>
              </select>
          </div>
      </div>			

			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php esc_html_e( 'Text After Price', 'pixad' ); ?>
					<i class="fa fa-question-circle" title="<?php esc_html_e( 'Set the text after all prices.', 'pixad' ); ?>" data-toggle="tooltip" data-placement="top"></i>
				</label>
				<div class="col-lg-9">
					<input name="autos_price_text" class="pixad-form-control" value="<?php echo $options['autos_price_text']; ?>">
				</div>
			</div>

			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php esc_html_e( 'Slider max price', 'pixad' ); ?>
					<i class="fa fa-question-circle" title="<?php esc_html_e( 'Set max price for price slider. If max price in slider set to this position, will be shown all autos more expensive than min price.', 'pixad' ); ?>" data-toggle="tooltip" data-placement="top"></i>
				</label>
				<div class="col-lg-9">
					<input name="autos_max_price" class="pixad-form-control" value="<?php echo esc_attr($options['autos_max_price']) ?>">
				</div>
			</div>

						<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php esc_html_e( 'Slider min Year', 'pixad' ); ?>
					<i class="fa fa-question-circle" title="<?php esc_html_e( 'Set min year for slider.', 'pixad' ); ?>" data-toggle="tooltip" data-placement="top"></i>
				</label>
				<div class="col-lg-9">
					<input name="autos_min_year" class="pixad-form-control" value="<?php echo esc_attr($options['autos_min_year']) ?>">
				</div>
			</div>


			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php esc_html_e( 'Use scroll with ajax', 'pixad' ); ?>
					<i class="fa fa-question-circle" title="<?php esc_html_e( 'Use scroll with ajax', 'pixad' ); ?>" data-toggle="tooltip" data-placement="top"></i>
				</label>
				<div class="col-lg-9">
					<?php $autos_ajax_scroll_up = isset($options['autos_ajax_scroll_up']) ? $options['autos_ajax_scroll_up'] : 0; ?>
					<select name="autos_ajax_scroll_up" class="pixad-form-control">
						<option value="0" <?php selected( $autos_ajax_scroll_up, '0', true ); ?>><?php esc_html_e( 'No', 'pixad' ); ?></option>
						<option value="1" <?php selected( $autos_ajax_scroll_up, '1', true ); ?>><?php esc_html_e( 'Yes', 'pixad' ); ?></option>
					</select>
				</div>
			</div>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php esc_html_e( 'Autos per page', 'pixad' ); ?>
					<i class="fa fa-question-circle" title="<?php esc_html_e( 'Set how many posts will be shown per page.', 'pixad' ); ?>" data-toggle="tooltip" data-placement="top"></i>
				</label>
				<div class="col-lg-9">
					<select name="autos_per_page" class="pixad-form-control">
						<?php pixad_get_options_range( 9, 51, $options['autos_per_page'], 3 ); ?>
						<option value="-1" <?php selected( $options['autos_per_page'], '-1', true ); ?>><?php esc_html_e( 'All', 'pixad' ); ?></option>
					</select>
				</div>
			</div>

			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php esc_html_e( 'Show disabled equipment', 'pixad' ); ?>
					<i class="fa fa-question-circle" title="<?php esc_html_e( 'If Yes, enabled and disabled equipment will be displayed on single auto page.', 'pixad' ); ?>" data-toggle="tooltip" data-placement="top"></i>
				</label>
				<div class="col-lg-9">
					<?php $equip_display = isset($options['autos_equipment']) ? $options['autos_equipment'] : 0; ?>
					<select name="autos_equipment" class="pixad-form-control">
						<option value="0" <?php selected( $equip_display, '0', true ); ?>><?php esc_html_e( 'No', 'pixad' ); ?></option>
						<option value="1" <?php selected( $equip_display, '1', true ); ?>><?php esc_html_e( 'Yes', 'pixad' ); ?></option>
					</select>
				</div>
			</div>
            
            <div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php esc_html_e( 'No found text in search result (HTML)', 'pixad' ); ?>
					<i class="fa fa-question-circle" title="<?php esc_html_e( '........', 'pixad' ); ?>" data-toggle="tooltip" data-placement="top"></i>
				</label>
				<div class="col-lg-9">
					<textarea name="autos_no_found" class="pixad-form-control" value="<?php echo isset($options['autos_no_found']) ? esc_attr($options['autos_no_found']) : ',' ?>"><?php echo isset($options['autos_no_found']) ? esc_attr($options['autos_no_found']) : ',' ?></textarea>	
				</div>
			</div>


			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php esc_html_e( 'Action after submitting car of dealer', 'pixad' ); ?>
					<i class="fa fa-question-circle" title="<?php esc_html_e( 'Select the status of publication that will receive auto posts created by users.', 'pixad' ); ?>" data-toggle="tooltip" data-placement="top"></i>
				</label>
				<div class="col-lg-9">
					<?php $status_publiс = isset($options['autos_status_publiс']) ? $options['autos_status_publiс'] : 0; ?>
					<select name="autos_status_publiс" class="pixad-form-control">
						<option value="" ><?php esc_html_e( 'Selected', 'pixad' ); ?></option>
						<?php foreach ($statuses as $key => $status): ?>
							<option value="<?php esc_html_e($key); ?>" <?php selected( $status_publiс, $key, true ); ?>><?php esc_html_e( $status ); ?></option>
						<?php endforeach ?>

					</select>
				</div>
			</div>
			
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php esc_html_e( 'Allowing dealers  without registration ', 'pixad' ); ?>
					<i class="fa fa-question-circle" title="<?php esc_html_e( '........', 'pixad' ); ?>" data-toggle="tooltip" data-placement="top"></i>
				</label>
				<div class="col-lg-9">
					<?php $autos_reg_user = isset($options['autos_reg_user']) ? $options['autos_reg_user'] : 0; ?>
					<select name="autos_reg_user" class="pixad-form-control">
						<option value="0" <?php selected( $autos_reg_user, '0', true ); ?>><?php esc_html_e( 'No', 'pixad' ); ?></option>
						<option value="1" <?php selected( $autos_reg_user, '1', true ); ?>><?php esc_html_e( 'Yes', 'pixad' ); ?></option>
					</select>
				</div>
			</div>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php esc_html_e( 'Auto domain for email of dealers', 'pixad' ); ?>
					<i class="fa fa-question-circle" title="<?php esc_html_e( '......', 'pixad' ); ?>" data-toggle="tooltip" data-placement="top"></i>
				</label>
				<div class="col-lg-9">
					<input name="autos_email_domain" class="pixad-form-control" value="<?php echo $options['autos_email_domain']; ?>">
				</div>
			</div>
			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label">
					<?php esc_html_e( 'Developer mode', 'pixad' ); ?>
					<i class="fa fa-question-circle" title="<?php esc_html_e( '........', 'pixad' ); ?>" data-toggle="tooltip" data-placement="top"></i>
				</label>
				<div class="col-lg-9">
					<?php $autos_demo_mode = isset($options['autos_demo_mode']) ? $options['autos_demo_mode'] : 0; ?>
					<select name="autos_demo_mode" class="pixad-form-control">
						<option value="0" <?php selected( $autos_demo_mode, '0', true ); ?>><?php esc_html_e( 'No', 'pixad' ); ?></option>
						<option value="1" <?php selected( $autos_demo_mode, '1', true ); ?>><?php esc_html_e( 'Yes', 'pixad' ); ?></option>
					</select>
				</div>
			</div>

            <div class="pixad-form-group">
                <label class="col-lg-2 pixad-control-label">
                    <?php esc_html_e( 'Send email to admin email after submitting car of dealer', 'pixad' ); ?>
                    <i class="fa fa-question-circle" title="<?php esc_html_e( '........', 'pixad' ); ?>" data-toggle="tooltip" data-placement="top"></i>
                </label>
                <div class="col-lg-9">
                    <?php $autos_send_to_email = isset($options['autos_send_to_email']) ? $options['autos_send_to_email'] : 0; ?>
                    <?php
                    ?>
                    <select name="autos_send_to_email" class="pixad-form-control">
                        <option value="0" <?php selected( $autos_send_to_email, '0', true ); ?>><?php esc_html_e( 'No', 'pixad' ); ?></option>
                        <option value="1" <?php selected( $autos_send_to_email, '1', true ); ?>><?php esc_html_e( 'Yes', 'pixad' ); ?></option>
                    </select>
                </div>
            </div>


			<div class="pixad-form-group">
				<label class="col-lg-2 pixad-control-label"></label>
				<div class="col-lg-9">
					<?php submit_button(); ?>
				</div>
			</div>
			
		</form>
	</div>
</div>
<script>
jQuery( document ).ready(function($) {
	$('[data-toggle="tooltip"]').tooltip();
});
</script>

<!-- / General Settings-->