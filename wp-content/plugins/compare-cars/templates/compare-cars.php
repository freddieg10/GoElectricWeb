<?php
/*
Template Name: Compare Page
Template Post Type: page
*/

get_header();

function compare_mobile_is_value($auto_translate, $Auto,  $attr){

  $var = isset($auto_translate[$Auto->get_meta($attr)]) ? $auto_translate[$Auto->get_meta($attr)] : $Auto->get_meta($attr); 
  return  (!empty($var)) ? 1 : 0;
}
function mobile_compare_row($auto_translate, $Auto,  $attr, $name ){

  $var = isset($auto_translate[$Auto->get_meta($attr)]) ? $auto_translate[$Auto->get_meta($attr)] : $Auto->get_meta($attr);  
   $class = (!empty($var)) ? 'mobile-compare-value' : 'mobile-compare-value compare-value-empty';
  ?>
  <span class="<?php echo $class; ?>"><?php echo $name; ?></span>
  <?php
}
global $post;
$body_compare = '';
$validate_copy;
$header_compare= '';


	 ob_start(); ?>
	<div class="col-md-3 col-sm-3 col-xs-12">
        <h2 class="compare-title">
        </h2>
        <div class="colored-separator text-left">
            <div class="first-long">
            </div>
            <div class="last-short">
            </div>
        </div>
  </div>
	<?php 
		$header_compare .= ob_get_clean();

    $id0 = null;
    if(!empty($_COOKIE["add-to-compare0"])){
        $id0 =  htmlspecialchars($_COOKIE["add-to-compare0"]);
    }
 $id1 = null;
	    if(!empty( $_COOKIE["add-to-compare1"])){
       $id1 =  htmlspecialchars($_COOKIE["add-to-compare1"]);
    }
	 $id2 = null;
      if(!empty( $_COOKIE["add-to-compare2"])){
       $id2 =  htmlspecialchars($_COOKIE["add-to-compare2"]);
    }

	$exclude_ids = array( $id0, $id1, $id2 );
	$counter= 0;
	$args = array( 
	    'post_type' => array('pixad-autos', ),
	    'post__in' => $exclude_ids,
	    'posts_per_page' => 3,
	);
	$the_query = new WP_Query( $args );
	if ( $the_query->have_posts() ) :
	while ( $the_query->have_posts() ) : $the_query->the_post();

	$counter++;

	$Settings = new PIXAD_Settings();
	$validate = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_validation', true ); // Get validation settings
	$validate = pixad::validation( $validate );
	$Auto = new PIXAD_Autos();
	$Auto->Query_Args( array('auto_id' => 376) );
	$auto_translate = unserialize( get_option( '_pixad_auto_translate' ) );
  $post_id_7 = get_post( $post->ID );
	$has_video = false;

	$video_attachments = array();
	$videos = pixad_get_attach_video($post->ID);
	//$videos = explode(',', $videos[0]);
	if(isset($videos[0]) && $videos[0] != '') {
		$video_attachments = get_posts( array(
			'post_type' => 'attachment',
			'include' => $videos[0]
		) );
	}

	if(count($video_attachments)>0 || pixad_get_external_video($post->ID) != '') {
		$has_video = true;
	}

	$custom =  get_post_custom($post->ID);

	$pix_options = get_option('pix_general_settings');

	$pix_show_specifications = get_post_meta( get_the_ID(), 'pixad_auto_specifications', true ) != '' ? get_post_meta( get_the_ID(), 'pixad_auto_specifications', true ) : 1;
	$pix_show_related = get_post_meta( get_the_ID(), 'pixad_auto_related', true ) != '' ? get_post_meta( get_the_ID(), 'pixad_auto_related', true ) : 1;
	$pix_show_share = get_post_meta( get_the_ID(), 'pixad_auto_share', true ) != '' ? get_post_meta( get_the_ID(), 'pixad_auto_share', true ) : 1;


 ob_start();

 ?>
    <div class="col-md-3 col-sm-3 col-xs-12 compare-col-auto" data-id="<?php the_ID(); ?>">
     	<div class="compare-values">
        <table>
          <tbody>
            <tr class="car-title-mobile-row">
              <td class="compare-value-hover" data-value="1">
                <div class="h5 car-title-mobile"><?php the_title( ); ?></div>
              </td>
            </tr>
           	<?php if( $validate['auto-stock-status_show'] ): ?>
            <tr>
              <td class="compare-value-hover <?php echo !compare_mobile_is_value($auto_translate, $Auto,  '_auto_stock_status') ? 'compare-value-col-empty' : '';?>" data-value="1">
                 <?php mobile_compare_row($auto_translate, $Auto, '_auto_stock_status', esc_html__( 'Stock status', 'compare_cars' ) ) ?>
                <div class="h5" data-option="Body"><?php $var = isset($auto_translate[$Auto->get_meta('_auto_stock_status')]) ? $auto_translate[$Auto->get_meta('_auto_stock_status')] : $Auto->get_meta('_auto_stock_status'); echo esc_attr( wp_kses_post( $var )) ?></div>
              </td>
            </tr>
            <?php endif; ?>
           	<?php if( $validate['auto-year_show'] ): ?>
            <tr>
              <td class="compare-value-hover <?php echo !compare_mobile_is_value($auto_translate, $Auto,  '_auto_year') ? 'compare-value-col-empty' : '';?>" data-value="2">
                <?php mobile_compare_row($auto_translate, $Auto, '_auto_year', esc_html__( 'Made Year', 'compare_cars' ) ) ?>
                <div class="h5" data-option="Body"><?php $var = isset($auto_translate[$Auto->get_meta('_auto_year')]) ? $auto_translate[$Auto->get_meta('_auto_year')] : $Auto->get_meta('_auto_year'); echo esc_attr( wp_kses_post( $var )) ?></div>
              </td>
            </tr>
            <?php endif; ?> 
           	<?php if($validate['auto-mileage_show']  ): ?>
            <tr>
              <td class="compare-value-hover <?php echo !compare_mobile_is_value($auto_translate, $Auto,  '_auto_mileage') ? 'compare-value-col-empty' : '';?>" data-value="3">
                <?php mobile_compare_row($auto_translate, $Auto, '_auto_mileage', esc_html__( 'Mileage', 'compare_cars' ) ) ?>
                <div class="h5" data-option="Body"><?php $var = isset($auto_translate[$Auto->get_meta('_auto_mileage')]) ? $auto_translate[$Auto->get_meta('_auto_mileage')] : $Auto->get_meta('_auto_mileage');  echo esc_attr( wp_kses_post( $var )) ?></div>
              </td>
            </tr>
            <?php endif; ?> 
					<?php if( $validate['auto-vin_show']  ): ?>
            <tr>
              <td class="compare-value-hover <?php echo !compare_mobile_is_value($auto_translate, $Auto,  '_auto_vin') ? 'compare-value-col-empty' : '';?>" data-value="4">
                <?php mobile_compare_row($auto_translate, $Auto, '_auto_vin', esc_html__( 'VIN', 'compare_cars' ) ) ?>
                <div class="h5" data-option="Body"><?php $var = isset($auto_translate[$Auto->get_meta('_auto_vin')]) ? $auto_translate[$Auto->get_meta('_auto_vin')] : $Auto->get_meta('_auto_vin');  echo esc_attr(wp_kses_post( $var )) ?></div>
              </td>
            </tr>
            <?php endif; ?> 
					<?php if( $validate['auto-version_show']  ): ?>
            <tr>
              <td class="compare-value-hover <?php echo !compare_mobile_is_value($auto_translate, $Auto,  '_auto_version') ? 'compare-value-col-empty' : '';?>" data-value="5">
                <?php mobile_compare_row($auto_translate, $Auto, '_auto_version', esc_html__( 'Version', 'compare_cars' ) ) ?>
                <div class="h5" data-option="Body"><?php $var = isset($auto_translate[$Auto->get_meta('_auto_version')]) ? $auto_translate[$Auto->get_meta('_auto_version')] : $Auto->get_meta('_auto_version');  echo esc_attr(wp_kses_post( $var )) ?></div>
              </td>
            </tr>
            <?php endif; ?> 
					<?php if( $validate['auto-fuel_show'] ): ?>
            <tr>
              <td class="compare-value-hover <?php echo !compare_mobile_is_value($auto_translate, $Auto,  '_auto_fuel') ? 'compare-value-col-empty' : '';?>" data-value="6">
                <?php mobile_compare_row($auto_translate, $Auto, '_auto_fuel', esc_html__( 'Fuel', 'compare_cars' ) ) ?>
                <div class="h5" data-option="Body"><?php $var = isset($auto_translate[$Auto->get_meta('_auto_fuel')]) ? $auto_translate[$Auto->get_meta('_auto_fuel')] : $Auto->get_meta('_auto_fuel');  echo esc_attr(wp_kses_post( $var )) ?></div>
              </td>
            </tr>
            <?php endif; ?>
					<?php if( $validate['auto-engine_show']  ): ?>
            <tr>
              <td class="compare-value-hover <?php echo !compare_mobile_is_value($auto_translate, $Auto,  '_auto_engine') ? 'compare-value-col-empty' : '';?>" data-value="7">
                <?php mobile_compare_row($auto_translate, $Auto, '_auto_engine', esc_html__( 'Engine (cm3)', 'compare_cars' ) ) ?>
                <div class="h5" data-option="Body"><?php $var = isset($auto_translate[$Auto->get_meta('_auto_engine')]) ? $auto_translate[$Auto->get_meta('_auto_engine')] : $Auto->get_meta('_auto_engine');  echo esc_attr( wp_kses_post( $var )) ?></div>
              </td>
            </tr>
            <?php endif; ?> 
					<?php if( $validate['auto-horsepower_show']  ): ?>
            <tr>
              <td class="compare-value-hover <?php echo !compare_mobile_is_value($auto_translate, $Auto,  '_auto_horsepower') ? 'compare-value-col-empty' : '';?>" data-value="8">
                <?php mobile_compare_row($auto_translate, $Auto, '_auto_horsepower', esc_html__( 'Horsepower (hp)', 'compare_cars' ) ) ?>
                <div class="h5" data-option="Body"><?php $var = isset($auto_translate[$Auto->get_meta('_auto_horsepower')]) ? $auto_translate[$Auto->get_meta('_auto_horsepower')] : $Auto->get_meta('_auto_horsepower');  echo esc_attr( wp_kses_post( $var )) ?></div>
              </td>
            </tr>
            <?php endif; ?> 
					<?php if( $validate['auto-transmission_show']  ) : ?>
            <tr>
              <td class="compare-value-hover <?php echo !compare_mobile_is_value($auto_translate, $Auto,  '_auto_transmission') ? 'compare-value-col-empty' : '';?>" data-value="9">
                <?php mobile_compare_row($auto_translate, $Auto, '_auto_transmission', esc_html__( 'Transmission', 'compare_cars' ) ) ?>
                <div class="h5" data-option="Body"><?php $var = isset($auto_translate[$Auto->get_meta('_auto_transmission')]) ? $auto_translate[$Auto->get_meta('_auto_transmission')] : $Auto->get_meta('_auto_transmission');  echo esc_attr( wp_kses_post( $var )) ?></div>
              </td>
            </tr>
            <?php endif; ?>
					<?php if( $validate['auto-doors_show']  ): ?>
            <tr>
              <td class="compare-value-hover <?php echo !compare_mobile_is_value($auto_translate, $Auto,  '_auto_doors') ? 'compare-value-col-empty' : '';?>" data-value="10">
                <?php mobile_compare_row($auto_translate, $Auto, '_auto_doors', esc_html__( 'Doors', 'compare_cars' ) ) ?>
                <div class="h5" data-option="Body"><?php $var = isset($auto_translate[$Auto->get_meta('_auto_doors')]) ? $auto_translate[$Auto->get_meta('_auto_doors')] : $Auto->get_meta('_auto_doors');  echo esc_attr( wp_kses_post( $var )) ?></div>
              </td>
            </tr>
            <?php endif; ?> 
					<?php if( $validate['auto-condition_show']  ): ?>
            <tr>
              <td class="compare-value-hover <?php echo !compare_mobile_is_value($auto_translate, $Auto,  '_auto_condition') ? 'compare-value-col-empty' : '';?>" data-value="11">
                <?php mobile_compare_row($auto_translate, $Auto, '_auto_condition', esc_html__( 'Condition', 'compare_cars' ) ) ?>
                <div class="h5" data-option="Body"><?php $var = isset($auto_translate[$Auto->get_meta('_auto_condition')]) ? $auto_translate[$Auto->get_meta('_auto_condition')] : $Auto->get_meta('_auto_condition');  echo esc_attr( wp_kses_post( $var )) ?></div>
              </td>
            </tr>
            <?php endif; ?> 
					<?php if( $validate['auto-drive_show']  ): ?>
            <tr>
              <td class="compare-value-hover <?php echo !compare_mobile_is_value($auto_translate, $Auto,  '_auto_drive') ? 'compare-value-col-empty' : '';?>" data-value="12">
                <?php mobile_compare_row($auto_translate, $Auto, '_auto_drive', esc_html__( 'Drive', 'compare_cars' ) ) ?>
                <div class="h5" data-option="Body"><?php $var = isset($auto_translate[$Auto->get_meta('_auto_drive')]) ? $auto_translate[$Auto->get_meta('_auto_drive')] : $Auto->get_meta('_auto_drive');  echo esc_attr( wp_kses_post( $var .' '.esc_html__( 'drive', 'compare_cars' ) )) ?></div>
              </td>
            </tr>
            <?php endif; ?>
						<?php if( $validate['auto-seats_show'] ): ?>
            <tr>
              <td class="compare-value-hover <?php echo !compare_mobile_is_value($auto_translate, $Auto,  '_auto_seats') ? 'compare-value-col-empty' : '';?>" data-value="13">
                <?php mobile_compare_row($auto_translate, $Auto, '_auto_seats', esc_html__( 'Seats', 'compare_cars' ) ) ?>
                <div class="h5" data-option="Body"><?php $var = isset($auto_translate[$Auto->get_meta('_auto_seats')]) ? $auto_translate[$Auto->get_meta('_auto_seats')] : $Auto->get_meta('_auto_seats');   echo esc_attr( wp_kses_post( $var )) ?></div>
              </td>
            </tr>
            <?php endif; ?>
						<?php if( $validate['auto-color_show']): ?>
            <tr>
              <td class="compare-value-hover <?php echo !compare_mobile_is_value($auto_translate, $Auto,  '_auto_color') ? 'compare-value-col-empty' : '';?>" data-value="14">
                 <?php mobile_compare_row($auto_translate, $Auto, '_auto_color', esc_html__( 'Color', 'compare_cars' ) ) ?>
                <div class="h5" data-option="Body"><?php $color = isset($auto_translate[$Auto->get_meta('_auto_color')]) ? $auto_translate[$Auto->get_meta('_auto_color')] : $Auto->get_meta('_auto_color');  echo esc_attr(wp_kses_post( $color )) ?></div>
              </td>
            </tr>
            <?php endif; ?>
					<?php if( $validate['auto-color-int_show']  ): ?>
            <tr>
              <td class="compare-value-hover <?php echo !compare_mobile_is_value($auto_translate, $Auto,  '_auto_color_int') ? 'compare-value-col-empty' : '';?>" data-value="15">
                 <?php mobile_compare_row($auto_translate, $Auto, '_auto_color_int', esc_html__( 'Interior Color', 'compare_cars' ) ) ?>
                <div class="h5" data-option="Body"><?php $color_int = isset($auto_translate[$Auto->get_meta('_auto_color_int')]) ? $auto_translate[$Auto->get_meta('_auto_color_int')] : $Auto->get_meta('_auto_color_int');  echo esc_attr(wp_kses_post( $color_int )) ?></div>
              </td>
            </tr>
            <?php endif; ?>
					<?php if( $validate['auto-price-type_show']  ): ?>
            <tr>
              <td class="compare-value-hover <?php echo !compare_mobile_is_value($auto_translate, $Auto,  '_auto_price_type') ? 'compare-value-col-empty' : '';?>" data-value="16">
                 <?php mobile_compare_row($auto_translate, $Auto, '_auto_price_type', esc_html__( 'Price Type', 'compare_cars' ) ) ?>
                <div class="h5" data-option="Body"><?php $var = isset($auto_translate[$Auto->get_meta('_auto_price_type')]) ? $auto_translate[$Auto->get_meta('_auto_price_type')] : $Auto->get_meta('_auto_price_type');  echo esc_attr(wp_kses_post( $var )) ?></div>
              </td>
            </tr>
            <?php endif; ?>
					<?php if( $validate['auto-warranty_show']  ): ?>
            <tr>
              <td class="compare-value-hover <?php echo !compare_mobile_is_value($auto_translate, $Auto,  '_auto_warranty') ? 'compare-value-col-empty' : '';?>" data-value="17">
                <?php mobile_compare_row($auto_translate, $Auto, '_auto_warranty', esc_html__( 'Warranty', 'compare_cars' ) ) ?>
                <div class="h5" data-option="Body"><?php $var = isset($auto_translate[$Auto->get_meta('_auto_warranty')]) ? $auto_translate[$Auto->get_meta('_auto_warranty')] : $Auto->get_meta('_auto_warranty');  echo esc_attr(wp_kses_post( $var )) ?></div>
              </td>
            </tr>
            <?php endif; ?>      
               <?php 
                  $custom_settings_quantity = 1;
                  $max_custom_settings_quantity = 35;
                  $data_val = 18;
                  while ($custom_settings_quantity <= $max_custom_settings_quantity): 
                    if( $validate['custom_'. $custom_settings_quantity .'_show']  ): ?>  
                      <tr>
                        <td class="compare-value-hover <?php echo !compare_mobile_is_value($auto_translate, $Auto,  '_custom_'. $custom_settings_quantity .'') ? 'compare-value-col-empty' : '';?>" data-value="<?php echo esc_attr($data_val) ?>">
                           <?php mobile_compare_row($auto_translate, $Auto, '_custom_'. $custom_settings_quantity .'', esc_html__( $validate['custom_'. $custom_settings_quantity .'_name'] ) ) ?>
                          <div class="h5" data-option="Body"><?php $var = $Auto->get_meta('_custom_'. $custom_settings_quantity .'');  echo esc_attr(wp_kses_post( $var )) ?></div>
                        </td>
                      </tr>
                  <?php endif; 
                    $custom_settings_quantity++ ; 
                    $data_val++;
                  endwhile;?>
          </tbody>
        </table>
      </div>
    </div>
		 <?php
		$body_compare .=   ob_get_clean();
