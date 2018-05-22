window.JST = window.JST || {};

JST["admin/users"] =
    "<div class=\"users-head\">"+
        "<p class=\"name\">NAME</p>"+
        "<p class=\"username\">USERNAME</p>"+
        "<p class=\"joined\">JOINED</p>"+
        "<input class=\"search admin-search users\" placeholder='Search for a user here'>"+
    "</div>"+
    "<div class=\"users-head pending\">"+
        "<p class=\"decline-sel\">Decline Selected</p>"+
        "<p class=\"accept-sel\">Accept Selected</p>"+
        "<p class=\"select-all\">Select All</p>"+
    "</div>"+
	"<div class=\"admin-rows-wrap\">"+
        "<div class=\"admin-rows-content users all-users\">"+
            "<% _.each(users, function(f, i) { %>  "+
                "<% if( f.status != 'unconfirmed') { %>"+
                    "<div class=\"admin-row\">"+
                        "<img style='height:45px;width:45px' src='<%= f.profilePic %>' />"+
                        "<a class=\"name\" href=\"<%= arcs.baseURL + 'user/'+ f.username %>\"><%= f.name %></a>"+
                        "<p class=\"username\"><%= f.username %></p>"+
                        "<p class=\"joined\"><%= f.created %></p>"+
                        "<a data-id=\"<%= f.id %>\" class=\"edit-prof-btn\">Edit Profile</a>"+
                        "<p id=\"delete-btn\" class=\"delete\" data-id=\"<%= f.id %>\">Delete</p>"+
                    "</div>"+
                "<% } %>"+
            "<% }) %>"+
        "</div>"+
		"<div class=\"admin-rows-content users pending-users\">"+
            "<% _.each(users, function(f, i) { %>"+
                "<% if( f.status == 'unconfirmed') { %>"+
                    "<div class=\"admin-row\">"+
                        "<div class='bullet'></div>"+
                        "<p class=\"name\"><%= f.username %></p>"+
                        "<p class=\"email\"><%= f.email %></p>"+
                        "<p class=\"date\"><%= f.created %></p>"+
                        "<p class=\"project\">projname</p>"+
                        "<p class=\"role\"><%= f.role %></p>"+
                        "<p id=\"confirm-btn\" class=\"accept\" data-id=\"<%= f.id %>\">Accept</p>"+
                        "<p id=\"delete-btn\" class=\"decline\" data-id=\"<%= f.id %>\">Decline</p>"+
                    "</div>"+
                "<% } %>"+
            "<% }) %>"+
        "</div>"+
        "<div class=\"create-user\">"+
            "<form>"+
                "<label>First name <input type=\"text\" name=\"fname\"></label>"+
                "<label>"+
					"Last name"+
					"<input type=\"text\" name=\"lname\">"+
				"</label>"+
				"<label id=\"profileImage\">"+
					"Profile Image"+
					"<input type=\"file\" name=\"profileImageDrop\" id=\"profileImageDrop\">"+
					"<label for=\"profileImageDrop\"><strong>Select</strong> or Drop an Image</label>"+
				"</label><br>"+
                "<label style='width: 448px'>User Name <input type=\"text\" name=\"uname\" style='width: 448px'></label><br>"+
                "<label style='width: 448px'>Email <input type=\"text\" name=\"email\" style='width: 448px'></label><br>"+
                "<label>Password <input type=\"password\" name=\"pw\"></label>"+
                "<label>Repeat Password <input type=\"password\" name=\"rpw\"></label>"+
                "<label class=\"matching-pw\"></label><br>"+
                "<p class='pnr'>Projects & Roles</p>"+
                "<div class=\"pnr-container create\">"+
                    "<div class=\"pnr-single\">"+
                        "<label>Project "+
                            "<select class=\"proj-select\" name=\"project\">"+
                                "<option style='display:none;' selected>Select a project</option>"+
                                "<% _.each(users[0].projectNames, function(f, i) { %>  "+
                                    "<option data-name=<%= f %> ><%= f %></option>"+
                                "<% }) %>"+
                            "</select></label>"+
                        "<label>Role "+
                            "<select name=\"role\">"+
                                "<option style='display:none;' selected>Select a role</option>"+
                                "<option>Researcher</option>"+
                                "<option>Moderator</option>"+
                                "<option>Admin</option>"+
                            "</select></label>"+
                    "</div>"+
                "</div>"+
                "<p id='createAdd' class='anotherPR create'>Add User to Another Project</p>"+
                "<input id=\"create-user-submit\" type=\"submit\" value=\"Create  User\">"+
            "</form>"+
        "</div>"+
		"<div class=\"invite-user\">"+
				"<form>"+
					"<label>First name <input type=\"text\" name=\"fname\"></label>"+
					"<label>"+
						"Last name"+
						"<input type=\"text\" name=\"lname\">"+
					"</label>"+
					"<label id=\"instruction\">"+
						"Provide an email address along with the invited user’s role and assigned projects and we’ll send them a link which will allow them to create an account."+
					"</label><br>"+
					"<label style='width: 448px'>Email <input type=\"text\" name=\"email\" style='width: 448px'></label><br>"+
					"<p class='pnr'>Projects & Roles</p>"+
					"<div class=\"pnr-container invite\">"+
                        "<div class=\"pnr-single\">"+
                            "<label>Project "+
                                "<select class=\"proj-select\" name=\"project\">"+
                                    "<option style='display:none;' selected>Select a project</option>"+
									"<% _.each(users[0].projectNames, function(f, i) { %>  "+
	                                    "<option data-name=<%= f %> ><%= f %></option>"+
	                                "<% }) %>"+
                                "</select></label>"+
                            "<label>Role "+
                                "<select name=\"role\">"+
                                    "<option style='display:none;' selected>Select a role</option>"+
                                    "<option>Researcher</option>"+
                                    "<option>Moderator</option>"+
                                    "<option>Admin</option>"+
                                "</select></label>"+
                        "</div>"+
                    "</div>"+
					"<p id='createAdd' class='anotherPR invite'>Add User to Another Project</p>"+
					"<input id=\"invite-btn\" type=\"submit\" value=\"Invite User\">"+
				"</form>"+
			"</div>"+
		"</div>"+
	"</div>"/*+
    "<div class=\"admin-pagination users\">"+
        "<div class=\"ipp\">"+
            "<div class=\"menu\">"+
                "<p class=\"curr\">25 ITEMS PER PAGE</p>"+
                "<p>50 ITEMS PER PAGE</p>"+
                "<p>75 ITEMS PER PAGE</p>"+
                "<p>DISPLAY ALL</p>"+
            "</div>"+

            "<div class=\"drop\">"+
                "<p class=\"per\">25 ITEMS PER PAGE</p>"+
                "<span class=\"chevron\"></span>"+
            "</div>"+
        "</div>"+

		"<div class=\"page-pick\">"+
			"<div class='arrow-wrap left'><span class=\"chevron left\"></span></div>"+
			"<div class=\"by-num\"></div>"+
			"<div class='arrow-wrap right'><span class=\"chevron right\"></span></div>"+
		"</div>"+
	"</div>"*/
	/*+
	"<table class=\"table table-striped table-bordered\">"+
    "<tr>" +
      "<th>Picture</th>"+
      "<th>Name</th>"+
      "<th>Username</th>"+
      "<th>Email</th>"+
      "<th>Project Roles</th>"+
      "<th>Status</th>"+
      "<th>Actions</th></tr><tr>"+
    "<% _.each(users, function(f, i) { %>  "+
        "<td><img style='height:100px;width:100px' src='<%= f.profilePic %>' /></td>"+
        "<td><%= f.name %></td>"+
        "<td><%= f.username %></td>"+
        "<td><%= f.email %></td>"+
        "<td><%= f.role %></td>"+
        "<td><%= f.status %></td>"+
        "<td>"+
            "<button id=\"delete-btn\" class=\"btn btn-danger btn-mini \" data-id=\"<%= f.id %>\">Delete</button>"+

            "<% if( f.status == 'active' ){ %>  "+
                "<button id=\"edit-btn\" class=\"btn btn-info btn-mini\" data-id=\"<%= f.id %>\">Edit</button>"+
            "<% }else{ %>"+
                "<button id=\"confirm-btn\" class=\"btn btn-info btn-mini\" data-id=\"<%= f.id %>\">Confirm</button>"+
            "<% } %>"+
        "</td>"+
    "</tr><% }) %></table>"*/;

