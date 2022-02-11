<?php
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Customposts
 */
 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
	

$post_id = esc_attr($posts);
$args = array(
			'post_status' => 'publish',
			'p' => $post_id,
		);
$wp_query = new WP_Query( $args );

	while ($wp_query->have_posts()) : 							
		$wp_query->the_post();



$out = '<div class="custom-post-item custom-post-'.esc_attr($style).' '.esc_attr($class_name).'">
<div class="cpi-image-wrapper" ><a href="'.get_the_permalink().'">'. get_the_post_thumbnail( get_the_ID(), 'autozone-services-thumb', array('srcset' => '') ) .'</a></div> ';

$out .= '<h4><a href="'.get_the_permalink().'">'. get_the_title() .'</a></h4>';

$out .= '	<ul class="cpi-date-wrapper"> ';
				if(autozone_get_option('blog_settings_date',1)){
					$out .= '<li><i class="fa fa-calendar"></i>'. get_the_date(null, $wp_query->ID) .'</li>';
				}
				
				// if( 'open' == $wp_query->comment_status && autozone_get_option('blog_settings_comments',1)) {
				 	$out .= '<li><i class="fa fa-commenting-o"></i>'. get_comments_number_text(0, 1 ) .'</li> ';
			//	 }
			
					 
	$out .= '</ul>';



if ( !get_the_excerpt() == '') {
	$out .= '<div class="cpi-excerpt">'.get_the_excerpt() .'</div>';
}
$out .= '<a class="cpi-link-more" href="'.get_the_permalink().'">'.esc_html__( 'Read More', 'autozone' ).' <span>>></span></a>';


$out .= '</div>';



	endwhile;






echo $out;