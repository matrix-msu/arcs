$(document).ready(function(){
    getKeywords();

    function getKeywords() {
        //get the keywords for the current page and update the chosen select thing
        /////////////////
        var html4 = '<fieldset class="users-fieldset">';
        html4 += '<select id ="urlAuthor" data-placeholder="Keywords" multiple class="chosen-select" style="width:90%;">';

        var pagesObject = PAGESOBJECT;

        var pagesArray = $.map(pagesObject, function(value, index) {
            return [value];
        });

        var keywordArray = [];

        pageIndex = $(".selectedResource").text().replace(/^\s+|\s+$/g, '') - 1;

        $.ajax({
            url: arcs.baseURL + "keywords/get",
            type: "POST",
            data: {
                page_kid: pagesArray[parseInt(pageIndex)].kid
            },
            success: function (data) {
                //console.log("get keyword ajax success");
                //console.log(data);

                keywordArray = data;

                if( keywordArray instanceof Array ) {
                    keywordArray.forEach(function (keyword) {
                        //html4 += '<option data-id="'+keyword+'">'+keyword+'</option>';
                        html4 += '<option selected="selected" data-id="' + keyword + '">' + keyword + '</option>';
                    })
                }
                html4 += '</select></fieldset>';

                //fill in the select
                $("#urlform").html(html4);

                /////uses the chosen.js to turn the select into a fancy thingy
                $(".chosen-select").chosen();

                $(".search-field").on('keydown', "input", function(e) {
                    var id = $(this).val();
                    if( (id == "" || id == ',') && e.key == 'Backspace' ) { //get the newest keyword and delete it
                        $.ajax({
                            url: arcs.baseURL + "keywords/deleteKeyword",
                            type: "POST",
                            data: {
                                page_kid: pagesArray[parseInt(pageIndex)].kid,
                                project_kid: PROJECT_KID,
                                keyword: $(e.target).parent().prev().children().eq(0).text()
                            },
                            success: function (data) {
                                //console.log("keyword delete ajax success");
                                //console.log(data);
                            }
                        })
                    }
                });

                //delete with backspace
                $(".search-field").on('keyup', "input", function(e) {
                    //console.log("key up");
                    //console.log(e.key);
                    //console.log(e);
                    var id = $(this).val();
                    if( (id == "" || id == ',') && e.key == 'Backspace' ) {
                        //$(".chosen-select").trigger("chosen:updated");

                    }else if( e.key == ',' ) {
                        //console.log("comma pressed");
                        id = id.substring(0, id.length - 1);  //remove comma

                        var alreadyExists = keywordArray.indexOf( id );
                        if( alreadyExists != -1 ){
                            //console.log("keyword already exists");
                            $(this).val('')
                            alert("You can only add a keyword once.");
                            return;
                        }
                        pageIndex = $(".selectedResource").text().replace(/^\s+|\s+$/g, '') - 1;
                        keywordArray.push( id );
                        $.ajax({
                            url: arcs.baseURL + "keywords/add",
                            type: "POST",
                            data: {
                                //resource_id: resourceKid,
                                page_kid: pagesArray[parseInt(pageIndex)].kid,
                                project_kid: PROJECT_KID,
                                keyword: id
                            },
                            statusCode: {
                                403: function() {
                                    var index = keywordArray.indexOf(id);
                                    if (index > -1) {
                                        keywordArray.splice(index, 1);
                                    }
                                    $("#urlAuthor").find('option[data-id="'+id+'"]').remove();
                                    $(".chosen-select").trigger("chosen:updated");
                                    alert('You have to be logged-in to add a keyword.');
                                }
                            },
                            success: function (data) {
                                //console.log("keyword add ajax success");
                                //console.log(data);
                            }
                        })
                        $("#urlAuthor").append( '<option selected="selected" data-id="'+id+'">'+id+'</option>');
                        $(".chosen-select").trigger("chosen:updated");
                    }
                });

                //delete with a click
                $(".search-choice-close").on('click', function(e) {
                    //console.log("pressed keyword delete");
                    //console.log(e);
                    //console.log( $(e.target).prev().html() );
                    pageIndex = $(".selectedResource").text().replace(/^\s+|\s+$/g, '') - 1;
                    $.ajax({
                        url: arcs.baseURL + "keywords/deleteKeyword",
                        type: "POST",
                        data: {
                            page_kid: pagesArray[parseInt(pageIndex)].kid,
                            project_kid: PROJECT_KID,
                            keyword: $(e.target).prev().html()
                        },
                        success: function (data) {
                            //console.log("keyword delete ajax success");
                            //console.log(data);
                        }
                    })
                });
            }
        })

        //get the common keywords for the current project and update the chosen select thing
        /////////////////

        var html5 = '<fieldset class="users-fieldset">';
        html5 += '<select id ="urlAuthor2" data-placeholder="Keywords" multiple class="chosen-select2" style="width:90%;">';

        pageIndex = $(".selectedResource").text().replace(/^\s+|\s+$/g, '') - 1;

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
                    //console.log('clicked add common keyword');
                    //e.stopPropagation();
                    var id = $(this).text();
                    var alreadyExists = keywordArray.indexOf( id );
                    if( alreadyExists != -1 ){
                        //console.log("keyword already exists");
                        alert("You can only add a keyword once.");
                        return;
                    }

                    pageIndex = $(".selectedResource").text().replace(/^\s+|\s+$/g, '') - 1;
                    keywordArray.push( id );
                    $.ajax({
                        url: arcs.baseURL + "keywords/add",
                        type: "POST",
                        data: {
                            //resource_id: resourceKid,
                            page_kid: pagesArray[parseInt(pageIndex)].kid,
                            project_kid: PROJECT_KID,
                            keyword: id
                        },
                        statusCode: {
                            403: function() {
                                var index = keywordArray.indexOf(id);
                                if (index > -1) {
                                    keywordArray.splice(index, 1);
                                }
                                $("#urlAuthor").find('option[data-id="'+id+'"]').remove();
                                $(".chosen-select").trigger("chosen:updated");
                                alert('You have to be logged-in to add a keyword.');
                            }
                        },
                        success: function (data) {
                            //console.log("keyword add ajax success");
                            //console.log(data);
                        }
                    })
                    $("#urlAuthor").append( '<option selected="selected" data-id="'+id+'">'+id+'</option>');
                    $(".chosen-select").trigger("chosen:updated");
                    //getKeywords();
                });
            }
        })
    }

    $('.other-resources').on('click', function(e) {
        //console.log('keywords click other resources');
        getKeywords();
    });
});
