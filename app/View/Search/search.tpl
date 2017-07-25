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

<article id="pageHelpModal">
  <div>

    <p class="modal-title">Advanced Search</p>
    This Search Text has yet to be supplied. Basic Search conducts a keyword
    search over words included in the Title, Creator, Description, Subject, and
    Transcript fields of materials in the repository.
    <p>
      Basic Search works best for whole words. It is not case sensitive, so the search
      terms can be entered in upper or lower case.
    </p>
    <p>
      Multi-word Basic Searches
      Entering more than one word in the Basic Search box results in a search where
      ALL words in the query are present in ANY of the Basic Search fields. A search
      for Wesley Fishel will return records where both "Wesley" AND "Fishel" appear
      in the Title OR Creator OR Description OR Subject OR Transcript field.
    </p>
    <p>
      To speed up searches, punctuation and common short function words have been
      removed from the search. These stop words include:
    </p>
    <p>
      a, about, above, above, across, after, afterwards, again, against, all,
      almost, alone, along, already, also, although, always, am, among, amongst,
      amoungst, amount, an, and, another, any, anyhow, anyone, anything, anyway,
      anywhere, are, around, as, at, back, be, became, because, become, becomes,
      becoming, been, before, beforehand, behind, being, below, beside, besides,
      between, beyond, bill, both, bottom, but, by, call, can, cannot, cant, co,
      con, could, couldn't, cry, de, describe, detail, do, done, down, due,
      during, each, eg, eight, either, eleven, else, elsewhere, empty, enough,
      etc, even, ever, every, everyone, everything, everywhere, except, few,
      fifteen, fifty, fill, find, fire, first, five, for, former, formerly,
      forty, found, four, from, front, full, further, get, give, go, had, has,
      hasn't, have, he, hence, her, here, hereafter, hereby, herein, hereupon, hers,
      herself, him, himself, his, how, however, hundred, ie, if, in, inc, indeed,
      interest, into, is, it, its, itself, keep, last, latter, latterly, least,
      less, ltd, made, many, may, me, meanwhile, might, mill, mine, more, moreover,
      most, mostly, move, much, must, my, myself, name, namely, neither, never, nevertheless,
      next, nine, no, nobody, none, no one, nor, not, nothing, now, nowhere, of, off, often,
      on, once, one, only, onto, or, other, others, otherwise, our, ours, ourselves, out, over,
      own, part, per, perhaps, please, put, rather, re, same, see, seem, seemed, seeming,
      seems, serious, several, she, should, show, side, since, sincere, six, sixty, so,
      some, somehow, someone, something, sometime, sometimes, somewhere, still, such,
    </p>
    <p>
      a, about, above, above, across, after, afterwards, again, against, all,
      almost, alone, along, already, also, although, always, am, among, amongst,
      amoungst, amount, an, and, another, any, anyhow, anyone, anything, anyway,
      anywhere, are, around, as, at, back, be, became, because, become, becomes,
      becoming, been, before, beforehand, behind, being, below, beside, besides,
      between, beyond, bill, both, bottom, but, by, call, can, cannot, cant, co,
      con, could, couldn't, cry, de, describe, detail, do, done, down, due,
      during, each, eg, eight, either, eleven, else, elsewhere, empty, enough,
      etc, even, ever, every, everyone, everything, everywhere, except, few,
      fifteen, fifty, fill, find, fire, first, five, for, former, formerly,
      forty, found, four, from, front, full, further, get, give, go, had, has,
      hasn't, have, he, hence, her, here, hereafter, hereby, herein, hereupon, hers,
      herself, him, himself, his, how, however, hundred, ie, if, in, inc, indeed,
      interest, into, is, it, its, itself, keep, last, latter, latterly, least,
      less, ltd, made, many, may, me, meanwhile, might, mill, mine, more, moreover,
      most, mostly, move, much, must, my, myself, name, namely, neither, never, nevertheless,
      next, nine, no, nobody, none, no one, nor, not, nothing, now, nowhere, of, off, often,
      on, once, one, only, onto, or, other, others, otherwise, our, ours, ourselves, out, over,
      own, part, per, perhaps, please, put, rather, re, same, see, seem, seemed, seeming,
      seems, serious, several, she, should, show, side, since, sincere, six, sixty, so,
      some, somehow, someone, something, sometime, sometimes, somewhere, still, such,
    </p>
  </div>
</article>
<a id="removeModal" href="#"></a>

<div class="viewers-container">
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

<div class='searchIntro'>
    <h1>
      Keyword Search
      <a id="page-help" href="#pageHelpModal">?</a>
    </h1>

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
	<div class="SearchBar ">
		<div class="mobile-filter-opt"> open filter options</div>
		<div id="search-actions" class="search-toolbar">
			<div class="tool-bar-results hideSearchBars">
			<div id="sites-buttons" class="btn-group actions-left hiddenProject">
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
    $(document).ready(function() {
        $("#pageHelpModal").click(function(e) {
            if (e.target.nodeName === "ARTICLE") {
                $("#removeModal")[0].click()
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
