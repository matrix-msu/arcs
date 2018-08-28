function generateMetadata(schemename, data, metadataEdits, controlOptions, flags, aboveScheme=false, aboveTwoSchemes=false) {
    var counter = 0;

    var controlTypes = {
        'project': {
            'Name': 'text',
            'Country': 'list',
            'Region': 'list',
            'Modern_Name': 'list',
            'Persistent_Name': 'text',
            'Location_Identifier': 'text',
            'Location_Identifier_Scheme': 'text',
            'Geolocation': 'multi_input',
            'Elevation': 'text',
            'Records_Archive': 'multi_select',
            'Complex_Title': 'text',
            'Earliest_Date': 'date',
            'Latest_Date': 'date',
            'Terminus_Ante_Quem': 'terminus',
            'Terminus_Post_Quem': 'terminus',
            'Period': 'multi_select',
            'Archaeological_Culture': 'multi_select',
            'Description': 'text',
            //'Brief Description' : 'text',
            'Permitting_Heritage_Body': 'multi_select'
        },
        'Seasons': {
            //'Project Associator' : 'associator',
            'Title': 'text',
            'Type': 'multi_select',
            'Sponsor': 'multi_select',
            'Director': 'multi_select',
            'Registrar': 'multi_select',
            'Contributor': 'list',
            'Contributor_Role': 'multi_select',
            'Contributor_2': 'list',
            'Contributor_Role_2': 'multi_select',
            'Contributor_3': 'list',
            'Contributor_Role_3': 'multi_select',
            'Contributor_4': 'list',
            'Contributor_Role_4': 'multi_select',
            'Contributor_5': 'list',
            'Contributor_Role_5': 'multi_select',
            'Contributor_6': 'list',
            'Contributor_Role_6': 'multi_select',
            'Contributor_7': 'list',
            'Contributor_Role_7': 'multi_select',
            'Contributor_8': 'list',
            'Contributor_Role_8': 'multi_select',
            'Contributor_9': 'list',
            'Contributor_Role_9': 'multi_select',
            'Earliest_Date': 'date',
            'Latest_Date': 'date',
            'Terminus_Ante_Quem': 'terminus',
            'Terminus_Post_Quem': 'terminus',
            'Description': 'text'
        },
        'excavations': {
            'Season_Associator': 'associator',
            'Name': 'text',
            'Type': 'list',
            'Supervisor': 'multi_select',
            'Earliest_Date': 'date',
            'Latest_Date': 'date',
            'Terminus_Ante_Quem': 'terminus',
            'Terminus_Post_Quem': 'terminus',
            'Excavation_Stratigraphy': 'text',
            'Survey_Conditions': 'text',
            'Post_Dispositional_Transformation': 'text'
        },
        'archival objects': {
            'URL': 'url',
            'Excavation_-_Survey_Associator': 'associator',
            'Season_Associator': 'associator',
            'Resource_Identifier': 'text',
            'Type': 'list',
            'Title': 'text',
            'Sub-title': 'text',
            'Repository': 'list',
            'Accession_Number': 'text',
            'Creator': 'multi_select',
            'Creator_Role': 'multi_select',
            'Earliest_Date': 'date',
            'Latest_Date': 'date',
            'Dimensions': 'multi_input',
            //'Date Range' : 'text',
            'Language': 'multi_select',
            'Description': 'text',
            'Pages': 'text',
            'Rights': 'text',
            'Rights_Holder': 'multi_select',
        },
        'subjects': {
            'Pages_Associator': 'associator',
            //'Resource Identifier' : 'text',
            'Subject_of_Observation_Associator': 'associator',
            'Artifact_-_Structure_Classification': 'list',
            'Artifact_-_Structure_Type': 'multi_select',
            'Artifact_-_Structure_Type_Qualifier': 'text',
            'Artifact_-_Structure_Material': 'multi_select',
            'Artifact_-_Structure_Technique': 'multi_select',
            'Artifact_-_Structure_Terminus_Ante_Quem': 'terminus',
            'Artifact_-_Structure_Terminus_Post_Quem': 'terminus',
            'Artifact_-_Structure_Period': 'multi_select',
            'Artifact_-_Structure_Archaeological_Culture': 'multi_select',

            'Artifact_-_Structure_Title': 'text',
            'Artifact_-_Structure_Creator': 'multi_select',
            'Artifact_-_Structure_Creator_Role': 'multi_select',
            'Artifact_-_Structure_Dimensions': 'multi_input',
            'Artifact_-_Structure_Excavation_Unit': 'multi_select',
            'Artifact_-_Structure_Location': 'multi_select',
            'Artifact_-_Structure_Geolocation': 'multi_input',
            'Artifact_-_Structure_Current_Location': 'list',
            'Artifact_-_Structure_Repository': 'list',
            'Artifact_-_Structure_Repository_Accession_Number': 'text',
            'Artifact_-_Structure_Description': 'text',
            'Artifact_-_Structure_Condition': 'multi_select',
            'Artifact_-_Structure_Inscription': 'text',
            'Artifact_-_Structure_Munsell_Number': 'text',
            'Artifact_-_Structure_Date': 'date',
            'Artifact_-_Structure_Subject': 'multi_select',
            'Artifact_-_Structure_Origin': 'list',
            'Artifact_-_Structure_Comparanda': 'text',
            'Artifact_-_Structure_Archaeological_Context': 'text',
            'Artifact_-_Structure_Shelving_Location': 'text'
        }
    };


    var controlDisplayNames = {
        'project': {
            'Name': 'Name',
            'Country': 'Country',
            'Region': 'Geographic Region',
            'Modern_Name': 'ModernPlacename',
            'Location_Identifier': 'Location',
            'Location_Identifier_Scheme': 'Location Source',
            'Geolocation': 'Coordinates',
            'Elevation': 'Elevation',
            'Earliest_Date': 'Earliest Research Activity',
            'Latest_Date': 'Latest Research Activity',
            'Records_Archive': 'Archive / Repository',
            'Persistent_Name': 'Common Name',
            'Complex_Title': 'Associated Institution(s)',
            'Terminus_Ante_Quem': 'Earliest Cultural Activity',
            'Terminus_Post_Quem': 'Latest Cultural Activity',
            'Period': 'Period(s) of Cultural Activity',
            'Archaeological_Culture': 'Archaeological Culture',
            'Description': 'Full Description',
            //'Brief Description' : 'text',
            'Permitting_Heritage_Body': 'Permitting Heritage Body'
        },
        'Seasons': {
            //'Project Associator' : 'associator',
            'Title': 'Title',
            'Type': 'Research Activity',
            'Director': 'Director(s)',
            'Registrar': 'Registrar(s)',
            'Sponsor': 'Sponsor(s)',
            'Contributor': 'Contributor(s)',
            'Contributor_Role': 'Contributor Role(s)',
            'Contributor_2': 'Contributor(s)',
            'Contributor_Role_2': 'Contributor Role(s)',
            'Contributor_3': 'Contributor(s)',
            'Contributor_Role_3': 'Contributor Role(s)',
            'Contributor_4': 'Contributor(s)',
            'Contributor_Role_4': 'Contributor Role(s)',
            'Contributor_5': 'Contributor(s)',
            'Contributor_Role_5': 'Contributor Role(s)',
            'Contributor_6': 'Contributor(s)',
            'Contributor_Role_6': 'Contributor Role(s)',
            'Contributor_7': 'Contributor(s)',
            'Contributor_Role_7': 'Contributor Role(s)',
            'Contributor_8': 'Contributor(s)',
            'Contributor_Role_8': 'Contributor Role(s)',
            'Contributor_9': 'Contributor(s)',
            'Contributor_Role_9': 'Contributor Role(s)',
            'Earliest_Date': 'Beginning of Season',
            'Latest_Date': 'End of Season',
            'Terminus_Ante_Quem': 'Earliest Cultural Activity for Season',
            'Terminus_Post_Quem': 'Latest Cultural Activity for Season',
            'Description': 'Description of Season Activity'
        },
        'excavations': {
            'Season_Associator': 'Season(s) when Study took place',
            'Name': 'Unit of Study',
            'Type': 'Type of Study',
            'Supervisor': 'Supervisor(s)',
            'Earliest_Date': 'Beginning of Study',
            'Latest_Date': 'End of Study',
            'Terminus_Ante_Quem': 'Earliest Cultural Activity for Study Unit',
            'Terminus_Post_Quem': 'Latest Cultural Activity for Study Unit',
            'Excavation_Stratigraphy': 'Description of Stratigraphy',
            'Survey_Conditions': 'Description of Survey',
            'Post_Dispositional_Transformation': 'Post-Depositional Activity'
        },
        'archival objects': {
            'URL': 'Stable URL',
            'Excavation_-_Survey_Associator': 'Study(s) when Resource was created',
            'Season_Associator': 'Season(s) when Resource was created',
            'Resource_Identifier': 'Resource Identifier',
            'Type': 'Resource Type',
            'Title': 'Title',
            'Sub-title': 'Sub-title',
            'Creator': 'Author/Creator',
            'Creator_Role': 'Author/Creator Role',
            'Earliest_Date': 'Earliest Date of Resource',
            'Latest_Date': 'Latest Date of Resource',
            'Dimensions': 'Dimensions',
            'Language': 'Language(s)',
            'Description': 'Description of Resource',
            'Pages': 'Number of Pages',
            'Rights': 'Rights',
            'Rights_Holder': 'Rights Holder',
            'Repository': 'Archive / Repository',
            'Accession_Number': 'Accession/Catalogue Number(s)',
        },
        'subjects': {
            'Pages_Associator': 'Page ID with Topic Info',
            //'Resource Identifier' : 'text',
            'Subject_of_Observation_Associator': 'Other Records with Topic Info',
            'Artifact_-_Structure_Classification': 'Artifact / Structure Classification',
            'Artifact_-_Structure_Type': 'Artifact / Structure Type',
            'Artifact_-_Structure_Type_Qualifier': 'Type Qualifier',
            'Artifact_-_Structure_Material': 'Artifact / Structure Material',
            'Artifact_-_Structure_Technique': 'Manufacturing technique',
            'Artifact_-_Structure_Archaeological_Culture': 'Associated Archaeological Culture',//broken
            'Artifact_-_Structure_Period': 'Artifact / Structure Period',
            'Artifact_-_Structure_Terminus_Ante_Quem': 'Earliest Possible Date of Artifact / Structure',
            'Artifact_-_Structure_Terminus_Post_Quem': 'Latest Possible Date of Artifact / Structure',

            'Artifact_-_Structure_Title': 'Title of Artifact / Structure',
            'Artifact_-_Structure_Location': 'Project-specific Location',
            'Artifact_-_Structure_Current_Location': 'Current Location of Artifact / Structure',
            'Artifact_-_Structure_Repository': 'Storage / Repository',
            'Artifact_-_Structure_Repository_Accession_Number': 'Accession Number',
            'Artifact_-_Structure_Creator': 'Artifact / Structure Creator',
            'Artifact_-_Structure_Creator_Role': 'Creator Role',
            'Artifact_-_Structure_Dimensions': 'Artifact / Structure Dimensions',
            'Artifact_-_Structure_Geolocation': 'Artifact / Structure Coordinates',
            'Artifact_-_Structure_Excavation_Unit': 'Artifact / Structure Survey / Excavation Unit',
            'Artifact_-_Structure_Location': 'Project-specific Location',
            'Artifact_-_Structure_Description': 'Artifact / Structure Description',
            'Artifact_-_Structure_Condition': 'Artifact / Structure Condition',
            'Artifact_-_Structure_Inscription': 'Inscribed text',
            'Artifact_-_Structure_Munsell_Number': 'Artifact / Structure Color(s)',
            'Artifact_-_Structure_Date': 'Precise Date of Artifact / Structure',
            'Artifact_-_Structure_Subject': 'Subject of Artifact / Structure',//broken
            'Artifact_-_Structure_Origin': 'Point of Origin',
            'Artifact_-_Structure_Comparanda': 'Comparative examples',
            'Artifact_-_Structure_Archaeological_Context': 'Archaeological context',
            'Artifact_-_Structure_Shelving_Location': 'Location in repository'
        }
    };

    var html = '<h3 class="level-tab ' + schemename + '" >';
    html += '<div class="drawer-inline-block drawer-name-text-' + schemename + '">';
    if (schemename === 'archival objects') {
        html += 'Resource (archival document)';
    } else {
        html += schemename;
    }
    html += '</div>';
    html += '<span class="metadata-edit-btn" style="visibility:hidden;" >Edit</span></h3>';
    html += '<div class="level-content" style="display:none;">';
    html += '<div class="accordion metadata-accordion excavation-div">';

    if (schemename == 'subjects') {
        html += '<div id="soo"><ul>';
        if (Object.keys(data).length > 0) {
            var count = 0, page_associator = '';
            for (key in data) {
                count++;
                var subject = data[key];
                html += '<li class="soo-li"';
                if (subject['Pages_Associator'] != undefined && subject['Pages_Associator'][0] != undefined) {
                    html += 'data-pageKid="' + subject['Pages_Associator'][0] + '" data-sooKid="' + subject['kid'] + '"';
                }
                html += '><a href="#soo-' + count + '" class="soo-click' + count + ' soo-click">';
                if (subject['Pages_Associator'][0] != page_associator) {
                    page_associator = subject['Pages_Associator'][0];
                }
                html += count + '</a></li>';
            }
        }
        html += '</ul><div class="level-content soo">';
    } else if (schemename == 'excavations') {
        html += '<div id="soo"><ul>';
        if (Object.keys(data).length > 0) {
            var count = 0;
            for (key in data) {
                count++;
                var excavation = data[key];
                html += '<li class="excavation-li" class="metadata-accordion ul" data-kid="' + excavation['kid'] + '">';
                html += '<a href="#excavations' + count + '" class="excavation-click' + count + ' excavation-click">';
                html += count + '</a></li>';
            }
        }
        html += '</ul><div class="excavation-tab-content" data-kid="';
        if (typeof excavation !== 'undefined') {
            html += excavation['kid'];
        } else {
            html += '';
        }
        html += '">';
    } else if (schemename == 'Seasons') {
        html += '<div style="margin-top:0px;">';
        html += '<ul style="top:-1px;position:relative;height:24px;">';
        if (Object.keys(data).length > 0) {
            var count = 0;
            for (key in data) {
                count++;
                var season = data[key];
                html += '<li class="season-li season-li-bubble-css"  class="metadata-accordion ul" ';
                html += ' data-kid = ' + season["kid"] + '>';
                html += '<a href="#Seasons' + count + '" class="season-a-bubble-css season-click' + count + '  season-click">';
                html += count + '</a></li>';
            }
        }
        html += '</ul><div class="season-tab-content" data-kid="';
        if (typeof season !== 'undefined') {
            html += season['kid'];
        } else {
            html += '';
        }
        html += '">';
    }

    if (schemename != 'excavations' && schemename != 'subjects' && schemename != 'Seasons') {
        html += '<div class="level-content">';
    }


    for (key in data) {
        if (key == 'diff' || data.length == 0) {
            break;
        }
        var item = data[key];
        counter++;

        html += '<table id="' + schemename + counter + '" class="' + schemename + '-table" data-scheme="' + schemename + '" data-kid="' + item['kid'] + '">';
        var matchContributor = false;
        var firstEmptyContributor = true;
        for (control in controlTypes[schemename]) {
            //because kora3 returns undefined if it is empty
            if (typeof item[control] == "undefined") {
                item[control] = "";
            }

            type = controlTypes[schemename][control];
            var text = '';
            if (type == 'text' || type == 'list') {
                text = item[control];
            }
            else if (type == 'url') {
                var host_url = window.location.hostname
                var kid = item['kid'];
                var url = 'http://' + host_url + arcs.baseURL + 'resource/' + kid;
                var link = "<a class='stable-url' href=" + url + ">" + url + "</a>";
                link += '<input type="text" style="display:none;" value="' + url + '" id="myInput">' +
                    '<div class="tooltip" style="opacity:1;">' +
                    '<button class="copyUrlBtn" data-url="'+url+'">' +
                    'Copy link' +
                    '</button>' +
                    '</div>';
                text = link;


            }
            else if (type == 'multi_input' || type == 'multi_select') {
                if (typeof item[control] != "string") {
                    for (var i = 0; i < item[control].length; i++) {
                        text += item[control][i] + "<br>";

                    }
                }
            }
            else if (type == 'associator') {
                var dataAssociatedList = '';
                if (aboveScheme !== false || aboveTwoSchemes !== false) {
                    var preview = '';
                    var usedAboveScheme = aboveScheme;
                    if (schemename == 'excavations') {
                        preview = 'Title';
                    } else if (schemename == 'archival objects') {
                        if (control == 'Excavation_-_Survey_Associator') {
                            preview = 'Name';
                            tmpControl = control
                        } else { //season is the above scheme
                            usedAboveScheme = aboveTwoSchemes;
                            preview = 'Title';
                        }
                    }
                }
                if (typeof item[control] != "string") {
                    for (var i = 0; i < item[control].length; i++) {
                        if (aboveScheme !== false || aboveTwoSchemes !== false) {
                            text += item[control][i] + " (" + usedAboveScheme[item[control][i]][preview] + ")<br>";
                        } else {
                            text += item[control][i] + "<br>";
                        }
                        dataAssociatedList += item[control][i] + ' ';
                    }
                }
            }
            else if (type == 'date') {
                if (typeof item[control] != "string") {
                    text += item[control]['year'] + "-" + item[control]['month'] + "-" +
                        item[control]['day'] + " " + item[control]['era'];
                }
            }
            else if (type == 'terminus') {
                if (typeof item[control] != "string") {
                    if (item[control]['prefix']) {
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
            if (matchContributor == true) {
                tmpControl = "Contributor_Role";
                matchContributor = false;
            }
            else if (tmpControl.indexOf("Contributor") == 0 && tmpControl != 'Contributor_Role') {
                tmpControl = "Contributor";
                if (text == '') {
                    if (firstEmptyContributor == true) {
                        firstEmptyContributor = false;
                    } else {
                        continue;
                    }
                }
                matchContributor = true;
            }

            var adjustedTmpControl = tmpControl.replace(/_/g, ' ');
            if (typeof (controlOptions[schemename][adjustedTmpControl]) != undefined) {
                options = ' data-options="' + controlOptions[schemename][adjustedTmpControl] + '"';
            }

            //check if the metadata has been flagged
            var flagged = "<div class='icon-meta-flag'>&nbsp;</div>";
            if (flags.hasOwnProperty(item['kid']) && flags[item['kid']].includes(control)) {
                flagged = "<div class='icon-meta-flag-red'>&nbsp;</div>";
            }

            extraString = " class='metadataEdit'>" + flagged + "<div id='" + control + "' data-control='" + type + "'" + options + ">" + text + "</div>";
            if (type == 'associator') {
                // console.log('data associator');
                // console.log(dataAssociatedList);
                extraString = " class='metadataEdit'>" + flagged + "<div id='" + control + "' data-control='" + type + "'" + options + " data-associations='" + dataAssociatedList + "'>" + text + "</div>";
            }
            if (control == 'Persistent_Name' || type == "url") {
                extraString = " >" + flagged + "<div id='" + control + "' data-control='" + type + "'" + options + ">" + text + "</div>";
            }
            //there is an edited metadata, so string is this
            if (metadataEdits.hasOwnProperty(item['kid']) && metadataEdits[item['kid']].hasOwnProperty(control)) {
                extraString = '><div class="icon-meta-lock">&nbsp;</div><div>Pending Approval</div>';
            }


            displayedControlName = controlDisplayNames[schemename][tmpControl];
            html += "<tr><td>" + displayedControlName + "</td><td" + extraString + "</td></tr>";
        }
        html += '</table>';
    }

    if (schemename != 'Seasons') {
        html += '</div>';
    }

    html += '</div></div>';

    if (schemename == 'excavations') {
        html += '</div>';
    }
    if (schemename == 'Seasons') {
        html += '</div></div>';
    }
    return html;

}