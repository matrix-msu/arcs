jQuery.fn.outerHTML = function() {
  return jQuery('<div />').append(this.eq(0).clone()).html();
};
var _resource = {};
_resource.pageSlider = ".other-page";
_resource.resourceContainer = "#other-resources-container";
_resource.viewWindow = "#viewer-window";


_resource.SwapResource  = function (kid) {

  $(this.pageSlider).find("a").each(function(){

    var id = $(this).attr("id");
    if(id.includes(kid)){
      $(this).css({ display: "initial" });
    }
    else{
      $(this).css({ display: "none" });
    }
  });
};
_resource.pageSwap = function(kid){

}
_resource.SetMedatdata = function(resource_kid, page_kid){

    // recurse data for array keys and values
    var resource = RESOURCES[resource_kid];
    var excavations = Array();
    var seasons = Array();
    for(var a in resource["Excavation - Survey Associator"]){
      var kid = resource["Excavation - Survey Associator"][a];
      if(EXCAVATIONS[kid] != undefined){
        excavations.push(EXCAVATIONS[kid]);
      }

    }




    var season = SEASONS[excavations[0]["Season Associator"]];
    var project = PROJECTS[season["Project Associator"]];
    var page = resource["page"][page_kid];

    this.fillTable(project, "#Project");
    this.fillTable(season, "#Season");
    this.fillTable(page, "#Archival_Object");

}
_resource.fillTable = function(obj, table){
  var table = $(table);
  for(attr_value in obj){
    attribute = "._" + attr_value.replace(" ", "-");
    if(table.find(attribute).length){
      table.find(attribute).html(obj[attr_value]);
    }
  }
}
_resource.insertLevel = function(template, insertPoint, name){
  $(insertPoint).html(template);
  $(insertPoint).attr({id: name});
}



$(document).ready(function()
{
  //clear pages

  _resource.SwapResource("clear");
  //select first element


  //resource nav
    var zoomOption = 1;
    $('.other-resources').click(function(){
      console.log($(this).parent().attr("class"));
      if($(this).parent().attr("class") == "other-page"){
        return;
      }


      $('.numberOverResources').css("background", '');
      $('.numberOverResources').removeClass('selectedResource');
      $(this).find('.numberOverResources').addClass('selectedResource');

      var id = $(this).find("img").attr("id");
      id = id.replace("identifier-", "");

      _resource.SwapResource(id);

  //$('#fullscreenImage').attr('src', $('#PageImage').attr('src'));
    });
    //select first element
    $(".resource-container-level").find("a").first().trigger("click");



    var angle = 0
    var className;
    $('.resources-rotate-icon').click(function(){
      console.log('rotator clicked');
      angle=(angle+90)%360;
      console.log(angle);
      className = 'rotate('+angle+'deg'+')';
      console.log(className);
      $('#ImageWrap').css('transform',className)
    });

    $(_resource.pageSlider + " img").click(function(){
      var kid = $(this).attr("id");
      var resource_kid = $(this).parent().parent().attr("id");
      resource_kid = resource_kid.replace("resource-pagelevel-", "");
      GetNewResource(kid);
      _resource.SetMedatdata(resource_kid, kid);
    });


    $('img.deleteModalClose').click(function(){
      console.log("Close delete box");
      $('.deleteWrap').css('display','none');
    });
    $('.deleteCancel').click(function(){
      console.log("Close delete box");
      $('.deleteWrap').css('display','none');
    });
    $('.fullscreenOverlay').click(function(e){
      if (e.target !== this && e.target !== $('.fullscreenOuter'))
        return
      $('.fullscreenWrap').css('display','none');
      $('html, body').css({
        'overflow': 'auto',
        'height': 'auto'
      });
    });
    $('.fullscreenClose').click(function(){
      $('.fullscreenWrap').css('display','none');
      $('html, body').css({
        'overflow': 'auto',
        'height': 'auto'
      });
    })
    $('.resources-fullscreen-icon').click(setExpand);
    $('.fullscreenInner').draggable();

    $('.fullscreenInner').bind('wheel',function(e){

      if (zoomOption < 1.25 || zoomOption >.7 )
        if(e.originalEvent.wheelDelta /120 > 0) {
          if(zoomOption >1.2)
            return
          console.log('zoom in');
          zoomOption+=.05
          $('.fullscreenInner , .fullscreenOuter').css('transform','scale('+zoomOption+')');
        }
        else{
          if(zoomOption < .75)
            return
          console.log('zoom out');
          zoomOption-=.05
          $('.fullscreenInner , .fullscreenOuter').css('transform','scale('+zoomOption+')');
        }
    })

    function setExpand(){
       var imageSrc = $("#PageImage").attr('src');
       console.log(imageSrc);
       $(".fullscreenImage").attr('src',imageSrc);
       $('.fullscreenWrap').css('display','block');
      zoomOption=1;
      $('.fullscreenInner, .fullscreenOuter').css('transform','scale(1)');
      $('html, body').css({
        'overflow': 'hidden',
        'height': '100%'
      });
     }




});
