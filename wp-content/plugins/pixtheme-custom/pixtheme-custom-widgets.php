<?php

// prevent direct file access
if( ! defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit;
}


class Pixtheme_StaticBlock_Widget extends WP_Widget {


    function __construct() {

        parent::__construct(
            'Pixtheme_StaticBlock_Widget',
            __( 'Pixtheme Static Block Widget', 'pixtheme' ),
            array(
                'description' => __( 'Displays your static block in widget', 'pixtheme' ),
            )
        );
    }

    public function widget( $args, $instance ) {

        $title = isset( $instance['title'] ) ? $instance['title'] : '';
        $blockId = isset( $instance['block_id'] ) ? $instance['block_id'] : 0;
        $title = apply_filters( 'widget_title', $title );

        echo $args['before_widget'];

        /*if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }*/

        $html = '<div class="product-sidebar-block sidebar-product">';

        $html .= pixtheme_get_staticblock_content($blockId);

        $html .= '</div>';

        echo $html;

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = isset( $instance['title'] ) ? $instance['title'] : 'Static Block';
        $blockId = isset( $instance['block_id'] ) ? $instance['block_id'] : '';
        $blocks = $this->getBlocksAll();


        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'pixtheme' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'block_id' ); ?>"><?php _e( 'Static Block:', 'pixtheme' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'block_id' ); ?>" name="<?php echo $this->get_field_name( 'block_id' ); ?>">
                <?php foreach ($blocks as $block):?>
                    <option <?php if ($blockId == $block->ID):?>selected="selected"<?php endif;?> value=<?php echo $block->ID?>""><?php echo $block->post_title?></option>
                <?php endforeach?>
            </select>
        </p>



        <?php
    }


    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['block_id'] = ( ! empty( $new_instance['block_id'] ) ) ? sanitize_text_field( $new_instance['block_id'] ) : '';
        return $instance;
    }

    private function getBlocksAll(){
        $args = array(
            'post_type'        => 'staticblocks',
            'post_status'      => 'publish',
        );

        $blocks = get_posts($args);

        return $blocks;
    }

}
