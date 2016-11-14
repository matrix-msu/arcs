var waitingId = 0;
var waits = [];
var _NewResource = {};
function GetNewResource(id) {
    if(id == null)
      return;
    image = document.getElementById('PageImage')
    image.src = '../img/arcs-preloader.gif';
    //image.style.height = '100%';
    //image.style.width = '100%';
    waitingId++;
    setTimeout(function () {
    }, 10000);
    $.ajax({

        url: arcs.baseURL + "resources/loadNewResource/" + id,
        type: 'GET',
        beforeSend: function(){
            waits[this.url] = waitingId;
        },
        success: function (res) {
          if(waits[this.url] >= waitingId){
              res = JSON.parse(res);

              kid = res['kid'];

              kids = [];

              //display obervatoins that apply to the selected page
              var cnt=0;
              var pageNum=1;

              document.getElementById('PageImage').src = res["kora_url"] + res['Image Upload']['localName'];

              document.getElementById('fullscreenImage').src = res["kora_url"] + res['Image Upload']['localName'];
            }
        }
    });
}
_NewResource.DeselectCSS = function(element){
  $(element).find(".numberOverResources").css({background :"black"});
  $(element).find("img").css("borderWidth","0px");
  $(element).css({opacity: ".6"});
}

_NewResource.SelectCSS = function(element){
  $(element).find("img").css("borderWidth","5px");
  $(element).find(".numberOverResources").css({background :"#0094BC"});
  $(element).css({opacity: "1"});
}

// other resources
$(document).ready(function () {
    var $item = $('#other-resources a'),
            $pics = $('#other-resources a img'),
            index = 0, //Starting index
            current = 0,
    $selected = $('#other-resources a .numberOverResources'),
            keys = JSON_KEYS,
    visible = 2.96969696969696, //worked better than 3
    shift = visible * 220,
    anim = {},
    value = "",
    oldzoom = 1,
    endIndex =
    LEN / visible -1;

    for(var i=0; i <$pics.length; i++){
        $pics[i].style.borderColor = "#0094BC";
        $pics[i].style.borderStyle = "solid";
        $item[i].onclick = createFunc(i);
    }

    $pics[0].style.borderWidth = "5px";

    function createFunc(i){
        return function(event){
        event.preventDefault();
        var container = $(this).parent().parent().attr("class");
        var selected = $(this).find(".numberOverResources").html();
        if(container == "page-slider"){
          $(".other-page").find(".other-resources").each(function(){
            var page = $(this).find(".numberOverResources").html();
            if(page ==  selected){
              _NewResource.SelectCSS(this);
            }
            else {
              _NewResource.DeselectCSS(this);
            }
          });
        }
        else{
        $(".resource-container-level").find(".other-resources").each(function(){
            var resource = $(this).find(".numberOverResources").html();
              if(resource ==  selected){
                _NewResource.SelectCSS(this);
              }
              else {
                _NewResource.DeselectCSS(this);
              }
          });
        }
        current = i;
        var kid = keys[current];
        GetNewResource(kid);
      }
    }


  $('.expandedArrowBoxLeft').click(previousImage);
  $('.expandedArrowBoxRight').click(nextImage);
  $('.fullscreenInner').mouseover(hoverExpand);
  $('.fullscreenInner').mouseout(hoverExpandClose);


  function hoverExpandClose(){
    $('.expandedArrowBoxLeft').css('display','none');
    $('.expandedArrowBoxRight').css('display','none');
  }
  function hoverExpand(){
    if ($('.leftHalf').is(':hover')){
      if (current > 0){
        $('.expandedArrowBoxLeft').css('display','block');
      }

      $('.expandedArrowBoxRight').css('display','none');
    }
    else{
       if(current < keys.length-1){
         $('.expandedArrowBoxRight').css('display','block');
       }

      $('.expandedArrowBoxLeft').css('display','none');
    }
  }
  function previousImage(){
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

      $('.other-resources').each( function () {
        if($(this).find('.numberOverResources').hasClass('selectedResource')){
          $(this).trigger('click');

        }

      });
      $(".fullscreenImage").attr('src', kora_url + $pics[current].src.slice((($pics[current].src.indexOf('largeThumbs'))+12),$pics[current].src.length-1)+'eg');
    }

  }

  function nextImage(){

    event.preventDefault();
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

    $('#zoom-range').click(function(event){
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
    _resource.selectResource(1);
});
