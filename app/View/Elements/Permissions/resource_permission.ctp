<div id="resource_permission_model" class="permissionModal">
    <div class="permission-content">
        <div class="modal-exit"><p><a id="#close" href="#"><?= $this->Html->image('Close.svg');?></a></p></div>
        <div class="permission-modal-header">
            <h1>Oh no! This resource is locked!</h1>
        </div>
        <div class="permission-modal-content">
            <p>You will need to login in order to view this private resource</p>
        </div>
        <div class="permission-modal-responseButtons">
            <p> <a href="#registerModal"><button class="reg">REGISTER</button></a>  <a href="#loginModal"><button class="request logModalBtn">LOGIN</button></a> </p>
        </div>
    </div>
</div>

<script>
  $(document).ready(function(){
    var permissions = function(){

          $("body").on("click", ".resourceLockedDarkBackgroundSP, .resourceLocked, .resourceLockedDarkBackground, .needToLogIn", function (){
            console.log("clicked");
            //  $("#resource_permission_model").css("opacity", 1);
            $("#resource_permission_model").show();
            $("#resource_permission_model").css("pointer-events", "all");
          });
          $(".modal-exit").click(function () {
              console.log("close");
              // $("#resource_permission_model").css("opacity", 0);
              $("#resource_permission_model").hide();
              $("#resource_permission_model").css("pointer-events", "none");
          });
          $(".logModalBtn, .reg").click(function () {
             $(".modal-exit").click();
          });

    }

    if (!resourceAccess) {
      $("#resource_permission_model").show();
    }

    permissions();
  });


</script>
