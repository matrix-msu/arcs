var rows, rowsOriginal;
var onPage = 0;

$(document).ready( function() {
    updateRows();
	if($('#users')[0]) {
		rowsOriginal = rows
	} else {
		rowsOriginal = rows
	}
	setUpPagination(25); //initial setup, 25 per page

	$('.admin-header-users .allUsers').on('click', function() {
		rows = $('.all-users .admin-row');
		setUpPagination(25);
	});
	$('.admin-header-users .pending').on('click', function() {
		rows = $('.pending-users .admin-row');
		setUpPagination(25);
	});

    /*
    ippDisplay();
    $(window).on('resize', function() {
        ippDisplay();
    })*/

    $(document).on('click', function(e){
        if ($('.admin-pagination .ipp *').is(e.target)){    //change number per page
            $ipp = $('.admin-pagination .ipp');
            if ($($ipp).hasClass('open')) {
                if($($ipp).find('.menu p').is(e.target)) {
                    $('.curr').removeClass('curr');
                    $text = $(e.target).text();
                    $num = $text.split(" ")[0];
                    $(e.target).addClass('curr');
                    $($ipp).find('.drop p').text($text);
                    setUpPagination($num);
                }
                $($ipp).removeClass('open');
            } else {
                $($ipp).addClass('open');
            }
        } else if ($('.page-pick *').is(e.target)){          //cycle page number
            var $navs = $('.by-num p');

            if ($('p').is(e.target)) {
                var text = $(e.target).text();
                if (text == '...') {
                    return;
                }
                if (text == '1'){
                    $p = 0;
                } else if (text == $numPages) {
                    $p = $numPages + 1;
                    if ($numPages < 6) {
                        $p = $numPages - 1;
                    }
                } else {
                    $p = parseInt(text);
                    if ($numPages < 6) {
                        $p -= 1;
                    }
                }
            } else if ($(e.target).hasClass('left')) {
                if ($numPages > 6 ){
                    $p = onPage;
                } else {
                    $p = onPage - 1;
                }
                if ($p < 0){
                    $p = $numPages-1;
                }

                if ($($navs[$p]).hasClass('fdots') || $($navs[$p]).hasClass('dots')){
                    $p -= 1;
                }

            } else if ($(e.target).hasClass('right')) {
                if ($numPages > 6) {
                    onPage += 1;
                }
                $p = onPage + 1;

                if ($($navs[$p]).hasClass('fdots') || $($navs[$p]).hasClass('dots')){
                    $p += 1;
                }
            }
            showPagination($p);
        } else if ($('.admin-pagination .open')[0]) {       //close per page menu on off click
            $('.open').removeClass('open');
        }
    });

});

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                                                                             *
 *  Pagination                                                                                 *
 *                                                                                             *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

//Calculate number of pages needed
//where $n is number per page, or "DISPLAY" to show all
function setUpPagination ($numPerPage) {
    if($numPerPage == "DISPLAY") {
        $perPage = rows.length;
        $numPages = 1;
    } else {
	   $perPage = $numPerPage;
	   $numPages = Math.ceil(rows.length / $perPage);
    }
    setPageNumbers($numPages);
	showPagination(0);
}

//Create page cycle numbers
function setPageNumbers($numPages) {
    $('.by-num').empty();
	$s = ""

    if ($numPages > 6){
        for($i=0; $i<5; $i++) {
            if ($i == 0){
                $s += "<p id='firstPage'>"+($i+1)+"</p>";
                $s += "<p class='fdots'>...</p>";
            } else {
                $s += "<p>"+($i+1)+"</p>";
            }
        }
        for($i=5; $i<$numPages - 1; $i++) {
            $s += "<p>"+($i+1)+"</p>";
        }
        $s += "<p class='dots'>...</p>";
        $s += "<p id='lastPage'>"+$numPages+"</p>";
    } else {
        for($i=0; $i<$numPages; $i++) {
            $s += "<p>"+($i+1)+"</p>";
        }
    }
	$('.by-num').append($s);
}

