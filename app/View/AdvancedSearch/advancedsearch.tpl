<style media="screen">
.push{
  height: 0px;
}
#open-colview-btn{
  text-transform: uppercase;
  text-decoration: none;
  font-size: 12px;
  height: 35px;
  padding: 10px;
  float: right;
  color: #C1C1C1;
  cursor: pointer;
}
#open-colview-btn:hover{
  color:#337ab7;
}
.advanced-display-header {
  width: 70%;
  margin: auto;
}


.advanced-search-container {
  width: 70%;
  margin: auto;
}
#backToSearch {
  font-size: 12px;
  color: #0094BC;
  margin-bottom: 16px;
}

#page-title {
  color: #3F3F3F;
  font-size: 24px;
}
#page-description {
  color: #686868;
  font-size: 12px;
  line-height: 24px;
  margin-top: 16px;
}


.page-info header {
  position: relative;
}
.search-info {
  margin-bottom: 80px;
}
#field-selctor {
  margin-top: 19px;
  font-size: 12px;
  color: #686868;
}
#field-selctor span {
  padding-right: 10px;
}
#field-selctor ul{
  display: inline-block;
  padding: 0;
}
#field-selctor li{
  border-right: 1px solid #E2E2E2;
  padding: 4px;
  display: inline-block;
  margin: 4px;
  font-weight: bold;
  padding-left: 0;
  margin-left: 0;
}
#field-selctor .exit-btn{
  font-weight: 100;
  padding-left: 10px;
  cursor: pointer;
}
</style>


<!--Only thing different with advancedsearch.tpl compared to search tpl
is from here to ...
-->
<header class="advanced-display-header">
  <article class="search-info">
    <section id="backToSearch">
      <a href="#">SEARCH AGAIN</a>
    </section>
    <section class="page-info">
      <header>
        <span id="page-title">Advanced Search</span>
      </header>
    </section>
    <section id="field-selctor">
      <ul>
        <span id="result-info">Showing 20 of 100 resutls for </span>
      </ul>
    </section>
  </article>
</header>
<!--here-->


<div class="viewes-container">
	<div class="collectionModalBackground" id="collectionModalBackground">
		<div class="collectionWrap" style="margin-top:9em;">
			<div id="collectionModal" style="width:35em;">
				<div class="collectionModalHeader">Add to collection <img src="../app/webroot/assets/img/Close.svg"
																		  class="modalClose"/></div>
				<hr>
				<p class="collectionTab collectionTabSearch activeTab" style="margin-left:.6em;">Search</p>
				<p class="collectionTab collectionTabNew">Add to a new collection</p>
				<div class="collectionSearchContainer">
					<form id="collectionSearchBarForm" onsubmit="collectionsSearch(); return false;">
						<input type="text" class="collectionSearchBar first" placeholder="Search for collections">
					</form>
					<div id="collectionSearchForm" >
						<div id="collectionSearchObjects">
						</div>
						<button class="collectionSearchSubmit" >ADD TO COLLECTION</button>
					</div>
				</div>
				<div class="collectionNewContainer">
					<div id="collectionNewForm">
							<textarea class="formInput" id="collectionTitle"
									  placeholder="ENTER NEW COLLECTION TITLE"></textarea>
						<button class="collectionNewSubmit">ADD TO NEW COLLECTION</button>
					</div>
				</div>

			</div>
			<div id="addedCollectionModal" style="width:35em;display:none;">
				<div class="collectionModalHeader">ADDED TO COLLECTION! <img src="../app/webroot/assets/img/Close.svg"
																			 class="modalClose"/></div>
				<hr>
				<div>1 resource added to <p id="collectionName" style="display:inline;color:#4899CF"></p>!</div>
				<br>
				<button class="viewCollection" type="submit">VIEW COLLECTION</button>
				<button class="backToSearch" type="submit">BACK TO SEARCH</button>
			</div>
		</div>
	</div>

