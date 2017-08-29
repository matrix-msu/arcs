
//Takes care of the pages and resources slider/scroll bars
$( document ).ready(function() {
    var scrollContent = '';
    var scrollSlider = '';
    var arrowsWidth = $('.button-right').width();
    var promiseCount = 0;

    function checkScroll(el){
        if( $(el).attr('id') == 'next-resource' ||
            $(el).attr('id') == 'prev-resource' ||
            $(el).parent().hasClass('pages-resource-nav') ||
            $(el).attr('id') == 'scrollLine'
        ){
            return $('.page-slider');
        }
        return $('.resource-container-level');
    }

    function checkSlider(el){
        if( $(el).attr('id') == 'next-resource' ||
            $(el).attr('id') == 'prev-resource' ||
            $(el).parent().hasClass('pages-resource-nav')
        ){
            return $('#scrollLine');
        }
        return $('#scrollLine2');
    }

    $(".ui-slider").slider({
        slide: function(event, ui){
            promiseCount = 0;
            scrollContent = checkScroll(this);
            scrollContent.stop(true, true);
            scrollContent.animate({
                scrollLeft: (scrollContent.prop('scrollWidth') - $(window).width() + arrowsWidth) * (ui.value / 100)
            }, 20);
            scrollContent.promise().done(function(){
                $('#resources-nav').trigger('resize');
            });
        }
    });

    $('.button-right, .button-left, #prev-resource, #next-resource').click(function(){
        promiseCount = 0;
        scrollContent = checkScroll(this);
        scrollSlider = checkSlider(this);
        function adjustScroll(){
            var val1 = scrollContent.scrollLeft() *100;
            var val2 = val1 / (scrollContent.prop('scrollWidth')-$(window).width()+arrowsWidth);
            scrollSlider.slider('value', val2);
        }
        var interval = setInterval( adjustScroll, 5 );
        scrollContent.promise().done(function(){
            promiseCount++;
            if( promiseCount == 2 ){
                adjustScroll();
                var resourcesTray = $('.resource-nav-level').find('.button-left');
                scrollContent = checkScroll(resourcesTray);
                scrollSlider = checkSlider(resourcesTray);
                adjustScroll();
            }
           clearInterval(interval);
        });
    });

    $(window).resize(function() {
        var sign = function(x) {
            return 1 / x === 1 / Math.abs(x);
        }
        var val1 = $('.page-slider').scrollLeft() *100;
        var val2 = val1 / ($('.page-slider').prop('scrollWidth')-$(window).width()+arrowsWidth);
        if( sign(val2) == false ){
            val2 = 100;
        }
        $('#scrollLine').slider('value', val2);

        val1 = $('.resource-container-level').scrollLeft() *100;
        val2 = val1 / ($('.resource-container-level').prop('scrollWidth')-$(window).width()+arrowsWidth);
        if( sign(val2) == false ){
            val2 = 100;
        }
        $('#scrollLine2').slider('value', val2);
    });
});

