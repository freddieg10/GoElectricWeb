 <?php /* The Template for displaying all single autos. */
global $post, $PIXAD_Autos, $PIXAD_Country;

$Settings = new PIXAD_Settings();
$settings = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
$validate = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_validation', true ); // Get validation settings
$validate = pixad::validation( $validate );
$PIXAD_Autos->Query_Args( array('auto_id' => $post->ID) );

$custom =  get_post_custom(get_queried_object()->ID);
$layout = get_post_meta( $post->ID, 'pixad_auto_sidebar_layout', true ) != '' ? get_post_meta( $post->ID, 'pixad_auto_sidebar_layout', true ) : 'right';

$pix_options = get_option('pix_general_settings');
$auto_translate = unserialize( get_option( '_pixad_auto_translate' ) );




$pix_show_description_tab = get_post_meta( get_the_ID(), 'pixad_auto_description_tab', true ) != '' ? get_post_meta( get_the_ID(), 'pixad_auto_description_tab', true ) : 1;
$pix_show_features_tab = get_post_meta( get_the_ID(), 'pixad_auto_features_tab', true ) != '' ? get_post_meta( get_the_ID(), 'pixad_auto_features_tab', true ) : 1;
$auto_equipment_cat = get_the_terms( get_the_ID(), 'auto-equipment');
if (empty($auto_equipment_cat)) {
	$pix_show_features_tab = false;
}





$title_1 = get_post_meta( get_the_ID(), 'pixad_auto_custom_title_1', true );
$title_2 = get_post_meta( get_the_ID(), 'pixad_auto_custom_title_2', true );
$title_3 = get_post_meta( get_the_ID(), 'pixad_auto_custom_title_3', true );
$pix_show_contacts_tab = get_post_meta( get_the_ID(), 'pixad_auto_contacts_tab', true ) != '' ? get_post_meta( get_the_ID(), 'pixad_auto_contacts_tab', true ) : 1;
 $pix_show_booking_button = get_post_meta( get_the_ID(), 'pixad_auto_booking_button', true ) != '' ? get_post_meta( get_the_ID(), 'pixad_auto_booking_button', true ) : 0;

$pixad_auto_form_id = get_post_meta( get_the_ID(), 'pixad_auto_form', true );
$pixad_auto_form_style = get_post_meta( get_the_ID(), 'pixad_auto_form_style', true );
if(class_exists('Pix_Autos') && get_theme_mod('autozone_map_api')){
    wp_enqueue_script('google-maps', autozone_google_map_url(), array( 'jquery' ), null , true);
}

$pix_show_specifications = get_post_meta( get_the_ID(), 'pixad_auto_specifications', true ) != '' ? get_post_meta( get_the_ID(), 'pixad_auto_specifications', true ) : 1;

$has_video = false;
$YoutubeCode = '';

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


$pix_active_description_tab = $pix_active_features_tab = $pix_active_title_1 = $pix_active_title_2 = $pix_active_title_3 = $pix_active_contacts_tab = '';
if($pix_show_description_tab) {
    $pix_active_description_tab = 'active';
}elseif(!$pix_show_description_tab) {
    $pix_active_features_tab = 'active';
} elseif($pix_show_features_tab) {
    $pix_show_features_tab = 'active';
} elseif($title_1) {
    $pix_active_title_1 = 'active';
} elseif($title_2) {
    $pix_active_title_2 = 'active';
} elseif($title_3) {
    $pix_active_title_3 = 'active';
} elseif($pix_show_contacts_tab) {
    $pix_active_contacts_tab = 'active';
}

get_header();

