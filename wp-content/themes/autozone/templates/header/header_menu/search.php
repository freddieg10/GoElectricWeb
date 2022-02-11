
<!-- ========================== --> 
<!-- SEARCH MODAL  --> 
<!-- ========================== -->

<div class="header-search">
	<div class="container">
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1">
				<div class="navbar-search">
					<form action="<?php echo esc_url(site_url()) ?>" method="get" id="search-global-form" class="search-global">
						<input type="text" placeholder="<?php echo !autozone_get_option('search_placeholder','') ? esc_html__('Type to search', 'autozone') : esc_attr(autozone_get_option('search_placeholder','')) ?>" autocomplete="off" name="s" id="search" value="<?php esc_attr(the_search_query()); ?>" class="search-global__input">
						<button class="search-global__btn"><i class="icon fa fa-search"></i></button>
						<div class="search-global__note"><?php echo !autozone_get_option('search_description','') ? esc_html__('Begin typing your search above and press return to search.', 'autozone') : wp_kses_post(autozone_get_option('search_description',''))?></div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<button type="button" class="search-close search-form_close close"><i class="fa fa-times"></i></button>
</div>
