<?php
namespace tests\res\infrastructure\vsc;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::isCli()
 */
class isCli extends \PHPUnit_Framework_TestCase
{
	public function testBasicIsCli()
	{
		vsc::setInstance(new vsc());
		$this->assertTrue(vsc::getEnv()->isCli());
	}
}
