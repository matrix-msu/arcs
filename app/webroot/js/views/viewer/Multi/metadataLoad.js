function generateMetadata(schemename, data, metadataEdits, controlOptions, flags) {
    var counter = 0;

	var html = '<h3 class="level-tab '+schemename+'" >'+schemename;
	html += '<span class="metadata-edit-btn" style="visibility:hidden;" >Edit</span></h3>';
	html += '<div class="level-content" style="display:none;">';
	html += '<div class="accordion metadata-accordion excavation-div">';

	if (schemename == 'subjects') {
		html += '<div id="soo"><ul>';
        if (Object.keys(data).length > 0) {
            var count=0, page_associator='';
            for (key in data) {
                var subject = data[key];
                count++;
                html += '<li class="soo-li"';
                if (subject['Pages Associator'] != undefined && subject['Pages Associator'][0] != undefined) {
                    html += 'data-pageKid="'+subject['Pages Associator'][0]+'" data-sooKid="'+subject['kid']+'"';
                    if (subject['Pages Associator'] != page_associator) {
                        page_associator = subject['Pages Associator'][0];
                        count = 1;
                    }
                };
                html += '><a href="#soo-'+count+'" class="soo-click'+count+' soo-click">'+count+'</a></li>';
            }
        }
        html += '</ul><div class="level-content soo">';
	}
	if (schemename != 'excavations' && schemename != 'subjects' && schemename != 'Seasons') {
		html += '<div class="level-content">';
	}
	var controlTypes = {
		'project' : {
            'Name' : 'text',
            'Country' : 'list',
            'Region' : 'list',
            'Geolocation' : 'multi_input',
            'Modern Name' : 'list',
            'Location Identifier' : 'text',
            'Location Identifier Scheme' : 'text',
            'Elevation' : 'text',
            'Earliest Date' : 'date',
            'Latest Date' : 'date',
            'Records Archive' : 'multi_select',
            'Persistent Name' : 'text',
            'Complex Title' : 'text',
            'Terminus Ante Quem' : 'terminus',
            'Terminus Post Quem' : 'terminus',
            'Period' : 'multi_select',
            'Archaeological Culture' : 'multi_select',
            'Description' : 'text',
            'Brief Description' : 'text',
            'Permitting Heritage Body' : 'multi_select'
		},
		'Seasons' : {
            'Project Associator' : 'associator',
            'Title' : 'text',
            'Type' : 'multi_select',
            'Director' : 'multi_select',
            'Registrar' : 'multi_select',
            'Sponsor' : 'multi_select',
            'Earliest Date' : 'date',
            'Latest Date' : 'date',
            'Terminus Ante Quem' : 'terminus',
            'Terminus Post Quem' : 'terminus',
            'Description' : 'text',
            'Contributor' : 'list',
            'Contributor Role' : 'multi_select',
            'Contributor 2' : 'list',
            'Contributor Role 2' : 'multi_select',
            'Contributor 3' : 'list',
            'Contributor Role 3' : 'multi_select',
            'Contributor 4' : 'list',
            'Contributor Role 4' : 'multi_select',
            'Contributor 5' : 'list',
            'Contributor Role 5' : 'multi_select',
            'Contributor 6' : 'list',
            'Contributor Role 6' : 'multi_select',
            'Contributor 7' : 'list',
            'Contributor Role 7' : 'multi_select',
            'Contributor 8' : 'list',
            'Contributor Role 8' : 'multi_select',
            'Contributor 9' : 'list',
            'Contributor Role 9' : 'multi_select'
		},
		'excavations' : {
            'Season Associator' : 'associator',
            'Name' : 'text',
            'Type' : 'list',
            'Supervisor' : 'multi_select',
            'Earliest Date' : 'date',
            'Latest Date' : 'date',
            'Terminus Ante Quem' : 'terminus',
            'Terminus Post Quem' : 'terminus',
            'Excavation Stratigraphy' : 'text',
            'Survey Conditions' : 'text',
            'Post Dispositional Transformation' : 'text',
            'Legacy' : 'text'
		},
		'archival objects' : {
            'Excavation - Survey Associator' : 'associator',
            'Season Associator' : 'associator',
            'Resource Identifier' : 'text',
            'Type' : 'list',
            'Title' : 'text',
            'Creator' : 'multi_select',
            'Creator Role' : 'multi_select',
            'Earliest Date' : 'date',
            'Date Range' : 'text',
            'Description' : 'text',
            'Pages' : 'text',
            'Condition' : 'list',
            'Accession Number' : 'text'
		},
		'subjects' : {
            'Pages Associator' : 'associator',
            'Resource Identifier' : 'text',
            'Subject of Observation Associator' : 'associator',
            'Artifact - Structure Classification' : 'list',
            'Artifact - Structure Type' : 'multi_select',
            'Artifact - Structure Terminus Ante Quem' : 'terminus',
            'Artifact - Structure Terminus Post Quem' : 'terminus',
            'Artifact - Structure Title' : 'text',
            'Artifact - Structure Geolocation' : 'multi_select',
            'Artifact - Structure Excavation Unit' : 'multi_select',
            'Artifact - Structure Description' : 'text',
            'Artifact - Structure Location' : 'multi_select'
		}
	}
    for (key in data) {
      console.log('item');
      console.log(item);
      console.log('control');
      console.log(control);
        var item = data[key];
        counter++;
        if (schemename == 'excavations' || schemename == 'Seasons') {
            var prefix = schemename.substring(0, schemename.length-1).toLowerCase();
            var excavationClass = prefix + '-tab-head';
            var excavationSmallClass = prefix + '-tab-content';
            html += '<h3 class="level-tab '+excavationClass+'" data-kid="'+item['kid']+'">'+schemename+' Level '+counter+'</h2>';
            html += '<div class="level-content smaller '+excavationSmallClass+'" data-kid="'+item['kid']+'">';
        }
        html += '<table id="'+schemename+counter+'" class="'+schemename+'-table" data-scheme="'+schemename+'" data-kid="'+item['kid']+'">';
        for (control in controlTypes[schemename]) {
            type = controlTypes[schemename][control];
            var text = '';
            if(type == 'text' || type == 'list') {
                text = item[control];
            }
            else if(type == 'multi_input' || type == 'multi_select' || type == 'associator') {
                if(typeof item[control] != "string"){
                    for (var i = 0; i < item[control].length; i++) {
                        text += item[control][i]+"<br>";
                    }
                }
            }
            else if (type == 'date') {
                if (typeof item[control] != "string") {
                    text += item[control]['year'] + "-" + item[control]['month'] + "-" +
                            item[control]['day'] + " " + item[control]['era'];
                }
            }
            else if(type == 'terminus'){
                if(typeof item[control] != "string"){
                    if(item[control]['prefix']){
                        text = item[control]['prefix'] + " ";
                    }
                    text += item[control]['year'] + "-" +
                             item[control]['month'] + "-" +
                             item[control]['day'] + " " +
                             item[control]['era'];
                }
            }
            var options = '';
            var tmpControl = control;
            if(tmpControl.indexOf("Contributor Role ") == 0) {
                tmpControl = "Contributor Role";
                if( text == '' ){
                    continue;
                }
            }
            else if(tmpControl.indexOf("Contributor ") == 0 && tmpControl != 'Contributor Role') {
                tmpControl = "Contributor";
                if( text == '' ){
                    continue;
                }
            }

            if (controlOptions[schemename][tmpControl] != undefined) {
                options = ' data-options="'+controlOptions[schemename][tmpControl]+'"';
            }

            //check if the metadata has been flagged
            var flagged = "<div class='icon-meta-flag'>&nbsp;</div>";
            if(flags.hasOwnProperty(item['kid']) && flags[item['kid']].hasOwnProperty(control)) {
                flagged = "<div class='icon-meta-flag-red'>&nbsp;</div>";
            }

            extraString = " class='metadataEdit'>"+flagged+"<div id='"+control+"' data-control='"+type+"'"+options+">"+text+"</div>";
            if(control == 'Persistent Name'){
                extraString = " >"+flagged+"<div id='"+control+"' data-control='"+type+"'"+options+">"+text+"</div>";
            }
            //there is an edited metadata, so string is this
            if(metadataEdits.hasOwnProperty(item['kid']) && metadataEdits[item['kid']].hasOwnProperty(control)) {
                extraString = '><div class="icon-meta-lock">&nbsp;</div><div>Pending Approval</div>';
            }

            html += "<tr><td>"+control+"</td><td"+extraString+"</td></tr>";
        }
        html += '</table>';
        if(schemename == 'excavations' || schemename == 'Seasons' ){
            html += '</div>';
        }
    }
    if(schemename != 'excavations' && schemename != 'Seasons'   ){
        html += '</div>';
    }
    html += '</div></div>';
    return html;
}
