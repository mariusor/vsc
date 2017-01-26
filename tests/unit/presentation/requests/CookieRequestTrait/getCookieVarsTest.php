<?php
namespace tests\presentation\requests\CookieRequestTrait;
use vsc\presentation\requests\CookieRequestTrait;

/**
 * @covers \vsc\presentation\requests\CookieRequestTrait::getCookieVars()
 */
class getCookieVars extends \BaseUnitTest
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
	use CookieRequestTrait {initCookie as public;}
}