?>
<div class="container">
    <div class="row">
        <?php if ($layout == 'left'):
			get_template_part( 'single', 'pixad-autos-sidebar' );
        endif;?>
		
		<?php if ($layout == 'none'){ ?>
		 <div class="col-md-8 col-md-offset-2">
		<?php }else{ ?>
        <div class="col-md-8">
		<?php }?>
            <?php
            // Start the loop.
            while ( have_posts() ) : the_post();
			?>
                <main class="main-content">
					<article class="car-details">

						<div class="car-details__wrap-title clearfix">
							<h2 class="car-details__title"><?php wp_kses_post(the_title()) ?></h2>
                         
		                <?php  $pixba_style = get_option('pixba_style'); ?>

							<?php if( $validate['auto-price_show'] && $PIXAD_Autos->get_meta('_auto_price') && $pixba_style == 'popup'): ?>
							<?php $price = is_numeric($PIXAD_Autos->get_meta('_auto_price')) || $PIXAD_Autos->get_meta('_auto_price') == '' ? $PIXAD_Autos->get_price() : '';
							?>
							    <div class="car-details__wrap-price"><span class="car-details__price"><span class="car-details__price-inner"><?php echo wp_kses_post($price); ?></span></span></div>
							<?php endif; ?>

                            <?php if( $validate['auto-price_show'] && $PIXAD_Autos->get_meta('_auto_price') && $pix_show_booking_button == 0): ?>
                                <?php $price = is_numeric($PIXAD_Autos->get_meta('_auto_price')) || $PIXAD_Autos->get_meta('_auto_price') == '' ? $PIXAD_Autos->get_price() : $auto_translate[$PIXAD_Autos->get_price()]; ?>
                                <div class="car-details__wrap-price"><span class="car-details__price"><span class="car-details__price-inner"><?php echo wp_kses_post($price); ?></span></span></div>
                            <?php endif; ?>
						</div>

						<div id="slider-product" class="flexslider slider-product">
						    					<?php if( get_post_meta(get_the_ID(), 'pixad_auto_featured_text', true) ): ?>
                                <span class="card__wrap-label"><span class="card__label"><?php echo  get_post_meta( get_the_ID(), 'pixad_auto_featured_text', true ); ?></span></span>
                            <?php endif; ?>
                            <?php if( $PIXAD_Autos->get_meta('_auto_sale_price') != '' ): ?>
                                <span class="card__wrap-label sale"><?php esc_html_e( 'Sale', 'autozone' ); ?></span>
                            <?php endif; ?>
					      <ul class="slides fl-magic-popup fl-gallery-popup">

					            <?php
					            $gallery = array();
					            if ( has_post_thumbnail() ) {

					                $image_title 		= esc_attr( get_the_title( get_post_thumbnail_id() ) );
					                $image_link  		= wp_get_attachment_url( get_post_thumbnail_id() );
					                $image       		= get_the_post_thumbnail( $post->ID, 'autozone-auto-single_crop', array('title' => $image_title) );

									$values = get_post_custom($post->ID);
									if(isset( $values['pixad_auto_gallery'][0]) ) {
								        $gallery = pixad_json_decode( $values['pixad_auto_gallery'][0]);
								    }

                                    if(isset($gallery[0]) && !empty($gallery[0]) )  {
								        // The json decode and base64 decode return an array of image ids
								        $attachment_ids = $gallery;
								    }else{
								        $attachment_ids = array();
								    }

								    echo sprintf( '<li><a class="prettyPhoto" rel="prettyPhoto[gallery1]" href="%s">%s</a></li>', $image_link, $image );
									
									if($has_video){

										$auto_video_code = isset($values['_auto_video_code']) ? $values['_auto_video_code'] : false;
										if ($auto_video_code){	
											$YoutubeCode = reset($auto_video_code);
											preg_match('#(\.be/|/embed/|/v/|/watch\?v=)([A-Za-z0-9_-]{5,11})#', $YoutubeCode, $matches);
											if (isset($matches[2]) && $matches[2] != '') {
											$YoutubeCode = $matches[2];
											}
											$you_t = '<iframe src="https://www.youtube.com/embed/'.$YoutubeCode.'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
						                    echo sprintf( '<li class="prettyPhoto" rel="prettyPhoto[gallery1]">%s</li>', $you_t );
										}
									}
									
									// foreach ($ids_video as $id_video) {
									// 	if(!empty($id_video)){
									// 		$post_video = get_post( (int)$id_video );
									// 		if(!empty($post_video)){
									// 			$type = '';
									// 			$pos = strripos($post_video->post_mime_type, 'video');
									// 			if ($pos === false) {
									// 			} else {
									// 				$type = substr($post_video->post_mime_type, 6);
									// 				echo '<li class="prettyPhoto  " rel="prettyPhoto[gallery1]">' . apply_filters( 'the_content', '[video  ' . $type .'="' . $post_video->guid . '"][/video]' ) . '</li>';
									// 			}

									// 		}
									// 	}
									// }
									if($attachment_ids[0] != -1){

											foreach ( $attachment_ids as $attachment_id ) {

					                   		$image_link = wp_get_attachment_url( $attachment_id );

					                   		$image       = wp_get_attachment_image( $attachment_id, 'autozone-auto-single_crop' );
					                   		$image_class = '';
					                   		$image_title = esc_attr( get_the_title( $attachment_id ) );

					                   		echo sprintf( '<li><a class="prettyPhoto sas" rel="prettyPhoto[gallery1]" href="%s" title="%s" >%s</a></li>', $image_link, $image_title, $image );

					                		}

										}

					            } else {
					                ?>
					                    <img class="no-image" src="<?php echo PIXADRO_CAR_URI .'assets/img/no_image.jpg'; ?>" alt="no-image">
						            <?php
					            }
					            ?>
					        </ul>
                            
                            
						<?php do_action( 'autozone_autos_single_auto_img', $post); ?>
                            
                            
                            
					    </div>
					    <?php
						if ( !empty($attachment_ids) && $attachment_ids[0] != -1 ) {
						?>
						    <div id="carousel-product" class="flexslider carousel-product">
						        <ul class="slides">
						        <?php

						            $image_title 		= esc_attr( get_the_title( get_post_thumbnail_id() ) );
						            $image_link  		= wp_get_attachment_url( get_post_thumbnail_id() );
						            $image       		= get_the_post_thumbnail( $post->ID, 'autozone-auto-thumb', array('title' => $image_title) );

						            echo sprintf( '<li>%s</li>', $image );
							
							
							if($has_video){
							
								$auto_video_code = isset($values['_auto_video_code']) ? $values['_auto_video_code'] : false;
									
								if ($auto_video_code){
									$image_title = 'Video';
									// $image = get_the_post_thumbnail( $post->ID, 'autozone-auto-thumb', array('title' => $image_title) );
									$image =  '<img src="http://img.youtube.com/vi/' . $YoutubeCode . '/0.jpg" />';
				                    echo sprintf( '<li class="auto-thumb-video">%s</li>', $image );
								}
							}
							// foreach ($ids_video as $id_video) {
							// 	if(!empty($id_video)){
							// 		$image_title = 'Video';
							// 		$image = get_the_post_thumbnail( $post->ID, 'autozone-auto-thumb', array('title' => $image_title) );
				   //                  echo sprintf( '<li class="auto-thumb-video">%s</li>', $image );
							// 	}
							// }

						            foreach ( $attachment_ids as $attachment_id ) {

						                $image_link = wp_get_attachment_url( $attachment_id );

						                $image       = wp_get_attachment_image( $attachment_id, 'autozone-auto-thumb' );
						                $image_class = esc_attr('');
						                $image_title = esc_attr( get_the_title( $attachment_id ) );

						                echo sprintf( '<li>%s</li>', $image );

						            }
						        ?>
						        </ul>
						    </div>





                        <?php } ?>


                        <div class="wrap-nav-tabs">
							<ul class="nav nav-tabs">
                                <?php if(!empty( get_the_content() )){?>
                                    <?php if ($pix_show_description_tab) : ?>
                                        <li class="<?php echo esc_attr($pix_active_description_tab); ?>"><a href="#tab1" data-toggle="tab" aria-expanded="true"><?php  esc_html_e( 'Vehicle Description', 'autozone' ) ?></a></li>
                                    <?php endif; ?>
                                <?php } ?>

							<?php if ($pix_show_features_tab) : ?>
								<li class="<?php echo esc_attr($pix_active_features_tab); ?>"><a href="#tab2" data-toggle="tab" aria-expanded="false"><?php esc_html_e( 'Equipment', 'autozone' ) ?></a></li>
							<?php endif; ?>



                        <?php

                        $settings_quantity_checked = 0;
                        $custom_settings_quantity = 1;
                        while ( $custom_settings_quantity <= 80) {
                                    if ($PIXAD_Autos->get_meta('_custom_'. $custom_settings_quantity .'') != ''	) {
                                         $settings_quantity_checked++;
                                    }

                            $custom_settings_quantity++;
                        }

                        ?>



						<?php if ($validate['group_1_show'] || $validate['group_2_show'] || $validate['group_3_show'] || $validate['group_4_show'] || $validate['group_5_show'] || $validate['group_6_show'] || $validate['group_7_show'] || $validate['group_8_show']) : ?>
									<?php if ( $settings_quantity_checked > 0	): ?>																				
							<li class=""><a href="#tab7" data-toggle="tab" aria-expanded="false"><?php esc_html_e( 'Technical', 'autozone' ) ?></a></li>
										<?php endif ?>
						<?php endif; ?>

					<?php  if($pix_show_specifications == "tab"): ?>
							<li class=""><a href="#tab9" data-toggle="tab" aria-expanded="false"><?php esc_html_e( 'Specifications', 'autozone' ) ?></a></li>
						<?php endif; ?>


							<?php
								if($title_1 != ''){
									?><li class="<?php echo esc_attr($pix_active_title_1); ?>"><a href="#tab4" data-toggle="tab" aria-expanded="true"><?php echo wp_kses_post( $title_1 ) ?></a></li><?php
								}
								if($title_2 != ''){
									?><li class="<?php echo esc_attr($pix_active_title_2); ?>"><a href="#tab5" data-toggle="tab" aria-expanded="true"><?php echo wp_kses_post( $title_2 ) ?></a></li><?php
								}
								if($title_3 != ''){
									?><li class="<?php echo esc_attr($pix_active_title_3); ?>"><a href="#tab6" data-toggle="tab" aria-expanded="true"><?php echo wp_kses_post( $title_3 ) ?></a></li><?php
								}
							?>

							<?php if ($pix_show_contacts_tab) : ?>
								<li class="<?php echo esc_attr($pix_active_contacts_tab); ?>"><a href="#tab3" data-toggle="tab" aria-expanded="false"><?php esc_html_e( 'Contact', 'autozone' ) ?></a></li>
							<?php endif; ?>
							<?php if ( 'open' == $post->comment_status): ?>
								<li class=""><a href="#tab8" data-toggle="tab" aria-expanded="false"><?php esc_html_e('Reviews', 'autozone');?></a></li>
							<?php endif;?>
							</ul>
						</div>
						<div class="tab-content">
						    <?php if ($pix_show_description_tab) : ?>
							<div class="tab-pane <?php echo esc_attr($pix_active_description_tab); ?>" id="tab1">
								<?php the_content() ?>
							</div>
							<?php endif; ?>
							<div class="tab-pane" id="tab8">
								<?php  comments_template();?>
							</div>



