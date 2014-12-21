<?php
namespace tests\res\infrastructure\Null;

/**
 * @covers the public method Null::__toString()
 */
class __toString extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
