<button id="new-old">Newest</button>
<button id="old-new">Oldest</button>
<button id="a-z">A-Z</button>
<button id="z-a">Z-A</button>


{% if user_collections and user_collections|length > 0 %}
  <div class="collection-list-wrapper">
    <h2>
      <img class="profile-image thumbnail" 
        src="http://gravatar.com/avatar/{{ user.gravatar }}?s=50"/>
      Your Collections
    </h2>
	<div id="filter">
		<p>FILTER BY</p>
	</div>
    <div class="collection-list" id="user-collections"></div>
    <script>
      arcs.user_viewer = new arcs.views.CollectionList({
        model: arcs.models.Collection,
        collection: new arcs.collections.CollectionList({{ user_collections|json_encode }}),
        el: $('#user-collections')
      });
    </script>
  </div>
{% endif %}

<div class="collection-list-wrapper">
    <h1>Collections</h1>
	<div id="filter">
		<p>FILTER BY</p>
	</div>
  <div class="collection-list" id="all-collections"></div>
  <script>
    arcs.user_viewer = new arcs.views.CollectionList({
      model: arcs.models.Collection,
      collection: new arcs.collections.CollectionList({{ collections|json_encode }}),
      el: $('#all-collections')
    });
  </script>
<div class="collection-list-wrapper">

<script>
	//sorting scripts
	$("#new-old").click(function(e) {
	  arcs.user_viewer.collection.sortVar = 'created';
	  arcs.user_viewer.collection.sort({silent:true});
	  arcs.user_viewer.collection.models = arcs.user_viewer.collection.models.reverse();
	  arcs.user_viewer.render();
	});	
	$("#old-new").click(function(e) {
	  arcs.user_viewer.collection.sortVar = 'created';
	  arcs.user_viewer.collection.sort({silent:true});
	  arcs.user_viewer.render();
	});	
	
	$("#most-popular").click(function(e) {
	  arcs.user_viewer.collection.sortVar = '';
	  arcs.user_viewer.collection.sort();
	  arcs.user_viewer.render();
	});	
	$("#author").click(function(e) {
	  arcs.user_viewer.collection.sortVar = '';
	  arcs.user_viewer.collection.sort();
	  arcs.user_viewer.render();
	});	
	$("#a-z").click(function(e) {
	  arcs.user_viewer.collection.sortVar = 'title';
	  arcs.user_viewer.collection.sort();
	  arcs.user_viewer.render();
	});	
	$("#z-a").click(function(e) {
	  arcs.user_viewer.collection.sortVar = 'title';
	  arcs.user_viewer.collection.sort();
	  arcs.user_viewer.collection.models = arcs.user_viewer.collection.models.reverse();
	  arcs.user_viewer.render();
	});	
</script>
