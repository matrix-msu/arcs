<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *f
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

 ////////////////////////////////////////////////////////////////////////
 # Test Controller
 ////////////////////////////////////////////////////////////////////////
     // router::connect('/test/*',
        // array('controller' => 'test', 'action' => 'test')
     // );

////////////////////////////////////////////////////////////////////////
# pages controller
////////////////////////////////////////////////////////////////////////
    # Pages routes
    Router::connect('/pages/*',
        array('controller' => 'pages', 'action' => 'display')
    );

    # Error pages
    Router::connect('/404',
        array('controller' => 'pages', 'action' => 'display', '404')
    );
    # Cake Error page
    Router::connect('/500',
        array('controller' => 'pages', 'action' => 'display', '500')
    );
//    # About
//    Router::connect('/about',
//        array('controller' => 'pages', 'action' => 'display', 'about')
//    );
    # Upload
    Router::connect('/upload',
        array('controller' => 'uploads', 'action' => 'batch')
    );
////////////////////////////////////////////////////////////////////////
# projects controller
////////////////////////////////////////////////////////////////////////
    # Home page
    Router::connect('/',
        array('controller' => 'projects', 'action' => 'index')
    );
    Router::connect("/projects/single_project/*",
        array('controller' => 'projects', 'action' => 'single_project')
    );
/////////////////////////////////////////////////////////////////////////f
# resources controller
////////////////////////////////////////////////////////////////////////
    Router::connect('/view/*',
        array('controller' => 'resources', 'action' => 'multi_viewer')
    );
    # Resource, collection and user singular aliases
    Router::connect('/resource/*',
        array('controller' => 'resources', 'action' => 'multi_viewer')
    );
    # Non-RESTful API routes
    Router::connect('/api/search',
        array('controller' => 'search', 'action' => 'resources')
    );
    Router::connect('/api/resources/keywords/*',
        array('controller' => 'resources', 'action' => 'keywords')
    );
    Router::connect('/api/resources/comments/*',
        array('controller' => 'resources', 'action' => 'keywords')
    );
    Router::connect('/api/resources/export',
        array('controller' => 'resources', 'action' => 'export')
    );
    Router::connect('/api/getMetadataEditsControlOptions',
        array('controller' => 'resources', 'action' => 'getMetadataEditsControlOptions')
    );

    # Accepted resources/ subpaths.
    Router::connect('/resources/loadNewResource/*',
        array('controller' => 'resources', 'action' => 'loadNewResource')
    );
    Router::connect('/resources/createExportFile',
        array('controller' => 'resources', 'action' => 'createExportFile')
    );
	Router::connect('/resources/downloadExportFile',
        array('controller' => 'resources', 'action' => 'downloadExportFile')
    );
    Router::connect('/resources/createPictureExportFile',
        array('controller' => 'resources', 'action' => 'createPictureExportFile')
    );
	Router::connect('/resources/downloadPictureExportFile',
        array('controller' => 'resources', 'action' => 'downloadPictureExportFile')
    );
    Router::connect('/resources/checkExportDone',
        array('controller' => 'resources', 'action' => 'checkExportDone')
    );
    Router::connect('/resources/export',
        array('controller' => 'resources', 'action' => 'export')
    );
    Router::connect('/search/collection/*',
        array('controller' => 'resources', 'action' => 'viewcollection')
    );
    Router::connect('/search/resource_type/*',
        array('controller' => 'resources', 'action' => 'viewtype')
    );
	Router::connect('/resources/viewkid/*',
        array('controller' => 'resources', 'action' => 'viewKid')
    );
    Router::connect('/resources/findallbyuser',
        array('controller' => 'resources', 'action' => 'findAllByUser')
    );
    # We can access the JSON search through either /api/search or this:
    Router::connect('/resources/search',
        array('controller' => 'search', 'action' => 'resources')
    );
    Router::connect('/resources/advanced_search',
        array('controller' => 'search', 'action' => 'advanced_resources')
    );
    Router::connect('/resources/complete',
        array('controller' => 'search', 'action' => 'complete')
    );
    # Resource page with a project-KID parameter.
    # This needs to be last so the above 3 routes are caught first.
    Router::connect('/resources/*',
        array('controller' => 'pages', 'action' => 'display', 'resources')
    );

