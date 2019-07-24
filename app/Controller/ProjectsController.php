
<?php
/**
 * Projects Controller
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
 require_once(KORA_LIB . "Project.php");
 require_once(KORA_LIB . "General_Search.php");
 require_once(KORA_LIB . "Advanced_Search.php");

 use Lib\Kora\Project;

App::import('Controller', 'Users');
App::import('Controller', 'Resources');
App::import('Controller', 'Collections');

class ProjectsController extends AppController {
    public $name = 'Projects';
    public $uses = array('Mapping', 'Collection', 'User');


	public function beforeFilter() {

      parent::beforeFilter();
      $this->Auth->allow("index", 'display', 'search',"single_project", "special_login");
  		$this->set(array(
  		'toolbar' => true,
          'footer' => false
  		));

  }



    public function getUser() {
    $user = array();
    $user = [];
    $user["loggedIn"] = $this->Session->read('Auth.User.name');
    $user["isAnyAdmin"] = $this->checkIfAnyAdmin($this->Session->read('Auth.User.id'));
    $user["name"] = $this->Session->read('Auth.User.name');
    $user["username"] = $this->Session->read('Auth.User.username');
    if( $this->Session->read('Auth.User.isAdmin') === 1 ){
      $user["role"] = 'Admin';
    } else {
      $user["role"] = 'Not';
    }
//    json_encode($user);
//    die;
    return $user;
    }
    public function checkIfAnyAdmin($id){
        $mappings = $this->Mapping->find('all', array(
            'conditions' => array(
                'AND' => array(
                    'Mapping.id_user' => $id,
                    'Mapping.status' => 'confirmed',
                    'Mapping.role' => 'Admin'
                ),
            )
        ));
//        var_dump($mappings);
//        die;
        if( !empty($mappings) ){
            return true;
        }else{
            return false;
        }

    }


	public function getProjects() {

        $projectstemp = array();
        foreach( parent::getPIDArray() as $name => $pid ) {
            $fields = array('Geolocation', "Persistent_Name", "Description", "Name", 'Country');
            $projectSid = parent::getProjectSIDFromProjectName($name);
            $kora = new General_Search($pid, $projectSid, 'kid', '!=', '    ', $fields);
            $projectstemp[] = json_decode($kora->return_json(), true);
        }

        $projects = array();

        foreach($projectstemp as $value){
            $projects[] = reset($value);
        }
		$this->set('projects', $projects);

	}
  public function index() {


    $this->getProjects();

    $user = $this->getUser();
    $this->set("user", $user);
    $this->render("index");
  }
	/**
     * Displays a view
     *
     * @param mixed What page to display
     * @return void
     */
	public function display() {

        // intialize kora session
        $kora = new \Lib\Kora();

		$path = func_get_args();
		$this->getProjects();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
        if ($title_for_layout == 'About') {
            $this->set('toolbar', false);
        }
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		$this->render(implode('/', $path));
	}

	public function single_project($proj) {
        $pid = static::getPIDFromProjectName($proj);
        $sid = static::getResourceSIDFromProjectName($proj);
        $fields = array("Title", "Type","Resource_Identifier", "Permissions", "Special_User");
        $sort = array(array( 'field' => 'systimestamp', 'direction' => SORT_DESC));
        // TODO: make this work
        $sort = array();    //Use this to turn off the sorting
        $kora = new Advanced_Search($pid, $sid, $fields, 0, 8, $sort);
        $kora->add_clause("kid", "!=", '');
        $server_output = json_decode($kora->search(), true);
        // echo "srever out";
        // echo json_encode($server_output);
        // die;

        $fields = 'KID';
        $kora = new General_Search($pid, $sid, 'kid', '!=', '', $fields);
        $projectResourceKids = $kora->return_array();
        //all resource kids in the project. for collections


        $sid = static::getProjectSIDFromProjectName($proj);
        $fields = 'ALL';
        $kora = new General_Search($pid, $sid, 'kid', '!=', '', $fields);
        $project = json_decode($kora->return_json(), true);
        $project = array_values($project)[0];


        $this->set("name",$project['Name']);
        $this->set("locationID",$project['Location_Identifier']);
        $this->set("description",$project['Description']);
        $this->set("kid",$project['kid']);
        $this->set("pName",$proj);


        // Now we go through the list, get any more needed information, and compile results
		$resources = [];
		foreach($server_output as $result) {
            $sid = static::getPageSIDFromProjectName($proj);
            $fields = array("Image_Upload");
            $sort = array();
            $kora = new Advanced_Search($pid, $sid, $fields, 0, 0, $sort);
            if( $result['Type'] == 'Field journal' ) {
                $kora->add_double_clause("Resource_Associator", "=", $result['kid'], // NOT SURE IF THIS SHOULD HAVE THE UNDERSCORE
                    "Scan Number", "=", "1");
            }else {
                $kora->add_clause("Resource_Associator", "=", $result['kid']);
            }
            $page = json_decode($kora->search(), true);

            $picture_url = isset(array_values($page)[0]['Image_Upload']['localName'])?
                     array_values($page)[0]['Image_Upload']['localName'] : null;

            $picture_kid = "";
            if (isset(array_values($page)[0]['kid'])) {
                $picture_kid = array_values($page)[0]['kid'];
            }

            //Decide if there is a picture..
            if( $picture_url != null ){
                $thumb = $this->largeThumb($picture_url, $picture_kid);
            }else{
                $thumb = Router::url('/', true)."img/DefaultResourceImage.svg";
            }
			$tempType = 'Unknown Type';
			if($result['Type']!=''){
				$tempType = $result['Type'];
			}
			$tempTitle = 'Unknown Title';
			if($result['Title']!=''){
				$tempTitle = $result['Title'];
			}

            if (!isset($result['Permissions'])){
                continue;
            }
            $temp_array = ['kid' => $result['kid'], 'Type' => $tempType, 'Title' => $tempTitle,
                           'thumb' => $thumb, "Permissions" => $result['Permissions']];
            $resources[] = $temp_array;
		}

        $usersC = new UsersController();
        $mappings = $this->Mapping->find('list', array(
            'conditions' => array(
                'Mapping.pid' => $pid,
                'Status' => 'confirmed'
            ),
            'fields' => array('id_user')
        ));
        $mappings = array_values($mappings);

		$projectUsers = $this->User->find('list', array(
            'conditions' => array('id' => $mappings, 'status' => 'active'),
            'order' => 'name',
            'fields' => array('username', 'name')
        ));
		$this->set('projectUsers', $projectUsers);


		// get user for permissions filter
        $username = NULL;
        if ($user = $usersC->getUser($this->Auth)) {
            $username = $user['User']['username'];
        }
        // convert the array to resemble a kora response.
        $tmp_array = array();
        foreach ($resources as $resource) {
          $tmp_array[$resource["kid"]] = $resource;
        }
        $resources = $tmp_array;
        // filter resources on user
        // filterByPermission ONLY TAKES A KORA RESPONSE AS PARAM 2
        ResourcesController::filterByPermission($username, $resources);
        //echo json_encode($resources);die;

        $this->set('resources', $resources);

		//create a temporary user since the toolbar was broken on the single_project page.
		//not sure why the actual user isn't being sent to the toolbar on this one page though...
		$tempUser = [];
		$tempUser["loggedIn"] = $this->Session->read('Auth.User.name');
		$tempUser["name"] = $this->Session->read('Auth.User.name');
		$tempUser["username"] = $this->Session->read('Auth.User.username');
		if( $this->Session->read('Auth.User.isAdmin') == 1 ){
			$tempUser["role"] = 'Admin';
		}else{
			$tempUser["role"] = 'Not';
		}

//		$this->set('user', $tempUser);


		$this->loadModel('Collection');
		$user_id =  $this->Session->read('Auth.User.id');
		//echo json_encode($this->Session->read('Auth.User'));

		if( $user_id !== null ) { //signed in
			$collections = $this->Collection->find('all', array(
                'fields' => array('DISTINCT collection_id','public'),
				//'order' => 'Collection.modified DESC',
				'conditions' => array('OR' => array(
					array( 'Collection.public' => '1'),
					array( 'Collection.public' => '2'),
					array( 'Collection.public' => '3'),
					array( 'Collection.user_id' => $user_id)
				), 'Collection.resource_kid LIKE' => "$pid-%"),
				//'group' => 'collection_id',
				'limit' => 10
			));

			//remove all the public 3 collections that the user isn't a part of
			$count = 0;
			foreach( $collections as $collection ){
				$bool_delete = 1;
				if( array_values($collection)[0]['public'] == '3'){
					$members =  explode(';', array_values( $collection)[0]['members'] );
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
                'fields' => array('DISTINCT collection_id'),
                //'order' => 'Collection.modified DESC',
				'conditions' => array('Collection.public' => '1',  //only get public collections
					'Collection.resource_kid LIKE' => "$pid-%"),
				//'group' => 'collection_id',
				'limit' => 10
			));
		}
        $collectionsList = Set::extract($collections, '/Collection/collection_id');
        $collections = array();
        foreach( $collectionsList as $c ) {
            $collectionsTemp = $this->Collection->find('all', array(
                'conditions' => array('collection_id' => $c),
                'order' => 'modified desc',
                'limit' => 1
            ));
            $collections[] = $collectionsTemp[0];
        }
        foreach( $collections as $key => $collection ){
            $collections[$key]['Collection']['timeAgo'] =  parent::time_elapsed_string($collection['Collection']['created']);
        }

        $this->set('collections', $collections);
        $this->render("single_project");
	}
}
