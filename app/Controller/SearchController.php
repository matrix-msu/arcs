<?php
/**
 * Search controller
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
class SearchController extends AppController {
    public $name = 'Search';
    public $uses = array('Resource');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('search', 'resources');
        if (!isset($this->request->query['related'])) {
            $this->Resource->recursive = -1;
            $this->Resource->flatten = true;
        }
    }

    /**
     * Display the search page
     */
    public function search($query='') {
        $title = 'Search';
        if ($query) $title .= ' - ' . urldecode($query);
        $this->set('title_for_layout', $title);
    }


    /**
     * Display the advanced search page
     * @param string $query
     */
    public function advance_search($query='') {
        $title = 'Advanced Search';
        if ($query) $title .= ' - ' . urldecode($query);
        $this->set('title_for_layout', $title);
        $this -> render('advancedsearch');
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
			$response['limit'] = $limit;
		}

        //Josh- Collections searches for resources
        ///////////////////////////////////////////////////////
        $catchcollections = 1;
        if ( substr($this->request->query['q'],0,13) == 'collection_id' && $catchcollections == 1){
            $collection_table_id = substr($this->request->query['q'],15,-1);
            //$response['results'] = array('hello' => 'Collections catch',
            //'collection_id' => substr($this->request->query['q'],15,-1));
            //// Start SQL Area
            ///////////////////
            $db = new DATABASE_CONFIG;
            $db_object =  (object) $db;
            $db_array = $db_object->{'default'};
            $response['db_info'] = $db_array['host'];
            $mysqli = new mysqli($db_array['host'], $db_array['login'], $db_array['password'], $db_array['database']);

            if ($mysqli->connect_error) {
                die('Connect Error (' . $mysqli->connect_errno . ') '
                    . $mysqli->connect_error);
            }
            //Get a collection_id from the id
            $sql = "SELECT collection_id FROM arcs_dev.collections WHERE collections.id ='".$collection_table_id."' LIMIT 1";
            //WHERE title = '".$file_name."'";
            $result = $mysqli->query($sql);
            //while($row = mysqli_fetch_assoc($result))
            //  $test[] = $row;
            //$response['collection_table_id'] = $collection_table_id;
            //$response['sql'] = $sql;
            $collection_id = mysqli_fetch_assoc($result);
            $collection_id = $collection_id['collection_id'];

            //Get the kid's from the collection_id
            $sql = "SELECT resource_kid FROM arcs_dev.collections WHERE collections.collection_id ='".$collection_id."' LIMIT 12";
            $result = $mysqli->query($sql);
            while($row = mysqli_fetch_assoc($result))
                $test[] = $row;
            $response['col_id'] = $collection_id;
            $response['query'] = $sql;
            $response['col_result'] = $test;

            //fix the returned array's format from 'resource_kid' to 'kid'
            $response['results'] = array();
            foreach( $test as $row){
                $temp_array = array();
                $temp_kid = $row['resource_kid'];
                $temp_array['kid'] = $temp_kid;
                //Get the Resources from Kora
                $query = "kid,=,".$temp_kid;
                $temp_array['resource_query'] = $query;
                $user = "";
                $pass = "";
                $display = "json";
                $url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".RESOURCE_SID."&token=".TOKEN."&display=".$display."&query=".urlencode($query);
                $temp_array['resource_url'] = $url;
                ///initialize post request to KORA API using curl
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
                //capture results and map to array
                $page = json_decode(curl_exec($ch), true);
                $r = $page[$temp_kid];

                //Handle resource title
                $resource_title = $r['Title'];
                if( !empty($resource_title)){
                    $temp_array['title'] = $resource_title;
                }else{
                    $temp_array['title'] = 'Unknown Title';
                }

                //Handle resource type
                $resource_type = $r['Type'];
                if ( !empty($resource_type) ){
                    $temp_array['type'] = $resource_type;
                }else{
                    $temp_array['type'] = 'Unknown Type';
                }

                $temp_array['Resource'] = $r;
                $resource_identifier = $r['Resource Identifier'];

                //Get the Pages from Kora
                //$new_temp = array('7B-2E0-1');
                $query = "Resource Identifier,=,".$resource_identifier;
                //$response['query'] = $query;
                $user = "";
                $pass = "";
                $display = "json";
                //no query
                //$url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".PAGES_SID."&token=".TOKEN."&display=".$display;
                //query
                //$url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".PAGES_SID."&token=".TOKEN."&display=".$display."&query=".$query;
                $url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".PAGES_SID."&token=".TOKEN."&display=".$display."&query=".urlencode($query)."&count=1";

                ///initialize post request to KORA API using curl
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
                //capture results and map to array
                $page2 = json_decode(curl_exec($ch), true);

                //Get the picture URL from the page results
                $temp_array['page_search'] = $page2;
                $picture_url = array_values($page2)[0]['Image Upload']['localName'];

                //Decide if there is a picture..
                if( !empty($picture_url) ){
                    $temp_array['pic_url'] = $picture_url;
                    $kora_pic_url = "http://kora.matrix.msu.edu/files/123/738/";
                    $temp_array['thumb'] = $kora_pic_url.$picture_url;
                }else{
                    $temp_array['thumb'] = "img/DefaultResourceImage.svg";
                }
                array_push($response['results'], $temp_array );
            }
            //return collections
            $response['total'] = count($response['results']);
            return $this->json(200, $response);
        }
        //End of collections
        ///////////////////////////////////////

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
		$url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".PAGES_SID."&token=".TOKEN."&display=".$display."&showsystimestamp=YES&showrecordowner=YES&showpid=YES";
		///initialize post request to KORA API using curl
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
		//capture results and map to array
		$response['results'] = json_decode(curl_exec($ch), true);
		$imageResults = array();
		foreach($response['results'] as $image) {
			$imageResults[$image['Resource Identifier']] = KORA_FILES_URI.PID."/".PAGES_SID."/".$image['Image Upload']['localName'];
		}


		//Get the Data
		$user = "";
		$pass = "";
		$query = $this->request->query['q'];

        if (isset($this->request->query['sid'])) {
            $sid = $this->request->query['sid'];
        }
        else {
            $sid = RESOURCE_SID;
        }

		$display = "json";
		$url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".$sid."&token=".TOKEN."&display=".$display."&query=".urlencode($query)."&fields=ALL&showsystimestamp=YES&showrecordowner=YES&showpid=YES";
		///initialize post request to KORA API using curl
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);


		///capture results and display
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









    // This is a debug func, use it to throw varibles on the console
    public function debug_to_console( $data ) {
        if ( is_array( $data ) )
            $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
        else
            $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
        echo $output;
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










    public function simple_search($query1) {

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
                $imageResults[$image['Resource Identifier']] = KORA_FILES_URI.PID."/".PAGES_SID."/".$image['Image Upload']['localName'];
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
            $this->json(200, $response);

        }


    }





    /*
    public function advanced_search($query1) {

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
                $imageResults[$image['Resource Identifier']] = KORA_FILES_URI.PID."/".PAGES_SID."/".$image['Image Upload']['localName'];
            }




            // Getting the data!!
            $user = "";
            $pass = "";
            $display = "json";
            $sid = RESOURCE_SID;
            $query2 = '(Type,like,'. $query1.'),||,(Resource Identifier,like,'. $query1.'),||,(Accession Number,like,'. $query1.')';
            // $query2 = '(Type,=,%'. $query1.'%),||,(Resource Identifier,=,%'. $query1.'%),||,(Earliest Date,=,%'. $query1.'%),||,(Latest Date,=,%'. $query1.'%)';
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
    */







