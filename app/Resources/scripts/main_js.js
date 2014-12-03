jQuery(document).ready(function () {




    var map;

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
    ]

    var options = {
        zoom: 14,
        center:  new google.maps.LatLng(54.6833, 25.2833),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        disableDefaultUI: true
    };

    map = new google.maps.Map($('#map-canvas_main')[0], options);
    map.setOptions({
        styles: style
    });

    var image = 'web/bundles/webtaximain/images/person.png';
    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(54.675461, 25.251474),
        draggable: false,
        icon: 'http://www.clker.com/cliparts/g/l/R/7/h/u/teamstijl-person-icon-blue-th.png',
        map: map

    });

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(54.685183, 25.287270),
        draggable: false,
        icon: 'http://www.tmfactory-racing.com/images/checkered-flag-icon2.png',
        map: map

    });

    var center;
    function calculateCenter() {
        center = map.getCenter();
    }
    google.maps.event.addDomListener(map, 'idle', function() {
        calculateCenter();
    });
    google.maps.event.addDomListener(window, 'resize', function() {
        map.setCenter(center);
    });

});