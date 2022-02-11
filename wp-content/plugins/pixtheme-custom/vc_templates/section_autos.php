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
$items_count = 5;
$auto_featured = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$slide_type = !empty($slide_type) ? $slide_type : 'idate';
$carousel = $carousel == 1 ? 'owl-carousel enable-owl-carousel' : '';
$auto_translate = unserialize( get_option( '_pixad_auto_translate' ) );

$out = '<div>';
$out .= '
			<div class="slider-grid '.esc_attr($carousel).' owl-theme 
            owl-theme_mod-c" 
            data-pagination="true" 
            data-single-item="true" 
            data-min480="1" data-min768="1" data-min992="1" data-min1200="1"  data-navigation="false" data-stop-on-hover="true" data-auto-play="false"
            
            >
			';
$Auto = new PIXAD_Autos();
if( $slide_type == 'ids' ) :

	preg_match_all( '/section_autos_slide([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
	$tab_titles = array();
	if ( isset( $matches[1] ) ) {
		if( count($matches[1]) > 0 )
			$items_count = $items_count*count($matches[1]);
		$tab_titles = $matches[1];
	}

	$tabs_ids = array();

	foreach ( $tab_titles as $tab ) {
		$tab_atts = shortcode_parse_atts( $tab[0] );
		$tabs_ids[] = isset( $tab_atts['item_1'] ) ? $tab_atts['item_1'] : 0;
		$tabs_ids[] = isset( $tab_atts['item_2'] ) ? $tab_atts['item_2'] : 0;
		$tabs_ids[] = isset( $tab_atts['item_3'] ) ? $tab_atts['item_3'] : 0;
		$tabs_ids[] = isset( $tab_atts['item_4'] ) ? $tab_atts['item_4'] : 0;
		$tabs_ids[] = isset( $tab_atts['item_5'] ) ? $tab_atts['item_5'] : 0;
	}

	$args = array(
		'post_type' => 'pixad-autos',
		'orderby' => 'post__in',
		'post__in' => $tabs_ids,
		'posts_per_page' => $items_count,
	);

else :

	$models_to_query = get_objects_in_term( explode( ",", $models ), 'auto-model');
	$args = array(
				'post_type' => 'pixad-autos',
				'orderby' => 'date',
				'post__in' => $models_to_query,
				'order' => 'DESC',
			);
	if($auto_featured != ''){
		$args['meta_query'] = array(
			array(
				'key' => 'pixad_auto_featured',
				'value' => $auto_featured
			),
		);
	}
	if( is_numeric($count) )
		$args['showposts'] = $count;
	else
		$args['posts_per_page'] = 5;
endif;

	$wp_query = new WP_Query( $args );

	if ($wp_query->have_posts()):
		$i = 0;
	    $cnt = $wp_query->found_posts;
		while ($wp_query->have_posts()) :

						$class = ($i % 5) == 0 ? 'autozone_latest_item_feature' : 'autozone_latest_item';
						$wp_query->the_post();

						$featured = get_post_meta($post->ID, 'pixad_auto_featured', true) != '' ? '<a class="slider-grid__btn btn btn-default btn-effect" href="javascript:void(0);"><span class="btn-inner">'.$auto_translate[get_post_meta($post->ID, 'pixad_auto_featured', true)].'</span></a>' : '';

                        $sale = $Auto->get_meta('_auto_sale_price') != '' ? '<span class="card__wrap-label sale">'.esc_html__( 'Sale', 'autozone' ).'</span>' : '';

						$link = get_the_permalink($post->ID);

						$thumbnail = get_the_post_thumbnail($post->ID, $class, array('class' => 'img-responsive'));

						$Auto->Query_Args( array('auto_id' => $post->ID) );

                        $price_catalog = is_numeric($Auto->get_meta('_auto_price')) || $Auto->get_meta('_auto_price') == ''  ? $Auto->get_price() : $auto_translate[$Auto->get_price()];

                        $custom_price_catalog = get_post_meta($post->ID, 'custom_price_catalog', 1) ;
                        $price_catalog = $custom_price_catalog ? $custom_price_catalog : $Auto->get_price();
                        //$price_catalog = is_numeric($PIXAD_Autos->get_meta('_auto_price')) || $PIXAD_Autos->get_meta('_auto_price') == '' ? $PIXAD_Autos->get_price() : $auto_translate[$PIXAD_Autos->get_price()];

                    if($Auto->get_meta('_auto_price')){
								$show_price = $price_catalog == '' ? '' : '<span class="slider-grid__price">'.wp_kses_post($price_catalog).'</span>';
							}else{
								$show_price ='';
							}
						
if( $i % 5 == 0 ){
$out .= '

			<div class="slider-grid__item">
                <div class="row">
                  <div class="col-md-5">
                    <div class="slider-grid__inner slider-grid__inner_mod-a">
                        <a href="'.esc_url($link).'">'.wp_kses_post($thumbnail).'</a>
                        '.$featured.'
                        '.wp_kses_post($sale).'
                        <div class="slider-grid__wrap-name">
                            <span class="slider-grid__name">'.wp_kses_post(get_the_title()).'</span>
                            '.$show_price.'
                        </div>
                    </div>
                  </div>';
    if($cnt == $i+1)
        $out .= '</div></div>';
} elseif( $i % 5 == 1 ) {
$out .= '

                  <div class="col-md-7">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="slider-grid__inner slider-grid__inner_mod-b">
                            <a href="'.esc_url($link).'">'.wp_kses_post($thumbnail).'</a>
                            '.wp_kses_post($sale).'
                            <span class="slider-grid__name">'.wp_kses_post(get_the_title()).'</span>
                            <a href="'.esc_url($link).'">
								<div class="slider-grid__hover">
									'.$show_price.'
									<ul class="slider-grid__info list-unstyled">
										<li><i class="icon icon-speedometer"></i>'.wp_kses_post($Auto->get_meta('_auto_mileage')).'</li>
										<li><i class="icon icon-paper-plane"></i>'.wp_kses_post($Auto->get_meta('_auto_year')).'</li>
									</ul>
								</div>
							</a>
                        </div>
                      </div>';
    if($cnt == $i+1)
        $out .= '</div></div></div></div>';
} elseif( $i % 5 == 2 ) {
$out .= '
                      <div class="col-sm-6">
                        <div class="slider-grid__inner slider-grid__inner_mod-b">
                            <a href="'.esc_url($link).'">'.wp_kses_post($thumbnail).'</a>
                            '.wp_kses_post($sale).'
                            <span class="slider-grid__name">'.wp_kses_post(get_the_title()).'</span>
                            <a href="'.esc_url($link).'">
								<div class="slider-grid__hover">
									'.$show_price.'
									<ul class="slider-grid__info list-unstyled">
										<li><i class="icon icon-speedometer"></i>'.wp_kses_post($Auto->get_meta('_auto_mileage')).'</li>
										<li><i class="icon icon-paper-plane"></i>'.wp_kses_post($Auto->get_meta('_auto_year')).'</li>
									</ul>
								</div>
							</a>
                        </div>
                      </div>
                    </div>';
    if($cnt == $i+1)
        $out .= '</div></div></div>';
} elseif( $i % 5 == 3 ) {
$out .= '
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="slider-grid__inner slider-grid__inner_mod-b">
                            <a href="'.esc_url($link).'">'.wp_kses_post($thumbnail).'</a>
                            '.wp_kses_post($sale).'
                            <span class="slider-grid__name">'.wp_kses_post(get_the_title()).'</span>
                            <a href="'.esc_url($link).'">
								<div class="slider-grid__hover">
									'.$show_price.'
									<ul class="slider-grid__info list-unstyled">
										<li><i class="icon icon-speedometer"></i>'.wp_kses_post($Auto->get_meta('_auto_mileage')).'</li>
										<li><i class="icon icon-paper-plane"></i>'.wp_kses_post($Auto->get_meta('_auto_year')).'</li>
									</ul>
								</div>
							</a>
                        </div>
                      </div>';
    if($cnt == $i+1)
        $out .= '</div></div></div></div>';
} elseif( $i % 5 == 4 ) {
$out .= '
                      <div class="col-sm-6">
                        <div class="slider-grid__inner slider-grid__inner_mod-b">
	                        <a href="' . esc_url($link) . '">' . wp_kses_post($thumbnail) . '</a>
	                        '.wp_kses_post($sale).'
                            <span class="slider-grid__name">' . wp_kses_post(get_the_title()) . '</span>
                            <a href="'.esc_url($link).'">
								<div class="slider-grid__hover">
									'.$show_price.'
									<ul class="slider-grid__info list-unstyled">
										<li><i class="icon icon-speedometer"></i>' . wp_kses_post($Auto->get_meta('_auto_mileage')) . '</li>
										<li><i class="icon icon-paper-plane"></i>' . wp_kses_post($Auto->get_meta('_auto_year')) . '</li>
									</ul>
								</div>
							</a>
                        </div>
                      </div>
                    </div>  ';

$out .= '

                  </div>
                </div>
              </div>
        ';
}
			$i++;
		endwhile;
		wp_reset_postdata();
	endif;
 
$out .= '            
		</div>
	</div>';

echo $out;