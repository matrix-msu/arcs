<?php
/**
 * Search controller
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */

require_once(KORA_LIB . "Keyword_Search.php");
require_once(KORA_LIB . "General_Search.php");
require_once(KORA_LIB . "Advanced_Search.php");
require_once(KORA_LIB . "Resource.php");
require_once(KORA_LIB . "Utility_Search.php");

use Lib\Kora\Keyword_Search;
use Lib\Resource;
use lib\kora\local\Utility_Search;

App::import('Controller', 'Users');
App::import('Controller', 'Resources');


class SearchController extends AppController {
    public $name = 'Search';
    public $uses = array('Resource','Users');

    public function initialize(){
        parent::initialize();
        $this->loadComponent('Paginator');
    }
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('search', 'resources', 'advanced_resources', 'simple_search','advance_search','getProjects', "keywordSearch");
        if (!isset($this->request->query['related'])) {
            $this->Resource->recursive = -1;
            $this->Resource->flatten = true;
        }
    }
    public function keywordSearch($projectName = null) {
      parent::verifyGlobals($projectName);
      if (isset($this->request->query["keyword"]) &&
          !empty($this->request->query["keyword"])) {

        $rKids= $this->getResourcesFromKeyword(
          $projectName, $this->request->query["keyword"]
        );

        $search = new Resource_Search($rKids, $projectName);
        $results = $search->getResultsAsArray();
        echo "<script>var results_to_display = ".json_encode($results).";</script>";
        $this->render("../Search/search");
      }
      else {
        throw new Exception("keyword parameter was not set");
      }

    }
    public function getResourcesFromKeyword($project,$query){

        $this->loadModel('Keyword');

        $pages = $this->Keyword->find('all', array(
         'conditions' => array('Keyword.keyword LIKE' => "%$query%"),
         'fields' => array('Keyword.page_kid'),
         'recursive' => 1
        ));
        $pageArray = array();

        for ($i=0; $i < count($pages); $i++) {
          $pageArray[$i] = $pages[$i]["Keyword"]["page_kid"];
        }
        if (empty($pageArray)) {
          $pageArray = array("empty");
        }

        $util = new Utility_Search();
        $resources = $util->getResourcesFromPages($pageArray, $project);

        return $resources;
    }
    /**
     * Display the search page
     */
    public function search($project=null, $query=null) {

        if($project === null) { // If no project, throw exception to give error page without showing users the php errors
            parent::verifyGlobals('explode');
        }

        if($project != "all")
            parent::verifyGlobals($project);

        $title = 'Search';

        if ($query) $title .= ' - ' . urldecode($query);
            $this->set('title_for_layout', $title);

	    if(!empty($query)){
		   echo "<script type='text/javascript'>var globalquery = '".$query."';</script>";
	    }
	    echo "<script type='text/javascript'>var globalproject = '".$project."';</script>";
    }

    public function simple_search($project, $query="", $page, $perPage) {

        $this->autoRender = false;
        $username = NULL;

        $usersC = new UsersController();

        if ($user = $usersC->getUser($this->Auth)) {
            $username = $user['User']['username'];
        }

        if ($project === "all") {

          $projects = array_keys(parent::getPIDArray());
          $results = array();

          foreach ($projects as $project) {
            // Kora Search
            $preFilter = $this->getResourcesFromKeyword($project, $query);
            $keySearch = new Keyword_Search($preFilter);
            $keySearch->execute($query,$project);

            $result = $keySearch->getResultsAsArray();

            ResourcesController::filterByPermission($username, $result['results']);

            $results[$project] = $result;
          }
          echo json_encode($results);

        } else {
          $preFilter = $this->getResourcesFromKeyword($project, $query);
          // Kora Search
          $keySearch = new Keyword_Search($preFilter);
          $keySearch->execute($query,$project);
          $results = $keySearch->getResultsAsArray();

          ResourcesController::filterByPermission($username, $results['results']);

          echo json_encode($results);
        }

    }


    /**
     *
     * Display the advanced search page
     * @param string $query
     *
     */
    public function advance_search($query='') {
        $title = 'Advanced Search';
        if ($query) $title .= ' - ' . urldecode($query);
        $this->set('title_for_layout', $title);
        $this -> render('/AdvancedSearch/advancedsearch');
    }

    /**
     * Complete a category given a query.
     */
    public function complete() {
        $searcher = $this->getSearcher();
        if ($this->Auth->loggedIn())
            $searcher->publicFilter = false;

        $category = $this->request->query['cat'];
        $query = $searcher->parseQuery($this->request->query['q']);
        $options = array('limit' => 100);
        $results = $searcher->complete($category, $query, $options);

        $this->json(200, $results);
    }

    /**
     * Parse the search options from the request parameters.
     *
     * @return array
     */
    protected function parseParams() {
        $params = $this->request->query;
        $options = array(
            'limit' => isset($params['n']) ? $params['n'] : 30,
            'page' => 1,
            'direction' => 'DESC',
            'order' => 'modified'
        );
        if (isset($params['order'])) {
            $orderables = array('modified', 'created', 'title');
            if (in_array($params['order'], $orderables))
                $options['order'] = $params['order'];
        }
        if (isset($params['page'])) $options['page'] = $params['page'];
        $options['offset'] = ($options['page'] - 1) * $options['limit'];
        if (isset($params['direction']) && $params['direction'] == 'asc') {
            $options['direction'] = 'ASC';
        }
        return $options;
    }

    /**
     * Search resources.
     */
    public function resources() {
        $options = $this->parseParams();

        if (!isset($this->request->query['q']))
            return $this->emptySearch($options);

        if (isset($this->request->query['n'])) {
            $limit = $this->request->query['n'];
            //$response['limit'] = $limit;
        }else{
            $limit = -1;
        }

        if (isset($this->request->query['pKid'])) {
            $pName = $this->request->query['pKid'];
        }

        //Collections search
        if ( substr($this->request->query['q'],0,13) == 'collection_id' ){
            $collection_id = substr($this->request->query['q'],15,-1);
            //// Start SQL Area
            $db = new DATABASE_CONFIG;
            $db_object =  (object) $db;
            $db_array = $db_object->{'default'};
            $mysqli = new mysqli($db_array['host'], $db_array['login'], $db_array['password'], $db_array['database']);

            if ($mysqli->connect_error) {
                die('Connect Error (' . $mysqli->connect_errno . ') '
                    . $mysqli->connect_error);
            }

            //Get the kid's from the collection_id
            if ($limit > 0) {
                // $sql = "SELECT resource_kid, id FROM collections WHERE collections.collection_id ='" . $collection_id . "' LIMIT " . ($limit+1);
                $sql = $mysqli->prepare("SELECT resource_kid, id FROM collections WHERE collections.collection_id = ? LIMIT ?");
                $temp = $limit+1;
                $sql->bind_param("ss", $collection_id, $temp);
            }else {
                $sql = $mysqli->prepare("SELECT resource_kid, id FROM collections WHERE collections.collection_id = ?");
                $sql->bind_param("s", $collection_id);
            }
            $sql->execute();
            $result = $sql->get_result();
            // $result = $mysqli->query($sql);
            $count = 0;
            $test = [];
            while($row = mysqli_fetch_assoc($result)) {
                $test[] = $row;
                $count++;
            }

            if( $limit == -1 ){  //show all was pressed. return resource_kids immediately.
                $return = array('results'=>array());
                foreach($test as $row){
                    $return['results'][] = $row['resource_kid'];
                }
                return $this->json(200, $return );
            }

            //Test if there are more results--
            $more_results = 0;
            if ( $count > $limit && $limit > -1 ){
                $more_results = 1;
                array_pop($test);
            }

            $response['results'] = array();

            $first = 1;
            foreach( $test as $row){
                $temp_array = array();
                if( $first == 1 ) {
                    $temp_array['more_results'] = $more_results;
                    $first = 0;
                }
                $temp_kid = $row['resource_kid'];

                $pName = parent::convertKIDtoProjectName($temp_kid);
                $pid = parent::getPIDFromProjectName($pName);
                $sid = parent::getResourceSIDFromProjectName($pName);
                $pageSid = parent::getPageSIDFromProjectName($pName);

                //Get the Resources from Kora
                $query = "kid,=,".$temp_kid;

                $fields = array('Title','Type','Resource_Identifier','Permissions','Special_User');
                $query_array = explode(",", $query);
                $kora = new General_Search($pid, $sid, $query_array[0], $query_array[1], $query_array[2], $fields);
                $resource = json_decode($kora->return_json(), true);
                $resource[$temp_kid]['thumb'] = ''; //set the thumb so that permissions will work

                //permissions stuffs.
                $username = NULL;
                $usersC = new UsersController();
                if ($user = $usersC->getUser($this->Auth)) {
                    $username = $user['User']['username'];
                }
                ResourcesController::filterByPermission($username, $resource);


                $r = $resource[$temp_kid];

                //handle permissions sent to frontent
                if( isset($r['Locked']) ){
                    $temp_array['Locked'] = $r['Locked'];
                }

                //Handle resource title
                if( isset($r['Title']) ){
                    $temp_array['title'] = $r['Title'];
                }else{
                    $temp_array['title'] = 'Unknown Title';
                }

                $temp_array['orphan'] = 'false';

                //Handle resource type
                if ( isset($r['Type']) ){
                    $resource_type = $r['Type'];
                    $temp_array['Type'] = $resource_type;
                }else{
                    continue;
                }
                $temp_array['kid'] = $temp_kid;

                $temp_array['collection_id'] = $row['id'];

                //grab all pages with the resource associator
                $fields = array('Image_Upload', 'Resource_Associator', 'Scan_Number');
                $kora = new Advanced_Search($pid, $pageSid, $fields);

                if( $resource_type == 'Field journal' ) {
                    $temp_array['resource-type'] = $resource_type;
                    $kora->add_double_clause("Resource_Associator", "=", $temp_kid,
                        "Scan_Number", "=", "1");
                }else {
                    $kora->add_clause("Resource_Associator", "=", $temp_kid);
                }

                $page2 = json_decode($kora->search(), true);

                //Get the picture URL from the page results
                $picture_url = '';
                if (isset(array_values($page2)[0])) {
                    $picture_url = array_values($page2)[0]['Image_Upload']['localName'];
                }

                //Decide if there is a picture..
                if( !empty($picture_url) ){
                    $temp_array['thumb'] = $this->smallThumb($picture_url);
                }else{
                    $temp_array['thumb'] = Router::url('/', true)."img/DefaultResourceImage.svg";
                }
                array_push($response['results'], $temp_array );
            }
            //return collections
            $response['total'] = count($response['results']);
            return $this->json(200, $response);
        }//finished collections search

        //// Resource Type search - resources page - orphans
        if ( $this->request->query['q'] == 'Orphan,=,true' ){

            //search for the orphaned pages with a limit.
            $pid = parent::getPIDFromProjectName($pName);
            $sid = parent::getPageSIDFromProjectName($pName);

            $fields = array('Image_Upload');
            $query_array = explode(",", $this->request->query['q']);
            if( $limit != -1 ) {
                $kora = new Advanced_Search($pid, $sid, $fields, 0, $limit+1);
            }else{
                $kora = new Advanced_Search($pid, $sid, $fields, 0, 0);
            }
            $kora->add_clause($query_array[0], $query_array[1], $query_array[2]);
            $response['results'] = json_decode($kora->search(), true);

            if( $limit == -1 ){
                $return = array('results'=> array_keys($response['results']) );
                return $this->json(200, $return );
            }

            $returnResults = array();
            $count = 0;
            foreach ($response['results'] as $page){
                $count++;
                if ($count > $limit && $limit != -1) {
                    $returnResults[0]['more_results'] = 1;
                    break;
                }

                $temp['orphan'] = 'true';

                $temp['kid'] = $page['kid'];

                $temp['title'] = 'Unknown Title';
                if (array_key_exists('Image_Upload', $page) && array_key_exists('originalName', $page['Image_Upload']) ) {
                    $temp['title'] = $page['Image_Upload']['originalName'];
                }

                $temp['thumb'] = '';
                if (array_key_exists('Image_Upload', $page) && array_key_exists('localName', $page['Image_Upload']) ) {
                    $temp['thumb'] = $page['Image_Upload']['localName'];
                }

                //Decide if there is a picture..
                if ($temp['thumb'] != '') {
                    $temp['thumb'] = $this->smallThumb($temp['thumb']);
                } else {
                    $temp['thumb'] = Router::url('/', true) . "img/DefaultResourceImage.svg";
                }

                array_push($returnResults, $temp);
            }


        }else {     // Resource type search - resources page
            //Get the Resources
            $query = $this->request->query['q'];

            $pid = parent::getPIDFromProjectName($pName);
            $sid = parent::getResourceSIDFromProjectName($pName);
            //$sid = parent::getProjectSIDFromProjectName($pName);


            //search for the resources by type
            $fields = array('Title','Resource_Identifier', 'Permissions', 'Special_User', 'Type');
            //$fields = 'ALL';
            $query_array = explode(",", $query);
            //$query_array = array('kid', '!=', '');
            if( $limit != -1 ) {
                $kora = new Advanced_Search($pid, $sid, $fields, null, $limit+1);
            }else{
                $kora = new Advanced_Search($pid, $sid, array('Title'), null, 0);
            }
            $kora->add_clause($query_array[0], $query_array[1], $query_array[2] );
            $resources = json_decode($kora->search(), true);



            $username = NULL;
            $usersC = new UsersController();
            if ($user = $usersC->getUser($this->Auth)) {
                $username = $user['User']['username'];
            }

            ResourcesController::filterByPermission($username, $resources);

            if( empty( $resources ) ) { //return now, there are no resources.
                $return = array('results'=> 'No Results' );
                return $this->json(200, $return);
            }

            if( $limit == -1 ){
                $return = array('results'=> array_keys($resources) );
                return $this->json(200, $return );
            }

            //grab all pages with the resource associator
            $sid = parent::getPageSIDFromProjectName($pName);
            $fields = array('Image_Upload', 'Resource_Associator', 'Scan_Number');
            $kora = new Advanced_Search($pid, $sid, $fields);

            //get a accepted resource associator array for kora,
            //stay within the limit
            $count = 0;
            $resourceKidArray = array();
            foreach ($resources as $key => $item) {
                $count++;
                //if there are more resources, add more results
                if ($count > $limit && $limit != -1) {
                    break;
                }
                $resourceKidArray[] = $key;
            }

            //using the array and 'in' this way because it's much faster.
            if( $query_array[2] == 'Field journal' ) {
                $kora->add_double_clause("Resource_Associator", "IN", $resourceKidArray,
                    "Scan_Number", "=", "1");
            }else {
                $kora->add_clause("Resource_Associator", "IN", $resourceKidArray);
            }

            $pages = json_decode($kora->search(), true);

            //get the info from the resources and pages
            $returnResults = array();
            $count = 0;

            foreach ($resources as $key => $item) {
                //check for show all button stuffs
                $count++;
                if ($count > $limit && $limit != -1) {
                    $returnResults[0]['more_results'] = 1;
                    break;
                }

                $temp['kid'] = $key;


                if( isset($item['Locked']) ){
                    $temp['Locked'] = $item['Locked'];
                }



                $temp['title'] = 'Unknown Title';
                if (array_key_exists('Title', $item) && $item['Title'] != '' ) {
                    $temp['title'] = $item['Title'];
                }

                //Get the Images
                $temp['thumb'] = '';

                //find the page by resource linkers and use the kid as the key.
                if( !empty($item['linkers']) ){
                    $minKey = min(array_keys($item['linkers'])); //grab the newest kid.
                    if(array_key_exists($minKey, $pages)){
                        $temp['thumb'] = $pages[$minKey]['Image_Upload']['localName'];
                        unset($pages[$minKey]); //delete that page to optimize
                    }
                }

                //if the page wasn't found by key, then search through all pages manually.
                if ($temp['thumb'] == '') {
                    foreach ($pages as $key2 => $item2) {
                        if (in_array($temp["kid"],$pages[$key2]['Resource Associator'])) {
                            $temp['thumb'] = $pages[$key2]['Image_Upload']['localName'];
                            unset($pages[$key2]); //delete that page to optimize
                            break;
                        }
                    }
                }

                //Decide if there is a picture..
                if ($temp['thumb'] != '') {
                    $temp['thumb'] = $this->smallThumb($temp['thumb']);
                } else {
                    $temp['thumb'] = Router::url('/', true) . "img/DefaultResourceImage.svg";
                }
                array_push($returnResults, $temp);

                $temp = array();
            }

            $response['countpages'] = count($pages);

        }


        //Test if there are more results for the show all button
        if( $limit == -1 ){
            $returnResults[0]['more_results'] = 0;
        }
        $response['results'] = $returnResults;
        $response['total'] = count($response['results']);
        $this->json(200, $response);
    }


    /**
     * Search resources with advanced search.
     */
    public function advanced_resources($data = null) {
        $isAnnotations = false;
        if( !empty($data) ){
            $isAnnotations = true;
            @$this->request->data = $data;
        }
        //$options = $this->parseParams();
        $this->autoRender = false;
        $pName = parent::convertKIDtoProjectName($this->request->data['pid']);
        $pid = parent::getPIDFromProjectName($pName);

        if( $this->request->data['sid'] == 'resource' ){
            $sid = parent::getResourceSIDFromProjectName($pName);
        }elseif( $this->request->data['sid'] == 'subject' ){
            $sid = parent::getSubjectSIDFromProjectName($pName);
        }elseif( $this->request->data['sid'] == 'page' ){
            $sid = parent::getPageSIDFromProjectName($pName);
        }

        $kora = new Advanced_Search($pid,$sid);

        foreach ($this->request->data['q'] as $q) {
            $kora->add_clause($q[0], $q[1], $q[2]);
        }

        $results = $kora->search();

        // Get the Resource Type
        if (!empty($results)) {
            $temp = json_decode($results);
            $associator = (array)array_values((array)$temp)[0];
            $associator = isset($associator['Resource_Associator'][0])
                          ? $associator['Resource_Associator'][0]
                          : false;
           if ($associator) {
               $pageSid = $sid;
               $sid = parent::getResourceSIDFromProjectName($pName);
               $kora = new General_Search($pid, $sid, "kid", "=", $associator, array("Type"));
               $tempRes = (array)json_decode($results, true);
               if( $this->request->data['sid'] == 'page' ) {
                   foreach ($tempRes as $key => $value) {
                       $localName = $tempRes[$key]['Image_Upload']['localName'];
                       //$localName = $tempRes[$key]->{'Image Upload'}->localName;
                       $tempRes[$key]['constructed_image'] = KORA_FILES_URI.$pid.'/'. $pageSid . '/'.$localName;
                   }
               }
               $tempRes2 = json_decode($kora->return_json());
               $tempRes["resource"] = $tempRes2;
               if( $isAnnotations ){
                   return $tempRes;
               }else {
                   echo json_encode($tempRes);
               }
               return;
           }
        }
        if( $isAnnotations ){
            return $results;
        }else {
            echo ($results);
        }
    }



    /**
     * Return an instance of a search class. SolrSearch if available, otherwise
     * SqlSearch. This depends on the `arcs.ini` configuration file.
     *
     * @return object
     */
    protected function getSearcher() {
        if (Configure::read('solr.uses')) {
            require_once(LIB . 'Arcs' . DS . 'Solr.php');
            return new \Arcs\SolrSearch(
                Configure::read('solr.host'),
                Configure::read('solr.port'),
                Configure::read('solr.webapp')
            );
        }
        require_once(LIB . 'Arcs' . DS . 'SqlSearch.php');
        $dbo = $this->Resource->getDataSource('default');
        $config = $dbo->config;
        return new \Arcs\SqlSearch($config);
    }
}
