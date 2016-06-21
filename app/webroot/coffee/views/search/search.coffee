# search.coffee
# -------------
# Search View. Select and perform bulk actions on search results.
arcs.views.search ?= {}
class arcs.views.search.Search extends Backbone.View

  options:
    sort: 'title'
    sortDir: 'asc'
    grid: true
    url: arcs.baseURL + 'search/'

  ### Initialize and define events ###

  initialize: (options) ->
    _.extend @options, _.pick(options, 'el')
    @setupSelect()
    @setupSearch()

    # Init our sub-view for actions.
    #@actions = new arcs.views.search.Actions
    #  el: @$el
    #  collection: @search.results

    # Setup our Router
    #router = new arcs.routers.Search
    #search: @search
    #console.log(router)

    # Start Backbone.history
    Backbone.history.start
      pushState: true
      root: @options.url

    # Search unless the Router already delegated it.
    #unless @router.searched 
    #  @search.run null,
    #    order: @options.sort
    #    direction: @options.sortDir

    # Set up some event bindings.
    @search.results.on 'change remove', @render, @
    arcs.bus.on 'selection', @afterSelection, @

    # <ctrl>-a to select all
    arcs.keys.map @,
      'ctrl+a': @selectAll
#'return': @search()
      '?': @showHotkeys
      t: @scrollTop

    @setupHelp()

  events:

#'click img'                : 'toggle' # Click on the image to select, conflicts with select button
#'click .result'            : 'maybeUnselectAll' # Click on the container to deselect, conflicts with select button
#'click #search-results'    : 'maybeUnselectAll' # Click on the whitespace to deselect, conflicts with select button
    'click #grid-btn'          : 'toggleView'
    'click #list-btn'          : 'toggleView'
    'click #top-btn'           : 'scrollTop'
#    'click .sort-btn'          : 'setSort'
    'click .dir-btn'           : 'setSortDir'
    'click .search-page-btn'   : 'setPage'
    'click .search-type'       : 'addFacet'
    'click .pageNumber'        : 'scrollTop'
    'click #leftArrowBox'        : 'scrollTop'
    'click #rightArrowBox'        : 'scrollTop'
    'click .sort-btn'        : 'scrollTop'

  ### More involved setups run by the initialize method ###

# Set up drag-to-select, using jQuery.ui.selectable
  setupSelect: ->
    @$el.find('#search-results').selectable
# Little bit of drag tolerance
      distance: 20
# Images are the selectables
      filter: '.img-wrapper img'
# Make jQuery UI call our selection methods.
      selecting: (e, ui) =>
        $(ui.selecting).parents('.result').addClass('selected')
        $(ui.selecting).parents('.result').children('.select-button').html 'DE-SELECT'
        $(ui.selecting).parents('.result').children('.select-button').addClass 'de-select'
        @afterSelection()
      selected: (e, ui) =>
        $(ui.selected).parents('.result').addClass('selected')
        $(ui.selected).parents('.result').children('.select-button').html 'DE-SELECT'
        $(ui.selected).parents('.result').children('.select-button').addClass 'de-select'
        @afterSelection()
      unselecting: (e, ui) =>
        $(ui.unselecting).parents('.result').removeClass('selected')
        $(ui.unselecting).parents('.result').children('.select-button').html 'SELECT'
        $(ui.unselecting).parents('.result').children('.select-button').removeClass 'de-select'
        @afterSelection()
      unselected: (e, ui) =>
        $(ui.unselected).parents('.result').removeClass('selected')
        $(ui.unselected).parents('.result').children('.select-button').html 'SELECT'
        $(ui.unselected).parents('.result').children('.select-button').removeClass 'de-select'
        @afterSelection()

# Make an instance of our Search utility and setup endless scrolling.
  setupSearch: ->
    @scrollReady = false
    @search = new arcs.utils.Search
      container: $('searchBox')
      order: @options.sort
      run: false
      loader: true
# This callback will be fired each time a search is done.
      success: =>
        console.log("#{encodeURIComponent(@search.query)}/p#{@search.page}")
        @router.navigate "#{encodeURIComponent(@search.query)}/p#{@search.page}"
        # Setup the endless scroll unless it's already been done.
        @setupScroll() and @scrollReady = true unless @scrollReady
        @setupHelp()
        @render()

