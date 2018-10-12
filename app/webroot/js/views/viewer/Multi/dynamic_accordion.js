function dynamicPrep() {
    /*
          Multi-resource dynamic accordion. based on new page and resource clicks.
     *********************************************************************************/
    //new page click show/hide the correct metadata
    $('.other-page').on('click', 'img', function(){  //page click
        $('.resource-reset-icon').click(); //reset the image position
        //subject of observation stuffs.
        $('.subjects-table').each(function(){  //hide all tables
            $(this).css('display','none');
        });
        $('.soo-li').each(function(){   //hide all radio buttons
            $(this).css('display','none');
        });
        var pageKid = $(this).attr('id');
        var clickedFirst = 0;
        var number = 1;
        $(".soo-li").each(function(){
            //show the matching radio buttons
            if( $(this).attr('data-pageKid') == (pageKid)){
                $(this).css('display','inline-block');
                $(this).find('a').html(number);
                number++;
                if( clickedFirst == 0 ){ //click the page's first soo radio button
                    $(this)[0].click();
                    clickedFirst = 1;
                }
            }
        })
        var countHtml = '';
        number -= 1;
        if( number > 1 ){
            countHtml = " ("+number+")";
        }
        $('.drawer-name-text-subjects').html('Subjects'+countHtml);

    })
    //soo radio button clicked. change css and show the correct soo table.
    $('.soo-li').click(function () { //soo radio button click
        $('.soo-li').each(function(){  //unclick all radio button css
            $(this).css('background-color','#f9f9f9');
            $(this).css('color','#555555');
        })
        $(this).css('background-color','#0093be'); //click this one button css
        $(this).css('color','#f9f9f9');
        $('.subjects-table').each(function(){  //hide all tables
            $(this).css('display','none');
        });
        var sooKid = $(this).attr('data-sooKid');
        $('.subjects-table[data-kid="'+sooKid+'"]').css('display','table'); //show the correct table
    })

    // //excavation radio button clicked. change css and show the correct excavations table.
    $('.excavation-li').click(function () { //excavation radio button click
        $('.excavation-li').each(function(){  //unclick all radio button css
            $(this).css('background-color','#f9f9f9');
            $(this).css('color','#555555');
        })
        $(this).css('background-color','#0093be'); //click this one button css
        $(this).css('color','#f9f9f9');
        $('.excavations-table').each(function(){  //hide all tables
            $(this).css('display','none');
        });
        var kid = $(this).attr('data-kid');
        $('.excavations-table[data-kid="'+kid+'"]').css('display','table'); //show the correct table
    })

    //new resource clicked. show/hide metadata based on the resource.
    $('.resource-slider').find('a.other-resources').click(function(){
        //display correct project
        var projectKid = $(this).attr('data-projectKid');
        $('.project-table').css('display', 'none');
        $('.project-table[data-kid="'+projectKid+'"]').css('display', 'table');
        //display correct resource
        var resourceKid = $(this).find('img').attr('id');
        resourceKid = resourceKid.replace('identifier-', '');

        //decide if you are allowed to edit
        if( showButNoEditArray.includes(resourceKid) ){
            //not allowed to edit
            $('.tools').css('visibility', 'hidden');
            $('.metadata-edit-btn').css('visibility', 'hidden');
            $('.trashTranscript').css('visibility', 'hidden');
            $('.flagAnnotation').css('visibility', 'hidden');
            $('.flagTranscript').css('visibility', 'hidden');
            $('.submitContainer').css('height', '0px').css('visibility', 'hidden');
            $('.editTranscriptions').css('visibility', 'hidden');
            $('#keyword-edit-btn').css('visibility', 'hidden');
            $('.annotateRelation').css('visibility', 'hidden');
            $('.annotateLabel').css('visibility', 'hidden');
        }else{
            $('.tools').css('visibility', 'visible');
            $('.metadata-edit-btn').css('visibility', 'visible');
            $('.trashTranscript').css('visibility', 'visible');
            $('.flagAnnotation').css('visibility', 'visible');
            $('.flagTranscript').css('visibility', 'visible');
            $('.submitContainer').css('height', '60px').css('visibility', 'visible');
            $('.editTranscriptions').css('visibility', 'visible');
            $('#keyword-edit-btn').css('visibility', 'visible');
            $('.annotateRelation').css('visibility', 'visible');
            $('.annotateLabel').css('visibility', 'visible');
        }
        var viewer = $("#ImageWrap"),
            submit = $(".submitContainer"),
            toolbar = $("#resource-tools");
        $(".commentContainer").css("height", viewer.height() + toolbar.height() + 1 - submit.height());

        $('.archival.objects-table').css('display', 'none');
        $('.archival.objects-table[data-kid="'+resourceKid+'"]').css('display', 'table');
        //find the excavations
        var stringExcavationKids = $('.archival.objects-table[data-kid="'+resourceKid+'"]')
            .find("[id='Excavation_-_Survey_Associator']").attr('data-associations');

        if (typeof(stringExcavationKids) == 'undefined'){
            stringExcavationKids = "";
        }

        var excavationKids = stringExcavationKids.split(' '); //turn into array
        excavationKids.pop(); //remove an empty index
        excavationKids.sort();
        var excavationSeasonAssociators = [];
        setTimeout(function () { //wasn't hiding all if not in this..
            $('.excavation-li').css('display', 'none'); //hide all
            $('.excavation-tab-content').css('display', 'none');
            $('.excavation-tab-content').css('height', 'auto');
            var firstDrawer = 0;
            var firstDrawer2 = 0;
            var number = 1;
            for(var i=0;i<excavationKids.length;i++){ //show each excavation
                var excavationHead = $('.excavation-li[data-kid="'+excavationKids[i]+'"]');
                $(excavationHead).css('display', 'block');
                excavationHead.find('a').html(number);
                number++;

                //click the first drawer
                if( firstDrawer == 0 ){
                    firstDrawer =1;
                    $('.excavation-tab-content').css('display', 'block');
                    // if($(excavationHead).attr('aria-selected') == 'false') {
                        $(excavationHead).click();
                    // }
                }

                //only show the first excavation drawer.
                if($('.excavations-table[data-kid="'+excavationKids[i]+'"]').length>0 ){
                    var ex = $('.excavations-table[data-kid="'+excavationKids[i]+'"]')
                        .find("[id='Season_Associator']").attr('data-associations');
                    ex = ex.split(' ');
                    ex.pop();
                    //console.log(ex);
                    $.merge(excavationSeasonAssociators, ex);
                }
                var result = [];
                $.each(excavationSeasonAssociators, function(i, e) {
                    if ($.inArray(e, result) == -1){
                        result.push(e);
                    }
                });
                excavationSeasonAssociators = result;
            }
            var countHtml = '';
            if( excavationKids.length > 1 ){
                countHtml = " ("+excavationKids.length+")";
            }
            $('.drawer-name-text-excavations').html('excavations'+countHtml);


            //find the season
            var stringSeasonKids = $('.archival.objects-table[data-kid="'+resourceKid+'"]')
                .find("[id='Season_Associator']").attr('data-associations');


            if (typeof stringSeasonKids == 'undefined') {
                //becasue kora returns undefined if something is not set
                stringSeasonKids = "";
            }
            var seasonKids = stringSeasonKids.split(' '); //turn into array
            seasonKids.pop(); //remove an empty index

            //merge the season kids found through excations with the ones found in resource
            $.merge(seasonKids, excavationSeasonAssociators);
            var result = [];
            $.each(seasonKids, function(i, e) {
                if ($.inArray(e, result) == -1){
                    result.push(e);
                }
            });
            seasonKids = result; //all the season kids associated to the clicked resource


            //hide and show the correct seasons
            $('.season-li').css('display', 'none'); //hide all
            $('.season-tab-content').css('display', 'none');
            $('.season-tab-content').css('height', 'auto');
            var firstDrawer = 0;
            var firstDrawer2 = 0;
            var number = 1;
            for(var i=0;i<seasonKids.length;i++){ //show each season
                var seasonHead = $('.season-li[data-kid="'+seasonKids[i]+'"]');
                $(seasonHead).css('display', 'inline-block');
                seasonHead.find('a').html(number);
                number++;

                //click the first drawer
                if( firstDrawer == 0 ){
                    firstDrawer =1;
                    $('.season-tab-content').css('display', 'block');
                    var firstSeasonHead = seasonHead;
                    setTimeout(function(){
                        $(firstSeasonHead).click();
                    }, 1);
                }
            }
            var countHtml = '';
            if( seasonKids.length > 1 ){
                countHtml = " ("+seasonKids.length+")";
            }
            $('.drawer-name-text-Seasons').html('Seasons'+countHtml);

            // seasons bubble changed
            $('.season-li').click(function () { //soo radio button click
                $('.season-li').each(function(){  //unclick all radio button css
                    $(this).css('background-color','#f9f9f9');
                    $(this).css('color','#555555');
                })
                $(this).css('background-color','#0093be'); //click this one button css
                $(this).css('color','#f9f9f9');
                $('.Seasons-table').each(function(){  //hide all tables
                    $(this).css('display','none');
                });
                var seasonKid = $(this).attr('data-kid');
                $('.Seasons-table[data-kid="'+seasonKid+'"]').css('display','table'); //show the correct table
            })

        }, 1);

    })
}
