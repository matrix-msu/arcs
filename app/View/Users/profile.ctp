<script src="<?php echo Router::url('/', true); ?>js/vendor/chosen.jquery.js"></script>

<div id="user-profile">

    <div class="row" id="user-info">
        <div>
            <div class="score-image-container">
                <div class="score-bubble">
                    <?php
                        if( $user_info['username'] == 'noah.girard' ){
                            echo '<p style="width: 68px;font-size: 14px;line-height: 15px;padding-top: 18px;font-weight:bold">
                                    Nothing. You suck.
                                  </p>';
                        }else{
                            echo $user_info['totalCount'];
                        }

                        $allProjects = array();
                        foreach ($projects as $p) {
                            array_push($allProjects, $p['Persistent_Name']);
                        }


                        $users_projects = array();
                        foreach ($user_info['mappings'] as $p) {
                            array_push($users_projects, $p['project']);
                        }
                    ?>
                </div>

                <div class="profile-image-container">
                  <img class="profile-image thumbnail" src = "<?php echo $user_info['profileImage']; ?>">
                </div>
            </div>
            <dl class="user-project-info">
                <dd>
                    <h2 id="userInfoName"><?php echo $user_info['name'];?></h2>
                </dd>
                <dd id="userInfoEmail">
                    <?php echo $user_info['email'];?>
                </dd>
                <dd id="userInfoUsername">
                	<?php echo $user_info['username'];?>
                </dd>
                <dd>
                    <?php
                    $projects = array();
                    foreach($user_info['mappings'] as $mapping) {
                        $projectString = ucwords(str_replace('_', ' ', $mapping['project']));
                        if ($mapping['status'] == 'confirmed'){
                          $string = '<span class="bolded">'.$projectString.'</span>: '.$mapping['role'];
                        }else{
                          $string = '<span class="bolded">'.$projectString.'</span>: Unconfirmed';
                        }
                        $projects[] = $string;
                    }
                    echo implode('<br /> ', $projects);
                    ?>
                </dd>
                  <?php if ($user['id'] == $user_info['id']): ?>
                      <dd>
                          <a href="#addProjectModal" id="request-project">Request Project Access</a>
                      </dd>
                  <?php endif ?>
                <dd>
                    <span class="bolded">Active Since: </span><?php echo $user_info['activeSince']; ?>
                </dd>
                <?php if ($user['id'] == $user_info['id']): ?>
                    <dd>
                        <a href="#" id="edit-profile" onclick="return false;">Edit Profile</a>
                    </dd>
                <?php endif ?>
                <?php echo $user_info['thumbnails'] ?>
            </dl>

            <dl class="score-description-list">
            	<dd>
            		<?php echo $this->Html->image('annotationsProfile.svg', array('width'=>'35px', 'height'=>'35px')); ?>
                    <div class="score-number"><?php echo $user_info['annotationsCount']; ?></div>
                     <span class="description-text">Annotations Made</span>
            	</dd>
            	<dd>
            		<?php echo $this->Html->image('metadataProfile.svg', array('width'=>'35px', 'height'=>'35px')); ?>
                    <div class="score-number"><?php echo $user_info['metadataCount']; ?> </div>
                    <span class="description-text">Metadata Edits Made</span>
            	</dd>
            	<dd>
            		<?php echo $this->Html->image('discussionsProfile.svg', array('width'=>'35px', 'height'=>'35px')); ?>
                    <div class="score-number"><?php echo $user_info['commentsCount']; ?> </div>
                     <span class="description-text">Comments Made</span>
            	</dd>
            	<dd>
            		<?php echo $this->Html->image('timeOnSiteProfile.svg', array('width'=>'35px', 'height'=>'35px')); ?>
                    <div class="score-number"><?php echo $user_info['monthsCount']; ?> </div>
                    <span class="description-text">Months On Site</span>
            	</dd>
            </dl>
        </div>
    </div>

    <div class="row tabbable" id="user-actions">
        <div class="toolbar">
            <h2 class="tab-name"></h2>
            <div class="user-actions"></div>
        </div>
        <ul class="nav nav-tabs">
            <li id='annotations' class=''>
                <a href="#">Annotations</a>
            </li>
            <li id='transcriptions' class=''>
                <a href="#">Transcriptions</a>
            </li>
            <li id='discussion' class=''>
                <a href="#">Discussions</a>
            </li>
            <li id='collections' class=''>
                <a href="#">Collections</a>
            </li>
