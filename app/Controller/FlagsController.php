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
        $this->Auth->allow('findAllByUser');

		$user = $this->Auth->User();
		$this->request->data['user_id'] = $user['id'];
		$this->request->data['user_name'] = $user['name'];
		$this->request->data['user_username'] = $user['username'];
		$this->request->data['user_email'] = $user['email'];
    }

	/**
	 * Find all flags associated with user id
	 */
	public function findAllByUser()
	{
		$model = $this->modelClass;
		$results = $this->$model->find('all', array(
			'conditions' => array('user_id' => $this->request->data['id'])
		));
		foreach ($results as $key => $flag) {
			$results[$key]['time_string'] = parent::time_elapsed_string($flag['created']);
		}
		$this->json(200, $results);
	}
}
