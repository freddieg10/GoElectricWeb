<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $cats
 * @var $title
 * @var $btn_text
 * @var $link
 * @var $skin
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Reviews
 */
global $post; 
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$href = vc_build_link( $link );
$link = isset($href['url']) ? $href['url'] : ''; 
$date = '';

$autozone_options = get_option('autozone_general_settings');
$skin = $skin == '' ? 'pix-lastnews-light' : $skin;

if( $cats == '' ):
	$out = '<p>'.esc_html__('No categories selected. To fix this, please login to your WP Admin area and set the categories you want to show by editing this shortcode and setting one or more categories in the multi checkbox field "Categories".', 'autozone');
else: 

$out = $css_animation != '' ? '<div class="animated '.esc_attr($skin).'" data-animation="' . esc_attr($css_animation) . '">' : '<div class="'.esc_attr($skin).'">';	

$out .= $btn_text != '' ? '<div class="clearfix"><a class="btn btn-success btn-effect pull-right" href="'.esc_url($link).'"><span class="btn-inner">'.wp_kses_post($btn_text).'</span></a></div>' : '';

$out .= '

<div class="heading-news">
                <h2 class="ui-title-block">'.wp_kses_post($title).'</h2>
                <div class="ui-subtitle-block_mod-b">'.wp_kses_post(do_shortcode($content)).'</div>
              </div>
              
              
	
';


$cat_to_query = get_objects_in_term( explode( ",", $cats ), 'category');

if(!empty($cat_to_query)){
   $args = array(
			'ignore_sticky_posts' => true,
			'showposts' => 3,
			'post__in' => $cat_to_query,
		);

} else {
    $args = array(
			'ignore_sticky_posts' => true,
			'showposts' => 3,
			'post__in' => 999999999999999999999999999999999,
		);

}




$wp_query = new WP_Query( $args );
			 					
	if ($wp_query->have_posts()):
		$i=0;
		$cnt = $wp_query->post_count;	
 		
		while ($wp_query->have_posts()) : 							
			$wp_query->the_post();
			$custom = get_post_custom($post->ID);
			$i++;
			
			if(autozone_get_option('autozone_blog_show_date', '1')){
				$date = '	<div class="entry-date">
								<span class="entry-date__inner">
									<span class="entry-date__number">'.wp_kses_post(get_the_time('j')).'</span>
									<br>'.wp_kses_post(get_the_time('M')).'
								</span>
							</div>';
			}

			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'autozone-post-thumb');
			$thumb_large = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
			$thumbnail = isset($thumb[0]) && $thumb[0] != '' ? $thumb[0] : get_template_directory_uri().'/images/noimage.jpg';
			$thumbnail_large = isset($thumb_large[0]) && $thumb_large[0] != '' ? $thumb_large[0] : get_template_directory_uri().'/images/noimage.jpg';

			$out .= '

				<article class="post post_mod-a clearfix">
					<div class="entry-media">
						<a href="'.esc_url(get_the_permalink()).'" >
							<img class="img-responsive" src="'.esc_url($thumbnail).'" width="470" height="280" alt="'.esc_attr(get_the_title()).'">
							<div class="post-hover helper"><i class="icon icon-magnifier-add"></i></div>
						</a>
					</div>
					<div class="entry-main entry-main_mod-a">
						<div class="entry-main__inner entry-main__inner_mod-a">
							<h3 class="entry-title"><a href="'.esc_url(get_the_permalink()).'">'.wp_kses_post(get_the_title()).'</a></h3>
							<div class="entry-meta">
								<span class="entry-meta__item">'.esc_html__('By:: ', 'autozone').get_the_author_link().'</span>';
					if( 'open' == $post->comment_status && autozone_get_option('blog_settings_comments', '1')) {
			            $out .= '	<span class="entry-meta__item">'.esc_html__( 'COMMENTS :: ', 'autozone' ).'<a class="entry-meta__link" href="'.esc_url(get_comments_link( $post->ID )).'">'.wp_kses_post(get_comments_number()).'</a></span>';
			        }
					$out .= '
							</div>
						</div>
						<div class="decor-1"></div>
						'.$date.'
						<div class="entry-content">
							'.get_the_excerpt().'
						</div>
					</div>
				</article>

			';

		endwhile;

	endif;
	 
$out .= '            
        <!--end-->
	</div>
	';
	endif;	
echo $out;