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
	color: #0094BC !important;
	text-decoration: none;
}
</style>

<article id="pageHelpModal">
  <div style="overflow-y:hidden">
      <a class="search-help-close" href="#">&times;</a>

    <p class="modal-title">Keyword Search</p>
	  Entering more than one word in a Keyword Search will generate results where ALL words in the
	  search are present in ANY of the Keyword Search fields.  A search for Byzantine glazed lamp,
	  for example, will return records where "Byzantine" <b>AND</b> "glazed" <b>AND</b> "lamp" appear in the Title
	  <b>OR</b> Resource Identifier <b>OR</b> Resource Type <b>OR</b> Date Created <b>OR</b> any of the 13 Keyword fields.
		<br /><br />
	  <u>To search dates, enter the data as follows</u>:<br />
	  Complete year (e.g. 1972 and not 72)<br />
	  Month and year (e.g. March 1972 and not 3/1972)<br />
	  Full date in year, month, day format (e.g. 1972/03/15 and not 3/15/72)<br />
	  <br />
        <section id="modal-advanced-search">
	         To conduct a more detailed search across many more fields in a single project, try an
			<a href="#" id="advancedSearch" style="color: #44D1FF">Advanced Search</a>.
           <br /><br />
        </section>
      For a more detailed description of search fields, logic and filters, consult the
	  <a href="#" id="help" style="color: #44D1FF">help text</a>.
	  </p>
  </div>
</article>
<a id="removeModal" href="#"></a>


<div id="collection_permission_model" class="permissionModal2">
	<div class="permission-content2">
		<div class="modal-exit2"><p><a id="#close2"><img class="close-img2" src="" alt=""></a></p></div>
		<div class="permission-modal-header2">
			<h1 id="resourcePermHeader2">Whoops. You must be logged in to add to a collection.</h1>
		</div>
		<div class="permission-modal-content2">
			<p id="resourcePermPara2">You will need to login in order to add resources to a collection.</p>
		</div>
		<div class="permission-modal-responseButtons2">
			<p>
				<a href="#registerModal">
					<button class="reg2">REGISTER</button>
				</a>
				<a href="#loginModal">
					<button class="request2 logModalBtn2">LOGIN</button>
				</a>
			</p>
		</div>
	</div>
</div>

<div class="viewers-container" id="viewers-search">
	<div class="collectionModalBackground" id="collectionModalBackground">
		<div class="collectionWrap" style="margin-top:9em;">
			<div id="collectionModal" style="width:35em;">
				<div class="collectionModalHeader">Add to collection <img src="../app/webroot/assets/img/Close.svg"
																		  class="modalClose collectionModalClose"/></div>
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
				<div class="collectionModalHeader">ADDED TO COLLECTION!
					<img src="../app/webroot/assets/img/Close.svg" class="modalClose collectionModalClose"/>
				</div>
				<hr>
				<div id="collectionMessage" style="margin-left:6px;">1 resource added to <p id="collectionName" style="display:inline;color:#4899CF"></p>.</div>
				<br>
				<div id="collectionWarning" style="margin-left:6px;"></div>
				<br>
				<a id="viewCollectionLink" ><button class="viewCollection" type="submit">VIEW COLLECTION</button></a>
				<button class="backToSearch" type="submit">BACK TO SEARCH</button>
			</div>
		</div>
	</div>

<div class='searchIntro' style="display:none">
    <h1>
      Keyword Search
      <a id="page-help" href="#pageHelpModal">?</a>
    </h1>

    <p>
		Keyword searches are designed to provide an overview of the resources uploaded by one or more projects into ARCS.
		Keyword Search conducts a search over words in six fields related to each <i>archival document</i>,
		including its Title, Resource Identifier, Resource Type, Date Created, and Accession Number.
		Keyword also searches fields that identify the <i>subject</i> focus of these archival documents,
		including the Classification, Type, and Period of the artifact or structure described in the
		archival document, and the Material, Technique and Dates of production for the artifact or structure.

		<br/><br/>Because ARCS relies on user-generated content, search results may be incomplete.
	</p>
</div>

<a name="searchJump"></a>
<div id="searchBox">
	<div class="searchIcon"></div>
	<input type="text" class="searchBoxInput" placeholder="SEARCH FOR ARCHAEOLOGICAL DATA" >
  <div id="searchButtonMobile">
      SEARCH
  </div>
  <div id="advanced">
  	<a class="advancedSearch" href="#" id="advancedSearchLink" >Advanced Search</a>
  </div>
</div>