////////////////////////////////////////////////////////////////////////
# collections controller
////////////////////////////////////////////////////////////////////////
    Router::connect('/collections/memberships',
        array('controller' => 'collections', 'action' => 'memberships')
    );
    Router::connect('/collections/titlesAndIds',
        array('controller' => 'collections', 'action' => 'titlesAndIds')
    );
    Router::connect('/collections/add',
        array('controller' => 'collections', 'action' => 'add')
    );
    Router::connect('/collections/addToExisting',
        array('controller' => 'collections', 'action' => 'addToExisting')
    );
    Router::connect('/collections/distinctUsers',
        array('controller' => 'collections', 'action' => 'distinctUsers')
    );
    Router::connect('/collections/editCollection',
        array('controller' => 'collections', 'action' => 'editCollection')
    );
    Router::connect('/collections/deleteResource',
        array('controller' => 'collections', 'action' => 'deleteResource')
    );
    Router::connect('/collections/findallbyuser',
        array('controller' => 'collections', 'action' => 'findAllByUser')
    );
    # Collections page
    Router::connect('/collections/*',
        array('controller' => 'collections', 'action' => 'index')
    );
////////////////////////////////////////////////////////////////////////
# users controller
////////////////////////////////////////////////////////////////////////
    Router::connect('/user/edit/*',
        array('controller' => 'users', 'action' => 'edit')
    );
    Router::connect('/user/*',
        array('controller' => 'users', 'action' => 'profile')
    );
    Router::connect('/users/reset_password/*',
        array('controller' => 'users', 'action' => 'reset_password')
    );
    Router::connect('/users/confirm_user/*',
        array('controller' => 'users', 'action' => 'confirm_user')
    );
    Router::connect('/users/special_login',
        array('controller' => 'users', 'action' => 'special_login')
    );
    Router::connect('/api/users/invite',
        array('controller' => 'users', 'action' => 'ajaxInvite')
    );
    Router::connect('/api/users/add',
        array('controller' => 'users', 'action' => 'ajaxAdd')
    );
    Router::connect('/api/users/delete',
        array('controller' => 'users', 'action' => 'ajaxDelete')
    );
    Router::connect('/api/users/update',
        array('controller' => 'users', 'action' => 'ajaxUpdate')
    );
	Router::connect('/api/users/upload',
		array('controller' => 'users', 'action' => 'ajaxUploadProfImage')
	);
    Router::connect('/users/getUsername',
        array('controller' => 'users', 'action' => 'getEmail')
    );
    Router::connect('/users/getEmail',
        array('controller' => 'users', 'action' => 'getUsername')
    );
    Router::connect('/users/missingPictureNotifyAdmin',
        array('controller' => 'users', 'action' => 'sendMissingImageEmail')
    );
	Router::connect('/users/uploadProfileImage',
		array('controller' => 'users', 'action' => 'uploadProfileImage')
	);

    Router::connect('/k3test',
		array('controller' => 'collections', 'action' => 'testK3Projects')
	);


    Router::connect('/findUnassociatedResources',
        array('controller' => 'resources', 'action' => 'findUnassociatedResources')
    );


    # Signup
    Router::connect('/register/*',
        array('controller' => 'users', 'action' => 'register')
    );
    # Invitation Signup
    Router::connect('/invitation/register/*',
        array('controller' => 'users', 'action' => 'registerByInvite')
    );
    # logout
    Router::connect('/logout',
        array('controller' => 'users', 'action' => 'logout')
    );
    Router::connect('/users/request_permission/*',
        array('controller' => 'users', 'action' => 'requestPermission')
    );
///////
//toolbar
//////
    Router::connect('/users/getAllUsers',
        array('controller' => 'users', 'action' => 'getAllUsers')
    );
////////////////////////////////////////////////////////////////////////
# advancedSearch controller
////////////////////////////////////////////////////////////////////////
    // order matters here! do not move this below search.
    Router::connect('/search/advanced/view/*',
        array('controller' => 'AdvancedSearch', 'action' => 'viewer')
    );
    Router::connect('/search/advanced/*',
        array('controller' => 'AdvancedSearch', 'action' => 'display')
    );
    Router::connect('/api/search/advanced/*',
        array('controller' => 'AdvancedSearch', 'action' => 'searchAPI')
    );
    Router::connect('/api/search/get_rest/advanced/images',
        array('controller' => 'AdvancedSearch', 'action' => 'advancedGetRestImages')
    );
    Router::connect('/api/search/get_rest/advanced',
        array('controller' => 'AdvancedSearch', 'action' => 'advancedGetRest')
    );

