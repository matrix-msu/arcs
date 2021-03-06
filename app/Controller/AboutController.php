<?php
/**
 * Help Controller
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
class AboutController extends AppController {

	public $name = 'About';

    public function beforeFilter() {
        header("Location: ".ARCS_PROMO_URL);
        die;
//        parent::beforeFilter();
//        $this->Auth->allow('index');
//        $sidebar = file_get_contents(ROOT . DS . 'docs' . DS . 'sidebar.json');
//        $this->set('sidebar', json_decode($sidebar, true));
//        $this->layout = 'doc';
    }
    /**
     * Displays a help document
     *
     * @param doc
     * @return void
     */
	public function display($doc) {
        $this->set(array(
            'title_for_layout' => $doc == 'index' ?
            'Getting Started' : Inflector::humanize($doc),
            'active' => $doc == 'index' ? '' : $doc
        ));
		$this->render($doc);
	}
	public function index(){
        header('Location: '.ARCS_PROMO_URL);
	    die;
    }
}
