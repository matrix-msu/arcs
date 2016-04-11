<?php
/**
 * Collections Controller
 * 
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
class CollectionsController extends AppController {
    public $name = 'Collections';

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('viewer', 'index', 'create', 'complete');
    }

    /**
     * Display all collections.
     */
    public function index() {
        $this->Collection->recursive = -1;

        $collections = $this->Collection->find('all', array(
            'order' => 'Collection.modified DESC'
        ));
        
        $this->set('collections', $this->Collection->find('all', array(
            'order' => 'Collection.modified DESC'
        )));
    }

    /**
     * Create a new collection.
     */
    public function add() {
        if (!$this->request->is('post')) {throw new MethodNotAllowedException();}
        if (!$this->request->data) {throw new BadRequestException();}

        // Save the collection.
        $this->request->data['collection_id'] = String::uuid();
        $this->Collection->permit('collection_id');
        $this->Collection->permit('resource_kid');
        $this->request->data['user_id'] = $this->Auth->user('id');
        $this->Collection->permit('user_id');
        $this->request->data['user_name'] = $this->Auth->user('name');
        $this->Collection->permit('user_name');
        $this->Collection->add($this->request->data);
        $this->Collection->flatten = true;
        $this->json(201, $this->Collection->findById($this->Collection->id));
    }

    /**
     * Add resource to an existing collection(s).
     */
    public function addToExisting() {
        if (!$this->request->is('post')) {throw new MethodNotAllowedException();}
        if (!$this->request->data) {throw new BadRequestException();}

        $length = count($this->request->data['collections']);
        debug($length);
        for ($i=0; $i<$length; $i++) {
            // make sure collection already exists
            $collection = $this->Collection->findById($this->request->data['collections'][$i]);
            if ($collection) {
                $object = array(
                    'collection_id' => $collection['collection_id'],
                    'resource_kid'  => $this->request->data['resource_kid'],
                    'user_id'       => $this->Auth->user('id'),
                    'user_name'     => $this->Auth->user('name'),
                    'title'         => $collection['title'],
                    'description'   => $collection['description'],
                    'public'        => $collection['public']
                );
                $this->Collection->permit('collection_id');
                $this->Collection->permit('resource_kid');
                $this->Collection->permit('user_id');
                $this->Collection->permit('user_name');

                debug($object);

                $this->Collection->add($object);
            }
        }
        $this->json(201);
    }

    /**
     * Update the collection.
     *
     * @param string $id
     */
    public function update($id=null) {
        $this->json(501);
    }

    /**
     * Delete a collection.
     *
     * @param string id
     */
    public function delete($id=null) {
        if (!$this->request->is('delete')) throw new MethodNotAllowedException();
        if (!$this->Access->isAdmin()) throw new ForbiddenException();
        if (!$this->Collection->delete($id)) throw new NotFoundException();
        $this->json(204);
    }

    /**
     * View a collection.
     *
     * @param string $id
     */
    public function viewer($id=null) {
        if (!$id) throw new BadRequestException();
        $collection = $this->Collection->findById($id);
        if (!$collection) throw new NotFoundException();
        $this->set('title_for_layout', $collection['Collection']['title']);
        $this->set('body_class', 'viewer');
        $this->set('footer', false);
        $this->loadModel('Resource');
        $rids = $this->Collection->Membership->members($id);
        $this->set('resources', $this->Resource->find('all', array(
            'conditions' => array(
                'Resource.id' => $rids
        ))));
        $this->set('collection', $collection['Collection']);
        $this->set('toolbar', array(
            'actions' => true,
            'logo' => true
        ));
    }

    /**
     * Return an array of (id, title) pairs. Similar to `complete`, but includes
     * the ids.
     */
    public function titles() {
        if (!$this->request->is('get')) throw new MethodNotAllowedException();
        return $this->json(200, $this->Collection->find('list', array(
            'fields' => 'Collection.title'
        )));
    }

    /**
     * Complete collection titles.
     */
    public function complete() {
        if (!$this->request->is('get')) throw new MethodNotAllowedException();
        return $this->json(200, $this->Collection->complete(
            'Collection.title', array(
                'Collection.title !=' => 'Temporary Collection'
            )
        ));
    }
}
