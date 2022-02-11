<?php
// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

/**
 * My Profile Widget
 *
 * @since 0.1
 */
class Pixad_Auto_Widget_By_Make extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct( 'pixad_auto_widget_by_make', __( 'Auto: By Make', 'pixad' ), array( 'description' => __( 'Filter autos by make.', 'pixad' ), ) );
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		global $post;

        $type = isset($instance['type']) && $instance['type'] == 'select' ? 'jelect' : 'check';

		?>
		<section class="widget block_content widget_mod-a pixad-filter" data-type="<?php echo esc_attr($type); ?>" data-field="make">
		<?php if( empty( $args['before_title'] ) ): ?>
			<h3 class="widget-title">
			<span>
		<?php endif; ?>

		<?php
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'].apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
		}
		?>

		<?php if( empty( $args['before_title'] ) ): ?>
			</span>
			</h3>
			<div class="decor-1"></div>
		<?php endif; ?>

		<div class="widget-content">

			<?php
			$args_tax = array(
				'taxonomy'      => array( 'auto-model' ),
				'orderby'       => 'name',
				'order'         => 'ASC',
				'parent'        => '0',
				'hide_empty'    => '0',

			);
			$autos_categories = get_categories ($args_tax);

			if( isset($instance['type']) && $instance['type'] == 'select') {
			    $all_make_class = !isset($_REQUEST['make']) ? 'jelect-option_state_active' : '';
			    $all_model_class = !isset($_REQUEST['model']) ? 'jelect-option_state_active' : '';
			    $out_make  = __( 'All Makes', 'pixad');
			    $out_model = __( 'All Models', 'pixad');
			    $out_makes = $out_models = '';
			    $get_make = isset($_REQUEST['make']) ? explode(',', $_REQUEST['make']) : array();
			    $get_model = isset($_REQUEST['model']) ? explode(',', $_REQUEST['model']) : array();

                foreach ($autos_categories as $auto_cat) :
                    if( in_array($auto_cat->slug, $get_make) ){
                        $class_make = 'jelect-option_state_active';
                        $out_make = $auto_cat->name;
                    } else {
                        $class_make = '';
                    }
                    $out_makes .= '<li data-val="'.esc_attr($auto_cat->slug).'" class="jelect-option '.esc_attr($class_make).'">'.wp_kses_post($auto_cat->name).'</li>';
                endforeach;
            ?>
                <div  class="select select_mod-a jelect pixad-makes-models-select">
                    <input data-type="jelect" data-field="make" id="ajax-make" name="ajax-make" value="" data-text="imagemin" type="text" class="jelect-input">
                    <div tabindex="0" role="button" class="jelect-current"><?php echo wp_kses_post($out_make) ?></div>
                    <ul class="jelect-options">
                        <li data-val="" class="jelect-option <?php echo esc_attr($all_make_class) ?>"><?php _e( 'All Makes', 'pixad') ?></li>
                        <?php echo ($out_makes) ?>
                    </ul>
                </div>
                <?php
                if(!empty($get_make)){
                    $make_term = get_term_by('slug', $get_make[0], 'auto-model');

                    if (is_object($make_term)) {
                    	$parent_args = $make_term->term_id;
                    }else{
                    	$parent_args ='';
                    }
                    


                //    print_r($make_term);
                    $args = array(
                        'taxonomy'      => 'auto-model',
                        'orderby'       => 'name',
                        'order'         => 'ASC',
                        'parent'        => $parent_args,
                        'hide_empty'    => false,
                    );
                    $terms_arr = get_terms( $args );
                    foreach ($terms_arr as $k => $v) {
                        if( in_array($v->slug, $get_model) ){
                            $class_model = 'jelect-option_state_active';
                            $out_model = $v->name;
                        } else {
                            $class_model = '';
                        }
                        $out_models .= '<li data-val="'.esc_attr($v->slug).'" class="jelect-option '.esc_attr($class_model).'">'.wp_kses_post($v->name).'</li>';
                    }
                }
                ?>
                <div class="select select_mod-a jelect">
                    <input data-type="jelect" data-field="model" id="pixad-model" name="pixad-model" value="" data-text="imagemin" type="text" class="jelect-input">
                    <input type="hidden" class="pixad-model-default-hidden" value="<?php esc_attr_e( 'All Models', 'pixad') ?>">
                    <div tabindex="0" role="button" class="jelect-current pixad-model"><?php echo wp_kses_post($out_model) ?></div>
                    <ul class="jelect-options pixad-model">
                        <li data-val="" class="jelect-option <?php echo esc_attr($all_model_class) ?>"><?php _e( 'All Models', 'pixad') ?></li>
                        <?php echo ($out_models) ?>
                    </ul>
                </div>
			<?php
            } else {
				$autos_categories = get_categories ($args_tax);
                if ($autos_categories):
                    echo '<ul class="list-categories list-unstyled">';
                    $get_make = isset($_REQUEST['make']) ? explode(',', $_REQUEST['make']) : array();
                    foreach ($autos_categories as $auto_cat) :
                        ?>
                        <li class="list-categories__item">
                            <input data-type="check" data-field="make"
                                   type="checkbox" <?php echo in_array($auto_cat->slug, $get_make) ? 'checked' : ''; ?>
                                   name="pixad-make" id="<?php echo esc_attr($auto_cat->slug) ?>"
                                   value="<?php echo esc_attr($auto_cat->slug) ?>">
                            <label for="<?php echo esc_attr($auto_cat->slug) ?>"><?php echo wp_kses_post($auto_cat->name) ?></label>
                        </li>
                        <?php
                        $args_tax_sub = array(
							'taxonomy'      => array( 'auto-model' ),
							'child_of'      => $auto_cat->term_id,
							'hide_empty'    => '0',
						);
						$autos_categories_sub = get_categories ($args_tax_sub);
						if ($autos_categories_sub):
							echo '<ul class="list-categories sub-categories list-unstyled">';
							foreach ($autos_categories_sub as $auto_cat_sub) :
							?>
							<li class="list-categories__item">
								<input data-type="check" data-field="make"
									   type="checkbox" <?php echo in_array($auto_cat_sub->slug, $get_make) ? 'checked' : ''; ?>
									   name="pixad-make" id="<?php echo esc_attr($auto_cat_sub->slug) ?>"
									   value="<?php echo esc_attr($auto_cat_sub->slug) ?>">
								<label for="<?php echo esc_attr($auto_cat_sub->slug) ?>"><?php echo wp_kses_post($auto_cat_sub->name) ?></label>
							</li>
							<?php
							endforeach;
							echo '</ul>';
						endif;
                    endforeach;
                    echo '</ul>';
                    //echo '<a class="list-categories__more" href="javascript:void(0);">'.__( 'VIEW MORE', 'pixad' ).'</a>';
                endif;
            }
			?>

		</div>
		</section>
		<?php

	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : __( 'By Make', 'pixad' );
		$type = isset( $instance['type'] ) ? $instance['type'] : 'list';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'pixad' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e( 'Filter Type:', 'pixad' ); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>">
                <option value="list" <?php selected( $type, 'list', true ); ?>><?php _e( 'List of makes', 'pixad' ); ?></option>
                <option value="select" <?php selected( $type, 'select', true ); ?>><?php _e( 'Makes and models selects', 'pixad' ); ?></option>
            </select>
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['type'] = ( ! empty( $new_instance['type'] ) ) ? strip_tags( $new_instance['type'] ) : 'list';

		return $instance;
	}
}

