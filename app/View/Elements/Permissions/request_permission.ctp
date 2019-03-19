<div id="request_permission_model" class="permissionModal">
    <div class="permission-content">
        <div class="modal-exit" style="cursor:pointer"><p><a id="#close"><?= $this->Html->image('Close.svg' , array('alt' => 'Exit'));?></a></p></div>
        <div class="permission-modal-header">
            <h1>Request User Access</h1>
        </div>

        <div class="permission-modal-content">
            <p>Selecting "Request User Access" below will send a notification to the admin of the project, who will then provide you access.</p>
        </div>

        <div class="permission-modal-responseButtons">
            <p><button class="modal-cancel">CANCEL</button> <button class="request">REQUEST USER ACCESS</button></p>
        </div>
    </div>

</div>
<script>
    $(document).ready(function() {
        var currentlyClickedLockedResourceKid = '';
        $("#request_permission_model").find(".request").click(function(e){
            var lastPart = window.location.href.split("/").pop().split("?")[0];
            console.log('click', currentlyClickedLockedResourceKid)
            if( lastPart.split('-').length == 3 ){
                currentlyClickedLockedResourceKid = lastPart;
            }
            if( currentlyClickedLockedResourceKid !== '' ){
                $.ajax({
                    url: arcs.baseURL + "users/request_permission/" + currentlyClickedLockedResourceKid,
                    success: function(response){
                        $('<form />')
                            .hide()
                            .attr({ method : "post" })
                            .attr({ action : arcs.baseURL})
                            .append($('<input />')
                                .attr("type","hidden")
                                .attr({ "name" : "flashSet" })
                                .val(response)
                            )
                            .append('<input type="submit" />')
                            .appendTo($("body"))
                            .submit();
                    }
                });
            }
        });
        $("body").on("click", ".resourceLockedDarkBackgroundSP, .resourceLocked, .resourceLockedDarkBackground, .needToLogIn, .resourceLockedDarkBackgroundSearch + .select-overlay, .detailed-locked", function (){
            $("#request_permission_model").show();
            $("#request_permission_model").css("pointer-events", "all");
            var resourceThumb = $(this).closest('.resource-thumb').attr('data-resource-kid');
            if( resourceThumb == undefined ){
                resourceThumb = $(this).closest('.resource-pic').attr('data-resource-kid');
            }
            currentlyClickedLockedResourceKid = resourceThumb;
        });
        $(".modal-exit, .modal-cancel").click(function () {
            $("#request_permission_model").hide();
            $("#request_permission_model").css("pointer-events", "none");
        });
        if (typeof resourceAccess !== 'undefined' && !resourceAccess) {
            $("#request_permission_model").show();
        }
    })

</script>
