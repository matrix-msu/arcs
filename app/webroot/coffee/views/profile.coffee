class arcs.views.Profile extends Backbone.View

  initialize: (options) ->
    _.extend @options, _.pick(options, 'model', 'collection', 'el')

    #console.log("collection list initialize2");
    #first loads the collection list here.... -Josh
    @search = new arcs.utils.Search
      container: $('.search-wrapper')
      run: false
      onSearch: =>
        location.href = arcs.url 'search', @search.query
    #@render()
    @$('details.open').each (i, el) =>
      @renderDetails $(el)

  events:
    'click #edit-profile': 'editAccount'
    'click summary': 'onClick'
    'click details.closed': 'onClick'
    'click #delete-btn': 'deleteCollection'
    'click .btn-show-all': 'onClick'


  editAccount: ->
    new arcs.views.Modal
      title: 'Edit Your Account'
      subtitle: "If you'd like your password to stay the same, leave the " +
        "password field blank."
      inputs:
        name:
          value: @model.get 'name'
        username:
          value: @model.get 'username'
        email:
          value: @model.get 'email'
        password:
          type: 'password'
      buttons:
        save:
          validate: true
          class: 'btn btn-success'
          callback: (vals) =>
            if vals.password == ''
              delete vals.password
            arcs.loader.show()
            @model.save vals,
              success: (model, response, options) ->
                arcs.loader.hide()
                return
              error: (model, response, options) ->
                arcs.loader.hide() # this is very finicky and returns when the request succeeds
                return
        cancel: ->

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
      $(e.currentTarget).removeClass('btn-show-all')
      #$(e.currentTarget).parent().hide()
      src = arcs.baseURL + 'img/arcs-preloader.gif'
      $(e.currentTarget).find("img:first").attr('src', src);
      limit = 0
    else
      $el = $(e.currentTarget).parent()
      limit = 1
      $el.toggleAttr('open')
      $el.toggleClass('closed').toggleClass('open')
      src = arcs.baseURL + 'img/arcs-preloader.gif'
      if $(e.currentTarget).next().children().eq(0).prop("tagName") isnt 'IMG'
        $(e.currentTarget).next().prepend('<img src="'+src+'" alt="SeeAll.svg">')
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

  #render: ->
  # console.log @$el
  #console.log "Josh Test Here1"
  #@$el.html arcs.tmpl 'collections/list',
  # collections: @collection.toJSON()
  #@

  #Josh- collections fills in the template here!!
  renderDetails: ($el, limit) ->
    id = $el.data 'id'
    query = encodeURIComponent('collection_id:"' + id + '"')
    query2 = arcs.baseURL + "resources/search?"
    if (limit == 1)
      query2 += "n=15&"
    console.log('url testing here')
    console.log(arcs.baseURL)
    console.log(query2 + "q=#{query}")
    $.getJSON query2 + "q=#{query}", (response) ->
      $el.children('.results').html arcs.tmpl 'home/details',
        resources: response.results
        searchURL: arcs.baseURL + "collection/#{id}"