class Pixad_Auto_Widget_Filter extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct( 'pixad_auto_widget_filter', __( 'Auto: Filter', 'pixad' ), array( 'description' => __( 'Filter autos by price, body type, fuel, transmission.', 'pixad' ), ) );
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		global $post;
		$Settings	= new PIXAD_Settings();
		$settings	= $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
		$currency = pixad_get_currencies($settings['autos_site_currency']);
		$before_title = $args['before_title'];
		$after_title = $args['after_title'];


		// $pixad_time_finish = $_REQUEST['finish_time'];
		if ( array_key_exists("start_time",$_REQUEST) ) {
			$pixad_time_start  = $_REQUEST['start_time'];
		} else {
			$pixad_time_start  =  __('Pick-up date', 'pixad');
		}

		if ( array_key_exists("finish_time",$_REQUEST)) {
			$pixad_time_finish  = $_REQUEST['finish_time'];
		} else {
			$pixad_time_finish  =  __('Drop-off date', 'pixad');
		}

// LUSTIG ADD
 		// $price = $instance[ 'price' ] ? 'true' : 'false';

// END LUSTIG ADD




		?>
		<div class="wrap-filter">
						<?php if(!empty($instance['booking_time'])) { ?>
				<section class="widget block_content widget_mod-a pixad-filter" data-type="jelect" data-field="time">
			<?php
				if (!empty($instance['booking_time_title'])) {
					echo $before_title . apply_filters('widget_title', $instance['booking_time_title']) . $after_title;
				}
				?>

					<div class="widget-content">
						<div  class="select select_mod-a jelect">
							<input data-type="jelect" data-field="start_time" id="pixad-start_time" name="pixad-start_time" value="" data-text="imagemin" type="text" class="pix-input-time" value="<?php echo current_time('d/m/Y H:i:s');?>" placeholder="<?php esc_attr_e( $pixad_time_start, 'pixad') ?>"  readonly="readonly">
						</div>
						<div  class="select select_mod-a jelect">
							<input data-type="jelect" data-field="finish_time" id="pixad-finish_time" name="pixad-finish_time" value="" data-text="imagemin" type="text" class="pix-input-time" value="<?php echo current_time('d/m/Y H:i:s'); ?>" placeholder="<?php esc_attr_e( $pixad_time_finish, 'pixad') ?>" readonly="readonly">
						</div>
					</div>
				</section>
			<?php } ?>
		
		    <?php
			if($instance['year']) {
			?>
				<section class="widget block_content widget_mod-a pixad-filter" data-type="number" data-field="autoyear">
                    <?php
                        if (!empty($instance['year_title'])) {
                            echo $before_title . apply_filters('widget_title', $instance['year_title']) . $after_title;
                            $get_year = isset($_REQUEST['autoyear']) ? explode(',',$_REQUEST['autoyear']) : array();
                        }
                    ?>
					<div class="widget-content">
						<div class="slider-price" id="slider-year"></div>
						<span class="slider-price__wrap-input">
							<input data-type="number" data-field="autoyear" class="slider-price__input" id="slider-year_min" name="pixad-autoyear">
							<span>-</span>
							<input data-type="number" data-field="autoyear" class="slider-price__input" id="slider-year_max" name="pixad-autoyear">
							<input type="hidden" id="pix-min-year" value="<?php echo isset($get_year[0]) ? esc_attr($get_year[0]) : ''; ?>">
							<input type="hidden" id="pix-max-year" value="<?php echo isset($get_year[1]) ? esc_attr($get_year[1]) : ''; ?>">
							<input type="hidden" id="pix-min-slider-year" value="<?php echo esc_attr($settings['autos_min_year']) ?>">
							<input type="hidden" id="pix-max-slider-year" value="<?php echo esc_attr(date('Y')+1) ?>">
						</span>
					</div>
				</section>
			<?php
			}
			?>
			<?php
			if($instance['price']) {
			?>
				<section class="widget block_content widget_mod-a pixad-filter" data-type="number" data-field="price">
			<?php
                if(!empty($instance['price_style']) && $instance['price_style'] == 'style_one'){

				if (!empty($instance['price_title'])) {
					echo $before_title . apply_filters('widget_title', $instance['price_title']) . $after_title;
					$get_price = isset($_REQUEST['price']) ? explode(',',$_REQUEST['price']) : array();
				}
            ?>
					<div class="widget-content">
						<div class="slider-price" id="slider-price"></div>
						<span class="slider-price__wrap-input">
							<input data-type="number" data-field="price" class="slider-price__input" id="slider-price_min" name="pixad-price">
							<span>-</span>
							<input data-type="number" data-field="price" class="slider-price__input" id="slider-price_max" name="pixad-price">
							<input type="hidden" id="pix-min-price" value="<?php echo isset($get_price[0]) ? esc_attr($get_price[0]) : ''; ?>">
							<input type="hidden" id="pix-max-price" value="<?php echo isset($get_price[1]) ? esc_attr($get_price[1]) : ''; ?>">
							<input type="hidden" id="pix-max-slider-price" value="<?php echo esc_attr($settings['autos_max_price']) ?>">
							<input type="hidden" id="pix-currency-symbol" value="<?php echo esc_attr($currency['symbol']) ?>">
							
							<input type="hidden" id="pix-thousand" value="<?php echo esc_attr($settings['autos_thousand']) ?>">
							<input type="hidden" id="pix-decimal" value="<?php echo esc_attr($settings['autos_decimal']) ?>">
							<input type="hidden" id="pix-decimal_number" value="<?php echo esc_attr($settings['autos_decimal_number']) ?>">
						</span>
					</div>
				</section>
			<?php
			    } elseif (!empty($instance['price_style']) && $instance['price_style'] == 'style_two'){
                    if (!empty($instance['price_title'])) {
                        echo $before_title . apply_filters('widget_title', $instance['price_title']) . $after_title;
                        $get_price = isset($_REQUEST['price']) ? explode(',',$_REQUEST['price']) : array();
                    }
                    ?>
                    <div class="widget-content">
                        <div class="slider-price" id="slider-price-two"></div>
                        <span class="slider-price__wrap-input">
							<input data-type="number" data-field="price" class="slider-price__input" id="slider-price_min-two" name="pixad-price" value="0">
							<input type="hidden" data-type="number" data-field="price" class="slider-price__input" id="slider-price_max-two" name="pixad-price">
							<input type="hidden" id="pix-min-price-two" value="<?php echo isset($get_price[0]) ? esc_attr($get_price[0]) : ''; ?>">
							<input type="hidden" id="pix-max-price-two" value="<?php echo isset($get_price[1]) ? esc_attr($get_price[1]) : ''; ?>">
							<input type="hidden" id="pix-max-slider-price-two" value="<?php echo esc_attr($settings['autos_max_price']) ?>">
							<input type="hidden" id="pix-currency-symbol" value="<?php echo esc_attr($currency['symbol']) ?>">

							<input type="hidden" id="pix-thousand-two" value="<?php echo esc_attr($settings['autos_thousand']) ?>">
							<input type="hidden" id="pix-decimal-two" value="<?php echo esc_attr($settings['autos_decimal']) ?>">
							<input type="hidden" id="pix-decimal_number-two" value="<?php echo esc_attr($settings['autos_decimal_number']) ?>">
						</span>
                    </div>
                    </section>

            <?php    }
            }
			?>


