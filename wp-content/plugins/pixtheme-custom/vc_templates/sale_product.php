<?php 
	$output = '';
	$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
	extract( $atts );
 
	$product = new WC_product($product_id);
	$product_post = get_post($product->get_id());
 	$sale_price_dates_to = ( $date = get_post_meta( $product_id, '_sale_price_dates_to', true ) ) ? date_i18n( 'F d, Y', $date ) : ''; 
	
	wp_enqueue_style('dscountdown', get_template_directory_uri(). '/assets/countdown/dscountdown.css');
 	wp_enqueue_script( 'dscountdown', get_template_directory_uri() . '/assets/countdown/dscountdown.min.js' );

?>
<script>
	jQuery(document).ready(function($) {
		var $countdown = jQuery( '.countdown' );
			if($countdown && $countdown.length){
				$countdown.each(function(i) {
					var $countdownItem = jQuery(this);
					
					var endDateData = $countdownItem.data('end-date');
					var themeData = $countdownItem.data('theme');
					var titleDaysData = $countdownItem.data('title-days');
					var titleHoursData = $countdownItem.data('title-hours');
					var titleMinutesData = $countdownItem.data('title-minutes');
					var titleSecondsData = $countdownItem.data('title-seconds');
					
					$countdownItem.dsCountDown({
						endDate: new Date(endDateData),
						theme: themeData,
						titleDays: titleDaysData,
						titleHours: titleHoursData,
						titleMinutes: titleMinutesData,
						titleSeconds: titleSecondsData
					});
				});
			}	
	});
</script>
<?php if ($type === 'Type1') { ?>

<div class="b-hot-deal woocommerce">
	<div class="hot-deal-card">
		<h3 class="heading-line"><?php echo esc_attr($title) ?></h3>
		<div class="image">
			<a href="<?php echo get_permalink($product_id) ?>">
				<?php echo get_the_post_thumbnail($product_id, 'medium', array('class'=>"img-responsive center-block")); ?>
			</a>
		</div>
		
		<div class="countdown dsCountDown ds-custom" data-end-date="<?php echo esc_attr($sale_price_dates_to)  ?> 23:59:00" data-theme="custom" data-title-days="DAY" data-title-hours="HRS" data-title-minutes="MINS" data-title-seconds="SECS">
		</div>
		<div class="card-info">
			<div class="caption">
				<div class="name-item">
					<a class="product-name" href="<?php echo get_permalink($product_id)  ?>"><?php echo esc_attr($product_post->post_title)  ?></a>
					
					<?php if ( $rating_html =  wc_get_rating_html( $product->get_id() ) ) : ?>
						<?php echo wp_kses_post($rating_html); ?>
					<?php endif; ?>
					 
				</div>
				<div class="deal-prices clearfix">
					<div class="deal pull-left">
						<span><?php esc_html_e('deal price', 'autozone'); ?></span>
						<br>
						<span class="product-price"><?php  echo wc_price( $product->get_sale_price() ) ?></span>
					</div>
					<div class="regular pull-right">
						<span><?php esc_html_e('regular price', 'autozone'); ?></span>
						<br>
						<span class="product-price-old"><?php echo wc_price( $product->get_regular_price() );  ?></span>
					</div>
				</div> 
			</div>
			<div class="cart-add-buttons">
				<?php echo apply_filters( 'woocommerce_loop_add_to_cart_link',
					sprintf( '<a href="?add-to-cart=%s" id="add-cart1"  rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button btn-add-cart-full">',
						esc_attr( $product->get_id()),
						esc_attr( $product->get_id() ),
						esc_attr( $product->get_sku() ),
						esc_attr( isset( $quantity ) ? $quantity : 1 ),
						$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
						esc_attr( $product->get_type()),
						esc_html( $product->add_to_cart_text() )
					),
				$product ) ?>
				<span><i class="fa fa-shopping-cart"></i></span><?php _e( 'add to cart', 'autozone') ?>
				</a>
				 
			</div>
		</div>
	</div>
</div>

<?php } else { ?>

<div class="b-hot-deal-mod">
	<div class="b-hot-container">
		<div class="row">
			<div class="col-sm-8">
				<div class= "row">
					<div class="hot-deal-mod-item clearfix">
						<div>
							<div class="col-sm-5">
								<div class="image">
									<?php echo get_the_post_thumbnail($product_id, 'large', array('class'=>"img-responsive center-block")); ?>
								</div>
							</div>
							<div class="col-sm-7">
								<div class="detail-info">
									<div class="card-info">
										<div class="caption">
											<div class="name-item">
												<?php echo esc_attr($product_post->post_title)  ?>
											</div>
											<?php if ( $rating_html =  wc_get_rating_html( $product->get_id() ) ) : ?>
												<?php echo wp_kses_post($rating_html); ?>
											<?php endif; ?>
											<div class="product-description">
												<p>
													<?php echo wp_kses_post($product_post->post_excerpt)  ?>
												</p>
												<a href="<?php echo get_permalink($product_id)  ?>"><?php esc_html_e('READ THE REVIEW', 'autozone'); ?></a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="b-hot-deal wow fadeInRight">
					<div class="hot-deal-card">
						<div class="countdown" data-end-date="<?php echo esc_attr($sale_price_dates_to)  ?> 23:59:00" data-theme="custom" data-title-days="DAY" data-title-hours="HRS" data-title-minutes="MINS" data-title-seconds="SECS" ></div>
						<div class="card-info">
							<div class="caption">
								<div class="deal-prices clearfix">
									<div class="deal pull-left">
										<span><?php esc_html_e('deal price', 'autozone'); ?></span>
										<br>
										<span class="product-price"><?php  echo wc_price( $product->get_sale_price() ) ?></span>
									</div>
									<div class="regular pull-right">
										<span><?php esc_html_e('regular price', 'autozone'); ?></span>
										<br>
										<span class="product-price-old"><?php  echo wc_price( $product->get_regular_price() ) ?></span>
									</div>
								</div>
							</div>
							<div class="cart-add-buttons">
							<?php echo apply_filters( 'woocommerce_loop_add_to_cart_link',
								sprintf( '<a href="?add-to-cart%s" id="add-cart1"  rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="btn-add-cart-full">',
									esc_attr( $product->get_id()),
									esc_attr( $product->get_id() ),
									esc_attr( $product->get_sku() ),
									esc_attr( isset( $quantity ) ? $quantity : 1 ),
									$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
									esc_attr( $product->get_type()),
									esc_html( $product->add_to_cart_text() )
								),
							$product ) ?>
							<span><i class="fa fa-shopping-cart"></i></span><?php _e( 'add to cart', 'autozone') ?>
							</a>
							 
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php } ?>