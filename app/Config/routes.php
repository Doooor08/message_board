<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
 
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));

	Router::connect('/register', array('controller' => 'pages', 'action' => 'authRegister'));
	Router::connect('/register/store', array('controller' => 'auth', 'action' => 'register'));
	Router::connect('/login', array('controller' => 'pages', 'action' => 'authLogin'));
	Router::connect('/login/validate', array('controller' => 'auth', 'action' => 'login'));
	Router::connect('/success', array('controller' => 'pages', 'action' => 'authSuccess'));
	
	Router::connect('/home', array('controller' => 'pages', 'action' => 'index'));
	Router::connect('/profile', array('controller' => 'pages', 'action' => 'userProfile'));
	Router::connect('/profile/edit', array('controller' => 'pages', 'action' => 'userProfileEdit'));
	Router::connect('/profile/update', array('controller' => 'user', 'action' => 'update'));
	Router::connect('/account/edit', array('controller' => 'pages', 'action' => 'userAccountEdit'));
	Router::connect('/account/update', array('controller' => 'auth', 'action' => 'update'));
	
	Router::connect('/compose', array('controller' => 'pages', 'action' => 'messageCompose'));
	Router::connect('/message/all', array('controller' => 'message', 'action' => 'index'));
	Router::connect('/message/view/:id', array('controller' => 'message', 'action' => 'get'));
	Router::connect('/message/store', array('controller' => 'message', 'action' => 'store'));
	Router::connect('/message/reply/:id', array('controller' => 'message', 'action' => 'storeReply'));
	Router::connect('/message/delete/:id', array());
	Router::connect('/message/deleteAll/:id', array());

	Router::connect('/user/all', array('controller' => 'user', 'action' => 'index'));
	Router::connect('/user/:user', array('controller' => 'user', 'action' => 'get'));
	Router::connect('/logout', array('controller' => 'auth', 'action' => 'logout'));
/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
