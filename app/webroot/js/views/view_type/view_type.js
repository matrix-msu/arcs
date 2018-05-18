function setUpViewTypeJs(){
//gobal variable array_search
var sortByTitleOrTime = 'Title'; //title or systimestamp
var sortDirection = -1; //1 or -1
var numberPerPage = 20; //how many are displayed on the page
var template = 'search/grid'; //either 'search/grid' or 'search/list'
var informationMap = {}; //all kids with their display info
var indicators = {};  //all kids with thier indicators
var results_to_display = {}; // the kids and info that are currently displayed
var currentPage = 1; // The current page
// var resourceType = location.href.split('/').slice(-1)[0];
var doneLoading = false // True once we load all the info we need.
var selectedMap = {
  "unselected": [],
  "selected": []
};
// Globals loaded from PHP
// allByTitle - all kids sorted by Title
// allByTime - all kids sorted by time
// lockedResources - all kids of locked resources
// resourceType - the type of resource to display
allByTitle.forEach(function(kid) {
	informationMap[kid] = false;
    indicators[kid] = false;
});

indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; };

//kick off the entire search.js file
$(document).ready(function(){
    if (resourceType.toLowerCase() == 'orphaned') {
        $('.toolbar-fixed').css('display','none');
    }
    $('.Searchbar').css('display','none');

	changeDisplay();
    if (doneLoading == false) {
        loadMore(2); //start loading the next pages
    }

	// open in collection view button
	$('#open-colview-form').click(function(e) {
		if (selectedMap['selected'].length > 0) {
			var form = $(e.target).parent();
			form.find("input").attr({value: JSON.stringify(selectedMap['selected']) });
			form.attr({action: arcs.baseURL + "view/"});
			form.submit();
		}
	});

	$('.search-again-link').click(function(e) {
		window.location.reload();
	});
});

function getKids(pageNo) {
    // gets the kids for the resources displayed on a page
	var start = (pageNo - 1) * numberPerPage;
    var end = start + numberPerPage;

	var displayKids = [];

    if (end > allByTitle.length) { // so it doesn't get an index error
        end = allByTitle.length;
    }
    if (start > allByTitle.length) {
        start = 0;
    }

	if (sortByTitleOrTime == 'Title') {
		displayKids = allByTitle.slice(start, end);
	}else {
		displayKids = allByTime.slice(start, end);
	}
	return displayKids;
}

function getKidInfo(kidArray) {
	//get info for kids in kidArray and update the informationMap with it
	var results = []
	$.ajax({
		type: 'POST',
		url: window.location.href,
		data: {'kidArray':kidArray},
		success: function(response) {
            indicatorResults = JSON.parse(response)['indicators'];
			results = JSON.parse(response)['results'];
						// fill in the indicators that were found
            Object.keys(indicatorResults).forEach(function(kid){
                indicators[kid] = indicatorResults[kid];
            });
			results.forEach(function(result){
				// fill the infomation map with the info
				informationMap[result['kid']] = result;
			});
            doneLoading = true;
            Object.keys(informationMap).forEach(function(kid){
                if (informationMap[kid] == false) {
                    doneLoading = false;
                }
            });
			useResults();
		},
	});
}

function loadMore(pageNo) {
    // will keep running untill all of the rescoures have been loaded
    if (doneLoading == true) {
        return;
    }
    //get the kids for the next page
    loadKids = getKids(pageNo);
    var getInfoFor = [];
    loadKids.forEach(function(kid) {
        if (informationMap[kid] == false) {
            getInfoFor.push(kid);
        }
    });

    if (getInfoFor.length == 0 && doneLoading == false) {
        loadMore(pageNo + 1); // keep loading more
        return;
    }

    var results = []
	$.ajax({
		type: 'POST',
		url: window.location.href,
		data: {'kidArray':getInfoFor},
		success: function(response) {
            indicatorResults = JSON.parse(response)['indicators'];
			results = JSON.parse(response)['results'];
            // fill in the indicators that were found
            Object.keys(indicatorResults).forEach(function(kid){
                indicators[kid] = indicatorResults[kid];
            });
			results.forEach(function(result){
				// fill the infomation map with the info
				informationMap[result['kid']] = result;
			});

            doneLoading = true;
            Object.keys(informationMap).forEach(function(kid){
                if (informationMap[kid] == false) {
                    doneLoading = false;
                }
            });

            if (doneLoading == false) {
                loadMore(pageNo + 1); // keep loading more
            }
    	},
    });
}

