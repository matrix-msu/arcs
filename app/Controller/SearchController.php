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

use Lib\Kora\Keyword_Search;
use Lib\Resource;

class SearchController extends AppController {
    public $name = 'Search';
    public $uses = array('Resource','Users');

	public function initialize(){
        parent::initialize();
        $this->loadComponent('Paginator');
    }
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('search', 'resources', 'advanced_resources', 'simple_search','advance_search','getProjects');
        if (!isset($this->request->query['related'])) {
            $this->Resource->recursive = -1;
            $this->Resource->flatten = true;
        }

    }

    /**
     * Display the search page
     */
    public function search($project, $query=null) {
      if($project != "all")
        parent::verifyGlobals($project);
      $title = 'Search';
      if ($query) $title .= ' - ' . urldecode($query);
        $this->set('title_for_layout', $title);
	    if(!empty($query)){
		   echo "<script>var globalquery = '".$query."';</script>";
	    }
	    echo "<script type='text/javascript'>var globalproject = '".$project."';</script>";
    }

    public function simple_search($project,$query="",$page,$perPage) {
        $this->autoRender = false;

        if ($query == ''){
            return $this->emptySearch($options);
        } else if ($project == "all") {
          $projects = array_keys($GLOBALS['PID_ARRAY']);
          $keySearch = new Keyword_Search();
          $results = array();

          foreach ($projects as $project) {
            $keySearch->execute($query,$project);
            $results[$project] = $keySearch->getResultsAsArray();
          }
          echo json_encode($results);

        } else {
          $keySearch = new Keyword_Search();
          $keySearch->execute($query,$project);
          $keySearch->print_json();
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

    // For now this function only does the resource and subject search by ketword
    // but can do more and the queing can be doen by an extra fucntion on in the same fuction using the continue
    // coommand, or an equivalen to continue as in c++
    // int his fucntion make an array of fields in the resoiurces and subject of observqtion
    // which will be returned. this will make a huge difference in the load time

    // This funtion takes in a scheme id(sid) and users input which will be made
    // to AN APPROPIATE QUERY. Then a kora restful call will be made to get the
    // we need to search for and thus will be the return.
    protected function search_single_scheme($sid, $query) {
        // Let us check and decide which sid we need to search, plus make the appropiate
        // query to be used pull data out of KORA.
        $user = "";
        $pass = "";
        $display = "json";

        if($sid == RESOURCE_SID){
            // making the query we want by specfic fields!!
            $q = '(Type,like,'. $query.'),||,(Resource Identifier,like,'. $query.'),||,(Earliest Date,like,'. $query.'),||,(Latest Date,like,'. $query.')';
            $url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".$sid."&token=".TOKEN."&display=".$display."&query=".urlencode($q);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
            //capture results and map to array
            $results = array();
            $results = json_decode(curl_exec($ch), true);
            return $results;
        }else if ($sid == PROJECT_SID) {
            // making the query we want by specfic fields!!
            $q = 'Country,like,'. $query ;
            $url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".$sid."&token=".TOKEN."&display=".$display."&query=".urlencode($q);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
            //capture results and map to array
            $results = array();
            $results = json_decode(curl_exec($ch), true);
            return $results;
        }else if ($sid == SEASON_SID) {
            // making the query we want by specfic fields!!
            $q = '(Title,like,'. $query.'),||,(Description,like,'. $query.'),||,(Earliest Date,like,'. $query.'),||,(Latest Date,like,'. $query.')';
            $url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".$sid."&token=".TOKEN."&display=".$display."&query=".urlencode($q);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
            //capture results and map to array
            $results = array();
            $results = json_decode(curl_exec($ch), true);
            return $results;
        }else if ($sid == SURVEY_SID) {
            // making the query we want by specfic fields!!
            $q = '(Name,like,'. $query.'),||,(Earliest Date,like,'. $query.'),||,(Latest Date,like,'. $query.')';
            $url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".$sid."&token=".TOKEN."&display=".$display."&query=".urlencode($q);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
            //capture results and map to array
            $results = array();
            $results = json_decode(curl_exec($ch), true);
            return $results;
        }else if ($sid == SUBJECT_SID) {
            // making the query we want by specfic fields!!
            $q = '(Artifact - Structure Classification,like,'. $query.'),||,';
            $q .= '(Artifact - Structure Type,like,'. $query.'),||,';
            $q .= '(Artifact - Structure Material,like,'. $query.'),||,';
            $q .= '(Artifact - Structure Technique,like,'. $query.'),||,';
            $q .= '(Artifact - Structure Period,like,'. $query.'),||,';
            $q .= '(Artifact - Structure Terminus Ante Quem,like,'. $query.'),||,';
            $q .= '(Artifact - Structure Terminus Post Quem,like,'. $query.')';
            // Make the Url
            $url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".$sid."&token=".TOKEN."&display=".$display."&query=".urlencode($q);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
            //capture results and map to array
            $results = array();
            $results = json_decode(curl_exec($ch), true);
            return $results;
        }else {
            return array();
        }

    }




    /**
     * @return mixed
     */
    public function getProjects(){
        $user = "";
        $pass = "";
        $display = "json";
        $sid = PROJECT_SID;
        $query2 = 'kid,!=,1';
        $url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".$sid."&token=".TOKEN."&display=".$display."&query=".urlencode($query2)."&fields=Persistent Name";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
        //capture results and map to array
        $results = json_decode(curl_exec($ch), true);
        return $results;
    }











    public function advanced_search($query1="",$page,$perPage) {
        if($query1 == ""){
            return 0;
        }
        $options = $this->parseParams();

        // This array will be used to get results from multiple schemes. i.e search mutiple schemes
        $schemes = array(RESOURCE_SID,PROJECT_SID,SEASON_SID,SURVEY_SID,SUBJECT_SID);

        if ($query1 == ''){
            return $this->emptySearch($options);
        }else {
            if (isset($this->request->query['n'])) {
                $limit = $this->request->query['n'];
                $response['limit'] = $limit;
            }


            if ($response['order'] == 'relevance') {
                $response['results'] = $this->Resource->findAllFromIds($response['results']);
            } else {
                $response['results'] = $this->Resource->find('all', array(
                    'conditions' => array('Resource.id' => $response['results']),
                    'order' => "Resource.{$options['order']} {$options['direction']}"
                ));
            }


            // The searcher will return debug information that should be hidden for
            // most account types.
            if (!$this->Access->isAdmin()) {
                unset($response['raw_query']);
                unset($response['mode']);
            }

            //Get the Images
            $user = "";
            $pass = "";
            $display = "json";
            $sid = PAGES_SID;
            // $query2 = '(Type,=,%'. $query1.'%),||,(Resource Identifier,=,%'. $query1.'%),||,(Earliest Date,=,%'. $query1.'%),||,(Latest Date,=,%'. $query1.'%)';
            // Use kid=1 to grub all the results from Kora so that we can compare them later with those of the data.
            // I do not think this is very efficient but will modify with time.
            $query2 = 'kid,!=,1';
            $url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".$sid."&token=".TOKEN."&display=".$display."&query=".urlencode($query2);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
            //capture results and map to array
            $response['results'] = json_decode(curl_exec($ch), true);
            $imageResults = array();
            foreach($response['results'] as $image) {
                //$imageResults[$image['Resource Identifier']] = KORA_FILES_URI.PID."/".PAGES_SID."/".$image['Image Upload']['localName'];
                $imageResults[$image['Resource Identifier']] = $this->smallThumb($image['Image Upload']['localName']);
            }

            // Lets get the data from KORA multiple schemes
            $kora_data = array();
            $total= array();
            foreach ($schemes as $scheme) {
                $kora_data =  $this->search_single_scheme($scheme, $query1);

                foreach($kora_data as $key => $result){
                    $total[$key] = $result;
                }
                /*
                foreach($kora_data as $data){
                    array_push($total,$data);
                }
                */
            }
            $response['results'] = $total;
            // $response['results'] = $this->search_single_scheme(RESOURCE_SID, $query1);

            $returnResults = array();
            foreach($response['results'] as $key => $item) {
                if ($imageResults[$item['Resource Identifier']] != null) {
                    $item['thumb'] = $imageResults[$item['Resource Identifier']];
                } else {
                    $item['thumb'] = DEFAULT_THUMB;
                }
                $returnResults[$key] = $item;
                //array_push($returnResults, $item);
            }

            $response['results'] = $returnResults;
            $response['total'] = count($response['results']);
            $numberOfPages = ceil($response['total']/$perPage);
            $skip = ($page-1)*$perPage;
            $response['display'] = array_slice($response['results'],$skip,$perPage);
            $response['pages'] = $numberOfPages;
            $response['pageNumber'] = $page;
            $response['numberPerPage'] = $perPage;  //pass this variable in eventually
            $response['skip'] = $skip;
//			$this->layout = false;
//				$this->Post->recursive = 0;
//				$this-paginate = array(
//				'limit' => 20;
//				);
            //$this->paginate($response['results']);
            $this->json(200, $response);

            //$this->json(200, $this->paginate($response['results']));


            //$this->paginate($response);
            //$paginate($this->json(200, $response));
        }


    }
    public function sm($query1) {

        $options = $this->parseParams();

        if ($query1 == ''){
            return $this->emptySearch($options);
        }else {
            if (isset($this->request->query['n'])) {
                $limit = $this->request->query['n'];
                $response['limit'] = $limit;
            }


            if ($response['order'] == 'relevance') {
                $response['results'] = $this->Resource->findAllFromIds($response['results']);
            } else {
                $response['results'] = $this->Resource->find('all', array(
                    'conditions' => array('Resource.id' => $response['results']),
                    'order' => "Resource.{$options['order']} {$options['direction']}"
                ));
            }


            // The searcher will return debug information that should be hidden for
            // most account types.
            if (!$this->Access->isAdmin()) {
                unset($response['raw_query']);
                unset($response['mode']);
            }

            //Get the Images
            $user = "";
            $pass = "";
            $display = "json";
            $sid = PAGES_SID;
            $query2 = '(Type,=,'. $query1.'),||,(Resource Identifier,=,'. $query1.'),||,(Earliest Date,=,'. $query1.'),||,(Latest Date,=,'. $query1.')';
            $query2 = 'kid,!=,1';
            $url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".$sid."&token=".TOKEN."&display=".$display."&query=".urlencode($query2);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
            //capture results and map to array
            $response['results'] = json_decode(curl_exec($ch), true);
            $imageResults = array();
            foreach($response['results'] as $image) {
                $imageResults[$image['Resource Identifier']] = KORA_FILES_URI.PID."/".PAGES_SID."/".$image['Image Upload']['localName'];
            }




            // Getting the data!!
            $user = "";
            $pass = "";
            $display = "json";
            $sid = RESOURCE_SID;
            $query2 = '(Type,=,'. $query1.'),||,(Resource Identifier,=,'. $query1.'),||,(Earliest Date,=,'. $query1.'),||,(Latest Date,=,'. $query1.')';
            $url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".$sid."&token=".TOKEN."&display=".$display."&query=".urlencode($query2);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
            //capture results and map to array
            $response['results'] = json_decode(curl_exec($ch), true);


            $returnResults = array();
            foreach($response['results'] as $item) {
                if ($imageResults[$item['Resource Identifier']] != null) {
                    $item['thumb'] = $imageResults[$item['Resource Identifier']];
                } else {
                    $item['thumb'] = DEFAULT_THUMB;
                }
                array_push($returnResults, $item);

            }

            $response['results'] = $returnResults;
            $response['total'] = count($response['results']);
            $this->json(200, $response);

        }


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
     * Return recently modified resources if no search query was givem.
     */
    public function emptySearch($options) {
        # No facets provided. Give them back some recent resources.
        $user = "";
        $pass = "";

        $display = "json";
        $query = "";
        $url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".RESOURCE_SID."&token=".TOKEN."&display=".urlencode($display);//."query=".urlencode($query);
        ///initialize post request to KORA API using curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);

        ///capture results and display
        $resources = curl_exec($ch);
        $this->json(200, array(
            'results' => $resources,
            'num_results' => count($resources),
            'limit' => $options['limit'],
            'mode' => 'no_search',
            'offset' => $options['offset'],
            'direction' => $options['direction'],
            'total' => $this->Resource->find('count', array(
                    'conditions' => $this->Auth->loggedIn() ?
                        null: array('Resource.public' => 1)
                )
            )
        ));
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
            $pKid = $this->request->query['pKid'];
        }

        //Josh- Collections searches for resources
        ///////////////////////////////////////////////////////
        $catchcollections = 1;
        if ( substr($this->request->query['q'],0,13) == 'collection_id' && $catchcollections == 1){
            $collection_id = substr($this->request->query['q'],15,-1);
            //$response['results'] = array('hello' => 'Collections catch',
            //'collection_id' => substr($this->request->query['q'],15,-1));
            //// Start SQL Area
            ///////////////////
            $db = new DATABASE_CONFIG;
            $db_object =  (object) $db;
            $db_array = $db_object->{'default'};
            $mysqli = new mysqli($db_array['host'], $db_array['login'], $db_array['password'], $db_array['database']);

            if ($mysqli->connect_error) {
                die('Connect Error (' . $mysqli->connect_errno . ') '
                    . $mysqli->connect_error);
            }
			/*
            //Get a collection_id from the id
            $sql = "SELECT collection_id FROM collections WHERE collections.id ='".$collection_table_id."' LIMIT 1";
            //WHERE title = '".$file_name."'";
            $result = $mysqli->query($sql);
            //while($row = mysqli_fetch_assoc($result))
            //  $test[] = $row;
            //$response['collection_table_id'] = $collection_table_id;
            //$response['sql'] = $sql;
            $collection_id = mysqli_fetch_assoc($result);
            $collection_id = $collection_id['collection_id'];
			*/

            //Get the kid's from the collection_id
            if ($limit > 0) {
                $sql = "SELECT resource_kid, id FROM collections WHERE collections.collection_id ='" . $collection_id . "' LIMIT " . ($limit+1);
            }else {
                $sql = "SELECT resource_kid, id FROM collections WHERE collections.collection_id ='" . $collection_id."'";
            }
            $result = $mysqli->query($sql);
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
            if ( $count > $limit && $limit != -1 ){
                $more_results = 1;
                array_pop($test);
            }

			$pKid = explode('/', $_SERVER['HTTP_REFERER']);
			$pKid = array_pop($pKid);
			$pid = $GLOBALS['PID_ARRAY'][strtolower($pKid)];
			$sid = $GLOBALS['RESOURCE_SID_ARRAY'][strtolower($pKid)];
			$pageSid = $GLOBALS['PAGES_SID_ARRAY'][strtolower($pKid)];

            $response['results'] = array();
            $first = 1;
            foreach( $test as $row){
                $temp_array = array();
                if( $first == 1 ) {
                    $temp_array['more_results'] = $more_results;
                    $first = 0;
                }
                $temp_kid = $row['resource_kid'];

                //Get the Resources from Kora
                $query = "kid,=,".$temp_kid;

                $fields = array('Title','Type','Resource Identifier');
                $query_array = explode(",", $query);
                $kora = new General_Search($pid, $sid, $query_array[0], $query_array[1], $query_array[2], $fields);
                $resource = json_decode($kora->return_json(), true);

                $r = $resource[$temp_kid];

                //Handle resource title
                $resource_title = $r['Title'];
                if( !empty($resource_title)){
                    $temp_array['title'] = $resource_title;
                }else{
                    $temp_array['title'] = 'Unknown Title';
                }

                $temp_array['orphan'] = 'false';

                //Handle resource type
                $resource_type = $r['Type'];
                if ( !empty($resource_type) ){
                    $temp_array['type'] = $resource_type;
                }else{
                    $temp_array['type'] = 'Unknown Type';
                }
                $temp_array['kid'] = $temp_kid;

                $temp_array['collection_id'] = $row['id'];

                $resource_identifier = $r['Resource Identifier'];

                //grab all pages with the resource identifier
                $fields = array('Image Upload', 'Resource Identifier', 'Scan Number');
                $kora = new Advanced_Search($pid, $pageSid, $fields);

                if( $resource_type == 'Field journal' ) {
                    $temp_array['resource-type'] = $resource_type;
                    $kora->add_double_clause("Resource Identifier", "=", $resource_identifier,
                        "Scan Number", "=", "1");
                }else {
                    $kora->add_clause("Resource Identifier", "=", $resource_identifier);
                }

                $page2 = json_decode($kora->search(), true);

                //Get the picture URL from the page results
                $picture_url = '';
                if (isset(array_values($page2)[0])) {
                    $picture_url = array_values($page2)[0]['Image Upload']['localName'];
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
        }
        //End of collections
        ///////////////////////////////////////

        //Josh- This code makes no sense to me
        //It brakes the resources page but only when the require_once(KORA_LIB . "Keyword_Search.php"); is there.
        //
        /*
        if (isset($response['order']) && $response['order'] == 'relevance') {
            $response['results'] = $this->Resource->findAllFromIds($response['results']);
        } else {
            //check if it is set
            $response['results'] = isset($response['results']) ? $response['results'] : "";
            $response['results'] = $this->Resource->find('all', array(
                'conditions' => array('Resource.id' => $response['results']),
                'order' => "Resource.{$options['order']} {$options['direction']}"
            ));
        }
        */

        /* todo - this code breaks if the user is not logged in
        // The searcher will return debug information that should be hidden for
        // most account types.
        if (!$this->Access->isAdmin()) {
            unset($response['raw_query']);
            unset($response['mode']);
        }
        */
/*
        $fields = array('Resource Identifier', 'Type', 'Title');
        $kora = new General_Search(RESOURCE_SID, 'kid', '!=', '1', $fields);
        $results['return'] = $kora->return_json();
        return $this->json(200, $results);
        //$json = $kora->return_json();
*/

        //return $this->json(200, 'hi' );
        //return;


        if ( $this->request->query['q'] == 'Orphan,=,true' ){  //search only for pages that are orphans

            //search for the orphaned pages with a limit.
			$pid = $GLOBALS['PID_ARRAY'][strtolower($pKid)];
			$sid = $GLOBALS['PAGES_SID_ARRAY'][strtolower($pKid)];
            $fields = array('Image Upload');
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
                if (array_key_exists('Image Upload', $page) && array_key_exists('originalName', $page['Image Upload']) ) {
                    $temp['title'] = $page['Image Upload']['originalName'];
                }

                $temp['thumb'] = '';
                if (array_key_exists('Image Upload', $page) && array_key_exists('localName', $page['Image Upload']) ) {
                    $temp['thumb'] = $page['Image Upload']['localName'];
                }

                //Decide if there is a picture..
                if ($temp['thumb'] != '') {
                    $temp['thumb'] = $this->smallThumb($temp['thumb']);
                } else {
                    $temp['thumb'] = Router::url('/', true) . "img/DefaultResourceImage.svg";
                }

                array_push($returnResults, $temp);
            }


        }else {     //search resources first by type, then get the page by resource
            //Get the Resources
            $user = "";
            $pass = "";
            $query = $this->request->query['q'];

			$pid = $GLOBALS['PID_ARRAY'][strtolower($pKid)];
			$sid = $GLOBALS['RESOURCE_SID_ARRAY'][strtolower($pKid)];

            //search for the resources by type
            $fields = array('Title','Resource Identifier');
            $query_array = explode(",", $query);
            if( $limit != -1 ) {
                $kora = new Advanced_Search($pid, $sid, $fields, 0, $limit+1);
            }else{
                $kora = new Advanced_Search($pid, $sid, array('Title'), 0, 0);
            }
            //Get resources by type and in the project resource kid array.
            //$kora->add_double_clause($query_array[0], $query_array[1], $query_array[2],
            //                            "kid", "IN", $projectKids);
			$kora->add_clause($query_array[0], $query_array[1], $query_array[2] );
            $resources = json_decode($kora->search(), true);

            if( $limit == -1 ){
                $return = array('results'=> array_keys($resources) );
                return $this->json(200, $return );
            }

            //grab all pages with the resource identifier
			$sid = $GLOBALS['PAGES_SID_ARRAY'][strtolower($pKid)];
            $fields = array('Image Upload', 'Resource Identifier', 'Scan Number');
            $kora = new Advanced_Search($pid, $sid, $fields);

            //get a accepted resource_identifier array for kora,
            //stay within the limit
            $count = 0;
            $resourceIdArray = array();
            foreach ($resources as $key => $item) {
                $count++;
                //if there are more resources, add more results
                if ($count > $limit && $limit != -1) {
                    break;
                }
                $resourceIdArray[] = $item['Resource Identifier'];
            }

            //using the array and 'in' this way because it's much faster.
            if( $query_array[2] == 'Field Journal' ) {
                $kora->add_double_clause("Resource Identifier", "IN", $resourceIdArray,
                    "Scan Number", "=", "1");
            }else {
                $kora->add_clause("Resource Identifier", "IN", $resourceIdArray);
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

                $temp['title'] = 'Unknown Title';
                if (array_key_exists('Title', $item) && $item['Title'] != '' ) {
                    $temp['title'] = $item['Title'];
                }

                //Get the Images
                $temp['thumb'] = '';
                $resource_identifier = $item['Resource Identifier'];

                //find the page by resource linkers and use the kid as the key.
                if( !empty($item['linkers']) ){
                    $minKey = min(array_keys($item['linkers'])); //grab the newest kid.
                    if(array_key_exists($minKey, $pages)){
                        $temp['thumb'] = $pages[$minKey]['Image Upload']['localName'];
                        unset($pages[$minKey]); //delete that page to optimize
                    }
                }

                //if the page wasn't found by key, then search through all pages manually.
                if ($temp['thumb'] == '') {
                    foreach ($pages as $key2 => $item2) {
                        if ($resource_identifier == $pages[$key2]['Resource Identifier']) {
                            $temp['thumb'] = $pages[$key2]['Image Upload']['localName'];
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
    public function advanced_resources() {
        $options = $this->parseParams();
        $this->autoRender = false;

        if (!isset($this->request->data['q']))
            return $this->emptySearch($options);

        $kora = new Advanced_Search($this->request->data['sid']);

        foreach ($this->request->data['q'] as $q) {
            $kora->add_clause($q[0], $q[1], $q[2]);
        }

        $results = $kora->search();
        echo ($results);
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