<div class='searchIntro'>
    <h1>Search</h1>

    <p>Vommit food and eat it again leave fur on owners clothes purr for no reason shake treat bag lounge in doorway or make meme, make cute face. Run in circles if it fits, i sits but peer out window, chatter at birds, lure them to mouth damn that dog stick butt in face leave fur on owners clothes jump off balcony, onto stranger's head.</p>
</div>

<a name="searchJump"></a>
<div id="searchBox">
	<div class="searchIcon"></div>
	<input type="text" class="searchBoxInput" placeholder="SEARCH FOR ARCHAEOLOGICAL DATA">
  <div id="searchButtonMobile">
      SEARCH
  </div>
  <div id="advanced">
  	<a class="advancedSearch" href="#" id="advancedSearchLink" >Advanced Search</a>
  </div>
</div>




<div id="search-results-wrapper">
		<div class="SearchBar">
			<div class="mobile-filter-opt"> open filter options</div>
			<div id="search-actions" class="search-toolbar">
				<div class="tool-bar-results">
					<div id="sites-buttons" class="btn-group actions-left">
						<!-- <button id="sites-btn" class="btn dropdown-toggle" data-toggle="dropdown">
                            Projects
                            <span class="pointerDown sort-arrow pointerSearch"></span>
                        </button> -->
						<ul class="dropdown-menu sitesMenu" data-id="Excavation Name">
						</ul>
					</div>

					<div id="seasons-buttons" class="btn-group actions-left" >
						<button id="seasons-btn" class="btn dropdown-toggle" data-toggle="dropdown">
							Season
							<span class="pointerDown sort-arrow pointerSearch"></span>
						</button>
						<ul class="dropdown-menu seasonsMenu" data-id="Season Name">
						</ul>
					</div>

					<div id="resources-buttons" class="btn-group actions-left">
						<button id="resources-btn" class="btn dropdown-toggle" data-toggle="dropdown">
							Resource Type
							<span class="pointerDown sort-arrow pointerSearch"></span>
						</button>
						<ul class="dropdown-menu resourcesMenu" data-id="Type">

						</ul>
					</div>


					<div id="excavation-buttons" class="btn-group actions-left">
						<button id="excavation-btn" class="btn dropdown-toggle" data-toggle="dropdown">
							Excavation Units
							<span class="pointerDown sort-arrow pointerSearch"></span>
						</button>
						<ul class="dropdown-menu excavationMenu" data-id="Excavation Type">

						</ul>
					</div>

					<div id="author-buttons" class="btn-group actions-left">
						<!--				need to adjust these on search -->
						<button id="author-btn" class="btn dropdown-toggle" data-toggle="dropdown">
							Creator
							<span class="pointerDown sort-arrow pointerSearch"></span>
						</button>
						<ul class="dropdown-menu creatorMenu" data-id="Creator">

						</ul>
					</div>
					<div id="options-buttons" class="btn-group actions-right">
						<button id="options-btn" class="btn dropdown-toggle" data-toggle="dropdown">
							Export
						</button>
					</div>

					<div id="view-buttons" class="btn-group actions-right">
						<button id="sort-btn" class="btn dropdown-toggle" data-toggle="dropdown">
							<span id="sort-by">view</span>
							<span class="pointerDown sort-arrow pointerSearch"></span>
						</button>
						<ul class="dropdown-menu">
							<li><a class="sort-btn active" id="grid-btn">simple&nbsp;
									<i class="icon-ok"></i></a></li>
							<li><a class="sort-btn" id="list-btn">detailed&nbsp;</a></li>
						</ul>
					</div>

					<div id="sorting-buttons" class="btn-group actions-right">
						<button id="sort-btn" class="btn dropdown-toggle" data-toggle="dropdown">
							Sort by
							<span class="pointerDown sort-arrow pointerSearch"></span>
						</button>
						<ul class="dropdown-menu">
							<li><a class="sort-btn active sorter" id="sort-title-btn">title&nbsp;
									<i class="icon-ok"></i></a></li>
							<li><a class="sort-btn sorter" id="sort-modified-btn">modified&nbsp;</a></li>
							<li class="divider"></li>
							<li><a class="dir-btn active " id="dir-asc-btn">ascending&nbsp;
									<i class="icon-ok"></i></a></li>
							<li><a class="dir-btn" id="dir-desc-btn">descending&nbsp;</a></li>
						</ul>
					</div>

				</div>
			</div>
		</div>
		<div class='search-pagination'>
			<div id="search-results">

				<div class='toolbar-fixed'>
					<a id='select-all'><span id='toggle-select'>SELECT</span> ALL (<span id='results-count'></span>) SEARCH RESULTS</a>
					<a id='selected-all'>ADD (<span id='selected-count'></span>) SELECTED RESULTS TO A COLLECTION <div class="icon-collection"></div></a>
					<div id="selected-resource-ids" style="display: none;"></div>
					<form id="open-colview-form" method="POST">
						<div id="open-colview-btn">Open in Collection View</div>
						<input type="hidden" name="resources" value="">
					</form>
				</div>

				<ul class="flex-container">
			</div>
		</div>


		<div id='search-bottom-bar'>
			<div id="search-actions" class="search-toolbar">
				<div id="items-per-pages-buttons" class="btn-group actions-left">
					<button id='items-per-page-btn' class='btn dropdown-toggle' data-toggle='dropdown'>20 Items per Page
						<span class='pointerDown sort-arrow pointerSearch'></span>
					</button>
					<ul class="dropdown-menu">
						<li><a class="sort-btn perpage-btn" id="open-btn">20 Items per Page&nbsp;</a></li>
						<li><a class="sort-btn perpage-btn" id="open-btn">40 Items per Page&nbsp;</a></li>
						<li><a class="sort-btn perpage-btn" id="open-btn">60 Items per Page&nbsp;</a></li>
					</ul>
				</div>
				<div id="pagination">
					<ul class="pagination">
						<div id='rightArrowBox'><li id='rightArrow' class='pointerDown pointerNum' style="display:none"></li></div>

						<li><a class='pageNumber' id='firstPage' style="display:none"> 1 </a></li>
						<div id='fDots'><li class='fDots' style="display:none"> ... </li></div>
						<li><a class='selected currentPage pageNumber' id='1' style="display:none"></a></li>
						<li><a class='pageNumber' id='2'style="display:none" ></a></li>
						<li><a class='pageNumber' id='3' style="display:none"></a></li>
						<li><a class='pageNumber' id='4' style="display:none"></a></li>
						<li><a class='pageNumber' id='5' style="display:none"></a></li>
						<div id='dots'> <li class='dots' style="display:none" style="display:none"> ... </li></div>
						<li><a class='pageNumber' id="lastPage" style="display:none"></a></li>
						<div id="leftArrowBox" ><li id='leftArrow' class='pointerDown pointerNum' style="display:none"></li></div>
					</ul>
				</div>

				<div id="search-again">
					<a class="search-again-link" id='top-btn'>Search again</a>
				</div>
			</div>



		</div>

		<div class="mobile-search-reroutes">
			<p class="searchAgain">Search Again</p>
			<p class="advSearch">Go to Advanced Search</p>
		</div>
	</div>
