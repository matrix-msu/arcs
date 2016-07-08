# profile.coffee
# -------------
# Profile View. Load and handle information for tabs on user profile page.

# Okay, forEach stuff is broken - comprehensions don't work well either as they're numbered not named, I think.
# And we're looping over objects, I think... Stupid CoffeeScript...
# See comments on first answer at least at http://stackoverflow.com/questions/11036721/how-do-i-convert-a-javascript-foreach-loop-function-to-coffeescript
# Bingle the bloody beep.

arcs.views.users ?= {}
class arcs.views.users.Profile extends Backbone.View
  activity = []
  annotations = []
  transcriptions = []
  discussions = []
  page = 15

  info = {url: arcs.baseURL}

  # Okay, this initialize function is going to be insanely long. See if there's a better way to do this.
  # Unfortunately, most of what it does is only replicated the first time. Maybe could dump into the arrays
  # with placeholders for image and such and reuse methods for putting data in place, but I'm not sure that's better
  initialize: (vars) ->
    info.id = vars.id
    that = this
    annoReady = $.ajax(
      url: info.url + 'annotations/findallbyuser'
      type: 'POST'
      data: id: info.id
      success: (annodata) ->
        # console.log annodata
        # Add entries to annotations and transcriptions tabs
        if !annodata.length
          $('#annotations-tab #contents').html '<h3>This user hasn\'t made any annotations yet</h3>'
          $('#transcriptions-tab #contents').html '<h3>This user hasn\'t made any transcriptions yet</h3>'
        else
          # This is the variable we'll store our soon-to-be html in, then put it in the tab all at once
          contents = ''
          # keep track of the current annotation we're on
          count = 0
          # As contents, but for transcriptions
          tcontents = ''
          # as count, but for transcriptions
          tcount = 0
          annodata.forEach (a) ->
            if a['transcript'] == '' or a['transcript'] == null
              # add to activity array
              activity.push
                time: a['created']
                type: 'annotation'
                kid: a['resource_kid']
                name: a['resource_name']
                text: 'Created New Annotation'
              # Get image and resource type
              do (count) ->
                $.ajax
                  url: info.url + 'resources/viewkid/' + a['resource_kid'] + '.json'
                  type: 'GET'
                  data: id: a['resource_kid']
                  success: (aresult) ->
                    #console.log(result);
                    thumb = aresult['thumb']
                    resType = aresult['type']
                    if resType == null
                      resType = 'Unknown Type'
                    if !(count >= 15)
                      div = $('#annotations-tab .cont')[count]
                      # So that img gets src set to thumb, and .type gets html (or text?) set to resType.
                      $(div).find('img').attr 'src', thumb
                      $(div).find('.type').html resType
                      if aresult['title'] != null
                        $(div).find('span.name').html aresult['title']
                    # Add info to annotations array
                    if aresult['title'] != null
                      annotations[count].name = aresult['title']
                    annotations[count].thumb = thumb
                    annotations[count].resType = resType
                    return
                return
              # Stuff to get the date to the desired format, may or may not work properly just yet
              d = new Date(a['created'])
              # silly nonsense to get month name
              monthNames = [
                'January'
                'February'
                'March'
                'April'
                'May'
                'June'
                'July'
                'August'
                'September'
                'October'
                'November'
                'December'
              ]
              date = monthNames[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear()
              # Sort out annotation type, then determine the URL appropriately for that type
              if a['url'] == null or a['url'] == ''
                type = 'Relation'
                # link to related resource page
                url = arcs.baseURL + 'resource/' + a['relation_resource_kid']
                # Related Resource Title
                linkText = a['relation_resource_name']
              else
                type = 'URL'
                url = a['url']
                linkText = a['url']
              # Store in array for page stuff as needed
              annotations.push
                kid: a['resource_kid']
                name: a['resource_name']
                date: date
                url: url
                linkText: linkText
              # And then add it all on to the end if not past 15
              if !(count >= 15)
                contents += '<div class=\'cont\'><div class=\'img\'><a href=\'' + arcs.baseURL + 'resource/' + a['resource_kid'] + '\'><img></a></div><p>' + '<a href=\'' + arcs.baseURL + 'resource/' + a['resource_kid'] + '\'><span class=\'name\'>' + a['resource_name'] + '</span></a>' + '<span class=\'type\'>Resource Type</span><span class=\'date\'>' + date + '</span></p><p class=\'annotationType\'>' + type + '</p><a href=' + url + '>' + linkText + '</a></div>'
              count++
            else
              # add to activity array
              activity.push
                time: a['created']
                type: 'transcription'
                kid: a['resource_kid']
                name: a['resource_name']
                text: 'Created New Transcription'
              # Get image and resource type
              do (tcount) ->
                $.ajax
                  url: info.url + 'resources/viewkid/' + a['resource_kid'] + '.json'
                  type: 'GET'
                  data: id: a['resource_kid']
                  success: (tresult) ->
                    # console.log(tresult);
                    thumb = tresult['thumb']
                    resType = tresult['type']
                    if resType == null
                      resType = 'Unknown Type'
                    if !(tcount >= 15)
                      div = $('#transcriptions-tab .cont')[tcount]
                      # So that img gets src set to thumb, and .type gets html (or text?) set to resType.
                      $(div).find('img').attr 'src', thumb
                      $(div).find('.type').html resType
                      if tresult['title'] != null
                        $(div).find('span.name').html tresult['title']
                    # Add info to transcriptions array
                    if tresult['title'] != null
                      transcriptions[tcount].name = tresult['title']
                    transcriptions[tcount].thumb = thumb
                    transcriptions[tcount].resType = resType
                    return
                return
              # Date stuff
              d = new Date(a['created'])
              monthNames = [
                'January'
                'February'
                'March'
                'April'
                'May'
                'June'
                'July'
                'August'
                'September'
                'October'
                'November'
                'December'
              ]
              # silly nonsense to get month name
              date = monthNames[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear()
              # Store in array for page stuff as needed
              transcriptions.push
                kid: a['resource_kid']
                name: a['resource_name']
                date: date
                transcript: a['transcript']
              # And then add it all on to the end if not past 15
              if !(tcount >= 15)
                tcontents += '<div class=\'cont\'><div class=\'img\'><a href=\'' + arcs.baseURL + 'resource/' + a['resource_kid'] + '\'><img></a></div>' + '<p><a href=\'' + arcs.baseURL + 'resource/' + a['resource_kid'] + '\'><span class=\'name\'>' + a['resource_name'] + '</span></a><span class=\'type\'>Resource Type</span><span class=\'date\'>' + date + '</span></p><p class=\'transcript\'>' + a['transcript'] + '</p></div>'
              tcount++
              # console.log tcontents
            return
          if !(contents == '')
            $('#annotations-tab #contents').html contents
          else
            $('#annotations-tab #contents').html '<h3>This user hasn\'t made any annotations yet</h3>'
          if !(tcontents == '')
            $('#transcriptions-tab #contents').html tcontents
          else
            $('#transcriptions-tab #contents').html '<h3>This user hasn\'t made any transcriptions yet</h3>'
          if count >= 15
            that.pagination('annotations', 0)
          if tcount >= 15
            that.pagination('transcriptions', 0)
        return
    )

    $.ajax
      url: info.url + 'comments/findallbyuser'
      type: 'POST'
      data: id: info.id
      success: (ddata) ->
        #console.log(ddata);
        if !ddata.length
          $('#discussion-tab #contents').html '<h3>No discussion items</h3>'
        else
          dcontents = ''
          dcount = 0
          #Get image, resource type, and resource title
          ddata.forEach (a) ->
            do (dcount) ->
              $.ajax
                url: info.url + 'resources/viewkid/' + a['resource_kid'] + '.json'
                type: 'GET'
                data: id: a['resource_kid']
                success: (dresult) ->
                  thumb = dresult['thumb']
                  resType = dresult['type']
                  if resType == null
                    resType = 'Unknown Type'
                  if !(dcount >= 15)
                    div = $('#discussion-tab .cont')[dcount]
                    # So that img gets src set to thumb, and .type gets html (or text?) set to resType.
                    $(div).find('img').attr 'src', thumb
                    $(div).find('.type').html resType
                    if dresult['title'] != null
                      $(div).find('span.name').html dresult['title']
                  if dresult['title'] != null
                    discussions[dcount].name = dresult['title']
                  discussions[dcount].thumb = thumb
                  discussions[dcount].resType = resType
                  return
              return
            # Stuff to get the date to the desired format
            d = new Date(a['created'])
            # silly nonsense to get month name
            monthNames = [
              'January'
              'February'
              'March'
              'April'
              'May'
              'June'
              'July'
              'August'
              'September'
              'October'
              'November'
              'December'
            ]
            date = monthNames[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear()
            # Store in array for page stuff as needed
            discussions.push
              kid: a['resource_kid']
              name: a['resource_name']
              date: date
              content: a['content']
            # And add it all on if not past 15
            if !(dcount >= 15)
              dcontents += '<div class=\'cont\'><div class=\'img\'><a href=\'' + arcs.baseURL + 'resource/' + a['resource_kid'] + '\'><img></a></div><p><a href=\'' + arcs.baseURL + 'resource/' + a['resource_kid'] + '\'><span class=\'name\'>Resource Name</span></a>' + '<span class=\'type\'>Resource Type</span><span class=\'date\'>' + date + '</span></p><p class=\'transcript\'>' + a['content'] + '</p></div>'
            dcount++
            return
          $('#discussion-tab #contents').html dcontents
          if dcount >= 15
            that.pagination('discussions', 0)
        return

    flagsReady = $.ajax(
      url: info.url + 'flags/findallbyuser'
      type: 'POST'
      data: id: info.id
      success: (fdata) ->
        fdata.forEach (flag) ->
          activity.push
            time: flag['created']
            type: 'flag'
            kid: flag['resource_kid']
            name: flag['resource_name']
            text: 'Created New Flag'
          return
        return
    )

    usersReady = $.ajax(
      url: info.url + 'users/findbyid'
      type: 'POST'
      data: id: info.id
      success: (udata) ->
        activity.push
          time: udata['last_login']
          type: 'log'
          text: 'Logged In'
        # Note the data also has a list of collections created by the user, date included
        return
    )
    # once the activity array is loaded, sort by most recent first and process
    $.when(usersReady, flagsReady, annoReady).then ->
      activity.sort (a, b) ->
        dateA = new Date(a.time)
        dateB = new Date(b.time)
        dateB - dateA
      console.log activity
      # pagination might happen here, or after, but build the html for the tab and get the images and such as needed
      content = ''
      count = 0
      activity.forEach (a) ->
        # Process date
        date = relativeDate(new Date(a['time']))
        # set name, link, and image stuff for all non-login entries, ajax query as needed
        extra = ''
        if a['type'] != 'log'
          extra = '<a href=\'' + arcs.baseURL + 'resource/' + a['kid'] + '\'><span class=\'name\'>' + a['name'] + '</span></a><img>'
          do (count) ->
            $.ajax
              url: info.url + 'resources/viewkid/' + a['kid'] + '.json'
              type: 'GET'
              data: id: a['kid']
              success: (result) ->
                # Do stuff here
                if !(count >= 15)
                  div = $('#activity-tab .cont')[count]
                  $(div).find('img').attr 'src', result['thumb']
                  if result['title'] != null
                    $(div).find('span.name').html result['title']
                if result['title'] != null
                  activity[count].name = result['title']
                activity[count].thumb = result['thumb']
                return
            return
        # And add it all on
        if !(count >= 15)
          content += '<div class=\'cont\'><p><span class=\'time\'>' + date + '</span><span class=\'' + a['type'] + '\'></span>' + '<span class=\'text\'>' + a['text'] + '</span>' + extra + '</p></div>'
        count++
        return
      $('#activity-tab #contents').html content
      if count >= 15
        that.pagination('activity', 0)
      return
    return

  # here we need further methods - pagination to build the page setup, called after stuff is built and after each page
  # shift; set page to get the correct data based on page number; fillArray to make the page array for us (thanks Charlie)

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

  # pagination should be called for each tab that needs it, so one method that takes a which tab argument is used
  # but is only activated on tabs that need it, and page shifting work is only done on the tab where it's needed
  pagination: (target, currentPage) ->
    # do stuff here
    console.log('pagination ' + target)
    if target == 'activity'
      arr = activity
      div = $('#activity-tab')
    else if target == 'annotations'
      arr = annotations
      div = $('#annotations-tab')
    else if target == 'transcriptions'
      arr = transcriptions
      div = $('#transcriptions-tab')
    else if target == 'discussions'
      arr = discussions
      div = $('#discussion-tab')
    lastPage = Math.ceil(arr.length/page)
    pageArray = fillArray(currentPage, lastPage)
    console.log($(div).find('#firstPage'))
    if 1 in pageArray
      $(div).find('#firstPage').css('display', 'none')
      $(div).find('.fDots').css('display', 'none')
    else
      $(div).find('#firstPage').css('display', 'block')
      $(div).find('.fDots').css('display', 'block')
    if 1 is currentPage
      $(div).find('#rightArrow').css('display', 'none')
    else
      $(div).find('#rightArrow').css('display', 'block')
    if lastPage in pageArray
      $(div).find('#lastPage').css('display', 'none')
      $(div).find('.dots').css('display', 'none')
      $(div).find('#leftArrow').css('display', 'none')
    else
      $(div).find('#lastPage').css('display', 'block')
      $(div).find('.dots').css('display', 'block')
      $(div).find('#leftArrow').css('display', 'block')
    if currentPage is lastPage
      $(div).find('#lefttArrow').css('display', 'none')
    else
      $(div).find('#leftArrow').css('display', 'block')
    if 2 is pageArray[0]
      $(div).find('.fDots').css('display', 'none')
    if lastPage-1 is pageArray[4]
      $(div).find('.dots').css('display', 'none')
    for i in [1..5]
#      console.log("Array contents: "+pageArray[i-1]+" i: "+ i)
      if pageArray[i-1] <= 0
#        console.log("undifined")
        $(div).find('#'+i).css('display', 'none')
      else
        $(div).find('#'+i).css('display', 'block')
        $(div).find('#'+i).html(pageArray[i-1])
        if parseInt($(div).find('#'+i).html()) is currentPage
          $(div).find('#'+i).addClass('selected')
          $(div).find('#'+i).addClass('currentPage')
    return

  # Okay, so search\search.coffee has useful stuff to borrow. _render has click even assignment. See also pagination and set page
  setPage: (num) ->
    # do stuff here
    return
