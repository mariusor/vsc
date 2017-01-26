<?php
namespace tests\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::isSecure()
 */
class isSecure extends \BaseUnitTest
{
	public function testDefaultIsFalse()
	{
		$o = new HttpRequestA_underTest_isSecure();
		$this->assertFalse($o->isSecure());
	}
}
class HttpRequestA_underTest_isSecure extends HttpRequestA {}
