var mapDealerLocator = {};
mapDealerLocator.pics = null;
mapDealerLocator.map = null;
mapDealerLocator.markerClusterer = null;
mapDealerLocator.markers = [];
mapDealerLocator.infoWindow = null;
mapDealerLocator.geocoder = null;

mapDealerLocator.init = function(data) {
  this.settings = data;
  var latlng = new google.maps.LatLng(this.settings.map_lat, this.settings.map_lng);
  var zoomwfsfsaf = parseFloat( this.settings.map_zoom );
  var options = {
    'zoom':  zoomwfsfsaf,
    'center': latlng,
    'mapTypeId': google.maps.MapTypeId.ROADMAP,
    'mapTypeControl': false,
  };
  mapDealerLocator.map = new google.maps.Map(document.getElementById(data.map_id), options);
  mapDealerLocator.pics = data.photos;
  mapDealerLocator.map.setOptions({styles: this.settings.map_styles});
  mapDealerLocator.infoWindow = new google.maps.InfoWindow();
  mapDealerLocator.showMarkers();
};

mapDealerLocator.showMarkers = function() {
  mapDealerLocator.markers = [];
  
  if (mapDealerLocator.markerClusterer) {
    mapDealerLocator.markerClusterer.clearMarkers();
  }

  var numMarkers = mapDealerLocator.pics.length;
  for (var i = 0; i < numMarkers; i++) {
    var titleText = mapDealerLocator.pics[i].post_title;
    if (titleText == '') {
      titleText = 'No title';
    }
    var panel_id = this.settings['panel_id'];
    var item =  jQuery('#'+panel_id+' [data-dealer-id="'+mapDealerLocator.pics[i].ID+'"]')[0];
    mapDealerLocator.pics[i].panelItem = item;

    var latLng = new google.maps.LatLng(mapDealerLocator.pics[i].latitude, mapDealerLocator.pics[i].longitude);
    var imageUrl = this.settings['icon_url'];
    var markerImage;
    if(imageUrl){
      markerImage = new google.maps.MarkerImage( imageUrl, new google.maps.Size(this.settings['icon_width'], this.settings['icon_height']))
    }else{
       markerImage = new google.maps.MarkerImage('https://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi2.png',
                              new google.maps.Size(27, 43)  );
    }
    var marker = new google.maps.Marker({
      'position': latLng,
      'icon': markerImage
    });
    var fn = mapDealerLocator.markerClickFunction(mapDealerLocator.pics[i], latLng, marker);

    google.maps.event.addListener(marker, 'click', fn);
    google.maps.event.addDomListener(item, 'click', fn);
    mapDealerLocator.markers.push(marker);
  }

  window.setTimeout(mapDealerLocator.time, 0);
};

mapDealerLocator.distanceInKmBetweenEarthCoordinates = function (lat1, lon1, lat2, lon2) {
  var earthRadiusKm = 6371;

  var dLat = this.degreesToRadians(lat2-lat1);
  var dLon = this.degreesToRadians(lon2-lon1);

  lat1 = this.degreesToRadians(lat1);
  lat2 = this.degreesToRadians(lat2);

  var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
          Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
  return earthRadiusKm * c;
}
mapDealerLocator.degreesToRadians = function (degrees) {
  return degrees * Math.PI / 180;
}

