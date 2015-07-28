<?php
namespace tests\lib\presentation\requests\SessionRequest;
use vsc\presentation\requests\HttpRequestA;
use vsc\presentation\requests\SessionRequest;

/**
 * @covers \vsc\presentation\requests\SessionRequest::setSessionVar()
 */
class setSessionVar extends \PHPUnit_Framework_TestCase
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
	use SessionRequest;
}