<?php  if($pix_show_specifications == "tab"): ?>
							<div class="tab-pane" id="tab9">
								<?php 
								$Auto = new PIXAD_Autos();
								$Auto->Query_Args( array('auto_id' => $post->ID) );
								$auto_translate = unserialize( get_option( '_pixad_auto_translate' ) ); 

						?>
			<section class="widget widget-auto-page">
			<div class="widget-content">
				<dl class="data-list-descriptions">
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
					<!-- Mileage -->
					<div class="dd-item">
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
					<!-- Drive -->
					<div class="dd-item">
						<dt class="left"><?php esc_html_e( 'Drive:', 'autozone' ); ?></dt>
						<dd class="right"><?php echo wp_kses_post( isset($auto_translate[$Auto->get_meta('_auto_drive')]) ? $auto_translate[$Auto->get_meta('_auto_drive')] : $Auto->get_meta('_auto_drive').' '.esc_html__( 'drive', 'autozone' ) ); ?></dd>
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
				</div>
			<?php endif;?>










                            <?php if ($pix_show_features_tab) : ?>
							<div class="tab-pane <?php echo esc_attr($pix_active_features_tab); ?>" id="tab2">
								
								<?php
									$terms = wp_get_post_terms( get_the_ID(), 'auto-equipment', array('fields' => 'ids') );
									$args_eq = array( 'taxonomy' => 'auto-equipment', 'hide_empty' => '0');
									$auto_equipment_cat = get_categories($args_eq);
									$equip_out = '';
									foreach ($auto_equipment_cat as $category) {
										if (is_object($category)) {
											$t_id = $category->term_id;
											$equipment_icon = get_option("auto_equipment_icon_$t_id");
											$class_icon_set = $equipment_icon != '' ? 'equipment-icon-set' : '';
											if (in_array($category->term_id, $terms)) {
												$feature_icon_true = $equipment_icon != '' ? '<i class="icon '.esc_attr($equipment_icon).'"></i>' : '<i class="features-icon">+</i>';
												$equip_out .= '<li class="pixad-exist '.esc_attr($class_icon_set).'">' . wp_kses_post($feature_icon_true.$category->name) . '</li>';
											} elseif($settings['autos_equipment']){
												$feature_icon_false = $equipment_icon != '' ? '<i class="icon '.esc_attr($equipment_icon).'"></i>' : '<i class="features-icon">-</i>';
												$equip_out .= '<li class="pixad-none '.esc_attr($class_icon_set).'"> ' . wp_kses_post($feature_icon_false.$category->name) . '</li>';
											}
										}
									}
									if( $equip_out != '')
										echo '<ul class="pixad-features-list">'.wp_kses_post($equip_out).'</ul>';
								?>


                            </div>
							<?php endif; ?>


							<div class="tab-pane " id="tab7">
								<?php
									$custom_settings_quantity = 1;
									$max_custom_settings_quantity = 10;
									$group_custom_settings_quantity = 1;
								while ($group_custom_settings_quantity <= 8): ?>
									<?php   if ( $validate['group_'. $group_custom_settings_quantity .'_show'] ) : ?>
                                      <div class="tech-group">
                                        <?php if($validate['custom_'. $custom_settings_quantity .'_show'] && $validate['group_'. $group_custom_settings_quantity .'_title']  && $PIXAD_Autos->get_meta('_custom_'. 									$custom_settings_quantity .'')): ?>
                                            <div class="title-subtitle-wrapper">
                                                <h4 class="title"><i class="<?php echo esc_html($validate['group_'. $group_custom_settings_quantity .'_icon']); ?>"></i><?php echo esc_html($validate['group_'. $group_custom_settings_quantity .'_title']); ?> </h4>
                                                <h5 class="subtitle"><?php echo esc_html($validate['group_'. $group_custom_settings_quantity .'_sub_title']); ?></h5>
                                                <div class="decor-1"></div>
                                            </div>
                                        <?php endif; ?>
                                        <dl class="list-descriptions list-unstyled">
                                            <?php
                                                    while ($custom_settings_quantity <= $max_custom_settings_quantity): ?>
                                                            <?php if( $validate['custom_'. $custom_settings_quantity .'_show'] && $PIXAD_Autos->get_meta('_custom_'. $custom_settings_quantity .'') ): ?>
                                                <div class="dd-item">
                                                                <dt class="left"><?php echo esc_html($validate['custom_'. $custom_settings_quantity .'_name']); ?></dt>
                                                <dd class="right"><?php echo wp_kses_post( $PIXAD_Autos->get_meta('_custom_'. $custom_settings_quantity .'')) ?></dd></div>
                                                            <?php endif; ?>
                                            <?php	$custom_settings_quantity++ ; ?>
                                                <?php endwhile; ?>
                                        </dl>
                                      </div>
									<?php

										  endif;
															$group_custom_settings_quantity++ ;
															$max_custom_settings_quantity = $max_custom_settings_quantity + 10;
								 
		 								endwhile;  

		 						?>
							</div>

							<?php
								if($title_1 != ''){
									?><div class="tab-pane <?php echo esc_attr($pix_active_title_1); ?>" id="tab4"><?php echo do_shortcode( get_post_meta( get_the_ID(), 'pixad_auto_custom_content_1', true ) ) ?></div><?php
								}
								if($title_2 != ''){
									?><div class="tab-pane <?php echo esc_attr($pix_active_title_2); ?>" id="tab5"><?php echo do_shortcode( get_post_meta( get_the_ID(), 'pixad_auto_custom_content_2', true ) ) ?></div><?php
								}
								if($title_3 != ''){
									?><div class="tab-pane <?php echo esc_attr($pix_active_title_3); ?>" id="tab6"><?php echo do_shortcode( get_post_meta( get_the_ID(), 'pixad_auto_custom_content_3', true ) ) ?></div><?php
								}

							?>

                            <?php if ($pix_show_contacts_tab) : ?>
							<div class="tab-pane <?php echo esc_attr($pix_active_contacts_tab); ?>" id="tab3">
								 <div class="rtd auto_contact_desc">
                                    <?php
                                        echo get_post_meta( get_the_ID(), 'pixad_auto_contact', true );
                                    ?>
								</div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <dl class="list-descriptions list-unstyled">


                                        <?php if ($validate['first-name_show'] && $PIXAD_Autos->get_meta('_seller_first_name')) { ?>
                                        <div class="dd-item">
                                            <dt class="left"><?php esc_html_e( 'First Name:', 'autozone' ); ?></dt>
                                                <dd class="right"><?php echo wp_kses_post($PIXAD_Autos->get_meta('_seller_first_name')) ?></dd>
                                        </div>
                                        <?php } elseif ($validate['first-name_show'] && $validate['first-name_def'] ) { ?>
                                        <div class="dd-item">
                                            <dt class="left"><?php esc_html_e( 'First Name:', 'autozone' ); ?></dt>
                                                <dd class="right"><?php echo esc_html($validate['first-name_def']); ?></dd>
                                        </div>
                                        <?php } else {}
                                        ?>

                                        <?php if( $validate['last-name_show'] && $PIXAD_Autos->get_meta('_seller_last_name') ) { ?>
                                        <div class="dd-item">
                                            <dt class="left"><?php esc_html_e( 'Last Name:', 'autozone' ); ?></dt>
                                            <dd class="right"><?php echo wp_kses_post($PIXAD_Autos->get_meta('_seller_last_name')) ?></dd>
                                        </div>
                                        <?php } elseif ($validate['last-name_show'] && $validate['last-name_def'] ) { ?>
                                        <div class="dd-item">
                                          <dt class="left"><?php esc_html_e( 'Last Name:', 'autozone' ); ?></dt>
                                            <dd class="right"><?php  echo esc_html($validate['last-name_def']); ?></dd>
                                        </div>
                                        <?php } else {}
                                        ?>

                                        <?php if( $validate['seller-company_show'] && $PIXAD_Autos->get_meta('_seller_company') ) { ?>
                                        <div class="dd-item">
                                            <dt class="left"><?php esc_html_e( 'Company:', 'autozone' ); ?></dt>
                                            <dd class="right"><?php echo wp_kses_post($PIXAD_Autos->get_meta('_seller_company')) ?></dd>
                                        </div>
                                    <?php } elseif ($validate['seller-company_show'] && $validate['seller-company_def'] ) { ?>
                                        <div class="dd-item">
                                          <dt class="left"><?php esc_html_e( 'Company:', 'autozone' ); ?></dt>
                                            <dd class="right"><?php  echo esc_html($validate['seller-company_def']); ?></dd>
                                        </div>
                                        <?php } else {}
                                        ?>

                                        <?php if( $validate['seller-phone_show'] && $PIXAD_Autos->get_meta('_seller_phone') ) { ?>
                                        <div class="dd-item">
                                            <dt class="left"><?php esc_html_e( 'Phone:', 'autozone' ); ?></dt>
                                            <dd class="right"><?php echo wp_kses_post($PIXAD_Autos->get_meta('_seller_phone')) ?></dd>
                                        </div>
                                    <?php } elseif ($validate['seller-phone_show'] && $validate['seller-phone_def'] ) { ?>
                                        <div class="dd-item">
                                          <dt class="left"><?php esc_html_e( 'Phone:', 'autozone' ); ?></dt>
                                            <dd class="right"><?php  echo esc_html($validate['seller-phone_def']); ?></dd>
                                        </div>
                                        <?php } else {}
                                        ?>

                                        <?php if( $PIXAD_Autos->get_meta('_seller_email') ) { ?>
                                        <div class="dd-item">
                                            <dt class="left"><?php esc_html_e( 'Email:', 'autozone' ); ?></dt>
                                            <dd class="right"><?php echo wp_kses_post($PIXAD_Autos->get_meta('_seller_email')) ?></dd>
                                        </div>
                                    <?php } elseif ($validate['seller-email_def'] ) { ?>
                                        <div class="dd-item">
                                          <dt class="left"><?php esc_html_e( 'Email:', 'autozone' ); ?></dt>
                                            <dd class="right"><?php  echo esc_html($validate['seller-email_def']); ?></dd>
                                        </div>
                                        <?php } else {}
                                        ?>

                                        <?php if( $validate['seller-country_show'] && $PIXAD_Autos->get_meta('_seller_country')) { ?>										<div class="dd-item">
                                            <dt class="left"><?php esc_html_e( 'Country:', 'autozone' ); ?></dt>
                                            <dd class="right"><?php echo wp_kses_post($PIXAD_Autos->get_meta('_seller_country')) ?></dd>
                                        </div>
                                    <?php } elseif ($validate['seller-country_def'] ) { ?>
                                        <div class="dd-item">
                                          <dt class="left"><?php esc_html_e( 'Country:', 'autozone' ); ?></dt>
                                            <dd class="right"><?php  echo esc_html($validate['seller-country_def']); ?></dd>
                                        </div>
                                        <?php } else {}
                                        ?>

                                        <?php if( $validate['seller-state_show'] && $PIXAD_Autos->get_meta('_seller_state')) { ?>
                                        <div class="dd-item">
                                            <dt class="left"><?php esc_html_e( 'State:', 'autozone' ); ?></dt>
                                            <dd class="right"><?php echo wp_kses_post($PIXAD_Autos->get_meta('_seller_state')) ?></dd>
                                        </div>
                                    <?php } elseif ($validate['seller-state_def'] ) { ?>
                                        <div class="dd-item">
                                          <dt class="left"><?php esc_html_e( 'State:', 'autozone' ); ?></dt>
                                            <dd class="right"><?php  echo esc_html($validate['seller-state_def']); ?></dd>
                                        </div>
                                        <?php } else {}
                                        ?>

                                        <?php if( $validate['seller-town_show'] && $PIXAD_Autos->get_meta('_seller_town')) { ?>
                                        <div class="dd-item">
                                            <dt class="left"><?php esc_html_e( 'Town:', 'autozone' ); ?></dt>
                                            <dd class="right"><?php echo wp_kses_post($PIXAD_Autos->get_meta('_seller_town')) ?></dd>
                                        </div>
                                    <?php } elseif ($validate['seller-town_def'] ) { ?>
                                        <div class="dd-item">
                                          <dt class="left"><?php esc_html_e( 'Town:', 'autozone' ); ?></dt>
                                            <dd class="right"><?php  echo esc_html($validate['seller-town_def']); ?></dd>
                                        </div>
                                        <?php } else {}
                                        ?>

                                    </dl>
                                    </div>
                                    <div class="col-md-8">

                                            <?php
                            if ($PIXAD_Autos->get_meta('_seller_location_lat') && $PIXAD_Autos->get_meta('_seller_location_long')){
                                    $local_location = true;
                            }else{
                                $local_location = false;
                            }

                            if ( $validate['seller-location-lat_def'] && $validate['seller-location-long_def'] ) {
                                $global_location = true;
                            }else{
                                $global_location = false;
                            }



                                                    ?>

                                             <?php if( $local_location || $global_location) : ?>
                                            <style>

                                                    #contact-map{
                                                        width: 100%;
                                                        height: 400px;
                                                        margin: 0 auto;
                                                    }

                                            </style>

                                        <div id="contact-map"></div>

                                        <script type="text/javascript">


                                            /*=== initializate google map ====*/

                                            function initMap() {

                                                var styles = [
                                                    {
                                                        "featureType": "administrative",
                                                        "elementType": "all",
                                                        "stylers": [
                                                            {
                                                                "visibility": "on"
                                                            },
                                                            {
                                                                "saturation": -100
                                                            },
                                                            {
                                                                "lightness": 20
                                                            }
                                                        ]
                                                    },
                                                    {
                                                        "featureType": "road",
                                                        "elementType": "all",
                                                        "stylers": [
                                                            {
                                                                "visibility": "on"
                                                            },
                                                            {
                                                                "saturation": -100
                                                            },
                                                            {
                                                                "lightness": 40
                                                            }
                                                        ]
                                                    },
                                                    {
                                                        "featureType": "water",
                                                        "elementType": "all",
                                                        "stylers": [
                                                            {
                                                                "visibility": "on"
                                                            },
                                                            {
                                                                "saturation": -10
                                                            },
                                                            {
                                                                "lightness": 30
                                                            }
                                                        ]
                                                    },
                                                    {
                                                        "featureType": "landscape.man_made",
                                                        "elementType": "all",
                                                        "stylers": [
                                                            {
                                                                "visibility": "simplified"
                                                            },
                                                            {
                                                                "saturation": -60
                                                            },
                                                            {
                                                                "lightness": 10
                                                            }
                                                        ]
                                                    },
                                                    {
                                                        "featureType": "landscape.natural",
                                                        "elementType": "all",
                                                        "stylers": [
                                                            {
                                                                "visibility": "simplified"
                                                            },
                                                            {
                                                                "saturation": -60
                                                            },
                                                            {
                                                                "lightness": 60
                                                            }
                                                        ]
                                                    },
                                                    {
                                                        "featureType": "poi",
                                                        "elementType": "all",
                                                        "stylers": [
                                                            {
                                                                "visibility": "off"
                                                            },
                                                            {
                                                                "saturation": -100
                                                            },
                                                            {
                                                                "lightness": 60
                                                            }
                                                        ]
                                                    },
                                                    {
                                                        "featureType": "transit",
                                                        "elementType": "all",
                                                        "stylers": [
                                                            {
                                                                "visibility": "off"
                                                            },
                                                            {
                                                                "saturation": -100
                                                            },
                                                            {
                                                                "lightness": 60
                                                            }
                                                        ]
                                                    }
                                                ];


            <?php if($local_location) { ?>

                                            var myLatLng = {lat: <?php echo esc_js($PIXAD_Autos->get_meta('_seller_location_lat')) ?>, lng: <?php echo esc_js($PIXAD_Autos->get_meta('_seller_location_long')) ?>};
                                            var address = "<?php echo esc_js($PIXAD_Autos->get_meta('_seller_location')) ?>";

            <?php } elseif ($global_location) { ?>

                                            var myLatLng = {lat: <?php echo esc_js($validate['seller-location-lat_def']) ?>, lng: <?php echo esc_js($validate['seller-location-long_def']) ?>};
                                            var address = "<?php echo esc_js($validate['seller-location_def']) ?>";

            <?php } ?>






                                            // Create a map object and specify the DOM element for display.
                                            var map = new google.maps.Map(document.getElementById("contact-map"), {
                                                center: myLatLng,
                                                scrollwheel: false,
                                                zoom: 15
                                            });

                                            var marker = new google.maps.Marker({
                                              position: myLatLng,
                                              map: map,
                                              title:address
                                            });

                                            map.setOptions({styles: styles});

                                        }

                                        </script>


                                        <?php endif; ?>
                                     </div>
                                </div>
							<?php endif; ?>
						    </div>
					</article>

					<?php
                    $pixad_banner_place = get_post_meta( get_the_ID(), 'pixad_auto_form_place', true );
                    if( get_post_meta( get_the_ID(), 'pixad_auto_banner', true ) != '' ) : ?>
					<div class="wrap-section-border">
                        <?php if($pixad_banner_place == 'content') { ?>

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

                        <?php } ?>

					</div><!-- end wrap-section-border -->
					<?php endif; ?>

				<!-- Modal -->                                                                     


		<?php  $pixba_style = get_option('pixba_style'); ?>
 <?php if ($pixba_style != 'sidebar'){?>			                                                           
<div class="modal fade" id="single-pixad-booking-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-body">  
           <div  id="booking_car_form">
                     <?php do_action('autozone_end_auto', $post); ?> 
           </div> 
      </div>

    </div>
  </div>
</div>
		 <?php } ?>	

				