//used to switch between tile and list views
function changeDisplay() {
	// the kids displayed on the screen
	displayKids = getKids(currentPage);
	var getInfoFor = []; //kids to be displayed that still need info
	displayKids.forEach(function(kid) {
		if (informationMap[kid] == false) {
			getInfoFor.push(kid);
		}
	});
	if (getInfoFor.length > 0) {
		getKidInfo(getInfoFor);
	}else {
		useResults();
	}
}

function useResults(){
	results_to_display = {};
	displayKids.forEach(function(kid) {
		// fill results to display with the information
		results_to_display[kid] = informationMap[kid];
	});

	$(".searchIntro").css("display","none")
	$("#searchBox").css("display","none")
	$("#advanced").css("display","none")
	$('#search-results-wrapper').css({
		visibility : 'visible',
		display    : 'initial'
	});

	var locked = lockedResources.length

    $('#results-count').html(Object.keys(informationMap).length - locked);
    adjustPage();
}

function adjustPage() {
	var lastPage, skip, temp;

	$('.pageNumber').removeClass('currentPage');
	$('.pageNumber').removeClass('selected');
	lastPage = Math.ceil(Object.keys(informationMap).length / numberPerPage);

	temp = fillArray(currentPage, lastPage);
	pagination(temp, currentPage, lastPage);

	$('#lastPage').html(lastPage);

	render({
		results: results_to_display
	});

	select_selected();
	setIndicators();
	calculateMargins();

	$('.resource-thumb').each(function(){
	    var atag = $(this).children().eq(0);
	    var darkBackground = $(atag).children().eq(0);
	    if ($(this).find('.resourceLockedDarkBackgroundSearch').length > 0) {
	      $(this).find('.circle-container').hide();
	    }
	    var resourcePicture = $(atag).children().eq(2);
	    $(resourcePicture).load(function(){ //wait for each picture to finish loading
	        var pictureWidth = resourcePicture[0].getBoundingClientRect().width;
	        darkBackground.width(pictureWidth); //background same as picture width
	        darkBackground.css('left',0); //recenter the darkbackground
	        darkBackground.css('right',0);
	        darkBackground.css('margin',"auto");
	    });
	});
}

function sortBy(key, a, b, r) {
	if (a[key] > b[key]) {
		return -1 * r;
	}
	if (a[key] < b[key]) {
		return +1 * r;
	}
	return 0;
};


function pagination(pageArray, currentPage, lastPage) {
  var i, j, results1;
  if (indexOf.call(pageArray, 1) >= 0) {
    $('#firstPage').css('display', 'none');
    $('.fDots').css('display', 'none');
  } else {
    $('#firstPage').css('display', 'block');
    $('.fDots').css('display', 'block');
  }
  if (1 === currentPage) {
    $('#rightArrow').css('display', 'none');
  } else {
    $('#rightArrow').css('display', 'block');
  }
  if (indexOf.call(pageArray, lastPage) >= 0) {
    $('#lastPage').css('display', 'none');
    $('.dots').css('display', 'none');
    $('#leftArrow').css('display', 'none');
  } else {
    $('#lastPage').css('display', 'block');
    $('.dots').css('display', 'block');
    $('#leftArrow').css('display', 'block');
  }
  if (currentPage === lastPage) {
    $('#lefttArrow').css('display', 'none');
  } else {
    $('#leftArrow').css('display', 'block');
  }
  if (2 === pageArray[0]) {
    $('.fDots').css('display', 'none');
  }
  if (lastPage - 1 === pageArray[4]) {
    $('.dots').css('display', 'none');
  }
  results1 = [];
  for (i = j = 1; j <= 5; i = ++j) {
    if (pageArray[i - 1] <= 0) {
      results1.push($('#' + i).css('display', 'none'));
    } else {
      $('#' + i).css('display', 'block');
      $('#' + i).html(pageArray[i - 1]);
      if (parseInt($('#' + i).html()) === currentPage) {
        $('#' + i).addClass('selected');
        results1.push($('#' + i).addClass('currentPage'));
      } else {
        results1.push(void 0);
      }
    }
  }
  return results1;
};

function fillArray(page, lastPage) {
  var i, results1;
  if (page < 3) {
    page = 3;
  }
  if (page === lastPage) {
    page = page - 2;
  }
  if (page === lastPage - 1) {
    page = page - 1;
  }
  i = -1;
  results1 = [];
  while (i < 4) {
    i++;
    if ((page + (i - 2)) <= lastPage) {
      results1.push(page + (i - 2));
    } else {
      results1.push(0);
    }
  }
  return results1;
};

