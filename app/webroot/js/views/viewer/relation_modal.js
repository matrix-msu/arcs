// Generated by CoffeeScript 1.9.2
(function() {
  var extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty;

  arcs.views.RelationModal = (function(superClass) {
    extend(RelationModal, superClass);

    function RelationModal() {
      return RelationModal.__super__.constructor.apply(this, arguments);
    }

    RelationModal.prototype.initialize = function() {
      return RelationModal.__super__.initialize.call(this);
    };

    RelationModal.prototype.miniSearch = function() {};

    return RelationModal;

  })(arcs.views.Modal);

}).call(this);