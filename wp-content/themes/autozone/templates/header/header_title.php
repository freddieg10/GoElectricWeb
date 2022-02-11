<?php /* Header Title template */ ?>
	
	
	<h1 class="ui-title-page">
          <?php
                $autozone_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
	        	$autozone_postpage_id = get_option('page_for_posts'); 
				$autozone_frontpage_id = get_option('page_on_front');
				$autozone_page_id = isset ($wp_query) ? $wp_query->get_queried_object_id() : '';
          ?>
          <?php if(is_single() && ! is_attachment()): ?>
          <?php echo wp_kses_post(get_the_title()); ?>
          <?php elseif( class_exists( 'WooCommerce' ) && (is_shop() || is_product_category() || is_product_tag()) ): ?>
          <?php wp_kses_post(woocommerce_page_title()); ?>
          <?php elseif( is_archive() && get_post_type() != 'post'): ?>
          <?php echo wp_kses_post($autozone_term->name); ?>
          <?php elseif( is_archive() ): ?>
          <?php echo wp_kses_post(get_the_title($autozone_postpage_id)); ?>
          <?php elseif( is_search() ): ?>
          <?php echo wp_kses_post(esc_html_e('Search results for: ', 'autozone').get_search_query()); ?>
          <?php elseif( is_page_template( 'blog-template.php' ) ): ?>          
          <?php echo wp_kses_post(get_the_title($autozone_page_id));  ?>
          <?php elseif( $autozone_page_id == $autozone_frontpage_id ): ?>          
          <?php echo wp_kses_post(get_the_title());  ?>
          <?php elseif( is_category() ): ?>
          <?php echo wp_kses_post(single_cat_title()); ?>
          <?php elseif( is_tag() ): ?>
          <?php echo wp_kses_post(single_tag_title()); ?>
          <?php elseif( $autozone_page_id > 0 ): ?>
          <?php echo wp_kses_post(get_the_title($autozone_page_id)); ?>
          <?php else: ?>
          <?php echo wp_kses_post(get_the_title()); ?>
          <?php endif; ?>
    </h1>