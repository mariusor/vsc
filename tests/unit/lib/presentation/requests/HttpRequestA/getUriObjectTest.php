<?php
namespace tests\lib\presentation\requests\HttpRequestA;
use vsc\infrastructure\urls\Url;
use vsc\presentation\requests\HttpRequestA;

/**
 * @covers \vsc\presentation\requests\HttpRequestA::getUriObject()
 */
class getUriObject extends \BaseUnitTest
{
	public function testBasicGetUriObject()
	{
		$o = new HttpRequestA_underTest_getUriObject();
		$this->assertInstanceOf(Url::class, $o->getUriObject());
	}
}
class HttpRequestA_underTest_getUriObject extends HttpRequestA {}