mapDealerLocator.markerClickFunction = function(pic, latlng, marker) {
  return function(e) {
    e.cancelBubble = true;
    if (e.stopPropagation) {
      e.stopPropagation();
    }
    var title = pic.post_title;
    var url = pic.post_url;
    var fileurl = pic.thumbnail_url;
    var ID = pic.ID;
    var price = pic.price;
    // if(undefined !== e.latLng){
      jQuery('.section-dealers__main').animate({
          scrollTop: pic.panelItem.offsetTop - 40
      }, 700);
    // }
    // //  hover
    jQuery('#'+mapDealerLocator.settings['panel_id'] + ' [data-dealer-id]').removeClass('dealer-hover');
    jQuery(pic.panelItem).addClass('dealer-hover');

    var htmlBlockSeller = '';
    var seller_location = pic.seller_location;
    var seller_phone = pic.seller_phone;
    var seller_email = pic.seller_email;
    if(seller_location){
      htmlBlockSeller += '<li><strong>Location: </strong>'+seller_location+'</li>';
    } 
    if(seller_location){
      htmlBlockSeller += '<li><strong>Phone: </strong>'+seller_phone+'</li>';
    } 
    if(seller_email){
      htmlBlockSeller += '<li><strong>Email: </strong>'+seller_email+'</li>';
    }


    var infoHtml = '<div class="slider-grid__inner slider-grid__inner_mod-a">'+
          '<a href="'+url+'">'+
          '<img width="300" height="188" src="'+fileurl+'" class="img-responsive wp-post-image" alt="">'+
          '</a>'+
          '<div class="slider-grid__wrap-name">'+
              '<span class="slider-grid__name">'+title+'</span>'+
        
              '<span class="slider-grid__price">'+price+'<span class="after-price-text"></span></span>'+
          '</div>'+
      '</div>';
    mapDealerLocator.infoWindow.setContent(infoHtml);
    mapDealerLocator.infoWindow.setPosition(latlng);
    mapDealerLocator.infoWindow.open(mapDealerLocator.map, marker);
  };
};

mapDealerLocator.clear = function() {
  for (var i = 0, marker; marker = mapDealerLocator.markers[i]; i++) {
    marker.setMap(null);
  }
};

mapDealerLocator.change = function() {
  mapDealerLocator.clear();
  mapDealerLocator.showMarkers();
};

mapDealerLocator.time = function() {

    var imageUrl = mapDealerLocator.settings['claster_url'];
    var mcOptions;
    if(imageUrl){
        var clusterStyles = [{
          url: mapDealerLocator.settings['claster_url'],
          textSize: mapDealerLocator.settings['claster_text_size'],
          height: mapDealerLocator.settings['claster_height'],
          width: mapDealerLocator.settings['claster_width']
        }, {
          url: mapDealerLocator.settings['claster_url'],
          textSize: mapDealerLocator.settings['claster_text_size'],
          height: mapDealerLocator.settings['claster_height'],
          width: mapDealerLocator.settings['claster_width']
        }, {
          url: mapDealerLocator.settings['claster_url'],
          textSize: mapDealerLocator.settings['claster_text_size'],
          height: mapDealerLocator.settings['claster_height'],
          width: mapDealerLocator.settings['claster_width']
        }, {
          url: mapDealerLocator.settings['claster_url'],
          textSize: mapDealerLocator.settings['claster_text_size'],
          height: mapDealerLocator.settings['claster_height'],
          width: mapDealerLocator.settings['claster_width']
        }, {
          url: mapDealerLocator.settings['claster_url'],
          textSize: mapDealerLocator.settings['claster_text_size'],
          height: mapDealerLocator.settings['claster_height'],
          width: mapDealerLocator.settings['claster_width']
        }];
      mcOptions = {
        gridSize: 52,
        styles: clusterStyles
      };
      mapDealerLocator.markerClusterer = new MarkerClusterer(mapDealerLocator.map, mapDealerLocator.markers, mcOptions);
    }else{
      mapDealerLocator.markerClusterer = new MarkerClusterer(mapDealerLocator.map, mapDealerLocator.markers, {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
    }

};
mapDealerLocator.codeAddress =   function (address) {
    mapDealerLocator.geocoder = new google.maps.Geocoder();
    mapDealerLocator.geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == 'OK') {
        var foundPosition = results[0].geometry.location;
        mapDealerLocator.pics.forEach(function(element) {
          element.radius = mapDealerLocator.
          distanceInKmBetweenEarthCoordinates(element.latitude, element.longitude, foundPosition.lat(),foundPosition.lng());
        });
        mapDealerLocator.pics.sort(function(a, b) {
          return a.radius - b.radius;
        });
        mapDealerLocator.pics[0].panelItem.click();
      } else {
       console.log('Geocode was not successful for the following reason: ' + status);
      }
    });
  }
google.maps.event.addDomListener(window, 'load', function() {
      dlcMapSettings.forEach(function(element) {
      mapDealerLocator.init(element);
    });
});
(function($) {
  $('#dlc-map-search')[0].addEventListener('keydown', function(e) {
    if (e.keyCode === 13) {
     mapDealerLocator.codeAddress(this.value);
    }
  });
})(jQuery);