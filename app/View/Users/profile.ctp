<div id="user-profile">

    <div class="row" id="user-info">
        <div>
            <div class="score-bubble"><?php echo $user_info['totalCount']; ?></div>

            <img class="profile-image thumbnail" src = "<?php echo $user_info['profileImage']; ?>">

            <dl>
                <dd>
                    <h2><?php echo $user_info['name'];?></h2>
                </dd>
                <dd>
                    <?php echo $user_info['email'];?>
                </dd>
                <dd>
                	<?php echo $user_info['username'];?></dd>
                <dd><span class="bolded">Role:</span> 
                <?php 
                    $role = $user_info['role'];
                    if ($role == 0) echo "Admin";
                    elseif ($role == 1) echo "Moderator";
                    elseif ($role == 2) echo "Researcher";
                ?>
                </dd>
                <dd><span class="bolded">Projects: </span>Polis, Isthmia, Chersonesos, Nemea</dd>
                <dd><span class="bolded">Active Since: </span><?php echo $user_info['activeSince']; ?></dd>
                <?php if ($user['id'] == $user_info['id']): ?>
                    <dd><a href="#" id="edit-profile" onclick="return false;">Edit Profile</a></dd>
                    <form method="post" enctype="multipart/form-data">
                        <dd><input type="file" name="user_image" value="Upload Profile Image" /></dd>
                        <dd><input type="submit" value="Upload Profile Image"></dd>
                    </form>
                <?php endif ?>
                <?php if ($role == 0): ?>
                    <?php 
                        $User = new User();
                        $User->id = $user_info['id'];
                        if($user_info['status'] == 'pending'){
                            $User->saveField('status', "active");
                            echo "User Confirmed";
                        }
                        ?>
                <?php endif ?>
            </dl> 
            
            <dl class="score-description-list">
            	<dd>
            		<?php echo $this->Html->image('annotationsProfile.svg', array('width'=>'35px', 'height'=>'35px')); echo $user_info['annotationsCount']; ?> <span class="description-text">Annotations Made</span>
            	</dd>
            	<dd>
            		<?php echo $this->Html->image('metadataProfile.svg', array('width'=>'35px', 'height'=>'35px')); echo $user_info['metadataCount']; ?> <span class="description-text">Metadata Edits Made</span>
            	</dd>
            	<dd>
            		<?php echo $this->Html->image('discussionsProfile.svg', array('width'=>'35px', 'height'=>'35px')); echo $user_info['commentsCount']; ?> <span class="description-text">Comments Made</span>
            	</dd>
            	<dd>
            		<?php echo $this->Html->image('timeOnSiteProfile.svg', array('width'=>'35px', 'height'=>'35px')); echo $user_info['monthsCount']; ?><span class="description-text">Months On Site</span>
            	</dd>
            </dl>
        </div>
    </div>

    <div class="row tabbable" id="user-actions">
        <ul class="nav nav-tabs">
            <li id='annotations' class=''><a href="#" onclick="changeTab('annotations'); return false;">Annotations</a></li>
            <li id='transcriptions' class=''><a href="#" onclick="changeTab('transcriptions'); return false;">Transcriptions</a></li>
            <li id='discussion' class=''><a href="#" onclick="changeTab('discussion'); return false;">Discussions</a></li>
            <li id='collections' class=''><a href="#" onclick="changeTab('collections'); return false;">Collections</a></li>
            <li id='achievements' class=''><a href="#" onclick="changeTab('achievements'); return false;">Achievements</a></li>
            <li id='activity' class=''><a href="#" onclick="changeTab('activity'); return false;">Activity</a></li>
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
    });

    // change tab
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

<script type='text/javascript'>
var activity = []; // store results for activity tab so they can be sorted by time and used

