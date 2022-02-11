<?php
/*** The html form for search input. ***/
?>

	<form action="<?php echo esc_url(site_url()) ?>" method="get" id="search-global-form">    
    	<input type="text" placeholder="<?php esc_html_e('Search', 'autozone');?>" name="s" id="search" value="<?php esc_attr(the_search_query()); ?>" /><input type="hidden" name="post_type" value="post" />
    </form>
    
    