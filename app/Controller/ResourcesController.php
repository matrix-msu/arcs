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

 require_once(KORA_LIB . "Advanced_Search.php");
 require_once(KORA_LIB . "Resource.php");
 require_once(KORA_LIB . "Resource_Search.php");
 require_once(KORA_LIB . "../Class/Benchmark.php");
 require_once(KORA_LIB . "Kora.php");

 use mb\Benchmark;
 use Lib\Kora;
 use Lib\Resource;

App::import('Controller', 'Users');

// Enum class for Permissions
abstract class Permissions {
    const R_Public  = "Public";
    const R_Member  = "Member";
    const R_Special = "Special";
}


class ResourcesController extends AppController {
    public $name = 'Resources';
    public $uses = array('Resource', 'Collection', 'MetadataEdit', 'User', 'Flag', 'Mapping');

    public function beforeFilter() {
        # The App Controller will set some common view variables (namely a
        # user array), so the parent's beforeFilter is run in this and most
        # other controllers.
        parent::beforeFilter();
        # Read-only actions, such as viewing resources and associated comments
        # are allowed by default.
        $this->Auth->allow(
            'view', 'viewer', 'multi_viewer', 'search', 'comments', 'annotations',
            'keywords', 'complete', 'zipped', 'download','checkExportDone', "loadNewResource",
            'createExportFile', 'downloadExportFile', 'viewtype', 'viewKid', 'viewcollection',
            'getMetadataEditsControlOptions'
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

        } else if (is_array($resources)) {

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
                $fields = array('Special_User', 'Permissions', 'Type','Title');
                $kora = new Advanced_Search($pid, $sid, $fields);
                $kora->add_clause("kid", "IN", $KIDs);
                $res = json_decode($kora->search(), true);
                foreach($res as $kid => $resource) {
                    // Permissions is Special User, but the user is not on
                    // the special user list
                    if (
                        isset($resource['Permissions']) &&
                        $resource['Permissions'] === Permissions::R_Special &&
                        !static::isSpecial($resource['Special_User'], $userName)
                      ) {
                        static::lockResource($kid, $resources);
                      }
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
                return true;
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
     * Return resource info from kid.
     *
     * @param string $id    resource kid
     */
    public function viewKid($kid=null) {
        if (!$this->request->is('get')) throw new MethodNotAllowedException();
        $resource['thumb'] = Router::url('/', true)."img/DefaultResourceImage.svg";
        if ($kid == "null") {
            $resource['Title'] = 'Unknown Title';
            $resource['Type'] = 'Unknown Type';
        }else{
            $resource = $this->getResource($kid)[$kid];
            $pages = $this->getPages($kid);
            $page1 = reset($pages);
            if (!empty($page1['Image_Upload']['localName'])) {
                $resource['thumb'] = $this->smallThumb($page1['Image_Upload']['localName']);
            }
        }
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
        $sql = $mysqli->prepare("SELECT metadata_kid, field_name FROM arcs_dev.metadata_edits WHERE rejected = 0 AND approved = 0");
        $sql->execute();
        $result = $sql->get_result();
        // $result = $mysqli->query($sql);
        $metadataedits = [];
        while($row = mysqli_fetch_assoc($result)) {

            //update an existing array.
            if( array_key_exists($row['metadata_kid'], $metadataedits) ){
                $valueArray = $metadataedits[$row['metadata_kid']];
                $valueArray[] = $row['field_name'];
                $metadataedits[$row['metadata_kid']] = $valueArray;

            }else{//create new array.
                $metadataedits[$row['metadata_kid']] = array($row['field_name']);
            }
        }
        //print_r($metadataedits);
        //die;
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

        $pName = parent::convertKIDtoProjectName($id);
        $pid = parent::getPIDFromProjectName($pName);
        $sid = parent::getPageSIDFromProjectName($pName);

        $fields = 'ALL';
        $kora = new General_Search($pid, $sid, 'kid', '=', $id, $fields);
        $page = json_decode($kora->return_json(), true);

        $page = $page[$id];
        $page['kora_url'] = KORA_FILES_URI.$pid."/".$sid."/";

		return json_encode($page);
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
                $pName = parent::convertKIDtoProjectName($url);
                $pid = parent::getPIDFromProjectName($pName);
                $sid = parent::getPageSIDFromProjectName($pName);

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

    //collections show all button.. get all and send to search
    public function viewcollection($collection_id){

        $username = NULL;
        $usersC = new UsersController();
        if ($user = $usersC->getUser($this->Auth)) {
            $username = $user['User']['username'];
        }

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
                ),'Collection.collection_id' => $collection_id)
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
        } else { //not signed in
            $collections = $this->Collection->find('all', array(
                'order' => 'Collection.modified DESC',
                'conditions' => array(
                    'Collection.public' => '1',
                    'Collection.collection_id' => $collection_id
                )//,  //only get public collections
                //'group' => 'collection_id'
            ));
        }
        $resourceKids = array();
        foreach( $collections as $temp ){ //only keep the resource_kids.
            $resourceKids[] = $temp['Collection']['resource_kid'];
        }
        if (count($resourceKids) == 0) {// If no project, throw exception to give error page without showing users the php errors
            $resourceKids[0] = 'explode';
        }
        $pName = parent::convertKIDtoProjectName($resourceKids[0]);

        $search = new Resource_Search($resourceKids, $pName);
        $results = $search->getResultsAsArray();
        static::filterByPermission($username, $results['results']);
        echo "<script>var results_to_display = ".json_encode($results)."</script>";
        $this->set("projectName", $pName);
        $this->render("../Search/search");
    }

    public function viewtype($projectName, $resource_type){
        $resource_type = ucfirst(strtolower($resource_type));
        $resource_type = str_replace('_', ' ', $resource_type);

        $username = NULL;
        $usersC = new UsersController();
        if ($user = $usersC->getUser($this->Auth)) {
            $username = $user['User']['username'];
        }

        if( $resource_type != 'Orphaned' ) {
            $pid = parent::getPIDFromProjectName($projectName);
            $sid = parent::getResourceSIDFromProjectName($projectName);
            $pageSid = parent::getPageSIDFromProjectName($projectName);

            //get resources
            $search = new General_Search($pid, $sid, 'Type', '=', $resource_type,['Type','Resource_Identifier', 'Permissions']);
            $results = $search->return_array();
            $rKids = array_keys($results);

            //get indicators
            $indicators = Resource::flag_analysis($results);

            //get pages
            $fields = array('Image_Upload','Resource_Associator','Scan_Number');
            $kora = new Advanced_Search($pid, $pageSid, $fields);
            if( $resource_type == 'Field_journal' ) {//kora 3 todo do types get an underscore??
                $kora->add_double_clause("Resource_Associator", "IN", $rKids,
                    "Scan_Number", "=", "1");
            }else {
                $kora->add_clause("Resource_Associator", "IN", $rKids);
            }
            $allPages = json_decode($kora->search(), true);

            //link in the pages to the resources
            foreach( $allPages as $page ){
                $resourceAssociator = $page['Resource_Associator'][0];
                $thumb = $page['Image_Upload']['localName'];
                $results[$resourceAssociator]['thumb'] = $this->smallThumb($thumb);
            }

            //take care of resources without pages and data formatting
            foreach( $results as $key => $v ){
                if( !isset($v['thumb']) ) {
                    $results[$key]['thumb'] = $this->smallThumb('');
                }
                $results[$key]['Title'] = $v['Resource_Identifier'];
            }

            $results = ['filters' => [], 'indicators' => $indicators, 'results' => $results, 'total'=>count($results)];
            static::filterByPermission($username, $results['results']);
            echo "<script>var results_to_display = " . json_encode($results) . ";</script>";

        }elseif( $resource_type == 'Orphaned' ) {
            $pid = parent::getPIDFromProjectName($projectName);
            $sid = parent::getPageSIDFromProjectName($projectName);
            $pages = new General_Search($pid, $sid, 'Orphan', '=', 'TRUE', 'ALL');
            $pages = $pages->return_array();
            $results = ['filters' => [], 'indicators' => [], 'results' => $pages];
            //static::filterByPermission($username, $results['results']);
            foreach ($results['results'] as $key => $value) {
                $results['results'][$key]['Title'] = $value['Page_Identifier'];
                $results['results'][$key]['orphan'] = true;
                if (is_array($value['Image_Upload'])) {
                    $results['results'][$key]['thumb'] = $this->smallThumb($value['Image_Upload']['localName']);
                }
                $results['indicators'][$key] = array(
                  "hasFlags"=>false,
                  "hasAnnotations"=>false,
                  "hasCollections"=>false,
                  "hasComments"=>false,
                  "hasKeywords"=>false
                );
            }
            echo "<script>var results_to_display = ".json_encode($results).";</script>";
        }
        $this->render("../Search/search");
    }

    // view multiple resources in a viewer
    public function multi_viewer($id='') {
        $pName = NULL;
        $resources = array();
        $projectsArray = array();
        $seasons = array();
        $excavations = array();
        $subjects = array();
        $resources_array = array();
        $showButNoEditArray = array();

        if($this->request->method() === "POST" && isset($this->request->data['resources'])){
            $post_data = $this->request->data;
            //create a new session variable and forward to a get request
            //the array index is used as a new url
            $_SESSION['multi_viewer_resources'][] = json_decode($post_data["resources"]);
            end($_SESSION['multi_viewer_resources']);
            $key = key($_SESSION['multi_viewer_resources']);
            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]$key";
            header("Location:".$actual_link);
            die();
        }elseif($this->request->method() === "GET"){
            if( $id == '' ){
                throw new NotFoundException();
            }
            //check first if this is a multi-resource session url
            $id = (string)$id;
            if( isset($_SESSION['multi_viewer_resources']) ) {
                foreach ($_SESSION['multi_viewer_resources'] as $key => $rKids) {
                    if ($id === (string)$key) {
                        $resources_array = $_SESSION['multi_viewer_resources'][$key];
                        $_SESSION['multi_viewer_resources'][$key] = $resources_array;//refresh the session
                        break;
                    }
                }
            }
            if (isset($this->request->query['pageSet']) && !empty($this->request->query['pageSet'])) {
                $pageIndex = $this->request->query['pageSet'];
                $this->set("pageSet", $pageIndex);
            }
            if( count($resources_array) < 1 ) {
                $resources_array = array($id);
            }
            if( count($resources_array) == 0 ) {
                throw new NotFoundException();
            }
        }else{
            //Not a post or get method
            throw new NotFoundException();
        }

        $username = NULL;
        $usersC = new UsersController();
        if ($user = $usersC->getUser($this->Auth)) {
            $username = $user['User']['username'];
        }

        $isSignedIn = ( $user == false )? false : true;

        //grab all the projects a user has permissions for--
        $mappings = $this->Mapping->find('all', array(
            'fields' => array('Mapping.role', 'Mapping.pid', 'Mapping.id_user', 'Mapping.status'),
            'conditions' => array(
                'AND' => array('Mapping.id_user' => $user['User']['id'], 'Mapping.status' => 'confirmed'),
            )
        ));
        $projectPermissionArray = array();
        foreach( $mappings as $mapping ){
            array_push($projectPermissionArray, $mapping['Mapping']['pid']);
        }

        $hasARealResource = false;

        foreach($resources_array as $resource){
            echo "2";
            //get resource information
            $info_array = $this->getResource($resource);

            if( empty($info_array) ){ //check if a real resource
                continue;
            }
            $hasARealResource = true;

            //check the resource for project permissions
            if( array_search($info_array[$resource]['pid'], $projectPermissionArray) === false ){
                $hasProjectPermission = false;
            }else{
                $hasProjectPermission = true;
            }

            $isPublicResource = ( $info_array[$resource]['Permissions'] == 'Public' )? true:false;

            static::filterByPermission($username, $info_array);
            $permission = array_values($info_array)[0];

            //filter by project permissions
            if( $hasProjectPermission ) {
                if( $isPublicResource ){ //public resources are allowed
                    if( !$isSignedIn ){ //can only edit if signed in
                        array_push( $showButNoEditArray, $resource );
                    }
                }else{ //not a public resource so check resource permissions
                    if (isset($permission['Locked']) && (bool)$permission['Locked']) { //no show, resouce modal
                        continue;
                    }
                }
            }else{
                if( $isPublicResource ){ //no project and public means show no edit
                    array_push( $showButNoEditArray, $resource );
                }else{ //no project and not public means no show, project modal
                    continue;
                }
            }

            if( $info_array[$resource]["Excavation_-_Survey_Associator"] != '') {
                $exc_kids = $this->getFromKey($info_array, "Excavation_-_Survey_Associator");

                //get Season data
                $excavation_array = $this->getExcavation($exc_kids);
                $this->pushToArray($excavation_array, $excavations);

                $season_kids = $this->getFromKey($excavation_array, "Season_Associator");

            }else{
                $season_kids = $this->getFromKey($info_array, "Season_Associator");
            }

            //get Season data
            $season_array = $this->getSeason($season_kids);
            $this->pushToArray($season_array, $seasons);

            $project_kid = $this->getFromKey($season_array,"Project_Associator")[0];
            $info_array[$resource]['project_kid'] = $project_kid;
            $pName = parent::convertKIDtoProjectName($project_kid);

            //get project array
            $project_array = $this->getProject($project_kid);
            $this->pushToArray($project_array, $projectsArray);

            //get pages and add to resource array
            $page = $this->getPages($resource);
            $pageKids = array_keys($page);

            if(empty($page)) {
                // creates a hacky solution to display a default page
                // when there are no pages associated with the resource
                // missing a lot of other information typically associated with a page
                $page["DefaultPage"] = array();
            }

            $info_array[$resource]["page"] = $page;

            //get SOO
            if( !empty($pageKids) ){
                $soo = $this->getSubjectOfObservation($pageKids);
            }else{
                $soo = array();
            }
            $this->pushToArray($soo, $subjects);

            //push to array
            $this->pushToArray($info_array, $resources);

            if (!isset($_GET['getRest'])) {
                $temp = count($resources_array) > 1 ? $id : 'false';
                $this->set("multiInfo", $temp);
                break;
            }
        }

        if( !$hasARealResource ){
            $this->set("notAResource", true);
        }
        if ( empty($resources) ) {
            $this->set("resourceAccess", false);
        }
        if( !isset($this->request->query['ajax'] ) && !isset($_GET['getRest'])){ //this is for a normal multi_view
            $metadataedits = $this->getEditMetadata();
            if($pName != '') {
                $metadataeditsControlOptions = $this->getMetadataEditsControlOptions($pName);
            }else{
                $metadataeditsControlOptions = array();
            }
            $flags = $this->getFlags($resources_array);
            $this->set("resources", $resources);
            $this->set("projectsArray", $projectsArray);
            ksort($seasons);
            $this->set("seasons", $seasons);
            ksort($excavations);
            $this->set("excavations", $excavations);
            $this->set("subjects", $subjects);
            $this->set("metadataEdits", $metadataedits);
            $this->set("metadataEditsControlOptions", $metadataeditsControlOptions);
            $this->set("flags", $flags);
            $this->set("showButNoEditArray", $showButNoEditArray);
        }
        else if (isset($_GET['getRest'])) {
            $metadataedits = $this->getEditMetadata();
            if($pName != '') {
                $metadataeditsControlOptions = $this->getMetadataEditsControlOptions($pName);
            }else{
                $metadataeditsControlOptions = array();
            }
            $flags = $this->getFlags($resources_array);
            ksort($seasons);
            ksort($excavations);
            foreach ($resources as $kid => $r) {
                $p = $r['page'];
                $p = isset(array_values($p)[0]['Image_Upload']['localName'])? array_values($p)[0]['Image_Upload']['localName'] : "";
                $p = AppController::smallThumb($p);
                $resources[$kid]['thumbsrc'] = $p;
                foreach ($r['page'] as $key => $page) {
                    $img = isset($page['Image_Upload']['localName']) ? $page['Image_Upload']['localName'] : "";
                    $resources[$kid]['page'][$key]['thumbsrc'] = AppController::smallThumb($img);
                }
            }
            echo json_encode(['resources' => $resources,
                                'projectsArray' => $projectsArray,
                                'seasons' => $seasons,
                                'excavations' => $excavations,
                                'subjects' => $subjects,
                                'metadataedits' => $metadataedits,
                                'metadataeditsControlOptions' => $metadataeditsControlOptions,
                                'flags' => $flags,
                                'showButNoEditArray' => $showButNoEditArray]);
            die;
        }
        else {  //this is for getting the data for a export data
            echo json_encode([$projectsArray,
                                $seasons,
                                $excavations,
                                $resources,
                                $subjects]);
            die;
        }
    }

