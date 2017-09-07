//js file for all of the discussions/comments in the multi-viewer
parent = null;
var editCommentOldValue = '';

$(document).ready(function(){
    getComments();

    $(".discussion").click(function () {
        var viewer = $("#ImageWrap"),
        submit = $(".submitContainer"),
        toolbar = $("#resource-tools")
        $(".commentContainer").css("height", viewer.height() + toolbar.height() + 2 - submit.height());
        getComments();
    });

    $(".newComment").click(function () {
        $("#tabs-3").append($(".newCommentForm"));
        $(".commentTextArea").val("");
        $(".newCommentForm").show();
        $(".newCommentForm").removeAttr('style');
        $(".newCommentForm").css("display", "inline");
        $(this).hide();
        parent = null;
    });

    $(".closeComment").click(function () {
        $(".commentTextArea,.replyTextArea").val("");
        $(".newCommentForm,.newReplyForm").hide();
        $(".newComment").show();
    });

    $(".newCommentForm,.newReplyForm ").submit(function (e) {
        e.preventDefault();
        if ($(".commentTextArea").val() != "") {
            $.ajax({
                url: NEW_COM_URL,
                type: "POST",
                data: {
                    resource_kid: CM_R_ID,
                    content: $(".commentTextArea").val(),
                    parent_id: parent
                },
                success: function (data) {
                    $(".commentTextArea").val("");
                    $("#tabs-3").append($(".newCommentForm,.newReplyForm, .newEditDiscussionReplyForm"));
                    $(".newCommentForm,.newReplyForm, .newEditDiscussionReplyForm").hide();
                    $(".newComment").show();
                    getComments();
                }
            });
        }else if ($(".replyTextArea").val() != "") {
            $.ajax({
                url: NEW_COM_URL,
                type: "POST",
                data: {
                    resource_kid: CM_R_ID,
                    content: $(".replyTextArea").val(),
                    parent_id: parent
                },
                success: function (data) {
                    $(".replyTextArea").val("");
                    $("#tabs-3").append($(".newCommentForm,.newReplyForm, .newEditDiscussionReplyForm"));
                    $(".newCommentForm,.newReplyForm, .newEditDiscussionReplyForm").hide();
                    $(".newComment").show();
                    getComments();
                }
            });
            parent = null;
        }
    });
    $(".newEditDiscussionReplyForm").submit(function (e) {
        e.preventDefault();
        if( $('.editDiscussionTextArea').val() !== editCommentOldValue ){
            $.ajax({
                url: "../comments/editComment",
                type: "POST",
                data: {
                    resource_kid: CM_R_ID,
                    content: $(".editDiscussionTextArea").val(),
                    id: parent
                },
                success: function (data) {
                    $(".editDiscussionTextArea").val("");
                    $("#tabs-3").append($(".newCommentForm,.newReplyForm, .newEditDiscussionReplyForm"));
                    $(".newCommentForm,.newReplyForm, .newEditDiscussionReplyForm").hide();
                    $(".newComment").show();
                    getComments();
                }
            });
            parent = null;
        }
    });
});

function getComments() {
    var currentResource = $('#identifier-'+CM_R_ID);
    var resourceHasPermissions = !(currentResource.hasClass('showButNoEdit'));
    $.ajax({
        url: CM_URL,
        type: "POST",
        data: {
            id: CM_R_ID
        },
        success: function (data) {
            $(".commentContainer").empty();

            var replyHtml = '';
            var editHtml = "</span><div class='editComment'>Edit</div>";
            var editHtmlHidden = "</span><div class='editComment' style='visibility:hidden'>Edit</div>";
            var tmpHtml = '';
            var userId = $('#cage').attr('data-userid');
            if( resourceHasPermissions ){
                replyHtml = "</span><div class='reply'>Reply</div>";
                tmpHtml = editHtml;
            }

            $.each(data, function (index, comment) {
                if (!comment.parent_id) {
                    tmpHtml = editHtmlHidden;
                    if( userId === comment.user_id ){
                        tmpHtml = editHtml;
                    }
                    $(".commentContainer").append(
                        "<div class='discussionComment discussionId' id='" + comment.id + "'>" +
                        "<span class='commentName'>" + comment.name + "</span>" +
                        "<span class='commentDate'>" +
                        formatDate(comment.created) +
                        "</span><br><span class='commentBody' data-content='"+comment.content+"'>" +
                        comment.content +
                        "<div id='commentEditReplyContainer'>"+tmpHtml+replyHtml+"</div>"+
                        "</div>"
                    );
                }
            });
            data = data.reverse();
            $.each(data, function (index, comment) {
                if (comment.parent_id) {
                    tmpHtml = editHtmlHidden;
                    if( userId === comment.user_id ){
                        tmpHtml = editHtml;
                    }
                    $("#" + comment.parent_id).append(
                        "<div class='discussionReply discussionId' id='" + comment.id + "'><span class='replyTo'>" +
                        "In reply to " + $("#" + comment.parent_id + " > .commentName").html() +
                        "</span><br><span class='commentName'>" +
                        comment.name +
                        "</span><span class='commentDate'>" +
                        formatDate(comment.created) +
                        "</span><br><span class='commentBody' data-content='"+comment.content+"'>" +
                        comment.content +
                        "<div id='commentEditReplyContainer'>"+tmpHtml+replyHtml+"</div>"+
                        "</div>"
                    );
                }
            });

            $(".reply").click(function () {
                $("#tabs-3").append($(".newReplyForm"));
                $(".replyTextArea").val("");
                $(".newReplyForm").show();
                $(".newReplyForm").removeAttr('style');
                $(".newReplyForm").css("display", "inline");
                $(".newComment").show();
                parent = $(this).closest('.discussionComment').attr("id");
                $('html, body').animate({
                    scrollTop: $(".newReplyForm").offset().top - 600
                }, 1000);
            });

            $(".editComment").click(function(){
                console.log('edit click')
                console.log($(".newEditDiscussionReplyForm"))
                editCommentOldValue = "";
                editCommentOldValue = $(this).closest('.commentBody').attr('data-content');
                $("#tabs-3").append($(".newEditDiscussionReplyForm"));
                $(".editDiscussionTextArea").val(editCommentOldValue);
                $(".newEditDiscussionReplyForm").show();
                $(".newEditDiscussionReplyForm").removeAttr('style');
                $(".newEditDiscussionReplyForm").css("display", "inline");
                $(".newComment").show();
                parent = $(this).closest('.discussionId').attr("id");
                $('html, body').animate({
                    scrollTop: $(".newEditDiscussionReplyForm").offset().top - 600
                }, 1000);
            });
        }
    });
}

function formatDate(input) {
    var d = new Date(Date.parse(input.replace(/-/g, "/")));
    var month = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
    var date = month[d.getMonth()] + "." + d.getDate() + "." + d.getFullYear();
    return (date);
}
