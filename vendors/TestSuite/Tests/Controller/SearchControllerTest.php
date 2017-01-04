<?php

App::uses('Controller', 'Controller');
App::uses('View', 'View');
App::uses('ProgressHelper', 'View/Helper');

use PHPUnit\Framework\TestCase;
class SearchControllerTest extends ControllerTestCase{
	public function setUp() {
    	  
	}	
	public function testSearchPageRender(){
		$page = getRequest("/");
		$this->assertTrue(hasNoErrors($page),"Error found on page");
	
	}
	public function testSingleProjectSearchRequest(){
		//searching 1974
		$json = getRequest("/simple_search/7B-2DE-0/1974/1/20");
		$decoded = json_decode($json);

		//test for results
		$this->assertFalse($decoded == NULL, "Json response is NULL");

	
		$this->assertTrue( isset($decoded->total) , "missing 'total' attribute" );
		$this->assertTrue( isset($decoded->time) , "missing 'time' attribute" );
		$this->assertTrue( isset($decoded->Memory) , "missing 'memory' attribute" );
		$this->assertTrue( isset($decoded->filters) , "missing 'filters' attribute" );
		$this->assertTrue( isset($decoded->results) , "missing 'results' attribute" );
	}
	public function testAllProjectSearchRequest(){
		//searching 1974 on All projects
		$json = getRequest("/simple_search/all/1974/1/20");
		$decoded = json_decode($json);

		//test for results
		$this->assertFalse($decoded == NULL, "Json response is NULL");

	
		$this->assertTrue( isset($decoded->total) , "missing 'total' attribute" );
		$this->assertTrue( isset($decoded->time) , "missing 'time' attribute" );
		$this->assertTrue( isset($decoded->Memory) , "missing 'memory' attribute" );
		$this->assertTrue( isset($decoded->filters) , "missing 'filters' attribute" );
		$this->assertTrue( isset($decoded->results) , "missing 'results' attribute" );	
	}
}