JST["admin/activity"] =
    "<div class=\"admin-rows-wrap\">"+
        "<div class=\"admin-rows-content activity\">"+
            "<% _.each(activity, function(f, i) { %>  "+
                "<div class=\"admin-row activity\">"+
                    "<img style='height:45px;width:45px' src='<%= f.profilePic %>' />"+
                    "<p class=\"username\"><%= f.name %></p>"+
                    "<p class=\"date\"><%= f.date %></p>"+
                    "<p class=\"type\"><%= f.type %></p>"+
                    "<a class=\"link\" href=\"<%= arcs.baseURL + 'user/'+ f.username %>\">View User</a>"+
                "</div>"+
            "<% }) %>"+
        "</div>"+
    "</div>"+
	"<div class=\"admin-pagination\">"+
        "<div class=\"ipp\">"+
            "<div class=\"menu\">"+
                "<p id=\"twenty-five-per-page\" class=\"curr\">25 ITEMS PER PAGE</p>"+
                "<p>50 ITEMS PER PAGE</p>"+
                "<p>75 ITEMS PER PAGE</p>"+
                "<p>DISPLAY ALL</p>"+
            "</div>"+
            "<div class=\"drop\">"+
                "<p class=\"per\">25 ITEMS PER PAGE</p>"+
                "<span class=\"chevron\"></span>"+
            "</div>"+
        "</div>"+
		"<div class=\"page-pick\">"+
			"<div class='arrow-wrap left'><span class=\"chevron left\"></span></div>"+
			"<div class=\"by-num\"></div>"+
			"<div class='arrow-wrap right'><span class=\"chevron right\"></span></div>"+
		"</div>"+
	"</div>";

JST["admin/flags"] =
	"<div class=\"admin-rows-wrap\">"+
		"<div class=\"admin-rows-content flag\">"+
			"<% _.each(flags, function(f, i) { %>"+
				"<div class=\"admin-row flag\">"+
					"<p class=\"obj-name\"><%= f.resource_kid %></p>"+
					"<a class=\"delete delete-flag-btn\" href=\"#\""+
                                "data-id=\"<%= f.id %>\">Delete</a>"+
					"<div class=\"status\" data-id=\"<%= f.id %>\">"+
						"<p class=\"current\"><%= f.status %></p>"+
						"<span class=\"chevron\"></span>"+
					"<div class=\"pick-status\">"+
						"<p class=\"pending\">pending</p>"+
                        "<p class=\"unresolved\">unresolved</p>"+
						"<p class=\"resolved\">resolved</p>"+
					"</div>"+
					"</div>"+
					"<p class=\"out-rel\"><%= f.annotation_target %>: <%= f.reason %></p>"+
					"<p class=\"flag-by\">"+
						"Flagged by "+
						"<a href=\"<%= arcs.baseURL + 'user/' + f.user_username %>\"><%= f.user_name %>: </a>"+
						"<small><%= f.explanation %></small>"+
					"</p>"+
				"</div>"+
			"<% }) %>"+
		"</div>"+
	"</div>"+
	"<div class=\"admin-pagination\">"+
        "<div class=\"ipp\">"+
            "<div class=\"menu\">"+
                "<p class=\"curr\">25 ITEMS PER PAGE</p>"+
                "<p>50 ITEMS PER PAGE</p>"+
                "<p>75 ITEMS PER PAGE</p>"+
                "<p>DISPLAY ALL</p>"+
            "</div>"+
            "<div class=\"drop\">"+
                "<p class=\"per\">25 ITEMS PER PAGE</p>"+
                "<span class=\"chevron\"></span>"+
            "</div>"+
        "</div>"+
		"<div class=\"page-pick\">"+
			"<div class='arrow-wrap left'><span class=\"chevron left\"></span></div>"+
			"<div class=\"by-num\"></div>"+
			"<div class='arrow-wrap right'><span class=\"chevron right\"></span></div>"+
		"</div>"+
	"</div>";

