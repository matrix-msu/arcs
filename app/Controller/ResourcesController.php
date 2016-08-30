<?php
/**
 * Resources Controller
 *
 * Logic for retrieving and presenting resources.
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */



class ResourcesController extends AppController {

    public $name = 'Resources';
    public $uses = array('Resource', 'Collection', 'MetadataEdit');

    public function beforeFilter() {
        # The App Controller will set some common view variables (namely a
        # user array), so the parent's beforeFilter is run in this and most
        # other controllers.
        parent::beforeFilter();

        # Read-only actions, such as viewing resources and associated comments
        # are allowed by default.
        $this->Auth->allow(
            'view', 'viewer', 'search', 'comments', 'annotations',
            'keywords', 'complete', 'zipped', 'download'
        );
        if (!isset($this->request->query['related'])) {
            $this->Resource->recursive = -1;
            $this->Resource->flatten = true;
        }
    }

    /**
     * Create a resource.
     *
     * This is the API version, see the Uploads controller for the form-based
     * uploader.
     */
    public function add() {
        if (!$this->request->is('post')) throw new MethodNotAllowedException();
        $this->request->data['user_id'] = $this->Auth->user('id');
        # Process requests with a download url later.
        if (isset($this->request->data['url'])) {
            $this->Job->enqueue('download_file', $this->request->data);
            return $this->json(202);
        }
        if (empty($_FILES)) throw new BadRequestException();
        $this->Resource->fromFile(array_shift($_FILES), $this->request->data);
        $this->json(201, $this->Resource->id);
    }

    /**
     * We don't have an index.
     */
    public function index() {
        throw new NotImplementedException();
    }

    /**
     * Edit the resource.
     *
     * @param string $id    resource id
     */
    public function edit($id=null) {
        if (!($this->request->is('post') || $this->request->is('put')))
            throw new MethodNotAllowedException();
        $resource = $this->Resource->findById($id);
        if (!$resource) throw new NotFoundException();
        if (!$this->Resource->add($this->request->data))
            throw new InternalErrorException();
        $this->json(200, $this->Resource->findById($id));
    }

    /**
     * Return resource info.
     *
     * @param string $id    resource id
     */
    public function view($id=null) {
        if (!$this->request->is('get')) throw new MethodNotAllowedException();
        if (!$id) throw new BadRequestException();
        $resource = $this->Resource->findById($id);
        if (!$resource) throw new NotFoundException();
        $public = $this->Resource->flatten ? $resource['public'] : $resource['Resource']['public'];
        if (!($public || $this->Auth->loggedIn())) throw new UnauthorizedException();
        $this->json(200, $resource);
    }

    /**
     * Delete the resource, if authorized.
     *
     * @param string $id    resource id
     */
    public function delete($id=null) {
        if (!$this->request->is('delete')) throw new MethodNotAllowedException();
        if (!$this->Auth->loggedIn()) throw new UnauthorizedException();
        if (!$this->Access->isAdmin()) throw new ForbiddenException();
        if (!$this->Resource->delete($id)) throw new InternalErrorException();
        $this->json(204);
    }

    /**
     * Creates a task to split a PDF into individual resources. Note it doesn't
     * actually do any splitting within the Request-Response loop.
     *
     * @param string $id    resource id
     */
    public function split_pdf($id=null) {
        if (!$this->request->is('post')) throw new MethodNotAllowedException();
        if (!$id) throw new BadRequestException();
        $resource = $this->Resource->findById($id);
        if (!$resource) throw new NotFoundException();
        if (!$resource['mime_type'] == 'application/pdf')
            throw new BadRequestException();
        # Create a new collection for the split.
        $this->Collection->permit('user_id');
        $this->Collection->add(array(
            'title' => $resource['title'],
            'description' => 'PDF split of ' . $resource['title'],
            'public' => $resource['public'],
            'user_id' => $this->Auth->user('id'),
            'pdf' => $id
        ));
        # Make a new task to split the PDF.
        $this->Job->enqueue('split_pdf', array(
            'resource_id' => $id,
            'collection_id' => $this->Collection->id,
            'type' => 'Notebook Page'
        ));
        $this->json(202);
    }