//header
	        ob_start();

	       ?>
						    <!--Compare car description-->
						    <div class="col-md-3 col-sm-3 col-xs-12 compare-col-auto compare-col-auto-id" data-id="<?php the_ID() ?>">
						        <a class="cmpr-links" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
	                    <div class="compare-car-img">
                          <?php                      
                           if ( has_post_thumbnail()) {
                            $val = get_option('compare_cars_templ'); 
                          //  $resize = !empty($val['resize']) ? $val['resize'] : false;
                            if($resize){
                              echo kama_thumb_img('w=470 &h=264 &crop=right &attach_id=' . get_post_thumbnail_id( $post->ID ) . ' &class='); 
                            }else{
                              echo get_the_post_thumbnail( NULL, 'medium');
                            }
                            
                          } ?>
	                    </div>
						        </a>
						        <div class="remove-compare-unlinkable">
						            <span class="remove-from-compare" data-action="remove" data-id="<?php the_ID(); ?>">
						                <i class="auto-icon-remove">
						                </i>
						                <span>
						                  <?php echo esc_attr( __('Remove', 'compare_cars')); ?>  
						                </span>
						            </span>
						        </div>
						        <a class="cmpr-links" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						            <div class="listing-car-item-meta">
						                <div class="car-meta-top heading-font clearfix">
                            <?php if( $validate['auto-price_show'] && (is_numeric($Auto->get_meta('_auto_price')) || isset($auto_translate[$Auto->get_price()]) ) ): ?>
						                    <div class="price discounted-price">
						                        <div class="sale-price">
                                        <?php $price;
                                        if(is_numeric($Auto->get_meta('_auto_price'))){
                                          $price = $Auto->get_price();
                                        }else if(isset($auto_translate[$Auto->get_price()])){
                                          $price = $auto_translate[$Auto->get_price()];
                                        }
                                        echo wp_kses_post( $price ) ?> 
						                        </div>
						                    </div>
                            <?php endif; ?>
						                    <div class="car-title">
						                        <?php the_title( ); ?>
						                    </div>
						                </div>
						            </div>
						        </a>
						    </div>
						    <!--md-3-->
						   

	<?php 