JST["admin/metadata_edits"] =
    "<div class=\"metadata-head\">"+
        "<p class=\"resource-kid\">RESOURCE KID</p>"+
        "<p class=\"username\">USERNAME</p>"+
        "<p class=\"metadata-kid\">METADATA KID</p>"+
        "<p class=\"field-name\">FIELD NAME</p>"+
        "<p class=\"value-before\">OLD VALUE</p>"+
        "<p class=\"new-value\">NEW VALUE</p>"+
        "<input class=\"search admin-search meta\" placeholder='Search for a user'>"+
    "</div>"+
    "<div class=\"admin-rows-wrap\">"+
        "<div class=\"admin-rows-content meta\">"+
            "<% _.each(metadata_edits, function(f, i) { %>  "+
                "<div class=\"admin-row meta\">"+
                    "<p class=\"resource-kid\"><%= f.MetadataEdit.resource_kid %></p>"+
                    "<p class=\"username\"><%= f.MetadataEdit.user_name %></p>"+
                    "<p class=\"metadata-kid\"><%= f.MetadataEdit.metadata_kid %></p>"+
                    "<p class=\"field-name\"><%= f.MetadataEdit.field_name %></p>"+
                    "<p class=\"value-before\"><%= f.MetadataEdit.value_before %></p>"+
                    "<p class=\"new-value\"><%= f.MetadataEdit.new_value %></p>"+
                    "<div class=\"actions\">"+
                        "<% if( f.MetadataEdit.rejected == 1 ){ %>"+
                            "Rejected"+
                        "<% }else if( f.MetadataEdit.approved == 1 ){ %>"+
                            "Approved"+
                        "<% }else{ %>"+
                            "<a class=\"meta-delete delete-flag-btn\"" +
                                "data-id=\"<%= f.MetadataEdit.id %>\"" +
                                "data-email='<%= f.MetadataEdit.email %>'>Delete</a>"+
                            "<a class=\"meta-approve approve-flag-btn\" " +
                                "data-id=\"<%= f.MetadataEdit.id %>\">Approve</a>"+
                        "<% } %>"+
                    "</div>"+
                "</div>"+
            "<% }) %>"+
        "</div>"+
    "</div>"
	/*
    "<table class=\"table table-striped table-bordered\">"+
    "<tr>" +
        "<th>Resource Kid</th>"+
        "<th>User Name</th>"+
        "<th>Metadata Kid</th>"+
        "<th>Field Name</th>"+
        "<th>Old Value</th>"+
        "<th>New Value</th>" +
        "<th>Actions</th>" +
    "</tr><tr>"+
    "<% _.each(metadata_edits, function(f, i) { %>  "+
        "<td><%= f.MetadataEdit.resource_kid %></td>"+
        "<td><%= f.MetadataEdit.user_name %></td>"+
        "<td><%= f.MetadataEdit.metadata_kid %></td>"+
        "<td><%= f.MetadataEdit.field_name %></td>"+
        "<td><%= f.MetadataEdit.value_before %></td>"+
        "<td><%= f.MetadataEdit.new_value %></td>"+
        "<td>"+
            "<% if( f.MetadataEdit.rejected == 1 ){ %>  "+
                "Rejected"+
            "<% }else if( f.MetadataEdit.approved == 1 ){ %>  "+
                "Approved"+
            "<% }else{ %>"+
                "<button class=\"delete-flag-btn btn btn-danger btn-mini \" " +
                    "data-id=\"<%= f.MetadataEdit.id %>\" " +
                    "data-email='<%= f.MetadataEdit.email %>'>Delete</button>"+
                "<button class=\"edit-flag-btn btn btn-info btn-mini\" " +
                    "data-id=\"<%= f.MetadataEdit.id %>\" >Approve</button>"+
            "<% } %>"+
        "</td>"+
    "</tr><% }) %>"+
    "</table>"*/;

JST["admin/show_job"] = "<dl>  <dt>Job</dt>  <dd><%= name %></dd>  <dt>Status</dt>  <dd><%= status %></dd>  <dt>Created</dt>  <dd><%= created %></dd>  <dt>Lock</dt>  <dd><%= locked_at %></dd>  <dt>Data</dt>  <dd><pre><%= data %></pre></dd>  <dt>Error</dt>  <dd><pre><%= error %></pre></dd></dl>";

JST["collections/list"] = "<% _.each(collections, function(c, i) { %>" +
    "<% if (i == -1) { %>  "+
        "<details data-id=\"<%= c.collection_id %>\" class=\"open back-color\" open=\"open\">" +
    "<% } else { %>  " +
        "<details data-id=\"<%= c.collection_id %>\" class=\"closed back-color\">" +
    "<% } %>" +
    "<summary>" +
        "<h3><%= c.title %></h3>" +
        "<h4><a href=\"<%= arcs.baseURL + 'user/'+ c.username %>\"><%= c.user_name %></a></h4>" +
        "<h5><%= c.timeAgo %></h5>" +
    "</summary>" +
    "<div class=\"results\"></div>" +
    "</details><% }) %>";

JST["collections/profile"] = '<div class="profile-collection-list-wrapper">' +
    '<div class="collection-list" id="all-collections">' +
    "<% _.each(collections, function(c, i) { %>" +
    "<% if (i == -1) { %>  "+
        "<details data-id=\"<%= c.collection_id %>\" class=\"open back-color\" open=\"open\">" +
    "<% } else { %>  " +
        "<details data-id=\"<%= c.id %>\" class=\"closed\">" +
    "<% } %>" +
    "<summary>" +
        "<h3><%= c.title %></h3>" +
        "<h4></h4>" +
        "<h5><%= c.timeAgo %></h5>" +
        "<% if (permissions == true) { %>  "+
            '<h4 class="edit-btn " data-permission="<%= c.public %>" data-members="<%= c.members %>" data-delete-resources="" style="float:right;padding-right:10px">OPEN COLLECTION</h4>' +
        "<% } %>" +
    "</summary>" +
    "<div class=\"results\"></div>" +
    "</details><% }) %> </div></div>";

