var projectKid = "all";
$(document).ready(function(){
    projectKid = $(".search-bar-js").data("project-kid");
    $(".search-bar").keyup(function(e){
       var val = $('#searchBar').val();
       if(e.keyCode == 13){
           console.log(val);
           url= arcs.baseURL + 'search/'+projectKid+"/"+ val;
           window.location.replace(url);
       }
   });
   $("#advancedSearchLink").attr("href","advanced/" + globalproject)
});

$(".searchBoxInput").keyup(function(e){
    var val = $('.searchBoxInput').val();
    if(e.keyCode == 13){
        console.log(val);
        url= arcs.baseURL + 'search/'+projectKid+"/"+ val;
        window.location.replace(url);
    }
});