setIndicators = function(){
  var associator = {
    hasFlags:".icon-flag",
    hasAnnotations:".search-icon-edit",
    hasCollections:".icon-in-collection",
    hasComments:".icon-discussed",
    hasKeywords:".icon-tagged"
  }
  for(var resource in indicators){
    var foundResouce = $('*[data-id=\"'+resource+'\"]');
    if(foundResouce.length){
      for(var prop in associator){
        var element = associator[prop]
        var indicator = foundResouce.find(element)
        var display = indicators[resource][prop]? "":"none";
        indicator.css({display:display})
      }
    }
  }
}

//select the selected resources when a new page loads
function select_selected(){
	$(".resource-thumb").each(function(){
	  if(selectedMap['selected'].includes($(this).attr("data-id"))){
		  $(this).find(".results").one("load", function() {
			  w = $(this).css('width')
			  var previous = $(this).prev()
			  $(previous).css('background','rgba(0, 147, 190, 0.75)');
			  $(previous).css("opacity", "1");
			  $(previous).css("width", w);
			  $(previous).find(".select-circle").addClass("selected");
			  $(previous).find(".circle-container").css("background", "transparent");
		  })

	  }
	})
}

// remove the selected css from all displayed resources
function unselectAllDisplay() {
	Object.keys(results_to_display).forEach(function(kid) {
		  var li = $('li[data-id="'+kid+'"]');
		  if (li.length) {
			li.find(".circle-container").css('background', '')
			li.find('.select-circle').removeClass('selected');
			li.find('.select-overlay').css('opacity', '')
			li.find('.select-overlay').css('background', '')
			li.find('#delect-all').attr({
			  id: 'select-all'
			});
		  }

	});
}

//make all of the displayed resources have the selected css
function selectAllDisplay() {
	this.$(".select-overlay").each(function(){
	w = Math.ceil($(this)[0].nextElementSibling.offsetWidth)
	$(this).css('width', w)
	})

	Object.keys(results_to_display).forEach(function(kid) {
			var li = $('li[data-id="'+kid+'"]');
			if (li.length) {
			  li.find(".circle-container").css('background', 'transparent')
			  li.find('.select-circle').addClass('selected');
			  li.find('.select-overlay').css('opacity', 1)
			  li.find('.select-overlay').css('background', 'rgba(0, 147, 190, 0.75)')
			  li.find('#select-all').attr({
				id: 'deselect-all'
			  });
			}
	});
};