JST["home/details"] = "<ul class=\"resource-thumbs\">"+
    "<% _.each(resources, function(r, i) { %>" + [
        "<li class=\"resource-thumb\" data-colid=\"<%= r.collection_id %>\" data-resource-kid=\"<%= r.kid %>\">",
        "<% var temp = '';if(r.orphan=='true'){temp='href=\"'+arcs.baseURL+'orphan/'+r.kid+'\"';}else if(r.kid=='' ||(typeof r.Locked !== 'undefined' && r.Locked == '1')){temp=''}else{temp='href=\"'+arcs.baseURL+'resource/'+r.kid+'\"'} %>",
        "<a <%= temp %> style='position:relative;'>",
            "<% if( typeof r.Locked !== 'undefined' && r.Locked == '1' ){ %>",
                "<div class='resourceLockedDarkBackground'></div>",
                "<img src=\"<%= arcs.baseURL + 'img/Locked.svg' %>\" alt='' class='resourceLocked' />",
            "<% } %>",
        "<img src=\"<%= r.thumb %>\" alt=\"resource\" />",
        "</a>",
        "<a class=\"resource-title\" <%= temp %>><%= r.title %><br /><span class='resource-type'><%= r.type %></a>",
        "</li>",
        "<% }) %><% if (!resources.length) { %>",
        "<li><i class=\"icon-exclamation-sign\"></i> No Results Found  </li>",
        "<% } else if (noShowAll != 1) { %>",
        "<li class=\"resource-thumb\">",
        "<% if (typeof searchURL != \"undefined\") { %>",
        "<div class=\"btn-show-all\"><a><img src=\"<%= arcs.baseURL + 'img/SeeAll.svg' %>\" alt=\"SeeAll.svg\"/></a>",
        "<a><i class=\"icon-share-alt\"></i><p class=\"show-all-btn-text\" style=\"margin-top: 12px;margin-bottom: 0px;color: #6D6E70;font-size: 16px;font-family: \"Helvetica Neue\", Helvetica, Arial, sans-serif;\">SHOW ALL</p><br /></a></div>",
        "<% } else { %>",
        "<a href='<%= arcs.baseURL + 'search/type:\"' + resources[0].type + '\"' %>'>",
        "<i class=\"icon-share-alt\"></i> Show all      </a>",
        "<% } %>  </li>"
    ].join("\n") + "<% } %></ul>";

JST["search/grid"] = "<% _.each(results, function(r, i) { %>" + [
        "<li class='resource-thumb simple 'data-id='<%= r.kid %>'",
        "<% if (r.project) { %>",
        "style='height:225px;'",
        "<% } %>",
        " > ",
        "<div>",
            "<% var temp='href=\"'+arcs.baseURL+'resource/'+r.kid+'\"';if( typeof r.Locked !== 'undefined' && r.Locked == '1' ){ temp=''; %>",
                "<div class='resourceLockedDarkBackgroundSearch' style='height:120px;width:115px;left:19px;'>",
                    "<img src=\"<%= arcs.baseURL + 'img/Locked.svg' %>\" alt='' class='resourceLocked' />",
                "</div>",
            "<% }if(typeof r.orphan !== 'undefined' && r.orphan) {" +
                "temp='href=\"'+arcs.baseURL+'orphan/'+r.kid+'\"';" +
                "var select='<div>'" +
            "}else{" +
                "var select='<div class=\"select-overlay\">"+
                "<div class=\"circle-container\">"+
                "<div class=\"select-circle\">"+
                "<div class=\"i-circle\"></div></div></div>';" +
            "} %>",
        "<%= select %>",
        "</div>",
        "<img class='results' src='<%= r.thumb == 'img/DefaultResourceImage.svg' ? arcs.baseURL + 'img/DefaultResourceImage.svg' : r.thumb %>'></div>",
        "<a class='result_a' <%= temp %>>",
        "<div class='resource-title'><%= r.Title %> </div>",
        "<div class='resource-type'><%= r.Type %></div> </a>",
        "<div class='icon-flag'></div>",
        "<div class='search-icon-edit'></div>",
        " <div class='icon-in-collection'></div>",
        "<div class='icon-discussed'></div>",
        "<div class='icon-tagged'></div>",
        "<% if (r.project) { %>",
        "<div class='projectTitle resource-type'> <b><%=r.project%></b></div>",
        "<% } %>",

        "</li>"
    ].join("\n") + "<% }) %>";

JST["search/list"] = "<% _.each(results, function(r, i) { %>" +  [
        "<li class='resource-thumb detailed'data-id='<%= r.kid %>'> ",
        "<div class='img-tooltip'>",
        "<div class='item'>",
        "<div class='select-overlay'><div class='circle-container'>",
        "<div class='select-circle'><div class='i-circle'></div></div></div></div>",
        "<% var temp='href=\"'+arcs.baseURL+'resource/'+r.kid+'\"';if( typeof r.Locked !== 'undefined' && r.Locked == '1' ){ temp=''; } %>",
        "<a class='result_a' <%= temp %>>",
            "<% if( typeof r.Locked !== 'undefined' && r.Locked == '1' ){ %>",
                "<div class='resourceLockedDarkBackgroundSearch' style='height:175px;'>",
                "<img src=\"<%= arcs.baseURL + 'img/Locked.svg' %>\" alt='' class='resourceLocked' />",
                "</div>",
            "<% } %>",
            "<img class='results' src='<%= r.thumb == 'img/DefaultResourceImage.svg' ? arcs.baseURL + 'img/DefaultResourceImage.svg' : r.thumb %>'>",
        "</a>",
        "<div class='tooltip'>",
        "<div class='search-icon-edit'></div>",
        " <div class='icon-in-collection'></div>",
        "<div class='icon-discussed'></div>",
        "<div class='icon-tagged'></div>",
        "</div>",
        "</div>",
        "</div>",
        "<div class='detailed-text'>",
        "<ul class='resourceInfo'>",
        "<% if (r['Accession Number']) { %>",
        " <li> <p> <b> <%= r['Accession Number']  %> </b></p></li>",
        "<% } %> ",
        "<% if (r['Resource Identifier']) { %>",
        " <li> <p>Resource Identifier: <b> <%= r['Resource Identifier']  %></b></p></li>",
        "<% } %> ",
        "<% if (r.Type) { %>",
        "<li> <p><%= r.Type %></p> </li>",
        "<% } %> ",
        "<% if (r.Creator) { %>",
        "<li> <p>By <b><%= r.Creator %> </b></p>  </li>",
        "<% } %> ",
        "<% if (r['Earliest Date'] ) { %>",
        "<li> <p>Date Created: <%= r['Earliest Date']['month'] %>-<%= r['Earliest Date']['day'] %>-<%= r['Earliest Date']['year'] %> <%= r['Earliest Date']['era'] %> </p>  </li>",
        "<% } %> ",
        "<% if ( r['Project Name'] ) { %>",
        "<li> <p>Associated Project <b><%= r['Project Name'] %> </b></p>  </li>",
        "<% } %> ",
        "<li> <p>Recently Edited By: <b><%= r['recordowner'] %> </b></p>  </li>",
        "</ul>",
        "</div>",
        "</li>"
    ].join("\n") + "<% }) %>";


