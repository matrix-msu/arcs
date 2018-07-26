//this file handles the canvas annotations and the details tab transcriptions and annotations
function annotationPrep() {
    var annotationDataGlobal = null;
    var pageKidGlobal;
    var isAnnotating = false;
    var resourceHasPermissions = false;
    var selectedPage = null;
    var hideAnnotations = false;

    //get annotate to support multi-pages.
    $('.page-slider').on('click', '.other-resource', function(){
        pageKidGlobal = $(this).attr('id');
        newPageClicked();
    });

    function newPageClicked(){
        $('#PageImage').unbind().one('load', function(){ //make sure this function is only called once
            if( $('#PageImagePreloader').css('display') == 'flex' ){
                setTimeout(function(){
                    newPageClicked();
                }, 4000);
                return;
            }
            //resize the canvas
            $(".canvas").height($("#PageImage").height());
            $(".canvas").width($("#PageImage").width());
            $(".canvas").css({bottom: $("#PageImage").height()});
            //if not currently annotating, remove old stuff and prep for the new
            if( !isAnnotating ){
                isAnnotating = true;
                $('#canvas').contents(':not(#missingPictureIcon)').remove();
                $(".annotationPopup").remove();
                $(".annotation_display").remove();
                $(".transcript_display").remove();
                var currentResource = $('.selectedCurrentResource').find('img');
                resourceHasPermissions = !(currentResource.hasClass('showButNoEdit'));
                resourceKid = currentResource.attr('id').replace('identifier-', '');
                resourceIdentifier = RESOURCES[resourceKid]['Resource_Identifier'];
                getAnnotationData();
            }
        });
    }

    //ajax function for getting annotation data, call drawboxes on finish
    function getAnnotationData(){
        $.ajax({
            url: arcs.baseURL + "api/annotations/findByKid",
            type: "POST",
            data: {
                kid: pageKidGlobal
            },
            success: function (data) {
                annotationDataGlobal = JSON.parse(data);
                displayAnnotations();
                isAnnotating = false;
            }
        });
    }

    var canvasWidth;
    var canvasHeight;
    //loop through all of the data and send to boxes, popups, and details
    function displayAnnotations(boxesOnly=false){
        $(".annotationPopup").remove();
        canvasWidth = $('.canvas').width();
        canvasHeight = $('.canvas').height();
        for( var el in annotationDataGlobal['annotationData'] ){
            annotationDataGlobal['annotationData'][el].forEach(function(current){
                drawAnnotationBox(current);
                if( el != "url" && el != 'transcription'){ //no popup for urls and transcriptions
                    appendPopup(current);
                }
                if( boxesOnly == false ){
                    populateDetailsDrawer(current);
                }
            });
        }
    }

    //draw the blue boxes on the canvas
    function drawAnnotationBox(current){
        if( current.x1 == null ){ return; }
        $(".canvas").append('<div class="gen_box"  data-kid="'+pageKidGlobal+'" id="' + current.id + '"></div>');
        var gen_box = $('#' + current.id);
        $(gen_box).css({
            'width': canvasWidth * current.x2 - canvasWidth * current.x1,
            'height': canvasHeight * current.y2 - canvasHeight * current.y1,
            'left': canvasWidth * current.x1,
            'top': canvasHeight * current.y1
        });
        var annotationHtml = '';
        var flagType = "FlagTooltip-White";
        var flagFlagged = "";
        if( annotationFlags.indexOf(current.id) != -1 ){
            flagType = "flagToolTip_Red"; flagFlagged = " flagged";
        }
        var annotationType = 'annotationOutgoing';
        if( current.url != '' ){
            annotationType = 'annotationUrl';
        }else if( current.incoming != null ){
            annotationType = 'annotationIncoming';
        }
        var flagHtml = "<div class='flagAnnotation notAdmin"+flagFlagged+"'>" +
            "<img style='cursor:pointer' src='/"+BASE_URL+"app/webroot/assets/img/"+flagType+".svg' " +
            "class='flagAnnotationId "+annotationType+"' data-annid='"+current.id+"' />" +
            "</div>";
        if(
            ($('#menu').html() == 'Login / Register' && flagType == 'flagToolTip_Red') ||
            $('#menu').html() != 'Login / Register'
        ){
            annotationHtml += flagHtml;
        }
        $(gen_box).html(annotationHtml);
    }

    //append the popup to the gen box
    function appendPopup(current){
        var resourceType = annotationDataGlobal['resource_data'][current.id]['resource'][current.relation_resource_kid]['Type'];
        var resourceIdentifier = annotationDataGlobal['resource_data'][current.id][current.relation_page_kid]['Resource_Identifier'];
        var pageScanNumber = annotationDataGlobal['resource_data'][current.id][current.relation_page_kid]['Scan_Number'];
        var pageThumbSrc = annotationDataGlobal['resource_data'][current.id][current.relation_page_kid]['constructed_image'];
        if( pageScanNumber != "" ){
            pageScanNumber = "Page Number: " + Math.floor(pageScanNumber);
        }
        //append in the popups
        $("#" + current.id).append(
            "<div class='annotationPopup' style='display:none'>"+
                "<img class='annotationImage' src='"+pageThumbSrc+"'/>"+
                "<div class='annotationData'>"+
                    "<p>Relation</p>"+
                    "<p>"+resourceIdentifier+"</p>"+
                    "<p>"+resourceType+"</p>"+
                    "<p>"+pageScanNumber+"</p>"+
                "</div>"+
            "</div>"
        );
        //decide if the popup should go on the left or right
        var offset = $("#" + current.id).width()+10;
        if( current.x1 > .5 ){
            $("#" + current.id).find('.annotationPopup').css('right', 170+'px');
        }else{
            $("#" + current.id).find('.annotationPopup').css('left', offset+'px');
        }
        //decide if the popup should align with the bottom
        if( current.y1 > .5 ){
            $("#" + current.id).find('.annotationPopup').css('top', '-170px');
        }
    }

    //show/hide the annotation popup on a mouse hover
    $( "#canvas" ).on('mouseenter', '.gen_box', function() {
        if( $('#canvas').hasClass('ui-selectable') ){ //don't show popups while selecting
            return;
        }
        $(this).find('.annotationPopup').css('display', 'inline-block');//.css('left',leftOffset);
    });$( "#canvas" ).on('mouseleave', '.gen_box', function() {
        $(this).find('.annotationPopup').css('display', 'none');
    });

    //resize the canvas on a image width change
    $(window).resize(function() {
        $('.resource-reset-icon').click();
        $('#canvas').width($('#PageImage').width());
        if( annotationDataGlobal !== null && !isAnnotating ) {
            displayAnnotations(true);
        }
    });

    $('.content_annotations').on('click', ".relationName", function(){
        var attr = $(this).parent().attr('data-relation-url');
        if (typeof attr !== typeof undefined && attr !== false) {
            var protocol = "http://";
            if( attr.substring(0,7)=='http://' || attr.substring(0,8)=='https://' ){
                protocol = '';
            }
            window.location.href = protocol + attr;
        }else{
            var resource = $(this).parent().attr('data-relation-resource-kid');
            var page = $(this).parent().attr('data-relation-page-kid');
            window.location.href = arcs.baseURL+"resource/" +resource+"?pageSet="+page;
        }
    });

    //clear the details drawer and populate
    function populateDetailsDrawer(current){
        var trashButton = '';
        // if( isAdmin == 1 ){
        //     trashButton = "<img src='/"+BASE_URL+"app/webroot/assets/img/Trash-Dark.svg' class='deleteTranscript'/>";
        // }
        var flagType = "FlagTooltip";
        var flagFlagged = '';
        if( annotationFlags.indexOf(current.id) != -1 ){
            flagType = "flagToolTip_Red"; flagFlagged = 'flagged';
        }
        var flagString1 = "<img src='/"+BASE_URL+"app/webroot/assets/img/"+flagType+".svg' " +
            "class='flagTranscript";
        var flagString2 = " flagAnnotationId' data-annid='"+current.id+"' "+
            "/>" ;
        var trashString = "<img src='/"+BASE_URL+"app/webroot/assets/img/Trash-Dark.svg' class='trashTranscript'/>" + trashButton;

        if( resourceHasPermissions == false ){
            flagString1 = '';
            flagString2 = '';
            trashString = '';
            flagFlagged = '';
        }
        if( current.page_kid == kid && current.transcript != "" ){ //add in the flags for a transcription
            var flagTypeClass = ' details-transcript ';
            if( resourceHasPermissions == false ) flagTypeClass = '';
            console.log('transcript', current)
            $(".content_transcripts").append(
                "<div class='transcript_display' id='" + current.id + "'>" +
                    current.transcript +
                    "<div class='thumbResource'> " +
                    flagString1 + flagTypeClass + flagFlagged + flagString2 +
                    trashString +
                    "</div>" +
                "</div>"
            );
        }else{ //add in the flags in the details tab for the annotations
            //outgoing
            if (current.relation_page_kid != "" && (current.incoming == "false" || !current.incoming)) {
                var flagTypeClass = ' details-outgoing ';
                if( resourceHasPermissions == false ) flagTypeClass = '';
                $(".outgoing_relations").append(
                    "<div " +
                        "class='annotation_display' " +
                        "id='"+current.id+"' " +
                        "data-relation-resource-kid='"+current.relation_resource_kid+"' " +
                        "data-relation-page-kid='"+current.relation_page_kid+"' " +
                    ">" +
                        "<div class='relationName'>" +
                        current.relation_resource_name +
                        "</div>" +
                        flagString1 + flagTypeClass + flagFlagged + flagString2 +
                        trashString +
                    "</div>"
                );
            }else if (current.relation_page_kid != "" && current.incoming == "true") {//incoming
                var text = current.x1 ? "Revert" : "Define space";
                var flagTypeClass = ' details-incoming ';
                var defineSpaceStuff =
                    "<img src='/"+BASE_URL+"app/webroot/assets/img/AnnotationsTooltip.svg' class='annotateRelation'/>"+
                    "<div class='annotateLabel'>" + text + "</div>";
                if( resourceHasPermissions == false ){
                    flagTypeClass = '';
                    defineSpaceStuff = '';
                }
                $(".incoming_relations").append(
                    "<div " +
                        "class='annotation_display' " +
                        "id='"+current.id+"' " +
                        "data-relation-resource-kid='"+current.relation_resource_kid+"' " +
                        "data-relation-page-kid='"+current.relation_page_kid+"' " +
                    ">" +
                        "<div class='relationName'>" +
                        current.relation_resource_name +
                        "</div>" +
                        flagString1 + flagTypeClass + flagFlagged + flagString2 +
                        trashString +
                        defineSpaceStuff +
                    "</div>"
                );
            }
        }
        if (current.url != "") { //add a url flag
            var flagTypeClass = ' details-url ';
            if( resourceHasPermissions == false ) flagTypeClass = '';
            $(".urls").append(
                "<div " +
                    "class='annotation_display' " +
                    "id='"+current.id+"' " +
                    "data-relation-url='"+current.url+"' " +
                ">" +
                    "<div class='relationName'>" +
                        current.url +
                    "</div>" +
                    flagString1 + flagTypeClass + flagFlagged + flagString2 +
                    trashString +
                "</div>"
            );
        }
    }

    //everything to do with edit annotations is below here
    ///////////////////////////////////////////////////////
    $('#annotate-new-btn').click(function(){
        prepareAddAnnotation();
    });
    $('.annotationHelpOk').click(function(){
        removeAddAnnotation();
        resetAnnotations();
    });
    $('.annotationClose').click(function(){
        resetAnnotations();
    });
    function removeAddAnnotation(){
        $('.annotateHelp').hide();
        $('#canvas').css('cursor', '').selectable('destroy');
        $('#ImageWrap').draggable();
    }
    function resetAnnotations(){
        $('.gen_box_temp').remove();
        //$('.resource-icons').css('display', 'table-cell')
        $('.resource-icons').css('visibility', 'visible')
        $('#prev-resource').css('display', '')
        $('.tools').show();
        $(".annotateModalBackground").hide();
        $('.other-resource, .other-resources').off('click.preventPageClicks');
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
    }
    function prepareAddAnnotation(defineSpace = false, id=null){
        $(".annotateSubmit").hide();
        $('.other-resource, .other-resources').on('click.preventPageClicks', preventPageClicks);
        //$('.resource-reset-icon').click();
        //$('.resource-icons').css('display', 'none')
        $('.resource-icons:not(.resource-icon-zoom-in-out)').css('visibility', 'hidden')
        $('#prev-resource').css('display', 'none')
        $('.tools').hide();
        $('.gen_box_temp').remove();
        $('.annotateHelp').show();
        $('#ImageWrap').draggable('destroy');
        var startX,startY,endX,endY,height,width;
        //this is where the actual user annotating code is
        $("#canvas").css('cursor', 'move');
        var zoomScale;
        var canvas = $('#canvas')[0];
        $("#canvas").selectable({
            start: function (e) { //mousedown record the coordinates
                zoomScale = canvas.getBoundingClientRect().width / canvas.offsetWidth;
                //zoomScale = 1;
                startX = e.pageX;
                // console.log('realx', e.pageX);

                var imageWrap = $('#ImageWrap');
                var imageDraggedLeft = parseFloat($(imageWrap).css('left'));
                var imageDraggedTop = parseFloat($(imageWrap).css('top'));

                // console.log('draggedPos ' + imageDraggedLeft + ", " + imageDraggedTop);

                startX = startX - imageDraggedLeft;

                // console.log('scaleX', startX);
                // console.log('zoomscale', zoomScale);
                // console.log('x*scale', zoomScale*startX);
                // console.log('x/scale', startX/zoomScale);
                startY = e.pageY;
            },
            stop: function (e) { //mouseup record the coordinates and draw a temp box.
                endX = e.pageX * zoomScale;
                endY = e.pageY * zoomScale;
                if( endX - startX >= 1 ){
                    width = endX - startX;
                }else{
                    width = startX - endX;
                    var drag_left = true;
                }
                if( endY - startY >= 1 ){
                    height = endY - startY;
                }else{
                    height = startY - endY;
                    var drag_up = true;
                }
                $('#canvas').append('<div class="gen_box gen_box_temp"></div>');
                $('.gen_box_temp').css({
                    'width': width,
                    'height': height,
                    'left': startX,
                    'top': startY - 120
                });
                // console.log('startx', startX);
                // console.log('startY', startY);


                //console.log('draggedPos ' + imageDraggedLeft + ", " + imageDraggedTop);

                //var zoomScale = $('#canvas').css('transform');
                ///console.log('zoomscale:', zoomScale);
                //add extra offset to the temp box depending on how it was drawn
                drag_left ? $('.gen_box_temp').offset({left: endX}) : $('.gen_box_temp').offset({left: startX});
                drag_up ? $('.gen_box_temp').offset({top: endY}) : $('.gen_box_temp').offset({top: startY});

				var gen_box = $('.gen_box_temp');

				//Add coordinates to annotation to save
				annotateData.x1 = parseFloat($(gen_box).css('left'), 10) / $(".canvas").width();
				annotateData.x2 = (parseFloat($(gen_box).css('left')) + width) / $(".canvas").width();
				annotateData.y1 = (parseFloat($(gen_box).css('top'))) / $(".canvas").height();
				annotateData.y2 = (parseFloat($(gen_box).css('top')) + height) / $(".canvas").height();

                removeAddAnnotation(); //remove annotate ability
                if (defineSpace == false){
                    $(".annotateModalBackground").show();
                }else{
                    submitDefineSpace(id, annotateData);
                }
            }
        });
    }

    function preventPageClicks(e){
        e.preventDefault();
        e.stopPropagation();
    }
    //new annotation modal controllers
    $(".annotateTabRelation").click(function () {
        $(".annotateRelationContainer").show();
        $(".annotateTranscriptContainer").hide();
        $(".annotateUrlContainer").hide();
        $('.activeTab').removeClass('activeTab');
        $(".annotateTabRelation").addClass("activeTab");
    });
    $(".annotateTabTranscript").click(function () {
        $(".annotateTranscriptContainer").show();
        $(".annotateRelationContainer").hide();
        $(".annotateUrlContainer").hide();
        $('.activeTab').removeClass('activeTab');
        $(".annotateTabTranscript").addClass("activeTab");
    });
    $(".annotateTabUrl").click(function () {
        $(".annotateUrlContainer").show();
        $(".annotateTranscriptContainer").hide();
        $(".annotateRelationContainer").hide();
        $('.activeTab').removeClass('activeTab');
        $(".annotateTabUrl").addClass("activeTab");
    });
    //Set transcript and url
    $(".annotateTranscript, .annotateUrl").on('change keyup paste mouseup', function () {
        if ($(this).val().length > 0) {
            $(".annotateSubmit").show();
        }else{
            $(".annotateSubmit").hide();
        }
    });

    //everything with annotate search below here-
	var result_ids = [];
    var results_count = 0;
    var results_per_page = 10;
    var current_offset = 0;
    var total_pages = 0;
    var index = 0;
    var page_nums = 0;
	var annotateData = {
        transcript: "",
        relation_id: null,
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
    var resourceKid = '';
    var resourceIdentifier = '';
    //Annotation search for submitted
    $(".annotateSearchForm").submit(function (event) {
        event.stopPropagation();
        event.preventDefault();
        SubmitAnnotateSearch(0);
    });


    //toggle the annotations on and off
    $('.resources-annotate-icon').click(function (event) {
        if (hideAnnotations){
            $('.gen_box').each(function (box) {
                $(this).css("display", "block");
            });
            hideAnnotations = false;
        }else{
            $('.gen_box').each(function (box) {
                $(this).css("display", "none");
            });
            hideAnnotations = true;
        }
    });

    $('.content_annotations').on('click', '.annotateLabel', function(){
        var id = $(this).parent().attr('id');
        var text = $(this)[0].innerHTML;
        var button = $(this);
        
        if (text == 'Define space'){
            $('.tools').css('visibility', 'hidden');
            prepareAddAnnotation(true, id);
        }else{
            $.ajax({
            url: arcs.baseURL + "api/annotations/" + id + ".json",
            type: "POST",
            data: {
                x1: null,
                x2: null,
                y1: null,
                y2: null
            },
            success: function () {
                $(canvas).find('#' + id).remove();
                resetAnnotations();

                $(button).html("Define space");

            }
        });
        }
        resetAnnotations();
    });
    
    function submitDefineSpace(id, annotateData){
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
                //reset annotations and redraw
                $(".annotation_display").remove();
                $(".transcript_display").remove();
                $(".gen_box").remove();
                $(".annotateSubmit").hide();
                resetAnnotations();
                getAnnotationData();
                $('.tools').css('visibility', 'visible');

            }
        });
    }




    function SubmitAnnotateSearch(offset){
        var annotateSearch = $(".annotateSearch");
        var search = annotateSearch.val();
        if( search == '' ){
            return;
        }
        $(".annotateSearch ").hide();
        $(".annotateSubmit").hide();
        $(".annotation_pagination").hide();
        var pKid = $('.selectedCurrentPage').find('img').attr('id');
        pid = getPidFromKid(pKid); //defined in bootstrap.php
        result_ids = [];
        current_offset = offset;
        index = 0;
        total_pages = 0;

        $(".resultsContainer").empty();

        var loader = InjectLoader(".annotateRelationContainer");
        loader.show()
        var pName = $('#resources').attr('href').split('/').pop();

        // Search Resources
        $.ajax({
            url: arcs.baseURL + "simple_search/"+pName+"/"+ encodeURIComponent(search) + "/1/20",
            type: "GET",
            success: function (data) {
                globalData = JSON.parse(data).results
                if( globalData.length == 0 ){
                    loader.remove()
                    $(".annotateSearch ").show()
                    $('.resultsContainer').html('<p style="text-align:center">No Results Found.</p>');
                    return;
                }
                // SetData(globalData, "resource", pid);
                var q = addResourcesToQueue(globalData)
                mapping = {}
                for (var resource in globalData) {
                    mapping[resource] = {
                        title: globalData[resource].Title,
                        survey: globalData[resource]["Excavation Name"],
                    }
                }
                // get pages
                $.ajax({
                    url: arcs.baseURL + "resources/advanced_search",
                    type: "POST",
                    data: {
                        pid: pKid,
                        sid: 'page',
                        q: q
                    },
                    success: function (data) {
						try {
							var pages = JSON.parse(data)
						} catch(e) {
							loader.remove()
							$(".annotateSearch ").show()
							$('.resultsContainer').html('<p style="text-align:center">No Results Found.</p>');
							return;
						}
                        globalData = pages;

                        $.each(globalData, function(key, value) {
                            $(".resultsContainer").append("<div class='annotateSearchResult' id='" + value['kid'] + "'></div>");
                        });

                        SetData(globalData,"resource", pid)
                        loader.remove()
                        $(".annotateSearch ").show()
                    }
                });
            }
        });
    }
	function InjectLoader(injectId) {
        var obj = $(injectId)
        var spinner = $(ARCS_LOADER_HTML);
        obj.ready(function () {
            obj.append(spinner)
        })
        return {
            show: function () {
                $('#annotateModal').css('min-height', '197px');
                $(".annotateRelationContainer").css("text-align", "center")
                obj.css("display","inherit")
            },
            hide: function () {
                $('#annotateModal').css('min-height', '');
                $(".annotateRelationContainer").css("text-align", "initial")
                obj.css("display","none")
            },
            remove: function () {
                $('#annotateModal').css('min-height', '');
                spinner.remove()
                $(".annotateRelationContainer").css("text-align", "initial")
            }
        }
    }
	function addResourcesToQueue(data) {

        var q = Array();

        $.each(data, function (key, value) {
            if (value['Resource_Identifier'] === undefined) {
                //skip pages without a resource Identifier
                return;
            }
            if (result_ids.indexOf(value.kid) == -1 && value['Resource_Identifier'] != "") {
                result_ids.push(value.kid);
                //$(".resultsContainer").append("<div class='annotateSearchResult' id='" + value['Resource_Identifier'] + "'></div>");
                q.push(['Resource_Associator', '=', value['kid']]);
            }
        });
        return q
    }
	function SetData(data, scheme, pid) {
        if (Object.keys(data).length > 0) {
            results_count = 0;
            //Iterate search results
            var q = [];
            var resource_info = {};

            if (scheme == "resource") {
                $.each(data, function (key, value) {
                    if (value['Resource_Identifier'] === undefined) {
                        //skip pages without a resource Identifier
                        return;
                    }
                    if (result_ids.indexOf(value.kid) == -1 && value['Resource_Identifier'] != "") {
                        result_ids.push(value.kid);
                        // if(!("#"+ value['kid']).length > 0) {
                        //     console.log("did thing");
                        //     $(".resultsContainer").append("<div class='annotateSearchResult' id='" + value['kid'] + "'></div>");
                        // }
                        q.push(['Resource_Identifier', '=', value['Resource_Identifier']]);

                        resource_info[value['kid']] = {
                            title: "Resource Title: " + value.Title,
                            scheme: "Relevant Scheme: Resource"
                        }
                    }
                });
            }
            else if (scheme == "subject") {
                $.each(data, function (key, value) {
                    if (result_ids.indexOf(value.kid) == -1 && value['Pages_Associator'] != "") {
                        result_ids.push(value.kid);
                        // if(!$(".resultsContainer").has("#"+ value['Resource_Identifier'])) {
                        //     $(".resultsContainer").append("<div class='annotateSearchResult' id='" + value['kid'] + "'></div>");
                        // }
                        $.each(value['Pages_Associator'], function (i, page) {
                            q.push(['kid', 'like', page]);
                        });

                        resource_info[value['Resource_Identifier']] = {
                            title: "Subject Description: " + value['Artifact_-_Structure_Description'],
                            scheme: "Relevant Scheme: Subject of Observation"
                        }
                    }
                });
            }
            index = 0;
            var counter = 0;

            //Get related pages
            $.each(data, function (kid,v) {
                var tempPid = pid;
                // could not find mapping
                if ( !('Resource_Associator' in v) || mapping[v['Resource_Associator'][0]] === undefined) {
                    return;
                }

                if (index >= current_offset && index < current_offset + results_per_page) {
                    //$("div[id='"+v['Resource_Identifier']+"']").after("<div class='annotateSearchResult' id='" + v.kid + "'></div>");
                    //justin-here $("#" + v['Resource_Identifier']).after("<div class='annotateSearchResult' id='" + v.kid + "'></div>");

					var page_sid = getSidFromKid(v.kid);
                    var image = v['constructed_image'];

                    var pageDisplay = $(".resultsContainer").find("#" + v.kid);
                    if (!(pageDisplay.children().length > 0)){
                        if (image === "") {
                            pageDisplay.append("<div class='imageWrap'><img class='resultImage' src=" + image + "/></div>");
                        }
                        else {
                            pageDisplay.append("<div class='imageWrap'><img class='resultImage' src='" + image + "'/></div>");
                        }
                        /**
                         Scheme Name
                         Resource.Identifer
                         Resource.Title
                         Page.Page Indentifier
                         */
                        var ResourceTitle = mapping[v['Resource_Associator'][0]].title || "No Title"
                        var surveyTitle = mapping[v['Resource_Associator'][0]].survey || "No Survey Name"
                        pageDisplay.append(
                            "<div class='pageInfo'>" +
                            "<p>" + surveyTitle + "</p>" +
                            "<p>" + v['Resource_Identifier']+ "</p>" +
                            "<p>" + ResourceTitle + "</p>" +
                            "<p>" + v['Page_Identifier'] + "</p>" +
                            "</div>"
                        );

                        pageDisplay.append("<hr class='resultDivider'>");
                    }

                    //Clicked a page
                    pageDisplay.off().click(function () {
                        if (selectedPage == pageDisplay) {
                            selectedPage.removeClass("selectedRelation");
                            selected = false;
                            annotateData.page_kid = "";
                            annotateData.resource_kid = "";
                            annotateData.resource_name = "";
                            annotateData.relation_resource_kid = "";
                            annotateData.relation_page_kid = "";
                            annotateData.relation_resource_name = "";
                            selectedPage = null;
                        }
                        else {
                            if(selectedPage != null){
                                selectedPage.removeClass("selectedRelation");
                            }
                            selectedPage = pageDisplay;
                            selectedPage.addClass("selectedRelation");
                            selected = true;
                            annotateData.page_kid = kid;
                            annotateData.resource_kid = resourceKid;
                            annotateData.resource_name = resourceIdentifier;
                            annotateData.relation_resource_name = v['Resource_Identifier'];
                            annotateData.relation_resource_kid = v['Resource_Associator'][0];
                            annotateData.relation_page_kid = v.kid;
                        }

                        if (selected || annotateData.url.length > 0) {
                            $(".annotateSubmit").show();

                        }
                        else {
                            $(".annotateSubmit").hide();
                        }
                    });
                    pageDisplay.css("display", "inherit");
                    counter++;

                }
                else {
                    $(".resultsContainer").find("#"+v.kid).css("display", "none");
                }
                index++;

            });
            index = counter;

            total_pages = Object.keys(globalData).length;
            // Display pagination
            if (current_offset < total_pages) {
                $(".annotation_pagination").show();
                $(".annotation_next").show();
            }
            if (current_offset >= results_per_page) {
                $(".annotation_pagination").show();
                $(".annotation_prev").show();
            }
            if ((current_offset+10) >= total_pages) {
                $(".annotation_next").hide();
            }
            if (current_offset < results_per_page) {
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
                //this is here to always show
                if (i > active_page - 5 && i <= max) {
                    $(".annotation_numbers").append("<span class='" + class_string + "' id='" + i + "'>" + i + "</span>");
                }
            }

            $(".page_number").click(function() {
                var num = parseInt($(this).attr('id'));
                current_offset = (num * results_per_page) - results_per_page
                SetData(globalData, "resource", pid);
            });

            //click event was triggering multiple times, .off needed
            $(".annotation_next").off().click(function() {
                $(".page_active").next()[0].click();
            });

            $(".annotation_prev").off().click(function() {
                $(".page_active").prev()[0].click();
            });

            $(".annotation_begin").off().click(function() {
                $(".annotation_numbers").children().first()[0].click();
            });

            $(".annotation_end").off().click(function() {
                $(".annotation_numbers").children().last()[0].click();
            });
        }
        else {
            if ($(".resultsContainer").children().length > 0 ) {
                $(".resultsContainer").empty();
                $(".resultsContainer").append("<div class='NoResultsMessage'>No results found.</div>");
            }
            else {
                $(".NoResultsMessage").hide();
            }
        }
    }
	$(".annotateSubmit").click(function () {

	    if( $('.annotateUrlContainer').css('display') == 'block' ){
            annotateData.url = $(".annotateUrl").val();
        }
        annotateData.page_kid = kid;
        annotateData.resource_kid = resourceKid;
        annotateData.resource_name = resourceIdentifier;
        annotateData.relation_id = null
        //First relation
        $.ajax({
            url: arcs.baseURL + "api/annotations.json",
            type: "POST",
            data: annotateData,
            success: function (data) {

                annotateData.relation_id = data.id
                if (annotateData.relation_resource_kid != "") {
                    //Backwards relation
                    $.ajax({
                        url: arcs.baseURL + "api/annotations.json",
                        type: "POST",
                        data: {
                            incoming: 'true',
                            relation_id: annotateData.relation_id,
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
                            // save the relation_id to first reference
                            $.ajax({
                                url: arcs.baseURL + "api/annotations/" +annotateData.relation_id+".json",
                                type: "POST",
                                data: {
                                    relation_id: data.id
                                },
                                success: function (data) {
                                }
                            });
                        }
                    });
                }
				//reset annotations and redraw
				$(".annotation_display").remove();
				$(".transcript_display").remove();
				$(".gen_box").remove();
                $(".annotateSubmit").hide();
				resetAnnotations();
				getAnnotationData();
            }
        });
    });

	$(document).on('click', ".trashTranscript", function () {
		if( $(this).parent().hasClass('annotation_display') ){
			$('.deleteBody').html('Are you sure you want to delete this annotation?');
			var parameter = $(this).parent().attr("id");
		}else{
			$('.deleteBody').html('Are you sure you want to delete this transcription?');
			var parameter = $(this).closest('.transcript_display').attr("id");
		}
		$('.deleteWrap').css('display', 'block');
		$('.deleteButton').unbind().click(function () {
			$('.deleteWrap').css('display', 'none');
			$.ajax({
				url: arcs.baseURL + "api/annotations/delete/" + parameter + ".json",
				type: "DELETE",
				statusCode: {
					200: function () {
						$(".annotation_display").remove();
						$(".transcript_display").remove();
						$(".gen_box").remove();
						resetAnnotations();
						getAnnotationData();
					},
					403: function () {
						alert("You don't have permission to delete this annotation");
					}
				}
			})
		});
	});

  $(document).ready(function () {
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

      $(".transcriptSubmit").click(function () {
          //e.preventDefault();
          annotateData.page_kid = kid;
          annotateData.resource_kid = resourceKid;
          annotateData.resource_name = resourceIdentifier;
          annotateData.transcript = $(".transcriptionTextarea").val();
          annotateData.order_transcript = 1000000;

          if (annotateData.transcript.length > 0)
              $.ajax({
                  url: arcs.baseURL + "api/annotations.json",
                  type: "POST",
                  data: annotateData,
                  success: function () {
                      console.log('hererererer')
                      $(".transcriptionTextarea").val('');
                      $(".newTranscriptionForm").hide();
                      //GetDetails();
                      window.location.href = location.href;
                  }
              });
      });
  });

}
