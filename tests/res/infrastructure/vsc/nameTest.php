<?php
namespace tests\res\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::name()
 */
class name extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