/*
    public function simple_search($query1) {

        $options = $this->parseParams();

        if (!isset($this->request->query['q']))
            return $this->emptySearch($options);

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
        if (isset($this->request->query['sid'])) {
            $sid = $this->request->query['sid'];
        }
        else {
            $sid = RESOURCE_SID;
        }

        //Get the Images
        $user = "";
        $pass = "";
        $display = "json";
        // $query2 = '((Type, like,' . $query1 . ') , or , (Resource Identifier, like,' . $query1 . '(Earliest Date, like,' . $query1 . '(Latest Date, like,' . $query1 . '))';
        $query2 = '((Type, like,' . $query1 . ') , or , (Resource Identifier, like ,' . $query1 . ') , or (Earliest Date, like,' . $query1 . ') , or ,(Latest Date, like,' . $query1 . '))';
        // $url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".PAGES_SID."&token=".TOKEN."&display=".$display."&showsystimestamp=YES&showrecordowner=YES&showpid=YES";
        $url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".$sid."&token=".TOKEN."&display=".$display."&query=".urlencode($query2);
        ///initialize post request to KORA API using curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
        //capture results and map to array
        $response['results'] = json_decode(curl_exec($ch), true);
        $imageResults = array();
        foreach($response['results'] as $image) {
            $imageResults[$image['Resource Identifier']] = KORA_FILES_URI.PID."/".PAGES_SID."/".$image['Image Upload']['localName'];
        }



        //Get the Data
        $user = "";
        $pass = "";
        $query = $this->request->query['q'];

        if (isset($this->request->query['sid'])) {
            $sid = $this->request->query['sid'];
        }
        else {
            $sid = RESOURCE_SID;
        }

        $display = "json";
        //$query2 = '((Type, like,' . $query1 . ') , or , (Resource Identifier, like,' . $query1 . '(Earliest Date, like,' . $query1 . '(Latest Date, like,' . $query1 . '))';
        $query2 = '((Type, like,' . $query1 . ') , or , (Resource Identifier, like,' . $query1 . ') , or (Earliest Date, like,' . $query1 . ') , or ,(Latest Date, like,' . $query1 . '))';
        $url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".$sid."&token=".TOKEN."&display=".$display."&query=".urlencode($query2);
        ///initialize post request to KORA API using curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);


        ///capture results and display
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

        return $response['results'] = $returnResults;
        $response['total'] = count($response['results']);
        $this->json(200, $response);
    }



*/


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
