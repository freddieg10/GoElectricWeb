<?php 
if( ! defined( 'ABSPATH' ) ) exit;
/*---------------------------------------------------------------------
 * PIXADRO CARS - SHORTCODE | Rewritten @since v0.7
 *--------------------------------------------------------------------*/
if( ! class_exists( 'PIXADROCUSTOM_SHORTCODE_CARS' ) ) {
	
	class PIXADROCUSTOM_SHORTCODE_CARS {
		
		/**
		 * Class Constructor
		 *
		 * @rewritten
		 * @since 0.7
		 */
		function __construct() {
			
			add_shortcode( 'pixad_autos', array( $this, 'shortcode' ) );
			
		}
		
		/**
		 * Shortcode Initialization
		 *
		 * @rewritten
		 * @since 0.7
		 */
		function shortcode( $atts, $content ) {

			ob_start();
			
			$html  = do_shortcode( $content );
			$html .= self::render( $atts );
			$html  = ob_get_contents();
			
			ob_end_clean();
			
			return $html;
		}
		
		/**
		 * Shortcode Render
		 *
		 * @rewritten
		 * @since 0.7
		 */
		static private function render( $Query = false ) {
			global $post, $PIXAD_Autos;
			
			$Settings = new PIXAD_Settings(); 
			$settings = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
			
			$validate = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_validation', true ); // Get validation settings
			$validate = pixad::validation( $validate ); // Fix undefined index notice
			
			$loop = new WP_Query( $PIXAD_Autos->Query_Args( $Query ) );

			// If delete auto fired
			if( isset( $_GET['pixad'] ) && $_GET['pixad'] == 'delete-pixad' && ! empty( $_GET['id'] ) ) {
				if( wp_delete_post( $_GET['id'] ) ) {
					echo
					'
					<div class="alert alert-success">
						<strong>'.__( 'Car deleted successfuly!', TEXTDOMAIN ).'</strong>
					</div>
					';
				}
			}
			
			// Output message with number how many autos found
			if( isset( $_POST['search-autos'] ) ) {
				echo
				'
				<div class="alert alert-success">
					<strong>'.__( 'Found Cars', TEXTDOMAIN ).':</strong> '. $loop->found_posts .'
				</div>
				';
			} ?>

			<div class="pixad-autos loop clearfix">
				
				<main class="col-md-12" role="main">
					
					<?php
					###################################################################################
					# IF USER IS LOGGED IN AND WANTS ADD NEW CLASSIFIED, LOAD add_pixad.php
					###################################################################################
					if( 
						isset( $_POST['add-new-pixad'] ) && $settings['mode'] == 'pixads' 
						or 
						isset( $_GET['pixad'] ) && $_GET['pixad'] == 'add-new-pixad' && $settings['mode'] == 'pixads' 
					  ): 

						require_once( PIXAD_TEMPLATES_DIR . 'parts/add_pixad.php' );
						
					###################################################################################
					# ELSE IF USER WANTS TO EDIT OWN CLASSIFIED LOAD edit_pixad.php 
					###################################################################################
					elseif( is_user_logged_in() && isset( $_GET['pixad'] ) && $_GET['pixad'] == 'edit-pixad' && $settings['mode'] == 'pixads' ):
					
						require_once ( PIXAD_TEMPLATES_DIR . 'parts/edit_pixad.php' );
					
					###################################################################################
					# ELSE IF USER WANTS TO SEE OWN MEMBERSHIP PAGE LOAD my_membership.php 
					###################################################################################
					elseif( is_user_logged_in() && isset( $_GET['pixad'] ) && $_GET['pixad'] == 'my-membership' && $settings['mode'] == 'pixads' ):
					
						require_once( PIXAD_TEMPLATES_DIR . 'parts/my_membership.php' );
					
					###################################################################################
					# ELSE IF USER WANTS TO SEE OWN TRANSACTIONS PAGE LOAD my_transactions.php 
					###################################################################################
					elseif( is_user_logged_in() && isset( $_GET['pixad'] ) && $_GET['pixad'] == 'my-transactions' && $settings['mode'] == 'pixads' ):
					
						require_once( PIXAD_TEMPLATES_DIR . 'parts/my_transactions.php' );
					
					###################################################################################
					# ELSE IF USER WANTS TO CHANGE MEMBERSHIP PLAN LOAD select_membership.php 
					###################################################################################
					elseif( is_user_logged_in() && isset( $_GET['pixad'] ) && $_GET['pixad'] == 'change-membership' && $settings['mode'] == 'pixads' ):
					
						require_once( PIXAD_TEMPLATES_DIR . 'parts/select_membership.php' );
					
					###################################################################################
					# ELSE SHOW CAR CLASSIFIEDS LOOP PAGE FOR ALL USERS
					###################################################################################
					else: ?>
					
					<!-- Cars Top Filter -->
					<div class="autos-top-filter clearfix">
							<div class="pull-left">
								<?php 
								
									// Order by date url
									$order_date = isset( $_GET['order-date'] ) ? esc_attr( $_GET['order-date'] ) : '';
									
									if( isset( $order_date ) && $order_date == 'asc' ) {
										$date = 'desc';
									}elseif( isset( $order_date ) && $order_date == 'desc' ) {
										$date = 'asc';
									}else{
										$date = 'asc';
									}
									
									// Order by price url
									$order_price = isset( $_GET['order-price'] ) ? esc_attr( $_GET['order-price'] ) : '';
									
									if( isset( $order_price ) && $order_price == 'asc' ) {
										$price = 'desc';
									}elseif( isset( $order_price ) && $order_price == 'desc' ) {
										$price = 'asc';
									}else{
										$price = 'asc';
									}
								?>
								
								<a href="<?php echo get_permalink(); ?>?order-date=<?php echo $date; ?>">
									<?php  _e( 'Date:', TEXTDOMAIN ); ?> <i class="fa fa-sort-numeric-<?php echo $date; ?>"></i>
								</a>
								
							</div>
							<div class="pull-right">
								<a id="autos-list-grid-style" href="#">
									<i class="fa fa-2x"></i>
								</a>
							</div>
					</div><!-- / Cars Top Filter -->
					
					<div id="change-layout" class="autos-list">
						
						<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
						
							<article id="post-<?php the_ID(); ?>">
								
								
								<?php if( $post->post_author == get_current_user_id() && isset( $_GET['pixad'] ) && $_GET['pixad'] == 'my-pixads' ): // Works only when pixad=my-pixads fired ?>
									<div class="pixadro-action-links col-md-12">
										<ul>
											<li><?php printf( '<a href="%s">%s</a>', esc_url( add_query_arg( array('pixad' => 'edit-pixad', 'id' => get_the_ID()), get_permalink( $settings['cc_page_id'] ) ) ), __( 'Edit Car', TEXTDOMAIN ) ); ?></li>
											<li><?php printf( '<a href="%s">%s</a>', esc_url( add_query_arg( array('pixad' => 'delete-pixad', 'id' => get_the_ID()), get_permalink( $settings['cc_page_id'] ) ) ), __( 'Delete Car', TEXTDOMAIN ) ); ?></li>
										</ul>
									</div>
								<?php endif; ?>
								
								<!-- Article Inner Wrapper -->
								<div class="article-inner-wrapper clearfix">
									
									<?php
										$images = $PIXAD_Autos->get_meta('_auto_images');
										
										/**
										 * Lets check if single or multiple images in meta value
										 * If multiple images, choose only first one for thumbnail
										 */
										if( preg_match( "/,/", $images ) ) {
											$images = explode( ",", $images );
											$image = $images[0];
										}else{
											$image = $images;
										}
										
										$strip_title = strip_tags( get_the_title() );
									?>
									
									<!-- Car Thumbnail -->
									<div class="auto-thumbnail col-lg-4 col-md-4 col-sm-4">
										<?php if( $PIXAD_Autos->get_meta('_auto_images') ): ?>
											<a href="<?php the_permalink(); ?>" title="<?php echo $strip_title; ?>">
												<img src="<?php echo $image; ?>" alt="<?php echo $strip_title; ?>">
												
												<span class="price"><?php echo $PIXAD_Autos->get_price(); ?></span>
												
											</a>
										<?php else: ?>
											<img class="no-image" src="<?php echo PIXADRO_CAR_URI .'assets/img/no_image.pixadg'; ?>" alt="no-image">
										<?php endif; ?>
										
									</div><!-- / Car Thumbnail -->

									<!-- Car Details -->
									<div class="auto-info col-lg-8 col-md-8 col-sm-8">
										
										<div class="title-price-container">
											<h6><a href="<?php the_permalink(); ?>" title="<?php echo $strip_title; ?>"><?php the_title(); ?></a></h6>
											
											<?php if( $validate['auto-price_show'] ): ?>
											<span class="price">
												<?php echo $PIXAD_Autos->get_price(); ?>
											</span>
											<?php endif; ?>
											
										</div>
										
										<ul>
											
											<?php if( $validate['auto-fuel_show'] ): ?>
											<li>
											  <b><?php _e( 'Fuel:', TEXTDOMAIN ); ?></b> 
											  
											  <?php if( $PIXAD_Autos->get_meta('_auto_fuel') ): ?>
												<span><?php _e( $PIXAD_Autos->get_meta('_auto_fuel'), TEXTDOMAIN ); ?></span>
											  <?php endif; ?>
											</li>
											<?php endif; ?>
											
											<?php if( $validate['auto-mileage_show'] ): ?>
											<li><!-- Mileage -->
											  <b><?php _e( 'Mileage:', TEXTDOMAIN ); ?></b>
											  
											  <?php if( $PIXAD_Autos->get_meta('_auto_mileage') ): ?>
												<span><?php echo number_format($PIXAD_Autos->get_meta('_auto_mileage')); ?></span>
											  <?php endif; ?>
											</li>
											<?php endif; ?>
											
											<?php if( $validate['auto-year_show'] ): ?>
											<li>
											  <b><?php _e( 'Year:', TEXTDOMAIN ); ?></b> 
											  
											  <?php if( $PIXAD_Autos->get_meta('_auto_year') ): ?>
												<span><?php echo $PIXAD_Autos->get_meta('_auto_year'); ?></span>
											  <?php endif; ?>
											</li>
											<?php endif; ?>
											
											<?php if( $validate['seller-country_show'] ): ?>
											<li>
											  <b><?php _e( 'Location:', TEXTDOMAIN ); ?></b>
											  <?php $country = new PIXAD_Country(); ?>
											  
											  <?php if( $PIXAD_Autos->get_meta('_seller_country') ): ?>
												<span><?php $country->text_output( $PIXAD_Autos->get_meta('_seller_country') ); ?></span>
											  <?php endif; ?>
											</li>
											<?php endif; ?>
											
										</ul>
									</div><!-- / Car Details -->
								</div><!-- / Article Inner Wrapper -->
								
								<div class="aditional-info clearfix">
									<ul>
									<?php if( get_the_date() ): ?>
										<li><span><?php echo get_the_date(); ?></span></li>
									<?php endif; ?>
									
									<?php if( $validate['auto-condition_show'] && $PIXAD_Autos->get_meta('_auto_condition') ): ?>
										
										<?php if( $PIXAD_Autos->get_meta('_auto_condition') == 'used' ): ?>
											<li><span><?php _e( 'Used', TEXTDOMAIN ); ?></span></li>
										<?php else: ?>
											<li><span><?php _e( 'New', TEXTDOMAIN ); ?></span></li>
										<?php endif; ?>
										
									<?php endif; ?>
									
									<?php if( $validate['auto-drive_show'] && $PIXAD_Autos->get_meta('_auto_drive') ): ?>
									
										<?php if( $PIXAD_Autos->get_meta('_auto_drive') == 'left' ): ?>
											<li><span><?php _e( 'Left drive', TEXTDOMAIN ); ?></span></li>
										<?php else: ?>
											<li><span><?php _e( 'Right drive', TEXTDOMAIN ); ?></span></li>
										<?php endif; ?>
									
									<?php endif; ?>
									
									<?php if( $validate['auto-engine_show'] && $PIXAD_Autos->get_meta('_auto_engine') ): ?>
									<li><span><?php echo $PIXAD_Autos->get_meta('_auto_engine'); ?> <?php _e( 'cm3', TEXTDOMAIN ); ?></span></li>
									<?php endif; ?>
									
									<?php if( $validate['auto-horsepower_show'] && $PIXAD_Autos->get_meta('_auto_horsepower') ): ?>
										<li><span><?php echo $PIXAD_Autos->get_meta('_auto_horsepower').' '.__( 'hp', TEXTDOMAIN ); ?></span></li>
									<?php endif; ?>
									
									<?php if( $validate['auto-doors_show'] && $PIXAD_Autos->get_meta('_auto_doors') ): ?>
										<li><span><?php echo $PIXAD_Autos->get_meta('_auto_doors').' '.__( 'doors', TEXTDOMAIN ); ?></span></li>
									<?php endif; ?>
									
									</ul>
								</div>
									
							</article>
						<?php endwhile; ?>
						
					</div>
					
					<?php if( ! isset( $_POST['add-new-pixad'] ) ) { ?>
					<!-- Pagination -->
					<div id="pixadro-pagination" class="clearfix">
						<?php
						$big = 999999999; // need an unlikely integer
						
						/**
						* Fix Paged on Static Homepage
						* ============================
						* @since 0.4
						*/
						if( get_query_var('paged') ) { $paged = get_query_var('paged'); }
						elseif( get_query_var('page') ) { $paged = get_query_var('page'); }
						else { $paged = 1; }

						echo paginate_links( array(
							'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format' => '?paged=%#%',
							'current' => max( 1, $paged ),
							'total' => $loop->max_num_pages
						) );
						?>
					</div><!-- / Pagination -->
					<?php } ?>
					
					<?php endif; ?>
					
				</main>
			</div>
		<?php
		}
	}
	new PIXADROCUSTOM_SHORTCODE_CARS;
}