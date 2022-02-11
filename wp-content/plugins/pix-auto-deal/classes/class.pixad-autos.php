<?php
class PIXAD_Autos {

	public $per_page;


	public $order = 'DESC';

	public $orderby = 'date';

	public $metakey;


	protected static $orderby_arr = array('date', 'title');

	protected static $orderby_num = array('_auto_price', '_auto_year');
	/**
	 * Class Constructor
	 * =================
	 * @since 0.4
	 */
	public function __construct() {
		// Rewrite rules
		add_action( 'init', array( $this, 'rewrite_rules' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'init_plugin' ) );
        add_action( 'wp_ajax_process_reservation', array( $this, 'process_reservation' ) );
        add_action( 'wp_ajax_nopriv_process_reservation', array( $this, 'process_reservation' ) );
	}

	/**
	 * Custom Rewrite Rules
	 * ====================
	 * @since 0.6
	 */
	public function rewrite_rules() {
		$Settings	= new PIXAD_Settings();
		$settings	= $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );

		//add_rewrite_rule( '^add-auto/?', 'index.php?page_id='.$settings['cc_page_id'].'&pixad=add-new-pixad', 'top' );
		//add_rewrite_rule( '^my-autos/?', 'index.php?page_id='.$settings['cc_page_id'].'&pixad=my-pixads', 'top' );
	}


	public function init_plugin() {
        wp_enqueue_script(
            'ajax_script',
            plugins_url( '/pix-auto-deal/assets/js/pixad-ajax.js' ),
            array('jquery'),
            TRUE
        );
        wp_localize_script(
            'ajax_script',
            'pixadAjax',
            array(
                'url'   => admin_url( 'admin-ajax.php' ),
                'nonce' => wp_create_nonce( "process_reservation_nonce" ),
            )
        );
    }



       public function process_reservation() {
    	$POST_order = wp_unslash( $_REQUEST);
		$POST_order = $POST_order['order'];
		$Settings = new PIXAD_Settings();
		$settings = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );

		$validate = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_validation', true ); // Get validation settings
		
		$showInSidebar = pixad::getsideviewfields($validate);
		$showInList = pixad::getlistviewfields($validate);
		$validate = pixad::validation( $validate ); // Fix undefined index notice

		$country = new PIXAD_Country();

	    $data = array_map( 'esc_attr', $_GET );

        check_ajax_referer( 'process_reservation_nonce', 'nonce' );
		$keys = array_keys($data);


					foreach($data as $key=>$val){
						if( $key == 'post_style'){
                    $view_type = $val;
                }
					}

        if( true && !in_array('make_model', $keys) ){
            $args = array();
            foreach($data as $key=>$val){
                if( property_exists('PIXAD_Autos', $key) && $key == 'order' ){
                    $temp = explode('-', $val);

					if(isset($temp[0]) && in_array($temp[0], self::$orderby_arr)){
		                $this->orderby = $temp[0];
		                $this->order = strtoupper($temp[1]);
		                $this->metakey = '';
	                }
	                elseif(isset($temp[0]) && !in_array($temp[0], self::$orderby_arr)){
		                $this->orderby = !in_array($temp[0], self::$orderby_num) ? 'meta_value' : 'meta_value_num';
		                $this->order = strtoupper($temp[1]);
		                $this->metakey = $temp[0];
	                }
                } elseif( property_exists('PIXAD_Autos', $key) && $key == 'per_page' ) {
	                $this->$key = $val;
                } elseif( $key == 'make_model' ){
	                //$args[$key] = $val;

                }elseif($key == 'time-finish'){
                	$args['finish_time'] = $val;
                }elseif($key == 'time-start'){
                	$args['start_time'] = $val;
                } elseif( $key != 'action' && $key != 'nonce' && $val != ''){
                    $args[$key] = $val;
                } 
	                		
                
            }

            $args['nopaging'] = true;

            $wp_query_args = $this->Query_Args($args);

			if('_auto_make-desc' == $POST_order){
   				$wp_query_args['orderby'] = 'title';
   				$wp_query_args['order'] = 'DESC'; 

          	}elseif('_auto_make-asc' == $POST_order){
   				$wp_query_args['orderby'] = 'title';
   				$wp_query_args['order'] = 'ASC'; 
          	}



		if( $POST_order === '_auto_price-desc' ) { 
	
		//	$wp_query_args['meta_query']['_auto_price']['key'] = '_auto_price';
		//	$wp_query_args['orderby']['_auto_price'] = 'DESC'; 

			
		  $wp_query_args['meta_key'] = '_auto_price';
		  $wp_query_args['orderby'] = 'meta_value_num';
		  $wp_query_args['order'] = 'DESC';



		}elseif($POST_order === '_auto_price-asc'){
		  $wp_query_args['meta_key'] = '_auto_price';
		  $wp_query_args['orderby'] = 'meta_value_num';
		  $wp_query_args['order'] = 'ASC';
		
		}

		//print_r($wp_query_args);

    		//$autozone_loop = new WP_Query( apply_filters( 'autozone_autos_arg_content_list',$this->Query_Args($args)));
              $autozone_loop = new WP_Query( apply_filters( 'autozone_autos_arg_content_list',$wp_query_args));	
          	//usort($autozone_loop->posts,array( $this, 'pix_sort_auto' ));
          

      		$args_sort = array_map( 'esc_attr', $_GET );
            if(isset($args_sort['order']) && ($args_sort['order'] === '_auto_price-asc' || $args_sort['order'] === '_auto_price-desc' )){
              usort($autozone_loop->posts,array( $this, 'pix_sort_auto' ));
            }else{
             //  $autozone_loop->posts = array_reverse($autozone_loop->posts);
            	 $autozone_loop->posts = array_reverse($autozone_loop->posts, true);  // ДОБАВИЛ ВТОРОЙ АРГУМЕНТ, БЕЗ НЕГО БАГ СОРТИРОВКИ - LUSTIG
            }
   

			/*		if('_auto_make-desc' == $POST_order){

          		usort($autozone_loop->posts, function($a, $b)
				{
				    return (-1)*strcmp($a->post_title, $b->post_title);
				});
          	}elseif('_auto_make-asc' == $POST_order){
          		usort($autozone_loop->posts, function($a, $b)
				{
				    return strcmp($a->post_title, $b->post_title);
				});
          	} */

          	$autozone_loop = apply_filters( 'autozone_ajax_start_loop_autos', $autozone_loop);

            $pixad_out = '';

           if ( $view_type == 'list') {  
            	include( dirname( __FILE__ ) . '/../templates/autos_listing.php' );
             } elseif ($view_type == 'grid'){
                include( dirname( __FILE__ ) . '/../templates/autos_grid.php' );

           }
            include( dirname( __FILE__ ) . '/../templates/autos_carousel.php' );


            wp_send_json_success($pixad_out);

        } elseif( true && in_array('make_model', $keys) ){
            foreach($data as $key=>$val) {
                if( $key == 'make_model' ) {
	                $html = '<li data-val="" class="jelect-option jelect-option_state_active">'.__( 'All Models', 'pixad').'</li>';

	                $make_term = get_term_by('slug', $val, 'auto-model');
	                $terms = get_term_children($make_term->term_id, 'auto-model');
	                if (!empty($terms) && !is_wp_error($terms)) {
						$args = array(
							'taxonomy' => 'auto-model',
							'orderby'       => 'slug',
							'order'         => 'ASC',
							'include'       => $terms,
							'hide_empty' => false,
						);
						$terms_arr = get_terms( $args );
		                foreach ($terms_arr as $k => $v) {
			                //$make_child_term = get_term_by('id', $key_child, 'auto-model');
			                $html .= '<li data-val="'.esc_attr($v->slug).'" class="jelect-option">'.wp_kses_post($v->name).'</li>';
		                }
		                wp_send_json_success($html);
	                }
	                break;
                }
            }
        }
        else
            wp_send_json_error( array( 'error' => $custom_error ) );
    }



    function pix_sort_auto($auto1,$auto2){
      $price1 = INF;
      $price2 = INF;
      $flag1 = 1;
      $flag2 = 1;
      if(!empty( get_post_meta( $auto1->ID, '_auto_price', true ))){
          $var1 = get_post_meta( $auto1->ID, '_auto_price', true );
          if((float)$var1 != 0) {
              $price1 = (float) $var1;
          }elseif($var1 !== ''){
              $price1 = -INF;
              $flag1 = 0;
          }
      }
      if(!empty( get_post_meta( $auto2->ID, '_auto_price', true ))){
          $var2 = get_post_meta( $auto2->ID, '_auto_price', true );
          if((float)$var2 != 0){
              $price2 = (float) $var2;
              }elseif($var2 !== ''){
              $price2 = -INF;
              $flag2 = 0;
          }
      }
      if($flag1){
          if( !empty(get_post_meta( $auto1->ID, '_auto_sale_price', true ))){
              $price1 =  (float) get_post_meta( $auto1->ID, '_auto_sale_price', true );
          }
      }
          if($flag2){
              if( !empty(get_post_meta( $auto2->ID, '_auto_sale_price', true ))){
                      $price2 =  (float) get_post_meta( $auto2->ID, '_auto_sale_price', true );
              }
          }

          $data = array_map( 'esc_attr', $_GET );
          $sort =0;
          if(isset($data['order']) && $data['order'] === '_auto_price-asc') $sort =1;
          elseif(isset($data['order']) && $data['order'] === '_auto_price-desc')$sort =-1;

          if($sort === 1){
              if($price1 < $price2) return -1;
        elseif($price1 > $price2) return 1;
        else return 0;
          }elseif($sort === -1){
              if($price1 < $price2) return 1;
        elseif($price1 > $price2) return -1;
        else return 0;
          }else return 0;
  }
	function pagenavi($max_page, $paged = 1) {
	    $pagenavi_options = array(
	        'pages_text' => '',
	        'current_text' => '%PAGE_NUMBER%',
	        'page_text' => '%PAGE_NUMBER%',
	        'first_text' => wp_kses_post(__('<i class="fa fa-angle-left"></i>','pixad')),
	        'last_text' => wp_kses_post(__('<i class="fa fa-angle-right"></i>','pixad')),
	        'next_text' => wp_kses_post(__('NEXT','pixad')),
	        'prev_text' => wp_kses_post(__('PREV','pixad')),
	        'dotright_text' => esc_html__('...','pixad'),
	        'dotleft_text' => esc_html__('...','pixad'),
	        'style' => 1,
	        'num_pages' => 5,
	        'always_show' => 0,
	        'num_larger_page_numbers' => 3,
	        'larger_page_numbers_multiple' => 10,
	        'use_pagenavi_css' => 1,
	    );

	    $Settings	= new PIXAD_Settings();
		$settings	= $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
	    $posts_per_page = intval($settings['autos_per_page']);

//	    $paged = intval(get_query_var('paged'));
//	    //$max_page = intval($this->max_num_pages);
//
//	    if (empty($paged) || $paged == 0)
//	        $paged = 1;

	    $pages_to_show = intval($pagenavi_options['num_pages']);
	    $larger_page_to_show = intval($pagenavi_options['num_larger_page_numbers']);
	    $larger_page_multiple = intval($pagenavi_options['larger_page_numbers_multiple']);
	    $pages_to_show_minus_1 = $pages_to_show - 1;
	    $half_page_start = floor($pages_to_show_minus_1/2);
	    $half_page_end = ceil($pages_to_show_minus_1/2);
	    $start_page = $paged - $half_page_start;

	    if ($start_page <= 0)
	        $start_page = 1;

	    $end_page = $paged + $half_page_end;
	    if (($end_page - $start_page) != $pages_to_show_minus_1) {
	        $end_page = $start_page + $pages_to_show_minus_1;
	    }

	    if ($end_page > $max_page) {
	        $start_page = $max_page - $pages_to_show_minus_1;
	        $end_page = $max_page;
	    }

	    if ($start_page <= 0)
	        $start_page = 1;

	    $larger_pages_array = array();
	    if ( $larger_page_multiple )
	        for ( $i = $larger_page_multiple; $i <= $max_page; $i += $larger_page_multiple )
	            $larger_pages_array[] = $i;

		$out = '';

	    if ($max_page > 1 || intval($pagenavi_options['always_show'])) {
	        $pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), esc_html__('Page %CURRENT_PAGE% of %TOTAL_PAGES%','pixad'));
	        $pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);
	        $out .= '<ul class="pixad-paging pagination">'."\n";
	        switch(intval($pagenavi_options['style'])) {
	            // Normal
	            case 1:
	                if (!empty($pages_text)) {
	                    //echo '<li><span class="pages">'.$pages_text.'</span></li>';
	                }
	                if ($start_page >= 2 && $pages_to_show < $max_page) {
	                    $first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['first_text']);
	                    $out .= '<li><a href="javascript:void(0);" data-page="'.$max_page.'" class="first pix-ajax-page" title="">'.$first_page_text.'</a></li>';
	                    if (!empty($pagenavi_options['dotleft_text'])) {
	                        $out .= '<li><span class="extend">'.$pagenavi_options['dotleft_text'].'</span></li>';
	                    }
	                }
	                $larger_page_start = 0;
	                foreach($larger_pages_array as $larger_page) {
	                    if ($larger_page < $start_page && $larger_page_start < $larger_page_to_show) {
	                        $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($larger_page), $pagenavi_options['page_text']);
	                        $out .= '<li><a href="javascript;" data-page="'.$larger_page.'" class="page pix-ajax-page" title="'.$page_text.'">'.$page_text.'</a></li>';
	                        $larger_page_start++;
	                    }
	                }
	                if($paged > 1)
	                    $out .= '<li class="arrow"><a href="javascript:void(0);" data-page="'.($paged-1).'" class="previouspostslink pix-ajax-page">'.$pagenavi_options['prev_text'].'</a></li>';
	                for($i = $start_page; $i  <= $end_page; $i++) {
	                    if ($i == $paged) {
	                        $current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
	                        $out .= '<li class="active"><a href="javascript:void(0);">'.$current_page_text.'</a></li>';
	                    } else {
	                        $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
	                        $out .= '<li><a href="javascript:void(0);" data-page="'.$i.'" class="page pix-ajax-page" title="'.$page_text.'">'.$page_text.'</a></li>';
	                    }
	                }
					if($paged < $max_page)
	                $out .= '<li class="arrow"><a href="javascript:void(0);" data-page="'.($paged+1).'" class="nextpostslink pix-ajax-page">'.$pagenavi_options['next_text'].'</a></li>';
	                $larger_page_end = 0;
	                foreach($larger_pages_array as $larger_page) {
	                    if ($larger_page > $end_page && $larger_page_end < $larger_page_to_show) {
	                        $page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($larger_page), $pagenavi_options['page_text']);
	                        $out .= '<li><a href="javascript:void(0);" data-page="'.$larger_page.'" class="page pix-ajax-page" title="'.$page_text.'">'.$page_text.'</a></li>';
	                        $larger_page_end++;
	                    }
	                }
	                if ($end_page < $max_page) {
	                    if (!empty($pagenavi_options['dotright_text'])) {
	                        $out .= '<li><span class="extend">'.$pagenavi_options['dotright_text'].'</span></li>';
	                    }
	                    $last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['last_text']);
	                    $out .= '<li><a href="javascript:void(0);" data-page="'.$max_page.'" class="last pix-ajax-page" title="">'.$last_page_text.'</a></li>';
	                }
	                break;

	        }
	        $out .= '</ul>'."\n";

	    }
	    return $out;
	}


	/**
	 * Search Autos Variations
	 * ======================
	 * @since 0.1
	 * @return array
	 */
	public function Query_Args( $query_args ) {
		$Settings	= new PIXAD_Settings();
		$settings	= $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );

		if( is_array( $query_args ) )
			 extract( $query_args );


		if( empty( $make ) ) 		$make 		= 'all';
		if( empty( $model ) ) 		$model 		= 'all';
		if( empty( $body ) ) 		$body 		= 'all';
		if( empty( $autoyear ) )	$autoyear 	= 'all';
		if( empty( $fuel ) )		$fuel 		= 'all';
		if( empty( $engine ) )		$engine 	= 'all';
		if( empty( $condition ) )	$condition 	= 'all';
		if( empty( $purpose ) )	    $purpose 	= 'all';
		if( empty( $dealer ) )	    $dealer 	= 'all';
		if( empty( $transmission ) )$transmission	= 'all';
		if( empty( $mileage ) ) 	$mileage	= 'all';
		if( empty( $price ) ) 		$price		= 'all';
		if( empty( $auto_id ) ) 	$auto_id	= '';
		if( empty( $per_page ) ) 	$per_page	= $settings['autos_per_page'];
		if( empty( $order ) ) 	    $order	    = 'date';
        if( empty( $long ) ) 	    $long	 = '';
        if( empty( $lat ) ) 	    $lat	 = '';
        if( empty( $radius ) ) 	    $radius	 = '';


        if(isset($query_args['finish_time']) && $query_args['finish_time'] != ''  ) {
            $finish_time	 = $query_args['finish_time'];
        } else {
            $finish_time	 = '';
        }
        if(isset($query_args['start_time']) && $query_args['start_time'] != ''  ) {
            $start_time	 = $query_args['start_time'];
        } else {
            $start_time	 = '';
        }

        $custom_settings_quantity = 1;
        while ($custom_settings_quantity <= 80) {
            if( empty( ${'custom_'.$custom_settings_quantity} ) )		${'custom_'.$custom_settings_quantity}		= 'all';

            $custom_settings_quantity++;
        }
		/**
		 * Fix Paged on Static Homepage
		 * ============================
		 * @since 0.4
		 */
		if( empty( $paged ) && get_query_var('paged') ) {
			$paged = get_query_var('paged');
		}elseif( empty( $paged ) && get_query_var('page') ) {
			$paged = get_query_var('page');
		}elseif ( empty( $paged ) ) {
			$paged = 1;
		}
        ##################################################
        # SEARCH CARS BY RADIUS
        ##################################################
        $this->metaQuery['autoRadius'] = '';
        if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['long'] ) && !empty( $_REQUEST['long'] ) && isset( $_REQUEST['lat'] ) && !empty( $_REQUEST['lat'] ) ) {

        }
	    ##################################################
			# SEARCH CARS BY MAKE
	    ##################################################
	    if(isset( $_REQUEST['order'])){
	      if('date-asc' == $_REQUEST['order']){
	        $this->order = 'ASC';
	        $this->orderby = 'date';
	      }elseif('date-desc' == $_REQUEST['order']){
	        $this->order = 'DESC';
	        $this->orderby = 'date';
	      }
	    }
		##################################################
		# SEARCH CARS BY MAKE
		##################################################
		$this->taxQuery['autoMake'] = '';
		if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['auto-make'] ) && !empty( $_REQUEST['auto-make'] ) ) {
			
			// Store Search Parameters
			$this->tax['taxonomy']	= 'auto-make';
			$this->tax['field']		= 'term_id';
			$this->tax['terms']		= esc_attr( $_REQUEST['auto-make'] );
			
			// Format Tax Query
			$this->taxQuery['autoMake'] = array(
				'taxonomy'	=> $this->tax['taxonomy'], 
				'field' 	=> $this->tax['field'], 
				'terms' 	=> $this->tax['terms']
			);
		}
		##################################################
		# SEARCH CARS BY MODEL
		##################################################
		$this->taxQuery['autoModel'] = '';
		//if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['auto-model'] ) && !empty( $_REQUEST['auto-model'] ) ) {
		if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['auto-model'] ) && !empty( $_REQUEST['auto-model'] ) ) {
				
				// Store Search Parameters
				$this->tax['taxonomy']	= 'auto-model';
				$this->tax['field']		= 'term_id';
				$this->tax['terms']		= esc_attr( $_REQUEST['auto-model'] );
				
				// Format Tax Query
				$this->taxQuery['autoModel'] = array(
					'taxonomy'	=> $this->tax['taxonomy'],
					'field'		=> $this->tax['field'],
					'terms'		=> $this->tax['terms']
				);
		}
		##################################################
		# SEARCH CARS BY BODY
		##################################################
		$this->taxQuery['autoBody'] = '';
		if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['auto-make'] ) && !empty( $_REQUEST['auto-make'] ) ) {
			
			// Store Search Parameters
			$this->tax['taxonomy']	= 'auto-body';
			$this->tax['field']		= 'term_id';
			$this->tax['terms']		= esc_attr( $_REQUEST['auto-body'] );
			
			// Format Tax Query
			$this->taxQuery['autoMake'] = array(
				'taxonomy'	=> $this->tax['taxonomy'], 
				'field' 	=> $this->tax['field'], 
				'terms' 	=> $this->tax['terms']
			);
		}
		##################################################
		# SEARCH CARS BY MADE YEAR FROM
		##################################################
		$this->metaQuery['autoYear'] = '';
		if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['auto-year'] ) && !empty( $_REQUEST['auto-year'] ) && empty( $_REQUEST['auto-year-to'] ) ) {
			// Format Meta Key & Value
			$this->metaKey['autoYear'] = '_auto_year';
			$this->metaVal['autoYear'] = esc_attr( $_REQUEST['auto-year'] );
			// Format Meta Query
			$this->metaQuery['autoYear'] = array( 
				'key'	=> $this->metaKey['autoYear'], 
				'value' => $this->metaVal['autoYear']
			);
		}
		else
		##################################################
		# SEARCH CARS BY MADE YEAR TO
		##################################################
		if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['auto-year-to'] ) && !empty( $_REQUEST['auto-year-to'] ) && empty( $_REQUEST['auto-year'] ) ) {
			
			// Format Meta Query
			$this->metaKey['autoYear'] = '_auto_year';
			$this->metaVal['autoYear'] = esc_attr( $_REQUEST['auto-year-to'] );
			
			// Format Meta Query
			$this->metaQuery['autoYear'] = array(
				'key'		=> $this->metaKey['autoYear'],
				'value'		=> $this->metaVal['autoYear'],
				'compare'	=> '>=',
				'type'		=> 'numeric'
			);
		}
		else
		##################################################
		# IF CAR YEAR FROM && CAR YEAR TO
		##################################################
		if( isset( $_POSt['search-autos'] ) && !empty( $_REQUEST['auto-year'] ) && !empty( $_REQUEST['auto-year-to'] ) ) {
			
			// Format Meta Key
			$this->metaKey['autoYear'] 	= '_auto_year';
			
			// Format Meta Value
			$this->metaVal['autoYear']	= esc_attr( $_REQUEST['auto-year'] );
			$this->metaVal['autoYearTo']	= esc_attr( $_REQUEST['auto-year-to'] );
			
			// Format Meta Query
			$this->metaQuery['autoYear'] = array(
				'key'		=> $this->metaKey['autoYear'],
				'value'		=> array( $this->metaVal['autoYear'], $this->metaVal['autoYearTo'] ),
				'compare'	=> 'BETWEEN',
				'type'		=> 'numeric'
			);
		}
		##################################################
		# SEARCH CARS BY FUEL STATUS - @since v0.7
		##################################################
		$this->metaQuery['autoFuel'] = '';
		if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['auto-fuel'] ) && !empty( $_REQUEST['auto-fuel'] ) ) {
			
			// Format Meta Key & Value
			$this->metaKey['autoFuel'] = '_auto_fuel';
			$this->metaVal['autoFuel'] = esc_attr( $_REQUEST['auto-fuel'] );
			
			// Format Meta Query
			$this->metaQuery['autoFuel'] = array(
				'key'	=> $this->metaKey['autoFuel'],
				'value'	=> $this->metaVal['autoFuel']
			);
		}
        ##################################################
        # SEARCH CARS BY AUTHOR STATUS - @since v0.7
        ##################################################
        if(isset( $_REQUEST['dealer'] ) && !empty( $_REQUEST['dealer'] ) ) {

            $autoDealer = array('author__in'        => array( $dealer ));
        }
		##################################################
		# SEARCH CARS BY CUSTOM FIELDS
		##################################################
		$custom_settings_quantity = 1;
        while ($custom_settings_quantity <= 80) {

				$this->metaQuery['autoCustom_'.$custom_settings_quantity.''] = '';
				if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['custom_'.$custom_settings_quantity.''] ) && !empty( $_REQUEST['custom_'.$custom_settings_quantity.''] ) ) {
				
				// Format Meta Key & Value
				$this->metaKey['autoCustom_'.$custom_settings_quantity.''] = '_custom_'.$custom_settings_quantity.'';
				$this->metaVal['autoCustom_'.$custom_settings_quantity.''] = esc_attr( $_REQUEST['custom_'.$custom_settings_quantity.''] );
	
				// Format Meta Query
				$this->metaQuery['autoCustom_'.$custom_settings_quantity.''] = array(
					'key'	=> $this->metaKey['autoCustom_'.$custom_settings_quantity.''],
				//	'value'	=> $this->metaVal['autoCustom_'.$custom_settings_quantity.'']  
					'value'	=>  str_replace('_', ' ', $this->metaVal['autoCustom_'.$custom_settings_quantity.''])
				);
				}

				$custom_settings_quantity++; 
			}
		##################################################
		# SEARCH CARS BY CONDITION STATUS
		##################################################
		$this->metaQuery['autoCondition'] = '';
		if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['auto-condition'] ) && !empty( $_REQUEST['auto-condition'] ) ) {
			
			// Format Meta Key & Value
			$this->metaKey['autoCondition'] = '_auto_condition';
			$this->metaVal['autoCondition'] = esc_attr( $_REQUEST['auto-condition'] );
			
			// Format Meta Query
			$this->metaQuery['autoCondition'] = array( 
				'key'	=> $this->metaKey['autoCondition'], 
				'value' => $this->metaVal['autoCondition']
			);
			
		}
        ##################################################
		# SEARCH CARS BY PURPOSE
		##################################################
		$this->metaQuery['autoPurpose'] = '';
		if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['auto-purpose'] ) && !empty( $_REQUEST['auto-purpose'] ) ) {
			
			// Format Meta Key & Value
			$this->metaKey['autoPurpose'] = '_auto_purpose';
			$this->metaVal['autoPurpose'] = esc_attr( $_REQUEST['auto-purpose'] );
		
			// Format Meta Query
			$this->metaQuery['autoPurpose'] = array( 
				'key'	=> $this->metaKey['autoPurpose'], 
				'value' => $this->metaVal['autoPurpose'],
			);
		}
		##################################################
		# SEARCH CARS BY PRICE
		##################################################
		$this->metaQuery['autoPrice'] = '';
		if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['auto-price'] ) ) {
			
			// Format Meta Key & Value
			$this->metaKey['autoPrice'] 		= '_auto_price';
			$this->metaVal['autoPrice'] 		= esc_attr( $_REQUEST['auto-price'] );
			
			// Extract lowest & highest prices
			$price = $this->metaVal['autoPrice'];
			$price = explode( ';', $price );
			
			// Save lowest & highest prices into variables
			$this->priceSta = $price[0];
			$this->priceEnd = $price[1];
			
			// Format Meta Query
			$this->metaQuery['autoPrice'] = array(
				'key'		=> $this->metaKey['autoPrice'],
				'value'		=> array( $this->priceSta, $this->priceEnd ),
				'compare'	=> 'BETWEEN',
				'type'		=> 'numeric'
			);
		}
		##################################################
		# SEARCH CARS BY MILEAGE
		##################################################
		$this->metaQuery['autoMileage'] = '';
		if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['auto-mileage'] ) && !empty( $_REQUEST['auto-mileage'] ) ) {
			
			// Format Meta Key & Value
			$this->metaKey['autoMileage'] = '_auto_mileage';
			$this->metaVal['autoMileage'] = esc_attr( $_REQUEST['auto-mileage'] );
			
			// Extract lowest & highest mileages
			$mileage = $this->metaVal['autoMileage'];
			$mileage = explode( ';', $mileage );
			
			// Save lowest & highest mileages into variables
			$this->mileageSta = $mileage[0]; // Mileage start from
			$this->mileageEnd = $mileage[1]; // Mileage end from

			// Format Meta Query
			$this->metaQuery['autoMileage'] = array( 
				'key'		=> $this->metaKey['autoMileage'], 
				'value'		=> array( $this->mileageSta, $this->mileageEnd ), 
				'compare'	=> 'BETWEEN',
				'type'		=> 'numeric'
			);
		}
		##################################################
		# SEARCH CARS BY LOCATION
		##################################################
		$this->metaQuery['autoLocation'] = '';
		if( isset( $_REQUEST['search-autos'] ) && isset( $_REQUEST['auto-location'] ) && !empty( $_REQUEST['auto-location'] ) ) {
			
			// Format Meta Key & Value
			$this->metaKey['autoLocation'] = '_seller_country';
			$this->metaVal['autoLocation'] = esc_attr( $_REQUEST['auto-location'] );
			
			// Format Meta Query
			$this->metaQuery['autoLocation'] = array(
				'key'	=> $this->metaKey['autoLocation'],
				'value'	=> $this->metaVal['autoLocation']
			);
		}
		##################################################
		# LIST CURRENT USER CLASSIFIEDS pixad=my-pixads
		##################################################
		if( isset( $_GET['pixad'] ) && $_GET['pixad'] == 'my-pixads' ) {

			$authors = get_current_user_id();
			$authors = 'post_type=pixad-autos&author='.$authors;

			return $authors;
		}

        $booked = [];

        if(!empty($finish_time) && !empty($start_time)){
            $booked = Pixad_Booking_AUTO::in_period_autos([ 'start-time' => $start_time, 'finish-time' => $finish_time]);

        }elseif(!empty($start_time)){
            $finish_time = $start_time;
            $booked = Pixad_Booking_AUTO::in_period_autos([ 'start-time' => $start_time, 'finish-time' => $finish_time]);
        }elseif(!empty($finish_time)){
            $start_time = $finish_time;
            $booked = Pixad_Booking_AUTO::in_period_autos([ 'start-time' => $start_time, 'finish-time' => $finish_time]);
        }


		$per_page = $this->per_page ? $this->per_page : $per_page;
		//var_dump($_REQUEST['search-autos']);
		// If search button fired, show autos by search parameters
		if( isset( $_REQUEST['search-autos'] ) ) {
			// Format query to output selected autos
			$this->Query = array(
				'post_type'			=> 'pixad-autos',
				'post_status' 		=> 'publish',
				'posts_per_page' 	=> $per_page,
				'orderby' 			=> $this->orderby,
				'order' 			=> $this->order,
				'meta_key' 			=> $this->metakey,
                $autoDealer,
				'tax_query' 		=> array( $this->taxQuery['autoMake'], $this->taxQuery['autoModel'] ),
				'meta_query' 		=> array( 
					$this->metaQuery['autoYear'],
					$this->metaQuery['autoFuel'],
                    $this->metaQuery['autoLong'],
                    $this->metaQuery['autoLat'],
                    $this->metaQuery['autoRadius'],
					$this->metaQuery['autoCustom_1'],
					$this->metaQuery['autoCustom_2'],
					$this->metaQuery['autoCustom_3'],
					$this->metaQuery['autoCustom_4'],
					$this->metaQuery['autoCustom_5'],
					$this->metaQuery['autoCustom_6'],
					$this->metaQuery['autoCustom_7'],
					$this->metaQuery['autoCustom_8'],
					$this->metaQuery['autoCustom_9'],
					$this->metaQuery['autoCustom_10'],
					$this->metaQuery['autoCustom_11'],
					$this->metaQuery['autoCustom_12'],
					$this->metaQuery['autoCustom_13'],
					$this->metaQuery['autoCustom_14'],
					$this->metaQuery['autoCustom_15'],
					$this->metaQuery['autoCustom_16'],
					$this->metaQuery['autoCustom_17'],
					$this->metaQuery['autoCustom_18'],
					$this->metaQuery['autoCustom_19'],
					$this->metaQuery['autoCustom_20'],
					$this->metaQuery['autoCustom_21'],
					$this->metaQuery['autoCustom_22'],
					$this->metaQuery['autoCustom_23'],
					$this->metaQuery['autoCustom_24'],
					$this->metaQuery['autoCustom_25'],
					$this->metaQuery['autoCustom_26'],
					$this->metaQuery['autoCustom_27'],
					$this->metaQuery['autoCustom_28'],
					$this->metaQuery['autoCustom_29'],
					$this->metaQuery['autoCustom_30'],
					$this->metaQuery['autoCustom_31'],
					$this->metaQuery['autoCustom_32'],
					$this->metaQuery['autoCustom_33'],
					$this->metaQuery['autoCustom_34'],
					$this->metaQuery['autoCustom_35'],	
					$this->metaQuery['autoCustom_36'],
					$this->metaQuery['autoCustom_37'],
					$this->metaQuery['autoCustom_38'],
					$this->metaQuery['autoCustom_39'],
					$this->metaQuery['autoCustom_40'],
					$this->metaQuery['autoCustom_41'],
					$this->metaQuery['autoCustom_42'],
					$this->metaQuery['autoCustom_43'],
					$this->metaQuery['autoCustom_44'],
					$this->metaQuery['autoCustom_45'],	
					$this->metaQuery['autoCustom_46'],
					$this->metaQuery['autoCustom_47'],
					$this->metaQuery['autoCustom_48'],
					$this->metaQuery['autoCustom_49'],
					$this->metaQuery['autoCustom_50'],
					$this->metaQuery['autoCustom_51'],
					$this->metaQuery['autoCustom_52'],
					$this->metaQuery['autoCustom_53'],
					$this->metaQuery['autoCustom_54'],
					$this->metaQuery['autoCustom_55'],	
					$this->metaQuery['autoCustom_56'],
					$this->metaQuery['autoCustom_57'],
					$this->metaQuery['autoCustom_58'],
					$this->metaQuery['autoCustom_59'],
					$this->metaQuery['autoCustom_60'],
					$this->metaQuery['autoCustom_61'],
					$this->metaQuery['autoCustom_62'],
					$this->metaQuery['autoCustom_63'],
					$this->metaQuery['autoCustom_64'],
					$this->metaQuery['autoCustom_65'],	
					$this->metaQuery['autoCustom_66'],
					$this->metaQuery['autoCustom_67'],
					$this->metaQuery['autoCustom_68'],
					$this->metaQuery['autoCustom_69'],
					$this->metaQuery['autoCustom_70'],
					$this->metaQuery['autoCustom_71'],
					$this->metaQuery['autoCustom_72'],
					$this->metaQuery['autoCustom_73'],
					$this->metaQuery['autoCustom_74'],
					$this->metaQuery['autoCustom_75'],	
					$this->metaQuery['autoCustom_76'],
					$this->metaQuery['autoCustom_77'],
					$this->metaQuery['autoCustom_78'],
					$this->metaQuery['autoCustom_79'],
					$this->metaQuery['autoCustom_80'],
					$this->metaQuery['autoCondition'],
					$this->metaQuery['autoPurpose'],
					$this->metaQuery['autoPrice'],
					$this->metaQuery['autoMileage'],
					$this->metaQuery['autoLocation'],

				),
				'paged' 			=> $paged,
                'post__not_in'		=>  $booked
			);
			
		} else { // Else if search not fired show all autos


			/**
			 * Auto Make [pixad_autos make='Audi']
			 * ================================
			 * @since 0.4
			 */
			if( $make !== 'all' ) {
				
				// Remove blank space from make
				if( preg_match( '/ /', $make ) )
					$make = str_replace( ' ', '', $make );
				
				// If multiple makes added
				if( preg_match( '/,/', $make ) )
					$make = explode( ',', $make );

				$temp = array();
				if(is_array($make)) {
					$temp = $make;
				} else {
					$temp[] = $make;
				}
				foreach ($temp as $val) {
					$make_term = get_term_by('slug', $val, 'auto-model');
					$terms = get_term_children($make_term->term_id, 'auto-model');
					if (!empty($terms) && !is_wp_error($terms)) {
						foreach ($terms as $key_child) {
							$make_child_term = get_term_by('id', $key_child, 'auto-model');
							$temp[] = $make_child_term->slug;
						}
					}
				}

				$make = $temp;
				
				// Format meta query
				$autoMake = array(
					'taxonomy'	=> 'auto-model',
					'field' 	=> 'slug', 
					'terms' 	=> $make
				);
			}
			/**
			 * Auto Model [pixad_autos model='a4']
			 * ================================
			 * @since 0.4
			 */
			if( $model !== 'all' ) {
				
				// Remove blank space from model
				if( preg_match( '/ /', $model ) )
					$model = str_replace( ' ', '', $model );
				
				// If multiple models added
				if( preg_match( '/,/', $model ) )
					$model = explode( ',', $model );
				
				// Convert string to lowercase
				if( is_array( $model ) ) {
					$model = array_map( 'strtolower', $model );
				}else{
					$model = strtolower( $model );
				}
				
				// Format meta query
				$autoModel = array(
						'taxonomy'	=> 'auto-model',
						'field'		=> 'slug',
						'terms'		=> $model
				);
			}
			/**
			 * Auto Body [pixad_autos body='a4']
			 * ================================
			 * @since 0.4
			 */
			if( $body !== 'all' ) {
				
				// Remove blank space from body
				if( preg_match( '/ /', $body ) )
					$body = str_replace( ' ', '', $body );
				
				// If multiple bodies added
				if( preg_match( '/,/', $body ) )
					$body = explode( ',', $body );
				
				// Convert string to lowercase
				if( is_array( $body ) ) {
					$body = array_map( 'strtolower', $body );
				}else{
					$body = strtolower( $body );
				}
				
				// Format meta query
				$autoModel = array(
					'taxonomy'	=> 'auto-body',
					'field'		=> 'slug',
					'terms'		=> $body
				);
			}
			/**
			 * Auto Year [pixad_autos year='2015']
			 * ================================
			 * @since 0.4
			 */
			if( $autoyear !== 'all' ) {
				
				// Remove blank space from year
				if( preg_match( '/ /', $autoyear ) )
					$autoyear = str_replace( ' ', '', $autoyear );
				
				// If multiple years added
				if( preg_match( '/,/', $autoyear ) ) 
					$autoyear = explode( ',', $autoyear );
				
				// Format meta query
				$autoYear = array(
					'key'	=> '_auto_year',
					'value'	=> $autoyear
				);
			}
			/**
			 * Auto Fuel [pixad_autos fuel='diesel']
			 * =========================================
			 * @since 0.7
			 */
			if( $fuel !== 'all' ) {
				
				// Remove blank space from fuel
				if( preg_match( '/ /', $fuel ) )
					$fuel = str_replace( ' ', '', $fuel );
				
				// If multiple fuel added
				if( preg_match( '/,/', $fuel ) )
					$fuel = explode( ',', $fuel );
				
				// Convert string to lowercase
				if( is_array( $fuel ) ) {
					$fuel = array_map( 'strtolower', $fuel );
				}else{
					$fuel = strtolower( $fuel );
				}
				
				// Format Meta Query
				$autoFuel = array(
					'key'	=> '_auto_fuel',
					'value'	=> $fuel
				);
			}
            /**
             * Auto Long [pixad_autos fuel='diesel']
             * =========================================
             * @since 0.7
             */
            if( $long !== '' && $lat !== '' && $radius !== '') {

                // If multiple fuel added
                if( preg_match( '/,/', $lat ) )
                    $lat = explode( ',', $lat );

                // Remove blank space from fuel
                if( preg_match( '/ /', $long ) )
                    $long = str_replace( ' ', '', $long );

                // If multiple fuel added
                if( preg_match( '/,/', $radius ) )
                    $radius = explode( ',', $radius );

                $query_args = array(
                    'post_type'                 => 'pixad-autos',
                    'post_status'               => 'publish',
                    'posts_per_page'            => -1
                );

                $autos = get_posts($query_args);


                if (is_plugin_active('car-locator/car-locator.php')){
                    foreach ($autos as $value){
                        $autos_long_lat[] = get_post_meta($value->ID, 'pixad_auto_location_pick_with_coordinates');
                    }
                    foreach ($autos_long_lat as $key => $value){
                        if(!empty($value) && $value !=''){
                            foreach ($value as $val){
                                if(!empty($val) && $val !=''){
                                    foreach ($val as $v){
                                        if(!empty($v) && $v !=''){
                                            if(isset($v['name']) && $v['name'] !=''){
                                                $distance = pixba_get_distance($lat, $long,  $v['lattitude'], $v['longitude']);
                                                if($distance < $radius){
                                                    $meta_values_lat[] = $v['lattitude'];
                                                    $meta_values_long[] = $v['longitude'];
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $autoRadius = array(
                        'compare' => 'IN',
                        array(
                            'key'	=> 'pixad_auto_booking_lattitude',
                            'value'	=> $meta_values_lat
                        ),
                        array(
                            'key'	=> 'pixad_auto_booking_longitude',
                            'value'	=> $meta_values_long
                        )
                    );
                } 
            }
		    $custom_settings_quantity = 1;
			while ($custom_settings_quantity <= 80) {

				if( ${'custom_'.$custom_settings_quantity} !== 'all' ) {				
                    // Remove blank space
                    /*if( preg_match( '/ /', ${'custom_'.$custom_settings_quantity} ) )
                        ${'custom_'.$custom_settings_quantity} = str_replace( ' ', '', ${'custom_'.$custom_settings_quantity} );
                    */
                    // If multiple  added
                    if( preg_match( '/,/', ${'custom_'.$custom_settings_quantity} ) )
                        ${'custom_'.$custom_settings_quantity} = explode( ',', ${'custom_'.$custom_settings_quantity} );

                    // Convert string to lowercase
                    if( is_array( ${'custom_'.$custom_settings_quantity} ) ) {
                        ${'custom_'.$custom_settings_quantity} = array_map( 'strtolower', ${'custom_'.$custom_settings_quantity} );
                    }else{
                        ${'custom_'.$custom_settings_quantity} = strtolower( ${'custom_'.$custom_settings_quantity} );
                    }

                    // Format Meta Query
                    ${'autoCustom_'.$custom_settings_quantity} = array(
                        'key'	=> '_custom_'.$custom_settings_quantity.'',
                    //	'value'	=> ${'custom_'.$custom_settings_quantity}
                        'value'	=>  str_replace('_', ' ', ${'custom_'.$custom_settings_quantity})
                    );
                }

				$custom_settings_quantity++; 
			}
			if( $transmission !== 'all' ) {
				
				// Remove blank space from fuel
				if( preg_match( '/ /', $transmission ) )
					$transmission = str_replace( ' ', '', $transmission );
				
				// If multiple fuel added
				if( preg_match( '/,/', $transmission ) )
					$transmission = explode( ',', $transmission );
				
				// Convert string to lowercase
				if( is_array( $transmission ) ) {
					$transmission = array_map( 'strtolower', $transmission );
				}else{
					$transmission = strtolower( $transmission );
				}
				
				// Format Meta Query
				$autoTransmission = array(
					'key'	=> '_auto_transmission',
					'value'	=> $transmission
				);
			}
			/**
			 * Auto Condition [pixad_autos condition='new']
			 * =========================================
			 * @since 0.4
			 */
			if( $condition !== 'all' ) {
				
				// Remove blank space from condition
				if( preg_match( '/ /', $condition ) )
					$condition = str_replace( ' ', '', $condition );
				
				// If multiple conditions added
				if( preg_match( '/,/', $condition ) )
					$condition = explode( ',', $condition );
				
				// Convert string to lowercase
				if( is_array( $condition ) ) {
					$condition = array_map( 'strtolower', $condition );
				}else{
					$condition = strtolower( $condition );
				}
				
				// Format meta query
				$autoCondition = array(
					'key'	=> '_auto_condition',
					'value'	=> $condition
				);
			}
			/**
			 * Auto Purpose [pixad_autos purpose='rent']
			 * =========================================
			 * @since 0.4
			 */
	        if( $purpose !== 'all' ) {

				// Remove blank space from condition
				if( preg_match( '/ /', $purpose ) )
					$purpose = str_replace( ' ', '', $purpose );
				
				// If multiple conditions added
				if( preg_match( '/,/', $purpose ) )
					$purpose = explode( ',', $purpose );
				
				// Convert string to lowercase
				if( is_array( $purpose ) ) {
					$purpose = array_map( 'strtolower', $purpose );
				}else{
					$purpose = strtolower( $purpose );
				}
				
				// Format meta query
				$autoPurpose = array(
					'key'	=> '_auto_purpose',
					'compare' => 'LIKE',
					'value'	=> $purpose
				);
			}

            if( $dealer !== 'all' ) {
                // Format meta query
                $autoDealer_meta = 'author__in';
                $autoDealer = $dealer;
            }else{
                $autoDealer_meta = '';
            }

			if( $autoyear !== 'all' ) {
				
				// Remove blank space from mileage
				if( preg_match( '/ /', $autoyear ) )
					$autoyear = str_replace( ' ', '', $autoyear );
				
				// Remove dot from mileage
				if( preg_match( '/./', $autoyear ) )
					$autoyear = str_replace( '.', '', $autoyear );
				
				// If multiple mileages added
				if( preg_match( '/,/', $autoyear ) )
					$autoyear = explode( ',', $autoyear );
				
				if(is_array($autoyear) && $autoyear[1] >= date('Y') && $autoyear[0] <= $autoyear[1]){
					// Format meta query
					$autoYear = array(
						'key'     => '_auto_year',
						'value'   => $autoyear[0],
						'type'    => 'numeric',
						'compare' => '>='
					);
				}elseif(is_array($autoyear) && $autoyear[1] < date('Y') && $autoyear[0] <= $autoyear[1]) {
					// Format meta query
					$autoYear = array(
							'key' => '_auto_year',
							'value' => $autoyear,
							'type' => 'numeric',
							'compare' => 'BETWEEN'
					);
				}else{
					$autoYear = array(
						'key'     => '_auto_year',
						'value'   => $autoyear[0],
						'type'    => 'numeric',
						'compare' => '>='
					);
				}
				
			}
			/**
			 * Auto Mileage [pixad_autos mileage='120000']
			 * ========================================
			 * @since 0.4
			 */
			if( $mileage !== 'all' ) {
				
				// Remove blank space from mileage
				if( preg_match( '/ /', $mileage ) )
					$mileage = str_replace( ' ', '', $mileage );
				
				// Remove dot from mileage
				if( preg_match( '/./', $mileage ) )
					$mileage = str_replace( '.', '', $mileage );
				
				// If multiple mileages added
				if( preg_match( '/,/', $mileage ) )
					$mileage = explode( ',', $mileage );
				
				if(is_array($mileage) && $mileage[1] >= 500000 && $mileage[0] <= $mileage[1]){
					// Format meta query
					$autoMileage = array(
						'key'     => '_auto_mileage',
						'value'   => $mileage[0],
						'type'    => 'numeric',
						'compare' => '>='
					);
				}elseif(is_array($mileage) && $mileage[1] < 500000 && $mileage[0] <= $mileage[1]) {
					// Format meta query
					$autoMileage = array(
							'key' => '_auto_mileage',
							'value' => $mileage,
							'type' => 'numeric',
							'compare' => 'BETWEEN'
					);
				}else{
					$autoMileage = array(
						'key'     => '_auto_mileage',
						'value'   => $mileage[0],
						'type'    => 'numeric',
						'compare' => '>='
					);
				}
				
			}
			
			if( $engine !== 'all' ) {
				
				// Remove blank space from mileage
				if( preg_match( '/ /', $engine ) )
					$engine = str_replace( ' ', '', $engine );

				// If multiple mileages added
				if( preg_match( '/,/', $engine ) )
					$engine = explode( ',', $engine );
				
				if(is_array($engine) && $engine[1] >= 7 && $engine[0] <= $engine[1]){
					// Format meta query
					$autoEngine = array(
						'key'     => '_auto_engine',
						'value'   => $engine[0],
						'type'    => 'numeric',
						'compare' => '>='
					);
				}elseif(is_array($engine) && $engine[1] < 7 && $engine[0] <= $engine[1]) {
					// Format meta query
					$autoEngine = array(
							'key' => '_auto_engine',
							'value' => $engine,
							'type' => 'numeric',
							'compare' => 'BETWEEN'
					);
				}else{
					$autoEngine = array(
						'key'     => '_auto_engine',
						'value'   => $engine[0],
						'type'    => 'numeric',
						'compare' => '>='
					);
				}
				
			}
			/**
			 * Auto Price [pixad_autos price='15000']
			 * ===================================
			 * @since 0.4
			 */
			if( $price !== 'all' ) {
				
				// Remove blank space from price
				if( preg_match( '/ /', $price ) )
					$price = str_replace( ' ', '', $price );
				
				// Remove dot from price
				if( preg_match( '/./', $price ) )
					$price = str_replace( '.', '', $price );
				
				// If multiple prices added
				if( preg_match( '/,/', $price ) )
					$price = explode( ',', $price );

				if(is_array($price) && $price[1] >= $settings['autos_max_price'] && $price[0] <= $price[1]){
					// Format meta query
					$autoPrice = array(
						'key'     => '_auto_price',
						'value'   => $price[0],
						'type'    => 'numeric',
						'compare' => '>='
					);
				}elseif(is_array($price) && $price[1] < $settings['autos_max_price'] && $price[0] <= $price[1]) {
					// Format meta query
					$autoPrice = array(
							'key' => '_auto_price',
							'value' => $price,
							'type' => 'numeric',
							'compare' => 'BETWEEN'
					);
				}else{
					$autoPrice = array(
						'key'     => '_auto_price',
						'value'   => $price[0],
						'type'    => 'numeric',
						'compare' => '>='
					);
				}
			}
			$autoMake		= isset( $autoMake ) ? $autoMake : '';
			$autoModel		= isset( $autoModel ) ? $autoModel : '';
			$autoEngine	    = isset( $autoEngine ) ? $autoEngine : '';
			$autoEngine	    = isset( $autoEngine ) ? $autoEngine : '';
			$autoYear		= isset( $autoYear ) ? $autoYear : '';
			$autoFuel		= isset( $autoFuel ) ? $autoFuel : '';
			$autoCondition	= isset( $autoCondition ) ? $autoCondition : '';
			$autoPurpose	= isset( $autoPurpose ) ? $autoPurpose : '';
			$autoDealer	     = isset( $autoDealer ) ? $autoDealer : '';
			$autoTransmission= isset( $autoTransmission ) ? $autoTransmission : '';
			$autoMileage	= isset( $autoMileage ) ? $autoMileage : '';
			$autoPrice		= isset( $autoPrice ) ? $autoPrice : '';
			$autoRadius		= isset( $autoRadius ) ? $autoRadius : '';

			$custom_settings_quantity = 1;
			while ($custom_settings_quantity <= 80) {
				${'autoCustom_'.$custom_settings_quantity}		= isset( ${'autoCustom_'.$custom_settings_quantity} ) ? ${'autoCustom_'.$custom_settings_quantity} : '';
				$custom_settings_quantity++; 
			}
						



            //$booked = Pixad_Booking_AUTO::in_period_autos([ 'start-time' => '1/06/2020 23:52', 'finish-time' => '6/06/2020 23:52']);
            // print_r($this->orderby);
			// Format query to output all autos
			$this->Query = array(
				'post_type' 		=> 'pixad-autos',
				'post_status' 		=> 'publish',
				'p'                 => $auto_id,
				'posts_per_page' 	=> $per_page,
				'orderby' 			=> $this->orderby,
				'order' 			=> $this->order,
				'meta_key' 			=> $this->metakey,
				'tax_query'			=> array( $autoMake, $autoModel ),
                $autoDealer_meta    => $autoDealer,
				'meta_query'		=> array(
					$autoYear,
					$autoFuel,
                    $autoRadius,
					$autoCustom_1,
					$autoCustom_2,
					$autoCustom_3,
					$autoCustom_4,
					$autoCustom_5,
					$autoCustom_6,
					$autoCustom_7,
					$autoCustom_8,
					$autoCustom_9,
					$autoCustom_10,
					$autoCustom_11,
					$autoCustom_12,
					$autoCustom_13,
					$autoCustom_14,
					$autoCustom_15,
					$autoCustom_16,
					$autoCustom_17,
					$autoCustom_18,
					$autoCustom_19,
					$autoCustom_10,		
					$autoCustom_21,
					$autoCustom_22,
					$autoCustom_23,
					$autoCustom_24,
					$autoCustom_25,
					$autoCustom_26,
					$autoCustom_27,
					$autoCustom_28,
					$autoCustom_29,
					$autoCustom_30,		
					$autoCustom_31,
					$autoCustom_32,
					$autoCustom_33,
					$autoCustom_34,
					$autoCustom_35,	
					$autoCustom_36,
					$autoCustom_37,
					$autoCustom_38,
					$autoCustom_39,
					$autoCustom_40,	
					$autoCustom_41,
					$autoCustom_42,
					$autoCustom_43,
					$autoCustom_44,
					$autoCustom_45,	
					$autoCustom_46,
					$autoCustom_47,
					$autoCustom_48,
					$autoCustom_49,
					$autoCustom_50,
					$autoCustom_51,
					$autoCustom_52,
					$autoCustom_53,
					$autoCustom_54,
					$autoCustom_55,	
					$autoCustom_56,
					$autoCustom_57,
					$autoCustom_58,
					$autoCustom_59,
					$autoCustom_60,
					$autoCustom_61,
					$autoCustom_62,
					$autoCustom_63,
					$autoCustom_64,
					$autoCustom_65,	
					$autoCustom_66,
					$autoCustom_67,
					$autoCustom_68,
					$autoCustom_69,
					$autoCustom_70,
					$autoCustom_71,
					$autoCustom_72,
					$autoCustom_73,
					$autoCustom_74,
					$autoCustom_75,	
					$autoCustom_76,
					$autoCustom_77,
					$autoCustom_78,
					$autoCustom_79,
					$autoCustom_80,			
					$autoCondition,
					$autoPurpose,
					$autoMileage,
					$autoEngine,
					$autoTransmission,
					$autoPrice,
				),
				'paged' 			=> $paged,
				'post__not_in'		=> $booked
			);
			
		}

		return $this->Query;
	}
	
	/**
	 * Loop auto make's in text loop
	 * OUTPUT: eg: Audi, BMW ...
	 * 
	 * @return array
	 */
	 public function loop_make() {

		$tax_terms = get_terms( 
			'auto-model',
			'orderby=name&order=ASC&hide_empty=0&hierarchical=0'
		);

		if( ! empty( $tax_terms ) && ! is_wp_error( $tax_terms ) ) {
			foreach ( $tax_terms as $tax_term ) {
				
				// Loop only parent terms
				if( $tax_term->parent == '0' ) {
					$terms[] = $tax_term;
				}
			}
		
			return $terms;
		}
	 }
	
	/**
	 * Loop auto model's in text loop
	 * OUTPUT: A4, X5 ...
	 *
	 * @return array
	 */
	 public function loop_model() {

		$tax_terms = get_terms(
			'auto-model',
			'orderby=name&order=ASC&hide_empty=0&hierarchical=0'
		);

		if( ! empty( $tax_terms ) && ! is_wp_error( $tax_terms ) ) {
			foreach ( $tax_terms as $tax_term ) {
				
				// Loop only child terms
				if( $tax_term->parent !== '0' ) {
					$terms[] = $tax_term;
				}

			}
			return $terms;
		}
	 }
	 
	/**
	 * Loop auto year in number loop
	 * OUTPUT: 1930, 1931 ...
	 *
	 * @return array
	 */
	 public function year() {
		$numbers = range( 2018, 1930 );
	
		foreach( $numbers as $number ) {
			$array[] = $number;
		}
		
		return $array;
	 }
	 
	/**
	 * Get auto make on single post (Frontend)
	 *
	 * @return array
	 */
	 public function get_make() {
		global $post;
		
		$args = array(
			'orderby'	=> 'name',
			'order'		=> 'ASC',
			'fields'	=> 'all'
		);
		
		$tax_terms = wp_get_post_terms($post->ID, 'auto-model', $args);
		
		foreach ($tax_terms as $tax_term) {
			
			// Loop only parent terms
			if( $tax_term->parent == '0' ) {
				return  $tax_term->name;
			}
			
		}
	 }
	 
	/**
	 * Get auto model on single post (Frontend)
	 * 
	 * @return array
	 */
	 public function get_model() {
		global $post;
		
		$args = array(
			'orderby'	=> 'name',
			'order'		=> 'ASC',
			'fields'	=> 'all'
		);
		
		$tax_terms = wp_get_post_terms($post->ID, 'auto-model', $args);
		
		foreach ($tax_terms as $tax_term) {
			
			// Loop only child terms
			if( $tax_term->parent ) {
				return  $tax_term->name;
			}
			
		}
	 }
	 
	/**
	 * Get auto meta details (Frontend)
	 * Loop (if ID provided) else Single pages
	 * 
	 * @return string
	 */
	public function get_meta( $key ) {
		return sanitize_text_field( get_post_meta( get_the_ID(), $key, true ) );
	}
	
	/**
	 * Get properly formated auto price
	 * ===============================
	 * @since 0.4
	 */
	public function get_price( $price = NULL ) {
		$Settings	= new PIXAD_Settings();
		$settings	= $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
		$currencies = unserialize( get_option( '_pixad_autos_currencies' ) ); // Get currencies from database
		$options = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
	   if (function_exists('icl_register_string')) {
          $text_after = apply_filters( 'wpml_translate_single_string', $options['autos_price_text'], 'pixad', $options['autos_price_text']); 
       }else{
          $text_after = isset($options['autos_price_text']) ? $options['autos_price_text'] : '';
       }

		$auto_currency	= $this->get_meta('_auto_currency'); // Get auto currency
		
		// If auto price not specified, let's pull price from database
		$auto_price = isset( $price ) ? $price : $this->get_meta('_auto_price');
		$auto_sale_price = $this->get_meta('_auto_sale_price');

		if( !empty($auto_price) && !is_numeric($auto_price) ){
			return $auto_price;
		}

		// If auto price not set, set by default 100
		if( empty( $auto_price ) ) $auto_price = 100;
		
		// Format price like 100,00$auto_sale_price_format$auto_sale_price_format
		$auto_price = number_format($auto_price, $settings['autos_decimal_number'], "{$settings['autos_decimal']}", "{$settings['autos_thousand']}");
		$auto_sale_price_format = $auto_sale_price ? number_format($auto_sale_price, $settings['autos_decimal_number'], "{$settings['autos_decimal']}", "{$settings['autos_thousand']}") : '';
		
		// Take only currency we are interest in and get details from it

		$currency = $currencies[$settings['autos_site_currency']];
		
		// If currency symbol or position missing let's set default ones
		if( !$currency['symbol'] ) $currency['symbol'] = '';
		if( !$currency['position'] ) $currency['position'] = 'right';
		
		// Format auto price & currency output
		switch( $currency['position'] ):
		
			case $currency['position'] == 'left':
				 $price = $currency['symbol'].$auto_price;
				 $auto_sale_price_format = $currency['symbol'].$auto_sale_price_format;
			break;
			
			case $currency['position'] == 'right':
				 $price = $auto_price.$currency['symbol'];
				 $auto_sale_price_format = $auto_sale_price_format.$currency['symbol'];
			break;
			
			case $currency['position'] == 'left_space':
				 $price = $currency['symbol'].' '.$auto_price;
				 $auto_sale_price_format = $currency['symbol'].' '.$auto_sale_price_format;
			break;
			
			case $currency['position'] == 'right_space':
				 $price = $auto_price.' '.$currency['symbol'];
				 $auto_sale_price_format = $auto_sale_price_format.' '.$currency['symbol'];
			break;
		
		endswitch; 
		// $price = $auto_price;

		if($auto_sale_price != ''){
			$price = '<span class="auto-sale-price"><del>'.$price.'</del>&nbsp;</span>'.$auto_sale_price_format;
		}

		return $price.'<span class="after-price-text">'.$text_after.'</span>';
	}
	
	/**
	 * Get Meta Minimum && Maximum Values
	 * Loop Trough PostMeta, Take All Values
	 * & Return Min & Max Values
	 *
	 * @since 0.3
	 * @return array
	 */
	public function get_meta_min_max( $meta_key ) {
		global $wpdb;
		
		$meta_val = $wpdb->get_col( $wpdb->prepare(
			"
			SELECT meta_value 
			FROM $wpdb->postmeta 
			WHERE meta_key = %s
			",
			$meta_key
		) );
		
		// If found results into database
		if( !empty( $meta_val[0] ) ) {
			foreach( $meta_val as $values ) {
				$value[] = $values;
			}
			
			$value = array_filter( $value ); // Filter array
			
			// Take value min & max values
			$value_min = min( $value );
			$value_max = max( $value );
		}

		// If price min empty
		if( empty( $value_min ) ) {
			$value_min = '1';
		}

		// If price max empty
		if( empty( $value_max ) ) {
			$value_max = '500000';
		}

		return array(
			'min' => $value_min,
			'max' => $value_max
		);
	}

} 
global $PIXAD_Autos;
$PIXAD_Autos = new PIXAD_Autos();
?>