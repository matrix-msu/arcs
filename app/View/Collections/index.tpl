<!-- Main Collections page. -->

<div class="collection-list-wrapper" >
    <h1 class="rsc-title">Collections</h1>
	{% if not user.loggedIn %}
	<p class="login_msg">You're viewing publicly available collections.
        You'll need to <a href=#loginModal>log in</a> to see the rest.
	</p>
    {% else %}
    <br />
	{% endif %}

	<div id='collections-filter' class="dropdown">
		<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Filter By
		<span class="pointerDown filter-arrow"></span></button>
		<ul class="dropdown-menu">
		<li><a id="new-old" href="#">Newest to Oldest</a></li>
		<li><a id="old-new" href="#">Oldest to Newest</a></li>
		<li><a id="popular" href="#">Most Popular</a></li>
		<li class="dropdown-submenu"><a id="author" class="author-arrow-toggle" href="#">Author
				<span class="pointerDown author-arrow" style="position:static"></span></a>
			<ul class="dropdown-menu" id="author-dropdown" style="left:100%;margin-top:-25px;">
				<!-- li><a class="author-filter" href="#">No Authors Available</a></li -->
				{{ authors }}
			</ul>
		</li>
		<li><a id="a-z" href="#">A-Z</a></li>
		<li><a id="z-a" href="#">Z-A</a></li>
		</ul>
	</div>

		<div class="collection-list" id="all-collections"></div>
	</div>
    <script>
        console.log('index collections');
        console.log({{collections|json_encode}});
        //fill in the collections list
        arcs.user_viewer = new arcs.views.CollectionList({
            model: arcs.models.Collection,
            collection: new arcs.collections.CollectionList({{ collections|json_encode }}),
            el: $('#all-collections')
        });
        console.log(arcs.user_viewer);
    </script>

<!-- Collections Pagination -->
		<div id='collection-bottom-bar'>
			<div id="collection-actions" class="search-toolbar">
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
				<div id="collection-pagination">
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
			</div>
		</div>
	

