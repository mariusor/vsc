<?php
namespace tests\res\infrastructure\vsc;

/**
 * @covers the protected method vsc::_isCli()
 */
class _isCli extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