$header_compare .=   ob_get_clean();

		endwhile;
		endif; 


	for ($i=0; $i < (3-$counter); $i++) { 
	        ob_start();
	       ?>
						    <!--Compare car description-->
						    <div class="col-md-3 col-sm-3 col-xs-12 compare-col-auto">
						        <a href="<?php echo esc_attr( compare_cars_find_url()); ?>" class="cmpr-links">
						            <div>
						                <div class="image-box-compare">
                                            
                              <div class="add-car-search-page"><i class="fa fa-plus" aria-hidden="true"></i></div>    
						                    <div class="compare-car-img">
						                    	<div class="compare-add-car"></div>
						                    	<img class="img-compare-none" width="186" height="300">
						                    </div>
						                </div>
						            </div>
						             
						        </a>
						        
						    </div>
						    <!--md-3-->
						   
		<?php 
		$header_compare .=   ob_get_clean();
	}

//body
	
if(empty($validate) ){
	$Settings = new PIXAD_Settings();
	$validate = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_validation', true ); // Get validation settings
	$validate = pixad::validation( $validate );
}


      ob_start();
  ?>
<div class="col-md-3 col-sm-3 hidden-xs">
    <div class="compare-options">
        <table>
            <tbody>
              <?php if( $validate['auto-stock-status_show'] ): ?>
                  <tr>
                    <td class="compare-value-hover" data-value="1">
                        <?php esc_html_e( 'Stock status:', 'compare_cars' ); ?>
                    </td>
                </tr>
              <?php endif; ?>
              <?php if( $validate['auto-year_show'] ): ?>
                  <tr>
                    <td class="compare-value-hover" data-value="2">
                        <?php esc_html_e( 'Made Year:', 'compare_cars' ); ?>
                    </td>
                </tr>
              <?php endif; ?>
                <?php if($validate['auto-mileage_show']  ): ?>
                <tr>
                    <td class="compare-value-hover" data-value="3">
                        <?php esc_html_e( 'Mileage:', 'compare_cars' ); ?>
                    </td>
                </tr>
                <?php endif; ?>
               <?php if( $validate['auto-vin_show']  ): ?>
                <tr>
                    <td class="compare-value-hover" data-value="4">
                        <?php esc_html_e( 'VIN:', 'compare_cars' ); ?>
                    </td>
                </tr>
                <?php endif; ?>
              <?php if( $validate['auto-version_show']  ): ?>
                <tr>
                    <td class="compare-value-hover" data-value="5">
                        <?php esc_html_e( 'Version:', 'compare_cars' ); ?>
                    </td>
                </tr>
                <?php endif; ?>
                <?php if( $validate['auto-fuel_show'] ): ?>
                <tr>
                    <td class="compare-value-hover" data-value="6">
                        <?php esc_html_e( 'Fuel:', 'compare_cars' ); ?>
                    </td>
                </tr>
                 <?php endif; ?>
              <?php if( $validate['auto-engine_show']  ): ?>
                <tr>
                    <td class="compare-value-hover" data-value="7">
                        <?php esc_html_e( 'Engine (cm3):', 'compare_cars' ); ?>
                    </td>
                </tr>
                 <?php endif; ?>
                 <?php if( $validate['auto-horsepower_show']  ): ?>
                <tr>
                    <td class="compare-value-hover" data-value="8">
                        <?php esc_html_e( 'Horsepower (hp):', 'compare_cars' ); ?>
                    </td>
                </tr>
                <?php endif; ?>
              <?php if( $validate['auto-transmission_show']  ) : ?>
                <tr>
                    <td class="compare-value-hover" data-value="9">
                        <?php esc_html_e( 'Transmission:', 'compare_cars' ); ?>
                    </td>
                </tr>
                <?php endif; ?>
                  <?php if( $validate['auto-doors_show']  ): ?>
                <tr>
                    <td class="compare-value-hover" data-value="10">
                        <?php esc_html_e( 'Doors:', 'compare_cars' ); ?>
                    </td>
                </tr>
                 <?php endif; ?>
               <?php if( $validate['auto-condition_show']  ): ?>
                <tr>
                    <td class="compare-value-hover" data-value="11">
                        <?php esc_html_e( 'Condition:', 'compare_cars' ); ?>
                    </td>
                </tr>
                 <?php endif; ?>
                <?php if( $validate['auto-drive_show']  ): ?>
                <tr>
                    <td class="compare-value-hover" data-value="12">
                        <?php esc_html_e( 'Drive:', 'compare_cars' ); ?>
                    </td>
                </tr>
                 <?php endif; ?>
                <?php if( $validate['auto-seats_show'] ): ?>
                <tr>
                    <td class="compare-value-hover" data-value="13">
                        <?php esc_html_e( 'Seats:', 'compare_cars' ); ?>
                    </td>
                </tr>
                 <?php endif; ?>
                 <?php if( $validate['auto-color_show']): ?>
                <tr>
                    <td class="compare-value-hover" data-value="14">
                        <?php esc_html_e( 'Color:', 'compare_cars' ); ?>
                    </td>
                </tr>
                <?php endif; ?>
                <?php if( $validate['auto-color-int_show']  ): ?>
                <tr>
                    <td class="compare-value-hover" data-value="15">
                        <?php esc_html_e( 'Interior Color:', 'compare_cars' ); ?>
                    </td>
                </tr>
                <?php endif; ?>
                <?php if( $validate['auto-price-type_show']  ): ?>
                <tr>
                    <td class="compare-value-hover" data-value="16">
                        <?php esc_html_e( 'Price Type:', 'compare_cars' ); ?>
                    </td>
                </tr>
                <?php endif; ?>
                <?php if( $validate['auto-warranty_show']  ): ?>
                <tr>
                    <td class="compare-value-hover" data-value="17">
                        <?php esc_html_e( 'Warranty:', 'compare_cars' ); ?>
                    </td>
                </tr>
                <?php endif; ?>
               <?php 
                  $custom_settings_quantity = 1;
                  $max_custom_settings_quantity = 35;
                  $data_val = 18;
                  while ($custom_settings_quantity <= $max_custom_settings_quantity): 

                   if( $validate['custom_'. $custom_settings_quantity .'_show']  ): ?>
                    <tr>
                      <td class="compare-value-hover" data-value="<?php echo esc_attr($data_val) ?>">
                          <?php echo $validate['custom_'. $custom_settings_quantity .'_name']; ?>
                      </td>
                    </tr>
                  <?php endif; 
                    $custom_settings_quantity++ ; 
                    $data_val++;
                  endwhile;

                ?>
            </tbody>
        </table>
    </div>