    /**
     * The Resource viewer.
     *
     * @param string $id            resource id
     * @param bool   $ignore_ctx    if true, the action will not redirect to the
     *                              collection view when the resource has a
     *                              non-null context attribute.
     */
    public function viewer($id, $page=0, $ignore_ctx=false) {

        $this->Resource->recursive = 1;
        $this->Resource->flatten = false;

    		//Get the Images
    		$query = "Resource Associator,=,".$id;
    		$user = "";
    		$pass = "";
    		$display = "json";
    		$url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".PAGES_SID."&token=".TOKEN."&display=".$display.
                "&query=".urlencode($query).'&fields=ALL';


    		///initialize post request to KORA API using curl
    		$ch = curl_init($url);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    		curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
    		//capture results and map to array
    		$pages = json_decode(curl_exec($ch), true);
      	$first = true;

            // get the first entry in $pages
            $firstPage = array_values($pages)[0]['kid'];
            //$pages[$firstPage]['thumb'] = KORA_FILES_URI.PID."/".PAGES_SID."/".$pages[$firstPage]['Image Upload']['localName'];
            // Shifting to create thumbnails for every page
            foreach($pages as $page) {
                $pages[$page['kid']]['thumbnail'] = $this->largeThumb($page['Image Upload']['localName']);
                $pages[$page['kid']]['thumb'] = KORA_FILES_URI.PID."/".PAGES_SID."/".$pages[$page['kid']]['Image Upload']['localName'];
            }

    		//resource
    		$query = "kid,=,".$id;
    		$display = "json";
    		$url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".RESOURCE_SID."&token=".TOKEN."&display=".$display."&query=".
                urlencode($query).'&fields=ALL';
    		///initialize post request to KORA API using curl
    		$ch = curl_init($url);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    		curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
    		//capture results and display
    		$resource = json_decode(curl_exec($ch), true);
    		$resource = $resource[$id];

    		$resource_id = $resource['Resource Identifier'];


            //survey
            $surveys = array();
            $seasonKID = '';
            if(is_array($resource['Excavation - Survey Associator'])){
              foreach ($resource['Excavation - Survey Associator'] as $kid) {
                  $query = "kid,=,".$kid;
                  $url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".SURVEY_SID."&token=".TOKEN."&display=".$display."&query=".
                      urlencode($query).'&fields=ALL';
                  ///initialize post request to KORA API using curl
                  $ch = curl_init($url);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                  curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
                  //capture results and display
                  $survey = json_decode(curl_exec($ch), true);
                  $survey = $survey[$kid];
                  array_push($surveys, $survey);
                  //If no seasons for a resource, use resource season associator
      			      if ($seasonKID == '') {
                  	 $seasonKID = $survey['Season Associator'][0];	// does nothing?
              	  }
                }
              }

            //If no seasons for a resource, use resource season associator
            if ($seasonKID == '') {
                $seasonKID = $resource['Season Associator'][0];
            }


            // SOO - Subject of Observation
            $query = "Resource Identifier,=,".$resource_id; // use this particular resource identifier
    		$url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".SUBJECT_SID."&token=".TOKEN."&display=".$display."&query=".
                urlencode($query).'&fields=ALL';
    		$ch = curl_init($url);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    		curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
    		//capture results and display
    		 $subject = json_decode(curl_exec($ch), true); // this is actually an array
         //print_r(count($subject);
        //exit(0);
    		//season
    		$seasons = array();
    		$projectKid = '';
    		$query = "kid,=,".$seasonKID;
    		$url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".SEASON_SID."&token=".TOKEN."&display=".$display."&query=".
                urlencode($query).'&fields=ALL';
    		///initialize post request to KORA API using curl
    		$ch = curl_init($url);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    		curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
    		//capture results and display
    		$season = json_decode(curl_exec($ch), true);
    		$season = $season[$seasonKID];

    		if ($projectKid == '') {
    			$projectKid = $season['Project Associator'][0];
    		}

    		//array_push($seasons, $season);

    		//project
    		$query = "kid,=,".$projectKid;
    		$url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".PROJECT_SID."&token=".TOKEN."&display=".$display."&query=".
                urlencode($query).'&fields=ALL';
    		///initialize post request to KORA API using curl
    		$ch = curl_init($url);
    		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    		curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
    		//capture results and display
    		$project = json_decode(curl_exec($ch), true);
    		$project = $project[$projectKid];
            $project['url'] = $url;

    		$resource['thumb'] = $pages[$firstPage]['thumb'];

            $public = isset($resource['Resource']['public']) ? $resource['Resource']['public'] : false;
            $allowed = true; // $public || $this->Auth->loggedIn();

            if (!$resource) return $this->redirect('/404');
            if (!$allowed) {
                $this->Session->setFlash("Oops. You'll need to login to view that.",
                    'flash_error');
                $this->Session->write('redirect', '/resource/' . $id);
                return $this->redirect($this->Auth->redirect('#loginModal'));
            }

            # Redirect if the resource's context is non-null.
            $resourceContext = isset($resource['Resource']['context']) ?$resource['Resource']['context'] : "";
            if ($resourceContext && !$ignore_ctx) {
                return $this->redirect('/collection/' .
                    $resource['Resource']['context'] . '/' . $id
                );
            }

    		//Set kid for viewer
            //moved to line 260
    		/*if (isset($pages[$firstPage]['kid'])) {
    			$this->set(array('kid' =>$pages[$firstPage]['kid']));
    		} else {
    			$this->set(array('kid' => $resource['kid']));
    		}*/

            $collections = json_encode($this->Collection->find('all', array(
                'fields'    => array('DISTINCT collection_id', 'title', 'user_name'),
                'order'     => 'created DESC',
                'recursive' => -1
            )));


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
            $sql = "SELECT metadata_kid, field_name FROM arcs_dev.metadata_edits WHERE rejected = '".decbin(0)."'";
            $result = $mysqli->query($sql);
            while($row = mysqli_fetch_assoc($result))
                $metadataedits[] = array('field_name' => $row['field_name'], 'metadata_kid' => $row['metadata_kid']);

            $this->set(array(
                'kid' =>$pages[$firstPage]['kid'],
                'pages' => $pages,
                'resource' => $resource,
                'subject' => $subject,
                'surveys' => $surveys,
    			'season' => $season,
                'project' => $project,
                'collections' => $collections,
                'metadataEdits' => $metadataedits,
                'toolbar' => array('actions' => true),
                'footer' => false,
                'body_class' => 'viewer standalone',
    			'kora_url' => KORA_FILES_URI.PID."/".PAGES_SID."/",
                'admin' => $this->Auth->user('isAdmin') == 1
            ));


            # On the first request of a particular resource (usually directly
            # after upload), we might prompt the user for additional
            # actions/information. Here we're turning that off for future
            # requests. (Note that the first_req will still be true within the
            # $resource var.)
            $resourceFirstReq = isset($resource['Resource']['first_req']) ?$resource['Resource']['first_req'] : false ;
            if ($resourceFirstReq)
                $this->Resource->firstRequest($resource['Resource']['id']);
    }

