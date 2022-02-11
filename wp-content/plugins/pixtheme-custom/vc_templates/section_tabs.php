<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Tabs
 */
 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );



$out = $css_animation != '' ? '<div class="animated" data-animation="' . esc_attr($css_animation) . '">' : '<div>';

preg_match_all( '/section_tab([^\]]+)/i', $content, $matches, PREG_OFFSET_CAPTURE );
$tab_titles = array();
/**
 * vc_tabs
 *
 */
if ( isset( $matches[1] ) ) {
	$tab_titles = $matches[1];
}

$tabs_nav = '';
$tabs_nav .= '<ul class="nav nav-tabs vertical-tabs">';
$i=0;
foreach ( $tab_titles as $tab ) {
	$i++;
	$tab_atts = shortcode_parse_atts( $tab[0] );
	if ( isset( $tab_atts['title'] ) ) {
		$class = $i==1 ? 'active' : '';
		$type = isset($tab_atts["type"]) ? $tab_atts["type"] : 'pixflaticon';
		$icon = isset( $tab_atts["icon_" . $type] ) ? $tab_atts["icon_" . $type] : '';
		$tabs_nav .= '
		<li class="'.esc_attr($class).'">
			<a data-toggle="tab" href="#tab-' . ( isset( $tab_atts['tab_id'] ) ? $tab_atts['tab_id'] : sanitize_title( $tab_atts['title'] ) ) . '">
				<i class="vertical-tab-icon '.esc_attr($icon).'"></i>
				<span>' . $tab_atts['title'] . '</span>
			</a>
		</li>';
	}
}
$tabs_nav .= '</ul>' . "\n";

$section_cont = explode( '[/section_tab]', $content );
array_pop($section_cont);
if( is_array( $section_cont ) && !empty( $section_cont ) ){
	$i=0;
	$out_cont = '';
	foreach( $section_cont as $option ){
		$i++;		
		$out_cont .= $i==1 ? str_replace('tab-pane fade', 'tab-pane fade in active', do_shortcode($option.'[/section_tab]')) : do_shortcode($option.'[/section_tab]');			   
	}		         
}

$out .= '
		<div class="row-1">
			<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
				' . $tabs_nav . '
			</div>
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
				<div class="tab-content h1-tab-content">
					'. $out_cont .'
				</div>
			</div>
		</div>
	';

$out .= '</div>'; 
echo $out;