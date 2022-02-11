<?php
function autozone_share_buttons($atts, $content=NULL){

    extract(shortcode_atts(array(
        'class' => '',
        'title' => __('Share this','autozone'),
        'post_type'=>'',
    ), $atts));

    global $post;
    if(!isset($post->ID)){
        $post = get_queried_object();
    }

    if (!isset($post->ID)){
        return;
    }

    $permalink = get_permalink($post->ID);
    $image =  wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'preview-thumb' );

    $post_title = rawurlencode(get_the_title($post->ID));

    if( $post_type == '' ){
        $out='
            <div class="social-block ">
                <div class="social-block__inner">
                    <span class="social-block__title">'.esc_html($title).'</span>
                    <ul class="social-block__list list-inline">
                        <li><a class="icon fa fa-facebook" href="http://www.facebook.com/sharer.php?u='.$permalink.'&amp;images='.$image[0].'" title="'.__('Facebook', 'pixtheme').'" target="_blank"></a></li>
                        <li><a class="icon fa fa-twitter" href="https://twitter.com/share?url='.$permalink.'&text='.$post_title.'" title="'.__('Twitter', 'pixtheme').'" target="_blank"></a></li>
                        
                    </ul>
                </div>
            </div>
			';
    } elseif($post_type == 'product') {
        $out='
			<h4 class="font-additional font-weight-bold text-uppercase">'.esc_attr($title).'</h4>
			<ul class="social-list">
				  <li><a class="hover-focus-border hover-focus-bg hvr-rectangle-out before-bg" href="http://www.facebook.com/sharer.php?u='.$permalink.'&amp;images='.$image[0].'" title="'.__('Facebook', 'pixtheme').'" target="_blank"><span class="social_facebook" aria-hidden="true"></span></a></li>
                  <li><a class="hover-focus-border hover-focus-bg hvr-rectangle-out before-bg" href="https://twitter.com/share?url='.$permalink.'&text='.$post_title.'" title="'.__('Twitter', 'pixtheme').'" target="_blank"><span class="social_twitter" aria-hidden="true"></span></a></li>
                  <li><a class="hover-focus-border hover-focus-bg hvr-rectangle-out before-bg" href="http://pinterest.com/pin/create/button/?url='.$permalink.'&amp;media='.$image[0].'&amp;description='.$post_title.'" title="" target="_blank"><span class="social_pinterest" aria-hidden="true"></span></a></li>
			</ul>
			';
    } elseif($post_type == 'post') {
        $out='
			<h4 class="font-additional font-weight-bold text-uppercase">'.esc_attr($title).'</h4>
			<ul class="share-list pull-left">
				  <li><a class="hover-focus-color" href="http://www.facebook.com/sharer.php?u='.$permalink.'&amp;images='.$image[0].'" title="'.__('Facebook', 'pixtheme').'" target="_blank"><span class="social_facebook" aria-hidden="true"></span></a></li>
                  <li><a class="hover-focus-color" href="https://twitter.com/share?url='.$permalink.'&text='.$post_title.'" title="'.__('Twitter', 'pixtheme').'" target="_blank"><span class="social_twitter" aria-hidden="true"></span></a></li>
                  <li><a class="hover-focus-color" href="http://pinterest.com/pin/create/button/?url='.$permalink.'&amp;media='.$image[0].'&amp;description='.$post_title.'" title="" target="_blank"><span class="social_pinterest" aria-hidden="true"></span></a></li>
			</ul>
			';
    }

    return $out;
}

add_shortcode('share', 'autozone_share_buttons');

add_action('admin_head','html_quicktags');
function html_quicktags() {

	$output = "<script type='text/javascript'>\n
	/* <![CDATA[ */ \n";
	wp_print_scripts( 'quicktags' );


	$buttons[] = array(
		'name' => 'title_inner',
		'options' => array(
			'display_name' => 'title_inner',
			'open_tag' => '\n[title_inner center="0"]',
			'close_tag' => '[/title_inner]\n',
			'key' => ''
	));


	$buttons[] = array(
		'name' => 'title_inner_large',
		'options' => array(
			'display_name' => 'title_inner_large',
			'open_tag' => '\n[title_inner_large center="0"]',
			'close_tag' => '[/title_inner_large]\n',
			'key' => ''
	));

    $buttons[] = array(
        'name' => 'decor',
        'options' => array(
            'display_name' => 'decor',
            'open_tag' => '\n[decor center="0"]',
            'close_tag' => '[/decor]\n',
            'key' => ''
    ));

    $buttons[] = array(
        'name' => 'decor_wide',
        'options' => array(
            'display_name' => 'decor_wide',
            'open_tag' => '\n[decor_wide center="0"]',
            'close_tag' => '[/decor_wide]\n',
            'key' => ''
    ));

    $buttons[] = array(
        'name' => 'decor_2',
        'options' => array(
            'display_name' => 'decor_2',
            'open_tag' => '\n[decor_2 center="0"]',
            'close_tag' => '[/decor_2]\n',
            'key' => ''
    ));

    $buttons[] = array(
		'name' => 'footer_name',
		'options' => array(
			'display_name' => 'footer_name',
			'open_tag' => '\n[footer_name]',
			'close_tag' => '[/footer_name]\n',
			'key' => ''
	));

	$buttons[] = array(
		'name' => 'footer_text',
		'options' => array(
			'display_name' => 'footer_text',
			'open_tag' => '\n[footer_text]',
			'close_tag' => '[/footer_text]\n',
			'key' => ''
	));

	$buttons[] = array(
		'name' => 'button_link',
		'options' => array(
			'display_name' => 'button_link',
			'open_tag' => '\n[button_link link="http://templines.com" decor="1"]',
			'close_tag' => '[/button_link]\n',
			'key' => ''
	));

	$buttons[] = array(
		'name' => 'marked_list',
		'options' => array(
			'display_name' => 'marked_list',
			'open_tag' => '\n[marked_list]',
			'close_tag' => '[/marked_list]\n',
			'key' => ''
	));

	for ($i=0; $i <= (count($buttons)-1); $i++) {
		$output .= "edButtons[edButtons.length] = new edButton('ed_{$buttons[$i]['name']}'
			,'{$buttons[$i]['options']['display_name']}'
			,'{$buttons[$i]['options']['open_tag']}'
			,'{$buttons[$i]['options']['close_tag']}'
			,'{$buttons[$i]['options']['key']}'
		); \n";
	}

	$output .= "\n /* ]]> */ \n
	</script>";
	echo $output;
}

