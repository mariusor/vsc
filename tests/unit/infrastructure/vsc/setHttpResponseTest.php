<?php
namespace tests\infrastructure\vsc;
use vsc\infrastructure\vsc;
use vsc\presentation\responses\HttpResponse;

/**
 * @covers \vsc\infrastructure\vsc::setHttpResponse()
 */
class setHttpResponse extends \BaseUnitTest
{
	public function testBasicSetHttpResponse()
	{
		$r = new HttpResponse();
		$o = new vsc();
		$o->setHttpResponse($r);

		$this->assertSame($r, $o->getHttpResponse());
	}
}
