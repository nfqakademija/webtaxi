// SPAGHETTI..... my eyes are bleeding
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
    var imageLinkComment = paramsObject.getAttribute('data-imageLinkComment');
    var imageLinkCommentActive = paramsObject.getAttribute('data-imageLinkCommentActive');

    var imageLinkimageLinkRatingStar = paramsObject.getAttribute('data-imageLinkRatingStar');
    var imageLinkimageLinkRatingStar1 = paramsObject.getAttribute('data-imageLinkRatingStar1');
    var imageLinkimageLinkRatingStar2 = paramsObject.getAttribute('data-imageLinkRatingStar2');
    var imageLinkimageLinkRatingStar3 = paramsObject.getAttribute('data-imageLinkRatingStar3');
    var imageLinkimageLinkRatingStar4 = paramsObject.getAttribute('data-imageLinkRatingStar4');
    var imageLinkimageLinkRatingStar5 = paramsObject.getAttribute('data-imageLinkRatingStar5');
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
    var stringRateThisTravel = 'Įvertinkite šią kelionę';
    var stringShowReviews = 'Peržiūrėti šios kelionės įvertinimus';

    var stringYours = 'Tavo';
    var stringReview = 'apžvalga';
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
                        var a;
                        //client:
                        if (!isMyTravelsSection) {
                            td = document.createElement('td');
                            fullName = t.client.firstName + ' ' + t.client.lastName;
                            if (fullName.length == 1) {
                                text = document.createTextNode(t.client.username);
                            } else {
                                text = document.createTextNode(t.client.username + ' (' + fullName + ')');
                            }

                            a = document.createElement('a');
                            a.href = 'user/' + t.client.id;
                            a.appendChild(text);
                            td.appendChild(a);
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
                                name = '(' + t.client.username + ') ' + t.client.firstName + ' ' + t.client.lastName;
                            }
                            text = document.createTextNode(name);
                            if (isTravelExpired) {
                                text.title = stringTravelWasNotAcceptedAndIsExpired;
                            }
                            a = document.createElement('a');
                            a.href = 'user/' + t.client.id;
                            a.appendChild(text);

                            td.appendChild(a);
                            tr.appendChild(td);
                        }

                        //action:
                        td = document.createElement('td');
                        img = document.createElement('img');
                        if (t.driver === null) {//if its not accepted, it could be removed or accepted
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
                        } else {
                            //travel has a driver, show review icon, if travel was not reviewed;
                            //ToDo cia galima graziau padaryti:
                            console.log('ratings ' + t.reviewClientRating + ' ' + t.reviewDriverRating);
                            var showAbilityToReview = false;
                            var showAbilityToSeeReview = false;
                            if (t.isMyTravel) { //I was a client
                                if (t.reviewClientRating <= 0 || t.reviewClientRating === null) {
                                    showAbilityToReview = true;
                                } else {
                                    showAbilityToSeeReview = true;
                                }
                            }
                            else
                            if ((t.isMyRelatedTravel && !t.isMyTravel)) { //I was a driver:
                                if (t.reviewDriverRating <= 0 || t.reviewDriverRating === null  ) {
                                    showAbilityToReview = true;
                                } else {
                                    showAbilityToSeeReview = true;
                                }
                            }
                            if (showAbilityToReview) {
                                img.src = imageLinkCommentActive;
                                img.title = stringRateThisTravel;
                                img.alt = stringRateThisTravel;
                                $( img ).click(createTravelReviewFunction(t.id));
                            } else
                            if (showAbilityToSeeReview) {
                                img.src = imageLinkComment;
                                img.title = stringShowReviews;
                                img.alt = stringShowReviews;
                                var review1 = null;
                                review1 = {rating:t.reviewClientRating, comment:t.reviewClientComment,
                                    name: '(' + t.client.username + ') ' + t.client.firstName + ' ' + t.client.lastName,
                                    isYour: t.isMyTravel};
                                var review2 = null;
                                review2 = {rating:t.reviewDriverRating, comment:t.reviewDriverComment,
                                    name: '(' + t.driver.username + ') ' + t.driver.firstName + ' ' + t.driver.lastName,
                                    isYour: !t.isMyTravel};
                                var reviews = [review1, review2];
                                $( img ).click(createShowTravelReviewsFunction(reviews));
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
                window.scrollTo(0,document.body.scrollHeight);
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
        modal.find('.btn-primary').off();
        modal.find('.btn-primary').click(createRemoveFunction(currentTravelId));
    });

    /**
     * on show, set correct values
     */
    $('#acceptModal').on('show.bs.modal', function () {
        var modal = $(this);
        modal.find('.modal-title').text(modalTitle);
        modal.find('.modal-message').text(modalText);
        modal.find('.btn-primary').off();
        modal.find('.btn-primary').click(createTravelAcceptFunction(currentTravelId));
    });

    function createTravelReviewFunction(travelId) {
        return function() {
            currentTravelId = travelId;
            $('#reviewModal').modal();
        };
    }

    /* START OF SEND REVIEW */
    // ToDo this solution for setting hover, click stars images is really really bad.

    /**
     * Stars image objects
     */
    var ratingStar1 = document.getElementById('ratingStar1');
    var ratingStar2 = document.getElementById('ratingStar2');
    var ratingStar3 = document.getElementById('ratingStar3');
    var ratingStar4 = document.getElementById('ratingStar4');
    var ratingStar5 = document.getElementById('ratingStar5');

    var reviewCountLeftSymbolsValueObject = document.getElementById('reviewCountLeftSymbolsValue');
    var reviewCommentObject = document.getElementById('reviewComment');

    var isRatingGiven = false;
    var isCommentGiven = false;

    var ratingCurrent = 0;

    /**
     * function for setting back rating stars if rating is not selected
     */
    var ratingStarsHoverOutFunction = function() {
        if (ratingCurrent !== 0) {
            return;
        }
        ratingStar1.src = imageLinkimageLinkRatingStar;
        ratingStar2.src = imageLinkimageLinkRatingStar;
        ratingStar3.src = imageLinkimageLinkRatingStar;
        ratingStar4.src = imageLinkimageLinkRatingStar;
        ratingStar5.src = imageLinkimageLinkRatingStar;
    };

    var clearAllStarsFunction = function() {
        ratingStar1.src = imageLinkimageLinkRatingStar;
        ratingStar2.src = imageLinkimageLinkRatingStar;
        ratingStar3.src = imageLinkimageLinkRatingStar;
        ratingStar4.src = imageLinkimageLinkRatingStar;
        ratingStar5.src = imageLinkimageLinkRatingStar;
    };

    var ratingStar1HoverInFunction = function()
    {
        if (ratingCurrent > 0) {
            return;
        }
        ratingStar1.src = imageLinkimageLinkRatingStar1;
        ratingStar2.src = imageLinkimageLinkRatingStar;
        ratingStar3.src = imageLinkimageLinkRatingStar;
        ratingStar4.src = imageLinkimageLinkRatingStar;
        ratingStar5.src = imageLinkimageLinkRatingStar;
    };

    var ratingStar2HoverInFunction = function()
    {
        if (ratingCurrent > 0) {
            return;
        }
        ratingStar1.src = imageLinkimageLinkRatingStar2;
        ratingStar2.src = imageLinkimageLinkRatingStar2;
        ratingStar3.src = imageLinkimageLinkRatingStar;
        ratingStar4.src = imageLinkimageLinkRatingStar;
        ratingStar5.src = imageLinkimageLinkRatingStar;
    };

    var ratingStar3HoverInFunction = function()
    {
        if (ratingCurrent > 0) {
            return;
        }
        ratingStar1.src = imageLinkimageLinkRatingStar3;
        ratingStar2.src = imageLinkimageLinkRatingStar3;
        ratingStar3.src = imageLinkimageLinkRatingStar3;
        ratingStar4.src = imageLinkimageLinkRatingStar;
        ratingStar5.src = imageLinkimageLinkRatingStar;
    };

    var ratingStar4HoverInFunction = function()
    {
        if (ratingCurrent > 0) {
            return;
        }
        ratingStar1.src = imageLinkimageLinkRatingStar4;
        ratingStar2.src = imageLinkimageLinkRatingStar4;
        ratingStar3.src = imageLinkimageLinkRatingStar4;
        ratingStar4.src = imageLinkimageLinkRatingStar4;
        ratingStar5.src = imageLinkimageLinkRatingStar;
    };

    var ratingStar5HoverInFunction = function()
    {
        if (ratingCurrent > 0) {
            return;
        }
        ratingStar1.src = imageLinkimageLinkRatingStar5;
        ratingStar2.src = imageLinkimageLinkRatingStar5;
        ratingStar3.src = imageLinkimageLinkRatingStar5;
        ratingStar4.src = imageLinkimageLinkRatingStar5;
        ratingStar5.src = imageLinkimageLinkRatingStar5;
    };

    $('#ratingStar1').hover(ratingStar1HoverInFunction, ratingStarsHoverOutFunction);

    $('#ratingStar2').hover(ratingStar2HoverInFunction, ratingStarsHoverOutFunction);

    $('#ratingStar3').hover(ratingStar3HoverInFunction, ratingStarsHoverOutFunction);

    $('#ratingStar4').hover(ratingStar4HoverInFunction, ratingStarsHoverOutFunction);

    $('#ratingStar5').hover(ratingStar5HoverInFunction, ratingStarsHoverOutFunction);

    $('#ratingStar1').click(function()
    {
        clearAllStarsFunction();
        ratingCurrent = 0;
        ratingStar1HoverInFunction();
        ratingCurrent = 1;
        isRatingGiven = true;

    });
    $('#ratingStar2').click(function()
    {
        clearAllStarsFunction();
        ratingCurrent = 0;
        ratingStar2HoverInFunction();
        ratingCurrent = 2;
        isRatingGiven = true;

    });
    $('#ratingStar3').click(function()
    {
        clearAllStarsFunction();
        ratingCurrent = 0;
        ratingStar3HoverInFunction();
        ratingCurrent = 3;
        isRatingGiven = true;
    });
    $('#ratingStar4').click(function()
    {
        clearAllStarsFunction();
        ratingCurrent = 0;
        ratingStar4HoverInFunction();
        ratingCurrent = 4;
        isRatingGiven = true;
    });
    $('#ratingStar5').click(function()
    {
        clearAllStarsFunction();
        ratingCurrent = 0;
        ratingStar5HoverInFunction();
        ratingCurrent = 5;
        isRatingGiven = true;
    });

    /**
     * OnShow, dismiss last values to review dialog:
     */
    $('#reviewModal').on('show.bs.modal', function () {
        var modal = $(this);
        ratingCurrent = 0;
        clearAllStarsFunction();
        isCommentGiven = false;
        isRatingGiven = false;
        reviewCommentObject.value = '';
        document.getElementById('errorInReview').style.display = 'none';
        modal.find('.btn-primary').off();
        modal.find('.btn-primary').click(createTryToSendReviewFunction());
    });

    /**
     * old comment value
     */
    var oldVal = '';

    /**
     * on comment field change updates symbols left count and and also sets correct value to isCommentGiven
     */
    $('#reviewComment').on('change keyup paste', function()
    {
        var currentVal = $(this).val();
        if(currentVal === oldVal) {
            return; //check to prevent multiple simultaneous triggers
        }
        oldVal = currentVal;
        var commentLenght = currentVal.length;
        reviewCountLeftSymbolsValueObject.innerHTML = '' +  (255 - commentLenght);
        if (commentLenght > 0) {
            isCommentGiven = true;
        } else {
            isCommentGiven = false;
        }
    });

    /**
     * Creates a function which determines can review be sent now and if yes, send
     * @returns {Function}
     */
    function createTryToSendReviewFunction() {
        return function() {
            if (isCommentGiven && isRatingGiven) {
                console.log('allow to send');
                sendReview(currentTravelId, ratingCurrent, reviewCommentObject.value);
            } else {
                console.log('dont allow to send');
                document.getElementById('errorInReview').style.display = 'block';
            }
        };
    }

    /**
     * ajax function for sending a review
     * @param travelId
     * @param rating
     * @param comment2
     */
    function sendReview(travelId, ratingCurrent, commentCurrent) {
        console.log('try ' + travelId + ' ' + ratingCurrent + ' ' + commentCurrent);
        $('#reviewModal').modal('hide');
        $.ajax({
            url: 'reviewTravel/' + travelId,
            type: 'GET',//ToDo need to change to PUT
            data: { rating : ratingCurrent, comment : commentCurrent },
            contentType: 'application/json; charset=utf-8',
            success: function (response) {
                console.log(response);
                var json = response;
                var obj = JSON && JSON.parse(json) || $.parseJSON(json);
                $.parseResponse(obj);
            },
            complete: function () {
                //window.location.reload(true);
            },
            error: function () {
                $.parseResponse();
            }
        });
    }
    /* END OF SEND REVIEW */

    /* START OF SHOW REVIEWS */

    /**
     * creates function for showing review dialog;
     * @param reviews
     * @returns {Function}
     */
    function createShowTravelReviewsFunction(reviews) {
        return function() {
            setSingleReviewValues(reviews[0], 'review1');
            setSingleReviewValues(reviews[1], 'review2');
            $('#showGivenReviewsModal').modal();
        };

    }

    /**
     * sets correct values to show-reviews dialog
     * @param reviewEntity
     * @param reviewIDInDocument
     */
    function setSingleReviewValues(reviewEntity, reviewIDInDocument) {
        var objDOM = document.getElementById('' + reviewIDInDocument);
        var authorMessage = objDOM.getElementsByClassName('reviewGivenAuthor')[1];
        var yours = '';
        if (reviewEntity.isYour) {
            yours = ' (' + stringYours + ')';
        }
        authorMessage.innerHTML = reviewEntity.name +  yours + ' ' + stringReview + ':';
        if (reviewEntity.rating === null || reviewEntity.rating === 0) {
            objDOM.getElementsByClassName('reviewModalNoReview')[0].style.display = 'block';
            objDOM.getElementsByClassName('reviewContainer')[0].style.display = 'none';
            objDOM.getElementsByClassName('form-control')[0].style.display = 'none';

        } else {
            objDOM.getElementsByClassName('form-control')[0].style.display = 'block';
            objDOM.getElementsByClassName('reviewContainer')[0].style.display = 'block';
            objDOM.getElementsByClassName('reviewModalNoReview')[0].style.display = 'none';
            var stars = objDOM.getElementsByTagName('img');
            var imageLink = null;
            switch(reviewEntity.rating) {
                case 1:
                    imageLink = imageLinkimageLinkRatingStar1;
                    break;
                case 2:
                    imageLink = imageLinkimageLinkRatingStar2;
                    break;
                case 3:
                    imageLink = imageLinkimageLinkRatingStar3;
                    break;
                case 4:
                    imageLink = imageLinkimageLinkRatingStar4;
                    break;
                case 5:
                    imageLink = imageLinkimageLinkRatingStar5;
                    break;
            }
            for (var i=0;i<5;i++) {
                if (i<reviewEntity.rating) {
                    stars[i].src = imageLink;
                } else {
                    stars[i].src = imageLinkimageLinkRatingStar;
                }
            }
            objDOM.getElementsByClassName('form-control')[0].innerHTML  = reviewEntity.comment;
        }
    }
    /* END OF SHOW REVIEWS */

})(window.jQuery);