# Setup the endless scroll. This is called after we've received our first set
# of results.
  setupScroll: ->
    [$actions, $results] = [@$('#search-actions'), @$('#search-results')]
    $window = $(window)
    pos = $actions.offset().top - 10

    ##    $window.scroll =>
    ##      # Toggle the toolbar's fixed position
    ##      if $window.scrollTop() > pos
    ##        $actions.addClass('toolbar-fixed').width $results.width() + 22
    ##      else
    ##        $actions.removeClass('toolbar-fixed').width 'auto'

    # Fix the toolbar width on resizes. 
    $window.resize ->
      $actions.width($results.width() + 23) if $window.scrollTop() > pos

  setupHelp: ->
    unless $('.search-help-btn').length
      $('.VS-search-inner').append(arcs.tmpl 'search/help-toggle')
      $('.search-help-btn').click(@showHelp)
      $('.search-help-close').click(@closeHelp)

# Toggle between list and grid view.
  toggleView: ->
    @options.grid = !@options.grid
    @$('#grid-btn').toggleClass 'active'
    @$('#list-btn').toggleClass 'active'
    @render()

# Scroll to the top of the page.
  scrollTop: ->
# The animation time should be relative to our position on the page.
    time = ($(window).scrollTop() / $(document).height()) * 1000
    $('html, body').animate {scrollTop: 0}, time

# Set the search sort (a.k.a. order). This triggers a new search
# and subsequent render.
  setSort: (e) ->
    @options.sort = e.target.id.match(/sort-(\w+)-btn/)[1]
    @$('.sort-btn .icon-ok').remove()
    @$(e.target).append @make 'i', class: 'icon-ok'
    @$('#sort-btn span#sort-by').html @options.sort
    console.log(("SEARCHING"))
    @search.run null,
      order: @options.sort
      direction: @options.sortDir

# Set the search sort direction--either 'asc' or 'desc'.
  setSortDir: (e) ->
    @options.sortDir = e.target.id.match(/dir-(\w+)-btn/)[1]
    @$('.dir-btn .icon-ok').remove()
    @$(e.target).append @make 'i', class: 'icon-ok'
    @search.run null,
      order: @options.sort
      direction: @options.sortDir

# Set the current search result page
  setPage: (e) ->
    e.preventDefault()
    @$el = $(e.currentTarget)
    @search.options.page = @$el.data('pageNumber')
    @search.run()

  unselectAll: (trigger=true) ->
    @$('.result').removeClass('selected')
    @$('.select-button').removeClass('de-select')
    @$('.select-button, #toggle-select').html('SELECT')
    @$('#deselect-all').attr id: 'select-all'
    arcs.bus.trigger 'selection' if trigger

  selectAll: (trigger=true) ->
    @$('.result').addClass('selected')
    @$('.select-button').addClass('de-select')
    @$('.select-button, #toggle-select').html('DE-SELECT')
    @$('#select-all').attr id: 'deselect-all'
    arcs.bus.trigger 'selection' if trigger

# Select a result and unselect everything else, unless a modifier key
# is pressed.n
  toggle: (e) ->
# If <ctrl> <shift> or <meta> is pressed allow multi-select
    if not (e.ctrlKey or e.shiftKey or e.metaKey)
      @unselectAll false
    $(e.currentTarget).parents('.result').toggleClass('selected')
    arcs.bus.trigger 'selection'

# Unselect all results unless a modifier key is held down, or
# the target isn't right.
  maybeUnselectAll: (e) ->
# If e is not an Event object, do it.
    return @unselectAll() unless e instanceof jQuery.Event
    # If one of the modifier keys is held down, we won't do anything.
    return false if (e.metaKey or e.ctrlKey or e.shiftKey)
    # If the target is the image, we won't do anything.
    return false if $(e.target).attr 'src'
    @unselectAll()

  showHotkeys: ->
    return $('.hotkeys-modal').remove() if $('.hotkeys-modal').length
    new arcs.views.Hotkeys template: 'search/hotkeys'

  showHelp: ->
    $('.search-help').show()

  closeHelp: ->
    $('.search-help').hide()

  ### Render the search results ###

# Syncs selection states between the ResultSet and the DOM elements that
# represent them. Uses Underscore's defer to wait for the call stack to
# clear.
  afterSelection: ->
    _.defer =>
      selected = $('.result.selected').map( -> $(@).data('id')).get()
      console.log("coffee selected")
      console.log(selected)
      arcs.selected = selected
      $('#selected-resource-ids').html(selected)
      # get the count of the selected items, change the style accordingly
      num = $('.result.selected').length
      $('#selected-count').html(num)
      if (num != 0)
        $('#selected-all').css({color:'black'})
      else
        $('#selected-all').css({color:'#C1C1C1'})

      @search.results.unselectAll()
      @search.results.select selected if selected.length
      if @search.results.anySelected()
        $('.btn.needs-resource').removeClass 'disabled'
        # Blur the search input(s), so that hotkeys work as expected.
        $('#search input').blur()
      else
        $('.btn.needs-resource').addClass 'disabled'

  $('.dropdown-menu').change (event) ->
    console.log(("Dropdown select"))

  # Append more results. 
  #
  # We do this instead of a full render to stop the scrollbar from jumping in
  # certain browsers.
  append: ->
    return unless @search.results.length > @search.options.n
    results = new arcs.collections.ResultSet @search.getLast()
    @_render results: results.toJSON(), true
  addFacet: (e) ->
    e.preventDefault()
    @search.vs.searchBox.addFacet(e.target.text,'',10)


