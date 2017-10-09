// flag
function flagPrep() {

    var metadata_info = {};
    metadata_info.field = '';
    metadata_info.target = '';
    metadata_info.metadata_kid = '';
    var detailsTarget = '';
    var currentId = '';

    //click on an annotation flag
    $('#canvas').on('click', ".flagAnnotation", function () {
        var el = $(this);
        if( el.hasClass('flagged') ){ //already flagged so no clicks
            return;
        }
        el.find('img').attr('src', arcs.baseURL+'app/webroot/img/flagToolTip_Blue.svg')
            .removeClass('icon-meta-flag')
            .addClass('icon-meta-flag-blue')
            .addClass('icon-meta-flag-blue-annotation');
        $(".flagModalBackground").show();
        $("#flagTarget").hide();
        var imgEl = el.find('img');
        if( imgEl.hasClass('annotationOutgoing') ){
            detailsTarget = 'Outgoing Relation';
        }else if( imgEl.hasClass('annotationIncoming') ){
            detailsTarget = 'Incoming Relation';
        }else if( imgEl.hasClass('annotationUrl') ){
            detailsTarget = 'URL';
        }
        console.log('target');
        console.log(detailsTarget);
        $('#flagAnnotation_id').val($(this).parent().attr("id"));
        currentId = $(this).find('.flagAnnotationId').attr('data-annid');
        $('.content_annotations').find('#'+currentId).find('.flagTranscript')
            .attr('src', arcs.baseURL+'app/webroot/img/flagToolTip_Blue.svg')
            .removeClass('icon-meta-flag')
            .addClass('icon-meta-flag-blue');
    });

    //click on a metadata flag
    $(".icon-meta-flag").click(function () {
        var flag = $(this);
        flag.css('background-image', 'url('+arcs.baseURL+'app/webroot/img/flagToolTip_Blue.svg)')
            .removeClass('icon-meta-flag').addClass('icon-meta-flag-blue');
        $(".flagModalBackground").show();
        metadata_info.field = flag.next().attr('id');
        metadata_info.target = 'Metadata';
        metadata_info.metadata_kid = flag.closest('table').attr('data-kid');
        return false; //you need this to prevent a metadata edit click
    });

    //click on a details-tab flag
    $(document).on('click', ".flagTranscript", function () {
        var el = $(this);
        if( el.hasClass('flagged') ){ //already flagged so no clicks
            return;
        }
        $(".flagModalBackground").show();
        el.attr('src', arcs.baseURL+'app/webroot/img/flagToolTip_Blue.svg')
            .removeClass('icon-meta-flag').addClass('icon-meta-flag-blue');
        if( el.hasClass('details-transcript') ){ //is transcript
            detailsTarget = 'Transcript';
            currentId = $(this).closest('.transcript_display').attr("id");
            $('#flagAnnotation_id').val(currentId);

        }else if( el.hasClass('details-outgoing') ){ //is outgoing annotation
            detailsTarget = 'Outgoing Relation';
            currentId = $(this).closest('.annotation_display').attr("id");
            $('#flagAnnotation_id').val(currentId);

        }else if( el.hasClass('details-incoming') ){ //is incoming annotation
            detailsTarget = 'Incoming Relation';
            currentId = $(this).closest('.annotation_display').attr("id");
            $('#flagAnnotation_id').val(currentId);

        }else if( el.hasClass('details-url') ){ //is url annotation
            detailsTarget = 'URL';
            currentId = $(this).closest('.annotation_display').attr("id");
            $('#flagAnnotation_id').val(currentId);
        }
        $('#canvas').find('#'+currentId).find('img')
            .attr('src', arcs.baseURL+'app/webroot/img/flagToolTip_Blue.svg')
            .removeClass('icon-meta-flag')
            .addClass('icon-meta-flag-blue')
            .addClass('icon-meta-flag-blue-annotation');

    });

    //close the flags modal
    $(".flagModalClose").click(function () {
        if( detailsTarget != '' ) { //it was a details tab or annotation flag, so apply image this way
            $('.icon-meta-flag-blue').each(function(){
                var flag = $(this);
                var flagType = 'FlagTooltip.svg';
                if( flag.parent().parent().hasClass('gen_box') ){
                    flagType = "FlagTooltip-White.svg";
                }
                flag.removeClass('icon-meta-flag-blue')
                    .addClass('icon-meta-flag')
                    .attr('src', arcs.baseURL + 'app/webroot/img/'+flagType);
            });
        }else { //metadata flag
            $('.icon-meta-flag-blue').removeClass('icon-meta-flag-blue')
                .addClass('icon-meta-flag')
                .css('background-image', 'url(' + arcs.baseURL + 'app/webroot/img/FlagTooltip.svg)');
        }
        $(".flagModalBackground").hide();
        $(".flagSuccess").hide();
        $("#flagReason").val('').show();
        $("#flagExplanation").val('').show();
        $("#flagTarget").val('').hide();
        $("#flagAnnotation_id").val('');
        $(".flagSubmit").show();
        metadata_info.field = '';
        metadata_info.target = '';
        detailsTarget = '';
    });

    $("#flagForm").submit(function (event) {

        // Stop form from submitting normally
        event.preventDefault();

        $(".flagSuccess").hide();

        if ($("#flagReason").val() == '') {
            $(".reasonError").show();
        } else {
            $(".reasonError").hide();
        }

        if ($("#flagExplanation").val() == '') {
            $(".explanationError").show();
        } else {
            $(".explanationError").hide();
        }

        if ($("#flagTarget").val() == '' && $("#flagTarget").is(":visible")) {
            $(".targetError").show();
        } else {
            $(".targetError").hide();
        }

        if ($("#flagReason").val() != '' && $("#flagExplanation").val() != '' && (($("#flagTarget").val() != '' && $("#flagTarget").is(":visible")) || !$("#flagTarget").is(":visible"))) {
            var pageKid = $(".selectedCurrentPage").find('img').attr('id');
            var resource_kid = $(".selectedCurrentPage").attr('id');
            var resource_name = RESOURCES[resource_kid]['Resource Identifier'];
            var formdata = {
                page_kid: pageKid,
                resource_kid: resource_kid,
                resource_name: resource_name,
                reason: $("#flagReason").val(),
                annotation_target: $("#flagTarget").val(),
                annotation_id: $("#flagAnnotation_id").val(),
                explanation: $("#flagExplanation").val(),
                status: "pending"
            };
            formdata.metadata_field = metadata_info.field;
            formdata.metadata_kid = metadata_info.metadata_kid;
            if( metadata_info.target != '' ) {
                formdata.annotation_target = metadata_info.target;
            }else if( detailsTarget != '' ) {
                formdata.annotation_target = detailsTarget;
            }

            //turn the flags red before the submit
            if(  metadata_info.target != '' ){ //metadata flag turns red
                $('.icon-meta-flag-blue')
                    .removeClass('icon-meta-flag-blue')
                    .addClass('icon-meta-flag-red')
                    .css('background-image', 'url('+arcs.baseURL+'app/webroot/img/flagToolTip_Red.svg)')
                    .unbind();
            }else{ //is a annotation or details tab flag
                annotationFlags.push(currentId);
                $('.flagAnnotationId').each(function(){
                    if( $(this).attr('data-annid') == currentId ){
                        $(this).attr('src', arcs.baseURL+'app/webroot/img/flagToolTip_Red.svg')
                            .removeClass('icon-meta-flag-blue')
                            .addClass('icon-meta-flag-red');
                    }
                });
            }
            metadata_info.field = '';
            metadata_info.metadata_kid = '';
            metadata_info.target = '';

            $.ajax({
                url: arcs.baseURL + "flags/add",
                type: "POST",
                data: formdata,
                statusCode: {
                    201: function () {
                        $("#flagReason").val('').hide();
                        $("#flagExplanation").val('').hide();
                        $("#flagTarget").val('').hide();
                        $("#flagAnnotation_id").val('');
                        $(".flagSubmit").hide();
                        $(".flagSuccess").show();

                    }
                }

            });
        }
    });
}

// $( document ).ready(flagPrep);
