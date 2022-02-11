<?php
global $post;
$out = $cnt = '';

extract(shortcode_atts(array(
    'title'=>'',
    'count'=>'',
    'cats'=>'',
    'perrow'=>'2',
    'container'=>'',
    'showcont'=>'',
    'skin'=>'',
    'css_animation' => '',
), $atts));

if( $cats == '' ):
    $out .= '<p>'.esc_html__('No categories selected. To fix this, please login to your WP Admin area and set the categories you want to show by editing this shortcode and setting one or more categories in the multi checkbox field "Categories".', 'autozone');
else: 



$out = $css_animation != '' ? '<div class="animated" data-animation="' . esc_attr($css_animation) . '">' : '<div>';
$out .= '	
        <div id="pix-portfolio"  class="portfolio-view "  >



            <div class="container">
                <div class="row">


        <div class="col-md-12">		  
          <div class="text-center filter ">        

                    <ul  id="filter"  class="portfolio-filter non-paginated">
                        <li><a href="#" class="current" data-filter="*">'. esc_html__('All' , 'autozone').'</a></li>';
                            $MyWalker = new PortfolioWalker();
                            $args = array( 'taxonomy' => 'portfolio_category', 'hide_empty' => '1', 'include' => $cats, 'title_li'=> '', 'walker' => $MyWalker, 'show_count' => '0', 'echo' => 0);
                            $categories = wp_list_categories ($args);
$out .= '
                        '.$categories.'
                    </ul>

                </div>

            </div>

            </div>

            </div>



        <div class="'.esc_attr($container).'">
            <div class="isotope-frame portfolio-col-'.esc_attr($perrow).' '.esc_attr($skin).'">
                <div class="isotope-filter isotope" >';

    $portfolio_posts_to_query = get_objects_in_term( explode( ",", $cats ), 'portfolio_category');
    $args = array(
                'post_type' => 'portfolio',
                'orderby' => 'menu_order',
                'post__in' => $portfolio_posts_to_query,
                'order' => 'ASC'
            );
    if( is_numeric($count) )
        $args['showposts'] = $count;
    else
        $args['numberposts'] = -1;

    $wp_query = new WP_Query( $args );

    if ($wp_query->have_posts()):
        while ($wp_query->have_posts()) :
                        $wp_query->the_post();
                        $cnt++;
                        $custom = get_post_custom($post->ID);
                        $garden_pix_format = $custom['post_types_select'][0];

                        $cats = wp_get_object_terms($post->ID, 'portfolio_category');

                        if ($cats){
                            $cat_slugs = '';
                            $cat_href = '';
                            foreach( $cats as $cat ){
                                $cat_slugs .= $cat->slug . " ";
                                $cat_href .= '<a href="'.esc_url(get_term_link( $cat )).'">' . wp_kses_post($cat->name) . "</a>, ";
                            }
                        }

                        $link = '';
                        $thumb_size = get_post_meta( get_the_ID(), 'thumb_size', true );
                        $img_size = $thumb_size != '' ? 'garden_pix-'.$thumb_size : 'garden_pix-portfolio-thumb';
                        $img_size = $perrow == 'default' ? $img_size : 'garden_pix-portfolio-thumb-col2';
                        $thumbnail = get_the_post_thumbnail($post->ID, $img_size, array('class' => 'cover'));

$out .= '

                    <div class="isotope-item '.esc_attr($cat_slugs).' '.esc_attr($img_size).'" >
                        <div class="portfolio-image">


                            '.$thumbnail.'
                            <div class="slide-desc"><table><tr><td>';
