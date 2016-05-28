<div class="viewers-container">
	<div class="collectionModalBackground" id="collectionModalBackground">
		<div class="collectionWrap" style="margin-top:9em;">
			<div id="collectionModal" style="width:35em;">
				<div class="collectionModalHeader">Add to collection <img src="../arcs/app/webroot/assets/img/Close.svg"
																		  class="modalClose"/></div>
				<hr>
				<p class="collectionTab collectionTabSearch activeTab" style="margin-left:.6em;">Search</p>
				<p class="collectionTab collectionTabNew">Add to a new collection</p>
				<div class="collectionSearchContainer">
					<form id="collectionSearchBarForm" onsubmit="collectionsSearch(); return false;">
						<input type="text" class="collectionSearchBar" placeholder="Search for collections">
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
	</div>


	<div id="advanced">
		<a class="advancedSearch" href="advancedsearch">Advanced Search</a>
	</div>

	<div id="search-results-wrapper">
		<div class="SearchBar">
			<div id="search-actions" class="search-toolbar">
				<div id="sites-buttons" class="btn-group actions-left">
				  <button id="sites-btn" class="btn dropdown-toggle" data-toggle="dropdown">
					Sites
					<span class="pointerDown sort-arrow"></span>
				  </button>
				  <ul class="dropdown-menu">
					<li><a class="sort-site-btn active" id="open-btn">Isthmia&nbsp;</a></li>
					<li><a class="sort-btn" id="open-colview-btn">Polis&nbsp;</a></li>
					<li><a class="sort-btn" id="open-btn">Chersonesos&nbsp;</a></li>
				  </ul>
				</div>

				<div id="seasons-buttons" class="btn-group actions-left">
				  <button id="seasons-btn" class="btn dropdown-toggle" data-toggle="dropdown">
					Season
					<span class="pointerDown sort-arrow"></span>
				  </button>
				  <ul class="dropdown-menu">
					<li><a class="sort-btn active" id="open-btn">Option 1&nbsp;</a></li>
					<li><a class="sort-btn" id="open-colview-btn">Option 2&nbsp;</a></li>
					<li><a class="sort-btn" id="open-btn">...&nbsp;</a></li>
				  </ul>
				</div>

				<div id="resources-buttons" class="btn-group actions-left">
				  <button id="resources-btn" class="btn dropdown-toggle" data-toggle="dropdown">
					Resource Type
					<span class="pointerDown sort-arrow"></span>
				  </button>
				  <ul class="dropdown-menu">
					<li><a class="sort-btn active" id="open-btn">Drawing&nbsp;</a></li>
					<li><a class="sort-btn" id="open-colview-btn">Inventory Card&nbsp;</a></li>
					<li><a class="sort-btn" id="open-btn">Map&nbsp;</a></li>
					 <li><a class="sort-btn" id="open-btn">Notebook&nbsp;</a></li>
					<li><a class="sort-btn" id="open-colview-btn">Notebook Page&nbsp;</a></li>
					<li><a class="sort-btn" id="open-btn">Photograph&nbsp;</a></li>
					<li><a class="sort-btn" id="open-btn">Report&nbsp;</a></li>
				  </ul>
				</div>

				<div id="author-buttons" class="btn-group actions-left">
				  <button id="author-btn" class="btn dropdown-toggle" data-toggle="dropdown">
					Author
					<span class="pointerDown sort-arrow"></span>
				  </button>
				  <ul class="dropdown-menu">
					<li><a class="sort-btn active" id="open-btn">Option 1&nbsp;</a></li>
					<li><a class="sort-btn" id="open-colview-btn">Option 2&nbsp;</a></li>
					<li><a class="sort-btn" id="open-btn">...&nbsp;</a></li>
				  </ul>
				</div>

				<div id="data-buttons" class="btn-group actions-left">
				  <button id="data-btn" class="btn dropdown-toggle" data-toggle="dropdown">
					Data
					<span class="pointerDown sort-arrow"></span>
				  </button>
				  <ul class="dropdown-menu">
					<li><a class="sort-btn active" id="open-btn">Option 1&nbsp;</a></li>
					<li><a class="sort-btn" id="open-colview-btn">Option 2&nbsp;</a></li>
					<li><a class="sort-btn" id="open-btn">...&nbsp;</a></li>
				  </ul>
				</div>

				<div id="options-buttons" class="btn-group actions-right">
				  <button id="options-btn" class="btn dropdown-toggle" data-toggle="dropdown">
					Options
					<span class="pointerDown sort-arrow"></span>
				  </button>
				  <ul class="dropdown-menu">
					<li><a class="sort-btn active" id="open-btn">In separate windows&nbsp;</a></li>
					<li><a class="sort-btn" id="open-colview-btn">In a collection view&nbsp;</a></li>
					<li class="divider"></li>
					<li><a class="sort-btn" id="open-btn">Download&nbsp;</a></li>
					<li><a class="sort-btn" id="open-colview-btn">Download as a Zip file&nbsp;</a></li>
				  </ul>
				</div>

				<div id="view-buttons" class="btn-group actions-right">
				  <button id="sort-btn" class="btn dropdown-toggle" data-toggle="dropdown">
					<span id="sort-by">view</span>
					<span class="pointerDown sort-arrow"></span>
				  </button>
				  <ul class="dropdown-menu">
					<li><a class="sort-btn active" id="sort-title-btn">simple&nbsp;
					  <i class="icon-ok"></i></a></li>
					<li><a class="sort-btn" id="sort-modified-btn">detailed&nbsp;</a></li>
				  </ul>
				</div>

				<div id="sorting-buttons" class="btn-group actions-right">
				  <button id="sort-btn" class="btn dropdown-toggle" data-toggle="dropdown">
					Sort by
					<span class="pointerDown sort-arrow"></span>
				  </button>
				  <ul class="dropdown-menu">
					<li><a class="sort-btn active" id="sort-title-btn">title&nbsp;
					  <i class="icon-ok"></i></a></li>
					<li><a class="sort-btn" id="sort-modified-btn">modified&nbsp;</a></li>
					<li><a class="sort-btn" id="sort-created-btn">created&nbsp;</a></li>
					<li class="divider"></li>
					<li><a class="dir-btn" id="dir-asc-btn">ascending&nbsp;
					  <i class="icon-ok"></i></a></li>
					<li><a class="dir-btn" id="dir-desc-btn">descending&nbsp;</a></li>
				  </ul>
				</div>

			</div>
		</div>

		<div id="search-results">

			<div class='toolbar-fixed'>
				<a id='select-all' onclick=''><span id='toggle-select'>SELECT</span> ALL (<span id='results-count'></span>) SEARCH RESULTS</a>
				<a id='selected-all' href="#">ADD (<span id='selected-count'></span>) SELECTED RESULTS TO A COLLECTION <img src='img/BelongsToCollectionTooltip.svg' class='collectionIcon'/></a>
				<div id="selected-resource-ids" style="display: none;"></div>
			</div>

			<ul class="flex-container">
				<!--
				<div class="resource-item-container">
					<li class="flex-item">1</li>
					<div class="resource-title">Resource Title</div>
					<div class="resource-type">Resource Type</div>
					<div class="icon-annotate"></div>
				</div>
				<div class="resource-item-container">
					<li class="flex-item">2</li>
					<div class="resource-title">Resource Title</div>
					<div class="resource-type">Resource Type</div>
					<div class="icon-annotate"></div>
					<div class="icon-flag"></div>
				</div>
				<div class="resource-item-container">
					<li class="flex-item">3</li>
					<div class="resource-title">Resource Title</div>
					<div class="resource-type">Resource Type</div>
					<div class="icon-flag"></div>
					<div class="search-icon-edit"></div>
					<div class="icon-in-collection"></div>
					<div class="icon-discussed"></div>
					<div class="icon-tagged"></div>
				</div>
				-->
			</ul>
		</div>

		<div id='search-bottom-bar'>
			<div id="search-actions" class="search-toolbar">
				<div id="items-per-pages-buttons" class="btn-group actions-left">
					  <button id="items-per-page-btn" class="btn dropdown-toggle" data-toggle="dropdown">
						20 Items per Page
						<span class="pointerDown sort-arrow"></span>
					  </button>
					  <ul class="dropdown-menu">
						<li><a class="sort-btn" id="open-btn">20 Items&nbsp;</a></li>
						<li><a class="sort-btn" id="open-colview-btn">40 Items&nbsp;</a></li>
						<li><a class="sort-btn" id="open-btn">60 Items&nbsp;</a></li>
					  </ul>
				</div>
				<ul class="pagination">
					<li><a class='selected pageNumber' id='1'>1</a></li>
					<li><a class='pageNumber' id='2'>2</a></li>
					<li><a class='pageNumber' id='3'>3</a></li>
					<li><a class='pageNumber' id='4'>4</a></li>
					<li><a class='pageNumber' id='5'>5</a></li>
				</ul>
				<div id="search-again">
					<a class="search-again-link" id='top-btn'>Search again</a>
				</div>
			</div>
		<div id="search-pagination"></div>

		</div>
	</div>