// JST["search/grid"] = "<% _.each(results, function(r, i) { %>  <div class='resource-item-container result' data-id='<%= r.kid %>'>  <li class='flex-item img-wrapper'><img class='flex-img' src='<%= r.thumb == 'img/DefaultResourceImage.svg' ? '../img/DefaultResourceImage.svg' : r.thumb %>'></li>  <span class='select-button' style='display:none;'>SELECT</span>  <a href='../resource/<%= r.kid %>'><div class='resource-title'><%= r.Title %></div>  <div class='resource-type'><%= r.Type %></div></a>  <div class='icon-flag'></div>  <div class='search-icon-edit'></div>  <div class='icon-in-collection'></div>  <div class='icon-discussed'></div>  <div class='icon-tagged'></div>  </div>  <% }) %>";

JST["search/help-toggle"] = "<i class=\"search-help-btn icon-info-sign\" rel=\"tooltip\"   data-placement=\"top\" data-original-title=\"Show Search Help\"></i>";
JST["search/hotkeys"] = "<div class=\"modal hotkeys-modal\">  <div class=\"modal-header\">    <a class=\"hotkeys-close pull-right\">close</a>    <h3>Shortcuts</h3>  </div>  <div class=\"modal-body\">    <table>      <thead>        <tr>          <th>Action</th>          <th>Keys(s)</th>        </tr>      </thead>      <tbody>        <tr>          <td>Select all</td>          <td><%= ctrl %> + A</td>        </tr>        <tr>          <td>Select multiple</td>          <td>click + drag</td>        </tr>        <tr>          <td>Add/remove from selection</td>          <td><%= ctrl %> + click</td>        </tr>        <tr>          <td>Quick preview</td>          <td>spacebar</td>        </tr>        <tr>          <td>Navigate previews</td>          <td>            <i class=\"icon-white icon-arrow-left\"></i>            <i class=\"icon-white icon-arrow-right\"></i>          </td>        <tr>          <td>Edit info (for selected)</td>          <td><%= ctrl %> + E</td>        </tr>        <tr>          <td>Back to top</td>          <td>T</td>        </tr>      </tbody>    </table>  </div></div>";



// JST["search/list"] = "<table style=\"width:100%\"><% _.each(results, function(r, i) { %>  <tr class=\"result list resource-item-container\" data-id=\"<%= r.id %>\" style='background:transparent;'>    <td  >    <div class='flex-item img-wrapper' >  <img class='flex-img' src=\"<%= r.thumb %>\" data-id=\"<%= r.id %>\" /> </div> <div class='icon-flag'></div>  <div class='search-icon-edit'></div>  <div class='icon-in-collection'></div>  <div class='icon-discussed'></div>  <div class='icon-tagged'></div> <div class='icon-annotate' style='opacity: .65;'></div> <span class='select-button' style='\margin-top:-170px; display:block;visibility:hidden;\'>SELECT</span> </td>       <td class='detailed-desc'>      <div>        <strong><%= r.title %></strong>     <% if (r.metadata) { %>          <span class=\"monospace\"><%= r.metadata %></span> &nbsp;        <% } %>        <a class=\"subtle\" href=\"<%= r.url %>\"><%= r.file_name %></a>      <strong><b><a href='../resource/<%= r.kid %>' style='    color: #6f6f6f;'> <%= r['Accession Number'] %> </a></b> <strong>      </div>      <% if (r.type) { %>      <div>        <% if (arcs.mime.isImage(r.mime_type)) { %>          <i class=\"icon-picture\"></i>        <% } else if (arcs.mime.isVideo(r.mime_type)) { %>          <i class=\"icon-film\"></i>        <% } else { %>          <i class=\"icon-file\"></i>        <% } %>        <%= r.type %>      </div>      <% } %>      <div> <%= r.Type %> </div>    <div>By <b><%= r.Creator %></b> 3 years ago </div> <div> Linked to: <b><%= r.linkers%></b> </div> <div> Associated Project: <b><%= r['Project Name'] %> </b> </div> <div> Recently Edited By: <b>Person Name</b> 3 weeks ago </div>  <div>        <% _.each(r.keywords, function(k) { %>          <a class=\"keyword-link subtle\"             href=\"<%= arcs.url('search', 'keyword:' + k) %>\"><%= k %></a>        <% }) %>      </div>      <div>        <% if (r.comments) { %>          <%= r.comments %> <i class=\"icon-comment\"></i>        <% } if (r.annotations) { %>          <%= r.annotations %> <i class=\"icon-map-marker\"></i>        <% } if (r.flags) { %>          <%= r.flags %> <i class=\"icon-flag\"></i>        <% } if (!r.public) { %>          <i class=\"icon-lock\"></i>        <% } %>      </div>    </td>  </tr><% }) %></table>";

//JST["search/list"] = "<table style=\"width:100%\"><% _.each(results, function(r, i) { %>  <tr class=\"result list\" data-id=\"<%= r.id %>\">    <td class=\"img-wrapper\">      <img src=\"<%= r.thumb %>\" data-id=\"<%= r.id %>\" />    </td>    <td>      <div>        <strong><%= r.title %></strong> &nbsp;        <% if (r.metadata.get('identifier')) { %>          <span class=\"monospace\"><%= r.metadata.get('identifier') %></span> &nbsp;        <% } %>        <a class=\"subtle\" href=\"<%= r.url %>\"><%= r.file_name %></a> &nbsp;        (<em>Resource.Acession Number</em>)      </div>      <% if (r.type) { %>      <div>        <% if (arcs.mime.isImage(r.mime_type)) { %>          <i class=\"icon-picture\"></i>        <% } else if (arcs.mime.isVideo(r.mime_type)) { %>          <i class=\"icon-film\"></i>        <% } else { %>          <i class=\"icon-file\"></i>        <% } %>        <%= r.type %>      </div>      <% } %>      <div>        Uploaded        <%= relativeDate(new Date(r.created)) %>        by        <a class=\"subtle\" href=\"<%= arcs.url('user', r.user.username) %>\"><%= r.user.name %></a>       </div>      <div>        <% _.each(r.keywords, function(k) { %>          <a class=\"keyword-link subtle\"             href=\"<%= arcs.url('search', 'keyword:' + k) %>\"><%= k %></a>        <% }) %>      </div>      <div>        <% if (r.comments.length) { %>          <%= r.comments.length %> <i class=\"icon-comment\"></i>        <% } if (r.annotations.length) { %>          <%= r.annotations.length %> <i class=\"icon-map-marker\"></i>        <% } if (r.flags.length) { %>          <%= r.flags.length %> <i class=\"icon-flag\"></i>        <% } if (!r.public) { %>          <i class=\"icon-lock\"></i>        <% } %>      </div>    </td>  </tr><% }) %></table>";

