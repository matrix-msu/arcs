
$(document).ready(function()
{

  //resource nav
    var zoomOption = 1;
    $('.other-resources').click(function(){
      console.log("dlkajflkadf");
      $('.numberOverResources').css("background", '');
      $('.numberOverResources').removeClass('selectedResource');
      $(this).find('.numberOverResources').addClass('selectedResource');
      console.log($(this).id);
      console.log("hello");

  ///$('#fullscreenImage').attr('src', $('#PageImage').attr('src'));
    });
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