<?php

$Settings = new PIXAD_Settings();
$settings	= $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
$validate = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_validation', true ); 
$validate = pixad::validation( $validate );

$args = array( 'post_type' => 'pixad-autos', 'posts_per_page' => -1,); 
$rand_posts = get_posts( $args );

$custom_settings_quantity = 1;
while ($custom_settings_quantity <= 80) {
	${'_custom_'.$custom_settings_quantity.'_setting_value'} = array();
		$custom_settings_quantity++; 
}
foreach( $rand_posts as $post ) : ?>
	<?php  
	$custom_settings_quantity = 1;
	while ($custom_settings_quantity <= 80) {
			
			$_custom_setting_key = get_post_custom_values('_custom_'.$custom_settings_quantity.''); // Получили  характеристику
			if ($_custom_setting_key[0] !== '') {    // Проверили или есть значение у характеристики
				 $_custom_setting_key[0] = str_replace(' ', '_', $_custom_setting_key[0]);
				array_push(${'_custom_'.$custom_settings_quantity.'_setting_value'}, $_custom_setting_key[0]); // Добавили значение в нужный массив 
			}

		//	print_r(${'_custom_'.$custom_settings_quantity.'_setting_value'});
			$custom_settings_quantity++; 
	} ?>
	
<?php endforeach; ?>
<?php  wp_reset_postdata() ?>

