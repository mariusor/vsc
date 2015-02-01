<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::isSecure()
 */
class isSecure extends \PHPUnit_Framework_TestCase
{
	public function testDefaultIsFalse()
	{
		$o = new HttpRequestA_underTest_isSecure();
		$this->assertFalse($o->isSecure());
	}
}
class HttpRequestA_underTest_isSecure extends HttpRequestA {}