<script>
  arcs.searchView = new arcs.views.search.Search({
    el: $('.wrap')
  });

</script>
<!--advanced search script-->
<script>

  var AdvancedSearch = {

    getParams : function() {
      var param = window.location.search.split("&")
      var paramArray = Array();
      for (var i=0;i<param.length;i++) {

        param[i] = param[i].replace(/\?/,"")

        if (param[i].split("=").length === 2) {
            var queryPart = {
              field : param[i].split("=")[0],
              value : param[i].split("=")[1]
            }
            paramArray.push(queryPart)
        }
      }
      return paramArray
    },
    getQuery : function(params) {
      var query = "?"
      params.forEach(function(e) {
        query += e.field + "=" + e.value + "&"
      })
      return query
    },
    pushParamsToView : function(ul, paramArray,min , max) {
      ul = $(ul)
      ul.empty()
      ul.append(
        "<span id=\"result-info\">Showing "+min+" of "+max+" resutls for </span>"
      )
      paramArray.forEach(function(element) {
        ul.append(
          "<li data-field=\"" + element.field + "\">" +
          element.field + ": \"" + decodeURIComponent(element.value) + "\"" +
          "<span class=\"exit-btn\">X</span>" +
          "</li>"
        )
      })
    },
    search : function(params) {
      var api = arcs.baseURL + "api/search/advanced/"
      var param = AdvancedSearch.getQuery(params);
      $('.flex-container').empty();
      $('.flex-container').append('<img src=' +arcs.baseURL+'img/arcs-preloader.gif>');
      window.location.href = window.location.origin + window.location.pathname + param
    }

  }

  $(document).ready(function(){
    var params = AdvancedSearch.getParams()
    var min = 20
    var max = window.results_to_display.total || 0
    AdvancedSearch.pushParamsToView("#field-selctor ul", params, min, max)

    $(".exit-btn").click(function() {
      var field = $(this).parent().data("field")
      params.forEach(function(e) {
        if (field == e.field) {
          params.splice(params.indexOf(e), 1)
          AdvancedSearch.pushParamsToView("#field-selctor ul", params, min, max)
          AdvancedSearch.search(params)
          return
        }
      })
    })

    $("#backToSearch").find("a").click(function() {
      window.location.href =
      window.location.origin + arcs.baseURL + "search/advanced/" + window.globalproject
    })

  })
