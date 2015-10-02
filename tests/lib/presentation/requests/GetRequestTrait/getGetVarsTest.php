<?php
namespace tests\lib\presentation\requests\GetRequestTrait;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\GetRequestTrait::getGetVars()
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
