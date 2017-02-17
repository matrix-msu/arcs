<?php
/**
 * Collections Controller
 * 
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */

require_once(KORA_LIB . "Advanced_Search.php");
require_once(KORA_LIB . "General_Search.php");

class CollectionsController extends AppController {
    public $name = 'Collections';

    public function beforeFilter() {
        parent::beforeFilter();

        $pKid = explode('/', $this->request->query['url']);
        //print_r($pKid);
        //exit();
        if( isset($pKid[1]) && sizeof( explode('-', $pKid[1]) ) == 3 ){
            $pKid = $pKid[1];

            //make sure it is a real project
            $fields = array('Name');
            $kora = new General_Search(PROJECT_SID, "kid", "=", $pKid, $fields);
            $project = json_decode($kora->return_json(), true);

            if(empty($project)){    //not a real project to redirect.
                $this->redirect('/');
            }
        }

        $this->Auth->allow('titlesAndIds', 'memberships', 'index', 'distinctUsers');
    }

    /**
     * Display all collections. Main collection page, initial collection list.
     */
    public function index() {

        $path = func_get_args();

        $projectResourceKids = $this->getProjectResources($path[0]);

        $this->Collection->recursive = -1;

        $user_id =  $this->Session->read('Auth.User.id');

        if( $user_id !== null ) { //signed in
            $collections = $this->Collection->find('all', array(
                'order' => 'Collection.modified DESC',
                'conditions' => array('OR' => array(
                    array( 'Collection.public' => '1'),
                    array( 'Collection.public' => '2'),
                    array( 'Collection.public' => '3'),
                    array( 'Collection.user_id' => $user_id)
                ), 'resource_kid' => $projectResourceKids),
                'group' => 'collection_id'
            ));

            //remove all the public 3 collections that the user isn't a part of
            $count = 0;
            foreach( $collections as $collection ){
                $bool_delete = 1;
                if( array_values($collection)[0]['public'] == '3'){
                    $members =  explode(';', array_values($collection)[0]['members'] );
                    foreach( $members as $member ){
                        if( $member == $user_id){
                            $bool_delete = 0;
                        }
                    }
                    if( $bool_delete == 1 ){
                        array_splice($collections, $count, 1);
                    }
                }
                $count++;
            }

        }else { //not signed in
            $collections = $this->Collection->find('all', array(
                'order' => 'Collection.modified DESC',
                'conditions' => array(
                    'Collection.public' => '1',
                    'resource_kid' => $projectResourceKids
                ),  //only get public collections
                'group' => 'collection_id'
            ));
        }
        //grab all user_names out of the collections.
        $authorList = array();
        foreach( $collections as $collection ){
            $authorList[] = $collection['Collection']['user_name'];
        }
        $authorList = array_unique($authorList);  //only keep unique

        //generate the html
        $authorString = "";
        forEach( $authorList as $author ) {
            $authorString .= '<li><a class="author-filter" href="#">'.$author.'</a></li>';
        }
        if( $authorString == '' ){  //html if none are found.
            $authorString = '<li><a class="author-filter" href="#">No Authors Available</a></li>';
        }

        //set variables for the view.
        $this->set('authors', $authorString);
        $this->set('collections', $collections);
    }

    /**
     *  get all resource kids in a project based on the project name.
     */
    protected function getProjectResources($pName){

        $pid = $GLOBALS['PID_ARRAY'][strtolower($pName)];
        $sid = $GLOBALS['RESOURCE_SID_ARRAY'][strtolower($pName)];
        $fields = array('Title');
        $kora = new General_Search($pid, $sid, 'kid', '!=', '0', $fields);
        $allResources = json_decode($kora->return_json(), true);
        return array_keys($allResources);
    }

