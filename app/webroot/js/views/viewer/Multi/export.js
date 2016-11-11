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
        var schemes = [PROJECTS, SEASONS, EXCAVATIONS, RESOURCES];
        //console.log(schemes);
        var pages = {};
        var subjects = SUBJECTS;
        var pageUrls = [];
        //build xmls for all the single records
        var xmlArray = [];
        //schemes.forEach(function (tempdata) {
        for( var i=0; i< schemes.length; i++){
            //build the all the records into a json encoded array.
            var schemeString = '[';
            for( var index in schemes[i] ){
                schemeString += JSON.stringify(schemes[i][index]) +',';
            }
            schemeString = schemeString.substring(0, schemeString.length -1 ); //remove last comma
            schemeString += ']';

            var jsonObject = JSON.parse(schemeString);//get array of json objects
            jsonObject.forEach(function(tempRecordObject){ //remove the extra backend tags.
                if( 'thumb' in tempRecordObject ){
                    delete tempRecordObject.thumb;
                }
                if( 'linkers' in tempRecordObject ){
                    delete tempRecordObject.linkers;
                }
                if( 'project_kid' in tempRecordObject ){
                    delete tempRecordObject.project_kid;
                }
                if( 'page' in tempRecordObject ){
                    var page = tempRecordObject.page;
                    for( var key in page ){
                        pages[key] = page[key];
                    }
                    delete tempRecordObject.page;
                }
                //get page urls for the images in php later
                if( 'Image Upload' in tempRecordObject && 'localName' in tempRecordObject['Image Upload']){
                    var url = tempRecordObject['Image Upload']['localName'];
                    if( $.inArray(url, pageUrls) == -1 ) {//make sure not a duplicate
                        pageUrls.push(url);
                    }
                }
            })
            if(!$.isEmptyObject(pages)){ // add in the pages and subjects after done with resource
                schemes.push(subjects);
                schemes.push(pages);
                pages = {};
            }
            //wrap the data in a record and data tag
            var recordObject = {Record: jsonObject};
            var dataObject = {Data: recordObject};
            var xmlString = json2xml(dataObject, ''); //convert the array into xml tags
            xmlString = '<' + '?xml version="1.0" encoding="ISO-8859-1"?' + '>\n' + xmlString; //header
            xmlArray.push(xmlString);  //done
        }
        //console.log(xmlArray);
        //console.log(pageUrls);
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
