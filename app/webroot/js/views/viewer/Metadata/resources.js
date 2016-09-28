
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
    var degree;
    $('.resources-rotate-icon').click(function(){
      console.log('rotator clicked');
      angle=(angle+90)%360;
      console.log(angle);
      degree = 'rotate('+angle+'deg'+')';
      console.log(degree);
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
       $(".fullscreenImage").css('transform',$('#ImageWrap').css('transform'));
       $('.fullscreenWrap').css('display','block');
      zoomOption=1;
      $('.fullscreenInner, .fullscreenOuter').css('transform','scale(1)');
      $('html, body').css({
        'overflow': 'hidden',
        'height': '100%'
      });
     }




});
