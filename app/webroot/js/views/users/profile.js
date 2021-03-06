// Generated by CoffeeScript 1.10.0
(function() {
  var base,
    extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty,
    indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

  if ((base = arcs.views).users == null) {
    base.users = {};
  }

  arcs.views.users.Profile = (function(superClass) {
    var activity, annotations, discussions, fillArray, info, page, transcriptions, collections;

    extend(Profile, superClass);

    function Profile() {
      return Profile.__super__.constructor.apply(this, arguments);
    }

    activity = [];

    annotations = [];

    transcriptions = [];

    discussions = [];

    collections = [];

    // Badge numbers
    var resourcesUploaded = 0;
    var resourcesEdited = 0;
    var resourceKeywords = 0;
    var resourcesFlagged = 0;
    var annotationsIn = 0;
    var annotationsOut = 0;
    var transcriptionCount = 0;
    var commentsInit = 0;
    var commentsReply = 0;
    var collectionsMade = 0;

    page = 15;

    info = {
      url: arcs.baseURL
    };

    Profile.prototype.initialize = function(vars) {
      var annoReady, flagsReady, metaReady, that, usersReady;
      info.id = vars.id;
      that = this;
      annoReady = $.ajax({
        url: info.url + 'annotations/findallbyuser',
        type: 'POST',
        data: {
          id: info.id
        },
        success: function(annodata) {
          var contents, count, tcontents, tcount;
          if (!annodata.length) {
            $('#annotations-tab #contents').html('<h3>This user hasn\'t made any annotations yet</h3>');
            $('#transcriptions-tab #contents').html('<h3>This user hasn\'t made any transcriptions yet</h3>');
          } else {
            contents = '';
            count = 0;
            tcontents = '';
            tcount = 0;
            annodata.forEach(function(a) {
              var d, date, linkText, monthNames, type, url;
              if (a['transcript'] === '' || a['transcript'] === null) {
                activity.push({
                  time: a['created'],
                  time_string: a['time_string'],
                  type: 'annotation',
                  kid: a['resource_kid'],
                  name: a['resource_name'],
                  text: 'Created New Annotation'
                });
                (function(count) {
                  $.ajax({
                    url: info.url + 'resources/viewkid/' + a['resource_kid'] + '.json',
                    type: 'GET',
                    data: {
                      id: a['resource_kid']
                    },
                    success: function(aresult) {
                      var div, resType, thumb;
                      thumb = aresult['thumb'];
                      resType = aresult['Type'];
                      if (resType === null || resType == "null") {
                        resType = 'Unknown Type';
                      }
                      if (!(count >= 15)) {
                        div = $('#annotations-tab .cont')[count];
                        $(div).find('img').attr('src', thumb).attr('alt', aresult['Title']);
                        $(div).find('.type').text(resType);
                        if (aresult['Title'] != null) {
                          $(div).find('span.name').html(aresult['Title']);
                        }
                      }
                      if (aresult['Title'] != null) {
                        annotations[count].name = aresult['Title'];
                      }
                      annotations[count].thumb = thumb;
                      annotations[count].resType = resType;
                    }
                  });
                })(count);
                d = new Date(a['created']);
                monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                date = monthNames[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear();
                if (a['url'] === null || a['url'] === '') {
                  annotationsIn++;
                  type = 'Relation';
                  url = arcs.baseURL + 'resource/' + a['relation_resource_kid'];
                  linkText = a['relation_resource_name'];
                } else {
                  annotationsOut++;
                  type = 'URL';
                  url = a['url'];
                  linkText = a['url'];
                }
                annotations.push({
                  kid: a['resource_kid'],
                  name: a['resource_name'],
                  date: date,
                  url: url,
                  linkText: linkText,
                  type: type
                });
                if (!(count >= 15)) {
                  contents += '<div class=\'cont\'><div class=\'img\'><a href=\'' + arcs.baseURL + 'resource/' + a['resource_kid'] + '\'><img alt="image"></a></div><p>' + '<a href=\'' + arcs.baseURL + 'resource/' + a['resource_kid'] + '\'><span class=\'name\'>' + a['resource_name'] + '</span></a>' + '<span class=\'type\'>Resource Type</span><span class=\'date\'>' + date + '</span></p><p class=\'annotationType\'>' + type + '</p><a href=' + url + '>' + linkText + '</a></div>';
                }
                count++;
              } else {
                transcriptionCount++;
                activity.push({
                  time: a['created'],
                  time_string: a['time_string'],
                  type: 'transcription',
                  kid: a['resource_kid'],
                  name: a['resource_name'],
                  text: 'Created New Transcription'
                });
                (function(tcount) {
                  $.ajax({
                    url: info.url + 'resources/viewkid/' + a['resource_kid'] + '.json',
                    type: 'GET',
                    data: {
                      id: a['resource_kid']
                    },
                    success: function(tresult) {
                      var div, resType, thumb;
                      thumb = tresult['thumb'];
                      resType = tresult['Type'];
                      if (resType === null) {
                        resType = 'Unknown Type';
                      }
                      if (!(tcount >= 15)) {
                        div = $('#transcriptions-tab .cont')[tcount];
                        $(div).find('img').attr('src', thumb).attr('alt', result['Title']);
                        $(div).find('.type').text(resType);
                        if (tresult['title'] != null) {
                          $(div).find('span.name').html(tresult['Title']);
                        }
                      }
                      if (tresult['Title'] != null) {
                        transcriptions[tcount].name = tresult['Title'];
                      }
                      transcriptions[tcount].thumb = thumb;
                      transcriptions[tcount].resType = resType;
                    }
                  });
                })(tcount);
                d = new Date(a['created']);
                monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                date = monthNames[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear();
                transcriptions.push({
                  kid: a['resource_kid'],
                  name: a['resource_name'],
                  date: date,
                  transcript: a['transcript']
                });
                if (!(tcount >= 15)) {
                  tcontents += '<div class=\'cont\'><div class=\'img\'><a href=\'' + arcs.baseURL + 'resource/' + a['resource_kid'] + '\'><img alt="transcription-image"></a></div>' + '<p><a href=\'' + arcs.baseURL + 'resource/' + a['resource_kid'] + '\'><span class=\'name\'>' + a['resource_name'] + '</span></a><span class=\'type\'>Resource Type</span><span class=\'date\'>' + date + '</span></p><p class=\'transcript\'>' + a['transcript'] + '</p></div>';
                }
                tcount++;
              }
            });
            if (!(contents === '')) {
              $('#annotations-tab #contents').html(contents);
            } else {
              $('#annotations-tab #contents').html('<h3>This user hasn\'t made any annotations yet</h3>');
            }
            if (!(tcontents === '')) {
              $('#transcriptions-tab #contents').html(tcontents);
            } else {
              $('#transcriptions-tab #contents').html('<h3>This user hasn\'t made any transcriptions yet</h3>');
            }
            if (count >= 15) {
              that.pagination('annotations', 1);
            }
            if (tcount >= 15) {
              that.pagination('transcriptions', 1);
            }
          }
        }
      });
      $.ajax({
        url: info.url + 'comments/findallbyuser',
        type: 'POST',
        data: {
          id: info.id
        },
        success: function(ddata) {
          //console.log(ddata);
          var dcontents, dcount;
          if (!ddata.length) {
            $('#discussion-tab #contents').html('<h3>This user hasn\'t made any discussions yet</h3>');
          } else {
            dcontents = '';
            dcount = 0;
            ddata.forEach(function(a) {
              var d, date, monthNames;
              if (a.parent_id == "") {
                commentsInit++;
              }
              else {
                commentsReply++;
              }
              (function(dcount) {
                $.ajax({
                  url: info.url + 'resources/viewkid/' + a['resource_kid'] + '.json',
                  type: 'GET',
                  data: {
                    id: a['resource_kid']
                  },
                  success: function(dresult) {
                    var div, resType, thumb;
                    thumb = dresult['thumb'];
                    resType = dresult['Type'];
                    if (resType === null) {
                      resType = 'Unknown Type';
                    }
                    if (!(dcount >= 15)) {
                      div = $('#discussion-tab .cont')[dcount];
                      $(div).find('img').attr('src', thumb).attr('alt', result['Title']);
                      $(div).find('.type').text(resType);
                      if (dresult['Title'] != null) {
                        $(div).find('span.name').text(dresult['Title']);
                      }
                    }
                    if (dresult['Title'] != null) {
                      discussions[dcount].name = dresult['Title'];
                    }
                    discussions[dcount].thumb = thumb;
                    discussions[dcount].resType = resType;
                  }
                });
              })(dcount);
              d = new Date(a['created']);
              monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
              date = monthNames[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear();
              discussions.push({
                kid: a['resource_kid'],
                name: a['resource_name'],
                date: date,
                content: a['content']
              });
              if (!(dcount >= 15)) {
                dcontents += '<div class=\'cont\'><div class=\'img\'><a href=\'' + arcs.baseURL + 'resource/' + a['resource_kid'] + '\'><img alt="discussion-image"></a></div><p><a href=\'' + arcs.baseURL + 'resource/' + a['resource_kid'] + '\'><span class=\'name\'>' + a['resource_name'] + '</span></a>' + '<span class=\'type\'>Resource Type</span><span class=\'date\'>' + date + '</span></p><p class=\'transcript\'>' + a['content'] + '</p></div>';
              }
              dcount++;
            });
            $('#discussion-tab #contents').html(dcontents);
            if (dcount >= 15) {
              that.pagination('discussions', 1);
            }
          }
        }
      });
      flagsReady = $.ajax({
        url: info.url + 'flags/findallbyuser',
        type: 'POST',
        data: {
          id: info.id
        },
        success: function(fdata) {
          var byResource = [];
          fdata.forEach(function(flag) {
            activity.push({
              time: flag['created'],
              type: 'flag',
              time_string: flag['time_string'],
              kid: flag['resource_kid'],
              name: flag['resource_name'],
              text: 'Created New Flag'
            });
            if (byResource.indexOf(flag.resource_id) == -1) {
              byResource.push(flag.resource_id);
            }
          });
        }
      });
      metaReady = $.ajax({
        url: info.url + 'metadataedits/findallbyuser',
        type: 'POST',
        data: {
          id: info.id
        },
        success: function(mdata) {
          var byResource = [];
          mdata.forEach(function(edit) {
            activity.push({
              time: edit['modified'],
              time_string: edit['time_string'],
              type: 'edit',
              kid: edit['resource_kid'],
              name: edit['resource_name'],
              text: 'Edited Metadata'
            });
            if (byResource.indexOf(edit.resource_id) == -1) {
              byResource.push(edit.resource_id);
            }
          });
        }
      });
      usersReady = $.ajax({
        url: info.url + 'users/findbyid',
        type: 'POST',
        data: {
          id: info.id
        },
        success: function(udata) {
          activity.push({
            time: udata['last_login'],
            time_string: udata['time_string'],
            type: 'log',
            text: 'Logged In'
          });
        }
      });
      var keywordsReady = $.ajax({
        url: info.url + 'keywords/findallbyuser',
        type: 'POST',
        data: {
          id: info.id
        },
        success: function(keywords) {
          // keywords in total, or resources given keywords? I'm going with the latter for now
          var byResource = [];
          for (var i = 0; i < keywords.length; i++) {
            if (byResource.indexOf(keywords[i]["resource_id"]) == -1) {
              byResource.push(keywords[i]["resource_id"]);
            }
          }
          resourceKeywords = byResource.length;
        }
      });

      var collectionsReady = $.ajax({
        url: info.url + 'collections/findallbyuser',
        type: 'POST',
        data: {
          id: info.id
        },
        success: function(list) {
          collections = JSON.parse(list);
          collectionsMade = collections.count;
          collections = JSON.parse(collections.data);
          //console.log('The collections', collections)
          var collections15 = collections.slice(0, 15);
          console.log('collections15', collections15)
          if( collectionsMade === '0' || collectionsMade == 0 ){
            $('#collections-tab-contents').html('<h3>This user hasn\'t made any collections yet</h3>');
            return;
          }

          var collections_permissions = false;
          if( $('#edit-profile').length > 0 ){
              collections_permissions = true;
          }
          var html;
          html = arcs.tmpl('collections/profile', {
              collections: collections15,
              permissions: collections_permissions
          });
          //console.log(html);
          $('#collections-tab-contents').html(html);
          if (collectionsMade >= 15) {
            that.pagination('collections', 1);
          }
        }
      });
      $.when(usersReady, flagsReady, annoReady, metaReady).then(function() {
        var content, count;
        activity.sort(function(a, b) {
          var dateA, dateB;
          dateA = new Date(a.time);
          dateB = new Date(b.time);
          return dateB - dateA;
        });
        content = '';
        count = 0;
        activity.forEach(function(a) {
          //var date, extra;
          //date = new Date(a['time']);
          //date.setMinutes(-new Date(new Date().getFullYear(), 0, 1).getTimezoneOffset() + 300);
          //date = relativeDate(date);
          //activity[count].date = date;
          var extra = '';
          var date = a['time_string'];
          if (a['type'] !== 'log') {
             extra = '<img/>';

            (function(count){
              $.ajax({
                url: info.url + 'resources/viewkid/' + a['kid'] + '.json',
                type: 'GET',
                data: {
                  id: a['kid']
                },
                success: function(result) {
                  //console.log(result);
                  var div;
                  if (!(count >= 15)) {
                    div = $('#activity-tab .cont')[count];
                    $(div).find('img').attr('src', result['thumb']).attr('alt', result['Title']);
                    if (result['Title'] != null) {
                      $(div).find('span.name a').text(result['Title']);
                    }
                  }
                  if (result['Title'] != null) {
                    activity[count].name = result['Title'];
                  }
                  activity[count].thumb = result['thumb'];
                }
              });
            })(count);
          }
          if (!(count >= 15)) {
            content += '<div class=\'cont\'>' +
                '<p><span class=\'time\'>' + date + '</span>' +
                    '<span class=\'' + a['type'] + '\'></span>' +
                    '<span class=\'text\'>' + a['text'] + '</span>';
            if (a['type'] !== 'log'){
                var name = a['name'];
                if (name == null) {
                  name = 'Object Name';
                }
                content+='<span class="name"><a href="' + arcs.baseURL + 'resource/' + a['kid'] + '">' + name + '</a></span>';
            }
                    //else{
                    //  content+='<span class=\'text\'>' + a['text'] + '</span>';
                    //}

            content += extra +'</p></div>';
          }
          count++;
        });
        $('#activity-tab #contents').html(content);
        if (count >= 15) {
          that.pagination('activity', 1);
        }
      });

      //$.when(usersReady, flagsReady, annoReady, metaReady, keywordsReady, collectionsReady).then(function() {
      //  var badgeNum;
      //  if (resourcesUploaded >= 10) {
      //    badgeNum = parseInt((resourcesUploaded-10) / 10) % 4 + 1;
      //    $("#achievements-tab").append('<div class="badgeDiv"><span>'+resourcesUploaded+'</span><img class="badgeImg" src="/'+BASE_URL+'app/webroot/img/number of resources uploaded'+badgeNum+'.png"><h3>Resources Uploaded</h3><p>Achievement Description</p></div>');
      //  }
      //  if (resourcesEdited >= 10) {
      //    badgeNum = parseInt((resourcesEdited-10) / 10) % 4 + 1;
      //    $("#achievements-tab").append('<div class="badgeDiv"><span>'+resourcesEdited+'</span><img class="badgeImg" src="/'+BASE_URL+'app/webroot/img/number of resources edited for metadata'+badgeNum+'.png"><h3>Resources Edited</h3><p>Achievement Description</p></div>');
      //  }
      //  if (resourceKeywords >= 10) {
      //    badgeNum = parseInt((resourceKeywords-10) / 10) % 4 + 1;
      //    $("#achievements-tab").append('<div class="badgeDiv"><span>'+resourceKeywords+'</span><img class="badgeImg" src="/'+BASE_URL+'app/webroot/img/keywords'+badgeNum+'.png"><h3>Keywords</h3><p>Achievement Description</p></div>');
      //  }
      //  if (resourcesFlagged >= 10) {
      //    badgeNum = parseInt((resourcesFlagged-10) / 10) % 4 + 1;
      //    $("#achievements-tab").append('<div class="badgeDiv"><span>'+resourcesFlagged+'</span><img class="badgeImg" src="/'+BASE_URL+'app/webroot/img/number of flagged resources'+badgeNum+'.png"><h3>Resources Flagged</h3><p>Achievement Description</p></div>');
      //  }
      //  if (annotationsIn >= 10) {
      //    badgeNum = parseInt((annotationsIn-10) / 10) % 4 + 1;
      //    $("#achievements-tab").append('<div class="badgeDiv"><span>'+annotationsIn+'</span><img class="badgeImg" src="/'+BASE_URL+'app/webroot/img/annotations in the system'+badgeNum+'.png"><h3>Internal Annotations</h3><p>Achievement Description</p></div>');
      //  }
      //  if (annotationsOut >= 10) {
      //    badgeNum = parseInt((annotationsOut-10) / 10) % 4 + 1;
      //    $("#achievements-tab").append('<div class="badgeDiv"><span>'+annotationsOut+'</span><img class="badgeImg" src="/'+BASE_URL+'app/webroot/img/annotations outside the system'+badgeNum+'.png"><h3>External Annotations</h3><p>Achievement Description</p></div>');
      //  }
      //  if (transcriptionCount >= 10) {
      //    badgeNum = parseInt((transcriptionCount-10) / 10) % 4 + 1;
      //    $("#achievements-tab").append('<div class="badgeDiv"><span>'+transcriptionCount+'</span><img class="badgeImg" src="/'+BASE_URL+'app/webroot/img/transcriptions'+badgeNum+'.png"><h3>Transcriptions Made</h3><p>Achievement Description</p></div>');
      //  }
      //  if (commentsInit >= 10) {
      //    badgeNum = parseInt((commentsInit-10) / 10) % 4 + 1;
      //    $("#achievements-tab").append('<div class="badgeDiv"><span>'+commentsInit+'</span><img class="badgeImg" src="/'+BASE_URL+'app/webroot/img/initiated discussions'+badgeNum+'.png"><h3>Discussions Started</h3><p>Achievement Description</p></div>');
      //  }
      //  if (commentsReply >= 10) {
      //    badgeNum = parseInt((commentsReply-10) / 10) % 4 + 1;
      //    $("#achievements-tab").append('<div class="badgeDiv"><span>'+commentsReply+'</span><img class="badgeImg" src="/'+BASE_URL+'app/webroot/img/responded to discussions'+badgeNum+'.png"><h3>Discussion Replies</h3><p>Achievement Description</p></div>');
      //  }
      //  if (collectionsMade >= 10) {
      //    badgeNum = parseInt((collectionsMade-10) / 10) % 4 + 1;
      //    $("#achievements-tab").append('<div class="badgeDiv"><span>'+collectionsMade+'</span><img class="badgeImg" src="/'+BASE_URL+'app/webroot/img/collections created'+badgeNum+'.png"><h3>Collections Created</h3><p>Achievement Description</p></div>');
      //  }
      //  if( $('.badgeImg').length == 0 ){
      //    $("#achievements-tab").append('<h3>This user hasn\'t earned any achievements yet</h3>');
      //  }
      //});
    };

    fillArray = function(page, lastPage) {
      var i, results;
      if (page < 3) {
        page = 3;
      }
      if (page === lastPage) {
        page = page - 2;
      }
      if (page === lastPage - 1) {
        page = page - 1;
      }
      i = -1;
      results = [];
      while (i < 4) {
        i++;
        if ((page + (i - 2)) <= lastPage) {
          results.push(page + (i - 2));
        } else {
          results.push(0);
        }
      }
      return results;
    };

    Profile.prototype.pagination = function(target, currentPage) {
      var arr, div, i, j, lastPage, pageArray;
      var that = this;
      if (target === 'activity') {
        arr = activity;
        div = $('#activity-tab');
      } else if (target === 'annotations') {
        arr = annotations;
        div = $('#annotations-tab');
      } else if (target === 'transcriptions') {
        arr = transcriptions;
        div = $('#transcriptions-tab');
      } else if (target === 'discussions') {
        arr = discussions;
        div = $('#discussion-tab');
      } else if (target === 'collections') {
        arr = collections;
        div = $('#collections-tab');
      }
      $(div).find('.pageNumber').unbind("click");
      $(div).find('#leftArrowBox').unbind("click");
      $(div).find('#rightArrowBox').unbind("click");
      lastPage = Math.ceil(arr.length / page);
      pageArray = fillArray(currentPage, lastPage);
      if (indexOf.call(pageArray, 1) >= 0) {
        $(div).find('#firstPage').css('display', 'none');
        $(div).find('.fDots').css('display', 'none');
      } else {
        $(div).find('#firstPage').css('display', 'block');
        $(div).find('#firstPage').click(function() {
          that.setPage(target, 1);
          that.pagination(target, 1);
        });
        $(div).find('.fDots').css('display', 'block');
      }
      if (1 == currentPage) {
        $(div).find('#rightArrowBox').css('display', 'none');
      } else {
        $(div).find('#rightArrowBox').css('display', 'block');
        $(div).find('#rightArrowBox').click(function() {
          that.setPage(target, currentPage - 1);
          that.pagination(target, currentPage - 1);
        });
      }
      if (indexOf.call(pageArray, lastPage) >= 0) {
        $(div).find('#lastPage').css('display', 'none');
        $(div).find('.dots').css('display', 'none');
        // $(div).find('#leftArrowBox').css('display', 'none');
      } else {
        $(div).find('#lastPage').css('display', 'block');
        $(div).find('#lastPage').click(function() {
          that.setPage(target, lastPage);
          that.pagination(target, lastPage);
        });
        $(div).find('.dots').css('display', 'block');
        // $(div).find('#leftArrowBox').css('display', 'block');
      }
      if (currentPage == lastPage) {
        $(div).find('#leftArrowBox').css('display', 'none');
      } else {
        $(div).find('#leftArrowBox').css('display', 'block');
        $(div).find('#leftArrowBox').click(function() {
          that.setPage(target, currentPage + 1);
          that.pagination(target, currentPage + 1);
        });
      }
      if (2 == pageArray[0]) {
        $(div).find('.fDots').css('display', 'none');
      }
      if (lastPage - 1 == pageArray[4]) {
        $(div).find('.dots').css('display', 'none');
      }
      $(div).find('.pageNumber').removeClass('selected');
      for (i = j = 1; j <= 5; i = ++j) {
        if (pageArray[i - 1] <= 0) {
          $(div).find('#' + i).css('display', 'none');
        } else {
          $(div).find('#' + i).css('display', 'block');
          $(div).find('#' + i).html(pageArray[i - 1]);
          $(div).find('#' + i).click(function() {
            that.setPage(target, parseInt($(this).html()));
            that.pagination(target, parseInt($(this).html()));
          });
          if (parseInt($(div).find('#' + i).html()) === currentPage) {
            $(div).find('#' + i).addClass('selected');
            $(div).find('#' + i).addClass('currentPage');
          }
        }
      }
    };

    Profile.prototype.setPage = function(target, pageNum) {
      console.log('In funct srtpsahe');
      var arr;
      if (target === 'activity') {
        arr = activity;
        div = $('#activity-tab');
      } else if (target === 'annotations') {
        arr = annotations;
        div = $('#annotations-tab');
      } else if (target === 'transcriptions') {
        arr = transcriptions;
        div = $('#transcriptions-tab');
      } else if (target === 'discussions') {
        arr = discussions;
        div = $('#discussion-tab');
      } else if (target === 'collections') {
        arr = collections;
        div = $('#collections-tab');
      }
      var first = (pageNum - 1) * page;
      var last = pageNum * page;
      if (last > arr.length) {
        last = arr.length;
      }
      var html = "";
      for (var i = first; i < last; i++) {
        var item = arr[i];
        if (target === 'activity') {
          var extra = '';
          if (item['type'] != 'log') {
            extra = '<a href=\'' + arcs.baseURL + 'resource/' + item['kid'] + '\'><span class=\'name\'>' + item['name'] + '</span></a><img alt="activity-image" src="'+item['thumb']+'">';
          }
          html += '<div class=\'cont\'><p><span class=\'time\'>' + item['date'] + '</span><span class=\'' + item['type'] + '\'></span>' + '<span class=\'text\'>' + item['text'] + '</span>' + extra + '</p></div>';
        } else if (target === 'annotations') {
          html += '<div class=\'cont\'><div class=\'img\'><a href=\'' + arcs.baseURL + 'resource/' + item['kid'] + '\'><img alt="annotation-image" src="'+item["thumb"]+'"></a></div><p><a href=\'' + arcs.baseURL + 'resource/' + item['kid'] + '\'><span class=\'name\'>' + item['name'] + '</span></a><span class=\'type\'>'+item["resType"]+'</span><span class=\'date\'>' + item["date"] + '</span></p><p class=\'annotationType\'>' + item["type"] + '</p><a href=' + item["url"] + '>' + item["linkText"] + '</a></div>';
        } else if (target === 'transcriptions') {
          html += '<div class=\'cont\'><div class=\'img\'><a href=\'' + arcs.baseURL + 'resource/' + item['kid'] + '\'><img alt="transcription-image" src="'+item['thumb']+'"></a></div><p><a href=\'' + arcs.baseURL + 'resource/' + item['kid'] + '\'><span class=\'name\'>' + item['name'] + '</span></a><span class=\'type\'>'+item['resType']+'</span><span class=\'date\'>' + item['date'] + '</span></p><p class=\'transcript\'>' + item['transcript'] + '</p></div>';
        } else if (target === 'discussions') {
          html += '<div class=\'cont\'><div class=\'img\'><a href=\'' + arcs.baseURL + 'resource/' + item['kid'] + '\'><img alt="discussion-image" src="'+item['thumb']+'"></a></div><p><a href=\'' + arcs.baseURL + 'resource/' + item['kid'] + '\'><span class=\'name\'>' + item['name'] + '</span></a><span class=\'type\'>'+item['resType']+'</span><span class=\'date\'>' + item['date'] + '</span></p><p class=\'transcript\'>' + item['content'] + '</p></div>';
        }
      }
      if (target == 'collections') {
          var collections_permissions = false;
          if( $('#edit-profile').length > 0 ){
              collections_permissions = true;
          }
          var arrTemp = arr.slice(15 * (pageNum - 1), 15 * pageNum);
          html = arcs.tmpl('collections/profile', {
              collections: arrTemp,
              permissions: collections_permissions
          });
          div.find('#collections-tab-contents').html(html);
      } else {
          div.find('#contents').html(html);
      }
    };

    return Profile;

  })(Backbone.View);

}).call(this);

$(document).ready(function(){
  $(document).on('click', '.pageNumber', function(){
    scrollUp();
  });
  $(document).on('click', '#leftArrowBox', function(){
    scrollUp();
  });
  $(document).on('click', '#rightArrowBox', function(){
    scrollUp();
  });
});

function scrollUp(){
  var time;
  time = ($(window).scrollTop() / $(document).height()) * 1000;
  return $('html, body').animate({
    scrollTop: 0
  }, time);
}
