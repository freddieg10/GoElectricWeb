<?php 

if(autozone_get_option('header_advanced_page', '0')){
	add_action( 'add_meta_boxes', 'autozone_header_set' );
	add_action( 'add_meta_boxes', 'autozone_header_style' );
	add_action( 'add_meta_boxes', 'autozone_header_elements' );
	add_action( 'add_meta_boxes', 'autozone_header_responsive' );
}


/********* HEADER SETTINGS ==> ***********/
/* создаем мета бокс для layout */
add_action( 'add_meta_boxes', 'autozone_layout_side' );
function autozone_layout_side() {
	add_meta_box(
		'autozone_layout_side',
		esc_html__('Page Settings', 'autozone'),
		'autozone_layout_side_content',
		null,
		'side', /* место размещения */
		'default'
	);
}

/* добавляем на страницу каталога новое поле контента для галереи*/
function autozone_layout_side_content( $post ) {

	echo '<p><strong>'.esc_html__('Main Color', 'autozone').'</strong></p>';
	$sel_v = get_post_meta($post->ID, 'page_bg_color', 1);
	echo '<input type="text" name="page_bg_color" value="'.esc_attr($sel_v).'" class="admin-color-field" data-default-color="" />';

	echo '<p><label for="header_logo" class="row-title">'.esc_html__('Header Logo Light', 'autozone').'</label>';
	$sel_logo = get_post_meta($post->ID, 'header_logo', true);
    echo '	<input type="text" name="header_logo" id="header_logo" value="'.esc_url($sel_logo).'" />
            <button data-input="header_logo" class="btn pix-image-upload">Image</button>
    </p>';
    if($sel_logo){
        echo '<p> <img src="'.esc_url($sel_logo).'" alt="logo"> </p>';
    }

    echo '<p><label for="header_logo_inverse" class="row-title">'.esc_html__('Header Logo Dark', 'autozone').'</label>';
	$sel_logo_inverse = get_post_meta($post->ID, 'header_logo_inverse', true);
    echo '	<input type="text" name="header_logo_inverse" id="header_logo_inverse" value="'.esc_url($sel_logo_inverse).'" />
            <button type="button" data-input="header_logo_inverse" class="btn pix-image-upload">Image</button>
    </p>';
    if($sel_logo_inverse){
        echo '<p> <img src="'.esc_url($sel_logo_inverse).'" alt="logo_inverse"> </p>';
    }

	echo '<p><strong>'.esc_html__('Page Layout', 'autozone').'</strong></p><p><select class="rwmb-select" name="page_layout" />';
	$sel_l = get_post_meta($post->ID, 'page_layout', 1);
	echo '	<option value="" '.esc_attr(selected( $sel_l, '', false )).' >'.esc_html__('Default', 'autozone').'</option>
			<option value="layout-wide" '.esc_attr(selected( $sel_l, 'layout-wide', false )).' >'.esc_html__('Wide', 'autozone').'</option>
			<option value="layout-boxed" '.esc_attr(selected( $sel_l, 'layout-boxed', false )).' >'.esc_html__('Boxed', 'autozone').'</option>
		</select></p>';
	echo '<input type="hidden" name="extra_fields_nonce" value="'.esc_attr(wp_create_nonce(__FILE__)).'" />';		
}

/* сохраняем изменения  */
add_action( 'save_post', 'autozone_layout_side_save' );
function autozone_layout_side_save( $post_id ) {
	if ( !empty($_POST['extra_fields_nonce']) && !wp_verify_nonce($_POST['extra_fields_nonce'], __FILE__) ) return false; // проверка
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; // выходим если это автосохранение
	if ( !current_user_can('edit_post', $post_id) ) return false; // выходим если юзер не имеет право редактировать запись

	if( !isset($_POST['page_layout'])
		&& !isset($_POST['page_bg_color'])
		&& !isset($_POST['header_logo'])
		&& !isset($_POST['header_logo_inverse'])
	) return false;	// выходим если данных нет

	// Все ОК! Теперь, нужно сохранить/удалить данные
	$_POST['header_logo_inverse'] = trim($_POST['header_logo_inverse']); // чистим все данные от пробелов по краям
	$_POST['header_logo'] = trim($_POST['header_logo']);
	$_POST['page_layout'] = trim($_POST['page_layout']);
	$_POST['page_bg_color'] = trim($_POST['page_bg_color']);

	if( empty($_POST['page_bg_color']) ){
		delete_post_meta($post_id, 'page_bg_color'); // удаляем поле если значение пустое
	}else{
		update_post_meta($post_id, 'page_bg_color', $_POST['page_bg_color']); // add_post_meta() работает автоматически
	}

	if( empty($_POST['header_logo']) ){
		delete_post_meta($post_id, 'header_logo'); // удаляем поле если значение пустое
	}else{
		update_post_meta($post_id, 'header_logo', $_POST['header_logo']); // add_post_meta() работает автоматически
	}

	if( empty($_POST['header_logo_inverse']) ){
		delete_post_meta($post_id, 'header_logo_inverse'); // удаляем поле если значение пустое
	}else{
		update_post_meta($post_id, 'header_logo_inverse', $_POST['header_logo_inverse']); // add_post_meta() работает автоматически
	}

	if( empty($_POST['page_layout']) ){
		delete_post_meta($post_id, 'page_layout'); // удаляем поле если значение пустое
	}else{
		update_post_meta($post_id, 'page_layout', $_POST['page_layout']); // add_post_meta() работает автоматически
	}

	return $post_id;
}

/* создаем мета бокс для layout */
function autozone_header_set() {
	add_meta_box(
		'autozone_header_set',
		esc_html__('Header', 'autozone'),
		'autozone_header_set_content',
		null,
		'side', /* место размещения */
		'low'
	);
}

