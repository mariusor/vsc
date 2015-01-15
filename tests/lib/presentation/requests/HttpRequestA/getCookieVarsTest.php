<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getCookieVars()
 */
class getCookieVars extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialize()
	{
		$_COOKIE = [];
		$o = new HttpRequestA_underTest_getCookieVars();
		$this->assertEquals($_COOKIE, $o->getCookieVars());
	}

	public function testInitializeWithMockedCookie()
	{
		$o = new HttpRequestA_underTest_getCookieVars();
		$this->assertEquals($_COOKIE, $o->getCookieVars());
	}
}

class HttpRequestA_underTest_getCookieVars extends HttpRequestA {}
