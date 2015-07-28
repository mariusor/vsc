<?php
namespace tests\lib\presentation\requests\SessionRequest;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\SessionRequest;

/**
 * @covers \vsc\presentation\requests\SessionRequest::getSessionVar()
 */
class getSessionVar extends \PHPUnit_Framework_TestCase
{
	protected function tearDown() {
		@session_destroy();
	}

	protected function startUp() {
		@session_start();
	}

	public function testEmptyAtInitialization()
	{
		$o = new SessionRequest_underTest_getSessionVar();
		$o->getSessionVar('test');
	}

	public function testBasicGetSession()
	{
		$sValue = uniqid();
		$o = new SessionRequest_underTest_getSessionVar();
		$o->setSessionVar('test', $sValue);
		$this->assertEquals($sValue, $o->getSessionVar('test'));
	}
}

class SessionRequest_underTest_getSessionVar {
	use SessionRequest;
}
