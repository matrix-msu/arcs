<style media="screen">
.push{
  height: 0px;
}
.wrap {
    min-height: 100%;
    padding-top: 60px !important;
    padding-bottom: 0px;
}
@media screen and (max-width: 780px) {
  .searchBoxColumn{
    width: 100% !important;
    display: block !important;

  }
}
</style>
<div class='searchIntro'>
    <h1>Advanced Search</h1>
    <p>
      Lorem ipsum dolor sit amet, ignota consetetur quo at, augue accumsan efficiendi ut usu. Dictas eripuit albucius mea in, ex officiis philosophia eum. Consul singulis ad pro, te saperet contentiones qui. Ne has reque temporibus, saepe quaerendum temporibus cum ei.
    </p>
</div>

<a name="searchJump"></a>

<div id="searchBoxAdvanced">
	<div class='searchBoxColumn'>
		<input type="text" class="searchBoxAdvanced" name="Coverage" 		id="Coverage"		placeholder="Coverage">
		<input type="text" class="searchBoxAdvanced" name="Date" 			id="Date"			placeholder="Date">
		<input type="text" class="searchBoxAdvanced" name="Description" 	id="Description"	placeholder="Description">
		<input type="text" class="searchBoxAdvanced" name="Identifier" 		id="Identifier"		placeholder="Identifier">
		<input type="text" class="searchBoxAdvanced" name="Location" 		id="Location"		placeholder="Location">
		<input type="text" class="searchBoxAdvanced" name="Subject" 		id="Subject"		placeholder="Subject">
	</div>
	<div class='searchBoxColumn'>
		<input type="text" class="searchBoxAdvanced" name="Creator" 		id="Creator"		placeholder="Creator">
		<input type="text" class="searchBoxAdvanced" name="DateModified" 	id="DateModified"	placeholder="Date - Modified">
		<input type="text" class="searchBoxAdvanced" name="Format" 			id="Format" 		placeholder="Format">
		<input type="text" class="searchBoxAdvanced" name="Language" 		id="Language" 		placeholder="Language">
		<input type="text" class="searchBoxAdvanced" name="Medium" 			id="Medium" 		placeholder="Medium">
		<input type='submit' class='user-reg-btn btn btn-success searchButton' id="advanced_search_button" value='Search'></input>
	</div>
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
		      	Creator
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
	  <ul class="flex-container">

		</ul>
  </div>

  <div id='search-bottom-bar'>
	  <div id="search-actions" class="search-toolbar">
		  <div id="items-per-pages-buttons" class="btn-group actions-left">
			  <button id='items-per-page-btn' class='btn dropdown-toggle' data-toggle='dropdown'>20 Items per Page
				  <span class='pointerDown sort-arrow pointerSearch'></span>
			  </button>
			  <ul class="dropdown-menu">
				  <li><a class="sort-btn" id="open-btn">20 Items per Page&nbsp;</a></li>
				  <li><a class="sort-btn" id="open-colview-btn">40 Items per Page&nbsp;</a></li>
				  <li><a class="sort-btn" id="open-btn">60 Items per Page&nbsp;</a></li>
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
				<a class="search-again-link" href="#" onclick="movePage()">Search again</a>
			</div>
	  </div>
    <div id="search-pagination"></div>

  </div>
</div>

<script>
	arcs.searchView = new arcs.views.advanced_search.AdvancedSearch({
		el: $('.wrap')
	});

</script>
