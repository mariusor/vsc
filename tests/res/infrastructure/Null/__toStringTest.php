<?php
namespace tests\res\infrastructure\Null;

/**
 * @covers \vsc\infrastructure\Null::__toString()
 */
class __toString extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
