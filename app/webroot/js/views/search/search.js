// Generated by CoffeeScript 1.10.0
(function() {
  var base,
    extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty;

  if ((base = arcs.views).search == null) {
    base.search = {};
  }

  arcs.views.search.Search = (function(superClass) {
    var search;

    extend(Search, superClass);

    function Search() {
      return Search.__super__.constructor.apply(this, arguments);
    }

    Search.prototype.options = {
      sort: 'title',
      sortDir: 'asc',
      grid: true,
      url: arcs.baseURL + 'search/'
    };


    /* Initialize and define events */

    Search.prototype.initialize = function(options) {
      _.extend(this.options, _.pick(options, 'el'));
      this.setupSelect();
      this.setupSearch();
      Backbone.history.start({
        pushState: true,
        root: this.options.url
      });
      this.search.results.on('change remove', this.render, this);
      arcs.bus.on('selection', this.afterSelection, this);
      arcs.keys.map(this, {
        'ctrl+a': this.selectAll,
        '?': this.showHotkeys,
        t: this.scrollTop
      });
      return this.setupHelp();
    };

    Search.prototype.events = {
      'click #grid-btn': 'toggleView',
      'click #list-btn': 'toggleView',
      'click #top-btn': 'scrollTop',
      'click .sort-btn': 'setSort',
      'click .dir-btn': 'setSortDir',
      'click .search-page-btn': 'setPage',
      'click .search-type': 'addFacet'
    };


    /* More involved setups run by the initialize method */

    Search.prototype.setupSelect = function() {
      return this.$el.find('#search-results').selectable({
        distance: 20,
        filter: '.img-wrapper img',
        selecting: (function(_this) {
          return function(e, ui) {
            $(ui.selecting).parents('.result').addClass('selected');
            $(ui.selecting).parents('.result').children('.select-button').html('DE-SELECT');
            $(ui.selecting).parents('.result').children('.select-button').addClass('de-select');
            return _this.afterSelection();
          };
        })(this),
        selected: (function(_this) {
          return function(e, ui) {
            $(ui.selected).parents('.result').addClass('selected');
            $(ui.selected).parents('.result').children('.select-button').html('DE-SELECT');
            $(ui.selected).parents('.result').children('.select-button').addClass('de-select');
            return _this.afterSelection();
          };
        })(this),
        unselecting: (function(_this) {
          return function(e, ui) {
            $(ui.unselecting).parents('.result').removeClass('selected');
            $(ui.unselecting).parents('.result').children('.select-button').html('SELECT');
            $(ui.unselecting).parents('.result').children('.select-button').removeClass('de-select');
            return _this.afterSelection();
          };
        })(this),
        unselected: (function(_this) {
          return function(e, ui) {
            $(ui.unselected).parents('.result').removeClass('selected');
            $(ui.unselected).parents('.result').children('.select-button').html('SELECT');
            $(ui.unselected).parents('.result').children('.select-button').removeClass('de-select');
            return _this.afterSelection();
          };
        })(this)
      });
    };

    Search.prototype.setupSearch = function() {
      this.scrollReady = false;
      return this.search = new arcs.utils.Search({
        container: $('searchBox'),
        order: this.options.sort,
        run: false,
        loader: true,
        success: (function(_this) {
          return function() {
            _this.router.navigate((encodeURIComponent(_this.search.query)) + "/p" + _this.search.page);
            if (!_this.scrollReady) {
              _this.setupScroll() && (_this.scrollReady = true);
            }
            _this.setupHelp();
            return _this.render();
          };
        })(this)
      });
    };

    Search.prototype.setupScroll = function() {
      var $actions, $results, $window, pos, ref;
      ref = [this.$('#search-actions'), this.$('#search-results')], $actions = ref[0], $results = ref[1];
      $window = $(window);
      pos = $actions.offset().top - 10;
      return $window.resize(function() {
        if ($window.scrollTop() > pos) {
          return $actions.width($results.width() + 23);
        }
      });
    };

    Search.prototype.setupHelp = function() {
      if (!$('.search-help-btn').length) {
        $('.VS-search-inner').append(arcs.tmpl('search/help-toggle'));
        $('.search-help-btn').click(this.showHelp);
        return $('.search-help-close').click(this.closeHelp);
      }
    };

    Search.prototype.toggleView = function() {
      this.options.grid = !this.options.grid;
      this.$('#grid-btn').toggleClass('active');
      this.$('#list-btn').toggleClass('active');
      return this.render();
    };

    Search.prototype.scrollTop = function() {
      var time;
      time = ($(window).scrollTop() / $(document).height()) * 1000;
      return $('html, body').animate({
        scrollTop: 0
      }, time);
    };

    Search.prototype.setSort = function(e) {
      this.options.sort = e.target.id.match(/sort-(\w+)-btn/)[1];
      this.$('.sort-btn .icon-ok').remove();
      this.$(e.target).append(this.make('i', {
        "class": 'icon-ok'
      }));
      this.$('#sort-btn span#sort-by').html(this.options.sort);
      console.log("SEARCHING");
      return this.search.run(null, {
        order: this.options.sort,
        direction: this.options.sortDir
      });
    };

    Search.prototype.setSortDir = function(e) {
      this.options.sortDir = e.target.id.match(/dir-(\w+)-btn/)[1];
      this.$('.dir-btn .icon-ok').remove();
      this.$(e.target).append(this.make('i', {
        "class": 'icon-ok'
      }));
      return this.search.run(null, {
        order: this.options.sort,
        direction: this.options.sortDir
      });
    };

    Search.prototype.setPage = function(e) {
      e.preventDefault();
      this.$el = $(e.currentTarget);
      this.search.options.page = this.$el.data('page');
      return this.search.run();
    };

    Search.prototype.unselectAll = function(trigger) {
      if (trigger == null) {
        trigger = true;
      }
      this.$('.result').removeClass('selected');
      this.$('.select-button').removeClass('de-select');
      this.$('.select-button, #toggle-select').html('SELECT');
      this.$('#deselect-all').attr({
        id: 'select-all'
      });
      if (trigger) {
        return arcs.bus.trigger('selection');
      }
    };

    Search.prototype.selectAll = function(trigger) {
      if (trigger == null) {
        trigger = true;
      }
      this.$('.result').addClass('selected');
      this.$('.select-button').addClass('de-select');
      this.$('.select-button, #toggle-select').html('DE-SELECT');
      this.$('#select-all').attr({
        id: 'deselect-all'
      });
      if (trigger) {
        return arcs.bus.trigger('selection');
      }
    };

    Search.prototype.toggle = function(e) {
      if (!(e.ctrlKey || e.shiftKey || e.metaKey)) {
        this.unselectAll(false);
      }
      $(e.currentTarget).parents('.result').toggleClass('selected');
      return arcs.bus.trigger('selection');
    };

    Search.prototype.maybeUnselectAll = function(e) {
      if (!(e instanceof jQuery.Event)) {
        return this.unselectAll();
      }
      if (e.metaKey || e.ctrlKey || e.shiftKey) {
        return false;
      }
      if ($(e.target).attr('src')) {
        return false;
      }
      return this.unselectAll();
    };

    Search.prototype.showHotkeys = function() {
      if ($('.hotkeys-modal').length) {
        return $('.hotkeys-modal').remove();
      }
      return new arcs.views.Hotkeys({
        template: 'search/hotkeys'
      });
    };

    Search.prototype.showHelp = function() {
      return $('.search-help').show();
    };

    Search.prototype.closeHelp = function() {
      return $('.search-help').hide();
    };


    /* Render the search results */

    Search.prototype.afterSelection = function() {
      return _.defer((function(_this) {
        return function() {
          var num, selected;
          selected = $('.result.selected').map(function() {
            return $(this).data('id');
          }).get();
          num = $('.result.selected').length;
          $('#selected-count').html(num);
          if (num !== 0) {
            $('#selected-all').css({
              color: 'black'
            });
          } else {
            $('#selected-all').css({
              color: '#C1C1C1'
            });
          }
          _this.search.results.unselectAll();
          if (selected.length) {
            _this.search.results.select(selected);
          }
          if (_this.search.results.anySelected()) {
            $('.btn.needs-resource').removeClass('disabled');
            return $('#search input').blur();
          } else {
            return $('.btn.needs-resource').addClass('disabled');
          }
        };
      })(this));
    };

    $('.dropdown-menu').change(function(event) {
      return console.log("Dropdown select");
    });

    Search.prototype.append = function() {
      var results;
      if (!(this.search.results.length > this.search.options.n)) {
        return;
      }
      results = new arcs.collections.ResultSet(this.search.getLast());
      return this._render({
        results: results.toJSON()
      }, true);
    };

    Search.prototype.addFacet = function(e) {
      e.preventDefault();
      return this.search.vs.searchBox.addFacet(e.target.text, '', 10);
    };

    search = function() {
      var resources, totalResults, val;
      val = $(".searchBoxInput").val();
      resources = new Promise(function(resolve, reject) {
        var req, resourcequery;
        resourcequery = encodeURIComponent("" + val);
        return req = $.getJSON(arcs.baseURL + 'simple_search/' + resourcequery, function(response) {
          var resp;
          console.log(response);
          resp = jQuery.parseJSON(response['results']);
          return resolve(resp);
        });
      });
      totalResults = [];
      return Promise.all([resources]).then(function(values) {
        var key, ref, value;
        ref = values[0];
        for (key in ref) {
          value = ref[key];
          totalResults.push(value);
        }
        $('#results-count').html(totalResults.length);
        Search.prototype._render({
          results: totalResults
        });
        return $('#search-pagination').html(arcs.tmpl('search/paginate', {
          results: totalResults
        }));
      });
    };

    $(function() {
      return $(".searchBoxInput").keyup(function(e) {
        if (e.keyCode === 13) {
          e.preventDefault();
          return search();
        }
      });
    });

    Search.prototype._render = function(results, append) {
      var $results, template;
      if (append == null) {
        append = false;
      }
      $results = $('.flex-container');
      template = this.options.grid ? 'search/grid' : 'search/list';
      results = results.results;
      $results[append ? 'append' : 'html'](arcs.tmpl(template, {
        results: results
      }));
      $('div.result').hover((function() {
        $(this).find('.select-button').show();
        $(this).find('img').addClass('img-hover');
      }), function() {
        $(this).find('.select-button').hide();
        $(this).find('img').removeClass('img-hover');
      });
      $('.select-button').click(function() {
        if ($(this).html() === 'SELECT') {
          $(this).html('DE-SELECT');
          $(this).addClass('de-select');
          $(this).parents('.result').addClass('selected');
          arcs.bus.trigger('selection');
        } else {
          $(this).html('SELECT');
          $(this).removeClass('de-select');
          $(this).parents('.result').removeClass('selected');
          arcs.bus.trigger('selection');
        }
      });
      if (!results.length > 0) {
        return $results.html("<div id='no-results'>No Results</div>");
      }
    };

    return Search;

  })(Backbone.View);

}).call(this);
