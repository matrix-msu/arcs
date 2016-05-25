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






    public function debug_to_console( $data ) {

        if ( is_array( $data ) )
            $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
        else
            $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
        echo $output;
    }





    public function simple_search($query) {
        return $query;
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



        //Get the Images
        $user = "";
        $pass = "";
        $display = "json";

        // Variables to check for so as to return our search with the approapiate data
        $r_id =  'Resource Identifier';
        $type = 'type';
        $e_date = 'Earliest Date';
        $l_date = 'Latest Date';
        // "http://kora.matrix.msu.edu/api/restful.php?request=GET&pid=123&sid=736&token=8b88eecedaa2d3708ebec77a&display=json&keywords="+resourcequery+"&sort=kid&order=SORT_ASC
        $url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".PAGES_SID."&token=".TOKEN."&display=".$display."&showsystimestamp=YES&showrecordowner=YES&showpid=YES";
        ///initialize post request to KORA API using curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
        //capture results and map to array
        $response['results'] = json_decode(curl_exec($ch), true);
        $imageResults = array();
        foreach($response['results'] as $image) {
            if ($query == $response['results'].$r_id) {
                $imageResults[$image['Resource Identifier']] = KORA_FILES_URI.PID."/".PAGES_SID."/".$image['Image Upload']['localName'];
            }else if ($query == $response['results'].$e_date) {
                $imageResults[$image['Resource Identifier']] = KORA_FILES_URI.PID."/".PAGES_SID."/".$image['Image Upload']['localName'];
            }else if ($query == $response['results'].$l_date) {
                $imageResults[$image['Resource Identifier']] = KORA_FILES_URI.PID."/".PAGES_SID."/".$image['Image Upload']['localName'];
            }else if ($query == $response['results'].$type){
                $imageResults[$image['Resource Identifier']] = KORA_FILES_URI.PID."/".PAGES_SID."/".$image['Image Upload']['localName'];
            }else {
                // do nothing - probs not efficient to let a free cycle got o waste
            }
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
        // $url = "http://kora.matrix.msu.edu/api/restful.php?request=GET&pid=123&sid=736&token=8b88eecedaa2d3708ebec77a&display=json&keywords=".query."&sort=kid&order=SORT_ASC";
        $url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".$sid."&token=".TOKEN."&display=".$display."&query=".urlencode($query)."&sort=kid&order=SORT_ASC";
        ///initialize post request to KORA API using curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);


        ///capture results and display
        $response['results'] = json_decode(curl_exec($ch), true);
        $returnResults = array();
        foreach($response['results'] as $item) {
            if ($query == $item.$r_id) {
                $imageResults[$image['Resource Identifier']] = KORA_FILES_URI.PID."/".PAGES_SID."/".$image['Image Upload']['localName'];
            }else if ($query == $item.$e_date) {
                $imageResults[$image['Resource Identifier']] = KORA_FILES_URI.PID."/".PAGES_SID."/".$image['Image Upload']['localName'];
            }else if ($query == $item.$l_date) {
                $imageResults[$image['Resource Identifier']] = KORA_FILES_URI.PID."/".PAGES_SID."/".$image['Image Upload']['localName'];
            }else if ($query == $item.$type){
                $imageResults[$image['Resource Identifier']] = KORA_FILES_URI.PID."/".PAGES_SID."/".$image['Image Upload']['localName'];
            }else {
                // do nothing - probs not efficient to let a free cycle got o waste
            }
        }
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
        $this->json(200, $query);
        //$this->set('_serialize', array( $response ) );
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
