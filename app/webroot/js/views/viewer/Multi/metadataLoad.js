function generateMetadata(schemename, data, metadataEdits, controlOptions, flags) {
    var counter = 0;

	var html = '<h3 class="level-tab '+schemename+'" >';
	if( schemename === 'archival objects' ){
	    html += 'Resource (archival document)';
    }else{
	    html += schemename;
    }
	html += '<span class="metadata-edit-btn" style="visibility:hidden;" >Edit</span></h3>';
	html += '<div class="level-content" style="display:none;">';
	html += '<div class="accordion metadata-accordion excavation-div">';

	if (schemename == 'subjects') {
		html += '<div id="soo"><ul>';
        if (Object.keys(data).length > 0) {
            var count=0, page_associator='';
            for (key in data) {
              count++;
                var subject = data[key];
                html += '<li class="soo-li"';
                if (subject['Pages Associator'] != undefined && subject['Pages Associator'][0] != undefined) {
                    html += 'data-pageKid="'+subject['Pages Associator'][0]+'" data-sooKid="'+subject['kid']+'"';
                }
                html += '><a href="#soo-'+count+'" class="soo-click'+count+' soo-click">';
                if (subject['Pages Associator'][0] != page_associator) {
                    page_associator = subject['Pages Associator'][0];
                    count = 1;
                }
                html += count+'</a></li>';
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
          'Modern Name' : 'list',
          'Persistent Name' : 'text',
          'Location Identifier' : 'text',
          'Location Identifier Scheme' : 'text',
          'Geolocation' : 'multi_input',
          'Elevation' : 'text',
          'Records Archive' : 'multi_select',
          'Complex Title' : 'text',
          'Earliest Date' : 'date',
          'Latest Date' : 'date',
          'Terminus Ante Quem' : 'terminus',
          'Terminus Post Quem' : 'terminus',
          'Period' : 'multi_select',
          'Archaeological Culture' : 'multi_select',
          'Description' : 'text',
          //'Brief Description' : 'text',
          'Permitting Heritage Body' : 'multi_select'
      },
      'Seasons' : {
          //'Project Associator' : 'associator',
          'Title' : 'text',
          'Type' : 'multi_select',
          'Sponsor' : 'multi_select',
          'Director' : 'multi_select',
          'Registrar' : 'multi_select',
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
          'Contributor Role 9' : 'multi_select',
          'Earliest Date' : 'date',
          'Latest Date' : 'date',
          'Terminus Ante Quem' : 'terminus',
          'Terminus Post Quem' : 'terminus',
          'Description' : 'text'
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
          'Post Dispositional Transformation' : 'text'
      },
      'archival objects' : {
          'Excavation - Survey Associator' : 'associator',
          'Season Associator' : 'associator',
          'Resource Identifier' : 'text',
          'Type' : 'list',
          'Title' : 'text',
          'Sub-title' : 'text',
          'Repository' : 'list',
          'Accession Number' : 'text',
          'Creator' : 'multi_select',
          'Creator Role' : 'multi_select',
          'Earliest Date' : 'date',
          'Latest Date' : 'date',
          'Dimensions' : 'multi_input',
          //'Date Range' : 'text',
          'Language' : 'multi_select',
          'Description' : 'text',
          'Pages' : 'text',
          'Rights' : 'text',
          'Rights Holder' : 'multi_select',
      },
      'subjects' : {
          'Pages Associator' : 'associator',
          //'Resource Identifier' : 'text',
          'Subject of Observation Associator' : 'associator',
          'Artifact - Structure Classification' : 'list',
          'Artifact - Structure Type' : 'multi_select',
          'Artifact - Structure Type Qualifier' : 'text',
          'Artifact - Structure Material' : 'multi_select',
          'Artifact - Structure Technique' : 'multi_select',
          'Artifact - Structure Terminus Ante Quem' : 'terminus',
          'Artifact - Structure Terminus Post Quem' : 'terminus',
          'Artifact - Structure Period' : 'multi_select',
          'Artifact - Structure Archaeological Culture' : 'multi_select',

          'Artifact - Structure Title' : 'text',
          'Artifact - Structure Creator' : 'multi_select',
          'Artifact - Structure Creator Role' : 'multi_select',
          'Artifact - Structure Dimensions' : 'multi_input',
          'Artifact - Structure Excavation Unit' : 'multi_select',
          'Artifact - Structure Location' : 'multi_select',
          'Artifact - Structure Geolocation' : 'multi_select',
          'Artifact - Structure Current Location' : 'list',
          'Artifact - Structure Repository' : 'list',
          'Artifact - Structure Repository Accession Number' : 'text',
          'Artifact - Structure Description' : 'text',
          'Artifact - Structure Condition' : 'multi_select',
          'Artifact - Structure Inscription' : 'text',
          'Artifact - Structure Munsell Number' : 'text',
          'Artifact - Structure Date' : 'date',
          'Artifact - Structure Subject' : 'multi_select',
          'Artifact - Structure Origin' : 'list',
          'Artifact - Structure Comparanda' : 'text',
          'Artifact - Structure Archaeological Context' : 'text',
          'Artifact - Structure Shelving Location' : 'text'
      }
  };


  var controlDisplayNames = {
      'project' : {
          'Name' : 'Name',
          'Country' : 'Country',
          'Region' : 'Geographic Region',
          'Modern Name' : 'ModernPlacename',
          'Location Identifier' : 'Location',
          'Location Identifier Scheme' : 'Location Source',
          'Geolocation' : 'Coordinates',
          'Elevation' : 'Elevation',
          'Earliest Date' : 'Earliest Research Activity',
          'Latest Date' : 'Latest Research Activity',
          'Records Archive' : 'Archive / Repository',
          'Persistent Name' : 'Common Name',
          'Complex Title' : 'Associated Institution(s)',
          'Terminus Ante Quem' : 'Earliest Cultural Activity',
          'Terminus Post Quem' : 'Latest Cultural Activity',
          'Period' : 'Period(s) of Cultural Activity',
          'Archaeological Culture' : 'Archaeological Culture',
          'Description' : 'Full Description',
          //'Brief Description' : 'text',
          'Permitting Heritage Body' : 'Permitting Heritage Body'
      },
      'Seasons' : {
          //'Project Associator' : 'associator',
          'Title' : 'Title',
          'Type' : 'Research Activity',
          'Director' : 'Director(s)',
          'Registrar' : 'Registrar(s)',
          'Sponsor' : 'Sponsor(s)',
          'Contributor' : 'Contributor(s)',
          'Contributor Role' : 'Contributor Role(s)',
          'Contributor 2' : 'Contributor(s)',
          'Contributor Role 2' : 'Contributor Role(s)',
          'Contributor 3' : 'Contributor(s)',
          'Contributor Role 3' : 'Contributor Role(s)',
          'Contributor 4' : 'Contributor(s)',
          'Contributor Role 4' : 'Contributor Role(s)',
          'Contributor 5' : 'Contributor(s)',
          'Contributor Role 5' : 'Contributor Role(s)',
          'Contributor 6' : 'Contributor(s)',
          'Contributor Role 6' : 'Contributor Role(s)',
          'Contributor 7' : 'Contributor(s)',
          'Contributor Role 7' : 'Contributor Role(s)',
          'Contributor 8' : 'Contributor(s)',
          'Contributor Role 8' : 'Contributor Role(s)',
          'Contributor 9' : 'Contributor(s)',
          'Contributor Role 9' : 'Contributor Role(s)',
          'Earliest Date' : 'Beginning of Season',
          'Latest Date' : 'End of Season',
          'Terminus Ante Quem' : 'Earliest Cultural Activity for Season',
          'Terminus Post Quem' : 'Latest Cultural Activity for Season',
          'Description' : 'Description of Season Activity'
      },
      'excavations' : {
          'Season Associator' : 'Season(s) when Study took place',
          'Name' : 'Unit of Study',
          'Type' : 'Type of Study',
          'Supervisor' : 'Supervisor(s)',
          'Earliest Date' : 'Beginning of Study',
          'Latest Date' : 'End of Study',
          'Terminus Ante Quem' : 'Earliest Cultural Activity for Study Unit',
          'Terminus Post Quem' : 'Latest Cultural Activity for Study Unit',
          'Excavation Stratigraphy' : 'Description of Stratigraphy',
          'Survey Conditions' : 'Description of Survey',
          'Post Dispositional Transformation' : 'Post-Depositional Activity'
      },
      'archival objects' : {
          'Excavation - Survey Associator' : 'Study(s) when Resource was created',
          'Season Associator' : 'Season(s) when Resource was created',
          'Resource Identifier' : 'Resource Identifier',
          'Type' : 'Resource Type',
          'Title' : 'Title',
          'Sub-title' : 'Sub-title',
          'Creator' : 'Author/Creator',
          'Creator Role' : 'Author/Creator Role',
          'Earliest Date' : 'Earliest Date of Resource',
          'Latest Date' : 'Latest Date of Resource',
          'Dimensions' : 'Dimensions',
          'Language' : 'Language(s)',
          'Description' : 'Description of Resource',
          'Pages' : 'Number of Pages',
          'Rights' : 'Rights',
          'Rights Holder' : 'Rights Holder',
          'Repository' : 'Archive / Repository',
          'Accession Number' : 'Accession/Catalogue Number(s)',
      },
      'subjects' : {
          'Pages Associator' : 'Page ID with Topic Info',
          //'Resource Identifier' : 'text',
          'Subject of Observation Associator' : 'Other Records with Topic Info',
          'Artifact - Structure Classification' : 'Artifact / Structure Classification',
          'Artifact - Structure Type' : 'Artifact / Structure Type',
          'Artifact - Structure Type Qualifier' : 'Type Qualifier',
          'Artifact - Structure Material' : 'Artifact / Structure Material',
          'Artifact - Structure Technique' : 'Manufacturing technique',
          'Artifact - Structure Archaeological Culture' : 'Associated Archaeological Culture',
          'Artifact - Structure Period' : 'Artifact / Structure Period',
          'Artifact - Structure Terminus Ante Quem' : 'Earliest Possible Date of Artifact / Structure',
          'Artifact - Structure Terminus Post Quem' : 'Latest Possible Date of Artifact / Structure',

          'Artifact - Structure Title' : 'Title of Artifact / Structure',
          'Artifact - Structure Location' : 'Project-specific Location',
          'Artifact - Structure Current Location' : 'Current Location of Artifact / Structure',
          'Artifact - Structure Repository' : 'Storage / Repository',
          'Artifact - Structure Repository Accession Number' : 'Accession Number',
          'Artifact - Structure Creator' : 'Artifact / Structure Creator',
          'Artifact - Structure Creator Role' : 'Creator Role',
          'Artifact - Structure Dimensions' : 'Artifact / Structure Dimensions',
          'Artifact - Structure Geolocation' : 'Artifact / Structure Coordinates',
          'Artifact - Structure Excavation Unit' : 'Artifact / Structure Survey / Excavation Unit',
          'Artifact - Structure Location' : 'Project-specific Location',
          'Artifact - Structure Description' : 'Artifact / Structure Description',
          'Artifact - Structure Condition' : 'Artifact / Structure Condition',
          'Artifact - Structure Inscription' : 'Inscribed text',
          'Artifact - Structure Munsell Number' : 'Artifact / Structure Color(s)',
          'Artifact - Structure Date' : 'Precise Date of Artifact / Structure',
          'Artifact - Structure Subject' : 'Subject of Artifact / Structure',
          'Artifact - Structure Origin' : 'Point of Origin',
          'Artifact - Structure Comparanda' : 'Comparative examples',
          'Artifact - Structure Archaeological Context' : 'Archaeological context',
          'Artifact - Structure Shelving Location' : 'Location in repository'
      }
  };


    for (key in data) {
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
        var matchContributor = false;
        var firstEmptyContributor = true;
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
            if( matchContributor == true ) {
                tmpControl = "Contributor Role";
                matchContributor = false;
            }
            else if(tmpControl.indexOf("Contributor ") == 0 && tmpControl != 'Contributor Role') {
                tmpControl = "Contributor";
                if( text == '' ){
                    if( firstEmptyContributor == true ){
                        firstEmptyContributor = false;
                    }else{
                        continue;
                    }
                }
                matchContributor = true;
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

            displayedControlName = controlDisplayNames[schemename][tmpControl];
            html += "<tr><td>"+displayedControlName+"</td><td"+extraString+"</td></tr>";
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
