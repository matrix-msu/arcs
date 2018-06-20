console.log("outside of it");
function keywordPrep(){
    console.log('at top');

	var keywordArray = []; //an array of the edited keywords
	var keywordOriginalArray = []; //keep an array of the stored keywords
	var keywordPageKid; //keep of the editing page kid
	var keywordProjectKid; //keep of the editing project kid
    var deletingKeywords = 0; //currently deleting keywords=1
    var addingKeywords = 0; //currently adding keywords=1

    Array.prototype.diff = function(a) {
        return this.filter(function(i) {return a.indexOf(i) < 0;});
    };
    $('.page-slider').on('click', '.other-resource', function() {
        var pageKid = $(this).attr('id');
        $("#urlform").css('display','none');
        getKeywords(pageKid, 0);
        $(".keyword-save-btn").removeClass("keyword-save-btn")
            .html("EDIT")
            .addClass("keyword-edit-btn")
            .css("color", '')
            .attr('id', 'keyword-edit-btn');
    });
    $(".level-tab").click(function (e) {
		if ( $(this).find('#keyword-save-btn').length >0 ) { //save the keywords
            e.stopPropagation();
            var deleteArray = keywordOriginalArray.diff( keywordArray ); //delete these
            var addArray = keywordArray.diff( keywordOriginalArray ); //add these keywords
            if( deleteArray.length > 0 ){
                deletingKeywords = 1;
                deleteKeywords(deleteArray);
            }
            if( addArray.length > 0 ){
                addingKeywords = 1;
                addKeywords(addArray);
            }
        }else if( $(this).find('#keyword-edit-btn').length >0 ) { //edit keyword was pressed. Handled above
            return;
        }else if (e.target.getAttribute("aria-expanded") == 'true') { //drawer pressed but open
            return;
        }else if ( //close keyword drawer by from other tab click
                    $(this).parents('#tabs-2').length > 0 &&
                    e.target.getAttribute("aria-expanded") == 'false' &&
                    $('#keyword-tab')[0].getAttribute("aria-expanded") == 'true'
                ) {
                    saveBackToEdit();
		}
    });
    function saveBackToEdit(){
        $("#urlform").css('display','none');
        var pageKid = $('.selectedCurrentPage').find('img').attr('id');
        getKeywords(pageKid, 0);
        $(".keyword-save-btn").removeClass("keyword-save-btn")
            .html("EDIT")
            .addClass("keyword-edit-btn")
            .css("color", '')
            .attr('id', 'keyword-edit-btn');
    }
    $('#keyword-edit-btn').click(function(e){ //edit keywords pressed.
        if($(this).attr('id') == 'keyword-edit-btn') {
            e.stopPropagation();
            $(this).parent().click();
            $(this).attr('id', 'keyword-save-btn')
                .attr('class', 'keyword-save-btn')
                .html('SAVE')
                .css("color", 'rgb(0, 147, 190)');
            $('#keyword-search-links').html('');
            var pageKid = $('.selectedCurrentPage').find('img').attr('id');
            getKeywords(pageKid, 1);
            //setTimeout(function () {
            //    getKeywords($('.page-slider').find('.other-resource').eq(0).attr('id'), 1);
            //}, 25);
        }
    });
	$(".details").one("click", function () { //details tab first click. load keywords
        getKeywords($('.page-slider').find('.other-resource').eq(0).attr('id'), 0);
    });
    function addDeleteListener(){ //must add the delete listener everytime a new keyword is added.
        //delete with a click
        $(".search-choice-close").one('click', function (e) {
            var keyword = $(e.target).prev().html();
            //delete the keyword from array
            var index = keywordArray.indexOf(keyword);
            if (index > -1) {
                keywordArray.splice(index, 1);
            }
        });
    }
    function addKeywords(addArray){
        var rkid = $("#"+keywordPageKid).parent().attr('id');
        console.log("rkid");
        $.ajax({
            url: arcs.baseURL + "keywords/add",
            type: "POST",
            data: {
                page_kid: keywordPageKid,
                project_kid: keywordProjectKid,
                keywords: addArray,
                resource_kid: rkid
            },
            success: function (data) {
                //update search links
                addingKeywords = 0;
                if( addingKeywords == 0 && deletingKeywords == 0) {
                    saveBackToEdit();
                }
            }
        });
    }
    function deleteKeywords(deleteArray){
        console.log('oh hello');
        $.ajax({
            url: arcs.baseURL + "keywords/deleteKeyword",
            type: "POST",
            data: {
                page_kid: keywordPageKid,
                project_kid: keywordProjectKid,
                keywords: deleteArray
            },
            success: function (data) {
                //update search links
                deletingKeywords = 0;
                if( addingKeywords == 0 && deletingKeywords == 0) {
                    saveBackToEdit();
                }
            }
        });
    }
    function getCommonKeywords(){
        //project_kid does not support multi-projects. Change here if that is needed-
        keywordProjectKid = $('.resource-slider').find('.other-resources').eq(0).attr('data-projectKid');
        //get the common keywords for the current project and update the chosen select thing
        var html5 = '<fieldset class="users-fieldset">';
        html5 += '<select id ="urlAuthor2" data-placeholder="Keywords" multiple class="chosen-select2" style="width:90%;">';
        $.ajax({
            url: arcs.baseURL + "keywords/common",
            type: "POST",
            data: {
                project_kid: keywordProjectKid
            },
            success: function (data) {
                var commonKeywordArray = data;

                if( commonKeywordArray instanceof Array ) {
                    commonKeywordArray.forEach(function (keyword) {
                        html5 += '<option selected="selected" data-id="' + keyword + '">' + keyword + '</option>';
                    })
                }
                html5 += '</select></fieldset>';

                //fill in the select
                $("#urlform2").css('display', 'block');
                $("#urlform2").html(html5);

                /////uses the chosen.js to turn the select into a fancy thingy
                $(".chosen-select2").chosen();

                //add a keyword by the common keyword list
                $('.search-choice').on('click', function(e) {
                    var id = $(this).text();
                    var alreadyExists = keywordArray.indexOf( id );
                    if( alreadyExists != -1 ){
                        alert("You can only add a keyword once.");
                        return;
                    }
                    keywordArray.push( id );
                    $("#urlAuthor").append( '<option selected="selected" data-id="'+id+'">'+id+'</option>');
                    $(".chosen-select").trigger("chosen:updated");
                    addDeleteListener();
                });
            }
        })
    }
	//get the keywords a page is associated to. How it is displayed is based on edit.
    function getKeywords(pageKid, edit=0) {
        var html4 = '<fieldset class="users-fieldset">';
        html4 += '<select id ="urlAuthor" data-placeholder="Keywords" multiple class="chosen-select" style="width:90%;">';

        keywordPageKid = pageKid;

        $.ajax({
            url: arcs.baseURL + "keywords/get",
            type: "POST",
            data: {
                page_kid: keywordPageKid
            },
            success: function (data) {
                keywordArray = data;
                keywordOriginalArray = keywordArray.slice();

                if (edit == 0) { //display the keywords as search links
                    $('#keyword-text').html('Click on the keyword links below to search for other resources with the same keyword.');
                    $('#keyword-common').css('display', 'none');
                    $('#urlform2').css('display', 'none');
                    $('#urlform').find('.chosen-choices').html();
                    $('#urlform').css('display', 'none');
                    var pName = $('#project1').find("[id='Persistent_Name']").html();
                    pName = pName.replace(/ /g, '_').toLowerCase();
                    var keywordHtml = '';
                    if (keywordArray instanceof Array) {
                        var check = 0;
                        keywordArray.forEach(function (keyword) {
                            keywordHtml += '<a href="' + arcs.baseURL + 'search/' + pName + '/' + keyword + '" style="display:inline-block;margin-right:5px;color:#0093be;text-decoration: underline;">' +
                                keyword +
                                '</a>';
                            check = 1;
                        })
                        if( check == 0 ){
                            $('#keyword-text').html('There are no keywords associated with this page.');
                        }else{
                            $('#keyword-text').html('Click on the keyword links below to search for other resources with the same keyword.');
                        }
                    }
                    $('#keyword-search-links').html(keywordHtml);
                } else { //display the keywords as editing
                    $('#keyword-text').html('Enter keywords below. Use commas to separate keywords.');
                    $('#keyword-common').css('display', 'block');
                    //use the chosen select thing for editing.
                    if (keywordArray instanceof Array) {
                        keywordArray.forEach(function (keyword) {
                            html4 += '<option selected="selected" data-id="' + keyword + '">' + keyword + '</option>';
                        })
                    }
                    html4 += '</select></fieldset>';

                    //fill in the select
					$("#urlform").css('display','block');
                    $("#urlform").html(html4);

                    /////uses the chosen.js to turn the select into a fancy thingy
                    $(".chosen-select").chosen();
                    addDeleteListener();

                    //add new keyword with a comma
                    $(".search-field").on('keyup', "input", function (e) {
                        var id = $(this).val();
                        if ((id == "" || id == ',') && e.key == 'Backspace') {
                            //backspace will do nothing if no keyword

                        } else if (e.key == ',') {
                            id = id.substring(0, id.length - 1);  //remove comma
                            if (id == '') { //keyword is empty, so ignore.
                                $(this).val('');
                                return;
                            }
                            var alreadyExists = keywordArray.indexOf(id);
                            if (alreadyExists != -1) {
                                $(this).val('')
                                alert("You can only add a keyword once.");
                                return;
                            }
                            keywordArray.push(id);

                            $("#urlAuthor").append('<option selected="selected" data-id="' + id + '">' + id + '</option>');
                            $(".chosen-select").trigger("chosen:updated");
                            addDeleteListener();
                        }
                    });
                }
            }
        });
        if( edit != 0){
            getCommonKeywords();
        }
    }
}

$(document).ready(keywordPrep);
