var projectKid = "all";
$(document).ready(function(){
    projectKid = $(".search-bar-js").data("project-kid");
    $(".search-bar").keyup(function(e){
       var val = $('#searchBar').val();
       if(e.keyCode == 13){
           window.location.href = arcs.baseURL+"search/"+projectKid+"/"+val;
       }
   });
    $('.indexSearchIcon').click(function(){
        var val = $('#searchBar').val();
        if( val == '|\xa0\xa0Search' ){
            val = '';
        }
        window.location.href = arcs.baseURL+"search/"+projectKid+"/"+val;
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