</div>
  <?php 
      $body_compare =   ob_get_clean() . $body_compare ;



for ($i=0; $i < (3-$counter) ; $i++) {
	 ob_start();
 	?>
    <div class="col-md-3 col-sm-3 col-xs-12 compare-block-empty">
     	<div class="compare-values">
        <table>
          <tbody>
           	<?php if( $validate['auto-stock-status_show'] ): ?>
            <tr>
              <td class="compare-value-hover" data-value="compare-value-body">
                <div class="h5" data-option="Body">
                </div>
              </td>
            </tr>
            <?php endif; ?>
           	<?php if( $validate['auto-year_show'] ): ?>
            <tr>
              <td class="compare-value-hover" data-value="compare-value-body">
                <div class="h5" data-option="Body">

                </div>
              </td>
            </tr>
            <?php endif; ?> 
           	<?php if($validate['auto-mileage_show']  ): ?>
            <tr>
              <td class="compare-value-hover" data-value="compare-value-body">
                <div class="h5" data-option="Body">

                </div>
              </td>
            </tr>
            <?php endif; ?> 
					<?php if( $validate['auto-vin_show']  ): ?>
            <tr>
              <td class="compare-value-hover" data-value="compare-value-body">
                <div class="h5" data-option="Body">

                </div>
              </td>
            </tr>
            <?php endif; ?> 
					<?php if( $validate['auto-version_show']  ): ?>
            <tr>
              <td class="compare-value-hover" data-value="compare-value-body">
                <div class="h5" data-option="Body">

                </div>
              </td>
            </tr>
            <?php endif; ?> 
					<?php if( $validate['auto-fuel_show'] ): ?>
            <tr>
              <td class="compare-value-hover" data-value="compare-value-body">
                <div class="h5" data-option="Body">

                </div>
              </td>
            </tr>
            <?php endif; ?>
					<?php if( $validate['auto-engine_show']  ): ?>
            <tr>
              <td class="compare-value-hover" data-value="compare-value-body">
                <div class="h5" data-option="Body">

                </div>
              </td>
            </tr>
            <?php endif; ?> 
					<?php if( $validate['auto-horsepower_show']  ): ?>
            <tr>
              <td class="compare-value-hover" data-value="compare-value-body">
                <div class="h5" data-option="Body">

                </div>
              </td>
            </tr>
            <?php endif; ?> 
					<?php if( $validate['auto-transmission_show']  ) : ?>
            <tr>
              <td class="compare-value-hover" data-value="compare-value-body">
                <div class="h5" data-option="Body">

                </div>
              </td>
            </tr>
            <?php endif; ?>
					<?php if( $validate['auto-doors_show']  ): ?>
            <tr>
              <td class="compare-value-hover" data-value="compare-value-body">
                <div class="h5" data-option="Body">

                </div>
              </td>
            </tr>
            <?php endif; ?> 
					<?php if( $validate['auto-condition_show']  ): ?>
            <tr>
              <td class="compare-value-hover" data-value="compare-value-body">
                <div class="h5" data-option="Body">
                </div>
              </td>
            </tr>
            <?php endif; ?> 
					<?php if( $validate['auto-drive_show']  ): ?>
            <tr>
              <td class="compare-value-hover" data-value="compare-value-body">
                <div class="h5" data-option="Body">
                </div>
              </td>
            </tr>
            <?php endif; ?>
						<?php if( $validate['auto-seats_show'] ): ?>
            <tr>
              <td class="compare-value-hover" data-value="compare-value-body">
                <div class="h5" data-option="Body">

                </div>
              </td>
            </tr>
            <?php endif; ?>
						<?php if( $validate['auto-color_show']): ?>
            <tr>
              <td class="compare-value-hover" data-value="compare-value-body">
                <div class="h5" data-option="Body">

                </div>
              </td>
            </tr>
            <?php endif; ?>
					<?php if( $validate['auto-color-int_show']  ): ?>
            <tr>
              <td class="compare-value-hover" data-value="compare-value-body">
                <div class="h5" data-option="Body">

                </div>
              </td>
            </tr>
            <?php endif; ?>
					<?php if( $validate['auto-price-type_show']  ): ?>
            <tr>
              <td class="compare-value-hover" data-value="compare-value-body">
                <div class="h5" data-option="Body">

                </div>
              </td>
            </tr>
            <?php endif; ?>
					<?php if( $validate['auto-warranty_show']  ): ?>
            <tr>
              <td class="compare-value-hover" data-value="compare-value-body">
                <div class="h5" data-option="Body">

                </div>
              </td>
            </tr>
            <?php endif; ?>   
            <?php 
              $custom_settings_quantity = 1;
              $max_custom_settings_quantity = 35;
              while ($custom_settings_quantity <= $max_custom_settings_quantity): 
               if( $validate['custom_'. $custom_settings_quantity .'_show']  ): ?>
                  <tr>
                     <td class="compare-value-hover" data-value="compare-value-body">
                       <div class="h5" data-option="Body"></div>
                     </td>
                  </tr>
              <?php endif; 
                $custom_settings_quantity++ ; 
              endwhile;
            ?>
          </tbody>
        </table>
      </div>
    </div>
		 <?php
		$body_compare .=   ob_get_clean();

}
		?>

	<div class="container">
    <div class="row">
      <div class="col-md-12">
        <main class="main-content main-page-compare">
        	<div class="row car-listing-row">
	        	<?php echo $header_compare;  ?>
					</div>
					<div class="row compare-row">
						<?php echo $body_compare; ?>
					</div>
				</main>
		  </div>
		</div>
	</div>
	<?php 

// Reset Post Data
wp_reset_postdata();


?>


<?php get_footer();?>
