<?php
namespace tests\lib\presentation\requests\CookieRequestTrait;
use vsc\presentation\requests\CookieRequestTrait;

/**
 * @covers \vsc\presentation\requests\CookieRequestTrait::getCookieVar()
 */
class getCookieVar extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialize()
	{
		$_COOKIE = [];
		$o = new CookieRequest_underTest_getCookieVar();
		$o->initCookie($_COOKIE);
		$this->assertEmpty($o->getCookieVar('test'));
	}

	public function testInitializeWithMock_COOKIE()
	{
		$o = new CookieRequest_underTest_getCookieVar();
		$o->initCookie($_COOKIE);
		$this->assertEquals($_COOKIE['user'], $o->getCookieVar('user'));
	}
}

class CookieRequest_underTest_getCookieVar {
	use CookieRequestTrait {initCookie as public; getCookieVar as public;}
}
