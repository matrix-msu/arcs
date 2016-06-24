{% if user_collections and user_collections|length > 0 %}
  <div class="collection-list-wrapper">
    <h2>
      <img class="profile-image thumbnail" src="{{ profileSrc }}" width="100" height="100"/>
      Your Collections
    </h2>
	
    <div class="collection-list" id="user-collections"></div>
    <script>
      arcs.user_viewer = new arcs.views.CollectionList({
        model: arcs.models.Collection,
        collection: new arcs.collections.CollectionList({{ user_collections|json_encode }}),
        el: $('#user-collections')
	  	console.log("Josh- The first collection-list spot - apparently does nothing...");
      });
    </script>
  </div>
{% endif %}

<div class="collection-list-wrapper">
    <h1>Collections</h1><br>

  <div id='collections-filter' class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Filter By
  <span class="pointerDown filter-arrow"></span></button>
  <ul class="dropdown-menu">
    <li><a id="new-old" href="#">Newest to Oldest</a></li>
    <li><a id="old-new" href="#">Oldest to Newest</a></li>
    <li><a id="popular" href="#">Most Popular</a></li>
    <li><a id="author" href="#">Author</a></li>
    <li><a id="a-z" href="#">A-Z</a></li>
    <li><a id="z-a" href="#">Z-A</a></li>
  </ul>
</div>

  <div class="collection-list" id="all-collections"><div class="search-wrapper" id ="search-wrapper"></div></div>
  <script>
    arcs.user_viewer = new arcs.views.CollectionList({
      model: arcs.models.Collection,
      collection: new arcs.collections.CollectionList({{ collections|json_encode }}),
      el: $('#all-collections')
    });
	arcs.user_viewer.collection.each(function(model) {
		console.log("something happens here...");
		console.log(model);
	});
  </script>
<div class="collection-list-wrapper">

<script>
	//handles filter button click to display filter options
	$(document).ready(function() {
		var filter;
		$( "#new-old" ).trigger( "click" );

		console.log( window.location.search );
		//TODO scroll to nth collection and open the drawer.

		var item = window.location.search.substr(1);
		if(!isNaN(parseFloat(item)) && isFinite(item) && parseInt(item) <1) {
			$( "#all-collections" ).children("details:first").trigger("click");

		}else if(!isNaN(parseFloat(item)) && isFinite(item)) {
			var int_item = parseInt(item);
			int_item = int_item -1;
			var openedCollection =  $( "#all-collections" ).children("details").eq(int_item);
			console.log("openCollection here");
			console.log(openedCollection);
			$('html, body').animate({
				scrollTop: (openedCollection.offset().top)
			},500);
			$( "#all-collections" ).children("details").eq(int_item+1).trigger("click");

		}else {
			$( "#all-collections" ).children("details:first").trigger("click");
		}
	});


	//sorting scripts
	$("#new-old").click(function(e) {
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
	  arcs.user_viewer.collection.sortVar = '';
	  arcs.user_viewer.collection.sort();
	  arcs.user_viewer.render();
	  filter = $("#author");
	  $(".dropdown-menu a").each(function(item) {
	    $(this).css('font-weight','normal');
	  });
	  filter.css('font-weight', 'bold');
	});	
	$("#a-z").click(function(e) {
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

	$( window ).click(function() {
		if ( $( '#collections-filter' ).hasClass( 'open' ) == false && $( '.filter-arrow' ).hasClass( 'pointerUp' ) ) {
			$( '.filter-arrow' ).removeClass( 'pointerUp' );
			$( '.dropdown-toggle' ).removeClass( 'dropdown-open' );
		}
	});

</script>
