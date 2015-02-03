<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\infrastructure\urls\UrlParserA;
use vsc\infrastructure\urls\UrlRWParser;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getUriObject()
 */
class getUriObject extends \PHPUnit_Framework_TestCase
{
	public function testBasicGetUriObject()
	{
		$o = new HttpRequestA_underTest_getUriObject();
		$this->assertInstanceOf(UrlParserA::class, $o->getUriObject());
	}
}
class HttpRequestA_underTest_getUriObject extends HttpRequestA {}
