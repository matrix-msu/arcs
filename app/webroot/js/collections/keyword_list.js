// Generated by CoffeeScript 1.10.0
(function() {
  var extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty;

  arcs.collections.KeywordList = (function(superClass) {
    extend(KeywordList, superClass);

    function KeywordList() {
      return KeywordList.__super__.constructor.apply(this, arguments);
    }

    KeywordList.prototype.model = arcs.models.Keyword;

    KeywordList.prototype.url = function() {
      return arcs.baseURL + "resources/keywords/" + arcs.resource.id;
    };

    KeywordList.prototype.parse = function(response) {
      var i, k, keywords, len, r;
      keywords = (function() {
        var i, len, results;
        results = [];
        for (i = 0, len = response.length; i < len; i++) {
          r = response[i];
          results.push(r.Keyword);
        }
        return results;
      })();
      for (i = 0, len = keywords.length; i < len; i++) {
        k = keywords[i];
        k.link = arcs.baseURL + "search/" + encodeURIComponent("keyword: '" + k.keyword + "'");
      }
      return keywords;
    };

    return KeywordList;

  })(Backbone.Collection);

}).call(this);