//Display the current page
function showPagination($on) {
    if (isNaN($on)) {
        return;
    }
    var $navs = $('.by-num p');

    onPage = $on;

    if ($numPages > 6) {
        if (onPage != 0) {
            onPage -= 1;
        }
        if (onPage >= $numPages) {
            onPage = $numPages - 1;
        }
    }

    $(rows).attr('style', 'display: none;');
    $navs.removeClass('active');
    $($navs[$on]).addClass('active');
    $base = onPage * $perPage;
    for ($i = 0; $i < $perPage; $i++) {
        $(rows[$base + $i]).attr('style', 'display: block;');
    }

    // dont show arrows on the edges
    if ($on == 0) {
        $('div.left').css('display', 'none');
    } else {
        $('div.left').css('display', 'block');
    }

    if ($on == $numPages + 1 || ($numPages < 6 && $on == $numPages - 1)) {
        $('div.right').css('display', 'none');
    } else {
        $('div.right').css('display', 'block');
    }

    $('.fdots').css('display', 'none');
    $('.dots').css('display', 'none');


    if ($numPages >= 6) {
        // page numbers to hide
        var upperRange = [];
        var lowerRange = [];

        if (onPage >= 4) {
            $('.fdots').css('display', 'inline-block');
        } else {
            $('.fdots').css('display', 'none');
        }

        if (onPage >= 3) {
            for (var i = onPage + 3; i < $numPages; i++) {
                upperRange.push(i);
            }
        } else {
            for (var i = 5; i < $numPages; i++) {
                upperRange.push(i)
            }
        }

        if ($numPages - onPage >= 4){
            $('.dots').css('display', 'inline-block');
            for (var i = onPage - 3; i > 0; i--) {
                lowerRange.push(i);
            }
        } else {
            $('.dots').css('display', 'none');

            for (var i = onPage - 3; i > 0; i--) {
                lowerRange.push(i);
            }
        }

        // hide page numbers based on the upper and lower ranges
        var pageCnt = 0;
        $navs.each(function (i, tag) {
            if ($(tag).hasClass('fdots') || $(tag).hasClass('dots')) {
                return;
            } else if ($(tag).is('#firstPage') || $(tag).is('#lastPage')){
                pageCnt++;
            } else {
                if (upperRange.includes(pageCnt) || lowerRange.includes(pageCnt)){
                    $(tag).css('display', 'none');
                } else {
                    $(tag).css('display', 'inline-block');
                }
                pageCnt++;
            }
        });

        $('#firstPage').css('display', 'inline-block');
        $('#lastPage').css('display', 'inline-block');
    }

}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                                                                             *
 *  Sort                                                                                       *
 *                                                                                             *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

//flip current selection
function reverseRows() {
	$('.admin-rows-content').append($('.admin-rows-content').children('.admin-row').get().reverse());
	updateRows();
	setUpPagination(25);
}

//reset to chronilogical order
function sortByDate() {
	$('.admin-rows-content').append(rowsOriginal);
	updateRows();
	setUpPagination(25);
}

//sorts rows increasing by html of dom child specified by cat(ex.'p.username')
function sortBy(cat) {
    if($('.all-users')[0]) {
        $('.admin-rows-content.all-users').append(mergeSort(rows,cat));
        rows = $('.all-users .admin-row');
    } else if ($('.pending-users')[0]) {
        $('.admin-rows-content.pending-users').append(mergeSort(rows,cat));
        rows = $('.pending-users .admin-row');
    } else {
		$('.admin-rows-content').append(mergeSort(rows,cat));
		rows = $('.admin-row');
	}

    if($(cat).hasClass('reversed')){
        $(cat).removeClass('reversed');
    }else {
        $(cat).addClass('reversed');
        rows = $.makeArray($(rows));
        rows = rows.reverse();
        //delete all
        $('.all-users').empty();
        //use reverse array to rebuild and add elements
        $('.all-users').append(rows)
    }
	setUpPagination(25);
}

