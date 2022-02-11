<?php
	/**  Core_Global  **/

	get_template_part( 'library/core/global/functions');
	get_template_part( 'library/core/global/sidebars');

	
	if (file_exists(get_template_directory() .'/one-click-demo-install/init.php'))
		get_template_part( 'one-click-demo-install/init' );
	
	
	
	
	
	
?>