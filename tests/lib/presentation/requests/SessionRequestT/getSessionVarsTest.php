<?php
namespace tests\lib\presentation\requests\SessionRequestT;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\SessionRequestT::getSessionVars()
 */
class getSessionVars extends \PHPUnit_Framework_TestCase
{
	public function testGetEmptySession()
	{
		$o = new HttpRequestA_underTest_getSessionVars();
		$this->assertEquals([], $o->getSessionVars());
	}
}
class HttpRequestA_underTest_getSessionVars extends HttpRequestA {}