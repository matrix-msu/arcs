$(document).ready(function() {
	
	if( $('#export-btn').length > 0 ){
		return; //this is a multi-viewer export
	}
	
	$('#export-images-buttons, #export-data-buttons').click(function(e){
		if( $(this).hasClass('opacitied') ){
			return;
		}
		if( $(this).hasClass('new-open') ){ //close
			$(this).removeClass('new-open');
			$(this).find('.pointerDown').css('transform','rotate(135deg');
			$(this).find('.dropdown-menu').css('display','none');
		}else{ //open
			$(this).addClass('new-open');
			$(this).find('.pointerDown').css('transform','rotate(315deg');
			$(this).find('.dropdown-menu:not(#export-images-warning)').css('display','block');
		}
	});
	
	$('#export-images-buttons').on('hover', function(){
		if( $(this).hasClass('opacitied') ){
			$('#export-images-warning').css('display','block');
			$('#export-images-buttons').css('opacity','1');
		}
	});
	$('#export-images-buttons').on('mouseleave', function(){
		if( $(this).hasClass('opacitied') ){
			$('#export-images-warning').css('display','none');
			$('#export-images-buttons').css('opacity','.2');
		}
	});
	
	$('#export-images-buttons').find('.export-image-num').unbind().click(function(e){
		e.preventDefault();
		e.stopPropagation();
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
	
	$('#export-data-buttons').find('.export-data-type').unbind().click(function(e){
		e.preventDefault();
		e.stopPropagation();
		$('#export-data-buttons').find('.export-data-type').removeClass('active');
		$(this).addClass('active');
		return;
	});
	
	$('#export-data-buttons').find('.export-data-num').unbind().click(function(e){
		e.preventDefault();
		e.stopPropagation();
		$('#export-data-buttons').find('.export-data-num').removeClass('active');
		$(this).addClass('active');
		if( $(this).attr('id') === 'export-data-all' ){
			var packs = 1;
		}else{
			var packs = Math.ceil(JSON.parse($('#selected-resource-ids').html()).length/$(this).attr('data-num'));
		}
		//change dropdown-menu
		var packHtml = '';
		for( var i=1; i<=packs; i++ ){
			packHtml += '<li><a class="sort-btn export-data-link" data-pack="'+i+'">DATA PACK '+i+'</a></li>'
		}
		$('#export-resources-per').find('.export-data-link').parent().remove();
		$('#export-resources-per').append(packHtml);
		return;
	});
	
	var isExporting = 0;
	var picUrls = [];
	
    $('#export-resources-per').on('click', '.export-data-link', function(e){ //do export.
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
		
        var loaderHtml = $(ARCS_LOADER_HTML);
        $(loaderHtml).css({'height':'inherit','margin-top':'4px','width':'12px','float':'right','margin-right':'24px'});
        $(loaderHtml).find('.sk-folding-cube').css({'height':'10.43px', 'width':'10.43px'});
        $(this).append(loaderHtml);

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
											$('#export-images-warning').css('display','none');
											
											$('#export-images-buttons').find('.export-image-num').removeClass('active');
											$('#export-image-30').addClass('active');
											var packs = Math.ceil(picUrls.length/30);
											var packHtml = '';
											for( var i=1; i<=packs; i++ ){
												packHtml += '<li><a class="sort-btn export-images-link" data-pack="'+i+'">IMAGES PACK '+i+'</a></li>'
											}
											$('#export-images-per').find('.export-images-link').parent().remove();
											$('#export-images-per').append(packHtml);
										}
										isExporting = 0;
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
	
	$('#export-images-per').on('click', '.export-images-link', function(e){ //do images export.
		e.preventDefault();
		e.stopPropagation();
        var $clicked = $(this);
        if(isExporting == 1 || $(this).hasClass('search-loading') ){
            return;
        }		
        isExporting = 1;
		
        var loaderHtml = $(ARCS_LOADER_HTML);
        $(loaderHtml).css({'height':'inherit','margin-top':'4px','width':'12px','float':'right','margin-right':'24px'});
        $(loaderHtml).find('.sk-folding-cube').css({'height':'10.43px', 'width':'10.43px'});
        $(this).append(loaderHtml);
		
		if( $('#export-image-all').hasClass('active') ){
			var picUrlsSlice = picUrls;
		}else{
			var packIncrement = parseInt($('.export-image-num.active').attr('data-num'));
			var packStart = ($(this).attr('data-pack') - 1) * packIncrement;
			var picUrlsSlice = picUrls.slice(packStart, packStart+packIncrement);
		}
		$('<form />')
			.hide()
			.attr({ method: "post" })
			.attr({ action: arcs.baseURL + "resources/downloadPictureExportFile" })
			.append($('<input />')
				.attr({ "name": "picUrls" })
				.val(JSON.stringify(picUrlsSlice))
			).append($('<input />')
				.attr({ "name": "packNum" })
				.val($(this).attr('data-pack'))
			).append($('<input />')
				.attr({ "name": "packTotal" })
				.val($('.export-images-link').length)
			)
			.append('<input type="submit" />')
			.appendTo($("body"))
			.submit();
		setTimeout(function () { //give time for jquery form click
			$.ajax({
				url: arcs.baseURL + "resources/checkExportDone",
				type: "POST",
				data: { 'filename': 'nothing' },
				statusCode: {
					200: function () {
						$clicked.html('FINISHED PACK '+$clicked.attr('data-pack'));
						isExporting = 0;
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
		
    });
});
