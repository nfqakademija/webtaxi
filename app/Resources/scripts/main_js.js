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
        animation: google.maps.Animation.DROP,
        title: 'Tomas',
        icon: 'http://webtaxi.dev/bundles/webtaximain/images/user_1_marker.png',
        map: map
    });

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(54.685183, 25.287270),
        draggable: false,
        animation: google.maps.Animation.DROP,
        title: 'Jonas',
        icon: 'http://webtaxi.dev/bundles/webtaximain/images/user_2_marker.png',
        map: map
    });

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(54.674918, 25.304431),
        draggable: false,
        animation: google.maps.Animation.DROP,
        title: 'Petras',
        icon: 'http://webtaxi.dev/bundles/webtaximain/images/user_3_marker.png',
        map: map
    });

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(54.673727, 25.270613),
        draggable: false,
        animation: google.maps.Animation.DROP,
        title: 'Mantas',
        icon: 'http://webtaxi.dev/bundles/webtaximain/images/user_4_marker.png',
        map: map
    });

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(54.700766, 25.233706),
        draggable: false,
        animation: google.maps.Animation.DROP,
        title: 'Giedrius',
        icon: 'http://webtaxi.dev/bundles/webtaximain/images/user_1_marker.png',
        map: map
    });

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(54.664643, 25.246066),
        draggable: false,
        animation: google.maps.Animation.DROP,
        title: 'Vilius',
        icon: 'http://webtaxi.dev/bundles/webtaximain/images/user_2_marker.png',
        map: map
    });

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(54.709098, 25.295504),
        draggable: false,
        animation: google.maps.Animation.DROP,
        title: 'Marius',
        icon: 'http://webtaxi.dev/bundles/webtaximain/images/user_3_marker.png',
        map: map
    });

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(54.672188, 25.332583),
        draggable: false,
        animation: google.maps.Animation.DROP,
        title: 'Juozas',
        icon: 'http://webtaxi.dev/bundles/webtaximain/images/user_4_marker.png',
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
        map.infowindow.open(map,marker);
    });

});