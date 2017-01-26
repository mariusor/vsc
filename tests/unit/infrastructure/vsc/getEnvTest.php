<?php
namespace tests\infrastructure\vsc;
use vsc\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::getEnv()
 */
class getEnv extends \BaseUnitTest
{
	public function testGetEnv () {
		$this->assertInstanceOf(vsc::class, vsc::getEnv());
	}
}