////////////////////////////////////////////////////////////////////////
# search controller
////////////////////////////////////////////////////////////////////////
//    Router::connect('/search/keyword/*',
//        array('controller' => 'search', 'action' => 'keywordSearch')
//    );
//    Router::connect('/simple_search/*',
//        array('controller' => 'AdvancedSearch', 'action' => 'simpleSearchWrapper')
//    );
    Router::connect('/simple_search_no_data/*',
        array('controller' => 'search', 'action' => 'simple_search_no_data')
    );
    Router::connect('/simple_search/*',
        array('controller' => 'search', 'action' => 'simple_search')
    );
    Router::connect('/api/simple_search/***',
        array('controller' => 'search', 'action' => 'simple_search')
    );
    Router::connect('/simple_search/user_verify',
        array('controller' => 'search', 'action' => 'verify')
    );
    Router::connect('/api/simple_search/user_verify',
        array('controller' => 'search', 'action' => 'verify')
    );
    Router::connect('/sites',
        array('controller' => 'search', 'action' => 'getProjects')
    );
    Router::connect('/search/*',
        array('controller' => 'search', 'action' => 'search')
    );
	   Router::connect('/search/paginate',
        array('controller' => 'search', 'action' => 'paginate')
    );
////////////////////////////////////////////////////////////////////////
# redirects
////////////////////////////////////////////////////////////////////////
    # Search must have a trailing slash, for the client-side code's sanity.
    Router::redirect('/search', 'search/');
    Router::redirect('/simple_search', 'simple_search/');
    Router::redirect('/advanced_search', 'advanced_search/');
    # Configuration status
    Router::connect('/admin/status',
        array('controller' => 'admin', 'action' => 'status')
    );
    Router::redirect('/admin',
        array('controller' => 'admin', 'action' => 'status')
    );

////////////////////////////////////////////////////////////////////////
# help Controller


////////////////////////////////////////////////////////////////////////
//    # Docs routes
//    Router::connect('/help',
//        array('controller' => 'help', 'action' => 'display', 'index')
//    );
//    Router::connect('/help/*',
//        array('controller' => 'help', 'action' => 'display')
//    );
////////////////////////////////////////////////////////////////////////
# annotations Controller
////////////////////////////////////////////////////////////////////////
    Router::connect('/api/annotations/findByKid',
          array('controller' => 'annotations', 'action' => 'findByKid')
    );
    Router::connect('/api/annotations/delete/*',
          array('controller' => 'annotations', 'action' => 'deleteAnnotation')
    );
////////////////////////////////////////////////////////////////////////
# MetadataEdits Controller
////////////////////////////////////////////////////////////////////////
    Router::connect('/metadataedits/add',
        array('controller' => 'MetadataEdits', 'action' => 'add')
    );
    Router::connect('/metadataedits/getAllKidsByScheme',
      array('controller' => 'MetadataEdits', 'action' => 'getAllKidsByScheme')
    );
////////////////////////////////////////////////////////////////////////
# profile routes
////////////////////////////////////////////////////////////////////////
    Router::connect('/metadataedits/findallbyuser',
        array('controller' => 'MetadataEdits', 'action' => 'findAllByUser')
    );
    Router::connect('/annotations/findallbyuser',
        array('controller' => 'annotations', 'action' => 'findallbyuser')
    );
    Router::connect('/comments/findallbyuser',
        array('controller' => 'comments', 'action' => 'findallbyuser')
    );
    Router::connect('/flags/findallbyuser',
        array('controller' => 'flags', 'action' => 'findAllByUser')
    );
    Router::connect('/users/findbyid',
        array('controller' => 'users', 'action' => 'findbyid')
    );
////////////////////////////////////////////////////////////////////////
# keywords Controller
////////////////////////////////////////////////////////////////////////
    Router::connect('/keywords/get',
        array('controller' => 'keywords', 'action' => 'get')
    );
    Router::connect('/keywords/add',
        array('controller' => 'keywords', 'action' => 'add')
    );
    Router::connect('/keywords/common',
        array('controller' => 'keywords', 'action' => 'common')
    );
    Router::connect('/keywords/deleteKeyword',
        array('controller' => 'keywords', 'action' => 'deleteKeyword')
    );
    Router::connect('/keywords/findallbyuser',
        array('controller' => 'keywords', 'action' => 'findAllByUser')
    );
