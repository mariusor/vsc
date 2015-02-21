<?php
namespace tests\lib\presentation\requests\SessionRequestT;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\SessionRequestT::getSessionVar()
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
		$o = new HttpRequestA_underTest_getSessionVar();
		$o->getSessionVar('test');
	}

	public function testBasicGetSession()
	{
		$sValue = uniqid();
		$_SESSION['test'] = $sValue;
		$o = new HttpRequestA_underTest_getSessionVar();
		$this->assertEquals($sValue, $o->getSessionVar('test'));
	}
}

class HttpRequestA_underTest_getSessionVar extends HttpRequestA {}
