<div id="resource_permission_model" class="permissionModal">
    <div class="permission-content">
        <div class="modal-exit"><p><a id="#close"><?= $this->Html->image('Close.svg', array('alt' => 'CloseimagePermission'));?></a></p></div>
        <div class="permission-modal-header">
            <h1 id="resourcePermHeader">Oh no! This resource is locked!</h1>
        </div>
        <div class="permission-modal-content">
            <p id="resourcePermPara">You will need to login in order to view this private resource</p>
        </div>
        <div class="permission-modal-responseButtons">
            <p>
                <a href="#registerModal">
                    <button class="reg">REGISTER</button>
                </a>
                <a href="#loginModal">
                    <button class="request logModalBtn">LOGIN</button>
                </a>
            </p>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    var permissions = function(){
        console.log('running p4ermissions')

        $("body").on("click", ".resourceLockedDarkBackgroundSP, .resourceLocked, .resourceLockedDarkBackground, .needToLogIn, .resourceLockedDarkBackgroundSearch + .select-overlay, .detailed-locked", function (){
            console.log('clicked')
            $("#resource_permission_model").show();
            $("#resource_permission_model").css("pointer-events", "all");
        });
        $(".modal-exit").click(function () {
            $("#resource_permission_model").hide();
            $("#resource_permission_model").css("pointer-events", "none");
        });
        $(".logModalBtn, .reg").click(function () {
            $(".modal-exit").click();
        });

    }

    if (typeof notAResource !== 'undefined' && notAResource) {
        $('#resourcePermHeader').html("This resource has been removed or no longer exists within the system.");
        $('#resourcePermPara').hide();
        $('.logModalBtn').hide();
        $('.permission-content').css('height', '175px');
        $('.permission-modal-header').css('width', '80%');
        $("#resource_permission_model").show();
    }else if (typeof resourceAccess !== 'undefined' && !resourceAccess) {
        $("#resource_permission_model").show();
    }

    permissions();
});


</script>
