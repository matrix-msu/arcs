$(document).ready(function () {
    var isAdmin = ADMIN;

    // Annotations
    var showAnnotations = true;
    var mouseOn = false;

    $(".resources-annotate-icon").click(function () {
        if ($('.resources-annotate-icon').attr('src') === "../img/AnnotationsOff.svg") {
            $('.resources-annotate-icon').attr('src', "../img/annotationsProfile.svg")
        }
        else {
            $('.resources-annotate-icon').attr('src', "../img/AnnotationsOff.svg")
        }

        if (showAnnotations) {
            $(".canvas").hide();
            showAnnotations = false;
        }
        else {
            $(".canvas").show();
            showAnnotations = true;
        }
    });

    var selected = false;

    function waitForElement() {
        if ($("#PageImage").height() !== 0) {
            $(".canvas").height($("#PageImage").height());
            $(".canvas").width($("#PageImage").width());
            $(".canvas").css({bottom: $("#PageImage").height()});
            DrawBoxes(kid);
        }
        else {
            setTimeout(function () {
                waitForElement();
            }, 250);
        }
    }

    waitForElement();

    $(".annotationClose").click(function () {
        $(".annotateModalBackground").hide();
        ResetAnnotationModal();
        $('.gen_box').remove();
        DrawBoxes(kid);
    });

    var gen_box = null;
    var disabled = true;

    function Draw(showForm, id) {
        $(".annotate").addClass("annotateActive");
        $(".canvas").show();
        $(".annotateHelp").show();
        $(".canvas").addClass("select");
        //Draw box
        var i = 0;
        disabled = false;
        $(".canvas").selectable({
            disabled: false,
            start: function (e) {
                if (!disabled) {
                    //get the mouse position on start
                    x_begin = e.pageX;
                    y_begin = e.pageY;
                }
            },
            stop: function (e) {
                if (!disabled) {
                    //get the mouse position on stop
                    x_end = e.pageX,
                        y_end = e.pageY;

                    /***  if dragging mouse to the right direction, calcuate width/height  ***/
                    if (x_end - x_begin >= 1) {
                        width = x_end - x_begin;

                        /***  if dragging mouse to the left direction, calcuate width/height (only change is x) ***/
                    } else {

                        width = x_begin - x_end;
                        var drag_left = true;
                    }

                    /***  if dragging mouse to the down direction, calcuate width/height  ***/
                    if (y_end - y_begin >= 1) {
                        height = y_end - y_begin;

                        /***  if dragging mouse to the up direction, calcuate width/height (only change is x) ***/
                    } else {

                        height = y_begin - y_end;
                        var drag_up = true;
                    }

                    //append a new div and increment the class and turn it into jquery selector
                    $(this).append('<div class="gen_box gen_box_' + i + '"></div>');
                    gen_box = $('.gen_box_' + i);

                    //add css to generated div and make it resizable & draggable
                    $(gen_box).css({
                        'width': width,
                        'height': height,
                        'left': x_begin,
                        'top': y_begin - 120
                    });

                    //if the mouse was dragged left, offset the gen_box position
                    drag_left ? $(gen_box).offset({left: x_end}) : $(gen_box).offset({left: x_begin});
                    drag_up ? $(gen_box).offset({top: y_end}) : $(gen_box).offset({top: y_begin});

                    //Add coordinates to annotation to save
                    annotateData.x1 = parseFloat($(gen_box).css('left'), 10) / $(".canvas").width();
                    annotateData.x2 = (parseFloat($(gen_box).css('left')) + width) / $(".canvas").width();
                    annotateData.y1 = (parseFloat($(gen_box).css('top'))) / $(".canvas").height();
                    annotateData.y2 = (parseFloat($(gen_box).css('top')) + height) / $(".canvas").height();

                    // Show annotation modal or update incoming annotation coordinates
                    if (showForm) $(".annotateModalBackground").show();
                    else {
                        $.ajax({
                            url: arcs.baseURL + "api/annotations/" + id + ".json",
                            type: "POST",
                            data: {
                                x1: annotateData.x1,
                                x2: annotateData.x2,
                                y1: annotateData.y1,
                                y2: annotateData.y2
                            },
                            success: function () {
                                ResetAnnotationModal();
                                GetDetails();
                                DrawBoxes(kid);
                            }
                        });
                    }

                    i++;
                }
            }
        });
    }

    $(".annotate").click(function () {
        Draw(true, null);
    });

    //Annotation search
    $(".annotateSearchForm").submit(function (event) {
        //$(".annotateSearchForm").keyup(function (event) {
        $(".resultsContainer").empty();
        var annotateSearch = $(".annotateSearch");
        $.ajax({
            url: arcs.baseURL + "resources/advanced_search",
            type: "POST",
            data: {
                q: [
                    ['Type', 'like', '%' + annotateSearch.val() + '%'],
                    ['Title', 'like', '%' + annotateSearch.val() + '%'],
                    ['Resource Identifier', 'like', '%' + annotateSearch.val() + '%'],
                    ['Description', 'like', '%' + annotateSearch.val() + '%'],
                    ['Accession Number', 'like', '%' + annotateSearch.val() + '%'],
                    ['Earliest Date', 'like', '%' + annotateSearch.val() + '%'],
                    ['Latest Date', 'like', '%' + annotateSearch.val() + '%']
                ],
                sid: resource_sid
            },
            success: function (data) {
                BuildResults(JSON.parse(data));
            }
        });

        event.preventDefault();
    });

    function BuildResults(data) {
        //Iterate search results
        $.each(data, function (key, value) {
            $(".resultsContainer").append("<div class='annotateSearchResult' id='" + value.kid + "'></div>");

            //Get related pages
            $.ajax({
                url: arcs.baseURL + "resources/advanced_search",
                type: "POST",
                data: {
                    q: [
                        ['Resource Identifier', 'like', value['Resource Identifier']],
                    ],
                    sid: page_sid
                },
                success: function (pages) {
                    pages = JSON.parse(pages);
                    $.each(pages, function (k, v) {
                        var image = KORA_FILES_URI + pid + '/' + page_sid + '/' + v['Image Upload'].localName;
                        $("#" + value.kid).after("<div class='annotateSearchResult' id='" + v.kid + "'></div>");
                        if (v.thumb == "img/DefaultResourceImage.svg") {
                            $("#" + v.kid).append("<div class='imageWrap'><img class='resultImage' src=" + image + "/></div>");
                        }
                        else {
                            $("#" + v.kid).append("<div class='imageWrap'><img class='resultImage' src='" + image + "'/></div>");
                        }

                        $("#" + v.kid).append(
                            "<div class='pageInfo'>" +
                            "<p>" + v['Page Identifier'] + "</p>" +
                            "</div>"
                        );

                        $("#" + v.kid).append("<hr class='resultDivider'>");

                        //Clicked a page
                        $("#" + v.kid).click(function () {
                            if ($(this).hasClass("selectedRelation")) {
                                $(this).removeClass("selectedRelation");
                                selected = false;
                                annotateData.page_kid = "";
                                annotateData.resource_kid = "";
                                annotateData.resource_name = "";
                                annotateData.relation_resource_kid = "";
                                annotateData.relation_page_kid = "";
                                annotateData.relation_resource_name = "";
                            }
                            else {
                                $(".annotateSearchResult").removeClass('selectedRelation');
                                $(this).addClass("selectedRelation");
                                selected = true;
                                annotateData.page_kid = kid;
                                annotateData.resource_kid = resourceKid;
                                annotateData.resource_name = "<?php echo $resource['Resource Identifier']; ?>";
                                annotateData.relation_resource_name = v['Resource Identifier'];
                                annotateData.relation_resource_kid = v['Resource Associator'][0];
                                annotateData.relation_page_kid = v.kid;
                            }

                            if (selected || annotateData.url.length > 0) {
                                $(".annotateSubmit").show();
                            }
                            else {
                                $(".annotateSubmit").hide();
                            }
                        })
                    })
                }
            });
        });
    }

    //Set transcript and url
    var lastValue = '';
    $(".annotateTranscript, .annotateUrl").on('change keyup paste mouseup', function () {
        if ($(this).val() != lastValue) {
            lastValue = $(this).val();
            //annotateData.transcript = $(".annotateTranscript").val();
            annotateData.url = $(".annotateUrl").val();
            if (selected || annotateData.url.length > 0) {
                $(".annotateSubmit").show();
            }
            else {
                $(".annotateSubmit").hide();
            }
        }
    });

    $(".annotateSubmit").click(function () {
        annotateData.page_kid = kid;
        annotateData.resource_kid = resourceKid;
        annotateData.resource_name = "<?php echo $resource['Resource Identifier']; ?>";

        //First relation
        $.ajax({
            url: arcs.baseURL + "api/annotations.json",
            type: "POST",
            data: annotateData,
            success: function (data) {
                $(gen_box).attr("id", data.id);
                gen_box = null;
                DrawBoxes(kid);
                if (annotateData.relation_resource_kid == "") {
                    GetDetails();
                }
            }
        });

        if (annotateData.relation_resource_kid != "") {
            //Backwards relation
            $.ajax({
                url: arcs.baseURL + "api/annotations.json",
                type: "POST",
                data: {
                    incoming: 'true',
                    resource_kid: annotateData.relation_resource_kid,
                    page_kid: annotateData.relation_page_kid,
                    resource_name: annotateData.relation_resource_name,
                    relation_resource_kid: annotateData.resource_kid,
                    relation_page_kid: annotateData.page_kid,
                    relation_resource_name: annotateData.resource_name,
                    transcript: annotateData.transcript,
                    url: annotateData.url
                },
                success: function (data) {
                    GetDetails();
                }
            });
        }
        ResetAnnotationModal();
    });

    function ResetAnnotationModal() {
        //Reset modal
        $(".annotateSearchResult").removeClass('selectedRelation');
        selected = false;
        annotateData.page_kid = "";
        annotateData.resource_kid = "";
        annotateData.relation_resource_kid = "";
        annotateData.relation_page_kid = "";
        annotateData.resource_name = "";
        annotateData.url = "";
        annotateData.transcript = "";
        annotateData.x1 = "";
        annotateData.x2 = "";
        annotateData.y1 = "";
        annotateData.y2 = "";

        disabled = true;

        $(".annotateRelationContainer").show();
        $(".annotateTranscriptContainer").hide();
        $(".annotateUrlContainer").hide();
        $(".annotateTabRelation").addClass("activeTab");
        $(".annotateTabTranscript").removeClass("activeTab");
        $(".annotateTabUrl").removeClass("activeTab");

        $(".annotateModalBackground").hide();
        $(".annotateHelp").hide();
        $(".annotateSearch").val("");
        $(".annotateTranscript").val("");
        $(".annotateUrl").val("");
        $(".resultsContainer").empty();
        $(".canvas").selectable({disabled: true});
        //$( ".canvas" ).removeClass("select ui-selectable ui-selectable-disabled");
        $(".annotate").removeClass("annotateActive");
        $(".annotateSubmit").hide();
    }

    //Tabs
    $(".annotateTabRelation").click(function () {
        $(".annotateRelationContainer").show();
        $(".annotateTranscriptContainer").hide();
        $(".annotateUrlContainer").hide();
        $(".annotateTabRelation").addClass("activeTab");
        $(".annotateTabTranscript").removeClass("activeTab");
        $(".annotateTabUrl").removeClass("activeTab");
    });

    $(".annotateTabTranscript").click(function () {
        $(".annotateTranscriptContainer").show();
        $(".annotateRelationContainer").hide();
        $(".annotateUrlContainer").hide();
        $(".annotateTabTranscript").addClass("activeTab");
        $(".annotateTabRelation").removeClass("activeTab");
        $(".annotateTabUrl").removeClass("activeTab");
    });

    $(".annotateTabUrl").click(function () {
        $(".annotateUrlContainer").show();
        $(".annotateTranscriptContainer").hide();
        $(".annotateRelationContainer").hide();
        $(".annotateTabUrl").addClass("activeTab");
        $(".annotateTabTranscript").removeClass("activeTab");
        $(".annotateTabRelation").removeClass("activeTab");
    });

    $(".annotationHelpOk").click(function () {
        $(".annotateHelp").hide();
    });



});
