// Generated by CoffeeScript 1.10.0
(function() {
  var extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty;

  arcs.models.Keyword = (function(superClass) {
    extend(Keyword, superClass);

    function Keyword() {
      return Keyword.__super__.constructor.apply(this, arguments);
    }

    Keyword.prototype.url = function() {
      if (this.isNew()) {
        return arcs.baseURL + 'keywords';
      }
      return arcs.baseURL + ("keywords/" + this.id);
    };

    return Keyword;

  })(Backbone.Model);

}).call(this);
