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
    ];



    var locat = [
        [54.709098, 25.295504],
        [54.675461, 25.251474],
        [54.674918, 25.304431],
        [54.685183, 25.287270],
        [54.673727, 25.270613],
        [54.700766, 25.233706],
        [54.700766, 25.233706],
        [54.672188, 25.332583]
    ];

    var strings = [
        'Labas',
        'Sveiki',
        'Hey',
        'Laba diena',
        'Aloha',
        'Labukas',
        'Sveiki',
        'Hai'
    ];

    var markers = [];

   function addMarkers() {
        var i;
        for ( i=0; i<locat.length; i++) {
            var locatio =locat[i];
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(locatio[0], locatio[1]),
                draggable: false,
                animation: google.maps.Animation.DROP,
                title: 'Tomas',
                icon: 'http://webtaxi.dev/bundles/webtaximain/images/user_1_marker.png'
            });
            markers.push(marker);
        }
    }

    var infoBoxes = [];
    var boxTextArray = [];
    function createInfoBoxes(){
        var i;
        for ( i=0; i<strings.length; i++) {

            boxTextArray[i] = document.createElement("div");
            boxTextArray[i].style.cssText ="border:2px solid black; background:#333; color:#FFF; box-shadow: 0 0 8px #000; text-shadow:0 -1px #000000;-webkit-border-radius: 2px;" +
            "-moz-border-radius: 2px; border-radius: 2px; -webkit-box-shadow: 0 0  8px #000;";
            boxTextArray[i].innerHTML = strings[i];


            var infobox = new InfoBox({
                content: boxTextArray[i],
                disableAutoPan: false,
                maxWidth: 150,
                pixelOffset: new google.maps.Size(-140, 0),
                zIndex: null,
                boxStyle: {
                    background: "url('http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/examples/tipbox.gif') no-repeat",
                    opacity: 0.75,
                    width: "280px"
                },
                closeBoxMargin: "12px 4px 2px 2px",
                closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
                infoBoxClearance: new google.maps.Size(1, 1)
            });
            infoBoxes.push(infobox);
        }
    }



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



  function randomMarkerAppearance(){
    var first, second, third, oldFirst, oldSecond, oldThird;
          setInterval(function () {
              first = Math.floor(Math.random() * markers.length);
              second = Math.floor(Math.random() * markers.length);
              third = Math.floor(Math.random() * markers.length);

              if (oldFirst != null) {
                  markers[oldFirst].setMap(null);
                  markers[oldSecond].setMap(null);
                  markers[oldThird].setMap(null);
                  infoBoxes[oldFirst].close();
                  infoBoxes[oldSecond].close();
                  infoBoxes[oldThird].close();
              }

              markers[first].setAnimation(google.maps.Animation.DROP);
              markers[second].setAnimation(google.maps.Animation.DROP);
              markers[third].setAnimation(google.maps.Animation.DROP);




              markers[second].setMap(map);
              infoBoxes[second].open(map,  markers[second]);
              markers[third].setMap(map);
              infoBoxes[third].open(map,  markers[third]);
              markers[first].setMap(map);
              infoBoxes[first].open(map,  markers[first]);

              oldFirst = first;
              oldSecond = second;
              oldThird= third;
          }, 5000);
    }




  /*  var image = 'web/bundles/webtaximain/images/person.png';
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
*/





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

    createInfoBoxes();
    addMarkers();
    randomMarkerAppearance();
}) (window.jQuery);