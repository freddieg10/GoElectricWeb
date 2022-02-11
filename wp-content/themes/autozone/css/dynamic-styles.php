 <?php //header("Content-type: text/css; charset: UTF-8");
$_REQUEST['pageID']= get_the_ID();
$autozone_customize = get_option( 'autozone_customize_options' );

$autozone_customize['first_color'] = autozone_get_option('style_settings_main_color', get_option('autozone_default_main_color'));
$autozone_customize['font_family'] = autozone_get_option('font', '');
$page_color = get_post_meta($_REQUEST['pageID'], 'page_bg_color', 1);
$footer_bg_image = autozone_get_option('footer_bg_image', '') ? autozone_get_option('footer_bg_image', '') : get_template_directory_uri().'/media/bg/9.jpg';
 require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
?>

<?php if($page_color):?>

	<?php $autozone_customize['first_color'] = $page_color; ?>

html .isotope-item .slide-desc,
html .yp-demo-link {
    background: <?php echo esc_attr($page_color)?> !important;
}
html .wrap-features .wrap-feature-item .feature-item .number,
html .nav-tabs-vertical > li.active > a,
html .nav-tabs-vertical > li.active > a:focus,
html .nav-tabs-vertical > li.active > a:hover,
html .steps i:before, html .steps i:after,
html .service-icon i{
	color: <?php echo esc_attr($page_color)?>;
}
html ::selection {
	background: <?php echo esc_attr($page_color)?>; /* Safari */
	color: #fff;
}
html ::-moz-selection {
	background: <?php echo esc_attr($page_color)?>; /* Firefox */
	color: #fff;
}

html .km-teammate-container[data-style=style3] .km-teammate-soc{
 background: <?php echo esc_attr($page_color)?>; 
}



<?php endif?>


html .section_mod-h:after {
	background-image: url('<?php echo esc_attr($footer_bg_image)?>');
}


<?php if($autozone_customize['first_color'] != ''):?>

.tab-content .pixad-features-list i.features-icon {
    color: <?php echo esc_attr($autozone_customize['first_color'])?> !important;
    top:2px !important;
}


html  .woocommerce ul.products li.product .onsale {
     background-color: <?php echo esc_attr($autozone_customize['first_color'])?>;
}


.footer__btn:before{
    border-bottom: 33px solid <?php echo esc_attr($autozone_customize['first_color'])?>;
}

.thecube .cube:before {
  background-color: <?php echo esc_attr($autozone_customize['first_color'])?>;
}
.list-services:hover .list-services__title *{
color: <?php echo esc_attr($autozone_customize['first_color'])?>;
}

html input[type="submit"] {
    background-color: <?php echo esc_attr($autozone_customize['first_color'])?>;
}

.woocommerce div.product .woocommerce-tabs ul.tabs li.active a{
  color: <?php echo esc_attr($autozone_customize['first_color'])?>;
}


html .b-submit__aside-step-inner-info h4{
  border-color: <?php echo esc_attr($autozone_customize['first_color'])?>;
}


html .booking-auto-form button.submit , html .car-booking a{
     background-color: <?php echo esc_attr($autozone_customize['first_color'])?>;
}


html .woocommerce-cart .wc-proceed-to-checkout a.checkout-button{
   background-color: <?php echo esc_attr($autozone_customize['first_color'])?> !important; 
}


html .period_picker_box .period_picker_show:before{
  background-color: <?php echo esc_attr($autozone_customize['first_color'])?> !important; 
}


.autozone_calculate_btn {
  background-color: <?php echo esc_attr($autozone_customize['first_color'])?> !important; 
}


.sidebar .widget_product_categories ul li a:before{
  color: <?php echo esc_attr($autozone_customize['first_color'])?> !important; 
}




a,
.color_primary,
.ui-title-inner .icon:before,
.link-img__link:hover .link-img__title,
.main-block__title strong,
.decor-3,
.list-services:hover .list-services__title,
.list-progress .icon,
.footer-title__inner,
.card__price-number,
.list-categories__link:before,
.list-categories__link:hover,
.list-descriptions dt:before,
.widget-post1__price,
.nav-tabs > li.active > a,
.nav-tabs > li > a:hover,
.nav-tabs > li.active > a:focus,
.social-blog__item:before,
blockquote:before,
.comments-list .comment-datetime , html .phone-menu i  {
    color: <?php echo esc_attr($autozone_customize['first_color'])?>;
}


