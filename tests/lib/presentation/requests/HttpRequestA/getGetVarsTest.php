<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getGetVars()
 */
class getGetVars extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$_GET = [];
		$o = new HttpRequestA_underTest_getGetVars();
		$this->assertEquals([], $o->getGetVars());
	}
}

class HttpRequestA_underTest_getGetVars extends HttpRequestA {}
