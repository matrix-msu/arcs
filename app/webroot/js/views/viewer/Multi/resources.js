jQuery.fn.outerHTML = function() {
    return jQuery('<div />').append(this.eq(0).clone()).html();
};
var pageSet = PAGESET || false;
//global resource
var _resource = {};

_resource.pageSlider = ".other-page";
_resource.resourceSlider = ".resource-slider";
_resource.resourceContainer = "#other-resources-container";
_resource.viewWindow = "#viewer-window";
_resource.pointer = ".p-select";
_resource.currentPage;
_resource.currentResource;
_resource.rotate = '.resources-rotate-icon';
_resource.SwapResource = function(kid) {

    $(this.pageSlider).find("a").each(function() {

        var id = $(this).attr("id");
        if (id.includes(kid)) {
            $(this).css({
                display: "initial"
            });
        } else {
            $(this).css({
                display: "none"
            });
        }
    });

};
_resource.page_increment = function(page_link = $(_resource.pageSlider).find("a")) {

    var cnt = 0;
    page_link.each(function() {
        if ($(this).css("display") != "none")
            $(this).find(".numberOverResources").html(++cnt);
        else
            $(this).find(".numberOverResources").html(0);
    });

}

_resource.selectPage = function(pageNum) {
    var pageEvent = $(_resource.pageSlider)
        .find(".numberOverResources:" + "contains('" + pageNum + "')")
        .first().parent()
        .find("img");

    pageEvent.trigger("click");
    return pageEvent;
}
_resource.selectResource = function(pageNum) {
    var rEvent = $(_resource.resourceSlider)
        .find(".numberOverResources:" + "contains('" + pageNum + "')")
        .first().parent()
        .find("img");

    rEvent.trigger("click");

}

_resource.sliderMove = function(obj, movementMultiplier=1) {

    var accelorator = 1;
    var slider = obj.slider;
    var element = slider.find("img");
    var movement = parseInt($(element).prop("width")) * movementMultiplier;

    obj.direction == "left" ? movement *= -1 : movement;

    if (slider.is(':animated')) {
        slider.stop();
        accelorator *= 2.5;
    }

    slider.animate({
            scrollLeft: slider.scrollLeft() + movement * obj.multiplier * accelorator
        }, obj.speed + accelorator,
        function() {
            _resource.sliderMove.adjust(slider);
        }
    );
}
_resource.sliderMove.adjust = function(element) {
    var slider = $(element).parent().find("#other-resources-container");
    var container = $(element).parent();

    if (slider.scrollLeft() == 0) {
        _resource.SliderStartCSS(container, false);
    } else {
        _resource.SliderStartCSS(container, true);
    }

    if (slider.scrollLeft() >= slider[0].scrollWidth - $(document).width())
        _resource.SliderEndCSS(container, false);
    else {
        _resource.SliderEndCSS(container, true);
    }
}

_resource.currWidth = null;
_resource.containerWidth = null;

_resource.SetWidths = function(container) {
    if (_resource.currWidth == null) {
        $(container).css({
            width: "initial"
        })
        _resource.currWidth = parseInt(
            $(container).width()
        );
        _resource.btnWidth = parseInt(
            $(container).find(".button-left").css("width")
        );
        _resource.containerWidth = parseInt(
            $(_resource.resourceContainer).width()
        );
    }
}
_resource.SliderStartCSS = function(container, reset) {
    _resource.SetWidths(container);
    if (!reset) {

        $(container).find(".button-left").css({
            display: "none"
        })
        $(container).css({
            width: _resource.currWidth
        });
        $(_resource.resourceContainer, container).css({
            width: _resource.containerWidth + _resource.btnWidth
        });
    } else {
        $(container).find(".button-left").css({
            display: "initial"
        })
        $(container).css({
            width: _resource.currWidth
        });
        $(_resource.resourceContainer, container).css({
            width: _resource.containerWidth 
        })
    }
}
_resource.SliderEndCSS = function(container, reset) {
    _resource.SetWidths(container);
    if (!reset) {
        $(container).find(".button-right").css({
            display: "none"
        })
        $(container).css({
            width: _resource.currWidth
        });
        $(_resource.resourceContainer, container).css({
            width: _resource.containerWidth + _resource.btnWidth
        })
    } else {
        $(container).find(".button-right").css({
            display: "initial"
        })
    }
}

_resource.insertLevel = function(template, insertPoint, name) {
    $(insertPoint).html(template);
    $(insertPoint).attr({
        id: name
    });
}

_resource.getObjFromKid = function(kid) {
    return $("#identifier-" + kid);
}

_resource.setPointer = function(id) {
    var resource = _resource.getObjFromKid(id);
    var sliderOffset = Math.abs($(_resource.resourceSlider).position().left);
    var offset = resource.offset().left + sliderOffset;

    if (sliderOffset != 60) {
        offset += 90;
    } else {
        offset -= 20;
    }

    $(_resource.pointer).children().each(function() {
        $(this).css({
            left: offset
        });
    });
}