#Create an array of the page numbers. Still needs to handle when there are less than five pages
  fillArray = (page,lastPage) ->
    if page < 3
      page = 3
    if page is lastPage
      page = page-2
    if page is lastPage-1
      page = page-1
    i=-1
    while i < 4
      i++
      if  (page + (i-2)) <= lastPage
        page + (i-2)
      else
        0

  pagination = (pageArray, currentPage, lastPage) ->
    if 1 in pageArray
      $('#firstPage').css('display', 'none')
      $('.fDots').css('display', 'none')
    else
      $('#firstPage').css('display', 'block')
      $('.fDots').css('display', 'block')
    if 1 is currentPage
      $('#rightArrow').css('display', 'none')
    else
      $('#rightArrow').css('display', 'block')
    if lastPage in pageArray
      $('#lastPage').css('display', 'none')
      $('.dots').css('display', 'none')
      $('#leftArrow').css('display', 'none')
    else
      $('#lastPage').css('display', 'block')
      $('.dots').css('display', 'block') 
      $('#leftArrow').css('display', 'block')
    if currentPage is lastPage
      $('#lefttArrow').css('display', 'none')
    else
      $('#leftArrow').css('display', 'block')
    for i in [1..5]
#      console.log("Array contents: "+pageArray[i-1]+" i: "+ i)
      if pageArray[i-1] is 0
#        console.log("undifined")
        $('#'+i).css('display', 'none')
      else
        $('#'+i).css('display', 'block')
        $('#'+i).html(pageArray[i-1])
        if parseInt($('#'+i).html()) is currentPage
          $('#'+i).addClass('selected')
	
  #MULTIPROJECT SEARCH
  search = () ->
    $('.flex-img').removeClass('selected')
    val = $(".searchBoxInput").val()
    pageNum = $('.selected').html()
    perPage = $('#items-per-page-btn').html().substring(0,2)
#    console.log(perPage)
    $('.pageNumber').removeClass('selected')
    resources = new Promise((resolve, reject) ->
      resourcequery = encodeURIComponent("#{val}")
      pageNumber= encodeURIComponent("#{pageNum}")
      perPageUrl = encodeURIComponent("#{perPage}")
      req = $.getJSON arcs.baseURL + 'simple_search/' + resourcequery + "/" +pageNumber + "/" + perPageUrl, (response) ->
#        console.log(response)
#        console.log("Current page: "+pageNum+", "+"Number of total pages: "+response['pages'])
        $('#lastPage').html(response['pages'])
        temp = fillArray(parseInt(pageNum),parseInt(response['pages']))
#        console.log(temp)
        pagination(temp,parseInt(pageNum), parseInt(response['pages']) )
        resolve(response['results'])
    )
    totalResults = []
    Promise.all([resources]).then((values) ->
      for key,value of values[0]
        totalResults.push value
#	  displayLimit = 20
      
      $('#results-count').html(totalResults.length)
      $('#search-pagination').html(arcs.tmpl('search/paginate', results: totalResults))
      Search.prototype._render results: totalResults
      return
    )
