// <!-- Give the resource array to the client-side code -->

$(document).ready(function(){
    $(function () {
        $("#tabs").tabs();
        $(document).ready(function(){
          var cnt = 1;
          console.log("hi");
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
        console.log("here");
    });
    $('.metadata-accordion').height($('#viewer-left').height() + 40);

    $(window).resize(function () {
        $('.metadata-accordion').height($('#viewer-left').height()+ 40);
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
