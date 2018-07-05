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

        $this->Auth->allow('titlesAndIds', 'memberships', 'index', 'distinctUsers', 'findAllByUser','testK3Projects');
    }


    /**
     * Display all collections. Main collection page, initial collection list.
     */
    public function index() {
        $pName = explode('/', $this->request->query['url']);

        if( isset($pName[1]) ){
            $isRealProject = parent::isRealProject($pName[1]);
            if(!$isRealProject){    //not a real project, so redirect.
                $this->redirect('/');
            }
        }

        $path = func_get_args();
        //$projectResourceKids = $this->getProjectResources($path[0]);
        $pid = parent::getPIDFromProjectName($path[0]);


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
                ),  'Collection.resource_kid LIKE' => "$pid-%"),
                'group' => 'collection_id'
            ));


            //remove all the public 3 collections that the user isn't a part of
            $count = 0;
            foreach( $collections as $key => $collection ){
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
                    'Collection.resource_kid LIKE' => "$pid-%"
                ),  //only get public collections
                'group' => 'collection_id'
            ));

        }

        foreach( $collections as $key => $collection ){

            $collections[$key]['Collection']['timeAgo'] = parent::time_elapsed_string($collection['Collection']['created']);
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
    // protected function getProjectResources($pName){
    //     $pid = parent::getPIDFromProjectName(strtolower($pName));
    //     $sid = parent::getResourceSIDFromProjectName(strtolower($pName));
    //     $fields = 'KID';
    //     $kora = new General_Search($pid, $sid, 'kid', '!=', '', $fields);
    //     $allResources = json_decode($kora->return_json(), true);
    //     return $allResources;
    // }

    public function testK3Projects($pName = 'isthmia'){
        $pid = parent::getPIDFromProjectName(strtolower($pName));
        $sid = parent::getPageSIDFromProjectName(strtolower($pName));
        //echo $sid;die;
        $fields = 'ALL';


        $q = "";

        $kora = new General_Search($pid, $sid, 'Title', '=', 'IPR_69-24', $fields);
        //$kora = new General_Search($pid, $sid, 'kid', '=', '34-171-208512', $fields);
        $results = json_decode($kora->return_json(), true);

        // $kora = new Advanced_Search($pid, $sid, $fields);
        // $kora->add_clause("kid", "!=", "");
        // $results = json_decode($kora->search(), true);

        echo json_encode($results);
        die;


//        $kora = new General_Search($pid, $sid, 'kid', '!=', '', $fields);
//        $kora = new General_Search($pid, $sid, 'Latest_Date', '!=', '', $fields);


//       $kora = new General_Search($pid, $sid, 'Latest_Date', 'LIKE', '%<month>9</month><day>16</day><year>2003</year>%', $fields);
//       $kora = new General_Search($pid, $sid, 'Latest_Date', 'LIKE', '<month>9</month><day>16</day><year>2003</year>', $fields);


//       $kora = new General_Search($pid, $sid, 'Latest_Date', 'LIKE', '%<month>09</month><day>16</day><year>2003</year>%', $fields);
//       $kora = new General_Search($pid, $sid, 'Latest_Date', 'LIKE', '<month>09</month><day>16</day><year>2003</year>', $fields);
//       $kora = new General_Search($pid, $sid, 'Latest_Date', 'LIKE', '%<month>9</month><day>16</day><year>2003</year>%', $fields);
//       $kora = new General_Search($pid, $sid, 'Latest_Date', 'LIKE', '<month>9</month><day>16</day><year>2003</year>', $fields);




//        $kora = new General_Search($pid, $sid, 'Title', 'LIKE', '1970', $fields);
//        $kora = new General_Search($pid, $sid, 'Sponsor', 'LIKE', 'Ohio', $fields);
//        $kora = new General_Search($pid, $sid, 'Registrar', 'LIKE', 'Tzortzoupolou', $fields);
//        $kora = new General_Search($pid, $sid, 'Director', 'LIKE', 'Gregory', $fields);
//        $kora = new General_Search($pid, $sid, 'Type', 'LIKE', 'Excavation', $fields);

//        $kora = new General_Search($pid, $sid, 'Project_Associator', 'LIKE', '34', $fields);
//        $kora = new General_Search($pid, $sid, 'Project_Associator', 'LIKE', '34-168-198016', $fields);
//        $kora = new General_Search($pid, $sid, 'Project Associator', 'LIKE', '34', $fields);
//        $kora = new General_Search($pid, $sid, 'Project Associator', 'LIKE', '34-168-198016', $fields);
//
//                $clause1 = new General_Search($pid, $sid, 'Latest_Date', 'LIKE', '9', $fields);
//                $clause2 = new General_Search($pid, $sid, 'Latest_Date', 'LIKE', '16', $fields);
//                $clause3 = new General_Search($pid, $sid, 'Latest_Date', 'LIKE', '2003', $fields);
//                $kora = new General_Search($clause1, 'AND', $clause2, 'AND', $clause3);

//        $kora = new General_Search($pid, $sid, 'Latest_Date', 'LIKE', '%2004%', $fields);
//        $kora = new General_Search($pid, $sid, 'Latest_Date', 'LIKE', '9142004', $fields);
//        $kora = new General_Search($pid, $sid, 'Latest_Date', 'LIKE', '%9142004%', $fields);
//        $kora = new General_Search($pid, $sid, 'Latest_Date', 'LIKE', '09142004', $fields);
//        $kora = new General_Search($pid, $sid, 'Latest_Date', 'LIKE', '%09142004%', $fields);

//        $kora = new General_Search($pid, $sid, 'Latest Date', 'LIKE', 'CE', $fields);
//        $kora = new General_Search($pid, $sid, 'Latest Date', 'LIKE', '2004', $fields);
//        $kora = new General_Search($pid, $sid, 'Latest Date', 'LIKE', '%2004%', $fields);
//        $kora = new General_Search($pid, $sid, 'Latest Date', 'LIKE', '9142004', $fields);
//        $kora = new General_Search($pid, $sid, 'Latest Date', 'LIKE', '%9142004%', $fields);
//        $kora = new General_Search($pid, $sid, 'Latest Date', 'LIKE', '09142004', $fields);
//        $kora = new General_Search($pid, $sid, 'Latest Date', 'LIKE', '%09142004%', $fields);

//        $kora = new General_Search($pid, $sid, 'Latest_Date', 'LIKE', '2004/09/14', $fields);
//        $kora = new General_Search($pid, $sid, 'Latest_Date', 'LIKE', '%2004/09/14%', $fields);
//        $kora = new General_Search($pid, $sid, 'Latest Date', 'LIKE', '2004/09/14', $fields);
//        $kora = new General_Search($pid, $sid, 'Latest Date', 'LIKE', '%2004/09/14%', $fields);
//        $kora = new General_Search($pid, $sid, 'Latest_Date', 'LIKE', '20040914', $fields);
//        $kora = new General_Search($pid, $sid, 'Latest_Date', 'LIKE', '%20040914%', $fields);
//        $kora = new General_Search($pid, $sid, 'Latest Date', 'LIKE', '20040914', $fields);
//        $kora = new General_Search($pid, $sid, 'Latest Date', 'LIKE', '%20040914%', $fields);





        $allResources = json_decode($kora->return_json(), true);


        echo json_encode($allResources);
        die;
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
            $sql = $mysqli->prepare("SELECT collection_id, title, user_name, min(created) AS DATE
                    FROM  collections
                    WHERE resource_kid = ?
                    GROUP BY collection_id
                    ORDER BY created");

            $sql->bind_param("s", $resource_id);
            $sql->execute();
            $result = $sql->get_result();
            // $result = $mysqli->query($sql);
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
        $this->request->data['collection_id'] = CakeText::uuid();
        $this->Collection->permit('collection_id');
        $this->Collection->permit('resource_kid');
        $this->request->data['user_id'] = $this->Auth->user('id');
        $this->Collection->permit('username');
        $this->request->data['username'] = $this->Auth->user('username');
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
        $this->Collection->permit('username');
        $this->Collection->permit('members');

        $collection = $this->Collection->findByCollection_id($this->request->data['collection']);

        //find all resource kids already in the collection
        $collectionResources = $this->Collection->find('all', array(
            'order' => 'Collection.modified DESC',
            'conditions' => array('collection_id' => $collection['Collection']['collection_id']),
            'fields' => array('resource_kid')
        ));
        $existingResourceKids = array();
        foreach( $collectionResources as $exc ){
            array_push($existingResourceKids, $exc['Collection']['resource_kid']);
        }
        //no resources to add
        if( !isset($this->request->data['resource_kids']) ){
            if (isset($collection)) {
                $collection = $collection['Collection'];
                $object = array(
                    'collection_id' => $collection['collection_id'],
                    'user_id' => $this->Auth->user('id'),
                    'user_name' => $this->Auth->user('name'),
                    'username' => $this->Auth->user('username'),
                    'title' => $collection['title'],
                    'public' => $collection['public']
                );
                $object['duplicates'] = false; //send if there were any duplicate kids to the view
                $object['new_resources'] = 0;
                $this->json(201, $object);
                return;
            }
            $this->json(400);
            return;
        }
        //filter out any duplicate resource kids
        $duplicates = false;
        $newResources = array_diff( $this->request->data['resource_kids'], $existingResourceKids );
        if( sizeof($newResources) < sizeof($this->request->data['resource_kids']) ){
            $duplicates = true;
        }

        if (isset($collection)) {

            $collection = $collection['Collection'];
            $object = array(
                'collection_id' => $collection['collection_id'],
                'user_id' => $this->Auth->user('id'),
                'user_name' => $this->Auth->user('name'),
                'username' => $this->Auth->user('username'),
                'title' => $collection['title'],
                'public' => $collection['public'],
                'members' => $collection['members']
            );

            $dataArray = array();
            foreach( $newResources as $resource_kid ) {
                $object['resource_kid'] = $resource_kid;
                array_push($dataArray, $object);
            }
            $this->Collection->saveMany($dataArray); //save the actual data

            $object['duplicates'] = $duplicates; //send if there were any duplicate kids to the view
            $object['new_resources'] = sizeof($newResources); //send if there were any duplicate kids to the view
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

        if (isset($this->request->query['pName'])) {
            $pid = parent::getPIDFromProjectName($this->request->query['pName']);


            //$projectResourceKids = $this->getProjectResources($this->request->query['pName']);

            if ($user_id !== null) { //signed in
                $collections = $this->Collection->find('all', array(
                    'order' => 'Collection.modified DESC',
                    'conditions' => array('OR' => array(
                        array('Collection.public' => '1'),
                        array('Collection.public' => '2'),
                        array('Collection.public' => '3'),
                        array('Collection.user_id' => $user_id)
                    ), 'Collection.resource_kid LIKE' => "$pid-%"),
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
                        'Collection.resource_kid LIKE' => "$pid-%"
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
     * Find all collections associated with user id - used by activity tab on user profile page
     */
    public function findAllByUser()
    {
        include_once("../Config/database.php");
        $db = new DATABASE_CONFIG;
        $db_object = (object)$db;
        $db_array = $db_object->{'default'};
        $response['db_info'] = $db_array['host'];
        $mysqli = new mysqli($db_array['host'], $db_array['login'], $db_array['password'], $db_array['database']);

        if ($mysqli->connect_error) {
            die('Connect Error (' . $mysqli->connect_errno . ') '
                . $mysqli->connect_error);
        }

        //Get a collection_id from the id
        //Get the title
        //Get the oldest created date.
        $sql = $mysqli->prepare("SELECT DISTINCT collection_id, id, title, min(created) AS DATE, public, members, user_id
                        FROM collections
                        GROUP BY collection_id
                        ORDER BY min(created) DESC;");
//        $sql->bind_param("s", $this->request->data['id']);
        $sql->execute();
        $result = $sql->get_result();

        while ($row = mysqli_fetch_assoc($result)) {
//            echo json_encode($row['user_id']);
//            echo 'IM HERE';
//            echo json_encode($this->Session->read('Auth.User.id'));
//            die;

            if($row['user_id'] == $this->Session->read('Auth.User.id')) {
                //Set the collection's last modified date
                $date = $row['DATE'];
                $year = substr($date, 0, 4);
                $months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                    'September', 'October', 'November', 'December');
                $month = substr($date, 5, 2);
                $day = substr($date, 8, 2);
                $return_date = array_values($months)[intval($month) - 1] . ' ' . $day . ', ' . $year;

                $temp_array = array('id' => $row['collection_id'],
                    'title' => $row['title'],
                    'date' => $return_date,
                    'public' => $row['public'],
                    'members' => $row['members']);
                $test[] = $temp_array;
            }
        }

        $count = count($test);
//        $sql = $mysqli->prepare("SELECT COUNT(DISTINCT collection_id)
//                                FROM  collections
//                                WHERE user_id = ?;");
//        $sql->bind_param("s", $this->request->data['id']);
//        $sql->execute();
//        $result = $sql->get_result();
//
//        $count = 0;
//        while ($row = mysqli_fetch_assoc($result)) {
//            $count = json_encode($row['COUNT(DISTINCT collection_id)']);
//            break;
//        }

        if( isset($test) ) {
            $return = array( 'count'=>$count, 'data'=>json_encode($test) );
            echo json_encode($return);
        }else{
            echo json_encode( array( 'count'=>$count) );
        }
        die;
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

        $sql = $mysqli->prepare("SELECT DISTINCT collection_id, id, title, min(created) AS DATE, public, members, username
                        FROM collections
                        WHERE collection_id = ?
                        GROUP BY collection_id
                        ORDER BY min(created) DESC;");
        $sql->bind_param("s", $_POST['id']);
        $sql->execute();
        $result = $sql->get_result();


        while ($row = mysqli_fetch_assoc($result)) {
            if ($row['username'] != $this->Session->read('Auth.User.username')) {
                die;
            }
        }

        //Update the collections permissions by collection_id
        $sql = $mysqli->prepare("UPDATE collections
                    SET collections.public = ?,
                        collections.members = ?
                    WHERE collections.collection_id = ?");
        $sql->bind_param("sss", $_POST['permission'], $_POST['viewUsers'], $_POST['id']);
        $sql->execute();
        $result = $sql->get_result();
        // $result = $mysqli->query($sql);
        //while($row = mysqli_fetch_assoc($result))
        //$collections[] = $row;
        $results['id'] = $_POST['id'];
        $results['permission'] = $_POST['permission'];
        //$results['sql'] = $sql;
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
        $sql = $mysqli->prepare("SELECT collections.collection_id
                    FROM arcs_dev.collections
                    WHERE collections.id = ?");
        $sql->bind_param("s", $_POST['id']);
        $sql->execute();
        $result = $sql->get_result();
        // $result = $mysqli->query($sql);
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
        $sql = $mysqli->prepare("DELETE FROM collections
                    WHERE collections.id = ?");
        $sql->bind_param("s", $_POST['id']);
        $sql->execute();
        $result = $sql->get_result();
        // $result = $mysqli->query($sql);
        //while($row = mysqli_fetch_assoc($result))
        //$collections[] = $row;
        $results['id'] = $_POST['id'];
        $results['sql'] = $sql;
        $results['result'] = $result;
        $this->json(200, $results);
    }
}
