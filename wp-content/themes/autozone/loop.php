<?php
$pix_options = get_option('pix_general_settings');
$post_ID = isset ($wp_query) ? $wp_query->get_queried_object_id() : (get_the_ID()>0 ? get_the_ID() : '');
$custom =  get_post_custom($post_ID);
$layout = isset($custom['_page_layout'][0]) ? $custom['_page_layout'][0] : '1';
$blogType = (int)autozone_get_option('blog_settings_type',1);
?>

<?php if ( ! have_posts() ) : ?>
    <div  class="post error404 not-found">
        <h1 class="entry-title"><?php esc_html_e( 'Not Found', 'autozone' ); ?></h1>
        <div class="entry-content">
            <p><?php esc_html_e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'autozone' ); ?></p>
            <?php get_search_form(); ?>
        </div><!-- .entry-content -->
    </div><!-- #post-0 -->
<?php endif; ?>


<?php while ( have_posts() ) : the_post(); ?>
    <?php
        $no_img_class = !has_post_thumbnail() ? ' entry-media-not-image' : '';
        $autozone_format  = get_post_format();
        $autozone_format = !in_array($autozone_format, array("quote", "gallery", "video")) ? 'standared' : $autozone_format;
    ?>
    <article id="post-<?php esc_attr( the_ID() ); ?>" <?php post_class( 'post_mod-b post_mod-d clearfix blog-item-'.esc_attr($autozone_format.$no_img_class) ); ?>>
        <?php get_template_part( 'templates/post-parts/post-format/blog', $autozone_format); ?>
        <?php get_template_part( 'templates/post-parts/blog-template/blog', 'template'); ?>
    </article>

<?php endwhile;?>

