// <!-- Give the resource array to the client-side code -->

$(document).ready(function(){
    $(function () {
        $("#tabs").tabs();
        $(document).ready(function(){
          var cnt = 1;
          $(".soo").each(function(){
            var display = $(this).css("display");
            if(display == "none"){
              $(".soo-click"+cnt).parent().css({display:"none"});
            }

            cnt++;
          });

        });

    });

    $(function () {
        $(".accordion").accordion({
            heightStyle: "fill"
        });
    });

    $('.metadata-accordion').height($('#viewer-window').height() + 40);

    $(window).resize(function () {
        $('.metadata-accordion').height($('#viewer-window').height());
    });

    $(function () {
        $("#soo").tabs();
    });
    $(function () {
        $(".survey-accordion").accordion({
            heightStyle: "content"
        });
    });



});