switch ($garden_pix_format){

    case 'image':
        $gallery = class_exists( 'RW_Meta_Box' ) ? rwmb_meta('post_image', 'type=image&size=full') : '';
        $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false);
        $link = $full_image[0];
        $out .= '
                        <div class="detail-item">
                        <div class="name"><a href="'.esc_url(get_the_permalink(get_the_ID())).'">'.wp_kses_post(get_the_title()).'</a></div>
                            <div class="icons">
                                <a data-rel="prettyPhoto[pp_gal_'.esc_attr($post->ID).']" href="'.esc_url($link).'" class="zoomPhoto">
                                    <i class="icon-plus"></i>
                                </a>
                                <div style="position:absolute; left:-99999px;">';
                                if( !empty($gallery) )
                                foreach ($gallery as $key => $slide) {
                                    if($key>0)
                                        $out .= '<a href="' . esc_url($slide['url']) . '" data-rel="prettyPhoto[pp_gal_'.esc_attr($post->ID).']" >
                                                    <img src="' . esc_url($slide['url']) . '" width="' . esc_attr($slide['width']) . '" height="' . esc_attr($slide['height']) . '" alt="' .esc_attr($slide['alt']).'" title="' .esc_attr($slide['title']). '"/>
                                                    </a>';
                                }
        $out .= '
                                </div>
                                <a href="'.esc_url(get_permalink(get_the_ID())).'"><i class="icon-info"></i></a>
                            </div>
                        </div>';
        break;


    case 'video':
        $out .= '
                        <div class="detail-item">
                    <div class="name"><a href="'.esc_url(get_the_permalink(get_the_ID())).'">'.wp_kses_post(get_the_title()).'</a></div>
                            <p>'.garden_pix_limit_words(get_the_excerpt(), 20).'</p>';
                            if ( get_post_meta( get_the_ID(), 'post_video_href', true ) !== '' ):
                                    $video_embed_code = get_post_meta( get_the_ID(), 'post_video_href', true );
                                    $video_width = get_post_meta( get_the_ID(), 'post_video_width', true );
                                    $video_height = get_post_meta( get_the_ID(), 'post_video_height', true );

        $out .= '				<a  href="'.esc_url($video_embed_code).'?width='.esc_attr($video_width).'&amp;height='. esc_attr($video_height).'" class="btn btn-primary btn-lg  video-popab"   >
                                    <i class="fa fa-play-circle"></i>
                                </a>';
                            endif;
        $out .= '
                        </div>';
        break;

    default:
        $gallery = class_exists( 'RW_Meta_Box' ) ? rwmb_meta('post_image', 'type=image&size=full') : '';
        $full_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false);
        $link = $full_image[0];
        $out .= '
                        <div class="detail-item">


                        <div class="name"><a href="'.esc_url(get_the_permalink(get_the_ID())).'">'.wp_kses_post(get_the_title()).'</a></div>



                            <div class="icons">
                                <a  href="'.esc_url($link).'" class="zoomPhoto"  data-rel="prettyPhoto[pp_gal_'.esc_attr($post->ID).']"    >
                                    <i class="icon-plus"></i>
                                </a>
                                <div style="position:absolute; left:-99999px;">';
                                foreach ($gallery as $key => $slide) {
                                    if($key>0)
                                        $out .= '<a href="' . esc_url($slide['url']) . '" data-rel="prettyPhoto[pp_gal_'.esc_attr($post->ID).']" >
                                                    <img src="' . esc_url($slide['url']) . '" width="' . esc_attr($slide['width']) . '" height="' . esc_attr($slide['height']) . '" alt="' .esc_attr($slide['alt']).'" title="' .esc_attr($slide['title']). '"/>
                                                    </a>';
                                }
        $out .= '
                                </div>
                                <a href="'.esc_url(get_permalink(get_the_ID())).'"><i class="icon-info"></i></a>
                            </div>
                        </div>';
        break;
}						
$out .= '	
                        </td></tr></table></div>
                    </div>


                </div>';

         endwhile;
    endif;

$out .= '            
                </div>	<!--end-->
            </div> <!--end isotop frame-->
        </div>';

$out .= '
        </div>

    ';
$out .= '</div>';
endif;	
echo $out;