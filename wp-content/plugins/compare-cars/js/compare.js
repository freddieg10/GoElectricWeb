;
jQuery(document).ready(function() {
	"use strict";
	(function($) {

		//выделить похожие величины
		var $columns = $('.compare-row').children('.compare-col-auto');
		var cellValues = [];
		if ($columns.length > 1) {

			$columns.each(function(i, el) {
				cellValues[i] = [];
				$(this).find('.compare-value-hover').each(function(index, el) {
					if ($(this).data('value')) {
						cellValues[i][index] = $(this).children('div');
					}
				});
			});
			var kit = [0];

			var leng = cellValues.length;
			for (var i = 0; i < cellValues[0].length; i++) {
				for (var j = 1; j < cellValues.length; j++) {
					if (cellValues[0][i].text() === cellValues[j][i].text() && cellValues[j][i].text() !== '') {
						cellValues[0][i].closest('td').addClass('compare-value-equal');
						cellValues[j][i].closest('td').addClass('compare-value-equal');
					}
				}
				for (var j = 2; j < cellValues.length; j++) {
					if (cellValues[1][i].text() === cellValues[j][i].text() && cellValues[j][i].text() !== '') {
						cellValues[1][i].closest('td').addClass('compare-value-equal');
						cellValues[j][i].closest('td').addClass('compare-value-equal');
					}
				}
			}
		}


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
		function compare_auto_update_counter() {

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

		}

		//добавить/удалить куки для сравнения
		$('.remove-from-compare').on('click', '', function(e) {
			if ($(this).data('action') === 'remove') {
				var v_new = $(this).data('id');

				var $header = $(this).parents('.car-listing-row');
				var $head;
				var $body = $header.siblings('.compare-row');
				var $colums = $body.children('.compare-col-auto');
				var $colum;
				$colums.each(function(index, el) {
					var v_id = $(this).data('id');
					if (v_id == v_new) {
						$colum = $(this);
						return;
					}
				});
				var $h5 = $colum.find('.h5');
				$h5.each(function(index, el) {
					$(this).text('');
					$(this).parent().removeClass('compare-value-equal');
				});

				var $item_heders = $header.find('.compare-col-auto-id');
				$item_heders.each(function(index, el) {
					var v_id = $(this).data('id');
					if (v_id == v_new) {
						$head = $(this);
						return;
					}
				});
				$head.html('<a href="' + document.compare_cars_data.idPostTemp + '" class=""><div class="compare-col-auto-empty"><div class="image"><div class="compare-car-img"><div class="compare-add-car"></div><img class="img-compare-none" width="186" height="300"></div></div></div><div class="add-car-search-page"><i class="fa fa-plus" aria-hidden="true"></i></div></a><a class=""><div class="listing-car-item-meta"><div class="car-meta-top heading-font clearfix"></div></div></a>');

				var compare0 = getCookie("add-to-compare0");
				var compare1 = getCookie("add-to-compare1");
				var compare2 = getCookie("add-to-compare2");
				var compare = [compare0, compare1, compare2];
				for (var i = 0; i < compare.length; i++) {
					if (compare[i] == v_new) {
						var cookieOptions = {
							expires: 36000,
							path: '/'
						};
						setCookie('add-to-compare' + i, null, cookieOptions);
						break;
					}
				}
			}
			compare_auto_update_counter();
		});


		//выделить цветом активную строку
		$('.compare-value-hover').hover(function() {
			$(this).toggleClass('compare-value-hover-active');
			var id = $(this).data('value');
			var $tr = $(this).parent('tr');
			var $body = $(this).parents('.compare-col-auto');
			var $colums = $body.siblings('.compare-col-auto');
			$colums.each(function(index, el) {
				var $td = $(this).find('td');
				$td.each(function(index, el) {
					if ($(this).data('value') == id) {
						$(this).toggleClass('compare-value-hover-active');
					}
				});
			});

		});



	})(jQuery);
});