<?php
$out = '';

$out .= '
	<div class="blog">
		<div class="subscribe">
			<div class="form-inline clearfix">
				'.do_shortcode('[mc4wp_form]').'
			</div>
		</div>	
	</div>	
	'; 

echo $out;
