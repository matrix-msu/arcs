(function(){


      var kid = "<?php echo $kid; ?>";

      var parent;

      function getComments() {
          $.ajax({
              url: "<?php echo Router::url('/', true); ?>api/comments/findall.json",
              type: "POST",
              data: {
                  id: "<?php echo $resource['kid']; ?>"
              },
              success: function (data) {
                  $(".commentContainer").empty();

                  $.each(data, function (index, comment) {
                      if (!comment.parent_id) {
                          $(".commentContainer").append(
                                  "<div class='discussionComment' id='" + comment.id + "'>" +
                                  "<span class='commentName'>" + comment.name + "</span>" +
                                  "<span class='commentDate'>" +
                                  formatDate(comment.created) +
                                  "</span><br><span class='commentBody'>" +
                                  comment.content +
                                  "</span><div class='reply'>Reply</div>" +
                                  "</div>"
                          );
                      }
                  });

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
                                  "</span></div>");
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

      $(".discussion").click(function () {
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
                  url: "<?php echo Router::url('/', true); ?>api/comments.json",
                  type: "POST",
                  data: {
                      resource_kid: "<?php echo $resource['kid']; ?>",
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
                  url: "<?php echo Router::url('/', true); ?>api/comments.json",
                  type: "POST",
                  data: {
                      resource_kid: "<?php echo $resource['kid']; ?>",
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

})();