    /**
     * Render a resource file using the download element. The download element
     * will set the file headers, which include an ambiguous Content-type to
     * 'force' the download.
     *
     * @param string $id   resource id
     */
    public function download($id) {
        $resource = $this->Resource->findById($id);
        if (!$resource) throw new NotFoundException();
        $this->layout = false;
        Configure::write('debug', 0);
        $sha = $resource['sha'];
        $this->set('fname', $resource['file_name']);
        $this->set('fsize', $resource['file_size']);
        $this->set('path', $this->Resource->path($sha, $sha));
        $this->render('/Elements/download');
    }

    /**
     * Create a zipfile of the POSTed array of resources. Responds with a JSON
     * object containing a url to the zipfile.
     */
    public function zipped() {
        # TODO: Look into streaming the zipfile, vs. making it and then providing
        # the link...
        if (!($this->request->is('post') && $this->request->data))
            throw new BadRequestException();
        $ids = $this->request->data['resources'];
        $resources = $this->Resource->find('all', array(
            'conditions' => array(
                'Resource.id' => $ids
            )
        ));
        $files = array();
        foreach ($resources as $r) {
            $files[$r['file_name']] = $r['sha'];
        }
        $title = str_replace(' ', '-', $resources[0]['title']);
        $name = $title . '-and-' .
            (count($files) - 1) . '-' .
            (count($files) > 2 ? 'others' : 'other');
        $sha = $this->Resource->makeZipfile($files, $name);
        $this->json(200, array('url' => $this->Resource->url($sha, $name . '.zip')));
    }