function mergeSort (arr, cat) {
    if (arr.length < 2) return arr;

    var mid = Math.floor(arr.length /2);
    var subLeft = mergeSort(arr.slice(0,mid),cat);
    var subRight = mergeSort(arr.slice(mid),cat);

    return merge(subLeft, subRight, cat);
}

function merge (a,b,cat) {
    var result = [];
    while (a.length >0 && b.length >0) {
		if ($(a[0]).find(cat).html().toLowerCase() <$(b[0]).find(cat).html().toLowerCase()) {
			result.push(a[0]);
			a = a.slice(1);
		} else {
			result.push(b[0]);
			b = b.slice(1);
		}
	}
    return result.concat(a.length? a : b);
}


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                                                                             *
 *  Filter                                                                                     *
 *                                                                                             *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

//Show only rows where the text at cat(ex. 'p.username') matches key
//Resets any sort or search
function filterBy(key, cat) {
    if(key == ''){
        $('.admin-rows-content').append(rowsOriginal);
    } else {
        $('.admin-rows-content').empty();
        for(var i = 0; i < rowsOriginal.size(); i++) {
            if($(rowsOriginal[i]).find(cat).html().toLowerCase() == key.toLowerCase()) {
                $('.admin-rows-content').append(rowsOriginal[i]);
            }
        }
    }

    updateRows();
    setUpPagination(25);

    $('.admin-pagination .ipp .menu .curr').removeClass('curr');
    $('#twenty-five-per-page').addClass('curr');
    $('.admin-pagination .ipp .drop .per').text( '25 ITEMS PER PAGE' );
}

//Remove rows where text at cat matches key
function filterOut(key, cat) {
    updateRows();

    if(key == ''){
        $('.admin-rows-content').append(rowsOriginal);
    } else {
        $('.admin-rows-content').empty();
        for(var i = 0; i < rows.size(); i++) {
            if($(rows[i]).find(cat).html().toLowerCase() != key.toLowerCase()) {
                $('.admin-rows-content').append(rows[i]);
            }
        }
    }

    updateRows();

    setUpPagination(25);

    $('.admin-pagination .ipp .menu .curr').removeClass('curr');
    $('#twenty-five-per-page').addClass('curr');
    $('.admin-pagination .ipp .drop .per').text( '25 ITEMS PER PAGE' );
}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                                                                             *
 *  Search                                                                                     *
 *                                                                                             *
 *	From unsorted, unfiltered admin rows, find ones where dom child cat(ex. 'p.username')      *
 *  contains substring key                                                                     *
 *                                                                                             *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

function search(key, cat) {
    var result = []

    if(key != "") {
        key = key.toLowerCase();

        //if($('#users')[0]) {
        //    var currentRows = $('.admin-rows-content.all-users').children();
        //} else {
        //    var currentRows = $('.admin-rows-content').children();
        //}

        for($i = 0; $i < rowsOriginal.length; $i++) {
            if($(rowsOriginal[$i]).find(cat)['context'].innerText.toLowerCase().indexOf(key) < 0){

            } else {
                result.push(rowsOriginal[$i]);
            }
        }
    } else {
        result = rowsOriginal;
    }


	if($('#users')[0]) {
        $('.admin-rows-content.all-users').empty();
        $('.admin-rows-content.all-users').prepend(result);
		rows = $('.all-users .admin-row');
	} else {
        $('.admin-rows-content').empty();
        $('.admin-rows-content').prepend(result);
		rows = $('.admin-row');
	}
	setUpPagination(25);
}

//
//
//

function updateRows() {
    if($('#users')[0]) {
		rows = $('.all-users .admin-row');
	} else {
		rows = $('.admin-row');
	}
}