#  search = () ->
#    val = $(".searchBoxInput").val()
#    pageNum = $('.selected').html()
#    resourcequery = encodeURIComponent("#{val}")
#    pageNumber= encodeURIComponent("#{pageNum}")
#    req = $.getJSON arcs.baseURL + 'simple_search/' + resourcequery + "/" +pageNumber, (response) ->
#      console.log(response)
##      $('#lastPage').html(response['pages'])
#      totalResults = []
#      for i in response['results'] by 1
#        totalResults.push i
#      $('#results-count').html(totalResults.length)
#      Search.prototype._render results: totalResults


  #search = () ->
  #  val = $(".searchBoxInput").val()
  #  console.log(val)
  #  resources = new Promise((resolve, reject) ->
  #    resourcequery = encodeURIComponent("(Type,like,#{val}),or,(Resource Identifier,like,#{val}),or,(Earliest Date,like,#{val}),or,(Latest Date,like,#{val})")
  #    #resourcequery = encodeURIComponent("#{val}")
  #    req = $.getJSON arcs.baseURL + "resources/search?q=#{resourcequery}&sid=736&count=20", (response) ->
  #    #req = $.getJSON "http://kora.matrix.msu.edu/api/restful.php?request=GET&pid=123&sid=736&token=8b88eecedaa2d3708ebec77a&display=json&keywords="+resourcequery+"&sort=Title&order=SORT_ASC",(response) ->
  #      resolve(response)
  #  )
  #  projects = new Promise((resolve, reject) ->
  #    projectquery = encodeURIComponent("(Country,like,#{val})")
  #    req = $.getJSON arcs.baseURL + "resources/search?q=#{projectquery}&sid=734&count=20", (response) ->
  #      resolve(response)
  #  )
  #  seasons = new Promise((resolve, reject) ->
  #    seasonquery = encodeURIComponent("(Title,like,#{val}),or,(Description,like,#{val}),or,(Earliest Date,like,#{val}),or,(Latest Date,like,#{val})")
  #    req = $.getJSON arcs.baseURL + "resources/search?q=#{seasonquery}&sid=735&count=20", (response) ->
  #      resolve(response)
  #  )
  #  excavations = new Promise((resolve, reject) ->
  #    excavationquery = encodeURIComponent("(Name,like,#{val}),or,(Earliest Date,like,#{val}),or,(Latest Date,like,#{val})")
  #    req = $.getJSON arcs.baseURL + "resources/search?q=#{excavationquery}&sid=740&count=20", (response) ->
  #     resolve(response)
  #  )
  #  observations = new Promise((resolve, reject) ->
  #    observationquery = encodeURIComponent("(Monument Classification,like,#{val}),or,(Monument.Type,like,#{val}),or,(Monument.Material,like,#{val}),or,(Monument.Technique,like,#{val}),or,(Monument.Period,like,#{val}),or,(Monument.Terminus Ante Quem,like,#{val}),or,(Monument.Terminus Post Quem,like,#{val})")
  #    req = $.getJSON arcs.baseURL + "resources/search?q=#{observationquery}&sid=739&count=20", (response) ->
  #      resolve(response)
  #  )
  #
  #  totalResults = {}
  #  Promise.all([resources,projects,seasons,excavations,observations]).then((values) ->
  #    for item in values
  #      Array::push.apply totalResults, item.results
  #    #console.log(totalResults)
  #    Search.prototype._render results: totalResults
  #    $('#search-pagination').html arcs.tmpl('search/paginate', results: totalResults)
  #  )

  #Activates on enter press: search
  $ ->
    $(".searchBoxInput").keyup (e) ->
#      console.log("Ran")
      if e.keyCode == 13
        $('.pageNumber').removeClass('selected');
        $("#1").addClass('selected');
        $("#1").html(1)
        e.preventDefault()
        search()

  _render: (results, append=false) ->
    $results = $('.flex-container')
    template = if @options.grid then 'search/grid' else 'search/list'
    results = results.results
    $results[if append then 'append' else 'html'] arcs.tmpl(template, results: results)

    $(".pageNumber").unbind().click (e) ->
      if($(this).hasClass('selected'))
#        console.log("times this was called")
        e.stopPropagation()
        return
      else
        $('.pageNumber').removeClass('selected')
        $(this).addClass('selected')
#        e.preventDefault()
#        e.stopPropagation()
##        console.log("search called")
        search()
        return

    $('#leftArrowBox').unbind().click (e) ->
      temp = $('.selected').html()
      $('.selected').html(parseInt(temp)+1)
      search()

    $('#rightArrowBox').unbind().click (e) ->
      temp = $('.selected').html()
      if temp is '1'
#        console.log("on page 1")
        return
      else
        $('.selected').html(parseInt(temp)-1)
        search()
	
    # add hover effects (select button, border) for the displayed images
    $('div.result').hover (->
      $(this).find('.select-button').show()
      $(this).find('img').addClass 'img-hover'
      return
    ), ->
      $(this).find('.select-button').hide()
      $(this).find('img').removeClass 'img-hover'
      return

    # add click effect for the select-button
    $('.select-button').click ->
      if $(this).html() == 'SELECT'
        $(this).html 'DE-SELECT'
        $(this).addClass 'de-select'
        $(this).parents('.result').addClass 'selected'
        arcs.bus.trigger 'selection'
      else
        $(this).html 'SELECT'
        $(this).removeClass 'de-select'
        $(this).parents('.result').removeClass 'selected'
        arcs.bus.trigger 'selection'
      return
    $('.sort-btn').unbind().click ->
      $('#items-per-page-btn').html($(this).html()+"<span class='pointerDown sort-arrow pointerSearch'></span>")
      $('.pageNumber').removeClass('selected');
      $("#1").addClass('selected');
      $("#1").html(1)
      search()

    if not results.length > 0
      $results.html "<div id='no-results'>No Results</div>"