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
    console.log @search.query
    @renderDetails $('details:first')

  events:
    'click summary': 'onClick'

  onClick: (e) ->
    $el = $(e.currentTarget).parent()
    $el.toggleAttr('open')
    @renderDetails $el
    # Recent versions of webkit will toggle <details> automatically. 
    # Instead of checking for support, we'll just stop it from bubbling up, 
    # since we've just toggled it ourselves.
    e.preventDefault()
    false

  renderDetails: ($el) ->
    type = $el.data('type')
    query = encodeURIComponent(type)
    $.getJSON arcs.baseURL + "resources/search?n=12&q=#{query}", (response) ->
      html = arcs.tmpl 'home/details', 
        resources: response.results
      $el.children('div').html html
      console.log response.results