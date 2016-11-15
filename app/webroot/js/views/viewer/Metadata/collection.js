// collection
$( document ).ready(function() {

    //open collection modal
    $("#collection-modal-btn").click(function () {
        $(".collectionModalBackground").show();
    });

    //close the modal. unselect and get the collections list again
    $(".modalClose").click(function () {
        $(".collectionSearchBar").addClass("first");
        $(".collectionModalBackground").hide();
        $("#collectionModal").show();
        $("#addedCollectionModal").hide();
        var retunselect = unselect(null);
    });

    //go to the arcs collection page from collection added modal.
    $(".viewCollection").click(function () {
        window.location.href = arcs.baseURL + "collections?" + lastCheckedId.substr(5);
    });
    //close the collection added modal
    $(".backToSearch").click(function () {
        $(".modalClose").trigger("click");
    });

    //new collection submit
    $(".collectionNewSubmit").click(function () {
        // creates a single, new collection entry based on the resource it is viewing
        var formdata = {
            title: $('#collectionTitle').val(),
            resource_kid: resourceKid,
            description: "",
            public: 1
        };

        $.ajax({
            url: arcs.baseURL + "collections/add",
            type: "POST",
            data: formdata,
            statusCode: {
                201: function () {
                    $("#collectionName").text($('#collectionTitle').val());
                    $("#collectionModal").hide();
                    $("#addedCollectionModal").show();
                    getCollections(); //details tab collections.
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

    //add the resource to an existing collection from the search tab.
    $(".collectionSearchSubmit").click(function () {
        // creates 1+ collection entries based on the resource (IE adds the resource to old collections)

        var resource_kid = resourceKid;

        //for each collection that was checked.
        $('#collectionSearchObjects input:checked').each(function () {
            var formdata = {
                collection: $(this).val(),
                resource_kid: resource_kid
            }

            $.ajax({
                url: arcs.baseURL + "collections/addToExisting",
                type: "POST",
                data: formdata,
                statusCode: {
                    201: function (data) {
                        var text = $("label[for=" + lastCheckedId + "]").children(":first").text();
                        $("#collectionName").text(text);
                        $("#collectionModal").hide();
                        $("#addedCollectionModal").show();
                        getCollections(); //update details tab collection list.
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
        //$(".collectionModalBackground").hide();
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
    collectionList(); //add to collection modal collection list.
    getCollections(); //details tab collections.
});

var collectionArray = [];

//get collection list for search modal
function collectionList() {
    collectionArray = [];
    $.ajax({
        url: arcs.baseURL + "collections/titlesAndIds",
        type: "get",
        //data: "",
        success: function (data) {
            data.forEach(function (tempdata) {
                var temparray = $.map(tempdata, function (value, index) {
                    return [value];
                });
                collectionArray.push(temparray);
            })
            //update the search modal with the new collection list
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
    this.$(".select-button").removeClass("de-select");
    this.$(".select-button, #toggle-select").html("SELECT");
    this.$("#deselect-all").attr({id: "select-all"});
    this.$(".checkedboxes").prop("checked", false);
    this.$("#collectionTitle").val('');
    this.$(".collectionTabSearch").trigger("click");
    collectionList();  //search modal collection list.
    checkSearchSubmitBtn();
}

var isAnyChecked = 0;
var lastCheckedId = '';

// Hide/show add to collection button in collection modal
function checkSearchSubmitBtn() {
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
        //set query to '' on first modal open.
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
function getCollections() {
    $.ajax({
        url: arcs.baseURL + "collections/memberships",
        type: "get",
        data: {
            id: resourceKid
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
            var ctab = document.getElementById("collections_tab");
            ctab.innerHTML = "COLLECTIONS (" + numCollections + ")";
            $("#collections_table").html(populateCollections);
        }
    })
}