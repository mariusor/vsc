<?php
namespace tests\res\infrastructure\vsc;
use vsc\application\dispatchers\RwDispatcher;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::getDispatcher()
 */
class getDispatcher extends \PHPUnit_Framework_TestCase
{
	public function testGetDispatcher ()
	{
		/* @var RwDispatcher $oDispatcher */
		$oDispatcher = vsc::getEnv()->getDispatcher();
		$this->assertInstanceOf(\vsc\application\dispatchers\DispatcherA::class, $oDispatcher);
	}

}
