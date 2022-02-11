<?php
if( ! defined( 'ABSPATH' ) ) exit;
/*---------------------------------------------------------------------
 * PIXADRO CARS - SINGLE CAR PAGE TEMPLATE | Rewritten @since v0.7
 *--------------------------------------------------------------------*/
if( ! class_exists( 'PIXADROCUSTOM_SINGLE_POST' ) ) {
	
	class PIXADROCUSTOM_SINGLE_POST {
		
		function __construct() {
			
			// Show single auto page
			add_filter( 'the_content', array( $this, 'render' ) );
			
		}
		
		function render( $content ) {
			global $post;
			
			if( $post->post_type == 'pixad-autos' && is_singular( 'pixad-autos' ) ) {
				
				ob_start();
				
				$content  = $this->output();
				$content  = ob_get_contents();
				
				ob_end_clean();
				
				return $content;
			} else {
				return $content;
			}
			
		}
		
		function output() { 
			global $post, $PIXAD_Autos, $PIXAD_Country; 
			
			$Settings = new PIXAD_Settings();
			$validate = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_validation', true ); // Get validation settings
			$validate = pixad::validation( $validate ); ?>
			
			<!-- Single Car Classifieds -->
			<div id="pixad-autos-single" class="pixad-autos page clearfix">
				
				<!-- Left Side -->
				<div class="col-md-12">
					
						<?php
						$images = $PIXAD_Autos->get_meta('_auto_images');
							
						/**
						 * Lets check if single or multiple images in meta value
						 * If multiple images, choose only first one for thumbnail
						 */
						if( preg_match( "/,/", $images ) ) {
							$images = explode( ",", $images );
							$img	= $images;
							$image 	= $images[0];
						}else{
							$image = $images;
							$img = '';
						}
						
						$strip_title = strip_tags( get_the_title() );
						?>
						
						<!-- Main Image -->
						<div class="pixad-autos-main-image">
							<?php if( $PIXAD_Autos->get_meta('_auto_images') ): ?>
								<img src="<?php echo $image; ?>">
								
								<?php if( $validate['auto-price_show'] && $PIXAD_Autos->get_meta('_auto_price') ): ?>
								<span class="pixad-autos-main-image-price">
									<?php echo $PIXAD_Autos->get_price(); ?>
								</span>
								<?php endif; ?>
							<?php endif; ?>
							
							<div class="pixad-thumbs">
							<?php if( $img ): foreach( $img as $image ): ?>
								<a href="<?php echo $image; ?>" title="<?php echo $strip_title; ?>" class="col-lg-2 col-md-2 col-sm-2">
									<img src="<?php echo $image; ?>">
								</a>
							<?php endforeach; endif; ?>
							</div>
						</div><!-- / Main Image -->
						
						<h3><?php echo get_the_title(); ?></h3>
						
						<!-- Tabs Panel -->
						<div class="panel">
						
							<ul id="pixad-autos-tabs" class="nav nav-tabs nav-justified">
							
								<li class="active">
									<a href="pixad#auto-details" data-toggle="tab"><?php _e( 'Car Details', 'pixad' ); ?></a>
								</li>
								
								<li>
									<a href="pixad#auto-equipment" data-toggle="tab"><?php _e( 'Car Equipment', 'pixad' ); ?></a>
								</li>
								
								<li>
									<a href="pixad#auto-description" data-toggle="tab"><?php _e( 'Car Description', 'pixad' ); ?></a>
								</li>
								
								<li>
									<a href="pixad#contact-seller" data-toggle="tab"><?php _e( 'Contact Seller', 'pixad' ); ?></a>
								</li>
							
							</ul>
							
							<div id="pixad-autos-tabs-content" class="tab-content">
							
								<!-- Car Details Tab -->
								<div id="auto-details" class="tab-pane fade active in">
						
									<?php if( $PIXAD_Autos->get_make() ): ?>
									<!-- Make -->
									<div class="cell">
										<div class="left"><?php _e( 'Make:', 'pixad' ); ?></div>
										<div class="right"><?php echo $PIXAD_Autos->get_make(); ?></div>
									</div><!-- / Make -->
									<?php endif; ?>
									
									<?php if( $PIXAD_Autos->get_model() ): ?>
									<!-- Model -->
									<div class="cell">
										<div class="left"><?php _e( 'Model:', 'pixad' ); ?></div>
										<div class="right"><?php echo $PIXAD_Autos->get_model(); ?></div>
									</div><!-- / Model -->
									<?php endif; ?>

									<?php if( $validate['auto-year_show'] && $PIXAD_Autos->get_meta('_auto_year') ): ?>
									<!-- Made Year -->
									<div class="cell">
										<div class="left"><?php _e( 'Made Year:', 'pixad' ); ?></div>
										<div class="right"><?php echo $PIXAD_Autos->get_meta('_auto_year'); ?></div>
									</div><!-- / Made Year -->
									<?php endif; ?>
									
									<?php if( $validate['auto-mileage_show'] && $PIXAD_Autos->get_meta('_auto_mileage') ): ?>
									<!-- Mileage -->
									<div class="cell">
										<div class="left"><?php _e( 'Mileage:', 'pixad' ); ?></div>
										<div class="right"><?php echo number_format($PIXAD_Autos->get_meta('_auto_mileage')); ?></div>
									</div><!-- / Mileage -->
									<?php endif; ?>
									
									<?php if( $validate['auto-vin_show'] && $PIXAD_Autos->get_meta('_auto_vin') ): ?>
									<!-- VIN -->
									<div class="cell">
										<div class="left"><?php _e( 'VIN:', 'pixad' ); ?></div>
										<div class="right"><?php echo $PIXAD_Autos->get_meta('_auto_vin'); ?></div>
									</div><!-- / VIN -->
									<?php endif; ?>
									
									<?php if( $validate['auto-version_show'] && $PIXAD_Autos->get_meta('_auto_version') ): ?>
									<!-- Version -->
									<div class="cell">
										<div class="left"><?php _e( 'Version:', 'pixad' ); ?></div>
										<div class="right"><?php echo $PIXAD_Autos->get_meta('_auto_version'); ?></div>
									</div><!-- / Version -->
									<?php endif; ?>
									
									<?php if( $validate['auto-fuel_show'] && $PIXAD_Autos->get_meta('_auto_fuel') ): ?>
									<!-- Fuel -->
									<div class="cell">
										<div class="left"><?php _e( 'Fuel:', 'pixad' ); ?></div>
										<div class="right"><?php _e( $PIXAD_Autos->get_meta('_auto_fuel'), 'pixad' ); ?></div>
									</div><!-- / Fuel -->
									<?php endif; ?>
									
									<?php if( $validate['auto-engine_show'] && $PIXAD_Autos->get_meta('_auto_engine') ): ?>
									<!-- Engine -->
									<div class="cell">
										<div class="left"><?php _e( 'Engine (cm3):', 'pixad' ); ?></div>
										<div class="right"><?php echo $PIXAD_Autos->get_meta('_auto_engine'); ?></div>
									</div><!-- / Engine -->
									<?php endif; ?>
									
									<?php if( $validate['auto-horsepower_show'] && $PIXAD_Autos->get_meta('_auto_horsepower') ): ?>
									<!-- Horsepower -->
									<div class="cell">
										<div class="left"><?php _e( 'Horsepower (hp):', 'pixad' ); ?></div>
										<div class="right"><?php echo $PIXAD_Autos->get_meta('_auto_horsepower'); ?></div>
									</div><!-- / Horsepower -->
									<?php endif; ?>
									
									<?php if( $validate['auto-transmission_show'] && $PIXAD_Autos->get_meta('_auto_transmission') ) : ?>
									<!-- Transmission -->
									<div class="cell">
										<div class="left"><?php _e( 'Transmission:', 'pixad' ); ?></div>
										<div class="right"><?php _e( $PIXAD_Autos->get_meta('_auto_transmission'), 'pixad' ); ?></div>
									</div><!-- / Transmission -->
									<?php endif; ?>
									
									<?php if( $validate['auto-doors_show'] && $PIXAD_Autos->get_meta('_auto_doors') ): ?>
									<!-- Doors -->
									<div class="cell">
										<div class="left"><?php _e( 'Doors:', 'pixad' ); ?></div>
										<div class="right"><?php echo $PIXAD_Autos->get_meta('_auto_doors'); ?></div>
									</div><!-- / Doors -->
									<?php endif; ?>

									<?php if( $validate['auto-condition_show'] && $PIXAD_Autos->get_meta('_auto_condition') ): ?>
									<!-- Condition -->
									<div class="cell">
										<div class="left"><?php _e( 'Condition:', 'pixad' ); ?></div>
										<div class="right"><?php _e( $PIXAD_Autos->get_meta('_auto_condition'), 'pixad' ); ?></div>
									</div><!-- / Condition -->
									<?php endif; ?>
									
									<?php if( $validate['auto-drive_show'] && $PIXAD_Autos->get_meta('_auto_drive') ): ?>
									<!-- Drive -->
									<div class="cell">
										<div class="left"><?php _e( 'Drive:', 'pixad' ); ?></div>
										<div class="right"><?php _e( $PIXAD_Autos->get_meta('_auto_drive').' drive', 'pixad' ); ?></div>
									</div><!-- / Drive -->
									<?php endif; ?>
									
									<?php if( $validate['auto-seats_show'] && $PIXAD_Autos->get_meta('_auto_seats') ): ?>
									<!-- Seats -->
									<div class="cell">
										<div class="left"><?php _e( 'Seats:', 'pixad' ); ?></div>
										<div class="right"><?php echo $PIXAD_Autos->get_meta('_auto_seats'); ?></div>
									</div><!-- / Seats -->
									<?php endif; ?>
									
									<?php if( $validate['auto-color_show'] && $PIXAD_Autos->get_meta('_auto_color') ): ?>
									<!-- Color -->
									<div class="cell">
										<div class="left"><?php _e( 'Color:', 'pixad' ); ?></div>
										<div class="right"><?php echo $PIXAD_Autos->get_meta('_auto_color'); ?></div>
									</div><!-- / Color -->
									<?php endif; ?>
									
									<?php if( $validate['auto-price_show'] && $PIXAD_Autos->get_meta('_auto_price') ): ?>
									<!-- Price -->
									<div class="cell">
										<div class="left"><?php _e( 'Price:', 'pixad' ); ?></div>
										<div class="right"><?php echo $PIXAD_Autos->get_price(); ?></div>
									</div><!-- / Price -->
									<?php endif; ?>
									
									<?php if( $validate['auto-price-type_show'] && $PIXAD_Autos->get_meta('_auto_price_type') ): ?>
									<!-- Price Type -->
									<div class="cell">
										<div class="left"><?php _e( 'Price Type:', 'pixad' ); ?></div>
										<div class="right"><?php _e( $PIXAD_Autos->get_meta('_auto_price_type'), 'pixad' ); ?></div>
									</div><!-- / Price Type -->
									<?php endif; ?>
									
									<?php if( $validate['auto-warranty_show'] && $PIXAD_Autos->get_meta('_auto_warranty') ): ?>
									<!-- Warranty -->
									<div class="cell">
										<div class="left"><?php _e( 'Warranty:', 'pixad' ); ?></div>
										<div class="right"><?php _e( $PIXAD_Autos->get_meta('_auto_warranty'), 'pixad' ); ?></div>
									</div><!-- / Warranty -->
									<?php endif; ?>
									
								</div><!-- / Car Details Tab -->
								
								<!-- Car Equipment Tab -->
								<div id="auto-equipment" class="tab-pane fade in">
									<?php $terms = wp_get_post_terms( $post->ID, 'auto-equipment' ); ?>
									
									<?php foreach( $terms as $term ): ?>
									<div class="cell">
										<div class="left"><?php echo $term->name; ?></div>
										<div class="right">
											<input class="pixad-checkbox" type="checkbox" name="<?php echo $term->name; ?>" checked disabled>
											<label><span></span></label>
										</div>
									</div>
									<?php endforeach; ?>
								
								</div><!-- / Car Equipment Tab -->
								
								<!-- Car Description Tab -->
								<div id="auto-description" class="tab-pane fade in">
									<div class="right">
										<?php echo str_replace("\r", "<br />", get_the_content('')); ?>
									</div>
								</div><!-- / Car Description Tab -->
								
								<!-- Contact Seller Tab -->
								<div id="contact-seller" class="tab-pane fade in">
									
									<?php if( $validate['first-name_show'] && $PIXAD_Autos->get_meta('_seller_first_name') ): ?>
									<div class="cell">
										<div class="left"><?php _e( 'First Name', 'pixad' ); ?></div>
										<div class="right"><?php echo $PIXAD_Autos->get_meta('_seller_first_name'); ?></div>
									</div>
									<?php endif; ?>
									
									<?php if( $validate['last-name_show'] && $PIXAD_Autos->get_meta('_seller_last_name') ): ?>
									<div class="cell">
										<div class="left"><?php _e( 'Last Name', 'pixad' ); ?></div>
										<div class="right"><?php echo $PIXAD_Autos->get_meta('_seller_last_name'); ?></div>
									</div>
									<?php endif; ?>
									
									<?php if( $PIXAD_Autos->get_meta('_seller_email') ): ?>
									<div class="cell">
										<div class="left"><?php _e( 'E-mail', 'pixad' ); ?></div>
										<div class="right">
											<a id="show-email"><?php _e( 'show email', 'pixad' ); ?></a>
											<a id="hide-email"><?php echo $PIXAD_Autos->get_meta('_seller_email'); ?></a>
										</div>
									</div>
									<?php endif; ?>
									
									<?php if( $validate['seller-phone_show'] && $PIXAD_Autos->get_meta('_seller_phone') ): ?>
									<div class="cell">
										<div class="left"><?php _e( 'Phone', 'pixad' ); ?></div>
										<div class="right">
											<a id="show-phone"><?php _e( 'show phone', 'pixad' ); ?></a>
											<a id="hide-phone"><?php echo $PIXAD_Autos->get_meta('_seller_phone'); ?></a>
										</div>
									</div>
									<?php endif; ?>
									
									<?php if( $validate['seller-company_show'] && $PIXAD_Autos->get_meta('_seller_company') ): ?>
									<div class="cell">
										<div class="left"><?php _e( 'Company', 'pixad' ); ?></div>
										<div class="right"><?php echo $PIXAD_Autos->get_meta('_seller_company'); ?></div>
									</div>
									<?php endif; ?>
									
									<?php if( $validate['seller-country_show'] && $PIXAD_Autos->get_meta('_seller_country') ): ?>
									<div class="cell">
										<div class="left"><?php _e( 'Country', 'pixad' ); ?></div>
										<div class="right"><?php $PIXAD_Country->text_output( $PIXAD_Autos->get_meta('_seller_country') ); ?></div>
									</div>
									<?php endif; ?>
									
									<?php if( $validate['seller-state_show'] && $PIXAD_Autos->get_meta('_seller_state') ): ?>
									<div class="cell">
										<div class="left"><?php _e( 'State', 'pixad' ); ?></div>
										<div class="right"><?php echo $PIXAD_Autos->get_meta('_seller_state'); ?></div>
									</div>
									<?php endif; ?>
									
									<?php if( $validate['seller-town_show'] && $PIXAD_Autos->get_meta('_seller_town') ): ?>
									<div class="cell">
										<div class="left"><?php _e( 'Town', 'pixad' ); ?></div>
										<div class="right"><?php echo $PIXAD_Autos->get_meta('_seller_town'); ?></div>
									</div>
									<?php endif; ?>
									
									<script>
									jQuery('#show-email').click(function(){
										jQuery('#show-email').hide();
										jQuery('#hide-email').show();
									});
									jQuery('#hide-email').hide();
									
									jQuery('#show-phone').click(function(){
										jQuery('#show-phone').hide();
										jQuery('#hide-phone').show();
									});
									jQuery('#hide-phone').hide();
									</script>
								</div><!-- / Contact Seller Tab -->
							
							</div>
						
						</div><!-- / Tabs Panel -->
					
				</div>
				
				<script>
				jQuery(document).ready(function($) {
					$('.pixad-thumbs').magnificPopup({
						delegate: 'a',
						type: 'image',
						gallery: {enabled: true}
					});
				});
				</script>

			</div><!-- / Single Car Classifieds -->
			
		<?php }
		
	}
	new PIXADROCUSTOM_SINGLE_POST;
}