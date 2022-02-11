;
jQuery(document).ready(function() {
	"use strict";

	function setCookie(name, value, options) {
		options = options || {};

		var expires = options.expires;

		if (typeof expires == "number" && expires) {
			var d = new Date();
			d.setTime(d.getTime() + expires * 1000);
			expires = options.expires = d;
		}
		if (expires && expires.toUTCString) {
			options.expires = expires.toUTCString();
		}

		value = encodeURIComponent(value);

		var updatedCookie = name + "=" + value;

		for (var propName in options) {
			updatedCookie += "; " + propName;
			var propValue = options[propName];
			if (propValue !== true) {
				updatedCookie += "=" + propValue;
			}
		}

		document.cookie = updatedCookie;
	}
	function getCookie(name) {
	  var matches = document.cookie.match(new RegExp(
	    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
	  ));
	  return matches ? decodeURIComponent(matches[1]) : undefined;
	}

	//добавить/удалить куки для сравнения авто
	function compare_auto_id(id, titleAuto, $obj = null) {
		var c1 = getCookie("add-to-compare0");
		var c2 = getCookie("add-to-compare1");
		var c3 = getCookie("add-to-compare2");
		var compare = [c1, c2, c3];
		var cookieOptions = {
			expires: 864000,
			path: '/'
		};

		for (var i = 0; i < compare.length; i++) {
			if (compare[i] == id) {
				setCookie('add-to-compare' + i, null, cookieOptions);
				compare_auto_update_counter(0, titleAuto, $obj);
				return;
			}
		}
		for (var i = 0; i < compare.length; i++) {
			var inte = parseInt(compare[i], 10);
			if (!inte) {
				setCookie('add-to-compare' + i, id, cookieOptions);
				compare_auto_update_counter(1, titleAuto, $obj);
				return;
			}
		}
		if (compare.length === 3) {
			compare_auto_more3();
			compare_auto_update_counter(-1);
		}
	}

	function getIdFavorite() {

		var cook;
		if(getCookie("compare_favoriteID") === undefined){
			cook = '';
			return cook.split(',');
		}else{
			cook =  getCookie("compare_favoriteID").toString();
			return cook.split(',');
		}
		
	}
//удалить старые id
	function delete_cookie_old(argument) {
		var cookieOptions = {
			expires: 864000,
			path: '/'
		};
		var mass = [];
		var arrCook = getIdFavorite();
		for (var i = 0; i < arrCook.length; i++) {
			var num = Number(arrCook[i]);
			var ar = [];
			ar = document.compare_cars_data.idsAutos.split(',');
			var flag = false;
			for (var j = 0; j < ar.length; j++) {
				if(ar[j] == num){
					flag = true;
				}
			}
			if(!flag) mass.push(i);
		}
		for (var i = mass.length-1; i >= 0; i--) {
			arrCook.splice(mass[i], 1);
		}
		arrCook.unshift('');
		setCookie('compare_favoriteID', arrCook, cookieOptions);
	}
		//добавить/удалить куки для любимого авто
	function setCookieFavorite(id) {
		
		var cookieOptions = {
			expires: 864000,
			path: '/'
		};
		var arrCook = getIdFavorite();
		for (var i = 0; i < arrCook.length; i++) {
			var num = Number(arrCook[i]);
			if (num == id ) {
				arrCook.splice(i, 1);
				if(arrCook.length === 0){
					arrCook.push('');
				} 
				setCookie('compare_favoriteID', arrCook, cookieOptions);
				updateIconFavorite(0, '---------', arrCook, id);
				delete_cookie_old();
				return;
			}
		}
			var inte = parseInt(arrCook[i], 10);
			if (!inte) {
				if(arrCook.length === 0){
					arrCook.push('');
				} 
				arrCook.push(id);
				setCookie('compare_favoriteID', arrCook, cookieOptions);
				updateIconFavorite(1, '+++++++++', arrCook, id);
				delete_cookie_old();
				return;
			}
	}
	//подсказка больше 3 
	function compare_auto_more3() {
		jQuery('.single-add-to-compare').addClass('single-add-to-compare-visible');
		jQuery('.single-add-to-compare').find('.auto-title').text(document.compare_cars_data.description.over);
		setTimeout(function func() {
			jQuery('.single-add-to-compare').removeClass('single-add-to-compare-visible');
		}, 2500);
	}


	//обновить пояснение
	function compare_auto_update_counter(flag, autoTitle = '', $obj = null) {

		var c1 = getCookie("add-to-compare0");
		var c2 = getCookie("add-to-compare1");
		var c3 = getCookie("add-to-compare2");
		var compare = [c1, c2, c3];
		var counter = 0;
		for (var i = 0; i < compare.length; i++) {
			if (compare[i] != undefined)
				if (compare[i] != null && +compare[i]) {
					counter++;
				}
		}
		var $text = jQuery('.current-cars-in-compare');
		if ($text.data('counter') == 'compare-count') $text.text(counter);

		//добавит в сравнения
		if (flag === 1) {

			$obj.removeClass('active-remove-compare');
			$obj.addClass('active-add-compare');

			jQuery('.single-add-to-compare').addClass('single-add-to-compare-visible');
			jQuery('.single-add-to-compare').find('.auto-title').text(autoTitle + document.compare_cars_data.description.add);
			setTimeout(function func() {
				jQuery('.single-add-to-compare').removeClass('single-add-to-compare-visible');
			}, 2500);
		} else if (flag === 0) { //удалит из сравнения

			$obj.removeClass('active-add-compare');
			$obj.addClass('active-remove-compare');

			jQuery('.single-add-to-compare').addClass('single-add-to-compare-visible');
			jQuery('.single-add-to-compare').find('.auto-title').text(autoTitle + document.compare_cars_data.description.remove);
			setTimeout(function func() {
				jQuery('.single-add-to-compare').removeClass('single-add-to-compare-visible');
			}, 2500);
		}

	}
	function updateIconFavorite(flag, autoTitle = '', cookie, id = -1) {

		var $text = jQuery('.current-cars-in-favorite');
		var cook = [];
		 for (var i = cookie.length; i > 0; i--) {
	    if (cookie[i] != null) {
	    	cook.unshift(cookie[i]);
	     }
	   }
		if ($text.data('counter') == 'favorite-count') $text.text(cook.length);

		if (flag === 1) {
			jQuery('.car-favorite').each(function(index, el) {
				if(jQuery(this).data('id') == id){
					jQuery(this).addClass('active-add-favorite');
				} 
			});
		} else if (flag === 0) { //удалит из сравнения
			jQuery('.car-favorite').each(function(index, el) {
				if(jQuery(this).data('id') == id){
					jQuery(this).removeClass('active-add-favorite');
				} 
			});
		}
	}

	(function($) {

		function add_action_compare(argument) {
			//добавить/удалить для сравнения
		$('.add-to-compare').on('click', '', function(e) {
			var compare;
			if ($(this).data('action') === 'add') {
				var auto = $(this).closest('div').find('.car-details__title').text();
				var v_new = $(this).data('id');
				compare_auto_id(v_new, auto, $(this));

			}
			});
		//добавить/удалить в любимое
		$('.car-favorite').on('click', '', function(e) {
		var arrCook = getIdFavorite();

			if ($(this).data('action') === 'add-favorite') {
				var auto = $(this).closest('div').find('.car-details__title').text();
				var v_new = $(this).data('id');
				var arrCook = getIdFavorite();
				setCookieFavorite(v_new);
			}
		});
		//стартовые активные классы фаворитов
		$('.car-favorite').each(function(index, el) {
			if ($(this).data('action') === 'add-favorite') {
				var id = $(this).data('id');
				var arrCook = getIdFavorite();
				for (var i = 0; i < arrCook.length; i++) {
					var num = Number(arrCook[i]);
					if (num == id ) {
						jQuery(this).addClass('active-add-favorite');
					}
				}
			}
		});
		//стартовые активные классы сравнения
		$('.add-to-compare').each(function(index, el) {
			if ($(this).data('action') === 'add') {
				var id = $(this).data('id');
				var c1 = getCookie("add-to-compare0");
				var c2 = getCookie("add-to-compare1");
				var c3 = getCookie("add-to-compare2");
				var compare = [c1, c2, c3];
				for (var i = 0; i < compare.length; i++) {
					var num = Number(compare[i]);
					if (num == id ) {
						jQuery(this).addClass('active-add-compare');
					}
				}
			}
		});
		}
		
		add_action_compare();
		compare_auto_update_counter(-1);
		updateIconFavorite(-1, '',getIdFavorite());

		$(document).on('filterRefreeshPage', '', function(event) {

			event.preventDefault();
			add_action_compare();		
		});
			
	})(jQuery);
});