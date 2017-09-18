// multi-resource collections
//also, search page collections
function collectionPrep() {

    // run on page load
    $(".collectionNewContainer").hide();
    collectionList();
    getCollections();


    //multi-viewer, open collection modal
    $("#collection-modal-btn").click(function () {
        $(".collectionModalBackground").show();
    });

    //search page, open collection modal
    $('#selected-all').click(function(){
        if (parseInt($('#selected-count').html()) > 0) {
            $(".collectionModalBackground").show();
        }
    });

    //close the modal. unselect and get the collections list again
    $(".collectionModalClose").click(function () {
        $(".collectionSearchBar").addClass("first");
        $(".collectionModalBackground").hide();
        $("#collectionModal").show();
        $("#addedCollectionModal").hide();
        var retunselect = unselect(null);
    });

    //close the collection added modal
    $(".backToSearch").click(function () {
        $(".collectionModalClose").trigger("click");
    });

    //new collection submit, creates a new one then adds the rest to that collection
    $(".collectionNewSubmit").click(function () {
        var resource_kids = getAllResourceKids();
        var formdata = {
            title: $('#collectionTitle').val(),
            resource_kid: resource_kids.shift(),
            public: 1
        };
        $.ajax({
            url: arcs.baseURL + "collections/add",
            type: "POST",
            data: formdata,
            statusCode: {
                201: function (data) {
                    var collection_id = data['collection_id'];
                    $('.viewCollection').attr('data-colId', data.collection_id);
                    var formdata = {
                        collection: collection_id,  //a collection_id
                        resource_kids: resource_kids
                    }
                    $.ajax({
                        url: arcs.baseURL + "collections/addToExisting",
                        type: "POST",
                        data: formdata,
                        statusCode: {
                            201: function (data) {
                                var href = $('#resources').attr('href');
                                href = href.split('/');
                                href = href.pop();
                                $('#viewCollectionLink').attr('href', arcs.baseURL+"collections/"+href+"?"+data.collection_id);
                                $("#collectionName").text($('#collectionTitle').val());
                                $("#collectionMessage")[0].childNodes[0].nodeValue = (data.new_resources+1)+' resource(s) were added to ';
                                if( data.duplicates ){
                                    $('#collectionWarning').html('**Warning: At least one resource was a duplicate and skipped.');
                                }
                                $("#collectionModal").hide();
                                $("#addedCollectionModal").show();
                                getCollections();
                            }
                        }
                    });
                },
                400: function () {
                    console.log("Bad Request");
                    $(".collectionModalBackground").hide();
                },
                405: function () {
                    console.log("Method Not Allowed");
                    $(".collectionModalBackground").hide();
                }
            }
        });
    });

    //get all the resource kids being added to the collection
    function getAllResourceKids(){
        var resource_kids = [];
        //is a multi-viewer page collections
        $('.resource-container-level').find('.other-resource').each(function (){
            var resource_kid = $(this).attr('id');
            resource_kid = resource_kid.replace('identifier-', '');
            resource_kids.push( resource_kid );
        });
        //is a search page add to collections
        if( resource_kids.length == 0 ){
            resource_kids = JSON.parse($('#selected-resource-ids').html());
        }
        //if still no resources, then stop.
        if( resource_kids.length == 0 ){
            throw new Error("There are no resources selected.");
        }
        return resource_kids;
    }

    //add the resource to an existing collection from the search tab.
    $(".collectionSearchSubmit").click(function () {
        var resource_kids = getAllResourceKids();
        var formdata = {
            collection: $('#collectionSearchObjects input:checked').val(),  //a collection_id
            resource_kids: resource_kids
        };
        $.ajax({
            url: arcs.baseURL + "collections/addToExisting",
            type: "POST",
            data: formdata,
            statusCode: {
                201: function (data) {
                    var href = $('#resources').attr('href');
                    href = href.split('/');
                    href = href.pop();
                    $('#viewCollectionLink').attr('href', arcs.baseURL+"collections/"+href+"?"+data.collection_id);
                    var text = $("label[for=" + lastCheckedId + "]").children(":first").text();
                    $("#collectionName").text($.trim(text));
                    $("#collectionMessage")[0].childNodes[0].nodeValue = data.new_resources+' resource(s) were added to ';
                    if( data.duplicates ){
                        $('#collectionWarning').html('**Warning: At least one resource was a duplicate and skipped.');
                    }
                    $("#collectionModal").hide();
                    $("#addedCollectionModal").show();
                    getCollections();
                }
            }
        });
    });

    // collection tabs
    $(".collectionTabSearch").click(function () {
        $(".collectionSearchContainer").show();
        $(".collectionNewContainer").hide();
        $(".collectionTabSearch").addClass("activeTab");
        $(".collectionTabNew").removeClass("activeTab");
    });

    $(".collectionTabNew").click(function () {
        $(".collectionNewContainer").show();
        $(".collectionSearchContainer").hide();
        $(".collectionTabNew").addClass("activeTab");
        $(".collectionTabSearch").removeClass("activeTab");
    });

    //new resource click.. update the details tab collections
    $('.resource-slider').find('.other-resource').click(function() {
        var resourceKid = $(this).attr('id');
        resourceKid = resourceKid.replace('identifier-', '');
        getCollections(resourceKid);
    });

};

