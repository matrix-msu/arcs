$(document).ready(function(){
	
	var keywordArray = [];
	
	$('#keyword-edit-btn').click(function(e){
		e.stopPropagation();
		$(this).parent().click();
		$(this).attr('id', 'keyword-save-btn')
			.attr('class', 'save-btn')
			.html('SAVE')
			.css("color",'rgb(0, 147, 190)');
		$('#keyword-search-links').html('');
		setTimeout(function(){
			getKeywords($('.page-slider').find('.other-resource').eq(0).attr('id'), 1);
		},25);
    });
    $(".level-tab").click(function (e) {
		if (e.target.getAttribute("class") == 'save-btn') {
            console.log("keywords level tab save btn click");
            e.stopPropagation();
            
        }else if( $(this).find('#keyword-edit-btn').length >0 ){
			return;
        }else if (e.target.getAttribute("aria-expanded") == 'true') {
            return;
        }else{
			$("#urlform").css('display','none');
			getKeywords($('.page-slider').find('.other-resource').eq(0).attr('id'), 0);
			$(".save-btn").removeClass("save-btn")
				.html("EDIT")
				.addClass("edit-btn")
				.css("color", '')
				.attr('id', 'keyword-edit-btn');
		}
    });
	$(".details").click(function () {
        getKeywords($('.page-slider').find('.other-resource').eq(0).attr('id'), 0);
		console.log(keywordArray);
    });

	//get the keywords a page is associated to. How it is displayed is based on edit.
    function getKeywords(pageKid, edit=0) {
        var html4 = '<fieldset class="users-fieldset">';
        html4 += '<select id ="urlAuthor" data-placeholder="Keywords" multiple class="chosen-select" style="width:90%;">';

        var PAGE_KID = pageKid;
        //project_kid does not support multi-projects. Change here if that is needed-
        var PROJECT_KID = $('.resource-slider').find('.other-resources').eq(0).attr('data-projectKid');

        $.ajax({
            url: arcs.baseURL + "keywords/get",
            type: "POST",
            data: {
                page_kid: PAGE_KID
            },
            success: function (data) {
                keywordArray = data;

                if (edit == 0) { //display the keywords as search links
                    var pName = $('#project1').find("[id='Persistent Name']").html();
                    pName = pName.replace(/ /g, '_').toLowerCase();
                    var keywordHtml = '';
                    if (keywordArray instanceof Array) {
                        keywordArray.forEach(function (keyword) {
                            keywordHtml += '<a href="' + arcs.baseURL + 'search/' + pName + '/' + keyword + '" style="display:inline-block;margin-right:5px;color:#0093be;text-decoration: underline;">' +
                                keyword +
                                '</a>';
                        })
                    }
                    $('#keyword-search-links').html(keywordHtml);
                } else { //display the keywords as editing
					//use the chosen select thing for editing.
                    if (keywordArray instanceof Array) {
                        keywordArray.forEach(function (keyword) {
                            //html4 += '<option data-id="'+keyword+'">'+keyword+'</option>';
                            html4 += '<option selected="selected" data-id="' + keyword + '">' + keyword + '</option>';
                        })
                    }
                    html4 += '</select></fieldset>';

                    //fill in the select
					$("#urlform").css('display','block');
                    $("#urlform").html(html4);

                    /////uses the chosen.js to turn the select into a fancy thingy
                    $(".chosen-select").chosen();

                    //add new keyword with a comma
                    $(".search-field").on('keyup', "input", function (e) {
                        var id = $(this).val();
                        if ((id == "" || id == ',') && e.key == 'Backspace') {
                            //$(".chosen-select").trigger("chosen:updated");

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
                            //pageIndex = $(".selectedResource").text().replace(/^\s+|\s+$/g, '') - 1;
                            keywordArray.push(id);
                            $.ajax({
                                url: arcs.baseURL + "keywords/add",
                                type: "POST",
                                data: {
                                    //resource_id: resourceKid,
                                    page_kid: PAGE_KID,
                                    project_kid: PROJECT_KID,
                                    keyword: id
                                },
                                success: function (data) {
                                    $("#urlAuthor").append('<option selected="selected" data-id="' + id + '">' + id + '</option>');
                                    $(".chosen-select").trigger("chosen:updated");
                                    //delete with a click
                                    $(".search-choice-close").one('click', function (e) {
                                        $.ajax({
                                            url: arcs.baseURL + "keywords/deleteKeyword",
                                            type: "POST",
                                            data: {
                                                page_kid: PAGE_KID,
                                                project_kid: PROJECT_KID,
                                                keyword: $(e.target).prev().html()
                                            },
                                            success: function (data) {
                                                //console.log("keyword delete ajax success");
                                            }
                                        })
                                    });
                                }
                            })

                        }
                    });

                    //delete with a click
                    $(".search-choice-close").one('click', function (e) {
                        $.ajax({
                            url: arcs.baseURL + "keywords/deleteKeyword",
                            type: "POST",
                            data: {
                                page_kid: PAGE_KID,
                                project_kid: PROJECT_KID,
                                keyword: $(e.target).prev().html()
                            },
                            success: function (data) {
                                //console.log("keyword delete ajax success");
                            }
                        })
                    });
                }
            }
        })

        //get the common keywords for the current project and update the chosen select thing

        var html5 = '<fieldset class="users-fieldset">';
        html5 += '<select id ="urlAuthor2" data-placeholder="Keywords" multiple class="chosen-select2" style="width:90%;">';

        $.ajax({
            url: arcs.baseURL + "keywords/common",
            type: "POST",
            data: {
                project_kid: PROJECT_KID
            },
            success: function (data) {
                //console.log("common keyword ajax success");
                //console.log(data);

                var commonKeywordArray = data;

                if( commonKeywordArray instanceof Array ) {
                    commonKeywordArray.forEach(function (keyword) {
                        //html5 += '<option data-id="'+keyword+'">'+keyword+'</option>';
                        html5 += '<option selected="selected" data-id="' + keyword + '">' + keyword + '</option>';
                    })
                }
                html5 += '</select></fieldset>';

                //fill in the select
                $("#urlform2").html(html5);

                /////uses the chosen.js to turn the select into a fancy thingy
                $(".chosen-select2").chosen();

                //add a common keyword
                $('.search-choice').on('click', function(e) {
                    var id = $(this).text();
                    var alreadyExists = keywordArray.indexOf( id );
                    if( alreadyExists != -1 ){
                        alert("You can only add a keyword once.");
                        return;
                    }
                    keywordArray.push( id );
                    $.ajax({
                        url: arcs.baseURL + "keywords/add",
                        type: "POST",
                        data: {
                            //resource_id: resourceKid,
                            page_kid: PAGE_KID,
                            project_kid: PROJECT_KID,
                            keyword: id
                        },
                        success: function (data) {
                            $("#urlAuthor").append( '<option selected="selected" data-id="'+id+'">'+id+'</option>');
                            $(".chosen-select").trigger("chosen:updated");
                            //delete with a click
                            $(".search-choice-close").one('click', function(e) {
                                $.ajax({
                                    url: arcs.baseURL + "keywords/deleteKeyword",
                                    type: "POST",
                                    data: {
                                        page_kid: PAGE_KID,
                                        project_kid: PROJECT_KID,
                                        keyword: $(e.target).prev().html()
                                    },
                                    success: function (data) {
                                        //console.log("keyword delete ajax success");
                                    }
                                })
                            });
                        }
                    })
                });
            }
        })
    }
});
