<?php

App::uses('Controller', 'Controller');
App::uses('View', 'View');
App::uses('ProgressHelper', 'View/Helper');

use PHPUnit\Framework\TestCase;
class SearchControllerTest extends ControllerTestCase{
	private $control;
	public function setUp() {
    	    parent::setUp();
	    $Controller = new Controller();
	    $View = new View($Controller);
	}	
	public function testSearchPageRender(){
		$data = array(
			"Post" => array(

			)
		);
		$this->testAction("/posts/add",array('data' => $data , 'method'=>'get'));
	}
	public function testSimpleSearchFunction(){
		
	}
	public function testAdvancedSearchFunction(){
	
	
	}
}
