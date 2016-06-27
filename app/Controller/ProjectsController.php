<?php
/**
 * Projects Controller
 * 
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
class ProjectsController extends AppController {
    public $name = 'Projects';
	
	public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('display', 'search', 'single_project');
		$this->set(array(
		'toolbar' => false,
        'footer' => false 
		));
    }
	
	public function getProjects() {
		$user = "";
		$pass = "";

		$display = "json";
		$query = "";
		$url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".PROJECT_SID."&token=".TOKEN."&display=json";
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
	
	public function single_project() {
		$user = "";
		$pass = "";

		$url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".RESOURCE_SID."&token=".TOKEN."&display=json&sort=kid&order=SORT_DESC&count=8";
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
		$server_output = json_decode(curl_exec($ch), true);
		// Now we go through the list, get any more needed information, and compile results
		$resources = [];
		foreach($server_output as $result) {
			$query = "Resource Identifier,=,".$result['Resource Identifier'];
			$url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".PAGES_SID."&token=".TOKEN."&display=json&query=".urlencode($query)."&count=1";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);
			$page = json_decode(curl_exec($ch), true);
			$picture_url = array_values($page)[0]['Image Upload']['localName'];
			//Decide if there is a picture..
			if( !empty($picture_url) ){
				$thumb = $this->largeThumb($picture_url);
			}else{
				$thumb = Router::url('/', true)."img/DefaultResourceImage.svg";
			}
			$temp_array = ['kid' => $result['kid'], 'type' => $result['Type'], 'title' => $result['Title'], 'thumb' => $thumb];
			$resources[] = $temp_array;
		}
		$this->set('resources', $resources);

		// Need collections, but those may not be in kora...

		$query = "Persistent Name,=,".$this->request->params['pass'][0];
		
		$url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".PROJECT_SID."&token=".TOKEN."&display=json&query=".urlencode($query);

		// Debug string w/o query.
		//$url = KORA_RESTFUL_URL."?request=GET&pid=".PID."&sid=".PROJECT_SID."&token=".TOKEN."&display=json";
		
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
		$this->set('project', $projects[0]);
	}
	
	

}