//collections globals.
var collectionArray = [];
var isAnyChecked = 0;
var lastCheckedId = '';

//get collection list for search modal
function collectionList() {
    var href = $('#resources').attr('href');

    //this is a all project search.. so hide the collections button and return
    if( typeof href == 'undefined' ){
        $('#selected-all').css('display', 'none');
        return;
    }

    var hrefTemp = href.split('/');
    href = hrefTemp.pop();

    if( href == '' ){ //there was a trailing '/'
        href = hrefTemp.pop();
    }

    if( href.length == 36 ){
        $('#resources').css('display', 'none');
        $('#collections').css('display', 'none');
        $('#selected-all').css('display', 'none');
        return;
    }

    collectionArray = [];
    $.ajax({
        url: arcs.baseURL + "collections/titlesAndIds",
        type: "get",
        data: {pName: href},
        success: function (data) {
            data.forEach(function (tempdata) {
                var temparray = $.map(tempdata, function (value, index) {
                    return [value];
                });
                collectionArray.push(temparray);
            })
            collectionsSearch();
        }
    });
}

//unselect collections.
var unselect = function (trigger) {
    if (trigger == null) {
        trigger = true
    }
    this.$(".result").removeClass("selected");
    // this.$(".select-button").removeClass("de-select");
    // this.$(".select-button, #toggle-select").html("SELECT");
    // this.$("#deselect-all").attr({id: "select-all"});
    // this.$(".checkedboxes").prop("checked", false);
    this.$("#collectionTitle").val('');
    this.$(".collectionTabSearch").trigger("click");
    collectionList();
    checkSearchSubmitBtn();
}

// Hide/show add to collection button in collection modal
function checkSearchSubmitBtn() {
    // Hide add to collection button in collection modal when no collections are selected
    var checkboxes = $("#collectionSearchObjects > input");
    var submitButt = $(".collectionSearchSubmit");

    if (checkboxes.is(":checked")) {
        submitButt.show();
        isAnyChecked = 1;
    }
    else {
        submitButt.hide();
        isAnyChecked = 0;
    }
}

//update the collection search modal based on the new collection list.
function collectionsSearch() {
    var query = "";
    if ($(".collectionSearchBar").hasClass("first")) {
        query = "";
        $(".collectionSearchBar").removeClass("first");
    } else {
        query = $(".collectionSearchBar").val();
    }

    // only put collections in between the div if they include the query.
    // I.E. "" is in every collection title and user_name
    var populateCheckboxes = "<hr>";
    for (var i = 0; i < collectionArray.length; i++) {
        if ((collectionArray[i][0].toLowerCase()).indexOf(query.toLowerCase()) != -1 ||
            (collectionArray[i][2].toLowerCase()).indexOf(query.toLowerCase()) != -1) {

            populateCheckboxes += "<input type='checkbox' class='checkedboxes' name='item-" + i + "' id='item-" + i + "' value='" + collectionArray[i][1] + "' />"
                + "<label for='item-" + i + "'><div style='float:left'>" + collectionArray[i][0] + " </div><div style='float:right'>" + collectionArray[i][2] + "</div></label><br />";
        }
    }
    $("#collectionSearchObjects").html(populateCheckboxes);

    var checkboxes = $("#collectionSearchObjects > input");
    checkboxes.click(function () {
        if (isAnyChecked == 1) {
            $('#' + lastCheckedId).prop("checked", false);
        }
        lastCheckedId = $(this).attr('id');
        checkSearchSubmitBtn();
    });
    $('#collectionTitle').bind('input propertychange', function () {
        if (this.value != "") {
            $(".collectionNewSubmit").show();
        } else {
            $(".collectionNewSubmit").hide();
        }
    });
}

//for the details tab, what collections the resource is a part of.
function getCollections( resourceKid='' ) {
    if( resourceKid == '' ) {
        var currentResource = $('.selectedCurrentResource').find('img');

        if( currentResource.length == 0 ){//This mean we are on the search page..just stop here
            return;
        }
        var resource_kid = currentResource.attr('id').replace('identifier-', '');
    }else{
        var resource_kid = resourceKid;
    }

    var ctab = $("#collections_tab");
    ctab[0].innerHTML = "COLLECTIONS (" + 0 + ")";
    $("#collections_table").html('');
    $.ajax({
        url: arcs.baseURL + "collections/memberships",
        type: "get",
        data: {
            id: resource_kid
        },
        success: function (data) {
            var numCollections = 0;
            numCollections = data.collections.length;
            if (data.collections.length > 0) {
                var populateCollections = "<table><tbody>" +
                    "<tr><td colspan='2'>This resource is a part of the following " + numCollections + " collections...</td></tr>";
                for (var i = numCollections - 1; i >= 0; i--) {
                    var collection = data.collections[i];
                    populateCollections += "<tr><td style='width:50%'>" + collection.title + "</td><td>" + collection.user_name + "</td></tr>";
                }
                populateCollections += "</tbody></table>";
            } else {
                var populateCollections = "<table><tbody>" +
                    "<tr><td colspan='2'>This resource isn't part of any collections...</td></tr>";
            }
            ctab[0].innerHTML = "COLLECTIONS (" + numCollections + ")";
            $("#collections_table").html(populateCollections);
        }
    })
}

// $( document ).ready(collectionPrep)
