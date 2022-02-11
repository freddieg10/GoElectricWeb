<?php

class AutozoneCommentWalker extends Walker_Comment{

    protected function comment( $comment, $depth, $args ) {
        if ( 'div' == $args['style'] ) {
            $tag = 'div';
            $add_below = 'comment';
        } else {
            $tag = 'li';
            $add_below = 'div-comment';
        }
        ?>
        <<?php echo wp_kses_post($tag); ?> <?php comment_class( $this->has_children ? 'parent' : '' ); ?> id="comment-<?php comment_ID(); ?>">
        <?php if ( 'div' != $args['style'] ) : ?>
            <div id="div-comment-<?php comment_ID(); ?>" class="comment-body">
        <?php endif; ?>
        <div class="comment-author vcard">
            <?php if ( 0 != $args['avatar_size'] ) echo get_avatar( $comment, $args['avatar_size'] ); ?>

        </div>
        <?php if ( '0' == $comment->comment_approved ) : ?>
            <em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'autozone' ) ?></em>
            <br />
        <?php endif; ?>
        <div class="comment-info-content">
            <?php printf( wp_kses_post(__( '<cite class="fn">%s</cite> <span class="says">says:</span>', 'autozone' )), get_comment_author_link() ); ?>
            <div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID, $args ) ); ?>">
                    <?php
                    /* translators: 1: date, 2: time */
                    printf( wp_kses_post(__( '%1$s at %2$s', 'autozone' )), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( esc_html__( '(Edit)', 'autozone' ), '&nbsp;&nbsp;', '' );
                ?>
            </div>

            <?php comment_text( get_comment_id(), array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>

            <?php
            comment_reply_link( array_merge( $args, array(
                'add_below' => $add_below,
                'depth'     => $depth,
                'max_depth' => $args['max_depth'],
                'reply_text'=> '<span class="btn-inner">'.esc_html__( 'Reply', 'autozone' ).'</span>',
                'before'    => '<div class="comment-reply">',
                'after'     => '</div>'
            ) ) );
            ?>
        </div>


        <?php if ( 'div' != $args['style'] ) : ?>
            </div>
        <?php endif; ?>
        <?php
    }

}