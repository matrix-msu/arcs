// Generated by CoffeeScript 1.9.2
(function() {
  var extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty;

  arcs.collections.UploadSet = (function(superClass) {
    extend(UploadSet, superClass);

    function UploadSet() {
      return UploadSet.__super__.constructor.apply(this, arguments);
    }

    UploadSet.prototype.model = arcs.models.Upload;

    UploadSet.prototype.url = function() {
      return arcs.baseURL + 'uploads';
    };

    return UploadSet;

  })(Backbone.Collection);

}).call(this);