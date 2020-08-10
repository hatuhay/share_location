/**
 * @file
 * Global utilities.
 *
 */
(function($, Drupal) {

  'use strict';

  var initialized;
  var uid = drupalSettings.user.uid;

  function init() {
    if (!initialized) {
      initialized = true;
      setTimeout(function update() {
        setUserLocation(uid);
        setTimeout(update, 120000);
      }, 120000);
    }
  }

  function setUserLocation(uid) {
    if ("geolocation" in navigator) {
      /* Geolocalización está disponible */
      navigator.geolocation.getCurrentPosition(function(position) {
        $.get( "/api/user/location/" + uid + "/set", { lat: position.coords.latitude, lng: position.coords.longitude } );
      });
    }
    else {
      /* Geolocalización NO está disponible */
      console.log("Geolocalización no diponible");
    }
  }

  Drupal.behaviors.share_location_location = {
    attach: function(context, settings) {

      init();

    }
  };

})(jQuery, Drupal);