// Generated by CoffeeScript 1.9.3
(function() {
  var extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty;

  arcs.views.Keyword = (function(superClass) {
    extend(Keyword, superClass);

    function Keyword() {
      return Keyword.__super__.constructor.apply(this, arguments);
    }

    Keyword.prototype.events = {
      'keydown #keyword-btn': 'saveKeyword',
      'click .keyword-remove-btn': 'deleteKeyword'
    };

    Keyword.prototype.initialize = function() {
      this.collection = new arcs.collections.KeywordList;
      arcs.bus.on('indexChange', (function(_this) {
        return function() {
          return _this.collection.fetch();
        };
      })(this));
      this.collection.on('add remove reset sync', this.render, this);
      arcs.utils.autocomplete({
        sel: '#keyword-btn',
        source: arcs.complete('keywords/complete')
      });
      return this.collection.fetch();
    };

    Keyword.prototype.saveKeyword = function(e) {
      var $input, keyword;
      if (e.keyCode !== 13) {
        return;
      }
      e.preventDefault();
      $input = this.$el.find('input#keyword-btn');
      keyword = new arcs.models.Keyword({
        resource_id: arcs.resource.id,
        keyword: $input.val()
      });
      $input.val('');
      keyword.save();
      this.collection.add(keyword);
      return false;
    };

    Keyword.prototype.deleteKeyword = function(e) {
      var $keyword, keyword;
      $keyword = $(e.target).parent().find('.keyword-link');
      keyword = this.collection.get($keyword.data('id'));
      if (!keyword) {
        return;
      }
      return arcs.confirm('Are you sure?', "This keyword will be deleted.", (function(_this) {
        return function() {
          return keyword.destroy();
        };
      })(this));
    };

    Keyword.prototype.render = function() {
      this.$('#keywords-wrapper').html(arcs.tmpl('viewer/keywords', {
        keywords: this.collection.toJSON()
      }));
      return this;
    };

    return Keyword;

  })(Backbone.View);

}).call(this);