<div id="search-results-wrapper">
	<div class="SearchBar ">
		<div class="mobile-filter-opt"> open filter options</div>
		<div id="search-actions" class="search-toolbar">
			<div class="tool-bar-results hideSearchBars">
			<div id="sites-buttons" data-field="Project Name" class="btn-group actions-left hiddenProject filter-btn">
		      <button id="sites-btn" class="btn dropdown-toggle" data-toggle="dropdown">
		      	Projects
		      	<span class="pointerDown sort-arrow pointerSearch"></span>
		      </button>
		      <ul class="dropdown-menu sitesMenu" data-id="Project Name">
		      </ul>
		    </div>

		    <div data-field="Season Name" id="seasons-buttons" class="filter-btn btn-group actions-left" >
		      <button id="seasons-btn" class="btn dropdown-toggle" data-toggle="dropdown">
		      	Season
		      	<span class="pointerDown sort-arrow pointerSearch"></span>
		      </button>
		      <ul class="dropdown-menu seasonsMenu" data-id="Season Name">
		      </ul>
		    </div>

		    <div data-field="Type" id="resources-buttons" class="filter-btn btn-group actions-left">
		      <button id="resources-btn" class="btn dropdown-toggle" data-toggle="dropdown">
		      	Resource Type
		      	<span class="pointerDown sort-arrow pointerSearch"></span>
		      </button>
		      <ul class="dropdown-menu resourcesMenu" data-id="Type">

		      </ul>
		    </div>


			<div data-field="Excavation Type" id="excavation-buttons" class="filter-btn btn-group actions-left">
				<button id="excavation-btn" class="btn dropdown-toggle" data-toggle="dropdown">
					Excavation Units
					<span class="pointerDown sort-arrow pointerSearch"></span>
				</button>
				<ul class="dropdown-menu excavationMenu" data-id="Excavation Type">

				</ul>
			</div>

		    <div data-field="Creator" id="author-buttons" class="filter-btn btn-group actions-left">
		      <button id="author-btn" class="btn dropdown-toggle" data-toggle="dropdown">
		      	Creator
		      	<span class="pointerDown sort-arrow pointerSearch"></span>
		      </button>
		      <ul class="dropdown-menu creatorMenu" data-id="Creator">
		      </ul>
		    </div>
			<div id="options-buttons" class="btn-group actions-right">
				<div id="export-data-buttons" class="filter-btn btn-group" style="float:left">
					<button id="options-btn" class="btn dropdown-toggle" data-toggle="dropdown">
						<span class="content">
							EXPORT
							<span class="pointerDown sort-arrow pointerSearch" style="top:inherit;transform:rotate(135deg);"></span>
						</span>
					</button>
					<ul class="dropdown-menu" id="export-resources-per" style="top:57px;left:-40px;max-height:none;display:none">
						<li><a class="sort-btn export-data-num" data-num="50" id="export-data-50">50 RESOURCES/ZIP</a></li>
						<li><a class="sort-btn export-data-num" data-num="100" id="export-data-100">100 RESOURCES/ZIP</a></li>
						<li><a class="sort-btn active export-data-num" id="export-data-all">ALL RESOURCES/ZIP</a></li>
						<hr>
						<!-- li><a class="sort-btn active export-data-type" id="export-as-xml">XML</a></li>
						<li><a class="sort-btn export-data-type">JSON</a></li>
						<hr -->
					</ul>
				</div>
				<div id="export-images-buttons" class="filter-btn btn-group opacitied" style="display:none">
					<button class="export-options" id="export-images-btn" href="#" style="padding-right:0">
						<span class="content">
							IMAGES
							<span class="pointerDown sort-arrow pointerSearch" style="top:inherit;transform:rotate(135deg);"></span>
						</span>
					</button>
					<ul class="dropdown-menu" id="export-images-per"  style="top:57px;left:-291px;max-height:none">
						<li><a class="sort-btn export-image-num" data-num="20" id="export-image-20">20 IMAGES/ZIP</a></li>
						<li><a class="sort-btn active export-image-num" data-num="30" id="export-image-30">30 IMAGES/ZIP<i class="icon-ok"></i></a></li>
						<li><a class="sort-btn export-image-num" data-num="40" id="export-image-40">40 IMAGES/ZIP</a></li>
						<li><a class="sort-btn export-image-num" id="export-image-all">ALL IMAGES/ZIP</a></li>
						<hr>
					</ul>
				</div>
                <div id="export-modal" class="filter-btn btn-group" style="display:none">
                    <ul class="dropdown-menu" style="margin:0;top:58px;left:-367px;width:397px!important">
                        <li><br>
