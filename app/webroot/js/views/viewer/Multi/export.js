$(document).ready(function(){
    //export all schemes and jpgs
    var isExporting = 0;
    $("#export-btn").click(function () {
        if(isExporting == 1){
            return;
        }
        isExporting = 1;
        $('.icon-export').css('background-image','url(/'+BASE_URL+'img/arcs-preloader.gif)');
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
        if( seasons.length > 0 ) {
            seasonsObject = scheme2json(seasons);
        }
		var excavationsObject = [];
        if( excavations.length > 0 ) {
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
        if( subjects.length > 0 ) {
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

        // handle season
        seasonsObject.forEach(function (tempdata) {
            if( 'linkers' in tempdata ) {
                tempdata.linkers.forEach(function (linker) {
                    excavationsObject.forEach(function (record) {
                        if (linker == record.kid) {
                            var data = '';
                            if ('Title' in tempdata) {
                                data = tempdata.Title;
                            }
                            record['Season Associator'] = data;
                        }
                    })
                    resourcesObject.forEach(function (record) {
                        if (linker == record.kid) {
                            var data = '';
                            if ('Title' in tempdata) {
                                data = tempdata.Title;
                            }
                            record['Season Associator'] = data;
                        }
                    })
                })
            }
        })
        xmlString = '';
        xmlString = objects2xmlString(seasonsObject);
        xmlArray.push(xmlString);

        // handle excavation
        excavationsObject.forEach(function (tempdata) {
            if( 'linkers' in tempdata ) {
                tempdata.linkers.forEach(function (linker) {
                    resourcesObject.forEach(function (record) {
                        if (linker == record.kid) {
                            var data = '';
                            if ('Name' in tempdata) {
                                data = tempdata.Name;
                            }
                            record['Excavation - Survey Associator'] = data;
                        }
                    })
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
            pageUrls.push(tempdata['Image Upload']['localName']); //collect image url stuff for later
            var uploadObject = {originalName:tempdata['Image Upload']['originalName'],text:tempdata['Image Upload']['localName']};
            tempdata['Image Upload'] = uploadObject;
        })
        xmlString = '';
        xmlString = objects2xmlString(pagesObject);
        xmlArray.push(xmlString);

        //nothing fancy for subject since it doesn't have a scheme below.
        xmlString = '';
        xmlString = objects2xmlString(subjectsObjectsArray);
        xmlArray.push(xmlString);

        //go to php for the pictures and zipping
        $.ajax({
            url: arcs.baseURL + "resources/export",
            type: "POST",
            data: {'xmls': xmlArray, 'picUrls': pageUrls},
            statusCode: {
                200: function (data) {
                    var blob = b64toBlob(data, 'application/zip'); //convert base64 to blob
                    var blobUrl = URL.createObjectURL(blob);    //create url

                    //add the blob url to and an a tag and click it
                    var a = document.createElement("a");
                    document.body.appendChild(a);
                    a.style = "display: none";
                    a.href = blobUrl;
                    a.download = 'Resource_data.zip'; //set file name
                    a.click();
                    window.URL.revokeObjectURL(blobUrl);
                    document.body.removeChild(a);   //remove the a tag
                },
                400: function () {
                    console.log("Bad Request");
                },
                405: function () {
                    console.log("Method Not Allowed");
                }
            }
        }).done(function(){
            //done exporting successful or not..
            console.log('export is done');
            $('.icon-export').css('background-image','url(/'+BASE_URL+'img/export.svg)');
            isExporting = 0;
        });


        function b64toBlob(b64Data, contentType, sliceSize) {
          contentType = contentType || '';
          sliceSize = sliceSize || 512;

          var byteCharacters = atob(b64Data);
          var byteArrays = [];

          for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            var slice = byteCharacters.slice(offset, offset + sliceSize);

            var byteNumbers = new Array(slice.length);
            for (var i = 0; i < slice.length; i++) {
              byteNumbers[i] = slice.charCodeAt(i);
            }

            var byteArray = new Uint8Array(byteNumbers);

            byteArrays.push(byteArray);
          }

          var blob = new Blob(byteArrays, {type: contentType});
          return blob;
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
