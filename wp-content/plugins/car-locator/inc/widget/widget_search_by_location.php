<?php
// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

/**
 * My Profile Widget
 *
 * @since 0.1
 */
class Car_Locator_Templines_Widget_By_Location extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {



        parent::__construct( 'car_locator_templines_widget_by_location', __( 'Car Locator: By Location', 'car-locator' ), array( 'description' => __( 'Filter autos by make.', 'car-locator' ), ) );
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		?>
		<section class="widget block_content widget_mod-a pixad-filter"  data-field="make">
		<?php if( empty( $args['before_title'] ) ): ?>
			<h3 class="widget-title">
			<span>
		<?php endif; ?>

		<?php
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'].apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		?>

		<?php if( empty( $args['before_title'] ) ): ?>
			</span>
			</h3>
			<div class="decor-1"></div>
		<?php endif; ?>
            <?php

            ?>

            <div class="slider-price" id="slider-radius"></div>
            <span class="slider-price__wrap-input">
                <input type="hidden" name="pixad-car-locator-radius" class="car-locator-radius" id="car-locator-radius" data-field="radius" value="">
                <input type="text" name="pixad-car-locator-city" class="pixad--city" id="pixad--city" value="">

                <input type="hidden" id="pix-min-radius" value="<?php echo $instance['min_radius'];?>">
                <input type="hidden" id="pix-max-radius" value="<?php echo $instance['max_radius'];?>">

                <input type="hidden" name="pixad-car-locator-lat" class="car-locator-radius" id="pixad-car-locator-lat" value="49.404762">
                <input type="hidden" name="pixad-car-locator-long" class="car-locator-radius" id="pixad-car-locator-long" value="75.499570">
            </span>



		</section>
		<?php

	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : __( 'Radius', 'pixad' );
		$min_radius = isset( $instance['min_radius'] ) ? $instance['min_radius'] : '0';
		$max_radius = isset( $instance['max_radius'] ) ? $instance['max_radius'] : '1000';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'pixad' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>

        <p>
            <label for="<?php echo $this->get_field_id( 'min_radius' ); ?>"><?php _e( 'Min Radius (km):', 'pixad' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'min_radius' ); ?>" name="<?php echo $this->get_field_name( 'min_radius' ); ?>" type="text" value="<?php echo esc_attr( $min_radius ); ?>">
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'max_radius' ); ?>"><?php _e( 'Max Radius (km):', 'pixad' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'max_radius' ); ?>" name="<?php echo $this->get_field_name( 'max_radius' ); ?>" type="text" value="<?php echo esc_attr( $max_radius ); ?>">
        </p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['min_radius'] = ( ! empty( $new_instance['min_radius'] ) ) ? strip_tags( $new_instance['min_radius'] ) : '0';
		$instance['max_radius'] = ( ! empty( $new_instance['max_radius'] ) ) ? strip_tags( $new_instance['max_radius'] ) : '500';

		return $instance;
	}
}





/**
 * Register Widget
 *
 * @since 1.0
 */
function register_car_locator_filter_widgets() {
    register_widget( 'Car_Locator_Templines_Widget_By_Location' );
}
add_action( 'widgets_init', 'register_car_locator_filter_widgets' );
?>