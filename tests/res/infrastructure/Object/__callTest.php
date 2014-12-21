<?php
namespace tests\res\infrastructure\Object;

/**
 * @covers the public method Object::__call()
 */
class __call extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
