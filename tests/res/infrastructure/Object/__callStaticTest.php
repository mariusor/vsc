<?php
namespace tests\res\infrastructure\Object;

/**
 * @covers \vsc\infrastructure\Object::__callStatic()
 */
class __callStatic extends \PHPUnit_Framework_TestCase
{
	public function testIncomplete()
	{
		$this->markTestIncomplete(" ... ");
	}
}
