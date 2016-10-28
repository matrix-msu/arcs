// collection
$( document ).ready(function() {

    $("#collection-modal-btn").click(function () {
        $(".collectionModalBackground").show();
    });

    $(".modalClose").click(function () {
        console.log('modal close');
        $(".collectionSearchBar").addClass("first");
        $(".collectionModalBackground").hide();
        $("#collectionModal").show();
        $("#addedCollectionModal").hide();
        var retunselect = unselect(null);
        collectionList();
    });

    $(".viewCollection").click(function () {
        console.log("lastcheckedid");
        console.log(lastCheckedId);
        window.location.href = arcs.baseURL + "collections?" + lastCheckedId.substr(5);
    });
    $(".backToSearch").click(function () {
        $(".modalClose").trigger("click");
    });

    $(".collectionNewSubmit").click(function () {
        // creates a new collection and add the other resources to the new one.
        var resource_kids = [];
        $('.resource-container-level').find('.other-resource').each(function (){
            console.log($(this));
            var resource_kid = $(this).attr('id');
            resource_kid = resource_kid.replace('identifier-', '');
            resource_kids.push( resource_kid );
        });
        var formdata = {
            title: $('#collectionTitle').val(),
            resource_kid: resource_kids.shift(),
            description: "",
            public: 1
        };
        $.ajax({
            url: arcs.baseURL + "collections/add",
            type: "POST",
            data: formdata,
            statusCode: {
                201: function (data) {
                    var collection_id = data['collection_id'];
                    var intSuccess = 0;
                    var length = resource_kids.length;
                    for(var i=0; i <resource_kids.length; i++){
                        var resource_kid = resource_kids[i];
                        var formdata = {
                            collection: collection_id,  //a collection_id
                            resource_kid: resource_kid
                        }
                        $.ajax({
                            url: arcs.baseURL + "collections/addToExisting",
                            type: "POST",
                            data: formdata,
                            statusCode: {
                                201: function (data) {
                                    intSuccess++;
                                    if( intSuccess == length ) {
                                        //var text = $("label[for=" + lastCheckedId + "]").children(":first").text();
                                        $("#collectionName").text($('#collectionTitle').val());
                                        $("#collectionModal").hide();
                                        $("#addedCollectionModal").show();
                                        getCollections();
                                    }
                                }
                            }
                        });
                    }
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

    $(".collectionSearchSubmit").click(function () {
        // creates 1+ collection entries based on the resource (IE adds the resource to old collections)

        var resource_kids = [];
        $('.resource-container-level').find('.other-resource').each(function (){
            console.log($(this));
            var resource_kid = $(this).attr('id');
            resource_kid = resource_kid.replace('identifier-', '');
            resource_kids.push( resource_kid );
        });
        var intSuccess = 0;
        var length = resource_kids.length;
        for(var i=0; i <resource_kids.length; i++){
            var resource_kid = resource_kids[i];
            var formdata = {
                collection: $('#collectionSearchObjects input:checked').val(),  //a collection_id
                resource_kid: resource_kid
            }
            $.ajax({
                url: arcs.baseURL + "collections/addToExisting",
                type: "POST",
                data: formdata,
                statusCode: {
                    201: function (data) {
                        intSuccess++;
                        if( intSuccess == length ) {
                            var text = $("label[for=" + lastCheckedId + "]").children(":first").text();
                            //$("#collectionName").text($('#collectionTitle').val());
                            $("#collectionName").text(text);
                            $("#collectionModal").hide();
                            $("#addedCollectionModal").show();
                            getCollections();
                        }
                    }
                }
            });
        }
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

    // run on page load
    $(".collectionNewContainer").hide();
    collectionList();
    getCollections();

    $('.resource-container-level').click(function() {
       getCollections();
    });


});

var collectionArray = [];
var isAnyChecked = 0;
var lastCheckedId = '';
var numCollections = 0;

function collectionList() {
    //console.log("collectionList");
    collectionArray = [];
    $.ajax({
        url: arcs.baseURL + "collections/titlesAndIds",
        type: "get",
        //data: "",
        success: function (data) {
            //console.log("collectionlist ajax success");
            //console.log(data);

            data.forEach(function (tempdata) {
                var temparray = $.map(tempdata, function (value, index) {
                    return [value];
                });
                collectionArray.push(temparray);
            })

            collectionsSearch();

            //console.log("finished the ajax");
            //console.log(collectionArray);
        }
    });
}

var unselect = function (trigger) {
    console.log("unselect");
    if (trigger == null) {
        trigger = true
    }
    this.$(".result").removeClass("selected");
    this.$(".select-button").removeClass("de-select");
    this.$(".select-button, #toggle-select").html("SELECT");
    this.$("#deselect-all").attr({id: "select-all"});
    this.$(".checkedboxes").prop("checked", false);
    this.$("#collectionTitle").val('');
    this.$(".collectionTabSearch").trigger("click");
    collectionList();
    checkSearchSubmitBtn();
    //collectionsSearch();
    //if(trigger){
    //  return arcs.bus.trigger("selection")
    //}
}

function checkSearchSubmitBtn() {
    // Hide add to collection button in collection modal when no collections are selected
    var checkboxes = $("#collectionSearchObjects > input");
    var submitButt = $(".collectionSearchSubmit");
    //console.log(checkboxes);
    //console.log("here");
    //console.log(this);

    if (checkboxes.is(":checked")) {
        submitButt.show();
        isAnyChecked = 1;
    }
    else {
        submitButt.hide();
        isAnyChecked = 0;
    }
}

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
    //console.log(populateCheckboxes);
    $("#collectionSearchObjects").html(populateCheckboxes);

    var checkboxes = $("#collectionSearchObjects > input");
    checkboxes.click(function () {
        //console.log('clicked check here');
        //console.log(this);
        if (isAnyChecked == 1) {
            $('#' + lastCheckedId).prop("checked", false);
        }
        lastCheckedId = $(this).attr('id');
        checkSearchSubmitBtn();
    });
    $('#collectionTitle').bind('input propertychange', function () {
        if (this.value != "") {
            $(".collectionNewSubmit").show();
            //console.log('text value not null');
        } else {
            $(".collectionNewSubmit").hide();
        }
    });
}

function getCollections() {
    var resource_kid = $('.resource-container-level').find('.selectedResource').prev().attr('id');
    resource_kid = resource_kid.replace('identifier-', '');
    $.ajax({
        url: arcs.baseURL + "collections/memberships",
        type: "get",
        data: {
            id: resource_kid
        },
        success: function (data) {
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
            var ctab = document.getElementById("collections_tab");
            ctab.innerHTML = "COLLECTIONS (" + numCollections + ")";
            $("#collections_table").html(populateCollections);
        }
    })
}