    /**
     * Get all collections a resource is a part of
     */
    public function memberships() {

        //handle collections info on the single resource page
        if (isset($this->request->query['id'])){
            $resource_id = $this->request->query['id'];
            $retval['id'] = $resource_id;

            //$collections = array();
            //// Start SQL Area
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
            //where is fancy to get min created of each collection
            //group by collection_id to only get one of each
            //order by created
            $sql = "SELECT collection_id, title, user_name, min(created) AS DATE
                    FROM  collections
                    WHERE resource_kid ='".$resource_id."'
                    GROUP BY collection_id
                    ORDER BY created";

            $result = $mysqli->query($sql);
            $collections = array();
            while($row = mysqli_fetch_assoc($result))
              $collections[] = $row;

            $retval['collections'] = $collections;
            return $this->json(200, $retval);
        }
        //I don't think this code is used...
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
        $user_id =  $this->Session->read('Auth.User.id');

        if (isset($this->request->query['pKid'])) {

            $pid = hexdec( explode('-', $this->request->query['pKid'])[0] );
            $pName = array_search($pid, $GLOBALS['PID_ARRAY']);

            $projectResourceKids = $this->getProjectResources($pName);

            if ($user_id !== null) { //signed in
                $collections = $this->Collection->find('all', array(
                    'order' => 'Collection.modified DESC',
                    'conditions' => array('OR' => array(
                        array('Collection.public' => '1'),
                        array('Collection.public' => '2'),
                        array('Collection.public' => '3'),
                        array('Collection.user_id' => $user_id)
                    ), 'resource_kid' => $projectResourceKids),
                    'group' => 'collection_id'
                ));

                //remove all the public 3 collections that the user isn't a part of
                $count = 0;
                foreach ($collections as $collection) {
                    $bool_delete = 1;
                    if (array_values($collection)[0]['public'] == '3') {
                        $members = explode(';', array_values($collection)[0]['members']);
                        foreach ($members as $member) {
                            if ($member == $user_id) {
                                $bool_delete = 0;
                            }
                        }
                        if ($bool_delete == 1) {
                            array_splice($collections, $count, 1);
                        }
                    }
                    $count++;
                }

            } else { //not signed in
                $collections = $this->Collection->find('all', array(
                    'order' => 'Collection.modified DESC',
                    'conditions' => array(
                        'Collection.public' => '1',
                        'resource_kid' => $projectResourceKids
                    ),  //only get public collections
                    'group' => 'collection_id'
                ));
            }
            $retval = [];
            foreach ($collections as $collection) {
                $temp = [];
                $temp['title'] = $collection{'Collection'}['title'];
                $temp['collection_id'] = $collection{'Collection'}{'collection_id'};
                $temp['user'] = $collection{'Collection'}['user_name'];
                $retval[] = $temp;
            }
            return $this->json(200, $retval);
        }else return '';
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

    public function editCollection()
    {
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
        //get the collection id from the id
        $sql = "SELECT collections.collection_id
                    FROM arcs_dev.collections
                    WHERE collections.id ='".$_POST['id']."';";
        $result = $mysqli->query($sql);
        $row = mysqli_fetch_assoc($result);
        //$collection_id2[] = $row;
        //$results['colid1'] = $row;
        //$results['colid2'] = $row[0];
        $collection_id = $row{collection_id};
        //$collection_id = $collection_id->collection_id;
        //$results['colid2'] = $collection_id;


        //Update the collections permissions by collection_id
        $sql = "UPDATE collections
                    SET collections.public = '".$_POST['permission']."',
                        collections.members = '".$_POST['viewUsers']."'
                    WHERE collections.collection_id ='".$collection_id."';";
        $result = $mysqli->query($sql);
        //while($row = mysqli_fetch_assoc($result))
            //$collections[] = $row;
        $results['id'] = $_POST['id'];
        $results['permission'] = $_POST['permission'];
        $results['sql'] = $sql;
        $results['result'] = $result;
        $this->json(200, $results);
    }

    public function viewMembers()
    {
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
        //get the collection id from the id
        $sql = "SELECT collections.collection_id
                    FROM arcs_dev.collections
                    WHERE collections.id ='".$_POST['id']."';";
        $result = $mysqli->query($sql);
        $row = mysqli_fetch_assoc($result);
        //$collection_id2[] = $row;
        //$results['colid1'] = $row;
        //$results['colid2'] = $row[0];
        $collection_id = $row{collection_id};
        //$collection_id = $collection_id->collection_id;
        //$results['colid2'] = $collection_id;


        //Update the collections permissions by collection_id
        $sql = "UPDATE collections
                    SET collections.public = '".$_POST['permission']."',
                        collections.members = '".$_POST['viewUsers']."'
                    WHERE collections.collection_id ='".$collection_id."';";
        $result = $mysqli->query($sql);
        //while($row = mysqli_fetch_assoc($result))
        //$collections[] = $row;
        $results['id'] = $_POST['id'];
        $results['permission'] = $_POST['permission'];
        $results['sql'] = $sql;
        $results['result'] = $result;
        $this->json(200, $results);
    }

    /**
     * Edit collection uses this to delete individual resources
     */
    public function deleteResource()
    {
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
        //Delete the resource with the id
        $sql = "DELETE FROM collections
                    WHERE collections.id ='".$_POST['id']."';";
        $result = $mysqli->query($sql);
        //while($row = mysqli_fetch_assoc($result))
        //$collections[] = $row;
        $results['id'] = $_POST['id'];
        $results['sql'] = $sql;
        $results['result'] = $result;
        $this->json(200, $results);
    }
}
