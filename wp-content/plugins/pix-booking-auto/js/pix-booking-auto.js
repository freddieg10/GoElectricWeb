jQuery(document).ready(function ($) {
	"use strict";

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
	function to21(s) {
		var a = s.split(" ");
		return [ a[0]];
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

	// все даты бронирования
	var allPixbaBookedDay = [];
	pixbaBookedDay.forEach(function(element) {

		// let startTime   = new Date(Date.parse(element['start-time']));
		// let finishTime  = new Date(Date.parse(element['finish-time']));

		var startDate = to21(element['start-time']);
		var dayStart = toDay(startDate[0]);
		var monthStart = toMonth(startDate[0]);
		var yearStart = toYear(startDate[0]);

		var finishDate = to21(element['finish-time']);
		var dayfinish = toDay(finishDate[0]);
		var monthfinish = toMonth(finishDate[0]);
		var yearfinish = toYear(finishDate[0]);


		let startTime  = new Date(monthStart[0] + '/' + dayStart[0] + '/' + yearStart[0]);
		let finishTime = new Date(monthfinish[0] + '/' + dayfinish[0] + '/' + yearfinish[0]);
		let finishTimeStr = dayfinish[0] + '/' + monthfinish[0] + '/' + yearfinish[0];



		let numberDay = datediff(startTime,finishTime)
		let periodDay;
		for (var i = 0; i < numberDay; i++) {
			var arrDay = parseInt(dayStart[0] );
			arrDay = arrDay + i;
			let startTimeStr = arrDay + '/' + monthStart[0] + '/' + yearStart[0];

			allPixbaBookedDay.push(startTimeStr);
		}
		allPixbaBookedDay.push(finishTimeStr);
	});

	var loceleBooking =  $('html').attr('lang');
	if(loceleBooking){
		loceleBooking = loceleBooking.slice(0, 2);
	}else{
		loceleBooking = '';
	}

	var work_days = jQuery('#datetimepicker_simple').data('work_days') + '';
	if (work_days) {
		var work_days_array  = work_days.split(',').map(function(item) {
			return parseInt(item, 10);
		});

	}
	var work_time = jQuery('#datetimepicker_simple').data('work_time');
	if (work_time) {
		var work_time_array  = work_time.split(',');
	}

	var date = new Date();
	var plusDays =  jQuery('#datetimepicker_simple').data('min_date');
	date.setDate(date.getDate() + plusDays);
	var options = {year: 'numeric', month: '2-digit', day: '2-digit' };
	var minDate = date.toLocaleDateString('zh-Hans-CN', options);

	var hide_end_time = jQuery('#datetimepicker_end').attr('class');
	if (hide_end_time == 'hide_end_time') {
		jQuery('#datetimepicker_simple').on('change', function(event) {
			
			var date_end =  new Date( jQuery('#datetimepicker_simple').val() );
			date_end.setDate(date_end.getDate() + 1);

			var curr_date   = date_end.getDate();
			var curr_month  = ("0" + (date_end.getMonth() + 1)).slice(-2);
			var curr_year   = date_end.getFullYear();
			var curr_hour   = ("0" + date_end.getHours()).slice(-2);
			var curr_minute = ("0" + date_end.getMinutes()).slice(-2);

			var format = jQuery('#pixad_format_date').val();
			var formats = jQuery('#pixad_format_date').val();
			if (formats == 'j/m/Y H:i'){
				date_end =  curr_date + "/" + curr_month + "/" + curr_year + " " + curr_hour + ":" + curr_minute;
			} else if(formats == 'm/j/Y H:i'){
				date_end =  curr_month + "/" + curr_date + "/" + curr_year + " " + curr_hour + ":" + curr_minute;
			}else if(formats == 'j/m/Y'){
				date_end =  curr_date + "/" + curr_month + "/" + curr_year;
			}else if(formats == 'm/j/Y'){
				date_end =  curr_month + "/" + curr_date + "/" + curr_year;
			}

			jQuery('#datetimepicker_end').val(date_end);

		});
	}

	console.log(pixbaBookedDayNew);
	if (jQuery('#booking_timepicker').val() == 1){
		var format = jQuery('#pixad_format_date').val();
		var formats = jQuery('#pixad_format_date').val();
		var format_check = jQuery('#pixad_format_date').val();
		var date_to_check;


		if (formats == 'j/m/Y H:i'){
			formats = 'j/m/Y';
		}
		if (formats == 'm/j/Y H:i'){
			formats = 'm/j/Y';
		}



		var datetimepickersBookingPick = jQuery('#datetimepicker_simple, #datetimepicker_end').datetimepicker({
			disabledWeekDays: work_days_array,
			allowTimes: work_time_array,
			format: format,
			defaultTime:'09:00',
			disabledDates: pixbaBookedDayNew,
			formatDate: formats,
			lang: loceleBooking,
			minDate: minDate,
			timepicker: true,
			onSelectTime: cond_logic,
			startDate: minDate
		});


	} else {
		var format = jQuery('#pixad_format_date').val();
		var formats = jQuery('#pixad_format_date').val();
		if (formats == 'j/m/Y H:i'){
			formats = 'j/m/Y';
		}
		if (formats == 'm/j/Y H:i'){
			formats = 'm/j/Y';
		}
		var datetimepickersBookingPick =	jQuery('#datetimepicker_simple, #datetimepicker_end').datetimepicker({
			disabledWeekDays: work_days_array,
			allowTimes: work_time_array,
			format:format,
			defaultTime:'09:00',
			disabledDates: pixbaBookedDayNew,
			formatDate: formats,
			lang: loceleBooking,
			timepicker: false,
			minDate: minDate,
			startDate: minDate
		});
	}



	var date = new Date();
	var plusDays =  jQuery('#pixad-time-start').data('min_date');
	date.setDate(date.getDate() + plusDays);
	var options = {year: 'numeric', month: '2-digit', day: '2-digit' };
	var minDate = date.toLocaleDateString('zh-Hans-CN', options);


	var work_days = jQuery('#pixad-time-start').data('work_days');
	if (work_days) {
		var work_days_array  = work_days.split(',').map(function(item) {
			return parseInt(item, 10);
		});
	}

	$.datetimepicker.setLocale(loceleBooking);

	var format = jQuery('#pixad_format_date_search').val();

	var pixbaInputTime =	jQuery('.pix-input-time').each(function(index, el) {
		jQuery(this).datetimepicker({
			disabledWeekDays: work_days_array,
			timepicker:false,
			format: format,
			formatDate: format,
			minDate: minDate,
			startDate: minDate
		});
	});



	// вкл календарь

	var datetimepickerCalendar = jQuery('#datetimepicker_calendar').periodpicker({
		norange: true, // use only one value
		cells: [1, 1], // show only one month
		lang: loceleBooking,
		resizeButton: false, // deny resize picker
		fullsizeButton: false,
		fullsizeOnDblClick: false,
		disableDays: allPixbaBookedDay,
		formatDate: format,
		inline:true,
		onChange: function () {
		}

	});


	// hide notices

	function noticeHide(){
		$(".booking-notice").addClass('notice-hide');
	}
	setTimeout(noticeHide, 12000);


});

