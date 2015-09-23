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

    # Home page
    Router::connect('/', 
        array('controller' => 'projects', 'action' => 'display', 'index')
    );
    
    Router::connect('/projects', 
        array('controller' => 'projects', 'action' => 'single_project', 'single_project')
    );
	
	# Resource page
    Router::connect('/resources', 
        array('controller' => 'pages', 'action' => 'display', 'resources')
    );

    # Error pages
    Router::connect('/404', 
        array('controller' => 'pages', 'action' => 'display', '404')
    );
    Router::connect('/500', 
        array('controller' => 'pages', 'action' => 'display', '500')
    );

    # About
    Router::connect('/about', 
        array('controller' => 'pages', 'action' => 'display', 'about')
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

    # Upload
    Router::connect('/upload',
        array('controller' => 'uploads', 'action' => 'batch')
    );

    # Resource, collection and user singular aliases
    Router::connect('/resource/*', 
        array('controller' => 'resources', 'action' => 'viewer')
    );
    Router::connect('/collection/*', 
        array('controller' => 'collections', 'action' => 'viewer')
    );
    Router::connect('/user/*', 
        array('controller' => 'users', 'action' => 'profile')
    );
    Router::connect('/user/edit/*', 
        array('controller' => 'users', 'action' => 'edit')
    );

    # Search 
    # (we're using the greedy pattern so that we can match urls with slashes, 
    # e.g. 'search/filetype:application/pdf')
    Router::connect('/search/**', 
        array('controller' => 'search', 'action' => 'search')
    );

    # We can access the JSON search through either /api/search or this:
    Router::connect('/resources/search', 
        array('controller' => 'search', 'action' => 'resources')
    );
    Router::connect('/resources/complete', 
        array('controller' => 'search', 'action' => 'complete')
    );

    # Search must have a trailing slash, for the client-side code's sanity. 
    Router::redirect('/search', 'search/');

    # Configuration status
    Router::redirect('/admin',
        array('controller' => 'admin', 'action' => 'status')
    );

    # Pages routes
    Router::connect('/pages/*', 
        array('controller' => 'pages', 'action' => 'display')
    );

    # Docs routes
    Router::connect('/help',
        array('controller' => 'help', 'action' => 'display', 'index')
    );
    Router::connect('/help/*', 
        array('controller' => 'help', 'action' => 'display')
    );

    # Non-RESTful API routes 
    Router::connect('/api/search',
        array('controller' => 'search', 'action' => 'resources')
    );
    Router::connect('/api/metadata/*',
        array('controller' => 'resources', 'action' => 'metadata')
    );
    Router::connect('/api/resources/keywords/*',
        array('controller' => 'resources', 'action' => 'keywords')
    );
    Router::connect('/api/resources/comments/*',
        array('controller' => 'resources', 'action' => 'keywords')
    );

    Router::connect('/api/users/invite',
        array('controller' => 'users', 'action' => 'ajaxInvite')
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
        'metadata'
    );

    Router::mapResources($restful);
    Router::mapResources($restful, array('prefix' => '/api/'));
    Router::parseExtensions();

	CakePlugin::routes();
	require CAKE . 'Config' . DS . 'routes.php';
