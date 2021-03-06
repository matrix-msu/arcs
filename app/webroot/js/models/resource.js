// Generated by CoffeeScript 1.10.0
(function() {
  var extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty;

  arcs.models.Resource = (function(superClass) {
    extend(Resource, superClass);

    Resource.prototype.defaults = {
      title: '',
      keywords: [],
      annotations: [],
      comments: [],
      metadata: {},
      mime_type: "unknown",
      page: 0,
      preview: false,
      "public": false,
      selected: false
    };

    function Resource(attributes) {
      Resource.__super__.constructor.call(this, this.parse(attributes));
    }

    Resource.prototype.url = function() {
      return arcs.baseURL + 'resources/' + this.id;
    };

    Resource.prototype.urlRoot = arcs.baseURL + 'resources';

    Resource.prototype.parse = function(r) {
      var i, j, k, len, len1, m, ref, ref1, ref2, v;
      if (r.Resource != null) {
        ref = r.Resource;
        for (k in ref) {
          v = ref[k];
          r[k] = v;
        }
        if (r.User != null) {
          r.user = r.User;
          delete r.User;
        }
        if (r.Keyword != null) {
          r.keywords = (function() {
            var i, len, ref1, results;
            ref1 = r.Keyword;
            results = [];
            for (i = 0, len = ref1.length; i < len; i++) {
              k = ref1[i];
              results.push(k.keyword);
            }
            return results;
          })();
          delete r.Keyword;
        }
        if (r.Comment != null) {
          r.comments = r.Comment;
          delete r.Comment;
        }
        if (r.Flag != null) {
          r.flags = r.Flag;
          delete r.Flag;
        }
        if (r.Membership != null) {
          r.memberships = {};
          ref1 = r.Membership;
          for (i = 0, len = ref1.length; i < len; i++) {
            m = ref1[i];
            r.memberships[m.collection_id] = parseInt(m.page);
          }
          delete r.Membership;
        }
        if (r.Annotation != null) {
          r.annotations = r.Annotation;
          delete r.Annotation;
        }
        if (r.Metadatum != null) {
          r.metadata = new arcs.models.MetadataContainer;
          r.metadata.id = r.id;
          ref2 = r.Metadatum;
          for (j = 0, len1 = ref2.length; j < len1; j++) {
            m = ref2[j];
            r.metadata.set(m.attribute, m.value);
          }
          delete r.Metadatum;
        }
        delete r.Resource;
      }
      if (r.modified === r.created) {
        r.modified = false;
      }
      return r;
    };

    return Resource;

  })(Backbone.Model);

}).call(this);
