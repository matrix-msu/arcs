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
    #render()
    #@$('details.open').each (i, el) =>
     # @renderDetails $(el)

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
      limit = 1
      $el.toggleAttr('open')
      $el.toggleClass('closed').toggleClass('open')
      src = arcs.baseURL + 'img/arcs-preloader.gif'
      if $(e.currentTarget).next().next().children().eq(0).prop("tagName") isnt 'IMG'
        #console.log("no image there")
        #console.log($(e.currentTarget).next().next().children().eq(0))
        #console.log($(e.currentTarget).next().next().children().eq(0).prop("tagName"))
        $(e.currentTarget).next().next().prepend('<img src="'+src+'" alt="SeeAll.svg">')

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

  render: () ->
    console.log @$el
    console.log "Fill in collection template here:"
    fullCollectionList = @collection.toJSON()
    currentCollectionList = []
    numPerPage = parseInt($('#items-per-page-btn').html().substring(0,2))
    console.log(numPerPage)
    i = 0
    while i < numPerPage && i < fullCollectionList.length
      currentCollectionList.push(fullCollectionList[i])
      i++
    console.log "page length: " +currentCollectionList.length
    @$el.html arcs.tmpl 'collections/list',
      collections: currentCollectionList
    @
    lastPage = Math.ceil(fullCollectionList.length/numPerPage)
    temp = fillArray(1, lastPage)
    pagination(temp,1,lastPage)
    $('.sort-btn').unbind().click (e) =>
      console.log("sort-btn clicked")
      #console.log(e)
      $('#items-per-page-btn').html($(e.target).html()+"<span class='pointerDown sort-arrow pointerSearch'></span>")
      $('.pageNumber').removeClass('selected');
      $('.pageNumber').removeClass('currentPage');
      $("#1").addClass('selected');
      $("#1").addClass('currentPage');
      $("#1").html(1)
      adjustPage(fullCollectionList, parseInt($('.currentPage').html()) )
      #@render()

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
        adjustPage(fullCollectionList,parseInt($('.currentPage').html()))
        return

    $('#leftArrowBox').unbind().click (e) ->
      temp = $('.currentPage').html()
      $('.currentPage').html(parseInt(temp)+1)
      adjustPage(fullCollectionList,parseInt($('.currentPage').html()))

    $('#rightArrowBox').unbind().click (e) ->
      temp = $('.currentPage').html()
      if temp is '1'
#        console.log("on page 1")
        return
      else
        $('.currentPage').html(parseInt(temp)-1)
        adjustPage(fullCollectionList,parseInt($('.currentPage').html()))
    $('#dots').unbind().click -> #---Josh
      temp = parseInt($('.currentPage').html())+5
      #      console.log(temp)
      #      console.log($("#lastPage").html())
      if temp > parseInt($("#lastPage").html())
        temp = parseInt($("#lastPage").html())
      #        console.log(temp)
      $('.currentPage').html(temp)
      adjustPage(fullCollectionList,parseInt($('.currentPage').html()))
    $('#fDots').unbind().click ->
      temp = parseInt($('.currentPage').html())-5
      #      console.log(temp)
      #      console.log($("#firstPage").html())
      if temp < 1
        temp = 1
      #        console.log(temp)
      $('.currentPage').html(temp)
      adjustPage(fullCollectionList,parseInt($('.currentPage').html()))


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


  adjustPage = (results,currentPage) =>
    $('.pageNumber').removeClass('currentPage')
    $('.pageNumber').removeClass('selected')
    console.log("CALLED")
    console.log(results)
    pageNum = currentPage
    console.log(pageNum)
    numberPerPage = parseInt($('#items-per-page-btn').html().substring(0,2))
    lastPage = Math.ceil(results.length/numberPerPage)
    console.log(lastPage)
    temp = fillArray(pageNum,lastPage)
    console.log(temp)
    pagination(temp,pageNum,lastPage)
    skip = (pageNum-1)*numberPerPage
    console.log("skip: "+skip+" (skip+numberPerPage: )"+ (skip+numberPerPage))
    $('#lastPage').html(lastPage)
    #    perPage = parseInt(perPage = $('#items-per-page-btn').html().substring(0,2))
    #fullCollectionList = @collection.toJSON()
    console.log(results[skip..(skip+numberPerPage)])
    #$('#all-collections')[0].html arcs.tmpl 'collections/list',
     # collections: results[skip..(skip+numberPerPage)]
    #collectionsDiv = ('#all-collections')
    #@collectionsDiv.html arcs.tmpl 'collections/list',
    # collections: currentCollectionList
    #@
    #@$el.html arcs.tmpl 'collections/list',
    #  collections: currentCollectionList
    #@
    $('#all-collections').html arcs.tmpl 'collections/list',
      collections: results[skip..(skip+numberPerPage)]


    #Search.prototype._render results: totalResults[skip...(skip+numberPerPage)]
    #if selectedMap['selected'].length > 0
     # showSelected()

  #Create an array of the page numbers.  ---Josh
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

