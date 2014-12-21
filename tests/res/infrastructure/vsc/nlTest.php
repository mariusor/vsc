<?php
namespace tests\res\infrastructure\vsc;

/**
 * @covers the public method vsc::nl()
 */
class nl extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
