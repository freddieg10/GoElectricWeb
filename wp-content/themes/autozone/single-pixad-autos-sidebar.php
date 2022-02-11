 <?php /* The Template for displaying all single autos. */
global $post;

$Settings = new PIXAD_Settings();
$settings	= $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
$validate = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_validation', true ); // Get validation settings
$validate = pixad::validation( $validate );
$Auto = new PIXAD_Autos();
$Auto->Query_Args( array('auto_id' => $post->ID) );

$auto_translate = unserialize( get_option( '_pixad_auto_translate' ) );

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

$pix_show_calc = get_post_meta( get_the_ID(), 'pixad_auto_calc', true ) != '' ? get_post_meta( get_the_ID(), 'pixad_auto_calc', true ) : 0;
$pix_show_calendar = get_post_meta( get_the_ID(), 'pixba_calendar_view', true ) != '' ? get_post_meta( get_the_ID(), 'pixba_calendar_view', true ) : 0;
$pix_show_booking_button = get_post_meta( get_the_ID(), 'pixad_auto_booking_button', true ) != '' ? get_post_meta( get_the_ID(), 'pixad_auto_booking_button', true ) : 0;

$custom =  get_post_custom($post->ID);

$pix_options = get_option('pix_general_settings');

$pix_show_specifications = get_post_meta( get_the_ID(), 'pixad_auto_specifications', true ) != '' ? get_post_meta( get_the_ID(), 'pixad_auto_specifications', true ) : 1;
$pix_show_related = get_post_meta( get_the_ID(), 'pixad_auto_related', true ) != '' ? get_post_meta( get_the_ID(), 'pixad_auto_related', true ) : 1;
$pix_show_share = get_post_meta( get_the_ID(), 'pixad_auto_share', true ) != '' ? get_post_meta( get_the_ID(), 'pixad_auto_share', true ) : 1;