    //grab all flags that apply to the resources being shown
    public function getFlags($resources_array){
        $flags = $this->Flag->find('all', array(
            'conditions' => array('resource_kid'=>$resources_array)
        ));
        $metadataFlags = array();
        $annotationFlags = array();

        foreach($flags as $flag){
            $target = $flag['Flag']['annotation_target'];
            if( $target == 'Metadata' ){
                if( isset($metadataFlags[$flag['Flag']['metadata_kid']]) ){
                    array_push($metadataFlags[$flag['Flag']['metadata_kid']], $flag['Flag']['metadata_field']);
                }else{
                    $metadataFlags[$flag['Flag']['metadata_kid']] = array($flag['Flag']['metadata_field']);
                }

            }else{
                array_push($annotationFlags, $flag['Flag']['annotation_id']);
            }
        }

        return array(
            'metadataFlags'=>$metadataFlags,
            'annotationFlags' => $annotationFlags
        );
    }

    /**
     * Get all the control options for metadataEdits
     *
     */
    public function getMetadataEditsControlOptions($project = null){
        $ajax = false;
        if( isset($this->request->data) && isset($this->request->data['project']) ){
            $project = $this->request->data['project'];
            $project = strtolower($project);
            $project = str_replace(' ', '_', $project);
            $ajax = true;
        }
        // check bootstrap configuration
        try {
            parent::getPIDFromProjectName($project);
        } catch (Exception $e) {
            //throw new NotFoundException("Project \"$project\" was not found!");
        }
        $pid = parent::getPIDFromProjectName($project);

        $sid = parent::getProjectSIDFromProjectName($project);
        $query = "name = 'Country' OR
                  name = 'Region' OR
                  name = 'Modern Name' OR
                  name = 'Records Archive' OR
                  name = 'Period' OR
                  name = 'Archaeological Culture' OR
                  name = 'Permitting Heritage Body'";
        $pCid = $this->getControls($pid, $sid, $query);

        $sid = parent::getSeasonSIDFromProjectName($project);
        $query = "name = 'Type' OR
                  name = 'Director' OR
                  name = 'Registrar' OR
                  name = 'Sponsor' OR
                  name = 'Contributor' OR
                  name = 'Contributor Role'";
        $sCid = $this->getControls($pid, $sid, $query);

        $sid = parent::getSurveySIDProjectName($project);
        $query = "name = 'Type' OR
                  name = 'Supervisor'";
        $eCid = $this->getControls($pid, $sid, $query);

        $sid = parent::getResourceSIDFromProjectName($project);
        $query = "name = 'Type' OR
                  name = 'Creator' OR
                  name = 'Creator Role' OR
                  name = 'Condition' OR
                  name = 'Access Level' OR
                  name = 'Language'";
        $rCid = $this->getControls($pid, $sid, $query);
//structure subject, culture
        $sid = parent::getSubjectSIDFromProjectName($project);
        $query = "name = 'Artifact - Structure Classification' OR
                  name = 'Artifact - Structure Type' OR
                  name = 'Artifact - Structure Excavation Unit' OR
                  name = 'Artifact - Structure Location' OR
                  name = 'Artifact - Structure Material' OR
                  name = 'Artifact - Structure Technique' OR
                  name = 'Artifact - Structure Archaeological Culture' OR
                  name = 'Artifact - Structure Period' OR
                  name = 'Artifact - Structure Creator' OR
                  name = 'Artifact - Structure Condition' OR
                  name = 'Artifact - Structure Subject'";
        $sooCid = $this->getControls($pid, $sid, $query);

        $return = array(
            'project' => $this->htmlifyControls($pCid),
            'Seasons' => $this->htmlifyControls($sCid),
            'excavations' => $this->htmlifyControls($eCid),
            'archival objects' => $this->htmlifyControls($rCid),
            'subjects' => $this->htmlifyControls($sooCid)
        );
        if( $ajax ){
            echo json_encode($return);
            die;
        }else{
            return $return;
        }
    }
    private function htmlifyControls($controlArray){

        foreach($controlArray as $control => $optionsArray){
            $optionsString = '';
            foreach($optionsArray as $option){
                $optionsString .= '<option value=&quot;'. $option. '&quot;>'. $option. '</option>';
            }
            $controlArray[$control] = $optionsString;
        }
        return $controlArray;
    }
    private function getControls($pid,$sid,$query) {
        // require symlink to the kora db
        $kora = new Kora();

        global $db;
        $controls = array();

        $object = $db->query("SELECT * FROM p$pid" .
            "Control WHERE schemeid = '$sid' " . "AND ($query)");
        if (!$object){
            return array();
        }
        while ($res = $object->fetch_assoc()) {
            $cid = $res["cid"];
            $list = new ListControl($pid, $cid);
            $settings = $list->GetControlOptions();
            $controls[$res['name']] =   (array)$settings->option;
        }
        if( $sid == '739'){
            //echo json_encode($controls);
            //die;
        }
        return $controls;
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
        $pName = parent::convertKIDtoProjectName($kid);
        $pid = parent::getPIDFromProjectName($pName);
        $sid = parent::getProjectSIDFromProjectName($pName);
        $query_array = array("kid","=",$kid);
        $fields = "ALL";
        $result = new General_Search($pid, $sid, $query_array[0], $query_array[1], $query_array[2], $fields);
        return $result->return_array();
    }
    protected function getSeason($kids){
        $pName = parent::convertKIDtoProjectName($kids[0]);
        $pid = parent::getPIDFromProjectName($pName);
        $sid = parent::getSeasonSIDFromProjectName($pName);
        $query_array = array("kid","IN",$kids);
        $fields = "ALL";
        $result = new General_Search($pid, $sid, $query_array[0], $query_array[1], $query_array[2], $fields);
        return $result->return_array();
    }
    protected function getExcavation($kids){
        $pName = parent::convertKIDtoProjectName($kids[0]);
        $pid = parent::getPIDFromProjectName($pName);
        $sid = parent::getSurveySIDProjectName($pName);
        $query_array = array("kid","IN",$kids);
        $fields = "ALL";
        $result = new General_Search($pid, $sid, $query_array[0], $query_array[1], $query_array[2], $fields);
        return $result->return_array();
    }
    protected function getResource($kid){
        $pName = parent::convertKIDtoProjectName($kid);
        $pid = parent::getPIDFromProjectName($pName);
        $sid = parent::getResourceSIDFromProjectName($pName);
        $query_array = array("kid","=",$kid);
        $fields = "ALL";
        $result = new General_Search($pid, $sid, $query_array[0], $query_array[1], $query_array[2], $fields);
        return $result->return_array();
    }
    protected function getPages($resource_kid){
        //grab all pages with the resource associator
        $pName = parent::convertKIDtoProjectName($resource_kid);
        $pid = parent::getPIDFromProjectName($pName);
        $sid = parent::getPageSIDFromProjectName($pName);
        $fields = 'ALL';
        $sort = array(array( 'field' => 'Scan_Number', 'direction' => SORT_ASC));
        $kora = new Advanced_Search($pid, $sid, $fields, 0, 0, $sort);
        $kora->add_clause("Resource_Associator", "=", $resource_kid);
        return json_decode($kora->search(), true);
    }
    protected function getSubjectOfObservation($pageKids){
        $pName = parent::convertKIDtoProjectName($pageKids[0]);
        $pid = parent::getPIDFromProjectName($pName);
        $sid = parent::getSubjectSIDFromProjectName($pName);
        $query_array = array("Pages_Associator", "IN", $pageKids);
        $fields = "ALL";
        $result = new General_Search($pid, $sid, $query_array[0], $query_array[1], $query_array[2], $fields);
        return $result->return_array();
    }

    public function findUnassociatedResources(){
        $pName = 'isthmia';
        $pid = parent::getPIDFromProjectName($pName);
        $sid = parent::getResourceSIDFromProjectName($pName);
        $query_array = array("kid","!=",'');
        $fields = "Title";
        $result = new General_Search($pid, $sid, $query_array[0], $query_array[1], $query_array[2], $fields);
        $resourcesWithNoPage = array();
        foreach( $result->return_array() as $resource ){
            if( empty($resource['linkers']) ){
                array_push($resourcesWithNoPage, $resource['kid']);
            }
        }
        echo json_encode( $resourcesWithNoPage );
        die;
    }
}