    /**
     * Request a re-thumbnail of a resource's thumbnail image. This is handled
     * through the Job Worker. We'll respond with a 202 status code if
     * everything checks out.
     *
     * @param string $id   resource id
     */
    public function rethumb($id) {
        if (!$this->request->is('post')) throw new BadRequestException();
        if (!$this->Auth->loggedIn()) throw new UnauthorizedException();
        $resource = $this->Resource->findById($id);
        if (!$resource) throw new NotFoundException();
        $this->Job->enqueue('thumb', array('resource_id' => $resource['id']));
        $this->json(202);
    }

    /**
     * Request that a resource's preview image be redone.
     *
     * @param string $id   resource id
     */
    public function repreview($id) {
        if (!$this->request->is('post')) throw new BadRequestException();
        if (!$this->Auth->loggedIn()) throw new UnauthorizedException();
        $resource = $this->Resource->findById($id);
        if (!$resource) throw new NotFoundException();
        $this->Job->enqueue('preview', array('resource_id' => $resource['id']));
        $this->json(202);
    }

    /**
     * Request that a resource by (re)indexed in SOLR.
     *
     * @param string $id   resource id
     */
    public function solr($id) {
        if (!$this->request->is('post')) throw new BadRequestException();
        if (!$this->Auth->loggedIn()) throw new UnauthorizedException();
        $resource = $this->Resource->findById($id);
        if (!$resource) throw new NotFoundException();
        $this->Job->enqueue('solr_index', array('resource_id' => $resource['id']));
        $this->json(202);
    }

    /**
     * Get or set (depending on HTTP method) metadata for the given resource.
     *
     * @param string $id   resource id
     */
    public function metadata($id) {
        if (!$this->Resource->findById($id)) throw new NotFoundException();
        if (($this->request->is('post') || $this->request->is('put')) &&
            $this->request->data)
        {
            foreach ($this->request->data as $k => $v)
                $this->Resource->Metadatum->store($id, $k, $v);
            return $this->json(201);
        }
        if ($this->request->is('get'))
            return $this->json(200, $this->Resource->Metadatum->find('all', array(
                'conditions' => array(
                    'Metadatum.resource_id' => $id
            ))));
        throw new BadRequestException();
    }

    /**
     * Return associated comments.
     *
     * @param string $id    resource id
     */
    public function comments($id=null) {
        if (!$this->request->is('get') || !$id) throw new BadRequestException();
        $this->json(200, $this->Resource->Comment->find('all',
            array('conditions' => array('Resource.id' => $id))
        ));
    }

    /**
     * Return associated keywords.
     *
     * @param string $id    resource id
     */
    public function keywords($id=null) {
        if (!$this->request->is('get') || !$id) throw new BadRequestException();
        $this->json(200, $this->Resource->Keyword->find('all',
            array('conditions' => array('Resource.id' => $id))
        ));
    }

    /**
     * Return associated hotspots.
     *
     * @param string $id    resource id
     */
    public function annotations($id=null) {
        if (!$this->request->is('get') || !$id) throw new BadRequestException();
        $this->Resource->Annotation->flatten = true;
        $res = array();
        $res['annotations'] = $this->Resource->Annotation->find('all', array(
            'conditions' => array('Resource.id' => $id)
        ));
        $relations = array_filter(array_map(function($a) {
            return isset($a['relation']) ?  $a['relation'] : null;
        }, $res['annotations']));
        if ($relations) {
            $res['relations'] = $this->Resource->find('all', array(
                'conditions' => array('Resource.id' => $relations)
            ));
        }
        $this->json(200, $res);
    }

