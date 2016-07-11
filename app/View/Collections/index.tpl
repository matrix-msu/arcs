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
    <li class="dropdown-submenu"><a id="author" class="author-arrow-toggle" href="#">Author
			<span class="pointerDown author-arrow" style="position:static"></span></a>
		<ul class="dropdown-menu" id="author-dropdown" style="left:100%;margin-top:-25px;">
			<li><a class="author-filter" href="#">Author 1</a></li>
			<li><a class="author-filter" href="#">Author 2</a></li>
			<li><a class="author-filter" href="#">Author 3</a></li>
		</ul>
	</li>
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
		//console.log("something happens here...");
		//console.log(model);
	});
  </script>
<div class="collection-list-wrapper">

<script>
	//handles filter button click to display filter options
	$(document).ready(function() {
		var filter;
		$( "#new-old" ).trigger( "click" );

		//console.log( window.location.search );

		//Get distinct author names for the author filter
		$.ajax({
			url: arcs.baseURL + "collections/distinctUsers",
			type: "get",
			//data: "",
			success: function (data) {
				//console.log("ajax success");
				//console.log(data);
				var populateAuthors = "";
				data.forEach(function (tempdata) {
					//console.log(tempdata.Collection.user_name);
					populateAuthors += '<li><a class="author-filter" href="#">'+ tempdata.Collection.user_name +'</a></li>';
				})
				//fill in the html of the authors dropdown menu
				//console.log(populateAuthors);
				$("#author-dropdown").html(populateAuthors);

				//attach the sorting script now that the html is there
				$(".author-filter").click(function(e) {
					//console.log("author filter click");
					//console.log(e.target.innerText);
					var author = e.target.innerText;
					var authorCollection = [];
					{{ collections|json_encode }}.forEach(function (collection){
						//console.log(collection.Collection.user_name);
						if(author == collection.Collection.user_name){
							authorCollection.push(collection);
						}
					})
					//authorCollection.reverse();
					//console.log("author collections here");
					//console.log(authorCollection);
					var newList = new arcs.collections.CollectionList(authorCollection);
					newList.models.reverse();
					//arcs.author_viewer = new arcs.views.CollectionList({
					//	model: arcs.models.Collection,
					//	collection: newList,
					//	el: $('#all-collections')
					//});
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
			}
		});

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
		//$("#author-dropdown").addClass("open");
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
