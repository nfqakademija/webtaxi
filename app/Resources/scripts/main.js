jQuery(document).ready(function () {
    var paramsObject = document.getElementById('parameters');
    var map;
    var markers = [];
    var infoBoxes = [];
    var boxTextArray = [];
    var idArray = [null, null, null, null];
    var check;

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

    /**
     * Array of marker coordinates
     * @type {*[]}
     */
    var locations = [
        [54.724392, 25.323830],
        [54.729844, 25.269756],
        [54.707337, 25.224781],
        [54.713188, 25.245380],
        [54.675886, 25.286579],
        [54.683428, 25.245895],
        [54.684123, 25.294991],
        [54.724590, 25.280571]
    ];

    /**
     * Array of strings for infoBoxes
     * @type {string[]}
     */
    var strings = [
        'Labas, pavežėkit iki Užupio :) ',
        'Sveiki, kas į Saulėtekį?',
        'Hey, gal kam Akropolis pakeliui? :) ',
        'Laba diena, gal kas iki Rotušės pametės?',
        'Aloha, varom kartu į pajūrį!',
        'Labukas, pametėsit į Senamiestį? ',
        'Sveiki, yra norinčių į Kauną? :) ',
        'Hai, vykstu į Lazdynus, kas su manim? '
    ];

    /**
     * Array of possible icons for markers
     * @type {string[]}
     */
    var icons = [
        paramsObject.getAttribute('data-userIcon1'),
        paramsObject.getAttribute('data-userIcon2'),
        paramsObject.getAttribute('data-userIcon3'),
        paramsObject.getAttribute('data-userIcon4')
    ];

    /**
     * Fills array with markers ( with randomly selected icons)
     */
   function addMarkers() {
        var i;
        for ( i=0; i<locations.length; i++) {
            var location =locations[i];
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(location[0], location[1]),
                draggable: false,
                animation: google.maps.Animation.DROP,
                icon: icons[Math.floor(Math.random() * icons.length)]
            });
            markers.push(marker);
        }
   }


    /**
     *
     */
    function createInfoBoxes(){
        var i;
        for ( i=0; i<strings.length; i++) {

            boxTextArray[i] = document.createElement("div");
            boxTextArray[i].className = "infobox";
            boxTextArray[i].innerHTML = strings[i];

            var infobox = new InfoBox({
                content: boxTextArray[i],
                disableAutoPan: true,
                maxWidth: 150,
                pixelOffset: new google.maps.Size(-140, 0),
                boxStyle: {
                    background: "url('http://google-maps-utility-library-v3.googlecode.com/svn/trunk/infobox/examples/tipbox.gif') no-repeat",
                    opacity: 0.75,
                    width: "auto"
                },
                closeBoxMargin: "12px 4px 2px 2px",
                closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
                infoBoxClearance: new google.maps.Size(1, 1)
            });
            infoBoxes.push(infobox);
        }
    }

    var options = {
        zoom: 12,
        center:  new google.maps.LatLng(54.685709, 25.102901),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        disableDefaultUI: true
    };

    map = new google.maps.Map($('#map-canvas_main')[0], options);
    map.setOptions({
        styles: style
    });



    function openInfoBox(infobox, marker){
        infobox.open(map,  marker);
    }


    function isInArray(array, search)
    {
        var i;
        var result = false;
        for (i=0; i<array.length-1; i++){
            if (search === array[i]) result = true;
        }
        return result;
    }


    function setMarker(marker, infobox, id) {
        idArray[0] = idArray[1];
        idArray[1] = idArray[2];
        idArray[2] = idArray[3];
        idArray[3] = id;

        if (idArray[0] != null) {
            check = isInArray(idArray, id);
            if(!check) {
                markers[idArray[0]].setMap(null);
                infoBoxes[idArray[0]].close();
            }
        }

        if(!check){
            marker.setAnimation(google.maps.Animation.DROP);
            marker.setMap(map);
            setTimeout(function () {
                openInfoBox(infobox, marker)
            }, 1000);
        }
    }

  function randomMarkerAppearance(){
      var first, oldFirst;
      setInterval(function () {
          first = Math.floor(Math.random() * markers.length);
          setMarker(markers[first], infoBoxes[first], oldFirst);
          oldFirst=first;
      }, 8000);
  }

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

    createInfoBoxes();
    addMarkers();
    randomMarkerAppearance();
}) (window.jQuery);