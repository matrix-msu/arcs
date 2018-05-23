var masterDict = JSON.parse(sessionStorage.getItem('masterDict'));
if (masterDict == null){
    masterDict = {};
}

var path = window.location.pathname;

$(document).ready(function() {
    $(".start-install-btn").on("click", function() {
        if (path.substr(path.length - 1) == "/"){
            window.location.href += 'kora'
        }
        else {
            window.location.href += '/kora'
        }
    });

    $("#season-step").on("click", function() {
        $(".project").hide();
        $(".season").show();
        $(".project-nav").removeClass("current-step");
        $(".season-nav").addClass("current-step");
        $(window).scrollTop(0); 
    });
    $("#excavation-step").on("click", function() {
        $(".season").hide();
        $(".excavation").show();
        $(".season-nav").removeClass("current-step");
        $(".excav-nav").addClass("current-step");
        $(window).scrollTop(0); 
    });
    $("#resource-step").on("click", function() {
        $(".excavation").hide();
        $(".resource").show();
        $(".excav-nav").removeClass("current-step");
        $(".resource-nav").addClass("current-step");
        $(window).scrollTop(0); 
    });
    $("#subject-step").on("click", function() {
        $(".resource").hide();
        $(".subject").show();
        $(".resource-nav").removeClass("current-step");
        $(".subject-nav").addClass("current-step");
        $(window).scrollTop(0); 
    });

    //save user input into masterDict 
    $(".cont-install-btn").on("click", function() {

        $(".inputDiv").each(function(){

            if ($(this).children().length == 0) {
                return;
            }
            var text;
            var pTag = $(this).find("p").text();
            masterDict[pTag] = [];

            if ($(this).find(".date-select").length > 0){
                //handle date selection
                $(this).find(".date-select").children().each(function(){
                    text = $(this).val();
                    masterDict[pTag].push(text);
                });
            }
            else if ($(this).find(".period-select").length > 0){
                //handle period selection
                var parent = $(this).find(".period-select");

                text = $(parent).find("input").val();
                masterDict[pTag].push(text);

                text = $(parent).find("select").val();
                masterDict[pTag].push(text);
            }
            else if ($(this).find("input").length > 0){
                //handle single input
                text = $(this).find("input").val();
                masterDict[pTag].push(text);
            }
            else if ($(this).find("select").length > 0){
                //handle single select
                text = $(this).find("select").val();
                masterDict[pTag].push(text);
            }
        });
        sessionStorage.setItem('masterDict', JSON.stringify(masterDict));
        console.log(masterDict);
    });
});