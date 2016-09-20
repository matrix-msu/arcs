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