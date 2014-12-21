<?php
namespace tests\res\infrastructure\Null;

/**
 * @covers the public method Null::__call()
 */
class __call extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
