<?php
global $post;
/**
 * Shortcode attributes
 * @var $atts
 * @var $carousel
 * @var $slide_type
 * @var $count
 * @var $models
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Autos
 */
$count = 8;
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$carousel = $carousel == 1 ? 'owl-carousel enable-owl-carousel' : '';
$per_page = $per_page == '' ? 8 : $per_page;

$out = '<div>';
$out .= '
			<div class="slider-grid '.esc_attr($carousel).' owl-theme owl-theme_mod-c" data-pagination="true" data-single-item="true" data-auto-play="7000" data-transition-style="fade" data-main-text-animation="true" data-after-init-delay="3000" data-after-move-delay="1000" data-stop-on-hover="true">
			';
$Auto = new PIXAD_Autos();


	$models_to_query = get_objects_in_term( explode( ",", $models ), 'auto-model');
	$args = array(
				'post_type' => 'pixad-autos',
				'orderby' => 'date',
				'post__in' => $models_to_query,
				'order' => 'DESC',
			);
	if( is_numeric($count) )
		$args['showposts'] = $count;
	else
		$args['posts_per_page'] = 8;


	$wp_query = new WP_Query( $args );

	if ($wp_query->have_posts()):
		$i = $j = 0;
		while ($wp_query->have_posts()) :

						$wp_query->the_post();

						$featured = get_post_meta($post->ID, 'pixad_auto_featured', true) != '' ? '<a class="slider-grid__btn btn btn-default btn-effect" href="javascript:void(0);"><span class="btn-inner">'.get_post_meta($post->ID, 'pixad_auto_featured', true).'</span></a>' : '';

						$link = get_the_permalink($post->ID);

						$thumbnail = get_the_post_thumbnail($post->ID, 'autozone_latest_item', array('class' => 'img-responsive'));

						$Auto->Query_Args( array('auto_id' => $post->ID) );
if( $i > 1 && $i % $per_page == 0 ){
$out .= '
			</div>
                ';
}
if( $i > 1 && $i % 4 == 0 ){
$out .= '
				</div>
                ';
}
if( $i % $per_page == 0 ){
			$out .= '
			<div class="slider-grid__item">
                ';
		}
if( $i % 4 == 0 ){
$out .= '
				<div class="row">
                ';
}

$out .= '
					<div class="col-md-3">
	                    <div class="slider-grid__inner slider-grid__inner_mod-b">
	                        <a href="'.esc_url($link).'">'.wp_kses_post($thumbnail).'</a>
	                        <span class="slider-grid__name">'.wp_kses_post(get_the_title()).'</span>
	                        <a href="'.esc_url($link).'">
								<div class="slider-grid__hover">
									<span class="slider-grid__price">'.wp_kses_post($Auto->get_price()).'</span>
									<ul class="slider-grid__info list-unstyled">
										<li><i class="icon icon-speedometer"></i>'.wp_kses_post($Auto->get_meta('_auto_mileage')).'</li>
										<li><i class="icon icon-paper-plane"></i>'.wp_kses_post($Auto->get_meta('_auto_year')).'</li>
									</ul>
								</div>
							</a>
	                    </div>
                    </div>
                    ';

			$i++;
		endwhile;
		wp_reset_postdata();
	endif;
 
$out .= '
				</div>
            </div>
		</div>
	</div>';

echo $out;