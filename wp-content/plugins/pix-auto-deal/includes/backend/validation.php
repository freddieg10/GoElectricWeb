<?php 
	$Settings = new PIXAD_Settings();
	$options  = $Settings->getSettings( 'WP_OPTIONS', '_pixad_autos_validation', true );

// $options = pixad::validation( $options);

	
	$allSettings = PIXAD_Settings::getAllSettings();

	    foreach ($allSettings as $_stg => $val){
        $options[$_stg . '_req']		= isset( $options[$_stg . '_req'] ) ? $options[$_stg . '_req'] : '';
        $options[$_stg . '_show']		= isset( $options[$_stg . '_show'] ) ? $options[$_stg . '_show'] : '';
        $options[$_stg . '_side']		= isset( $options[$_stg . '_side'] ) ? $options[$_stg . '_side'] : '';
        $options[$_stg . '_list']		= isset( $options[$_stg . '_list'] ) ? $options[$_stg . '_list'] : '';
        $options[$_stg . '_icon']		= isset( $options[$_stg . '_icon'] ) ? $options[$_stg . '_icon'] : '';
        $_POST[$_stg . '_def']			= isset( $_POST[$_stg . '_def'] ) ? $_POST[$_stg . '_def'] : '';
    }

  		$custom_settings_quantity = 1;
  		while ($custom_settings_quantity <= 80) {
  		$_POST['custom_'.$custom_settings_quantity.'_name']			= isset( $_POST['custom_'.$custom_settings_quantity.'_name'] ) ? $_POST['custom_'.$custom_settings_quantity.'_name'] : '';  

       	$options['custom_'.$custom_settings_quantity.'_req']		= isset( $options['custom_'.$custom_settings_quantity.'_req'] ) ? $options['custom_'.$custom_settings_quantity.'_req'] : '';
        $options['custom_'.$custom_settings_quantity.'_show']		= isset( $options['custom_'.$custom_settings_quantity.'_show'] ) ? $options['custom_'.$custom_settings_quantity.'_show'] : '';
        $options['custom_'.$custom_settings_quantity.'_side']		= isset( $options['custom_'.$custom_settings_quantity.'_side'] ) ? $options['custom_'.$custom_settings_quantity.'_side'] : '';
        $options['custom_'.$custom_settings_quantity.'_list']		= isset( $options['custom_'.$custom_settings_quantity.'_list'] ) ? $options['custom_'.$custom_settings_quantity.'_list'] : '';
        $options['custom_'.$custom_settings_quantity.'_icon']		= isset( $options['custom_'.$custom_settings_quantity.'_icon'] ) ? $options['custom_'.$custom_settings_quantity.'_icon'] : '';

        $custom_settings_quantity++ ;
  		}

			$group_custom_settings_quantity = 1;
 		 		while ($group_custom_settings_quantity <= 8) {
			$_POST['group_'.$group_custom_settings_quantity.'_title']			= isset( $_POST['group_'.$group_custom_settings_quantity.'_title'] ) ? $_POST['group_'.$group_custom_settings_quantity.'_title'] : '';
			$_POST['group_'.$group_custom_settings_quantity.'_sub_title']		= isset( $_POST['group_'.$group_custom_settings_quantity.'_sub_title'] ) ? $_POST['group_'.$group_custom_settings_quantity.'_sub_title'] : '';

			$options['group_'. $group_custom_settings_quantity .'_show']		= isset( $options['group_'. $group_custom_settings_quantity .'_show'] ) ? $options['group_'. $group_custom_settings_quantity .'_show'] : '';
			$_POST['group_'.$group_custom_settings_quantity.'_icon']			= isset( $_POST['group_'.$group_custom_settings_quantity.'_icon'] ) ? $_POST['group_'.$group_custom_settings_quantity.'_icon'] : '';

			$group_custom_settings_quantity++ ;
			}

	// If fired save button
	if( isset( $_POST['save'] ) ) {
		$args = array();
		foreach( $_POST as $key => $value ) {
			if( $key !== 'save' ) {
				$args[$key] = $value;
			}
		}
		$Settings->update( 'WP_OPTIONS', '_pixad_autos_validation', serialize( $args ) );
	}
?>