    /**
     * Return a list of values for autocompletion.
     *
     * @param string $field   Resource field to complete.
     */
    public function complete($field=null) {
        if (!$this->request->is('get') || !$field) throw new BadRequestException();
        switch ($field) {
            case 'title':
                $values = $this->Resource->complete('Resource.title');
                break;
            case 'created':
                $values = $this->Resource->complete('Resource.created', null, true);
                break;
            case 'modified':
                $values = $this->Resource->complete('Resource.modified', null, true);
                break;
            default:
                $values = array();
        }
        $this->json(200, $values);
    }

    /**
     * Lightweight version of what viewer() does.
     * Instead of returning the entire page content though
     *
     * return only the image for viewer-window and content for right sidebar
     */
    public function loadNewResource($id) {
        $this->autoRender = false;

        //Get the Images
        $query = "kid,=,".$id;
        $user = "";
        $pass = "";
        $display = "json";
        $url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".PAGES_SID."&token=".TOKEN."&display=".$display."&query=".urlencode($query);
        ///initialize post request to KORA API using curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
        //capture results and map to array
        $page = json_decode(curl_exec($ch), true);
        $p = $page[$id];
        $p['kora_url'] = KORA_FILES_URI.PID."/".PAGES_SID."/";

        //$this->_View->viewVars['kid'] = $p['kid'];

		// return KORA_FILES_URI.PID."/".PAGES_SID."/".$p['Image Upload']['localName'];
		return json_encode($p);
    }

    /**
     * View a resource
     *
     * @param string $id
     */
    public function viewKid($id)
    {
        $response = ['kid' => $id];

        //resource
        $query = "kid,=,".$id;
        $user = "";
        $pass = "";
        $display = "json";
        $url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".RESOURCE_SID."&token=".TOKEN."&display=".$display."&query=".urlencode($query);
        ///initialize post request to KORA API using curl
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
        //capture results and map to array
        $resource = json_decode(curl_exec($ch), true);
        //echo $resource;
        $resource = $resource[$id];
        //$this->json(200, $resource);
        //return $resource;
        $response['type'] = $resource['Type'];
        $response['title'] = $resource['Title'];

        $resource_identifier = $resource['Resource Identifier'];

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
            //$kora_pic_url = "http://kora.matrix.msu.edu/files/123/738/";
            //$response['thumb'] = $kora_pic_url.$picture_url;
            $response['thumb'] = $this->smallThumb($temp_array['pic_url']);
            $response['largethumb'] = $this->largeThumb($temp_array['pic_url']);
        }else{
            $response['thumb'] = Router::url('/', true)."img/DefaultResourceImage.svg";
            $response['largethumb'] = Router::url('/', true)."img/DefaultResourceImage.svg";
        }

        $this->json(200, $response);
        return $response;
    }

    public function export(){
        # create new zip opbject
        $zip = new ZipArchive();

        # create a temp file & open it
        $tmp_file = tempnam('.','Resouce_Data.zip');
        $zip->open($tmp_file, ZipArchive::CREATE);

        $count = 0;
        $xmlNames = ['Project_data.xml', 'Season_data.xml', 'Excavation_Survey_data.xml', 'Resource_data.xml',
            'Subject_Of_Observation_data.xml', 'Pages_data.xml'];
        foreach ($this->request->data['xmls'] as $xml) {
            $zip->addFromString($xmlNames[$count], $xml);
            $count++;
        }

        foreach($this->request->data['picUrls'] as $url){
            # download file
            $string = KORA_FILES_URI.PID.'/'.PAGES_SID.'/'.$url;
            $download_file = file_get_contents( $string );
            $zip->addFromString('images/'.basename($url),$download_file);
        }
        $zip->close();
        //send back base64 format of a zip file
        $data = file_get_contents($tmp_file);
        $this->json(200, base64_encode($data) );
    }

}
