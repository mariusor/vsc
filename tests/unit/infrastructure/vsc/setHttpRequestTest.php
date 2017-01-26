<?php
namespace tests\infrastructure\vsc;
use vsc\presentation\requests\RwHttpRequest;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::setHttpRequest()
 */
class setHttpRequest extends \BaseUnitTest
{
	public function testBasicSetHttpRequest()
	{
		$r = new RwHttpRequest();
		$o = new vsc();
		$o->setHttpRequest($r);

		$this->assertSame($r, $o->getHttpRequest());
	}
}