<?php 
$custom_settings_quantity = 1;
while ($custom_settings_quantity <= 80) {
	${'_custom_'.$custom_settings_quantity.'_setting_value'} = array_unique(array_filter(${'_custom_'.$custom_settings_quantity.'_setting_value'}));
?> 

<?php if(!empty(${'_custom_'.$custom_settings_quantity.'_setting_value'}) && $instance['custom_'.$custom_settings_quantity.'']) {?>

		<section class="widget block_content widget_mod-a pixad-filter" data-type="jelect" data-field="<?php echo 'custom_'. $custom_settings_quantity .''; ?>">
				<?php echo $before_title . apply_filters('widget_title', $validate['custom_'. $custom_settings_quantity .'_name']) . $after_title; ?>
					<div class="widget-content">
						<div  class="select select_mod-a jelect">
							<input data-type="jelect" data-field="<?php echo 'custom_'. $custom_settings_quantity .''; ?>" id="<?php echo 'pixad-custom_'. $custom_settings_quantity .''; ?>" name="<?php echo 'pixad-custom_'. $custom_settings_quantity .''; ?>" value="" data-text="imagemin" type="text" class="jelect-input">
							<div tabindex="0" role="button" class="jelect-current"><?php echo $validate['custom_'. $custom_settings_quantity .'_name']; ?></div>
							<ul class="jelect-options">
								<li data-val="" class="jelect-option jelect-option_state_active"><?php esc_html_e( 'All', 'pixad') ?></li>
							<?php
								foreach (${'_custom_'.$custom_settings_quantity.'_setting_value'} as $key => $value) {?>
								<!--	<li data-val="<?php echo $value; ?>" class="jelect-option"><?php echo $value; ?></li> -->
										<li data-val="<?php echo $value; ?>" class="jelect-option"><?php echo str_replace('_', ' ', $value); ?></li> 
							<?php } ?>
						  </ul>
						</div>
					</div>
		</section>
<?php }?>

	<?php	$custom_settings_quantity++; 
}?>


			<?php
			if($instance['body']) {
			?>
				<section class="widget block_content widget_mod-a pixad-filter" data-type="check" data-field="body">
			<?php
				if (!empty($instance['body_title'])) {
					echo $before_title . apply_filters('widget_title', $instance['body_title']) . $after_title;
				}
				$args_tax = array( 'taxonomy' => 'auto-body', 'hide_empty' => '1');
				$autos_bodies = get_categories ($args_tax);
				if( $autos_bodies ):
					$get_body = isset($_REQUEST['body']) ? explode(',',$_REQUEST['body']) : array();
					echo '<div class="widget-content">
							<ul class="list-categories body-categories list-unstyled">';
					foreach($autos_bodies as $auto_body) :
						?>
						<li class="list-categories__item">
							<input data-type="check" data-field="body" type="checkbox" <?php echo in_array($auto_body->slug, $get_body) ? 'checked' : ''; ?> name="pixad-body" id="<?php echo esc_attr($auto_body->slug) ?>" value="<?php echo esc_attr($auto_body->slug) ?>">
							<label for="<?php echo esc_attr($auto_body->slug) ?>">
								<?php
				$auto_t_id = $auto_body->term_id;
				$auto_cat_meta = get_option("auto_body_$auto_t_id");
				$auto_cat_thumb_url = get_option("pixad_body_thumb$auto_t_id");
				$auto_cat_thumb_filter_url = get_option("pixad_body_thumb_filter$auto_t_id");
$dir = plugin_dir_path( __DIR__ );
				$figure = '<img src="../wp-content/plugins/pix-auto-deal/assets/img/no_image.jpg" alt="'.esc_attr($auto_body->name).'">';;

				if($auto_cat_thumb_filter_url){
					$img_src = wp_get_attachment_image_src( attachment_url_to_postid( $auto_cat_thumb_filter_url ), 'autozone-body-thumb' );
					$figure = '<img src="'.esc_url($img_src[0]).'" alt="'.esc_attr($auto_body->name).'">';

				}elseif($auto_cat_thumb_url){
					$img_src = wp_get_attachment_image_src( attachment_url_to_postid( $auto_cat_thumb_url ), 'autozone-body-thumb' );
					$figure = '<img src="'.esc_url($img_src[0]).'" alt="'.esc_attr($auto_body->name).'">';
				} elseif(isset($auto_cat_meta['pixad_body_icon']) && $auto_cat_meta['pixad_body_icon'] != ''){
					$figure = '<i class="icon'. esc_attr($auto_cat_meta['pixad_body_icon']) .'"></i>';
				}?>
                <div class="body-icon-wrapper">
								<?php echo wp_kses_post($figure) ?>
								</div>
								<span class="auto_body_name"><?php echo wp_kses_post($auto_body->name) ?></span>
                            
                            </label>
						</li>
						<?php
					endforeach;
					echo '</ul>
					</div>';
				endif;
				?>
				</section>
			<?php
			}
			?>
			<?php
			if($instance['fuel']) {
			?>
				<section class="widget block_content widget_mod-a pixad-filter" data-type="jelect" data-field="fuel">
			<?php
				if (!empty($instance['fuel_title'])) {
					echo $before_title . apply_filters('widget_title', $instance['fuel_title']) . $after_title;
				}
				?>
					<div class="widget-content">
						<div  class="select select_mod-a jelect">
							<input data-type="jelect" data-field="fuel" id="pixad-fuel" name="pixad-fuel" value="" data-text="imagemin" type="text" class="jelect-input">
							<div tabindex="0" role="button" class="jelect-current"><?php esc_html_e( 'All Fuel Types', 'pixad') ?></div>
							<ul class="jelect-options">
								<li data-val="" class="jelect-option jelect-option_state_active"><?php esc_html_e( 'All Fuel Types', 'pixad') ?></li>
								<li data-val="petrol" class="jelect-option"><?php esc_html_e( 'Petrol', 'pixad') ?></li>
								<li data-val="gasoline" class="jelect-option"><?php esc_html_e( 'Gasoline', 'pixad') ?></li>
								<li data-val="diesel" class="jelect-option"><?php esc_html_e( 'Diesel', 'pixad') ?></li>
								<li data-val="hybrid" class="jelect-option"><?php esc_html_e( 'Hybrid', 'pixad') ?></li>
								<li data-val="plugin_electric" class="jelect-option"><?php esc_html_e( 'Plugin electric', 'pixad') ?></li>
								<li data-val="electric" class="jelect-option"><?php esc_html_e( 'Electric', 'pixad') ?></li>
								<li data-val="petrol+cng" class="jelect-option"><?php esc_html_e( 'Petrol+CNG', 'pixad') ?></li>
								<li data-val="lpg" class="jelect-option"><?php esc_html_e( 'LPG', 'pixad') ?></li>
							</ul>
						</div>
					</div>
				</section>
			<?php
			}
			?>
			<?php
			if($instance['transmission']) {
			?>
				<section class="widget block_content widget_mod-a pixad-filter" data-type="jelect" data-field="transmission">
			<?php
				if (!empty($instance['transmission_title'])) {
					echo $before_title . apply_filters('widget_title', $instance['transmission_title']) . $after_title;
				}
				?>
					<div class="widget-content">
						<div  class="select select_mod-a jelect">
							<input data-type="jelect" data-field="transmission" id="pixad-transmission" name="pixad-transmission" value="" data-text="imagemin" type="text" class="jelect-input">
							<div tabindex="0" role="button" class="jelect-current"><?php esc_html_e( 'All Transmissions', 'pixad') ?></div>
							<ul class="jelect-options">
								<li data-val="" class="jelect-option jelect-option_state_active"><?php esc_html_e( 'All Transmissions', 'pixad') ?></li>
								<li data-val="automatic" class="jelect-option"><?php esc_html_e( 'Automatic', 'pixad') ?></li>
								<li data-val="manual" class="jelect-option"><?php esc_html_e( 'Manual', 'pixad') ?></li>
								<li data-val="semi-automatic" class="jelect-option"><?php esc_html_e( 'Semi-Automatic', 'pixad') ?></li>
							</ul>
						</div>
					</div>
				</section>
			<?php
			}
			?>

			<?php
			if($instance['mileage']) {
			?>
				<section class="widget block_content widget_mod-a pixad-filter" data-type="number" data-field="mileage">
			<?php
				if (!empty($instance['mileage_title'])) {
					echo $before_title . apply_filters('widget_title', $instance['mileage_title']) . $after_title;
					$get_mileage = isset($_REQUEST['mileage']) ? explode(',',$_REQUEST['mileage']) : array();
				}
				?>
					<div class="widget-content">
						<div class="slider-price" id="slider-mileage"></div>
						<span class="slider-price__wrap-input">
							<input data-type="number" data-field="mileage" class="slider-price__input" id="slider-mileage_min" name="pixad-mileage">
							<span>-</span>
							<input data-type="number" data-field="mileage" class="slider-price__input" id="slider-mileage_max" name="pixad-mileage">
							<input type="hidden" id="pix-min-mileage" value="<?php echo isset($get_mileage[0]) ? esc_attr($get_mileage[0]) : ''; ?>">
							<input type="hidden" id="pix-max-mileage" value="<?php echo isset($get_mileage[1]) ? esc_attr($get_mileage[1]) : ''; ?>">
							<input type="hidden" id="pix-max-slider-mileage" value="500000">
						</span>
					</div>
				</section>
			<?php
			}
			?>

			<?php
			if($instance['engine']) {
			?>
				<section class="widget block_content widget_mod-a pixad-filter" data-type="number" data-field="engine">
			<?php
				if (!empty($instance['engine_title'])) {
					echo $before_title . apply_filters('widget_title', $instance['engine_title']) . $after_title;
					$get_engine = isset($_REQUEST['engine']) ? explode(',',$_REQUEST['engine']) : array();
				}
				?>
					<div class="widget-content">
						<div class="slider-price" id="slider-engine"></div>
						<span class="slider-price__wrap-input">
							<input data-type="number" data-field="engine" class="slider-price__input" id="slider-engine_min" name="pixad-engine">
							<span>-</span>
							<input data-type="number" data-field="engine" class="slider-price__input" id="slider-engine_max" name="pixad-engine">
							<input type="hidden" id="pix-min-engine" value="<?php echo isset($get_engine[0]) ? esc_attr($get_engine[0]) : ''; ?>">
							<input type="hidden" id="pix-max-engine" value="<?php echo isset($get_engine[1]) ? esc_attr($get_engine[1]) : ''; ?>">
							<input type="hidden" id="pix-max-slider-engine" value="7">
						</span>
					</div>
				</section>
			<?php
			}
			?>
			<?php
			if($instance['condition']) {
			?>
				<section class="widget block_content widget_mod-a pixad-filter" data-type="jelect" data-field="condition">
			<?php
				if (!empty($instance['condition_title'])) {
					echo $before_title . apply_filters('widget_title', $instance['condition_title']) . $after_title;
				}
				?>
					<div class="widget-content">
						<div  class="select select_mod-a jelect">
							<input data-type="jelect" data-field="condition" id="pixad-condition" name="pixad-condition" value="" data-text="imagemin" type="text" class="jelect-input">
							<div tabindex="0" role="button" class="jelect-current"><?php esc_html_e( 'All Conditions', 'pixad') ?></div>
							<ul class="jelect-options">
								<li data-val="" class="jelect-option jelect-option_state_active"><?php esc_html_e( 'All Conditions', 'pixad') ?></li>
								<li data-val="new" class="jelect-option"><?php esc_html_e( 'New', 'pixad') ?></li>
								<li data-val="used" class="jelect-option"><?php esc_html_e( 'Used', 'pixad') ?></li>
								<li data-val="driver" class="jelect-option"><?php esc_html_e( 'Driver', 'pixad') ?></li>
								<li data-val="non driver" class="jelect-option"><?php esc_html_e( 'Non driver', 'pixad') ?></li>
								<li data-val="projectcar" class="jelect-option"><?php esc_html_e( 'Projectcar', 'pixad') ?></li>
								<li data-val="barnfind" class="jelect-option"><?php esc_html_e( 'Barnfind', 'pixad') ?></li>
							</ul>
						</div>
					</div>
				</section>
			<?php
			}
			?>

			<?php
			if($instance['purpose']) {
			?>
				<section class="widget block_content widget_mod-a pixad-filter" data-type="jelect" data-field="purpose">
			<?php
				if (!empty($instance['purpose_title'])) {
					echo $before_title . apply_filters('widget_title', $instance['purpose_title']) . $after_title;
				}
				?>
					<div class="widget-content">
						<div  class="select select_mod-a jelect">
							<input data-type="jelect" data-field="purpose" id="pixad-purpose" name="pixad-purpose" value="" data-text="imagemin" type="text" class="jelect-input">
							<div tabindex="0" role="button" class="jelect-current"><?php esc_html_e( 'All purposes', 'pixad') ?></div>
							<ul class="jelect-options">
								<li data-val="" class="jelect-option jelect-option_state_active"><?php esc_html_e( 'All purposes', 'pixad') ?></li>
								<li data-val="rent" class="jelect-option"><?php esc_html_e( 'Rent', 'pixad') ?></li>
								<li data-val="Selling" class="jelect-option"><?php esc_html_e( 'Selling', 'pixad') ?></li>
								<li data-val="sold" class="jelect-option"><?php esc_html_e( 'Sold', 'pixad') ?></li>
							</ul>
						</div>
					</div>
				</section>
			<?php
			}
			?>



		</div>

		<div class="btn">
			<div class="btn-filter wrap__btn-skew-r js-filter">
				<?php
					$path = '';
					if(substr_count($_SERVER['REQUEST_URI'], '/page/') > 0){
						$path = preg_split('/\/page\//', $_SERVER['REQUEST_URI']);
						$path = $path[0].'/';
					}else{
						$path = preg_split('/\?/', $_SERVER['REQUEST_URI']);
						$path = $path[0];
					}
				?>
				<button data-href="<?php echo esc_url($_SERVER['SERVER_NAME'] . $path)?>" id="pixad-reset-button" class="btn-skew-r btn-effect"><span class="btn-skew-r__inner"><?php echo wp_kses_post($instance['btn_title']) ?></span></button>

			</div>
		</div>

		<?php
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$price = isset( $instance['price'] ) ? $instance['price'] : 'on';
		$price_style = isset( $instance['price_style'] ) ? $instance['price_style'] : 'style_one';
		$price_title = ! empty( $instance['price_title'] ) ? $instance['price_title'] : __( 'Price Range', 'pixad' );
		$body = isset( $instance['body'] ) ? $instance['body'] : 'on';
		$body_title = ! empty( $instance['body_title'] ) ? $instance['body_title'] : __( 'Vehicle Body Type', 'pixad' );
		$fuel = isset( $instance['fuel'] ) ? $instance['fuel'] : 'on';
		$fuel_title = ! empty( $instance['fuel_title'] ) ? $instance['fuel_title'] : __( 'Fuel Type', 'pixad' );
		$mileage = isset( $instance['mileage'] ) ? $instance['mileage'] : 'on';
		$mileage_title = ( ! empty( $instance['mileage_title'] ) ) ? $instance['mileage_title'] : __( 'Mileage Range', 'pixad' );
		$year = isset( $instance['year'] ) ? $instance['year'] : 'on';
		$year_title = ! empty( $instance['year_title'] ) ? $instance['year_title'] : __( 'Year Range', 'pixad' );
		$transmission = isset( $instance['transmission'] ) ? $instance['transmission'] : 'on';
		$transmission_title = ! empty( $instance['transmission_title'] ) ? $instance['transmission_title'] : __( 'Transmission Range', 'pixad' );
		$engine = isset( $instance['engine'] ) ? $instance['engine'] : 'on';
		$engine_title = ! empty( $instance['engine_title'] ) ? $instance['engine_title'] : __( 'Engine Volume', 'pixad' );
		$condition = isset( $instance['condition'] ) ? $instance['condition'] : 'on';
		$condition_title = ! empty( $instance['condition_title'] ) ? $instance['condition_title'] : __( 'Condition', 'pixad' );

		$purpose = isset( $instance['purpose'] ) ? $instance['purpose'] : 'on';
		$purpose_title = ! empty( $instance['purpose_title'] ) ? $instance['purpose_title'] : __( 'Purpose', 'pixad' );

		$booking_time = ( ! empty( $new_instance['booking_time'] ) ) ?  $new_instance['booking_time'] : 'on';
		$booking_time_title = ! empty( $instance['booking_time_title'] ) ? $instance['booking_time_title'] : __( 'Booking Time', 'pixad' );
		$btn_title = ! empty( $instance['btn_title'] ) ? $instance['btn_title'] : __( 'Filter Vehicles', 'pixad' );

	$custom_settings_quantity = 1;
		while ($custom_settings_quantity <= 80) {
			${'custom_'.$custom_settings_quantity} = isset( $instance['custom_'.$custom_settings_quantity.''] ) ? $instance['custom_'.$custom_settings_quantity.''] : 'on';
			$custom_settings_quantity++; 
		}







		?>
		 <p>
			<input class="checkbox" id="<?php echo $this->get_field_id( 'booking_time' ); ?>" name="<?php echo $this->get_field_name( 'booking_time' ); ?>" type="checkbox" <?php checked( $booking_time ); ?>>
			<label for="<?php echo $this->get_field_id( 'booking_time' ); ?>"><?php _e( 'Show Booking Time Type:' ); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'booking_time_title' ); ?>"><?php _e( 'Booking Time Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'booking_time_title' ); ?>" name="<?php echo $this->get_field_name( 'booking_time_title' ); ?>" type="text" value="<?php echo esc_attr( $booking_time_title ); ?>">
		</p> 
		<p> 
        <input class="checkbox" id="<?php echo $this->get_field_id( 'price' ); ?>" name="<?php echo $this->get_field_name( 'price' ); ?>" type="checkbox" <?php checked( $instance[ 'price' ], 'on' ); ?>>

			<label for="<?php echo $this->get_field_id( 'price' ); ?>"><?php _e( 'Show Price Range:' ); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'price_title' ); ?>"><?php _e( 'Price Block Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'price_title' ); ?>" name="<?php echo $this->get_field_name( 'price_title' ); ?>" type="text" value="<?php echo esc_attr( $price_title ); ?>">
		</p>
        <p>
            <label for="<?php echo $this->get_field_id( 'price_style' ); ?>"><?php _e( 'Price Style:' ); ?></label>
            <select class="widefat" id="widget-pixad_auto_widget_by_make-2-type" name="<?php echo $this->get_field_name( 'price_style' ); ?>">
                <?php if($price_style == 'style_one'){?>
                    <option value="style_one" <?php echo 'selected';?>><?php echo esc_html('Style one');?></option>
                <?php } else { ?>
                    <option value="style_one"><?php echo esc_html('Style one');?></option>
                <?php } ?>

                <?php if($price_style == 'style_two'){?>
                    <option value="style_two" <?php echo 'selected';?>><?php echo esc_html('Style two');?></option>
                <?php } else { ?>
                    <option value="style_two"><?php echo esc_html('Style two');?></option>
                <?php } ?>
            </select>
        </p>
		<p>
			<input class="checkbox" id="<?php echo $this->get_field_id( 'body' ); ?>" name="<?php echo $this->get_field_name( 'body' ); ?>" type="checkbox" <?php checked( $instance[ 'body' ], 'on' ); ?>>
			<label for="<?php echo $this->get_field_id( 'body' ); ?>"><?php _e( 'Show Vehicle Body Type:' ); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'body_title' ); ?>"><?php _e( 'Vehicle Body Type Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'body_title' ); ?>" name="<?php echo $this->get_field_name( 'body_title' ); ?>" type="text" value="<?php echo esc_attr( $body_title ); ?>">
		</p>
		<p>
			<input class="checkbox" id="<?php echo $this->get_field_id( 'fuel' ); ?>" name="<?php echo $this->get_field_name( 'fuel' ); ?>" type="checkbox" <?php checked( $instance[ 'fuel' ], 'on' ); ?>>
			<label for="<?php echo $this->get_field_id( 'fuel' ); ?>"><?php _e( 'Show Fuel Type:' ); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'fuel_title' ); ?>"><?php _e( 'Fuel Type Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'fuel_title' ); ?>" name="<?php echo $this->get_field_name( 'fuel_title' ); ?>" type="text" value="<?php echo esc_attr( $fuel_title ); ?>">
		</p>
		<p>
			<input class="checkbox" id="<?php echo $this->get_field_id( 'mileage' ); ?>" name="<?php echo $this->get_field_name( 'mileage' ); ?>" type="checkbox" <?php checked( $instance[ 'mileage' ], 'on' ); ?>>
			<label for="<?php echo $this->get_field_id( 'mileage' ); ?>"><?php _e( 'Show Mileage Range:' ); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'mileage_title' ); ?>"><?php _e( 'Mileage Block Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'mileage_title' ); ?>" name="<?php echo $this->get_field_name( 'mileage_title' ); ?>" type="text" value="<?php echo esc_attr( $mileage_title ); ?>">
		</p>
		<p>
			<input class="checkbox" id="<?php echo $this->get_field_id( 'year' ); ?>" name="<?php echo $this->get_field_name( 'year' ); ?>" type="checkbox" <?php checked( $instance[ 'year' ], 'on' ); ?>>
			<label for="<?php echo $this->get_field_id( 'year' ); ?>"><?php _e( 'Show Year Range:' ); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'year_title' ); ?>"><?php _e( 'Year Range Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'year_title' ); ?>" name="<?php echo $this->get_field_name( 'year_title' ); ?>" type="text" value="<?php echo esc_attr( $year_title ); ?>">
		</p>
		<p>
			<input class="checkbox" id="<?php echo $this->get_field_id( 'transmission' ); ?>" name="<?php echo $this->get_field_name( 'transmission' ); ?>" type="checkbox" <?php checked( $instance[ 'transmission' ], 'on' ); ?>>
			<label for="<?php echo $this->get_field_id( 'transmission' ); ?>"><?php _e( 'Show Transmission Type:' ); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'transmission_title' ); ?>"><?php _e( 'Transmission Type Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'transmission_title' ); ?>" name="<?php echo $this->get_field_name( 'transmission_title' ); ?>" type="text" value="<?php echo esc_attr( $transmission_title ); ?>">
		</p>


		<p>
			<input class="checkbox" id="<?php echo $this->get_field_id( 'engine' ); ?>" name="<?php echo $this->get_field_name( 'engine' ); ?>" type="checkbox" <?php checked( $instance[ 'engine' ], 'on' ); ?>>
			<label for="<?php echo $this->get_field_id( 'engine' ); ?>"><?php _e( 'Show Engine Volume:' ); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'engine_title' ); ?>"><?php _e( 'Engine Volume Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'engine_title' ); ?>" name="<?php echo $this->get_field_name( 'engine_title' ); ?>" type="text" value="<?php echo esc_attr( $engine_title ); ?>">
		</p>
		<p>
			<input class="checkbox" id="<?php echo $this->get_field_id( 'condition' ); ?>" name="<?php echo $this->get_field_name( 'condition' ); ?>" type="checkbox" <?php checked( $instance[ 'condition' ], 'on' ); ?>>
			<label for="<?php echo $this->get_field_id( 'condition' ); ?>"><?php _e( 'Show Condition:' ); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'condition_title' ); ?>"><?php _e( 'Condition Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'condition_title' ); ?>" name="<?php echo $this->get_field_name( 'condition_title' ); ?>" type="text" value="<?php echo esc_attr( $condition_title ); ?>">
		</p>


		<p>
			<input class="checkbox" id="<?php echo $this->get_field_id( 'purpose' ); ?>" name="<?php echo $this->get_field_name( 'purpose' ); ?>" type="checkbox" <?php checked( $instance[ 'purpose' ], 'on' ); ?>>
			<label for="<?php echo $this->get_field_id( 'purpose' ); ?>"><?php _e( 'Show purpose:' ); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'purpose_title' ); ?>"><?php _e( 'Purpose Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'purpose_title' ); ?>" name="<?php echo $this->get_field_name( 'purpose_title' ); ?>" type="text" value="<?php echo esc_attr( $purpose_title ); ?>">
		</p>




