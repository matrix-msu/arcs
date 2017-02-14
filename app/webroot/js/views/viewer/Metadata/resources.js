var defaultExpand = {
  "page" : "#PageImage",
  "popup" : ".fullscreenImage",
  "wrap" : ".fullscreenWrap",
  "inner": ".fullscreenInner",
  "outer" : ".fullscreenOuter",
  "fullClose" : ".fullscreenClose",
  "overlay" : ".fullscreenOverlay"
};

var scale = {};

scale.max = 2;
scale.min = .5;
scale.inc = .05;

$(document).ready(function()
{
  //resource nav
    var zoomOption = 1;
    $('.other-resources').click(function(){
      $('.numberOverResources').css("background", '');
      $('.numberOverResources').removeClass('selectedResource');
      $(this).find('.numberOverResources').addClass('selectedResource');
      console.log($(this).id);
      console.log("hello");

  ///$('#fullscreenImage').attr('src', $('#PageImage').attr('src'));
    });
    var angle = 0
    var degree;
    $('.resources-rotate-icon').click(function(){
      angle=(angle+90)%360;
      degree = 'rotate('+angle+'deg'+')';
      $('#ImageWrap').css('transform',degree);
      $('#fullscreenImage').css('transform',degree);
    });
    $(".resource-reset-icon").click( function () {
      angle = 0;
      $('#ImageWrap').css('transform','');
      $("#canvas").css('transform', 'scale(1)');
      $("#PageImage").css('transform', 'scale(1)');
      $('.zoom-bar').val(1);
      $('#ImageWrap').css('top','');
      $('#ImageWrap').css('left','');
    });
    $('img.deleteModalClose').click(function(){
      console.log("Close delete box");
      $('.deleteWrap').css('display','none');
    });
    $('.deleteCancel').click(function(){
      console.log("Close delete box");
      $('.deleteWrap').css('display','none');
    });
    $(defaultExpand.overlay).click(function(e){
      if (e.target !== this && e.target !== $(defaultExpand.outer))
        return
      $(defaultExpand.wrap).css('display','none');
      $('html, body').css({
        'overflow': 'auto',
        'height': 'auto'
      });
    });
    $(defaultExpand.fullClose).click(function(){
      $(defaultExpand.wrap).css('display','none');
      $('html, body').css({
        'overflow': 'auto',
        'height': 'auto'
      });
    })
    $('.resources-fullscreen-icon').click(setExpand);
    $(defaultExpand.inner).draggable();

    $(defaultExpand.inner).bind('wheel',function(e){
      if (zoomOption < scale.max|| zoomOption >scale.min )
        if(e.originalEvent.deltaY > 0) {
          if(zoomOption >scale.max)
            return
          zoomOption+=scale.inc;
          $(defaultExpand.inner, defaultExpand.outer).css('transform','scale('+zoomOption+')');
        }
        else{
          if(zoomOption < scale.min)
            return
          zoomOption-=scale.inc;
          $(defaultExpand.inner, defaultExpand.outer).css('transform','scale('+zoomOption+')');
        }
    })

});

function Expand(obj) {
  var imageSrc = $(obj.page).attr('src');
  $(obj.popup).attr('src',imageSrc);
  $(obj.popup).css('transform',$('#ImageWrap').css('transform'));
  $(obj.wrap).css('display','block');
 zoomOption=1;
 $(obj.inner, obj.outer).css('transform','scale(1)');
 $('html, body').css({
   'overflow': 'hidden',
   'height': '100%'
 });
}

  function setExpand(){
    Expand(defaultExpand);
   }