</div>

<script>
  arcs.searchView = new arcs.views.search.Search({
    el: $('.wrap')
  });
   
   function toggle_search_visibility() {
       var e = document.getElementById("search-results-wrapper");
       if(e.style.visibility == 'hidden')
       		console.log("hi");
	   		e.style.visibility = 'visible';
    }
    /* Replaced with search.js' scrollTop */
    /*function movePage() {
	    console.log("HI");
	    window.location.hash = "searchJump";
	}
    */
	
    /*$(document).ready(function () {
    $("li").click(function () {
        $('li > ul').not($(this).children("ul")).hide();
        $(this).children("ul").toggle();
    });
	});*/
	
	$(".searchBoxInput").keyup(function (e) {
		if (e.keyCode === 13) {
			console.log("Hi");
			toggle_search_visibility();
		}
	});
	
	/* function for page numbers */
	$('.pageNumber').click(function(){
		/* console.log(this.id); */
		$('.pageNumber').removeClass('selected');
		$(this).addClass('selected');
		/* add functions here, use this.id to identify page number. */
	});

	$('#select-all, #deselect-all').click(function(){
		if (this.id === 'select-all') {
			this.id = 'deselect-all';
			arcs.searchView.selectAll();
			$('#toggle-select').html('DE-SELECT');
		} else {
			this.id = 'select-all';
			arcs.searchView.unselectAll();
			$('#toggle-select').html('SELECT');
		}
		
	});
