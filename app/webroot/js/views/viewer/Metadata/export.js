$(document).ready(function(){
    //export all schemes and jpgs
    var isExporting = 0;
    $("#export-btn").click(function () {
        if(isExporting == 1){
            return;
        }
        isExporting = 1;
        $('.icon-export').css('background-image','url(../img/arcs-preloader.gif)');
        //load data in variables
        //var schemes = SCHEMES;
        var projects = SCHEMES[0];
        var seasons = SCHEMES[1];
        var excavations = SCHEMES[2];
        var resources = SCHEMES[3];
        var subjects = SUBJECTS;
        var pages = PAGES;
        //build xmls for all the single records
        var xmlArray = [];

        var projectsObject = JSON.parse(projects);
        var seasonsObject = JSON.parse(seasons);
		var excavationsObjectArray = JSON.parse(excavations);
        var resourcesObject = JSON.parse(resources);
		resourcesObject['Excavation - Survey Associator'] = [];
        var pagesObjectsArray = [];
        pages.forEach(function (tempdata) {
            pagesObjectsArray.push( JSON.parse(tempdata) );
        })
        var subjectsObjectsArray = [];
        subjects.forEach(function (tempdata) {
            var subjectJson = JSON.parse(tempdata);
            if ('Pages Associator' in subjectJson) {
                delete subjectJson['Pages Associator'];
            }
            subjectsObjectsArray.push( subjectJson );
        })

        // handle project
        projectsObject.linkers.forEach(function (tempdata) {
            if( tempdata == seasonsObject.kid ){
                var data = '';
                if( 'Name' in projectsObject ){
                    data = projectsObject.Name;
                }
                seasonsObject['Project Associator'] = data;
            }
        })
        deleteTags(projectsObject);
        object2xml(projectsObject, xmlArray);

        // handle season
        if( 'linkers' in seasonsObject ) {
            seasonsObject.linkers.forEach(function (tempdata) {
				excavationsObjectArray.forEach(function (tempdata2) {
                    if (tempdata == tempdata2.kid) {
                        var data = '';
                        if ('Title' in seasonsObject) {
                        data = seasonsObject.Title;
                    }
                        tempdata2['Season Associator'] = data;
                    }
                })
                if (tempdata == resourcesObject.kid) {
                    var data = '';
                    if ('Title' in seasonsObject) {
                        data = seasonsObject.Title;
                    }
                    resourcesObject['Season Associator'] = data;
                }
            })
        }
        deleteTags(seasonsObject);
        object2xml(seasonsObject, xmlArray);

        // handle excavation
		var xmlString = '';
		excavationsObjectArray.forEach(function (tempdata) {
			if( 'linkers' in tempdata ) {
				tempdata.linkers.forEach(function (tempdata2) {
					if (tempdata2 == resourcesObject.kid) {
						var data = '';
						if ('Name' in tempdata) {
							data = tempdata.Name;
						}
						resourcesObject['Excavation - Survey Associator'].push(data);
					}
				})
			}
			deleteTags(tempdata);
            var recordObject = {Record: tempdata};
            var dataObject = {Data: recordObject};
            var trim = json2xml(dataObject, '').substring(23); //remove the <Data><ConsistentData/>
            trim = trim.substring(0, trim.length - 7);  //remove the </Data>
            xmlString += trim;
        })
        xmlString = '<' + '?xml version="1.0" encoding="ISO-8859-1"?' + '>\n<Data><ConsistentData/>' +
            xmlString + '</Data>';
        xmlArray.push(xmlString);

        //handle resource
        if( 'linkers' in resourcesObject ) {
            resourcesObject.linkers.forEach(function (tempdata) {
                pagesObjectsArray.forEach(function (tempdata2) {
                    if (tempdata == tempdata2.kid) {
                        var data = '';
                        if ('Resource Identifier' in resourcesObject) {
                            data = resourcesObject['Resource Identifier'];
                        }
                        tempdata2['Resource Identifier'] = data;
                    }
                })
            })
        }
        deleteTags(resourcesObject);
        object2xml(resourcesObject, xmlArray);

        //take care of the multiple pages
        xmlString = '';
        var pageUrls = [];
        pagesObjectsArray.forEach(function (tempdata) {
			console.log(tempdata);
            if( 'linkers' in tempdata ) {
                tempdata.linkers.forEach(function (tempdata2) {
                    subjectsObjectsArray.forEach(function (tempdata3) {
                        if (tempdata2 == tempdata3.kid) {
                            var data = '';
                            if ('Page Identifier' in tempdata) {
                                data = tempdata['Page Identifier'];
                            }
                            tempdata3['Pages Associator'] = data;
                        }
                    })
                })
            }
            deleteTags(tempdata);
            pageUrls.push(tempdata['Image Upload']['localName']); //collect image url stuff for later
            var uploadObject = {originalName:tempdata['Image Upload']['originalName'],text:tempdata['Image Upload']['localName']};
            tempdata['Image Upload'] = uploadObject;
            var recordObject = {Record: tempdata};
            var dataObject = {Data: recordObject};
            var trim = json2xml(dataObject, '').substring(23); //remove the <Data><ConsistentData/>
            trim = trim.substring(0, trim.length - 7);  //remove the </Data>
            xmlString += trim;
        })
        xmlString = '<' + '?xml version="1.0" encoding="ISO-8859-1"?' + '>\n<Data><ConsistentData/>' +
            xmlString + '</Data>';
        xmlArray.push(xmlString);

        //treat subject of observation differently since you can have multiple
        var xmlString = '';
        subjectsObjectsArray.forEach(function (tempdata) {
            deleteTags(tempdata);
            var recordObject = {Record: tempdata};
            var dataObject = {Data: recordObject};
            var trim = json2xml(dataObject, '').substring(23); //remove the <Data><ConsistentData/>
            trim = trim.substring(0, trim.length - 7);  //remove the </Data>
            xmlString += trim;
        })
        xmlString = '<' + '?xml version="1.0" encoding="ISO-8859-1"?' + '>\n<Data><ConsistentData/>' +
            xmlString + '</Data>';
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
            //console.log('here');
            $('.icon-export').css('background-image','url(../img/export.svg)');
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
        }
    }

    function object2xml( o, xmlArray ) {
        var recordObject = {Record: o};
        var dataObject = {Data: recordObject};
        var xmlString = json2xml(dataObject, '');
        xmlString = '<' + '?xml version="1.0" encoding="ISO-8859-1"?' + '>\n' + xmlString;
        xmlArray.push(xmlString);
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