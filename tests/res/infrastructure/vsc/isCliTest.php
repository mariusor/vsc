<?php
namespace tests\res\infrastructure\vsc;

/**
 * @covers the public method vsc::isCli()
 */
class isCli extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