$(window).resize(function() {
    _resource.currWidth = null;
    _resource.sliderMove.adjust($(_resource.pageSlider).parent());
    _resource.sliderMove.adjust($(_resource.resourceSlider).parent());
});
$(document).ready(function() {
    var permModal = $("#request_permission_model")
    var resourcePermModal = $("#resource_permission_model")

    if (permModal.length && permModal.css("opacity") == 1 ||
        resourcePermModal.length  && resourcePermModal.css("opacity") == 1) {
      var modal
      if (permModal.length) {
        modal = permModal
      } else {
        modal = resourcePermModal
      }
      modal.find(".permission-modal-responseButtons")
          .find("button")
          .first()
          .remove()
      modal.find(".modal-exit").remove()
    }

    $(".button-right").click(function(e) {

        var element = $(this).parent().find("#other-resources-container");
        _resource.sliderMove({
            direction: "right",
            slider: $(element),
            multiplier: 2,
            speed: 400
        });

    });
    $(".button-left").click(function(e) {

        var element = $(this).parent().find("#other-resources-container");
        _resource.sliderMove({
            direction: "left",
            slider: $(element),
            multiplier: 2,
            speed: 400
        });

    });
    //initialize scroll
    $(".button-left").trigger("click");
    //resource nav
    var zoomOption = 1;

    // trigger img if number clicked insteads
    $(".numberOverResources").click(function(e) {
        $(this).parent().find("img").trigger("click");
        e.stopPropagation();
    });
    $('.other-resources').click(function() {
        //add a selected class to any clicked page or resource
        if($(this).parents('.page-slider').length > 0) {
            $('.page-slider').find('.other-resources').removeClass('selectedCurrentPage');
            $(this).addClass('selectedCurrentPage')
        }
        if($(this).parents('.resource-slider').length > 0) {
            $('.resource-slider').find('.other-resources').removeClass('selectedCurrentResource');
            $(this).addClass('selectedCurrentResource')
        }


        if ($(this).parent().length && $(this).parent().attr("class") == "other-page") {
            return;
        }

        var id = $(this).find("img").attr("id");
        id = id.replace("identifier-", "");
        CM_R_ID = id //sets the global Resource ID
        getComments()


        //initialize scroll
        $(_resource.pageSlider).parent().scrollLeft(0);
        $(_resource.pageSlider).parent().parent().find(".button-left").trigger("click");


        _resource.currentResource = parseInt(
            $(this).find(".numberOverResources").html()
        );

        _resource.SwapResource(id);
        _resource.setPointer(id);
        _resource.page_increment();
        _resource.selectPage(1);
        if(pageSet) {
            var page = $(_resource.pageSlider).find("#"+pageSet);
            if(page.length) {
                var index = page.parent().find(".numberOverResources").html();
                index = parseInt(index,10) || 0
                _resource.selectPage(index);
                _resource.sliderMove({
                    direction: "right",
                    slider: $(_resource.pageSlider).parent(),
                    multiplier: 1,
                    speed: 1000
                }, (index-3)/2);
            }
        }
        else {
            console.log("no Page SEt")
        }


    });

    var angle = 0
    var className;
    $(_resource.rotate).click(function() {
        angle = (angle + 90) % 360;
        className = 'rotate(' + angle + 'deg' + ')';
        $('#ImageWrap').css('transform', className);
        $(".fullscreenImage").css('transform', className);
    });

    $(".resource-reset-icon").click( function () {
      angle = 0;
      $('#ImageWrap').css('transform','');
      $("#canvas").css('transform', 'scale(1)');
      $("#PageImage").css('transform', 'scale(1)');
      $('.zoom-bar').val(1);
      $('#ImageWrap').css('top','');
      $('#ImageWrap').css('left','');
      $(".fullscreenImage").css('transform', 'rotate(' + angle + 'deg' + ')');
    });

    $(_resource.pageSlider + " img").click(function(e) {
        var kid = $(this).attr("id");
        var resource_kid = $(this).parent().parent().attr("id");
        resource_kid = resource_kid.replace("resource-pagelevel-", "");
        _resource.currentPage = parseInt(
            $(this).parent().find(".numberOverResources").html()
        );
        GetNewResource(kid);
    });

    $('img.deleteModalClose').click(function() {

        $('.deleteWrap').css('display', 'none');
    });
    $('.deleteCancel').click(function() {

        $('.deleteWrap').css('display', 'none');
    });
    $('.fullscreenOverlay').click(function(e) {
        if (e.target !== this && e.target !== $('.fullscreenOuter'))
            return
        $('.fullscreenWrap').css('display', 'none');
        $('html, body').css({
            'overflow': 'auto',
            'height': 'auto'
        });
    });
    $('.fullscreenClose').click(function() {
        $('.fullscreenWrap').css('display', 'none');
        $('html, body').css({
            'overflow': 'auto',
            'height': 'auto'
        });
    })
    $('.resources-fullscreen-icon').click(setExpand);
    $('.fullscreenInner').draggable();
    $('.fullscreenInner').bind('wheel', function(e) {

        if (zoomOption < 1.25 || zoomOption > .7)
            if (e.originalEvent.wheelDelta / 120 > 0) {
                if (zoomOption > 1.2)
                    return

                zoomOption += .05
                $('.fullscreenInner , .fullscreenOuter').css('transform', 'scale(' + zoomOption + ')');
            } else {
                if (zoomOption < .75)
                    return

                zoomOption -= .05
                $('.fullscreenInner , .fullscreenOuter').css('transform', 'scale(' + zoomOption + ')');
            }
    })
    //GOTO
    function setExpand() {
        var imageSrc = $("#PageImage").attr('src');

        $(".fullscreenImage").attr('src', imageSrc);
        $('.fullscreenWrap').css('display', 'block');
        zoomOption = 1;
        $('.fullscreenInner, .fullscreenOuter').css('transform', 'scale(1)');
        $('html, body').css({
            'overflow': 'hidden',
            'height': '100%'
        });
    }
});
