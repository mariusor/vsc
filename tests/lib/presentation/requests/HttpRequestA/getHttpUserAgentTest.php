<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getHttpUserAgent()
 */
class getHttpUserAgent extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new HttpRequestA_underTest_getHttpUserAgent();
		$this->assertEquals('', $o->getHttpUserAgent());
	}
}

class HttpRequestA_underTest_getHttpUserAgent extends HttpRequestA {}