<p id="export-modal-title" style="display:inline">EXPORT</p> SELECTED RESOURCES
<img src="/<?php echo BASE_URL; ?>app/webroot/assets/img/ClearText.svg" class="modalClose exportModalClose new-open" style="margin-top:-3px"/>
<hr>
<div id="export-modal-explain">
<p class="sort-btn" style="white-space:pre;margin-top:-19px;line-height:19px">
Exports are split into a series of zip files that contain the data
and images for the selected Resources.
The data zip file exports before the images zip file(s).
Select your data export format: <a class="sort-btn active export-data-type" id="export-as-xml" style="display:inline">XML</a> | <a class="sort-btn export-data-type" style="display:inline">JSON</a>
</p>
<hr>
<a class="sort-btn active" id="export-automatic" style="margin-bottom:10px">Start DOWNLOAD</a>
</div>
                        <p class="sort-btn" style="white-space:pre;display:none;margin-top:-19px" id="export-modal-exporting">
Your export could take a little while.
You are downloading <span class="export-rem-data">0</span> records and <span class="export-rem-images">TBD</span> images,
which will be exported in a series of zip files.

Records --- Downloaded: <span class="export-downed-data">0</span> | Remaining: <span class="export-rem-data export-rem-decreasing-data">0</span>
Images ---- Downloaded: <span class="export-downed-images">0</span> | Remaining: <span class="export-rem-images export-rem-decreasing-images">TBD</span>
                        </p></li>
                    </ul>
                </div>
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
    <section class="search-filter-selector" id="field-selctor">
      <ul>
      </ul>
    </section>

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

			<div id="new-search">
				<a class="new-search-link">New Search</a>
			</div>
			<div id="search-again">
				<a class="search-again-link">Search again</a>
			</div>
		</div>



	</div>

	<div class="mobile-search-reroutes">
		<p class="searchAgain">Search Again</p>
		<p class="newSearch">New Search</p>
		<p class="advSearch">Go to Advanced Search</p>
	</div>
</div>


<script>


    var viewType = location.href.includes('search/resource_type/');
    var viewCollection = location.href.includes('search/collection/');

    if( viewType == true ){
		$("#searchBox").css("display","none");
		$("#advanced").css("display","none");
		var html = "<?php echo ARCS_LOADER_HTML; ?>";
		$('.searchIntro').html(html);
		$("#new-search").css("display","none");
		setUpViewTypeJs();
    }else{
		arcs.searchView = new arcs.views.search.Search({
	        el: $('.wrap')
	    });
	}
	if (viewCollection == false) {
		$(".searchIntro").css("display","block");
	}

	if (viewCollection == true) {
		$("#search-again").css("display","none");
		$("#new-search").css("display","none");
		$('.newSearch').remove();
		$('.searchAgain').remove();

	}


    $(document).ready(function() {
		var projectURL = window.location.href.split("/search/")[1];
        projectURL = projectURL.split(/[/#]/)[0];

        if (projectURL == "all") { //don't show the advanced search section if it's an all project search
            var advancedSection = document.getElementById("modal-advanced-search");
            advancedSection.style.display = "none";
        }

		var signedIn = false;
		if ($('#menu').html() != 'Login / Register'){
			signedIn = true;
		}

		if (signedIn){
			$('#options-btn').show();
		}

		//$('#options-btn').one('click', function() { //do export.
			//$('#export-images-buttons').css('display', 'block').css('opacity','.2');
			//$('#export-images-btn').css('display', 'block');
		//});

        $("#pageHelpModal").click(function(e) {
            if (e.target.nodeName === "ARTICLE") {
                $("#removeModal")[0].click()
            }
            if (e.target.id === "advancedSearch") {
                window.location.href =
                window.location.origin + arcs.baseURL + "search/advanced/" + projectURL
            }
            if (e.target.id === "help") {
                window.location.href =
                window.location.origin + arcs.baseURL + "help/searching"
            }
        })
    });

    //load in the collections.js.. the same one as multi_view
    var imported = document.createElement('script');
    imported.src = arcs.baseURL + "js/views/viewer/Multi/collection.js";
    document.head.appendChild(imported);

	var icon = arcs.baseURL + '/favicon.ico';
	$('head').append('<link rel="shortcut icon" href="'+icon+'" />');

	//fix the relative image references.
    $('.collectionModalClose').attr('src', arcs.baseURL + 'app/webroot/assets/img/Close.svg');

</script>
