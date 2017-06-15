<?php
App::uses('MetaResourcesController', 'Controller');
/**
 * Comments controller.
 *
 * This controller will only respond to ajax requests.
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
class CommentsController extends MetaResourcesController {
    public $name = 'Comments';

    public function beforeFilter() {
        parent::beforeFilter();

        $user = $this->Auth->User();
        $this->request->data['user_id'] = $user['id'];
        $this->request->data['name'] = $user['name'];
        $this->Auth->allow( 'findAll' );
    }

    /**
     * Find all meta-resources
     */
    public function findAll() {
        $model = $this->modelClass;
        $results = $this->$model->find('all', array(
            'conditions' => array('resource_kid' => $this->request->data['id']),
            'order' => array('created DESC')
        ));
        $this->json(200, $results);
    }

    /**
     * Find all comments by user ID
     */
    public function findAllByUser() {
        $model = $this->modelClass;
        $results = $this->$model->find('all', array(
            'conditions' => array('user_id' => $this->request->data['id']),
            'order' => array('created DESC')
        ));
        $this->json(200, $results);
    }
}
