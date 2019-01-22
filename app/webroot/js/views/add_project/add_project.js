if( typeof JS_IS_ADD_PROJECT_PAGE !== 'undefined'){
    $(document).ready(function() {
        var path = window.location.pathname;
        console.log('herere')

        $(".start-install-btn").on("click", function() {
            if (path.substr(path.length - 1) == "/"){
                window.location.href += 'download'
            }
            else {
                window.location.href += '/download'
            }
        });

        $(".continue-to-projConfig-btn").on("click", function() {
            var url =  window.location.href;
            url = url.replace(/\/[^\/]*$/, '/config')
            window.location.href = url;
        });

        function checkFields(selector="") {
            var valid = true;
            $(".req").each(function(){
                if(selector.length > 0 && $(this).parents("." + selector).length <= 0){
                    return;
                }
                else{
                    if ($(this).val() != null && $(this).val().length > 0 && $(this).val() != $(this).attr("placeholder")){
                        return;
                    }
                    else{
                        valid = false;
                        $(".required-notice").show();
                        console.log("not valid");
                    }
                }
            });

            if(valid){
                $(".required-notice").hide();
            }
            return valid;
        }

        $("form").on("submit", function() {
            var valid = checkFields();
            if(!valid){
                event.preventDefault();
            }
        })

        $("#season-step").on("click", function() {
            var valid = checkFields("project");
            if(!valid){
                return;
            }

            $(".project").hide();
            $(".season").show();
            $(".project-nav").removeClass("current-step");
            $(".season-nav").addClass("current-step");
            $(window).scrollTop(0);
        });
        $("#excavation-step").on("click", function() {
            var valid = checkFields("season");
            if(!valid){
                return;
            }

            $(".season").hide();
            $(".excavation").show();
            $(".season-nav").removeClass("current-step");
            $(".excav-nav").addClass("current-step");
            $(window).scrollTop(0);
        });
        $("#resource-step").on("click", function() {
            var valid = checkFields("excavation");
            if(!valid){
                return;
            }

            $(".excavation").hide();
            $(".resource").show();
            $(".excav-nav").removeClass("current-step");
            $(".resource-nav").addClass("current-step");
            $(window).scrollTop(0);
        });
        $("#subject-step").on("click", function() {
            var valid = checkFields("resource");
            if(!valid){
                return;
            }

            $(".resource").hide();
            $(".subject").show();
            $(".resource-nav").removeClass("current-step");
            $(".subject-nav").addClass("current-step");
            $(window).scrollTop(0);
        });


    });
}