<?php // print_r($options); ?>

<!-- Validation Settings -->
<div class="pixad-panel validation">
	<div class="pixad-panel-heading">
		<span class="pixad-panel-title"><?php _e( 'Validation Settings', TEXTDOMAIN ); ?></span>
	</div>
	<div class="pixad-panel-body">
		<form method="post" class="pixad-form-horizontal" role="form">
		
			<table class="pixad-table">
				<thead>
					<tr class="pixad-primary">
						<th><?php _e( 'Input Field', TEXTDOMAIN ); ?> <i class="fa fa-question-circle" title="Auto Fields" data-toggle="tooltip" data-placement="top"></i></th>
						<th><?php _e( 'Required', TEXTDOMAIN ); ?> <i class="fa fa-question-circle" title="Check this if you want this field to be marked as required when users adding new autos." data-toggle="tooltip" data-placement="top"></i></th>
						<th><?php _e( 'Show', TEXTDOMAIN ); ?> <i class="fa fa-question-circle" title="Check this if you want to show this field to be visible on autos page & add / edit auto frontpage." data-toggle="tooltip" data-placement="top"></i></th>

						<th><?php _e( 'Display in Grid', TEXTDOMAIN ); ?></th>
						<th><?php _e( 'Display in List', TEXTDOMAIN ); ?></th>
            <th><?php _e( 'Icon', TEXTDOMAIN ); ?></th>

						<th><?php _e( 'Default value', TEXTDOMAIN ); ?> <i class="fa fa-question-circle" title="Auto Fields" data-toggle="tooltip" data-placement="top"></i></th>
					</tr>
				</thead>
				<tbody>
					<form method="post">
					
                        <?php foreach($allSettings as $_key => $_setting):?>
                            <tr>
                                <td><?php _e( $_setting, TEXTDOMAIN ); ?></td>
                                <?php if (in_array($_key,array('auto-make','auto-model'))):?>
                                    <td><input name="<?php echo $_key?>_req" type="checkbox"  checked disabled></td>
                                    <td><input name="<?php echo $_key?>_show" type="checkbox"  checked disabled></td>
                                <?php elseif($_key == 'auto-date'):?>
                                    <td></td>
                                    <td><input name="<?php echo $_key?>_show" type="checkbox" <?php checked( 'on', $options[$_key .'_show'], true ); ?>></td>
                                <?php else:?>
                                    <td><input name="<?php echo $_key?>_req" type="checkbox" <?php checked( 'on', $options[$_key . '_req'], true ); ?>></td>
                                    <td><input name="<?php echo $_key?>_show" type="checkbox" <?php checked( 'on', $options[$_key . '_show'], true ); ?>></td>
                                <?php endif;?>
                                <td><input name="<?php echo $_key?>_side" type="checkbox" <?php checked( 'on', $options[$_key . '_side'], true ); ?>></td>
                                <td><input name="<?php echo $_key?>_list" type="checkbox" <?php checked( 'on', $options[$_key . '_list'], true ); ?>></td>
                                <td><input type="text" placeholder="autofont-cars" name="<?php echo $_key?>_icon" value="<?php echo esc_attr($options[$_key . '_icon'])?>"/></td>

															<?php if (in_array($_key,array('first-name','last-name','seller-company','seller-email', 'seller-phone', 'seller-country', 'seller-state', 'seller-town', 'seller-location', 'seller-location-lat', 'seller-location-long'))):?>
                                    <td><input name="<?php echo $_key?>_def" type="text" value="<?php echo $options[$_key . '_def']; ?>" class="pixad-form-control"></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach;?>

                     


								<?php   

									$custom_settings_quantity = 1;
									$max_custom_settings_quantity = 10;
									$group_custom_settings_quantity = 1;

								while ($group_custom_settings_quantity <= 8) { ?>

									<tr>
										<td colspan="5" style="text-align: center;">Custom Settings - Group <?php echo $group_custom_settings_quantity; ?></td>
										
									</tr>
									<tr>
										<td colspan="2">
											<b><label for="group_<?php echo $group_custom_settings_quantity; ?>_show"><?php _e( 'Add in technical tab', TEXTDOMAIN ); ?></label></b>
											<input name="group_<?php echo $group_custom_settings_quantity; ?>_show" type="checkbox" <?php checked( 'on', $options['group_'. $group_custom_settings_quantity .'_show'], true ); ?>></td>
											<td >
												<b>Icon class:</b>
												<input name="group_<?php echo $group_custom_settings_quantity; ?>_icon" type="text" value="<?php echo $options['group_'. $group_custom_settings_quantity .'_icon']; ?>" class="pixad-form-control" placeholder="Group icon class" style="display: inline-block; width: 50%;">
											</td>
									</tr>
									<tr>
										<td>Custom Settings Title:</td>
										<td><input name="group_<?php echo $group_custom_settings_quantity; ?>_title" type="text" value="<?php echo $options['group_'. $group_custom_settings_quantity .'_title']; ?>" class="pixad-form-control"></td>
										<td><b>Custom Settings SubTitle:</b></td>
										<td><input name="group_<?php echo $group_custom_settings_quantity; ?>_sub_title" type="text" value="<?php echo $options['group_'. $group_custom_settings_quantity .'_sub_title']; ?>" class="pixad-form-control"></td>
									</tr>

									<tr class="pixad-primary">
										<th><?php _e( 'Input Field', TEXTDOMAIN ); ?> <i class="fa fa-question-circle" title="Auto Fields" data-toggle="tooltip" data-placement="top"></i></th>
										<th><?php _e( 'Required', TEXTDOMAIN ); ?> <i class="fa fa-question-circle" title="Check this if you want this field to be marked as required when users adding new autos." data-toggle="tooltip" data-placement="top"></i></th>
										<th><?php _e( 'Show', TEXTDOMAIN ); ?> <i class="fa fa-question-circle" title="Check this if you want to show this field to be visible on autos page & add / edit auto frontpage." data-toggle="tooltip" data-placement="top"></i></th>

										<th><?php _e( 'Display in Grid', TEXTDOMAIN ); ?></th>
										<th><?php _e( 'Display in List', TEXTDOMAIN ); ?></th>
      					     <th><?php _e( 'Icon', TEXTDOMAIN ); ?></th>
									</tr>

      					 <?php     
  								while ($custom_settings_quantity <= $max_custom_settings_quantity) { ?>
  														
 											<tr>
 												
                                <td><input name="custom_<?php echo $custom_settings_quantity; ?>_name" type="text" value="<?php echo $options['custom_'. $custom_settings_quantity .'_name']; ?>" class="pixad-form-control"></td>

                                <td><input name="custom_<?php echo $custom_settings_quantity; ?>_req" type="checkbox" <?php checked( 'on', $options['custom_'. $custom_settings_quantity .'_req'], true ); ?>></td>

                                <td><input name="custom_<?php echo $custom_settings_quantity; ?>_show" type="checkbox" <?php checked( 'on', $options['custom_'. $custom_settings_quantity .'_show'], true ); ?>></td>

                                <td><input name="custom_<?php echo $custom_settings_quantity; ?>_side" type="checkbox" <?php checked( 'on', $options['custom_'. $custom_settings_quantity .'_side'], true ); ?>></td>
                                <td><input name="custom_<?php echo $custom_settings_quantity; ?>_list" type="checkbox" <?php checked( 'on', $options['custom_'. $custom_settings_quantity .'_list'], true ); ?>></td>

                                <td><input type="text" placeholder="autofont-cars" name="custom_<?php echo $custom_settings_quantity; ?>_icon" value="<?php echo esc_attr($options['custom_'. $custom_settings_quantity .'_icon'])?>"/></td>

                            </tr>

    								 <?php  $custom_settings_quantity++ ;
  									}  

										$group_custom_settings_quantity++ ;
										$max_custom_settings_quantity = $max_custom_settings_quantity + 10;

										}
  									?>

					<tr>
						<td colspan="5"><input name="save" type="submit" class="add-new-h2" value="<?php _e( 'Save', TEXTDOMAIN ); ?>"></td>
					</tr>
					</form>
				</tbody>
			</table>
		
		</form>
	</div>
</div><!-- / Validation Settings -->

<script>
jQuery( document ).ready(function($) {
	$('[data-toggle="tooltip"]').tooltip();
});
</script>