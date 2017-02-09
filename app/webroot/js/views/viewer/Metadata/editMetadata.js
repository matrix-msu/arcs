$(document).ready(function () {
    /*--------Metadata--------*/
    function addMetadataEdits() {
        switch (meta_scheme_name){
            case "Project":
                meta_scheme_id = "<?php echo PROJECT_SID; ?>";
                meta_resource_kid = "<?php echo $project['kid']; ?>";
                break;
            case "Season":
                meta_scheme_id = "<?php echo SEASON_SID; ?>";
                meta_resource_kid = "<?php echo $season['kid']; ?>";
                break;
            case "Excavation/Survey":
                meta_scheme_id = "<?php echo SURVEY_SID; ?>";
                //finds the kid somewhere else.
                break;
            case "Archival_Object":
                meta_scheme_id = "<?php echo RESOURCE_SID; ?>";
                meta_resource_kid = resourceKid;
                break;
            case "Subject_Of_Observation":
                meta_scheme_id = "<?php echo SUBJECT_SID; ?>";
                //finds the kid somewhere else
                break;
        }
        $.ajax({
            url: arcs.baseURL + "metadataedits/add",
            type: "post",
            data: {
                resource_kid: resourceKid,
                resource_name: "<?php echo $resource['Title']; ?>",
                scheme_id: meta_scheme_id,
                //scheme_name: meta_scheme_name, //no longer used
                control_type: meta_control_type,
                field_name: meta_field_name,
                user_id: "idk",   //this is set somewhere else
                value_before: meta_value_before,
                new_value: meta_new_value,
                approved: 0,
                rejected: 0,
                reason_rejected: "",
                metadata_kid: meta_resource_kid
            },
            success: function (data) {
                window.location.reload();
            }
        })
    }
    var metadataIsSelected = 0;     //0 or 1 to know if there is one selected
    var editBtnClick = 0;           //0 or 1
    var meta_field_name = '';       //data sent to arcs kora plugin---
    var meta_control_type = '';
    var meta_options = '';
    var meta_value_before = '';
    var meta_new_value = '';
    var meta_scheme_name = '';
    var meta_resource_kid = '';
    var meta_scheme_id = 0;

    var associator_full_array = [];  //used for associator modal
    var associator_selected = [];

    $(".metadataEdit").click(function() {
        $(this).each(
            function(){
                // if the td elements contain any input tag
                if ($(this).find('textarea').length || $(this).find('select').length || editBtnClick == 0){
                    // sets the text content of the tag equal to the value of the input
                    //$(this).text($(this).find('input').val());
                }else {
                    if(metadataIsSelected == 1){
                        var id = $("#meta_textarea").parent().children("div").eq(0).text();
                        var text = $("#meta_textarea").text();
                        if( meta_options == '' ){
                            if( meta_value_before != '' && (meta_control_type == 'multi_input' || meta_control_type == 'multi_select' ) ){
                                meta_value_before = meta_value_before.replace(/\n+/g, '<br />');
                            }
                            var fill = '<div id="'+meta_field_name+'" data-control="'+meta_control_type+'">'+meta_value_before+"</div>";
                        }else{
                            meta_options = meta_options.replace(/["]+/g, '&quot;');
                            if( meta_value_before != '' && (meta_control_type == 'multi_input' || meta_control_type == 'multi_select' ) ){
                                meta_value_before = meta_value_before.replace(/\n+/g, '<br />');
                            }
                            var fill = '<div id="'+meta_field_name+'" data-control="'+meta_control_type+'" data-options="'+meta_options+'">'+meta_value_before+"</div>";
                        }
                        $("#meta_textarea").parent().replaceWith(fill);
                        metadataIsSelected = 0;
                    }
                    // removes the text, appends an input and sets the value to the text-value
                    meta_field_name = $(this).children('div').eq(1).attr('id');
                    meta_control_type = $(this).children('div').eq(1).attr('data-control');
                    meta_options = '';
                    meta_scheme_name = $(this).parent().parent().parent().attr('id');
                    meta_resource_kid = $(this).parent().parent().parent().parent().attr('data-kid');
                    var temp_element = $(this).children('div').eq(1).clone();
                    temp_element.find('br').replaceWith('\n');
                    meta_value_before = temp_element.text();

                    //give different control edits based on the kora control type
                    var html = '';
                    if( meta_control_type == 'text' ){
                        html = $('<textarea />',{'value' : meta_value_before, 'id' : 'meta_textarea'}).val(meta_value_before);
                        $(this).children('div').eq(1).html(html);

                    }else if( meta_control_type == 'date' ){
                        html= '<div class="kora_control" id="meta_textarea">'+
                            '<select class="kcdc_month" id="month_select">'+
                            '<option value="">&nbsp;</option><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option>'+
                            '</select>'+
                            '<select class="kcdc_day" id="day_select">'+
                            '<option value="">&nbsp;</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option>'+
                            '</select>'+
                            '<select class="kcdc_year"  id="year_select">'+
                            '<option value="">&nbsp;</option><option value="1930">1930</option><option value="1931">1931</option><option value="1932">1932</option><option value="1933">1933</option><option value="1934">1934</option><option value="1935">1935</option><option value="1936">1936</option><option value="1937">1937</option><option value="1938">1938</option><option value="1939">1939</option><option value="1940">1940</option><option value="1941">1941</option><option value="1942">1942</option><option value="1943">1943</option><option value="1944">1944</option><option value="1945">1945</option><option value="1946">1946</option><option value="1947">1947</option><option value="1948">1948</option><option value="1949">1949</option><option value="1950">1950</option><option value="1951">1951</option><option value="1952">1952</option><option value="1953">1953</option><option value="1954">1954</option><option value="1955">1955</option><option value="1956">1956</option><option value="1957">1957</option><option value="1958">1958</option><option value="1959">1959</option><option value="1960">1960</option><option value="1961">1961</option><option value="1962">1962</option><option value="1963">1963</option><option value="1964">1964</option><option value="1965">1965</option><option value="1966">1966</option><option value="1967">1967</option><option value="1968">1968</option><option value="1969">1969</option><option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option><option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option>'+
                            '</select>'+
                            '<input type="hidden" class="kcdc_era" id="era" value="CE">'+
                            '<div class="ajaxerror"></div>'+
                            '</div>';
                        $(this).children('div').eq(1).html(html);

                        var month = '';
                        var day = '';
                        var year = '';

                        if( meta_value_before != '' ){
                            var valueArray = meta_value_before.split(" ");
                            var dateString = valueArray[0];
                            var dateArray = dateString.split("/");
                            month = dateArray[0];
                            day = dateArray[1];
                            year = dateArray[2];
                            $('#month_select option[value="'+ month +'"]').prop('selected', true);
                            $('#day_select option[value="'+ day +'"]').prop('selected', true);
                            $('#year_select option[value="'+ year +'"]').prop('selected', true);
                        }

                    }else if( meta_control_type == 'terminus' ){
                        html= '<div class="kora_control" id="meta_textarea">'+
                            '<select class="kcdc_month" id="month_select">'+
                            '<option value="">&nbsp;</option><option value="1">January</option><option value="2">February</option><option value="3">March</option><option value="4">April</option><option value="5">May</option><option value="6">June</option><option value="7">July</option><option value="8">August</option><option value="9">September</option><option value="10">October</option><option value="11">November</option><option value="12">December</option>'+
                            '</select>'+
                            '<select class="kcdc_day" id="day_select">'+
                            '<option value="">&nbsp;</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option>'+
                            '</select>'+
                            '<select class="kcdc_year" id="year_select"><option value="">&nbsp;</option>';
                        for (i = 1; i < 10000; i++) {
                            html += '<option value="'+i+'">'+i+'</option>';
                        }
                        html += '</select>'+
                            '<select class="kcdc_era" id="era_select"><option value="" selected="selected">'+
                            '</option><option value="CE">CE</option><option value="BCE">BCE</option>'+
                            '</select><br />Prefix: '+
                            '<select class="kcdc_prefix"  id="prefix_select">'+
                            '<option></option><option value="ca">ca</option>'+
                            '</select>'+
                            '<div class="ajaxerror"></div>'+
                            '</div>';
                        $(this).children('div').eq(1).html(html);

                        var month = '';
                        var day = '';
                        var year = '';
                        var prefix = '';
                        var era = '';

                        /////change text date to date array----
                        if( meta_value_before != '' ){
                            var valueArray = meta_value_before.split(" ");
                            var dateString = '';
                            if( valueArray[0].indexOf('/') == -1 ){     // '/' does not exist in array, it is the prefix
                                prefix = valueArray[0];
                                dateString = valueArray[1];
                                if(typeof valueArray[2] !== 'undefined') { //does exist
                                    era = valueArray[2];
                                }

                            }else{      // '/' does exit it is the date
                                dateString = valueArray[0];
                                if(typeof valueArray[1] !== 'undefined') { //does exist
                                    era = valueArray[1];
                                }
                            }
                            var dateArray = dateString.split("/");
                            month = dateArray[0];
                            day = dateArray[1];
                            year = dateArray[2];
                            $('#month_select option[value="'+ month +'"]').prop('selected', true);
                            $('#day_select option[value="'+ day +'"]').prop('selected', true);
                            $('#year_select option[value="'+ year +'"]').prop('selected', true);
                            if( prefix != '' ){
                                $('#prefix_select option[value="'+ prefix +'"]').prop('selected', true);
                            }
                            if( era != ''){
                                $('#era_select option[value="'+ era +'"]').prop('selected', true);
                            }
                        }

                    }else if( meta_control_type == 'multi_input' ){
                        html = '<div class="kora_control" id="meta_textarea">'+
                            '<table>'+
                            '<tbody>'+
                            '<tr>'+
                            '<td><input type="text" class="kcmtc_additem" name="Input135" id="Input135" value=""></td>'+
                            '<td><input type="button" class="kcmtc_additem" id="multi_input_add" value="Add"></td>'+
                            '</tr>'+
                            '<tr>'+
                            '<td rowspan="3">'+
                            '<select id="p123c135" class="kcmtc_curritems fullsizemultitext" name="p123c135[]" multiple="multiple" size="5">';
                        if( meta_value_before != '' ){
                            var valueArray = meta_value_before.split("\n");
                            valueArray.pop(); //remove the trailing ''
                            valueArray.forEach(function (tempdata) {
                                html += '<option class="multi_input_option" value="'+ tempdata +'" selected>'+ tempdata +'</option>';
                            });
                        }
                        html += '</select>'+
                            '</td>'+
                            '<td><input type="button" class="kcmtc_removeitem" id="multi_input_remove" value="Remove"></td>'+
                            '</tr>'+
                            '<tr>'+
                            '<td><input type="button" class="kcmtc_moveitemup" id="multi_input_up" value="Up"></td>'+
                            '</tr>'+
                            '<tr>'+
                            '<td><input type="button" class="kcmtc_moveitemdown" id="multi_input_down" value="Down"></td>'+
                            '</tr>'+
                            '</tbody>'+
                            '</table>'+
                            '<div class="ajaxerror"></div>'+
                            '</div>';
                        $(this).children('div').eq(1).html(html);
                        $('#multi_input_add').click(function(e) {
                            var textBar = $('#Input135');
                            var text = textBar.val();
                            html = '<option class="multi_input_option" value="'+ text +'" selected>'+ text +'</option>';
                            $('#p123c135').append(html);
                            textBar.val('');
                        });
                        $('#multi_input_remove').click(function(e) {
                            var $option = $( "#meta_textarea option:selected" );
                            if( $option.length == 1 ){
                                $option.remove();
                            }
                        });
                        $('#multi_input_up').click(function(e) {
                            var $option = $( "#meta_textarea option:selected" );
                            if( $option.length == 1 && $option.prev().hasClass('multi_input_option') ){
                                $option.insertBefore( $option.prev() );
                            }
                        });
                        $('#multi_input_down').click(function(e) {
                            var $option = $( "#meta_textarea option:selected" );
                            if( $option.length == 1 && $option.next().hasClass('multi_input_option') ){
                                $option.insertAfter( $option.next() );
                            }
                        });

                    }else if( meta_control_type == 'multi_select'){
                        meta_options = $(this).children('div').eq(1).attr('data-options');
                        html = '<div class="kora_control" id="meta_textarea">'+
                            '<select id="p123c25" class="kcmlc_curritems" name="p123c25[]" multiple="multiple" size="5">'+
                            meta_options +
                            '</select>'+
                            '<div class="ajaxerror"></div>'+
                            '</div>';
                        $(this).children('div').eq(1).html(html);
                        if( meta_value_before != '' ){
                            var valueArray = meta_value_before.split("\n");
                            valueArray.pop(); //remove the trailing ''
                            valueArray.forEach(function (tempdata) {
                                $('#meta_textarea option[value="'+ tempdata +'"]').prop('selected', true);
                            });
                        }

                    }else if( meta_control_type == 'list' ){
                        meta_options = $(this).children('div').eq(1).attr('data-options');
                        html = '<div class="kora_control" id="meta_textarea">'+
                            '<select name="p123c15">'+
                            '<option value="">&nbsp;</option>'+
                            meta_options +
                            '</select></div>';
                        $(this).children('div').eq(1).html(html);
                        if( meta_value_before != '' ){
                            $('#meta_textarea option[value="'+ meta_value_before +'"]').prop('selected', true);
                        }
                    }else if( meta_control_type == 'associator' ){
                        $('#associatorTitle').html('Edit ' + meta_field_name + ' Metadata' );
                        $('.associatorModalBackground').show();
                        //add the preloader gif
                        var html = '<img alt="preloader gif" src="'+ arcs.baseURL + 'img/arcs-preloader.gif" style="display:block;margin:20px auto 0 auto;" />';
                        $('#associatorSearchObjects').append(html);
                        associator_modal = $('.associatorModalBackground')[0].outerHTML;

                        $.ajax({
                            url: arcs.baseURL + "metadataedits/getAllKidsByScheme",
                            type: "POST",
                            data: {
                                scheme_name: meta_field_name
                            },
                            success: function (data) {
                                associator_full_array = new Array();
                                for (var key in data) {
                                    if (data.hasOwnProperty(key)) {

                                        var obj = data[key];
                                        obj.kid = key;
                                        associator_full_array.push(obj);
                                    }
                                }
                                populateAssociatorCheckboxes();
                            }
                        });

                    }
                    metadataIsSelected = 1;
                }
            })
    });
    $('.associatorSearchSubmit').on('click', function(evt){
        evt.stopImmediatePropagation();
        meta_new_value = '';
        $('#associatorSearchObjects input:checked').each(function () {
            meta_new_value += $( this ).val() + "\n";
        });
        if( meta_new_value != '' ){
            meta_new_value = meta_new_value.substring(0, meta_new_value.length - 1);
        }
        addMetadataEdits();

    });

    $('#associatorSearchObjects').on('click', 'label', function(evt){
        if( meta_field_name == 'Project Associator' || meta_field_name == 'Season Associator' ){
            $('#associatorSearchObjects input:checked').each(function () {
                $(this).attr('checked', false);
            });
        }
    });
    $('.modalCloseAssociator').click(function() {
        if( associator_full_array.length > 1000 ){
            //needs to reload the page or else it can suffer severe ui lags
            location.reload();
        }else{
            $('#associatorSearchObjects').html('');
            $(".associatorModalBackground").hide();
            $(".save-btn").removeClass("save-btn").text("EDIT").addClass("edit-btn").css("color", '');
            metadataIsSelected = 0;
            editBtnClick = 0;
        }
    });

    function populateAssociatorCheckboxes() {

        var populateCheckboxes = "<hr>";
        for (i = 0; i < associator_full_array.length; i++) {
            var obj = associator_full_array[i];
            var kid = '';
            var text = '';
            for (var field in obj) {
                if (obj.hasOwnProperty(field) && field != 'pid' && field != 'schemeID' && field != 'linkers' ) {
                    if( field == 'kid' ){
                        kid = obj[field];
                    }else if( field == 'Image Upload' ){
                        text += 'Original Name: ' + obj[field]['originalName'] + '<br />';
                    }else{
                        text += field + ': ' + obj[field] + '<br />';
                    }
                }
            }
            populateCheckboxes += "<input type='checkbox' class='checkedboxes' name='associator-item-" + i + "' id='associator-item-" + i + "' value='" + kid + "' />"
                + "<label for='associator-item-" + i + "'><div style='float:left'>" + kid + " </div><div style='float:right'>" + text + "</div></label><br />";

        }
        $('#associatorSearchObjects').html(populateCheckboxes);
        if( meta_value_before != '' ){
            var valueArray = meta_value_before.split("\n");
            valueArray.pop(); //remove the trailing ''
            valueArray.forEach(function (tempdata) {
                var label_for = $('#associatorSearchObjects input[value="'+ tempdata +'"]').attr('name');
                $("#associatorSearchObjects label[for="+label_for+"]").trigger('click');
            });
        }
    }
    function associatorSearch() {
        var query = $(".associatorSearchBar").val();
        if( query == '' ){
            return;
        }
        for (i = 0; i < associator_full_array.length; i++) {
            var obj = associator_full_array[i];
            if (obj.hasOwnProperty('kid') && obj.kid == query ) {
                $('label[for="associator-item-'+ i +'"]')[0].scrollIntoView();
            }
        }


    }

    $(document).on("click", ".edit-btn", function() {
        $('.metadataEdit').css('cursor', 'default');
        if (editBtnClick != 1) {
            $(this).text("SAVE");
            $(this).css({'color':'#0093be'});
            $(this).addClass("save-btn").removeClass("edit-btn");
        }
        editBtnClick = 1;
        $(this).parent().next().find('.metadataEdit').css('cursor', 'pointer');
    });

    // Details tab
    $(".details").click(function () {
        GetDetails();

    });

    $(".level-tab span .save-btn").click(function() {
        //.log("level tab save btn click");
    });

    $(".soo-click").click(function() {
        $(".save-btn").removeClass("save-btn").text("EDIT").addClass("edit-btn").css("color", '');
        var id = $("#meta_textarea").parent().children("div").eq(0).text();
        var text = $("#meta_textarea").text();
        if( meta_options == '' ){
            if( meta_value_before != '' && (meta_control_type == 'multi_input' || meta_control_type == 'multi_select' ) ){
                meta_value_before = meta_value_before.replace(/\n+/g, '<br />');
            }
            var fill = '<div id="'+meta_field_name+'" data-control="'+meta_control_type+'">'+meta_value_before+"</div>";
        }else{
            meta_options = meta_options.replace(/["]+/g, '&quot;');
            if( meta_value_before != '' && (meta_control_type == 'multi_input' || meta_control_type == 'multi_select' ) ){
                meta_value_before = meta_value_before.replace(/\n+/g, '<br />');
            }
            var fill = '<div id="'+meta_field_name+'" data-control="'+meta_control_type+'" data-options="'+meta_options+'">'+meta_value_before+"</div>";
        }
        $("#meta_textarea").parent().replaceWith(fill);
        metadataIsSelected = 0;
        editBtnClick = 0;
    });

    $(".level-tab").click(function(e) {
        $('.metadataEdit').css('cursor', 'default');
        if( e.target.getAttribute("class") == 'save-btn' ){
            e.stopPropagation();
            if (metadataIsSelected == 1) {
                $(".save-btn").removeClass("save-btn");
                meta_new_value = '';
                if( meta_control_type == 'text' ){
                    meta_new_value = $("#meta_textarea").val();

                }else if( meta_control_type == 'list' ){
                    meta_new_value = $( "#meta_textarea option:selected" ).text();

                }else if( meta_control_type == 'date' ){
                    var month='', day='', year='';
                    month = $('#month_select option:selected').text();
                    day = $('#day_select option:selected').text();
                    year = $('#year_select option:selected').text();

                    meta_new_value = month + '/' + day + '/' + year + ' CE';

                }else if( meta_control_type == 'terminus' ){
                    var month='', day='', year='', prefix='', era='';
                    month = $('#month_select option:selected').text();
                    day = $('#day_select option:selected').text();
                    year = $('#year_select option:selected').text();
                    prefix = $('#prefix_select option:selected').text();
                    era = $('#era_select option:selected').text();

                    if( prefix != '' ){
                        meta_new_value = prefix + ' ';
                    }
                    meta_new_value += month + '/' + day + '/' + year;

                    if( era != '' ){
                        meta_new_value += ' ' + era;
                    }

                }else if( meta_control_type == 'multi_input' ){
                    $( "#meta_textarea option" ).each(function() {
                        meta_new_value += $( this ).text() + "\n";
                    });
                    if( meta_new_value != '' ){
                        meta_new_value = meta_new_value.substring(0, meta_new_value.length - 1);
                    }

                }else if( meta_control_type == 'multi_select' ){
                    $( "#meta_textarea option:selected" ).each(function() {
                        meta_new_value += $( this ).text() + "\n";
                    });
                    if( meta_new_value != '' ){
                        meta_new_value = meta_new_value.substring(0, meta_new_value.length - 1);
                    }

                }
                addMetadataEdits();
            }
            return;
        }
        if( e.target.getAttribute("aria-expanded") == 'true' ){
            return;
        }
        $(".save-btn").removeClass("save-btn").text("EDIT").addClass("edit-btn").css("color", '');
        var id = $("#meta_textarea").parent().children("div").eq(0).text();
        var text = $("#meta_textarea").text();
        if( meta_options == '' ){
            if( meta_value_before != '' && (meta_control_type == 'multi_input' || meta_control_type == 'multi_select' ) ){
                meta_value_before = meta_value_before.replace(/\n+/g, '<br />');
            }
            var fill = '<div id="'+meta_field_name+'" data-control="'+meta_control_type+'">'+meta_value_before+"</div>";
        }else{
            meta_options = meta_options.replace(/["]+/g, '&quot;');
            if( meta_value_before != '' && (meta_control_type == 'multi_input' || meta_control_type == 'multi_select' ) ){
                meta_value_before = meta_value_before.replace(/\n+/g, '<br />');
            }
            var fill = '<div id="'+meta_field_name+'" data-control="'+meta_control_type+'" data-options="'+meta_options+'">'+meta_value_before+"</div>";
        }
        $("#meta_textarea").parent().replaceWith(fill);
        metadataIsSelected = 0;
        editBtnClick = 0;
        if ($(this).hasClass("transcriptionTab") && !$(".editTranscriptions").is(":visible") && !$(".editOptions").is(":visible")) $(".editTranscriptions").show();
        if (!$(this).hasClass("transcriptionTab")) {
            $(".editTranscriptions").hide();
            $(".editOptions").hide();
            $(".newTranscriptionForm").hide();
        }
    });
});