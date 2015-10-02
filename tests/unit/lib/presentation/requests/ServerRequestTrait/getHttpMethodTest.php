<?php
namespace tests\lib\presentation\requests\ServerRequestTrait;
use mocks\presentation\requests\PopulatedRequest;
use vsc\presentation\requests\HttpRequestTypes;

/**
 * @covers \vsc\presentation\requests\ServerRequestTrait::getHttpMethod()
 */
class getHttpMethod extends \PHPUnit_Framework_TestCase
{
	public function testGetHttpMethod () {
		$o = new PopulatedRequest();

		$o->setHttpMethod(HttpRequestTypes::HEAD);
		$this->assertEquals (HttpRequestTypes::HEAD, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::GET, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::POST, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::PUT, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::DELETE, $o->getHttpMethod());

		$o->setHttpMethod(HttpRequestTypes::GET);
		$this->assertNotEquals (HttpRequestTypes::HEAD, $o->getHttpMethod());
		$this->assertEquals (HttpRequestTypes::GET, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::POST, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::PUT, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::DELETE, $o->getHttpMethod());

		$o->setHttpMethod(HttpRequestTypes::POST);
		$this->assertNotEquals (HttpRequestTypes::HEAD, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::GET, $o->getHttpMethod());
		$this->assertEquals (HttpRequestTypes::POST, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::PUT, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::DELETE, $o->getHttpMethod());

		$o->setHttpMethod(HttpRequestTypes::PUT);
		$this->assertNotEquals (HttpRequestTypes::HEAD, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::GET, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::POST, $o->getHttpMethod());
		$this->assertEquals (HttpRequestTypes::PUT, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::DELETE, $o->getHttpMethod());

		$o->setHttpMethod(HttpRequestTypes::DELETE);
		$this->assertNotEquals (HttpRequestTypes::HEAD, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::GET, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::POST, $o->getHttpMethod());
		$this->assertNotEquals (HttpRequestTypes::PUT, $o->getHttpMethod());
		$this->assertEquals (HttpRequestTypes::DELETE, $o->getHttpMethod());
	}
}
