<?php
namespace tests\lib\presentation\requests\SessionRequestT;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\SessionRequestT::setSessionVar()
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
		$o = new HttpRequestA_underTest_setSessionVar();
		$o->setSessionVar('test', $sValue);
		$this->assertEquals($sValue, $_SESSION['test']);
	}
}

class HttpRequestA_underTest_setSessionVar extends HttpRequestA {}