function garden_pix_addbuttons() {
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
		return;

	if ( get_user_option('rich_editing') == 'true') {
		add_filter('mce_buttons_3', 'register_garden_pix_custom_button');
	}
}
function register_garden_pix_custom_button($buttons) {
	array_push(
		$buttons,
		"title_inner",
		"title_inner_large",
		"decor",
		"decor_wide",
		"decor_2",
		"footer_name",
		"footer_text",
		"button_link",
		"marked_list"

		);
	return $buttons;
}
add_action('init', 'garden_pix_addbuttons');

/******************* custom_title *******************/

function pix_title_inner( $atts, $content = null ) {
     extract(shortcode_atts(array(
		"title"=>'',
		"center"=>''
	), $atts));
	$center = $center != 1 ? '' : 'center-content';
	$out = '
            <div class="'.esc_attr($center).'"><h2 class="ui-title-inner">'.$content.'</h2></div>
            ';
   return $out;
}
add_shortcode('title_inner', 'pix_title_inner');

/******************* title_inner_large *******************/

function pix_title_inner_large( $atts, $content = null ) {
     extract(shortcode_atts(array(
		"title"=>'',
		"center"=>''
	), $atts));
	$center = $center != 1 ? '' : 'center-content';
	$out = '
            <div class="'.esc_attr($center).'"><h2 class="ui-title-inner ui-title-inner_mod-a">'.$content.'</h2></div>
            ';
   return $out;
}
add_shortcode('title_inner_large', 'pix_title_inner_large');


/******************* decor *******************/

function pix_decor( $atts, $content = null ) {
    extract(shortcode_atts(array(
        "center"=>''
    ), $atts));
    $center = $center != 1 ? '' : 'center-content';
    $out = '<div class="'.esc_attr($center).'"><div class="decor-1"></div></div>';
    return $out;
}
add_shortcode('decor', 'pix_decor');


/******************* decor_wide *******************/

function pix_decor_wide( $atts, $content = null ) {
     extract(shortcode_atts(array(
		"center"=>''
	), $atts));
	$center = $center != 1 ? '' : 'center-content';
	$out = '<div class="'.esc_attr($center).'"><div class="decor-1 decor-1_mod-b"></div></div>';
   return $out;
}
add_shortcode('decor_wide', 'pix_decor_wide');


/******************* decor_2 *******************/

function pix_decor_2( $atts, $content = null ) {
    extract(shortcode_atts(array(
        "center"=>''
    ), $atts));
    $center = $center != 1 ? '' : 'center-content';
    $out = '<div class="'.esc_attr($center).'"><div class="decor-2"><i class="icon fa fa-caret-down"></i></div></div>';
    return $out;
}
add_shortcode('decor_2', 'pix_decor_2');


/******************* footer_name *******************/

function pix_footer_name( $atts, $content = null ) {
     extract(shortcode_atts(array(
		"title"=>''
	), $atts));
	$out = '<div class="footer__name">'.$content.'</div>';
   return $out;
}
add_shortcode('footer_name', 'pix_footer_name');


/******************* footer_text *******************/

function pix_footer_text( $atts, $content = null ) {
     extract(shortcode_atts(array(
		"title"=>''
	), $atts));
	$out = '<div class="footer__text">'.$content.'</div>';
   return $out;
}
add_shortcode('footer_text', 'pix_footer_text');


/******************* footer_text *******************/

function pix_button_link( $atts, $content = null ) {
     extract(shortcode_atts(array(
		"link"=>'',
		"decor"=>''
	), $atts));
	$decor = ($decor != 0) ? '<div class="decor-1 decor-1_mod-b"></div>' : '';
	$out = '<a class="brand-link text-center" href="'.esc_url($link).'"><i class="icon fa fa-caret-right"></i>'.wp_kses_post($content).'<i class="icon fa fa-caret-left"></i><span class="br"></span>
                '.$decor.'
            </a>';
   return $out;
}
add_shortcode('button_link', 'pix_button_link');


/******************* marked_list *******************/

function pix_marked_list( $atts, $content = null ) {
     extract(shortcode_atts(array(
		"icon"=>'',
		"type"=>''
	), $atts));
	$temp_replace = str_replace('<ul>', '<ul class="list-mark list-unstyled">', $content);
	$temp_replace = str_replace('<li>', '<li><i class="decor-3 fa fa-caret-right"></i>', $temp_replace);
	$out = $temp_replace;
   return $out;
}
add_shortcode('marked_list', 'pix_marked_list');



?>