<div id="user-profile">
    <div class="row" id="user-info">
        <div>
            <img class="profile-image thumbnail"
                src="http://gravatar.com/avatar/<?php echo $user_info['User']['gravatar'] ?>">
            <dl>
                <dd><h2><?php echo $user_info['User']['name']?></h2></dd>
                <dd>
                    <a href="mailto:<?php echo $user_info['User']['email'] ?>">
                        <?php echo $user_info['User']['email']; ?></a>
                </dd>
                <dd><?php echo $user_info['User']['username']?></dd>
                <dd>Role: 
                <?php 
                    $role = $user_info['User']['role'];
                    if ($role == 0) echo "Admin";
                    if ($role == 1) echo "Moderator";
                    if ($role == 2) echo "Researcher";
                ?>
                </dd>
                <?php if ($user['id'] == $user_info['User']['id']): ?>
                    <dd><a href="#" id="edit-profile" onclick="return false;">Edit Profile</a></dd>
                <?php endif ?>
            </dl>
        </div>
    </div>
    <div class="row tabbable" id="user-actions">
        <ul class="nav nav-tabs">
            <li id='uploads' class=''><a href="#" onclick="changeTab('uploads'); return false;">Uploads</a></li>
            <li id='annotations' class=''><a href="#" onclick="changeTab('annotations'); return false;">Annotations</a></li>
            <li id='flagged' class=''><a href="#" onclick="changeTab('flagged'); return false;">Flagged Items</a></li>
            <li id='discussion' class=''><a href="#" onclick="changeTab('discussion'); return false;">Discussions</a></li>
            <li id='collections' class=''><a href="#" onclick="changeTab('collections'); return false;">Collections</a></li>
        </ul>
        <div class="tab-content">
            <?php echo $this->element('tabs/uploads-tab') ?>
            <?php echo $this->element('tabs/annotations-tab') ?>
            <?php echo $this->element('tabs/flags-tab') ?>
            <?php echo $this->element('tabs/discussion-tab') ?>
            <?php echo $this->element('tabs/collection-tab') ?>
        </div>
    </div>
</div>

<script type="text/javascript">	
    arcs.profileView = new arcs.views.Profile({
        el: $('#user-profile'),
        model: new arcs.models.User(<?php echo json_encode($user); ?>)
    });

	// used to open tabs
	var currentTab = 'uploads';
	$('li[id=uploads]').addClass('active');
	function changeTab(tab) {
		if (currentTab != tab) {
		 	$("li[id="+currentTab+"]").removeClass('active');
		 	$("#" + currentTab + '-tab').removeClass('active');
		 	$("li[id="+tab+"]").addClass('active');
		 	$("#" + tab + '-tab').addClass('active');
		 	currentTab = tab;
		}
	}
</script>