?>
<div class="col-md-4">
	<aside class="sidebar ">

    <?php if ($pix_show_booking_button) : ?>
	<?php  $pixba_style = get_option('pixba_style'); ?>
        <?php if ($pixba_style != 'popup'){?>

            <div  id="booking_car_info" class="">
                <?php do_action('autozone_end_auto', $post); ?>
            </div>
        <?php } else {?>
            <div class="car-booking">
                <a  data-toggle="modal" data-target="#single-pixad-booking-modal">
                    <i class="icon_calendar"></i><?php echo esc_html_e('Booking this car','autozone')?>
                </a>
            </div>


			<?php } ?>
     <?php endif; ?>
        <?php
        if($pix_show_calendar){
            do_action('autozone_preview_calendar', $post->ID);
        }
        ?>

      <?php  
             $gallery = array();
             $values = get_post_custom($post->ID);

            if (isset( $values['pixad_auto_gallery_2'][0])) {
                if(class_exists('Pix_Autos')){
                    $gallery = json_decode(pix_baseencode( $values['pixad_auto_gallery_2'][0]));
                }
            }
                    if(isset( $values['pixad_auto_gallery_2'][0]) && $gallery[0]  !== '-1' ) {

                        if($gallery != NULL){
                            if (array_key_exists('1', $gallery )) {
                                $listClass = 'auto-promo-inline';
                            }else{
                                $listClass ='';
                            }
                            echo "<div class='promo_gallery_wrapper ". $listClass."'><ul>";
                        }

                    }
                    if(isset($gallery[0]) && !empty($gallery[0]) && $gallery[0]  !== '-1' )  {
                        // The json decode and base64 decode return an array of image ids
                        $attachment_ids = $gallery;
                    }else{
                        $attachment_ids = array();
                    }
                    foreach ( $attachment_ids as $attachment_id ) {
                        $image = wp_get_attachment_image( $attachment_id, 'autozone-promo-thumb' );
                        echo '<li>'.$image.'</li>';

                    }
                    if(isset( $values['pixad_auto_gallery_2'][0]) && $gallery[0]  !== '-1') {
                                echo "</ul></div>";
                    }?>



	<?php if ($pix_show_specifications == 1) : ?>
		<section class="widget">
			<h3 class="widget-title"><?php  esc_html_e( 'Specifications', 'autozone' ) ?></h3>
			<div class="decor-1"></div>
			<div class="widget-content">
				<dl class="list-descriptions list-unstyled">
					<?php if( $Auto->get_make() ): ?>
					<!-- Make -->
                     <div class="dd-item">
						<dt><?php esc_html_e( 'Make:', 'autozone' ); ?></dt>
						<dd><?php echo wp_kses_post( $Auto->get_make()) ?></dd>
                    </div>
					<?php endif; ?>

					<?php if( $Auto->get_model() ): ?>
					<!-- Model -->
                    <div class="dd-item">
						<dt><?php esc_html_e( 'Model:', 'autozone' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_model()) ?></dd>
                    </div>
					<!-- / Model -->
					<?php endif; ?>

					<?php if( $validate['auto-stock-status_show'] && $Auto->get_meta('_auto_stock_status') ): ?>
                    <div class="dd-item">
						<dt class="left"><?php esc_html_e( 'Stock status:', 'autozone' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $auto_translate[$Auto->get_meta('_auto_stock_status')] ) ?></dd>
                    </div>
					<?php endif; ?>

					<?php if( $validate['auto-year_show'] && $Auto->get_meta('_auto_year') ): ?>
					<!-- Made Year -->
                    <div class="dd-item">
						<dt class="left"><?php esc_html_e( 'Made Year:', 'autozone' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_meta('_auto_year')) ?></dd>
                    </div>
					<!-- / Made Year -->
					<?php endif; ?>

					<?php if( $validate['auto-mileage_show'] && $Auto->get_meta('_auto_mileage') ): ?>
                    <div class="dd-item">
					<!-- Mileage -->
						<dt class="left"><?php esc_html_e( 'Mileage:', 'autozone' ); ?></dt>
						<dd class="right"><?php echo number_format($Auto->get_meta('_auto_mileage'), "{$settings['autos_decimal_number']}", "{$settings['autos_decimal']}", "{$settings['autos_thousand']}"); ?></dd>
                    </div>
					<!-- / Mileage -->
					<?php endif; ?>

					<?php if( $validate['auto-vin_show'] && $Auto->get_meta('_auto_vin') ): ?>
					<!-- VIN -->
                    <div class="dd-item">
						<dt class="left"><?php esc_html_e( 'VIN:', 'autozone' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_meta('_auto_vin')) ?></dd>
                    </div>
					<!-- / VIN -->
					<?php endif; ?>

					<?php if( $validate['auto-version_show'] && $Auto->get_meta('_auto_version') ): ?>
					<!-- Version -->
                    <div class="dd-item">
						<dt class="left"><?php esc_html_e( 'Version:', 'autozone' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_meta('_auto_version')) ?></dd>
                    </div>
					<!-- / Version -->
					<?php endif; ?>

					<?php if( $validate['auto-fuel_show'] && $Auto->get_meta('_auto_fuel') ): ?>
					<!-- Fuel -->
                    <div class="dd-item">
						<dt class="left"><?php esc_html_e( 'Fuel:', 'autozone' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $auto_translate[$Auto->get_meta('_auto_fuel')]); ?></dd>
                    </div>
					<!-- / Fuel -->
					<?php endif; ?>

					<?php if( $validate['auto-engine_show'] && $Auto->get_meta('_auto_engine') ): ?>
					<!-- Engine -->
                    <div class="dd-item">
						<dt class="left"><?php esc_html_e( 'Engine (cm3):', 'autozone' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_meta('_auto_engine')) ?></dd>
                    </div>
					<!-- / Engine -->
					<?php endif; ?>

					<?php if( $validate['auto-horsepower_show'] && $Auto->get_meta('_auto_horsepower') ): ?>
					<!-- Horsepower -->
                    <div class="dd-item">
						<dt class="left"><?php esc_html_e( 'Horsepower (hp):', 'autozone' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_meta('_auto_horsepower')) ?></dd>
                    </div>
					<!-- / Horsepower -->
					<?php endif; ?>

					<?php if( $validate['auto-transmission_show'] && $Auto->get_meta('_auto_transmission') ) : ?>
					<!-- Transmission -->
                    <div class="dd-item">
						<dt class="left"><?php esc_html_e( 'Transmission:', 'autozone' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $auto_translate[$Auto->get_meta('_auto_transmission')] ) ?></dd>
                    </div>
					<!-- / Transmission -->
					<?php endif; ?>

					<?php if( $validate['auto-doors_show'] && $Auto->get_meta('_auto_doors') ): ?>
					<!-- Doors -->
                    <div class="dd-item">
						<dt class="left"><?php esc_html_e( 'Doors:', 'autozone' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_meta('_auto_doors')) ?></dd>
                    </div>
					<!-- / Doors -->
					<?php endif; ?>

					<?php if( $validate['auto-condition_show'] && $Auto->get_meta('_auto_condition') ): ?>
					<!-- Condition -->
                    <div class="dd-item">
						<dt class="left"><?php esc_html_e( 'Condition:', 'autozone' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $auto_translate[$Auto->get_meta('_auto_condition')] ); ?></dd>
                    </div>
					<!-- / Condition -->
					<?php endif; ?>





					<?php if( $validate['auto-drive_show'] && $Auto->get_meta('_auto_drive') ): ?>
					<?php $drive = isset($auto_translate[$Auto->get_meta('_auto_drive')]) ? $auto_translate[$Auto->get_meta('_auto_drive')] : $Auto->get_meta('_auto_drive'); ?>
					<!-- Drive -->
                    <div class="dd-item">
						<dt class="left"><?php esc_html_e( 'Drive:', 'autozone' ); ?></dt>
					<dd class="right"><?php echo wp_kses_post( $drive ) ?></dd>
                    </div>
					<!-- / Drive -->
					<?php endif; ?>

					<?php if( $validate['auto-seats_show'] && $Auto->get_meta('_auto_seats') ): ?>
					<!-- Seats -->
                    <div class="dd-item">
						<dt class="left"><?php esc_html_e( 'Seats:', 'autozone' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_meta('_auto_seats')) ?></dd>
                    </div>
					<!-- / Seats -->
					<?php endif; ?>

					<?php if( $validate['auto-color_show'] && $Auto->get_meta('_auto_color') ): ?>
					<?php $color = isset($auto_translate[$Auto->get_meta('_auto_color')]) ? $auto_translate[$Auto->get_meta('_auto_color')] : $Auto->get_meta('_auto_color'); ?>
					<!-- Color -->
                    <div class="dd-item">
						<dt class="left"><?php esc_html_e( 'Color:', 'autozone' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $color ) ?></dd>
                    </div>
					<!-- / Color -->
					<?php endif; ?>

					<?php if( $validate['auto-color-int_show'] && $Auto->get_meta('_auto_color_int') ): ?>
					<?php $color_int = isset($auto_translate[$Auto->get_meta('_auto_color_int')]) ? $auto_translate[$Auto->get_meta('_auto_color_int')] : $Auto->get_meta('_auto_color_int'); ?>
                    <div class="dd-item">
						<dt class="left"><?php esc_html_e( 'Interior Color:', 'autozone' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $color_int ) ?></dd>
                    </div>
					<!-- / Color Int -->
					<?php endif; ?>



					<?php if( $validate['auto-price-type_show'] && $Auto->get_meta('_auto_price_type') ): ?>
					<!-- Price Type -->
                    <div class="dd-item">
						<dt class="left"><?php esc_html_e( 'Price Type:', 'autozone' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $auto_translate[$Auto->get_meta('_auto_price_type')] ); ?></dd>
                    </div>
					<!-- / Price Type -->
					<?php endif; ?>

					<?php if( $validate['auto-warranty_show'] && $Auto->get_meta('_auto_warranty') ): ?>
					<!-- Warranty -->
                    <div class="dd-item">
						<dt class="left"><?php esc_html_e( 'Warranty:', 'autozone' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $auto_translate[$Auto->get_meta('_auto_warranty')] ); ?></dd>
                    </div>
					<!-- / Warranty -->
					<?php endif; ?>



				<?php

									$custom_settings_quantity = 1;
									$max_custom_settings_quantity = 10;
									$group_custom_settings_quantity = 1;
				while ($group_custom_settings_quantity <= 8): ?>

