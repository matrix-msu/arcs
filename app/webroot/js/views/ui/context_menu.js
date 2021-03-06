// Generated by CoffeeScript 1.10.0
(function() {
  var extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty;

  arcs.views.ContextMenu = (function(superClass) {
    extend(ContextMenu, superClass);

    function ContextMenu() {
      return ContextMenu.__super__.constructor.apply(this, arguments);
    }

    ContextMenu.prototype.events = {
      'click *': 'hide'
    };

    ContextMenu.prototype.options = {
      options: {
        'Example option': function() {},
        'Another option': function() {}
      },
      context: window,
      onShow: function() {}
    };

    ContextMenu.prototype.initialize = function(options) {
      _.extend(this.options, _.pick(options, "el", 'filter', 'options', 'onShow', 'context'));
      $('.context-menu').remove();
      $('body').append(arcs.tmpl('ui/context_menu', {
        options: this.options.options
      }));
      this.menu = $('.context-menu');
      return this.addEvents();
    };

    ContextMenu.prototype.show = function(e) {
      this.hide();
      this.menu.css({
        position: 'absolute',
        top: e.pageY + 'px',
        left: e.pageX + 'px'
      });
      this.menu.show();
      this.options.onShow(e);
      e.preventDefault();
      return false;
    };

    ContextMenu.prototype.addEvents = function() {
      var boundCb, cb, id, opt, ref;
      this.events["contextmenu " + this.options.filter] = 'show';
      ref = this.options.options;
      for (opt in ref) {
        cb = ref[opt];
        if (this.options.context[cb] == null) {
          continue;
        }
        boundCb = _.bind(this.options.context[cb], this.options.context);
        id = arcs.inflector.identifierize(opt);
        this.events["click #context-menu-option-" + id] = boundCb;
      }
      return this.delegateEvents();
    };

    ContextMenu.prototype.hide = function(e) {
      return this.menu.hide();
    };

    return ContextMenu;

  })(Backbone.View);

}).call(this);
