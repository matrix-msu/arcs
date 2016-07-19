// Generated by CoffeeScript 1.10.0
(function() {
  var extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty,
    indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

  arcs.views.CollectionList = (function(superClass) {
    var adjustPage, fillArray, pagination;

    extend(CollectionList, superClass);

    function CollectionList() {
      return CollectionList.__super__.constructor.apply(this, arguments);
    }

    CollectionList.prototype.initialize = function(options) {
      _.extend(this.options, _.pick(options, 'model', 'collection', 'el'));
      return this.search = new arcs.utils.Search({
        container: $('.search-wrapper'),
        run: false,
        onSearch: (function(_this) {
          return function() {
            return location.href = arcs.url('search', _this.search.query);
          };
        })(this)
      });
    };

    CollectionList.prototype.events = {
      'click summary': 'onClick',
      'click details.closed': 'onClick',
      'click #delete-btn': 'deleteCollection',
      'click .btn-show-all': 'onClick'
    };

    CollectionList.prototype.onClick = function(e) {
      var $el, limit, ref, src;
      console.log("Clicked here.");
      console.log(e.currentTarget.tagName);
      if (e.currentTarget.tagName === 'DETAILS') {
        $el = $(e.currentTarget);
        limit = 1;
        $el.toggleAttr('open');
        $el.toggleClass('closed').toggleClass('open');
        src = arcs.baseURL + 'img/arcs-preloader.gif';
        $(e.currentTarget).children().eq(2).prepend('<img src="' + src + '" alt="SeeAll.svg">');
      } else if (e.currentTarget.className === 'btn-show-all') {
        $el = $(e.currentTarget).parent().parent().parent().parent();
        $(e.currentTarget).removeClass('btn-show-all');
        src = arcs.baseURL + 'img/arcs-preloader.gif';
        $(e.currentTarget).find("img:first").attr('src', src);
        limit = 0;
      } else {
        $el = $(e.currentTarget).parent();
        limit = 1;
        $el.toggleAttr('open');
        $el.toggleClass('closed').toggleClass('open');
        src = arcs.baseURL + 'img/arcs-preloader.gif';
        if ($(e.currentTarget).next().next().children().eq(0).prop("tagName") !== 'IMG') {
          $(e.currentTarget).next().next().prepend('<img src="' + src + '" alt="SeeAll.svg">');
        }
      }
      console.log($el);
      this.renderDetails($el, limit);
      if ((e.srcElement != null)) {
        if (((ref = e.srcElement.tagName) !== 'SPAN' && ref !== 'BUTTON' && ref !== 'I' && ref !== 'A')) {
          e.preventDefault();
          return false;
        }
      }
    };

    CollectionList.prototype.deleteCollection = function(e) {
      var $parent, id, model;
      e.preventDefault();
      $parent = $(e.currentTarget).parents('details');
      id = $parent.data('id');
      model = this.collection.get(id);
      return arcs.confirm("Are you sure you want to delete this collection?", ("<p>Collection <b>" + (model.get('title')) + "</b> will be ") + "deleted. <p><b>N.B.</b> Resources within the collection will not be " + "deleted. They may still be accessed from other collections to which they " + "belong.", (function(_this) {
        return function() {
          arcs.loader.show();
          return $.ajax({
            url: arcs.url('collections', 'delete', model.id),
            type: 'DELETE',
            success: function() {
              _this.collection.remove(model, {
                silent: true
              });
              _this.render();
              return arcs.loader.hide();
            }
          });
        };
      })(this));
    };

    CollectionList.prototype.render = function() {
      var currentCollectionList, fullCollectionList, i, lastPage, numPerPage, temp;
      console.log(this.$el);
      console.log("Fill in collection template here:");
      fullCollectionList = this.collection.toJSON();
      currentCollectionList = [];
      numPerPage = parseInt($('#items-per-page-btn').html().substring(0, 2));
      console.log(numPerPage);
      i = 0;
      while (i < numPerPage && i < fullCollectionList.length) {
        currentCollectionList.push(fullCollectionList[i]);
        i++;
      }
      console.log("page length: " + currentCollectionList.length);
      this.$el.html(arcs.tmpl('collections/list', {
        collections: currentCollectionList
      }));
      this;
      lastPage = Math.ceil(fullCollectionList.length / numPerPage);
      temp = fillArray(1, lastPage);
      pagination(temp, 1, lastPage);
      $('.sort-btn').unbind().click((function(_this) {
        return function(e) {
          console.log("sort-btn clicked");
          $('#items-per-page-btn').html($(e.target).html() + "<span class='pointerDown sort-arrow pointerSearch'></span>");
          $('.pageNumber').removeClass('selected');
          $('.pageNumber').removeClass('currentPage');
          $("#1").addClass('selected');
          $("#1").addClass('currentPage');
          $("#1").html(1);
          return adjustPage(fullCollectionList, parseInt($('.currentPage').html()));
        };
      })(this));
      $(".pageNumber").unbind().click(function(e) {
        if ($(this).hasClass('selected')) {
          e.stopPropagation();
        } else {
          $('.pageNumber').removeClass('selected');
          $('.pageNumber').removeClass('currentPage');
          $(this).addClass('selected');
          $(this).addClass('currentPage');
          adjustPage(fullCollectionList, parseInt($('.currentPage').html()));
        }
      });
      $('#leftArrowBox').unbind().click(function(e) {
        temp = $('.currentPage').html();
        $('.currentPage').html(parseInt(temp) + 1);
        return adjustPage(fullCollectionList, parseInt($('.currentPage').html()));
      });
      $('#rightArrowBox').unbind().click(function(e) {
        temp = $('.currentPage').html();
        if (temp === '1') {

        } else {
          $('.currentPage').html(parseInt(temp) - 1);
          return adjustPage(fullCollectionList, parseInt($('.currentPage').html()));
        }
      });
      $('#dots').unbind().click(function() {
        temp = parseInt($('.currentPage').html()) + 5;
        if (temp > parseInt($("#lastPage").html())) {
          temp = parseInt($("#lastPage").html());
        }
        $('.currentPage').html(temp);
        return adjustPage(fullCollectionList, parseInt($('.currentPage').html()));
      });
      return $('#fDots').unbind().click(function() {
        temp = parseInt($('.currentPage').html()) - 5;
        if (temp < 1) {
          temp = 1;
        }
        $('.currentPage').html(temp);
        return adjustPage(fullCollectionList, parseInt($('.currentPage').html()));
      });
    };

    CollectionList.prototype.renderDetails = function($el, limit) {
      var id, query, query2;
      id = $el.data('id');
      query = encodeURIComponent('collection_id:"' + id + '"');
      query2 = arcs.baseURL + "resources/search?";
      if (limit !== 0) {
        query2 += "n=15&";
      }
      return $.getJSON(query2 + ("q=" + query), function(response) {
        return $el.children('.results').html(arcs.tmpl('home/details', {
          resources: response.results,
          searchURL: arcs.baseURL + ("collection/" + id)
        }));
      });
    };

    pagination = function(pageArray, currentPage, lastPage) {
      var i, j, results1;
      console.log(pageArray);
      if (indexOf.call(pageArray, 1) >= 0) {
        $('#firstPage').css('display', 'none');
        $('.fDots').css('display', 'none');
      } else {
        $('#firstPage').css('display', 'block');
        $('.fDots').css('display', 'block');
      }
      if (1 === currentPage) {
        $('#rightArrow').css('display', 'none');
      } else {
        $('#rightArrow').css('display', 'block');
      }
      if (indexOf.call(pageArray, lastPage) >= 0) {
        $('#lastPage').css('display', 'none');
        $('.dots').css('display', 'none');
        $('#leftArrow').css('display', 'none');
      } else {
        $('#lastPage').css('display', 'block');
        $('.dots').css('display', 'block');
        $('#leftArrow').css('display', 'block');
      }
      if (currentPage === lastPage) {
        $('#lefttArrow').css('display', 'none');
      } else {
        $('#leftArrow').css('display', 'block');
      }
      if (2 === pageArray[0]) {
        $('.fDots').css('display', 'none');
      }
      if (lastPage - 1 === pageArray[4]) {
        $('.dots').css('display', 'none');
      }
      results1 = [];
      for (i = j = 1; j <= 5; i = ++j) {
        if (pageArray[i - 1] <= 0) {
          results1.push($('#' + i).css('display', 'none'));
        } else {
          $('#' + i).css('display', 'block');
          $('#' + i).html(pageArray[i - 1]);
          if (parseInt($('#' + i).html()) === currentPage) {
            $('#' + i).addClass('selected');
            results1.push($('#' + i).addClass('currentPage'));
          } else {
            results1.push(void 0);
          }
        }
      }
      return results1;
    };

    adjustPage = function(results, currentPage) {
      var currentCollectionList, i, lastPage, numberPerPage, pageNum, skip, temp;
      $('.pageNumber').removeClass('currentPage');
      $('.pageNumber').removeClass('selected');
      console.log("CALLED");
      console.log(results);
      pageNum = currentPage;
      console.log(pageNum);
      numberPerPage = parseInt($('#items-per-page-btn').html().substring(0, 2));
      lastPage = Math.ceil(results.length / numberPerPage);
      console.log(lastPage);
      temp = fillArray(pageNum, lastPage);
      console.log(temp);
      pagination(temp, pageNum, lastPage);
      skip = (pageNum - 1) * numberPerPage;
      console.log("skip: " + skip + " (skip+numberPerPage: )" + (skip + numberPerPage));
      $('#lastPage').html(lastPage);
      currentCollectionList = [];
      i = skip;
      while (i < (skip + numberPerPage) && i < results.length) {
        currentCollectionList.push(results[i]);
        i++;
      }
      return $('#all-collections').html(arcs.tmpl('collections/list', {
        collections: currentCollectionList
      }));
    };

    fillArray = function(page, lastPage) {
      var i, results1;
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
      results1 = [];
      while (i < 4) {
        i++;
        if ((page + (i - 2)) <= lastPage) {
          results1.push(page + (i - 2));
        } else {
          results1.push(0);
        }
      }
      return results1;
    };

    return CollectionList;

  })(Backbone.View);

}).call(this);