var annoReady = $.ajax({
    url: "<?php echo Router::url('/', true); ?>annotations/findallbyuser",
    type: "POST",
    data: {
        id: "<?php echo $user_info['id']; ?>"
    },
    success: function (data) {
        //console.log(data);
        // Add entries to annotations tab - split by annotations and transcriptions
        // Format - image, paragraph with span for type and span for date? Then annotation type paragraph and link?
        // Grabbing the image may take another round of ajax - save for last to put that together?
        // Oh, resource type is like that too...
        if (!data.length) {
            // currently the no annotations by this user is displayed before we do js stuff. If I change that,
            // we'll actually use this to set it up. And probably may as well, but it won't be first.
            //$("#annotations-tab").html("<h3>This user hasn't made any annotations yet</h3>");
            //$("#transcriptions-tab").html("<h3>This user hasn't made any transcriptions yet</h3>");
            // If we switch to using these at any point, we also need the ifs at the bottom to have else clauses
            // to put this in the correct spot if one is empty and the other isn't.
        }
        else {
            var contents = ""; // This is the variable we'll store our soon-to-be html in, then put it in the tab all at once
            var count = 0; // keep track of the current annotation we're on
            var tcontents = ""; // As contents, but for transcriptions
            var tcount = 0; // as count, but for transcriptions
            data.forEach(function(a) {
                if (a['transcript'] == "" || a['transcript'] === null) {
                    // add to activity array
                    activity.push({time: a['created'], type: "annotation", kid: a['resource_kid'], name: a['resource_name']});

                    // Get image and resource type
                    (function(count) {
                        $.ajax({
                            url: "<?php echo Router::url('/', true); ?>resources/viewkid/" + a['resource_kid'] + ".json",
                            type: "GET",
                            data: {
                                id: a['resource_kid']//a['page_id']
                            },
                            success: function (result) {
                                //console.log(result);
                                var thumb = result['thumb'];
                                var resType = result['type'];
                                if (resType === null) {
                                    resType = "Unknown Type";
                                }
                                var div = $("#annotations-tab .cont")[count];
                                // So that img gets src set to thumb, and .type gets html (or text?) set to resType.
                                $(div).find("img").attr('src', thumb);
                                $(div).find(".type").html(resType);
                                if (result['title'] !== null) {
                                    $(div).find("span.name").html(result['title']);
                                }
                            }
                        });
                    })(count);

                    // Stuff to get the date to the desired format, may or may not work properly just yet
                    var d = new Date(a['created']);
                    var monthNames = ["January", "February", "March", "April", "May", "June",
                      "July", "August", "September", "October", "November", "December"]; // silly nonsense to get month name
                    var date = monthNames[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear();
                    // Sort out annotation type, then determine the URL appropriately for that type
                    if (a['url'] === null || a['url'] == "") {
                        var type = "Relation";
                        var url = arcs.baseURL + "resource/" + a['relation_resource_kid']; // link to related resource page
                        var linkText = a['relation_resource_name']; // Related Resource Title
                    }
                    else {
                        type = "URL";
                        url = a['url'];
                        linkText = a['url'];
                    }
                    // And then add it all on to the end
                    contents += "<div class='cont'><div class='img'><img></div><p><span class='name'>" + a['resource_name']
                      + "</span><span class='type'>Resource Type</span><span class='date'>" + date
                      + "</span></p><p class='annotationType'>" + type + "</p><a href=" + url + ">" + linkText + "</a></div>";
                    count++;
                }
                else {
                    // add to activity array
                    activity.push({time: a['created'], type: "transcription", kid: a['resource_kid'], name: a['resource_name']});

                    // Get image and resource type
                    (function(tcount) {
                    $.ajax({
                        url: "<?php echo Router::url('/', true); ?>resources/viewkid/" + a['resource_kid'] + ".json",
                        type: "GET",
                        data: {
                            id: a['resource_kid']//a['page_id']
                        },
                        success: function (result) {
                            //console.log(result);
                            var thumb = result['thumb'];
                            var resType = result['type'];
                            if (resType === null) {
                                resType = "Unknown Type";
                            }
                            var div = $("#transcriptions-tab .cont")[tcount];
                            // So that img gets src set to thumb, and .type gets html (or text?) set to resType.
                            $(div).find("img").attr('src', thumb);
                            $(div).find(".type").html(resType);
                            if (result['title'] !== null) {
                                $(div).find("span.name").html(result['title']);
                            }
                        }
                    });
                    })(tcount);
                    // Date stuff
                    var d = new Date(a['created']);
                    var monthNames = ["January", "February", "March", "April", "May", "June",
                      "July", "August", "September", "October", "November", "December"]; // silly nonsense to get month name
                    var date = monthNames[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear();
                    // And then add it all on to the end
                    tcontents += "<div class='cont'><div class='img'><img></div><p><span class='name'>"
                      + a['resource_name'] + "</span><span class='type'>Resource Type</span><span class='date'>"
                      + date + "</span></p><p class='transcript'>" + a['transcript'] + "</p></div>";
                    tcount++;
                }
            });
            if (!contents == "") {
                $("#annotations-tab").html(contents);
            }
            if (!tcontents == "") {
                $("#transcriptions-tab").html(tcontents);
            }
        }
    }
});

$.ajax({
    url: "<?php echo Router::url('/', true); ?>comments/findallbyuser",
    type: "POST",
    data: {
        id: "<?php echo $user_info['id']; ?>"
    },
    success: function (data) {
        //console.log(data);
        if (!data.length) {
            $("#discussion-tab").html("<h3>No discussion items</h3>");
        }
        else {
            var contents = "";
            var count = 0;
            //Get image, resource type, and resource title
            data.forEach(function(a) {
                (function(count) {
                $.ajax({
                    url: "<?php echo Router::url('/', true); ?>resources/viewkid/" + a['resource_kid'] + ".json",
                    type: "GET",
                    data: {
                        id: a['resource_kid']
                    },
                    success: function (result) {
                        var thumb = result['thumb'];
                        var resType = result['type'];
                        if (resType === null) {
                            resType = "Unknown Type";
                        }
                        var div = $("#discussion-tab .cont")[count];
                        // So that img gets src set to thumb, and .type gets html (or text?) set to resType.
                        $(div).find("img").attr('src', thumb);
                        $(div).find(".type").html(resType);
                        if (result['title'] !== null) {
                            $(div).find("span.name").html(result['title']);
                        }
                    }
                });
                })(count);
                // Stuff to get the date to the desired format
                var d = new Date(a['created']);
                var monthNames = ["January", "February", "March", "April", "May", "June",
                  "July", "August", "September", "October", "November", "December"]; // silly nonsense to get month name
                var date = monthNames[d.getMonth()] + " " + d.getDate() + ", " + d.getFullYear();
                // And add it all on
                contents += "<div class='cont'><div class='img'><img></div><p><span class='name'>Resource Name</span>" +
                  "<span class='type'>Resource Type</span><span class='date'>" + date + "</span></p><p class='transcript'>"
                  + a['content'] + "</p></div>";
                count++;
            });
            $("#discussion-tab").html(contents);
        }
    }
});

// Either thumb and resource name (and anything else like that) is gotten after the activity array is completed and sorted
// or we need to adjust these functions so they don't return the deferred object until the inner ajax needed to get that
// information is completed. Or look more at deferred objects and see if there's a way to get them to do that readily.

var flagsReady = $.ajax({
    url: "<?php echo Router::url('/', true); ?>flags/findallbyuser",
    type: "POST",
    data: {
        id: "<?php echo $user_info['id']; ?>"
    },
    success: function(data) {
        data.forEach(function(flag) {
            activity.push({time: flag['created'], type: "flag", kid: flag['resource_kid'], name: flag['resource_name']});
        });
    }
});

var usersReady = $.ajax({
    url: "<?php echo Router::url('/', true); ?>users/findbyid",
    type: "POST",
    data: {
        id: "<?php echo $user_info['id']; ?>"
    },
    success: function(data) {
        activity.push({time: data['last_login'], type: "login"});
        // Note the data also has a list of collections created by the user, date included
    }
});

$.ajax({
    url: "<?php echo Router::url('/', true); ?>collections/findallbyuser",
    type: "POST",
    data: {
        id: "<?php echo $user_info['id']; ?>"
    },
    success: function(data) {
    }
});

// once the activity array is loaded, sort by most recent first and process
$.when(usersReady, flagsReady, annoReady).then(function() {
    activity.sort(function(a, b) {
        var dateA = new Date(a.time);
        var dateB = new Date(b.time);
        return dateB - dateA;
    });
    console.log(activity);
    // pagination might happen here, or after, but build the html for the tab and get the images and such as needed
});
</script>