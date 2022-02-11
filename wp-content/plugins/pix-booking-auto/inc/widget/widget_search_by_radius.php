<?php
// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

/**
 * My Profile Widget
 *
 * @since 0.1
 */
class Pixba_Templines_Widget_By_Location extends WP_Widget {
    /**
     * Register widget with WordPress.
     */
    function __construct() {

        parent::__construct( 'pixba_templines_widget_by_location', __( 'Booking Auto: By Location', 'pixba' ), array( 'description' => __( 'Filter autos by make.', 'pixba' ), ) );



        wp_enqueue_script('tmpray_geocomplete', plugin_dir_url( __FILE__ ) . 'js/jquery.geocomplete.js', array('jquery'), null, false);


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


        <section class="widget block_content widget_mod-a pixad-filter pixba-radius-search"  data-field="price">


            <?php if( empty( $args['before_title'] ) ): ?>
            <h3 class="widget-title">
                <span>
            <?php endif; ?>

            <?php
            if ( ! empty( $instance['title_radius'] ) ) {
                echo $args['before_title'].apply_filters( 'widget_title', $instance['title_radius'] ). $args['after_title'];
            }
            ?>

            <?php if( empty( $args['before_title'] ) ): ?>
                </span>
            </h3>
            <div class="decor-1"></div>
        <?php endif; ?>


            <input type="text" name="car-locator-city" class="pixad--city" id="pixad--city" data-field="city" value="" autocomplete="off">
            <input type="hidden" name="pixad-car-locator-lat" class="car-locator-radius" id="pixad-car-locator-lat" data-field="lat" value="49.404762">
            <input type="hidden" name="pixad-car-locator-long" class="car-locator-radius" id="pixad-car-locator-long" data-field="long" value="75.499570">
        </section>
        <section class="widget block_content widget_mod-a pixad-filter pixba-radius-search"  data-field="price">




            <div class="slider-price" id="slider-radius"></div>
            <span class="slider-price__wrap-input">

                <input type="hidden" name="pixad-car-locator-radius" class="car-locator-radius" id="car-locator-radius" data-field="radius" value="">
                <input type="hidden" id="pix-min-radius" value="<?php echo $instance['min_radius'];?>">
                <input type="hidden" id="pix-max-radius" value="<?php echo $instance['max_radius'];?>">
                <span><?php echo esc_attr('Radius');?></span>
                <input type="number" id="pixba_radius_max" class="pixba-radius-widget"  value="<?php echo $instance['max_radius'];?>" >

            </span>
            <script>
                jQuery(document).ready(function(){
                    jQuery('.pixad--city').geocomplete({
                        location: false
                    }).bind('geocode:result',function (e, result) {
                        jQuery('#pixad-car-locator-lat').val(result.geometry.viewport.Ya.j);
                        jQuery('#pixad-car-locator-long').val(result.geometry.viewport.Ua.j);
                    });
                })
            </script>


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
        $title = isset( $instance['title_radius'] ) ? $instance['title_radius'] : __( 'Find By Radius', 'pixad' );
        $min_radius = isset( $instance['min_radius'] ) ? $instance['min_radius'] : '0';
        $max_radius = isset( $instance['max_radius'] ) ? $instance['max_radius'] : '1000';

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title_radius' ); ?>"><?php _e( 'Title for Radius:', 'pixad' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title_radius' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
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
        $instance['title_radius'] = ( ! empty( $new_instance['title_radius'] ) ) ? strip_tags( $new_instance['title_radius'] ) : '';
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
function register_pixba_filter_widgets() {
    register_widget( 'Pixba_Templines_Widget_By_Location' );
}
add_action( 'widgets_init', 'register_pixba_filter_widgets' );
?>