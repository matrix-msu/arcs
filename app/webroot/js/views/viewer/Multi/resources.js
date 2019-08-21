jQuery.fn.outerHTML = function() {
    return jQuery('<div />').append(this.eq(0).clone()).html();
};
var pageSet = typeof PAGESET !== 'undefined' ? PAGESET : false;
//global resource
var _resource = {};
var first = true;

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
        if (id === kid) {
            $(this).css({
                display: "initial"
            });
        } else {
            $(this).css({
                display: "none"
            });
        }
    });


    //trigger resize to fix the left/right arrows faster
    $(window).trigger('resize');

    //take care of the pages slider for scroll_bar.js
    setTimeout(function(){
        if(
            $('.pages-resource-nav .button-left').css('display') == 'none' &&
            $('.pages-resource-nav .button-right').css('display') == 'none'
        ){
            setTimeout(function(){$('#scroll').slideUp(300);}, 1)

        }else{
            setTimeout(function(){$('#scroll').slideDown(300);}, 1)
            $("#resources-nav").addClass("scroll-shift-nav");
            $("#viewer-right").addClass("scroll-shift-viewer");
        }
    }, 1)

};
_resource.page_increment = function(page_link = $(_resource.pageSlider).find("a")) {

    var cnt = 0;
    page_link.each(function() {
        if ($(this).css("display") != "none")
            $(this).find(".numberOverResources").html(++cnt);
        else
            $(this).find(".numberOverResources").html(0);
    });
    return cnt;
}

