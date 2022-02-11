<?php

if ( post_password_required() ) {
    return;
}

?>
<?php if ( have_comments() ) : ?>
    <ol class="comment-list rtd">
        <?php
        wp_list_comments( array(
            'style'       => 'ol',
            'short_ping'  => true,
            'avatar_size' => 56,
            'walker'      => new AutozoneCommentWalker()
        ) );
        ?>
    </ol>
    
    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
        <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
            <h1 class="screen-reader-text"><?php esc_attr_e( 'Comment navigation', 'autozone' ); ?></h1>
            <div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'autozone' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'autozone' ) ); ?></div>
        </nav><!-- #comment-nav-below -->
    <?php endif; // Check for comment navigation. ?>
    
<?php endif;?>

<?php
// If comments are closed and there are comments, let's leave a little note, shall we?
if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
    ?>
    <p class="no-comments"><?php esc_attr_e( 'Comments are closed.', 'autozone' ); ?></p>
<?php endif;?>


<?php
    global $post;
    $commenter = wp_get_current_commenter();
    $req      = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $html_req = ( $req ? " required='required'" : '' );
    $required_text = sprintf( ' ' . wp_kses_post(__('Required fields are marked %s', 'autozone' )), '<span class="required">*</span>' );

    $fields   =  array(
        'author' => '<div class="col-md-6"><p class="comment-form-author">
            <input id="author" name="author" type="text" placeholder="' . esc_html__( 'Name', 'autozone' ) . ( $req ? ' *' : '' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $html_req . ' /></p></div>',
        'email'  => '<div class="col-md-6"><p class="comment-form-email">
            <input id="email" name="email" type="email" placeholder="' . esc_html__( 'Email', 'autozone' ) . ( $req ? ' *' : '' ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' . $aria_req . $html_req  . ' /></p></div>',
    );
    if($post->post_type == 'pixad-autos'){
        $fields = array_merge([       'rating' =>'<div class="comment-form-rating col-md-12">
                    <label for="rating">'.esc_attr__('Your rating', 'autozone').'</label>
                    <select name="rating" id="rating-autos" aria-required="true" required="" style="display: none;">
                        <option value="">Rate…</option>
                        <option value="5">Perfect</option>
                        <option value="4">Good</option>
                        <option value="3">Average</option>
                        <option value="2">Not that bad</option>
                        <option value="1">Very poor</option>
                    </select></div>'], $fields);
    }

    $comments_args = array(
        'must_log_in'          => '<div class="col-md-12"><p class="must-log-in">' . sprintf( wp_kses_post(__( 'You must be <a href="%s">logged in</a> to post a comment.', 'autozone' ) ), wp_login_url( apply_filters( 'the_permalink', get_permalink( get_the_ID() ) ) ) ) . '</p></div>',
        'logged_in_as'         => '<div class="col-md-12"><p class="logged-in-as">' . sprintf( wp_kses_post(__( '<a href="%1$s" aria-label="Logged in as %2$s. Edit your profile.">Logged in as %2$s</a>. <a href="%3$s">Log out?</a>', 'autozone' ) ), get_edit_user_link(), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( get_the_ID() ) ) ) ) . '</p></div>',
        'comment_notes_before' => '<div class="col-md-12"><p class="comment-notes"><span id="email-notes">' . wp_kses_post(__( 'Your email address will not be published.', 'autozone' ) ) . '</span>'. ( $req ? $required_text : '' ) . '</p></div>',
            'class_form' => 'comment-form row',
        'fields' => apply_filters( 'comment_form_default_fields', $fields ),
        'comment_field' => '<div class="col-md-12"><p class="comment-form-comment"><textarea id="comment" name="comment" placeholder="' . esc_html__( 'Comment', 'autozone' ) . '" aria-required="true"></textarea></p></div>',
        'submit_field' => '<div class="col-md-12"><p class="form-submit">%1$s %2$s</p></div>',
    );

    comment_form($comments_args);

?>


