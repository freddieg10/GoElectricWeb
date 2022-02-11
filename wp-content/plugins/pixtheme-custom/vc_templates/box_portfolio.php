<?php
global $post;
$out = '';

extract(shortcode_atts(array(
    'port'=>'',
    'buttext'=>'',
    'css_animation' => '',
), $atts));

if( $port == '' ):
    $out .= '<p>'.esc_html__('No portfolio card selected. To fix this, please login to your WP Admin area and set the portfolio card you want to show by editing this shortcode and setting one portfolio card in the dropdown "Portfolio Card".', 'autozone');
else: 

$out = $css_animation != '' ? '<div class="animated" data-animation="' . esc_attr($css_animation) . '">' : '<div>';
$out .= '

    <div class="slider_team slider_team_horiz border_btm">
        <div class="slide slide_horiz">
            <div class="row">

    ';

    $args = array(
                'post_type' => 'portfolio',
                'p' => $port,
            );

    $wp_query = new WP_Query( $args );

    if ($wp_query->have_posts()):
        while ($wp_query->have_posts()) :
                $wp_query->the_post();
                //$cnt++;
                //$custom = get_post_custom($post->ID);
                //$garden_pix_format = $custom['post_types_select'][0];

                $cats = wp_get_object_terms($post->ID, 'portfolio_category');

                if ($cats){
                    $cat_slugs = '';
                    foreach( $cats as $cat ){
                        $cat_slugs .= $cat->slug . " ";
                    }
                }

                $position = $phone = $email = $facebook = $twitter = $googleplus = $linkedin = '';

                if ( class_exists( 'RW_Meta_Box' ) ) {
                    $position   = rwmb_meta( 'portfolio_position' ) != '' ? '<span class="category">' . rwmb_meta( 'portfolio_position' ) . '</span>' : '';
                    $phone      = rwmb_meta( 'portfolio_phone' ) != '' ? '
                    <div class="slide__contacts">
                    <i class="icon icon-call-in"></i>
                    <span class="helper"><a href="tel:' . esc_attr( rwmb_meta( 'portfolio_phone' ) ) . '">' . rwmb_meta( 'portfolio_phone' ) . '</a></span>
                </div>' : '';
                    $email      = rwmb_meta( 'portfolio_email' ) != '' ? '
                <div class="slide__contacts">
                    <i class="icon icon-envelope-open"></i>
                    <span class="helper"><a href="mailto:' . esc_attr( rwmb_meta( 'portfolio_email' ) ) . '">' . rwmb_meta( 'portfolio_email' ) . '</a></span>
                </div>' : '';
                    $facebook   = rwmb_meta( 'portfolio_facebook' ) != '' ? '<li><a target="_blank" href="' . esc_url( rwmb_meta( 'portfolio_facebook' ) ) . '"><i class="social_icons fa fa-facebook-square"></i></a></li>' . "\n" : '';
                    $twitter    = rwmb_meta( 'portfolio_twitter' ) != '' ? '<li><a target="_blank" href="' . esc_url( rwmb_meta( 'portfolio_twitter' ) ) . '"><i class="social_icons fa fa-twitter-square"></i></a></li>' . "\n" : '';
                    $googleplus = rwmb_meta( 'portfolio_googleplus' ) != '' ? '<li><a target="_blank" href="' . esc_url( rwmb_meta( 'portfolio_googleplus' ) ) . '"><i class="social_icons fa fa-google-plus-square"></i></a></li>' . "\n" : '';
                    $linkedin   = rwmb_meta( 'portfolio_linkedin' ) != '' ? '<li><a target="_blank" href="' . esc_url( rwmb_meta( 'portfolio_linkedin' ) ) . '"><i class="social_icons fa fa-linkedin-square"></i></a></li>' . "\n" : '';
                }
                $thumbnail = get_the_post_thumbnail($post->ID, 'portfolio-thumb');

$out .= '
                <div class="col-md-6 col-sm-5">
                    '.$thumbnail;
                if($facebook || $twitter || $googleplus || $linkedin){
$out .= '
                    <ul class="social-links social-links_right">
                        '.$facebook.$twitter.$googleplus.$linkedin.'
                    </ul>';
                }
$out .= '
                </div>
                <div class="col-md-6 col-sm-7 text-left">
                    <span class="name">'.wp_kses_post(get_the_title()).'</span>
                    '.$position.'
                    <div class="slide__info ui-text">'.wp_kses_post(get_the_excerpt()).'</div>
                    '.$phone.'
                    '.$email.'
                    <a class="btn btn_small" href="'.esc_url(get_permalink(get_the_ID())).'">'.$buttext.'</a>
                </div>
                ';

         endwhile;
    endif;

$out .= '				
            </div>
        </div>
    </div>
    ';
$out .= '</div>';
endif;	
echo $out;