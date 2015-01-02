<?php
namespace tests\lib\application\dispatchers\DispatcherA;
use vsc\infrastructure\vsc;
use vsc\application\dispatchers\RwDispatcher;

/**
 * @covers the public method DispatcherA::getRequest()
 */
class getRequest extends \PHPUnit_Framework_TestCase
{
	public function testBasicGetRequest () {
		$sFixturePath = VSC_FIXTURE_PATH . 'config' . DIRECTORY_SEPARATOR;
		$o = new RwDispatcher();

		$oRequest = $o->getRequest ();

		$oBlaReq = vsc::getEnv ()->getHttpRequest ();

		$this->assertSame ( $oRequest, $oBlaReq );
	}
}