.staff-no-skill:hover {
    background: <?php echo esc_attr($autozone_customize['first_color'])?>;
}



.bg-color_primary,
.main-slider__link,
.decor-2:before,
.decor-2:after,
.section-bg_primary,
.border-section-top_mod-b:before,
.border-section-top_mod-b:after,
.slider-grid__price,
.btn-default:after,
.owl-theme_mod-c .owl-controls .owl-page.active span,
.owl-theme_mod-c .owl-controls.clickable .owl-page:hover span,
.owl-theme_mod-d .owl-controls .owl-page.active span,
.owl-theme_mod-d .owl-controls.clickable .owl-page:hover span,
.list-type__link:hover,
.list-staff__item:hover .list-staff__info,
.progress-bar,
.post .entry-date,
.post:hover .entry-main__inner_mod-a:after,
.btn-effect:after,
.yamm .navbar-toggle,
.ui-btn_mod-a,
.jelect-option:hover,
.jelect-option_state_active,
.car-details__price,
.noUi-origin,
.btn-skew-r,
.list-tags__link:hover,
.about-autor,
.card__wrap-label , html .mli_count , html .header-menu-middle .header-navibox-search .btn , .woocommerce.columns-5 .owl-theme .owl-controls .owl-page.active span , .woocommerce.columns-4 .owl-theme .owl-controls .owl-page.active span , .woocommerce.columns-3 .owl-theme .owl-controls .owl-page.active span {
    background-color: <?php echo esc_attr($autozone_customize['first_color'])?>;
}

html .link-img__link,
html .owl-theme_mod-c .owl-controls .owl-page.active span,
html .owl-theme_mod-c .owl-controls.clickable .owl-page:hover span,
html .owl-theme_mod-d .owl-controls .owl-page.active span,
html .owl-theme_mod-d .owl-controls.clickable .owl-page:hover span,
html .list-type__link:hover,
html .current-menu-item > a:before,html .current-page-parent > a:before {
	border-color: <?php echo esc_attr($autozone_customize['first_color'])?> !important;
}



#iview div.iview-directionNav a.iview-nextNav:hover:before,
.list-staff__item:nth-child(even):hover .list-staff__info:after,
.reviews:hover .reviews__title {border-left-color: <?php echo esc_attr($autozone_customize['first_color'])?>;}

#iview div.iview-directionNav a.iview-prevNav:hover:before,
.list-staff__item:nth-child(odd):hover .list-staff__info:after {border-right-color: <?php echo esc_attr($autozone_customize['first_color'])?>;}

