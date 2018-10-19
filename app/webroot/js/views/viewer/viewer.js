// Generated by CoffeeScript 1.10.0
(function() {
  var extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty;

  arcs.views.Viewer = (function(superClass) {
    extend(Viewer, superClass);

    function Viewer() {
      return Viewer.__super__.constructor.apply(this, arguments);
    }
    Viewer.prototype.initialize = function(options) {
      var ref;
      _.extend(this.options, _.pick(options, 'model', 'collection', 'collectionModel', "el"));
      this.collectionModel = this.options.collectionModel;
      this.orderCollection();
      arcs.bus.on('indexChange', this.set, this);
      arcs.bus.on('all', function(name) {
        return arcs.log(name);
      });
      this.collection.on('add change remove', this.render, this);
      this.model.on('add change remove', this.render, this);
      this.throttledResize = _.throttle(this.resize, 500);
      $(window).resize((function(_this) {
        return function() {
          return arcs.bus.trigger('resourceResize');
        };
      })(this));
      arcs.bus.on('resourceResize', this.throttledResize, this);
    //   arcs.keys.map(this, {
    //     left: this.prev,
    //     right: this.next,
    //     '?': this.showHotkeys
    //   });
      this.actions = new arcs.views.ViewerActions({
        el: $('#viewer-controls'),
        collection: this.collection,
        viewer: this
      });
      this.discussion = new arcs.views.DiscussionTab({
        el: $('#discussion')
      });
      this.keywords = new arcs.views.Keyword({
        el: $('#notations')
      });
      this.annotations = new arcs.views.Annotation({
        el: $('#viewer')
      });
      this.carousel = new arcs.views.Carousel({
        el: $('#carousel-wrapper'),
        collection: this.collection,
        index: (ref = this.index) != null ? ref : 0
      });
      this.router = new arcs.routers.Viewer;
      Backbone.history.start({
        pushState: true,
        root: arcs.baseURL + (this.collection.length ? 'collection/' : 'resource/')
      });
      if (this.model.get('first_req')) {
        this.splitPrompt();
      }
      if (this.index == null) {
        this.index = 0;
      }
      return this.resize();
    };

    Viewer.prototype.events = {
      'click #next-btn': 'next',
      'click #prev-btn': 'prev'
    };

    Viewer.prototype.orderCollection = function() {
      var ref;
      if (((ref = this.collectionModel) != null ? ref.id : void 0) == null) {
        return;
      }
      this.collection.each((function(_this) {
        return function(resource) {
          return resource.set('page', resource.get('memberships')[_this.collectionModel.id]);
        };
      })(this));
      return this.collection.sort();
    };

    Viewer.prototype.set = function(identifier, options) {
      var index, model, ref, ref1, ref2, route;
      if (options == null) {
        options = {};
      }
      if (options.noSet) {
        return false;
      }
      if (_.isNumeric(identifier)) {
        index = parseInt(identifier);
        model = this.collection.length ? this.collection.at(index) : this.model;
      } else {
        model = this.collection.get(identifier);
        index = this.collection.models.indexOf(model);
        options.noNavigate = false;
        options.replace = true;
      }
      if (!(model && index >= 0)) {
        return false;
      }
      ref = [model, model, index], this.model = ref[0], arcs.resource = ref[1], this.index = ref[2];
      if (options.trigger) {
        arcs.bus.trigger('indexChange', index, {
          noSet: true
        });
      }
      if (!options.noRender) {
        this.render();
      }
      route = ((ref1 = (ref2 = arcs.collectionModel) != null ? ref2.id : void 0) != null ? ref1 : this.model.id) + "/" + (this.index + 1);
      if (!options.noNavigate) {
        this.router.navigate(route, {
          replace: options.replace
        });
      }
      if (!options.noPreload) {
        this._preloadNeighbors();
      }
      return true;
    };

    Viewer.prototype._preloadNeighbors = function() {
      if (this.collection.at(this.index + 1) != null) {
        arcs.preload(this.collection.at(this.index + 1).get('url'));
      }
      if (this.collection.at(this.index - 1) != null) {
        return arcs.preload(this.collection.at(this.index - 1).get('url'));
      }
    };

    Viewer.prototype.next = function() {
      return this.set(this.index + 1, {
        trigger: true
      });
    };

    Viewer.prototype.prev = function() {
      return this.set(this.index - 1, {
        trigger: true
      });
    };

    Viewer.prototype.openFull = function() {
      return window.open(this.model.get('url'), '_blank', 'menubar=no');
    };

    Viewer.prototype.checkNav = function() {
      if (this.collection.length === this.index + 1) {
        this.$('#next-btn').addClass('disabled');
      } else {
        this.$('#next-btn').removeClass('disabled');
      }
      if (this.index === 0) {
        return this.$('#prev-btn').addClass('disabled');
      } else {
        return this.$('#prev-btn').removeClass('disabled');
      }
    };

    Viewer.prototype.splitPrompt = function() {
      if (this.model.get('mime_type') !== 'application/pdf') {
        return;
      }
      return new arcs.views.Modal({
        title: "Split into a PDF?",
        subtitle: "We noticed you've uploaded a PDF. If you'd like, " + "we can split the PDF into a collection, where it can be " + "annotated and commented on--page by page.",
        buttons: {
          yes: {
            "class": 'btn btn-success',
            callback: (function(_this) {
              return function() {
                return $.post(arcs.baseURL + 'resources/split_pdf/' + _this.model.id);
              };
            })(this)
          },
          no: function() {}
        }
      });
    };

    Viewer.prototype.showHotkeys = function() {
      if ($('.hotkeys-modal').length) {
        return $('.hotkeys-modal').remove();
      }
      return new arcs.views.Hotkeys({
        template: 'viewer/hotkeys'
      });
    };

    Viewer.prototype.resize = function() {
      var $resource, $well, $wrapping, COLLECTION, STANDALONE, TAB_MARGIN, height, margin, zoomLevel;
      STANDALONE = 128;
      COLLECTION = 204;
      TAB_MARGIN = 75;
      $resource = this.$("img[alt='resource']");
      $wrapping = this.$('#wrapping');
      $well = this.$('.viewer-well');
      margin = $('body').hasClass('standalone') ? STANDALONE : COLLECTION;
      height = $(window).height() - margin;
      zoomLevel = $resource.data('zoom');
      $well.height(height);
      $resource.height(height * zoomLevel);
      $wrapping.height(height).width($well.width() - 36);
      this.$('.tab-content').height(height - TAB_MARGIN);
      if ($wrapping.data().kineticSettings != null) {
        $wrapping.kinetic('detach');
      }
      if (zoomLevel > 1) {
        return $wrapping.kinetic();
      }
    };

    Viewer.prototype.render = function() {
      var mimeInfo, template;
      mimeInfo = arcs.utils.mime.getInfo(this.model.get('mime_type'));
      switch (mimeInfo.type) {
        case 'image':
          template = 'viewer/image';
          break;
        case 'document':
          template = 'viewer/document';
          break;
        case 'video':
          template = 'viewer/video';
          break;
        default:
          template = 'viewer/unknown';
      }
      this.$('#resource').html(arcs.tmpl(template, this.model.toJSON()));
      this.$("img[alt='resource']").load(arcs.bus.trigger('resourceLoaded'));
      this.$('#resource-details').html(arcs.tmpl('viewer/table', this.model.toJSON()));
      if (this.collectionModel != null) {
        this.$('#collection-details').html(arcs.tmpl('viewer/collection_table', this.collectionModel.toJSON()));
      }
      this.checkNav();
      this.resize();
      return this;
    };

    return Viewer;

  })(Backbone.View);

}).call(this);
