// <!-- Give the resource array to the client-side code -->

function prepAccordion(delayedFire){
    $(function () {
        $("#tabs").tabs();
        function prepAccordionInner(){
            var cnt = 1;
            $(".soo").each(function(){
                var display = $(this).css("display");
                if(display == "none"){
                    $(".soo-click"+cnt).parent().css({display:"none"});
                }
                cnt++;
            });

        }
        $(document).ready(prepAccordionInner);
        if (delayedFire === true) {
            prepAccordionInner();
        }
    });
    $(function () {
        $(".accordion").accordion({
            heightStyle: "fill",
            active: 3
        });
    });
    //height of the viewer window - the height of the tabs - 2 for the border width
    $('.metadata-accordion').height($('#viewer-left').height() - $(".metadata-tabs").height() - 2);
    $('.excavation-div').height('auto');
    $('.excavation-tab-content').height('auto');
    $('.season-tab-content').height('auto');
    $(window).resize(function () {
        $('.metadata-accordion').height($('#viewer-left').height() - $(".metadata-tabs").height() - 2 );
        $('.excavation-div').height('auto');
        $('.excavation-tab-content').height('auto');
    });
    $(function () {
        $("#soo").tabs();
    });
    $(function () {
        //$(".survey-accordion").accordion({
        //    heightStyle: "content"
        //});
    });
}

// $(document).ready(prepAccordion);
$(document).ready(function () {
    $('.metadata-accordion').height($('#viewer-left').height() - $(".metadata-tabs").height() - 2);
    $('.excavation-div').height('auto');
})
