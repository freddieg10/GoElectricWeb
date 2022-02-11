<?php
/**
 * Shortcode attributes
 * @var $atts
 * Shortcode class
 * @var $this WPBakeryShortCode_сustomer_favourites
 */
 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$instance=['number'=>6,]; 
$args=['widget_id'=>'сustomer_favourites',];
?>
<div class="widget-wrapper <?php echo esc_attr($atts['class_name']); ?>">	
<?php the_widget( 'WC_Widget_Top_Rated_Products',$instance,$args); 	?>
</div>