<?php
global $post;
$Settings = new PIXAD_Settings();
$settings	= $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
$validate = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_validation', true ); 
$validate = pixad::validation( $validate );

$args = array( 'post_type' => 'pixad-autos', 'posts_per_page' => -1,); 
$rand_posts = get_posts( $args );

$custom_settings_quantity = 1;
while ($custom_settings_quantity <= 80) {
	${'_custom_'.$custom_settings_quantity.'_setting_value'} = array();
		$custom_settings_quantity++; 
}
foreach( $rand_posts as $post ) : ?>
	<?php  
	$custom_settings_quantity = 1;
	while ($custom_settings_quantity <= 80) {
			
			$_custom_setting_key = get_post_custom_values('_custom_'.$custom_settings_quantity.''); // Получили характеристику
			if ($_custom_setting_key[0] !== '') {    // Проверили или есть значение у характеристики
				array_push(${'_custom_'.$custom_settings_quantity.'_setting_value'}, $_custom_setting_key[0]); // Добавили значение в нужный массив 
			}
			$custom_settings_quantity++; 
	} ?>
	
<?php endforeach; ?>
<?php wp_reset_postdata() ?>

<?php  

$custom_settings_quantity = 1;
while ($custom_settings_quantity <= 80) {
	${'_custom_'.$custom_settings_quantity.'_setting_value'} = array_unique(array_filter(${'_custom_'.$custom_settings_quantity.'_setting_value'}));
?> 

<?php if(!empty(${'_custom_'.$custom_settings_quantity.'_setting_value'}) && $validate['custom_'. $custom_settings_quantity .'_show']) {?>

				<p>
					<input class="checkbox" id="<?php echo $this->get_field_id( 'custom_'.$custom_settings_quantity.'' ); ?>" name="<?php echo $this->get_field_name( 'custom_'.$custom_settings_quantity.'' ); ?>" type="checkbox" 
						   <?php  checked( $instance[ 'custom_'.$custom_settings_quantity.'' ], 'on' ); 
						  // checked( ${'custom_'.$custom_settings_quantity} ); 
						   ?>>
					<label for="<?php echo $this->get_field_id( 'custom_'.$custom_settings_quantity.'' ); ?>">
						<?php echo 'Show '.$validate['custom_'. $custom_settings_quantity .'_name'] ?>:	
					</label>
				</p>

		<?php 	}

			$custom_settings_quantity++; 
		}
 ?>



		<p>
			<label for="<?php echo $this->get_field_id( 'btn_title' ); ?>"><?php _e( 'Button Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'btn_title' ); ?>" name="<?php echo $this->get_field_name( 'btn_title' ); ?>" type="text" value="<?php echo esc_attr( $btn_title ); ?>">
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['price'] = $new_instance['price'];
		$instance['price_style'] = $new_instance['price_style'];
		$instance['price_title'] = ( ! empty( $new_instance['price_title'] ) ) ? strip_tags( $new_instance['price_title'] ) : '';
		$instance['body'] = $new_instance['body'];
		$instance['body_title'] = ( ! empty( $new_instance['body_title'] ) ) ? strip_tags( $new_instance['body_title'] ) : '';
		$instance['fuel'] = $new_instance['fuel'];
		$instance['fuel_title'] = ( ! empty( $new_instance['fuel_title'] ) ) ? strip_tags( $new_instance['fuel_title'] ) : '';
        $instance['mileage'] = $new_instance['mileage'];
		$instance['mileage_title'] = ( ! empty( $new_instance['mileage_title'] ) ) ? strip_tags( $new_instance['mileage_title'] ) : '';
		$instance['year'] = $new_instance['year'];
		$instance['year_title'] = ( ! empty( $new_instance['year_title'] ) ) ? strip_tags( $new_instance['year_title'] ) : '';
		$instance['transmission'] = $new_instance['transmission'];
		$instance['transmission_title'] = ( ! empty( $new_instance['transmission_title'] ) ) ? strip_tags( $new_instance['transmission_title'] ) : '';
		$instance['engine'] = $new_instance['engine'];
		$instance['engine_title'] = ( ! empty( $new_instance['engine_title'] ) ) ? strip_tags( $new_instance['engine_title'] ) : '';
		$instance['condition'] = $new_instance['condition'];
		$instance['condition_title'] = ( ! empty( $new_instance['condition_title'] ) ) ? strip_tags( $new_instance['condition_title'] ) : '';

		$instance['purpose'] = $new_instance['purpose'];
		$instance['purpose_title'] = ( ! empty( $new_instance['purpose_title'] ) ) ? strip_tags( $new_instance['purpose_title'] ) : '';

		$instance['booking_time'] = ( ! empty( $new_instance['booking_time'] ) ) ? strip_tags( $new_instance['booking_time'] ) : '';
		$instance['booking_time_title'] = ( ! empty( $new_instance['booking_time_title'] ) ) ? strip_tags( $new_instance['booking_time_title'] ) : '';
		$instance['btn_title'] = ( ! empty( $new_instance['btn_title'] ) ) ? strip_tags( $new_instance['btn_title'] ) : '';

		$custom_settings_quantity = 1;
		while ($custom_settings_quantity <= 80) {
			$instance['custom_'.$custom_settings_quantity.''] = $new_instance['custom_'.$custom_settings_quantity.''];
			$custom_settings_quantity++; 
		}

		return $instance;
	}
}



