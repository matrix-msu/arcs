# search.coffee
# -------------
# Search View. Select and perform bulk actions on search results.
selectedMap={"unselected": [],"selected": [] } #key value pairs {'page #', array of selected elements on that page}
selectedCount = 0
selected = []
display = []
totalResults = []
waiting = false
arcs.views.advanced_search ?= {}
class arcs.views.advanced_search.AdvancedSearch extends Backbone.View

  options:
    sort: 'title'
    sortDir: 'asc'
    grid: true
    url: arcs.baseURL + 'advanced_search/'

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
    'click .fDots'        : 'scrollTop'
    'click .dots'        : 'scrollTop'

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
    console.log("unselectAll called")
    @$('.result').removeClass('selected')
    @$('.select-button').removeClass('de-select')
    @$('.select-button, #toggle-select').html('SELECT')
    @$('#deselect-all').attr id: 'select-all'
    arcs.bus.trigger 'selection' if trigger

  selectAll: (trigger=true) ->
    console.log("selectAll called")
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
    console.log("maybeunselectAll called")
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
      console.log(arcs.selected)
      $('#selected-resource-ids').html(selected)
      # get the count of the selected items, change the style accordingly
      num = $('.result.selected').length
      $('#selected-count').html(num)
      if (num != 0)
        $('#selected-all').css({color:'black'})
      else
        $('#selected-all').css({color:'#C1C1C1'})

      #      @search.results.unselectAll()
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


  #Create an array of the page numbers.
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
    console.log(pageArray)
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
    if 2 is pageArray[0]
      $('.fDots').css('display', 'none')
    if lastPage-1 is pageArray[4]
      $('.dots').css('display', 'none')
    for i in [1..5]
#      console.log("Array contents: "+pageArray[i-1]+" i: "+ i)
      if pageArray[i-1] <= 0
#        console.log("undifined")
        $('#'+i).css('display', 'none')
      else
        $('#'+i).css('display', 'block')
        $('#'+i).html(pageArray[i-1])
        if parseInt($('#'+i).html()) is currentPage
          $('#'+i).addClass('selected')
          $('#'+i).addClass('currentPage')

  noResults = () ->
    $('#firstPage').css('display', 'none')
    $('.fDots').css('display', 'none')
    $('#lastPage').css('display', 'none')
    $('.dots').css('display', 'none')
    $('#leftArrow').css('display', 'none')
    $('#rightArrow').css('display', 'none')
    for i in [1..5]
      $('#'+i).css('display', 'none')

  showSelected = () ->
    $( '.result' ).each ->
      if $(this).data('id') in selectedMap['selected']
        $(this).addClass('selected')
        $(this).find('.select-button').addClass 'de-select'
        $(this).find('.select-button').html 'DE-SELECT'

  adjustPage = (results,currentPage) ->
    if waiting
      return
    $('.pageNumber').removeClass('currentPage')
    $('.pageNumber').removeClass('selected')
    console.log("CALLED")
    console.log(results)
    pageNum = currentPage
    console.log(pageNum)
    numberPerPage = parseInt($('#items-per-page-btn').html().substring(0,2))
    console.log(numberPerPage)
    lastPage = Math.ceil(results.length/numberPerPage)
    console.log(lastPage)
    temp = fillArray(pageNum,lastPage)
    console.log(temp)
    pagination(temp,pageNum,lastPage)
    skip = (pageNum-1)*numberPerPage
    console.log("skip: "+skip+" (skip+numberPerPage: )"+ (skip+numberPerPage))
    $('#lastPage').html(lastPage)
    #    perPage = parseInt(perPage = $('#items-per-page-btn').html().substring(0,2))
    console.log(totalResults[skip..(skip+numberPerPage)])
    AdvancedSearch.prototype._render results: totalResults[skip...(skip+numberPerPage)]
    if selectedMap['selected'].length > 0
      showSelected()




  # Lets get the inputs from the form in the advanced tpl
