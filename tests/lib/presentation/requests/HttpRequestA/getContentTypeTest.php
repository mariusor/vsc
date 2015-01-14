<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getContentType()
 */
class getContentType extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialize()
	{
		$_COOKIE = [];
		$o = new HttpRequestA_underTest_getContentType();
		$this->assertEmpty($o->getContentType());
	}
}

class HttpRequestA_underTest_getContentType extends HttpRequestA {}
