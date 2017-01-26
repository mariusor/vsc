<?php
namespace tests\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getVars()
 */
class getVars extends \BaseUnitTest
{
	public function testWithEmptyRequest()
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
