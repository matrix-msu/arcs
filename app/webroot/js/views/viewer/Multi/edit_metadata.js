function editMetaPrep() {
    console.log('edit meta prep')
    //todo - make associators do the update without reloading thing.

    //data sent to arcs kora plugin---
    var metadataIsSelected = 0;     //0 or 1 to know if there is one selected
    var editBtnClick = 0;           //0 or 1
    var meta_field_name = '';
    var meta_control_type = '';
    var meta_options = '';
    var meta_value_before = '';
    var meta_new_value = '';
    var meta_scheme_name = '';
    var meta_resource_kid = '';
    var resource_kid = '';
    var resource_name = '';

    var associator_full_array = new Array();  //all the records of a scheme are kept here
    var associator_current_showing = new Array(); //the records for a certain search are kept here
    var associator_selected = new Array(); //all currently selected associations are kept here

    //the main submission function for when
    function addMetadataEdits() {
        $('#meta_textarea').addClass('meta_ajaxwait').removeAttr('id');
        $.ajax({
            url: arcs.baseURL + "metadataedits/add",
            type: "post",
            data: {
                resource_kid: resource_kid,
                resource_name: resource_name,
                scheme_id: meta_scheme_name,
                control_type: meta_control_type,
                field_name: meta_field_name,
                user_id: "user_not_set",   //this is set in the controller
                value_before: meta_value_before,
                new_value: meta_new_value,
                approved: 0,
                rejected: 0,
                reason_rejected: "",
                metadata_kid: meta_resource_kid
            },
            success: function (data) {
                var fill = '<td>' +
                        '<div class="icon-meta-lock">&nbsp;</div>' +
                        '<div>Pending Approval</div>' +
                    '</td>';
                $(".meta_ajaxwait").parent().parent().replaceWith(fill);
                metadataIsSelected = 0;
                editBtnClick = 0;
            }
        })
    }

    //a field to edit was clicked, so load in the correct type of editor and prepare current data for later
    $(".metadataEdit").click(function () {
        $(this).each(
            function () {
                // if the td elements contain any input tag
                if ($(this).find('textarea').length || $(this).find('select').length || editBtnClick == 0) {
                    // do nothing.
                } else {
                    //if there was already something being edited...reset that field
                    if (metadataIsSelected == 1) {
                        var id = $("#meta_textarea").parent().children("div").eq(0).text();
                        var text = $("#meta_textarea").text();
                        if (meta_options == '' || meta_options == undefined) {
                            if (meta_value_before != '' && (meta_control_type == 'multi_input' || meta_control_type == 'multi_select' )) {
                                meta_value_before = meta_value_before.replace(/\n+/g, '<br />');
                            }
                            var fill = '<div id="' + meta_field_name + '" data-control="' + meta_control_type + '">' + meta_value_before + "</div>";
                        } else {
                            meta_options = meta_options.replace(/["]+/g, '&quot;');
                            if (meta_value_before != '' && (meta_control_type == 'multi_input' || meta_control_type == 'multi_select' )) {
                                meta_value_before = meta_value_before.replace(/\n+/g, '<br />');
                            }
                            var fill = '<div id="' + meta_field_name + '" data-control="' + meta_control_type + '" data-options="' + meta_options + '">' + meta_value_before + "</div>";
                        }
                        $("#meta_textarea").parent().replaceWith(fill);
                        metadataIsSelected = 0;
                        $('.icon-meta-flag').css('display', 'block'); //add flags back in
                        $(".metadataEdit").css('cursor', 'pointer'); //the last edit metadata box is clickable
                    }
                    // removes the text, appends an input and sets the value to the text-value
                    meta_field_name = $(this).children('div').eq(1).attr('id');
                    meta_control_type = $(this).children('div').eq(1).attr('data-control');
                    meta_options = '';
                    meta_scheme_name = $(this).parent().parent().parent().attr('data-scheme');
                    meta_resource_kid = $(this).parent().parent().parent().attr('data-kid');
                    resource_kid = $('.resource-container-level').find('.selectedResource').prev().attr('id');
                    resource_kid = resource_kid.replace('identifier-', '');
                    resource_name = $('table[data-kid="'+resource_kid+'"]').find("[id='Resource Identifier']").html();
                    var temp_element = $(this).children('div').eq(1).clone();
                    temp_element.find('br').replaceWith('\n');
                    meta_value_before = temp_element.text();

                    //the rest of the box isn't clickable anymore. so default cursor
                    $(this).css('cursor', 'default');

                    //remove the flag metadata button while editing metadata
                    $(this).find('.icon-meta-flag').css('display', 'none');

                    //give different control edits based on the kora control type
                    var html = '';
                    if (meta_control_type == 'text') {
                        html = $('<textarea />', {
                            'value': meta_value_before,
                            'id': 'meta_textarea'
                        }).val(meta_value_before);

                        $('.level-content, .ui-accordion-header, .ui-state-default, .ui-accordion-icons,' +
                            '.ui-accordion-header-active, .ui-state-active, .ui-corner-top, #soo').unbind('keydown');
                        $(this).children('div').eq(1).html(html);
                        
                    } else if (meta_control_type == 'date') {
                        html = '<div class="kora_control" id="meta_textarea">' +
                            '<select class="kcdc_year"  id="year_select">' +
                            '<option value="">&nbsp;</option><option value="1930">1930</option><option value="1931">1931</option><option value="1932">1932</option><option value="1933">1933</option><option value="1934">1934</option><option value="1935">1935</option><option value="1936">1936</option><option value="1937">1937</option><option value="1938">1938</option><option value="1939">1939</option><option value="1940">1940</option><option value="1941">1941</option><option value="1942">1942</option><option value="1943">1943</option><option value="1944">1944</option><option value="1945">1945</option><option value="1946">1946</option><option value="1947">1947</option><option value="1948">1948</option><option value="1949">1949</option><option value="1950">1950</option><option value="1951">1951</option><option value="1952">1952</option><option value="1953">1953</option><option value="1954">1954</option><option value="1955">1955</option><option value="1956">1956</option><option value="1957">1957</option><option value="1958">1958</option><option value="1959">1959</option><option value="1960">1960</option><option value="1961">1961</option><option value="1962">1962</option><option value="1963">1963</option><option value="1964">1964</option><option value="1965">1965</option><option value="1966">1966</option><option value="1967">1967</option><option value="1968">1968</option><option value="1969">1969</option><option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option><option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option>' +
                            '</select>' +
                            '<select class="kcdc_month" id="month_select">' +
                            '<option value="">&nbsp;</option><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option>' +
                            '</select>' +
                            '<select class="kcdc_day" id="day_select">' +
                            '<option value="">&nbsp;</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option>' +
                            '</select>' +
                            '<input type="hidden" class="kcdc_era" id="era" value="CE">' +
                            '<div class="ajaxerror"></div>' +
                            '</div>';
                        $(this).children('div').eq(1).html(html);

                        var month = '';
                        var day = '';
                        var year = '';

                        if (meta_value_before != '') {
                            var valueArray = meta_value_before.split(" ");
                            var dateString = valueArray[0];
                            var dateArray = dateString.split("-");
                            year = dateArray[0];
                            month = dateArray[1];
                            day = dateArray[2];
                            $('#month_select option[value="' + month + '"]').prop('selected', true);
                            $('#day_select option[value="' + day + '"]').prop('selected', true);
                            $('#year_select option[value="' + year + '"]').prop('selected', true);
                        }

                    } else if (meta_control_type == 'terminus') {
                        html = '<div class="kora_control" id="meta_textarea">' +
                            '<select class="kcdc_year" id="year_select"><option value="">&nbsp;</option>';
                        for (var i = 1; i < 10000; i++) {
                            html += '<option value="' + i + '">' + i + '</option>';
                        }
                        html += '</select>' +
                            '<select class="kcdc_month" id="month_select">' +
                            '<option value="">&nbsp;</option><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option>' +
                            '</select>' +
                            '<select class="kcdc_day" id="day_select">' +
                            '<option value="">&nbsp;</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option>' +
                            '</select>' +
                            '<select class="kcdc_era" id="era_select"><option value="" selected="selected">' +
                            '</option><option value="CE">CE</option><option value="BCE">BCE</option>' +
                            '</select><br />Prefix: ' +
                            '<select class="kcdc_prefix"  id="prefix_select">' +
                            '<option></option><option value="ca">ca</option>' +
                            '</select>' +
                            '<div class="ajaxerror"></div>' +
                            '</div>';
                        $(this).children('div').eq(1).html(html);

                        var month = '';
                        var day = '';
                        var year = '';
                        var prefix = '';
                        var era = '';

                        /////change text date to date array----
                        if (meta_value_before != '') {
                            var valueArray = meta_value_before.split(" ");
                            var dateString = '';
                            if (valueArray[0].indexOf('/') == -1) {     // '/' does not exist in array, it is the prefix
                                prefix = valueArray[0];
                                dateString = valueArray[1];
                                if (typeof valueArray[2] !== 'undefined') { //does exist
                                    era = valueArray[2];
                                }

                            } else {      // '/' does exit it is the date
                                dateString = valueArray[0];
                                if (typeof valueArray[1] !== 'undefined') { //does exist
                                    era = valueArray[1];
                                }
                            }
                            var dateArray = dateString.split("-");
                            year = dateArray[0];
                            month = dateArray[1];
                            day = dateArray[2];
                            $('#month_select option[value="' + month + '"]').prop('selected', true);
                            $('#day_select option[value="' + day + '"]').prop('selected', true);
                            $('#year_select option[value="' + year + '"]').prop('selected', true);
                            if (prefix != '') {
                                $('#prefix_select option[value="' + prefix + '"]').prop('selected', true);
                            }
                            if (era != '') {
                                $('#era_select option[value="' + era + '"]').prop('selected', true);
                            }
                        }

                    } else if (meta_control_type == 'multi_input') {
                        html = '<div class="kora_control" id="meta_textarea">' +
                            '<table>' +
                            '<tbody>' +
                            '<tr>' +
                            '<td><input type="text" class="kcmtc_additem" name="Input135" id="Input135" value=""></td>' +
                            '<td><input type="button" class="kcmtc_additem" id="multi_input_add" value="Add"></td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td rowspan="3">' +
                            '<select id="p123c135" class="kcmtc_curritems fullsizemultitext" name="p123c135[]" multiple="multiple" size="5">';
                        if (meta_value_before != '') {
                            var valueArray = meta_value_before.split("\n");
                            valueArray.pop(); //remove the trailing ''
                            valueArray.forEach(function (tempdata) {
                                html += '<option class="multi_input_option" value="' + tempdata + '" selected>' + tempdata + '</option>';
                            });
                        }
                        html += '</select>' +
                            '</td>' +
                            '<td><input type="button" class="kcmtc_removeitem" id="multi_input_remove" value="Remove"></td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td><input type="button" class="kcmtc_moveitemup" id="multi_input_up" value="Up"></td>' +
                            '</tr>' +
                            '<tr>' +
                            '<td><input type="button" class="kcmtc_moveitemdown" id="multi_input_down" value="Down"></td>' +
                            '</tr>' +
                            '</tbody>' +
                            '</table>' +
                            '<div class="ajaxerror"></div>' +
                            '</div>';
                        $(this).children('div').eq(1).html(html);
                        $('#multi_input_add').click(function (e) {
                            var textBar = $('#Input135');
                            var text = textBar.val();
                            html = '<option class="multi_input_option" value="' + text + '" selected>' + text + '</option>';
                            $('#p123c135').append(html);
                            textBar.val('');
                        });
                        $('#multi_input_remove').click(function (e) {
                            var $option = $("#meta_textarea option:selected");
                            if ($option.length == 1) {
                                $option.remove();
                            }
                        });
                        $('#multi_input_up').click(function (e) {
                            var $option = $("#meta_textarea option:selected");
                            if ($option.length == 1 && $option.prev().hasClass('multi_input_option')) {
                                $option.insertBefore($option.prev());
                            }
                        });
                        $('#multi_input_down').click(function (e) {
                            var $option = $("#meta_textarea option:selected");
                            if ($option.length == 1 && $option.next().hasClass('multi_input_option')) {
                                $option.insertAfter($option.next());
                            }
                        });

                    } else if (meta_control_type == 'multi_select') {
                        meta_options = $(this).children('div').eq(1).attr('data-options');
                        html = '<div class="kora_control" id="meta_textarea">' +
                            '<select id="p123c25" class="kcmlc_curritems" name="p123c25[]" multiple="multiple" size="5">' +
                            meta_options +
                            '</select>' +
                            '<div class="ajaxerror"></div>' +
                            '</div>';
                        $(this).children('div').eq(1).html(html);
                        if (meta_value_before != '') {
                            var valueArray = meta_value_before.split("\n");
                            valueArray.pop(); //remove the trailing ''
                            valueArray.forEach(function (tempdata) {
                                $('#meta_textarea option[value="' + tempdata + '"]').prop('selected', true);
                            });
                        }

                    } else if (meta_control_type == 'list') {
                        meta_options = $(this).children('div').eq(1).attr('data-options');
                        html = '<div class="kora_control" id="meta_textarea">' +
                            '<select name="p123c15">' +
                            '<option value="">&nbsp;</option>' +
                            meta_options +
                            '</select></div>';
                        $(this).children('div').eq(1).html(html);
                        if (meta_value_before != '') {
                            $('#meta_textarea option[value="' + meta_value_before + '"]').prop('selected', true);
                        }
                    } else if (meta_control_type == 'associator') {
                        meta_value_before = $(this).children('div').eq(1).attr('data-associations');
                        meta_value_before = meta_value_before.split(' ').join('\n');
                        $(this).children('div').eq(1).append('<div id="meta_textarea"></div>');
                        $('#associatorTitle').html('Edit ' + meta_field_name + ' Metadata');
                        $('.associatorModalBackground').show();
                        $('.associator_numbers').html(''); //clear out the pagination numbers
                        $('.associator_begin').css('visibility', 'hidden');
                        $('.associator_prev').css('visibility', 'hidden');
                        $('.associator_next').css('visibility', 'hidden');
                        $('.associator_end').css('visibility', 'hidden');
                        //add the preloader
                        var loaderHtml = $(ARCS_LOADER_HTML);
                        $(loaderHtml).css({'margin-top':'5px'});
                        $(loaderHtml).find('.sk-cube').addClass('sk-cube-white');
                        $('#associatorSearchObjects').append(loaderHtml);

                        $.ajax({
                            url: arcs.baseURL + "metadataedits/getAllKidsByScheme",
                            type: "POST",
                            data: {
                                scheme_name: meta_field_name,
                                meta_kid: meta_resource_kid
                            },
                            success: function (data) {
                                associator_full_array = JSON.parse(data);
								associator_current_showing = associator_full_array;

								//add the current associators to the selected array
								if (meta_value_before != '') {
									var valueArray = meta_value_before.split("\n");
									valueArray.pop(); //remove the trailing ''
									associator_selected = valueArray;
								}
                                //add pagination numbers based on 10 items / page
                                populateNumbers(Math.ceil( associator_current_showing.length/10 ));
                            }
                        });

                    }
                    metadataIsSelected = 1;
                }
            })
    });

    //edit associator modal .. go to the confirmation modal
    $('#associatorSearchSubmitFirst').on('click', function (evt) {
        $('#associatorSelectModal').css('display', 'none');
        $('#associatorSubmitConfirm').css('display', 'block');
        //fill in the edit associator confirm modal
        var text = '';
        associator_selected.forEach(function (tempdata) {
            text += tempdata + "<br />";
        });
        $('#associatorsToSubmit').html(text);
    });

    //from the edit associator confirmation modal. actually submit the new associators.
    $('#associatorSearchSubmitConfirm').on('click', function (evt) {
        meta_new_value = '';
        for(var i=0; i<associator_selected.length; i++){
            meta_new_value += associator_selected[i];
            if( i != associator_selected.length-1 ){
                meta_new_value += "\n";
            }
        }
        $(".metadata-save-btn").removeClass("metadata-save-btn") //change back to edit button
            .text("EDIT")
            .addClass("metadata-edit-btn")
            .css("color", '');
        addMetadataEdits();
        $('#closeAssociatorConfirm').click();
    });

    //closing the edit associator confirm modal
    $('#closeAssociatorConfirm').click(function() {
        $('.associatorModalBackground').css('display', 'none');
        $('#associatorSelectModal').css('display', 'block');
        $('#modalCloseAssociatorSelect').click();
    });

	//clicked on one of the kids in the associator search box.
    $('#associatorSearchObjects').on('click', 'label', function (evt) {
        var sel = getSelection().toString(); //grab any highlighted text on the page
        if(!sel){ //it was a true click, not highlighting text. So, add or remove the selection.
            var checkBoxId = '#'+$(this).attr('for');
            var checkBox = $(checkBoxId);
            var checkBoxKid = $(checkBox).attr('value');
            if( $(checkBox).is(':checked') ){ //was already checked so remove from selected array
                var index = associator_selected.indexOf(checkBoxKid);
                if (index > -1) {
                    associator_selected.splice(index, 1);
                }
            }else{ 							//add to the selected array
                associator_selected.push(checkBoxKid);
            }
        }else{ //this wasn't a click, it was just highlighting text so dont do anything.
            return false;
        }

    });
    $('#modalCloseAssociatorSelect').click(function () {
        $('#meta_textarea').remove();
        metadataIsSelected = 0;
		$('#associatorSearchObjects').html('');
		$(".associatorModalBackground").hide();
        $('.icon-meta-flag').css('display', 'block'); //add flags back in
        $(".metadataEdit").css('cursor', 'pointer'); //the last edit metadata box is clickable
    });

    //load in associator checkboxes based on the current page number
    function populateAssociatorCheckboxes(currentPage) {
        var associatorPreview = {
            'excavations' : 'Title',
            'archival objects' : 'Name',
            'subjects' : 'Resource Identifier'//go ask kora for this pls
        };
        var populateCheckboxes = "<hr>";
        currentPage = currentPage-1; //pages start at 1, but array index starts at 0
        var startIndex = currentPage*10; //10 items per page
        for (var key=startIndex; key<startIndex+10 && key <associator_current_showing.length; key++) {
            var obj = associator_current_showing[key];
            var kid = '';
            var text = '';
            var preview = obj[associatorPreview[meta_scheme_name]];
            for (var field in obj) {
                if(
                  obj.hasOwnProperty(field) && field != 'pid' && field != 'schemeID'
                  && field != 'linkers' && field != associatorPreview[meta_scheme_name]
                ){
                    if (field == 'kid') {
                        kid = obj[field];
                    } else if (field == 'Image Upload') {
                        text += "<span class='metadata_associator'>"
                        + 'Original Name: ' + obj[field]['originalName']
                        + "</span><br />";
                    } else {
                        text += "<span class='metadata_associator'>"
                        + field + ': ' + obj[field]
                        + "</span><br />";
                    }

                }
            }

            populateCheckboxes += "<input type='checkbox' class='checkedboxes' name='associator-item-"
                + key + "' id='associator-item-" + key + "' value='" + kid + "' />"
                + "<label for='associator-item-" + key + "'><div style='float:left; width:111px;'>"
                + preview + " </div><div style='float:left; width:200px;'>"
                + "<span class='metadata_associator'>" + 'KID: ' + kid + "</span>" + "<br />"
                + text + "</div></label><br />";

        }
        $("#associatorSearchObjects").scrollTop(0); //scroll back to top of the checkboxes on page change.
        $('#associatorSearchObjects').html(populateCheckboxes); //new page of content

		associator_selected.forEach(function (tempdata) {  //check checkboxes that have already been selected
			$('#associatorSearchObjects input[value="' + tempdata + '"]').prop("checked", 'checked');
		});
    }

	//edit associator modal - search bar submit
	$('#associatorSearchInput').keypress(function (e) {
		if (e.which == 13) { //enter button
			var query = $(".associatorSearchBar").val();
			if (query == '') {
				associator_current_showing = associator_full_array;
			}else{
			    associator_current_showing = [];
				for (var i = 0; i < associator_full_array.length; i++) {
					var obj = associator_full_array[i];
					if (obj.hasOwnProperty('kid') && obj.kid == query) {
                        associator_current_showing.push(obj);
					}
				}
			}
      if (associator_current_showing.length == 0) {//no results
          $('#associatorSearchObjects').html('');
      }

			//add pagination numbers based on 10 items / page
			populateNumbers(Math.ceil( associator_current_showing.length/10 ));
		}
	});

    //an edit button was clicked so change it to a save button
    $(document).on("click", ".metadata-edit-btn", function () {
        $('.metadataEdit').css('cursor', 'default');
        if (editBtnClick != 1) {
            $(this).text("SAVE");
            $(this).css({'color': '#0093be'});
            $(this).addClass("metadata-save-btn").removeClass("metadata-edit-btn");
        }
        editBtnClick = 1;
        $(this).parent().next().find('.metadataEdit').css('cursor', 'pointer');
    });

    $(".level-tab span .metadata-save-btn").click(function () {
        //console.log("level tab save btn click");
    });

    //a new subject of observation was clicked, so reload edit metadata
    $(".soo-click").click(function () {
        $(".metadata-save-btn").removeClass("metadata-save-btn").text("EDIT").addClass("metadata-edit-btn").css("color", '');
        var id = $("#meta_textarea").parent().children("div").eq(0).text();
        var text = $("#meta_textarea").text();
        if (meta_options == '') {
            if (meta_value_before != '' && (meta_control_type == 'multi_input' || meta_control_type == 'multi_select' )) {
                meta_value_before = meta_value_before.replace(/\n+/g, '<br />');
            }
            var fill = '<div id="' + meta_field_name + '" data-control="' + meta_control_type + '">' + meta_value_before + "</div>";
        } else {
            meta_options = meta_options.replace(/["]+/g, '&quot;');
            if (meta_value_before != '' && (meta_control_type == 'multi_input' || meta_control_type == 'multi_select' )) {
                meta_value_before = meta_value_before.replace(/\n+/g, '<br />');
            }
            var fill = '<div id="' + meta_field_name + '" data-control="' + meta_control_type + '" data-options="' + meta_options + '">' + meta_value_before + "</div>";
        }
        $("#meta_textarea").parent().replaceWith(fill);
        metadataIsSelected = 0;
        editBtnClick = 0;
        $('.icon-meta-flag').css('display', 'block'); //add flags back in
        $(".metadataEdit").css('cursor', 'pointer'); //the last edit metadata box is clickable
    });

    //save button click, grab the value and submit
    $(".level-tab").click(function (e) {
        $('.metadataEdit').css('cursor', 'default');
        if (e.target.getAttribute("class") == 'metadata-save-btn') {
            e.stopPropagation();
            if (metadataIsSelected == 1) {
                $(".metadata-save-btn").removeClass("metadata-save-btn") //change back to edit button
                    .text("EDIT")
                    .addClass("metadata-edit-btn")
                    .css("color", '');
                getMetadataForSubmit();  //get data
                addMetadataEdits();     //submit the data
            }
        }else if (e.target.getAttribute("aria-expanded") == 'true') {
                //console.log("already expanded");
        }else {
            $(".metadata-save-btn").removeClass("metadata-save-btn").text("EDIT").addClass("metadata-edit-btn").css("color", '');
            var id = $("#meta_textarea").parent().children("div").eq(0).text();
            var text = $("#meta_textarea").text();
            if (meta_options == '' || meta_options == undefined) {

                if (meta_value_before != '' && (meta_control_type == 'multi_input' || meta_control_type == 'multi_select' )) {
                    meta_value_before = meta_value_before.replace(/\n+/g, '<br />');
                }
                var fill = '<div id="' + meta_field_name + '" data-control="' + meta_control_type + '">' + meta_value_before + "</div>";
            } else {
                meta_options = meta_options.replace(/["]+/g, '&quot;');
                if (meta_value_before != '' && (meta_control_type == 'multi_input' || meta_control_type == 'multi_select' )) {
                    meta_value_before = meta_value_before.replace(/\n+/g, '<br />');
                }
                var fill = '<div id="' + meta_field_name + '" data-control="' + meta_control_type + '" data-options="' + meta_options + '">' + meta_value_before + "</div>";
            }
            $("#meta_textarea").parent().replaceWith(fill);
            metadataIsSelected = 0;
            editBtnClick = 0;
            $('.icon-meta-flag').css('display', 'block'); //add flags back in
            $(".metadataEdit").css('cursor', 'pointer'); //the last edit metadata box is clickable
        }
    });

    //check if the value was a &nsbp.. that won't save in mysql well.
    function checkForNbsp(text){
        if(text == "\u00a0"){
            text = '';
        }
        return text;
    }

    //save was clicked. this is just a helper function that is run to grab the data before submit.
    function getMetadataForSubmit(){
        meta_new_value = '';
        if (meta_control_type == 'text') {
            meta_new_value = checkForNbsp( $("#meta_textarea").val() );

        } else if (meta_control_type == 'list') {
            meta_new_value = checkForNbsp( $("#meta_textarea option:selected").text() );

        } else if (meta_control_type == 'date') {
            var month = '', day = '', year = '';
            month = checkForNbsp( $('#month_select option:selected').text() );
            day = checkForNbsp( $('#day_select option:selected').text() );
            year = checkForNbsp( $('#year_select option:selected').text() );

            meta_new_value =  year + '-' + month + '-' + day + ' CE';

        } else if (meta_control_type == 'terminus') {
            var month = '', day = '', year = '', prefix = '', era = '';
            month = checkForNbsp( $('#month_select option:selected').text() );
            day = checkForNbsp( $('#day_select option:selected').text() );
            year = checkForNbsp( $('#year_select option:selected').text() );
            prefix = checkForNbsp( $('#prefix_select option:selected').text() );
            era = checkForNbsp( $('#era_select option:selected').text() );

            if (prefix != '') {
                meta_new_value = prefix + ' ';
            }
            meta_new_value += year + '-' + month + '-' + day;

            if (era != '') {
                meta_new_value += ' ' + era;
            }

        } else if (meta_control_type == 'multi_input') {
            $("#meta_textarea option").each(function () {
                meta_new_value += checkForNbsp( $(this).text() ) + "\n";
            });
            if (meta_new_value != '') {
                meta_new_value = meta_new_value.substring(0, meta_new_value.length - 1);
            }

        } else if (meta_control_type == 'multi_select') {
            $("#meta_textarea option:selected").each(function () {
                meta_new_value += checkForNbsp( $(this).text() ) + "\n";
            });
            if (meta_new_value != '') {
                meta_new_value = meta_new_value.substring(0, meta_new_value.length - 1);
            }
        }
    }

    /*
     *  Edit-Metadata Pagination functions  -  from here to bottom --
     */

    $(".associator_pagination").disableSelection(); //prevent highlight of the page numbers on double click

    $(document).on("click", ".aso_page_number", function () {
        if($(this).prev().length <= 0){ //it is on the first page so hide the left arrows
            $('.associator_prev').css('visibility', 'hidden');
            $('.associator_begin').css('visibility', 'hidden');
        }else{
            $('.associator_prev').css('visibility', 'visible');
            $('.associator_begin').css('visibility', 'visible');
        }
        if($(this).next().length <= 0){ //it is on the last page to hide the right arrows
            $('.associator_next').css('visibility', 'hidden');
            $('.associator_end').css('visibility', 'hidden');
        }else{
            $('.associator_next').css('visibility', 'visible');
            $('.associator_end').css('visibility', 'visible');
        }

        var currentPage = $(this).data('asoindex');
        $('.aso_page_number').removeClass('aso_page_active');
        $(this).addClass('aso_page_active');
        populateAssociatorCheckboxes(currentPage);
    });

    $('.associator_next').click(function(){
        var el = $('.aso_page_active').next();
        if(el.length > 0){
            el.click();
            if( el.css('display') == 'none' ){
                el.css('display', 'inline-block');
                var remove = el.data('asoindex') - 9;
                $("span[data-asoindex='"+remove+"']").css('display', 'none');
            }
        }
    });
    $('.associator_prev').click(function(){
        var el = $('.aso_page_active').prev();
        if(el.length > 0){
            el.click();
            if( el.css('display') == 'none' ){
                el.css('display', 'inline-block');
                var remove = el.data('asoindex') + 9;
                $("span[data-asoindex='"+remove+"']").css('display', 'none');
            }
        }
    });

    $('.associator_end').click(function(){
        var el = $('.aso_page_number').last();
        if(el.length > 0){
            $('.aso_page_number').css('display', 'none');
            el.click();
            var index = el.data('asoindex');
            for(var i = index; i>index-9; i--){
                $("span[data-asoindex='"+i+"']").css('display', 'inline-block');
            }
        }
    });

    $('.associator_begin').click(function(){
        var el = $('.aso_page_number').first();
        if(el.length > 0){
            $('.aso_page_number').css('display', 'none');
            el.click();
            var index = el.data('asoindex');
            for(var i = 1; i<index+9; i++){
                $("span[data-asoindex='"+i+"']").css('display', 'inline-block');
            }
        }
    });

    function populateNumbers(i){
        var numbersHtml = '';
        $('.associator_numbers').html(numbersHtml);//clear
        for(var j=1; j<=i; j++) {
            numbersHtml += '<span class="aso_page_number" data-asoindex="'+j+'" style="display:none;">'+j+'</span>';
        }
        $('.associator_numbers').html(numbersHtml);
        $('.associator_begin').click();
    }
}

// $( document ).ready(editMetaPrep);
