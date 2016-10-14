jQuery.fn.outerHTML = function() {
  return jQuery('<div />').append(this.eq(0).clone()).html();
};
var _resource = {};
var _default = {


};
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
_resource.page_increment = function(page_link = $(_resource.pageSlider).find("a")){

  var cnt = 0;
  page_link.each(function(){
    if($(this).css("display") != "none")
      $(this).find(".numberOverResources").html(++cnt);
    else
      $(this).find(".numberOverResources").html(0);
  });

}

_resource.selectPage = function(pageNum){
  var pageEvent = $(_resource.pageSlider)
    .find(".numberOverResources:"+"contains('"+pageNum+"')")
    .first().parent()
    .find("img");

  pageEvent.trigger("click");
  return pageEvent;
}

_resource.sliderMove = function(obj){

  var slider = obj.slider;
  var element = slider.find("img");
  var movement = parseInt($(element).width())
               + parseInt($(element).css("margin"));

  obj.direction == "left" ? movement *= -1 : movement;

  slider.animate({
      scrollLeft: slider.scrollLeft() + movement * obj.multiplier
    }, obj.speed );

}

_resource.insertLevel = function(template, insertPoint, name){
  $(insertPoint).html(template);
  $(insertPoint).attr({id: name});
}



$(document).ready(function()
{
  //clear pages

  //_resource.SwapResource("clear");
  //select first element

  $(".button-right").click(function(e){

      var element = $(this).parent().find("#other-resources-container");
      _resource.sliderMove({
        direction: "right",
        slider: $(element),
        multiplier: 2,
        speed: 400
      });
  });
  $(".button-left").click(function(e){

    var element = $(this).parent().find("#other-resources-container");
    _resource.sliderMove({
      direction: "left",
      slider: $(element),
      multiplier: 2,
      speed: 400
    });

  });


  //resource nav
    var zoomOption = 1;

    // trigger img if number clicked insteads
    $(".numberOverResources").click(function(){
        $(this).parent().find("img").trigger("click");
    });
    $('.other-resources').click(function(){

      if($(this).parent().length && $(this).parent().attr("class") == "other-page"){
        return;
      }


      $('.numberOverResources').css("background", '');
      $('.numberOverResources').removeClass('selectedResource');
      $(this).find('.numberOverResources').addClass('selectedResource');

      var id = $(this).find("img").attr("id");
      id = id.replace("identifier-", "");

      _resource.SwapResource(id);
      _resource.page_increment();
      _resource.selectPage(1);

  //$('#fullscreenImage').attr('src', $('#PageImage').attr('src'));
    });



    var angle = 0
    var className;
    $('.resources-rotate-icon').click(function(){

      angle=(angle+90)%360;

      className = 'rotate('+angle+'deg'+')';

      $('#ImageWrap').css('transform',className)
    });

    $(_resource.pageSlider + " img").click(function(){

      var kid = $(this).attr("id");
      var resource_kid = $(this).parent().parent().attr("id");
      resource_kid = resource_kid.replace("resource-pagelevel-", "");
      GetNewResource(kid);
    });


    $('img.deleteModalClose').click(function(){

      $('.deleteWrap').css('display','none');
    });
    $('.deleteCancel').click(function(){

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

          zoomOption+=.05
          $('.fullscreenInner , .fullscreenOuter').css('transform','scale('+zoomOption+')');
        }
        else{
          if(zoomOption < .75)
            return

          zoomOption-=.05
          $('.fullscreenInner , .fullscreenOuter').css('transform','scale('+zoomOption+')');
        }
    })

    function setExpand(){
       var imageSrc = $("#PageImage").attr('src');

       $(".fullscreenImage").attr('src',imageSrc);
       $('.fullscreenWrap').css('display','block');
      zoomOption=1;
      $('.fullscreenInner, .fullscreenOuter').css('transform','scale(1)');
      $('html, body').css({
        'overflow': 'hidden',
        'height': '100%'
      });
     }



     //select first element
     $(".resource-container-level").find("img").first().trigger("click");

});