class Pixad_Auto_Widget_User_Account extends WP_Widget {

    function __construct() {
        parent::__construct( 'pixad_auto_widget_user_account', __( 'Auto: Account', 'pixad' ), array( 'description' => __( 'Show users links.', 'pixad' ), ) );
    }

    public function widget( $args, $instance ) {
        $Settings = new PIXAD_Settings();
        $options	= $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_settings', true );
        $auto_sell_page = isset($options['autos_sell_car_page']) ? $options['autos_sell_car_page'] : false;
        $auto_listing_page = isset($options['autos_listing_car_page']) ? $options['autos_listing_car_page'] : false;
        $auto_my_page = isset($options['autos_my_cars_page']) ? $options['autos_my_cars_page'] : false;
        $auto_my_page = isset($options['autos_my_cars_page']) ? $options['autos_my_cars_page'] : false;
        $auto_update_page = isset($options['autos_update_car_page']) ? $options['autos_update_car_page'] : false;
        

        $user_autos = array();
        if (is_user_logged_in()){
            $uargs = array(
                'author' => get_current_user_id(),
                'post_type' => 'pixad-autos',
                'post_status' => 'publish'
            );
            $user_autos = get_posts($uargs);
        }


        ?>
        <section class="widget block_content widget_mod-a widget_dealer">
            <h4 class="widget-title"><span><?php echo wp_kses_post($instance['main_title']) ?></span></h4>
            <div class="decor-1"></div>
            <div class="widget-content">
                <ul>
                    <?php if (!count($user_autos)):?>
                        <li class="wd-msg"><?php echo esc_html_e("You don't have any cars","pixad")?></li>
                    <?php endif; ?>
                    <?php foreach ($user_autos as $user_auto): $auto_update_page = get_edit_post_link($user_auto->ID);?>
                        <li>
                            <a class="wd-image" href="<?php echo esc_url(get_the_permalink($user_auto->ID))?>">
                                <img src="<?php echo esc_url(get_the_post_thumbnail_url($user_auto->ID))?>"/>
                            </a>
                            <span class="wd-name"><?php echo esc_attr($user_auto->post_title)?></span>
                             <a class="wd-update" href="<?php echo esc_url($auto_update_page); ?>"><?php echo esc_html_e('Edit')?></a>
                        </li>
                    <?php endforeach;?>
                   
                </ul>
                
                 <?php if ($auto_sell_page):?>
                       
                           <div class="wd-auto_sell_page_btn"><a class="wd-auto_sell_page btn" href="<?php echo esc_url(get_page_link($auto_sell_page))?>"><?php echo esc_html_e("Add your car","pixad")?></a></div> 
                     
                    <?php endif; ?>
            </div>
        </section>
        <?php

    }

