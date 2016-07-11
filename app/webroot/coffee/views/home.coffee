# home.coffee
# -----------
class arcs.views.Home extends Backbone.View

  initialize: (options) ->
    _.extend @options, _.pick(options, "el")
    @search = new arcs.utils.Search
      container: $('.search-wrapper')
      run: false
      onSearch: =>
        location.href = arcs.url 'search', @search.query
    $('details:first').children().eq(0).trigger("click");

  events:
    'click summary': 'onClick'
    'click .btn-show-all': 'onClick'

  onClick: (e) ->
    console.log(e.currentTarget.tagName);
    if e.currentTarget.tagName == 'SUMMARY'
      $el = $(e.currentTarget).parent()
      $el.toggleAttr('open')
      limit = 1
      src = arcs.baseURL + 'img/arcs-preloader.gif'
      $(e.currentTarget).next().prepend('<img src="'+src+'" alt="SeeAll.svg">')
    else if e.currentTarget.className == 'btn-show-all'
      $el = $(e.currentTarget).parent().parent().parent().parent()
      $(e.currentTarget).removeClass('btn-show-all')
      #$(e.currentTarget).parent().hide()
      src = arcs.baseURL + 'img/arcs-preloader.gif'
      $(e.currentTarget).find("img:first").attr('src', src);
      limit = 0
    else
      $el = $(e.currentTarget).parent()
      $el.toggleAttr('open')
      limit = 0
    @renderDetails $el, limit
    # Recent versions of webkit will toggle <details> automatically. 
    # Instead of checking for support, we'll just stop it from bubbling up, 
    # since we've just toggled it ourselves.
    e.preventDefault()
    false

  renderDetails: ($el, limit) ->
    type = $el.data('type')
    query = encodeURIComponent("Type,=,"+type)
    query2 = arcs.baseURL + "resources/search?"
    if (limit != 0)
      query2 += "n=15&"
    #console.log('found the coffee render')
    $.getJSON query2 + "q=#{query}", (response) ->
      html = arcs.tmpl 'home/details', 
        resources: response.results
        searchURL: arcs.baseURL + "collection/"
      $el.children('div').html html