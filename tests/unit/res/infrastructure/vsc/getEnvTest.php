<?php
namespace tests\res\infrastructure\vsc;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::getEnv()
 */
class getEnv extends \PHPUnit_Framework_TestCase
{
	public function testGetEnv () {
		$this->assertInstanceOf(vsc::class, vsc::getEnv());
	}
}
