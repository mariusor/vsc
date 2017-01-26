<?php
namespace tests\infrastructure\vsc;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::isCli()
 */
class isCli extends \BaseUnitTest
{
	public function testBasicIsCli()
	{
		vsc::setInstance(new vsc());
		$this->assertTrue(vsc::getEnv()->isCli());
	}
}
