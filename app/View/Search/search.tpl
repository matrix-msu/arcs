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
</style>
<div class="viewers-container">
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
		<div id="search-actions" class="search-toolbar">
			<div id="sites-buttons" class="btn-group actions-left">
		      <button id="sites-btn" class="btn dropdown-toggle" data-toggle="dropdown">
		      	Projects
		      	<span class="pointerDown sort-arrow pointerSearch"></span>
		      </button>
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

		    <!--
			<div id="data-buttons" class="btn-group actions-left">
		      <button id="data-btn" class="btn dropdown-toggle" data-toggle="dropdown">
		      	Data
		      	<span class="pointerDown sort-arrow pointerSearch"></span>
		      </button>
		      <ul class="dropdown-menu">
		        <li><a class="sort-btn active" id="open-btn">Option 1&nbsp;</a></li>
		        <li><a class="sort-btn" id="open-colview-btn">Option 2&nbsp;</a></li>
		        <li><a class="sort-btn" id="open-btn">...&nbsp;</a></li>
		      </ul>
		    </div>
		    -->

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
		        <li><a class="sort-btn active" id="sort-title-btn">title&nbsp;
		          <i class="icon-ok"></i></a></li>
		        <li><a class="sort-btn" id="sort-modified-btn">modified&nbsp;</a></li>
		        <li><a class="sort-btn" id="sort-created-btn">created&nbsp;</a></li>
		        <li class="divider"></li>
		        <li><a class="dir-btn active" id="dir-asc-btn">ascending&nbsp;
		          <i class="icon-ok"></i></a></li>
		        <li><a class="dir-btn" id="dir-desc-btn">descending&nbsp;</a></li>
		      </ul>
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
</div>


