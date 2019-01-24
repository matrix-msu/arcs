/**
 * Created by josh.christ on 3/14/2017.
 */
$(document).ready(function() {
    $("#export-btn").click(function () {
        $(this).hide();
        $('.export-options').show();
    });

    $('.export-options').click(function(){ //do export.
        var isExporting = 0;
        var exportAsXML = false;
        var $clicked = $(this);

        if ($(this).attr('id') == 'export-xml-btn'){
            exportAsXML = true;
            $('#export-json-btn').hide();
        }else{
            $('#export-xml-btn').hide();
        }

        if(isExporting == 1 || $(this).hasClass('search-loading') ){
            return;
        }
        isExporting = 1;
        var loaderHtml = $(ARCS_LOADER_HTML);
        $(loaderHtml).css({'height':'inherit', 'margin-top':'-6px'});
        $(loaderHtml).find('.sk-folding-cube').css({'height':'36.43px', 'width':'36.43px'});
        $(this).html(loaderHtml);
        //get all resource kids
        var resourceKidResults = [];
        arcs.views.search.exportResults.forEach(function(e){
            resourceKidResults.push(e.kid);
        });

        console.log('kids', resourceKidResults)

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


        //grab all of the data from a multi-resource call.
        var schemeData = [];
        $.ajax({
            url: arcs.baseURL + "resource?ajax",
            type: "POST",
            data: {'resources': JSON.stringify(resourceKidResults), 'isExportAjax': true},
            statusCode: {
                200: function (data) {
                    schemeData = JSON.parse(data);
                    console.log('ajax success', schemeData);
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
                        //download created file
                        $('<form />')
                            .hide()
                            .attr({ method: "post" })
                            .attr({ action: arcs.baseURL + "resources/downloadExportFile" })
                            .append($('<input />')
                                .attr("type", "hidden")
                                .attr({ "name": "filename" })
                                .val(data.datafile)
                            )
                            .append('<input type="submit" />')
                            .appendTo($("body"))
                            .submit();

                        function doPictureDownloads(index,size,increment){
                            if( index > size -1 ){
                                $clicked.find('.icon-export').html('');
                                $clicked.find('.icon-export').css('background-image', 'url(/' + BASE_URL + 'img/export.svg)');
                                $clicked.hide();
                                $("#export-btn").show();
                                $('.export-options').hide();
                                isExporting = 0;
                                return;
                            }else if(index + increment > size){
                                increment = size - index;
                            }
                            var picSlice = data.picUrls.slice(index, index+increment);
                            index += increment;
                            $('<form />')
                                .hide()
                                .attr({ method: "post" })
                                .attr({ action: arcs.baseURL + "resources/downloadPictureExportFile" })
                                .append($('<input />')
                                    .attr("type", "hidden")
                                    .attr({ "name": "picUrls" })
                                    .val(JSON.stringify(picSlice))
                                )
                                .append('<input type="submit" />')
                                .appendTo($("body"))
                                .submit();
                            setTimeout(function () { //give time for jquery form click
                                $.ajax({
                                    url: arcs.baseURL + "resources/checkExportDone",
                                    type: "POST",
                                    data: { 'filename': data.datafile },
                                    statusCode: {
                                        200: function () {
                                            doPictureDownloads(index,size,increment);
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
                        //check when the export finishes
                        setTimeout(function () { //give time for jquery form click
                            $.ajax({
                                url: arcs.baseURL + "resources/checkExportDone",
                                type: "POST",
                                data: { 'filename': data.datafile },
                                statusCode: {
                                    200: function () {
                                        doPictureDownloads(0,data.picUrls.length,50);
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

    function scheme2json(scheme){
        //build the all the records into a json encoded array.
        var schemeString = '[';
        for( var index in scheme ){
            schemeString += JSON.stringify(scheme[index]) +',';
        }
        schemeString = schemeString.substring(0, schemeString.length -1 ); //remove last comma
        schemeString += ']';

        return JSON.parse(schemeString);//get array of json objects
    }

    function objects2xmlString(o){
        var xmlString = '';
        o.forEach(function (tempdata) {
            deleteTags(tempdata);
            var recordObject = {Record: tempdata};
            var dataObject = {Data: recordObject};
            var trim = json2xml(dataObject, '').substring(23); //remove the <Data><ConsistentData/>
            trim = trim.substring(0, trim.length - 7);  //remove the </Data>
            xmlString += trim;
        })
        xmlString = '<' + '?xml version="1.0" encoding="ISO-8859-1"?' + '>\n<Data><ConsistentData/>' +
            xmlString + '</Data>';
        return xmlString;
    }

    function deleteTags(o){
        if( 'thumb' in o ){
            delete o.thumb;
        }if( 'kid' in o ){
            delete o.kid;
        }if( 'linkers' in o ){
            delete o.linkers;
        }if( 'pid' in o ){
            delete o.pid;
        }if( 'recordowner' in o ){
            delete o.recordowner;
        }if( 'schemeID' in o ){
            delete o.schemeID;
        }if( 'systimestamp' in o ){
            delete o.systimestamp;
        }if( 'thumbnail' in o ){
            delete o.thumbnail;
        }if( 'Resource Associator' in o ){
            delete o['Resource Associator'];
        }if( 'project_kid' in o ){
            delete o['project_kid'];
        }
    }

    function json2xml(o, tab) {
        //console.log('json object:');
        //console.log(o);
        var firstObject = true;
        var toXml = function(v, name, ind) {
            var xml = "";
            name = name.replace(/ /g, '_');
            if (v instanceof Array) {
                for (var i=0, n=v.length; i<n; i++)
                    xml += ind + toXml(v[i], name, ind+"\t") + "\n";
            }
            //look for objects that are not the Data or Record tag
            else if ( typeof(v) == "object" && name != 'Record' && name != 'Data' ) {
                xml +=  "<" + name;
                if( 'prefix' in v && v.prefix != '' ){
                    xml +=' prefix="'+ v.prefix + '"';
                }
                if( 'originalName' in v && v.originalName != '' ){  //added this to take care of pages.
                    xml +=' originalName="'+ v.originalName + '"';
                }
                xml += '>';
                if ( 'text' in v ) {
                    xml += v.text;
                }
                if( 'month' in v ){
                    if( v.month != '' ){
                        xml += v.month;
                    }
                    xml += '/';
                }
                if( 'day' in v ){
                    if( v.day != '' ){
                        xml += v.day;
                    }
                    xml += '/';
                }
                if( 'year' in v && v.year != '' ){
                    xml += v.year;
                }
                if( 'era' in v && v.era != '' ){
                    xml += ' ' + v.era;
                }
                xml += '</' + name + '>';
            }
            else if (typeof(v) == "object") { //only record, data and terminus are objects
                firstObject = false;
                var hasChild = false;
                xml += ind + "<" + name;
                for (var m in v) {
                    if (m.charAt(0) == "@")
                        xml += " " + m.substr(1) + "=\"" + v[m].toString() + "\"";
                    else
                        hasChild = true;
                }
                xml += hasChild ? ">" : "/>";
                if( name == 'Data'){
                    xml += '<ConsistentData/>';
                }
                if (hasChild) {
                    for (var m in v) {
                        if (m == "#text")
                            xml += v[m];
                        else if (m == "#cdata")
                            xml += "<![CDATA[" + v[m] + "]]>";
                        else if (m.charAt(0) != "@")
                            xml += toXml(v[m], m, ind+"\t");
                    }
                    xml += (xml.charAt(xml.length-1)=="\n"?ind:"") + "</" + name + ">";
                }
            }
            else if( v.toString() != '') {
                //console.log(name);
                xml += ind + "<" + name + ">" + v.toString() +  "</" + name + ">";
            }
            return xml;
        }, xml="";
        for (var m in o)
            xml += toXml(o[m], m, "");
        return tab ? xml.replace(/\t/g, tab) : xml.replace(/\t|\n/g, "");
    }
});
