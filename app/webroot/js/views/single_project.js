// Generated by CoffeeScript 1.10.0
(function() {
  var extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty;

  arcs.views.SingleProject = (function(superClass) {
    extend(SingleProject, superClass);

    function SingleProject() {
      return SingleProject.__super__.constructor.apply(this, arguments);
    }

    SingleProject.prototype.initialize = function(options) {
      return _.extend(this.options, _.pick(options, 'model', 'collection', 'el'));
    };

    SingleProject.prototype.events = {
      'click summary': 'onClick',
      'click details.closed': 'onClick',
      'click #delete-btn': 'deleteCollection',
      'click .btn-show-all': 'onClick'
    };

    SingleProject.prototype.onClick = function(e) {
      var $el, limit, ref, src;
      if (e.currentTarget.tagName === 'DETAILS') {
        $el = $(e.currentTarget);
        if ($el[0].hasAttribute("open")) {
          $el.children('div').html('');
          return;
        }
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
        if ($el[0].hasAttribute("open")) {
          $el.children('div').html('');
          return;
        }
        limit = 1;
        $el.toggleAttr('open');
        $el.toggleClass('closed').toggleClass('open');
        src = arcs.baseURL + 'img/arcs-preloader.gif';
        if ($(e.currentTarget).next().next().children().eq(0).prop("tagName") !== 'IMG') {
          $(e.currentTarget).next().next().prepend('<img src="' + src + '" alt="SeeAll.svg">');
        }
      }
      this.renderDetails($el, limit);
      if ((e.srcElement != null)) {
        if (((ref = e.srcElement.tagName) !== 'SPAN' && ref !== 'BUTTON' && ref !== 'I' && ref !== 'A')) {
          e.preventDefault();
          return false;
        }
      }
    };

    SingleProject.prototype.render = function() {
      var fullCollectionList;
      fullCollectionList = this.collection.toJSON();
      fullCollectionList.reverse();
      this.$el.html(arcs.tmpl('collections/list', {
        collections: fullCollectionList
      }));
      return this;
    };

    SingleProject.prototype.renderDetails = function($el, limit) {
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

    return SingleProject;

  })(Backbone.View);

}).call(this);
