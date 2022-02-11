jQuery.noConflict()(function($) {

    "use strict";
    var $window = window,
        bookin_previe_calendar = $('.booking-preview-calendar');



    function datediff(first, second) {
        return Math.round((second-first)/(1000*60*60*24));
    }
    function to21(s) {
        var a = s.split(" ");
        return [ a[0]];
    }
    function toDay(s) {
        var a = s.split("/");
        return ['0' + a[0]];
    }
    function toMonth(s) {
        var a = s.split("/");
        return [ a[1]];
    }
    function toYear(s) {
        var a = s.split("/");
        return [ a[2]];
    }

    // Booking Preview
    $window.initBookingPreview = function(){
            var bookin_previe_calendar = $('.booking-preview-calendar'),
                rental_time_item = $('.rental-table-item-timer');
            rental_time_item.each(function( index ) {
                var $this = $(this);
                console.log( $this );
            });
            if($('#booking-calendar-data').length){
                var BookedDates = JSON.parse($('#booking-calendar-data').val());

                var allPixbaBookedDay = [];
                BookedDates.forEach(function (element) {
                    var startDate = to21(element['start']);
                    var dayStart = toDay(startDate[0]);
                    var monthStart = toMonth(startDate[0]);
                    var yearStart = toYear(startDate[0]);

                    var finishDate = to21(element['end']);
                    var dayfinish = toDay(finishDate[0]);
                    var monthfinish = toMonth(finishDate[0]);
                    var yearfinish = toYear(finishDate[0]);

                    var startTimeStr = {};
                    let startTime  = new Date(monthStart[0] + '/' + dayStart[0] + '/' + yearStart[0]);
                    startTimeStr['start'] =  monthStart[0] + '/' + dayStart[0] + '/' + yearStart[0] + ' 00:00';
                    startTimeStr['end'] =  monthfinish[0] + '/' + dayfinish[0] + '/' + yearfinish[0] + ' 23:59';



                    allPixbaBookedDay.push(startTimeStr);



                })
            }


        if(bookin_previe_calendar.length){
                var events = [
                    {
                        start:moment().add(7, 'days').calendar(),
                        end: moment().add(9, 'days').calendar(),
                    },
                    {
                        start:moment().subtract(7, 'days').calendar(),
                    },
                    {
                        start:moment().add(19, 'days').calendar(),
                        end: moment().add(22, 'days').calendar(),
                    },
                ];
                if(!bookin_previe_calendar.hasClass('preview-calendar')){
                    var lang = $('#pixad_calendar_lang').val();

                    bookin_previe_calendar.fullCalendar({
                        header: {
                            left: 'title',
                            right: 'prev,next'
                        },
                        formatDate: 'j/m/Y',
                        editable: false,
                        eventLimit: true,
                        //events: [{start: "06/01/2020 23:52",  end: "06/06/2020 23:52"}],
                        events: allPixbaBookedDay,
                        lang: lang
                    });

                } else {
                    var lang = $('#pixad_calendar_lang').val();

                    bookin_previe_calendar.fullCalendar({
                        header: {
                            left: 'title',
                            right: 'prev,next'
                        },
                        defaultDate: moment().date(1),
                        editable: false,
                        eventLimit: true,
                        events: events,
                        lang: lang
                    });
                }
            };
    };



    $window.initBookingPreview();


});