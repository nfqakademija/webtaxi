(function($) {
    'use strict';

    var geocoder = new google.maps.Geocoder(),
        directionsService = new google.maps.DirectionsService(),
        directionsDisplay = new google.maps.DirectionsRenderer(),
        infowindow = new google.maps.InfoWindow(),
        destinationMarkerCreated = false,
        destinationMarker,
        map,
        start,
        dest;

    /**
     * @param location
     */
    function initialise(location) {
        var currentLocation  = new google.maps.LatLng(location.coords.latitude, location.coords.longitude);

        var style = [
            {
                stylers: [
                    { saturation: "-100" },
                    { lightness: "20" }
                ]
            },{
                featureType: "poi",
                stylers: [
                    { visibility: "off" }
                ]
            },{
                featureType: "transit",
                stylers: [
                    { visibility: "off" }
                ]
            },{
                featureType: "road",
                stylers: [
                    { lightness: "50" },
                    { visibility: "on" }
                ]
            },{
                featureType: "landscape",
                stylers: [
                    { lightness: "50" }
                ]
            }
        ];
        map = new google.maps.Map(document.getElementById("map-canvas"), {
            center: currentLocation,
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles: style
        });

        directionsDisplay.setMap(map);
        var startMarker= createMarker(currentLocation, 'start');

        google.maps.event.addListener(map, 'click', function (event) {
            if (!destinationMarkerCreated) {
                destinationMarker = createMarker(event.latLng, 'destination');
                destinationMarkerCreated = true;
            }
        });

        document.getElementById('address').addEventListener('change', function() {
            codeAddress(document.getElementById('address').value, startMarker);
        }, false);

        document.getElementById('dest_address').addEventListener('change', function() {
            codeAddress(document.getElementById('dest_address').value, destinationMarker);
        }, false);

        document.getElementById('Kviesti').addEventListener('click', function() {
            testMovement(startMarker.getPosition().lat(), startMarker.getPosition().lng());
        });
    }



    /**
     * @param pos
     * @param marker
     */
    function geocodePosition(pos, marker) {
        var callback = function (responses) {
            if (!responses || !responses.length) {
                return;
            }
            //var address = responses[0].formatted_address;

            var address = "";
            var city = "";
            var state = "";
            var number = "";

                    $.each(responses[0].address_components, function(){
                        switch(this.types[0]){
                            case "route":
                                address = this.short_name;
                                break;
                            case "administrative_area_level_1":
                                state = this.long_name;
                                break;
                            case "locality":
                                city = this.short_name;
                                break;
                            case "street_number":
                                number = this.short_name;
                                break;
                        }
                    });
                address=address+" "+number+" "+city;



            infowindow.setContent(address);
            infowindow.open(map, marker);

            if (marker.title == 'start') {
                document.getElementById('address').value = address;
                start = marker.getPosition();
                document.getElementById('travel_sourceLatitude').value =marker.getPosition().lat();
                document.getElementById('travel_sourceLongitude').value =marker.getPosition().lng();
            } else {
                document.getElementById('dest_address').value = address;
                dest = marker.getPosition();
                document.getElementById('travel_destinationLatitude').value =marker.getPosition().lat();
                document.getElementById('travel_destinationLongitude').value =marker.getPosition().lng();
            }

            calcRoute(start, dest);
        };

        geocoder.geocode({
            latLng: pos
        }, callback);
    }


    function codeAddress(addressToCode, marker) {
        var address = addressToCode;




        var callback = function (responses) {
            if (!responses || !responses.length) {
                return;
            }
                map.setCenter(responses[0].geometry.location);
            if (typeof marker === "undefined"){
                marker = createMarker(responses[0].geometry.location, 'destination');
                destinationMarkerCreated = true;
            }else{marker.setPosition(responses[0].geometry.location);}
                geocodePosition(responses[0].geometry.location, marker);
        };

        geocoder.geocode({
            address: address
        }, callback);
    }

    /**
     *
     * @param pos
     * @param t
     * @returns {google.maps.Marker}
     */
    function createMarker(pos, t) {

            var marker = new google.maps.Marker({
            position: pos,
            draggable: true,
            map: map,
            title: t
        });

        geocodePosition(pos, marker);

        google.maps.event.addListener(marker, 'dragend', function () {
            geocodePosition(marker.getPosition(),marker);
        });

        return marker;
    }

    /**
     * @param start
     * @param dest
     */
    function calcRoute(start, dest) {

        var request = {
            origin: start,
            destination: dest,
            travelMode: google.maps.TravelMode.DRIVING
        };

        directionsService.route(request, function (response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
                document.getElementById("distance").value = response.routes[0].legs[0].distance.value / 1000;
            }
        });
    }

    navigator.geolocation.getCurrentPosition(initialise);
})(window.jQuery);