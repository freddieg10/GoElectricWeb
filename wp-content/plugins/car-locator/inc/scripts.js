jQuery(document).ready(function($) {
    "use strict";

    $('.pixad--city').geocomplete({
        location: false
    }).bind('geocode:result',function (e, result) {
        jQuery('#pixad-car-locator-lat').val(result.geometry.viewport.Ya.j);
        jQuery('#pixad-car-locator-long').val(result.geometry.viewport.Ua.j);
        jQuery('#car-locator-radius').val(0);
    });

});