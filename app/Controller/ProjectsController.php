
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
 use Lib\Kora\Project;

class ProjectsController extends AppController {
    public $name = 'Projects';


	public function beforeFilter() {

      parent::beforeFilter();
          $this->Auth->allow('display', 'search',"single_project");
  		$this->set(array(
  		'toolbar' => true,
          'footer' => false
  		));

    }
	public function getProjects() {
		$user = "";
		$pass = "";

		$display = "json";
		$query = "";

        $url=KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".PROJECT_SID."&token=".TOKEN."&display=json";
		///initialize post request to KORA API using curl
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);

		///capture results and display
		$server_output = json_decode(curl_exec($ch), true);
		//var_dump($server_output);
		$projects = array();
		foreach($server_output as $item) {
			array_push($projects, $item);
		}
		$this->set('projects', $projects);
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

        $user = "";
		$pass = "";

        $project = new Project($proj);
    
        $server_output = $project->get_recent();
    
        $this->set("name",$project->get_name());
        $this->set("description",$project->get_description());
        //$this->set("recently_added", $project->get_recent());

         //print_r($server_output);//exit();
    
        // Now we go through the list, get any more needed information, and compile results
		$resources = [];
		foreach($server_output as $result) {

            $page = $project->get_page($result['Resource Identifier'], $result['Type']);
    
            $picture_url = isset(array_values($page)[0]['Image Upload']['localName'])?
                     array_values($page)[0]['Image Upload']['localName'] : null;
    
            //Decide if there is a picture..
            if( !empty($picture_url) ){
                $thumb = $this->largeThumb($picture_url);
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

            $temp_array = ['kid' => $result['kid'], 'type' => $tempType, 'title' => $tempTitle, 'thumb' => $thumb];
            $resources[] = $temp_array;
		}
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

		$this->set('user', $tempUser);


		$this->loadModel('Collection');
		$user_id =  $this->Session->read('Auth.User.id');
		//echo json_encode($this->Session->read('Auth.User'));

		if( $user_id !== null ) { //signed in
			$collections = $this->Collection->find('all', array(
				'order' => 'Collection.modified DESC',
				'conditions' => array('OR' => array(
					array( 'Collection.public' => '1'),
					array( 'Collection.public' => '2'),
					array( 'Collection.public' => '3'),
					array( 'Collection.user_id' => $user_id)
				)),
				'group' => 'collection_id',
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
			$this->set('collections', $collections);

		}else { //not signed in
			$collections = $this->Collection->find('all', array(
				'order' => 'Collection.modified DESC',
				'conditions' => array('Collection.public' => '1'), //only get public collections
				'group' => 'collection_id',
				'limit' => 10
			));
			$this->set('collections', $collections);
		}

    $this->render("single_project");

	}

}