.header.sticky .navbar,
.form-control:focus {border-bottom-color: #DC2D13;}

.btn-default,
.btn-success {box-shadow: 5px 0 0 0 <?php echo esc_attr($autozone_customize['first_color'])?>;}

.yamm .nav > li > a:hover {
    box-shadow: 0 -5px 0 0 <?php echo esc_attr($autozone_customize['first_color'])?>;
    background: none !important;
}

.link,
.list-type__link,
.main-slider__btn,
.car-details__title {box-shadow: -4px 0 0 0 <?php echo esc_attr($autozone_customize['first_color'])?>;}

.pagination > .active > a,
.pagination > .active > span,
.pagination > .active > a:hover,
.pagination > .active > span:hover,
.pagination > .active > a:focus,
.pagination > .active > span:focus,
.pagination > li > a:hover,
.pagination > li > span:hover,
.pagination > li > a:focus,
.pagination > li > span:focus {
	box-shadow: 0 3px 0 0 <?php echo esc_attr($autozone_customize['first_color'])?>;
}

html .wd-auto_sell_page{
 background-color: <?php echo esc_attr($autozone_customize['first_color'])?>;
}


html .hours_price_title_item span.pixad_auto_price_in_hour , .extr-right *{
  color: <?php echo esc_attr($autozone_customize['first_color'])?>;
}


.slider-grid  .owl-page.active span, .slider-grid .owl-page span:hover{
    background-color: <?php echo esc_attr($autozone_customize['first_color'])?> !important;
    border-color:<?php echo esc_attr($autozone_customize['first_color'])?> !important;
}


/*Headers color*/


html .header-cart-count{
    background: <?php echo esc_attr($autozone_customize['first_color'])?> !important;
}

html body .header li > a:hover {
    color: <?php echo esc_attr($autozone_customize['first_color'])?> !important;
}



html body  .fullscreen-center-menu li > a:hover {
    color: <?php echo esc_attr($autozone_customize['first_color'])?> !important;
}

html body [off-canvas] li a:hover {
    color: <?php echo esc_attr($autozone_customize['first_color'])?>;
}



.kameleon-cf7-container .km_cf7-btn-txt-r{
    background:  <?php echo esc_attr($autozone_customize['first_color'])?> !important;
}



a {
	color: <?php echo esc_attr($autozone_customize['first_color'])?>;
}



.cl-effect-1  .current-menu-item > a {
  	color: <?php echo esc_attr($autozone_customize['first_color'])?> !important;
}

.customer-favourites .woocommerce-Price-amount {
  	color: <?php echo esc_attr($autozone_customize['first_color'])?> ;
}



.full-width .dropdown-menu ul li:hover a{
 color: <?php echo esc_attr($autozone_customize['first_color'])?> !important;
}
html .nav > li > a:hover, html .nav > li > a:focus {
	color: <?php echo esc_attr($autozone_customize['first_color'])?>;
}
html .pre-footer {
	background: none repeat scroll 0 0 <?php echo esc_attr($autozone_customize['first_color'])?>;
}
html .after-heading-info, .highlight_text {
	color: <?php echo esc_attr($autozone_customize['first_color'])?>;
}
html .bx-wrapper .bx-next {
	background: <?php echo esc_attr($autozone_customize['first_color'])?> !important;
}
html .bx-wrapper .bx-next {
	background: <?php echo esc_attr($autozone_customize['first_color'])?> !important;
}
html .full-title.banner-full-width {
	background-color: <?php echo esc_attr($autozone_customize['first_color'])?>
}
html .featured-item-simple-icon::after {
	border-color: <?php echo esc_attr($autozone_customize['first_color'])?>;
}
html .top-cart i, html .top-cart .icon-basket {
	color: <?php echo esc_attr($autozone_customize['first_color'])?>;
}
html .dropdown-menu > li > a:hover, html .dropdown-menu > li > a:focus {
	background-color: <?php echo esc_attr($autozone_customize['first_color'])?>
}
html .title-action a {
	background: none repeat scroll 0 0 <?php echo esc_attr($autozone_customize['first_color'])?> !important;
	border-color: <?php echo esc_attr($autozone_customize['first_color'])?> !important;
}
html .full-title-name .btn {
	background: none repeat scroll 0 0 <?php echo esc_attr($autozone_customize['first_color'])?>!important;
	border-color: <?php echo esc_attr($autozone_customize['first_color'])?> !important;
}
html .marked_list1 li:before {
	color: <?php echo esc_attr($autozone_customize['first_color'])?>;
}
html .woocommerce #respond input#submit, html .woocommerce a.button, html .woocommerce button.button, html .woocommerce input.button {
	background-color: <?php echo esc_attr($autozone_customize['first_color'])?> !important;
	border-color: <?php echo esc_attr($autozone_customize['first_color'])?> !important;
}
html .product-info .nav-tabs > li.active a, html .product-info .nav-tabs > li:hover a {
	background: <?php echo esc_attr($autozone_customize['first_color'])?> !important;
	color: #fff !important;
	outline: none !important;
	border: 1px solid <?php echo esc_attr($autozone_customize['first_color'])?>;
}
html .product-info .nav-tabs {
	border-top-color: <?php echo esc_attr($autozone_customize['first_color'])?>;
}
html .nav > li > a:hover, html .nav > li > a:focus {
	color: <?php echo esc_attr($autozone_customize['first_color'])?>;
}
html .label-sale, .label-hot, html .label-not-available, html .label-best {
	color: #526aff;
}

html a {
  color: <?php echo esc_attr($autozone_customize['first_color'])?>;
}