JST["search/paginate"] = "<% if (results.num_results > 0) { %>  <div class=\"search-pages btn-toolbar\">    <% if (results.page != 1) {%>      <div class=\"btn-group\">        <a class=\"search-page-btn btn\" data-page=\"<%= results.page - 1 %>\"           href=\"<%= arcs.url('search', results.query, 'p' + (results.page - 1)) %>\">          &larr;        </a>      </div>    <% } %>    <div class=\"btn-group\">      <% var pages = _.range(1, _.range(0, results.total, results.limit).length + 1) %>      <% _.each(_.surrounding(pages, results.page - 1, 10), function(p) { %>        <a class=\"search-page-btn btn <%= (p == results.page) ? \"active\" : \"\" %>\"           data-page=\"<%= p %>\" href=\"<%= arcs.url('search', results.query, 'p' + p) %>\"><%= p %></a>      <% }) %>    </div>    <% if (results.num_results == results.limit) { %>      <div class=\"btn-group\">        <a class=\"search-page-btn btn\" data-page=\"<%= results.page + 1 %>\"           href=\"<%= arcs.url('search', results.query, 'p' + (results.page + 1)) %>\">          &rarr;        </a>      </div>    <% } %>  </div>  <div class=\"search-description\">    <%= results.offset + 1 %> &mdash;    <%= results.offset + results.num_results %>    of <%= results.total %> resources  </div><% } %>";
JST["search/preview"] = "<div class=\"preview\">  <img class=\"preview-image\" src=\"<%= preview || url %>\" alt=\"preview\"/>  <div class=\"preview-footer\">    <a id=\"title\" href=\"<%= arcs.baseURL + \"resource/\" + id %>\">      <%= title %>    </a>&nbsp;    <% if (mime_type == 'application/pdf') print('(PDF)'); %>    <% if (count > 1) { %>    <span class=\"pull-right\">      <% if (page > 1) { %>        <span id=\"prev-btn\">&larr;</span>      <% } %>      <%= page %> / <%= count %>      <span id=\"next-btn\"         class=\"<%= page < count ? '' : 'invisible' %>\">&rarr;</span>    </span>    <% } %>  </div></div>";
JST["ui/button"] = "<a class=\"btn icon unselectable\" id=\"<%= id %>\"    <%= this.url !== undefined ? 'href=\"' + url + '\"' : '' %>>    <span class=\"<%= this.class %>\"></span>    <%= text %></a>";
JST["ui/context_menu"] = "<ul class=\"nav nav-list context-menu\" style=\"display:none\">  <% for (o in options) { %>  <li><a class=\"context-menu-option\"     id=\"context-menu-option-<%= arcs.inflector.identifierize(o) %>\">    <%= o %></a></li>  <% } %></ul>";
JST["ui/loader"] = "<div class=\"loading\"></div>";
JST["ui/modal_columned"] = "<div class=\"modal-header\">  <a class=\"close\" data-dismiss=\"modal\">×</a>  <h3><%= title %></h3></div><div class=\"modal-body\"><% if (subtitle) { %>  <%= subtitle %>  <br><br><% } %><% var left = true %><% _.each(inputs, function(i, name) { %>  <% if (left) { %>  <div class=\"row\">  <% } %>  <span class=\"span-6\">  <% if (_.isUndefined(i.label) || i.label !== false) { %>    <label for=\"modal-<%= name %>\">      <%= _.isUndefined(i.label) ? name.substr(0, 1).toUpperCase() + name.substr(1) : i.label %>       <% if (i.help) { %>        <i class=\"icon-info-sign\" rel=\"tooltip\" title=\"<%= i.help %>\"></i>      <% } %>    </label>  <% } %>  <% if (i.type === 'select') { %>    <select class=\"<%= i.class %>\" id=\"modal-<%= name %>-input\"      <%= i.focused ? 'autofocus' : '' %>      name=\"modal-<%= name %>\">    <% _.each(i.options, function(val, key) { %>      <option <%= i.value == val ? 'selected' : '' %> value=\"<%= val %>\">        <%= _.isArray(i.options) ? val : key %>      </option>    <% }) %>    </select>  <% } else if (i.type === 'textarea') { %>    <textarea class=\"<%= i.class %>\" id=\"modal-<%= name %>-input\"      name=\"modal-<%= name %>\" <%= i.focused ? 'autofocus' : '' %>></textarea>  <% } else { %>    <input type=\"<%= i.type ? i.type : 'text' %>\" class=\"<%= i.class %>\"      id=\"modal-<%= name %>-input\" value=\"<%= i.value %>\"      <%= i.focused ? 'autofocus' : '' %>      name=\"modal-<%= name %>\" placeholder=\"<%= i.placeholder %>\" />  <% } %>  <% if (!_.isUndefined(i.checkbox)) { %>    <input class=\"checkbox inline\" id=\"modal-<%= name %>-checkbox\"       type=\"checkbox\" <%= (i.checkbox) ? 'checked' : '' %> />  <% } %>  </span>  <% if (!left) { %>  </div>  <% } %>  <% left = !left %><% }) %><% if (!left) { %>  </div><% } %></div><div class=\"modal-footer\"><% _.each(buttons, function(b, name) { %>  <button class=\"<%= b.class ? b.class : 'btn' %>\"     id=\"modal-<%= name %>-button\">    <%= name.substr(0, 1).toUpperCase() + name.substr(1) %>   </button><% }) %></div>";
JST["ui/modal"] = "<div class=\"modal-header\">  <a class=\"close\" data-dismiss=\"modal\">×</a>  <h3><%= title %></h3></div><div class=\"modal-body\"><% if (subtitle) { %>  <%= subtitle %>  <br><br><% } %>  <div id=\"validation-error\"></div><% _.each(inputs, function(i, name) { %>  <% if (_.isUndefined(i.label) || i.label !== false) { %>    <label for=\"modal-<%= name %>\">      <%= _.isUndefined(i.label) ? name.charAt(0).toUpperCase() + name.substr(1) : i.label %>       <% if (i.help) { %>        <i class=\"icon-info-sign\" rel=\"tooltip\" title=\"<%= i.help %>\"></i>      <% } %>    </label>  <% } %>  <% if (i.type === 'select') { %>    <select class=\"<%= i.class %>\" id=\"modal-<%= name %>-input\"      <%= i.focused ? 'autofocus' : '' %>      name=\"modal-<%= name %>\">    <% _.each(i.options, function(val, key) { %>      <option <%= i.value == val ? 'selected' : '' %> value=\"<%= val %>\"?>        <%= _.isArray(i.options) ? val : key %>      </option>    <% }) %>    </select>  <% } else if (i.type === 'textarea') { %>    <textarea class=\"<%= i.class %>\" id=\"modal-<%= name %>-input\"      name=\"modal-<%= name %>\" <%= i.focused ? 'autofocus' : '' %>><%= i.value || '' %></textarea>  <% } else { %>    <input type=\"<%= i.type ? i.type : 'text' %>\" class=\"<%= i.class %>\"      id=\"modal-<%= name %>-input\" value=\"<%= i.value %>\"      <%= i.focused ? 'autofocus' : '' %>      name=\"modal-<%= name %>\" placeholder=\"<%= i.placeholder %>\" />  <% } %><% }) %></div><div class=\"modal-footer\"><% _.each(buttons, function(b, name) { %>  <button class=\"<%= b.class ? b.class : 'btn' %>\"     id=\"modal-<%= name %>-button\">    <%= name.substr(0, 1).toUpperCase() + name.substr(1) %>   </button><% }) %></div>";
JST["ui/modal_wrapper"] = "<div id=\"modal\" class=\"modal\" style=\"display:none; max-height:none;\"></div>";
JST["ui/notification"] = "<div id=\"notification\" class=\"alert notification\" style=\"display:none\">    <a class=\"close\" data-dismiss=\"alert\" href=\"#\">×</a>    <span id=\"msg\"></span></div>";
JST["ui/progress"] = "<span class=\"progress\">  <div class=\"bar\" style=\"width: <%= progress %>%\"></div></span>";
JST["upload/list"] = "<div class=\"accordion-group upload\" data-id=\"<%= cid %>\">  <div class=\"accordion-heading\">    <div class=\"accordion-toggle\">      <% if (arcs.mime.isImage(type)) { %>        <i class=\"icon-picture\"></i>      <% } else if (arcs.mime.isVideo(type)) { %>        <i class=\"icon-film\"></i>      <% } else { %>        <i class=\"icon-file\"></i>      <% } %>      <%= name %> &nbsp;&nbsp;      <em><%= arcs.utils.convertBytes(size) %></em> &nbsp;&nbsp;      <div class=\"remove\"></div>      <span class=\"progress\">        <div class=\"bar\" style=\"width: <%= progress %>%\"></div>      </span>      <span id=\"progress-done\" class=\"pull-right\" style=\"display:none\">        <i class=\"icon-ok\"></i> Done      </span>    </div>  </div>  <div class=\"accordion-body collapse in\">    <div class=\"accordion-inner\">      <input type=\"text\" id=\"upload-title\" placeholder=\"Title\" />      <input type=\"text\" id=\"upload-identifier\" placeholder=\"Identifier\" />      <select id=\"upload-type\" style=\"display:inline-block\">        <option disabled selected>Choose Type...</option>      <% _.each(arcs.config.types, function(help, type) { %>        <option><%= type %></option>      <% }) %>      </select>    </div>  </div></div>";
JST["viewer/annotations"] = "<ul class=\"annotations\"><% _.each(annotations, function(a) { %>  <li class=\"annotation\" data-id=\"<%= a.id %>\">  <% if (a.relation) { %>    <i class=\"icon-magnet\"></i>    <a href=\"<%= arcs.url('resource', a.relation.id) %>\"      class=\"subtle\"><%= a.relation.title %></a>  <% } else if (a.transcript) { %>    <i class=\"icon-align-justify\"></i>    <%= arcs.inflector.truncate(a.transcript, 200) %>  <% } else if (a.url) { %>    <i class=\"icon-share\"></i>    <a class=\"subtle\" href=\"<%= a.url %>\"><%= a.url %></a>  <% } %>  </li><% }) %></ul>";
JST["viewer/annotator"] = "<div class=\"annotator-tabs tabbable\">  <ul class=\"nav nav-tabs\">    <li class=\"active\">      <a href=\"#relation-tab\" data-toggle=\"tab\">Relation</a>    </li>    <li>      <a href=\"#transcription-tab\" data-toggle=\"tab\">Transcription</a>    </li>    <li>      <a href=\"#url-tab\" data-toggle=\"tab\">URL</a>    </li>  </ul>  <div class=\"tab-content\">    <div id=\"relation-tab\" class=\"tab-pane active\">      <div class=\"mini-search\"></div>      <div class=\"mini-search-results\">        <div class=\"loading-squares\" style=\"margin-top:40px\"></div>      </div>    </div>    <div id=\"transcription-tab\" class=\"tab-pane\">      <textarea class=\"transcription\" id=\"transcript\"         placeholder=\"Transcribe text within the resource...\"></textarea>    </div>    <div id=\"url-tab\" class=\"tab-pane\">      <div class=\"input-prepend\">        <span class=\"add-on\">http://</span>        <input id=\"url\" class=\"span2\" type=\"text\"           placeholder=\"google.com\"/>      </div>    </div>  </div></div>";
JST["viewer/carousel"] = "<% _.each(resources, function(r, i) { %>  <li>    <img class=\"thumb\" src=\"<%= r.thumb %>\" alt=\"thumbnail\"      style=\"width:100px; height:90px;\" data-id=\"<%= r.id %>\"/>    <div class=\"overlay\">      <span><%= i + 1 + offset %></span>    </div>  </li><% }) %>";
JST["viewer/collection_table"] = "<tr>  <td>Title</td>  <td>    <a class=\"subtle\"       href='<%= arcs.url(\"search\", \"collection:\" + arcs.inflector.enquote(title, false)) %>'>      <%- title || '' %>    </a>  </td></tr><tr>  <td>Description</td>  <td><%= description %></td></tr><% if (pdf) { %><tr>  <td>Original PDF</td>  <td><a href=\"<%= arcs.baseURL + 'resource/' + pdf %>\">Link</a></td></tr><% } %>";
JST["viewer/discussion"] = "<% _.each(comments, function(c) { %><div class=\"comment-wrapper\" id=\"comment-<%= c.id %>\">  <div class=\"comment-voice thumbnail\">    <img class=\"user-thmb\" src=\"http://gravatar.com/avatar/<%= c.gravatar %>?s=40\"/>  </div>  <div class=\"comment-header\">    <a class=\"name subtle\" href=\"<%= arcs.baseURL + 'user/' + c.username %>\">      <%= c.name %>    </a>    commented     <span class=\"time\"><%= relativeDate(new Date(c.created)) %></span>  </div>  <div class=\"comment\"><%- c.content %></div></div><% }) %>";
JST["viewer/document"] = "<iframe src=\"http://docs.google.com/gview?url=<%= url %>&embedded=true\"    style=\"width: 100%; height: 100%; float:left;\" frameborder=\"0\"></iframe>";
JST["viewer/hotkeys"] = "<div class=\"modal hotkeys-modal\">  <div class=\"modal-header\">    <a class=\"hotkeys-close pull-right\">close</a>    <h3>Shortcuts</h3>  </div>  <div class=\"modal-body\">    <table>      <thead>        <tr>          <th>Action</th>          <th>Keys(s)</th>        </tr>      </thead>      <tbody>        <tr>          <td>Navigate pages</td>          <td>            <i class=\"icon-white icon-arrow-left\"></i>            <i class=\"icon-white icon-arrow-right\"></i>          </td>        </tr>        <tr>          <td>Annotate</td>          <td>            <i class=\"icon-white icon-screenshot\"></i>          </td>        </tr>        <tr>          <td>Edit info</td>          <td><%= ctrl %> + E</td>        </tr>        <tr>          <td>Enter page number</td>          <td>P</td>        </tr>        <tr>          <td>Toggle annotation visibility</td>          <td>A</td>        </tr>        <tr>          <td>Zoom in</td>          <td>            <i class=\"icon-white icon-plus\"></i>          </td>        </tr>        <tr>          <td>Zoom out</td>          <td>            <i class=\"icon-white icon-minus\"></i>          </td>        </tr>      </tbody>    </table>  </div></div>";
JST["viewer/hotspots"] = "<% _.each(annotations, function(a) { %>  <% a.url = a.url || '#' %>  <a class=\"hotspot\" style=\"left:<%= a.x1 + offset %>px; top:<%= a.y1 %>px;     width:<%= a.x2 - a.x1 %>px; height:<%= a.y2 - a.y1 %>px;\" data-id=\"<%= a.id %>\"     href=\"<%= a.relation ? arcs.url('resource', a.relation.id) : a.url %>\">    <% if (arcs.user.is('Sr. Researcher') || a.user_id == arcs.user.id) { %>      <i class=\"remove-btn icon-remove\"></i>    <% } %>  </a><% }) %>";
JST["viewer/image"] = "<img src=\"<%= preview || url %>\" alt=\"resource\" data-zoom=\"1\" data-id=\"<%= id %>\">";
JST["viewer/keywords"] = "<ul class=\"keyword-list\"><% _.each(keywords, function(k) { %>  <li>    <a class=\"keyword-link subtle\" id=\"keyword-<%= k.id %>\"       href=\"<%= k.link %>\" data-id=\"<%= k.id %>\"><%- k.keyword %></a>    <% if (arcs.user.is('Sr. Researcher') || k.user_id == arcs.user.id) { %>      <i class=\"keyword-remove-btn icon-remove\"></i>    <% } %>  </li><% }) %></ul>";
JST["viewer/popover"] = "<% if (relation) { %>  <h3>  <% if (arcs.mime.isImage(relation.mime_type)) { %>    <i class=\"icon-picture\"></i>  <% } else if (arcs.mime.isVideo(relation.mime_type)) { %>    <i class=\"icon-film\"></i>  <% } else { %>    <i class=\"icon-file\"></i>  <% } %>  <%= relation.title %>  </h3>  <h4><%= relation.type %></h4>  <br><img class=\"thumb\" src=\"<%= relation.thumb %>\"/><% } else if (transcript) { %>  <p><%= arcs.inflector.truncate(transcript, 500) %></p><% } else { %>  <a href=\"<%= url %>\"><%= url %></a><% } %>";
JST["viewer/popover_title"] = "<% if (type == 'Relation') { %>Relation <i class=\"icon-magnet\"></i> <% } if (type == 'Transcription') { %>Transcription <i class=\"icon-align-justify\"></i> <% } if (type == 'URL') { %>URL <i class=\"icon-share\"></i><% } %>";

