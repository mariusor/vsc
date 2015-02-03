<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getHttpAcceptCharset()
 */
class getHttpAcceptCharset extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new HttpRequestA_underTest_getHttpAcceptCharset();
		$this->assertEquals([], $o->getHttpAcceptCharset());
	}
}

class HttpRequestA_underTest_getHttpAcceptCharset extends HttpRequestA {}