////////////////////////////////////////////////////////////////////////
# comments controller
////////////////////////////////////////////////////////////////////////
  Router::connect('/comments/findall',
      array('controller' => 'comments', 'action' => 'findall')
  );
  Router::connect('/comments/editComment',
      array('controller' => 'comments', 'action' => 'editComment')
  );
   Router::connect('/flags/add',
        array('controller' => 'flags', 'action' => 'add')
    );
    ////////////////////////////////////////////////////////////////////////
    # installation Controller
    ////////////////////////////////////////////////////////////////////////
    Router::connect('/installation',
        array('controller' => 'installations', 'action' => 'display', 'index')
    );
    Router::connect('/installation/register',
       array('controller' => 'installations', 'action' => 'register')
    );
//   Router::connect('/installation/kora',
//      array('controller' => 'installations', 'action' => 'koraConfig')
//    );
    Router::connect('/installation/field',
       array('controller' => 'installations', 'action' => 'fieldConfig')
    );
     Router::connect('/installation/create',
        array('controller' => 'installations', 'action' => 'createProject')
    );
    Router::connect('/installation/config',
        array('controller' => 'installations', 'action' => 'arcsConfig')
    );
    Router::connect('/installation/finalize',
        array('controller' => 'installations', 'action' => 'finalize')
    );
//    Router::connect('/installation/periodo',
//        array('controller' => 'installations', 'action' => 'periodo')
//    );



# Orphans controller
Router::connect('/orphan/*',
    array('controller' => 'orphans', 'action' => 'display')
);

#admin pages
Router::connect('/admintools/activity/*',
    array('controller' => 'admin', 'action' => 'activity')
);
Router::connect('/admintools/flags/*',
    array('controller' => 'admin', 'action' => 'flags')
);
Router::connect('/admintools/metadata_edits/*',
    array('controller' => 'admin', 'action' => 'metadata_edits')
);
Router::connect('/admintools/users/*',
    array('controller' => 'admin', 'action' => 'users')
);
Router::connect('/users/uploadProfileImage',
  array('controller' => 'users', 'action' => 'uploadProfileImage')
);
Router::connect('/admin/editFlags/*',
    array('controller' => 'admin', 'action' => 'editFlags')
);
Router::connect('/admin/editMetadata/*',
    array('controller' => 'admin', 'action' => 'editMetadata')
);
Router::connect('/admin/accept/*',
    array('controller' => 'admin', 'action' => 'accept')
);
Router::connect('/admin/getProfilePics',
    array('controller' => 'admin', 'action' => 'ajaxGetProfilePics')
);


////////////////////////////////////////////////////////////////////////
# add projects controller
////////////////////////////////////////////////////////////////////////
Router::connect('/add_project',
    array('controller' => 'AddProjects',  'action' => 'display')
);
Router::connect('/add_project/download',
    array('controller' => 'AddProjects',  'action' => 'download')
);
Router::connect('/add_project/config',
    array('controller' => 'AddProjects',  'action' => 'projectConfig')
);
Router::connect('/add_project/create',
    array('controller' => 'AddProjects',  'action' => 'createProject')
);
Router::connect('/add_project/finalize',
    array('controller' => 'AddProjects',  'action' => 'finalize')
);
Router::connect('/add_project/field',
    array('controller' => 'AddProjects', 'action' => 'fieldConfig')
);
Router::connect('/add_project/downloadLayoutFile',
    array('controller' => 'AddProjects', 'action' => 'downloadLayoutFile')
);




    $restful = array(
        'resources',
        'comments',
        'keywords',
        'annotations',
        'bookmarks',
        'users',
        'flags',
        'jobs',
        'metadata',
        'MetadataEdits',
        'collections',
        'simple_search',
        'advanced_search'
    );

    Router::mapResources($restful);
    Router::mapResources($restful, array('prefix' => '/api/'));
    Router::parseExtensions();
    Router::parseExtensions( 'json' );

	CakePlugin::routes();
	require CAKE . 'Config' . DS . 'routes.php';
