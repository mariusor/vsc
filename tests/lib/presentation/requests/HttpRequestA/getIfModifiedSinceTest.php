<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getIfModifiedSince()
 */
class getIfModifiedSince extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new HttpRequestA_underTest_getIfModifiedSince();
		$this->assertEquals('', $o->getIfModifiedSince());
	}
}

class HttpRequestA_underTest_getIfModifiedSince extends HttpRequestA {}
