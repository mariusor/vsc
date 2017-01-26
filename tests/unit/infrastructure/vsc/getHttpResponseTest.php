<?php
namespace tests\infrastructure\vsc;
use vsc\presentation\responses\HttpResponseA;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::getHttpResponse()
 */
class getHttpResponse extends \BaseUnitTest
{
	public function testBasicGetResponse()
	{
		$o = new vsc();
		$r = $o->getHttpResponse();
		$this->assertInstanceOf(HttpResponseA::class, $r);
	}
}
