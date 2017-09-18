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
        $(".soo-li").each(function(){  //show the matching radio buttons
            if( $(this).attr('data-pageKid').indexOf(pageKid) != -1 ){
                $(this).css('display','list-item');
                if( clickedFirst == 0 ){ //click the page's first soo radio button
                    $(this)[0].click();
                    clickedFirst = 1;
                }
            }
        })
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
            .find("[id='Excavation - Survey Associator']").html();
        var excavationKids = stringExcavationKids.split('<br>'); //turn into array
        excavationKids.pop(); //remove an empty index
        excavationKids.sort();
        var excavationSeasonAssociators = [];
        setTimeout(function () {//wasn't hiding all if not in this..
            $('.excavation-tab-head').css('display', 'none'); //hide all
            $('.excavation-tab-content').css('display', 'none');
            $('.excavation-tab-content').css('height', 'auto');
            var firstDrawer = 0;
            var firstDrawer2 = 0;
            for(var i=0;i<excavationKids.length;i++){ //show each excavation
                var excavationHead = $('.excavation-tab-head[data-kid="'+excavationKids[i]+'"]');
                $(excavationHead).css('display', 'block');
                //click the first drawer
                if( firstDrawer == 0 ){
                    firstDrawer =1;
                    if($(excavationHead).attr('aria-selected') == 'false') {
                        $(excavationHead).click();
                    }
                }
                //rename the drawer.
                var text = 'EXCAVATIONS LEVEL '+ (i+1);
                if($('.excavation-tab-head[data-kid="'+excavationKids[i]+'"]').length>0){
                    $('.excavation-tab-head[data-kid="'+excavationKids[i]+'"]')[0].innerText = text;
                }
                //only show the first excavation drawer.
                if($('.excavation-tab-content[data-kid="'+excavationKids[i]+'"]').length>0 ){
                    if( firstDrawer2==0 ) {
                        $('.excavation-tab-content[data-kid="' + excavationKids[i] + '"]').eq(0).css('display', 'block');
                        firstDrawer2 = 1;
                    }
                    var ex = $('.excavation-tab-content[data-kid="'+excavationKids[i]+'"]')
                        .find("[id='Season Associator']").html();
                    ex = ex.replace('<br>', '');
                    //console.log(ex);
                    excavationSeasonAssociators.push(ex);
                }
            }
            //find the season
            var stringSeasonKids = $('.archival.objects-table[data-kid="'+resourceKid+'"]')
                .find("[id='Season Associator']").html();
            var seasonKids = stringSeasonKids.split('<br>'); //turn into array
            seasonKids.pop(); //remove an empty index
            //todo- improve this to hide/show correct seasons**associated through excavation
            $('.Seasons-table').css('display', 'none');
            $('.season-tab-head').css('display', 'none');
            $('.season-tab-content').css('display', 'none');
            var index =1;
            var firstDrawerS = 0;
            $('.Seasons-table').each(function(){
                var season = $(this);
                var sKid = season.attr('data-kid');
                seasonKids.every(function(e){
                    if( e == sKid ){
                        season.css('display', 'table');
                        season.parent().css('display', 'block');
                        season.parent().prev().html('Season Level '+index);
                        season.parent().prev().css('display', 'block');
                        index++;
                        if( firstDrawerS==0 ) {
                            season.parent().prev().click();
                            firstDrawerS = 1;
                        }
                        return false;
                    }
                    return true;
                });
                if( excavationSeasonAssociators.indexOf(sKid) != -1 ){
                    season.css('display', 'table');
                    season.parent().css('display', 'block');
                    season.parent().prev().html('Season Level '+index);
                    season.parent().prev().css('display', 'block');
                    index++;
                    if( firstDrawerS==0 ) {
                        season.parent().prev().click();
                        firstDrawerS = 1;
                    }
                }
            });
        }, 1);

    })
}

// $( document ).ready(dynamicPrep);
