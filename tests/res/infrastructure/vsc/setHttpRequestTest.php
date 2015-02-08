<?php
namespace tests\res\infrastructure\vsc;
use vsc\presentation\requests\RwHttpRequest;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::setHttpRequest()
 */
class setHttpRequest extends \PHPUnit_Framework_TestCase
{
	public function testBasicSetHttpRequest()
	{
		$r = new RwHttpRequest();
		$o = new vsc();
		$o->setHttpRequest($r);

		$this->assertSame($r, $o->getHttpRequest());
	}
}