<?php   if ( $validate['group_'. $group_custom_settings_quantity .'_show'] != 'on' ) : ?>
		<?php if($validate['custom_'. $custom_settings_quantity .'_show'] && $validate['group_'. $group_custom_settings_quantity .'_title']  && $Auto->get_meta('_custom_'. $custom_settings_quantity .'')): ?>
		<div class="title-subtitle-wrapper">
			<h4 class="title"><?php echo esc_html($validate['group_'. $group_custom_settings_quantity .'_title']); ?> </h4>
			<h5 class="subtitle"><?php echo esc_html($validate['group_'. $group_custom_settings_quantity .'_sub_title']); ?></h5>
		</div>
		<?php endif; ?>
	<?php
  			while ($custom_settings_quantity <= $max_custom_settings_quantity): ?>
					<?php if( $validate['custom_'. $custom_settings_quantity .'_show'] && $Auto->get_meta('_custom_'. $custom_settings_quantity .'') ): ?>

                    <div class="dd-item">
						<dt class="left"><?php echo esc_html($validate['custom_'. $custom_settings_quantity .'_name']); ?></dt>
						<dd class="right"><?php echo wp_kses_post( $Auto->get_meta('_custom_'. $custom_settings_quantity .'')) ?></dd>
                    </div>
					<?php endif; ?>
	<?php	$custom_settings_quantity++ ; ?>
		<?php endwhile;  ?>
 <?php  else:  ?>
				<?php 	$custom_settings_quantity = $custom_settings_quantity + 9; ?>
