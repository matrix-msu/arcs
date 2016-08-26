<?php
/**
 * Created by PhpStorm.
 * User: marc
 * Date: 28/06/16
 * Time: 11:33 AM
 */

class AdvancedSearchController extends AppController {
    public $name = 'Advanced Search';
    public $uses = array('advance_search');

    public $paginate = [
        'limit' => 20,
        'order' => [
            'Search.response.Title' => 'asc'
        ]
    ];

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
    }

    public function beforeFilter()
    {
        parent::beforeFilter();
        //$this->Auth->allow('advanced_search', 'resources');
        if (!isset($this->request->query['related'])) {
            //$this->Resource->recursive = -1;
            //$this->Resource->flatten = true;
        }
    }



    /**
     * Display the advanced search page
     * @param string $query
     */

    public function advance_search($query = '')
    {
        $title = 'Advanced Search';
        if ($query) $title .= ' - ' . urldecode($query);
        $this->set('title_for_layout', $title);
        $this->render('/AdvancedSearch/advancedsearch');
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

        $query = json_decode($query,true);

        if($sid == RESOURCE_SID){
            // making the query we want by specfic fields!!
            $q = "";
            foreach ($query as $value) {
                if ( ($value != "") && (count($query) > 1) ) {
                    if ($query[0] === $value) {
                        $q .= '( (Type,like,'. $value.'),||,(Resource Identifier,like,'. $value.'),||,(Accession Number,like,'. $value.') )';
                    }else {
                        $q .= ',&&,( (Type,like,'. $value.'),||,(Resource Identifier,like,'. $value.'),||,(Accession Number,like,'. $value.') )';
                    }
                    $q = '(Type,like,'. $value.'),||,(Resource Identifier,like,'. $value.'),||,(Accession Number,like,'. $value.')';
                }elseif ($query != "") {
                    $q = '(Type,like,'. $value.'),||,(Resource Identifier,like,'. $value.'),||,(Accession Number,like,'. $value.')';
                }else{
                    // Do nothing, just pass
                }
            }
            // $q = '(Type,like,'. $query.'),||,(Resource Identifier,like,'. $query.'),||,(Earliest Date,like,'. $query.'),||,(Latest Date,like,'. $query.')';
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
            $q = "";
            foreach ($query as $value) {
                if ( ($value != "") && (count($query) > 1) ) {
                    if ($query[0] === $value) {
                        $q .= '( (Name,like,'. $value.'),||,(Period,like,'. $value.') )';
                    }else {
                        $q .= ',&&,( (Name,like,' . $value . '),||,(Period,like,' . $value . ') )';
                    }
                }elseif ($query != ""){
                    $q = '(Name,like,'. $value.'),||,(Period,like,'. $value.')';
                }else {
                    // DO nothing
                }
            }
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
            $q = "";
            foreach ($query as $value) {
                if ( ($value != "") && (count($query) > 1) ) {
                    if ($query[0] === $value) {
                        $q .= '( (Earliest Date,like,'. $value.'),||,(Latest Date,like,'. $value.') )';
                    }else {
                        $q .= ',&&,( (Earliest Date,like,'. $value.'),||,(Latest Date,like,'. $value.') )';
                    }
                }elseif ($query != ""){
                    $q = '(Earliest Date,like,'. $value.'),||,(Latest Date,like,'. $value.')';
                }else {
                    // DO nothing
                }
            }
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
            // $q = '(Name,like,'. $query.'),||,(Earliest Date,like,'. $query.'),||,(Latest Date,like,'. $query.')';
            $q = "";
            foreach ($query as $value) {
                if ( ($value != "") && (count($query) > 1) ) {
                    if ($query[0] === $value) {
                        $q .= '( (Earliest Date,like,'. $value.'),||,(Latest Date,like,'. $value.') )';
                    }else {
                        $q .= ',&&,( (Earliest Date,like,'. $value.'),||,(Latest Date,like,'. $value.') )';
                    }
                }elseif ($query != ""){
                    $q = '(Earliest Date,like,'. $value.'),||,(Latest Date,like,'. $value.')';
                }else {
                    // do nothing
                }
            }
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
            $q = "";
            foreach ($query as $value) {
                if ( ($value != "") && (count($query) > 1) ) {
                    if ($query[0] === $value) {
                        // $q .= '( (Earliest Date,like,'. $value.'),||,(Latest Date,like,'. $value.') )';
                        $q = '( (Artifact - Structure Classification,like,'. $value.'),||,';
                        $q .= '(Artifact - Structure Type,like,'. $value.'),||,';
                        $q .= '(Artifact - Structure Material,like,'. $value.'),||,';
                        $q .= '(Artifact - Structure Technique,like,'. $value.'),||,';
                        $q .= '(Artifact - Structure Period,like,'. $value.'),||,';
                        $q .= '(Artifact - Structure Terminus Ante Quem,like,'. $value.'),||,';
                        $q .= '(Artifact - Structure Terminus Post Quem,like,'. $value.') )';
                    }else {
                        // $q .= ',&&,( (Earliest Date,like,'. $value.'),||,(Latest Date,like,'. $value.') )';
                        $q = ',&&,( (Artifact - Structure Classification,like,'. $value.'),||,';
                        $q .= '(Artifact - Structure Type,like,'. $value.'),||,';
                        $q .= '(Artifact - Structure Material,like,'. $value.'),||,';
                        $q .= '(Artifact - Structure Technique,like,'. $value.'),||,';
                        $q .= '(Artifact - Structure Period,like,'. $value.'),||,';
                        $q .= '(Artifact - Structure Terminus Ante Quem,like,'. $value.'),||,';
                        $q .= '(Artifact - Structure Terminus Post Quem,like,'. $value.') )';
                    }
                }elseif ($query != "") {
                    $q = '(Artifact - Structure Classification,like,'. $value.'),||,';
                    $q .= '(Artifact - Structure Type,like,'. $value.'),||,';
                    $q .= '(Artifact - Structure Material,like,'. $value.'),||,';
                    $q .= '(Artifact - Structure Technique,like,'. $value.'),||,';
                    $q .= '(Artifact - Structure Period,like,'. $value.'),||,';
                    $q .= '(Artifact - Structure Terminus Ante Quem,like,'. $value.'),||,';
                    $q .= '(Artifact - Structure Terminus Post Quem,like,'. $value.')';
                }else {
                    // DO nothing
                }
            }
            /*
            $q = '(Artifact - Structure Classification,like,'. $query.'),||,';
            $q .= '(Artifact - Structure Type,like,'. $query.'),||,';
            $q .= '(Artifact - Structure Material,like,'. $query.'),||,';
            $q .= '(Artifact - Structure Technique,like,'. $query.'),||,';
            $q .= '(Artifact - Structure Period,like,'. $query.'),||,';
            $q .= '(Artifact - Structure Terminus Ante Quem,like,'. $query.'),||,';
            $q .= '(Artifact - Structure Terminus Post Quem,like,'. $query.')';
            */

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











    protected function search_single_scheme1($sid, $query) {
        // Let us check and decide which sid we need to search, plus make the appropiate
        // query to be used pull data out of KORA.
        $user = "";
        $pass = "";
        $display = "json";

        $qu = json_decode($query,true);
        $query = $qu[0];

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
                // $imageResults[$image['Resource Identifier']] = KORA_FILES_URI.PID."/".PAGES_SID."/".$image['Image Upload']['localName'];
                // $imageResults[$image['Resource Identifier']] = $this->smallThumb($image['Image Upload']['localName']);
                $imageResults[$image['Resource Identifier']] = $image['Image Upload']['localName'];
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
                //$imageResults[$item['Resource Identifier']] = $this->smallThumb($image['Image Upload']['localName']);
                if ($imageResults[$item['Resource Identifier']] != null) {
                    //$item['thumb'] = $imageResults[$item['Resource Identifier']];
                    $item['thumb'] = $this->smallThumb($imageResults[$item['Resource Identifier']]);
                } else {
                    $item['thumb'] = DEFAULT_THUMB;
                }
                $returnResults[$key] = $item;
                //array_push($returnResults, $item);
            }

            $response['results'] = $returnResults;
            $response['total'] = count($response['results']);
//            $numberOfPages = ceil($response['total']/$perPage);
//            $skip = ($page-1)*$perPage;
//            $response['display'] = array_slice($response['results'],$skip,$perPage);
//            $response['pages'] = $numberOfPages;
//            $response['pageNumber'] = $page;
//            $response['numberPerPage'] = $perPage;  //pass this variable in eventually
//            $response['skip'] = $skip;
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

    public function paginate($object = NULL, $scope = array(), $whiteList = array()){

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
