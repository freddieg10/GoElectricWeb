<?php 

	function autozone_js_vars(){
		
		$vars = '';

		$_js = apply_filters('autozone_js_vars',$vars);

		echo esc_js($_js);
		
	}
	
	
	function autozone_css_vars(){
		
		$css = '';
		$header_color  = autozone_get_option('header_all_color');
		$footer_color  = autozone_get_option('footer_all_color');
		if ($footer_color){
			
			$css .= '.footer-top { background-color: '.$header_color.' !important}';
			$css .= '.footer-bottom { background-color: '.$header_color.' !important}';			
		}

		
		if ($header_color)
			$css .= '.header-top { background-color: '.$header_color.' !important}';
		$css .= '';
		
		echo esc_html($css);
	}

	
	function autozone_get_theme_header(){
		$headerType = 'header1';
		global $wp_query;

		
		$pix_header_type_page = get_post_meta(get_the_ID(), 'header_type', true);
		if ($pix_header_type_page && $pix_header_type_page != ''){
			$headerType = $pix_header_type_page;
		}else{
			if (autozone_get_option('header_type')){
				$headerType = autozone_get_option('header_type');
			}
		}


		if (isset($wp_query->queried_object->ID)){
			$GLOBALS['autozone_footer_type_page'] = get_post_meta($wp_query->queried_object->ID, 'pix_page_footer_staticblock', true);
		}else{
			$GLOBALS['autozone_footer_type_page'] = get_post_meta(get_the_ID(), 'pix_page_footer_staticblock', true);
		}

		$headerFile = get_template_directory() . '/templates/header/types/' . $headerType . '.php';
		if (file_exists($headerFile))
			include( get_template_directory() . '/templates/header/types/' . $headerType . '.php' );
	}
	

	function autozone_load_block($block_name){
		
		global $woocommerce,$theme_name;
		
		$blockData = explode('/',$block_name);
		$blockType = (isset($blockData[0]))?$blockData[0]:'';
		$blockName = (isset($blockData[1]))?$blockData[1]:'';
	
		
		if (file_exists(get_template_directory() . '/templates/' . $blockType . '/' . $blockName . '.php')){
			get_template_part( 'templates/' . $blockType . '/' . $blockName );
		}
		
		
		
	}


	function autozone_woo_get_page_id(){

		global $post;

		if( is_shop() || is_product_category() || is_product_tag() )
			$id = get_option( 'woocommerce_shop_page_id' );
		elseif( is_product() || !empty($post->ID) )
			$id = $post->ID;
		else
			$id = 0;
		return $id;
	}


	function autozone_checkAvailableJsToPage($types){
		foreach($types as $type){
			if (function_exists('is_product') && is_product() && $type == 'product'){
				return true;
			}
		}
		return false;
	}

	function autozone_get_staticblock_content($blockId){

		if (is_array($blockId)){
			// SORT ORDER

			// Prepare sortable array
			$_blocks = array();

			foreach($blockId as $bId){
				if ($bId == 'global'){
					$bId = autozone_get_option('footer_block');
				}
				$_block = get_post($bId);
				$_blocks[$_block->menu_order][] = $_block;
			}



			foreach ($_blocks as $blockMenuOrder){
				foreach($blockMenuOrder as $block) {
					$shortcodes_custom_css = get_post_meta($block->ID, '_wpb_shortcodes_custom_css', true);
					if (!empty($shortcodes_custom_css)) {
						echo '<style type="text/css" data-type="vc_shortcodes-custom-css">';
						echo esc_html($shortcodes_custom_css);
						echo '</style>';
					}

					echo apply_filters('the_content', $block->post_content);
				}
			}
		}else{

			if ($blockId == 'global'){
				return '';
			}


			$block = get_post($blockId);
			$shortcodes_custom_css = get_post_meta( $blockId, '_wpb_shortcodes_custom_css', true );
			if ( ! empty( $shortcodes_custom_css ) ) {
				echo '<style type="text/css" data-type="vc_shortcodes-custom-css">';
				echo esc_html($shortcodes_custom_css);
				echo '</style>';
			}
			echo apply_filters('the_content', $block->post_content);
		}



	}


	function autozone_get_staticblock_option_array(){

		$args = array(
			'posts_per_page'  => '0',
			'post_type'        => 'staticblocks',
			'post_status'      => 'publish',
		);
		$staticBlocks = array();
		$staticBlocks[] = 'Select block';
		$staticBlocksData = get_posts( $args );
		foreach($staticBlocksData as $_block){
			$staticBlocks[$_block->ID] = $_block->post_title;
		}
		$staticBlocks['nofooter'] = esc_html__('No Footer','autozone');
		return $staticBlocks;
	}
	
	
	
	
	
	
?>