<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getHttpAcceptEncoding()
 */
class getHttpAcceptEncoding extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new HttpRequestA_underTest_getHttpAcceptEncoding();
		$this->assertEquals([], $o->getHttpAcceptEncoding());
	}
}

class HttpRequestA_underTest_getHttpAcceptEncoding extends HttpRequestA {}
