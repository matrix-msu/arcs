<div id="request_permission_model" class="permissionModal">
    <div class="permission-content">
        <div class="modal-exit"><p><a id="#close" href="#"><?= $this->Html->image('close.svg');?></a></p></div>
        <div class="permission-modal-header">
            <h1>Request User Access for this Project</h1>
        </div>

        <div class="permission-modal-content">
            <p>Selecting "Request User Access" below will send a notification to the admin of the project, who will then provide you access</p>
        </div>

        <div class="permission-modal-responseButtons">
            <p><button>CANCEL</button> <button class="request">REQUEST USER ACCESS</button></p>
        </div>
    </div>

</div>

<script>

  $(document).ready(function() {
    $("#request_permission_model").find(".request").click(function(e){
      $.ajax({
        url: arcs.baseURL + "users/request_permission/7B-2E0-0",
        success: function(result){
          console.log(result);
        }
      });
    })
  })

</script>
