<div class="block-title">
	<?php autozone_load_block('header/header_bgimage')?>
</div>




<?php  $pixba_style = get_option('pixba_style'); ?>
 <?php if ($pixba_style != 'sidebar'){?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
		<?php  do_action( 'header_botton_notice'); ?>
</div>	
	</div>
</div>

<?php } ?>
