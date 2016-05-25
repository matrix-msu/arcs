
$(document).ready(function(){

    $("#resources").click(function(){
        this.href = this.href+"?"+index;
    });
    $("#collections").click(function(){
        this.href = this.href+"?"+index;
    });
     $("#search").click(function(){
        this.href = this.href+"?"+index;
    });
    $("#help").click(function(){
        this.href = this.href+"?"+index;
    });
});

/*Keep as global*/

var temp = window.location.href;
var tempArray = temp.split("/").reverse();
var toolId = tempArray[0];
var projects = ["Polis", "Isthmia", "Chersonesos"];
var index = projects.indexOf(toolId);

if(index ==-1){
//get the previous index stored somewhere
	var prevIndex;
	var i = toolId.substr(toolId.length -1);
	var i2 =toolId.substr(toolId.length -2);
	if (i2 != -1){
		prevIndex = projects[i];
		if(i == 1 || i== 0 || i == 2){

			document.getElementById("toolbarHead").innerHTML = projects[i] + document.getElementById("toolbarHead").innerHTML;
			index=i; 
			}
		else{
			document.getElementById("toolbarHead").innerHTML = "Projects" + document.getElementById("toolbarHead").innerHTML;
			}
		
	}
	else{
		document.getElementById("toolbarHead").innerHTML = "Projects" + document.getElementById("toolbarHead").innerHTML;
	}
	}
else{
	document.getElementById("toolbarHead").innerHTML = toolId + document.getElementById("toolbarHead").innerHTML  ;
}

