<div class="admin-header-users">
    <p class="allUsers">All Users</p>
    <p class="create">Create</p>
    <p class="invite">Invite</p>
    <p class="pending">Pending</p>
    <span class='active-line'></span>
</div>

<div id="admin-users">
    <div id="users"></div>
</div>
<script type="text/javascript">
    var projectNames = <?php echo json_encode($users[0]['projectNames']) ?>;

  	arcs.adminView = new arcs.views.admin.Users({
      	el: $('#admin-users'),
      	collection: new arcs.collections.UserList(<?php echo json_encode($users) ?>)
  	});
</script>

<div class="admin-pagination users">
	<div class="ipp">
    <div class="menu">
			<p class="curr">25 ITEMS PER PAGE</p>
			<p>50 ITEMS PER PAGE</p>
			<p>75 ITEMS PER PAGE</p>
			<p>DISPLAY ALL</p>
		</div>
	  <div class="drop">
		  <p class="per">25 ITEMS PER PAGE</p>
		  <span class="chevron"></span>
	  </div>
  </div>
  <div class="page-pick">
	  <div class='arrow-wrap left'><span class="chevron left"></span></div>
	  <div class="by-num"></div>
	  <div class='arrow-wrap right'><span class="chevron right"></span></div>
  </div>
</div>
