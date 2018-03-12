<?php
/**
 * Installation Controller
 *
 * @package    ARCS
 * @link       http://github.com/calmsu/arcs
 * @copyright  Copyright 2012, Michigan State University Board of Trustees
 * @license    BSD License (http://www.opensource.org/licenses/bsd-license.php)
 */
class InstallationsController extends AppController {
	public $name = 'Installations';

	public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('display');
    }


	public function register() {
	          $this->set(array(
	            'title_for_layout' => 'index'
	        ));
	        $this->render("register");
	    }


    /**
     * Displays the start installation page
     */
	public function display() {
	  	$this->set(array(
	    	'title_for_layout' => 'Install ARCS'
	    ));
		$this->render("index");
	}


	/**
	 * Displays the Kora Configuration page
	 */
	public function koraConfig() {
		$this->set(array(
			'title_for_layout' => 'Install ARCS'
		));
		$this->render("kora_config");
	}

}
