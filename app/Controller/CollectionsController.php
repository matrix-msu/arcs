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
            'order' => 'Collection.modified DESC',

            //Josh- added this line to group by collection
            'group' => 'collection_id'
        )));
    }

    /**
     * Get all collections a resource is a part of
     */
    public function memberships($id) {

        //handle collections info on the single resource page
        if (isset($this->request->query['id'])){
            $resource_id = $this->request->query['id'];
            $retval['id'] = $resource_id;

            //$collections = array();
            //// Start SQL Area
            ///////////////////
            include_once("../Config/database.php");
            $db = new DATABASE_CONFIG();
            $db_object =  (object) $db;
            $db_array = $db_object->{'default'};
            $response['db_info'] = $db_array['host'];
            $mysqli = new mysqli($db_array['host'], $db_array['login'], $db_array['password'], $db_array['database']);

            if ($mysqli->connect_error) {
                die('Connect Error (' . $mysqli->connect_errno . ') '
                    . $mysqli->connect_error);
            }
            //Get collections info from the resource_kid
            $sql = "SELECT DISTINCT collections.collection_id, collections.title, collections.user_name
                    FROM arcs_dev.collections 
                    WHERE collections.resource_kid ='".$resource_id."';";
            $result = $mysqli->query($sql);
            while($row = mysqli_fetch_assoc($result))
              $collections[] = $row;
            //$response['collection_table_id'] = $collection_table_id;
            //$response['sql'] = $sql;
            //$collection_id = mysqli_fetch_assoc($result);
            //$collection_id = $collection_id['collection_id'];

            $retval['collections'] = $collections;
            return $this->json(200, $retval);
        }
        $this->loadModel('Membership');
        $ids = $this->Membership->memberships($id);
        $collections = $this->Collection->find('all', array(
            'order' => 'Collection.modified DESC',
            'conditions' => array(
                "Collection.id" => $ids
            )
        ));
        $this->json(200, $collections);
    }

    /**
     * Create a new collection.
     */
    public function add() {
        if (!$this->request->is('post')) {$this->json(405); throw new MethodNotAllowedException();}
        if (!$this->request->data) {$this->json(400); throw new BadRequestException();}

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
        if (!$this->request->is('post')) {$this->json(405); throw new MethodNotAllowedException();}
        if (!$this->request->data) {$this->json(400); throw new BadRequestException();}

        $this->Collection->permit('collection_id');
        $this->Collection->permit('resource_kid');
        $this->Collection->permit('user_id');
        $this->Collection->permit('user_name');

        $collection = $this->Collection->findByCollection_id($this->request->data['collection']);

        if (isset($collection)) {
            $collection = $collection['Collection'];

            $object = array(
                'collection_id' => $collection['collection_id'],
                'resource_kid'  => $this->request->data['resource_kid'],
                'user_id'       => $this->Auth->user('id'),
                'user_name'     => $this->Auth->user('name'),
                'title'         => $collection['title'],
                'description'   => $collection['description'],
                'public'        => $collection['public']
            );

            $this->Collection->add($object);
            $this->json(201, $object);
            return;
        }
        $this->json(400);
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
     * Return an array of (id, title, collection_id) pairs. Similar to `complete`, but includes
     * the ids.
     */
    public function titlesAndIds() {
        //if (!$this->request->is('get')) throw new MethodNotAllowedException();
        return $this->json(200, $this->Collection->find('all', array(
            'fields' => array('Collection.title', 'Collection.collection_id', 'Collection.user_name'),
            'group' => 'collection_id',
            'order' => 'Collection.modified DESC'
        )));
    }

    /**
     * Return an array of (user_id, user_name) pairs.
     */
    public function distinctUsers() {
        //if (!$this->request->is('get')) throw new MethodNotAllowedException();
        return $this->json(200, $this->Collection->find('all', array(
            'fields' => array('Collection.user_id', 'Collection.user_name'),
            'group' => 'Collection.user_id',
            'order' => 'Collection.user_name'
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

    /**
     * Find all collections associated with user id - may or may not be used by activity tab on user profile page
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
