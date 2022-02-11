/*
| ----------------------------------------------------------------------------------
| TABLE OF CONTENT
| ----------------------------------------------------------------------------------
-SETTING
-Sticky Header
-Dropdown Menu Fade
-Animated Entrances
-Accordion
-Filter accordion
-Chars Start
-Сustomization select
-Zoom Images
-HOME SLIDER
-CAROUSEL PRODUCTS
-PRICE RANGE
-SLIDERS
-Animated WOW
*/


 

(function ($) {
    
    $(window).load(function() {
    $('#loader').fadeOut('slow');
    });
$(document).ready(function() {

    "use strict";

 /////////////////////////////////////
    //  LOADER
    /////////////////////////////////////

    var $preloader = $('#page-preloader'),
    $spinner = $preloader.find('.spinner-loader');
    $spinner.fadeOut();
    $preloader.delay(50).fadeOut('slow');
    
    
    
    $('#wpadminbar').addClass('wpadmin-opacity');


    $( '.yamm li:has(ul)' ).doubleTapToGo();
    
   
    

 

/////////////////////////////////////////////////////////////////
// SETTING
/////////////////////////////////////////////////////////////////

    var windowHeight = $(window).height();
    var windowWidth = $(window).width();


    var tabletWidth = 767;
    var mobileWidth = 640;
    
    
    
     /////////////////////////////////////
    //  iframe
    /////////////////////////////////////


		$('.wpb_map_wraper').click(function () {
			$('iframe').css("pointer-events", "auto");
		});
    
    
    /******************************************************* 
     *****  SELECT 2  *****
     *********************************************************/
    
    
    $('.orderby,.woocommerce div.product form.cart .variations select').select2()


    
    
/////////////////////////////////////
//  Home Banner
/////////////////////////////////////
    
    $('.link-img__link_disabled').on('click', function(e) {
    e.preventDefault();
    $(this).off("click").attr('href', "javascript: void(0);");
   //add .off() if you don't want to trigger any event associated with this link
});




/////////////////////////////////////
//  Sticky Header
/////////////////////////////////////
    
    
     $("#clt-maps").click(function () {
        $('.header').addClass('headermaphide');
    });
    


    if (windowWidth > tabletWidth) {

        var headerSticky = $(".layout-theme").data("header");
        var headerTop = $(".layout-theme").data("header-top");

        if (headerSticky.length) {
            $(window).on('scroll', function() {
                var winH = $(window).scrollTop();
                var $pageHeader = $('.header');
                if (winH > headerTop) {

              
                    $pageHeader.addClass('sticky');

                } else {

                  
                    $pageHeader.removeClass('sticky');
                    
                    
                    
                    var DelayMenuMaps = function () {



            $('.header').removeClass('headermaphide');
   

        };

        setTimeout(DelayMenuMaps, 1000);
                    
                }
            });
        }
    }
    
    
    
    
      if (windowWidth > tabletWidth) {
    
    
            var DelayLoad = function () {



            $(".sticky-bar").stick_in_parent();
   

        };

        setTimeout(DelayLoad, 2000);



	  }
    
    
    
    


	
    
    
	
    ////////////////////////////////////////////  
    //  full-width
    ///////////////////////////////////////////  


    function fullWidthSection() {
		

        var windowWidth = $(window).width();
        var widthContainer = $('.container').width();
		var sectionFW =   $('.bg_inner');

        var fullWidth1 = windowWidth - widthContainer;
        var fullWidth2 = fullWidth1 / 2;
        
        
        if( $('html').attr('dir') == 'rtl' ){
    
    
                sectionFW.css("width", windowWidth);
                sectionFW.css("margin-right", -fullWidth2);
               
                $('[data-vc-full-width="true"]').css("right", -fullWidth2 + 15 ); 
              
       }
        
        
        
        else{
            
            sectionFW.css("width", windowWidth);
            sectionFW.css("margin-left", -fullWidth2); 
            
        }
 
        

    }

    fullWidthSection();
    $(window).resize(function() {
        fullWidthSection()
    });
    

/////////////////////////////////////////////////////////////////
//PRICE RANGE
/////////////////////////////////////////////////////////////////

    if ($('#slider-price').length > 0) {
		var slider = document.getElementById('slider-price');
		var min_price = document.getElementById('pix-min-price').value;
		var max_price = document.getElementById('pix-max-price').value;
		var max_slider_price = document.getElementById('pix-max-slider-price').value;
        
        var pix_thousand = document.getElementById('pix-thousand').value;
        var pix_decimal = document.getElementById('pix-decimal').value;
        var pix_decimal_number = document.getElementById('pix-decimal_number').value;

		//var symbol_price = document.getElementById('pix-currency-symbol').value;
		min_price = min_price == '' ? 0 : min_price;
		max_price = max_price == '' ? max_slider_price : max_price;

        noUiSlider.create(slider, {
                        start: [min_price, max_price],
                        step: 1000,
                        connect: true,
                        range: {
                            'min': 0,
                            'max': Number(max_slider_price)
                        },

                   /*   format: {
                          to: function ( value ) {
                            return value;
                          },
                          from: function ( value ) {
                            return value;
                          }
                        } 
                     */  
                      format: wNumb({
                         decimals: pix_decimal_number,
                         mark: pix_decimal,
                         thousand: pix_thousand
                        })
                       
                    });

		var pValues_price = [
			document.getElementById('slider-price_min'),
			document.getElementById('slider-price_max')
		];

		slider.noUiSlider.on('update', function( values, handle ) {
			pValues_price[handle].value = values[handle];
		});

		slider.noUiSlider.on('change', function( values, handle ) {
			$(pValues_price[handle]).trigger('change');
		});

    }
    if ($('#slider-price-two').length > 0) {
        var slider = document.getElementById('slider-price-two');
        var min_price = document.getElementById('pix-min-price-two').value;
        var max_price = document.getElementById('pix-max-price-two').value;
        var max_slider_price = document.getElementById('pix-max-slider-price-two').value;

        var pix_thousand = document.getElementById('pix-thousand-two').value;
        var pix_decimal = document.getElementById('pix-decimal-two').value;
        var pix_decimal_number = document.getElementById('pix-decimal_number-two').value;

        //var symbol_price = document.getElementById('pix-currency-symbol').value;
        min_price = min_price == '' ? 0 : min_price;
        max_price = max_price == '' ? max_slider_price : max_price;

        noUiSlider.create(slider, {
            start: [0],
            step: 10,
            connect: 'upper',
            range: {
                'min': 0,
                'max': Number(max_slider_price)
            },

            /*   format: {
                   to: function ( value ) {
                     return value;
                   },
                   from: function ( value ) {
                     return value;
                   }
                 }
              */
            format: wNumb({
                decimals: pix_decimal_number,
                mark: pix_decimal,
                thousand: pix_thousand
            })

        });

        var pValues_price = [
            document.getElementById('slider-price_min-two'),
            document.getElementById('slider-price_max-two'),
        ];

        slider.noUiSlider.on('update', function( values, handle ) {
            pValues_price[handle].value = values[handle];
        });

        slider.noUiSlider.on('change', function( values, handle ) {
            $(pValues_price[handle]).trigger('change');
        });

    }

/////////////////////////////////////////////////////////////////
//YEAR RANGE
/////////////////////////////////////////////////////////////////

    if ($('#slider-year').length > 0) {
		var slider_year = document.getElementById('slider-year');
        var min_slider_year = document.getElementById('pix-min-slider-year').value;
        var min_year = document.getElementById('pix-min-slider-year').value;
		var max_year = document.getElementById('pix-max-year').value;
		var max_slider_year = document.getElementById('pix-max-slider-year').value;
		// min_year = min_year == '' ? 1950 : min_year;
        min_year = min_year == '' ? min_slider_year : min_year;
		max_year = max_year == '' ? max_slider_year : max_year;
        
        noUiSlider.create(slider_year, {
                        start: [min_year, max_year],
                        step: 1,
                        connect: true,
                        range: {
                            'min': parseInt(min_slider_year),
                            'max': Number(max_slider_year)
                        },

                        format: {
                          to: function ( value ) {
                            return value;
                          },
                          from: function ( value ) {
                            return value;
                          }
                        }
                        
                    });

		var pValues_year = [
			document.getElementById('slider-year_min'),
			document.getElementById('slider-year_max')
		];

		slider_year.noUiSlider.on('update', function( values, handle ) {
			pValues_year[handle].value = values[handle];
		});

		slider_year.noUiSlider.on('change', function( values, handle ) {
			$(pValues_year[handle]).trigger('change');
		});

    }

/////////////////////////////////////////////////////////////////
//RADIUS RANGE
/////////////////////////////////////////////////////////////////

    if ($('#slider-radius').length > 0) {
        var slider_radius = document.getElementById('slider-radius');
        var min_slider_radius = document.getElementById('pix-min-radius').value;
        var max_slider_radius = document.getElementById('pix-max-radius').value;
        noUiSlider.create(slider_radius, {
            start: [0],
            step: 1,
            connect: 'upper',
            range: {
                'min': parseInt(min_slider_radius),
                'max': Number(max_slider_radius)
            },
            direction: 'ltr',
            handler: 'ltr'
        });
        var pValue_radius = [
            document.getElementById('car-locator-radius')
        ];

        var pValue_radius_show = [
            document.getElementById('pixba_radius_max')
        ];
        slider_radius.noUiSlider.on('update', function( values, handle ) {
            pValue_radius[handle].value = values[handle];
            pValue_radius_show[handle].value = values[handle];
        });
        slider_radius.noUiSlider.on('change', function( values, handle ) {
            $(pValue_radius[handle]).trigger('change');
            $(pValue_radius_show[handle]).trigger('change');
        });
    }
    
/////////////////////////////////////////////////////////////////
//   MILEAGE RANGE
/////////////////////////////////////////////////////////////////

    if ($('#slider-mileage').length > 0) {
		var slider_mileage = document.getElementById('slider-mileage');
		var min_mileage = document.getElementById('pix-min-mileage').value;
		var max_mileage = document.getElementById('pix-max-mileage').value;
		var max_slider_mileage = document.getElementById('pix-max-slider-mileage').value;
		min_mileage = min_mileage == '' ? 0 : min_mileage;
		max_mileage = max_mileage == '' ? max_slider_mileage : max_mileage;

 
        noUiSlider.create(slider_mileage, {
                        start: [min_mileage, max_mileage],
                        step: 0.1,
                        connect: true,
                        range: {
                            'min': 0,
                            'max': Number(max_slider_mileage)
                        },

                    /*    format: {
                          to: function ( value ) {
                            return value;
                          },
                          from: function ( value ) {
                            return value;
                          }
                        }
                       */ 
        });

		var pValues_mileage = [
			document.getElementById('slider-mileage_min'),
			document.getElementById('slider-mileage_max')
		];

		slider_mileage.noUiSlider.on('update', function( values, handle ) {
			pValues_mileage[handle].value = values[handle];
		});

		slider_mileage.noUiSlider.on('change', function( values, handle ) {
			$(pValues_mileage[handle]).trigger('change');
		});

    }
 
/////////////////////////////////////////////////////////////////
//   ENGINE RANGE
/////////////////////////////////////////////////////////////////

    if ($('#slider-engine').length > 0) {
		var slider_engine = document.getElementById('slider-engine');
		var min_engine = document.getElementById('pix-min-engine').value;
		var max_engine = document.getElementById('pix-max-engine').value;
		var max_slider_engine = document.getElementById('pix-max-slider-engine').value;
		min_engine = min_engine == '' ? 0 : min_engine;
		max_engine = max_engine == '' ? max_slider_engine : max_engine;

        noUiSlider.create(slider_engine, {
                        start: [min_engine, max_engine],
                        step: 0.1,
                        connect: true,
                        range: {
                            'min': 0,
                            'max': Number(max_slider_engine)
                        },

                        // Full number format support.
                        
                    });

		var pValues_engine = [
			document.getElementById('slider-engine_min'),
			document.getElementById('slider-engine_max')
		];

		slider_engine.noUiSlider.on('update', function( values, handle ) {
			pValues_engine[handle].value = values[handle];
		});

		slider_engine.noUiSlider.on('change', function( values, handle ) {
			$(pValues_engine[handle]).trigger('change');
		});

    }
    

/////////////////////////////////////
//  Disable Mobile Animated
/////////////////////////////////////

    if (windowWidth < mobileWidth) {

        $("body").removeClass("animated-css");

    }


        $('.animated-css .animated:not(.animation-done)').waypoint(function() {

                var animation = $(this).data('animation');

                $(this).addClass('animation-done').addClass(animation);

        }, {
                        triggerOnce: true,
                        offset: '90%'
        });
    
    
    
     $('#step01').waypoint(function() {

                
                $(".b-submit__aside-step").removeClass('m-active');
                $(".b-submit__aside-step-inner").removeClass('m-active');
                $(".step01").addClass('m-active');
                $(".step01 .b-submit__aside-step-inner").addClass('m-active');
         
         

        }, {
                        triggerOnce: false,
                         offset: '55%'
        });
    
    
    
    $('#step02').waypoint(function() {
        
        
       

                $(".b-submit__aside-step").removeClass('m-active');
                $(".b-submit__aside-step-inner").removeClass('m-active');
                $(".step02").addClass('m-active');
                $(".step02 .b-submit__aside-step-inner").addClass('m-active');
         
         

        }, {
                        triggerOnce: false,
                        offset: '55%'
        });
    
    
    
     $('#step03').waypoint(function() {
         
         
       

                
                $(".b-submit__aside-step").removeClass('m-active');
                $(".b-submit__aside-step-inner").removeClass('m-active');
                $(".step03").addClass('m-active');
                $(".step03 .b-submit__aside-step-inner").addClass('m-active');
         
         

        }, {
                        triggerOnce: false,
                        offset: '55%'
        });
    
    
    
    
       
     $('#step04').waypoint(function() {
  
                $(".b-submit__aside-step").removeClass('m-active');
                $(".b-submit__aside-step-inner").removeClass('m-active');
                $(".step04").addClass('m-active');
                $(".step04 .b-submit__aside-step-inner").addClass('m-active');
         
         

        }, {
                        triggerOnce: false,
                        offset: '55%'
        });
    
    
    
    
   
     $('#step05').waypoint(function() {
         
         
       

                
                $(".b-submit__aside-step").removeClass('m-active');
                $(".b-submit__aside-step-inner").removeClass('m-active');
                $(".step05").addClass('m-active');
                $(".step05 .b-submit__aside-step-inner").addClass('m-active');
         
         

        }, {
                        triggerOnce: false,
                        offset: '55%'
        });
    
    
    



//////////////////////////////
// Animated Entrances
//////////////////////////////



    if (windowWidth > 1200) {

        $(window).scroll(function() {
                $('.animatedEntrance').each(function() {
                        var imagePos = $(this).offset().top;

                        var topOfWindow = $(window).scrollTop();
                        if (imagePos < topOfWindow + 400) {
                                        $(this).addClass("slideUp"); // slideUp, slideDown, slideLeft, slideRight, slideExpandUp, expandUp, fadeIn, expandOpen, bigEntrance, hatch
                        }
                });
        });

    }




/////////////////////////////////////////////////////////////////
// Accordion
/////////////////////////////////////////////////////////////////

    $(".btn-collapse").on('click', function () {
            $(this).parents('.panel-group').children('.panel').removeClass('panel-default');
            $(this).parents('.panel').addClass('panel-default');
            if ($(this).is(".collapsed")) {
                $('.panel-title').removeClass('panel-passive');
            }
            else {$(this).next().toggleClass('panel-passive');
        };
    });




/////////////////////////////////////
//  Chars Start
/////////////////////////////////////

    if ($('body').length) {
            $(window).on('scroll', function() {
                    var winH = $(window).scrollTop();

                    $('.list-progress').waypoint(function() {
                            $('.chart').each(function() {
                                    CharsStart();
                            });
                    }, {
                            offset: '80%'
                    });
            });
    }


        function CharsStart() {
            $('.chart').easyPieChart({
                    barColor: false,
                    trackColor: false,
                    scaleColor: false,
                    scaleLength: false,
                    lineCap: false,
                    lineWidth: false,
                    size: false,
                    animate: 7000,

                    onStep: function(from, to, percent) {
                            $(this.el).find('.percent').text(Math.round(percent));
                    }
            });

        }




/////////////////////////////////////////////////////////////////
// Сustomization select
/////////////////////////////////////////////////////////////////

    $('.jelect').jelect();



/////////////////////////////////////
//  Zoom Images
/////////////////////////////////////




    
	$( ' slider-gallery__link , .zoom , .swipebox , .widget-slider__item a , .slider-gallery__link , .car-details .flexslider a.prettyPhoto , .isotope-item a ' ).magnificPopup({type: 'image'});
    
    

    
    
        
        
$(".fl-magic-popup a").magnificPopup({
    type: 'image',
    gallery: {
        enabled: true,
        tPrev: 'Previous',
        tNext: 'Next',
        tCounter: '<span class="mfp-counter">%curr% / %total%</span>' // markup of counter
    },
    image: {
        markup:
            '<div class="mfp-figure">'+
            '<div class="mfp-img"></div>'+
            '</div>'+
            '<div class="mfp-close"></div>'+
            '<div class="mfp-bottom-bar">'+
            '<div class="mfp-title"></div>'+
            '<div class="mfp-counter"></div>' +
            '</div>'
    },
    iframe: {
        markup: '<div class="mfp-iframe-scaler">'+
            '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>'+
            '</div>'+
            '<div class="mfp-close"></div>'
    },
    mainClass: 'mfp-zoom-in',
    removalDelay: 300,
    callbacks: {
        open: function () {
            $.magnificPopup.instance.next = function () {
                var self = this;
                self.wrap.removeClass('mfp-image-loaded');
                setTimeout(function () {
                    $.magnificPopup.proto.next.call(self);
                }, 120);
            };
            $.magnificPopup.instance.prev = function () {
                var self = this;
                self.wrap.removeClass('mfp-image-loaded');
                setTimeout(function () {
                    $.magnificPopup.proto.prev.call(self);
                }, 120);
            }
        },
        imageLoadComplete: function () {
            var self = this;
            setTimeout(function () {
                self.wrap.addClass('mfp-image-loaded');
            }, 16);
        }
    }

});



/////////////////////////////////////////////////////////////////
// Accordion
/////////////////////////////////////////////////////////////////

    $(".btn-collapse").on('click', function () {
            $(this).parents('.panel-group').children('.panel').removeClass('panel-default');
            $(this).parents('.panel').addClass('panel-default');
            if ($(this).is(".collapsed")) {
                $('.panel-title').removeClass('panel-passive');
            }
            else {$(this).next().toggleClass('panel-passive');
        };
    });




/////////////////////////////////////////////////////////////////
// Filter accordion
/////////////////////////////////////////////////////////////////


$('.js-filter').on('click', function() {
        $(this).prev('.wrap-filter').slideToggle('slow')});

$('.js-filter').on('click', function() {
        $(this).toggleClass('filter-up filter-down')});



     
    
$('.mobile-filter-btn').on('click', function(e) {
    
    
    $('.sticky-bar .sidebar').addClass('sidebar-show');
    $('.mobile-menu-trigger').show(); 
    
});
    
    
    $('.mobile-menu-trigger').on('click', function(e) {
    
    
 $('.sticky-bar .sidebar').removeClass('sidebar-show');
 $('.mobile-menu-trigger').hide();
    
    
});
    
    

    
////////////////////////////////////////////
// CAROUSEL PRODUCTS
///////////////////////////////////////////



    if ($('#slider-product').length > 0) {

        // The slider being synced must be initialized first
        $('#carousel-product').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
             smoothHeight:true,
            itemWidth: 120,
            itemMargin: 8,
            asNavFor: '#slider-product'
        });

        $('#slider-product').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            smoothHeight:true,
            sync: "#carousel-product"
        });
    }


    
   
    
    
     $(".col-md-9 .related .products").each(function(i) {
               
               
                $(this).owlCarousel({
                items : 3,
                itemsCustom : false,
                itemsDesktop : [1199,4],
                itemsDesktopSmall : [980,3],
                itemsTablet: [768,2],
                itemsTabletSmall: false,
                itemsMobile : [479,1],
                singleItem : false,
                itemsScaleUp : false,
                slideSpeed : 200,
                paginationSpeed : 800,
                rewindSpeed : 1000,
                autoPlay : true,
                stopOnHover : true,
                navigation : false,
                pagination : true,
                paginationNumbers: false,   
            })
               
       });

    
           $(".home-template .products.columns-5").each(function(i) {
               
               
                $(this).owlCarousel({
                items : 5,
                itemsCustom : false,
                itemsDesktop : [1199,4],
                itemsDesktopSmall : [980,3],
                itemsTablet: [768,2],
                itemsTabletSmall: false,
                itemsMobile : [479,1],
                singleItem : false,
                itemsScaleUp : false,
                slideSpeed : 200,
                paginationSpeed : 800,
                rewindSpeed : 1000,
                autoPlay : true,
                stopOnHover : true,
                navigation : false,
                pagination : true,
                paginationNumbers: false,   
            })
               
       });
  
            
            
           $(".home-template .products.columns-4").each(function(i) {
               
               
                $(this).owlCarousel({
                items : 4,
                itemsCustom : false,
                itemsDesktop : [1199,4],
                itemsDesktopSmall : [980,3],
                itemsTablet: [768,2],
                itemsTabletSmall: false,
                itemsMobile : [479,1],
                singleItem : false,
                itemsScaleUp : false,
                slideSpeed : 200,
                paginationSpeed : 800,
                rewindSpeed : 1000,
                autoPlay : true,
                stopOnHover : true,
                navigation : false,
                pagination : true,
                paginationNumbers: false,   
            })
               
       });
         
    
            
                      
           $(".home-template .products.columns-3").each(function(i) {
               
               
                $(this).owlCarousel({
                items : 3,
                itemsCustom : false,
                itemsDesktop : [1199,4],
                itemsDesktopSmall : [980,3],
                itemsTablet: [768,2],
                itemsTabletSmall: false,
                itemsMobile : [479,1],
                singleItem : false,
                itemsScaleUp : false,
                slideSpeed : 200,
                paginationSpeed : 800,
                rewindSpeed : 1000,
                autoPlay : true,
                stopOnHover : true,
                navigation : false,
                pagination : true,
                paginationNumbers: false,   
            })
               
       });
         
    
            
               
    
    
