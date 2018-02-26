$(document).ready(function(){
    //export all schemes and jpgs
    var isExporting = 0;
    $("#export-btn").click(function () {
        if(isExporting == 1){
            return;
        }
        isExporting = 1;
        var loaderHtml = $(ARCS_LOADER_HTML);
        //$(loaderHtml).css({'height':'inherit', 'margin-top':'-6px'});
        $(loaderHtml).css({'height':'13px', 'width':'13px'});
        $(loaderHtml).find('.sk-folding-cube').css({'height':'11px', 'width':'11px'});
        $('.icon-export').css('background-image','none').css('padding-left', '2px');
        $('.icon-export').html(loaderHtml);
        //load data in variables

		//var projects = PROJECTS;
        var seasons = SEASONS;
        var excavations = EXCAVATIONS;
        var resources = RESOURCES;
        var pages = {};
        var subjects = SUBJECTS;

        //build xmls for all the single records
        var xmlArray = [];
        var xmlString = '';

		var projectsObject = scheme2json(PROJECTS);

		var seasonsObject = [];
    //    if( !jQuery.isEmptyObject(seasons) ) {
        if(seasons.length > 0) {
            seasonsObject = scheme2json(seasons);
        }
		var excavationsObject = [];
        //if( !jQuery.isEmptyObject(excavations) ) {
        if(excavations.length > 0) {
            excavationsObject = scheme2json(excavations);
        }

		var resourcesObject = scheme2json(resources);
        var pagesObject = [];
        resourcesObject.forEach(function (tempdata) {
            if ('page' in tempdata) {
                for( var key in tempdata['page'] ){
                    pagesObject.push(tempdata['page'][key]);
                }
                delete tempdata['page'];
            }
        })
        var pageUrls = [];
		var subjectsObjectsArray = [];

        //if( !jQuery.isEmptyObject(subjects) ) {
        if(subjects.length > 0) {
            subjectsObjectsArray = scheme2json(subjects);
        }

        // handle project
        projectsObject.forEach(function (tempdata) {
            if( 'linkers' in tempdata ) {
                tempdata.linkers.forEach(function (linker) {
                    seasonsObject.forEach(function (record) {
                        if (linker == record.kid) {
                            var data = '';
                            if ('Name' in tempdata) {
                                data = tempdata.Name;
                            }
                            record['Project Associator'] = data;
                        }
                    })
                })
            }
        })
        xmlString = objects2xmlString(projectsObject);
        xmlArray.push(xmlString);
        console.log('project done:');
        console.log(xmlString);
        console.log(xmlArray);
        //return;

        var firstPass = true;
        // handle season
        seasonsObject.forEach(function (tempdata) {
            if( 'linkers' in tempdata ) {
                tempdata.linkers.forEach(function (linker) {
                    excavationsObject.forEach(function (record) {
                        if( firstPass ){
                            record['Season Associator'] = '';
                        }
                        if (linker == record.kid) {
                            var data = '';
                            if ('Title' in tempdata) {
                                data = tempdata.Title;
                            }
                            if( typeof record['Season Associator'] == 'string' ){
                                record['Season Associator'] = [data];
                            }else{
                                record['Season Associator'].push(data);
                            }
                        }
                    })
                    resourcesObject.forEach(function (record) {
                        if( firstPass ){
                            record['Season Associator'] = '';
                        }
                        if (linker == record.kid) {
                            var data = '';
                            if ('Title' in tempdata) {
                                data = tempdata.Title;
                            }
                            if( typeof record['Season Associator'] == 'string' ){
                                record['Season Associator'] = [data];
                            }else{
                                record['Season Associator'].push(data);
                            }
                        }
                    })
                    firstPass = false;
                })
            }
        })

        xmlString = '';
        xmlString = objects2xmlString(seasonsObject);
        xmlArray.push(xmlString);
        firstPass = true;
        // handle excavation
        excavationsObject.forEach(function (tempdata) {
            if( 'linkers' in tempdata ) {
                tempdata.linkers.forEach(function (linker) {
                    resourcesObject.forEach(function (record) {
                        if( firstPass ){
                            record['Excavation - Survey Associator'] = '';
                        }
                        if (linker == record.kid) {
                            var data = '';
                            if ('Name' in tempdata) {
                                data = tempdata.Name;
                            }
                            if( typeof record['Excavation - Survey Associator'] == 'string' ){
                                record['Excavation - Survey Associator'] = [data];
                            }else{
                                record['Excavation - Survey Associator'].push(data);
                            }
                        }
                    })
                    firstPass = false;
                })
            }
        })
        xmlString = '';
        xmlString = objects2xmlString(excavationsObject);
        xmlArray.push(xmlString);

        //handle resource
        resourcesObject.forEach(function (tempdata) {
            if( 'linkers' in tempdata ) {
                tempdata.linkers.forEach(function (linker) {
                    pagesObject.forEach(function (record) {
                        if (linker == record.kid) {
                            var data = '';
                            if ('Resource Identifier' in tempdata) {
                                data = tempdata['Resource Identifier'];
                            }
                            record['Resource Identifier'] = data;
                        }
                    })
                })
            }
        })
        xmlString = '';
        xmlString = objects2xmlString(resourcesObject);
        xmlArray.push(xmlString);

        //take care of the multiple pages
        pagesObject.forEach(function (tempdata) {
            if( 'linkers' in tempdata ) {
                tempdata.linkers.forEach(function (linker) {
                    subjectsObjectsArray.forEach(function (record) {
                        if (linker == record.kid) {
                            var data = '';
                            if ('Page Identifier' in tempdata) {
                                data = tempdata['Page Identifier'];
                            }
                            record['Pages Associator'] = data;
                        }
                    })
                })
            }
            pageUrls.push(tempdata['Image_Upload']['localName']); //collect image url stuff for later
            var uploadObject = {originalName:tempdata['Image_Upload']['originalName'],text:tempdata['Image_Upload']['localName']};
            tempdata['Image_Upload'] = uploadObject;
        })
        xmlString = '';
        xmlString = objects2xmlString(pagesObject);
        xmlArray.push(xmlString);

        //nothing fancy for subject since it doesn't have a scheme below.
        xmlString = '';
        xmlString = objects2xmlString(subjectsObjectsArray);
        xmlArray.push(xmlString);

        //create file
        $.ajax({
            url: arcs.baseURL + "resources/createExportFile",
            type: "POST",
            data: {'xmls': JSON.stringify(xmlArray), 'picUrls': JSON.stringify(pageUrls)},
            statusCode: {
                200: function (data) {
                    //download created file
                    $('<form />')
                        .hide()
                        .attr({ method : "post" })
                        .attr({ action : arcs.baseURL + "resources/downloadExportFile"})
                        .append($('<input />')
                            .attr("type","hidden")
                            .attr({ "name" : "filename" })
                            .val(data)
                        )
                        .append('<input type="submit" />')
                        .appendTo($("body"))
                        .submit();

                    //check when the export finishes
                    setTimeout(function(){ //give time for jquery form click
                        $.ajax({
                            url: arcs.baseURL + "resources/checkExportDone",
                            type: "POST",
                            data: {'filename': data},
                            statusCode: {
                                200: function () {
                                    $('.icon-export').html('');
                                    $('.icon-export').css('background-image','url(/'+BASE_URL+'img/export.svg)');
                                    isExporting = 0;
                                }
                            }
                        });
                    }, 50);
                },
                400: function () {
                    console.log("Bad Request");
                },
                405: function () {
                    console.log("Method Not Allowed");
                }
            }
        });
        return;
    });

	function scheme2json(scheme){
		//build the all the records into a json encoded array.
            var schemeString = '[';
            for( var index in scheme ){
                schemeString += JSON.stringify(scheme[index]) +',';
            }
            schemeString = schemeString.substring(0, schemeString.length -1 ); //remove last comma
            schemeString += ']';
            //console.log(schemeString);
            return JSON.parse(schemeString);//get array of json objects
	}

	function objects2xmlString(o){
        var xmlString = '';
        o.forEach(function (tempdata) {
            deleteTags(tempdata);
            var recordObject = {Record: tempdata};
            var dataObject = {Data: recordObject};
            console.log(dataObject == null);
            console.log('wat da hek');
            // if (dataObject == ""){
            //
            // }
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
