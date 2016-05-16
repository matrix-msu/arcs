// Generated by CoffeeScript 1.10.0
(function() {
  var slice = [].slice;

  arcs.confirm = function() {
    var i, msg, onConfirm, ref;
    msg = 2 <= arguments.length ? slice.call(arguments, 0, i = arguments.length - 1) : (i = 0, []), onConfirm = arguments[i++];
    return new arcs.views.Modal({
      title: msg[0],
      subtitle: (ref = msg[1]) != null ? ref : '',
      buttons: {
        yes: {
          "class": 'btn btn-danger',
          callback: onConfirm
        },
        no: function() {}
      }
    });
  };

  arcs.prompt = function() {
    var msg, ref;
    msg = 1 <= arguments.length ? slice.call(arguments, 0) : [];
    return new arcs.views.Modal({
      title: msg[0],
      subtitle: (ref = msg[1]) != null ? ref : '',
      buttons: {
        ok: {
          "class": 'btn btn-primary',
          callback: function() {}
        }
      }
    });
  };

  arcs.needsLogin = function() {
    return location.href = arcs.url('/#loginModal');
  };

}).call(this);
