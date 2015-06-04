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
                    <dd><a herf="">Edit Profile</a></dd>
                <?php endif ?>

                <dd><button class="btn" id="edit-btn"><i class="icon-edit"></i>Edit</button></dd>
            </dl>
        </div>.
    </div>

    <div class="row tabbable" id="user-actions">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#uploads-tab">Uploads</a></li>
            <li><a data-toggle="tab" href="#annotations-tab">Annotations</a></li>
            <li><a data-toggle="tab" href="#flagged-tab">Flagged Items</a></li>
            <li><a data-toggle="tab" href="#disucssion-tab">Discussions</a></li>
            <li><a data-toggle="tab" href="#collections-tab">Collections</a></li>
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
</script>
