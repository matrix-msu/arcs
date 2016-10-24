$(document).ready(function(){

    var currentPagePicture = '';

    //check if the first page image has loaded and get keywords. if not, wait more
    function waitForPicture() {
        if ($('#PageImage').attr('src') == '../img/arcs-preloader.gif') {
            //console.log('more waiting');
            setTimeout(function () {
                waitForPicture();
            }, 150);
        }else{
            if( $('#PageImage').attr('src') != currentPagePicture ) {
                currentPagePicture = $('#PageImage').attr('src');
                getKeywords();
            }
        }
    }
    //wait and kick off the picture checking
    function startKeywords() {
        setTimeout(function () {
            waitForPicture();
        }, 500);
    }
    startKeywords();

    function getKeywords() {
        //get the keywords for the current page and update the chosen select thing
        /////////////////
        var html4 = '<fieldset class="users-fieldset">';
        html4 += '<select id ="urlAuthor" data-placeholder="Keywords" multiple class="chosen-select" style="width:90%;">';

        var resource_kid = $('.resource-container-level').find('.selectedResource').prev().attr('id');
        resource_kid = resource_kid.replace('identifier-', '');

        var PROJECT_KID = RESOURCES[resource_kid]['project_kid'];

        var PAGE_KID = $('#PageImage').attr('src');
        PAGE_KID = PAGE_KID.split('/');
        PAGE_KID = PAGE_KID.pop();
        PAGE_KID = PAGE_KID.split('-');
        PAGE_KID = PAGE_KID[0]+'-'+PAGE_KID[1]+'-'+PAGE_KID[2];

        var keywordArray = [];

        pageIndex = $(".selectedResource").text().replace(/^\s+|\s+$/g, '') - 1;

        $.ajax({
            url: arcs.baseURL + "keywords/get",
            type: "POST",
            data: {
                page_kid: PAGE_KID
            },
            success: function (data) {
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
                                page_kid: PAGE_KID,
                                project_kid: PROJECT_KID,
                                keyword: $(e.target).parent().prev().children().eq(0).text()
                            },
                            success: function (data) {
                            }
                        })
                    }
                });

                //add new keyword with a comma
                $(".search-field").on('keyup', "input", function(e) {
                    var id = $(this).val();
                    if( (id == "" || id == ',') && e.key == 'Backspace' ) {
                        //$(".chosen-select").trigger("chosen:updated");

                    }else if( e.key == ',' ) {
                        id = id.substring(0, id.length - 1);  //remove comma

                        var alreadyExists = keywordArray.indexOf( id );
                        if( alreadyExists != -1 ){
                            $(this).val('')
                            alert("You can only add a keyword once.");
                            return;
                        }
                        //pageIndex = $(".selectedResource").text().replace(/^\s+|\s+$/g, '') - 1;
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
                            //console.log("keyword add ajax success");
                        }
                    })
                    $("#urlAuthor").append( '<option selected="selected" data-id="'+id+'">'+id+'</option>');
                    $(".chosen-select").trigger("chosen:updated");
                    //getKeywords();
                });
            }
        })
    }

    $('.other-resource').on('click', function(e) {
        if( $(this).attr('id').indexOf('identifier-') == -1 ) {
            startKeywords();
        }
    });
});
