<?php

/**
 * Shortcode attributes
 * @var $atts
 * @var $booking_time
 * @var $booking_pick_up_title
 * @var $booking_drop_off_title
 * @var $price_range
 * @var $price_range-title
 * @var $vehicle_body
 * @var $vehicle_body_title
 * @var $vehicle_makers
 * @var $vehicle_makers_title
 * @var $vehicle_model
 * @var $vehicle_model_title
 * @var $fuel_type
 * @var $fuel_type_title
 * @var $mileage_range
 * @var $mileage_range_title
 * @var $year_range
 * @var $year_range_title
 * @var $transmission_type
 * @var $transmission_type_title
 * @var $engine_volume
 * @var $engine_volume_title
 * @var $condition
 * @var $condition_title
 * @var $purpose
 * @var $purpose_title
 * @var $custom_1	
 * @var $custom_2	
 * @var $custom_3	
 * @var $custom_4	
 * @var $custom_5	
 * @var $custom_6	
 * @var $custom_7	
 * @var $custom_8	
 * @var $custom_9	
 * @var $custom_10	
 * @var $custom_11	
 * @var $custom_12	
 * @var $custom_13	
 * @var $custom_14	
 * @var $custom_15	
 * @var $custom_16	
 * @var $custom_17	
 * @var $custom_18	
 * @var $custom_19	
 * @var $custom_20	
 * @var $custom_21	
 * @var $custom_22	
 * @var $custom_23	
 * @var $custom_24	
 * @var $custom_25	
 * @var $custom_26	
 * @var $custom_27	
 * @var $custom_28	
 * @var $custom_29	
 * @var $custom_30	
 * @var $custom_31	
 * @var $custom_32	
 * @var $custom_33	
 * @var $custom_34	
 * @var $custom_35	
 * @var $custom_36	
 * @var $custom_37	
 * @var $custom_38	
 * @var $custom_39	
 * @var $custom_40	
 * @var $custom_41	
 * @var $custom_42	
 * @var $custom_43	
 * @var $custom_44	
 * @var $custom_45	
 * @var $custom_46	
 * @var $custom_47	
 * @var $custom_48	
 * @var $custom_49	
 * @var $custom_40
 * @var $custom_51	
 * @var $custom_52	
 * @var $custom_53	
 * @var $custom_54	
 * @var $custom_55	
 * @var $custom_56	
 * @var $custom_57	
 * @var $custom_58	
 * @var $custom_59	
 * @var $custom_50
 * @var $custom_61	
 * @var $custom_62	
 * @var $custom_63	
 * @var $custom_64	
 * @var $custom_65	
 * @var $custom_66	
 * @var $custom_67	
 * @var $custom_68	
 * @var $custom_69	
 * @var $custom_60
 * @var $custom_71	
 * @var $custom_72	
 * @var $custom_73	
 * @var $custom_74	
 * @var $custom_75	
 * @var $custom_76	
 * @var $custom_77	
 * @var $custom_78	
 * @var $custom_79	
 * @var $custom_80
 * @var $style
 * Shortcode class
 * @var $this WPBakeryShortCode_Vehicle_Search
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$args_tax = array(
	'taxonomy'      => array( 'auto-model' ),
	'orderby'       => 'name',
	'order'         => 'ASC',
	'parent'        => '0',
	'hide_empty'    => '0',

);
$autos_categories = get_categories ($args_tax);


	$all_make_class = !isset($_REQUEST['make']) ? 'jelect-option_state_active' : '';
	$all_model_class = !isset($_REQUEST['model']) ? 'jelect-option_state_active' : '';
	$out_make  = __( 'All Makes', 'autozone');
	$out_author  = __( 'All Dealers', 'autozone');
	$out_model = __( 'All Models', 'autozone');
	$out_makes = $out_models = '';
	$get_make = isset($_REQUEST['make']) ? explode(',', $_REQUEST['make']) : array();
	$get_model = isset($_REQUEST['model']) ? explode(',', $_REQUEST['model']) : array();

	
	$Settings	= new PIXAD_Settings();
	$settings	= $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
	
	$currencies = unserialize( get_option( '_pixad_autos_currencies' ) ); // Get currencies from database
	$currency = $currencies[$settings['autos_site_currency']];
	$currency_symbol = $currency['symbol'];

$url_page_listings = get_page_uri( $settings['autos_listing_car_page']);
if ($url_page_listings !== 'rental') {
	$result_url =  $url_page_listings;
}else{
	$result_url = esc_url(site_url('/vehicle-listings/'));
}
?>
<form action="<?php echo $result_url ?>" method="get" id="findCarNowForm">
	<div class="vc-auto-search <?php echo $style ?>">

				<?php if ($booking_time): ?>

                <?php
                    $hide_timepicker = get_option('pixba_hide_timepicker');
                    if($hide_timepicker != 1){
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

                    ?>
  		<div  class="select select_mod-a jelect">
            <input type="hidden" id="pixad_format_date_search" value="<?php echo esc_attr($format);?>">
							<input data-type="jelect" data-field="time-start" id="pixad-time-start" name="start_time" value="<?php esc_html_e( 'Select date', 'autozone' )?>" readonly data-text="imagemin" type="text" class="pix-input-time" value="<?php echo current_time(get_option('date_format')) ?>" >
							<div class="home-search-label"><?php echo $booking_pick_up_title; ?></div>
						</div>
                            <input id="pixad_date_format" type="hidden" value="<?php echo esc_attr(get_option('date_format'))?>">
						<div  class="select select_mod-a jelect">
							<input data-type="jelect" data-field="time-finish" id="pixad-time-finish" name="finish_time" value="<?php esc_html_e( 'Select date', 'autozone' )?>" readonly data-text="imagemin" type="text" class="pix-input-time" value="<?php echo current_time(get_option('date_format')) ?>" >
							<div class="home-search-label"><?php echo $booking_drop_off_title; ?></div>
						</div>
		<?php endif ?>		

<?php if ($vehicle_body): ?>
				<section class="home-pixad-filter" >
                    
                    
                    <div class="home-search-heading"><?php echo $vehicle_body_title ?></div>
                    
			<?php

				$args_tax = array( 'taxonomy' => 'auto-body', 'hide_empty' => '1');
				$autos_bodies = get_categories ($args_tax);
				if( $autos_bodies ):
					$get_body = isset($_REQUEST['body']) ? explode(',',$_REQUEST['body']) : array();
					echo '<div class="home-search-content">
							<ul class="list-categories body-categories list-unstyled">';
					foreach($autos_bodies as $auto_body) :
						?>
						<li class="list-categories__item">
							<input data-type="check" data-field="body" type="checkbox" <?php echo in_array($auto_body->slug, $get_body) ? 'checked' : ''; ?> name="body" id="<?php echo esc_attr($auto_body->slug) ?>" value="<?php echo esc_attr($auto_body->slug) ?>">
							<label for="<?php echo esc_attr($auto_body->slug) ?>">
								<?php
				$auto_t_id = $auto_body->term_id;
				$auto_cat_meta = get_option("auto_body_$auto_t_id");
				$auto_cat_thumb_url = get_option("pixad_body_thumb$auto_t_id");
				$auto_cat_thumb_filter_url = get_option("pixad_body_thumb_filter$auto_t_id");

				if($auto_cat_thumb_filter_url){
					$img_src = wp_get_attachment_image_src( attachment_url_to_postid( $auto_cat_thumb_filter_url ), 'autozone-body-thumb' );
					$figure = '<img src="'.esc_url($img_src[0]).'" alt="'.esc_attr($auto_body->name).'">';

				}elseif($auto_cat_thumb_url){
					$img_src = wp_get_attachment_image_src( attachment_url_to_postid( $auto_cat_thumb_url ), 'autozone-body-thumb' );
					$figure = '<img src="'.esc_url($img_src[0]).'" alt="'.esc_attr($auto_body->name).'">';
				} elseif(isset($auto_cat_meta['pixad_body_icon'])){
					$figure = '<i class="icon '. esc_attr($auto_cat_meta['pixad_body_icon']) .'"></i>';
				}?>
                <div class="body-icon-wrapper">
								<?php echo wp_kses_post($figure) ?>
								</div>
								<span class="auto_body_name"><?php echo wp_kses_post($auto_body->name) ?></span>
                            
                            </label>
						</li>
						<?php
					endforeach;
					echo '</ul>
					</div>';
				endif;
				?>
				
				</section>
<?php endif?>

<?php if ($vehicle_makers): ?>
		<div  class="select select_mod-a jelect pixad-makes-models-select">
			<input data-type="jelect" data-field="make" id="ajax-make" name="make" value="" data-text="imagemin" type="text" class="jelect-input">
			<div tabindex="0" role="button" class="jelect-current"><?php echo wp_kses_post($out_make) ?></div>
			<ul class="jelect-options">
				<li data-val="" class="jelect-option <?php echo esc_attr($all_make_class) ?>"><?php _e( 'All Makes', 'autozone') ?></li>
				<?php foreach ($autos_categories as $auto_cat) :
						if( in_array($auto_cat->slug, $get_make) ){
							$class_make = 'jelect-option_state_active';
							$out_make = $auto_cat->name;
						} else {
							$class_make = '';
						}
						echo '<li data-val="'.esc_attr($auto_cat->slug).'" class="jelect-option '.esc_attr($class_make).'">'.wp_kses_post($auto_cat->name).'</li>';
					endforeach;
				 ?>
			</ul>
            <div class="home-search-label"><?php echo $vehicle_makers_title ?></div>
        </div>
<?php endif?>

<?php if ($vehicle_authors): ?>
    <?php
        $autos_authors = get_users();
        //var_dump($autos_authors);
    ?>
    <div  class="select select_mod-a jelect pixad-dealers-select">
        <input data-type="jelect" data-field="dealer" id="ajax-dealer" name="dealer" value="" data-text="imagemin" type="text" class="jelect-input">
        <div tabindex="0" role="button" class="jelect-current"><?php echo wp_kses_post($out_author) ?></div>
        <ul class="jelect-options">
            <li data-val="" class="jelect-option <?php echo esc_attr($all_make_class) ?>"><?php _e( 'All Dealers', 'autozone') ?></li>
            <?php foreach ($autos_authors as $auto_aut) :
                //if( in_array($auto_aut->slug, $get_make) ){
                //    $class_make = 'jelect-option_state_active';
                //    $out_make = $auto_cat->name;
              //  } else {
              //      $class_make = '';
             //   }
               echo '<li data-val="'.esc_attr($auto_aut->ID).'" class="jelect-option '.esc_attr($class_make).'">'.wp_kses_post($auto_aut->user_nicename).'</li>';
            endforeach;
            ?>
        </ul>
        <div class="home-search-label"><?php echo $vehicle_authors_title ?></div>
    </div>
<?php endif?>

<?php if ($vehicle_model && $vehicle_makers): ?>
		<?php
		if(!empty($get_make)){
			$make_term = get_term_by('slug', $get_make[0], 'auto-model');
			$args = array(
				'taxonomy'      => 'auto-model',
				'orderby'       => 'name',
				'order'         => 'ASC',
				'parent'        => $make_term->term_id,
				'hide_empty'    => false,
			);
			$terms_arr = get_terms( $args );

		}
		?>

		<div class="select select_mod-a jelect">
			<input data-type="jelect" data-field="model" id="pixad-model" name="model" value="" data-text="imagemin" type="text" class="jelect-input">
			<input type="hidden" class="pixad-model-default-hidden" value="<?php esc_attr_e( 'All Models', 'autozone') ?>">
			<div tabindex="0" role="button" class="jelect-current pixad-model"><?php echo wp_kses_post($out_model) ?></div>
			<ul class="jelect-options pixad-model">
				<li data-val="" class="jelect-option <?php echo esc_attr($all_model_class) ?>"><?php _e( 'All Models', 'autozone') ?></li>

				<?php 
					if (!empty($get_make) ) {
					
				foreach ($terms_arr as $k => $v) {
					if( in_array($v->slug, $get_model) ){
						$class_model = 'jelect-option_state_active';
						$out_model = $v->name;
					} else {
						$class_model = '';
					}
					echo '<li data-val="'.esc_attr($v->slug).'" class="jelect-option '.esc_attr($class_model).'">'.wp_kses_post($v->name).'</li>';
				} 
				}

				?>
			</ul>
		 <div class="home-search-label"><?php echo $vehicle_model_title ?></div></div>
  <?php endif?>

<?php if ($condition): ?>
		<div class="select select_mod-a jelect">
			<input data-type="jelect" data-field="type" id="pixad-type" name="condition" value="" data-text="imagemin" type="text" class="jelect-input">
			<input type="hidden" class="pixad-type-default-hidden" value="<?php esc_attr_e( 'Vehicle Status', 'autozone') ?>">	
			<div tabindex="0" role="button" class="jelect-current pixad-type"><?php esc_attr_e( 'Vehicle Status', 'autozone') ?></div>		
			<ul class="jelect-options pixad-type">
				<li data-val="" class="jelect-option <?php echo esc_attr($all_model_class) ?>"><?php _e( 'Vehicle Status', 'autozone') ?></li>
				<li data-val="new" class="jelect-option"><?php _e( 'New', 'autozone') ?></li>
				<li data-val="used" class="jelect-option"><?php _e( 'Used', 'autozone') ?></li>
				
			</ul>
            
            <div class="home-search-label"><?php echo $condition_title; ?></div>
                    
		</div>
<?php endif ?>


<?php if ($purpose): ?>
		<div  class="select select_mod-a jelect">
							<input data-type="jelect" data-field="purpose" id="pixad-purpose" name="purpose" value="" data-text="imagemin" type="text" class="jelect-input">
							<div tabindex="0" role="button" class="jelect-current"><?php esc_html_e( 'All purposes', 'autozone') ?></div>
							<ul class="jelect-options">
								<li data-val="" class="jelect-option jelect-option_state_active"><?php esc_html_e( 'All purposes', 'autozone') ?></li>
								<li data-val="rent" class="jelect-option"><?php esc_html_e( 'Rent', 'autozone') ?></li>
								<li data-val="sell" class="jelect-option"><?php esc_html_e( 'Sell', 'autozone') ?></li>
                                <li data-val="sold" class="jelect-option"><?php esc_html_e( 'Sold', 'autozone') ?></li>

                            </ul>
							 <div class="home-search-label"><?php echo $purpose_title; ?></div>
						</div>
<?php endif ?>






<?php if ($price_range): ?>
	
		<div class="slider-price">
			<div class="noUi-target noUi-ltr noUi-horizontal noUi-background" id="slider-price">

			</div>
			<span class="slider-price__wrap-input">
                
                
                <div class="tmpl-slide-price-left">
				
                <span class="currency-symbol">
                    <?php echo esc_attr($currency_symbol)?>
                </span>
                <input data-type="number" data-field="price" class="slider-price__input" id="slider-price_min" >
                </div>
                

                  <div class="tmpl-slide-price-right">
				<span class="currency-symbol">
                    <?php echo esc_attr($currency_symbol)?></span>
                
                <input data-type="number" data-field="price" class="slider-price__input" id="slider-price_max" >
                </div>
                
				<input name="price" type="hidden" id="slider-price_total"/>
				<input type="hidden" id="pix-min-price" value="">
				<input type="hidden" id="pix-max-price" value="">
				<input type="hidden" id="pix-max-slider-price" value="<?php echo esc_attr($settings['autos_max_price']) ?>">
				<input type="hidden" id="pix-min-slider-year" value="<?php echo esc_attr($settings['autos_min_year']) ?>">
				<input type="hidden" id="pix-currency-symbol" value="$">
				<input type="hidden" id="pix-thousand" value="<?php echo esc_attr($settings['autos_thousand']) ?>">
				<input type="hidden" id="pix-decimal" value="<?php echo esc_attr($settings['autos_decimal']) ?>">
				<input type="hidden" id="pix-decimal_number" value="<?php echo esc_attr($settings['autos_decimal_number']) ?>">
			</span>

			<div class="home-search-label"><?php echo $price_range_title; ?></div>
				</div>
			
<?php endif ?>
<?php if ($fuel_type): ?>
					<div  class="select select_mod-a jelect">
							<input data-type="jelect" data-field="fuel" id="pixad-fuel" name="fuel" value="" data-text="imagemin" type="text" class="jelect-input">
							<div tabindex="0" role="button" class="jelect-current"><?php esc_html_e( 'All Fuel Types', 'autozone') ?></div>
							<ul class="jelect-options">
								<li data-val="" class="jelect-option jelect-option_state_active"><?php esc_html_e( 'All Fuel Types', 'autozone') ?></li>
								<li data-val="petrol" class="jelect-option"><?php esc_html_e( 'Petrol', 'autozone') ?></li>
								<li data-val="diesel" class="jelect-option"><?php esc_html_e( 'Diesel', 'autozone') ?></li>
								<li data-val="hybrid" class="jelect-option"><?php esc_html_e( 'Hybrid', 'autozone') ?></li>
								<li data-val="plugin_electric" class="jelect-option"><?php esc_html_e( 'Plugin electric', 'autozone') ?></li>
								<li data-val="electric" class="jelect-option"><?php esc_html_e( 'Electric', 'autozone') ?></li>
								<li data-val="petrol+cng" class="jelect-option"><?php esc_html_e( 'Petrol+CNG', 'autozone') ?></li>
								<li data-val="lpg" class="jelect-option"><?php esc_html_e( 'LPG', 'autozone') ?></li>
							</ul>

							<div class="home-search-label"><?php echo $fuel_type_title; ?></div>
						</div>
<?php endif ?>
<?php if ($transmission_type): ?>
					<div  class="select select_mod-a jelect">
							<input data-type="jelect" data-field="transmission" id="pixad-transmission" name="transmission" value="" data-text="imagemin" type="text" class="jelect-input">
							<div tabindex="0" role="button" class="jelect-current"><?php esc_html_e( 'All Transmissions', 'autozone') ?></div>
							<ul class="jelect-options">
								<li data-val="" class="jelect-option jelect-option_state_active"><?php esc_html_e( 'All Transmissions', 'autozone') ?></li>
								<li data-val="automatic" class="jelect-option"><?php esc_html_e( 'Automatic', 'autozone') ?></li>
								<li data-val="manual" class="jelect-option"><?php esc_html_e( 'Manual', 'autozone') ?></li>
								<li data-val="semi-automatic" class="jelect-option"><?php esc_html_e( 'Semi-Automatic', 'autozone') ?></li>
							</ul>

							<div class="home-search-label"><?php echo $transmission_type_title; ?></div>
					</div>
<?php endif ?>
<?php if ($mileage_range): ?>
					<div class="select select_mod-a jelect">
						<div class="slider-price" id="slider-mileage"></div>
						<span class="slider-price__wrap-input">
							<input data-type="number" data-field="mileage" class="slider-price__input" id="slider-mileage_min" >
							<span>-</span>
							<input data-type="number" data-field="mileage" class="slider-price__input" id="slider-mileage_max" >
							<input type="hidden" id="pix-min-mileage" value="<?php echo isset($get_mileage[0]) ? esc_attr($get_mileage[0]) : ''; ?>">
							<input type="hidden" id="pix-max-mileage" value="<?php echo isset($get_mileage[1]) ? esc_attr($get_mileage[1]) : ''; ?>">
							<input type="hidden" id="pix-max-slider-mileage" value="500000">
							<input name="mileage" type="hidden" id="pix-max-slider-mileage_total"/>
						</span>

						<div class="home-search-label"><?php echo $mileage_range_title; ?></div>
					</div>
<?php endif ?>
<?php if ($year_range): ?>
					<div class="select select_mod-a jelect">
						<div class="slider-price" id="slider-year"></div>
						<span class="slider-price__wrap-input">
							<input data-type="number" data-field="autoyear" class="slider-price__input" id="slider-year_min" >
							<span>-</span>
							<input data-type="number" data-field="autoyear" class="slider-price__input" id="slider-year_max">
							<input type="hidden" id="pix-min-year" value="<?php echo isset($get_year[0]) ? esc_attr($get_year[0]) : ''; ?>">
							<input type="hidden" id="pix-max-year" value="<?php echo isset($get_year[1]) ? esc_attr($get_year[1]) : ''; ?>">
							<input type="hidden" id="pix-max-slider-year" value="<?php echo esc_attr(date('Y')+1) ?>">
							<input name="autoyear" type="hidden" id="pix-max-slider-year_total"/>
						</span>
						<div class="home-search-label"><?php echo $year_range_title; ?></div>
					</div>
<?php endif ?>
<?php if ($engine_volume): ?>
					<div class="select select_mod-a jelect">
						<div class="slider-price" id="slider-engine"></div>
						<span class="slider-price__wrap-input">
							<input data-type="number" data-field="engine" class="slider-price__input" id="slider-engine_min" >
							<span>-</span>
							<input data-type="number" data-field="engine" class="slider-price__input" id="slider-engine_max" >
							<input type="hidden" id="pix-min-engine" value="<?php echo isset($get_engine[0]) ? esc_attr($get_engine[0]) : ''; ?>">
							<input type="hidden" id="pix-max-engine" value="<?php echo isset($get_engine[1]) ? esc_attr($get_engine[1]) : ''; ?>">
							<input type="hidden" id="pix-max-slider-engine" value="7">
							<input name="engine" type="hidden" id="pix-max-slider-engine_total"/>
						</span>
						<div class="home-search-label"><?php echo $engine_volume_title; ?></div>
					</div>
	<?php endif ?>	




<?php 
global $post;
$Settings = new PIXAD_Settings();
$settings	= $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
$validate = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_validation', true ); 
$validate = pixad::validation( $validate );

$args = array( 'post_type' => 'pixad-autos', 'posts_per_page' => -1,); 
$rand_posts = get_posts( $args );

$custom_settings_quantity = 1;
while ($custom_settings_quantity <= 80) {
	${'_custom_'.$custom_settings_quantity.'_setting_value'} = array();
		$custom_settings_quantity++; 
}
foreach( $rand_posts as $post ) : ?>
	<?php  
	$custom_settings_quantity = 1;
	while ($custom_settings_quantity <= 80) {
			
			$_custom_setting_key = get_post_custom_values('_custom_'.$custom_settings_quantity.''); // Получили  характеристику
			if ($_custom_setting_key[0] !== '') {    // Проверили или есть значение у характеристики
				$_custom_setting_key[0] = str_replace(' ', '_', $_custom_setting_key[0]);
				array_push(${'_custom_'.$custom_settings_quantity.'_setting_value'}, $_custom_setting_key[0]); // Добавили значение в нужный массив 
			}
			$custom_settings_quantity++; 
	} ?>
	
<?php endforeach; ?>
<?php  wp_reset_postdata() ?>

<?php 
$custom_settings_quantity = 1;
while ($custom_settings_quantity <= 80) {
	${'_custom_'.$custom_settings_quantity.'_setting_value'} = array_unique(array_filter(${'_custom_'.$custom_settings_quantity.'_setting_value'}));
?> 

<?php // print_r($_custom_1_setting_value) ?>


<?php if(!empty(${'_custom_'.$custom_settings_quantity.'_setting_value'})  && ${'custom_'.$custom_settings_quantity} ) {?>

	
						<div  class="select select_mod-a jelect">
							<input data-type="jelect" data-field="<?php echo 'custom_'. $custom_settings_quantity .''; ?>" id="<?php echo 'pixad-custom_'. $custom_settings_quantity .''; ?>" name="<?php echo 'custom_'. $custom_settings_quantity .''; ?>" value="" data-text="imagemin" type="text" class="jelect-input">
							<div tabindex="0" role="button" class="jelect-current"><?php echo $validate['custom_'. $custom_settings_quantity .'_name']; ?></div>
							<ul class="jelect-options">
								<li data-val="" class="jelect-option jelect-option_state_active"><?php esc_html_e( 'All', 'autozone') ?></li>
							<?php
								foreach (${'_custom_'.$custom_settings_quantity.'_setting_value'} as $key => $value) {?>
									<li data-val="<?php echo $value; ?>" class="jelect-option"><?php echo str_replace('_', ' ', $value); ?></li>
							<?php } ?>
						  </ul>
						  <div class="home-search-label"><?php echo  $validate['custom_'. $custom_settings_quantity .'_name']; ?></div>
						</div>
					
<?php }?>

	<?php	$custom_settings_quantity++; 
}?>


		<div class="btn">
				<div class="btn-filter wrap__btn-skew-r js-filter">
									<button type="button" onclick="findCarNowVc(); return false;"  class="btn-skew-r btn-effect"><span class="btn-skew-r__inner"><?php echo esc_html_e('Find It Now','autozone')?></span></button>

				</div>
			</div>

	</div>
</form>




<script type="text/javascript">
	function findCarNowVc(){

		/*PRICE*/

		var _price_from = jQuery('#slider-price_min').val();
		if (_price_from) {
			_price_from = _price_from.replace(/\D/g, "");
		}


		var _price_to = jQuery('#slider-price_max').val();
		if (_price_to) {
			_price_to = _price_to.replace(/\D/g, "");
		}
		jQuery('#slider-price_total').val(_price_from + "," + _price_to);

		/*BODY*/
		var checked_body = '';
		jQuery("input[name='body']").each(function(key,val) {
			if( jQuery(this).prop( "checked" ) ){
				checked_body = checked_body + ',' + jQuery(this).val();
			}
		});
		jQuery("input[name='body']").val(checked_body);

		/*MILEAGE*/
		var mileage_from = jQuery('#slider-mileage_min').val();
		var mileage_to = jQuery('#slider-mileage_max').val();
		jQuery('#pix-max-slider-mileage_total').val(mileage_from + "," + mileage_to);

		/*YEAR*/
		var year_from = jQuery('#slider-year_min').val();
		var year_to = jQuery('#slider-year_max').val();
		jQuery('#pix-max-slider-year_total').val(year_from + "," + year_to);

		/*ENGINE*/
		var engine_from = jQuery('#slider-engine_min').val();
		var engine_to = jQuery('#slider-engine_max').val();
		jQuery('#pix-max-slider-engine_total').val(engine_from + "," + engine_to);



		jQuery('#findCarNowForm').submit();
		
	}
</script>
	