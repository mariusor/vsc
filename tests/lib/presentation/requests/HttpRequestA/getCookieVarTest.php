<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getCookieVar()
 */
class getCookieVar extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialize()
	{
		$_COOKIE = [];
		$o = new HttpRequestA_underTest_getCookieVar();
		$this->assertEmpty($o->getCookieVar('test'));
	}

	public function testInitializeWithMock_COOKIE()
	{
		$o = new HttpRequestA_underTest_getCookieVar();
		$this->assertEquals($_COOKIE['user'], $o->getCookieVar('user'));
	}
}

class HttpRequestA_underTest_getCookieVar extends HttpRequestA {
	public function getCookieVar ($key) {
		return parent::getCookieVar($key);
	}
}
