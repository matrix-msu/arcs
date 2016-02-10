<?php
/**
 * MetaResources controller.
 *
 * The MetaResource controller is extended in ARCS and used as a template for
 * RESTful actions. It doesn't use views--all data is sent and received as
 * JSON.
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
class MetaResourcesController extends AppController {

    public function beforeFilter() {
		if ($this->request->accepts('application/json')) {
			$this->RequestHandler->renderAs($this, 'json');
		}
        parent::beforeFilter();
        $this->Auth->allow('view');
        $model = $this->modelClass;
        if (!isset($this->request->query['related'])) {
            $this->$model->recursive = -1;
            $this->$model->flatten = true;
        }
    }

    /**
     * Add a meta-resource
     */
    public function add() {
        if (!$this->request->is('post')) throw new MethodNotAllowedException();
        if (!$this->request->data) throw new BadRequestException;
        $model = $this->modelClass;
        //debug($model);
        # if ($model == 'bookmarks' || $model == 'comments' || $model == 'jobs' || $model == 'keywords') {
        $this->$model->permit('user_id');
        $this->request->data['user_id'] = $this->Auth->user('id');
        # } elseif ($model == 'annotations' || $model == 'flags') {
        #   add resource_name, user_name, user_email, user_username, user_id
        # }
        # if ($model == 'flags') {
        # add status
        # }
        if (!$this->$model->add($this->request->data)) 
            throw new InternalErrorException();
        $this->json(201, $this->$model->findById($this->$model->id));
    }

    /**
     * Edit a meta-resource
     *
     * @param string $id
     */
    public function edit($id) {
        if (!($this->request->is('put') || $this->request->is('post'))) 
            throw new MethodNotAllowedException();
            // return $this->json(405);
        $model = $this->modelClass;
        $this->$model->read(null, $id);
        if (!$this->$model->exists()) 
            throw new NotFoundException();
            // return $this->json(404);
        if (!$this->request->data) 
            throw new BadRequestException();
            // return $this->json(400);
        if (!$this->$model->add($this->request->data)) 
            throw new InternalErrorException();
            // return $this->json(500);
        $this->json(200, $this->$model->findById($this->$model->id));
    }

    /**
     * View a meta-resource
     *
     * @param string $id
     */
    public function view($id) {
        //if (!$this->request->is('get')) throw new MethodNotAllowedException();
        $model = $this->modelClass;
        //$result = $this->$model->findById($id);
		$result = $this->$model->find('first', array(
			'conditions' => array('resource_id' => $id)
		));
        //if (!$result) throw new NotFoundException(); 
        $this->json(200, $result);
    }
	
	/**
     * Find all meta-resources
     *
     * @param string $id
     */
    public function findAll() {
        //if (!$this->request->is('get')) throw new MethodNotAllowedException();
        $model = $this->modelClass;
		$results = $this->$model->find('all', array(
			'conditions' => array('page_kid' => $this->request->data['id'])
		));
        //if (!$result) throw new NotFoundException(); 
        $this->json(200, $results);
    }

    /**
     * Delete a meta-resource
     *
     * @param string $id
     */
    public function delete($id) {
        if (!$this->request->is('delete')) throw new MethodNotAllowedException();
        $model = $this->modelClass;
        $this->$model->flatten = true;
        $result = $this->$model->findById($id);
        if (!$result) throw new NotFoundException();
        if (!($this->Access->isSrResearcher() || $this->Access->isCreator($result)))
            throw new ForbiddenException();
        if (!$this->$model->delete($id)) throw new InternalErrorException();
        $this->json(204);
    }
}