<?php endif;  ?>

				<?php		$group_custom_settings_quantity++ ;
						$max_custom_settings_quantity = $max_custom_settings_quantity + 10;

		 endwhile; ?>



				</dl>
			</div>
		</section>
	<?php endif; ?>



    <?php if ($pix_show_related) : ?>
		<section class="widget">
			<h3 class="widget-title"><?php esc_html_e( 'Related Cars', 'autozone') ?></h3>
			<div class="decor-1"></div>
			<?php
				$custom_taxterms = wp_get_object_terms( $post->ID, 'auto-body', array('fields' => 'ids') );
				// arguments
				$args = array(
					'post_type' => 'pixad-autos',
					'posts_per_page' => 3, // you may edit this number
					'orderby' => 'rand',
					'tax_query' => array(
					    array(
					        'taxonomy' => 'auto-body',
					        'field' => 'id',
					        'terms' => $custom_taxterms
					    )
					),
					'post__not_in' => array ($post->ID),
				);
				$related_items = new WP_Query( $args );

				// loop over query
				if ($related_items->have_posts()) :
				echo '<div class="widget-content">';
				while ( $related_items->have_posts() ) :
					$related_items->the_post();
					$Auto_Related = new PIXAD_Autos();
					$Auto_Related->Query_Args( array('auto_id' => $post->ID) );
				?>
					<section class="widget-post1 clearfix">
						<div class="widget-post1__img">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<?php if( has_post_thumbnail() ): ?>
									<?php the_post_thumbnail('thumbnail', array('class' => 'img-responsive')); ?>
								<?php else: ?>
									<img class="img-responsive no-image" src="<?php echo PIXADRO_CAR_URI .'assets/img/no_image.jpg'; ?>" alt="no-image">
								<?php endif; ?>
							</a>
						</div>
						<div class="widget-post1__inner">
							<h3 class="widget-post1__title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
							<div class="widget-post1__price"><?php esc_html_e( 'Price:' , 'autozone') ?> <?php echo wp_kses_post($Auto_Related->get_price()) ?></div>
							<div class="widget-post1__description"><?php echo autozone_limit_words(get_the_excerpt(), 15); ?></div>
						</div>
					</section>
				<?php
				endwhile;
				wp_reset_query();
				echo '</div>';
				endif;
			?>
		</section>
    <?php endif; ?>

        <?php
        $pixad_banner_place = get_post_meta( get_the_ID(), 'pixad_auto_form_place', true );
        if( get_post_meta( get_the_ID(), 'pixad_auto_banner', true ) != '' ) : ?>
            <?php if($pixad_banner_place == 'sidebar') { ?>
                <section class="widget">
                            <section class="section_letter section-bg section-bg_primary">
                                <div class="letter bg-inner">
                                    <div class="letter__inner">
                                        <?php echo get_post_meta( get_the_ID(), 'pixad_auto_banner', true ) ?>
                                    </div>
                                    <div class="letter__btn wrap-social-block wrap-social-block_mod-a">
                                        <a class="social-block social-block_mod-a btn-effect" data-toggle="modal" data-target="#single-pixad-autos-modal">
                                            <div class="social-block__inner"><?php esc_html_e( 'send details', 'autozone' ); ?></div>
                                        </a>
                                    </div>
                                </div><!-- end bg-inner -->
                                <div class="border-section-bottom border-section-bottom_mod-a"></div>
                            </section><!-- end section_mod-b -->
                    </section>
            <?php } ?>

        <?php endif; ?>


        <?php if($pix_show_calc): ?>
    <?php
    $currencies = unserialize( get_option( '_pixad_autos_currencies' ) );

		$currency = $currencies[$settings['autos_site_currency']];
		if( !$currency['symbol'] ) $currency['symbol'] = '';
    ?>

    <section class="widget widget-calculator">
		<h3 class="widget-title"><i class="theme-fonts-icon_calculator_alt"></i><?php echo esc_html__('Financing calculator','autozone')?></h3>

		<div class="widget-content">
			<div class="autozone_calculator">
				<div class="row">
					<input type="hidden" id="pix-thousand" value="<?php echo esc_attr($settings['autos_thousand']) ?>">
					<input type="hidden" id="pix-decimal" value="<?php echo esc_attr($settings['autos_decimal']) ?>">
					<input type="hidden" id="pix-decimal_number" value="<?php echo esc_attr($settings['autos_decimal_number']) ?>">

					<div class="col-md-12">
						<div class="form-group">
							<div class="labeled"><?php echo esc_html__('Vehicle price','autozone')?> <span class="orange currency">(<?php echo esc_html($currency['symbol']); ?>)</span></div>
							<input type="text" class="numbersOnly vehicle_price" value="100000">
						</div>

						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group md-mg-rt">
									<div class="labeled"><?php echo esc_html__('Interest rate','autozone')?> <span class="orange">(%)</span></div>
									<input type="text" class="numbersOnly interest_rate" value="5">
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group md-mg-lt">
									<div class="labeled"><?php echo esc_html__('Period','autozone')?> <span class="orange">(<?php echo esc_html__('month','autozone')?>)</span></div>
									<input type="text" class="numbersOnly period_month" value="36">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="labeled"><?php echo esc_html__('Down Payment','autozone')?> <span class="orange">(<?php echo esc_html($currency['symbol']); ?>)</span></div>
							<input type="text" class="numbersOnly down_payment" value="10000">
						</div>


						<a href="javascript:void(0)" class="button button-sm autozone_calculate_btn dp-in"><?php echo esc_html__('Calculate','autozone')?></a>


						<div class="calculator-alert alert alert-danger">

						</div>

					</div>

					<div class="col-md-12">
						<div class="autozone_calculator_results" style="display: block;">
							<div class="autozone_calculator_report">
								<dl class="list-descriptions list-unstyled">
								<dt><?php echo esc_html__('Monthly Payment','autozone')?></dt>
								<dd class="monthly_payment h5"><span class="currency"></span><span class="val"></dd>

								<dt><?php echo esc_html__('Total Interest Payment','autozone')?></dt>
								<dd class="total_interest_payment h5"><span class="currency"></span><span class="val"></dd>

								<dt><?php echo esc_html__('Total Amount to Pay','autozone')?></dt>
								<dd class="total_amount_to_pay h5"><span class="currency"></span><span class="val"></span></dd>
								</dl>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
    <?php endif; ?>
        
        
          <?php if(!function_exists('A2A_SHARE_SAVE_init')){ ?>
            <?php if ($pix_show_share) : ?>
                <div class="widget widget_mod-b">
                    <div class="wrap-social-block wrap-social-block_mod-a">
                        <?php echo do_shortcode('[share title="'.esc_html__('Share This', 'autozone').'"]'); ?>
                    </div>
                </div>
            <?php endif; ?>
         <?php } ?>
         <?php if(function_exists('A2A_SHARE_SAVE_init')){ ?> 
        
        <div class="widget widget_mod-b">
			<div class="wrap-social-block wrap-social-block_mod-a">
				
            <div class="social-block ">
                <div class="social-block__inner">
                    <span class="social-block__title"><?php echo esc_html__('Share This','autozone')?></span>
                    <?php if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) { ADDTOANY_SHARE_SAVE_KIT(); } ?>
                </div>
            </div>
						</div>
		</div>
        


                 
		
    <?php } ?>     
        
	</aside>
</div>



