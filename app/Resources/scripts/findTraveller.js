(function($) {
    'use strict';

    var lastId = -1;
    var count = 5;

    $('#loadMore').click(function()
    {
        $('#loadingMore').show();
        $.ajax({
            url: 'loadMoreTravels',
            type: 'GET',
            data: { count : count, fromId : lastId },
            contentType: 'application/json; charset=utf-8',
            onload: function () {
              showLoading
            },
            success: function (response) {
                console.log(response);
                var json = response;
                var obj = JSON && JSON.parse(json) || $.parseJSON(json);
                var travels = obj.travels;
                var tableBody = document.getElementById('travelsTBody');
                if (travels != null) {
                    for (var i = 0; i < travels.length; i++) {

                        var t = travels[i];
                        var tr = document.createElement("tr");
                        //time call:
                        var td = document.createElement("td");
                        var text = document.createTextNode(t.timeCall);
                        td.appendChild(text);
                        tr.appendChild(td);
                        //source:
                        td = document.createElement("td");
                        text = document.createTextNode(t.sourceAddress);
                        td.appendChild(text);
                        tr.appendChild(td);
                        //destination:
                        td = document.createElement("td");
                        text = document.createTextNode(t.destinationAddress);
                        td.appendChild(text);
                        tr.appendChild(td);
                        //client:
                        td = document.createElement("td");
                        text = document.createTextNode(t.client.username + " (" + t.client.firstName + " " + t.client.lastName + ")");
                        td.appendChild(text);
                        tr.appendChild(td);
                        //price:
                        td = document.createElement("td");
                        text = document.createTextNode(t.price);
                        td.appendChild(text);
                        tr.appendChild(td);
                        //passenger count:
                        td = document.createElement("td");
                        text = document.createTextNode(t.passengerCount);
                        td.appendChild(text);
                        tr.appendChild(td);
                        //distance:
                        td = document.createElement("td");
                        text = document.createTextNode(t.distance);
                        td.appendChild(text);
                        tr.appendChild(td);
                        //profit:
                        td = document.createElement("td");
                        text = document.createTextNode(t.profit);
                        td.appendChild(text);
                        tr.appendChild(td);
                        //action:
                        td = document.createElement("td");
                        var img = document.createElement("img");
                        if (t.isMyTravel) {
                            tr.className += " myTravel ";
                            img.src = "http://webtaxi.dev/bundles/webtaximain/images/remove.png";
                            $( img ).click(createRemoveFunction(t.id));
                            td.appendChild(img);
                            tr.appendChild(td);
                        } else {

                        }

                        tableBody.insertBefore(tr, tableBody.childNodes[tableBody.childNodes.length-2]);
                        lastId = travels[i].id;
                    }
                }

                if (travels == null || travels.length == 0 || travels.length < count) {
                    $('#loadMore').hide();
                    $('#noMoreToLoad').show();
                }
            },
            complete: function(){
                $('#loadingMore').hide();
            },

            error: function () {
                $('#loadingMore').hide();
                alert('Nenumatyta klaida. Praneškite apie klaidą');
            }
        });

    });

    $(document).ready(function() {
        $("#loadMore").click();

    });


    function createRemoveFunction(travelId) {
        return function() {
            $.ajax({
                url: 'removeMyTravel/' + travelId,
                type: 'DELETE',

                contentType: 'application/json; charset=utf-8',
                onload: function () {
                    showLoading
                },
                success: function (response) {
                    console.log(response);
                    var json = response;
                    var obj = JSON && JSON.parse(json) || $.parseJSON(json);
                    var status = obj.status;
                    // we dont care about status, just reloadin page;
                },
                complete: function(){
                    window.location.reload(true);
                },

                error: function () {
                    alert('Nenumatyta klaida. Praneškite apie klaidą');
                }
            });
        }
    }


})(window.jQuery);

