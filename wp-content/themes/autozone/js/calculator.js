jQuery(document).ready(function(){
    autoCalcInit();
});


function autoCalcInit(){
    autoCalcHideMsg();
    autoCalcHideTotal();
    jQuery('a.autozone_calculate_btn').click(function(){

  var pix_thousand = document.getElementById('pix-thousand').value;
  var pix_decimal = document.getElementById('pix-decimal').value;
  var pix_decimal_number = document.getElementById('pix-decimal_number').value;

if (pix_decimal != pix_thousand ) {
jQuery('.vehicle_price, .down_payment').number( true, pix_decimal_number, pix_decimal, pix_thousand);
}
        autoCalcExecute();
        autoCalcShowTotal();
    });
}

function autoCalcExecute(){

    var _currency= jQuery('.orange.currency').html();
        _currency =  _currency.replace(/[()]/g, '');

  var pix_thousand = document.getElementById('pix-thousand').value;
  var pix_decimal = document.getElementById('pix-decimal').value;
  var pix_decimal_number = document.getElementById('pix-decimal_number').value;



    var _price = parseFloat(jQuery('.vehicle_price').val()); // цена авто
    var _rate = parseFloat(jQuery('.interest_rate').val());  // процент
    var _period = parseFloat(jQuery('.period_month').val()); // сколько месяцев
    var _payment = parseFloat(jQuery('.down_payment').val()); // первый взнос





    _rate = _rate/1200;

console.log(_rate );
    var _base_rate = _rate;

    if(_rate == 0) {
        _base_rate = 1;
    }
    _permonthpaywithrate = (_price - _payment) * _base_rate * Math.pow(1 + _rate, _period);
    var _permonthpay = ((Math.pow(1 + _rate, _period)) - 1);
    if(_permonthpay == 0) {
        _permonthpay = 1;
    }

    _permonthpaywithrate = _permonthpaywithrate/_permonthpay;
    _permonthpaywithrate = _permonthpaywithrate.toFixed(0);

    _total_pay = _payment + (_permonthpaywithrate*_period);
    _total_pay = _total_pay.toFixed(0);



    _total_interest_pay = _total_pay - _price;
    _total_interest_pay = _total_interest_pay.toFixed(0);
_total_interest_pay = _total_interest_pay.toLocaleString();

 //   jQuery('.monthly_payment').html(_currency + _permonthpaywithrate);
 //   jQuery('.total_interest_payment ').html(_currency + _total_interest_pay);
 //   jQuery('.total_amount_to_pay').html(_currency+_total_pay);

 jQuery('.total_amount_to_pay span.currency, .total_interest_payment span.currency, .monthly_payment span.currency').html(_currency);

 jQuery('.monthly_payment span.val').html(_permonthpaywithrate);
 jQuery('.total_amount_to_pay span.val').html(_total_pay);
 jQuery('.total_interest_payment span.val').html(_total_interest_pay);

 jQuery('.total_amount_to_pay span.val, .total_interest_payment span.val, .monthly_payment span.val').number( true, pix_decimal_number, pix_decimal, pix_thousand);

}

function autoCalcHideMsg(){
    jQuery('.calculator-alert').hide();
}

function autoCalcShowMsg(){
    jQuery('.calculator-alert').show();
}

function autoCalcHideTotal(){
    jQuery('.autozone_calculator_results').hide();
}

function autoCalcShowTotal(){
    jQuery('.autozone_calculator_results').slideDown('slow');
}