_resource.selectPage = function(pageNum) {
    if( pageNum == 0 ){
        pageNum = 1;
    }
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
    var movement = parseInt($(element).prop("width")) * movementMultiplier

    obj.direction == "left" ? movement *= -1 : movement;

    if (slider.is(':animated')) {
        slider.stop();
        accelorator *= 2.5;
    }

    slider.animate({
            scrollLeft: slider.scrollLeft() + movement * obj.multiplier * accelorator
        }, obj.speed + accelorator,
        function() {
            $(window).trigger('resize');
        }
    );
}
_resource.sliderMove.adjust = function(element) {
    var slider = $(element).parent().find("#other-resources-container");
    var container = $(element).parent();
    var checkBoth = 0;
    var fullSlider = $(slider).find('#other-resources');
    var width = parseInt( $(window).width() );
    var btnWidth = parseInt( $(container).find(".button-left").width() );

    //handle showing the left, right arrows
    if (slider.scrollLeft() == 0) {
        $(container).find(".button-left").css({display: "none"});
    } else {
        $(container).find(".button-left").css({display: "block"});
        checkBoth++;
    }
    var tmpBtnWidth = 0;
    if( $(container).find(".button-right").css('display') == 'block' ){
        tmpBtnWidth = btnWidth;
    }

    if( slider.scrollLeft() + slider.width() +12 +tmpBtnWidth >= fullSlider.width() ){
        $(container).find(".button-right").css({display: "none"});
    }else{
        $(container).find(".button-right").css({display: "block"});
        checkBoth++;
    }

    //set the width of the container
    $(container).width(width);
    width = width - 12;
    if( checkBoth == 2 ){
        width = width - btnWidth*2;
    }else if( checkBoth == 1 ){
        width = width - btnWidth;
    }
    $(slider).css('width', width);
    //$(container).css('width', width);
    var pagesShowing = true;
    if( $('#resources-nav').css('display') === 'none' ){
        pagesShowing = false;
    }

    if( $(element).hasClass('resource-container-level') ){
        if( window.innerWidth > 900 || !pagesShowing ){
            $('#viewer-right').css('top','0');
            $('.resource-nav-level#resources-nav').css('margin-top','0px');
        }
        if( window.innerWidth > 900 ){
            $('#scroll2').css('margin-top', '0');
        }
        if( checkBoth == 0 ){
            setTimeout(function(){
                // if( window.innerWidth <= 900 && pagesShowing ){
                //     $('.resource-nav-level#resources-nav').css('margin-top','113px');
                //     $('#viewer-right').css('top','113px');
                // }
                if( window.innerWidth <= 900 && !pagesShowing ){
                    $('#viewer-right').css('top','-41px');
                }
                $('#scroll2').slideUp(300);
            }, 1)
        }else{
            setTimeout(function(){
                if( window.innerWidth <= 900 && pagesShowing ) {
                    $('.resource-nav-level#resources-nav').css('margin-top', '156px');
                    $('#viewer-right').css('top', '156px');
                    $('#scroll2').css('margin-top', '114px');
                }
                $('#scroll2').slideDown(300);
            }, 1)
            $("#resources-nav").addClass("scroll-shift-nav");
            $("#viewer-right").addClass("scroll-shift-viewer");
        }
    }if( $(element).hasClass('page-slider') ){
        if( checkBoth == 0 ){
            setTimeout(function(){
                $('#resources-nav').css('margin-top', '0');
                if( $('#viewer-right').css('top') === '156px' ){
                    $('#viewer-right').css('top', '114px');
                }
                $('#scroll').slideUp(300);
            }, 1)
        }else{
            setTimeout(function(){$('#scroll').slideDown(300);}, 1)
            $("#resources-nav").addClass("scroll-shift-nav");
            $("#viewer-right").addClass("scroll-shift-viewer");
        }
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
    var sliderOffset = $(_resource.resourceSlider).position().left;
    // Magic number 26 is actually the pointer's left margin
    var offset = resource.offset().left + resource.outerWidth() / 2.0 - sliderOffset - 26;

    $(_resource.pointer).children().each(function() {
        $(this).css({
            left: offset
        });
    });
}

$(window).resize(function() {
    _resource.currWidth = null;
    //redo all of the slider sizing
    setTimeout(function(){
        _resource.sliderMove.adjust($(_resource.pageSlider).parent());
        _resource.sliderMove.adjust($(_resource.resourceSlider).parent());
    },1);

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
    // $(".numberOverResources").click(function(e) {
    var numberOverResourcesClick = function (e) {
        $(this).parent().find("img").trigger("click");
        e.stopPropagation();
        // });
    };
    $(".numberOverResources").click(numberOverResourcesClick);
    // $('.other-resources').click(function() {
    var otherResourcesClick = function () {

        //add a selected class to any clicked page or resource
        if($(this).parents('.page-slider').length > 0) {
            $('.page-slider').find('.other-resources').removeClass('selectedCurrentPage');
            $(this).addClass('selectedCurrentPage')
            var id = $(this).find("img").attr("id");
            //pageSet = id;
            var stateObj = { pageID: id };

            history.replaceState(stateObj, "page 2", "?pageSet=" +id);
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
        CM_R_ID = id; //sets the global Resource ID
        getComments();

        $('#res-header').html($('.archival[data-kid="'+id+'"]').find('#Title').html());

        //initialize scroll
        $(_resource.pageSlider).parent().scrollLeft(0);
        $(_resource.pageSlider).parent().parent().find(".button-left").trigger("click");


        _resource.currentResource = parseInt(
            $(this).find(".numberOverResources").html()
        );

        _resource.SwapResource(id);
        _resource.setPointer(id);
        var newCnt = _resource.page_increment();

	if( newCnt > 1 ){
		$("#resources-nav").css("display","block");
	}else{
		$("#resources-nav").css("display","none");
	}

        console.log('num pages2:', newCnt);
console.log(_resource.pageSlider);
	//console.log('num pages:', $(".page-slider").find(".other-resources").length);
        if( typeof $('.selectedCurrentResource').attr('data-dontclickpage') === 'undefined') {
            _resource.selectPage(1);
        }else{
            var page = $(_resource.pageSlider).find("#" + $('.selectedCurrentResource').attr('data-dontclickpage'));
            if(page.length) {
                var index = page.parent().find(".numberOverResources").html();
                index = parseInt(index,10) || 0;
                _resource.selectPage(index);
                _resource.sliderMove({
                    direction: "right",
                    slider: $(_resource.pageSlider).parent(),
                    multiplier: 1,
                    speed: 1000
                }, (index-3)/2);
            }
            $('.selectedCurrentResource').removeAttr('data-dontclickpage');
            return;
        }

        if(pageSet) {
            var page = $(_resource.pageSlider).find("#" + pageSet);
            if (first){
                var checkExist = setInterval(function () {
                    page = $(_resource.pageSlider).find("#" + pageSet);
                    var resourceId = page.parent().attr('id');
                    if ($('#identifier-' + resourceId).length) {
                        page = $(_resource.pageSlider).find("#" + pageSet);
                        $('#identifier-' + resourceId).click();
                        if( multiInfo === 0 ){
                            setTimeout(function(){$('#identifier-' + resourceId).click();},1500);
                        }else{
                        }

                        pageSet = false;
                        clearInterval(checkExist);
                    }
                }, 300);
                first = false;
            }
            if(page.length) {
                var index = page.parent().find(".numberOverResources").html();
                index = parseInt(index,10) || 0;
                _resource.selectPage(index);
                _resource.sliderMove({
                    direction: "right",
                    slider: $(_resource.pageSlider).parent(),
                    multiplier: 1,
                    speed: 1000
                }, (index-3)/2);
            }
        }
        // });
    };
    $('.other-resources').click(otherResourcesClick);

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
        $('#zoom-range').val(1);
        $('#ImageWrap').css('top','');
        $('#ImageWrap').css('left','');
        $(".fullscreenImage").css('transform', 'rotate(' + angle + 'deg' + ')');
    });

    $(_resource.pageSlider).on('click', 'img', function(e) {
        var kid = $(e.currentTarget).attr("id");
        var resource_kid = $(e.currentTarget).parent().parent().attr("id");
        resource_kid = resource_kid.replace("resource-pagelevel-", "");
        _resource.currentPage = parseInt(
            $(e.currentTarget).parent().find(".numberOverResources").html()
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
        $('#ImageWrap, .fullscreenInner').css({
            top: 'auto',
            right: 'auto',
            bottom: 'auto',
            left: 'auto'
        });
        $('#zoom-range').val(1)
        $('#ImageWrap #PageImage').css({transform: 'scale(1)'})
        $('#ImageWrap #canvas').css({transform: 'scale(1)'})
        $(".fullscreenImage").attr('src', imageSrc);
        $('.fullscreenWrap').css('display', 'block');
        zoomOption = 1;
        $('.fullscreenInner, .fullscreenOuter').css('transform', 'scale(1)');
        $('html, body').css({
            'overflow': 'hidden',
            'height': '100%'
        });
    }

    if (typeof(multiInfo) == 'undefined') {
        return;
    }

    if (multiInfo !== false) {
        prepAccordion(true);
        $(".accordion").accordion({
            heightStyle: "fill",
            active: 3,
            autoHeight: false
        });
        scrollPrep();
        dynamicPrep();
        var currentImageKid = '';
        for( var ind in RESOURCES[Object.keys(RESOURCES)[0]]['page'] ){
            if( RESOURCES[Object.keys(RESOURCES)[0]]['page'][ind]['Scan_Number'] == "1.000000000000000000000000000000" ){
                currentImageKid = ind;
            }
        }
        if( currentImageKid == '' ){
            currentImageKid = RESOURCES[Object.keys(RESOURCES)[0]]['page'][Object.keys(RESOURCES[Object.keys(RESOURCES)[0]]['page'])][0];
        }
        var multiPageSet = false;
        if( pageSet != false ){
            currentImageKid = pageSet;
            multiPageSet = pageSet;
        }
        //GetNewResource(currentImageKid);
        $('#PageImage').css('display', 'block').addClass('multiInfo');
        //decide whether or not multi-resource drawer is shown. Fix css also
        if( window.innerWidth <= 900 ) {
            $('#scroll2').css('margin-top', '114px');
            $('.resource-nav-level#resources-nav').css('margin-top', '156px');
            //$('.resource-nav-level#resources-nav').css('margin-top','156px');
            $('#viewer-right').css('top', '158px');
        }
        $('.resource-nav-level').css('display', 'block');
        //$('.selectedCurrentResource').click();

        var loaded = {
            projects : [],
            seasons : [],
            excavations : [],
            resources : [],
            subjects : []
        };
        for (var kid in PROJECTS){
            loaded.projects.push(kid);
        }
        for (var kid in SEASONS){
            loaded.seasons.push(kid);
        }
        for (var kid in EXCAVATIONS){
            loaded.excavations.push(kid);
        }
        for (var kid in RESOURCES){
            loaded.resources.push(kid);
        }
        for (var kid in SUBJECTS){
            loaded.subjects.push(kid);
        }

        $.ajax({
            url: arcs.baseURL + "view/" + multiInfo,
            type: 'GET',
            data: {
                'getRest' : true
            },
            success: function (results) {
                $('#PageImage').removeClass('multiInfo');
                results = JSON.parse(results);
                PROJECTS = Object.assign(results.projectsArray, PROJECTS);
                SEASONS = Object.assign(results.seasons, SEASONS);
                RESOURCES = Object.assign(results.resources, RESOURCES);
                EXCAVATIONS = Object.assign(results.excavations, EXCAVATIONS);
                SUBJECTS = Object.assign(results.subjects, SUBJECTS);
                showButNoEditArray = Object.assign(results.showButNoEditArray, showButNoEditArray);
                annotationFlags = Object.assign(results.flags['annotationFlags'], annotationFlags);
                controllerFlags = Object.assign(results.flags, controllerFlags);
                //SEASONS = results.seasons;
                //RESOURCES = results.resources;
                //EXCAVATIONS = results.excavations;
                //SUBJECTS = results.subjects;
                //showButNoEditArray = results.showButNoEditArray;
                //annotationFlags = results.flags['annotationFlags'];
                var firstid = $('#other-resources.other-page a').length - 1;
                var cnt = 1;
                for (resource in results.resources) {
                    // the first resource is already loaded
                    if (cnt == 1) {
                        cnt++;
                        continue;
                    }
                    // first we add the resource to the resource slider
                    resource = results.resources[resource];
                    var html = "<a class='other-resources' data-projectKid='"+resource['project_kid']+"' style='opacity: 0.6'>";
                    html += "<img id='identifier-"+resource.kid+"' class='other-resource";
                    html += results.showButNoEditArray.indexOf(resource.kid) ? " showButNoEdit' " : "' ";
                    html += "src='"+resource.thumbsrc+"' height='200px'/>";
                    html += "<div class='numberOverResources'>"+cnt+"</div>";
                    $('#other-resources.resource-slider').append(html);
                    cnt++;

                    // next we add the pages to the page slider
                    var pagecnt = 0;
                    for (pageid in resource.page) {
                        var page = resource.page[pageid];
                        html = "<a class = 'other-resources' id = '"+resource.kid+"' style='display: none; opacity: 0.6'><img class = 'other-resource' id = '";
                        html += page.kid != undefined ? page.kid : resource.kid;
                        html += "' src='"+page.thumbsrc+"' /><div class='numberOverResources'>";
                        html += (++pagecnt)+"</div></a>";
                        $('#other-resources.other-page').append(html);
                    }
                    $('#resource-drawer-loader').remove();
                }
                //$('#resources-nav.resource-nav-level').show();
                _resource.setPointer(Object.keys(results.resources)[0]);

                // handle click handlers
                $(".numberOverResources").unbind('click', numberOverResourcesClick);
                $(".numberOverResources").click(numberOverResourcesClick);
                $('.other-resources').unbind('click', otherResourcesClick);
                $('.other-resources').click(otherResourcesClick);
                pageSelectBuild(firstid);

                addResources(loaded);

                dynamicPrep();
                editMetaPrep();
                annotationPrep();
                // collectionPrep();
                commentsPrep();
                flagPrep();
                keywordPrep();
                scrollPrep();
                $('.selectedCurrentResource').attr('data-dontclickpage',multiPageSet)
                $('.selectedCurrentResource').click();
                // if( multiPageSet !== false ){
                //     setTimeout(function(){
                //         var page = $(_resource.pageSlider).find("#" + multiPageSet);
                //         $(page).click();
                //         if(page.length) {
                //             var index = page.parent().find(".numberOverResources").html();
                //             index = parseInt(index,10) || 0;
                //             _resource.selectPage(index);
                //             _resource.sliderMove({
                //                 direction: "right",
                //                 slider: $(_resource.pageSlider).parent(),
                //                 multiplier: 1,
                //                 speed: 1000
                //             }, (index-3)/2);
                //         }
                //     },500);
                //
                // }
                $('#export-data-buttons').removeClass('opacitied').css('opacity','');
            }
        });
    }else{
        prepAccordion(true);
        dynamicPrep();
        editMetaPrep();
        annotationPrep();
        // collectionPrep();
        commentsPrep();
        flagPrep();
        keywordPrep();
        scrollPrep();
        $(".accordion").accordion({
            heightStyle: "fill",
            active: 3
        });
        $('#export-data-buttons').removeClass('opacitied').css('opacity','');
    }
});

function addResources(loaded){
    var projectsToLoad = {};
    var projectsCount = loaded.projects.length;
    for (var kid in PROJECTS){
        if (loaded.projects.includes(kid)) {
        } else {
            projectsToLoad[kid] = PROJECTS[kid];
            loaded.projects.push(kid)
        }
    }

    var excavationsToLoad = {};
    var excavationsCount = loaded.excavations.length;
    for (var kid in EXCAVATIONS){
        if (loaded.excavations.includes(kid)) {
        } else {
            excavationsToLoad[kid] = EXCAVATIONS[kid];
            loaded.excavations.push(kid)
        }
    }

    var seasonsToLoad = {};
    var seasonsCount = loaded.seasons.length;
    for (var kid in SEASONS){
        if (loaded.seasons.includes(kid)) {
        } else {
            seasonsToLoad[kid] = SEASONS[kid];
            loaded.seasons.push(kid)
        }
    }

    var resourcesToLoad = {};
    var resourcesCount = loaded.resources.length;
    for (var kid in RESOURCES){
        if (loaded.resources.includes(kid)) {
        } else {
            resourcesToLoad[kid] = RESOURCES[kid];
            loaded.resources.push(kid)
        }
    }

    var subjectsToLoad = {};
    var subjectsCount = loaded.subjects.length;
    for (var kid in SUBJECTS){
        if (loaded.subjects.includes(kid)) {
        } else {
            subjectsToLoad[kid] = SUBJECTS[kid];
            loaded.subjects.push(kid)
        }
    }

    //change generateMetadata so that you can insert html instead of destroying the accordion and rebuilding.
    //var projectData = generateMetadata("project", projectsToLoad, controllerMetadataEdits, controllerMetadataOptions, controllerFlags.metadataFlags, false, false, projectsCount);
    //var seasonsData = generateMetadata("Seasons", seasonsToLoad, controllerMetadataEdits, controllerMetadataOptions, controllerFlags.metadataFlags, false, false, seasonsCount);
    //var excavationsData = generateMetadata("excavations", excavationsToLoad, controllerMetadataEdits, controllerMetadataOptions, controllerFlags.metadataFlags, seasonsToLoad, false, excavationsCount);
    //var archivalData = generateMetadata("archival objects", resourcesToLoad, controllerMetadataEdits, controllerMetadataOptions, controllerFlags.metadataFlags,excavationsToLoad,seasonsToLoad, resourcesCount);
    //var subjectsData = generateMetadata("subjects", subjectsToLoad, controllerMetadataEdits, controllerMetadataOptions, controllerFlags.metadataFlags, false, false, subjectsCount);

    var projectData = generateMetadata("project", projectsToLoad, controllerMetadataEdits, controllerMetadataOptions, controllerFlags.metadataFlags, false, false, projectsCount);
    var seasonsData = generateMetadata("Seasons", seasonsToLoad, controllerMetadataEdits, controllerMetadataOptions, controllerFlags.metadataFlags, false, false, seasonsCount);
    var excavationsData = generateMetadata("excavations", excavationsToLoad, controllerMetadataEdits, controllerMetadataOptions, controllerFlags.metadataFlags, SEASONS, false, excavationsCount);
    var archivalData = generateMetadata("archival objects", resourcesToLoad, controllerMetadataEdits, controllerMetadataOptions, controllerFlags.metadataFlags,EXCAVATIONS,SEASONS, resourcesCount);
    var subjectsData = generateMetadata("subjects", subjectsToLoad, controllerMetadataEdits, controllerMetadataOptions, controllerFlags.metadataFlags, false, false, subjectsCount);


    $('.archival.objects-table').parent().append(archivalData);
    $('.project-table').parent().append(projectData);
    $('.excavation-tab-content').append(excavationsData);
    $('.season-tab-content').append(seasonsData);
    $('.level-content.soo').parent().append(subjectsData);



    // create excavation bubbles
    var html = '';
    var count = excavationsCount;
    for (var excavationKid in excavationsToLoad) {
        count++;
        html += '<li class="excavation-li" class="metadata-accordion ul" data-kid="' + excavationKid + '">';
        html += '<a href="#excavations' + count + '" class="excavation-click' + count + ' excavation-click">';
        html += count + '</a></li>';
    }

    //add the excavation bubbles
    $('.excavation-tab-content').prev().append(html);
    $('.excavation-tab-content').prev('destroy')
    $('.excavation-tab-content').prev({
        heightStyle: "fill",
        active: 3
    });


    //create subjects bubbles
    //create subjects bubbles
    var html = '';
    var count = subjectsCount;
    var page_associator = '';

    for (var subjectKid in subjectsToLoad) {
        count++;
        var subject = subjectsToLoad[subjectKid];
        html += '<li class="soo-li"';
        if (subject['Pages_Associator'] != undefined && subject['Pages_Associator'][0] != undefined) {
            html += 'data-pageKid="' + subject['Pages_Associator'][0] + '" data-sooKid="' + subject['kid'] + '"';
        }
        html += '><a href="#soo-' + count + '" class="soo-click' + count + ' soo-click">';
        if (subject['Pages_Associator'][0] != page_associator) {
            page_associator = subject['Pages_Associator'][0];
        }
        html += count + '</a></li>';
    }

    //add the subject bubbles
    $('.level-content.soo').prev().append(html);
    $('.level-content.soo').prev('destroy')
    $('.level-content.soo').prev({
        heightStyle: "fill",
        active: 3
    });

    //create seasons bubbles
    var html = '';
    var count = seasonsCount;
    var page_associator = '';
    for (var seasonKid in seasonsToLoad) {
        count++;
        var season = seasonsToLoad[seasonKid];
        html += '<li class="season-li season-li-bubble-css"  class="metadata-accordion ul" ';
        html += ' data-kid = ' + season["kid"] + '>';
        html += '<a href="#Seasons' + count + '" class="season-a-bubble-css season-click' + count + '  season-click">';
        html += count + '</a></li>';
    }

    //add the season bubbles
    $('.season-tab-content').prev().append(html);
    $('.season-tab-content').prev('destroy')
    $('.season-tab-content').prev({
        heightStyle: "fill",
        active: 3
    });

    $(".accordion").accordion('destroy')
    $(".accordion").accordion({
        heightStyle: "fill",
        active: 3
    });
}
