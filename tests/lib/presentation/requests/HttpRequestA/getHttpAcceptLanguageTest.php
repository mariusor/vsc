<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getHttpAcceptLanguage()
 */
class getHttpAcceptLanguage extends \PHPUnit_Framework_TestCase
{
	public function testEmptyAtInitialization()
	{
		$o = new HttpRequestA_underTest_getHttpAcceptLanguage();
		$this->assertEquals([], $o->getHttpAcceptLanguage());
	}
}

class HttpRequestA_underTest_getHttpAcceptLanguage extends HttpRequestA {}
