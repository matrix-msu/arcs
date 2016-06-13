<?php
App::uses('MetaResourcesController', 'Controller');
/**
 * Annotations controller.
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
class AnnotationsController extends MetaResourcesController {
    public $name = 'Annotations';
	
	public function beforeFilter() {
        parent::beforeFilter();

		$user = $this->Auth->User();
		
		$this->request->data['user_id'] = $user['id'];
		$this->request->data['user_name'] = $user['name'];
		$this->request->data['user_username'] = $user['username'];
		$this->request->data['user_email'] = $user['email'];
    }

	/**
	 * Find all annotations associated with user id
	 */
	public function findAllByUser()
	{
		$model = $this->modelClass;
		$results = $this->$model->find('all', array(
			'conditions' => array('user_id' => $this->request->data['id'])
		));
		$this->json(200, $results);
	}
}
