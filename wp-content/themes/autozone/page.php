<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Template Name: Page
 */


$custom = isset ($wp_query) ? get_post_custom($wp_query->get_queried_object_id()) : '';
$layout = isset ($custom['pix_page_layout']) ? $custom['pix_page_layout'][0] : '2';
$sidebar = isset ($custom['pix_selected_sidebar'][0]) ? $custom['pix_selected_sidebar'][0] : 'sidebar-1';
if (!is_active_sidebar($sidebar)) $layout = '1';

?>

<?php get_header();?>
    <section class="page-content" id="pageContent">
        <div class="container">
            <div class="row">

                <?php if($layout > 1) autozone_show_sidebar('left',$custom) ?>
                <div class="col-xs-12 col-sm-12 <?php if ($layout == 1):?>col-md-12<?php else:?>col-md-8<?php endif;?> col2-right  ">

                    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                        <?php $pix_page = $post; ?>
                      <div class="rtd"> <?php the_content(); ?></div>
                        <?php if('open' == $pix_page->comment_status) : ?>
			              <div class="wrap-comments">
			                <?php comments_template(); ?>
			              </div>
			            <?php endif; ?>
                    <?php endwhile; ?>

                </div>
                <?php if($layout > 1) autozone_show_sidebar('right',$custom) ?>
            </div>
        </div>
    </section>
<?php get_footer(); ?>