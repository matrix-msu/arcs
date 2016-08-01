$(document).ready(function(){

   $(".search-bar").keyup(function(){
	   url= window.location.href + 'search/input';
		window.location.replace(url);
   });
});