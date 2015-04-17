<?php
namespace tests\res\infrastructure\vsc;
use vsc\application\dispatchers\DispatcherA;
use vsc\application\dispatchers\RwDispatcher;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::setDispatcher()
 */
class setDispatcher extends \PHPUnit_Framework_TestCase
{
	public function testSetDispatcher () {
		/* @var RwDispatcher $oDispatcher */
		$oDispatcher = new RwDispatcher();

		vsc::getEnv()->setDispatcher($oDispatcher);
		$oSetDispatcher = vsc::getEnv()->getDispatcher();
		$this->assertInstanceOf(DispatcherA::class, $oSetDispatcher);
		$this->assertSame($oDispatcher, $oSetDispatcher);
	}
}