JST["viewer/table"] = "<tr>  <td>Title</td>  <td>    <a class=\"subtle\"       href='<%= arcs.url(\"search\", \"title:\" + arcs.inflector.enquote(title, false)) %>'>      <%- title || '' %>    </a>  </td></tr><tr>  <td>Access</td>  <td>    <a class=\"subtle\" href=\"<%= arcs.url('search', 'access:' + (public ? 'public' : 'private')) %>\">      <%= public ? \"public\" : \"private\" %>    </a>  </td></tr><tr>  <td>Type</td>  <td>    <a class=\"subtle\"       href='<%= arcs.url(\"search\", \"type:\" + arcs.inflector.enquote(type, false)) %>'>      <%- type || '' %>    </a>  </td></tr><tr>  <td>Created</td>  <td><%= created %></td></tr><% if (modified) { %><tr>  <td>Modified</td>  <td><%= modified %></td></tr><% } %><tr>  <td>File-name</td>  <td><a href=\"<%= url %>\"><%= file_name %></a></td></tr><tr>  <td>File-type</td>  <td><%= mime_type %></td></tr><% _.each(metadata.attributes, function(v, k) { %>  <% if (v) { %>  <tr>    <td><%- k.charAt(0).toUpperCase() + k.substr(1) %></td>    <td>    <% if (k.match(/date/i)) { %>      <%- v %>    <% } else { %>      <a class=\"subtle\"        href='<%= arcs.url(\"search\", k + \":\" + arcs.inflector.enquote(v, false)) %>'>        <%- v %>      </a>    <% } %>    </td>  </tr>  <% } %><% }) %>";