.box-date-post .date-2 {
   color: <?php echo esc_attr($autozone_customize['first_color'])?>;
}

html body  .type-post.sticky:after {
		color: <?php echo esc_attr($autozone_customize['first_color'])?>;

}


html .km-teammate-container[data-style=style3] .km-teammate-soc{
  background: <?php echo esc_attr($autozone_customize['first_color'])?> !important;
}


.tagcloud a:hover{
   background: <?php echo esc_attr($autozone_customize['first_color'])?> !important;
   border-color: <?php echo esc_attr($autozone_customize['first_color'])?> !important;
   color:#fff;
}


.owl-theme .owl-controls .owl-page.active span{
  background: <?php echo esc_attr($autozone_customize['first_color'])?> !important;
   border-color: <?php echo esc_attr($autozone_customize['first_color'])?> !important;
}

    <!--END SECOND COLOR-->
    

  <?php endif?> 
  
<?php if ( class_exists('PixthemeCustom') ):?>
    <?php if($autozone_customize['second_color'] != ''):?>
	


html .btn-link,html  .view-post-btn {
  color: <?php echo esc_attr($autozone_customize['second_color'])?> !important;
}
html .demo_changer .demo-icon {
	background: <?php echo esc_attr($autozone_customize['second_color'])?>;
}
html .woocommerce nav.woocommerce-pagination ul li a:focus, html .woocommerce nav.woocommerce-pagination ul li a:hover, html .woocommerce nav.woocommerce-pagination ul li span.current {
	background: <?php echo esc_attr($autozone_customize['second_color'])?> !important;
}
html .pagination li, html .woocommerce-pagination li {
	border-color: <?php echo esc_attr($autozone_customize['second_color'])?> !important;
}
html .tagcloud a:hover {
	background: <?php echo esc_attr($autozone_customize['second_color'])?> !important;
}
html .title-option {
	background: <?php echo esc_attr($autozone_customize['second_color'])?>;
}
html .ip-header .ip-loader svg path.ip-loader-circle {
	stroke: <?php echo esc_attr($autozone_customize['second_color'])?> !important;
}
.yamm {
	background-color: <?php echo esc_attr($autozone_customize['second_color'])?>;
}
.yamm .dropdown-menu h1:after, .yamm .dropdown-menu h2:after, .yamm .dropdown-menu h3:after, .yamm .dropdown-menu h4:after, .yamm .dropdown-menu h5:after, .yamm .dropdown-menu h6:after {
	border-color: <?php echo esc_attr($autozone_customize['second_color'])?> !important;
}
html .banner-full-width .btn.btn-primary {
	background-color: <?php echo esc_attr($autozone_customize['second_color'])?>;
	border-color: <?php echo esc_attr($autozone_customize['second_color'])?>;
	color: #ffffff;
}
html .full-title-name {
	background-color: <?php echo esc_attr($autozone_customize['second_color'])?>;
}
html .carousel-text a.btn-read-more.btn {
	color: <?php echo esc_attr($autozone_customize['second_color'])?>;
}
html a.btn-read-more.btn {
	color: #ffc300;
}
html .btn-primary, html .wpcf7-submit {
	background-color: <?php echo esc_attr($autozone_customize['second_color'])?>;
	border-color: <?php echo esc_attr($autozone_customize['second_color'])?>;
}
html .service-icon {
	border-color: <?php echo esc_attr($autozone_customize['second_color'])?>;
}
html .service-item:hover .service-icon {
	background-color: <?php echo esc_attr($autozone_customize['second_color'])?>;
}
html .pre-footer:hover {
	background-color: <?php echo esc_attr($autozone_customize['second_color'])?>;
}
.footer-shop .widgettitle:after {
	border-bottom: 1px solid <?php echo esc_attr($autozone_customize['second_color'])?>;
}
html .footer-absolute {
	background-color: <?php echo esc_attr($autozone_customize['second_color'])?>;
}



