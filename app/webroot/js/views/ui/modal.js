// Generated by CoffeeScript 1.9.3
(function() {
  var extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty;

  arcs.views.Modal = (function(superClass) {
    extend(Modal, superClass);

    function Modal() {
      return Modal.__super__.constructor.apply(this, arguments);
    }

    Modal.prototype.options = {
      draggable: true,
      backdrop: true,
      keyboard: true,
      show: true,
      "class": '',
      title: 'No Title',
      subtitle: null,
      template: 'ui/modal',
      inputs: {},
      buttons: {}
    };

    Modal.prototype.initialize = function() {
      var $sel, name, options, ref, ref1;
      $('#modal').remove();
      $('.modal-backdrop').remove();
      $('body').append(arcs.tmpl('ui/modal_wrapper'));
      this.el = this.$el = $('#modal');
      if (this.options["class"]) {
        this.$el.addClass(this.options["class"]);
      }
      this.$el.html(arcs.tmpl(this.options.template, this.options));
      ref = this.options.inputs;
      for (name in ref) {
        options = ref[name];
        $sel = this.$("#modal-" + name + "-input");
        if (options.complete || options.multicomplete) {
          arcs.utils.autocomplete({
            sel: $sel,
            multiple: !!options.multicomplete,
            source: (ref1 = options.multicomplete) != null ? ref1 : options.complete
          });
        }
      }
      if (this.options.draggable) {
        this.$el.draggable({
          handle: this.$('.modal-header')
        });
        this.$('.modal-header').css('cursor', 'move');
      }
      this.$el.modal({
        backdrop: this.options.backdrop,
        keyboard: this.options.keyboard,
        show: this.options.show
      });
      return this.bindButtons();
    };

    Modal.prototype.hide = function() {
      return this.$el.modal('hide');
    };

    Modal.prototype.show = function() {
      return this.$el.modal('show');
    };

    Modal.prototype.isOpen = function() {
      return this.$el.is(':visible');
    };

    Modal.prototype.validate = function() {
      var i, len, name, options, ref, required, values;
      this.$('#validation-error').hide();
      this.$('.error').removeClass('error');
      values = this.getValues();
      required = [];
      ref = this.options.inputs;
      for (name in ref) {
        options = ref[name];
        if (options.required) {
          if (!values[name].replace(/\s/g, '').length) {
            required.push(name);
          }
        }
      }
      if (!required.length) {
        return true;
      }
      for (i = 0, len = required.length; i < len; i++) {
        name = required[i];
        this.$("#modal-" + name + "-input").addClass('error');
        this.$("label[for='modal-" + name + "']").addClass('error');
      }
      this.$('#validation-error').show().html('Looks like you missed a required field.');
      return false;
    };

    Modal.prototype.getValues = function() {
      var name, values;
      values = {};
      for (name in this.options.inputs) {
        values[name] = this.$("#modal-" + name + "-input").val();
      }
      return values;
    };

    Modal.prototype.bindButtons = function() {
      var name, results;
      results = [];
      for (name in this.options.buttons) {
        results.push(this.$("button#modal-" + name + "-button").click((function(_this) {
          return function(e) {
            var callback, cb, context, options, ref, ref1, ref2, valid;
            name = e.target.id.match(/modal-([\w-]+)-button/)[1];
            options = _this.options.buttons[name];
            if (_.isFunction(options)) {
              cb = options;
            } else {
              ref2 = [(ref = options.callback) != null ? ref : (function() {}), (ref1 = options.context) != null ? ref1 : window], callback = ref2[0], context = ref2[1];
              cb = _.bind(callback, context);
            }
            valid = options.validate ? _this.validate() : true;
            if (valid) {
              cb(_this.getValues());
            }
            if (!(((options.close != null) && options.close) || !valid)) {
              return _this.hide();
            }
          };
        })(this)));
      }
      return results;
    };

    return Modal;

  })(Backbone.View);

}).call(this);