    public function form( $instance ) {
        $title = ! empty( $instance['main_title'] ) ? $instance['main_title'] : __( 'My Acount', 'pixad' );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'main_title' ); ?>"><?php _e( 'Widget Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'main_title' ); ?>" name="<?php echo $this->get_field_name( 'main_title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['main_title'] = ( ! empty( $new_instance['main_title'] ) ) ? strip_tags( $new_instance['main_title'] ) : '';
        return $instance;
    }
}



class WP_Widget_Search_Car extends WP_Widget {

	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_search_car',
			'description' => __( 'A search car form for your site.' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'search_car', _x( 'Auto: Search', 'Search car widget' ), $widget_ops );
	}


	public function widget( $args, $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		echo $args['before_widget'];
		if ( $title ) {
			 echo $args['before_title'] . $title . $args['after_title'];
		}

		
		function auto_search_form( $form ) {
    $form = '<form  method="get" id="search-global-form-car" action="'. home_url( '/' ) .'">';
    $form .= '<input type="text"  name="s" id="search-car" value="'.  esc_attr(the_search_query()) .'" /><input type="hidden" name="post_type" value="pixad-autos" />';

    $form .= '</form>';
    return $form;
}
		add_filter( 'get_search_form', 'auto_search_form' );
get_search_form();
remove_filter( 'get_search_form', 'auto_search_form' );
		
	
		
		
		
		
		echo $args['after_widget'];
	}


	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = $instance['title'];
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<?php
	}

	
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args((array) $new_instance, array( 'title' => ''));
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		return $instance;
	}

}







/**
 * Register Widget
 *
 * @since 1.0
 */
function register_pixad_auto_filter_widgets() {
    register_widget( 'Pixad_Auto_Widget_By_Make' );
    register_widget( 'Pixad_Auto_Widget_Filter' );
    register_widget( 'Pixad_Auto_Widget_User_Account' );
	 register_widget( 'WP_Widget_Search_Car' );
}
add_action( 'widgets_init', 'register_pixad_auto_filter_widgets' );
?>