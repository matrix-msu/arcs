$(document).ready(function() {
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
});