html .btn-location-open i {
	color: #fff;
}
html .product-grid li:hover .product-bottom .btn-group .btn {
	background-color: <?php echo esc_attr($autozone_customize['second_color'])?>;
	border-color: <?php echo esc_attr($autozone_customize['second_color'])?>;
}
html .pp-content:hover {
	background: none repeat scroll 0 0 <?php echo esc_attr($autozone_customize['second_color'])?>;
}
html .pp-content:hover .arrow {
	border-color: <?php echo esc_attr($autozone_customize['second_color'])?>;
}
html .parallax-black .service-item .fa::before {
	color: <?php echo esc_attr($autozone_customize['second_color'])?>;
}
html .btn-download {
	background: <?php echo esc_attr($autozone_customize['second_color'])?>;
	color: #fff !important;
}
html body aside .widget_nav_menu li:before, html body aside .widget_product_categories li:before {
	color: <?php echo esc_attr($autozone_customize['second_color'])?>;
}
html aside .widget_nav_menu li:hover, aside .widget_product_categories li:hover {
	border-left-color: <?php echo esc_attr($autozone_customize['second_color'])?>;
}
.info-desc {
	border: 7px solid <?php echo esc_attr($autozone_customize['second_color'])?>;
	box-shadow: 1px 1px 3px <?php echo esc_attr($autozone_customize['second_color'])?> inset;
}
html .info-desc:after {
	background: none repeat scroll 0 0 <?php echo esc_attr($autozone_customize['second_color'])?>;
}
html .info-desc:before {
	background: none repeat scroll 0 0 <?php echo esc_attr($autozone_customize['second_color'])?>;
}
html .info-desc td i {
	color: <?php echo esc_attr($autozone_customize['second_color'])?>;
}
html .marked_list2 li:before {
	color: <?php echo esc_attr($autozone_customize['second_color'])?>;
}

html  blockquote {
  border-left: 3px solid <?php echo esc_attr($autozone_customize['second_color'])?>;
}




html .banner-full-width {
	background: none;
	color: #333333;
	border-top: #eeeeee 1px solid;
	border-bottom: #eeeeee 1px solid;
}
html .banner-full-width p {
	color: #333333;
}
html .banner-full-width .btn {
	border-color: #333333;
	color: #333333;
}


  <?php endif?> 
  <?php endif?> 
  
  
<?php if ( class_exists('PixthemeCustom') ):?>
    <?php if($autozone_customize['third_color'] != ''):?>
    
     
html .no-bg-color-parallax.parallax-yellow .bg-slideshow:after {
	background-color: <?php echo esc_attr($autozone_customize['third_color'])?> ;
}
  
   <?php endif?>
   <?php endif?> 
   
   
   
    
  <?php if($autozone_customize['font_family'] != ''):?>


html body   , 
html body   * , 
html .main-block__title , 
html .main-block , 
html .ui-title-inner , 
html body p , html .brand-link , 
html header a , 
html header li ,
html .link-img__title ,
.list-mark li{
    font-family: '<?php echo esc_attr($autozone_customize['font_family'])?>' ;
    font-weight: <?php echo esc_attr($autozone_customize['font_weight'])?>;    
}


html .tmpl-title-font{
    font-family: '<?php echo esc_attr($autozone_customize['font_family'])?>' !important;
    font-weight: normal; 
}



h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 ,
.slider-grid__inner_mod-b .slider-grid__name ,
.list-progress__name ,
.list-staff__name ,
.staff-progress__title ,
.post .entry-date__inner ,
.card__label ,
.nav-tabs  li a ,
html .pixad-features-list li ,
.post-nav__title ,
.post-nav__link ,
.woocommerce div.product .woocommerce-tabs ul.tabs li a{
    font-family: '<?php echo esc_attr($autozone_customize['font_family'])?>' !important;
    font-weight: 700;    
}



    <?php endif?>
<?php if ( class_exists('PixthemeCustom') ):?>
    <?php if($autozone_customize['font_title_family'] != ''):?>
html h1, html  h2, html  h3,  html  h4, html  h5, html  h6,{
    font-family: '<?php echo esc_attr($autozone_customize['font_title_family'])?>';
    font-weight:<?php echo esc_attr($autozone_customize['font_title_weight'])?>;
}

	<?php endif?>
    <?php endif?>

 <?php if ( class_exists('PixthemeCustom') ):?>
<?php if($autozone_options['autozone_custom_css']):?>
<?php echo esc_attr($autozone_options['autozone_custom_css']); ?>
<?php endif?>
  <?php endif?>




