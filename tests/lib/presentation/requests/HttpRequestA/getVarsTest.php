<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getVars()
 */
class getVars extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$_GET = [];
		$_POST = [];
		$_COOKIE = [];
		$_SESSION = [];
		$_REQUEST = [];

		$o = new HttpRequestA_underTest_getVars();
		$this->assertEquals([], $o->getVars());
	}
}

class HttpRequestA_underTest_getVars extends HttpRequestA {
}
