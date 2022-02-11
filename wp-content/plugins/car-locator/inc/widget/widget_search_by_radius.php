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

        parent::__construct( 'pixba_templines_widget_by_location', __( 'Car Locator: By Location', 'pixba' ), array( 'description' => __( 'Filter autos by make.', 'pixba' ), ) );



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

        <form method="post">
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

            <?php $car_locator = new Car_Locator_Templines(); ?>

            <input type="text" name="car-locator-city" class="pixad--city" id="pixad--city" data-field="city" value="">
            <input type="hidden" name="pixad-car-locator-lat" class="car-locator-radius" id="pixad-car-locator-lat" data-field="lat" value="<?php echo $car_locator::get_setting('map_lat', 1);?>">
            <input type="hidden" name="pixad-car-locator-long" class="car-locator-radius" id="pixad-car-locator-long" data-field="long" value="<?php echo $car_locator::get_setting('map_lng', 1);?>">
        </section>
        <section class="widget block_content widget_mod-a pixad-filter pixba-radius-search"  data-field="price">

            <div class="slider-price" id="slider-radius"></div>
            <span class="slider-price__wrap-input">
                <?php

                $map_autos                       = $car_locator::get_map_booking_address();
                $map_data                        = [];
                $map_data['map_id']              = 'clt-maps';
                $map_data['google_maps_api_key'] = $car_locator::get_setting('google_maps_api_key', '');
                $map_data['map_zoom']            = $car_locator::get_setting('map_zoom', 1);
                $map_data['map_lat']             = $car_locator::get_setting('map_lat', 1);
                $map_data['map_lng']             = $car_locator::get_setting('map_lng', 1);
                $map_data['icon_url']            = $car_locator::get_setting('icon_url', $car_locator::$settings['default']['icon_url']);
                $map_data['icon_width']          = $car_locator::get_setting('icon_width', 27);
                $map_data['icon_height']         = $car_locator::get_setting('icon_height', 43);
                $map_data['claster_url']         = $car_locator::get_setting('claster_url', $car_locator::$settings['default']['claster_url']);
                 //$map_data['claster_url']         = $car_locator::get_setting('claster_url', $car_locator::$settings['default']['claster_url']);
                $map_data['claster_width']       = $car_locator::get_setting('claster_width', 53);
                $map_data['claster_height']      = $car_locator::get_setting('claster_height', 53);
                $map_data['claster_text_size']   = $car_locator::get_setting('claster_text_size', 14);
                $map_data['info_block_summary']  = $car_locator::$strings['info_block_summary'];
                $map_data['info_block_readmore'] = $car_locator::$strings['info_block_readmore'];
                $map_data['map_styles']          = json_decode(wp_unslash($car_locator::get_setting('map_styles')));
                $map_data['photos']              = json_encode($map_autos);
                ?>



                <script>
                    jQuery(document).ready(function(){

                        jQuery('#car-locator-radius').change(function () {
                            var map_zoom;
                            var radius = jQuery('#car-locator-radius').val();
                            if(radius <= 100){
                                map_zoom = 13;
                            } else if(radius <= 200){
                                map_zoom = 11;
                            }else if(radius <= 300){
                                map_zoom = 8;
                            }else if(radius <= 500){
                                map_zoom = 7;
                            }else if(radius <= 700){
                                map_zoom = 7;
                            }else if(radius <= 800){
                                map_zoom = 5;
                            }else if(radius <= 900){
                                map_zoom = 5;
                            }else if(radius <= 1000){
                                map_zoom = 4;
                            }
                            var data =
                                {
                                    "map_id": "clt-maps",
                                    "google_maps_api_key":"<?php echo $car_locator::get_setting('google_maps_api_key', '');?>",
                                    "map_zoom": map_zoom,
                                    "map_lat": jQuery('#pixad-car-locator-lat').val(),
                                    "map_lng": jQuery('#pixad-car-locator-long').val(),
                                    "icon_url":"<?php echo $car_locator::get_setting('icon_url', $car_locator::$settings['default']['icon_url']);?>",
                                    "icon_width":<?php echo $car_locator::get_setting('icon_width', 27);?>,
                                    "icon_height":<?php echo $car_locator::get_setting('icon_height', 43);?>,
                                    "claster_width":<?php echo $car_locator::get_setting('claster_width', 53);?>,
                                    "claster_height":<?php echo $car_locator::get_setting('claster_height', 53);?>,
                                    "claster_text_size":<?php echo $car_locator::get_setting('claster_text_size', 14);?>,
                                    "info_block_summary":"<?php echo $car_locator::$strings['info_block_summary'];?>",
                                    "info_block_readmore":"<?php echo $car_locator::$strings['info_block_readmore'];?>",
                                    "map_styles":<?php echo wp_unslash($car_locator::get_setting('map_styles'));?>,
                                    "photos": <?php echo $map_data['photos'];?>
                                };

                            mapCarsLocator.init(data);
                        });

                        //if( !jQuery('.pixad--city').val() ) {
                         //   jQuery('#radius-reset-show-hide').hide();
                       // }
                       // jQuery('.pixad--city').keyup(function() {
                       //     jQuery('#radius-reset-show-hide').show();
                       // });
                        
                    })
                </script>

                <input type="hidden" name="pixad-car-locator-radius" class="car-locator-radius" id="car-locator-radius" data-field="radius" value="">
                <input type="hidden" id="pix-min-radius" value="<?php echo $instance['min_radius'];?>">
                <input type="hidden" id="pix-max-radius" value="<?php echo $instance['max_radius'];?>">
                <span><?php echo esc_attr('Radius');?></span>
                <input type="number" id="pixba_radius_max" class="pixba-radius-widget" readonly value="<?php echo $instance['max_radius'];?>" >
                <?php
                $path = '';
                if(substr_count($_SERVER['REQUEST_URI'], '/page/') > 0){
                    $path = preg_split('/\/page\//', $_SERVER['REQUEST_URI']);
                    $path = $path[0].'/';
                }else{
                    $path = preg_split('/\?/', $_SERVER['REQUEST_URI']);
                    $path = $path[0];
                }
                ?>
                <div class="btn-filter wrap__btn-skew-r js-filter" id="radius-reset-show-hide">
				    <button data-href="<?php echo esc_url($_SERVER['SERVER_NAME'] . $path)?>" id="pixad-reset-button" class="btn-skew-r btn-effect"><span class="btn-skew-r__inner"><?php echo $instance['title_button'];?></span></button>

			    </div>



            </span>


        </section>
        </form>

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
        $title_button = isset( $instance['title_button'] ) ? $instance['title_button'] : __( 'Reset Filter', 'pixad' );
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
        <p>
            <label for="<?php echo $this->get_field_id( 'title_button' ); ?>"><?php _e( 'Reset Button Text:', 'pixad' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title_button' ); ?>" name="<?php echo $this->get_field_name( 'title_button' ); ?>" type="text" value="<?php echo esc_attr( $title_button ); ?>">
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
        $instance['title_button'] = ( ! empty( $new_instance['title_button'] ) ) ? strip_tags( $new_instance['title_button'] ) : '';
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