$(document).ready(function() {
	
	if( $('#export-btn').length > 0 ){
		return; //this is a multi-viewer export
	}

    $('#export-data-buttons,.exportModalClose').click(function(e){
        if( $(this).hasClass('opacitied') || $('#options-buttons').css('opacity') == .2 ){
            e.preventDefault();
            e.stopPropagation();
            return;
        }
        if( $(this).hasClass('new-open') && isExporting === 0 ){ //close
            $('#export-data-buttons').removeClass('new-open');
            $('#export-data-buttons').find('.pointerDown').css('transform','rotate(135deg');
            $('#export-data-buttons').find('.dropdown-menu').css('display','none');
            $('#export-images-buttons').find('.dropdown-menu').css('display','none');
            $('#export-modal').css('display','none').find('.dropdown-menu').css('display','none');
        }else{ //open
            $('#export-data-buttons').addClass('new-open');
            $('#export-data-buttons').find('.pointerDown').css('transform','rotate(315deg');
            $('#export-data-buttons').find('.dropdown-menu').css('display','none');
            //$('#export-images-buttons').find('.dropdown-menu:not(#export-images-warning)').css('display','block');
            $('#export-modal').css('display','block').find('.dropdown-menu').css('display','block');
        }
    });
	
	$('#export-images-buttons').find('.export-image-num').unbind().click(function(e){
		e.preventDefault();
		e.stopPropagation();
		if( isExporting ){
            return;
        }
		$('#export-images-buttons').find('.export-image-num').removeClass('active');
		$(this).addClass('active');
		if( $(this).attr('id') === 'export-image-all' ){
			var packs = 1;
		}else{
			var packs = Math.ceil(picUrls.length/$(this).attr('data-num'));
		}
		//change dropdown-menu
		var packHtml = '';
		for( var i=1; i<=packs; i++ ){
			packHtml += '<li><a class="sort-btn export-images-link" data-pack="'+i+'">IMAGES PACK '+i+'</a></li>'
		}
		$('#export-images-per').find('.export-images-link').parent().remove();
		$('#export-images-per').append(packHtml);
		return;
	});

    $('#export-modal-explain').find('.export-data-type').unbind().click(function(e){
		e.preventDefault();
		e.stopPropagation();
        $('#export-modal-explain').find('.export-data-type').removeClass('active');
		$(this).addClass('active');
		return;
	});
	
	$('#export-data-buttons').find('.export-data-num').unbind().click(function(e){
		e.preventDefault();
		e.stopPropagation();
		if( isExporting ){
            return;
        }
		$('#export-data-buttons').find('.export-data-num').removeClass('active');
		$(this).addClass('active');
		if( $(this).attr('id') === 'export-data-all' ){
			var packs = 1;
		}else{
			var packs = Math.ceil(JSON.parse($('#selected-resource-ids').html()).length/$(this).attr('data-num'));
		}
		var packHtml = '';
		for( var i=1; i<=packs; i++ ){
			packHtml += '<li><a class="sort-btn export-data-link" data-pack="'+i+'">DATA PACK '+i+'</a></li>'
		}
		$('#export-resources-per').find('.export-data-link').parent().remove();
		$('#export-resources-per').append(packHtml);
		return;
	});
	
	//export automatic
	$('#export-automatic').click(function(e){
		e.stopPropagation();
		e.preventDefault();
		$('.export-data-link').addClass('automatic');
		$('.automatic').eq(0).click();
	});
	
	var isExporting = 0;
	var picUrls = [];
    var picSliceCurrentIndex = 0;
    var picExportPackNum;
	//export link clicks - this actual downlaod data export here
    $('#export-resources-per').on('click', '.export-data-link', function(e){
		e.preventDefault();
		e.stopPropagation();
		
        var exportAsXML = false;
        var $clicked = $(this);

        if( $('#export-as-xml').hasClass('active') ){
            exportAsXML = true;
        }
        if(isExporting == 1 || $(this).hasClass('search-loading') ){
            return;
        }
        isExporting = 1;
		
		var resetPics = 1;
		$('.export-data-link').each(function(){
			if( $(this).hasClass('downloaded') ){
				resetPics = 0;
			}
		});
		if( resetPics == 1 ){
			picUrls = [];
		}

		$('#export-modal-explain').css('display','none');
		$('#export-modal-exporting').css('display','block');
        $('#export-modal-title').html("EXPORTING");

        var loaderHtml = $(ARCS_LOADER_HTML);
        $(loaderHtml).css({'height':'inherit','margin-top':'-26px','width':'12px','float':'right','margin-right':'34px'});
        $(loaderHtml).find('.sk-folding-cube').css({'height':'14.43px', 'width':'14.43px'});
        $("#export-modal-exporting").append(loaderHtml);
        $(".exportModalClose").css('display','none');

        var projects = {};
        var seasons = {};
        var excavations = {};
        var resources = {};
        var pages = {};
        var subjects = {};

        var seasonKids = [];
        var excavationKids = [];
        var resourceKids = [];
        var pageKids = [];
        var subjectKids = [];
        var projectKids = [];
        var imagesArray = [];

        var kidArray = [];

		if( $('#export-data-all').hasClass('active') ){
			var resourceKidSlice = $('#selected-resource-ids').html();
		}else{
			var packIncrement = parseInt($('.export-data-num.active').attr('data-num'));
			var packStart = ($(this).attr('data-pack') - 1) * packIncrement;
			var resourceKidSlice = JSON.parse($('#selected-resource-ids').html()).slice(packStart, packStart+packIncrement);
			resourceKidSlice = JSON.stringify(resourceKidSlice);
		}
		
        //grab all of the data from a multi-resource call.
        var schemeData = [];
        $.ajax({
            url: arcs.baseURL + "resource?ajax",
            type: "POST",
            data: {'resources': resourceKidSlice, 'isExportAjax': true},
            statusCode: {
                200: function (data) {
                    schemeData = JSON.parse(data);
                    projects = schemeData[0];
                    seasons = schemeData[1];
                    excavations = schemeData[2];
                    resources = schemeData[3];
                    subjects = schemeData[4];
                    processExportData();
                }
            }
        })

        function processExportData(){
            for (var season in seasons) {
                if (season != "unique"){
                    seasonKids.push(season);
                }
            }

            for (var excavation in excavations) {
                if (excavation != "unique"){
                    excavationKids.push(excavation);
                }
            }

            for (var resource in resources) {
                if (resource != "unique"){
                    resourceKids.push(resource);
                }
                for (var page in resources[resource]['page']) {
                    if (page != "unique"){
                        pageKids.push(page);
                    }
                }
            }

            for (var subject in subjects) {
                if (subject != "unique"){
                    subjectKids.push(subject);
                }
            }

            for (var project in projects) {
                if (project != "unique"){
                    projectKids.push(project);
                }

            }
            kidArray = [projectKids, seasonKids, excavationKids, resourceKids, pageKids, subjectKids];
            //create file
            $.ajax({
                url: arcs.baseURL + "resources/createExportFile",
                type: "POST",
                data: { 'xmls': JSON.stringify(kidArray),
                    'exportAsXML': exportAsXML
                },
                statusCode: {
                    200: function (data) {
                        data = JSON.parse(data);
						picUrls = picUrls.concat(data.picUrls);
                        //download created file
                        $('<form />')
                            .hide()
                            .attr({ method: "post" })
                            .attr({ action: arcs.baseURL + "resources/downloadExportFile" })
                            .append($('<input />')
                                .attr("type", "hidden")
                                .attr({ "name": "filename" })
                                .val(data.datafile)
                            ).append($('<input />')
								.attr({ "name": "packNum" })
								.val($clicked.attr('data-pack'))
							).append($('<input />')
								.attr({ "name": "packTotal" })
								.val($('.export-data-link').length)
							)
                            .append('<input type="submit" />')
                            .appendTo($("body"))
                            .submit();
                        //check when the export finishes
                        setTimeout(function () { //give time for jquery form click
                            $.ajax({
                                url: arcs.baseURL + "resources/checkExportDone",
                                type: "POST",
                                data: { 'filename': data.datafile },
                                statusCode: {
                                    200: function () {
										var downCount = $('.export-rem-data').eq(0).html();
										if( !$('#export-data-all').hasClass('active') ){
											var tempDownCount = parseInt($('.export-downed-data').html())+parseInt($('.export-data-num.active').attr('data-num'));
											if( tempDownCount < downCount ){
												downCount = tempDownCount;
											}
										}
										$('.export-downed-data').html(downCount);
										var remaining = parseInt($('.export-rem-data').eq(0).html()) - downCount;
										$('.export-rem-decreasing-data').html(remaining);
                                        //doPictureDownloads(0,data.picUrls.length,31);
										$clicked.html('FINISHED PACK '+$clicked.attr('data-pack'));
										$clicked.addClass('downloaded');
										
										var picsReady = 1;
										$('.export-data-link').each(function(){
											if( !$(this).hasClass('downloaded') ){
												picsReady = 0;
											}
										});
										if( picsReady == 1 ){
											$('#export-images-buttons').removeClass('opacitied').css('opacity','');
											$('.export-rem-images').html(picUrls.length);
											var automatic = '';
											if( $('.export-data-link').eq(0).hasClass('automatic') ){
												automatic = ' automatic';
											}
											if( $('.export-image-num.active').attr('id') === 'export-image-all' ){
												var packs = 1;
											}else{
												var packs = Math.ceil(picUrls.length/$('.export-image-num.active').attr('data-num'));
											}
											var packHtml = '';
											for( var i=1; i<=packs; i++ ){
												packHtml += '<li><a class="sort-btn export-images-link'+automatic+'" data-pack="'+i+'">IMAGES PACK '+i+'</a></li>'
											}
											$('#export-images-per').find('.export-images-link').parent().remove();
											$('#export-images-per').append(packHtml);
											$('#export-images-buttons').click();
										}
                                        picExportPackNum = 1;
										isExporting = 0;
										setTimeout(function(){
											$('.automatic:not(.downloaded)').click();
										},50);
										return;
                                    },
                                    400: function () {
                                        console.log("Bad Request");
                                    },
                                    405: function () {
                                        console.log("Method Not Allowed");
                                    }
                                }
                            });
                        }, 50);
                    }
                }
            });
        }
    });
	
	//export image link click - the actual image pack export
	$('#export-images-per').on('click', '.export-images-link', function(e){
		e.preventDefault();
		e.stopPropagation();
        var $clicked = $(this);
        if(isExporting == 1 || $(this).hasClass('search-loading') ){
            return;
        }		
        isExporting = 1;
		
        var loaderHtml = $(ARCS_LOADER_HTML);
        $(loaderHtml).css({'height':'inherit','margin-top':'4px','width':'12px','float':'right','margin-left':'10px'});
        $(loaderHtml).find('.sk-folding-cube').css({'height':'10.43px', 'width':'10.43px'});
        $(this).append(loaderHtml);
		
		if( $('#export-image-all').hasClass('active') ){
			var picUrlsSlice = picUrls;
		}else{
			var packIncrement = parseInt($('.export-image-num.active').attr('data-num'));
			//var packStart = ($(this).attr('data-pack') - 1) * packIncrement;
            var picUrlsSlice = picUrls.slice(picSliceCurrentIndex, picUrls.length);
		}
		var packNum = $(this).attr('data-pack');

		if( picUrlsSlice.length == 0 ){
            $('.export-rem-decreasing-images').html("0");
            isExporting = 0;
            $("#export-modal-exporting").find('.sk-cube-container').remove();
            $(".exportModalClose").css('display','block');
            return;
		}
		
		$.ajax({
			url: arcs.baseURL + "resources/createPictureExportFile",
			type: "POST",
			data: { 
				'picUrls': JSON.stringify(picUrlsSlice)
			},
			statusCode: {
				200: function (data) {
                    data = JSON.parse(data);
                    var numPics = data.numPics;
                    picSliceCurrentIndex += numPics;
                    data = data.filename;
                    console.log("before download", data, picExportPackNum, picSliceCurrentIndex);
					$form = $('<form />')
						.hide()
						.attr({ method: "post" })
						.attr({ action: arcs.baseURL + "resources/downloadPictureExportFile" })
						.append($('<input />')
							.attr({ "name": "filename" })
							.val(data)
						).append($('<input />')
							.attr({ "name": "packNum" })
							.val(picExportPackNum)
						).append($('<input />')
							.attr({ "name": "packTotal" })
							.val($('.export-images-link').length)
						)
						.append('<input type="submit" />')
						.appendTo($("body"))
						.submit();
                    picExportPackNum++;
					setTimeout(function () { //give time for jquery form click
						$.ajax({
							url: arcs.baseURL + "resources/checkExportDone",
							type: "POST",
							data: { 'filename': data },
							statusCode: {
								200: function (data) {
									if(!data){
										return;
									}
									$clicked.html('FINISHED PACK '+$clicked.attr('data-pack'));
									//$clicked.addClass('downloaded');
									var downCount = $('.export-rem-images').eq(0).html();
									if( !$('#export-image-all').hasClass('active') ){
										var tempDownCount = parseInt($('.export-downed-images').html())+parseInt($('.export-image-num.active').attr('data-num'));
										if( tempDownCount < downCount ){
											downCount = tempDownCount;
										}
									}
									$('.export-downed-images').html(downCount);
									var remaining = parseInt($('.export-rem-images').eq(0).html()) - downCount;
									$('.export-rem-decreasing-images').html(remaining);
									isExporting = 0;
                                    if( remaining === 0 ){ //finished all pictures
                                        $("#export-modal-exporting").find('.sk-cube-container').remove();
                                        $(".exportModalClose").css('display','block');
                                    }else{
                                        setTimeout(function(){
                                            $('.automatic:not(.downloaded)').click();
                                        },1000);
                                    }
								},
								400: function () {
									console.log("Bad Request");
								}
							}
						});
					}, 50);
				},
				400: function () {
					console.log("caught the create pic error");
				}
			}
		});
    });
});
