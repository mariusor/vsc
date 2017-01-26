<?php
namespace tests\infrastructure\vsc;
use vsc\application\dispatchers\DispatcherA;
use vsc\application\dispatchers\RwDispatcher;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::getDispatcher()
 */
class getDispatcher extends \BaseUnitTest
{
	public function testGetDispatcher ()
	{
		/* @var RwDispatcher $oDispatcher */
		$oDispatcher = vsc::getEnv()->getDispatcher();
		$this->assertInstanceOf(DispatcherA::class, $oDispatcher);
	}

}
