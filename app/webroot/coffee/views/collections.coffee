# collections.coffee
# ------------------
class arcs.views.CollectionList extends Backbone.View

  initialize: (options) ->
    _.extend @options, _.pick(options, 'model', 'collection', 'el')

    #console.log("collection list initialize2");
    #first loads the collection list here.... -Josh
    @search = new arcs.utils.Search
      container: $('.search-wrapper')
      run: false
      onSearch: =>
        location.href = arcs.url 'search', @search.query
    @render()
    @$('details.open').each (i, el) =>
      @renderDetails $(el)

  events:
    'click summary': 'onClick'
    'click details.closed': 'onClick'
    'click #delete-btn': 'deleteCollection'
    'click .btn-show-all': 'onClick'

  onClick: (e) ->
    #Loads individual collections here----Josh
    console.log("Clicked here.");
    console.log(e.currentTarget.tagName);
    if e.currentTarget.tagName == 'DETAILS'
      $el = $(e.currentTarget)
      limit = 1
      $el.toggleAttr('open')
      $el.toggleClass('closed').toggleClass('open')
    else if e.currentTarget.className == 'btn-show-all'
      $el = $(e.currentTarget).parent().parent().parent().parent()
      $(e.currentTarget).parent().hide()
      limit = 0
    else
      $el = $(e.currentTarget).parent()
      limit = 1
      $el.toggleAttr('open')
      $el.toggleClass('closed').toggleClass('open')
    console.log($el)
    @renderDetails $el, limit
    # Recent versions of webkit will toggle <details> automatically. 
    # Instead of checking for support, we'll just stop it from bubbling up, 
    # since we've just toggled it ourselves.
    if (e.srcElement?)
      if (e.srcElement.tagName not in ['SPAN', 'BUTTON', 'I', 'A'])
        e.preventDefault()
        false

  deleteCollection: (e) ->
    e.preventDefault()
    $parent = $(e.currentTarget).parents 'details'
    id = $parent.data 'id'
    model = @collection.get id
    
    arcs.confirm "Are you sure you want to delete this collection?",
      "<p>Collection <b>#{model.get('title')}</b> will be " +
      "deleted. <p><b>N.B.</b> Resources within the collection will not be " +
      "deleted. They may still be accessed from other collections to which they " +
      "belong.", =>
        arcs.loader.show()
        $.ajax
          url: arcs.url 'collections', 'delete', model.id
          type: 'DELETE'
          success: =>
            @collection.remove(model, silent: true)
            @render()
            arcs.loader.hide()

  render: ->
    console.log @$el
    console.log "Josh Test Here1"
    @$el.html arcs.tmpl 'collections/list',
      collections: @collection.toJSON()
    @

#Josh- collections fills in the template here!!
  renderDetails: ($el, limit) ->
    id = $el.data 'id'
    query = encodeURIComponent('collection_id:"' + id + '"')
    query2 = arcs.baseURL + "resources/search?"
    if (limit != 0)
      query2 += "n=15&"
    $.getJSON query2 + "q=#{query}", (response) ->
      $el.children('.results').html arcs.tmpl 'home/details',
        resources: response.results
        searchURL: arcs.baseURL + "collection/#{id}"
