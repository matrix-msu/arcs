parent = null

$(document).ready(function(){
      getComments();


      $(".discussion").click(function () {
          var viewer = $("#ImageWrap"),
              submit = $(".submitContainer"),
              toolbar = $("#resource-tools")
          $(".commentContainer").css("height", viewer.height() + toolbar.height() + 1 - submit.height());
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

      $(".newCommentForm,.newReplyForm").submit(function (e) {

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
                      $("#tabs-3").append($(".newCommentForm,.newReplyForm"));
                      $(".newCommentForm,.newReplyForm").hide();
                      $(".newComment").show();
                      getComments();
                  }
              });
          }
          else if ($(".replyTextArea").val() != "") {
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
                      $("#tabs-3").append($(".newCommentForm,.newReplyForm"));
                      $(".newCommentForm,.newReplyForm").hide();
                      $(".newComment").show();
                      getComments();
                  }
              });
              parent = null;
          }
      });


  //	$('.resources-annotate-icon').click(function(){
  //		if ($('.resources-annotate-icon').attr('src') === "../img/AnnotationsOff.svg"){
  //			$('.resources-annotate-icon').attr('src') = "../img/annotationsProfile.svg"
  //		}
  //		else{
  //			$('.resources-annotate-icon').attr('src') = "../img/AnnotationsOff.svg"
  //		}
  //	});
	})
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
                  if( resourceHasPermissions ){
                      replyHtml = "</span><div class='reply'>Reply</div>";
                  }

                  $.each(data, function (index, comment) {
                      if (!comment.parent_id) {
                          $(".commentContainer").append(
                                  "<div class='discussionComment' id='" + comment.id + "'>" +
                                  "<span class='commentName'>" + comment.name + "</span>" +
                                  "<span class='commentDate'>" +
                                  formatDate(comment.created) +
                                  "</span><br><span class='commentBody'>" +
                                  comment.content +
                                  replyHtml +
                                  "</div>"
                          );
                      }
                  });
                  data = data.reverse();
                  $.each(data, function (index, comment) {
                      if (comment.parent_id) {



                          $("#" + comment.parent_id).append(
                                  "<div class='discussionReply' id='" + comment.id + "'><span class='replyTo'>" +
                                  "In reply to " + $("#" + comment.parent_id + " > .commentName").html() +
                                  "</span><br><span class='commentName'>" +
                                  comment.name +
                                  "</span><span class='commentDate'>" +
                                  formatDate(comment.created) +
                                  "</span><br><span class='commentBody'>" +
                                  comment.content +
                                  replyHtml +
                                  "</div>"
                          );
                      }
                  });

                  $(".reply").click(function () {
                      $("#tabs-3").append($(".newReplyForm"));
                      $(".replyTextArea").val("");
                      // $(this).parent().append($(".newReplyForm"));
                      $(".newReplyForm").show();
                      $(".newReplyForm").removeAttr('style');
                      $(".newReplyForm").css("display", "inline");
                      $(".newComment").show();
                      parent = $(this).parent().attr("id");

                      $('html, body').animate({
                          scrollTop: $(".newReplyForm").offset().top - 600
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
