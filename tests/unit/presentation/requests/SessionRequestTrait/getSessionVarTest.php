<?php
namespace tests\presentation\requests\SessionRequestTrait;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\SessionRequestTrait;

/**
 * @covers \vsc\presentation\requests\SessionRequestTrait::getSessionVar()
 */
class getSessionVar extends \BaseUnitTest
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
	use SessionRequestTrait;
}