/* добавляем на страницу каталога новое поле контента для галереи*/
function autozone_header_set_content( $post ) {

	echo '<p><strong>'.esc_html__('Header Type', 'autozone').'</strong></p><p><select class="rwmb-select" name="header_type" />';
	$sel_ht = get_post_meta($post->ID, 'header_type', 1);
	echo '	<option value="" '.esc_attr(selected( $sel_ht, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
            <option value="header1" '.esc_attr(selected( $sel_ht, 'header1', false )).' >'.esc_html__('Classic', 'autozone').'</option>
            <option value="header2" '.esc_attr(selected( $sel_ht, 'header2', false )).' >'.esc_html__('Shop', 'autozone').'</option>
            <option value="header3" '.esc_attr(selected( $sel_ht, 'header3', false )).' >'.esc_html__('Sidebar', 'autozone').'</option>
        </select></p>';

	echo '<p><strong>'.esc_html__('Sidebar View', 'autozone').'</strong><br>'.esc_html__('(only for header type Sidebar)', 'autozone').'</p><p><select class="rwmb-select" name="header_sidebar_view" />';
	$sel_side = get_post_meta($post->ID, 'header_sidebar_view', 1);
	echo '	<option value="" '.esc_attr(selected( $sel_side, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
            <option value="fixed" '.esc_attr(selected( $sel_side, 'fixed', false )).' >'.esc_html__('Fixed', 'autozone').'</option>
            <option value="horizontal" '.esc_attr(selected( $sel_side, 'horizontal', false )).' >'.esc_html__('Horizontal Button', 'autozone').'</option>
            <option value="vertical" '.esc_attr(selected( $sel_side, 'vertical', false )).' >'.esc_html__('Vertical Button', 'autozone').'</option>
        </select></p>';

	echo '<p><strong>'.esc_html__('Header Behavior', 'autozone').'</strong></p><p><select class="rwmb-select" name="header_sticky" />';
	$sel_sticky = get_post_meta($post->ID, 'header_sticky', true);
    echo '	<option value="" '.esc_attr(selected( $sel_sticky, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
            <option value="0" '.esc_attr(selected( $sel_sticky, '0', false )).' >'.esc_html__('Default', 'autozone').'</option>
            <option value="sticky" '.esc_attr(selected( $sel_sticky, 'sticky', false )).' >'.esc_html__('Fixed Header', 'autozone').'</option>
            <option value="fixed" '.esc_attr(selected( $sel_sticky, 'fixed', false )).' >'.esc_html__('Sticky Header', 'autozone').'</option>
        </select></p>';

	echo '<p><strong>'.esc_html__('Show Main Menu', 'autozone').'</strong><p><select class="rwmb-select" name="header_menu" />';
	$sel_menu = get_post_meta($post->ID, 'header_menu', true);
	echo '	<option value="" '.esc_attr(selected( $sel_menu, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
			<option value="1" '.esc_attr(selected( $sel_menu, '1', false )).' >'.esc_html__('Yes', 'autozone').'</option>
            <option value="0" '.esc_attr(selected( $sel_menu, '0', false )).' >'.esc_html__('No', 'autozone').'</option>
        </select>
        </p>';

	echo '<p><strong>'.esc_html__('Additional Menu', 'autozone').'</strong></p><p><select class="rwmb-select" name="header_menu_add_position" />';
	$sel_add_position = get_post_meta($post->ID, 'header_menu_add_position', true);
    echo '	<option value="" '.esc_attr(selected( $sel_add_position, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
            <option value="left" '.esc_attr(selected( $sel_add_position, 'left', false )).' >'.esc_html__('Left Sidebar', 'autozone').'</option>
            <option value="right" '.esc_attr(selected( $sel_add_position, 'right', false )).' >'.esc_html__('Right Sidebar', 'autozone').'</option>
            <option value="top" '.esc_attr(selected( $sel_add_position, 'top', false )).' >'.esc_html__('Top Sidebar', 'autozone').'</option>
            <option value="bottom" '.esc_attr(selected( $sel_add_position, 'bottom', false )).' >'.esc_html__('Bottom Sidebar', 'autozone').'</option>
            <option value="screen" '.esc_attr(selected( $sel_add_position, 'screen', false )).' >'.esc_html__('Full Screen', 'autozone').'</option>
            <option value="disable" '.esc_attr(selected( $sel_add_position, 'disable', false )).' >'.esc_html__('Disable', 'autozone').'</option>
        </select></p>';

	echo '<input type="hidden" name="extra_fields_nonce" value="'.esc_attr(wp_create_nonce(__FILE__)).'" />';
}

/* сохраняем изменения  */
add_action( 'save_post', 'autozone_header_set_save' );
function autozone_header_set_save( $post_id ) {
	if ( !empty($_POST['extra_fields_nonce']) && !wp_verify_nonce($_POST['extra_fields_nonce'], __FILE__) ) return false; // проверка
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; // выходим если это автосохранение
	if ( !current_user_can('edit_post', $post_id) ) return false; // выходим если юзер не имеет право редактировать запись

	if( !isset($_POST['header_type'])
		&& !isset($_POST['header_sidebar_view'])
		&& !isset($_POST['header_sticky'])
		&& !isset($_POST['header_menu'])
		&& !isset($_POST['header_menu_add_position'])
	) return false;


	if( !isset($_POST['header_type']) ){
        delete_post_meta($post_id, 'header_type'); // удаляем поле если значение пустое
    }else{
        update_post_meta($post_id, 'header_type', $_POST['header_type']); // add_post_meta() работает автоматически
    }

	if( !isset($_POST['header_sidebar_view']) ){
        delete_post_meta($post_id, 'header_sidebar_view'); // удаляем поле если значение пустое
    }else{
        update_post_meta($post_id, 'header_sidebar_view', $_POST['header_sidebar_view']); // add_post_meta() работает автоматически
    }

	if( !isset($_POST['header_sticky']) ){
		delete_post_meta($post_id, 'header_sticky'); // удаляем поле если значение пустое
	}else{
		update_post_meta($post_id, 'header_sticky', $_POST['header_sticky']); // add_post_meta() работает автоматически
	}

    if( !isset($_POST['header_menu']) ){
        delete_post_meta($post_id, 'header_menu'); // удаляем поле если значение пустое
    }else{
        update_post_meta($post_id, 'header_menu', $_POST['header_menu']); // add_post_meta() работает автоматически
    }

    if( !isset($_POST['header_menu_add_position']) ){
        delete_post_meta($post_id, 'header_menu_add_position'); // удаляем поле если значение пустое
    }else{
        update_post_meta($post_id, 'header_menu_add_position', $_POST['header_menu_add_position']); // add_post_meta() работает автоматически
    }

	return $post_id;
}



/* создаем мета бокс для layout */
function autozone_header_style() {
	add_meta_box(
		'autozone_header_style',
		esc_html__('Header Style', 'autozone'),
		'autozone_header_style_content',
		null,
		'side', /* место размещения */
		'low'
	);
}

/* добавляем на страницу каталога новое поле контента для галереи*/
function autozone_header_style_content( $post ) {

	echo '<p><strong>'.esc_html__('Header Background', 'autozone').'</strong></p><p><select class="rwmb-select" name="header_background" />';
	$sel_background = get_post_meta($post->ID, 'header_background', true);
    echo '	<option value="" '.esc_attr(selected( $sel_background, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
            <option value="white" '.esc_attr(selected( $sel_background, 'white', false )).' >'.esc_html__('White', 'autozone').'</option>
            <option value="black" '.esc_attr(selected( $sel_background, 'black', false )).' >'.esc_html__('Black', 'autozone').'</option>
            <option value="trans-white" '.esc_attr(selected( $sel_background, 'trans-white', false )).' >'.esc_html__('Transparent White', 'autozone').'</option>
            <option value="trans-black" '.esc_attr(selected( $sel_background, 'trans-black', false )).' >'.esc_html__('Transparent Black', 'autozone').'</option>
        </select></p>';

	echo '<p><strong>'.esc_html__('Header Transparent', 'autozone').'</strong></p><p><select class="rwmb-select" name="header_transparent" />';
	$sel_trans = get_post_meta($post->ID, 'header_transparent', true);
    echo '	<option value="" '.esc_attr(selected( $sel_trans, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
            <option value="0" '.esc_attr(selected( $sel_trans, '0', false )).' >0.0</option>
            <option value="1" '.esc_attr(selected( $sel_trans, '1', false )).' >0.1</option>
            <option value="2" '.esc_attr(selected( $sel_trans, '2', false )).' >0.2</option>
            <option value="3" '.esc_attr(selected( $sel_trans, '3', false )).' >0.3</option>
            <option value="4" '.esc_attr(selected( $sel_trans, '4', false )).' >0.4</option>
            <option value="5" '.esc_attr(selected( $sel_trans, '5', false )).' >0.5</option>
            <option value="6" '.esc_attr(selected( $sel_trans, '6', false )).' >0.6</option>
            <option value="7" '.esc_attr(selected( $sel_trans, '7', false )).' >0.7</option>
            <option value="8" '.esc_attr(selected( $sel_trans, '8', false )).' >0.8</option>
            <option value="9" '.esc_attr(selected( $sel_trans, '9', false )).' >0.9</option>
        </select></p>';
        
	echo '<p><strong>'.esc_html__('Menu Hover Effect', 'autozone').'</strong></p><p><select class="rwmb-select" name="header_hover_effect" />';
	$sel_hover = get_post_meta($post->ID, 'header_hover_effect', true);
    echo '	<option value="" '.esc_attr(selected( $sel_hover, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
            <option value="0" '.esc_attr(selected( $sel_hover, '0', false )).' >'.esc_html__('Without effect', 'autozone').'</option>
            <option value="1" '.esc_attr(selected( $sel_hover, '1', false )).' >a</option>
            <option value="3" '.esc_attr(selected( $sel_hover, '3', false )).' >b</option>
            <option value="4" '.esc_attr(selected( $sel_hover, '4', false )).' >c</option>
            <option value="6" '.esc_attr(selected( $sel_hover, '6', false )).' >d</option>
            <option value="7" '.esc_attr(selected( $sel_hover, '7', false )).' >e</option>
            <option value="8" '.esc_attr(selected( $sel_hover, '8', false )).' >f</option>
            <option value="9" '.esc_attr(selected( $sel_hover, '9', false )).' >g</option>
            <option value="11" '.esc_attr(selected( $sel_hover, '11', false )).' >h</option>
            <option value="12" '.esc_attr(selected( $sel_hover, '12', false )).' >i</option>
            <option value="13" '.esc_attr(selected( $sel_hover, '13', false )).' >j</option>
            <option value="14" '.esc_attr(selected( $sel_hover, '14', false )).' >k</option>
            <option value="17" '.esc_attr(selected( $sel_hover, '17', false )).' >l</option>
            <option value="18" '.esc_attr(selected( $sel_hover, '18', false )).' >m</option>
        </select></p>';

	echo '<p><strong>'.esc_html__('Menu Markers', 'autozone').'</strong></p><p><select class="rwmb-select" name="header_marker" />';
	$sel_marker = get_post_meta($post->ID, 'header_marker', true);
    echo '	<option value="" '.esc_attr(selected( $sel_marker, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
            <option value="menu-marker-arrow" '.esc_attr(selected( $sel_marker, 'menu-marker-arrow', false )).' >'.esc_html__('Arrows', 'autozone').'</option>
            <option value="menu-marker-dot" '.esc_attr(selected( $sel_marker, 'menu-marker-dot', false )).' >'.esc_html__('Dots', 'autozone').'</option>
            <option value="no-marker" '.esc_attr(selected( $sel_marker, 'no-marker', false )).' >'.esc_html__('Without markers', 'autozone').'</option>
        </select></p>';

	echo '<p><strong>'.esc_html__('Header Layout', 'autozone').'</strong></p><p><select class="rwmb-select" name="header_layout" />';
	$sel_layout = get_post_meta($post->ID, 'header_layout', true);
    echo '	<option value="" '.esc_attr(selected( $sel_layout, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
            <option value="normal" '.esc_attr(selected( $sel_layout, 'normal', false )).' >'.esc_html__('Normal', 'autozone').'</option>
            <option value="boxed" '.esc_attr(selected( $sel_layout, 'boxed', false )).' >'.esc_html__('Boxed', 'autozone').'</option>
            <option value="full" '.esc_attr(selected( $sel_layout, 'full', false )).' >'.esc_html__('Full Width', 'autozone').'</option>
        </select></p>';

	echo '<p><strong>'.esc_html__('Sidebar Menu Animation', 'autozone').'</strong></p><p><select class="rwmb-select" name="header_menu_animation" />';
	$sel_animation = get_post_meta($post->ID, 'header_menu_animation', true);
    echo '	<option value="" '.esc_attr(selected( $sel_animation, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
            <option value="overlay" '.esc_attr(selected( $sel_animation, 'overlay', false )).' >'.esc_html__('Overlay', 'autozone').'</option>
            <option value="reveal" '.esc_attr(selected( $sel_animation, 'reveal', false )).' >'.esc_html__('Reveal', 'autozone').'</option>
        </select></p>';

	echo '<input type="hidden" name="extra_fields_nonce" value="'.esc_attr(wp_create_nonce(__FILE__)).'" />';
}

/* сохраняем изменения  */
add_action( 'save_post', 'autozone_header_style_save' );
function autozone_header_style_save( $post_id ) {
	if ( !empty($_POST['extra_fields_nonce']) && !wp_verify_nonce($_POST['extra_fields_nonce'], __FILE__) ) return false; // проверка
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; // выходим если это автосохранение
	if ( !current_user_can('edit_post', $post_id) ) return false; // выходим если юзер не имеет право редактировать запись

	if( !isset($_POST['header_background'])
		&& !isset($_POST['header_transparent'])
		&& !isset($_POST['header_hover_effect'])
		&& !isset($_POST['header_marker'])
		&& !isset($_POST['header_layout'])
		&& !isset($_POST['header_menu_animation'])
	) return false;


	if( !isset($_POST['header_background']) ){
		delete_post_meta($post_id, 'header_background'); // удаляем поле если значение пустое
	}else{
		update_post_meta($post_id, 'header_background', $_POST['header_background']); // add_post_meta() работает автоматически
	}

	if( !isset($_POST['header_transparent']) ){
		delete_post_meta($post_id, 'header_transparent'); // удаляем поле если значение пустое
	}else{
		update_post_meta($post_id, 'header_transparent', $_POST['header_transparent']); // add_post_meta() работает автоматически
	}

	if( !isset($_POST['header_hover_effect']) ){
		delete_post_meta($post_id, 'header_hover_effect'); // удаляем поле если значение пустое
	}else{
		update_post_meta($post_id, 'header_hover_effect', $_POST['header_hover_effect']); // add_post_meta() работает автоматически
	}

	if( !isset($_POST['header_marker']) ){
		delete_post_meta($post_id, 'header_marker'); // удаляем поле если значение пустое
	}else{
		update_post_meta($post_id, 'header_marker', $_POST['header_marker']); // add_post_meta() работает автоматически
	}

	if( !isset($_POST['header_layout']) ){
		delete_post_meta($post_id, 'header_layout'); // удаляем поле если значение пустое
	}else{
		update_post_meta($post_id, 'header_layout', $_POST['header_layout']); // add_post_meta() работает автоматически
	}

    if( !isset($_POST['header_menu_animation']) ){
        delete_post_meta($post_id, 'header_menu_animation'); // удаляем поле если значение пустое
    }else{
        update_post_meta($post_id, 'header_menu_animation', $_POST['header_menu_animation']); // add_post_meta() работает автоматически
    }


	return $post_id;
}




/* создаем мета бокс для layout */
function autozone_header_elements() {
	add_meta_box(
		'autozone_header_elements',
		esc_html__('Header Elements', 'autozone'),
		'autozone_header_elements_content',
		null,
		'side', /* место размещения */
		'low'
	);
}

/* добавляем на страницу каталога новое поле контента для галереи*/
function autozone_header_elements_content( $post ) {

	echo '<p><strong>'.esc_html__('Show Top Bar', 'autozone').'</strong></p><p><select class="rwmb-select" name="header_bar" />';
	$sel_bar = get_post_meta($post->ID, 'header_bar', true);
	echo '	<option value="" '.esc_attr(selected( $sel_bar, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
			<option value="1" '.esc_attr(selected( $sel_bar, '1', false )).' >'.esc_html__('Yes', 'autozone').'</option>
            <option value="0" '.esc_attr(selected( $sel_bar, '0', false )).' >'.esc_html__('No', 'autozone').'</option>
        </select></p>';

	echo '<p><strong>'.esc_html__('Show Minicart', 'autozone').'</strong></p><p><select class="rwmb-select" name="header_minicart" />';
	$sel_minicart = get_post_meta($post->ID, 'header_minicart', true);
    echo '	<option value="" '.esc_attr(selected( $sel_minicart, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
            <option value="1" '.esc_attr(selected( $sel_minicart, '1', false )).' >'.esc_html__('Yes', 'autozone').'</option>
            <option value="0" '.esc_attr(selected( $sel_minicart, '0', false )).' >'.esc_html__('No', 'autozone').'</option>
        </select></p>';

	echo '<p><strong>'.esc_html__('Show Search', 'autozone').'</strong></p><p><select class="rwmb-select" name="header_search" />';
	$sel_search = get_post_meta($post->ID, 'header_search', true);
    echo '	<option value="" '.esc_attr(selected( $sel_search, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
            <option value="1" '.esc_attr(selected( $sel_search, '1', false )).' >'.esc_html__('Yes', 'autozone').'</option>
            <option value="0" '.esc_attr(selected( $sel_search, '0', false )).' >'.esc_html__('No', 'autozone').'</option>
        </select></p>';

	echo '<p><strong>'.esc_html__('Show Socials', 'autozone').'</strong></p><p><select class="rwmb-select" name="header_socials" />';
	$sel_socials = get_post_meta($post->ID, 'header_socials', true);
    echo '	<option value="" '.esc_attr(selected( $sel_socials, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
            <option value="1" '.esc_attr(selected( $sel_socials, '1', false )).' >'.esc_html__('Yes', 'autozone').'</option>
            <option value="0" '.esc_attr(selected( $sel_socials, '0', false )).' >'.esc_html__('No', 'autozone').'</option>
        </select></p>';

	echo '<p><strong>'.esc_html__('Show Phone', 'autozone').'</strong></p><p><select class="rwmb-select" name="header_phone" />';
	$sel_phone = get_post_meta($post->ID, 'header_phone', true);
    echo '	<option value="" '.esc_attr(selected( $sel_phone, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
            <option value="1" '.esc_attr(selected( $sel_phone, '1', false )).' >'.esc_html__('Yes', 'autozone').'</option>
            <option value="0" '.esc_attr(selected( $sel_phone, '0', false )).' >'.esc_html__('No', 'autozone').'</option>
        </select></p>';

	echo '<p><strong>'.esc_html__('Show E-mail', 'autozone').'</strong></p><p><select class="rwmb-select" name="header_email" />';
	$sel_email = get_post_meta($post->ID, 'header_email', true);
    echo '	<option value="" '.esc_attr(selected( $sel_email, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
            <option value="1" '.esc_attr(selected( $sel_email, '1', false )).' >'.esc_html__('Yes', 'autozone').'</option>
            <option value="0" '.esc_attr(selected( $sel_email, '0', false )).' >'.esc_html__('No', 'autozone').'</option>
        </select></p>';

	echo '<p><strong>'.esc_html__('Top Bar Email Position', 'autozone').'</strong></p><p><select class="rwmb-select" name="header_topbarbox_1_position" />';
	$sel_top1 = get_post_meta($post->ID, 'header_topbarbox_1_position', true);
	echo '	<option value="" '.esc_attr(selected( $sel_top1, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
			<option value="left" '.esc_attr(selected( $sel_top1, 'left', false )).' >'.esc_html__('Left', 'autozone').'</option>
            <option value="right" '.esc_attr(selected( $sel_top1, 'right', false )).' >'.esc_html__('Right', 'autozone').'</option>
        </select></p>';

	echo '<p><strong>'.esc_html__('Top Bar Menu Position', 'autozone').'</strong></p><p><select class="rwmb-select" name="header_topbarbox_2_position" />';
	$sel_top2 = get_post_meta($post->ID, 'header_topbarbox_2_position', true);
	echo '	<option value="" '.esc_attr(selected( $sel_top2, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
			<option value="left" '.esc_attr(selected( $sel_top2, 'left', false )).' >'.esc_html__('Left', 'autozone').'</option>
            <option value="right" '.esc_attr(selected( $sel_top2, 'right', false )).' >'.esc_html__('Right', 'autozone').'</option>
        </select></p>';

	echo '<p><strong>'.esc_html__('Logo Position', 'autozone').'</strong></p><p><select class="rwmb-select" name="header_navibox_1_position" />';
	$sel_nav1 = get_post_meta($post->ID, 'header_navibox_1_position', true);
	echo '	<option value="" '.esc_attr(selected( $sel_nav1, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
			<option value="left" '.esc_attr(selected( $sel_nav1, 'left', false )).' >'.esc_html__('Left', 'autozone').'</option>
            <option value="right" '.esc_attr(selected( $sel_nav1, 'right', false )).' >'.esc_html__('Right', 'autozone').'</option>
        </select></p>';

	echo '<p><strong>'.esc_html__('Main Menu Position', 'autozone').'</strong></p><p><select class="rwmb-select" name="header_navibox_2_position" />';
	$sel_nav2 = get_post_meta($post->ID, 'header_navibox_2_position', true);
	echo '	<option value="" '.esc_attr(selected( $sel_nav2, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
			<option value="left" '.esc_attr(selected( $sel_nav2, 'left', false )).' >'.esc_html__('Left', 'autozone').'</option>
            <option value="right" '.esc_attr(selected( $sel_nav2, 'right', false )).' >'.esc_html__('Right', 'autozone').'</option>
        </select></p>';

	echo '<p><strong>'.esc_html__('Socials And Phone Position', 'autozone').'</strong></p><p><select class="rwmb-select" name="header_navibox_3_position" />';
	$sel_nav3 = get_post_meta($post->ID, 'header_navibox_3_position', true);
	echo '	<option value="" '.esc_attr(selected( $sel_nav3, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
			<option value="left" '.esc_attr(selected( $sel_nav3, 'left', false )).' >'.esc_html__('Left', 'autozone').'</option>
            <option value="right" '.esc_attr(selected( $sel_nav3, 'right', false )).' >'.esc_html__('Right', 'autozone').'</option>
        </select></p>';

	echo '<p><strong>'.esc_html__('Minicart Position', 'autozone').'</strong></p><p><select class="rwmb-select" name="header_navibox_4_position" />';
	$sel_nav4 = get_post_meta($post->ID, 'header_navibox_4_position', true);
	echo '	<option value="" '.esc_attr(selected( $sel_nav4, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
			<option value="left" '.esc_attr(selected( $sel_nav4, 'left', false )).' >'.esc_html__('Left', 'autozone').'</option>
            <option value="right" '.esc_attr(selected( $sel_nav4, 'right', false )).' >'.esc_html__('Right', 'autozone').'</option>
        </select></p>';

	echo '<input type="hidden" name="extra_fields_nonce" value="'.esc_attr(wp_create_nonce(__FILE__)).'" />';
}

/* сохраняем изменения  */
add_action( 'save_post', 'autozone_header_elements_save' );
function autozone_header_elements_save( $post_id ) {
	if ( !empty($_POST['extra_fields_nonce']) && !wp_verify_nonce($_POST['extra_fields_nonce'], __FILE__) ) return false; // проверка
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; // выходим если это автосохранение
	if ( !current_user_can('edit_post', $post_id) ) return false; // выходим если юзер не имеет право редактировать запись

	if( !isset($_POST['header_minicart'])
		&& !isset($_POST['header_bar'])
		&& !isset($_POST['header_search'])
		&& !isset($_POST['header_socials'])
		&& !isset($_POST['header_phone'])
		&& !isset($_POST['header_email'])
		&& !isset($_POST['header_topbarbox_1_position'])
		&& !isset($_POST['header_topbarbox_2_position'])
		&& !isset($_POST['header_navibox_1_position'])
		&& !isset($_POST['header_navibox_2_position'])
		&& !isset($_POST['header_navibox_3_position'])
		&& !isset($_POST['header_navibox_4_position'])
	) return false;


    if( !isset($_POST['header_bar']) ){
        delete_post_meta($post_id, 'header_bar'); // удаляем поле если значение пустое
    }else{
        update_post_meta($post_id, 'header_bar', $_POST['header_bar']); // add_post_meta() работает автоматически
    }

    if( !isset($_POST['header_minicart']) ){
        delete_post_meta($post_id, 'header_minicart'); // удаляем поле если значение пустое
    }else{
        update_post_meta($post_id, 'header_minicart', $_POST['header_minicart']); // add_post_meta() работает автоматически
    }

    if( !isset($_POST['header_search']) ){
        delete_post_meta($post_id, 'header_search'); // удаляем поле если значение пустое
    }else{
        update_post_meta($post_id, 'header_search', $_POST['header_search']); // add_post_meta() работает автоматически
    }

    if( !isset($_POST['header_socials']) ){
        delete_post_meta($post_id, 'header_socials'); // удаляем поле если значение пустое
    }else{
        update_post_meta($post_id, 'header_socials', $_POST['header_socials']); // add_post_meta() работает автоматически
    }

	if( !isset($_POST['header_phone']) ){
		delete_post_meta($post_id, 'header_phone'); // удаляем поле если значение пустое
	}else{
		update_post_meta($post_id, 'header_phone', $_POST['header_phone']); // add_post_meta() работает автоматически
	}

	if( !isset($_POST['header_email']) ){
		delete_post_meta($post_id, 'header_email'); // удаляем поле если значение пустое
	}else{
		update_post_meta($post_id, 'header_email', $_POST['header_email']); // add_post_meta() работает автоматически
	}

	if( !isset($_POST['header_topbarbox_1_position']) ){
		delete_post_meta($post_id, 'header_topbarbox_1_position'); // удаляем поле если значение пустое
	}else{
		update_post_meta($post_id, 'header_topbarbox_1_position', $_POST['header_topbarbox_1_position']); // add_post_meta() работает автоматически
	}

	if( !isset($_POST['header_topbarbox_2_position']) ){
		delete_post_meta($post_id, 'header_topbarbox_2_position'); // удаляем поле если значение пустое
	}else{
		update_post_meta($post_id, 'header_topbarbox_2_position', $_POST['header_topbarbox_2_position']); // add_post_meta() работает автоматически
	}

	if( !isset($_POST['header_navibox_1_position']) ){
		delete_post_meta($post_id, 'header_navibox_1_position'); // удаляем поле если значение пустое
	}else{
		update_post_meta($post_id, 'header_navibox_1_position', $_POST['header_navibox_1_position']); // add_post_meta() работает автоматически
	}

	if( !isset($_POST['header_navibox_2_position']) ){
		delete_post_meta($post_id, 'header_navibox_2_position'); // удаляем поле если значение пустое
	}else{
		update_post_meta($post_id, 'header_navibox_2_position', $_POST['header_navibox_2_position']); // add_post_meta() работает автоматически
	}

	if( !isset($_POST['header_navibox_3_position']) ){
		delete_post_meta($post_id, 'header_navibox_3_position'); // удаляем поле если значение пустое
	}else{
		update_post_meta($post_id, 'header_navibox_3_position', $_POST['header_navibox_3_position']); // add_post_meta() работает автоматически
	}

	if( !isset($_POST['header_navibox_4_position']) ){
		delete_post_meta($post_id, 'header_navibox_4_position'); // удаляем поле если значение пустое
	}else{
		update_post_meta($post_id, 'header_navibox_4_position', $_POST['header_navibox_4_position']); // add_post_meta() работает автоматически
	}

	return $post_id;
}


/* создаем мета бокс для layout */
function autozone_header_responsive() {
	add_meta_box(
		'autozone_header_responsive',
		esc_html__('Header Responsive', 'autozone'),
		'autozone_header_responsive_content',
		null,
		'side', /* место размещения */
		'low'
	);
}

/* добавляем на страницу каталога новое поле контента для галереи*/
function autozone_header_responsive_content( $post ) {

	echo '<p><strong>'.esc_html__('Header Mobile Behavior', 'autozone').'</strong></p><p><select class="rwmb-select" name="mobile_sticky" />';
	$sel_mobs = get_post_meta($post->ID, 'mobile_sticky', true);
	echo '	<option value="" '.esc_attr(selected( $sel_mobs, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
			<option value="mobile-no-sticky" '.esc_attr(selected( $sel_mobs, 'mobile-no-stickyv', false )).' >'.esc_html__('No Sticky', 'autozone').'</option>
            <option value="mobile-no-fixed" '.esc_attr(selected( $sel_mobs, 'mobile-no-fixedv', false )).' >'.esc_html__('No Fixed', 'autozone').'</option>
        </select></p>';

	echo '<p><strong>'.esc_html__('Mobile Top Bar', 'autozone').'</strong></p><p><select class="rwmb-select" name="mobile_topbar" />';
	$sel_mobt = get_post_meta($post->ID, 'mobile_topbar', true);
    echo '	<option value="" '.esc_attr(selected( $sel_mobt, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
            <option value="no-mobile-topbar" '.esc_attr(selected( $sel_mobt, 'no-mobile-topbar', false )).' >'.esc_html__('Off', 'autozone').'</option>
        </select></p>';

	echo '<p><strong>'.esc_html__('Tablet Minicart', 'autozone').'</strong></p><p><select class="rwmb-select" name="tablet_minicart" />';
	$sel_search = get_post_meta($post->ID, 'tablet_minicart', true);
    echo '	<option value="" '.esc_attr(selected( $sel_search, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
            <option value="no-tablet-minicart" '.esc_attr(selected( $sel_search, 'no-tablet-minicart', false )).' >'.esc_html__('Off', 'autozone').'</option>
        </select></p>';

	echo '<p><strong>'.esc_html__('Tablet Search', 'autozone').'</strong></p><p><select class="rwmb-select" name="tablet_search" />';
	$sel_socials = get_post_meta($post->ID, 'tablet_searcht', true);
    echo '	<option value="" '.esc_attr(selected( $sel_socials, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
            <option value="no-tablet-search" '.esc_attr(selected( $sel_socials, 'no-tablet-search', false )).' >'.esc_html__('Off', 'autozone').'</option>
        </select></p>';

	echo '<p><strong>'.esc_html__('Tablet Header Phone', 'autozone').'</strong></p><p><select class="rwmb-select" name="tablet_phone" />';
	$sel_phone = get_post_meta($post->ID, 'tablet_phone', true);
    echo '	<option value="" '.esc_attr(selected( $sel_phone, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
            <option value="no-tablet-phone" '.esc_attr(selected( $sel_phone, 'no-tablet-phone', false )).' >'.esc_html__('Off', 'autozone').'</option>
        </select></p>';

	echo '<p><strong>'.esc_html__('Tablet Socials', 'autozone').'</strong></p><p><select class="rwmb-select" name="tablet_socials" />';
	$sel_email = get_post_meta($post->ID, 'tablet_socials', true);
    echo '	<option value="" '.esc_attr(selected( $sel_email, '', false )).' >'.esc_html__('Global', 'autozone').'</option>
            <option value="no-tablet-socials" '.esc_attr(selected( $sel_email, 'no-tablet-socials', false )).' >'.esc_html__('Off', 'autozone').'</option>
        </select></p>';

	echo '<input type="hidden" name="extra_fields_nonce" value="'.esc_attr(wp_create_nonce(__FILE__)).'" />';
}

/* сохраняем изменения  */
add_action( 'save_post', 'autozone_header_responsive_save' );
function autozone_header_responsive_save( $post_id ) {
	if ( !empty($_POST['extra_fields_nonce']) && !wp_verify_nonce($_POST['extra_fields_nonce'], __FILE__) ) return false; // проверка
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false; // выходим если это автосохранение
	if ( !current_user_can('edit_post', $post_id) ) return false; // выходим если юзер не имеет право редактировать запись

	if( !isset($_POST['mobile_sticky'])
		&& !isset($_POST['mobile_topbar'])
		&& !isset($_POST['tablet_minicart'])
		&& !isset($_POST['tablet_search'])
		&& !isset($_POST['tablet_phone'])
		&& !isset($_POST['tablet_socials'])
	) return false;


    if( !isset($_POST['mobile_sticky']) ){
        delete_post_meta($post_id, 'mobile_sticky'); // удаляем поле если значение пустое
    }else{
        update_post_meta($post_id, 'mobile_sticky', $_POST['mobile_sticky']); // add_post_meta() работает автоматически
    }

    if( !isset($_POST['mobile_topbar']) ){
        delete_post_meta($post_id, 'mobile_topbar'); // удаляем поле если значение пустое
    }else{
        update_post_meta($post_id, 'mobile_topbar', $_POST['mobile_topbar']); // add_post_meta() работает автоматически
    }

    if( !isset($_POST['tablet_minicart']) ){
        delete_post_meta($post_id, 'tablet_minicart'); // удаляем поле если значение пустое
    }else{
        update_post_meta($post_id, 'tablet_minicart', $_POST['tablet_minicart']); // add_post_meta() работает автоматически
    }

    if( !isset($_POST['tablet_search']) ){
        delete_post_meta($post_id, 'tablet_search'); // удаляем поле если значение пустое
    }else{
        update_post_meta($post_id, 'tablet_search', $_POST['tablet_search']); // add_post_meta() работает автоматически
    }

	if( !isset($_POST['tablet_phone']) ){
		delete_post_meta($post_id, 'tablet_phone'); // удаляем поле если значение пустое
	}else{
		update_post_meta($post_id, 'tablet_phone', $_POST['tablet_phone']); // add_post_meta() работает автоматически
	}

	if( !isset($_POST['tablet_socials']) ){
		delete_post_meta($post_id, 'tablet_socials'); // удаляем поле если значение пустое
	}else{
		update_post_meta($post_id, 'tablet_socials', $_POST['tablet_socials']); // add_post_meta() работает автоматически
	}

	return $post_id;
}


/********* ==> END HEADER SETTINGS ***********/


add_action( 'add_meta_boxes', 'autozone_posts_init' );
function autozone_posts_init(){
	add_meta_box("sidebar_options", esc_html__("AutoZone - Page Layout Options", 'autozone'), "autozone_sidebar_options", "post", "side", "low");
	add_meta_box("sidebar_options", esc_html__("AutoZone - Page Layout Options", 'autozone'), "autozone_sidebar_options", "page", "side", "low");
	add_meta_box("sidebar_options", esc_html__("AutoZone - Page Layout Options", 'autozone'), "autozone_sidebar_options", "portfolio", "side", "low");



}

/** START SIDEBAR OPTIONS */

function autozone_sidebar_options(){
	global $post;
	$post_id = $post;
	if (is_object($post_id)) {
		$post_id = $post_id->ID;
	}
	
	
	$selected_type_purpose = (get_post_meta($post_id, 'pix_page_purpose', true) == "") ? '' : get_post_meta($post_id, 'pix_page_purpose', true);
	$selected_type_sidebar = (get_post_meta($post_id, 'pix_page_layout', true) == "") ? 2 : get_post_meta($post_id, 'pix_page_layout', true);

	$selected_footer_block = array();

	if (!is_array(get_post_meta($post_id, 'pix_page_footer_staticblock', true))){
		if (get_post_meta($post_id, 'pix_page_footer_staticblock', true) == ""){
			$selected_footer_block = array('global');
		}else{
			$selected_footer_block = array(get_post_meta($post_id, 'pix_page_footer_staticblock', true));
		}
	}else{
		$selectedFootBlock = get_post_meta($post_id, 'pix_page_footer_staticblock', true);
		if (empty($selectedFootBlock)){
			$selected_footer_block = array('global');
		}else{
			$selected_footer_block = $selectedFootBlock;
		}
	}



	
	$args = array(
		'post_type'        => 'staticblocks',
		'post_status'      => 'publish',
	);
	$staticBlocks = array();
	$staticBlocks['global'] = esc_html__('Use global settings','autozone');
	$staticBlocksData = get_posts( $args );
	foreach($staticBlocksData as $_block){
		$staticBlocks[$_block->ID] =  $_block->post_title;
	}
	$staticBlocks['nofooter'] = esc_html__('No Footer','autozone');

	$selected_sidebar = get_post_meta($post_id, 'pix_selected_sidebar', true);

	if(!is_array($selected_sidebar)){
		$tmp = $selected_sidebar; 
		$selected_sidebar = array(); 
		$selected_sidebar[0] = $tmp;
	}
	
	?>
	<p><strong><?php echo esc_html__('Autos Purpose', 'autozone')?></strong></p>
	
	<select class="rwmb-select" name="pix_page_purpose" id="pix_page_purpose" size="0">
	    <option value="" <?php if ($selected_type_purpose == ''):?>selected="selected"<?php endif?>><?php echo esc_html__('All', 'autozone')?></option>
		<option value="rent" <?php if ($selected_type_purpose == 'rent'):?>selected="selected"<?php endif?>><?php echo esc_html__('Rent', 'autozone')?></option>
		<option value="sell" <?php if ($selected_type_purpose == 'sell'):?>selected="selected"<?php endif?>><?php echo esc_html__('Selling', 'autozone')?>
		<option value="sold" <?php if ($selected_type_purpose == 'sold'):?>selected="selected"<?php endif?>><?php echo esc_html__('Sold', 'autozone')?>	

		</option>
	</select>
	
	<p><strong><?php echo esc_html__('Sidebar type', 'autozone')?></strong></p>
	
	<select class="rwmb-select" name="pix_page_layout" id="pix_page_layout" size="0">
		<option value="1" <?php if ($selected_type_sidebar == 1):?>selected="selected"<?php endif?>><?php echo esc_html__('Full width', 'autozone')?></option>
		<option value="2" <?php if ($selected_type_sidebar == 2):?>selected="selected"<?php endif?>><?php echo esc_html__('Right Sidebar', 'autozone')?></option>
		<option value="3" <?php if ($selected_type_sidebar == 3):?>selected="selected"<?php endif?>><?php echo esc_html__('Left Sidebar', 'autozone')?></option>
	</select>
	<?php ?>
	
	<p><strong><?php echo esc_html__('Sidebar content', 'autozone')?></strong></p>
	<ul>
	<?php 
	global $wp_registered_sidebars;
	//var_dump($wp_registered_sidebars);		
		for($i=0;$i<1;$i++){ ?>
			<li>
			<select name="sidebar_generator[<?php echo esc_attr($i)?>]">
				<!--<option value=""<?php if($selected_sidebar[$i] == ''){ echo " selected";} ?>><?php echo esc_html__('WP Default Sidebar', 'autozone')?></option>-->
			<?php
			$sidebars = $wp_registered_sidebars;
			if(is_array($sidebars) && !empty($sidebars)){
				foreach($sidebars as $sidebar){
					if($selected_sidebar[$i] == $sidebar['id']){
						echo "<option value='".esc_attr($sidebar['id'])."' selected>{$sidebar['name']}</option>\n";
					}else{
						echo "<option value='".esc_attr($sidebar['id'])."'>{$sidebar['name']}</option>\n";
					}
				}
			}
			?>
			</select>
			</li>
		<?php } ?>
	</ul>

	<p><strong><?php echo esc_html__('Footer Static Block', 'autozone')?></strong></p>
	<ul>
		<li>
		<select name="pix_page_footer_staticblock[]" multiple="multiple">
		<?php foreach($staticBlocks as $id => $_staticBlock){
				if(in_array($id,$selected_footer_block)){
					echo "<option value='".esc_attr($id)."' selected>".esc_attr($_staticBlock)."</option>\n";
				}else{
					echo "<option value='".esc_attr($id)."'>".esc_attr($_staticBlock)."</option>\n";
				}
			}
		?>
		</select>
		</li>
	</ul>

<?php }

/** END SIDEBAR OPTIONS */


function autozone_save_postdata( $post_id ) {
	
	if ( wp_is_post_revision( $post_id ) )
		return;
		
		
	global $post, $new_meta_boxes;

	
	if(isset($new_meta_boxes))
	foreach($new_meta_boxes as $meta_box) {
		
		if ( $meta_box['type'] != 'title)' ) {
		
			if ( 'page' == $_POST['post_type'] ) {
				if ( !current_user_can( 'edit_page', $post_id ))
					return $post_id;
			} else {
				if ( !current_user_can( 'edit_post', $post_id ))
					return $post_id;
			}
			
			if (isset($_POST[$meta_box['name']]) && is_array($_POST[$meta_box['name']]) ) {
				$cats = '';
				foreach($_POST[$meta_box['name']] as $cat){
					$cats .= $cat . ",";
				}
				$data = substr($cats, 0, -1);
			}
			
			else { $data = ''; if(isset($_POST[$meta_box['name']])) $data = $_POST[$meta_box['name']]; }			
			
			if(get_post_meta($post_id, $meta_box['name']) == "")
				add_post_meta($post_id, $meta_box['name'], $data, true);
			elseif($data != get_post_meta($post_id, $meta_box['name'], true))
				update_post_meta($post_id, $meta_box['name'], $data);
			elseif($data == "")
				delete_post_meta($post_id, $meta_box['name'], get_post_meta($post_id, $meta_box['name'], true));
				
		}
	}

	autozone_save_sidebar_data( $post_id );
	
}

function autozone_save_sidebar_data( $post_id ){

	if (isset($_POST['pix_page_purpose'])){
		if(get_post_meta($post_id, 'pix_page_purpose') == "")
			add_post_meta($post_id, 'pix_page_purpose', $_POST['pix_page_purpose'], true);
		else
			update_post_meta($post_id, 'pix_page_purpose', $_POST['pix_page_purpose']);
	}

	if (isset($_POST['pix_page_layout'])){
		if(get_post_meta($post_id, 'pix_page_layout') == "")
			add_post_meta($post_id, 'pix_page_layout', $_POST['pix_page_layout'], true);
		else
			update_post_meta($post_id, 'pix_page_layout', $_POST['pix_page_layout']);
	}
	
	if (isset($_POST['sidebar_generator'][0])){
		if(get_post_meta($post_id, 'pix_page_layout') == "")
			add_post_meta($post_id, 'pix_selected_sidebar', $_POST['sidebar_generator'][0], true);
		else
			update_post_meta($post_id, 'pix_selected_sidebar', $_POST['sidebar_generator'][0]);
	}
	if (isset($_POST['pix_page_footer_staticblock'])){
		if(get_post_meta($post_id, 'pix_page_footer_staticblock') == "")
			add_post_meta($post_id, 'pix_page_footer_staticblock', $_POST['pix_page_footer_staticblock'], true);
		else
			update_post_meta($post_id, 'pix_page_footer_staticblock', $_POST['pix_page_footer_staticblock']);
	}
}

add_action('save_post', 'autozone_save_postdata');

?>