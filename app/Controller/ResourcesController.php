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

 require_once(KORA_LIB . "General_Search.php");
 require_once(KORA_LIB . "Advanced_Search.php");
 require_once(KORA_LIB . "Resource_Search.php");
 require_once(KORA_LIB . "../Class/Benchmark.php");
 use mb\Benchmark;

// Enum class for Permissions
abstract class Permissions {
    const R_Public  = "Public";
    const R_Member  = "Member";
    const R_Special = "Special";
}


class ResourcesController extends AppController {

    public $name = 'Resources';
    public $uses = array('Resource', 'Collection', 'MetadataEdit', 'User');

    public function beforeFilter() {
        # The App Controller will set some common view variables (namely a
        # user array), so the parent's beforeFilter is run in this and most
        # other controllers.
        parent::beforeFilter();
        # Read-only actions, such as viewing resources and associated comments
        # are allowed by default.
        $this->Auth->allow(
            'view', 'viewer', 'multi_viewer', 'search', 'comments', 'annotations',
            'keywords', 'complete', 'zipped', 'download', 'checkExportDone', "loadNewResource", 'createExportFile', 'downloadExportFile', 'viewtype'
        );
        if (!isset($this->request->query['related'])) {
            $this->Resource->recursive = -1;
            $this->Resource->flatten = true;
        }
    }
    /**
     * Filters a kora return by permissions
     *
     * @param string $userName  is the username tied to the search
     * @param array  $resources is a reference to the results returned from a kora search
     *
     */ 
     public static function filterByPermission($userName, &$resources) {
        
        
        if (empty($userName)) {
            static::lockResourcesByPermission(Permissions::R_Member, $resources);
            static::lockResourcesByPermission(Permissions::R_Special, $resources);
        } else {

            $KIDs = array();
            $i = 0;
            foreach($resources as $resource) {
                if(isset($resource['kid'])) {
                    $KIDs[$i++] = $resource['kid'];
                }
            }

            $projects = array();
            foreach($KIDs as $kid) {
                $name = parent::convertKIDtoProjectName($kid);
                $projects[$name] = "";
            }

            $projects = array_keys($projects);
            foreach($projects as $project) {
                $pid = parent::getPIDFromProjectName($project);
                $sid = parent::getResourceSIDFromProjectName($project);
                $fields = array('Special User', 'Permissions', 'Type','Title');
                $kora = new Advanced_Search($pid, $sid, $fields);
                $kora->add_clause("kid", "IN", $KIDs);
                $res = json_decode($kora->search(), true);
                foreach($res as $resource) {
                    // Permissions is Special User, but the user is not on
                    // the special user list
                    if (
                        isset($resource['Permissions']) &&
                        $resource['Permissions'] === Permissions::R_Special &&
                        !static::isSpecial($resource['Special User'], $userName)
                       )
                            static::lockResource($kid,$resources);
                }
            }    
        }  
    }
    /**
     * Checks if a username is in the special field
     *
     * @param string $specialFieldString  is the string from the special user field from kora
     * @param string $username            is the username to look for
     *
     */ 
    public static function isSpecial($specialFieldString, $username) {
        $users = explode('|',$specialFieldString);
        foreach($users as $user){
            if (trim($user) === $username) {
                return false;
            }
        }
        return false;
    }
    /**
     * Locks a resource in a kora result by removing all the fields except,
     * kid, permission, type, title, thumb
     *
     * @param string $kid        kid you want to lock
     * @param array  $resources  kora results returned to lock on. (pass by reference)
     *
     */ 
    public static function lockResource($kid, &$resources) {
        if (isset($resources[$kid])) {
            $resources[$kid] = array(
                  "kid"         => isset($resources[$kid]['kid'])         ? $resources[$kid]['kid']         : "",
                  "Permissions" => isset($resources[$kid]['Permissions']) ? $resources[$kid]['Permissions'] : "",
                  "Type"        => isset($resources[$kid]['Type'])        ? $resources[$kid]['Type']        : "",
                  "Title"       => isset($resources[$kid]['Title'])       ? $resources[$kid]['Title']       : "",
                  "thumb"       => isset($resources[$kid]['thumb'])       ? $resources[$kid]['thumb']       : "",
                  "Locked"      => true,
            );
        }
    }
    /**
     * Locks all resources by a given permission
     *
     * @param string $permission permission you want to lock
     * @param array  $resources  kora results returned to lock on. (modifies the original array / pass by reference)
     *
     */ 
    public static function lockResourcesByPermission($permission, &$resources){
        foreach($resources as $kid => $resource){
            if (isset($resource['Permissions']) && $resource['Permissions'] === $permission) {
                static::lockResource($kid, $resources); 
            }
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
     * The current sinlge-Resource viewer.
     *
     * @param string $id            resource kid
     * @param bool   $ignore_ctx    if true, the action will not redirect to the
     *                              collection view when the resource has a
     *                              non-null context attribute.
     */
    public function viewer($id, $page=0, $ignore_ctx=false) {

        $pid = hexdec( explode('-', $id)[0] );
        $pName = array_search($pid, $GLOBALS['PID_ARRAY']);

        //resource
        $sid = $GLOBALS['RESOURCE_SID_ARRAY'][strtolower($pName)];
        $query = "kid,=,".$id;
        $fields = array('ALL');
        $query_array = explode(",", $query);
        $kora = new General_Search($pid, $sid, $query_array[0], $query_array[1], $query_array[2], $fields);
        $resource = json_decode($kora->return_json(), true);
        $resource = $resource[$id];

        //grab all pages with the resource identifier
        $sid = $GLOBALS['PAGES_SID_ARRAY'][strtolower($pName)];
        $pageSid = $sid;
        $fields = array('ALL');
        $sort = array(array( 'field' => 'Scan Number', 'direction' => SORT_ASC));
        $kora = new Advanced_Search($pid, $sid, $fields, 0, 0, $sort);
        $kora->add_clause("Resource Associator", "=", $id);
        $pages = json_decode($kora->search(), true);

        // get the first entry in $pages
        $firstPage = array_values($pages)[0]['kid'];

        // Shifting to create thumbnails for every page
        $pageKids = array();
        foreach($pages as $page) {
            $pageKids[] = $page['kid'];
            $pages[$page['kid']]['thumbnail'] = $this->largeThumb($page['Image Upload']['localName']);
            $pages[$page['kid']]['thumb'] = KORA_FILES_URI.$pid."/".$sid."/".$pages[$page['kid']]['Image Upload']['localName'];
        }

        //survey
        $surveys = array();
        $seasonKID = '';
        $sid = $GLOBALS['SURVEY_SID_ARRAY'][strtolower($pName)];
        if(is_array($resource['Excavation - Survey Associator'])){
          foreach ($resource['Excavation - Survey Associator'] as $kid) {
              $query = "kid,=,".$kid;
              $fields = array('ALL');
              $query_array = explode(",", $query);
              $kora = new General_Search($pid, $sid, $query_array[0], $query_array[1], $query_array[2], $fields);
              $survey = json_decode($kora->return_json(), true);

              $survey = $survey[$kid];
              array_push($surveys, $survey);
              //If no seasons for a resource, use resource season associator
              if ($seasonKID == '') {
                 $seasonKID = $survey['Season Associator'][0];
              }
            }
          }

        //If no seasons for a resource, use resource season associator
        if ($seasonKID == '') {
            $seasonKID = $resource['Season Associator'][0];
        }

        // SOO - Subject of Observation
        $sid = $GLOBALS['SUBJECT_SID_ARRAY'][strtolower($pName)];
        $query = "Pages Associator,IN"; // use this particular resource identifier
        $fields = array('ALL');
        $query_array = explode(",", $query);
        $kora = new General_Search($pid, $sid, $query_array[0], $query_array[1], $pageKids, $fields);
        $subject = json_decode($kora->return_json(), true);

        //season
        $projectKid = '';
        $sid = $GLOBALS['SEASON_SID_ARRAY'][strtolower($pName)];
        $query = "kid,=,".$seasonKID;
        $fields = array('ALL');
        $query_array = explode(",", $query);
        $kora = new General_Search($pid, $sid, $query_array[0], $query_array[1], $query_array[2], $fields);
        $season = json_decode($kora->return_json(), true);
        $season = $season[$seasonKID];

        if ($projectKid == '') {
            $projectKid = $season['Project Associator'][0];
        }

        //project
        $sid = $GLOBALS['PROJECT_SID_ARRAY'][strtolower($pName)];
        $query = "kid,=,".$projectKid;
        $fields = array('ALL');
        $query_array = explode(",", $query);
        $kora = new General_Search($pid, $sid, $query_array[0], $query_array[1], $query_array[2], $fields);
        $project = json_decode($kora->return_json(), true);

        $project = $project[$projectKid];
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

        $collections = json_encode($this->Collection->find('all', array(
            'fields'    => array('DISTINCT collection_id', 'title', 'user_name'),
            'order'     => 'created DESC',
            'recursive' => -1
        )));


        //edit metadata stuffs
        $metadataedits = $this->getEditMetadata();

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
            'kora_url' => KORA_FILES_URI.$pid."/".$pageSid."/",
            //'kora_url' => KORA_FILES_URI.PID."/".PAGES_SID."/",
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

    //get all the edit metadata in the table.
    protected function getEditMetadata(){
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
        $metadataedits = [];
        while($row = mysqli_fetch_assoc($result)) {

            //update and existing array.
            if( array_key_exists($row['metadata_kid'], $metadataedits) ){
                $valueArray = $metadataedits[$row['metadata_kid']];
                $valueArray[] = $row['field_name'];
                $metadataedits[$row['metadata_kid']] = $valueArray;

            }else{//create new array.
                $metadataedits[$row['metadata_kid']] = array($row['field_name']);
            }

        }
        return $metadataedits;
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
     * Return Page info based on page kid*
     * @param string $id = page kid
     */
    public function loadNewResource($id) {
        $this->autoRender = false;

        $pid = hexdec( explode('-', $id)[0] );
        $pName = array_search($pid, $GLOBALS['PID_ARRAY']);
        $sid = $GLOBALS['PAGES_SID_ARRAY'][strtolower($pName)];

        $fields = array('ALL');
        $kora = new General_Search($pid, $sid, 'kid', '=', $id, $fields);
        $page = json_decode($kora->return_json(), true);
        $page = $page[$id];
        $page['kora_url'] = KORA_FILES_URI.$pid."/".$sid."/";

		return json_encode($page);
    }

    /**
     * View a resource
     * Josh- I'm not really sure what this is for... It isn't single resource.
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

    //create a file to be exported.
    public function createExportFile(){
        # create new zip opbject
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        $zip = new ZipArchive();

        # create a temp file & open it
        $tmp_file = tempnam('.','Resouce_Data_');
        $zip->open($tmp_file.'.zip', ZipArchive::CREATE);

        $count = 0;
        $xmlNames = ['Project_data.xml', 'Season_data.xml', 'Excavation_Survey_data.xml', 'Resource_data.xml',
            'Pages_data.xml', 'Subject_Of_Observation_data.xml'];
        foreach (json_decode($this->request->data['xmls']) as $xml) {
            $zip->addFromString($xmlNames[$count], $xml);
            $count++;
        }
        if( isset($this->request->data['picUrls']) ){

            foreach(json_decode($this->request->data['picUrls']) as $url){
                # download file
                $pid = hexdec( explode('-', $url)[0] );
                $pName = array_search($pid, $GLOBALS['PID_ARRAY']);
                $sid = $GLOBALS['PAGES_SID_ARRAY'][strtolower($pName)];

                $string = KORA_FILES_URI.$pid.'/'.$sid.'/'.$url;
                $download_file = @file_get_contents( $string );
                $zip->addFromString('images/'.basename($url),$download_file);
            }
        }
        $zip->close();
		echo $tmp_file;
		die;
    }

    //download the created export file and delete it
	public function downloadExportFile(){
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.'Resource_Data.zip'.'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($this->request->data['filename'].'.zip'));
		readfile($this->request->data['filename'].'.zip');

        unlink($this->request->data['filename'].'.zip');
        unlink($this->request->data['filename']);
		die;
	}

    /*
     * check for when the export file is done downloading
     * This code will only run after the download either finished or crashed
     * delete the files if download crashed.
     */
    public function checkExportDone(){
        if(file_exists($this->request->data['filename'].'.zip')){
            unlink($this->request->data['filename'].'.zip');
        }
        if(file_exists($this->request->data['filename'])){
            unlink($this->request->data['filename']);
        }
        die;
    }

    public function viewtype($projectName){

      if(isset($this->request->data['resource_kids'])){
        $json =  $this->request->data['resource_kids'];
        $rKids = json_decode($json);
        $search = new Resource_Search($rKids, $projectName);
        $results = $search->getResultsAsArray();
        echo "<script>var results_to_display = ".json_encode($results).";</script>";
      }
      else if(isset($this->request->data['orphaned_kids'])){
        $pKids = $this->request->data['orphaned_kids'];
      }else{
          $this->Collection->recursive = -1;
          $user_id =  $this->Session->read('Auth.User.id');
          $collections = '';
          if( $user_id !== null ) { //signed in
              $collections = $this->Collection->find('all', array(
                  'order' => 'Collection.modified DESC',
                  'conditions' => array('OR' => array(
                      array( 'Collection.public' => '1'),
                      array( 'Collection.public' => '2'),
                      array( 'Collection.public' => '3'),
                      array( 'Collection.user_id' => $user_id)
                  ),'Collection.collection_id' => $projectName)
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
                      'Collection.collection_id' => $projectName
                  )//,  //only get public collections
                  //'group' => 'collection_id'
              ));
          }
          $resourceKids = array();
          foreach( $collections as $temp ){ //only keep the resource_kids.
              $resourceKids[] = $temp['Collection']['resource_kid'];
          }
          $pid = hexdec( explode('-', $resourceKids[0])[0] );
          $pName = array_search($pid, $GLOBALS['PID_ARRAY']);

          $search = new Resource_Search($resourceKids, $pName);
          $results = $search->getResultsAsArray();
          echo "<script>var results_to_display = ".json_encode($results)."</script>";
          $this->set("projectName", $pName);
      }
      $this->render("../Search/search");
    }

    //view muitiple resources in a viewer
    public function multi_viewer($id=''){
		
	
        $resources = array();
        $projectsArray = array();
        $seasons = array();
        $excavations = array();
        $subjects = array();
        $resources_array = array();
        if($this->request->method() === "POST" && isset($this->request->data['pageSet'])){
            $pageIndex = $this->request->data['pageSet'];
            $this->set("pageSet", $pageIndex);
            $resources_array = array( $id );
        }elseif($this->request->method() === "POST" && isset($this->request->data['resources'])){
            $post_data = $this->request->data;
            $resources_array = json_decode($post_data["resources"]);
        }elseif($this->request->method() === "GET"){
            if($id == '' ){
                throw new NotFoundException();
            }
            $resources_array = array( $id );
        }else{
            //Not a post or get method
            throw new NotFoundException();
        }
        foreach($resources_array as $resource){

            //get resource information
            $info_array = $this->getResource($resource);
            //$identifier = $info_array[$resource]['Resource Identifier'];

			if( $info_array[$resource]["Excavation - Survey Associator"] != '') {
                $exc_kids = $this->getFromKey($info_array, "Excavation - Survey Associator");

                //get Season data
                $excavation_array = $this->getExcavation($exc_kids);
                $this->pushToArray($excavation_array, $excavations);

                $season_kids = $this->getFromKey($excavation_array, "Season Associator");

            }else{
                $season_kids = $this->getFromKey($info_array, "Season Associator");
            }

            //get Season data
            $season_array = $this->getSeason($season_kids);
            $this->pushToArray($season_array, $seasons);

            $project_kid = $this->getFromKey($season_array,"Project Associator")[0];
            $info_array[$resource]['project_kid'] = $project_kid;

            //get project array
            $project_array = $this->getProject($project_kid);
            $this->pushToArray($project_array, $projectsArray);

            //get pages and add to resource array
            $page = $this->getPages($resource);
            $pageKids = array_keys($page);
            //var_dump($page);
            //$page[] = $project_kid;

            $info_array[$resource]["page"] =  $page;

            //get SOO
            if( !empty($pageKids) ){
                $soo = $this->getSubjectOfObservation($pageKids);
            }else{
                $soo = array();
            }
            $this->pushToArray($soo, $subjects);

            //push to array
            $this->pushToArray($info_array, $resources);

        }
		if( !isset($this->request->query['ajax'] )){
			$metadataedits = $this->getEditMetadata();

			$this->set("resources", $resources);
			$this->set("projectsArray", $projectsArray);
			ksort($seasons);
			$this->set("seasons", $seasons);
			ksort($excavations);
			$this->set("excavations", $excavations);
			$this->set("subjects", $subjects);
			$this->set("metadataEdits", $metadataedits);
		}else{
			echo json_encode([$projectsArray, 
								$seasons,
								$excavations,
								$resources,
								$subjects]);
			die;
		}

    }
    protected function pushToArray($value, &$array){
        foreach($value as $key => $v){
            if(!isset($array[$key]) && !empty($key)){
                $array[$key] = $value[$key];
            }
        }

    }
    protected function getFromKey($array, $key){
      return array_values($array)[0][$key];
    }
    protected function getProject($kid){
	  $pid = hexdec( explode('-', $kid)[0] );
	  $pName = array_search($pid, $GLOBALS['PID_ARRAY']);
	  $sid = parent::getProjectSIDFromProjectName($pName);
      $query_array = array("kid","=",$kid);
      $fields = "ALL";
      $result = new General_Search($pid, $sid, $query_array[0], $query_array[1], $query_array[2], $fields);
      return $result->return_array();
    }
    protected function getSeason($kids){
      $pid = hexdec( explode('-', $kids[0])[0] );
	  $pName = array_search($pid, $GLOBALS['PID_ARRAY']);
	  $sid = parent::getSeasonSIDFromProjectName($pName);
      $query_array = array("kid","IN",$kids);
      $fields = "ALL";
      $result = new General_Search($pid, $sid, $query_array[0], $query_array[1], $query_array[2], $fields);
      return $result->return_array();
    }
    protected function getExcavation($kids){
      $pid = hexdec( explode('-', $kids[0])[0] );
	  $pName = array_search($pid, $GLOBALS['PID_ARRAY']);
	  $sid = parent::getSurveySIDProjectName($pName);
      $query_array = array("kid","IN",$kids);
      $fields = "ALL";
      $result = new General_Search($pid, $sid, $query_array[0], $query_array[1], $query_array[2], $fields);
      return $result->return_array();
    }
    protected function getResource($kid){
      $pid = hexdec( explode('-', $kid)[0] );
	  $pName = array_search($pid, $GLOBALS['PID_ARRAY']);
	  $sid = parent::getResourceSIDFromProjectName($pName);
      $query_array = array("kid","=",$kid);
      $fields = "ALL";
      $result = new General_Search($pid, $sid, $query_array[0], $query_array[1], $query_array[2], $fields);
      return $result->return_array();
    }
    protected function getPages($resource_kid){
      //grab all pages with the resource associator
	  $pid = hexdec( explode('-', $resource_kid)[0] );
	  $pName = array_search($pid, $GLOBALS['PID_ARRAY']);
	  $sid = parent::getPageSIDFromProjectName($pName);
      $fields = array('ALL');
      $sort = array(array( 'field' => 'Scan Number', 'direction' => SORT_ASC));
      $kora = new Advanced_Search($pid, $sid, $fields, 0, 0, $sort);
      $kora->add_clause("Resource Associator", "=", $resource_kid);
      return json_decode($kora->search(), true);
    }
    protected function getSubjectOfObservation($pageKids){
        $pid = hexdec(explode('-', $pageKids[0])[0]);
        $pName = array_search($pid, $GLOBALS['PID_ARRAY']);
        $sid = parent::getSubjectSIDFromProjectName($pName);
        $query_array = array("Pages Associator", "IN", $pageKids);
        $fields = "ALL";
        $result = new General_Search($pid, $sid, $query_array[0], $query_array[1], $query_array[2], $fields);
        return $result->return_array();
    }
}
