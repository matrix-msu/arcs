// preloader image and images

$(window).resize(function(){
  var h = $("#viewer-window").height();
  $("#PageImage").css({height: h+"px"});

});


// other resources
$(document).ready(function () {
  var url = window.location.href;
  if(!url.includes("/orphan/"))
    return
  var h = $("#viewer-window").height();
  $("#ImageWrap img").css({height: h+"px"});

  var oldzoom = 1;

  function createFunc(i){
        return function(event){
        event.preventDefault();
        $pics[current].style.borderWidth = "0px";
        current = i;
        $pics[current].style.borderWidth = "5px";
        var kid = keys[current];
        GetNewResource(kid);
    }
    }

    $('#button-right').click(function(event){
        event.preventDefault();
  console.log(index);
        if(index < endIndex ){
//                if(index == 0){
//                    $('#button-left').css('display', 'none');
//                    $('#other-resources-container').css('width', '90%');
//                }
            index++;
            visible = 2.969696969696;
            shift = visible * 265; //was 220px
            value = "-=" + shift + "px";
            anim['left'] = value;
            $item.animate(anim, "fast");
        }
    });

    $('#button-left').click(function(event){
        event.preventDefault();
  console.log(index)
        if(index > 0){
            index--;
            if(index == 0){
                //$('#button-left').css('display', 'none');
                //$('#other-resources-container').css('width', '95%');
            }
            visible = 2.969696969696;
            shift = (visible) * 265;
            value = "+=" + shift + "px";
            anim['left'] = value;
            $item.animate(anim, "fast");
        }
    });

    $('#prev-resource').click(function(event){
        event.preventDefault();
        if(current > 0){
    $('.numberOverResources').removeClass('selectedResource');
            $pics[current].style.borderWidth = "0px";
    $selected[current].style.background =""
            current--;
            $pics[current].style.borderWidth = "5px";
    $selected[current].style.background ="#0094bc"
    $selected[current].className += ' selectedResource';
            var kid = keys[current];
    console.log("KID: " + kid);
    console.log("current: "+current);
    console.log(kid);
    $('#zoom-range').val(1);
    $('.other-resources').each( function () {
//					console.log(parseInt($(this).find('.numberOverResources').html()));
      console.log($(this).find('.numberOverResources').hasClass('selectedResource'));
      if($(this).find('.numberOverResources').hasClass('selectedResource')){
        console.log('found the boarder');
        console.log(parseInt($(this).find('.numberOverResources').html()));
        $(this).trigger('click');
      }
    });
//                GetNewResource(kid);
//				$("#PageImage").attr('src',$pics[current].src);
//				console.log('previous image should appear');
        }
    });

    $('#next-resource').click(function(event){
        event.preventDefault();
        if(current < keys.length-1){
    $('.numberOverResources').removeClass('selectedResource');
            $pics[current].style.borderWidth = "0px";
    $selected[current].style.background =""
            current++;
            $pics[current].style.borderWidth = "5px";
//				$selected[current].style.background ="#0094bc"
    $selected[current].className += ' selectedResource';
            var kid = keys[current];
    console.log(kid);
    $('#zoom-range').val(1);
    var nextImg = parseInt($('.other-resources').find('.numberOverResources').html())+1
    console.log(nextImg);
    $('.other-resources').each( function () {
//					console.log(parseInt($(this).find('.numberOverResources').html()));
      console.log($(this).find('.numberOverResources').hasClass('selectedResource'));
      if($(this).find('.numberOverResources').hasClass('selectedResource')){
        console.log('found the boarder');
        console.log(parseInt($(this).find('.numberOverResources').html()));
        $(this).trigger('click');
      }
    });
//				console.log($('.other-resources').find('.numberOverResources').html());
//                GetNewResource(kid);
//				$("#PageImage").attr('src',$pics[current].src);
//				console.log('next image should appear');
        }
    });
  $('.fullscreen-prev, .fullscreen-next').hide();
  // $('.fullscreen-prev').click(previousImage);
  // $('.fullscreen-next').click(nextImage);

  function previousImage(){
    // event.preventDefault();
    if(current > 0){
      $('.numberOverResources').removeClass('selectedResource');
      $pics[current].style.borderWidth = "0px";
      $selected[current].style.background =""
      current--;
      $pics[current].style.borderWidth = "5px";
      $selected[current].style.background ="#0094bc"
      $selected[current].className += ' selectedResource';
      var kid = keys[current];
      console.log("KID: " + kid);
      console.log("current: "+current);
      $('.other-resources').each( function () {
        if($(this).find('.numberOverResources').hasClass('selectedResource')){
          $(this).trigger('click');

        }

      });
      $(".fullscreenImage").attr('src', kora_url + $pics[current].src.slice((($pics[current].src.indexOf('largeThumbs'))+12),$pics[current].src.length-1)+'eg');
    }

  }

  function nextImage(){

    // event.preventDefault();
    if(current < keys.length-1){
      $('.numberOverResources').removeClass('selectedResource');
      $pics[current].style.borderWidth = "0px";
      $selected[current].style.background =""
      current++;
      $pics[current].style.borderWidth = "5px";
      $selected[current].style.background ="#0094bc"
      $selected[current].className += ' selectedResource';
      var kid = keys[current];
      $('.other-resources').each( function () {
        if($(this).find('.numberOverResources').hasClass('selectedResource')){
          $(this).trigger('click');
        }

      });
//
      $(".fullscreenImage").attr('src',kora_url + $pics[current].src.slice((($pics[current].src.indexOf('largeThumbs'))+12),$pics[current].src.length-1)+'eg');

    }
  }
    $('#zoom-out').click(function(event){
        event.preventDefault();
        var zoomrange = document.getElementById("zoom-range");
        var image = document.getElementById("PageImage");
        var canvas = $('.canvas');
        var wrapper = document.getElementById("ImageWrapper");
        var zoom, ratio;
        if(zoomrange.value > 1){
            zoomrange.value -= 1;
            zoom = zoomrange.value;
            zoomratio = 10/(11-zoom);
            canvas.css("transform" , "scale(" + zoomratio + ")");
    image.style.transform = "scale(" + zoomratio + ")";
    image.style.left = "0px";
    image.style.top = "0px";
    }

    });

    $('#zoom-in').click(function(event){
        event.preventDefault();
        var zoomrange = document.getElementById("zoom-range");
        var canvas = document.getElementById("canvas");
        var image = document.getElementById("PageImage");
        var zoom;
        if(zoomrange.value < 10){
            zoom = zoomrange.value;
            zoom = Number(zoom) + Number(1);
            zoomrange.value = zoom;
            zoomratio = 10/(11-zoom);
            canvas.style.transform = "scale(" + zoomratio + ")";
            image.style.transform = "scale(" + zoomratio + ")";
        }

    });

    $('#zoom-range').on('change', function(event){
        event.preventDefault();
        var zoomrange = document.getElementById("zoom-range");
        var canvas = $('.canvas');
        var image = document.getElementById("PageImage");
        var zoom;

        zoom = zoomrange.value;

        if(oldzoom > zoom){
            image.style.left = "0px";
            image.style.top = "0px";
        }

        oldzoom = zoom;
        zoomratio = 10/(11-zoom);
        canvas.css("transform" , "scale(" + zoomratio + ")");
        image.style.transform = "scale(" + zoomratio + ")";

    });

    var jq = document.createElement('script');
    jq.src = "//code.jquery.com/ui/1.11.4/jquery-ui.js";
    document.querySelector('head').appendChild(jq);

    jq.onload = drag;

    function drag(){
        $("#ImageWrap").draggable();
        //$("#canvas").draggable({
        //handle: $('#ImageWrap')
        //});
    }

});
