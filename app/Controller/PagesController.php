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
				$pName = array_pop($path);
				echo "<script>globalproject=\"$pName\"</script>";
				$this->set("pName", $pName);
				$count = count($path);
				try {
					static::verifyGlobals($pName);
				} catch (Exception $e) {
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

        if( isset($pName) ) {
            $pid = parent::getPIDFromProjectName($pName);
            $sid = parent::getResourceSIDFromProjectName($pName);
            $types = parent::getK3Controls($pid, $sid, array('Type'), 'Resource');
            $this->set("pid", $pid);
            $this->set("sid", $sid);
            $this->set("types", $types);
        }

		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}
}
