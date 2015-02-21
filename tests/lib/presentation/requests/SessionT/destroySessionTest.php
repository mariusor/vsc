<?php
namespace tests\lib\presentation\requests\SessionT;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\SessionT::destroySession()
 */
class destroySession extends \PHPUnit_Framework_TestCase
{
	public function testBasicDestroySession()
	{
		$o = new HttpRequestA_underTest_destroySession();
		$this->assertNotEquals('', session_id());
		@HttpRequestA::destroySession();
		$this->assertEquals('', session_id());
		$this->assertEmpty(session_id());
	}
}

class HttpRequestA_underTest_destroySession extends HttpRequestA {
	public function __construct() {
		@session_start();
	}
}
