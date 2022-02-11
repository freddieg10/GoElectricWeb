<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

$custom = isset ($wp_query) ? get_post_custom($wp_query->get_queried_object_id()) : '';
$layout = isset ($custom['pix_page_layout']) ? $custom['pix_page_layout'][0] : '2';
$sidebar = isset ($custom['pix_selected_sidebar'][0]) ? $custom['pix_selected_sidebar'][0] : 'sidebar-1';
if (!is_active_sidebar($sidebar)) $layout = '1';

?>
<?php get_header();?>
<div class="container">
	<div class="row">

		<?php autozone_show_sidebar('left',$custom) ?>
		<div class="col-md-8">
			<main class="main-content">
				<?php
                    $wp_query = new WP_Query();
                    $pp = get_option('posts_per_page');
                    $wp_query->query('posts_per_page='.$pp.'&paged='.$paged);
                    get_template_part( 'loop', 'index' );
                ?>

				<?php
			    if ( $wp_query->max_num_pages > 1 ) :
			        if(function_exists('autozone_pagenavi')) { autozone_pagenavi();}
			    endif;
			    ?>


			</main><!-- end main-content -->
		</div><!-- end col -->

		<?php autozone_show_sidebar('right',$custom) ?>

	</div><!-- end row -->
</div>

<?php get_footer(); ?>