#  getInput = ->
#    inputs_array =
#      coverage: document.getElementByName('coverage')
#      date: document.getElementsByName('date')
#      description: document.getElementsByName('description')
#      identifier: document.getElementsByName('#identifier')
#      location: document.getElementsByName('location')
#      subject: document.getElementsByName('subject')
#      creator: document.getElementsByName('creator')
#      date_modifier: document.getElementsByName('date-modifier')
#      format: document.getElementsByName('format')
#      language: document.getElementsByName('language')
#      medium: document.getElementsByName('medium')
#    inputs_array




  #MULTIPROJECT SEARCH
  advancedSearch = (val) ->
    $('.flex-img').removeClass('selected')
    console.log(val)
    val = JSON.stringify(val)
    pageNum = $('.currentPage').html()
    perPage = $('#items-per-page-btn').html().substring(0,2)
    $('.pageNumber').removeClass('currentPage')
    $('.pageNumber').removeClass('selected')
    resources = new Promise((resolve, reject) ->
      resourcequery = encodeURIComponent("#{val}")
      pageNumber= encodeURIComponent("#{pageNum}")
      perPageUrl = encodeURIComponent("#{perPage}")
      req = $.getJSON arcs.baseURL + 'advanced_search/' + resourcequery + "/" +pageNumber + "/" + perPageUrl, (response) ->
        console.log(response)
        $('#lastPage').html(response['pages'])
        temp = fillArray(parseInt(pageNum),parseInt(response['pages']))
        if response['display'] isnt 0
          pagination(temp,parseInt(pageNum), parseInt(response['pages']) )
        else
          noResults()
        $('#results-count').html(response['results'])
        resolve(response['results'])
    )
    totalResults = []
    Promise.all([resources]).then((values) ->
      console.log(values[0])
      for key,value of values[0]
        totalResults.push value
      $('#results-count').html(totalResults.length)
#      $('#search-pagination').html(arcs.tmpl('search/paginate', results: totalResults))
#      AdvancedSearch.prototype._render results: totalResults
      adjustPage(totalResults,1)
      return
    )




  $ ->
    if !$.support.placeholder
      active = document.activeElement
      $(':text').focus(->
        if $(this).attr('placeholder') != '' and $(this).val() == $(this).attr('placeholder')
          $(this).val('').removeClass 'hasPlaceholder'
          $(this).val ''
        return
      ).blur ->
        if $(this).attr('placeholder') != '' and ($(this).val() == '' or $(this).val() == $(this).attr('placeholder'))
          $(this).val($(this).attr('placeholder')).addClass 'hasPlaceholder'
          $(this).val ''
        return
      $(':text').blur()
      $(active).focus()
      $(this).find('.searchBoxAdvanced').each ->
        $(this).val ''
        return
        return
    return


  #Activates on submit button click: advancedsearch
  $ ->
    $("#advanced_search_button").click (e) ->
      console.log("Ran ad")
      $('.pageNumber').removeClass('selected');
      $('.pageNumber').removeClass('currentPage');
      $("#1").addClass('selected');
      $("#1").addClass('currentPage');
      $("#1").html(1)

      # Getting the input from the user. Will do find a shorter method later!!
      medium          = $("#Medium").val()
      language        = $("#Language").val()
      format          = $("#Format").val()
      date_modified   = $("#DateModified").val()
      creator         = $("#Creator").val()
      subject         = $("#Subject").val()
      location        = $("#Location").val()
      identifier      = $("#Identifier").val()
      description     = $("#Description").val()
      date            = $("#Date").val()
      coverage        = $("#Coverage").val()

      # An array of the inpiuts so that we can work on them in the contorller
      val = [coverage,date,description,identifier,location,subject,creator,date_modified,format,language,medium]
      console.log(val.length)
      console.log(val)
      val2 = []
      x = 0
      while x < val.length
        if val[x] != ''
          val2.push val[x]
        x++
      val = val2
      e.preventDefault()
      $('.flex-container').empty()
      $('.flex-container').append('<img src="/~arnold.mutayoba/arcs/img/arcs-preloader.gif">');
      $('#search-results-wrapper').css('visibility','visible')
      advancedSearch(val)

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
        $('.pageNumber').removeClass('currentPage')
        $(this).addClass('selected')
        $(this).addClass('currentPage')
        adjustPage(totalResults,parseInt($('.currentPage').html()))
        return

    $('#leftArrowBox').unbind().click (e) ->
      temp = $('.currentPage').html()
      $('.currentPage').html(parseInt(temp)+1)
      adjustPage(totalResults,parseInt($('.currentPage').html()))

    $('#rightArrowBox').unbind().click (e) ->
      temp = $('.currentPage').html()
      if temp is '1'
