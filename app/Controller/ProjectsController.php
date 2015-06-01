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
        $this->Auth->allow('display', 'search');
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
		$url = KORA_RESTFUL_URL."?request=GET&pid=22&sid=38&token=a60c6df37bd50ebc998c76ac&display=".urlencode($display);//."query=".urlencode($query);
		///initialize post request to KORA API using curl
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERPWD, $user.':'.$pass);

		///capture results and display
		$server_output = curl_exec($ch);
		$this->set('projects', $server_output);
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
	
	

}
