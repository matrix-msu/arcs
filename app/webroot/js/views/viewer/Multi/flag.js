// flag
$(function () {
    $("#flag").click(function () {
        $(".modalBackground").show();
    });

    var metadata_info = {};
    metadata_info.field = '';
    metadata_info.target = '';
    $(".icon-meta-flag").click(function () {
        $(".modalBackground").show();
        metadata_info.field = $(this).next().html();
        metadata_info.target = 'Metadata';
    });

    $(".modalClose").click(function () {
        $(".modalBackground").hide();
        $(".flagSuccess").hide();
        $("#flagTarget").hide();
        $("#flagReason").val('');
        $("#flagExplanation").val('');
        $("#flagTarget").val('');
        $("#flagAnnotation_id").val('');
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
            var pageKid = $("#PageImage").attr('src');
            pageKid = pageKid.split('/');
            pageKid = pageKid.pop();
            pageKid = pageKid.split('-');
            pageKid = pageKid[0]+'-'+pageKid[1]+'-'+pageKid[2];
            var resource_kid = $('.resource-container-level').find('.selectedResource').prev().attr('id');
            resource_kid = resource_kid.replace('identifier-', '');
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
            if( metadata_info.field != '' ){
                formdata.metadata_field = metadata_info.field;
                metadata_info.field = '';
            }
            if( metadata_info.target != '' ){
                formdata.annotation_target = metadata_info.target;
                metadata_info.target = '';
            }

            $.ajax({
                url: arcs.baseURL + "resources/flags/add",
                type: "POST",
                data: formdata,
                statusCode: {
                    201: function () {
                        $("#flagReason").val('');
                        $("#flagExplanation").val('');
                        $("#flagTarget").val('');
                        $(".flagSuccess").show();
                        $("#flagAnnotation_id").val('');
                    }
                }

            });
        }
    });
});
