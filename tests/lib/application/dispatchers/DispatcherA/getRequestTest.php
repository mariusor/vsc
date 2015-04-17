<?php
namespace tests\lib\application\dispatchers\DispatcherA;
use vsc\infrastructure\vsc;
use vsc\application\dispatchers\RwDispatcher;

/**
 * @covers \vsc\application\dispatchers\DispatcherA::getRequest()
 */
class getRequest extends \PHPUnit_Framework_TestCase
{
	public function testBasicGetRequest () {
		$o = new RwDispatcher();

		$oRequest = $o->getRequest ();

		$oBlaReq = vsc::getEnv ()->getHttpRequest ();

		$this->assertSame ( $oRequest, $oBlaReq );
	}
}
