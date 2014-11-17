(function($) {
    'use strict';

    var currentLocation;
    var infowindow = new google.maps.InfoWindow();
    var geocoder;
    var marker;
    var map;
    var marker_set=false;
    var address;


    function initialise(location) {
        currentLocation = new google.maps.LatLng(location.coords.latitude, location.coords.longitude);
        geocoder = new google.maps.Geocoder();
        console.log(location);
        var mapOptions =
        {
            center: currentLocation,
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
        createMarker(currentLocation, 'start');

        google.maps.event.addListener(map, 'click', function (event) {
            if (marker_set == false) {
                createMarker(event.latLng, 'destination');
                marker_set = true;
            }
        });
    }


    function geocodePosition(pos) {
        geocoder.geocode({
            latLng: pos
        }, function(responses) {
            if (responses && responses.length > 0) {
                address = responses[0].formatted_address;
            } else {
                address('Cannot determine address at this location.');
            }
        });
    }


    function createMarker(pos, t){
        var marker = new google.maps.Marker({
            position: pos,
            draggable: true,
            map: map,
            title: t
        });
            google.maps.event.addListener(marker, 'dragend', function() {
            // updateMarkerStatus('Drag ended');
                geocodePosition(marker.getPosition());
                infowindow.setContent(address);
                infowindow.open(map, marker);
                document.getElementById('address').value=address;
        });

        return marker;
    }


    navigator.geolocation.getCurrentPosition(initialise);
})(window.jQuery);


