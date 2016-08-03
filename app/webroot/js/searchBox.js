$(document).ready(function(){
    $(".search-bar").keyup(function(e){
       var val = $('#searchBar').val();
       if(e.keyCode == 13){
           console.log(val);
           url= arcs.baseURL + 'search/' + val;
           window.location.replace(url);
       }
   });
});

$(".searchBoxInput").keyup(function(e){
    var val = $('.searchBoxInput').val();
    if(e.keyCode == 13){
        console.log(val);
        url= arcs.baseURL + 'search/' + val;
        window.location.replace(url);
    }
});