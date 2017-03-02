$(document).ready(function () {
    var isAdmin = ADMIN;

    // Annotations
    var showAnnotations = true;
    var mouseOn = false;

    $(".resources-annotate-icon").click(function () {
        console.log("ahh");
        if ($('.resources-annotate-icon').attr('src') === "/"+BASE_URL+"img/AnnotationsOff.svg") {
            $('.resources-annotate-icon').attr('src', "/"+BASE_URL+"img/annotationsProfile.svg")
        }
        else {
            $('.resources-annotate-icon').attr('src', "/"+BASE_URL+"img/AnnotationsOff.svg")
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

    var annotateData = {
        transcript: "",
        url: "",
        page_kid: "",
        resource_kid: "",
        resource_name: "",
        relation_resource_kid: "",
        relation_page_kid: "",
        relation_resource_name: "",
        x1: "",
        x2: "",
        y1: "",
        y2: ""
    };
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

    //Load boxes
    function DrawBoxes(pageKid) {
        console.log("draw");
        $(gen_box).remove();
        $(".gen_box").remove();
        $.ajax({
            url: arcs.baseURL + "api/annotations/findall.json",
            type: "POST",
            data: {
                id: pageKid
            },
            success: function (data) {
                $.each(data, function (k, v) {
                    if (v.x1) {
                        $(".canvas").append('<div class="gen_box" id="' + v.id + '"></div>');
                        gen_box = $('#' + v.id);

                        //add css to generated div and make it resizable & draggable
                        $(gen_box).css({
                            'width': $(".canvas").width() * v.x2 - $(".canvas").width() * v.x1,
                            'height': $(".canvas").height() * v.y2 - $(".canvas").height() * v.y1,
                            'left': $(".canvas").width() * v.x1,
                            'top': $(".canvas").height() * v.y1
                        });

                        if (isAdmin == 1) {
                            $(gen_box).append("<div class='deleteAnnotation' id='deleteAnnotation_" + v.id + "'><img src='/'+BASE_URL+'app/webroot/assets/img/Trash-White.svg'/></div>");
                            $(gen_box).append("<div class='flagAnnotation'><img src='/'+BASE_URL+'app/webroot/assets/img/FlagTooltip.svg'/></div>");
                        }
                        else {
                            $(gen_box).append("<div class='flagAnnotation notAdmin'><img src='/'+BASE_URL+'app/webroot/assets/img/FlagTooltip.svg'/></div>");
                        }

                        $("#deleteAnnotation_" + v.id).click(function () {
                            var box = $(this).parent();
                            $.ajax({
                                url: arcs.baseURL + "api/annotations/" + $(this).parent().attr("id") + ".json",
                                type: "DELETE",
                                statusCode: {
                                    204: function () {
                                        box.remove();
                                        GetDetails();
                                    },
                                    // Make modal for this
                                    403: function () {
                                        alert("You don't have permission to delete this annotation");
                                    }
                                }
                            })
                        });
                    }
                });

                $(".flagAnnotation").click(function () {
                    $(".modalBackground").show();
                    $("#flagTarget").show();
                    $('#flagAnnotation_id').val($(this).parent().attr("id"));
                });

                //Mouse over annotation
                $(".gen_box").mouseenter(function () {
                    mouseOn = true;
                    ShowAnnotation($(this).attr('id'));
                });

                $(".gen_box").mouseleave(function () {
                    mouseOn = false;
                    $(".annotationPopup").remove();
                });
            }
        });
    }

    // Annotation popup on the canvas
    function ShowAnnotation(id) {
        $.ajax({
            url: arcs.baseURL + "api/annotations/" + id + ".json",
            type: "GET",
            success: function (data) {
                $(".annotationPopup").remove();
                if (mouseOn) {
                    $("#" + id).append("<div class='annotationPopup'><img class='annotationImage'/><div class='annotationData'></div></div>");
                    $(".annotationPopup").css("left", $("#" + id).width() + 10);
                    if (data.relation_page_kid != "") {
                        var paramKid = (data.relation_resource_kid == data.relation_page_kid) ? data.relation_resource_kid : data.relation_page_kid;
                        var paramSid = (data.relation_resource_kid == data.relation_page_kid) ? "<?php echo RESOURCE_SID;?>" : "<?php echo PAGES_SID;?>";
                        $.ajax({
                            url: arcs.baseURL + "resources/search?q=" + encodeURIComponent(
                                "kid,=," + paramKid) + "&sid=" + paramSid,
                            type: "POST",
                            success: function (page) {
                                $(".annotationImage").attr('src', page.results[0].thumb);
                                $(".annotationData").append("<p>Relation</p>");
                                $(".annotationData").append("<p>Name: " + data.relation_resource_name + "</p>");
                                $(".annotationData").append("<p>Type: " + page.results[0].Type + "</p>");
                                $(".annotationData").append("<p>Scan #: " + page.results[0]["Scan Number"] + "</p>");
                            }
                        });
                    }

                    if (data.transcript != "") {
                        $(".annotationData").append("<p>Transcript: " + data.transcript + "</p>");
                    }

                    if (data.url != "") {
                        $(".annotationData").append("<p>URL: " + data.url + "</p>");
                    }
                }
            }
        });
    }

    // Annotation popup in details tab
    function ShowDetailsAnnotation(t) {
        var id = t.parent().attr('id');
        $.ajax({
            url: arcs.baseURL + "api/annotations/" + id + ".json",
            type: "GET",
            success: function (data) {
                $(".annotationPopup").remove();
                if (mouseOn) {
                    t.append("<div class='annotationPopup detailsPopup'><img class='annotationImage'/><div class='annotationData'></div></div>");
                    $(".annotationPopup").css("left", t.width() + 30);
                    if (data.relation_page_kid != "") {
                        var paramKid = (data.relation_resource_kid == data.relation_page_kid) ? data.relation_resource_kid : data.relation_page_kid;
                        var paramSid = (data.relation_resource_kid == data.relation_page_kid) ? "<?php echo RESOURCE_SID;?>" : "<?php echo PAGES_SID;?>";
                        $.ajax({
                            url: arcs.baseURL + "resources/search?q=" + encodeURIComponent(
                                "kid,=," + paramKid) + "&sid=" + paramSid,
                            type: "POST",
                            success: function (page) {
                                $(".annotationImage").attr('src', page.results[0].thumb);
                                $(".annotationData").append("<p>Relation</p>");
                                $(".annotationData").append("<p>Name: " + data.relation_resource_name + "</p>");
                                $(".annotationData").append("<p>Type: " + page.results[0].Type + "</p>");
                                $(".annotationData").append("<p>Scan #: " + page.results[0]["Scan Number"] + "</p>");
                            }
                        });
                    }

                    if (data.transcript != "") {
                        $(".annotationData").append("<p>Transcript: " + data.transcript + "</p>");
                    }

                    if (data.url != "") {
                        $(".annotationData").append("<p>URL: " + data.url + "</p>");
                    }
                }
            }
        });
    }

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
                    ['Type', 'like', annotateSearch.val()],
                    ['Title', 'like', annotateSearch.val()],
                    ['Resource Identifier', 'like', annotateSearch.val()],
                    ['Description', 'like', annotateSearch.val()],
                    ['Accession Number', 'like', annotateSearch.val()],
                    ['Earliest Date', 'like', annotateSearch.val()],
                    ['Latest Date', 'like', annotateSearch.val()],
                ],
                sid: resource_sid
            },
            success: function (data) {
                BuildResults(data);
            }
        });

        event.preventDefault();
    });

    function BuildResults(data) {
        if (data.total > 0) {
            //Iterate search results
            $.each(data.results, function (key, value) {
                $(".resultsContainer").append("<div class='annotateSearchResult' id='" + value.kid + "'></div>");
                /*if (value.thumb == "img/DefaultResourceImage.svg") {
                 $("#" + value.kid).append("<div class='imageWrap'><img class='resultImage' src='<?php echo Router::url('/', true); ?>app/webroot/" + value.thumb + "'/></div>");
                 }
                 else {
                 $("#" + value.kid).append("<div class='imageWrap'><img class='resultImage' src='" + value.thumb + "'/></div>");
                 }

                 $("#" + value.kid).append(
                 "<div class='resultInfo'>" +
                 "<p>" + value['Accession Number'] + "</p>" +
                 "<p>" + value['Type'] + "</p>" +
                 "</div>"
                 );
                 $("#" + value.kid).append("<hr class='resultDivider'>");*/

                //Get related pages
                $.ajax({
                    //url: arcs.baseURL + "resources/search?q=" + encodeURIComponent("(Resource Associator,like," + value.kid + "),or,(Resource Identifier,like," + value['Resource Identifier'] + ")") + "&sid=<?php echo PAGES_SID;?>",
                    url: arcs.baseURL + "resources/search?q=" + encodeURIComponent("(Resource Identifier,like," + value['Resource Identifier'] + ")") + "&sid=" + page_sid,
                    type: "POST",
                    success: function (pages) {
                        $.each(pages.results, function (k, v) {
                            $("#" + value.kid).after("<div class='annotateSearchResult resultPage' id='" + v.kid + "'></div>");
                            if (v.thumb == "img/DefaultResourceImage.svg") {
                                $("#" + v.kid).append("<div class='imageWrap'><img class='resultImage' src=" + webroot + v.thumb + "/></div>");
//								$('.fullscreenImage').attr('src','<?php echo Router::url('/', true); ?>app/webroot/" + v.thumb + "' );
//								console.log('<?php echo Router::url('/', true); ?>app/webroot/" + v.thumb + "')
                            }
                            else {
                                $("#" + v.kid).append("<div class='imageWrap'><img class='resultImage' src='" + v.thumb + "'/></div>");
                                console.log(v.thumb);
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

                                if (selected || annotateData.transcript.length > 0 || annotateData.url.length > 0) {
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


    function GetDetails() {
        $(".transcript_display").remove();
        $(".annotation_display").remove();
        $.ajax({
            url: arcs.baseURL + "api/annotations/findall.json",
            type: "POST",
            data: {
                id: kid
            },
            success: function (data) {
                data.sort(function (a, b) {
                    if (a.order_transcript < b.order_transcript) return -1;
                    if (a.order_transcript > b.order_transcript) return 1;
                });

                $.each(data, function (key, value) {
                    var trashButton = isAdmin == 1 ? "<img src='/'+BASE_URL+'app/webroot/assets/img/Trash-Dark.svg' class='deleteTranscript'/>" : "";
                    if (value.page_kid == kid && value.transcript != "") {
                        $(".content_transcripts").append("<div class='transcript_display' id='" + value.id + "'>" + value.transcript + "<div class='thumbResource'> <img src='/'+BASE_URL+'app/webroot/assets/img/FlagTooltip.svg' class='flagTranscript'/><img src='/'+BASE_URL+'app/webroot/assets/img/Trash-Dark.svg' class='trashTranscript'/>" + trashButton + "</div></div>");
                    }
                    else {
                        if (value.relation_page_kid != "" && (value.incoming == "false" || !value.incoming)) {
                            $(".outgoing_relations").append("<div class='annotation_display' id='" + value.id + "'><div class='relationName'>" + value.relation_resource_name + "</div><img src='/'+BASE_URL+'app/webroot/assets/img/FlagTooltip.svg' class='flagTranscript'/> <img src='/'+BASE_URL+'app/webroot/assets/img/Trash-Dark.svg' class='trashAnnotation'/>" + trashButton + "</div>");
                        }
                        else if (value.relation_page_kid != "" && value.incoming == "true") {
                            var text = value.x1 ? "Revert to whole resource" : "Define space";
                            $(".incoming_relations").append("<div class='annotation_display " + value.id + "' id='" + value.id + "'><div class='relationName'>" + value.relation_resource_name + "</div><img src='/'+BASE_URL+'app/webroot/assets/img/FlagTooltip.svg' class='flagTranscript'/> <img src='/'+BASE_URL+'app/webroot/assets/img/Trash-Dark.svg' class='trashAnnotation'/>" + trashButton + "<img src='/'+BASE_URL+'app/webroot/assets/img/AnnotationsTooltip.svg' class='annotateRelation'/><div class='annotateLabel'>" + text + "</div></div>");
                        }
                    }
                    if (value.url != "") {
                        $(".urls").append("<div class='annotation_display' id='" + value.id + "'>" + value.url + "<img src='/'+BASE_URL+'app/webroot/assets/img/FlagTooltip.svg' class='flagTranscript'/> <img src='/'+BASE_URL+'app/webroot/assets/img/Trash-Dark.svg' class='trashAnnotation'/>" + trashButton + "</div>");
                    }

                    // Set incoming coordinates or reset incoming annotation coordinates to null
                    $("." + value.id).click(function () {
                        if (!value.x1) {
                            Draw(false, value.id);
                        }
                        else {
                            $.ajax({
                                url: arcs.baseURL + "api/annotations/" + value.id + ".json",
                                type: "POST",
                                data: {
                                    x1: null,
                                    x2: null,
                                    y1: null,
                                    y2: null
                                },
                                success: function () {
                                    DrawBoxes(kid);
                                    GetDetails();
                                }
                            });
                        }
                    });
                });

                $(".flagTranscript").click(function () {
                    $(".modalBackground").show();
                    $("#flagTarget").val("Transcript");
                    $('#flagAnnotation_id').val($(this).parent().attr("id"));
                });
                $(".trashAnnotation").click(function () {
                    console.log("Delete clicked")
                    console.log("delete menu should pop up")
                    $('.deleteBody').html('Are you sure you want to delete this annotation?')
                    $('.deleteWrap').css('display', 'block');
                    console.log($(this).parent().attr("id"))
                    var paramater = $(this).parent().attr("id");
                    $('.deleteButton').unbind().click(function () {
                        console.log('delete annotations')
                        console.log(paramater)
                        $('.deleteWrap').css('display', 'none');
                        $.ajax({
                            url: arcs.baseURL + "api/annotations/" + paramater + ".json",
                            type: "DELETE",
                            statusCode: {
                                204: function () {
                                    console.log("In the 204 status")
                                    GetDetails();
                                    DrawBoxes(kid);

                                },
                                403: function () {
                                    alert("You don't have permission to delete this annotation");
                                }
                            }
                        })

                    });

                });

                $(".trashTranscript").click(function () {
                    console.log("Delete clicked")
                    console.log("delete menu should pop up")
                    $('.deleteBody').html('Are you sure you want to delete this transcription?')
                    $('.deleteWrap').css('display', 'block');
                    console.log($(this).parent().attr("id"))
                    var paramater = $(this).closest('.transcript_display').attr("id");
                    $('.deleteButton').unbind().click(function () {
                        console.log('delete annotations')
                        console.log(paramater)
                        $('.deleteWrap').css('display', 'none');
                        $.ajax({
                            url: arcs.baseURL + "api/annotations/" + paramater + ".json",
                            type: "DELETE",
                            statusCode: {
                                204: function () {
                                    console.log("In the 204 status")
                                    GetDetails();
                                    DrawBoxes(kid);

                                },
                                403: function () {
                                    alert("You don't have permission to delete this annotation");
                                }
                            }
                        })

                    });
//                    $.ajax({
//                        url: arcs.baseURL + "api/annotations/" + $(this).parent().attr("id") + ".json",
//                        type: "DELETE",
//                        statusCode: {
//                            204: function () {
//								console.log("In the 204 status")
//                                GetDetails();
//                                DrawBoxes(kid);
//                            },
//                            403: function () {
//                                alert("You don't have permission to delete this annotation");
//                            }
//                        }
//                    })
                });
//				$('.deleteButton').click(function(){
//					console.log('delete annotations')
//					console.log($(this).parent().attr("id"))
//					$.ajax({
//						url: arcs.baseURL + "api/annotations/" + $(this).parent().attr("id") + ".json",
//						type: "DELETE",
//						statusCode: {
//							204: function () {
//								console.log("In the 204 status")
//								GetDetails();
//								DrawBoxes(kid);
//							},
//							403: function () {
//								alert("You don't have permission to delete this annotation");
//							}
//						}
//					})
//				});
                //Mouse over annotation
                $(".relationName").mouseenter(function () {
                        mouseOn = true;
                        ShowDetailsAnnotation($(this));
                    })
                    .mouseleave(function () {
                        mouseOn = false;
                        $(".annotationPopup").remove();
                    });
            }
        })

    }
});
