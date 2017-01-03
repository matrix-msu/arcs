<?php

App::uses('Controller', 'Controller');
App::uses('View', 'View');
App::uses('ProgressHelper', 'View/Helper');

//PHP UNIT framework
use PHPUnit\Framework\TestCase;

//make a class with orinalname with "Test" on the end
class DummyClassTest extends TestCase{

	private $var = "stringComp";
	//setup runs before any functions
	public function setUp() {
    	   
	}	
	/*
	 * function names should have "test" in front
	 * 
	 */	
	public function testDemo(){
		$testVar = $this->var;
		$this->assertEquals($testVar, "stringComp");

		$int1 = 20;

		$this->assertTrue($int1 == 21,
			"Assert Failed: int1 not == 21");
	   
	}


}
/*
 *
 assertArrayHasKey()
 assertClassHasAttribute()
 assertArraySubset()
 assertClassHasStaticAttribute()
 assertContains()
 assertContainsOnly()
 assertContainsOnlyInstancesOf()
 assertCount()
 assertDirectoryExists()
 assertDirectoryIsReadable()
 assertDirectoryIsWritable()
 assertEmpty()
 assertEqualXMLStructure()
 assertEquals()
 assertFalse()
 assertFileEquals()
 assertFileExists()
 assertFileIsReadable()
 assertFileIsWritable()
 assertGreaterThan()
 assertGreaterThanOrEqual()
 assertInfinite()
 assertInstanceOf()
 assertInternalType()
 assertIsReadable()
 assertIsWritable()
 assertJsonFileEqualsJsonFile()
 assertJsonStringEqualsJsonFile()
 assertJsonStringEqualsJsonString()
 assertLessThan()
 assertLessThanOrEqual()
 assertNan()
 assertNull()
 assertObjectHasAttribute()
 assertRegExp()
 assertStringMatchesFormat()
 assertStringMatchesFormatFile()
 assertSame()
 assertStringEndsWith()
 assertStringEqualsFile()
 assertStringStartsWith()
 assertThat()
 assertTrue()
 assertXmlFileEqualsXmlFile()
 assertXmlStringEqualsXmlFile()
assertXmlStringEqualsXmlString() 
 *
 *
 *
 */
