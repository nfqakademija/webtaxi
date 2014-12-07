(function($) {
    'use strict';
    /*START OF GETTING PARAMS*/
    var paramsObject = document.getElementById('parameters');
    var loadMoreTravelsLink = paramsObject.getAttribute('data-loadMoreTravelsLink');
    var isMyTravelsSection = paramsObject.getAttribute('data-isMyTravels');
    var imageLinkAlert = paramsObject.getAttribute('data-imageLinkAlert');
    var imageLinkRemove = paramsObject.getAttribute('data-imageLinkRemove');
    var imageLinkTick = paramsObject.getAttribute('data-imageLinkTick');
    var imageLinkInfo = paramsObject.getAttribute('data-imageLinkInfo');
    var imageLinkTraveler = paramsObject.getAttribute('data-imageLinkTraveler');
    var imageLinkSteeringWheel = paramsObject.getAttribute('data-imageLinkSteeringWheel');
    /*END OF GETTING PARAMS*/
    var lastId = -1;
    var count = 5;

    var modalTitle = 'Klaida';
    var modalText = '';
    var modalImage = imageLinkAlert;
    var currentTravelId = -1;

    var stringYouWereClient = 'Jūs keliautojas';
    var stringYouWereDriver = 'Jūs vairuotojas';
    var stringRemoveThisTravel = 'Panaikinti šią kelionę';
    var stringAcceptThisTravel = 'Priimti šią kelionę';
    var stringTravelWasNotAcceptedAndIsExpired = 'Ši kelionė nebuvo priimta ir nebegalioja';
    /**
     * OnClick - ajax function - load some more travels
     */
    $('#loadMore').click(function()
    {
        $('#loadingMore').show();
        $.ajax({
            url: loadMoreTravelsLink,
            type: 'GET',
            data: { count : count, fromId : lastId },
            contentType: 'application/json; charset=utf-8',
            success: function (response) {
                console.log(response);
                var json = response;
                var obj = JSON && JSON.parse(json) || $.parseJSON(json);
                var travels = obj.travels;
                var tableBody = document.getElementById('travelsTBody');
                if (travels !== null) {
                    for (var i = 0; i < travels.length; i++) {
                        var t = travels[i];
                        var isTravelExpired = travels[i].isTravelExpired;
                        var tr = document.createElement('tr');
                        var td;
                        var img;
                        if (isMyTravelsSection) {
                            //show image is driver or is traveler:
                            td = document.createElement('td');
                            img = document.createElement('img');
                            if (t.isMyTravel) {
                                img.src = imageLinkTraveler;
                                img.title = stringYouWereClient;
                                img.alt = stringYouWereClient;
                            } else {
                                img.src = imageLinkSteeringWheel;
                                img.title = stringYouWereDriver;
                                img.alt = stringYouWereDriver;
                            }
                            td.appendChild(img);
                            tr.appendChild(td);
                        }



                        //time call:
                        td = document.createElement('td');
                        var text = document.createTextNode(t.timeCall);
                        td.appendChild(text);
                        tr.appendChild(td);
                        //source:
                        td = document.createElement('td');
                        text = document.createTextNode(t.sourceAddress);
                        td.appendChild(text);
                        tr.appendChild(td);
                        //destination:
                        td = document.createElement('td');
                        text = document.createTextNode(t.destinationAddress);
                        td.appendChild(text);
                        tr.appendChild(td);

                        var fullName;
                        //client:
                        if (!isMyTravelsSection) {
                            td = document.createElement('td');
                            fullName = t.client.firstName + ' ' + t.client.lastName;
                            text = document.createTextNode(t.client.username + ' (' + fullName + ')');
                            td.appendChild(text);
                            tr.appendChild(td);
                        }

                        //price:
                        td = document.createElement('td');
                        text = document.createTextNode(t.price);
                        td.appendChild(text);
                        tr.appendChild(td);
                        //passenger count:
                        td = document.createElement('td');
                        text = document.createTextNode(t.passengerCount);
                        td.appendChild(text);
                        tr.appendChild(td);
                        //distance:
                        td = document.createElement('td');
                        text = document.createTextNode(t.distance);
                        td.appendChild(text);
                        tr.appendChild(td);
                        //profit:
                        td = document.createElement('td');
                        text = document.createTextNode(t.profit);
                        td.appendChild(text);
                        tr.appendChild(td);
                        //with:
                        //print person, who is a your assocaite - driver or a client
                        if (isMyTravelsSection) {
                            td = document.createElement('td');
                            var name = '';
                            if (t.isMyTravel) {
                                if (t.driver !== null) {
                                    name = '(' + t.driver.username + ') ' + t.driver.firstName + ' ' + t.driver.lastName;
                                } else {
                                    if (isTravelExpired) {
                                        name = ' - ';
                                    }
                                }
                            } else {
                                name = '(' + t.driver.username + ') ' + t.client.firstName + ' ' + t.client.lastName;
                            }
                            text = document.createTextNode(name);
                            if (isTravelExpired) {
                                text.title = stringTravelWasNotAcceptedAndIsExpired;
                            }
                            td.appendChild(text);
                            tr.appendChild(td);
                        }

                        //action:
                        td = document.createElement('td');
                        img = document.createElement('img');
                        if (t.driver === null) {
                            if (t.isMyTravel) {
                                if (!isTravelExpired) {
                                    img.src = imageLinkRemove;
                                    img.title = stringRemoveThisTravel;
                                    img.alt = stringRemoveThisTravel;
                                    $( img ).click(createTravelRemovalConfirmationFunction(t.id, t.sourceAddress, t.destinationAddress));
                                }
                            } else {
                                if (!isTravelExpired) {
                                    img.src = imageLinkTick;
                                    img.alt = stringAcceptThisTravel;
                                    $( img ).click(createTravelAcceptanceConfirmationFunction(t.id, fullName, t.sourceAddress, t.destinationAddress));
                                }
                            }
                        }
                        if (t.isMyTravel) {
                            tr.className += ' myTravel ';
                        }
                        if (isTravelExpired && t.driver === null) {
                            tr.className += ' travelExpired ';
                        }

                        td.appendChild(img);
                        tr.appendChild(td);

                        tableBody.insertBefore(tr, tableBody.childNodes[tableBody.childNodes.length-2]);
                        lastId = travels[i].id;
                    }
                }

                if (travels === null || travels.length === 0 || travels.length < count) {
                    $('#loadMore').hide();
                    $('#noMoreToLoad').show();
                }
            },
            complete: function(){
                $('#loadingMore').hide();
            },

            error: function () {
                $('#loadingMore').hide();
                //alert('Nenumatyta klaida. Praneškite apie klaidą');
            }
        });

    });

    $(document).ready(function() {
        $('#loadMore').click();

    });
    /**
     * shows dialog: does user really want to delete his travel?
     * @param travelId
     * @param sourceAddress
     * @param destinationAddress
     * @returns {Function}
     */
    function createTravelRemovalConfirmationFunction(travelId, sourceAddress, destinationAddress) {
        return function() {
            currentTravelId = travelId;
            modalTitle = 'Ar Jūs įsitikinęs?';
            modalText = 'Ar tikrai norite panaikinti kelionę iš ' + sourceAddress + ' į ' + destinationAddress + '?';
            $('#deleteModal').modal();
        };
    }

    /**
     * shows dialog: does user really want to accept this travel?
     * @param travelId
     * @param client
     * @param sourceAddress
     * @param destinationAddress
     * @returns {Function}
     */
    function createTravelAcceptanceConfirmationFunction(travelId, client, sourceAddress, destinationAddress) {
        return function() {
            currentTravelId = travelId;
            modalTitle = 'Ar Jūs įsitikinęs?';
            modalText = 'Ar tikrai norite pavežėti ' + client + ' iš ' + sourceAddress + ' į ' + destinationAddress + '?';
            $('#acceptModal').modal();
        };
    }

    /**
     * ajax function for removing the travel
     * @param travelId
     * @returns {Function}
     */
    function createRemoveFunction(travelId) {
        return function() {
            $('#deleteModal').modal('hide');
            $.ajax({
                url: 'removeMyTravel/' + travelId,
                type: 'DELETE',

                contentType: 'application/json; charset=utf-8',
                success: function (response) {
                    console.log(response);
                    var json = response;
                    var obj = JSON && JSON.parse(json) || $.parseJSON(json);

                    $.parseResponse(obj);
                },
                complete: function(){
                    //window.location.reload(true);
                },

                error: function () {
                    $.parseResponse();
                }
            });
        };
    }

    /**
     * ajax function for accepting a travel
     * @param travelId
     * @returns {Function}
     */
    function createTravelAcceptFunction(travelId) {
        return function() {
            $('#acceptModal').modal('hide');
            $.ajax({
                url: 'acceptTravel/' + travelId,
                type: 'PUT',

                contentType: 'application/json; charset=utf-8',
                success: function (response) {
                    console.log(response);
                    var json = response;
                    var obj = JSON && JSON.parse(json) || $.parseJSON(json);
                    $.parseResponse(obj);
                },
                complete: function(){
                    //window.location.reload(true);
                },
                error: function () {
                    $.parseResponse();

                }
            });
        };
    }

    /**
     * parsing response from ajax functions: accept travel or remove travel
     * and show the dialog about response to user
     * @param _obj response or void if an error occured;
     */
    $.parseResponse = function (_obj) {
        if((_obj)){
            var status = _obj.status;
            modalText = _obj.message;
            if (status === 1) {
                modalTitle = 'Operacija sėkminga';
                modalImage = imageLinkInfo;
            } else {
                modalTitle = 'Klaida';
                modalImage = imageLinkAlert;
            }
        } else {
            modalTitle = 'Klaida';
            modalText = 'Ši kelionė neegiztuoja';
            modalImage = imageLinkAlert;
        }
        $('#infoModal').modal();
    };

    /**
     * OnShow, set correct values to info dialog
     */
    $('#infoModal').on('show.bs.modal', function () {
        var modal = $(this);
        modal.find('.modal-title').text(modalTitle);
        modal.find('.modal-message').text(modalText);
        modal.find('.modal-image').attr('src', modalImage);
    });

    /**
     * reload the page when user closes info dialog
     */
    $('#infoModal').on('hide.bs.modal', function () {
        window.location.reload(true);
    });

    /**
     * on show, set correct values
     */
    $('#deleteModal').on('show.bs.modal', function () {
        var modal = $(this);
        modal.find('.modal-title').text(modalTitle);
        modal.find('.modal-message').text(modalText);
        modal.find('.btn-primary').click(createRemoveFunction(currentTravelId));
    });

    /**
     * on show, set correct values
     */
    $('#acceptModal').on('show.bs.modal', function () {
        var modal = $(this);
        modal.find('.modal-title').text(modalTitle);
        modal.find('.modal-message').text(modalText);
        modal.find('.btn-primary').click(createTravelAcceptFunction(currentTravelId));
    });

})(window.jQuery);