#        console.log("on page 1")
        return
      else
        $('.currentPage').html(parseInt(temp)-1)
        adjustPage(totalResults,parseInt($('.currentPage').html()))
    $('#dots').unbind().click ->
      temp = parseInt($('.currentPage').html())+5
      #      console.log(temp)
      #      console.log($("#lastPage").html())
      if temp > parseInt($("#lastPage").html())
        temp = parseInt($("#lastPage").html())
      #        console.log(temp)
      $('.currentPage').html(temp)
      adjustPage(totalResults,parseInt($('.currentPage').html()))
    $('#fDots').unbind().click ->
      temp = parseInt($('.currentPage').html())-5
      #      console.log(temp)
      #      console.log($("#firstPage").html())
      if temp < 1
        temp = 1
      #        console.log(temp)
      $('.currentPage').html(temp)
      adjustPage(totalResults,parseInt($('.currentPage').html()))
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
        $('#selected-all').css({color:'black'})
        selectedMap['selected'].push $(this).parents('.result').data("id")
        $('#selected-resource-ids').html(selectedMap["selected"])
        $('#selected-count').html(selectedMap["selected"].length)
        console.log(selectedMap)
        arcs.bus.trigger 'selection'
      else
        $(this).html 'SELECT'
        $(this).removeClass 'de-select'
        $(this).parents('.result').removeClass 'selected'
        index = selectedMap['selected'].indexOf($(this).parents('.result').data("id"))
        if index > -1
          selectedMap['selected'].splice(index,1)
        if selectedMap['selected'].length < 1
          $('#selected-all').css({color:'#C1C1C1'})
        console.log(index)
        console.log(selectedMap)
        $('#selected-resource-ids').html(selectedMap["selected"])
        $('#selected-count').html(selectedMap["selected"].length)
        arcs.bus.trigger 'selection'

      return
    $('.sort-btn').unbind().click ->
      $('#items-per-page-btn').html($(this).html()+"<span class='pointerDown sort-arrow pointerSearch'></span>")
      $('.pageNumber').removeClass('selected');
      $('.pageNumber').removeClass('currentPage');
      $("#1").addClass('selected');
      $("#1").addClass('currentPage');
      $("#1").html(1)
      adjustPage(totalResults,parseInt($('.currentPage').html()))

    $('#select-all, #deselect-all').unbind().click ->
      if this.id is 'select-all'
        $('#selected-all').css({color:'black'})
        selectedMap['selected']=[]
        i = 0
        for i of totalResults
          selectedMap['selected'].push totalResults[i]['kid']
          ++i
        console.log(selected['unselected'])
        #        selectedMap['selected'] = totalResults[0]['kid']
        arcs.searchView.selectAll();
        $('#toggle-select').html('DE-SELECT')
        console.log(selectedMap['selected'])
        $('#selected-resource-ids').html(selectedMap["selected"])
        $('#selected-count').html(selectedMap["selected"].length)
      else
        $('#selected-all').css({color:'#C1C1C1'})
        console.log("in the else statement")
        selectedMap['selected'] = []
        this.id = 'select-all'
        arcs.searchView.unselectAll();
        $('#selected-resource-ids').html(selectedMap["selected"])
        $('#selected-count').html(selectedMap["selected"].length)

    #
    if results.length is 0
      $results.html "<div id='no-results'>No Results</div>"