</script>

<script>
	// collection
	$("#selected-all").click(function () {
		//console.log("hello-testing-click");
		var e = document.getElementById("selected-all");
		//console.log(e.style.color);
		if(e.style.color == "rgb(0, 0, 0)")
			$(".collectionModalBackground").show();

	});

	$(".modalClose").click(function () {
		$(".collectionModalBackground").hide();
	});

	function collectionsSearch() {
		var query = $(".collectionSearchBar").val();
		console.log("search here");

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
	}

	$(".collectionNewSubmit").click(function () {
		// creates a single, new collection entry based on the resource it is viewing
		var selected_resources = [];
		selected_resources = arcs.selected;
		console.log("selected_resource:");
		console.log(selected_resources);

		var formdata = {
			title: $('#collectionTitle').val(),
			resource_kid: selected_resources[0],
			description: ""//,
			//public: 1
		}
		console.log("got here 1");
		$.ajax({
			url: arcs.baseURL + "collections/add",
			type: "POST",
			data: formdata,
			statusCode: {
				201: function (data) {
					console.log("Success");
					console.log(data);
					//window.location.reload();
					selected_resources.shift();
					var new_col_id = data['collection_id']
					console.log("newcolid:");
					console.log(new_col_id);

					selected_resources.forEach(function(resource){
						var resource_kid = resource;
						var formdata = {
							collection: new_col_id,
							resource_kid: resource_kid
						};
						console.log("add to existing");
						console.log(formdata);

						$.ajax({
							url: arcs.baseURL + "collections/addToExisting",
							type: "POST",
							data: formdata,
							statusCode: {
								201: function () {
									console.log("Success");
									//window.location.reload();
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
					//arcs.Search.prototype.unselectAll();
					var unselect = function(trigger){
						if(trigger==null){trigger=true}this.$(".result").removeClass("selected");
						this.$(".select-button").removeClass("de-select");
						this.$(".select-button, #toggle-select").html("SELECT");
						this.$("#deselect-all").attr({id:"select-all"});
						this.$(".checkedboxes").prop("checked", false);
						this.$("#collectionTitle").val('');
						this.$(".collectionTabSearch").trigger("click");
						collectionList();
						collectionsSearch();
						if(trigger){
							return arcs.bus.trigger("selection")
						}
					};
					var retunselect = unselect(null);
					console.log("unselect here:");
					console.log(retunselect);
					$(".collectionModalBackground").hide();
					//arcs.selected = 0;
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
		//console.log("got to search click");
		//var selected_resources_string  = document.getElementById("selected-resource-ids").innerHTML;
		var selected_resources = [];
		selected_resources = arcs.selected;
		//console.log(selected_resources);
		//console.log("type below");
		//console.log(typeof(selected_resources));
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
		})
		var unselect = function(trigger){
			if(trigger==null){
				trigger=true
			}
			this.$(".result").removeClass("selected");
			this.$(".select-button").removeClass("de-select");
			this.$(".select-button, #toggle-select").html("SELECT");
			this.$("#deselect-all").attr({id:"select-all"});
			this.$(".checkedboxes").prop("checked", false);
			this.$("#collectionTitle").val('');
			this.$(".collectionTabSearch").trigger("click");
			collectionList();
			collectionsSearch();
			if(trigger){
				return arcs.bus.trigger("selection")
			}
		};
		var retunselect = unselect(null);
		$(".collectionModalBackground").hide();
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

	//<?php echo "var collectionArray = ".$collections.";" ?>
	//console.log("got here");
	//arcs.user_viewer = new arcs.views.CollectionList({
	//	model: arcs.models.Collection,
	//	collection: new arcs.collections.CollectionList({ collections|json_encode }}),
	//		el: $('#collectionSearchObjects')
	//});
	//arcs.user_viewer.collection.each(function(model) {
	//	console.log("something happens here...");
	//	console.log(model);
	//});
	//console.log("got here");
	//console.log(arcs.baseURL+ "collections/index");
	//var temp = getJSON arcs.baseURL + "collections/search?n=12&q=#{query}", (response) ->
		//resources2: response.results
	//console.log(arcs.josh_collection);
	var collectionArray = [];
	function collectionList() {
		collectionArray = [];
		$.ajax({
			url: arcs.baseURL + "collections/titlesAndIds",
			type: "get",
			//data: "",
			success: function (data) {
				//console.log("ajax success");
				//console.log(data);
				var arr = Object.keys(data).map(function (k) {
					return data[k]
				});
				//console.log('array below here');
				//console.log(arr);
				data.forEach(function (tempdata) {
					var arr = Object.keys(tempdata).map(function (k) {
						return tempdata[k]
					});
					//console.log(tempdata);
					//console.log("array below");
					//console.log(arr);
					arr.forEach(function (temparrdata) {
						var arr2 = Object.keys(temparrdata).map(function (k) {
							return temparrdata[k]
						});
						//console.log(arr2);
						if (arr2.length > 0)
							collectionArray.push(arr2);
					})


				})
				collectionsSearch();
				//console.log("finished the ajax");
				//console.log(collectionArray);
			}
		});
	}
	collectionList();
	//var collections = [];
	//console.log("collectionArray below here");
	//console.log(collectionArray);
	//collectionArray.forEach(function (element) {
		//console.log(element);
		//collections.push(element['Collection']);
	//});

	//collectionsSearch();
</script>