<script>
	//handles filter button click to display filter options
	$(document).ready(function() {
		var filter;
		$( "#new-old" ).trigger( "click" ); //default filter

		//attach the sorting script now that the html is there
		$(".author-filter").click(function(e) {
			var author = e.target.innerText;
			var authorCollection = [];
			{{ collections|json_encode }}.forEach(function (collection){
			if(author == collection.Collection.user_name){
				authorCollection.push(collection);
			}
		})
		var newList = new arcs.collections.CollectionList(authorCollection);
		newList.models.reverse();

		arcs.user_viewer.collection = newList;
		arcs.user_viewer.render();
		$("#author-dropdown").removeClass("open");
		$("#author-dropdown").addClass("second-open");
		filter = $("#author");
		$(".dropdown-menu a").each(function(item) {
			$(this).css('font-weight','normal');
		});
		filter.css('font-weight', 'bold');
		$(e.currentTarget).css('font-weight', 'bold');
	});

		//determin if the window needs to scroll to a specific collection
		//single/mult-resource and search can view a specific collection.
		//take the collection_id from the url
		
		var col_id = '';
		col_id = window.location.search.substr(1);
		var openCollection = $('#all-collections').find('details[data-id="'+col_id+'"]');
		
		if( col_id != '' ){
			//find where the collection is
			function collectionCheck(col){
				return col.Collection.collection_id == col_id;
			}
			var col_index = {{ collections|json_encode }}.findIndex(collectionCheck) + 1;
			
			//find the page it's on and go to it
			var item_per_page = $('#items-per-page-btn').html().substring(0,2);
			$('#'+Math.ceil(col_index/item_per_page)).trigger('click');
			openCollection = $('#all-collections').find('details[data-id="'+col_id+'"]');
			
			//scroll and click the collection
			if( openCollection.prev().length == 1 ){
				$('html, body').animate({
					scrollTop: (openCollection.prev().offset().top)
				},500);
			}
			$(openCollection).trigger('click');
		}else {
			$( "#all-collections" ).children("details:first").trigger('click');
		}
	});


	//sorting scripts
	$("#new-old").click(function(e) {
	  $("#author-dropdown").hide();
	  $("#author-dropdown").removeClass("second-open").removeClass("open");
	  arcs.user_viewer.collection = new arcs.collections.CollectionList({{ collections|json_encode }});
	  arcs.user_viewer.collection.sortVar = 'created';
	  arcs.user_viewer.collection.sort({silent:true});
	  arcs.user_viewer.collection.models = arcs.user_viewer.collection.models.reverse();
	  arcs.user_viewer.render();
	  filter = $("#new-old");
	  $(".dropdown-menu a").each(function(item) {
	    $(this).css('font-weight','normal');
	  });
	  filter.css('font-weight', 'bold');
	});	
	$("#old-new").click(function(e) {
	  $("#author-dropdown").hide();
	  $("#author-dropdown").removeClass("second-open").removeClass("open");
	  arcs.user_viewer.collection = new arcs.collections.CollectionList({{ collections|json_encode }});
	  arcs.user_viewer.collection.sortVar = 'created';
	  arcs.user_viewer.collection.sort({silent:true});
	  arcs.user_viewer.render();
	  filter = $("#old-new");
	  $(".dropdown-menu a").each(function(item) {
	    $(this).css('font-weight','normal');
	  });
	  filter.css('font-weight', 'bold');
	});	
	
	$("#popular").click(function(e) {
	  $("#author-dropdown").hide();
	  $("#author-dropdown").removeClass("second-open").removeClass("open");
	  arcs.user_viewer.collection = new arcs.collections.CollectionList({{ collections|json_encode }});
	  arcs.user_viewer.collection.sortVar = '';
	  arcs.user_viewer.collection.sort();
	  arcs.user_viewer.render();
	  filter = $("#popular");
	  $(".dropdown-menu a").each(function(item) {
	    $(this).css('font-weight','normal');
	  });
	  filter.css('font-weight', 'bold');
	});

	$("#author").click(function(e) {
		$("#author-dropdown").show();
		e.stopPropagation();
		e.preventDefault();
	});

	$("#a-z").click(function(e) {
	  $("#author-dropdown").hide();
	  $("#author-dropdown").removeClass("second-open").removeClass("open");
	  arcs.user_viewer.collection = new arcs.collections.CollectionList({{ collections|json_encode }});
	  arcs.user_viewer.collection.sortVar = 'title';
	  arcs.user_viewer.collection.sort();
	  arcs.user_viewer.render();
	  filter = $("#a-z");
	  $(".dropdown-menu a").each(function(item) {
	    $(this).css('font-weight','normal');
	  });
	  filter.css('font-weight', 'bold');
	});

	$("#z-a").click(function(e) {
	  console.log(arcs.user_viewer.collection.models);
	  $("#author-dropdown").hide();
	  $("#author-dropdown").removeClass("second-open").removeClass("open");
	  arcs.user_viewer.collection = new arcs.collections.CollectionList({{ collections|json_encode }});
	  arcs.user_viewer.collection.sortVar = 'title';
	  arcs.user_viewer.collection.sort();
	  arcs.user_viewer.collection.models = arcs.user_viewer.collection.models.reverse();
	  arcs.user_viewer.render();
	  filter = $("#z-a");
	  $(".dropdown-menu a").each(function(item) {
	    $(this).css('font-weight','normal');
	  });
	  filter.css('font-weight', 'bold');
	});	

	$( '.dropdown-toggle' ).click(function() {
	  $( '.filter-arrow' ).toggleClass( 'pointerUp' );
	  $( '.dropdown-toggle' ).toggleClass( 'dropdown-open' );
	});

	$( '.author-arrow-toggle' ).click(function() {
		$( '.author-arrow' ).toggleClass( 'pointerUp' );
		$( '#author-dropdown' ).toggleClass( 'open' );
		$("#author-dropdown").toggleClass("second-open");
		if ( $("#author-dropdown").hasClass("second-open")){
			$("#author-dropdown").show();
		}else{
			$("#author-dropdown").hide();
		}
	});

	$( window ).click(function() {
		if ( $( '#collections-filter' ).hasClass( 'open' ) == false && $( '.filter-arrow' ).hasClass( 'pointerUp' ) ) {
			$( '.filter-arrow' ).removeClass( 'pointerUp' );
			$( '.dropdown-toggle' ).removeClass( 'dropdown-open' );
			if ( $("#author-dropdown").hasClass("open")){
				$("#author-dropdown").hide();
				$( '.author-arrow' ).removeClass( 'pointerUp' );
				$( '#author-dropdown' ).removeClass( 'open' );
				$("#author-dropdown").removeClass("second-open");
			}
		}

	});

</script>
