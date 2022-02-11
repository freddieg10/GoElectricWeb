<?php
/*** The template for displaying search results pages. ***/

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
              
                <div class="col-xs-12 col-sm-7 <?php if ($layout == 1):?>col-md-12<?php else:?>col-md-9<?php endif;?> col2-right  ">
                
                   <?php if ( have_posts() ) : ?>
                
					
					<?php
                
               
       							 get_template_part( 'loop', 'autos' );
								echo pixad_wp_pagenavi();
  		
				 
                    ?>
                
                    <?php else : ?>
                        <div id="post-0" class="post no-results not-found">
                            <h1><?php esc_html_e( 'Nothing Found', 'autozone' ); ?></h1>
                            <div class="entry-content">
                                <p><?php esc_html_e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'autozone' ); ?></p>
                             </div><!-- .entry-content -->
                        </div><!-- #post-0 -->
                    <?php endif; ?>
                
                </div>
                
             <?php if($layout > 1) autozone_show_sidebar('right',$custom) ?>
            
            </div>
        </div>
    </section>
    

<?php get_footer(); ?>
			
            
            