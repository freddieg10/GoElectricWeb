<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $typetable
 * @var $monthtext
 * @var $yeartext
 * @var $monthshort
 * @var $yearshort
 * @var $currency
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Pricetable
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$section_cont = explode( '[/section_pricecol]', $content );
array_pop($section_cont);
if( is_array( $section_cont ) && !empty( $section_cont ) ){
	$i=0;
	foreach( $section_cont as $tab ){
		$i++;
		preg_match_all( '/section_pricecol([^\]]+)/i', $tab, $matches, PREG_OFFSET_CAPTURE );
		$tab_atts = shortcode_parse_atts( $matches[1][0][0] );
		if ( isset( $tab_atts['title'] ) ) {
			$class = isset($tab_atts['ispopular']) && $tab_atts['ispopular'] == true ? 'p-recommended' : '';
			$flag = isset($tab_atts['ispopular']) && $tab_atts['ispopular'] == true ? '<div class="p-r-angle"><span class="ef icon_check"></span></div>' : '';
			$type = isset($tab_atts["type"]) ? $tab_atts["type"] : 'pixflaticon';
			$icon = isset( $tab_atts['icon_'.$type] ) ? $tab_atts['icon_'.$type] : '';
			$href = vc_build_link( $tab_atts['link'] );
			$class_year = in_array($typetable, array('', 'yearly')) ? 'is-visible' : 'is-hidden';
			$class_month = $typetable == 'monthly' ? 'is-visible' : 'is-hidden';
			$monthprice = isset($tab_atts['monthprice']) ? $tab_atts['monthprice'] : '';
			$yearprice = isset($tab_atts['yearprice']) ? $tab_atts['yearprice'] : '';
		
			$out_cont .= '
				<div  class="col-md-4">			
					<ul class="cd-pricing-wrapper reverse-animation  '.esc_attr($class).'">';
			if(in_array($typetable, array('', 'monthly'))){			
				$out_cont .= '
						<li data-type="monthly" class="is-ended '.esc_attr($class_month).' panel  panel-default panel-price text-center">
						
							<div class="pack-box '.esc_attr($class).'">
								<div class="p-box-icon">
									<span class="'.esc_attr($icon).'"></span> 
								</div>
								<div class="p-box-content">
									'.$flag.'
									<h3>'.wp_kses_post($tab_atts['title']).'</h3>
									<div class="pack-desc">Starting From</div>
									<div class="pack-price-box">
										<span class="p-price">'.wp_kses_post($currency).wp_kses_post($monthprice).'</span>
										<span class="p-period">/ '.wp_kses_post($monthshort).'</span>
									</div>
									'.do_shortcode($tab."[/section_pricecol]").'
								</div>
								<div class="tooth-block"></div>
								<div class="p-box-footer">
									<a href="'.esc_url($href['url']).'" class="btn">'.wp_kses_post($tab_atts['btntext']).'</a>
								</div>
							</div>
						</li>';
			}
			if(in_array($typetable, array('', 'yearly'))){	
				$out_cont .= '
						<li data-type="yearly" class="is-ended li-last '.esc_attr($class_year).' panel  panel-default panel-price">
							<div class="pack-box '.esc_attr($class).'">
								<div class="p-box-icon">
									<span class="'.esc_attr($icon).'"></span> 
								</div>
								<div class="p-box-content">
									'.$flag.'
									<h3>'.wp_kses_post($tab_atts['title']).'</h3>
									<div class="pack-desc">Starting From</div>
									<div class="pack-price-box">
										<span class="p-price">'.wp_kses_post($currency).wp_kses_post($yearprice).'</span>
										<span class="p-period">/ '.wp_kses_post($yearshort).'</span>
									</div>
									'.do_shortcode($tab."[/section_pricecol]").'
								</div>
								<div class="tooth-block"></div>
								<div class="p-box-footer">
									<a href="'.esc_url($href['url']).'" class="btn">'.wp_kses_post($tab_atts['btntext']).'</a>
								</div>
							</div>								
						</li>';
			}
				$out_cont .= '		  
						</ul>
						<!-- .cd-pricing-wrapper --> 
					</div>
				';			
		}	
											   
	}		        
}

$out = ' 
		<div class="container">			
			<div class="cd-pricing-container cd-full-width cd-secondary-theme">
';
if($typetable == ''){
	$out .= '
				<div class="cd-pricing-switcher pricing-switcher">			
					<div data-toggle="buttons" class="btn-group">
						<label class="btn btn-info"><input type="radio" checked="" id="monthly-1" value="monthly" name="duration-1"> '.wp_kses_post($monthtext).'</label>
						<label class="btn btn-info active"><input type="radio" id="yearly-1" value="yearly" name="duration-1"> '.wp_kses_post($yeartext).'</label>
					</div>			  
				</div>
				<!-- .cd-pricing-switcher -->			
	';
}
$out .= '
				<div class="price">
					<div class="cd-pricing-list cd-bounce-invert">
						<div class="row no-gutter">
							'. $out_cont .'
						</div>
					</div>
					<!-- .cd-pricing-list --> 
				</div>
			</div>
		</div>
';
 
echo $out;