<div class="modal fade" id="single-pixad-autos-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><?php esc_html_e( 'send details', 'autozone' ); ?></h4>
      </div>
      <div class="modal-body">
          
       <?php   echo do_shortcode("[kswr_cf7 cf7_id=\"$pixad_auto_form_id\" cf7_style=\"$pixad_auto_form_style\"]") ?>
      </div>

    </div>
  </div>
</div>
                    <?php if(class_exists('Pixad_Booking_AUTO')){?>
                        <div class="extra-modal modal fade" id="single-pixad-extra-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <?php $custom_fields = get_option('pixba_custom_fields');
                                        $count_fields = count($custom_fields);
                                        if($count_fields > 10) {
                                            $category = '';
                                            $icon = '';
                                            $s = 1;
                                            $k = 1;
                                            foreach ($custom_fields as $key => $field) {
                                                if(isset($field['icon'])){
                                                    if ( $icon == $field['icon']){
                                                        $field['icon'] = '';
                                                    } else {
                                                        $icon = $field['icon'];
                                                    }
                                                }
                                                if(isset($field['category'])){
                                                    if ( $category == $field['category']){
                                                        $field['category'] = '';
                                                    } else {
                                                        if($s > 1){
                                                            echo '</div>';
                                                        }
                                                        $category = $field['category'];
                                                        echo '<div class="fields_category_contain">';
                                                    }
                                                }
                                                $pix_booking_class = Pixad_Booking_AUTO::field_check_form_front($field);
                                                echo esc_attr($pix_booking_class, 'autozone');
                                                $s++;
                                            }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            jQuery.noConflict()(function ($){
                                jQuery(".booking-field-extra").on("click", function() {
                                    var pixba_id = '#pixba_booking_extra_hidden_' + jQuery(this).data('name');
                                    if(jQuery(this).is(':checked')){
                                        jQuery(pixba_id).prop('checked', true);
                                    } else {
                                        jQuery(pixba_id).prop('checked', false);
                                    }
                                    var numberOfChecked = ': +' + jQuery('.pixba_booking_extra_hidden:checked').length + ' added';
                                    jQuery('#extra_checked_count').html(numberOfChecked);
                                });
                            });
                        </script>
                    <?php } ?>
                         <!-- END Modal -->     


				</main>
			<?php
                // End the loop.
            endwhile;
            ?>
        </div>
        <?php if ($layout == 'right'):
			get_template_part( 'single', 'pixad-autos-sidebar' );
        endif;?>
    </div>
</div>

<?php get_footer();?>
