$( document ).ready(function() {

    //hide the resources slider if there is only one resource.
    var hideFirstDrawer = parseInt($('.pages-resource-nav').attr('data-hideFirstDrawer'));
console.log('hi', hideFirstDrawer);
    if (!hideFirstDrawer){
	console.log($('.pages-resource-nav'));
        $('.pages-resource-nav').css('display', 'block');
    }
    if($('.resource-slider').find('.other-resources').length > 1){
        $('.resource-nav-level').css('display', 'block');
        var resource_kid = $('.selectedCurrentResource').find('img').attr('id');
        resource_kid = resource_kid.replace('identifier-', '');
        _resource.setPointer(resource_kid);
    }
    $(window).trigger('resize');

    /*
          Left and right resource buttons right under main picture.
     ****************************************************/

    //left prev resource button
    var prev_view_tested = 0; //test inView only once.
    $('#prev-resource').click(function(){
        //already being animated. just ignore click.
        if( $("#other-resources-container").is(':animated') ){
            return;
        }
        //find the current page
        var currentPage = $('.selectedCurrentPage');
        var inView = isElementInViewport($(currentPage)); //test page is shown
        if( !inView && prev_view_tested == 0 ){ //not shown and not already tested
            prev_view_tested = 1;  //tested
            var slider = $("#other-resources-container");
            var offset = $(slider).scrollLeft()+$(currentPage).position().left-
                ( parseInt($(currentPage).find('img').width())/4
                );
            //animate the current resource into view.
            $(slider).animate({scrollLeft: offset }, 1, function(){
                $('#prev-resource')[0].click(); //continue bottom code later
            });
            return; //wait until animate is finished to continue
        }
        prev_view_tested = 0;  //not tested
        //find the previous page
        var previous = $(currentPage).prev();
        if( previous.length > 0 ){
            var isAnimate = 0; //0 mean normal animate, 1 is resouce change
            if( $(currentPage).attr('id') != $(previous).attr('id') ){ //its a new resource
                var id = '#identifier-'+$(previous).attr('id');
                $(id)[0].click(); // click the new resource
                isAnimate = 1;
                setTimeout(function () { //wait for the pages to update
                    var offset = $(previous).position().left; //update pages bar
                    var slider = $("#other-resources-container");
                    $(slider).animate({scrollLeft: offset }, 1);
                    slider = $(".resource-container-level"); //update resource bar
                    offset = $(slider).scrollLeft() -
                        ( parseInt($(previous).find('img').width()) +
                            parseInt($(previous).find('img').css('margin-left'))*2
                        );
                    $(slider).animate({scrollLeft: offset }, 400, function(){
                        //trigger a resize so the drawer arrows get checked.
                        $(window).trigger('resize');
                    });

                }, 100);
            }
            previous.find('img').click(); //click the new page
            if( isAnimate == 0 ){ //do a normal page animate if its the same resource
                var slider = $("#other-resources-container");
                var offset = $(slider).scrollLeft() -
                    ( parseInt($(previous).find('img').width()) +
                      parseInt($(previous).find('img').css('margin-left'))*2 +
                      parseInt($(previous).find('img').css('border-width'))*2
                    );
                $(slider).animate({scrollLeft: offset }, 200, function(){
                    //trigger a resize so the drawer arrows get checked.
                    $(window).trigger('resize');
                });
            }
        }
    });
    //right next resource button.
    var next_view_tested = 0; //test inView only once.
    $('#next-resource').click(function(){
        if( $("#other-resources-container").is(':animated') ){
            return;
        }
        var currentPage = $('.selectedCurrentPage');
        var inView = isElementInViewport($(currentPage)); //test page is shown
        if( !inView && next_view_tested == 0 ){ //not shown and not already tested
            next_view_tested = 1;  //tested
            var slider = $("#other-resources-container");
            var offset = $(slider).scrollLeft()+$(currentPage).position().left-
                ( parseInt($(currentPage).find('img').width())/4
                );
            //animate the current resource into view.
            $(slider).animate({scrollLeft: offset }, 1, function(){
                $('#next-resource')[0].click(); //continue bottom code later
            });
            return; //wait until animate is finished to continue
        }
        next_view_tested = 0;  //not tested
        var next = $(currentPage).next();
        if( next.length > 0 ){
            var isAnimate = 0;
            if( $(currentPage).attr('id') != $(next).attr('id') ){ //its a new resource
                var id = '#identifier-'+$(next).attr('id');
                $(id)[0].click();
                isAnimate = 1;
                setTimeout(function () {
                    var slider = $("#other-resources-container");
                    $(slider).animate({scrollLeft: 0 }, 1);
                    slider = $(".resource-container-level");
                    var offset = $(slider).scrollLeft() +
                        ( parseInt($(next).find('img').width()) +
                            parseInt($(next).find('img').css('margin-left'))*2
                        );
                    $(slider).animate({scrollLeft: offset }, 400, function(){
                        //trigger a resize so the drawer arrows get checked.
                        $(window).trigger('resize');
                    });

                }, 100);
            }
            next.find('img').click();
            if( isAnimate == 0 ){
                var slider = $("#other-resources-container");
                var offset = $(slider).scrollLeft() +
                    ( parseInt($(next).find('img').width()) +
                      parseInt($(next).find('img').css('margin-left'))*2 +
                      parseInt($(next).find('img').css('border-width'))*2
                    );
                $(slider).animate({scrollLeft: offset }, 200, function(){
                    //trigger a resize so the drawer arrows get checked.
                    $(window).trigger('resize');
                });
            }
        }
    });
    $(".fullscreen-next").click(function () {
       $('#next-resource').trigger("click");
    });
    $(".fullscreen-prev").click(function () {
       $('#prev-resource').trigger("click");
    });
    function isElementInViewport (el) {

        //special bonus for those using jQuery
        if (typeof jQuery === "function" && el instanceof jQuery) {
            el = el[0];
        }

        var rect = el.getBoundingClientRect();

        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && /*or $(window).height() */
            rect.right <= (window.innerWidth || document.documentElement.clientWidth) /*or $(window).width() */
        );
    }
});
