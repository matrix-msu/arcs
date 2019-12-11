//Start Edit Collections area

var allUsers = new Array;
var membersArray = new Array;

$(document).on('click', ".save-btn", function(e) {
    e.stopPropagation();
    e.preventDefault();
});

$(document).ready(function() {
    $('body').on('click', ".save-btn", function(e) {
        e.stopPropagation();
        e.preventDefault();
    });

    $.ajax({
        url: arcs.baseURL + "users/getAllUsers",
        type: "POST",
        statusCode: {
            200: function (data) {
                allUsers = data;
            }
        }
    });

    $(document).on('click', ".edit-btn", function (e) {
        e.stopPropagation();
        e.preventDefault();
        //edit collection button click
        if( $(e.target).hasClass('edit-btn')){
            var el_details = $(e.target).parent().parent();
            var summary = $(e.target).parent();

            //drawer is closed. open it and end.
            if( $(el_details).hasClass("closed") ) {
                summary[0].click();
                //drawer is open but there is a show all button. Click that and end.
            }
            //drawer is open with loading icon
            else if(
                $(e.target).parent().nextAll(".results").children().eq(0)
                    .children().last().children().eq(0).hasClass("show-all-loading-icon")
            ) {
                //do nothing
            }else{
                //drawer is open. Add in the edit collections stuffs
                var id = $(e.target).parent().parent().data('id');
                var string = '<div class="editRadio" style="margin-left:20px"><input type="radio" name="'+id+'" value="1" class="not-users-radio"><p class="radioLabel"> Display Publicly on Site</p></div>';
                string += '<div class="editRadio"><input type="radio" name="'+id+'" value="2" class="not-users-radio"><p class="radioLabel"> Login Necessary to View</p></div>';
                string += '<div class="editRadio"><input type="radio" name="'+id+'" value="3" class="users-radio"><p class="radioLabel"> Only Selected Users can View</p></div>';
                string += '<div class="editRadio"><input type="radio" name="'+id+'" value="4" class="not-users-radio"><p class="radioLabel"> Only I can View</p></div>';
                string += '<form class="uploadForm" id="urlform" method="post" enctype="multipart/form-data">';
                string += '<fieldset class="users-fieldset"></fieldset>';
                string += '</form>';
                summary.after(string);
                $(e.target).text("SAVE EDITS MADE");
                $(e.target).removeClass("edit-btn");
                $(e.target).addClass("save-btn");
                var permission =  $(e.target).attr("data-permission");
                $(e.target).parent().parent().children().eq(permission).children().eq(0).prop('checked', true);

                //attach the selected user radio button click listener
                $(".users-radio").click(function (e) {
                    var members = "";
                    members = $(e.target).parent().parent().children().eq(0).children().eq(3).attr("data-members");
                    membersArray = members.split(';');

                    var html4 = '<select id ="urlAuthor" data-placeholder="Search and Select Users Who Can View this Collection" multiple class="chosen-select" style="width:90%;">';
                    allUsers.forEach( function(user){
                        var check = 0;
                        membersArray.forEach( function(member) {
                            if(user['id'] == member ){
                                check = 1;
                            }
                        })
                        if(check==0) {
                            html4 += '<option data-id="'+user['id']+'">'+user['name']+'  ('+user['username']+')</option>';
                        }
                        if(check == 1) {
                            html4 += '<option selected="selected" data-id="'+user['id']+'">'+user['name']+'  ('+user['username']+')</option>';
                        }
                    })
                    html4 += '</select>';

                    //fill in the select
                    $(e.target).parent().parent().children().next(".uploadForm").children().eq(0).html(html4);

                    /////uses the chosen.js to turn the select into a fancy thingy
                    $(".chosen-select").chosen();

                });
                $(".radioLabel").click(function (e) {
                    $(e.target).prev().trigger("click");
                });

                $(".not-users-radio").click(function (e) {
                    $(e.target).parent().parent().children().next(".uploadForm").children().eq(0).html("");
                });
                if( permission == 3 ){
                    //trigger a click on the selected users radio button to display the search bar
                    $(e.target).parent().parent().children().eq(permission).children().eq(0).trigger("click");
                }

                //do stuff for the delete resource thumb buttons
                $(e.target).parent().nextAll(".results").children().eq(0).children().each(function(index, element) {
                    stringspan = '<span class="delete-resource">'+
                        '<img src="/' +BASE_URL+ 'img/Close.svg"/></span>';
                    $(element).append(stringspan);
                });
                $(".delete-resource").click(function (e) {
                    var deleteString = "";
                    var currentDeleteString = "";
                    deleteString += $(e.target).closest('li').attr("data-colid") + ";";
                    currentDeleteString = $(e.target).closest('details').find('h4.save-btn').attr("data-delete-resources");
                    $(e.target).closest('details').find('h4.save-btn').attr("data-delete-resources", currentDeleteString+deleteString);
                    $(e.target).closest('li').remove();

                    console.log($(e.target).closest('li'));
                    console.log('delete', deleteString);
                    console.log('current', currentDeleteString);
                    // currentDeleteString = $(e.target).closest('details').children().eq(0).children().eq(3).attr("data-delete-resources", currentDeleteString+deleteString);
                    // if( $(e.target).prop("tagName") == 'IMG' ){
                    //     deleteString += $(e.target).parent().parent().attr("data-colid") + ";";
                    //     currentDeleteString = $(e.target).parent().parent().parent().parent().parent().children().eq(0).children().eq(3).attr("data-delete-resources");
                    //                           $(e.target).parent().parent().parent().parent().parent().children().eq(0).children().eq(3).attr("data-delete-resources", currentDeleteString+deleteString);
                    //     $(e.target).parent().parent().remove();
                    //
                    // }else if( $(e.target).prop("tagName") == 'SPAN' ){
                    //     deleteString += $(e.target).parent().attr("data-colid") + ";";
                    //     currentDeleteString = $(e.target).parent().parent().parent().parent().children().eq(0).children().eq(3).attr("data-delete-resources");
                    //     $(e.target).parent().parent().parent().parent().children().eq(0).children().eq(3).attr("data-delete-resources", currentDeleteString+deleteString);
                    //     $(e.target).parent().remove();
                    // }
                });
                //attach the save button listener now that the edit btn is finished.
                $(".save-btn").one('click', function (e) {
                    e.stopPropagation();
                    e.preventDefault();

                    //////delete and resources that should be deleted
                    var deleteResourceArray = new Array;
                    var deleteString = "";
                    deleteString = $(e.target).attr("data-delete-resources");
                    $(e.target).attr("data-delete-resources", "");
                    deleteResourceArray = deleteString.split(';');
                    if( deleteResourceArray[deleteResourceArray.length - 1] == "" ){
                        deleteResourceArray.pop();
                    }

                    ///delete each resource from the collection
                    deleteResourceArray.forEach(function(index) {
                        var formdata = {
                            id: index
                        }
                        console.log(formdata);
                        $.ajax({
                            url: arcs.baseURL +"collections/deleteResource",
                            type: "POST",
                            data: formdata,
                            statusCode: {
                                200: function (data) {
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
                        selectedUserIds.push($(e.target).parent().nextAll(".uploadForm").children().eq(0).children().eq(0).children().eq(index).attr("data-id") );
                        count++;
                        stringUserIds += $(e.target).parent().nextAll(".uploadForm").children().eq(0).children().eq(0).children().eq(index).attr("data-id");
                        stringUserIds += ";";
                    });
                    $(e.target).attr("data-members", stringUserIds); //update the attr data-members for next time.

                    //submit collection edits
                    var formdata = {
                        id: $(e.target).parent().parent().data('id'),
                        permission: col_permission,
                        viewUsers: stringUserIds
                    }
                    $.ajax({
                        url: arcs.baseURL + "collections/editCollection",
                        type: "POST",
                        data: formdata,
                        statusCode: {
                            200: function (data) {
                                $(e.target).attr("data-permission", col_permission);
                                $(e.target).text("EDIT COLLECTION");
                                $(e.target).removeClass("save-btn");
                                $(e.target).addClass("edit-btn");
                                $(e.target).parent().parent().children().remove(".editRadio");
                                $(e.target).parent().parent().children().remove(".uploadForm");

                                //close the drawer now that save edits is done
                                $(e.target).parent().nextAll(".results").children().eq(0).children().remove(".resource-thumb");
                                $(e.target).parent()[0].click();
                            }
                        }
                    });
                });
            }
        }
    });
});
