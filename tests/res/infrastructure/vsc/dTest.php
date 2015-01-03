<?php
namespace tests\res\infrastructure\vsc;

/**
 * @covers \vsc\infrastructure\vsc::d()
 */
class d extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
