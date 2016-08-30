// flag
$(function () {
    $("#flag").click(function () {
        $(".modalBackground").show();
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
            var formdata = {
                page_kid: kid,
                resource_kid: resourceKid,
                resource_name: resourceName,
                reason: $("#flagReason").val(),
                annotation_target: $("#flagTarget").val(),
                annotation_id: $("#flagAnnotation_id").val(),
                explanation: $("#flagExplanation").val(),
                status: "pending"
            };

            $.ajax({
                url: arcss.baseURL + "resources/flags/add",
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
