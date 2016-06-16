<div class='searchIntro'>
    <h1>Advanced Search</h1>
    
    <p>Vommits food and eat it again leave fur on owners clothes purr for no reason shake treat bag lounge in doorway or make meme, make cute face. Run in circles if it fits, i sits but peer out window, chatter at birds, lure them to mouth damn that dog stick butt in face leave fur on owners clothes jump off balcony, onto stranger's head.</p>
</div>

<a name="searchJump"></a>

<div id="searchBoxAdvanced">
	<div class='searchBoxColumn'>
		<input type="text" class="searchBoxAdvanced" name="Coverage" placeholder="Coverage">
		<input type="text" class="searchBoxAdvanced" name="Date" placeholder="Date">
		<input type="text" class="searchBoxAdvanced" name="Description" placeholder="Description">
		<input type="text" class="searchBoxAdvanced" name="Identifier" placeholder="Identifier">
		<input type="text" class="searchBoxAdvanced" name="Location" placeholder="Location">
		<input type="text" class="searchBoxAdvanced" name="Subject" placeholder="Subject">
	</div>
	<div class='searchBoxColumn'>
		<input type="text" class="searchBoxAdvanced" name="Creator" placeholder="Creator">
		<input type="text" class="searchBoxAdvanced" name="DateModified" placeholder="Date - Modified">
		<input type="text" class="searchBoxAdvanced" name="Format" placeholder="Format">
		<input type="text" class="searchBoxAdvanced" name="Language" placeholder="Language">
		<input type="text" class="searchBoxAdvanced" name="Medium" placeholder="Medium">
		<input type='submit' onclick="toggle_search_visibility()" class='user-reg-btn btn btn-success searchButton' id="advanced_searchButton" value='Search'></input>
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
	  <ul class="flex-container">
	  		<!--<div class="resource-item-container">
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
	  		<div class="resource-item-container">
		  		<li class="flex-item">4</li>
		  		<div class="resource-title">Resource Title</div>
		  		<div class="resource-type">Resource Type</div>
		  		<div class="icon-flag search-icon-edit"></div>
		  	</div>
	  		<div class="resource-item-container">
		  		<li class="flex-item">5</li>
		  		<div class="resource-title">Resource Title</div>
		  		<div class="resource-type">Resource Type</div>
		  	</div>
	  		<div class="resource-item-container">
		  		<li class="flex-item">6</li>
		  		<div class="resource-title">Resource Title</div>
		  		<div class="resource-type">Resource Type</div>
		  	</div>
	  		<div class="resource-item-container">
		  		<li class="flex-item">7</li>
		  		<div class="resource-title">Resource Title</div>
		  		<div class="resource-type">Resource Type</div>
		  	</div>
	  		<div class="resource-item-container">
		  		<li class="flex-item">8</li>
		  		<div class="resource-title">Resource Title</div>
		  		<div class="resource-type">Resource Type</div>
		  	</div>
	  		<div class="resource-item-container">
		  		<li class="flex-item">9</li>
		  		<div class="resource-title">Resource Title</div>
		  		<div class="resource-type">Resource Type</div>
		  	</div>
	  		<div class="resource-item-container">
		  		<li class="flex-item">10</li>
		  		<div class="resource-title">Resource Title</div>
		  		<div class="resource-type">Resource Type</div>
		  	</div>
	  		<div class="resource-item-container">
		  		<li class="flex-item">11</li>
		  		<div class="resource-title">Resource Title</div>
		  		<div class="resource-type">Resource Type</div>
		  	</div>
	  		<div class="resource-item-container">
		  		<li class="flex-item">12</li>
		  		<div class="resource-title">Resource Title</div>
		  		<div class="resource-type">Resource Type</div>
		  	</div>-->
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
				<li><a href="#">1</a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
			</ul>
			<div id="search-again">
				<a class="search-again-link" href="#" onclick="movePage()">Search again</a>
			</div>
	  </div>
    <div id="search-pagination"></div>
    
  </div>
</div>

<script>
  arcs.searchView = new arcs.views.search.Search({
    el: $('.wrap')
  });
   
   function toggle_search_visibility() {
       var e = document.getElementById("search-results-wrapper");
       if(e.style.visibility == 'hidden')
       		console.log("hiiiiiiiiiiiii");
	   		e.style.visibility = 'visible';
    }
    
    function movePage() {
	    console.log("hiiiiiiGUH");
	    window.location.hash = "searchJump";
	    }
    
    /*$(document).ready(function () {
    $("li").click(function () {
        $('li > ul').not($(this).children("ul")).hide();
        $(this).children("ul").toggle();
    });
	});*/

  /* function for page numbers */
  $('.pageNumber').click(function(){
	  /* console.log(this.id); */
	  $('.pageNumber').removeClass('selected');
	  $(this).addClass('selected');
	  /* add functions here, use this.id to identify page number. */
  });

</script>
