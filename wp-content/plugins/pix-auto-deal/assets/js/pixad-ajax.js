jQuery(document).ready(function($) 
{
	/**
	 * @param state - (object) current object { name_of_param : value }
	 * @param value - (string) part of url like: &name_of_param=value
	 * @param title - (string) title
	 */
	Date.prototype.yyyymmdd = function() {
		var mm = this.getMonth() + 1; // getMonth() is zero-based
		var dd = this.getDate();

		return [this.getFullYear(),
			(mm>9 ? '' : '0') + mm,
			(dd>9 ? '' : '') + dd
		].join('/');
	};
	function datediff(first, second) {
		return Math.round((second-first)/(1000*60*60*24));
	}
	function toDay(s) {
		var a = s.split("/");
		return [ a[0]];
	}
	function toMonth(s) {
		var a = s.split("/");
		return [ a[1]];
	}
	function toYear(s) {
		var a = s.split("/");
		return [ a[2]];
	}




	var getUrlParameter = function getUrlParameter(sParam) {
		var sPageURL = window.location.search.substring(1),
			sURLVariables = sPageURL.split('&'),
			sParameterName,
			i;
		for (i = 0; i < sURLVariables.length; i++) {
			sParameterName = sURLVariables[i].split('=');
			if (sParameterName[0] === sParam) {
				return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
			}
		}
	};
	var body = getUrlParameter('body');
	var state = { 'body' : body };
	var title = title || '';
	pix_change_url(state, title);





	function pix_change_url(state, title ){
		title = title || '';
		var data = {
			action: 'process_reservation',
			post_style: $('#pixad-listing').attr("class"),
			nonce: pixadAjax.nonce
		};
		var currentState = history.state == null ? {} : history.state;
		var url_str = '';

		$.extend( currentState, state );
		if($('#sort-purpose').val() != ''){
			var purpose = { 'purpose' : $('#sort-purpose').val() }
			$.extend( currentState, purpose );
		}

		$.each( currentState, function( key, val ) {
			if(val != '')
				url_str = url_str + "&" + key + "=" + val;
		});

		url_str = url_str.replace('&','?');

		history.pushState(currentState, title, url_str);
		$.extend( data, currentState );
		return data;

	}

	function goToByScroll(id){
		// console.log('goToByScrol');
	    $('html,body').animate({
	        scrollTop: $('#pix-sorting').offset().top - 110
	    }, 700);
	}

	function showAjaxLoader(){
		// console.log('showAjaxLoader');
		var autos_ajax_scroll_up = $('#pix-sorting').attr('data-ajax_scroll');
		// console.log(autos_ajax_scroll_up);
		if(autos_ajax_scroll_up != '0'){
			goToByScroll();
		}
		

		
		$('#filter_loader').show();
		$('.pix-ajax-loader').addClass('ajax-loading');
	}

	function hideAjaxLoader(){
        $('#filter_loader').hide();
          
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

		$('.pix-ajax-loader').removeClass('ajax-loading');
		pageClick();
	}

    $('#jelect-page').on( 'change', function (e) {
        showAjaxLoader();
        e.preventDefault();
		var state = { 'per_page' : this.value }
		var data = pix_change_url(state, 'per page');
        $.get( pixadAjax.url, data, function( response ){
                //console.log('AJAX response : ',response.data);
                $('#pixad-listing').html(response.data);
                $(document).trigger('filterRefreeshPage');
                hideAjaxLoader();
        });
    });

    $('#jelect-sort').on( 'change', function (e) {
        showAjaxLoader();
        e.preventDefault();

		var state = { 'order' : this.value }
		var data = pix_change_url(state, 'order');

        $.get( pixadAjax.url, data, function( response ){
                //console.log('AJAX response : ',response.data);
                $('#pixad-listing').html(response.data);
                $(document).trigger('filterRefreeshPage');
                hideAjaxLoader();

        });
    });

    $('#ajax-make').on( 'change', function (e) {
        e.preventDefault();
        var make_val = $(this).val();
        var args = {};
        args['make'] = '';
        pix_change_url(args, 'make');
        args['model'] = '';
        pix_change_url(args, 'model');
		var data = {
            action: 'process_reservation',
            nonce: pixadAjax.nonce,
            make_model: make_val,
        };
        $.get( pixadAjax.url, data, function( response ){
            //console.log('AJAX response : ',response.data);
            $('.jelect-options.pixad-model').html(response.data);
            $('.jelect-current.pixad-model').html($('.pixad-model-default-hidden').val());

        });

        showAjaxLoader();
        var args = {};
        if(make_val.length > 0) {
            args['make'] = make_val;
        }
        else
            args['make'] = '';
        var data = pix_change_url(args, 'make');
		//console.log('AJAX data : ',data);
        $.get( pixadAjax.url, data, function( response ){
            //console.log('AJAX response : ',response.data);
            $('#pixad-listing').html(response.data);
            $(document).trigger('filterRefreeshPage');
            hideAjaxLoader();

        });
    });

	$('#ajax-dealer').on( 'change', function (e) {
		e.preventDefault();
		var dealer_val = $(this).val();
		var args = {};
		args['dealer'] = '';
		pix_change_url(args, 'dealer');
		args['model'] = '';
		pix_change_url(args, 'model');
		var data = {
			action: 'process_reservation',
			nonce: pixadAjax.nonce,
			make_model: dealer_val,
		};
		$.get( pixadAjax.url, data, function( response ){
			//console.log('AJAX response : ',response.data);
			$('.jelect-options.pixad-model').html(response.data);
			$('.jelect-current.pixad-model').html($('.pixad-model-default-hidden').val());

		});

		showAjaxLoader();
		var args = {};
		if(dealer_val.length > 0) {
			args['dealer'] = dealer_val;
		}
		else
			args['dealer'] = '';
		var data = pix_change_url(args, 'dealer');
		//console.log('AJAX data : ',data);
		$.get( pixadAjax.url, data, function( response ){
			//console.log('AJAX response : ',response.data);
			$('#pixad-listing').html(response.data);
			$(document).trigger('filterRefreeshPage');
			hideAjaxLoader();

		});
	});

	function pageClick() {
		$('.pixad-paging li a').click(function (e) {
			e.preventDefault();
			showAjaxLoader();

			var state = {'paged': $(this).data('page')}
			var data = pix_change_url(state, 'paged');
			//console.log(data);

			$.get(pixadAjax.url, data, function (response) {
				//console.log('AJAX response : ',response.data);
				$('#pixad-listing').html(response.data);
				$(document).trigger('filterRefreeshPage');
				hideAjaxLoader();
			});
		});
	}
	$("#pixad-car-locator-lat").change(function (e) {

		showAjaxLoader();
		e.preventDefault();
		$(this).blur();
		var args = {};
		alert('changed');

		if ($(this).attr("id") == "pixad-car-locator-lat") {
			args_radius = $('#car-locator-radius').val();
			args_lat = $(this).val();
			args_long = $('#pixad-car-locator-long').val();
			if(args_radius.length > 0) {
				args['radius'] =  args_radius;
			}
			else{
				args['radius'] = '';
			}
			if(args_lat.length > 0) {
				args['lat'] =  args_lat;
			}
			else{
				args['lat'] = '';
			}
			if(args_long.length > 0) {
				args['long'] =  args_long;
			}
			else{
				args['long'] = '';
			}
		}
		if ($(this).attr("id") == "pixad-car-locator-long") {
			args_radius = $('#car-locator-radius').val();
			args_lat = $('#pixad-car-locator-lat').val();
			args_long = $(this).val();
			if(args_radius.length > 0) {
				args['radius'] =  args_radius;
			}
			else{
				args['radius'] = '';
			}
			if(args_lat.length > 0) {
				args['lat'] =  args_lat;
			}
			else{
				args['lat'] = '';
			}
			if(args_long.length > 0) {
				args['long'] =  args_long;
			}
			else{
				args['long'] = '';
			}
		}

		var data = pix_change_url(args, 'filter');
		//console.log('AJAX data : ',data);
		$.get( pixadAjax.url, data, function( response ){
			//console.log('AJAX response : ',response.data);
			$('#pixad-listing').html(response.data);
			$(document).trigger('filterRefreeshPage');


			hideAjaxLoader();
		});
	});



	$("input[name^='pixad-']").on( 'change', function (e) {

		
		e.preventDefault();
		$(this).blur();
		var args = {};
		var args_str = '';
		var type = $(this).data('type'); // check - checkbox, number - input with int, text - input with string, jelect - select
		var field = $(this).data('field');

		showAjaxLoader();

	// console.log('input change');
	// console.log('type : ',type);
	// console.log('field : ',field);

		if(type == 'check'){
			$("[name^='pixad-"+field+"']").each(function(key,val) {
				if( $(this).prop( "checked" ) ){
					args_str = args_str + ',' + $(this).val();
				}
			});
			if(args_str.length > 0) {
				args_str = args_str.replace(',', '');
				args[field] = args_str;
			}
			else
				args[field] = '';
		}
		if(type == 'number'){
			$("[name^='pixad-"+field+"']").each(function(key,val) {
				var current_number = $(this).val();
				current_number = current_number.replace(/\D/g, "");
				/* if( Number($(this).val())>=0 ){
					args_str = args_str + ',' + Number($(this).val()); */
				if( current_number>=0 ){
					args_str = args_str + ',' + current_number;
				}
			});
			if(args_str.length > 0) {
				args_str = args_str.replace(',', '');
				args[field] = args_str;
			}
			else
				args[field] = '';
		}

		if($(this).attr("id") == 'slider-price_min-two'){
			$("[name^='pixad-"+field+"']").each(function(key,val) {
				var current_number = $(this).val();
				current_number = current_number.replace(/\D/g, "");
				/* if( Number($(this).val())>=0 ){
					args_str = args_str + ',' + Number($(this).val()); */
				console.log('AJAX response : ', current_number);


				if( current_number>=0 ){
					args_str = 0 + ',' + args_str;
				}
			});
			if(args_str.length > 0) {
				args_str = args_str.replace(',', '');
				args[field] = args_str;
			}
			else
				args[field] = '0';
		}

		if(type == 'jelect'){
			args_str = $('#pixad-'+field).val();

			if(args_str.length > 0) {
				args[field] = args_str;
			}
			else
				args[field] = '';
		}
		//Car Location Radius Filter
		if ($(this).attr("id") == "car-locator-radius") {
			args_radius = $('#car-locator-radius').val();
			args_long = $('#pixad-car-locator-long').val();
			args_lat = $('#pixad-car-locator-lat').val();
			if(args_radius.length > 0) {
				args['radius'] =  args_radius;
			}
			else{
				args['radius'] = '';
			}
			if(args_lat.length > 0) {
				args['lat'] =  args_lat;
			}
			else{
				args['lat'] = '';
			}
			if(args_long.length > 0) {
				args['long'] =  args_long;
			}
			else{
				args['long'] = '';
			}
		}


		var data = pix_change_url(args, 'filter');

		//console.log('AJAX data : ',data);
		$.get( pixadAjax.url, data, function( response ){
			//console.log('AJAX response : ',response);
			$('#pixad-listing').html(response.data);
			$(document).trigger('filterRefreeshPage');
			hideAjaxLoader();
		});
	});

    $('#pixad-filter').on( 'click', function (e) {
        showAjaxLoader();
        //return 1;
        e.preventDefault();
	    var args = {};
	    var filter = $('.pixad-filter');
	    $('.pixad-filter').each(function(i,elem) {
	        var args_str = '';
	        var type = $(this).data('type'); // check - checkbox, number - input with int, text - input with string, jelect - select
	        var field = $(this).data('field');
	        if(type == 'check'){
	            $(this).find("[name*='pixad-']").each(function(key,val) {
					if( $(this).prop( "checked" ) ){
						args_str = args_str + ',' + $(this).val();
					}
				});
				if(args_str.length > 0) {
					args_str = args_str.replace(',', '');
					args[field] = args_str;
				}
				else
					args[field] = '';
	        }
	        if(type == 'number'){
	            $(this).find("[name*='pixad-']").each(function(key,val) {
					if( Number($(this).val())>=0 ){
						args_str = args_str + ',' + Number($(this).val());
					}
				});
				if(args_str.length > 0) {
					args_str = args_str.replace(',', '');
					args[field] = args_str;
				}
				else
					args[field] = '';
	        }
	        if(type == 'jelect'){
		        args_str = $('#pixad-'+field).val();
				if(args_str.length > 0) {
					args[field] = args_str;
				}
				else
					args[field] = '';
	        }


			//Car Location Radius Filter
			if ($(this).attr("id") == "car-locator-radius") {
				args_radius = $('#car-locator-radius').val();
				args_long = $('#pixad-car-locator-long').val();
				args_lat = $('#pixad-car-locator-lat').val();
				if(args_radius.length > 0) {
					args['radius'] =  args_radius;
				}
				else{
					args['radius'] = '';
				}
				if(args_lat.length > 0) {
					args['lat'] =  args_lat;
				}
				else{
					args['lat'] = '';
				}
				if(args_long.length > 0) {
					args['long'] =  args_long;
				}
				else{
					args['long'] = '';
				}
			}


		});

		var data = pix_change_url(args, 'filter');
		//onsole.log('AJAX data : ',data);
        $.get( pixadAjax.url, data, function( response ){
            //console.log('AJAX response : ',response.data);
            $('#pixad-listing').html(response.data);
            $(document).trigger('filterRefreeshPage');
            hideAjaxLoader();

        });

    });

    $('#pixad-reset-button').on('click', function (e) {
        e.preventDefault();
		window.location.href = $(this).data('href');
    });

});