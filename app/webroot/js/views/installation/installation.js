$(document).ready(function() {
    console.log("hit");
    $(".cont-install-btn").on("click", function() {
       
        $(".project").hide();
        $(".season").show();
        $(".project-nav").removeClass("current-step");
        $(".season-nav").addClass("current-step");
        $(window).scrollTop(0);
    });
});