/////////////////////////////////////
//  SCROLL TOP
/////////////////////////////////////
    
    
     $(document).on("click", ".footer__btn", function (event) {
        event.preventDefault();

        $('html, body').animate({
            scrollTop: 0
        }, 300);
    });



 




/////////////////////////////////////////////////////////////////
// Sliders
/////////////////////////////////////////////////////////////////

    var Core = {

        initialized: false,

        initialize: function() {

                if (this.initialized) return;
                this.initialized = true;

                this.build();

        },

        build: function() {

        // Owl Carousel

            this.initOwlCarousel();
        },
        initOwlCarousel: function(options) {

                        $(".enable-owl-carousel").each(function(i) {
                            var $owl = $(this);

                            var itemsData = $owl.data('items');
                            var navigationData = $owl.data('navigation');
                            var paginationData = $owl.data('pagination');
                            var singleItemData = $owl.data('single-item');
                            var autoPlayData = $owl.data('auto-play');
                            var transitionStyleData = $owl.data('transition-style');
                            var mainSliderData = $owl.data('main-text-animation');
                            var afterInitDelay = $owl.data('after-init-delay');
                            var stopOnHoverData = $owl.data('stop-on-hover');
                            var min480 = $owl.data('min480');
                            var min768 = $owl.data('min768');
                            var min992 = $owl.data('min992');
                            var min1200 = $owl.data('min1200');

                            $owl.owlCarousel({
                                navigation : navigationData,
                                pagination: paginationData,
                                singleItem : singleItemData,
                                autoPlay : autoPlayData,
                                transitionStyle : transitionStyleData,
                                stopOnHover: stopOnHoverData,
                                navigationText : ["<i></i>","<i></i>"],
                                items: itemsData,
                                itemsCustom:[
                                                [0, 1],
                                                [465, min480],
                                                [750, min768],
                                                [975, min992],
                                                [1185, min1200]
                                ],
                                afterInit: function(elem){
                                            if(mainSliderData){
                                                    setTimeout(function(){
                                                            $('.main-slider_zoomIn').css('visibility','visible').removeClass('zoomIn').addClass('zoomIn');
                                                            $('.main-slider_fadeInLeft').css('visibility','visible').removeClass('fadeInLeft').addClass('fadeInLeft');
                                                            $('.main-slider_fadeInLeftBig').css('visibility','visible').removeClass('fadeInLeftBig').addClass('fadeInLeftBig');
                                                            $('.main-slider_fadeInRightBig').css('visibility','visible').removeClass('fadeInRightBig').addClass('fadeInRightBig');
                                                    }, afterInitDelay);
                                                }
                                },
                                beforeMove: function(elem){
                                    if(mainSliderData){
                                            $('.main-slider_zoomIn').css('visibility','hidden').removeClass('zoomIn');
                                            $('.main-slider_slideInUp').css('visibility','hidden').removeClass('slideInUp');
                                            $('.main-slider_fadeInLeft').css('visibility','hidden').removeClass('fadeInLeft');
                                            $('.main-slider_fadeInRight').css('visibility','hidden').removeClass('fadeInRight');
                                            $('.main-slider_fadeInLeftBig').css('visibility','hidden').removeClass('fadeInLeftBig');
                                            $('.main-slider_fadeInRightBig').css('visibility','hidden').removeClass('fadeInRightBig');
                                    }
                                },
                                afterMove: sliderContentAnimate,
                                afterUpdate: sliderContentAnimate,
                            });
                        });
            function sliderContentAnimate(elem){
                var $elem = elem;
                var afterMoveDelay = $elem.data('after-move-delay');
                var mainSliderData = $elem.data('main-text-animation');
                if(mainSliderData){
                                setTimeout(function(){
                                                $('.main-slider_zoomIn').css('visibility','visible').addClass('zoomIn');
                                                $('.main-slider_slideInUp').css('visibility','visible').addClass('slideInUp');
                                                $('.main-slider_fadeInLeft').css('visibility','visible').addClass('fadeInLeft');
                                                $('.main-slider_fadeInRight').css('visibility','visible').addClass('fadeInRight');
                                                $('.main-slider_fadeInLeftBig').css('visibility','visible').addClass('fadeInLeftBig');
                                                $('.main-slider_fadeInRightBig').css('visibility','visible').addClass('fadeInRightBig');
                                }, afterMoveDelay);
                }
            }
        },

    };

    Core.initialize();

});

