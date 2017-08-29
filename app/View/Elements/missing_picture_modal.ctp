<div id="missing_picture_modal" class="permissionModal">
    <div id="missing_picture_content" class="permission-content" style="height:255px;">
        <div class="modal-exit" style="cursor:pointer"><p><a id="#close"><?= $this->Html->image('Close.svg');?></a></p></div>
        <div id="missing_picture_login">
            <div class="permission-modal-header">
                <h1>Login Required</h1>
            </div>
            <div class="permission-modal-content">
                <p>You will need to login in order to notify the admin that this resource is missing an image</p>
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
        <div id="missing_picture_loggedin" style="display:none;">
            <div class="permission-modal-header">
                <h1 id="missing_picture_header">Notify Admin of Missing Image?</h1>
            </div>

            <div class="permission-modal-content">
                <p>Selecting “Notify Admin” will send an email to the admin of the project encouraging them to add an image file to this resource.</p>
            </div>

            <div class="permission-modal-responseButtons">
                <p>
                    <button id="missing_picture_cancel" class="modal-cancel">CANCEL</button>
                    <button id="missing_picture_notify" class="request">NOTIFY ADMIN</button>
                </p>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function() {
        $("body").on("click", "#missingPictureIcon", function (){
            if( $('#menu').html() == 'Login / Register' ){
                $('#missing_picture_login').css('display', 'block');
                $('#missing_picture_loggedin').css('display', 'none');
                $('#missing_picture_content').css('height', '255px');
            }else{
                $('#missing_picture_login').css('display', 'none');
                $('#missing_picture_loggedin').css('display', 'block');
                $('#missing_picture_content').css('height', '300px');
            }
            $('#missing_picture_modal').css('display', 'block')
        });
        $("#missing_picture_modal .modal-exit, .modal-cancel").click(function () {
            $('#missing_picture_modal').css('display', 'none')
        });
        $('#missing_picture_notify').click(function(){
            console.log('notify admin click')
            $.ajax({
                url: arcs.baseURL + "users/missingPictureNotifyAdmin",
                type: "POST",
                data: {resourceKid: $('#missingPictureIcon').attr('data-kid')},
                success: function (data) {
                    $('#missing_picture_notify').remove();
                    $('#missing_picture_cancel').remove();
                    var message = "An email has been successfully sent to the admin";
                    if( data == true ){
                        $('#missing_picture_header').html("Success!");
                    }else{
                        message = "Something went wrong with the email process. Try refreshing the page, and logging out"+
                            "and back in. If the problem persists, contact an administrator.";
                        $('#missing_picture_header').html("Oh no! Something went wrong.");
                    }
                    $('#missing_picture_loggedin .permission-modal-content').html(message);
                }
            });
        });
  })

</script>
