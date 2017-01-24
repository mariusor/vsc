<?php
namespace tests\lib\presentation\requests\SessionRequestTrait;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\SessionRequestTrait;

/**
 * @covers \vsc\presentation\requests\SessionRequestTrait::setSessionVar()
 */
class setSessionVar extends \BaseUnitTest
{
	protected function tearDown() {
		@session_destroy();
	}

	protected function startUp() {
		@session_start();
	}

	public function testBasicSetSession()
	{
		$sValue = uniqid();
		$o = new SessionRequest_underTest_setSessionVar();
		$o->setSessionVar('test', $sValue);
		$this->assertEquals($sValue, $_SESSION['test']);
	}
}

class SessionRequest_underTest_setSessionVar {
	use SessionRequestTrait;
}