<!--            <li id='achievements' class=''>-->
<!--                <a href="#">Achievements</a>-->
<!--            </li>-->
            <li id='activity' class=''>
                <a href="#">Activity</a>
            </li>
<!--            <li id='testingEdit' class='' style="display:none;">test</li>-->
        </ul>
        <div class="tab-content">
            <?php echo $this->element('tabs/annotations-tab') ?>
            <?php echo $this->element('tabs/transcriptions-tab') ?>
            <?php echo $this->element('tabs/discussion-tab') ?>
            <?php echo $this->element('tabs/collection-tab') ?>
<!--            --><?php //echo $this->element('tabs/achievements-tab') ?>
            <?php echo $this->element('tabs/activity-tab') ?>
        </div>
    </div>
</div>
<!--<div id="addProjectModal" id="modal" class="addProject">-->
    <div id="addProjectModal" class="register">
        <div class="register-content">
            <a id="#close" class="reverse-filter" href="#">
              <?=
              $this->Html->image('Close.svg', array('class' => 'exit', 'alt' => 'Exit'));?>
            </a>
            <div class="left">
                <div class="registerContainer">
                    <h3>Request Project Access</h3>
                    <?php
                        if (sizeof($allProjects) > sizeof($users_projects)){
                    ?>
                        <input type="hidden" id="UserProject" name="data[User][project]">
                        <div class="selectDiv" id="selected-projects">
                    <?php
                        echo "Select Project(s) to Register In *";
                    ?>
                        </div>
                    <div id="projectsDropdown" style="display: none;">
                        <?php foreach($allProjects as $p) {
                            $temp = str_replace(' ', '_', $p);
                                if (!in_array($temp, $users_projects)){
                        ?>
                                    <p id="<?php echo $p ?>"><?php echo ucwords($p) ?></p>
                        <?php }} ?>
                    </div>
                </div>
                <?php echo $this->Form->submit('Request Project Access', array('class' => 'btn btn-success', 'id' => 'request-access-submit')); ?>
                <?php }else {
                    echo "You have access to all projects";
                } ?>
            </div>
            <?php echo $this->Form->end();?>
        </div>
    </div>


<script type='text/javascript'>
    // edit user
    arcs.profileView = new arcs.views.Profile({
        el: $('#user-profile'),
        model: new arcs.models.User(<?php echo json_encode($user); ?>)
    });

    // Score bubble tooltip
    $(document).ready(function() {
        $(".score-bubble").tooltipster({
            content: $('<span>User Contributions</span><br><span><?php echo $this->Html->image("annotationsProfile.svg", array("width"=>"25px", "height"=>"25px")) . "+" . $this->Html->image("metadataProfile.svg", array("width"=>"25px", "height"=>"25px")) . "+" . $this->Html->image("discussionsProfile.svg", array("width"=>"25px", "height"=>"25px")) . "+" . $this->Html->image("timeOnSiteProfile.svg", array("width"=>"25px", "height"=>"25px")) ?></span>'),
            contentAsHTML: true,
            touchDevices: false,
            trigger: 'hover',
            position: 'right',
            theme: 'tooltipster-custom'
        });

        // initialize the annotations tab
        var currentTab = "annotations";
        $("#" + currentTab).addClass("active");
        $("#" + currentTab + "-tab").addClass("active");
        $(".tab-name").html(currentTab);

        // changing tabs click listener
        $("#user-actions .nav-tabs li a").click(function(event) {
            event.preventDefault();
            var tab = $(this).parent().attr("id");
            if (currentTab !== tab) {
                $("#" + currentTab).removeClass('active');
                $("#" + currentTab + '-tab').removeClass('active');
                $("#" + tab).addClass('active');
                $("#" + tab + '-tab').addClass('active');
                $(".tab-name").html(tab);

                if($(window).width() <= 960){
                    $("#user-actions .nav").slideToggle("slow");
                    $(".user-actions").toggleClass("active-menu");
                }

                currentTab = tab;
            }
        });

        $(".user-actions").click(function() {
            if( $("#user-actions .nav").is(':animated')){//if they spam the button
				return;
            }else{
              $("#user-actions .nav").slideToggle("slow");
              $(".user-actions").toggleClass("active-menu");
            }

        });
    });
</script>

<script type='text/javascript'>
arcs.profileView2 = new arcs.views.users.Profile({id: '<?php echo $user_info['id']; ?>'});
</script>
