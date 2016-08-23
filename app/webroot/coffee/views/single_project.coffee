# collections.coffee
# ------------------
class arcs.views.SingleProject extends Backbone.View

  initialize: (options) ->
    _.extend @options, _.pick(options, 'model', 'collection', 'el')


  events:
    'click summary': 'onClick'
    'click details.closed': 'onClick'
    'click #delete-btn': 'deleteCollection'
    'click .btn-show-all': 'onClick'

  onClick: (e) ->
#Loads individual collections here----Josh
    if e.currentTarget.tagName == 'DETAILS'
      $el = $(e.currentTarget)
      if $el[0].hasAttribute("open")
        $el.children('div').html ''
        return
      limit = 1
      $el.toggleAttr('open')
      $el.toggleClass('closed').toggleClass('open')
      src = arcs.baseURL + 'img/arcs-preloader.gif'
      $(e.currentTarget).children().eq(2).prepend('<img src="'+src+'" alt="SeeAll.svg">')
    else if e.currentTarget.className == 'btn-show-all'
      $el = $(e.currentTarget).parent().parent().parent().parent()
      $(e.currentTarget).removeClass('btn-show-all')
      #$(e.currentTarget).parent().hide()
      src = arcs.baseURL + 'img/arcs-preloader.gif'
      $(e.currentTarget).find("img:first").attr('src', src);
      limit = 0
    else
      $el = $(e.currentTarget).parent()
      if $el[0].hasAttribute("open")
        $el.children('div').html ''
        return
      limit = 1
      $el.toggleAttr('open')
      $el.toggleClass('closed').toggleClass('open')
      src = arcs.baseURL + 'img/arcs-preloader.gif'
      if $(e.currentTarget).next().next().children().eq(0).prop("tagName") isnt 'IMG'
        $(e.currentTarget).next().next().prepend('<img src="'+src+'" alt="SeeAll.svg">')

    @renderDetails $el, limit
    # Recent versions of webkit will toggle <details> automatically.
    # Instead of checking for support, we'll just stop it from bubbling up,
    # since we've just toggled it ourselves.
    if (e.srcElement?)
      if (e.srcElement.tagName not in ['SPAN', 'BUTTON', 'I', 'A'])
        e.preventDefault()
        false

  render: () ->
    fullCollectionList = @collection.toJSON()
    fullCollectionList.reverse()

    @$el.html arcs.tmpl 'collections/list',
      collections: fullCollectionList
    @

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