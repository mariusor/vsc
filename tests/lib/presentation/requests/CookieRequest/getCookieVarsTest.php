<?php
namespace tests\lib\presentation\requests\CookieRequest;
use vsc\presentation\requests\CookieRequest;

/**
 * @covers \vsc\presentation\requests\CookieRequest::getCookieVars()
 */
class getCookieVars extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialize()
	{
		$_COOKIE = [];
		$o = new CookieRequest_underTest_getCookieVars();
		$o->initCookie($_COOKIE);
		$this->assertEquals($_COOKIE, $o->getCookieVars());
	}

	public function testInitializeWithMockedCookie()
	{
		$o = new CookieRequest_underTest_getCookieVars();
		$o->initCookie($_COOKIE);
		$this->assertEquals($_COOKIE, $o->getCookieVars());
	}
}

class CookieRequest_underTest_getCookieVars {
	use CookieRequest {initCookie as public;}
}
