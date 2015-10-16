<div id="user-profile">

    <div class="row" id="user-info">
        <div>
            <div class="score-bubble"><?php echo $user_info['User']['totalCount']; ?></div>

            <img class="profile-image thumbnail"
                src="http://gravatar.com/avatar/<?php echo $user_info['User']['gravatar'] ?>">
            <dl>
                <dd><h2><?php echo $user_info['User']['name']?></h2></dd>
                <dd>
                	<?php echo $user_info['User']['email']?>
                </dd>
                <dd>
                	<?php echo $user_info['User']['username']?></dd>
                <dd><span class="bolded">Role:</span> 
                <?php 
                    $role = $user_info['User']['role'];
                    if ($role == 0) echo "Admin";
                    if ($role == 1) echo "Moderator";
                    if ($role == 2) echo "Researcher";
                ?>
                </dd>
                <dd><span class="bolded">Projects: </span>Polis, Isthmia, Chersonesos, Nemea</dd>
                <dd><span class="bolded">Active Since: </span><?php echo $user_info['User']['activeSince']; ?></dd>
                <?php if ($user['id'] == $user_info['User']['id']): ?>
                    <dd><a href="#" id="edit-profile" onclick="return false;">Edit Profile</a></dd>
                <?php endif ?>
            </dl> 
            
            <dl class="score-description-list">
            	<dd>
            		<?php echo $this->Html->image('annotationsProfile.svg', array('width'=>'35px', 'height'=>'35px')); echo $user_info['User']['annotationsCount']; ?> <span class="description-text">Annotations Made</span>
            	</dd>
            	<dd>
            		<?php echo $this->Html->image('metadataProfile.svg', array('width'=>'35px', 'height'=>'35px')); echo $user_info['User']['metadataCount']; ?> <span class="description-text">Metadata Edits Made</span>
            	</dd>
            	<dd>
            		<?php echo $this->Html->image('discussionsProfile.svg', array('width'=>'35px', 'height'=>'35px')); echo $user_info['User']['commentsCount']; ?> <span class="description-text">Comments Made</span>
            	</dd>
            	<dd>
            		<?php echo $this->Html->image('timeOnSiteProfile.svg', array('width'=>'35px', 'height'=>'35px')); echo $user_info['User']['monthsCount']; ?><span class="description-text">Months On Site</span>
            	</dd>
            </dl>
        </div>
    </div>
    <div class="row tabbable" id="user-actions">
        <ul class="nav nav-tabs">
            <li id='annotations' class=''><a href="#" onclick="changeTab('annotations'); return false;">Annotations</a></li>
            <li id='discussion' class=''><a href="#" onclick="changeTab('discussion'); return false;">Discussions</a></li>
            <li id='collections' class=''><a href="#" onclick="changeTab('collections'); return false;">Collections</a></li>
            <li id='achievements' class=''><a href="#" onclick="changeTab('achievements'); return false;">Achievements</a></li>
            <li id='activity' class=''><a href="#" onclick="changeTab('activity'); return false;">Activity</a></li>
        </ul>
        <div class="tab-content">
            <?php echo $this->element('tabs/annotations-tab') ?>
            <?php echo $this->element('tabs/discussion-tab') ?>
            <?php echo $this->element('tabs/collection-tab') ?>
            <?php echo $this->element('tabs/achievements-tab') ?>
            <?php echo $this->element('tabs/activity-tab') ?>
        </div>
    </div>
</div>

<script type='text/javascript'>
    // EDIT USER
    arcs.profileView = new arcs.views.Profile({
        el: $('#user-profile'),
        model: new arcs.models.User(<?php echo json_encode($user); ?>)
    });

    // SCORE BUBBLE TOOLTIP
    $(document).ready(function() {
        $(".score-bubble").tooltipster({
            content: $('<span>User Contributions</span><br><span><?php echo $this->Html->image("annotationsProfile.svg", array("width"=>"35px", "height"=>"35px")) . "+" . $this->Html->image("metadataProfile.svg", array("width"=>"35px", "height"=>"35px")) . "+" . $this->Html->image("discussionsProfile.svg", array("width"=>"35px", "height"=>"35px")) . "+" . $this->Html->image("timeOnSiteProfile.svg", array("width"=>"35px", "height"=>"35px")) ?></span>'),
            touchDevices: false,
            trigger: 'hover',
            position: 'right'
        });
    });

	// CHANGE TAB
	var currentTab = 'annotations';
	$('li[id=annotations]').addClass('active');
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
