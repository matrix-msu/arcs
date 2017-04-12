// Generated by CoffeeScript 1.10.0
(function() {
  var extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
    hasProp = {}.hasOwnProperty;

  arcs.views.Home = (function(superClass) {
    extend(Home, superClass);

    function Home() {
      return Home.__super__.constructor.apply(this, arguments);
    }

    Home.prototype.initialize = function(options) {
      _.extend(this.options, _.pick(options, "el"));
      this.search = new arcs.utils.Search({
        container: $('.search-wrapper'),
        run: false,
        onSearch: (function(_this) {

          return function() {
            return location.href = arcs.url('search', _this.search.query);
          };
        })(this)
      });
      return $('details:first').children().eq(0).trigger("click");

    };

    Home.prototype.events = {
      'click summary': 'onClick',
      'click .btn-show-all': 'onClick'
    };

    Home.prototype.onClick = function(e) {
      var $el, limit, src;
      if (e.currentTarget.tagName === 'SUMMARY') {
        $el = $(e.currentTarget).parent();
        if ($el[0].hasAttribute("open")) {
          $el.children('div').html('');
          return;
        }
        $el.toggleAttr('open');
        limit = 25;
        src = arcs.baseURL + 'img/arcs-preloader.gif';
        if ($(e.currentTarget).next().children().eq(0).prop("tagName") !== 'IMG') {
          $(e.currentTarget).next().prepend('<img src="' + src + '" alt="SeeAll.svg">');
        }
      } else if (e.currentTarget.className === 'btn-show-all') {
        $el = $(e.currentTarget).parent().parent().parent().parent();
        $(e.currentTarget).removeClass('btn-show-all');
        src = arcs.baseURL + 'img/arcs-preloader.gif';
        $(e.currentTarget).find("img:first").attr('src', src);
        //limit = $el.find('.resource-thumb').length + 14;
        limit = -1;
        //console.log('resources show more redirect here');
        //return;
      } else {
        $el = $(e.currentTarget).parent();
        $el.toggleAttr('open');
        limit = 0;
      }
      this.renderDetails($el, limit);

      e.preventDefault();
      return false;
    };

    //the resources page. where the ajax for drawers is.
    Home.prototype.renderDetails = function($el, limit) {
      var query, query2, type;
      type = $el.data('type');
      query = encodeURIComponent("Type,=," + type);
      if (type === 'Orphaned') {
        query = encodeURIComponent('Orphan,=,true');
      }
      query2 = arcs.baseURL + 'resources/search?';
      if (limit !== 0) {
        query2 += "n=" + limit + "&";
      }
      var url = window.location.href.split('/');
      var kid = '';
      kid = url.pop();
      if(kid != '' && kid != 'resources' ){
        query2 += "pKid=" + kid + "&";
      }
      return $.getJSON(query2 + ("q=" + query), function(response) {
        if( response.results.length == 0 || response.results == 'No Results'){
          $el.children('div').html('No Results');
          return;
        }
        if( typeof response.results[0] == "object" ){
          var html;
          html = arcs.tmpl('home/details', {
            resources: response.results,
            noShowAll: 0,
            searchURL: arcs.baseURL + "collection/"
          });
          $el.children('div').html(html);
          adjustResultsCenter();
          //readjust the resource permissions css
          $('.resource-thumb').each(function(){
            var atag = $(this).children().eq(0);
            var darkBackground = $(atag).children().eq(0);
            var resourcePicture = $(atag).children().eq(2);
            $(resourcePicture).load(function(){ //wait for each picture to finish loading
              var pictureWidth = resourcePicture[0].getBoundingClientRect().width;
              darkBackground.width(pictureWidth); //background same as picture width
              darkBackground.css('left',(115-pictureWidth)/2); //recenter the darkbackground
            });
          });
          return; //$el.find('.show-all-btn-text').html('SHOW MORE');
        }else {
          var project = window.location.href
            .split("/")
            .reverse()[0]
          if (type === 'Orphaned') {
            $('<form />')
                .hide()
                .attr({ method : "post" })
                .attr({ action : "../search/collection/" + project})
                .append($('<input />')
                    .attr("type","hidden")
                    .attr({ "name" : "orphaned_kids" })
                    .val(JSON.stringify(response.results))
                )
                .append('<input type="submit" />')
                .appendTo($("body"))
                .submit();
          }else {
            $('<form />')
                .hide()
                .attr({method: "post"})
                .attr({action: "../search/collection/" + project})
                .append($('<input />')
                    .attr("type", "hidden")
                    .attr({"name": "resource_kids"})
                    .val(JSON.stringify(response.results))
                )
                .append('<input type="submit" />')
                .appendTo($("body"))
                .submit();
          }
          return;
        }
      });

    };
    return Home;

  })(Backbone.View);


}).call(this);

$(document).ready(function()
{
  $(window).resize( function (){
    adjustResultsCenter();
  });
});
function adjustResultsCenter() {

        var ul = $(".resource-thumbs");
        var totalWidth = ul.outerWidth(true) - (ul.outerWidth() - ul.width());
        // console.log("Total width: "+totalWidth);
        var li = $(".resource-thumb");
        // li.css("margin", "");
        ul.css("margin", "");
        ul.css("padding", "");
        ul.css("font-size", "");
        var recordWidth = li.outerWidth(true)  - (li.outerWidth() - li.width());
        // console.log("RecordWidth: "+recordWidth);
        var margin = ((totalWidth % recordWidth) / 2);
        if (margin < 0){
            margin = 0;
        }
        var ulWidth =   ul.outerWidth(true) - (margin*2);
        var numLi = Math.floor(ulWidth / recordWidth);
        // console.log("Numli: "+numLi);
        var liMargin = (ulWidth-(121*numLi))/(numLi*2);
        // console.log(liMargin);
        // li.css("margin", ("10px " + liMargin + "px"));
        ul.css("margin", ("0 " + (margin-1) + "px"));
        // console.log("UL width: "+ulWidth);
        ul.css("padding", "0");
        ul.css("font-size", "0");

        // li.css("margin", ("0 " + Math.floor(margin) + "px"));
}
