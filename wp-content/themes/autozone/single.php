<?php
/**
 * The Template for displaying all single posts.
 */
$custom =  get_post_custom(get_queried_object()->ID);
$layout = isset ($custom['pix_page_layout']) ? $custom['pix_page_layout'][0] : '2';
$sidebar = isset ($custom['pix_selected_sidebar'][0]) ? $custom['pix_selected_sidebar'][0] : 'sidebar-1';

if (!is_active_sidebar($sidebar)) $layout = '1';

$pix_options = get_option('pix_general_settings');
get_header();


?>

<div class="container">
    <div class="row">
        <?php autozone_show_sidebar('left',$custom) ?>
        <div class="<?php if ($layout == 1):?>col-md-12 pix-without-sidebar<?php else:?>col-md-8<?php endif;?>">
            <?php
            // Start the loop.
            while ( have_posts() ) : the_post();

                /*
                 * Include the post format-specific template for the content. If you want to
                 * use this in a child theme, then include a file called called content-___.php
                 * (where ___ is the post format) and that will be used instead.
                 */
                get_template_part( 'templates/post-single/content', get_post_format() );

                // End the loop.
            endwhile;
            ?>
        </div>
        <?php autozone_show_sidebar('right',$custom) ?>
    </div>
</div>

<?php get_footer();?>


