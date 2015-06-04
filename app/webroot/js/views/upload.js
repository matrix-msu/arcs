// Generated by CoffeeScript 1.9.3
(function() {
  var extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty,
    indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

  arcs.views.Upload = (function(superClass) {
    extend(Upload, superClass);

    function Upload() {
      return Upload.__super__.constructor.apply(this, arguments);
    }

    Upload.prototype.UPLOAD_ERR_OK = 0;

    Upload.prototype.UPLOAD_ERR_INI_SIZE = 1;

    Upload.prototype.UPLOAD_ERR_FORM_SIZE = 2;

    Upload.prototype.UPLOAD_ERR_PARTIAL = 3;

    Upload.prototype.UPLOAD_ERR_NO_FILE = 4;

    Upload.prototype.pending = 0;

    Upload.prototype.progress = 0;

    Upload.prototype.allDone = false;

    Upload.prototype.initialize = function() {
      this.uploads = new arcs.collections.UploadSet;
      this.setupFileupload();
      this.$uploads = this.$el.find('#uploads-container');
      return this.uploads.on('add remove change', this.render, this);
    };

    Upload.prototype.events = {
      'click #upload-btn': 'upload',
      'click .remove': 'remove'
    };

    Upload.prototype.setupFileupload = function() {
      this.fileupload = this.$el.find('#fileupload');
      return this.fileupload.fileupload({
        dataType: 'json',
        url: arcs.url('uploads/add_files'),
        add: (function(_this) {
          return function(e, data) {
            var existing, f, i, len, maybeUploads, u, upload, uploads;
            maybeUploads = (function() {
              var i, len, ref, results;
              ref = data.files;
              results = [];
              for (i = 0, len = ref.length; i < len; i++) {
                f = ref[i];
                results.push(new arcs.models.Upload(f));
              }
              return results;
            })();
            existing = _this.uploads.pluck('name');
            uploads = _.reject(maybeUploads, function(u) {
              var name;
              name = u.get('name');
              if (indexOf.call(existing, name) >= 0) {
                arcs.notify(("You tried to add '" + name + "', but a file with that ") + "name is already being uploaded, so we couldn't add it. If it is " + "not the same file, change the name or upload it in another " + "batch.", 'error', false);
                return true;
              }
              return false;
            });
            if (!uploads.length) {
              return false;
            }
            _this.uploads.add(uploads);
            for (i = 0, len = uploads.length; i < len; i++) {
              u = uploads[i];
              upload = u.toJSON();
              upload.cid = u.cid;
              _this.$uploads.append(arcs.tmpl('upload/list', upload));
            }
            _this.$('span#drop-msg').remove();
            _this.$('#upload-btn').addClass('disabled');
            data.submit();
            return _this.pending += 1;
          };
        })(this),
        fail: (function(_this) {
          return function(e, data) {
            if (data.errorThrown === 'Forbidden') {
              return arcs.needsLogin();
            }
          };
        })(this),
        progress: (function(_this) {
          return function(e, data) {
            var f, i, len, model, progress, ref;
            progress = parseInt(data.loaded / data.total * 100, 10);
            ref = data.files;
            for (i = 0, len = ref.length; i < len; i++) {
              f = ref[i];
              model = _this.uploads.find(function(m) {
                return m.get('name') === f.name;
              });
              model.set('progress', progress);
            }
            return _this.render();
          };
        })(this),
        progressall: (function(_this) {
          return function(e, data) {
            _this.progress = data.loaded / data.total * 100;
            return _this.render();
          };
        })(this),
        done: (function(_this) {
          return function(e, data) {
            var f, i, len, model, ref, response;
            ref = data.files;
            for (i = 0, len = ref.length; i < len; i++) {
              f = ref[i];
              model = _this.uploads.find(function(m) {
                return m.get('name') === f.name;
              });
              response = _.find(data.result, function(r) {
                return r.name === f.name;
              });
              model.set('progress', 100);
              model.set('sha', response.sha);
              model.set('error', response.error);
            }
            _this.pending -= 1;
            if (!_this.pending) {
              _this.$el.find('#upload-btn').removeClass('disabled');
              _this.allDone = true;
            }
            return _this.checkForErrors() && _this.render();
          };
        })(this)
      });
    };

    Upload.prototype.upload = function() {
      if (this.pending !== 0) {
        return arcs.notify('Downloads are still pending.', 'error');
      }
      if (!this.uploads.length) {
        return arcs.notify('Choose a file to upload.', 'error');
      }
      this.uploads.each((function(_this) {
        return function(u) {
          var $u;
          $u = _this.$uploads.find(".upload[data-id=" + u.cid + "]");
          u.set('title', $u.find('#upload-title').val());
          u.set('identifier', $u.find('#upload-identifier').val());
          u.set('rtype', $u.find('#upload-type').val());
          if (u.get('identifier') === 'Identifier') {
            return u.set('identifier', '');
          }
        };
      })(this));
      return $.postJSON(arcs.baseURL + 'uploads/batch', this.uploads.toJSON(), function(data) {
        return location.href = arcs.url('search/');
      });
    };

    Upload.prototype.checkForErrors = function() {
      var error, i, len, msg, ref, results, upload;
      ref = this.uploads.models;
      results = [];
      for (i = 0, len = ref.length; i < len; i++) {
        upload = ref[i];
        error = upload.get('error');
        if (error === this.UPLOAD_ERR_OK) {
          continue;
        }
        if (error === this.UPLOAD_ERR_INI_SIZE || error === this.UPLOAD_ERR_FORM_SIZE) {
          msg = ("The file '" + (upload.get('name')) + "' was too large. If ") + "possible, split the file into pieces.";
        } else if (error === this.UPLOAD_ERR_PARTIAL) {
          msg = ("The file '" + (upload.get('name')) + "' was only partially ") + "uploaded. Please refresh the page and try again.";
        } else {
          msg = "Something went wrong. Please refresh the page and " + "try again. If the problem persists, contact the system " + "administrator.";
        }
        msg += " For more information, see our " + ("<a href='" + (arcs.url('help/uploading')) + "'>Uploading ") + "documentation.</a>";
        arcs.notify(msg, 'error', false);
        results.push(this.disable());
      }
      return results;
    };

    Upload.prototype.remove = function(e) {
      var $upload;
      $upload = this.$(e.currentTarget).parents('.upload');
      this.uploads.remove(this.uploads.getByCid($upload.data('id')));
      $upload.remove();
      if (!this.uploads.length) {
        return this.$('#upload-btn').addClass('disabled');
      }
    };

    Upload.prototype.disable = function() {
      this.$el.addClass('disabled');
      return this.$el.find('a, button').addClass('disabled');
    };

    Upload.prototype.render = function() {
      var $u, i, len, msg, ref, upload;
      ref = this.uploads.models;
      for (i = 0, len = ref.length; i < len; i++) {
        upload = ref[i];
        $u = this.$uploads.find(".upload[data-id=" + upload.cid + "]");
        if (upload.get('progress') < 100) {
          $u.find('.bar').css('width', upload.get('progress') + '%');
        } else {
          $u.find('.progress').hide();
          $u.find('span#progress-done').show();
        }
      }
      if (this.allDone) {
        msg = "<i class='icon-ok'></i> All Done";
      } else if (this.progress === 100 || this.pending === 0) {
        msg = "<i class='icon-time'></i> Waiting on server...";
      } else {
        msg = (this.progress.toFixed(2)) + "% (" + this.pending + " pending)";
      }
      this.$('span#progress-all').html(msg);
      return this;
    };

    return Upload;

  })(Backbone.View);

}).call(this);
