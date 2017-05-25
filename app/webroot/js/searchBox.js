var projectKid = "all";
$(document).ready(function(){
    projectKid = $(".search-bar-js").data("project-kid");
    $(".search-bar").keyup(function(e){
       var val = $('#searchBar').val();
       if(e.keyCode == 13){
           url= arcs.baseURL + 'search/'+projectKid+"/"+ val;
           window.location.replace(url);
       }
   });
  var linked = $(".searchBoxInput").data("searchlink") || false
  if (linked) {
    $(".searchBoxInput").unbind().keyup(function(e){

      $("#advancedSearchLink").attr("href","advanced/" + window.globalproject)
        var val = $('.searchBoxInput').val();
        if(e.keyCode == 13){
            url= arcs.baseURL + 'search/' + window.globalproject + "/"+ val;
            window.location.replace(url);
        }
        e.stopPropagation()

    });
  }


});
