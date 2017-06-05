<div id="request_permission_model" class="permissionModal">
    <div class="permission-content">
        <div class="modal-exit"><p><a id="#close" href="#"><?= $this->Html->image('close.svg');?></a></p></div>
        <div class="permission-modal-header">
            <h1>Request User Access</h1>
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
      if (window.locked_array.length) {
        var param = locked_array[0]
        $.ajax({
          url: arcs.baseURL + "users/request_permission/" + param,
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
    })
  })

</script>
