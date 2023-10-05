<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link https://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();

/**
 * Displays a view
 *
 * @return CakeResponse|null
 * @throws ForbiddenException When a directory traversal attempt.
 * @throws NotFoundException When the view file could not be found
 *   or MissingViewException in debug mode.
 */
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		if (in_array('..', $path, true) || in_array('.', $path, true)) {
			throw new ForbiddenException();
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}
	// Auth functions: sessions not required
	public function authRegister() {
		$this->layout = 'authLayout';
		$this->set('title', 'Register');
		$this->Session->destroy();
	}

	public function authLogin() {
		$this->layout = 'authLayout';
		$this->set('title', 'Login');
		$this->Session->destroy();
	}

	public function authSuccess() {
		$this->layout = 'authLayout';
		$this->set('title', 'Success');
		// Check session 
		if (!$this->Session->check('User')) {
			$this->redirect(array('controller' => 'pages', 'action' => 'authLogin'));
		}
	}

	// Main page functions: sessions are required
	public function index() {
		$this->layout = 'indexLayout';
		$this->set('title', 'Home');
		$this->set('pageTitle', 'Message List');
		// Check session 
		if (!$this->Session->check('User')) {
			$this->redirect(array('controller' => 'pages', 'action' => 'authLogin'));
		}
	}

	public function userProfile() {
		$this->layout = 'indexLayout';
		$this->set('title', 'Profile');
		$this->set('pageTitle', 'User Profile');
		// Check session 
		if (!$this->Session->check('User')) {
			$this->redirect(array('controller' => 'pages', 'action' => 'authLogin'));
		}
	}
	public function userProfileEdit() {
		$this->layout = 'indexLayout';
		$this->set('title', 'Edit Profile');
		$this->set('pageTitle', 'Edit User Profile');
		
		// Check session 
		if (!$this->Session->check('User')) {
			$this->redirect(array('controller' => 'pages', 'action' => 'authLogin'));
		}
	}

	public function messageCompose() {
		$this->layout = 'indexLayout';
		$this->set('title', 'Compose New Message');
		$this->set('pageTitle', 'New Message');
		// Check session 
		if (!$this->Session->check('User')) {
			$this->redirect(array('controller' => 'pages', 'action' => 'authLogin'));
		}
	}

	// public function messageDetail() {
	// 	$this->layout = 'indexLayout';
	// 	$this->set('title', 'Message Body');
	// 	$this->set('pageTitle', 'Message Details');
	// 	// Check session 
	// 	if (!$this->Session->check('User')) {
	// 		$this->redirect(array('controller' => 'pages', 'action' => 'authLogin'));
	// 	}
	// }
}
