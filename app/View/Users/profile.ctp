<script src="<?php echo Router::url('/', true); ?>js/vendor/chosen.jquery.js"></script>

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
arcs.profileView = new arcs.views.users.Profile({id: '<?php echo $user_info['id']; ?>'});

var allUsers = new Array;
$(document).ready(function() {
    $.ajax({
        url: "<?php echo Router::url('/', true); ?>users/getAllUsers",
        type: "POST",
        //data: formdata,
        statusCode: {
            200: function (data) {
                //console.log("Success");
                //console.log(data);
                //console.log("got all users here");
                //console.log(data);
                allUsers = data;
                //console.log(allUsers);

            },
            400: function () {
                console.log("Bad Request");
            },
            405: function () {
                console.log("Method Not Allowed");
            }
        }
    });
});

$(".edit-btn").click(function (e) {
    e.stopPropagation();
    e.preventDefault();
    if( $(e.target).hasClass('edit-btn')){
        console.log("clicked edit collection");
        var el_details = $(e.target).parent().parent();
        var summary = $(e.target).parent();
        if( $(el_details).hasClass("closed") ) {
            console.log("details is closed");
            summary[0].click();
        }else{
            //var el_results = $(e.target).parent().nextAll('.results');
            //console.log( el_results );
            //el_results.prepend("hello testing prepend");
            var id = $(e.target).parent().parent().data('id');
            var string = '<div class="editRadio"><input type="radio" name="'+id+'" value="1"> Display Publicly on Site</div>';
            string += '<div class="editRadio"><input type="radio" name="'+id+'" value="2"> Login Necessary to View</div>';
            string += '<div class="editRadio"><input type="radio" name="'+id+'" value="3" class="users-radio"> Only Selected Users can View</div>';
            string += '<div class="editRadio"><input type="radio" name="'+id+'" value="4"> Only I can View</div>';
            string += '<form class="uploadForm" id="urlform" method="post" enctype="multipart/form-data">';
            string += '<fieldset class="users-fieldset"></fieldset>';
            string += '</form>';
            summary.after(string);
            $(e.target).text("SAVE EDITS MADE");
            $(e.target).removeClass("edit-btn");
            $(e.target).addClass("save-btn");
            var permission =  $(e.target).attr("data-permission");
            //console.log("radio button");
            //console.log($(e.target).parent().parent().children().eq(permission).children().eq(0));
            $(e.target).parent().parent().children().eq(permission).children().eq(0).prop('checked', true);

            //attach the selected user radio button click listener
            $(".users-radio").click(function (e) {
                console.log("selected users click");
                //e.stopPropagation();
                //e.preventDefault();
                var html = '<div id="collections-filter" class="dropdown">'+
                              '<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Filter By'+
                              '<span class="pointerDown filter-arrow"></span></button>'+
                              '<ul class="dropdown-menu">'+
                                '<li><a id="new-old" href="#">Newest to Oldest</a></li>'+
                                '<li><a id="old-new" href="#">Oldest to Newest</a></li>'+
                                '<li><a id="popular" href="#">Most Popular</a></li>'+
                                '<li class="dropdown-submenu"><a id="author" class="author-arrow-toggle" href="#">Author'+
                            			'<span class="pointerDown author-arrow" style="position:static"></span></a>'+
                            		'<ul class="dropdown-menu" id="author-dropdown" style="left:100%;margin-top:-25px;">'+
                            			'<li><a class="author-filter" href="#">No Authors Available</a></li>'+
                            		'</ul>'+
                            	'</li>'+
                                '<li><a id="a-z" href="#">A-Z</a></li>'+
                                '<li><a id="z-a" href="#">Z-A</a></li>'+
                              '</ul>'+
                            '</div>';
                var html2 = '<div id="collections-filter" class="dropdown">'+
                              '<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Filter By'+
                              '<span class="pointerDown filter-arrow"></span></button>'+
                              '<ul class="dropdown-menu">';
                var html3 = '<div class="chosen-container chosen-container-multi" style="width: 178px;" title="" id="urlAuthor_chosen">'+
                             		'<ul class="chosen-choices ui-sortable">'+
                             		'<li class="search-field ui-sortable-handle">'+
                             		    '<input type="text" value="SEARCH / SELECT AUTHORS" class="" autocomplete="off" style="width: 258px;margin-left:auto;">'+
                             		'</li>'+
                             		'</ul>'+
                                    '<div class="chosen-drop">'+
                                        '<ul class="chosen-results">';
                var html4 = '<select id ="urlAuthor" data-placeholder="Search and Select Users Who Can View this Collection" multiple class="chosen-select" style="width:90%;">';
                allUsers.forEach( function(user){
                    html3 += '<li class="active-result">'+user['name']+'</li>';
                    html4 += '<option>'+user['name']+'</option>';
                })
                html3 +=        '</ul>'+
                            '</div>'+
                          '</div>';
                html4 += '</select>';
                console.log("insert selected html stuff here");
                console.log( $(e.target).parent().parent().children().next(".uploadForm").children().eq(0) );
                //fill in the select
                $(e.target).parent().parent().children().next(".uploadForm").children().eq(0).html(html4);

                /////uses the choses.js to turn the select into a fancy thingy
                $(".chosen-select").chosen();

            });
            if( permission == 3 ){
                console.log("selected users onload");
                //trigger a click on the selected users radio button to display the search bar
                $(e.target).parent().parent().children().eq(permission).children().eq(0).trigger("click");
            }
        }
    }else if( $(e.target).hasClass('save-btn') ){
        console.log("clicked save collection btn");
        var col_permission = $('input[name='+$(e.target).parent().parent().data('id')+']:checked').val()
        console.log(col_permission);
        var formdata = {
            id: $(e.target).parent().parent().data('id'),
            permission: col_permission
        }
        $.ajax({
            url: "<?php echo Router::url('/', true); ?>collections/editCollection",
            type: "POST",
            data: formdata,
            statusCode: {
                200: function (data) {
                    //console.log("Success");
                    //console.log(data);
                    $(e.target).attr("data-permission", col_permission);
                    $(e.target).text("EDIT COLLECTION");
                    $(e.target).removeClass("save-btn");
                    $(e.target).addClass("edit-btn");
                    $(e.target).parent().parent().children().remove(".editRadio");

                },
                400: function () {
                    console.log("Bad Request");
                },
                405: function () {
                    console.log("Method Not Allowed");
                }
            }
        });
    }
});
</script>