var projectKid = "all";
$(document).ready(function(){
    projectKid = $(".search-bar-js").data("project-kid");
    $(".search-bar").keyup(function(e){
       var val = $('#searchBar').val();
       if(e.keyCode == 13){
           var getUrl = window.location;
           var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
           url= baseUrl + '/arcs/search/'+projectKid+"/"+ val;
           window.location.href = url;
       }
   });
  var linked = $(".searchBoxInput").data("searchlink") || false
  if (linked) {
    $(".searchBoxInput").unbind().keyup(function(e){

      $("#advancedSearchLink").attr("href","advanced/" + window.globalproject)
        var val = $('.searchBoxInput').val();
        if(e.keyCode == 13){
            url= arcs.baseURL + 'search/' + window.globalproject + "/"+ val;
            window.location.href = url;
        }
        e.stopPropagation()

    });
  }


});
