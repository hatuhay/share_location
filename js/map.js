/**
 * @file
 * Global utilities.
 *
 */
(function($, Drupal) {

  'use strict';

  var initialized;
  var marker;
  var map;
  var urlTemp = `https://caninar.esboceto.net/dog.png`;
  var uid = drupalSettings.dataPaseo.paseador;
  var icon = {
    url: urlTemp,
    scale: 0.4,
    fillColor: "#427af4",
    fillOpacity: 1,
    strokeWeight: 1,
    anchor: new google.maps.Point(0, 5),
  };

  function init() {
    if (!initialized) {
      initialized = true;
      setMap(uid);
      setTimeout(function update() {
        updateMap(uid);
        setTimeout(update, 60000);
      }, 60000);
    }
  }

  function setMap(uid) {
    $.get( "/api/user/location/" + uid, function( data ) {
      var pos = {
        lat: parseFloat(data.data.lat),
        lng: parseFloat(data.data.lng)
      };
      renderMap(pos);
    }, "json" );
  }

  function updateMap(uid) {
    $.get( "/api/user/location/" + uid, function( data ) {
      var pos = {
        lat: parseFloat(data.data.lat),
        lng: parseFloat(data.data.lng)
      };
      map.setCenter(pos);
      marker.setMap(null);
      marker = new google.maps.Marker({
        position: pos,
        icon: icon,
        map: map
      });
    }, "json" );
  }

  // This Function will create an icon with angle and add/display that marker on the map
  function renderMap(pos) {
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: 16,
      center: new google.maps.LatLng(pos),
    });

    marker = new google.maps.Marker({
      position: pos,
      icon: icon,
      map: map
    });
  }

  Drupal.behaviors.share_location_map = {
    attach: function(context, settings) {

      init();

    }
  };

})(jQuery, Drupal);