function render(results, append) {
	var $results, filterResults, getCnt;
	if (append == null) {
	append = false;
	}


	$results = $('.flex-container');

	if (template === 'search/grid'){
		$(".flex-container").removeClass("detailed-list");
		$(".flex-container").addClass("grid-list");
	}
	else{
		$(".flex-container").removeClass("grid-list");
		$(".flex-container").addClass("detailed-list");
	}
  	results = results.results;
  	if(results.length && results[0].Orphan == 'TRUE' ){
    	$('.toolbar-fixed').css('display', 'none');
    }

	$results[append ? 'append' : 'html'](arcs.tmpl(template, {
		results: results
	}));

	$(".pageNumber").unbind().click(function(e) {
		if ($(this).hasClass('selected')) {
			e.stopPropagation();
		} else {
			$('.pageNumber').removeClass('selected');
			$('.pageNumber').removeClass('currentPage');
			$(this).addClass('selected');
			$(this).addClass('currentPage');
			currentPage = parseInt($('.currentPage').html());
			changeDisplay();
		}
	});
	$('#leftArrowBox').unbind().click(function(e) {
		var temp;
		temp = $('.currentPage').html();
		$('.currentPage').html(parseInt(temp) + 1);
		currentPage += 1;
		changeDisplay();
	});
	$('#rightArrowBox').unbind().click(function(e) {
		var temp;
		temp = $('.currentPage').html();
		if (temp === '1') {

		} else {
			$('.currentPage').html(parseInt(temp) - 1);
			currentPage -= 1;
			changeDisplay();
		}
	});
	$('#dots').unbind().click(function() {
		var temp;
		temp = parseInt($('.currentPage').html()) + 5;
		if (temp > parseInt($("#lastPage").html())) {
			temp = parseInt($("#lastPage").html());
		}
		$('.currentPage').html(temp);
		currentPage = temp;
		changeDisplay();
	});
	$('#fDots').unbind().click(function() {
		var temp;
		temp = parseInt($('.currentPage').html()) - 5;
		if (temp < 1) {
			temp = 1;
		}
		$('.currentPage').html(temp);
		currentPage = temp;
		changeDisplay();
	});
	$('.resource-thumb').hover((function() {
		$(this).find('.select-overlay').addClass('select-hover');
		w = $(this).find(".results").css('width')
		$(this).find(".select-overlay").css("width", w);
	}), function() {
		$(this).find('.select-overlay').removeClass('select-hover');
	});
	$('.select-overlay').hover(function(){
		if ($(this).find(".select-circle").hasClass("selected")){
			$(this).css( 'cursor', '' );
		}
		else{
			$(this).css( 'cursor', 'pointer' );
		}
	});
	$('.select-overlay').click(function (e) {
		if ($(this).parent().find('.resourceLockedDarkBackgroundSearch').length == 0) {
			e.stopPropagation();
		}
		if ($(this).find(".select-circle").hasClass("selected")){
			return;
		}
		else{
			var href = $(this).parent().parent().find(".result_a").attr('href')
			if(href !== undefined )
			window.location.href = href;
		}
	});

//clicked on a individual resource, either select or unselect
	$('.select-circle').click(function(e) {
		e.stopPropagation();
		var makeSelect = false;
		if($(this).hasClass("selected")){
			$(this).removeClass('selected')
			$(this).closest(".circle-container").css('background', '')
			$(this).closest('.select-overlay').css('background', '')
			$(this).closest('.select-overlay').css('opacity', '')
			makeSelect = false;
		}
		else{
			$(this).addClass('selected')
			$(this).closest(".circle-container").css('background', 'transparent')
			$(this).closest('.select-overlay').css('opacity', 1)
			$(this).closest('.select-overlay').css('background', 'rgba(0, 147, 190, 0.75)')
			makeSelect = true;
		}
		var data_id = $(this).closest(".resource-thumb")
		data_id = data_id[0]
		data_id = data_id.getAttribute('data-id');
		if (makeSelect){ //selecting the clicked resource
			selectedMap['selected'].push(data_id)
		}else{ //deselecting the resource
			var index = selectedMap['selected'].indexOf(data_id)
			selectedMap['selected'].splice(index,1)
		}
		//update the add to collections button informations
		//collectionPrep();
		$("#selected-resource-ids").html(JSON.stringify(selectedMap['selected']))
		$('#selected-count').html(selectedMap['selected'].length)
		if( selectedMap['selected'].length == 0 ){ //not clickable
			$('#selected-all, #open-colview-btn').css({
			color: '#C1C1C1'
		});
		} else { //clickable
			$('#selected-all, #open-colview-btn').css({
				color: 'black'
			});
		}
	});

	$('.perpage-btn').unbind().click(function() {
		numberPerPage = parseInt($(this).html().substring(0, 2));
		$('#items-per-page-btn').html($(this).html() + "<span class='pointerDown sort-arrow pointerSearch'></span>");
		$('.pageNumber').removeClass('selected');
		$('.pageNumber').removeClass('currentPage');
		$("#1").addClass('selected');
		$("#1").addClass('currentPage');
		$("#1").html(1);
		changeDisplay();
		// return adjustPage(parseInt($('.currentPage').html()));
	});

	$('#select-all, #deselect-all').unbind().click(function() {
		var i;
		if (this.id === 'select-all') {
			$('#selected-all, #open-colview-btn').css({
			color: 'black'
			});
			selectedMap['selected'] = [];

			//get all unlocked resources
			for (kid in informationMap) {
				if(!lockedResources.includes(kid)) {
					selectedMap['selected'].push(kid);
				}
			}

			// arcs.searchView.selectAll();
			selectAllDisplay();
			$('#toggle-select').html('DE-SELECT');
			this.id = "deselect-all";
			$('#selected-resource-ids').html(JSON.stringify(selectedMap["selected"]));
			return $('#selected-count').html(selectedMap["selected"].length);
		} else {
			$('#selected-all, #open-colview-btn').css({
				color: '#C1C1C1'
			});
			selectedMap['selected'] = [];
			this.id = 'select-all';
			unselectAllDisplay();
			$('#toggle-select').html('SELECT');
			$('#selected-resource-ids').html(JSON.stringify(selectedMap["selected"]));
			return $('#selected-count').html(selectedMap["selected"].length);
		}
	});

    getCnt = function() {
        var cnt, key, val;
        cnt = 0;
        for (key in filtersApplied) {
            val = filtersApplied[key];
            if (val) {
                cnt++;
            }
        }
        return cnt;
    };

  filterResults = function() {
    var count, creator, excavationType, key, seasonName, sites, type, val;
    totalResults = [];

    sites = filtersApplied['Excavation Name'];
    seasonName = filtersApplied['Season Name'];
    type = filtersApplied['Type'];
    excavationType = filtersApplied['Excavation Type'];
    creator = filtersApplied['Creator'];
    count = 0;
    for (key in unfilteredResults) {
      val = unfilteredResults[key];

	 if (val.hasOwnProperty('Locked') === true) {
		 continue;
	}

      if (sites !== '') {
        if (val['project'] !== sites) {
          continue;
        }
      }
      if (seasonName !== '') {
        if (val['Season Name'] !== seasonName) {
          continue;
        }
      }
      if (type !== '') {
        if (val['Type'] !== type) {
          continue;
        }
      }
      if (excavationType !== '') {
        if (val['Excavation Name'] !== excavationType) {
          continue;
        }
      }

      if (creator !== '') {
        if (indexOf.call(val['Creator'], creator) < 0) {
          continue;
        }
      }
      totalResults.push(val);
      if (val.hasOwnProperty('Locked') === false) {
        count++;
      }

    }
    $('#results-count').html(count);//only represents unlocked results
    adjustPage(1);
  };
  $('.filter').unbind().on("click", function() {
    var currentFilter, filterCnt, filterKey, parentUl;
    if ($(this).hasClass('active')) {

    } else {
      parentUl = $(this).parent().parent();
      filterKey = parentUl.data('id');
      currentFilter = $(this).html();
      if (currentFilter === 'all') {
        currentFilter = '';
      }
      parentUl.find($('.active')).removeClass('active');
      $(this).addClass('active');
      filtersApplied[filterKey] = currentFilter;
      setVisualFilter(filtersApplied)
      filterCnt = getCnt();
      if (filterCnt) {
        filterResults();
      } else {
        totalResults = unfilteredResults;

		var locked = lockedResources.length;

        //#results-count only represents unlocked results
        $('#results-count').html(Object.keys(informationMap).length - locked);
        adjustPage(1);
      }
    }
  });
  $('.dir-btn').unbind().click(function() {
    var id;
    if ($(this).hasClass('active')) {

    } else {
      $('.dir-btn').removeClass('active');
      $(this).addClass('active');
      id = $(this).attr('id');
      if (id === 'dir-asc-btn') {
        sortDirection = false;
      } else {
        sortDirection = true;
      }
      return adjustPage(1);
    }
  });
  $('.mobile-filter-opt').unbind().click(function () {
        if ($('.tool-bar-results').css("display") == "none"){
            $('.tool-bar-results').css("display",'block')
        }
        else{
            $('.tool-bar-results').css("display",'none')
        }
    });
    $( window ).resize(function() {
        if($( window ).width() > 960){
            $('.tool-bar-results').css("display",'block');
            calculateMargins();
        }
        else{
            if ($(".hiddenProject")[0]){
                $(".tool-bar-results").css("height" ,"240px");
            } else {
                $(".tool-bar-results").css("height" ,"300px");
            }

            if(template === "search/list"){
                $( "#grid-btn" ).trigger( "click" );
                $(".flex-container").removeClass("detailed-list");
                $(".flex-container").addClass("grid-list");
            }

            calculateMargins();
        }
    });

	$('.sorter').unbind().click(function() {
		var id;
		if ($(this).hasClass('active')) {

		} else {
			$('.sorter').removeClass('active');
			$(this).addClass('active');
			if ($(this).attr("id") === "sort-title-btn"){
				titleOrTime = false;
			}
		else{
			titleOrTime = true;
		}
			return adjustPage(1);
		}
	});

	if (results.length === 0) {
		return $results.html("<div id='no-results'>No Results</div>");
	}
};


function calculateMargins() {
    var w = Math.floor($('div#search-results').width());
    var resourceWidth;
    if ($(window).width() < 960){
      //only 2 wide in mobile
        resourceWidth = 228;
        var newMargin =Math.floor((w-resourceWidth)/4);
        $(".resource-thumb").css("margin", "10px " + newMargin + "px")
    }
    else{
        resourceWidth = 180;
        var numOfRes = Math.floor(w/resourceWidth);
        var newMargin = Math.floor((w-(resourceWidth*numOfRes))/(numOfRes*2)) + 15;
        $(".resource-thumb").css("margin", "15px " + (newMargin) + "px");
    }
}

}