/* Add Active class to List/Grid button on Vehicle Listings*/
	
if ($('#pixad-listing').hasClass('grid')) {
	$('.sorting__item.view-by .grid').addClass('active')
}else{
	$('.sorting__item.view-by .list').addClass('active')
}	
 
    
    /* Grid Height */
    
 $.fn.equivalent = function (){
        var $blocks = $(this), 
            maxH    = $blocks.eq(0).height(); 

        $blocks.each(function(){
           
            maxH = ( $(this).height() > maxH ) ? $(this).height() : maxH;
           
        });

        $blocks.height(maxH); 
    }

    $('.grid .slider-grid__inner').equivalent(); 
    
    
    
    


        function compare_auto_rsdggsdgsg3() {
        jQuery('.add-car-to-site').addClass('add-car-to-site-visible');
        setTimeout(function func() {
            jQuery('.add-car-to-site').removeClass('add-car-to-site-visible');
        }, 10000);
    }
    
	compare_auto_rsdggsdgsg3();
	


// COMMENT RAITING
    $("body").on("init", "#rating-autos", function() {
        $("#rating-autos").hide().before('<p class="stars"><span><a class="star-1" href="#">1</a><a class="star-2" href="#">2</a><a class="star-3" href="#">3</a><a class="star-4" href="#">4</a><a class="star-5" href="#">5</a></span></p>')
    }).on("click", "#respond p.stars a", function() {
        var e = $(this)
          , t = $(this).closest("#respond").find("#rating-autos")
          , i = $(this).closest(".stars");
        return t.val(e.text()),
        e.siblings("a").removeClass("active"),
        e.addClass("active"),
        i.addClass("selected"),
        !1
    }),
    $("#rating-autos").trigger("init");
    
}(jQuery));






    
