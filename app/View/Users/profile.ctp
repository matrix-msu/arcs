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

//Start Edit Collections area

var allUsers = new Array;
var membersArray = new Array;

$(document).on('click', ".save-btn", function(e) {
    console.log("got to save btn function thing");
    e.stopPropagation();
    e.preventDefault();
});

$(document).ready(function() {

    $('body').on('click', ".save-btn", function(e) {
        console.log("got to save btn function thing");
        e.stopPropagation();
        e.preventDefault();
    });

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





$(".edit-btn").parent().on('click', ".edit-btn", function (e) {
    e.stopPropagation();
    e.preventDefault();

    //edit collection button click
    if( $(e.target).hasClass('edit-btn')){
        console.log("clicked edit collection");
        var el_details = $(e.target).parent().parent();
        var summary = $(e.target).parent();

        //drawer is closed. open it and end.
        if( $(el_details).hasClass("closed") ) {
            console.log("details is closed");
            summary[0].click();

        //drawer is open but there is a show all button. Click that and end.
        }else if( $(e.target).parent().nextAll(".results").children().eq(0).children().last().children().eq(0).hasClass("btn-show-all") ) {
            //console.log("edit btn click: there is a show all button");
            $(e.target).parent().nextAll(".results").children().eq(0).children().last().children().eq(0)[0].click();

        //drawer is open with loading icon
        }else if( $(e.target).parent().nextAll(".results").children().eq(0).children().last().children().eq(0).hasClass("show-all-loading-icon") ) {
            //do nothing

        //drawer is open. Add in the edit collections stuffs
        }else{
            //var el_results = $(e.target).parent().nextAll('.results');
            //console.log( el_results );
            //el_results.prepend("hello testing prepend");
            var id = $(e.target).parent().parent().data('id');
            var string = '<div class="editRadio"><input type="radio" name="'+id+'" value="1" class="not-users-radio"> Display Publicly on Site</div>';
            string += '<div class="editRadio"><input type="radio" name="'+id+'" value="2" class="not-users-radio"> Login Necessary to View</div>';
            string += '<div class="editRadio"><input type="radio" name="'+id+'" value="3" class="users-radio"> Only Selected Users can View</div>';
            string += '<div class="editRadio"><input type="radio" name="'+id+'" value="4" class="not-users-radio"> Only I can View</div>';
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

                var members = "";
                members = $(e.target).parent().parent().children().eq(0).children().eq(3).attr("data-members");
                console.log("members: " + members);
                membersArray = members.split(';');
                console.log(membersArray);

                var html4 = '<select id ="urlAuthor" data-placeholder="Search and Select Users Who Can View this Collection" multiple class="chosen-select" style="width:90%;">';
                allUsers.forEach( function(user){
                    var check = 0;
                    membersArray.forEach( function(member) {
                        if(user['id'] == member ){
                            check = 1;
                        }
                    })
                    if(check==0) {
                        html4 += '<option data-id="'+user['id']+'">'+user['name']+'</option>';
                    }
                    if(check == 1) {
                    html4 += '<option selected="selected" data-id="'+user['id']+'">'+user['name']+'</option>';
                    }
                })
                html4 += '</select>';
                //console.log("insert selected html stuff here");
                //console.log( $(e.target).parent().parent().children().next(".uploadForm").children().eq(0) );

                //fill in the select
                $(e.target).parent().parent().children().next(".uploadForm").children().eq(0).html(html4);

                /////uses the chosen.js to turn the select into a fancy thingy
                $(".chosen-select").chosen();

            });
            $(".not-users-radio").click(function (e) {
                $(e.target).parent().parent().children().next(".uploadForm").children().eq(0).html("");
            });
            if( permission == 3 ){
                console.log("selected users onload");
                //trigger a click on the selected users radio button to display the search bar
                $(e.target).parent().parent().children().eq(permission).children().eq(0).trigger("click");
            }

            //do stuff for the delete resource thumb buttons
            console.log("delete resource thumbs setup");
            console.log( $(e.target).parent().nextAll(".results").children().eq(0).children() );
            $(e.target).parent().nextAll(".results").children().eq(0).children().each(function(index, element) {
                console.log("kid:"+ $(element).attr("data-resource-kid") );
                console.log("colid:"+ $(element).attr("data-colid") );
                stringspan = '<span class="delete-resource" style="background-color:rgb(0,147,190);position:relative;float:right;top:50%;transform:translateY(-800%);width:20px;height:20px">'+
                                '<img src= "../../img/Close.svg"/></span>';
                $(element).append(stringspan);
            });
            $(".delete-resource").click(function (e) {
                console.log("clicked delete resource span");
                console.log( $(e.target).prop("tagName") );
                var deleteString = "";
                var currentDeleteString = "";

                if( $(e.target).prop("tagName") == 'IMG' ){
                    deleteString += $(e.target).parent().parent().attr("data-colid") + ";";
                    currentDeleteString = $(e.target).parent().parent().parent().parent().parent().children().eq(0).children().eq(3).attr("data-delete-resources");
                    $(e.target).parent().parent().parent().parent().parent().children().eq(0).children().eq(3).attr("data-delete-resources", currentDeleteString+deleteString);
                    $(e.target).parent().parent().remove();

                }else if( $(e.target).prop("tagName") == 'SPAN' ){
                    deleteString += $(e.target).parent().attr("data-colid") + ";";
                    currentDeleteString = $(e.target).parent().parent().parent().parent().children().eq(0).children().eq(3).attr("data-delete-resources");
                    $(e.target).parent().parent().parent().parent().children().eq(0).children().eq(3).attr("data-delete-resources", currentDeleteString+deleteString);
                    $(e.target).parent().remove();
                }
            });
            //attach the save button listener now that the edit btn is finished.
            $(".save-btn").one('click', function (e) {
                e.stopPropagation();
                e.preventDefault();
                console.log("clicked save collection btn");

                //////delete and resources that should be deleted
                console.log("delete resources");
                console.log( $(e.target).attr("data-delete-resources") );
                var deleteResourceArray = new Array;
                var deleteString = "";
                deleteString = $(e.target).attr("data-delete-resources");
                $(e.target).attr("data-delete-resources", "");
                deleteResourceArray = deleteString.split(';');
                if( deleteResourceArray[deleteResourceArray.length - 1] == "" ){
                    deleteResourceArray.pop();
                }
                console.log("delete resources array:");
                console.log(deleteResourceArray);

                ///delete each resource from the collection
                deleteResourceArray.forEach(function(index) {
                    console.log(index);
                    var formdata = {
                        id: index
                    }
                    $.ajax({
                        url: "<?php echo Router::url('/', true); ?>collections/deleteResource",
                        type: "POST",
                        data: formdata,
                        statusCode: {
                            200: function (data) {
                                console.log("Success");
                                console.log(data);
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

                //if there are no more resources in the drawer, then remove the collection from the page
                if( $(e.target).parent().nextAll('.results').children().eq(0).children().length == 0 ) {
                    $(e.target).parent().parent().remove();
                }

                //////update the permission and members for the collection
                var col_permission = $('input[name='+$(e.target).parent().parent().data('id')+']:checked').val()
                console.log(col_permission);

                //get the chosen user indexs
                var selectedUsers = [];
                $(e.target).parent().nextAll(".uploadForm").children().eq(0).children().eq(1).children().eq(0).children(".search-choice").each(function(index, element) {
                    selectedUsers.push($(element).children().eq(1).attr("data-option-array-index") );
                });
                var selectedUserIds = [];
                var stringUserIds = "";
                var count = 0;

                //get the actual id of each chosen user and put it into the string
                selectedUsers.forEach(function(index) {
                    console.log(index);
                    selectedUserIds.push($(e.target).parent().nextAll(".uploadForm").children().eq(0).children().eq(0).children().eq(index).attr("data-id") );
                    count++;
                    stringUserIds += $(e.target).parent().nextAll(".uploadForm").children().eq(0).children().eq(0).children().eq(index).attr("data-id");
                    stringUserIds += ";";
                });
                console.log(selectedUserIds);
                $(e.target).attr("data-members", stringUserIds); //update the attr data-members for next time.

                //submit collection edits
                var formdata = {
                    id: $(e.target).parent().parent().data('id'),
                    permission: col_permission,
                    viewUsers: stringUserIds
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
                            $(e.target).parent().parent().children().remove(".uploadForm");

                            console.log("got to save edit end");
                            //update the drawer's collection id
                            var newCollectionId = "";
                            newCollectionId = $(e.target).parent().next().children().eq(0).children().eq(0).attr("data-colid");
                            $(e.target).parent().parent().attr("data-id", newCollectionId);
                            //close the drawer now that save edits is done

                            $(e.target).parent().nextAll(".results").children().eq(0).children().remove(".resource-thumb");
                            $(e.target).parent()[0].click();
                            console.log("got to save edit finished");

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
        }
    }
});
</script>