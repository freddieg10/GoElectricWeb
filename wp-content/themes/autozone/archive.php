<?php
    $custom = isset ($wp_query) ? get_post_custom($wp_query->get_queried_object_id()) : ''; 
?>

<?php get_header(); ?>
    <section class="page-content" id="pageContent">
        <div class="container">
            <div class="row">
                <?php autozone_show_sidebar('left',$custom) ?>
                <div class="col-xs-12 col-sm-7 col-md-8 col2-right  ">
                    <?php if ( have_posts() ) : ?>

                         <?php
                             if ( have_posts() )
                                the_post();
                             rewind_posts();
                             get_template_part( 'loop', 'archive' );
                         ?>
                    <?php endif ?>
                </div>
                <?php autozone_show_sidebar('right',$custom) ?>
            </div>
        </div>
    </section>
<?php get_footer(); ?>