<?php
/**
 * Pages Controller
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
require_once(KORA_LIB . "General_Search.php");

class PagesController extends AppController {

	public $name = 'Pages';

	public $uses = array();

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('display', 'search');
		//todo- set a page not found error if the kid is bad.
    }

    /**
     * Displays a view
     *
     * @param mixed What page to display
     * @return void
     */
	public function display() {

		$path = func_get_args();
		//print_r($path);
		//exit();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
			//using this as a resources page before filter.
			if($page == 'resources'){
				if(empty($path[1])){
					$this->redirect('/');
				}
				$pKid = array_pop($path);
				$count = count($path);
				//make sure it is a real project
				$fields = array('Name');
				$kora = new General_Search(PROJECT_SID, "kid", "=", $pKid, $fields);
				$project = json_decode($kora->return_json(), true);

				if(empty($project)){    //not a real project to redirect.
					$this->redirect('/');
				}
			}
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
