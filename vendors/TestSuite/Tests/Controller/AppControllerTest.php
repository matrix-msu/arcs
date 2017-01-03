<?php

App::uses('Controller', 'Controller');
App::uses('View', 'View');
App::uses('ProgressHelper', 'View/Helper');

use PHPUnit\Framework\TestCase;
class AppControllerTest extends ControllerTestCase{
	public function setUp() {
    	    parent::setUp();
	    $Controller = new Controller();
	    $View = new View($Controller);
	}	
	public function testInitialization(){

	   
	}
	public function testSmallThumbFunction(){
		
	
	}

}
