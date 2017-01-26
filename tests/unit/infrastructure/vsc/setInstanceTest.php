<?php
namespace tests\infrastructure\vsc;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::setInstance()
 */
class setInstance extends \BaseUnitTest
{
	public function testBasicSetInstance () {
		vsc::setInstance(new vsc_underTest_setInstance());
		$this->assertInstanceOf(vsc_underTest_setInstance::class, vsc::getEnv());
		$this->assertInstanceOf(vsc::class, vsc::getEnv());
	}

}
class vsc_underTest_setInstance extends vsc {}
