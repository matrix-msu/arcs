<script src="<?php echo Router::url('/', true); ?>js/vendor/chosen.jquery.js"></script>

<div id="user-profile">

    <div class="row" id="user-info">
        <div>
            <div class="score-bubble">
                <?php
                    if( $user_info['username'] == 'noah.girard' ){
                        echo '<p style="width: 68px;font-size: 14px;line-height: 15px;padding-top: 18px;font-weight:bold">
                                Nothing. You suck.
                              </p>';
                    }else{
                        echo $user_info['totalCount'];
                    }
                ?>
            </div>

            <div class="profile-image-container">
              <img class="profile-image thumbnail" src = "<?php echo $user_info['profileImage']; ?>">
            </div>

            <dl class="user-project-info">
                <dd>
                    <h2><?php echo $user_info['name'];?></h2>
                </dd>
                <dd>
                    <?php echo $user_info['email'];?>
                </dd>
                <dd>
                	<?php echo $user_info['username'];?>
                </dd>
                <dd>
                    <?php
                    $projects = array();
                    foreach($user_info['mappings'] as $mapping) {
                        $projectString = ucwords(str_replace('_', ' ', $mapping['project']));
                        $string = '<span class="bolded">'.$projectString.'</span>: '.$mapping['role'];
                        $projects[] = $string;
                    }
                    echo implode(',<br /> ', $projects);
                    ?>
                </dd>
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
            		<?php echo $this->Html->image('annotationsProfile.svg', array('width'=>'35px', 'height'=>'35px'));
                    echo $user_info['annotationsCount']; ?> <span class="description-text">Annotations Made</span>
            	</dd>
            	<dd>
            		<?php echo $this->Html->image('metadataProfile.svg', array('width'=>'35px', 'height'=>'35px'));
                    echo $user_info['metadataCount']; ?> <span class="description-text">Metadata Edits Made</span>
            	</dd>
            	<dd>
            		<?php echo $this->Html->image('discussionsProfile.svg', array('width'=>'35px', 'height'=>'35px'));
                    echo $user_info['commentsCount']; ?> <span class="description-text">Comments Made</span>
            	</dd>
            	<dd>
            		<?php echo $this->Html->image('timeOnSiteProfile.svg', array('width'=>'35px', 'height'=>'35px'));
                    echo $user_info['monthsCount']; ?><span class="description-text">Months On Site</span>
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
            <li id='achievements' class=''>
                <a href="#">Achievements</a>
            </li>
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
            <?php echo $this->element('tabs/achievements-tab') ?>
            <?php echo $this->element('tabs/activity-tab') ?>
        </div>
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

<script type="text/javascript">
    $('.createThumbnails').click(function(){
        var project = $(this).attr('data-project');
        window.location.href = arcs.baseURL+'admin/createthumbnails/'+project;
    });
</script>