</script>



<!--TO HERE-->
	<script>
		// collection
		$("#selected-all").click(function () {
			var e = document.getElementById("selected-all");
			if(e.style.color == "rgb(0, 0, 0)")
				$(".collectionModalBackground").show();
		});
		$(".modalClose").click(function () {
			$(".collectionModalBackground").hide();
			$("#collectionModal").show();
			$("#addedCollectionModal").hide();
			unselect(null);
			collectionList();
		});
		var isAnyChecked = 0;
		var lastCheckedId = '';
		function checkSearchSubmitBtn() {
			// Hide add to collection button in collection modal when no collections are selected
			var checkboxes = $("#collectionSearchObjects > input");
			var submitButt = $(".collectionSearchSubmit");
			if(checkboxes.is(":checked")) {
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
			if( $(".collectionSearchBar").hasClass("first") ){
				query = "";
				$(".collectionSearchBar").removeClass("first");
			}else {
				query = $(".collectionSearchBar").val();
			}
			// only put collections in between the div if they include the query.
			// I.E. "" is in every collection title and user_name
			var populateCheckboxes = "<hr>";
			for (var i = 0; i < collectionArray.length; i++) {
				if ((collectionArray[i][0].toLowerCase()).indexOf(query.toLowerCase()) != -1 ||
						(collectionArray[i][2].toLowerCase()).indexOf(query.toLowerCase()) != -1) {
					populateCheckboxes += "<input type='checkbox' class='checkedboxes' name='item-" + i + "' id='item-" + i + "' value='" + collectionArray[i][1] + "' />"
							+ "<label for='item-" + i + "'><div style='float:left'>" + collectionArray[i][0] + " </div><div style='float:right'>" + collectionArray[i][2]+ "</div></label><br />";
				}
			}
			$("#collectionSearchObjects").html(populateCheckboxes);
			// Hide add to collection button in collection modal when no collections are selected
			var checkboxes = $("#collectionSearchObjects > input");
			var submitButt = $(".collectionSearchSubmit");
			console.log(checkboxes);
			checkboxes.click(function() {
				if(isAnyChecked == 1){
					$('#'+lastCheckedId).prop("checked", false);
				}
				lastCheckedId = $(this).attr('id');
				checkSearchSubmitBtn();
			});
			$('#collectionTitle').bind('input propertychange', function() {
				if(this.value != ""){
					$(".collectionNewSubmit").show();
				}else{
					$(".collectionNewSubmit").hide();
				}
			});
		}
		$(".viewCollection").click(function () {
			var href = $('#resources').attr('href');
			href = href.split('/');
			href = href.pop();
			window.location.href=arcs.baseURL+"collections/"+href+"?"+$('.viewCollection').attr('data-colId');
		});
		$(".backToSearch").click(function () {
			$(".modalClose").trigger("click");
		});
		$(".collectionNewSubmit").click(function () {
			// creates a single, new collection entry based on the resource it is viewing
			var selected_resources = [];
			$('.resource-item-container.result.selected').each(function(){
				selected_resources.push($(this).attr('data-id'));
			});
			var formdata = {
				title: $('#collectionTitle').val(),
				resource_kid: selected_resources[0],
				description: ""//,
				//public: 1
			};
			$.ajax({
				url: arcs.baseURL + "collections/add",
				type: "POST",
				data: formdata,
				statusCode: {
					201: function (data) {
						selected_resources.shift();
						var new_col_id = data['collection_id'];
						$('.viewCollection').attr('data-colId', data.collection_id);
						selected_resources.forEach(function(resource){
							var resource_kid = resource;
							var formdata = {
								collection: new_col_id,
								resource_kid: resource_kid
							};
							$.ajax({
								url: arcs.baseURL + "collections/addToExisting",
								type: "POST",
								data: formdata,
								statusCode: {
									201: function () {
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
						})
						$("#collectionName").text($('#collectionTitle').val());
						$("#collectionModal").hide();
						$("#addedCollectionModal").show();
						unselect(null);
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
			var selected_resources = [];
			$('.resource-item-container.result.selected').each(function(){
				selected_resources.push($(this).attr('data-id'));
			});
			selected_resources.forEach(function(resource){
				var resource_kid = resource;
				$('#collectionSearchObjects input:checked').each(function () {
					var formdata = {
						collection: $(this).val(),
						resource_kid: resource_kid
					}
					// TODO: sometimes returns an error but it will always upload to the sql database
					$.ajax({
						url: arcs.baseURL + "collections/addToExisting",
						type: "POST",
						data: formdata,
						statusCode: {
							201: function (data) {
								$('.viewCollection').attr('data-colId', data.collection_id);
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
			})
			var text = $("label[for="+lastCheckedId+"]").children(":first").text();
			$("#collectionName").text(text);
			$("#collectionModal").hide();
			$("#addedCollectionModal").show();
			unselect(null);
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
		function unselect(trigger){
			if(trigger==null){
				trigger=true
			}
			this.$(".result").removeClass("selected");
			this.$(".select-button").removeClass("de-select");
			this.$(".select-button, #toggle-select").html("SELECT");
			this.$("#deselect-all").attr({id:"select-all"});
			this.$('#selected-all').css('color','rgb(193, 193, 193)');
			this.$('#selected-count').html('');
			this.$(".checkedboxes").prop("checked", false);
			this.$("#collectionTitle").val('');
			this.$(".collectionTabSearch").trigger("click");
			collectionList();
			collectionsSearch();
			if(trigger){
				return arcs.bus.trigger("selection")
			}
		};
		var collectionArray = [];
		function collectionList() {
			collectionArray = [];
			var href = $('#resources').attr('href');
			href = href.split('/');
			var projectKid = href.pop();
			$.ajax({
				url: arcs.baseURL + "collections/titlesAndIds",
				type: "get",
				data: {pKid: projectKid},
				success: function (data) {
					data.forEach(function (tempdata) {
						var temparray = $.map(tempdata, function(value, index) {
							return [value];
						});
						collectionArray.push(temparray);
					})
					collectionsSearch();
				}
			});
		}
		collectionList();
	</script>
