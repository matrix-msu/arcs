$(document).ready(function () {
    /*--------Annotations--------*/
    var isAdmin = ADMIN;
    var showAnnotations = true;
    var mouseOn = false;
    var gen_box = null;
    var disabled = true;
    var result_ids = [];
    var results_found = false;
    var results_count = 0;
    var results_per_page = 10;
    var current_offset = 0;
    var total_pages = 0;
    var index = 0;
    var page_nums = 0;
	
	//get annotate to support multi-pages.
	$('#other-resources').find('.img-holder').click(function(){
		$('#canvas').html('');
		waitForElement(0);
	});    

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

    //on document load. wait for page image and trigger drawboxes.
    waitForElement(1);
    function waitForElement(offset) {
        if ($("#PageImage").height() !=0 && $("#PageImage").attr('src') != '../img/arcs-preloader.gif' &&
            $("#PageImage")[0].complete != false ) {
            $(".canvas").height($("#PageImage").height());
            $(".canvas").width($("#PageImage").width());
			if( offset == 1){
				$(".canvas").css({bottom: $("#PageImage").height()});
			}else{
				$(".canvas").css({bottom: '0px'});
			}

            //get current page kid.
            var pageKid = $("#PageImage").attr('src');
            pageKid = pageKid.split('/');
            pageKid = pageKid.pop();
            pageKid = pageKid.split('-');
            pageKid = pageKid[0]+'-'+pageKid[1]+'-'+pageKid[2];
            DrawBoxes(pageKid);
        }
        else {
            setTimeout(function () {
				if(offset == 1){
					waitForElement(1);
				}else{
					waitForElement(0);
				}
            }, 250);
        }
    }

    $(".annotationClose").click(function () {
        $(".annotateModalBackground").hide();
        ResetAnnotationModal();
        $('.gen_box').remove();
        DrawBoxes(kid);
    });

    function Draw(showForm, id) {
        $("#ImageWrap").draggable( "disable" );
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
        SubmitSearch(0);
        event.preventDefault();
    });

    // Search pagination
    $(".annotation_next").click(function() {
        SubmitSearch(current_offset + results_per_page);
    });

    $(".annotation_prev").click(function() {
        SubmitSearch(current_offset - results_per_page);
    });

    $(".annotation_begin").click(function() {
        SubmitSearch(0);
    });

    $(".annotation_end").click(function() {
        SubmitSearch(page_nums * results_per_page - results_per_page);
    });


    function SubmitSearch(offset) {
        result_ids = [];
        current_offset = offset;
        index = 0;
        total_pages = 0;

        $(".resultsContainer").empty();
        var annotateSearch = $(".annotateSearch");
        results_found = false;

        // Search Resources
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
                BuildResults(JSON.parse(data), "resource");
            }
        });

        // Search Subjects of Observation
        $.ajax({
            url: arcs.baseURL + "resources/advanced_search",
            type: "POST",
            data: {
                q: [
                    ['Artifact - Structure Classification', 'like', '%' + annotateSearch.val() + '%'],
                    ['Artifact - Structure Description', 'like', '%' + annotateSearch.val() + '%'],
                    ['Artifact - Structure Type', 'like', '%' + annotateSearch.val() + '%'],
                    ['Artifact - Structure Material', 'like', '%' + annotateSearch.val() + '%'],
                    ['Artifact - Structure Technique', 'like', '%' + annotateSearch.val() + '%'],
                    ['Artifact - Structure Period', 'like', '%' + annotateSearch.val() + '%'],
                    ['Artifact - Structure Terminus Ante Quem', 'like', '%' + annotateSearch.val() + '%'],
                    ['Artifact - Structure Terminus Post Quem', 'like', '%' + annotateSearch.val() + '%']
                ],
                sid: subject_sid
            },
            success: function (data) {
                BuildResults(JSON.parse(data), "subject");
            }
        });
    }

    function BuildResults(data, scheme) {
        if (Object.keys(data).length > 0) {
            results_found = true;
            results_count = 0;
            //Iterate search results
            var q = [];
            var resource_info = {};
            if (scheme == "resource") {
                $.each(data, function (key, value) {
                    if (result_ids.indexOf(value.kid) == -1 && value['Resource Identifier'] != "") {
                        result_ids.push(value.kid);
                        $(".resultsContainer").append("<div class='annotateSearchResult' id='" + value['Resource Identifier'].replace(/\./g, '-') + "'></div>");
                        q.push(['Resource Identifier', '=', value['Resource Identifier']]);

                        resource_info[value['Resource Identifier']] = {
                            title: "Resource Title: " + value.Title,
                            scheme: "Relevant Scheme: Resource"
                        }
                    }
                });
            }
            else if (scheme == "subject") {
                $.each(data, function (key, value) {
                    if (result_ids.indexOf(value.kid) == -1 && value['Pages Associator'] != "") {
                        result_ids.push(value.kid);
                        $(".resultsContainer").append("<div class='annotateSearchResult' id='" + value['Resource Identifier'].replace(/\./g, '-') + "'></div>");
                        $.each(value['Pages Associator'], function (i, page) {
                            q.push(['kid', 'like', page]);
                        });

                        resource_info[value['Resource Identifier']] = {
                            title: "Subject Description: " + value['Artifact - Structure Description'],
                            scheme: "Relevant Scheme: Subject of Observation"
                        }
                    }
                });
            }

            //Get related pages
            $.ajax({
                url: arcs.baseURL + "resources/advanced_search",
                type: "POST",
                data: {
                    q: q,
                    sid: page_sid
                },
                success: function (pages) {
                    pages = JSON.parse(pages);
                    total_pages += Object.keys(pages).length;

                    $.each(pages, function (k, v) {
                        if (index >= current_offset && index < current_offset + results_per_page) {
                            $("#" + v['Resource Identifier'].replace(/\./g, '-')).after("<div class='annotateSearchResult' id='" + v.kid + "'></div>");

                            var image = KORA_FILES_URI + pid + '/' + page_sid + '/' + v['Image Upload'].localName;
                            //var image = "http://dev2.matrix.msu.edu/arcs/app/webroot/thumbs/smallThumbs/" + v['Image Upload'].originalName;
                            var pageDisplay = $("#" + v.kid);
                            if (v.thumb == "img/DefaultResourceImage.svg") {
                                pageDisplay.append("<div class='imageWrap'><img class='resultImage' src=" + image + "/></div>");
                            }
                            else {
                                pageDisplay.append("<div class='imageWrap'><img class='resultImage' src='" + image + "'/></div>");
                            }

                            pageDisplay.append(
                                "<div class='pageInfo'>" +
                                "<p>" + resource_info[v['Resource Identifier']].scheme + "</p>" +
                                "<p>" + resource_info[v['Resource Identifier']].title + "</p>" +
                                "<p>Page Identifier: " + v['Page Identifier'] + "</p>" +
                                "</div>"
                            );

                            pageDisplay.append("<hr class='resultDivider'>");

                            //Clicked a page
                            pageDisplay.click(function () {
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
                            });
                        }
                        if (index >= current_offset + results_per_page) {
                            return false;
                        }
                        index++;
                    });


                    // Display pagination
                    if (index < total_pages) {
                        $(".annotation_pagination").show();
                        $(".annotation_next").show();
                    }
                    if (index > results_per_page) {
                        $(".annotation_pagination").show();
                        $(".annotation_prev").show();
                    }
                    if (index >= total_pages) {
                        $(".annotation_next").hide();
                    }
                    if (index <= results_per_page) {
                        $(".annotation_prev").hide();
                    }
                    if (total_pages <= results_per_page) {
                        $(".annotation_pagination").hide();
                    }

                    page_nums = Math.ceil(total_pages / results_per_page);
                    var active_page = (current_offset / results_per_page) + 1;

                    if (active_page > 1) {
                        $(".annotation_begin").show();
                    }
                    else {
                        $(".annotation_begin").hide();
                    }
                    if (active_page < page_nums) {
                        $(".annotation_end").show();
                    }
                    else {
                        $(".annotation_end").hide();
                    }

                    $(".annotation_numbers").empty();
                    for (var i = 1; i <= page_nums; i++) {
                        var class_string = i == active_page ? "page_number page_active" : "page_number";
                        var max = active_page + 5;
                        if (active_page <= 5) {
                            max = 10;
                        }
                        if (i > active_page - 5 && i <= max) {
                            $(".annotation_numbers").append("<span class='" + class_string + "' id='" + i + "'>" + i + "</span>");
                        }
                    }

                    $(".page_number").click(function() {
                        var num = $(this).attr('id');
                        SubmitSearch((num * results_per_page) - results_per_page);
                    });
                }
            });
        }
        else {
            if (!results_found) {
                $(".resultsContainer").empty();
                $(".resultsContainer").append("<div class='NoResultsMessage'>No results found.</div>");
            }
            else {
                $(".NoResultsMessage").hide();
            }
        }
    }

    //Set transcript and url
    var lastValue = '';
    $(".annotateTranscript, .annotateUrl").on('change keyup paste mouseup', function () {
        if ($(this).val() != lastValue) {
            lastValue = $(this).val();
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
        $("#ImageWrap").draggable( "enable" );
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
        $(".annotation_pagination").hide();
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
        var isAdmin = ADMIN;
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
                    var trashButton = isAdmin == 1 ? "<img src='../app/webroot/assets/img/Trash-Dark.svg' class='deleteTranscript'/>" : "";
                    if (value.page_kid == kid && value.transcript != "") {
                        $(".content_transcripts").append("<div class='transcript_display' id='" + value.id + "'>" + value.transcript + "<div class='thumbResource'> <img src='../app/webroot/assets/img/FlagTooltip.svg' class='flagTranscript'/><img src='../app/webroot/assets/img/Trash-Dark.svg' class='trashTranscript'/>" + trashButton + "</div></div>");
                    }
                    else {
                        if (value.relation_page_kid != "" && (value.incoming == "false" || !value.incoming)) {
                            $(".outgoing_relations").append("<div class='annotation_display' id='" + value.id + "'><div class='relationName'>" + value.relation_resource_name + "</div><img src='../app/webroot/assets/img/FlagTooltip.svg' class='flagTranscript'/> <img src='../app/webroot/assets/img/Trash-Dark.svg' class='trashAnnotation'/>" + trashButton + "</div>");
                        }
                        else if (value.relation_page_kid != "" && value.incoming == "true") {
                            var text = value.x1 ? "Revert to whole resource" : "Define space";
                            $(".incoming_relations").append("<div class='annotation_display " + value.id + "' id='" + value.id + "'><div class='relationName'>" + value.relation_resource_name + "</div><img src='../app/webroot/assets/img/FlagTooltip.svg' class='flagTranscript'/> <img src='../app/webroot/assets/img/Trash-Dark.svg' class='trashAnnotation'/>" + trashButton + "<img src='../app/webroot/assets/img/AnnotationsTooltip.svg' class='annotateRelation'/><div class='annotateLabel'>" + text + "</div></div>");
                        }
                    }
                    if (value.url != "") {
                        $(".urls").append("<div class='annotation_display' id='" + value.id + "'>" + value.url + "<img src='../app/webroot/assets/img/FlagTooltip.svg' class='flagTranscript'/> <img src='../app/webroot/assets/img/Trash-Dark.svg' class='trashAnnotation'/>" + "</div>");
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
                    $('.deleteBody').html('Are you sure you want to delete this annotation?')
                    $('.deleteWrap').css('display', 'block');
                    var parameter = $(this).parent().attr("id");
                    $('.deleteButton').unbind().click(function () {
                        $('.deleteWrap').css('display', 'none');
                        $.ajax({
                            url: arcs.baseURL + "api/annotations/" + parameter + ".json",
                            type: "DELETE",
                            statusCode: {
                                204: function () {
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
                    $('.deleteBody').html('Are you sure you want to delete this transcription?');
                    $('.deleteWrap').css('display', 'block');
                    var parameter = $(this).closest('.transcript_display').attr("id");
                    $('.deleteButton').unbind().click(function () {
                        $('.deleteWrap').css('display', 'none');
                        $.ajax({
                            url: arcs.baseURL + "api/annotations/" + parameter + ".json",
                            type: "DELETE",
                            statusCode: {
                                204: function () {
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

                        $.ajax({
                            url: arcs.baseURL + "resources/advanced_search",
                            type: "POST",
                            data: {
                                q: [
                                    ['kid', '=', paramKid]
                                ],
                                sid: page_sid
                            },
                            success: function (pageData) {
                                var page = JSON.parse(pageData)[paramKid];
                                var image = KORA_FILES_URI + pid + '/' + page_sid + '/' + page['Image Upload'].localName;
                                $(".annotationImage").attr('src', image);
                                $(".annotationData").append("<p>Relation</p>");
                                $(".annotationData").append("<p>Name: " + data.relation_resource_name + "</p>");
                                $(".annotationData").append("<p>Type: " + page.Type + "</p>");
                                $(".annotationData").append("<p>Scan #: " + page["Scan Number"] + "</p>");
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

    //Load boxes
    function DrawBoxes(pageKid) {
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
                            $(gen_box).append("<div class='deleteAnnotation' id='deleteAnnotation_" + v.id + "'><img src='../app/webroot/assets/img/Trash-White.svg'/></div>");
                            $(gen_box).append("<div class='flagAnnotation'><img src='../app/webroot/assets/img/FlagTooltip-White.svg'/></div>");
                        }
                        else {
                            $(gen_box).append("<div class='flagAnnotation notAdmin'><img src='../app/webroot/assets/img/FlagTooltip-White.svg'/></div>");
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

                        $.ajax({
                            url: arcs.baseURL + "resources/advanced_search",
                            type: "POST",
                            data: {
                                q: [
                                    ['kid', '=', paramKid]
                                ],
                                sid: page_sid
                            },
                            success: function (pageData) {
                                var page = JSON.parse(pageData)[paramKid];
                                var image = KORA_FILES_URI + pid + '/' + page_sid + '/' + page['Image Upload'].localName;
                                $(".annotationImage").attr('src', image);
                                $(".annotationData").append("<p>Relation</p>");
                                $(".annotationData").append("<p>Name: " + data.relation_resource_name + "</p>");
                                $(".annotationData").append("<p>Type: " + page.Type + "</p>");
                                $(".annotationData").append("<p>Scan #: " + page["Scan Number"] + "</p>");
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


    /*--------Transcriptions--------*/
    $(".editTranscriptions").click(function () {
        $(".editOptions").show();
        $(".editTranscriptions").hide();

        $(".content_transcripts").sortable({
            disabled: false,
            sort: function (e) {
                $(".newTranscriptionForm").hide();
            }
        });

        $('.transcript_display').addClass("editable");
        $(".editInstructions").show();
    });

    $(".newTranscription").click(function () {
        $('.content_transcripts').append($(".newTranscriptionForm"));
        $(".newTranscriptionForm").show();
    });

    $(".saveTranscription").click(function () {
        $(".transcriptionTextarea").val('');
        $(".newTranscriptionForm").hide();
        $(".editOptions").hide();
        $(".editTranscriptions").show();

        var sortedIDs = $(".content_transcripts").sortable("toArray");
        $.each(sortedIDs, function (k, v) {
            $.ajax({
                url: arcs.baseURL + "api/annotations/" + v + ".json",
                type: "POST",
                data: {
                    order_transcript: k
                }
            });
        });

        $(".content_transcripts").sortable({disabled: true});
        $('.transcript_display').removeClass("editable");
        $(".editInstructions").hide();
    });

    $(".newTranscriptionForm").submit(function (e) {
        e.preventDefault();
        annotateData.page_kid = kid;
        annotateData.resource_kid = resourceKid;
        annotateData.resource_name = "<?php echo $resource['Resource Identifier']; ?>";
        annotateData.transcript = $(".transcriptionTextarea").val();
        annotateData.order_transcript = 1000000;

        if (annotateData.transcript.length > 0)
            $.ajax({
                url: arcs.baseURL + "api/annotations.json",
                type: "POST",
                data: annotateData,
                success: function () {
                    $(".transcriptionTextarea").val('');
                    $(".newTranscriptionForm").hide();
                    GetDetails();
                }
            });
    });



});