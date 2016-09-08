<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
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
# pages controller
////////////////////////////////////////////////////////////////////////
    # Pages routes
    Router::connect('/pages/*',
        array('controller' => 'pages', 'action' => 'display')
    );
    # Resource page
    Router::connect('/resources',
        array('controller' => 'pages', 'action' => 'display', 'resources')
    );
    # Error pages
    Router::connect('/404',
        array('controller' => 'pages', 'action' => 'display', '404')
    );
    # Cake Error page
    Router::connect('/500',
        array('controller' => 'pages', 'action' => 'display', '500')
    );
    # About
    Router::connect('/about',
        array('controller' => 'pages', 'action' => 'display', 'about')
    );
    # Upload
    Router::connect('/upload',
        array('controller' => 'uploads', 'action' => 'batch')
    );
////////////////////////////////////////////////////////////////////////
# projects controller
////////////////////////////////////////////////////////////////////////
    # Home page
    Router::connect('/',
        array('controller' => 'projects', 'action' => 'display', 'index')
    );
    Router::connect("/projects/single_project/*",
        array('controller' => 'projects', 'action' => 'single_project')
    );
/////////////////////////////////////////////////////////////////////////
# resources controller
////////////////////////////////////////////////////////////////////////

    # Resource, collection and user singular aliases
    Router::connect('/resource/*',
        array('controller' => 'resources', 'action' => 'viewer')
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
    Router::connect('/resources/loadNewResource/*',
        array('controller' => 'resources', 'action' => 'loadNewResource')
    );
    Router::connect('/resources/export',
        array('controller' => 'resources', 'action' => 'export')
    );

////////////////////////////////////////////////////////////////////////
# collections controller
////////////////////////////////////////////////////////////////////////
    # Collections page
    Router::connect('/collections',
        array('controller' => 'collections', 'action' => 'index')
    );
    Router::connect('/collections/memberships',
        array('controller' => 'collections', 'action' => 'memberships')
    );
    Router::connect('/collections/titlesAndIds',
        array('controller' => 'collections', 'action' => 'titlesAndIds')
    );
////////////////////////////////////////////////////////////////////////
# users controller
////////////////////////////////////////////////////////////////////////
    Router::connect('/user/*',
        array('controller' => 'users', 'action' => 'profile')
    );
    Router::connect('/user/edit/*',
        array('controller' => 'users', 'action' => 'edit')
    );
    Router::connect('/users/confirm_user/*',
        array('controller' => 'users', 'action' => 'confirm_user')
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
////////////////////////////////////////////////////////////////////////
# search controller
////////////////////////////////////////////////////////////////////////
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
    Router::connect('/search/**',
        array('controller' => 'search', 'action' => 'search')
    );
	   Router::connect('/search/paginate',
        array('controller' => 'search', 'action' => 'paginate')
    );
    # We can access the JSON search through either /api/search or this:
    Router::connect('/resources/search',
        array('controller' => 'search', 'action' => 'resources')
    );
    Router::connect('/resources/complete',
        array('controller' => 'search', 'action' => 'complete')
    );
////////////////////////////////////////////////////////////////////////
# advancedSearch controller
////////////////////////////////////////////////////////////////////////
    Router::connect('/advanced_search',
        array('controller' => 'AdvancedSearch', 'action' => 'advance_search')
    );

    Router::connect('/advanced_search/*',
        array('controller' => 'AdvancedSearch', 'action' => 'advanced_search')
    );

    Router::connect('/api/advanced_search/*',
        array('controller' => 'AdvancedSearch', 'action' => 'advanced_search')
    );
	  Router::connect('/resources/flags/add',
        array('controller' => 'flags', 'action' => 'add')
    );
////////////////////////////////////////////////////////////////////////
# redirects
////////////////////////////////////////////////////////////////////////
    # Search must have a trailing slash, for the client-side code's sanity.
    Router::redirect('/search', 'search/');
    Router::redirect('/simple_search', 'simple_search/');
    Router::redirect('/advanced_search', 'advanced_search/');
    # Configuration status
    Router::redirect('/admin',
        array('controller' => 'admin', 'action' => 'status')
    );
////////////////////////////////////////////////////////////////////////
# help Controller
////////////////////////////////////////////////////////////////////////
    # Docs routes
    Router::connect('/help',
        array('controller' => 'help', 'action' => 'display', 'index')
    );
    Router::connect('/help/*',
        array('controller' => 'help', 'action' => 'display')
    );
////////////////////////////////////////////////////////////////////////
# annotations Controller
////////////////////////////////////////////////////////////////////////
    Router::connect('/api/annotations/findall',
          array('controller' => 'annotations', 'action' => 'findAll')
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
////////////////////////////////////////////////////////////////////////
##################
////////////////////////////////////////////////////////////////////////

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
