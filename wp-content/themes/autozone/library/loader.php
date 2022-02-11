<?php

    /* Load CORE main file */
    require_once(get_template_directory() . '/library/core/index.php');

    /* Load THEME main file */
    require_once(get_template_directory() . '/library/theme/index.php');

    /* Load Plugins */
    include_once(get_template_directory() . '/library/theme/activation.php');
    if(pixtheme_check_is_activated()){
    	    require_once(get_template_directory() . '/library/plugins.php');
    }

?>