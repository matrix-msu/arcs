<?php
App::uses('MetaResourcesController', 'Controller');
/**
 * Flags controller.
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
class FlagsController extends MetaResourcesController {
	public $name = 'Flags';
	
	public function beforeFilter() {
        parent::beforeFilter();
        $this->loadModel('Resources');

		$resource = $this->Resources->find('all', array(
			'conditions' => array('Resources.title' => $this->request->data['resource_name'])
		));
		
		$user = $this->Auth->User();
		
		$this->request->data['resource_id'] = $resource[0]['Resources']['id'];
		$this->request->data['user_id'] = $user['id'];
		$this->request->data['user_name'] = $user['name'];
		$this->request->data['user_username'] = $user['username'];
		$this->request->data['user_email'] = $user['email'];
    }
	
	
}
