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
    //height of the viewer window - the height of the tabs - 2 for the border width
    $('.metadata-accordion').height($('#viewer-left').height() - $(".metadata-tabs").height() - 2);

    $(window).resize(function () {
        $('.metadata-accordion').height($('#viewer-left').height() - $(".metadata-tabs").height() - 2 );
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
